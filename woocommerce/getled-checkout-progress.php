<?php
/**
 * Getled checkout progress template
 * @author  Shramee
 * @package Getled
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$step1 = $step2 = $step3 = '';

$html_attributes = [
	1 => [
		'class="active"',
		'',
		'',
	],
	2 => [
		'class="done"',
		'class="active"',
		'',
	],
	3 => [
		'class="done"',
		'class="done"',
		'class="active"',
	],
];


?>

<div id="getled-checkout-progress">
	<div id="step-bag" <?php echo $html_attributes[ Getled_WooCommerce::$checkout_progress ][0]  ?>>
		<div class="step-number"><?php _e( '1', 'getled' ) ?></div>
		<div class="label"><?php _e( 'Bag', 'getled' ) ?></div>
	</div>
	<div class="sep"></div>
	<div id="step-delivery" <?php echo $html_attributes[ Getled_WooCommerce::$checkout_progress ][1]  ?>>
		<div class="step-number"><?php _e( '2', 'getled' ) ?></div>
		<div class="label"><?php _e( 'Delivery', 'getled' ) ?></div>
	</div>
	<div class="sep"></div>
	<div id="step-payment" <?php echo $html_attributes[ Getled_WooCommerce::$checkout_progress ][2] ?>>
		<div class="step-number"><?php _e( '3', 'getled' ) ?></div>
		<div class="label"><?php _e( 'Payment', 'getled' ) ?></div>
	</div>
</div>