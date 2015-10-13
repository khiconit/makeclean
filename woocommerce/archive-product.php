<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
	get_header( 'shop' ); ?>
	<?php
	   if(isset($makeclean_theme_option['sidebar-archive'])):
        if($makeclean_theme_option['sidebar-archive'] ==1 ) :
             add_filter( 'vc_shortcodes_css_class', 'custom_css_classes_for_vc_row_and_vc_column', 10, 2 );
        endif;
    else:

            add_filter( 'vc_shortcodes_css_class', 'custom_css_classes_for_vc_row_and_vc_column', 10, 2 );

    endif;
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		// do_action( 'woocommerce_before_main_content' );
	?>



		<?php
			/**
			 * woocommerce_archive_description hook
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			echo '<div id="product-section" class="product-section shop"> <div class="container"> <div class="row">';
              if(!is_search()): //if <>  search page
                if(isset($makeclean_theme_option['sidebar-archive']) ):
                 if($makeclean_theme_option['sidebar-archive']==1):
                 	get_sidebar('shop' ) ;
                 	do_action( 'custom_archive_description' );
                 	else:
                 	do_action( 'woocommerce_archive_description' );
             	endif;

                else:
                    get_sidebar('shop' );
                    do_action( 'custom_archive_description' );
                endif;
            else://If is search page then display
            if(isset($makeclean_theme_option['sidebar-archive'])):
                if($makeclean_theme_option['sidebar-archive'] ==1 ) :
                    get_sidebar('shop' ) ;
                    echo '<div class="col-md-9 col-sm-8">';
                else:
                    echo '<div class="col-md-12 col-sm-11">';
                endif;
             else:
                get_sidebar('shop' ) ;
                    echo '<div class="col-md-9 col-sm-8">';
             endif;
            if ( have_posts() ) : ?>
                <div class="product-category">
                     <h4><?php woocommerce_page_title(); ?></h4>
                  </div>
                <?php
                        /**
                         * woocommerce_before_shop_loop hook
                         *
                         * @hooked woocommerce_result_count - 20
                         * @hooked woocommerce_catalog_ordering - 30
                         */

                        do_action( 'woocommerce_before_shop_loop' ); ?>

                    <?php woocommerce_product_loop_start(); ?>

                        <?php woocommerce_product_subcategories(); ?>

                        <?php while ( have_posts() ) : the_post(); ?>

                                <?php $shop_page   = get_post( wc_get_page_id( 'shop' ) ); ?>

                            <?php wc_get_template_part( 'content', 'product' ); ?>

                        <?php endwhile; // end of the loop.?>

                    <?php woocommerce_product_loop_end(); ?>

                    <?php
                        /**
                         * woocommerce_after_shop_loop hook
                         *
                         * @hooked woocommerce_pagination - 10
                         */
                          if (!( is_post_type_archive( 'product' ) && get_query_var( 'paged' ) == 0) ):
                        do_action( 'woocommerce_after_shop_loop' );
                        endif;
              endif;
            endif;
			?>
 </div>


<?php

if(isset($makeclean_theme_option['sidebar-archive'])):
        if($makeclean_theme_option['sidebar-archive'] ==1 ) :
        	echo '<div class="col-md-9 col-sm-8">';
        else:
        	echo '<div class="col-md-12 col-sm-11">';
        endif;
   	else:
   		echo '<div class="col-md-9 col-sm-8">';
 endif;
  if (!( is_post_type_archive( 'product' ) && get_query_var( 'paged' ) == 0) ):
 ?>
         <div class="product-category">
             <h4><?php woocommerce_page_title(); ?></h4>
          </div>
         <?php
         endif;
        if ( have_posts() ) :
        		?>
        		<?php
        				/**
        				 * woocommerce_before_shop_loop hook
        				 *
        				 * @hooked woocommerce_result_count - 20
        				 * @hooked woocommerce_catalog_ordering - 30
        				 */

        				do_action( 'woocommerce_before_shop_loop' );

        			?>

        			<?php woocommerce_product_loop_start(); ?>

        				<?php woocommerce_product_subcategories(); ?>

        				<?php while ( have_posts() ) : the_post(); ?>

        					<?php if (!( is_post_type_archive( 'product' ) && get_query_var( 'paged' ) == 0) ): ?>

        						<?php $shop_page   = get_post( wc_get_page_id( 'shop' ) ); ?>

        					<?php wc_get_template_part( 'content', 'product' ); ?>

        					<?php endif; ?>
        				<?php endwhile; // end of the loop.?>



        			<?php woocommerce_product_loop_end(); ?>

        			<?php
        				/**
        				 * woocommerce_after_shop_loop hook
        				 *
        				 * @hooked woocommerce_pagination - 10
        				 */
        				  if (!( is_post_type_archive( 'product' ) && get_query_var( 'paged' ) == 0) ):
        				do_action( 'woocommerce_after_shop_loop' );
        				endif;
        			?>
 </div>
		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>
 </div>
	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
	echo '</div>';
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */

		//do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); ?>
