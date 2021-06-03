<?php
/**
 * Template part for displaying single posts.
 *
 * @package um-theme
 */

global $defaults;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
	<?php

	do_action( 'um_theme_single_post_top' );
	/**
	 * Functions hooked into um_theme_single_post add_action
	 *
	 * @hooked um_theme_single_post_header          - 10
	 * @hooked um_theme_single_post_featured_image  - 20
	 * @hooked um_theme_single_post_content         - 30
	 */
	do_action( 'um_theme_single_post' );
	?>
</article>

<?php
	/**
	 * Functions hooked in to um_theme_single_post_bottom action
	 *
	 * @hooked um_theme_single_post_comment         		- 5
	 * @hooked um_theme_single_post_additional_content      - 10
	 */
	do_action( 'um_theme_single_post_bottom' );
?>