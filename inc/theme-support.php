<?php
//register menu
//-------------------------------------
function beginner_register_menu(){
    add_theme_support( 'menus' );
    register_nav_menu( 'top_menu' , 'منوی بالای سایت');
    register_nav_menu( 'mobile_nav' , 'منوی موبایلی');
    
}
add_action( 'init' , 'beginner_register_menu');

//register post formats
//-------------------------------------
add_theme_support( 'post-formats', array( 'image', 'video', 'gallery', 'quote' ) );

//register featured image
//-------------------------------------
add_theme_support( 'post-thumbnails' );

//register header image
//-------------------------------------
add_theme_support( 'custom-header' );

//register logo image
//-------------------------------------
add_theme_support( 'custom-logo' );

// register beginner_sidebar_1 widget area
//--------------------------------------------
function beginner_sidebar(){
    $beginner_args = array( 
        'name'          => 'ستون کناری',
        'id'            => 'beginner_sidebar_1',
        'before_widget' => '<div class="beginner_widget">',
        'after_widget'  => '</div><!--beginner_widget-->',
        'before_title'  => '<h5 class="beginner_widget_heading">',
        'after_title'   => '</h5><!--beginner_widget_heading-->'
        );
    register_sidebar( $beginner_args );
}
add_action( 'widgets_init' ,  'beginner_sidebar' );

// register beginner_footer_sidebar_1 widget area
//--------------------------------------------

function beginner_footer_sidebar() {
    $beginner_args = array(
        'name'          => 'نوار پایینی',
        'id'            => 'beginner_footer_sidebar_1',
        'before_widget' => '<div class="col-md-4"><div class="beginner_widget">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<h6 class="mt-2">',
        'after_title'   => '</h6>'
    );

    register_sidebar( $beginner_args );
}

add_action( 'widgets_init', 'beginner_footer_sidebar' );


// Register beginner_header_sidebar_1 widget area
//--------------------------------------------

function beginner_header_sidebar(){
    $beginner_args = array(
        'name'              => 'نوار بالایی',
        'id'                => 'beginner_header_sidebar_1',
        'before_widget'     => '<div class="d-flex col-md-6 col-12 justify-content-center justify-content-md-end" >',
        'after_widget'      => '</div>',
        'before_title'      => '<h6 class="mt-2">',
        'after_title'       => '</h6>'
    );
    register_sidebar( $beginner_args );
}
add_action( 'widgets_init', 'beginner_header_sidebar' );

// edit tag cloud widgets
//--------------------------------------------
function beginner_widget_tag_cloud_args( $args ) {
    $args['format'] = 'list';
    $args['largest'] = 0.8;
    $args['smallest'] = 0.8;
    $args['unit'] = 'rem';
    return $args;
}
add_filter( 'widget_tag_cloud_args' , 'beginner_widget_tag_cloud_args', 10, 1);

function beginner_wp_tag_cloud( $output ) {
   $output = str_replace("<ul class='wp-tag-cloud' role='list'>", '<ul class="list-inline beginner_rtl_inline_list beginner_tags">', $output);
   $output = str_replace('<li>', '<li class="list-inline-item">', $output);
   return $output;
}
add_filter( 'wp_tag_cloud' , 'beginner_wp_tag_cloud', 10, 1 );

// changing comment reply link class
function beginner_comment_reply_link( $link ) {
    $new_link = str_replace( "class='comment-reply-link'", "class='beginner_reply'", $link );
    return $new_link;
}

add_filter( 'comment_reply_link', 'beginner_comment_reply_link', 10, 1 );
