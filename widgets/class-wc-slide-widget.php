<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
class WC_slide_widget extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        // widget actual processes
        parent::__construct(
                'widget_title',
                'WC Slide widget',
                ['description'=>'Slide widget in products page']
            );
        add_action('admin_enqueue_scripts', array($this, 'upload_scripts'));
    }
    public function upload_scripts()
    {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('upload_media_widget', get_stylesheet_directory_uri().'/assets/js/'. 'upload-img.js', array('jquery'));

        wp_enqueue_style('thickbox');
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        // outputs the content of the widget
         extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $before_widget;

        //In tiêu đề widget
        echo $before_title.$title.$after_title;

        // Nội dung trong widget
        if(isset($instance['image'])):
        echo '<a title="Add Banner" href="'.$instance['link'].'"><img src="'.$instance["image"].'" alt="add banner" /></a>';
        endif;
        // Kết thúc nội dung trong widget

        echo $after_widget;
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
         parent::form( $instance );

        //Biến tạo các giá trị mặc định trong form
        $defaults       =   [
            'title'     => 'Widget title',
            'image'     =>  'Widget image',
            'link'      =>  'Link your banner'
        ];
        //Gộp các giá trị trong mảng $default vào biến $instance để nó trở thành các giá trị mặc định
        $instance   =   wp_parse_args( $instance, $defaults );
        //Tạo biến riêng cho giá trị mặc định trong mảng $default
        $title      = esc_attr( $instance['title'] );
        $image      = esc_url($instance['image'] );
        $link       = esc_url($instance['link'] );

        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
            <input name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
            <input class="upload_image_button button button-primary" type="button" value="Upload Image" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'link' ); ?>"><?php _e( 'Link:' ,KC_DOMAIN); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_url( $link ); ?>" />
        </p>
    <?php
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
         parent::update( $new_instance, $old_instance );
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['image'] =     esc_url($new_instance['image'] );
        $instance['link'] =     esc_url($new_instance['link'] );

        return $instance;
    }

}