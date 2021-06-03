<?php

namespace FluentFormPro\classes;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class ConditionalContent
{
    private static $entryId;
    private static $formData;
    private static $form;

    public static function handle($atts, $content)
    {
        $shortcodeDefaults = apply_filters('fluentform_conditional_shortcode_defaults', array(
            'field' => '',
            'is' => '',
            'to' => ''
        ), $atts);

        extract(shortcode_atts($shortcodeDefaults, $atts));

        if(!$field || !$is || !$to) {
            return '';
        }

        $operatorMaps = [
            'equal' => '=',
            'not_equal' => '!=',
            'greater_than' => '>',
            'less_than' => '<',
            'greater_or_equal' => '>=',
            'less_or_equal' => '<=',
            'starts_with' => 'startsWith',
            'ends_with' => 'endsWith',
            'contains' => 'contains',
            'not_contains' => 'doNotContains'
        ];

        if(!isset($operatorMaps[$is])) {
            return '';
        }

        $is = $operatorMaps[$is];

        $condition = [
            'conditionals' => [
                'status'     => true,
                'type'       => 'any',
                'conditions' => [
                    [
                        "field"    => $field,
                        "operator" => $is,
                        "value"    => $to
                    ]
                ]
            ]
        ];

        if (\FluentForm\App\Services\ConditionAssesor::evaluate($condition, static::$formData)) {
            return do_shortcode($content);
        }

        return '';
    }


    public static function initiate($content, $entryId, $formData, $form)
    {
        if(!has_shortcode($content, 'ff_if') || !$content) {
            return $content;
        }

        static::$entryId = $entryId;
        static::$formData = $formData;

        static::$form = $form;
        return do_shortcode($content);
    }
}