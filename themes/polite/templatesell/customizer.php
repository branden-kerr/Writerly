<?php
/**
 * Polite Theme Customizer
 *
 * @package Polite
 */

if ( !function_exists('polite_default_theme_options_values') ) :

    function polite_default_theme_options_values() {

        $default_theme_options = array(

          /*Logo Options*/
          'polite_logo_width_option' => '600',

            /*Top Header*/
            'polite_enable_top_header'=> 0, 
            'polite_enable_top_header_social'=> 0,
            'polite_enable_top_header_menu'=> 0,

            /*Header Image*/
            'polite_enable_header_image_overlay'=> 0,
            'polite_slider_overlay_color'=> '#000000',
            'polite_slider_overlay_transparent'=> '0.1',
            'polite_header_image_height'=> '100',

           /*Header Options*/
            'polite_enable_offcanvas'  => 0,
            'polite_enable_search'  => 0,

            /*Menu Options*/
            'polite_mobile_menu_text'  => esc_html__('Menu','polite'),
            'polite_mobile_menu_option'=> 'menu-text',

            /*Colors Options*/
            'polite_primary_color'              => '#d42929',

            /*Slider Options*/
            'polite_enable_slider'      => 1,
            'polite-select-category'    => 0,
    
            /*Boxes Section */
            'polite_enable_promo'       => 1,
            'polite-promo-select-category'=> 0,
            
            /*Blog Page*/
            'polite-sidebar-blog-page' => 'no-sidebar',
            'polite-column-blog-page'  => 'masonry-post',
            'polite-blog-image-layout' => 'full-image',
            'polite-content-show-from' => 'excerpt',
            'polite-excerpt-length'    => 25,
            'polite-pagination-options'=> 'ajax',
            'polite-blog-exclude-category'=> '',
            'polite-read-more-text'    => '',
            'polite-show-hide-share'   => 1,
            'polite-show-hide-category'=> 1,
            'polite-show-hide-date'=> 1,
            'polite-show-hide-author'=> 1,

            /*Single Page */
            'polite-single-page-featured-image' => 1,
            'polite-single-page-related-posts'  => 0,
            'polite-single-page-related-posts-title' => esc_html__('Related Posts','polite'),
            'polite-sidebar-single-page'=> 'single-right-sidebar',
            'polite-single-social-share' => 1,


            /*Sticky Sidebar*/
            'polite-enable-sticky-sidebar' => 0,

            /*Footer Section*/
            'polite-footer-copyright'  => esc_html__('Copyright All Rights Reserved 2021','polite'),

            /*Breadcrumb Options*/
            'polite-extra-breadcrumb' => 1,
            'polite-breadcrumb-selection-option'=> 'theme',

        );
return apply_filters( 'polite_default_theme_options_values', $default_theme_options );
}
endif;
/**
 *  Polite Theme Options and Settings
 *
 * @since Polite 1.0.0
 *
 * @param null
 * @return array polite_get_options_value
 *
 */
if ( !function_exists('polite_get_options_value') ) :
    function polite_get_options_value() {
        $polite_default_theme_options_values = polite_default_theme_options_values();
        $polite_get_options_value = get_theme_mod( 'polite_options');
        if( is_array( $polite_get_options_value )){
            return array_merge( $polite_default_theme_options_values, $polite_get_options_value );
        }
        else{
            return $polite_default_theme_options_values;
        }
    }
endif;

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function polite_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
    if ( isset( $wp_customize->selective_refresh ) ) {
      $wp_customize->selective_refresh->add_partial( 'blogname', array(
         'selector'        => '.site-title a',
         'render_callback' => 'polite_customize_partial_blogname',
     ) );
      $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
         'selector'        => '.site-description',
         'render_callback' => 'polite_customize_partial_blogdescription',
     ) );
  }
  $default = polite_default_theme_options_values();

  require get_template_directory() . '/templatesell/theme-settings/theme-settings.php';

}
add_action( 'customize_register', 'polite_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function polite_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function polite_customize_partial_blogdescription() {
	bloginfo( 'description' );
}
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function polite_customize_preview_js() {
	wp_enqueue_script( 'polite-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20200412', true );
}
add_action( 'customize_preview_init', 'polite_customize_preview_js' );

/*
** Customizer Styles
*/
function polite_panels_css() {
     wp_enqueue_style('polite-customizer-css', get_template_directory_uri() . '/css/customizer-style.css', array(), '4.5.0');
}
add_action( 'customize_controls_enqueue_scripts', 'polite_panels_css' );