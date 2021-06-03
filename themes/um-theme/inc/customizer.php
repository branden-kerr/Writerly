<?php
/**
 *
 * @package um-theme
 */
function um_theme_customize_register( $wp_customize ) {
	global $defaults;

	if ( class_exists( 'WP_Customize_Control' ) ) {
		/**
		 * Customizer Line Break
		 */
		if ( ! class_exists( 'UM_Theme_Helper_Line_Break' ) ) {
			class UM_Theme_Helper_Line_Break extends WP_Customize_Control {
				/**
				 * Render the hr.
				 */
				public function render_content() {
					echo '<span class="um-customizer-line">';
					echo '<hr />';
					echo '</span>';
				}
			}
		}

		/**
		 * Customizer Title Control with Description
		 */
		if ( ! class_exists( 'UM_Theme_UI_Helper_Title' ) ) {
			class UM_Theme_UI_Helper_Title extends WP_Customize_Control {
				public $type 	= 'info';
				public $class 	= '';
				/**
				 * Render the label & description.
				 */
				public function render_content() {
				?>
					<label class="<?php echo esc_attr( $this->class ); ?>">
					<?php if ( ! empty( $this->label ) ) : ?>
						<span class="customize-control-title ui__title">
							<?php echo esc_html( $this->label ); ?>
						</span>
					<?php endif; ?>
					</label>

					<?php if ( ! empty( $this->description ) ) : ?>
						<span class="description customize-control-description">
							<?php echo esc_attr( $this->description ); ?>
						</span>
					<?php endif; ?>

					<?php if ( ! $this->value() ) : ?>
						<?php echo esc_attr( $this->value() ); ?>
					<?php endif; ?>

					<?php
				}
			}
		}

		/**
		 * Google Fonts Dropdown
		 */
		if ( ! class_exists( 'Google_Font_Dropdown_Custom_Control' ) ) {
			class Google_Font_Dropdown_Custom_Control extends WP_Customize_Control {

				private $fonts = false;

				public function __construct( $manager, $id, $args = array(), $options = array() ) {
					$this->fonts = $this->get_google_fonts();
					parent::__construct( $manager, $id, $args );
				}

				/**
				 * Render the Google Font dropdown.
				 */
				public function render_content() {
					?>
						<label class="customize_dropdown_input">
							<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
							<select id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" data-customize-setting-link="<?php echo esc_attr( $this->id ); ?>">
								<?php
									if ( $this->fonts ) {
										foreach ( $this->fonts as $k => $v ) {
											echo '<option value="'.$v['family'].'" ' . selected( $this->value(), $v['family'], false ) . '>'.$v['family'].'</option>';
										}
									}
								?>
							</select>
						</label>
					<?php
				}

				public function get_google_fonts() {

					$google_fonts_file = (string) apply_filters( 'umtheme_google_fonts_json_file', UM_THEME_DIR . 'inc/webfonts/google-fonts.json' );

					if ( ! file_exists( $google_fonts_file ) ) {
						return array();
					}

					global $wp_filesystem;

					// Initialize the WP filesystem.
					if ( empty( $wp_filesystem ) ) {
						require_once( ABSPATH . '/wp-admin/includes/file.php' );
						WP_Filesystem();
					}

					if (
						$wp_filesystem->is_file( $google_fonts_file ) &&
						$wp_filesystem->is_readable( $google_fonts_file )
					) {
						$file_contants = $wp_filesystem->get_contents( $google_fonts_file );
					}

					$content = json_decode( $file_contants, true );

					return $content['items'];
				}
			}
		}
	}

	/*--------------------------------------------------------------
	## 1.0 Panels
	--------------------------------------------------------------*/
		// Global Styles Panel
		$wp_customize->add_panel( 'customizer_colors_panel',
			array(
				'priority'       => 2,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__( 'General Styles','um-theme' ),
				'description'    => esc_html__( 'Customize your sites color and font','um-theme' ),
			)
		);
		// Homepage Panel
		$wp_customize->add_panel( 'customizer_homepage_panel',
			array(
				'priority'       => 3,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__( 'Homepage','um-theme' ),
				'description'    => esc_html__( 'Your Homepage Sections','um-theme' ),
			)
		);
		// Header Panel
		$wp_customize->add_panel( 'customizer_header_panel',
			array(
				'priority'       => 4,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__( 'Header','um-theme' ),
				'description'    => esc_html__( 'Customize your sites Header Colors & Layout','um-theme' ),
			)
		);

		// Global Layout Panel
		$wp_customize->add_panel( 'customizer_component_layout_panel',
			array(
				'priority'       => 5,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__( 'Content','um-theme' ),
				'description'    => esc_html__( 'Change layout of post archive & single posts.','um-theme' ),
			)
		);
		// Footer Panel
		$wp_customize->add_panel( 'customizer_footer_panel',
			array(
				'priority'       => 6,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__( 'Footer','um-theme' ),
				'description'    => esc_html__( 'Customize your sites Footer Section Colors & Layout','um-theme' ),
			)
		);
		// Code Panel
		$wp_customize->add_panel( 'customizer_panel_code_panel',
			array(
				'priority'       => 7,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__( 'Code','um-theme' ),
				'description'    => esc_html__( 'Add JavaScript code to header, footer etc.','um-theme' ),
			)
		);

		// Ultimate Member
		$wp_customize->add_panel( 'customizer_panel_um_plugin_panel',
			array(
				'priority'       => 8,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__( 'Ultimate Member','um-theme' ),
				'description'    => esc_html__( 'Change layout of Ultimate Member Plugin elements.','um-theme' ),
			)
		);
		// ForumWP
		$wp_customize->add_panel( 'customizer_panel_forumwp_panel',
			array(
				'priority'       => 8,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__( 'ForumWP','um-theme' ),
				'description'    => esc_html__( 'Change layout of ForumWP Plugin elements.','um-theme' ),
			)
		);
		// bbPress
		$wp_customize->add_panel( 'customizer_panel_bbpress_panel',
			array(
				'priority'       => 9,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__( 'bbPress','um-theme' ),
				'description'    => esc_html__( 'Customize bbPress forum.','um-theme' ),
			)
		);

		// LifterLMS
		$wp_customize->add_panel( 'customizer_panel_lifterlms_panel',
			array(
				'priority'       => 10,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__( 'LifterLMS','um-theme' ),
				'description'    => esc_html__( 'Customize LifterLMS.','um-theme' ),
			)
		);
		// WP Job Manager
		$wp_customize->add_panel( 'customizer_panel_job_manager_panel',
			array(
				'priority'       => 11,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__( 'WP Job Manager','um-theme' ),
				'description'    => esc_html__( 'Customize WP Job Manager.','um-theme' ),
			)
		);
		// Easy Digital Downloads
		$wp_customize->add_panel( 'customizer_panel_easy_digital_downloads',
			array(
				'priority'       => 11,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__( 'Easy Digital Downloads','um-theme' ),
				'description'    => esc_html__( 'Customize Easy Digital Downloads.','um-theme' ),
			)
		);

		// Dokan Multivendor
		$wp_customize->add_panel( 'customizer_panel_dokan_multivendor_panel',
			array(
				'priority'       => 11,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__( 'Dokan Multivendor','um-theme' ),
				'description'    => esc_html__( 'Customize Dokan Multivendor.','um-theme' ),
			)
		);
		// Restrict Content
		$wp_customize->add_panel( 'customizer_panel_rcp_panel',
			array(
				'priority'       => 11,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__( 'Restrict Content','um-theme' ),
				'description'    => esc_html__( 'Customize Restrict Content.','um-theme' ),
			)
		);

		// WPAdverts
		$wp_customize->add_panel( 'customizer_panel_um_wpadverts',
			array(
				'priority'       => 8,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__( 'WPAdverts','um-theme' ),
				'description'    => esc_html__( 'Change color of WPAdverts Plugin elements.','um-theme' ),
			)
		);

		// UM Theme Hooks
		$wp_customize->add_panel( 'customizer_panel_um_theme_hooks_panel',
			array(
				'priority'       => 20,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__( 'Hooks','um-theme' ),
				'description'    => esc_html__( 'Add Shortcodes & text.','um-theme' ),
			)
		);

		// SportsPress
		$wp_customize->add_panel( 'customizer_panel_um_sportspress',
			array(
				'priority'       => 8,
				'capability'     => 'edit_theme_options',
				'title'          => esc_html__( 'SportsPress','um-theme' ),
				'description'    => esc_html__( 'Change color of SportsPress Plugin elements.','um-theme' ),
			)
		);

	/*--------------------------------------------------------------
	## 1.0 Sections
	--------------------------------------------------------------*/
		$wp_customize->get_section( 'static_front_page' )->priority = 1;
		$wp_customize->get_section(	'static_front_page' )->title 	= esc_html__( 'Select Your Frontpage','um-theme' );
		$wp_customize->get_section( 'static_front_page' )->panel 	= 'customizer_homepage_panel';
		$wp_customize->remove_section( 'background_image' );
	/*--------------------------------------------------------------
	## Default Sections
	--------------------------------------------------------------*/
	/*--------------------------------------------------------------
	## General Style Section
	--------------------------------------------------------------*/

	// Site Wide Color
	$wp_customize->add_section( 'customizer_section_global_color',
		array(
			'title' 			=> esc_html__( 'Site Wide Color', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 1,
			'panel' 			=> 'customizer_colors_panel',
		)
	);
	// Text
	$wp_customize->add_section( 'customizer_section_typography_body',
		array(
			'title' 		=> esc_html__( 'Text', 'um-theme' ),
			'capability' 	=> 'edit_theme_options',
			'priority' 		=> 2,
			'panel' 		=> 'customizer_colors_panel',
		)
	);
	// Headings
	$wp_customize->add_section( 'customizer_section_typography_title',
		array(
			'title' 		=> esc_html__( 'Headings', 'um-theme' ),
			'capability' 	=> 'edit_theme_options',
			'priority' 		=> 3,
			'panel' 		=> 'customizer_colors_panel',
		)
	);

	// Sidebar & Widget Area
	$wp_customize->add_section( 'customizer_section_widget_area',
		array(
			'title' 			=> esc_html__( 'Sidebar & Widget Area', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 4,
			'panel' 			=> 'customizer_colors_panel',
		)
	);
	// Buttons
	$wp_customize->add_section( 'customizer_section_button_style',
		array(
			'title' 			=> esc_html__( 'Buttons', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 5,
			'panel' 			=> 'customizer_colors_panel',
		)
	);
	// Social Accounts
	$wp_customize->add_section( 'customizer_style_social_account',
		array(
			'title' 			=> esc_html__( 'Social Accounts', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 7,
			'panel' 			=> 'customizer_colors_panel',
		)
	);

	// Form Fields
	$wp_customize->add_section( 'customizer_style_form_fields',
		array(
			'title' 			=> esc_html__( 'Form Fields', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 8,
			'panel' 			=> 'customizer_colors_panel',
		)
	);

	/*--------------------------------------------------------------
	## Content
	--------------------------------------------------------------*/
		// Post Archive Layouts
		$wp_customize->add_section( 'customizer_section_article_layout',
			array(
				'title' 		=> esc_html__( 'Post Archive', 'um-theme' ),
				'capability' 	=> 'edit_theme_options',
				'priority' 		=> 2,
				'panel' 		=> 'customizer_component_layout_panel',
			)
		);
		// Post Layout
		$wp_customize->add_section( 'customizer_section_single_article_layout',
			array(
				'title' 		=> esc_html__( 'Post Layout', 'um-theme' ),
				'capability' 	=> 'edit_theme_options',
				'priority' 		=> 3,
				'panel' 		=> 'customizer_component_layout_panel',
			)
		);
		// Content Sidebar Management
		$wp_customize->add_section( 'customizer_section_sidebar_management',
			array(
				'title' 		=> esc_html__( 'Sidebar Management', 'um-theme' ),
				'capability' 	=> 'edit_theme_options',
				'priority' 		=> 4,
				'panel' 		=> 'customizer_component_layout_panel',
			)
		);

		// Container Width
		$wp_customize->add_section( 'customizer_section_width_layout',
			array(
				'title' 		=> esc_html__( 'Container Width', 'um-theme' ),
				'capability' 	=> 'edit_theme_options',
				'priority' 		=> 1,
				'panel' 		=> 'customizer_colors_panel',
			)
		);

	/*--------------------------------------------------------------
	## 10.0 Footer Sections
	--------------------------------------------------------------*/
		// Footer Layout
		$wp_customize->add_section( 'customizer_section_footer_layout',
			array(
				'title' 		=> esc_html__( 'Footer - Bottom Bar', 'um-theme' ),
				'capability' 	=> 'edit_theme_options',
				'priority' 		=> 1,
				'panel' 		=> 'customizer_footer_panel',
			)
		);
		// Footer Widgets
		$wp_customize->add_section( 'customizer_section_footer_widget',
			array(
				'title' 		=> esc_html__( 'Footer Widgets', 'um-theme' ),
				'capability' 	=> 'edit_theme_options',
				'priority' 		=> 2,
				'panel' 		=> 'customizer_footer_panel',
			)
		);

	/*--------------------------------------------------------------
	## 4.0 Header Sections
	--------------------------------------------------------------*/
		// Top Bar Layout
		$wp_customize->add_section( 'customizer_section_topbar',
			array(
				'title' 		=> esc_html__( 'Top Bar Layout', 'um-theme' ),
				'capability' 	=> 'edit_theme_options',
				'priority' 		=> 1,
				'panel' 		=> 'customizer_header_panel',
			)
		);
		// Top Bar Style
		$wp_customize->add_section( 'customizer_section_topbar_style',
			array(
				'title' 		=> esc_html__( 'Top Bar Style', 'um-theme' ),
				'capability' 	=> 'edit_theme_options',
				'priority' 		=> 2,
				'panel' 		=> 'customizer_header_panel',
			)
		);
		// Header Logo
		$wp_customize->get_section( 'title_tagline' )->title 				= esc_html__( 'Header Logo','um-theme' );
		$wp_customize->get_section( 'title_tagline' )->priority 			= 3;
		$wp_customize->get_section( 'title_tagline' )->panel 				= 'customizer_header_panel';

		// Header Menu
		$wp_customize->add_section( 'customizer_section_header_navigation_style',
			array(
				'title' 		=> esc_html__( 'Header Menu', 'um-theme' ),
				'capability' 	=> 'edit_theme_options',
				'priority' 		=> 4,
				'panel'			=> 'customizer_header_panel',
			)
		);
		// Header Logged In
		$wp_customize->add_section( 'customizer_section_header_logged_in',
			array(
				'title' 		=> esc_html__( 'Header - Logged In', 'um-theme' ),
				'capability' 	=> 'edit_theme_options',
				'priority' 		=> 5,
				'panel' 		=> 'customizer_header_panel',
			)
		);
		// Header Logged Out
		$wp_customize->add_section( 'customizer_section_header_logged_out',
			array(
				'title' 		=> esc_html__( 'Header - Logged Out', 'um-theme' ),
				'capability' 	=> 'edit_theme_options',
				'priority' 		=> 6,
				'panel' 		=> 'customizer_header_panel',
			)
		);

		// Header Search Section
		$wp_customize->add_section( 'customizer_section_header_search',
			array(
				'title' 		=> esc_html__( 'Header Search', 'um-theme' ),
				'capability' 	=> 'edit_theme_options',
				'priority' 		=> 7,
				'panel' 		=> 'customizer_header_panel',
			)
		);
		// Header Style
		$wp_customize->add_section( 'customizer_section_header_color',
			array(
				'title' 		=> esc_html__( 'Header Style', 'um-theme' ),
				'capability' 	=> 'edit_theme_options',
				'priority' 		=> 8,
				'panel' 		=> 'customizer_header_panel',
			)
		);
		// Bottom Bar Layout
		$wp_customize->add_section( 'customizer_section_bottombar_layout',
			array(
				'title' 		=> esc_html__( 'Bottom Bar Layout', 'um-theme' ),
				'capability' 	=> 'edit_theme_options',
				'priority' 		=> 9,
				'panel' 		=> 'customizer_header_panel',
			)
		);

		// Bottom Bar Style
		$wp_customize->add_section( 'customizer_section_bottombar',
			array(
				'title' 		=> esc_html__( 'Bottom Bar Style', 'um-theme' ),
				'capability' 	=> 'edit_theme_options',
				'priority' 		=> 10,
				'panel' 		=> 'customizer_header_panel',
			)
		);
		// Header Messenger Modal
		$wp_customize->add_section( 'customizer_section_messenger_modal',
			array(
				'title' 			=> esc_html__( 'Header Messenger Modal', 'um-theme' ),
				'capability' 		=> 'edit_theme_options',
				'priority' 			=> 20,
				'panel' 			=> 'customizer_header_panel',
				'active_callback' 	=> 'um_theme_is_active_um_messaging',
			)
		);
		// Header Notificaion Modal
		$wp_customize->add_section( 'customizer_section_notification_modal',
			array(
				'title' 			=> esc_html__( 'Header Notification Modal', 'um-theme' ),
				'capability' 		=> 'edit_theme_options',
				'priority' 			=> 20,
				'panel' 			=> 'customizer_header_panel',
				'active_callback' 	=> 'um_theme_is_active_um_notifications',
			)
		);

		// Header Friend Requests Modal
		$wp_customize->add_section( 'customizer_section_header_requests_modal',
			array(
				'title' 			=> esc_html__( 'Header Friend Requests', 'um-theme' ),
				'capability' 		=> 'edit_theme_options',
				'priority' 			=> 20,
				'panel' 			=> 'customizer_header_panel',
				'active_callback' 	=> 'um_theme_is_active_um_friends',
			)
		);


	/*--------------------------------------------------------------
	## UM Theme Hooks
	--------------------------------------------------------------*/
	// Header
	$wp_customize->add_section( 'customizer_section_um_theme_hooks_header',
		array(
			'title' 			=> esc_html__( 'Header', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 1,
			'panel' 			=> 'customizer_panel_um_theme_hooks_panel',
		)
	);
	// Content
	$wp_customize->add_section( 'customizer_section_um_theme_hooks_content',
		array(
			'title' 			=> esc_html__( 'Content', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 2,
			'panel' 			=> 'customizer_panel_um_theme_hooks_panel',
		)
	);
	// Single Post
	$wp_customize->add_section( 'customizer_section_um_theme_hooks_single_post',
		array(
			'title' 			=> esc_html__( 'Single Post', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 3,
			'panel' 			=> 'customizer_panel_um_theme_hooks_panel',
		)
	);
	// Comment
	$wp_customize->add_section( 'customizer_section_um_theme_hooks_comment',
		array(
			'title' 			=> esc_html__( 'Comment', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 4,
			'panel' 			=> 'customizer_panel_um_theme_hooks_panel',
		)
	);
	// Footer
	$wp_customize->add_section( 'customizer_section_um_theme_hooks_footer',
		array(
			'title' 			=> esc_html__( 'Footer', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 5,
			'panel' 			=> 'customizer_panel_um_theme_hooks_panel',
		)
	);
	/**
	* Colors Panel.
	*/
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_control( 'header_textcolor' )->section 	= 'text_color';


	/*--------------------------------------------------------------
	## Hook Settings
	--------------------------------------------------------------*/
	// Hook Settings - Header
	// um_theme_before_header
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_header_before_header]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_header_before_header',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 1,
					'label'      		=> esc_html__( 'um_theme_before_header', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_header',
					'settings'   		=> 'customization[um_theme_setting_hook_header_before_header]',
				)
			);
	// um_theme_header
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_header]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_header',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 2,
					'label'      		=> esc_html__( 'um_theme_header', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_header',
					'settings'   		=> 'customization[um_theme_setting_hook_header]',
				)
			);
	// um_theme_after_header
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_header_after_header]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_header_after_header',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 3,
					'label'      		=> esc_html__( 'um_theme_after_header', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_header',
					'settings'   		=> 'customization[um_theme_setting_hook_header_after_header]',
				)
			);
	// um_theme_header_profile_before
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_header_profile_before]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_header_profile_before',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 4,
					'label'      		=> esc_html__( 'um_theme_header_profile_before', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_header',
					'settings'   		=> 'customization[um_theme_setting_hook_header_profile_before]',
				)
			);
	// um_theme_header_profile_after
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_header_profile_after]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_header_profile_after',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 5,
					'label'      		=> esc_html__( 'um_theme_header_profile_after', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_header',
					'settings'   		=> 'customization[um_theme_setting_hook_header_profile_after]',
				)
			);
	// Hook Settings - Content
	// um_theme_before_site
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_content_before_site]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_content_before_site',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 1,
					'label'      		=> esc_html__( 'um_theme_before_site', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_content',
					'settings'   		=> 'customization[um_theme_setting_hook_content_before_site]',
				)
			);
	// um_theme_before_content
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_before_content]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_before_content',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 2,
					'label'      		=> esc_html__( 'um_theme_before_content', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_content',
					'settings'   		=> 'customization[um_theme_setting_hook_before_content]',
				)
			);
	// um_theme_content_top
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_content_top]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_content_top',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 3,
					'label'      		=> esc_html__( 'um_theme_content_top', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_content',
					'settings'   		=> 'customization[um_theme_setting_hook_content_top]',
				)
			);
	// um_theme_before_page_content
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_content_before_page]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_content_before_page',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 4,
					'label'      		=> esc_html__( 'um_theme_before_page_content', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_content',
					'settings'   		=> 'customization[um_theme_setting_hook_content_before_page]',
				)
			);
	// um_theme_page
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_content_page]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_content_page',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 5,
					'label'      		=> esc_html__( 'um_theme_page', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_content',
					'settings'   		=> 'customization[um_theme_setting_hook_content_page]',
				)
			);
	// um_theme_after_page_content
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_content_after_page]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_content_after_page',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 6,
					'label'      		=> esc_html__( 'um_theme_after_page_content', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_content',
					'settings'   		=> 'customization[um_theme_setting_hook_content_after_page]',
				)
			);
	// um_theme_loop_before
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_loop_before]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_loop_before',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 7,
					'label'      		=> esc_html__( 'um_theme_loop_before', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_content',
					'settings'   		=> 'customization[um_theme_setting_hook_loop_before]',
				)
			);
	// um_theme_loop_after
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_loop_after]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_loop_after',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 8,
					'label'      		=> esc_html__( 'um_theme_loop_after', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_content',
					'settings'   		=> 'customization[um_theme_setting_hook_loop_after]',
				)
			);
	// Hook Settings - Single Post
	// um_theme_single_post_before
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_single_post_before]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_single_post_before',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 1,
					'label'      		=> esc_html__( 'um_theme_single_post_before', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_single_post',
					'settings'   		=> 'customization[um_theme_setting_hook_single_post_before]',
				)
			);
	// um_theme_single_post_top
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_single_post_top]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_single_post_top',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 2,
					'label'      		=> esc_html__( 'um_theme_single_post_top', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_single_post',
					'settings'   		=> 'customization[um_theme_setting_hook_single_post_top]',
				)
			);
	// um_theme_single_post
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_single_post]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_single_post',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 3,
					'label'      		=> esc_html__( 'um_theme_single_post', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_single_post',
					'settings'   		=> 'customization[um_theme_setting_hook_single_post]',
				)
			);
	// um_theme_single_post_bottom
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_single_post_bottom]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_single_post_bottom',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 4,
					'label'      		=> esc_html__( 'um_theme_single_post_bottom', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_single_post',
					'settings'   		=> 'customization[um_theme_setting_hook_single_post_bottom]',
				)
			);
	// um_theme_single_post_after
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_single_post_after]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_single_post_after',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 5,
					'label'      		=> esc_html__( 'um_theme_single_post_after', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_single_post',
					'settings'   		=> 'customization[um_theme_setting_hook_single_post_after]',
				)
			);
	// Hook Settings - Comments
	// um_theme_before_comments
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_before_comments]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_before_comments',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 1,
					'label'      		=> esc_html__( 'um_theme_before_comments', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_comment',
					'settings'   		=> 'customization[um_theme_setting_hook_before_comments]',
				)
			);
	// um_theme_before_comments_title
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_before_comments_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_before_comments_title',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 2,
					'label'      		=> esc_html__( 'um_theme_before_comments_title', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_comment',
					'settings'   		=> 'customization[um_theme_setting_hook_before_comments_title]',
				)
			);
	// um_theme_after_comments_title
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_after_comments_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_after_comments_title',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 3,
					'label'      		=> esc_html__( 'um_theme_after_comments_title', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_comment',
					'settings'   		=> 'customization[um_theme_setting_hook_after_comments_title]',
				)
			);
	// um_theme_after_comments
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_after_comments]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_after_comments',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 4,
					'label'      		=> esc_html__( 'um_theme_after_comments', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_comment',
					'settings'   		=> 'customization[um_theme_setting_hook_after_comments]',
				)
			);
	// Hook Settings - Footer
	// um_theme_before_footer
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_before_footer]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_before_footer',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 1,
					'label'      		=> esc_html__( 'um_theme_before_footer', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_footer',
					'settings'   		=> 'customization[um_theme_setting_hook_before_footer]',
				)
			);
	// um_theme_footer
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_footer]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_footer',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 2,
					'label'      		=> esc_html__( 'um_theme_footer', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_footer',
					'settings'   		=> 'customization[um_theme_setting_hook_footer]',
				)
			);
	// um_theme_after_footer
	$wp_customize->add_setting( 'customization[um_theme_setting_hook_after_footer]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_setting_hook_after_footer',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 3,
					'label'      		=> esc_html__( 'um_theme_after_footer', 'um-theme' ),
					'section'    		=> 'customizer_section_um_theme_hooks_footer',
					'settings'   		=> 'customization[um_theme_setting_hook_after_footer]',
				)
			);



	/*--------------------------------------------------------------
	## Logo Section
	--------------------------------------------------------------*/

	// Header Logo Type
	$wp_customize->add_setting( 'customization[um_show_header_logo_type]',
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);
		$wp_customize->add_control( 'um_show_header_logo_type',
			array(
				'label'      => esc_html__( 'Header Logo Type', 'um-theme' ),
				'section'    => 'title_tagline',
				'settings'   => 'customization[um_show_header_logo_type]',
				'priority'   => 1,
				'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Text', 'um-theme' ),
					2   => esc_html__( 'Logo', 'um-theme' ),
				),
			)
		);

		// Logo Text Color
		$wp_customize->get_control( 'header_textcolor' )->label 			= esc_html__( 'Logo Color', 'um-theme' );
		$wp_customize->get_control( 'header_textcolor' )->priority 			= 6;
		$wp_customize->get_control( 'header_textcolor' )->section 			= 'title_tagline';
		$wp_customize->get_setting( 'header_textcolor' )->active_callback 	= 'is_active_header_logo_type_text';
		$wp_customize->get_setting( 'header_textcolor' )->default 			= '#444444';
		$wp_customize->get_setting( 'header_textcolor' )->active_callback 	= 'is_active_header_logo_type_text';
		$wp_customize->get_control( 'header_textcolor' )->active_callback 	= 'is_active_header_logo_type_text';


		// Logo Hover Color
		$wp_customize->add_setting( 'customization[um_theme_logo_hover_color]',
			array(
				'default' 			=> '#444444',
				'type' 				=> 'option',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport' 		=> 'postMessage',
			)
		);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,'um_theme_logo_hover_color', array(
						'label'      => esc_html__( 'Logo Hover Color', 'um-theme' ),
						'section'    => 'title_tagline',
						'settings'   => 'customization[um_theme_logo_hover_color]',
						'priority'   => 7,
					)
				)
			);

		// Logo Image
		$wp_customize->get_control( 'custom_logo' )->label 					= esc_html__( 'Logo Image', 'um-theme' );
		$wp_customize->get_control( 'custom_logo' )->priority 				= 200;
		$wp_customize->get_setting( 'custom_logo' )->active_callback  		= 'is_active_header_logo_type_image_logo';
		$wp_customize->get_control( 'custom_logo' )->active_callback  		= 'is_active_header_logo_type_image_logo';
		$wp_customize->get_control( 'custom_logo' )->button_labels  		= array(
				'select'       => __( 'Select Image', 'um-theme' ),
				'change'       => __( 'Change Image', 'um-theme' ),
				'remove'       => __( 'Remove', 'um-theme' ),
				'default'      => __( 'Default', 'um-theme' ),
				'placeholder'  => __( 'No Image selected', 'um-theme' ),
				'frame_title'  => __( 'Select Image', 'um-theme' ),
				'frame_button' => __( 'Choose Image', 'um-theme' ),
		);

		// Site Title
		$wp_customize->get_control( 'blogname' )->label 					= esc_html__( 'Site Title', 'um-theme' );
		$wp_customize->get_setting( 'blogname' )->transport         		= 'postMessage';
		$wp_customize->get_setting( 'blogname' )->active_callback         	= 'is_active_header_logo_type_text';
		$wp_customize->get_control( 'blogname' )->priority 					= 2;
		$wp_customize->get_setting( 'blogname' )->active_callback         	= 'is_active_header_logo_type_text';
		$wp_customize->get_control( 'blogname' )->active_callback         	= 'is_active_header_logo_type_text';

		// Favicon
		$wp_customize->get_control( 'site_icon' )->priority 				= 300;

		$wp_customize->remove_control( 'display_header_text' );
		$wp_customize->remove_control( 'blogdescription' );
		$wp_customize->remove_control( 'header_image' );


	// Retina Logo
	$wp_customize->add_setting( 'um_retina_logo',
		array(
			'sanitize_callback' => 'esc_url_raw',
			'transport' 		=> 'refresh',
			'active_callback' 	=> 'is_active_header_logo_type_image_logo',
		)
	);
			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,'um_retina_logo', array(
				   		'label'      		=> esc_html__( 'Logo Image - Retina', 'um-theme' ),
				   		'section'    		=> 'title_tagline',
				   		'settings'   		=> 'um_retina_logo',
				   		'priority'   		=> 18,
				   		'active_callback' 	=> 'is_active_header_logo_type_image_logo',
			   		)
				)
			);

	// Logo Font
	$wp_customize->add_setting( 'um_theme_typography_logo_font',
		array(
			'default'           => 'Open Sans',
			'sanitize_callback' => 'sanitize_text_field',
			'transport' 		=> 'refresh',
			'active_callback' 	=> 'is_active_header_logo_type_text',
		)
	);
		$wp_customize->add_control(
			new Google_Font_Dropdown_Custom_Control(
				$wp_customize, 'um_theme_typography_logo_font', array(
					'label' 			=> esc_html__( 'Logo Font', 'um-theme' ),
					'section'    		=> 'title_tagline',
					'settings'   		=> 'um_theme_typography_logo_font',
					'priority'   		=> 100,
					'active_callback' 	=> 'is_active_header_logo_type_text',
				)
			)
		);
	// Logo Font Size
	$wp_customize->add_setting( 'customization[um_theme_logo_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '16px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
			'active_callback' 	=> 'is_active_header_logo_type_text',
		)
	);
			$wp_customize->add_control('um_theme_logo_font_size',
				array(
					'type' 				=> 'text',
					'label' 			=> esc_html__( 'Logo Font Size', 'um-theme' ),
					'section' 			=> 'title_tagline',
					'settings' 			=> 'customization[um_theme_logo_font_size]',
					'priority'   		=> 101,
					'active_callback' 	=> 'is_active_header_logo_type_text',
					'input_attrs' 		=> array(
							'placeholder' => __( 'example: 16px', 'um-theme' ),
					),
				)
			);
	// Logo Font Weight
	$wp_customize->add_setting( 'customization[um_theme_logo_weight]',
		array(
			'default' 			=> 'normal',
			'type' 				=> 'option',
			'transport' 		=> 'refresh',
			'sanitize_callback' => 'esc_attr',
			'active_callback' 	=> 'is_active_header_logo_type_text',
		)
	);
		$wp_customize->add_control( 'um_theme_logo_weight',
			array(
				'label'      		=> esc_html__( 'Logo Font Weight', 'um-theme' ),
				'section'    		=> 'title_tagline',
				'settings'   		=> 'customization[um_theme_logo_weight]',
				'sanitize_callback' => 'esc_attr',
				'priority'   		=> 102,
				'active_callback' 	=> 'is_active_header_logo_type_text',
				'type'       		=> 'select',
					'choices'   	=> array(
							'100'   	=> esc_html__( '100', 'um-theme' ),
							'200'  		=> esc_html__( '200', 'um-theme' ),
							'300'		=> esc_html__( '300', 'um-theme' ),
							'400'   	=> esc_html__( '400', 'um-theme' ),
							'500'  		=> esc_html__( '500', 'um-theme' ),
							'600'		=> esc_html__( '600', 'um-theme' ),
							'700'   	=> esc_html__( '700', 'um-theme' ),
							'800'  		=> esc_html__( '800', 'um-theme' ),
							'900'		=> esc_html__( '900', 'um-theme' ),
							'lighter'	=> esc_html__( 'Lighter', 'um-theme' ),
							'normal'   	=> esc_html__( 'Normal', 'um-theme' ),
							'bold'  	=> esc_html__( 'Bold', 'um-theme' ),
							'bolder'	=> esc_html__( 'Bolder', 'um-theme' ),
					),
			)
		);

	/*--------------------------------------------------------------
	## Posts
	--------------------------------------------------------------*/
	// Article Box Color
	$wp_customize->add_setting( 'customization[um_post_single_box_bg]' ,
		array(
			'default' 			=> '#ffffff',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
		)
	);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'um_post_single_box_bg',
			array(
				'label'      => esc_html__( 'Article Box Color', 'um-theme' ),
				'section'    => 'customizer_section_single_article_layout',
				'settings'   => 'customization[um_post_single_box_bg]',
				'priority'   => 2,
			)
		));
	// Article Text Color
	$wp_customize->add_setting( 'customization[um_post_single_box_text_color]',
		array(
			'default' 			=> '#333333',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,'um_post_single_box_text_color', array(
					'label'      => esc_html__( 'Article Text Color', 'um-theme' ),
					'section'    => 'customizer_section_single_article_layout',
					'settings'   => 'customization[um_post_single_box_text_color]',
					'priority'   => 3,
				)
			)
		);
	// Post Tag Background Color
	$wp_customize->add_setting( 'customization[um_post_tag_box_bg]' ,
		array(
			'default' 			=> '#f1f3f4',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'um_post_tag_box_bg', array(
					'label'      => esc_html__( 'Post Tag Background Color', 'um-theme' ),
					'section'    => 'customizer_section_single_article_layout',
					'settings'   => 'customization[um_post_tag_box_bg]',
					'priority'   => 4,
				)
			)
		);
	// Post Tag Color
	$wp_customize->add_setting( 'customization[um_post_tag_text_color]',
		array(
			'default' 			=> '#62646c',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,'um_post_tag_text_color', array(
					'label'      => esc_html__( 'Post Tag Color', 'um-theme' ),
					'section'    => 'customizer_section_single_article_layout',
					'settings'   => 'customization[um_post_tag_text_color]',
					'priority'   => 5,
				)
			)
		);
	$wp_customize->add_setting( 'um_theme_single_article_line_break_first',
		array(
			'default'    		=> true,
			'sanitize_callback' => 'wp_kses',
		)
	);
			$wp_customize->add_control(
				new UM_Theme_Helper_Line_Break(
					$wp_customize, 'um_theme_single_article_line_break_first', array(
						'section' 	=> 'customizer_section_single_article_layout',
						'settings'  => 'um_theme_single_article_line_break_first',
						'priority'  => 19,
					)
				)
			);

	// Show Hide Page Elements
	$wp_customize->add_setting( 'customization[customizer_show_hide_page_sections]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
		)
	);
			$wp_customize->add_control(
				new UM_Theme_UI_Helper_Title(
					$wp_customize, 'customizer_show_hide_page_sections', array(
						'type' 			=> 'info',
						'label' 		=> esc_html__( 'Page Elements','um-theme' ),
						'section' 		=> 'customizer_section_single_article_layout',
						'settings'    	=> 'customization[customizer_show_hide_page_sections]',
						'priority'   	=> 30,
					)
				)
			);

	// Show Page Breadcrumb
	$wp_customize->add_setting( 'customization[um_theme_show_page_breadcumb]' ,
		array(
			'default' 				=> 2,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);
		$wp_customize->add_control( 'um_theme_show_page_breadcumb',
			array(
				'label'      => esc_html__( 'Show Breadcrumb', 'um-theme' ),
				'section'    => 'customizer_section_single_article_layout',
				'settings'   => 'customization[um_theme_show_page_breadcumb]',
				'priority'   => 31,
				'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// Show Hide Post Sections
	$wp_customize->add_setting( 'customization[customizer_show_hide_post_sections]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
		)
	);
			$wp_customize->add_control(
				new UM_Theme_UI_Helper_Title(
					$wp_customize, 'customizer_show_hide_post_sections', array(
						'type' 			=> 'info',
						'label' 		=> esc_html__( 'Single Post Elements','um-theme' ),
						'section' 		=> 'customizer_section_single_article_layout',
						'settings'    	=> 'customization[customizer_show_hide_post_sections]',
						'priority'   	=> 40,
					)
				)
			);
	// Featured Image Position
	$wp_customize->add_setting( 'customization[um_theme_post_featured_image_pos]' ,
		array(
			'default' 				=> 2,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);
		$wp_customize->add_control( 'um_theme_post_featured_image_pos',
			array(
				'label'      => esc_html__( 'Featured Image', 'um-theme' ),
				'section'    => 'customizer_section_single_article_layout',
				'settings'   => 'customization[um_theme_post_featured_image_pos]',
				'priority'   => 41,
				'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Hidden', 'um-theme' ),
					2   => esc_html__( 'Above Title', 'um-theme' ),
					3   => esc_html__( 'Above Post', 'um-theme' ),
					4   => esc_html__( 'Beside Post', 'um-theme' ),
				),
			)
		);

	// Show Article Summary
	$wp_customize->add_setting( 'customization[um_theme_show_post_article_summary]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);
		$wp_customize->add_control( 'um_theme_show_post_article_summary',
			array(
				'label'      => esc_html__( 'Show Article Summary', 'um-theme' ),
				'section'    => 'customizer_section_single_article_layout',
				'settings'   => 'customization[um_theme_show_post_article_summary]',
				'priority'   => 42,
				'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);
	// Show Post Navigation
	$wp_customize->add_setting( 'customization[um_theme_show_post_meta_navigation]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);
		$wp_customize->add_control( 'um_theme_show_post_meta_navigation',
			array(
				'label'      => esc_html__( 'Post Navigation', 'um-theme' ),
				'section'    => 'customizer_section_single_article_layout',
				'settings'   => 'customization[um_theme_show_post_meta_navigation]',
				'priority'   => 42,
				'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);
	// Show Post Tags
	$wp_customize->add_setting( 'customization[um_theme_show_post_tags]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);
		$wp_customize->add_control( 'um_theme_show_post_tags',
			array(
				'label'      => esc_html__( 'Post Tags', 'um-theme' ),
				'section'    => 'customizer_section_single_article_layout',
				'settings'   => 'customization[um_theme_show_post_tags]',
				'priority'   => 43,
				'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);
	// Show Post Category
	$wp_customize->add_setting( 'customization[um_theme_show_post_category]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);
		$wp_customize->add_control( 'um_theme_show_post_category',
			array(
				'label'      => esc_html__( 'Post Category', 'um-theme' ),
				'section'    => 'customizer_section_single_article_layout',
				'settings'   => 'customization[um_theme_show_post_category]',
				'priority'   => 44,
				'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);
	// Show Post Author Box
	$wp_customize->add_setting( 'customization[um_theme_show_post_author_box]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);
		$wp_customize->add_control( 'um_theme_show_post_author_box',
			array(
				'label'      => esc_html__( 'Author Box', 'um-theme' ),
				'section'    => 'customizer_section_single_article_layout',
				'settings'   => 'customization[um_theme_show_post_author_box]',
				'priority'   => 45,
				'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// Show Comments
	$wp_customize->add_setting( 'customization[um_theme_show_site_comments]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);
		$wp_customize->add_control( 'um_theme_show_site_comments',
			array(
				'label'      => esc_html__( 'Comments', 'um-theme' ),
				'section'    => 'customizer_section_single_article_layout',
				'settings'   => 'customization[um_theme_show_site_comments]',
				'priority'   => 46,
				'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	/*--------------------------------------------------------------
	## Sitewide or Global Color
	--------------------------------------------------------------*/
	$wp_customize->get_setting( 'background_color' )->default 	= '#f6f9fc';
	$wp_customize->get_control( 'background_color' )->section 	= 'customizer_section_global_color';
	$wp_customize->get_control( 'background_color' )->priority 	= 1;
	$wp_customize->get_control( 'background_color' )->label 	= esc_html__( 'Website Background Color', 'um-theme' );
	$wp_customize->remove_control( 'background_image' );
	// Website Meta Color
	$wp_customize->add_setting( 'customization[um_theme_website_meta_color]',
		array(
			'default' 			=> '#a5aaa8',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'um_theme_website_meta_color', array(
					'label'      		=> esc_html__( 'Meta Information Colors', 'um-theme' ),
					'section'    		=> 'customizer_section_global_color',
					'description' 		=> esc_html__( 'Change the color of Article & Comments date, author name, reply link etc.', 'um-theme' ),
					'settings'   		=> 'customization[um_theme_website_meta_color]',
					'priority'   		=> 2,
				)
			)
		);

	// Link Text Color -- Settings
	$wp_customize->add_setting( 'customization[link_text_color]' ,
		array(
			'default' 				=> '#444444',
			'type' 					=> 'option',
			'sanitize_callback' 	=> 'sanitize_hex_color',
			'transport' 			=> 'postMessage',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,'link_text_color', array(
					'label'      => esc_html__( 'Link Text', 'um-theme' ),
					'section'    => 'customizer_section_global_color',
					'settings'   => 'customization[link_text_color]',
					'priority'   => 5,
				)
			)
		);
	// Link Text Hover Color -- Settings
	$wp_customize->add_setting( 'customization[link_hover_color]' ,
		array(
			'default' 				=> '#333333',
			'type' 					=> 'option',
			'sanitize_callback' 	=> 'sanitize_hex_color',
			'transport' 			=> 'postMessage',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'link_hover_color', array(
					'label'      => esc_html__( 'Link Text Hover', 'um-theme' ),
					'section'    => 'customizer_section_global_color',
					'settings'   => 'customization[link_hover_color]',
					'priority'   => 6,
				)
			)
		);

	// Header Layouts
	$wp_customize->add_setting( 'customization[um_theme_header_layout]',
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);
		$wp_customize->add_control( 'um_theme_header_layout',
			array(
				'label'      => esc_html__( 'Header Layout', 'um-theme' ),
				'section'    => 'customizer_section_header_color',
				'settings'   => 'customization[um_theme_header_layout]',
				'priority'   => 1,
				'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Default', 'um-theme' ),
					2   => esc_html__( 'Wide Search', 'um-theme' ),
					3   => esc_html__( 'Centered Logo', 'um-theme' ),
					4   => esc_html__( 'Wide Menu', 'um-theme' ),
				),
			)
		);

	// Make Header Sticky
	$wp_customize->add_setting( 'customization[um_theme_make_header_sticky]',
		array(
			'default' 				=> 2,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);
		$wp_customize->add_control( 'um_theme_make_header_sticky',
			array(
				'label'      => esc_html__( 'Make Header Sticky', 'um-theme' ),
				'section'    => 'customizer_section_header_color',
				'settings'   => 'customization[um_theme_make_header_sticky]',
				'priority'   => 2,
				'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);
	$wp_customize->add_setting( 'um_theme_header_style_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);
			$wp_customize->add_control(
				new UM_Theme_Helper_Line_Break(
					$wp_customize, 'um_theme_header_style_line_break_first', array(
						'section' 	=> 'customizer_section_header_color',
						'settings'  => 'um_theme_header_style_line_break_first',
						'priority'  => 9,
					)
				)
			);

	// Site Header Padding
	$wp_customize->add_setting( 'customization[um_header_padding_setting]',
		array(
			'type' 				=> 'option',
			'default' 			=> '10px',
			'transport' 		=> 'refresh',
			'sanitize_callback' => 'esc_attr',
	) );
			$wp_customize->add_control( 'um_header_padding_setting',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Site Header Padding','um-theme' ),
					'section' 		=> 'customizer_section_header_color',
					'settings' 		=> 'customization[um_header_padding_setting]',
					'priority'   	=> 10,
					'input_attrs' 	=> array(
						'placeholder' => __( 'example: 10px', 'um-theme' ),
					),
				)
			);
	// Header Background Color -- Settings
	$wp_customize->add_setting( 'customization[header_background_color]' ,
		array(
		'default' 			=> '#ffffff',
		'type' 				=> 'option',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'header_background_color', array(
					'label'      => esc_html__( 'Header Background Color', 'um-theme' ),
					'section'    => 'customizer_section_header_color',
					'settings'   => 'customization[header_background_color]',
					'priority'   => 11,
				)
			)
		);

	// Widget Background Color -- Settings
	$wp_customize->add_setting( 'customization[widgets_background_color]',
		array(
			'default' 			=> '#ffffff',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,'widgets_background_color', array(
					'label'      => esc_html__( 'Widget Area Background', 'um-theme' ),
					'section'    => 'customizer_section_widget_area',
					'settings'   => 'customization[widgets_background_color]',
					'priority'   => 4,
				)
			)
		);

	/*--------------------------------------------------------------
	## Button Color
	--------------------------------------------------------------*/
	// Button Text
	$wp_customize->add_setting( 'customization[customizer_ui_general_button_text]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);
			$wp_customize->add_control(
				new UM_Theme_UI_Helper_Title(
					$wp_customize, 'customizer_ui_general_button_text', array(
						'type' 			=> 'info',
						'label' 		=> esc_html__( 'Button Text','um-theme' ),
						'section' 		=> 'customizer_section_button_style',
						'settings'    	=> 'customization[customizer_ui_general_button_text]',
						'priority'   	=> 1,
					)
				)
			);

	// Button Font
	$wp_customize->add_setting( 'um_theme_typography_button_font',
		array(
			'default'           => 'Open Sans',
			'sanitize_callback' => 'sanitize_text_field',
			'transport' 		=> 'refresh',
		)
	);
		$wp_customize->add_control(
			new Google_Font_Dropdown_Custom_Control(
				$wp_customize, 'um_theme_typography_button_font', array(
					'label' 	=> esc_html__( 'Button Font', 'um-theme' ),
					'section'   => 'customizer_section_button_style',
					'settings'  => 'um_theme_typography_button_font',
					'priority'  => 3,
				)
			)
		);

	// Button Font Size
	$wp_customize->add_setting( 'customization[um_theme_button_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '16px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_button_font_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Button Font Size','um-theme' ),
					'section' 		=> 'customizer_section_button_style',
					'settings' 		=> 'customization[um_theme_button_font_size]',
					'priority'   	=> 4,
					'input_attrs' 	=> array(
						'placeholder' => __( 'example: 16px', 'um-theme' ),
					),
				)
			);


	// Button Font Weight
	$wp_customize->add_setting( 'customization[um_theme_button_weight]' ,
		array(
			'default' 			=> 'normal',
			'type' 				=> 'option',
			'transport' 		=> 'refresh',
			'sanitize_callback' => 'esc_attr',
		)
	);
		$wp_customize->add_control( 'um_theme_button_weight',
			array(
				'label'      		=> esc_html__( 'Button Font Weight', 'um-theme' ),
				'section'    		=> 'customizer_section_button_style',
				'settings'   		=> 'customization[um_theme_button_weight]',
				'sanitize_callback' => 'esc_attr',
				'priority'   		=> 5,
				'type'       		=> 'select',
					'choices'   	=> array(
							'100'   	=> esc_html__( '100', 'um-theme' ),
							'200'  		=> esc_html__( '200', 'um-theme' ),
							'300'		=> esc_html__( '300', 'um-theme' ),
							'400'   	=> esc_html__( '400', 'um-theme' ),
							'500'  		=> esc_html__( '500', 'um-theme' ),
							'600'		=> esc_html__( '600', 'um-theme' ),
							'700'   	=> esc_html__( '700', 'um-theme' ),
							'800'  		=> esc_html__( '800', 'um-theme' ),
							'900'		=> esc_html__( '900', 'um-theme' ),
							'lighter'	=> esc_html__( 'Lighter', 'um-theme' ),
							'normal'   	=> esc_html__( 'Normal', 'um-theme' ),
							'bold'  	=> esc_html__( 'Bold', 'um-theme' ),
							'bolder'	=> esc_html__( 'Bolder', 'um-theme' ),
					),
			)
		);

	// Button Text Transform
	$wp_customize->add_setting( 'customization[um_theme_button_transform]' ,
		array(
			'default' 			=> 'none',
			'type' 				=> 'option',
			'transport' 		=> 'postMessage',
			'sanitize_callback' => 'sanitize_key',
		)
	);
		$wp_customize->add_control( 'um_theme_button_transform',
			array(
				'label'      		=> esc_html__( 'Button Text Transform', 'um-theme' ),
				'section'    		=> 'customizer_section_button_style',
				'settings'   		=> 'customization[um_theme_button_transform]',
				'sanitize_callback' => 'esc_attr',
				'priority'   		=> 6,
				'type'       		=> 'select',
					'choices'   	=> array(
							'none'   		=> esc_html__( 'Normal', 'um-theme' ),
							'uppercase' 	=> esc_html__( 'UPPERCASE', 'um-theme' ),
							'lowercase'		=> esc_html__( 'lowercase', 'um-theme' ),
							'capitalize'	=> esc_html__( 'Capitalize', 'um-theme' ),
					),
			)
		);
	$wp_customize->add_setting( 'um_theme_general_button_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);
			$wp_customize->add_control(
				new UM_Theme_Helper_Line_Break(
					$wp_customize, 'um_theme_general_button_line_break_first', array(
						'section' 		=> 'customizer_section_button_style',
						'settings'    	=> 'um_theme_general_button_line_break_first',
						'priority'   	=> 9,
					)
				)
			);

	// Button Color
	$wp_customize->add_setting( 'customization[customizer_ui_general_button_color]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);
			$wp_customize->add_control(
				new UM_Theme_UI_Helper_Title(
					$wp_customize,'customizer_ui_general_button_color', array(
						'type' 			=> 'info',
						'label' 		=> esc_html__( 'Button Color','um-theme' ),
						'section' 		=> 'customizer_section_button_style',
						'settings'    	=> 'customization[customizer_ui_general_button_color]',
						'priority'   	=> 10,
					)
				)
			);

	// Button Background Color -- Settings
	$wp_customize->add_setting( 'customization[button_background_color]' ,
		array(
			'default' 				=> '#444444',
			'type' 					=> 'option',
			'sanitize_callback' 	=> 'sanitize_hex_color',
			'transport' 			=> 'postMessage',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,'button_background_color', array(
					'label'      => esc_html__( 'Button Color', 'um-theme' ),
					'section'    => 'customizer_section_button_style',
					'settings'   => 'customization[button_background_color]',
					'priority'   => 11,
				)
			)
		);

	// Button Text Color -- Settings
	$wp_customize->add_setting( 'customization[button_text_color]' ,
		array(
			'default' 			=> '#ffffff',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'button_text_color', array(
					'label'      => esc_html__( 'Button Text', 'um-theme' ),
					'section'    => 'customizer_section_button_style',
					'settings'   => 'customization[button_text_color]',
					'priority'   => 12,
				)
			)
		);

	// Button Hover Color -- Settings
	$wp_customize->add_setting( 'customization[button_hover_color]' ,
		array(
			'default' 				=> '#333333',
			'type' 					=> 'option',
			'sanitize_callback' 	=> 'sanitize_hex_color',
			'transport' 			=> 'postMessage',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'button_hover_color', array(
					'label'      => esc_html__( 'Button Hover', 'um-theme' ),
					'section'    => 'customizer_section_button_style',
					'settings'   => 'customization[button_hover_color]',
					'priority'   => 13,
				)
			)
		);

	// Button Text Hover Color -- Settings
	$wp_customize->add_setting( 'customization[button_hover_text_color]' ,
		array(
			'default' 				=> '#ffffff',
			'type' 					=> 'option',
			'sanitize_callback' 	=> 'sanitize_hex_color',
			'transport' 			=> 'postMessage',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'button_hover_text_color', array(
					'label'      => esc_html__( 'Button Hover Text', 'um-theme' ),
					'section'    => 'customizer_section_button_style',
					'settings'   => 'customization[button_hover_text_color]',
					'priority'   => 14,
				)
			)
		);

	$wp_customize->add_setting( 'um_theme_general_button_line_break_second',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);
			$wp_customize->add_control(
				new UM_Theme_Helper_Line_Break(
					$wp_customize, 'um_theme_general_button_line_break_second', array(
						'section' 		=> 'customizer_section_button_style',
						'settings'    	=> 'um_theme_general_button_line_break_second',
						'priority'   	=> 19,
					)
				)
			);

	// Button Border
	$wp_customize->add_setting( 'customization[customizer_ui_general_button_border]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);
			$wp_customize->add_control(
				new UM_Theme_UI_Helper_Title(
					$wp_customize, 'customizer_ui_general_button_border', array(
						'type' 			=> 'info',
						'label' 		=> esc_html__( 'Button Border','um-theme' ),
						'section' 		=> 'customizer_section_button_style',
						'settings'    	=> 'customization[customizer_ui_general_button_border]',
						'priority'   	=> 29,
					)
				)
			);
	// Button Border Radius
	$wp_customize->add_setting( 'customization[um_theme_button_border_radius]',
		array(
			'type' 				=> 'option',
			'default' 			=> '2px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control('um_theme_button_border_radius',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Button Border Radius','um-theme' ),
					'section' 		=> 'customizer_section_button_style',
					'settings' 		=> 'customization[um_theme_button_border_radius]',
					'priority'   	=> 30,
					'input_attrs' 	=> array(
								'placeholder' => __( 'example: 16px', 'um-theme' ),
					),
				)
			);

	// Enable Button Border
	$wp_customize->add_setting( 'customization[um_theme_button_border_enable]' ,
		array(
			'default' 				=> 2,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);
		$wp_customize->add_control( 'um_theme_button_border_enable',
			array(
				'label'      => esc_html__( 'Button Border', 'um-theme' ),
				'section'    => 'customizer_section_button_style',
				'settings'   => 'customization[um_theme_button_border_enable]',
				'priority'   => 31,
				'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// Button Border Color
	$wp_customize->add_setting( 'customization[button_border_color]' ,
		array(
			'default' 				=> '#333333',
			'type' 					=> 'option',
			'sanitize_callback' 	=> 'sanitize_hex_color',
			'transport' 			=> 'postMessage',
			'active_callback' 		=> 'is_active_button_border',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'button_border_color', array(
					'label'      		=> esc_html__( 'Button Border Color', 'um-theme' ),
					'section'    		=> 'customizer_section_button_style',
					'settings'   		=> 'customization[button_border_color]',
					'priority'   		=> 32,
					'active_callback' 	=> 'is_active_button_border',
				)
			)
		);

	// Button Border Width
	$wp_customize->add_setting( 'customization[um_theme_button_border_width]',
		array(
			'type' 				=> 'option',
			'default' 			=> '1px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
			'active_callback' 	=> 'is_active_button_border',
		)
	);
			$wp_customize->add_control('um_theme_button_border_width',
				array(
					'type' 				=> 'text',
					'label' 			=> esc_html__( 'Button Border Width','um-theme' ),
					'section' 			=> 'customizer_section_button_style',
					'settings' 			=> 'customization[um_theme_button_border_width]',
					'priority'   		=> 33,
					'active_callback' 	=> 'is_active_button_border',
					'input_attrs' 		=> array(
							'placeholder' => __( 'example: 1px', 'um-theme' ),
					),
				)
			);

	/*--------------------------------------------------------------
	## General Layout
	--------------------------------------------------------------*/
	// Site Width
	$wp_customize->add_setting( 'customization[um_theme_canvas_width]',
		array(
			'type' 				=> 'option',
			'default'         	=> '1200px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
	) );
			$wp_customize->add_control( 'um_theme_canvas_width',
				array(
					'type' 			=> 'text',
					'label'      	=> esc_html__( 'Site Width', 'um-theme' ),
					'description' 	=> esc_html__( 'Write your width in px or %. Example: 1200px. Your content will be confined within this area.', 'um-theme' ),
					'section'    	=> 'customizer_section_width_layout',
					'settings'   	=> 'customization[um_theme_canvas_width]',
					'priority'   	=> 3,
					'input_attrs' => array(
						'placeholder' => __( '1200px', 'um-theme' ),
					),
				)
			);

	// Header Width
	$wp_customize->add_setting( 'customization[um_theme_header_width]',
		array(
			'type' 				=> 'option',
			'default'         	=> '100%',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_header_width',
				array(
					'type' 			=> 'text',
					'label'      	=> esc_html__( 'Header Width', 'um-theme' ),
					'description' 	=> esc_html__( 'Write your width in %. Example: 100%. Your content will be confined within this area.', 'um-theme' ),
					'section'    	=> 'customizer_section_width_layout',
					'settings'   	=> 'customization[um_theme_header_width]',
					'priority'   	=> 4,
					'input_attrs' => array(
						'placeholder' => __( '100%', 'um-theme' ),
					),
				)
			);

	/*--------------------------------------------------------------
	## Header Top Bar
	--------------------------------------------------------------*/
	// Top Bar Layout
	$wp_customize->add_setting( 'customization[um_show_topbar]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);
		$wp_customize->add_control( 'um_show_topbar',
			array(
				'label'      => esc_html__( 'Top Bar Layout', 'um-theme' ),
				'section'    => 'customizer_section_topbar',
				'settings'   => 'customization[um_show_topbar]',
				'priority'   => 1,
				'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'None', 'um-theme' ),
					2   => esc_html__( '1 Column', 'um-theme' ),
					3   => esc_html__( '2 Column', 'um-theme' ),
				),
			)
		);

	// Top Bar Layout Column First Layout
	$wp_customize->add_setting( 'customization[um_topbar_colum_first_layout]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'is_active_top_bar',
		)
	);
		$wp_customize->add_control( 'um_topbar_colum_first_layout',
			array(
				'label'      		=> esc_html__( 'Column 1 Layout', 'um-theme' ),
				'section'    		=> 'customizer_section_topbar',
				'settings'   		=> 'customization[um_topbar_colum_first_layout]',
				'priority'   		=> 10,
				'active_callback' 	=> 'is_active_top_bar',
				'type'       		=> 'select',
				'choices'    		=> array(
						1   => esc_html__( 'Text', 'um-theme' ),
						2   => esc_html__( 'Text & Social Icons', 'um-theme' ),
						3   => esc_html__( 'Menu', 'um-theme' ),
						4   => esc_html__( 'Menu & Social Icons', 'um-theme' ),
						5   => esc_html__( 'Social Icons', 'um-theme' ),
				),
			)
		);

	// Column 1 Text
	$wp_customize->add_setting( 'customization[um_topbar_colum_first_text]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
			'active_callback' 	=> 'is_active_column_one_text',
		)
	);
			$wp_customize->add_control( 'um_topbar_colum_first_text',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 11,
					'label'      		=> esc_html__( 'Column 1 Text', 'um-theme' ),
					'section'    		=> 'customizer_section_topbar',
					'settings'   		=> 'customization[um_topbar_colum_first_text]',
					'active_callback' 	=> 'is_active_column_one_text',
				)
			);

	// Top Bar Layout Column First Layout
	$wp_customize->add_setting( 'customization[um_topbar_colum_second_layout]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'is_active_top_bar_two_column',
		)
	);
		$wp_customize->add_control( 'um_topbar_colum_second_layout',
			array(
				'label'      		=> esc_html__( 'Column 2 Layout', 'um-theme' ),
				'section'    		=> 'customizer_section_topbar',
				'settings'   		=> 'customization[um_topbar_colum_second_layout]',
				'priority'   		=> 20,
				'type'       		=> 'select',
				'active_callback' 	=> 'is_active_top_bar_two_column',
				'choices'    		=> array(
						1   => esc_html__( 'Text', 'um-theme' ),
						2   => esc_html__( 'Text & Social Icons', 'um-theme' ),
						3   => esc_html__( 'Menu', 'um-theme' ),
						4   => esc_html__( 'Menu & Social Icons', 'um-theme' ),
						5   => esc_html__( 'Social Icons', 'um-theme' ),
				),
			)
		);

	// Column 2 Text
	$wp_customize->add_setting( 'customization[um_topbar_colum_second_text]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
			'active_callback' 	=> 'is_active_topbar_column_two_text',
		)
	);
			$wp_customize->add_control( 'um_topbar_colum_second_text',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 21,
					'label'      		=> esc_html__( 'Column 2 Text', 'um-theme' ),
					'section'    		=> 'customizer_section_topbar',
					'settings'   		=> 'customization[um_topbar_colum_second_text]',
					'active_callback' 	=> 'is_active_topbar_column_two_text',
				)
			);

	/*--------------------------------------------------------------
	## Top Bar Style
	--------------------------------------------------------------*/
	// Top Bar Background Color
	$wp_customize->add_setting( 'customization[header_topbar_background_color]' ,
		array(
			'default' 			=> '#444444',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'header_topbar_background_color', array(
					'label'      => esc_html__( 'Top Bar Background', 'um-theme' ),
					'section'    => 'customizer_section_topbar_style',
					'settings'   => 'customization[header_topbar_background_color]',
					'priority'   => 1,
				)
			)
		);

	// Top Bar Text Color
	$wp_customize->add_setting( 'customization[header_topbar_text_color]' ,
		array(
			'default' 			=> '#ffffff',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'header_topbar_text_color', array(
					'label'      => esc_html__( 'Top Bar Text', 'um-theme' ),
					'section'    => 'customizer_section_topbar_style',
					'settings'   => 'customization[header_topbar_text_color]',
					'priority'   => 2,
				)
			)
		);

	$wp_customize->add_setting( 'um_theme_header_topbar_style_line_break_first',
		array(
			'default'    		=> true,
			'sanitize_callback' => 'wp_kses',
		)
	);
			$wp_customize->add_control(
				new UM_Theme_Helper_Line_Break(
					$wp_customize, 'um_theme_header_topbar_style_line_break_first', array(
						'section' 	=> 'customizer_section_topbar_style',
						'settings'  => 'um_theme_header_topbar_style_line_break_first',
						'priority'  => 9,
					)
				)
			);

	// Top Bar Menu Color
	$wp_customize->add_setting( 'customization[header_topbar_menu_color]' ,
		array(
			'default' 			=> '#ffffff',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'header_topbar_menu_color', array(
					'label'      => esc_html__( 'Top Bar Link', 'um-theme' ),
					'section'    => 'customizer_section_topbar_style',
					'settings'   => 'customization[header_topbar_menu_color]',
					'priority'   => 10,
				)
			)
		);

	// Top Bar Link Hover Color
	$wp_customize->add_setting( 'customization[header_topbar_link_hover_color]' ,
		array(
		'default' 			=> '#eeeeee',
		'type' 				=> 'option',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,'header_topbar_link_hover_color', array(
					'label'      => esc_html__( 'Top Bar Link Hover', 'um-theme' ),
					'section'    => 'customizer_section_topbar_style',
					'settings'   => 'customization[header_topbar_link_hover_color]',
					'priority'   => 11,
				)
			)
		);

	$wp_customize->add_setting( 'um_theme_header_topbar_style_line_break_second',
		array(
			'default'    		=> true,
			'sanitize_callback' => 'wp_kses',
		)
	);
			$wp_customize->add_control(
				new UM_Theme_Helper_Line_Break(
					$wp_customize, 'um_theme_header_topbar_style_line_break_second', array(
						'section' 	=> 'customizer_section_topbar_style',
						'settings'  => 'um_theme_header_topbar_style_line_break_second',
						'priority'  => 19,
					)
				)
			);

	// Topbar Font Size
	$wp_customize->add_setting( 'customization[header_topbar_menu_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '13px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'header_topbar_menu_font_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Topbar Font Size','um-theme' ),
					'section' 		=> 'customizer_section_topbar_style',
					'settings' 		=> 'customization[header_topbar_menu_font_size]',
					'priority'   	=> 20,
					'input_attrs' 	=> array(
							'placeholder' => __( 'example: 13px', 'um-theme' ),
					),
				)
			);

	// Social Icon Font Size
	$wp_customize->add_setting( 'customization[header_topbar_icon_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '22px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'header_topbar_icon_font_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Social Icon Size','um-theme' ),
					'section' 		=> 'customizer_section_topbar_style',
					'settings' 		=> 'customization[header_topbar_icon_font_size]',
					'priority'   	=> 21,
					'input_attrs' 	=> array(
							'placeholder' => __( 'example: 13px', 'um-theme' ),
					),
				)
			);

	/*--------------------------------------------------------------
	## Header Bottom Bar
	--------------------------------------------------------------*/
	// Show Bottom Bar
	$wp_customize->add_setting( 'customization[um_show_bottombar]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);
		$wp_customize->add_control( 'um_show_bottombar',
			array(
				'label'      => esc_html__( 'Bottom Bar', 'um-theme' ),
				'section'    => 'customizer_section_bottombar_layout',
				'settings'   => 'customization[um_show_bottombar]',
				'priority'   => 1,
				'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
					3   => esc_html__( 'Visible on Click', 'um-theme' ),
				),
			)
		);

	// Bottom Bar Layout
	$wp_customize->add_setting( 'customization[um_show_bottombar_layout]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'is_active_bottom_bar',
		)
	);
		$wp_customize->add_control( 'um_show_bottombar_layout',
			array(
				'label'      		=> esc_html__( 'Bottom Bar Layout', 'um-theme' ),
				'section'    		=> 'customizer_section_bottombar_layout',
				'settings'   		=> 'customization[um_show_bottombar_layout]',
				'priority'   		=> 1,
				'type'       		=> 'select',
				'active_callback' 	=> 'is_active_bottom_bar',
				'choices'    		=> array(
						1   => esc_html__( '1 Column', 'um-theme' ),
						2   => esc_html__( '2 Column', 'um-theme' ),
				),
			)
		);

	// Bottom Bar Layout Column First Layout
	$wp_customize->add_setting( 'customization[um_bottombar_colum_first_layout]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'is_active_bottom_bar_layout_one',
		)
	);
		$wp_customize->add_control( 'um_bottombar_colum_first_layout',
			array(
				'label'      => esc_html__( 'Column 1 Layout', 'um-theme' ),
				'section'    => 'customizer_section_bottombar_layout',
				'settings'   => 'customization[um_bottombar_colum_first_layout]',
				'priority'   => 10,
				'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Text', 'um-theme' ),
					2   => esc_html__( 'Menu', 'um-theme' ),
				),
			)
		);

	// Column 1 Text
	$wp_customize->add_setting( 'customization[um_bottompbar_colum_first_text]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
			'active_callback' 	=> 'is_active_bottom_column_one_text',
		)
	);
			$wp_customize->add_control( 'um_bottompbar_colum_first_text',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 11,
					'label'      		=> esc_html__( 'Column 1 Text', 'um-theme' ),
					'section'    		=> 'customizer_section_bottombar_layout',
					'settings'   		=> 'customization[um_bottompbar_colum_first_text]',
					'active_callback' 	=> 'is_active_bottom_column_one_text',
				)
			);

	// Bottom Bar Layout Column Second Layout
	$wp_customize->add_setting( 'customization[um_bottombar_colum_second_layout]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'is_active_bottom_select_layout_two',
		)
	);
		$wp_customize->add_control( 'um_bottombar_colum_second_layout',
			array(
				'label'      		=> esc_html__( 'Column 2 Layout', 'um-theme' ),
				'section'    		=> 'customizer_section_bottombar_layout',
				'settings'   		=> 'customization[um_bottombar_colum_second_layout]',
				'priority'   		=> 20,
				'type'       		=> 'select',
				'active_callback' 	=> 'is_active_bottom_select_layout_two',
				'choices'    		=> array(
						1   => esc_html__( 'Text', 'um-theme' ),
						2   => esc_html__( 'Menu', 'um-theme' ),
				),
			)
		);

	// Column 1 Text
	$wp_customize->add_setting( 'customization[um_bottompbar_colum_second_text]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
			'active_callback' 	=> 'is_active_bottom_column_two_text',
		)
	);
			$wp_customize->add_control( 'um_bottompbar_colum_second_text',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 21,
					'label'      		=> esc_html__( 'Column 2 Text', 'um-theme' ),
					'section'    		=> 'customizer_section_bottombar_layout',
					'settings'   		=> 'customization[um_bottompbar_colum_second_text]',
					'active_callback' 	=> 'is_active_bottom_column_two_text',
				)
			);

	// Bottom bar Font Size
	$wp_customize->add_setting( 'customization[header_bottombar_menu_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '13px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
			'active_callback' 	=> 'is_active_bottom_bar',
		)
	);
			$wp_customize->add_control( 'header_bottombar_menu_font_size',
				array(
					'type' 				=> 'text',
					'label' 			=> esc_html__( 'Bottom bar Font Size', 'um-theme' ),
					'section' 			=> 'customizer_section_bottombar',
					'settings' 			=> 'customization[header_bottombar_menu_font_size]',
					'priority'   		=> 1,
					'active_callback' 	=> 'is_active_bottom_bar',
					'input_attrs' 		=> array(
							'placeholder' => __( 'example: 13px', 'um-theme' ),
					),
				)
			);

	// Bottom Bar Background Color
	$wp_customize->add_setting( 'customization[header_bottombar_background_color]' ,
		array(
		'default' 			=> '#444444',
		'type' 				=> 'option',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage',
		'active_callback' 	=> 'is_active_bottom_bar',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,'header_bottombar_background_color', array(
					'label'      		=> esc_html__( 'Bottom Bar Background', 'um-theme' ),
					'section'    		=> 'customizer_section_bottombar',
					'settings'   		=> 'customization[header_bottombar_background_color]',
					'priority'   		=> 20,
					'active_callback' 	=> 'is_active_bottom_bar',
				)
			)
		);

	// Bottom Bar Menu Color
	$wp_customize->add_setting( 'customization[header_bottombar_menu_color]' ,
		array(
		'default' 				=> '#ffffff',
		'type' 					=> 'option',
		'sanitize_callback' 	=> 'sanitize_hex_color',
		'transport' 			=> 'postMessage',
		'active_callback' 		=> 'is_active_bottom_bar',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,'header_bottombar_menu_color', array(
					'label'      		=> esc_html__( 'Bottom Bar Menu', 'um-theme' ),
					'section'    		=> 'customizer_section_bottombar',
					'settings'   		=> 'customization[header_bottombar_menu_color]',
					'priority'   		=> 21,
					'active_callback' 	=> 'is_active_bottom_bar',
				)
			)
		);

	// Bottom Bar Text Color
	$wp_customize->add_setting( 'customization[header_bottombar_text_color]' ,
		array(
		'default' 				=> '#333333',
		'type' 					=> 'option',
		'sanitize_callback' 	=> 'sanitize_hex_color',
		'transport' 			=> 'postMessage',
		'active_callback' 		=> 'is_active_bottom_bar',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,'header_bottombar_text_color', array(
					'label'      		=> esc_html__( 'Bottom Bar Text', 'um-theme' ),
					'section'    		=> 'customizer_section_bottombar',
					'settings'   		=> 'customization[header_bottombar_text_color]',
					'priority'   		=> 21,
					'active_callback' 	=> 'is_active_bottom_bar',
				)
			)
		);

	// On Click Icon Size
	$wp_customize->add_setting( 'customization[header_bottombar_onclick_icon_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '13px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
			'active_callback' 	=> 'is_active_bottom_click_bar',
		)
	);
			$wp_customize->add_control( 'header_bottombar_onclick_icon_size',
				array(
					'type' 				=> 'text',
					'label' 			=> esc_html__( 'On Click Icon Size','um-theme' ),
					'section' 			=> 'customizer_section_bottombar',
					'settings' 			=> 'customization[header_bottombar_onclick_icon_size]',
					'priority'   		=> 30,
					'active_callback' 	=> 'is_active_bottom_click_bar',
					'input_attrs' 		=> array(
							'placeholder' => __( 'example: 13px', 'um-theme' ),
					),
				)
			);

	// On Click Icon Color
	$wp_customize->add_setting( 'customization[header_bottombar_onclick_icon_color]' ,
		array(
			'default' 			=> '#444444',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_bottom_click_bar',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,'header_bottombar_onclick_icon_color', array(
					'label'      		=> esc_html__( 'On Click Icon Color', 'um-theme' ),
					'section'    		=> 'customizer_section_bottombar',
					'settings'   		=> 'customization[header_bottombar_onclick_icon_color]',
					'priority'   		=> 31,
					'active_callback' 	=> 'is_active_bottom_click_bar',
				)
			)
		);

	// On Click Icon Hover Color
	$wp_customize->add_setting( 'customization[header_bottombar_onclick_icon_hover_color]' ,
		array(
			'default' 			=> '#333333',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_bottom_click_bar',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,'header_bottombar_onclick_icon_hover_color', array(
					'label'      		=> esc_html__( 'On Click Icon Hover Color', 'um-theme' ),
					'section'    		=> 'customizer_section_bottombar',
					'settings'   		=> 'customization[header_bottombar_onclick_icon_hover_color]',
					'priority'   		=> 32,
					'active_callback' 	=> 'is_active_bottom_click_bar',
				)
			)
		);
	/*--------------------------------------------------------------
	## Header Friend Requests
	--------------------------------------------------------------*/
	// Show Header Friend Requests
	$wp_customize->add_setting( 'customization[um_show_header_friend_requests]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);
		$wp_customize->add_control( 'um_show_header_friend_requests',
			array(
				'label'      => esc_html__( 'Show Header Friend Requests', 'um-theme' ),
				'section'    => 'customizer_section_header_requests_modal',
				'settings'   => 'customization[um_show_header_friend_requests]',
				'priority'   => 1,
				'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);


	$wp_customize->add_setting( 'um_theme_header_friend_req_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);
			$wp_customize->add_control(
				new UM_Theme_Helper_Line_Break(
					$wp_customize, 'um_theme_header_friend_req_line_break_first', array(
						'section' 	=> 'customizer_section_header_requests_modal',
						'settings'  => 'um_theme_header_friend_req_line_break_first',
						'priority'  => 9,
					)
				)
			);

	// Header Friend Requests Color
	$wp_customize->add_setting( 'customization[header_friend_req_color]' ,
		array(
			'default' 			=> '#cccccc',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_friend_requests',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'header_friend_req_color', array(
					'label'      		=> esc_html__( 'Friend Requests Icon Color', 'um-theme' ),
					'section'    		=> 'customizer_section_header_requests_modal',
					'settings'   		=> 'customization[header_friend_req_color]',
					'priority'   		=> 11,
					'active_callback' 	=> 'is_active_header_friend_requests',
				)
			)
		);

	// Friend Requests Hover Color
	$wp_customize->add_setting( 'customization[header_friend_req_hover_color]' ,
		array(
			'default' 			=> '#bbbbbb',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_friend_requests',
		)
	);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,'header_friend_req_hover_color', array(
					'label'      		=> esc_html__( 'Friend Requests Icon Hover Color', 'um-theme' ),
					'section'    		=> 'customizer_section_header_requests_modal',
					'settings'   		=> 'customization[header_friend_req_hover_color]',
					'priority'   		=> 12,
					'active_callback' 	=> 'is_active_header_friend_requests',
				)
			)
		);

	$wp_customize->add_setting( 'um_theme_header_friend_req_line_break_second',
		array(
			'default'    		=> true,
			'sanitize_callback' => 'wp_kses',
			'active_callback' 	=> 'is_active_header_friend_requests',
		)
	);
			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_header_friend_req_line_break_second',
				array(
					'section' 	=> 'customizer_section_header_requests_modal',
					'settings'  => 'um_theme_header_friend_req_line_break_second',
					'priority'  => 19,
					'active_callback' 	=> 'is_active_header_friend_requests',
			)) );


	// Friend Requests Bubble Background Color
	$wp_customize->add_setting( 'customization[header_friend_req_bubble_bg_color]' ,
		array(
			'default' 			=> '#ED5565',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_friend_requests',
		)
	);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'header_friend_req_bubble_bg_color',
			array(
				'label'      		=> esc_html__( 'Notification Bubble Color', 'um-theme' ),
				'section'    		=> 'customizer_section_header_requests_modal',
				'settings'   		=> 'customization[header_friend_req_bubble_bg_color]',
				'priority'   		=> 21,
				'active_callback' 	=> 'is_active_header_friend_requests',
			)
		));

	// Notification Bubble Color
	$wp_customize->add_setting( 'customization[header_friend_req_bubble_color]' ,
		array(
			'default'	 		=> '#ffffff',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_friend_requests',
		)
	);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'header_friend_req_bubble_color',
			array(
				'label'      		=> esc_html__( 'Notification Counter Color', 'um-theme' ),
				'section'    		=> 'customizer_section_header_requests_modal',
				'settings'   		=> 'customization[header_friend_req_bubble_color]',
				'priority'   		=> 22,
				'active_callback' 	=> 'is_active_header_friend_requests',
			)
		));

	$wp_customize->add_setting( 'um_theme_header_friend_req_line_break_third',
		array(
			'default'    		=> true,
			'sanitize_callback' => 'wp_kses',
			'active_callback' 	=> 'is_active_header_friend_requests',
		)
	);
			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_header_friend_req_line_break_third',
				array(
					'section' 			=> 'customizer_section_header_requests_modal',
					'settings'  		=> 'um_theme_header_friend_req_line_break_third',
					'priority'  		=> 29,
					'active_callback' 	=> 'is_active_header_friend_requests',
			)) );


	// Header Friend Requests Box Color
	$wp_customize->add_setting( 'customization[header_friend_req_box_color]' ,
		array(
			'default' 			=> '#ffffff',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_friend_requests',
		)
	);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_friend_req_box_color',
			array(
				'label'      		=> esc_html__( 'Friend Requests Box Color', 'um-theme' ),
				'section'    		=> 'customizer_section_header_requests_modal',
				'settings'   		=> 'customization[header_friend_req_box_color]',
				'priority'   		=> 31,
				'active_callback' 	=> 'is_active_header_friend_requests',
			)
		));

	// Header Friend Requests Content Color
	$wp_customize->add_setting( 'customization[header_friend_req_content_color]' ,
		array(
			'default' 			=> '#444444',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_friend_requests',
		)
	);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_friend_req_content_color',
			array(
				'label'      		=> esc_html__( 'Friend Requests Content Color', 'um-theme' ),
				'section'    		=> 'customizer_section_header_requests_modal',
				'settings'   		=> 'customization[header_friend_req_content_color]',
				'priority'   		=> 32,
				'active_callback' 	=> 'is_active_header_friend_requests',
			)
		));


	$wp_customize->add_setting( 'um_theme_header_friend_req_line_break_fourth',
		array(
			'default'    		=> true,
			'sanitize_callback' => 'wp_kses',
			'active_callback' 	=> 'is_active_header_friend_requests',
		)
	);
			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_header_friend_req_line_break_fourth',
				array(
					'section' 	=> 'customizer_section_header_requests_modal',
					'settings'  => 'um_theme_header_friend_req_line_break_fourth',
					'priority'  => 39,
					'active_callback' 	=> 'is_active_header_friend_requests',
			)) );

	// Friend Request Confirm Button
	$wp_customize->add_setting( 'customization[header_friend_req_confirm_button_color]' ,
		array(
			'default'	 		=> '#3F51B5',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_friend_requests',
		)
	);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'header_friend_req_confirm_button_color',
			array(
				'label'      		=> esc_html__( 'Confirm Button', 'um-theme' ),
				'section'    		=> 'customizer_section_header_requests_modal',
				'settings'   		=> 'customization[header_friend_req_confirm_button_color]',
				'priority'   		=> 41,
				'active_callback' 	=> 'is_active_header_friend_requests',
			)
		));

	// Friend Request Confirm Button Text
	$wp_customize->add_setting( 'customization[header_friend_req_confirm_button_text_color]' ,
		array(
			'default'	 		=> '#ffffff',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_friend_requests',
		)
	);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'header_friend_req_confirm_button_text_color',
			array(
				'label'      		=> esc_html__( 'Confirm Button Text', 'um-theme' ),
				'section'    		=> 'customizer_section_header_requests_modal',
				'settings'   		=> 'customization[header_friend_req_confirm_button_text_color]',
				'priority'   		=> 42,
				'active_callback' 	=> 'is_active_header_friend_requests',
			)
		));

	// Friend Request Decline Button
	$wp_customize->add_setting( 'customization[header_friend_req_delete_button_color]' ,
		array(
			'default'	 		=> '#f2f2f2',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_friend_requests',
		)
	);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'header_friend_req_delete_button_color',
			array(
				'label'      		=> esc_html__( 'Decline Button', 'um-theme' ),
				'section'    		=> 'customizer_section_header_requests_modal',
				'settings'   		=> 'customization[header_friend_req_delete_button_color]',
				'priority'   		=> 43,
				'active_callback' 	=> 'is_active_header_friend_requests',
			)
		));

	// Friend Request Confirm Button Text
	$wp_customize->add_setting( 'customization[header_friend_req_delete_button_text_color]' ,
		array(
			'default'	 		=> '#3F51B5',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_friend_requests',
		)
	);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'header_friend_req_delete_button_text_color',
			array(
				'label'      		=> esc_html__( 'Decline Button Text', 'um-theme' ),
				'section'    		=> 'customizer_section_header_requests_modal',
				'settings'   		=> 'customization[header_friend_req_delete_button_text_color]',
				'priority'   		=> 44,
				'active_callback' 	=> 'is_active_header_friend_requests',
			)
		));

	/*--------------------------------------------------------------
	## Header Notification Modal
	--------------------------------------------------------------*/
	// Show Header Notification
	$wp_customize->add_setting( 'customization[um_show_header_notification]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);
		$wp_customize->add_control( 'um_show_header_notification',
			array(
				'label'      => esc_html__( 'Show Header Notification', 'um-theme' ),
				'section'    => 'customizer_section_notification_modal',
				'settings'   => 'customization[um_show_header_notification]',
				'priority'   => 1,
				'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	$wp_customize->add_setting( 'um_theme_header_notification_line_break_first',
		array(
			'default'    		=> true,
			'sanitize_callback' => 'wp_kses',
			'active_callback' 	=> 'is_active_header_notification',
		)
	);
			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_header_notification_line_break_first',
				array(
					'section' 			=> 'customizer_section_notification_modal',
					'settings'    		=> 'um_theme_header_notification_line_break_first',
					'priority'   		=> 9,
					'active_callback' 	=> 'is_active_header_notification',
				)
			) );

	// Notification Color
	$wp_customize->add_setting( 'customization[header_notification_color]' ,
		array(
			'default' 			=> '#cccccc',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_notification',
		)
	);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_notification_color',
			array(
				'label'      		=> esc_html__( 'Notification Icon Color', 'um-theme' ),
				'section'    		=> 'customizer_section_notification_modal',
				'settings'   		=> 'customization[header_notification_color]',
				'priority'   		=> 11,
				'active_callback' 	=> 'is_active_header_notification',
			)
		));

	// Notification Hover Color
	$wp_customize->add_setting( 'customization[header_notification_hover_color]' ,
		array(
			'default' 			=> '#bbbbbb',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_notification',
		)
	);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'header_notification_hover_color',
			array(
				'label'      		=> esc_html__( 'Notification Icon Hover Color', 'um-theme' ),
				'section'    		=> 'customizer_section_notification_modal',
				'settings'   		=> 'customization[header_notification_hover_color]',
				'priority'   		=> 12,
				'active_callback' 	=> 'is_active_header_notification',
			)
		));

	$wp_customize->add_setting( 'um_theme_header_notification_line_break_second',
		array(
			'default'    		=> true,
			'sanitize_callback' => 'wp_kses',
			'active_callback' 	=> 'is_active_header_notification',
		)
	);
			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_header_notification_line_break_second',
				array(
					'section' 			=> 'customizer_section_notification_modal',
					'settings'    		=> 'um_theme_header_notification_line_break_second',
					'priority'   		=> 19,
					'active_callback' 	=> 'is_active_header_notification',
				)
			) );

	// Notification Bubble Background Color
	$wp_customize->add_setting( 'customization[header_notification_bubble_bg_color]' ,
		array(
			'default' 			=> '#ED5565',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_notification',
		)
	);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'header_notification_bubble_bg_color',
			array(
				'label'      		=> esc_html__( 'Notification Bubble Color', 'um-theme' ),
				'section'    		=> 'customizer_section_notification_modal',
				'settings'   		=> 'customization[header_notification_bubble_bg_color]',
				'priority'   		=> 21,
				'active_callback' 	=> 'is_active_header_notification',
			)
		));

	// Notification Bubble Color
	$wp_customize->add_setting( 'customization[header_notification_bubble_color]' ,
		array(
			'default'	 		=> '#ffffff',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_notification',
		)
	);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'header_notification_bubble_color',
			array(
				'label'      		=> esc_html__( 'Notification Counter Color', 'um-theme' ),
				'section'    		=> 'customizer_section_notification_modal',
				'settings'   		=> 'customization[header_notification_bubble_color]',
				'priority'   		=> 22,
				'active_callback' 	=> 'is_active_header_notification',
			)
		));

	$wp_customize->add_setting( 'um_theme_header_notification_line_break_third',
		array(
			'default'    		=> true,
			'sanitize_callback' => 'wp_kses',
			'active_callback' 	=> 'is_active_header_notification',
		)
	);
			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_header_notification_line_break_third',
				array(
					'section' 			=> 'customizer_section_notification_modal',
					'settings'    		=> 'um_theme_header_notification_line_break_third',
					'priority'   		=> 29,
					'active_callback' 	=> 'is_active_header_notification',
				)
			) );

	// Notification Box Color
	$wp_customize->add_setting( 'customization[header_notification_box_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		    'active_callback' 	=> 'is_active_header_notification',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_notification_box_color',
			array(
				'label'      		=> esc_html__( 'Notification Box Color', 'um-theme' ),
				'section'    		=> 'customizer_section_notification_modal',
				'settings'   		=> 'customization[header_notification_box_color]',
			    'priority'   		=> 31,
			    'active_callback' 	=> 'is_active_header_notification',
			)
		));


	// Notification Box Color
	$wp_customize->add_setting( 'customization[header_notification_text_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		    'active_callback' 	=> 'is_active_header_notification',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_notification_text_color',
			array(
				'label'      		=> esc_html__( 'Notification Text Color', 'um-theme' ),
				'section'    		=> 'customizer_section_notification_modal',
				'settings'   		=> 'customization[header_notification_text_color]',
			    'priority'   		=> 32,
			    'active_callback' 	=> 'is_active_header_notification',
			)
		));



	/*--------------------------------------------------------------
	## Header Messenger
	--------------------------------------------------------------*/

	// Show Header Messenger
	$wp_customize->add_setting( 'customization[um_show_header_messenger]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_show_header_messenger',
			array(
				'label'      => esc_html__( 'Show Header Messenger', 'um-theme' ),
				'section'    => 'customizer_section_messenger_modal',
				'settings'   => 'customization[um_show_header_messenger]',
			    'priority'   => 1,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);


	// User Display Name in Messenger Modal
	$wp_customize->add_setting( 'customization[um_displayname_header_messenger]' ,
		array(
			'default' 				=> 2,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_displayname_header_messenger',
			array(
				'label'      => esc_html__( 'User Display Name in Messenger Modal', 'um-theme' ),
				'section'    => 'customizer_section_messenger_modal',
				'settings'   => 'customization[um_displayname_header_messenger]',
			    'priority'   => 1,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Nickname', 'um-theme' ),
					2   => esc_html__( 'First Name', 'um-theme' ),
					3   => esc_html__( 'Last Name', 'um-theme' ),
					4   => esc_html__( 'Full Name', 'um-theme' ),
				),
			)
		);


	$wp_customize->add_setting( 'um_theme_header_messenger_line_break_first',
		array(
			'default'    		=> true,
			'sanitize_callback' => 'wp_kses',
			'active_callback' 	=> 'is_active_header_messenger',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_header_messenger_line_break_first',
				array(
					'section' 			=> 'customizer_section_messenger_modal',
					'settings'    		=> 'um_theme_header_messenger_line_break_first',
					'priority'   		=> 9,
					'active_callback' 	=> 'is_active_header_messenger',
				)
			) );

	// Private Message Color
	$wp_customize->add_setting( 'customization[header_private_message_color]' ,
		array(
		    'default' 			=> '#cccccc',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		    'active_callback' 	=> 'is_active_header_messenger',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_private_message_color',
			array(
				'label'      		=> esc_html__( 'Message Icon Color', 'um-theme' ),
				'section'    		=> 'customizer_section_messenger_modal',
				'settings'   		=> 'customization[header_private_message_color]',
			    'priority'   		=> 11,
			    'active_callback' 	=> 'is_active_header_messenger',
			)
		));

	// Private Message Hover Color
	$wp_customize->add_setting( 'customization[header_private_message_hover_color]' ,
		array(
		    'default' 			=> '#bbbbbb',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		    'active_callback' 	=> 'is_active_header_messenger',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'header_private_message_hover_color',
			array(
				'label'      		=> esc_html__( 'Message Icon Hover Color', 'um-theme' ),
				'section'    		=> 'customizer_section_messenger_modal',
				'settings'   		=> 'customization[header_private_message_hover_color]',
			    'priority'   		=> 12,
			    'active_callback' 	=> 'is_active_header_messenger',
			)
		));

	$wp_customize->add_setting( 'um_theme_header_messenger_line_break_second',
		array(
			'default'    		=> true,
			'sanitize_callback' => 'wp_kses',
			'active_callback' 	=> 'is_active_header_messenger',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_header_messenger_line_break_second',
				array(
					'section' 			=> 'customizer_section_messenger_modal',
					'settings'    		=> 'um_theme_header_messenger_line_break_second',
					'priority'   		=> 19,
					'active_callback' 	=> 'is_active_header_messenger',
				)
			) );

	// Messenger Box Color
	$wp_customize->add_setting( 'customization[um_theme_header_messenger_box_color]' ,
		array(
	    'default' 			=> '#ffffff',
	    'type' 				=> 'option',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' 		=> 'postMessage',
		'active_callback' 	=> 'is_active_header_messenger',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_header_messenger_box_color',
			array(
				'label'      		=> esc_html__( 'Message Box Color', 'um-theme' ),
				'section'    		=> 'customizer_section_messenger_modal',
				'settings'   		=> 'customization[um_theme_header_messenger_box_color]',
			    'priority'   		=> 20,
				'active_callback' 	=> 'is_active_header_messenger',
			)
		));

	// Messenger Username Color
	$wp_customize->add_setting( 'customization[um_theme_header_messenger_username_color]' ,
		array(
	    'default' 			=> '#333333',
	    'type' 				=> 'option',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' 		=> 'postMessage',
		'active_callback' 	=> 'is_active_header_messenger',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_header_messenger_username_color',
			array(
				'label'      		=> esc_html__( 'Message Username Color', 'um-theme' ),
				'section'    		=> 'customizer_section_messenger_modal',
				'settings'   		=> 'customization[um_theme_header_messenger_username_color]',
			    'priority'   		=> 21,
				'active_callback' 	=> 'is_active_header_messenger',
			)
		));


	// Messenger Text Color
	$wp_customize->add_setting( 'customization[um_theme_header_messenger_text_color]' ,
		array(
	    'default' 			=> '#333333',
	    'type' 				=> 'option',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' 		=> 'postMessage',
		'active_callback' 	=> 'is_active_header_messenger',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_header_messenger_text_color',
			array(
				'label'      		=> esc_html__( 'Message Text Color', 'um-theme' ),
				'section'    		=> 'customizer_section_messenger_modal',
				'settings'   		=> 'customization[um_theme_header_messenger_text_color]',
			    'priority'   		=> 22,
				'active_callback' 	=> 'is_active_header_messenger',
			)
		));

	// Unread Message Color
	$wp_customize->add_setting( 'customization[um_theme_header_unread_message_color]' ,
		array(
	    'default' 			=> '#e6e9f0',
	    'type' 				=> 'option',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' 		=> 'postMessage',
		'active_callback' 	=> 'is_active_header_messenger',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_header_unread_message_color',
			array(
				'label'      		=> esc_html__( 'Unread Message Color', 'um-theme' ),
				'section'    		=> 'customizer_section_messenger_modal',
				'settings'   		=> 'customization[um_theme_header_unread_message_color]',
			    'priority'   		=> 22,
				'active_callback' 	=> 'is_active_header_messenger',
			)
		));

	/*--------------------------------------------------------------
	## Header Search
	--------------------------------------------------------------*/

	// Show Header Search
	$wp_customize->add_setting( 'customization[um_show_header_search]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_show_header_search',
			array(
				'label'      => esc_html__( 'Header Search', 'um-theme' ),
				'section'    => 'customizer_section_header_search',
				'settings'   => 'customization[um_show_header_search]',
			    'priority'   => 1,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable for All', 'um-theme' ),
					2   => esc_html__( 'Enable for Logged in Users', 'um-theme' ),
					3   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// Header Search Type
	$wp_customize->add_setting( 'customization[um_show_header_search_type]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'is_active_header_search',
		)
	);

		$wp_customize->add_control( 'um_show_header_search_type',
			array(
				'label'      		=> esc_html__( 'Search Type', 'um-theme' ),
				'section'    		=> 'customizer_section_header_search',
				'settings'   		=> 'customization[um_show_header_search_type]',
			    'priority'   		=> 2,
			    'type'       		=> 'select',
			    'active_callback' 	=> 'is_active_header_search',
				'choices'    => array(
					1   => esc_html__( 'Member Search', 'um-theme' ),
					2   => esc_html__( 'Search All Content', 'um-theme' ),
				),
			)
		);

	$wp_customize->add_setting( 'um_theme_header_search_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_header_search_line_break_first',
				array(
					'section' 	=> 'customizer_section_header_search',
					'settings'  => 'um_theme_header_search_line_break_first',
					'priority'  => 9,
			)) );

	// Search Box Color
	$wp_customize->add_setting( 'customization[header_search_background_color]' ,
		array(
		    'default' 			=> '#ecf1ff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		    'active_callback' 	=> 'is_active_header_search',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'header_search_background_color',
			array(
				'label'      		=> esc_html__( 'Search Box Color', 'um-theme' ),
				'section'    		=> 'customizer_section_header_search',
				'settings'   		=> 'customization[header_search_background_color]',
			    'priority'   		=> 10,
	    		'active_callback' 	=> 'is_active_header_search',
			)
		));


	// Search Text Color
	$wp_customize->add_setting( 'customization[header_search_text_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		    'active_callback' 	=> 'is_active_header_search',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_search_text_color',
			array(
				'label'      		=> esc_html__( 'Search Text Color', 'um-theme' ),
				'section'    		=> 'customizer_section_header_search',
				'settings'   		=> 'customization[header_search_text_color]',
			    'priority'   		=> 11,
	    		'active_callback' 	=> 'is_active_header_search',
			)
		));

	// Search Placeholder Text Color
	$wp_customize->add_setting( 'customization[header_search_placeholder_text_color]' ,
		array(
		    'default' 			=> '#888888',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		    'active_callback' 	=> 'is_active_header_search',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_search_placeholder_text_color',
			array(
				'label'      		=> esc_html__( 'Placeholder Text Color', 'um-theme' ),
				'section'    		=> 'customizer_section_header_search',
				'settings'   		=> 'customization[header_search_placeholder_text_color]',
			    'priority'   		=> 12,
	    		'active_callback' 	=> 'is_active_header_search',
			)
		));

	// Menu Font Size
	$wp_customize->add_setting( 'customization[header_search_border_radius]',
		array(
			'type' 				=> 'option',
			'default' 			=> '4px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		    'active_callback' 	=> 'is_active_header_search',
		)
	);
			$wp_customize->add_control( 'header_search_border_radius',
				array(
					'type' 				=> 'text',
					'label' 			=> esc_html__( 'Search Box Border Radius', 'um-theme' ),
					'section' 			=> 'customizer_section_header_search',
					'settings' 			=> 'customization[header_search_border_radius]',
					'priority'   		=> 13,
					'active_callback' 	=> 'is_active_header_search',
	               	'input_attrs' 		=> array(
	            			'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);

/*--------------------------------------------------------------
## Header Logged Out
--------------------------------------------------------------*/

	// Menu For Logged out Users
	$wp_customize->add_setting( 'customization[header_logged_out_display]',
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'header_logged_out_display',
			array(
				'label'      => esc_html__( 'What to display to logged out users', 'um-theme' ),
				'section'    => 'customizer_section_header_logged_out',
				'settings'   => 'customization[header_logged_out_display]',
			    'priority'   => 1,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Show Button 1 & Button 2', 'um-theme' ),
					2   => esc_html__( 'Show Button 1', 'um-theme' ),
					3   => esc_html__( 'Show Button 2', 'um-theme' ),
					4   => esc_html__( 'Show Text', 'um-theme' ),
				),
			)
		);

	$wp_customize->add_setting( 'um_theme_header_logged_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_header_logged_line_break_first',
				array(
					'section' 	=> 'customizer_section_header_logged_out',
					'settings'  => 'um_theme_header_logged_line_break_first',
					'priority'  => 2,
			)) );


	// Button 1
	$wp_customize->add_setting( 'customization[customizer_ui_header_logged_button_one]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
	    	'active_callback' 	=> 'is_active_header_logged_button_one',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'customizer_ui_header_logged_button_one',
				array(
					'type' 				=> 'info',
					'label' 			=> esc_html__( 'Button 1', 'um-theme' ),
					'section' 			=> 'customizer_section_header_logged_out',
					'settings'    		=> 'customization[customizer_ui_header_logged_button_one]',
					'priority'   		=> 10,
	    			'active_callback' 	=> 'is_active_header_logged_button_one',
			)) );

	// Button 1 Text
	$wp_customize->add_setting( 'customization[um_theme_header_out_button_one_text]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_logged_button_one',
		)
	);

			$wp_customize->add_control( 'um_theme_header_out_button_one_text',
				array(
					'type' 				=> 'url',
	               	'label'      		=> esc_html__( 'Button 1 Text', 'um-theme' ),
	               	'section'    		=> 'customizer_section_header_logged_out',
	               	'settings'   		=> 'customization[um_theme_header_out_button_one_text]',
	               	'priority'   		=> 11,
	               	'active_callback' 	=> 'is_active_header_logged_button_one',
	               	'input_attrs' 		=> array(
							'placeholder' => esc_html__( 'Button 1', 'um-theme' ),
					),
				)
			);

	// Button 1 URL
	$wp_customize->add_setting( 'customization[um_theme_header_out_button_one_url]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'esc_url_raw',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_logged_button_one',
		)
	);

			$wp_customize->add_control('um_theme_header_out_button_one_url',
				array(
					'type' 				=> 'url',
	               	'label'      		=> esc_html__( 'Button 1 URL', 'um-theme' ),
	               	'section'    		=> 'customizer_section_header_logged_out',
	               	'settings'   		=> 'customization[um_theme_header_out_button_one_url]',
	               	'priority'   		=> 11,
	               	'active_callback' 	=> 'is_active_header_logged_button_one',
	               	'input_attrs' 		=> array(
							'placeholder' => esc_html__( 'www.example.com', 'um-theme' ),
					),
				)
			);

	// Login Button Color
	$wp_customize->add_setting( 'customization[header_login_button_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'active_callback' 	=> 'is_active_header_logged_button_one',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'header_login_button_color',
			array(
				'label'      		=> esc_html__( 'Button 1 Color', 'um-theme' ),
				'section'    		=> 'customizer_section_header_logged_out',
				'settings'   		=> 'customization[header_login_button_color]',
			    'priority'   		=> 11,
			    'active_callback' 	=> 'is_active_header_logged_button_one',
			)
		));

	// Login Text Color
	$wp_customize->add_setting( 'customization[header_login_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		    'active_callback' 	=> 'is_active_header_logged_button_one',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_login_text_color',
			array(
				'label'      		=> esc_html__( 'Button 1 Text Color', 'um-theme' ),
				'section'    		=> 'customizer_section_header_logged_out',
				'settings'   		=> 'customization[header_login_text_color]',
			    'priority'   		=> 12,
			    'active_callback' 	=> 'is_active_header_logged_button_one',
			)
		));

	// Button 1 Hover Color
	$wp_customize->add_setting( 'customization[um_header_logged_out_button_one_hover_bg]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		    'active_callback' 	=> 'is_active_header_logged_button_one',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_header_logged_out_button_one_hover_bg',
			array(
				'label'      		=> esc_html__( 'Button 1 Hover Color', 'um-theme' ),
				'section'    		=> 'customizer_section_header_logged_out',
				'settings'   		=> 'customization[um_header_logged_out_button_one_hover_bg]',
			    'priority'   		=> 13,
			    'active_callback' 	=> 'is_active_header_logged_button_one',
			)
		));

	// Button 1 Text Hover Color
	$wp_customize->add_setting( 'customization[um_header_logged_out_button_one_hover_text]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		    'active_callback' 	=> 'is_active_header_logged_button_one',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_header_logged_out_button_one_hover_text',
			array(
				'label'      		=> esc_html__( 'Button 1 Hover Text Color', 'um-theme' ),
				'section'   	 	=> 'customizer_section_header_logged_out',
				'settings'   		=> 'customization[um_header_logged_out_button_one_hover_text]',
			    'priority'   		=> 13,
			    'active_callback' 	=> 'is_active_header_logged_button_one',
			)
		));

	// Login Button Border
	$wp_customize->add_setting( 'customization[um_theme_login_button_border_enable]' ,
		array(
			'default' 				=> 2,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'is_active_header_logged_button_one',
		)
	);

		$wp_customize->add_control( 'um_theme_login_button_border_enable',
			array(
				'label'      => esc_html__( 'Button 1 Border', 'um-theme' ),
				'section'    => 'customizer_section_header_logged_out',
				'settings'   => 'customization[um_theme_login_button_border_enable]',
			    'priority'   => 13,
			    'type'       => 'select',
			    'active_callback' 	=> 'is_active_header_logged_button_one',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// Login Button Border Color
	$wp_customize->add_setting( 'customization[um_theme_login_button_border_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		    'active_callback' 	=> 'is_active_login_button_border',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_login_button_border_color',
			array(
				'label'      		=> esc_html__( 'Button 1 Border Color', 'um-theme' ),
				'section'    		=> 'customizer_section_header_logged_out',
				'settings'   		=> 'customization[um_theme_login_button_border_color]',
			    'priority'   		=> 14,
			    'active_callback' 	=> 'is_active_login_button_border',
			)
		));


	// Login Button Border Width
	$wp_customize->add_setting( 'customization[um_theme_login_button_border_width]',
		array(
			'type' 				=> 'option',
			'default' 			=> '1px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
			'active_callback' 	=> 'is_active_login_button_border',
		)
	);
			$wp_customize->add_control('um_theme_login_button_border_width',
				array(
					'type' 				=> 'text',
					'label' 			=> esc_html__( 'Button 1 Border Width', 'um-theme' ),
					'section' 			=> 'customizer_section_header_logged_out',
					'settings' 			=> 'customization[um_theme_login_button_border_width]',
					'priority'   		=> 15,
					'active_callback' 	=> 'is_active_login_button_border',
	               	'input_attrs' 		=> array(
	            			'placeholder' => __( 'example: 1px', 'um-theme' ),
	        		),
				)
			);

	$wp_customize->add_setting( 'um_theme_header_logged_line_break_second',
		array(
			'default'    		=> true,
			'sanitize_callback' => 'wp_kses',
			'active_callback' 	=> 'is_active_header_logged_button_one',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_header_logged_line_break_second',
				array(
					'section' 			=> 'customizer_section_header_logged_out',
					'settings'    		=> 'um_theme_header_logged_line_break_second',
					'priority'   		=> 19,
					'active_callback' 	=> 'is_active_header_logged_button_one',
				)
			) );


	// Button 2
	$wp_customize->add_setting( 'customization[customizer_ui_header_logged_button_two]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
	    	'active_callback' 	=> 'is_active_header_logged_button_two',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'customizer_ui_header_logged_button_two',
				array(
					'type' 				=> 'info',
					'label' 			=> esc_html__( 'Button 2', 'um-theme' ),
					'section' 			=> 'customizer_section_header_logged_out',
					'settings'    		=> 'customization[customizer_ui_header_logged_button_two]',
					'priority'   		=> 20,
	    			'active_callback' 	=> 'is_active_header_logged_button_two',
				)
			) );


	// Button 1 Text
	$wp_customize->add_setting( 'customization[um_theme_header_out_button_two_text]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_logged_button_two',
		)
	);

			$wp_customize->add_control( 'um_theme_header_out_button_two_text',
				array(
					'type' 				=> 'url',
	               	'label'      		=> esc_html__( 'Button 2 Text', 'um-theme' ),
	               	'section'    		=> 'customizer_section_header_logged_out',
	               	'settings'   		=> 'customization[um_theme_header_out_button_two_text]',
	               	'priority'   		=> 21,
	               	'active_callback' 	=> 'is_active_header_logged_button_two',
	               	'input_attrs' 		=> array(
							'placeholder' => esc_html__( 'Button 2', 'um-theme' ),
					),
				)
			);

	// Button 2 URL
	$wp_customize->add_setting( 'customization[um_theme_header_out_button_two_url]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'esc_url_raw',
			'transport' 		=> 'postMessage',
			'active_callback' 	=> 'is_active_header_logged_button_two',
		)
	);

			$wp_customize->add_control('um_theme_header_out_button_two_url',
				array(
					'type' 				=> 'url',
	               	'label'      		=> esc_html__( 'Button 2 URL', 'um-theme' ),
	               	'section'    		=> 'customizer_section_header_logged_out',
	               	'settings'   		=> 'customization[um_theme_header_out_button_two_url]',
	               	'priority'   		=> 21,
	               	'active_callback'	=> 'is_active_header_logged_button_two',
	               	'input_attrs' 		=> array(
							'placeholder' 	=> esc_html__( 'www.example.com', 'um-theme' ),
					),
				)
			);

	// Register Button Color
	$wp_customize->add_setting( 'customization[header_log_button_two_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		    'active_callback' 	=> 'is_active_header_logged_button_two',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_log_button_two_color',
			array(
				'label'      		=> esc_html__( 'Button 2 Color', 'um-theme' ),
				'section'    		=> 'customizer_section_header_logged_out',
				'settings'   		=> 'customization[header_log_button_two_color]',
			    'priority'   		=> 21,
			    'active_callback' 	=> 'is_active_header_logged_button_two',
			)
		));

	// Button 2 Text Color
	$wp_customize->add_setting( 'customization[header_log_button_two_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		    'active_callback' 	=> 'is_active_header_logged_button_two',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_log_button_two_text_color',
			array(
				'label'      		=> esc_html__( 'Button 2 Text Color', 'um-theme' ),
				'section'    		=> 'customizer_section_header_logged_out',
				'settings'   		=> 'customization[header_log_button_two_text_color]',
			    'priority'   		=> 22,
			    'active_callback' 	=> 'is_active_header_logged_button_two',
			)
		));

	// Button 2 Hover Color
	$wp_customize->add_setting( 'customization[um_header_logged_out_button_two_hover_bg]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		    'active_callback' 	=> 'is_active_header_logged_button_two',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'um_header_logged_out_button_two_hover_bg',
			array(
				'label'      		=> esc_html__( 'Button 2 Hover Color', 'um-theme' ),
				'section'    		=> 'customizer_section_header_logged_out',
				'settings'   		=> 'customization[um_header_logged_out_button_two_hover_bg]',
			    'priority'   		=> 22,
			    'active_callback' 	=> 'is_active_header_logged_button_two',
			)
		));

	// Button 2 Hover Text Color
	$wp_customize->add_setting( 'customization[um_header_logged_out_button_two_hover_text]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		    'active_callback' 	=> 'is_active_header_logged_button_two',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'um_header_logged_out_button_two_hover_text',
			array(
				'label'      		=> esc_html__( 'Button 2 Hover Text Color', 'um-theme' ),
				'section'    		=> 'customizer_section_header_logged_out',
				'settings'   		=> 'customization[um_header_logged_out_button_two_hover_text]',
			    'priority'   		=> 22,
			    'active_callback' 	=> 'is_active_header_logged_button_two',
			)
		));

	// Button 2 Border
	$wp_customize->add_setting( 'customization[um_theme_reg_button_border_enable]' ,
		array(
			'default' 				=> 2,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'is_active_header_logged_button_two',
		)
	);

		$wp_customize->add_control( 'um_theme_reg_button_border_enable',
			array(
				'label'      		=> esc_html__( 'Button 2 Border', 'um-theme' ),
				'section'    		=> 'customizer_section_header_logged_out',
				'settings'   		=> 'customization[um_theme_reg_button_border_enable]',
			    'priority'   		=> 23,
			    'type'       		=> 'select',
				'active_callback' 	=> 'is_active_header_logged_button_two',
				'choices'    		=> array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// Login Button Border Color
	$wp_customize->add_setting( 'customization[um_theme_reg_button_border_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		    'active_callback' 	=> 'is_active_reg_button_border',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'um_theme_reg_button_border_color',
			array(
				'label'      		=> esc_html__( 'Button 2 Border Color', 'um-theme' ),
				'section'    		=> 'customizer_section_header_logged_out',
				'settings'   		=> 'customization[um_theme_reg_button_border_color]',
			    'priority'   		=> 24,
			    'active_callback' 	=> 'is_active_reg_button_border',
			)
		));

	// Button 2 Border Width
	$wp_customize->add_setting( 'customization[um_theme_reg_button_border_width]',
		array(
			'type' 				=> 'option',
			'default' 			=> '1px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
			'active_callback' 	=> 'is_active_reg_button_border',
		)
	);
			$wp_customize->add_control('um_theme_reg_button_border_width',
				array(
					'type' 				=> 'text',
					'label' 			=> esc_html__( 'Button 2 Border Width', 'um-theme' ),
					'section' 			=> 'customizer_section_header_logged_out',
					'settings' 			=> 'customization[um_theme_reg_button_border_width]',
					'priority'   		=> 25,
					'active_callback' 	=> 'is_active_reg_button_border',
	               	'input_attrs' 		=> array(
	            			'placeholder' => __( 'example: 1px', 'um-theme' ),
	        		),
				)
			);


	$wp_customize->add_setting( 'um_theme_header_logged_line_break_third',
		array(
			'default'    		=> true,
			'sanitize_callback' => 'wp_kses',
			'active_callback' 	=> 'is_active_header_logged_button_two',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_header_logged_line_break_third',
				array(
					'section' 			=> 'customizer_section_header_logged_out',
					'settings'    		=> 'um_theme_header_logged_line_break_third',
					'priority'   		=> 29,
					'active_callback' 	=> 'is_active_header_logged_button_two',
				)
			) );

	// Header Logged Out Text
	$wp_customize->add_setting( 'customization[header_logged_out_text]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		    'active_callback' 	=> 'is_active_header_logged_out_text',
		)
	);

			$wp_customize->add_control( 'header_logged_out_text',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 31,
	               	'label'      		=> esc_html__( 'Header Logged Out Text', 'um-theme' ),
	               	'description' 		=> esc_html__( 'Let logged out users know what they are missing out on.', 'um-theme' ),
	               	'section'    		=> 'customizer_section_header_logged_out',
	               	'settings'   		=> 'customization[header_logged_out_text]',
	               	'active_callback' 	=> 'is_active_header_logged_out_text',
				)
			);

/*--------------------------------------------------------------
## Header Logged In
--------------------------------------------------------------*/

	// Show User Profile
	$wp_customize->add_setting( 'customization[um_show_header_profile]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_show_header_profile',
			array(
				'label'      => esc_html__( 'User Avatar in Header', 'um-theme' ),
				'section'    => 'customizer_section_header_logged_in',
				'settings'   => 'customization[um_show_header_profile]',
			    'priority'   => 1,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
					3   => esc_html__( 'Floating Profile', 'um-theme' ),

				),
			)
		);

	// Show User Profile
	$wp_customize->add_setting( 'customization[um_show_header_username]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'is_active_header_profile',
		)
	);

		$wp_customize->add_control( 'um_show_header_username',
			array(
				'label'      => esc_html__( 'Display name in header', 'um-theme' ),
				'section'    => 'customizer_section_header_logged_in',
				'settings'   => 'customization[um_show_header_username]',
			    'priority'   => 2,
			    'type'       => 'select',
			    'active_callback' 		=> 'is_active_header_profile',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// Display name in header as
	$wp_customize->add_setting( 'customization[um_header_username_type_select]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'is_active_header_profile',
		)
	);

		$wp_customize->add_control( 'um_header_username_type_select',
			array(
				'label'      => esc_html__( 'Display name in header as', 'um-theme' ),
				'section'    => 'customizer_section_header_logged_in',
				'settings'   => 'customization[um_header_username_type_select]',
			    'priority'   => 3,
			    'type'       => 'select',
				'active_callback' 		=> 'is_active_header_profile',
				'choices'    => array(
					1  	=> esc_html__( 'Display Name', 'um-theme' ),
					2  	=> esc_html__( 'First Name', 'um-theme' ),
					3   => esc_html__( 'Last Name', 'um-theme' ),
					4 	=> esc_html__( 'Nice Name', 'um-theme' ),
				),
			)
		);

	// User Avatar Size
	$wp_customize->add_setting( 'customization[header_profile_avatar_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> 50,
			'sanitize_callback' => 'absint',
			'transport' 		=> 'refresh',
			'active_callback' 	=> 'is_active_header_profile',
		)
	);
			$wp_customize->add_control('header_profile_avatar_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'User Avatar Size', 'um-theme' ),
					'section' 		=> 'customizer_section_header_logged_in',
					'settings' 		=> 'customization[header_profile_avatar_size]',
					'priority'   	=> 4,
					'active_callback' 		=> 'is_active_header_profile',
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 50', 'um-theme' ),
	        		),
				)
			);

	// User Avatar Border Radius
	$wp_customize->add_setting( 'customization[header_profile_border_radius]',
		array(
			'type' 				=> 'option',
			'default' 			=> '45px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
			'active_callback' 	=> 'is_active_header_profile',
		)
	);
			$wp_customize->add_control('header_profile_border_radius',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'User Avatar Border Radius', 'um-theme' ),
					'section' 		=> 'customizer_section_header_logged_in',
					'settings' 		=> 'customization[header_profile_border_radius]',
					'priority'   	=> 4,
					'active_callback' 		=> 'is_active_header_profile',
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);

	// Header Icon Font Size
	$wp_customize->add_setting( 'customization[header_profile_icon_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '16px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
			'active_callback' 	=> 'is_active_header_profile',
		)
	);
			$wp_customize->add_control('header_profile_icon_font_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Icon Font Size', 'um-theme' ),
					'section' 		=> 'customizer_section_header_logged_in',
					'settings' 		=> 'customization[header_profile_icon_font_size]',
					'priority'   	=> 4,
					'active_callback' 		=> 'is_active_header_profile',
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);

	// Header Profile Position
	$wp_customize->add_setting( 'customization[um_header_profile_position]' ,
		array(
			'default' 				=> 2,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'is_active_header_profile',
		)
	);

		$wp_customize->add_control( 'um_header_profile_position',
			array(
				'label'      => esc_html__( 'Header Profile Position', 'um-theme' ),
				'section'    => 'customizer_section_header_logged_in',
				'settings'   => 'customization[um_header_profile_position]',
			    'priority'   => 5,
			    'type'       => 'select',
				'active_callback' 		=> 'is_active_header_profile',
				'choices'    => array(
					1   => esc_html__( 'Left', 'um-theme' ),
					2   => esc_html__( 'Right', 'um-theme' ),
				),
			)
		);

/*--------------------------------------------------------------
## Header Navigation Style
--------------------------------------------------------------*/
	// Menu Font Settings
	$wp_customize->add_setting( 'customization[um_theme_header_nav_ui_font]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_header_nav_ui_font',
				array(
					'type' 				=> 'info',
					'label' 			=> esc_html__( 'Menu Font Settings', 'um-theme' ),
					'section' 			=> 'customizer_section_header_navigation_style',
					'settings'    		=> 'customization[um_theme_header_nav_ui_font]',
					'priority'   		=> 1,
				)
			) );

	// Navigation Font
    $wp_customize->add_setting( 'um_theme_typography_nav_font',
    	array(
        	'default'           => 'Open Sans',
        	'sanitize_callback' => 'sanitize_text_field',
        	'transport' 		=> 'refresh',
        )
    );

	    $wp_customize->add_control( new Google_Font_Dropdown_Custom_Control( $wp_customize, 'um_theme_typography_nav_font',
	    	array(
				'label' 	=> esc_html__( 'Menu Font', 'um-theme' ),
	        	'section'   => 'customizer_section_header_navigation_style',
	        	'settings'  => 'um_theme_typography_nav_font',
	        	'priority'  => 2,
	    )));

	// Menu Font Size
	$wp_customize->add_setting( 'customization[um_theme_menu_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '16px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'postMessage',
		)
	);
			$wp_customize->add_control( 'um_theme_menu_font_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Menu Font Size', 'um-theme' ),
					'section' 		=> 'customizer_section_header_navigation_style',
					'settings' 		=> 'customization[um_theme_menu_font_size]',
					'priority'   	=> 3,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);

	// Menu Position -- Settings
	$wp_customize->add_setting( 'customization[um_theme_menu_position]' ,
		array(
			'default' 			=> 'center',
			'type' 				=> 'option',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_theme_menu_position',
			array(
				'label'      => esc_html__( 'Menu Alignment', 'um-theme' ),
				'section'    => 'customizer_section_header_navigation_style',
				'settings'   => 'customization[um_theme_menu_position]',
			    'priority'   => 4,
			    'type'       => 'select',
				'choices'    => array(
					'start'   	=> esc_html__( 'Left', 'um-theme' ),
					'end'  		=> esc_html__( 'Right', 'um-theme' ),
					'center' 	=> esc_html__( 'Center', 'um-theme' ),
				),
			)
		);

    // Navigation Font Weight
	$wp_customize->add_setting( 'customization[um_theme_nav_weight]' ,
		array(
			'default' 			=> 'normal',
			'type' 				=> 'option',
			'transport' 		=> 'refresh',
			'sanitize_callback' => 'esc_attr',
		)
	);

		$wp_customize->add_control( 'um_theme_nav_weight',
			array(
				'label'      		=> esc_html__( 'Menu Font Weight', 'um-theme' ),
				'section'    		=> 'customizer_section_header_navigation_style',
				'settings'   		=> 'customization[um_theme_nav_weight]',
				'sanitize_callback' => 'esc_attr',
			    'priority'   		=> 5,
			    'type'       		=> 'select',
				'choices'   		=> array(
							'100'   	=> esc_html__( '100', 'um-theme' ),
							'200'  		=> esc_html__( '200', 'um-theme' ),
							'300'		=> esc_html__( '300', 'um-theme' ),
							'400'   	=> esc_html__( '400', 'um-theme' ),
							'500'  		=> esc_html__( '500', 'um-theme' ),
							'600'		=> esc_html__( '600', 'um-theme' ),
							'700'   	=> esc_html__( '700', 'um-theme' ),
							'800'  		=> esc_html__( '800', 'um-theme' ),
							'900'		=> esc_html__( '900', 'um-theme' ),
							'lighter'	=> esc_html__( 'Lighter', 'um-theme' ),
							'normal'   	=> esc_html__( 'Normal', 'um-theme' ),
							'bold'  	=> esc_html__( 'Bold', 'um-theme' ),
							'bolder'	=> esc_html__( 'Bolder', 'um-theme' ),
					),
			)
		);


	$wp_customize->add_setting( 'um_theme_header_nav_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_header_nav_line_break_first',
				array(
					'section' 		=> 'customizer_section_header_navigation_style',
					'settings'   	=> 'um_theme_header_nav_line_break_first',
					'priority'   	=> 9,
			)) );


	// Menu Font Settings
	$wp_customize->add_setting( 'customization[um_theme_header_nav_ui_submenu]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_header_nav_ui_submenu',
				array(
					'type' 				=> 'info',
					'label' 			=> esc_html__( 'Submenu Settings', 'um-theme' ),
					'section' 			=> 'customizer_section_header_navigation_style',
					'settings'    		=> 'customization[um_theme_header_nav_ui_submenu]',
					'priority'   		=> 10,
			)) );

	// Submenu Arrow
	$wp_customize->add_setting( 'customization[um_theme_submenu_arrow]' ,
		array(
			'default' 			=> 2,
			'type' 				=> 'option',
			'sanitize_callback' => 'absint',
			'transport' 		=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_theme_submenu_arrow',
			array(
				'label'      => esc_html__( 'Submenu Arrow', 'um-theme' ),
				'section'    => 'customizer_section_header_navigation_style',
				'settings'   => 'customization[um_theme_submenu_arrow]',
			    'priority'   => 11,
			    'type'       => 'select',
				'choices'    => array(
						1   	=> esc_html__( 'Show', 'um-theme' ),
						2  		=> esc_html__( 'Hide', 'um-theme' ),
				),
			)
		);

	// Submenu Color
	$wp_customize->add_setting( 'customization[um_theme_submenu_background_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_submenu_background_color',
			array(
				'label'      => esc_html__( 'Submenu Color', 'um-theme' ),
				'section'    => 'customizer_section_header_navigation_style',
				'settings'   => 'customization[um_theme_submenu_background_color]',
			    'priority'   => 13,
			)
		));


	// Submenu Text Color
	$wp_customize->add_setting( 'customization[um_theme_submenu_text_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_submenu_text_color',
			array(
				'label'      => esc_html__( 'Submenu Text Color', 'um-theme' ),
				'section'    => 'customizer_section_header_navigation_style',
				'settings'   => 'customization[um_theme_submenu_text_color]',
			    'priority'   => 14,
			)
		));

	$wp_customize->add_setting( 'um_theme_header_nav_line_break_second',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_header_nav_line_break_second',
				array(
					'section' 		=> 'customizer_section_header_navigation_style',
					'settings'   	=> 'um_theme_header_nav_line_break_second',
					'priority'   	=> 19,
			)) );

	// Menu Font Settings
	$wp_customize->add_setting( 'customization[um_theme_header_nav_ui_de_color]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_header_nav_ui_de_color',
				array(
					'type' 				=> 'info',
					'label' 			=> esc_html__( 'Menu Colors', 'um-theme' ),
					'section' 			=> 'customizer_section_header_navigation_style',
					'settings'    		=> 'customization[um_theme_header_nav_ui_de_color]',
					'priority'   		=> 20,
			)) );


	// Menu Text Color -- Settings
	$wp_customize->add_setting( 'customization[menu_text_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'menu_text_color',
			array(
				'label'      => esc_html__( 'Menu Item Color', 'um-theme' ),
				'section'    => 'customizer_section_header_navigation_style',
				'settings'   => 'customization[menu_text_color]',
			    'priority'   => 21,
			)
		));

	// Menu Text Color -- Settings
	$wp_customize->add_setting( 'customization[menu_text_hover_color]',
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_text_hover_color',
			array(
				'label'      => esc_html__( 'Menu Hover Color', 'um-theme' ),
				'section'    => 'customizer_section_header_navigation_style',
				'settings'   => 'customization[menu_text_hover_color]',
			    'priority'   => 22,
			)
		));

	// Selected Menu Text Color -- Settings
	$wp_customize->add_setting( 'customization[selected_menu_text_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'selected_menu_text_color',
			array(
				'label'      => esc_html__( 'Selected Menu Text Color', 'um-theme' ),
				'section'    => 'customizer_section_header_navigation_style',
				'settings'   => 'customization[selected_menu_text_color]',
			    'priority'   => 23,
			)
		));

	// Selected Menu Background Color -- Settings
	$wp_customize->add_setting( 'customization[selected_menu_bg_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'selected_menu_bg_color',
			array(
				'label'      => esc_html__( 'Selected Menu Background Color', 'um-theme' ),
				'section'    => 'customizer_section_header_navigation_style',
				'settings'   => 'customization[selected_menu_bg_color]',
			    'priority'   => 24,
			)
		));

/*--------------------------------------------------------------
## Blog Layout
--------------------------------------------------------------*/
	// Post layout
	$wp_customize->add_setting( 'customization[um_theme_blog_posts_layout]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_theme_blog_posts_layout',
			array(
				'label'      => esc_html__( 'Posts layout', 'um-theme' ),
				'section'    => 'customizer_section_article_layout',
				'settings'   => 'customization[um_theme_blog_posts_layout]',
			    'priority'   => 1,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Grid', 'um-theme' ),
					2   => esc_html__( 'List', 'um-theme' ),
				),
			)
		);

	// Pagination Layout
	$wp_customize->add_setting( 'customization[um_theme_blog_pagination_type]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_theme_blog_pagination_type',
			array(
				'label'      => esc_html__( 'Pagination Type', 'um-theme' ),
				'section'    => 'customizer_section_article_layout',
				'settings'   => 'customization[um_theme_blog_pagination_type]',
			    'priority'   => 1,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Next / Previous', 'um-theme' ),
					2   => esc_html__( 'Numeric 1 2 3', 'um-theme' ),
				),
			)
		);

	// Blog Post background Color
	$wp_customize->add_setting( 'customization[um_theme_blog_post_bg_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'um_theme_blog_post_bg_color',
			array(
				'label'      => esc_html__( 'Post background Color', 'um-theme' ),
				'section'    => 'customizer_section_article_layout',
				'settings'   => 'customization[um_theme_blog_post_bg_color]',
			    'priority'   => 11,
			)
		));

	// Blog Post Content Color
	$wp_customize->add_setting( 'customization[um_theme_blog_post_content_color]' ,
		array(
		    'default' 			=> '#000000',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'um_theme_blog_post_content_color',
			array(
				'label'      => esc_html__( 'Post Content Color', 'um-theme' ),
				'section'    => 'customizer_section_article_layout',
				'settings'   => 'customization[um_theme_blog_post_content_color]',
			    'priority'   => 11,
			)
		));

	// Blog Post Content Color
	$wp_customize->add_setting( 'customization[um_theme_blog_post_title_color]' ,
		array(
		    'default' 			=> '#000000',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_blog_post_title_color',
			array(
				'label'      => esc_html__( 'Post Title Color', 'um-theme' ),
				'section'    => 'customizer_section_article_layout',
				'settings'   => 'customization[um_theme_blog_post_title_color]',
			    'priority'   => 11,
			)
		));


/*--------------------------------------------------------------
## Sidebar Management
--------------------------------------------------------------*/

	// Blog Sidebar Position
	$wp_customize->add_setting( 'customization[um_theme_content_sidebar_position]' ,
		array(
			'default' 				=> 2,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_theme_content_sidebar_position',
			array(
				'label'      => esc_html__( 'Sidebar Position', 'um-theme' ),
				'section'    => 'customizer_section_sidebar_management',
				'settings'   => 'customization[um_theme_content_sidebar_position]',
			    'priority'   => 2,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Right', 'um-theme' ),
					2   => esc_html__( 'Left', 'um-theme' ),
				),
			)
		);


	// Show Sidebar on Post
	$wp_customize->add_setting( 'customization[um_theme_sticky_sidebar]' ,
		array(
			'default' 				=> 2,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_theme_sticky_sidebar',
			array(
				'label'      => esc_html__( 'Sticky Sidebar', 'um-theme' ),
				'section'    => 'customizer_section_sidebar_management',
				'settings'   => 'customization[um_theme_sticky_sidebar]',
			    'priority'   => 3,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);


	// Sidebar Width
	$wp_customize->add_setting( 'customization[um_theme_layout_single_sidebar_width]',
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'transport' 			=> 'refresh',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
		)
	);

		$wp_customize->add_control( 'um_theme_layout_single_sidebar_width',
			array(
				'label'      => esc_html__( 'Sidebar Width', 'um-theme' ),
				'section'    => 'customizer_section_sidebar_management',
				'settings'   => 'customization[um_theme_layout_single_sidebar_width]',
			    'priority'   => 4,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( '25% of Website', 'um-theme' ),
					2   => esc_html__( '35% of Website', 'um-theme' ),
					3   => esc_html__( '40% of Website', 'um-theme' ),
					4   => esc_html__( '50% of Website', 'um-theme' ),
				),
			)
		);


	$wp_customize->add_setting( 'um_theme_sidebar_mgt_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_sidebar_mgt_line_break_first',
				array(
					'section' 		=> 'customizer_section_sidebar_management',
					'settings'   	=> 'um_theme_sidebar_mgt_line_break_first',
					'priority'   	=> 9,
			)) );

	// Show or Hide Sidebar
	$wp_customize->add_setting( 'customization[um_theme_sidebar_mgt_hide_ui_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_sidebar_mgt_hide_ui_title',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Sidebar Location','um-theme' ),
					'section' 		=> 'customizer_section_sidebar_management',
					'settings'  	=> 'customization[um_theme_sidebar_mgt_hide_ui_title]',
					'priority'  	=> 10,
				)
			) );


	// Show Sidebar on Post
	$wp_customize->add_setting( 'customization[um_theme_show_sidebar_post]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_theme_show_sidebar_post',
			array(
				'label'      => esc_html__( 'Single Post', 'um-theme' ),
				'section'    => 'customizer_section_sidebar_management',
				'settings'   => 'customization[um_theme_show_sidebar_post]',
			    'priority'   => 11,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// Show Sidebar on Page
	$wp_customize->add_setting( 'customization[um_theme_show_sidebar_page]' ,
		array(
			'default' 				=> 2,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_theme_show_sidebar_page',
			array(
				'label'      => esc_html__( 'Pages', 'um-theme' ),
				'section'    => 'customizer_section_sidebar_management',
				'settings'   => 'customization[um_theme_show_sidebar_page]',
			    'priority'   => 12,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// Show Sidebar on Archive Pages
	$wp_customize->add_setting( 'customization[um_theme_show_sidebar_archive_page]',
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_theme_show_sidebar_archive_page',
			array(
				'label'      => esc_html__( 'Archive Pages', 'um-theme' ),
				'section'    => 'customizer_section_sidebar_management',
				'settings'   => 'customization[um_theme_show_sidebar_archive_page]',
			    'priority'   => 13,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// Show Sidebar on Search
	$wp_customize->add_setting( 'customization[um_theme_show_sidebar_search]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_theme_show_sidebar_search',
			array(
				'label'      => esc_html__( 'Search Page', 'um-theme' ),
				'section'    => 'customizer_section_sidebar_management',
				'settings'   => 'customization[um_theme_show_sidebar_search]',
			    'priority'   => 14,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// bbPress Sidebar
	$wp_customize->add_setting( 'customization[um_theme_ui_um_group_sidebar]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			'active_callback' 	=> 'um_theme_is_active_um_ext_groups',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_ui_um_group_sidebar',
				array(
					'type' 		=> 'info',
					'label' 	=> esc_html__( 'UM Sidebar', 'um-theme' ),
					'section' 	=> 'customizer_section_sidebar_management',
					'settings'  => 'customization[um_theme_ui_um_group_sidebar]',
					'priority'  => 15,
					'active_callback' 	=> 'um_theme_is_active_um_ext_groups',

			)) );

	// Show Sidebar on UM Groups
	$wp_customize->add_setting( 'customization[um_theme_show_sidebar_group]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'um_theme_is_active_um_ext_groups',
		)
	);

		$wp_customize->add_control( 'um_theme_show_sidebar_group',
			array(
				'label'      		=> esc_html__( 'Group Pages', 'um-theme' ),
				'description'		=> esc_html__( 'Group page of Ultimate Member plugin.', 'um-theme' ),
				'section'    		=> 'customizer_section_sidebar_management',
				'settings'   		=> 'customization[um_theme_show_sidebar_group]',
			    'priority'   		=> 15,
			    'type'       		=> 'select',
				'active_callback'	=> 'um_theme_is_active_um_ext_groups',
				'choices'    		=> array(
						1   => esc_html__( 'Enable', 'um-theme' ),
						2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// bbPress Sidebar
	$wp_customize->add_setting( 'customization[um_theme_ui_bbpress_sidebar]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			'active_callback' 	=> 'um_theme_is_active_bbpress',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_ui_bbpress_sidebar',
				array(
					'type' 		=> 'info',
					'label' 	=> esc_html__( 'bbPress Sidebar', 'um-theme' ),
					'section' 	=> 'customizer_section_sidebar_management',
					'settings'  => 'customization[um_theme_ui_bbpress_sidebar]',
					'priority'  => 16,
					'active_callback'	=> 'um_theme_is_active_bbpress',

			)) );

	// Show Sidebar on bbPress Forums
	$wp_customize->add_setting( 'customization[um_theme_show_sidebar_bb_forum]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'um_theme_is_active_bbpress',
		)
	);

		$wp_customize->add_control( 'um_theme_show_sidebar_bb_forum',
			array(
				'label'      		=> esc_html__( 'bbPress Forum Pages', 'um-theme' ),
				'description'		=> esc_html__( 'Forum page of bbPress plugin.', 'um-theme' ),
				'section'    		=> 'customizer_section_sidebar_management',
				'settings'   		=> 'customization[um_theme_show_sidebar_bb_forum]',
			    'priority'   		=> 17,
			    'type'       		=> 'select',
				'active_callback'	=> 'um_theme_is_active_bbpress',
				'choices'    		=> array(
						1   => esc_html__( 'Enable', 'um-theme' ),
						2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);


	// Show Sidebar on bbPress Topics
	$wp_customize->add_setting( 'customization[um_theme_show_sidebar_bb_topic]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'um_theme_is_active_bbpress',
		)
	);

		$wp_customize->add_control( 'um_theme_show_sidebar_bb_topic',
			array(
				'label'      		=> esc_html__( 'bbPress Topic Pages', 'um-theme' ),
				'description'		=> esc_html__( 'Forum page of bbPress plugin.', 'um-theme' ),
				'section'    		=> 'customizer_section_sidebar_management',
				'settings'   		=> 'customization[um_theme_show_sidebar_bb_topic]',
			    'priority'   		=> 17,
			    'type'       		=> 'select',
				'active_callback'	=> 'um_theme_is_active_bbpress',
				'choices'    		=> array(
						1   => esc_html__( 'Enable', 'um-theme' ),
						2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);


	// Show Sidebar on bbPress Reply
	$wp_customize->add_setting( 'customization[um_theme_show_sidebar_bb_reply]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'um_theme_is_active_bbpress',
		)
	);

		$wp_customize->add_control( 'um_theme_show_sidebar_bb_reply',
			array(
				'label'      		=> esc_html__( 'bbPress Reply Pages', 'um-theme' ),
				'description'		=> esc_html__( 'Forum page of bbPress plugin.', 'um-theme' ),
				'section'    		=> 'customizer_section_sidebar_management',
				'settings'   		=> 'customization[um_theme_show_sidebar_bb_reply]',
			    'priority'   		=> 17,
			    'type'       		=> 'select',
				'active_callback'	=> 'um_theme_is_active_bbpress',
				'choices'    		=> array(
						1   => esc_html__( 'Enable', 'um-theme' ),
						2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// WooCommerce Sidebar
	$wp_customize->add_setting( 'customization[um_theme_ui_woo_sidebar]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			'active_callback' 	=> 'um_theme_is_active_woocommerce',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_ui_woo_sidebar',
				array(
					'type' 		=> 'info',
					'label' 	=> esc_html__( 'WooCommerce Sidebar', 'um-theme' ),
					'section' 	=> 'customizer_section_sidebar_management',
					'settings'  => 'customization[um_theme_ui_woo_sidebar]',
					'priority'  => 19,
					'active_callback' 	=> 'um_theme_is_active_woocommerce',

			)) );

	// Show Sidebar on WooCommerce Archive Page
	$wp_customize->add_setting( 'customization[um_theme_show_sidebar_woo_archive]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'um_theme_is_active_woocommerce',
		)
	);

		$wp_customize->add_control( 'um_theme_show_sidebar_woo_archive',
			array(
				'label'      		=> esc_html__( 'Shop Page', 'um-theme' ),
				'description'		=> esc_html__( 'Product archive page of WooCommerce plugin.', 'um-theme' ),
				'section'    		=> 'customizer_section_sidebar_management',
				'settings'   		=> 'customization[um_theme_show_sidebar_woo_archive]',
			    'priority'   		=> 20,
			    'type'       		=> 'select',
				'active_callback'	=> 'um_theme_is_active_woocommerce',
				'choices'    		=> array(
						1   => esc_html__( 'Enable', 'um-theme' ),
						2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// Show Sidebar on WooCommerce Product Page
	$wp_customize->add_setting( 'customization[um_theme_show_sidebar_woo_product]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'um_theme_is_active_woocommerce',
		)
	);

		$wp_customize->add_control( 'um_theme_show_sidebar_woo_product',
			array(
				'label'      		=> esc_html__( 'Product Page', 'um-theme' ),
				'description'		=> esc_html__( 'Product page of WooCommerce plugin.', 'um-theme' ),
				'section'    		=> 'customizer_section_sidebar_management',
				'settings'   		=> 'customization[um_theme_show_sidebar_woo_product]',
			    'priority'   		=> 20,
			    'type'       		=> 'select',
				'active_callback'	=> 'um_theme_is_active_woocommerce',
				'choices'    		=> array(
						1   => esc_html__( 'Enable', 'um-theme' ),
						2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// ForumWP Sidebar
	$wp_customize->add_setting( 'customization[um_theme_ui_forumwp_sidebar]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			'active_callback' 	=> 'um_theme_is_active_forumwp',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_ui_forumwp_sidebar',
				array(
					'type' 		=> 'info',
					'label' 	=> esc_html__( 'ForumWP Sidebar', 'um-theme' ),
					'section' 	=> 'customizer_section_sidebar_management',
					'settings'  => 'customization[um_theme_ui_forumwp_sidebar]',
					'priority'  => 30,
					'active_callback' 	=> 'um_theme_is_active_forumwp',

			)) );


	// Show Sidebar on ForumWP Forums
	$wp_customize->add_setting( 'customization[um_theme_show_sidebar_forumwp_forum]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'um_theme_is_active_forumwp',
		)
	);

		$wp_customize->add_control( 'um_theme_show_sidebar_forumwp_forum',
			array(
				'label'      		=> esc_html__( 'Forum Pages', 'um-theme' ),
				'section'    		=> 'customizer_section_sidebar_management',
				'settings'   		=> 'customization[um_theme_show_sidebar_forumwp_forum]',
			    'priority'   		=> 31,
			    'type'       		=> 'select',
				'active_callback'	=> 'um_theme_is_active_forumwp',
				'choices'    		=> array(
						1   => esc_html__( 'Enable', 'um-theme' ),
						2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);


	// Show Sidebar on ForumWP Topics
	$wp_customize->add_setting( 'customization[um_theme_show_sidebar_forumwp_topic]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'um_theme_is_active_forumwp',
		)
	);

		$wp_customize->add_control( 'um_theme_show_sidebar_forumwp_topic',
			array(
				'label'      		=> esc_html__( 'Topic Pages', 'um-theme' ),
				'section'    		=> 'customizer_section_sidebar_management',
				'settings'   		=> 'customization[um_theme_show_sidebar_forumwp_topic]',
			    'priority'   		=> 32,
			    'type'       		=> 'select',
				'active_callback'	=> 'um_theme_is_active_forumwp',
				'choices'    		=> array(
						1   => esc_html__( 'Enable', 'um-theme' ),
						2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);


	// Show Sidebar on ForumWP Tag Page
	$wp_customize->add_setting( 'customization[um_theme_show_sidebar_forumwp_tag]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'um_theme_is_active_forumwp',
		)
	);

		$wp_customize->add_control( 'um_theme_show_sidebar_forumwp_tag',
			array(
				'label'      		=> esc_html__( 'Tag Pages', 'um-theme' ),
				'section'    		=> 'customizer_section_sidebar_management',
				'settings'   		=> 'customization[um_theme_show_sidebar_forumwp_tag]',
			    'priority'   		=> 33,
			    'type'       		=> 'select',
				'active_callback'	=> 'um_theme_is_active_forumwp',
				'choices'    		=> array(
						1   => esc_html__( 'Enable', 'um-theme' ),
						2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// Show Sidebar on ForumWP Category Page
	$wp_customize->add_setting( 'customization[um_theme_show_sidebar_forumwp_cat]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'um_theme_is_active_forumwp',
		)
	);

		$wp_customize->add_control( 'um_theme_show_sidebar_forumwp_cat',
			array(
				'label'      		=> esc_html__( 'Category Pages', 'um-theme' ),
				'section'    		=> 'customizer_section_sidebar_management',
				'settings'   		=> 'customization[um_theme_show_sidebar_forumwp_cat]',
			    'priority'   		=> 34,
			    'type'       		=> 'select',
				'active_callback'	=> 'um_theme_is_active_forumwp',
				'choices'    		=> array(
						1   => esc_html__( 'Enable', 'um-theme' ),
						2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);


	// WPAdverts Sidebar
	$wp_customize->add_setting( 'customization[um_theme_ui_wpadverts_sidebar]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			'active_callback' 	=> 'is_active_wp_adverts',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_ui_wpadverts_sidebar',
				array(
					'type' 		=> 'info',
					'label' 	=> esc_html__( 'WPAdverts Sidebar', 'um-theme' ),
					'section' 	=> 'customizer_section_sidebar_management',
					'settings'  => 'customization[um_theme_ui_wpadverts_sidebar]',
					'priority'  => 40,
					'active_callback' 	=> 'is_active_wp_adverts',
			)) );

	// Show Sidebar on WPAdverts Archive Page
	$wp_customize->add_setting( 'customization[um_theme_show_sidebar_wpadverts_archive]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'is_active_wp_adverts',
		)
	);

		$wp_customize->add_control( 'um_theme_show_sidebar_wpadverts_archive',
			array(
				'label'      		=> esc_html__( 'Archive Page', 'um-theme' ),
				'description'		=> esc_html__( 'Product archive page of WooCommerce plugin.', 'um-theme' ),
				'section'    		=> 'customizer_section_sidebar_management',
				'settings'   		=> 'customization[um_theme_show_sidebar_wpadverts_archive]',
			    'priority'   		=> 41,
			    'type'       		=> 'select',
				'active_callback'	=> 'is_active_wp_adverts',
				'choices'    		=> array(
						1   => esc_html__( 'Enable', 'um-theme' ),
						2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// Show Sidebar on WPAdverts Single Page
	$wp_customize->add_setting( 'customization[um_theme_show_sidebar_wpadverts_single]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
			'active_callback' 		=> 'is_active_wp_adverts',
		)
	);

		$wp_customize->add_control( 'um_theme_show_sidebar_wpadverts_single',
			array(
				'label'      		=> esc_html__( 'Single Page', 'um-theme' ),
				'description'		=> esc_html__( 'Product page of WooCommerce plugin.', 'um-theme' ),
				'section'    		=> 'customizer_section_sidebar_management',
				'settings'   		=> 'customization[um_theme_show_sidebar_wpadverts_single]',
			    'priority'   		=> 42,
			    'type'       		=> 'select',
				'active_callback'	=> 'is_active_wp_adverts',
				'choices'    		=> array(
						1   => esc_html__( 'Enable', 'um-theme' ),
						2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);
/*--------------------------------------------------------------
## Typography - Body
--------------------------------------------------------------*/

	// Body Font Settings
	$wp_customize->add_setting( 'customization[um_theme_typography_ui_body_font]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_typography_ui_body_font',
				array(
					'type' => 'info',
					'label' => esc_html__( 'Font Settings', 'um-theme' ),
					'section' => 'customizer_section_typography_body',
					'settings'    => 'customization[um_theme_typography_ui_body_font]',
					'priority'   => 1,
			)) );

	// Typography Body Font & Size
    $wp_customize->add_setting( 'um_theme_typography_body_font',
    	array(
        	'default'           => 'Open Sans',
        	'sanitize_callback' => 'sanitize_text_field',
        	'transport' 		=> 'refresh',
        )
    );

	    $wp_customize->add_control( new Google_Font_Dropdown_Custom_Control( $wp_customize, 'um_theme_typography_body_font',
	    	array(
				'label' 		=> esc_html__( 'Body Font', 'um-theme' ),
	        	'section'    	=> 'customizer_section_typography_body',
	        	'settings'   	=> 'um_theme_typography_body_font',
	        	'priority'   	=> 2,
	    )));

	//Body Text Font Size
	$wp_customize->add_setting( 'customization[um_theme_body_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '16px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'postMessage',
		)
	);

			$wp_customize->add_control( 'um_theme_body_font_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Body Font Size', 'um-theme' ),
					'section' 		=> 'customizer_section_typography_body',
					'settings' 		=> 'customization[um_theme_body_font_size]',
					'priority'   	=> 3,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);

    // Font Weight - Body
	$wp_customize->add_setting( 'customization[um_theme_body_weight]' ,
		array(
			'default' 			=> 'normal',
			'type' 				=> 'option',
			'transport' 		=> 'refresh',
			'sanitize_callback' => 'esc_attr',
		)
	);

		$wp_customize->add_control( 'um_theme_body_weight',
			array(
				'label'      	=> esc_html__( 'Body Font Weight', 'um-theme' ),
				'section'    	=> 'customizer_section_typography_body',
				'settings'   	=> 'customization[um_theme_body_weight]',
				'sanitize_callback' => 'esc_attr',
			    'priority'   	=> 4,
			    'type'       	=> 'select',
					'choices'   => array(
							'100'   	=> esc_html__( '100', 'um-theme' ),
							'200'  		=> esc_html__( '200', 'um-theme' ),
							'300'		=> esc_html__( '300', 'um-theme' ),
							'400'   	=> esc_html__( '400', 'um-theme' ),
							'500'  		=> esc_html__( '500', 'um-theme' ),
							'600'		=> esc_html__( '600', 'um-theme' ),
							'700'   	=> esc_html__( '700', 'um-theme' ),
							'800'  		=> esc_html__( '800', 'um-theme' ),
							'900'		=> esc_html__( '900', 'um-theme' ),
							'lighter'	=> esc_html__( 'Lighter', 'um-theme' ),
							'normal'   	=> esc_html__( 'Normal', 'um-theme' ),
							'bold'  	=> esc_html__( 'Bold', 'um-theme' ),
							'bolder'	=> esc_html__( 'Bolder', 'um-theme' ),
					),
			)
		);

	// Enable Font Smoothing
	$wp_customize->add_setting( 'customization[um_enable_font_smoothing]' ,
		array(
        	'default' 			=> true,
        	'type' 				=> 'option',
        	'sanitize_callback' => 'wp_validate_boolean',
		)
	);

		$wp_customize->add_control( 'um_enable_font_smoothing',
			array(
				'label'      	=> esc_html__( 'Enable Font Smoothing', 'um-theme' ),
				'section'    	=> 'customizer_section_typography_body',
				'settings'   	=> 'customization[um_enable_font_smoothing]',
			    'priority'   	=> 5,
			    'type'       	=> 'checkbox',
			    'transport' 	=> 'refresh',
			)
		);

	$wp_customize->add_setting( 'um_theme_typography_body_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_typography_body_line_break_first',
				array(
					'section' => 'customizer_section_typography_body',
					'settings'    => 'um_theme_typography_body_line_break_first',
					'priority'   => 9,
			)) );

	// Body Text Color -- Settings
	$wp_customize->add_setting( 'customization[body_text_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'body_text_color',
			array(
				'label'      => esc_html__( 'Body Text Color', 'um-theme' ),
				'section'    => 'customizer_section_typography_body',
				'settings'   => 'customization[body_text_color]',
			    'priority'   => 11,
			)
		));

/*--------------------------------------------------------------
## Typography - Heading
--------------------------------------------------------------*/

	// Heading Font Settings
	$wp_customize->add_setting( 'customization[um_theme_typography_ui_title_font]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_typography_ui_title_font',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Font Settings', 'um-theme' ),
					'section' 		=> 'customizer_section_typography_title',
					'settings'    	=> 'customization[um_theme_typography_ui_title_font]',
					'priority'   	=> 1,
			)) );

    $wp_customize->add_setting( 'um_theme_typography_title_font',
    	array(
        	'default'           => 'Open Sans',
        	'sanitize_callback' => 'sanitize_text_field',
        	'transport' 		=> 'refresh',
        )
    );

	    $wp_customize->add_control( new Google_Font_Dropdown_Custom_Control( $wp_customize, 'um_theme_typography_title_font',
	    	array(
				'label' 	=> esc_html__( 'Heading Font', 'um-theme' ),
	        	'section'   => 'customizer_section_typography_title',
	        	'settings'  => 'um_theme_typography_title_font',
	        	'priority'  => 2,
	    )));

    // Font Weight - Title
	$wp_customize->add_setting( 'customization[um_theme_title_weight]' ,
		array(
			'default' 			=> 'normal',
			'type' 				=> 'option',
			'transport' 		=> 'refresh',
			'sanitize_callback' => 'esc_attr',
		)
	);

		$wp_customize->add_control( 'um_theme_title_weight',
			array(
				'label'      	=> esc_html__( 'Font Weight', 'um-theme' ),
				'section'    	=> 'customizer_section_typography_title',
				'settings'   	=> 'customization[um_theme_title_weight]',
				'sanitize_callback' => 'esc_attr',
			    'priority'   	=> 3,
			    'type'       	=> 'select',
					'choices'   => array(
							'100'   	=> esc_html__( '100', 'um-theme' ),
							'200'  		=> esc_html__( '200', 'um-theme' ),
							'300'		=> esc_html__( '300', 'um-theme' ),
							'400'   	=> esc_html__( '400', 'um-theme' ),
							'500'  		=> esc_html__( '500', 'um-theme' ),
							'600'		=> esc_html__( '600', 'um-theme' ),
							'700'   	=> esc_html__( '700', 'um-theme' ),
							'800'  		=> esc_html__( '800', 'um-theme' ),
							'900'		=> esc_html__( '900', 'um-theme' ),
							'lighter'	=> esc_html__( 'Lighter', 'um-theme' ),
							'normal'   	=> esc_html__( 'Normal', 'um-theme' ),
							'bold'  	=> esc_html__( 'Bold', 'um-theme' ),
							'bolder'	=> esc_html__( 'Bolder', 'um-theme' ),
					),
			)
		);

    // Title Text Transform
	$wp_customize->add_setting( 'customization[um_theme_title_capitalization]' ,
		array(
			'default' 			=> 'none',
			'type' 				=> 'option',
			'transport' 		=> 'postMessage',
			'sanitize_callback' => 'sanitize_key',
		)
	);

		$wp_customize->add_control( 'um_theme_title_capitalization',
			array(
				'label'      		=> esc_html__( 'Font Format', 'um-theme' ),
				'section'    		=> 'customizer_section_typography_title',
				'settings'   		=> 'customization[um_theme_title_capitalization]',
				'sanitize_callback' => 'esc_attr',
			    'priority'   		=> 4,
			    'type'       		=> 'select',
					'choices'   	=> array(
							'none'   		=> esc_html__( 'Normal', 'um-theme' ),
							'uppercase' 	=> esc_html__( 'UPPERCASE', 'um-theme' ),
							'lowercase'		=> esc_html__( 'lowercase', 'um-theme' ),
							'capitalize'	=> esc_html__( 'Capitalize', 'um-theme' ),
					),
			)
		);


	$wp_customize->add_setting( 'um_theme_typography_heading_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_typography_heading_line_break_first',
				array(
					'section' 	=> 'customizer_section_typography_title',
					'settings'  => 'um_theme_typography_heading_line_break_first',
					'priority'  => 9,
				)
			) );

	// Heading Font Settings
	$wp_customize->add_setting( 'customization[um_theme_typography_ui_title_font_size]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_typography_ui_title_font_size',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Font Size', 'um-theme' ),
					'section' 		=> 'customizer_section_typography_title',
					'settings'    	=> 'customization[um_theme_typography_ui_title_font_size]',
					'priority'   	=> 10,
				)
			) );

	// H1 Font Size
	$wp_customize->add_setting('customization[body_h1_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '40px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control('body_h1_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'H1', 'um-theme' ),
					'section' 		=> 'customizer_section_typography_title',
					'settings' 		=> 'customization[body_h1_size]',
					'priority'   	=> 11,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 36px', 'um-theme' ),
	        		),
				)
			);

	// H2 Font Size
	$wp_customize->add_setting('customization[body_h2_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '34px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control('body_h2_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'H2', 'um-theme' ),
					'section' 		=> 'customizer_section_typography_title',
					'settings' 		=> 'customization[body_h2_size]',
					'priority'   	=> 12,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 24px', 'um-theme' ),
	        		),
				)
			);


	// H3 Font Size
	$wp_customize->add_setting( 'customization[body_h3_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '28px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'body_h3_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'H3', 'um-theme' ),
					'section' 		=> 'customizer_section_typography_title',
					'settings' 		=> 'customization[body_h3_size]',
					'priority'   	=> 13,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);

	// H4 Font Size
	$wp_customize->add_setting( 'customization[body_h4_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '22px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'body_h4_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'H4', 'um-theme' ),
					'section' 		=> 'customizer_section_typography_title',
					'settings' 		=> 'customization[body_h4_size]',
					'priority'   	=> 14,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);

	// H5 Font Size
	$wp_customize->add_setting( 'customization[body_h5_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '16px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control('body_h5_size', array(
				'type' 			=> 'text',
				'label' 		=> esc_html__( 'H5', 'um-theme' ),
				'section' 		=> 'customizer_section_typography_title',
				'settings' 		=> 'customization[body_h5_size]',
				'priority'   	=> 15,
               	'input_attrs' 	=> array(
            		'placeholder' => __( 'example: 16px', 'um-theme' ),
        		),
			) );

	// H6 Font Size
	$wp_customize->add_setting('customization[body_h6_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '16px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'body_h6_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'H6', 'um-theme' ),
					'section' 		=> 'customizer_section_typography_title',
					'settings' 		=> 'customization[body_h6_size]',
					'priority'   	=> 16,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);

	$wp_customize->add_setting( 'um_theme_typography_heading_line_break_second',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_typography_heading_line_break_second',
				array(
					'section' 		=> 'customizer_section_typography_title',
					'settings'    	=> 'um_theme_typography_heading_line_break_second',
					'priority'   	=> 19,
				)
			) );

	// Title Text Color -- Settings
	$wp_customize->add_setting( 'customization[title_text_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'title_text_color',
			array(
				'label'      	=> esc_html__( 'Heading Text Color', 'um-theme' ),
				'section'    	=> 'customizer_section_typography_title',
				'settings'   	=> 'customization[title_text_color]',
			    'priority'   	=> 21,
			)
		));

/*--------------------------------------------------------------
## Font Style
--------------------------------------------------------------*/
    // Widget Left Title Alignment
	$wp_customize->add_setting( 'customization[um_theme_widget_title_alignment]' ,
		array(
			'default' 			=> 'left',
			'type' 				=> 'option',
			'transport' 		=> 'postMessage',
			'sanitize_callback' => 'sanitize_key',
		)
	);

		$wp_customize->add_control( 'um_theme_widget_title_alignment',
			array(
				'label'      		=> esc_html__( 'Widget Title Alignment', 'um-theme' ),
				'section'    		=> 'customizer_section_widget_area',
				'settings'   		=> 'customization[um_theme_widget_title_alignment]',
				'sanitize_callback' => 'esc_attr',
			    'priority'   		=> 32,
			    'type'       		=> 'select',
					'choices'   	=> array(
							'left'   	=> esc_html__( 'Left', 'um-theme' ),
							'center'  	=> esc_html__( 'Center', 'um-theme' ),
							'right'		=> esc_html__( 'Right', 'um-theme' ),
					),
			)
		);
/*--------------------------------------------------------------
## Social Accounts
--------------------------------------------------------------*/

	// Social Account Title
	$wp_customize->add_setting( 'customization[um_theme_social_account_ui_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_social_account_ui_title',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Social Accounts', 'um-theme' ),
					'section' 		=> 'customizer_style_social_account',
					'settings'    	=> 'customization[um_theme_social_account_ui_title]',
					'priority'   	=> 1,
				)
			) );

    // Social Accounts Icon One
    $wp_customize->add_setting('customization[um_theme_social_account_icon_one]',
    	array(
	        'sanitize_callback' 	=> 'esc_attr',
	        'transport' 			=> 'refresh',
	        'type' 					=> 'option',
    	)
    );

	    $wp_customize->add_control('um_theme_social_account_icon_one',
	    	array(
		        'section' 		=> 'customizer_style_social_account',
		        'type' 			=> 'select',
		        'choices' 		=> um_theme_social_accounts_icons(),
		        'priority'   	=> 2,
				'settings'    	=> 'customization[um_theme_social_account_icon_one]',
	    	)
	    );

	// Social Accounts URL One
	$wp_customize->add_setting('customization[um_theme_social_account_link_one]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'esc_url_raw',
			'transport' 		=> 'postMessage',
		)
	);

			$wp_customize->add_control( 'um_theme_social_account_link_one',
				array(
					'type' 		=> 'url',
	               	'section'    => 'customizer_style_social_account',
	               	'settings'   => 'customization[um_theme_social_account_link_one]',
	               	'priority'   => 3,
	               	'input_attrs' => array(
						'placeholder' => esc_html__( 'url', 'um-theme' ),
					),
				)
			);

    // Social Accounts Icon Two
    $wp_customize->add_setting( 'customization[um_theme_social_account_icon_two]',
    	array(
	        'sanitize_callback' 	=> 'esc_attr',
	        'transport' 			=> 'refresh',
	        'type' 					=> 'option',
    	)
    );

	    $wp_customize->add_control( 'um_theme_social_account_icon_two',
	    	array(
		        'section' 		=> 'customizer_style_social_account',
		        'type' 			=> 'select',
		        'choices' 		=> um_theme_social_accounts_icons(),
		        'priority'   	=> 4,
				'settings'    	=> 'customization[um_theme_social_account_icon_two]',
	    	)
	    );

	// Social Accounts URL Two
	$wp_customize->add_setting( 'customization[um_theme_social_account_link_two]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'esc_url_raw',
			'transport' 		=> 'postMessage',
		)
	);

			$wp_customize->add_control( 'um_theme_social_account_link_two',
				array(
					'type' 			=> 'url',
	               	'section'    	=> 'customizer_style_social_account',
	               	'settings'   	=> 'customization[um_theme_social_account_link_two]',
	               	'priority'   	=> 5,
	                'input_attrs' 	=> array(
						'placeholder' => esc_html__( 'url', 'um-theme' ),
					),
				)
			);

    // Social Accounts Icon Three
    $wp_customize->add_setting( 'customization[um_theme_social_account_icon_three]',
    	array(
	        'sanitize_callback' 	=> 'esc_attr',
	        'transport' 			=> 'refresh',
	        'type' 					=> 'option',
    	)
    );

	    $wp_customize->add_control( 'um_theme_social_account_icon_three',
	    	array(
		        'section' 		=> 'customizer_style_social_account',
		        'type' 			=> 'select',
		        'choices' 		=> um_theme_social_accounts_icons(),
		        'priority'   	=> 6,
				'settings'    	=> 'customization[um_theme_social_account_icon_three]',
	    	)
	    );

	// Social Accounts URL Three
	$wp_customize->add_setting( 'customization[um_theme_social_account_link_three]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'esc_url_raw',
			'transport' 		=> 'postMessage',
		)
	);

			$wp_customize->add_control( 'um_theme_social_account_link_three',
				array(
					'type' 			=> 'url',
	               	'section'    	=> 'customizer_style_social_account',
	               	'settings'   	=> 'customization[um_theme_social_account_link_three]',
	               	'priority'   	=> 7,
	               	'input_attrs' 	=> array(
						'placeholder' => esc_html__( 'url', 'um-theme' ),
					),
				)
			);

    // Social Accounts Icon Four
    $wp_customize->add_setting( 'customization[um_theme_social_account_icon_four]',
    	array(
	        'sanitize_callback' 	=> 'esc_attr',
	        'transport' 			=> 'refresh',
	        'type' 					=> 'option',
    	)
    );

	    $wp_customize->add_control('um_theme_social_account_icon_four',
	    	array(
		        'section' 		=> 'customizer_style_social_account',
		        'type' 			=> 'select',
				'settings'    	=> 'customization[um_theme_social_account_icon_four]',
		        'choices' 		=> um_theme_social_accounts_icons(),
		        'priority'   	=> 8,
	    	)
	    );

	// Social Accounts URL Four
	$wp_customize->add_setting( 'customization[um_theme_social_account_link_four]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'esc_url_raw',
			'transport' 		=> 'postMessage',
		)
	);

			$wp_customize->add_control( 'um_theme_social_account_link_four',
				array(
					'type' 			=> 'url',
	               	'section'    	=> 'customizer_style_social_account',
	               	'settings'   	=> 'customization[um_theme_social_account_link_four]',
	               	'priority'   	=> 9,
	               	'input_attrs' 	=> array(
					    'placeholder' => esc_html__( 'url', 'um-theme' ),
					),
				)
			);

    // Social Accounts Icon Five
    $wp_customize->add_setting( 'customization[um_theme_social_account_icon_five]',
    	array(
	        'sanitize_callback' 	=> 'esc_attr',
	        'transport' 			=> 'refresh',
	        'type' 					=> 'option',
    	)
    );

	    $wp_customize->add_control( 'um_theme_social_account_icon_five',
	    	array(
		        'section' 		=> 'customizer_style_social_account',
		        'type' 			=> 'select',
				'settings'    	=> 'customization[um_theme_social_account_icon_five]',
		        'choices' 		=> um_theme_social_accounts_icons(),
		        'priority'   	=> 10,
	    	)
	    );

	// Social Accounts URL Five
	$wp_customize->add_setting( 'customization[um_theme_social_account_link_five]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'esc_url_raw',
			'transport' 		=> 'postMessage',
		)
	);

			$wp_customize->add_control( 'um_theme_social_account_link_five',
				array(
					'type' 			=> 'url',
	               	'section'    	=> 'customizer_style_social_account',
	               	'settings'   	=> 'customization[um_theme_social_account_link_five]',
	               	'priority'   	=> 11,
	               	'input_attrs' 	=> array(
					    'placeholder' => esc_html__( 'url', 'um-theme' ),
					),
				)
			);

    // Social Accounts Icon Six
    $wp_customize->add_setting( 'customization[um_theme_social_account_icon_six]',
    	array(
	        'sanitize_callback' 	=> 'esc_attr',
	        'transport' 			=> 'refresh',
	        'type' 					=> 'option',
    	)
    );

	    $wp_customize->add_control( 'um_theme_social_account_icon_six',
	    	array(
		        'section' 		=> 'customizer_style_social_account',
		        'type' 			=> 'select',
				'settings'    	=> 'customization[um_theme_social_account_icon_six]',
		        'choices' 		=> um_theme_social_accounts_icons(),
		        'priority'   	=> 12,
	    	)
	    );

	// Social Accounts URL Six
	$wp_customize->add_setting( 'customization[um_theme_social_account_link_six]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'esc_url_raw',
			'transport' 		=> 'postMessage',
		)
	);

			$wp_customize->add_control( 'um_theme_social_account_link_six',
				array(
					'type' 			=> 'email',
	               	'section'    	=> 'customizer_style_social_account',
	               	'settings'   	=> 'customization[um_theme_social_account_link_six]',
	               	'priority'   	=> 13,
	               	'input_attrs' 	=> array(
					    	'placeholder' => esc_html__( 'url', 'um-theme' ),
					),
				)
			);


	$wp_customize->add_setting( 'um_theme_social_account_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_social_account_line_break_first',
				array(
					'section' 		=> 'customizer_style_social_account',
					'settings'    	=> 'um_theme_social_account_line_break_first',
					'priority'   	=> 19,
				)
			) );

	// Social Icon Color
	$wp_customize->add_setting( 'customization[social_accounts_color]' ,
		array(
		    'default' 					=> '#333333',
		    'type' 						=> 'option',
		    'sanitize_callback' 		=> 'sanitize_hex_color',
		    'transport' 				=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'social_accounts_color',
			array(
				'label'      => esc_html__( 'Social Icon Color', 'um-theme' ),
				'section'    => 'customizer_style_social_account',
				'settings'   => 'customization[social_accounts_color]',
			    'priority'   => 21,
			)
		));

	// Social Icon Hover Color
	$wp_customize->add_setting( 'customization[social_accounts_hover_color]',
		array(
		    'default' 					=> '#333333',
		    'type' 						=> 'option',
		    'sanitize_callback' 		=> 'sanitize_hex_color',
		    'transport' 				=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'social_accounts_hover_color',
			array(
				'label'      => esc_html__( 'Social Icon Hover Color', 'um-theme' ),
				'section'    => 'customizer_style_social_account',
				'settings'   => 'customization[social_accounts_hover_color]',
			    'priority'   => 22,
			)
		));

/*--------------------------------------------------------------
## Footer Layout
--------------------------------------------------------------*/

	// Bottom Bar Layout
	$wp_customize->add_setting( 'customization[um_show_footer_layout]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_show_footer_layout',
			array(
				'label'      => esc_html__( 'Footer Bar Layout', 'um-theme' ),
				'section'    => 'customizer_section_footer_layout',
				'settings'   => 'customization[um_show_footer_layout]',
			    'priority'   => 10,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( '1 Column', 'um-theme' ),
					2   => esc_html__( '2 Column', 'um-theme' ),
				),
			)
		);

	// Bottom Bar Layout Column First Layout
	$wp_customize->add_setting( 'customization[um_footer_colum_first_layout]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'   	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_footer_colum_first_layout',
			array(
				'label'      => esc_html__( 'Column 1 Layout', 'um-theme' ),
				'section'    => 'customizer_section_footer_layout',
				'settings'   => 'customization[um_footer_colum_first_layout]',
			    'priority'   => 11,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Text', 'um-theme' ),
					2   => esc_html__( 'Menu', 'um-theme' ),
				),
			)
		);

	// Column 1 Text
	$wp_customize->add_setting( 'customization[um_footer_colum_first_text]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		    'active_callback' 	=> 'is_active_footer_column_one_text',
		)
	);

			$wp_customize->add_control('um_footer_colum_first_text',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 12,
	               	'label'      		=> esc_html__( 'Column 1 Text', 'um-theme' ),
	               	'section'    		=> 'customizer_section_footer_layout',
	               	'settings'   		=> 'customization[um_footer_colum_first_text]',
		    		'active_callback' 	=> 'is_active_footer_column_one_text',
				)
			);

	// Bottom Bar Layout Column Second Layout
	$wp_customize->add_setting( 'customization[um_footer_colum_second_layout]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
	    	'active_callback' 		=> 'is_active_footer_column_two',
		)
	);

		$wp_customize->add_control( 'um_footer_colum_second_layout',
			array(
				'label'      		=> esc_html__( 'Column 2 Layout', 'um-theme' ),
				'section'    		=> 'customizer_section_footer_layout',
				'settings'   		=> 'customization[um_footer_colum_second_layout]',
			    'priority'   		=> 13,
			    'type'       		=> 'select',
	    		'active_callback' 	=> 'is_active_footer_column_two',
				'choices'    		=> array(
						1   => esc_html__( 'Text', 'um-theme' ),
						2   => esc_html__( 'Menu', 'um-theme' ),
				),
			)
		);

	// Column 2 Text
	$wp_customize->add_setting( 'customization[um_footer_colum_second_text]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses_post',
			'transport' 		=> 'refresh',
		    'active_callback' 	=> 'is_active_footer_column_two_text',
		)
	);

			$wp_customize->add_control( 'um_footer_colum_second_text',
				array(
					'type' 				=> 'textarea',
					'priority'   		=> 14,
	               	'label'      		=> esc_html__( 'Column 2 Text', 'um-theme' ),
	               	'section'    		=> 'customizer_section_footer_layout',
	               	'settings'   		=> 'customization[um_footer_colum_second_text]',
		    		'active_callback' 	=> 'is_active_footer_column_two_text',
				)
			);

	$wp_customize->add_setting( 'um_theme_footer_bottom_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_footer_bottom_line_break_first',
				array(
					'section' 		=> 'customizer_section_footer_layout',
					'settings'    	=> 'um_theme_footer_bottom_line_break_first',
					'priority'   	=> 29,
				)
			) );

	// Profile Content
	$wp_customize->add_setting( 'customization[um_theme_footer_ui_bottom_color]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_footer_ui_bottom_color',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Color', 'um-theme' ),
					'section' 		=> 'customizer_section_footer_layout',
					'settings'    	=> 'customization[um_theme_footer_ui_bottom_color]',
					'priority'   	=> 30,
				)
			) );

	// Footer Text Color - Settings
	$wp_customize->add_setting( 'customization[footer_text_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'footer_text_color',
			array(
				'label'      => esc_html__( 'Footer Text', 'um-theme' ),
				'section'    => 'customizer_section_footer_layout',
				'settings'   => 'customization[footer_text_color]',
			    'priority'   => 31,
			)
		));

	// Footer Text Color - Settings
	$wp_customize->add_setting( 'customization[footer_link_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'footer_link_color',
			array(
				'label'      => esc_html__( 'Footer Link', 'um-theme' ),
				'section'    => 'customizer_section_footer_layout',
				'settings'   => 'customization[footer_link_color]',
			    'priority'   => 32,
			)
		));

	// Footer Link Hover Color - Settings
	$wp_customize->add_setting( 'customization[footer_link_hover_color]',
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'footer_link_hover_color',
			array(
				'label'      => esc_html__( 'Footer Link Hover', 'um-theme' ),
				'section'    => 'customizer_section_footer_layout',
				'settings'   => 'customization[footer_link_hover_color]',
			    'priority'   => 33,
			)
		));

	// Footer Background Color - Settings
	$wp_customize->add_setting( 'customization[footer_background_color]' ,
		array(
		    'default' 			=> '#eceef1',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'footer_background_color',
			array(
				'label'      => esc_html__( 'Footer Background', 'um-theme' ),
				'section'    => 'customizer_section_footer_layout',
				'settings'   => 'customization[footer_background_color]',
			    'priority'   => 34,
			)
		));

	// Footer Menu Color
	$wp_customize->add_setting( 'customization[footer_menu_color]',
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'footer_menu_color',
			array(
				'label'      => esc_html__( 'Footer Menu', 'um-theme' ),
				'section'    => 'customizer_section_footer_layout',
				'settings'   => 'customization[footer_menu_color]',
			    'priority'   => 35,
			)
		));

	// Footer Menu Font Size
	$wp_customize->add_setting( 'customization[footer_menu_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '13px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'footer_menu_font_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Footer Bottom Font Size', 'um-theme' ),
					'section' 		=> 'customizer_section_footer_layout',
					'settings' 		=> 'customization[footer_menu_font_size]',
					'priority'   	=> 36,
	               	'input_attrs' 	=> array(
		            		'placeholder' => __( 'example: 13px', 'um-theme' ),
		        	),
				)
			);

	$wp_customize->add_setting( 'um_theme_footer_bottom_line_break_second',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_footer_bottom_line_break_second',
				array(
					'section' 		=> 'customizer_section_footer_layout',
					'settings'    	=> 'um_theme_footer_bottom_line_break_second',
					'priority'   	=> 39,
				)
			) );

	// Profile Content
	$wp_customize->add_setting( 'customization[um_theme_footer_ui_bottom_scrolltop]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_footer_ui_bottom_scrolltop',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Scroll to Top', 'um-theme' ),
					'section' 		=> 'customizer_section_footer_layout',
					'settings'    	=> 'customization[um_theme_footer_ui_bottom_scrolltop]',
					'priority'   	=> 40,
				)
			) );

	// Scroll To Top
	$wp_customize->add_setting( 'customization[um_theme_show_scroll_to_top]',
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_theme_show_scroll_to_top',
			array(
				'label'      => esc_html__( 'Scroll To Top Icon', 'um-theme' ),
				'section'    => 'customizer_section_footer_layout',
				'settings'   => 'customization[um_theme_show_scroll_to_top]',
			    'priority'   => 41,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// Scroll to Top Color
	$wp_customize->add_setting( 'customization[um_theme_primary_color]',
		array(
		    'default' 			=> '#2196F3',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_primary_color',
			array(
				'label'      		=> esc_html__( 'Scroll to Top Color', 'um-theme' ),
				'section'    		=> 'customizer_section_footer_layout',
				'settings'   		=> 'customization[um_theme_primary_color]',
			    'priority'   		=> 42,
			)
		));

/*--------------------------------------------------------------
## Footer Widgets
--------------------------------------------------------------*/

	$wp_customize->add_setting( 'customization[um_theme_footer_ui_widget_setting]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_footer_ui_widget_setting',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Widget Settings', 'um-theme' ),
					'section' 		=> 'customizer_section_footer_widget',
					'settings'    	=> 'customization[um_theme_footer_ui_widget_setting]',
					'priority'   	=> 1,
				)
			) );

	// Footer Widgets Column
	$wp_customize->add_setting( 'customization[um_theme_footer_widget_column]' ,
		array(
			'default' 			=> 'boot-col-md-3',
			'type' 				=> 'option',
			'transport' 		=> 'refresh',
			'sanitize_callback' => 'esc_attr',
		)
	);

		$wp_customize->add_control( 'um_theme_footer_widget_column',
			array(
				'label'      => esc_html__( 'Widgets per row', 'um-theme' ),
				'section'    => 'customizer_section_footer_widget',
				'settings'   => 'customization[um_theme_footer_widget_column]',
			    'priority'   => 2,
			    'type'       => 'select',
				'choices'    => array(
					'boot-col-md-3'   => esc_html__( '4 Column', 'um-theme' ),
					'boot-col-md-4'   => esc_html__( '3 Column', 'um-theme' ),
					'boot-col-md-6'   => esc_html__( '2 Column', 'um-theme' ),
					'boot-col-md-12'  => esc_html__( '1 Column', 'um-theme' ),
				),
			)
		);

	// Footer Widgets Column
	$wp_customize->add_setting( 'customization[um_theme_footer_widget_alignment]' ,
		array(
			'default' 			=> 'center',
			'type' 				=> 'option',
			'transport' 		=> 'refresh',
			'sanitize_callback' => 'esc_attr',
		)
	);

		$wp_customize->add_control( 'um_theme_footer_widget_alignment',
			array(
				'label'      => esc_html__( 'Widget Text Alignment', 'um-theme' ),
				'section'    => 'customizer_section_footer_widget',
				'settings'   => 'customization[um_theme_footer_widget_alignment]',
			    'priority'   => 3,
			    'type'       => 'select',
				'choices'    => array(
					'left'   	=> esc_html__( 'Left', 'um-theme' ),
					'center'   	=> esc_html__( 'Center', 'um-theme' ),
					'right'   	=> esc_html__( 'Right', 'um-theme' ),
				),
			)
		);

	$wp_customize->add_setting( 'um_theme_footer_widget_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_footer_widget_line_break_first',
				array(
					'section' 		=> 'customizer_section_footer_widget',
					'settings'    	=> 'um_theme_footer_widget_line_break_first',
					'priority'   	=> 9,
				)
			) );


	$wp_customize->add_setting( 'customization[um_theme_footer_ui_widget_color]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_footer_ui_widget_color',
				array(
					'type' 		=> 'info',
					'label' 	=> esc_html__( 'Color', 'um-theme' ),
					'section' 	=> 'customizer_section_footer_widget',
					'settings'  => 'customization[um_theme_footer_ui_widget_color]',
					'priority'  => 10,
				)
			) );


	// Footer Widget Background Color
	$wp_customize->add_setting( 'customization[um_theme_footer_widget_bg_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_footer_widget_bg_color',
			array(
				'label'      => esc_html__( 'Footer Widget Background', 'um-theme' ),
				'section'    => 'customizer_section_footer_widget',
				'settings'   => 'customization[um_theme_footer_widget_bg_color]',
			    'priority'   => 11,
			)
		));

	// Footer Widget Color
	$wp_customize->add_setting( 'customization[um_theme_footer_widget_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_footer_widget_color',
			array(
				'label'      => esc_html__( 'Footer Widget Text', 'um-theme' ),
				'section'    => 'customizer_section_footer_widget',
				'settings'   => 'customization[um_theme_footer_widget_color]',
			    'priority'   => 12,
			)
		));

	// Footer Widget Link Color
	$wp_customize->add_setting( 'customization[um_theme_footer_widget_link_color]' ,
		array(
	    'default'	 		=> '#333333',
	    'type' 				=> 'option',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_footer_widget_link_color',
			array(
				'label'      => esc_html__( 'Footer Widget Link', 'um-theme' ),
				'section'    => 'customizer_section_footer_widget',
				'settings'   => 'customization[um_theme_footer_widget_link_color]',
			    'priority'   => 13,
			)
		));

	// Footer Widget Link Hover Color
	$wp_customize->add_setting( 'customization[um_theme_footer_widget_link_hover_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_footer_widget_link_hover_color',
			array(
				'label'      => esc_html__( 'Footer Widget Link Hover', 'um-theme' ),
				'section'    => 'customizer_section_footer_widget',
				'settings'   => 'customization[um_theme_footer_widget_link_hover_color]',
			    'priority'   => 14,
			)
		));

/*--------------------------------------------------------------
## Ultimate Member Sections
--------------------------------------------------------------*/

	// Login Page
	$wp_customize->add_section( 'customizer_section_um_login_page_section',
		array(
			'title' 			=> esc_html__( 'Login Page', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 1,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
		)
	);

	// Profile Page
	$wp_customize->add_section( 'customizer_section_um_profile_template',
		array(
			'title' 			=> esc_html__( 'Profile Page', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 1,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
		)
	);

	// Member Directory
	$wp_customize->add_section( 'customizer_section_um_member_directory',
		array(
			'title' 			=> esc_html__( 'Member Directory', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 2,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
		)
	);

	// Ultimate Member Color
	$wp_customize->add_section( 'customizer_section_um_set_plug_color',
		array(
			'title' 			=> esc_html__( 'Ultimate Member Color', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 3,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
		)
	);

	// Ultimate Member Color
	$wp_customize->add_section( 'customizer_section_um_account_section',
		array(
			'title' 			=> esc_html__( 'Account Page', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 4,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
		)
	);

	// Extension: Followers
	$wp_customize->add_section( 'customizer_section_um_ext_followers',
		array(
			'title' 			=> esc_html__( 'Extension: Followers', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
			'active_callback' 	=> 'um_theme_is_active_um_followers',
		)
	);

	// Extension: Friends
	$wp_customize->add_section( 'customizer_section_um_ext_friends',
		array(
			'title' 			=> esc_html__( 'Extension: Friends', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
			'active_callback' 	=> 'um_theme_is_active_um_friends',
		)
	);

	// Extension: Notifications
	$wp_customize->add_section( 'customizer_section_um_ext_notifications',
		array(
			'title' 			=> esc_html__( 'Extension: Notifications', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
			'active_callback' 	=> 'um_theme_is_active_um_notifications',
		)
	);

	// Extension: Private Messages
	$wp_customize->add_section( 'customizer_section_um_ext_private_messages',
		array(
			'title' 			=> esc_html__( 'Extension: Private Messages', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
			'active_callback' 	=> 'um_theme_is_active_um_messaging',
		)
	);

	// Extension: User Reviews
	$wp_customize->add_section( 'customizer_section_um_ext_user_reviews',
		array(
			'title' 			=> esc_html__( 'Extension: User Reviews', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
			'active_callback' 	=> 'um_theme_is_active_um_reviews',
		)
	);

	// Extension: Social Activity
	$wp_customize->add_section( 'customizer_section_um_ext_activity',
		array(
			'title' 			=> esc_html__( 'Extension: Social Activity', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
			'active_callback' 	=> 'um_theme_is_active_um_social_activity',
		)
	);

	// Extension: User Tags
	$wp_customize->add_section( 'customizer_section_um_ext_user_tag',
		array(
			'title' 			=> esc_html__( 'Extension: User Tags', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
			'active_callback' 	=> 'um_theme_is_active_um_ext_user_tags',
		)
	);

	// Extension: UM WooCommerce
	$wp_customize->add_section( 'customizer_section_um_ext_woocommerce',
		array(
			'title' 			=> esc_html__( 'Extension: WooCommerce', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
			'active_callback' 	=> 'um_theme_is_active_um_ext_woocommerce',
		)
	);

	// Extension: Verified Users
	$wp_customize->add_section( 'customizer_section_um_ext_verified_users',
		array(
			'title' 			=> esc_html__( 'Extension: Verified Users', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
			'active_callback' 	=> 'um_theme_is_active_um_ext_verified_users',
		)
	);

	// Extension: Groups
	$wp_customize->add_section( 'customizer_section_um_ext_groups',
		array(
			'title' 			=> esc_html__( 'Extension: Groups', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
			'active_callback' 	=> 'um_theme_is_active_um_ext_groups',
		)
	);

	// Extension: Profile Completeness
	$wp_customize->add_section( 'customizer_section_um_ext_profile_complete',
		array(
			'title' 			=> esc_html__( 'Extension: Profile Completeness', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
			'active_callback' 	=> 'um_theme_is_active_um_ext_profile_complete',
		)
	);

	// Extension: User Bookmarks
	$wp_customize->add_section( 'customizer_section_um_ext_user_bookmarks',
		array(
			'title' 			=> esc_html__( 'Extension: User Bookmarks', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
			'active_callback' 	=> 'um_theme_is_active_um_ext_user_bookmarks',
		)
	);

	// Extension: User Notes
	$wp_customize->add_section( 'customizer_section_um_ext_user_notes',
		array(
			'title' 			=> esc_html__( 'Extension: User Notes', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'customizer_panel_um_plugin_panel',
			'active_callback' 	=> 'um_theme_is_active_um_ext_user_notes',
		)
	);

/*--------------------------------------------------------------
## Ultimate Member - User Notes
--------------------------------------------------------------*/

	// User Notes Color
	$wp_customize->add_setting( 'customization[um_theme_user_notes_color]',
		array(
		    'default' 			=> '#BBDEFB',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_user_notes_color',
			array(
				'label'      => esc_html__( 'User Notes', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_notes',
				'settings'   => 'customization[um_theme_user_notes_color]',
			    'priority'   => 1,
			)
		));

	// User Notes Text Color
	$wp_customize->add_setting( 'customization[um_theme_user_notes_text_color]',
		array(
		    'default' 			=> '#0D47A1',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_user_notes_text_color',
			array(
				'label'      => esc_html__( 'User Notes Text', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_notes',
				'settings'   => 'customization[um_theme_user_notes_text_color]',
			    'priority'   => 1,
			)
		));

	// User Notes Button Color
	$wp_customize->add_setting( 'customization[um_theme_user_notes_border_color]',
		array(
		    'default' 			=> '#cccccc',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_user_notes_border_color',
			array(
				'label'      => esc_html__( 'User Notes Border', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_notes',
				'settings'   => 'customization[um_theme_user_notes_border_color]',
			    'priority'   => 3,
			)
		));

/*--------------------------------------------------------------
## Ultimate Member - User Bookmarks
--------------------------------------------------------------*/

	// User Bookmarks Button Color
	$wp_customize->add_setting( 'customization[um_theme_user_bookmarks_button_color]',
		array(
		    'default' 			=> '#ECEFF1',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_user_bookmarks_button_color',
			array(
				'label'      => esc_html__( 'Add Bookmark Button', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_bookmarks',
				'settings'   => 'customization[um_theme_user_bookmarks_button_color]',
			    'priority'   => 1,
			)
		));

	// User Bookmarks Button Text Color
	$wp_customize->add_setting( 'customization[um_theme_user_bookmarks_button_text_color]',
		array(
		    'default' 			=> '#607D8B',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_user_bookmarks_button_text_color',
			array(
				'label'      => esc_html__( 'Add Bookmark Button Text', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_bookmarks',
				'settings'   => 'customization[um_theme_user_bookmarks_button_text_color]',
			    'priority'   => 2,
			)
		));


	// User Bookmarks Button Color
	$wp_customize->add_setting( 'customization[um_theme_user_bookmarks_remove_button_color]',
		array(
		    'default' 			=> '#FCE4EC',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_user_bookmarks_remove_button_color',
			array(
				'label'      => esc_html__( 'Remove Bookmark Button', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_bookmarks',
				'settings'   => 'customization[um_theme_user_bookmarks_remove_button_color]',
			    'priority'   => 9,
			)
		));

	// User Bookmarks Button Text Color
	$wp_customize->add_setting( 'customization[um_theme_user_bookmarks_remove_button_text_color]',
		array(
		    'default' 			=> '#F48FB1',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_user_bookmarks_remove_button_text_color',
			array(
				'label'      => esc_html__( 'Remove Bookmark Button Text', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_bookmarks',
				'settings'   => 'customization[um_theme_user_bookmarks_remove_button_text_color]',
			    'priority'   => 10,
			)
		));


	// Show Bookmark Excerpt
	$wp_customize->add_setting( 'customization[um_theme_user_bookmarks_list_excerpt_show]',
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'transport' 			=> 'refresh',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
		)
	);

		$wp_customize->add_control( 'um_theme_user_bookmarks_list_excerpt_show',
			array(
				'label'      => esc_html__( 'Show Bookmark Excerpt', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_bookmarks',
				'settings'   => 'customization[um_theme_user_bookmarks_list_excerpt_show]',
			    'priority'   => 12,
			    'type'       => 'select',
				'choices'    => array(
									1   => esc_html__( 'Enable', 'um-theme' ),
									2   => esc_html__( 'Disable', 'um-theme' ),
								),
			)
		);


	// Modal Background Color
	$wp_customize->add_setting( 'customization[um_theme_user_bookmarks_modal_bg]',
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_user_bookmarks_modal_bg',
			array(
				'label'      => esc_html__( 'Modal Background Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_bookmarks',
				'settings'   => 'customization[um_theme_user_bookmarks_modal_bg]',
			    'priority'   => 20,
			)
		));

	// Modal Text Color
	$wp_customize->add_setting( 'customization[um_theme_user_bookmarks_modal_text]',
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_user_bookmarks_modal_text',
			array(
				'label'      => esc_html__( 'Modal Text Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_bookmarks',
				'settings'   => 'customization[um_theme_user_bookmarks_modal_text]',
			    'priority'   => 21,
			)
		));

/*--------------------------------------------------------------
## Ultimate Member - Login Page
--------------------------------------------------------------*/

	// Login Page Background Image
	$wp_customize->add_setting( 'um_theme_login_page_bg_image',
		array(
			'sanitize_callback' => 'esc_url_raw',
			'transport' 		=> 'refresh',
		)
	);

			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,'um_theme_login_page_bg_image',
				array(
	               'label'      		=> esc_html__( 'Login Page Background Image', 'um-theme' ),
	               'section'    		=> 'customizer_section_um_login_page_section',
	               'settings'   		=> 'um_theme_login_page_bg_image',
	               'priority'   		=> 1,
			   )
			));

	// Login Page Background Color
	$wp_customize->add_setting( 'customization[um_theme_login_page_bg_color]',
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_login_page_bg_color',
			array(
				'label'      => esc_html__( 'Login Page Background Color', 'um-theme' ),
				'section'    => 'customizer_section_um_login_page_section',
				'settings'   => 'customization[um_theme_login_page_bg_color]',
			    'priority'   => 2,
			)
		));

	// Login Page Field Label Color
	$wp_customize->add_setting( 'customization[um_theme_login_page_field_label_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_login_page_field_label_color',
			array(
				'label'      => esc_html__( 'Login Page Field Label Color', 'um-theme' ),
				'section'    => 'customizer_section_um_login_page_section',
				'settings'   => 'customization[um_theme_login_page_field_label_color]',
			    'priority'   => 4,
			)
		));


	$wp_customize->add_setting( 'um_theme_um_login_page_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_um_login_page_line_break_first',
				array(
					'section' 		=> 'customizer_section_um_login_page_section',
					'settings'    	=> 'um_theme_um_login_page_line_break_first',
					'priority'   	=> 9,
				)
			) );

	// Login Button
	$wp_customize->add_setting( 'customization[um_theme_login_page_login_color]' ,
		array(
		    'default' 			=> '#3ba1da',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_login_page_login_color',
			array(
				'label'      => esc_html__( 'Login Button', 'um-theme' ),
				'section'    => 'customizer_section_um_login_page_section',
				'settings'   => 'customization[um_theme_login_page_login_color]',
			    'priority'   => 10,
			)
		));

	// Login Text Button
	$wp_customize->add_setting( 'customization[um_theme_login_page_login_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_login_page_login_text_color',
			array(
				'label'      => esc_html__( 'Login Button Text', 'um-theme' ),
				'section'    => 'customizer_section_um_login_page_section',
				'settings'   => 'customization[um_theme_login_page_login_text_color]',
			    'priority'   => 11,
			)
		));


	// Register Button
	$wp_customize->add_setting( 'customization[um_theme_login_page_register_color]' ,
		array(
		    'default' 			=> '#eeeeee',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_login_page_register_color',
			array(
				'label'      => esc_html__( 'Register Button', 'um-theme' ),
				'section'    => 'customizer_section_um_login_page_section',
				'settings'   => 'customization[um_theme_login_page_register_color]',
			    'priority'   => 12,
			)
		));

	// Register Text Button
	$wp_customize->add_setting( 'customization[um_theme_login_page_register_text_color]' ,
		array(
		    'default' 			=> '#666666',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_login_page_register_text_color',
			array(
				'label'      => esc_html__( 'Register Button Text', 'um-theme' ),
				'section'    => 'customizer_section_um_login_page_section',
				'settings'   => 'customization[um_theme_login_page_register_text_color]',
			    'priority'   => 13,
			)
		));

/*--------------------------------------------------------------
## Ultimate Member - Extension: Profile Completeness
--------------------------------------------------------------*/

	// Empty Bar Color
	$wp_customize->add_setting( 'customization[um_theme_ext_profile_empty_bar_color]' ,
		array(
		    'default' 			=> '#eeeeee',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_profile_empty_bar_color',
			array(
				'label'      => esc_html__( 'Empty Bar Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_profile_complete',
				'settings'   => 'customization[um_theme_ext_profile_empty_bar_color]',
			    'priority'   => 1,
			)
		));

	// Complete Bar Color
	$wp_customize->add_setting( 'customization[um_theme_ext_profile_complete_bar_color]' ,
		array(
		    'default' 			=> '#3BA1DA',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_profile_complete_bar_color',
			array(
				'label'      => esc_html__( 'Complete Bar Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_profile_complete',
				'settings'   => 'customization[um_theme_ext_profile_complete_bar_color]',
			    'priority'   => 2,
			)
		));

/*--------------------------------------------------------------
## Ultimate Member - Extension: Groups
--------------------------------------------------------------*/

	// Groups Directory
	$wp_customize->add_setting( 'customization[um_theme_um_group_directory_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_um_group_directory_title',
				array(
					'type' 				=> 'info',
					'label' 			=> esc_html__( 'Groups Directory', 'um-theme' ),
					'section' 			=> 'customizer_section_um_ext_groups',
					'settings'    		=> 'customization[um_theme_um_group_directory_title]',
					'priority'   		=> 1,
				)
			) );

	// Group List Layout
	$wp_customize->add_setting( 'customization[um_theme_ext_um_group_list_layout]',
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'transport' 			=> 'refresh',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
		)
	);

		$wp_customize->add_control( 'um_theme_ext_um_group_list_layout',
			array(
				'label'      => esc_html__( 'Group List Layout', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_groups',
				'settings'   => 'customization[um_theme_ext_um_group_list_layout]',
			    'priority'   => 2,
			    'type'       => 'select',
				'choices'    => array(
									1   => esc_html__( 'Default', 'um-theme' ),
									2   => esc_html__( 'List', 'um-theme' ),
									3   => esc_html__( 'Grid', 'um-theme' ),
								),
			)
		);

	// Show Group Description
	$wp_customize->add_setting( 'customization[um_theme_ext_um_group_show_group_description]' ,
		array(
			'default' 			=> true,
			'type' 				=> 'option',
			'transport' 		=> 'refresh',
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);

		$wp_customize->add_control( 'um_theme_ext_um_group_show_group_description',
			array(
				'label'      => esc_html__( 'Show Group Description', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_groups',
				'settings'   => 'customization[um_theme_ext_um_group_show_group_description]',
			    'priority'   => 3,
			    'type'       => 'checkbox',
			)
		);

	// UM Groups Line Break
	$wp_customize->add_setting( 'um_theme_um_group_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_um_group_line_break_first',
				array(
					'section' 		=> 'customizer_section_um_ext_groups',
					'settings'    	=> 'um_theme_um_group_line_break_first',
					'priority'   	=> 9,
				)
			) );


	// Groups Style
	$wp_customize->add_setting( 'customization[um_theme_um_group_style_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_um_group_style_title',
				array(
					'type' 				=> 'info',
					'label' 			=> esc_html__( 'Groups Style', 'um-theme' ),
					'section' 			=> 'customizer_section_um_ext_groups',
					'settings'    		=> 'customization[um_theme_um_group_style_title]',
					'priority'   		=> 21,
				)
			) );

	// Group Title Color
	$wp_customize->add_setting( 'customization[um_theme_ext_group_title_color]' ,
		array(
		    'default' 			=> '#666666',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_group_title_color',
			array(
				'label'      => esc_html__( 'Group Title Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_groups',
				'settings'   => 'customization[um_theme_ext_group_title_color]',
			    'priority'   => 22,
			)
		));


	// Group Description Text
	$wp_customize->add_setting( 'customization[um_theme_ext_group_description_color]' ,
		array(
		    'default' 			=> '#8a8a8a',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_group_description_color',
			array(
				'label'      => esc_html__( 'Group Description Text', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_groups',
				'settings'   => 'customization[um_theme_ext_group_description_color]',
			    'priority'   => 23,
			)
		));


	// Group Background Color
	$wp_customize->add_setting( 'customization[um_theme_ext_groups_bg_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_ext_groups_bg_color',
			array(
				'label'      => esc_html__( 'Group Background Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_groups',
				'settings'   => 'customization[um_theme_ext_groups_bg_color]',
			    'priority'   => 24,
			)
		));


	// Group Tab Border Color
	$wp_customize->add_setting( 'customization[um_theme_ext_group_tab_border_color]' ,
		array(
		    'default' 			=> '#f2f2f2',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_ext_group_tab_border_color',
			array(
				'label'      => esc_html__( 'Group Tab Border Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_groups',
				'settings'   => 'customization[um_theme_ext_group_tab_border_color]',
			    'priority'   => 24,
			)
		));

	// Group Search Button Color
	$wp_customize->add_setting( 'customization[um_theme_ext_group_search_button_color]' ,
		array(
		    'default' 			=> '#6596ff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_ext_group_search_button_color',
			array(
				'label'      => esc_html__( 'Search Button Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_groups',
				'settings'   => 'customization[um_theme_ext_group_search_button_color]',
			    'priority'   => 25,
			)
		));

	// Group Search Button Text Color
	$wp_customize->add_setting( 'customization[um_theme_ext_group_search_button_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_ext_group_search_button_text_color',
			array(
				'label'      => esc_html__( 'Search Button Text Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_groups',
				'settings'   => 'customization[um_theme_ext_group_search_button_text_color]',
			    'priority'   => 26,
			)
		));

	// Group Title Font Size
	$wp_customize->add_setting( 'customization[um_theme_ext_group_title_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '16px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_ext_group_title_font_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Title Font Size', 'um-theme' ),
					'section' 		=> 'customizer_section_um_ext_groups',
					'settings' 		=> 'customization[um_theme_ext_group_title_font_size]',
					'priority'   	=> 27,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);

	// Group Description Font Size
	$wp_customize->add_setting( 'customization[um_theme_ext_group_description_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '16px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_ext_group_description_font_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Description Font Size', 'um-theme' ),
					'section' 		=> 'customizer_section_um_ext_groups',
					'settings' 		=> 'customization[um_theme_ext_group_description_font_size]',
					'priority'   	=> 28,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);


	// UM Groups Line Break
	$wp_customize->add_setting( 'um_theme_um_group_line_break_second',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_um_group_line_break_second',
				array(
					'section' 		=> 'customizer_section_um_ext_groups',
					'settings'    	=> 'um_theme_um_group_line_break_second',
					'priority'   	=> 29,
				)
			) );


	// Group Active Filter Background
	$wp_customize->add_setting( 'customization[um_theme_ext_group_filter_active_bg]' ,
		array(
		    'default' 			=> '#f2f2f2',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_ext_group_filter_active_bg',
			array(
				'label'      => esc_html__( 'Group Active Filter', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_groups',
				'settings'   => 'customization[um_theme_ext_group_filter_active_bg]',
			    'priority'   => 30,
			)
		));

	// Group Active Filter Background
	$wp_customize->add_setting( 'customization[um_theme_ext_group_filter_active_text]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_ext_group_filter_active_text',
			array(
				'label'      => esc_html__( 'Group Active Filter Text', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_groups',
				'settings'   => 'customization[um_theme_ext_group_filter_active_text]',
			    'priority'   => 31,
			)
		));


	// Group Filter Background
	$wp_customize->add_setting( 'customization[um_theme_ext_group_filter_bg]' ,
		array(
		    'default' 			=> '#f2f2f2',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_ext_group_filter_bg',
			array(
				'label'      => esc_html__( 'Group Filter', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_groups',
				'settings'   => 'customization[um_theme_ext_group_filter_bg]',
			    'priority'   => 32,
			)
		));

	// Group Filter Background
	$wp_customize->add_setting( 'customization[um_theme_ext_group_filter_text]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_ext_group_filter_text',
			array(
				'label'      => esc_html__( 'Group Filter Text', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_groups',
				'settings'   => 'customization[um_theme_ext_group_filter_text]',
			    'priority'   => 33,
			)
		));

/*--------------------------------------------------------------
## Ultimate Member - Extension: Verified Users
--------------------------------------------------------------*/

	// Tags Background Color
	$wp_customize->add_setting( 'customization[um_theme_ext_tags_bg_color]' ,
		array(
		    'default' 			=> '#eeeeee',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_ext_tags_bg_color',
			array(
				'label'      => esc_html__( 'Tags Background Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_tag',
				'settings'   => 'customization[um_theme_ext_tags_bg_color]',
			    'priority'   => 2,
			)
		));

	// Tags Text Color
	$wp_customize->add_setting( 'customization[um_theme_ext_tags_text_color]' ,
		array(
		    'default' 			=> '#666666',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_ext_tags_text_color',
			array(
				'label'      => esc_html__( 'Tags Text Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_tag',
				'settings'   => 'customization[um_theme_ext_tags_text_color]',
			    'priority'   => 3,
			)
		));

	// Tags Border Color
	$wp_customize->add_setting( 'customization[um_theme_ext_tags_border_color]' ,
		array(
		    'default' 			=> '#eeeeee',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_tags_border_color',
			array(
				'label'      => esc_html__( 'Tags Border Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_tag',
				'settings'   => 'customization[um_theme_ext_tags_border_color]',
			    'priority'   => 4,
			)
		));

	// Tags Background Color
	$wp_customize->add_setting( 'customization[um_theme_ext_tags_hover_bg_color]' ,
		array(
		    'default' 			=> '#eeeeee',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_tags_hover_bg_color',
			array(
				'label'      => esc_html__( 'Tags Hover Background Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_tag',
				'settings'   => 'customization[um_theme_ext_tags_hover_bg_color]',
			    'priority'   => 11,
			)
		));

	// Tags Text Color
	$wp_customize->add_setting( 'customization[um_theme_ext_tags_hover_text_color]' ,
		array(
		    'default' 			=> '#666666',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_tags_hover_text_color',
			array(
				'label'      => esc_html__( 'Tags Hover Text Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_tag',
				'settings'   => 'customization[um_theme_ext_tags_hover_text_color]',
			    'priority'   => 12,
			)
		));

	// Tags Border Color
	$wp_customize->add_setting( 'customization[um_theme_ext_tags_hover_border_color]' ,
		array(
		    'default' 			=> '#eeeeee',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_tags_hover_border_color',
			array(
				'label'      => esc_html__( 'Tags Hover Border Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_tag',
				'settings'   => 'customization[um_theme_ext_tags_hover_border_color]',
			    'priority'   => 13,
			)
		));

	// User Tags Font Size
	$wp_customize->add_setting( 'customization[um_theme_ext_tag_text_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '12px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_ext_tag_text_font_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Font Size', 'um-theme' ),
					'section' 		=> 'customizer_section_um_ext_user_tag',
					'settings' 		=> 'customization[um_theme_ext_tag_text_font_size]',
					'priority'   	=> 16,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);

/*--------------------------------------------------------------
## Ultimate Member - Extension: Verified Users
--------------------------------------------------------------*/

	// Verified Icon Color
	$wp_customize->add_setting( 'customization[um_theme_ext_verified_icon_color]' ,
		array(
		    'default' 			=> '#5ea5e7',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_verified_icon_color',
			array(
				'label'      => esc_html__( 'Verified Icon Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_verified_users',
				'settings'   => 'customization[um_theme_ext_verified_icon_color]',
			    'priority'   => 1,
			)
		));
/*--------------------------------------------------------------
## Ultimate Member - Extension: UM WooCommerce
--------------------------------------------------------------*/

	// Product Box Background
	$wp_customize->add_setting( 'customization[um_theme_ext_woo_product_bg_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_woo_product_bg_color',
			array(
				'label'      => esc_html__( 'Product Box Background', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_woocommerce',
				'settings'   => 'customization[um_theme_ext_woo_product_bg_color]',
			    'priority'   => 1,
			)
		));

	// Product Price
	$wp_customize->add_setting( 'customization[um_theme_ext_woo_product_price_color]' ,
		array(
		    'default' 			=> '#6596ff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_woo_product_price_color',
			array(
				'label'      => esc_html__( 'Product Price', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_woocommerce',
				'settings'   => 'customization[um_theme_ext_woo_product_price_color]',
			    'priority'   => 2,
			)
		));

	// Product Title
	$wp_customize->add_setting( 'customization[um_theme_ext_woo_product_title_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_woo_product_title_color',
			array(
				'label'      => esc_html__( 'Product Title', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_woocommerce',
				'settings'   => 'customization[um_theme_ext_woo_product_title_color]',
			    'priority'   => 4,
			)
		));

	// Product Review
	$wp_customize->add_setting( 'customization[um_theme_ext_woo_product_review_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_woo_product_review_color',
			array(
				'label'      => esc_html__( 'Product Review', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_woocommerce',
				'settings'   => 'customization[um_theme_ext_woo_product_review_color]',
			    'priority'   => 5,
			)
		));
/*--------------------------------------------------------------
## Ultimate Member - Extension: User Reviews
--------------------------------------------------------------*/

	// Star Color
	$wp_customize->add_setting( 'customization[um_theme_ext_reviews_star_color]' ,
		array(
		    'default' 			=> '#E6B800',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_ext_reviews_star_color',
			array(
				'label'      => esc_html__( 'Star Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_reviews',
				'settings'   => 'customization[um_theme_ext_reviews_star_color]',
			    'priority'   => 1,
			)
		));

	// Review Bar Color
	$wp_customize->add_setting( 'customization[um_theme_ext_reviews_bar_color]' ,
		array(
		    'default' 			=> '#3BA1DA',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_reviews_bar_color',
			array(
				'label'      => esc_html__( 'Review Bar Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_reviews',
				'settings'   => 'customization[um_theme_ext_reviews_bar_color]',
			    'priority'   => 2,
			)
		));

	// Empty Bar Color
	$wp_customize->add_setting( 'customization[um_theme_ext_reviews_empty_bar_color]' ,
		array(
		    'default' 			=> '#e5e5e5',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_reviews_empty_bar_color',
			array(
				'label'      => esc_html__( 'Empty Bar Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_reviews',
				'settings'   => 'customization[um_theme_ext_reviews_empty_bar_color]',
			    'priority'   => 3,
			)
		));

	// Review Title Color
	$wp_customize->add_setting( 'customization[um_theme_ext_reviews_single_title_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_reviews_single_title_color',
			array(
				'label'      => esc_html__( 'Review Title Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_reviews',
				'settings'   => 'customization[um_theme_ext_reviews_single_title_color]',
			    'priority'   => 3,
			)
		));

	// Review Section Header
	$wp_customize->add_setting( 'customization[um_theme_ext_reviews_section_title_color]' ,
		array(
		    'default' 			=> '#555555',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_reviews_section_title_color',
			array(
				'label'      => esc_html__( 'Review Section Header Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_user_reviews',
				'settings'   => 'customization[um_theme_ext_reviews_section_title_color]',
			    'priority'   => 3,
			)
		));
/*--------------------------------------------------------------
## Ultimate Member - Extension: Followers
--------------------------------------------------------------*/

	// Followers Meta Color
	$wp_customize->add_setting( 'customization[um_theme_ext_followers_meta_color]' ,
		array(
		    'default' 			=> '#999999',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_followers_meta_color',
			array(
				'label'      => esc_html__( 'Meta Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_followers',
				'settings'   => 'customization[um_theme_ext_followers_meta_color]',
			    'priority'   => 1,
			)
		));

	// Followers Count Color
	$wp_customize->add_setting( 'customization[um_theme_ext_followers_count_color]' ,
		array(
		    'default' 			=> '#3ba1da',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_followers_count_color',
			array(
				'label'      => esc_html__( 'Followers Count Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_followers',
				'settings'   => 'customization[um_theme_ext_followers_count_color]',
			    'priority'   => 2,
			)
		));

/*--------------------------------------------------------------
## Ultimate Member - Extension: Notifications
--------------------------------------------------------------*/

	// Show Floating Notifications
	$wp_customize->add_setting( 'customization[um_show_floating_notification]' ,
		array(
			'default' 				=> 2,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_show_floating_notification',
			array(
				'label'      => esc_html__( 'Show Floating Notifications', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_notifications',
				'settings'   => 'customization[um_show_floating_notification]',
			    'priority'   => 1,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);

	// Notification Icon Color
	$wp_customize->add_setting( 'customization[um_theme_ext_float_notification_icon_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_float_notification_icon_color',
			array(
				'label'      => esc_html__( 'Notification Icon Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_notifications',
				'settings'   => 'customization[um_theme_ext_float_notification_icon_color]',
			    'priority'   => 3,
			)
		));

	// Notification Bell Icon Color
	$wp_customize->add_setting( 'customization[um_theme_ext_float_notification_bell_icon_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_float_notification_bell_icon_color',
			array(
				'label'      => esc_html__( 'Notification Bell Icon Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_notifications',
				'settings'   => 'customization[um_theme_ext_float_notification_bell_icon_color]',
			    'priority'   => 4,
			)
		));

/*--------------------------------------------------------------
## Ultimate Member - Extension: Friends
--------------------------------------------------------------*/

	// Show Friend box in Users Profile
	$wp_customize->add_setting( 'customization[um_show_profile_friend_requests]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_show_profile_friend_requests',
			array(
				'label'      => esc_html__( 'Show Friend box in Users Profile', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_friends',
				'settings'   => 'customization[um_show_profile_friend_requests]',
			    'priority'   => 1,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);


	// Friends Avatar Border Radius
	$wp_customize->add_setting('customization[um_theme_ext_friends_image_radius]', array(
		'type' 				=> 'option',
		'default' 			=> '45px',
		'sanitize_callback' => 'esc_attr',
		'transport' 		=> 'postMessage',
	) );
			$wp_customize->add_control( 'um_theme_ext_friends_image_radius', array(
				'type' 			=> 'text',
				'label' 		=> esc_html__( 'Friends Avatar Border Radius', 'um-theme' ),
				'section' 		=> 'customizer_section_um_ext_friends',
				'settings' 		=> 'customization[um_theme_ext_friends_image_radius]',
				'priority'   	=> 2,
               	'input_attrs' 	=> array(
            		'placeholder' => __( 'example: 16px', 'um-theme' ),
        		),
			) );

	// Add Friend Button Color
	$wp_customize->add_setting( 'customization[um_theme_ext_friend_button_bg_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_friend_button_bg_color',
			array(
				'label'      => esc_html__( 'Add Friend Button Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_friends',
				'settings'   => 'customization[um_theme_ext_friend_button_bg_color]',
			    'priority'   => 3,
			)
		));

	// Add Friend Button Text Color
	$wp_customize->add_setting( 'customization[um_theme_ext_friend_button_text_color]',
		array(
		    'default' 			=> '#666666',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_friend_button_text_color',
			array(
				'label'      => esc_html__( 'Add Friend Button Text Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_friends',
				'settings'   => 'customization[um_theme_ext_friend_button_text_color]',
			    'priority'   => 4,
			)
		));

	// Add Friend Button Color
	$wp_customize->add_setting( 'customization[um_theme_ext_friend_button_hover_bg_color]' ,
		array(
		    'default' 			=> '#6596ff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_friend_button_hover_bg_color',
			array(
				'label'      => esc_html__( 'Add Friend Button Hover Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_friends',
				'settings'   => 'customization[um_theme_ext_friend_button_hover_bg_color]',
			    'priority'   => 5,
			)
		));

	// Add Friend Button Text Color
	$wp_customize->add_setting( 'customization[um_theme_ext_friend_button_hover_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_friend_button_hover_text_color',
			array(
				'label'      => esc_html__( 'Add Friend Button Hover Text Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_friends',
				'settings'   => 'customization[um_theme_ext_friend_button_hover_text_color]',
			    'priority'   => 6,
			)
		));

/*--------------------------------------------------------------
## Ultimate Member - Extension: Social Activity
--------------------------------------------------------------*/

	// Avatar Border Radius
	$wp_customize->add_setting('customization[um_theme_ext_activity_image_radius]',
		array(
			'type' 				=> 'option',
			'default' 			=> '45px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'postMessage',
		)
	);
			$wp_customize->add_control('um_theme_ext_activity_image_radius',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Avatar Border Radius', 'um-theme' ),
					'section' 		=> 'customizer_section_um_ext_activity',
					'settings' 		=> 'customization[um_theme_ext_activity_image_radius]',
					'priority'   	=> 4,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);

	// Activity Head Color
	$wp_customize->add_setting( 'customization[um_theme_ext_acitivity_head_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_acitivity_head_color',
			array(
				'label'      => esc_html__( 'Activity Head Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_activity',
				'settings'   => 'customization[um_theme_ext_acitivity_head_color]',
			    'priority'   => 1,
			)
		));

	// Activity Meta Color
	$wp_customize->add_setting( 'customization[um_theme_ext_acitivity_meta_color]' ,
		array(
		    'default' 			=> '#aaaaaa',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_acitivity_meta_color',
			array(
				'label'      => esc_html__( 'Activity Meta Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_activity',
				'settings'   => 'customization[um_theme_ext_acitivity_meta_color]',
			    'priority'   => 2,
			)
		));

	// Activity Meta Color
	$wp_customize->add_setting( 'customization[um_theme_ext_acitivity_border_color]' ,
		array(
		    'default' 			=> '#e5e5e5',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_acitivity_border_color',
			array(
				'label'      => esc_html__( 'Activity Border Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_activity',
				'settings'   => 'customization[um_theme_ext_acitivity_border_color]',
			    'priority'   => 3,
			)
		));

	// Activity Text Color
	$wp_customize->add_setting( 'customization[um_theme_ext_acitivity_text_color]' ,
		array(
		    'default' 			=> '#666666',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_acitivity_text_color',
			array(
				'label'      => esc_html__( 'Activity Text Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_activity',
				'settings'   => 'customization[um_theme_ext_acitivity_text_color]',
			    'priority'   => 1,
			)
		));

	// Activity Text Font Size
	$wp_customize->add_setting('customization[um_theme_ext_acitivity_text_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '16px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control('um_theme_ext_acitivity_text_font_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Text Font Size', 'um-theme' ),
					'section' 		=> 'customizer_section_um_ext_activity',
					'settings' 		=> 'customization[um_theme_ext_acitivity_text_font_size]',
					'priority'   	=> 2,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);
/*--------------------------------------------------------------
## Ultimate Member - Extension: Private Messages
--------------------------------------------------------------*/

	// Conversation Color
	$wp_customize->add_setting( 'customization[um_theme_um_pm_conversation_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_um_pm_conversation_title',
				array(
					'type' 				=> 'info',
					'label' 			=> esc_html__( 'Conversation Color', 'um-theme' ),
					'section' 			=> 'customizer_section_um_ext_private_messages',
					'settings'    		=> 'customization[um_theme_um_pm_conversation_title]',
					'priority'   		=> 1,
				)
			) );

	// Message Background Color
	$wp_customize->add_setting( 'customization[um_theme_ext_pm_message_your_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_pm_message_your_text_color',
			array(
				'label'      => esc_html__( 'Your Message Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_private_messages',
				'settings'   => 'customization[um_theme_ext_pm_message_your_text_color]',
			    'priority'   => 2,
			)
		));

	// Message Background Color
	$wp_customize->add_setting( 'customization[um_theme_ext_pm_your_message_bg_color]' ,
		array(
		    'default' 			=> '#0084ff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_pm_your_message_bg_color',
			array(
				'label'      => esc_html__( 'Your Message Background', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_private_messages',
				'settings'   => 'customization[um_theme_ext_pm_your_message_bg_color]',
			    'priority'   => 3,
			)
		));

	// Message Background Color
	$wp_customize->add_setting( 'customization[um_theme_ext_pm_message_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_pm_message_text_color',
			array(
				'label'      => esc_html__( 'Other Persons Message Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_private_messages',
				'settings'   => 'customization[um_theme_ext_pm_message_text_color]',
			    'priority'   => 4,
			)
		));

	// Message Background Color
	$wp_customize->add_setting( 'customization[um_theme_ext_pm_message_bg_color]' ,
		array(
		    'default' 			=> '#0084ff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_pm_message_bg_color',
			array(
				'label'      => esc_html__( 'Other Persons Message Background', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_private_messages',
				'settings'   => 'customization[um_theme_ext_pm_message_bg_color]',
			    'priority'   => 5,
			)
		));

	// Download Chat History
	$wp_customize->add_setting( 'customization[um_theme_ext_pm_message_hide_chat_history]',
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'transport' 			=> 'refresh',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
		)
	);

		$wp_customize->add_control( 'um_theme_ext_pm_message_hide_chat_history',
			array(
				'label'      => esc_html__( 'Download Chat History', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_private_messages',
				'settings'   => 'customization[um_theme_ext_pm_message_hide_chat_history]',
			    'priority'   => 6,
			    'type'       => 'select',
				'choices'    => array(
									1   => esc_html__( 'Show', 'um-theme' ),
									2   => esc_html__( 'Hide', 'um-theme' ),
								),
			)
		);

	$wp_customize->add_setting( 'um_theme_um_plug_pm_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_um_plug_pm_line_break_first',
				array(
					'section' 		=> 'customizer_section_um_ext_private_messages',
					'settings'    	=> 'um_theme_um_plug_pm_line_break_first',
					'priority'   	=> 9,
				)
			) );

	// Conversation Color
	$wp_customize->add_setting( 'customization[um_theme_um_pm_button_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_um_pm_button_title',
				array(
					'type' 				=> 'info',
					'label' 			=> esc_html__( 'Button Color', 'um-theme' ),
					'section' 			=> 'customizer_section_um_ext_private_messages',
					'settings'    		=> 'customization[um_theme_um_pm_button_title]',
					'priority'   		=> 10,
				)
			) );

	// Message Button Text Color
	$wp_customize->add_setting( 'customization[um_theme_ext_pm_message_button_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_pm_message_button_text_color',
			array(
				'label'      => esc_html__( 'Message Button Text Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_private_messages',
				'settings'   => 'customization[um_theme_ext_pm_message_button_text_color]',
			    'priority'   => 11,
			)
		));

	// Message Button Color
	$wp_customize->add_setting( 'customization[um_theme_ext_pm_message_button_color]' ,
		array(
		    'default' 			=> '#0084ff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_pm_message_button_color',
			array(
				'label'      => esc_html__( 'Message Button Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_private_messages',
				'settings'   => 'customization[um_theme_ext_pm_message_button_color]',
			    'priority'   => 12,
			)
		));

	$wp_customize->add_setting( 'um_theme_um_plug_pm_line_break_second',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_um_plug_pm_line_break_second',
				array(
					'section' 		=> 'customizer_section_um_ext_private_messages',
					'settings'    	=> 'um_theme_um_plug_pm_line_break_second',
					'priority'   	=> 19,
				)
			) );

	// Message Icon Color
	$wp_customize->add_setting( 'customization[um_theme_ext_pm_message_icon_color]' ,
		array(
		    'default' 			=> '#999999',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_ext_pm_message_icon_color',
			array(
				'label'      => esc_html__( 'Message Icon Color', 'um-theme' ),
				'section'    => 'customizer_section_um_ext_private_messages',
				'settings'   => 'customization[um_theme_ext_pm_message_icon_color]',
			    'priority'   => 21,
			)
		));

/*--------------------------------------------------------------
## Ultimate Member - Account Page
--------------------------------------------------------------*/

	// Account Tab Position
	$wp_customize->add_setting( 'customization[um_theme_um_account_tab_position]',
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'transport' 			=> 'refresh',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
		)
	);

		$wp_customize->add_control( 'um_theme_um_account_tab_position',
			array(
				'label'      => esc_html__( 'Account Tab Position', 'um-theme' ),
				'section'    => 'customizer_section_um_account_section',
				'settings'   => 'customization[um_theme_um_account_tab_position]',
			    'priority'   => 1,
			    'type'       => 'select',
				'choices'    => array(
									1   => esc_html__( 'Left (default)', 'um-theme' ),
									2   => esc_html__( 'Top', 'um-theme' ),
								),
			)
		);

	// Ultimate Member Tab Color
	$wp_customize->add_setting( 'customization[um_theme_um_account_tab_color]' ,
		array(
		    'default' 			=> '#eeeeee',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_um_account_tab_color',
			array(
				'label'      => esc_html__( 'Tab Color', 'um-theme' ),
				'section'    => 'customizer_section_um_account_section',
				'settings'   => 'customization[um_theme_um_account_tab_color]',
			    'priority'   => 1,
			)
		));

	// Ultimate Member Tab Color
	$wp_customize->add_setting( 'customization[um_theme_um_account_tab_text_color]' ,
		array(
		    'default' 			=> '#999999',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_um_account_tab_text_color',
			array(
				'label'      => esc_html__( 'Tab Text Color', 'um-theme' ),
				'section'    => 'customizer_section_um_account_section',
				'settings'   => 'customization[um_theme_um_account_tab_text_color]',
			    'priority'   => 2,
			)
		));

	// Ultimate Member Tab Color
	$wp_customize->add_setting( 'customization[um_theme_um_account_tab_icon_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_um_account_tab_icon_color',
			array(
				'label'      => esc_html__( 'Tab Icon Color', 'um-theme' ),
				'section'    => 'customizer_section_um_account_section',
				'settings'   => 'customization[um_theme_um_account_tab_icon_color]',
			    'priority'   => 2,
			)
		));

	// Ultimate Member Tab Hover Color
	$wp_customize->add_setting( 'customization[um_theme_um_account_tab_hover_color]' ,
		array(
		    'default' 			=> '#dddddd',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_um_account_tab_hover_color',
			array(
				'label'      => esc_html__( 'Tab Hover Color', 'um-theme' ),
				'section'    => 'customizer_section_um_account_section',
				'settings'   => 'customization[um_theme_um_account_tab_hover_color]',
			    'priority'   => 9,
			)
		));

	// Ultimate Member Tab Text Hover Color
	$wp_customize->add_setting( 'customization[um_theme_um_account_tab_text_hover_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_um_account_tab_text_hover_color',
			array(
				'label'      => esc_html__( 'Tab Text Hover Color', 'um-theme' ),
				'section'    => 'customizer_section_um_account_section',
				'settings'   => 'customization[um_theme_um_account_tab_text_hover_color]',
			    'priority'   => 10,
			)
		));

/*--------------------------------------------------------------
## Ultimate Member Color
--------------------------------------------------------------*/
	// Ultimate Member Accent Color
	$wp_customize->add_setting( 'customization[um_theme_um_plug_accent_color]' ,
		array(
		    'default' 			=> '#3ba1da',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_um_plug_accent_color',
			array(
				'label'      => esc_html__( 'Accent Color', 'um-theme' ),
				'section'    => 'customizer_section_um_set_plug_color',
				'settings'   => 'customization[um_theme_um_plug_accent_color]',
			    'priority'   => 1,
			)
		));

	// UM Meta Color
	$wp_customize->add_setting( 'customization[um_theme_um_plug_meta_color]' ,
		array(
		    'default' 			=> '#aaaaaa',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_um_plug_meta_color',
			array(
				'label'      => esc_html__( 'UM Meta Color', 'um-theme' ),
				'section'    => 'customizer_section_um_set_plug_color',
				'settings'   => 'customization[um_theme_um_plug_meta_color]',
			    'priority'   => 2,
			)
		));

	$wp_customize->add_setting( 'um_theme_um_plug_color_line_break_fourth',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_um_plug_color_line_break_fourth',
				array(
					'section' 		=> 'customizer_section_um_set_plug_color',
					'settings'    	=> 'um_theme_um_plug_color_line_break_fourth',
					'priority'   	=> 39,
				)
			) );

	// UM Plugin Buutons
	$wp_customize->add_setting( 'customization[um_theme_um_plug_button_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_um_plug_button_title',
				array(
					'type' 				=> 'info',
					'label' 			=> esc_html__( 'Buttons', 'um-theme' ),
					'section' 			=> 'customizer_section_um_set_plug_color',
					'settings'    		=> 'customization[um_theme_um_plug_button_title]',
					'priority'   		=> 40,
				)
			) );

	// UM Button Color
	$wp_customize->add_setting( 'customization[um_theme_um_plug_button_bg_color]' ,
		array(
		    'default' 			=> '#3ba1da',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_um_plug_button_bg_color',
			array(
				'label'      => esc_html__( 'UM Button', 'um-theme' ),
				'section'    => 'customizer_section_um_set_plug_color',
				'settings'   => 'customization[um_theme_um_plug_button_bg_color]',
			    'priority'   => 41,
			)
		));

	// UM Button Color
	$wp_customize->add_setting( 'customization[um_theme_um_plug_button_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_um_plug_button_text_color',
			array(
				'label'      => esc_html__( 'UM Button Text', 'um-theme' ),
				'section'    => 'customizer_section_um_set_plug_color',
				'settings'   => 'customization[um_theme_um_plug_button_text_color]',
			    'priority'   => 42,
			)
		));

	// UM Button Color
	$wp_customize->add_setting( 'customization[um_theme_um_plug_button_hover_bg_color]' ,
		array(
		    'default' 			=> '#3ba1da',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_um_plug_button_hover_bg_color',
			array(
				'label'      => esc_html__( 'UM Button Hover', 'um-theme' ),
				'section'    => 'customizer_section_um_set_plug_color',
				'settings'   => 'customization[um_theme_um_plug_button_hover_bg_color]',
			    'priority'   => 43,
			)
		));

	// UM Button Color
	$wp_customize->add_setting( 'customization[um_theme_um_plug_button_hover_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_um_plug_button_hover_text_color',
			array(
				'label'      => esc_html__( 'UM Button Hover Text', 'um-theme' ),
				'section'    => 'customizer_section_um_set_plug_color',
				'settings'   => 'customization[um_theme_um_plug_button_hover_text_color]',
			    'priority'   => 44,
			)
		));

	// UM Button Text Color (Alt)
	$wp_customize->add_setting( 'customization[um_theme_um_plug_alt_button_text_color]' ,
		array(
		    'default' 			=> '#666666',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_um_plug_alt_button_text_color',
			array(
				'label'      => esc_html__( 'UM Button Text (Alt)', 'um-theme' ),
				'section'    => 'customizer_section_um_set_plug_color',
				'settings'   => 'customization[um_theme_um_plug_alt_button_text_color]',
			    'priority'   => 45,
			)
		));

	// Alt Button Color
	$wp_customize->add_setting( 'customization[um_theme_um_plug_alt_button_color]' ,
		array(
		    'default' 			=> '#eeeeee',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_um_plug_alt_button_color',
			array(
				'label'      => esc_html__( 'UM Button (Alt)', 'um-theme' ),
				'section'    => 'customizer_section_um_set_plug_color',
				'settings'   => 'customization[um_theme_um_plug_alt_button_color]',
			    'priority'   => 46,
			)
		));

	// Alt Button Hover Color
	$wp_customize->add_setting( 'customization[um_theme_um_plug_alt_button_hover_color]' ,
		array(
		    'default' 			=> '#e5e5e5',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_um_plug_alt_button_hover_color',
			array(
				'label'      => esc_html__( 'UM Button Hover (Alt)', 'um-theme' ),
				'section'    => 'customizer_section_um_set_plug_color',
				'settings'   => 'customization[um_theme_um_plug_alt_button_hover_color]',
			    'priority'   => 47,
			)
		));

	// Alt Button Hover Color
	$wp_customize->add_setting( 'customization[um_theme_um_plug_alt_button_hover_text_color]' ,
		array(
		    'default' 			=> '#666666',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_um_plug_alt_button_hover_text_color',
			array(
				'label'      => esc_html__( 'UM Button Hover Text (Alt)', 'um-theme' ),
				'section'    => 'customizer_section_um_set_plug_color',
				'settings'   => 'customization[um_theme_um_plug_alt_button_hover_text_color]',
			    'priority'   => 48,
			)
		));

/*--------------------------------------------------------------
## Ultimate Member - Member Directory
--------------------------------------------------------------*/

	// Box Background Color
	$wp_customize->add_setting( 'customization[um_theme_member_directory_box_bg_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_member_directory_box_bg_color',
			array(
				'label'      => esc_html__( 'Box Background Color', 'um-theme' ),
				'section'    => 'customizer_section_um_member_directory',
				'settings'   => 'customization[um_theme_member_directory_box_bg_color]',
			    'priority'   => 2,
			)
		));

	// Box Text Color
	$wp_customize->add_setting( 'customization[um_theme_member_directory_box_text_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_member_directory_box_text_color',
			array(
				'label'      => esc_html__( 'Box Text Color', 'um-theme' ),
				'section'    => 'customizer_section_um_member_directory',
				'settings'   => 'customization[um_theme_member_directory_box_text_color]',
			    'priority'   => 2,
			)
		));

	// Member Title Font Size
	$wp_customize->add_setting( 'customization[um_theme_member_directory_title_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '16px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_member_directory_title_font_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Name Font Size', 'um-theme' ),
					'section' 		=> 'customizer_section_um_member_directory',
					'settings' 		=> 'customization[um_theme_member_directory_title_font_size]',
					'priority'   	=> 3,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);


	$wp_customize->add_setting( 'um_theme_member_dir_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_member_dir_line_break_first',
				array(
					'section' 	=> 'customizer_section_um_member_directory',
					'settings'  => 'um_theme_member_dir_line_break_first',
					'priority'  => 9,
			)) );

	// Selected Filter Text Color
	$wp_customize->add_setting( 'customization[um_theme_member_dir_selec_filter_text_color]' ,
		array(
		    'default' 			=> '#666666',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_member_dir_selec_filter_text_color',
			array(
				'label'      => esc_html__( 'Selected Filter Text Color', 'um-theme' ),
				'section'    => 'customizer_section_um_member_directory',
				'settings'   => 'customization[um_theme_member_dir_selec_filter_text_color]',
			    'priority'   => 11,
			)
		));

	// Selected Filter Background Color
	$wp_customize->add_setting( 'customization[um_theme_member_dir_selec_filter_bg_color]' ,
		array(
		    'default' 			=> '#f1f1f1',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_member_dir_selec_filter_bg_color',
			array(
				'label'      => esc_html__( 'Selected Filter Background Color', 'um-theme' ),
				'section'    => 'customizer_section_um_member_directory',
				'settings'   => 'customization[um_theme_member_dir_selec_filter_bg_color]',
			    'priority'   => 12,
			)
		));

/*--------------------------------------------------------------
## Ultimate Member - Profile Template
--------------------------------------------------------------*/

	// Show Hide Post Sections
	$wp_customize->add_setting( 'customization[um_theme_profile_template_ui_profile_area]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_profile_template_ui_profile_area',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Profile Header', 'um-theme' ),
					'section' 		=> 'customizer_section_um_profile_template',
					'settings'    	=> 'customization[um_theme_profile_template_ui_profile_area]',
					'priority'   	=> 1,
				)
			) );

	// Profile Area Color
	$wp_customize->add_setting( 'customization[um_theme_template_profile_content_area_text_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_template_profile_content_area_text_color',
			array(
				'label'      => esc_html__( 'Profile Header Area Text Color', 'um-theme' ),
				'section'    => 'customizer_section_um_profile_template',
				'settings'   => 'customization[um_theme_template_profile_content_area_text_color]',
			    'priority'   => 2,
			)
		));

	// Profile Area Background Color
	$wp_customize->add_setting( 'customization[um_theme_template_profile_content_area_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_template_profile_content_area_color',
			array(
				'label'      => esc_html__( 'Profile Header Area Background Color', 'um-theme' ),
				'section'    => 'customizer_section_um_profile_template',
				'settings'   => 'customization[um_theme_template_profile_content_area_color]',
			    'priority'   => 3,
			)
		));

	// Profile Navigation Bar Color
	$wp_customize->add_setting( 'customization[um_theme_template_profile_nav_bar_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_template_profile_nav_bar_color',
			array(
				'label'      => esc_html__( 'Profile Navigation Bar Color', 'um-theme' ),
				'section'    => 'customizer_section_um_profile_template',
				'settings'   => 'customization[um_theme_template_profile_nav_bar_color]',
			    'priority'   => 4,
			)
		));

	// Profile Navigation Menu Color
	$wp_customize->add_setting( 'customization[um_theme_template_profile_nav_menu_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_template_profile_nav_menu_color',
			array(
				'label'      => esc_html__( 'Profile Navigation Menu Color', 'um-theme' ),
				'section'    => 'customizer_section_um_profile_template',
				'settings'   => 'customization[um_theme_template_profile_nav_menu_color]',
			    'priority'   => 5,
			)
		));

	// Profile Navigation Menu Hover Color
	$wp_customize->add_setting( 'customization[um_theme_template_profile_nav_menu_hover_color]' ,
		array(
		    'default' 				=> '#ffffff',
		    'type' 					=> 'option',
		    'sanitize_callback' 	=> 'sanitize_hex_color',
		    'transport' 			=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_template_profile_nav_menu_hover_color',
			array(
				'label'      => esc_html__( 'Profile Navigation Menu Hover Color', 'um-theme' ),
				'section'    => 'customizer_section_um_profile_template',
				'settings'   => 'customization[um_theme_template_profile_nav_menu_hover_color]',
			    'priority'   => 6,
			)
		));

	// Profile Navigation Menu Background Hover Color
	$wp_customize->add_setting( 'customization[um_theme_template_profile_nav_menu_bg_hover_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_template_profile_nav_menu_bg_hover_color',
			array(
				'label'      => esc_html__( 'Menu Background Hover Color', 'um-theme' ),
				'section'    => 'customizer_section_um_profile_template',
				'settings'   => 'customization[um_theme_template_profile_nav_menu_bg_hover_color]',
			    'priority'   => 7,
			)
		));

	$wp_customize->add_setting( 'um_theme_template_profile_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_template_profile_line_break_first',
				array(
					'section' 	=> 'customizer_section_um_profile_template',
					'settings'  => 'um_theme_template_profile_line_break_first',
					'priority'  => 8,
				)
			) );

	// Profile Content
	$wp_customize->add_setting( 'customization[um_theme_profile_template_ui_profile_content]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_profile_template_ui_profile_content',
				array(
					'type' 		=> 'info',
					'label' 	=> esc_html__( 'Profile Content', 'um-theme' ),
					'section' 	=> 'customizer_section_um_profile_template',
					'settings'  => 'customization[um_theme_profile_template_ui_profile_content]',
					'priority'  => 20,
				)
			) );

	// Profile Single Container Color
	$wp_customize->add_setting( 'customization[um_theme_profile_single_text_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_profile_single_text_color',
			array(
				'label'      => esc_html__( 'Profile Content Text Color', 'um-theme' ),
				'section'    => 'customizer_section_um_profile_template',
				'settings'   => 'customization[um_theme_profile_single_text_color]',
			    'priority'   => 21,
			)
		));

	// Profile Single Container Color
	$wp_customize->add_setting( 'customization[um_theme_profile_meta_color]' ,
		array(
		    'default' 			=> '#999999',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_profile_meta_color',
			array(
				'label'      => esc_html__( 'Profile Meta', 'um-theme' ),
				'section'    => 'customizer_section_um_profile_template',
				'settings'   => 'customization[um_theme_profile_meta_color]',
			    'priority'   => 21,
			)
		));

	// Profile Single Container Color
	$wp_customize->add_setting( 'customization[um_theme_template_profile_single_container_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_template_profile_single_container_color',
			array(
				'label'      => esc_html__( 'Profile Content Background Color', 'um-theme' ),
				'section'    => 'customizer_section_um_profile_template',
				'settings'   => 'customization[um_theme_template_profile_single_container_color]',
			    'priority'   => 22,
			)
		));

	// Profile Field Label Border
	$wp_customize->add_setting( 'customization[um_theme_profile_field_label_txt_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_profile_field_label_txt_color',
			array(
				'label'      => esc_html__( 'Field Label Text', 'um-theme' ),
				'section'    => 'customizer_section_um_profile_template',
				'settings'   => 'customization[um_theme_profile_field_label_txt_color]',
			    'priority'   => 23,
			)
		));


	// Profile Field Label Border
	$wp_customize->add_setting( 'customization[um_theme_template_profile_field_label_color]' ,
		array(
		    'default' 			=> '#eeeeee',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_template_profile_field_label_color',
			array(
				'label'      => esc_html__( 'Field Label Border', 'um-theme' ),
				'section'    => 'customizer_section_um_profile_template',
				'settings'   => 'customization[um_theme_template_profile_field_label_color]',
			    'priority'   => 24,
			)
		));

	$wp_customize->add_setting( 'um_theme_template_profile_line_break_second',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_template_profile_line_break_second',
				array(
					'section' 		=> 'customizer_section_um_profile_template',
					'settings'   	=> 'um_theme_template_profile_line_break_second',
					'priority'   	=> 29,
				)
			) );

	// Profile Content
	$wp_customize->add_setting( 'customization[um_theme_profile_template_ui_profile_sidebar]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_profile_template_ui_profile_sidebar',
				array(
					'type' 		=> 'info',
					'label' 	=> esc_html__( 'Profile Sidebar', 'um-theme' ),
					'section' 	=> 'customizer_section_um_profile_template',
					'settings'  => 'customization[um_theme_profile_template_ui_profile_sidebar]',
					'priority'  => 30,
				)
			) );

	// Profile Sidebar Container Color
	$wp_customize->add_setting( 'customization[um_theme_template_profile_sidebar_container_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_template_profile_sidebar_container_color',
			array(
				'label'      => esc_html__( 'Profile Sidebar Container Color', 'um-theme' ),
				'section'    => 'customizer_section_um_profile_template',
				'settings'   => 'customization[um_theme_template_profile_sidebar_container_color]',
			    'priority'   => 32,
			)
		));

/*--------------------------------------------------------------
## Form Fields
--------------------------------------------------------------*/

	// Form Border Color
	$wp_customize->add_setting( 'customization[um_theme_form_field_border_color]' ,
		array(
		    'default' 			=> '#e2e2e2',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_form_field_border_color',
			array(
				'label'      => esc_html__( 'Form Border', 'um-theme' ),
				'section'    => 'customizer_style_form_fields',
				'settings'   => 'customization[um_theme_form_field_border_color]',
			    'priority'   => 1,
			)
		));

	// Form Text Color
	$wp_customize->add_setting( 'customization[um_theme_form_field_text_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_form_field_text_color',
			array(
				'label'      => esc_html__( 'Form Text', 'um-theme' ),
				'section'    => 'customizer_style_form_fields',
				'settings'   => 'customization[um_theme_form_field_text_color]',
			    'priority'   => 2,
			)
		));

	// Form Field Background Color
	$wp_customize->add_setting( 'customization[um_theme_form_field_background_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_form_field_background_color',
			array(
				'label'      => esc_html__( 'Form Field Background', 'um-theme' ),
				'section'    => 'customizer_style_form_fields',
				'settings'   => 'customization[um_theme_form_field_background_color]',
			    'priority'   => 3,
			)
		));

	// Form Border Focus Color
	$wp_customize->add_setting( 'customization[um_theme_form_field_border_focus_color]' ,
		array(
		    'default' 			=> '#cccccc',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_form_field_border_focus_color',
			array(
				'label'      => esc_html__( 'Form Border Focus', 'um-theme' ),
				'section'    => 'customizer_style_form_fields',
				'settings'   => 'customization[um_theme_form_field_border_focus_color]',
			    'priority'   => 4,
			)
		));

	// Form Error Text Color
	$wp_customize->add_setting( 'customization[um_theme_form_field_error_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_form_field_error_text_color',
			array(
				'label'      => esc_html__( 'Form Error Text', 'um-theme' ),
				'section'    => 'customizer_style_form_fields',
				'settings'   => 'customization[um_theme_form_field_error_text_color]',
			    'priority'   => 5,
			)
		));

	// Form Error Background Color
	$wp_customize->add_setting( 'customization[um_theme_form_field_error_bg_color]' ,
		array(
		    'default' 			=> '#ed5565',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_form_field_error_bg_color',
			array(
				'label'      => esc_html__( 'Form Error Background', 'um-theme' ),
				'section'    => 'customizer_style_form_fields',
				'settings'   => 'customization[um_theme_form_field_error_bg_color]',
			    'priority'   => 5,
			)
		));

	// Form Field Label Color
	$wp_customize->add_setting( 'customization[um_theme_form_field_label_text_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_form_field_label_text_color',
			array(
				'label'      => esc_html__( 'Form Field Label', 'um-theme' ),
				'section'    => 'customizer_style_form_fields',
				'settings'   => 'customization[um_theme_form_field_label_text_color]',
			    'priority'   => 6,
			)
		));

	// Form Placeholder Text Color
	$wp_customize->add_setting( 'customization[um_theme_form_field_placeholder_text_color]',
		array(
		    'default' 			=> '#aaaaaa',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_form_field_placeholder_text_color',
			array(
				'label'      => esc_html__( 'Form Placeholder Text', 'um-theme' ),
				'section'    => 'customizer_style_form_fields',
				'settings'   => 'customization[um_theme_form_field_placeholder_text_color]',
			    'priority'   => 7,
			)
		));

/*--------------------------------------------------------------
## Code
--------------------------------------------------------------*/
	// JavaScript Code
	$wp_customize->add_section( 'customizer_section_code_javascript',
		array(
			'title' 			=> esc_html__( 'JavaScript Code', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 1,
			'panel' 			=> 'customizer_panel_code_panel',
		)
	);

	$wp_customize->add_setting( 'customization[um_theme_code_javascript]',
		array(
			'capability'        => 'edit_theme_options',
			'type' 				=> 'option',
		)
	);

	$wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'um_theme_code_javascript',
		array(
			'label'    		=> esc_html__( 'JavaScript Code', 'um-theme' ),
			'description'   => esc_html__( 'JavaScript entered in the box below will be rendered within <script> tags.', 'um-theme' ),
			'code_type'   	=> 'javascript',
			'section'  		=> 'customizer_section_code_javascript',
			'settings' 		=> 'customization[um_theme_code_javascript]',
			'priority'   	=> 1,
		)
	) );

	// Head Code
	$wp_customize->add_section( 'customizer_section_code_head',
		array(
			'title' 			=> esc_html__( 'Head Code', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 2,
			'panel' 			=> 'customizer_panel_code_panel',
		)
	);

	$wp_customize->add_setting( 'customization[um_theme_code_head]',
		array(
			'capability'        => 'edit_theme_options',
			'type' 				=> 'option',
		)
	);

	$wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'um_theme_code_head',
		array(
			'label'    		=> esc_html__( 'Head Code', 'um-theme' ),
			'description'   => esc_html__( 'Code entered in the box below will be rendered within the page <head> tag.', 'um-theme' ),
			'code_type'   	=> 'javascript',
			'section'  		=> 'customizer_section_code_head',
			'settings' 		=> 'customization[um_theme_code_head]',
			'priority'   	=> 1,
		)
	) );

	// Header Code
	$wp_customize->add_section( 'customizer_section_code_header',
		array(
			'title' 			=> esc_html__( 'Header Code', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 3,
			'panel' 			=> 'customizer_panel_code_panel',
		)
	);

	$wp_customize->add_setting( 'customization[um_theme_code_header]',
		array(
			'capability'        => 'edit_theme_options',
			'type' 				=> 'option',
		)
	);

	$wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'um_theme_code_header',
		array(
			'label'    		=> esc_html__( 'Header Code', 'um-theme' ),
			'description'   => esc_html__( 'Code entered in the box below will be rendered directly after the opening <body> tag.', 'um-theme' ),
			'section'  		=> 'customizer_section_code_header',
			'settings' 		=> 'customization[um_theme_code_header]',
			'code_type'     => 'javascript',
			'priority'   	=> 1,
		)
	) );

	// Footer Code
	$wp_customize->add_section('customizer_section_code_footer',
		array(
			'title' 			=> esc_html__( 'Footer Code', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 4,
			'panel' 			=> 'customizer_panel_code_panel',
		)
	);

	$wp_customize->add_setting( 'customization[um_theme_code_footer]',
		array(
			'capability'        => 'edit_theme_options',
			'type' 				=> 'option',
		)
	);

	$wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'um_theme_code_footer',
		array(
			'label'    		=> esc_html__( 'Footer Code', 'um-theme' ),
			'description'   => esc_html__( 'Code entered in the box below will be rendered directly before the closing <body> tag.', 'um-theme' ),
			'section'  		=> 'customizer_section_code_footer',
			'settings' 		=> 'customization[um_theme_code_footer]',
			'code_type'     => 'javascript',
			'priority'   	=> 1,
		)
	) );



/*--------------------------------------------------------------
## ForumWP
--------------------------------------------------------------*/

	// ForumWP Forum
	$wp_customize->add_section( 'customizer_section_forumwp_forum',
		array(
			'title' 			=> esc_html__( 'Forum', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 1,
			'panel' 			=> 'customizer_panel_forumwp_panel',
			'active_callback' 	=> 'um_theme_is_active_forumwp',
		)
	);

	// ForumWP Topic
	$wp_customize->add_section( 'customizer_section_forumwp_topic',
		array(
			'title' 			=> esc_html__( 'Topic', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 2,
			'panel' 			=> 'customizer_panel_forumwp_panel',
			'active_callback' 	=> 'um_theme_is_active_forumwp',
		)
	);

	// ForumWP Tag
	$wp_customize->add_section( 'customizer_section_forumwp_tag',
		array(
			'title' 			=> esc_html__( 'Tag', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 3,
			'panel' 			=> 'customizer_panel_forumwp_panel',
			'active_callback' 	=> 'um_theme_is_active_forumwp',
		)
	);

	// ForumWP Category
	$wp_customize->add_section( 'customizer_section_forumwp_category',
		array(
			'title' 			=> esc_html__( 'Category', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 4,
			'panel' 			=> 'customizer_panel_forumwp_panel',
			'active_callback' 	=> 'um_theme_is_active_forumwp',
		)
	);

	// ForumWP Search
	$wp_customize->add_section( 'customizer_section_forumwp_search',
		array(
			'title' 			=> esc_html__( 'Search', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 5,
			'panel' 			=> 'customizer_panel_forumwp_panel',
			'active_callback' 	=> 'um_theme_is_active_forumwp',
		)
	);

	// ForumWP Misc
	$wp_customize->add_section( 'customizer_section_forumwp_misc',
		array(
			'title' 			=> esc_html__( 'Misc', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 6,
			'panel' 			=> 'customizer_panel_forumwp_panel',
			'active_callback' 	=> 'um_theme_is_active_forumwp',
		)
	);

/*--------------------------------------------------------------
## ForumWP Search
--------------------------------------------------------------*/

	// Search Button Color
	$wp_customize->add_setting( 'customization[um_forumwp_search_button_color]' ,
		array(
		    'default' 			=> '#1a1a1a',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_search_button_color',
			array(
				'label'      => esc_html__( 'Search Button Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_search',
				'settings'   => 'customization[um_forumwp_search_button_color]',
			    'priority'   => 3,
			)
		));

	// Search Button Text Color
	$wp_customize->add_setting( 'customization[um_forumwp_search_button_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_search_button_text_color',
			array(
				'label'      => esc_html__( 'Search Button Text Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_search',
				'settings'   => 'customization[um_forumwp_search_button_text_color]',
			    'priority'   => 4,
			)
		));

	// Search Box Color
	$wp_customize->add_setting( 'customization[um_forumwp_search_box_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_search_box_color',
			array(
				'label'      => esc_html__( 'Search Box Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_search',
				'settings'   => 'customization[um_forumwp_search_box_color]',
			    'priority'   => 4,
			)
		));
/*--------------------------------------------------------------
## ForumWP Forum
--------------------------------------------------------------*/

	// Forum Title Color
	$wp_customize->add_setting( 'customization[um_forumwp_forum_title_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_forum_title_color',
			array(
				'label'      => esc_html__( 'Forum Title Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_forum',
				'settings'   => 'customization[um_forumwp_forum_title_color]',
			    'priority'   => 1,
			)
		));

	// Forum Text Color
	$wp_customize->add_setting( 'customization[um_forumwp_subdata_color]' ,
		array(
		    'default' 			=> '#a3a3a3',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_subdata_color',
			array(
				'label'      => esc_html__( 'Sub Data Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_forum',
				'settings'   => 'customization[um_forumwp_subdata_color]',
			    'priority'   => 1,
			)
		));

	// Reply Box Color
	$wp_customize->add_setting( 'customization[um_forumwp_reply_box_color]' ,
		array(
		    'default' 			=> '#f6f8fc',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_reply_box_color',
			array(
				'label'      => esc_html__( 'Reply Box Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_forum',
				'settings'   => 'customization[um_forumwp_reply_box_color]',
			    'priority'   => 2,
			)
		));

	// Forum Heading Color
	$wp_customize->add_setting( 'customization[um_forumwp_forum_heading_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_forum_heading_color',
			array(
				'label'      => esc_html__( 'Forum Heading Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_forum',
				'settings'   => 'customization[um_forumwp_forum_heading_color]',
			    'priority'   => 5,
			)
		));

	// Forum Border Color
	$wp_customize->add_setting( 'customization[um_forumwp_border_color]' ,
		array(
		    'default' 			=> '#eeeeee',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_border_color',
			array(
				'label'      => esc_html__( 'Forum Border Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_forum',
				'settings'   => 'customization[um_forumwp_border_color]',
			    'priority'   => 6,
			)
		));

	// Meta Color
	$wp_customize->add_setting( 'customization[um_forumwp_meta_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_meta_color',
			array(
				'label'      => esc_html__( 'Meta Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_forum',
				'settings'   => 'customization[um_forumwp_meta_color]',
			    'priority'   => 7,
			)
		));

/*--------------------------------------------------------------
## ForumWP Category
--------------------------------------------------------------*/
	// Category Color
	$wp_customize->add_setting( 'customization[um_forumwp_cat_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_cat_color',
			array(
				'label'      => esc_html__( 'Category Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_category',
				'settings'   => 'customization[um_forumwp_cat_color]',
			    'priority'   => 1,
			)
		));

	// Category Text Color
	$wp_customize->add_setting( 'customization[um_forumwp_cat_txt_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_cat_txt_color',
			array(
				'label'      => esc_html__( 'Category Text Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_category',
				'settings'   => 'customization[um_forumwp_cat_txt_color]',
			    'priority'   => 2,
			)
		));

/*--------------------------------------------------------------
## ForumWP Tag
--------------------------------------------------------------*/
	// Category Color
	$wp_customize->add_setting( 'customization[um_forumwp_tag_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_tag_color',
			array(
				'label'      => esc_html__( 'Category Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_tag',
				'settings'   => 'customization[um_forumwp_tag_color]',
			    'priority'   => 1,
			)
		));

	// Category Text Color
	$wp_customize->add_setting( 'customization[um_forumwp_tag_txt_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_tag_txt_color',
			array(
				'label'      => esc_html__( 'Category Text Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_tag',
				'settings'   => 'customization[um_forumwp_tag_txt_color]',
			    'priority'   => 2,
			)
		));


/*--------------------------------------------------------------
## ForumWP Topic
--------------------------------------------------------------*/

	// Topic Title Font Size
	$wp_customize->add_setting( 'customization[um_forumwp_topic_title_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '16px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_forumwp_topic_title_font_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Topic Title Font Size', 'um-theme' ),
					'section' 		=> 'customizer_section_forumwp_topic',
					'settings' 		=> 'customization[um_forumwp_topic_title_font_size]',
					'priority'   	=> 2,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);

	// Category Text Color
	$wp_customize->add_setting( 'customization[um_forumwp_topic_title_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_topic_title_color',
			array(
				'label'      => esc_html__( 'Topic Title Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_topic',
				'settings'   => 'customization[um_forumwp_topic_title_color]',
			    'priority'   => 3,
			)
		));


	// Topic Button Color
	$wp_customize->add_setting( 'customization[um_forumwp_topic_btn_color]' ,
		array(
		    'default' 			=> '#1a1a1a',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_topic_btn_color',
			array(
				'label'      => esc_html__( 'Topic Button Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_topic',
				'settings'   => 'customization[um_forumwp_topic_btn_color]',
			    'priority'   => 11,
			)
		));

	// Topic Button Text Color
	$wp_customize->add_setting( 'customization[um_forumwp_topic_btn_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_topic_btn_text_color',
			array(
				'label'      => esc_html__( 'Topic Button Text Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_topic',
				'settings'   => 'customization[um_forumwp_topic_btn_text_color]',
			    'priority'   => 12,
			)
		));

	// Reply Button Color
	$wp_customize->add_setting( 'customization[um_forumwp_reply_btn_color]' ,
		array(
		    'default' 			=> '#1a1a1a',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_reply_btn_color',
			array(
				'label'      => esc_html__( 'Reply Button Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_topic',
				'settings'   => 'customization[um_forumwp_reply_btn_color]',
			    'priority'   => 13,
			)
		));

	// Topic Button Text Color
	$wp_customize->add_setting( 'customization[um_forumwp_reply_btn_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_forumwp_reply_btn_text_color',
			array(
				'label'      => esc_html__( 'Reply Button Text Color', 'um-theme' ),
				'section'    => 'customizer_section_forumwp_topic',
				'settings'   => 'customization[um_forumwp_reply_btn_text_color]',
			    'priority'   => 14,
			)
		));
/*--------------------------------------------------------------
## bbPress
--------------------------------------------------------------*/
	// bbPress Color
	$wp_customize->add_section( 'customizer_section_bbpress_color',
		array(
			'title' 			=> esc_html__( 'bbPress Color', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 1,
			'panel' 			=> 'customizer_panel_bbpress_panel',
			'active_callback' 	=> 'um_theme_is_active_bbpress',
		)
	);

/*--------------------------------------------------------------
## bbPress Colors
--------------------------------------------------------------*/
	// Forum Title
	$wp_customize->add_setting( 'customization[um_theme_bb_info_color_ui_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_bb_info_color_ui_title',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Forum Color', 'um-theme' ),
					'section' 		=> 'customizer_section_bbpress_color',
					'settings'  	=> 'customization[um_theme_bb_info_color_ui_title]',
					'priority'  	=> 1,
				)
			) );


	// bbPress Title Font Size
	$wp_customize->add_setting( 'customization[um_bb_forum_title_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '16px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_bb_forum_title_font_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Title Font Size', 'um-theme' ),
					'section' 		=> 'customizer_section_bbpress_color',
					'settings' 		=> 'customization[um_bb_forum_title_font_size]',
					'priority'   	=> 2,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);

	// bbPress Title Color
	$wp_customize->add_setting( 'customization[um_bb_forum_title_color]' ,
		array(
		    'default' 			=> '#6596ff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_bb_forum_title_color',
			array(
				'label'      => esc_html__( 'Title Color', 'um-theme' ),
				'section'    => 'customizer_section_bbpress_color',
				'settings'   => 'customization[um_bb_forum_title_color]',
			    'priority'   => 3,
			)
		));

	// bbPress Text Color
	$wp_customize->add_setting( 'customization[um_bb_forum_text_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_bb_forum_text_color',
			array(
				'label'      => esc_html__( 'Text Color', 'um-theme' ),
				'section'    => 'customizer_section_bbpress_color',
				'settings'   => 'customization[um_bb_forum_text_color]',
			    'priority'   => 4,
			)
		));

	// bbPress Author Name Color
	$wp_customize->add_setting( 'customization[um_bb_forum_author_name_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'um_bb_forum_author_name_color',
			array(
				'label'      => esc_html__( 'Author Name Color', 'um-theme' ),
				'section'    => 'customizer_section_bbpress_color',
				'settings'   => 'customization[um_bb_forum_author_name_color]',
			    'priority'   => 5,
			)
		));

	$wp_customize->add_setting( 'um_theme_bb_color_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_bb_color_line_break_first',
				array(
					'section' 		=> 'customizer_section_bbpress_color',
					'settings'   	=> 'um_theme_bb_color_line_break_first',
					'priority'   	=> 9,
			)) 	);

	// Forum Title
	$wp_customize->add_setting( 'customization[um_theme_bb_forum_header_ui_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_bb_forum_header_ui_title',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Forum Header', 'um-theme' ),
					'section' 		=> 'customizer_section_bbpress_color',
					'settings'  	=> 'customization[um_theme_bb_forum_header_ui_title]',
					'priority'  	=> 10,
			)) );

	// Forum Header Background Color
	$wp_customize->add_setting( 'customization[um_bb_forum_header_bg_color]' ,
		array(
		    'default' 			=> '#6596ff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_bb_forum_header_bg_color',
			array(
				'label'      => esc_html__( 'Forum Header Background Color', 'um-theme' ),
				'section'    => 'customizer_section_bbpress_color',
				'settings'   => 'customization[um_bb_forum_header_bg_color]',
			    'priority'   => 11,
			)
		));

	// Forum Header Text Color
	$wp_customize->add_setting( 'customization[um_bb_forum_header_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_bb_forum_header_text_color',
			array(
				'label'      => esc_html__( 'Forum Header Text Color', 'um-theme' ),
				'section'    => 'customizer_section_bbpress_color',
				'settings'   => 'customization[um_bb_forum_header_text_color]',
			    'priority'   => 12,
			)
		));

	// Forum Header Border Color
	$wp_customize->add_setting( 'customization[um_bb_forum_header_border_color]' ,
		array(
		    'default' 			=> '#6596ff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_bb_forum_header_border_color',
			array(
				'label'      => esc_html__( 'Forum Header Border Color', 'um-theme' ),
				'section'    => 'customizer_section_bbpress_color',
				'settings'   => 'customization[um_bb_forum_header_border_color]',
			    'priority'   => 13,
			)
		));

	$wp_customize->add_setting( 'um_theme_bb_color_line_break_second',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_bb_color_line_break_second',
				array(
					'section' 		=> 'customizer_section_bbpress_color',
					'settings'   	=> 'um_theme_bb_color_line_break_second',
					'priority'   	=> 19,
			)) );

	// Forum Title
	$wp_customize->add_setting( 'customization[um_theme_bb_forum_notice_ui_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_bb_forum_notice_ui_title',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Sticky & Notice', 'um-theme' ),
					'section' 		=> 'customizer_section_bbpress_color',
					'settings'  	=> 'customization[um_theme_bb_forum_notice_ui_title]',
					'priority'  	=> 20,
			)) );

	// Sticky topic background color
	$wp_customize->add_setting( 'customization[um_bb_sticky_topic_bg_color]' ,
		array(
	    'default' 			=> '#f0f8ff',
	    'type' 				=> 'option',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_bb_sticky_topic_bg_color',
			array(
				'label'      => esc_html__( 'Sticky topic background color', 'um-theme' ),
				'section'    => 'customizer_section_bbpress_color',
				'settings'   => 'customization[um_bb_sticky_topic_bg_color]',
			    'priority'   => 21,
			)
		));

	// Notice Background Color
	$wp_customize->add_setting( 'customization[um_bb_notice_bg_color]' ,
		array(
		    'default' 			=> '#ECEFF1',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_bb_notice_bg_color',
			array(
				'label'      => esc_html__( 'Notice Background Color', 'um-theme' ),
				'section'    => 'customizer_section_bbpress_color',
				'settings'   => 'customization[um_bb_notice_bg_color]',
			    'priority'   => 22,
			)
		));

	// Notice Text Color
	$wp_customize->add_setting( 'customization[um_bb_notice_text_color]' ,
		array(
		    'default' 			=> '#444444',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_bb_notice_text_color',
			array(
				'label'      => esc_html__( 'Notice Text Color', 'um-theme' ),
				'section'    => 'customizer_section_bbpress_color',
				'settings'   => 'customization[um_bb_notice_text_color]',
			    'priority'   => 23,
			)
		));

	// Notice Border Color
	$wp_customize->add_setting( 'customization[um_bb_notice_border_color]' ,
		array(
		    'default' 			=> '#CFD8DC',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_bb_notice_border_color',
			array(
				'label'      => esc_html__( 'Notice Border Color', 'um-theme' ),
				'section'    => 'customizer_section_bbpress_color',
				'settings'   => 'customization[um_bb_notice_border_color]',
			    'priority'   => 24,
			)
		));

/*--------------------------------------------------------------
## LifterLMS
--------------------------------------------------------------*/

	// LifterLMS Color
	$wp_customize->add_section( 'customizer_section_lifterlms_button',
		array(
			'title' 			=> esc_html__( 'LifterLMS Buttons', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'customizer_panel_lifterlms_panel',
			'active_callback' 	=> 'um_theme_is_active_lifterlms',
		)
	);

	// LifterLMS Pricing Tables
	$wp_customize->add_section( 'customizer_section_lifterlms_pricing_tables',
		array(
			'title' 			=> esc_html__( 'LifterLMS Pricing Tables', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'customizer_panel_lifterlms_panel',
			'active_callback' 	=> 'um_theme_is_active_lifterlms',
		)
	);

	// LifterLMS Checkout
	$wp_customize->add_section( 'customizer_section_lifterlms_checkout',
		array(
			'title' 			=> esc_html__( 'LifterLMS Checkout', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'customizer_panel_lifterlms_panel',
			'active_callback' 	=> 'um_theme_is_active_lifterlms',
		)
	);

	/*--------------------------------------------------------------
	## LifterLMS Buttons
	--------------------------------------------------------------*/

	// Primary Button Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_primary_button_color]' ,
		array(
		    'default' 			=> '#2295ff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_lifter_primary_button_color',
			array(
				'label'      => esc_html__( 'Primary Button Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_button',
				'settings'   => 'customization[um_theme_lifter_primary_button_color]',
			    'priority'   => 2,
			)
		));

	// Primary Button Text Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_primary_button_text_color]' ,
		array(
		    'default' 			=> '#fefefe',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_lifter_primary_button_text_color',
			array(
				'label'      => esc_html__( 'Primary Button Text Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_button',
				'settings'   => 'customization[um_theme_lifter_primary_button_text_color]',
			    'priority'   => 3,
			)
		));


	// Primary Button Hover Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_primary_button_hover_color]' ,
		array(
		    'default' 			=> '#0077e4',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_lifter_primary_button_hover_color',
			array(
				'label'      => esc_html__( 'Primary Button Hover Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_button',
				'settings'   => 'customization[um_theme_lifter_primary_button_hover_color]',
			    'priority'   => 4,
			)
		));

	// Primary Button Text Hover Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_primary_button_hover_text_color]' ,
		array(
		    'default' 			=> '#fefefe',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_lifter_primary_button_hover_text_color',
			array(
				'label'      => esc_html__( 'Primary Button Hover Text Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_button',
				'settings'   => 'customization[um_theme_lifter_primary_button_hover_text_color]',
			    'priority'   => 5,
			)
		));


	// Secondary Button Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_secondary_button_color]' ,
		array(
		    'default' 			=> '#e1e1e1',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_lifter_secondary_button_color',
			array(
				'label'      => esc_html__( 'Secondary Button Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_button',
				'settings'   => 'customization[um_theme_lifter_secondary_button_color]',
			    'priority'   => 11,
			)
		));


	// Secondary Button Text Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_secondary_button_text_color]' ,
		array(
		    'default' 			=> '#414141',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_lifter_secondary_button_text_color',
			array(
				'label'      => esc_html__( 'Secondary Button Text Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_button',
				'settings'   => 'customization[um_theme_lifter_secondary_button_text_color]',
			    'priority'   => 12,
			)
		));


	// Secondary Button Hover Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_secondary_button_hover_color]' ,
		array(
		    'default' 			=> '#cdcdcd',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_lifter_secondary_button_hover_color',
			array(
				'label'      => esc_html__( 'Secondary Button Hover Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_button',
				'settings'   => 'customization[um_theme_lifter_secondary_button_hover_color]',
			    'priority'   => 13,
			)
		));

	// Secondary Button Text Hover Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_secondary_button_hover_text_color]' ,
		array(
		    'default' 			=> '#414141',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_lifter_secondary_button_hover_text_color',
			array(
				'label'      => esc_html__( 'Secondary Button Hover Text Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_button',
				'settings'   => 'customization[um_theme_lifter_secondary_button_hover_text_color]',
			    'priority'   => 14,
			)
		));

	/*--------------------------------------------------------------
	## Pricing Tables
	--------------------------------------------------------------*/

	// Plan Title Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_plan_title_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_lifter_plan_title_color',
			array(
				'label'      => esc_html__( 'Plan Title Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_pricing_tables',
				'settings'   => 'customization[um_theme_lifter_plan_title_color]',
			    'priority'   => 2,
			)
		));

	// Plan Title Background Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_plan_title_bg_color]' ,
		array(
		    'default' 			=> '#2295ff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_lifter_plan_title_bg_color',
			array(
				'label'      => esc_html__( 'Plan Title Background Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_pricing_tables',
				'settings'   => 'customization[um_theme_lifter_plan_title_bg_color]',
			    'priority'   => 3,
			)
		));


	// Plan Featured Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_plan_featured_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_lifter_plan_featured_color',
			array(
				'label'      => esc_html__( 'Plan Featured Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_pricing_tables',
				'settings'   => 'customization[um_theme_lifter_plan_featured_color]',
			    'priority'   => 11,
			)
		));

	// Plan Featured Background Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_plan_featured_bg_color]' ,
		array(
		    'default' 			=> '#4ba9ff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_lifter_plan_featured_bg_color',
			array(
				'label'      => esc_html__( 'Plan Featured Background Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_pricing_tables',
				'settings'   => 'customization[um_theme_lifter_plan_featured_bg_color]',
			    'priority'   => 12,
			)
		));

	// Plan Border Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_plan_featured_border_color]' ,
		array(
		    'default' 			=> '#2295ff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_lifter_plan_featured_border_color',
			array(
				'label'      => esc_html__( 'Plan Border Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_pricing_tables',
				'settings'   => 'customization[um_theme_lifter_plan_featured_border_color]',
			    'priority'   => 13,
			)
		));

	// Restrictions Link Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_plan_restriction_link_color]' ,
		array(
		    'default' 			=> '#f8954f',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_lifter_plan_restriction_link_color',
			array(
				'label'      => esc_html__( 'Restrictions Link Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_pricing_tables',
				'settings'   => 'customization[um_theme_lifter_plan_restriction_link_color]',
			    'priority'   => 14,
			)
		));

	// Restrictions Link Hover Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_plan_restriction_link_hover_color]' ,
		array(
		    'default' 			=> '#f67d28',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_lifter_plan_restriction_link_hover_color',
			array(
				'label'      => esc_html__( 'Restrictions Link Hover Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_pricing_tables',
				'settings'   => 'customization[um_theme_lifter_plan_restriction_link_hover_color]',
			    'priority'   => 14,
			)
		));

	/*--------------------------------------------------------------
	## LifterLMS Checkout
	--------------------------------------------------------------*/

	// Checkout Heading Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_checkout_heading_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_lifter_checkout_heading_color',
			array(
				'label'      => esc_html__( 'Checkout Heading Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_checkout',
				'settings'   => 'customization[um_theme_lifter_checkout_heading_color]',
			    'priority'   => 2,
			)
		));

	// Checkout Heading Background Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_checkout_heading_bg_color]' ,
		array(
		    'default' 			=> '#2295ff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_lifter_checkout_heading_bg_color',
			array(
				'label'      => esc_html__( 'Checkout Heading Background Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_checkout',
				'settings'   => 'customization[um_theme_lifter_checkout_heading_bg_color]',
			    'priority'   => 3,
			)
		));

	// Checkout Border Color
	$wp_customize->add_setting( 'customization[um_theme_lifter_checkout_border_color]' ,
		array(
		    'default' 			=> '#2295ff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_lifter_checkout_border_color',
			array(
				'label'      => esc_html__( 'Checkout Border Color', 'um-theme' ),
				'section'    => 'customizer_section_lifterlms_checkout',
				'settings'   => 'customization[um_theme_lifter_checkout_border_color]',
			    'priority'   => 3,
			)
		));

/*--------------------------------------------------------------
## WooCommerce
--------------------------------------------------------------*/

	// WooCommerce Color
	$wp_customize->add_section( 'customizer_section_woocommerce_color',
		array(
			'title' 			=> esc_html__( 'WooCommerce Color', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'woocommerce',
		)
	);

	// WooCommerce Layouts
	$wp_customize->add_section( 'customizer_section_woocommerce_layouts',
		array(
			'title' 			=> esc_html__( 'WooCommerce Layouts', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'woocommerce',
		)
	);

	// Related & Upsell
	$wp_customize->add_section( 'customizer_section_woocommerce_reup',
		array(
			'title' 			=> esc_html__( 'Related & Upsell', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'woocommerce',
		)
	);

	// YITH WooCommerce Wishlist
	$wp_customize->add_section( 'customizer_section_woocommerce_yith_wishlist',
		array(
			'title' 			=> esc_html__( 'YITH WooCommerce Wishlist', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 90,
			'panel' 			=> 'woocommerce',
			'active_callback' 	=> 'um_theme_is_active_yith_wishlist',
		)
	);

/*--------------------------------------------------------------
## YITH WooCommerce Wishlist
--------------------------------------------------------------*/

	// Wishlist Add to Cart Button
	$wp_customize->add_setting( 'customization[um_theme_yith_wishlist_add_cart_color]' ,
		array(
		    'default' 			=> '#3F51B5',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_yith_wishlist_add_cart_color',
			array(
				'label'      => esc_html__( 'Wishlist Add to Cart Button', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_yith_wishlist',
				'settings'   => 'customization[um_theme_yith_wishlist_add_cart_color]',
			    'priority'   => 1,
			)
		));

	// Wishlist Add to Cart Button Text
	$wp_customize->add_setting( 'customization[um_theme_yith_wishlist_add_cart_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_yith_wishlist_add_cart_text_color',
			array(
				'label'      => esc_html__( 'Wishlist Add to Cart Button Text', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_yith_wishlist',
				'settings'   => 'customization[um_theme_yith_wishlist_add_cart_text_color]',
			    'priority'   => 2,
			)
		));

	// Wishlist Remove Button
	$wp_customize->add_setting( 'customization[um_theme_yith_wishlist_remove_color]' ,
		array(
		    'default' 			=> '#CFD8DC',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_yith_wishlist_remove_color',
			array(
				'label'      => esc_html__( 'Wishlist Remove Button', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_yith_wishlist',
				'settings'   => 'customization[um_theme_yith_wishlist_remove_color]',
			    'priority'   => 3,
			)
		));

	// Wishlist Remove Button
	$wp_customize->add_setting( 'customization[um_theme_yith_wishlist_remove_text_color]' ,
		array(
		    'default' 			=> '#607D8B',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_yith_wishlist_remove_text_color',
			array(
				'label'      => esc_html__( 'Wishlist Remove Button Text', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_yith_wishlist',
				'settings'   => 'customization[um_theme_yith_wishlist_remove_text_color]',
			    'priority'   => 4,
			)
		));

	// Show Wishlist Button below Shop products
	$wp_customize->add_setting( 'customization[um_theme_yith_show_wishlist_product_loop]' ,
		array(
			'default' 			=> false,
			'type' 				=> 'option',
			'transport' 		=> 'refresh',
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);

		$wp_customize->add_control( 'um_theme_yith_show_wishlist_product_loop',
			array(
				'label'      => esc_html__( 'Show Wishlist below Shop products', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_yith_wishlist',
				'settings'   => 'customization[um_theme_yith_show_wishlist_product_loop]',
			    'priority'   => 11,
			    'type'       => 'checkbox',
			)
		);

/*--------------------------------------------------------------
## WooCommerce Layouts
--------------------------------------------------------------*/

	// Products layout
	$wp_customize->add_setting( 'customization[um_theme_woo_product_layout]',
		array(
			'default' => 1,
			'type' => 'option',
			'transport' => 'refresh',
			'sanitize_callback'    => 'absint',
			'sanitize_js_callback' => 'absint',
		)
	);

		$wp_customize->add_control( 'um_theme_woo_product_layout',
			array(
				'label'      => esc_html__( 'Products layout', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_layouts',
				'settings'   => 'customization[um_theme_woo_product_layout]',
			    'priority'   => 11,
			    'type'       => 'select',
				'choices'    => array(
									1   => esc_html__( 'Grid', 'um-theme' ),
									2   => esc_html__( 'List', 'um-theme' ),
								),
			)
		);

/*--------------------------------------------------------------
## WooCommerce Color
--------------------------------------------------------------*/

	// WooCommerce Info Color
	$wp_customize->add_setting( 'customization[um_theme_um_woo_info_color_ui_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_um_woo_info_color_ui_title',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'WooCommerce Info Color', 'um-theme' ),
					'section' 		=> 'customizer_section_woocommerce_color',
					'settings'  	=> 'customization[um_theme_um_woo_info_color_ui_title]',
					'priority'  	=> 1,
			)) );

	// WooCommerce Info Color
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_info_color]' ,
		array(
		    'default' 			=> '#1e85be',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_woocommerce_info_color',
			array(
				'label'      => esc_html__( 'WooCommerce Info', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_color',
				'settings'   => 'customization[um_theme_woocommerce_info_color]',
			    'priority'   => 2,
			)
		));

	// WooCommerce Message Color
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_message_color]' ,
		array(
		    'default' 			=> '#8fae1b',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_woocommerce_message_color',
			array(
				'label'      => esc_html__( 'WooCommerce Message', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_color',
				'settings'   => 'customization[um_theme_woocommerce_message_color]',
			    'priority'   => 3,
			)
		));

	// WooCommerce Message Color
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_message_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_woocommerce_message_text_color',
			array(
				'label'      => esc_html__( 'WooCommerce Message Text', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_color',
				'settings'   => 'customization[um_theme_woocommerce_message_text_color]',
			    'priority'   => 3,
			)
		));

	$wp_customize->add_setting( 'um_theme_um_woo_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_um_woo_line_break_first',
				array(
					'section' 		=> 'customizer_section_woocommerce_color',
					'settings'   	=> 'um_theme_um_woo_line_break_first',
					'priority'   	=> 19,
				)
			) );

	// WooCommerce On Slae Badge Color
	$wp_customize->add_setting( 'customization[um_theme_um_woo_product_color_ui_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_um_woo_product_color_ui_title',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Product Colors', 'um-theme' ),
					'section' 		=> 'customizer_section_woocommerce_color',
					'settings'  	=> 'customization[um_theme_um_woo_product_color_ui_title]',
					'priority'  	=> 20,
				)
			) );

	// Product Title
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_product_title_color]' ,
		array(
		    'default' 			=> '#3F51B5',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_woocommerce_product_title_color',
			array(
				'label'      => esc_html__( 'Product Title', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_color',
				'settings'   => 'customization[um_theme_woocommerce_product_title_color]',
			    'priority'   => 21,
			)
		));

	// Price Color
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_price_color]' ,
		array(
		    'default' 			=> '#3F51B5',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_woocommerce_price_color',
			array(
				'label'      => esc_html__( 'Price Color', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_color',
				'settings'   => 'customization[um_theme_woocommerce_price_color]',
			    'priority'   => 22,
			)
		));

	// Star Rating Color
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_star_rating_color]' ,
		array(
		    'default' 			=> '#FFC107',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_woocommerce_star_rating_color',
			array(
				'label'      => esc_html__( 'Star Rating Color', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_color',
				'settings'   => 'customization[um_theme_woocommerce_star_rating_color]',
			    'priority'   => 23,
			)
		));

	$wp_customize->add_setting( 'um_theme_um_woo_line_break_second',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_um_woo_line_break_second',
				array(
					'section' 		=> 'customizer_section_woocommerce_color',
					'settings'   	=> 'um_theme_um_woo_line_break_second',
					'priority'   	=> 29,
			)) );

	// WooCommerce On Slae Badge Color
	$wp_customize->add_setting( 'customization[um_theme_um_woo_sale_badge_color_ui_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_um_woo_sale_badge_color_ui_title',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'On Sale Badge', 'um-theme' ),
					'description' 	=> esc_html__( 'Change the color of On Sale Badges.', 'um-theme' ),
					'section' 		=> 'customizer_section_woocommerce_color',
					'settings'  	=> 'customization[um_theme_um_woo_sale_badge_color_ui_title]',
					'priority'  	=> 30,
			)) );

	// Sale Badge
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_sale_badge_color]' ,
		array(
		    'default' 			=> '#ef3768',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_woocommerce_sale_badge_color',
			array(
				'label'      => esc_html__( 'Sale Badge Color', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_color',
				'settings'   => 'customization[um_theme_woocommerce_sale_badge_color]',
			    'priority'   => 31,
			)
		));

	// Sale Badge Text
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_sale_badge_text]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_woocommerce_sale_badge_text',
			array(
				'label'      => esc_html__( 'Sale Badge Text', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_color',
				'settings'   => 'customization[um_theme_woocommerce_sale_badge_text]',
			    'priority'   => 32,
			)
		));

	$wp_customize->add_setting( 'um_theme_um_woo_line_break_third',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_um_woo_line_break_third',
				array(
					'section' 		=> 'customizer_section_woocommerce_color',
					'settings'   	=> 'um_theme_um_woo_line_break_third',
					'priority'   	=> 39,
			)) );

	// WooCommerce Shop Page Buttons Color
	$wp_customize->add_setting( 'customization[um_theme_um_woo_button_color_ui_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_um_woo_button_color_ui_title',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Buttons Color', 'um-theme' ),
					'description' 	=> esc_html__( 'Change the color of Add to Cart Buttons', 'um-theme' ),
					'section' 		=> 'customizer_section_woocommerce_color',
					'settings'  	=> 'customization[um_theme_um_woo_button_color_ui_title]',
					'priority'  	=> 40,
			)) );

	// Add To Cart Button
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_add_cart_button_color]' ,
		array(
		    'default' 			=> '#3F51B5',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_woocommerce_add_cart_button_color',
			array(
				'label'      => esc_html__( 'Button Color', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_color',
				'settings'   => 'customization[um_theme_woocommerce_add_cart_button_color]',
			    'priority'   => 41,
			)
		));

	// Add To Cart Button Text
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_add_cart_button_text]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_woocommerce_add_cart_button_text',
			array(
				'label'      => esc_html__( 'Button Text Color', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_color',
				'settings'   => 'customization[um_theme_woocommerce_add_cart_button_text]',
			    'priority'   => 42,
			)
		));

	// Add To Cart Button
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_add_cart_button_hover_color]' ,
		array(
		    'default' 			=> '#3F51B5',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_woocommerce_add_cart_button_hover_color',
			array(
				'label'      => esc_html__( 'Button Hover Color', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_color',
				'settings'   => 'customization[um_theme_woocommerce_add_cart_button_hover_color]',
			    'priority'   => 43,
			)
		));

	// Add To Cart Button Text
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_add_cart_button_hover_text]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,'um_theme_woocommerce_add_cart_button_hover_text',
			array(
				'label'      => esc_html__( 'Button Hover Text', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_color',
				'settings'   => 'customization[um_theme_woocommerce_add_cart_button_hover_text]',
			    'priority'   => 44,
			)
		));

/*--------------------------------------------------------------
## WooCommerce Shop page Settings
--------------------------------------------------------------*/

	if ( um_theme_is_active_woocommerce() ){
		$wp_customize->get_control( 'woocommerce_shop_page_display' )->priority 			= 2;
		$wp_customize->get_control( 'woocommerce_category_archive_display' )->priority 		= 3;
		$wp_customize->get_control( 'woocommerce_default_catalog_orderby' )->priority 		= 4;
		$wp_customize->get_control( 'woocommerce_catalog_columns' )->priority 				= 41;
		$wp_customize->get_control( 'woocommerce_catalog_rows' )->priority 					= 42;
	}


	// WooCommerce Shop Page Buttons Color
	$wp_customize->add_setting( 'customization[um_theme_woo_shop_page_content_ui_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_woo_shop_page_content_ui_title',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Shop Page Content', 'um-theme' ),
					'section' 		=> 'woocommerce_product_catalog',
					'settings'  	=> 'customization[um_theme_woo_shop_page_content_ui_title]',
					'priority'  	=> 1,
			)) );




	$wp_customize->add_setting( 'um_theme_native_woo_shop_line_break_third',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_native_woo_shop_line_break_third',
				array(
					'section' 		=> 'woocommerce_product_catalog',
					'settings'   	=> 'um_theme_native_woo_shop_line_break_third',
					'priority'   	=> 39,
			)) );

	// WooCommerce Shop Page Buttons Color
	$wp_customize->add_setting( 'customization[um_theme_woo_shop_product_count_ui_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_woo_shop_product_count_ui_title',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Number of products','um-theme' ),
					'section' 		=> 'woocommerce_product_catalog',
					'settings'  	=> 'customization[um_theme_woo_shop_product_count_ui_title]',
					'priority'  	=> 40,
			)) );


	$wp_customize->add_setting( 'um_theme_native_woo_shop_line_break_fourth',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_native_woo_shop_line_break_fourth',
				array(
					'section' 		=> 'woocommerce_product_catalog',
					'settings'   	=> 'um_theme_native_woo_shop_line_break_fourth',
					'priority'   	=> 49,
			)) );

	// WooCommerce Shop Page Buttons Color
	$wp_customize->add_setting( 'customization[um_theme_woo_shop_product_hide_ui_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_woo_shop_product_hide_ui_title',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Show / Hide','um-theme' ),
					'section' 		=> 'woocommerce_product_catalog',
					'settings'  	=> 'customization[um_theme_woo_shop_product_hide_ui_title]',
					'priority'  	=> 50,
			)) );

	// Show Product Title
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_shop_show_product_title]' ,
		array(
			'default' 			=> true,
			'type' 				=> 'option',
			'transport' 		=> 'refresh',
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);

		$wp_customize->add_control( 'um_theme_woocommerce_shop_show_product_title',
			array(
				'label'      => esc_html__( 'Show Product Title', 'um-theme' ),
				'section'    => 'woocommerce_product_catalog',
				'settings'   => 'customization[um_theme_woocommerce_shop_show_product_title]',
			    'priority'   => 51,
			    'type'       => 'checkbox',
			)
		);

	// Show Product Price
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_shop_show_product_price]' ,
		array(
			'default' 			=> true,
			'type' 				=> 'option',
			'transport' 		=> 'refresh',
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);

		$wp_customize->add_control( 'um_theme_woocommerce_shop_show_product_price',
			array(
				'label'      => esc_html__( 'Show Product Price', 'um-theme' ),
				'section'    => 'woocommerce_product_catalog',
				'settings'   => 'customization[um_theme_woocommerce_shop_show_product_price]',
			    'priority'   => 52,
			    'type'       => 'checkbox',
			)
		);

	// Show Add To Cart Button
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_shop_show_add_cart]' ,
		array(
			'default' 			=> true,
			'type' 				=> 'option',
			'transport' 		=> 'refresh',
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);

		$wp_customize->add_control( 'um_theme_woocommerce_shop_show_add_cart',
			array(
				'label'      => esc_html__( 'Show Add To Cart Button', 'um-theme' ),
				'section'    => 'woocommerce_product_catalog',
				'settings'   => 'customization[um_theme_woocommerce_shop_show_add_cart]',
			    'priority'   => 53,
			    'type'       => 'checkbox',
			)
		);

	// Show Sale Badge
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_shop_show_sale_badge]' ,
		array(
			'default' 			=> true,
			'type' 				=> 'option',
			'transport' 		=> 'refresh',
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);

		$wp_customize->add_control( 'um_theme_woocommerce_shop_show_sale_badge',
			array(
				'label'      => esc_html__( 'Show Sale Badge', 'um-theme' ),
				'section'    => 'woocommerce_product_catalog',
				'settings'   => 'customization[um_theme_woocommerce_shop_show_sale_badge]',
			    'priority'   => 54,
			    'type'       => 'checkbox',
			)
		);

	// WooCommerce Product Title Font Size
	$wp_customize->add_setting('customization[um_theme_woo_prod_title_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '16px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control('um_theme_woo_prod_title_font_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Product Title Font Size','um-theme' ),
					'section' 		=> 'woocommerce_product_catalog',
					'settings' 		=> 'customization[um_theme_woo_prod_title_font_size]',
					'priority'   	=> 61,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);

/*--------------------------------------------------------------
## WooCommerce Notice
--------------------------------------------------------------*/

	// Notice Background Color
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_notice_bg_color]' ,
		array(
		    'default' 			=> '#a46497',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_woocommerce_notice_bg_color',
			array(
				'label'      => esc_html__( 'Notice Background Color', 'um-theme' ),
				'section'    => 'woocommerce_store_notice',
				'settings'   => 'customization[um_theme_woocommerce_notice_bg_color]',
			    'priority'   => 20,
			)
		));

	// Notice Text Color
	$wp_customize->add_setting( 'customization[um_theme_woocommerce_notice_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
			'capability'        => 'manage_woocommerce',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_woocommerce_notice_text_color',
			array(
				'label'      => esc_html__( 'Notice Text Color', 'um-theme' ),
				'section'    => 'woocommerce_store_notice',
				'settings'   => 'customization[um_theme_woocommerce_notice_text_color]',
			    'priority'   => 21,
			)
		));

/*--------------------------------------------------------------
## WooCommerce Related & Upsell Products
--------------------------------------------------------------*/

	// Show Related Products
	$wp_customize->add_setting( 'customization[um_theme_show_woo_related]' ,
		array(
			'default' 				=> 1,
			'type' 					=> 'option',
			'sanitize_callback'    	=> 'absint',
			'sanitize_js_callback' 	=> 'absint',
			'transport' 			=> 'refresh',
		)
	);

		$wp_customize->add_control( 'um_theme_show_woo_related',
			array(
				'label'      => esc_html__( 'Show Related Products', 'um-theme' ),
				'section'    => 'customizer_section_woocommerce_reup',
				'settings'   => 'customization[um_theme_show_woo_related]',
			    'priority'   => 1,
			    'type'       => 'select',
				'choices'    => array(
					1   => esc_html__( 'Enable', 'um-theme' ),
					2   => esc_html__( 'Disable', 'um-theme' ),
				),
			)
		);


	// WooCommerce Number of Related Products
	$wp_customize->add_setting( 'customization[um_theme_woo_related_product_no]',
		array(
			'type' 				=> 'option',
			'default' 			=> 4,
			'sanitize_callback' => 'absint',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_woo_related_product_no',
				array(
					'type' 			=> 'number',
					'label' 		=> esc_html__( 'Number of Related Products per page','um-theme' ),
					'section' 		=> 'customizer_section_woocommerce_reup',
					'settings' 		=> 'customization[um_theme_woo_related_product_no]',
					'priority'   	=> 2,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( '4', 'um-theme' ),
	        		),
				)
			);


	// WooCommerce Number of Upsell Products
	$wp_customize->add_setting( 'customization[um_theme_woo_upsell_product_no]',
		array(
			'type' 				=> 'option',
			'default' 			=> 4,
			'sanitize_callback' => 'absint',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_woo_upsell_product_no',
				array(
					'type' 			=> 'number',
					'label' 		=> esc_html__( 'Number of Upsell Products per page','um-theme' ),
					'section' 		=> 'customizer_section_woocommerce_reup',
					'settings' 		=> 'customization[um_theme_woo_upsell_product_no]',
					'priority'   	=> 3,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( '4', 'um-theme' ),
	        		),
				)
			);


/*--------------------------------------------------------------
## SportsPress
--------------------------------------------------------------*/

	// SportsPress Table
	$wp_customize->add_section( 'customizer_section_sportspress_table',
		array(
			'title' 			=> esc_html__( 'Table', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 1,
			'panel' 			=> 'customizer_panel_um_sportspress',
			'active_callback' 	=> 'um_theme_is_active_sportspress',
		)
	);

	// SportsPress Elements
	$wp_customize->add_section( 'customizer_section_sportspress_elements',
		array(
			'title' 			=> esc_html__( 'Elements', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 2,
			'panel' 			=> 'customizer_panel_um_sportspress',
			'active_callback' 	=> 'um_theme_is_active_sportspress',
		)
	);

/*--------------------------------------------------------------
## SportsPress Table
--------------------------------------------------------------*/

	// SportsPress Table Caption Background
	$wp_customize->add_setting( 'customization[um_theme_sportspress_table_caption_color]' ,
		array(
		    'default' 			=> '#2b353e',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_sportspress_table_caption_color',
			array(
				'label'      => esc_html__( 'Table Caption Background', 'um-theme' ),
				'section'    => 'customizer_section_sportspress_table',
				'settings'   => 'customization[um_theme_sportspress_table_caption_color]',
			    'priority'   => 1,
			)
		));

	// SportsPress Table Caption Text
	$wp_customize->add_setting( 'customization[um_theme_sportspress_table_caption_text]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_sportspress_table_caption_text',
			array(
				'label'      => esc_html__( 'Table Caption Text', 'um-theme' ),
				'section'    => 'customizer_section_sportspress_table',
				'settings'   => 'customization[um_theme_sportspress_table_caption_text]',
			    'priority'   => 2,
			)
		));

	// SportsPress Table Background
	$wp_customize->add_setting( 'customization[um_theme_sportspress_table_bg]' ,
		array(
		    'default' 			=> '#f4f4f4',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_sportspress_table_bg',
			array(
				'label'      => esc_html__( 'Table Caption Background', 'um-theme' ),
				'section'    => 'customizer_section_sportspress_table',
				'settings'   => 'customization[um_theme_sportspress_table_bg]',
			    'priority'   => 3,
			)
		));


	// SportsPress Table Background
	$wp_customize->add_setting( 'customization[um_theme_sportspress_table_border]' ,
		array(
		    'default' 			=> '#e0e0e0',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_sportspress_table_border',
			array(
				'label'      => esc_html__( 'Table Border', 'um-theme' ),
				'section'    => 'customizer_section_sportspress_table',
				'settings'   => 'customization[um_theme_sportspress_table_border]',
			    'priority'   => 4,
			)
		));


/*--------------------------------------------------------------
## SportsPress Elements
--------------------------------------------------------------*/

	// SportsPress Elements Background
	$wp_customize->add_setting( 'customization[um_theme_sportspress_elements_bg]' ,
		array(
		    'default' 			=> '#E3F2FD',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_sportspress_elements_bg',
			array(
				'label'      => esc_html__( 'Elements Background', 'um-theme' ),
				'section'    => 'customizer_section_sportspress_table',
				'settings'   => 'customization[um_theme_sportspress_elements_bg]',
			    'priority'   => 1,
			)
		));


	// SportsPress Elements Text
	$wp_customize->add_setting( 'customization[um_theme_sportspress_elements_text]' ,
		array(
		    'default' 			=> '#4FC3F7',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_sportspress_elements_text',
			array(
				'label'      => esc_html__( 'Elements Text', 'um-theme' ),
				'section'    => 'customizer_section_sportspress_table',
				'settings'   => 'customization[um_theme_sportspress_elements_text]',
			    'priority'   => 2,
			)
		));

/*--------------------------------------------------------------
## WP Adverts
--------------------------------------------------------------*/

	// WPAdverts Item
	$wp_customize->add_section( 'customizer_section_wpadverts_item',
		array(
			'title' 			=> esc_html__( 'Advert Item', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 1,
			'panel' 			=> 'customizer_panel_um_wpadverts',
			'active_callback' 	=> 'is_active_wp_adverts',
		)
	);

	// WPAdverts Pricing
	$wp_customize->add_section( 'customizer_section_wpadverts_pricing',
		array(
			'title' 			=> esc_html__( 'Pricing', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 1,
			'panel' 			=> 'customizer_panel_um_wpadverts',
			'active_callback' 	=> 'is_active_wp_adverts',
		)
	);

	// WPAdverts Featured Item
	$wp_customize->add_section( 'customizer_section_wpadverts_featured',
		array(
			'title' 			=> esc_html__( 'Featured Item', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 1,
			'panel' 			=> 'customizer_panel_um_wpadverts',
			'active_callback' 	=> 'is_active_wp_adverts',
		)
	);

	// WPAdverts Sold Item
	$wp_customize->add_section( 'customizer_section_wpadverts_sold',
		array(
			'title' 			=> esc_html__( 'Sold Item', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 1,
			'panel' 			=> 'customizer_panel_um_wpadverts',
			'active_callback' 	=> 'is_active_wp_adverts',
		)
	);

	// WPAdverts Search Filter
	$wp_customize->add_section( 'customizer_section_wpadverts_search',
		array(
			'title' 			=> esc_html__( 'Search Filter', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 10,
			'panel' 			=> 'customizer_panel_um_wpadverts',
			'active_callback' 	=> 'is_active_wp_adverts',
		)
	);

/*--------------------------------------------------------------
## WPAdverts Colors
--------------------------------------------------------------*/

	// Item Background Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_item_bg_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_item_bg_color',
			array(
				'label'      => esc_html__( 'Item Background Color', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_item',
				'settings'   => 'customization[um_theme_wpadverts_item_bg_color]',
			    'priority'   => 1,
			)
		));

	// Text Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_text_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_text_color',
			array(
				'label'      => esc_html__( 'Text Color', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_item',
				'settings'   => 'customization[um_theme_wpadverts_text_color]',
			    'priority'   => 1,
			)
		));

	// Link Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_link_color]' ,
		array(
		    'default' 			=> '#21759b',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_link_color',
			array(
				'label'      => esc_html__( 'Link Color', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_item',
				'settings'   => 'customization[um_theme_wpadverts_link_color]',
			    'priority'   => 1,
			)
		));

	// Item Border Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_item_border_color]' ,
		array(
		    'default' 			=> '#e5e5e5',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_item_border_color',
			array(
				'label'      => esc_html__( 'Item Border Color', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_item',
				'settings'   => 'customization[um_theme_wpadverts_item_border_color]',
			    'priority'   => 1,
			)
		));

	// Icon Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_icon_color]' ,
		array(
		    'default' 			=> '#999999',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_icon_color',
			array(
				'label'      => esc_html__( 'Icon Color', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_item',
				'settings'   => 'customization[um_theme_wpadverts_icon_color]',
			    'priority'   => 20,
			)
		));

	// Icon Background Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_icon_bg_color]' ,
		array(
		    'default' 			=> '#f5f5f5',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_icon_bg_color',
			array(
				'label'      => esc_html__( 'Icon Background Color', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_item',
				'settings'   => 'customization[um_theme_wpadverts_icon_bg_color]',
			    'priority'   => 21,
			)
		));

	// Contact Box Background Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_contact_box_bg_color]' ,
		array(
		    'default' 			=> '#fcfcfc',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_contact_box_bg_color',
			array(
				'label'      => esc_html__( 'Contact Box Background Color', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_item',
				'settings'   => 'customization[um_theme_wpadverts_contact_box_bg_color]',
			    'priority'   => 31,
			)
		));

	// Contact Box Border Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_contact_box_border_color]' ,
		array(
		    'default' 			=> '#f5f5f5',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_contact_box_border_color',
			array(
				'label'      => esc_html__( 'Contact Box Border Color', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_item',
				'settings'   => 'customization[um_theme_wpadverts_contact_box_border_color]',
			    'priority'   => 32,
			)
		));

/*--------------------------------------------------------------
## WPAdverts Sold Item
--------------------------------------------------------------*/

	// Sold Item Background Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_sold_item_bg_color]' ,
		array(
		    'default' 			=> '#ffcc00',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_sold_item_bg_color',
			array(
				'label'      => esc_html__( 'Sold Item Background', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_sold',
				'settings'   => 'customization[um_theme_wpadverts_sold_item_bg_color]',
			    'priority'   => 40,
			)
		));

	// Sold Item Text Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_sold_item_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_sold_item_text_color',
			array(
				'label'      => esc_html__( 'Sold Item Text', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_sold',
				'settings'   => 'customization[um_theme_wpadverts_sold_item_text_color]',
			    'priority'   => 41,
			)
		));

/*--------------------------------------------------------------
## WPAdverts Featured Item
--------------------------------------------------------------*/

	// Featured Item Background Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_featured_item_bg_color]' ,
		array(
		    'default' 			=> '#F0F8FF',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_featured_item_bg_color',
			array(
				'label'      => esc_html__( 'Featured Item Background', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_featured',
				'settings'   => 'customization[um_theme_wpadverts_featured_item_bg_color]',
			    'priority'   => 30,
			)
		));

	// Featured Item Border Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_featured_item_border_color]' ,
		array(
		    'default' 			=> '#b0c4de',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_featured_item_border_color',
			array(
				'label'      => esc_html__( 'Featured Item Border', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_featured',
				'settings'   => 'customization[um_theme_wpadverts_featured_item_border_color]',
			    'priority'   => 30,
			)
		));


	// Title Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_featured_item_title_color]' ,
		array(
		    'default' 			=> '#21759b',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_featured_item_title_color',
			array(
				'label'      => esc_html__( 'Featured Item Title', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_featured',
				'settings'   => 'customization[um_theme_wpadverts_featured_item_title_color]',
			    'priority'   => 30,
			)
		));

	// Text Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_featured_item_text_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_featured_item_text_color',
			array(
				'label'      => esc_html__( 'Featured Item Text', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_featured',
				'settings'   => 'customization[um_theme_wpadverts_featured_item_text_color]',
			    'priority'   => 30,
			)
		));

/*--------------------------------------------------------------
## WPAdverts Pricing
--------------------------------------------------------------*/

	// Price Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_price_color]' ,
		array(
		    'default' 			=> '#b34040',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_price_color',
			array(
				'label'      => esc_html__( 'Price Color', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_pricing',
				'settings'   => 'customization[um_theme_wpadverts_price_color]',
			    'priority'   => 1,
			)
		));

	// Price Background Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_price_bg_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_price_bg_color',
			array(
				'label'      => esc_html__( 'Price Background Color', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_pricing',
				'settings'   => 'customization[um_theme_wpadverts_price_bg_color]',
			    'priority'   => 2,
			)
		));

/*--------------------------------------------------------------
## WPAdverts Search Filter
--------------------------------------------------------------*/

	// Search Box Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_search_box_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_search_box_color',
			array(
				'label'      => esc_html__( 'Search Box Color', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_search',
				'settings'   => 'customization[um_theme_wpadverts_search_box_color]',
			    'priority'   => 1,
			)
		));

	// Search Border Color
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_search_border_color]' ,
		array(
		    'default' 			=> '#e5e5e5',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_search_border_color',
			array(
				'label'      => esc_html__( 'Search Border Color', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_search',
				'settings'   => 'customization[um_theme_wpadverts_search_border_color]',
			    'priority'   => 2,
			)
		));

	// Search Placeholder Background
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_search_placeholder_bg]' ,
		array(
		    'default' 			=> '#eeeeee',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_search_placeholder_bg',
			array(
				'label'      => esc_html__( 'Search Placeholder Background', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_search',
				'settings'   => 'customization[um_theme_wpadverts_search_placeholder_bg]',
			    'priority'   => 2,
			)
		));

	// Search Placeholder Text
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_search_placeholder_text]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_search_placeholder_text',
			array(
				'label'      => esc_html__( 'Search Placeholder Text', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_search',
				'settings'   => 'customization[um_theme_wpadverts_search_placeholder_text]',
			    'priority'   => 2,
			)
		));

	// Search Button Background
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_search_button_bg]' ,
		array(
		    'default' 			=> '#f5f5f5',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_search_button_bg',
			array(
				'label'      => esc_html__( 'Search Button Background', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_search',
				'settings'   => 'customization[um_theme_wpadverts_search_button_bg]',
			    'priority'   => 2,
			)
		));

	// Search Button Text
	$wp_customize->add_setting( 'customization[um_theme_wpadverts_search_button_text]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_wpadverts_search_button_text',
			array(
				'label'      => esc_html__( 'Search Button Text', 'um-theme' ),
				'section'    => 'customizer_section_wpadverts_search',
				'settings'   => 'customization[um_theme_wpadverts_search_button_text]',
			    'priority'   => 2,
			)
		));


/*--------------------------------------------------------------
## Restrict Content Section
--------------------------------------------------------------*/

	// Restrict Content Colors
	$wp_customize->add_section( 'customizer_section_rcp_colors',
		array(
			'title' 			=> esc_html__( 'Colors', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 1,
			'panel' 			=> 'customizer_panel_rcp_panel',
			'active_callback' 	=> 'is_active_restrict_content',
		)
	);

/*--------------------------------------------------------------
## Restrict Content Colors
--------------------------------------------------------------*/

	// Restrict Message Text
	$wp_customize->add_setting( 'customization[um_theme_rcp_message_text_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_rcp_message_text_color',
			array(
				'label'      => esc_html__( 'Restrict Message Text', 'um-theme' ),
				'section'    => 'customizer_section_rcp_colors',
				'settings'   => 'customization[um_theme_rcp_message_text_color]',
			    'priority'   => 1,
			)
		));

	// Restrict Message Background
	$wp_customize->add_setting( 'customization[um_theme_rcp_message_bg_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_rcp_message_bg_color',
			array(
				'label'      => esc_html__( 'Restrict Message Background', 'um-theme' ),
				'section'    => 'customizer_section_rcp_colors',
				'settings'   => 'customization[um_theme_rcp_message_bg_color]',
			    'priority'   => 2,
			)
		));


	// Logout Button Text
	$wp_customize->add_setting( 'customization[um_theme_rcp_logout_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_rcp_logout_text_color',
			array(
				'label'      => esc_html__( 'Logout Button Text', 'um-theme' ),
				'section'    => 'customizer_section_rcp_colors',
				'settings'   => 'customization[um_theme_rcp_logout_text_color]',
			    'priority'   => 11,
			)
		));

	// Logout Button
	$wp_customize->add_setting( 'customization[um_theme_rcp_logout_bg_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_rcp_logout_bg_color',
			array(
				'label'      => esc_html__( 'Logout Button', 'um-theme' ),
				'section'    => 'customizer_section_rcp_colors',
				'settings'   => 'customization[um_theme_rcp_logout_bg_color]',
			    'priority'   => 12,
			)
		));


/*--------------------------------------------------------------
## Dokan Multivendor Sections
--------------------------------------------------------------*/

	// Product Loop
	$wp_customize->add_section( 'customizer_section_dokan_product_loop',
		array(
			'title' 			=> esc_html__( 'Product Loop', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 1,
			'panel' 			=> 'customizer_panel_dokan_multivendor_panel',
			'active_callback' 	=> 'um_theme_is_active_dokan',
		)
	);

	// Dokan Colors
	$wp_customize->add_section( 'customizer_section_dokan_colors',
		array(
			'title' 			=> esc_html__( 'Colors', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 1,
			'panel' 			=> 'customizer_panel_dokan_multivendor_panel',
			'active_callback' 	=> 'um_theme_is_active_dokan',
		)
	);

/*--------------------------------------------------------------
## Dokan Colors
--------------------------------------------------------------*/

	// Store Pages
	$wp_customize->add_setting( 'customization[um_theme_dokan_store_color_ui_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_dokan_store_color_ui_title',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Store Pages', 'um-theme' ),
					'section' 		=> 'customizer_section_dokan_colors',
					'settings'  	=> 'customization[um_theme_dokan_store_color_ui_title]',
					'priority'  	=> 1,
				)
			) );

	// Store Name Color
	$wp_customize->add_setting( 'customization[um_theme_dokan_store_name_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_dokan_store_name_color',
			array(
				'label'      => esc_html__( 'Store Name', 'um-theme' ),
				'section'    => 'customizer_section_dokan_colors',
				'settings'   => 'customization[um_theme_dokan_store_name_color]',
			    'priority'   => 3,
			)
		));

	// Store Info Color
	$wp_customize->add_setting( 'customization[um_theme_dokan_store_info_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_dokan_store_info_color',
			array(
				'label'      => esc_html__( 'Store Info', 'um-theme' ),
				'section'    => 'customizer_section_dokan_colors',
				'settings'   => 'customization[um_theme_dokan_store_info_color]',
			    'priority'   => 3,
			)
		));
/*--------------------------------------------------------------
## Dokan Multivendor - Product Loop
--------------------------------------------------------------*/

	// Show Product Title
	$wp_customize->add_setting( 'customization[um_theme_dokan_shop_show_sold_by]' ,
		array(
			'default' 			=> true,
			'type' 				=> 'option',
			'transport' 		=> 'refresh',
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);

		$wp_customize->add_control( 'um_theme_dokan_shop_show_sold_by',
			array(
				'label'      => esc_html__( 'Show Sold By', 'um-theme' ),
				'section'    => 'customizer_section_dokan_product_loop',
				'settings'   => 'customization[um_theme_dokan_shop_show_sold_by]',
			    'priority'   => 51,
			    'type'       => 'checkbox',
			)
		);

	// Show Vendor Information
	$wp_customize->add_setting( 'customization[um_theme_dokan_single_vendor_info]' ,
		array(
			'default' 			=> true,
			'type' 				=> 'option',
			'transport' 		=> 'refresh',
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);

		$wp_customize->add_control( 'um_theme_dokan_single_vendor_info',
			array(
				'label'      => esc_html__( 'Show Vendor Info', 'um-theme' ),
				'section'    => 'customizer_section_dokan_product_loop',
				'settings'   => 'customization[um_theme_dokan_single_vendor_info]',
			    'priority'   => 51,
			    'type'       => 'checkbox',
			)
		);

/*--------------------------------------------------------------
## EDD Buttons Section
--------------------------------------------------------------*/

	// EDD Buttons Section
	$wp_customize->add_section( 'customizer_section_edd_buttons',
		array(
			'title' 			=> esc_html__( 'EDD Buttons', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 1,
			'panel' 			=> 'customizer_panel_easy_digital_downloads',
			'active_callback' 	=> 'um_theme_is_active_edd',
		)
	);

	// EDD Info Color
	$wp_customize->add_section( 'customizer_section_edd_info_color',
		array(
			'title' 			=> esc_html__( 'EDD Info Color', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 2,
			'panel' 			=> 'customizer_panel_easy_digital_downloads',
			'active_callback' 	=> 'um_theme_is_active_edd',
		)
	);

/*--------------------------------------------------------------
## EDD Buttons
--------------------------------------------------------------*/

	// Button
	$wp_customize->add_setting( 'customization[um_theme_edd_button_ui_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_edd_button_ui_title',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Button', 'um-theme' ),
					'section' 		=> 'customizer_section_edd_buttons',
					'settings'  	=> 'customization[um_theme_edd_button_ui_title]',
					'priority'  	=> 1,
				)
			) );


	// EDD Button Font Size
	$wp_customize->add_setting( 'customization[um_theme_edd_button_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '16px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_edd_button_font_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Button Font Size', 'um-theme' ),
					'section' 		=> 'customizer_section_edd_buttons',
					'settings' 		=> 'customization[um_theme_edd_button_font_size]',
					'priority'   	=> 2,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);

	// EDD Button Color
	$wp_customize->add_setting( 'customization[um_theme_edd_button_bg_color]' ,
		array(
		    'default' 			=> '#428bca',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_edd_button_bg_color',
			array(
				'label'      => esc_html__( 'Button Color', 'um-theme' ),
				'section'    => 'customizer_section_edd_buttons',
				'settings'   => 'customization[um_theme_edd_button_bg_color]',
			    'priority'   => 3,
			)
		));

	// EDD Button Text Color
	$wp_customize->add_setting( 'customization[um_theme_edd_button_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_edd_button_text_color',
			array(
				'label'      => esc_html__( 'Button Text Color', 'um-theme' ),
				'section'    => 'customizer_section_edd_buttons',
				'settings'   => 'customization[um_theme_edd_button_text_color]',
			    'priority'   => 4,
			)
		));

	// EDD Button Hover Color
	$wp_customize->add_setting( 'customization[um_theme_edd_button_hover_bg_color]' ,
		array(
		    'default' 			=> '#428bca',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_edd_button_hover_bg_color',
			array(
				'label'      => esc_html__( 'Button Hover Color', 'um-theme' ),
				'section'    => 'customizer_section_edd_buttons',
				'settings'   => 'customization[um_theme_edd_button_hover_bg_color]',
			    'priority'   => 5,
			)
		));

	// EDD Button Hover Text Color
	$wp_customize->add_setting( 'customization[um_theme_edd_button_hover_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_edd_button_hover_text_color',
			array(
				'label'      => esc_html__( 'Button Hover Text Color', 'um-theme' ),
				'section'    => 'customizer_section_edd_buttons',
				'settings'   => 'customization[um_theme_edd_button_hover_text_color]',
			    'priority'   => 6,
			)
		));

/*--------------------------------------------------------------
## EDD Info Color
--------------------------------------------------------------*/

	// Error Background Color
	$wp_customize->add_setting( 'customization[um_theme_edd_alert_bg_color]' ,
		array(
		    'default' 			=> '#f2dede',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_edd_alert_bg_color',
			array(
				'label'      => esc_html__( 'Error Background Color', 'um-theme' ),
				'section'    => 'customizer_section_edd_info_color',
				'settings'   => 'customization[um_theme_edd_alert_bg_color]',
			    'priority'   => 2,
			)
		));

	// Error Text Color
	$wp_customize->add_setting( 'customization[um_theme_edd_alert_text_color]' ,
		array(
		    'default' 			=> '#a94442',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_edd_alert_text_color',
			array(
				'label'      => esc_html__( 'Error Text Color', 'um-theme' ),
				'section'    => 'customizer_section_edd_info_color',
				'settings'   => 'customization[um_theme_edd_alert_text_color]',
			    'priority'   => 3,
			)
		));

	// Error Border Color
	$wp_customize->add_setting( 'customization[um_theme_edd_alert_border_color]' ,
		array(
		    'default' 			=> '#ebccd1',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_edd_alert_border_color',
			array(
				'label'      => esc_html__( 'Error Border Color', 'um-theme' ),
				'section'    => 'customizer_section_edd_info_color',
				'settings'   => 'customization[um_theme_edd_alert_border_color]',
			    'priority'   => 4,
			)
		));

	$wp_customize->add_setting( 'um_theme_edd_info_line_break_first',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_edd_info_line_break_first',
				array(
					'section' 	=> 'customizer_section_edd_info_color',
					'settings'  => 'um_theme_edd_info_line_break_first',
					'priority'  => 9,
			)) );


	// Success Background Color
	$wp_customize->add_setting( 'customization[um_theme_edd_success_bg_color]' ,
		array(
		    'default' 			=> '#dff0d8',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_edd_success_bg_color',
			array(
				'label'      => esc_html__( 'Success Background Color', 'um-theme' ),
				'section'    => 'customizer_section_edd_info_color',
				'settings'   => 'customization[um_theme_edd_success_bg_color]',
			    'priority'   => 12,
			)
		));

	// Success Text Color
	$wp_customize->add_setting( 'customization[um_theme_edd_success_text_color]' ,
		array(
		    'default' 			=> '#3c763d',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_edd_success_text_color',
			array(
				'label'      => esc_html__( 'Success Text Color', 'um-theme' ),
				'section'    => 'customizer_section_edd_info_color',
				'settings'   => 'customization[um_theme_edd_success_text_color]',
			    'priority'   => 13,
			)
		));

	// Success Border Color
	$wp_customize->add_setting( 'customization[um_theme_edd_success_border_color]' ,
		array(
		    'default' 			=> '#d6e9c6',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_edd_success_border_color',
			array(
				'label'      => esc_html__( 'Success Border Color', 'um-theme' ),
				'section'    => 'customizer_section_edd_info_color',
				'settings'   => 'customization[um_theme_edd_success_border_color]',
			    'priority'   => 14,
			)
		));

	$wp_customize->add_setting( 'um_theme_edd_info_line_break_second',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_edd_info_line_break_second',
				array(
					'section' 	=> 'customizer_section_edd_info_color',
					'settings'  => 'um_theme_edd_info_line_break_second',
					'priority'  => 19,
			)) );

	// Info Background Color
	$wp_customize->add_setting( 'customization[um_theme_edd_info_bg_color]' ,
		array(
		    'default' 			=> '#d9edf7',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_edd_info_bg_color',
			array(
				'label'      => esc_html__( 'Info Background Color', 'um-theme' ),
				'section'    => 'customizer_section_edd_info_color',
				'settings'   => 'customization[um_theme_edd_info_bg_color]',
			    'priority'   => 22,
			)
		));

	// Info Text Color
	$wp_customize->add_setting( 'customization[um_theme_edd_info_text_color]' ,
		array(
		    'default' 			=> '#31708f',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_edd_info_text_color',
			array(
				'label'      => esc_html__( 'Info Text Color', 'um-theme' ),
				'section'    => 'customizer_section_edd_info_color',
				'settings'   => 'customization[um_theme_edd_info_text_color]',
			    'priority'   => 23,
			)
		));

	// Info Border Color
	$wp_customize->add_setting( 'customization[um_theme_edd_info_border_color]' ,
		array(
		    'default' 			=> '#bce8f1',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_edd_info_border_color',
			array(
				'label'      => esc_html__( 'Info Border Color', 'um-theme' ),
				'section'    => 'customizer_section_edd_info_color',
				'settings'   => 'customization[um_theme_edd_info_border_color]',
			    'priority'   => 24,
			)
		));

	$wp_customize->add_setting( 'um_theme_edd_info_line_break_third',
		array(
			'default'    => true,
			'sanitize_callback' => 'wp_kses',
		)
	);

			$wp_customize->add_control( new UM_Theme_Helper_Line_Break( $wp_customize, 'um_theme_edd_info_line_break_third',
				array(
					'section' 	=> 'customizer_section_edd_info_color',
					'settings'  => 'um_theme_edd_info_line_break_third',
					'priority'  => 29,
			)) );


	// Warn Background Color
	$wp_customize->add_setting( 'customization[um_theme_edd_warn_bg_color]' ,
		array(
		    'default' 			=> '#fcf8e3',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_edd_warn_bg_color',
			array(
				'label'      => esc_html__( 'Warn Background Color', 'um-theme' ),
				'section'    => 'customizer_section_edd_info_color',
				'settings'   => 'customization[um_theme_edd_warn_bg_color]',
			    'priority'   => 32,
			)
		));

	// Warn Text Color
	$wp_customize->add_setting( 'customization[um_theme_edd_warn_text_color]' ,
		array(
		    'default' 			=> '#8a6d3b',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_edd_warn_text_color',
			array(
				'label'      => esc_html__( 'Warn Text Color', 'um-theme' ),
				'section'    => 'customizer_section_edd_info_color',
				'settings'   => 'customization[um_theme_edd_warn_text_color]',
			    'priority'   => 33,
			)
		));

	// Warn Border Color
	$wp_customize->add_setting( 'customization[um_theme_edd_warn_border_color]' ,
		array(
		    'default' 			=> '#faebcc',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_edd_warn_border_color',
			array(
				'label'      => esc_html__( 'Warn Border Color', 'um-theme' ),
				'section'    => 'customizer_section_edd_info_color',
				'settings'   => 'customization[um_theme_edd_warn_border_color]',
			    'priority'   => 34,
			)
		));
/*--------------------------------------------------------------
## WP Job Manager
--------------------------------------------------------------*/

	// Single Job Listing
	$wp_customize->add_section( 'customizer_section_single_job_listing',
		array(
			'title' 			=> esc_html__( 'Single Job Listing', 'um-theme' ),
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 1,
			'panel' 			=> 'customizer_panel_job_manager_panel',
			'active_callback' 	=> 'um_theme_is_active_wp_job_manager',
		)
	);

/*--------------------------------------------------------------
## Single Job Listing
--------------------------------------------------------------*/

	// Single Job Listing Title
	$wp_customize->add_setting( 'customization[um_theme_sing_job_listing_ui_title]',
		array(
			'type' 				=> 'option',
			'sanitize_callback' => 'wp_kses',
			)
	);

			$wp_customize->add_control( new UM_Theme_UI_Helper_Title( $wp_customize, 'um_theme_sing_job_listing_ui_title',
				array(
					'type' 			=> 'info',
					'label' 		=> esc_html__( 'Job Title', 'um-theme' ),
					'section' 		=> 'customizer_section_single_job_listing',
					'settings'  	=> 'customization[um_theme_sing_job_listing_ui_title]',
					'priority'  	=> 1,
				)
			) );


	// Job Title Font Size
	$wp_customize->add_setting( 'customization[um_theme_sing_job_listing_title_font_size]',
		array(
			'type' 				=> 'option',
			'default' 			=> '30px',
			'sanitize_callback' => 'esc_attr',
			'transport' 		=> 'refresh',
		)
	);
			$wp_customize->add_control( 'um_theme_sing_job_listing_title_font_size',
				array(
					'type' 			=> 'text',
					'label' 		=> esc_html__( 'Title Font Size', 'um-theme' ),
					'section' 		=> 'customizer_section_single_job_listing',
					'settings' 		=> 'customization[um_theme_sing_job_listing_title_font_size]',
					'priority'   	=> 2,
	               	'input_attrs' 	=> array(
	            		'placeholder' => __( 'example: 16px', 'um-theme' ),
	        		),
				)
			);

	// Job Title Color
	$wp_customize->add_setting( 'customization[um_theme_sing_job_listing_title_color]' ,
		array(
		    'default' 			=> '#333333',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_sing_job_listing_title_color',
			array(
				'label'      => esc_html__( 'Title Color', 'um-theme' ),
				'section'    => 'customizer_section_single_job_listing',
				'settings'   => 'customization[um_theme_sing_job_listing_title_color]',
			    'priority'   => 3,
			)
		));


	// Apply Button Color
	$wp_customize->add_setting( 'customization[um_theme_sing_job_listing_button_color]' ,
		array(
		    'default' 			=> '#2196F3',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_sing_job_listing_button_color',
			array(
				'label'      => esc_html__( 'Button Color', 'um-theme' ),
				'section'    => 'customizer_section_single_job_listing',
				'settings'   => 'customization[um_theme_sing_job_listing_button_color]',
			    'priority'   => 12,
			)
		));

	// Apply Button Text Color
	$wp_customize->add_setting( 'customization[um_theme_sing_job_listing_button_text_color]' ,
		array(
		    'default' 			=> '#ffffff',
		    'type' 				=> 'option',
		    'sanitize_callback' => 'sanitize_hex_color',
		    'transport' 		=> 'postMessage',
		)
	);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'um_theme_sing_job_listing_button_text_color',
			array(
				'label'      => esc_html__( 'Button Text Color', 'um-theme' ),
				'section'    => 'customizer_section_single_job_listing',
				'settings'   => 'customization[um_theme_sing_job_listing_button_text_color]',
			    'priority'   => 13,
			)
		));

}