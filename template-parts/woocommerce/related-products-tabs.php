<?php
$tabs = [];

ob_start();

$crosssells = get_post_meta( get_the_ID(), '_crosssell_ids',true);
$args = array(
	'post_type' => 'product',
	'posts_per_page' => -1,
	'post__in' => $crosssells
);
$products = new WP_Query( $args );
if( $products->have_posts() ) :
	echo '<section class="related products"><h2>Cross-Sells Products</h2>';
	woocommerce_product_loop_start();
	while ( $products->have_posts() ) : $products->the_post();
		wc_get_template_part( 'content', 'product' );
	endwhile; // end of the loop.
	woocommerce_product_loop_end();
	echo '</section>';
endif;
wp_reset_query();


$related = ob_get_clean();
if ( $related ) {
	$tabs['related'] = [
		'title' => __( 'Style this with', 'getled' ),
		'content' => $related,
		'prioritty' => 25,
	];
}

ob_start();
woocommerce_upsell_display();
$upsell = ob_get_clean();
if ( $upsell ) {
	$tabs['upsells'] = [
		'title' => __( 'You may also like', 'getled' ),
		'content' => $upsell,
		'prioritty' => 50,
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
