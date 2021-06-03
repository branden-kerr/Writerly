<?php
/**
 * Add sidebar class in body
 *
 * @since Polite 1.0.0
 *
 */

add_filter('body_class', 'polite_body_class');
function polite_body_class($classes)
{
    $classes[] = 'at-sticky-sidebar';
    global $polite_theme_options;
    
    if (is_singular()) {
        $sidebar = $polite_theme_options['polite-sidebar-single-page'];
        if ($sidebar == 'single-no-sidebar') {
            $classes[] = 'single-no-sidebar';
        } elseif ($sidebar == 'single-left-sidebar') {
            $classes[] = 'single-left-sidebar';
        } elseif ($sidebar == 'single-middle-column') {
            $classes[] = 'single-middle-column';
        } else {
            $classes[] = 'single-right-sidebar';
        }
    }
    
    $sidebar = $polite_theme_options['polite-sidebar-blog-page'];
    if ($sidebar == 'no-sidebar') {
        $classes[] = 'no-sidebar';
    } elseif ($sidebar == 'left-sidebar') {
        $classes[] = 'left-sidebar';
    } elseif ($sidebar == 'middle-column') {
        $classes[] = 'middle-column';
    } else {
        $classes[] = 'right-sidebar';
    }
    return $classes;
}

/**
 * Add layout class in body
 *
 * @since Polite 1.0.0
 *
 */

add_filter('body_class', 'polite_layout_body_class');
function polite_layout_body_class($classes)
{
    global $polite_theme_options;
    $layout = $polite_theme_options['polite-column-blog-page'];
    if ($layout == 'masonry-post') {
        $classes[] = 'masonry-post';
    } else {
        $classes[] = 'one-column';
    }    
    return $classes;
}


/**
 * Filter to hide text Category from category page
 *
 * @since Polite 1.0.9
 *
 */
add_filter( 'get_the_archive_title', function ( $title ) {
    if( is_category() ) {
        $title = single_cat_title( '', false );
    }
    return $title;
});