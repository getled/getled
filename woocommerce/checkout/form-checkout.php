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

$getled_show_checkout_form = is_user_logged_in() || ! empty( $_POST['billing_email'] );

?>
<div class="col l8 s12">
	<h2 id="getled-checkout-step">
		<span class="step-number"><?php _e( 2, 'getled' ) ?></span>
		<?php echo __( 'Delivery', 'getled' ) ?>
	</h2>
	<?php if ( $getled_show_checkout_form ) {
		echo
			'<form name="checkout" method="post" class="checkout woocommerce-checkout checkout-main" enctype="multipart/form-data"' .
			'action="' . esc_url( wc_get_checkout_url() ) . '">';
	} else {
		echo '<div class="checkout-main">';
	}
	?>
	<?php
	if ( ! $getled_show_checkout_form ) {
		wc_get_template( 'checkout/logged-out-user.php' );
	} elseif ( $checkout->get_checkout_fields() ) {
		?>
		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div id="customer_details">
			<?php
			do_action( 'woocommerce_checkout_billing' );
			do_action( 'woocommerce_checkout_shipping' );
			?>
		</div>
		<div id="payment">
			<h3 id="secure-payment-label">
				<?php _e( 'Secure payment', 'getled' ) ?> <i class="fa fa-lock"></i>
			</h3>
			<h4><?php _e( 'Choose payment method', 'getled' ) ?></h4>
			<?php woocommerce_checkout_payment(); ?>
		</div>
		<script>
			jQuery( function ( $ ) {
				var
					$pay = $( '#payment' ),
					$stepBag = $( '#step-bag' ),
					$stepDel = $( '#step-delivery' ),
					$stepPay = $( '#step-payment' );
				$pay.hide();
				$( '#payment-button' ).click( function () {
					window.scrollTo(0, 0);
					$( '#customer_details, #payment-button' ).hide();
					$pay.show();
					$( '#getled-checkout-step' ).html( '<span class="step-number">3</span> payment' );
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


	<?php if ( $getled_show_checkout_form ) {
		echo '</form>';
	} else {
		echo '</div>';
	} ?>
</div>
<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
<div class="col l4 s12">
	<div class="checkout-aside">
		<h3 id="order_review_heading">
			<?php _e( 'Bag', 'getled' ); ?>
			<small>
				<?php
				echo sprintf(
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

		<?php if ( wc_coupons_enabled() ) { ?>
			<form class="woocommerce-coupon-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
				<?php do_action( 'woocommerce_cart_coupon' ); ?>
			</form>
		<?php } ?>

		<div class="cart-subtotal">
			<span><?php _e( 'Subtotal', 'woocommerce' ); ?> </span>
			<span class="cart-subtotal-value"><?php wc_cart_totals_subtotal_html(); ?></span>
		</div>
		<?php
		wc_get_template( 'checkout/checkout-totals.php' );
		?>
		<button type="button" class="button" id="payment-button"><?php _e( 'Payment', 'getled' ) ?></button>

		<div id="secure-checkout-label">
			<i class="fa fa-lock"></i> <?php _e( 'Secure checkout', 'getled' ) ?>
		</div>
	</div>
</div>


<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
