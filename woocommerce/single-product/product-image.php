<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;
$attachment_ids = $product->get_gallery_attachment_ids();
?>

<div class="col-md-6 single-product-slider ow-padding-left">
	<div id="product-slider" class="flexslider">
		<ul class="slides">
	<?php
		if ( has_post_thumbnail() ) {

			$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
			$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );

			$image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'	=> $image_title,
				'alt'	=> $image_title
				) );
			echo '<li>'.$image .' </li>';
			if ( $attachment_ids ) :
				$loop 		= 0;
				foreach ( $attachment_ids as $attachment_id ) {
				$image_link = wp_get_attachment_url( $attachment_id );
				if ( ! $image_link )
					continue;
				$image_title 	= esc_attr( get_the_title( $attachment_id ) );
				$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );
				$image       	= wp_get_attachment_url($attachment_id ,apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ),0);

				echo '<li> <img src="'.$image.'"  alt="'.$image_title.'"/> </li>';

				$loop++;
			}
				echo '<li>'.$image .' </li>';
			endif;

		} else {

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<li><img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID ).'</li>';

		}

	?>
		</ul>
	</div>

	<?php do_action( 'woocommerce_product_thumbnails' ); ?>
</div>