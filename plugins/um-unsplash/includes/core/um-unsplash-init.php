<?php if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'UM_Unsplash' ) ) {


	/**
	 * Class UM_Unsplash
	 */
	class UM_Unsplash extends UM_Unsplash_Functions {


		var $proxy_url = 'https://ultimatemember.com/wp-json/unsplash';


		/**
		 * @var
		 */
		private static $instance;


		/**
		 * @return UM_Unsplash
		 */
		static public function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
				self::$instance->_um_unsplash_construct();
			}

			return self::$instance;
		}


		/**
		 * UM_User_Bookmarks constructor.
		 *
		 * @since 1.0
		 */
		function __construct() {
			parent::__construct();
		}


		/**
		 * Unsplash_API constructor.
		 */
		function _um_unsplash_construct() {
			add_filter( 'um_call_object_Unsplash', array( &$this, 'get_this' ) );
			add_filter( 'um_settings_default_values', array( &$this, 'default_settings' ), 10, 1 );

			$license = UM()->options()->get( 'um_unsplash_license_key' );
			if ( empty( $license ) ) {
				$this->admin();
			} else {
				if ( UM()->is_request( 'ajax' ) ) {
					$this->ajax();
				} elseif ( UM()->is_request( 'admin' ) ) {
					$this->admin();
					$this->ajax();
				} elseif ( UM()->is_request( 'frontend' ) ) {
					$this->enqueue();
				}

				$this->profile();
			}
		}


		/**
		 * @return $this
		 */
		function get_this() {
			return $this;
		}


		/**
		 * @param $defaults
		 *
		 * @return array
		 */
		function default_settings( $defaults ) {
			$defaults = array_merge( $defaults, $this->setup()->settings_defaults );
			return $defaults;
		}


		/**
		 * @return um_ext\um_unsplash\core\Unsplash_Setup()
		 */
		function setup() {
			if ( empty( UM()->classes['um_unsplash_setup'] ) ) {
				UM()->classes['um_unsplash_setup'] = new um_ext\um_unsplash\core\Unsplash_Setup();
			}

			return UM()->classes['um_unsplash_setup'];
		}


		/**
		 * @return um_ext\um_unsplash\admin\Admin()
		 */
		function admin() {
			if ( empty( UM()->classes['um_unsplash_admin'] ) ) {
				UM()->classes['um_unsplash_admin'] = new um_ext\um_unsplash\admin\Admin();
			}

			return UM()->classes['um_unsplash_admin'];
		}


		/**
		 * @return um_ext\um_unsplash\core\Unsplash_Enqueue()
		 */
		function enqueue() {
			if ( empty( UM()->classes['um_unsplash_enqueue'] ) ) {
				UM()->classes['um_unsplash_enqueue'] = new um_ext\um_unsplash\core\Unsplash_Enqueue();
			}

			return UM()->classes['um_unsplash_enqueue'];
		}


		/**
		 * @return um_ext\um_unsplash\core\Profile()
		 */
		function profile() {
			if ( empty( UM()->classes['um_unsplash_profile'] ) ) {
				UM()->classes['um_unsplash_profile'] = new um_ext\um_unsplash\core\Profile();
			}

			return UM()->classes['um_unsplash_profile'];
		}


		/**
		 * @return um_ext\um_unsplash\core\Unsplash_Ajax()
		 */
		function ajax() {
			if ( empty( UM()->classes['um_unsplash_ajax'] ) ) {
				UM()->classes['um_unsplash_ajax'] = new um_ext\um_unsplash\core\Unsplash_Ajax();
			}

			return UM()->classes['um_unsplash_ajax'];
		}
	}

}


//create class var
add_action( 'plugins_loaded', 'um_init_unsplash', -10, 1 );
if ( ! function_exists( 'um_init_unsplash' ) ) {
	function um_init_unsplash() {
		if ( function_exists( 'UM' ) ) {
			UM()->set_class( 'Unsplash', true );
		}
	}
}