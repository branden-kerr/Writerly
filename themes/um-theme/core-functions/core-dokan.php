<?php
/**
 * Helper functions for Dokan Multivendor.
 *
 * @package     um-theme
 * @subpackage  dokan
 * @link        https://wordpress.org/plugins/dokan-lite/
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */
global $defaults;

/**
 * Enable support for Dokan Multivendor.
 */

// If plugin - 'Dokan' not exist then return.
if ( ! class_exists( 'WeDevs_Dokan' ) ) {
    return;
}

if ( class_exists( 'WeDevs_Dokan' ) ) {
    add_action( 'woocommerce_after_shop_loop_item_title','um_theme_dokan_product_loop_sold_by', 100 );
    add_action( 'woocommerce_single_product_summary', 'um_theme_display_dokan_vendor_information', 8 );
}


/*
 * Show Seller name on product loop For Dokan Multivendor plugin
 */
if ( ! function_exists( 'um_theme_dokan_product_loop_sold_by' ) ) {
    function um_theme_dokan_product_loop_sold_by(){
        global $defaults;
        if ( class_exists( 'WeDevs_Dokan' ) && 
            true == wp_validate_boolean( $defaults['um_theme_dokan_shop_show_sold_by'] )) {
    ?>
        </a>
        <?php
            global $product;

            $seller     = get_post_field( 'post_author', $product->get_id());
            $author     = get_user_by( 'id', $seller );
            $store_info = dokan_get_store_info( $author->ID );

            if ( !empty( $store_info['store_name'] ) ) { ?>
                <div class="dokan-sold-by">
                    <?php printf( 'Sold by: <a href="%s">%s</a>', dokan_get_store_url( $author->ID ), $author->display_name ); ?>
                </div>
            <?php
            }
        }
    }
}

/*
 * Show Seller name below product title For Dokan Multivendor plugin
 */
if ( ! function_exists( 'um_theme_display_dokan_vendor_information' ) ) {
    function um_theme_display_dokan_vendor_information() {
        global $defaults;
        if ( class_exists( 'WeDevs_Dokan' ) && 
            true == wp_validate_boolean( $defaults['um_theme_dokan_single_vendor_info'] )) {

            // Get the author ID (the vendor ID)
            $vendor_id = (int) get_post_field( 'post_author', get_the_id() );
            // Get the WP_User object (the vendor) from author ID
            $vendor         = new WP_User( $vendor_id );
            $store_info     = dokan_get_store_info( $vendor_id );   // Get the store data
            $store_name     = (string) $store_info['store_name'];            // Get the store name
            $store_url      = (string) dokan_get_store_url( $vendor_id );    // Get the store URL

            echo "<div class='single-vendor-info'>";
            esc_html_e( 'Seller Name:', 'um-theme' );
            echo "<a href='$store_url'>$store_name</a>";
            echo "</div>";
        }
    }
}