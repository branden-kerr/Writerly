<?php
/**
 * Helper functions for bbPress
 *
 * @package     um-theme
 * @subpackage  woocommerce
 * @uses        [add_theme_support](https://developer.wordpress.org/reference/functions/add_theme_support/) To enable WooCommerce support.
 * @link        https://docs.woothemes.com/document/third-party-custom-theme-compatibility/
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       0.5
 */
global $defaults;

// If plugin - 'WooCommerce' not exist then return.
if ( ! class_exists( 'WooCommerce' ) ) {
    return;
}

$show_cart_button       = $defaults['um_theme_woocommerce_shop_show_add_cart'];
$show_product_title     = $defaults['um_theme_woocommerce_shop_show_product_title'];
$show_product_price     = $defaults['um_theme_woocommerce_shop_show_product_price'];
$show_product_sale      = $defaults['um_theme_woocommerce_shop_show_sale_badge'];

/**
 * WooCommerce Performance
 */
add_action( 'get_header',  'um_theme_woo_remove_wc_generator' );
add_action( 'woocommerce_init','um_theme_woo_remove_wc_generator' );

/**
 * WooCommerce Content Wrappers
 */
add_action( 'woocommerce_before_main_content', 'um_theme_woocommerce_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'um_theme_woocommerce_wrapper_content_end', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * WooCommerce Sidebars
 */
add_action( 'woocommerce_sidebar', 'um_theme_woocommerce_sidebar', 10 );
add_action( 'woocommerce_sidebar', 'um_theme_woocommerce_wrapper_end', 12 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * WooCommerce Theme Support
 */
add_action( 'after_setup_theme', 'um_theme_wc_setup' );
add_action( 'woocommerce_before_shop_loop', 'um_theme_render_premmerce_active_filters_widget', 40 );
add_action( 'woocommerce_after_shop_loop_item', 'um_theme_display_yith_wishlist_below_product_price', 97 );

/**
 * WooCommerce Product Upsell
 */
add_filter( 'woocommerce_upsell_display_args', 'um_theme_upsell_products_args' );

add_filter( 'woocommerce_catalog_orderby', 'um_theme_woocommerce_catalog_orderby_labels', 20 );
add_filter( 'woocommerce_sale_flash', 'um_theme_remove_exclamation_woocommerce_sale_flash' );
add_filter( 'get_the_archive_title', 'um_theme_woocommerce_custom_archive_title' );
add_filter( 'woocommerce_breadcrumb_defaults', 'um_theme_woocommerce_breadcrumb_delimiter' );

/**
 * WooCommerce Related Products
 */
if ( 2 === (int) $defaults['um_theme_show_woo_related'] ) {
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
}

add_filter( 'woocommerce_output_related_products_args', 'um_theme_related_products_args' );

/**
 * Remove 0 from product review tab if there is no review.
 */
add_filter( 'woocommerce_product_tabs', 'um_theme_remove_zero_for_product_review_tab', 98 );

/**
 * WooCommerce Body Class
 */
add_filter( 'body_class', 'um_theme_wc_l10n_body_class' );

/**
 * WooCommerce Shop Products Title
 */
if ( $show_product_title === 0 ) {
    remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
}

/**
 * WooCommerce Shop Products Price
 */
if ( $show_product_price === 0 ) {
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
}

/**
 * WooCommerce Shop Products Add to Cart Button
 */
if ( $show_cart_button === 0 ) {
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}

/**
 * WooCommerce Shop Products Sale Badge
 */
if ( $show_product_sale === 0 ) {
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
}

/**
 * WooCommerce Shop Layout
 */
if ( $defaults['um_theme_woo_product_layout'] === 2 ) {
    add_action( 'woocommerce_before_shop_loop_item', 'um_theme_bootstrap_class_row', 5 );
    add_action( 'woocommerce_before_shop_loop_item', 'um_theme_bootstrap_class_column_six', 6 );
    add_action( 'woocommerce_before_shop_loop_item_title', 'um_theme_bootstrap_class_close_div', 15 );
    add_action( 'woocommerce_shop_loop_item_title', 'um_theme_bootstrap_class_column_six', 5 );
    add_action( 'woocommerce_after_shop_loop_item', 'um_theme_bootstrap_class_close_div', 12 );
    add_action( 'woocommerce_after_shop_loop_item', 'um_theme_bootstrap_class_close_div', 15 );
}

/**
 * WooCommerce Theme Support
 */
if ( ! function_exists( 'um_theme_wc_setup' ) ) {
    function um_theme_wc_setup() {
        // WooCommerce Integration
        add_theme_support( 'woocommerce' );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }
}

/**
 * Add body class to indicate when WooCommerce is localized.
 *
 * @filter body_class
 *
 * @since  0.50
 *
 * @param  array $classes Array of body classes.
 *
 * @return array
 */
if ( ! function_exists( 'um_theme_wc_l10n_body_class' ) ) {
    function um_theme_wc_l10n_body_class( array $classes ) {
        global $l10n;
        if ( ! empty( $l10n['woocommerce'] ) ) {
            $classes[] = 'um-woocommerce-l10n';
        }
        return $classes;
    }
}

/**
* Remove generator from WooCommerce old versions
*/
if ( ! function_exists( 'um_theme_woo_remove_wc_generator' ) ) {
    function um_theme_woo_remove_wc_generator() {

        // Generator WC function
        // WC >= 2.1.0
        remove_action( 'wp_head', 'wc_generator_tag' );

        // Generator method depending on the global WC object
        if ( isset( $GLOBALS['woocommerce'] ) && is_object( $GLOBALS['woocommerce'] ) ) {
            // WC < 2.1.0
            remove_action( 'wp_head', [$GLOBALS['woocommerce'], 'generator'] );
        }
    }
}

/**
* WooCommerce Content Wrapper Start
*/
if ( ! function_exists( 'um_theme_woocommerce_wrapper_start' ) ) {
    function um_theme_woocommerce_wrapper_start() {
        ?>
        <div class="website-canvas">
        <?php do_action( 'um_theme_woo_before_content' ); ?>
        <div class="boot-row">
        <div class="<?php um_determine_single_content_width();?>">
        <?php
    }
}

/**
* WooCommerce Content Wrapper End
*/
if ( ! function_exists( 'um_theme_woocommerce_wrapper_content_end' ) ) {
    function um_theme_woocommerce_wrapper_content_end() {
        echo '</div>';
    }
}

/**
* WooCommerce Wrapper End
*/
if ( ! function_exists( 'um_theme_woocommerce_wrapper_end' ) ) {
    function um_theme_woocommerce_wrapper_end() {
        echo '</div></div>';
    }
}

/**
* WooCommerce Sidebar Content
*/
if ( ! function_exists( 'um_theme_woocommerce_sidebar' ) ) {
    function um_theme_woocommerce_sidebar() {

        global $defaults;
        $woo_shop           = (int) $defaults['um_theme_show_sidebar_woo_archive'];
        $woo_product        = (int) $defaults['um_theme_show_sidebar_woo_product'];

        if ( ! um_theme_active_page_sidebar() ) { return;}

        if ( is_post_type_archive('product') && $woo_shop === 1 or is_product_category() && $woo_shop === 1 or is_product_tag() && $woo_shop === 1 ) {
            ?>
            <aside id="secondary" class="widget-area widget-area-side <?php um_theme_determine_sidebar_position();?> <?php um_determine_single_sidebar_width();?>" role="complementary">
            <?php
            do_action( 'um_theme_before_sidebar' );
            dynamic_sidebar( 'sidebar-page' );
            do_action( 'um_theme_after_sidebar' );
            echo '</aside>';
        } elseif ( is_singular( 'product' ) && $woo_product === 1 ) {
            ?>
            <aside id="secondary" class="widget-area widget-area-side <?php um_theme_determine_sidebar_position();?> <?php um_determine_single_sidebar_width();?>" role="complementary">
            <?php
            do_action( 'um_theme_before_sidebar' );
            dynamic_sidebar( 'sidebar-page' );
            do_action( 'um_theme_after_sidebar' );
            echo '</aside>';
        }
    }
}
/**
* Bootstrap CSS Class : row
*/
if ( ! function_exists( 'um_theme_bootstrap_class_row' ) ) {
    function um_theme_bootstrap_class_row() {
        echo "<div class='boot-row'>";
    }
}

/**
* Bootstrap CSS Class : Column 6
*/
if ( ! function_exists( 'um_theme_bootstrap_class_column_six' ) ) {
    function um_theme_bootstrap_class_column_six() {
        echo "<div class='boot-col-md-6'>";
    }
}

/**
* Bootstrap CSS Class : Colse Div Once
*/
if ( ! function_exists( 'um_theme_bootstrap_class_close_div' ) ) {
    function um_theme_bootstrap_class_close_div() {
        echo '</div>';
    }
}

/**
* WooCommerce Related Products Per page
*/
if ( ! function_exists( 'um_theme_related_products_args' ) ) {
    function um_theme_related_products_args( $args ) {
        global $defaults;
        $args['posts_per_page'] = (int) $defaults['um_theme_woo_related_product_no'];
        return $args;
    }
}

/**
* WooCommerce Upsell Products Per page
*/
if ( ! function_exists( 'um_theme_upsell_products_args' ) ) {
    function um_theme_upsell_products_args( $args ) {
        global $defaults;
        $args['posts_per_page'] = (int) $defaults['um_theme_woo_upsell_product_no'];
        return $args;
    }
}


/**
* WooCommerce Remove 0 from product review tabs
*/
if ( ! function_exists( 'um_theme_remove_zero_for_product_review_tab' ) ) {
    function um_theme_remove_zero_for_product_review_tab( $tabs ) {
        global $product;
        $product_review_count = $product->get_review_count();
        if ( $product_review_count === 0 ) {
            $tabs['reviews']['title'] = 'Reviews';
        } else {
            $tabs['reviews']['title'] = 'Reviews(' . $product_review_count . ')';
        }
        return $tabs;
    }
}

/**
* Reset Filters for Premmerce WooCommerce Product Filter Pro
*/
if ( !function_exists( 'um_theme_render_premmerce_active_filters_widget' ) ) {
    function um_theme_render_premmerce_active_filters_widget() {

        if ( function_exists( 'premmerce_pwpf_fs' ) ) {
            ob_start();
            the_widget( 'Premmerce\\Filter\\Widget\\ActiveFilterWidget' );
            $widget = ob_get_clean();

            if ( trim( strip_tags( $widget ) ) != '' ) : ?>
                <div class="content__row content__row--sm">
                    <div class="pc-active-filter pc-active-filter--hor">
                        <?php echo $widget; ?>
                    </div>
                </div>
            <?php
            endif;
        }
    }
}

/**
* YITH WooCommerce Wishlist compatibility.
*/
if ( ! function_exists( 'um_theme_display_yith_wishlist_below_product_price' ) ) {
    function um_theme_display_yith_wishlist_below_product_price() {
        global $defaults;
        if ( class_exists( 'YITH_WCWL' ) ) {
            if ( true == wp_validate_boolean($defaults['um_theme_yith_show_wishlist_product_loop'] )) {
                echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
            }
        }
    }
}

/**
 * Modify the default WooCommerce orderby dropdown labels in the mini-bar.
 *
 * Create your own um_theme_woocommerce_catalog_orderby_labels() to override in a child theme.
 */
if ( ! function_exists( 'um_theme_woocommerce_catalog_orderby_labels' ) ) {
    function um_theme_woocommerce_catalog_orderby_labels( $orderby ) {
        $orderby['menu_order'] = esc_html__( 'All', 'um-theme' );
        $orderby['popularity'] = esc_html__( 'Popularity', 'um-theme' );
        $orderby['rating']     = esc_html__( 'Rating', 'um-theme' );
        $orderby['date']       = esc_html__( 'Newest', 'um-theme' );
        $orderby['price']      = esc_html__( 'Price: Low to High', 'um-theme' );
        $orderby['price-desc'] = esc_html__( 'Price: High to Low', 'um-theme' );

        return $orderby;
    }
}

/*
 * Remove ! from sale badge.
 */
if ( ! function_exists( 'um_theme_remove_exclamation_woocommerce_sale_flash' ) ) {
    function um_theme_remove_exclamation_woocommerce_sale_flash( $html ) {
        return str_replace( '!', '', $html );
    }
}

/**
 * Removes the "Product Category:" from the Archive Title
 */
if ( ! function_exists( 'um_theme_woocommerce_custom_archive_title' ) ) {
    function um_theme_woocommerce_custom_archive_title( $title ) {
        if ( is_tax() ) {
            $title = single_cat_title( '', false );
        }
        return $title;
    }
}


/**
 * Change the breadcrumb separator
 */
if ( ! function_exists( 'um_theme_woocommerce_breadcrumb_delimiter' ) ) {
    function um_theme_woocommerce_breadcrumb_delimiter( $defaults ) {
        // Change the breadcrumb delimeter from '/' to '>'
        $defaults['delimiter'] = '<i class="woo-delimeter fas fa-chevron-right"></i>';
        return $defaults;
    }
}