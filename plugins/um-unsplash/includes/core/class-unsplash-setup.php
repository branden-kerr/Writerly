<?php
namespace um_ext\um_unsplash\core;


if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Class Unsplash_Setup
 *
 * @package um_ext\um_unsplash\core
 */
class Unsplash_Setup {


	/**
	 * @var array
	 */
	var $settings_defaults;


	/**
	 * Unsplash_Setup constructor.
	 */
	function __construct() {
		//settings defaults
		$this->settings_defaults = array(
			'unsplash_no_of_photos'     => '30',
			'unsplash_default_keyword'  => 'light',
		);

	}


	/**
	 * Set default settings function
	 */
	function set_default_settings() {
		$options = get_option( 'um_options', array() );

		foreach ( $this->settings_defaults as $key => $value ) {
			//set new options to default
			if ( ! isset( $options[ $key ] ) ) {
				$options[ $key ] = $value;
			}
		}

		update_option( 'um_options', $options );
	}


	/**
	 * Run User Bookmark Setup
	 */
	function run_setup() {
		$this->set_default_settings();
	}
}
