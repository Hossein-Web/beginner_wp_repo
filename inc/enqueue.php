<?php
    /*==========================
    * enqueue styles and scripts
    * ==========================
    */
    function beginner_enqueue() {
        //==============styles=================
        wp_enqueue_style( 'bootstrap_css', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '4.0.0', 'all' );        
        wp_enqueue_style( 'beginner_font_awesome', get_template_directory_uri() . '/assets/css/fontawesome-all.css', array(), '5.0.8', 'all' );
        wp_enqueue_style( 'owl_carousel_theme_default_css', get_template_directory_uri() . '/assets/css/owl.theme.default.min.css', array(), '2.3.4', 'all');
        wp_enqueue_style( 'owl_carousel_css', get_template_directory_uri() . '/assets/css/owl.carousel.min.css', array(), '2.3.4', 'all');
        wp_enqueue_style( 'magnific_popup_css', get_template_directory_uri() . '/assets/css/magnific-popup.css', array(), '1.1.0', 'all');
        wp_enqueue_style( 'beginner_css', get_template_directory_uri() . '/assets/css/beginner_style.css', array(), '1.0.0', 'all' );
        
        //==============scripts=================
        wp_enqueue_script( 'jquery_js', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), '1.10.2', TRUE );
        wp_enqueue_script( 'bootstrap_js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery_js' ), '4.0.0', TRUE );
        wp_enqueue_script( 'owl_carousel_js', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( ), '2.3.4', TRUE );
        wp_enqueue_script( 'jquery_sticky_js', get_template_directory_uri() . '/assets/js/jquery.sticky.js', array( 'jquery_js' ), '1.0.4', TRUE );
        wp_enqueue_script( 'magnific_popup_js', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.js', array( 'jquery_js' ), '1.1.0', TRUE );
        wp_enqueue_script( 'beginner_js', get_template_directory_uri() . '/assets/js/beginner_js.js', array( 'jquery_js' ), '1.0.0', TRUE );
    }
    add_action( 'wp_enqueue_scripts', 'beginner_enqueue' );
    