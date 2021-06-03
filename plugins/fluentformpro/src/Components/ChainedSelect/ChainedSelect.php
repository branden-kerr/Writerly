<?php

namespace FluentFormPro\Components\ChainedSelect;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Services\FormBuilder\BaseFieldManager;
use FluentForm\Framework\Helpers\ArrayHelper;

class ChainedSelect extends BaseFieldManager
{
    public function __construct()
    {
        parent::__construct(
            'chained_select',
            'Chained Select',
            ['chained', 'select', 'csv', 'progressive'],
            'advanced'
        );

        add_action('wp_enqueue_scripts', function () {
            wp_register_script(
                'fluentform-chained-element-script',
                FLUENTFORMPRO_DIR_URL . 'public/js/chainedSelectScript.js',
                ['jquery'],
                FLUENTFORMPRO_VERSION,
                true
            );
        });

        add_filter(
            'fluentform_response_render_' . $this->key, array($this, 'renderResponse'), 10, 4
        );
    }

    public function getComponent()
    {
        return [
            'index'          => 20,
            'element'        => $this->key,
            'attributes'     => [
                'name'        => $this->key,
                'class'       => '',
                'value'       => '',
                'data-type'   => 'chained-select',
                'type'        => 'chained-select',
                'placeholder' => __('Select Parent | Select Child', 'fluentformpro')
            ],
            'settings'       => [
                'container_class'    => '',
                'label'              => $this->title,
                'label_placement'    => '',
                'help_message'       => '',
                'data_source'        => [
                    'name'     => '',
                    'url'      => '',
                    'type'     => 'file',
                    'meta_key' => null,
                    'headers'  => ['Parent', 'Child', 'Grand Child'],
                    'options'  => []
                ],
                'admin_field_label'  => '',
                'validation_rules'   => [
                    'required' => [
                        'value'   => false,
                        'message' => __('This field is required', 'fluentformpro'),
                    ]
                ],
                'conditional_logics' => []
            ],
            'editor_options' => [
                'title'      => $this->title . ' Field',
                'icon_class' => 'ff-edit-link',
                'template'   => 'chainedSelect'
            ],
        ];
    }

    public function getGeneralEditorElements()
    {
        return [
            'label',
            'admin_field_label',
            'data_source',
            'value',
            'label_placement',
            'validation_rules',
        ];
    }

    public function generalEditorElement()
    {
        return [
            'data_source' => [
                'template'  => 'chainSelectDataSource',
                'label'     => 'CSV Data Source',
                'help_text' => 'Upload your chained select CSV file or provide a remote URL'
            ]
        ];
    }

    function render($data, $form)
    {
        wp_enqueue_script('fluentform-chained-element-script');

        $elementName = $data['element'];

        $data = apply_filters('fluenform_rendering_field_data_' . $elementName, $data, $form);

        $rootName = $data['attributes']['name'];

        $hasConditions = $this->hasConditions($data) ? 'has-conditions ' : '';

        $elementClass = ArrayHelper::get($data, 'attributes.class');

        $data['attributes']['class'] = '';

        $data['attributes']['class'] .= $hasConditions;

        $data['attributes']['class'] .= ' ff-field_container ff-chained-select-field-wrapper';

        if ($wrapperClass = ArrayHelper::get($data, 'settings.container_class')) {
            $data['attributes']['class'] .= ' ' . $wrapperClass;
        }

        $atts = $this->buildAttributes(
            ArrayHelper::except($data['attributes'], ['name', 'type', 'placeholder'])
        );

        $html = "<div {$atts}>";

        $html .= "<div class='ff-t-container'>";

        $labelPlacement = ArrayHelper::get($data, 'settings.label_placement');

        $labelPlacementClass = '';

        if ($labelPlacement) {
            $labelPlacementClass = ' ff-el-form-' . $labelPlacement;
        }

        list($headers, $content) = $this->getCsvData($data, $form);

        foreach ($headers as $key => $field) {
            $element = [
                'settings'   => $data['settings'],
                'attributes' => $data['attributes']
            ];

            $element['settings']['label'] = $field;

            $element['attributes']['name'] = $rootName . '[' . $field . ']';

            $element['attributes']['class'] = 'ff-el-form-control ' . $elementClass;

            if ($tabIndex = \FluentForm\App\Helpers\Helper::getNextTabIndex()) {
                $element['attributes']['tabindex'] = $tabIndex;
            }

            $element['settings']['container_class'] = $labelPlacementClass;

            $element['attributes']['id'] = $this->makeElementId($element, $form);

            $options = "<option value=''>$field</option>";

            if ($key == 0) {
                foreach (array_unique(array_column($content, $field)) as $value) {
                    $options .= "<option value='$value'>$value</option>";
                }
            }

            $elementAttributes = ArrayHelper::except(
                    $element['attributes'], ['type', 'data-type', 'placeholder']
                ) + [
                    'data-index' => $key,
                    'data-meta_key' => $element['settings']['data_source']['meta_key']
                ];

            $elementAttributes['class'] = $elementAttributes['class'] . ' el-chained-select';

            $elementAttributes['data-key'] = $field;

            $elementAttributes = $this->buildAttributes($elementAttributes);

            $elMarkup = "<select disabled " . $elementAttributes . ">$options</select>";

            $markup = $this->buildElementMarkup($elMarkup, $element, $form);

            $html .= "<div class='ff-t-cell'>{$markup}</div>";
        }

        $html .= "</div>";
        $html .= "</div>";

        echo apply_filters('fluenform_rendering_field_html_' . $elementName, $html, $data, $form);
    }

    protected function getCsvData($element, $form)
    {
        if (!class_exists('CSVParser')) {
            require_once(FLUENTFORMPRO_DIR_PATH . 'libs/CSVParser/CSVParser.php');
        }

        $csvParser = new \CSVParser;

        $path = wp_upload_dir()['basedir'] . FLUENTFORM_UPLOAD_DIR;

        $metaKey = $element['settings']['data_source']['meta_key'];

        $target = $path . '/' . $metaKey . '_' . $form->id . '.csv';

        if (file_exists($target)) {
            $content = file_get_contents($target);

            $csvParser->load_data($content);

            $result = $csvParser->parse($csvParser->find_delimiter());

            $headers = array_shift($result);

            foreach ($result as $key => $value) {
                $result[$key] = array_combine($headers, $value);
            }

            return [$headers, $result];
        }

        return [['Parent', 'Child', 'Grand Child'], []];
    }

    public function renderResponse($response, $field, $form_id, $isHtml = false) {
        if (!$response) {
            return $response;
        }

        $response = (array) $response;
        $response = array_filter($response);
        
        if (!$response) {
            return '';
        }

        if (!$isHtml) {
            return fluentImplodeRecursive(', ', $response);
        }

        $html = $html = '<ul class="ff_entry_list">';
        foreach ($response as $label => $response) {
            $html .= '<li>'.$label.': '.$response.'</li>';
        }
        $html .= '</ul>';
        
        return $html;
    }
}
