<?php

namespace FluentFormPro\Payments\Components;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Services\FormBuilder\BaseFieldManager;
use FluentForm\Framework\Helpers\ArrayHelper;

class PaymentMethods extends BaseFieldManager
{

    public function __construct()
    {
        parent::__construct(
            'payment_method',
            'Payment Method',
            ['payment methods', 'payment', 'methods', 'stripe', 'paypal'],
            'payments'
        );

        add_filter(
            'fluentform_editor_init_element_payment_method',
            [$this, 'recheckEditorComponent']
        );

        add_filter('fluentform_response_render_'.$this->key, function ($value) {
            if($value == 'test') {
                return 'Offline';
            }
            return $value;
        });

    }

    function getComponent()
    {
        $available_methods = apply_filters('fluentformpro_available_payment_methods', []);

        if (!$available_methods) {
            return;
        }

        return [
            'index' => 10,
            'element' => $this->key,
            'attributes' => [
                'name' => $this->key,
                'type' => 'radio',
                'value' => ''
            ],
            'settings' => [
                'container_class' => '',
                'label' => $this->title,
                'default_method' => '',
                'label_placement' => '',
                'help_message' => '',
                'payment_methods' => $available_methods,
                'admin_field_label' => '',
                'conditional_logics' => []
            ],
            'editor_options' => [
                'title' => $this->title . ' Field',
                'icon_class' => 'ff-edit-credit-card',
                'template' => 'inputPaymentMethods'
            ],
        ];
    }

    public function recheckEditorComponent($component)
    {
        $available_methods = apply_filters('fluentformpro_available_payment_methods', []);

        if(!$available_methods) {
            $component['settings']['payment_methods'] = $available_methods;
            return $component;
        }

        $existingMethods = ArrayHelper::get($component, 'settings.payment_methods', []);

        $updatedMethods = [];

        foreach ($available_methods as $methodName => $method) {
            if(isset($existingMethods[$methodName])) {
                $method['settings'] = wp_parse_args($existingMethods[$methodName]['settings'], $method['settings']);
                $method['enabled'] = $existingMethods[$methodName]['enabled'];
            } else {
                $method['enabled'] = 'no';
            }
            $updatedMethods[$methodName] = $method;
        }

        $component['settings']['payment_methods'] = $updatedMethods;

        return $component;
    }

    public function getEditorCustomizationSettings()
    {
        return [
            'payment_methods' => array(
                'template'  => 'paymentMethodsConfig',
                'label'     => __('Payment Methods', 'fluentformpro'),
                'help_text' => __('Please Select and Configure the payment methods for this form, At least 1 method is required. If you select only one it will not show on the form for selection but will process that payment with the selected method.', 'fluentformpro')
            )
        ];
    }

    public function getGeneralEditorElements()
    {
        return [
            'label',
            'admin_field_label',
            'label_placement',
            'payment_methods',
            'value'
        ];
    }

    function render($data, $form)
    {
        $elementName = $data['element'];
        $data = apply_filters('fluenform_rendering_field_data_'.$elementName, $data, $form);

        $data['attributes']['class'] = trim(
            'ff-el-form-check-input ' .
            ArrayHelper::get($data, 'attributes.class')
        );

        $paymentMethods = $formattedOptions = ArrayHelper::get($data, 'settings.payment_methods');
        $available_methods = apply_filters('fluentformpro_available_payment_methods', []);
        $activatedMethods = [];

        foreach ($paymentMethods as $methodName => $paymentMethod) {
            $enabled = ArrayHelper::get($paymentMethod, 'enabled');
            if($enabled == 'yes' && isset($available_methods[$methodName])) {
                $activatedMethods[$methodName] = $paymentMethod;
            }
        }

        if (!$activatedMethods) {
            echo wp_sprintf(
                '<p class="ff-error ff-payment-method-error">%s</p>',
                 __('No activated payment method found. If you are an admin please check the payment settings', 'fluentformpro')
             );
            return;
        }

        foreach ($activatedMethods as $methodName => $activatedMethod) {
            do_action(
                'fluentform_rending_payment_method_'.$methodName, $activatedMethod, $data, $form
            );
        }


        if (count($activatedMethods) == 1) {
            $methodKeys = array_keys($activatedMethods);
            $methodName = $methodKeys[0];
            $methodElement = $activatedMethods[$methodName];
            $data['attributes']['type'] = 'hidden';
            $data['attributes']['value'] = $methodName;
            $data['attributes']['class'] = 'ff_selected_payment_method';
            echo "<input ".$this->buildAttributes($data['attributes'], $form).">";
            do_action('fluentform_payment_method_render_'.$methodName, $methodElement, $form);
			return;
        }

        $elMarkup = '';

        $hasImageOption = false;

        $defaultValue = $this->extractValueFromAttributes($data);

        if (!isset($activatedMethods[$defaultValue])) {
            $defaultValue = key($activatedMethods);
        }

        if ($hasImageOption) {
            $data['settings']['container_class'] .= '';
            $elMarkup .= '<div class="ff_el_checkable_photo_holders">';
        }

        $firstTabIndex = \FluentForm\App\Helpers\Helper::getNextTabIndex();

        foreach ($activatedMethods as $methodName => $method) {
            $parentClass = "ff-el-form-check ff-el-payment-method-label";
            if ($methodName == $defaultValue) {
                $data['attributes']['checked'] = true;
                $parentClass .= ' ff_item_selected';
            } else {
                $data['attributes']['checked'] = false;
            }

            if ($firstTabIndex) {
                $data['attributes']['tabindex'] = $firstTabIndex;
                $firstTabIndex = '-1';
            }

            $data['attributes']['value'] = $methodName;
            $data['attributes']['type']  = 'radio';

            $methodLabel = ArrayHelper::get($method, 'settings.option_label.value');

            if($methodLabel) {
                $method['title'] = $methodLabel;
            }

            $atts = $this->buildAttributes($data['attributes']);

            $id = $this->getUniqueid(str_replace(['[', ']'], ['', ''], $data['attributes']['name']));

            if ($hasImageOption) {
                $parentClass .= ' ff-el-image-holder';
            }

            $elMarkup .= "<div class='{$parentClass}'>";
            // Here we can push the visual items
            if ($hasImageOption) {
                //$elMarkup .= "<label style='background-image: url({$available_methods[$methodName]['image']})' class='ff-el-image-input-src' for={$id}></label>";
            }

            $elMarkup .= "<label class='ff-el-form-check-label' for={$id}><input {$atts} id='{$id}'> <span>{$method['title']}</span></label>";
            $elMarkup .= "</div>";
        }

        if ($hasImageOption) {
            $elMarkup .= '</div>';
        }

        $html = $this->buildElementMarkup($elMarkup, $data, $form);
        echo apply_filters('fluenform_rendering_field_html_'.$elementName, $html, $data, $form);
    }
}
