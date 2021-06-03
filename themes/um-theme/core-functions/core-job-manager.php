<?php
/**
 * Helper functions for WP Job Manager
 *
 * @package 	um-theme
 * @subpackage 	WP Job Manager
 * @link      	https://wordpress.org/plugins/wp-job-manager/
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

/**
 * WP Job Manager Hooks
 */
add_action( 'single_job_listing_start', 'um_theme_job_manager_title', 20 );
remove_action( 'um_theme_single_post', 'um_theme_single_post_header', 10 );
remove_action( 'single_job_listing_start', 'job_listing_company_display', 30 );


/**
 * Output Article Header of Single Post
 */
if ( ! function_exists( 'um_theme_job_manager_title' ) ) {
    function um_theme_job_manager_title() {
        ?>
        <div class="boot-row single-job-header boot-align-items-center">
        	<div class="boot-col-md-8">
		        <header class="entry-header boot-text-left single-article-header">
		            <h1 class="single-job-title entry-title"><?php the_title(); ?></h1>
		        </header>
        	</div>
        	<div class="boot-col-md-4 boot-text-right">
				<?php if ( candidates_can_apply() ) : ?>
					<?php get_job_manager_template( 'job-application.php' ); ?>
				<?php endif; ?>
        	</div>
        </div>

    <?php

    }
}

/**
 * Twitter Link
 */
if ( ! function_exists( 'the_um_company_twitter' ) ) {
	function the_um_company_twitter( $before = '', $after = '', $echo = true, $post = null ) {
		$company_twitter = get_the_company_twitter( $post );

		if ( 0 === strlen( $company_twitter ) ) {
			return null;
		}

		$company_twitter = $before . '<a href="' . esc_url( 'https://twitter.com/' . $company_twitter ) . '" class="company_twitter"></a>' . $after;

		if ( $echo ) {
			echo wp_kses_post( $company_twitter );
		} else {
			return $company_twitter;
		}
	}
}