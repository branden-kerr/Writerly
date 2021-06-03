<?php

namespace FluentFormPro\Integrations\ConstantContact;

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
            'ConstantContact',
            'constatantcontact',
            '_fluentform_constantcontact_settings_v2',
            'constantcontact_feed',
            26
        );

        $this->logo = $this->app->url('public/img/integrations/constantcontact.png');

        $this->description = 'Connect ConstantContact with WP Fluent Forms and create subscriptions forms right into WordPress and grow your list.';

        $this->registerAdminHooks();

       //add_filter('fluentform_notifying_async_constatantcontact', '__return_false');
    }

    public function getGlobalFields($fields)
    {
        return [
            'logo'               => $this->logo,
            'menu_title'         => __('Constant Contact API Settings', 'fluentformpro'),
            'menu_description'   => __('Constant Contact is an integrated email marketing, marketing automation, and small business CRM. Save time while growing your business with sales automation. Use Fluent Form to collect customer information and automatically add it to your Constant Contact list. If you don\'t have an Constant Contact account, you can <a href="https://www.trello.com/" target="_blank">sign up for one here.</a>', 'fluentformpro'),
            'valid_message'      => __('Your Constant Contact configuration is valid', 'fluentformpro'),
            'invalid_message'    => __('Your Constant Contact configuration is invalid', 'fluentformpro'),
            'save_button_text'   => __('Verify Constant Contact ', 'fluenform'),
            'config_instruction' => $this->getConfigInstractions(),
            'fields'             => [
                'accessToken' => [
                    'type'        => 'text',
                    'placeholder' => 'access token Key',
                    'label_tips'  => __("Enter your Constant Contact access token Key, if you do not have <br>Please click here to get yours", 'fluentformpro'),
                    'label'       => __('Constant Contact access Key', 'fluentformpro'),
                ],
            ],
            'hide_on_valid'      => true,
            'discard_settings'   => [
                'section_description' => 'Your Constant Contact API integration is up and running',
                'button_text'         => 'Disconnect Constant Contact',
                'data'                => [
                    'accessToken' => ''
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
            'accessToken' => '',
            'status'      => ''
        ];

        return wp_parse_args($globalSettings, $defaults);
    }

    /*
    * Saving The Global Settings
    *
    */
   public function saveGlobalSettings($settings)
   {
       if (!$settings['accessToken']) {
           $integrationSettings = [
               'accessToken' => '',
               'status'      => false
           ];
           // Update the  details with access token
           update_option($this->optionKey, $integrationSettings, 'no');
           wp_send_json_success([
               'message'      => __('Your settings has been updated', 'fluentformpro'),
               'status'       => false,
               'require_load' => true
           ], 200);
       }

       try {
           $settings['status'] = false;
           update_option($this->optionKey, $settings, 'no');
           $api = new API($settings['accessToken']);
           $auth = $api->auth_test();
           
           if (!$auth[0]['error_key']) {
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
           'global_configure_url'  => admin_url('admin.php?page=fluent_forms_settings#general-constatantcontact-settings'),
           'configure_message'     => 'ConstantContact is not configured yet! Please configure your ConstantContact api first',
           'configure_button_text' => 'Set ConstantContact API'
       ];
       return $integrations;
   }

   public function getIntegrationDefaults($settings, $formId)
   {
       return [
           'name'            => '',
           'list_id'         => '',
           'email_address'   => '',
           'first_name'      => '',
           'last_name'       => '',
           'job_title'       => '',
           'company_name'    => '',
           'home_phone'     => '',
           'work_phone'     => '',
           'address_line_1'  => '',
           'address_line_2'  => '',
           'city_name'       => '',
           'state_name'      => '',
           'zip_code'        => '',
           'country_name'    => '',
           'custom_fields'   => (object)[],
           'conditionals'    => [
               'conditions' => [],
               'status'     => false,
               'type'       => 'all'
           ],
           'update_if_exist' => false,
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
                   'placeholder' => 'Your Feed Title',
                   'component'   => 'text'
               ],
               [
                   'key'         => 'list_id',
                   'label'       => 'Constant Contact List',
                   'placeholder' => 'Select ConstantContact Mailing List',
                   'tips'        => 'Select the ConstantContact Mailing List you would like to add your contacts to.',
                   'component'   => 'list_ajax_options',
                   'options'     => $this->getLists(),
               ],
               [
                   'key'                => 'custom_fields',
                   'require_list'       => true,
                   'label'              => 'Map Fields',
                   'tips'               => 'Select which Fluent Form fields pair with their<br /> respective ConstantContact fields.',
                   'component'          => 'map_fields',
                   'field_label_remote' => 'ConstantContact Field',
                   'field_label_local'  => 'Form Field',
                   'primary_fileds'     => [
                       [
                           'key'           => 'email_address',
                           'label'         => 'Email Address',
                           'required'      => true,
                           'input_options' => 'emails'
                       ],
                       [
                           'key'   => 'first_name',
                           'label' => 'First Name'
                       ],
                       [
                           'key'   => 'last_name',
                           'label' => 'Last Name'
                       ],
                       [
                           'key'   => 'job_title',
                           'label' => 'Job Title'
                       ],
                       [
                           'key'   => 'company_name',
                           'label' => 'Company name'
                       ],
                       [
                           'key'   => 'home_phone',
                           'label' => 'Home Phone Number'
                       ],
                       [
                           'key'   => 'work_phone',
                           'label' => 'Work Phone Number'
                       ],
                       [
                           'key'   => 'address_line_1',
                           'label' => 'Address Line 1'
                       ],
                       [
                        'key'   => 'address_line_2',
                        'label' => 'Address Line 2'
                        ],
                       [
                           'key'   => 'city_name',
                           'label' => 'City'
                       ],
                       [
                           'key'   => 'state_name',
                           'label' => 'State'
                       ],
                       [
                           'key'   => 'zip_code',
                           'label' => 'ZIP Code'
                       ]
                   ]
               ],
               [
                   'require_list' => true,
                   'key'          => 'conditionals',
                   'label'        => 'Conditional Logics',
                   'tips'         => 'Allow ConstantContact integration conditionally based on your submission values',
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
        $api = $this->getRemoteApi();
        $lists = $api->get_lists();
        
        $formateddLists = [];
        
        if(is_wp_error($lists)) {
            return $formateddLists;
        }
        foreach ($lists as $list) {
            $formateddLists[$list['id']] = $list['name'];
        }
        return $formateddLists;
    }

    protected function getConfigInstractions()
    {
        ob_start();
        ?>
        <div><h4>Constant contact V3 is beta, so we just downgrade to V2 as per user request, see this instruction bellow to reauthenticate with V2</h4>
            <ol>
                <li>Click here to <a
                        href="<?php echo $this->getAuthenticateUri(); ?>""
                        target="_blank">Get Access Token</a>.
                </li>
                <li>Then If you already have  an account click "I already have an account"</li>
                <li>Copy your Constant Contact access token and paste bellow field</li>
            </ol>
        </div>
        <?php
        return ob_get_clean();
    }

    public function getAuthenticateUri()
    {
        $api = $this->getRemoteApi();
        return $api->makeAuthorizationUrl();
    }


    public function notify($feed, $formData, $entry, $form)
    {
        $feedData = $feed['processedValues'];

        if (!is_email($feedData['email_address'])) {
            $feedData['email_address'] = ArrayHelper::get($formData, $feedData['email_address']);
        }

        if (!is_email($feedData['email_address']) || !$feedData['list_id']) {
            do_action('ff_integration_action_result', $feed, 'failed', 'ConstantContact API call has been skipped because no valid email available');
            return false;
        }

        /* Prepare audience member import array. */
        $subscriber_details = array(      
            'custom_fields'    => array(),
        );


        $mapFields = ArrayHelper::only($feedData, [
            'email_address',
            'list_id',
            'first_name',
            'last_name',
            'job_title',
            'company_name',
            'home_phone',
            'work_phone',
            'address_line_1',
            'address_line_2',
            'city_name',
            'state_name',
            'zip_code'
        ]);


        foreach ($mapFields as $field_name => $field_value) {
            if(!$field_value) {
                continue;
            }
         
            $emailTypes = [
                'email_address' => 'email_address'
            ];

            if(in_array($field_name, array_keys($emailTypes))) {
                $field_value = trim( $field_value );

                if ( ! isset( $subscriber_details['email_address'] ) ) {
                    $subscriber_details['email_addresses']    = array();
                    
                }
                $subscriber_details['email_addresses'][0][ $emailTypes[$field_name] ] = $field_value;
                continue;
            }

            $addressTypes = [
                'address_line_1' => 'line1',
                'address_line_2' => 'line2',
                'city_name' => 'city',
                'state_name' => 'state',
                'zip_code' => 'postal_code',
            ];

            if(in_array($field_name, array_keys($addressTypes))) {
                $field_value = trim( $field_value );

                if ( ! isset( $subscriber_details['addresses'] ) ) {
                    $subscriber_details['addresses']    = array();
                    
                }
                $subscriber_details['addresses'][0][ $addressTypes[$field_name] ] = $field_value;
                continue;
            }

            $listTypes = [
                'list_id' => 'id'
            ];

            if(in_array($field_name, array_keys($listTypes))) {
                $field_value = trim( $field_value );

                if ( ! isset( $subscriber_details['lists'] ) ) {
                    $subscriber_details['lists']    = array();
                    
                }
                $subscriber_details['lists'][0][ $listTypes[$field_name] ] = $field_value;
                continue;
            }

            if ( ! isset( $subscriber_details[ $field_name ] ) ) {
                $subscriber_details[ $field_name ] = $field_value;
            }

        }

        if($subscriber_details['addresses']){
            $subscriber_details['addresses'][0]['address_type'] = 'BUSINESS';
        }

        if( !empty($feedData['work_number'])){
            $subscriber_details['work_phone'] = $feedData['work_number'];
        }

        if( !empty($feedData['home_number'])){
            $subscriber_details['home_phone'] = $feedData['home_number'];
        }

        if($customFiels = ArrayHelper::get($feedData, 'custom_fields')) {
            foreach ($customFiels as $fieldKey => $fieldValue) {
                if(!$fieldValue) {
                    continue;
                }
                $subscriber_details['custom_fields'][] = array(
                    'custom_field_id' => $fieldKey,
                    'value'           => $field_value,
                );
            }
        }

        $subscriber_details = apply_filters('fluentform_integration_data_'.$this->integrationKey, $subscriber_details, $feed, $entry);


        $api = $this->getRemoteApi();

        $subscription_results = $api->subscribeToList($subscriber_details);

        if ( !is_wp_error( $subscription_results ) && isset($subscription_results['id']) ) {
            do_action('ff_integration_action_result', $feed, 'success', 'Constant Contact has been successfully initialed and pushed data');
        } else {
            do_action('ff_integration_action_result', $feed, 'failed', ArrayHelper::get($subscription_results[0], 'error_message'));
        }
    }

   public function getMergeFields($list, $listId, $formId)
    {
        return [];
    }

   protected function getRemoteApi()
    {
        $Settings = get_option($this->optionKey);  
        return new API($Settings['accessToken']);
    } 
}
