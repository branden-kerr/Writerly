<?php
/**
 * Helper functions for Beaver Builder
 *
 * @package 	um-theme
 * @subpackage 	Beaver Builder
 * @link      	https://wordpress.org/plugins/beaver-builder-lite-version/
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// If plugin - 'Beaver Themer' not exist then return.
if ( ! class_exists( 'FLThemeBuilderLoader' ) || ! class_exists( 'FLThemeBuilderLayoutData' ) ) {
	return;
}

// Registering Elementor Theme Location API locations.
add_action( 'after_setup_theme', 'um_theme_register_beaver_themer' );

// Registering Header & Footer Support.
add_action( 'wp', 'um_theme_beaver_builder_check_header_footer' );

// Registering UM Theme Hook Support.
add_filter( 'fl_theme_builder_part_hooks', 'um_theme_register_beaver_part_hooks' );


/**
 * Registering Beaver Builder Location API locations
 */
if ( ! function_exists( 'um_theme_register_beaver_themer' ) ) {
	function um_theme_register_beaver_themer() {
		add_theme_support( 'fl-theme-builder-headers' );
		add_theme_support( 'fl-theme-builder-footers' );
		add_theme_support( 'fl-theme-builder-parts' );
	}
}

/**
 * Registering Header & Footer Support.
 */
if ( ! function_exists( 'um_theme_beaver_builder_check_header_footer' ) ) {
	function um_theme_beaver_builder_check_header_footer() {

	  // Get the header ID.
	  $header_ids = FLThemeBuilderLayoutData::get_current_page_header_ids();

	  // Get the footer ID.
	  $footer_ids = FLThemeBuilderLayoutData::get_current_page_footer_ids();

	  // If we have a header, remove the theme header and hook in Theme Builder's.
	  if ( ! empty( $header_ids ) ) {
	    remove_action( 'um_theme_header', 'um_theme_header_custom_background' );
	    remove_action( 'um_theme_header', 'um_theme_core_header' );
	    add_action( 'um_theme_header', 'FLThemeBuilderLayoutRenderer::render_header' );
	  }

	  // If we have a footer, remove the theme footer and hook in Theme Builder's.
	  if ( ! empty( $footer_ids ) ) {
	    remove_action( 'um_theme_footer', 'um_theme_footer_widgets' );
	    remove_action( 'um_theme_footer', 'um_theme_footer_bottom_content' );
	    add_action( 'um_theme_footer', 'FLThemeBuilderLayoutRenderer::render_footer' );
	  }

	}
}

/**
 * Registering UM Theme Hook Support.
 */
if ( ! function_exists( 'um_theme_register_beaver_part_hooks' ) ) {
	function um_theme_register_beaver_part_hooks() {

	  return array(
	    array(
	      'label' => __( 'Archive Page', 'um-theme' ),
	      'hooks' => array(
	        'um_theme_content_archive_header' => __( 'Archive Header', 'um-theme' ),
	      ),
	    ),

	    array(
	      'label' => __( 'Comments', 'um-theme' ),
	      'hooks' => array(
	        'um_theme_before_comments' 		=> __( 'Before Comments', 'um-theme' ),
	        'um_theme_inside_comments' 		=> __( 'Inside Comments', 'um-theme' ),
	        'um_theme_below_comments_title' => __( 'Below Comment Title', 'um-theme' ),
	      ),
	    ),

	    array(
	      'label' => __( 'Page', 'um-theme' ),
	      'hooks' => array(
	        'um_theme_before_page_content' 	=> __( 'Before Page Content', 'um-theme' ),
	        'um_theme_after_page_content' 	=> __( 'After Page Content', 'um-theme' ),
	      ),
	    ),

	    array(
	      'label' => __( 'Articles', 'um-theme' ),
	      'hooks' => array(
	        'um_theme_single_post_top' 		=> __( 'Article Header', 'um-theme' ),
	        'um_theme_single_post' 			=> __( 'Article Content', 'um-theme' ),
	        'um_theme_single_post_bottom' 	=> __( 'Article Footer', 'um-theme' ),
	      ),
	    ),

	    array(
	      'label' => __( 'Loop', 'um-theme' ),
	      'hooks' => array(
	        'um_theme_loop_before' 	=> __( 'Before Loop', 'um-theme' ),
	        'um_theme_loop_after' 	=> __( 'After Loop', 'um-theme' ),
	      )
	    ),

	    array(
	      'label' => __( 'Profile Header', 'um-theme' ),
	      'hooks' => array(
	        'um_theme_header_profile_before' 	=> __( 'Before Profile Header', 'um-theme' ),
	        'um_theme_header_profile_after' 	=> __( 'After Profile Header', 'um-theme' ),
	      ),
	    ),

	  );

	}
}
