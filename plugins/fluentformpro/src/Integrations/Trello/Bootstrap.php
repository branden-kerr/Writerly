<?php

namespace FluentFormPro\Integrations\Trello;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Modules\Acl\Acl;
use FluentForm\App\Services\Integrations\IntegrationManager;
use FluentForm\Framework\Foundation\Application;
use FluentForm\Framework\Helpers\ArrayHelper;

class Bootstrap extends IntegrationManager
{
    public function __construct(Application $app)
    {
        parent::__construct(
            $app,
            'Trello',
            'trello',
            '_fluentform_Trello_settings',
            'fluentform_Trello_feed',
            16
        );

        $this->logo = $this->app->url('public/img/integrations/trello.png');

        $this->description = 'WP Fluent Forms Trello Module allows you to create Trello card from submiting forms.';

        $this->registerAdminHooks();

        add_action('wp_ajax_fluentform_pro_trello_board_config', array($this, 'getBoardConfigOptions'));
        // add_filter('fluentform_notifying_async_trello', '__return_false');

    }

    public function getGlobalFields($fields)
    {
        return [
            'logo'               => $this->logo,
            'menu_title'         => __('Trello API Settings', 'fluentformpro'),
            'menu_description'   => __('Trello is an integrated email marketing, marketing automation, and small business CRM. Save time while growing your business with sales automation. Use Fluent Form to collect customer information and automatically add it to your Trello list. If you don\'t have an Trello account, you can <a href="https://www.trello.com/" target="_blank">sign up for one here.</a>', 'fluentformpro'),
            'valid_message'      => __('Your Trello configuration is valid', 'fluentformpro'),
            'invalid_message'    => __('Your Trello configuration is invalid', 'fluentformpro'),
            'save_button_text'   => __('Verify Trello ', 'fluenform'),
            'config_instruction' => $this->getConfigInstractions(),
            'fields'             => [
                'accessToken' => [
                    'type'        => 'text',
                    'placeholder' => 'access token Key',
                    'label_tips'  => __("Enter your Trello access token Key, if you do not have <br>Please click here to get yours", 'fluentformpro'),
                    'label'       => __('Trello access Key', 'fluentformpro'),
                ],
            ],
            'hide_on_valid'      => true,
            'discard_settings'   => [
                'section_description' => 'Your Trello API integration is up and running',
                'button_text'         => 'Disconnect Trello',
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

    public function getBoardConfigOptions()
    {
        Acl::verify('fluentform_forms_manager');

        $requestInfo = $this->app->request->get('settings');
        $boardConfig = ArrayHelper::get($requestInfo, 'board_config');

        $boardId = ArrayHelper::get($boardConfig, 'board_id');

        $data = [
            'board_id'       => $this->getBoards(),
            'board_list_id'  => [],
            'board_label_id' => [],
            'member_ids'     => []
        ];

        if ($boardId) {
            $data['board_list_id'] = $this->getBoardLists($boardId);
            $data['board_label_id'] = $this->getBoardLabels($boardId);
            $data['member_ids'] = $this->getBoardMembers($boardId);
        }

        wp_send_json_success([
            'fields_options' => $data
        ], 200);
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

            // Update the reCaptcha details with siteKey & secretKey.
            update_option($this->optionKey, $integrationSettings, 'no');

            wp_send_json_success([
                'message' => __('Your settings has been updated and discarted', 'fluentformpro'),
                'status'  => false
            ], 200);
        }

        try {
            $settings['status'] = false;
            update_option($this->optionKey, $settings, 'no');
            $api = new TrelloApi($settings['accessToken'], null);
            $auth = $api->auth_test();
            if (isset($auth['id'])) {
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
            'global_configure_url'  => admin_url('admin.php?page=fluent_forms_settings#general-Trello-settings'),
            'configure_message'     => 'Trello is not configured yet! Please configure your Trello API first',
            'configure_button_text' => 'Set Trello API'
        ];
        return $integrations;
    }

    protected function getConfigInstractions()
    {
        ob_start();
        ?>
        <div><h4>To Authenticate Trello you need an access token.</h4>
            <ol>
                <li>Click here to <a
                        href="https://trello.com/1/authorize?expiration=never&name=FluentForm%20Pro&scope=read,write,account&response_type=token&key=f79dfb43d0becc887dc488e99bed0687"
                        target="_blank">Get Access Token</a>.
                </li>
                <li>Then login and allow with your trello account.</li>
                <li>Copy your your access token and paste bellow field then click Verify Trello.</li>
            </ol>
        </div>
        <?php
        return ob_get_clean();
    }

    public function getIntegrationDefaults($settings, $formId)
    {
        return [
            'name'         => '',
            'list_id'      => '', // This is the borad id
            'board_config' => [
                'board_id'       => '',
                'board_list_id'  => '',
                'board_label_id' => '',
                'member_ids'     => []
            ],
            'card_name'    => '',
            'card_description'    => '',
            'card_pos'    => 'bottom',
            'conditionals' => [
                'conditions' => [],
                'status'     => false,
                'type'       => 'all'
            ],
            'enabled'      => true
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
                    'key'            => 'board_config',
                    'label'          => 'Trello Configuration',
                    'required'       => true,
                    'component'      => 'chained_select',
                    'primary_key'    => 'board_id',
                    'fields_options' => [
                        'board_id'       => [],
                        'board_list_id'  => [],
                        'board_label_id' => [],
                        'member_ids'     => []
                    ],
                    'options_labels' => [
                        'board_id'       => [
                            'label'       => 'Select Board',
                            'type'        => 'select',
                            'placeholder' => 'Select Board'
                        ],
                        'board_list_id'  => [
                            'label'       => 'Select List',
                            'type'        => 'select',
                            'placeholder' => 'Select Board List'
                        ],
                        'board_label_id' => [
                            'label'       => 'Select Card Label',
                            'type'        => 'multi-select',
                            'placeholder' => 'Select Card Label'
                        ],
                        'member_ids'     => [
                            'label'       => 'Select Members',
                            'type'        => 'multi-select',
                            'placeholder' => 'Select Members'
                        ]
                    ],
                    'remote_url'     => admin_url('admin-ajax.php?action=fluentform_pro_trello_board_config')
                ],
                [
                    'key' => 'card_name',
                    'label' => 'Card Title',
                    'required' => true,
                    'placeholder' => 'Trello Card Title',
                    'component' => 'value_text'
                ],
                [
                    'key' => 'card_description',
                    'label' => 'Card Content',
                    'placeholder' => 'Trello Card Content',
                    'component' => 'value_textarea'
                ],
                [
                    'key' => 'card_pos',
                    'label' => 'Card Position',
                    'required' => true,
                    'placeholder' => 'Postion',
                    'component' => 'radio_choice',
                    'options' => [
                        'bottom' => 'Bottom',
                        'top' => 'Top'
                    ]
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
            'button_require_list' => false,
            'integration_title'   => $this->title
        ];
    }

    protected function getBoards()
    {
        $api = $this->getApiClient();
        if (!$api) {
            return [];
        }
        $boards = $api->getBoards();

        $formattedBoards = [];
        foreach ($boards as $board) {
            if (is_array($board)) {
                $formattedBoards[$board['id']] = $board['name'];
            }
        }

        return $formattedBoards;
    }

    protected function getBoardLists($boardId)
    {
        $api = $this->getApiClient();
        if (!$api) {
            return [];
        }

        $lists = $api->getLists($boardId);

        if(is_wp_error($lists)) {
            return [];
        }

        $formattedLists = [];
        foreach ($lists as $list) {
            if (is_array($list)) {
                $formattedLists[$list['id']] = $list['name'];
            }
        }

        return $formattedLists;
    }

    protected function getBoardLabels($boardId)
    {
        $api = $this->getApiClient();
        if (!$api) {
            return [];
        }

        $labels = $api->getLabels($boardId);

        if(is_wp_error($labels)) {
            return [];
        }

        $formattedLabels = [];
        foreach ($labels as $label) {
            if (is_array($label)) {
                $formattedLabels[$label['id']] = $label['name'] ?: $label['color'];
            }
        }

        return $formattedLabels;
    }

    protected function getBoardMembers($boardId)
    {
        $api = $this->getApiClient();
        if (!$api) {
            return [];
        }

        $members = $api->getMembers($boardId);

        if(is_wp_error($members)) {
            return [];
        }

        $formattedMembers = [];
        foreach ($members as $member) {
            if (is_array($member)) {
                $formattedMembers[$member['id']] = $member['fullName'] . ' (@' . $member['username'] . ')';
            }
        }

        return $formattedMembers;
    }


    /**
     * Prepare Trello forms for feed field.
     *
     * @return array
     */

    /*
     * Submission Broadcast Handler
     */

    public function notify($feed, $formData, $entry, $form)
    {
        $feedData = $feed['processedValues'];

        $listId = ArrayHelper::get($feedData, 'board_config.board_list_id');

        if(!$listId) {
            return;
        }

        $data = [
            'name' => ArrayHelper::get($feedData, 'card_name'),
            'desc' => ArrayHelper::get($feedData, 'card_description'),
            'pos' => ArrayHelper::get($feedData, 'card_pos'),
            'idList' => $listId
        ];

        if($members = ArrayHelper::get($feedData, 'board_config.member_ids')) {
            $data['idMembers'] = implode(',', $members);
        }

        $labels = ArrayHelper::get($feedData, 'board_config.board_label_id');

        if($labels) {
            if(is_array($labels)) {
                $data['idLabels'] = implode(',', $labels);
            } else {
                $data['idLabels'] = $labels;
            }
        }

        $data = apply_filters('fluentform_integration_data_'.$this->integrationKey, $data, $feed, $entry);


        // Now let's prepare the data and push to Trello
        $api = $this->getApiClient();

        $response = $api->addCard($data);

        if (!is_wp_error($response) && isset($response['id'])) {
            do_action('ff_integration_action_result', $feed, 'success', 'Trello feed has been successfully initialed and pushed data');
        } else {
            $error = is_wp_error($response) ? $response->get_error_messages() : 'API Error when submitting Data in trello server';
            do_action('ff_integration_action_result', $feed, 'failed', $error);
        }
    }

    protected function getApiClient()
    {
        $settings = get_option($this->optionKey);
        return new TrelloApi(
            $settings['accessToken']
        );
    }

    function getMergeFields($list, $listId, $formId)
    {
        return $list;
    }
}
