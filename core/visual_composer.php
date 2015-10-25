<?php
$target_arr = array(__("Same window", KC_DOMAIN) => "_self", __("New window", KC_DOMAIN) => "_blank");

add_shortcode_param( 'number_field', 'number_field_vc' );
if( !function_exists('number_field_vc')){
    function number_field_vc( $settings, $value ) {
    return '<div class="stm_number_field_block">'
        .'<input type="number" name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
        esc_attr( $settings['param_name'] ) . ' ' .
        esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" />' .
        '</div>'; // This is html markup that will be outputted in content elements edit form
}
}
      /*  Service */
if( !function_exists('vc_service_function')){
    function vc_service_function($atts, $content = null){
    $output     =   '';
     extract( shortcode_atts( array(
      'title'                      =>   '',
      'head_icon'                  =>  '',
      'count_word'                 =>  '',
      'count_items'                =>  '',
      'select_categories'          =>  '',
      'button_title'               =>  '',
      'style'                      =>   2,
      'size'                       =>   ''
   ), $atts ) );
    $array_size         =   ['thumbnail','medium','large','full '];
    if(!in_array(trim($size),$array_size )){
        $size   =   'medium' ;
    }
    $output     .=  '<section id="service-section" class="service-section ow-section">';
    $output     .=  '<div class="container"><div class="section-header">';
    $output     .=  '<h3><img src="'.wp_get_attachment_url($head_icon).'" alt="sep-icon" /> '.$title.'</h3></div> ';
    $output     .=  '<div id="make-clean-service" class="owl-carousel owl-theme services-style'.$style.'">';
    if((is_numeric($select_categories)) && ($select_categories >=0)){
        if( !is_numeric($count_items)) $count_items=0;
            $list_post      =   get_posts(['category'=>$select_categories,'posts_per_page'=>$count_items] );
            foreach( $list_post as $post):setup_postdata( $post );
                $content       =   get_the_content( );

                $output         .=  '<div class="item">';
                $output         .=  '<div class="service-box">';
                $output         .=  get_the_post_thumbnail($post->ID,$size);
                $output         .=  '<div class="service-box-inner">';
                $output         .=   '<h4>'.get_the_title($post->ID ).'</h4>';
                if($style==2)$output         .=   '<p>'.the_excerpt_max_charlength($content,$count_word).'</p>';

                $output         .=   '<a title="xx'.$button_title.'" href="'.post_permalink( $post->ID ).'">'.$button_title.'</a>';
                $output         .=    '</div></div></div>';
            endforeach;
    }

    $output                 .=  '</div></div> </div> ';
    $output                 .=  '</section>';
    return                  $output;
}
}

add_shortcode('vc_service','vc_service_function' );
vc_map( array(
    'name'              => __( 'Service Offer', KC_DOMAIN ),
    'base'              => 'vc_service',
    'icon'              => 'stm_gallery_grid',
    'category'          => __( 'Make clean', KC_DOMAIN ),
    'params'            => array(
      array(
            'type'              => 'textfield',
            'heading'           => __( 'Title', KC_DOMAIN ),
            'param_name'        => 'title'
      ),
      array(
            'type'              => 'attach_image',
            'heading'           => __( 'Image', KC_DOMAIN ),
            'param_name'        => 'head_icon',
            "value"             => "",
            "description"       => __("Select images from media library.", KC_DOMAIN)
      ),
      array(
            'type'              => 'number_field',
            'heading'           => __( 'Number word display', KC_DOMAIN ),
            'param_name'        => 'count_word',
            'value'             => 50,
            'description'       => __( 'Enter number of word display short content.', KC_DOMAIN )
        ),
      array(
            'type'              => 'dropdown',
            'heading'           => __( 'Style slider', KC_DOMAIN ),
            'param_name'        => 'style',
            'value'             =>   [1,2],
            'description'       => __( 'Choose style slide.', KC_DOMAIN )
        ),
      array(
            'type'              => 'textfield',
            'heading'           => __( 'Size image to display', KC_DOMAIN ),
            'param_name'        => 'image_size',
            'value'             => 'thumbnail',
            'description'       => __( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size..', KC_DOMAIN )
        ),
      array(
            'type'              => 'textfield',
            'heading'           => __( 'Number items to  display', KC_DOMAIN ),
            'param_name'        => 'count_items',
            'value'             => 10,
            'description'       => __( 'Enter number of items display in  slide.', KC_DOMAIN )
        ),
       array(
            "type"              => "my_category",
            "heading"           => __("Select category", KC_DOMAIN),
            "param_name"        => "select_categories",
            "description"       => __("Select category.", KC_DOMAIN)
        ),
        array(
            'type'              => 'textfield',
            'heading'           => __( 'Title  display on button', KC_DOMAIN ),
            'param_name'        => 'button_title',
            'value'             => '',
            'description'       => __( 'Enter title button.', KC_DOMAIN )
        ),
    ),
  ) );
add_shortcode( 'vc_service','vc_service_function');
$post_types = get_post_types( array() );
$post_types_list = array();
if ( is_array( $post_types ) && ! empty( $post_types ) ) {
    foreach ( $post_types as $post_type ) {
        if ( $post_type !== 'revision' && $post_type !== 'nav_menu_item'/* && $post_type !== 'attachment'*/ ) {
            $label = ucfirst( $post_type );
            $post_types_list[] = array( $post_type, __( $label, KC_DOMAIN ) );
        }
    }
}
$post_types_list[] = array( 'custom', __( 'Custom query', KC_DOMAIN ) );
$post_types_list[] = array( 'ids', __( 'List of IDs', KC_DOMAIN ) );
if( !function_exists('category_settings_field')){
    function category_settings_field($param, $param_value) {
                $dependency = vc_generate_dependencies_attributes($param);
                $entries = get_categories();
                $param_line = '';
                $param_line .= '<select name="'.$param['param_name'].'" class="wpb_vc_param_value dropdown wpb-input wpb-select '.$param['param_name'].' '.$param['type'].'">';

                foreach($entries as $key => $entry) {
                    $selected = '';
                    if ( $entry->term_id == $param_value ) $selected = ' selected="selected"';
                    $sidebar_name = $entry->name;
                    $param_line .= '<option value="'.$entry->term_id.'"'.$selected.'>'.$sidebar_name.'</option>';
                }
                $param_line .= '</select>';


    return $param_line;
}
}
add_shortcode_param('my_category', 'category_settings_field');

if( !function_exists('category_wc_custom')){
    function category_wc_custom($param, $param_value){
    $taxonomy     = 'product_cat';
      $orderby      = 'name';
      $show_count   = 0;      // 1 for yes, 0 for no
      $pad_counts   = 0;      // 1 for yes, 0 for no
      $hierarchical = 1;      // 1 for yes, 0 for no
      $title        = '';
      $empty        = 0;
      $args = array(
             'taxonomy'     => $taxonomy,
             'orderby'      => $orderby,
             'show_count'   => $show_count,
             'pad_counts'   => $pad_counts,
             'hierarchical' => $hierarchical,
             'title_li'     => $title,
             'hide_empty'   => $empty
      );
     $entries = get_categories( $args );
     $dependency = vc_generate_dependencies_attributes($param);
     $param_line = '';
    $param_line .= '<select name="'.$param['param_name'].'" class="wpb_vc_param_value dropdown wpb-input wpb-select '.$param['param_name'].' '.$param['type'].'">';
     foreach($entries as $key => $entry) {
                    $selected = '';
                    if ( $entry->term_id == $param_value ) $selected = ' selected="selected"';
                    $sidebar_name = $entry->name;
                    $param_line .= '<option value="'.$entry->term_id.'"'.$selected.'>'.$sidebar_name.'</option>';
                }
                $param_line .= '</select>';


    return $param_line;

    }
}
add_shortcode_param('my_wc_category', 'category_wc_custom');








        /*Wellcome*/

vc_map( array(
    'name' => __( 'Welcome box', KC_DOMAIN ),
    'base' => 'vc_welcome',
    'icon' => 'icon-wpb-layer-shape-text',
    'wrapper_class' => 'clearfix',
    'category' => __( 'Make clean', KC_DOMAIN ),
    'description' => __( 'A block of text with WYSIWYG editor', KC_DOMAIN ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Title', KC_DOMAIN ),
            'param_name' => 'title',
            'value' => __( 'Title welcome', KC_DOMAIN )
        ),
        array(
            'type'              => 'attach_image',
            'heading'           => __( 'Image welcome', KC_DOMAIN ),
            'param_name'        => 'head_icon',
            "value"             => "",
            "description"       => __("Select images from media library.", KC_DOMAIN)
      ),
        array(
            'type'              =>  'textarea',
            'heading'           =>  __('Content welcome',KC_DOMAIN),
            'param_name'        =>  'content_welcome',
            'value'             => 'Your content',
            'description'       =>  'Enter your text'
            ),
        array(
            'type'              =>  'textfield',
            'heading'           =>  __('Button left',KC_DOMAIN),
            'param_name'        =>  'button_left',
            'value'             =>  '',
            'description'       =>  'Enter your button left name'
            ),
        array(
            'type' => 'vc_link',
            'heading' => __( 'URL (Link)', KC_DOMAIN ),
            'param_name' => 'button_left_link',
            'description' => __( 'Enter button link.', KC_DOMAIN )
        ),
        array(
            'type'              =>  'textfield',
            'heading'           =>  __('Button right',KC_DOMAIN),
            'param_name'        =>  'button_right',
            'value'             =>  '',
            'description'       =>  'Enter your button right name'
            ),
        array(
            'type' => 'vc_link',
            'heading' => __( 'URL (Link)', KC_DOMAIN ),
            'param_name' => 'button_right_link',
            'description' => __( 'Enter button link.', KC_DOMAIN )
        ),
        /*Box 1*/
        array(
            'type'              =>  'textfield',
            'heading'           =>  __('Heading title box 1',KC_DOMAIN),
            'param_name'        =>  'box_1_title',
            'value'             =>  'Value',
            'description'       =>  'Enter your header box 1 '
            ),
        array(
            'type'              => 'attach_image',
            'heading'           => __( 'Image icon box 1', KC_DOMAIN ),
            'param_name'        => 'icon_box_1',
            "value"             => "",
            "description"       => __("Select images from media library.", KC_DOMAIN)
        ),
        array(
            'type'              =>  'textarea',
            'heading'           =>  __('Content box 1',KC_DOMAIN),
            'param_name'        =>  'content_box_1',
            'value'             => 'Your content',
            'description'       =>  'Enter your text'
            ),
        /*Box 2*/
        array(
            'type'              =>  'textfield',
            'heading'           =>  __('Heading title box 2',KC_DOMAIN),
            'param_name'        =>  'box_2_title',
            'value'             =>  'Value',
            'description'       =>  'Enter your header box 2 '
            ),
        array(
            'type'              => 'attach_image',
            'heading'           => __( 'Image icon box 2', KC_DOMAIN ),
            'param_name'        => 'icon_box_2',
            "value"             => "",
            "description"       => __("Select images from media library.", KC_DOMAIN)
        ),
        array(
            'type'              =>  'textarea',
            'heading'           =>  __('Content box 2',KC_DOMAIN),
            'param_name'        =>  'content_box_2',
            'value'             => 'Your content',
            'description'       =>  'Enter your text'
            ),
        /*Box 3*/
        array(
            'type'              =>  'textfield',
            'heading'           =>  __('Heading title box 3',KC_DOMAIN),
            'param_name'        =>  'box_3_title',
            'value'             =>  'Value',
            'description'       =>  'Enter your header box 3 '
            ),
        array(
            'type'              => 'attach_image',
            'heading'           => __( 'Image icon box 3', KC_DOMAIN ),
            'param_name'        => 'icon_box_3',
            "value"             => "",
            "description"       => __("Select images from media library.", KC_DOMAIN)
        ),
        array(
            'type'              =>  'textarea',
            'heading'           =>  __('Content box 2',KC_DOMAIN),
            'param_name'        =>  'content_box_3',
            'value'             => 'Your content',
            'description'       =>  'Enter your text'
            ),


    )
) );

add_shortcode( 'vc_welcome','vc_welcome_function');
if( !function_exists('vc_welcome_function')){
    function vc_welcome_function($atts, $content = null){
        $output     =   '';
        extract( shortcode_atts( array(
          'title'                                   =>   '',
          'head_icon'                               =>  '',
          'content_welcome'                         =>  '',
          'button_left'                             =>  '',
          'button_left_link'                        =>  '',
          'button_right'                            =>  '',
          'button_right_link'                       =>   '',
          'box_1_title'                             =>   '',
          'icon_box_1'                              =>  '',
          'content_box_1'                           =>  '',
          'box_2_title'                             =>  '',
          'icon_box_2'                              =>  '',
          'content_box_2'                           =>  '',
          'box_3_title'                             =>   '',
          'icon_box_3'                              =>   '',
          'content_box_3'                           =>  '',
          'el_class'                                =>  '',

       ), $atts ) );
        if($button_left_link !=""):
            $button_left_link=vc_build_link($button_left_link);
            $button_left_link=$button_left_link['url'];
        endif;
        if($button_right_link !=""):
            $button_right_link=vc_build_link($button_right_link);
            $button_right_link=$button_right_link['url'];
        endif;
        $output         .=  '<Section id="welcome-section" class="welcome-section ow-section">';
        $output         .=  '<div class="container">';
        $output         .=  '<div class="col-md-4 col-sm-5">';
        $output         .=  '<img src="'.wp_get_attachment_url($head_icon).'" alt="'.$title.'" /></div>';
        $output         .=  '<div class="col-md-8 col-sm-7 welcome-content">';
        $output         .=  '<div class="section-header">';
        $output         .=  '<h3>'.$title.'</h3></div>';
        $output         .=  '<p> '.$content_welcome.' </p>';
        if($button_left !='') $output .='<a title="'.$button_left.'" href="'.$button_left_link.'">'.$button_left.'</a>';
        if($button_right !='') $output .='<a title="'.$button_right.'" href="'.$button_right_link.'">'.$button_right.'</a>';
        $output         .=  '<div class="welcome-content-box row">';

        $output         .=  '<div class="col-md-4 col-sm-6 welcome-box">';
        $output         .=  '<img src="'.wp_get_attachment_url($icon_box_1).'" alt="'.$box_1_title.'" />';
        $output         .=  '<h4> '.$box_1_title.' </h4>';
        $output         .=  '<p> '.$content_box_1.' </p>';
        $output         .=  '</div>';

        $output         .=  '<div class="col-md-4 col-sm-6 welcome-box">';
        $output         .=  '<img src="'.wp_get_attachment_url($icon_box_2).'" alt="'.$box_2_title.'" />';
        $output         .=  '<h4> '.$box_2_title.' </h4>';
        $output         .=  '<p> '.$content_box_2.' </p>';
        $output         .=  '</div>';

        $output         .=  '<div class="col-md-4 col-sm-6 welcome-box">';
        $output         .=  '<img src="'.wp_get_attachment_url($icon_box_3).'" alt="'.$box_3_title.'" />';
        $output         .=  '<h4> '.$box_3_title.' </h4>';
        $output         .=  '<p> '.$content_box_3.' </p>';
        $output         .=  '</div>';

        $output         .='</div> </div> </div> </section>';

        return $output;

    }
}


/*Section Member */

vc_map( array(
        'name' => __( 'Industry box & Customer reviews', KC_DOMAIN ),
        'base' => 'vc_industry',
        'wrapper_class' => 'clearfix',
        'category' => __( 'Make clean', KC_DOMAIN ),
        'description' => __( 'Industry box & Customer reviews', KC_DOMAIN ),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __( 'Header', KC_DOMAIN ),
                'param_name' => 'title_industry',
                'value' => '',
                'group' =>  __('INDUSTRIES ',KC_DOMAIN)
            ),
            array(
            'type'              => 'attach_image',
            'heading'           => __( 'Icon Header', KC_DOMAIN ),
            'param_name'        => 'icon_industry',
            "value"             => "",
            "description"       => __("Select images from media library.", KC_DOMAIN),
            'group' =>  __('INDUSTRIES ',KC_DOMAIN)
            ),
            array(
                'type' => 'textarea',
                'heading' => __( 'Description', KC_DOMAIN ),
                'param_name' => 'description_industry',
                'value' => '',
                'group' =>  __('INDUSTRIES ',KC_DOMAIN)
            ),
            array(
                'type' => 'textfield',
                'heading' => __( 'Button title', KC_DOMAIN ),
                'param_name' => 'button_industry',
                'value' => '',
                'group' =>  __('INDUSTRIES ',KC_DOMAIN)
           ),
            array(
            'type' => 'vc_link',
            'heading' => __( 'URL (Link)', KC_DOMAIN ),
            'param_name' => 'button_link',
            'description' => __( 'Enter button link.', KC_DOMAIN ),
            'group' =>  __('INDUSTRIES ',KC_DOMAIN)
            ),
            array(
            'type' => 'param_group',
            'heading' => __( 'List Serve', KC_DOMAIN ),
            'param_name' => 'values',
            'group' =>  __('INDUSTRIES ',KC_DOMAIN),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Title serve', KC_DOMAIN ),
                    'param_name' => 'title_serve',
                    'description' => __( 'Enter title for serve.', KC_DOMAIN ),

                ),
                array(
                    'type' => 'attach_image',
                    'heading' => __( 'Icon', KC_DOMAIN ),
                    'param_name' => 'serve_icon',
                    'description' => __( 'Select icon from library.', KC_DOMAIN ),
                ),


             )
            ),

            array(
                'type' => 'textfield',
                'heading' => __( 'Extra class', KC_DOMAIN ),
                'param_name' => 'extra_class_industry',
                'value' => '',
               'group' =>  __('INDUSTRIES ',KC_DOMAIN)
           ),
            /*Customers rated*/
            array(
                'type' => 'textfield',
                'heading' => __( 'Head title', KC_DOMAIN ),
                'param_name' => 'head_reviews',
                'value' => '',
                'group' =>  __('Reviews ',KC_DOMAIN)
           ),
            array(
                'type' => 'attach_image',
                'heading' => __( 'Icon header', KC_DOMAIN ),
                'param_name' => 'icon_reviews',
                'value' => '',
                'group' =>  __('Reviews ',KC_DOMAIN)
           ),
            array(
            'type' => 'param_group',
            'heading' => __( 'List reviews', KC_DOMAIN ),
            'param_name' => 'reviews_list',
            'group' =>  __('Reviews ',KC_DOMAIN),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Customer name', KC_DOMAIN ),
                    'param_name' => 'customer_name',
                    'description' => __( 'Enter customer name.', KC_DOMAIN ),

                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Position name', KC_DOMAIN ),
                    'param_name' => 'customer_position',
                    'description' => __( 'Enter customer Position.', KC_DOMAIN ),

                ),
                array(
                    'type' => 'attach_image',
                    'heading' => __( 'Customer avatar', KC_DOMAIN ),
                    'param_name' => 'cusomer_avatar',
                    'description' => __( 'Select avatar from library.', KC_DOMAIN ),
                ),
                array(
                    'type' => 'textarea',
                    'heading' => __( 'Review content', KC_DOMAIN ),
                    'param_name' => 'review_content',
                    'description' => __( 'Enter reviews content.', KC_DOMAIN ),

                ),


             )
            ),
            array(
                'type' => 'textfield',
                'heading' => __( 'Extra class', KC_DOMAIN ),
                'param_name' => 'extra_class_review',
                'value' => '',
                'group' =>  __('Reviews ',KC_DOMAIN)
           ),


        )

    )
);
add_shortcode( 'vc_industry','vc_industry_function');
if ( !function_exists('vc_industry_function')){
    function vc_industry_function($atts, $content = null){
        $output     =   '';
     extract( shortcode_atts( array(
      'title_industry'                           =>    '',
      'icon_industry'                            =>    '',
      'description_industry'                     =>    '',
      'button_industry'                          =>    '',
      'values'                                   =>    '',
      'title_serve'                              =>    [],
      'serve_icon'                               =>    [],
      'head_reviews'                             =>    '',
      'icon_reviews'                             =>    '',
      'reviews_list'                             =>    '',
      'customer_name'                            =>    [],
      'customer_position'                        =>    [],
      'cusomer_avatar'                           =>    [] ,
      'review_content'                           =>    [],
      'extra_class_industry'                     =>    '',
      'extra_class_review'                       =>    '',
      'button_link'                              =>     '',


   ), $atts ) );
        if($button_link !=""):
            $button_link         =       vc_build_link( $button_link );
            $button_link         =       esc_attr( $button_link['url'] ) ;
        endif;

        $values                 =       vc_param_group_parse_atts($values) ;
        $reviews_list           =       vc_param_group_parse_atts($reviews_list);

        $output                 .=      '<section id="industry-serve-section" class="industry-serve-section ow-section">';
        $output                 .=      '<div class="container">';
        $output                 .=      '<div class="col-md-6">';
        $output                 .=      '<div class="section-header">';
        $output                 .=      '<h3> <img src="'.wp_get_attachment_url($icon_industry).'" alt="sep-icon" />'.$title_industry.'</h3></div>';
        $output                 .=      '<div class="industry-serve '.$extra_class_industry.'">';
        $output                 .=      '<p> '.$description_industry.'</p>';
        $output                 .=      '<div class="row">';

        foreach($values as $serve_list){
            $output             .=      '<p class="col-md-6 col-sm-6"><img src="'.wp_get_attachment_url($serve_list["serve_icon"] ).'" alt="'.$serve_list["title_serve"].'" /> '.$serve_list["title_serve"].'</p>';
        }
        // for($i=0;$i<=count($values);$i++):
        //     $output             .=      '<p class="col-md-6 col-sm-6"><img src="'.wp_get_attachment_url($values[$i]["serve_icon"] ).'" alt="'.$values[$i]["title_serve"].'" /> '.$values[$i]["title_serve"].'</p>';
        // endfor;

        $output                 .=      '<a title="'.$button_industry.'" href="'.$button_link.'">'.$button_industry.'</a>';
        $output                 .=      '</div>';
        $output                 .=      '</div>';
        $output                 .=      '</div>';

        /*End industry*/

        $output                 .=      '<div class="col-md-6 '.$extra_class_review.'">';
        $output                 .=      '<div class="section-header">';
        $output                 .=      '<h3><img src="'.wp_get_attachment_url($icon_reviews).'" alt="sep-icon" /> '.$head_reviews.'</h3>';
        $output                 .=      '</div>';
        $output                 .=      '<div class="industry-serve">';
        $output                 .=      '<div id="testimonial" class="carousel slide testimonial" data-ride="carousel">';
        $output                 .=      '<ol class="carousel-indicators">';
        $output                 .=      '<li data-target="#testimonial" data-slide-to="1" class="active"></li>';
        for( $k=2; $k<=count($reviews_list);$k++):
                $output         .=      '<li data-target="#testimonial" data-slide-to="'.$k.'" class=""></li>';
        endfor;
        $output                 .=      '</ol>';
        $output                 .=      '<div class="carousel-inner" role="listbox">';
        $active                  = '';
        foreach(((array)$reviews_list) as $key=>$customer):
                if($key==0) $active='active';else $active='';
                $output         .=      '<div class="item '.$active.'">';
                $output         .=      '<img src="'.wp_get_attachment_url($customer["cusomer_avatar"]).'" alt="'.$customer["customer_name"].'" />';
                $output         .=      '<div class="carousel-caption">';
                $output         .=      '<p> '.$customer["review_content"].' </p>';
                $output         .=      '<h3> '.$customer["customer_name"].'<span>'.$customer["customer_position"].'</span></h3>';
                $output         .=      '</div>';
                $output         .=      '</div>';
        endforeach;


        $output                 .=      '</div>  </div> </div> </div> </div></section>';

        return $output;
    }
}

vc_map( array(
        'name' => __( 'Make clean Statistics', KC_DOMAIN ),
        'base' => 'vc_statistics',
        'category' => __( 'Make clean', KC_DOMAIN ),
        'description' => __( 'Make clean Statistics animation', KC_DOMAIN ),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __( 'Extra class', KC_DOMAIN ),
                'param_name' => 'class_statistics',
                'value' => '',

            ),
            array(
                    'type' => 'attach_image',
                    'heading' => __( 'Background', KC_DOMAIN ),
                    'param_name' => 'background_statistics',
                    'description' => __( 'Select icon from library.', KC_DOMAIN ),
                ),
            array(
            'type' => 'colorpicker',
            'heading' => __( 'Custom background Color', KC_DOMAIN ),
            'param_name' => 'background_color',
            'description' => __( 'Select background color for your element.', KC_DOMAIN ),

            ),
            array(
            'type' => 'param_group',
            'heading' => __( 'Statistics count animation', KC_DOMAIN ),
            'param_name' => 'list_statistics',

            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Title', KC_DOMAIN ),
                    'param_name' => 'title_statistics',
                    'description' => __( 'Enter title for statistics.', KC_DOMAIN ),

                ),
                array(
                    'type' => 'number_field',
                    'heading' => __( 'Number animation', KC_DOMAIN ),
                    'param_name' => 'animation_number',
                    'description' => __( 'Enter number for statistics.', KC_DOMAIN ),

                ),
                array(
                    'type' => 'attach_image',
                    'heading' => __( 'Icon', KC_DOMAIN ),
                    'param_name' => 'statistics_icon',
                    'description' => __( 'Select icon from library.', KC_DOMAIN ),
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => __( 'Background', KC_DOMAIN ),
                    'param_name' => 'statistics_bg',
                    'description' => __( 'Select background from library.', KC_DOMAIN ),
                ),


             )
            ),
        )
        )
);

add_shortcode( 'vc_statistics','vc_statistics_function');
if ( !function_exists('vc_statistics_function')){
    function vc_statistics_function($atts, $content = null){
        $output     =   '';
        extract( shortcode_atts( array(
          'class_statistics'                           =>    '',
          'background_statistics'                      =>       '',
          'background_color'                           =>       '',
          'list_statistics'                            =>    [],
       ), $atts ) );

        $list_statistics        =       vc_param_group_parse_atts($list_statistics);
        $background             =       '';
        if(trim($background_statistics !='')):
        $background             =       'background:url('.wp_get_attachment_url($background_statistics).')';
        else:
            $background         =       'background:'.$background_color;
        endif;
        $output                 .=      '<div id="statistics-section" class="statistics-section ow-background '.$class_statistics.'" style="'.$background.'; background-repeat: no-repeat;">';
        $output                 .=      '<div class="container">';
        $count                  =count($list_statistics);
        if($count == 0) $count =1;
        $cols                   =   ceil(12/$count);

        foreach($list_statistics as $key=> $list ):
            $output     .=      '<div class="col-md-'.$cols.' col-sm-'.$cols.' col-xs-'.($cols*2).'">';
            $output     .=      '<div class="statistics-box"> <h3>';
            $output     .=      '<img src="'.wp_get_attachment_url($list["statistics_icon"]).'" alt="'.$list["title_statistics"].'" />';
            $output     .=      '<span class="count" id="statistics_1_count-'.($key+1).'" data-statistics_percent="'.$list["animation_number"].'"></span>';
            $output     .=      '</h3>';
            $output     .=      '<img src="'.wp_get_attachment_url($list["statistics_bg"]).'" alt="brush" />';
            $output     .=      '<h4> '.$list["title_statistics"].'</h4>';
            $output     .=      '</div> </div>';
        endforeach;
        $output     .=      '';
        $output     .=      '</div> </div>';
        return $output;
    }
}


vc_map( array(
        'name'          => __( 'Make clean Latest news', KC_DOMAIN ),
        'base'          => 'vc_latest_news',
        'category'      => __( 'Make clean', KC_DOMAIN ),
        'description'   => __( 'Make clean LATEST NEWS', KC_DOMAIN ),
        'params'        => array(
            array(
                'type'              => 'textfield',
                'heading'           => __( 'Title', KC_DOMAIN ),
                'param_name'        => 'lastest_news_title',
                'value'             => '',

            ),
            array(
                    'type'          => 'attach_image',
                    'heading'       => __( 'Icon', KC_DOMAIN ),
                    'param_name'    => 'latest_news_icon',
                    'description'   => __( 'Select icon from library.', KC_DOMAIN ),
                ),
            array(
                "type"              => "my_category",
                "heading"           => __("Select category", KC_DOMAIN),
                "param_name"        => "select_categories",
                "description"       => __("Select category.", KC_DOMAIN)
            ),
            array(
                'type'              => 'textfield',
                'heading'           => __( 'Buton title readmore', KC_DOMAIN ),
                'param_name'        => 'lastest_news_button',
                'value'             => '',

            ),
             array(
                'type'              => 'textfield',
                'heading'           => __( 'Title view all', KC_DOMAIN ),
                'param_name'        => 'lastest_news_view_all',
                'value'             => '',

            ),
             array(
            'type'              => 'textfield',
            'heading'           => __( 'Number word display', KC_DOMAIN ),
            'param_name'        => 'count_word',
            'value'             => 50,
            'description'       => __( 'Enter number of word display short content.', KC_DOMAIN )
        ),
             array(
                'type'              => 'textfield',
                'heading'           => __( 'Extra class', KC_DOMAIN ),
                'param_name'        => 'extra_class',
                'value'             => '',

            ),

         )
    )
);

add_shortcode( 'vc_latest_news','vc_latest_news_function');
if ( !function_exists('vc_latest_news_function')){
    function vc_latest_news_function($atts, $content = null){
        $output     =   '';
        extract( shortcode_atts( array(
          'lastest_news_title'                             =>       '',
          'latest_news_icon'                               =>       '',
          'select_categories'                              =>       '',
          'lastest_news_button'                            =>       '' ,
          'lastest_news_view_all'                           =>       '',
          'count_word'                                      =>      '',
          'extra_class'                                    =>       '',
       ), $atts ) );
        $output             .=           '<div id="blog-section" class="blog-section ow-section '.$extra_class.'">';
        $output             .=           '<div class="container">';
        $output             .=           '<div class="section-header">';
        $output             .=           '<h3><img src="'.wp_get_attachment_url( $latest_news_icon).'" alt="sep-icon" />'.$lastest_news_title.'</h3>';
        $output             .=           '</div>';

        $output             .=           '';
         if((is_numeric($select_categories)) && ($select_categories >=0)){

                $list_post      =   get_posts(['category'=>$select_categories,'posts_per_page'=>2] );
                foreach( $list_post as $post):setup_postdata( $post );
                    $content       =   get_the_content( );

                    $output         .=  '<article class="col-md-6 col-sm-12">';
                    $output         .=  '<div class="blog-box">';
                    $output         .=  '<div class="blog-box-inner">';
                    $output         .=  '<header class="entry-header">';
                    $output         .=  '<h3><a title="'.get_the_title($post->ID ).'" href="'.get_post_permalink( $post->ID ).'">'.get_the_title($post->ID ).'</a></h3>';
                    $output         .=  '</header>';
                    $output         .=  '<footer class="entry-footer">';
                    $output         .=  '<span class="byline">';
                    $output         .=  '<span class="screen-reader-text">'.__('BY',KC_DOMAIN).' </span>';
                    $output         .=  author_link();
                    $output         .=  '</span> ';
                    $output         .=  '<span class="byline">';
                    $output         .=  '<span class="screen-reader-text">'.__('Likes',KC_DOMAIN).' </span>';
                    $output         .=  '<a title="Likes" href="#">23</a> </span>';
                    $output         .=  '</footer>';
                    $output         .=  '<div class="entry-content">';
                    $output         .=  '<p>'.the_excerpt_max_charlength($content,$count_word).' ...</p>';
                    $output         .=  '</div>';
                    $output         .=  '<a title="'.$lastest_news_button.'" href="'.get_post_permalink( $post->ID ).'">'.$lastest_news_button.'</a>';
                    $output         .=  '</div>';
                    $output         .=  '<div class="entry-cover pull-right last-new-home">';
                    $output         .=  '<a title="'.$post->post_title.'" href="'.get_post_permalink( $post->ID ).'" >'.get_the_post_thumbnail($post->ID,"medium").' </a>';
                    $output         .=  '<span class="posted-on">';
                    $output         .=  '<span class="like">'.wp_count_comments( $post->ID )->total_comments.'</span>';
                    $output         .=  '<span class="date">'. get_the_date( 'd/m/Y', $post->ID ).'</span>';
                    $output         .=  '</span>';
                    $output         .=  '</div>';
                    $output         .=  '</div> </article>';


                endforeach;
        }

        $output             .=           '<a href="'.get_category_link( $select_categories ).'" class="btn">'.$lastest_news_view_all.'</a>';
        $output             .=           '</div> </div>';
        return $output;

    }
}

vc_map( array(
   "name" => __("Home blocks Products by Brand Carousel", KC_DOMAIN),
   "base" => "vc_brand",
    "wrapper_class" => "clearfix",
    "category" => __('Make clean', KC_DOMAIN),
    "description" => __('Home blocks of Products by Brand Carousel', KC_DOMAIN),
   "params" => array(

        array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", KC_DOMAIN),
         "param_name" => "title",
         "value" => __("New Collection",KC_DOMAIN),
         "description" => __("Block title.",KC_DOMAIN)
        ),
        array(
         "type" => "attach_image",
         "heading" => __("Icon", KC_DOMAIN),
         "param_name" => "icon",
         "description" => __("Icon title.",KC_DOMAIN)
        ),
         array(
          "type" => "dropdown",
          "heading" => __("Columns count", KC_DOMAIN),
          "param_name" => "columns_count",
          "value" => array(6, 5, 4, 3, 2, 1),
          "admin_label" => true,
          "description" => __("Select columns count.", KC_DOMAIN)
        ),


        array(
         "type" => "number_field",
         "holder" => "div",
         "class" => "",
         "heading" => __("Number items", KC_DOMAIN),
         "param_name" => "num_items",
         "value" => "6",
         "description" => __("Number of items in a carousel.",KC_DOMAIN)
        ),




   )
) );

add_shortcode( 'vc_brand','vc_brand_function');
if ( !function_exists('vc_brand_function')){
    function vc_brand_function($atts, $content = null){
        $output     =   '';
        extract( shortcode_atts( array(
          'title'                             =>       '',
          'columns_count'                               =>       '',
          'num_items'                            =>       '' ,
          'icon'                            =>'',

       ), $atts ) );
        $terms = get_terms( YITH_WCBR::$brands_taxonomy, [ 'hide_empty' => false,'number'=>$num_items ] );
        $output         .=      '<div id="partner-section" class="partner-section ow-section">';
        $output         .=      '<div class="container">';
        $output         .=      '<div class="section-header">';
        $output         .=      '<h3><img src="'.wp_get_attachment_url($icon ).'" alt="sep-icon" />'.$title.'</h3>';
        $output         .=      '</div>';
        $output         .=      '<div id="make-clean-partner" class="owl-carousel owl-theme">';
        foreach($terms as $term):
            $thumbnail_id = absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ) );
            $image = wp_get_attachment_url( $thumbnail_id, 'yith_wcbr_logo_size' );
            $output         .=      '<div class="item">';
            $output         .=      '<a title="'.$term->name.'" class="partner-logo" href="'.get_term_link($term).'"><img src="'.$image.'" alt="'.$term->name.'" /></a>';
            $output         .=      '</div>';
        endforeach;

        $output         .=      '</div>';
        $output         .=      '</div>';
        $output         .=      '</div>';
        return $output;

       }
   }


vc_map( array(
   "name" => __("Home blocks STAFFS by STAFFS Carousel", KC_DOMAIN),
   "base" => "vc_staffs",
    "wrapper_class" => "clearfix",
    "category" => __('Make clean', KC_DOMAIN),
    "description" => __('Home blocks STAFFS by STAFFS Carousel', KC_DOMAIN),
    "params" => array(

        array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", KC_DOMAIN),
         "param_name" => "title",
         "value" => __("New Collection",KC_DOMAIN),
         "description" => __("Block title.",KC_DOMAIN)
        ),
        array(
         "type" => "textarea",
         "holder" => "div",
         "class" => "",
         "heading" => __("Description", KC_DOMAIN),
         "param_name" => "description",
         "value" => __("New Collection",KC_DOMAIN),
         "description" => __("Block title.",KC_DOMAIN)
        ),
        array(
                    'type' => 'attach_image',
                    'heading' => __( 'Icon', KC_DOMAIN ),
                    'param_name' => 'staffs_icon',
                    'description' => __( 'Select  from library.', KC_DOMAIN ),
                ),
        array(
            'type' => 'param_group',
            'heading' => __( 'List Serve', KC_DOMAIN ),
            'param_name' => 'list_staffs',
            'params' => array(
            array(
                    'type' => 'textfield',
                    'heading' => __( 'Staffs name', KC_DOMAIN ),
                    'param_name' => 'staffs_name',
                    'description' => __( 'Enter name for staffs.', KC_DOMAIN ),

                ),
                array(
                    'type' => 'attach_image',
                    'heading' => __( 'Avatar', KC_DOMAIN ),
                    'param_name' => 'satffs_avatar',
                    'description' => __( 'Select  from library.', KC_DOMAIN ),
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => __( 'Icon hover', KC_DOMAIN ),
                    'param_name' => 'icon_hover',
                    'description' => __( 'Select  from library.', KC_DOMAIN ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Position staffs', KC_DOMAIN ),
                    'param_name' => 'staffs_position',
                    'description' => __( 'Enter name position staffs.', KC_DOMAIN ),

                ),


            )
        ),
    )
    )
);
add_shortcode( 'vc_staffs','vc_staffs_function');
if ( !function_exists('vc_staffs_function')){
    function vc_staffs_function($atts, $content = null){
        $output     =   '';
        extract( shortcode_atts( array(
          'title'                             =>       '',
          'description'                               =>       '',
          'list_staffs'                            =>       [],
          'staffs_icon'                            =>'',

       ), $atts ) );
        $list_staffs             =       vc_param_group_parse_atts($list_staffs);
        $output                 .=      '<section id="team-section" class="team-section ow-section">';
        $output                 .=      '<div class="container">';
        $output                 .=      '<div class="col-md-3 col-sm-4">';
        $output                 .=      '<div class="section-header">';
        $output                 .=      '<h3><img src="'.wp_get_attachment_url( $staffs_icon ).'" alt="sep-icon" /> '.$title.'</h3>';
        $output                 .=      '</div>';
        $output                 .=      '<p>'.$description.'  </p>';
        $output                 .=      '</div>';
        $output                 .=      '<div class="col-md-9 col-sm-8">';
        $output                 .=      '<div id="make-clean-team" class="owl-carousel owl-theme team-style1">';

        foreach($list_staffs as $list_staff):
            $output                 .=      '<div class="item">';
            $output                 .=      '<div class="team-box">';
            $output                 .=      '<img src="'.wp_get_attachment_url($list_staff["satffs_avatar"] ).'" alt="team" />';
            $output                 .=      '<div class="team-box-inner">';
            $output                 .=      '<img src="'.wp_get_attachment_url($list_staff["icon_hover"] ).'" alt="team icon" />';
            $output                 .=      '<h4> '.$list_staff["staffs_name"].' </h4> <hr>';
            $output                 .=      '<p> '.$list_staff["staffs_position"].' </p>';
            $output                 .=      '</div>';
            $output                 .=      '</div>';
            $output                 .=      '</div>';
        endforeach;
        $output                 .=      '</div>';
        $output                 .=      '</div>';
        $output                 .=      '</div>';
        $output                 .=      '</section>';


        return $output;
    }
}
vc_map( array(
       "name" => __("Blocks testimonial by testimonial Carousel", KC_DOMAIN),
       "base" => "vc_testimonial",
        "wrapper_class" => "clearfix",
        "category" => __('Make clean', KC_DOMAIN),
        "description" => __('Blocks testimonial by testimonial Carousel', KC_DOMAIN),
        "params" => array(

            array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Title", KC_DOMAIN),
             "param_name" => "title",
             "value" => __("New Collection",KC_DOMAIN),
             "description" => __("Block title.",KC_DOMAIN)
            ),
            array(
            'type' => 'param_group',
            'heading' => __( 'List testimonial', KC_DOMAIN ),
            'param_name' => 'list_testimonial',
            'params' => array(

                array(
                        'type' => 'textarea',
                        'heading' => __( 'Content', KC_DOMAIN ),
                        'param_name' => 'content',
                        'description' => __( 'Enter your content testimonial.', KC_DOMAIN ),
                    ),
                )
            ),
            array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Extra class", KC_DOMAIN),
             "param_name" => "extra_class",
             "description" => __("Extra class.",KC_DOMAIN)
            ),

        )
    )
);

add_shortcode( 'vc_testimonial','vc_testimonial_function');
if ( !function_exists('vc_testimonial_function')){
    function vc_testimonial_function($atts, $content = null){
        $output     =   '';
        extract( shortcode_atts( array(
          'title'                                       =>       '',
          'list_testimonial'                            =>       [],
          'extra_class'                                 =>'',

       ), $atts ) );
        $list_testimonial   =       vc_param_group_parse_atts($list_testimonial);
        $output             .=      '<div id="testimonial-section" class="testimonial-section ow-section">';
        $output             .=      '<div class="container">';
        $output             .=      '<div id="testimonial-carousel" class="carousel slide" data-ride="carousel">';
        $output             .=      '<div class="carousel-inner" role="listbox">';
        $active             ='active';
        foreach($list_testimonial as $k=>$list):
            if(0 !=$k)$active ='';
        $output             .=      '<div class="item '.$active.'">';
        $output             .=      '<div class="testimonial-box">';
        $output             .=      $list['content'];
        $output             .=      '</div>';
        $output             .=      '</div>';
        endforeach;
        $output             .=      '</div>';
        $output             .=      '<a class="left carousel-control" href="#testimonial-carousel" role="button" data-slide="prev">';
        $output             .=      '<span class="fa fa-long-arrow-left" aria-hidden="true"></span>';
        $output             .=      '<span class="sr-only">'.__('Previous',KC_DOMAIN).'</span';
        $output             .=      '</a>';
        $output             .=      '<a class="right carousel-control" href="#testimonial-carousel" role="button" data-slide="next">';
        $output             .=      '<span class="fa fa-long-arrow-right" aria-hidden="true"></span>';
        $output             .=      '<span class="sr-only">'.__('Next',KC_DOMAIN).'</span>';
        $output             .=      '</a>';
        $output             .=      '</div>';
        $output             .=      '</div>';
        $output             .=      '</div>';

        return $output;


    }
}

vc_map( array(
       "name" => __("Blocks Category Product", KC_DOMAIN),
       "base" => "vc_featured_product",
        "wrapper_class" => "clearfix",
        "category" => __('Make clean', KC_DOMAIN),
        "description" => __('Home blocks of Featured Product', KC_DOMAIN),
            "params" => array(
                array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => __("Title", KC_DOMAIN),
                 "param_name" => "title",
                 "value" => __("Category Products",KC_DOMAIN),
                 "description" => __("Block title.",KC_DOMAIN)
                ),
                array(
                'type' => 'param_group',
                'heading' => __( 'Tabs Content', KC_DOMAIN ),
                'param_name' => 'list_tabs',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Title ', KC_DOMAIN ),
                        'param_name' => 'title_tab',
                        'description' => __( 'Enter title for tab.', KC_DOMAIN ),

                    ),
                    array(
                      "type" => "dropdown",
                      "heading" => __("Columns count", "js_composer"),
                      "param_name" => "columns_count",
                      "value" => array(6, 5, 4, 3, 2, 1),
                      "admin_label" => true,
                      "description" => __("Select columns count.", "js_composer")
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Select type product", "js_composer"),
                        "param_name" => "my_product_cat",
                        "description" => __("Select type product.", "js_composer"),
                        'value'     =>  [__('All Products',KC_DOMAIN)       =>'sale_products',
                                        __('Best Selling',KC_DOMAIN)        =>      'best_selling_products',
                                        __('Top Rated',KC_DOMAIN)           =>    'top_rated_products' ,
                                        __('New Products',KC_DOMAIN)        =>     'recent_products',
                                        __('Featured Proucts',KC_DOMAIN)    =>      'featured_products',
                                        ],
                    ),

                    array(
                     "type" => "textfield",
                     "holder" => "div",
                     "class" => "",
                     "heading" => __("Number items", "js_composer"),
                     "param_name" => "num_items",
                     "value" => "4",
                     "description" => __("Number of items in a tab.","js_composer")
                    ),
                 )
            )
        )
    )
);
add_shortcode( 'vc_featured_product','vc_featured_product_func');
if( !function_exists('vc_featured_product_func')){

    function vc_featured_product_func( $atts, $content = null ) { // New function parameter $content is added!
       global $makeclean_theme_option;
       extract( shortcode_atts( array(
          'title' => '',
          'list_tabs' => '',
       ), $atts ) );
    $tabs               =   vc_param_group_parse_atts($list_tabs);

    $output              =   '<div class="col-md-12 col-sm-11 ">';
    $output             .=   '<div class="product-category"> ';
    $output             .=   '<ul class="nav nav-tabs" role="tablist">';

    $active             =   'active';

    for($i=0;$i<count($tabs) ;$i++):
        if($i !=0) $active ='';

        $output         .=   '<li class="'.$active.'" role="presentation" ><a  href="#tab'.$i.'" aria-controls="tab'.$i.'" role="tab" data-toggle="tab">'.$tabs[$i]["title_tab"].' </a></li>';

    endfor;
    $output            .=   '</ul> </div>';

    $active             =   'in active';
    $output            .=   '  <div class="tab-content">';
    foreach($tabs as $key=> $tab):
        if($key !=0)    $active='';
        $output             .=   '<div role="tabpanel" class="tab-pane fade  '.$active.'" id="tab'.$key.'">';
        $output             .=   do_shortcode('['.$tab["my_product_cat"].' per_page="'.$tab["num_items"].'" columns="'.$tab["columns_count"].'"]' );
        $output             .=   '</div>';
    endforeach;
    $output             .=   '</div>';
    $output             .=   '</div>';

    return $output;


    }
}

vc_map( array(
       "name" => __("Blocks Category Product", KC_DOMAIN),
       "base" => "vc_categories_product",
        "wrapper_class" => "clearfix",
        "category" => __('Make clean', KC_DOMAIN),
        "description" => __('Home blocks of Category Product', KC_DOMAIN),
            "params" => array(
                array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => __("Title", KC_DOMAIN),
                 "param_name" => "title",
                 "value" => __("Category Products",KC_DOMAIN),
                 "description" => __("Block title.",KC_DOMAIN)
                ),
                array(
                  "type" => "dropdown",
                  "heading" => __("Columns count", "js_composer"),
                  "param_name" => "columns_count",
                  "value" => array(6, 5, 4, 3, 2, 1),
                  "admin_label" => true,
                  "description" => __("Select columns count.", "js_composer")
                ),
                array(
                    "type" => "my_wc_category",
                    "heading" => __("Select category", "js_composer"),
                    "param_name" => "my_product_cat",
                    "description" => __("Select category.", "js_composer")
                ),

                array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => __("Number items", "js_composer"),
                 "param_name" => "num_items",
                 "value" => "4",
                 "description" => __("Number of items in a carousel.","js_composer")
                ),

            )
        )
    );
add_shortcode( 'vc_categories_product','vc_categories_product_func');
if( !function_exists('vc_categories_product_func')){

    function vc_categories_product_func( $atts, $content = null ) { // New function parameter $content is added!
       global $makeclean_theme_option;
       extract( shortcode_atts( array(
          'title' => '',
          'columns_count' => '',
          'my_product_cat' => '',
          'num_items' => '',

       ), $atts ) );
      //  $taxonomy    = 'product_cat';
      // $orderby      = 'name';
      // $show_count   = 0;      // 1 for yes, 0 for no
      // $pad_counts   = 0;      // 1 for yes, 0 for no
      // $hierarchical = 1;      // 1 for yes, 0 for no
      // $title        = '';
      // $empty        = 0;

      // $args = array(
      //       'id'            =>$my_product_cat,
      //        'taxonomy'     => $taxonomy,
      //        'orderby'      => $orderby,
      //        'show_count'   => $show_count,
      //        'pad_counts'   => $pad_counts,
      //        'hierarchical' => $hierarchical,
      //        'title_li'     => $title,
      //        'hide_empty'   => $empty
      // );
      //   $all_categories = get_categories( $args );
        $term            =   get_term( $my_product_cat,'product_cat');
        $view_more      =   get_term_link($term ,'product_cat');
        if( empty($term))    return '';
        $slug           =   $term->slug;
        $output         ='';
        $output         .=  '<div class="col-md-12 col-sm-11">';
        $output         .=  '<div class="product-category">';
        $output         .=  '<h4>'.$title.'</h4> </div>';
        $output         .=  '<ul class="product-main row">';

        $output         .=  do_shortcode('[product_category category="'.$slug.'"]');

        $output         .=  '<a href="'.esc_url($view_more).'" class="btn">'.__('View More',KC_DOMAIN).'</a>';
        $output         .=  '</ul>';
        $output         .=  '</div>';

        return $output;
   }
}