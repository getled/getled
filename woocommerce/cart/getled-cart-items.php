<?php
$editable = ! empty( WC()->cart->getled_editable );
foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
	/** @var WC_Product $_product */
	$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
	$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

	if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
		$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
		?>
		<div
			class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
			<div class="product-thumbnail"><?php
				$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

				if ( ! $product_permalink ) {
					echo $thumbnail;
				} else {
					printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
				}
				?></div>

			<div class="product-info">
				<div class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>"><?php
					if ( ! $product_permalink ) {
						echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
					} else {
						echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
					}

					// Meta data.
					echo wc_get_formatted_cart_item_data( $cart_item );

					// Backorder notification.
					if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
						echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
					}
					?>
				</div>

				<?php
				if ( $editable ) {
				?>
			</div><!-- .product-info -->
			<div class="product-actions">
				<div class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
					<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
				</div>

				<div class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
					<?php
					if ( $_product->is_sold_individually() ) {
						$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
					} else {
						$product_quantity = woocommerce_quantity_input( array(
							'input_name'   => "cart[{$cart_item_key}][qty]",
							'input_value'  => $cart_item['quantity'],
							'max_value'    => $_product->get_max_purchase_quantity(),
							'min_value'    => '0',
							'product_name' => $_product->get_name(),
						), $_product, false );
					}

					echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
					?></div>

				<div class="remove-product">
					<?php
					// @codingStandardsIgnoreLine
					echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
						'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">' .
						__( 'Remove', 'getled' ) . '</a>',
						esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
						__( 'Remove', 'getled' ),
						esc_attr( $product_id ),
						esc_attr( $_product->get_sku() )
					), $cart_item_key );
					?>
				</div>

				<?php
				} else {
					?>
					<div class="item-quantity">
						<?php echo "$cart_item[quantity] x " . WC()->cart->get_product_subtotal( $_product, 1 ); ?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}
}
