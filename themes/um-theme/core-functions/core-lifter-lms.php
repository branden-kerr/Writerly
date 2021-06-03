<?php
/**
 * Theme Support for LifterLMS
 *
 * @package 	um-theme
 * @subpackage 	LifterLMS
 * @link      	https://wordpress.org/plugins/lifterlms/
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

add_filter( 'llms_get_theme_default_sidebar', 'um_theme_llms_sidebar_function' );
add_action( 'after_setup_theme', 'um_theme_llms_theme_support' );
add_action( 'lifterlms_before_loop', 'um_theme_lifterlms_open_container', 5 );
add_action( 'lifterlms_after_loop', 'um_theme_lifterlms_close_container', 15 );


/**
 * Display LifterLMS Course and Lesson sidebars
 * on courses and lessons in place of the sidebar returned by
 * this function
 * @param    string     $id    default sidebar id (an empty string)
 * @return   string
 */
if ( ! function_exists( 'um_theme_llms_sidebar_function' ) ) {
	function um_theme_llms_sidebar_function( $id ) {
		$my_sidebar_id = 'sidebar-page';
		return $my_sidebar_id;
	}
}

/**
 * Declare explicit theme support for LifterLMS course and lesson sidebars
 * @return   void
 */
if ( ! function_exists( 'um_theme_llms_theme_support' ) ) {
	function um_theme_llms_theme_support() {
		add_theme_support( 'lifterlms' );
		add_theme_support( 'lifterlms-quizzes' );
		add_theme_support( 'lifterlms-sidebars' );
	}
}

/**
 * Opening wrapper for LifterLMS pages.
 */
if ( ! function_exists( 'um_theme_lifterlms_open_container' ) ) {
	function um_theme_lifterlms_open_container() {
		echo '<div class="website-canvas">';
	}
}

/**
 * Closing wrapper for LifterLMS pages.
 */
if ( ! function_exists( 'um_theme_lifterlms_close_container' ) ) {
	function um_theme_lifterlms_close_container() {
		echo '</div>';
	}
}

/**
 * Remove collapse js since it's conflict with Bootstrap framework.
 */
add_action( 'wp_enqueue_scripts', 'um_theme_remove_collapse_js', 100 );

if ( ! function_exists( 'um_theme_remove_collapse_js' ) ) {
    function um_theme_remove_collapse_js() {
       wp_dequeue_script( 'collapse' );
    }
}