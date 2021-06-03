<?php
namespace FluentFormPro\Integrations\Aweber;

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
            'AWeber',
            'aweber',
            '_fluentform_aweber_settings',
            'fluentform_aweber_feed',
            16
        );
        $globalSettings = get_option($this->optionKey);
// dd($globalSettings);
        $this->logo = $this->app->url('public/img/integrations/aweber.png');

        $this->description = 'WP Fluent Forms Aweber Module allows you to create Aweber list signup forms in WordPress, so you can grow your email list.';

        $this->registerAdminHooks();

       //add_filter('fluentform_notifying_async_aweber', '__return_false');
    }

    public function getGlobalFields($fields)
    {
        return [
            'logo'             => $this->logo,
            'menu_title'       => __('AWeber API Settings', 'fluentformpro'),
            'menu_description' => __('AWeber is an integrated email marketing, marketing automation, and small business CRM. Save time while growing your business with sales automation. Use Fluent Form to collect customer information and automatically add it to your Aweber list. If you don\'t have an Aweber account, you can <a href="https://www.aweber.com/" target="_blank">sign up for one here.</a>', 'fluentformpro'),
            'valid_message'    => __('Your Aweber configuration is valid', 'fluentformpro'),
            'invalid_message'  => __('Your Aweber configuration is invalid', 'fluentformpro'),
            'save_button_text' => __('Save Settings', 'fluenform'),
            'config_instruction' => $this->getConfigInstractions(),
            'fields'           => [
                'authorizeCode'    => [
                    'type'        => 'password',
                    'placeholder' => 'Access token',
                    'label_tips'  => __("Enter your Aweber Access token, if you do not have <br>Please click on the get Access token", 'fluentformpro'),
                    'label'       => __('AWeber Access Token', 'fluentformpro'),
                ]
            ],
            'hide_on_valid'    => true,
            'discard_settings' => [
                'section_description' => 'Your Aweber API integration is up and running',
                'button_text'         => 'Disconnect Aweber',
                'data'                => [
                    'authorizeCode' => ''
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
            'authorizeCode'    => '',
            'access_token'     => '',
            'refresh_token'    => '',
            'status'           => '',
            'expires_at'       => null
        ];

        return wp_parse_args($globalSettings, $defaults);
    }

    public function saveGlobalSettings($settings)
    {
        if (!$settings['authorizeCode']) {
            $integrationSettings = [
                'authorizeCode'    => '',
                'access_token'     => '',
                'refresh_token'    => '',
                'status'           => false,
                'expires_at'       => null
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
            $api = new AweberApi($settings);
            $auth = $api->auth_test();
           
            if (isset($auth['refresh_token'])) {
                $settings['status'] = true;
                $settings['access_token']  = $auth['access_token'];
                $settings['refresh_token'] = $auth['refresh_token'];
                $settings['expires_at']    = time() + intval($auth['expires_in']);;  
               

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
            'global_configure_url'  => admin_url('admin.php?page=fluent_forms_settings#general-aweber-settings'),
            'configure_message'     => 'Aweber is not configured yet! Please configure your Aweber API first',
            'configure_button_text' => 'Set Aweber API'
        ];
        return $integrations;
    }

    protected function getConfigInstractions()
    {
        ob_start();
        ?>
        <div><h4>To Authenticate AWeber you need an access token.</h4>
            <ol>
                <li>Click here to <a
                        href="<?php echo $this->getAuthenticateUri(); ?>""
                        target="_blank">Get Access Token</a>.
                </li>
                <li>Then login and allow with your AWeber account.</li>
                <li>Copy your your access token and paste bellow field then click Verify AWeber.</li>
            </ol>
        </div>
        <?php
        return ob_get_clean();
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
                // [
                //     'key'         => 'list_id',
                //     'label'       => 'Aweber Segment',
                //     'placeholder' => 'Select Aweber Segment',
                //     'tips'        => 'Select the Aweber segment you would like to add your contacts to.',
                //     'component'   => 'list_ajax_options',
                //     'options'     => $this->getLists()
                // ],
                [
                    'key'                => 'custom_field_mappings',
                    // 'require_list'       => true,
                    'label'              => 'Map Fields',
                    'tips'               => 'Select which Fluent Form fields pair with their<br /> respective Aweber fields.',
                    'component'          => 'map_fields',
                    'field_label_remote' => 'Aweber Field',
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
                    // 'require_list'       => true,
                    'label'              => 'Other Fields',
                    'tips'               => 'Select which Fluent Form fields pair with their<br /> respective Aweber fields.',
                    'component'          => 'dropdown_many_fields',
                    'field_label_remote' => 'Aweber Field',
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
                    'key'          => 'note',
                    // 'require_list' => true,
                    'label'        => 'Note',
                    'placeholder'  => 'write a note for this contact',
                    'tips'         => 'You can write a note for this contact',
                    'component'    => 'value_textarea'
                ],
                [
                    // 'require_list' => true,
                    'key'          => 'conditionals',
                    'label'        => 'Conditional Logics',
                    'tips'         => 'Allow Aweber integration conditionally based on your submission values',
                    'component'    => 'conditional_block'
                ],
                [
                    // 'require_list'    => true,
                    'key'             => 'enabled',
                    'label'           => 'Status',
                    'component'       => 'checkbox-single',
                    'checkbox_label' => 'Enable This feed'
                ]
            ],
            // 'button_require_list' => true,
            'integration_title'   => $this->title
        ];
    }

    protected function getLists()
    {
        // $api = $this->getApiClient();
        // if (!$api) {
        //     return [];
        // }

        // $lists = $api->getLists();


        // $formattedLists = [];
        // foreach ($lists as $list) {
        //     if (is_array($list)) {
        //         $formattedLists[$list['id']] = $list['name'];
        //     }
        // }

        return $formattedLists= ['list'];
    }

    // getting available tags

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

    public function getAuthenticateUri()
    {
        $api = $this->getApiClient();
        return $api->makeAuthorizationUrl();
    }

    /*
     * Submission Broadcast Handler
     */

    public function notify($feed, $formData, $entry, $form)
    {
        $api = $this->getApiClient();
        $response = $api->addContact($addData);
        


        // die
        $feedData = $feed['processedValues'];
        if (!is_email($feedData['fieldEmailAddress'])) {
            $feedData['fieldEmailAddress'] = ArrayHelper::get($formData, $feedData['fieldEmailAddress']);
        }

        if (!is_email($feedData['fieldEmailAddress'])) {
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

        $tags = implode(",", $feedData['tags']);

        if ($tags) {
            $addData['tag'] = $tags;
        }
        $addData['segment'] = $feedData['list_id'];
        $addData['ip'] = $feedData['ip_address'];
        $addData = array_filter($addData);

        $addData['email'] = $feedData['fieldEmailAddress'];

        $addData['time'] = time();

        // Now let's prepare the data and push to hubspot
        $api = $this->getApiClient();

        $response = $api->addContact($addData);


        if (!is_wp_error($response) && $response['status'] === 'success') {
           
            do_action('ff_log_data', [
                'parent_source_id' => $form->id,
                'source_type'      => 'submission_item',
                'source_id'        => $entry->id,
                'component'        => $this->integrationKey,
                'status'           => 'success',
                'title'            => $feed['settings']['name'],
                'description'      => 'Aweber feed has been successfully initialed and pushed data'
            ]);
        } else {
            // Contact adding failed
            do_action('ff_log_data', [
                'parent_source_id' => $form->id,
                'source_type'      => 'submission_item',
                'source_id'        => $entry->id,
                'component'        => $this->integrationKey,
                'status'           => 'failed',
                'title'            => $feed['settings']['name'],
                'description'      => is_wp_error($response) ? $response->get_error_messages() : 'API Error when submitting Data'
            ]);
        }
    }


    protected function getApiClient()
    {
        $settings = get_option($this->optionKey);
        return new AweberApi(
            $settings
        );
    }
}
