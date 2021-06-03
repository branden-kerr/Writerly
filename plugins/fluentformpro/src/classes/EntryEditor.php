<?php

namespace FluentFormPro\classes;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Modules\Entries\Entries;

class EntryEditor
{
    public static function editEntry()
    {
        $entryId = intval($_REQUEST['entry_id']);

        $entryData = \json_decode(wp_unslash($_REQUEST['entry']), true);

        try {
            static::updateEntryResponse($entryId, $entryData);
        } catch (\Exception $exception) {
            wp_send_json_error([
                'message' => $exception->getMessage()
            ], 423);
        }

        wp_send_json_success([
            'message' => __('Entry data successfully updated', 'fluentformpro'),
            'data' => $entryData
        ]);
    }

    public static function updateEntryResponse($id, $response)
    {
        // Find the database Entry First
        $entry = wpFluent()->table('fluentform_submissions')
            ->where('id', $id)
            ->first();

        if (!$entry) {
            throw new \Exception('No Entry Found');
        }

        $origianlResponse = json_decode($entry->response, true);

        $diffs = [];
        foreach ($response as $resKey => $resvalue) {
            if (!isset($origianlResponse[$resKey]) || $origianlResponse[$resKey] != $resvalue) {
                $diffs[$resKey] = $resvalue;
            }
        }

        if (!$diffs) {
            return true;
        }

        $response = wp_parse_args($response, $origianlResponse);

        wpFluent()->table('fluentform_submissions')
            ->where('id', $id)
            ->update([
                'response' => json_encode($response),
                'updated_at' => current_time('mysql')
            ]);


        $entries = new Entries();

        $entries->updateEntryDiffs($id, $entry->form_id, $diffs);

        $user = get_user_by('ID', get_current_user_id());

        if ($user) {
            $message = 'Entry data has been updated by '.$user->user_login;
        }

        do_action('ff_log_data', [
            'parent_source_id' => $entry->form_id,
            'source_type' => 'submission_item',
            'source_id' => $entry->id,
            'component' => 'EntryEditor',
            'status' => 'info',
            'title' => 'Entry Data Updated',
            'description' => $message,
        ]);

        return true;
    }
}
