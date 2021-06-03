<?php
/**
 * Dynamic css
 *
 * @since Polite 1.0.0
 *
 * @param null
 * @return null
 *
 */
if (!function_exists('polite_dynamic_css')) :

    function polite_dynamic_css()
    {
        global $polite_theme_options;

        /* Color Options Options */
        $polite_primary_color              = esc_attr($polite_theme_options['polite_primary_color']);
        $polite_logo_width              = absint($polite_theme_options['polite_logo_width_option']);
        
        $polite_header_overlay  = esc_attr($polite_theme_options['polite_slider_overlay_color']);
        $polite_header_transparent  = esc_attr($polite_theme_options['polite_slider_overlay_transparent']);
        $polite_header_min_height              = absint($polite_theme_options['polite_header_image_height']);

        $custom_css = '';

        //Primary  Background 
        if (!empty($polite_primary_color)) {
            $custom_css .= "
            #toTop,
            a.effect:before,
            .show-more,
            a.link-format,
            .comment-form #submit:hover, 
            .comment-form #submit:focus,
            .meta_bottom .post-share a:hover,
            .tabs-nav li:before,
            .post-slider-section .s-cat,
            .sidebar-3 .widget-title:after,
            .bottom-caption .slick-current .slider-items span,
            aarticle.format-status .post-content .post-format::after,
            article.format-chat .post-content .post-format::after, 
            article.format-link .post-content .post-format::after,
            article.format-standard .post-content .post-format::after, 
            article.format-image .post-content .post-format::after, 
            article.hentry.sticky .post-content .post-format::after, 
            article.format-video .post-content .post-format::after, 
            article.format-gallery .post-content .post-format::after, 
            article.format-audio .post-content .post-format::after, 
            article.format-quote .post-content .post-format::after{ 
                background-color: ". $polite_primary_color."; 
                border-color: ".$polite_primary_color.";
            }";

        }
        //Primary Color
        if (!empty($polite_primary_color)) {
            $custom_css .= "
            #author:active, 
            #email:active, 
            #url:active, 
            #comment:active, 
            #author:focus, 
            #email:focus, 
            #url:focus, 
            #comment:focus,
            #author:hover, 
            #email:hover, 
            #url:hover, 
            #comment:hover{
                border-color:".$polite_primary_color.";
            }";
         }
        //Primary Color
        if (!empty($polite_primary_color)) {
            $custom_css .= "
            .post-cats > span i, 
            .post-cats > span a,
            .slide-wrap .caption .s-cat,
            .slide-wrap .caption span a:hover,
            .comment-form .logged-in-as a:last-child:hover, 
            .comment-form .logged-in-as a:last-child:focus,
            .main-header a:hover, 
            .main-header a:focus, 
            .main-header a:active,
            .top-menu > ul > li > a:hover,
            .main-menu ul li.current-menu-item > a, 
            .header-2 .main-menu > ul > li.current-menu-item > a,
            .main-menu ul li:hover > a,
            .post-navigation .nav-links a:hover, 
            .post-navigation .nav-links a:focus,
            .tabs-nav li.tab-active a, 
            .tabs-nav li.tab-active,
            .tabs-nav li.tab-active a, 
            .tabs-nav li.tab-active,
            ul.trail-items li a:hover span,
            .author-socials a:hover,
            .post-date a:focus, 
            .post-date a:hover,
            .post-excerpt a:hover, 
            .post-excerpt a:focus, 
            .content a:hover, 
            .content a:focus,
            .post-footer > span a:hover, 
            .post-footer > span a:focus,
            .widget a:hover, 
            .widget a:focus,
            .footer-menu li a:hover, 
            .footer-menu li a:focus,
            .footer-social-links a:hover,
            .footer-social-links a:focus,
            .site-footer a:hover, 
            .site-footer a:focus, .content-area p a{ 
                color : ". $polite_primary_color."; 
            }";
        }

        //Logo Width
        if (!empty($polite_logo_width)) {
            $custom_css .= "
            .header-1 .head_one .logo{ 
                max-width : ". $polite_logo_width."px; 
            }";
        }

        //Header Overlay
        if (!empty($polite_header_overlay)) {
            $custom_css .= "
            .header-image:before { 
                background-color : ". $polite_header_overlay."; 
            }";
        }

        //Header Tranparent
        if (!empty($polite_header_transparent)) {
            $custom_css .= "
            .header-image:before { 
                opacity : ". $polite_header_transparent."; 
            }";
        }

        //Header Min Height
        if (!empty($polite_header_min_height)) {
            $custom_css .= "
            .header-1 .header-image .head_one { 
                min-height : ". $polite_header_min_height."px; 
            }";
        }

        wp_add_inline_style('polite-style', $custom_css);
    }
endif;
add_action('wp_enqueue_scripts', 'polite_dynamic_css', 99);