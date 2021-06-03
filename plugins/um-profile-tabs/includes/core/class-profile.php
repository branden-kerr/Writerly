<?php
namespace um_ext\um_profile_tabs\core;


if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Class Profile
 *
 * @package um_ext\um_profile_tabs\core
 */
class Profile {


	/**
	 * @var array
	 */
	protected $tabs = [];


	private $inited = false;


	/**
	 * Profile constructor.
	 */
	function __construct() {
		// init the custom tabs until the using
		add_filter( 'um_profile_tabs', [ $this, 'predefine_tabs' ], 1, 1 );
		add_filter( 'um_profile_tabs', [ &$this, 'add_tabs' ], 9999, 1 );

		add_filter( 'um_user_profile_tabs', [ &$this, 'profile_tab_display_settings' ], 10, 1 );


		add_filter( 'um_user_profile_tabs', [ &$this, 'profile_tabs_order' ], 9999999, 1 );
		add_filter( 'um_user_profile_tabs', [ &$this, 'profile_tabs_titles' ], 9999999, 1 );

		add_action( 'um_user_after_updating_profile', [ $this, 'redirect_to_current_tab' ], 100, 3 );
		add_filter( 'um_edit_profile_cancel_uri', [ $this, 'redirect_to_current_tab_after_cancel' ], 10, 1 );

		// cf7 support
		add_filter( 'wpcf7_form_hidden_fields', [ $this, 'add_profile_id_on_cf7' ] );
		add_filter( 'wpcf7_mail_components', [ $this, 'change_email_to_profile_owner_email' ], 10, 3 );
	}


	/**
	 * @param $tab
	 *
	 * @return mixed
	 */
	function get_slug( $tab ) {
		$slug = get_post_meta( $tab->ID, 'um_tab_slug', true );
		if ( UM()->external_integrations()->is_wpml_active() ) {
			global $sitepress;

			$tab_id = $sitepress->get_object_id( $tab->ID, 'um_profile_tabs', true, $sitepress->get_default_language() );
			if ( $tab_id && $tab_id != $tab->ID ) {
				$slug = get_post_meta( $tab_id, 'um_tab_slug', true );
			}
		}

		return $slug;
	}


	/**
	 * Init tabs before the first using UM()->profile()->tabs()
	 *
	 * @param $tabs
	 *
	 * @return mixed
	 */
	function predefine_tabs( $tabs ) {
		if ( $this->inited ) {
			return $tabs;
		}

		$profile_tabs = get_posts( [
			'post_type'         => 'um_profile_tabs',
			'orderby'           => 'menu_order',
			'posts_per_page'    => -1,
		] );

		foreach ( $profile_tabs as $tab ) {

			$slug = $this->get_slug( $tab );
			if ( isset( $this->tabs[ $slug ] ) ) {
				continue;
			}

			$icon = get_post_meta( $tab->ID, 'um_icon',true );
			if ( ! $icon ) {
				$icon = 'um-faicon-check';
			}

			if ( UM()->external_integrations()->is_wpml_active() ) {
				global $sitepress;

				$tab_id = $sitepress->get_object_id( $tab->ID, 'um_profile_tabs', true, $sitepress->get_current_language() );
				if ( $tab_id && $tab_id != $tab->ID ) {
					$tab = get_post( $tab_id );
				}
			}

			$tab = [
				'tabid'     => $slug,
				'id'        => $tab->ID,
				'icon'      => $icon,
				'title'     => $tab->post_title,
				'content'   => $tab->post_content,
				'form'      => get_post_meta( $tab->ID, 'um_form', true ),
			];

			$this->tabs[ $slug ] = $tab;

			// Show content
			add_action( 'um_profile_content_' . $tab['tabid'], function( $args ) use ( $tab ) {
				$userdata = get_userdata( um_profile_id() );

				$tab_content = wpautop( $tab['content'] );

				$placeholders = [
					'{profile_id}'              => um_profile_id(),
					'{first_name}'              => $userdata->first_name,
					'{last_name}'               => $userdata->last_name,
					'{user_email}'              => $userdata->user_email,
					'{display_name}'            => $userdata->display_name,
					'[ultimatemember form_id='  => '[',
				];
				$tab_content = str_replace( array_keys( $placeholders ), array_values( $placeholders ), $tab_content );

				ob_start();

				echo apply_filters( 'the_content', $tab_content ); ?>

				<div class="um-clear"></div>

				<?php echo $this->um_custom_tab_form( $tab['tabid'], $tab['form'] );

				echo ob_get_clean();
			});

		}

		$this->inited = true;

		return $tabs;
	}


	/**
	 * @param $tabs
	 *
	 * @return mixed
	 */
	function add_tabs( $tabs ) {
		foreach ( $this->tabs as $tab ) {
			$tabs[ $tab['tabid'] ] = [
				'ID'                => $tab['id'],
				'name'              => $tab['title'],
				'icon'              => $tab['icon'],
				'is_custom_added'   => true, // it's data for wp-admin Profile Tabs order to make not editable title
			];
		}

		return $tabs;
	}


	/**
	 * Check an access for the tabs
	 *
	 * @param $tabs
	 *
	 * @return mixed
	 */
	function profile_tab_display_settings( $tabs ) {
		foreach ( $this->tabs as $tab ) {
			if ( empty( $tabs[ $tab['tabid'] ] ) ) {
				continue;
			}

			$tab_id = $tab['id'];
			if ( UM()->external_integrations()->is_wpml_active() ) {
				global $sitepress;

				$default_lang_tab_id = $sitepress->get_object_id( $tab_id, 'um_profile_tabs', true, $sitepress->get_default_language() );
				if ( $default_lang_tab_id && $default_lang_tab_id != $tab_id ) {
					$tab_id = $default_lang_tab_id;
				}
			}

			$forms_ids = get_post_meta( $tab_id, '_can_have_this_tab_forms',true );
			// check by the form ID
			if ( ! empty( $forms_ids ) && isset( UM()->shortcodes()->form_id ) && ! in_array( UM()->shortcodes()->form_id, $forms_ids ) ) {
				unset( $tabs[ $tab['tabid'] ] );
				continue;
			}
			// check by the profile owner role
			if ( ! $this->can_have_tab( $tab_id ) ) {
				unset( $tabs[ $tab['tabid'] ] );
				continue;
			}
		}

		return $tabs;
	}


	/**
	 * Check if user has the current tab by role
	 *
	 * @param string $tab_id
	 * @param int|null $profile_id
	 *
	 * @return bool
	 */
	function can_have_tab( $tab_id , $profile_id = null ) {
		if ( $profile_id == null ) {
			$profile_id = um_profile_id();
		}

		$can_have = get_post_meta( $tab_id, '_can_have_this_tab_roles', true );
		if ( empty( $can_have ) ) {
			return true;
		}

		$current_user_roles = UM()->roles()->get_all_user_roles( $profile_id );

		if ( ! is_array( $current_user_roles ) ) {
			$current_user_roles = [];
		}

		if ( array_intersect( $current_user_roles, $can_have ) ) {
			return true;
		}

		return false;
	}


	/**
	 * Change profile tabs order
	 *
	 * @param array $tabs
	 *
	 * @return array
	 */
	function profile_tabs_order( $tabs ) {
		$custom_order = UM()->options()->get( 'profile_tabs_order' );

		if ( empty( $custom_order ) ) {
			return $tabs;
		}

		$items_ordered = explode( ',', $custom_order );

		if ( ! is_array( $items_ordered ) ) {
			return $tabs;
		}

		uksort( $tabs, function( $a, $b ) use ( $items_ordered ) {

			$arr_flip = array_flip( $items_ordered );

			if ( ! isset( $arr_flip[ $a ] ) || ! isset( $arr_flip[ $b ] ) ) {
				return -1;
			}

			if ( $arr_flip[ $a ] == $arr_flip[ $b ] ) {
				return 0;
			}

			return ( $arr_flip[ $a ] < $arr_flip[ $b ] ) ? -1 : 1;
		} );

		return $tabs;
	}


	/**
	 * Customize profile tabs names
	 *
	 * @param array $tabs
	 *
	 * @return array
	 */
	function profile_tabs_titles( $tabs ) {
		$custom_titles = UM()->options()->get( 'tabs_custom_titles' );

		if ( empty( $custom_titles ) ) {
			return $tabs;
		}

		foreach ( $tabs as $tab_id => &$tab_data ) {
			if ( ! empty( $custom_titles[ $tab_id ] ) ) {
				$tab_data['name'] = $custom_titles[ $tab_id ];
			}
		}

		return $tabs;
	}

	
	/**
	 * Generate content for custom tabs
	 * 
	 * @param  string   $tab_id
	 * @param  int|null $form
	 * 
	 * @return string
	 */
	function um_custom_tab_form( $tab_id, $form = null ) {
		if ( empty( $form ) ) {
			return '';
		}

		$tab = $tab_id;
		$edit_action = 'edit_' . $tab;
		$profile_url = um_user_profile_url( um_profile_id() );

		$edit_url = add_query_arg( [ 'profiletab' => $tab, 'um_action' => $edit_action ], $profile_url );
		$tab_url = add_query_arg( [ 'profiletab' => $tab ], $profile_url );

		$edit_mode = false;
		if ( isset( $_GET['um_action'] ) && $_GET['um_action'] == $edit_action ) {
			if ( UM()->roles()->um_current_user_can( 'edit', um_profile_id() ) ) {
				$edit_mode = true;
			}
		}

		// save profile settings
		$set_id = UM()->fields()->set_id;
		$set_mode = UM()->fields()->set_mode;
		$editing = UM()->fields()->editing;
		$viewing = UM()->fields()->viewing;

		// set profile settings
		$form_id = intval( $form );
		UM()->fields()->set_id = $form_id;
		UM()->fields()->set_mode = get_post_meta( $form_id, '_um_mode', true );
		UM()->fields()->editing = $edit_mode;
		UM()->fields()->viewing = !$edit_mode;

		$contents = '';
		ob_start();

		if ( $edit_mode ) { ?>
			<form method="post" action="">
		<?php }

		$args['form_id'] = intval( $form );
		$args['primary_btn_word'] = __( 'Update', 'um-profile-tabs' );

		do_action( 'um_before_form', $args );
		do_action( 'um_before_profile_fields', $args );
		do_action( 'um_main_profile_fields', $args );
		do_action( 'um_after_form_fields', $args );
		do_action( 'um_after_profile_fields', $args );

		if ( $edit_mode ) { ?>
				<input type="hidden" name="redirect_tab" value="<?php echo esc_url( $tab_url ) ?>'"/>
			</form>
		<?php } elseif ( UM()->roles()->um_current_user_can( 'edit', um_profile_id() ) ) { ?>

			<a href="<?php echo esc_url( $edit_url ) ?>" class="um-modal-btn"><i class="um-faicon-pencil"></i> <?php _e( 'Edit', 'um-profile-tabs' ) ?></a>

		<?php }
		$contents .= ob_get_clean();

		// restore default profile settings
		UM()->fields()->set_id = $set_id;
		UM()->fields()->set_mode = $set_mode;
		UM()->fields()->editing = $editing;
		UM()->fields()->viewing = $viewing;

		return $contents;
	}


	/**
	 * Redirect to current tab after form update
	 *
	 * @param int $user_id
	 * @param array $args
	 * @param array $to_update
	 */
	function redirect_to_current_tab( $to_update, $user_id, $args ) {
		if ( isset( $args['submitted']['redirect_tab'] ) ) {
			exit( wp_redirect( $args['submitted']['redirect_tab'] ) );
		}
	}


	/**
	 * Redirect to current tab after cancel form update
	 *
	 * @param $url
	 *
	 * @return string
	 */
	function redirect_to_current_tab_after_cancel( $url ) {
		if ( isset( $_GET['profiletab'], $_GET['um_action'] ) && $_GET['profiletab'] != 'main' ) {
			$url = add_query_arg( [ 'profiletab' => $_GET['profiletab'] ], um_user_profile_url( um_profile_id() ) );
		}
		
		return $url;
	}


	/**
	 * Add profile id on cf7 form
	 *
	 * @param $fields
	 *
	 * @return mixed
	 */
	function add_profile_id_on_cf7( $fields ) {
		if ( um_is_core_page( 'user' ) ) {
			$fields['_wpcf7_um_profile_id'] = um_profile_id();
		}

		return $fields;
	}


	/**
	 * @param $args
	 * @param $contact_form
	 * @param $class
	 *
	 * @return mixed
	 */
	function change_email_to_profile_owner_email( $args, $contact_form, $class ) {
		if ( class_exists( '\WPCF7_Submission' ) ) {
			$submission = \WPCF7_Submission::get_instance();
			$page = $submission->get_meta( 'container_post_id' );



			// getting User Profile predefined page ID, use WPML for getting proper ID
			$page_id = UM()->options()->get( 'core_user' );
			if ( UM()->external_integrations()->is_wpml_active() ) {
				global $sitepress;

				$current_lang_page_id = $sitepress->get_object_id( $page_id, 'page', true, $sitepress->get_current_language() );
				if ( $current_lang_page_id && $current_lang_page_id != $page_id ) {
					$page_id = $current_lang_page_id;
				}
			}

			if ( (int) $page_id === (int) $page ) {
				if ( ! empty( $_REQUEST['_wpcf7_um_profile_id'] ) ) {
					$user = get_user_by( 'ID', absint( $_REQUEST['_wpcf7_um_profile_id'] ) );
					if ( ! is_wp_error( $user ) && isset( $user->user_email ) && is_email( $user->user_email ) ) {
						$args['recipient'] = $user->user_email;
					}
				}
			}
		}

		return $args;
	}
}
