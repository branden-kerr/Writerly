<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package um-theme
 */
global $defaults;
$archive_status 	= (int) $defaults['um_theme_show_sidebar_archive_page'];
get_header();?>
<div id="primary" class="content-area">
<main id="main" class="site-main" tabindex="-1" role="main">
<div class="website-canvas">

	<?php
		// Elementor `archive` location.
		if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) : ?>

			<header class="page-header">
				<?php do_action( 'um_theme_content_archive_header' ); ?>
			</header>

			<div class="boot-row">
			<div class="template-blog <?php um_determine_blog_content_width();?> <?php um_theme_determine_sidebar_position();?>">
			<div class="boot-row">
				<?php
					if ( have_posts() ) :
					/* Start the Loop */
						while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/content' );
						endwhile;
						um_theme_pagination();
					else :
						get_template_part( 'template-parts/content', 'none' );
					endif;
					wp_reset_postdata();
				?>
			</div>
			</div>

			<?php
				// Get archive sidebar
				if ( is_archive() && $archive_status === 1 ) {
					get_sidebar('blog');
				}
			?>
			</div>
	<?php endif;?>
</div>
</main>
</div>
<?php
get_footer();
