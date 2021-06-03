<?php

namespace FluentFormPro\Components\Post\Components;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Services\FormBuilder\Components\Text;

class NonHierarchicalTaxonomy extends Text
{
    public function compile($data, $form)
    {
        $data['attributes']['type'] = 'text';
        
        return parent::compile($data, $form);
    }
}