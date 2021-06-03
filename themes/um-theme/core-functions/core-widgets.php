<?php

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class UM_Theme_Widget_User_Profile extends WP_Widget {

	protected $defaults;

	public function __construct( $id_base = '', $widget_name = '', $widget_options = array(), $control_options = array() ) {

		// widget defaults
		$this->defaults = array(
			'title' 					=> esc_html__( '', 'um-theme' ),
		);

		$widget_options = array_merge(
			array(
				'classname' 					=> 'um_widget_user_profile',
				'description' 					=> esc_html__( 'UM - User Profile', 'um-theme' ),
				'customize_selective_refresh' 	=> true,
			),
			$widget_options
		);

		$control_options 	= array_merge( array( 'id_base' => 'um-widget-user-profile' ), $control_options );
		$id_base 			= empty( $id_base ) ? 'um-widget-user-profile' : $id_base;
		$widget_name    	= empty( $widget_name ) ? esc_html__( 'UM Theme: User Profile', 'um-theme' ) : $widget_name;

		parent::__construct( $id_base, $widget_name, $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$instance 				= wp_parse_args( (array) $instance, $this->defaults );
		$title 					= apply_filters( 'widget_title', sanitize_text_field( $instance['title'] ) );

        echo $before_widget;?>

		<?php
			if ( $title ) {
				do_action( 'um_theme_user_profile_widget_before_the_title' );
				echo $before_title . $title . $after_title;
				do_action( 'um_theme_user_profile_widget_after_the_title' );
			}
		?>

		<?php

		if ( class_exists( 'UM' ) ) :

			global $ultimatemember;
			global $um_prefix;

			global $menu;

			$profile_url = esc_url( um_user_profile_url( get_current_user_id() ) );

			?>

			<div class="boot-row widget-user-profile">

				<!-- User Profile -->
				<div class="boot-col-2 widget-user-profile-avatar">
					<a href="<?php echo $profile_url;?>">
						<?php echo get_avatar( get_current_user_id(), '45' );?>
					</a>
				</div>
				<div class="boot-col-10 widget-user-profile-name">
					<a href="<?php echo $profile_url;?>">
						<?php echo esc_html( um_user( 'display_name' ) );?>
					</a>
				</div>

				<?php

					// get active tabs
					$tabs = UM()->profile()->tabs_active();

					$all_tabs = $tabs;

					$tabs = array_filter( $tabs, function( $item ) {
						if ( ! empty( $item['hidden'] ) ) {
							return false;
						}
						return true;
					});

					$active_tab = UM()->profile()->active_tab();
					//check here tabs with hidden also, to make correct check of active tab
					if ( ! isset( $all_tabs[ $active_tab ] ) || um_is_on_edit_profile() ) {
						$active_tab = 'main';
						UM()->profile()->active_tab = $active_tab;
						UM()->profile()->active_subnav = null;
					}

					$has_subnav = false;
					if ( count( $tabs ) == 1 ) {
						foreach ( $tabs as $tab ) {
							if ( isset( $tab['subnav'] ) ) {
								$has_subnav = true;
							}
						}
					}

					// need enough tabs to continue
					if ( count( $tabs ) <= 1 && ! $has_subnav && count( $all_tabs ) === count( $tabs ) ) {
						return;
					}

					if ( count( $tabs ) > 1 || count( $all_tabs ) > count( $tabs ) ) {
						// Move default tab priority
						$default_tab = UM()->options()->get( 'profile_menu_default_tab' );
						$dtab = ( isset( $tabs[ $default_tab ] ) ) ? $tabs[ $default_tab ] : 'main';
						if ( isset( $tabs[ $default_tab ] ) ) {
							unset( $tabs[ $default_tab ] );
							$dtabs[ $default_tab ] = $dtab;
							$tabs = $dtabs + $tabs;
						}

						if ( ! empty( $tabs ) ) { ?>

							<div class="um-profile-nav">

								<?php foreach ( $tabs as $id => $tab ) {

									$nav_link = um_get_core_page( 'user' );
									$nav_link = remove_query_arg( 'um_action', $nav_link );
									$nav_link = remove_query_arg( 'subnav', $nav_link );
									$nav_link = add_query_arg( 'profiletab', $id, $nav_link );
									$nav_link = apply_filters( "um_profile_menu_link_{$id}", $nav_link );

									$profile_nav_class = '';

									if ( $id == $active_tab ) {
										$profile_nav_class .= ' active';
									} ?>

									<div class="um-profile-nav-item">
										<?php if ( UM()->options()->get( 'profile_menu_icons' ) ) { ?>

											<a href="<?php echo esc_url( $nav_link ); ?>" class=""
											   title="<?php echo esc_attr( $tab['name'] ); ?>">

												<i class="<?php echo esc_attr( $tab['icon'] ); ?>"></i>

												<?php if ( isset( $tab['notifier'] ) && $tab['notifier'] > 0 ) { ?>
													<span class="um-tab-notifier"><?php echo $tab['notifier']; ?></span>
												<?php } ?>

												<span class="title"><?php echo esc_html( $tab['name'] ); ?></span>
											</a>
										<?php } ?>
									</div>

								<?php } ?>

							</div>

						<?php }
					}
					?>

			</div>



			<!-- Groups -->
			<!-- Messages -->
			<!-- Online Users -->

			<?php
		endif;
		?>
       <?php  echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title']                = strip_tags( $new_instance['title'] );

		return $instance;
	}

	public function form( $instance ) {

		// Defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$title 					= sanitize_text_field( $instance['title'] );
		?>

	    <!-- Heading -->
	    <p>
		    <label for="<?php echo $this->get_field_id( 'title' );?>"><?php _e( 'Section Title','um-theme' );?></label>
		    <input class="widefat" id="<?php echo $this->get_field_id( 'title' );?>" name="<?php echo $this->get_field_name( 'title' );?>" value="<?php if ( isset( $title ) ) echo esc_attr( $title );?>"/>
		</p>
		<?php
	}

	protected function default_instance_args( array $instance ) {}

	public function enqueue_scripts( $hook_suffix ) {}

	public function print_scripts() {}

}


/**
 * Ultimate Member Plugin : Member Widget
 *
 * @since 0.50
 */

class Um_Theme_Widget_New_Members extends WP_Widget {

	protected $defaults;

	public function __construct() {

		// widget defaults
		$this->defaults = array(
			'title' 					=> esc_html__( '', 'um-theme' ),
			'um-member-order' 			=> 1,
			'member-no' 				=> 6,
			'um-member-layout' 			=> 1,
			'role' 						=> 'editor',
		);

		$widget_slug = 'um_theme_widget_new_members';

		$widget_options   = array(
			'classname' 					=> $widget_slug,
			'description' 					=> esc_html__( 'UM - Members', 'um-theme' ),
			'customize_selective_refresh' 	=> true,
		);

		$widget_name = esc_html__( 'UM Theme: New Members', 'um-theme' );

		parent::__construct( $widget_slug, $widget_name, $widget_options );
		$this->alt_option_name = 'um_theme_widget_new_members';

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_footer-widgets.php', array( $this, 'print_scripts' ), 9999 );
	}

	public function enqueue_scripts( $hook_suffix ) {
		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'underscore' );
	}


	public function print_scripts() { ?>
		<script>
		( function( $ ){
			function initColorPicker( widget ) {
						widget.find( '.color-picker' ).wpColorPicker( {
							change: _.throttle( function() { // For Customizer
								$(this).trigger( 'change' );
							}, 3000 )
						});
			}

			function onFormUpdate( event, widget ) {
				initColorPicker( widget );
			}

			$( document ).on( 'widget-added widget-updated', onFormUpdate );

			$( document ).ready( function() {
				$( '#widgets-right .widget:has(.color-picker)' ).each( function () {
					initColorPicker( $( this ) );
				} );
			} );
		}( jQuery ) );
		</script>
			<?php
	}

	public function widget( $args, $instance ) {

		extract( $args );
		$instance 				= wp_parse_args( (array) $instance, $this->defaults );

		$title 					= apply_filters( 'widget_title', sanitize_text_field( $instance['title'] ) );
		$um_member_order 		= isset( $instance['um-member-order'] ) ? $instance['um-member-order'] : '1';
		$role 					= isset( $instance['role'] ) ? $instance['role'] : 'editor';
		$member_no 				= isset( $instance['member-no'] ) ? $instance['member-no'] : '6';
		$member_layout 			= isset( $instance['um-member-layout'] ) ? $instance['um-member-layout'] : '1';

        echo $before_widget;?>

        <div class="boot-text-center">
        <div class="website-canvas">
		<?php
			if ( $title ) {
				echo $before_title.$title.$after_title;
			}
		?>

		<?php

		if ( class_exists( 'UM' ) ) :

		global $ultimatemember;
		global $um_prefix;

		if ( $um_member_order == 1 ) {
			$query_args = array(
				'role'      	=> $role,
    			'fields'      	=> 'id',
			    'number'      	=> $member_no,
			    'orderby'     	=> 'registered',
			    'order'       	=> 'DESC',
			);
		} elseif ( $um_member_order == 2 ) {
			$query_args = array(
				'role'      	=> $role,
    			'fields'      	=> 'id',
			    'number'      	=> $member_no,
			    'orderby'     	=> 'user_name',
			    'order'       	=> 'DESC',
			);
		} elseif ( $um_member_order == 3 ) {
			$query_args = array(
				'role'      	=> $role,
    			'fields'      	=> 'id',
			    'number'      	=> $member_no,
			    'orderby'     	=> 'display_name',
			    'order'       	=> 'DESC',
			);
		} else {
			$query_args = array(
				'role'      	=> $role,
    			'fields'      	=> 'id',
			    'number'      	=> $member_no,
			    'orderby'     	=> 'post_count',
			    'order'       	=> 'DESC',
			);
		}


		$wp_user_query = new WP_User_Query( $query_args );

		// Get the results
		$users = $wp_user_query->get_results();

		if ( ! empty( $users ) ) :

		do_action( 'um_theme_member_widget_before' ); // action hook um_theme_member_widget_before

		if ( $member_layout == 1 ) {

			echo '<div class="boot-row">';
		  	foreach( $users as $user_id ) :

			    um_fetch_user( $user_id );
			    $user 			= get_user_by( "id", $user_id );
			    $date_format 	= get_option( 'date_format' );
		    ?>

		    <div class="boot-col-12 um-widget-member">
		    	<div class="boot-row boot-align-items-center">
		    		<div class="boot-col-4 um-widget-member-image um-w-av-round">
		    			<a href="<?php echo esc_url( um_user_profile_url() );?>" title="<?php echo um_user( 'display_name' )?>">
		    				<?php echo um_get_avatar( '', $user_id, 65 )?>
		    			</a>
		    		</div>
		    		<div class="boot-col-8 um-widget-member-name">
		    			<a href="<?php echo esc_url( um_user_profile_url() );?>" title="<?php echo um_user( 'display_name' )?>">
							<?php echo esc_attr( um_user( "display_name" ) );?>
						</a>
		    		</div>
		    	</div>
		    </div>

		    <?php
		  endforeach;
		  echo '</div>';

		  do_action( 'um_theme_member_widget_after' );

		} else {
			echo '<div class="boot-row">';
		  foreach( $users as $user_id ) :

		    um_fetch_user( $user_id );
		    $user 			= get_user_by( "id", $user_id );
		    $date_format 	= get_option( 'date_format' );
		    ?>
		    <div class="boot-col-6 um-widget-member">
		    	<div class="boot-align-items-center">

		    		<div class="um-widget-member-image um-widget-member-image-two">
		    			<a href="<?php echo esc_url( um_user_profile_url() );?>" title="<?php echo um_user( 'display_name' )?>">
		    				<?php echo um_get_avatar( '', $user_id, 150 )?>
		    			</a>
		    		</div>

		    		<div class="um-widget-member-name boot-text-center">
		    			<a href="<?php echo esc_url( um_user_profile_url() );?>" title="<?php echo um_user( 'display_name' )?>">
							<?php echo esc_attr( um_user( "display_name" ) );?>
						</a>
		    		</div>
		    	</div>
		    </div>

		    <?php
		  endforeach;
		  echo '</div>';
		  do_action( 'um_theme_member_widget_after' );
		}
		um_reset_user();
	else :
		esc_html_e( 'Not Found', 'um-theme' );
	endif;
	endif;
		?>
       <?php  echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] 					= esc_html( $new_instance['title'] );
		$instance['role'] 					= $new_instance['role'] ;
		$instance['um-member-order'] 		= strip_tags( $new_instance['um-member-order'] );
		$instance['member-no'] 				= (int) $new_instance['member-no'];
		$instance['um-member-layout'] 		= (int) $new_instance['um-member-layout'];

		return $instance;
	}

    public function form( $instance ) {
		// Defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$title 					= sanitize_text_field( $instance['title'] );
		$member_no 				= sanitize_text_field( $instance['member-no'] );
		$member_layout 			= sanitize_text_field( $instance['um-member-layout'] );
		?>

	    <!-- Heading -->
	    <p>
		    <label for="<?php echo $this->get_field_id( 'title' );?>"><?php _e( 'Section Title','um-theme' );?></label>
		    <input class="widefat" id="<?php echo $this->get_field_id( 'title' );?>" name="<?php echo $this->get_field_name( 'title' );?>" value="<?php if ( isset( $title ) ) echo esc_attr( $title );?>"/>
		</p>

	    <!-- Member No -->
	    <p>
		    <label for="<?php echo $this->get_field_id( 'member-no' );?>"><?php _e( 'Number of Members','um-theme' );?></label>
		    <input class="widefat" id="<?php echo $this->get_field_id( 'member-no' );?>" name="<?php echo $this->get_field_name( 'member-no' );?>" value="<?php if ( isset( $member_no ) ) echo esc_attr( $member_no );?>"/>
		</p>

		<!-- Members Order -->
        <p>
			<label for="<?php echo $this->get_field_id( 'um-member-order' ); ?>"><?php _e( 'Order Members by', 'um-theme' ) ?></label>
			<select id="<?php echo $this->get_field_id( 'um-member-order' ); ?>" name="<?php echo $this->get_field_name( 'um-member-order' ); ?>" class="widefat">
				<option value="1"
					<?php if ( '1' == $instance['um-member-order'] ) echo 'selected="selected"'; ?>><?php _e( 'Newly Registered', 'um-theme' ) ?>
				</option>
				<option value="2"
					<?php if ( '2' == $instance['um-member-order'] ) echo 'selected="selected"'; ?>><?php _e( 'User Name (A - Z)', 'um-theme' ) ?>
				</option>
				<option value="3"
					<?php if ( '3' == $instance['um-member-order'] ) echo 'selected="selected"'; ?>><?php _e( 'Display Name (A - Z)', 'um-theme' ) ?>
				</option>
				<option value="4"
					<?php if ( '4' == $instance['um-member-order'] ) echo 'selected="selected"'; ?>><?php _e( 'Members with Highest Post', 'um-theme' ) ?>
				</option>
			</select>
		</p>

		<!-- Members Role -->
		<p>
			<label for="<?php echo $this->get_field_id( 'role' ); ?>"><?php _e( 'Role:', 'um-theme' ); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'role' ); ?>" name="<?php echo $this->get_field_name( 'role' ); ?>">
					<?php wp_dropdown_roles( $instance['role'] ); // Dropdown list of roles. ?>
				</select>
		</p>

		<!-- Members Order -->
        <p>
			<label for="<?php echo $this->get_field_id( 'um-member-layout' ); ?>"><?php _e( 'Layout', 'um-theme' ) ?></label>
			<select id="<?php echo $this->get_field_id( 'um-member-layout' ); ?>" name="<?php echo $this->get_field_name( 'um-member-layout' ); ?>" class="widefat">
				<option value="1"
					<?php if ( '1' == $instance['um-member-layout'] ) echo 'selected="selected"'; ?>><?php _e( 'Layout 1', 'um-theme' ) ?>
				</option>
				<option value="2"
					<?php if ( '2' == $instance['um-member-layout'] ) echo 'selected="selected"'; ?>><?php _e( 'Layout 2', 'um-theme' ) ?>
				</option>

			</select>
		</p>

		<?php
	}
}