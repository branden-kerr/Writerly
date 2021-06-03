<?php
/**
 * Enable support for Ultimate Member.
 *
 * @link   https://wordpress.org/plugins/ultimate-member/
 *
 * @since  0.50
 */

global $defaults;

/*--------------------------------------------------------------
## 1.0 Ultimate Member - General
--------------------------------------------------------------*/

/**
 * Customizer UM page redirection.
 * When Customizing Ultimate Member Plugin Pages re-direct to pages based on UM Customizer Tab.
 */
add_action( 'customize_controls_print_scripts', 'um_theme_customizer_add_scripts', 30 );

if ( ! function_exists( 'um_theme_customizer_add_scripts' ) ) {
    function um_theme_customizer_add_scripts() {
            if ( class_exists( 'UM' ) ) {
            ?>
                <script type="text/javascript">
                    jQuery( document ).ready( function( $ ) {

                        wp.customize.section( 'customizer_section_um_member_directory', function( section ) {
                            section.expanded.bind( function( isExpanded ) {
                                if ( isExpanded ) {
                                    wp.customize.previewer.previewUrl.set( '<?php echo esc_js( um_get_core_page( 'members' ) ); ?>' );
                                }
                            } );
                        } );

                        wp.customize.section( 'customizer_section_um_profile_template', function( section ) {
                            section.expanded.bind( function( isExpanded ) {
                                if ( isExpanded ) {
                                    wp.customize.previewer.previewUrl.set( '<?php echo esc_js( um_get_core_page( 'user' ) ); ?>' );
                                }
                            } );
                        } );

                    } );
                </script>
            <?php
        }
    }
}

/**
 * Remove um-old-default.css
 * UM Dequeue Old UM CSS File.
 * Removes the um-old-default.css
 */
add_action( 'wp_enqueue_scripts', 'um_theme_remove_old_css', UM()->enqueue()->get_priority() + 1 );

if ( ! function_exists( 'um_theme_remove_old_css' ) ) {
    function um_theme_remove_old_css() {
       wp_dequeue_style( 'um_default_css' );
       wp_dequeue_style( 'um_old_css' );
    }
}


/*--------------------------------------------------------------
## 2.0 Ultimate Member Logged in Header components.
--------------------------------------------------------------*/

if ( 2 === (int) $defaults['um_header_profile_position'] ) {
    add_action( 'um_theme_header_profile_before', 'um_theme_header_friend_request_modal', 1 );
    add_action( 'um_theme_header_profile_before', 'um_theme_header_activity_modal', 2 );
    /**
     * Rearrange Notification Icon.
     */
    if ( function_exists( 'um_notifications_check_dependencies' ) ) {
       add_action( 'init', 'um_notification_rearrrange', 10 );
    }

} else {
    add_action( 'um_theme_header_profile_after', 'um_theme_header_friend_request_modal', 15 );
    add_action( 'um_theme_header_profile_after', 'um_theme_header_activity_modal', 20 );
    /**
     * Rearrange Notification Icon.
     */
    if ( function_exists( 'um_notifications_check_dependencies' ) ) {
       add_action( 'init', 'um_notification_rearrrange', 10 );
    }
}

/**
 * Outputs the Messenger Modal in Header.
 */
if ( ! function_exists( 'um_theme_header_friend_request_modal' ) ) {
    function um_theme_header_friend_request_modal() {

        global $defaults;

        if (
            is_user_logged_in() &&
            class_exists( 'UM' ) &&
            class_exists( 'UM_Friends_API' )&&
            (int) $defaults['um_show_header_friend_requests'] === 1
        ) {
            (int) $count = UM()->Friends_API()->api()->count_friend_requests_received( get_current_user_id() ); ?>
            <div class="header-friend-requests">
            <div class="dropdown msg-drop" aria-label="<?php _e( 'Friend Requests', 'um-theme' );?>" data-balloon-pos="down">

                <i class="um-friend-tick fas fa-user-friends dropdown-togglu" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>

                <?php if ( (int) $count !== 0 ) : ?>
                    <span class="um-friend-req-live-count"><?php echo absint( $count );?></span>
                <?php endif;?>
                <ul class="dropdown-menu friends-drop-menu" aria-labelledby="dropdownMenuButton">
                    <div class="um-theme-dropdown-header">
                       <h6 class="boot-m-0"><?php esc_html_e( 'Friend Requests', 'um-theme' );?></h6>
                    </div>
                    <?php um_theme_header_get_friend_requests();?>
                </ul>
            </div>
            </div>
        <?php
        }
    }
}

/**
 * Outputs the Messenger Modal in Header.
 */
if ( ! function_exists( 'um_theme_header_activity_modal' ) ) {
    function um_theme_header_activity_modal() {

        global $defaults;

        if (
            is_user_logged_in() &&
            class_exists( 'UM' ) &&
            class_exists( 'UM_Messaging_API' ) &&
            (int) $defaults['um_show_header_messenger'] === 1
        ) {
            (int) $count = UM()->Messaging_API()->api()->get_unread_count( get_current_user_id() ); ?>
            <div class="header-messenger-box">
            <div class="dropdown msg-drop" aria-label="<?php _e( 'Messages', 'um-theme' );?>" data-balloon-pos="down">

                <i class="um-msg-tik-ico far fa-envelope dropdown-togglu" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                <?php if ( (int) $count !== 0 ) : ;?>
                    <span class="um-message-live-count"><?php echo absint( $count );?></span>
                <?php endif;?>
                <ul class="dropdown-menu msg-drop-menu" aria-labelledby="dropdownMenuButton">
                    <?php um_theme_get_recent_messages();?>
                </ul>
            </div>
            </div>
        <?php
        }
    }
}


/**
 * Re-arrange the Ultimate Member notification position.
 */
if ( ! function_exists( 'um_notification_rearrrange' ) ) {
    function um_notification_rearrrange() {
        if ( function_exists( 'um_notifications_check_dependencies' ) ) {
            global $defaults;
            if ( 2 === (int) $defaults['um_show_floating_notification'] ) {
                remove_action( 'wp_footer', 'um_notification_show_feed', 99999999999 );
            }

            if ( 2 === (int) $defaults['um_header_profile_position'] ) {
                add_action( 'um_theme_header_profile_before', 'um_theme_header_notification_modal', 3 );
            } else {
                add_action( 'um_theme_header_profile_after', 'um_theme_header_notification_modal', 25 );
            }
        }
    }
}

/*--------------------------------------------------------------
## 3.0 Ultimate Member - User Profile
--------------------------------------------------------------*/

/**
 * Add Sidebar to Ultimate Member profile Pages.
 */
add_action( 'init', 'force_um_profile_sidebar', 2 );

if ( ! function_exists( 'force_um_profile_sidebar' ) ) {
    function force_um_profile_sidebar(){
        add_action( 'um_profile_menu', 'um_theme_profile_layout_one_open', 10 );
        add_action( 'um_profile_menu_after', 'um_theme_profile_layout_one_close', 10 );
        add_action( 'um_profile_menu_after', 'um_theme_profile_layout_one_sidebar', 15 );
        add_action( 'um_profile_menu_after', 'um_theme_profile_layout_one_close', 20 );
    }
}

/**
 * UM Profile Page wrapper opening.
 */
if ( ! function_exists( 'um_theme_profile_layout_one_open' ) ) {
    function um_theme_profile_layout_one_open() {
        ?>
        <div class="um-profile-content-container">
        <div class="boot-row">
            <div class="<?php um_get_profile_sidebar_status();?> um-theme-profile-single-content">
            <div class="um-theme-profile-single-content-container">
    <?php
    }
}

/**
 * UM Profile Page sidebar status.
 */
if ( ! function_exists( 'um_get_profile_sidebar_status' ) ) {
    function um_get_profile_sidebar_status() {
        if ( is_active_sidebar( 'sidebar-profile' ) ) {
            echo 'boot-col-md-8';
        } else {
            echo 'boot-col-md-12';
        }
    }
}

/**
 * UM Profile Page wrapper closing.
 */
if ( ! function_exists( 'um_theme_profile_layout_one_close' ) ) {
    function um_theme_profile_layout_one_close() {
        echo '</div>';
        echo '</div>';
    }
}

/**
 * UM Profile Page Sidebar.
 */
if ( ! function_exists( 'um_theme_profile_layout_one_sidebar' ) ) {
    function um_theme_profile_layout_one_sidebar() {
        if ( is_active_sidebar( 'sidebar-profile' ) ) { ?>
            <div class="boot-col-md-4 um-theme-profile-single-sidebar">
            <div class="um-theme-profile-single-sidebar-container">
                <?php dynamic_sidebar( 'sidebar-profile' ); ?>
            </div>
            </div>
        <?php }
    }
}

/**
 * Components for Profile Layout One
 */
if ( ! function_exists( 'um_theme_below_profile_layout_one_image_open' ) ) {
    function um_theme_below_profile_layout_one_image_open() {
        echo '<div class="um-below-profile-one">';
    }
}

if ( ! function_exists( 'um_theme_below_profile_layout_one_image_close' ) ) {
    function um_theme_below_profile_layout_one_image_close() {
        echo '</div>';
    }
}

function um_theme_profile_layout_one_header( $args ){
    $default_size   = str_replace( 'px', '', $args['photosize'] );
    $overlay        = '<span class="um-profile-photo-overlay"><span class="um-profile-photo-overlay-s"><ins><i class="um-faicon-camera"></i></ins></span></span>';

    do_action( 'um_pre_header_editprofile', $args ); ?>

                <div class="um-profile-photo" data-user_id="<?php echo um_profile_id(); ?>">

                    <a href="<?php echo esc_url( um_user_profile_url() ); ?>" class="um-profile-photo-img" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
                       <?php echo $overlay . get_avatar( um_user( 'ID' ), $default_size ); ?>
                    </a>

                    <?php
                        if ( ! isset( UM()->user()->cannot_edit ) ) {

                            UM()->fields()->add_hidden_field( 'profile_photo' );

                            if ( ! um_profile( 'profile_photo' ) ) { // has profile photo

                                $items = array(
                                    '<a href="#" class="um-manual-trigger" data-parent=".um-profile-photo" data-child=".um-btn-auto-width">' . __( 'Upload photo', 'um-theme' ) . '</a>',
                                    '<a href="#" class="um-dropdown-hide">' . __( 'Cancel', 'um-theme' ) . '</a>',
                                );

                                $items = apply_filters( 'um_user_photo_menu_view', $items );

                                echo UM()->profile()->new_ui( 'bc', 'div.um-profile-photo', 'click', $items );

                            } elseif ( UM()->fields()->editing == true ) {

                                $items = array(
                                    '<a href="#" class="um-manual-trigger" data-parent=".um-profile-photo" data-child=".um-btn-auto-width">' . __( 'Change photo', 'um-theme' ) . '</a>',
                                    '<a href="#" class="um-reset-profile-photo" data-user_id="' . um_profile_id() . '" data-default_src="' . um_get_default_avatar_uri() . '">' . __( 'Remove photo', 'um-theme' ) . '</a>',
                                    '<a href="#" class="um-dropdown-hide">' . __( 'Cancel', 'um-theme' ) . '</a>',
                                );

                                $items = apply_filters( 'um_user_photo_menu_edit', $items );

                                echo UM()->profile()->new_ui( 'bc', 'div.um-profile-photo', 'click', $items );
                            }
                        }
                    ?>
                </div>

                <div class="um-profile-meta boot-d-block boot-d-sm-none">

                    <?php do_action( 'um_before_profile_main_meta', $args ); ?>

                    <div class="um-main-meta">

                        <?php if ( $args['show_name'] ) { ?>
                            <div class="um-name">
                                <a href="<?php echo esc_url( um_user_profile_url() );?>" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
                                    <?php echo um_user( 'display_name', 'html' ); ?>
                                </a>

                                <?php do_action( 'um_after_profile_name_inline', $args ); ?>
                            </div>
                        <?php } ?>

                        <div class="um-clear"></div>

                        <?php do_action( 'um_after_profile_header_name_args', $args ); ?>

                        <?php do_action( 'um_after_profile_header_name' ); ?>

                    </div>

                    <?php if ( isset( $args['metafields'] ) && ! empty( $args['metafields'] ) ) { ?>
                        <div class="um-meta">
                            <?php echo UM()->profile()->show_meta( $args['metafields'] ); ?>
                        </div>
                    <?php } ?>

<?php
            $description_key = UM()->profile()->get_show_bio_key( $args );

            if ( UM()->fields()->viewing == true && um_user( $description_key ) && $args['show_bio'] ) { ?>

                <div class="um-meta-text">
                    <?php $description = get_user_meta( um_user( 'ID' ), $description_key, true );

                    if ( UM()->options()->get( 'profile_show_html_bio' ) ) {
                        echo make_clickable( wpautop( wp_kses_post( $description ) ) );
                    } else {
                        echo esc_html( $description );
                    } ?>
                </div>

            <?php } elseif ( UM()->fields()->editing == true && $args['show_bio'] ) { ?>

                <div class="um-meta-text">
                    <textarea id="um-meta-bio"
                              data-character-limit="<?php echo esc_attr( UM()->options()->get( 'profile_bio_maxchars' ) ); ?>"
                              placeholder="<?php esc_attr_e( 'Tell us a bit about yourself...', 'um-theme' ); ?>"
                              name="<?php echo esc_attr( $description_key . '-' . $args['form_id'] ); ?>"
                              id="<?php echo esc_attr( $description_key . '-' . $args['form_id'] ); ?>"><?php echo UM()->fields()->field_value( $description_key ) ?></textarea>
                    <span class="um-meta-bio-character um-right"><span
                            class="um-bio-limit"><?php echo UM()->options()->get( 'profile_bio_maxchars' ); ?></span></span>

                    <?php if ( UM()->fields()->is_error( $description_key ) ) {
                        echo UM()->fields()->field_error( UM()->fields()->show_error( $description_key ), true );
                    } ?>

                </div>

            <?php } ?>

            <div class="um-profile-status <?php echo esc_attr( um_user( 'account_status' ) ); ?>">
                <span><?php printf( __( 'This user account status is %s', 'um-theme' ), um_user( 'account_status_name' ) ); ?></span>
            </div>


                    <?php do_action( 'um_after_header_meta', um_user( 'ID' ), $args ); ?>

                </div>
                <?php
}

function um_theme_profile_layout_two_header( $args ){
    $default_size   = str_replace( 'px', '', $args['photosize'] );
    $overlay        = '<span class="um-profile-photo-overlay"><span class="um-profile-photo-overlay-s"><ins><i class="um-faicon-camera"></i></ins></span></span>';

    do_action( 'um_pre_header_editprofile', $args ); ?>

                <div class="um-profile-photo" data-user_id="<?php echo um_profile_id(); ?>">

                    <a href="<?php echo esc_url( um_user_profile_url() ); ?>" class="um-profile-photo-img" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
                       <?php echo $overlay . get_avatar( um_user( 'ID' ), $default_size ); ?>
                    </a>

                    <?php
                        if ( ! isset( UM()->user()->cannot_edit ) ) {

                            UM()->fields()->add_hidden_field( 'profile_photo' );

                            if ( ! um_profile( 'profile_photo' ) ) { // has profile photo

                                $items = array(
                                    '<a href="#" class="um-manual-trigger" data-parent=".um-profile-photo" data-child=".um-btn-auto-width">' . __( 'Upload photo', 'um-theme' ) . '</a>',
                                    '<a href="#" class="um-dropdown-hide">' . __( 'Cancel', 'um-theme' ) . '</a>',
                                );

                                $items = apply_filters( 'um_user_photo_menu_view', $items );

                                echo UM()->profile()->new_ui( 'bc', 'div.um-profile-photo', 'click', $items );

                            } elseif ( UM()->fields()->editing == true ) {

                                $items = array(
                                    '<a href="#" class="um-manual-trigger" data-parent=".um-profile-photo" data-child=".um-btn-auto-width">' . __( 'Change photo', 'um-theme' ) . '</a>',
                                    '<a href="#" class="um-reset-profile-photo" data-user_id="' . um_profile_id() . '" data-default_src="' . um_get_default_avatar_uri() . '">' . __( 'Remove photo', 'um-theme' ) . '</a>',
                                    '<a href="#" class="um-dropdown-hide">' . __( 'Cancel', 'um-theme' ) . '</a>',
                                );

                                $items = apply_filters( 'um_user_photo_menu_edit', $items );

                                echo UM()->profile()->new_ui( 'bc', 'div.um-profile-photo', 'click', $items );
                            }
                        }
                    ?>
                </div>

                <div class="um-profile-meta">

                    <?php do_action( 'um_before_profile_main_meta', $args ); ?>

                    <div class="um-main-meta">

                        <?php if ( $args['show_name'] ) { ?>
                            <div class="um-name">
                                <a href="<?php echo esc_url( um_user_profile_url() );?>" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
                                    <?php echo um_user( 'display_name', 'html' ); ?>
                                </a>

                                <?php do_action( 'um_after_profile_name_inline', $args ); ?>
                            </div>
                        <?php } ?>

                        <div class="um-clear"></div>

                        <?php do_action( 'um_after_profile_header_name_args', $args ); ?>

                        <?php do_action( 'um_after_profile_header_name' ); ?>

                    </div>

                    <?php if ( isset( $args['metafields'] ) && ! empty( $args['metafields'] ) ) { ?>
                        <div class="um-meta">
                            <?php echo UM()->profile()->show_meta( $args['metafields'] ); ?>
                        </div>
                    <?php } ?>

                    <?php do_action( 'um_after_header_meta', um_user( 'ID' ), $args ); ?>

                </div>
                <?php
}

/**
 * Components for Profile Layout Two
 */
if ( ! function_exists( 'um_theme_below_profile_layout_two_image_open' ) ) {
    function um_theme_below_profile_layout_two_image_open() {
        echo '<div class="um-below-profile-two">';
    }
}

if ( ! function_exists( 'um_theme_below_profile_layout_two_image_close' ) ) {
    function um_theme_below_profile_layout_two_image_close() {
        echo '</div>';
    }
}

/**
 * Components for Profile Layout Two
 */
if ( ! function_exists( 'um_theme_below_profile_layout_three_image_open' ) ) {
    function um_theme_below_profile_layout_three_image_open() {
        echo '<div class="um-below-profile-three">';
    }
}

/*--------------------------------------------------------------
## 3.0 UM Notifications
--------------------------------------------------------------*/

/**
 * UM Notification from Notifications_API
 */
if ( ! function_exists( 'um_theme_notification_show_feed' ) ) {
    function um_theme_notification_show_feed() {

        if ( ! is_user_logged_in() ) {
            return;
        }

        if ( ! class_exists( 'UM_Notifications_API' ) ) {
            return;
        }

        $notifications  = UM()->Notifications_API()->api()->get_notifications( 10 );

        echo UM()->Notifications_API()->shortcode()->ultimatemember_notifications();

        if ( $notifications ) : ?>
            <div class="meta notfication-see-all">
                <a href="<?php echo esc_url( um_get_core_page( 'notifications' ) );?>"><?php _e( 'See All Notifications', 'um-theme' ); ?></a>
            </div>
        <?php endif;
    }
}

/**
 * Outputs the Notification Modal in Header.
 */
if ( ! function_exists( 'um_theme_header_notification_modal' ) ) {
    function um_theme_header_notification_modal() {

        global $defaults;

        if (    is_user_logged_in() &&
                class_exists( 'UM' ) &&
                class_exists( 'UM_Notifications_API' ) &&
                1 === (int) $defaults['um_show_header_notification']
            ) {

            $notifications  = UM()->Notifications_API()->api()->get_notifications( 10 );
            $unread         = (int) UM()->Notifications_API()->api()->get_notifications( 0, 'unread', true );
            $unread_count   = ( absint( $unread ) > 9 ) ? '+9' : $unread;
            ?>

            <div class="header-notification-box">
            <div class="dropdown msg-drop" aria-label="<?php _e( 'Notifications', 'um-theme' );?>" data-balloon-pos="down">
                <i class="um-notification-ico far fa-bell dropdown-togglu" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                <?php if ( (int) $unread_count !== 0 ) : ;?>
                    <span class="um-notification-live-count"><?php echo absint( $unread_count );?></span>
                <?php endif;?>
                <ul class="dropdown-menu msg-drop-menu" aria-labelledby="dropdownMenuButton">
                    <?php um_theme_notification_show_feed();?>
                </ul>
            </div>
            </div>
        <?php
        }
    }
}


/*--------------------------------------------------------------
## 4.0 UM Groups
--------------------------------------------------------------*/

/**
 * Apply layout for UM Group extension.
 */
if ( class_exists( 'UM' ) && function_exists( 'um_groups_plugins_loaded' ) ) {
    add_action( 'init', 'um_theme_apply_group_list_layout' );
}

if ( ! function_exists( 'um_theme_apply_group_list_layout' ) ) {
    function um_theme_apply_group_list_layout(){
        remove_action('um_groups_directory','um_groups_directory');
        remove_action('um_groups_directory_search_form','um_groups_directory_search_form');
        remove_action('um_groups_directory_tabs','um_groups_directory_tabs');
        add_action('um_groups_directory','um_theme_um_groups_directory');
        add_action('um_groups_directory_tabs','um_theme_um_groups_directory_tabs');
        add_action('um_groups_directory_search_form','um_theme_um_groups_directory_search_form');
    }
}

/**
 * Display groups directory
 */
if ( ! function_exists( 'um_theme_um_groups_directory' ) ) {
function um_theme_um_groups_directory( $args ){
    global $defaults;
    wp_enqueue_script( 'um_groups' );
    wp_enqueue_style( 'um_groups' );

    if ( um_groups('total_groups') > 0 ) {

        if ( 1 === (int) $defaults['um_theme_ext_um_group_list_layout'] ) {
            echo '<div class="um-groups-directory">';
        } else {
            echo '<div class="um-groups-directory boot-row">';
        }

        foreach( um_groups('groups') as $group ):
                $slug = UM()->Groups()->api()->get_privacy_slug( $group->ID );
                $count = um_groups_get_member_count( $group->ID );
                ?>

                <?php if ( 1 === (int) $defaults['um_theme_ext_um_group_list_layout'] ) : ?>
                <?php
                echo '<div class="um-group-item">';

                    if( true == $args['show_actions'] ) {
                        echo '<div class="actions">';
                        echo '<ul>';

                            echo '<li>';
                                do_action('um_groups_join_button', $group->ID );
                            echo '</li>';

                            echo '<li class="count-members">';
                            echo '<span class="group-meta-info">';
                            echo sprintf( _n( '<span>%s</span> member', '<span>%s</span> members', $count, 'um-theme' ), number_format_i18n( $count ) );
                            echo '</span>';
                            echo '</li>';

                            echo '<li class="last-active">';
                            echo '<span class="group-meta-info">';
                                echo '<span>';
                                echo __('active, ','um-theme').human_time_diff( UM()->Groups()->api()->get_group_last_activity( $group->ID, true ) ).__(' ago','um-theme');
                                echo '</span>';
                            echo '</span>';
                            echo '</li>';

                        echo '</ul>';
                        echo '</div>';
                    }

                    echo '<a href="'.get_permalink( $group->ID ).'">';
                        if( 'small' == $args['avatar_size'] ){
                            echo UM()->Groups()->api()->get_group_image( $group->ID, 'default', 50, 50 );
                        }else{
                            echo UM()->Groups()->api()->get_group_image( $group->ID, 'default', 100, 100 );
                        }
                        echo "<h4 class='um-group-name'>".get_the_title( $group->ID )."</h4>";
                    echo '</a>';

                    echo '<div class="um-group-meta">';
                        echo '<ul>';
                        echo '<li class="privacy">';
                        echo '<span class="group-meta-info">';
                        echo um_groups_get_privacy_icon( $group->ID );
                        echo sprintf( __('%s Group', 'um-theme' ), um_groups_get_privacy_title( $group->ID ) );
                        echo '</span>';
                        echo '</li>';
                        echo '<li class="description">' ;
                        echo $group->post_content;
                        echo '</li>';
                        echo '</ul>';
                    echo '</div>';
                    echo '<div class="um-clear"></div>';


                echo '</div>';
                echo '<div class="um-clear"></div>';
                ?>
                    <?php elseif ( 2 === (int) $defaults['um_theme_ext_um_group_list_layout'] ) : ?>
                        <div class="boot-col-md-12">
                        <div class="um-group-item slim-box-container boot-row">
                        <div class="boot-col-md-3 um-group-image-container">
                            <a href="<?php echo esc_url( get_permalink( $group->ID ) );?>">
                                <?php
                                    if( 'small' == $args['avatar_size'] ){
                                        echo UM()->Groups()->api()->get_group_image( $group->ID, 'default', 50, 50 );
                                    }else{
                                        echo UM()->Groups()->api()->get_group_image( $group->ID, 'default', 250, 250 );
                                    }
                                ?>
                            </a>
                        </div>

                        <div class="boot-col-md-6 um-group-text-container">
                            <a href="<?php echo esc_url( get_permalink( $group->ID ) );?>"><h4 class='um-group-name'><?php echo get_the_title( $group->ID );?></h4></a>

                            <div class="um-group-meta">
                                <ul>
                                    <li class="privacy">
                                        <span class="group-meta-info">
                                        <?php echo um_groups_get_privacy_icon( $group->ID );?>
                                        <?php echo sprintf( __('%s Group', 'um-theme' ), um_groups_get_privacy_title( $group->ID ) );?>
                                        </span>
                                    </li>
                                </ul>
                            </div>

                            <?php if ( true == wp_validate_boolean($defaults['um_theme_ext_um_group_show_group_description'] )) : ?>
                                <p class="group-description"><?php echo $group->post_content;?></p>
                            <?php endif;?>
                        </div>

                        <div class="boot-col-md-3 um-group-button-container">
                            <?php if( true == $args['show_actions'] ) : ?>
                                <div class="actions">
                                    <ul>
                                        <li><?php do_action('um_groups_join_button', $group->ID );?></li>
                                    </ul>
                                </div>
                            <?php endif;?>

                                <?php if( true == $args['show_actions'] ) : ?>
                                    <div class="actions">
                                        <ul>
                                            <li class="count-members">
                                                <span class="group-meta-info">
                                                <?php esc_html_e( 'Total Members:', 'um-theme' );?>
                                                <?php echo sprintf( _n( '<span>%s</span> member', '<span>%s</span> members', $count, 'um-theme' ), number_format_i18n( $count ) );?>
                                                </span>
                                            </li>
                                            <li class="last-active">
                                                <span class="group-meta-info">
                                                <?php esc_html_e( 'Recent Activity:', 'um-theme' );?>
                                                <span><?php echo human_time_diff( UM()->Groups()->api()->get_group_last_activity( $group->ID, true ) ).__(' ago','um-theme');?></span>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                <?php endif;?>


                        </div>
                        </div>
                        </div>
                    <?php else : ?>
                        <div class="group-grid boot-col-md-4">
                        <div class="group-grid-inner">

                            <div class="um-group-image-container">
                                <a href="<?php echo esc_url( get_permalink( $group->ID ) );?>">
                                    <?php
                                        if( 'small' == $args['avatar_size'] ){
                                            echo UM()->Groups()->api()->get_group_image( $group->ID, 'default', 50, 50 );
                                        }else{
                                            echo UM()->Groups()->api()->get_group_image( $group->ID, 'default', 250, 250 );
                                        }
                                    ?>
                                </a>
                            </div>

                            <div class="um-group-text-container">
                                <a href="<?php echo esc_url( get_permalink( $group->ID ) );?>"><h4 class='um-group-name'><?php echo get_the_title( $group->ID );?></h4></a>
                                <div class="um-group-meta">
                                    <ul>
                                        <li class="privacy">
                                            <span class="group-meta-info">
                                            <?php echo um_groups_get_privacy_icon( $group->ID );?>
                                            <?php echo sprintf( __('%s Group', 'um-theme' ), um_groups_get_privacy_title( $group->ID ) );?>
                                            </span>
                                        </li>
                                    </ul>
                                </div>

                            <?php if ( true == $defaults['um_theme_ext_um_group_show_group_description'] ) : ?>
                                <p class="group-description"><?php echo $group->post_content;?></p>
                            <?php endif;?>

                            </div>

                            <div class="um-group-button-container">


                                <?php if( true == $args['show_actions'] ) : ?>
                                    <div class="actions">
                                        <ul>
                                            <li class="count-members">
                                                <span class="group-meta-info">
                                                <?php esc_html_e( 'Total Members:', 'um-theme' );?>
                                                <?php echo sprintf( _n( '<span>%s</span> member', '<span>%s</span> members', $count, 'um-theme' ), number_format_i18n( $count ) );?>
                                                </span>
                                            </li>
                                            <li class="last-active">
                                                <span class="group-meta-info">
                                                <?php esc_html_e( 'Recent Activity:', 'um-theme' );?>
                                                <span><?php echo human_time_diff( UM()->Groups()->api()->get_group_last_activity( $group->ID, true ) ).__(' ago','um-theme');?></span>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                <?php endif;?>



                                <?php if( true == $args['show_actions'] ) : ?>
                                    <div class="actions">
                                        <ul>
                                            <li><?php do_action('um_groups_join_button', $group->ID );?></li>
                                        </ul>
                                    </div>
                                <?php endif;?>

                            </div>

                        </div>
                        </div>
                    <?php endif; ?>

        <?php endforeach;?>

       </div>
       <?php
        // Restore original Post Data
    } else {
        _e('No groups found.','um-theme');
    }
}
}


/**
 * Groups directory tabs
 */
if ( ! function_exists( 'um_theme_um_groups_directory_tabs' ) ) {
    function um_theme_um_groups_directory_tabs( $args ){
        wp_enqueue_script( 'um_groups' );
        wp_enqueue_style( 'um_groups' );

        if( false == $args['show_total_groups_count'] || um_is_core_page('my_groups') ) return;

        $filter = get_query_var('filter');
        ?>

        <div id="um-groups-filters" class="um-groups-found-posts">
            <ul class="filters">
                <li class="all <?php echo ( 'all' == $filter || empty( $filter ) ? 'active': '' );?>">
                    <a href="<?php echo esc_url( um_get_core_page('groups') );?>" class="group-filter-item-link">
                        <span class="group-filter-item"><?php echo sprintf( __('All Groups <span>%s</span>','um-theme'), um_groups_get_all_groups_count() );?></span>
                    </a>
                </li>

                <?php if( is_user_logged_in() ) : ?>
                    <li class="own <?php echo ( 'own' == $filter ? 'active': '' );?>">
                        <a href="<?php echo esc_url( um_get_core_page('groups') );?>?filter=own" class="group-filter-item">
                            <?php echo sprintf( __('My Groups <span>%s</span>', 'um-theme'), um_groups_get_own_groups_count() );?>
                        </a>
                    </li>
                    <li class="create">
                        <a href="<?php echo esc_url( um_get_core_page('create_group') );?>" class="group-filter-item">
                            <?php echo __('Create a Group', 'um-theme');?>
                        </a>
                    </li>
                <?php endif;?>
            </ul>
        </div>
    <?php
    }
}


/**
 * Group directory search form
 */
if ( ! function_exists( 'um_theme_um_groups_directory_search_form' ) ) {
    function um_theme_um_groups_directory_search_form( $args ){

        if( 0 == $args['show_search_form'] ) return;

        wp_enqueue_script( 'um_groups' );
        wp_enqueue_style( 'um_groups' );

        $search = get_query_var('groups_search');
        $filter = get_query_var('filter');
        ?>


        <div class="um-groups-directory-header">
        <form class="um-groups-search-form">

        <div class="boot-row">
            <div class="boot-col-md-5">
                <?php echo '<input type="text" name="groups_search" placeholder="'.__('Search groups...', 'um-theme' ).'" value="'.esc_attr( $search ).'"/>';?>
            </div>
            <div class="group-search-filter boot-col-md-7">
                <?php

                if( 1 == $args['show_search_categories'] ){

                    $cat = get_query_var('cat');

                    $arr_categories = um_groups_get_categories();

                    echo "<select name=\"cat\">";
                    echo "<option value=\"\">".__("All Categories","um-theme")."</option>";
                    if( ! empty( $arr_categories ) ){
                        foreach( $arr_categories as $value => $title ){
                            echo "<option value=\"{$value}\" ". selected( $cat, $value, false ) .">{$title}</option>";
                        }
                    }
                    echo "</select>";

                }

                if( 1 == $args['show_search_tags'] ){

                    $tags = get_query_var('tags');

                    $arr_tags = um_groups_get_tags();

                    echo "<select name=\"tags\" >";
                    echo "<option value=\"\">".__("All Tags","um-theme")."</option>";
                    if( ! empty( $arr_tags ) ){
                        foreach( $arr_tags as $value => $title ){
                            echo "<option value=\"{$value}\" ". selected( $tags, $value, false ) ." >{$title}</option>";
                        }
                    }
                    echo "</select>";

                }

                if( 'own' == $filter ){
                    echo '<input type="hidden" name="filter" value="'. esc_attr( $filter ) .'" />';
                }

                echo '<input type="submit" class="" value="'.__('Search', 'um-theme' ).'"/> ';
                echo '<a href="'. get_the_permalink() .'" class="primary-button">'.__('Clear', 'um-theme' ).'</a>';
                ?>
            </div>
        </div>
        </form>
         <div class="um-clear"></div>
        </div>
        <?php
    }
}


/*--------------------------------------------------------------
## 5.0 UM Friends
--------------------------------------------------------------*/


if ( ! function_exists( 'um_theme_friends_add_button' ) ) {
    function um_theme_friends_add_button( $args ) {
        if ( class_exists( 'UM_Friends_API' ) ) {
            $user_id = absint( um_profile_id() );
            echo '<div class="um-friends-nocoverbtn" style="display: block">' . UM()->Friends_API()->api()->friend_button( $user_id, get_current_user_id() ) . '</div>';
        }
    }
}


if ( ! function_exists( 'um_theme_friend_box_profile' ) ) {
    function um_theme_friend_box_profile() {
        global $defaults;

        if (
            class_exists( 'UM_Friends_API' ) &&
            1 === (int) $defaults['um_show_profile_friend_requests']
        ) {

            $friends_defaults = array(
                'user_id'       => ( um_is_core_page( 'user' ) ) ? um_profile_id() : get_current_user_id(),
                'style'         => 'default',
                'max'           => 12
            );

            $args = wp_parse_args( $friends_defaults );
            extract( $args );

            ob_start();

            $friends        = UM()->Friends_API()->api()->friends( $user_id );
            (int) $count    = UM()->Friends_API()->api()->count_friends_plain( $user_id );
        ?>
            <div class="um-friends-list" data-max="<?php echo absint( $max );?>">
                <div class="um-friends-list-header">
                    <p class="um-friends-list-header-title">
                        <?php esc_html_e( 'Friends', 'um-theme' );?> - <span class="um-accent-color"><?php echo absint( $count );?></span>
                    </p>
                </div>
            <?php $total_friends_count = 0; ?>
            <?php if ( $friends ) { ?>

                <?php foreach ( $friends as $k => $arr ) {
                    extract( $arr );
                    $total_friends_count++;

                    if ( $user_id2 == $user_id ) {
                        $user_id2 = $user_id1;
                    }

                    um_fetch_user( $user_id2 );
                ?>

                    <div class="um-friends-list-user">
                        <a href="<?php echo esc_url( um_user_profile_url() ); ?>" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
                        <div class="um-friends-list-pic">
                            <?php echo get_avatar( um_user( 'ID' ), 40 ); ?>
                        </div>
                        <p class="um-friends-list-name"><?php echo esc_html( um_user( 'first_name' ) ); ?></p>
                        </a>
                    </div>

                <?php } ?>

            <?php } else { ?>
                <p><?php echo ( $user_id === get_current_user_id()  ) ? __( 'You do not have any friends yet.','um-theme' ) : __( 'This user does not have any friends yet.','um-theme' ); ?></p>
            <?php } ?>

            </div>

        <?php
                $user_friends_box = ob_get_contents();
                ob_end_clean();
                echo $user_friends_box;
        }
    }
}


/**
 * Outputs the Friend Request Modal in Header.
 */
if ( ! function_exists( 'um_theme_header_get_friend_requests' ) ) {
    function um_theme_header_get_friend_requests() {
        wp_enqueue_script( 'um_friends' );
        wp_enqueue_style( 'um_friends' );

        if ( ! class_exists( 'UM_Friends_API' ) ) {
        	return;
        }

        $friend_request     = UM()->Friends_API()->api()->friend_reqs( get_current_user_id() );
        $user_id            = get_current_user_id();
        $note               = __( 'You do not have pending friend requests yet.', 'um-theme' );

        if ( $friend_request ) {
            foreach ( $friend_request as $k => $arr ) {

                extract( $arr );

                if ( $user_id2 == $user_id ) {
                    $user_id2 = $user_id1;
                }

                um_fetch_user( $user_id2 ); ?>

                <div class="um-friends-user">
                <div class="boot-row">
                    <div class="boot-col-6 boot-col-md-2">
                        <a href="<?php echo esc_url( um_user_profile_url() ); ?>" class="um-friends-user-photo" title="<?php echo um_user('display_name'); ?>">
                            <?php echo get_avatar( um_user('ID'), 50 ); ?>
                        </a>
                    </div>

                    <div class="um-friends-user-name boot-col-6 boot-col-md-3">
                        <a href="<?php echo esc_url( um_user_profile_url() ); ?>" title="<?php echo um_user('display_name'); ?>">
                            <?php echo esc_attr( um_user('display_name') ); ?>
                        </a>
                    </div>

                    <div class="um-friends-user-btn boot-col-12 boot-col-md-7">
                        <?php
                            if ( $user_id2 === get_current_user_id() ) {
                                echo '<a href="' . um_edit_profile_url() . '" class="um-friend-edit um-button um-alt">' . __('Edit profile','um-theme') . '</a>';
                            } else {
                                echo UM()->Friends_API()->api()->friend_button( $user_id2, get_current_user_id(), true );
                            }
                        ?>
                    </div>
                </div>
                </div>

            <?php }
        } else { ?>

            <div class="um-profile-note">
                <span><?php echo esc_html( $note ); ?></span>
            </div>

        <?php }
    }
}


/*--------------------------------------------------------------
## 6.0 UM Message
--------------------------------------------------------------*/

/**
 * Remove Download Chat History link from Messenger.
 */
global $defaults;
if ( function_exists( 'um_messaging_plugins_loaded' ) ) {

    if (
        class_exists( 'UM_Messaging_API' ) &&
        2 === (int) $defaults['um_theme_ext_pm_message_hide_chat_history']
    ) {
        remove_action( 'um_messaging_after_conversation_links', array( UM()->Messaging_API()->gdpr(), 'render_download_chat_link' ), 99, 2 );
        remove_action( 'um_messaging_after_conversations_list', array( UM()->Messaging_API()->gdpr(), 'render_download_all_chats_link' ), 99 );
    }
}

/**
 * Prints out the Private Messeage Conversation.
 */
if ( ! function_exists( 'um_get_conversation' ) ) {
    function um_get_conversation( $user1, $user2, $conversation_id = null ) {

    global $defaults;

    (int) $selector_data = $defaults['um_displayname_header_messenger'];

    	if ( ! class_exists( 'UM_Messaging_API' ) ) {
    		return;
    	}

        global $wpdb;
        $table_name2 = $wpdb->prefix . "um_messages";

        // No conversation yet.
        if ( ! $conversation_id || $conversation_id <= 0 ) return;

        // Get conversation ordered by time and show only 1000 messages.
        $messages = $wpdb->get_results( $wpdb->prepare(
            "SELECT *
            FROM {$table_name2}
            WHERE conversation_id = %d
            ORDER BY time DESC LIMIT 3",
            $conversation_id
        ) );

        $response       = null;
        $update_query   = false;
        $messages_link  = add_query_arg( array( 'profiletab' => 'messages', 'conversation_id' => $conversation_id ), um_user_profile_url( get_current_user_id() ) );

        $value = json_decode( wp_json_encode( $messages ), true );
        ?>

        <?php if ( isset( $value[0] ) ) { ?>
            <a href="<?php echo esc_url( $messages_link );?>" class="message-status-<?php echo $value[0]['status'];?>">
            <div class="boot-row header-msg-holder">

                <div class="boot-col-2 header-msg-ava">
                    <?php
                        if ( get_current_user_id() === absint( $value[0]['recipient'] ) ) {
                            echo get_avatar( $value[0]['author'], 40 );
                        } else {
                            echo get_avatar( $value[0]['recipient'], 40 );
                        }
                    ?>
                </div>

                <div class="boot-col-10 header-msg-con">
                <div class="boot-row">
                    <?php if ( get_current_user_id() === absint( $value[0]['recipient'] ) ) : ?>

                        <div class="boot-col-8 messenger-username">
                            <strong><?php um_message_header_name_selector( $value, 'author', $selector_data );?></strong>
                        </div>
                        <div class="boot-col-4 boot-text-right">
                            <span class="meta"><?php echo UM()->Messaging_API()->api()->beautiful_time( $value[0]['time'], 'right_m' );?></span>
                        </div>

                    <?php else : ?>
                        <div class="boot-col-8 messenger-username">
                            <strong><?php um_message_header_name_selector( $value, 'recipient', $selector_data );?></strong>
                        </div>
                        <div class="boot-col-4 boot-text-right">
                            <span class="meta"><?php echo UM()->Messaging_API()->api()->beautiful_time( $value[0]['time'], 'right_m' );?></span>
                        </div>

                    <?php endif; ?>
                </div>
                <p class="messenger-text"><?php echo wp_kses_post( $value[0]['content'] );?></p>
                </div>
            </div>
            </a>
    <?php }
    }
}

function um_message_header_name_selector( $value, $author, $selector_data ){
    /**
    * $author
    * author || recipient
    */
    if ( $selector_data === 1 ){
        echo esc_html( get_user_meta( $value[0][$author], 'nickname', true ) );
    } elseif( $selector_data === 2 ){
        echo esc_html( get_user_meta( $value[0][$author], 'first_name', true ) );
    } elseif( $selector_data === 3 ){
        echo esc_html( get_user_meta( $value[0][$author], 'last_name', true ) );
    } else{
        echo esc_html( get_user_meta( $value[0][$author], 'first_name', true ) ) ." ". esc_html( get_user_meta( $value[0][$author], 'last_name', true ) );
    }
}

/**
 * Get the Private Messeage Conversation from Database.
 */
if ( ! function_exists( 'um_theme_get_recent_messages' ) ) {
    function um_theme_get_recent_messages() {

    	if ( ! class_exists( 'UM_Messaging_API' ) ) {
    		return;
    	}

        global $wpdb;

        $table_name    = $wpdb->prefix . "um_conversations";
        $user_id       = get_current_user_id();
        $sql_query     = "SELECT * FROM {$table_name} WHERE user_a = %d OR user_b = %d ORDER BY last_updated DESC LIMIT 3";

        $results = $wpdb->get_results( $wpdb->prepare( $sql_query, $user_id, $user_id ) );

        if ( $results ) {
            $value = json_decode( wp_json_encode( $results ), true );
            ?>
                <div class="um-theme-dropdown-header">
                   <h6 class="boot-m-0"><?php esc_html_e( 'Messages', 'um-theme' );?></h6>
                </div>

            <?php
                foreach ( $value as $key ) :
                    // Check if the member is blocked by the user.
                    if ( ! UM()->Messaging_API()->api()->blocked_user( $key['user_a'] ) ) {
                        // Check if it is a hidden conversation.
                        if ( ! UM()->Messaging_API()->api()->hidden_conversation( $key['conversation_id'] ) ) {
                            echo um_get_conversation( $key['user_a'], $key['user_b'] , $key['conversation_id'] );
                        }

                    }
                endforeach;
            ?>

            <a href="<?php echo esc_url( add_query_arg( 'profiletab', 'messages', um_user_profile_url( get_current_user_id() ) ) );?>">
                <small class="meta msg-see-all"><?php esc_html_e( 'See All Messages', 'um-theme' );?></small>
            </a>

        <?php } else { ?>
            <p class="no-messages">
                <i class="no-messages-icon um-icon-android-chat"></i>
                <?php esc_html_e( 'No Messages', 'um-theme' );?>
            </p>
            <?php
        }
    }
}


function um_theme_profile_layout_four_header( $args ){
    $default_size   = str_replace( 'px', '', $args['photosize'] );
    $overlay        = '<span class="um-profile-photo-overlay"><span class="um-profile-photo-overlay-s"><ins><i class="um-faicon-camera"></i></ins></span></span>';
?>

        <div class="boot-row boot-align-items-center">
            <div class="boot-col-md-3 um-profile-four-head-left">
                <div class="um-profile-photo" data-user_id="<?php echo um_profile_id(); ?>">

                    <a href="<?php echo esc_url( um_user_profile_url() ); ?>" class="um-profile-photo-img" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
                        <?php echo $overlay . get_avatar( um_user( 'ID' ), $default_size ); ?>
                    </a>

                    <?php
                        if ( ! isset( UM()->user()->cannot_edit ) ) {

                            UM()->fields()->add_hidden_field( 'profile_photo' );

                            if ( ! um_profile( 'profile_photo' ) ) { // has profile photo

                                $items = array(
                                    '<a href="#" class="um-manual-trigger" data-parent=".um-profile-photo" data-child=".um-btn-auto-width">' . __( 'Upload photo', 'um-theme' ) . '</a>',
                                    '<a href="#" class="um-dropdown-hide">' . __( 'Cancel', 'um-theme' ) . '</a>',
                                );

                                $items = apply_filters( 'um_user_photo_menu_view', $items );

                                echo UM()->profile()->new_ui( 'bc', 'div.um-profile-photo', 'click', $items );

                            } elseif ( UM()->fields()->editing == true ) {

                                $items = array(
                                    '<a href="#" class="um-manual-trigger" data-parent=".um-profile-photo" data-child=".um-btn-auto-width">' . __( 'Change photo', 'um-theme' ) . '</a>',
                                    '<a href="#" class="um-reset-profile-photo" data-user_id="' . um_profile_id() . '" data-default_src="' . um_get_default_avatar_uri() . '">' . __( 'Remove photo', 'um-theme' ) . '</a>',
                                    '<a href="#" class="um-dropdown-hide">' . __( 'Cancel', 'um-theme' ) . '</a>',
                                );

                                $items = apply_filters( 'um_user_photo_menu_edit', $items );

                                echo UM()->profile()->new_ui( 'bc', 'div.um-profile-photo', 'click', $items );
                            }
                        }
                    ?>
                </div>
            </div>

            <div class="boot-col-md-6 um-profile-four-head-center">
                <div class="um-profile-meta">

                    <?php do_action( 'um_before_profile_main_meta', $args ); ?>

                    <div class="um-main-meta">

                        <?php if ( $args['show_name'] ) { ?>
                            <div class="um-name">
                                <a href="<?php echo esc_url( um_user_profile_url() );?>" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
                                    <?php echo um_user( 'display_name', 'html' ); ?>
                                </a>

                                <?php do_action( 'um_after_profile_name_inline', $args ); ?>
                            </div>
                        <?php } ?>

                        <div class="um-clear"></div>

                        <?php do_action( 'um_after_profile_header_name_args', $args ); ?>

                        <?php do_action( 'um_after_profile_header_name' ); ?>

                        <?php do_action( 'um_profile_layout_four_second' );?>


                        <?php
            $description_key = UM()->profile()->get_show_bio_key( $args );

            if ( UM()->fields()->viewing == true && um_user( $description_key ) && $args['show_bio'] ) { ?>

                <div class="um-meta-text">
                    <?php $description = get_user_meta( um_user( 'ID' ), $description_key, true );

                    if ( UM()->options()->get( 'profile_show_html_bio' ) ) {
                        echo make_clickable( wpautop( wp_kses_post( $description ) ) );
                    } else {
                        echo esc_html( $description );
                    } ?>
                </div>

            <?php } elseif ( UM()->fields()->editing == true && $args['show_bio'] ) { ?>

                <div class="um-meta-text">
                    <textarea id="um-meta-bio"
                              data-character-limit="<?php echo esc_attr( UM()->options()->get( 'profile_bio_maxchars' ) ); ?>"
                              placeholder="<?php esc_attr_e( 'Tell us a bit about yourself...', 'um-theme' ); ?>"
                              name="<?php echo esc_attr( $description_key . '-' . $args['form_id'] ); ?>"
                              id="<?php echo esc_attr( $description_key . '-' . $args['form_id'] ); ?>"><?php echo UM()->fields()->field_value( $description_key ) ?></textarea>
                    <span class="um-meta-bio-character um-right"><span
                            class="um-bio-limit"><?php echo UM()->options()->get( 'profile_bio_maxchars' ); ?></span></span>

                    <?php if ( UM()->fields()->is_error( $description_key ) ) {
                        echo UM()->fields()->field_error( UM()->fields()->show_error( $description_key ), true );
                    } ?>

                </div>

            <?php } ?>

            <div class="um-profile-status <?php echo esc_attr( um_user( 'account_status' ) ); ?>">
                <span><?php printf( __( 'This user account status is %s', 'um-theme' ), um_user( 'account_status_name' ) ); ?></span>
            </div>
                    </div>
                </div>
            </div>

            <div class="boot-col-md-3 um-profile-four-head-right">

                <?php do_action( 'um_pre_header_editprofile', $args ); ?>

                <?php if ( isset( $args['metafields'] ) && ! empty( $args['metafields'] ) ) { ?>
                    <div class="um-meta">
                        <?php echo UM()->profile()->show_meta( $args['metafields'] ); ?>
                    </div>
                <?php } ?>

                <?php do_action( 'um_after_header_meta', um_user( 'ID' ), $args ); ?>
            </div>

    </div>
    <?php
}

if ( 3 === (int) $defaults['um_show_header_profile'] ) {
    add_action( 'um_theme_before_site', 'um_theme_floating_profilebar', 10 );
}

function um_theme_floating_profilebar(){
    if ( is_user_logged_in() && class_exists( 'UM' ) ) {
        remove_action( 'um_theme_header_profile_before', 'um_display_header_user_profile', 10 );
        remove_action( 'um_theme_header_profile_before', 'um_theme_header_friend_request_modal', 8 );
        remove_action( 'um_theme_header_profile_before', 'um_theme_header_activity_modal', 10 );
        remove_action( 'um_theme_header_profile_before', 'um_theme_header_notification_modal', 10 );
?>

    <div class="profile-float-bar">
        <div class="um-header-avatar">
            <a href="<?php echo esc_url( um_user_profile_url( get_current_user_id() ) );?>" class="um-tip-n" original-title="<?php echo esc_attr( um_user( 'display_name' ) );?>">
            <?php
                echo get_avatar( get_current_user_id(), 60 );
            ?>
            </a>
        </div>

        <div>
            <?php
                um_theme_header_friend_request_modal();
                um_theme_header_activity_modal();
                um_theme_header_notification_modal();
            ?>
        </div>

    </div>

<?php
    }
}