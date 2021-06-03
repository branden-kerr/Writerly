<?php

namespace FluentFormPro\Payments;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Databases\Migrations\FormSubmissions;
use FluentForm\App\Helpers\Helper;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentFormPro\Payments\Classes\CouponModel;
use FluentFormPro\Payments\Migrations\Migration;
use FluentFormPro\Payments\PaymentMethods\Offline\OfflineProcessor;

class AjaxEndpoints
{
    public function handleEndpoint($route)
    {
        $validRoutes = [
            'enable_payment'               => 'enablePaymentModule',
            'update_global_settings'       => 'updateGlobalSettings',
            'get_payment_method_settings'  => 'getPaymentMethodSettings',
            'save_payment_method_settings' => 'savePaymentMethodSettings',
            'get_form_settings'            => 'getFormSettings',
            'save_form_settings'           => 'saveFormSettings',
            'update_transaction'           => 'updateTransaction',
            'get_coupons'                  => 'getCoupons',
            'enable_coupons'               => 'enableCoupons',
            'save_coupon'                  => 'saveCoupon',
            'delete_coupon' => 'deleteCoupon'
        ];

        if (isset($validRoutes[$route])) {
            $this->{$validRoutes[$route]}();
        }

        die();
    }

    public function enablePaymentModule()
    {
        $this->upgradeDb();
        // Update settings
        $settings = PaymentHelper::updatePaymentSettings([
            'status' => 'yes'
        ]);
        // send response to reload the page

        wp_send_json_success([
            'message'  => __('Payment Module successfully enabled!', 'fluentformpro'),
            'settings' => $settings,
            'reload'   => 'yes'
        ]);
    }

    private function upgradeDB()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'fluentform_transactions';
        $cols = $wpdb->get_col("DESC {$table}", 0);

        if ($cols && in_array('subscription_id', $cols) && in_array('transaction_hash', $cols)) {
            // We are good
        } else {
            $wpdb->query("DROP TABLE IF EXISTS {$table}");
            Migration::migrate();
            // Migrate the database
            FormSubmissions::migrate(true); // Add payment_total
        }
    }

    public function updateGlobalSettings()
    {
        $settings = wp_unslash($_REQUEST['settings']);

        // Update settings
        $settings = PaymentHelper::updatePaymentSettings($settings);

        // send response to reload the page
        wp_send_json_success([
            'message'  => __('Settings successfully updated!', 'fluentformpro'),
            'settings' => $settings,
            'reload'   => 'yes'
        ]);

    }

    public function getPaymentMethodSettings()
    {
        $method = sanitize_text_field($_REQUEST['method']);
        $settings = apply_filters('fluentform_payment_settings_' . $method, []);

        wp_send_json_success([
            'settings' => ($settings) ? $settings : false
        ]);
    }

    public function savePaymentMethodSettings()
    {
        $method = sanitize_text_field($_REQUEST['method']);
        $settings = wp_unslash($_REQUEST['settings']);

        $validationErrors = apply_filters('payment_method_settings_validation_' . $method, [], $settings);

        if ($validationErrors) {
            wp_send_json_error([
                'message' => __('Failed to save settings', 'fluentformpro'),
                'errors'  => $validationErrors
            ], 423);
        }

        update_option('fluentform_payment_settings_' . $method, $settings, 'yes');

        wp_send_json_success([
            'message' => __('Settings successfully updated', 'fluentformpro')
        ]);
    }

    public function getFormSettings()
    {
        $formId = intval($_REQUEST['form_id']);
        $settings = PaymentHelper::getFormSettings($formId, 'admin');
        wp_send_json_success([
            'settings'        => $settings,
            'currencies'      => PaymentHelper::getCurrencies(),
            'payment_methods' => PaymentHelper::getFormPaymentMethods($formId)
        ], 200);
    }

    public function saveFormSettings()
    {
        $formId = intval($_REQUEST['form_id']);
        $settings = wp_unslash($_REQUEST['settings']);
        Helper::setFormMeta($formId, '_payment_settings', $settings);

        wp_send_json_success([
            'message' => __('Settings successfully saved', 'fluentformpro')
        ], 200);
    }

    public function updateTransaction()
    {
        $transactionData = $_REQUEST['transaction'];
        $transactionId = intval($transactionData['id']);
        $oldTransaction = wpFluent()->table('fluentform_transactions')
            ->find($transactionId);

        $changingStatus = $oldTransaction->status != $transactionData['status'];

        $updateData = ArrayHelper::only($transactionData, [
            'payer_name',
            'payer_email',
            'billing_address',
            'charge_id',
            'status'
        ]);

        $updateData['updated_at'] = current_time('mysql');

        wpFluent()->table('fluentform_transactions')
            ->where('id', $transactionId)
            ->update($updateData);

        $newStatus = $transactionData['status'];
        if (
            ($changingStatus && ($newStatus == 'refunded' || $newStatus == 'partial-refunded')) ||
            ($newStatus == 'partial-refunded' && ArrayHelper::get($transactionData, 'refund_amount'))
        ) {
            $refundAmount = 0;
            $refundNote = 'Refunded by Admin';

            if ($newStatus == 'refunded') {
                // Handle refund here
                $refundAmount = $oldTransaction->payment_total;
            } else if ($newStatus == 'partially-refunded') {
                $refundAmount = ArrayHelper::get($transactionData, 'refund_amount') * 100;
                $refundNote = ArrayHelper::get($transactionData, 'refund_note');
            }

            if ($refundAmount) {
                $offlineProcessor = new OfflineProcessor();
                $offlineProcessor->setSubmissionId($oldTransaction->submission_id);

                $submission = $offlineProcessor->getSubmission();
                $offlineProcessor->refund($refundAmount, $oldTransaction, $submission, $oldTransaction->payment_method, 'refund_' . time(), $refundNote);
            }

        }

        if ($changingStatus) {

            if ($newStatus == 'paid' || $newStatus == 'pending' || $newStatus == 'processing') {
                // Delete All Refunds
                wpFluent()->table('fluentform_transactions')
                    ->where('submission_id', $oldTransaction->submission_id)
                    ->where('transaction_type', 'refund')
                    ->delete();
            }

            $offlineProcessor = new OfflineProcessor();
            $offlineProcessor->setSubmissionId($oldTransaction->submission_id);
            $offlineProcessor->changeSubmissionPaymentStatus($newStatus);
            $offlineProcessor->changeTransactionStatus($transactionId, $newStatus);
        }

        wp_send_json_success([
            'message' => 'Successfully updated data'
        ], 200);
    }

    public function getCoupons()
    {
        $status = get_option('fluentform_coupon_status');
        if ($status != 'yes') {
            wp_send_json([
                'coupon_status' => false
            ], 200);
        }

        $couponModel = new CouponModel();

        $coupons = $couponModel->getCoupons(true);

        $data = [
            'coupon_status' => 'yes',
            'coupons'       => $coupons
        ];

        if (isset($_REQUEST['page']) && $_REQUEST['page'] == 1) {
            $forms = wpFluent()->table('fluentform_forms')
                ->select(['id', 'title'])
                ->where('has_payment', 1)
                ->get();
            $formattedForms = [];
            foreach ($forms as $form) {
                $formattedForms[$form->id] = $form->title;
            }
            $data['available_forms'] = $formattedForms;
        }

        wp_send_json($data, 200);
    }

    public function enableCoupons()
    {
        (new CouponModel())->migrate();
        update_option('fluentform_coupon_status', 'yes', 'no');
        wp_send_json([
            'coupon_status' => 'yes'
        ], 200);
    }

    public function saveCoupon()
    {
        $coupon = wp_unslash($_REQUEST['coupon']);

        $validator = fluentValidator($coupon, [
            'title' => 'required',
            'code' => 'required',
            'amount' => 'required',
            'coupon_type' => 'required',
            'status' => 'required'
        ]);

        if ($validator->validate()->fails()) {
            $errors = $validator->errors();
            wp_send_json([
                'errors' => $errors,
                'message' => 'Please fill up all the required fields'
            ], 423);
        }

        $couponId = false;

        if(isset($coupon['id'])) {
            $couponId = $coupon['id'];
            unset($coupon['id']);
        }

        if($exist = (new CouponModel())->isCouponCodeAvailable($coupon['code'], $couponId)) {
            wp_send_json([
                'errors' => [
                    'code' => [
                        'exist' => 'Same coupon code is already exists'
                    ]
                ],
                'message' => 'Same coupon code is already exists'
            ], 423);
        }

        if($couponId) {
            (new CouponModel())->update($couponId,$coupon);
        } else {
            $couponId = (new CouponModel())->insert($coupon);
        }

        wp_send_json([
            'message' => __('Coupon has been created successfully', 'fluentformpro'),
            'coupon_id' => $couponId
        ], 200);

    }

    public function deleteCoupon()
    {
        $couponId = intval($_REQUEST['coupon_id']);
        (new CouponModel())->delete($couponId);
        wp_send_json([
            'message' => __('Coupon has been successfully deleted', 'fluentformpro'),
            'coupon_id' => $couponId
        ], 200);
    }

}