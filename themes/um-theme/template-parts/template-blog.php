<?php
/**
 *
 * Template name: Blog Posts
 *
 * @package um-theme
 */
global $defaults;
$archive_status 	= (int) $defaults['um_theme_show_sidebar_archive_page'];

// Homepage pagination.
if ( get_query_var( 'paged' ) ) {
	$paged = get_query_var( 'paged' );
} elseif ( get_query_var( 'page' ) ) {
	$paged = get_query_var( 'page' );
} else {
	$paged = 1;
}

$args = array(
	'post_type' 	=> 'post',
	'post_status' 	=> 'publish',
	'orderby' 		=> 'date',
	'order' 		=> 'DESC',
	'paged' 		=> $paged,
);

if ( has_filter( 'um_theme_template_blog_args' ) ) {
	$args = apply_filters( 'um_theme_template_blog_args', $args );
}

$wp_query = null;
$wp_query = new WP_Query();
$wp_query->query( $args );
get_header();
?>

<main id="primary" class="content-area" tabindex="-1" role="main">
<div id="main" class="site-main">

	<header class="page__header entry-header">
		<div class="single page-meta">
			<h1 class="entry-title">
				<?php the_title();?>
			</h1>
		</div>
	</header>

	<div class="website-canvas">
		<div class="boot-row">
			<div class="template-blog <?php um_determine_blog_content_width();?> <?php um_theme_determine_sidebar_position();?>">
				<div class="boot-row">
					<?php
						if ( $wp_query->have_posts() ) :
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
				if ( $archive_status === 1 ) {
					get_sidebar('blog');
				}
			?>

		</div>
	</div>
</div><!-- #primary -->
</main><!-- #main -->
<?php
get_footer();
