<?php

class Getled_WooCommerce {
	/** @var self Instance */
	private static $_instance;

	public function __construct() {

		// Cart actions
		add_action( 'woocommerce_before_mini_cart', [ $this, 'before_mini_cart_contents' ], 99 );
		add_filter( 'woocommerce_cart_item_remove_link', [ $this, 'mini_cart_item_remove' ] );
		add_action( 'wp_footer', [ $this, 'remove_cart_item_confirm_dialog' ] );

		// Templates filter
		add_filter( 'woocommerce_locate_template', array( $this, 'wc_locate_template' ), 999, 2 );
		add_filter( 'woocommerce_product_tabs', array( $this, 'product_tabs' ), 25 );

		// Related Products
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

		add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 16 );
		add_action( 'woocommerce_after_single_product_summary', [ $this, 'related_products_tabs' ], 16 );
		add_action( 'woocommerce_before_single_product_summary', [ $this, 'gallery_thumbs_nav_js' ], 25 );
	}

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

	function before_mini_cart_contents() {
		$cart = WC()->cart;
		?>
		<div id="getled-min-cart-info" data-amount="<?php echo strip_tags( $cart->get_cart_total() ) ?>"
				 data-count="<?php echo array_sum( $cart->get_cart_item_quantities() ) ?>"></div>
		<?php
		if ( ! $cart->is_empty() ) {
			if ( 2 < count( $cart->cart_contents ) ) {
				add_action( 'woocommerce_mini_cart_contents', function () {
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
				<a class="button" onclick="Getled.removeMiniCartItem( this )">Okay</a>
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
		$returns_info  = get_theme_mod( 'getled_product_returns_info' );

		if ( $delivery_info ) {
			$tabs['delivery_info'] = array(
				'title'    => get_theme_mod( 'getled_product_delivery_label', 'DELIVERY' ),
				'priority' => 25,
				'callback' => [ $this, 'delivery_product_tab' ],
			);
		}

		if ( $returns_info ) {
			$tabs['returns_info'] = array(
				'title'    => get_theme_mod( 'getled_product_returns_label', 'RETURNS' ),
				'priority' => 50,
				'callback' => [ $this, 'returns_product_tab' ],
			);
		}

		$tabs['description']['title'] = 'PRODUCT DETAILS';
		unset( $tabs['reviews'] );
		unset( $tabs['additional_information'] );

		return $tabs;
	}

	public function delivery_product_tab() {
		echo get_theme_mod( 'getled_product_delivery_info' );
	}

	public function returns_product_tab() {
		echo get_theme_mod( 'getled_product_returns_info' );
	}

	public function gallery_thumbs_nav_js() {
		?>
		<style>
			.woocommerce .product .getled-gallery-nav {
				position: absolute;
				top: 0;
				left: 0;
				width: calc(25% - 10px);
				text-align: center;
				margin: 0 !important;
				cursor: pointer;
			}

			.woocommerce .product .gallery-nav-next {
				top: auto;
				bottom: 0;
			}
		</style>
		<script>
			jQuery( function ( $ ) {
				setTimeout( function () {
					var $thumbsWrap = $( '.flex-control-nav.flex-control-thumbs' );
					if ( $thumbsWrap.find( 'li' ).length < 3 ) return;
					$thumbsWrap
						.after( '<div class="getled-gallery-nav gallery-nav-prev"><i class="fa fa-chevron-up"></i></div>' )
						.after( '<div class="getled-gallery-nav gallery-nav-next"><i class="fa fa-chevron-down"></i></div>' )
					$thumbsWrap.siblings( '.getled-gallery-nav' ).on( 'click', function () {
						var
							$t = $( this ),
							scroll = $thumbsWrap.find( 'li' ).outerHeight() + 20;
						if ( $t.attr( 'class' ).indexOf( 'prev' ) > - 1 ) {
							scroll = '-=' + scroll;
						} else {
							scroll = '+=' + scroll;
						}
						$thumbsWrap.animate( {scrollTop: scroll}, 'fast' );
					} );
				}, 250 );
			} );
		</script>
		<?php
	}
}

Getled_WooCommerce::instance();