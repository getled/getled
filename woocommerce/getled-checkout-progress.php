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
		'label' => 'your bag',
		1 => 'class="active"',
		2 => '',
		3 => '',
	],
	2 => [
		'label' => 'delivery',
		1 => 'class="done"',
		2 => 'class="active"',
		3 => '',
	],
	3 => [
		'label' => 'payment',
		1 => 'class="done"',
		2 => 'class="done"',
		3 => 'class="active"',
	],
];

$current_attrs = $html_attributes[ Getled_WooCommerce::$checkout_progress ];

?>

<h2 id="getled-checkout-step">
	<span class="step-number"><?php _e( Getled_WooCommerce::$checkout_progress, 'getled' ) ?></span>
	<?php echo $current_attrs['label'] ?>
</h2>
<div id="getled-checkout-progress">
	<div id="step-bag" <?php echo $current_attrs[1]  ?>>
		<div class="step-number"><?php _e( '1', 'getled' ) ?></div>
		<div class="label"><?php _e( 'Bag', 'getled' ) ?></div>
	</div>
	<div class="sep"></div>
	<div id="step-delivery" <?php echo $current_attrs[2]  ?>>
		<div class="step-number"><?php _e( '2', 'getled' ) ?></div>
		<div class="label"><?php _e( 'Delivery', 'getled' ) ?></div>
	</div>
	<div class="sep"></div>
	<div id="step-payment" <?php echo $current_attrs[3] ?>>
		<div class="step-number"><?php _e( '3', 'getled' ) ?></div>
		<div class="label"><?php _e( 'Payment', 'getled' ) ?></div>
	</div>
</div>