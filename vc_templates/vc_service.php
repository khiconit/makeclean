<?php
$output     =   '';
     extract( shortcode_atts( array(
      'title'                      =>   '',
      'head_icon'                  =>  '',
      'count_word'                 =>  '',
      'count_items'                =>  '',
      'select_categories'          =>  '',
      'button_title'               =>  '',
      'size'                       =>   ''
   ), $atts ) );
    $array_size         =   ['thumbnail','medium','large','full '];
    if(!in_array($size,$array_size )){
        $size   =   'thumbnail' ;
    }
    $output     .=  '<section id="service-section" class="service-section ow-section">';
    $output     .=  '<div class="container"><div class="section-header">';
    $output     .=  '<h3><img src="'.wp_get_attachment_url($head_icon).'" alt="sep-icon" /> '.$title.'</h3></div> ';
    $output     .=  '<div id="make-clean-service" class="owl-carousel owl-theme services-style2">';
    if((is_numeric($select_categories)) && ($select_categories >=0)){
        if( !is_numeric($count_items)) $count_items=0;
            $list_post      =   get_posts(['category'=>$select_categories,'posts_per_page'=>$count_items] );
            foreach( $list_post as $post):setup_postdata( $post );
                $content       =   get_the_content( );

                $output         .=  '<div class="item">';
                $output         .=  '<div class="service-box">';
                $output         .=  get_the_post_thumbnail($post->ID,$size);
                $output         .=  '<div class="service-box-inner">';
                $output         .=   '<h4>'.get_the_title( ).'</h4>';
                $output         .=   '<p>'.the_excerpt_max_charlength($content,$count_word).'</p>';
                $output         .=   '<a title="'.$button_title.'" href="'.post_permalink( $post->ID ).'">view details</a>';
                $output         .=    '</div></div></div>';
            endforeach;
    }

    $output                 .=  '</div></div> </div> ';
    $output                 .=  '</section>';
    echo                   $output;

 ?>