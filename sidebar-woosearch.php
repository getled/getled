<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package getled
 */

if ( ! is_active_sidebar( 'topsearch' ) ) {
	return;
}
?>


	<?php dynamic_sidebar( 'topsearch' ); ?>

