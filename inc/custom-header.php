<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package getled
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses getled_header_style()
 */
function getled_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'getled_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 3200,
		'height'                 => 1200,
		'flex-height'            => true,
		'wp-head-callback'       => 'getled_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'getled_custom_header_setup' );

