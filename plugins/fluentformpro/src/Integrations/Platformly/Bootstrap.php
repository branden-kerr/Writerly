<?php
namespace FluentFormPro\Integrations\Platformly;

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
            'Platformly',
            'platformly',
            '_fluentform_platformly_settings',
            'fluentform_platformly_feed',
            16
        );

        $this->logo = $this->app->url('public/img/integrations/platformly.png');

        $this->description = 'WP Fluent Forms Platformly Module allows you to create Platformly list signup forms in WordPress, so you can grow your email list.';

        $this->registerAdminHooks();

//        add_filter('fluentform_notifying_async_platformly', '__return_false');
    }

    public function getGlobalFields($fields)
    {
        return [
            'logo'             => $this->logo,
            'menu_title'       => __('Platformly API Settings', 'fluentformpro'),
            'menu_description' => __('Platformly is an integrated email marketing, marketing automation, and small business CRM. Save time while growing your business with sales automation. Use Fluent Form to collect customer information and automatically add it to your Platformly list. If you don\'t have an Platformly account, you can <a href="https://www.platform.ly/" target="_blank">sign up for one here.</a>', 'fluentformpro'),
            'valid_message'    => __('Your Platformly configuration is valid', 'fluentformpro'),
            'invalid_message'  => __('Your Platformly configuration is invalid', 'fluentformpro'),
            'save_button_text' => __('Save Settings', 'fluenform'),
            'fields'           => [
                'apiKey'    => [
                    'type'        => 'password',
                    'placeholder' => 'API Key',
                    'label_tips'  => __("Enter your Platformly API Key, if you do not have <br>Please login to your Platformly account and find the api key", 'fluentformpro'),
                    'label'       => __('Platformly API Key', 'fluentformpro'),
                ],
                'projectId' => [
                    'type'        => 'number',
                    'placeholder' => 'Project ID',
                    'required'    => true,
                    'label_tips'  => __("Please Provide your Platformly project id", 'fluentformpro'),
                    'label'       => __('Platformly project id', 'fluentformpro'),
                ],
            ],
            'hide_on_valid'    => true,
            'discard_settings' => [
                'section_description' => 'Your Platformly API integration is up and running',
                'button_text'         => 'Disconnect Platformly',
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
            'projectId' => '',
            'status'    => ''
        ];

        return wp_parse_args($globalSettings, $defaults);
    }

    public function saveGlobalSettings($settings)
    {
        if (!$settings['apiKey']) {
            $integrationSettings = [
                'apiKey'    => '',
                'projectId' => '',
                'status'    => false
            ];

            // Update the reCaptcha details with siteKey & secretKey.
            update_option($this->optionKey, $integrationSettings, 'no');

            wp_send_json_success([
                'message' => __('Your settings has been updated and discarded', 'fluentformpro'),
                'status'  => true
            ], 200);
        }

        try {
            $settings['status'] = false;
            update_option($this->optionKey, $settings, 'no');
            $api = new PlatformlyApi($settings['apiKey'], $settings['projectId']);
            $auth = $api->auth_test();
            if (isset($auth['account_id'])) {
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
            'global_configure_url'  => admin_url('admin.php?page=fluent_forms_settings#general-platformly-settings'),
            'configure_message'     => 'Platformly is not configured yet! Please configure your Platformly API first',
            'configure_button_text' => 'Set Platformly API'
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
            'tags'                    => [],
            'tag_ids_selection_type' => 'simple',
            'tag_routers'            => [],
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
                    'label'       => 'Platformly Segment',
                    'placeholder' => 'Select Platformly Segment',
                    'tips'        => 'Select the Platformly segment you would like to add your contacts to.',
                    'component'   => 'list_ajax_options',
                    'options'     => $this->getLists()
                ],
                [
                    'key'                => 'custom_field_mappings',
                    'require_list'       => true,
                    'label'              => 'Map Fields',
                    'tips'               => 'Select which Fluent Form fields pair with their<br /> respective Platformly fields.',
                    'component'          => 'map_fields',
                    'field_label_remote' => 'Platformly Field',
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
                        ),
                        array(
                            'name'     => 'phone',
                            'label'    => esc_html__('Phone Number', 'fluentformpro'),
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
                    'field_label_remote' => 'Platformly Field',
                    'field_label_local'  => 'Form Field',
                    'options' => [
                        'company' => 'Company Name',
                        'address' => 'Address Line 1',
                        'address2' => 'Address Line 2',
                        'city' => 'City',
                        'state' => 'State',
                        'zip' => 'ZIP code',
                        'country' => 'Country',
                        'fax' => 'Fax',
                        'sms_number' => 'SMS Number',
                        'phone' => 'Phone',
                        'birthday' => 'Birthday',
                        'website' => 'Website'
                    ]
                ],
                [
                    'key'          => 'tags',
                    'require_list' => true,
                    'label'        => 'Contact Tags',
                    'placeholder' => 'Select Tags',
                    'component'    => 'selection_routing',
                    'simple_component' => 'select',
                    'routing_input_type' => 'select',
                    'routing_key'  => 'tag_ids_selection_type',
                    'settings_key' => 'tag_routers',
                    'is_multiple'  => true,
                    'labels'       => [
                        'choice_label'      => 'Enable Dynamic Tag Selection',
                        'input_label'       => '',
                        'input_placeholder' => 'Set Tag'
                    ],
                    'options'      => $this->getTags()
                ],
                [
                    'key'          => 'note',
                    'require_list' => true,
                    'label'        => 'Note',
                    'placeholder'  => 'write a note for this contact',
                    'tips'         => 'You can write a note for this contact',
                    'component'    => 'value_textarea'
                ],
                [
                    'require_list' => true,
                    'key'          => 'conditionals',
                    'label'        => 'Conditional Logics',
                    'tips'         => 'Allow Platformly integration conditionally based on your submission values',
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


        $formattedLists = [];
        foreach ($lists as $list) {
            if (is_array($list)) {
                $formattedLists[$list['id']] = $list['name'];
            }
        }

        return $formattedLists;
    }

    // getting available tags
    protected function getTags()
    {
        $api = $this->getApiClient();
        if (!$api) {
            return [];
        }

        $tags = $api->getTags();

        $formattedLists = [];
        foreach ($tags as $tag) {
            if (is_array($tag)) {
                $formattedLists[strval($tag['id'])] = $tag['name'];
            }
        }

        return $formattedLists;
    }

    public function getMergeFields($list, $listId, $formId)
    {
        $api = $this->getApiClient();
        $fields = $api->getCustomFields();

        $formattedFileds = [];
        foreach ($fields as $field) {
            $formattedFileds['cf_'.$field['alias'].'_'.$field['id']] = $field['name'];
        }
        return $formattedFileds;
    }

    /**
     * Prepare Platformly forms for feed field.
     *
     * @return array
     */

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
            do_action('ff_integration_action_result', $feed, 'error', 'Email is not valid for integration');
            return;
        }

        $addData = [];
        $addData = array_merge($addData, ArrayHelper::get($feedData, 'default_fields'));


        if(ArrayHelper::get($feedData, 'custom_field_mappings')){
            $addData = array_merge($addData, ArrayHelper::get($feedData, 'custom_field_mappings'));
        }

        foreach (ArrayHelper::get($feedData, 'other_fields_mapping') as $item) {
            $addData[$item['label']] = $item['item_value'];
        }

        $tags = $this->getSelectedTagIds($feedData, $formData, 'tags');
        if ($tags) {
            $contact['tags'] = implode(",", $tags);
        }

        $addData['segment'] = $feedData['list_id'];
        $addData['ip'] = $feedData['ip_address'];
        $addData = array_filter($addData);

        $addData['email'] = $feedData['fieldEmailAddress'];

        $addData['time'] = time();

        $addData = apply_filters('fluentform_integration_data_'.$this->integrationKey, $addData, $feed, $entry);

        // Now let's prepare the data and push to Platformly
        $api = $this->getApiClient();
        $response = $api->addContact($addData);

        if (!is_wp_error($response) && $response['status'] === 'success') {
            do_action('ff_integration_action_result', $feed, 'success', 'Platformly feed has been successfully initialed and pushed data');
            if (ArrayHelper::get($feedData, 'note')) {          
                $api->add_note($response["data"]["cc_id"], ArrayHelper::get($feedData, 'fieldEmailAddress'), ArrayHelper::get($feedData, 'note'));
            }
        } else {
            $error = is_wp_error($response) ? $response->get_error_messages() : 'API Error when submitting Data';
            do_action('ff_integration_action_result', $feed, 'failed', $error);
        }
    }


    protected function getApiClient()
    {
        $settings = get_option($this->optionKey);
        return new PlatformlyApi(
            $settings['apiKey'], $settings['projectId']
        );
    }
}
