<?php

namespace FluentFormPro;

use FluentForm\App\Modules\Form\FormHandler;
use FluentForm\App\Modules\Form\FormFieldsParser;

class Uploader extends FormHandler
{
    /**
     * Uploads files to the server.
     */
    public function upload()
    {
        $this->overrideUploadDir();

        $formId = intval($this->request->get('formId'));

        $this->formData = $this->request->all();

        if ($formId) {
            $this->setForm($formId);

            $this->validateNonce();

            if ($this->form) {
                // Get the HTTP files. It'll be an array with always one item.
                $files = $this->request->files();

                do_action('fluentform_starting_file_upload', $files, $this->form);

                // Get the form attribute name then.
                $arrayKeys = array_keys($files);
                $attribute = array_pop($arrayKeys);

                // Get the specific form field by using the element type and it's attribute name.
                $field = FormFieldsParser::getField(
                    $this->form,
                    ['input_file', 'input_image', 'featured_image'],
                    $attribute,
                    ['rules']
                );

                if ($field) {
                    // Extract the validation rules & messages for file upload element.
                    list($rules, $messages) = FormFieldsParser::getValidations(
                        $this->form, $files, $field
                    );
                    /**
                     * Delegate 'max_file_size', 'allowed_file_types' rules & messages to
                     * 'max', 'mimes' since the validation library doesn't recognise those
                     */
                    list($rules, $messages) = $this->delegateValidations($rules, $messages);

                    // Fire an event so that one can hook into it to work with the rules & messages.
                    $validations = $this->app->applyFilters(
                        'fluentform_file_upload_validations',
                        [$rules, $messages],
                        $this->form
                    );

                    $validator = \FluentValidator\Validator::make(
                        $files, $validations[0], $validations[1]
                    );

                    if ($validator->validate()->fails()) {
                        // Fire an event so that one can hook into it to work with the errors.
                        $errors = $this->app->applyFilters(
                            'fluentform_file_upload_validation_error',
                            $validator->errors(),
                            $this->form
                        );

                        wp_send_json([
                            'errors' => $errors
                        ], 422);
                    }

                    // it's safe to upload file now
                    $uploadedFiles = [];
                    foreach ($files as $file) {
                        /**
                         * @var $file \FluentForm\Framework\Request\File
                         */
                        $filesArray = $file->toArray();

                        $uploaderArgs = apply_filters('fluentform_uploader_args', [
                            'test_form' => false
                        ], $filesArray, $this->form);

                        $uploadedFiles[] = wp_handle_upload(
                            $filesArray,
                            $uploaderArgs
                        );
                    }

                    wp_send_json_success([
                        'files' => $uploadedFiles
                    ], 200);
                }
            }
        }
    }

    /**
     * Register filters for custom upload dir
     */
    public function overrideUploadDir()
    {
        add_filter('wp_handle_upload_prefilter', function ($file) {
            add_filter('upload_dir', [$this, 'setCustomUploadDir']);

            add_filter('wp_handle_upload', function ($fileinfo) {
                remove_filter('upload_dir', [$this, 'setCustomUploadDir']);
                $fileinfo['file'] = basename($fileinfo['file']);
                return $fileinfo;
            });

            return $this->renameFileName($file);
        });
    }

    /**
     * Set plugin's custom upload dir
     * @param  array $param
     * @return array $param
     */
    public function setCustomUploadDir($param)
    {
        $param['url'] = $param['baseurl'].FLUENTFORM_UPLOAD_DIR;
        $param['path'] = $param['basedir'].FLUENTFORM_UPLOAD_DIR;
        if (!is_dir($param['path'])) {
            mkdir($param['path'], 0755);
            file_put_contents(
                wp_upload_dir()['basedir'].FLUENTFORM_UPLOAD_DIR.'/.htaccess',
                file_get_contents(__DIR__.'/Stubs/htaccess.stub')
            );
        }

        return $param;
    }

    /**
     * Rename the uploaded file name before saving
     * @param  array $file
     * @return array $file
     */
    public function renameFileName($file)
    {
        $originalArray = $file;
        $prefix = 'ff-' . md5(uniqid(rand())) .'-ff-';

        $file['name'] = $prefix . $file['name'];

        return apply_filters('fluentform_uploaded_file_name', $file, $originalArray);
    }

    /**
     * Prepare the validation rules & messages specific to
     * file type inputs when actual form is submitted.
     *
     * @param $validations
     * @param $form \stdClass
     * @return array
     */
    public function prepareValidations($validations, $form)
    {
        $element = FormFieldsParser::getElement($form, ['input_file', 'input_image']);

        if (count($element)) {
            // Delegate the `max_file_count` validation to `max`
            $validations = $this->delegateValidations(
                $validations[0], $validations[1], ['max_file_count'], ['max']
            );
        }

        return $validations;
    }

    public function deleteFile() {
        if (!empty($_POST['path'])) {
            $file_name = sanitize_file_name($_POST['path']);
            wp_die(@unlink(
                wp_upload_dir()['basedir'] . FLUENTFORM_UPLOAD_DIR . '/' . $file_name
            ));
        }
    }
}
