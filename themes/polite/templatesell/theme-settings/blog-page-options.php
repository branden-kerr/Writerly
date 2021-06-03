<?php
/*Blog Page Options*/
$wp_customize->add_section('polite_blog_page_section', array(
    'priority' => 20,
    'capability' => 'edit_theme_options',
    'theme_supports' => '',
    'title' => __('Blog Settings', 'polite'),
    'panel' => 'polite_panel',
));
/*Blog Page Sidebar Layout*/

$wp_customize->add_setting('polite_options[polite-sidebar-blog-page]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-sidebar-blog-page'],
    'sanitize_callback' => 'polite_sanitize_select'
));

$wp_customize->add_control( new Polite_Radio_Image_Control(
        $wp_customize,
    'polite_options[polite-sidebar-blog-page]', array(
    'choices' => polite_blog_sidebar_position_array(),
    'label' => __('Blog and Archive Sidebar', 'polite'),
    'description' => __('This sidebar will work blog and archive pages.', 'polite'),
    'section' => 'polite_blog_page_section',
    'settings' => 'polite_options[polite-sidebar-blog-page]',
    'type' => 'select',
    'priority' => 15,
)));


/*Blog Page column number*/
$wp_customize->add_setting('polite_options[polite-column-blog-page]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-column-blog-page'],
    'sanitize_callback' => 'polite_sanitize_select'
));

$wp_customize->add_control('polite_options[polite-column-blog-page]', array(
    'choices' => array(
        'one-column' => __('Single Layout', 'polite'),
        'masonry-post' => __('Masonry Layout', 'polite'),
    
    ),
    'label' => __('Blog Layout Options', 'polite'),
    'description' => __('Change your blog or archive page layout.', 'polite'),
    'section' => 'polite_blog_page_section',
    'settings' => 'polite_options[polite-column-blog-page]',
    'type' => 'select',
    'priority' => 15,
));


/*Image Layout Options For Blog Page*/
$wp_customize->add_setting('polite_options[polite-blog-image-layout]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-blog-image-layout'],
    'sanitize_callback' => 'polite_sanitize_select'
));

$wp_customize->add_control('polite_options[polite-blog-image-layout]', array(
    'choices' => array(
        'full-image' => __('Full Layout', 'polite'),
        'left-image' => __('Grid Layout', 'polite'),
    
    ),
    'label' => __('Blog Page Layout', 'polite'),
    'description' => __('This will work only on Full layout Option', 'polite'),
    'section' => 'polite_blog_page_section',
    'settings' => 'polite_options[polite-blog-image-layout]',
    'type' => 'select',
    'priority' => 15,
));

/*Blog Page Show content from*/
$wp_customize->add_setting('polite_options[polite-content-show-from]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-content-show-from'],
    'sanitize_callback' => 'polite_sanitize_select'
));

$wp_customize->add_control('polite_options[polite-content-show-from]', array(
    'choices' => array(
        'excerpt' => __('Show from Excerpt', 'polite'),
        'content' => __('Show from Content', 'polite'),
    ),
    'label' => __('Select Content Display From', 'polite'),
    'description' => __('You can enable excerpt from Screen Options inside post section of dashboard', 'polite'),
    'section' => 'polite_blog_page_section',
    'settings' => 'polite_options[polite-content-show-from]',
    'type' => 'select',
    'priority' => 15,
));


/*Blog Page excerpt length*/
$wp_customize->add_setting('polite_options[polite-excerpt-length]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-excerpt-length'],
    'sanitize_callback' => 'absint'

));

$wp_customize->add_control('polite_options[polite-excerpt-length]', array(
    'label' => __('Excerpt Length', 'polite'),
    'description' => __('Enter the number per Words to show the content in blog page.', 'polite'),
    'section' => 'polite_blog_page_section',
    'settings' => 'polite_options[polite-excerpt-length]',
    'type' => 'number',
    'priority' => 15,
));

/*Exclude Category in Blog Page*/
$wp_customize->add_setting('polite_options[polite-blog-exclude-category]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-blog-exclude-category'],
    'sanitize_callback' => 'sanitize_text_field'
));

$wp_customize->add_control('polite_options[polite-blog-exclude-category]', array(
    'label' => __('Exclude categories in Blog Listing', 'polite'),
    'description' => __('Enter categories ids with comma separated eg: 2,7,14,47.', 'polite'),
    'section' => 'polite_blog_page_section',
    'settings' => 'polite_options[polite-blog-exclude-category]',
    'type' => 'text',
    'priority' => 15,
));

/*Blog Page Pagination Options*/
$wp_customize->add_setting('polite_options[polite-pagination-options]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-pagination-options'],
    'sanitize_callback' => 'polite_sanitize_select'

));

$wp_customize->add_control('polite_options[polite-pagination-options]', array(
    'choices' => array(
        'numeric' => __('Numeric Pagination', 'polite'),
        'ajax' => __('Ajax Pagination', 'polite'),
    ),
    'label' => __('Pagination Types', 'polite'),
    'description' => __('Choose Required Pagination Type', 'polite'),
    'section' => 'polite_blog_page_section',
    'settings' => 'polite_options[polite-pagination-options]',
    'type' => 'select',
    'priority' => 15,
));

/*Blog Page read more text*/
$wp_customize->add_setting('polite_options[polite-read-more-text]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-read-more-text'],
    'sanitize_callback' => 'sanitize_text_field'
));

$wp_customize->add_control('polite_options[polite-read-more-text]', array(
    'label' => __('Read More Text', 'polite'),
    'description' => __('Read more text for blog and archive page.', 'polite'),
    'section' => 'polite_blog_page_section',
    'settings' => 'polite_options[polite-read-more-text]',
    'type' => 'text',
    'priority' => 15,
));


/*Social Share in blog page*/
$wp_customize->add_setting('polite_options[polite-show-hide-share]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-show-hide-share'],
    'sanitize_callback' => 'polite_sanitize_checkbox'
));

$wp_customize->add_control('polite_options[polite-show-hide-share]', array(
    'label' => __('Show Social Share', 'polite'),
    'description' => __('Options to Enable Social Share in blog and archive page.', 'polite'),
    'section' => 'polite_blog_page_section',
    'settings' => 'polite_options[polite-show-hide-share]',
    'type' => 'checkbox',
    'priority' => 15,
));

/*Category Show hide*/
$wp_customize->add_setting('polite_options[polite-show-hide-category]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-show-hide-category'],
    'sanitize_callback' => 'polite_sanitize_checkbox'
));

$wp_customize->add_control('polite_options[polite-show-hide-category]', array(
    'label' => __('Show Category', 'polite'),
    'description' => __('Option to hide the category on the blog page.', 'polite'),
    'section' => 'polite_blog_page_section',
    'settings' => 'polite_options[polite-show-hide-category]',
    'type' => 'checkbox',
    'priority' => 15,
));
/*Date Show hide*/
$wp_customize->add_setting('polite_options[polite-show-hide-date]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-show-hide-date'],
    'sanitize_callback' => 'polite_sanitize_checkbox'
));

$wp_customize->add_control('polite_options[polite-show-hide-date]', array(
    'label' => __('Show Date', 'polite'),
    'description' => __('Option to hide the date on the blog page.', 'polite'),
    'section' => 'polite_blog_page_section',
    'settings' => 'polite_options[polite-show-hide-date]',
    'type' => 'checkbox',
    'priority' => 15,
));
/*Author Show hide*/
$wp_customize->add_setting('polite_options[polite-show-hide-author]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['polite-show-hide-author'],
    'sanitize_callback' => 'polite_sanitize_checkbox'
));

$wp_customize->add_control('polite_options[polite-show-hide-author]', array(
    'label' => __('Show Author', 'polite'),
    'description' => __('Option to hide the author on the blog page.', 'polite'),
    'section' => 'polite_blog_page_section',
    'settings' => 'polite_options[polite-show-hide-author]',
    'type' => 'checkbox',
    'priority' => 15,
));

