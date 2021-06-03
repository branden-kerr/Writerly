<?php

namespace FluentFormPro\Components\Post\Components;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Services\FormBuilder\BaseFieldManager;
use FluentForm\Framework\Helpers\ArrayHelper;

class PostTitle extends BaseFieldManager
{
    public function __construct()
    {
        parent::__construct(
            'post_title',
            'Post Title',
            ['title', 'post_title', 'post title'],
            'post'
        );
    }

    function getComponent()
    {
        return [
            'index' => 0,
            'element' => $this->key,
            'attributes' => [
                'name' => $this->key,
                'class' => '',
                'value' => '',
                'type' => 'text',
                'placeholder' => ''
            ],
            'settings' => [
                'container_class' => '',
                'placeholder' => '',
                'label' => $this->title,
                'label_placement' => '',
                'help_message' => '',
                'admin_field_label' => '',
                'validation_rules' => [
                    'required' => [
                        'value' => false,
                        'message' => __('This field is required', 'fluentformpro'),
                    ]
                ],
                'conditional_logics' => []
            ],
            'editor_options' => [
                'title' => $this->title,
                'icon_class' => 'ff-edit-text',
                'template' => 'inputText'
            ],
        ];
    }

    public function getGeneralEditorElements()
    {
        return [
            'label',
            'admin_field_label',
            'placeholder',
            'value',
            'label_placement',
            'validation_rules',
        ];
    }

    public function render($data, $form)
    {
        $elementName = $data['element'];

        $data = apply_filters('fluenform_rendering_field_data_' . $elementName, $data, $form);

        $data['attributes']['class'] = @trim('ff-el-form-control ' . $data['attributes']['class']);

        $data['attributes']['id'] = $this->makeElementId($data, $form);

        $data['attributes']['tabindex'] = \FluentForm\App\Helpers\Helper::getNextTabIndex();

        $elMarkup = "<input " . $this->buildAttributes($data['attributes'], $form) . ">";

        $html = $this->buildElementMarkup($elMarkup, $data, $form);

        echo apply_filters('fluenform_rendering_field_html_' . $elementName, $html, $data, $form);
    }

    public function pushTags($tags, $form)
    {
        if ($form->type != 'post') {
            return $tags;
        }
        $tags[$this->key] = $this->tags;
        return $tags;
    }
}
