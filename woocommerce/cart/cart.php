<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form col l8 s12" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<div class="cart-contents">
		<?php
		do_action( 'woocommerce_before_cart_contents' );
		WC()->cart->getled_editable = true;
		wc_get_template( 'cart/getled-cart-items.php' );
		do_action( 'woocommerce_cart_contents' );
		?>
		<script>
			jQuery( function ( $ ) {
				$( 'select.qty' ).change( function() {
					console.log( 'changed' );
					$( '[name="update_cart"]' ).click();
				} );
			} );
		</script>
		<button type="submit" class="button" name="update_cart"
						value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
	</div>

	<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
	<?php wp_nonce_field( 'woocommerce-cart' ); ?>
</form>

<div class="col l4 s12">
	<div class="cart-sidebar">

		<?php do_action( 'woocommerce_before_cart_totals' ); ?>
		<div class="cart-subtotal">
			<span><?php _e( 'Subtotal', 'woocommerce' ); ?> </span>
			<span class="cart-subtotal-value"><?php wc_cart_totals_subtotal_html(); ?></span>
		</div>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
				<span class="cart-coupon-value"><?php Getled_WooCommerce::coupon_html( $coupon ) ?></span>
			</div>
		<?php endforeach; ?>

		<?php if ( wc_coupons_enabled() ) { ?>
			<form class="woocommerce-coupon-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
				<label for="coupon_code"><?php esc_html_e( 'Coupon code', 'woocommerce' ); ?></label>

				<div class="coupon-field">
					<input type="text" name="coupon_code" class="input-text" id="coupon_code" value=""
								 placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>"/>
					<input type="submit" class="button" name="apply_coupon"
								 value="<?php esc_attr_e( 'Use', 'woocommerce' ); ?>"/>
				</div>
				<?php do_action( 'woocommerce_cart_coupon' ); ?>
			</form>
		<?php } ?>

		<?php do_action( 'woocommerce_cart_actions' ); ?>
		<?php wp_nonce_field( 'woocommerce-cart' ); ?>

		<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action( 'woocommerce_cart_collaterals' );
		?>
	</div>
</div>
<?php do_action( 'woocommerce_after_cart' ); ?>
