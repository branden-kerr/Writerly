<?php
/*Footer Options*/
$wp_customize->add_section('polite_footer_section', array(
    'priority' => 20,
    'capability' => 'edit_theme_options',
    'theme_supports' => '',
    'title' => __('Footer Settings', 'polite'),
    'panel' => 'polite_panel',
));


/*Copyright Setting*/
$wp_customize->add_setting('polite_options[polite-footer-copyright]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-footer-copyright'],
    'sanitize_callback' => 'sanitize_text_field'
));

$wp_customize->add_control('polite_options[polite-footer-copyright]', array(
    'label' => __('Copyright Text', 'polite'),
    'description' => __('Enter your own copyright text.', 'polite'),
    'section' => 'polite_footer_section',
    'settings' => 'polite_options[polite-footer-copyright]',
    'type' => 'text',
    'priority' => 15,
));
