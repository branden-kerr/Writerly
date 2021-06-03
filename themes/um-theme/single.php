<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package um-theme
 */

global $defaults;
get_header();
?>

<div class="website-canvas">
<div class="boot-row">
	<main id="primary" class="content-area single-post-content <?php um_determine_single_content_width();?>" tabindex="-1" role="main">
		<div id="main" class="site-main boot-row">
		<?php
			// Elementor `single` location
			if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
				/* Start the Loop */
				while ( have_posts() ) : the_post();
					do_action( 'um_theme_single_post_before' );
					get_template_part( 'template-parts/content', 'single' );
					do_action( 'um_theme_single_post_after' );
				endwhile;
			}
		?>
		</div>
	</main>
	<?php get_sidebar(); ?>
</div>
</div>
<?php
get_footer();
