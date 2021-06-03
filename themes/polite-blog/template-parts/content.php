<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Polite Grid
 */
global $polite_theme_options;
$show_content_from = esc_attr($polite_theme_options['polite-content-show-from']);
$read_more = esc_html($polite_theme_options['polite-read-more-text']);
$masonry = esc_attr($polite_theme_options['polite-column-blog-page']);
$image_location = esc_attr($polite_theme_options['polite-blog-image-layout']);
$social_share = absint($polite_theme_options['polite-show-hide-share']);
$date = absint($polite_theme_options['polite-show-hide-date']);
$category = absint($polite_theme_options['polite-show-hide-category']);
$author = absint($polite_theme_options['polite-show-hide-author']);
$read_time = absint($polite_theme_options['polite-show-hide-read-time']);
$has_content = ($show_content_from == 'content') ? 'has-content' : 'no-cotent';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($masonry); ?>>
    <div class="post-wrap <?php echo esc_attr($image_location); ?> <?php echo esc_attr($has_content); ?>">
        <?php if(has_post_thumbnail()) { ?>
            <div class="post-media">
                <?php polite_post_thumbnail(); ?>
                <?php 
                if( 1 == $social_share ){
                    do_action( 'polite_social_sharing' ,get_the_ID() );
                }
                ?>
            </div>
        <?php } ?>
        <div class="post-content">
            <?php if($category == 1 ){ ?>
                <div class="post-cats">
                    <?php polite_entry_meta(); ?>
                </div>
            <?php } ?>
            <div class="post_title">
                <?php
                if (is_singular()) :
                    the_title('<h1 class="post-title entry-title">', '</h1>');
                else :
                    the_title('<h2 class="post-title entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                    ?>
                <?php endif; ?>
            </div>
            <div class="post-excerpt entry-content">
                <?php
                if (is_singular()) {
                    the_content();
                } else {
                    if ($show_content_from == 'excerpt') {
                        the_excerpt();
                    }elseif($show_content_from == 'content') {
                        the_content();
                    }else{
                       echo "";
                    }
                }
                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'polite-blog'),
                    'after' => '</div>',
                ));
                ?>
                <!-- read more -->
                <?php if (!empty($read_more) && $show_content_from == 'excerpt'): ?>
                    <a class="more-link" href="<?php the_permalink(); ?>"><?php echo esc_html($read_more); ?> <i
                                class="fa fa-long-arrow-right"></i>
                    </a>
                <?php endif; ?>
            </div>
            <!-- .entry-content end -->
            <div class="post-meta">
                <?php
                if ('post' === get_post_type()) :
                    ?>
                    <div class="post-date">
                        <div class="entry-meta">
                            <?php
                            if($date == 1 ){
                                polite_posted_on();
                            }
                            if($author == 1 ){
                                polite_posted_by();
                            }
                            if($read_time == 1 ){
                                polite_blog_read_time();
                            }
                            ?>
                        </div><!-- .entry-meta -->
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</article><!-- #post- -->