<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package um-theme
 */

?>

<li>
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '>', '</a></span>' ); ?>
	</header>

		<?php um_theme_post_thumbnail();?>

	<div class="search-excerpt">
		<?php
		the_excerpt();
		?>
	</div>
</li>
