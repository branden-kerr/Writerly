<?php if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'UM_Unsplash_Functions' ) ) {


	/**
	 * Class UM_Unsplash_Functions
	 */
	class UM_Unsplash_Functions {


		/**
		 * UM_Unsplash_Functions constructor.
		 */
		function __construct() {
			add_action( 'um_cover_area_content', array( $this, 'show_photo_attribution' ), 10, 1 );
			add_action('after_unsplash_cover_update',array($this,'trigger_download_event'),10,2);
		}


		/**
		 *
		 */
		function show_photo_attribution() {
			$cover_pic = get_user_meta( um_profile_id(), '_um_unsplash_cover', true );
			$pic_author = get_user_meta( um_profile_id(), '_um_unsplash_photo_author', true );
			$author_url = get_user_meta( um_profile_id() , '_um_unsplash_photo_author_url', true );
			$download_url = get_user_meta( um_profile_id() , '_um_unsplash_photo_download_url', true );
			$download_url .= '?force=true';

			$author_url .='?utm_source='.UM()->options()->get( 'unsplash_app_name' ).'&utm_medium=referral';

			$unsplash_url = 'https://unsplash.com/?utm_source='.UM()->options()->get( 'unsplash_app_name' ).'&utm_medium=referral';

			if ( $cover_pic && $pic_author ) { ?>

				<span class="um-unsplash-attribution">
					<?php printf( __( 'Photo by <a target="_blank" class="author-url" href="%s">%s</a> on <a target="_blank" href="%s">Unsplash</a>', 'um-unsplash' ), $author_url, ucfirst( esc_html( $pic_author )) , $unsplash_url ); ?>
				</span>

			<?php }
		}






		function trigger_download_event( $user_id, $photo_download_url ){

			$get_app_name = file_get_contents( UM()->Unsplash()->proxy_url . '/appname/' . UM()->options()->get( 'um_unsplash_license_key' ) );
			$app_name_arr = json_decode( $get_app_name );

			$photo_id = get_user_meta( $user_id , '_um_unsplash_photo_id', true );
			$url = UM()->Unsplash()->proxy_url . 'download/' . UM()->options()->get( 'um_unsplash_license_key' ) . '/' . $photo_id;
			$data = file_get_contents( $url );
			UM()->options()->update( 'unsplash_app_name' , esc_attr( $app_name_arr->data ) );


		}







		/*
		*
		*/

		function get_unsplash_auth_token(){

			$access_key = UM()->options()->get( 'unsplash_access_key' );
			$secrete_key = UM()->options()->get( 'unsplash_secret_key' );
			$application_name = UM()->options()->get( 'unsplash_app_name' );
			$redirect_url = UM()->options()->get( 'unsplash_redirect_uri' );

			// $code = '4fb73091ab07498bae82feaafd37ab222c526cc636803aff9e702b7b3f8b6f2c';

			// $access_token = '7415a62a107c2002ec2cfd13157ad4a8347580e805762c51e61a03ac6966f93e'

			$data = [
				'client_id' => $access_key,
				'client_secret' => $secrete_key,
				'redirect_uri' => $redirect_url,
				'code'	=> 'asckjlksjflkjflajsf',
				'grant_type' => 'authorization_code'
			];



			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://unsplash.com/oauth/token");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$response = curl_exec($ch);
			curl_close ($ch);

			echo  $response;
			die;

		}


	}
}
