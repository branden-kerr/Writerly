<?php
namespace um_ext\um_unsplash\core;


if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Class Unsplash_Ajax
 * @package um_ext\um_unsplash\core
 */

class Unsplash_Ajax {


	/**
	 * Unsplash_Ajax constructor.
	 */

	function __construct() {

		add_action( 'wp_ajax_um_unsplash_update' , array( $this, 'um_unsplash_save_cover_photo' ) );

	}


	/**
	 * Saves unsplash photo for cover image
	 */
	function um_unsplash_save_cover_photo() {

		if ( ! is_user_logged_in() ) {

			wp_send_json_error( __( 'You need to be logged in to perform this action.', 'um-unsplash' ) );

		}

		if ( ! wp_verify_nonce( $_POST['_wpnonce'] , 'um_unsplash_save_photo' ) ) {

			wp_send_json_error( __( 'Invalid nonce.', 'um-unsplash' ) );

		}

		$user_id = intval( $_POST['profile'] );

		$image = esc_attr( $_POST['unsplash_img'] );

		$photo_author = esc_attr( $_POST['photo_author'] );

		$photo_author_url = esc_attr( $_POST['photo_author_url'] );

		$photo_download_url = esc_attr( $_POST['photo_download_url'] );

		$photo_id = esc_attr( $_POST['photo_id'] );

		$image = str_replace( 'q=85', 'q=100', $image );

		if ( ! get_user_meta( $user_id,'cover_photo',true ) ) {

			add_user_meta( $user_id, 'cover_photo', 'cover_photo.jpg' );

		} else {

			UM()->files()->delete_core_user_photo( $user_id, 'cover_photo' );

		}

		update_user_meta( $user_id , '_um_unsplash_cover', $image );

		update_user_meta( $user_id , '_um_unsplash_photo_author', $photo_author );

		update_user_meta( $user_id , '_um_unsplash_photo_author_url', $photo_author_url );

		update_user_meta( $user_id , '_um_unsplash_photo_download_url', $photo_download_url );

		update_user_meta( $user_id , '_um_unsplash_photo_id', $photo_id );

		do_action( 'after_unsplash_cover_update' , $user_id , $photo_download_url );

		um_fetch_user( $user_id );

		$data = array(

			'image'     => str_replace( '&amp;', '&', $image ),
			'img_html'  => um_user( 'cover_photo' )

		);

		wp_send_json_success( $data );
	}
}
