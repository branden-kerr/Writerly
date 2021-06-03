<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package UM Theme
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container-card-content">

        <?php
            /**
             * Functions hooked into um_theme_page action
             *
             * @hooked um_theme_output_page_header          - 10
             * @hooked um_theme_output_page_content         - 20
             */
            do_action( 'um_theme_page' );
        ?>

	</div>
</article>
