<?php

namespace FluentFormPro\Integrations\IContact;

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
            'iContact',
            'icontact',
            '_fluentform_icontact_settings',
            'fluentform_icontact_feed',
            20
        );
        $this->logo = $this->app->url('public/img/integrations/icontact.png');

        $this->description = 'Connect iContact with WP Fluent Forms and subscribe a contact when a form is submitted.';

        $this->registerAdminHooks();

       // add_filter('fluentform_notifying_async_icontact', '__return_false');
    }

    public function getGlobalFields($fields)
    {
        return [
            'logo' => $this->logo,
            'menu_title' => __('iContact API Settings', 'fluentformpro'),
            'menu_description' => __('iContact is an email marketing platform to send email newsletters to your customers, manage your<br />subscriber lists, and track campaign performance. Use Fluent Form to collect customer information<br />and automatically add it to your iContact list. If you don\'t have an iContact account,<br />you can <a href="https://www.icontact.com/" target="_blank">sign up for one here.</a>', 'fluentformpro'),
            'valid_message' => __('Your iContact configuration is valid', 'fluentformpro'),
            'invalid_message' => __('Your iContact configuration is invalid', 'fluentformpro'),
            'save_button_text' => __('Save Settings', 'fluentformpro'),
            'config_instruction' => "<p>Fluent Form iContact Add-On requires your Application ID, API username and API password. To obtain an application ID, follow the steps described below:<br/></p><ol><li>Visit iContact's <a href=\"https://app.icontact.com/icp/core/registerapp/\" target=\"_blank\">application registration page</a></li><li>Set an application name and description for your application.</li><li>Choose to show information for API 2.0.</li><li>Copy the provided API-AppId into the Application ID setting field below.</li><li>Click \"Enable this AppId for your account\".</li><li>Create a password for your application and click save.</li><li>Enter your API password, along with your iContact account username, into the fields below.</li></ol>",
            'fields' => [
                'appKey' => [
                    'type' => 'password',
                    'placeholder' => 'Application Key',
                    'label_tips' => __("Enter your iContact Application Key", 'fluentformpro'),
                    'label' => __('Application Key', 'fluentformpro'),
                ],
                'username' => [
                    'type' => 'text',
                    'placeholder' => 'Account Email Address',
                    'label_tips' => __("Enter your iContact Account Email Address", 'fluentformpro'),
                    'label' => __('Account Email Address', 'fluentformpro'),
                ],
                'apiPassword' => [
                    'type' => 'password',
                    'placeholder' => 'API Password',
                    'label_tips' => __("Enter your iContact API Password", 'fluentformpro'),
                    'label' => __('API Password', 'fluentformpro'),
                ],
                'AccountID' => [
                    'type' => 'text',
                    'placeholder' => 'Account ID',
                    'label_tips' => __("Enter your Account ID. It's a numeric value. You will get in the api settings", 'fluentformpro'),
                    'label' => __('Account ID', 'fluentformpro'),
                ],
                'clientFolderId' => [
                    'type' => 'text',
                    'placeholder' => 'Client Folder ID',
                    'label_tips' => __("Enter your Client Folder ID", 'fluentformpro'),
                    'label' => __('Client Folder ID', 'fluentformpro'),
                ]
            ],
            'hide_on_valid' => true,
            'discard_settings' => [
                'section_description' => 'Your iContact API integration is up and running',
                'button_text' => 'Disconnect iContact',
                'data' => [
                    'appKey' => ''
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
            'appKey' => '',
            'username' => '',
            'apiPassword' => '',
            'clientFolderId	' => '',
            'AccountID' => '',
            'status' => ''
        ];

        return wp_parse_args($globalSettings, $defaults);
    }

    public function saveGlobalSettings($settings)
    {
        if (!$settings['appKey']) {
            $integrationSettings = [
                'appKey' => '',
                'username' => '',
                'apiPassword' => '',
                'status' => false
            ];
            // Update the reCaptcha details with siteKey & secretKey.
            update_option($this->optionKey, $integrationSettings, 'no');
            wp_send_json_success([
                'message' => __('Your API settings has been updated and discarted', 'fluentformpro'),
                'status' => false
            ], 200);
        }

        try {
            $emptyAppKey = empty($settings['appKey']);
            $emptyUsername = empty($settings['username']);
            $emptyApiPassword = empty($settings['apiPassword']);

            if ($emptyAppKey || $emptyUsername || $emptyApiPassword) {
                throw new \Exception('Invalid request, missing required fields.', 400);
            }

            $settings['status'] = false;
            $settings['appKey'] = sanitize_text_field($settings['appKey']);
            $settings['username'] = sanitize_text_field($settings['username']);
            $settings['apiPassword'] = sanitize_text_field($settings['apiPassword']);

            update_option($this->optionKey, $settings, 'no');
            $this->getFolders($settings);
            $settings['status'] = true;
            update_option($this->optionKey, $settings, 'no');

            return wp_send_json_success([
                'status' => true,
                'message' => __('Your API key settings has been verified and updated. All good!', 'fluentformpro')
            ], 200);

        } catch (\Exception $e) {
            wp_send_json_error([
                'status' => false,
                'message' => $e->getMessage()
            ], 423);
        }

    }

    public function pushIntegration($integrations, $formId)
    {
        $integrations[$this->integrationKey] = [
            'title' => $this->title . ' Integration',
            'logo' => $this->logo,
            'is_active' => $this->isConfigured(),
            'configure_title' => 'Configuration required!',
            'global_configure_url' => admin_url('admin.php?page=fluent_forms_settings#general-icontact-settings'),
            'configure_message' => 'iContact API Key is not configured yet! Please configure your iContact api first',
            'configure_button_text' => 'Set iContact API'
        ];
        return $integrations;
    }

    public function getIntegrationDefaults($settings, $formId)
    {
        return [
            'name' => '',
            'list_id' => '',
            'fieldName' => '',
            'fieldEmailAddress' => '',
            'default_fields' => (object)[],
            'custom_field_mappings' => (object)[],
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
                    'label' => 'iContact List',
                    'placeholder' => 'Select iContact List',
                    'tips' => 'Select the iContact List you would like to add your contacts to.',
                    'component' => 'list_ajax_options',
                    'options' => $this->getLists(),
                ],
                [
                    'key' => 'custom_field_mappings',
                    'require_list' => true,
                    'label' => 'Map Fields',
                    'tips' => 'Select which Fluent Form fields pair with their<br /> respective iContact fields.',
                    'component' => 'map_fields',
                    'field_label_remote' => 'iContact Field',
                    'field_label_local' => 'Form Field',
                    'primary_fileds' => [
                        [
                            'key' => 'fieldEmailAddress',
                            'label' => 'Email Address',
                            'required' => true,
                            'input_options' => 'emails'
                        ]
                    ],
                    'default_fields' => array(
                        array(
                            'name' => 'prefix',
                            'label' => esc_html__('Prefix', 'fluentformpro')
                        ),
                        array(
                            'name' => 'firstName',
                            'label' => esc_html__('First Name', 'fluentformpro')
                        ),
                        array(
                            'name' => 'lastName',
                            'label' => esc_html__('Last Name', 'fluentformpro')
                        ),
                        array(
                            'name' => 'suffix',
                            'label' => esc_html__('Suffix', 'fluentformpro')
                        ),
                        array(
                            'name' => 'street',
                            'label' => esc_html__('Address: Line 1', 'fluentformpro')
                        ),
                        array(
                            'name' => 'street2',
                            'label' => esc_html__('Address: Line 2', 'fluentformpro')
                        ),
                        array(
                            'name' => 'city',
                            'label' => esc_html__('Address: City', 'fluentformpro')
                        ),
                        array(
                            'name' => 'state',
                            'label' => esc_html__('Address: State', 'fluentformpro')
                        ),
                        array(
                            'name' => 'postalCode',
                            'label' => esc_html__('Address: Postal Code', 'fluentformpro')
                        ),
                        array(
                            'name' => 'phone',
                            'label' => esc_html__('Phone Number', 'fluentformpro')
                        ),
                        array(
                            'name' => 'fax',
                            'label' => esc_html__('Fax Number', 'fluentformpro')
                        ),
                        array(
                            'name' => 'business',
                            'label' => esc_html__('Business Number', 'fluentformpro')
                        )
                    )
                ],
                [
                    'require_list' => true,
                    'key' => 'conditionals',
                    'label' => 'Conditional Logics',
                    'tips' => 'Allow iContact integration conditionally based on your submission values',
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
        $api = $this->getApiClient();
        $lists = $api->get_lists();

        $formattedLists = [];
        foreach ($lists as $list) {
            $formattedLists[$list['listId']] = $list['name'];
        }
        return $formattedLists;

    }

    public function getMergeFields($list, $listId, $formId)
    {
        $api = $this->getApiClient();
        if (!$api) {
            return [];
        }
        $customFields = $api->get_custom_fields();

        $formattedFields = [];
        foreach ($customFields as $customField) {
            $formattedFields[$customField['customFieldId']] = $customField['publicName'];
        }
        return $formattedFields;
    }

    protected function getFolders($settings)
    {
        $api = new IContactApi(
            $settings['appKey'],
            $settings['username'],
            $settings['apiPassword'],
            $settings['clientFolderId'],
            $settings['AccountID']
        );

        $folders = [];
        $clientFolders = $api->get_client_folders();

        foreach ($clientFolders as $folder) {
            $folders[] = [
                'label' => isset($folder['name'])
                    ? $folder['name']
                    : esc_html__('Default Client Folder', 'fluentformicontact'),
                'value' => $folder['clientFolderId']
            ];
        }

        return $folders;
    }


    /*
     * Handle Notifications here
     */

    /*
    * Form Submission Hooks Here
    */
    public function notify($feed, $formData, $entry, $form)
    {
        $feedData = $feed['processedValues'];

        if (!is_email($feedData['fieldEmailAddress'])) {
            $feedData['fieldEmailAddress'] = ArrayHelper::get($formData, $feedData['fieldEmailAddress']);
        }

        if (!is_email($feedData['fieldEmailAddress'])) {
            do_action('ff_integration_action_result', $feed, 'failed', 'iContact API call has been skipped because no valid email available');
            return;
        }

        $subscriber = [
            'email' => $feedData['fieldEmailAddress']
        ];

        $defaultFields = ArrayHelper::get($feedData, 'default_fields', []);
        foreach ($defaultFields as $fieldKey => $fieldValue) {
            if (!$fieldValue) {
                continue;
            }
            $subscriber[$fieldKey] = $fieldValue;
        }


        $cutomFields = ArrayHelper::get($feedData, 'custom_field_mappings', []);
        foreach ($cutomFields as $fieldKey => $fieldValue) {
            if (!$fieldValue) {
                continue;
            }
            $subscriber[$fieldKey] = $fieldValue;
        }


        $subscriber = array_filter($subscriber);

        $subscriber = apply_filters('fluentform_integration_data_'.$this->integrationKey, $subscriber, $feed, $entry);


        $contactId = false;
        try {
            $contactId = $this->syncContact($subscriber);
        } catch (\Exception $exception) {
            do_action('ff_integration_action_result', $feed, 'failed', $exception->getMessage());
            return;
        }

        if (is_wp_error($contactId)) {
            do_action('ff_integration_action_result', $feed, 'failed', $contactId->get_error_message());
        }

        if ($contactId) {
            do_action('ff_integration_action_result', $feed, 'success', 'iContact feed has been successfully initialed and pushed the contact');
            try {
                $this->addSubscription($contactId, $feedData['list_id']);
            } catch (\Exception $exception) {
                //
            }
            return;
        }

    }

    private function syncContact($contact)
    {
        $api = $this->getApiClient();

        /* Check to see if we're adding a new contact. */
        $find_contact = $api->get_contact_by_email($contact['email']);

        $is_new_contact = empty($find_contact);
        if ($is_new_contact) {
            try {
                $response = $api->add_contact($contact);
                return $response['contactId'];
            } catch (\Exception $e) {
                return new \WP_Error('broke', $e->getMessage());
            }
        } else {
            try {
                $contact_id = $find_contact[0]['contactId'];
                /* Update the contact. */
                $api->update_contact($contact_id, $contact);
                return $contact_id;
            } catch (\Exception $e) {
                return new \WP_Error('broke', $e->getMessage());
            }
        }
    }

    private function addSubscription($contactId, $listId)
    {

        try {
            $api = $this->getApiClient();

            /* Subscribe the contact to the list. */
            $subscription = $api->add_contact_to_list($contactId, $listId);

            /* Log whether or not contact was subscribed to list. */
            if (empty ($subscription)) {
                return new \WP_Error('broke', 'Add subscription failed');
            } else {
                return true;
            }

        } catch (\Exception $e) {
            return new \WP_Error('broke', $e->getMessage());
        }

    }


    protected function getApiClient($settings = null)
    {
        if (!$settings) {
            $settings = $this->getGlobalSettings([]);
        }

        return new IContactApi(
            $settings['appKey'],
            $settings['username'],
            $settings['apiPassword'],
            isset($settings['clientFolderId']) ? $settings['clientFolderId'] : '',
            isset($settings['AccountID']) ? $settings['AccountID'] : ''
        );
    }
}
