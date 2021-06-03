<?php

namespace FluentFormPro\Integrations\BuddyIntegration;

class FluentFormBuddyBoss
{
    public function init()
    {
        add_filter('fluentform_user_registration_feed_fields', array($this, 'pushSettingsFields'));
        add_filter('fluentform_user_registration_field_defaults', array($this, 'pushFieldDefaults'));
        add_action('fluentform_user_registration_completed', array($this, 'saveDataToUser'), 10, 3);
    }

    public function pushFieldDefaults($defaults)
    {
        $defaults['bboss_profile_fields'] = [
            [
                'label'      => '',
                'item_value' => ''
            ]
        ];
        $defaults['bboss_profile_type'] = '';

        return $defaults;
    }

    public function pushSettingsFields($fields)
    {
        $fields[] = [
            'key'       => 'html_info',
            'label'     => '',
            'component' => 'html_info',
            'html_info' => '<h3 style="margin-bottom: 0">BuddyBoss Settings</h3><hr />'
        ];

        $groups = bp_xprofile_get_groups(
            array(
                'fetch_fields' => true
            )
        );

        $profileFields = [];

        foreach ($groups as $group) {
            foreach ($group->fields as $field) {
                $profileFields[$field->id . ' '] = $field->name; // We need to key as string so adding an extra space
            }
        }

        $profileTypes = [];

        $member_types = bp_get_member_types(array(), 'objects');
        foreach ($member_types as $typeName => $member_type) {
            $profileTypes[$typeName] = $member_type->labels['name'];
        }

        $fields[] = [
            'key'         => 'bboss_profile_fields',
            'label'       => 'Profile Fields',
            'component'   => 'dropdown_many_fields',
            'options'     => $profileFields,
            'remote_text' => 'X-Profile Field',
            'local_text'  => 'Form Field',
            'tips'        => 'Map your BuddyBoss x-profile fields with your form fields'
        ];


        if ($profileTypes) {
            $fields[] = [
                'key'       => 'bboss_profile_type',
                'label'     => 'BuddyBoss Profile Type',
                'component' => 'select',
                'options'   => $profileTypes,
                'tips'      => 'Select BuddyBoss Profile Type'
            ];
        }


        return $fields;
    }

    /*
     * This function will be called once user registration has been completed
     */
    public function saveDataToUser($userId, $feed, $entry)
    {
        $xProfileFields = \FluentForm\Framework\Helpers\ArrayHelper::get($feed, 'processedValues.bboss_profile_fields', []);
        $parsedXFields = [];
        foreach ($xProfileFields as $xProfileField) {
            if (!empty($xProfileField['item_value'])) {
                $fieldId = intval($xProfileField['label']);
                $parsedXFields[$fieldId] = esc_html($xProfileField['item_value']);
            }
        }

        if ($parsedXFields) {
            $this->setXProfileFields($userId, $parsedXFields);
        }

        $profileTypeSlug = \FluentForm\Framework\Helpers\ArrayHelper::get($feed, 'processedValues.bboss_profile_type');

        if ($profileTypeSlug) {
            $this->setProfileType($userId, $profileTypeSlug, $entry);
        }
    }

    private function setProfileType($userId, $profileSlug, $entry)
    {

        bp_set_member_type($userId, $profileSlug);


        /*
         * Add a note to Fluent Forms Entry Details
         */
        do_action('ff_log_data', [
            'title'            => 'BoddyBoss Profile has been created - User Id: ' . $userId,
            'status'           => 'success',
            'description'      => 'Profile has been created in BuddyBoss. Profile Type: ' . $profileSlug,
            'parent_source_id' => $entry->form_id,
            'source_id'        => $entry->id,
            'component'        => 'UserRegistration',
            'source_type'      => 'submission_item'
        ]);
    }

    private function setXProfileFields($userId, $fields)
    {
        foreach ($fields as $fieldKey => $value) {
            xprofile_set_field_data($fieldKey, $userId, $value);
        }
    }
}