<?php

namespace FluentFormPro\Payments;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Modules\Acl\Acl;
use FluentForm\App\Modules\Form\FormFieldsParser;
use FluentForm\App\Services\FormBuilder\ShortCodeParser;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentFormPro\Payments\Classes\PaymentAction;
use FluentFormPro\Payments\Classes\PaymentEntries;
use FluentFormPro\Payments\Classes\PaymentReceipt;
use FluentFormPro\Payments\Components\Coupon;
use FluentFormPro\Payments\Components\CustomPaymentComponent;
use FluentFormPro\Payments\Components\ItemQuantity;
use FluentFormPro\Payments\Components\MultiPaymentComponent;
use FluentFormPro\Payments\Components\PaymentMethods;
use FluentFormPro\Payments\Components\PaymentSummaryComponent;
use FluentFormPro\Payments\Orders\OrderData;
use FluentFormPro\Payments\PaymentMethods\PayPal\PayPalHandler;
use FluentFormPro\Payments\PaymentMethods\Offline\OfflineHandler;
use FluentFormPro\Payments\PaymentMethods\Stripe\StripeHandler;
use FluentFormPro\Payments\PaymentMethods\Stripe\StripeSettings;

class PaymentHandler
{
    public function init()
    {
        add_filter('fluentform_global_settings_components', [$this, 'pushGlobalSettings'], 1, 1);

        add_action('fluentform_global_settings_component_payment_settings', [$this, 'renderPaymentSettings']);

        add_action('wp_ajax_fluentform_handle_payment_ajax_endpoint', [$this, 'handleAjaxEndpoints']);

        if (!$this->isEnabled()) {
            return;
        }

        add_filter('fluentform_show_payment_entries', '__return_true');

        add_filter('fluentform_form_settings_menu', array($this, 'maybeAddPaymentSettings'), 10, 2);
        // Let's load Payment Methods here
        (new StripeHandler())->init();;
        (new PayPalHandler())->init();;
        (new OfflineHandler())->init();;

        // Let's load the payment method component here
        new MultiPaymentComponent();
        new CustomPaymentComponent();
        new ItemQuantity();
        new PaymentMethods();
        new PaymentSummaryComponent();
        new Coupon();

        add_action('fluentform_before_insert_payment_form', array($this, 'maybeHandlePayment'), 10, 3);

        add_filter('fluentform_submission_order_data', function ($data, $submission, $form) {
            return OrderData::getSummary($submission, $form);
        }, 10, 3);

        add_filter('fluent_form_entries_vars', function ($vars, $form) {
            if ($form->has_payment) {
                $vars['has_payment'] = $form->has_payment;
                $vars['currency_config'] = PaymentHelper::getCurrencyConfig($form->id);
                $vars['currency_symbols'] = PaymentHelper::getCurrencySymbols();
                $vars['payment_statuses'] = PaymentHelper::getPaymentStatuses();
            }
            return $vars;
        }, 10, 2);

        add_filter('fluentform_submission_entry_labels_with_payment', array($this, 'modifySingleEntryLabels'), 10, 3);

        add_filter('fluentform_all_entry_labels_with_payment', array($this, 'modifySingleEntryLabels'), 10, 3);

        add_action('fluentform_rending_payment_form', function ($form) {
            wp_enqueue_script('fluentform-payment-handler', FLUENTFORMPRO_DIR_URL . 'public/js/payment_handler.js', array('jquery'), FLUENTFORM_VERSION, true);

            wp_localize_script('fluentform-payment-handler', 'fluentform_payment_config', [
                'i18n' => [
                    'item' => __('Item', 'fluentformpro'),
                    'price' => __('Price', 'fluentformpro'),
                    'qty' => __('Qty', 'fluentformpro'),
                    'line_total' => __('Line Total', 'fluentformpro'),
                    'total' => __('Total', 'fluentformpro'),
                    'not_found' => __('No payment item selected yet', 'fluentformpro'),
                    'discount:' => __('Discount:', 'fluentformpro')
                ]
            ]);

            $publishableKey = apply_filters('fluentform-payment_stripe_publishable_key', StripeSettings::getPublishableKey($form->id), $form->id);

            wp_localize_script('fluentform-payment-handler', 'fluentform_payment_config_' . $form->id, [
                'currency_settings' => PaymentHelper::getCurrencyConfig($form->id),
                'stripe' => [
                    'publishable_key' => $publishableKey
                ]
            ]);

        });

        if (isset($_GET['fluentform_payment']) && isset($_GET['payment_method'])) {
            add_action('wp', function () {
                $data = $_GET;
                $paymentMethod = sanitize_text_field($_GET['payment_method']);
                do_action('fluent_payment_frameless_' . $paymentMethod, $data);
            });
        }

        if (isset($_REQUEST['fluentform_payment_api_notify'])) {
            add_action('wp', function () {
                $paymentMethod = sanitize_text_field($_REQUEST['payment_method']);
                do_action('fluentform_ipn_endpint_' . $paymentMethod);
            });
        }

        add_filter('fluentform_editor_vars', function ($vars) {
            $settings = PaymentHelper::getCurrencyConfig($vars['form_id']);
            $vars['payment_settings'] = $settings;
            $vars['has_payment_features'] = !!$settings;
            return $vars;
        });

        add_filter('fluentform_payment_smartcode', array($this, 'paymentReceiptView'), 10, 3);

        (new PaymentEntries())->init();

    }

    public function pushGlobalSettings($components)
    {
        $components['payment_settings'] = [
            'hash' => '',
            'title' => 'Payment Settings',
            'query' => [
                'component' => 'payment_settings'
            ]
        ];
        return $components;
    }

    public function renderPaymentSettings()
    {
        $paymentSettings = PaymentHelper::getPaymentSettings();
        $isSettingsAvailable = !!get_option('__fluentform_payment_module_settings');

        $nav = 'general';

        if (isset($_REQUEST['nav'])) {
            $nav = sanitize_text_field($_REQUEST['nav']);
        }

        $data = [
            'is_setup' => $isSettingsAvailable,
            'general' => $paymentSettings,
            'payment_methods' => apply_filters('fluentformpro_available_payment_methods', []),
            'currencies' => PaymentHelper::getCurrencies(),
            'active_nav' => $nav,
            'stripe_webhook_url' => add_query_arg([
                'fluentform_payment_api_notify' => '1',
                'payment_method' => 'stripe'
            ], home_url('/'))
        ];

        wp_enqueue_script('ff-payment-settings', FLUENTFORMPRO_DIR_URL . 'public/js/payment-settings.js', ['jquery'], FLUENTFORMPRO_VERSION, true);

        wp_enqueue_media();

        wp_localize_script('ff-payment-settings', 'ff_payment_settings', $data);

        echo '<div id="ff-payment-settings"><ff-payment-settings :settings="settings"></ff-payment-settings></div>';
    }

    public function handleAjaxEndpoints()
    {
        if (isset($_REQUEST['form_id'])) {
            Acl::verify('fluentform_forms_manager');
        } else {
            Acl::verify('fluentform_settings_manager');
        }

        $route = sanitize_text_field($_REQUEST['route']);
        (new AjaxEndpoints())->handleEndpoint($route);
    }

    public function maybeHandlePayment($insertData, $data, $form)
    {
        // Let's get selected Payment Method
        if (!FormFieldsParser::hasPaymentFields($form)) {
            return;
        }

        $paymentAction = new PaymentAction($form, $insertData, $data);

        if (!$paymentAction->getCalculatedAmount()) {
            return;
        }

        /*
         * We have to check if
         * 1. has payment method
         * 2. if user selected payment method
         * 3. or maybe has a conditional logic on it
         */
        if($paymentAction->isConditionPass()) {
            if (FormFieldsParser::hasElement($form, 'payment_method') &&
                !$paymentAction->selectedPaymentMethod
            ) {
                wp_send_json([
                    'errors' => [__('Sorry! No selected payment method found. Please select a valid payment method', 'fluentformpro')]
                ], 423);
            }
        }

        $paymentAction->draftFormEntry();
    }

    public function isEnabled()
    {
        $paymentSettings = PaymentHelper::getPaymentSettings();
        return $paymentSettings['status'] == 'yes';
    }

    public function modifySingleEntryLabels($labels, $submission, $form)
    {
        $formFields = FormFieldsParser::getPaymentFields($form);
        if($formFields && is_array($formFields)) {
            $labels = ArrayHelper::except($labels, array_keys($formFields));
        }
        return $labels;
    }

    public function maybeAddPaymentSettings($menus, $formId)
    {
        $form = wpFluent()->table('fluentform_forms')->find($formId);
        if ($form->has_payment) {
            $menus = array_merge(array_slice($menus, 0, 1), array(
                'payment_settings' => [
                    'title' => __('Payment Settings', 'fluentformpro'),
                    'slug' => 'form_settings',
                    'hash' => 'payment_settings',
                    'route' => '/payment-settings',
                ]
            ), array_slice($menus, 1));
        }
        return $menus;
    }


    /**
     * @param $html string
     * @param $property string
     * @param $instance ShortCodeParser
     * @return false|string
     */
    public function paymentReceiptView($html, $property, $instance)
    {
        $entry = $instance::getEntry();
        $receiptClass = new PaymentReceipt($entry);
        return $receiptClass->getItem($property);
    }

}