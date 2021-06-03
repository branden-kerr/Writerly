<?php
namespace FluentFormPro\Components;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Services\FormBuilder\Components\BaseComponent;

class ShortCode extends BaseComponent
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

        $hasConditions = $this->hasConditions($data) ? 'has-conditions ' : '';
		
		$data['attributes']['class'] = trim(
			$this->getDefaultContainerClass()
			.' '. @$data['attributes']['class']
			.' '. $hasConditions
		);

		$atts = $this->buildAttributes(
			\FluentForm\Framework\Helpers\ArrayHelper::except($data['attributes'], 'name')
		);

		$html = "<div {$atts}>".do_shortcode($data['settings']['shortcode'])."</div>";
        echo apply_filters('fluenform_rendering_field_html_'.$elementName, $html, $data, $form);
    }
}