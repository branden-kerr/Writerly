<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Software Licensing for UM Theme
 */

// Includes the files needed for the theme updater
if ( ! class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' 	=> 'http://www.ultimatemember.com/', 	// Site where EDD is hosted
		'item_name' 		=> 'Theme', 							// Name of theme
		'theme_slug' 		=> 'um-theme', 							// Theme slug
		'version' 			=> '1.28', 								// The current version of this theme
		'author' 			=> 'Ultimate Member', 					// The author of this theme
		'download_id' 		=> '', 									// Optional, used for generating a license renewal link
		'renew_url' 		=> '', 									// Optional, allows for a custom license renewal link
    	'beta'           	=> false, 								// Optional, set to true to opt into beta versions
	),
	// Strings
	$strings = array(
		'theme-license'             => __( 'Theme License', 'um-theme' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'um-theme' ),
		'license-key'               => __( 'License Key', 'um-theme' ),
		'license-action'            => __( 'License Action', 'um-theme' ),
		'deactivate-license'        => __( 'Deactivate License', 'um-theme' ),
		'activate-license'          => __( 'Activate License', 'um-theme' ),
		'status-unknown'            => __( 'License status is unknown.', 'um-theme' ),
		'renew'                     => __( 'Renew?', 'um-theme' ),
		'unlimited'                 => __( 'unlimited', 'um-theme' ),
		'license-key-is-active'     => __( 'License key is active.', 'um-theme' ),
		'expires%s'                 => __( 'Expires %s.', 'um-theme' ),
		'expires-never'             => __( 'Lifetime License.', 'um-theme' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'um-theme' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'um-theme' ),
		'license-key-expired'       => __( 'License key has expired.', 'um-theme' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'um-theme' ),
		'license-is-inactive'       => __( 'License is inactive.', 'um-theme' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'um-theme' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'um-theme' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'um-theme' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'um-theme' ),
		'update-available'          => __( '<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'um-theme' ),
	)
);