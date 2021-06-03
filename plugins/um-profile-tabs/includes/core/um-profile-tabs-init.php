<?php if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Class UM_Profile_Tabs
 */
class UM_Profile_Tabs {


	/**
	 * @var
	 */
	private static $instance;


	/**
	 * @return UM_Profile_Tabs
	 */
	static public function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


	/**
	 * UM_Profile_Tabs constructor.
	 */
	function __construct() {
		add_filter( 'um_call_object_Profile_Tabs', [ &$this, 'get_this' ] );

		if ( UM()->is_request( 'admin' ) ) {
			$this->admin();
		}

		$this->common();
		$this->profile();
	}


	/**
	 * @return $this
	 */
	function get_this() {
		return $this;
	}


	/**
	 * @return um_ext\um_profile_tabs\admin\Admin()
	 */
	function admin() {
		if ( empty( UM()->classes['um_profile_tabs_admin'] ) ) {
			UM()->classes['um_profile_tabs_admin'] = new um_ext\um_profile_tabs\admin\Admin();
		}
		return UM()->classes['um_profile_tabs_admin'];
	}


	/**
	 * @return um_ext\um_profile_tabs\core\Common()
	 */
	function common() {
		if ( empty( UM()->classes['um_profile_tabs_common'] ) ) {
			UM()->classes['um_profile_tabs_common'] = new um_ext\um_profile_tabs\core\Common();
		}
		return UM()->classes['um_profile_tabs_common'];
	}


	/**
	 * @return um_ext\um_profile_tabs\core\Profile()
	 */
	function profile() {
		if ( empty( UM()->classes['um_profile_tabs_profile'] ) ) {
			UM()->classes['um_profile_tabs_profile'] = new um_ext\um_profile_tabs\core\Profile();
		}
		return UM()->classes['um_profile_tabs_profile'];
	}
}


//create class var
add_action( 'plugins_loaded', 'um_init_um_profile_tabs', -10, 1 );
function um_init_um_profile_tabs() {
	if ( function_exists( 'UM' ) ) {
		UM()->set_class( 'Profile_Tabs', true );
	}
}