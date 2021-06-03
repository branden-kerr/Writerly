<?php if ( ! defined( 'ABSPATH' ) ) exit;

get_header(); ?>
<div class="website-canvas">
<div class="boot-row">
	<section id="primary" class="content-area <?php um_determine_single_content_width();?>">
		<main id="main" class="site-main" role="main">

			<?php the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php
						if ( is_sticky() && is_home() && ! is_paged() ) {
							printf( '<span class="sticky-post">%s</span>', _x( 'Featured', 'post', 'um-theme' ) );
						}
						if ( is_singular() ) :
							the_title( '<h1 class="entry-title fmwp-topic-title">', '</h1>' );
						else :
							the_title( sprintf( '<h2 class="entry-title fmwp-topic-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
						endif;
						?>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php echo do_shortcode( '[fmwp_topic id="' . get_the_ID() . '" /]' ); ?>
					</div><!-- .entry-content -->
				</article>

		</main><!-- #main -->
	</section><!-- #primary -->

	<?php get_sidebar(); ?>
</div>
</div>
<?php get_footer();