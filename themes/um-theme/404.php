<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package um-theme
 */

get_header(); ?>
<div class="website-canvas">
<main id="primary" class="content-area" tabindex="-1" role="main">
	<div id="main" class="site-main">
	<section class="error-404 not-found website-canvas">
		<div class="container-card-content">
			<?php
			// Elementor `404` location.
			if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) { ?>
				<header class="page-header">
					<h1 class="page-title"><?php (string) apply_filters( 'um_theme_404_title', esc_html_e( '404', 'um-theme' ) ); // WPCS: XSS OK. ?></h1>
					<h4><?php (string) apply_filters( 'um_theme_404_desc', esc_html_e( 'Oops! Page not found.', 'um-theme' ) ); // WPCS: XSS OK. ?></h4>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php (string) apply_filters( 'um_theme_404_text', esc_html_e( 'We couldn&rsquo;t find the page you are looking for. Perhaps you can try searching:', 'um-theme' ) );?></p>
					<?php get_search_form(); ?>

					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn button error-button-home" role="button">
						<span><?php esc_html_e( 'Return to Home', 'um-theme' ); ?></span>
					</a>
				</div>
			<?php } ?>
		</div>
	</section>
	</div>
</main>
</div>
<?php get_footer(); ?>
