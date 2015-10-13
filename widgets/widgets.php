<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
add_action('widgets_init','makeclean_custom_widgets' );
 function makeclean_custom_widgets()
{

  register_widget('Footer_WP_Widget_Categories' );
  register_widget('Widget_form_footer' );
  register_widget('Custom_Search' );

    //woocommerce category
    if ( class_exists( 'WC_Widget_Product_Categories' ) ) {
    unregister_widget( 'WC_Widget_Product_Categories' );
    include_once( 'class-wc-widget-product-categories.php' );
    register_widget( 'Custom_WC_Widget_Product_Categories' );

  }

   if ( class_exists( 'WC_Widget_Price_Filter' ) ) {
    unregister_widget( 'WC_Widget_Price_Filter' );
    include_once( 'class-wc-widget-price-filter.php' );
    register_widget( 'Custom_WC_Widget_Price_Filter' );
  }
 if ( class_exists( 'WC_Widget_Product_Search' ) ) {
    unregister_widget( 'WC_Widget_Product_Search' );
    include_once( 'class-wc-widget-product-search.php' );
    register_widget( 'Custom_Widget_Product_Search' );
  }

  if(class_exists('WP_Widget_Recent_Posts')){
      unregister_widget('WP_Widget_Recent_Posts' );
    }
    register_widget('Custom_WP_Widget_Recent_Posts' );

    if(class_exists('WP_Widget_Categories')){
      unregister_widget('WP_Widget_Categories' );
    }
    register_widget('Custom_WP_Widget_Categories' );

    if(class_exists('WP_Widget_Search')){
      unregister_widget('WP_Widget_Search' );
    }


    register_widget('Custom_Gallery_Post' );

}


class Custom_WP_Widget_Recent_Posts extends WP_Widget {

  public function __construct() {
    $widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "Your site&#8217;s most recent Posts.") );
    parent::__construct('recent-posts', __('Makeclean Recent Posts'), $widget_ops);
    $this->alt_option_name = 'widget_recent_entries';
    add_action( 'save_post', array($this, 'flush_widget_cache') );
    add_action( 'deleted_post', array($this, 'flush_widget_cache') );
    add_action( 'switch_theme', array($this, 'flush_widget_cache') );
  }

  /**
   * @param array $args
   * @param array $instance
   */
  public function widget( $args, $instance ) {


    $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );

    /** This filter is documented in wp-includes/default-widgets.php */
    $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

    $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
    if ( ! $number )
      $number = 5;
    $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

    /**
     * Filter the arguments for the Recent Posts widget.
     *
     * @since 3.4.0
     *
     * @see WP_Query::get_posts()
     *
     * @param array $args An array of arguments used to retrieve the recent posts.
     */
    $r = new WP_Query( apply_filters( 'widget_posts_args', array(
      'posts_per_page'      => $number,
      'no_found_rows'       => true,
      'post_status'         => 'publish',
      'ignore_sticky_posts' => true
    ) ) );

    if ($r->have_posts()) :
?>
<aside class="widget widget_recent_post">
    <?php echo $args['before_widget']; ?>
    <?php if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    } ?>

    <?php while ( $r->have_posts() ) : $r->the_post(); ?>
      <div class="recent_post">
        <div class="col-md-8 col-sm-6 col-xs-7">
        <a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
      <?php if ( $show_date ) : ?>
        <span class="date"><?php echo get_the_date(); ?></span>
      <?php endif; ?>
        </div>
        <div class="col-md-4 col-sm-5 col-xs-5">
           <a title="Post Image" href="<?php the_permalink(); ?>">
           <?php  if(has_post_thumbnail(the_ID())):
                        echo get_the_post_thumbnail(the_ID(),'post-thumbnail' );
                    else:
                        echo '<img width="144" height="144" src="'.get_stylesheet_directory_uri().'/assets/images/no-thumbnail.png" />';
                    endif;
             ?>
           </a>
       </div>
      </div>
    <?php endwhile; ?>

    <?php echo $args['after_widget']; ?>
</aside>
<?php
    // Reset the global $the_post as this query will have stomped on it
    wp_reset_postdata();

    endif;

  }

  /**
   * @param array $new_instance
   * @param array $old_instance
   * @return array
   */
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['number'] = (int) $new_instance['number'];
    $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
    $this->flush_widget_cache();

    $alloptions = wp_cache_get( 'alloptions', 'options' );
    if ( isset($alloptions['widget_recent_entries']) )
      delete_option('widget_recent_entries');

    return $instance;
  }

  /**
   * @access public
   */
  public function flush_widget_cache() {
    wp_cache_delete('widget_recent_posts', 'widget');
  }

  /**
   * @param array $instance
   */
  public function form( $instance ) {
    $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
    $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
    $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
    <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

    <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
    <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

    <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
    <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
<?php
  }
}

class Custom_WP_Widget_Categories extends WP_Widget {

  public function __construct() {
    $widget_ops = array( 'classname' => 'widget_categories', 'description' => __( "A list or dropdown of categories." ) );
    parent::__construct('categories', __('Makeclean Categories'), $widget_ops);
  }

  /**
   * @staticvar bool $first_dropdown
   *
   * @param array $args
   * @param array $instance
   */
  public function widget( $args, $instance ) {
    static $first_dropdown = true;

    /** This filter is documented in wp-includes/default-widgets.php */
    $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Categories' ) : $instance['title'], $instance, $this->id_base );

    $c = ! empty( $instance['count'] ) ? '1' : '0';
    $h = ! empty( $instance['hierarchical'] ) ? '1' : '0';
    $d = ! empty( $instance['dropdown'] ) ? '1' : '0';
    echo '<aside class="widget widget_category">';
    //echo $args['before_widget'];
    if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }

    $cat_args = array(
      'orderby'      => 'name',
      'show_count'   => $c,
      'hierarchical' => $h
    );

    if ( $d ) {
      $dropdown_id = ( $first_dropdown ) ? 'cat' : "{$this->id_base}-dropdown-{$this->number}";
      $first_dropdown = false;

      echo '<label class="screen-reader-text" for="' . esc_attr( $dropdown_id ) . '">' . $title . '</label>';

      $cat_args['show_option_none'] = __( 'Select Category' );
      $cat_args['id'] = $dropdown_id;

      /**
       * Filter the arguments for the Categories widget drop-down.
       *
       * @since 2.8.0
       *
       * @see wp_dropdown_categories()
       *
       * @param array $cat_args An array of Categories widget drop-down arguments.
       */
      wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $cat_args ) );
?>

<script type='text/javascript'>
/* <![CDATA[ */
(function() {
  var dropdown = document.getElementById( "<?php echo esc_js( $dropdown_id ); ?>" );
  function onCatChange() {
    if ( dropdown.options[ dropdown.selectedIndex ].value > 0 ) {
      location.href = "<?php echo home_url(); ?>/?cat=" + dropdown.options[ dropdown.selectedIndex ].value;
    }
  }
  dropdown.onchange = onCatChange;
})();
/* ]]> */
</script>

<?php
    } else {
?>
    <ul>
<?php
    $cat_args['title_li'] = '';

    /**
     * Filter the arguments for the Categories widget.
     *
     * @since 2.8.0
     *
     * @param array $cat_args An array of Categories widget options.
     */
    wp_list_categories( apply_filters( 'widget_categories_args', $cat_args ) );
?>
    </ul>
<?php
    }

   // echo $args['after_widget'];
    echo '</div>';
  }

  /**
   * @param array $new_instance
   * @param array $old_instance
   * @return array
   */
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['count'] = !empty($new_instance['count']) ? 1 : 0;
    $instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
    $instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;

    return $instance;
  }

  /**
   * @param array $instance
   */
  public function form( $instance ) {
    //Defaults
    $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
    $title = esc_attr( $instance['title'] );
    $count = isset($instance['count']) ? (bool) $instance['count'] :false;
    $hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
    $dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

    <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
    <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Display as dropdown' ); ?></label><br />

    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
    <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label><br />

    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
    <label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy' ); ?></label></p>
<?php
  }

}

class Custom_Search extends WP_Widget {

  public function __construct() {
    $widget_ops = array('classname' => 'widget_search', 'description' => __( "A search form for your site.") );
    parent::__construct( 'search', _x( 'Search', 'Search widget' ), $widget_ops );
  }

  /**
   * @param array $args
   * @param array $instance
   */
  public function widget( $args, $instance ) {
    /** This filter is documented in wp-includes/default-widgets.php */
    $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

    echo $args['before_widget'];
    if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }

    // Use current theme search form if it exists
    get_search_form();

    echo $args['after_widget'];
  }

  /**
   * @param array $instance
   */
  public function form( $instance ) {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
    $title = $instance['title'];
?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
  }

  /**
   * @param array $new_instance
   * @param array $old_instance
   * @return array
   */
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }

}

class Custom_Gallery_Post extends WP_Widget{
  public function __construct() {
    $widget_ops = array('classname' => 'widget_gallery', 'description' => __( "Gallery post.") );
    parent::__construct( 'search', _x( 'Makeclean Gallery post', KC_DOMAIN ), $widget_ops );
  }
  public function form( $instance){
     $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
     $title = $instance['title'];
    ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
    <?php
  }

  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }

  public function widget( $args, $instance ) {
    /** This filter is documented in wp-includes/default-widgets.php */
    $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
    echo '<aside class="widget widget_gallery">';
  //  echo $args['before_widget'];
    if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }
    // Use current theme search form if it exists
    ?>
    <ul>
      <?php if ( $gallery = get_post_gallery( get_the_ID(), false ) ) : ?>
          <?php foreach ( $gallery['src'] AS $src ) : ?>
          <li><a title="Images Gallery" href="#"><img src="<?=$src?>" alt="gallery-1" class="gallery-post" /></a></li>
          <?php endforeach; ?>
      <?php endif; ?>

    </ul>
    <?php

   // echo $args['after_widget'];
    echo '</aside>';
  }
}




class Footer_WP_Widget_Categories extends WP_Widget {

  public function __construct() {
    $widget_ops = array( 'classname' => 'widget_categories_footer', 'description' => __( "A list or dropdown of categories." ) );
    parent::__construct('categories_footer', __('Footer Categories'), $widget_ops);
  }

  /**
   * @staticvar bool $first_dropdown
   *
   * @param array $args
   * @param array $instance
   */
  public function widget( $args, $instance ) {
    static $first_dropdown = true;

    /** This filter is documented in wp-includes/default-widgets.php */
    $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Categories' ) : $instance['title'], $instance, $this->id_base );

    $c = ! empty( $instance['count'] ) ? '1' : '0';
    $h = ! empty( $instance['hierarchical'] ) ? '1' : '0';
    $d = ! empty( $instance['dropdown'] ) ? '1' : '0';
    //echo '<aside class="col-md-3 col-sm-3 widget widget-link">';
   echo $args['before_widget'];
    if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }

    $cat_args = array(
      'orderby'      => 'name',
      'show_count'   => $c,
      'hierarchical' => $h
    );

    if ( $d ) {
      $dropdown_id = ( $first_dropdown ) ? 'cat' : "{$this->id_base}-dropdown-{$this->number}";
      $first_dropdown = false;

      echo '<label class="screen-reader-text" for="' . esc_attr( $dropdown_id ) . '">' . $title . '</label>';

      $cat_args['show_option_none'] = __( 'Select Category' );
      $cat_args['id'] = $dropdown_id;

      /**
       * Filter the arguments for the Categories widget drop-down.
       *
       * @since 2.8.0
       *
       * @see wp_dropdown_categories()
       *
       * @param array $cat_args An array of Categories widget drop-down arguments.
       */
      wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $cat_args ) );
?>

<script type='text/javascript'>
/* <![CDATA[ */
(function() {
  var dropdown = document.getElementById( "<?php echo esc_js( $dropdown_id ); ?>" );
  function onCatChange() {
    if ( dropdown.options[ dropdown.selectedIndex ].value > 0 ) {
      location.href = "<?php echo home_url(); ?>/?cat=" + dropdown.options[ dropdown.selectedIndex ].value;
    }
  }
  dropdown.onchange = onCatChange;
})();
/* ]]> */
</script>

<?php
    } else {
?>
    <ul>
<?php
    $cat_args['title_li'] = '';

    /**
     * Filter the arguments for the Categories widget.
     *
     * @since 2.8.0
     *
     * @param array $cat_args An array of Categories widget options.
     */
    wp_list_categories( apply_filters( 'widget_categories_args', $cat_args ) );
?>
    </ul>
<?php
    }

    echo $args['after_widget'];

  }

  /**
   * @param array $new_instance
   * @param array $old_instance
   * @return array
   */
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['count'] = !empty($new_instance['count']) ? 1 : 0;
    $instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
    $instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;

    return $instance;
  }

  /**
   * @param array $instance
   */
  public function form( $instance ) {
    //Defaults
    $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
    $title = esc_attr( $instance['title'] );
    $count = isset($instance['count']) ? (bool) $instance['count'] :false;
    $hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
    $dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

    <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
    <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Display as dropdown' ); ?></label><br />

    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
    <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label><br />

    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
    <label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy' ); ?></label></p>
<?php
  }

}



class Widget_form_footer extends WP_Widget {

  public function __construct() {
    $widget_ops = array( 'classname' => 'widget_form_footer', 'description' => __( "A list or dropdown of categories." ) );
    parent::__construct('form_footer', __('Makeclean Form Footer'), $widget_ops);
  }

  /**
   * @staticvar bool $first_dropdown
   *
   * @param array $args
   * @param array $instance
   */
  public function widget( $args, $instance ) {
    static $first_dropdown = true;

    /** This filter is documented in wp-includes/default-widgets.php */
    $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Categories' ) : $instance['title'], $instance, $this->id_base );



     echo $args['before_widget'];
    if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }
    $shortcode    = ($instance['shortcode']) ? $instance['shortcode'] :'';

      echo do_shortcode($shortcode );

    echo $args['after_widget'];

  }

  /**
   * @param array $new_instance
   * @param array $old_instance
   * @return array
   */
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['shortcode'] = !empty($new_instance['shortcode']) ? $new_instance['shortcode'] : '';


    return $instance;
  }

  /**
   * @param array $instance
   */
  public function form( $instance ) {
    //Defaults
    $instance = wp_parse_args( (array) $instance, array( 'title' => '','shortcode'=>'') );
    $title = esc_attr( $instance['title'] );
    $shortcode = esc_attr( $instance['shortcode'] );


?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
 <p><label for="<?php echo $this->get_field_id('shortcode'); ?>"><?php _e( 'Shortcode Contact form 7:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('shortcode'); ?>" name="<?php echo $this->get_field_name('shortcode'); ?>" type="text" value="<?php echo $shortcode; ?>" /></p>

<?php
  }

}