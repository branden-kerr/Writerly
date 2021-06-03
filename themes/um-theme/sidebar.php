<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package um-theme
 */
if ( ! um_theme_active_page_sidebar() ) { return; }

	global $defaults;

	$post_status 		= (int) $defaults['um_theme_show_sidebar_post'];
	$page_status 		= (int) $defaults['um_theme_show_sidebar_page'];
	$archive_status 	= (int) $defaults['um_theme_show_sidebar_archive_page'];
	$search_status 		= (int) $defaults['um_theme_show_sidebar_search'];
	$group_status 		= (int) $defaults['um_theme_show_sidebar_group'];
	$bbpress_forum		= (int) $defaults['um_theme_show_sidebar_bb_forum'];
    $bbpress_topic      = (int) $defaults['um_theme_show_sidebar_bb_topic'];
    $bbpress_reply      = (int) $defaults['um_theme_show_sidebar_bb_reply'];
	$forumwp_forum		= (int) $defaults['um_theme_show_sidebar_forumwp_forum'];
    $forumwp_topic      = (int) $defaults['um_theme_show_sidebar_forumwp_topic'];
    $forumwp_tag      	= (int) $defaults['um_theme_show_sidebar_forumwp_tag'];
    $forumwp_cat      	= (int) $defaults['um_theme_show_sidebar_forumwp_cat'];
    $wpadverts_archive  = (int) $defaults['um_theme_show_sidebar_wpadverts_archive'];
    $wpadverts_single   = (int) $defaults['um_theme_show_sidebar_wpadverts_single'];

	// Post Type - Default Post
	if ( is_singular( 'post' ) && $post_status === 1 ) {
		um_theme_display_sidebar_condition();
	}

	// Archive Page
	if ( is_archive() && $archive_status === 1 ) {
		um_theme_display_sidebar_condition();
	}

	// Search Page
	if ( is_search() && $search_status === 1 ) {
		um_theme_display_sidebar_condition();
	}

	// Post Type - Default Page
	if ( is_singular( 'page' ) && $page_status === 1 ) {
		um_theme_display_sidebar_condition();
	}

	// Ultimate Member - Groups
	if ( class_exists( 'UM' ) && $group_status === 1 ) {

		if ( is_singular( 'um_groups' ) ){
			um_theme_display_sidebar_condition();
		}
	}

	// WPAdverts
	if ( class_exists( 'Adverts' ) ) {

		// Single Page - Adverts
		if ( is_singular( 'advert' ) && $wpadverts_single === 1 ) {
			um_theme_display_sidebar_condition();
		}

		// Archive Page - Adverts
		if ( is_post_type_archive('advert') && $wpadverts_archive === 1 ) {
			um_theme_display_sidebar_condition();
		}
	}

	// ForumWP
	if ( is_singular( 'fmwp_forum' ) && $forumwp_forum === 1 ) {
		um_theme_display_sidebar_condition();
	}

	if ( is_singular( 'fmwp_topic' ) && $forumwp_topic === 1 ) {
		um_theme_display_sidebar_condition();
	}

	if ( is_tax( 'fmwp_forum_category' ) && $forumwp_cat === 1 ) {
		um_theme_display_sidebar_condition();
	}

	if ( is_tax( 'fmwp_topic_tag' ) && $forumwp_tag === 1 ) {
		um_theme_display_sidebar_condition();
	}

	// bbPress
	// bbPress Forum
	if ( class_exists( 'bbPress' ) ) {
		if ( is_singular( 'forum' ) && $bbpress_forum === 1 ){
			um_theme_display_sidebar_condition();
		}

		if ( is_singular( 'topic' ) && $bbpress_topic === 1 ) {
			um_theme_display_sidebar_condition();
		}

		if ( is_singular( 'reply' ) && $bbpress_reply === 1 ) {
			um_theme_display_sidebar_condition();
		}
	}