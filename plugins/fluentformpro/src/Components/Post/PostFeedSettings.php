<?php
namespace FluentFormPro\Components\Post;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class PostFeedSettings
{
    /**
     * Handles fluentform_get_post_types ajax action
     * @return Array Possible post types to create a post form
     */
    public function getPostTypes()
    {
        $ignoredPostTypes = ['attachment'];

        $publicPostTypes = get_post_types(['public' => true]);

        return array_keys(array_diff($publicPostTypes, $ignoredPostTypes));
    }

    /**
     * Handles fluentform_get_post_settings ajax action
     * @return Array Possible post settings for post feed management
     */
    public function getPostSettings()
    {
        $formId = intval($_REQUEST['form_id']);

        $postSettings = $this->getFormSettings($formId);

        $data['comment_statuses'] = ['open', 'close'];

        $data['post_statuses'] = ['draft', 'pending', 'private', 'publish'];

        $data['post_fields'] = ['post_title', 'post_content', 'post_excerpt', 'featured_image'];

        $data['post_info'] = $this->getPostInfo();

        $data['taxonomies'] = $this->getPostTaxonomies($postSettings->post_type);

        $acfFields = AcfHelper::getAcfFields($postSettings->post_type);

        $data['acf_fields'] = $acfFields['general'];
        
        $data['acf_fields_advanced'] = $acfFields['advanced'];

        $data['has_acf'] = class_exists('\ACF');

        $data['post_formats'] = $this->getPostFormats();

        $data['categories'] = $categories = $this->getCategories();

        $data['default_feed'] = $this->getDefaultFeed(
            $this->getDefaultCategory($categories)
        );

        return $data;
    }

    protected function getPostInfo()
    {
        $postInfo = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', intval($_REQUEST['form_id']))
            ->where('meta_key', 'post_settings')
            ->first();

        $postInfo->value = json_decode($postInfo->value);

        return $postInfo;
    }

    protected function getPostTaxonomies($postType)
    {

        return array_map(function ($taxonomy) {
            return [
                'name' => $taxonomy->name,
                'label' => $taxonomy->label
            ];
        }, get_object_taxonomies($postType, 'object'));
    }

    private function getFormSettings($formId)
    {
        $form = wpFluent()->table('fluentform_forms')->where('id', $formId)->first();

        $value = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $form->id)
            ->where('meta_key', 'post_settings')
            ->first()->value;

        return json_decode($value);
    }

    protected function getPostFormats()
    {
        $postFormats = [];

        if (current_theme_supports('post-formats')) {
            $postFormats = get_theme_support('post-formats');
            if (is_array($postFormats[0])) {
                $postFormats = array_merge(['standard'], $postFormats[0]);
            }
        }

        return $postFormats;
    }

    protected function getCategories()
    {
        $allCategories = get_categories([
            'hide_empty' => 0,
            'order' => 'DESC',
            'order_by' => 'cat_ID'
        ]);

        $categories = [];

        foreach ($allCategories as $category) {
            $categories[] = [
                'category_id' => $category->cat_ID,
                'category_name' => $category->name
            ];
        }

        return $categories;
    }

    protected function getDefaultCategory($categories)
    {
        if (!$defaultCategory = intval(get_option('default_category'))) {
            $defaultCategory = @$categories[0]['category_id'];
        }

        return $defaultCategory;
    }

    protected function getDefaultFeed($defaultCategory)
    {
        return [
            'feed_name' => '',
            'feed_status' => true,
            'post_status' => 'publish',
            'post_format' => 'standard',
            'comment_status' => 'open',
            'post_fields_mapping' => [
                ['post_field' => 'post_title', 'form_field' => ''],
                ['post_field' => 'post_content', 'form_field' => ''],
                ['post_field' => 'post_excerpt', 'form_field' => ''],
            ],
            'acf_mappings' => [
                [
                    'field_key' => '',
                    'field_value' => ''
                ]
            ],
            'advanced_acf_mappings' => [
                [
                    'field_key' => '',
                    'field_value' => ''
                ]
            ],
            'meta_fields_mapping' => [],
            'default_category' => $defaultCategory,
            'conditionals' => [
                'conditions' => [],
                'status' => false,
                'type' => 'all'
            ]
        ];
    }
}
