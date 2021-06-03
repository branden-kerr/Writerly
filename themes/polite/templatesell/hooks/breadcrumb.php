<?php
/**
 * Functions to manage breadcrumbs
 */
if (!function_exists('polite_breadcrumb_options')) :
    function polite_breadcrumb_options()
    {
        global $polite_theme_options;
        $breadcrumbs = absint($polite_theme_options['polite-extra-breadcrumb']);
        $breadcrumb_from = esc_attr($polite_theme_options['polite-breadcrumb-selection-option']);        

        if ( $breadcrumbs == 1 && $breadcrumb_from == 'theme' ) {
            polite_breadcrumbs();
        }elseif($breadcrumbs == 1 &&  $breadcrumb_from == 'yoast' && (function_exists('yoast_breadcrumb'))){
            yoast_breadcrumb();
        }elseif($breadcrumbs == 1 && 'rankmath' == $breadcrumb_from && (function_exists('rank_math_the_breadcrumbs'))) {
          rank_math_the_breadcrumbs();
        }elseif($breadcrumbs == 1 && 'navxt' == $breadcrumb_from && (function_exists('bcn_display'))){
            bcn_display();
        }else{
            //do nothing
        }
    }
endif;
add_action('polite_breadcrumb_options_hook', 'polite_breadcrumb_options');

/**
 * BreadCrumb Settings
 */
if (!function_exists('polite_breadcrumbs')):
    function polite_breadcrumbs()
    {
        if (!function_exists('polite_breadcrumb_trail')) {
            require get_template_directory() . '/templatesell/breadcrumbs/breadcrumbs.php';
        }
        $breadcrumb_args = array(
            'container' => 'div',
            'show_browse' => false
        );        
        polite_breadcrumb_trail($breadcrumb_args);
    }
endif;
add_action('polite_breadcrumbs_hook', 'polite_breadcrumbs');