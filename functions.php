<?php
/**
 * getled functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package getled
 */

if ( ! function_exists( 'getled_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function getled_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on getled, use a find and replace
	 * to change 'getled' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'getled', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Add WooCommerce support
	add_theme_support( 'woocommerce' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
        add_image_size('getled-full-bleed' , 2000 , 1200 , true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'getled' ),
                //'menu-2' => esc_html__( 'Secondary', 'getled' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'getled_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

        // Add theme support for custom Logo
        add_theme_support( 'custom-logo' , array (
            'width' => 50,
            'height' => 50,
            'flex-width' => true,
        ));
        
        }
endif;
add_action( 'after_setup_theme', 'getled_setup' );

function getled_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Oswald, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$oswald = _x( 'on', 'oswald font: on or off', 'getled' );

	if ( 'off' !== $oswald ) {
            
		$font_families = array();

		$font_families[] = 'Oswald:200,300,400,500,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function getled_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'getled-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'getled_resource_hints', 10, 2 );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function getled_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'getled_content_width', 640 );
}
add_action( 'after_setup_theme', 'getled_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function getled_widgets_init() {
        
        register_sidebar( array(
		'name'          => esc_html__( 'Top Banner', 'getled' ),
		'id'            => 'top',
		'description'   => esc_html__( 'Add widgets here.', 'getled' ),
		'before_widget' => '<section id="f-three" class="f-three box">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
    
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'getled' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'getled' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
        
        register_sidebar( array(
		'name'          => esc_html__( 'Row two', 'getled' ),
		'id'            => 'rowtwo',
		'description'   => esc_html__( 'Add widgets here.', 'getled' ),
		'before_widget' => '<section id="%1$s" class="box f-two">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
        
        
        register_sidebar( array(
		'name'          => esc_html__( 'Footer Email', 'getled' ),
		'id'            => 'footer-email',
		'description'   => esc_html__( 'Add footer email widget here.', 'getled' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
        
        register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets', 'getled' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add footer widgets here.', 'getled' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'getled_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function getled_scripts() {
    // Enqueue Google Fonts Oswald: 200 Extra light, 300 light, 400 Normal and 700 bold
        wp_enqueue_style( 'getled-fonts', getled_fonts_url());
        
        wp_enqueue_style( 'getled-style' , get_stylesheet_uri() );

        wp_enqueue_script( 'getled-navmenu', get_template_directory_uri() . '/js/navmenu.js', array('jquery'), time(), true );
        
        wp_localize_script( 'getled-navmenu', 'getledScreenReaderText',
                
                array(
                        
                    'expand' => __('Expand child menu', 'getled'),
                    'collapse' => __('Collapse child menu', 'getled'),
                   ));
        
        wp_enqueue_script( 'getled-functions', get_template_directory_uri() . '/js/functions.js', array('jquery'), '20170505', true );

        wp_enqueue_script( 'getled-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'getled_scripts' );

//**Adds a new admin stylesheet**/

 add_action( 'admin_enqueue_scripts', 'load_admin_style' );
      function load_admin_style() {
        wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/admin-style-new.css', false, '1.0.0' );
       }

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/*
 * Getled menu functions file 
 *  */
require get_template_directory(). '/inc/getledmenu.php';

// getled hooks 
// getled_under_header 



