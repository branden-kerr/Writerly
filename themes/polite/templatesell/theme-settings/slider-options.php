<?php
/*Slider Options*/
$GLOBALS['polite_theme_options'] = polite_get_options_value();

$wp_customize->add_section( 'polite_slider_section', array(
   'priority'       => 20,
   'capability'     => 'edit_theme_options',
   'theme_supports' => '',
   'title'          => __( 'Slider Settings', 'polite' ),
   'panel' 		 => 'polite_panel',
) );

/*callback functions slider*/
if ( !function_exists('polite_slider_active_callback') ) :
  function polite_slider_active_callback(){
      global $polite_theme_options;
      $enable_slider = absint($polite_theme_options['polite_enable_slider']);
      if( 1 == $enable_slider ){
          return true;
      }
      else{
          return false;
      }
  }
endif;

/*Slider Enable Option*/
$wp_customize->add_setting( 'polite_options[polite_enable_slider]', array(
   'capability'        => 'edit_theme_options',
   'transport' => 'refresh',
   'default'           => $default['polite_enable_slider'],
   'sanitize_callback' => 'polite_sanitize_checkbox'
) );

$wp_customize->add_control(
    'polite_options[polite_enable_slider]', 
    array(
       'label'     => __( 'Enable Slider', 'polite' ),
       'description' => __('You can select the category for the slider below. More Options are available on premium version.', 'polite'),
       'section'   => 'polite_slider_section',
       'settings'  => 'polite_options[polite_enable_slider]',
        'type'      => 'checkbox',
       'priority'  => 15,
   )
 );        

/*Slider Category Selection*/
$wp_customize->add_setting( 'polite_options[polite-select-category]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['polite-select-category'],
    'sanitize_callback' => 'absint'

) );

$wp_customize->add_control(
    new Polite_Customize_Category_Dropdown_Control(
        $wp_customize,
        'polite_options[polite-select-category]',
        array(
            'label'     => __( 'Select Category For Slider', 'polite' ),
            'description' => __('Choose one category to show the slider. More settings are in pro version.', 'polite'),
            'section'   => 'polite_slider_section',
            'settings'  => 'polite_options[polite-select-category]',
            'type'      => 'category_dropdown',
            'priority'  => 15,
            'active_callback'=> 'polite_slider_active_callback',
        )
    )

);