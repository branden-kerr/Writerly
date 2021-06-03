<?php
/**
 * The template for displaying Author pages.
 *
 * @link https://codex.wordpress.org/Author_Templates
 *
 * @package um-theme
 */

global $defaults;
get_header();

// Get author data.
$avatar             = get_avatar( get_the_author_meta( 'user_email' ), 500 );
$author_name        = get_the_author();
$author_bio         = get_the_author_meta( 'description' );
$author_post_url    = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
?>

<main id="main" class="site-main" tabindex="-1" role="main">
<div class="website-canvas">
<div class="boot-row">

    <div id="primary" class="content-area single-page__content <?php um_determine_single_content_width();?> <?php um_theme_determine_sidebar_position();?>">

        <section class="author-bio-page">
            <div class="boot-row">
                <div class="boot-col-md-5"><?php echo wp_kses_post( $avatar ); ?></div>
                <div class="boot-col-md-7">
                    <h1 class="author-bio-title"><?php echo esc_html( $author_name ); ?></h1>
                    <?php
                        if ( $author_bio ) {
                            echo '<p class="author-bio-description">';
                            echo wp_kses_post( $author_bio );
                            echo '</p>';
                        }
                    ?>
                </div>
            </div>
        </section>

        <?php if ( have_posts() ) : ?>
            <div class="author-bio-page--posts boot-row">
                <h2 class="boot-col-sm-12"><?php echo esc_html( 'Posts by', 'um-theme' );?> <?php echo esc_attr( $author_name ); ?>:</h2>
                <?php do_action( 'um_theme_loop_before' ); ?>
                <?php
                    while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/content' );
                    endwhile;
                ?>
                <?php do_action( 'um_theme_loop_after' ); ?>
            </div>
        <?php endif;?>

    </div>

    <?php get_sidebar(); ?>

</div>
</div>
</main>
<?php
get_footer();
