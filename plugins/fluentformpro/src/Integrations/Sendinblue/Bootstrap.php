<?php
namespace FluentFormPro\Integrations\Sendinblue;

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
            'Sendinblue',
            'sendinblue',
            '_fluentform_sendinblue_settings',
            'fluentform_sendinblue_feed',
            16
        );

        $this->logo = $this->app->url('public/img/integrations/sendinblue.png');

        $this->description = 'WP Fluent Forms Sendinblue Module allows you to create contacts on your list, so you can grow your email list.';

        $this->registerAdminHooks();

    //    add_filter('fluentform_notifying_async_sendinblue', '__return_false');
    }

    public function getGlobalFields($fields)
    {
        return [
            'logo'             => $this->logo,
            'menu_title'       => __('Sendinblue API Settings', 'fluentformpro'),
            'menu_description' => __('Sendinblue is an integrated email marketing, marketing automation, and small business CRM. Save time while growing your business with sales automation. Use Fluent Form to collect customer information and automatically add it to your Sendinblue list. If you don\'t have an Sendinblue account, you can <a href="https://www.sendinblue.com//" target="_blank">sign up for one here.</a>', 'fluentformpro'),
            'valid_message'    => __('Your Sendinblue configuration is valid', 'fluentformpro'),
            'invalid_message'  => __('Your Sendinblue configuration is invalid', 'fluentformpro'),
            'save_button_text' => __('Save Settings', 'fluenform'),
            'fields'           => [
                'apiKey'    => [
                    'type'        => 'password',
                    'placeholder' => 'V3 API Key',
                    'label_tips'  => __("Enter your Sendinblue API Key, if you do not have <br>Please login to your Sendinblue account and find the api key", 'fluentformpro'),
                    'label'       => __('Sendinblue V3 API Key', 'fluentformpro'),
                ]
            ],
            'hide_on_valid'    => true,
            'discard_settings' => [
                'section_description' => 'Your Sendinblue API integration is up and running',
                'button_text'         => 'Disconnect Sendinblue',
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
            'apiKey'    => '',
            'status'    => ''
        ];

        return wp_parse_args($globalSettings, $defaults);
    }

    public function saveGlobalSettings($settings)
    {
        if (!$settings['apiKey']) {
            $integrationSettings = [
                'apiKey'    => '',
                'status'    => false
            ];

            // Update the details with siteKey & secretKey.
            update_option($this->optionKey, $integrationSettings, 'no');

            wp_send_json_success([
                'message' => __('Your settings has been updated and discarted', 'fluentformpro'),
                'status'  => false
            ], 200);
        }

        try {
            $settings['status'] = false;
            update_option($this->optionKey, $settings, 'no');       
            $api = new SendinblueApi($settings['apiKey']);
            $auth = $api->auth_test();   
            if (isset($auth['email'])) {
                $settings['status'] = true;
                update_option($this->optionKey, $settings, 'no');
                return wp_send_json_success([
                    'status'  => true,
                    'message' => __('Your settings has been updated!', 'fluentformpro')
                ], 200);
            }
            throw new \Exception('Invalid Credentials', 400);
        } catch (\Exception $e) {
            wp_send_json_error([
                'status'  => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function pushIntegration($integrations, $formId)
    {
        $integrations[$this->integrationKey] = [
            'title'                 => $this->title . ' Integration',
            'logo'                  => $this->logo,
            'is_active'             => $this->isConfigured(),
            'configure_title'       => 'Configuration required!',
            'global_configure_url'  => admin_url('admin.php?page=fluent_forms_settings#general-sendinblue-settings'),
            'configure_message'     => 'Sendinblue is not configured yet! Please configure your Sendinblue API first',
            'configure_button_text' => 'Set Sendinblue API'
        ];
        return $integrations;
    }

    public function getIntegrationDefaults($settings, $formId)
    {
        return [
            'name'                    => '',
            'list_id'                 => '',
            'fieldEmailAddress'       => '',
            'custom_field_mappings'   => (object)[],
            'default_fields'          => (object)[],
            'other_fields_mapping' => [
                [
                    'item_value' => '',
                    'label' => ''
                ]
            ],
            'ip_address' => '{ip}',
            'conditionals'            => [
                'conditions' => [],
                'status'     => false,
                'type'       => 'all'
            ],
            'enabled'                 => true
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
                    'label'       => 'Sendinblue Segment',
                    'placeholder' => 'Select Sendinblue Segment',
                    'tips'        => 'Select the Sendinblue segment you would like to add your contacts to.',
                    'component'   => 'list_ajax_options',
                    'options'     => $this->getLists()
                ],
                [
                    'key'                => 'custom_field_mappings',
                    'require_list'       => true,
                    'label'              => 'Map Fields',
                    'tips'               => 'Select which Fluent Form fields pair with their<br /> respective Sendinblue fields.',
                    'component'          => 'map_fields',
                    'field_label_remote' => 'Sendinblue Field',
                    'field_label_local'  => 'Form Field',
                    'primary_fileds'     => [
                        [
                            'key'           => 'fieldEmailAddress',
                            'label'         => 'Email Address',
                            'required'      => true,
                            'input_options' => 'emails'
                        ]
                    ],
                    'default_fields'     => [
                        array(
                            'name'     => 'first_name',
                            'label'    => esc_html__('First Name', 'fluentformpro'),
                            'required' => false
                        ),
                        array(
                            'name'     => 'last_name',
                            'label'    => esc_html__('Last Name', 'fluentformpro'),
                            'required' => false
                        )
                    ]
                ],
                [
                    'key'                => 'other_fields_mapping',
                    'require_list'       => true,
                    'label'              => 'Other Fields',
                    'tips'               => 'Select which Fluent Form fields pair with their<br /> respective Platformly fields.',
                    'component'          => 'dropdown_many_fields',
                    'field_label_remote' => 'SendInBlue Field',
                    'field_label_local'  => 'Form Field',
                    'options'            => $this->attributes()
                ],
                [
                    'require_list' => true,
                    'key'          => 'conditionals',
                    'label'        => 'Conditional Logics',
                    'tips'         => 'Allow Sendinblue integration conditionally based on your submission values',
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

    protected function getLists()
    {
        $api = $this->getApiClient();
        if (!$api) {
            return [];
        }

        $lists = $api->getLists();

        if(!$lists) {
            return [];
        }

        $formattedLists = [];
        foreach ($lists['lists'] as $list) {
            if (is_array($list)) {
                $formattedLists[strval($list['id'])] = $list['name'];
            }
        }

        return $formattedLists;
    }

    public function getMergeFields($list, $listId, $formId)
    {
        return [];
    }

    public function attributes()
    {
        $api = $this->getApiClient();
        if (!$api) {
            return [];
        }

        $attributes = $api->attributes();

        $formattedAttributes = [];
        foreach ($attributes["attributes"] as $attribute) {
            if (is_array($attribute)) {
                $formattedAttributes[$attribute['name']] = $attribute['name'];
            } 
        }
        return $formattedAttributes;
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
            do_action('ff_integration_action_result', $feed, 'failed', 'SendInBlue API call has been skipped because no valid email available');
            return;
        }

        $addData = [];
        $attributes = new \stdClass;
        $addData['listIds'] = [absint($feedData['list_id'])] ;
        $addData['email'] = $feedData['fieldEmailAddress'];

        $defaultFields = ArrayHelper::get($feedData, 'default_fields');
        $attributes->FIRSTNAME = $defaultFields['first_name'];
        $attributes->LASTNAME = $defaultFields['last_name'];

        foreach (ArrayHelper::get($feedData, 'other_fields_mapping') as $item) {   
            $label = $item['label'];
            if($item['item_value']){
                $attributes->$label = $item['item_value']; 
            }         
        } 
        
        $addData['attributes'] = $attributes;

        $addData = apply_filters('fluentform_integration_data_'.$this->integrationKey, $addData, $feed, $entry);

        $api = $this->getApiClient();
        
        $response = $api->addContact($addData);

        if (!is_wp_error($response) && !empty($response['id'])) {
            do_action('ff_integration_action_result', $feed, 'success', 'SendinBlue feed has been successfully initialed and pushed data');
        } else {
            $error = 'API Error when submitting Data';
            if(is_wp_error($response)) {
                $error = $response->get_error_message();
            }
            if(is_array($error)) {
                $error =  $response->get_error_messages()[0];
            }
            do_action('ff_integration_action_result', $feed, 'failed', $error);
        }
    }


    protected function getApiClient()
    {
        $settings = get_option($this->optionKey);
        return new SendinblueApi(
            $settings['apiKey']
        );
    }
}
