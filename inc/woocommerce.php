<?php
add_action( 'woocommerce_before_mini_cart', 'getled_before_mini_cart_contents', 99 );

function getled_before_mini_cart_contents() {
	$cart = WC()->cart;
	?>
	<div id="getled-min-cart-info" data-amount="<?php echo strip_tags( $cart->get_cart_total() ) ?>" data-count="<?php echo array_sum( $cart->get_cart_item_quantities() ) ?>"></div>
	<?php
	if ( ! $cart->is_empty() ) {
		if ( 2 < count( $cart->cart_contents ) ) {
			add_action( 'woocommerce_mini_cart_contents', function() {
				echo '<i class="fa fa-caret-down scroll"></i>';
			}, 99 );

			echo '<i class="fa fa-caret-up scroll"></i>';
		}
	} else {
		?>
		<p class="woocommerce-mini-cart__empty-message"><?php _e( 'Your bag is empty!', 'woocommerce' ); ?></p>
		<?php
	}
}

add_filter( 'woocommerce_cart_item_remove_link', 'getled_mini_cart_item_remove' );

function getled_mini_cart_item_remove( $html ) {
	return '<a class="getled-remove-item">&times;</a>' . $html;
}

add_action( 'wp_footer', 'getled_remove_cart_item_confirm_dialog' );

function getled_remove_cart_item_confirm_dialog() {
	?>
	<div id="remove-mini-cart-item" class="getled-dialog" style="display:none;">
		<p><?php _e( 'Are you sure you would like to remove this item from the shopping bag?', 'getled' ) ?></p>
		<div class="getled-dialog-buttons">
			<a class="button alt close">Cancel</a>
			<a class="button" onclick="getled.removeMiniCartItem( this )">Okay</a>
		</div>
	</div>
	<?php
}