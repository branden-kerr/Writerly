<?php
/**
 * Header Helper Functions
 *
 * @package     um-theme
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

global $defaults;

/**
 * Output Header Skip Links
 */
if ( ! function_exists( 'um_theme_header_skip_links' ) ) {
    function um_theme_header_skip_links() {
        echo '<a class="skip-link sr-only sr-only-focusable" href="#content">' . __( 'Skip to content', 'um-theme' ) . '</a>';
    }
}


/**
 * Output Header Custom background Image
 */
if ( ! function_exists( 'um_theme_header_custom_background' ) ) {
    function um_theme_header_custom_background() {
        echo '<div class="custom-header-media">';
        the_custom_header_markup();
        echo '</div>';
    }
}

/**
 * Output Header Logo
 */
if ( ! function_exists( 'um_theme_header_logo' ) ) {
    function um_theme_header_logo() {
        // Check if Logo is Active
            if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) :
                um_theme_custom_logo();
            else : ?>
                <div itemscope="itemscope" itemtype="https://schema.org/Organization">
                <p class="site-title" itemprop="name">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                </p>
                </div>
        <?php endif;
     }
}

/**
 * Output Header Custom Logo Image
 */
if ( ! function_exists( 'um_theme_custom_logo' ) ) {
    function um_theme_custom_logo() {

        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo           = wp_get_attachment_image_src( $custom_logo_id , 'full' );
        $retina_logo    = get_theme_mod( 'um_retina_logo' );
        ?>

        <a href="<?php echo esc_url( home_url( '/' ) );?>" class="custom-logo-link" rel="home" itemprop="url">
        <img class="site-img-logo" src="<?php echo esc_url( $logo[0] );?>" alt="logo" <?php if ( $retina_logo ) { ?> srcset="<?php echo esc_url( $retina_logo );?> 2x"<?php } ?>>
        </a>
        <?php
    }
}


/**
 * Output Header Navigation
 */
if ( ! function_exists( 'um_theme_header_menu' ) ) {
    function um_theme_header_menu() {
        global $defaults;
        $menu_position = esc_attr( $defaults['um_theme_menu_position'] );

        /**
         * Support for Max Mega Menu
         * @link https://wordpress.org/plugins/megamenu/
         */
        if ( function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled('primary') ) {

            wp_nav_menu( array(
                'theme_location'    => 'primary',
            ) );

        } else { ?>

            <nav class="navbar navbar-expand-xl navbar-expand-md navbar-light" aria-label="<?php esc_attr_e( 'Primary Menu', 'um-theme' ); ?>">
            <div class="boot-container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-navbar-primary" aria-controls="bs-navbar-primary" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <?php
                    wp_nav_menu( array(
                        'theme_location'    => 'primary',
                        'depth'             => apply_filters( 'umtheme_header_menu_depth', 2 ),
                        'container'         => 'div',
                        'container_class'   => "collapse navbar-collapse boot-justify-content-$menu_position",
                        'container_id'      => 'bs-navbar-primary',
                        'menu_class'        => 'nav navbar-nav',
                        'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                        'walker'            => new WP_Bootstrap_Navwalker(),
                    ) );
                ?>
            </div>
            </nav>
        <?php }
    }
}

/**
 * Output Header Markup
 */
if ( ! function_exists( 'um_theme_core_header' ) ) {
function um_theme_core_header() {

    global $defaults;
    $header_layout      = (int) $defaults['um_theme_header_layout'];
    $profile_position   = (int) $defaults['um_header_profile_position'];

    if ( $profile_position === 1 ){
        $position_class = "profile-position-left";
    }else{
        $position_class = "profile-position-right";
    }

?>
        <div class="boot-container-fluid header-container">
        <div class="header-inner">
        <div class="boot-row boot-align-items-center">

            <?php if ( 1 === (int) $header_layout ) : ?>
                <!-- Logo -->
                <div class="boot-col-5 boot-col-sm-5 boot-col-md-2 boot-order-2 boot-order-md-1 site-branding header-branding-logo">
                    <?php um_theme_header_logo();?>
                </div>

                <!-- Header Menu -->
                <div class="boot-col-2 boot-col-sm-2 boot-col-md-5 boot-order-1 boot-order-md-2 header-one-menu">
                    <?php um_theme_header_menu();?>
                </div>

                <!-- Header Search -->
                <div class="boot-col-12 boot-col-sm-12 boot-col-md-2 boot-order-4 boot-order-md-3 header-search-box">
                    <?php um_theme_display_header_search();?>
                </div>

                <!-- UM Notifcation & Profile. -->
                <div class="boot-col-5 boot-col-sm-5 boot-col-md-3 boot-order-3 boot-order-md-4 header-one-profile <?php echo $position_class;?> boot-text-right">
                    <?php
                        do_action( 'um_theme_header_profile_before' );

                        do_action( 'um_theme_header_profile_after' );
                    ?>
                </div>

            <?php elseif( 2 === (int) $header_layout ) : ?>
               <!-- Logo -->
                <div class="boot-col-md-2 boot-col-2 boot-order-2 boot-order-md-1 site-branding header-branding-logo">
                    <?php um_theme_header_logo();?>
                </div>

                <!-- Header Search -->
                <div class="boot-col-md-4 boot-col-12 boot-order-4 boot-order-md-2 header-search-box search-box-wide">
                    <?php um_theme_display_header_search();?>
                </div>

                <!-- Header Menu -->
                <div class="boot-col-md-4 boot-col-2 boot-order-1 boot-order-md-3 header-one-menu">
                    <?php um_theme_header_menu();?>
                </div>

                <!-- UM Notifcation & Profile. -->
                <div class="boot-col-md-2 boot-col-8 boot-order-3 boot-order-md-4 header-one-profile <?php echo $position_class;?> boot-text-right">
                    <?php
                        do_action( 'um_theme_header_profile_before' );

                        do_action( 'um_theme_header_profile_after' );
                    ?>
                </div>

            <?php elseif( 3 === (int) $header_layout ) : ?>
                <!-- Header Search -->
                <div class="boot-col-md-3 boot-col-12 boot-order-md-1 boot-order-4 header-search-box search-position-left">
                    <?php um_theme_display_header_search();?>
                </div>

                <!-- Logo -->
                <div class="boot-col-md-6 boot-col-3 boot-order-md-2 boot-order-2 site-branding header-branding-logo boot-text-center">
                    <?php um_theme_header_logo();?>
                </div>

                <!-- UM Notifcation & Profile. -->
                <div class="boot-col-md-3 boot-col-6 boot-order-md-3 boot-order-3 header-one-profile <?php echo $position_class;?> boot-text-right">
                    <?php
                        do_action( 'um_theme_header_profile_before' );

                        do_action( 'um_theme_header_profile_after' );
                    ?>
                </div>

                <!-- Header Menu -->
                <div class="boot-col-md-12 boot-col-3 boot-order-md-4 boot-order-1 header-one-menu">
                    <?php um_theme_header_menu();?>
                </div>

            <?php else : ?>

                <!-- Logo -->
                <div class="boot-col-md-2 boot-col-4 boot-order-2 boot-order-md-1 site-branding header-branding-logo">
                    <?php um_theme_header_logo();?>
                </div>

                <!-- Header Menu -->
                <div class="boot-col-md-7 boot-col-2 boot-order-1 boot-order-md-2 header-one-menu">
                    <?php um_theme_header_menu();?>
                </div>

                <!-- UM Notifcation & Profile. -->
                <div class="boot-col-md-3 boot-col-6 boot-order-3 boot-order-md-3 header-one-profile <?php echo $position_class;?> boot-text-right">
                    <?php
                        do_action( 'um_theme_header_profile_before' );

                        do_action( 'um_theme_header_profile_after' );
                    ?>
                </div>

            <?php endif;?>

        </div>
        </div>
        </div>
<?php }
}

/**
 * Ultimate Member switch user profile link based on mbile devices or not.
 */
if ( ! function_exists( 'um_theme_header_profile_link_switcher' ) ) {
    function um_theme_header_profile_link_switcher() {
        if ( wp_is_mobile() ) {
            echo esc_url( '#' );
        } else {
            echo esc_url( um_user_profile_url( get_current_user_id() ) );
        }
    }
}


/**
 * Output Header Markup
 */
if ( ! function_exists( 'um_theme_display_header_search' ) ) {
    function um_theme_display_header_search() {
        global $defaults;
        $show_header_search = (int) $defaults['um_show_header_search'];

        if ( 1 === (int) $show_header_search ) : ?>
            <div class="header-search">
                <?php um_theme_header_search_type(); ?>
            </div>
        <?php elseif ( 2 === (int) $show_header_search && is_user_logged_in() ) : ?>
            <div class="header-search">
                <?php um_theme_header_search_type(); ?>
            </div>
        <?php endif;
    }
}

/**
 * Ultimate Member User Profile Dropdown.
 */
if ( ! function_exists( 'um_display_header_user_profile' ) ) {
    function um_display_header_user_profile() {

        global $defaults;
        $show_header_profile = (int) $defaults['um_show_header_profile'];
        $user_avatar_size    = (int) $defaults['header_profile_avatar_size'];

        if ( is_user_logged_in() ) {

            if ( 1 === (int) $show_header_profile ) {

                if ( class_exists( 'UM' ) ) {
                    um_fetch_user( get_current_user_id() );
                    $username_type      = (int) $defaults['um_header_username_type_select'];

                    if ( $username_type === 1 ){
                        $display_name       = um_user( 'display_name' );
                    } elseif( $username_type === 2 ){
                        $display_name       = um_user( 'first_name' );
                    } elseif( $username_type === 3 ){
                        $display_name       = um_user( 'last_name' );
                    } else {
                        $display_name       = um_user( 'user_nicename' );
                    }
                } ?>

            <div class="outer-section-profile-container">
                <?php if ( class_exists( 'UM' ) ) : ?>
                <div class="label-container">
                    <span>
                        <?php if ( 1 === (int) $defaults['um_show_header_username'] ) { ?>
                            <p class="um-header-avatar-name boot-d-none boot-d-sm-inline-block">
                                <a href="<?php um_theme_header_profile_link_switcher();?>"><?php echo esc_html( $display_name );?></a>
                                <i class="fas fa-angle-down"></i>
                            </p>
                        <?php } ?>

                            <div class="um-header-avatar">
                                <a href="<?php um_theme_header_profile_link_switcher();?>">
                                    <?php echo get_avatar( get_current_user_id(), $user_avatar_size );?>
                                </a>
                            </div>
                    </span>
                </div>
                <?php endif;?>

                <div class="inner-section-profile-container">
                <div class="section section-site-profile">
                <div class="site-profile-container">
                    <?php if ( wp_is_mobile() ) : ?>
                        <div class="mobile-username">
                            <a href="<?php echo esc_url( um_user_profile_url( get_current_user_id() ) );?>">
                                <?php echo esc_html( $display_name );?>
                            </a>
                        </div>
                    <?php endif;?>
                <nav class="nav navbar-light" aria-label="<?php esc_attr_e( 'Profile Menu', 'um-theme' ); ?>">
                  <div class="boot-container-fluid">
                    <?php
                        do_action( 'um_theme_before_header_profile_menu' );

                        wp_nav_menu( array(
                            'theme_location'    => 'profile-menu',
                            'depth'             => apply_filters( 'umtheme_header_profile_menu_depth', 2 ),
                            'container'         => 'div',
                            'container_class'   => 'navbar-collapse flex-column',
                            'container_id'      => 'bs-navbar-profile',
                            'menu_class'        => 'list-unstyled components',
                            'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                            'walker'            => new WP_Bootstrap_Navwalker(),
                        ) );

                        do_action( 'um_theme_after_header_profile_menu' );
                    ?>
                    </div>
                </nav>
                </div>
                </div>
                </div>
            </div>
            <?php
            }

        } else {
            um_theme_header_logeed_out_components();
        }
    }
}

/**
 * Header Logged Out Components eg. Login button.
 */
if ( ! function_exists( 'um_theme_header_logeed_out_components' ) ) {
    function um_theme_header_logeed_out_components() {

        global $defaults;

        $logout_display     = (int) $defaults['header_logged_out_display'];
        $button_one         = esc_url( $defaults['um_theme_header_out_button_one_url'] );
        $button_two         = esc_url( $defaults['um_theme_header_out_button_two_url'] );
        $button_one_text    = esc_attr( $defaults['um_theme_header_out_button_one_text'] );
        $button_two_text    = esc_attr( $defaults['um_theme_header_out_button_two_text'] );

        if ( $logout_display === 1 ) { ?>
            <div class="um-header-nonuser-button">
                <?php
                // Button 1
                if ( ! empty( $button_one_text ) ) { ?>
                    <a  href="<?php echo esc_url( $button_one );?>" class="btn header-button-1">
                        <?php echo esc_attr( $button_one_text );?>
                    </a>
                <?php } ?>

                <?php
                // Button 2
                if ( ! empty( $button_two_text ) ) { ?>
                    <a href="<?php echo esc_url( $button_two );?>" class="btn header-button-2">
                        <?php echo esc_attr( $button_two_text );?>
                    </a>
                <?php } ?>
            </div>
        <?php
        } elseif ( $logout_display === 2 ) {
            // Show Login button
            ?>
            <div class="um-header-nonuser-button">
            <?php
            // Button 1
            if ( ! empty( $button_one_text ) ) { ?>
                <a href="<?php echo esc_url( $button_one );?>" class="btn header-button-1">
                    <?php echo esc_attr( $button_one_text );?>
                </a>
            <?php } ?>
           </div>
        <?php
        } elseif ( $logout_display === 3 ) {
        ?>
        <div class="um-header-nonuser-button">
            <?php
            // Button 2
            if ( ! empty( $button_two_text ) ) { ?>
                <a href="<?php echo esc_url( $button_two );?>" class="btn header-button-2">
                    <?php echo esc_attr( $button_two_text );?>
                </a>
            <?php } ?>
        </div>
        <?php
        } else {
            // Show Text
            um_theme_header_output_logeed_out_text();
        }
    }
}

/**
 * Output Header Logged Out Text
 */
if ( ! function_exists( 'um_theme_header_output_logeed_out_text' ) ) {
    function um_theme_header_output_logeed_out_text() {
        global $defaults;

        if ( ! empty( $defaults['header_logged_out_text'] ) ) {

            $content = $defaults['header_logged_out_text'];
            $content = um_theme_make_translation( 'header_logged_out_text', $content );

            echo '<p class="um-header-logged-out-text">';
            echo do_shortcode( wp_kses_post( $content ) );
            echo '</p>';
        }
    }
}


/**
 * Output Header Topbar First Column Text
 */
if ( ! function_exists( 'um_theme_header_topbar_first_column_text' ) ) {
    function um_theme_header_topbar_first_column_text() {
        global $defaults;

        if ( ! empty( $defaults['um_topbar_colum_first_text'] ) ) {

            $content = $defaults['um_topbar_colum_first_text'];
            $content = um_theme_make_translation( 'um_topbar_colum_first_text', $content );

            echo '<p class="um-header-topbar-text">';
            echo do_shortcode( wp_kses_post( $content ) );
            echo '</p>';
        }
    }
}


/**
 * Output Header Topbar Second Column Text
 */
if ( ! function_exists( 'um_theme_header_topbar_second_column_text' ) ) {
    function um_theme_header_topbar_second_column_text() {
        global $defaults;

        if ( ! empty( $defaults['um_topbar_colum_second_text'] ) ) {

            $content = $defaults['um_topbar_colum_second_text'];
            $content = um_theme_make_translation( 'um_topbar_colum_second_text', $content );

            echo '<p class="um-header-topbar-text">';
            echo do_shortcode( wp_kses_post( $content ) );
            echo '</p>';
        }
    }
}

/**
 * Output Header Bottombar First Column Text
 */
if ( ! function_exists( 'um_theme_header_bottombar_first_column_text' ) ) {
    function um_theme_header_bottombar_first_column_text() {
        global $defaults;

        if ( ! empty( $defaults['um_bottompbar_colum_first_text'] ) ) {

            $content = $defaults['um_bottompbar_colum_first_text'];
            $content = um_theme_make_translation( 'um_bottompbar_colum_first_text', $content );

            echo '<p class="um-header-topbar-text">';
            echo do_shortcode( wp_kses_post( $content ) );
            echo '</p>';
        }
    }
}

/**
 * Output Header Bottombar Second Column Text
 */
if ( ! function_exists( 'um_theme_header_bottombar_second_column_text' ) ) {
    function um_theme_header_bottombar_second_column_text() {
        global $defaults;

        if ( ! empty( $defaults['um_bottompbar_colum_second_text'] ) ) {

            $content = $defaults['um_bottompbar_colum_second_text'];
            $content = um_theme_make_translation( 'um_bottompbar_colum_second_text', $content );

            echo '<p class="um-header-bottom-text">';
            echo do_shortcode( wp_kses_post( $content ) );
            echo '</p>';
        }
    }
}


/**
 * Header Topbar Markup
 */
function um_theme_header_topbar() {

    global $defaults;

    $topbar_column_one_layout   = (int) $defaults['um_topbar_colum_first_layout'];
    $topbar_column_two_layout   = (int) $defaults['um_topbar_colum_second_layout'];
    $show_topbar_layout         = (int) $defaults['um_show_topbar'];

    if ( 2 === (int) $show_topbar_layout ) : ?>

    <div class="header-top-bar">
    <div class="boot-container-fluid topbar-container">
    <div class="boot-text-center">

        <?php if ( 1 === (int) $topbar_column_one_layout ) : ?>
            <!-- Text -->
            <?php um_theme_header_topbar_first_column_text();?>
        <?php elseif ( 2 === (int) $topbar_column_one_layout ) : ?>
            <!-- Text & Social Icons -->
            <div class="boot-row">
                <div class="boot-col-md-6 boot-text-left">
                    <?php um_theme_header_topbar_first_column_text();?>
                </div>
                <div class="boot-col-md-6 boot-text-right">
                    <?php um_theme_social_menu();?>
                </div>
            </div>
        <?php elseif ( $topbar_column_one_layout === 3 ) : ?>
            <!-- Menu -->
            <nav class="navbar navbar-expand-md navbar-light" aria-label="<?php esc_attr_e( 'Top Bar Menu', 'um-theme' ); ?>">
            <div class="boot-container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-navbar-topbar" aria-controls="bs-navbar-topbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <?php
                    wp_nav_menu( array(
                        'theme_location'    => 'header-top',
                        'depth'             => apply_filters( 'umtheme_header_top_menu_depth', 2 ),
                        'container'         => 'div',
                        'container_class'   => 'collapse navbar-collapse boot-justify-content-center',
                        'container_id'      => 'bs-navbar-topbar',
                        'menu_class'        => 'nav navbar-nav',
                        'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                        'walker'            => new WP_Bootstrap_Navwalker(),
                    ) );
                ?>
            </div>
            </nav>
        <?php elseif ( $topbar_column_one_layout === 4 ) : ?>
            <!-- Menu & Social Icons -->
            <div class="boot-row">
                <div class="boot-col-md-6 boot-text-left">
                <nav class="navbar navbar-expand-md navbar-light" aria-label="<?php esc_attr_e( 'Top Bar Menu', 'um-theme' ); ?>">
                    <div class="boot-container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-navbar-topbar" aria-controls="bs-navbar-topbar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <?php
                            wp_nav_menu( array(
                                'theme_location'    => 'header-top',
                                'depth'             => apply_filters( 'umtheme_header_top_menu_depth', 2 ),
                                'container'         => 'div',
                                'container_class'   => 'collapse navbar-collapse boot-justify-content-start',
                                'container_id'      => 'bs-navbar-topbar',
                                'menu_class'        => 'nav navbar-nav',
                                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                                'walker'            => new WP_Bootstrap_Navwalker(),
                            ) );
                        ?>
                    </div>
                </nav>
                </div>

                <div class="boot-col-md-6 boot-text-right">
                    <?php um_theme_social_menu();?>
                </div>
            </div>
        <?php else :
            // Social Icons
            um_theme_social_menu();
        endif;?>
    </div>
    </div>
    </div>
<?php
endif;


if ( $show_topbar_layout === 3 ) : ?>

<div class="header-top-bar">
<div class="boot-container-fluid topbar-container">
<div class="boot-row boot-align-items-center">
        <div class="boot-col-6">

            <?php if ( $topbar_column_one_layout === 1 ) : ?>
                <!-- Text -->
                <?php um_theme_header_topbar_first_column_text();?>
            <?php elseif ( $topbar_column_one_layout === 2 ) : ?>
                <!-- Text & Social Icons -->
                <?php um_theme_header_topbar_first_column_text();?>
                <?php um_theme_social_menu();?>
            <?php elseif ( $topbar_column_one_layout === 3 ) : ?>
                <!-- Menu -->
                  <nav class="navbar navbar-expand-md navbar-light" aria-label="<?php esc_attr_e( 'Top Bar Menu', 'um-theme' ); ?>">
                      <div class="boot-container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-navbar-topbar" aria-controls="bs-navbar-topbar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                            <?php
                            wp_nav_menu( array(
                                'theme_location'    => 'header-top',
                                'depth'             => apply_filters( 'umtheme_header_top_menu_depth', 2 ),
                                'container'         => 'div',
                                'container_class'   => 'collapse navbar-collapse',
                                'container_id'      => 'bs-navbar-topbar',
                                'menu_class'        => 'nav navbar-nav',
                                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                                'walker'            => new WP_Bootstrap_Navwalker(),
                            ) );
                            ?>
                        </div>
                    </nav>
            <?php elseif ( $topbar_column_one_layout === 4 ) : ?>
                <!-- Menu & Social Icons -->
                    <nav class="navbar navbar-expand-md navbar-light" aria-label="<?php esc_attr_e( 'Top Bar Menu', 'um-theme' ); ?>">
                      <div class="boot-container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-navbar-topbar" aria-controls="bs-navbar-topbar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                            <?php
                            wp_nav_menu( array(
                                'theme_location'    => 'header-top',
                                'depth'             => apply_filters( 'umtheme_header_top_menu_depth', 2 ),
                                'container'         => 'div',
                                'container_class'   => 'collapse navbar-collapse',
                                'container_id'      => 'bs-navbar-topbar',
                                'menu_class'        => 'nav navbar-nav',
                                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                                'walker'            => new WP_Bootstrap_Navwalker(),
                            ) );
                            ?>
                        </div>
                    </nav>

                    <?php um_theme_social_menu();?>

            <?php else : ?>
                <!-- Social Icons -->
                <?php um_theme_social_menu();?>
            <?php endif;?>

        </div>
        <div class="boot-col-6 boot-text-right">

            <?php if ( $topbar_column_two_layout === 1 ) : ?>
                <!-- Text -->
                <?php um_theme_header_topbar_second_column_text();?>
            <?php elseif ( $topbar_column_two_layout === 2 ) : ?>
                <!-- Text & Social Icons -->
                <?php um_theme_header_topbar_second_column_text();?>
                <?php um_theme_social_menu();?>
            <?php elseif ( $topbar_column_two_layout === 3 ) : ?>
                <!-- Menu -->
                  <nav class="navbar navbar-expand-md navbar-light" aria-label="<?php esc_attr_e( 'Top Bar Menu', 'um-theme' ); ?>">
                      <div class="boot-container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-navbar-topbar" aria-controls="bs-navbar-topbar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                            <?php
                            wp_nav_menu( array(
                                'theme_location'    => 'header-top',
                                'depth'             => apply_filters( 'umtheme_header_top_menu_depth', 2 ),
                                'container'         => 'div',
                                'container_class'   => 'collapse navbar-collapse boot-justify-content-end',
                                'container_id'      => 'bs-navbar-topbar',
                                'menu_class'        => 'nav navbar-nav',
                                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                                'walker'            => new WP_Bootstrap_Navwalker(),
                            ) );
                            ?>
                        </div>
                    </nav>
            <?php elseif ( $topbar_column_two_layout === 4 ) : ?>
                <!-- Menu & Social Icons -->
                    <nav class="navbar navbar-expand-md navbar-light" aria-label="<?php esc_attr_e( 'Top Bar Menu', 'um-theme' ); ?>">
                      <div class="boot-container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-navbar-topbar" aria-controls="bs-navbar-topbar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                            <?php
                            wp_nav_menu( array(
                                'theme_location'    => 'header-top',
                                'depth'             => apply_filters( 'umtheme_header_top_menu_depth', 2 ),
                                'container'         => 'div',
                                'container_class'   => 'collapse navbar-collapse boot-justify-content-end',
                                'container_id'      => 'bs-navbar-topbar',
                                'menu_class'        => 'nav navbar-nav',
                                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                                'walker'            => new WP_Bootstrap_Navwalker(),
                            ) );
                            ?>
                        </div>
                    </nav>

                    <?php um_theme_social_menu();?>

            <?php else : ?>
                <!-- Social Icons -->
                <?php um_theme_social_menu();?>
            <?php endif;?>
        </div>
</div>
</div>
</div>
<?php
endif;
}

/**
 * Header Bottom Bar
 */
if ( ! function_exists( 'um_theme_header_bottombar' ) ) {
    function um_theme_header_bottombar() {

    global $defaults;

    if ( $defaults['um_show_bottombar'] === 1 || $defaults['um_show_bottombar'] === 3 ) : ?>

    <?php if ( $defaults['um_show_bottombar_layout'] === 1 ) : ?>
    <div <?php um_theme_get_bottom_toggler_state();?> class="header-bottom-bar boot-text-center">
            <?php if ( $defaults['um_bottombar_colum_first_layout'] === 1 ) :?>
                <?php um_theme_header_bottombar_first_column_text();?>
            <?php endif;?>

            <?php if ( $defaults['um_bottombar_colum_first_layout'] === 2 ) :?>
                <div class="header-bottom-bar">
                <div class="boot-container-fluid">
                    <nav class="navbar navbar-expand navbar-light" aria-label="<?php esc_attr_e( 'Bottom Bar Menu', 'um-theme' ); ?>">
                    <div class="boot-container">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-navbar-bottombar" aria-controls="bs-navbar-bottombar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <?php
                            wp_nav_menu(
                                array(
                                    'theme_location'    => 'header-bottom',
                                    'depth'             => apply_filters( 'umtheme_header_bottom_menu_depth', 2 ),
                                    'container'         => 'div',
                                    'container_class'   => 'collapse navbar-collapse boot-justify-content-center',
                                    'container_id'      => 'bs-navbar-bottombar',
                                    'menu_class'        => 'nav navbar-nav',
                                    'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                                    'walker'            => new WP_Bootstrap_Navwalker(),
                            ) );
                        ?>
                    </div>
                    </nav>
                </div>
                </div>
            <?php endif;?>
    </div>
    <?php endif;?>

    <?php if ( $defaults['um_show_bottombar_layout'] === 2 ) : ?>
    <div <?php um_theme_get_bottom_toggler_state();?> class="header-bottom-bar">
    <div class="container-padded">
    <div class="boot-row boot-align-items-center">
        <div class="boot-col-md-6 bottom-bar-left boot-text-left">

            <?php if ( $defaults['um_bottombar_colum_first_layout'] === 1 ) : ?>
                <?php um_theme_header_bottombar_first_column_text();?>
            <?php endif;?>

            <?php if ( $defaults['um_bottombar_colum_first_layout'] === 2 ) : ?>
                <div class="boot-container">
                    <nav class="navbar navbar-expand-md navbar-light" aria-label="<?php esc_attr_e( 'Bottom Bar Menu', 'um-theme' ); ?>">
                    <div class="boot-container">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-navbar-bottombar" aria-controls="bs-navbar-bottombar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <?php
                            wp_nav_menu(
                                array(
                                    'theme_location'    => 'header-bottom',
                                    'depth'             => apply_filters( 'umtheme_header_bottom_menu_depth', 2 ),
                                    'container'         => 'div',
                                    'container_class'   => 'collapse navbar-collapse boot-justify-content-center',
                                    'container_id'      => 'bs-navbar-bottombar',
                                    'menu_class'        => 'nav navbar-nav',
                                    'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                                    'walker'            => new WP_Bootstrap_Navwalker(),
                            ) );
                        ?>
                    </div>
                    </nav>
                </div>

            <?php endif;?>
        </div>


        <div class="boot-col-md-6 bottom-bar-right boot-text-right">

            <?php if ( $defaults['um_bottombar_colum_second_layout'] === 1 ) : ?>
                <?php um_theme_header_bottombar_second_column_text();?>
            <?php endif;?>

            <?php if ( $defaults['um_bottombar_colum_second_layout'] === 2 ) : ?>
                <div class="boot-container">
                    <nav class="navbar navbar-expand-md navbar-light" aria-label="<?php esc_attr_e( 'Bottom Bar Menu', 'um-theme' ); ?>">
                    <div class="boot-container">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-navbar-bottombar" aria-controls="bs-navbar-bottombar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <?php
                            wp_nav_menu(
                                array(
                                    'theme_location'    => 'header-bottom',
                                    'depth'             => apply_filters( 'umtheme_header_bottom_menu_depth', 2 ),
                                    'container'         => 'div',
                                    'container_class'   => 'collapse navbar-collapse boot-justify-content-center',
                                    'container_id'      => 'bs-navbar-bottombar',
                                    'menu_class'        => 'nav navbar-nav',
                                    'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                                    'walker'            => new WP_Bootstrap_Navwalker(),
                            ) );
                        ?>
                    </div>
                    </nav>
                </div>

            <?php endif;?>
        </div>
    </div>
    </div>
    </div>
    <?php endif;?>

    <?php
    endif;
    }
}

/**
 * Bottom Bar Section Reveal Button.
 */
if ( ! function_exists( 'um_add_bottom_menu_clicker' ) ) {
    function um_add_bottom_menu_clicker( $items, $args ) {
        global $defaults;
        $menu_state = (int) $defaults['um_show_bottombar'];

        if ( $menu_state === 3 && $args->theme_location == 'primary' ) {
            $items .= '<li id="get_click">';
            $items .= '<i class="bottom-t-m-ico fas fa-ellipsis-h"></i>';
            $items .= '</li>';
        }

        return $items;
    }
}


/**
 * Check if Bottom bar visible is active
 */
if ( ! function_exists( 'is_active_bottom_bar_click_class' ) ) {
 function is_active_bottom_bar_click_class() {
    global $defaults;
    if ( 3 === (int) $defaults['um_show_bottombar'] ) {
        echo 'bb-hide-menu';
    }
 }
}

/**
 * Add ID based on Menu State.
 */
if ( ! function_exists( 'um_theme_get_bottom_toggler_state' ) ) {
    function um_theme_get_bottom_toggler_state() {

        global $defaults;
        $menu_state = $defaults['um_show_bottombar'];

        if ( 3 === $menu_state  ) {
            echo 'id="get_started"';
        }
    }
}