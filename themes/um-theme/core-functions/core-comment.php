<?php
/**
 * Helper functions for Comments section.
 *
 * @package     um-theme
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

/*
 * Comment Markup
 */
if ( ! function_exists( 'um_theme_comment' ) ) {
    function um_theme_comment( $comment, array $args, $depth ) {
        /**
         * Outputs a comment in the HTML5 format.
         *
         * @see wp_list_comments()
         * @see https://developer.wordpress.org/reference/functions/get_comment_author_url/
         * @see https://developer.wordpress.org/reference/functions/get_comment_author/
         * @see https://developer.wordpress.org/reference/functions/get_avatar/
         * @see https://developer.wordpress.org/reference/functions/get_comment_reply_link/
         * @see https://developer.wordpress.org/reference/functions/get_edit_comment_link/
         *
         * @param WP_Comment $comment Comment to display.
         * @param int        $depth   Depth of the current comment.
         * @param array      $args    An array of arguments.
         */

        // Get correct tag used for the comments
        if ( 'div' === $args['style'] ) {
            $tag       = 'div';
            $add_below = 'comment';
        } else {
            $tag       = 'li';
            $add_below = 'div-comment';
        } ?>

        <<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>">


    <?php
    // Switch between different comment types
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' : ?>
        <div class="pingback-entry"><span class="pingback-heading"><?php esc_html_e( 'Pingback:', 'um-theme' ); ?></span> <?php comment_author_link(); ?></div>
    <?php
        break;
        default :

        if ( 'div' != $args['style'] ) { ?>
            <article class="boot-row comment-body">
        <?php } ?>
                <div class="boot-col-md-1 boot-col-3 comment-body-avatar comment-meta commentmetadata">
                    <div class="comment-author author vcard">
                        <?php echo wp_kses_post( get_avatar( $comment, 35 ) ); ?>
                    </div>
                </div>

                <div class="boot-col-md-11 boot-col-9 comment-author-section">
                    <h5 class="comment__author body-font-family"><?php echo get_comment_author_link(); ?></h5>
                    <div class="meta-block">
                        <a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>" class="meta comment__meta comment-date">
                        <time datetime="<?php echo esc_attr( get_comment_date( DATE_W3C ) );?>">
                            <span class="meta comment__date"><?php comment_date(); ?></span>
                            <span class="meta comment__time"><?php comment_time(); ?></span>
                        </time>
                        </a>
                    </div>
                </div>

                <div class="boot-col-md-11 boot-col-12 boot-offset-md-1 comment-content" id="div-comment-<?php comment_ID() ?>">
                    <div class="comment__body comment-text"><?php comment_text(); ?></div>

                    <?php
                    // Display comment moderation text
                    if ( $comment->comment_approved == '0' ) { ?>
                        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'um-theme' ); ?></em><br/>
                    <?php } ?>

                    <div class="meta-block">
                        <button type="button" class="comment__edit">
                            <?php edit_comment_link( esc_html__( 'Edit', 'um-theme' ), '  ', '' ); ?>
                        </button>
                        <button type="button" class="meta button--reply">
                            <?php
                                comment_reply_link( array_merge( $args, array(
                                    'reply_text'    => esc_html__( 'Reply', 'um-theme' ),
                                    'add_below'     => $add_below,
                                    'depth'         => $depth,
                                    'max_depth'     => $args['max_depth'],
                            ) ) );
                            ?>
                        </button>
                    </div>
                </div>
    <?php
        if ( 'div' != $args['style'] ) { ?>
            </article>
        <?php }
    // IMPORTANT: Note that we do NOT close the opening tag, WordPress does this for us
        break;
    endswitch; // End comment_type check.
    }
}
