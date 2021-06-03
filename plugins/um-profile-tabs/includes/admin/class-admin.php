<?php
namespace um_ext\um_profile_tabs\admin;


if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'um_ext\um_profile_tabs\admin\Admin' ) ) {


	/**
	 * Class Admin
	 * @package um_ext\um_profile_tabs\admin
	 */
	class Admin {


		/**
		 * Admin constructor.
		 */
		function __construct() {
			add_filter( 'um_settings_structure', [ &$this, 'extend_settings' ], 10, 1 );

			add_action( 'admin_menu', [ $this, 'create_admin_submenu' ], 1001 );

			add_action( 'load-post.php', [ &$this, 'add_metabox' ], 9 );
			add_action( 'load-post-new.php', [ &$this, 'add_metabox' ], 9 );

			add_filter( 'um_is_ultimatememeber_admin_screen', [ &$this, 'is_um_screen' ], 10, 1 );
			add_filter( 'um_render_sortable_items_item_html', [ &$this, 'customize_pre_defined_titles_html' ], 10, 3 );
		}


		/**
		 * Additional Settings for Profile Tabs extension
		 *
		 * @param array $settings
		 *
		 * @return array
		 */
		function extend_settings( $settings ) {
			$settings['licenses']['fields'][] = [
				'id'        => 'um_profile_tabs_license_key',
				'label'     => __( 'Profile tabs License Key', 'um-profile-tabs' ),
				'item_name' => 'Profile tabs',
				'author'    => 'Ultimate Member',
				'version'   => um_profile_tabs_version,
			];

			$tabs = UM()->profile()->tabs();

			$tabs_items = [];
			$tabs_condition = [];
			foreach ( $tabs as $id => $tab ) {
				if ( ! empty( $tab['hidden'] ) ) {
					continue;
				}

				if ( isset( $tab['name'] ) ) {
					$tabs_items[ $id ] = $tab['name'];
					$tabs_condition[] = 'profile_tab_' . $id;
				}

				foreach ( $settings['appearance']['sections']['profile_menu']['fields'] as $k => &$data ) {
					if ( $data['id'] == 'profile_tab_' . $id ) {
						$data['data']['fill_profile_tabs_order'] = $id;
						break;
					}
				}
			}

			$settings['appearance']['sections']['profile_menu']['fields'][] = [
				'id'            => 'profile_tabs_order',
				'type'          => 'sortable_items',
				'label'         => __( 'Profile Tabs Order', 'um-profile-tabs' ),
				'items'         => $tabs_items,
				'conditional'   => [ implode( '|', $tabs_condition ), '~', 1 ],
				'size'          => 'small',
				'tooltip'       => __( 'Pay an attention that default tab ignore the order and will be displayed the first', 'um-profile-tabs' ),
			];

			return $settings;
		}


		/**
		 * Add UM submenu for Profile Tabs
		 */
		function create_admin_submenu() {
			add_submenu_page( 'ultimatemember', __( 'Profile Tabs', 'um-profile-tabs' ), __( 'Profile Tabs', 'um-profile-tabs' ), 'manage_options', 'edit.php?post_type=um_profile_tabs' );
		}


		/**
		 * Extends UM admin pages for enqueue scripts
		 *
		 * @param $is_um
		 *
		 * @return bool
		 */
		function is_um_screen( $is_um ) {
			global $current_screen;
			if ( strstr( $current_screen->id, 'um_profile_tabs' ) ) {
				$is_um = true;
			}

			return $is_um;
		}


		/**
		 * Render the settings field for changing profile tabs order
		 *
		 * @param string $content
		 * @param string $tab_id
		 * @param array $field_data
		 *
		 * @return string
		 */
		function customize_pre_defined_titles_html( $content, $tab_id, $field_data ) {
			if ( $field_data['id'] == 'profile_tabs_order' ) {
				$tabs = UM()->profile()->tabs();

				if ( empty( $tabs[ $tab_id ] ) ) {
					return $content;
				}

				if ( ! empty( $tabs[ $tab_id ]['is_custom_added'] ) ) {
					return $content;
				}

				$custom_titles = UM()->options()->get( 'tabs_custom_titles' );

				$value = $content;
				if ( ! empty( $custom_titles[ $tab_id ] ) ) {
					$value = $custom_titles[ $tab_id ];
				}

				$content = '<input type="text" name="um_options[tabs_custom_titles][' . $tab_id . ']" value="' . esc_attr( $value ) . '"/>';
			}

			return $content;
		}


		/**
		 * Add metaboxes with options to Add/Edit Profile Tab screen
		 */
		function add_metabox() {
			global $current_screen;

			if ( $current_screen->id == 'um_profile_tabs' ) {
				add_action( 'add_meta_boxes', [ &$this, 'profile_tab_metaboxes' ], 1 );
				add_action( 'save_post', [ &$this, 'save_meta_data' ], 10, 3 );
			}
		}


		/**
		 * Add metaboxes
		 */
		function profile_tab_metaboxes() {
			// don't show metaboxes for translations
			if ( UM()->external_integrations()->is_wpml_active() ) {
				global $post, $sitepress;

				$tab_id = $sitepress->get_object_id( $post->ID, 'um_profile_tabs', true, $sitepress->get_default_language() );
				if ( $tab_id && $tab_id != $post->ID ) {
					return;
				}
			}

			add_meta_box(
				"um-admin-custom-profile-tab/access{" . um_profile_tabs_path . "}",
				__( 'Display Settings', 'um-profile-tabs' ),
				[ UM()->metabox(), 'load_metabox_custom' ],
				'um_profile_tabs',
				'side',
				'default'
			);

			add_meta_box(
				"um-admin-custom-profile-tab/icon{" . um_profile_tabs_path . "}",
				__( 'Customize this tab', 'um-profile-tabs' ),
				[ UM()->metabox(), 'load_metabox_custom' ],
				'um_profile_tabs',
				'side',
				'default'
			);

			add_meta_box(
				"um-admin-custom-profile-tab/um-form{" . um_profile_tabs_path . "}",
				__( 'Pre-defined content', 'um-profile-tabs' ),
				[ UM()->metabox(), 'load_metabox_custom' ],
				'um_profile_tabs',
				'side',
				'default'
			);
		}


		/**
		 * Save Profile Tab metabox settings
		 *
		 * @param int $post_id
		 * @param \WP_Post $post
		 * @param bool $update
		 */
		function save_meta_data( $post_id, $post, $update ) {
			//make this handler only on product form submit
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
				return;
			}

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			if ( empty( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'update-post_' . $post_id ) ) {
				return;
			}

			if ( empty( $post->post_type ) || 'um_profile_tabs' != $post->post_type ) {
				return;
			}

			if ( UM()->external_integrations()->is_wpml_active() ) {
				global $sitepress;

				$tab_id = $sitepress->get_object_id( $post_id, 'um_profile_tabs', true, $sitepress->get_default_language() );
				if ( $tab_id && $tab_id != $post_id ) {
					return;
				}
			}

			if ( empty( $_POST['um_profile_tab'] ) ) {
				return;
			}

			$icon = '';
			if ( isset( $_POST['um_profile_tab']['_icon'] ) ) {
				$icon = sanitize_key( $_POST['um_profile_tab']['_icon'] );
			}
			update_post_meta( $post_id, 'um_icon', $icon );

			$form = '';
			if ( isset( $_POST['um_profile_tab']['_um_form'] ) ) {
				$form = absint( $_POST['um_profile_tab']['_um_form'] );
			}
			update_post_meta( $post_id, 'um_form', $form );

			if ( ! empty( $_POST['um_profile_tab']['_can_have_this_tab_roles'] ) ) {
				update_post_meta( $post_id, '_can_have_this_tab_roles', $_POST['um_profile_tab']['_can_have_this_tab_roles'] );
			} else {
				update_post_meta( $post_id, '_can_have_this_tab_roles', [] );
			}

			if ( ! empty( $_POST['um_profile_tab']['_can_have_this_tab_forms'] ) ) {
				update_post_meta( $post_id, '_can_have_this_tab_forms', $_POST['um_profile_tab']['_can_have_this_tab_forms'] );
			} else {
				update_post_meta( $post_id, '_can_have_this_tab_forms', [] );
			}

			// sanitize slug, avoid not latin|numeric symbols in slugs
			if ( preg_match( "/[a-z0-9]+$/i", urldecode( $post->post_name ) ) ) {
				$tab_slug = sanitize_title( $post->post_name );
			} else {
				// otherwise use autoincrement and slug generator
				$auto_increment = UM()->options()->get( 'custom_profiletab_increment' );
				$auto_increment = ! empty( $auto_increment ) ? $auto_increment : 1;
				$tab_slug = "custom_profiletab_{$auto_increment}";
			}

			$old_slug = get_post_meta( $post_id, 'um_tab_slug', true );

			// slug is unique for all languages, use 1 for all langs
			// UM options UM Appearances > Profile Tabs are based on these slugs
			// update autoincrement option if slug generator has been used
			// make these action only on create profile tab post or if there isn't post meta
			if ( $update !== true || ! $old_slug ) {

				if ( UM()->external_integrations()->is_wpml_active() ) {
					global $sitepress;

					$tab_id = $sitepress->get_object_id( $post_id, 'um_profile_tabs', true, $sitepress->get_default_language() );
					if ( $tab_id && $tab_id == $post_id ) {
						update_post_meta( $post_id, 'um_tab_slug', $tab_slug );

						if ( isset( $auto_increment ) ) {
							$auto_increment++;
							UM()->options()->update( 'custom_profiletab_increment', $auto_increment );
						}

						// show new profile tab by default - update UM Appearances > Profile Tabs settings
						if ( UM()->options()->get( 'profile_tab_' . $tab_slug ) === '' ) {
							UM()->options()->update( 'profile_tab_' . $tab_slug, '1' );
							UM()->options()->update( 'profile_tab_' . $tab_slug . '_privacy', '0' );
						}
					}
				} else {
					update_post_meta( $post_id, 'um_tab_slug', $tab_slug );

					if ( isset( $auto_increment ) ) {
						$auto_increment++;
						UM()->options()->update( 'custom_profiletab_increment', $auto_increment );
					}

					// show new profile tab by default - update UM Appearances > Profile Tabs settings
					if ( UM()->options()->get( 'profile_tab_' . $tab_slug ) === '' ) {
						UM()->options()->update( 'profile_tab_' . $tab_slug, '1' );
						UM()->options()->update( 'profile_tab_' . $tab_slug . '_privacy', '0' );
					}
				}
			}
		}
	}
}