<?php

namespace FluentFormPro\Integrations\Drip;

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
            'Drip',
            'drip',
            '_fluentform_drip_settings',
            'fluentform_drip_feed',
            16
        );

        $this->logo = $this->app->url('public/img/integrations/drip.png');

        $this->description = 'WP Fluent Forms Drip Module allows you to create Drip subscribers from WordPress, so you can grow your email list.';

        $this->registerAdminHooks();

        //  add_filter('fluentform_notifying_async_drip', '__return_false');

    }

    public function getGlobalFields($fields)
    {
        return [
            'logo' => $this->logo,
            'menu_title' => __('Drip API Settings', 'fluentformpro'),
            'menu_description' => __('Drip is an ECRM and Ecommerce CRM designed for building personal and profitable relationships with your customers at scale. Use Fluent Form to collect customer information and automatically add it to your Drip list.', 'fluentformpro'),
            'valid_message' => __('Your Drip configuration is valid', 'fluentformpro'),
            'invalid_message' => __('Your Drip configuration is invalid', 'fluentformpro'),
            'save_button_text' => __('Save Settings', 'fluenform'),
            'fields' => [
                'apiKey' => [
                    'type' => 'password',
                    'placeholder' => 'API Token',
                    'label_tips' => __("Enter your Drip API Key, if you do not have <br>Please login to your Drip account settings -> User Info and find the api key", 'fluentformpro'),
                    'label' => __('Drip API Token', 'fluentformpro'),
                ],
                'accountId' => [
                    'type' => 'number',
                    'placeholder' => 'Project ID',
                    'required' => true,
                    'label_tips' => __("Please Provide your Drip project id", 'fluentformpro'),
                    'label' => __('Drip project id', 'fluentformpro'),
                ],
            ],
            'hide_on_valid' => true,
            'discard_settings' => [
                'section_description' => 'Your Drip API integration is up and running',
                'button_text' => 'Disconnect Drip',
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
            'accountId' => '',
            'status' => ''
        ];

        return wp_parse_args($globalSettings, $defaults);
    }

    public function saveGlobalSettings($settings)
    {
        if (!$settings['apiKey']) {
            $integrationSettings = [
                'apiKey' => '',
                'accountId' => '',
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
            $api = new DripApi($settings['apiKey'], $settings['accountId']);
            $auth = $api->auth_test();

            if (!empty($auth['accounts'])) {
                $settings['status'] = true;
                update_option($this->optionKey, $settings, 'no');
                return wp_send_json_success([
                    'status' => true,
                    'message' => __('Your settings has been updated!', 'fluentformpro')
                ], 200);
            }

            $message = 'Invalid Credentials';
            if (is_wp_error($auth)) {
                $message = $auth->get_error_message();
            } else if (isset($auth['errors'][0]['message'])) {
                $message = $auth['errors'][0]['message'];
            }
            throw new \Exception($message, 423);
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
            'global_configure_url' => admin_url('admin.php?page=fluent_forms_settings#general-platformly-settings'),
            'configure_message' => 'Drip is not configured yet! Please configure your Drip API first',
            'configure_button_text' => 'Set Drip API'
        ];
        return $integrations;
    }

    public function getIntegrationDefaults($settings, $formId)
    {
        return [
            'name' => '',
            'fieldEmailAddress' => '',
            'custom_field_mappings' => (object)[],
            'default_fields' => (object)[],
            'other_fields_mapping' => [
                [
                    'item_value' => '',
                    'label' => ''
                ]
            ],
            'custom_fields' => [
                [
                    'item_value' => '',
                    'label' => ''
                ]
            ],
            'ip_address' => '{ip}',
            'eu_consent' => '',
            'tags' => '',
            'tag_routers'            => [],
            'tag_ids_selection_type' => 'simple',
            'remove_tags' => '',
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
                    'key' => 'custom_field_mappings',
                    'require_list' => false,
                    'label' => 'Map Fields',
                    'tips' => 'Select which Fluent Form fields pair with their<br /> respective Drip fields.',
                    'component' => 'map_fields',
                    'field_label_remote' => 'Drip Field',
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
                        )
                    ]
                ],
                [
                    'key' => 'other_fields_mapping',
                    'require_list' => false,
                    'label' => 'Other Fields',
                    'tips' => 'Select which Fluent Form fields pair with their<br /> respective Drip fields.',
                    'component' => 'dropdown_many_fields',
                    'field_label_remote' => 'Drip Field',
                    'field_label_local' => 'Form Field',
                    'options' => [
                        'address1' => 'Address Line 1',
                        'address2' => 'Address Line 2',
                        'city' => 'City',
                        'state' => 'State',
                        'zip' => 'ZIP code',
                        'country' => 'Country',
                        'phone' => 'Phone'
                    ]
                ],
                [
                    'key' => 'custom_fields',
                    'require_list' => false,
                    'label' => 'Custom Fields',
                    'tips' => 'custom field data',
                    'component' => 'dropdown_label_repeater',
                ],
                [

                    'key' => 'tags',
                    'require_list' => false,
                    'label' => 'Contact Tags',
                    'tips' => 'Associate tags to your Drip contacts with a comma separated list (e.g. new lead, FluentForms, web source). Commas within a merge tag value will be created as a single tag.',
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
                    'require_list' => false,
                    'key' => 'remove_tags',
                    'label' => 'Remove tags',
                    'placeholder' => 'Type Tags (comma separated)',
                    'tips' => 'Type tags as comma separated that need to be removed',
                    'component' => 'value_text'
                ],
                [
                    'require_list' => false,
                    'key' => 'conditionals',
                    'label' => 'Conditional Logics',
                    'tips' => 'Allow Drip integration conditionally based on your submission values',
                    'component' => 'conditional_block'
                ],
                [
                    'require_list' => false,
                    'key' => 'eu_consent',
                    'label' => 'EU Consent',
                    'tips' => 'specifying whether the subscriber granted for GDPR consent',
                    'component' => 'radio_choice',
                    'options' => [
                        '' => 'Default',
                        'granted' => 'Granted'
                    ]
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

    public function notify($feed, $formData, $entry, $form)
    {
        $feedData = $feed['processedValues'];

        if (!is_email($feedData['fieldEmailAddress'])) {
            $feedData['fieldEmailAddress'] = ArrayHelper::get($formData, $feedData['fieldEmailAddress']);
        }

        if (!is_email($feedData['fieldEmailAddress'])) {
            do_action('ff_integration_action_result', $feed, 'failed', 'Drip API called skipped because no valid email available');
            return;
        }

        $addData = [
            'email' => $feedData['fieldEmailAddress']
        ];
        $addData = array_merge($addData, ArrayHelper::get($feedData, 'default_fields'));

        foreach (ArrayHelper::get($feedData, 'other_fields_mapping') as $item) {
            $addData[$item['label']] = $item['item_value'];
        }

        if ($customFields = ArrayHelper::get($feedData, 'custom_fields')) {
            $customData = [];
            foreach ($customFields as $customField) {
                $customData[$customField['label']] = $customField['item_value'];
            }
            $customData = array_filter($customData);
            if ($customData) {
                $addData['custom_fields'] = $customData;
            }
        }

        $tags = $this->getSelectedTagIds($feedData, $formData, 'tags');
        if(!is_array($tags)) {
            $tags = explode(',', $tags);
        }
        $tags = array_map('trim', $tags);
        $tags = array_filter($tags);
        if ($tags) {
            $addData['tags'] = $tags;
        }

        $removeTags = array_filter(explode(",", $feedData['remove_tags']));
        if ($removeTags) {
            $addData['remove_tags'] = array_map('trim', $removeTags);
        }

        if (!empty($feedData['ip_address'])) {
            $addData['ip_address'] = $feedData['ip_address'];
        }

        if (!empty($feedData['eu_consent'])) {
            $addData['eu_consent'] = $feedData['eu_consent'];
        }

        $addData = array_filter($addData);

        $addData = apply_filters('fluentform_integration_data_'.$this->integrationKey, $addData, $feed, $entry);


        // Now let's prepare the data and push to drip
        $api = $this->getApiClient();

        $response = $api->addContact($addData);

        if (!is_wp_error($response)) {
            do_action('ff_integration_action_result', $feed, 'success', 'Drip feed has been successfully initialed and pushed data');
        } else {
            $error = is_wp_error($response) ? $response->get_error_messages() : 'API Error when submitting Data';
            do_action('ff_integration_action_result', $feed, 'failed', $error);
        }
    }

    protected function getApiClient()
    {
        $settings = $this->getGlobalSettings([]);
        return new DripApi(
            $settings['apiKey'], $settings['accountId']
        );
    }

    public function getMergeFields($list, $listId, $formId)
    {
        return [];
    }
}
