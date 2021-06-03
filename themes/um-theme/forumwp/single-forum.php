<?php if ( ! defined( 'ABSPATH' ) ) exit;

get_header(); ?>
<div class="website-canvas">
<div class="boot-row">
	<section id="primary" class="content-area <?php um_determine_single_content_width();?>">
		<main id="main" class="site-main" role="main">

			<?php the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="https://schema.org/BlogPosting">
				<header class="entry-header fmwp">
					<?php if ( is_sticky() && is_home() && ! is_paged() ) {
						printf( '<span class="sticky-post">%s</span>', _x( 'Featured', 'post', 'um-theme' ) );
					}

					$wp_query->query_vars['fmwp_forum_info_args'] = array(
						'id' => get_the_ID(),
					);

					FMWP()->get_template_part( 'single-forum-info' ); ?>
				</header><!-- .fl-post-header -->

				<?php echo do_shortcode( '[fmwp_forum id="' . get_the_ID() . '" /]' ); ?>

			</article>


		</main><!-- #main -->
	</section><!-- #primary -->

	<?php get_sidebar(); ?>
</div>
</div>
<?php get_footer();