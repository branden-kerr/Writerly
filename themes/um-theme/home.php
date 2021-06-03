<?php
/**
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package um-theme
 */
global $defaults;
get_header();?>

<main id="primary" class="content-area" tabindex="-1" role="main">
<div id="main" class="site-main">

		<?php
		if ( have_posts() ) :
			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title sr-only sr-only-focusable"><?php the_title(); ?></h1>
				</header>
			<?php
			endif;?>

			<div class="website-canvas">
			<div class="boot-row">
				<div class="template-blog <?php um_determine_blog_content_width();?> <?php um_theme_determine_sidebar_position();?>">
				<div class="boot-row">
				<?php
					/* Start the Loop */
						get_template_part( 'loop' );
					else :
						get_template_part( 'template-parts/content', 'none' );
					endif;
					wp_reset_postdata();
				?>
				</div>
				</div>
			</div>
			</div>
	</div>
</main>
<?php
get_footer();