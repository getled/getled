<?php

class Getled_WooCommerce {
	/** @var self Instance */
	private static $_instance;

	/**
	 * Returns instance of current calss
	 * @return self Instance
	 */
	public static function instance() {
		if ( ! self::$_instance ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {

		// Cart actions
		add_action( 'woocommerce_before_mini_cart', [ $this, 'before_mini_cart_contents' ], 99 );
		add_filter( 'woocommerce_cart_item_remove_link', [ $this, 'mini_cart_item_remove' ] );
		add_action( 'wp_footer', [ $this, 'remove_cart_item_confirm_dialog' ] );

		// Templates filter
		add_action( 'woocommerce_locate_template', array( $this, 'wc_locate_template' ), 999, 2 );
		add_action( 'woocommerce_product_tabs', array( $this, 'product_tabs' ), 25 );

		// Related Products
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

		add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 16 );
		add_action( 'woocommerce_after_single_product_summary', [ $this, 'related_products_tabs' ], 16 );

	}

	function before_mini_cart_contents() {
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

	function mini_cart_item_remove( $html ) {
		return '<a class="getled-remove-item">&times;</a>' . $html;
	}

	function remove_cart_item_confirm_dialog() {
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

	public function wc_locate_template( $file, $tpl ) {
		if ( 'single-product/tabs/tabs.php' == $tpl ) {
			return locate_template( 'template-parts/woocommerce/accordion-tabs.php' );
		}

		return $file;
	}

	public function related_products_tabs() {
		locate_template( 'template-parts/woocommerce/related-products-tabs.php', 'load' );
	}

	public function product_tabs( $tabs = array() ) {
		global $product;

		$delivery_info = get_theme_mod( 'getled_product_delivery_info' );
		$returns_info = get_theme_mod( 'getled_product_returns_info' );

		if ( $delivery_info ) {
			$tabs['delivery_info'] = array(
				'title'    => get_theme_mod( 'getled_product_delivery_label', 'DELIVERY' ),
				'priority' => 5,
				'callback' => [ $this, 'delivery_product_tab' ],
			);
		}

		if ( $returns_info ) {
			$tabs['returns_info'] = array(
				'title'    => get_theme_mod( 'getled_product_returns_label', 'RETURNS' ),
				'priority' => 7,
				'callback' => [ $this, 'returns_product_tab' ],
			);
		}

		$tabs['description']['title'] = 'PRODUCT DETAILS';
		unset( $tabs['reviews'] );

		return $tabs;
	}

	public function delivery_product_tab() {
		echo get_theme_mod( 'getled_product_delivery_info' );
	}

	public function returns_product_tab() {
		echo get_theme_mod( 'getled_product_returns_info' );
	}
}

Getled_WooCommerce::instance();