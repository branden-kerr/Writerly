<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package um-theme
 */
get_header(); ?>
	<main id="primary" class="content-area" tabindex="-1" role="main">
		<section id="main" class="site-main">
		<div class="website-canvas">
		<div class="boot-row">
		<div id="primary" class="content-area single-page__content <?php um_determine_single_content_width();?>">

		<?php if ( have_posts() ) : ?>

			<div class="container-card-content">
				<header class="page-header">
					<!-- Title for search results containing search term -->
					<h1 class="page-title">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Search Results for: %s', 'um-theme' ), '<span class="search-term">' . get_search_query() . '</span>' );
						?>
					</h1>
					<?php do_action( 'um_theme_search_header' ); ?>
				</header><!-- .page-header -->

				<div class="boot-row search-list">
					<?php while ( have_posts() ) : the_post(); ?>
						<div class="search-entry boot-col-sm-12">
						<article id="post-<?php the_ID();?>" <?php post_class();?>>
							<header class="entry-header">
								<h3 class="search-entry-title entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
								<span class="search-post-type"><?php um_theme_search_display_post_type();?></span>
							</header>


							<?php um_published_on();?>
							<span class="meta"><?php esc_html_e( 'by', 'um-theme' );?></span>
							<?php um_post_author();?>

							<div class="excerpt"><?php the_excerpt();?></div>
						</article>
						</div>
					<?php endwhile; ?>
				</div>
			</div>

			<?php
				um_theme_pagination();
		 else :
				get_template_part( 'template-parts/content', 'none' );
		 endif;
		?>
		</div>
		<?php get_sidebar(); ?>
		</div>
		</div>
		</section>
	</main>
<?php get_footer(); ?>
