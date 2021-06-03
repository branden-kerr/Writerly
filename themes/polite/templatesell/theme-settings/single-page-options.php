<?php
$GLOBALS['polite_theme_options'] = polite_get_options_value();

/*Single Page Options*/
$wp_customize->add_section('polite_single_page_section', array(
    'priority' => 20,
    'capability' => 'edit_theme_options',
    'theme_supports' => '',
    'title' => __('Single Page Settings', 'polite'),
    'panel' => 'polite_panel',
));

/*Featured Image Option*/
$wp_customize->add_setting('polite_options[polite-single-page-featured-image]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-single-page-featured-image'],
    'sanitize_callback' => 'polite_sanitize_checkbox'
));

$wp_customize->add_control('polite_options[polite-single-page-featured-image]', array(
    'label' => __('Enable Featured Image on Single Posts', 'polite'),
    'description' => __('You can hide images on single post from here.', 'polite'),
    'section' => 'polite_single_page_section',
    'settings' => 'polite_options[polite-single-page-featured-image]',
    'type' => 'checkbox',
    'priority' => 15,
));

/*Single Page Sidebar Layout*/
$wp_customize->add_setting('polite_options[polite-sidebar-single-page]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-sidebar-single-page'],
    'sanitize_callback' => 'polite_sanitize_select'
));

$wp_customize->add_control( 
    new Polite_Radio_Image_Control(
        $wp_customize,
    'polite_options[polite-sidebar-single-page]', array(
    'choices' => polite_sidebar_position_array(),
    'label' => __('Select Sidebar', 'polite'),
    'description' => __('From Appearance > Customize > Widgets and add the widgets on the respected widget areas.', 'polite'),
    'section' => 'polite_single_page_section',
    'settings' => 'polite_options[polite-sidebar-single-page]',
    'type' => 'select',
    'priority' => 15,
)));

/*Related Post Options*/
$wp_customize->add_setting('polite_options[polite-single-page-related-posts]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-single-page-related-posts'],
    'sanitize_callback' => 'polite_sanitize_checkbox'
));

$wp_customize->add_control('polite_options[polite-single-page-related-posts]', array(
    'label' => __('Related Posts', 'polite'),
    'description' => __('2 posts of same category will appear.', 'polite'),
    'section' => 'polite_single_page_section',
    'settings' => 'polite_options[polite-single-page-related-posts]',
    'type' => 'checkbox',
    'priority' => 15,
));


/*callback functions related posts*/
if (!function_exists('polite_related_post_callback')) :
    function polite_related_post_callback()
    {
        global $polite_theme_options;
        $related_posts = absint($polite_theme_options['polite-single-page-related-posts']);
        if (1 == $related_posts) {
            return true;
        } else {
            return false;
        }
    }
endif;

/*Related Post Title*/
$wp_customize->add_setting('polite_options[polite-single-page-related-posts-title]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-single-page-related-posts-title'],
    'sanitize_callback' => 'sanitize_text_field'
));

$wp_customize->add_control('polite_options[polite-single-page-related-posts-title]', array(
    'label' => __('Related Posts Title', 'polite'),
    'description' => __('Enter the suitable title.', 'polite'),
    'section' => 'polite_single_page_section',
    'settings' => 'polite_options[polite-single-page-related-posts-title]',
    'type' => 'text',
    'priority' => 15,
    'active_callback' => 'polite_related_post_callback'
));

/*Social Share Options*/
$wp_customize->add_setting('polite_options[polite-single-social-share]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-single-social-share'],
    'sanitize_callback' => 'polite_sanitize_checkbox'
));

$wp_customize->add_control('polite_options[polite-single-social-share]', array(
    'label' => __('Social Sharing', 'polite'),
    'description' => __('Enable Social Sharing on Single Posts.', 'polite'),
    'section' => 'polite_single_page_section',
    'settings' => 'polite_options[polite-single-social-share]',
    'type' => 'checkbox',
    'priority' => 15,
));
