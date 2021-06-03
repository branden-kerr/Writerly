<?php
$GLOBALS['polite_theme_options'] = polite_get_options_value();

/*Header Options*/
$wp_customize->add_section('polite_header_section', array(
    'priority' => 20,
    'capability' => 'edit_theme_options',
    'theme_supports' => '',
    'title' => __('Header Settings', 'polite'),
    'panel' => 'polite_panel',
));


/*Header Search Enable Option*/
$wp_customize->add_setting( 'polite_options[polite_enable_search]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['polite_enable_search'],
    'sanitize_callback' => 'polite_sanitize_checkbox'
) );

$wp_customize->add_control( 'polite_options[polite_enable_search]', array(
    'label'     => __( 'Enable Search', 'polite' ),
    'description' => __('It will help to display the search in Menu.', 'polite'),
    'section'   => 'polite_header_section',
    'settings'  => 'polite_options[polite_enable_search]',
    'type'      => 'checkbox',
    'priority'  => 5,

) );


/*Header Offcanvas Enable Option*/
$wp_customize->add_setting( 'polite_options[polite_enable_offcanvas]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['polite_enable_offcanvas'],
    'sanitize_callback' => 'polite_sanitize_checkbox'
) );

$wp_customize->add_control( 'polite_options[polite_enable_offcanvas]', array(
    'label'     => __( 'Enable Offcanvas Sidebar', 'polite' ),
    'description' => __('It will help to display the Offcanvas sidebar in Menu.', 'polite'),
    'section'   => 'polite_header_section',
    'settings'  => 'polite_options[polite_enable_offcanvas]',
    'type'      => 'checkbox',
    'priority'  => 5,

) );


/*Mobile menu icon option*/
$wp_customize->add_setting('polite_options[polite_mobile_menu_option]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite_mobile_menu_option'],
    'sanitize_callback' => 'polite_sanitize_select'
));

$wp_customize->add_control('polite_options[polite_mobile_menu_option]', array(
    'choices' => array(
        'menu-text' => __('Menu Text in Mobile', 'polite'),
        'menu-icon' => __('Hamberger Menu in Mobile', 'polite'),
    ),
    'label' => __('Select the Mobile Menu Type', 'polite'),
    'description' => __('You can either select the text mode or hamberger menu in mobile layout.', 'polite'),
    'section' => 'polite_header_section',
    'settings' => 'polite_options[polite_mobile_menu_option]',
    'type' => 'select',
    'priority' => 15,
));

/*callback functions mobile menu type*/
if (!function_exists('polite_mobile_menu_type_callback')) :
    function polite_mobile_menu_type_callback()
    {
        global $polite_theme_options;
        $mobile_menu_type = esc_attr($polite_theme_options['polite_mobile_menu_option']);
        if ( 'menu-text' == $mobile_menu_type) {
            return true;
        } else {
            return false;
        }
    }
endif;

/*Mobile Menu Text*/
$wp_customize->add_setting( 'polite_options[polite_mobile_menu_text]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['polite_mobile_menu_text'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'polite_options[polite_mobile_menu_text]', array(
    'label'     => __( 'Enter the Mobile Menu Text', 'polite' ),
    'description' => __('In the Mobile view mode, you can see Menu text. Change this text from here. It will only available on the mobile view mode.', 'polite'),
    'section'   => 'polite_header_section',
    'settings'  => 'polite_options[polite_mobile_menu_text]',
    'type'      => 'text',
    'priority'  => 15,
    'active_callback' => 'polite_mobile_menu_type_callback',

) );