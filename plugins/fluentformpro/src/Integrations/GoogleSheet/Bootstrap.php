<?php

namespace FluentFormPro\Integrations\GoogleSheet;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Services\Integrations\IntegrationManager;
use FluentForm\Framework\Foundation\Application;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentFormPro\Integrations\GoogleSheet\API\API;
use FluentFormPro\Integrations\GoogleSheet\API\Sheet;

class Bootstrap extends IntegrationManager
{
    public function __construct(Application $app)
    {
        parent::__construct(
            $app,
            'Google Sheets',
            'google_sheet',
            '_fluentform_google_sheet_settings',
            'google_sheet_notification_feed',
            26
        );

        $this->logo = $this->app->url('public/img/integrations/google-sheets.png');
        $this->description = 'Add WP Fluent Forms Submission to Google sheets when a form is submitted.';
        $this->registerAdminHooks();
       // add_filter('fluentform_notifying_async_google_sheet', '__return_false');
        add_filter('fluentform_save_integration_value_google_sheet', array($this, 'checkColumnSlugs'), 10, 2);
    }

    public function getGlobalFields($fields)
    {
        $api = new API();

        return [
            'logo' => $this->logo,
            'menu_title' => __('Google Sheets', 'fluentformpro'),
            'menu_description' => __('Copy that Google Access Code from other window and paste it here, then click on Verify Code button.', 'fluentformpro'),
            'valid_message' => __('Your Google Access Code is valid', 'fluentformpro'),
            'invalid_message' => __('Your Google Access Code is not valid', 'fluentformpro'),
            'save_button_text' => __('Verify Code', 'fluentformpro'),
            'fields' => [
                'access_code' => [
                    'type' => 'text',
                    'placeholder' => 'Access Code',
                    'label_tips' => __("Enter Google Access Code. Please find this by clicking 'Get Google Sheet Access Code' Button", 'fluentformpro'),
                    'label' => __('Access Code', 'fluentformpro'),
                ],
                'button_link' => [
                    'type' => 'link',
                    'link_text' => 'Get Google Sheet Access Code',
                    'link' => $api->getAUthUrl(),
                    'target' => '_blank',
                    'tips' => 'Please click on this link get get Access Code From Google'
                ]
            ],
            'hide_on_valid' => true,
            'discard_settings' => [
                'section_description' => 'Your Google Sheet integration is up and running',
                'button_text' => 'Disconnect Google Sheet',
                'data' => [
                    'access_code' => ''
                ],
                'show_verify' => false
            ]
        ];
    }

    public function getGlobalSettings($settings)
    {
        $globalSettings = get_option($this->optionKey);
        if (!$globalSettings) {
            $globalSettings = [];
        }
        $defaults = [
            'access_code' => ''
        ];

        return wp_parse_args($globalSettings, $defaults);
    }

    public function saveGlobalSettings($settings)
    {
        if (empty($settings['access_code'])) {
            $integrationSettings = [
                'access_code' => '',
                'status' => false
            ];
            // Update the reCaptcha details with siteKey & secretKey.
            update_option($this->optionKey, $integrationSettings, 'no');
            wp_send_json_success([
                'message' => __('Your settings has been updated', 'fluentformpro'),
                'status' => false
            ], 200);
        }

        // Verify API key now
        try {
            $accessCode = sanitize_textarea_field($settings['access_code']);
            $api = new API();

            $result = $api->generateAccessKey($accessCode);

            if (is_wp_error($result)) {
                throw new \Exception($result->get_error_message());
            }

            $result['access_code'] = $accessCode;
            $result['created_at'] = time();
            $result['status'] = true;

            update_option($this->optionKey, $result, 'no');

        } catch (\Exception $exception) {
            wp_send_json_error([
                'message' => $exception->getMessage()
            ], 400);
        }

        wp_send_json_success([
            'message' => __('Your Google Sheet api key has been verified and successfully set', 'fluentformpro'),
            'status' => true
        ], 200);
    }

    public function pushIntegration($integrations, $formId)
    {
        $integrations[$this->integrationKey] = [
            'title' => 'Google Sheet',
            'logo' => $this->logo,
            'is_active' => $this->isConfigured(),
            'configure_title' => 'Configuration required!',
            'global_configure_url' => admin_url('admin.php?page=fluent_forms_settings#general-google_sheet-settings'),
            'configure_message' => 'Google Sheet is not configured yet! Please configure your Google Sheet api first',
            'configure_button_text' => 'Set Google Sheet API'
        ];
        return $integrations;
    }

    public function getIntegrationDefaults($settings, $formId)
    {
        return [
            'name' => '',
            'spreadsheet_id' => '',
            'work_sheet_id' => '',
            'meta_fields' => [
                (object)array()
            ],
            'conditionals' => [
                'conditions' => [],
                'status' => false,
                'type' => 'all'
            ],
            'enabled' => true
        ];
    }

    public function getSettingsFields($settings, $formId)
    {
        return [
            'fields' => [
                [
                    'key' => 'name',
                    'label' => 'Name',
                    'required' => true,
                    'placeholder' => 'Your Feed Name',
                    'component' => 'text'
                ],
                [
                    'key' => 'spreadsheet_id',
                    'label' => 'Spreadsheet ID',
                    'required' => true,
                    'placeholder' => 'Spreadsheet ID',
                    'component' => 'text',
                    'inline_tip' => '<a href="https://wpmanageninja.com/docs/fluent-form/integrations-available-in-wp-fluent-form/google-sheet-integration#get_sheet_id" target="blank">Check documentation</a> for how to find google Spreadsheet ID'
                ],
                [
                    'key' => 'work_sheet_id',
                    'label' => 'Worksheet Name',
                    'required' => true,
                    'placeholder' => 'Worksheet Name',
                    'component' => 'text',
                    'inline_tip' => '<a href="https://wpmanageninja.com/docs/fluent-form/integrations-available-in-wp-fluent-form/google-sheet-integration#get_sheet_id" target="blank">Check documentation</a> for how to find google Worksheet Name'
                ],
                [
                    'key' => 'meta_fields',
                    'label' => 'Spreadsheet Fields',
                    'sub_title' => 'Please specify the meta ',
                    'required' => true,
                    'component' => 'dropdown_label_repeater',
                ],
                [
                    'key' => 'conditionals',
                    'label' => 'Conditional Logics',
                    'tips' => 'Push data to google sheet conditionally based on your submission values',
                    'component' => 'conditional_block'
                ],
                [
                    'require_list' => false,
                    'key' => 'enabled',
                    'label' => 'Status',
                    'component' => 'checkbox-single',
                    'checkbox_label' => 'Enable This feed'
                ]
            ],
            'button_require_list' => false,
            'integration_title' => $this->title
        ];
    }

    public function checkColumnSlugs($settings, $integrationId)
    {
        $message = 'Validation Failed';
        // Validate First
        $errors = [];
        if (empty($settings['spreadsheet_id'])) {
            $errors['spreadsheet_id'] = ['Please Provide spreadsheet ID'];
        }
        if (empty($settings['work_sheet_id'])) {
            $errors['spreadsheet_id'] = ['Please Provide Worksheet Name'];
        }
        if (empty($settings['meta_fields'])) {
            $errors['meta_fields'] = ['Please Provide Meta Fields Values'];
        }

        if (count($settings['meta_fields']) > 208) {
            $errors['meta_fields'] = ['Spreadsheet Fields can not bet greater than 104'];
            $message = 'Spreadsheet Fields can not bet greater than 104';
        }

        if ($errors) {
            wp_send_json_error([
                'message' => $message,
                'errors' => $errors
            ], 423);
        }

        $keys = [];

        foreach ($settings['meta_fields'] as $index => $meta) {
            if (empty($meta['slug'])) {
                $slug = sanitize_title($meta['label'], 'column_' . $index, 'display');
                if (isset($keys[$slug])) {
                    $slug = $slug . '_' . time() . '_' . mt_rand(1, 100);
                }
                $settings['meta_fields'][$index]['slug'] = $slug;
                $keys[$slug] = $meta['label'];
            } else {
                $keys[$meta['slug']] = $meta['label'];
            }
        }


        // Let's get the sheet Header Now
        $sheet = new Sheet();
        $sheetId = $settings['spreadsheet_id'];
        $workId = $settings['work_sheet_id'];
        $response = $sheet->insertHeader($sheetId, $workId, $keys);

        if (is_wp_error($response)) {
            wp_send_json_error([
                'message' => $response->get_error_message(),
                'errors' => $response
            ], 423);
        }

        // we are done here
        return $settings;
    }

    public function getMergeFields($list, $listId, $formId)
    {
        return [];
    }

    /*
     * Form Submission Hooks Here
     */
    public function notify($feed, $formData, $entry, $form)
    {
        $feedData = $feed['processedValues'];
        $row = [];
        $metaFields = $feedData['meta_fields'];

        if(!$metaFields) {
            return do_action('ff_integration_action_result', $feed, 'failed', 'No meta fields found');
        }

        foreach ($metaFields as $field) {
            $row[] = wp_unslash(sanitize_textarea_field(ArrayHelper::get($field, 'item_value')));
        }

        $row = apply_filters('fluentform_integration_data_'.$this->integrationKey, $row, $feed, $entry);

        $sheet = new Sheet();
        $response = $sheet->insertRow($feedData['spreadsheet_id'], $feedData['work_sheet_id'], $row);

        if (is_wp_error($response)) {
            do_action('ff_integration_action_result', $feed, 'failed', $response->get_error_message());
        } else {
            do_action('ff_integration_action_result', $feed, 'success', 'Pushed data to Google Sheet');
        }
    }
}
