<?php

namespace FluentFormPro\Payments\PaymentMethods\Stripe;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\Framework\Helpers\ArrayHelper;
use FluentFormPro\Payments\Components\PaymentMethods;
use FluentFormPro\Payments\PaymentMethods\Stripe\API\ApiRequest;
use FluentFormPro\Payments\PaymentMethods\Stripe\API\StripeListener;

class StripeHandler
{
    protected $key = 'stripe';

    public function init()
    {
        add_filter('fluentform_payment_settings_'.$this->key, function () {
            return StripeSettings::getSettings();
        });
        add_filter('payment_method_settings_validation_'.$this->key, array($this, 'validateSettings'), 10, 2);

        if (!$this->isEnabled()) {
            return;
        }

        add_filter('fluentformpro_available_payment_methods', array($this, 'pushPaymentMethodToForm'), 10, 1);

        add_action('fluentform_rending_payment_method_' . $this->key, array($this, 'enqueueAssets'));

        add_filter('fluentform_transaction_data_' . $this->key, array($this, 'modifyTransaction'), 10, 1);

        add_action('fluentform_ipn_endpint_'.$this->key, function () {
            (new StripeListener())->verifyIPN();
        });

        (new StripeProcessor())->init();
    }

    public function pushPaymentMethodToForm($methods)
    {
        if (!$this->isEnabled()) {
            return $methods;
        }

        $methods[$this->key] = [
            'title' => __('Credit/Debit Card (Stripe)', 'fluentformpro'),
            'enabled' => 'yes',
            'method_value' => $this->key,
            'settings' => [
                'option_label' => [
                    'type' => 'text',
                    'template' => 'inputText',
                    'value' => 'Pay with Card (Stripe)',
                    'label' => 'Method Label'
                ],
                'require_billing_info' => [
                    'type' => 'checkbox',
                    'template' => 'inputYesNoCheckbox',
                    'value' => 'no',
                    'label' => 'Require Billing info'
                ],
                'require_shipping_info' => [
                    'type' => 'checkbox',
                    'template' => 'inputYesNoCheckbox',
                    'value' => 'no',
                    'label' => 'Collect Shipping Info'
                ]
            ]
        ];

        return $methods;
    }

    public function enqueueAssets()
    {
        wp_enqueue_script('stripe_elements', 'https://js.stripe.com/v3/', array('jquery'), '3.0', true);
    }

    public function validateSettings($errors, $settings)
    {
        if(ArrayHelper::get($settings, 'is_active') != 'yes') {
            return [];
        }

        $mode = $settings['payment_mode'];

        if(empty($settings[$mode.'_publishable_key']) || empty($settings[$mode.'_secret_key'])) {
            $errors['keys'] = 'Stripe Publishable Key and Secret key is required for '.$mode.' mode';
        }

        return $errors;
    }

    public function modifyTransaction($transaction)
    {
        if ($transaction->charge_id) {
            $urlBase = 'https://dashboard.stripe.com/';
            if ($transaction->payment_mode != 'live') {
                $urlBase .= 'test/';
            }
            $transaction->action_url = $urlBase . 'payments/' . $transaction->charge_id;
        }

        if ($transaction->status == 'requires_capture') {
            $transaction->additional_note = '<b>Action Required: </b> The payment has been authorized but not captured yet. Please <a target="_blank" rel="noopener" href="' . $transaction->action_url . '">Click here</a> to capture this payment in stripe.com';
        }

        return $transaction;
    }

    public function isEnabled()
    {
        $settings = StripeSettings::getSettings();
        return $settings['is_active'] == 'yes';
    }
}
