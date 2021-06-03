<?php
namespace FluentFormPro\Components\Post;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Modules\Form\FormFieldsParser;
use FluentForm\App\Services\ConditionAssesor;
use FluentForm\App\Services\FormBuilder\ShortCodeParser;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentFormPro\Components\Post\Components\HierarchicalTaxonomy;
use FluentFormPro\Components\Post\Components\NonHierarchicalTaxonomy;

class PostFormHandler
{
    public function renderTaxonomyFields($data, $form)
    {
        if ($form->type != 'post') return;

        if (isset($data['taxonomy_settings'])) {
            if ($data['taxonomy_settings']['hierarchical']) {
                return (new HierarchicalTaxonomy)->compile($data, $form);
            } else {
                return (new NonHierarchicalTaxonomy)->compile($data, $form);
            }
        }
    }

    public function onFormSubmissionInserted($entryId, $formData, $form)
    {
        $feeds = $this->getFormFeeds($form);

        if (!$feeds) {
            return;
        }

        $postType = $this->getPostType($form);

        $entry = wpFluent()->table('fluentform_submissions')
            ->where('id', $entryId)
            ->first();

        foreach ($feeds as $feed) {
            $feed->value = json_decode($feed->value, true);

            if (!ArrayHelper::get($feed->value, 'feed_status')) continue;

            $feed = ShortCodeParser::parse($feed->value, $entryId, $formData, $form);

            if (!$this->isConditionMet($feed, $formData)) {
                continue;
            }

            $this->createPostFromFeed($feed, $entry, $formData, $form, $postType);
        }
    }

    public function createPostFromFeed($feed, $entry, $formData, $form, $postType = false)
    {
        if(!is_object($entry)) {
            $entry = wpFluent()->table('fluentform_submissions')
                ->where('id', $entry)
                ->first();
        }
        if(!$postType) {
            $postType = $this->getPostType($form);
        }

        $postData = [
            'post_type' => $postType,
            'post_status' => ArrayHelper::get($feed, 'post_status'),
            'comment_status' => ArrayHelper::get($feed, 'comment_status'),
            'post_category' => array(ArrayHelper::get($feed, 'default_category'))
        ];

        if(!empty($entry->user_id)) {
            $postData['post_author'] = $entry->user_id;
        }


        $postData = $this->mapPostFields($feed, $postData);

        $postData = $this->mapMetaFields($feed, $postData, $postType, $formData);

        $formInputs = FormFieldsParser::getInputs($form, ['element', 'raw', 'attributes']);

        foreach ($formInputs as $field) {
            if ($field['element'] == 'featured_image') {
                $fieldName = $field['attributes']['name'];
                if (!empty($formData[$fieldName][0])) {
                    $postData['featured_Image'] = $formData[$fieldName][0];
                }
            }

            if (isset($field['raw']['taxonomy_settings'])) {
                $postData = $this->mapTaxonomyFields(
                    $field['raw']['taxonomy_settings'], $postData, $formData
                );
            }
        }

        $this->insertPost($feed, $postData, $form, $entry->id);
    }

    protected function isConditionMet($feed, $formData)
    {
        // We have to check if the feed meets the conditional Logic
        $conditionSettings = ArrayHelper::get($feed, 'conditionals');

        if (
            !$conditionSettings ||
            !ArrayHelper::isTrue($conditionSettings, 'status') ||
            !count(ArrayHelper::get($conditionSettings, 'conditions'))
        ) {
            return true;
        }

        return ConditionAssesor::evaluate($feed, $formData);
    }

    protected function getFormFeeds($form)
    {
        return wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $form->id)
            ->where('meta_key', 'postFeeds')
            ->get();
    }

    protected function getPostType($form)
    {
        $postSettings = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $form->id)
            ->where('meta_key', 'post_settings')
            ->first()->value;

        $postSettings = json_decode($postSettings);

        return $postSettings->post_type;
    }

    protected function mapPostFields($feed, $postData)
    {
        foreach ($feed['post_fields_mapping'] as $postFieldMapping) {
            $postField = $postFieldMapping['post_field'];

            if ($postField != 'post_title') {
                $postData[$postField] = $postFieldMapping['form_field'];
            } else {
                $postData[$postField] = wp_strip_all_tags($postFieldMapping['form_field']);
            }
        }

        return $postData;
    }

    protected function mapMetaFields($feed, $postData, $postType, $formData = [])
    {
        $metaInputs = ArrayHelper::get($feed, 'meta_fields_mapping', []);

        foreach ($metaInputs as $metaFieldMapping) {
            $metaKey = $metaFieldMapping['meta_key'];
            $postData['meta_input'][$metaKey] = $metaFieldMapping['meta_value'];
        }

        if (!class_exists('\ACF')) {
            return $postData;
        }

        $postData['acf_mappings'] = [];

        if ($acfFields = ArrayHelper::get($feed, 'acf_mappings', [])) {
            $metaValues = AcfHelper::prepareGeneralFieldsData($acfFields, $postType);
            if ($metaValues) {
                $postData['acf_mappings'] = array_merge($postData['acf_mappings'], $metaValues);
            }
        }

        if ($advancedAcfFields = ArrayHelper::get($feed, 'advanced_acf_mappings', [])) {
            $metaValues = AcfHelper::prepareAdvancedFieldsData($advancedAcfFields, $formData, $postType);
            if ($metaValues) {
                $postData['acf_mappings'] = array_merge($postData['acf_mappings'], $metaValues);
            }
        }

        return $postData;
    }

    protected function mapTaxonomyFields($taxonomySettings, $postData, $formData)
    {
        $taxonomyFieldName = $taxonomySettings['name'];

        if (!isset($formData[$taxonomyFieldName])) {
            return $postData;
        }

        $taxonomyData = $formData[$taxonomyFieldName];

        if ($taxonomyFieldName == 'category') {
            if ($taxonomyData) {
                $postData['post_category'] = (array)$taxonomyData;
            }
        } else if ($taxonomyFieldName == 'post_tag') {
            $tags = explode(',', $taxonomyData);
            $postData['tags_input'] = array_map('trim', $tags);
        } else {
            $postData['tax_input'][$taxonomyFieldName] = $taxonomyData;
        }

        return $postData;
    }

    protected function insertPost($feed, $postData, $form, $entryId)
    {
        $acfFields = [];
        if(isset($postData['acf_mappings'])) {
            $acfFields = $postData['acf_mappings'];
            unset($postData['acf_mappings']);
        }

        $postId = wp_insert_post($postData);

        if (is_wp_error($postId)) {
            return;
        }

        if($acfFields && function_exists('update_field')) {
            foreach ($acfFields as $fieldKey => $value) {
                update_field($fieldKey, $value, $postId);
            }
        }

        $editLink = get_edit_post_link($postId);
        if(!$editLink) {
            $editLink = admin_url('post.php?post='.$postId.'&action=edit');
        }

        $info = 'WP Post/CPT created from submission. Post ID: ' . $postId . '. <a href="' . $editLink . '" target="_blank">Edit Post/CPT</a>';

        do_action('ff_log_data', [
            'parent_source_id' => $form->id,
            'source_type' => 'submission_item',
            'source_id' => $entryId,
            'component' => 'postFeeds',
            'status' => 'success',
            'title' => 'Post created from form submission',
            'description' => $info
        ]);


        wpFluent()->table('fluentform_submission_meta')
            ->insert([
                'response_id' => $entryId,
                'form_id' => $form->id,
                'meta_key' => '__postFeeds_created_id',
                'value' => $postId,
                'name' => 'Post/CPT Created',
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql'),
            ]);

        update_post_meta($postId, '_fluentform_id', $form->id);

        if (!function_exists('set_post_thumbnail')) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
        }

        if(!empty($feed['post_format'])) {
            $format = 'post-format-' . $feed['post_format'];
            wp_set_post_terms($postId, $format, 'post_format');
        }

        if (isset($postData['featured_Image'])) {
            $this->setFeaturedImage($postId, $postData['featured_Image']);
        }

        do_action('fluentform_post_integration_success', $postId, $postData, $entryId, $form, $feed);
    }

    protected function setFeaturedImage($postId, $featuredImage)
    {
        $attach_id = $this->getAttachmentToImageUrl($featuredImage);
        if($attach_id) {
            // And finally assign featured image to post
            return set_post_thumbnail($postId, $attach_id);
        }

        return false;
    }

    public function getAttachmentToImageUrl($fileUrl, $postId = 0)
    {
        $path = wp_upload_dir()['basedir'] . FLUENTFORM_UPLOAD_DIR;

        $file = $path . substr($fileUrl, strrpos($fileUrl, '/'));

        $upload_dir = wp_upload_dir();

        $fileArray = explode('-ff-', $file);
        $actualName = array_pop($fileArray);

        $unique_file_name = wp_unique_filename($upload_dir['path'], $actualName); // Generate unique name
        $destination = $upload_dir['path'] . '/' . $unique_file_name;

        $newFileUrl = $upload_dir['url'].'/'.$unique_file_name;

        $result = copy($file, $destination);


        $filePath = $file;
        if ($result) {
            $filePath = $destination;
        }

        // Check image file type
        $wp_filetype = wp_check_filetype($unique_file_name, null);


        // Set attachment data
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($unique_file_name),
            'post_content' => '',
            'post_status' => 'inherit',
            'guid' => $newFileUrl
        );

        // Create the attachment
        $attach_id = wp_insert_attachment($attachment, $filePath, $postId);


        if (!function_exists('wp_generate_attachment_metadata')) {
            // Include image.php
            require_once(ABSPATH . 'wp-admin/includes/image.php');
        }

        // Define attachment metadata
        $attach_data = wp_generate_attachment_metadata($attach_id, $filePath);

        // Assign metadata to attachment
        wp_update_attachment_metadata($attach_id, $attach_data);
        return $attach_id;
    }
}
