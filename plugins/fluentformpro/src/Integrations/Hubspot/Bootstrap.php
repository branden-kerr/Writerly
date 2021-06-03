<?php

namespace FluentFormPro\Integrations\Hubspot;

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
            'HubSpot',
            'hubspot',
            '_fluentform_hubspot_settings',
            'hubspot_feed',
            26
        );

        $this->logo = $this->app->url('public/img/integrations/hubspot.png');

        // add_filter('fluentform_notifying_async_hubspot', '__return_false');

        $this->description = 'Connect HubSpot with WP Fluent Forms and subscribe a contact when a form is submitted.';

        $this->registerAdminHooks();
    }

    public function getGlobalFields($fields)
    {
        return [
            'logo' => $this->logo,
            'menu_title' => __('Hubspot API Settings', 'fluentformpro'),
            'menu_description' => __('Hubspot is a CRM software. Use Fluent Form to collect customer information and automatically add it as Hubspot subscriber list.', 'fluentformpro'),
            'valid_message' => __('Your Hubspot API Key is valid', 'fluentformpro'),
            'invalid_message' => __('Your Hubspot API Key is not valid', 'fluentformpro'),
            'save_button_text' => __('Save Settings', 'fluentformpro'),
            'fields' => [
                'apiKey' => [
                    'type' => 'password',
                    'placeholder' => 'API Key',
                    'label_tips' => __("Enter your Hubspot API Key, if you do not have <br>Please login to your Hubspot account and go to<br>Profile -> Account Settings -> Account Info", 'fluentformpro'),
                    'label' => __('Hubspot API Key', 'fluentformpro'),
                ]
            ],
            'hide_on_valid' => true,
            'discard_settings' => [
                'section_description' => 'Your HubSpot API integration is up and running',
                'button_text' => 'Disconnect HubSpot',
                'data' => [
                    'apiKey' => ''
                ]
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
            'status' => ''
        ];

        return wp_parse_args($globalSettings, $defaults);
    }

    public function saveGlobalSettings($settings)
    {
        if (!$settings['apiKey']) {
            $integrationSettings = [
                'apiKey' => '',
                'status' => false
            ];
            update_option($this->optionKey, $integrationSettings, 'no');

            wp_send_json_success([
                'message' => __('Your settings has been updated and discarded', 'fluentformpro'),
                'status' => false
            ], 200);
        }

        // Verify API key now
        try {
            $integrationSettings = [
                'apiKey' => sanitize_text_field($settings['apiKey']),
                'status' => false
            ];
            update_option($this->optionKey, $integrationSettings, 'no');

            $api = new API($settings['apiKey']);
            $result = $api->auth_test();

            if (is_wp_error($result)) {
                throw new \Exception($result->get_error_message());
            }

            if (!empty($result['message'])) {
                throw new \Exception($result['message']);
            }

        } catch (\Exception $exception) {
            wp_send_json_error([
                'message' => $exception->getMessage()
            ], 400);
        }

        // Integration key is verified now, Proceed now

        $integrationSettings = [
            'apiKey' => sanitize_text_field($settings['apiKey']),
            'status' => true
        ];

        // Update the reCaptcha details with siteKey & secretKey.
        update_option($this->optionKey, $integrationSettings, 'no');

        wp_send_json_success([
            'message' => __('Your HubSport api key has been verified and successfully set', 'fluentformpro'),
            'status' => true
        ], 200);
    }

    public function pushIntegration($integrations, $formId)
    {
        $integrations[$this->integrationKey] = [
            'title' => $this->title . ' Integration',
            'logo' => $this->logo,
            'is_active' => $this->isConfigured(),
            'configure_title' => 'Configuration required!',
            'global_configure_url' => admin_url('admin.php?page=fluent_forms_settings#general-hubspot-settings'),
            'configure_message' => 'HubSpot is not configured yet! Please configure your HubSpot api first',
            'configure_button_text' => 'Set HubSpot API'
        ];
        return $integrations;
    }

    public function getIntegrationDefaults($settings, $formId)
    {
        return [
            'name' => '',
            'list_id' => '',
            'email' => '',
            'firstname' => '',
            'lastname' => '',
            'website' => '',
            'company' => '',
            'phone' => '',
            'address' => '',
            'city' => '',
            'state' => '',
            'zip' => '',
            'fields' => (object)[],
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
                    'key' => 'list_id',
                    'label' => 'HubSpot List',
                    'placeholder' => 'Select HubSpot Mailing List',
                    'tips' => 'Select the HubSpot Mailing List you would like to add your contacts to.',
                    'component' => 'list_ajax_options',
                    'options' => $this->getLists(),
                ],
                [
                    'key' => 'fields',
                    'require_list' => true,
                    'label' => 'Map Fields',
                    'tips' => 'Select which Fluent Form fields pair with their<br /> respective HubSpot fields.',
                    'component' => 'map_fields',
                    'field_label_remote' => 'HubSpot Field',
                    'field_label_local' => 'Form Field',
                    'primary_fileds' => [
                        [
                            'key' => 'email',
                            'label' => 'Email Address',
                            'required' => true,
                            'input_options' => 'emails'
                        ],
                        [
                            'key' => 'firstname',
                            'label' => 'First Name'
                        ],
                        [
                            'key' => 'lastname',
                            'label' => 'Last Name'
                        ],
                        [
                            'key' => 'website',
                            'label' => 'Website'
                        ],
                        [
                            'key' => 'company',
                            'label' => 'Company'
                        ],
                        [
                            'key' => 'phone',
                            'label' => 'Phone'
                        ],
                        [
                            'key' => 'address',
                            'label' => 'Address'
                        ],
                        [
                            'key' => 'city',
                            'label' => 'City'
                        ],
                        [
                            'key' => 'state',
                            'label' => 'State'
                        ],
                        [
                            'key' => 'zip',
                            'label' => 'Zip'
                        ],
                    ]
                ],
                [
                    'require_list' => true,
                    'key' => 'conditionals',
                    'label' => 'Conditional Logics',
                    'tips' => 'Allow HubSpot integration conditionally based on your submission values',
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
        $api = $this->getRemoteClient();
        $lists = $api->getLists();
        $formateddLists = [];
        foreach ($lists as $list) {
            $formateddLists[$list['listId']] = $list['name'];
        }
        return $formateddLists;
    }

    public function getMergeFields($list, $listId, $formId)
    {
        $api = $this->getRemoteClient();
        $fields = $api->getCustomFields();

        $formattedFields = [];

        foreach ($fields as $field) {
            $formattedFields[$field['name']] = $field['label'];
        }

        return $formattedFields;
    }

    public function getRemoteClient()
    {
        $settings = $this->getGlobalSettings([]);
        return new API($settings['apiKey']);
    }


    /*
     * Notification Handler
     */

    public function notify($feed, $formData, $entry, $form)
    {
        $feedData = $feed['processedValues'];
        if (!is_email($feedData['email'])) {
            $feedData['email'] = ArrayHelper::get($formData, $feedData['email']);
        }
        if (!is_email($feedData['email'])) {
            do_action('ff_integration_action_result', $feed, 'failed', 'Hubspot API call has been skipped because no valid email available');
        }

        $mainFields = ArrayHelper::only($feedData, [
            'email',
            'firstname',
            'lastname',
            'website',
            'company',
            'phone',
            'address',
            'city',
            'state',
            'zip'
        ]);

        $fields = array_filter(array_merge($mainFields, ArrayHelper::get($feedData, 'fields', [])));

        $fields = apply_filters('fluentform_hubspot_field_data', $fields, $feed, $entry, $form);

        $fields = apply_filters('fluentform_integration_data_'.$this->integrationKey, $fields, $feed, $entry);


        // Now let's prepare the data and push to hubspot
        $api = $this->getRemoteClient();

        $response = $api->subscribe($feedData['list_id'], $fields);

        if (is_wp_error($response)) {
            do_action('ff_integration_action_result', $feed, 'failed', $response->get_error_message());
        } else {
            do_action('ff_integration_action_result', $feed, 'success', 'Hubspot feed has been successfully initialed and pushed data');
        }
    }

}
