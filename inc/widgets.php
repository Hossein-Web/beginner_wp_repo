<?php 
    // popular post widget with image 
    //--------------------------------------------
    class beginner_popular_posts extends WP_Widget {
        
        public function __construct() {
            $beginner_options =  array(
                'classname'     => 'beginner_popular_posts_class',
                'description'   => 'نوشته های پربازدید به همراه عکس'
            );
            parent::__construct('beginner_popular_posts_id', 'نوشته های پربازدید', $beginner_options );
        }
        
        public function widget($args, $instance) {
            $beginner_title = ! empty( $instance['title'] ) ? $instance['title']: 'نوشته های پربازدید';
            $beginner_title = apply_filters('widget_title', $beginner_title );
            $beginner_args = array(
                'post_type'         => 'post',
                'post_status'       => 'publish',
                'meta_key'          => '_beginner_post_key',
                'orderby'           => 'meta_value_num',
                'order'             => 'DESC',
                'posts_per_page'    => absint( $instance['post_count'] )
            );
            $beginner_popular_posts = new WP_Query( $beginner_args );
            if( $beginner_popular_posts->have_posts() ):
                echo $args['before_widget'];
                echo $args['before_title'] . $beginner_title . $args['after_title'];
                ?>
                <ul class="beginner_recent_post">
                <?php while ( $beginner_popular_posts->have_posts() ):
                    $beginner_popular_posts->the_post();
                ?>
                    <li>
                        <a href="<?php the_permalink(); ?>" class="d-flex justify-content-center align-items-center beginner_recent_post_title">
                            <h6><?php the_title(); ?></h6>
                        </a>
                        <div class="clearfix">
                            <a href="<?php the_permalink() ?>" class="beginner_recent_post_thumb" >
                                <?php if( has_post_thumbnail() ): ?>
                                    <img class="img-fluid" alt="" src="<?php the_post_thumbnail_url( 'medium' ); ?>" />
                                <?php endif;?>
                            </a>
                            <p class="beginner_recent_post_excerpt"><?php echo get_the_excerpt(); ?></p>
                        </div>
                    </li>
                <?php endwhile; ?>
                </ul>
                <?php echo $args['after_widget'];
                wp_reset_postdata();
            endif;
        }


        public function form($instance) {
            $beginner_title = !empty( $instance['title'] )? $instance['title']: '';
            $beginner_post_count = !empty( $instance['post_count'] )? absint( $instance['post_count'] ): 5;
            ?>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>" ><?php _e('عنوان:') ?></label>
                    <input class="widefat"
                           type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>"
                           name="<?php echo esc_attr( $this->get_field_name('title') ); ?>"
                           value="<?php echo esc_attr( $beginner_title ); ?>"
                           />
                </p>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id('post_count') ); ?>" ><?php _e('تعداد نوشته:') ?></label>
                    <input class="tiny-text" min="1" step="1" 
                           type="number" id="<?php echo esc_attr( $this->get_field_id('post_count') ); ?>"
                           name="<?php echo esc_attr( $this->get_field_name('post_count') ); ?>"
                           value="<?php echo esc_attr( $beginner_post_count ); ?>"
                           />
                </p>
            <?php
        }
        
        public function update($new_instance, $old_instance) {
            $instance = array();
            $instance['title'] = !empty( $new_instance['title'] )? sanitize_text_field($new_instance['title']): '';
            $instance['post_count'] = !empty( $new_instance['post_count'] )?absint( $new_instance['post_count'] ): 5;
            return $instance;
        }
        
        
    }
    function beginner_register_popular_posts() {
        register_widget('beginner_popular_posts');
    }
    add_action('widgets_init', 'beginner_register_popular_posts');
    
    // creating number of post views meta data
    //--------------------------------------------
    function beginner_save_post_views( $beginner_post_id ) {
       $beginner_key = '_beginner_post_key'; //meta key with under score prefix will be hidden in admin post page
       $beginner_views = get_post_meta( $beginner_post_id, $beginner_key, TRUE );
       $beginner_count = empty( $beginner_views )? 0 : intval( $beginner_views );
       $beginner_count++;
       update_post_meta( $beginner_post_id, $beginner_key,  $beginner_count );
    }
    
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
    
    // custom categories widget 
    //--------------------------------------------
    
    class beginner_custom_categories extends WP_Widget {
        public function __construct() {
            $beginner_options = array(
                'classname'     => 'beginner_custom_categories_class',
                'description'   => 'نمایش دسته بندی ها'
            );
            parent::__construct('beginner_custom_categories_id', 'دسته بندی ها', $beginner_options);
        }
        
        private function beginner_the_category_link( $beginner_category, $beginner_show_count = '1' ) {
            $output = '<a href="' . get_category_link( $beginner_category->cat_ID ) . '" class="d-flex justify-content-between">';
            $output .= '<p>' . $beginner_category->cat_name . '</p>';
                 if( $beginner_show_count === '1' ): 
                    $output .= '<p class="beginner_cat_count">' . $beginner_category->count . '</p>';
                 endif; 
            $output .= '</a>';
            echo $output;
        }
        
        public function widget( $args, $instance ) {
            $beginner_title = ! empty( $instance['title'] ) ? $instance['title'] : 'دسته بندی ها';
            $beginner_title = apply_filters( 'widget_title', $beginner_title );
            $beginner_count = ! empty( $instance['categories_count'] ) ? '1' : '0';
            $beginner_hierarchical = ! empty( $instance['hierarchical'] ) ? '1' : '0';
            $beginner_categories = get_categories();
            if( ! empty( $beginner_categories ) ):
            echo $args['before_widget'];
            echo $args['before_title'] . $beginner_title . $args['after_title'];
            echo '<ul class="beginner_category">';
            if( $beginner_hierarchical === '1' ):
            foreach( $beginner_categories as $beginner_category ):
                if( $beginner_category->category_parent === 0 ): ?>
                    <li>
                        <?php 
                            $this->beginner_the_category_link( $beginner_category, $beginner_count );
                            $beginner_args = array( 'parent' => $beginner_category->cat_ID );
                            $beginner_category_children = get_categories( $beginner_args );
                             if( ! empty( $beginner_category_children ) ):
                               echo '<ul class="beginner_category_children">';
                               foreach( $beginner_category_children as $beginner_category_child ): ?>
                                 <li> 
                                    <?php $this->beginner_the_category_link( $beginner_category_child, $beginner_count ); ?>
                                 </li>    
                               <?php endforeach;
                               echo '</ul>';
                             endif; 
                            ?>
                    </li>
                <?php endif;
            endforeach;
            elseif( $beginner_hierarchical === '0' ):
                foreach( $beginner_categories as $beginner_category ): ?>
                    <li>
                        <?php $this->beginner_the_category_link( $beginner_category, $beginner_count ); ?>
                    </li>
                <?php
            endforeach;
            endif;
            echo '</ul><!--.beginner_category-->';
            echo $args['after_widget'];
             
            endif;
        }
        
        public function form( $instance ) {
            $beginner_title = ! empty( $instance['title'] ) ? $instance['title'] : '';
            $beginner_count = ! empty( $instance['categories_count'] ) ? $instance['categories_count'] : '0';
            $beginner_hierarchical = ! empty( $instance['hierarchical'] ) ? $instance['hierarchical'] : '0';
            ?>
                    <p>
                        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" ><?php _e( 'عنوان: ' ); ?></label> 
                        <input class="widefat"
                               type="text" 
                               id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                               name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                               value="<?php echo esc_attr( $beginner_title ); ?>"
                               />
                    </p>
                    <p>
                        <input type="checkbox"
                               class="checkbox"
                               id="<?php echo esc_attr( $this->get_field_id( 'categories_count' ) ); ?>"
                               name="<?php echo esc_attr( $this->get_field_name( 'categories_count' ) ); ?>"
                               <?php checked( $beginner_count ); ?>
                               />
                        <label for="<?php echo esc_attr( $this->get_field_id( 'categories_count' ) ); ?>" > <?php _e( 'نمایش تعداد نوشته ها' ); ?> </label>
                    <br />
                        <input type="checkbox"
                               class="checkbox"
                               id="<?php echo esc_attr( $this->get_field_id( 'hierarchical' ) ); ?>"
                               name="<?php echo esc_attr( $this->get_field_name( 'hierarchical' ) ); ?>"
                               <?php checked( $beginner_hierarchical ); ?>
                               />
                        <label for="<?php echo esc_attr( $this->get_field_id( 'hierarchical' ) ); ?>" > <?php _e( 'نمایش رده بندی ها' ); ?> </label>
                    </p>
             <?php 
            
        }
        
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
            $instance['categories_count'] = ! empty( $new_instance['categories_count'] ) ? '1' : '0';
            $instance['hierarchical'] = ! empty( $new_instance['hierarchical'] ) ? '1' : '0';
            
            return $instance;
            
        }
    }
    function beginner_register_custom_categories() {
        register_widget('beginner_custom_categories');
//        unregister_widget('WP_Widget_Categories');
    }
    add_action('widgets_init', 'beginner_register_custom_categories');

// custom logo widget
//--------------------------------------------
    class Beginner_Logo extends WP_Widget{
        function __construct()
        {
            $beginner_options = array(
                    'classname'     => 'beginner_logo_class',
                    'description'   => 'لوگوی سایت به همراه توصیف مختصر'
            );
            parent::__construct('beginner_logo_id', 'لوگوی سایت', $beginner_options );
        }
        public function widget($args, $instance)
        {
            $beginner_logo_id = get_theme_mod( 'custom_logo' );
            $beginner_logo_url = wp_get_attachment_image_url( $beginner_logo_id );
            $beginner_logo_description = apply_filters( 'widget_title', $instance[ 'logo_description' ] );
            echo $args[ 'before_widget' ];
            echo '<div class="beginner_logo_container"><a href="'.  esc_url(site_url())  .'"><img class="img-fluid" src="' . $beginner_logo_url . '" alt="' . get_bloginfo( 'description') . '"/></a></div>';
            if ( !empty( $beginner_logo_description ) ){
                echo '<p class="my-3" >' . $beginner_logo_description . '</p>';
            }
            echo $args[ 'after_widget' ];
        }

        public function form($instance)
        {   $beginner_logo_id = get_theme_mod( 'custom_logo' );
            $beginner_logo_url = wp_get_attachment_image_url( $beginner_logo_id );
            $beginner_logo_description = ! empty( $instance[ 'logo_description' ] ) ? esc_html( $instance[ 'logo_description' ] ) : esc_html( get_bloginfo( 'description') );
            ?>
            <p>
                <img src="<?php echo esc_url( $beginner_logo_url ); ?>" alt="" />
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('logo_description') ); ?>" ><?php _e('توصیف مختصر:') ?></label>
                <textarea class="widefat"
                       type="text" id="<?php echo esc_attr( $this->get_field_id('logo_description') ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name('logo_description') ); ?>"
                ><?php echo esc_attr( $beginner_logo_description ); ?></textarea>
            </p>
         <?php
        }

        public function update($new_instance, $old_instance) {
            $instance = array();
            $instance['logo_description'] = !empty( $new_instance['logo_description'] )? sanitize_text_field($new_instance['logo_description']): sanitize_text_field( get_bloginfo( 'description') );
            return $instance;
        }
    }

function beginner_register_logo() {
    register_widget('Beginner_Logo');
}
add_action('widgets_init', 'beginner_register_logo');

// custom social media widget
//--------------------------------------------
// this class is not complete
class Beginner_social_media extends WP_Widget{
    function __construct()
    {
        $beginner_options = array(
            'classname'     => 'beginner_social_media_class',
            'description'   => 'شبکه های اجتماعی به همراه لوگو'
        );
        parent::__construct('beginner_social_media_id', esc_html__( 'شبکه های اجتماعی', 'beginbeginner' ), $beginner_options );
    }
    public function widget($args, $instance)
    {
        $beginner_logo_id = get_theme_mod( 'custom_logo' );
        $beginner_logo_url = wp_get_attachment_image_url( $beginner_logo_id );
        $beginner_social_media = get_theme_mod( 'beginner_social_media_settings' );
        echo $args[ 'before_widget' ];
        echo '<div class="beginner_logo_container"><a href="'.  esc_url(site_url())  .'"><img class="img-fluid" src="' . $beginner_logo_url . '" alt="' . get_bloginfo( 'description') . '"/></a></div>';
        if ( !empty( $beginner_logo_description ) ){
            echo '<p class="my-3" >' . $beginner_logo_description . '</p>';
        }
        echo $args[ 'after_widget' ];
    }

    public function form($instance)
    {   $beginner_logo_id = get_theme_mod( 'custom_logo' );
        $beginner_logo_url = wp_get_attachment_image_url( $beginner_logo_id );
        $beginner_logo_description = ! empty( $instance[ 'logo_description' ] ) ? esc_html( $instance[ 'logo_description' ] ) : esc_html( get_bloginfo( 'description') );
        ?>
        <p>
            <img src="<?php echo esc_url( $beginner_logo_url ); ?>" alt="" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id('logo_description') ); ?>" ><?php _e('توصیف مختصر:') ?></label>
            <textarea class="widefat"
                      type="text" id="<?php echo esc_attr( $this->get_field_id('logo_description') ); ?>"
                      name="<?php echo esc_attr( $this->get_field_name('logo_description') ); ?>"
            ><?php echo esc_attr( $beginner_logo_description ); ?></textarea>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['logo_description'] = !empty( $new_instance['logo_description'] )? sanitize_text_field($new_instance['logo_description']): sanitize_text_field( get_bloginfo( 'description') );
        return $instance;
    }
}

function beginner_register_social_media() {
    register_widget('Beginner_social_media');
}
add_action('widgets_init', 'beginner_register_social_media');
