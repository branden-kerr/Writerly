<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package um-theme
 */
if ( ! is_active_sidebar( 'sidebar-page' ) ) {
	return;
}
?>


<aside id="secondary" class="widget-area widget-area-side <?php um_theme_determine_sidebar_position();?> <?php um_determine_single_sidebar_width();?>" role="complementary">
	<?php
		do_action( 'um_theme_before_sidebar' );
		dynamic_sidebar( 'sidebar-page' );
		do_action( 'um_theme_after_sidebar' );
	?>
</aside>