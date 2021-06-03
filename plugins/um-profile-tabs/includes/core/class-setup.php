<?php
namespace um_ext\um_profile_tabs\core;


if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Class Setup
 *
 * @package um_ext\um_profile_tabs\core
 */
class Setup {


	/**
	 * @var array
	 */
	var $settings_defaults;


	/**
	 * Setup constructor.
	 */
	function __construct() {
		//settings defaults
		$this->settings_defaults = [
			'custom_profiletab_increment' => 1,
		];
	}


	/**
	 *
	 */
	function set_default_settings() {
		$options = get_option( 'um_options', [] );

		foreach ( $this->settings_defaults as $key => $value ) {
			//set new options to default
			if ( ! isset( $options[ $key ] ) ) {
				$options[ $key ] = $value;
			}

		}

		update_option( 'um_options', $options );
	}


	/**
	 *
	 */
	function run_setup() {
		$this->set_default_settings();
	}
}