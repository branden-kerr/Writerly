<?php

namespace FluentFormPro\Payments\PaymentMethods\Offline;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class OfflineHandler
{
    protected $key = 'test';

    public function init()
    {
        add_filter('fluentform_payment_settings_' . $this->key, array($this, 'getSettings'));

        if(!$this->isEnabled()) {
            return;
        }

        add_filter(
            'fluentformpro_available_payment_methods',
            [$this, 'pushPaymentMethodToForm']
        );

        add_filter('fluentform_transaction_data_' . $this->key, array($this, 'modifyTransaction'), 10, 1);

        (new OfflineProcessor())->init();
    }

    public function pushPaymentMethodToForm($methods)
    {
        $methods[$this->key] = [
            'title' => __('Offline Payment', 'fluentformpro'),
            'enabled' => 'yes',
            'method_value' => $this->key,
            'settings' => [
                'option_label' => [
                    'type' => 'text',
                    'template' => 'inputText',
                    'value' => 'Offline Payment',
                    'label' => 'Method Label'
                ]
            ]
        ];

        return $methods;
    }

    public function getSettings()
    {
        $defaults = [
            'is_active' => 'no',
            'payment_mode' => 'test',
            'payment_instruction' => ''
        ];

        $settings = get_option('fluentform_payment_settings_test', []);

        $settings = wp_parse_args($settings, $defaults);

        return $settings;
    }

    public function isEnabled()
    {
        $settings = $this->getSettings();
        return $settings['is_active'] == 'yes';
    }

    public function modifyTransaction($transaction)
    {
        $transaction->payment_method = __('Offline', 'fluentformpro');
        return $transaction;
    }
}
