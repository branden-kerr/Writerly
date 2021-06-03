<?php
/**
 *
 * Template name: Page Builder - Full Width
 *
 * @package um-theme
 */
global $defaults;
get_header();?>

<div id="main" class="site-main">
<?php do_action( 'um_theme_before_page_content' );?>
<?php while ( have_posts() ) : the_post(); ?>

<div class="boot-col-md-12 page-content">
<div class="boot-row">

	<main id="primary" class="content-area single-page__content boot-col-md-12" tabindex="-1" role="main">
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
				<?php
					the_content();
					um_theme_display_wp_link_pages();
				?>
			</div>
		</div>
		<?php
			/**
			 * Functions hooked in to um_theme_after_page_content action
			 *
			 * @hooked um_theme_output_page_comments - 10
			 */
			do_action( 'um_theme_after_page_content' );
		?>
	</main>

	<?php endwhile; ?>
</div>
</div>
</div>
<?php
get_footer();
