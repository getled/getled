<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package getled
 */



?>

	</div><!-- #content -->
        
       <?php get_sidebar('footer'); ?>


     

	
</div><!-- #page -->
<script type="text/javascript">
	jQuery(document).ready(function(){
	jQuery ('<a class="menu-close-icon"><img src="<?php echo get_template_directory_uri();?>/images/close-white.png"></a>').insertAfter(".menu-primary-menu-container" );
});
</script>
<?php wp_footer(); ?>

</body>
</html>
