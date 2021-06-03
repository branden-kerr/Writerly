<?php
/**
 * Post Navigation Function
 *
 * @since Polite 1.0.0
 *
 * @param null
 * @return void
 *
 */
if (!function_exists('polite_posts_navigation')) :
    function polite_posts_navigation()
    {
        global $polite_theme_options;
        $polite_pagination_option = $polite_theme_options['polite-pagination-options'];
        if ('numeric' == $polite_pagination_option) {
            echo "<div class='pagination'>";
            global $wp_query;
            $big = 999999999; // need an unlikely integer
            echo paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $wp_query->max_num_pages,
                'prev_text' => __('<i class="fa fa-angle-left"></i>', 'polite'),
                'next_text' => __('<i class="fa fa-angle-right"></i>', 'polite'),
            ));
            echo "<div>";
        } elseif ('ajax' == $polite_pagination_option) {
            $page_number = get_query_var('paged');
            if ($page_number == 0) {
                $output_page = 2;
            } else {
                $output_page = $page_number + 1;
            }
            if(paginate_links()) {
            echo "<div class='ajax-pagination text-center'><div class='show-more' data-number='$output_page'><i class='fa fa-refresh'></i>" . __('View More', 'polite') . "</div><div id='free-temp-post'></div></div>";
            }
        } else {
            return false;
        }
    }
endif;
add_action('polite_action_navigation', 'polite_posts_navigation', 10);