<?php
/*
Plugin Name: Ultimate Member - Unsplash
Plugin URI: http://ultimatemember.com/
Description: Let users choose cover photo from Unsplash
Version: 2.0.5
Author: Ultimate Member
Author URI: http://ultimatemember.com/
Text Domain: um-unsplash
Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) exit;

require_once( ABSPATH.'wp-admin/includes/plugin.php' );

$plugin_data = get_plugin_data( __FILE__ );

define( 'um_unsplash_url' , plugin_dir_url( __FILE__ ) );
define( 'um_unsplash_path' , plugin_dir_path( __FILE__ ));
define( 'um_unsplash_plugin' , plugin_basename( __FILE__ ) );
define( 'um_unsplash_extension' , $plugin_data['Name'] );
define( 'um_unsplash_version' , $plugin_data['Version'] );
define( 'um_unsplash_textdomain' , 'um-unsplash' );
define( 'um_unsplash_requires' , '2.0.54' );


function um_unsplash_plugins_loaded() {
	$locale = ( get_locale() != '' ) ? get_locale() : 'en_US';
	load_textdomain( um_unsplash_textdomain, WP_LANG_DIR . '/plugins/' . um_unsplash_textdomain . '-' . $locale . '.mo' );
	load_plugin_textdomain( um_unsplash_textdomain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'um_unsplash_plugins_loaded', 0 );


add_action( 'plugins_loaded', 'um_unsplash_check_dependencies', -20 );

if ( ! function_exists( 'um_unsplash_check_dependencies' ) ) {

	function um_unsplash_check_dependencies() {
		if ( ! defined( 'um_path' ) || ! file_exists( um_path  . 'includes/class-dependencies.php' ) ) {
			//UM is not installed
			function um_unsplash_dependencies() {
				echo '<div class="error"><p>' . sprintf( __( 'The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>', 'um-unsplash' ), um_unsplash_extension ) . '</p></div>';
			}

			add_action( 'admin_notices', 'um_unsplash_dependencies' );
		} else {

			if ( ! function_exists( 'UM' ) ) {
				require_once um_path . 'includes/class-dependencies.php';
				$is_um_active = um\is_um_active();
			} else {
				$is_um_active = UM()->dependencies()->ultimatemember_active_check();
			}

			if ( ! $is_um_active ) {
				//UM is not active
				function um_unsplash_dependencies() {
					echo '<div class="error"><p>' . sprintf( __( 'The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>', 'um-unsplash' ), um_unsplash_extension ) . '</p></div>';
				}

				add_action( 'admin_notices', 'um_unsplash_dependencies' );

			} elseif ( true !== UM()->dependencies()->compare_versions( um_unsplash_requires, um_unsplash_version, 'unsplash', um_unsplash_extension ) ) {
				//UM old version is active
				function um_unsplash_dependencies() {
					echo '<div class="error"><p>' . UM()->dependencies()->compare_versions( um_unsplash_requires, um_unsplash_version, 'unsplash', um_unsplash_extension ) . '</p></div>';
				}

				add_action( 'admin_notices', 'um_unsplash_dependencies' );

			} else {

				$license = UM()->options()->get( 'um_unsplash_license_key' );
				if ( empty( $license ) ) {
					//UM old version is active
					function um_unsplash_dependencies() {
						echo '<div class="error"><p>' . sprintf( __( 'The <strong>%s</strong> extension requires the license key to work properly.', 'um-unsplash' ), um_unsplash_extension ) . '</p></div>';
					}

					add_action( 'admin_notices', 'um_unsplash_dependencies' );
				}

				require_once um_unsplash_path . 'includes/core/um-unsplash-functions.php';
				require_once um_unsplash_path . 'includes/core/um-unsplash-init.php';

			}
		}
	}
}


register_activation_hook( um_unsplash_plugin, 'um_unsplash_activation_hook' );
if ( ! function_exists( 'um_unsplash_activation_hook' ) ) {
	function um_unsplash_activation_hook() {
		//first install
		$version = get_option( 'um_unsplash_version' );

		if ( ! $version ) {
			update_option( 'um_unsplash_last_version_upgrade', um_unsplash_version );
		}

		if ( $version != um_unsplash_version ) {
			update_option( 'um_unsplash_version', um_unsplash_version );
		}

		//run setup
		if ( ! class_exists( 'um_ext\um_unsplash\core\Unsplash_Setup' ) ) {
			require_once um_unsplash_path . 'includes/core/class-unsplash-setup.php';
		}

		$user_unsplash_setup = new um_ext\um_unsplash\core\Unsplash_Setup();
		$user_unsplash_setup->run_setup();
	}
}
