<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package getled
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> >
    <i class="boddycover"></i>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'getled' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
            <div class="displaymenu"><button class="toggle-gmenu"><i class="<?php echo get_theme_mod('getled_menu_title_iconclass_setting'); ?>"></i><?php echo get_theme_mod('getled_menu_title_setting'); ?></button>	
            </div> 
                <div class="site-branding">
                    <?php the_custom_logo () ?>
                        <div class="site-branding-text">
                        <?php
			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>
                    </div>
		</div><!-- .site-branding -->

                <div class="nextmenu"> next menu</div>
                
	</header><!-- #masthead -->
        
       <nav id="getled-navigation" class="main-navigation" role="navigation">
            <?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' ) ); ?>
        </nav><!-- #site-navigation --> 

                
                 <?php
        
        /* action hook for any content placed right after the header, menu, etc */
        
        do_action ('getled_under_header'); 
        
        ?>
        
        <?php if (get_header_image() && is_front_page()) : ?>
        
        <figure class="header-image">
            
             <?php the_header_image_tag(); ?>
        </figure>
        
        <?php endif; ?>
        
	<div id="content" class="site-content">
  