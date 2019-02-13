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
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> >
<i class="boddycover"></i>

<div id="page" class="site">

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'getled' ); ?></a>
    <header id="masthead" class="site-header" role="banner"> 
		<div class="header-section">  
      		<!-- <div class="row npad"> -->
			<div class="row">
				<div class="col s1 m1 l1 xl1 ma">
					<div class="displaymenu">
						<div class="toggle-gmenu">
							<?php if(get_theme_mod( 'getled_menu_title_iconclass_setting' )){?>
								<i class="<?php echo get_theme_mod( 'getled_menu_title_iconclass_setting' ); ?>"></i><?php //echo get_theme_mod( 'getled_menu_title_setting' ); ?>
							<?php }else{ ?> 
								<i class="fa fa-bars"></i>
							<?php } ?>
						</div>
					</div>          
				</div>
			
				<div class="col s6 m7 l8 xl9 ma">
					<div class="site-branding">          
						<?php if ( has_custom_logo() ){
						    the_custom_logo();
						    }else{ ?>
							<div class="site-branding-text">
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
																						rel="home"><?php bloginfo( 'name' ); ?></a>
									<?php
									$description = get_bloginfo( 'description', 'display' );
								    if ( $description || is_customize_preview() ) : ?>
									<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
									<?php endif; ?>
								</h1>
							</div>
							         <?php } ?>
				    </div>
				</div>
				<div class="col s5 m4 l3 xl2 ma">
					<div class="header-right-icons">
						<div class="custom-searchbox">
							<?php get_sidebar('woosearch');?> 
						</div>
						<div class="myaccount">
							<?php 
							    if(get_theme_mod( 'getled_my_account_page_url' )){
							       $my_account_page_url= get_theme_mod( 'getled_my_account_page_url' );
								}else{
								  $my_account_page_url= "#";
							  }
							?>
							<?php if(get_theme_mod( 'getled_my_account_icon_url' )){ ?>
							<a href="<?php echo $my_account_page_url; ?>">
									<img class="my_account" src="<?php echo get_theme_mod( 'getled_my_account_icon_url' ); ?>" alt="My Account">
							</a>
						<?php } else { ?>
							<a href="<?php echo $my_account_page_url; ?>"><i class="fa fa-user-circle-o"></i></a>
						<?php } ?>
						</div>
						<div class="cart">
							<?php getled_header_cart(); ?>
						</div>
					</div>
				</div>		
			</div>
		</div>
    </header>

	<nav id="getled-navigation" class="main-navigation" role="navigation">
		<div class="main-navigation-menus">
			<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' ) ); ?>
			<?php if (get_theme_mod( 'getled_middle_menu_enable' )){
				middle_menu_area();
			} ?>
			<?php wp_nav_menu( array( 'theme_location' => 'menu-2', 'menu_id' => 'secondary-menu' ) ); ?>
		</div>
    </nav><!-- #site-navigation -->


	<?php

	/* action hook for any content placed right after the header, menu, etc */

	do_action( 'getled_under_header' );

	?>

	<?php if ( get_header_image() && is_front_page() ) : ?>

		<figure class="header-image">

			<?php the_header_image_tag(); ?>
		</figure>

	<?php endif; ?>

	<div id="content" class="site-content">
  
