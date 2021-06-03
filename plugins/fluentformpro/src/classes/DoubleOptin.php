<?php

namespace FluentFormPro\classes;

use FluentForm\App\Helpers\Helper;
use FluentForm\App\Modules\Form\FormFieldsParser;
use FluentForm\App\Modules\Form\FormHandler;
use FluentForm\App\Services\FormBuilder\Notifications\EmailNotification;
use FluentForm\App\Services\FormBuilder\ShortCodeParser;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentFormPro\classes\SharePage\SharePage;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class DoubleOptin
{
    private $initialStatusSlug = 'unconfirmed';
    private $confirmedStatusSlug = 'confirmed';

    public function init()
    {
        add_filter('fluentform_entry_statuses', function ($statuses, $formId) {
            if ($this->isActivated($formId)) {
                $statuses[$this->initialStatusSlug] = __('Unconfirmed', 'fluentformpro');
                $statuses[$this->confirmedStatusSlug] = __('Confirmed', 'fluentformpro');
            }
            return $statuses;
        }, 10, 2);

        add_filter('fluentform_form_settings_ajax', function ($settings, $formId) {
            if ($optinSettings = $this->getDoubleOptinSettings($formId)) {
                $settings['double_optin'] = $optinSettings;
            }
            return $settings;
        }, 10, 2);

        add_action('fluentform_after_save_form_settings', array($this, 'saveFormSettings'), 10, 2);

        add_action('fluentform_before_form_actions_processing', array($this, 'processOnSubmission'), 10, 3);

        add_action('fluentformpro_entry_confirmation', array($this, 'confirmSubmission'), 1, 1);

        add_action('wp_ajax_fluentform_get_global_double_optin', array($this, 'getGlobalSettingsAjax'));

        add_action('wp_ajax_fluentform_save_global_double_optin', array($this, 'updateGlobalSettingsAjax'));

        add_action('fluentform_do_email_report_scheduled_tasks', array($this, 'maybeDeleteUnconfirmedEntries'), 99);
        add_action('fluentform_maybe_scheduled_jobs', array($this, 'maybeDeleteUnconfirmedEntries'), 99);

        add_action('fluentform_entry_statuses', array($this, 'maybeDeleteOldEntries'));
    }

    public function isActivated($formId = false)
    {
        if (!$formId) {
            return false;
        }
        static $activated;
        if ($activated) {
            return $activated == 'yes';
        }

        $settings = $this->getDoubleOptinSettings($formId);

        if ($settings && !empty($settings['status'])) {
            $activated = $settings['status'];
        }

        return $activated == 'yes';
    }

    public function saveFormSettings($formId, $allSettings)
    {
        $doubleOptinSettings = ArrayHelper::get($allSettings, 'double_optin', []);
        if ($doubleOptinSettings) {
            Helper::setFormMeta($formId, 'double_optin_settings', $doubleOptinSettings);
        }
    }

    public function getDoubleOptinSettings($formId, $scope = 'admin')
    {
        $defaults = [
            'status'                => 'no',
            'confirmation_message'  => __('Please check your email inbox to confirm this submission', 'fluentform'),
            'email_body_type'       => 'global',
            'email_subject'         => '',
            'email_body'            => '',
            'email_field'           => '',
            'skip_if_logged_in'     => 'yes',
            'skip_if_fc_subscribed' => 'no'
        ];

        $settings = \FluentForm\App\Helpers\Helper::getFormMeta($formId, 'double_optin_settings', []);

        if ($settings) {
            $defaults = wp_parse_args($settings, $defaults);
        }

        $globalSettings = $this->getGlobalSettings();

        if ($globalSettings['enabled'] != 'yes') {
            return false;
        }

        if (empty($defaults['email_body']) || $defaults['email_body_type'] == 'global') {
            $defaults['email_body'] = $globalSettings['email_body'];
        }

        if (empty($defaults['email_subject']) || $defaults['email_body_type'] == 'global') {
            $defaults['email_subject'] = $globalSettings['email_subject'];
        }

        if ($scope == 'public') {
            $defaults = wp_parse_args($defaults, $globalSettings);
        }

        return $defaults;
    }

    public function processOnSubmission($insertId, $formData, $form)
    {
        $doubleOptinSettings = $this->getDoubleOptinSettings($form->id, 'public');

        if (
            !$doubleOptinSettings
            || ArrayHelper::get($doubleOptinSettings, 'status') != 'yes'
            || (ArrayHelper::get($doubleOptinSettings, 'skip_if_logged_in') == 'yes' && get_current_user_id())
        ) {
            return;
        }

        $emailField = ArrayHelper::get($doubleOptinSettings, 'email_field');
        if (!$emailField) {
            return;
        }
        $emailId = trim(ArrayHelper::get($formData, $emailField));
        if (!$emailId || !is_email($emailId)) {
            return;
        }

        if (ArrayHelper::get($doubleOptinSettings, 'skip_if_fc_subscribed') == 'yes' && defined('FLUENTCRM')) {
            $crmContact = FluentCrmApi('contacts')->getContact($emailId);
            if ($crmContact && $crmContact->status == 'subscribed') {
                return;
            }
        }

        wpFluent()->table('fluentform_submissions')
            ->where('id', $insertId)
            ->update([
                'status' => $this->initialStatusSlug
            ]);


        $data = ArrayHelper::only($doubleOptinSettings, [
            'confirmation_message',
            'email_subject',
            'email_body'
        ]);

        $data = ShortCodeParser::parse($data, $insertId, $formData);
        $emailBody = $data['email_body'];

        $confirmationUrl = $shareUrl = add_query_arg([
            'ff_landing'         => $form->id,
            'entry_confirmation' => Helper::getSubmissionMeta($insertId, '_entry_uid_hash')
        ], site_url());

        $emailBody = str_replace('#confirmation_url#', $confirmationUrl, $emailBody);

        $notification = [
            'name'           => 'Double Optin Email',
            'fromName'       => ArrayHelper::get($doubleOptinSettings, 'fromName'),
            'fromEmail'      => ArrayHelper::get($doubleOptinSettings, 'fromEmail'),
            'replyTo'        => ArrayHelper::get($doubleOptinSettings, 'replyTo'),
            'bcc'            => '',
            'subject'        => $data['email_subject'],
            'message'        => $data['email_body'],
            'enabled'        => true,
            'email_template' => '',
            'sendTo'         => [
                'type'  => 'email',
                'email' => $emailId,
                'field' => ''
            ]
        ];

        $emailNotificationClass = new EmailNotification(wpFluentForm());
        $emailHeaders = $emailNotificationClass->getHeaders($notification);

        $emailBody = $emailNotificationClass->getEmailWithTemplate($emailBody, $form, $notification);

        $mailSent = wp_mail($emailId, $data['email_subject'], $emailBody, $emailHeaders);

        do_action('ff_log_data', [
            'parent_source_id' => $form->id,
            'source_type'      => 'submission_item',
            'source_id'        => $insertId,
            'component'        => 'DoubleOptin',
            'status'           => 'info',
            'title'            => 'Double Optin Confirmation Email sent',
            'description'      => 'Double Optin Email sent to form submitter [' . $emailId . ']',
        ]);

        $result = [
            'insert_id'  => $insertId,
            'result'     => [
                'redirectTo' => 'samePage',
                'message'    => $data['confirmation_message'],
                'action'     => 'hide_form'
            ],
            'error'      => '',
            'optin_sent' => $mailSent
        ];

        wp_send_json_success($result, 200);

    }

    private function getGlobalSettings()
    {
        $defaults = [
            'email_body'           => '<h2>Please Confirm Your Submission</h2><p>&nbsp;</p><p style="text-align: center;"><a style="color: #ffffff; background-color: #454545; font-size: 16px; border-radius: 5px; text-decoration: none; font-weight: normal; font-style: normal; padding: 0.8rem 1rem; border-color: #0072ff;" href="#confirmation_url#">Confirm Submission</a></p><p>&nbsp;</p><p>If you received this email by mistake, simply delete it. Your form submission won\'t proceed if you don\'t click the confirmation link above.</p>',
            'email_subject'        => __('Please confirm your form submission', 'fluentformpro'),
            'fromName'             => '',
            'fromEmail'            => '',
            'replyTo'              => '',
            'enabled'              => 'yes',
            'auto_delete_status'   => 'yes',
            'auto_delete_day_span' => 5
        ];

        if ($settings = get_option('_fluentform_double_optin_settings')) {
            return wp_parse_args($settings, $defaults);
        }

        return $defaults;
    }

    public function confirmSubmission($data)
    {
        $formId = ArrayHelper::get($data, 'ff_landing');

        if (!$this->isActivated($formId)) {
            die('Sorry! Invalid Form Confirmation URL');
        }

        $hash = ArrayHelper::get($data, 'entry_confirmation');

        $meta = wpFluent()->table('fluentform_submission_meta')
            ->where('form_id', $formId)
            ->where('meta_key', '_entry_uid_hash')
            ->where('value', $hash)
            ->first();

        if (!$meta) {
            die('Sorry! Invalid Confirmation URL');
        }
        $entryId = $meta->response_id;

        $entry = wpFluent()->table('fluentform_submissions')
            ->where('form_id', $formId)
            ->where('id', $entryId)
            ->first();

        if (!$entry) {
            die('Sorry! Invalid Confirmation URL.');
        }

        $submissionData = json_decode($entry->response, true);
        $form = wpFluent()->table('fluentform_forms')->find($formId);

        if ($entry->status == $this->initialStatusSlug || Helper::getSubmissionMeta($entryId, 'is_form_action_fired') != 'yes') {
            do_action('ff_log_data', [
                'parent_source_id' => $form->id,
                'source_type'      => 'submission_item',
                'source_id'        => $entryId,
                'component'        => 'DoubleOptin',
                'status'           => 'info',
                'title'            => 'Double Optin Confirmed',
                'description'      => 'Form submitter confirmed the double optin email from IP address: ' . wpFluentForm()->request->getIp(),
            ]);

            $confirmation = (new FormHandler(wpFluentForm()))->processFormSubmissionData($entryId, $submissionData, $form);
            $result = $confirmation['result'];

            wpFluent()->table('fluentform_submissions')
                ->where('id', $entryId)
                ->update([
                    'status' => $this->confirmedStatusSlug
                ]);
        } else {
            $result = (new FormHandler(wpFluentForm()))->getReturnData($entryId, $form, $submissionData);
        }

        if ($redirectUrl = ArrayHelper::get($result, 'redirectUrl')) {
            wp_redirect($redirectUrl);
            exit();
        }

        $settings = [
            'status'           => 'yes',
            'logo'             => '',
            'title'            => '',
            'description'      => '',
            'color_schema'     => '#4286c4',
            'custom_color'     => '#4286c4',
            'design_style'     => 'modern',
            'featured_image'   => '',
            'background_image' => ''
        ];

        $message = ShortCodeParser::parse($result['message'], $entryId, $submissionData);

        // We have to show the message now
        $landingVars = apply_filters('fluentform_submission_vars', [
            'settings'        => $settings,
            'title'           => 'Submission Confirmed - ' . $form->title,
            'form_id'         => $formId,
            'entry'           => $entry,
            'form'            => $form,
            'bg_color'        => $settings['custom_color'],
            'landing_content' => $message,
            'has_header'      => false
        ], $formId);


        (new SharePage())->loadPublicView($landingVars);
    }

    public function getGlobalSettingsAjax()
    {
        \FluentForm\App\Modules\Acl\Acl::verify('fluentform_settings_manager');

        wp_send_json_success([
            'settings' => $this->getGlobalSettings()
        ], 200);
    }

    public function updateGlobalSettingsAjax()
    {
        \FluentForm\App\Modules\Acl\Acl::verify('fluentform_settings_manager');
        $settings = wp_unslash($_REQUEST['settings']);
        update_option('_fluentform_double_optin_settings', $settings, 'no');
        wp_send_json_success([
            'message' => 'Settings successfully updated'
        ], 200);
    }

    public function maybeDeleteUnconfirmedEntries()
    {
        $this->maybeDeleteOldEntries();

        $settings = $this->getGlobalSettings();
        if (
            ArrayHelper::get($settings, 'auto_delete_status') != 'yes' ||
            ArrayHelper::get($settings, 'enabled') != 'yes'
        ) {
            return;
        }

        $daySpan = intval(ArrayHelper::get($settings, 'auto_delete_day_span'));
        if (!$daySpan) {
            $daySpan = 7;
        }
        $date = date('Y-m-d H:i:s', (time() - $daySpan * DAY_IN_SECONDS));

        $oldEntries = wpFluent()->table('fluentform_submissions')
            ->where('status', $this->initialStatusSlug)
            ->where('created_at', '<', $date)
            ->limit(100)
            ->get();

        $this->deleteEntries($oldEntries);

    }

    public function maybeDeleteOldEntries()
    {
        $autoDeleteFormMetas = wpFluent()->table('fluentform_form_meta')
            ->where('meta_key', 'auto_delete_days')
            ->get();

        if (!$autoDeleteFormMetas) {
            return;
        }

        $formGroups = [];

        foreach ($autoDeleteFormMetas as $meta) {
            if (!isset($formGroups[$meta->value])) {
                $formGroups[$meta->value] = [];
            }
            $formGroups[$meta->value][] = $meta->form_id;
        }

        foreach ($formGroups as $delayDays => $formIds) {
            $date = date('Y-m-d H:i:s', (time() - $delayDays * DAY_IN_SECONDS));
            $oldEntries = wpFluent()->table('fluentform_submissions')
                ->whereIn('form_id', $formIds)
                ->where('created_at', '<', $date)
                ->limit(100)
                ->get();
            $this->deleteEntries($oldEntries);
        }
    }

    public function deleteEntries($entries)
    {
        if(!$entries) {
            return;
        }
        $deletingIds = [];
        foreach ($entries as $entry) {
            $deletingIds[] = $entry->id;
            $this->deleteAssociateFiles($entry);
        }

        wpFluent()->table('fluentform_submissions')
            ->where('status', $this->initialStatusSlug)
            ->whereIn('id', $deletingIds)
            ->delete();


        wpFluent()->table('fluentform_submission_meta')
            ->whereIn('response_id', $deletingIds)
            ->delete();

        wpFluent()->table('fluentform_logs')
            ->whereIn('source_id', $deletingIds)
            ->where('source_type', 'submission_item')
            ->delete();

        wpFluent()->table('fluentform_entry_details')
            ->whereIn('submission_id', $deletingIds)
            ->delete();

        ob_start();

        try {

            wpFluent()->table('fluentform_order_items')
                ->whereIn('submission_id', $deletingIds)
                ->delete();

            wpFluent()->table('fluentform_transactions')
                ->whereIn('submission_id', $deletingIds)
                ->delete();

            wpFluent()->table('ff_scheduled_actions')
                ->whereIn('origin_id', $deletingIds)
                ->where('type', 'submission_action')
                ->delete();

        } catch (\Exception $exception) {
            // ...
        }

        $errors = ob_get_clean();
    }

    private function deleteAssociateFiles($entry)
    {

        if (apply_filters('fluentform_disable_attachment_delete', false, $entry->form_id)) {
            return;
        }

        $fileFields = $this->getFileFields($entry->form_id);
        if (!$fileFields) {
            return;
        }

        $data = json_decode($entry->response, true);

        foreach ($fileFields as $field) {
            if (!empty($data[$field])) {
                $files = $data[$field];
                if (!is_array($files)) {
                    $files = [$files];
                }
                foreach ($files as $file) {
                    $file = wp_upload_dir()['basedir'] . FLUENTFORM_UPLOAD_DIR . '/' . basename($file);
                    if (is_readable($file) && !is_dir($file)) {
                        @unlink($file);
                    }
                }
            }
        }
    }

    private function getFileFields($formId)
    {
        static $fieldsCache = [];
        if (isset($formsCache[$formId])) {
            return $formsCache;
        }

        $form = wpFluent()->table('fluentform_forms')->find($formId);

        if (!$form) {
            return [];
        }

        $fields = FormFieldsParser::getAttachmentInputFields($form, ['element', 'attributes']);

        $filesFieldNames = [];
        foreach ($fields as $field) {
            if (!empty($field['attributes']['name'])) {
                $filesFieldNames[] = $field['attributes']['name'];
            }
        }

        $fieldsCache[$formId] = $filesFieldNames;

        return $fieldsCache[$formId];

    }
}