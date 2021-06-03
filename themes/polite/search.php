<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Polite
 */

get_header();
?>
<section id="content" class="site-content posts-container">
    <div class="container">
        <div class="row">
			<div class="archive-heading">
				<h1 class="archive-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'polite' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</div>
			<div class="breadcrumbs-wrap">
				<?php 
				// breadcrumb hook
				do_action('polite_breadcrumb_options_hook'); ?> 
			</div>
			<div id="primary" class="col-md-8 content-area">
				<main id="main" class="site-main">
					<?php if ( have_posts() ) : ?>
					<?php
						/* Masonry Start Section */
						do_action('polite_masonry_start_hook'); 

						/* Start the Loop */
						while ( have_posts() ) :
							the_post();
							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */

							get_template_part( 'template-parts/content', 'search' );

						endwhile;

						/* Masonry end Section */
						do_action('polite_masonry_end_hook');

						/**
			             * polite_action_navigation hook
			             * @since Polite 1.0.0
			             *
			             * @hooked polite_action_navigation -  10
			             */
						do_action( 'polite_action_navigation');
							
						else :

						get_template_part( 'template-parts/content', 'none' );
						endif;
					?>
				</main><!-- #main -->
			</div><!-- #primary -->
			<?php get_sidebar(); ?>
		</div>
	</div>
</section>
<?php get_footer();

