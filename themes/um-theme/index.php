<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package um-theme
 */
global $defaults;
$archive_status 	= (int) $defaults['um_theme_show_sidebar_archive_page'];
get_header();?>

<main id="primary" class="content-area" tabindex="-1" role="main">
<div id="main" class="site-main">
		<?php
			// Elementor `archive` location
			if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) { ?>

				<div class="website-canvas">
				<div class="boot-row">

					<div class="template-blog <?php um_determine_blog_content_width();?> <?php um_theme_determine_sidebar_position();?>">
					<div class="boot-row">
					<?php
						if ( have_posts() ) :
							/* Start the Loop */
							get_template_part( 'loop' );
						else :
							get_template_part( 'template-parts/content', 'none' );
						endif;
						wp_reset_postdata();
					?>
					</div>
					</div>
					<?php
						if ( is_archive() && $archive_status === 1 ) {
							get_sidebar('blog');
						}
					?>
				</div>
				</div>
			<?php }?>

</div><!-- #primary -->
</main><!-- #main -->
<?php
get_footer();
