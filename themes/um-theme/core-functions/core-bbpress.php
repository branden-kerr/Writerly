<?php
/**
 * Helper functions for bbPress
 *
 * @package 	um-theme
 * @subpackage 	bbPress
 * @link      	https://wordpress.org/plugins/bbpress/
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// bbPress Breadcrumb.
add_action( 'um_theme_page', 'um_theme_bbpress_breadcumb', 5 );

// Remove the default css of Ultimate Member bbPress extension.
add_action( 'wp_enqueue_scripts', 'um_theme_remove_um_bbpress_css', 100 );

// Add Font Awesome arrow icons to Replies pagination.
add_filter( 'bbp_replies_pagination', 'um_theme_bbp_replies_topic_pagination_icons' );

// Add Font Awesome arrow icons to Topic pagination.
add_filter( 'bbp_topic_pagination', 'um_theme_bbp_replies_topic_pagination_icons' );

// Add Font Awesome arrow icons to Search Results pagination.
add_filter( 'bbp_search_results_pagination', 'um_theme_bbp_replies_topic_pagination_icons' );

// Add Font Awesome icon to favorite.
add_filter( 'bbp_after_get_user_favorites_link_parse_args', 'um_theme_bbp_filter_favorites_button' );

// Add Font Awesome icon to Forum Subscribe.
add_filter( 'bbp_after_get_forum_subscribe_link_parse_args', 'um_theme_bbp_filter_subscribtion_button' );

// Add Font Awesome icon to User Subscribe.
add_filter( 'bbp_after_get_user_subscribe_link_parse_args', 'um_theme_bbp_filter_subscribtion_button' );

// Add custom class to bbPress Forum container.
add_filter( 'bbp_get_forum_class', 'um_bb_forum_add_class' );

// Add custom class to bbPress Topic container.
add_filter( 'bbp_get_topic_class', 'um_bb_topic_add_class' );


/**
 * Modify the pagination links to use Font Awesome
 * icons.
 *
 * @since 1.0.0
 *
 * @param  $args Current arguments.
 * @return $args Modified arguments.
 */
if ( ! function_exists( 'um_theme_bbp_replies_topic_pagination_icons' ) ) {
	function um_theme_bbp_replies_topic_pagination_icons( $args ) {
		$args['prev_text'] = is_rtl() ? '<i class="fa fa-chevron-right"></i>' : '<i class="fa fa-chevron-left"></i>';
		$args['next_text'] = is_rtl() ? '<i class="fa fa-chevron-left"></i>' : '<i class="fa fa-chevron-right"></i>';

		return $args;
	}
}


/**
 * Filter the favorite button default text.
 *
 * @since 1.0.0
 *
 * @param  $args Current arguments.
 * @return $args Modified arguments.
 */
if ( ! function_exists( 'um_theme_bbp_filter_favorites_button' ) ) {
	function um_theme_bbp_filter_favorites_button( $args ) {
		$args['favorite'] = '<i class="fa fa-star"></i>';
		$args['favorited'] = '<i class="fa fa-star"></i>';

		return $args;
	}
}

/**
 * Filter the subscribe button default text.
 *
 * @since 1.0.0
 *
 * @param  $args Current arguments.
 * @return $args Modified arguments.
 */
if ( ! function_exists( 'um_theme_bbp_filter_subscribtion_button' ) ) {
	function um_theme_bbp_filter_subscribtion_button( $args ) {
		$args['before'] = '';
		$args['subscribe'] = '<i class="fa fa-rss"></i>';
		$args['unsubscribe'] = '<i class="fa fa-rss"></i>';

		return $args;
	}
}

/**
 * bbPress Breadcrumb
 */
if ( ! function_exists( 'um_theme_bbpress_breadcumb' ) ) {
	function um_theme_bbpress_breadcumb() {
		if ( is_bbpress() ) {
			echo '<div class="um-bbpress-breadcrumb">';
			echo '<div class="boot-row">';
			echo '<div class="boot-col-10">';
			bbp_breadcrumb();
			echo '</div>';
			echo '<div class="boot-col-2 boot-text-right">';
			bbp_topic_subscription_link();
			bbp_user_favorites_link();
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}
	}
}

/**
 * bbPress Forum top snippet
 */
if ( ! function_exists( 'um_bb_get_single_forum_description' ) ) {
	function um_bb_get_single_forum_description( $args = '' ) {

			// Parse arguments against default values.
			$r = bbp_parse_args( $args, array(
				'forum_id'  => 0,
				'size'      => 25,
				'feed'      => true,
			), 'get_single_forum_description' );

			// Validate forum_id.
			$forum_id = (int) bbp_get_forum_id( $r['forum_id'] );

			// Unhook the 'view all' query var adder.
			remove_filter( 'bbp_get_forum_permalink', 'bbp_add_view_all' );

			// Get some forum data.
			$tc_int      = bbp_get_forum_topic_count( $forum_id, false );
			$rc_int      = bbp_get_forum_reply_count( $forum_id, false );
			$topic_count = bbp_get_forum_topic_count( $forum_id );
			$reply_count = bbp_get_forum_reply_count( $forum_id );
			$last_active = bbp_get_forum_last_active_id( $forum_id );

			// Has replies.
			if ( ! empty( $reply_count ) ) {
				$reply_text = $reply_count;
			}

			// Forum has active data.
			if ( ! empty( $last_active ) ) {
				$topic_text      = bbp_get_forum_topics_link( $forum_id );
				$time_since      = bbp_get_forum_freshness_link( $forum_id );
				$last_updated_by = bbp_get_author_link( array( 'post_id' => $last_active, 'size' => $r['size'] ) );
			}

			// Forum has active data.
			if ( ! empty( $last_active ) ) {

				if ( ! empty( $reply_count ) ) {
					?>
					<div class="bbp-template-notice info boot-container">
					<div class="boot-row boot-align-items-center">
						<div class="boot-col-3">
							<span class="topic-info-number"><?php echo esc_html( $topic_text );?></span>
							<span class="topic-info-title"><?php esc_html_e( 'Topic', 'um-theme' );?></span>
						</div>
						<div class="boot-col-3">
							<span class="topic-info-number"><?php echo esc_html( $reply_text );?></span>
							<span class="topic-info-title"><?php esc_html_e( 'Replies', 'um-theme' );?></span>
						</div>
						<div class="boot-col-3">
							<span class="topic-info-number"><?php echo esc_html( $time_since );?></span>
							<span class="topic-info-title"><?php esc_html_e( 'Recent activity', 'um-theme' );?></span>
						</div>
						<div class="boot-col-3">
							<span class="topic-info-number"><?php echo esc_html( $last_updated_by );?></span>
							<span class="topic-info-title"><?php esc_html_e( 'Last updated by', 'um-theme' );?></span>
						</div>
					</div>
					</div>
						<?php
				} else {
					?>
					<div class="bbp-template-notice info boot-container">
					<div class="boot-row boot-align-items-center">
						<div class="boot-col-4">
							<span class="topic-info-number"><?php echo esc_html( $topic_text );?></span>
							<span class="topic-info-title"><?php esc_html_e( 'Topic', 'um-theme' );?></span>
						</div>
						<div class="boot-col-4">
							<span class="topic-info-number"><?php echo esc_html( $time_since );?></span>
							<span class="topic-info-title"><?php esc_html_e( 'Recent activity', 'um-theme' );?></span>
						</div>
						<div class="boot-col-4">
							<span class="topic-info-number"><?php echo esc_html( $last_updated_by );?></span>
							<span class="topic-info-title"><?php esc_html_e( 'Last updated by', 'um-theme' );?></span>
						</div>
					</div>
					</div>
					<?php
				}
			} else {

				if ( ! empty( $reply_count ) ) {
					?>

						<div class="bbp-template-notice info boot-container">
							<div class="boot-row boot-align-items-center">

							<div class="boot-col-6">
								<span class="topic-info-number"><?php echo esc_html( $topic_text );?></span>
								<span class="topic-info-title"><?php esc_html_e( 'Topic', 'um-theme' );?></span>
							</div>

							<div class="boot-col-6">
								<span class="topic-info-number"><?php echo esc_html( $reply_text );?></span>
								<span class="topic-info-title"><?php esc_html_e( 'Replies', 'um-theme' );?></span>
							</div>

							</div>
						</div>
					<?php
				} else {
					if ( ! empty( $topic_count ) ) {
						?>
						<div class="bbp-template-notice info boot-container">
						<div class="boot-row boot-align-items-center">
							<div class="boot-col-6">
								<span class="topic-info-number"><?php echo esc_html( $topic_text );?></span>
								<span class="topic-info-title"><?php esc_html_e( 'Topic', 'um-theme' );?></span>
							</div>
							<div class="boot-col-6">
							</div>
						</div>
						</div>
					<?php
					} else {
						?>
						<div class="bbp-template-notice info boot-container">
							<div class="boot-row boot-align-items-center">

							<div class="boot-col-12">
								<span class="topic-info-title"><?php esc_html_e( 'This forum is empty.', 'um-theme' );?></span>
							</div>

							</div>
						</div>
						<?php
					}
				}
			}
			// Add the 'view all' filter back.
			add_filter( 'bbp_get_forum_permalink', 'bbp_add_view_all' );
	}
}

/**
 * bbPress Add CSS Class : Topic.
 */
if ( ! function_exists( 'um_bb_topic_add_class' ) ) {
	function um_bb_topic_add_class( $classes ) {
		$classes[] = 'um-bb-each-topic';
		return $classes;
	}
}

/**
 * bbPress Add CSS Class : Forum.
 */
if ( ! function_exists( 'um_bb_forum_add_class' ) ) {
	function um_bb_forum_add_class( $classes ) {
		$classes[] = 'um-bb-each-forums boot-row';
		return $classes;
	}
}

/**
 * Remove bbPress UM Extension CSS.
 */
if ( ! function_exists( 'um_theme_remove_um_bbpress_css' ) ) {
	function um_theme_remove_um_bbpress_css() {
		if ( function_exists( 'um_bbpress_plugins_loaded' ) ) {
			wp_dequeue_style( 'um_bbpress' );
		}
	}
}
