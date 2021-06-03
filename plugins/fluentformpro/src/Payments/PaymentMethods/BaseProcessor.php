<?php

namespace FluentFormPro\Payments\PaymentMethods;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Modules\Form\FormHandler;
use FluentForm\Framework\Helpers\ArrayHelper;

abstract class BaseProcessor
{
    protected $method;

    protected $form = null;

    protected $submission = null;

    protected $submissionId = null;

    public function init()
    {
        add_action('fluentform_process_payment_' . $this->method, array($this, 'handlePaymentAction'), 10, 4);
    }

    public abstract function handlePaymentAction($submissionId, $submissionData, $form, $methodSettings);

    public function setSubmissionId($submissionId)
    {
        $this->submissionId = $submissionId;
    }

    public function getSubmissionId()
    {
        return $this->submissionId;
    }

    public function insertTransaction($data)
    {
        $submission = $this->getSubmission();
        $data['created_at'] = current_time('mysql');
        $data['updated_at'] = current_time('mysql');
        $data['form_id'] = $submission->form_id;
        $data['submission_id'] = $submission->id;
        $data['payment_method'] = $this->method;
        if(empty($data['transaction_type'])) {
            $data['transaction_type'] = 'onetime';
        }

        if ($userId = get_current_user_id()) {
            $data['user_id'] = $userId;
        }

        return wpFluent()->table('fluentform_transactions')->insert($data);
    }

    public function insertRefund($data)
    {
        $submission = $this->getSubmission();
        $data['created_at'] = current_time('mysql');
        $data['updated_at'] = current_time('mysql');
        $data['form_id'] = $submission->form_id;
        $data['submission_id'] = $submission->id;
        $data['payment_method'] = $this->method;
        if(empty($data['transaction_type'])) {
            $data['transaction_type'] = 'refund';
        }

        if ($userId = get_current_user_id()) {
            $data['user_id'] = $userId;
        }

        return wpFluent()->table('fluentform_transactions')->insert($data);
    }

    public function getTransaction($transactionId, $column = 'id')
    {
        return wpFluent()->table('fluentform_transactions')
            ->where($column, $transactionId)
            ->where('transaction_type', 'onetime')
            ->first();
    }

    public function getRefund($refundId, $column = 'id')
    {
        return wpFluent()->table('fluentform_transactions')
            ->where($column, $refundId)
            ->where('transaction_type', 'refund')
            ->first();
    }

    public function getTransactionByChargeId($chargeId)
    {
        return wpFluent()->table('fluentform_transactions')
            ->where('submission_id', $this->submissionId)
            ->where('charge_id', $chargeId)
            ->first();
    }

    public function getLastTransaction($submissionId)
    {
        return wpFluent()->table('fluentform_transactions')
            ->where('submission_id', $submissionId)
            ->orderBy('id', 'DESC')
            ->first();
    }

    public function changeSubmissionPaymentStatus($newStatus)
    {
        do_action('fluentform_before_payment_status_change', $newStatus, $this->getSubmission());

        wpFluent()->table('fluentform_submissions')
            ->where('id', $this->submissionId)
            ->update([
                'payment_status' => $newStatus,
                'updated_at' => current_time('mysql')
            ]);

        $this->submission = null;

        do_action('ff_log_data', [
            'parent_source_id' => $this->getForm()->id,
            'source_type'      => 'submission_item',
            'source_id'        => $this->submissionId,
            'component'        => 'Payment',
            'status'           => 'info',
            'title'            => 'Payment Status changed',
            'description'      => 'Payment status changed to '.$newStatus
        ]);

        do_action('fluentform_after_payment_status_change', $newStatus, $this->getSubmission());

        return true;
    }

    public function recalculatePaidTotal()
    {
        $transactions = wpFluent()->table('fluentform_transactions')
            ->where('submission_id', $this->submissionId)
            ->whereIn('status', ['paid', 'requires_capture', 'processing', 'partially-refunded', 'refunded'])
            ->where('transaction_type','onetime')
            ->get();

        $total = 0;
        foreach ($transactions as $transaction) {
            $total += $transaction->payment_total;
        }

        $refunds = $this->getRefundTotal();
        if($refunds) {
            $total = $total - $refunds;
        }

        return wpFluent()->table('fluentform_submissions')
            ->where('id', $this->submissionId)
            ->update([
                'total_paid' => $total,
                'updated_at' => current_time('mysql')
            ]);
    }

    public function getRefundTotal()
    {
        $refunds = wpFluent()->table('fluentform_transactions')
            ->where('submission_id', $this->submissionId)
            ->where('transaction_type','refund')
            ->get();

        $total = 0;
        if($refunds) {
            foreach ($refunds as $refund) {
                $total += $refund->payment_total;
            }
        }

        return $total;
    }

    public function changeTransactionStatus($transactionId, $newStatus)
    {
        do_action(
            'fluentform_before_transaction_status_change',
            $newStatus,
            $this->getSubmission(),
            $transactionId
        );

        wpFluent()->table('fluentform_transactions')
            ->where('id', $transactionId)
            ->update([
                'status' => $newStatus,
                'updated_at' => current_time('mysql')
            ]);

        do_action(
            'fluentform_after_transaction_status_change',
            $newStatus,
            $this->getSubmission(),
            $transactionId
        );

        return true;
    }

    public function updateTransaction($transactionId, $data)
    {
        $data['updated_at'] = current_time('mysql');

        return wpFluent()->table('fluentform_transactions')
            ->where('id', $transactionId)
            ->update($data);
    }

    public function completePaymentSubmission($isAjax = true)
    {
        $returnData = $this->getReturnData();
        if ($isAjax) {
            wp_send_json_success($returnData, 200);
        }
        return $returnData;
    }

    public function getReturnData()
    {
        $submission = $this->getSubmission();
        if($this->getMetaData('is_form_action_fired') == 'yes') {
            $data = (new FormHandler(wpFluentForm()))->getReturnData($submission->id, $this->getForm(), $submission->response);
            $returnData = [
                'insert_id' => $submission->id,
                'result' => $data,
                'error' => ''
            ];
            if(!isset($_REQUEST['fluentform_payment_api_notify'])) {
                // now we have to check if we need this user as auto login
                if($loginId = $this->getMetaData('_make_auto_login')) {
                    $this->maybeAutoLogin($loginId, $submission);
                }
            }
        } else {
            $returnData = (new FormHandler(wpFluentForm()))->processFormSubmissionData(
                $this->submissionId, $submission->response, $this->getForm()
            );
            $this->setMetaData('is_form_action_fired', 'yes');
        }
        return $returnData;
    }

    public function getSubmission()
    {
        if (!is_null($this->submission)) {
            return $this->submission;
        }

        $submission = wpFluent()->table('fluentform_submissions')
            ->where('id', $this->submissionId)
            ->first();

        $submission->response = json_decode($submission->response, true);

        $this->submission = $submission;

        return $this->submission;

    }

    public function getForm()
    {
        if (!is_null($this->form)) {
            return $this->form;
        }

        $submission = $this->getSubmission();

        $this->form = wpFluent()->table('fluentform_forms')
            ->where('id', $submission->form_id)
            ->first();

        return $this->form;
    }

    public function getOrderItems()
    {
        return wpFluent()->table('fluentform_order_items')
            ->where('submission_id', $this->submissionId)
            ->where('type', 'single')
            ->get();
    }

    public function getDiscountItems()
    {
        return wpFluent()->table('fluentform_order_items')
            ->where('submission_id', $this->submissionId)
            ->where('type', 'discount')
            ->get();
    }

    public function setMetaData($name, $value)
    {
        $value = maybe_serialize($value);

        return wpFluent()->table('fluentform_submission_meta')
            ->insert([
                'response_id' => $this->getSubmissionId(),
                'form_id' => $this->getForm()->id,
                'meta_key' => $name,
                'value' => $value,
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql')
            ]);
    }

    public function deleteMetaData($name)
    {
        return wpFluent()->table('fluentform_submission_meta')
            ->where('meta_key', $name)
            ->where('response_id', $this->getSubmissionId())
            ->delete();
    }

    public function getMetaData($metaKey)
    {
        $meta = wpFluent()->table('fluentform_submission_meta')
            ->where('response_id', $this->getSubmissionId())
            ->where('meta_key', $metaKey)
            ->first();

        if ($meta && $meta->value) {
            return maybe_unserialize($meta->value);
        }

        return false;
    }

    public function showPaymentView($returnData)
    {
        $redirectUrl = ArrayHelper::get($returnData, 'result.redirectUrl');
        if($redirectUrl) {
            wp_redirect($redirectUrl);
            exit();
        }

        $form = $this->getForm();

        if(!empty($returnData['title'])) {
            $title = $returnData['title'];
        } else if($returnData['type'] == 'success') {
            $title = __('Payment Success', 'fluentformpro');
        } else {
            $title = __('Payment Failed', 'fluentformpro');
        }

        $message = $returnData['error'];
        if(!$message) {
            $message = $returnData['result']['message'];
        }

        $data = [
            'status' => $returnData['type'],
            'form' => $form,
            'title' => $title,
            'submission' => $this->getSubmission(),
            'message' => $message,
            'is_new' => $returnData['is_new'],
            'data' => $returnData
        ];

        $data = apply_filters('fluentform_frameless_page_data', $data);

        add_filter('pre_get_document_title', function ($title) use ($data) {
            return $data['title'].' '.apply_filters( 'document_title_separator', '-' ). ' ' . $data['form']->title;
        });

        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_style('fluent-form-landing', FLUENTFORMPRO_DIR_URL.'public/css/frameless.css', [], FLUENTFORMPRO_VERSION);
        });

        status_header(200);
        echo $this->loadView('frameless_view', $data);
        exit(200);
    }

    public function loadView($view, $data = [])
    {
        $file = FLUENTFORMPRO_DIR_PATH . 'src/views/' . $view . '.php';
        extract($data);
        ob_start();
        include($file);
        return ob_get_clean();
    }

    public function refund($refund_amount, $transaction, $submission, $method = '', $refundId = '', $refundNote = 'Refunded')
    {
        $this->setSubmissionId($submission->id);
        $status = 'refunded';
        $alreadyRefunded = $this->getRefundTotal();
        $totalRefund = intval($refund_amount + $alreadyRefunded);

        if($totalRefund < $transaction->payment_total) {
            $status = 'partially-refunded';
        }

        $this->changeTransactionStatus($transaction->id, $status);
        $this->changeSubmissionPaymentStatus($status);

        $refundData = [
            'form_id'        => $submission->form_id,
            'submission_id'  => $submission->id,
            'payment_method' => $transaction->payment_method,
            'charge_id'      =>  $refundId,
            'payment_note'   => $refundNote,
            'payment_total'  => $refund_amount,
            'payment_mode'   => $transaction->payment_mode,
            'created_at'     => current_time('mysql'),
            'updated_at'     => current_time('mysql'),
            'status'         => 'refunded',
            'transaction_type' => 'refund'
        ];

        $refundId = $this->insertRefund($refundData);

        do_action('ff_log_data', [
            'parent_source_id' => $submission->form_id,
            'source_type'      => 'submission_item',
            'source_id'        => $submission->id,
            'component'        => 'Payment',
            'status'           => 'info',
            'title'            => 'Refund issued',
            'description'      => 'Refund issued and refund amount: '.number_format($refund_amount / 100, 2)
        ]);

        $this->recalculatePaidTotal();

        $refund = $this->getRefund($refundId);

        do_action('fluentform_payment_refunded_'.$method, $refund, $refund->form_id);
        do_action('fluentform_payment_refunded', $refund, $refund->form_id);
    }

    private function maybeAutoLogin($loginId, $submission)
    {
        if(is_user_logged_in() || !$loginId) {
            return;
        }
        if($loginId != $submission->user_id) {
            return;
        }

        wp_clear_auth_cookie();
        wp_set_current_user($loginId);
        wp_set_auth_cookie($loginId);
        $this->deleteMetaData('_make_auto_login');
    }

    public function getAmountTotal()
    {
        $orderItems = $this->getOrderItems();

        $amountTotal = 0;
        foreach ($orderItems as $item) {
            $amountTotal += $item->line_total;
        }

        $discountItems = $this->getDiscountItems();
        foreach ($discountItems as $discountItem) {
            $amountTotal -= $discountItem->line_total;
        }

        return $amountTotal;
    }
}
