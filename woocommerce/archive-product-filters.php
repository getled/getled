<div id="getled-filters">

	<?php

	// region Sorting filter
	Getled_WooCommerce::filter( 'Sort by', 'orderby', [
		'popularity' => 'Popularity',
//	'rating'     => 'Average rating',
		'date'       => 'New in',
		'price'      => 'Price: low to high',
		'price-desc' => 'Price: high to low',
	] );
	// endregion Sorting filter

	// region Price filter
	ob_start();
	the_widget( 'WC_Widget_Price_Filter' );

	Getled_WooCommerce::filter( 'Price range', 'price', ob_get_clean() );
	// endregion Price filter

	// region Product categories filter
	$terms = get_terms( array(
		'taxonomy' => 'product_cat',
		'hide_empty' => false,
		'update_term_meta_cache' => false,
	) );

	ob_start();
	echo '<ul class="wpf_links wpf_column_horizontal">';
	Getled_WooCommerce::filter_item( __( 'All products', 'getled' ), get_permalink( wc_get_page_id( 'shop' ) ) );
	foreach ( $terms as $term ) {
		/** @var WP_Term $term */
		Getled_WooCommerce::filter_item( $term->name, get_term_link( $term ) );
	}
	echo '</ul>';

	Getled_WooCommerce::filter( 'Categories', 'categories', ob_get_clean() );
	// endregion Product categories filter

	// region Product categories filter
	$terms = get_terms( array(
		'taxonomy' => 'pa_color',
		'hide_empty' => false,
		'update_term_meta_cache' => false,
	) );

	ob_start();
	echo '<ul class="wpf_links wpf_column_horizontal">';
	Getled_WooCommerce::filter_item( __( 'Any color', 'getled' ), get_permalink( wc_get_page_id( 'shop' ) ) );
	foreach ( $terms as $term ) {
		/** @var WP_Term $term */
		Getled_WooCommerce::filter_item( $term->name, 'pa_color', $term->term_id );
	}
	echo '</ul>';

	Getled_WooCommerce::filter( 'Color', 'categories', ob_get_clean() );
	// endregion Product categories filter


	?>
</div>

