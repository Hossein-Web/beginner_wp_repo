<?php
/* The shortcodes file
 * @package WordPress
 * @subpackage Beginner
 * @version 1.0
 */

function beginner_contact_us_form_callback () {
   ob_start();
   include get_template_directory() . '/template_parts/contact_us_form.php';
   return ob_get_clean();

}

add_shortcode( 'contact_us_form', 'beginner_contact_us_form_callback' );
