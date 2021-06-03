<?php

namespace FluentFormPro\Integrations\Automizy;

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
            'Automizy',
            'automizy',
            '_fluentform_automizy_settings',
            'automizy_feeds',
            40
        );

        $this->logo = $this->app->url('public/img/integrations/automizy.png');

        $this->description = 'Connect Automizy with WP Fluent Forms and subscribe a contact when a form is submitted.';

        $this->registerAdminHooks();

       // add_filter('fluentform_notifying_async_automizy', '__return_false');
    }

    public function getGlobalFields($fields)
    {
        return [
            'logo'             => $this->logo,
            'menu_title'       => __('Automizy API Settings', 'fluentformpro'),
            'menu_description' => __('Automizy is email marketing software. Use Fluent Form to collect customer information and automatically add it as Automizy subscriber list. <a target="_blank" rel="nofollow" href="https://app.automizy.com/api-token">Get API Token</a>', 'fluentformpro'),
            'valid_message'    => __('Your Automizy API Key is valid', 'fluentformpro'),
            'invalid_message'  => __('Your Automizy API Key is not valid', 'fluentformpro'),
            'save_button_text' => __('Save Settings', 'fluenform'),
            'fields'           => [
                'apiKey' => [
                    'type'        => 'text',
                    'placeholder' => 'API Token',
                    'label_tips'  => __("Enter your Automizy API Key, if you do not have <br>Please login to your Automizy account and go to<br>Account -> Settings -> Api Token", 'fluentformpro'),
                    'label'       => __('Automizy API Token', 'fluentformpro'),
                ]
            ],
            'hide_on_valid'    => true,
            'discard_settings' => [
                'section_description' => 'Your Automizy API integration is up and running',
                'button_text'         => 'Disconnect Automizy',
                'data'                => [
                    'apiKey' => ''
                ],
                'show_verify'         => true
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

            // Update the reCaptcha details with siteKey & secretKey.
            update_option($this->optionKey, $integrationSettings, 'no');

            wp_send_json_success([
                'message' => __('Your settings has been updated', 'fluentformpro'),
                'status'  => false
            ], 200);
        }

        //  Verify API key now
        try {
            $api = new API($settings['apiKey']);
            $result = $api->auth_test();
            if (!empty($result['error'])) {
                throw new \Exception($result['message']);
            }
        } catch (\Exception $exception) {
            wp_send_json_error([
                'message' => $exception->getMessage(),
                'status'  => false
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
            'message' => __('Your Automizy api key has been verified and successfully set', 'fluentformpro'),
            'status'  => true
        ], 200);
    }

    public function pushIntegration($integrations, $formId)
    {
        $integrations[$this->integrationKey] = [
            'title'                 => $this->title . ' Integration',
            'logo'                  => $this->logo,
            'is_active'             => $this->isConfigured(),
            'configure_title'       => 'Configuration required!',
            'global_configure_url'  => admin_url('admin.php?page=fluent_forms_settings#general-automizy-settings'),
            'configure_message'     => 'MooSend is not configured yet! Please configure your Automizy api first',
            'configure_button_text' => 'Set Automizy API'
        ];
        return $integrations;
    }

    public function getIntegrationDefaults($settings, $formId)
    {
        return [
            'name'                 => '',
            'SubscriberFirstName'  => '',
            'SubscriberLastName'   => '',
            'Email'                => '',
            'CustomFields'         => (object)[],
            'other_fields_mapping' => [
                [
                    'item_value' => '',
                    'label'      => ''
                ]
            ],
            'list_id'              => '', // Automizy
            'tags'                 => '',
            'tag_routers'            => [],
            'tag_ids_selection_type' => 'simple',
            'conditionals'         => [
                'conditions' => [],
                'status'     => false,
                'type'       => 'all'
            ],
            'enabled'              => true
        ];
    }

    public function getSettingsFields($settings, $formId)
    {
        return [
            'fields'              => [
                [
                    'key'         => 'name',
                    'label'       => 'Feed Name',
                    'required'    => true,
                    'placeholder' => 'Your Feed Name',
                    'component'   => 'text'
                ],
                [
                    'key'         => 'list_id',
                    'required'    => true,
                    'label'       => 'Automizy Mailing Lists',
                    'placeholder' => 'Select Automizy Mailing List',
                    'tips'        => 'Select the Automizy Mailing List you would like to add your contacts to.',
                    'component'   => 'select',
                    'options'     => $this->getLists(),
                ],
                [
                    'key'                => 'CustomFields',
                    'require_list'       => false,
                    'label'              => 'Primary Fields',
                    'tips'               => 'Associate your Automizy merge tags to the appropriate Fluent Form fields by selecting the appropriate form field from the list.',
                    'component'          => 'map_fields',
                    'field_label_remote' => 'Automizy Field',
                    'field_label_local'  => 'Form Field',
                    'primary_fileds'     => [
                        [
                            'key'           => 'Email',
                            'label'         => 'Email Address',
                            'required'      => true,
                            'input_options' => 'emails'
                        ],
                        [
                            'key'   => 'SubscriberFirstName',
                            'label' => 'First Name'
                        ],
                        [
                            'key'   => 'SubscriberLastName',
                            'label' => 'Last Name'
                        ]
                    ]
                ],
                [
                    'key'          => 'other_fields_mapping',
                    'require_list' => false,
                    'label'        => 'Custom Fields',
                    'remote_text'  => 'Automizy Field',
                    'tips'         => 'Select which Fluent Form fields pair with their<br /> respective Automizy fields.',
                    'component'    => 'dropdown_many_fields',
                    'local_text'   => 'Form Field',
                    'options'      => $this->getCustomFields()
                ],
                [
                    'key' => 'tags',
                    'require_list' => true,
                    'label' => 'Tags',
                    'tips' => 'Associate tags to your Automizy contacts with a comma separated list (e.g. new lead, FluentForms, web source). Commas within a merge tag value will be created as a single tag.',
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
                    'inline_tip' => 'Please provide each tag by comma separated value'                ],
                [
                    'require_list' => false,
                    'key'          => 'conditionals',
                    'label'        => 'Conditional Logics',
                    'tips'         => 'Allow Automizy integration conditionally based on your submission values',
                    'component'    => 'conditional_block'
                ],
                [
                    'require_list'   => false,
                    'key'            => 'enabled',
                    'label'          => 'Status',
                    'component'      => 'checkbox-single',
                    'checkbox_label' => 'Enable This feed'
                ]
            ],
            'button_require_list' => false,
            'integration_title'   => $this->title
        ];
    }

    public function getMergeFields($list, $listId, $formId)
    {
        return [];
    }

    private function getCustomFields()
    {
        $api = $this->getApiInstance();
        $fields = $api->getCustomFields();

        $formattedFields = [];

        foreach ($fields as $field) {
            $formattedFields[$field['name']] = $field['label'];
        }

        unset($formattedFields['firstname']);
        unset($formattedFields['lastname']);

        return $formattedFields;
    }

    protected function getLists()
    {
        $api = $this->getApiInstance();
        $lists = $api->getLists();
        $formattedLists = [];
        foreach ($lists as $list) {
            $formattedLists[$list['id']] = $list['name'];
        }
        return $formattedLists;
    }

    /*
     * Form Submission Hooks Here
     */
    public function notify($feed, $formData, $entry, $form)
    {
        $feedData = $feed['processedValues'];


        $listId = ArrayHelper::get($feedData, 'list_id');
        if (!$listId) {
            do_action('ff_integration_action_result', $feed, 'failed', 'Automizy API call has been skipped because no valid List available');
        }

        if (!is_email($feedData['Email'])) {
            $feedData['Email'] = ArrayHelper::get($formData, $feedData['Email']);
        }

        if (!is_email($feedData['Email'])) {
            do_action('ff_integration_action_result', $feed, 'failed', 'Automizy API call has been skipped because no valid email available');
            return;
        }

        $subscriber = [
            'email' => $feedData['Email']
        ];

        $customFields = [
            'firstname' => ArrayHelper::get($feedData, 'SubscriberFirstName'),
            'lastname'  => ArrayHelper::get($feedData, 'SubscriberLastName'),
        ];

        foreach ($feedData['other_fields_mapping'] as $field) {
            if (!empty($field['item_value'])) {
                $customFields[$field['label']] = $field['item_value'];
            }
        }

        $customFields = array_filter($customFields);
        if ($customFields) {
            $subscriber['customFields'] = $customFields;
        }

        $tags = $this->getSelectedTagIds($feedData, $formData, 'tags');
        if(!is_array($tags)) {
            $tags = explode(',', $tags);
        }

        $tags = array_map('trim', $tags);
        $tags = array_filter($tags);
        if ($tags) {
            $subscriber['tags'] = implode(',', $tags);
        }

        $subscriber = array_filter($subscriber);

        $subscriber = apply_filters('fluentform_integration_data_' . $this->integrationKey, $subscriber, $feed, $entry);

        $api = $this->getApiInstance();
        $result = $api->subscribe($listId, $subscriber);

        if (!empty($result['error'])) {
            $message = !empty($result['message']) ? $result['message'] : 'Automizy API call has been failed';
            do_action('ff_integration_action_result', $feed, 'failed', $message);
        } else {
            do_action('ff_integration_action_result', $feed, 'success', 'Automizy feed has been successfully initialed and pushed data');
        }
    }

    protected function getApiInstance()
    {
        $settings = $this->getApiSettings();
        return new API($settings['apiKey']);
    }
}
