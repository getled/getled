<?php
/**
 * Getled checkout new user
 * @author  Shramee
 * @package Getled
 */

wp_enqueue_script( 'jquery-ui-tabs' );
?>

<div id="getled-logged-out-user">
	<ul>
		<li><a href="#new"><?php _e( 'New to us?', 'getled' ) ?></a></li>
		<li><a href="#login"><?php _e( 'Already registered?', 'getled' ) ?></a></li>
	</ul>
	<div id="new">
		<h4><?php _e( 'Type in your email address to get started', 'getled' ) ?></h4>
		<form name="checkout" method="post" class="woocommerce-checkout" enctype="multipart/form-data"
					action="<?php echo esc_url( wc_get_checkout_url() ); ?>">
			<p class="form-row form-row-wide" id="email_field">
				<label for="billing_email" class=""><?php _e( 'Email address', 'getled' ) ?></label>
				<input required type="email" class="input-text " name="billing_email" id="billing_email"
							 placeholder="email@address.com">
			</p>
			<button type="submit" class="button" name="continue"><?php _e( 'Continue', 'getled' ) ?></button>
		</form>
	</div>
	<div id="login">
		<form class="woocommerce-form woocommerce-form-login login" method="post" style="">

			<p class="form-row form-row-wide">
				<label for="username"><?php _e( 'Username or email', 'woocommerce' ) ?></label>
				<input class="input-text" type="text" name="username" id="username" autocomplete="username">			</p>
			<p class="form-row form-row-wide">
				<label for="password"><?php _e( 'Password', 'woocommerce' ) ?></label>
				<input class="input-text" type="password" name="password" id="password" autocomplete="current-password">
			</p>
			<div class="clear"></div>

			<p class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgotten Your Password?', 'getled' ); ?></a>
			</p>

			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<button type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>"><?php esc_html_e( 'Login', 'woocommerce' ); ?></button>
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
				</label>
			</p>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

			<div class="clear"></div>
		</form>

	</div>
</div>

<script>
	jQuery( function ( $ ) {
		$( "#getled-logged-out-user" ).tabs();
	} );
</script>