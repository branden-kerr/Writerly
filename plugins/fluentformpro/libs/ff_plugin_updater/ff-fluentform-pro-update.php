<?php

defined( 'ABSPATH' ) or die( 'No script kittays please!' );

if ( !class_exists( 'FluentFormAddOnUpdater' ) ) {
    // load our custom updater
    require_once( dirname( __FILE__ ) . '/updater/FluentFormAddOnUpdater.php' );
}

if ( !class_exists( 'FluentFormAddOnChecker' ) ) {
	require_once( dirname( __FILE__ ) . '/updater/FluentFormAddOnChecker.php' );
}

// Kick off our EDD class
new FluentFormAddOnChecker( array(
	// The plugin file, if this array is defined in the plugin
	'plugin_file' => FLUENTFORMPRO_DIR_FILE,
	// The current version of the plugin.
	// Also need to change in readme.txt and plugin header.
	'version' => FLUENTFORMPRO_VERSION,
	// The main URL of your store for license verification
	'store_url' => 'https://wpmanageninja.com',
	// Your name
	'author' => 'WP Manage Ninja',
	// The URL to renew or purchase a license
	'purchase_url' => 'https://wpmanageninja.com/downloads/fluentform-pro-add-on/',
	// The URL of your contact page
	'contact_url' => 'https://wpmanageninja.com/contact',
	// This should match the download name exactly
	'item_id' => '542',
	// The option names to store the license key and activation status
	'license_key' => '_ff_fluentform_pro_license_key',
	'license_status' => '_ff_fluentform_pro_license_status',
	// Option group param for the settings api
	'option_group' => '_ff_fluentform_pro_license',
	// The plugin settings admin page slug
	'admin_page_slug' => 'fluent_forms_add_ons',
	// If using add_menu_page, this is the parent slug to add a submenu item underneath.
	'activate_url' => admin_url('admin.php?page=fluent_forms_add_ons&sub_page=fluentform-pro-add-on'),
	// The translatable title of the plugin
	'plugin_title' => __( 'WP Fluent Forms Pro Add On', 'fluentformpro' ),
	'menu_slug' => 'fluentform-pro-add-on',
	'menu_title' => __('Fluent Forms Pro License', 'fluentformpro'),
    'cache_time' => 168 * 60 * 60 // 7 days
));
