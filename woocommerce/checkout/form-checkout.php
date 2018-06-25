<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see      https://docs.woocommerce.com/document/template-structure/
 * @author    WooThemes
 * @package  WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>

<?php if ( is_user_logged_in() ) {
	?>
	<form name="checkout" method="post" class="checkout woocommerce-checkout" enctype="multipart/form-data"
	action="<?php echo esc_url( wc_get_checkout_url() ); ?>">
	<?php
} ?>

	<div class="checkout-main col l9">
		<?php
		if ( ! is_user_logged_in() && empty( $_POST['billing_email'] ) ) {
			wc_get_template( 'checkout/logged-out-user.php' );
		} elseif ( $checkout->get_checkout_fields() ) {
			?>
			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<div id="customer_details">
				<?php
				do_action( 'woocommerce_checkout_billing' );
				do_action( 'woocommerce_checkout_shipping' );
				?>
				<button type="button" class="button" id="payment-button"><?php _e( 'Payment', 'getled' ) ?></button>
			</div>
			<div id="payment">
				<?php woocommerce_checkout_payment(); ?>
			</div>
			<script>
				jQuery( function( $ ) {
					var
						$pay = $( '#payment' ),
						$stepBag = $( '#step-bag' ),
						$stepDel = $( '#step-delivery' ),
						$stepPay = $( '#step-payment' );
					$pay.hide();
					$( '#payment-button' ).click( function() {
						$( '#customer_details' ).hide();
						$pay.show();
						$stepPay.attr( 'class', $stepDel.attr( 'class' ) );
						$stepDel.attr( 'class', $stepBag.attr( 'class' ) );
					} );
				} );
			</script>

			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

			<script>
				jQuery( function ( $ ) {
					var $cb = $( '#ship-to-different-address-checkbox' );
					$cb.change( function () {
						if ( this.checked ) {
							$( '.shipping_address' ).slideDown();
						} else {
							$( '.shipping_address' ).slideUp();
						}
					} ).change();
				} );
			</script>

			<?php
		} ?>
	</div>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
	<div class="checkout-aside col l3">
		<h3 id="order_review_heading">
			<?php _e( 'Bag', 'getled' ); ?>
			<small>
				<?php
				echo sprintf (
					_n( '%d item', '%d items', WC()->cart->get_cart_contents_count() ),
					WC()->cart->get_cart_contents_count()
				);
				?>
			</small>

			<small class="edit-bag">
				<a href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'Edit bag', 'getled' ); ?>">
					<?php _ex( 'Edit', 'edit bag', 'getled' ) ?>
				</a>
			</small>
		</h3>
		<?php
		WC()->cart->getled_editable = false;
		wc_get_template( 'cart/getled-cart-items.php' );
		?>
		<div class="cart-subtotal">
			<span><?php _e( 'Subtotal', 'woocommerce' ); ?> </span>
			<span class="cart-subtotal-value"><?php wc_cart_totals_subtotal_html(); ?></span>
		</div>
		<?php
		wc_get_template( 'checkout/checkout-totals.php' );
		?>
		<div id="secure-checkout-label">
			<i class="fa fa-lock"></i> <?php _e( 'Secure checkout', 'getled' ) ?>
		</div>
	</div>


	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

<?php if ( is_user_logged_in() ) {
?>
</form>
	<?php
			} ?>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
