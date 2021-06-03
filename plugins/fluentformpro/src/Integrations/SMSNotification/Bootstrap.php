<?php

namespace FluentFormPro\Integrations\SMSNotification;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Services\Integrations\IntegrationManager;
use FluentForm\Framework\Foundation\Application;

class Bootstrap extends IntegrationManager
{
    public function __construct(Application $app)
    {
        parent::__construct(
            $app,
            'SMS Notification',
            'sms_notification',
            '_fluentform_sms_notification_settings',
            'sms_notification_feed',
            25
        );

        $this->logo = $this->app->url('public/img/integrations/twillio.png');

        $this->description = 'Send SMS in real time when a form is submitted with Twillio.';


        $this->registerAdminHooks();

//        add_filter('fluentform_notifying_async_sms_notification', '__return_false');
    }

    public function getGlobalFields($fields)
    {
        return [
            'logo'             => $this->logo,
            'menu_title'       => __('SMS Provider Settings (Twillio)', 'fluentformpro'),
            'menu_description' => __('Please Provide your Twillio Settings here', 'fluentformpro'),
            'valid_message'    => __('Your Twillio API Key is valid', 'fluentformpro'),
            'invalid_message'  => __('Your Twillio API Key is not valid', 'fluentformpro'),
            'save_button_text' => __('Save Settings', 'fluentformpro'),
            'fields'           => [
                'senderNumber' => [
                    'type'        => 'text',
                    'placeholder' => 'Twillio Number',
                    'label_tips'  => __("Enter your twillo sender number", 'fluentformpro'),
                    'label'       => __('Number From', 'fluentformpro'),
                ],
                'accountSID'   => [
                    'type'        => 'text',
                    'placeholder' => 'Account SID',
                    'label_tips'  => __("Enter Twillio Account SID. This can be found from twillio", 'fluentformpro'),
                    'label'       => __('Account SID', 'fluentformpro'),
                ],
                'authToken'    => [
                    'type'        => 'password',
                    'placeholder' => 'Auth Token',
                    'label_tips'  => __("Enter Twillio API Auth Token. This can be found from twillio", 'fluentformpro'),
                    'label'       => __('Auth Token', 'fluentformpro'),
                ]
            ],
            'hide_on_valid'    => true,
            'discard_settings' => [
                'section_description' => 'Your Twillio API integration is up and running',
                'button_text'         => 'Disconnect Twillio',
                'data'                => [
                    'authToken' => ''
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
            'senderNumber' => '',
            'accountSID'   => '',
            'authToken'    => '',
            'provider'     => 'twillio'
        ];

        return wp_parse_args($globalSettings, $defaults);
    }

    public function saveGlobalSettings($settings)
    {
        if (!$settings['authToken']) {
            $integrationSettings = [
                'senderNumber' => '',
                'accountSID'   => '',
                'authToken'    => '',
                'provider'     => 'twillio',
                'status'       => false
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
            
             if (empty($settings['senderNumber'])) {
                 //prevent saving integration without the sender number
                 throw new \Exception('Sender number is required');
                 
             }
            $integrationSettings = [
                'senderNumber' => sanitize_textarea_field($settings['senderNumber']),
                'accountSID'   => sanitize_text_field($settings['accountSID']),
                'authToken'    => sanitize_text_field($settings['authToken']),
                'provider'     => 'twillio',
                'status'       => false
            ];
            update_option($this->optionKey, $integrationSettings, 'no');

            $api = new TwillioApi($settings['authToken'], $settings['accountSID']);
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
            'senderNumber' => sanitize_textarea_field($settings['senderNumber']),
            'accountSID'   => sanitize_text_field($settings['accountSID']),
            'authToken'    => sanitize_text_field($settings['authToken']),
            'provider'     => 'twillio',
            'status'       => true
        ];

        // Update the reCaptcha details with siteKey & secretKey.
        update_option($this->optionKey, $integrationSettings, 'no');

        wp_send_json_success([
            'message' => __('Your Twillio api key has been verified and successfully set', 'fluentformpro'),
            'status'  => true
        ], 200);
    }

    public function pushIntegration($integrations, $formId)
    {
        $integrations[$this->integrationKey] = [
            'title'                 => 'SMS Notification by Twillio',
            'logo'                  => $this->logo,
            'is_active'             => $this->isConfigured(),
            'configure_title'       => 'Configuration required!',
            'global_configure_url'  => admin_url('admin.php?page=fluent_forms_settings#general-sms_notification-settings'),
            'configure_message'     => 'SMS Notification is not configured yet! Please configure your SMS api first',
            'configure_button_text' => 'Set SMS Notification API'
        ];
        return $integrations;
    }

    public function getIntegrationDefaults($settings, $formId)
    {
        return [
            'name'            => '',
            'receiver_number' => '',
            'message'         => '',
            'conditionals'    => [
                'conditions' => [],
                'status'     => false,
                'type'       => 'all'
            ],
            'enabled'         => true
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
                    'key'         => 'receiver_number',
                    'label'       => 'To',
                    'required'    => true,
                    'placeholder' => 'Type the receiver number',
                    'component'   => 'value_text'
                ],
                [
                    'key'         => 'message',
                    'label'       => 'SMS text',
                    'required'    => true,
                    'placeholder' => 'SMS Text',
                    'component'   => 'value_textarea'
                ],
                [
                    'require_list' => false,
                    'key'          => 'conditionals',
                    'label'        => 'Conditional Logics',
                    'tips'         => 'Send SMS Notication conditionally based on your submission values',
                    'component'    => 'conditional_block'
                ],
                [
                    'require_list'    => false,
                    'key'             => 'enabled',
                    'label'           => 'Status',
                    'component'       => 'checkbox-single',
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


    /*
     * Form Submission Hooks Here
     */
    public function notify($feed, $formData, $entry, $form)
    {
        $feedData = $feed['processedValues'];

        if (empty($feedData['receiver_number']) || empty($feedData['message'])) {
            do_action('ff_integration_action_result', $feed, 'failed',  'no valid receiver_number found');
            return;
        }

        $apiSettings = $this->getGlobalSettings([]);

        $smsData = [
            'Body' => $feedData['message'],
            'From' => $apiSettings['senderNumber'],
            'To'   => $feedData['receiver_number']
        ];

        $smsData = apply_filters('fluentform_integration_data_'.$this->integrationKey, $smsData, $feed, $entry);

        $api = $this->getRemoteClient();
        $response = $api->sendSMS($apiSettings['accountSID'], $smsData);

        if (is_wp_error($response)) {
            do_action('ff_integration_action_result', $feed, 'failed',  $response->get_error_message());
        } else {
            do_action('ff_integration_action_result', $feed, 'success', 'Twilio SMS feed has been successfully initialed and pushed data');
        }
    }

    public function getRemoteClient()
    {
        $settings = $this->getGlobalSettings([]);
        return new TwillioApi($settings['authToken'], $settings['accountSID']);
    }

}
