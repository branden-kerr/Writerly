<?php

namespace FluentFormPro\Components;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Helpers\Helper;
use FluentForm\App\Services\FormBuilder\Components\BaseComponent;
use FluentForm\Framework\Helpers\ArrayHelper;

class Uploader extends BaseComponent
{
	/**
	 * Compile and echo the html element
	 * @param  array $data [element data]
	 * @param  stdClass $form [Form Object]
	 * @return viod
	 */
	public function compile($data, $form)
	{
        $elementName = $data['element'];
        $data = apply_filters('fluenform_rendering_field_data_'.$elementName, $data, $form);

        $data['attributes']['class'] = @trim('ff-el-form-control '. $data['attributes']['class'].' ff-screen-reader-element');
        $data['attributes']['id'] = $this->makeElementId($data, $form).'_'.Helper::$formInstance;
        $data['attributes']['multiple'] = true;

        if($tabIndex = \FluentForm\App\Helpers\Helper::getNextTabIndex()) {
            $data['attributes']['tabindex'] = $tabIndex;
        }
        
        $btnText = ArrayHelper::get($data, 'settings.btn_text');
        if(!$btnText) {
            $btnText = __('Choose File', 'fluentformpro');
        }

        $elMarkup = "<label for='".$data['attributes']['id']."' class='ff_file_upload_holder'><span class='ff_upload_btn ff-btn'>".$btnText."</span> <input %s></label>";

        $elMarkup = sprintf($elMarkup, $this->buildAttributes($data['attributes'], $form));

		$html = $this->buildElementMarkup($elMarkup, $data, $form);

        echo apply_filters('fluenform_rendering_field_html_'.$elementName, $html, $data, $form);
        $this->enqueueProScripts();
    }

	/**
     * Enqueue required scripts
     * @return void
     */
    public function enqueueProScripts()
    {
        wp_enqueue_script('fluentform-uploader-jquery-ui-widget');
        wp_enqueue_script('fluentform-uploader-iframe-transport');
        wp_enqueue_script('fluentform-uploader');
    }
}