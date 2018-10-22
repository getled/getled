<?php
/**
 * Template Name: Full Getled
 *
 */
 

get_header( 'clear' ); ?>

	<div id="elementor-getled" class="content-elementor">
           
			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'frontpage' );

				

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
