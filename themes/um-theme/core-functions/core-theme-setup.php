<?php
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 * @package um-theme
 */

/**
 * Setup helper functions of UM Theme.
 */
if ( ! function_exists( 'um_theme_setup' ) ) {
	function um_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on UM Theme, use a find and replace
		 * to change 'um-theme' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'um-theme' );

		/*
	     * Add default posts and comments RSS feed links to head.
	     */
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'um-theme-thumb', 820, 400, array( 'center', 'center' ) );
		set_post_thumbnail_size( 'um-theme-thumb', 820, 400 );

		/*
		 * Enable support responsive embedded content
		 * See: https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#responsive-embedded-content
		 */
		add_theme_support( 'responsive-embeds' );

		// Add support for default block styles.
		add_theme_support( 'wp-block-styles' );

		// Add theme support for Yoast SEO breadcrumbs
		add_theme_support( 'yoast-seo-breadcrumbs' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Adds support for editor color palette.
		add_theme_support( 'editor-color-palette', array(
		    array(
		        'name' 	=> __( 'sky blue', 'um-theme' ),
		        'slug' 	=> 'strong-magenta',
		        'color' => '#6596ff',
		    ),
		    array(
		        'name' 	=> __( 'light grayish magenta', 'um-theme' ),
		        'slug' 	=> 'light-grayish-magenta',
		        'color' => '#333333',
		    ),
		    array(
		        'name' 	=> __( 'very light gray', 'um-theme' ),
		        'slug' 	=> 'very-light-gray',
		        'color' => '#eeeeee',
		    ),
		    array(
		        'name' 	=> __( 'very dark gray', 'um-theme' ),
		        'slug' 	=> 'very-dark-gray',
		        'color' => '#444444',
		    ),
		) );

		/**
		 * Register custom Custom Navigation Menus.
		 * This theme uses wp_nav_menu() in the following locations.
		 *
		 * @link  https://developer.wordpress.org/reference/functions/register_nav_menus/
		 * @since 1.0.0
		 */
		register_nav_menus(
			/**
			 * Filter registered nav menus.
			 *
			 * @since 1.0.0
			 *
			 * @var array
			 */
			(array) apply_filters( 'um_theme_nav_menus',
				array(
					'header-top' 		=> esc_html__( 'Top Bar Menu', 'um-theme' ),
					'primary' 			=> esc_html__( 'Primary Menu', 'um-theme' ),
					'header-bottom' 	=> esc_html__( 'Bottom Bar Menu', 'um-theme' ),
					'profile-menu' 		=> esc_html__( 'User Header Menu', 'um-theme' ),
					'footer' 			=> esc_html__( 'Footer Menu', 'um-theme' ),
				)
			)
		);

		// Add theme support for Custom Logo.
		add_theme_support( 'custom-logo',
				array(
					'flex-width'  => true,
					'flex-height' => true,
				)
		 );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'navigation-widgets',
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		add_theme_support( 'widget-customizer' );

	    /*
	     * Enable support for Customizer Selective Refresh.
	     * See: https://make.wordpress.org/core/2016/02/16/selective-refresh-in-the-customizer/
	     */
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support( 'custom-background', (array) apply_filters( 'um_custom_background_args',
			array(
				'default-color' 	=> '#f6f9fc',
				'default-image' 	=> '',
				'default-repeat'	=> 'no-repeat',
			)
		) );

		// Set the default content width.
		$GLOBALS['content_width'] = (int) apply_filters( 'um_content_width', 640 );

		add_editor_style();

		// Declare SportsPress support.
		add_theme_support( 'sportspress' );
	}
}

/**
 * Enqueue scripts and styles.
 */
if ( ! function_exists( 'um_theme_scripts' ) ) {
	function um_theme_scripts() {

		// Register Style
		wp_register_style( 'umtheme-libraries', UM_THEME_URI . 'inc/css/libraries.min.css', array(), UM_THEME_VERSION, 'all' );
		wp_register_style( 'umtheme-stylesheet', get_stylesheet_uri(), array( 'umtheme-libraries' ), UM_THEME_VERSION , 'all' );
		wp_register_style( 'umtheme-fonts', um_theme_fonts_url(), array(), UM_THEME_VERSION, 'all' );

		// Enqueue Style
		wp_enqueue_style( 'umtheme-libraries' );
		wp_enqueue_style( 'umtheme-stylesheet' );
        wp_enqueue_style( 'umtheme-fonts' );

		// RTL Support
		if ( is_rtl() ) {
			wp_enqueue_style( 'umtheme-rtl-stylesheet', UM_THEME_URI . 'inc/css/rtl.css', array(), UM_THEME_VERSION );
		}

		// Enqueue bbPress stylesheet if active.
		if ( class_exists( 'bbPress' ) ) {
			wp_register_style( 'umtheme-bbpress', UM_THEME_URI . 'inc/css/um-theme-bbpress.css', array(), UM_THEME_VERSION, 'all' );
			wp_enqueue_style( 'umtheme-bbpress' );
		}

		// Load only if WooCommerce is active.
		if ( class_exists( 'WooCommerce' ) ) {
			wp_register_style( 'umtheme-woocommerce', UM_THEME_URI . 'inc/css/um-theme-woocommerce.css', array(), UM_THEME_VERSION, 'all' );
			wp_enqueue_style( 'umtheme-woocommerce' );
		}

        // Register Script
        wp_register_script( 'umtheme-js', UM_THEME_URI . 'inc/js/um-theme-app-min.js', array( 'jquery' ), UM_THEME_VERSION, false );
        wp_register_script( 'umtheme-html5', UM_THEME_URI . 'inc/js/html5.js', array(), '3.7.3' );

        // Enqueue Script
	  	wp_enqueue_script( 'umtheme-js' );
		wp_enqueue_script( 'umtheme-html5' );
		wp_script_add_data( 'umtheme-js', 'async', true );
		wp_script_add_data( 'umtheme-html5', 'conditional', 'lt IE 9' );

		// Enqueue Comments Script
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}