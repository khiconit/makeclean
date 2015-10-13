<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	$loop 		= 0;

	?>
	<div id="product-carousel" class="flexslider product-thumb">
			<ul class="slides">
		<?php
		$thumb='';
			foreach ( $attachment_ids as $attachment_id ) {
				$image_link = wp_get_attachment_url( $attachment_id );
				if ( ! $image_link )
					continue;
				$image_title 	= esc_attr( get_the_title( $attachment_id ) );
				$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );
				$image       	= wp_get_attachment_url($attachment_id ,apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ),0);

				echo '<li> <img src="'.$image.'"  alt="'.$image_title.'"/> </li>';

				$loop++;
			}
		?>
			</ul>
	</div>
	<?php
}
