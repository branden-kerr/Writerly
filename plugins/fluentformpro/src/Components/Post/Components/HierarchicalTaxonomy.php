<?php

namespace FluentFormPro\Components\Post\Components;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Services\FormBuilder\Components\Select;
use FluentForm\App\Services\FormBuilder\Components\Checkable;

class HierarchicalTaxonomy
{
    public function compile($data, $form)
    {
        $data = $this->populateOptions($data, $form);

        $fieldType = $data['settings']['field_type'];

        if ($fieldType != 'checkbox') {
            
            $data['attributes']['type'] = 'select';

            if ($fieldType == 'select_multiple') {
                $data['attributes']['multiple'] = true;
            }
            
            return (new Select)->compile($data, $form);
        } else {

            $data['attributes']['type'] = 'checkbox';

            return (new Checkable)->compile($data, $form);   
        }
    }

    protected function populateOptions($data, $form)
    {
        if (isset($data['taxonomy_settings'])) {

            if ($data['taxonomy_settings']['hierarchical']) {

                $termsArgs = apply_filters('fluentform_post_integrations_terms_args', [
                    'order' => 'ASC',
                    'hide_empty' => false,
                    'taxonomy' => $data['taxonomy_settings']['name']
                ], $data, $form);

                $terms = get_terms($termsArgs);

                $data['settings']['advanced_options'] = [];

                foreach ($terms as $term) {
                    if (empty($term->name)) {
                        continue;
                    }

                    $data['settings']['advanced_options'][] = [
                        'label' => $term->name,
                        'value' => $term->term_id
                    ];
                }
            }
        }

        return $data;
    }
}
