<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
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
 * @version 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty"
					 name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>"/>
	</div>
	<?php
} else {
	$labelledby = $options = '';
	$min_value = max( $min_value, 1 );
	if ( ! $max_value ) {
		$max_value = 5;
	}
	for ( $count = $min_value; $count <= $max_value; $count += $step ) {
		$options  .= '<option value="' . $count . '"' . selected( $count, $input_value, 0 ) . '>' . $count . '</option>';
	}
	if ( ! empty( $args['product_name'] ) ) {
		$labelledby = sprintf( esc_attr__( '%s quantity', 'woocommerce' ), $args['product_name'] );
	}
	?>
	<div class="quantity">
		<label for="<?php echo $input_id ?>"><?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>:</label>
		<select id="<?php echo $input_id ?>" class="input-text qty text" name="<?php echo $input_name ?>">
			<?php echo $options; ?>
		</select>
	</div>
	<?php
}
