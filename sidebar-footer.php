<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package getled
 */

if ( ! is_active_sidebar( 'footer-1' ) ) {
	return;
}
?>


<aside id="footer-email" class="widget-area footer-email" role="complementary">
	<?php dynamic_sidebar( 'footer-email' ); ?>
</aside><!-- #secondary -->

<aside id="footer-widget-area" class="widget-area footer-widgets row " role="complementary">
	<?php dynamic_sidebar( 'footer-1' ); ?>
</aside><!-- #secondary -->

<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">

		<?php 

			custom_footer_action ();

			?>

		</div><!-- .site-info -->
	</footer><!-- #colophon -->