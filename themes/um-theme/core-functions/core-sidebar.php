<?php

global $defaults;

/**
 * Check if Right sidebar is active.
 */
if ( ! function_exists( 'um_theme_active_page_sidebar' ) ) {
    function um_theme_active_page_sidebar() {
        if ( is_active_sidebar( 'sidebar-page' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Output the main contents width.
 */
if ( ! function_exists( 'um_determine_blog_content_width' ) ) {
    function um_determine_blog_content_width() {

        global $defaults;
        $archive_status     = (int) $defaults['um_theme_show_sidebar_archive_page'];
        $sidebar_width      = (int) $defaults['um_theme_layout_single_sidebar_width'];

        if ( $archive_status === 1 && is_active_sidebar( 'sidebar-page' ) ) {
            if ( $sidebar_width === 1 ) {
                echo ' boot-col-md-9';
            } elseif ( $sidebar_width === 2 ) {
                echo ' boot-col-md-8';
            } elseif ( $sidebar_width === 3 ) {
                echo ' boot-col-md-7';
            } else{
                echo ' boot-col-md-6';
            }
        } else {
            echo ' boot-col-12';
        }
    }
}

/**
 * Including class for sidebar widget css class.
 */
if ( ! function_exists( 'um_determine_single_content_width' ) ) {
    function um_determine_single_content_width() {

        global $defaults;

        $sidebar_width      = (int) $defaults['um_theme_layout_single_sidebar_width'];
        $post_status        = (int) $defaults['um_theme_show_sidebar_post'];
        $page_status        = (int) $defaults['um_theme_show_sidebar_page'];
        $archive_status     = (int) $defaults['um_theme_show_sidebar_archive_page'];
        $search_status      = (int) $defaults['um_theme_show_sidebar_search'];
        $group_status       = (int) $defaults['um_theme_show_sidebar_group'];
        $bbpress_forum      = (int) $defaults['um_theme_show_sidebar_bb_forum'];
        $bbpress_topic      = (int) $defaults['um_theme_show_sidebar_bb_topic'];
        $bbpress_reply      = (int) $defaults['um_theme_show_sidebar_bb_reply'];
        $woo_shop           = (int) $defaults['um_theme_show_sidebar_woo_archive'];
        $woo_product        = (int) $defaults['um_theme_show_sidebar_woo_product'];
        $forumwp_forum      = (int) $defaults['um_theme_show_sidebar_forumwp_forum'];
        $forumwp_topic      = (int) $defaults['um_theme_show_sidebar_forumwp_topic'];
        $forumwp_tag        = (int) $defaults['um_theme_show_sidebar_forumwp_tag'];
        $forumwp_cat        = (int) $defaults['um_theme_show_sidebar_forumwp_cat'];
        $wpadverts_archive  = (int) $defaults['um_theme_show_sidebar_wpadverts_archive'];
        $wpadverts_single   = (int) $defaults['um_theme_show_sidebar_wpadverts_single'];

        // Singular
        if ( is_singular() && !is_singular( 'post' ) && !is_page() ) {
            if ( $post_status === 1 ) {
                if ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 1 ) {
                    echo ' boot-col-md-9 ';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 2 ) {
                    echo ' boot-col-md-8 ';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 3 ) {
                    echo ' boot-col-md-7 ';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 4 ) {
                    echo ' boot-col-md-6 ';
                } else {
                    echo ' boot-col-md-12 ';
                }
            } else {
                echo ' boot-col-12';
            }
        }

        // Post
        if ( is_singular( 'post' ) ) {
            if ( $post_status === 1 ) {
                if ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 1 ) {
                    echo ' boot-col-md-9';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 2 ) {
                    echo ' boot-col-md-8';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 3 ) {
                    echo ' boot-col-md-7';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 4 ) {
                    echo ' boot-col-md-6';
                } else {
                    echo ' boot-col-md-12';
                }
            } else {
                echo ' boot-col-12';
            }
        }

        // Page
        if ( is_page() ) {
            if ( $page_status === 1 ) {
                if ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 1 ) {
                    echo ' boot-col-md-9';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 2 ) {
                    echo ' boot-col-md-8';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 3 ) {
                    echo ' boot-col-md-7';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 4 ) {
                    echo ' boot-col-md-6';
                } else {
                    echo ' boot-col-md-12';
                }
            } else {
                echo ' boot-col-12';
            }
        }

        // Archive Pages
        if ( is_archive() && ! is_post_type_archive( 'product' ) ) {
            if ( $archive_status === 1 ) {
                if ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 1 ) {
                    echo ' boot-col-md-9';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 2 ) {
                    echo ' boot-col-md-8';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 3 ) {
                    echo ' boot-col-md-7';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 4 ) {
                    echo ' boot-col-md-6';
                } else {
                    echo ' boot-col-md-12';
                }
            } else {
                echo ' boot-col-12';
            }
        }

        // Search Page
        if ( is_search() ) {
            if ( $search_status === 1 ) {
                if ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 1 ) {
                    echo ' boot-col-md-9';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 2 ) {
                    echo ' boot-col-md-8';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 3 ) {
                    echo ' boot-col-md-7';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 4 ) {
                    echo ' boot-col-md-6';
                } else {
                    echo ' boot-col-md-12';
                }
            } else {
                echo ' boot-col-12';
            }
        }

        // WooCommerce
        if ( class_exists( 'WooCommerce' ) ) {

            if ( is_post_type_archive('product') or is_product_category() or is_product_tag() ) {
                if ( $woo_shop === 1 ) {
                    if ( $sidebar_width === 1 ) {
                        echo ' boot-col-md-9';
                    } elseif ( $sidebar_width === 2 ) {
                        echo ' boot-col-md-8';
                    } elseif ( $sidebar_width === 3 ) {
                        echo ' boot-col-md-7';
                    } elseif ( $sidebar_width === 4 ) {
                        echo ' boot-col-md-6';
                    } else {
                        echo ' boot-col-md-12';
                    }
                } else {
                    echo ' boot-col-12';
                }
            }

            if ( is_singular( 'product' ) ) {
                if ( $woo_product === 1 && $sidebar_width === 1 ) {
                    echo ' boot-col-md-9';
                } elseif ( $woo_product === 1 && $sidebar_width === 2 ) {
                    echo ' boot-col-md-8';
                } elseif ( $woo_product === 1 && $sidebar_width === 3 ) {
                    echo ' boot-col-md-7';
                } elseif ( $woo_product === 1 && $sidebar_width === 4 ) {
                    echo ' boot-col-md-6';
                } else {
                    echo ' boot-col-md-12';
                }
            }
        }


        // WPAdverts
        if ( class_exists( 'Adverts' ) ) {

            if ( is_post_type_archive('advert') ) {
                if ( $wpadverts_archive === 1 ) {
                    if ( $sidebar_width === 1 ) {
                        echo ' boot-col-md-9';
                    } elseif ( $sidebar_width === 2 ) {
                        echo ' boot-col-md-8';
                    } elseif ( $sidebar_width === 3 ) {
                        echo ' boot-col-md-7';
                    } elseif ( $sidebar_width === 4 ) {
                        echo ' boot-col-md-6';
                    } else {
                        echo ' boot-col-md-12';
                    }
                } else {
                    echo ' boot-col-12';
                }
            }

            if ( is_singular( 'advert' ) ) {
                if ( $wpadverts_single === 1 && $sidebar_width === 1 ) {
                    echo ' boot-col-md-9';
                } elseif ( $wpadverts_single === 1 && $sidebar_width === 2 ) {
                    echo ' boot-col-md-8';
                } elseif ( $wpadverts_single === 1 && $sidebar_width === 3 ) {
                    echo ' boot-col-md-7';
                } elseif ( $wpadverts_single === 1 && $sidebar_width === 4 ) {
                    echo ' boot-col-md-6';
                } else {
                    echo ' boot-col-md-12';
                }
            }
        }

        // The Events Calendar Plugin
        if ( class_exists( 'Tribe__Events__Main' ) ) {

            // Events Page
            if ( is_singular( 'tribe_events' ) ) {
                if ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 1 ) {
                    echo ' boot-col-md-9';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 2 ) {
                    echo ' boot-col-md-8';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 3 ) {
                    echo ' boot-col-md-7';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 4 ) {
                    echo ' boot-col-md-6';
                } else {
                    echo ' boot-col-md-12';
                }
            }

            // Venue Page
            if ( is_singular( 'tribe_venue' ) ) {
                if ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 1 ) {
                    echo ' boot-col-md-9';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 2 ) {
                    echo ' boot-col-md-8';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 3 ) {
                    echo ' boot-col-md-7';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 4 ) {
                    echo ' boot-col-md-6';
                } else {
                    echo ' boot-col-md-12';
                }
            }

            // Organizer Page
            if ( is_singular( 'tribe_organizer' ) ) {
                if ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 1) {
                    echo ' boot-col-md-9';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 2 ) {
                    echo ' boot-col-md-8';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 3 ) {
                    echo ' boot-col-md-7';
                } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 4 ) {
                    echo ' boot-col-md-6';
                } else {
                    echo ' boot-col-md-12';
                }
            }
        }

        // UM Groups Page
        if ( class_exists( 'UM' ) && function_exists( 'um_groups_plugins_loaded' ) ) {
            if ( is_singular( 'um_groups' ) || um_is_core_page('groups') ) {
                if ( $sidebar_width === 1 && $group_status === 1 ) {
                    echo ' boot-col-md-9';
                } elseif ( $sidebar_width === 2 && $group_status === 1 ) {
                    echo ' boot-col-md-8';
                } elseif ( $sidebar_width === 3 && $group_status === 1 ) {
                    echo ' boot-col-md-7';
                } elseif ( $sidebar_width === 4 && $group_status === 1 ) {
                    echo ' boot-col-md-6';
                } else {
                    echo ' boot-col-md-12';
                }
            }
        }

        // bbPress
        if ( class_exists( 'bbPress' ) ) {
            // bbPress Forums
            if ( is_singular( 'forum' ) ) {
                if ( $sidebar_width === 1 && $bbpress_forum === 1 ) {
                    echo 'boot-col-md-9';
                } elseif ( $sidebar_width === 2 && $bbpress_forum === 1 ) {
                    echo 'boot-col-md-8';
                } elseif ( $sidebar_width === 3 && $bbpress_forum === 1 ) {
                    echo 'boot-col-md-7';
                } elseif ( $sidebar_width === 4 && $bbpress_forum === 1 ) {
                    echo 'boot-col-md-6';
                } else {
                    echo 'boot-col-md-12';
                }
            }

            // bbPress Topics
            if ( is_singular( 'topic' ) ) {
                if ( $sidebar_width === 1 && $bbpress_topic === 1 ) {
                    echo 'boot-col-md-9';
                } elseif ( $sidebar_width === 2 && $bbpress_topic === 1 ) {
                    echo 'boot-col-md-8';
                } elseif ( $sidebar_width === 3 && $bbpress_topic === 1 ) {
                    echo 'boot-col-md-7';
                } elseif ( $sidebar_width === 4 && $bbpress_topic === 1 ) {
                    echo 'boot-col-md-6';
                } else {
                    echo 'boot-col-md-12';
                }
            }

            // bbPress Reply
            if ( is_singular( 'reply' ) ) {
                if ( $sidebar_width === 1 ) {
                    echo 'boot-col-md-9';
                } elseif ( $sidebar_width === 2 && $bbpress_reply === 1 ) {
                    echo 'boot-col-md-8';
                } elseif ( $sidebar_width === 3 && $bbpress_reply === 1 ) {
                    echo 'boot-col-md-7';
                } elseif ( $sidebar_width === 4 && $bbpress_reply === 1 ) {
                    echo 'boot-col-md-6';
                } else {
                    echo 'boot-col-md-12';
                }
            }
        } // bbPress


        // ForumWP
        if ( class_exists( 'FMWP' ) ) {
            // ForumWP Forums
            if ( is_singular( 'fmwp_forum' ) ) {
                if ( $sidebar_width === 1 && $forumwp_forum === 1 ) {
                    echo ' boot-col-md-9';
                } elseif ( $sidebar_width === 2 && $forumwp_forum === 1 ) {
                    echo ' boot-col-md-8';
                } elseif ( $sidebar_width === 3 && $forumwp_forum === 1 ) {
                    echo ' boot-col-md-7';
                } elseif ( $sidebar_width === 4 && $forumwp_forum === 1 ) {
                    echo ' boot-col-md-6';
                } else {
                    echo ' boot-col-md-12';
                }
            }

            // ForumWP Topics
            if ( is_singular( 'fmwp_topic' ) ) {
                if ( $sidebar_width === 1 && $forumwp_topic === 1 ) {
                    echo ' boot-col-md-9';
                } elseif ( $sidebar_width === 2 && $forumwp_topic === 1 ) {
                    echo ' boot-col-md-8';
                } elseif ( $sidebar_width === 3 && $forumwp_topic === 1 ) {
                    echo ' boot-col-md-7';
                } elseif ( $sidebar_width === 4 && $forumwp_topic === 1 ) {
                    echo ' boot-col-md-6';
                } else {
                    echo ' boot-col-md-12';
                }
            }

            // ForumWP Category
            if ( is_tax( 'fmwp_forum_category' ) ) {
                if ( $sidebar_width === 1 ) {
                    echo ' boot-col-md-9';
                } elseif ( $sidebar_width === 2 && $forumwp_cat === 1 ) {
                    echo ' boot-col-md-8';
                } elseif ( $sidebar_width === 3 && $forumwp_cat === 1 ) {
                    echo ' boot-col-md-7';
                } elseif ( $sidebar_width === 4 && $forumwp_cat === 1 ) {
                    echo ' boot-col-md-6';
                } else {
                    echo ' boot-col-md-12';
                }
            }

            // ForumWP Tag
            if ( is_tax( 'fmwp_topic_tag' ) ) {
                if ( $sidebar_width === 1 ) {
                    echo ' boot-col-md-9';
                } elseif ( $sidebar_width === 2 && $forumwp_tag === 1 ) {
                    echo ' boot-col-md-8';
                } elseif ( $sidebar_width === 3 && $forumwp_tag === 1 ) {
                    echo ' boot-col-md-7';
                } elseif ( $sidebar_width === 4 && $forumwp_tag === 1 ) {
                    echo ' boot-col-md-6';
                } else {
                    echo ' boot-col-md-12';
                }
            }
        } // ForumWP

    } // um_determine_single_content_width
}


/**
 * Assign Sidebar Width
 */
if ( ! function_exists( 'um_determine_single_sidebar_width' ) ) {
    function um_determine_single_sidebar_width() {
      global $defaults;
      $sidebar_width = $defaults['um_theme_layout_single_sidebar_width'];

        if ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 1 ) {
            echo 'boot-col-md-3';
        } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 2 ) {
            echo 'boot-col-md-4';
        } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 3 ) {
            echo 'boot-col-md-5';
        } elseif ( is_active_sidebar( 'sidebar-page' ) && $sidebar_width === 4 ) {
            echo 'boot-col-md-6';
        } else {
            echo 'boot-col-md-12';
        }
    }
}


/**
 * Sidebar Position ( Left or Right )
 */
if ( ! function_exists( 'um_theme_determine_sidebar_position' ) ) {
    function um_theme_determine_sidebar_position() {
        global $defaults;
        $sidebar_position = (int) $defaults['um_theme_content_sidebar_position'];

    	if ( $sidebar_position === 1 ) {
    		echo 'boot-order-last';
    	} else {
            echo 'boot-order-first';
        }
    }
}

/**
 * Register widget areas.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
if ( ! function_exists( 'um_theme_widgets_init' ) ) {
    function um_theme_widgets_init() {

    register_sidebar(
        apply_filters(
            'um_theme_page_widget_args',
            array(
                'name'          => esc_html__( 'Content Sidebar', 'um-theme' ),
                'id'            => 'sidebar-page',
                'description'   => esc_html__( 'These widgets will be only visible in Post, Page & Archive pages','um-theme' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => apply_filters( 'um_theme_start_widget_title', '<h3 class="widget-title">' ),
                'after_title'   => apply_filters( 'um_theme_end_widget_title', '</h3>' ),
            )
        )
    );

    register_sidebar(
        apply_filters(
            'um_theme_profile_widget_args',
            array(
                'name'          => esc_html__( 'Profile Sidebar', 'um-theme' ),
                'id'            => 'sidebar-profile',
                'description'   => esc_html__( 'These widgets will be only visible in Ultimate Member Profile pages','um-theme' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => apply_filters( 'um_theme_start_widget_title', '<h3 class="widget-title">' ),
                'after_title'   => apply_filters( 'um_theme_end_widget_title', '</h3>' ),
            )
        )
    );

    register_sidebar(
        apply_filters(
            'um_theme_footer_widget_1_args',
            array(
                'name'          => esc_html__( 'Footer Column 1', 'um-theme' ),
                'id'            => 'sidebar-footer-one',
                'description'   => esc_html__( 'These widgets will be only visible in footer 1.','um-theme' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => apply_filters( 'um_theme_start_footer_widget_title', '<h3 class="widget-title">' ),
                'after_title'   => apply_filters( 'um_theme_end_footer_widget_title', '</h3>' ),
            )
        )
    );

    register_sidebar(
        apply_filters(
            'um_theme_footer_widget_2_args',
            array(
                'name'          => esc_html__( 'Footer Column 2', 'um-theme' ),
                'id'            => 'sidebar-footer-two',
                'description'   => esc_html__( 'These widgets will be only visible in footer 2.','um-theme' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => apply_filters( 'um_theme_start_footer_widget_title', '<h3 class="widget-title">' ),
                'after_title'   => apply_filters( 'um_theme_end_footer_widget_title', '</h3>' ),
            )
        )
    );

    register_sidebar(
        apply_filters(
            'um_theme_footer_widget_3_args',
            array(
                'name'          => esc_html__( 'Footer Column 3', 'um-theme' ),
                'id'            => 'sidebar-footer-three',
                'description'   => esc_html__( 'These widgets will be only visible in footer 3.','um-theme' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => apply_filters( 'um_theme_start_footer_widget_title', '<h3 class="widget-title">' ),
                'after_title'   => apply_filters( 'um_theme_end_footer_widget_title', '</h3>' ),
            )
        )
    );

    register_sidebar(
        apply_filters(
            'um_theme_footer_widget_4_args',
             array(
                'name'          => esc_html__( 'Footer Column 4', 'um-theme' ),
                'id'            => 'sidebar-footer-four',
                'description'   => esc_html__( 'These widgets will be only visible in footer 4.','um-theme' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => apply_filters( 'um_theme_start_footer_widget_title', '<h3 class="widget-title">' ),
                'after_title'   => apply_filters( 'um_theme_end_footer_widget_title', '</h3>' ),
            )
         )
    );

    register_widget( 'Um_Theme_Widget_New_Members' );

    register_widget( 'UM_Theme_Widget_User_Profile' );
    }
}

if ( ! function_exists( 'um_theme_display_sidebar_condition' ) ) {
    function um_theme_display_sidebar_condition(){
        ?>
        <aside id="secondary" class="widget-area widget-area-side <?php um_theme_determine_sidebar_position();?> <?php um_determine_single_sidebar_width();?>" role="complementary">
            <?php
            do_action( 'um_theme_before_sidebar' );
            dynamic_sidebar( 'sidebar-page' );
            do_action( 'um_theme_after_sidebar' );
            ?>
        </aside>
        <?php
    }
}