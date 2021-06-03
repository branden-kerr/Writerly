<?php
namespace um_ext\um_profile_tabs\core;
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Class Common
 *
 * @package um_ext\um_profile_tabs\core
 */
class Common {


	/**
	 * Common constructor.
	 */
	function __construct() {
		add_action( 'init', [ $this, 'register_post_type' ] );
		add_action( 'delete_post', [ $this, 'remove_profile_tab_options' ], 10, 1 );
	}


	/**
	 *
	 */
	function register_post_type() {
		$labels = [
			'name'              => _x( 'Profile Tabs', 'Post Type General Name', 'um-profile-tabs' ),
			'singular_name'     => _x( 'Profile tab', 'Post Type Singular Name', 'um-profile-tabs' ),
			'menu_name'         => __( 'Profile Tabs', 'um-profile-tabs' ),
			'name_admin_bar'    => __( 'Profile Tabs', 'um-profile-tabs' ),
			'archives'          => __( 'Item Archives', 'um-profile-tabs' ),
			'attributes'        => __( 'Item Attributes', 'um-profile-tabs' ),
			'parent_item_colon' => __( 'Parent Item:', 'um-profile-tabs' ),
			'all_items'         => __( 'All Items', 'um-profile-tabs' ),
			'add_new_item'      => __( 'Add New Item', 'um-profile-tabs' ),
			'add_new'           => __( 'Add New', 'um-profile-tabs' ),
			'new_item'          => __( 'New Item', 'um-profile-tabs' ),
			'edit_item'         => __( 'Edit Item', 'um-profile-tabs' ),
			'update_item'       => __( 'Update Item', 'um-profile-tabs' ),
			'view_item'         => __( 'View Item', 'um-profile-tabs' ),
			'view_items'        => __( 'View Items', 'um-profile-tabs' ),
			'search_items'      => __( 'Search Item', 'um-profile-tabs' ),
			'not_found'         => __( 'Not found', 'um-profile-tabs' ),
		];
		
		$args = [
			'label'                 => __( 'Profile Tabs', 'um-profile-tabs' ),
			'description'           => __( '', 'um-profile-tabs' ),
			'labels'                => $labels,
			'supports'              => ['title','editor'],
			'hierarchical'          => false,
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => false,
			'menu_position'         => 5,
			'show_in_admin_bar'     => false,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		];

		register_post_type( 'um_profile_tabs', $args );
	}


	/**
	 * When delete profile tab - remove option connected
	 *
	 * @param $post_id
	 */
	function remove_profile_tab_options( $post_id ) {
		$post = get_post( $post_id );

		if ( ! is_wp_error( $post ) && 'um_profile_tabs' == $post->post_type ) {
			$tab_slug = str_replace( '-', '', $post->post_name );
			UM()->options()->remove( 'profile_tab_' . $tab_slug );
			UM()->options()->remove( 'profile_tab_' . $tab_slug . '_privacy' );
			UM()->options()->remove( 'profile_tab_' . $tab_slug . '_roles' );
		}
	}
}