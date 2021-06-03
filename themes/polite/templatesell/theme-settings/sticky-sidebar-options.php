<?php 
/*Sticky Sidebar*/
$wp_customize->add_section( 'polite_sticky_sidebar', array(
   'priority'       => 20,
   'capability'     => 'edit_theme_options',
   'theme_supports' => '',
   'title'          => __( 'Sticky Sidebar Settings', 'polite' ),
   'panel' 		 => 'polite_panel',
) );

/*Sticky Sidebar Setting*/
$wp_customize->add_setting( 'polite_options[polite-enable-sticky-sidebar]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['polite-enable-sticky-sidebar'],
    'sanitize_callback' => 'polite_sanitize_checkbox'
) );

$wp_customize->add_control( 'polite_options[polite-enable-sticky-sidebar]', array(
    'label'     => __( 'Enable Sticky Sidebar', 'polite' ),
    'description' => __('Enable and Disable sticky sidebar from this section.', 'polite'),
    'section'   => 'polite_sticky_sidebar',
    'settings'  => 'polite_options[polite-enable-sticky-sidebar]',
    'type'      => 'checkbox',
    'priority'  => 15,
) );