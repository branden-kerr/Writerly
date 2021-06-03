<?php
/**
 * The template for displaying header.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package um-theme
 */
global $defaults;
$defaults = um_theme_option_defaults();?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta content="initial-scale=1, minimum-scale=1, width=device-width" name="viewport">
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	}
?>

<?php do_action( 'um_theme_before_site' ); ?>

<div id="page" class="hfeed site website-width">

<?php do_action( 'um_theme_before_header' );?>

	<header id="masthead" class="custom-header site-header <?php um_theme_output_header_sticky_class();?>" role="banner">
		<?php
		// Elementor `header` location
		if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
			/**
			 * Functions hooked into um_theme_header action
			 *
			 * @hooked um_theme_header_custom_background   - 20
			 * @hooked um_theme_core_header                - 30
			 */
			 do_action( 'um_theme_header' );
		}
		?>
	</header>
	<?php do_action( 'um_theme_after_header' ); ?>

<div class="boot-row">
	<div class="boot-col-md-12">

	<?php do_action( 'um_theme_before_content' ); ?>

	<div id="content" class="boot-container-fluid site-content">
		<?php do_action( 'um_theme_content_top' );