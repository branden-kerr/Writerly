<?php
/* Theme Options Panel */
	    $wp_customize->add_panel( 'polite_panel', array(
	        'priority' => 30,
	        'capability' => 'edit_theme_options',
	        'title' => __( 'Polite Theme Options', 'polite' ),
) );

/* Customizer Options */
require get_template_directory() . '/templatesell/theme-settings/logo-options.php';
require get_template_directory() . '/templatesell/theme-settings/top-header-options.php';
require get_template_directory() . '/templatesell/theme-settings/header-options.php';
require get_template_directory() . '/templatesell/theme-settings/color-options.php';
require get_template_directory() . '/templatesell/theme-settings/slider-options.php';
require get_template_directory() . '/templatesell/theme-settings/boxes-options.php';
require get_template_directory() . '/templatesell/theme-settings/blog-page-options.php';
require get_template_directory() . '/templatesell/theme-settings/single-page-options.php';
require get_template_directory() . '/templatesell/theme-settings/sticky-sidebar-options.php';
require get_template_directory() . '/templatesell/theme-settings/footer-options.php';
require get_template_directory() . '/templatesell/theme-settings/breadcrumb-options.php';