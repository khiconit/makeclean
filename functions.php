<?php

define('KC_DOMAIN','makeclean');
define('CORE',dirname(__FILE__).'/core');
define('THEME_URL',get_stylesheet_directory_uri());
define('SHOP_PATH',get_stylesheet_directory().'/woocommerce');
require( CORE. '/init.php');
require( dirname(__FILE__). '/widgets/widgets.php');
if( !isset($content_width)){
    $content_width  =   620;
}
/**
    @embed file /core/init.php
**/
require_once(CORE . "/init.php");
if( !function_exists('author_link')){
    function author_link(){
        global $authordata;
        if ( ! is_object( $authordata ) ) {
                return;
        }

        return  $link = sprintf(
                '<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
                esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ),
                 esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ),
                get_the_author()
        );
    }
}
if( !function_exists('makeclean_theme_setup')){
    function makeclean_theme_setup(){
        $languages_folder           =       THEME_URL. '/languages';
        load_theme_textdomain( KC_DOMAIN, $languages_folder );

        /* Tự động thêm link rss lên <head>*/
        add_theme_support( 'automatic-feed-links' );

        /* Them post thumbnail để hiển thị ảnh đại diện bài viết*/
        add_theme_support('post-thumbnail' );

        add_theme_support('post-formats', ['image','video','gallery']);

        add_theme_support('title-tag' );
        /* custom background */

        add_theme_support('custom-background',['default-color'=>'#f8f8f8'] );
        set_post_thumbnail_size( 114, 114,true );
        register_nav_menus(['main_menu' => __('Main Menu',KC_DOMAIN),'bottom_menu' => __('Footer Menu',KC_DOMAIN),'top-menu'=>__('Top Menu',KC_DOMAIN) ]);

         $sidebar    =   [
            'name'              =>  __('Main Sidebar', KC_DOMAIN),
            'id'                =>  'main-sidebar',
            'description'       =>  __('Default sidebar',KC_DOMAIN),
            'class'             =>  'main-sidebar',
            'before_title'      =>  '<h3 class="widget-title">',
            'after_title'       =>  '</h3>'
        ];
        register_sidebar($sidebar );
        $sidebar    =   [
            'name'              =>  __('Woocommerce Sidebar', KC_DOMAIN),
            'id'                =>  'woo-sidebar',
            'before_widget'     => ' <aside id="%1$s" class="widget widget_search  %2$s" >',
            'after_widget'      => '</aside>',
            'description'       =>  __('Woocommerce sidebar',KC_DOMAIN),
            'class'             =>  'woo-sidebar',
            'before_title'      =>  '<h3 class="widget_title">',
            'after_title'       =>  '</h3>'
        ];
        register_sidebar($sidebar );
           /**
            * Creates a sidebar
            * @param string|array  Builds Sidebar based off of 'name' and 'id' values.
            */
            $args = array(
                'name'          => __( 'Footer link 1', KC_DOMAIN ),
                'id'            => 'footer-link-1',
                'description'   => '',
                'class'         => '',
                'before_widget' => '<aside id="%1$s" class="%2$s col-md-3 col-sm-3 widget widget-link">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widget_title">',
                'after_title'   => '</h3>'
            );

            register_sidebar( $args );
            $args = array(
                'name'          => __( 'Footer link 2', KC_DOMAIN ),
                'id'            => 'footer-link-2',
                'description'   => '',
                'class'         => '',
                'before_widget' => '<aside id="%1$s" class="%2$s col-md-3 col-sm-3 widget widget-link">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widget_title">',
                'after_title'   => '</h3>'
            );

            register_sidebar( $args );
            $args = array(
                'name'          => __( 'Footer link 3', KC_DOMAIN ),
                'id'            => 'footer-link-3',
                'description'   => '',
                'class'         => '',
                'before_widget' => '<aside id="%1$s" class="%2$s col-md-2 col-sm-2 widget widget-link">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widget_title">',
                'after_title'   => '</h3>'
            );

            register_sidebar( $args );
            $args = array(
                'name'          => __( 'Footer Form', KC_DOMAIN ),
                'id'            => 'footer-form',
                'description'   => '',
                'class'         => '',
                'before_widget' => '<aside id="%1$s" class="%2$s ol-md-4 col-sm-4 widget widget-calculator">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widget_title">',
                'after_title'   => '</h3>'
            );

            register_sidebar( $args );
    }
    add_action('init','makeclean_theme_setup' );




}


if ( !function_exists('makeclean_logo')){
    function makeclean_logo(){
          global $makeclean_theme_option;
          if( $makeclean_theme_option['logo-on']  ==0 ): ?>
           <div class="col-md-3 col-sm-4">
                <?php
                    printf( '<h1> <a href="%1$s" title="%2$s"> %3$s  </a></h1> ',esc_url( get_home_url() ),get_bloginfo('description' ), $makeclean_theme_option['text-logo'])  ;
                ?>
            </div>
        <?php else: ?>
                    <div class="col-md-3 col-sm-4">
                        <a title="<?php bloginfo('description' ); ?>" href="<?php esc_url(get_home_url() ) ?>"><img src="<?php echo $makeclean_theme_option['logo-image']['url']  ?>" alt="<?php bloginfo('description' ); ?>" /></a>
                    </div>
        <?php endif; ?>


    <?php

    }
}
if ( !function_exists('makeclean_logo_response')){
    function makeclean_logo_response(){
         global $makeclean_theme_option;
        printf('<a  href="%1$s"><img  src="%2$s"></a>',home_url() ,$makeclean_theme_option['logo-image-mobile']['url'] );
    }
}


if(in_array('js_composer/js_composer.php',apply_filters('active_plugins',get_option('active_plugins' ) ))){
        require( CORE. '/visual_composer.php');
    }
if( !function_exists('makeclean_contact_phone')){
    function makeclean_contact_phone(){
        global  $makeclean_theme_option;

        printf('<p> %1$s<span>%2$s</span></p>', $makeclean_theme_option['text-contact-phone'], $makeclean_theme_option['contact-phone']);
    }
}

if( !function_exists('makeclean_main_menu')){
    function makeclean_main_menu($menu){
           /**
            * Displays a navigation menu
            * @param array $args Arguments
            */
            $args = array(
                'theme_location' => $menu,
                'container' => 'div',
                'container_class' => 'collapse navbar-collapse',
                'container_id' => 'bs-example-navbar-collapse-1',
                'menu_class' => 'nav navbar-nav',
                'menu_id' => '',
                'items_wrap' => '<ul idx = "%1$s" id="test-menu" class = "%2$s">%3$s</ul>',

                'walker'          => new Makeclean_Walker_menu(),
            );

            wp_nav_menu( $args );
    }
}

if( !function_exists('makeclean_theme_head')){
    function makeclean_theme_head(){ ?>


        <div class="site-name">
            <?php
                global $makeclean_theme_option;
                if ( $makeclean_theme_option['logo-on'] ==0):
             ?>
                <?php
                if(is_home()):
                     printf( '<h1> <a href="%1$s" title="%2$s"> %3$s  </a></h1> ',home_url(),get_bloginfo('description' ),get_bloginfo('sitename' ))  ;
                else:
                     printf( '<p> <a href="%1$s" title="%2$s"> %3$s  </a></p> ',home_url(),get_bloginfo('description' ),get_bloginfo('sitename' ))  ;
                endif;
            ?>
            <?php
            else:

             ?>
            <a href="/"> <img src="<?php echo  $makeclean_theme_option['logo-image']['url'] ?>" alt=""></a>
        <?php  endif; ?>
        </div>
        <div class="site-description"><?php bloginfo('description' ); ?></div>
        <?php
    }
}

if( !function_exists('makeclean_stylesheet')){
    function makeclean_stylesheet(){
        wp_register_style('bootstrap',get_template_directory_uri().'/assets/libraries/bootstrap/bootstrap.min.css'  );
        wp_enqueue_style('bootstrap' );
        wp_register_style('jquery-ui',get_template_directory_uri().'/assets/libraries/fuelux/jquery-ui.min.css' );
        wp_enqueue_style( 'jquery-ui' );
        wp_register_style('carousel',get_template_directory_uri().'/assets/libraries/owl-carousel/owl.carousel.css' );
        wp_enqueue_style('carousel');

        wp_register_style('owl-carousel',get_template_directory_uri().'/assets/libraries/owl-carousel/owl.theme.css' );
        wp_enqueue_style('owl-carousel' );
        wp_register_style('font-awesome',get_template_directory_uri().'/assets/libraries/fonts/font-awesome.min.css' );
        wp_enqueue_style('font-awesome' );

        wp_register_style('animate',get_template_directory_uri().'/assets/libraries/animate/animate.min.css' );
        wp_enqueue_style('animate' );
        wp_register_style('flexslider',get_template_directory_uri().'/assets/libraries/flexslider/flexslider.css' );
        wp_enqueue_style('flexslider' );
        wp_register_style('font-awesome',get_template_directory_uri().'/assets/libraries/fonts/font-awesome.min.css' );
        wp_enqueue_style('font-awesome' );
        wp_register_style('magnific-popup',get_template_directory_uri().'/assets/libraries/magnific-popup.css' );
        wp_enqueue_style('magnific-popup' );
        wp_register_style('components',get_template_directory_uri().'/assets/css/components.css' );
        wp_enqueue_style('components' );
        wp_register_style('main-style',get_template_directory_uri().'/style.css' );
        wp_enqueue_style('main-style');
        wp_register_style( 'media-style', get_template_directory_uri().'/assets/css/media.css');
        wp_enqueue_style('media-style');

       /* Script*/

        wp_register_script('jquery-easing',get_template_directory_uri().'/assets/libraries/jquery.easing.min.js',['jquery'],'1.0',true );
        wp_enqueue_script( 'jquery-easing' );

        wp_register_script( 'js-bootstrap',get_template_directory_uri().'/assets/libraries/bootstrap/bootstrap.min.js',['jquery'],'1.0',true);
        wp_enqueue_script('js-bootstrap' );
        wp_register_script('owl-carousel-js',get_template_directory_uri().'/assets/libraries/owl-carousel/owl.carousel.min.js',['jquery'],'1.0',true );
        wp_enqueue_script( 'owl-carousel-js' );
        wp_register_script('fuelux',get_template_directory_uri().'/assets/libraries/fuelux/jquery-ui.min.js',['jquery'],'1.0',true );
        wp_enqueue_script( 'fuelux' );

        wp_register_script('jquery-quicksand',get_template_directory_uri().'/assets/libraries/portfolio-filter/jquery.quicksand.js',['jquery'],'1.0',true );
        wp_enqueue_script( 'jquery-quicksand' );
        wp_register_script('modernizr',get_template_directory_uri().'/assets/libraries/expanding-search/modernizr.custom.js',['jquery'],'1.0',true );
        wp_enqueue_script( 'modernizr' );
        wp_register_script('flexslider',get_template_directory_uri().'/assets/libraries/flexslider/jquery.flexslider-min.js',['jquery'],'1.0',true );
        wp_enqueue_script( 'flexslider' );
        wp_register_script('magnific-popup',get_template_directory_uri().'/assets/libraries/jquery.magnific-popup.min.js',['jquery'],'1.0',true );
        wp_enqueue_script( 'magnific-popup' );
        wp_register_script('classie',get_template_directory_uri().'/assets/libraries/expanding-search/classie.js',['jquery'],'1.0',true );
        wp_enqueue_script( 'classie' );
        wp_register_script('wow',get_template_directory_uri().'/assets/libraries/wow.min.js',[],'4.3.1',true);
        wp_enqueue_script( 'wow' );
        wp_register_script('knob',get_template_directory_uri().'/assets/libraries/jquery.knob.js',['jquery'],'1.0',true );
        wp_enqueue_script( 'knob' );
        wp_register_script('appear',get_template_directory_uri().'/assets/libraries/jquery.appear.js',['jquery'],'1.0',true );
        wp_enqueue_script( 'appear' );
        wp_register_script('animateNumber',get_template_directory_uri().'/assets/libraries/jquery.animateNumber.min.js',['jquery'],'1.0',true );
        wp_enqueue_script( 'animateNumber' );

        wp_register_script('googlemap','http://maps.google.com/maps/api/js?sensor=false',['jquery'],'1.0',true );
        wp_enqueue_script( 'googlemap' );
        wp_register_script('gmap',get_template_directory_uri().'/assets/libraries/gmap/jquery.gmap.min.js',['jquery'],'1.0',true );
        wp_enqueue_script( 'gmap' );
        wp_register_script('functions',get_template_directory_uri().'/assets/js/functions.js',['jquery'],'1.0',true );
        wp_enqueue_script( 'functions' );




  }

add_action('wp_enqueue_scripts','makeclean_stylesheet' );

}


class Makeclean_Walker_menu extends Walker_Nav_Menu {
    private $curItem;
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\" role=\"menu\">\n";
    }
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'dropdown-toggle menu-item-' . $item->ID;

        /**
         * Filter the CSS class(es) applied to a menu item's list item element.
         *
         * @since 3.0.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        /**
         * Filter the ID applied to a menu item's list item element.
         *
         * @since 3.0.1
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        /**
         * Filter the HTML attributes applied to a menu item's anchor element.
         *
         * @since 3.6.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         *     @type string $title  Title attribute.
         *     @type string $target Target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param object $item  The current menu item.
         * @param array  $args  An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth Depth of menu item. Used for padding.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        /** This filter is documented in wp-includes/post-template.php */
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        /**
         * Filter a menu item's starting output.
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since 3.0.0
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item        Menu item data object.
         * @param int    $depth       Depth of menu item. Used for padding.
         * @param array  $args        An array of {@see wp_nav_menu()} arguments.
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
        $element->is_dropdown = !empty($children_elements[$element->ID]);
        if ($element->is_dropdown) {
          if ($depth === 0) {
            $element->classes[] = '';
          } elseif ($depth === 1) {
            $element->classes[] = '';
          }
        }
        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
      }
}
if( !function_exists('makeclean_favicon')){
    function makeclean_favicon(){
        global $makeclean_theme_option;
        if((isset($makeclean_theme_option['favicon'])) && (!empty($makeclean_theme_option['favicon']))){
            printf('<link rel="shortcut icon" href="%1$s">',$makeclean_theme_option['favicon']['url']);
        }else{
            printf('<link rel="shortcut icon" href="%1$s">',get_stylesheet_directory_uri().'/assets/images/favicon.png');
        }
    }
}

if( !function_exists('makeclean_thumbnail')){
    function makeclean_thumbnail($size){
        if(!is_single( ) && has_post_thumbnail( ) && !post_password_required( ) || has_post_format( )):?>
            <figure class="post-thumbnail"><?php the_post_thumbnail($size );  ?></figure>

            <?php
            endif;
    }
}
if ( ! function_exists( 'the_excerpt_max_charlength' ) ) {
    function the_excerpt_max_charlength($text='',$limit=20){
        $text = get_the_excerpt();
        $explode = explode(' ',$text);
        $string  = '';
        $dots = '...';
        if(count($explode) <= $limit){
            $dots = '';
            $string .= $text;
        } else {
            for($i=0;$i<$limit;$i++){
                $string .= $explode[$i]." ";
            }
        }
        return  $string.$dots;
    }
}
if ( ! function_exists( 'makeclean_content_entry' ) ) {
    function makeclean_content_entry($limit=20){
        $text = get_the_excerpt();
        $explode = explode(' ',$text);
        $string  = '';
        $dots = '...';
        if(count($explode) <= $limit){
            $dots = '';
            $string .= $text;
        } else {
            for($i=0;$i<$limit;$i++){
                $string .= $explode[$i]." ";
            }
        }
        return  $string.$dots;
    }
}
// if( !function_exists('get_the_post_thumbnail')){
//     function get_the_post_thumbnail( $post_id = null, $size = 'post-thumbnail', $attr = '' ) {
//     $post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
//     $post_thumbnail_id = get_post_thumbnail_id( $post_id );

//     /**
//      * Filter the post thumbnail size.
//      *
//      * @since 2.9.0
//      *
//      * @param string $size The post thumbnail size.
//      */
//     $size = apply_filters( 'post_thumbnail_size', $size );

//     if ( $post_thumbnail_id ) {

//         /**
//          * Fires before fetching the post thumbnail HTML.
//          *
//          * Provides "just in time" filtering of all filters in wp_get_attachment_image().
//          *
//          * @since 2.9.0
//          *
//          * @param string $post_id           The post ID.
//          * @param string $post_thumbnail_id The post thumbnail ID.
//          * @param string $size              The post thumbnail size.
//          */
//         do_action( 'begin_fetch_post_thumbnail_html', $post_id, $post_thumbnail_id, $size );
//         if ( in_the_loop() )
//             update_post_thumbnail_cache();
//         $html = wp_get_attachment_url( $post_thumbnail_id, $size, false, $attr );

//         /**
//          * Fires after fetching the post thumbnail HTML.
//          *
//          * @since 2.9.0
//          *
//          * @param string $post_id           The post ID.
//          * @param string $post_thumbnail_id The post thumbnail ID.
//          * @param string $size              The post thumbnail size.
//          */
//         do_action( 'end_fetch_post_thumbnail_html', $post_id, $post_thumbnail_id, $size );

//     } else {
//         $html = '';
//     }
//     /**
//      * Filter the post thumbnail HTML.
//      *
//      * @since 2.9.0
//      *
//      * @param string $html              The post thumbnail HTML.
//      * @param string $post_id           The post ID.
//      * @param string $post_thumbnail_id The post thumbnail ID.
//      * @param string $size              The post thumbnail size.
//      * @param string $attr              Query string of attributes.
//      */
//     return apply_filters( 'post_thumbnail_html', $html, $post_id, $post_thumbnail_id, $size, $attr );
// }
// }
if ( !function_exists('makeclean_copyright')){
    function makeclean_copyright(){
        global $makeclean_theme_option;
        if(isset($makeclean_theme_option['copyright_footer'])){
            echo  $makeclean_theme_option['copyright_footer'];
        }else{
            _e('<p>Copyright@2015 By Khi Con KC_DOMAIN</p>',KC_DOMAIN);
        }
    }
}
if( !function_exists('text_footer')){
    function text_footer(){
        global $makeclean_theme_option;
        if(isset($makeclean_theme_option['text-footer'])){
            echo $makeclean_theme_option['text-footer'];
        }else{
            _e('<h5>HAVE ANY QUESTIONS OR WANT A FREE ESTIMATE? </h5> <h3> CALL NOW: +(01) 800 527 4800</h3>',KC_DOMAIN);
        }
    }
}
if( !function_exists('makeclean_archive_layout')){
    function makeclean_archive_layout(){
        global $makeclean_theme_option;
        $layout ='8';
        if( isset( $makeclean_theme_option['sidebar-archive'])):
                if(0 == $makeclean_theme_option['sidebar-archive']  ) return 12;
        endif;
        return $layout;
    }
}
if ( !function_exists('makeclean_theme_pagination')){
    function makeclean_theme_pagination(){
        if ( $GLOBALS['wp_query']->max_num_pages  <2){
            return '';
        } ?>
        <nav id="pagination" role="navigation">
            <?php  if(get_next_post_link( )): ?>
            <div class="prev">  <?php next_posts_link( __('Older Posts', KC_DOMAIN));  ?> </div>
            <?php  endif; ?>
            <?php if(get_previous_posts_link(  )): ?>

        <div class="next"> <?php  previous_posts_link( __('Newest Post' , KC_DOMAIN) ); ?></div>
            <?php endif; ?>

        </nav>

        <?php



    }

}

if ( ! function_exists( 'makeclean_archive_pagination' ) ) {
    function makeclean_archive_pagination() {
        global $wp_query;
        $big = get_option('posts_per_page');
        echo '<div class="page_nav">';
        echo paginate_links( array(
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages
        ) );
        echo '</div>';
    }
}
if ( !function_exists('makeclean_theme_readmore')){
    function makeclean_theme_readmore(){
        return '<a class="read-more" href="'.get_permalink(get_the_ID() ).'"> ...</a>';

}
}
add_filter('excerpt_more' ,'makeclean_theme_readmore');


if( !function_exists('breabcrum_display')){
    function breadcrum(){
        global $makeclean_theme_option;
        if( (isset($makeclean_theme_option['breadcrumb-shop']) ) &&  ($makeclean_theme_option['breadcrumb-shop']==1))return true;

        return false;
    }
}
if( !function_exists('custom_product_archive_description')){
function custom_product_archive_description() {
    global $makeclean_theme_option;
    if ( is_post_type_archive( 'product' ) && get_query_var( 'paged' ) == 0 ) {
        $shop_page   = get_post( wc_get_page_id( 'shop' ) );
        if ( $shop_page ) {
            $description = wc_format_content( $shop_page->post_content );
            if ( $description ) {

                echo '<div class="page-description col-md-9 col-sm-8">' . $description . '</div> ';
            }
        }
    }
    }
}
add_action('custom_archive_description','custom_product_archive_description' );


if(!function_exists('custom_css_classes_for_vc_row_and_vc_column')){
    function custom_css_classes_for_vc_row_and_vc_column( $class_string, $tag ) {
      if ( $tag == 'vc_row' || $tag == 'vc_row_inner' ) {
        $class_string = str_replace( 'vc_row-fluid', 'my_row-fluid col-md-12 col-sm-11', $class_string ); // This will replace "vc_row-fluid" with "my_row-fluid"
      }
      if ( $tag == 'vc_column' || $tag == 'vc_column_inner' ) {
        $class_string = preg_replace( '/vc_col-sm-(\d{1,2})/', 'my_col-sm-9', $class_string ); // This will replace "vc_col-sm-%" with "my_col-sm-%"
      }
      return $class_string; // Important: you should always return modified or original $class_string
    }
}

if(!function_exists('get_curent_cat_name')){
    function get_curent_cat_name(){
        global $wp_query;
// get the query object
$cat_obj = $wp_query->get_queried_object();

print_r($cat_obj);

if($cat_obj)    {
    $category_name = $cat_obj->name;
    $category_desc = $cat_obj->description;
    $category_ID  = $cat_obj->term_id;
}
    }
}
add_action('init' ,'get_curent_cat_name');


if(!function_exists('contact_from_modal')){
    function contact_from_modal(){
        global $makeclean_theme_option;
     if( (isset($makeclean_theme_option['popup-contact'])) && ( $makeclean_theme_option['popup-contact'] !="")) :?>
        <div class="modal fade" id="contact-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php _e('Contact form',KC_DOMAIN) ?></h4>
                </div>
                <div class="modal-body">
                    <?php echo (do_shortcode($makeclean_theme_option['popup-contact'] )); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close',KC_DOMAIN)?></button>

                </div>
            </div>
        </div>
    </div>

    <?php

        endif;

    }
}
if( !function_exists('makeclean_cart_quantity')){
    function makeclean_cart_quantity($args = array(), $product = null, $echo = true){
        if ( is_null( $product ) )
            $product = $GLOBALS['product'];

        $defaults = array(
            'input_name'    => 'quantity',
            'input_value'   => '1',
            'max_value'     => apply_filters( 'woocommerce_quantity_input_max', '', $product ),
            'min_value'     => apply_filters( 'woocommerce_quantity_input_min', '', $product ),
            'step'          => apply_filters( 'woocommerce_quantity_input_step', '1', $product )
        );

        $args = apply_filters( 'woocommerce_quantity_input_args', wp_parse_args( $args, $defaults ), $product );


        ?>
    <input type="number" step="<?php echo esc_attr( $args["step"] ); ?>" <?php if ( is_numeric( $args["min_value"] ) ) : ?>min="<?php echo esc_attr( $args["min_value"] ); ?>"<?php endif; ?> <?php if ( is_numeric( $args["max_value"] ) ) : ?>max="<?php echo esc_attr( $args["max_value"] ); ?>"<?php endif; ?> name="<?php echo esc_attr( $args["input_name"] ); ?>" value="<?php echo esc_attr( $args["input_value"] ); ?>" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="qty btn" size="4" />

<?php    }
}


if(!function_exists('left_sticker')){
    function left_sticker(){
        global $makeclean_theme_option;
        if(isset($makeclean_theme_option['left-sticker'])){
            echo $makeclean_theme_option['left-sticker'];
        }
    }
}
if(!function_exists('right_sticker')){
    function right_sticker(){
        global $makeclean_theme_option;
        if(isset($makeclean_theme_option['right-sticker'])){
            echo $makeclean_theme_option['right-sticker'];
        }
    }
}
if(!function_exists('custom_comment_form')){
    function custom_comment_form(){
        $commenter = wp_get_current_commenter();
        $req = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $fields =  array(

          'author' =>
            '<p class="comment-form-author"><label for="author">' . __( 'Name', 'domainreference' ) . '</label> ' .
            ( $req ? '<span class="required">*</span>' : '' ) .
            '<input id="author" name="author"  class="form-control" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
            '" size="30"' . $aria_req . ' /></p>',

          'email' =>
            '<p class="comment-form-email"><label for="email">' . __( 'Email', 'domainreference' ) . '</label> ' .
            ( $req ? '<span class="required">*</span>' : '' ) .
            '<input id="email" name="email" class="form-control" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
            '" size="30"' . $aria_req . ' /></p>',

          'url' =>
            '<p class="comment-form-url"><label for="url">' . __( 'Website', 'domainreference' ) . '</label>' .
            '<input id="url" name="url" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
            '" size="30" /></p>',
        );
        $post_id = get_the_ID();
        $user = wp_get_current_user();
        $user_identity = $user->exists() ? $user->display_name : '';
        $args = array(
          'id_form'           => 'commentform',
          'class_form'        =>  'comment-form form-horizontal',
          'id_submit'         => 'submit',
          'class_submit'      => 'submit',
          'name_submit'       => 'submit',
          'title_reply'       => __( 'Leave a Reply' ),
          'title_reply_to'    => __( 'Leave a Reply to %s' ),
          'cancel_reply_link' => __( 'Cancel Reply' ),
          'label_submit'      => __( 'Post Comment' ),
          'format'            => 'xhtml',

          'comment_field' =>  '<p class="comment-form-comment"><label for="comment">' . _x( 'Bình luận', 'noun' ) .
            '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" class="form-control">' .
            '</textarea></p>',

          'must_log_in' => '<p class="must-log-in">' .
            sprintf(
              __( 'You must be <a href="%s">logged in</a> to post a comment.' ),
              wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
            ) . '</p>',

          'logged_in_as' => '<p class="logged-in-as">' .
            sprintf(
            __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
              admin_url( 'profile.php' ),
              $user_identity,
              wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
            ) . '</p>',

          'comment_notes_before' => '<p class="comment-notes">' .
            __( 'Your email address will not be published.' ) . ( $req ? 'required="required"': '' ) .
            '</p>',

          'comment_notes_after' => '<p class="form-allowed-tags">' .
            sprintf(
              __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ),
              ' <code>' . allowed_tags() . '</code>'
            ) . '</p>',

          'fields' => apply_filters( 'comment_form_default_fields', $fields ),
        );
    comment_form( $args, $post_id );
    }
}
if(!function_exists('show_comment')){
    function show_comment(){
        $args = array(
                                'author_email' => '',
                                'include_unapproved' => '',
                                'fields' => '',
                                'ID' => '',
                                'order' => 'DESC',
                                'post_author__in' => '',
                                'post_author__not_in' => '',
                                'post_ID' => get_the_ID(), // ignored (use post_id instead)
                                'post_id' => get_the_ID(),
                                'post_author' => '',
                                'post_name' => '',
                                'post_parent' => '',
                                'post_status' => '',
                                'post_type' => '',
                                'status' => 'all',
                                'type' => '',
                                    'type__in' => '',
                                    'type__not_in' => '',
                                'user_id' => '',
                                'search' => '',
                                'count' => false,

                            );
                         $comment =   get_comments( $args ) ;

                            foreach($comment as $cmt):
                         ?>
                         <div class="comment-box">
                                <div class="col-md-2 col-xs-4">
                                    <img src="<?php  echo get_stylesheet_directory_uri();?>/assets/images/messages.png" alt="comment-box">
                                </div>
                                <div class="col-md-10 col-xs-8">
                                    <div class="vcard author post-author">
                                        <h3 class="comment-user-name"><?php  echo $cmt->comment_author ?></h3>
                                        <h4 class="comment-date pull-right"><?php  echo $cmt->comment_date ?></h4>
                                    </div>
                                    <p class="comments-desc">
                                        <?php  echo $cmt->comment_content ?>
                                    </p>

                                </div>
                            </div>
                            <?php
                            endforeach;
    }
}
if(!function_exists('wc_add_to_cart_message')){
    function wc_add_to_cart_message( $product_id ) {

        if ( is_array( $product_id ) ) {

            $titles = array();

            foreach ( $product_id as $id ) {
                $titles[] = get_the_title( $id );
            }

            $added_text = sprintf( __( 'Added &quot;%s&quot; to your cart.', 'woocommerce' ), join( __( '&quot; and &quot;', 'woocommerce' ), array_filter( array_merge( array( join( '&quot;, &quot;', array_slice( $titles, 0, -1 ) ) ), array_slice( $titles, -1 ) ) ) ) );

        } else {
            $added_text = sprintf( __( '&quot;%s&quot; was successfully added to your cart.', 'woocommerce' ), get_the_title( $product_id ) );
        }

        // Output success messages
        if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) :

            $return_to  = apply_filters( 'woocommerce_continue_shopping_redirect', wp_get_referer() ? wp_get_referer() : home_url() );

            $message    = sprintf('<a href="%s" class="button wc-forward">%s</a> %s', $return_to, __( 'Continue Shopping', 'woocommerce' ), $added_text );

        else :

            $message    = sprintf('<a href="%s" class="button wc-forward">%s</a> %s', get_permalink( wc_get_page_id( 'cart' ) ), __( 'View Cart', 'woocommerce' ), $added_text );

        endif;

        wc_add_notice( apply_filters( 'wc_add_to_cart_message', $message, $product_id ) );
    }
}