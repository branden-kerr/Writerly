<?php
//https://rapidapi.com/blog/proxy-app-api-key-spa-development/
// https://www.cloudways.com/blog/real-time-chat-app-php/
//https://code.tutsplus.com/tutorials/get-started-with-pusher-build-a-chat-app-with-channels-php-and-vuejs--cms-31252
//https://www.cipherbright.com/blog/how-to-develop-wordpress-plugin-with-react/

// http://www.onlinecode.org/php-send-real-time-notification-clients-pusher/

namespace um_ext\um_unsplash\core;


if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Class Profile
 * @package um_ext\um_unsplash\core
 */
class Profile {


	/**
	 * Profile constructor.
	 */
	function __construct() {

		add_filter( 'um_cover_area_content_dropdown_items', array( &$this, 'um_cover_area_content_dropdown_items' ), 10 , 2 );
		add_action( 'wp_footer', array( &$this, 'modal_area' ) );

		add_action( 'um_after_remove_cover_photo', array( &$this, 'remove_unsplash_cover_pic' ), 10, 1 );
		add_action( 'um_after_upload_db_meta_cover_photo', array( &$this, 'remove_unsplash_cover_pic' ), 10, 1 );

		add_filter( 'um_user_cover_photo_uri__filter', array( &$this, 'um_user_cover_photo_uri__filter' ), 10, 3 );
		//add_filter( 'um_get_default_cover_uri_filter', array( &$this, 'um_get_default_cover_uri_filter' ), 20, 1 );

	}


	/**
	 * Add "Select from Unsplash" item to cover image dropdown
	 *
	 * @param $items
	 * @param $profile_id
	 *
	 * @return array
	 */
	function um_cover_area_content_dropdown_items( $items, $profile_id ) {

		$arr = array();
		$arr[] = '<a href="javascript:void(0);" class="um-unsplash-trigger">' . __( 'Select from Unsplash', 'um-unsplash' ) . '</a>';
		$items = array_merge( $arr, $items );
		return $items;

	}


	/**
	 * Load modal window on profile form for select Unsplash image
	 */
	function modal_area() {

		if ( um_is_core_page( 'user' ) && um_get_requested_user() ) {
			UM()->get_template( 'modal.php', um_unsplash_plugin, array(), true );
		}

	}


	/**
	 * Delete Unsplash photo when remove cover photo action is triggered.
	 * Delete Unsplash photo when regular upload cover photo
	 *
	 * @param $user_id
	 */
	function remove_unsplash_cover_pic( $user_id ) {

		delete_user_meta( $user_id, '_um_unsplash_cover' );
		delete_user_meta( $user_id, '_um_unsplash_photo_author' );

	}


	/**
	 * Change cover photo url to display unsplash photo covers
	 *
	 * @param $cover_uri
	 * @param $is_default
	 * @param $attrs
	 *
	 * @return mixed
	 */
	function um_user_cover_photo_uri__filter( $cover_uri, $is_default, $attrs ) {

		$profile_id = UM()->user()->id;
		$unsplash_image = get_user_meta( $profile_id, '_um_unsplash_cover', true );

		if ( $unsplash_image ) {
			$cover_uri = $unsplash_image;

			if ( ! um_is_core_page( 'user' ) &&
			     ! ( wp_doing_ajax() && isset( $_REQUEST['action'] ) && 'um_unsplash_update' == $_REQUEST['action'] ) ) {

				$percent_reduction = ( intval( $attrs ) / 1000 ) * 100;
				$new_height = ( $percent_reduction / 100 ) * 370;
				$cover_uri = str_replace( 'w=1000', 'w=' . $attrs, $cover_uri );
				$cover_uri = str_replace( 'h=370', 'h=' . ceil( $new_height ), $cover_uri );

			}
		}

		return $cover_uri;

	}
}
