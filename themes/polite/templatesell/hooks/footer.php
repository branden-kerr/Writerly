<?php
/**
 * Goto Top functions
 *
 * @since Polite 1.0.0
 *
 */

if (!function_exists('polite_go_to_top')) :
    function polite_go_to_top()
    {
    ?>
            <a id="toTop" class="go-to-top" href="#" title="<?php esc_attr_e('Go to Top', 'polite'); ?>">
                <i class="fa fa-angle-double-up"></i>
            </a>
<?php
    } endif;
add_action('polite_go_to_top_hook', 'polite_go_to_top', 10, 1);