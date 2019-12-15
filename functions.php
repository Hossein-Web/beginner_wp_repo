<?php

/* ==========================
 * require files
 * ==========================
 */
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/theme-support.php';
require_once get_template_directory() . '/inc/walker.php';
require_once get_template_directory() . '/inc/beginner_walker_comment.php';
require_once get_template_directory() . '/inc/ajax_response.php';
require_once get_template_directory() . '/inc/widgets.php';
require_once get_template_directory() . '/inc/function-admin.php';
require_once get_template_directory() . '/inc/shortcodes.php';
require_once get_template_directory() . '/inc/custom-post-type.php';

// setting languages directory
add_action( 'after_setup_theme', 'beginner_language_settings' );
function beginner_language_settings() {
    load_theme_textdomain( 'beginbeginner', get_template_directory() . '/languages' );
}
//remove wordpress version
//-------------------------------------

remove_action('wp_head', 'wp_generator');

function beginner_remove_wp_version($src) {
    global $wp_version;
    parse_str(parse_url($src, PHP_URL_QUERY), $query);
    if (!empty($query['ver']) && $query['ver'] === $wp_version) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}

add_filter('script_loader_src', 'beginner_remove_wp_version');
add_filter('style_loader_src', 'beginner_remove_wp_version');

//Adding img-fluid class to images in posts
//--------------------------------------------

function beginner_add_class( $class ){
    return $class . ' img-fluid' ;
}
add_filter( 'get_image_tag_class', 'beginner_add_class' );
// create pagination
//--------------------------------------------
function beginner_pagination(){

    if (is_singular()):
        return;
    endif;
    $beginner_post = $GLOBALS[ 'wp_query' ];

    /** Stop execution if there's only 1 page */
    if ($beginner_post->max_num_pages <= 1):
        return;
    endif;
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max = intval( $beginner_post->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 ):
        $links[] = $paged;
    endif;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ):
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    endif;

    if ( ( $paged + 2 ) <= $max ):
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    endif;

    echo '<div class="beginner_pagination"><ul>' . "\n";

    /** Previous Post Link */
    if ( get_previous_posts_link() ):
        printf( '<li>%s</li>' . "\n", get_previous_posts_link( 'قبلی' ) );
    endif;

    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ):
        if( 1 == $paged ):
            printf( '<li%s><span>%s</span></li>' . "\n", ' class="beginner_active"', '1' );
        else:
            printf( '<li%s><a href="%s">%s</a></li>' . "\n", '', esc_url( get_pagenum_link( 1 ) ), '1' );
        endif;

        if ( ! in_array( 2, $links ) ):
            echo '<li class="beginner_dots"><span>...</span></li>';
        endif;
    endif;

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ):
        if( $link == $paged ):
            printf( '<li%s><span>%s</span></li>' . "\n", ' class="beginner_active"', $link );
        else:
            printf( '<li%s><a href="%s">%s</a></li>' . "\n", '', esc_url( get_pagenum_link( $link ) ), $link );
        endif;
    endforeach;

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ):
        if ( ! in_array( $max - 1, $links ) ):
            echo '<li class="beginner_dots"><span>...</span></li>' . "\n";
        endif;
        if( $max == $paged ):
            printf( '<li%s><span>%s</span></li>' . "\n", ' class="beginner_active"', $max );
        else:
            printf( '<li%s><a href="%s">%s</a></li>' . "\n", '', esc_url( get_pagenum_link( $max ) ), $max );
        endif;
    endif;

    /** Next Post Link */
    if ( get_next_posts_link() ):
        printf( '<li>%s</li>' . "\n", get_next_posts_link( 'بعدی' ) );
    endif;

    echo '</ul></div>' . "\n";
}

// changing query vars for archive page
//--------------------------------------------

function beginner_pre_get_posts( $query ){
$beginner_current_page = get_query_var( 'paged' )? get_query_var( 'paged' ):1;
if( !is_admin() && $query->is_main_query() ):
    if( $query->is_archive() ):
       $query->set( 'posts_per_archive_page', '3' );
       $query->set( 'paged', $beginner_current_page ); 
    endif;
    if( $query->is_home() ):
        $query->set( 'posts_per_page', '5' );
        $query->set( 'paged', $beginner_current_page );
    endif;
    if( $query->is_search() ):
        $query->set( 'post_type', 'post' );
        $query->set( 'posts_per_page', '5' );
    endif;

endif;
}
add_action( 'pre_get_posts', 'beginner_pre_get_posts' );


//fake SMTP server

function mailtrap($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.mailtrap.io';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 2525;
    $phpmailer->Username = 'd976b9612dd5a9';
    $phpmailer->Password = '8f2914eab61b1b';
}

add_action('phpmailer_init', 'mailtrap');

// when acf plugin is deactivated
if ( !function_exists( 'get_field' ) ) {
    function get_field(){
        return '';
    }
}
if ( !function_exists( 'acf_photo_gallery' ) ) {
    function acf_photo_gallery(){
        return '';
    }
}

// bread crumb function for test
/*function the_breadcrumb() {
    global $post;
    echo '<ul id="breadcrumbs">';
    if (!is_home()) {
        echo '<li><a href="';
        echo get_option('home');
        echo '">';
        echo 'Home';
        echo '</a></li><li class="separator"> / </li>';
        if (is_category() || is_single()) {
            echo '<li>';
            //the_category(' </li><li class="separator"> / </li><li> ');
            single_cat_title( ' </li><li class="separator"> / </li><li> ' );
            if (is_single()) {
                echo '</li><li class="separator"> / </li><li>';
                the_title();
                echo '</li>';
            }
        } elseif (is_page()) {
            if($post->post_parent){
                $anc = get_post_ancestors( $post->ID );
                $title = get_the_title();
                foreach ( $anc as $ancestor ) {
                    $output = '<li><a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a></li> <li class="separator">/</li>';
                }
                echo $output;
                echo '<strong title="'.$title.'"> '.$title.'</strong>';
            } else {
                echo '<li><strong> '.get_the_title().'</strong></li>';
            }
        }
    }
    elseif (is_tag()) {single_tag_title();}
    elseif (is_day()) {echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';}
    elseif (is_month()) {echo"<li>Archive for "; the_time('F, Y'); echo'</li>';}
    elseif (is_year()) {echo"<li>Archive for "; the_time('Y'); echo'</li>';}
    elseif (is_author()) {echo"<li>Author Archive"; echo'</li>';}
    elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'</li>';}
    elseif (is_search()) {echo"<li>Search Results"; echo'</li>';}
    echo '</ul>';
}*/