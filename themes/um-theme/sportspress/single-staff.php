<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package um-theme
 */
global $defaults;
get_header();?>

<div id="primary" class="site-main">
	<div class="boot-col-md-12 page-content">
	<div class="website-canvas">
	<div class="boot-row">
	<main id="main" class="content-area single-page__content <?php um_determine_single_content_width();?>" tabindex="-1" role="main">

		<?php do_action( 'um_theme_before_page_content' );?>

		<?php
			if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
				while ( have_posts() ) : the_post();
					// Elementor `single` location
					get_template_part( 'template-parts/content', 'page' );
				endwhile;
			}
		?>

		<?php
			/**
			 * Functions hooked in to um_theme_after_page_content action
			 *
			 * @hooked um_theme_output_page_comments - 10
			 */
			do_action( 'um_theme_after_page_content' );
		?>

	</main>
	<?php get_sidebar();?>
</div>
</div>
</div>
</div>

<?php
get_footer();
