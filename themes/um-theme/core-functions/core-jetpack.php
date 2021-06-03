<?php
/**
 * Helper functions for Jetpack
 *
 * @package 	um-theme
 * @subpackage 	Jetpack
 * @link      	https://jetpack.com
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/responsive-videos/
 * See: https://jetpack.com/support/content-options/
 */

add_action( 'after_setup_theme', 'um_theme_jetpack_setup' );

function um_theme_jetpack_setup(){
	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Content Options to make small visual modifications.
	add_theme_support( 'jetpack-content-options', array(
	    'post-details'       => array(
	        'stylesheet'      => 'umtheme-stylesheet', // name of the theme's stylesheet.
	        'date'            => '.post-meta__time', // a CSS selector matching the elements that display the post date.
	        'categories'      => '.meta-category', // a CSS selector matching the elements that display the post categories.
	        'tags'            => '.meta-tag', // a CSS selector matching the elements that display the post tags.
	        'author'          => '.article-author-box', // a CSS selector matching the elements that display the post author.
	    ),
	    'featured-images'    => array(
	        'archive'         => true, // enable or not the featured image check for archive pages: true or false.
	        'archive-default' => true, // the default setting of the featured image on archive pages, if it's being displayed or not: true or false (only required if false).
	        'post'            => true, // enable or not the featured image check for single posts: true or false.
	        'post-default'    => true, // the default setting of the featured image on single posts, if it's being displayed or not: true or false (only required if false).
	        'page'            => true, // enable or not the featured image check for single pages: true or false.
	        'page-default'    => true, // the default setting of the featured image on single pages, if it's being displayed or not: true or false (only required if false).
	    ),
	) );
}