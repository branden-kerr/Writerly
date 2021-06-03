<?php

namespace FluentFormPro\Payments\Components;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Services\FormBuilder\BaseFieldManager;
use FluentForm\App\Services\FormBuilder\Components\Text;
use FluentForm\Framework\Helpers\ArrayHelper;

class ItemQuantity extends BaseFieldManager
{
    public function __construct(
        $key = 'item_quantity_component',
        $title = 'Quantity',
        $tags = ['custom', 'payment', 'quantity'],
        $position = 'payments'
    )
    {
        parent::__construct(
            $key,
            $title,
            $tags,
            $position
        );
    }

    function getComponent()
    {
        return array(
            'index' => 6,
            'element' => $this->key,
            'attributes' => array(
                'type' => 'number',
                'name' => 'item-quantity',
                'value' => '',
                'id' => '',
                'class' => '',
                'placeholder' => '',
                'data-quantity_item' => 'yes'
            ),
            'settings' => array(
                'container_class' => '',
                'is_payment_field' => 'yes',
                'label' => __('Quantity', 'fluentformpro'),
                'admin_field_label' => '',
                'label_placement' => '',
                'help_message' => '',
                'number_step' => '',
                'prefix_label' => '',
                'suffix_label' => '',
                'target_product' => '',
                'validation_rules' => array(
                    'required' => array(
                        'value' => false,
                        'message' => __('This field is required', 'fluentformpro'),
                    ),
                    'numeric' => array(
                        'value' => true,
                        'message' => __('This field must contain numeric value', 'fluentformpro'),
                    ),
                    'min' => array(
                        'value' => '',
                        'message' => __('Minimum value is ', 'fluentformpro'),
                    ),
                    'max' => array(
                        'value' => '',
                        'message' => __('Maximum value is ', 'fluentformpro'),
                    ),
                ),
                'conditional_logics' => array()
            ),
            'editor_options' => array(
                'title' => __('Item Quantity', 'fluentformpro'),
                'icon_class' => 'ff-edit-keyboard-o',
                'template' => 'inputText'
            ),
        );
    }

    public function getGeneralEditorElements()
    {
        return [
            'label',
            'label_placement',
            'admin_field_label',
            'placeholder',
            'target_product',
            'validation_rules'
        ];
    }

    public function getAdvancedEditorElements()
    {
        return [
            'value',
            'container_class',
            'class',
            'help_message',
            'number_step',
            'prefix_label',
            'suffix_label',
            'name',
            'conditional_logics',
            'calculation_settings'
        ];
    }

    public function getEditorCustomizationSettings()
    {
        return [
            'target_product' => array(
                'template'  => 'targetProduct',
                'label' => __('Product Field Mapping', 'fluentformpro'),
                'help_text' => __('Select which Product this field is tied to', 'fluentformpro'),
            )
        ];
    }

    function render($data, $form)
    {
        $data['attributes']['class'] .= ' ff_quantity_item';
        $data['attributes']['data-target_product'] = ArrayHelper::get($data, 'settings.target_product');

        if(!ArrayHelper::get($data, 'settings.validation_rules.min.value') == '') {
            ArrayHelper::set($data, 'settings.validation_rules.min.value', 0);
        }

        ArrayHelper::set($data, 'attributes.min', ArrayHelper::get($data, 'settings.validation_rules.min.value'));

        if(ArrayHelper::get($data, 'settings.validation_rules.max.value')) {
            ArrayHelper::set($data, 'attributes.max', ArrayHelper::get($data, 'settings.validation_rules.max.value'));
        }

        return (new Text())->compile($data, $form);
    }
}