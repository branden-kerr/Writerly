<?php
/**
 * Masonry Start Class and Id functions
 *
 * @since Polite 1.0.0
 *
 */
if (!function_exists('polite_masonry_start')) :
    function polite_masonry_start()
    { ?>
        <div class="masonry-start"><div id="masonry-loop">
        
        <?php
    }
endif;
add_action('polite_masonry_start_hook', 'polite_masonry_start', 10, 1);

/**
 * Masonry end Div
 *
 * @since Polite 1.0.0
 *
 */
if (!function_exists('polite_masonry_end')) :
    function polite_masonry_end()
    { ?>
        </div>
        </div>
        
        <?php
    }
endif;
add_action('polite_masonry_end_hook', 'polite_masonry_end', 10, 1);