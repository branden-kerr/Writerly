<?php
/**
 *
 * @package um-theme
 */

if ( ! function_exists( 'um_theme_custom_header_setup' ) ) {
	function um_theme_custom_header_setup() {
		add_theme_support( 'custom-header', apply_filters( 'um_theme_custom_header_args',
			array(
				'default-image'          => '',
				'default-text-color'     => '000000',
				'width'                  => 1920,
				'height'                 => 300,
				'flex-height'            => true,
				'wp-head-callback'       => 'um_theme_header_style',
				'admin-preview-callback' => 'um_theme_admin_header_image',
		) ) );
	}
}


if ( ! function_exists( 'um_theme_header_style' ) ) {
	function um_theme_header_style() {
		$header_text_color = get_header_textcolor();
		// If no custom options for text are set, let's bail
		if ( empty( $header_image ) && $header_text_color ) {
			return;
		}
		?>

		<style type="text/css">
		/* Has the text been hidden? */
		<?php if ( ! display_header_text() ) :?>
			.site-title,
			.site-description {position: absolute; clip: rect(1px, 1px, 1px, 1px);}
		/* If the user has set a custom color for the text use that. */
		<?php else : ?>
			.site-title a,
			.site-description {color: #<?php echo esc_attr( $header_text_color );?>;}
		<?php endif; ?>
		</style>
		<?php
	}
}


if ( ! function_exists( 'um_theme_admin_header_image' ) ) {
	function um_theme_admin_header_image() {
	?>
		<div id="headimg">
			<h1 class="displaying-header-text">
				<a id="name" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			</h1>
			<div class="displaying-header-text" id="desc" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>"><?php bloginfo( 'description' ); ?></div>
			<?php if ( get_header_image() ) : ?>
			<img src="<?php header_image(); ?>" alt="">
			<?php endif; ?>
		</div>
	<?php
	}
}