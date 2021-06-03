/**
 * customizer.js
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function($) {

    var style = $('.site-title a'),
        accent_color_background = $('.post-meta__tag__item a'),
        accent_color_text = $('.single.post-meta,.single.post-meta a,.comment-reply-link,.comment__author,.post-meta__author,.comment-edit-link'),
        menu_color = $('.outer-section-profile-container .inner-section-profile-container a,.um-header-avatar-name a,#bs-navbar-profile a,#bs-navbar-primary a,#bs-navbar-primary'),
        button_color_background = $('.comment-form input[type=submit],.site-search form input[type=submit]'),
        button_color_text = $('.comment-form input[type=submit]');

    /*--------------------------------------------------------------
    ## Color
    --------------------------------------------------------------*/

    // Site title
    wp.customize('blogname', function(value) {
        value.bind(function(to) {
            $('.site-title a').text(to);
        });
    });

    // Logo Hover Color
    wp.customize('customization[um_theme_logo_hover_color]', function(value) {
        value.bind(function(newval) {
            $('.site-title a:hover').css('color', newval);
        });
    });

    // Site Description
    wp.customize('blogdescription', function(value) {
        value.bind(function(to) {
            $('.site-description').text(to);
        });
    });

    // Body Font Size
    wp.customize('customization[um_theme_body_font_size]', function(value) {
        value.bind(function(newval) {
            $('body').css('font-size', newval);
        });
    });

    // Heading Text Color
    wp.customize('customization[title_text_color]', function(value) {
        value.bind(function(newval) {
            $('h1,h2,h3,h4,h5,h6').css('color', newval);
        });
    });

    // Content Background Color
    wp.customize('customization[um_customizer_post_content_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.site-content').css('background-color', newval);
        });
    });

    // Site Body Text Color
    wp.customize('customization[body_text_color]', function(value) {
        value.bind(function(newval) {
            $('body').css('color', newval);
        });
    });

    // Other Color
    wp.customize('customization[um_theme_primary_color]', function(value) {
        value.bind(function(newval) {
            $('.scrollToTop').css('color', newval);
        });
    });

    // Website Meta Color Background
    wp.customize('customization[um_theme_website_meta_color]', function(value) {
        value.bind(function(newval) {
            accent_color_background.css('background-color', newval);
        });
    });

    // Website Meta Color
    wp.customize('customization[um_theme_website_meta_color]', function(value) {
        value.bind(function(newval) {
            accent_color_text.css('color', newval);
        });
    });

    /*--------------------------------------------------------------
    ## Button & Link
    --------------------------------------------------------------*/

    // Button Background Color
    wp.customize('customization[button_background_color]', function(value) {
        value.bind(function(newval) {
            button_color_background.css('background-color', newval);
        });
    });

    // Button Text Color
    wp.customize('customization[button_text_color]', function(value) {
        value.bind(function(newval) {
            button_color_text.css('color', newval);
        });
    });

    // Button 1 Hover Color
    wp.customize('customization[um_header_logged_out_button_one_hover_bg]', function(value) {
        value.bind(function(newval) {
            $('.header-button-1:hover').css('background-color', newval);
        });
    });

    // Button 1 Hover Text Color
    wp.customize('customization[um_header_logged_out_button_one_hover_text]', function(value) {
        value.bind(function(newval) {
            $('.header-button-1:hover').css('color', newval);
        });
    });

    // Button 2 Hover Color
    wp.customize('customization[um_header_logged_out_button_two_hover_bg]', function(value) {
        value.bind(function(newval) {
            $('.header-button-2:hover').css('background-color', newval);
        });
    });

    // Button 2 Hover Text Color
    wp.customize('customization[um_header_logged_out_button_two_hover_text]', function(value) {
        value.bind(function(newval) {
            $('.header-button-2:hover').css('color', newval);
        });
    });

    // Register Button Color
    wp.customize('customization[header_log_button_two_color]', function(value) {
        value.bind(function(newval) {
            $('.header-button-2').css('background-color', newval);
        });
    });

    // Register Button Text Color
    wp.customize('customization[header_log_button_two_text_color]', function(value) {
        value.bind(function(newval) {
            $('.header-button-2').css('color', newval);
        });
    });

    // Header Buttton 1 Color
    wp.customize('customization[header_login_text_color]', function(value) {
        value.bind(function(newval) {
            $('.header-button-1').css('color', newval);
        });
    });

    // Header Buttton 1 Background Color
    wp.customize('customization[header_login_button_color]', function(value) {
        value.bind(function(newval) {
            $('.header-button-1').css('background-color', newval);
        });
    });

    // Header Buttton 2 Color
    wp.customize('customization[header_register_text_color]', function(value) {
        value.bind(function(newval) {
            $('.header-button-2').css('color', newval);
        });
    });

    // Header Buttton 2 Background Color
    wp.customize('customization[header_log_button_two_text_color]', function(value) {
        value.bind(function(newval) {
            $('.header-button-2').css('background-color', newval);
        });
    });

    // Link Text Color
    wp.customize('customization[link_text_color]', function(value) {
        value.bind(function(newval) {
            $('a').css('color', newval);
        });
    });

    // Link Hover Color
    wp.customize('customization[link_hover_color]', function(value) {
        value.bind(function(newval) {
            $('a:hover').css('color', newval);
        });
    });

    // Footer Widget Link Color
    wp.customize('customization[um_theme_footer_widget_link_color]', function(value) {
        value.bind(function(newval) {
            $('.footer-sidebar-column-one a,.footer-sidebar-column-two a,.footer-sidebar-column-three a,.footer-sidebar-column-four a').css('color', newval);
        });
    });

    // Footer Widget Link Hover Color
    wp.customize('customization[um_theme_footer_widget_link_hover_color]', function(value) {
        value.bind(function(newval) {
            $('.footer-sidebar-column-one a:hover,.footer-sidebar-column-two a:hover,.footer-sidebar-column-three a:hover,.footer-sidebar-column-four a:hover').css('color', newval);
        });
    });

    /*--------------------------------------------------------------
    ## Widget
    --------------------------------------------------------------*/

    // Widget Background Color
    wp.customize('customization[widgets_background_color]', function(value) {
        value.bind(function(newval) {
            $('#secondary .widget').css('background-color', newval);
        });
    });

    // Footer Widget Background
    wp.customize('customization[um_theme_footer_widget_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.site-footer-layout-sidebar').css('background-color', newval);
        });
    });

    // Footer Widget Color
    wp.customize('customization[um_theme_footer_widget_color]', function(value) {
        value.bind(function(newval) {
            $('.footer-sidebar-column-one,.footer-sidebar-column-two,.footer-sidebar-column-three,.footer-sidebar-column-four').css('color', newval);
        });
    });

    // Title Alignment Widget
    wp.customize('customization[um_theme_widget_title_alignment]', function(value) {
        value.bind(function(newval) {
            $('.widget-title').css('text-align', newval);
        });
    });

    /*--------------------------------------------------------------
    ## Menu
    --------------------------------------------------------------*/

    // Header Selected Menu Text Color
    wp.customize('customization[selected_menu_text_color]', function(value) {
        value.bind(function(newval) {
            $('#bs-navbar-primary .current-menu-item a').css('color', newval);
        });
    });

    // Menu Text Color
    wp.customize('customization[menu_text_hover_color]', function(value) {
        value.bind(function(newval) {
            $('#bs-navbar-profile a:hover,#bs-navbar-primary a:hover').css('color', newval);
        });
    });

    // Header Selected Menu Background Color
    wp.customize('customization[selected_menu_bg_color]', function(value) {
        value.bind(function(newval) {
            $('#bs-navbar-primary .current-menu-item a').css('background-color', newval);
        });
    });

    // Menu Text Color
    wp.customize('customization[menu_text_color]', function(value) {
        value.bind(function(newval) {
            menu_color.css('color', newval);
        });
    });

    // Submenu Text Color
    wp.customize('customization[um_theme_submenu_text_color]', function(value) {
        value.bind(function(newval) {
            $('.dropdown-item,.outer-section-profile-container .inner-section-profile-container a').css('color', newval);
        });
    });

    // Menu Font Size
    wp.customize('customization[um_theme_menu_font_size]', function(value) {
        value.bind(function(newval) {
            $('.menu-item a,.page-numbers a,.page-numbers span').css('font-size', newval);
        });
    });

    // Menu Position
    wp.customize('customization[um_theme_menu_position]', function(value) {
        value.bind(function(newval) {
            $('.nav-menu').css('text-align', newval);
        });
    });

    // Topbar Menu Color & Top Bar Link
    wp.customize('customization[header_topbar_menu_color]', function(value) {
        value.bind(function(newval) {
            $('#header-top li a,.topbar-container a, #bs-navbar-topbar a, #bs-navbar-topbar').css('color', newval);
        });
    });

    // Topbar Menu Hover Color & Top Bar Link Hover Color
    wp.customize('customization[header_topbar_link_hover_color]', function(value) {
        value.bind(function(newval) {
            $('.topbar-container a:hover, #bs-navbar-topbar a:hover').css('color', newval);
        });
    });

    // Bottom Bar Menu Color
    wp.customize('customization[header_bottombar_menu_color]', function(value) {
        value.bind(function(newval) {
            $('.header-bottom-bar, #bs-navbar-bottombar a, #bs-navbar-bottombar li').css('color', newval);
        });
    });

    // Bottom bar Font Size
    wp.customize('customization[header_bottombar_menu_font_size]', function(value) {
        value.bind(function(newval) {
            $('.header-bottom-bar,#bs-navbar-bottombar a,#bs-navbar-bottombar li').css('font-size', newval);
        });
    });

    // Topbar Font Size
    wp.customize('customization[header_topbar_menu_font_size]', function(value) {
        value.bind(function(newval) {
            $('.um-header-topbar-text').css('font-size', newval);
        });
    });

    // Footer Menu Color
    wp.customize('customization[footer_menu_color]', function(value) {
        value.bind(function(newval) {
            $('#bs-navbar-footer a,#bs-navbar-footer li').css('color', newval);
        });
    });

    // Footer Menu Font Size
    wp.customize('customization[footer_menu_font_size]', function(value) {
        value.bind(function(newval) {
            $('.site-footer-layout-text').css('font-size', newval);
        });
    });

    /*--------------------------------------------------------------
    ## Header
    --------------------------------------------------------------*/

    // Header text color.
    wp.customize('header_textcolor', function(value) {
        value.bind(function(to) {
            if ('blank' === to) {
                $('.site-title a, .site-description').css({
                    'clip': 'rect(1px, 1px, 1px, 1px)',
                    'position': 'absolute'
                });
            } else {
                $('.site-title a, .site-description').css({
                    'clip': 'auto',
                    'position': 'relative'
                });
                $('.site-title a, .site-description').css({
                    'color': to
                });
            }
        });
    });

    // Header Background Color
    wp.customize('customization[header_background_color]', function(value) {
        value.bind(function(newval) {
            $('.site-header').css('background-color', newval);
        });
    });

    // Topbar Background Color
    wp.customize('customization[header_topbar_background_color]', function(value) {
        value.bind(function(newval) {
            $('.header-top-bar').css('background-color', newval);
        });
    });

    // Topbar Text Color
    wp.customize('customization[header_topbar_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um-header-topbar-text').css('color', newval);
        });
    });

    // Bottom Bar Background Color
    wp.customize('customization[header_bottombar_background_color]', function(value) {
        value.bind(function(newval) {
            $('.header-bottom-bar').css('background-color', newval);
        });
    });

    // Bottom Bar Text Color
    wp.customize('customization[header_bottombar_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um-header-bottom-text').css('color', newval);
        });
    });

    // Header Search Box Color
    wp.customize('customization[header_search_background_color]', function(value) {
        value.bind(function(newval) {
            $('.header-search #search-form-input').css('background-color', newval);
        });
    });

    // Header Search Text Color
    wp.customize('customization[header_search_text_color]', function(value) {
        value.bind(function(newval) {
            $('.header-search #search-form-input').css('color', newval);
        });
    });

    // On Click Icon Color
    wp.customize('customization[header_bottombar_onclick_icon_color]', function(value) {
        value.bind(function(newval) {
            $('.bottom-t-m-ico').css('color', newval);
        });
    });

    // On Click Icon Hover Color
    wp.customize('customization[header_bottombar_onclick_icon_hover_color]', function(value) {
        value.bind(function(newval) {
            $('.bottom-t-m-ico:hover').css('color', newval);
        });
    });

    // Search Placeholder Text Color
    wp.customize('customization[header_search_placeholder_text_color]', function(value) {
        value.bind(function(newval) {
            $('.header-inner .search-form ::placeholder').css('color', newval);
        });
    });

    // On Click Icon Size
    wp.customize('customization[header_bottombar_onclick_icon_size]', function(value) {
        value.bind(function(newval) {
            $('.bottom-t-m-ico').css('font-size', newval);
        });
    });

    /*--------------------------------------------------------------
    ## Article
    --------------------------------------------------------------*/

    // Article Box Color
    wp.customize('customization[um_post_single_box_bg]', function(value) {
        value.bind(function(newval) {
            $('.single-article-content').css('background-color', newval);
        });
    });

    // Article Box Text Color
    wp.customize('customization[um_post_single_box_text_color]', function(value) {
        value.bind(function(newval) {
            $('.single-article-content').css('color', newval);
        });
    });

    // Post background Color
    wp.customize('customization[um_theme_blog_post_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.template-blog .blog-post-container').css('background-color', newval);
        });
    });

    // Post Content Color
    wp.customize('customization[um_theme_blog_post_content_color]', function(value) {
        value.bind(function(newval) {
            $('.template-blog .excerpt,.template-blog .excerpt-list,.template-blog .blog-post-container').css('color', newval);
        });
    });

    // Post Title Color
    wp.customize('customization[um_theme_blog_post_title_color]', function(value) {
        value.bind(function(newval) {
            $('.template-blog .entry-title a').css('color', newval);
        });
    });

    // Post Tag Background Color
    wp.customize('customization[um_post_tag_box_bg]', function(value) {
        value.bind(function(newval) {
            $('.meta-tag a').css('background-color', newval);
        });
    });

    // Post Tag Text Color
    wp.customize('customization[um_post_tag_text_color]', function(value) {
        value.bind(function(newval) {
            $('.meta-tag a').css('color', newval);
        });
    });

    /*--------------------------------------------------------------
    ## Social Icons
    --------------------------------------------------------------*/

    // Social Icon Font Size
    wp.customize('customization[header_topbar_icon_font_size]', function(value) {
        value.bind(function(newval) {
            $('.topbar-container .um-theme-social-link a').css('font-size', newval);
        });
    });

    // Social Icon Color
    wp.customize('customization[social_accounts_color]', function(value) {
        value.bind(function(newval) {
            $('.um-theme-social-link a').css('color', newval);
        });
    });

    // Social Icon Hover Color
    wp.customize('customization[social_accounts_hover_color]', function(value) {
        value.bind(function(newval) {
            $('.um-theme-social-link a:hover').css('color', newval);
        });
    });

    /*--------------------------------------------------------------
    ## Footer
    --------------------------------------------------------------*/

    // Footer Background Color
    wp.customize('customization[footer_background_color]', function(value) {
        value.bind(function(newval) {
            $('.site-footer-layout-text').css('background-color', newval);
        });
    });

    // Footer Text Color
    wp.customize('customization[footer_text_color]', function(value) {
        value.bind(function(newval) {
            $('.site-footer-layout-text').css('color', newval);
        });
    });

    // Footer Link Color
    wp.customize('customization[footer_link_color]', function(value) {
        value.bind(function(newval) {
            $('.site-footer-layout-text a').css('color', newval);
        });
    });

    // Footer Link Hover Color
    wp.customize('customization[footer_link_hover_color]', function(value) {
        value.bind(function(newval) {
            $('.site-footer-layout-text a:hover').css('color', newval);
        });
    });

    /*--------------------------------------------------------------
    ## Layout & Positioning
    --------------------------------------------------------------*/

    // Site Width
    wp.customize('customization[um_theme_canvas_width]', function(value) {
        value.bind(function(to) {
            $('.website-canvas').css('max-width', newval);
        });
    });

    /*--------------------------------------------------------------
    ## LifterLMS
    --------------------------------------------------------------*/

    // Primary Button Color
    wp.customize('customization[um_theme_lifter_primary_button_color]', function(value) {
        value.bind(function(newval) {
            $('.llms-button-primary').css('background-color', newval);
        });
    });

    // Primary Button Text Color
    wp.customize('customization[um_theme_lifter_primary_button_text_color]', function(value) {
        value.bind(function(newval) {
            $('.llms-button-primary').css('color', newval);
        });
    });

    // Primary Button Hover Color
    wp.customize('customization[um_theme_lifter_primary_button_hover_color]', function(value) {
        value.bind(function(newval) {
            $('.llms-button-primary:hover').css('background-color', newval);
        });
    });

    // Primary Button Text Hover Color
    wp.customize('customization[um_theme_lifter_primary_button_hover_text_color]', function(value) {
        value.bind(function(newval) {
            $('.llms-button-primary:hover').css('color', newval);
        });
    });

    // Secondary Button Color
    wp.customize('customization[um_theme_lifter_secondary_button_color]', function(value) {
        value.bind(function(newval) {
            $('.llms-button-secondary').css('background-color', newval);
        });
    });

    // Secondary Button Text Color
    wp.customize('customization[um_theme_lifter_secondary_button_text_color]', function(value) {
        value.bind(function(newval) {
            $('.llms-button-secondary').css('color', newval);
        });
    });

    // Secondary Button Hover Color
    wp.customize('customization[um_theme_lifter_secondary_button_hover_color]', function(value) {
        value.bind(function(newval) {
            $('.llms-button-secondary:hover').css('background-color', newval);
        });
    });

    // Secondary Button Text Hover Color
    wp.customize('customization[um_theme_lifter_secondary_button_hover_text_color]', function(value) {
        value.bind(function(newval) {
            $('.llms-button-secondary:hover').css('color', newval);
        });
    });

    // Plan Title Color
    wp.customize('customization[um_theme_lifter_plan_title_color]', function(value) {
        value.bind(function(newval) {
            $('.llms-access-plan-title,.llms-access-plan .stamp').css('color', newval);
        });
    });

    // Plan Title Background Color
    wp.customize('customization[um_theme_lifter_plan_title_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.llms-access-plan-title,.llms-access-plan .stamp').css('background-color', newval);
        });
    });

    // Plan Featured Color
    wp.customize('customization[um_theme_lifter_plan_featured_color]', function(value) {
        value.bind(function(newval) {
            $('.llms-access-plan.featured .llms-access-plan-featured').css('color', newval);
        });
    });

    // Plan Featured Background Color
    wp.customize('customization[um_theme_lifter_plan_featured_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.llms-access-plan.featured .llms-access-plan-featured').css('background-color', newval);
        });
    });

    // Restrictions Link Color
    wp.customize('customization[um_theme_lifter_plan_restriction_link_color]', function(value) {
        value.bind(function(newval) {
            $('.llms-access-plan-restrictions a').css('color', newval);
        });
    });

    // Restrictions Link Hover Color
    wp.customize('customization[um_theme_lifter_plan_restriction_link_hover_color]', function(value) {
        value.bind(function(newval) {
            $('.llms-access-plan-restrictions a:hover').css('color', newval);
        });
    });

    // Checkout Heading Color
    wp.customize('customization[um_theme_lifter_checkout_heading_color]', function(value) {
        value.bind(function(newval) {
            $('.llms-checkout-wrapper .llms-form-heading').css('color', newval);
        });
    });

    // Checkout Heading Color
    wp.customize('customization[um_theme_lifter_checkout_heading_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.llms-checkout-wrapper .llms-form-heading').css('background-color', newval);
        });
    });

    /*--------------------------------------------------------------
    ## WP Job Manager
    --------------------------------------------------------------*/

    // Job Title Font Size
    wp.customize('customization[um_theme_sing_job_listing_title_font_size]', function(value) {
        value.bind(function(newval) {
            $('.single-job-title').css('font-size', newval);
        });
    });

    // Job Title Color
    wp.customize('customization[um_theme_sing_job_listing_title_color]', function(value) {
        value.bind(function(newval) {
            $('.single-job-title').css('color', newval);
        });
    });

    // Apply Button Color
    wp.customize('customization[um_theme_sing_job_listing_button_color]', function(value) {
        value.bind(function(newval) {
            $('.single-job-header .application_button').css('background-color', newval);
        });
    });

    // Apply Button Text Color
    wp.customize('customization[um_theme_sing_job_listing_button_text_color]', function(value) {
        value.bind(function(newval) {
            $('.single-job-header .application_button').css('color', newval);
        });
    });

    /*--------------------------------------------------------------
    ## bbPress
    --------------------------------------------------------------*/

    // bbPress Title Font Size
    wp.customize('customization[um_bb_forum_title_font_size]', function(value) {
        value.bind(function(newval) {
            $('.bbp-topic-title,.bbp-reply-title,.bbp-forum-title,.bbp-topic-permalink').css('font-size', newval);
        });
    });

    // bbPress Title Color
    wp.customize('customization[um_bb_forum_title_color]', function(value) {
        value.bind(function(newval) {
            $('.bbp-topic-title,.bbp-reply-title,.bbp-forum-title,.bbp-topic-permalink').css('color', newval);
        });
    });

    // bbPress Text Color
    wp.customize('customization[um_bb_forum_text_color]', function(value) {
        value.bind(function(newval) {
            $('.bbp-forum-content').css('color', newval);
        });
    });

    // bbPress Author Name Color
    wp.customize('customization[um_bb_forum_author_name_color]', function(value) {
        value.bind(function(newval) {
            $('.bbp-author-name').css('color', newval);
        });
    });

    // Forum Header Background Color
    wp.customize('customization[um_bb_forum_header_bg_color]', function(value) {
        value.bind(function(newval) {
            $('#bbpress-forums li.bbp-header').css('background-color', newval);
        });
    });

    // Forum Header Text Color
    wp.customize('customization[um_bb_forum_header_text_color]', function(value) {
        value.bind(function(newval) {
            $('#bbpress-forums li.bbp-header').css('color', newval);
        });
    });

    // Sticky topic background color
    wp.customize('customization[um_bb_sticky_topic_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.bbp-topics-front ul.super-sticky,.bbp-topics ul.super-sticky,.bbp-topics ul.sticky,.bbp-forum-content ul.sticky').css('background-color', newval);
        });
    });

    // Notice Background Color
    wp.customize('customization[um_bb_notice_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.um-bbpress-warning,div.bbp-template-notice.info,.bbp-template-notice,.indicator-hint').css('background-color', newval);
        });
    });

    // Notice Text Color
    wp.customize('customization[um_bb_notice_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um-bbpress-warning,div.bbp-template-notice.info,.bbp-template-notice,.indicator-hint').css('background-color', newval);
        });
    });

    /*--------------------------------------------------------------
    ## YITH Wishlist
    --------------------------------------------------------------*/

    // Wishlist Add to Cart Button
    wp.customize('customization[um_theme_yith_wishlist_add_cart_color]', function(value) {
        value.bind(function(newval) {
            $('.wishlist_table .add_to_cart_button').css('background-color', newval);
        });
    });

    // Wishlist Add to Cart Button Text
    wp.customize('customization[um_theme_yith_wishlist_add_cart_text_color]', function(value) {
        value.bind(function(newval) {
            $('.wishlist_table .add_to_cart_button').css('color', newval);
        });
    });

    // Wishlist Remove Button
    wp.customize('customization[um_theme_yith_wishlist_remove_color]', function(value) {
        value.bind(function(newval) {
            $('.wishlist_table a.remove_from_wishlist').css('background-color', newval);
        });
    });

    // Wishlist Remove Text Button
    wp.customize('customization[um_theme_yith_wishlist_remove_text_color]', function(value) {
        value.bind(function(newval) {
            $('.wishlist_table a.remove_from_wishlist').css('color', newval);
        });
    });

    /*--------------------------------------------------------------
    ## Easy Digital Downloads
    --------------------------------------------------------------*/

    // EDD Button Font Size
    wp.customize('customization[um_theme_edd_button_font_size]', function(value) {
        value.bind(function(newval) {
            $('#edd-purchase-button, .edd-submit, [type=submit].edd-submit').css('font-size', newval);
        });
    });

    // EDD Button Color
    wp.customize('customization[um_theme_edd_button_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.edd-submit.button.white,.edd-submit.button.gray,.edd-submit.button.red,.edd-submit.button.green,.edd-submit.button.yellow,.edd-submit.button.orange,.edd-submit.button.dark-gray,.edd-submit.button.blue').css('background-color', newval);
        });
    });

    // EDD Button Text Color
    wp.customize('customization[um_theme_edd_button_text_color]', function(value) {
        value.bind(function(newval) {
            $('.edd-submit.button.white,.edd-submit.button.gray,.edd-submit.button.red,.edd-submit.button.green,.edd-submit.button.yellow,.edd-submit.button.orange,.edd-submit.button.dark-gray,.edd-submit.button.blue').css('color', newval);
        });
    });

    // EDD Button Hover Color
    wp.customize('customization[um_theme_edd_button_hover_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.edd-submit.button.white:hover,.edd-submit.button.gray:hover,.edd-submit.button.red:hover,.edd-submit.button.green:hover,.edd-submit.button.yellow:hover,.edd-submit.button.orange:hover,.edd-submit.button.dark-gray:hover,.edd-submit.button.blue:hover').css('background-color', newval);
        });
    });

    // EDD Button Hover Text Color
    wp.customize('customization[um_theme_edd_button_hover_text_color]', function(value) {
        value.bind(function(newval) {
            $('.edd-submit.button.white:hover,.edd-submit.button.gray:hover,.edd-submit.button.red:hover,.edd-submit.button.green:hover,.edd-submit.button.yellow:hover,.edd-submit.button.orange:hover,.edd-submit.button.dark-gray:hover,.edd-submit.button.blue:hover').css('color', newval);
        });
    });

    // Error Background Color
    wp.customize('customization[um_theme_edd_alert_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.edd-alert-error').css('background-color', newval);
        });
    });

    // Error Text Color
    wp.customize('customization[um_theme_edd_alert_text_color]', function(value) {
        value.bind(function(newval) {
            $('.edd-alert-error').css('color', newval);
        });
    });

    // Success Background Color
    wp.customize('customization[um_theme_edd_success_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.edd-alert-success').css('background-color', newval);
        });
    });

    // Success Text Color
    wp.customize('customization[um_theme_edd_success_text_color]', function(value) {
        value.bind(function(newval) {
            $('.edd-alert-success').css('color', newval);
        });
    });

    // Info Background Color
    wp.customize('customization[um_theme_edd_info_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.edd-alert-info').css('background-color', newval);
        });
    });

    // Info Text Color
    wp.customize('customization[um_theme_edd_info_text_color]', function(value) {
        value.bind(function(newval) {
            $('.edd-alert-info').css('color', newval);
        });
    });

    // Warn Background Color
    wp.customize('customization[um_theme_edd_warn_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.edd-alert-warn').css('background-color', newval);
        });
    });

    // Warn Text Color
    wp.customize('customization[um_theme_edd_warn_text_color]', function(value) {
        value.bind(function(newval) {
            $('.edd-alert-warn').css('color', newval);
        });
    });

    /*--------------------------------------------------------------
    ## WooCommerce
    --------------------------------------------------------------*/

    // WooCommerce Product Title Font Size
    wp.customize('customization[um_theme_woo_prod_title_font_size]', function(value) {
        value.bind(function(newval) {
            $('.woocommerce ul.products li.product .woocommerce-loop-category__title,.woocommerce ul.products li.product .woocommerce-loop-product__title,.woocommerce ul.products li.product h3').css('font-size', newval);
        });
    });

    // Star Rating Color
    wp.customize('customization[um_theme_woocommerce_star_rating_color]', function(value) {
        value.bind(function(newval) {
            $('.woocommerce .star-rating span::before').css('color', newval);
        });
    });

    // WooCommerce Message Color
    wp.customize('customization[um_theme_woocommerce_message_color]', function(value) {
        value.bind(function(newval) {
            $('.woocommerce-message').css('background-color', newval);
        });
    });

    // WooCommerce Info Color
    wp.customize('customization[um_theme_woocommerce_info_color]', function(value) {
        value.bind(function(newval) {
            $('.woocommerce-info::before').css('color', newval);
        });
    });

    // WooCommerce Price Color
    wp.customize('customization[um_theme_woocommerce_price_color]', function(value) {
        value.bind(function(newval) {
            $('.woocommerce div.product p.price,.woocommerce div.product span.price,.woocommerce ul.products li.product .price').css('color', newval);
        });
    });

    // WooCommerce Message Color
    wp.customize('customization[um_theme_woocommerce_message_text_color]', function(value) {
        value.bind(function(newval) {
            $('.woocommerce-message').css('color', newval);
        });
    });

    // WooCommerce Product Title Color
    wp.customize('customization[um_theme_woocommerce_product_title_color]', function(value) {
        value.bind(function(newval) {
            $('.woocommerce div.product .product_title,.woocommerce-loop-product__title').css('color', newval);
        });
    });

    // Add To Cart Button
    wp.customize('customization[um_theme_woocommerce_add_cart_button_color]', function(value) {
        value.bind(function(newval) {
            $('.woocommerce #respond input#submit.alt,.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt,.woocommerce #respond input#submit,.woocommerce a.button,.woocommerce button.button,.woocommerce input.button').css('background-color', newval);
        });
    });

    // Add To Cart Button Text
    wp.customize('customization[um_theme_woocommerce_add_cart_button_text]', function(value) {
        value.bind(function(newval) {
            $('.woocommerce #respond input#submit.alt,.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt,.woocommerce #respond input#submit,.woocommerce a.button,.woocommerce button.button,.woocommerce input.button').css('color', newval);
        });
    });

    // Sale Badge
    wp.customize('customization[um_theme_woocommerce_sale_badge_color]', function(value) {
        value.bind(function(newval) {
            $('.woocommerce span.onsale').css('background-color', newval);
        });
    });

    // Sale Badge Text
    wp.customize('customization[um_theme_woocommerce_sale_badge_text]', function(value) {
        value.bind(function(newval) {
            $('.woocommerce span.onsale').css('color', newval);
        });
    });

    // Notice Text Color
    wp.customize('customization[um_theme_woocommerce_notice_text_color]', function(value) {
        value.bind(function(newval) {
            $('.woocommerce-store-notice').css('color', newval);
        });
    });

    // Notice Background Color
    wp.customize('customization[um_theme_woocommerce_notice_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.woocommerce-store-notice').css('background-color', newval);
        });
    });

    // Add To Cart Button
    wp.customize('customization[um_theme_woocommerce_add_cart_button_hover_color]', function(value) {
        value.bind(function(newval) {
            $('.woocommerce #respond input#submit:hover,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce #respond input#submit.alt:hover,.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover,.woocommerce input.button.alt:hover').css('background-color', newval);
        });
    });

    /*--------------------------------------------------------------
    ## ForumWP
    --------------------------------------------------------------*/

    // Category Background Color
    wp.customize('customization[um_forumwp_cat_color]', function(value) {
        value.bind(function(newval) {
            $('.fmwp-forum-category').css('background-color', newval);
        });
    });

    // Category Text Color
    wp.customize('customization[um_forumwp_cat_txt_color]', function(value) {
        value.bind(function(newval) {
            $('.fmwp-forum-category a').css('color', newval);
        });
    });

    // Tag Background Color
    wp.customize('customization[um_forumwp_tag_color]', function(value) {
        value.bind(function(newval) {
            $('.fmwp-topic-tag').css('background-color', newval);
        });
    });

    // Tag Text Color
    wp.customize('customization[um_forumwp_tag_txt_color]', function(value) {
        value.bind(function(newval) {
            $('.fmwp-topic-tag a').css('color', newval);
        });
    });

    // Topic Title Color
    wp.customize('customization[um_forumwp_topic_title_color]', function(value) {
        value.bind(function(newval) {
            $('.fmwp-topic-title').css('color', newval);
        });
    });

    // Topic Button Background Color
    wp.customize('customization[um_forumwp_topic_btn_color]', function(value) {
        value.bind(function(newval) {
            $('input[type=button].fmwp-create-topic').css('background-color', newval);
        });
    });

    // Topic Button Text Color
    wp.customize('customization[um_forumwp_topic_btn_text_color]', function(value) {
        value.bind(function(newval) {
            $('input[type=button].fmwp-create-topic').css('color', newval);
        });
    });

    // Reply Button Background Color
    wp.customize('customization[um_forumwp_reply_btn_color]', function(value) {
        value.bind(function(newval) {
            $('input[type=button].fmwp-write-reply').css('background-color', newval);
        });
    });

    // Reply Button Text Color
    wp.customize('customization[um_forumwp_reply_btn_text_color]', function(value) {
        value.bind(function(newval) {
            $('input[type=button].fmwp-write-reply').css('color', newval);
        });
    });

    // Metadata Color
    wp.customize('customization[um_forumwp_subdata_color]', function(value) {
        value.bind(function(newval) {
            $('.fmwp-reply-subdata,.fmwp-topic-subdata,.fmwp-topic-top-actions-dropdown,.fmwp-reply-top-actions-dropdown,.fmwp-show-child-replies').css('color', newval);
        });
    });

    // Reply Box Background Color
    wp.customize('customization[um_forumwp_reply_box_color]', function(value) {
        value.bind(function(newval) {
            $('.fmwp-child-reply').css('background-color', newval);
        });
    });

    // Search Button Background Color
    wp.customize('customization[um_forumwp_search_button_color]', function(value) {
        value.bind(function(newval) {
            $('.fmwp-search-topic,.fmwp-search-forum').css('background-color', newval);
        });
    });

    // Search Button Text Color
    wp.customize('customization[um_forumwp_search_button_text_color]', function(value) {
        value.bind(function(newval) {
            $('.fmwp-search-topic,.fmwp-search-forum').css('color', newval);
        });
    });

    // Forum Heading Color
    wp.customize('customization[um_forumwp_forum_heading_color]', function(value) {
        value.bind(function(newval) {
            $('.fmwp-forums-wrapper-heading,.fmwp-topics-wrapper-heading').css('color', newval);
        });
    });

    // Forum Border Color
    wp.customize('customization[um_forumwp_border_color]', function(value) {
        value.bind(function(newval) {
            $('.fmwp-forums-wrapper-heading,.fmwp-forums-list-head,.fmwp-forum-row,.fmwp-forum-nav-bar,.fmwp-topics-wrapper-heading,.fmwp-topic-row').css('border-color', newval);
        });
    });

    // Info Color
    wp.customize('customization[um_forumwp_meta_color]', function(value) {
        value.bind(function(newval) {
            $('.fmwp-forum-actions-dropdown,.fmwp-forum-statistics-data,.fmwp-topic-statistics-section,.fmwp-topic-actions-dropdown').css('color', newval);
        });
    });

    // Forum Title Color
    wp.customize('customization[um_forumwp_forum_title_color]', function(value) {
        value.bind(function(newval) {
            $('.fmwp-forum-title').css('color', newval);
        });
    });

    // Search Box Color
    wp.customize('customization[um_forumwp_search_box_color]', function(value) {
        value.bind(function(newval) {
            $('.fmwp-forum-search-line,.fmwp-forums-search-line,.fmwp-topics-search-line').css('background-color', newval);
        });
    });


    /*--------------------------------------------------------------
    ## Ultimate Member
    --------------------------------------------------------------*/

    // Ultimate Member - Primary Button Text Color
    wp.customize('customization[um_theme_um_plug_button_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um .um-button,.um input[type=submit].um-button,.um input[type=submit].um-button:focus,.um a.um-button,.um a.um-button.um-disabled:hover,.um a.um-button.um-disabled:focus,.um a.um-button.um-disabled:active').css('color', newval);
        });
    });

    // Ultimate Member - Primary Text Color
    wp.customize('customization[um_theme_um_plug_button_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.um .um-button,.um input[type=submit].um-button,.um input[type=submit].um-button:focus,.um a.um-button,.um a.um-button.um-disabled:hover,.um a.um-button.um-disabled:focus,.um a.um-button.um-disabled:active').css('background-color', newval);
        });
    });

    // Ultimate Member - Primary Button Hover Color
    wp.customize('customization[um_theme_um_plug_button_hover_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.um-modal-btn:hover,.um input[type=submit].um-button:hover,.um a.um-button:hover,.um-button:active').css('background-color', newval);
        });
    });

    // Ultimate Member - Primary Button Hover Text Color
    wp.customize('customization[um_theme_um_plug_button_hover_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um-modal-btn:hover,.um input[type=submit].um-button:hover,.um a.um-button:hover,.um-button:active').css('color', newval);
        });
    });

    // Ultimate Member - Primary Alt Button Text Color
    wp.customize('customization[um_theme_um_plug_alt_button_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um .um-button.um-alt,.um input[type=submit].um-button.um-alt').css('color', newval);
        });
    });

    // Ultimate Member - Primary Button Alt Color
    wp.customize('customization[um_theme_um_plug_alt_button_color]', function(value) {
        value.bind(function(newval) {
            $('.um .um-button.um-alt,.um input[type=submit].um-button.um-alt').css('background-color', newval);
        });
    });

    // Member Directory - Box Background Color
    wp.customize('customization[um_theme_member_directory_box_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.um-members-wrapper .um-members .um-member').css('background-color', newval);
        });
    });

    // Member Directory - Box Text Color
    wp.customize('customization[um_theme_member_directory_box_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um-member-name a').css('color', newval);
        });
    });

    // Member Directory - Selected Filter Background Color
    wp.customize('customization[um_theme_member_dir_selec_filter_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.um-directory .um-members-filter-tag').css('background-color', newval);
        });
    });

    // Member Directory - Selected Filter Text Color
    wp.customize('customization[um_theme_member_dir_selec_filter_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um-directory .um-members-filter-tag').css('color', newval);
        });
    });

    // User Profiles - Profile Single Container Color
    wp.customize('customization[um_theme_template_profile_single_container_color]', function(value) {
        value.bind(function(newval) {
            $('.um-theme-profile-single-content-container').css('background-color', newval);
        });
    });

    // User Profiles - Profile Sidebar Container Color
    wp.customize('customization[um_theme_template_profile_sidebar_container_color]', function(value) {
        value.bind(function(newval) {
            $('.um-theme-profile-single-sidebar-container').css('background-color', newval);
        });
    });

    // User Profiles - Profile Navigation Bar Color
    wp.customize('customization[um_theme_template_profile_nav_bar_color]', function(value) {
        value.bind(function(newval) {
            $('.um-profile-nav').css('background-color', newval);
        });
    });

    // User Profiles - Profile Navigation Menu Color
    wp.customize('customization[um_theme_template_profile_nav_menu_color]', function(value) {
        value.bind(function(newval) {
            $('.um-profile-nav-item a').css('color', newval);
        });
    });

    // User Profiles - Profile Navigation Active Menu Hover Color
    wp.customize('customization[um_theme_template_profile_nav_menu_bg_hover_color]', function(value) {
        value.bind(function(newval) {
            $('.um .um-profile-nav-item.active a:hover,.um .um-profile-nav-item.active a,.um-profile-nav-item a:hover').css('background-color', newval);
        });
    });

    // User Profiles - Profile Navigation Active Menu Hover Color
    wp.customize('customization[um_theme_template_profile_nav_menu_hover_color]', function(value) {
        value.bind(function(newval) {
            $('.um .um-profile-nav-item.active a:hover,.um .um-profile-nav-item.active a,.um-profile-nav-item a:hover').css('color', newval);
        });
    });

    // User Profiles - Profile Content Area Color
    wp.customize('customization[um_theme_template_profile_content_area_color]', function(value) {
        value.bind(function(newval) {
            $('.um-profile .um-header').css('background-color', newval);
        });
    });

    // User Profiles - Meta Color
    wp.customize('customization[um_theme_profile_meta_color]', function(value) {
        value.bind(function(newval) {
            $('.um-profile.um .um-profile-meta').css('color', newval);
        });
    });

    // User Profiles - Profile Text Color
    wp.customize('customization[um_theme_profile_single_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um-profile-two,.um-profile-note,.um-profile-note span,.um-theme-profile-single-content-container').css('color', newval);
        });
    });

    // User Profiles - Profile Content Text Color
    wp.customize('customization[um_theme_template_profile_content_area_text_color]', function(value) {
        value.bind(function(newval) {
            $('.profile-title,.um-profile-meta .um-meta-text,.um-profile.um .um-name a,.um-profile.um .um-name a:hover').css('color', newval);
        });
    });

    // User Profiles - Profile Label Text Color
    wp.customize('customization[um_theme_profile_field_label_txt_color]', function(value) {
        value.bind(function(newval) {
            $('.um-profile-body .um-field-label').css('color', newval);
        });
    });

    // User Profiles - Profile Field Label Border Color
    wp.customize('customization[um_theme_template_profile_field_label_color]', function(value) {
        value.bind(function(newval) {
            $('.um-profile.um-viewing .um-field-label').css('border-color', newval);
        });
    });

    // UM Messaging - Header Message Username Color
    wp.customize('customization[um_theme_header_messenger_username_color]', function(value) {
        value.bind(function(newval) {
            $('.um-theme-dropdown-header,.messenger-username strong').css('color', newval);
        });
    });

    // UM Messaging - Message Button Text Color
    wp.customize('customization[um_theme_ext_pm_message_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um-message-item.left_m .um-message-item-content').css('color', newval);
        });
    });

    // UM Messaging - Message Button Color
    wp.customize('customization[um_theme_ext_pm_message_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.um-message-item.left_m .um-message-item-content').css('background-color', newval);
        });
    });

    // UM Messaging - Message Button Text Color
    wp.customize('customization[um_theme_ext_pm_message_button_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um-message-send').css('color', newval);
        });
    });

    // UM Messaging - Message Button Color
    wp.customize('customization[um_theme_ext_pm_message_button_color]', function(value) {
        value.bind(function(newval) {
            $('.um-message-send').css('background-color', newval);
        });
    });

    // UM Messaging - Message Background Color
    wp.customize('customization[um_theme_ext_pm_your_message_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.um-message-item-content').css('background-color', newval);
        });
    });

    // UM Messaging - Message Text Color
    wp.customize('customization[um_theme_ext_pm_message_your_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um-message-item-content').css('color', newval);
        });
    });

    // UM Messaging - Header Message Box Color
    wp.customize('customization[um_theme_header_messenger_box_color]', function(value) {
        value.bind(function(newval) {
            $('.header-messenger-box .dropdown-menu').css('background-color', newval);
        });
    });

    // UM Messaging - Message Color
    wp.customize('customization[um_theme_header_messenger_text_color]', function(value) {
        value.bind(function(newval) {
            $('.messenger-text').css('color', newval);
        });
    });

    // UM Messaging - Header Icon Color
    wp.customize('customization[um_theme_ext_pm_message_icon_color]', function(value) {
        value.bind(function(newval) {
            $('.um-message-item-remove,.um-message-header-right a').css('color', newval);
        });
    });

    // UM Messaging - Message Icon Color
    wp.customize('customization[header_private_message_color]', function(value) {
        value.bind(function(newval) {
            $('.um-msg-tik-ico').css('color', newval);
        });
    });

    // UM Messaging - Message Icon Hover Color
    wp.customize('customization[header_private_message_hover_color]', function(value) {
        value.bind(function(newval) {
            $('.um-msg-tik-ico:hover').css('color', newval);
        });
    });

    // UM Messaging - Unread Message Color
    wp.customize('customization[um_theme_header_unread_message_color]', function(value) {
        value.bind(function(newval) {
            $('.message-status-0').css('background-color', newval);
        });
    });

    // UM Messaging - Private Message Color
    wp.customize('customization[header_private_message_color]', function(value) {
        value.bind(function(newval) {
            $('.header-one-profile .um-notification-m').css('color', newval);
        });
    });

    // UM Social Activity - Text Color
    wp.customize('customization[um_theme_ext_acitivity_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um-activity-bodyinner-txt').css('color', newval);
        });
    });

    // UM Social Activity - Activity Header Color
    wp.customize('customization[um_theme_ext_acitivity_head_color]', function(value) {
        value.bind(function(newval) {
            $('.um-activity-head').css('background-color', newval);
        });
    });

    // UM Social Activity - Activity Border Color
    wp.customize('customization[um_theme_ext_acitivity_border_color]', function(value) {
        value.bind(function(newval) {
            $('.um-activity-bodyinner-txt span.post-meta,.um-activity-head,.um-activity-body,.um-activity-foot,.um-activity-comments').css('border-color', newval);
        });
    });

    // UM Social Activity - Activity Meta Color
    wp.customize('customization[um_theme_ext_acitivity_meta_color]', function(value) {
        value.bind(function(newval) {
            $('.um-activity-author-meta span.um-activity-metadata a').css('color', newval);
        });
    });

    // UM Friends - Friend Button Color
    wp.customize('customization[um_theme_ext_friend_button_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.um .um-friends-coverbtn a').css('background-color', newval);
        });
    });

    // UM Friends - Friend Button Text Color
    wp.customize('customization[um_theme_ext_friend_button_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um .um-friends-coverbtn a').css('color', newval);
        });
    });

    // UM Friends - Friend Button Hover Color
    wp.customize('customization[um_theme_ext_friend_button_hover_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.um .um-friends-coverbtn a:hover').css('background-color', newval);
        });
    });

    // UM Friends - Friend Button Text Hover Color
    wp.customize('customization[um_theme_ext_friend_button_hover_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um .um-friends-coverbtn a:hover').css('color', newval);
        });
    });

    // UM Friends - Friends Requests Button Text Color
    wp.customize('customization[header_friend_req_confirm_button_text_color]', function(value) {
        value.bind(function(newval) {
            $('.friends-drop-menu .um-friend-accept-btn').css('color', newval);
        });
    });

    // UM Friends - Friends Requests Button Color
    wp.customize('customization[header_friend_req_confirm_button_color]', function(value) {
        value.bind(function(newval) {
            $('.friends-drop-menu .um-friend-accept-btn').css('background-color', newval);
        });
    });

    // UM Friends - Header Friend Requests Color
    wp.customize('customization[header_friend_req_content_color]', function(value) {
        value.bind(function(newval) {
            $('.header-friend-requests .dropdown-menu').css('color', newval);
        });
    });

    // UM Friends - Header Friend Requests Background Color
    wp.customize('customization[header_friend_req_box_color]', function(value) {
        value.bind(function(newval) {
            $('.header-friend-requests .dropdown-menu').css('background-color', newval);
        });
    });

    // UM Friends - Friend Requests Bubble Background Color
    wp.customize('customization[header_friend_req_bubble_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.um-friend-req-live-count').css('background-color', newval);
        });
    });

    // UM Friends - Friend Requests Bubble Color
    wp.customize('customization[header_friend_req_bubble_color]', function(value) {
        value.bind(function(newval) {
            $('.um-friend-req-live-count').css('color', newval);
        });
    });

    // UM Friends - Friend Request Decline Button
    wp.customize('customization[header_friend_req_delete_button_color]', function(value) {
        value.bind(function(newval) {
            $('.friends-drop-menu .um-friend-reject-btn').css('background-color', newval);
        });
    });

    // UM Friends - Friend Request Confirm Button
    wp.customize('customization[header_friend_req_confirm_button_color]', function(value) {
        value.bind(function(newval) {
            $('.friends-drop-menu .um-friend-accept-btn').css('background-color', newval);
        });
    });

    // UM Friends - Friend Request Confirm Button
    wp.customize('customization[header_friend_req_delete_button_text_color]', function(value) {
        value.bind(function(newval) {
            $('.friends-drop-menu .um-friend-reject-btn').css('color', newval);
        });
    });

    // UM Friends - Friend Requests Icon Color
    wp.customize('customization[header_friend_req_color]', function(value) {
        value.bind(function(newval) {
            $('.um-friend-tick').css('color', newval);
        });
    });

    // UM Friends - Friend Requests Icon Hover Color
    wp.customize('customization[header_friend_req_hover_color]', function(value) {
        value.bind(function(newval) {
            $('.um-friend-tick:hover').css('color', newval);
        });
    });

    // UM Groups - Groups Title Color
    wp.customize('customization[um_theme_ext_group_title_color]', function(value) {
        value.bind(function(newval) {
            $('.um-group-name,.um-groups-single .um-group-name').css('color', newval);
        });
    });

    // UM Groups - Groups Background Color
    wp.customize('customization[um_theme_ext_groups_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.um-group-item,.group-grid-inner').css('background-color', newval);
        });
    });

    // UM Groups - Search Button Text
    wp.customize('customization[um_theme_ext_group_search_button_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um-groups-search-form input[type=submit]').css('color', newval);
        });
    });

    // UM Groups - Search Button Color
    wp.customize('customization[um_theme_ext_group_search_button_color]', function(value) {
        value.bind(function(newval) {
            $('.um-groups-search-form input[type=submit]').css('background-color', newval);
        });
    });

    // UM Groups - Group Description Text
    wp.customize('customization[um_theme_ext_group_description_color]', function(value) {
        value.bind(function(newval) {
            $('.group-description,.um-group-meta .description,.um-groups-single .um-group-description').css('color', newval);
        });
    });

    // UM Notifications - Notification Text Color
    wp.customize('customization[header_notification_text_color]', function(value) {
        value.bind(function(newval) {
            $('.header-notification-box h6,.header-notification-box .um-notification').css('color', newval);
        });
    });

    // UM Notifications - Bell Icon Color
    wp.customize('customization[um_theme_ext_float_notification_bell_icon_color]', function(value) {
        value.bind(function(newval) {
            $('.um-groups-search-form input[type=submit]').css('color', newval);
        });
    });

    // UM Notifications - Bell Icon Background Color
    wp.customize('customization[um_theme_ext_float_notification_icon_color]', function(value) {
        value.bind(function(newval) {
            $('.um-groups-search-form input[type=submit]').css('background-color', newval);
        });
    });

    // UM Notifications - Header Notification Background Color
    wp.customize('customization[header_notification_box_color]', function(value) {
        value.bind(function(newval) {
            $('.header-notification-box .um-notification').css('background-color', newval);
        });
    });

    // UM Notifications - Notification Bubble Background Color
    wp.customize('customization[header_notification_bubble_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.um-notification-live-count').css('background-color', newval);
        });
    });

    // UM Notifications - Notification Bubble Color
    wp.customize('customization[header_notification_bubble_color]', function(value) {
        value.bind(function(newval) {
            $('.um-notification-live-count').css('color', newval);
        });
    });

    // UM Notifications - Notification Icon Color
    wp.customize('customization[header_notification_color]', function(value) {
        value.bind(function(newval) {
            $('.um-notification-ico').css('color', newval);
        });
    });

    // UM Notifications - Notification Icon Hover Color
    wp.customize('customization[header_notification_hover_color]', function(value) {
        value.bind(function(newval) {
            $('.um-notification-ico:hover').css('color', newval);
        });
    });

    // UM Notifications - Notification Color
    wp.customize('customization[header_notification_color]', function(value) {
        value.bind(function(newval) {
            $('.header-one-profile .um-notification-b').css('color', newval);
        });
    });

    // UM WooCommerce - Product Background Color
    wp.customize('customization[um_theme_ext_woo_product_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.um-woo-grid').css('background-color', newval);
        });
    });

    // UM WooCommerce - Product Price Color
    wp.customize('customization[um_theme_ext_woo_product_price_color]', function(value) {
        value.bind(function(newval) {
            $('span.um-woo-grid-price').css('color', newval);
        });
    });

    // UM WooCommerce - Product Title Color
    wp.customize('customization[um_theme_ext_woo_product_title_color]', function(value) {
        value.bind(function(newval) {
            $('.um-woo-grid-title a').css('color', newval);
        });
    });

    // UM WooCommerce - Product Review Color
    wp.customize('customization[um_theme_ext_woo_product_review_color]', function(value) {
        value.bind(function(newval) {
            $('.um-woo-grid-content').css('color', newval);
        });
    });

    // UM User Tags - Tags Hover Background Color
    wp.customize('customization[um_theme_ext_tags_hover_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.um-user-tag:hover,.um-user-tag:focus,.um-user-tag:active,.um-user-tag.active').css('color', newval);
        });
    });

    // UM User Tags - Tags Hover Text Color
    wp.customize('customization[um_theme_ext_tags_hover_border_color]', function(value) {
        value.bind(function(newval) {
            $('.um-woo-grid-content').css('border-color', newval);
        });
    });

    // UM User Tags - Tags Background Color
    wp.customize('customization[um_theme_ext_tags_bg_color]', function(value) {
        value.bind(function(newval) {
            $('.um-user-tag').css('background-color', newval);
        });
    });

    // UM User Tags - Tags Border Color
    wp.customize('customization[um_theme_ext_tags_border_color]', function(value) {
        value.bind(function(newval) {
            $('.um-user-tag').css('border-color', newval);
        });
    });

    // UM User Tags - Tags Hover Text Color
    wp.customize('customization[um_theme_ext_tags_hover_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um-user-tag:hover a,.um-user-tag a:hover').css('color', newval);
        });
    });

    // UM User Tags - Tags Text Color
    wp.customize('customization[um_theme_ext_tags_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um-user-tag a').css('color', newval);
        });
    });

    // UM Profile Completeness - Empty Bar Color
    wp.customize('customization[um_theme_ext_profile_empty_bar_color]', function(value) {
        value.bind(function(newval) {
            $('.um-user-tag').css('background-color', newval);
        });
    });

    // UM Profile Completeness - Complete Bar Color
    wp.customize('customization[um_theme_ext_profile_complete_bar_color]', function(value) {
        value.bind(function(newval) {
            $('.um-user-tag').css('background-color', newval);
        });
    });

    // UM User Reviews - Review Complete Bar Color
    wp.customize('customization[um_theme_ext_reviews_bar_color]', function(value) {
        value.bind(function(newval) {
            $('.um-reviews-d-p span').css('background-color', newval);
        });
    });

    // UM User Reviews - Review Empty Bar Color
    wp.customize('customization[um_theme_ext_reviews_empty_bar_color]', function(value) {
        value.bind(function(newval) {
            $('.um-reviews-d-p').css('background-color', newval);
        });
    });

    // UM User Reviews - Review Title Color
    wp.customize('customization[um_theme_ext_reviews_single_title_color]', function(value) {
        value.bind(function(newval) {
            $('div.um .um-form div.um-reviews-post .um-reviews-title').css('color', newval);
        });
    });

    // UM User Reviews - Review Section Header
    wp.customize('customization[um_theme_ext_reviews_section_title_color]', function(value) {
        value.bind(function(newval) {
            $('.um-reviews-header').css('color', newval);
        });
    });

    // UM User Reviews - User Review Star Color
    wp.customize('customization[um_theme_ext_reviews_star_color]', function(value) {
        value.bind(function(newval) {
            $('span.um-reviews-avg i,span.um-reviews-rate i').css('color', newval);
        });
    });

    // UM Followers - Meta Color
    wp.customize('customization[um_theme_ext_followers_meta_color]', function(value) {
        value.bind(function(newval) {
            $('.um-followers-user-span,.um-followers-rc a').css('color', newval);
        });
    });

    // UM Followers - Follower Count Color
    wp.customize('customization[um_theme_ext_followers_count_color]', function(value) {
        value.bind(function(newval) {
            $('.um-followers-rc a span').css('color', newval);
        });
    });

    // UM Verified User - Verified Icon Color
    wp.customize('customization[um_theme_ext_verified_icon_color]', function(value) {
        value.bind(function(newval) {
            $('.um-verified').css('color', newval);
        });
    });

    // UM User Bookmarks - Bookmark Button Color
    wp.customize('customization[um_theme_user_bookmarks_button_color]', function(value) {
        value.bind(function(newval) {
            $('.um-user-bookmarks-add-button').css('background-color', newval);
        });
    });

    // UM User Bookmarks - Bookmark Button Text Color
    wp.customize('customization[um_theme_user_bookmarks_button_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um-user-bookmarks-add-button').css('color', newval);
        });
    });

    // UM User Bookmarks - Bookmark Remove Button Color
    wp.customize('customization[um_theme_user_bookmarks_remove_button_color]', function(value) {
        value.bind(function(newval) {
            $('.um-user-bookmarks-profile-remove-link,.um-user-bookmarks-remove-button').css('background-color', newval);
        });
    });

    // UM User Bookmarks - Bookmark Remove Button Text Color
    wp.customize('customization[um_theme_user_bookmarks_remove_button_text_color]', function(value) {
        value.bind(function(newval) {
            $('.um-user-bookmarks-profile-remove-link,.um-user-bookmarks-remove-button').css('color', newval);
        });
    });

    // UM User Bookmarks - Modal Background Color
    wp.customize('customization[um_theme_user_bookmarks_modal_bg]', function(value) {
        value.bind(function(newval) {
            $('.um-user-bookmarks-modal .um-user-bookmarks-modal-content').css('background-color', newval);
        });
    });

    // UM User Bookmarks - Modal Text Color
    wp.customize('customization[um_theme_user_bookmarks_modal_text]', function(value) {
        value.bind(function(newval) {
            $('.um-user-bookmarks-modal .um-user-bookmarks-modal-content').css('color', newval);
        });
    });

    // UM User Notes - Notes Color
    wp.customize('customization[um_theme_user_notes_color]', function(value) {
        value.bind(function(newval) {
            $('.note-block').css('background-color', newval);
        });
    });

    // UM User Notes - Notes Text Color
    wp.customize('customization[um_theme_user_notes_text_color]', function(value) {
        value.bind(function(newval) {
            $('.note-block').css('color', newval);
        });
    });

})(jQuery);