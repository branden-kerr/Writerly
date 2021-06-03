<?php
/**
 * Added polite Page.
*/

/**
 * Add a new page under Appearance
 */
function polite_menu() {
	add_theme_page( __( 'Polite Options', 'polite' ), __( 'Polite Options', 'polite' ), 'edit_theme_options', 'polite-theme', 'polite_page' );
}
add_action( 'admin_menu', 'polite_menu' );

/**
 * Enqueue styles for the help page.
 */
function polite_admin_scripts( $hook ) {
	if ( 'appearance_page_polite-theme' !== $hook ) {
		return;
	}
	wp_enqueue_style( 'polite-admin-style', get_template_directory_uri() . '/templatesell/about/about.css', array(), '' );
}
add_action( 'admin_enqueue_scripts', 'polite_admin_scripts' );

/**
 * Add the theme page
 */
function polite_page() {
	?>
	<div class="das-wrap">
		<div class="polite-panel">
			<div class="polite-logo">
				<img class="ts-logo" src="<?php echo esc_url( get_template_directory_uri() . '/templatesell/about/images/polite-logo.png' ); ?>" alt="Logo">
			</div>
			<a href="https://www.templatesell.com/item/polite-plus-masonry-wordpress-theme/" target="_blank" class="btn btn-success pull-right"><?php esc_html_e( 'Upgrade Pro $49', 'polite' ); ?></a>
			<p>
			<?php esc_html_e( 'A perfect theme for blog and magazine site. With masonry layout and multiple blog page layout, this theme is the awesome and minimal theme.', 'polite' ); ?></p>
			<a class="btn btn-primary" href="<?php echo esc_url (admin_url( '/customize.php?' ));
				?>"><?php esc_html_e( 'Theme Options - Click Here', 'polite' ); ?></a>
		</div>

		<div class="polite-panel">
			<div class="polite-panel-content">
				<div class="theme-title">
					<h3><?php esc_html_e( 'Looking for theme Documentation?', 'polite' ); ?></h3>
				</div>
				<a href="http://www.docs.templatesell.net/polite" target="_blank" class="btn btn-secondary"><?php esc_html_e( 'Documentation - Click Here', 'polite' ); ?></a>
			</div>
		</div>
		<div class="polite-panel">
			<div class="polite-panel-content">
				<div class="theme-title">
					<h3><?php esc_html_e( 'If you like the theme, please leave a review', 'polite' ); ?></h3>
				</div>
				<a href="https://wordpress.org/support/theme/polite/reviews/#new-post" target="_blank" class="btn btn-secondary"><?php esc_html_e( 'Rate this theme', 'polite' ); ?></a>
			</div>
		</div>
	</div>
	<?php
}
