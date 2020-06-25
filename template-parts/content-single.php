<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package getled
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
 <section class="post-content"> 
     
     <header class="entry-header">
         
         <?php 
         if ( has_post_thumbnail() ){ ?>
         <figure class="featured-image full-bleed">
             <?php 
             the_post_thumbnail('getled-full-bleed'); 
             ?>
         </figure><!-- .featured-imaged full-bleed -->
         <?php } ?>
             
            <?php getled_the_category_list (); ?>
            
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php getled_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->
     
	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'getled' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'getled' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php getled_entry_footer(); ?>
	</footer><!-- .entry-footer -->
        <?php
        getled_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
        ?>
 </section>
        <?php get_sidebar(); ?>
</article><!-- #post-## -->
