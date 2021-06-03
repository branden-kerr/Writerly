<?php

namespace FluentFormPro\Integrations\UserRegistration;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Helpers\Helper;
use FluentForm\Framework\Helpers\ArrayHelper;

class UserRegistrationApi
{
    public function getUserRoles()
    {
        if ( ! function_exists( 'get_editable_roles' ) ) {
            require_once ABSPATH . 'wp-admin/includes/user.php';
        }

        $roles = get_editable_roles();

        $validRoles = [];
        foreach ($roles as $roleKey => $role) {
            if (!ArrayHelper::get($role, 'capabilities.manage_options')) {
                $validRoles[$roleKey] = $role['name'];
            }
        }

        return apply_filters('fluentorm_UserRegistration_creatable_roles', $validRoles);
    }

    public function validate($settings, $settingsFields)
    {
        foreach ($settingsFields['fields'] as $field) {

            if ($field['key'] != 'CustomFields') continue;

            $errors = [];

            foreach ($field['primary_fileds'] as $primaryField) {
                if (!empty($primaryField['required'])) {
                    if (empty($settings[$primaryField['key']])) {
                        $errors[$primaryField['key']] = $primaryField['label'] . ' is required.';
                    }
                }
            }

            if ($errors) {
                wp_send_json_error([
                    'message' => array_shift($errors),
                    'errors' => $errors
                ], 422);
            }
        }

        return $settings;
    }

    public function registerUser($feed, $formData, $entry, $form, $integrationKey)
    {
        if (get_current_user_id()) return;

        $parsedValue = $feed['processedValues'];

        if (!is_email($parsedValue['Email'])) {
            $parsedValue['Email'] = ArrayHelper::get(
                $formData, $parsedValue['Email']
            );
        }

        if (!is_email($parsedValue['Email'])) return;

        if (email_exists($parsedValue['Email'])) return;

        if(!empty($parsedValue['username'])) {
            $userName = ArrayHelper::get($formData, $parsedValue['username']);
            if(is_array($userName)) {
                return;
            }
            if($userName && username_exists($userName)) {
                return;
            }
            if($userName) {
                $parsedValue['username'] = $userName;
            }
        }

        if(empty($parsedValue['username'])) {
            $parsedValue['username'] = $parsedValue['Email'];
        }

        $feed['processedValues'] = $parsedValue;

        do_action('fluentform_user_registration_before_start', $feed, $entry, $form);

        $this->createUser($feed, $formData, $entry, $form, $integrationKey);
    }

    protected function createUser($feed, $formData, $entry, $form, $integrationKey)
    {

        $feed = apply_filters('fluentform_user_registration_feed', $feed, $entry, $form);

        $parsedData = $feed['processedValues'];

        $email = $parsedData['Email'];
        $userName = $parsedData['username'];

        if (empty($parsedData['password'])) {
            $password = wp_generate_password(8);
        } else {
            $password = $parsedData['password'];
        }

        $userId = wp_create_user($userName, $password, $email);

        if (is_wp_error($userId)) {
            return $this->addLog(
                $feed['settings']['name'],
                'failed',
                $userId->get_error_message(),
                $form->id,
                $entry->id,
                $integrationKey
            );
        }

        do_action('fluentform_created_user', $userId, $feed, $entry, $form);

        Helper::setSubmissionMeta($entry->id, '__created_user_id', $userId);

        $this->updateUser($parsedData, $userId);

        $this->addUserRole($parsedData, $userId);

        $this->addUserMeta($parsedData, $userId, $form->id);

        $this->maybeLogin($parsedData, $userId, $entry);

        $this->maybeSendEmail($parsedData, $userId);

        do_action('fluentform_user_registration_completed', $userId, $feed, $entry, $form);

        $this->addLog(
            $feed['settings']['name'],
            'success',
            'user has been successfully created. Created User ID: ' . $userId,
            $form->id,
            $entry->id,
            $integrationKey
        );

        wpFluent()->table('fluentform_submissions')
            ->where('id', $entry->id)
            ->update([
                'user_id' => $userId
            ]);
    }

    protected function updateUser($parsedData, $userId)
    {
        $name = trim(ArrayHelper::get($parsedData, 'first_name'). ' ' . ArrayHelper::get($parsedData, 'last_name'));

        $data = array_filter([
            'ID' => $userId,
            'user_nicename' => $name,
            'display_name' => $name,
            'user_url' => ArrayHelper::get($parsedData, 'user_url')
        ]);

        if ($name) {
            wp_update_user($data);
        }
    }

    protected function addUserRole($parsedData, $userId)
    {
        $userRoles = $this->getUserRoles();
        $assignedRole = $parsedData['userRole'];

        if (!isset($userRoles[$assignedRole])) {
            $assignedRole = 'subscriber';
        }

        $user = new \WP_User($userId);
        $user->set_role($assignedRole);
    }

    protected function addUserMeta($parsedData, $userId, $formId)
    {
        foreach ($parsedData['userMeta'] as $userMeta) {
            $userMetas[$userMeta['label']] = $userMeta['item_value'];
        }

        $userMetas = array_merge($userMetas, [
            'first_name' => $parsedData['first_name'],
            'last_name' => $parsedData['last_name']
        ]);

        if (!isset($userMetas['nickname'])) {
            $userMetas['nickname'] = $parsedData['first_name'] . ' ' . $parsedData['last_name'];
        }

        foreach ($userMetas as $metaKey => $metaValue) {
            if (trim($metaValue)) {
                update_user_meta($userId, $metaKey, trim($metaValue));
            }
        }

        update_user_meta($userId, 'fluentform_user_id', $formId);
    }

    protected function maybeLogin($parsedData, $userId, $entry = false)
    {
        if (ArrayHelper::isTrue($parsedData, 'enableAutoLogin')) {
            // check if it's payment success page
            // or direct url
            if(isset($_REQUEST['fluentform_payment_api_notify']) && $entry) {
                // This payment IPN request so let's keep a reference for real request
                Helper::setSubmissionMeta($entry->id, '_make_auto_login', $userId, $entry->form_id);
                return;
            }

            wp_clear_auth_cookie();
            wp_set_current_user($userId);
            wp_set_auth_cookie($userId);
        }
    }

    protected function maybeSendEmail($parsedData, $userId)
    {
        if (ArrayHelper::isTrue($parsedData, 'sendEmailToNewUser')) {
            // This will send an email with password setup link
            \wp_new_user_notification($userId, null, 'user');
        }
    }

    protected function addLog($title, $status, $description, $formId, $entryId, $integrationKey)
    {
        do_action('ff_log_data', [
            'title' => $title,
            'status' => $status,
            'description' => $description,
            'parent_source_id' => $formId,
            'source_id' => $entryId,
            'component' => $integrationKey,
            'source_type' => 'submission_item'
        ]);
        return true;
    }
}
