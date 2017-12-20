<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package getled
 */

if ( ! is_active_sidebar( 'rowtwo' ) ) {
	return;
}
?>

<aside id="flex-container" class="widget-area flex-container" role="complementary">
	<?php dynamic_sidebar( 'rowtwo' ); ?>
</aside><!-- #secondary -->
