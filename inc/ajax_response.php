<?php
add_action( 'wp_ajax_beginner_load_comments', 'beginner_load_more_comments' );
add_action( 'wp_ajax_nopriv_beginner_load_comments', 'beginner_load_more_comments' );
function beginner_load_more_comments() {
    $next_comment_page = $_POST[ 'comment_page' ];
    $post_id = $_POST[ 'post_id' ];
    global $post;
    $post = get_post( $post_id );
    setup_postdata( $post );
        $args = array(
            'walker'            => new Beginner_Walker_Comment(),
            'style'             => 'ol',
            'max_depth'         => 4,
            'avatar_size'       => 64,
            'page'              => $next_comment_page,
            'per_page'          => get_option('comments_per_page'));
        wp_list_comments( $args );

wp_die();
}

add_action( 'wp_ajax_beginner_save_contact_us_info', 'beginner_save_contact_us_info_callback' );
add_action( 'wp_ajax_nopriv_beginner_save_contact_us_info', 'beginner_save_contact_us_info_callback' );

function beginner_save_contact_us_info_callback() {

    $name = wp_strip_all_tags( $_POST[ 'name' ] );
    $email_address = wp_strip_all_tags( $_POST[ 'email' ] );
    $subject = wp_strip_all_tags( $_POST[ 'subject' ] );
    $comment_text = wp_strip_all_tags( $_POST[ 'comment' ] );
    $message_post_array = array(
        'post_type'     => 'beginner_message',
        'post_author'   => 1,
        'post_content'  => $comment_text,
        'post_title'    =>  $subject,
        'post_status'   => 'publish',
        'comment_status'=> 'closed',
        'ping_status'   => 'closed',
        'meta_input'    => array( '_author_meta_key' => $name, '_email_address_meta_key' => $email_address )
    );

   $post_id = wp_insert_post( $message_post_array );

   if ( $post_id !== 0 ) {
       $to = get_bloginfo( 'admin_email' );
       $headers[] = 'From: ' . get_bloginfo( 'name' ) . '<' . $to . '>';
       $headers[] = 'Reply-To: ' . $name . '<' . $email_address . '>';
       $headers[] = 'Content-Type: text/html; charset= UTF-8';
       wp_mail( $to, $subject, $comment_text, $headers  );
   }

   echo $post_id;
   wp_die();

}
