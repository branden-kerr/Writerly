<?php
/**
 * Helper functions for Polylang
 *
 * @package 	um-theme
 * @subpackage 	Polylang
 * @link      	https://wordpress.org/plugins/polylang/
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.4
 */


/**
 * Make the theme strings translatable for Polylang Multilingual Translation
 */
if ( ! function_exists( 'um_theme_make_translation' ) ) {
	function um_theme_make_translation( $id, $val = '' ) {

		if ( $val && $id ) {

			// Polylang Translation.
			if ( function_exists( 'pll__' ) ) {
				$val = pll__( $val );
			} else {
				$val = $val;
			}

			// Return the value.
			return $val;
		}
	}
}

/**
 * Register the theme strings for Polylang Multilingual Translation
 * @link https://wordpress.org/plugins/polylang/
 * @since 1.0.4
 */
if ( function_exists( 'pll_register_string' ) ) {

    function um_theme_polylang_register_string() {

    	global $defaults;

    	// Topbar First Column Text.
		if ( ! empty( $defaults['um_topbar_colum_first_text'] ) ) {
    		$topbar_first_column_text    	= esc_attr( $defaults['um_topbar_colum_first_text'] );
        	pll_register_string( 'um_topbar_colum_first_text', $topbar_first_column_text, 'um-theme', true );
		}

    	// Topbar Second Column Text.
		if ( ! empty( $defaults['um_topbar_colum_second_text'] ) ) {
    		$topbar_second_column_text    	= esc_attr( $defaults['um_topbar_colum_second_text'] );
    	    pll_register_string( 'um_topbar_colum_second_text', $topbar_second_column_text, 'um-theme', true );
		}

    	// Bottombar First Column Text.
		if ( ! empty( $defaults['um_bottompbar_colum_first_text'] ) ) {
			$bottombar_first_column_text   	= esc_attr( $defaults['um_bottompbar_colum_first_text'] );
        	pll_register_string( 'um_bottompbar_colum_first_text', $bottombar_first_column_text, 'um-theme', true );
		}

    	// Bottombar Second Column Text.
		if ( ! empty( $defaults['um_bottompbar_colum_second_text'] ) ) {
    		$bottombar_second_column_text   = esc_attr( $defaults['um_bottompbar_colum_second_text'] );
        	pll_register_string( 'um_bottompbar_colum_second_text', $bottombar_second_column_text, 'um-theme', true );
		}

    	// Header Logged Out Text.
		if ( ! empty( $defaults['header_logged_out_text'] ) ) {
			$header_logged_out_text   		= esc_attr( $defaults['header_logged_out_text'] );
        	pll_register_string( 'header_logged_out_text', $header_logged_out_text, 'um-theme', true );
		}

    	// Footer First Column Text.
		if ( ! empty( $defaults['um_footer_colum_first_text'] ) ) {
    		$footer_first_column_text   	= esc_attr( $defaults['um_footer_colum_first_text'] );
    		pll_register_string( 'um_footer_colum_first_text', $footer_first_column_text, 'um-theme', true );
		}

    	// Footer Second Column Text.
		if ( ! empty( $defaults['um_footer_colum_second_text'] ) ) {
    		$footer_second_column_text   	= esc_attr( $defaults['um_footer_colum_second_text'] );
        	pll_register_string( 'um_footer_colum_second_text', $footer_second_column_text, 'um-theme', true );
		}

    }

    add_action( 'after_setup_theme', 'um_theme_polylang_register_string' );
}
