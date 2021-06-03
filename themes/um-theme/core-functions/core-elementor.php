<?php
/**
 * Elementor Page Builder Support
 *
 * @package 	um-theme
 * @subpackage 	Elementor
 * @link      	https://wordpress.org/plugins/elementor/
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Register Theme Location API.
add_action( 'elementor/theme/register_locations', 'um_theme_register_elementor_locations' );

/*
 * Registering Elementor Theme Location API locations
 */
if ( ! function_exists( 'um_theme_register_elementor_locations' ) ) {
	function um_theme_register_elementor_locations( $elementor_theme_manager ) {
		$elementor_theme_manager->register_all_core_location();
	}
}


if ( ! function_exists( 'um_theme_check_elementor_hide_title' ) ) {
	/**
	 * Check hide title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function um_theme_check_elementor_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = \Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'um_theme_show_page_title', 'um_theme_check_elementor_hide_title' );



if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {

	//add_action( 'elementor/theme/register_locations', 'um_theme_register_extra_elementor_locations' );

	if ( ! function_exists( 'um_theme_register_extra_elementor_locations' ) ) {
		function um_theme_register_extra_elementor_locations( $elementor_theme_manager ) {
			$locations = [
				'um_theme_before_site'   				=> __( 'Before Site Content', 'um-theme' ),
				'um_theme_before_content' 				=> __( 'Before Content', 'um-theme' ),
				'um_theme_content_top'  				=> __( 'Content Start', 'um-theme' ),
				'um_theme_before_header' 				=> __( 'Before Header Content', 'um-theme' ),
				'um_theme_header_profile_before'        => __( 'Before Profile Header', 'um-theme' ),
				'um_theme_header_profile_after'         => __( 'After Profile Header', 'um-theme' ),
				'um_theme_before_header_profile_menu'   => __( 'Before Profile Header Menu', 'um-theme' ),
				'um_theme_after_header_profile_menu'    => __( 'After Profile Header Menu', 'um-theme' ),
				'um_theme_after_header'   				=> __( 'After Header Content', 'um-theme' ),
				'um_theme_loop_before'       			=> __( 'Before Loop', 'um-theme' ),
				'um_theme_loop_after'        			=> __( 'After Loop', 'um-theme' ),
				'um_theme_before_page_content'          => __( 'Before Page Content', 'um-theme' ),
				'um_theme_after_page_content'          	=> __( 'After Page Content', 'um-theme' ),
				'um_theme_before_comments'      		=> __( 'Before Comments', 'um-theme' ),
				'um_theme_before_comments_title'		=> __( 'Before Comments Title', 'um-theme' ),
				'um_theme_after_comments_title' 		=> __( 'After Comments Title', 'um-theme' ),
				'um_theme_after_comments'       		=> __( 'After Comments', 'um-theme' ),
				'um_theme_before_sidebar'  				=> __( 'Before Sidebar', 'um-theme' ),
				'um_theme_after_sidebar'   				=> __( 'After Sidebar', 'um-theme' ),
				'um_theme_before_footer_widgets'        => __( 'Before Footer Widgets', 'um-theme' ),
				'um_theme_after_footer_widgets'        	=> __( 'After Footer Widgets', 'um-theme' ),
				'um_theme_before_footer'  				=> __( 'Before Footer', 'um-theme' ),
				'um_theme_after_footer'   				=> __( 'After Footer', 'um-theme' ),
			];

			foreach ( $locations as $hook => $label ) {
				$elementor_theme_manager->register_location( $hook, [
					'label'    => $label,
					'hook'     => $hook,
				] );
			}
		}
	}
}