<div class="um-item">
<div class="boot-row um-tab-post-single">
	<div class="boot-col-md-4 um-tab-post-image">
		<?php if ( has_post_thumbnail( $post->ID ) ) {
			$image_id = get_post_thumbnail_id( $post->ID );
			$image_url = wp_get_attachment_image_src( $image_id, 'full', true ); ?>

			<div class="um-item-img">
				<a href="<?php echo get_permalink( $post ) ?>">
					<?php echo get_the_post_thumbnail( $post->ID, 'medium' ); ?>
				</a>
			</div>

		<?php } ?>
	</div>

	<div class="boot-col-md-8 um-tab-post-content">

		<div class="um-item-meta">
			<span>
				<?php printf( __( '%s ago', 'um-theme' ), human_time_diff( get_the_time( 'U', $post->ID ), current_time( 'timestamp' ) ) ); ?>
			</span>
			<span>
				<?php echo __( 'in', 'um-theme' ); ?>: <?php the_category( ', ', '', $post->ID ); ?>
			</span>
			<span>
				<?php $num_comments = get_comments_number( $post->ID );

				if ( $num_comments == 0 ) {
					$comments = __( 'no comments', 'um-theme' );
				} elseif ( $num_comments > 1 ) {
					$comments = sprintf( __( '%s comments', 'um-theme' ), $num_comments );
				} else {
					$comments = __( '1 comment', 'um-theme' );
				} ?>

				<a href="<?php echo get_comments_link( $post->ID ) ?>"><?php echo $comments; ?></a>
			</span>
		</div>

		<div class="um-item-link">
			<h4><a href="<?php echo get_permalink( $post ) ?>"><?php echo $post->post_title; ?></a></h4>
		</div>

	</div>

</div>
</div>