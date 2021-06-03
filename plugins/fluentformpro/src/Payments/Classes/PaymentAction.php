<?php

namespace FluentFormPro\Payments\Classes;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Helpers\Helper;
use FluentForm\App\Modules\Form\FormFieldsParser;
use FluentForm\App\Modules\Form\FormHandler;
use FluentForm\App\Services\ConditionAssesor;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentFormPro\Payments\PaymentHelper;

class PaymentAction
{
    private $form;

    private $data;

    private $submissionData;

    private $submissionId = null;

    private $orderItems = [];

    private $quantityItems = [];

    public $selectedPaymentMethod = '';

    public $methodSettings = [];

    protected $paymentInputs = null;

    protected $currency = null;

    protected $methodField = null;

    protected $discountCodes = [];

    protected $couponField = [];

    public function __construct($form, $insertData, $data)
    {
        $this->form = $form;
        $this->data = $data;
        $this->setSubmissionData($insertData);
        $this->setupData();
    }

    private function setSubmissionData($insertData)
    {
        $insertData = (array)$insertData;
        $insertData['response'] = json_decode($insertData['response'], true);
        $this->submissionData = $insertData;
    }

    private function setupData()
    {
        $formFields = FormFieldsParser::getPaymentFields($this->form, ['admin_label', 'attributes', 'settings']);

        $paymentInputElements = ['custom_payment_component', 'multi_payment_component'];
        $quantityItems = [];
        $paymentInputs = [];
        $paymentMethod = false;
        $couponField = false;
        foreach ($formFields as $fieldKey => $field) {
            $element = ArrayHelper::get($field, 'element');
            if(in_array($element, $paymentInputElements)) {
                $paymentInputs[$fieldKey] = $field;
            } else  if($element == 'item_quantity_component') {
                $quantityItems[ArrayHelper::get($field, 'settings.target_product')] = ArrayHelper::get($field, 'attributes.name');
            } else if($element == 'payment_method') {
                $paymentMethod = $field;
            } else if($element == 'payment_coupon') {
                $couponField = $field;
            }
        }

        $this->paymentInputs = $paymentInputs;
        $this->quantityItems = $quantityItems;

        if($paymentMethod) {
            $this->methodField = $paymentMethod;
            if($this->isConditionPass()) {
                $methodName = ArrayHelper::get($paymentMethod, 'attributes.name');
                $this->selectedPaymentMethod = ArrayHelper::get($this->data, $methodName);
                $this->methodSettings = ArrayHelper::get($paymentMethod, 'settings.payment_methods.'.$this->selectedPaymentMethod);
            }
        }

        if($couponField) {
            $couponCodes = ArrayHelper::get($this->data, '__ff_all_applied_coupons', '');
            if($couponCodes) {
                $couponCodes = \json_decode($couponCodes, true);
                if($couponCodes) {
                    $couponCodes = array_unique($couponCodes);
                    $this->discountCodes = (new CouponModel())->getCouponsByCodes($couponCodes);
                    $this->couponField = $couponField;
                }
            }
        }
    }

    public function isConditionPass()
    {
        $conditionSettings = ArrayHelper::get($this->methodField, 'settings.conditional_logics', []);
        if (
            !$conditionSettings ||
            !ArrayHelper::isTrue($conditionSettings, 'status') ||
            !count(ArrayHelper::get($conditionSettings, 'conditions'))
        ) {
            return true;
        }

        $conditionFeed = ['conditionals' => $conditionSettings];
        return ConditionAssesor::evaluate($conditionFeed, $this->data);
    }

    public function draftFormEntry()
    {
        $formSettings = PaymentHelper::getFormSettings($this->form->id, 'public');
        $submission = $this->submissionData;
        $submission['payment_status'] = 'pending';
        $submission['payment_method'] = $this->selectedPaymentMethod;
        $submission['payment_type'] = $this->getPaymentType();
        $submission['currency'] = $formSettings['currency'];
        $submission['response'] = json_encode($submission['response']);
        $submission['payment_total'] = $this->getCalculatedAmount();

        $submission = apply_filters('fluentform_with_payment_submission_data', $submission, $this->form);

        $insertId = wpFluent()->table('fluentform_submissions')->insert($submission);

        $uidHash = md5(wp_generate_uuid4() . $insertId);
        Helper::setSubmissionMeta($insertId, '_entry_uid_hash', $uidHash, $this->form->id);

        $submission['id'] = $insertId;
        $this->setSubmissionData($submission);
        $this->submissionId = $insertId;

        // Record Payment Items
        $items = $this->getOrderItems();

        foreach ($items as $item) {
            $item['submission_id'] = $insertId;
            wpFluent()->table('fluentform_order_items')->insert($item);
        }

        do_action('fluentform_process_payment_' . $this->selectedPaymentMethod, $this->submissionId, $this->submissionData, $this->form, $this->methodSettings);

        /*
         * The following code will run only if no payment method catch and process the payment
         * In the payment method, ideally they will send the response. But if no payment method exist then
         * we will handle here
         */
        $submission = wpFluent()->table('fluentform_submissions')->find($insertId);

        $returnData = (new FormHandler(wpFluentForm()))->processFormSubmissionData(
            $submission->id, $this->submissionData['response'], $this->form
        );

        wp_send_json_success($returnData, 200);
    }

    public function getOrderItems()
    {
        if ($this->orderItems) {
            return $this->orderItems;
        }

        $paymentInputs = $this->paymentInputs;

        if (!$paymentInputs) {
            return [];
        }

        $items = [];
        $data = $this->submissionData['response'];

        foreach ($paymentInputs as $paymentInput) {
            $name = ArrayHelper::get($paymentInput, 'attributes.name');
            if (!$name || !isset($data[$name])) {
                continue;
            }
            $price = 0;
            $inputType = ArrayHelper::get($paymentInput, 'attributes.type');

            if(!$data[$name]) {
                continue;
            }

            if($inputType == 'number') {
                $price = $data[$name];
            } else if ($inputType == 'single' ) {
                $price = ArrayHelper::get($paymentInput, 'attributes.value');
            } else if($inputType == 'radio' || $inputType == 'select') {
                $item = $this->getItemFromVariables($paymentInput, $data[$name]);
                if($item) {
                    $quantity = $this->getQuantity($item['parent_holder']);
                    if(!$quantity) {
                        continue;
                    }
                    $item['quantity'] = $quantity;
                    $this->pushItem($item);
                }
                continue;
            } else if(ArrayHelper::get($paymentInput, 'attributes.type') == 'checkbox') {
                $selectedItems = $data[$name];
                foreach ($selectedItems as $selectedItem) {
                    $item = $this->getItemFromVariables($paymentInput, $selectedItem);
                    if($item) {
                        $quantity = $this->getQuantity($item['parent_holder']);
                        if(!$quantity) {
                            continue;
                        }
                        $item['quantity'] = $quantity;
                        $this->pushItem($item);
                    }
                }
                continue;
            }

            if (!is_numeric($price) || !$price) {
                continue;
            }

            $productName = ArrayHelper::get($paymentInput, 'attributes.name');
            $quantity = $this->getQuantity($productName);
            if(!$quantity) {
                continue;
            }

            $this->pushItem([
                'parent_holder' => $productName,
                'item_name' => ArrayHelper::get($paymentInput, 'admin_label'),
                'item_price' => $price,
                'quantity' => $quantity
            ]);
        }


        $subTotal = array_sum(array_column($this->orderItems,'line_total')) / 100;

        if ($this->discountCodes) {
            $this->discountCodes = (new CouponModel())->getValidCoupons($this->discountCodes, $this->form->id, $subTotal);

            foreach ($this->discountCodes as $coupon) {
                $discountAmount = $coupon->amount;
                if ($coupon->coupon_type == 'percent') {
                    $discountAmount = intval((floatval($coupon->amount) / 100) * $subTotal);
                }

                $this->pushItem([
                    'parent_holder' => ArrayHelper::get($this->couponField, 'attributes.name'),
                    'item_name' => $coupon->title,
                    'item_price' => $discountAmount,
                    'quantity' => 1,
                    'type' => 'discount'
                ]);

                $subTotal = $subTotal - $discountAmount;
            }
        }

        $items = $this->orderItems;

        $items = apply_filters('fluentform_submission_order_items', $items, $this->submissionData, $this->form);

        $this->orderItems = $items;

        return $this->orderItems;
    }

    private function getQuantity($productName)
    {
        $quantity = 1;
        if(!$this->quantityItems) {
            return $quantity;
        }
        if(!isset($this->quantityItems[$productName])) {
            return $quantity;
        }
        $inputName = $this->quantityItems[$productName];
        $quantity = ArrayHelper::get($this->submissionData['response'], $inputName);
        if(!$quantity) {
            return 0;
        }
        return intval($quantity);
    }

    private function pushItem($data)
    {
        if(!$data['item_price']) {
            return;
        }

        $data['item_price'] = intval($data['item_price'] * 100);

        $defaults = [
            'type' => 'single',
            'form_id' => $this->form->id,
            'quantity' => !empty($data['quantity']) ? $data['quantity'] : 1,
            'created_at' => current_time('mysql'),
            'updated_at' => current_time('mysql')
        ];

        $item = wp_parse_args($data, $defaults);

        $item['line_total'] = $item['item_price'] * $item['quantity'];

        if(!$this->orderItems) {
            $this->orderItems = [];
        }

        $this->orderItems[] = $item;
    }

    private function getItemFromVariables($item, $key)
    {
        $selectedOption = [];
        foreach (ArrayHelper::get($item, 'settings.pricing_options') as $priceOption) {
            $label = sanitize_text_field($priceOption['label']);
            if($label == $key) {
                $selectedOption = $priceOption;
            }
        }

        if(!$selectedOption || empty($selectedOption['value']) || !is_numeric($selectedOption['value'])) {
            return false;
        }

        return [
            'parent_holder' => ArrayHelper::get($item, 'attributes.name'),
            'item_name' => $selectedOption['label'],
            'item_price' => $selectedOption['value']
        ];
    }

    public function getCalculatedAmount()
    {
        $items = $this->getOrderItems();

        $total = 0;
        foreach ($items as $item) {
            if($item['type'] == 'discount') {
                $total -= $item['line_total'];
            } else {
                $total += $item['line_total'];
            }
        }
        return $total;
    }

    public function getPaymentType()
    {
        return 'product'; // return value product|subscription|donation
    }

    private function getCurrency()
    {
        if ($this->currency !== null) {
            return $this->currency;
        }
        $this->currency = 'usd';

        return $this->currency;
    }


}