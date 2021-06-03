<?php
namespace um_ext\um_unsplash\core;


if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Class Unsplash_Enqueue
 * @package um_ext\um_unsplash\core
 */
class Unsplash_Enqueue {

	/**
	 * Unsplash_Enqueue constructor.
	 */
	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
	}




	/*
		Equeue plugin related scripts and styles
	*/
	function wp_enqueue_scripts() {
		wp_register_script( 'um-unsplash' , um_unsplash_url . 'assets/js/um-unsplash.js' , array( 'jquery', 'wp-util', 'wp-i18n' ) , um_unsplash_version , true );
		wp_set_script_translations( 'um-unsplash', 'um-unsplash' );

		$settings = [
			'number_of_photos'  => UM()->options()->get( 'unsplash_no_of_photos' ),
			'default_keyword'   => UM()->options()->get( 'unsplash_default_keyword' ),
			'proxy_url'         => UM()->Unsplash()->proxy_url,
			'license'           => UM()->options()->get( 'um_unsplash_license_key' ),
		];
		wp_localize_script('um-unsplash', 'um_unsplash_settings', $settings );


		wp_register_style( 'um-unsplash' , um_unsplash_url . 'assets/css/um-unsplash.css' , array(), um_unsplash_version );


		wp_enqueue_script( 'um-unsplash' );
		wp_enqueue_style( 'um-unsplash' );
	}
}
