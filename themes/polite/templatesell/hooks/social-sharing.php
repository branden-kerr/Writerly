<?php
/**
 * Social Sharing Hook *
 * @since 1.0.0
 *
 * @param int $post_id
 * @return void
 *
 */
if (!function_exists('polite_social_sharing')) :
    function polite_social_sharing($post_id)
    {
        $polite_url = get_the_permalink($post_id);
        $polite_title = get_the_title($post_id);
        $polite_image = get_the_post_thumbnail_url($post_id);
        
        //sharing url
        $polite_twitter_sharing_url = esc_url('http://twitter.com/share?text=' . $polite_title . '&url=' . $polite_url);
        $polite_facebook_sharing_url = esc_url('https://www.facebook.com/sharer/sharer.php?u=' . $polite_url);
        $polite_pinterest_sharing_url = esc_url('http://pinterest.com/pin/create/button/?url=' . $polite_url . '&media=' . $polite_image . '&description=' . $polite_title);
        $polite_linkedin_sharing_url = esc_url('http://www.linkedin.com/shareArticle?mini=true&title=' . $polite_title . '&url=' . $polite_url);
        
        ?>
        <div class="meta_bottom">
            <div class="post-share">
                <a target="_blank" href="<?php echo $polite_facebook_sharing_url; ?>"><i class="fa fa-facebook"></i></a>
                <a target="_blank" href="<?php echo $polite_twitter_sharing_url; ?>"><i
                            class="fa fa-twitter"></i></a>
                <a target="_blank" href="<?php echo $polite_pinterest_sharing_url; ?>"><i
                            class="fa fa-pinterest"></i></a>
                <a target="_blank" href="<?php echo $polite_linkedin_sharing_url; ?>"><i class="fa fa-linkedin"></i></a>
            </div>
        </div>
        <?php
    }
endif;
add_action('polite_social_sharing', 'polite_social_sharing', 10);