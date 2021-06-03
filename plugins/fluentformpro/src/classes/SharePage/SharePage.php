<?php

namespace FluentFormPro\classes\SharePage;

use FluentForm\App;
use FluentForm\App\Helpers\Helper;
use FluentForm\App\Modules\Acl\Acl;
use FluentForm\Framework\Helpers\ArrayHelper;

class SharePage
{
    public $metaKey = '_landing_page_settings';

    public function boot()
    {
        $enabled = $this->isEnabled();

        add_action('wp', [$this, 'renderLandingForm']);

        add_filter('fluentform_global_addons', function ($addOns) use ($enabled) {
            $addOns['sharePages'] = [
                'title'       => 'Landing Pages',
                'description' => 'Create completely custom "distraction-free" form landing pages to boost conversions',
                'logo'        => App::publicUrl('img/integrations/landing_pages.png'),
                'enabled'     => ($enabled) ? 'yes' : 'no',
                'config_url'  => '',
                'category'    => 'wp_core'
            ];
            return $addOns;
        }, 9);

        if (!$enabled) {
            return;
        }

        add_filter('fluentform_form_settings_menu', function ($menu) {
            $menu['landing_pages'] = [
                'title' => __('Landing Page', 'fluentformpro'),
                'slug'  => 'form_settings',
                'hash'  => 'landing_pages',
                'route' => '/landing_pages'
            ];
            return $menu;
        });

        add_action('wp_ajax_ff_get_landing_page_settings', [$this, 'getSettingsAjax']);
        add_action('wp_ajax_ff_store_landing_page_settings', [$this, 'saveSettingsAjax']);

    }

    public function getSettingsAjax()
    {
        $formId = intval($_REQUEST['form_id']);
        Acl::verify('fluentform_forms_manager', $formId);
        $settings = $this->getSettings($formId);

        $shareUrl = '';
        if ($settings['status'] == 'yes') {
            $params = [
                'ff_landing' => $formId
            ];
            $shareUrl = add_query_arg($params, site_url());
        }

        wp_send_json_success([
            'settings'  => $settings,
            'share_url' => $shareUrl
        ]);
    }

    public function saveSettingsAjax()
    {
        $formId = intval($_REQUEST['form_id']);
        Acl::verify('fluentform_forms_manager', $formId);
        $settings = $_REQUEST['settings'];
        $formattedSettings = wp_unslash($settings);
        $formattedSettings['description'] = wp_kses_post($settings['description']);
        Helper::setFormMeta($formId, $this->metaKey, $formattedSettings);

        $shareUrl = '';
        if ($formattedSettings['status'] == 'yes') {
            $shareUrl = add_query_arg(['ff_landing' => $formId], site_url());
        }

        wp_send_json_success([
            'message'   => __('Settings successfully updated'),
            'share_url' => $shareUrl
        ]);
    }

    public function getSettings($formId)
    {
        $settings = Helper::getFormMeta($formId, $this->metaKey, []);

        $defaults = [
            'status'           => 'no',
            'logo'             => '',
            'title'            => '',
            'description'      => '',
            'color_schema'     => '#4286c4',
            'custom_color'     => '#4286c4',
            'design_style'     => 'modern',
            'featured_image'   => '',
            'background_image' => ''
        ];

        return wp_parse_args($settings, $defaults);
    }

    public function renderLandingForm()
    {
        $ff_landing = ArrayHelper::get($_GET, 'ff_landing');

        if (!$ff_landing || is_admin()) {
            return;
        }

        $hasConfirmation = false;
        if (isset($_REQUEST['entry_confirmation'])) {
            do_action('fluentformpro_entry_confirmation', $_REQUEST);
            $hasConfirmation = true;
        }

        $formId = intval($_GET['ff_landing']);

        $form = wpFluent()->table('fluentform_forms')->where('id', $formId)->first();

        if (!$form) {
            return;
        }

        $settings = $this->getSettings($formId);


        if (ArrayHelper::get($settings, 'status') != 'yes') {
            return;
        }

        $pageTitle = $form->title;

        if ($settings['title']) {
            $pageTitle = $settings['title'];
        }

        add_action('wp_enqueue_scripts', function () use ($formId) {
            do_action('fluentform_load_form_assets', $formId);
            wp_enqueue_style('fluent-form-styles');
            wp_enqueue_style('fluentform-public-default');
            wp_enqueue_script('fluent-form-submission');
        });

        $backgroundColor = ArrayHelper::get($settings, 'color_schema');

        if ($backgroundColor == 'custom') {
            $backgroundColor = ArrayHelper::get($settings, 'custom_color');
        }


        $landingContent = '[fluentform id="' . $formId . '"]';
        if(!$hasConfirmation) {
            $salt = ArrayHelper::get($settings, 'share_url_salt');
            if($salt && $salt != ArrayHelper::get($_REQUEST, 'form')) {
                $landingContent = __('Sorry, You do not have access to this form', 'fluentformpro');
                $pageTitle = __('No Access', 'fluentformpro');
                $settings['title'] = '';
                $settings['description'] = '';
            }
        }

        $landingVars = apply_filters('fluentform_landing_vars', [
            'settings'        => $settings,
            'title'           => $pageTitle,
            'form_id'         => $formId,
            'form'            => $form,
            'bg_color'        => $backgroundColor,
            'landing_content' => $landingContent,
            'has_header'      => $settings['logo'] || $settings['title'] || $settings['description']
        ], $formId);

        $this->loadPublicView($landingVars);
    }

    public function loadPublicView($landingVars)
    {
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_style(
                'fluent-form-landing',
                FLUENTFORMPRO_DIR_URL . 'public/css/form_landing.css',
                [],
                FLUENTFORMPRO_VERSION
            );
        });

        add_filter('pre_get_document_title', function ($title) use ($landingVars) {
            $separator = apply_filters('document_title_separator', '-');
            return $landingVars['title'] . ' ' . $separator . ' ' . get_bloginfo('name', 'display');
        });

        status_header(200);
        echo $this->loadView('landing_page_view', $landingVars);
        exit(200);
    }

    public function loadView($view, $data = [])
    {
        $file = FLUENTFORMPRO_DIR_PATH . 'src/views/' . $view . '.php';
        extract($data);
        ob_start();
        include($file);
        return ob_get_clean();
    }

    public function isEnabled()
    {
        $globalModules = get_option('fluentform_global_modules_status');

        $sharePages = ArrayHelper::get($globalModules, 'sharePages');

        if (!$sharePages || $sharePages == 'yes') {
            return true;
        }

        return false;
    }
}
