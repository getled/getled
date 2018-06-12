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
		<p class="form-row form-row-wide" id="email_field">
			<label for="billing_email" class=""><?php _e( 'Email address', 'getled' ) ?></label>
			<input required type="email" class="input-text " name="billing_email" id="billing_email" placeholder="email@address.com">
		</p>
		<button type="submit" class="button" name="continue"><?php _e( 'Continue', 'getled' ) ?></button>
	</div>
	<div id="login">
		<p class="form-row form-row-wide">
			<label for="username"><?php _e( 'Username or email', 'woocommerce' ) ?></label>
			<input type="text" class="input-text" name="username" id="username">
		</p>
		<p class="form-row form-row-wide">
			<label for="password"><?php _e( 'Password', 'woocommerce' ) ?></label>
			<input class="input-text" type="password" name="password" id="password">
		</p>
		<div class="clear"></div>


		<p class="form-row">
			<input type="hidden" id="woocommerce-login-nonce" name="woocommerce-login-nonce" value="d3522b66a3"><input
				type="hidden" name="_wp_http_referer" value="/11/checkout/">
			<button type="submit" class="button" name="login" value="Login">Login</button>
			<input type="hidden" name="redirect" value="http://wp/11/checkout/">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
				<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox"
							 id="rememberme" value="forever"> <span>Remember me</span>
			</label>
		</p>
		<p class="lost_password">
			<a href="http://wp/11/my-account/lost-password/">Lost your password?</a>
		</p>

		<div class="clear"></div>
	</div>
</div>

<script>
	jQuery( function ( $ ) {
		$( "#getled-logged-out-user" ).tabs();
	} );
</script>