<?php

class Getled_WooCommerce {
	public static $checkout_progress;
	/** @var self Instance */
	private static $_instance;

	/** @var string Color attribute */
	private static $color_attr;

	public static function color_attr() {
		if ( ! self::$color_attr ) {
			self::$color_attr = taxonomy_exists( 'pa_colour' ) ? 'pa_colour' : 'pa_color';
		}

		return self::$color_attr;
	}

	/**
	 * Whether or not it's a product archive
	 * @return bool Whether or not it's a product archive
	 */
	public static function product_archive() {
		return function_exists( 'is_shop' ) && ( is_shop() ||  is_product_taxonomy() || is_product_category() || is_product_tag() );
	}

	public function __construct() {

		if ( ! function_exists( 'is_shop' ) ) {
			return;
		}

		/** Variation swatches */
		require get_template_directory() . '/ext/variant-swatches/variant-swatches.php';

		/* Smart variation images */
		define( 'SVI_URL', get_template_directory_uri() . '/ext/svi/' );
		define( 'SVI_PATH', get_template_directory() . '/ext/svi/' );
		require SVI_PATH . 'svi.php';

		// Cart actions
		add_action( 'woocommerce_before_mini_cart', [ $this, 'before_mini_cart_contents' ], 99 );
		add_filter( 'woocommerce_cart_item_remove_link', [ $this, 'mini_cart_item_remove' ] );
		add_action( 'wp_footer', [ $this, 'remove_cart_item_confirm_dialog' ] );

		// Templates filter
		add_filter( 'woocommerce_product_tabs', array( $this, 'product_tabs' ), 25 );

		// Related Products
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

		// Cart/Checkout
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
		add_action( 'woocommerce_before_cart', array( $this, 'checkout_progress' ) );
		add_action( 'woocommerce_before_checkout_form', array( $this, 'checkout_progress' ) );
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form' );
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

		// Shop
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

		// Single product
		add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 16 );
		add_action( 'woocommerce_after_single_product_summary', [ $this, 'related_products_tabs' ], 16 );
		add_action( 'woocommerce_before_single_product_summary', [ $this, 'gallery_thumbs_nav_js' ], 25 );

		add_filter( 'woocommerce_product_add_to_cart_text', array( $this, 'add_to_cart_text' ), 10, 2 );
		add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'add_to_cart_text' ), 10, 2 );

		// Product filters
		add_filter( 'getled_mobile_accordion', [ $this, 'getled_mobile_accordion' ] );
		add_action( 'woocommerce_product_query', [ $this, 'apply_filters_on_query' ] );
		add_action( 'woocommerce_shop_loop_item_title', [ $this, 'color_variations_indicator' ], 7 );
	}

	// region Shop filter rendering methods

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

	public static function filter( $label, $qry_param, $inner_elements ) {
		?>
		<div class="getled-filter" id="getled-filter-<?php echo $qry_param ?>">
			<a href="#" class="label"><?php echo $label ?></a>
			<div class="getled-filter-content">
				<?php
				if ( is_array( $inner_elements ) ) {
					echo '<ul class="wpf_links wpf_column_horizontal">';
					foreach ( $inner_elements as $val => $lbl ) {
						Getled_WooCommerce::filter_item( $lbl, $qry_param, $val );
					}
					echo '</ul>';
				} else {
					echo $inner_elements;
				}
				?>
			</div>
		</div>
		<?php
	}

	// endregion Shop filter rendering methods

	public static function filter_item( $label, $qry_param, $val = null, $class = '' ) {
		if ( null === $val ) {
			$url = $qry_param;
		} else {
			if ( filter_input( INPUT_GET, $qry_param ) == $val ) {
				$class .= ' active';
			}
			$url = add_query_arg( $qry_param, $val );
		}
		?>
		<li>
			<a class="getled-filter-link <?php echo $class ?>" href="<?php echo $url; ?>">
				<span><?php echo $label ?></span>
			</a>
		</li>
		<?php
	}

	// region Mini cart

	function before_mini_cart_contents() {
		$cart = WC()->cart;
		?>
		<div id="getled-min-cart-info" data-amount="<?php echo strip_tags( $cart->get_cart_total() ) ?>"
				 data-count="<?php echo array_sum( $cart->get_cart_item_quantities() ) ?>"></div>
		<?php
		if ( ! $cart->is_empty() ) {
			if ( 1 < count( $cart->cart_contents ) ) {
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
		if ( ! is_cart() ) {
			$html = '<a class="getled-remove-item">&times;</a>' . $html;
		}

		return $html;
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
	// endregion Mini cart

	// region Single product
	public function related_products_tabs() {
		wc_get_template( 'single-product/related-products.php' );
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

			} );
		</script>
		<?php
	}
	// endregion Single product

	// region Global
	/**
	 * @param string $a2c
	 * @param WC_Product $product
	 *
	 * @return string
	 */
	public function add_to_cart_text( $a2c, $product ) {
		if ( $product->get_type() == 'simple' ) {
			if ( $product->is_purchasable() && $product->is_in_stock() ) {
				$a2c = __( 'Add to basket', 'getled' );
			}
		}

		return $a2c;
	}

	/**
	 * @param WP_Query $qry
	 */
	public function apply_filters_on_query( $qry ) {
		if ( $qry->is_main_query() ) {
			$color_tax = Getled_WooCommerce::color_attr();
			$color_param = str_replace( 'pa_', '', $color_tax );
			if ( ! empty( $_GET[ $color_param ] ) ) {
				$tax_query = $qry->get( 'tax_query' );

				if ( is_array( $tax_query ) ) {
					$tax_query[] = [
						'taxonomy' => $color_tax,
						'field'    => 'slug',
						'terms'    => [ $_GET[ $color_param ] ],
					];
				}
				$qry->set( 'tax_query', $tax_query );
			}
		}
	}
	// endregion Global

	// region Product archives/Terms
	public function getled_mobile_accordion( $sections ) {
		ob_start();
		do_action( 'woocommerce_archive_description' );
		$cat_info = ob_get_clean();

		if ( $cat_info ) {
			$sections['products-header'] = [
				'title'   => woocommerce_page_title( false ),
				'content' => $cat_info,
			];
		}

		ob_start();
		wc_get_template( 'archive-product-filters.php' );
		$filter_html                 = ob_get_clean();
		$sections['products-filter'] = [
			'title'   => __( 'Product filters' ),
			'content' => $filter_html,
		];

		if ( $this->filters_applied() ) {
			$sections['products-filter']['class'] = 'getled-panel-open';
		}

		return $sections;
	}

	public function color_variations_indicator() {
		/** @var WC_Product $product */
		global $product;
		if ( $product ) {
			$color_tax = Getled_WooCommerce::color_attr();
			$prod_id = $product->get_id();

			if(  'WC_Product_Variation' === get_class( $product ) ) {
				/** @var WC_Product_Variation $product */
				$prod_id = $product->get_parent_id();
			}

			$vars = get_the_terms( $prod_id, $color_tax ); // get all attributes by variations

			if ( $vars && 1 < count( $vars ) ) {
				?>
				<div class='color-variations-indicator'></div>
				<?php
			}
		}
	}

	private function filters_applied() {
		return
			isset( $_GET['min_price'] ) || isset( $_GET['orderby'] ) ||
			isset( $_GET['max_price'] ) || isset( $_GET[ Getled_WooCommerce::color_attr() ] );
	}
	// endregion Product archives / Terms

	// region Cart/Checkout
	public function checkout_progress() {
		if ( is_cart() ) {
			Getled_WooCommerce::$checkout_progress = 1;
		} else if ( is_checkout() ) {
			if ( filter_input( INPUT_GET, 'step' ) === 'payment' ) {
				Getled_WooCommerce::$checkout_progress = 3;
			} else {
				Getled_WooCommerce::$checkout_progress = 2;
			}
		}
		wc_get_template( 'getled-checkout-progress.php' );
	}
	// endregion Cart/Checkout

	public static function coupon_html( $coupon ) {
		$discount_amount_html = '';

		$amount               = WC()->cart->get_coupon_discount_amount( $coupon->get_code(), WC()->cart->display_cart_ex_tax );
		$discount_amount_html = wc_price( $amount );

		if ( $coupon->get_free_shipping() && empty( $amount ) ) {
			$discount_amount_html = __( 'Free shipping coupon', 'woocommerce' );
		}

		$discount_amount_html = apply_filters( 'woocommerce_coupon_discount_amount_html', $discount_amount_html, $coupon );
		$coupon_html          = $discount_amount_html . ' <a href="' . esc_url( add_query_arg( 'remove_coupon', rawurlencode( $coupon->get_code() ), defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url() ) ) . '" class="woocommerce-remove-coupon" data-coupon="' . esc_attr( $coupon->get_code() ) . '">' . __( 'Remove', 'woocommerce' ) . '</a>';

		echo wp_kses( apply_filters( 'woocommerce_cart_totals_coupon_html', $coupon_html, $coupon, $discount_amount_html ), array_replace_recursive( wp_kses_allowed_html( 'post' ), array( 'a' => array( 'data-coupon' => true ) ) ) );
	}
}

Getled_WooCommerce::instance();

//// Remove add to cart button on Category pages.
function remove_loop_button(){
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}
add_action('init','remove_loop_button');