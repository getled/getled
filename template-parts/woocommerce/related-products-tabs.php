<?php
$tabs = [];

ob_start();
woocommerce_upsell_display();
$upsell = ob_get_clean();
if ( $upsell ) {
	$tabs['upsells'] = [
		'title' => __( 'You may also like', 'getled' ),
		'content' => $upsell
	];
}

ob_start();
woocommerce_output_related_products();
$related = ob_get_clean();
if ( $related ) {
	$tabs['related'] = [
		'title' => __( 'Style this with', 'getled' ),
		'content' => $related
	];
}


?>

<div class="woocommerce-tabs wc-tabs-wrapper">
		<ul class="tabs wc-tabs" role="tablist">
			<?php foreach ( $tabs as $key => $tab ) : ?>
	<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
		<a href="#tab-<?php echo esc_attr( $key ); ?>">
			<?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?>
		</a>
	</li>
<?php endforeach; ?>
</ul>
<?php foreach ( $tabs as $key => $tab ) : ?>
	<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
		<?php if ( isset( $tab['content'] ) ) { echo $tab['content']; } ?>
	</div>
<?php endforeach; ?>
</div>
