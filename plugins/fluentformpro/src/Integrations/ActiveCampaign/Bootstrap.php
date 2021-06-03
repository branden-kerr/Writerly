<?php

namespace FluentFormPro\Integrations\ActiveCampaign;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Services\Integrations\IntegrationManager;
use FluentForm\Framework\Foundation\Application;
use FluentForm\Framework\Helpers\ArrayHelper;

class Bootstrap extends IntegrationManager
{
    public function __construct(Application $app)
    {
        parent::__construct(
            $app,
            'ActiveCampaign',
            'activecampaign',
            '_fluentform_activecampaign_settings',
            'fluentform_activecampaign_feed',
            16
        );

        $this->logo = $this->app->url('public/img/integrations/activecampaign.png');

        $this->description = 'Fluent Forms ActiveCampaign Module allows you to create ActiveCampaign list signup forms in WordPress, so you can grow your email list.';

        $this->registerAdminHooks();

      //  add_filter('fluentform_notifying_async_activecampaign', '__return_false');
    }

    public function getGlobalFields($fields)
    {
        return [
            'logo' => $this->logo,
            'menu_title' => __('ActiveCampaign API Settings', 'fluentformpro'),
            'menu_description' => __('ActiveCampaign is an integrated email marketing, marketing automation, and small business CRM. Save time while growing your business with sales automation. Use Fluent Form to collect customer information and automatically add it to your ActiveCampaign list. If you don\'t have an ActiveCampaign account, you can <a href="https://www.activecampaign.com/" target="_blank">sign up for one here.</a>', 'fluentformpro'),
            'valid_message' => __('Your ActiveCampaign configuration is valid', 'fluentformpro'),
            'invalid_message' => __('Your ActiveCampaign configuration is invalid', 'fluentformpro'),
            'save_button_text' => __('Save Settings', 'fluenform'),
            'fields' => [
                'apiUrl' => [
                    'type' => 'text',
                    'placeholder' => 'API URL',
                    'label_tips' => __("Please Provide your ActiveCampaign API URL", 'fluentformpro'),
                    'label' => __('ActiveCampaign API URL', 'fluentformpro'),
                ],
                'apiKey' => [
                    'type' => 'password',
                    'placeholder' => 'API Key',
                    'label_tips' => __("Enter your ActiveCampaign API Key, if you do not have <br>Please login to your ActiveCampaign account and find the api key", 'fluentformpro'),
                    'label' => __('ActiveCampaign API Key', 'fluentformpro'),
                ]
            ],
            'hide_on_valid' => true,
            'discard_settings' => [
                'section_description' => 'Your ActiveCampaign API integration is up and running',
                'button_text' => 'Disconnect ActiveCampaign',
                'data' => [
                    'apiKey' => ''
                ],
                'show_verify' => true
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
            'apiKey' => '',
            'apiUrl' => '',
            'status' => ''
        ];

        return wp_parse_args($globalSettings, $defaults);
    }

    public function saveGlobalSettings($settings)
    {
        if (!$settings['apiKey']) {
            $integrationSettings = [
                'apiKey' => '',
                'apiUrl' => '',
                'status' => false
            ];
            // Update the reCaptcha details with siteKey & secretKey.
            update_option($this->optionKey, $integrationSettings, 'no');
            wp_send_json_success([
                'message' => __('Your settings has been updated and discarted', 'fluentformpro'),
                'status' => false
            ], 200);
        }

        try {
            $settings['status'] = false;
            update_option($this->optionKey, $settings, 'no');
            $api = new ActiveCampaignApi($settings['apiUrl'], $settings['apiKey']);
            if ($api->auth_test()) {
                $settings['status'] = true;
                update_option($this->optionKey, $settings, 'no');

                return wp_send_json_success([
                    'status' => true,
                    'message' => __('Your settings has been updated!', 'fluentformpro')
                ], 200);
            }
            throw new \Exception('Invalid Credentials', 400);

        } catch (\Exception $e) {
            wp_send_json_error([
                'status' => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }


    }

    public function pushIntegration($integrations, $formId)
    {
        $integrations[$this->integrationKey] = [
            'title' => $this->title . ' Integration',
            'logo' => $this->logo,
            'is_active' => $this->isConfigured(),
            'configure_title' => 'Configuration required!',
            'global_configure_url' => admin_url('admin.php?page=fluent_forms_settings#general-activecampaign-settings'),
            'configure_message' => 'ActiveCampaign is not configured yet! Please configure your ActiveCampaign API first',
            'configure_button_text' => 'Set ActiveCampaign API'
        ];
        return $integrations;
    }

    public function getIntegrationDefaults($settings, $formId)
    {
        return [
            'name' => '',
            'list_id' => '',
            'fieldEmailAddress' => '',
            'custom_field_mappings' => (object)[],
            'default_fields' => (object)[],
            'note' => '',
            'tags' => '',
            'tag_routers'            => [],
            'tag_ids_selection_type' => 'simple',
            'conditionals' => [
                'conditions' => [],
                'status' => false,
                'type' => 'all'
            ],
            'instant_responders' => false,
            'last_broadcast_campaign' => false,
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
                    'key' => 'list_id',
                    'label' => 'ActiveCampaign List',
                    'placeholder' => 'Select ActiveCampaign Mailing List',
                    'tips' => 'Select the ActiveCampaign Mailing List you would like to add your contacts to.',
                    'component' => 'list_ajax_options',
                    'options' => $this->getLists(),
                ],
                [
                    'key' => 'custom_field_mappings',
                    'require_list' => true,
                    'label' => 'Map Fields',
                    'tips' => 'Select which Fluent Form fields pair with their<br /> respective ActiveCampaign fields.',
                    'component' => 'map_fields',
                    'field_label_remote' => 'ActiveCampaign Field',
                    'field_label_local' => 'Form Field',
                    'primary_fileds' => [
                        [
                            'key' => 'fieldEmailAddress',
                            'label' => 'Email Address',
                            'required' => true,
                            'input_options' => 'emails'
                        ]
                    ],
                    'default_fields' => [
                        array(
                            'name' => 'first_name',
                            'label' => esc_html__('First Name', 'fluentformpro'),
                            'required' => false
                        ),
                        array(
                            'name' => 'last_name',
                            'label' => esc_html__('Last Name', 'fluentformpro'),
                            'required' => false
                        ),
                        array(
                            'name' => 'phone',
                            'label' => esc_html__('Phone Number', 'fluentformpro'),
                            'required' => false
                        ),
                        array(
                            'name' => 'orgname',
                            'label' => esc_html__('Organization Name', 'fluentformpro'),
                            'required' => false
                        )
                    ]
                ],
                [
                    'key' => 'tags',
                    'require_list' => true,
                    'label' => 'Tags',
                    'tips' => 'Associate tags to your ActiveCampaign contacts with a comma separated list (e.g. new lead, FluentForms, web source). Commas within a merge tag value will be created as a single tag.',
                    'component'    => 'selection_routing',
                    'simple_component' => 'value_text',
                    'routing_input_type' => 'text',
                    'routing_key'  => 'tag_ids_selection_type',
                    'settings_key' => 'tag_routers',
                    'labels'       => [
                        'choice_label'      => 'Enable Dynamic Tag Input',
                        'input_label'       => '',
                        'input_placeholder' => 'Tag'
                    ],
                    'inline_tip' => 'Please provide each tag by comma separated value, You can use dynamic smart codes'
                ],
                [
                    'key' => 'note',
                    'require_list' => true,
                    'label' => 'Note',
                    'tips' => 'You can write a note for this contact',
                    'component' => 'value_textarea'
                ],
                [
                    'key' => 'double_optin_form',
                    'require_list' => true,
                    'label' => 'Double Opt-In Form',
                    'tips' => 'Select which ActiveCampaign form will be used when exporting to ActiveCampaign to send the opt-in email.',
                    'component' => 'list_select_filter',
                    'filter_by' => 'list_id',
                    'parsedType' => 'number',
                    'placeholder' => 'Select Double Opt-in Form',
                    'options' => $this->getAcForms(),
                ],
                [
                    'key' => 'instant_responders',
                    'require_list' => true,
                    'label' => 'Instant Responders',
                    'tips' => 'When the instant responders option is enabled, ActiveCampaign will<br/>send any instant responders setup when the contact is added to the<br/>list. This option is not available to users on a free trial.',
                    'component' => 'checkbox-single',
                    'checkbox_label' => 'Enable Instant Responder'
                ],
                [
                    'key' => 'last_broadcast_campaign',
                    'require_list' => true,
                    'label' => 'Last Broadcast Campaign',
                    'tips' => 'When the send the last broadcast campaign option is enabled,<br/>ActiveCampaign will send the last campaign sent out to the list<br/>to the contact being added. This option is not available to users<br/>on a free trial.',
                    'component' => 'checkbox-single',
                    'checkbox_label' => 'Enable Send the last broadcast campaign'
                ],
                [
                    'require_list' => true,
                    'key' => 'conditionals',
                    'label' => 'Conditional Logics',
                    'tips' => 'Allow ActiveCampaign integration conditionally based on your submission values',
                    'component' => 'conditional_block'
                ],
                [
                    'require_list' => true,
                    'key' => 'enabled',
                    'label' => 'Status',
                    'component' => 'checkbox-single',
                    'checkbox_label' => 'Enable This feed'
                ]
            ],
            'button_require_list' => true,
            'integration_title' => $this->title
        ];
    }

    protected function getLists()
    {
        $api = $this->getApiClient();
        if (!$api) {
            return [];
        }

        $lists = $api->get_lists();

        $formattedLists = [];
        foreach ($lists as $list) {
            if (is_array($list)) {
                $formattedLists[strval($list['id'])] = $list['name'];
            }
        }

        return $formattedLists;
    }

    public function getMergeFields($list, $listId, $formId)
    {
        $fields = [];
        $api = $this->getApiClient();
        $response = $api->get_custom_fields();
        if ($response['result_code']) {
            $fields = array_filter($response, function ($item) {
                return is_array($item);
            });
            $formattedFileds = [];
            foreach ($fields as $field) {
                $formattedFileds[$field['id']] = $field['title'];
            }
            return $formattedFileds;
        }
        return $fields;
    }

    /**
     * Prepare ActiveCampaign forms for feed field.
     *
     * @return array
     */
    public function getAcForms()
    {
        $forms = array();
        $api = $this->getApiClient();
        // Get available ActiveCampaign forms.
        $ac_forms = $api->get_forms();

        // Add ActiveCampaign forms to array and return it.
        if (!empty($ac_forms)) {
            foreach ($ac_forms as $form) {
                if (!is_array($form)) {
                    continue;
                }
                if ($form['sendoptin'] == 0 || !is_array($form['lists'])) {
                    continue;
                }
                $forms[] = [
                    'label' => $form['name'],
                    'value' => 'item_' . $form['id'],
                    'lists' => $form['lists']
                ];
            }
        }
        return $forms;
    }

    /*
     * Submission Broadcast Handler
     */

    public function notify($feed, $formData, $entry, $form)
    {
        $feedData = $feed['processedValues'];

        if (!is_email($feedData['fieldEmailAddress'])) {
            $feedData['fieldEmailAddress'] = ArrayHelper::get($formData, $feedData['fieldEmailAddress']);
        }

        if (!is_email($feedData['fieldEmailAddress'])) {
            do_action('ff_integration_action_result', $feed, 'failed', 'Active Campaign API call has been skipped because no valid email available');
            return;
        }

        $addData = [
            'email' => $feedData['fieldEmailAddress'],
            'first_name' => ArrayHelper::get($feedData, 'default_fields.first_name'),
            'last_name' => ArrayHelper::get($feedData, 'default_fields.last_name'),
            'phone' => ArrayHelper::get($feedData, 'default_fields.phone'),
            'orgname' => ArrayHelper::get($feedData, 'default_fields.orgname'),
        ];

        $tags = $this->getSelectedTagIds($feedData, $formData, 'tags');
        if(!is_array($tags)) {
            $tags = explode(',', $tags);
        }

        $tags = array_map('trim', $tags);
        $tags = array_filter($tags);

        if ($tags) {
            $addData['tags'] = implode(',', $tags);
        }

        $list_id = $feedData['list_id'];
        $addData['p[' . $list_id . ']'] = $list_id;
        $addData['status[' . $list_id . ']'] = '1';

        foreach (ArrayHelper::get($feedData, 'custom_field_mappings', []) as $key => $value) {
            if (!$value) {
                continue;
            }
            $contact_key = 'field[' . $key . ',0]';
            $addData[$contact_key] = $value;
        }

        if (ArrayHelper::isTrue($feedData, 'instant_responders')) {
            $addData['instantresponders[' . $list_id . ']'] = 1;
        }

        if (ArrayHelper::isTrue($feedData, 'last_broadcast_campaign')) {
            $addData['lastmessage[' . $list_id . ']'] = 1;
        }

        if (!empty($feedData['double_optin_form'])) {
            $formId = str_replace('item_', '', $feedData['double_optin_form']);
            if ($formId) {
                $addData['form'] = $formId;
            }
        }

        $addData = array_filter($addData);

        $addData = apply_filters('fluentform_integration_data_'.$this->integrationKey, $addData, $feed, $entry);

        // Now let's prepare the data and push to hubspot
        $api = $this->getApiClient();
        $response = $api->sync_contact($addData);

        if (is_wp_error($response)) {
            do_action('ff_integration_action_result', $feed, 'failed', $response->get_error_message());
            return false;
        } else if ($response['result_code'] == 1) {
            do_action('ff_integration_action_result', $feed, 'success', 'Active Campaign has been successfully initialed and pushed data');
            if (ArrayHelper::get($feedData, 'note')) {
                // Contact Added
                $api->add_note($response['subscriber_id'], $list_id, ArrayHelper::get($feedData, 'note'));
            }
            return true;
        }

        do_action('ff_integration_action_result', $feed, 'failed', $response['result_message']);
    }


    protected function getApiClient()
    {
        $settings = get_option($this->optionKey);

        return new ActiveCampaignApi(
            $settings['apiUrl'], $settings['apiKey']
        );
    }
}
