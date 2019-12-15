<?php
/* The custom post type file
 * @package WordPress
 * @subpackage Beginner
 * @version 1.0
 */

// creating messages custom post type

add_action( 'init', 'beginner_messages_custom_post_type' );

function beginner_messages_custom_post_type() {

    $labels = array(
     'name'                 => 'پیام ها',
     'singular_name'        => 'پیام',
     'add_new'              => 'افزودن جدید',
     'add_new_item'         => 'افزودن پیام جدید',
     'edit_item'            => 'ویرایش پیام',
     'new_item'             => 'پیام جدید',
     'view_item'            => 'مشاهده پیام',
     'view_items'           => 'مشاهده پیام ها',
     'search_items'         => 'جستجوی پیام ها',
     'not_found'            => 'پیام یافت نشد',
     'not_found_in_trash'   => 'پیام در زباله دان یافت نشد',
     'all_items'            => 'تمام پیام ها',
     'menu_name'            => 'پیام ها',
    );
    $args = array(
        'label'             => 'پیام ها',
        'labels'            => $labels,
        'description'       => 'این نوع پست جهت نگهداری پیام های ارسالی کاربران از صفحه تماس با ما ایجاد شده است.',
        'public'            => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'menu_position'     => 26,
        'menu_icon'         => 'dashicons-format-status'
    );

    register_post_type( 'beginner_message', $args );

}

// creating user information meta box for messages custom post type

add_action( 'add_meta_boxes', 'beginner_user_info_meta_box' );

function beginner_user_info_meta_box() {
    add_meta_box( 'user_info_meta_box', 'مشخصات', 'beginner_user_info_meta_box_callback', 'beginner_message', 'side' );
}

function beginner_user_info_meta_box_callback( $post ) {

    $email_address = get_post_meta( $post->ID, '_email_address_meta_key', true );
    $author = get_post_meta( $post->ID, '_author_meta_key', true );

    echo '<p class="post-attributes-label-wrapper"><label for="beginner_email_field" class="post-attributes-label">نشانی ایمیل</label></p>';
    echo '<input id="beginner_email_field" class="ltr" type="email" size="27" name="beginner_email_field_name" value="' . esc_attr( $email_address ) . '" />';

    echo '<p class="post-attributes-label-wrapper"><label for="beginner_author_field" class="post-attributes-label">نویسنده</label></p>';
    echo '<input id="beginner_author_field" class="rtl" type="text" size="27" name="beginner_author_field_name" value="' . esc_attr( $author ) . '" />';

    wp_nonce_field( 'beginner_save_user_info_meta', 'beginner_user_info_meta_nonce' );

}

// saving user information meta box for messages custom post type

add_action( 'save_post', 'beginner_save_user_info_meta' );

function beginner_save_user_info_meta( $post_id ) {
    $email_field_value = sanitize_text_field( $_POST[ 'beginner_email_field_name' ] );
    $author_field_value = sanitize_text_field( $_POST[ 'beginner_author_field_name' ] );

     if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
         return;
     }

     if ( !isset( $_POST[ 'beginner_user_info_meta_nonce' ] ) ) {
         return;
     }

     if ( !wp_verify_nonce( $_POST[ 'beginner_user_info_meta_nonce' ], 'beginner_save_user_info_meta' ) ) {
         return;
     }

     if ( !current_user_can( 'edit_post', $post_id ) ) {
         return;
     }

     if ( isset( $email_field_value ) ) {
         update_post_meta( $post_id, '_email_address_meta_key', $email_field_value );
     }

    if ( isset( $author_field_value ) ) {
        update_post_meta( $post_id, '_author_meta_key', $author_field_value );
    }
}

// changing messages custom post type columns

add_filter( 'manage_beginner_message_posts_columns', 'beginner_set_custom_message_columns' );

function beginner_set_custom_message_columns( $columns ) {

    $new_columns = array(
            'title'             => 'موضوع',
            'full_name'         => 'نام',
            'email_address'     => 'نشانی ایمیل',
            'message_content'   => 'متن پیام',
            'date'              => 'تاریخ'
    );
    return $new_columns;

}

// displaying messages custom post type columns

add_action( 'manage_posts_custom_column', 'beginner_display_custom_message_columns', 10, 2 );

function beginner_display_custom_message_columns( $column, $post_id ) {

    switch ( $column ) {
        case 'full_name':
            $author = get_post_meta( $post_id, '_author_meta_key', true );
            echo $author;
            break;
        case 'email_address':
            $email_address = get_post_meta( $post_id, '_email_address_meta_key', true );
            echo $email_address;
            break;
        case 'message_content':
            the_excerpt();
            break;
    }

}

