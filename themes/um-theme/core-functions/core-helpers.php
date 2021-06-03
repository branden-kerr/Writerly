<?php
/**
 * UM Theme Helper Functions
 *
 * @package     um-theme
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

global $defaults;

/**
 *Add Class to the body
 */
if ( ! function_exists( 'um_theme_body_classes' ) ) {
    function um_theme_body_classes( $classes ) {
        global $defaults;

        if ( wp_is_mobile() ) {
            $classes[] = 'um-theme-mobile';
        } else {
            $classes[] = 'um-theme-desktop';
        }

        // Multiple Author
        if ( is_multi_author() ) {
            $classes[] = 'group-blog';
        }

        // Not Singular
        if ( ! is_singular() ) {
            $classes[] = 'hfeed';
        }

        // Add a class if there is a custom header.
        if ( has_header_image() ) {
            $classes[] = 'has-header-image';
        }

        // Adds a class of no-sidebar when there is no sidebar present.
        if ( ! is_active_sidebar( 'sidebar-page' ) ) {
            $classes[] = 'no-sidebar';
        }

        // Add class if child theme is active.
        if ( is_child_theme() ) {
          $classes[] = 'child-theme-active';
        }

        if ( 1 === (int) $defaults['um_theme_make_header_sticky'] ) {
            $classes[] = 'has-sticky-header';
        }

        $classes[] = 'boot-container-fluid';

        return array_unique( $classes );
    }
}

/**
 * Strip unnecessary css classes from body element.
 */
 if( ! function_exists( 'um_theme_clean_body_classes' ) ) {
    function um_theme_clean_body_classes( $classes ) {

        $not_allowed_classes = [
            'single-format-standard',
            'admin-bar',
            'customize-support',
            'wp-embed-responsive',
            'theme-um-theme',
            'wp-custom-logo',
            'page-template',
            'page-template-template-parts',
        ];

        return array_diff( $classes, $not_allowed_classes );

    }
}

/**
 * Add CSS class to Next Pagination
 */
if ( ! function_exists( 'um_theme_next_page_add_class' ) ) {
    function um_theme_next_page_add_class() {
        return 'class="pagination-next"';
    }
}

/**
 * Add CSS class to Previous Pagination
 */
if ( ! function_exists( 'um_theme_previous_page_add_class' ) ) {
    function um_theme_previous_page_add_class() {
        return 'class="pagination-previous"';
    }
}

/**
 * Prints HTML with meta information for the Tags
 */
if ( ! function_exists( 'um_post_tag' ) ) {
    function um_post_tag() {
        // Hide category and tag text for pages.
        if ( get_post_type() === 'post' ) {
            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list();
            if ( $tags_list && ! is_wp_error( $tags_list ) ) {
                echo '<span class="meta meta-tag">' . wp_kses_post( $tags_list ) . '</span>';
            }
        }
    }
}

/**
 * Prints Post published date
 */
if ( ! function_exists( 'um_published_on' ) ) {
    function um_published_on() { ?>
        <span class="meta post-meta__time">
            <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) );?>">
                <?php echo esc_attr( get_the_date( get_option( 'date_format' ) ) );?>
            </time>
        </span>
    <?php }
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
if ( ! function_exists( 'um_post_author' ) ) {
    function um_post_author() {

        $author_url = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
        ?>
        <span class="meta post-meta__author">
            <address>
                <span class="vcard author author_name">
                    <a href="<?php echo $author_url;?>" class="post-meta-author-link" rel="author">
                        <?php
                            if ( function_exists( 'coauthors_posts_links' ) ){
                                coauthors_posts_links();
                            } else{
                                the_author();
                            }
                        ?>
                    </a>
                </span>
            </address>
        </span>
<?php
    }
}

/**
 * Numbered Pagination
 */
if ( ! function_exists( 'um_theme_pagination' ) ) {
    function um_theme_pagination() {
        global $defaults;
        $blog_pagination_type = $defaults['um_theme_blog_pagination_type'];

        /**
         * Display WP-PageNavi pagination instead of theme pagination if the plugin exists.
         */
        if ( function_exists( 'wp_pagenavi' ) ) {
            wp_pagenavi();
        } else {
        /**
         * Display theme pagination.
         */
            if ( 1 === (int) $blog_pagination_type ) :
                // Next & Previous Page Pagination.
                echo '<div class="article-pagination-custom boot-col-12">';
                next_posts_link( 'Next Page', 0 );
                previous_posts_link( 'Previous Page', 0 );
                echo '</div>';
            else :
                // Numeric Pagination.
                echo '<div class="boot-col-md-12">';
                echo '<div class="article-pagination-num">';

                the_posts_pagination( array(
                    'prev_text'     => '<i class="fas fa-angle-left" aria-hidden="true"></i><span class="sr-only sr-only-focusable">' . __( 'Previous Page', 'um-theme' ) . '</span>',
                    'next_text'     => '<i class="fas fa-angle-right" aria-hidden="true"></i><span class="sr-only sr-only-focusable">' . __( 'Next Page', 'um-theme' ) . '</span>',
                    'aria_label'    => __( 'Pagination Navigation', 'um-theme' ),
                ) );

                echo '</div>';
                echo '</div>';
            endif;
        }
    }
}


/**
 * Check & Prints out Scroll To Top if activated
 */
if ( ! function_exists( 'um_theme_scroll_to_top' ) ) {
    function um_theme_scroll_to_top() {
      global $defaults;
        if ( 1 === (int) $defaults['um_theme_show_scroll_to_top'] ) { ?>
      <script>
      // Scroll To Top
      jQuery(window).scroll(function(){
        if (jQuery(this).scrollTop() > 700) {
            jQuery('.scrollToTop').fadeIn();
        } else {
            jQuery('.scrollToTop').fadeOut();
        }
        });

        //Click event to scroll to top
        jQuery('.scrollToTop').click(function(){
          jQuery('html, body').animate({scrollTop : 0},1000);
                return false;
        });
        </script>
    <?php }}
}


/**
 * Print out the post categories.
 */
if ( ! function_exists( 'um_theme_category' ) ) {
    function um_theme_category() {
        if ( 'post' === get_post_type() ) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list( esc_html__( ', ', 'um-theme' ) );
            if ( $categories_list && um_theme_has_active_categories() ) {
                echo '<p class="entry-meta">';
                echo '<span class="meta meta-category" rel="tag">' . wp_kses_post( $categories_list ) . '</span>';
                echo '</p>';
            }
        }
    }
}

/**
 * Check if the site has active categories.
 *
 * We will store the result in a transient so this function
 * can be called frequently without any performance concern.
 *
 * @see   um_theme_has_active_categories_reset()
 *
 * @since 1.0.0
 *
 * @uses [get_transient](https://developer.wordpress.org/reference/functions/get_transient/)
 * @uses [get_categories](https://developer.wordpress.org/reference/functions/get_categories/)
 * @uses [set_transient](https://developer.wordpress.org/reference/functions/set_transient/)
 *
 * @return bool Returns true when categories are found, otherwise returns false.
 */
if ( ! function_exists( 'um_theme_has_active_categories' ) ) {
    function um_theme_has_active_categories() {

        $has_active_categories = get_transient( 'um_theme_has_active_categories' );

        if ( WP_DEBUG || false === $has_active_categories ) {

            $categories = get_categories(
                array(
                    'fields'     => 'ids',
                    'hide_empty' => 1,
                    'number'     => 2, // We only care if more than one exists.
                )
            );

            $has_active_categories = ( count( $categories ) > 1 );

            set_transient( 'um_theme_has_active_categories', $has_active_categories );

        }

        /**
         * Filter if the site has active categories.
         *
         * @since 1.0.0
         *
         * @var bool
         */
        return (bool) apply_filters( 'um_theme_has_active_categories', ! empty( $has_active_categories ) );
    }
}


/**
 * Reset the transient for the active categories check.
 *
 * @action create_category
 * @action edit_category
 * @action delete_category
 * @action save_post
 * @see    um_theme_has_active_categories()
 * @since  1.0.0
 */
if ( ! function_exists( 'um_theme_has_active_categories_reset' ) ) {
    function um_theme_has_active_categories_reset() {
        delete_transient( 'um_theme_has_active_categories' );
    }
}

/**
* Article Author Box
*/
if ( ! function_exists( 'um_get_single_article_author_box' ) ) {
    function um_get_single_article_author_box() {

        $avatar             = get_avatar( get_the_author_meta( 'user_email' ), 75 );
        $author_name        = get_the_author_meta( 'display_name' );
        $author_bio         = get_the_author_meta( 'description' );
        $author_post_url    = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );

        if ( class_exists( 'coauthors_plus' ) ) :
            umtheme_display_coauthor_box();
        else :
        ?>

            <div class="article-author-box boot-text-center">
                <div class="author-box-profile">
                    <div class="author-image">
                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>" class="post-meta-author-link">
                            <?php echo wp_kses_post( $avatar );?>
                        </a>
                    </div>
                    <?php if ( $author_name ) : ?>
                        <h5 class="author-name">
                            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>" class="post-meta-author-link">
                                <?php echo esc_attr( $author_name );?>
                            </a>
                        </h5>
                    <?php endif;?>

                    <?php if ( $author_bio ) : ?>
                        <p class="meta author-bio"><?php echo esc_html( $author_bio );?></p>
                    <?php endif;?>
                </div>
            </div>
        <?php
        endif;
    }
}

/**
 * Displays the navigation to next/previous post, when applicable.
 *
 * @param array $args Optional. See get_the_post_navigation() for available arguments.
 *                    Default empty array.
 */
if ( ! function_exists( 'um_theme_the_post_navigation' ) ) {
    function um_theme_the_post_navigation( $args = array() ) {
        echo wp_kses_post( um_theme_get_the_post_navigation( $args ) );
    }
}

/**
 * Retrieves the navigation to next/previous post, when applicable.
 *
 * @param array $args {
 *     Optional. Default post navigation arguments. Default empty array.
 *
 * @type string $prev_text Anchor text to display in the previous post link. Default '%title'.
 * @type string $next_text Anchor text to display in the next post link. Default '%title'.
 * @type bool $in_same_term Whether link should be in a same taxonomy term. Default false.
 * @type array|string $excluded_terms Array or comma-separated list of excluded term IDs. Default empty.
 * @type string $taxonomy Taxonomy, if `$in_same_term` is true. Default 'category'.
 * @type string $screen_reader_text Screen reader text for nav element. Default 'Post navigation'.
 * }
 * @return string Markup for post links.
 */
if ( ! function_exists( 'um_theme_get_the_post_navigation' ) ) {
    function um_theme_get_the_post_navigation( $args = array() ) {
        $args = wp_parse_args( $args, array(
            'prev_text'          => '%title',
            'next_text'          => '%title',
            'in_same_term'       => false,
            'excluded_terms'     => '',
            'taxonomy'           => 'category',
            'screen_reader_text' => __( 'Post navigation', 'um-theme' ),
        ) );

        $navigation = '';

        $previous = get_previous_post_link(
            '<div class="nav-previous"><span class="nav-previous-title">%link</span>' . '<span class="nav-previous-info">' . __( 'Previous', 'um-theme' ) . '</span></div>',
            $args['prev_text'],
            $args['in_same_term'],
            $args['excluded_terms'],
            $args['taxonomy']
        );

        $next = get_next_post_link(
            '<div class="nav-next"><span class="nav-next-title">%link</span>' . '<span class="nav-next-info">' . __( 'Next', 'um-theme' ) . '</span></div>',
            $args['next_text'],
            $args['in_same_term'],
            $args['excluded_terms'],
            $args['taxonomy']
        );

        // Only add markup if there's somewhere to navigate to.
        if ( $previous || $next ) {
            $navigation = _navigation_markup( $previous . $next, 'post-navigation', $args['screen_reader_text'] );
        }

        return $navigation;
    }
}

/**
 * Google Fonts URL
 * @link https://fonts.google.com/
 * @license SIL Open Font License (OFL)
 * @since 1.0.0
 */
if ( ! function_exists( 'um_theme_fonts_url' ) ) {
    function um_theme_fonts_url() {

        $fonts_url          = '';
        $content_font       = get_theme_mod( 'um_theme_typography_body_font', 'Open Sans' );
        $header_font        = get_theme_mod( 'um_theme_typography_title_font', 'Open Sans' );
        $navigation_font    = get_theme_mod( 'um_theme_typography_nav_font', 'Open Sans' );
        $logo_font          = get_theme_mod( 'um_theme_typography_logo_font', 'Open Sans' );
        $button_font        = get_theme_mod( 'um_theme_typography_button_font', 'Open Sans' );

        if ( 'off' !== $content_font || 'off' !== $header_font || 'off' !== $navigation_font || 'off' !== $logo_font || 'off' !== $button_font ) {

            $font_families = array();

            if ( 'off' !== $content_font ) {
                $font_families[] = $content_font . ':300,400,700';
            }

            if ( 'off' !== $header_font ) {
                $font_families[] = $header_font . ':300,400,700';
            }

            if ( 'off' !== $navigation_font ) {
                $font_families[] = $navigation_font . ':300,400,700';
            }

            if ( 'off' !== $logo_font ) {
                $font_families[] = $logo_font . ':300,400,700';
            }

            if ( 'off' !== $button_font ) {
                $font_families[] = $button_font . ':300,400,700';
            }

            $protocol = is_ssl() ? 'https' : 'http';

            $query_args = array(
                'family'    => rawurlencode( implode( '|', array_unique( $font_families ) ) ),
                'subset'    => rawurlencode( 'latin,latin-ext' ),
                'display'   => rawurlencode( 'swap' ),
            );

            $fonts_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
        }

        return esc_url_raw( $fonts_url );
    }
}

/**
 * Add resource hints to our Google fonts call.
 *
 * @since 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
if ( ! function_exists( 'um_theme_resource_hints' ) ) {
    function um_theme_resource_hints( $urls, $relation_type ) {
        if ( wp_style_is( 'umtheme-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
            if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '>=' ) ) {
                $urls[] = array(
                    'href' => 'https://fonts.gstatic.com',
                    'crossorigin',
                );
            } else {
                $urls[] = 'https://fonts.gstatic.com';
            }
        }
        return $urls;
    }
}

/**
 * Outputs Social Media Icons
 */
if ( ! function_exists( 'um_theme_social_menu' ) ) {
    function um_theme_social_menu() {
        global $defaults;

        $social_link_one    = esc_url( $defaults['um_theme_social_account_link_one'] );
        $social_link_two    = esc_url( $defaults['um_theme_social_account_link_two'] );
        $social_link_three  = esc_url( $defaults['um_theme_social_account_link_three'] );
        $social_link_four   = esc_url( $defaults['um_theme_social_account_link_four'] );
        $social_link_five   = esc_url( $defaults['um_theme_social_account_link_five'] );
        $social_link_six    = esc_url( $defaults['um_theme_social_account_link_six'] );
        $social_icon_one    = esc_attr( $defaults['um_theme_social_account_icon_one'] );
        $social_icon_two    = esc_attr( $defaults['um_theme_social_account_icon_two'] );
        $social_icon_three  = esc_attr( $defaults['um_theme_social_account_icon_three'] );
        $social_icon_four   = esc_attr( $defaults['um_theme_social_account_icon_four'] );
        $social_icon_five   = esc_attr( $defaults['um_theme_social_account_icon_five'] );
        $social_icon_six    = esc_attr( $defaults['um_theme_social_account_icon_six'] );
    ?>

    <nav class="um-theme-social-link" itemscope itemtype="http://schema.org/Organization" aria-label="<?php esc_attr_e( 'Social Links', 'um-theme' ); ?>">
    <link href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">

    <!-- Social Icon 1 -->
    <?php if ( ! empty( $social_link_one ) ) : ?>
        <a href="<?php echo esc_url( $social_link_one );?>">
            <span class="<?php echo esc_attr( $social_icon_one ); ?>"></span>
        </a>
    <?php endif; ?>

    <!-- Social Icon 2 -->
    <?php if ( ! empty( $social_link_two ) ) : ?>
        <a href="<?php echo esc_url( $social_link_two );?>">
            <span class="<?php echo esc_attr( $social_icon_two ); ?>"></span>
        </a>
    <?php endif; ?>

    <!-- Social Icon 3 -->
    <?php if ( ! empty( $social_link_three ) ) : ?>
        <a href="<?php echo esc_url( $social_link_three );?>">
            <span class="<?php echo esc_attr( $social_icon_three ); ?>"></span>
        </a>
    <?php endif; ?>

    <!-- Social Icon 4 -->
    <?php if ( ! empty( $social_link_four ) ) : ?>
        <a href="<?php echo esc_url( $social_link_four );?>">
            <span class="<?php echo esc_attr( $social_icon_four ); ?>"></span>
        </a>
    <?php endif; ?>

    <!-- Social Icon 5 -->
    <?php if ( ! empty( $social_link_five ) ) : ?>
        <a href="<?php echo esc_url( $social_link_five );?>">
            <span class="<?php echo esc_attr( $social_icon_five ); ?>"></span>
        </a>
    <?php endif; ?>

    <!-- Social Icon 6 -->
    <?php if ( ! empty( $social_link_six ) ) : ?>
        <a href="<?php echo esc_url( $social_link_six );?>">
            <span class="<?php echo esc_attr( $social_icon_six ); ?>"></span>
        </a>
    <?php endif; ?>

    </nav>

<?php }
}

/**
 * Output Theme Footer Widgets
 */
if ( ! function_exists( 'um_theme_footer_widgets' ) ) {
    function um_theme_footer_widgets() {

        do_action( 'um_theme_before_footer_widgets' );

        global $defaults;
        $footer_widget_column = $defaults['um_theme_footer_widget_column'];

        if ( is_active_sidebar( 'sidebar-footer-one' ) || is_active_sidebar( 'sidebar-footer-two' ) || is_active_sidebar( 'sidebar-footer-three' ) || is_active_sidebar( 'sidebar-footer-four' ) ) : ?>
            <div class="site-footer-layout-sidebar">
            <div class="boot-container">
                <div class="boot-row">
                    <?php if ( is_active_sidebar( 'sidebar-footer-one' ) ) : ?>
                    <div class="footer-sidebar-column-one <?php echo sanitize_html_class( $footer_widget_column );?>">
                        <?php do_action( 'um_theme_before_first_footer_col' ); ?>
                        <?php dynamic_sidebar( 'sidebar-footer-one' ); ?>
                        <?php do_action( 'um_theme_after_first_footer_col' ); ?>
                    </div>
                    <?php endif;?>

                    <?php if ( is_active_sidebar( 'sidebar-footer-two' ) ) : ?>
                    <div class="footer-sidebar-column-two <?php echo sanitize_html_class( $footer_widget_column );?>">
                        <?php do_action( 'um_theme_before_second_footer_col' ); ?>
                        <?php dynamic_sidebar( 'sidebar-footer-two' ); ?>
                        <?php do_action( 'um_theme_after_second_footer_col' ); ?>
                    </div>
                    <?php endif;?>

                    <?php if ( is_active_sidebar( 'sidebar-footer-three' ) ) : ?>
                    <div class="footer-sidebar-column-three <?php echo sanitize_html_class( $footer_widget_column );?>">
                        <?php do_action( 'um_theme_before_third_footer_col' ); ?>
                        <?php dynamic_sidebar( 'sidebar-footer-three' ); ?>
                        <?php do_action( 'um_theme_after_third_footer_col' ); ?>
                    </div>
                    <?php endif;?>

                    <?php if ( is_active_sidebar( 'sidebar-footer-four' ) ) : ?>
                    <div class="footer-sidebar-column-four <?php echo sanitize_html_class( $footer_widget_column );?>">
                        <?php do_action( 'um_theme_before_fourth_footer_col' ); ?>
                        <?php dynamic_sidebar( 'sidebar-footer-four' ); ?>
                        <?php do_action( 'um_theme_after_fourth_footer_col' ); ?>
                    </div>
                    <?php endif;?>
                </div>
            </div>
            </div>
        <?php endif;

        do_action( 'um_theme_after_footer_widgets' );
    }
}

/**
 * Output Footer Column First Text
 */
if ( ! function_exists( 'um_theme_footer_first_column_text' ) ) {
    function um_theme_footer_first_column_text() {
        global $defaults;

        if ( ! empty( $defaults['um_footer_colum_first_text'] ) ) {

            $content = $defaults['um_footer_colum_first_text'];
            $content = um_theme_make_translation( 'um_footer_colum_first_text', $content );

            echo do_shortcode( wp_kses_post( $content ) );
        }
    }
}

/**
 * Output Footer Column Second Text
 */
if ( ! function_exists( 'um_theme_footer_second_column_text' ) ) {
    function um_theme_footer_second_column_text() {
        global $defaults;

        if ( ! empty( $defaults['um_footer_colum_second_text'] ) ) {

            $content = $defaults['um_footer_colum_second_text'];
            $content = um_theme_make_translation( 'um_footer_colum_second_text', $content );
            echo '<div class="boot-col-md-6 footer-text">';
            echo '<p>';
            echo do_shortcode( wp_kses_post( $content ) );
            echo '</p>';
            echo '</div>';
        }
    }
}


/**
 * Output Theme Footer Content Text
 */
if ( ! function_exists( 'um_theme_footer_bottom_content' ) ) :
    function um_theme_footer_bottom_content() {
        global $defaults;
        ?>

    <div class="site-footer-center site-footer-layout-text">
    <div class="website-canvas">

        <?php if ( 1 === (int) $defaults['um_show_footer_layout'] ) : ?>
            <div class="boot-row">
            <?php if ( 1 === (int) $defaults['um_footer_colum_first_layout'] ) : ?>
            <?php
                if ( ! empty( $defaults['um_footer_colum_first_text'] ) ) : ?>
                    <div class="boot-col-md-12 footer-text boot-text-center">
                        <p><?php um_theme_footer_first_column_text();?></p>
                    </div>
            <?php endif;?>
            <?php endif;?>

            <?php if ( 2 === (int) $defaults['um_footer_colum_first_layout'] ) : ?>
                <div class="boot-col-md-12 footer-menu-container">

                    <?php if ( has_nav_menu( 'footer' ) ) : ?>
                        <nav class="navbar navbar-light" aria-label="<?php esc_attr_e( 'Footer Menu', 'um-theme' ); ?>">
                         <div class="boot-container boot-justify-content-center">

                            <?php
                                wp_nav_menu( array(
                                    'theme_location'    => 'footer',
                                    'depth'             => 1,
                                    'container'         => 'div',
                                    'container_class'   => 'foot-nav',
                                    'container_id'      => 'bs-navbar-footer',
                                    'menu_class'        => 'um-nav-footer',
                                    'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                                    'walker'            => new WP_Bootstrap_Navwalker(),
                                ) );
                            ?>
                        </div>
                        </nav>
                    <?php endif;?>

                </div>
            <?php endif;?>
            </div>
        <?php endif;?>

        <?php if ( 2 === (int) $defaults['um_show_footer_layout'] ) : ?>
            <div class="boot-row">
            <?php if ( 1 === (int) $defaults['um_footer_colum_first_layout'] ) : ?>
                <?php if ( ! empty( $defaults['um_footer_colum_first_text'] ) ) : ?>
                        <div class="boot-col-md-6 footer-text">
                            <p><?php um_theme_footer_first_column_text();?></p>
                        </div>
                <?php endif;?>
            <?php endif;?>

            <?php if ( 2 === (int) $defaults['um_footer_colum_first_layout'] ) : ?>
                <div class="boot-col-md-6 footer-menu-container">

                    <?php if ( has_nav_menu( 'footer' ) ) : ?>
                        <nav class="navbar navbar-light" aria-label="<?php esc_attr_e( 'Footer Menu', 'um-theme' ); ?>">
                        <div class="boot-container">

                            <?php
                                wp_nav_menu( array(
                                    'theme_location'    => 'footer',
                                    'depth'             => 1,
                                    'container'         => 'div',
                                    'container_class'   => 'boot-justify-content-end',
                                    'container_id'      => 'bs-navbar-footer',
                                    'menu_class'        => 'um-nav-footer',
                                    'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                                    'walker'            => new WP_Bootstrap_Navwalker(),
                                ) );
                            ?>
                        </div>
                        </nav>
                    <?php endif;?>

                </div>
            <?php endif;?>


            <?php if ( 1 === (int) $defaults['um_footer_colum_second_layout'] ) : ?>
                <?php um_theme_footer_second_column_text();?>
            <?php endif;?>

            <?php if ( 2 === (int) $defaults['um_footer_colum_second_layout'] ) : ?>
                <div class="boot-col-md-6 footer-menu-container">

                    <?php if ( has_nav_menu( 'footer' ) ) : ?>
                        <nav class="navbar navbar-light" aria-label="<?php esc_attr_e( 'Footer Menu', 'um-theme' ); ?>">
                        <div class="boot-container boot-justify-content-end">

                            <?php
                                wp_nav_menu( array(
                                    'theme_location'    => 'footer',
                                    'depth'             => 1,
                                    'container'         => 'div',
                                    'container_class'   => 'boot-justify-content-end',
                                    'container_id'      => 'bs-navbar-footer',
                                    'menu_class'        => 'um-nav-footer',
                                    'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                                    'walker'            => new WP_Bootstrap_Navwalker(),
                                ) );
                            ?>
                        </div>
                        </nav>
                    <?php endif;?>

                </div>
            <?php endif;?>
            </div>
        <?php endif;?>
    </div>
    </div>
<?php
    }
endif;

/**
 * Output Article Header of Single Post
 */
if ( ! function_exists( 'um_theme_single_post_header' ) ) {
    function um_theme_single_post_header() {

        global $defaults;
        $show_post_cat          = (int) $defaults['um_theme_show_post_category'];
        $show_article_summary   = (int) $defaults['um_theme_show_post_article_summary'];
        ?>

        <?php do_action('um_theme_before_single_post_header');?>

        <header class="entry-header single-article-header">
            <?php
                if ( 1 === $show_post_cat  ) {
                    um_theme_category();
                }
            ?>

            <h1 class="entry-title"><?php the_title(); ?></h1>

            <?php if ( is_singular( 'post' ) ) : ?>
                <?php if ( 1 === $show_article_summary ) :?>
                    <div class="article-summary"><?php the_excerpt();?></div>
                <?php endif;?>
                <span class="meta"><?php um_post_author();?> - <?php um_published_on();?></span>
            <?php endif;?>
        </header>
    <?php
    }
}

/**
 * Output Article Featured Image
 */
if ( ! function_exists( 'um_theme_single_post_featured_image' ) ) {
    function um_theme_single_post_featured_image() {

        global $defaults;
        $f_image_position          = (int) $defaults['um_theme_post_featured_image_pos'];

        if ( 1 === $f_image_position ) {
            return;
        } elseif (  2 === $f_image_position ) {
            add_action( 'um_theme_single_post_top', 'um_theme_single_post_print_featured_image', 5 );
        } elseif (  3 === $f_image_position ) {
            add_action( 'um_theme_single_post', 'um_theme_single_post_print_featured_image', 15 );
        } else {
            add_action( 'um_theme_single_post', 'um_theme_single_post_beside_print_featured_image', 15 );
        }
    }
}

/**
 * Output Article Featured Image - Regular
 */
if ( ! function_exists( 'um_theme_single_post_print_featured_image' ) ) {
    function um_theme_single_post_print_featured_image() {
        the_post_thumbnail( 'large' );
    }
}

/**
 * Output Article Featured Image - Beside
 */
if ( ! function_exists( 'um_theme_single_post_beside_print_featured_image' ) ) {
    function um_theme_single_post_beside_print_featured_image() {
        echo '<div class="single-post-beside">';
        the_post_thumbnail( 'large' );
        echo '</div>';
    }
}

/**
 * Output Single Post Content
 */
if ( ! function_exists( 'um_theme_single_post_content' ) ) {
    function um_theme_single_post_content() {

        global $defaults;

        $show_post_tag   = (int) $defaults['um_theme_show_post_tags'];
        $show_author_box = (int) $defaults['um_theme_show_post_author_box'];
        ?>

        <div class="entry-content single-article-content">
        <div class="single-article-content-inner">

            <?php
                // Article Content
                the_content();

                // Article Tags
                if ( 1 === $show_post_tag  ) {
                    um_post_tag();
                }

                // Article author box
                if ( 1 === $show_author_box  && is_singular( 'post' ) ) :
                    um_get_single_article_author_box();
                endif;
            ?>
        </div>
        </div>
    <?php
    }
}

/**
 * Output Single Post Comments
 */
if ( ! function_exists( 'um_theme_single_post_comment' ) ) {
    function um_theme_single_post_comment() {

        global $defaults;
        $show_comments          = (int) $defaults['um_theme_show_site_comments'];

        if ( 1 === $show_comments  ) : ?>
            <div class="single-article-comment">
                <div class="website-canvas">
                    <?php
                        /**
                         * Functions hooked in to um_theme_after_page_content action
                         *
                         * @hooked um_theme_output_page_comments - 10
                         */
                        do_action( 'um_theme_after_page_content' );
                    ?>
                </div>
            </div>
        <?php endif;
    }
}

/**
 * Output Single Post Additional Content
 */
if ( ! function_exists( 'um_theme_single_post_additional_content' ) ) {
    function um_theme_single_post_additional_content() {
        global $defaults;
        $show_post_navigation   = (int) $defaults['um_theme_show_post_meta_navigation'];
        ?>

        <div class="single-article-additional">
            <div class="website-canvas">
                <?php
                    if ( 1 === $show_post_navigation  && is_singular( 'post' ) ) {
                        um_theme_the_post_navigation();
                    }

                    um_theme_display_wp_link_pages();
                ?>

            </div>
        </div>
    <?php
    }
}

/**
 * Output Page Comments
 */
if ( ! function_exists( 'um_theme_output_page_comments' ) ) {
    function um_theme_output_page_comments() {
        global $defaults;

        if ( ! post_type_supports( get_post_type(), 'comments' ) ) {
            return;
        }

        if ( true == $defaults['um_theme_show_site_comments']  ) {
            if ( comments_open() || get_comments_number() ) {
                if ( is_singular() && ! in_array( get_post_type(), array( 'post', 'page' ), true ) ) {
                    comments_template( '', true );
                } elseif ( is_singular( 'post' ) ) {
                    comments_template( '', true );
                } elseif ( is_singular( 'page'  ) ) {
                    comments_template( '', true );
                }
           }
        }
    }
}

/**
 * Remove Junk from Headers
 */
if ( ! function_exists( 'um_theme_performance_enhancer' ) ) {
    function um_theme_performance_enhancer() {
        add_filter( 'the_generator', '__return_false' );
        remove_filter( 'wp_title',    'capital_P_dangit', 11 );
        remove_filter( 'the_title',    'capital_P_dangit', 11 );
        remove_filter( 'the_content',  'capital_P_dangit', 11 );
        remove_filter( 'comment_text', 'capital_P_dangit', 31 );
        remove_action( 'wp_head', 'wp_generator' );
        remove_action( 'wp_head', 'rsd_link' );
        remove_action( 'wp_head', 'wlwmanifest_link' );
        remove_action( 'wp_head', 'index_rel_link' );
        remove_action( 'wp_head', 'feed_links', 2 );
        remove_action( 'wp_head', 'feed_links_extra', 3 );
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
        remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
        remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
        remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
    }
}

/**
 * Remove Version info from scripts
 */
if ( ! function_exists( 'um_theme_remove_script_version' ) ) {
    function um_theme_remove_script_version( $src ) {
        $parts = explode( '?ver', $src );
        return $parts[0];
    }
}

/**
 * Output the Header Search ( Member or Generic Search Box )
 */
if ( ! function_exists( 'um_theme_header_search_type' ) ) {
    function um_theme_header_search_type() {
        global $defaults;

        if ( 1 === (int) $defaults['um_show_header_search_type'] && class_exists( 'UM' ) ) {
            echo do_shortcode( '[ultimatemember_searchform]' );
        } else {
            get_search_form();
        }
    }
}

/**
 * Remove widgets dashboard.
 */
if ( ! function_exists( 'um_theme_admin_remove_dashboard_widgets' ) ) {
    function um_theme_admin_remove_dashboard_widgets() {
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );

        // Yoast's SEO Plugin Widget.
        remove_meta_box( 'yoast_db_widget', 'dashboard', 'normal' );
    }
}

/**
 * Archive Section Title
 */
if ( ! function_exists( 'um_theme_archive_content_title' ) ) {
    function um_theme_archive_content_title() {
        echo '<h1 class="page-title">';
        the_archive_title();
        echo '</h1>';
    }
}


/**
 * Archive Section Description
 */
if ( ! function_exists( 'um_theme_archive_content_description' ) ) {
    function um_theme_archive_content_description() {
        echo '<div class="taxonomy-description">';
        the_archive_description();
        echo '</div>';
    }
}

/**
 * Page Header Section
 */
if ( ! function_exists( 'um_theme_output_page_header' ) ) {
    function um_theme_output_page_header() {
        echo '<header class="boot-col-md-12 page__header entry-header">';
        echo '<div class="single page-meta">';
        um_theme_third_party_breadcrumb();

        if ( apply_filters( 'um_theme_show_page_title', true ) ) : ?>
            <h1 class="entry-title">
            <?php the_title();?>
            </h1>
        <?php endif;

        echo '</div>';
        echo '</header>';
    }
}

/**
 * Page Content Section
 */
if ( ! function_exists( 'um_theme_output_page_content' ) ) {
    function um_theme_output_page_content() {
        echo '<div class="entry-content">';
        the_content();
        um_theme_display_wp_link_pages();
        echo '</div>';
    }
}

/**
 * Sticky Sidebar Widgets Opening
 */
if ( ! function_exists( 'um_theme_sticky_sidebar_opening' ) ) {
    function um_theme_sticky_sidebar_opening() {
        global $defaults;
        if ( 1=== (int) $defaults['um_theme_sticky_sidebar'] ) {
            echo '<div class="boot-sticky-top">';
        }
    }
}

/**
 * Sticky Sidebar Widgets Closing
 */
if ( ! function_exists( 'um_theme_sticky_sidebar_closing' ) ) {
    function um_theme_sticky_sidebar_closing() {
        global $defaults;
        if ( 1 === (int) $defaults['um_theme_sticky_sidebar'] ) {
            echo '</div>';
        }
    }
}

/**
 * Output Header Sticky Class
 */
if ( ! function_exists( 'um_theme_output_header_sticky_class' ) ) {
    function um_theme_output_header_sticky_class() {
        global $defaults;
        if ( 1 === (int) $defaults['um_theme_make_header_sticky'] ) {
            echo 'boot-sticky-top';
        }
    }
}

/**
 * Add rel="nofollow" and remove rel="category".
 */
if ( ! function_exists( 'um_theme_modify_category_rel' ) ) {
    function um_theme_modify_category_rel( $text ) {
        $search = array( 'rel="category"', 'rel="category tag"' );
        $text = str_replace( $search, 'rel="nofollow"', $text );

        return $text;
    }
}

/**
 * Add rel="nofollow" and remove rel="tag".
 */
if ( ! function_exists( 'um_theme_modify_tag_rel' ) ) {
    function um_theme_modify_tag_rel( $taglink ) {
        return str_replace( 'rel="tag">', 'rel="nofollow">', $taglink );
    }
}

/**
 * Add image alt tag to post featured image.
 */
if ( ! function_exists( 'um_theme_add_post_featured_image_alt_text' ) ) {
    function um_theme_add_post_featured_image_alt_text( $attr, $attachment = null ) {
        $img_title      = trim( strip_tags( $attachment->post_title ) );
        $attr['alt']    = $img_title;

        return $attr;
    }
}

/**
 * Change the Leave a Reply title from h3 to h4.
 */
if ( ! function_exists( 'um_theme_comment_reply_title' ) ) {
    function um_theme_comment_reply_title( $defaults ){
      $defaults['title_reply_before'] = '<h4 id="reply-title" class="comment-reply-title">';
      $defaults['title_reply_after'] = '</h4>';
      return $defaults;
    }
}

/**
 * Change Default Comment Login link to UM Login Page
 */
if ( ! function_exists( 'um_theme_change_login_link' ) ) {
    function um_theme_change_login_link( $defaults ) {
        if ( class_exists( 'UM' ) ) {
            $defaults['must_log_in'] = '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'um-theme' ), um_get_core_page( 'login' ) ) . '</p>';
            return $defaults;
        }
    }
}

/**
 * This function takes a css-string and compresses it, removing
 * unneccessary whitespace, colons, removing unneccessary px/em
 * declarations etc.
 *
 * @param string $css Styles to be minified.
 * @return string compressed css content
 * @see https://github.com/Schepp/CSS-JS-Booster
 */
if ( ! function_exists( 'um_theme_minify_css' ) ) {
    function um_theme_minify_css( $css ) {
        // Remove comments.
        $css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );

        // Backup values within single or double quotes.
        preg_match_all( '/(\'[^\']*?\'|"[^"]*?")/ims', $css, $hit, PREG_PATTERN_ORDER );
        $count = count( $hit[1] );
        for ( $i = 0; $i < $count; $i++ ) {
            $css = str_replace( $hit[1][ $i ], '##########' . $i . '##########', $css );
        }

        // Remove traling semicolon of selector's last property.
        $css = preg_replace( '/;[\s\r\n\t]*?}[\s\r\n\t]*/ims', "}\r\n", $css );

        // Remove any whitespace between semicolon and property-name.
        $css = preg_replace( '/;[\s\r\n\t]*?([\r\n]?[^\s\r\n\t])/ims', ';$1', $css );

        // Remove any whitespace surrounding property-colon.
        $css = preg_replace( '/[\s\r\n\t]*:[\s\r\n\t]*?([^\s\r\n\t])/ims', ':$1', $css );

        // Remove any whitespace surrounding selector-comma.
        $css = preg_replace( '/[\s\r\n\t]*,[\s\r\n\t]*?([^\s\r\n\t])/ims', ',$1', $css );

        // Remove any whitespace surrounding opening parenthesis.
        $css = preg_replace( '/[\s\r\n\t]*{[\s\r\n\t]*?([^\s\r\n\t])/ims', '{$1', $css );

        // Remove any whitespace between numbers and units.
        $css = preg_replace( '/([\d\.]+)[\s\r\n\t]+(px|em|pt|%)/ims', '$1$2', $css );

        // Shorten zero-values.
        $css = preg_replace( '/([^\d\.]0)(px|em|pt|%)/ims', '$1', $css );

        // Constrain multiple whitespaces.
        $css = preg_replace( '/\p{Zs}+/ims', ' ', $css );

        // Remove newlines.
        $css = str_replace( array( "\r\n", "\r", "\n" ), '', $css );

        // Restore backupped values within single or double quotes.
        $count = count( $hit[1] );
        for ( $i = 0; $i < $count; $i++ ) {
            $css = str_replace( '##########' . $i . '##########', $hit[1][ $i ], $css );
        }
        return $css;
    }
}

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
if ( ! function_exists( 'um_theme_pingback_header' ) ) {
    function um_theme_pingback_header() {
        if ( is_singular() && pings_open( get_queried_object() ) ) {
            printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
        }
    }
}


if ( ! function_exists( 'um_theme_post_thumbnail' ) ) {
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * Create your own um_theme_post_thumbnail() function to override in a child theme.
 *
 * @since UM Theme 1.13
 */
    function um_theme_post_thumbnail( $size = 'um-theme-thumb' ) {

        if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
            return;
        }

        if ( is_singular() ) :

            the_post_thumbnail( $size );

        else : ?>

        <a href="<?php the_permalink(); ?>" class="post-thumbnail">
            <?php the_post_thumbnail( $size, array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
        </a>

        <?php endif; // End is_singular()
    }
}


/**
 * Allow additional file type uploads.
 */
 if( ! function_exists( 'um_theme_extend_upload_mimes' ) ) {

    function um_theme_extend_upload_mimes( $mimes ) {
        $mimes = array_merge(
            $mimes,
            array(
                'mp4'   => 'video/mp4',
                'ogv'   => 'video/ogg',
                'webm'  => 'video/webm',
                'txt'   => 'text/plain'
            )
        );

        return $mimes;
    }
}

 if( ! function_exists( 'um_theme_menu_toggle_button' ) ) {
    function um_theme_menu_toggle_button( $item_output, $item, $depth, $args ) {
        // Add toggle button
        if ( true === is_object( $args ) ) {
            if ( isset( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {
                $item_output = um_theme_menu_arrow_button_markup( $item_output, $item );
            }
        } else {
            if ( isset( $item->post_parent ) && 0 === $item->post_parent ) {
                $item_output = um_theme_menu_arrow_button_markup( $item_output, $item );
            }
        }

        return $item_output;
    }
}

/**
* Get Menu Arrow Button Mark up
*
* @param string  $item_output The menu item's starting HTML output.
* @param WP_Post $item        Menu item data object.
*
* @since 1.16
* @return string Menu item arrow button markup.
*/
 if( ! function_exists( 'um_theme_menu_arrow_button_markup' ) ) {
    function um_theme_menu_arrow_button_markup( $item_output, $item ) {
        $item_output  = apply_filters( 'um_theme_toggle_button_markup', $item_output, $item );
        $item_output .= '<button type="button" class="' . esc_attr(
            'um-theme-menu-toggle',
            array(
                'role'          => 'button',
                'aria-expanded' => 'false',
            ),
            $item
        ) . '"><span class="sr-only sr-only-focusable">' . __( 'Menu Toggle', 'um-theme' ) . '</span></button>';

        return $item_output;
    }
}


/**
 * Breadcrumb Compatibility
 */
 if( ! function_exists( 'um_theme_third_party_breadcrumb' ) ) {
    function um_theme_third_party_breadcrumb() {

        global $defaults;
        if ( 1 === (int) $defaults['um_theme_show_page_breadcumb'] ) {
            echo "<div class='ext-plugin-breadcrumb'>";
            // Yoast SEO Breadcrumb
            if ( function_exists('yoast_breadcrumb') ) {
                yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
            }

            // SEOPress Breadcrumb
            if( function_exists( 'seopress_display_breadcrumbs' ) ) {
                seopress_display_breadcrumbs();
            }

            // Jetpack Breadcrumb
            if ( function_exists( 'jetpack_breadcrumbs' ) ) {
                jetpack_breadcrumbs();
            }

            // Breadcrumb NavXT
            if ( function_exists( 'bcn_display' ) ) {
                bcn_display();
            }

            // Rank Math Breadcrumbs
            if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
                rank_math_the_breadcrumbs();
            }

            echo "</div>";
        }
    }
}

/**
 * Strip unnecessary css classes from article element.
 */
 if( ! function_exists( 'um_theme_clean_post_classes' ) ) {
    function um_theme_clean_post_classes($classes, $class, $post_id) {
        $classes = array_diff( $classes, array(
            'format-standard',
            'category-uncategorized',
            'post-' . $post_id,
            'status-' . get_post_status($post_id),
        ) );

        return array_unique( $classes );
    }
}

/**
 * The formatted output of a list of pages.
 */
 if( ! function_exists( 'um_theme_display_wp_link_pages' ) ) {
    function um_theme_display_wp_link_pages(){
        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'um-theme' ),
            'after'  => '</div>',
        ) );
    }
}

 if( ! function_exists( 'um_theme_search_results_count' ) ) {
    function um_theme_search_results_count(){
        if ( is_search() ) {
            global $wp_query;
            $found_posts = $wp_query->found_posts;

            if ( $found_posts > 0 ) {
                // Translators: $s number of found results.
                $description = sprintf( _n( 'About %s result', 'About %s results', $found_posts, 'um-theme' ), number_format_i18n( $found_posts ) );
            } else {
                $description = esc_html__( 'No results found', 'um-theme' );
            }

            echo "<span class='search-count'>";
            echo esc_html( $description );
            echo "</span>";
        }
    }
}

 if( ! function_exists( 'um_theme_search_display_post_type' ) ) {
    function um_theme_search_display_post_type(){
        global $post;
        echo $post->post_type;
    }
}

/**
 * Co-authors in RSS and other feeds
 * /wp-includes/feed-rss2.php uses the_author(), so we selectively filter the_author value
 */
if( ! function_exists( 'umtheme_coauthors_in_rss' ) ) {
    function umtheme_coauthors_in_rss( $the_author ) {
        if ( ! is_feed() || ! function_exists( 'coauthors' ) ) {
            return $the_author;
        } else {
            return coauthors( null, null, null, null, false );
        }
    }
}

/**
* Show multiple Co-Author biography fields at the bottom of a single post
*/
if( ! function_exists( 'umtheme_display_coauthor_box' ) ) {
    function umtheme_display_coauthor_box() {

        if ( class_exists( 'coauthors_plus' ) ) {

            $coauthors = get_coauthors();
            foreach( $coauthors as $key => $coauthor ) {
                ?>
            <div class="article-author-box boot-text-center">
                <div class="author-box-profile">
                    <div class="author-image">
                        <a href="<?php echo esc_url( get_author_posts_url( $coauthor->ID, $coauthor->user_nicename ) );?>" class="post-meta-author-link">
                            <?php echo get_avatar( $coauthor->user_email, '80' );?>
                        </a>
                    </div>
                    <?php if ( $coauthor->display_name ) : ?>
                        <h5 class="author-name">
                            <a href="<?php echo esc_url( get_author_posts_url( $coauthor->ID, $coauthor->user_nicename ) );?>" class="post-meta-author-link">
                                <?php echo esc_attr( $coauthor->display_name );?>
                            </a>
                        </h5>
                    <?php endif;?>

                    <?php if ( $coauthor->description ) : ?>
                        <p class="meta author-bio"><?php echo $coauthor->description;?></p>
                    <?php endif;?>
                </div>
            </div>
                <?php
            }
        }
    }
}

if ( ! function_exists( 'umtheme_display_postView_count' ) ) {
    function umtheme_display_postView_count(){
        if ( function_exists('the_views') ){
            echo '<span class="post-views">';
            the_views();
            echo '</span>';
        }
    }
}

if ( ! function_exists( 'umtheme_display_postRatings_count' ) ) {
    function umtheme_display_postRatings_count(){
        if ( function_exists('the_ratings') ){
            the_ratings();
        }
    }
}