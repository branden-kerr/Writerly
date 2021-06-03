<?php

namespace FluentFormPro\classes;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class ProSmartCodes
{
    public function register()
    {
        add_filter('fluentform_smartcode_group_render_images', array($this, 'parseImageLists'), 10, 2);
    }

    public function parseImageLists($property, $instance)
    {
        $propertyArray = explode('|', $property);
        $inputName = array_shift($propertyArray);
        $column = false;
        if(isset($propertyArray[0])) {
            $column = intval($propertyArray[0]);
        }

        if(!$column) {
            $column = 1;
        }

        $inputs = $instance::getInputs();

        $images = \FluentForm\Framework\Helpers\ArrayHelper::get($inputs, $inputName);

        if(!is_array($images)) {
            return '';
        }

        if(!$images) {
            return '';
        }

        $rows = array_chunk($images, $column);

        $html = '<table class="fs_rendered_images" border="0" style="border:0px solid transparent; border-collapse: collapse;">';
        foreach ($rows as $rowImages) {
            $html .= '<tr>';
            foreach ($rowImages as $image) {
                $parts = explode('.', $image);
                $extension = array_pop($parts);

                if(in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                    $html .= '<td><img src="'.$image.'" /></td>';
                } else {
                    $parts = explode('/', $image);
                    $extension = array_pop($parts);
                    $html .= '<td><a href="'.$image.'">'.$extension.'</a></td>';
                }
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        return $html;
    }
}