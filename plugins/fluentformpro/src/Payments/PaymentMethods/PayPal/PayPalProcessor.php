<?php

namespace FluentFormPro\Payments\PaymentMethods\PayPal;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\Framework\Helpers\ArrayHelper;
use FluentFormPro\Payments\PaymentHelper;
use FluentFormPro\Payments\PaymentMethods\BaseProcessor;
use FluentFormPro\Payments\PaymentMethods\PayPal\API\IPN;

class PayPalProcessor extends BaseProcessor
{
    public $method = 'paypal';

    protected $form;

    public function init()
    {
        add_action('fluentform_process_payment_' . $this->method, array($this, 'handlePaymentAction'), 10, 4);
        add_action('fluent_payment_frameless_' . $this->method, array($this, 'handleSessionRedirectBack'));

        add_action('fluentform_ipn_endpint_' . $this->method, function () {
            (new IPN())->verifyIPN();
            exit(200);
        });

        add_action('fluentform_ipn_paypal_action_web_accept', array($this, 'handleWebAcceptPayment'), 10, 3);

    }

    public function handlePaymentAction($submissionId, $submissionData, $form, $methodSettings)
    {
        $this->setSubmissionId($submissionId);
        $this->form = $form;
        $submission = $this->getSubmission();

        $uniqueHash = md5($submission->id . '-' . $form->id . '-' . time() . '-' . mt_rand(100, 999));

        $transactionId = $this->insertTransaction([
            'transaction_type' => 'onetime',
            'transaction_hash' => $uniqueHash,
            'payment_total'    => $this->getAmountTotal(),
            'status'           => 'pending',
            'currency'         => PaymentHelper::getFormCurrency($form->id),
            'payment_mode'     => $this->getPaymentMode()
        ]);

        $transaction = $this->getTransaction($transactionId);

        $this->handlePayPalRedirect($transaction, $submission, $form, $methodSettings);
    }

    public function handlePayPalRedirect($transaction, $submission, $form, $methodSettings)
    {
        $paymentSettings = PaymentHelper::getPaymentSettings();

        $customerEmail = '';
        if ($submission->user_id) {
            $user = get_user_by('ID', $submission->user_id);
            $customerEmail = $user->user_email;
        }

        $successUrl = add_query_arg(array(
            'fluentform_payment' => $submission->id,
            'payment_method'     => $this->method,
            'transaction_hash'   => $transaction->transaction_hash,
            'type'               => 'success'
        ), site_url('/'));


        $cancelUrl = $submission->source_url;

        if (!wp_http_validate_url($cancelUrl)) {
            $cancelUrl = home_url($cancelUrl);
        }

        $listener_url = add_query_arg(array(
            'fluentform_payment_api_notify' => 1,
            'payment_method'                => $this->method,
            'submission_id'                 => $submission->id,
            'transaction_hash'              => $transaction->transaction_hash,
        ), home_url('index.php')); //

        $paypal_args = array(
            'cmd'           => '_cart',
            'upload'        => '1',
            'business'      => PayPalSettings::getPayPalEmail($form->id),
            'email'         => $customerEmail,
            'no_shipping'   => (ArrayHelper::get($methodSettings, 'settings.require_shipping_address.value') == 'yes') ? '0' : '1',
            'no_note'       => '1',
            'currency_code' => strtoupper($submission->currency),
            'charset'       => 'utf-8',
            'custom'        => $submission->id,
            'return'        => $successUrl,
            'notify_url'    => $listener_url,
            'cancel_return' => $cancelUrl,
            'image_url'     => ArrayHelper::get($paymentSettings, 'business_logo')
        );

        $paypal_args = wp_parse_args($paypal_args, $this->getCartSummery());

        $paypal_args = apply_filters('fluentform_paypal_checkout_args', $paypal_args, $submission, $transaction, $form);

        $redirectUrl = $this->getRedirectUrl($paypal_args, $form->id);

        do_action('ff_log_data', [
            'parent_source_id' => $submission->form_id,
            'source_type'      => 'submission_item',
            'source_id'        => $submission->id,
            'component'        => 'Payment',
            'status'           => 'info',
            'title'            => 'Redirect to PayPal',
            'description'      => 'User redirect to paypal for completing the payment'
        ]);

        wp_send_json_success([
            'nextAction'   => 'payment',
            'actionName'   => 'normalRedirect',
            'redirect_url' => $redirectUrl,
            'message'      => __('You are redirecting to PayPal.com to complete the purchase. Please wait while you are redirecting....', 'fluentformpro'),
            'result'       => [
                'insert_id' => $submission->id
            ]
        ], 200);
    }

    private function getCartSummery()
    {
        $items = $this->getOrderItems();
        $paypal_args = array();
        if ($items) {
            $counter = 1;
            foreach ($items as $item) {
                if (!$item->item_price) {
                    continue;
                }
                $paypal_args['item_name_' . $counter] = $item->item_name;
                $paypal_args['quantity_' . $counter] = $item->quantity;
                $paypal_args['amount_' . $counter] = round($item->item_price / 100, 2);
                $counter = $counter + 1;
            }
        }

        $discountItems = $this->getDiscountItems();
        if($discountItems) {
            $discountTotal = 0;
            foreach ($discountItems as $discountItem) {
                $discountTotal += $discountItem->line_total;
            }
            $paypal_args['discount_amount_cart'] = round($discountTotal / 100, 2);
        }

        return $paypal_args;
    }

    private function getRedirectUrl($args, $formId = false)
    {
        if ($this->getPaymentMode($formId) == 'test') {
            $paypal_redirect = 'https://www.sandbox.paypal.com/cgi-bin/webscr/?';
        } else {
            $paypal_redirect = 'https://www.paypal.com/cgi-bin/webscr/?';
        }

        return $paypal_redirect . http_build_query($args);
    }

    public function handleSessionRedirectBack($data)
    {
        $type = sanitize_text_field($data['type']);
        $submissionId = intval($data['fluentform_payment']);
        $this->setSubmissionId($submissionId);

        $submission = $this->getSubmission();

        $transactionHash = sanitize_text_field($data['transaction_hash']);
        $transaction = $this->getTransaction($transactionHash, 'transaction_hash');

        if (!$transaction || !$submission) {
            return;
        }

        $form = $this->getForm();
        $isNew = false;

        if ($type == 'success' && $transaction->status == 'paid') {
            $isNew = $this->getMetaData('is_form_action_fired') != 'yes';
            $returnData = $this->getReturnData();
        } else if ($type == 'success') {
            $returnData = [
                'insert_id' => $submission->id,
                'title'     => __('Payment was not marked as Paid', 'fluentformpro'),
                'result'    => false,
                'error'     => __('Looks like the payment is not marked as paid yet. Please reload this page after 1-2 minutes. Sometimes, PayPal payments take few minutes to marked as paid.  Please contact if needed!', 'fluentformpro')
            ];
        } else {
            $returnData = [
                'insert_id' => $submission->id,
                'title'     => __('Payment Cancelled', 'fluentformpro'),
                'result'    => false,
                'error'     => __('Looks like you have cancelled the payment', 'fluentformpro')
            ];
        }

        $returnData['type'] = $type;
        $returnData['is_new'] = $isNew;

        $this->showPaymentView($returnData);
    }

    public function handleWebAcceptPayment($data, $submissionId, $ipnVerified)
    {

        $this->setSubmissionId($submissionId);
        $submission = $this->getSubmission();

        if (!$submission) {
            return;
        }


        $payment_status = strtolower($data['payment_status']);

        if ($payment_status == 'refunded' || $payment_status == 'reversed') {
            // Process a refund
            $this->processRefund($data, $submission);
            return;
        }

        $transaction = $this->getLastTransaction($submissionId);

        if (!$transaction || $transaction->payment_method != $this->method) {
            return;
        }

        if ($data['txn_type'] != 'web_accept' && $data['txn_type'] != 'cart' && $data['payment_status'] != 'Refunded') {
            return;
        }


        // Check if actions are fired
        if ($this->getMetaData('is_form_action_fired') == 'yes') {
            return;
        }

        $business_email = isset($data['business']) && is_email($data['business']) ? trim($data['business']) : trim($data['receiver_email']);

        $this->setMetaData('paypal_receiver_email', $business_email);

        if ('completed' == $payment_status || 'pending' == $payment_status) {
            $status = 'paid';

            if ($payment_status == 'pending') {
                $status = 'processing';
            }
            // Let's make the payment as paid
            $updateData = [
                'payment_note'     => maybe_serialize($data),
                'charge_id'        => sanitize_text_field($data['txn_id']),
                'payer_email'      => sanitize_text_field($data['payer_email']),
                'payer_name'       => ArrayHelper::get($data, 'first_name') . ' ' . ArrayHelper::get($data, 'last_name'),
                'shipping_address' => $this->getAddress($data)
            ];

            $this->updateTransaction($transaction->id, $updateData);
            $this->changeSubmissionPaymentStatus($status);
            $this->changeTransactionStatus($transaction->id, $status);
            $this->recalculatePaidTotal();
            $returnData = $this->completePaymentSubmission(false);
            $this->setMetaData('is_form_action_fired', 'yes');

            if (isset($data['pending_reason'])) {
                // Log Processing Reason
                do_action('ff_log_data', [
                    'parent_source_id' => $submission->form_id,
                    'source_type'      => 'submission_item',
                    'source_id'        => $submission->id,
                    'component'        => 'Payment',
                    'status'           => 'info',
                    'title'            => 'PayPal Payment Pending',
                    'description'      => $this->getPendingReason($data)
                ]);
            }
        }
    }

    private function processRefund($data, $submission)
    {
        if ($submission->payment_status == 'refunded') {
            return;
        }

        if ($submission->payment_status == 'refunded') {
            return;
        }

        // check if already refunded
        $refundExist = $this->getTransactionByChargeId($data['txn_id']);

        if ($refundExist) {
            return;
        }

        $transaction = $this->getTransactionByChargeId($data['parent_txn_id']);

        if (!$transaction) {
            return;
        }

        $refund_amount = $data['mc_gross'] * -100;

        $this->refund($refund_amount, $transaction, $submission, 'paypal', $data['txn_id'], 'Refund From PayPal');

    }

    private function getAddress($data)
    {
        $address = array();
        if (!empty($data['address_street'])) {
            $address['address_line1'] = sanitize_text_field($data['address_street']);
        }
        if (!empty($data['address_city'])) {
            $address['address_city'] = sanitize_text_field($data['address_city']);
        }
        if (!empty($data['address_state'])) {
            $address['address_state'] = sanitize_text_field($data['address_state']);
        }
        if (!empty($data['address_zip'])) {
            $address['address_zip'] = sanitize_text_field($data['address_zip']);
        }
        if (!empty($data['address_state'])) {
            $address['address_country'] = sanitize_text_field($data['address_country_code']);
        }
        return implode(', ', $address);
    }

    public function getPaymentMode($formId = false)
    {
        $isLive = PayPalSettings::isLive($formId);
        if($isLive) {
            return 'live';
        }
        return 'test';
    }

    private function getPendingReason($data)
    {
        $note = 'Payment marked as pending';
        switch (strtolower($data['pending_reason'])) {
            case 'echeck' :
                $note = __('Payment made via eCheck and will clear automatically in 5-8 days', 'easy-digital-downloads');
                break;
            case 'address' :
                $note = __('Payment requires a confirmed customer address and must be accepted manually through PayPal', 'easy-digital-downloads');
                break;
            case 'intl' :
                $note = __('Payment must be accepted manually through PayPal due to international account regulations', 'easy-digital-downloads');
                break;
            case 'multi-currency' :
                $note = __('Payment received in non-shop currency and must be accepted manually through PayPal', 'easy-digital-downloads');
                break;
            case 'paymentreview' :
            case 'regulatory_review' :
                $note = __('Payment is being reviewed by PayPal staff as high-risk or in possible violation of government regulations', 'easy-digital-downloads');
                break;
            case 'unilateral' :
                $note = __('Payment was sent to non-confirmed or non-registered email address.', 'easy-digital-downloads');
                break;
            case 'upgrade' :
                $note = __('PayPal account must be upgraded before this payment can be accepted', 'easy-digital-downloads');
                break;

            case 'verify' :
                $note = __('PayPal account is not verified. Verify account in order to accept this payment', 'easy-digital-downloads');
                break;
            case 'other' :
                $note = __('Payment is pending for unknown reasons. Contact PayPal support for assistance', 'easy-digital-downloads');
                break;
        }
        return $note;
    }

}