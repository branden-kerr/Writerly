<?php 
/*Logo Section*/
$wp_customize->add_setting( 'polite_options[polite_logo_width_option]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['polite_logo_width_option'],
    'sanitize_callback' => 'absint'
) );
$wp_customize->add_control( 'polite_options[polite_logo_width_option]', array(
   'label'     => __( 'Logo Width', 'polite' ),
   'description' => __('Adjust the logo width. Minimum is 100px and maximum is 600px.', 'polite'),
   'section'   => 'title_tagline',
   'settings'  => 'polite_options[polite_logo_width_option]',
   'type'      => 'range',
   'priority'  => 15,
   'input_attrs' => array(
          'min' => 100,
          'max' => 600,
        ),
) );