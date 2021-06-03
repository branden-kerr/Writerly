<?php
namespace FluentFormPro\Components;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Helpers\Helper;
use FluentForm\App\Services\FormBuilder\BaseFieldManager;
use FluentForm\Framework\Helpers\ArrayHelper;

class NetPromoterScore extends BaseFieldManager
{

    public function __construct()
    {
        parent::__construct(
            'net_promoter_score',
            __('Net Promoter Score', 'fluentformpro'),
            ['net promoter score', 'score', 'survey', 'nps'],
            'advanced'
        );
    }

    public function getComponent()
    {
        return array(
            'index'          => 19,
            'element'        => $this->key,
            'attributes'     => array(
                'name'  => $this->key,
                'type' => 'radio',
                'value' => '',
                'id'    => '',
                'class' => ''
            ),
            'settings'       => array(
                'label'              => __('Net Promoter Score', 'fluentformpro'),
                'start_text'         => __('Not at all Likely', 'fluentformpro'),
                'end_text'           => __('Extremely Likely', 'fluentformpro'),
                'start_number'       => 0,
                'end_number'         => 10,
                'help_message'       => '',
                'label_placement'    => '',
                'admin_field_label'  => '',
                'container_class'    => '',
                'conditional_logics' => array(),
                'validation_rules'   => array(
                    'required' => array(
                        'value'   => false,
                        'message' => __('This field is required', 'fluentformpro'),
                    ),
                ),
            ),
            'options' => array (
                '0' => __('0', 'fluentformpro'),
                '1' => __('1', 'fluentformpro'),
                '2' => __('2', 'fluentformpro'),
                '3' => __('3', 'fluentformpro'),
                '4' => __('4', 'fluentformpro'),
                '5' => __('5', 'fluentformpro'),
                '6' => __('6', 'fluentformpro'),
                '7' => __('7', 'fluentformpro'),
                '8' => __('8', 'fluentformpro'),
                '9' => __('9', 'fluentformpro'),
                '10'=> __('10', 'fluentformpro')
            ),
            'editor_options' => array(
                'title'      => __('Net Promoter Score', 'fluentformpro'),
                'icon_class' => 'ff-edit-rating',
                'template'   => 'net_promoter',
            )
        );
    }


    public function getGeneralEditorElements()
    {
        return [
            'label',
            'admin_field_label',
            'start_text',
            'end_text',
            'label_placement',
            'validation_rules',
        ];
    }

    public function getAdvancedEditorElements()
    {
        return [
            'name',
            'help_message',
            'container_class',
            'class',
            'value',
            'conditional_logics',
        ];
    }

    public function generalEditorElement()
    {
        return [
            'start_text' => [
                'template'  => 'inputText',
                'label'     => 'Promoter Start Text',
                'help_text' => 'Start Indicator Text for Promoter Scale',
            ],
            'end_text' => [
                'template'  => 'inputText',
                'label'     => 'Promoter End Text',
                'help_text' => 'End Indicator Text for Promoter Scale',
            ]
        ];
    }

    public function advancedEditorElement()
    {
        return [];
    }

    public function render($data, $form)
    {
        $elementName = $data['element'];

        $data = apply_filters('fluenform_rendering_field_data_' . $elementName, $data, $form);

        $options = range(0,10,1);

        $elMarkup = '<table class="ff_net_table">';
        $elMarkup .= $this->getThead(
            $options,
            ArrayHelper::get($data, 'settings.start_text'),
            ArrayHelper::get($data, 'settings.end_text')
        );
        $elMarkup .= $this->getTbody($data, $options);
        $elMarkup .= '</table>';

        $html = $this->buildElementMarkup($elMarkup, $data, $form);
        echo apply_filters('fluenform_rendering_field_html_' . $elementName, $html, $data, $form);
    }

    private function getThead($options, $textStart, $textEnd)
    {
        ob_start();
        ?>
        <thead>
            <tr>
                <th colspan="<?php echo count($options); ?>">
                    <span class="ff_not-likely"><?php echo $textStart; ?></span>
                    <span class="ff_extremely-likely"><?php echo $textEnd; ?></span>
                </th>
            </tr>
        </thead>
        <?php
        return ob_get_clean();
    }

    private function getTbody($data, $options)
    {
        ob_start();
        ?>
        <tbody>
            <tr>
                <?php foreach ($options as $option): ?>
                <?php
                    $id = $this->getUniqueid(str_replace(['[', ']'], ['', ''], $data['attributes']['name'].'_'.$option));
                    $atts = [
                        'type' => 'radio',
                        'class' => 'ff-screen-reader-element',
                        'value' => $option,
                        'data-calc_value' => $option,
                        'id' => $id,
                        'name' =>  $data['attributes']['name']
                    ];
                    $atts = $this->buildAttributes($atts);
                ?>
                <td>
                    <input <?php echo $atts; ?>>
                    <label class='ff-el-net-label' for="<?php echo $id; ?>">
                        <span><?php echo $option; ?></span>
                    </label>
                </td>
                <?php endforeach; ?>
            </tr>
        </tbody>
        <?php
        return ob_get_clean();
    }
}
