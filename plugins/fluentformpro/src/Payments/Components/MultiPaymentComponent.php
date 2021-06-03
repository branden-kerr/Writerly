<?php

namespace FluentFormPro\Payments\Components;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Services\FormBuilder\BaseFieldManager;
use FluentForm\App\Services\FormBuilder\Components\Text;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentFormPro\Payments\PaymentHelper;

class MultiPaymentComponent extends BaseFieldManager
{
    public function __construct(
        $key = 'multi_payment_component',
        $title = 'Multi Payment Item',
        $tags = ['custom', 'payment', 'donation'],
        $position = 'payments'
    )
    {
        parent::__construct(
            $key,
            $title,
            $tags,
            $position
        );

        add_filter('fluentform_editor_init_element_multi_payment_component', function ($element) {
            if(!isset($element['settings']['layout_class'])) {
                $element['settings']['layout_class'] = '';
            }
            return $element;
        });

    }

    function getComponent()
    {
        return array(
            'index' => 8,
            'element' => $this->key,
            'attributes' => array(
                'type' => 'single', // single|radio|checkbox|select
                'name' => 'payment_input',
                'value' => '10',
            ),
            'settings' => array(
                'container_class' => '',
                'label' => __('Payment Item', 'fluentformpro'),
                'admin_field_label' => '',
                'label_placement' => '',
                'display_type' => '',
                'help_message' => '',
                'is_payment_field' => 'yes',
                'pricing_options' => array(
                    [
                        'label' => 'Payment Item 1',
                        'value' => 10,
                        'image' => ''
                    ]
                ),
                'price_label' => __('Price:', 'fluentformpro'),
                'enable_quantity' => false,
                'enable_image_input' => false,
                'is_element_lock' => false,
                'layout_class' => '',
                'validation_rules' => array(
                    'required' => array(
                        'value' => false,
                        'message' => __('This field is required', 'fluentformpro'),
                    ),
                ),
                'conditional_logics' => array(),
            ),
            'editor_options' => array(
                'title' => __('Payment Field', 'fluentformpro'),
                'icon_class' => 'ff-edit-shopping-cart',
                'element' => 'input-radio',
                'template' => 'inputMultiPayment'
            )
        );
    }

    public function getGeneralEditorElements()
    {
        return [
            'label',
            'label_placement',
            'admin_field_label',
            'placeholder',
            'pricing_options',
            'validation_rules',
        ];
    }

    public function getAdvancedEditorElements()
    {
        return [
            'container_class',
            'help_message',
            'name',
            'layout_class',
            'conditional_logics'
        ];
    }

    function render($data, $form)
    {
        $type = ArrayHelper::get($data, 'attributes.type');

        if ($type == 'single') {
            $this->renderSingleItem($data, $form);
            return '';
        }

        $this->renderMultiProduct($data, $form);
    }

    public function renderSingleItem($data, $form)
    {
        $elementName = $data['element'];
        $data = apply_filters('fluenform_rendering_field_data_' . $elementName, $data, $form);

        $inputAttributes = [
            'type' => 'hidden',
            'name' => $data['attributes']['name'],
            'value' => $data['attributes']['value'],
            'class' => 'ff_payment_item',
            'data-payment_item' => 'yes',
            'data-payment_value' => $data['attributes']['value'],
        ];


        $inputAttributes['id'] = $this->makeElementId($data, $form);

        $priceLabel = ArrayHelper::get($data, 'settings.price_label');
        $productPrice = ArrayHelper::get($data, 'attributes.value');

        if (!$productPrice) {
            $productPrice = 0;
        }

        $money = PaymentHelper::formatMoney(
            $productPrice * 100, PaymentHelper::getFormCurrency($form->id)
        );

        $elMarkup = $input = "<input " . $this->buildAttributes($inputAttributes, $form) . ">";

        $elMarkup .= '<span class="ff_item_price_wrapper"><span class="ff_product_price_label">' . $priceLabel . '</span>';
        $elMarkup .= ' <span class="ff_product_price">' . $money . '</span></span>';

        $html = $this->buildElementMarkup($elMarkup, $data, $form);
        echo apply_filters('fluenform_rendering_field_html_' . $elementName, $html, $data, $form);
    }

    public function renderMultiProduct($data, $form)
    {
        $elementName = $data['element'];

        $data = apply_filters('fluenform_rendering_field_data_' . $elementName, $data, $form);

        $data['attributes']['class'] = trim(
            'ff-el-form-check-input ' .
            'ff-el-form-check-'.$data['attributes']['type'].' '.
            ArrayHelper::get($data, 'attributes.class')
        );

        if ($data['attributes']['type'] == 'checkbox') {
            $data['attributes']['name'] = $data['attributes']['name'] . '[]';
        }

        $defaultValues = (array)$this->extractValueFromAttributes($data);

        $elMarkup = '';

        $firstTabIndex = \FluentForm\App\Helpers\Helper::getNextTabIndex();

        $formattedOptions = ArrayHelper::get($data, 'settings.pricing_options');

        $hasImageOption = ArrayHelper::get($data, 'settings.enable_image_input');

        $type = ArrayHelper::get($data, 'attributes.type');


        if ($type == 'select') {
            $selectAtts = [
                'name' => $data['attributes']['name'],
                'class' => 'ff-el-form-control ff_payment_item',
                'data-payment_item' => 'yes',
                'data-name' => $data['attributes']['name'],
                'id' => $this->getUniqueid(str_replace(['[', ']'], ['', ''], $data['attributes']['name']))
            ];

            if ($firstTabIndex) {
                $selectAtts['tabindex'] = $firstTabIndex;
            }

            $elMarkup .= '<select ' . $this->buildAttributes($selectAtts, $form) . '>';

            if($placeholder = ArrayHelper::get($data, 'settings.placeholder')) {
                $optionAtts = $this->buildAttributes([
                    'value' => '',
                    'data-payment_value' => '',
                    'data-calc_value' => ''
                ], $form);
                $elMarkup .= '<option '.$optionAtts.'>'.$placeholder.'</option>';
            }

        } else if ($hasImageOption) {
            $data['settings']['container_class'] .= '';
            $elMarkup .= '<div class="ff_el_checkable_photo_holders">';
        }

        $groupId = $this->makeElementId($data, $form);

        foreach ($formattedOptions as $index => $option) {
            if ($type == 'select') {
                if (!$defaultValues && $index == 0) {
                    $checked = true;
                } else {
                    $checked = in_array($option['value'], $defaultValues);
                }
                $optionAtts = $this->buildAttributes([
                    'value' => $option['label'],
                    'data-payment_value' => $option['value'],
                    'data-calc_value' => $option['value'],
                    'selected' => $checked
                ], $form);
                $elMarkup .= '<option ' . $optionAtts . '>' . $option['label'] . '</option>';
                continue;
            }

            $displayType = isset($data['settings']['display_type']) ? ' ff-el-form-check-' . $data['settings']['display_type'] : '';
            $parentClass = "ff-el-form-check{$displayType}";

            if (in_array($option['value'], $defaultValues)) {
                $data['attributes']['checked'] = true;
                $parentClass .= ' ff_item_selected';
            } else {
                $data['attributes']['checked'] = false;
            }

            if ($firstTabIndex) {
                $data['attributes']['tabindex'] = $firstTabIndex;
                $firstTabIndex = '-1';
            }

            $data['attributes']['class'] .= ' ff_payment_item';

            $data['attributes']['value'] = $option['label'];
            $data['attributes']['data-payment_value'] = $option['value'];
            $data['attributes']['data-calc_value'] = ArrayHelper::get($option, 'value');
            $data['attributes']['data-group_id'] = $groupId;

            $atts = $this->buildAttributes($data['attributes'], $form);
            $id = $this->getUniqueid(str_replace(['[', ']'], ['', ''], $data['attributes']['name']));

            if ($hasImageOption && $option['image']) {
                $parentClass .= ' ff-el-image-holder';
            }

            $elMarkup .= "<div class='{$parentClass}'>";
            // Here we can push the visual items
            if ($hasImageOption && $option['image']) {
                $elMarkup .= "<label style='background-image: url({$option['image']})' class='ff-el-image-input-src' for={$id}></label>";
            }

            $elMarkup .= "<label class='ff-el-form-check-label' for={$id}><input {$atts} id='{$id}'> <span>{$option['label']}</span></label>";
            $elMarkup .= "</div>";
        }

        if ($type == 'select') {
            $elMarkup .= '</select>';
        } else if ($hasImageOption) {
            $elMarkup .= '</div> ';
        }

        if($layoutClass = ArrayHelper::get($data, 'settings.layout_class')) {
            $data['settings']['container_class'] = $data['settings']['container_class'].' '.$layoutClass;
        }

        $html = $this->buildElementMarkup($elMarkup, $data, $form);
        
        echo apply_filters('fluenform_rendering_field_html_' . $elementName, $html, $data, $form);
    }
}
