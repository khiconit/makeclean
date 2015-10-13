<form role="search" method="get" class="search widget_search" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<label class="screen-reader-text" for="s"><?php _e( 'Search for:', 'woocommerce' ); ?></label>
	<input type="search" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'woocommerce' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'woocommerce' ); ?>" />
	<span class="search-icon input-group-btn"><button type="submit" class="btn btn-xlg" value="<?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>"> </button></span>
	<input type="hidden" name="post_type" value="product" />
</form>
