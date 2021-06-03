<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package um-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<?php do_action( 'um_theme_before_comments' );?>
<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>

		<?php do_action( 'um_theme_before_comments_title' );?>
		<h3 class="comments-title">
			<?php
				printf(
					esc_html( _nx( '1 Comment %2$s', '%1$s Comments %2$s', get_comments_number(), 'comments title', 'um-theme' ) ),
						number_format_i18n( get_comments_number() ),
						'<span class="sr-only sr-only-focusable">' . get_the_title() . '</span>'
				);
			?>
		</h3>
		<?php do_action( 'um_theme_after_comments_title' );?>
	<?php else : ?>
		<h5 class="comments-title"><?php esc_html_e( 'Leave a Response', 'um-theme' ); ?></h5>
	<?php endif;?>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>

		<nav id="comment-nav-above" class="navigation comment-navigation">
			<h2 class="sr-only sr-only-focusable"><?php esc_html_e( 'Comment navigation', 'um-theme' ); ?></h2>
			<div class="nav-links">
				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'um-theme' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'um-theme' ) ); ?></div>
			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-above -->
	<?php endif; // Check for comment navigation. ?>

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>

		<ul class="comment-list">
			<?php
				wp_list_comments(
					array(
						'style'     => 'ul',
						'callback'	=> 'um_theme_comment',
					)
				);
			?>
		</ul><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-below" class="navigation comment-navigation">
			<h2 class="sr-only sr-only-focusable"><?php esc_html_e( 'Comment navigation', 'um-theme' ); ?></h2>
			<div class="nav-links">
				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'um-theme' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'um-theme' ) ); ?></div>
			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-below -->
		<?php endif; // Check for comment navigation. ?>
	<?php endif; // Check for have_comments(). ?>

	<?php comment_form(); ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'um-theme' ); ?></p>
	<?php endif;?>
</div><!-- #comments -->
<?php do_action( 'um_theme_after_comments' );?>