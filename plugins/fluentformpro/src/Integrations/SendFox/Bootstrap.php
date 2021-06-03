<?php

namespace FluentFormPro\Integrations\SendFox;

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
            'SendFox',
            'sendfox',
            '_fluentform_sendfox_settings',
            'sendfox_feeds',
            21
        );

        $this->logo = $this->app->url('public/img/integrations/sendfox.png');

        $this->description = 'Connect SendFox with WP Fluent Forms and subscribe a contact when a form is submitted.';

        $this->registerAdminHooks();

       // add_filter('fluentform_notifying_async_sendfox', '__return_false');
    }

    public function getGlobalFields($fields)
    {
        return [
            'logo'             => $this->logo,
            'menu_title'       => __('SendFox API Settings', 'fluentformpro'),
            'menu_description' => __('SendFox is email marketing software. Use Fluent Form to collect customer information and automatically add it as SendFox subscriber list.', 'fluentformpro'),
            'valid_message'    => __('Your SendFox API Key is valid', 'fluentformpro'),
            'invalid_message'  => __('Your SendFox API Key is not valid', 'fluentformpro'),
            'save_button_text' => __('Save Settings', 'fluenform'),
            'fields'           => [
                'apiKey' => [
                    'type'        => 'textarea',
                    'placeholder' => 'API Key',
                    'label_tips'  => __("Enter your SendFox API Key, if you do not have <br>Please login to your Sendfox account and go to<br>Account -> Appi Key", 'fluentformpro'),
                    'label'       => __('SendFox API Key', 'fluentformpro'),
                ]
            ],
            'hide_on_valid'    => true,
            'discard_settings' => [
                'section_description' => 'Your SendFox API integration is up and running',
                'button_text'         => 'Disconnect SendFox',
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
            'message' => __('Your SendFox api key has been verified and successfully set', 'fluentformpro'),
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
            'global_configure_url'  => admin_url('admin.php?page=fluent_forms_settings#general-sendfox-settings'),
            'configure_message'     => 'MooSend is not configured yet! Please configure your SendFox api first',
            'configure_button_text' => 'Set SendFox API'
        ];
        return $integrations;
    }

    public function getIntegrationDefaults($settings, $formId)
    {
        return [
            'name'                   => '',
            'SubscriberFirstName'         => '', // Name in SendFox
            'SubscriberLastName'         => '', // Name in SendFox
            'Email'                  => '',
            'CustomFields'           => (object)[],
            'list_id'                => '', // SendFox
            'conditionals'           => [
                'conditions' => [],
                'status'     => false,
                'type'       => 'all'
            ],
            'enabled'                => true
        ];
    }

    public function getSettingsFields($settings, $formId)
    {
        return [
            'fields'              => [
                [
                    'key'         => 'name',
                    'label'       => 'Name',
                    'required'    => true,
                    'placeholder' => 'Your Feed Name',
                    'component'   => 'text'
                ],
                [
                    'key'         => 'list_id',
                    'label'       => 'SendFox Mailing Lists',
                    'placeholder' => 'Select SendFox Mailing List',
                    'tips'        => 'Select the SendFox Mailing List you would like to add your contacts to.',
                    'component'   => 'list_ajax_options',
                    'options'     => $this->getLists(),
                ],
                [
                    'key'                => 'CustomFields',
                    'require_list'       => true,
                    'label'              => 'Map Fields',
                    'tips'               => 'Associate your SendFox merge tags to the appropriate Fluent Form fields by selecting the appropriate form field from the list.',
                    'component'          => 'map_fields',
                    'field_label_remote' => 'SendFox Field',
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
                    'require_list' => true,
                    'key'          => 'conditionals',
                    'label'        => 'Conditional Logic',
                    'tips'         => 'Allow SendFox integration conditionally based on your submission values',
                    'component'    => 'conditional_block'
                ],
                [
                    'require_list'    => true,
                    'key'             => 'enabled',
                    'label'           => 'Status',
                    'component'       => 'checkbox-single',
                    'checkbox_label' => 'Enable This feed'
                ]
            ],
            'button_require_list' => true,
            'integration_title'   => $this->title
        ];
    }

    public function getMergeFields($list, $listId, $formId)
    {
        return [];
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
        if (!is_email($feedData['Email'])) {
            $feedData['Email'] = ArrayHelper::get($formData, $feedData['Email']);
        }

        if (!is_email($feedData['Email'])) {
            do_action('ff_integration_action_result', $feed, 'failed', 'SendFox API call has been skipped because no valid email available');
            return;
        }

        $subscriber = [
            'first_name'  => $feedData['SubscriberFirstName'],
            'last_name'  => $feedData['SubscriberLastName'],
            'email' => $feedData['Email'],
            'tags' => [
                $feedData['list_id']
            ]
        ];
        $subscriber = array_filter($subscriber);

        $subscriber = apply_filters('fluentform_integration_data_'.$this->integrationKey, $subscriber, $feed, $entry);

        $api = $this->getApiInstance();
        $result = $api->subscribe($subscriber);
        if (!$result) {
            do_action('ff_integration_action_result', $feed, 'failed', 'SendFox API call has been failed');
        } else {
            do_action('ff_integration_action_result', $feed, 'success', 'SendFox feed has been successfully initialed and pushed data');
        }
    }

    protected function getApiInstance()
    {
        $settings = $this->getApiSettings();
        return new API($settings['apiKey']);
    }
}
