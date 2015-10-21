<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

?>
<li itemprop="review" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
  	<div class="comment-box">
            <div class="col-md-2 col-xs-4">
                <img src="<?php  echo get_stylesheet_directory_uri();?>/assets/images/messages.png" alt="comment-box">
            </div>
            <div class="col-md-10 col-xs-8">
                <div class="vcard author post-author">
                    <h3 class="comment-user-name"><?php  if ( get_option( 'woocommerce_review_rating_verification_label' ) === 'yes' )
		if ( wc_customer_bought_product( $comment->comment_author_email, $comment->user_id, $comment->comment_post_ID ) )
			echo '<em class="verified">(' . __( 'verified owner', 'woocommerce' ) . ')</em> '; ?></h3>
                    <h4 class="comment-date pull-right"><?php     echo get_comment_date( 'c' );  ?></h4>
                </div>
                <p class="comments-desc">
                    <?php  echo comment_text();  ?>
                </p>

            </div>
        </div>