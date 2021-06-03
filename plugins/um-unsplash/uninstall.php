<?php
/**
* Uninstall UM Unsplash
*
*/

// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;


if ( ! defined( 'um_unsplash_path' ) ) {
	define( 'um_unsplash_path', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'um_unsplash_url' ) ) {
	define( 'um_unsplash_url', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'um_unsplash_plugin' ) ) {
	define( 'um_unsplash_plugin', plugin_basename( __FILE__ ) );
}

$options = get_option( 'um_options', array() );
if ( ! empty( $options['uninstall_on_delete'] ) ) {

	if ( ! class_exists( 'um_ext\um_unsplash\core\Unsplash_Setup' ) ) {
		require_once um_unsplash_path . 'includes/core/class-unsplash-setup.php';
	}

	$unsplash_setup = new um_ext\um_unsplash\core\Unsplash_Setup();

	//remove settings
	foreach ( $unsplash_setup->settings_defaults as $k => $v ) {
		unset( $options[ $k ] );
	}

	unset( $options['um_unsplash_license_key'] );

	update_option( 'um_options', $options );

	delete_option( 'um_unsplash_last_version_upgrade' );
	delete_option( 'um_unsplash_version' );
}