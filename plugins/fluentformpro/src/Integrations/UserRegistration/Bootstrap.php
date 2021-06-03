<?php

namespace FluentFormPro\Integrations\UserRegistration;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Helpers\Helper;
use FluentForm\App\Services\ConditionAssesor;
use FluentForm\App\Services\Integrations\IntegrationManager;
use FluentForm\Framework\Foundation\Application;
use FluentForm\Framework\Helpers\ArrayHelper;

class Bootstrap extends IntegrationManager
{
    public $category = 'wp_core';
    public $disableGlobalSettings = 'yes';

    public function __construct(Application $app)
    {
        parent::__construct(
            $app,
            'User Registration',
            'UserRegistration',
            '_fluentform_user_registration_settings',
            'user_registration_feeds',
            1
        );

        $this->userApi = new UserRegistrationApi;

        $this->logo = $this->app->url('public/img/integrations/user_registration.png');

        $this->description = 'Create WordPress user when when a form is submitted.';

        add_filter('fluentform_notifying_async_UserRegistration', '__return_false');

        add_filter('fluentform_save_integration_value_' . $this->integrationKey, [$this, 'validate'], 10, 3);

        add_filter('fluentform_validation_user_registration_errors', [$this, 'validateSubmittedForm'], 10, 3);

        $this->registerAdminHooks();
    }

    public function pushIntegration($integrations, $formId)
    {
        $integrations[$this->integrationKey] = [
            'category'                => 'wp_core',
            'disable_global_settings' => 'yes',
            'logo'                    => $this->logo,
            'title'                   => $this->title . ' Integration',
            'is_active'               => $this->isConfigured()
        ];

        return $integrations;
    }

    public function getIntegrationDefaults($settings, $formId = null)
    {
        $fields = [
            'name'                 => '',
            'Email'                => '',
            'username'             => '',
            'CustomFields'         => (object)[],
            'userRole'             => 'subscriber',
            'userMeta'             => [
                [
                    'label' => '', 'item_value' => ''
                ]
            ],
            'enableAutoLogin'      => false,
            'sendEmailToNewUser'   => false,
            'validateForUserEmail' => true,
            'conditionals'         => [
                'conditions' => [],
                'status'     => false,
                'type'       => 'all'
            ],
            'enabled'              => true
        ];

        return apply_filters('fluentform_user_registration_field_defaults', $fields, $formId);
    }

    public function getSettingsFields($settings, $formId = null)
    {
        $fields = apply_filters('fluentform_user_registration_feed_fields', [
            [
                'key'         => 'name',
                'label'       => 'Name',
                'required'    => true,
                'placeholder' => 'Your Feed Name',
                'component'   => 'text'
            ],
            [
                'key'                => 'CustomFields',
                'require_list'       => false,
                'label'              => 'Map Fields',
                'tips'               => 'Associate your user registration fields to the appropriate Fluent Form fields by selecting the appropriate form field from the list.',
                'component'          => 'map_fields',
                'field_label_remote' => 'User Registration Field',
                'field_label_local'  => 'Form Field',
                'primary_fileds'     => [
                    [
                        'key'           => 'Email',
                        'label'         => 'Email Address',
                        'required'      => true,
                        'input_options' => 'emails'
                    ],
                    [
                        'key'       => 'username',
                        'label'     => 'User name',
                        'required'  => false,
                        'input_options' => 'all',
                        'help_text' => 'Keep empty if you want the username and user email is the same',
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
                        'key'       => 'password',
                        'label'     => 'Password',
                        'help_text' => 'Keep empty to be auto generated',
                    ],
                ]
            ],
            [
                'require_list' => false,
                'required'     => true,
                'key'          => 'userRole',
                'label'        => 'Default User Role',
                'tips'         => 'Set default user role when registering a new user.',
                'component'    => 'radio_choice',
                'options'      => $this->userApi->getUserRoles()
            ],
            [
                'require_list' => false,
                'key'          => 'userMeta',
                'label'        => 'User Meta',
                'tips'         => 'Add user meta.',
                'component'    => 'dropdown_label_repeater',
                'field_label'  => 'User Meta Key',
                'value_label'  => 'User Meta Value'
            ],
            [
                'require_list'   => false,
                'key'            => 'enableAutoLogin',
                'label'          => 'Auto Login',
                'checkbox_label' => 'Allow the user login automatically after registration',
                'component'      => 'checkbox-single',
            ],
            [
                'require_list'   => false,
                'key'            => 'sendEmailToNewUser',
                'label'          => 'Email Notification',
                'checkbox_label' => 'Send default WordPress welcome email to user after registration',
                'component'      => 'checkbox-single',
            ],
            [
                'require_list'   => false,
                'key'            => 'validateForUserEmail',
                'label'          => 'Form Validation',
                'checkbox_label' => 'Do not submit the form if user already exist in Database',
                'component'      => 'checkbox-single',
            ]
        ], $formId);

        $fields[] = [
            'require_list' => false,
            'key'          => 'conditionals',
            'label'        => 'Conditional Logics',
            'tips'         => 'Allow User Registration integration conditionally based on your submission values',
            'component'    => 'conditional_block'
        ];
        $fields[] = [
            'require_list'   => false,
            'key'            => 'enabled',
            'label'          => 'Status',
            'component'      => 'checkbox-single',
            'checkbox_label' => 'Enable This feed',
            'inline_tip'     => 'Please note that, This action will only run if the visitor is logged out state and the email is not registered yet'
        ];

        return [
            'fields'              => $fields,
            'button_require_list' => false,
            'integration_title'   => $this->title
        ];
    }

    public function validate($settings, $integrationId, $formId)
    {
        $parseSettings = $this->userApi->validate(
            $settings, $this->getSettingsFields($settings)
        );

        Helper::setFormMeta($formId, '_has_user_registration', 'yes');

        return $parseSettings;
    }

    public function validateSubmittedForm($errors, $data, $form)
    {
        $feeds = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $form->id)
            ->where('meta_key', 'user_registration_feeds')
            ->get();

        if (!$feeds) {
            return $errors;
        }

        foreach ($feeds as $feed) {
            $parsedValue = json_decode($feed->value, true);

            if (!ArrayHelper::isTrue($parsedValue, 'validateForUserEmail')) {
                continue;
            }

            if ($parsedValue && ArrayHelper::isTrue($parsedValue, 'enabled')) {
                // Now check if conditions matched or not
                $isConditionMatched = $this->checkCondition($parsedValue, $data);
                if (!$isConditionMatched) {
                    continue;
                }
                $email = ArrayHelper::get($data, $parsedValue['Email']);
                if (!$email) {
                    continue;
                }

                if (email_exists($email)) {
                    if (!isset($errors['restricted'])) {
                        $errors['restricted'] = [];
                    }
                    $errors['restricted'][] = __('This email is already registered. Please choose another one.', 'fluentformpro');
                    return $errors;
                }

                if(!empty($parsedValue['username'])) {
                    $userName = ArrayHelper::get($data, $parsedValue['username']);
                    if($userName) {
                        if(username_exists($userName)) {
                            if (!isset($errors['restricted'])) {
                                $errors['restricted'] = [];
                            }
                            $errors['restricted'][] = __('This username is already registered. Please choose another one.', 'fluentformpro');
                            return $errors;
                        }
                    }
                }
            }
        }

        return $errors;
    }

    /*
     * Form Submission Hooks Here
     */
    public function notify($feed, $formData, $entry, $form)
    {
        $this->userApi->registerUser(
            $feed, $formData, $entry, $form, $this->integrationKey
        );
    }

    // There is no global settings, so we need
    // to return true to make this module work.
    public function isConfigured()
    {
        return true;
    }

    // This is an absttract method, so it's required.
    public function getMergeFields($list, $listId, $formId)
    {
        // ...
    }

    // This method should return global settings. It's not required for
    // this class. So we should return the default settings otherwise
    // there will be an empty global settings page for this module.
    public function addGlobalMenu($setting)
    {
        return $setting;
    }

    private function checkCondition($parsedValue, $formData)
    {
        $conditionSettings = ArrayHelper::get($parsedValue, 'conditionals');
        if (
            !$conditionSettings ||
            !ArrayHelper::isTrue($conditionSettings, 'status') ||
            !count(ArrayHelper::get($conditionSettings, 'conditions'))
        ) {
            return true;
        }

        return ConditionAssesor::evaluate($parsedValue, $formData);
    }
}
