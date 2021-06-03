<?php
/**
 * Dynamic CSS from Customizer settings
 *
 * @package     um-theme
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
if ( ! function_exists( 'um_theme_customize_preview_js' ) ) {
	function um_theme_customize_preview_js() {
		wp_enqueue_script( 'um_theme_customizer', get_theme_file_uri( '/inc/js/customizer.js' ), array( 'customize-preview' ), UM_THEME_VERSION , true );
	}
}

/**
 * Loads Customizer customizations
 */
if ( ! function_exists( 'um_theme_customizer_head_styles' ) ) {
	function um_theme_customizer_head_styles() {
		/**
		 * Return CSS Output
		 *
		 * @return string Generated CSS.
		 */

		global $defaults;
		/**
		 * - Variable Declaration
		 */

		// Width
		$canvas_width 								= esc_attr( $defaults['um_theme_canvas_width'] );
		$header_width 								= esc_attr( $defaults['um_theme_header_width'] );
		$um_header_padding_setting 					= $defaults['um_header_padding_setting'];

		// General Color Options
		$logo_text_color 							= get_header_textcolor();
		$logo_hover_color 							= sanitize_hex_color( $defaults['um_theme_logo_hover_color'] );
		$body_text_color 							= sanitize_hex_color( $defaults['body_text_color'] );
		$primary_color								= sanitize_hex_color( $defaults['um_theme_primary_color'] );
		$website_meta								= sanitize_hex_color( $defaults['um_theme_website_meta_color'] );
		$title_text_color 							= sanitize_hex_color( $defaults['title_text_color'] );
		$menu_text_color 							= sanitize_hex_color( $defaults['menu_text_color'] );
		$link_text_color 							= sanitize_hex_color( $defaults['link_text_color'] );
		$link_hover_color 							= sanitize_hex_color( $defaults['link_hover_color'] );
		$button_text_color 							= sanitize_hex_color( $defaults['button_text_color'] );
		$button_hover_color 						= sanitize_hex_color( $defaults['button_hover_color'] );
		$login_button_color 						= sanitize_hex_color( $defaults['header_login_button_color'] );
		$login_text_color 							= sanitize_hex_color( $defaults['header_login_text_color'] );
		$reg_button_border_color 					= sanitize_hex_color( $defaults['um_theme_reg_button_border_color'] );
		$log_button_border_color 					= sanitize_hex_color( $defaults['um_theme_login_button_border_color'] );
		$register_button_color 						= sanitize_hex_color( $defaults['header_log_button_two_color'] );
		$register_text_color 						= sanitize_hex_color( $defaults['header_log_button_two_text_color'] );
		$topbar_background_color 					= sanitize_hex_color( $defaults['header_topbar_background_color'] );
		$topbar_menu_color 							= sanitize_hex_color( $defaults['header_topbar_menu_color'] );
		$topbar_text_color 							= sanitize_hex_color( $defaults['header_topbar_text_color'] );
		$header_background_color 					= sanitize_hex_color( $defaults['header_background_color'] );
		$footer_menu_font_color 					= sanitize_hex_color( $defaults['footer_menu_color'] );
		$footer_background_color 					= sanitize_hex_color( $defaults['footer_background_color'] );
		$footer_text_color 							= sanitize_hex_color( $defaults['footer_text_color'] );
		$footer_link_color 							= sanitize_hex_color( $defaults['footer_link_color'] );
		$footer_link_hover_color 					= sanitize_hex_color( $defaults['footer_link_hover_color'] );
		$footer_widget_bg_color 					= sanitize_hex_color( $defaults['um_theme_footer_widget_bg_color'] );
		$footer_widget_color 						= sanitize_hex_color( $defaults['um_theme_footer_widget_color'] );
		$footer_widget_link_color 					= sanitize_hex_color( $defaults['um_theme_footer_widget_link_color'] );
		$bottombar_background_color 				= sanitize_hex_color( $defaults['header_bottombar_background_color'] );
		$bottombar_menu_color 						= sanitize_hex_color( $defaults['header_bottombar_menu_color'] );
		$bottombar_text_color 						= sanitize_hex_color( $defaults['header_bottombar_text_color'] );
		$social_accounts_color 						= sanitize_hex_color( $defaults['social_accounts_color'] );
		$button_border_color 						= sanitize_hex_color( $defaults['button_border_color'] );
		$bottom_onclick_color 						= sanitize_hex_color( $defaults['header_bottombar_onclick_icon_color'] );
		$social_accounts_hover_color 				= sanitize_hex_color( $defaults['social_accounts_hover_color'] );
		$header_search_text_color 					= sanitize_hex_color( $defaults['header_search_text_color'] );
		$bottom_onclick_hover_color 				= sanitize_hex_color( $defaults['header_bottombar_onclick_icon_hover_color'] );
		$template_blog_post_bg_color 				= sanitize_hex_color( $defaults['um_theme_blog_post_bg_color'] );
		$menu_text_hover_color 						= sanitize_hex_color( $defaults['menu_text_hover_color'] );
		$widget_background_color 					= sanitize_hex_color( $defaults['widgets_background_color'] );
		$button_background_color 					= sanitize_hex_color( $defaults['button_background_color'] );
		$button_hover_text_color 					= sanitize_hex_color( $defaults['button_hover_text_color'] );
		$template_blog_post_content_color 			= sanitize_hex_color( $defaults['um_theme_blog_post_content_color'] );
		$footer_widget_link_hover_color 			= sanitize_hex_color( $defaults['um_theme_footer_widget_link_hover_color'] );
		$header_search_background_color 			= sanitize_hex_color( $defaults['header_search_background_color'] );
		$header_logged_out_btn_one_hover_color 		= sanitize_hex_color( $defaults['um_header_logged_out_button_one_hover_bg'] );
		$header_logged_out_btn_one_hover_text 		= sanitize_hex_color( $defaults['um_header_logged_out_button_one_hover_text'] );
		$header_logged_out_btn_two_hover_color 		= sanitize_hex_color( $defaults['um_header_logged_out_button_two_hover_bg'] );
		$header_logged_out_btn_two_hover_text 		= sanitize_hex_color( $defaults['um_header_logged_out_button_two_hover_text'] );
		$header_search_placeholder_text_color 		= sanitize_hex_color( $defaults['header_search_placeholder_text_color'] );

		// Typography
		$footer_menu_font_size 						= esc_attr( $defaults['footer_menu_font_size'] );
		$topbar_font_size 							= esc_attr( $defaults['header_topbar_menu_font_size'] );
		$widget_title_alignment						= esc_attr( $defaults['um_theme_widget_title_alignment'] );
		$title_font_weight							= esc_attr( $defaults['um_theme_title_weight'] );
		$body_font_weight							= esc_attr( $defaults['um_theme_body_weight'] );
		$nav_font_weight							= esc_attr( $defaults['um_theme_nav_weight'] );
		$logo_font_weight							= esc_attr( $defaults['um_theme_logo_weight'] );
		$body_font_size								= esc_attr( $defaults['um_theme_body_font_size'] );
		$menu_font_size								= esc_attr( $defaults['um_theme_menu_font_size'] );
		$bottom_bar_font_size 						= esc_attr( $defaults['header_bottombar_menu_font_size'] );
		$logo_font_size								= esc_attr( $defaults['um_theme_logo_font_size'] );
		$element_title_capitalization				= esc_attr( $defaults['um_theme_title_capitalization'] );

		// Buttons styling
		$footer_widget_align						= esc_attr( $defaults['um_theme_footer_widget_alignment'] );
		$button_border_width						= esc_attr( $defaults['um_theme_button_border_width'] );
		$button_border_radius						= esc_attr( $defaults['um_theme_button_border_radius'] );
		$button_font_size							= esc_attr( $defaults['um_theme_button_font_size'] );
		$button_font_weight							= esc_attr( $defaults['um_theme_button_weight'] );
		$button_text_transform						= esc_attr( $defaults['um_theme_button_transform'] );
		$bottom_onclick_font_size					= esc_attr( $defaults['header_bottombar_onclick_icon_size'] );
		$reg_button_border_width					= esc_attr( $defaults['um_theme_reg_button_border_width'] );
		$log_button_border_width					= esc_attr( $defaults['um_theme_login_button_border_width'] );
		$search_border_radius 						= esc_attr( $defaults['header_search_border_radius'] );

		//bbPress
		$bb_sticky_bg 								= sanitize_hex_color( $defaults['um_bb_sticky_topic_bg_color'] );
		$bb_notification_bg 						= sanitize_hex_color( $defaults['um_bb_notice_bg_color'] );
		$bb_notification_text 						= sanitize_hex_color( $defaults['um_bb_notice_text_color'] );
		$bb_notification_border 					= sanitize_hex_color( $defaults['um_bb_notice_border_color'] );
		$bb_forum_head_bg 							= sanitize_hex_color( $defaults['um_bb_forum_header_bg_color'] );
		$bb_forum_head_text 						= sanitize_hex_color( $defaults['um_bb_forum_header_text_color'] );
		$bb_forum_head_border 						= sanitize_hex_color( $defaults['um_bb_forum_header_border_color'] );
		$bb_author_name_color 						= sanitize_hex_color( $defaults['um_bb_forum_author_name_color'] );
		$bb_title_color 							= sanitize_hex_color( $defaults['um_bb_forum_title_color'] );
		$bb_text_color 								= sanitize_hex_color( $defaults['um_bb_forum_text_color'] );
		$bb_title_font_size 						= esc_attr( $defaults['um_bb_forum_title_font_size'] );

		// WooCommerce
		$woo_price_color 							= sanitize_hex_color( $defaults['um_theme_woocommerce_price_color'] );
		$woo_product_title_color 					= sanitize_hex_color( $defaults['um_theme_woocommerce_product_title_color'] );
		$woo_add_cart_button 						= sanitize_hex_color( $defaults['um_theme_woocommerce_add_cart_button_color'] );
		$woo_add_cart_button_text 					= sanitize_hex_color( $defaults['um_theme_woocommerce_add_cart_button_text'] );
		$woo_sale_badge 							= sanitize_hex_color( $defaults['um_theme_woocommerce_sale_badge_color'] );
		$woo_sale_badge_text 						= sanitize_hex_color( $defaults['um_theme_woocommerce_sale_badge_text'] );

		// Ultimate Member
		$um_post_single_box_bg 						= sanitize_hex_color( $defaults['um_post_single_box_bg'] );
		$um_post_single_box_text_color 				= sanitize_hex_color( $defaults['um_post_single_box_text_color'] );
		$um_ext_pm_text_color 						= sanitize_hex_color( $defaults['um_theme_ext_pm_message_text_color'] );
		$um_ext_pm_bg_color 						= sanitize_hex_color( $defaults['um_theme_ext_pm_message_bg_color'] );
		$um_ext_pm_button_bg_color 					= sanitize_hex_color( $defaults['um_theme_ext_pm_message_button_color'] );
		$um_ext_pm_button_text_color 				= sanitize_hex_color( $defaults['um_theme_ext_pm_message_button_text_color'] );
		$template_profile_nav_bar_color 			= sanitize_hex_color( $defaults['um_theme_template_profile_nav_bar_color'] );
		$template_profile_nav_menu_color 			= sanitize_hex_color( $defaults['um_theme_template_profile_nav_menu_color'] );
		$header_notification_hover_color 			= sanitize_hex_color( $defaults['header_notification_hover_color'] );
		$header_friend_req_hover_color 				= sanitize_hex_color( $defaults['header_friend_req_hover_color'] );
		$um_theme_form_field_border_color 			= sanitize_hex_color( $defaults['um_theme_form_field_border_color'] );
		$um_theme_form_field_text_color 			= sanitize_hex_color( $defaults['um_theme_form_field_text_color'] );
		$friend_req_bubble_color 					= sanitize_hex_color( $defaults['header_friend_req_bubble_color'] );
		$friend_req_bubble_bg_color 				= sanitize_hex_color( $defaults['header_friend_req_bubble_bg_color'] );
		$notification_bubble_bg_color 				= sanitize_hex_color( $defaults['header_notification_bubble_bg_color'] );
		$notification_bubble_color 					= sanitize_hex_color( $defaults['header_notification_bubble_color'] );
		$header_private_message_color 				= sanitize_hex_color( $defaults['header_private_message_color'] );
		$header_notification_color 					= sanitize_hex_color( $defaults['header_notification_color'] );
		$header_friend_req_color 					= sanitize_hex_color( $defaults['header_friend_req_color'] );
		$member_box_bg_color 						= sanitize_hex_color( $defaults['um_theme_member_directory_box_bg_color'] );
		$member_box_text_color 						= sanitize_hex_color( $defaults['um_theme_member_directory_box_text_color'] );
		$profile_border_radius 						= esc_attr( $defaults['header_profile_border_radius'] );
		$template_profile_content_area_text_color 	= sanitize_hex_color( $defaults['um_theme_template_profile_content_area_text_color'] );
		$template_profile_single_area_text_color 	= sanitize_hex_color( $defaults['um_theme_profile_single_text_color'] );
		$header_private_message_hover_color 		= sanitize_hex_color( $defaults['header_private_message_hover_color'] );
		$template_profile_content_area_color 		= sanitize_hex_color( $defaults['um_theme_template_profile_content_area_color'] );
		$template_profile_single_area_color 		= sanitize_hex_color( $defaults['um_theme_template_profile_single_container_color'] );
		$template_profile_sidebar_area_color 		= sanitize_hex_color( $defaults['um_theme_template_profile_sidebar_container_color'] );
		$template_profile_field_label_color 		= sanitize_hex_color( $defaults['um_theme_template_profile_field_label_color'] );
		$um_theme_form_field_background_color 		= sanitize_hex_color( $defaults['um_theme_form_field_background_color'] );
		$um_theme_form_field_border_focus_color 	= sanitize_hex_color( $defaults['um_theme_form_field_border_focus_color'] );
		$um_theme_form_field_error_text_color 		= sanitize_hex_color( $defaults['um_theme_form_field_error_text_color'] );
		$um_theme_form_field_error_bg_color 		= sanitize_hex_color( $defaults['um_theme_form_field_error_bg_color'] );
		$um_theme_form_field_label_text_color 		= sanitize_hex_color( $defaults['um_theme_form_field_label_text_color'] );
		$template_profile_nav_menu_hover_color 		= sanitize_hex_color( $defaults['um_theme_template_profile_nav_menu_hover_color'] );
		$template_profile_nav_menu_bg_hover_color 	= sanitize_hex_color( $defaults['um_theme_template_profile_nav_menu_bg_hover_color'] );

		$css = '';

		if ( true === wp_validate_boolean( $defaults['um_enable_font_smoothing'] )) :
			$css .= 'html,* {-webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;}';
		endif;

		$css .= '.um-header-avatar img{
			    width:' .  $defaults['header_profile_avatar_size']. 'px;
    			height:' .  $defaults['header_profile_avatar_size']. 'px;
		}';

		$css .= '
			body,
			button,
			input,
			select,
			textarea{
				font-family: "' . esc_attr( get_theme_mod( 'um_theme_typography_body_font', 'Open Sans' ) ). '", sans-serif;
				font-size:' . esc_attr( $body_font_size ) . ';
				color:' . sanitize_hex_color( $body_text_color ) . ';
				font-weight:' . esc_attr( $body_font_weight ) . ';
			}

			.body-font-family{ font-family: "' . esc_attr( get_theme_mod( 'um_theme_typography_body_font', 'Open Sans' ) ). '", sans-serif; }
			body{ background-color: #' . get_theme_mod( 'background_color', 'f6f9fc' ). '; }
			h1{font-size: ' .  esc_attr( $defaults['body_h1_size'] ) . ';}
			h2{font-size: ' .  esc_attr( $defaults['body_h2_size'] ) . ';}
			h3{font-size: ' .  esc_attr( $defaults['body_h3_size'] ) . ';}
			h4{font-size: ' .  esc_attr( $defaults['body_h4_size'] ) . ';}
			h5{font-size: ' .  esc_attr( $defaults['body_h5_size'] ) . ';}
			h6{font-size: ' .  esc_attr( $defaults['body_h6_size'] ) . ';}

			h1, h2, h3, h4, h5, h6{
				font-family: "' .  esc_attr( get_theme_mod( 'um_theme_typography_title_font', 'Open Sans' ) ) . '",sans-serif;
				font-weight:' .  esc_attr( $title_font_weight ) . ';
				color: ' .  sanitize_hex_color( $title_text_color ) . ';
				text-transform: ' .  esc_attr( $element_title_capitalization ) . ';
			}

			.site-title a{
				font-family: "' .  esc_attr( get_theme_mod( 'um_theme_typography_logo_font', 'Open Sans' ) ) . '",sans-serif;
				font-size:' .  esc_attr( $logo_font_size ) . ';
				font-weight:' .  esc_attr( $logo_font_weight ) . ';
				color: #' .   $logo_text_color . ';
			}

			.site-title a:hover{ color: ' . sanitize_hex_color( $logo_hover_color ) . ';}

			.website-canvas{max-width:' . esc_attr( $canvas_width ) . ';}
			.header-inner{max-width:' . esc_attr( $header_width ) . ';}

			.single-article-content,
			.comment-list .comment.depth-1{
			    background-color: ' . sanitize_hex_color( $um_post_single_box_bg ) . ';
			    color: ' . sanitize_hex_color( $um_post_single_box_text_color ) . ';
			}

			.template-blog .blog-post-container{background-color:' . sanitize_hex_color( $template_blog_post_bg_color ) . ';}

			.template-blog .excerpt,
			.template-blog .excerpt-list,
			.template-blog .blog-post-container{
			    color: ' . sanitize_hex_color( $template_blog_post_content_color ) . ';
			}

			.template-blog .entry-title a{color:' .  sanitize_hex_color( $defaults['um_theme_blog_post_title_color'] ) . ';}

			.meta-tag a{
				background-color:' . sanitize_hex_color( $defaults['um_post_tag_box_bg'] ) . ';
				color:' . sanitize_hex_color( $defaults['um_post_tag_text_color'] ) . ';
			}

			.um-button,
			.btn,
			.comment-form input[type=submit],
			.site-search form input[type=submit]{
				font-family: "' . esc_attr( get_theme_mod( 'um_theme_typography_button_font', 'Open Sans' ) ) . '",sans-serif;
				background-color:' . sanitize_hex_color( $button_background_color ) . ';
				color:' . sanitize_hex_color( $button_text_color ) . ';
				border-radius:' . esc_attr( $button_border_radius ) . ';
				font-size:' . esc_attr( $button_font_size ) . ';
				font-weight:' . esc_attr( $button_font_weight ) . ';
				text-transform:' . esc_attr( $button_text_transform ) . ';
			}

			.btn:active,
			.btn:hover,
			.comment-form input[type=submit]:hover,
			.site-search form input[type=submit]:hover{
				background-color:' . sanitize_hex_color( $button_hover_color ) . ';
				color:' . sanitize_hex_color( $button_hover_text_color ) . ';
			}

			.profile-float-bar,.site-header{
				background-color:' . sanitize_hex_color( $header_background_color ) . ';
			}

			.header-container{
				padding:' . esc_attr( $um_header_padding_setting ) . ';
			}

			.header-button-1 {
				background-color:' . sanitize_hex_color( $login_button_color ) . ';
				color:' . sanitize_hex_color( $login_text_color ) . ';
			}

			.header-button-1:hover {
				background-color:' . sanitize_hex_color( $header_logged_out_btn_one_hover_color ) . ';
				color:' . sanitize_hex_color( $header_logged_out_btn_one_hover_text ) . ';
			}

			.header-button-2 {
				background-color:' . sanitize_hex_color( $register_button_color ) . ';
				color:' . sanitize_hex_color( $register_text_color ) . ';
			}

			.header-button-2:hover {
				background-color:' . sanitize_hex_color( $header_logged_out_btn_two_hover_color ) . ';
				color:' . sanitize_hex_color( $header_logged_out_btn_two_hover_text ) . ';
			}

			.outer-section-profile-container .inner-section-profile-container a,
			.um-header-avatar-name a,
			#bs-navbar-profile a,
			#bs-navbar-primary a,
			#bs-navbar-primary{
				font-family: "' .  esc_attr( get_theme_mod( 'um_theme_typography_nav_font', 'Open Sans' ) ) . '",sans-serif;
				font-weight:' .  esc_attr( $nav_font_weight ) . ';
				color:' .  sanitize_hex_color( $menu_text_color ) . ';
				font-size:' . esc_attr( $menu_font_size ) . ';
			}

			.um-header-avatar-name .fa-angle-down{ color:' .  sanitize_hex_color( $menu_text_color ) . ';}
			#bs-navbar-profile a:hover,#bs-navbar-primary a:hover{ color: ' . sanitize_hex_color( $menu_text_hover_color ) . ';}

			#bs-navbar-primary .current-menu-item a{
			    background-color:' .  sanitize_hex_color( $defaults['selected_menu_bg_color'] ) . ';
			    color:' .  sanitize_hex_color( $defaults['selected_menu_text_color'] ) . ' !important;
			}

			.inner-section-profile-container .dropdown-menu,
			.outer-section-profile-container .inner-section-profile-container{
				background-color: ' . sanitize_hex_color( $defaults['um_theme_submenu_background_color'] ) . '!important;
			}

			.dropdown-item,
			.outer-section-profile-container .inner-section-profile-container a{
				color:' . sanitize_hex_color( $defaults['um_theme_submenu_text_color'] ) . '!important;
			}

			@media screen and (max-width: 550px) {
				#bs-navbar-primary {
	    			background-color: ' . sanitize_hex_color( $defaults['um_theme_submenu_background_color'] ) . ';
	    			color: ' . sanitize_hex_color( $defaults['um_theme_submenu_text_color'] ) . ';
				}
			}

			.site-footer-layout-sidebar .widget-title,
			.footer-sidebar-column-one,
			.footer-sidebar-column-two,
			.footer-sidebar-column-three,
			.footer-sidebar-column-four{
				text-align:' . esc_attr( $footer_widget_align ) . ';}

			.site-footer-layout-sidebar {background-color:' . sanitize_hex_color( $footer_widget_bg_color ) . ';}

			.footer-sidebar-column-one,
			.footer-sidebar-column-two,
			.footer-sidebar-column-three,
			.footer-sidebar-column-four {
			    color:' . sanitize_hex_color( $footer_widget_color ) . ';
			}

			.footer-sidebar-column-one a,
			.footer-sidebar-column-two a,
			.footer-sidebar-column-three a,
			.footer-sidebar-column-four a{
			    color:' . sanitize_hex_color( $footer_widget_link_color ) . ';
			}

			.footer-sidebar-column-one a:hover,
			.footer-sidebar-column-two a:hover,
			.footer-sidebar-column-three a:hover,
			.footer-sidebar-column-four a:hover{
			    color:' . sanitize_hex_color( $footer_widget_link_hover_color ) . ';
			}

			.site-footer-layout-text{
				background-color:' . sanitize_hex_color( $footer_background_color ) . ';
				color:' . sanitize_hex_color( $footer_text_color ) . ';
				font-size:' . esc_attr( $footer_menu_font_size ) . ';
			}

			.site-footer-layout-text a{color:' . sanitize_hex_color( $footer_link_color ) . ';}
			.site-footer-layout-text a:hover{color:' . sanitize_hex_color( $footer_link_hover_color ) . ';}

			#bs-navbar-footer a,
			#bs-navbar-footer li{
				color:' . sanitize_hex_color( $footer_menu_font_color ) . ';
				font-size:' . esc_attr( $footer_menu_font_size ) . ';
			}

			.um-theme-social-link a{color:' .  sanitize_hex_color( $social_accounts_color ) . ';}
			.um-theme-social-link a:hover{color:' .  sanitize_hex_color( $social_accounts_hover_color ) . ';}
			.scrollToTop{color:' .  sanitize_hex_color( $primary_color ) . ';}
			.adverts-single-author-name,.meta,.post-meta__time,.single.post-meta,.post-meta__author{color:' . sanitize_hex_color( $website_meta ) . ';}
			.post-meta__tag__item a:before{background-color:' . sanitize_hex_color( $website_meta ) . ';}
			a{color:' . sanitize_hex_color( $link_text_color ) . ';}
			a:hover,a:focus,a:active{color:' . sanitize_hex_color( $link_hover_color ) . ';}
			.widget-title{text-align:' . esc_attr( $widget_title_alignment ) . ';}
			#secondary .widget{background-color:' . sanitize_hex_color( $widget_background_color ) . ';}
			.bottom-t-m-ico {font-size:' .  esc_attr( $bottom_onclick_font_size ) . ';color:' . sanitize_hex_color( $bottom_onclick_color ) . ';}
			.bottom-t-m-ico:hover {color:' . sanitize_hex_color( $bottom_onclick_hover_color ) . ';}
			.um-friend-tick,.um-notification-ico,.um-msg-tik-ico{font-size:' . $defaults['header_profile_icon_font_size'] . ';}
		';


		if ( $defaults['um_theme_button_border_enable'] === 1 ) :
			$css .= '
				.btn,
				.comment-form input[type=submit],
				.site-search form input[type=submit]{
					border:' . esc_attr( $button_border_width ) . ' solid ' .  sanitize_hex_color( $button_border_color ) . ';
				}
			';
		endif;

		if ( $defaults['um_theme_login_button_border_enable'] === 1 ) :
			$css .= '.header-button-1{border:' . esc_attr( $log_button_border_width ) . ' solid ' . sanitize_hex_color( $log_button_border_color ) . ';}';
		else :
			$css .= '.header-button-1{border:none;}';
		endif;

		if ( $defaults['um_theme_reg_button_border_enable'] === 1 ) :
			$css .= '.header-button-2{border:' . esc_attr( $reg_button_border_width ) . ' solid ' . sanitize_hex_color( $reg_button_border_color ) . ';}';
		else :
			$css .= '.header-button-2{border:none;}';
		endif;

		if ( $defaults['um_show_topbar'] === 2 || $defaults['um_show_topbar'] === 3 ) :
			$css .='
			.header-top-bar .dropdown-menu,.header-top-bar{ background-color:' .  sanitize_hex_color( $topbar_background_color ) . ';}
			.topbar-container .um-theme-social-link a{font-size:' .  esc_attr( $defaults['header_topbar_icon_font_size'] ) . ';}
			.um-header-topbar-text{color:' .  sanitize_hex_color( $topbar_text_color ) . '; font-size:' .  esc_attr( $topbar_font_size ) . ';}
			.topbar-container a,#bs-navbar-topbar a,#bs-navbar-topbar{ color:' .  sanitize_hex_color( $topbar_menu_color ) . '; font-size:' .  esc_attr( $topbar_font_size ) . ';}
			.topbar-container a:hover,#bs-navbar-topbar a:hover{color:' .  sanitize_hex_color( $defaults['header_topbar_link_hover_color'] ) . ';}
			';
		endif;

		if ( $defaults['um_show_bottombar'] === 1 || $defaults['um_show_bottombar'] === 3 ) :
			$css .='
				.header-bottom-bar .dropdown-menu,.header-bottom-bar{background-color:' .  sanitize_hex_color( $bottombar_background_color ) . ' !important;}
				.header-bottom-bar,#bs-navbar-bottombar a,#bs-navbar-bottombar li{color:' .  sanitize_hex_color( $bottombar_menu_color ) . '!important; font-size:' .  esc_attr( $bottom_bar_font_size ) . ';}
				.um-header-bottom-text{color:' .  sanitize_hex_color( $bottombar_text_color ) . '; font-size:' .  esc_attr( $bottom_bar_font_size ) . ';}
			';
		endif;

		if ( $defaults['um_show_header_search'] === 1 || $defaults['um_show_header_search'] === 2 ) :
			$css .='
				.header-search .um-search-field,
				.header-search #search-form-input{
					background-color:' . sanitize_hex_color( $header_search_background_color ) . ';
					color:' . sanitize_hex_color( $header_search_text_color ) . ';
					border-radius:' . esc_attr( $search_border_radius ) . ';
				}

				.header-inner .um-search-field ::placeholder,
				.header-inner .search-form ::placeholder{
					color:' . sanitize_hex_color( $header_search_placeholder_text_color ) . ';
				}
			';
		endif;

		if ( $defaults['um_theme_submenu_arrow'] === 2 ) :
			$css .='
				.outer-section-profile-container .fa-angle-down,.dropdown-toggle::after{
					display:none;
				}
			';
		endif;

		// LifterLMS
		if ( class_exists( 'LifterLMS' ) ) :

			$css .='

				.llms-button-primary {
					background-color:' .  sanitize_hex_color( $defaults['um_theme_lifter_primary_button_color'] ) . ';
					color:' .  sanitize_hex_color( $defaults['um_theme_lifter_primary_button_text_color'] ) . ';
				}

				.llms-button-primary:hover {
					background-color:' . sanitize_hex_color( $defaults['um_theme_lifter_primary_button_hover_color'] ) . ';
					color:' . sanitize_hex_color( $defaults['um_theme_lifter_primary_button_hover_text_color'] ) . ';
				}

				.llms-button-secondary{
					background-color:' . sanitize_hex_color( $defaults['um_theme_lifter_secondary_button_color'] ) . ';
					color:' . sanitize_hex_color( $defaults['um_theme_lifter_secondary_button_text_color'] ) . ';
				}

				.llms-button-secondary:hover{
					background-color:' . sanitize_hex_color( $defaults['um_theme_lifter_secondary_button_hover_color'] ) . ';
					color:' . sanitize_hex_color( $defaults['um_theme_lifter_secondary_button_hover_text_color'] ) . ';
				}

				.llms-access-plan-title,
				.llms-access-plan .stamp{
					background-color:' . sanitize_hex_color( $defaults['um_theme_lifter_plan_title_bg_color'] ) . ';
					color:' . sanitize_hex_color( $defaults['um_theme_lifter_plan_title_color'] ) . ';
				}

				.llms-access-plan.featured .llms-access-plan-featured{
					background-color:' . sanitize_hex_color( $defaults['um_theme_lifter_plan_featured_bg_color'] ) . ';
					color:' . sanitize_hex_color( $defaults['um_theme_lifter_plan_featured_color'] ) . ';
				}

				.llms-access-plan.featured .llms-access-plan-content,
				.llms-access-plan.featured .llms-access-plan-footer{
					border-left-color:' . sanitize_hex_color( $defaults['um_theme_lifter_plan_featured_bg_color'] ) . ';
					border-right-color:' . sanitize_hex_color( $defaults['um_theme_lifter_plan_featured_color'] ) . ';
				}

				.llms-access-plan.featured .llms-access-plan-footer {
					border-bottom-color:' . sanitize_hex_color( $defaults['um_theme_lifter_plan_featured_color'] ) . ';
				}

				.llms-access-plan-restrictions a {
					color:' . sanitize_hex_color( $defaults['um_theme_lifter_plan_restriction_link_color'] ) . ';
				}

				.llms-access-plan-restrictions a:hover {
					color:' . sanitize_hex_color( $defaults['um_theme_lifter_plan_restriction_link_hover_color'] ) . ';
				}

				.llms-checkout-wrapper .llms-form-heading {
					background-color:' . sanitize_hex_color( $defaults['um_theme_lifter_checkout_heading_bg_color'] ) . ';
					color:' . sanitize_hex_color( $defaults['um_theme_lifter_checkout_heading_color'] ) . ';
				}

				.llms-checkout-section,
				.llms-checkout-wrapper form.llms-login {
					border-color:' . sanitize_hex_color( $defaults['um_theme_lifter_checkout_border_color'] ) . ';
				}
				';
		endif;

		// Ultimate Member
		if ( class_exists( 'UM' ) ) :

			$css .='
				.um a.um-link:hover,
				.um a.um-link-hvr:hover,
				.um .um-tip:hover,
				.um .um-field-radio.active:not(.um-field-radio-state-disabled) i,
				.um .um-field-checkbox.active:not(.um-field-radio-state-disabled) i,
				.um .um-member-name a:hover,
				.um .um-member-more a:hover,
				.um .um-member-less a:hover,
				.um .um-members-pagi a:hover,
				.um .um-cover-add:hover,
				.um .um-profile-subnav a.active,
				.um .um-item-meta a,
				.um-account-name a:hover,
				.um-account-nav a.current,
				.um-account-side li a.current span.um-account-icon,
				.um-account-side li a.current:hover span.um-account-icon,
				.um-dropdown li a:hover,
				i.um-active-color,
				span.um-active-color,
				.um a.um-link,
				.um-profile.um .um-profile-headericon a:hover,
				.um-profile.um .um-profile-edit-a.active,
				.um-accent-color{
					color:' . sanitize_hex_color( $defaults['um_theme_um_plug_accent_color'] ) . ';
				}

				.um .um-field-group-head:hover,
				.picker__footer,
				.picker__header,
				.picker__day--infocus:hover,
				.picker__day--outfocus:hover,
				.picker__day--highlighted:hover,
				.picker--focused .picker__day--highlighted,
				.picker__list-item:hover,
				.picker__list-item--highlighted:hover,
				.picker--focused .picker__list-item--highlighted,
				.picker__list-item--selected,
				.picker__list-item--selected:hover,
				.picker--focused .picker__list-item--selected,
				.um .um-field-group-head,
				.picker__box,
				.picker__nav--prev:hover,
				.picker__nav--next:hover,
				.um .um-members-pagi span.current,
				.um .um-members-pagi span.current:hover,
				.um .um-profile-nav-item.active a,
				.um .um-profile-nav-item.active a:hover,
				.upload,
				.um-modal-header,
				.um-modal-btn,
				.um-modal-btn.disabled,
				.um-modal-btn.disabled:hover,
				div.uimob800 .um-account-side li a.current,
				div.uimob800 .um-account-side li a.current:hover,
				.um input[type=submit]:disabled:hover{
					background-color:' . sanitize_hex_color( $defaults['um_theme_um_plug_accent_color'] ) . ';
				}

				.um .um-tip,
				.select2-default,
				.select2-default *,
				.select2-container-multi .select2-choices .select2-search-field input,
				.um-profile.um .um-profile-headericon a,
				.um span.um-req,
				.um .um-field-icon i,
				.select2-container .select2-choice .select2-arrow:before,
				.select2-search:before,
				.select2-search-choice-close:before{
					color:' . sanitize_hex_color( $defaults['um_theme_um_plug_meta_color'] ) . ';
				}

				.adverts-single-author .adverts-single-author-avatar img.avatar,
				.um-reviews-img .gravatar,
				.um-friends-user-photo .gravatar,
				.um-header-avatar img{
					border-radius:' . esc_attr( $profile_border_radius ) . ';
				}

				.um-tab-notifier,
				span.um-friends-notf,
				.um-message-live-count,
				.um-notification-live-count{
					background-color:' . sanitize_hex_color( $notification_bubble_bg_color ) . ' !important;
					color:' . sanitize_hex_color( $notification_bubble_color ) . ' !important;
				}

				.um .um-button,
				.um-request-button,
				.um input[type=submit].um-button,
				.um input[type=submit].um-button:focus,
				.um a.um-button,
				.um a.um-button.um-disabled:hover,
				.um a.um-button.um-disabled:focus,
				.um a.um-button.um-disabled:active{
					background-color:' . sanitize_hex_color( $defaults['um_theme_um_plug_button_bg_color'] ) . ' !important;
					color:' . sanitize_hex_color( $defaults['um_theme_um_plug_button_text_color'] ) . '!important;
				}

				.um-member-directory-sorting-a, .um-member-directory-filters-a, .um-member-directory-view-type-a{
					color:' . sanitize_hex_color( $defaults['um_theme_um_plug_button_bg_color'] ) . ' !important;
				}

				body .um-directory .um-member-directory-header .um-member-directory-header-row .um-search .um-search-filter.um-slider-filter-type .um-slider .ui-slider-range.ui-widget-header{
					background-color:' . sanitize_hex_color( $defaults['um_theme_um_plug_button_bg_color'] ) . ' !important;
					border:2px solid ' . sanitize_hex_color( $defaults['um_theme_um_plug_button_bg_color'] ) . ' !important;
				}

				.um-directory .um-members-filter-tag{
					background-color:' . sanitize_hex_color( $defaults['um_theme_member_dir_selec_filter_bg_color'] ) . ' !important;
					color:' . sanitize_hex_color( $defaults['um_theme_member_dir_selec_filter_text_color'] ) . ' !important;
				}

				.um-modal-btn:hover,
				.um input[type=submit].um-button:hover,
				.um a.um-button:hover,
				.um-button:active{
					background-color:' . esc_attr( $defaults['um_theme_um_plug_button_hover_bg_color'] ) . ' !important;
					color:' . sanitize_hex_color( $defaults['um_theme_um_plug_button_hover_text_color'] ) . ' !important;
				}

				.um .um-button.um-alt,
				.um-groups-invites-users-wrapper .um-group-button,
				.um input[type=submit].um-button.um-alt{
					color:' . sanitize_hex_color( $defaults['um_theme_um_plug_alt_button_text_color'] ) . ' !important;
					background-color:' . sanitize_hex_color( $defaults['um_theme_um_plug_alt_button_color'] ) . ' !important;
				}

				.um-alt:active,
				.um .um-button.um-alt:hover,
				.um-groups-invites-users-wrapper .um-group-button:hover,
				.um input[type=submit].um-button.um-alt:hover{
					background-color:' . sanitize_hex_color( $defaults['um_theme_um_plug_alt_button_hover_color'] ) . ' !important;
					color:' . sanitize_hex_color( $defaults['um_theme_um_plug_alt_button_hover_text_color'] ) . '!important;
				}

				.um .um-field-label {color:' . sanitize_hex_color( $um_theme_form_field_label_text_color ) . ' !important;}

				.um .um-form ::-webkit-input-placeholder,
				.um .um-form ::-moz-placeholder,
				.um .um-form ::-moz-placeholder,
				.um .um-form ::-ms-input-placeholder {
				    color:' . sanitize_hex_color( $defaults['um_theme_form_field_placeholder_text_color'] ) . ';
				}

				.um .um-form input[type=text],
				.um .um-form input[type=tel],
				.um .um-form input[type=number],
				.um .um-form input[type=password],
				.um .um-form textarea,
				.um .upload-progress,
				.select2-container .select2-choice,
				.select2-drop,
				.select2-container-multi .select2-choices,
				.select2-drop-active,
				.select2-drop.select2-drop-above {
				    border: 1px solid ' . sanitize_hex_color( $um_theme_form_field_border_color ) . ' !important;
				}

				.um .um-form input[type=text],
				.um .um-form input[type=tel],
				.um .um-form input[type=password],
				.um .um-form textarea {
				    color:' .sanitize_hex_color( $um_theme_form_field_text_color ) . ' !important;
				}

				.um .um-form input[type=text]:focus,
				.um .um-form input[type=tel]:focus,
				.um .um-form input[type=number]:focus,
				.um .um-form input[type=password]:focus,
				.um .um-form .um-datepicker.picker__input.picker__input--active,
				.um .um-form .um-datepicker.picker__input.picker__input--target,
				.um .um-form textarea:focus {
				    border: 1px solid ' . sanitize_hex_color( $um_theme_form_field_border_focus_color ) . ' !important;
				}

				.um .um-form input[type=text]:focus,
				.um .um-form input[type=tel]:focus,
				.um .um-form input[type=number]:focus,
				.um .um-form input[type=password]:focus,
				.um .um-form textarea:focus,
				.um .um-form input[type=text],
				.um .um-form input[type=tel],
				.um .um-form input[type=number],
				.um .um-form input[type=password],
				.um .um-form textarea,
				.select2-container .select2-choice,
				.select2-container-multi .select2-choices {
				    background-color:' . sanitize_hex_color( $um_theme_form_field_background_color ) . ' !important;
				}

				p.um-notice.err,
				.um-field-error {
				    background-color:' . sanitize_hex_color( $um_theme_form_field_error_bg_color ) . ' !important;
				    color:' . sanitize_hex_color( $um_theme_form_field_error_text_color ) . ' !important;
				}

				.um-field-arrow {color:' . sanitize_hex_color( $um_theme_form_field_error_bg_color ) . ' !important;}
				.um-profile-nav{background-color:' . sanitize_hex_color( $template_profile_nav_bar_color ) . ' !important;}
				.um-messaging-bar,.um-profile .um-header,.um-profile-four {background-color:' . sanitize_hex_color( $template_profile_content_area_color ) . ';}
				.member-profile-container,.um-member {background-color:' . sanitize_hex_color( $member_box_bg_color ) . ' !important;}
				.member-profile-container,.um-member-name a {
					color:' . sanitize_hex_color( $member_box_text_color ) . '!important;
					font-size: ' . esc_attr( $defaults['um_theme_member_directory_title_font_size'] ) . ' !important;
				}

				.um-theme-dropdown-header,.messenger-username strong{color:' . sanitize_hex_color( $defaults['um_theme_header_messenger_username_color'] ) . ';}

				.profile-title,
				.um-profile-meta .um-meta-text,
				.um-profile.um .um-name a,
				.um-profile.um .um-name a:hover {
					color:' . sanitize_hex_color( $template_profile_content_area_text_color ) . ';
				}

				.um-profile.um .um-profile-meta{color:' . sanitize_hex_color( $defaults['um_theme_profile_meta_color'] ) . ';}
				.um-theme-profile-single-content-container{background-color:' . sanitize_hex_color( $template_profile_single_area_color ) . ';}

				.um-profile-two,
				.um-profile-note,
				.um-profile-note span,
				.um-theme-profile-single-content-container{
					color:' . sanitize_hex_color( $template_profile_single_area_text_color ) . ' !important;
				}

				.um-theme-profile-single-sidebar-container{background-color:' . sanitize_hex_color( $template_profile_sidebar_area_color ) . ';}
				.um-profile-one-content .um-profile-nav-item a,
				.um-profile-two-content .um-profile-nav-item a,
				.um-profile-nav .um-profile-nav-item a,
				.um .um-profile-four-content .um-profile-nav-item.active a,
				.um-profile-four-content .um-profile-nav-item a:hover{
					color:' . sanitize_hex_color( $template_profile_nav_menu_color ) . ' !important;
				}

				.um-friends-list,
				.um-profile-two .um-profile-meta,
				.um-profile-one-content .um-profile-nav,
				.um-profile.um-viewing .um-field-label,
				.um-profile-one .um-profile-meta.boot-d-block.boot-d-sm-none{
					border-color:' . sanitize_hex_color( $template_profile_field_label_color ) . ' !important;
				}

				.um-profile-body .um-field-label{
					color: ' . sanitize_hex_color( $defaults['um_theme_profile_field_label_txt_color'] ) . '!important;
				}

				.um .um-profile-nav-item.active a:hover,
				.um .um-profile-nav-item.active a,
				.um-profile-nav-item a:hover{
					color:' . sanitize_hex_color( $template_profile_nav_menu_hover_color ) . '!important;
					background-color:' . sanitize_hex_color( $template_profile_nav_menu_bg_hover_color ) . ' !important;
				}

				.um-account-side ul li{background-color:' . sanitize_hex_color( $defaults['um_theme_um_account_tab_color'] ) . ';}
				.um-account-side ul li a span.um-account-title{color:' . sanitize_hex_color( $defaults['um_theme_um_account_tab_text_color'] ) . ';}

				.um-account-side ul li a span.um-account-icon,
				.um-account-side ul li a.current span.um-account-icon{
					color: ' . sanitize_hex_color( $defaults['um_theme_um_account_tab_icon_color'] ) . ';
				}

				.um-account-side ul li a:hover {background-color:' . sanitize_hex_color( $defaults['um_theme_um_account_tab_hover_color'] ) . ';}

				.um-account-side ul li a:hover .um-account-title,
				.um-account-side ul li a:hover .um-account-icon,
				.um-account-side ul li a.current:hover span.um-account-icon {
					color:' . sanitize_hex_color( $defaults['um_theme_um_account_tab_text_hover_color'] ) . ';
				}

				.um-link .um-verified,
				.um-groups-comment-author-link .um-verified,
				.um-activity-author-url .um-verified,
				.um-groups-author-url .um-verified,
				.um-name .um-verified,
				.um-member-name .um-verified {
					color:' . sanitize_hex_color( $defaults['um_theme_ext_verified_icon_color'] ) . ' !important;
				}

				.um-login #um-submit-btn {
					color:' . sanitize_hex_color( $defaults['um_theme_login_page_login_text_color'] ) . ';
					background-color:' . sanitize_hex_color( $defaults['um_theme_login_page_login_color'] ) . ';
				}

				.um-login .um-alt {
					color:' . sanitize_hex_color( $defaults['um_theme_login_page_register_text_color'] ) . '!important;
					background-color:' . sanitize_hex_color( $defaults['um_theme_login_page_register_color'] ) . '!important;
				}

				body.um-page-login {
					background-color:' . sanitize_hex_color( $defaults['um_theme_login_page_bg_color'] ) . '!important;
					background-image: url(' . get_theme_mod( 'um_theme_login_page_bg_image' ) . ');
					background-size: cover;
					background-position-x: center;
					background-position-y: center;
				}

				.um-page-login .um-field-label {color:' . sanitize_hex_color( $defaults['um_theme_login_page_field_label_color'] ) . '!important;}
				';
		endif;

		// Ultimate Member Accounts Page
		if ( class_exists( 'UM' ) && $defaults['um_theme_um_account_tab_position'] === 2 ) :
			$css .='
				.um-account-side {width:80% !important; margin-left:10%; margin-right:10%;}
				.um-account-side ul, .um-account-side li {text-align: center;}
				.um-form .um-account-side li { display: inline-block; margin-right: 5px !important; margin-bottom: 5px !important; }
				.um-account-side li a span.um-account-arrow{display:none;}
				.um-account-side li a span.um-account-title {padding-left: 10px !important;}

				.um-form .um-account-side li a{
				    padding: 5px 10px !important;
				    height: 35px;
				}

				.um-account-side li a span.um-account-icon{
					border:none !important;
					padding:0 !important;
				}

				.um-form .um-account-main{
					width:100% !important;
					margin-top:15px;
				}

				.um-account-tab {
				    margin: 5% 15%;
				    width: 70%;
				}

				#um_user_photos_download_all,
				#um_user_photos_delete_all {
				    display: inline-block;
				    width: auto;
				    margin-right:5px;
				}
			';
		endif;

		// Ultimate Member - Social Activity
		if ( function_exists( 'um_activity_plugins_loaded' ) ) :
			$css .= '
				.um-activity-head{background-color:' . sanitize_hex_color( $defaults['um_theme_ext_acitivity_head_color'] ) . ';}
				.um-activity-author-meta span.um-activity-metadata a{color:' . sanitize_hex_color( $defaults['um_theme_ext_acitivity_meta_color'] ) . ';}

				.um .um-activity-ava img,
				.um-activity-comment-avatar img,
				.um-activity-faces img.avatar{
					border-radius:' .  esc_attr( $defaults['um_theme_ext_activity_image_radius'] ) . ' !important;
				}

				.um-activity-bodyinner-txt span.post-meta,
				.um-activity-head,
				.um-activity-body,
				.um-activity-foot,
				.um-activity-comments{
					border-color:' . sanitize_hex_color( $defaults['um_theme_ext_acitivity_border_color'] ) . ' !important;
				}

				.um-activity-bodyinner-txt{
					color:' . sanitize_hex_color( $defaults['um_theme_ext_acitivity_text_color'] ) . ' !important;
					font-size: ' . esc_attr( $defaults['um_theme_ext_acitivity_text_font_size'] ) . ';
				}
			';
		endif;

		// Ultimate Member - Private Message
		if ( function_exists( 'um_messaging_plugins_loaded' ) ) :

			$css .= '
				.um-message-item.left_m .um-message-item-content{
					color:' . sanitize_hex_color( $um_ext_pm_text_color ) . ' !important;
					background-color:' . sanitize_hex_color( $um_ext_pm_bg_color ) . '!important;
				}

				.um-message-item-content{
					color:' . sanitize_hex_color( $defaults['um_theme_ext_pm_message_your_text_color'] ) . ' !important;
					background-color:' . sanitize_hex_color( $defaults['um_theme_ext_pm_your_message_bg_color'] ) . '!important;
				}

				.um-message-abtn,
				.um-message-btn,
				.um-message-send{
					color:' . sanitize_hex_color( $um_ext_pm_button_text_color ) . ' !important;
					background-color:' . sanitize_hex_color( $um_ext_pm_button_bg_color ) . ' !important;
				}

				.um-message-conv .um-message-conv-item.active{ border-right:5px solid ' . sanitize_hex_color( $um_ext_pm_button_bg_color ) . ' !important;}
				.um-message-item-remove,.um-message-header-right a{ color:' . sanitize_hex_color( $defaults['um_theme_ext_pm_message_icon_color'] ) . ' !important;}
				.um-msg-tik-ico {color:' . sanitize_hex_color( $header_private_message_color ) . ';}
				.um-msg-tik-ico:hover {color:' . sanitize_hex_color( $header_private_message_hover_color ) . ';}
				.messenger-text{color:' . sanitize_hex_color( $defaults['um_theme_header_messenger_text_color'] ) . ';}
				.header-messenger-box .dropdown-menu{
					background-color:' . sanitize_hex_color( $defaults['um_theme_header_messenger_box_color'] ) . ' !important;
					color:' . sanitize_hex_color( $defaults['um_theme_header_messenger_text_color'] ) . ';
				}
				.message-status-0{background-color:' . sanitize_hex_color( $defaults['um_theme_header_unread_message_color'] ) . ';}
			';
		endif;

		// Ultimate Member - Notifications
		if ( function_exists( 'um_notifications_check_dependencies' ) ) :

			$css .= '
				.header-notification-box .um-notification{background-color:' . sanitize_hex_color( $defaults['header_notification_box_color'] ) . ' !important;}
				.header-notification-box h6,.header-notification-box .um-notification{color:' . sanitize_hex_color( $defaults['header_notification_text_color'] ) . ';}
				.um-notification-ico {color:' . sanitize_hex_color( $header_notification_color ) . ';}
				.um-notification-ico:hover {color:' . sanitize_hex_color( $header_notification_hover_color ) . ';}

				.um-notification-b {
					background-color:' . sanitize_hex_color( $defaults['um_theme_ext_float_notification_icon_color'] ) . ' !important;
					color:' . sanitize_hex_color( $defaults['um_theme_ext_float_notification_bell_icon_color'] ) . ' !important;
				}
			';
		endif;

		// Ultimate Member - Profile Completeness
		if ( function_exists( 'um_profile_completeness_plugins_loaded' ) ) :

			$css .= '
				.um-completeness-bar{background-color:' . sanitize_hex_color( $defaults['um_theme_ext_profile_empty_bar_color'] ) . ' !important;}
				.um-completeness-done{background-color:' . sanitize_hex_color( $defaults['um_theme_ext_profile_complete_bar_color'] ) . ' !important;}
			';
		endif;

		// Ultimate Member - Followers
		if ( function_exists( 'um_followers_plugins_loaded' ) ) :

			$css .= '
				.um-followers-user-span,.um-followers-rc a{color:' . sanitize_hex_color( $defaults['um_theme_ext_followers_meta_color'] ) . ' !important;}
				.um-followers-rc a span{color:' . sanitize_hex_color( $defaults['um_theme_ext_followers_count_color'] ) . ' !important;}
				.um-activity-like.active .um-faicon-thumbs-up{color:' . sanitize_hex_color( $defaults['um_theme_um_plug_accent_color'] ) . ' !important;}
			';
		endif;

		// Ultimate Member - User Bookmarks
		if ( function_exists( 'um_user_bookmarks_plugins_loaded' ) ) :

			$css .= '
				.um-user-bookmarks-add-button{
					background-color:' . sanitize_hex_color( $defaults['um_theme_user_bookmarks_button_color'] ) . ' !important;
					color:' . sanitize_hex_color( $defaults['um_theme_user_bookmarks_button_text_color'] ) . ' !important;
				}

				.um-user-bookmarks-profile-remove-link,
				.um-user-bookmarks-remove-button{
					background-color:' . sanitize_hex_color( $defaults['um_theme_user_bookmarks_remove_button_color'] ) . ' !important;
					color:' . sanitize_hex_color( $defaults['um_theme_user_bookmarks_remove_button_text_color'] ) . ' !important;
				}

				.um-user-bookmarks-modal .um-user-bookmarks-modal-content{
					background-color:' . sanitize_hex_color( $defaults['um_theme_user_bookmarks_modal_bg'] ) . ' !important;
					color:' . sanitize_hex_color( $defaults['um_theme_user_bookmarks_modal_text'] ) . ' !important;
				}
			';
		endif;

		// Ultimate Member - User Notes
		if ( function_exists( 'um_user_notes_plugins_loaded' ) ) :

			$css .= '
				.note-block{
					background-color:' . sanitize_hex_color( $defaults['um_theme_user_notes_color'] ) . ' !important;
					color:' . sanitize_hex_color( $defaults['um_theme_user_notes_text_color'] ) . ' !important;
					border-color:' . sanitize_hex_color( $defaults['um_theme_user_notes_border_color'] ) . ' !important;
				}

				.note-block .um_note_read_more{color:' . sanitize_hex_color( $defaults['um_theme_user_notes_text_color'] ) . ' !important;}
			';
		endif;

		if ( $defaults['um_theme_user_bookmarks_list_excerpt_show'] === 2 ) :
			$css .= '.um-user-bookmarks-post-content p{ display:none;}';
		endif;

		// Ultimate Member - Friends
		if ( function_exists( 'um_friends_plugins_loaded' ) ) :

			$css .= '
				.um-friend-req-live-count{
					background-color:' . sanitize_hex_color( $friend_req_bubble_bg_color ) . ' !important;
					color:' . sanitize_hex_color( $friend_req_bubble_color ) . ' !important;
				}

				.header-friend-requests .dropdown-menu{
					color:' . sanitize_hex_color( $defaults['header_friend_req_content_color'] ) . ';
					background-color:' . sanitize_hex_color( $defaults['header_friend_req_box_color'] ) . ';
				}

				.friends-drop-menu .um-friend-accept-btn{
					color:' . sanitize_hex_color( $defaults['header_friend_req_confirm_button_text_color'] ) . ';
					background-color:' . sanitize_hex_color( $defaults['header_friend_req_confirm_button_color'] ) . ';
				}

				.friends-drop-menu .um-friend-reject-btn{
					color:' . sanitize_hex_color( $defaults['header_friend_req_delete_button_text_color'] ) . ';
					background-color:' . sanitize_hex_color( $defaults['header_friend_req_delete_button_color'] ) . ';
				}

				.friends-drop-menu .um-theme-dropdown-header h6,
				.header-friend-requests .um-profile-note span{
					color:' . sanitize_hex_color( $defaults['header_friend_req_content_color'] ) . ' !important;
				}

				.um .um-friends-coverbtn a{
					background-color:' . sanitize_hex_color( $defaults['um_theme_ext_friend_button_bg_color'] ) . ' !important;
					color:' . sanitize_hex_color( $defaults['um_theme_ext_friend_button_text_color'] ) . ' !important;
				}

				.um .um-friends-coverbtn a:hover{
					background-color:' . sanitize_hex_color( $defaults['um_theme_ext_friend_button_hover_bg_color'] ) . ' !important;
					color:' . sanitize_hex_color( $defaults['um_theme_ext_friend_button_hover_text_color'] ) . ' !important;
				}

				.um-friend-tick {color: ' . sanitize_hex_color( $header_friend_req_color ) . ';}
				.um-friend-tick:hover {color:' . sanitize_hex_color( $header_friend_req_hover_color ) . ';}
				.friends-drop-menu .um-friends-user-photo img{border-radius:' . $defaults['um_theme_ext_friends_image_radius'] . ' !important;}
			';
		endif;

		// Ultimate Member - User Reviews
		if ( function_exists( 'um_reviews_plugins_loaded' ) ) :

			$css .= '
				span.um-reviews-avg i,span.um-reviews-rate i{color:' . sanitize_hex_color( $defaults['um_theme_ext_reviews_star_color'] ) . ' !important;}
				.um-reviews-d-p span{background-color:' . sanitize_hex_color( $defaults['um_theme_ext_reviews_bar_color'] ) . ' !important;}
				.um-reviews-d-p{background-color:' . sanitize_hex_color( $defaults['um_theme_ext_reviews_empty_bar_color'] ) . ' !important;}
				div.um .um-form div.um-reviews-post .um-reviews-title{color:' . sanitize_hex_color( $defaults['um_theme_ext_reviews_single_title_color'] ) . ' !important;}
				.um-reviews-header {color:' . sanitize_hex_color( $defaults['um_theme_ext_reviews_section_title_color'] ) . ' !important;}
			';
		endif;

		// Ultimate Member - WooCommerce
		if ( function_exists( 'um_theme_is_active_um_ext_woocommerce' ) ) :

			$css .= '
				.um-woo-grid {background-color:' . sanitize_hex_color( $defaults['um_theme_ext_woo_product_bg_color'] ) . ';}
				span.um-woo-grid-price {color:' . sanitize_hex_color( $defaults['um_theme_ext_woo_product_price_color'] ) . ';}
				.um-woo-grid-title a {color:' . sanitize_hex_color( $defaults['um_theme_ext_woo_product_title_color'] ) . ';}
				.um-woo-grid-content{color:' . sanitize_hex_color( $defaults['um_theme_ext_woo_product_review_color'] ) . ';}
			';
		endif;

		// Ultimate Member - User Tags
		if ( function_exists( 'um_user_tags_plugins_loaded' ) ) :
			$css .= '
				.um-user-tag {
					background-color:' . sanitize_hex_color( $defaults['um_theme_ext_tags_bg_color'] ) . ' !important;
					border-color:' . sanitize_hex_color( $defaults['um_theme_ext_tags_border_color'] ) . ' !important;
					font-size:' . esc_attr( $defaults['um_theme_ext_tag_text_font_size'] ) . ' !important;
				}

				.um-user-tag a{color:' . sanitize_hex_color( $defaults['um_theme_ext_tags_text_color'] ) . ' !important;}
				.um-user-tag:hover a,.um-user-tag a:hover{color:' . sanitize_hex_color( $defaults['um_theme_ext_tags_hover_text_color'] ) . ' !important;}

				.um-user-tag:hover,
				.um-user-tag:focus,
				.um-user-tag:active,
				.um-user-tag.active{
					background-color:' . sanitize_hex_color( $defaults['um_theme_ext_tags_hover_bg_color'] ) . ' !important;
					border-color:' . sanitize_hex_color( $defaults['um_theme_ext_tags_hover_border_color'] ) . ' !important;
				}
			';
		endif;

		// Ultimate Member - UM Groups
		if ( function_exists( 'um_groups_plugins_loaded' ) ) :

			$css .= '

				.um-group-item,.group-grid-inner {background-color:' . sanitize_hex_color( $defaults['um_theme_ext_groups_bg_color'] ) . ';}

				.um-group-name,
				.um-groups-single .um-group-name {
					font-size:' . esc_attr( $defaults['um_theme_ext_group_title_font_size'] ) . ' !important;
					color:' . sanitize_hex_color( $defaults['um_theme_ext_group_title_color'] ) . ' !important;
				}

				.um-groups-single div.um-group-tabs-wrap {
					border-top-color:' . sanitize_hex_color( $defaults['um_theme_ext_group_tab_border_color'] ) . ';
					border-bottom-color:' . sanitize_hex_color( $defaults['um_theme_ext_group_tab_border_color'] ) . ';
				}

				.group-grid-inner{border-color:' . sanitize_hex_color( $defaults['um_theme_ext_group_tab_border_color'] ) . ';}

				.group-meta-info,
				.group-description,
				.um-group-meta .description,
				.um-groups-single .um-group-description {
					font-size:' . esc_attr( $defaults['um_theme_ext_group_description_font_size'] ) . ' !important;
					color:' . sanitize_hex_color( $defaults['um_theme_ext_group_description_color'] ) . ' !important;
				}

				.um-groups-search-form input[type=submit] {
					color:' . sanitize_hex_color( $defaults['um_theme_ext_group_search_button_text_color'] ) . ';
					background-color:' . sanitize_hex_color( $defaults['um_theme_ext_group_search_button_color'] ) . ';
				}

				#um-groups-filters ul.filters li.active {background-color:' . sanitize_hex_color( $defaults['um_theme_ext_group_filter_active_bg'] ) . ' !important;}
				#um-groups-filters ul.filters li.active a{color:' . sanitize_hex_color( $defaults['um_theme_ext_group_filter_active_text'] ) . ' !important;}
				.active .group-filter-item span{border-left-color:' . sanitize_hex_color( $defaults['um_theme_ext_group_filter_active_text'] ) . '!important;}
				#um-groups-filters ul.filters li{background-color:' . sanitize_hex_color( $defaults['um_theme_ext_group_filter_bg'] ) . ';}
				#um-groups-filters ul.filters li a{color:' . sanitize_hex_color( $defaults['um_theme_ext_group_filter_text'] ) . '!important;}
				.group-filter-item span{border-left-color:' . sanitize_hex_color( $defaults['um_theme_ext_group_filter_text'] ) . '!important;}
			';
		endif;

		// ForumWP
		if ( class_exists( 'FMWP' ) ) :

			$css .= '
			.fmwp-topic-title,.fmwp-forum-title{
				font-family: "' .  esc_attr( get_theme_mod( 'um_theme_typography_title_font', 'Open Sans' ) ) . '",sans-serif;
				font-weight:' .  esc_attr( $title_font_weight ) . ' !important;
				text-transform: ' .  esc_attr( $element_title_capitalization ) . ';
			}

			.fmwp-forum-title{color: ' . sanitize_hex_color( $defaults['um_forumwp_forum_title_color'] ) . '!important;}
			.fmwp-forum-category {background-color: ' . sanitize_hex_color( $defaults['um_forumwp_cat_color'] ) . ';}
			.fmwp-forum-category a{color: ' . sanitize_hex_color( $defaults['um_forumwp_cat_txt_color'] ) . ';}
			.fmwp-topic-tag {background-color: ' . sanitize_hex_color( $defaults['um_forumwp_tag_color'] ) . ';}
			.fmwp-topic-tag a{color: ' . sanitize_hex_color( $defaults['um_forumwp_tag_txt_color'] ) . ';}

			.fmwp-topic-title{
				font-size:' .  esc_attr( $defaults['um_forumwp_topic_title_font_size'] ) . ';
				color: ' . sanitize_hex_color( $defaults['um_forumwp_topic_title_color'] ) . '!important;
			}

			input[type=button].fmwp-create-topic{
				background-color: ' . sanitize_hex_color( $defaults['um_forumwp_topic_btn_color'] ) . ';
				color: ' . sanitize_hex_color( $defaults['um_forumwp_topic_btn_text_color'] ) . ';
			}

			input[type=button].fmwp-write-reply{
				background-color: ' . sanitize_hex_color( $defaults['um_forumwp_reply_btn_color'] ) . ';
				color: ' . sanitize_hex_color( $defaults['um_forumwp_reply_btn_text_color'] ) . ';
			}

			.fmwp-reply-subdata,
			.fmwp-topic-subdata,
			.fmwp-topic-top-actions-dropdown,
			.fmwp-reply-top-actions-dropdown,
			.fmwp-show-child-replies{
				color: ' . sanitize_hex_color( $defaults['um_forumwp_subdata_color'] ) . '!important;
			}

			.fmwp-child-reply{background-color: ' . sanitize_hex_color( $defaults['um_forumwp_reply_box_color'] ) . '!important;}

			.fmwp-search-topic,
			.fmwp-search-forum{
				background-color: ' . sanitize_hex_color( $defaults['um_forumwp_search_button_color'] ) . '!important;
				color: ' . sanitize_hex_color( $defaults['um_forumwp_search_button_text_color'] ) . '!important;
			}

			.fmwp-forums-wrapper-heading,
			.fmwp-topics-wrapper-heading{
				color: ' . sanitize_hex_color( $defaults['um_forumwp_forum_heading_color'] ) . '!important;
			}

			.fmwp-forums-wrapper-heading,
			.fmwp-forums-list-head,
			.fmwp-forum-row,
			.fmwp-forum-nav-bar,
			.fmwp-topics-wrapper-heading,
			.fmwp-topic-row{
				border-color: ' . sanitize_hex_color( $defaults['um_forumwp_border_color'] ) . '!important;
			}

			.fmwp-forum-actions-dropdown,
			.fmwp-forum-statistics-data,
			.fmwp-topic-statistics-section,
			.fmwp-topic-actions-dropdown{
				color: ' . sanitize_hex_color( $defaults['um_forumwp_meta_color'] ) . '!important;
			}

			.fmwp-forum-search-line,
			.fmwp-forums-search-line,
			.fmwp-topics-search-line{
				background-color: ' . sanitize_hex_color( $defaults['um_forumwp_search_box_color'] ) . '!important;
			}
			';
		endif;

		// WooCommerce
		if ( class_exists( 'WooCommerce' ) ) :

			$css .= '
				.woocommerce div.product p.price,
				.woocommerce div.product span.price,
				.woocommerce ul.products li.product .price{
				    color:' . sanitize_hex_color( $woo_price_color ) . ' !important;
				}

				.woocommerce div.product .product_title,
				.woocommerce-loop-product__title{
				    color:' . sanitize_hex_color( $woo_product_title_color ) . ';
				}

				.woocommerce #respond input#submit.alt,
				.woocommerce a.button.alt,
				.woocommerce button.button.alt,
				.woocommerce input.button.alt,
				.woocommerce #respond input#submit,
				.woocommerce a.button,
				.woocommerce button.button,
				.woocommerce input.button{
					font-family: "' . esc_attr( get_theme_mod( 'um_theme_typography_button_font', 'Open Sans' ) ) . '",sans-serif;
					background-color:' . sanitize_hex_color( $woo_add_cart_button ) . ';
				    color:' . sanitize_hex_color( $woo_add_cart_button_text ) . ' !important;
				}

				.woocommerce span.onsale{
					background-color:' . sanitize_hex_color( $woo_sale_badge ) . ';
				    color:' . sanitize_hex_color( $woo_sale_badge_text ) . ';
				}

				.woocommerce #respond input#submit:hover,
				.woocommerce a.button:hover,
				.woocommerce button.button:hover,
				.woocommerce input.button:hover,
				.woocommerce #respond input#submit.alt:hover,
				.woocommerce a.button.alt:hover,
				.woocommerce button.button.alt:hover,
				.woocommerce input.button.alt:hover{
					background-color:' . sanitize_hex_color( $defaults['um_theme_woocommerce_add_cart_button_hover_color'] ) . ';
				    color:' . sanitize_hex_color( $defaults['um_theme_woocommerce_add_cart_button_hover_text'] ) . ';
				}

				.woocommerce-info::before{color:' . sanitize_hex_color( $defaults['um_theme_woocommerce_info_color'] ) . ';}
				.woocommerce-info {border-top-color:' . sanitize_hex_color( $defaults['um_theme_woocommerce_info_color'] ) . ';}

				.woocommerce-message {
					background-color:' . sanitize_hex_color( $defaults['um_theme_woocommerce_message_color'] ) . ';
					color:' . sanitize_hex_color( $defaults['um_theme_woocommerce_message_text_color'] ) . ';
				}

				.woocommerce .star-rating span::before{color:' . sanitize_hex_color( $defaults['um_theme_woocommerce_star_rating_color'] ) . ';}

				.woocommerce-store-notice{
					color:' . sanitize_hex_color( $defaults['um_theme_woocommerce_notice_text_color'] ) . ' !important;
					background-color:' . sanitize_hex_color( $defaults['um_theme_woocommerce_notice_bg_color'] ) . '!important;
				}

				.woocommerce ul.products li.product .woocommerce-loop-category__title,
				.woocommerce ul.products li.product .woocommerce-loop-product__title,
				.woocommerce ul.products li.product h3{
					font-size:' . esc_attr( $defaults['um_theme_woo_prod_title_font_size'] ) . ';
				}
			';
		endif;

		// YITH Wishlist
		if ( class_exists( 'YITH_WCWL' ) ) :
			$css .= '
				.wishlist_table .add_to_cart_button {
				    background-color:' . sanitize_hex_color( $defaults['um_theme_yith_wishlist_add_cart_color'] ) . ' !important;
				    color:' . sanitize_hex_color( $defaults['um_theme_yith_wishlist_add_cart_text_color'] ) . ' !important;
				}

				.wishlist_table a.remove_from_wishlist {
				    background-color:' . sanitize_hex_color( $defaults['um_theme_yith_wishlist_remove_color'] ) . ' !important;
				    color:' . sanitize_hex_color( $defaults['um_theme_yith_wishlist_remove_text_color'] ) . ' !important;
				}
			';
		endif;

		// Dokan Multivendor
		if ( class_exists( 'WeDevs_Dokan' ) ) :
			$css .= '
				.profile-info-head .store-name,.profile-info .store-name {color:' . sanitize_hex_color( $defaults['um_theme_dokan_store_name_color'] ) . ' !important;}
				.dokan-store-info {color:' . sanitize_hex_color( $defaults['um_theme_dokan_store_info_color'] ) . ' !important;}
			';
		endif;

		// Easy Digital Downloads
		if ( class_exists( 'Easy_Digital_Downloads' ) ) :
			$css .= '
				#edd-purchase-button, .edd-submit, [type=submit].edd-submit {font-size:' . esc_attr( $defaults['um_theme_edd_button_font_size'] ) . ' !important;}

				.edd-submit.button.white,
				.edd-submit.button.gray,
				.edd-submit.button.red,
				.edd-submit.button.green,
				.edd-submit.button.yellow,
				.edd-submit.button.orange,
				.edd-submit.button.dark-gray,
				.edd-submit.button.blue {
				    background-color:' . sanitize_hex_color( $defaults['um_theme_edd_button_bg_color'] ) . ' !important;
				    color:' . sanitize_hex_color( $defaults['um_theme_edd_button_text_color'] ) . ' !important;
				}

				.edd-submit.button.white:hover,
				.edd-submit.button.gray:hover,
				.edd-submit.button.red:hover,
				.edd-submit.button.green:hover,
				.edd-submit.button.yellow:hover,
				.edd-submit.button.orange:hover,
				.edd-submit.button.dark-gray:hover,
				.edd-submit.button.blue:hover {
				    background-color:' . sanitize_hex_color( $defaults['um_theme_edd_button_hover_bg_color'] ) . ' !important;
				    color:' . sanitize_hex_color( $defaults['um_theme_edd_button_hover_text_color'] ) . ' !important;
				}

				.edd-alert-error{
				    background-color:' . sanitize_hex_color( $defaults['um_theme_edd_alert_bg_color'] ) . ' !important;
				    color:' . sanitize_hex_color( $defaults['um_theme_edd_alert_text_color'] ) . ' !important;
				    border-color:' . sanitize_hex_color( $defaults['um_theme_edd_alert_border_color'] ) . ' !important;
				}

				.edd-alert-success{
				    background-color:' . sanitize_hex_color( $defaults['um_theme_edd_success_bg_color'] ) . ' !important;
				    color:' . sanitize_hex_color( $defaults['um_theme_edd_success_text_color'] ) . ' !important;
				    border-color:' . sanitize_hex_color( $defaults['um_theme_edd_success_border_color'] ) . ' !important;
				}

				.edd-alert-info{
				    background-color:' . sanitize_hex_color( $defaults['um_theme_edd_info_bg_color'] ) . ' !important;
				    color:' . sanitize_hex_color( $defaults['um_theme_edd_info_text_color'] ) . ' !important;
				    border-color:' . sanitize_hex_color( $defaults['um_theme_edd_info_border_color'] ) . ' !important;
				}

				.edd-alert-warn {
				    background-color:' . sanitize_hex_color( $defaults['um_theme_edd_warn_bg_color'] ) . ' !important;
				    color:' . sanitize_hex_color( $defaults['um_theme_edd_warn_text_color'] ) . ' !important;
				    border-color:' . sanitize_hex_color( $defaults['um_theme_edd_warn_border_color'] ) . ' !important;
				}
			';
		endif;

		// bbPress
		if ( class_exists( 'bbPress' ) ) :

			$css .= '
				.um-bbpress-warning,
				div.bbp-template-notice.info,
				.bbp-template-notice,
				.indicator-hint {
				    background-color:' . sanitize_hex_color( $bb_notification_bg ) . ' !important;
				    border-color:' . sanitize_hex_color( $bb_notification_border ) . '!important;
				    color:' . sanitize_hex_color( $bb_notification_text ) . ' !important;
				}

				.bbp-topics-front ul.super-sticky,
				.bbp-topics ul.super-sticky,
				.bbp-topics ul.sticky,
				.bbp-forum-content ul.sticky {
				    background-color:' . sanitize_hex_color( $bb_sticky_bg ) . ' !important;
				}

				#bbpress-forums li.bbp-header{
					background-color:' . sanitize_hex_color( $bb_forum_head_bg ) . ' !important;
					border-color:' . sanitize_hex_color( $bb_forum_head_border ) . ' !important;
					color:' . sanitize_hex_color( $bb_forum_head_text ) . ' !important;
				}

				.bbp-author-name {color:' . sanitize_hex_color( $bb_author_name_color ) . ' !important;}
				.bbp-forum-content{color:' . sanitize_hex_color( $bb_text_color ) . ' !important;}

				.bbp-topic-title,
				.bbp-reply-title,
				.bbp-forum-title,
				.bbp-topic-permalink{
					color:' . sanitize_hex_color( $bb_title_color ) . ' !important;
					font-size:' . esc_attr( $bb_title_font_size ) . ';
				}
			';
		endif;

		// WP Job Manager
		if ( class_exists( 'WP_Job_Manager' ) ) :

			$single_job_title_color 		= sanitize_hex_color( $defaults['um_theme_sing_job_listing_title_color'] );
			$single_job_title_font_size 	= esc_attr( $defaults['um_theme_sing_job_listing_title_font_size'] );
			$single_job_button_color 		= sanitize_hex_color( $defaults['um_theme_sing_job_listing_button_color'] );
			$single_job_button_text_color 	= sanitize_hex_color( $defaults['um_theme_sing_job_listing_button_text_color'] );

			$css .= '
				.single-job-title {
				    color:' . sanitize_hex_color( $single_job_title_color ) . ' !important;
				    font-size:' . esc_attr( $single_job_title_font_size ) . ' !important;
				}

				.single-job-header .application_button {
				    color:' . sanitize_hex_color( $single_job_button_text_color ) . ' !important;
				    background-color:' . sanitize_hex_color( $single_job_button_color ) . ' !important;
				}

			';
		endif;

		// Restrict Content
		if ( function_exists( 'restrict_shortcode' ) ) :
			$css .= '
				.rc-restricted-content-message{
					color:' . sanitize_hex_color( $defaults['um_theme_rcp_message_text_color'] ) . ' !important;
					background-color:' . sanitize_hex_color( $defaults['um_theme_rcp_message_bg_color'] ) . ' !important;
				}

				.rc_logged_in a{
					color:' . sanitize_hex_color( $defaults['um_theme_rcp_logout_text_color'] ) . ' !important;
					background-color:' . sanitize_hex_color( $defaults['um_theme_rcp_logout_bg_color'] ) . ' !important;
				}
			';
		endif;

		// WPAdverts
		if ( class_exists( 'Adverts' ) ) :
			$css .= '
				.advert-price{
					background-color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_price_bg_color'] ) . '!important;
					color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_price_color'] ) . '!important;
					border-color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_price_color'] ) . '!important;
				}

				.adverts-price-box,
				.advert-item:hover .advert-price{
					background-color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_price_color'] ) . '!important;
					color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_price_bg_color'] ) . '!important;
				}

				.adverts-widget-recent .advert-widget-recent-price {
					color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_price_color'] ) . '!important;
				}

				.adverts-widget-recent .adverts-widget-recent-title a,
				.adverts-widget-recent .adverts-widget-recent-title a:visited,
				.advert-item span.advert-link .advert-link-text{
					color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_link_color'] ) . '!important;
				}

				.advert-item{
					color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_text_color'] ) . '!important;
					background-color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_item_bg_color'] ) . '!important;
					border-color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_item_border_color'] ) . '!important;
				}

				.advert-item.advert-is-featured {
					background-color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_featured_item_bg_color'] ) . '!important;
					border-color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_featured_item_border_color'] ) . '!important;
				}

				.wpadverts-list-item-marked-as-sold {
					background-color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_sold_item_bg_color'] ) . '!important;
					color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_sold_item_text_color'] ) . '!important;
				}

				.adverts-grid .adverts-round-icon{
					background-color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_icon_bg_color'] ) . '!important;
					color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_icon_color'] ) . '!important;
				}

				.adverts-contact-box {
					border-color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_contact_box_border_color'] ) . '!important;
					background-color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_contact_box_bg_color'] ) . '!important;
				}

				.adverts-options {
					border-color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_search_border_color'] ) . '!important;
					background-color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_search_box_color'] ) . '!important;
				}

				.advert-input input[type=text] {
					background-color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_search_placeholder_bg'] ) . '!important;
					color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_search_placeholder_text'] ) . '!important;
				}

				.adverts-button-small{
					background-color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_search_button_bg'] ) . '!important;
					color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_search_button_text'] ) . '!important;
				}

				.adverts-square-icon:before{
					color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_search_button_text'] ) . '!important;
				}

				.advert-is-featured span.advert-link .advert-link-text{
					color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_featured_item_title_color'] ) . '!important;
				}

				.advert-is-featured{
					color:' . sanitize_hex_color( $defaults['um_theme_wpadverts_featured_item_text_color'] ) . '!important;
				}

			';
		endif;


		// SportsPress
		if ( class_exists( 'SportsPress' ) ) :
			$css .= '
				.sp-table-caption{
					background-color:' . sanitize_hex_color( $defaults['um_theme_sportspress_table_caption_color'] ) . ';
					color:' . sanitize_hex_color( $defaults['um_theme_sportspress_table_caption_text'] ) . ';
				}

				.sp-template-details dl,
				.sp-data-table{
					background-color:' . sanitize_hex_color( $defaults['um_theme_sportspress_table_bg'] ) . ';
				}

				.sp-data-table,
				.sp-data-table th,
				.sp-data-table td,
				.sp-template-details dl{
					border-color:' . sanitize_hex_color( $defaults['um_theme_sportspress_table_border'] ) . ';
				}

				.sp-staff-role,
				strong.sp-player-number,
				.sp-template-event-logos .sp-team-result{
					background-color:' . sanitize_hex_color( $defaults['um_theme_sportspress_elements_bg'] ) . ';
					color:' . sanitize_hex_color( $defaults['um_theme_sportspress_elements_text'] ) . ';
				}

			';
		endif;


		// Combine the values from above.
		$css_minified = $css;

		// Minify dynamic CSS.
		if ( function_exists( 'um_theme_minify_css' ) ) {
			$css_minified = um_theme_minify_css( $css_minified );
		}

		wp_add_inline_style( 'umtheme-stylesheet', wp_strip_all_tags( $css_minified ) );
	}
}