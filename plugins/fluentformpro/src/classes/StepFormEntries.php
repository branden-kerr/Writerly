<?php
namespace FluentFormPro\classes;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Helpers\Helper;
use FluentForm\App\Modules\Acl\Acl;
use FluentForm\App\Modules\Entries\Entries;
use FluentForm\App\Modules\Entries\Export;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentForm\App\Modules\Form\FormDataParser;
use FluentForm\App\Modules\Form\FormFieldsParser;

class StepFormEntries
{
    protected $formId = false;
    protected $per_page = 10;
    protected $page_number = 1;
    protected $status = false;
    protected $is_favourite = null;
    protected $sort_by = 'ASC';
    protected $search = false;
    protected $wheres = [];
    protected $formTable = 'fluentform_forms';
    protected $entryTable = 'fluentform_draft_submissions';

    public static function boot($app)
    {
        return new static($app);
    }

    public function __construct($app)
    {
        $this->app = $app;

        $this->registerAjaxHandlers();

        $this->app->addFilter('fluentform_form_admin_menu', [$this, 'addAdminMenu'], 10, 2);

        $app->addAction('ff_fluentform_form_application_view_msformentries', [$this, 'renderEntries']);
    }

    protected function registerAjaxHandlers()
    {
        $this->app->addAdminAjaxAction('fluentform-step-form-entry-count', function () {
            Acl::verify('fluentform_entries_viewer');
            $this->getCountOfEntries();
        });

        $this->app->addAdminAjaxAction('fluentform-step-form-entries', function () {
            Acl::verify('fluentform_entries_viewer');
            $this->getEntries();
        });

        $this->app->addAdminAjaxAction('fluentform-step-form-delete-entry', function () {
            Acl::verify('fluentform_entries_viewer');
            $this->deleteEntry();
        });

        $this->app->addAdminAjaxAction('fluentform-step-form-entries-export', function () {
            Acl::verify('fluentform_entries_viewer');
            (new Export($this->app, 'fluentform_draft_submissions'))->index();
        });

        $this->app->addAdminAjaxAction('fluentform-step-form-get-entry', function () {
            Acl::verify('fluentform_entries_viewer');
            $this->getEntry();
        });
    }

    public function addAdminMenu($formAdminMenus, $form_id)
    {
        if (Helper::getFormMeta($form_id, 'step_data_persistency_status') != 'yes') {
            return $formAdminMenus;
        }
        $formAdminMenus['msformentries'] = [
            'hash' => '/',
            'slug' => 'msformentries',
            'title' => __('Partial Entries', 'fluentformpro'),
            'url' => admin_url(
                'admin.php?page=fluent_forms&form_id=' . $form_id . '&route=msformentries'
            )
        ];

        return $formAdminMenus;
    }

    public function renderEntries($form_id)
    {
        $this->enqueueScript();

        $form = wpFluent()->table($this->formTable)->find($form_id);


        $fluentformStepFormEntryVars = apply_filters('fluentform_step_form_entry_vars', [
            'form_id' => $form->id,
            'current_form_title' => $form->title,
            'has_pro' => defined('FLUENTFORMPRO'),
            'all_forms_url' => admin_url('admin.php?page=fluent_forms'),
            'printStyles' => [fluentformMix('css/settings_global.css')],
            'entries_url_base' => admin_url('admin.php?page=fluent_forms&route=msformentries&form_id='),
            'available_countries' => $this->app->load(
                $this->app->appPath('Services/FormBuilder/CountryNames.php')
            ),
            'no_found_text' => __('Sorry! No entries found. All your entries will be shown here once you start getting form submissions', 'fluentformpro'
            )
        ], $form);

        wp_localize_script(
            'fluentform_step_form_entries',
            'fluentform_step_form_entry_vars',
            $fluentformStepFormEntryVars
        );

        ob_start();
        require(FLUENTFORMPRO_DIR_PATH . 'src/views/step_form_entries.php');
        echo ob_get_clean();
    }

    protected function enqueueScript()
    {
        wp_enqueue_script(
            'fluentform_step_form_entries',
            FLUENTFORMPRO_DIR_URL . 'public/js/step-form-entries.js',
            ['jquery'],
            FLUENTFORM_VERSION,
            true
        );
    }

    public function getCountOfEntries()
    {
        $formId = intval($this->app->request->get('form_id'));

        $count = wpFluent()->table($this->entryTable)
            ->select(wpFluent()->table($this->entryTable)->raw('COUNT(*) as count'))
            ->where('form_id', $formId)
            ->count();

        wp_send_json_success([
            'count' => $count
        ], 200);

    }

    public function getEntries()
    {
        if (!defined('FLUENTFORM_RENDERING_ENTRIES')) {
            define('FLUENTFORM_RENDERING_ENTRIES', true);
        }

        $entries = $this->getStepFormEntries(
            intval($this->app->request->get('form_id')),
            intval($this->app->request->get('current_page', 1)),
            intval($this->app->request->get('per_page', 10)),
            sanitize_text_field($this->app->request->get('sort_by', 'DESC')),
            sanitize_text_field($this->app->request->get('entry_type', 'all')),
            sanitize_text_field($this->app->request->get('search'))
        );


        $labels = apply_filters(
            'fluentform_all_entry_labels', $entries['formLabels'], $this->app->request->get('form_id')
        );

        $form = wpFluent()->table($this->formTable)->find($this->app->request->get('form_id'));

        wp_send_json_success([
            'submissions' => apply_filters('fluentform_all_entries', $entries['submissions']),
            'labels' => $labels
        ], 200);
    }

    public function getStepFormEntries(
        $formId,
        $currentPage,
        $perPage,
        $sortBy,
        $entryType,
        $search,
        $wheres = []
    )
    {
        $form = wpFluent()->table($this->formTable)->find($formId);
        $formMeta = $this->getFormInputsAndLabels($form);
        $formLabels = $formMeta['labels'];
        $formLabels = apply_filters('fluentfoform_entry_lists_labels', $formLabels, $form);
        $submissions = $this->getResponses($formId, $perPage, $sortBy, $currentPage, $search, $wheres);
        $submissions['data'] = FormDataParser::parseFormEntries($submissions['data'], $form);

        return compact('submissions', 'formLabels');
    }

    public function getResponses($formId, $perPage, $sortBy, $currentPage, $search = '', $wheres = [])
    {
        $query = wpFluent()->table($this->entryTable)->where('form_id', $formId)->orderBy('id', $sortBy);

        if ($perPage > 0) {
            $query = $query->limit($perPage);
        }

        if ($currentPage > 0) {
            $query = $query->offset(($currentPage - 1) * $perPage);
        }

        if ($search) {
            $searchString = $search;
            $query->where(function ($q) use ($searchString) {
                $q->where('id', 'LIKE', "%{$searchString}%")
                    ->orWhere('response', 'LIKE', "%{$searchString}%");
            });
        }

        if ($wheres) {
            foreach ($wheres as $where) {
                if (is_array($where) && count($where) > 1) {
                    if (count($where) > 2) {
                        $column = $where[0];
                        $operator = $where[1];
                        $value = $where[2];
                    } else {
                        $column = $where[0];
                        $operator = '=';
                        $value = $where[1];
                    }
                    $query->where($column, $operator, $value);
                }
            }
        }

        $total = $query->count();
        $responses = $query->get();
        $responses = apply_filters('fluentform_get_raw_responses', $responses, $formId);

        return [
            'data' => $responses,
            'paginate' => [
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $currentPage,
                'last_page' => ceil($total / $perPage)
            ]
        ];
    }

    public function getEntry()
    {
        $entryData = $this->getstepFormEntry();

        $entryData['widgets'] = apply_filters('fluentform_single_entry_widgets', [], $entryData);

        wp_send_json_success($entryData, 200);
    }

    public function getstepFormEntry()
    {
        $this->formId = intval($this->app->request->get('form_id'));

        $entryId = intval($this->app->request->get('entry_id'));

        $this->sort_by = sanitize_text_field($this->app->request->get('sort_by', 'ASC'));

        $this->search = sanitize_text_field($this->app->request->get('search'));

        $submission = $this->getResponse($entryId);

        if (!$submission) {
            wp_send_json_error([
                'message' => 'No Entry found.'
            ], 422);
        }

        $form = wpFluent()->table($this->formTable)->find($this->formId);

        $formMeta = $this->getFormInputsAndLabels($form);

        $submission = FormDataParser::parseFormEntry($submission, $form, $formMeta['inputs'], true);

        if ($submission->user_id) {
            $user = get_user_by('ID', $submission->user_id);
            $user_data = [
                'name' => $user->display_name,
                'email' => $user->user_email,
                'ID' => $user->ID,
                'permalink' => get_edit_user_link($user->ID)
            ];
            $submission->user = $user_data;
        }

        $submission = apply_filters('fluentform_single_response_data', $submission, $this->formId);

        $fields = apply_filters(
            'fluentform_single_response_input_fields', $formMeta['inputs'], $this->formId
        );

        $labels = apply_filters(
            'fluentform_single_response_input_labels', $formMeta['labels'], $this->formId
        );

        $order_data = false;

        $nextSubmissionId = $this->getNextResponse($entryId);

        $previousSubmissionId = $this->getPrevResponse($entryId);

        return [
            'submission' => $submission,
            'next' => $nextSubmissionId,
            'prev' => $previousSubmissionId,
            'labels' => $labels,
            'fields' => $fields,
            'order_data' => $order_data
        ];
    }

    protected function getResponse($entryId)
    {
        return wpFluent()->table($this->entryTable)->find($entryId);
    }

    protected function getFormInputsAndLabels($form, $with = ['admin_label', 'raw'])
    {
        $formInputs = FormFieldsParser::getEntryInputs($form, $with);

        $inputLabels = FormFieldsParser::getAdminLabels($form, $formInputs);

        return [
            'inputs' => $formInputs,
            'labels' => $inputLabels
        ];
    }

    protected function getNextResponse($entryId)
    {
        $query = $this->getNextPrevEntryQuery();

        $operator = $this->sort_by == 'ASC' ? '>' : '<';

        return $query->select('id')
            ->where('id', $operator, $entryId)
            ->orderBy('id', $this->sort_by)
            ->first();
    }

    protected function getPrevResponse($entryId)
    {
        $query = $this->getNextPrevEntryQuery();

        $operator = $this->sort_by == 'ASC' ? '<' : '>';

        $orderBy = $this->sort_by == 'ASC' ? 'DESC' : 'ASC';

        return $query->select('id')
            ->where('id', $operator, $entryId)
            ->orderBy('id', $orderBy)
            ->first();
    }

    protected function getNextPrevEntryQuery()
    {
        $query = wpFluent()->table($this->entryTable)->limit(1);

        if ($this->search) {
            $query->where('response', 'LIKE', "%{$this->search}%");
        }

        return $query->where('form_id', $this->formId);
    }

    public function deleteEntry()
    {
        $formId = intval($this->app->request->get('form_id'));
        $entryId = intval($this->app->request->get('entry_id'));
        $newStatus = sanitize_text_field($this->app->request->get('status'));

        $this->deleteEntryById($entryId, $formId);

        wp_send_json_success([
            'message' => __('Item Successfully deleted', 'fluentformpro'),
            'status' => $newStatus
        ], 200);
    }

    public function deleteEntryById($entryId, $formId = false)
    {
        do_action('fluentform_before_partial_entry_deleted', $entryId, $formId);

        ob_start();
        wpFluent()->table($this->entryTable)->where('id', $entryId)->delete();
        $errors = ob_get_clean();

        do_action('fluentform_after_partial_entry_deleted', $entryId, $formId);

        return true;
    }

    protected function getSubmissionAttachments($submissionId, $form)
    {
        $fields = FormFieldsParser::getAttachmentInputFields($form, ['element', 'attributes']);

        $deletableFiles = [];

        if ($fields) {
            $submission = wpFluent()->table($this->entryTable)
                ->where('id', $submissionId)
                ->first();

            $data = json_decode($submission->response, true);

            foreach ($fields as $field) {
                if (!empty($data[$field['attributes']['name']])) {

                    $files = $data[$field['attributes']['name']];

                    if (is_array($files)) {
                        $deletableFiles = array_merge($deletableFiles, $files);
                    } else {
                        $deletableFiles = $files;
                    }

                }
            }
        }

        return $deletableFiles;
    }
}
