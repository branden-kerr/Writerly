<?php

namespace FluentFormPro\classes;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Helpers\Helper;
use FluentForm\App\Modules\Acl\Acl;
use FluentForm\App\Modules\Form\FormFieldsParser;
use FluentForm\Framework\Helpers\ArrayHelper;

class FormStyler
{

    public function boot()
    {
        add_action('fluentform_form_styler', array($this, 'initStyler'));
        add_action('wp_enqueue_scripts', array($this, 'addAdvancedCSS'));
        add_action('wp_ajax_fluentform_save_form_styler', array($this, 'saveStylerSettings'));
        add_action('wp_ajax_fluentform_get_form_styler', array($this, 'getStylerSettings'));
        add_action('fluentform_init_custom_stylesheet', array($this, 'pushStyleSheet'), 10, 2);

        add_action('fluentform_form_imported', array($this, 'maybeGenerateStyle'), 10, 1);
        add_action('flentform_form_duplicated', array($this, 'maybeGenerateStyle'), 10, 1);
    }

    public function pushStyleSheet($selectedStyle, $formId)
    {
        if ($selectedStyle) {

            add_filter('fluentform_form_class', function ($formClass, $form) use ($formId, $selectedStyle) {
                if ($form->id == $formId) {
                    $formClass .= ' ' . $selectedStyle;
                }
                return $formClass;
            }, 10, 2);

            $presets = $this->getPresets();

            if (isset($presets[$selectedStyle]) && $src = ArrayHelper::get($presets[$selectedStyle], 'src')) {
                wp_enqueue_style('fluent_skin_' . $selectedStyle, $src, [], FLUENTFORMPRO_VERSION);
            }
        }

    }

    public function addAdvancedCSS()
    {
        $skins = $this->getPresets();
        foreach ($skins as $skinName => $skin) {
            if ($skin['src']) {
                wp_register_style('fluent_skin_' . $skinName, $skin['src'], [], FLUENTFORMPRO_VERSION);
            }
        }

        if (isset($_GET['fluent_forms_pages']) && isset($_GET['preview_id'])) {
            $skins = $this->getPresets();
            foreach ($skins as $skinName => $skin) {
                if ($skin['src']) {
                    wp_enqueue_style('fluent_skin_' . $skinName);
                }
            }
            add_action('wp_head', function () {
                do_action('fluentform_load_form_assets', intval($_GET['preview_id']));
            }, 99);
        }
    }

    public function initStyler($formId)
    {
        wp_enqueue_style('fluentform_styler', FLUENTFORMPRO_DIR_URL . 'public/css/styler_app.css', array(), FLUENTFORMPRO_VERSION);
        wp_enqueue_script('fluentform_styler', FLUENTFORMPRO_DIR_URL . 'public/js/styler_app.js', array('jquery'), FLUENTFORMPRO_VERSION);
        wp_enqueue_style('dashicons');

        wp_localize_script('fluentform_styler', 'fluent_styler_vars', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'form_id' => $formId
        ]);

        echo '<div id="ff_form_styler"><ff-styler-app :form_vars="form_vars"></ff-styler-app></div>';
    }

    public function getStylerSettings()
    {
        Acl::verify('fluentform_forms_manager');
        $formId = intval($_REQUEST['form_id']);
        $presetStyle = Helper::getFormMeta($formId, '_ff_selected_style', '');
        $styles = Helper::getFormMeta($formId, '_ff_form_styles', []);

        $preSets = $this->getPresets();

        $returnData = [
            'preset_style' => $presetStyle,
            'styles' => $styles,
            'presets' => $preSets,
            'is_multipage' => Helper::isMultiStepForm($formId),
            'has_section_break' => Helper::hasFormElement($formId, 'section_break'),
            'has_tabular_grid' => Helper::hasFormElement($formId, 'tabular_grid'),
            'has_range_slider' => Helper::hasFormElement($formId, 'rangeslider'),
            'has_net_promoter' => Helper::hasFormElement($formId, 'net_promoter_score')
        ];

        if(!empty($_REQUEST['with_all_form_styles'])) {
            $returnData['existing_form_styles'] = $this->getOtherFormStyles($formId);
        }

        wp_send_json_success($returnData, 200);
    }

    public function saveStylerSettings()
    {
        Acl::verify('fluentform_forms_manager');

        $formId = intval($_REQUEST['form_id']);
        $styleType = sanitize_text_field($_REQUEST['style_name']);
        $styles = wp_unslash($_REQUEST['form_styles']);
        Helper::setFormMeta($formId, '_ff_selected_style', $styleType);

        if ($styleType != 'ffs_custom') {
            $styles = ArrayHelper::only($styles, ['container_styles', 'asterisk_styles', 'help_msg_style', 'success_msg_style', 'error_msg_style']);
        }

        Helper::setFormMeta($formId, '_ff_form_styles', $styles);
        $stylerGenerator = new FormStylerGenerator();
        $css = $stylerGenerator->generateFormCss('.fluentform_wrapper_' . $formId, $styles);
        $css = trim($css);

        Helper::setFormMeta($formId, '_ff_form_styler_css', $css);
        do_action('fluentform_after_style_generated', $formId);

        wp_send_json_success([
            'message' => __('Styles successfully updated', 'fluentformpro')
        ], 200);
    }

    public function getPresets()
    {
        $presets = [
            '' => [
                'label' => __('Default', ''),
                'src' => ''
            ],
            'ffs_modern_b' => [
                'label' => __('Modern (Bold)', ''),
                'src' => FLUENTFORMPRO_DIR_URL . 'public/css/skin_modern_bold.css'
            ],
            'ffs_modern_l' => [
                'label' => __('Modern (Light)', ''),
                'src' => FLUENTFORMPRO_DIR_URL . 'public/css/skin_modern_light.css'
            ],
            'ffs_classic' => [
                'label' => __('Classic', ''),
                'src' => FLUENTFORMPRO_DIR_URL . 'public/css/skin_classic.css'
            ],
            'ffs_bootstrap' => [
                'label' => __('Bootstrap Style', ''),
                'src' => FLUENTFORMPRO_DIR_URL . 'public/css/skin_bootstrap.css'
            ],
        ];

        $presets = apply_filters('fluentform_style_preses', $presets);

        $presets['ffs_custom'] = [
            'label' => __('Custom (Advanced Customization)', ''),
            'src' => ''
        ];

        return $presets;
    }

    public function maybeGenerateStyle($formId)
    {
        // check if the form has custom styler
        $styles = Helper::getFormMeta($formId, '_ff_form_styles');
        if ($styles) {
            $stylerGenerator = new FormStylerGenerator();
            $css = $stylerGenerator->generateFormCss('.fluentform_wrapper_' . $formId, $styles);
            Helper::setFormMeta($formId, '_ff_form_styler_css', $css);
            do_action('fluentform_after_style_generated', $formId);
        }
    }

    private function getOtherFormStyles($callerFormId)
    {
        $customStyles = wpFluent()->table('fluentform_form_meta')
            ->select([
                'fluentform_form_meta.value',
                'fluentform_form_meta.form_id',
                'fluentform_forms.title'
            ])
            ->where('fluentform_form_meta.form_id', '!=', $callerFormId)
            ->where('fluentform_form_meta.meta_key', '_ff_form_styles')
            ->join('fluentform_forms', 'fluentform_forms.id', '=', 'fluentform_form_meta.form_id')
            ->get();

        $validFormSelectors = wpFluent()->table('fluentform_form_meta')
            ->select([
                'value',
                'form_id',
                'value'
            ])
            ->where('fluentform_form_meta.form_id', '!=', $callerFormId)
            ->where('fluentform_form_meta.meta_key', '_ff_selected_style')
            ->where('fluentform_form_meta.meta_key', '!=', '')
            ->get();

        $styles = [];
        foreach ($validFormSelectors as $formSelector) {
            if(!$formSelector->value || $formSelector->value == '""') {
                continue;
            }
            $selectorType = str_replace('"', '', $formSelector->value);
            $styles[$formSelector->form_id] = [
                'type' => $selectorType,
                'is_custom' => $selectorType == 'ffs_custom',
                'form_id' => $formSelector->form_id
            ];
        }

        $formattedStyles = [
            'custom' => [],
            'predefined' => []
        ];

        foreach ($customStyles as $style) {
            if(!isset($styles[$style->form_id])) {
                continue;
            }
            $existingStyle = $styles[$style->form_id];
            $existingStyle['form_title'] = $style->title;
            $existingStyle['styles'] = json_decode($style->value, true);
            if($existingStyle['is_custom']) {
                $formattedStyles['custom'][$style->form_id] = $existingStyle;
            } else {
                $formattedStyles['predefined'][$style->form_id] = $existingStyle;
            }
        }

        return $formattedStyles;
    }

}
