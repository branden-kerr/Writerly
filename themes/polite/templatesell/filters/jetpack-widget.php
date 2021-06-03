<?php
/**
 * Jetpack Top Posts widget Image size
 * @since Polite 1.0.0
 *
 * @param null
 * @return void
 */
function polite_custom_thumb_size($get_image_options)
{
    $get_image_options['avatar_size'] = 600;
    
    return $get_image_options;
}

add_filter('jetpack_top_posts_widget_image_options', 'polite_custom_thumb_size');