<?php
/*
Plugin Name: Fluent Forms Pro Add On Pack
Description: The Pro version of FluentForm, the most advanced, drag and drop form builder plugin for WordPress.
Version: 3.6.68
Author: WP Fluent Forms
Author URI: https://wpfluentforms.com
Plugin URI: https://wpfluentforms.com/
License: GPLv2 or later
Text Domain: fluentformpro
Domain Path: /resources/languages
*/

defined('ABSPATH') or die;

define('FLUENTFORMPRO', true);
define('FLUENTFORMPRO_VERSION', '3.6.68');
define('FLUENTFORM_UPLOAD_DIR', '/fluentform');
define('FLUENTFORMPRO_DIR_URL', plugin_dir_url(__FILE__));
define('FLUENTFORMPRO_DIR_PATH', plugin_dir_path(__FILE__));
define('FLUENTFORMPRO_DIR_FILE', __FILE__);

include FLUENTFORMPRO_DIR_PATH . 'autoload.php';

if (!class_exists('FluentFormPro')) {

    class FluentFormPro
    {
        /**
         * Add paths/directory names in $addOns to any add addons where a Bootstrap.php file
         * is available to initialize the addon. Following entries are addon directory names.
         *
         * @var $addOns array
         */
        protected $addOns = array(
            'FluentFormPro\Integrations\ActiveCampaign',
            'FluentFormPro\Integrations\CampaignMonitor',
            'FluentFormPro\Integrations\ConstantContact',
            'FluentFormPro\Integrations\ConvertKit',
            'FluentFormPro\Integrations\GetResponse',
            'FluentFormPro\Integrations\Hubspot',
            'FluentFormPro\Integrations\IContact',
            'FluentFormPro\Integrations\MooSend',
            'FluentFormPro\Integrations\Platformly',
            'FluentFormPro\Integrations\WebHook',
            'FluentFormPro\Integrations\Zapier',
            'FluentFormPro\Integrations\SendFox',
            'FluentFormPro\Integrations\MailerLite',
            'FluentFormPro\Integrations\SMSNotification',
            'FluentFormPro\Integrations\GetGist',
            'FluentFormPro\Integrations\GoogleSheet',
            'FluentFormPro\Integrations\Trello',
            'FluentFormPro\Integrations\Drip',
            // 'FluentFormPro\Integrations\Aweber',
            'FluentFormPro\Integrations\Sendinblue',
            'FluentFormPro\Integrations\UserRegistration',
            'FluentFormPro\Integrations\Automizy',
            'FluentFormPro\Integrations\Telegram'
        );

        /**
         * Extra elements in Pro version
         * @var $proElements array
         */
        protected $proElements = array(
            'shortcode',
            'form_step',
            'input_file',
            'input_image',
            'input_repeat',
            'action_hook',
        );

        /**
         * Bootstrap the FluentFormPro Plugin
         * @param FluentForm\Framework\Foundation\Application $app
         * @return void
         */
        public function boot()
        {
            if (!defined('FLUENTFORM')) {
                $this->injectDependency();
                return;
            }

            if (!defined('FLUENTFORM_HAS_NIA')) {
                return add_action('admin_notices', function () {
                    $class = 'notice notice-error';
                    $message = 'You are using old version of WP Fluent Forms. Please update to latest from your plugins list';
                    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
                });
            }

            if (function_exists('wpFluentForm')) {
                $this->registerHooks(wpFluentForm());
            }

        }

        protected function registerHooks($fluentForm)
        {
            $this->ajaxHooks($fluentForm);
            $this->adminHooks($fluentForm);
            $this->publicHooks($fluentForm);
            $this->commonHooks($fluentForm);
            $this->registerAddOns($fluentForm);

            add_action('wp_enqueue_scripts', array($this, 'registerScripts'), 999);

            new \FluentFormPro\Components\PhoneField();
            new \FluentFormPro\Components\CustomSubmitField();
            new \FluentFormPro\Components\RangeSliderField();
            new \FluentFormPro\Components\NetPromoterScore();
            new \FluentFormPro\Components\ChainedSelect\ChainedSelect();
            new \FluentFormPro\Components\ColorPicker();
            new \FluentFormPro\Components\RepeaterField();
            new \FluentFormPro\Components\PostSelectionField();

            /*
             * Complience Settings here
             */
            add_action('fluentform_global_notify_completed', function ($entryId, $form) {
                if (\FluentForm\App\Helpers\Helper::isEntryAutoDeleteEnabled($form->id)) {
                    $entriesClass = new \FluentForm\App\Modules\Entries\Entries();
                    $entriesClass->deleteEntryById($entryId, $form->id);
                }
            }, 10, 2);

            /*
             * Form Styler
             */
            (new \FluentFormPro\classes\FormStyler)->boot();

            /*
             * Form Landing Pages
             */
            (new \FluentFormPro\classes\SharePage\SharePage)->boot();

            /*
             * Boot Payment Module
             */
            (new \FluentFormPro\Payments\PaymentHandler)->init();


            if (defined('BP_VERSION')) {
                (new \FluentFormPro\Integrations\BuddyIntegration\FluentFormBuddyBoss())->init();
            }

        }

        /**
         * Notify the user about the FluentForm dependency and instructs to install it.
         */
        protected function injectDependency()
        {
            add_action('admin_notices', function () {
                $pluginInfo = $this->getFluentFormInstallationDetails();

                $class = 'notice notice-error';

                $install_url_text = 'Click Here to Install the Plugin';

                if ($pluginInfo->action == 'activate') {
                    $install_url_text = 'Click Here to Activate the Plugin';
                }

                $message = 'FluentForm PRO Add-On Requires FluentForm Base Plugin, <b><a href="' . $pluginInfo->url
                    . '">' . $install_url_text . '</a></b>';

                printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
            });
        }

        /**
         * Get the FluentForm plugin installation information e.g. the URL to install.
         *
         * @return \stdClass $activation
         */
        protected function getFluentFormInstallationDetails()
        {
            $activation = (object)[
                'action' => 'install',
                'url'    => ''
            ];

            $allPlugins = get_plugins();

            if (isset($allPlugins['fluentform/fluentform.php'])) {
                $url = wp_nonce_url(
                    self_admin_url('plugins.php?action=activate&plugin=fluentform/fluentform.php'),
                    'activate-plugin_fluentform/fluentform.php'
                );

                $activation->action = 'activate';
            } else {
                $api = (object)[
                    'slug' => 'fluentform'
                ];

                $url = wp_nonce_url(
                    self_admin_url('update.php?action=install-plugin&plugin=' . $api->slug),
                    'install-plugin_' . $api->slug
                );
            }

            $activation->url = $url;

            return $activation;
        }

        /**
         * Register admin/backend hooks
         * @return void
         */
        public function adminHooks($app)
        {
            add_filter('fluentform_disabled_components', [$this, 'filterDisabledComponents']);

            add_action('wp_ajax_fluentform_update_entry', function () {
                $formId = intval($_REQUEST['form_id']);
                \FluentForm\App\Modules\Acl\Acl::verify('fluentform_entries_viewer', $formId);
                \FluentFormPro\classes\EntryEditor::editEntry();
            });


            (new \FluentFormPro\classes\ResendNotificationHandler())->init();

            \FluentFormPro\classes\StepFormEntries::boot($app);
        }

        /**
         * Register public/frontend hooks
         * @return void
         */
        public function publicHooks($app)
        {
            $this->registerProElementsRenderingHook($app);
        }

        /**
         * Registers common hooks.
         */
        public function commonHooks($app)
        {
            $app->addfilter('fluentform_validations', function ($validations, $form) use ($app) {
                return (new \FluentFormPro\Uploader($app))->prepareValidations($validations, $form);
            }, 10, 2);

            // Filter other confirmations for form submission response
            $app->addFilter('fluentform_form_submission_confirmation', function ($confirmation, $data, $form) {

                $confirmations = wpFluent()->table('fluentform_form_meta')
                    ->where('form_id', $form->id)
                    ->where('meta_key', 'confirmations')
                    ->get();


                foreach ($confirmations as $item) {
                    $item->value = json_decode($item->value, true);
                    if ($item->value['active']) {
                        if (\FluentForm\App\Services\ConditionAssesor::evaluate($item->value, $data)) {
                            return $item->value;
                        }
                    }
                }

                return $confirmation;

            }, 10, 3);

            add_filter('fluentform_email_template_footer_credit', '__return_empty_string');

            add_shortcode('fluentform_modal', function ($atts) {
                $shortcodeDefaults = apply_filters('fluentform_popup_shortcode_defaults', array(
                    'form_id'   => null,
                    'btn_text'  => 'Contact Me',
                    'css_class' => 'btn btn-success',
                    'bg_color'  => 'white'
                ), $atts);
                $atts = shortcode_atts($shortcodeDefaults, $atts);

                if (empty($atts['form_id'])) {
                    return;
                }

                return \FluentFormPro\classes\FormModal::renderModal($atts);

            });

            add_shortcode('fluentform_survey', function ($atts) {

                $shortcodeDefaults = apply_filters('fluentform_survey_shortcode_defaults', array(
                    'form_id'    => null,
                    'field_name' => '',
                    'label'      => 'yes',
                    'counts'     => 'yes'
                ), $atts);


                $atts = shortcode_atts($shortcodeDefaults, $atts);

                return (new \FluentFormPro\classes\SurveyResultProcessor())->getSurveyResultHtml($atts);
            });

            add_filter('fluentform_submission_message_parse', array('FluentFormPro\classes\ConditionalContent', 'initiate'), 10, 4);

            add_shortcode('ff_if', array('FluentFormPro\classes\ConditionalContent', 'handle'));
            add_shortcode('ff_sub_if', array('FluentFormPro\classes\ConditionalContent', 'handle'));

            add_action('ff_rendering_calculation_form', function ($form, $element) {
                (new \FluentFormPro\classes\Calculation())->enqueueScripts();
            }, 10, 2);

            // Hook into the `fluentform_submission_confirmation` before returning the data
            // so that if append survey result is enabled we could display survey result.
            add_filter('fluentform_submission_confirmation', function ($data, $form) {
                if (isset($form->settings['appendSurveyResult']) && $form->settings['appendSurveyResult']['enabled']) {
                    $data['message'] .= (new \FluentFormPro\classes\SurveyResultProcessor())->getSurveyResultHtml([
                        'form_id'    => $form->id,
                        'field_name' => '',
                        'label'      => $form->settings['appendSurveyResult']['showLabel'] ? 'yes' : false,
                        'counts'     => $form->settings['appendSurveyResult']['showCount'] ? 'yes' : false,
                    ]);
                }

                return $data;
            }, 10, 2);

            \FluentFormPro\Components\Post\Bootstrap::boot();

            \FluentFormPro\classes\DraftSubmissionsManager::boot($app);

            add_filter('fluentform_validation_errors', function ($errors, $data, $form, $fields) {
                return (new \FluentFormPro\classes\AdvancedFormValidation())->validateAdvancedConditions($errors, $data, $form, $fields);
            }, 10, 4);

            (new \FluentFormPro\classes\ProSmartCodes())->register();

            (new \FluentFormPro\classes\DoubleOptin())->init();
        }

        /**
         * Registers ajax hooks.
         */
        public function ajaxHooks($app)
        {
            $app->addAdminAjaxAction('fluentform_file_upload', function () use ($app) {
                (new \FluentFormPro\Uploader($app))->upload();
            });

            $app->addPublicAjaxAction('fluentform_file_upload', function () use ($app) {
                (new \FluentFormPro\Uploader($app))->upload();
            });

            $app->addPublicAjaxAction('fluentform_delete_uploaded_file', function () use ($app) {
                (new \FluentFormPro\Uploader($app))->deleteFile();
            });

            $app->addAdminAjaxAction('fluentform_delete_uploaded_file', function () use ($app) {
                (new \FluentFormPro\Uploader($app))->deleteFile();
            });

            // Post Form Creation Ajax Hook On Backend
            $app->addAdminAjaxAction('fluentform_get_post_types', function () {
                \FluentForm\App\Modules\Acl\Acl::verify('fluentform_settings_manager');

                $postSettings = new \FluentFormPro\Components\Post\PostFeedSettings;

                wp_send_json_success(['post_types' => $postSettings->getPostTypes()]);
            });

            // Post Form Creation Ajsx Hook On Backend
            $app->addAdminAjaxAction('fluentform_get_post_settings', function () {
                \FluentForm\App\Modules\Acl\Acl::verify('fluentform_settings_manager');

                $postSettings = new \FluentFormPro\Components\Post\PostFeedSettings;

                wp_send_json_success($postSettings->getPostSettings());
            });

            // Chained Select Ajax Hook On Backend
            $app->addAdminAjaxAction('fluentform_chained_select_file_upload', function () use ($app) {
                require_once(__DIR__ . '/libs/CSVParser/CSVParser.php');
                $cs = new \FluentFormPro\Components\ChainedSelect\ChainedSelectDataSourceManager(
                    $app
                );
                $cs->saveDataSource(new CSVParser);
            });

            // Chained Select Ajax Hook On Backend
            $app->addAdminAjaxAction('fluentform_chained_select_remove_ds', function () use ($app) {
                $cs = new \FluentFormPro\Components\ChainedSelect\ChainedSelectDataSourceManager(
                    $app
                );
                $cs->deleteDataSource();
            });

            // Chained Select Ajax Hook On Frontend
            $getChainedSelectOptions = function () use ($app) {
                require_once(__DIR__ . '/libs/CSVParser/CSVParser.php');
                $cs = new \FluentFormPro\Components\ChainedSelect\ChainedSelectDataSourceManager(
                    $app
                );
                $cs->getOptionsForNextField(new CSVParser);
            };

            $app->addAdminAjaxAction('fluentform_get_chained_select_options', $getChainedSelectOptions);
            $app->addPublicAjaxAction('fluentform_get_chained_select_options', $getChainedSelectOptions);

            $app->addPublicAjaxAction('fluentform_get_chained_select_options', $getChainedSelectOptions);

            $app->addAdminAjaxAction('fluentform_apply_coupon', function () {
                (new \FluentFormPro\Payments\Classes\CouponController())->validateCoupon();
            });

            $app->addPublicAjaxAction('fluentform_apply_coupon', function () {
                (new \FluentFormPro\Payments\Classes\CouponController())->validateCoupon();
            });

        }

        /**
         * Register pro element's rendering hooks
         * @return void
         */
        protected function registerProElementsRenderingHook($app)
        {
            add_action('fluentform_render_item_input_file', function () {
                $class = new \FluentFormPro\Components\Uploader;
                call_user_func_array(array($class, 'compile'), func_get_args());
            }, 10, 2);

            add_action('fluentform_render_item_input_image', function () {
                $class = new \FluentFormPro\Components\Uploader;
                call_user_func_array(array($class, 'compile'), func_get_args());
            }, 10, 2);

            add_action('fluentform_render_item_input_repeat', function () {
                $class = new \FluentFormPro\Components\Repeater;
                call_user_func_array(array($class, 'compile'), func_get_args());
            }, 10, 2);

            add_action('fluentform_render_item_step_start', function () {
                $class = new \FluentFormPro\Components\FormStep;
                call_user_func_array(array($class, 'stepStart'), func_get_args());
            }, 10, 2);

            add_action('fluentform_render_item_form_step', function () {
                $class = new \FluentFormPro\Components\FormStep;
                call_user_func_array(array($class, 'compile'), func_get_args());
            }, 10, 2);

            add_action('fluentform_render_item_step_end', function ($data, $form) {
                $class = new \FluentFormPro\Components\FormStep;
                call_user_func_array(array($class, 'stepEnd'), [$data, $form]);
            }, 10, 2);

            add_action('fluentform_render_item_shortcode', function () {
                $class = new \FluentFormPro\Components\ShortCode;
                call_user_func_array(array($class, 'compile'), func_get_args());
            }, 10, 2);

            add_action('fluentform_render_item_action_hook', function () {
                $class = new \FluentFormPro\Components\ActionHook;
                call_user_func_array(array($class, 'compile'), func_get_args());
            }, 10, 2);
        }

        /**
         * Activate disabled components
         *
         * @param array $disabled
         *
         * @return array
         */
        public function filterDisabledComponents($disabled)
        {
            foreach ($disabled as $key => &$value) {
                if (in_array($key, $this->proElements)) {
                    $value['disabled'] = false;
                }
            }
            return $disabled;
        }

        /**
         * Register 3rd party Integrations on Form Submit
         * @return void
         */
        public function registerAddOns($app)
        {
            foreach ($this->addOns as $addOn) {
                $class = "{$addOn}\Bootstrap";
                new $class($app);
            }
        }


        public function registerScripts()
        {
            $cssSource = FLUENTFORMPRO_DIR_URL . 'public/libs/intl-tel-input/css/intlTelInput.min.css';
            if (is_rtl()) {
                $cssSource = FLUENTFORMPRO_DIR_URL . 'public/libs/intl-tel-input/css/intlTelInput-rtl.min.css';
            }

            wp_register_style('intlTelInput', $cssSource, [], '16.0.0');
            wp_register_style('pickr', FLUENTFORMPRO_DIR_URL . 'public/libs/pickr/themes/monolith.min.css', [], '1.5.1');
            wp_register_script('intlTelInput', FLUENTFORMPRO_DIR_URL . 'public/libs/intl-tel-input/js/intlTelInput.min.js', [], '16.0.0', true);
            wp_register_script('intlTelInputUtils', FLUENTFORMPRO_DIR_URL . 'public/libs/intl-tel-input/js/utils.js', [], '16.0.0', true);

            wp_register_script(
                'fluentform-uploader-jquery-ui-widget',
                FLUENTFORMPRO_DIR_URL . 'public/js/jQuery-File-Upload-9.19.2/js/vendor/jquery.ui.widget.js',
                array('jquery'),
                true,
                true
            );

            wp_register_script(
                'fluentform-uploader-iframe-transport',
                FLUENTFORMPRO_DIR_URL . 'public/js/jQuery-File-Upload-9.19.2/js/jquery.iframe-transport.js',
                array('fluentform-uploader-jquery-ui-widget'),
                true,
                true
            );

            wp_register_script(
                'fluentform-uploader',
                FLUENTFORMPRO_DIR_URL . 'public/js/jQuery-File-Upload-9.19.2/js/jquery.fileupload.js',
                array('fluentform-uploader-iframe-transport'),
                true,
                true
            );

            wp_register_script(
                'pickr',
                FLUENTFORMPRO_DIR_URL . 'public/libs/pickr/pickr.min.js',
                array(),
                true,
                true
            );
        }
    }

    /**
     * Plugin init hook
     * @return void
     */
    add_action('init', function () {

        load_plugin_textdomain(
            'fluentformpro', false, dirname(plugin_basename(__FILE__)) . '/resources/languages'
        );

        (new FluentFormPro)->boot();
    });

    register_activation_hook(__FILE__, function ($siteWide) {
        \FluentFormPro\Payments\Migrations\Migration::run($siteWide);
        \FluentFormPro\classes\DraftSubmissionsManager::migrate();
    });

    add_action('plugins_loaded', function () {
        if (defined('FLUENTFORM')) {
            include plugin_dir_path(__FILE__) . 'libs/ff_plugin_updater/ff-fluentform-pro-update.php';
        }
    });
}