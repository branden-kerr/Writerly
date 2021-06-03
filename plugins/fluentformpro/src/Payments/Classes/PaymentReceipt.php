<?php

namespace FluentFormPro\Payments\Classes;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentFormPro\Payments\Orders\OrderData;

class PaymentReceipt
{

    private $entry;

    private $orderItems = null;

    private $discountItems = null;

    public function __construct($entry)
    {
        $this->entry = $entry;
    }

    public function getItem($property)
    {
        $methodMaps = [
            'receipt' => 'renderReceipt',
            'summary' => 'paymentInfo',
            'summary_list' => 'paymentInfoTable',
            'order_items' => 'itemDetails'
        ];

        $submissionMaps = [
            'payment_status',
            'payment_total',
            'payment_method'
        ];

        if(isset($methodMaps[$property])) {
            $html = $this->{$methodMaps[$property]}();
            $html .= $this->loadCss();
            return $html;
        }

        if(in_array($property, $submissionMaps)) {
            return $this->getSubmissionValue($property);
        }

        return '';

    }

    public function getSubmissionValue($property)
    {
        if($property == 'payment_total') {
            return OrderData::calculateOrderItemsTotal($this->getOrderItems(), true, $this->entry->currency, $this->getDiscountItems());
        }

        $value = $this->entry->{$property};

        if($property == 'payment_method' && $value == 'test') {
            return __('Offline', 'fluentformpro');
        }

        return ucfirst($value);
    }

    private function getOrderItems()
    {
        if (!is_null($this->orderItems)) {
            return $this->orderItems;
        }

        $this->orderItems = OrderData::getOrderItems($this->entry);
        return $this->orderItems;
    }

    protected function getDiscountItems()
    {
        if (!is_null($this->discountItems)) {
            return $this->discountItems;
        }

        $this->discountItems = OrderData::getDiscounts($this->entry);
        return $this->discountItems;
    }

    public function renderReceipt()
    {
        $submission = $this->entry;

        if (!$submission) {
            return '<p class="ff_invalid_receipt">' . __('Invalid submission. No receipt found', 'fluentformpro') . '</p>';
        }

        $html = $this->beforePaymentReceipt();

        $html .= $this->paymentInfo();


        $html .= '<h4>' . __('Order Details', 'fluentformpro') . '</h4>';
        $html .= $this->itemDetails();
        $html .= $this->customerDetails();
        $html .= $this->afterPaymentReceipt();
        $html .= $this->loadCss();
        return $html;
    }

    private function beforePaymentReceipt()
    {
        ob_start();
        echo '<div class="ff_payment_receipt">';
        do_action('fluentform_payment_receipt_before_content', $this->entry);
        return ob_get_clean();
    }

    private function afterPaymentReceipt()
    {
        ob_start();
        do_action('fluentform_payment_receipt_after_content', $this->entry);
        echo '</div>';
        return ob_get_clean();
    }


    private function paymentInfo()
    {
        $preRender = apply_filters('fluentform_payment_receipt_pre_render_payment_info', '', $this->entry);
        if ($preRender) {
            return $preRender;
        }

        $orderItems = $this->getOrderItems();

        if (!$orderItems) {
            return;
        }

        $submission = $this->entry;

        if($submission->payment_method == 'test') {
            $submission->payment_method = __('Offline', 'fluentformpro');
        }

        $discountItems = $this->getDiscountItems();

        return $this->loadView('payment_info', array(
            'submission' => $submission,
            'items' => $orderItems,
            'discount_items' => $discountItems,
            'orderTotal' => OrderData::calculateOrderItemsTotal($orderItems, true, $this->entry->currency, $discountItems)
        ));
    }

    private function paymentInfoTable()
    {
        $preRender = apply_filters('fluentform_payment_receipt_pre_render_payment_info_list', '', $this->entry);
        if ($preRender) {
            return $preRender;
        }

        $orderItems = $this->getOrderItems();

        if (!$orderItems) {
            return '';
        }

        $discountItems = $this->getDiscountItems();

        return $this->loadView('payment_info_list', array(
            'submission' => $this->entry,
            'items' => $orderItems,
            'orderTotal' => OrderData::calculateOrderItemsTotal($orderItems, true, $this->entry->currency, $discountItems)
        ));
    }


    private function itemDetails()
    {
        $orderItems = $this->getOrderItems();
        $preRender = apply_filters('fluentform_payment_receipt_pre_render_item_details', '', $this->entry, $orderItems);
        if ($preRender) {
            return $preRender;
        }

        if (!$orderItems) {
            return '';
        }

        $discountItems = $this->getDiscountItems();

        return $this->loadView('order_items_table', array(
            'submission' => $this->entry,
            'items' => $orderItems,
            'discount_items' => $discountItems,
            'subTotal' => OrderData::calculateOrderItemsTotal($orderItems, true, $this->entry->currency),
            'orderTotal' => OrderData::calculateOrderItemsTotal($orderItems, true, $this->entry->currency, $discountItems)
        ));
    }

    private function customerDetails()
    {
        $preRender = apply_filters('fluentform_payment_receipt_pre_render_submission_details', '', $this->entry);
        if ($preRender) {
            return $preRender;
        }

        $transactions = OrderData::getTransactions($this->entry->id);
        if (!$transactions || empty($transactions[0])) {
            return;
        }

        $transaction = $transactions[0];

        return $this->loadView('customer_details', array(
            'submission' => $this->entry,
            'transaction' => $transaction
        ));
    }

    private function loadCss()
    {
        return $this->loadView('custom_css', array('submission' => $this->entry));
    }

    public function loadView($fileName, $data)
    {
        // normalize the filename
        $fileName = str_replace(array('../', './'), '', $fileName);
        $basePath = apply_filters('fluentform_payment_receipt_template_base_path', FLUENTFORMPRO_DIR_PATH . 'src/views/receipt/', $fileName, $data);
        $filePath = $basePath . $fileName . '.php';
        extract($data);
        ob_start();
        include $filePath;
        return ob_get_clean();
    }
}