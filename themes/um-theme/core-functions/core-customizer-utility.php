<?php
/**
 * Customizer Helper Functions.
 *
 * @package     um-theme
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

/**
 * Social Media Icon Choices for Customizer
 */
if ( ! function_exists( 'um_theme_social_accounts_icons' ) ) {
    function um_theme_social_accounts_icons() {

        global $defaults;
        return array(
            ''                              => esc_html__( 'None', 'um-theme' ),
            'fab fa-500px'                  => esc_html__( '500PX', 'um-theme' ),
            'fab fa-amazon'                 => esc_html__( 'Amazon', 'um-theme' ),
            'fab fa-amazon-pay'             => esc_html__( 'Amazon Pay', 'um-theme' ),
            'fab fa-android'                => esc_html__( 'Android', 'um-theme' ),
            'fab fa-angellist'              => esc_html__( 'Angellist', 'um-theme' ),
            'fab fa-app-store'              => esc_html__( 'App Store', 'um-theme' ),
            'fab fa-apple'                  => esc_html__( 'Apple', 'um-theme' ),
            'fab fa-app-store-ios'          => esc_html__( 'iOS App Store', 'um-theme' ),
            'fab fa-apple-pay'              => esc_html__( 'Apple Pay', 'um-theme' ),
            'fab fa-audible'                => esc_html__( 'Audible', 'um-theme' ),
            'fab fa-aws'                    => esc_html__( 'Amazon Web Services', 'um-theme' ),
            'fab fa-bandcamp'               => esc_html__( 'Bandcamp', 'um-theme' ),
            'fab fa-behance'                => esc_html__( 'Behance', 'um-theme' ),
            'fab fa-behance-square'         => esc_html__( 'Behance Square', 'um-theme' ),
            'fab fa-bitbucket'              => esc_html__( 'BitBucket', 'um-theme' ),
            'fab fa-bitcoin'                => esc_html__( 'Bitcoin', 'um-theme' ),
            'fab fa-bity'                   => esc_html__( 'Bitly', 'um-theme' ),
            'fab fa-blackberry'             => esc_html__( 'Blackberry', 'um-theme' ),
            'fab fa-blogger'                => esc_html__( 'Blogger', 'um-theme' ),
            'fab fa-blogger-b'              => esc_html__( 'Blogger B', 'um-theme' ),
            'fab fa-buysellads'             => esc_html__( 'BuySellAds', 'um-theme' ),
            'fab fa-cc-amazon-pay'          => esc_html__( 'CC Amazon Pay', 'um-theme' ),
            'fab fa-cc-amex'                => esc_html__( 'CC AMEX', 'um-theme' ),
            'fab fa-cc-apple-pay'           => esc_html__( 'CC Apple Pay', 'um-theme' ),
            'fab fa-cc-diners-club'         => esc_html__( 'CC Diners Club', 'um-theme' ),
            'fab fa-cc-visa'                => esc_html__( 'CC Visa', 'um-theme' ),
            'fab fa-cc-stripe'              => esc_html__( 'CC Stripe', 'um-theme' ),
            'fab fa-cc-paypal'              => esc_html__( 'CC PayPal', 'um-theme' ),
            'fab fa-cc-mastercard'          => esc_html__( 'CC Mastercard', 'um-theme' ),
            'fab fa-cc-jcb'                 => esc_html__( 'JCB Credit Card', 'um-theme' ),
            'fab fa-cc-discover'            => esc_html__( 'Discover Credit Card', 'um-theme' ),
            'fab fa-codepen'                => esc_html__( 'Codepen', 'um-theme' ),
            'fab fa-creative-commons'       => esc_html__( 'Creative Commons', 'um-theme' ),
            'fab fa-creative-commons-by'    => esc_html__( 'Creative Commons Attribution', 'um-theme' ),
            'fab fa-delicious'              => esc_html__( 'Delicious', 'um-theme' ),
            'fab fa-digg'                   => esc_html__( 'Digg', 'um-theme' ),
            'fab fa-discord'                => esc_html__( 'Discord', 'um-theme' ),
            'fab fa-deviantart'             => esc_html__( 'deviantART', 'um-theme' ),
            'fab fa-dribbble'               => esc_html__( 'Dribbble', 'um-theme' ),
            'fab fa-dribbble-square'        => esc_html__( 'Dribbble Square', 'um-theme' ),
            'fab fa-dropbox'                => esc_html__( 'Dropbox', 'um-theme' ),
            'fab fa-ebay'                   => esc_html__( 'eBay', 'um-theme' ),
            'fab fa-facebook-f'             => esc_html__( 'Facebook F', 'um-theme' ),
            'fab fa-facebook'               => esc_html__( 'Facebook', 'um-theme' ),
            'fab fa-etsy'                   => esc_html__( 'Etsy', 'um-theme' ),
            'fab fa-ethereum'               => esc_html__( 'Etherum', 'um-theme' ),
            'fab fa-facebook-messenger'     => esc_html__( 'Facebook Messenger', 'um-theme' ),
            'fab fa-facebook-square'        => esc_html__( 'Facebook Square', 'um-theme' ),
            'fab fa-flickr'                 => esc_html__( 'Flickr', 'um-theme' ),
            'fab fa-flipboard'              => esc_html__( 'Flipboard', 'um-theme' ),
            'fab fa-forumbee'               => esc_html__( 'Forumbee', 'um-theme' ),
            'fab fa-foursquare'             => esc_html__( 'Foursquare', 'um-theme' ),
            'fab fa-free-code-camp'         => esc_html__( 'Free Code Camp', 'um-theme' ),
            'fab fa-get-pocket'             => esc_html__( 'Get Pocket', 'um-theme' ),
            'fab fa-gitlab'                 => esc_html__( 'GitLab', 'um-theme' ),
            'fab fa-github-square'          => esc_html__( 'GitHub Square', 'um-theme' ),
            'fab fa-github-alt'             => esc_html__( 'GitHub Alternate', 'um-theme' ),
            'fab fa-github'                 => esc_html__( 'GitHub', 'um-theme' ),
            'fab fa-git-square'             => esc_html__( 'Git Square', 'um-theme' ),
            'fab fa-git'                    => esc_html__( 'Git', 'um-theme' ),
            'fab fa-goodreads'              => esc_html__( 'Goodreads', 'um-theme' ),
            'fab fa-goodreads-g'            => esc_html__( 'Goodreads v2', 'um-theme' ),
            'fab fa-google'                 => esc_html__( 'Google', 'um-theme' ),
            'fab fa-google-drive'           => esc_html__( 'Google Drive', 'um-theme' ),
            'fab fa-google-play'            => esc_html__( 'Google Play', 'um-theme' ),
            'fab fa-google-plus'            => esc_html__( 'Google Plus', 'um-theme' ),
            'fab fa-google-plus-g'          => esc_html__( 'Google Plus v2', 'um-theme' ),
            'fab fa-google-plus-square'     => esc_html__( 'Google Plus Square', 'um-theme' ),
            'fab fa-google-wallet'          => esc_html__( 'Google Wallet', 'um-theme' ),
            'fab fa-gratipay'               => esc_html__( 'Gratipay', 'um-theme' ),
            'fab fa-grav'                   => esc_html__( 'Grav', 'um-theme' ),
            'fab fa-grunt'                  => esc_html__( 'Grunt', 'um-theme' ),
            'fab fa-gulp'                   => esc_html__( 'Gulp', 'um-theme' ),
            'fab fa-hacker-news'            => esc_html__( 'Hacker News', 'um-theme' ),
            'fab fa-hacker-news-square'     => esc_html__( 'Hacker News Square', 'um-theme' ),
            'fab fa-hackerrank'             => esc_html__( 'Hackerrank', 'um-theme' ),
            'fab fa-hire-a-helper'          => esc_html__( 'HireAHelper', 'um-theme' ),
            'fab fa-hooli'                  => esc_html__( 'Hooli', 'um-theme' ),
            'fab fa-houzz'                  => esc_html__( 'Houzz', 'um-theme' ),
            'fab fa-itunes-note'            => esc_html__( 'iTunes Note', 'um-theme' ),
            'fab fa-itunes'                 => esc_html__( 'iTunes', 'um-theme' ),
            'fab fa-instagram'              => esc_html__( 'Instagram', 'um-theme' ),
            'fab fa-imdb'                   => esc_html__( 'IMDB', 'um-theme' ),
            'fab fa-kaggle'                 => esc_html__( 'Kaggle', 'um-theme' ),
            'fab fa-kickstarter'            => esc_html__( 'Kickstarter', 'um-theme' ),
            'fab fa-kickstarter-k'          => esc_html__( 'Kickstarter K', 'um-theme' ),
            'fab fa-linkedin'               => esc_html__( 'LinkedIn', 'um-theme' ),
            'fab fa-linkedin-in'            => esc_html__( 'LinkedIn In', 'um-theme' ),
            'fab fa-leanpub'                => esc_html__( 'Leanpub', 'um-theme' ),
            'fab fa-lastfm-square'          => esc_html__( 'last.fm Square', 'um-theme' ),
            'fab fa-lastfm'                 => esc_html__( 'last.fm', 'um-theme' ),
            'fab fa-lyft'                   => esc_html__( 'Lyft', 'um-theme' ),
            'fab fa-mailchimp'              => esc_html__( 'Mailchimp', 'um-theme' ),
            'fab fa-microsoft'              => esc_html__( 'Microsoft', 'um-theme' ),
            'fab fa-meetup'                 => esc_html__( 'Meetup', 'um-theme' ),
            'fab fa-medium-m'               => esc_html__( 'Medium M', 'um-theme' ),
            'fab fa-medium'                 => esc_html__( 'Medium', 'um-theme' ),
            'fab fa-patreon'                => esc_html__( 'Patreon', 'um-theme' ),
            'fab fa-paypal'                 => esc_html__( 'Paypal', 'um-theme' ),
            'fab fa-periscope'              => esc_html__( 'Periscope', 'um-theme' ),
            'fab fa-pinterest'              => esc_html__( 'Pinterest', 'um-theme' ),
            'fab fa-pinterest-square'       => esc_html__( 'Pinterest Square', 'um-theme' ),
            'fab fa-pinterest-p'            => esc_html__( 'Pinterest P', 'um-theme' ),
            'fab fa-product-hunt'           => esc_html__( 'Product Hunt', 'um-theme' ),
            'fab fa-qq'                     => esc_html__( 'QQ', 'um-theme' ),
            'fab fa-quora'                  => esc_html__( 'Quora', 'um-theme' ),
            'fab fa-reddit'                 => esc_html__( 'Reddit', 'um-theme' ),
            'fab fa-reddit-square'          => esc_html__( 'Reddit Square', 'um-theme' ),
            'fab fa-reddit-alien'           => esc_html__( 'Reddit Alien', 'um-theme' ),
            'fab fa-skype'                  => esc_html__( 'Skype', 'um-theme' ),
            'fab fa-slack'                  => esc_html__( 'Slack', 'um-theme' ),
            'fab fa-slack-hash'             => esc_html__( 'Slack Hash', 'um-theme' ),
            'fab fa-slideshare'             => esc_html__( 'Slideshare', 'um-theme' ),
            'fab fa-snapchat'               => esc_html__( 'Snapchat', 'um-theme' ),
            'fab fa-snapchat-square'        => esc_html__( 'Snapchat Square', 'um-theme' ),
            'fab fa-snapchat-ghost'         => esc_html__( 'Snapchat Ghost', 'um-theme' ),
            'fab fa-stack-overflow'         => esc_html__( 'Stack Overflow', 'um-theme' ),
            'fab fa-stack-exchange'         => esc_html__( 'Stack Exchange', 'um-theme' ),
            'fab fa-spotify'                => esc_html__( 'Spotify', 'um-theme' ),
            'fab fa-soundcloud'             => esc_html__( 'SoundCloud', 'um-theme' ),
            'fab fa-stripe'                 => esc_html__( 'Stripe', 'um-theme' ),
            'fab fa-stripe-s'               => esc_html__( 'Stripe S', 'um-theme' ),
            'fab fa-stumbleupon'            => esc_html__( 'StumbleUpon', 'um-theme' ),
            'fab fa-stumbleupon-circle'     => esc_html__( 'StumbleUpon Circle', 'um-theme' ),
            'fab fa-twitter'                => esc_html__( 'Twitter', 'um-theme' ),
            'fab fa-twitter-square'         => esc_html__( 'Twitter Square', 'um-theme' ),
            'fab fa-twitch'                 => esc_html__( 'Twitch', 'um-theme' ),
            'fab fa-tumblr-square'          => esc_html__( 'Tumblr Square', 'um-theme' ),
            'fab fa-tumblr'                 => esc_html__( 'Tumblr', 'um-theme' ),
            'fab fa-tripadvisor'            => esc_html__( 'TripAdvisor', 'um-theme' ),
            'fab fa-trello'                 => esc_html__( 'Trello', 'um-theme' ),
            'fab fa-viber'                  => esc_html__( 'Viber', 'um-theme' ),
            'fab fa-vimeo'                  => esc_html__( 'Vimeo', 'um-theme' ),
            'fab fa-vimeo-square'           => esc_html__( 'Vimeo Square', 'um-theme' ),
            'fab fa-vimeo-v'                => esc_html__( 'Vimeo v2', 'um-theme' ),
            'fab fa-vine'                   => esc_html__( 'Vine', 'um-theme' ),
            'fab fa-vk'                     => esc_html__( 'VK', 'um-theme' ),
            'fab fa-wikipedia-w'            => esc_html__( 'Wikipedia', 'um-theme' ),
            'fab fa-whatsapp'               => esc_html__( 'WhatsApp', 'um-theme' ),
            'fab fa-whatsapp-square'        => esc_html__( 'Whatsapp Square', 'um-theme' ),
            'fab fa-weixin'                 => esc_html__( 'Weixin', 'um-theme' ),
            'fab fa-weibo'                  => esc_html__( 'Weibo', 'um-theme' ),
            'fab fa-xing-square'            => esc_html__( 'Xing Square', 'um-theme' ),
            'fab fa-xing'                   => esc_html__( 'Xing', 'um-theme' ),
            'fab fa-youtube-square'         => esc_html__( 'YouTube Square', 'um-theme' ),
            'fab fa-youtube'                => esc_html__( 'YouTube', 'um-theme' ),
            'fab fa-yelp'                   => esc_html__( 'Yelp', 'um-theme' ),
            'fab fa-yahoo'                  => esc_html__( 'Yahoo', 'um-theme' ),
            'fab fa-y-combinator'           => esc_html__( 'Y Combinator', 'um-theme' ),
        );
    }
}

/**
 * Sanitize Hex Color.
 */
if ( ! function_exists( 'sanitize_hex_color' ) ) {
    function sanitize_hex_color( $color ) {
        if ( '' === $color ) {
            return '';
        }
        // 3 or 6 hex digits, or the empty string.
        if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
            return $color;
        }
        return null;
    }
}

/**
 * Sanitize checkbox field.
 *
 * @since 1.24
 * @param bool $checked Whether or not a box is checked.
 * @return bool True if checkbox is activated, othewise false
 */
if ( ! function_exists( 'um_theme_sanitize_checkbox' ) ) {
    function um_theme_sanitize_checkbox( $checked ) {
        return ( ( isset( $checked ) && true === $checked ) ? true : false );
    }
}

/**
 * Check if Button Border is Enabled
 */
if ( ! function_exists( 'is_active_button_border' ) ) {
 function is_active_button_border() {
    global $defaults;
    // Check for the slider plugin class
    if ( 1 === (int) $defaults['um_theme_button_border_enable'] ) {
        return true;
    } else {
        return false;
    }
 }
}

/**
 * Check if Button Border is Enabled
 */
if ( ! function_exists( 'is_active_login_button_border' ) ) {
 function is_active_login_button_border() {
    global $defaults;
    // Check if border is enabled for login button
    if ( 1 === (int) $defaults['um_theme_login_button_border_enable'] ) {
        return true;
    } else {
        return false;
    }
 }
}

/**
 * Check if Button Border is Enabled
 */
if ( ! function_exists( 'is_active_reg_button_border' ) ) {
 function is_active_reg_button_border() {
    global $defaults;
    // Check if border is enabled for register button
    if ( 1 === (int) $defaults['um_theme_reg_button_border_enable'] ) {
        return true;
    } else {
        return false;
    }
 }
}

/**
 * Check if Top Bar is Enabled
 */
if ( ! function_exists( 'is_active_top_bar' ) ) {
 function is_active_top_bar() {
    global $defaults;
    if ( 2 === (int) $defaults['um_show_topbar'] || 3 === (int) $defaults['um_show_topbar'] ) {
        return true;
    } else {
        return false;
    }
 }
}

/**
 * Check if Top Bar is Enabled
 */
if ( ! function_exists( 'is_active_top_bar_two_column' ) ) {
 function is_active_top_bar_two_column() {
    global $defaults;
    if ( 3 === (int) $defaults['um_show_topbar'] ) {
        return true;
    } else {
        return false;
    }
 }
}

/**
 * Check if Top Bar is Enabled
 */
if ( ! function_exists( 'is_active_column_one_text' ) ) {
 function is_active_column_one_text() {
    global $defaults;
    if (
        1 !== (int) $defaults['um_show_topbar'] &&
        1 === (int) $defaults['um_topbar_colum_first_layout'] ||
        2 === (int) $defaults['um_topbar_colum_first_layout']
    ) {
        return true;
    } else {
        return false;
    }
 }
}

/**
 * Check if Top Bar is Enabled
 */
if ( ! function_exists( 'is_active_topbar_column_two_text' ) ) {
 function is_active_topbar_column_two_text() {
    global $defaults;
    if (
        3 === (int) $defaults['um_show_topbar'] &&
        1 === (int) $defaults['um_topbar_colum_second_layout'] ||
        3 === (int) $defaults['um_show_topbar'] &&
        2 === (int) $defaults['um_topbar_colum_second_layout']
    ) {
        return true;
    } else {
        return false;
    }
 }
}

/**
 * Check if Bottom Bar is Enabled
 */
if ( ! function_exists( 'is_active_bottom_column_one_text' ) ) {
 function is_active_bottom_column_one_text() {
    global $defaults;
    if ( 1 === (int) $defaults['um_bottombar_colum_first_layout'] ) {
        return true;
    } else {
        return false;
    }
 }
}

/**
 * Check if Bottom Bar is Enabled
 */
if ( ! function_exists( 'is_active_bottom_column_two_text' ) ) {
 function is_active_bottom_column_two_text() {
    global $defaults;
    if ( $defaults['um_show_bottombar_layout'] === 2 && $defaults['um_bottombar_colum_second_layout'] === 1 ) {
        return true;
    } else {
        return false;
    }
 }
}

/**
 * Check if Bottom Bar is Enabled
 */
if ( ! function_exists( 'is_active_bottom_select_layout_two' ) ) {
 function is_active_bottom_select_layout_two() {
    global $defaults;
    if ( 2 === (int) $defaults['um_show_bottombar_layout'] ) {
        return true;
    } else {
        return false;
    }
 }
}

/**
 * Check if Header Search is Enabled
 */
if ( ! function_exists( 'is_active_header_search' ) ) {
    function is_active_header_search() {
        global $defaults;
        if ( 1 === (int) $defaults['um_show_header_search'] || 2 === (int) $defaults['um_show_header_search'] ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check if Bottom Bar is Enabled
 */
if ( ! function_exists( 'is_active_bottom_bar' ) ) {
    function is_active_bottom_bar() {
        global $defaults;
        if ( 1 === (int) $defaults['um_show_bottombar'] || 3 === (int) $defaults['um_show_bottombar'] ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check if Bottom Bar is Enabled
 */
if ( ! function_exists( 'is_active_bottom_bar_layout_one' ) ) {
    function is_active_bottom_bar_layout_one() {
        global $defaults;
        if ( 1 === (int) $defaults['um_show_bottombar_layout'] ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check if Bottom Bar is Enabled
 */
if ( ! function_exists( 'is_active_bottom_click_bar' ) ) {
     function is_active_bottom_click_bar() {
        global $defaults;
        if ( 3 === (int) $defaults['um_show_bottombar'] ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check if logo type is text
 */
if ( ! function_exists( 'is_active_header_logo_type_text' ) ) {
    function is_active_header_logo_type_text() {
        global $defaults;
        if ( 1 === (int) $defaults['um_show_header_logo_type'] ) {
            return true;
        }
    }
}

/**
 * Check if logo type is image
 */
if ( ! function_exists( 'is_active_header_logo_type_image_logo' ) ) {
    function is_active_header_logo_type_image_logo() {
        global $defaults;
        if ( 1 !== (int) $defaults['um_show_header_logo_type'] ) {
            return true;
        }
    }
}

/**
 * Check if Top Bar is Enabled
 */
if ( ! function_exists( 'is_active_footer_column_one_text' ) ) {
    function is_active_footer_column_one_text() {
        global $defaults;
        if ( 1 === (int) $defaults['um_footer_colum_first_layout'] ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check if Top Bar is Enabled
 */
if ( ! function_exists( 'is_active_footer_column_two_text' ) ) {
    function is_active_footer_column_two_text() {
        global $defaults;
        if ( 2 === (int) $defaults['um_show_footer_layout'] && 1 === (int) $defaults['um_footer_colum_second_layout'] ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check if Top Bar is Enabled
 */
if ( ! function_exists( 'is_active_footer_column_two' ) ) {
    function is_active_footer_column_two() {
        global $defaults;
         if ( 2 === (int) $defaults['um_show_footer_layout'] ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check if Header Logged Button one is active
 */
if ( ! function_exists( 'is_active_header_logged_button_one' ) ) {
    function is_active_header_logged_button_one() {
        global $defaults;
        if ( 1 === (int) $defaults['header_logged_out_display']  || 2 === (int) $defaults['header_logged_out_display'] ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check if Header Logged Button Two is active
 */
if ( ! function_exists( 'is_active_header_logged_button_two' ) ) {
 function is_active_header_logged_button_two() {
    global $defaults;
    if ( 1 === (int) $defaults['header_logged_out_display']  || 3 === (int) $defaults['header_logged_out_display'] ) {
        return true;
    } else {
        return false;
    }
 }
}

/**
 * Check if Header Logged Out Text is Enabled
 */
if ( ! function_exists( 'is_active_header_logged_out_text' ) ) {
 function is_active_header_logged_out_text() {
    global $defaults;
    if ( 4 === (int) $defaults['header_logged_out_display'] ) {
        return true;
    } else {
        return false;
    }
 }
}

/**
 * Custom Style to Customizer User Interface.
 */
if ( ! function_exists( 'um_theme_native_customizer_style' ) ) {
    function um_theme_native_customizer_style() {
        wp_enqueue_style( 'CustomizerUI', get_theme_file_uri( '/inc/css/customizer-ui.css' ) );
    }
}

if ( ! function_exists( 'um_theme_output_javascript_code' ) ) {
    function um_theme_output_javascript_code() {
        global $defaults;
        $js_code = $defaults['um_theme_code_javascript'];

        if ( '' === $js_code ) {
            return;
        }
        ?>
        <script type="text/javascript">
            <?php echo $js_code; ?>
        </script>
        <?php
    }
}

/**
 * Custom JavaScript code to Head.
 */
if ( ! function_exists( 'um_theme_output_head_code' ) ) {
    function um_theme_output_head_code() {
        global $defaults;
        $js_code = $defaults['um_theme_code_head'];

        if ( '' === $js_code ) {
            return;
        }
        ?>

        <script type="text/javascript">
            <?php echo $js_code; ?>
        </script>
        <?php
    }
}

/**
 * Custom JavaScript code to Header.
 */
if ( ! function_exists( 'um_theme_output_header_code' ) ) {
    function um_theme_output_header_code() {
        global $defaults;
        $js_code = $defaults['um_theme_code_header'];

        if ( '' === $js_code ) {
            return;
        }
        ?>

        <script type="text/javascript">
            <?php echo $js_code; ?>
        </script>
        <?php
    }
}

/**
 * Custom JavaScript code to Footer.
 */
if ( ! function_exists( 'um_theme_output_footer_code' ) ) {
    function um_theme_output_footer_code() {
        global $defaults;
        $js_code = $defaults['um_theme_code_footer'];

        if ( '' === $js_code ) {
            return;
        }
        ?>

        <script type="text/javascript">
            <?php echo $js_code; ?>
        </script>
        <?php
    }
}

/**
 * Check UM Extension : Followers is installed.
 * @link https://ultimatemember.com/extensions/followers/
 */
if ( ! function_exists( 'um_theme_is_active_um_followers' ) ) {
    function um_theme_is_active_um_followers() {
        if ( class_exists( 'UM' ) && function_exists( 'um_followers_plugins_loaded' ) ) {
            return true;
        } else {
            return false;
        }
    }
}


/**
 * Check UM Extension : Private Messages is installed.
 * @link https://ultimatemember.com/extensions/private-messages/
 */
if ( ! function_exists( 'um_theme_is_active_um_messaging' ) ) {
    function um_theme_is_active_um_messaging() {
        if ( class_exists( 'UM' ) && function_exists( 'um_messaging_plugins_loaded' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check UM Extension : Real-time Notifications is installed.
 * @link https://ultimatemember.com/extensions/real-time-notifications/
 */
if ( ! function_exists( 'um_theme_is_active_um_notifications' ) ) {
    function um_theme_is_active_um_notifications() {
        if ( class_exists( 'UM' ) && function_exists( 'um_notifications_check_dependencies' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check UM Extension : Friends is installed.
 * @link https://ultimatemember.com/extensions/friends/
 */
if ( ! function_exists( 'um_theme_is_active_um_friends' ) ) {
    function um_theme_is_active_um_friends() {
        if ( class_exists( 'UM' ) && function_exists( 'um_friends_plugins_loaded' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check UM Extension : Social Activity is installed.
 * @link https://ultimatemember.com/extensions/social-activity/
 */
if ( ! function_exists( 'um_theme_is_active_um_social_activity' ) ) {
    function um_theme_is_active_um_social_activity() {
        if ( class_exists( 'UM' ) && function_exists( 'um_activity_plugins_loaded' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check UM Extension : User Reviews is installed.
 * @link https://ultimatemember.com/extensions/user-reviews/
 */
if ( ! function_exists( 'um_theme_is_active_um_reviews' ) ) {
    function um_theme_is_active_um_reviews() {

        if ( class_exists( 'UM' ) && function_exists( 'um_reviews_plugins_loaded' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check UM Extension : UM WooCommerce is installed.
 * @link https://ultimatemember.com/extensions/woocommerce/
 */
if ( ! function_exists( 'um_theme_is_active_um_ext_woocommerce' ) ) {
    function um_theme_is_active_um_ext_woocommerce() {
        if ( class_exists( 'UM' ) && function_exists( 'um_woocommerce_plugins_loaded' ) && class_exists( 'WooCommerce' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check UM Extension : Verified Users is installed.
 * @link https://ultimatemember.com/extensions/verified-users/
 */
if ( ! function_exists( 'um_theme_is_active_um_ext_verified_users' ) ) {
    function um_theme_is_active_um_ext_verified_users() {
        if ( class_exists( 'UM' ) && function_exists( 'um_verified_users_plugins_loaded' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check UM Extension : User Tags is installed.
 * @link https://ultimatemember.com/extensions/user-tags/
 */
if ( ! function_exists( 'um_theme_is_active_um_ext_user_tags' ) ) {
    function um_theme_is_active_um_ext_user_tags() {
        if ( class_exists( 'UM' ) && function_exists( 'um_user_tags_plugins_loaded' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check UM Extension : Groups is installed.
 * @link https://ultimatemember.com/extensions/groups/
 */
if ( ! function_exists( 'um_theme_is_active_um_ext_groups' ) ) {
    function um_theme_is_active_um_ext_groups() {

        if ( class_exists( 'UM' ) && function_exists( 'um_groups_plugins_loaded' ) ) {
            return true;
        } else {
            return false;
        }
    }
}


/**
 * Check UM Extension : Profile Completeness is installed.
 * @link https://ultimatemember.com/extensions/profile-completeness/
 */
if ( ! function_exists( 'um_theme_is_active_um_ext_profile_complete' ) ) {
    function um_theme_is_active_um_ext_profile_complete() {

        if ( class_exists( 'UM' ) && function_exists( 'um_profile_completeness_plugins_loaded' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check UM Extension : User Bookmarks is installed.
 * @link https://ultimatemember.com/extensions/profile-completeness/
 */
if ( ! function_exists( 'um_theme_is_active_um_ext_user_bookmarks' ) ) {
    function um_theme_is_active_um_ext_user_bookmarks() {

        if ( class_exists( 'UM' ) && function_exists( 'um_user_bookmarks_plugins_loaded' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check UM Extension : User Notes is installed.
 * @link https://ultimatemember.com/extensions/profile-completeness/
 */
if ( ! function_exists( 'um_theme_is_active_um_ext_user_notes' ) ) {
    function um_theme_is_active_um_ext_user_notes() {

        if ( class_exists( 'UM' ) && function_exists( 'um_user_notes_plugins_loaded' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check if Header Friend Request Modal is Enabled.
 */
if ( ! function_exists( 'is_active_header_friend_requests' ) ) {
 function is_active_header_friend_requests() {
    global $defaults;
    if ( class_exists( 'UM' ) && function_exists( 'um_friends_plugins_loaded' ) && $defaults['um_show_header_friend_requests'] === 1 ) {
        return true;
    } else {
        return false;
    }
 }
}


/**
 * Check if Header Friend Request Modal is Enabled.
 */
if ( ! function_exists( 'is_active_header_messenger' ) ) {
 function is_active_header_messenger() {
    global $defaults;
    if ( class_exists( 'UM' ) && function_exists( 'um_messaging_plugins_loaded' ) && $defaults['um_show_header_messenger'] === 1 ) {
        return true;
    } else {
        return false;
    }
 }
}

/**
 * Check if Header Friend Request Modal is Enabled.
 */
if ( ! function_exists( 'is_active_header_notification' ) ) {
 function is_active_header_notification() {
    global $defaults;
    if ( class_exists( 'UM' ) && function_exists( 'um_notifications_check_dependencies' ) && $defaults['um_show_header_notification'] === 1 ) {
        return true;
    } else {
        return false;
    }
 }
}

/**
 * Display content in um_theme_before_header
 */
if ( ! function_exists( 'um_hook_header_before' ) ) {
    function um_hook_header_before() {
        global $defaults;
        $before_header   = $defaults['um_theme_setting_hook_header_before_header'];
        if ( ! empty( $before_header ) ){
            echo do_shortcode( $before_header );
        }
    }
}


/**
 * Display content in um_theme_header
 */
if ( ! function_exists( 'um_theme_hook_header' ) ) {
    function um_theme_hook_header() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_header'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}

/**
 * Display content in um_theme_after_header
 */
if ( ! function_exists( 'um_hook_header_after' ) ) {
    function um_hook_header_after() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_header_after_header'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}


/**
 * Display content in um_theme_header_profile_before
 */
if ( ! function_exists( 'um_hook_header_profile_before' ) ) {
    function um_hook_header_profile_before() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_header_profile_before'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}


/**
 * Display content in um_theme_header_profile_after
 */
if ( ! function_exists( 'um_hook_header_profile_after' ) ) {
    function um_hook_header_profile_after() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_header_profile_after'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}

/**
 * Display content in um_theme_before_site
 */
if ( ! function_exists( 'um_hook_before_site' ) ) {
    function um_hook_before_site() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_content_before_site'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}

/**
 * Display content in um_theme_before_content
 */
if ( ! function_exists( 'um_hook_before_content' ) ) {
    function um_hook_before_content() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_before_content'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}


/**
 * Display content in um_theme_content_top
 */
if ( ! function_exists( 'um_hook_content_top' ) ) {
    function um_hook_content_top() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_content_top'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}

/**
 * Display content in um_theme_before_page_content
 */
if ( ! function_exists( 'um_hook_before_page_content' ) ) {
    function um_hook_before_page_content() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_content_before_page'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}


/**
 * Display content in um_theme_page
 */
if ( ! function_exists( 'um_hook_page_content' ) ) {
    function um_hook_page_content() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_content_page'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}

/**
 * Display content in um_theme_after_page_content
 */
if ( ! function_exists( 'um_hook_page_content_after' ) ) {
    function um_hook_page_content_after() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_content_after_page'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}

/**
 * Display content in um_theme_loop_before
 */
if ( ! function_exists( 'um_hook_loop_before' ) ) {
    function um_hook_loop_before() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_loop_before'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}

/**
 * Display content in um_theme_loop_after
 */
if ( ! function_exists( 'um_hook_loop_after' ) ) {
    function um_hook_loop_after() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_loop_after'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}



/**
 * Display content in um_theme_single_post_before
 */
if ( ! function_exists( 'um_hook_single_post_before' ) ) {
    function um_hook_single_post_before() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_single_post_before'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}


/**
 * Display content in um_theme_single_post_top
 */
if ( ! function_exists( 'um_hook_single_post_top' ) ) {
    function um_hook_single_post_top() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_single_post_top'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}


/**
 * Display content in um_theme_single_post
 */
if ( ! function_exists( 'um_hook_single_post' ) ) {
    function um_hook_single_post() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_single_post'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}


/**
 * Display content in um_theme_single_post_bottom
 */
if ( ! function_exists( 'um_hook_single_post_bottom' ) ) {
    function um_hook_single_post_bottom() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_single_post_bottom'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}


/**
 * Display content in um_theme_single_post_after
 */
if ( ! function_exists( 'um_hook_single_post_after' ) ) {
    function um_hook_single_post_after() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_single_post_after'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}



/**
 * Display content in um_theme_before_comments
 */
if ( ! function_exists( 'um_hook_before_comments' ) ) {
    function um_hook_before_comments() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_before_comments'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}


/**
 * Display content in um_theme_before_comments_title
 */
if ( ! function_exists( 'um_hook_before_comments_title' ) ) {
    function um_hook_before_comments_title() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_before_comments_title'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}

/**
 * Display content in um_theme_after_comments_title
 */
if ( ! function_exists( 'um_hook_after_comments_title' ) ) {
    function um_hook_after_comments_title() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_after_comments_title'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}


/**
 * Display content in um_theme_after_comments
 */
if ( ! function_exists( 'um_hook_after_comments' ) ) {
    function um_hook_after_comments() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_after_comments'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}

/**
 * Display content in um_theme_before_footer
 */
if ( ! function_exists( 'um_hook_before_footer' ) ) {
    function um_hook_before_footer() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_before_footer'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}

/**
 * Display content in um_theme_footer
 */
if ( ! function_exists( 'um_hook_footer' ) ) {
    function um_hook_footer() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_footer'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}

/**
 * Display content in um_theme_after_footer
 */
if ( ! function_exists( 'um_hook_footer_after' ) ) {
    function um_hook_footer_after() {
        global $defaults;
        $hook_header   = $defaults['um_theme_setting_hook_after_footer'];
        if ( ! empty( $hook_header ) ){
            echo do_shortcode( $hook_header );
        }
    }
}


/**
 * Check if Profile Header is active.
 */
if ( ! function_exists( 'is_active_header_profile' ) ) {
 function is_active_header_profile() {
    global $defaults;

    if ( 1 === (int) $defaults['um_show_header_profile'] or 3 === (int) $defaults['um_show_header_profile'] ) {
        return true;
    } else {
        return false;
    }
 }
}

/**
 * Check SportsPress : SportsPress is installed.
 * @link https://wordpress.org/plugins/sportspress/
 */
if ( ! function_exists( 'um_theme_is_active_sportspress' ) ) {
    function um_theme_is_active_sportspress() {
        if ( class_exists( 'SportsPress' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check WP Job Manager : if WP Job Manager is installed.
 * @link https://wordpress.org/plugins/wp-job-manager/
 */
if ( ! function_exists( 'um_theme_is_active_wp_job_manager' ) ) {
    function um_theme_is_active_wp_job_manager() {
        if ( class_exists( 'WP_Job_Manager' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
* Check if YITH WooCommerce Wishlist is active.
* @link https://wordpress.org/plugins/yith-woocommerce-wishlist/
*/
if ( ! function_exists( 'um_theme_is_active_yith_wishlist' ) ) {
    function um_theme_is_active_yith_wishlist() {
        return class_exists( 'YITH_WCWL' ) ? true : false;
    }
}

/**
 * Check EDD : if Easy Digital Downloads is installed.
 * @link https://wordpress.org/plugins/easy-digital-downloads/
 */
if ( ! function_exists( 'um_theme_is_active_edd' ) ) {
    function um_theme_is_active_edd() {
        if ( class_exists( 'Easy_Digital_Downloads' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check Dokan : if Easy Digital Downloads is installed.
 * @link https://wordpress.org/plugins/dokan-lite/
 */
if ( ! function_exists( 'um_theme_is_active_dokan' ) ) {
    function um_theme_is_active_dokan() {
        if ( class_exists( 'WeDevs_Dokan' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check if Restrict Content plugin is active.
 * @link https://wordpress.org/plugins/restrict-content/
 */
if ( ! function_exists( 'is_active_restrict_content' ) ) {
 function is_active_restrict_content() {
    if ( function_exists( 'restrict_shortcode' ) ) {
        return true;
    } else {
        return false;
    }
 }
}

/**
 * Check if WPAdverts plugin is active.
 * @link https://wordpress.org/plugins/wpadverts/
 */
if ( ! function_exists( 'is_active_wp_adverts' ) ) {
 function is_active_wp_adverts() {
    if ( class_exists( 'Adverts' ) ) {
        return true;
    } else {
        return false;
    }
 }
}

/**
 * Check bbPress : bbPress is installed.
 * @link https://ultimatemember.com/extensions/bbpress/
 */
if ( ! function_exists( 'um_theme_is_active_bbpress' ) ) {
    function um_theme_is_active_bbpress() {
        if ( class_exists( 'bbPress' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check ForumWP : ForumWP is installed.
 * @link https://forumwpplugin.com/
 */
if ( ! function_exists( 'um_theme_is_active_forumwp' ) ) {
    function um_theme_is_active_forumwp() {
        if ( class_exists( 'FMWP' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Check LifterLMS : if LifterLMS is installed.
 * @link https://wordpress.org/plugins/lifterlms/
 */
if ( ! function_exists( 'um_theme_is_active_lifterlms' ) ) {
    function um_theme_is_active_lifterlms() {
        if ( class_exists( 'LifterLMS' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
* Check if WooCommerce is active.
* @link https://wordpress.org/plugins/woocommerce/
*/
if ( ! function_exists( 'um_theme_is_active_woocommerce' ) ) {
    function um_theme_is_active_woocommerce() {
        return class_exists( 'WooCommerce' ) ? true : false;
    }
}