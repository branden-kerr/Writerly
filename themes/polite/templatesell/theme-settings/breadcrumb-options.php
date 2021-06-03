<?php 
/*Extra Options*/
$GLOBALS['polite_theme_options'] = polite_get_options_value();
$wp_customize->add_section( 'polite_extra_options', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Breadcrumb Settings', 'polite' ),
    'panel'          => 'polite_panel',
) );

/*Breadcrumb Enable*/
$wp_customize->add_setting( 'polite_options[polite-extra-breadcrumb]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['polite-extra-breadcrumb'],
    'sanitize_callback' => 'polite_sanitize_checkbox'
) );

$wp_customize->add_control( 'polite_options[polite-extra-breadcrumb]', array(
    'label'     => __( 'Enable Breadcrumb', 'polite' ),
    'description' => __( 'Breadcrumb will appear on all pages except home page. More settings will be on the premium version.', 'polite' ),
    'section'   => 'polite_extra_options',
    'settings'  => 'polite_options[polite-extra-breadcrumb]',
    'type'      => 'checkbox',
    'priority'  => 15,
) );

/*callback functions related posts*/
if (!function_exists('polite_breadcrumb_callback')) :
    function polite_breadcrumb_callback()
    {
        global $polite_theme_options;
        $breadcrumb = absint($polite_theme_options['polite-extra-breadcrumb']);
        if (1 == $breadcrumb) {
            return true;
        } else {
            return false;
        }
    }
endif;

/*Select Breadcrumb From*/
$wp_customize->add_setting('polite_options[polite-breadcrumb-selection-option]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-breadcrumb-selection-option'],
    'sanitize_callback' => 'polite_sanitize_select'
));

$wp_customize->add_control('polite_options[polite-breadcrumb-selection-option]', array(
    'choices' => array(
        'theme' => __('Theme Default', 'polite'),
        'yoast' => __('Yoast Plugin', 'polite'),
        'rankmath' => __('Rank Math Plugin', 'polite'),
        'navxt' => __('NavXT Plugin', 'polite'),
    ),
    'label' => __('Select Breadcrumb From', 'polite'),
    'description' => __('You need to install and activate the respected plugin to show their Breadcrumb. Otherwise, your default theme Breadcrumb will appear. If you see error in search console, then we recommend to use plugin Breadcrumb.', 'polite'),
    'section' => 'polite_extra_options',
    'settings' => 'polite_options[polite-breadcrumb-selection-option]',
    'type' => 'select',
    'priority' => 15,
    'active_callback'=>'polite_breadcrumb_callback',
));