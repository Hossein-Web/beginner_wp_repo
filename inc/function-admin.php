<?php
/*==========================
* The admin settings page
* ==========================
*/
//website admin settings
function beginner_website_settings() {
    //menu pages
    add_menu_page( 'تنظیمات وب سایت', 'تنظیمات وب سایت', 'manage_options', 'website_settings', 'beginner_contact_us_template', 'dashicons-admin-generic', 81 );

    //submenu pages
    add_submenu_page( 'website_settings', 'تنظیمات تماس با ما', 'تنظیمات تماس با ما', 'manage_options', 'website_settings', 'beginner_contact_us_template' );
    add_submenu_page( 'website_settings', 'تنظیمات فرضی', 'تنظیمات فرضی', 'manage_options', 'website_settings_2', 'beginner_some_template' );

    //contact us settings fields action
    add_action( 'admin_init', 'beginner_contact_us_settings_fields' );
}

add_action( 'admin_menu', 'beginner_website_settings' );

function beginner_contact_us_template() {
//contact us admin settings
    require_once get_template_directory() . '/template_parts/contact_us_admin_template.php';
}

function beginner_some_template() {
//contact us admin settings
}

//contact us admin page settings fields

function beginner_contact_us_settings_fields() {
    register_setting('contact_us_info_group', 'google_map_option');
    add_settings_section('google_map_section', 'آدرس شرکت یا محل کار', 'beginner_google_map_section_callback', 'website_settings');
    add_settings_field('google_map_field', 'کد نقشه گوگل', 'beginner_google_map_field_callback', 'website_settings', 'google_map_section');

    register_setting('contact_us_info_group', 'address_1_option');
    register_setting('contact_us_info_group', 'address_2_option');
    register_setting('contact_us_info_group', 'address_3_option');

    register_setting('contact_us_info_group', 'tel_1_option');
    register_setting('contact_us_info_group', 'tel_2_option');
    register_setting('contact_us_info_group', 'tel_3_option');

    register_setting('contact_us_info_group', 'email_1_option');
    register_setting('contact_us_info_group', 'email_2_option');
    register_setting('contact_us_info_group', 'email_3_option');

    add_settings_section('contact_us_info_section', 'اطلاعات تماس', 'beginner_contact_us_info_section_callback', 'website_settings');

    add_settings_field('address_1_field', 'آدرس 1', 'beginner_address_1_field_callback', 'website_settings', 'contact_us_info_section');
    add_settings_field('address_2_field', 'آدرس 2', 'beginner_address_2_field_callback', 'website_settings', 'contact_us_info_section');
    add_settings_field('address_3_field', 'آدرس 3', 'beginner_address_3_field_callback', 'website_settings', 'contact_us_info_section');

    add_settings_field('tel_1_field', 'تلفن 1', 'beginner_tel_1_field_callback', 'website_settings', 'contact_us_info_section');
    add_settings_field('tel_2_field', 'تلفن 2', 'beginner_tel_2_field_callback', 'website_settings', 'contact_us_info_section');
    add_settings_field('tel_3_field', 'تلفن 3', 'beginner_tel_3_field_callback', 'website_settings', 'contact_us_info_section');

    add_settings_field('email_1_field', 'نشانی ایمیل 1', 'beginner_email_1_field_callback', 'website_settings', 'contact_us_info_section');
    add_settings_field('email_2_field', 'نشانی ایمیل 2', 'beginner_email_2_field_callback', 'website_settings', 'contact_us_info_section');
    add_settings_field('email_3_field', 'نشانی ایمیل 3', 'beginner_email_3_field_callback', 'website_settings', 'contact_us_info_section');
}

// google map section callback

function beginner_google_map_section_callback() {

}


// google map field callback

function beginner_google_map_field_callback() {
    $google_map = get_option( 'google_map_option' );
    if( empty( $google_map ) ) {
        echo '<textarea id="google_map_option" class="large-text code" aria-describedby="google_map_description" rows="5" name="google_map_option" ></textarea>';
        echo '<p id="google_map_description" class="description" >کد iframe دریافت شده از سایت google map را در اینجا قرار دهید.</p>';
    }else{
        echo '<textarea id="google_map_option" class="large-text code" aria-describedby="google_map_description" rows="5" name="google_map_option" >' . esc_attr( $google_map ) . '</textarea>';
        echo '<p id="google_map_description" class="description" >کد iframe دریافت شده از سایت google map را در اینجا قرار دهید.</p>';
    }

}

//contact us info section callback

function beginner_contact_us_info_section_callback() {
}

//contact us info field callback functions

function beginner_address_1_field_callback() {
    $address_1 = get_option( 'address_1_option' );

    if ( empty( $address_1 ) ) {
        echo '<input id="address_1_option" class="large-text" type="text" name="address_1_option" />';
    }else {
        echo '<input id="address_1_option" class="large-text" type="text" name="address_1_option" value="' . esc_attr( $address_1 ) . '" />';
    }

}

function beginner_address_2_field_callback() {

    $address_2 = get_option( 'address_2_option' );

    if ( empty( $address_2 ) ) {
        echo '<input id="address_2_option" class="large-text" type="text" name="address_2_option" />';
    }else {
        echo '<input id="address_2_option" class="large-text" type="text" name="address_2_option" value="' . esc_attr( $address_2 ) . '" />';
    }

}

function beginner_address_3_field_callback() {

    $address_3 = get_option( 'address_3_option' );

    if ( empty( $address_3 ) ) {
        echo '<input id="address_3_option" class="large-text" type="text" name="address_3_option" />';
    }else {
        echo '<input id="address_3_option" class="large-text" type="text" name="address_3_option" value="' . esc_attr( $address_3 ) . '" />';
    }

}

//contact us tel field callback functions

function beginner_tel_1_field_callback() {

    $tel_1 = get_option( 'tel_1_option' );

    if ( empty( $tel_1 ) ) {
        echo '<input id="tel_1_option" class="ltr" type="text" name="tel_1_option" />';
    }else {
        echo '<input id="tel_1_option" class="ltr" type="text" name="tel_1_option" value="' . esc_attr( $tel_1 ) . '" />';
    }

}

function beginner_tel_2_field_callback() {

    $tel_2 = get_option( 'tel_2_option' );

    if ( empty( $tel_2 ) ) {
        echo '<input id="tel_2_option" class="ltr" type="text" name="tel_2_option" />';
    }else {
        echo '<input id="tel_2_option" class="ltr" type="text" name="tel_2_option" value="' . esc_attr( $tel_2 ) . '" />';
    }

}

function beginner_tel_3_field_callback() {

    $tel_3 = get_option( 'tel_3_option' );

    if ( empty( $tel_3 ) ) {
        echo '<input id="tel_3_option" class="ltr" type="text" name="tel_3_option" />';
    }else {
        echo '<input id="tel_3_option" class="ltr" type="text" name="tel_3_option" value="' . esc_attr( $tel_3 ) . '" />';
    }

}

//contact us email field callback functions

function beginner_email_1_field_callback() {

    $email_1 = get_option( 'email_1_option' );

    if ( empty( $email_1 ) ) {
        echo '<input id="email_1_option" class="regular-text" type="email" name="email_1_option" />';
    }else {
        echo '<input id="email_1_option" class="regular-text" type="email" name="email_1_option" value="' . esc_attr( $email_1 ) . '" />';
    }

}

function beginner_email_2_field_callback() {

    $email_2 = get_option( 'email_2_option' );

    if ( empty( $email_2 ) ) {
        echo '<input id="email_2_option" class="regular-text" type="email" name="email_2_option" />';
    }else {
        echo '<input id="email_2_option" class="regular-text" type="email" name="email_2_option" value="' . esc_attr( $email_2 ) . '" />';
    }

}

function beginner_email_3_field_callback() {

    $email_3 = get_option( 'email_3_option' );

    if ( empty( $email_3 ) ) {
        echo '<input id="email_3_option" class="regular-text" type="email" name="email_3_option" />';
    }else {
        echo '<input id="email_3_option" class="regular-text" type="email" name="email_3_option" value="' . esc_attr( $email_3 ) . '" />';
    }

}

// Adding meta box in post
/*add_filter( 'rwmb_meta_boxes', 'beginner_post_meta_box' );

function beginner_post_meta_box( $meta_boxes ) {
    $beginner_text_domain = 'beginbeginner';

    $meta_boxes[] = array(
        'title'      => __( 'جزئیات سربرگ پست', $beginner_text_domain ),
        'post_types' => 'post',
        'fields'     => array(
            array(
                'name'  => __( 'ویدئو شاخص', $beginner_text_domain ),
                'id'    => 'beginner_featured_video',
                'type'  => 'image_advanced',
                'desc'  => __( 'ویدئو ابتدای پست', $beginner_text_domain )
            )
        )
    );

    return $meta_boxes;
}*/

// kirki customized contact us function
function beginner_customize_contact_us_callback( $wp_customize ) {
    // social media settings
    kirki::add_config( 'beginner_social_media_id', array(
        'capability'    => 'edit_theme_options',
        'option_type'   => 'theme_mod'
    ) );

    kirki::add_panel( 'beginner_contact_us_panel_id', array(
        'title'         => 'تنظیمات تماس با ما',
        'description'   => 'این بخش مربوط به صفحه تماس با ما است.',
        'priority'      => 10

    ) );

    kirki::add_section( 'beginner_contact_us_section_id', array(
        'title'         => 'راه های ارتباطی',
        'description'   => 'در این بخش راه های ارتباطی خود با مخاطبین را مشخص کنید.',
        'panel'         => 'beginner_contact_us_panel_id',
        'priority'      => 160
    ) );

    // address settings
    Kirki::add_config( 'beginner_address_id', array(
        'capability'    => 'edit_theme_options',
        'option_type'   => 'theme_mod'
    ) );

    // email settings
    Kirki::add_config( 'beginner_email_id', array(
        'capability'    => 'edit_theme_options',
        'option_type'   => 'theme_mod'
    ) );

    // email settings
    Kirki::add_config( 'beginner_phone_id', array(
        'capability'    => 'edit_theme_options',
        'option_type'   => 'theme_mod'
    ) );

}

add_action( 'customize_register', 'beginner_customize_contact_us_callback' );

$beginner_social_media_args = array(
    'type'          => 'repeater',
    'label'         => esc_html__( 'شبکه اجتماعی', 'beginbeginner' ),
    'section'       => 'beginner_contact_us_section_id',
    'priority'      => 10,
    'row_label'     => array(
        'type'      => 'text',
        'value'     => esc_html__( 'شبکه اجتماعی', 'beginbeginner' ),
    ),
    'button_label'  => esc_html__( 'افزودن جدید', 'beginbeginner' ),
    'settings'      => 'beginner_social_media_settings',
    'default'       => array(
        // social media defaults
    ),
    'fields'        => array(
        'beginner_social_media_url' => array(
            'type'          => 'text',
            'label'         => esc_html__( 'آدرس', 'beginbeginner' ),
            'description'   => esc_html__( 'آدرس شبکه اجتماعی', 'beginbeginner' ),
            'default'       => ''
        ),
        'beginner_social_media_class' => array(
            'type'          => 'text',
            'label'         => esc_html__( 'کلاس', 'beginbeginner' ),
            'description'   => esc_html__( 'کلاس مربوط به شبکه اجتماعی از سایت https://fontawesome.com/icons', 'beginbeginner' ),
            'default'       => ''
        )
    )
);
kirki::add_field( 'beginner_social_media_id', $beginner_social_media_args );

$beginner_address_args = array(
    'type'          => 'repeater',
    'label'         => esc_html__( 'آدرس ها', 'beginbeginner' ),
    'section'       => 'beginner_contact_us_section_id',
    'priority'      => 10,
    'row_label'     => array(
        'type'      => 'text',
        'value'     => esc_html__( 'آدرس', 'beginbeginner' ),
    ),
    'button_label'  => esc_html__( 'افزودن جدید', 'beginbeginner' ),
    'settings'      => 'beginner_address_settings',
    'default'       => array(
        // address defaults
    ),
    'fields'        => array(
        'beginner_address' => array(
            'type'          => 'text',
            'label'         => esc_html__( 'آدرس', 'beginbeginner' ),
            'description'   => esc_html__( 'آدرس خود را در این قسمت بنویسید.', 'beginbeginner' ),
            'default'       => ''
        )
    )
);
kirki::add_field( 'beginner_address_id', $beginner_address_args );

$beginner_email_args = array(
    'type'          => 'repeater',
    'label'         => esc_html__( 'آدرس های پست الکترونیکی', 'beginbeginner' ),
    'section'       => 'beginner_contact_us_section_id',
    'priority'      => 10,
    'row_label'     => array(
        'type'      => 'text',
        'value'     => esc_html__( 'پست الکترونیکی', 'beginbeginner' ),
    ),
    'button_label'  => esc_html__( 'افزودن جدید', 'beginbeginner' ),
    'settings'      => 'beginner_email_settings',
    'default'       => array(
        // email defaults
    ),
    'fields'        => array(
        'beginner_email' => array(
            'type'          => 'email',
            'label'         => esc_html__( 'آدرس پست الکترونیکی', 'beginbeginner' ),
            'description'   => esc_html__( 'آدرس پست الکترونیکی خود را در این قسمت وارد کنید.', 'beginbeginner' ),
            'default'       => ''
        )
    )
);
kirki::add_field( 'beginner_email_id', $beginner_email_args );

$beginner_phone_args = array(
    'type'          => 'repeater',
    'label'         => esc_html__( 'تلفن تماس', 'beginbeginner' ),
    'section'       => 'beginner_contact_us_section_id',
    'priority'      => 10,
    'row_label'     => array(
        'type'      => 'text',
        'value'     => esc_html__( 'شماره تلفن', 'beginbeginner' ),
    ),
    'button_label'  => esc_html__( 'افزودن جدید', 'beginbeginner' ),
    'settings'      => 'beginner_phone_settings',
    'default'       => array(
        // phone defaults
    ),
    'fields'        => array(
        'beginner_phone' => array(
            'type'          => 'text',
            'label'         => esc_html__( 'شماره تلفن', 'beginbeginner' ),
            'description'   => esc_html__( 'شماره تلفن خود را به همراه کد در این قسمت وارد کنید.', 'beginbeginner' ),
            'default'       => ''
        )
    )
);
kirki::add_field( 'beginner_phone_id', $beginner_phone_args );