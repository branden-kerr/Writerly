<?php
/*Promo Section Options*/
$GLOBALS['polite_theme_options'] = polite_get_options_value();

$wp_customize->add_section( 'polite_promo_section', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Boxes Below Slider Settings', 'polite' ),
    'panel'          => 'polite_panel',
) );

/*callback functions slider*/
if ( !function_exists('polite_promo_active_callback') ) :
    function polite_promo_active_callback(){
        global $polite_theme_options;
        $enable_promo = absint($polite_theme_options['polite_enable_promo']);
        if( 1 == $enable_promo ){
            return true;
        }
        else{
            return false;
        }
    }
endif;

/*Boxes Enable Option*/
$wp_customize->add_setting( 'polite_options[polite_enable_promo]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['polite_enable_promo'],
    'sanitize_callback' => 'polite_sanitize_checkbox'
) );

$wp_customize->add_control( 'polite_options[polite_enable_promo]', array(
    'label'     => __( 'Enable Boxes', 'polite' ),
    'description' => __('Enable and select the category to show the boxes below slider.', 'polite'),
    'section'   => 'polite_promo_section',
    'settings'  => 'polite_options[polite_enable_promo]',
    'type'      => 'checkbox',
    'priority'  => 5,

) );

/*Promo Category Selection*/
$wp_customize->add_setting( 'polite_options[polite-promo-select-category]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['polite-promo-select-category'],
    'sanitize_callback' => 'absint'

) );

$wp_customize->add_control(
    new Polite_Customize_Category_Dropdown_Control(
        $wp_customize,
        'polite_options[polite-promo-select-category]',
        array(
            'label'     => __( 'Category For Boxes', 'polite' ),
            'description' => __('From the dropdown select the category for the boxes. Category having post will display in below boxes section.', 'polite'),
            'section'   => 'polite_promo_section',
            'settings'  => 'polite_options[polite-promo-select-category]',
            'type'      => 'category_dropdown',
            'priority'  => 5,
            'active_callback'=>'polite_promo_active_callback'
        )
    )
);