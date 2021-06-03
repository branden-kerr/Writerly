<?php
/**
 * UM Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package um-theme
 * @author  Ultimate Member
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Theme Constants
 */
if ( ! defined( 'UM_THEME_VERSION' ) ) {
	define( 'UM_THEME_VERSION', '1.28' );
}

if ( ! defined( 'UM_THEME_DIR' ) ) {
	define( 'UM_THEME_DIR', get_parent_theme_file_path() . '/' );
}

if ( ! defined( 'UM_THEME_URI' ) ) {
	define( 'UM_THEME_URI', get_parent_theme_file_uri() . '/' );
}

/**
 * Core Setup
 *
 * @since 1.00
 */
require_once UM_THEME_DIR . 'core-functions/core-theme-setup.php';

/**
 * Multilingual Support
 *
 * @since 1.0.4
 */
require_once UM_THEME_DIR . 'core-functions/core-multilingual.php';

/**
 * Load Customizer Settings & Defaults
 *
 * @since 0.50
 */
require_once UM_THEME_DIR . 'inc/customizer.php';
require_once UM_THEME_DIR . 'core-functions/core-default.php';
require_once UM_THEME_DIR . 'core-functions/core-customizer-utility.php';
require_once UM_THEME_DIR . 'core-functions/core-customizer-css.php';
require_once UM_THEME_DIR . 'core-functions/core-widgets.php';
/**
 * Load Hooks
 *
 * @since 0.50
 */
require_once UM_THEME_DIR . 'core-functions/core-hook.php';

/**
 * Load Helper Fuctions
 *
 * @since 0.50
 */
require_once UM_THEME_DIR . 'core-functions/core-helpers.php';

/**
 * Load custom Menu Walker
 *
 * @since 0.50
 */
require_once UM_THEME_DIR . 'core-functions/core-menu-walker.php';

/**
 * Load Sidebar Components
 *
 * @since 0.50
 */
require_once UM_THEME_DIR . 'core-functions/core-sidebar.php';

/**
 * Load Header Components
 *
 * @since 0.50
 */
require_once UM_THEME_DIR . 'core-functions/core-header.php';
require_once UM_THEME_DIR . 'inc/custom-header.php';

/**
 * Load Comment Components
 *
 * @since 0.50
 */
require_once UM_THEME_DIR . 'core-functions/core-comment.php';

/**
 * Load WooCommerce compatibility file.
 * https://wordpress.org/plugins/woocommerce/
 * @since 0.50
 */

if ( class_exists( 'WooCommerce' ) ) {
	require_once UM_THEME_DIR . 'core-functions/core-woocommerce.php';
}

/**
 * Load Dokan Multivendor compatibility file.
 * https://wordpress.org/plugins/dokan-lite/
 * @since 1.13
 */

if ( class_exists( 'WeDevs_Dokan' ) ) {
	require_once UM_THEME_DIR . 'core-functions/core-dokan.php';
}

/**
 * Load Ultimate Member compatibility file.
 * https://wordpress.org/plugins/ultimate-member/
 * @since 0.50
 */

if ( class_exists( 'UM' ) ) {
	require_once UM_THEME_DIR . 'core-functions/core-ultimate-member.php';
}

/**
 * Load bbPress compatibility file.
 * https://wordpress.org/plugins/bbpress/
 * @since 0.50
 */

if ( class_exists( 'bbPress' ) ) {
	require_once UM_THEME_DIR . 'core-functions/core-bbpress.php';
}

/**
 * Load Elementor Page Builder compatibility file.
 * https://wordpress.org/plugins/elementor/
 * @since 0.50
 */
// Elementor Compatibility requires PHP 5.4 for namespaces.
if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
	if ( did_action( 'elementor/loaded' ) ) {
		require_once UM_THEME_DIR . 'core-functions/core-elementor.php';
	}
}

/**
 * Load Beaver Builder Themer compatibility file.
 * https://wordpress.org/plugins/beaver-builder-lite-version/
 * @since 0.50
 */
// Beaver Themer compatibility requires PHP 5.3.
if ( version_compare( PHP_VERSION, '5.3', '>=' ) ) {
	if ( ! class_exists( 'FLThemeBuilderLoader' ) || ! class_exists( 'FLThemeBuilderLayoutData' ) ) {
		require_once UM_THEME_DIR . 'core-functions/core-beaver-themer.php';
	}
}

/**
 * Load LifterLMS compatibility file.
 * https://wordpress.org/plugins/lifterlms/
 * @since 0.50
 */
if ( class_exists( 'LifterLMS' ) ) {
	require_once UM_THEME_DIR . 'core-functions/core-lifter-lms.php';
}

/**
 * Remote theme update.
 *
 * @since 0.50
 */
if ( ! function_exists( 'um_theme_update_theme_license' ) ) {
	function um_theme_update_theme_license() {
		if ( ! class_exists( 'EDD_Theme_Updater' ) ) {
			require_once UM_THEME_DIR . 'updater/theme-updater.php';
		}
	}
}

/**
 * Load WP Job Manager Compatibility
 * https://wordpress.org/plugins/wp-job-manager/
 * @since 1.12
 */
if ( class_exists( 'WP_Job_Manager' ) ) {
	require_once UM_THEME_DIR . 'core-functions/core-job-manager.php';
}

/**
 * Support for Jetpack
 * https://wordpress.org/plugins/jetpack/
 * @since 1.23
 */
if ( class_exists( 'Jetpack' ) ) {
	require_once UM_THEME_DIR . 'core-functions/core-jetpack.php';
}

/**
 * Support for Google Tag Manager for WordPress
 * https://wordpress.org/plugins/duracelltomi-google-tag-manager/
 * Check if the gtm function really exists and if so output the gtm tag.
 * @since 1.23
 */
add_action( 'um_theme_before_site', 'um_theme_inject_gtm_tag' );

if ( ! function_exists( 'um_theme_inject_gtm_tag' ) ) {
	function um_theme_inject_gtm_tag() {
		if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) {
			gtm4wp_the_gtm_tag();
		}
	}
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://wordpress.org/plugins/code-snippets/
 */