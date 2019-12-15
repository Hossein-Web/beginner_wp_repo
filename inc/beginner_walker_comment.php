<?php

class Beginner_Walker_Comment extends Walker_Comment {
public function start_lvl(&$output, $depth = 0, $args = array())
{
    $GLOBALS['comment_depth'] = $depth + 1;

    switch ( $args['style'] ) {
        case 'div':
            break;
        case 'ol':
            $output .= '<ol class="beginner_children">' . "\n";
            break;
        case 'ul':
        default:
            $output .= '<ul class="beginner_children">' . "\n";
            break;
    }
}

public function end_lvl(&$output, $depth = 0, $args = array())
{
    $GLOBALS['comment_depth'] = $depth + 1;

    switch ( $args['style'] ) {
        case 'div':
            break;
        case 'ol':
            $output .= "</ol><!-- .beginner_children -->\n";
            break;
        case 'ul':
        default:
            $output .= "</ul><!-- .beginner_children -->\n";
            break;
    }
}

    protected function comment($comment, $depth, $args) {

        if ( 'div' == $args['style'] ) {
            $tag = 'div';
            $add_below = 'comment';
        } else {
            $tag = 'li';
            $add_below = 'div-comment';
        }
        ?>
        <<?php echo $tag; ?> <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?> id="comment-<?php comment_ID(); ?>">
        <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID(); ?>" class="mt-3">
    <?php endif; ?>
        <div class="beginner_comment_header d-flex">
            <?php
            $beginner_args = array( 'class' => 'beginner_thumb' );
            if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'], '', 'کاربر', $beginner_args ); ?>
            <?php
            /* translators: %s: comment author link */
            /*printf( __( '%s <span class="says">says:</span>' ),
                sprintf( '<cite class="fn">%s</cite>', get_comment_author_link( $comment ) )
            );*/
            ?>
            <div class="beginner_comment_details" >
                <?php printf( '<p><a href="%s">%s</a></p><span>%s</span>', esc_url( get_comment_link( $comment, $args ) ), get_comment_author( $comment ), get_comment_date( '', $comment ) ); ?>
            </div>
        </div>
        <?php if ( '0' == $comment->comment_approved ) : ?>
        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ) ?></em>
        <br />
    <?php endif; ?>

        <div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
                <?php
                /* translators: 1: comment date, 2: comment time */
                printf( __( '%1$s at %2$s' ), get_comment_date( '', $comment ),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)' ), '&nbsp;&nbsp;', '' );
            ?>
        </div>
        <div class="beginner_comment_text">
            <?php comment_text( $comment, array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
        </div><!-- .beginner_comment_text -->

        <?php
        comment_reply_link( array_merge( $args, array(
            'add_below' => $add_below,
            'depth'     => $depth,
            'max_depth' => $args['max_depth'],
            'before'    => '',
            'after'     => ''
        ) ) );
        ?>

        <?php if ( 'div' != $args['style'] ) : ?>
        </div>
    <?php endif; ?>
        <?php
    }

}