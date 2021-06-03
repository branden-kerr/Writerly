<?php

namespace FluentFormPro\Integrations\GetGist;

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
            'GetGist',
            'getgist',
            '_fluentform_getgist_settings',
            'getgist_feed',
            36
        );

        $this->logo = $this->app->url('public/img/integrations/getgist.png');

        $this->description = 'GetGist is Easy to use all-in-one software for live chat, email marketing automation, forms, knowledge base, and more for a complete 360° view of your contacts.';

        $this->registerAdminHooks();

       // add_filter('fluentform_notifying_async_getgist', '__return_false');
    }

    public function getGlobalFields($fields)
    {
        return [
            'logo'             => $this->logo,
            'menu_title'       => __('GetGist Settings', 'fluentformpro'),
            'menu_description' => $this->description,
            'valid_message'    => __('Your GetGist API Key is valid', 'fluentformpro'),
            'invalid_message'  => __('Your GetGist API Key is not valid', 'fluentformpro'),
            'save_button_text' => __('Save Settings', 'fluentformpro'),
            'fields'           => [
                'apiKey' => [
                    'type'        => 'text',
                    'placeholder' => 'API Key',
                    'label_tips'  => __("Enter your GetGist API Key, if you do not have <br>Please login to your GetGist account and go to<br>Settings -> Integrations -> API key", 'fluentformpro'),
                    'label'       => __('GetGist API Key', 'fluentformpro'),
                ]
            ],
            'hide_on_valid'    => true,
            'discard_settings' => [
                'section_description' => 'Your GetGist API integration is up and running',
                'button_text'         => 'Disconnect GetGist',
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

        // Verify API key now
        try {
            $integrationSettings = [
                'apiKey' => sanitize_text_field($settings['apiKey']),
                'status' => false
            ];
            update_option($this->optionKey, $integrationSettings, 'no');

            $api = new API($settings['apiKey']);
            $result = $api->auth_test();

            if (!empty($result['error'])) {
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
            'message' => __('Your GetGist api key has been verified and successfully set', 'fluentformpro'),
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
            'global_configure_url'  => admin_url('admin.php?page=fluent_forms_settings#general-getgist-settings'),
            'configure_message'     => 'GetGist is not configured yet! Please configure your GetGist api first',
            'configure_button_text' => 'Set GetGist API'
        ];
        return $integrations;
    }

    public function getIntegrationDefaults($settings, $formId)
    {
        return [
            'name'         => '',
            'list_id'      => '',
            'fields'       => (object)[],
            'conditionals' => [
                'conditions' => [],
                'status'     => false,
                'type'       => 'all'
            ],
            'resubscribe'  => false,
            'enabled'      => true
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
                    'key'                => 'fields',
                    'label'              => 'Map Fields',
                    'tips'               => 'Select which Fluent Form fields pair with their<br /> respective Gist fields.',
                    'component'          => 'map_fields',
                    'field_label_remote' => 'Gist Field',
                    'field_label_local'  => 'Form Field',
                    'primary_fileds'     => [
                        [
                            'key'           => 'email',
                            'label'         => 'Email Address',
                            'required'      => true,
                            'input_options' => 'emails'
                        ],
                        [
                            'key'           => 'lead_name',
                            'label'         => 'Name',
                            'required'      => false
                        ],
                        [
                            'key'           => 'lead_phone',
                            'label'         => 'Phone',
                            'required'      => false
                        ]
                    ]
                ],
                [
                    'key'         => 'tags',
                    'label'       => 'Lead Tags',
                    'required'    => false,
                    'placeholder' => 'Tags',
                    'component'   => 'value_text',
                    'inline_tip' => 'Use comma separated value. You can use smart tags here'
                ],
                [
                    'key'             => 'landing_url',
                    'label'           => 'Landing URL',
                    'tips'            => 'When this option is enabled, FluentForm will pass the form page url to the gist lead',
                    'component'       => 'checkbox-single',
                    'checkbox_label' => 'Enable Landing URL'
                ],
                [
                    'key'             => 'last_seen_ip',
                    'label'           => 'Push IP Address',
                    'tips'            => 'When this option is enabled, FluentForm will pass the last_seen_ip to gist',
                    'component'       => 'checkbox-single',
                    'checkbox_label' => 'Enable last IP address'
                ],
                [
                    'key'          => 'conditionals',
                    'label'        => 'Conditional Logics',
                    'tips'         => 'Allow Gist integration conditionally based on your submission values',
                    'component'    => 'conditional_block'
                ],
                [
                    'key'             => 'enabled',
                    'label'           => 'Status',
                    'component'       => 'checkbox-single',
                    'checkbox_label' => 'Enable This feed'
                ]
            ],
            'integration_title'   => $this->title
        ];
    }

    protected function getLists()
    {
        return [];
    }

    public function getMergeFields($list = false, $listId = false, $formId = false)
    {
       return [];
    }


    /*
     * Form Submission Hooks Here
     */
    public function notify($feed, $formData, $entry, $form)
    {
        $feedData = $feed['processedValues'];
        $subscriber = [
            'name' => ArrayHelper::get($feedData, 'lead_name'),
            'email' => ArrayHelper::get($feedData, 'email'),
            'phone' => ArrayHelper::get($feedData, 'lead_phone'),
            'created_at' => time(),
            'last_seen_at' => time()
        ];

        $tags = ArrayHelper::get($feedData, 'tags');
        if($tags) {
            $tags = explode(',', $tags);
            $formtedTags = [];
            foreach ($tags as $tag) {
                $formtedTags[] = wp_strip_all_tags(trim($tag));
            }
            $subscriber['tags'] = $formtedTags;
        }

        if(ArrayHelper::isTrue($feedData, 'landing_url')) {
            $subscriber['landing_url'] = $entry->source_url;
        }

        if(ArrayHelper::isTrue($feedData, 'last_seen_ip')) {
            $subscriber['last_seen_ip'] = $entry->ip;
        }

        $subscriber = array_filter($subscriber);

        if(!empty($subscriber['email']) && !is_email($subscriber['email'])) {
            $subscriber['email'] = ArrayHelper::get($formData, $subscriber['email']);
        }

        if(!is_email($subscriber['email'])) {
            do_action('ff_integration_action_result', $feed, 'failed', 'GetGist API called skipped because no valid email available');
            return;
        }


        $subscriber = apply_filters('fluentform_integration_data_'.$this->integrationKey, $subscriber, $feed, $entry);


        $api = $this->getRemoteClient();
        $response = $api->subscribe($subscriber);

        if (is_wp_error($response)) {
            do_action('ff_integration_action_result', $feed, 'failed', $response->get_error_message());
        } else {
            do_action('ff_integration_action_result', $feed, 'success', 'GetGist feed has been successfully initialed and pushed data');
        }
    }

    public function getRemoteClient()
    {
        $settings = $this->getGlobalSettings([]);
        return new API($settings['apiKey']);
    }

}
