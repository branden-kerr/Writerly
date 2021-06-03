<?php
/**
 * Single job listing.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-single-job_listing.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @since       1.0.0
 * @version     1.28.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

add_action( 'single_job_listing_start', 'um_theme_job_manager_title', 20 );
remove_action( 'um_theme_single_post', 'um_theme_single_post_header', 10 );
remove_action( 'single_job_listing_start', 'job_listing_company_display', 30 );

?>
<div class="single_job_listing">
	<?php if ( get_option( 'job_manager_hide_expired_content', 1 ) && 'expired' === $post->post_status ) : ?>
		<div class="job-manager-info"><?php _e( 'This listing has expired.', 'um-theme' ); ?></div>
	<?php else : ?>
		<?php
			/**
			 * single_job_listing_start hook
			 *
			 * @hooked job_listing_meta_display - 20
			 * @hooked job_listing_company_display - 30
			 */
			do_action( 'single_job_listing_start' );
		?>

		<div class="boot-row">

			<div class="boot-col-md-8">

				<div class="job_description">
					<?php wpjm_the_job_description(); ?>
				</div>

				<?php
					/**
					 * single_job_listing_end hook
					 */
					do_action( 'single_job_listing_end' );
				?>

			</div>

			<div class="single-job-sidebar boot-col-md-4">
				<?php job_listing_company_display();?>
			</div>

		</div>


	<?php endif; ?>
</div>
