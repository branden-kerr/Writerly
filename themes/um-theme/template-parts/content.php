<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package um-theme
 */

global $defaults;

// Layout 1
if ( $defaults['um_theme_blog_posts_layout'] === 1 ) :

	// First Post
	if ( $wp_query->current_post === 0 ) : ?>

		<article id="post-<?php the_ID();?>" <?php post_class( 'boot-col-sm-6' );?>>
			<div class="blog-post-container blog-post-one boot-text-center">

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="blog-post-image">
						<?php um_theme_post_thumbnail();?>
					</div>
				<?php endif;?>

				<div class="blog-post-title entry-header boot-text-center">
					<h3 class="entry-title">
						<a href="<?php the_permalink();?>">
							<?php the_title();?>
						</a>
					</h3>
				</div>

				<?php um_theme_category(); ?>

				<div class="entry-excerpt">
					<?php the_excerpt();?>
				</div>

				<p class="more-link-wrap">
					<a href="<?php the_permalink();?>">
						<?php esc_html_e( 'Continue Reading', 'um-theme' );?>
					</a>
				</p>
			</div>
		</article>

	<?php
	// Second Post
	elseif ( $wp_query->current_post === 1 ) : ?>

			<article id="post-<?php the_ID();?>" <?php post_class( 'boot-col-sm-6' );?> >
				<div class="blog-post-container blog-post-one boot-text-center">

					<?php if ( has_post_thumbnail() ) : ?>
						<div class="blog-post-image">
							<?php um_theme_post_thumbnail();?>
						</div>
					<?php endif;?>

					<div class="blog-post-title entry-header boot-text-center">
						<h3 class="entry-title">
							<a href="<?php the_permalink();?>">
								<?php the_title();?>
							</a>
						</h3>
					</div>

					<?php um_theme_category(); ?>

					<div class="entry-excerpt">
						<?php the_excerpt();?>
					</div>

					<p class="more-link-wrap">
						<a href="<?php the_permalink();?>">
							<?php esc_html_e( 'Continue Reading', 'um-theme' );?>
						</a>
					</p>

				</div>
			</article>

	<?php
	// rest of the posts.
	else : ?>

			<article id="post-<?php the_ID();?>" <?php post_class( 'boot-col-sm-4' );?>>
			<div class="blog-post-container blog-post-one-alt boot-text-center">

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="blog-post-image">
						<?php um_theme_post_thumbnail();?>
					</div>
				<?php endif;?>

				<div class="blog-post-title entry-header boot-text-center">
					<h4 class="entry-title">
						<a href="<?php the_permalink();?>">
							<?php the_title();?>
						</a>
					</h4>
				</div>

			</div>
			</article>

		<?php endif;

// Layout 2
else : ?>

	<article id="post-<?php the_ID();?>" <?php post_class( 'boot-col-sm-12' );?>>

		<header class="entry-header">
			<h3 class="entry-title">
				<a href="<?php the_permalink();?>">
					<?php the_title();?>
				</a>
			</h3>
		</header>

		<?php um_published_on();?>

		<span class="meta"><?php esc_html_e( 'by', 'um-theme' );?></span>
		<?php um_post_author();?>
		<span class="meta"> - </span>
		<span class="meta">
			<a href="<?php comments_link(); ?>"><?php comments_number( 'Leave a comment', '1 Response', '% Responses' ); ?></a>
		</span>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="featured-image">
				<?php um_theme_post_thumbnail();?>
			</div>
		<?php endif;?>

		<div class="excerpt">
			<?php the_excerpt();?>
		</div>

	</article>

<?php endif;?>