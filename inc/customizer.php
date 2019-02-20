<?php
/**
 * getled Theme Customizer
 *
 * @package getled
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 *
 */

// Sanitize text
function sanitize_text( $text ) {
	return sanitize_text_field( $text );
}

function getled_customize_register( $wp_customize ) {

	//var_dump($wp_customize->sections());

	// Cutomize title and tagline sections and labels

	$wp_customize->get_section( 'title_tagline' )->title = __( 'Site Name, Description & Logo', 'getledcustomizer' );

	$wp_customize->get_control( 'blogname' )->label            = __( 'Site Name', 'getledcustomizer' );
	$wp_customize->get_control( 'blogdescription' )->label     = __( 'Site Description', 'getledcustomizer' );
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Customize the Front Page Settings

	$wp_customize->get_section( 'static_front_page' )->title    = __( 'Homepage Preferences', 'getledcustomizer' );
	$wp_customize->get_section( 'static_front_page' )->priority = 20;

	$wp_customize->get_control( 'show_on_front' )->label  = __( 'Choose Homepage Preference', 'getledcustomizer' );
	$wp_customize->get_control( 'page_on_front' )->label  = __( 'Select Homepage', 'getledcustomizer' );
	$wp_customize->get_control( 'page_for_posts' )->label = __( 'Select Blog Homepage', 'getledcustomizer' );

	$wp_customize->get_section( 'header_image' )->title   = __( 'Main Front Page Image', 'getledcustomizer' );
	$wp_customize->get_control( 'header_image' )->label   = __( 'Main Front Page Image', 'getledcustomizer' );
	$wp_customize->get_control( 'header_image' )->section = 'static_front_page';
	// Customize Background Settings
	$wp_customize->get_section( 'background_image' )->title   = __( 'Background Styles', 'getledcustomizer' );
	$wp_customize->get_control( 'background_color' )->section = 'background_image';

	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Add Top 3 Promotions

	// create class to define textarea controls in Customizr.


	// end

	//Section
	$wp_customize->add_section( 'top_promotions', array(
		'title'    => __( 'Change Text and Colors of Top Promo links', 'getledcustomizer' ),
		'panel'    => 'general_settings',
		'priority' => 20
	) );

	//Section
	$wp_customize->add_section( 'shopping_cart', array(
		'title'    => __( 'Shopping Cart', 'getledcustomizer' ),
		'panel'    => 'general_settings',
		'priority' => 20
	) );
	
    
	// Top 3 on or off toggle

	$checkboxs [] = array(
		'slug'     => 'toponetoggle',
		'default'  => true,
		'label'    => __( 'Show Top One (only this one shows up on mobile)', 'getledcustomizer' ),
		'type'     => 'checkbox',
		'priority' => 5
	);

	$checkboxs [] = array(
		'slug'     => 'toptwotoggle',
		'default'  => true,
		'label'    => __( 'Show Top Two', 'getledcustomizer' ),
		'type'     => 'checkbox',
		'priority' => 6
	);

	$checkboxs [] = array(
		'slug'     => 'topthreetoggle',
		'default'  => true,
		'label'    => __( 'Show Top Three', 'getledcustomizer' ),
		'type'     => 'checkbox',
		'priority' => 7
	);

	foreach ( $checkboxs as $checkbox ) {

		// settings

		$wp_customize->add_setting(
			$checkbox['slug'], array(
				'default' => $checkbox ['default'],


			)
		);

		//controls

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				$checkbox ['slug'],
				array(
					'label'    => $checkbox ['label'],
					'section'  => 'top_promotions',
					'type'     => $checkbox ['type'],
					'settings' => $checkbox['slug'],
					'priority' => $checkbox ['priority']
				)
			) );

	}

	// Top Headers 1, 2 & 3 Header text

	$toptexts[] = array(
		'slug'     => 'top_one_header',
		'default'  => __( 'Promo 1', 'getledcustomizer' ),
		'label'    => __( 'Promo 1 - Header', 'getledcustomizer' ),
		'priority' => 10
	);

	$toptexts[] = array(
		'slug'     => 'top_two_header',
		'default'  => __( 'Promo 2', 'getledcustomizer' ),
		'label'    => __( 'Promo 2 - Header', 'getledcustomizer' ),
		'priority' => 70
	);

	$toptexts[] = array(
		'slug'     => 'top_three_header',
		'default'  => __( 'Promo 3', 'getledcustomizer' ),
		'label'    => __( 'Promo 3 - Header', 'getledcustomizer' ),
		'priority' => 130
	);

	// Top paragraph's 1, 2 & 3 text

	$toptexts[] = array(
		'slug'     => 'top_one_text',
		'default'  => __( 'I am text for top one', 'getledcustomizer' ),
		'label'    => __( 'Promo 1 - Paragraph text', 'getledcustomizer' ),
		'priority' => 20
	);

	$toptexts[] = array(
		'slug'     => 'top_two_text',
		'default'  => __( 'I am text for top two', 'getledcustomizer' ),
		'label'    => __( 'Promo 2 - Paragraph text', 'getledcustomizer' ),
		'priority' => 80
	);

	$toptexts[] = array(
		'slug'     => 'top_three_text',
		'default'  => __( 'I am text for top three', 'getledcustomizer' ),
		'label'    => __( 'Promo 3 - Paragraph text', 'getledcustomizer' ),
		'priority' => 140
	);

	//Top link texts 1, 2 & 3

	$toplinks[] = array(
		'slug'     => 'top_one_link',
		'default'  => __( 'link 1 here', 'getledcustomizer' ),
		'label'    => __( 'Promo 1 - Link', 'getledcustomizer' ),
		'priority' => 30
	);

	$toplinks[] = array(
		'slug'     => 'top_two_link',
		'default'  => __( 'link 2 here', 'getledcustomizer' ),
		'label'    => __( 'Promo 2 - Link', 'getledcustomizer' ),
		'priority' => 90
	);

	$toplinks[] = array(
		'slug'     => 'top_three_link',
		'default'  => __( 'link 3 here', 'getledcustomizer' ),
		'label'    => __( 'Promo 3 - Link', 'getledcustomizer' ),
		'priority' => 150
	);

	// add settings and controls for each header and paragraph text

	foreach ( $toptexts as $toptext ) {

		// settings

		$wp_customize->add_setting(
			$toptext['slug'], array(
				'default'           => $toptext ['default'],
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text',
			)
		);

		//controls

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				$toptext ['slug'],
				array(
					'label'    => $toptext ['label'],
					'section'  => 'top_promotions',
					'type'     => 'text',
					'settings' => $toptext['slug'],
					'priority' => $toptext ['priority']
				)
			) );

	}

	foreach ( $toplinks as $toplink ) {

		// settings

		$wp_customize->add_setting(
			$toplink['slug'], array(
				'default'           => $toplink ['default'],
				'sanitize_callback' => 'sanitize_text',
			)
		);

		//controls

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				$toplink ['slug'],
				array(
					'label'    => $toplink ['label'],
					'section'  => 'top_promotions',
					'type'     => 'text',
					'settings' => $toplink['slug'],
					'priority' => $toplink ['priority']
				)
			) );

	}

	// Background color 1,2,3

	$color_controls[] = array(
		'slug'     => 'top_one_bg_color',
		'default'  => '#C6F0ED',
		'label'    => __( 'Promo 1  - Background Color', 'getledcustomizer' ),
		'priority' => 40
	);

	$color_controls[] = array(
		'slug'     => 'top_two_bg_color',
		'default'  => '#F3D0D2',
		'label'    => __( 'Promo 2  - Background Color', 'getledcustomizer' ),
		'priority' => 100
	);

	$color_controls [] = array(
		'slug'     => 'top_three_bg_color',
		'default'  => '#FFFFFF',
		'label'    => __( 'Promo 3  - Background Color', 'getledcustomizer' ),
		'priority' => 160
	);

	// Header colors 1,2,3

	$color_controls[] = array(
		'slug'     => 'top_one_header_color',
		'default'  => '#000000',
		'label'    => __( 'Promo 1 - Header Text Color', 'getledcustomizer' ),
		'priority' => 50
	);

	$color_controls[] = array(
		'slug'     => 'top_two_header_color',
		'default'  => '#000000',
		'label'    => __( 'Promo 2 - Header Text Color', 'getledcustomizer' ),
		'priority' => 110
	);

	$color_controls[] = array(
		'slug'     => 'top_three_header_color',
		'default'  => '#000000',
		'label'    => __( 'Promo 3 - Header Text Color', 'getledcustomizer' ),
		'priority' => 170
	);

	// Text color 1,2,3

	$color_controls[] = array(
		'slug'     => 'top_one_text_color',
		'default'  => '#000000',
		'label'    => __( 'Promo 1 - Paragraph Text Color', 'getledcustomizer' ),
		'priority' => 60
	);

	$color_controls[] = array(
		'slug'     => 'top_two_text_color',
		'default'  => '#000000',
		'label'    => __( 'Promo 2 - Paragraph Text Color', 'getledcustomizer' ),
		'priority' => 120
	);

	$color_controls[] = array(
		'slug'     => 'top_three_text_color',
		'default'  => '#000000',
		'label'    => __( 'Promo 3 - Paragraph Text Color', 'getledcustomizer' ),
		'priority' => 180
	);

	$color_controls[] = array(
		'slug'    => 'product_category_description_bg',
		'default' => '#ffe7f4',
		'section' => 'getled_woocommerce',
		'label'   => __( 'Product category description background', 'getledcustomizer' ),
	);

	$color_controls[] = array(
		'slug'    => 'product_category_description_color',
		'default' => '#322',
		'section' => 'getled_woocommerce',
		'label'   => __( 'Product category description font color', 'getledcustomizer' ),
	);

	// Section -  For Design Settings ---> Colors - Will control, Category background colors and footer background colors

	$wp_customize->add_section( 'colors', array(
		'title' => __( 'Colors', 'getled' ),
		'panel'  => 'design_settings',
		

	));

	// Woocommerce Product Category Background color

	$bgcolor_controls[] = array(
		'slug'     => 'cat_bg_color',
		'default'  => '#FFE2E6',
		'label'    => __( 'Product Category Description  - Background Color', 'getled' ),
		'priority' => 10
	);

	$bgcolor_controls[] = array(
		'slug'     => 'cat_colortext',
		'default'  => '#322',
		'label'    => __( 'Product Category Description  - Text Color', 'getled' ),
		'priority' => 15
	);

	// Footer Top Background Color

	$bgcolor_controls[] = array(
		'slug'     => 'footer_bg_color1',
		'default'  => '#FFE2E6',
		'label'    => __( 'Footer Area Top  - Background Color', 'getled' ),
		'priority' => 20
	);

	// Footer Top Text Color

	$bgcolor_controls[] = array(
		'slug'     => 'footer_text_color1',
		'default'  => '#555',
		'label'    => __( 'Footer Area Top  - Text Color', 'getled' ),
		'priority' => 25
	);

	// Footer Bottom Background Color

	$bgcolor_controls[] = array(
		'slug'     => 'footer_bg_color2',
		'default'  => '#FFE2E6',
		'label'    => __( 'Footer Area Bottom  - Background Color', 'getled' ),
		'priority' => 30
	);

    // Footer Bottom Text Color

	$bgcolor_controls[] = array(
		'slug'     => 'footer_text_color2',
		'default'  => '#555',
		'label'    => __( 'Footer Area Bottom  - Text Color', 'getled' ),
		'priority' => 35
	);

	// for each loop for the three bg colors above

	foreach ( $bgcolor_controls as $bgcolor_control ) {

		// settings

		$wp_customize->add_setting(
			$bgcolor_control['slug'], array(
				'default' => $bgcolor_control['default'],
				'type'    => 'option'
			)
		);

		//controls
		
		$wp_customize->add_control( new WP_Customize_Color_Control( 
			$wp_customize, 
			$bgcolor_control ['slug'], 
			array (
				'label' => $bgcolor_control ['label'],
				'section' => 'colors',
				'settings' => $bgcolor_control ['slug']
				)
			));
	}

	// END of code for Design Settings ---> Colors - Will control, Category background colors and footer background colors


	// Create custom panels
	$wp_customize->add_panel( 'general_settings', array(
		'priority'       => 10,
		'theme_supports' => '',
		'title'          => __( 'General Settings', 'getledcustomizer' ),
		'description'    => __( 'Controls the basic settings for Getled.', 'getledcustomizer' ),
	) );
	$wp_customize->add_panel( 'design_settings', array(
		'priority'       => 20,
		'theme_supports' => '',
		'title'          => __( 'Design Settings', 'getledcustomizer' ),
		'description'    => __( 'Controls the basic design settings for the Getled.', 'getledcustomizer' ),
	) );

	// Assign sections to panels
	$wp_customize->get_section( 'title_tagline' )->panel       = 'general_settings';
	$wp_customize->get_section( 'static_front_page' )->panel   = 'general_settings';
	$wp_customize->get_section( 'custom_css' )->panel          = 'design_settings';
	$wp_customize->get_section( 'background_image' )->panel    = 'design_settings';
	$wp_customize->get_section( 'background_image' )->priority = 1000;
	$wp_customize->get_section( 'colors' )->panel              = 'design_settings';
}


	
add_action( 'customize_register', 'getled_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function getled_customize_preview_js() {
	wp_enqueue_script( 'getled_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}

add_action( 'customize_preview_init', 'getled_customize_preview_js' );

if ( ! function_exists( 'getled_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see getled_custom_header_setup().
	 */
	function getled_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
			<?php
				// Has the text been hidden?
				if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}

			<?php
				// If the user has set a custom color for the text use that.
				else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
            .site-description {
				color: #<?php echo esc_attr( $header_text_color );?>! important ;
			}
			<?php endif; ?>
		</style>
		<?php
	}
endif;
function getled_top_three_promo() {

	//define top 3 headers
	$topheader1 = get_theme_mod( 'top_one_header','top header text' );
	$topheader2 = get_theme_mod( 'top_two_header' ,'top two text');
	$topheader3 = get_theme_mod( 'top_three_header','top three text' );
	//define top 3 paragraph texts
	$topparagraph1 = get_theme_mod( 'top_one_text','top one paragraph' );
	$topparagraph2 = get_theme_mod( 'top_two_text','top two paragraph' );
	$topparagraph3 = get_theme_mod( 'top_three_text' ,'top three paragraph' );
	//define top 3 links
	$toplink1 = get_theme_mod( 'top_one_link' );
	$toplink2 = get_theme_mod( 'top_two_link' );
	$toplink3 = get_theme_mod( 'top_three_link' );

	// div containing all the top three

	echo '<div class="topthree">';

	//First Top 1
	if ( get_theme_mod( 'toponetoggle' ) != "" ):
		echo '<div class="first">';
		echo '<a href="' . $toplink1 . ' ">';
		echo '<h3 class="top-promotion1">';
		echo $topheader1;
		echo '</h3>';
		echo '<p class="top-promo1-text">';
		echo $topparagraph1;
		echo '</p>';
		echo '</a>';
		echo '</div>';

	endif;
	//Second Top 2
	if ( get_theme_mod( 'toptwotoggle' ) != "" ):
		echo '<div class="second">';
		echo '<a href="' . $toplink2 . ' ">';
		echo '<h3 class="top-promotion2">';
		echo $topheader2;
		echo '</h3>';
		echo '<p class="top-promo2-text">';
		echo $topparagraph2;
		echo '</p>';
		echo '</a>';
		echo '</div>';

	endif;
	//Second Top 3

	if ( get_theme_mod( 'topthreetoggle' ) != "" ):
		echo '<div class="third">';
		echo '<a href="' . $toplink3 . ' ">';
		echo '<h3 class="top-promotion3">';
		echo $topheader3;
		echo '</h3>';
		echo '<p class="top-promo3-text">';
		echo $topparagraph3;
		echo '</p>';
		echo '</a>';
		echo '</div>';

	endif;
	// end div for all top three

	echo '</div>';


}


add_action( 'getled_under_header', 'getled_top_three_promo' );

/* customier option */
add_action( 'customize_register', 'getled_customizer_controls' );


// Function to output style Design Settings ---> Colors - Will control, Category background colors and footer background colors

function getled_bgcolor_css() {
	
	// Woocommerce Product Category Background color and Footer Background colors 
	// Define Colors

	$color_bgcat = get_option('cat_bg_color');
	$color_cattext = get_option('cat_colortext');
	$color_bgfooter1 = get_option('footer_bg_color1');
	$color_bgfooter2 = get_option('footer_bg_color2');
	$color_bgfootertext1 = get_option('footer_text_color1');
	$color_bgfootertext2 = get_option('footer_text_color2');
	// Add classes for Product Category Background color and Footer Background colors 

	?>

	<style>

	/*woocommerce category description background color*/
		header.woocommerce-products-header {
			background-color: <?php echo $color_bgcat; ?>!important;
			color: <?php echo $color_cattext; ?>!important;
		}

	/*footer top background and Text color*/
		.footer-email {
			background-color: <?php echo $color_bgfooter1; ?>;
		}

		.footer-email .widget, .footer-email .widget-title, .footer-email .widget a, .footer-email .widget_calendar thead, .footer-email .rss-date, .footer-email .widget_rss cite {
    		color: <?php echo $color_bgfootertext1; ?>;
		}

	/*footer top background color*/
		.footer-widgets {
			background-color: <?php echo $color_bgfooter2; ?>;
		}

	/*footer bottom background color*/
	.footer-widgets .widget, .footer-widgets .widget-title, .footer-widgets .widget a, .footer-widgets .widget_calendar thead, .footer-widgets .rss-date, .footer-widgets .widget_rss cite {

			color: <?php echo $color_bgfootertext2; ?>!important;
		}

	</style>


<?php }
 
 add_action( 'wp_head', 'getled_bgcolor_css' );

//END function Design Settings ---> Colors - Will control, Category background colors and footer background colors

/**
 * @param WP_Customize_Manager $man
 */
function getled_button_customizer_controls( $man ) {
	$man->add_section(
		'getled_buttons',
		array(
			'title'       => __( 'Buttons', 'getled' ),
			'priority'    => 100,
			'capability'  => 'edit_theme_options',
			'description' => __( 'Customize buttons\' appearance.', 'getled' ),
		)
	);

	$man->add_setting( 'getled_button_color', [ 'default' => '#04aa5b' ] );
	$man->add_control( new WP_Customize_Color_Control(
		$man,
		'getled_button_color',
		array(
			'label'    => __( 'Primary Button Color', 'getled' ),
			'section'  => 'getled_buttons',
			'settings' => 'getled_button_color',
			'priority' => 10,
		)
	) );

	$man->add_setting( 'getled_button_text_color', [ 'default' => '#fff' ] );
	$man->add_control( new WP_Customize_Color_Control(
		$man,
		'getled_button_text_color',
		array(
			'label'    => __( 'Primary Button Text Color', 'getled' ),
			'section'  => 'getled_buttons',
			'settings' => 'getled_button_text_color',
			'priority' => 10,
		)
	) );

	$man->add_setting( 'getled_button_hover_color', [ 'default' => '#03a050' ] );
	$man->add_control( new WP_Customize_Color_Control(
		$man,
		'getled_button_hover_color',
		array(
			'label'    => __( 'Primary Button Hover Color', 'getled' ),
			'section'  => 'getled_buttons',
			'settings' => 'getled_button_hover_color',
			'priority' => 10,
		)
	) );

	$man->add_setting( 'getled_button_hover_text_color', [ 'default' => '#fff' ] );
	$man->add_control( new WP_Customize_Color_Control(
		$man,
		'getled_button_hover_text_color',
		array(
			'label'    => __( 'Primary Button Hover Text Color', 'getled' ),
			'section'  => 'getled_buttons',
			'settings' => 'getled_button_hover_text_color',
			'priority' => 10,
		)
	) );


	$man->add_setting( 'getled_button_secondary_color', [ 'default' => '#444' ] );
	$man->add_control( new WP_Customize_Color_Control(
		$man,
		'getled_button_secondary_color',
		array(
			'label'    => __( 'Secondary Button Color', 'getled' ),
			'section'  => 'getled_buttons',
			'settings' => 'getled_button_secondary_color',
			'priority' => 10,
		)
	) );

	$man->add_setting( 'getled_button_secondary_text_color', [ 'default' => '#fff' ] );
	$man->add_control( new WP_Customize_Color_Control(
		$man,
		'getled_button_secondary_text_color',
		array(
			'label'    => __( 'Secondary Button Text Color', 'getled' ),
			'section'  => 'getled_buttons',
			'settings' => 'getled_button_secondary_text_color',
			'priority' => 10,
		)
	) );

	$man->add_setting( 'getled_button_secondary_hover_color', [ 'default' => '#212121' ] );
	$man->add_control( new WP_Customize_Color_Control(
		$man,
		'getled_button_secondary_hover_color',
		array(
			'label'    => __( 'Secondary Button Hover Color', 'getled' ),
			'section'  => 'getled_buttons',
			'settings' => 'getled_button_secondary_hover_color',
			'priority' => 10,
		)
	) );

	$man->add_setting( 'getled_button_secondary_hover_text_color', [ 'default' => '#fff' ] );
	$man->add_control( new WP_Customize_Color_Control(
		$man,
		'getled_button_secondary_hover_text_color',
		array(
			'label'    => __( 'Secondary Button Hover Text Color', 'getled' ),
			'section'  => 'getled_buttons',
			'settings' => 'getled_button_secondary_hover_text_color',
			'priority' => 10,
		)
	) );

	$man->add_setting( 'getled_button_lr_padding', [ 'default' => 16 ] );
	$man->add_control(
		'getled_button_lr_padding',
		[
			'label'    => __( 'Button left/right padding', 'getled' ),
			'section'  => 'getled_buttons',
			'settings' => 'getled_button_lr_padding',
			'type'     => 'number',
		]
	);

	$man->add_setting( 'getled_button_tb_padding', [ 'default' => 11 ] );
	$man->add_control(
		'getled_button_tb_padding',
		[
			'label'    => __( 'Button top/bottom padding', 'getled' ),
			'section'  => 'getled_buttons',
			'settings' => 'getled_button_tb_padding',
			'type'     => 'number',
		]
	);

	$man->add_setting( 'getled_button_rounded_corners', [ 'default' => 2 ] );
	$man->add_control(
		'getled_button_rounded_corners',
		[
			'label'    => __( 'Button rounded corners', 'getled' ),
			'section'  => 'getled_buttons',
			'settings' => 'getled_button_rounded_corners',
			'type'     => 'number',
		]
	);
}

/**
 * Code for range slider
 */
 if( class_exists( 'WP_Customize_Control' ) ) {
	class WP_Customize_Range extends WP_Customize_Control {
		public $type = 'range';

        public function __construct( $manager, $id, $args = array() ) {
            parent::__construct( $manager, $id, $args );
            $defaults = array(
                'min' => 30,
                'max' => 50,
                'step' => 1
            );
            $args = wp_parse_args( $args, $defaults );

            $this->min = $args['min'];
            $this->max = $args['max'];
            $this->step = $args['step'];
            $this->setting =$args['setting'];
        }

		public function render_content() {
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<input class='range-slider' min="<?php echo $this->min ?>" max="<?php echo $this->max ?>" step="<?php echo $this->step ?>" type='range' <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" oninput="jQuery(this).next('input').val( jQuery(this).val() )">
			<?php if($this->setting == 'getled_top_icon_size'){?>
            <input type="number" readonly min="<?php echo $this->min ?>" max="<?php echo $this->max ?>" data-customize-setting-link="<?php echo $this->setting ?>" type='text' value='<?php echo esc_attr( $this->value() ); ?>'>
            <?php } else { ?>
			<input type="number"  data-customize-setting-link="<?php echo $this->setting ?>" type='text' value='<?php echo esc_attr( $this->value() ); ?>'>
	        <?php } ?>
      </label>
   <?php
       }
    }
}

/**
 * @param WP_Customize_Manager $wp_customize
 */
function getled_customizer_controls( $wp_customize ) {

	getled_button_customizer_controls( $wp_customize );

	$wp_customize->add_section(
		'getled_menu_options',
		array(
			'title'       => __( 'Primary Menu Settings', 'getled' ),
			'priority'    => 100,
			'capability'  => 'edit_theme_options',
			'description' => __( 'Change menu options here.', 'getled' ),
		)
	);

    
	$wp_customize->add_setting( 'getled_menu_color',
		array(
			'default' => 'f1f1f1'
		)
	);

	$wp_customize->add_setting( 'getled_menu_bg_color',
		array(
			'default' => 'f1f1f1'
		)
	);

	$wp_customize->add_setting( 'getled_menu_bg_color_hover',
		array(
			'default' => 'f1f1f1'
		)
	);
    //code for primary menu link hover color and font size
	$wp_customize->add_setting( 'getled_primary_menu_link_font_size',
		array(
			'default' => '20'
		)
	);
    $wp_customize->add_setting( 'getled_menu_link_color_hover',
		array(
			'default' => 'f1f1f1'
		)
	);
	$wp_customize->add_control( new WP_Customize_Range( $wp_customize, 'getled_primary_menu_link_font_size', array(
	'label'    => __( 'Menu Link Font Size ', 'getled' ),
    'min' => 10,
    'max' => 100,
    'step' => 10,
    'setting'=> 'getled_primary_menu_link_font_size',
	'section' => 'getled_menu_options',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'getled_menu_link_color_hover',
		array(
			'label'    => __( 'Menu Link Color on Hover', 'getled' ),
			'section'  => 'getled_menu_options',
			'settings' => 'getled_menu_link_color_hover',
			'priority' => 10,
		)
	) );
	$wp_customize->add_setting( 'getled_menu_title_iconclass_setting',
		array(
			'default' => 'fa fa-bars'
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'getled_menu_color_control',
		array(
			'label'    => __( 'Menu Text Color', 'getled' ),
			'section'  => 'getled_menu_options',
			'settings' => 'getled_menu_color',
			'priority' => 10,
		)
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'getled_menu_bg_color_control',
		array(
			'label'    => __( 'Menu Background Color', 'getled' ),
			'section'  => 'getled_menu_options',
			'settings' => 'getled_menu_bg_color',
			'priority' => 10,
		)
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'getled_menu_bg_color_hover_control',
		array(
			'label'    => __( 'Menu Background Color on Hover', 'getled' ),
			'section'  => 'getled_menu_options',
			'settings' => 'getled_menu_bg_color_hover',
			'priority' => 10,
		)
	) );
	$wp_customize->add_control(
		'getled_menu_title_iconclass_setting',
		array(
			'label'    => __( 'Menu Icon (Fontawesome Class)', 'getled' ),
			'section'  => 'getled_menu_options',
			'settings' => 'getled_menu_title_iconclass_setting',
			'type'     => 'text',
		) );
	//secondary menu settings
	$wp_customize->add_section(
		'getled_secondary_menu_options',
		array(
			'title'       => __( 'Secondary Menu Settings', 'getled' ),
			'priority'    => 100,
			'capability'  => 'edit_theme_options',
			'description' => __( 'Change secondary menu options here.', 'getled' ),
		)
	);
    $wp_customize->add_setting( 'getled_secondary_menu_link_font_size',
		array(
			'default' => '20'
		)
	);
	$wp_customize->add_setting( 'getled_secondary_menu_link_color',
		array(
			'default' => '000000'
		)
	);

	$wp_customize->add_setting( 'getled_secondary_menu_bg_color',
		array(
			'default' => 'f1f1f1'
		)
	);

	$wp_customize->add_setting( 'getled_secondary_menu_link_color_hover',
		array(
			'default' => 'f1f1f1'
		)
	);
	$wp_customize->add_setting( 'getled_secondary_menu_bg_color_hover',
		array(
			'default' => 'f1f1f1'
		)
	);
	$wp_customize->add_control( new WP_Customize_Range( $wp_customize, 'getled_secondary_menu_link_font_size',
		array(
			'label'    => __( 'Menu Link Font Size ', 'getled' ),
			'min' => 10,
			'max' => 100,
			'step' => 10,
			'setting'=> 'getled_secondary_menu_link_font_size',
			'section' => 'getled_secondary_menu_options',
		)
	) );

    $wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'getled_secondary_menu_link_color',
		array(
			'label'    => __( 'Menu Link Color', 'getled' ),
			'section'  => 'getled_secondary_menu_options',
			'settings' => 'getled_secondary_menu_link_color',
			'priority' => 10,
		)
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'getled_secondary_menu_bg_color',
		array(
			'label'    => __( 'Secondary Menu Background Color', 'getled' ),
			'section'  => 'getled_secondary_menu_options',
			'settings' => 'getled_secondary_menu_bg_color',
			'priority' => 10,
		)
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'getled_secondary_menu_link_color_hover',
		array(
			'label'    => __( 'Menu link Color on Hover', 'getled' ),
			'section'  => 'getled_secondary_menu_options',
			'settings' => 'getled_secondary_menu_link_color_hover',
			'priority' => 10,
		)
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'getled_secondary_menu_bg_color_hover',
		array(
			'label'    => __( 'Menu Background Color on Hover', 'getled' ),
			'section'  => 'getled_secondary_menu_options',
			'settings' => 'getled_secondary_menu_bg_color_hover',
			'priority' => 10,
		)
	) );
	//middle menu setting
	$wp_customize->add_section(
		'getled_middle_menu_options',
		array(
			'title'       => __( 'Middle Menu Settings', 'getled' ),
			'priority'    => 100,
			'capability'  => 'edit_theme_options',
			'description' => __( 'Change middle menu options here.', 'getled' ),
		)
	);
    $wp_customize->add_setting( 'getled_middle_menu_enable',
		array(
			'default' => ''
		)
	);
	$wp_customize->add_setting( 'getled_middle_menu_link_color',
		array(
			'default' => '000000'
		)
	);

	$wp_customize->add_setting( 'getled_middle_menu_bg_color',
		array(
			'default' => 'f1f1f1'
		)
	);

	$wp_customize->add_setting( 'getled_middle_menu_link_color_hover',
		array(
			'default' => 'f1f1f1'
		)
	);
	$wp_customize->add_setting( 'getled_middle_menu_signin_link',
		array(
			'default' => ''
		)
	);
	$wp_customize->add_setting( 'getled_middle_menu_register_link',
		array(
			'default' => ''
		)
	);
	$wp_customize->add_control(
		'getled_middle_menu_enable',
		array(
			'label'    => __( 'Enable Middle Menu', 'getled' ),
			'section'  => 'getled_middle_menu_options',
			'settings' => 'getled_middle_menu_enable',
			'type'     => 'checkbox',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'getled_middle_menu_link_color',
		array(
			'label'    => __( 'Menu Link Color', 'getled' ),
			'section'  => 'getled_middle_menu_options',
			'settings' => 'getled_middle_menu_link_color',
			'priority' => 10,
		)
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'getled_middle_menu_bg_color',
		array(
			'label'    => __( 'Menu Background Color', 'getled' ),
			'section'  => 'getled_middle_menu_options',
			'settings' => 'getled_middle_menu_bg_color',
			'priority' => 10,
		)
	) );
    $wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'getled_middle_menu_link_color_hover',
		array(
			'label'    => __( 'Menu link Color on Hover', 'getled' ),
			'section'  => 'getled_middle_menu_options',
			'settings' => 'getled_middle_menu_link_color_hover',
			'priority' => 10,
		)
	) );
	$wp_customize->add_control(
		'getled_middle_menu_signin_link',
		array(
			'label'    => __( 'Sign In Link', 'getled' ),
			'section'  => 'getled_middle_menu_options',
			'settings' => 'getled_middle_menu_signin_link',
			'type'     => 'text',
		) );
	$wp_customize->add_control(
		'getled_middle_menu_register_link',
		array(
			'label'    => __( 'Register LInk', 'getled' ),
			'section'  => 'getled_middle_menu_options',
			'settings' => 'getled_middle_menu_register_link',
			'type'     => 'text',
		) );
	//code for header settings
    $wp_customize->add_section(
		'getled_header_settings_option',
		array(
			'title'    => __( 'Header Settings', 'getled' ),
			'panel'    => 'general_settings',
			'priority'    => 100,
			'capability'  => 'edit_theme_options',
			'description' => __( 'Change Header settings here.', 'getled' ),
		)
	);

    
	$wp_customize->add_setting( 'getled_header_bg_color',
		array(
			'default' => 'f1f1f1'
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'getled_header_bg_color',
		array(
			'label'    => __( 'Header Background Color', 'getled' ),
			'section'  => 'getled_header_settings_option',
			'settings' => 'getled_header_bg_color',
			'priority' => 10,
		)
	) );
    $wp_customize->add_setting( 'getled_header_height' , array(
    'default'     => 100,
    'transport'   => 'refresh',
     ) );
	$wp_customize->add_control( new WP_Customize_Range( $wp_customize, 'getled_header_height',
		array(
			'label'	=>  __( 'Header Height(In Px)', 'getled' ),
			'min' => 100,
			'max' => 500,
			'step' => 10,
			'setting'=>'getled_header_height',
			'section' => 'getled_header_settings_option',
		)
	) );
   $wp_customize->add_setting( 'getled_header_bottom_border_color',
		array(
			'default' => 'f1f1f1'
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'getled_header_bottom_border_color',
		array(
			'label'    => __( 'Header Bottom Border Color', 'getled' ),
			'section'  => 'getled_header_settings_option',
			'settings' => 'getled_header_bottom_border_color',
			'priority' => 10,
		)
	) );
    $wp_customize->add_setting( 'getled_header_bottom_border_width',array( 'default' => 1 ) );
		
	$wp_customize->add_control( 
		'getled_header_bottom_border_width',
		array(
			'label'    => __( 'Header Bottom Border Width(In Px)', 'getled' ),
			'section'  => 'getled_header_settings_option',
			'settings' => 'getled_header_bottom_border_width',
			'type'     => 'number',
		)
	);
		
	//my account section 
	$wp_customize->add_section(
		'getled_top_icon',
		array(
			'title'       => __( 'Top Icons', 'getled' ),
			'panel'    => 'general_settings',
			'priority'    => 100,
			'capability'  => 'edit_theme_options',
			'description' => __( 'Top Icon Setting.', 'getled' ),
		)
	);
    $wp_customize->add_setting( 'getled_my_account_icon_url');
		
	$wp_customize->add_control( 
		'getled_my_account_icon_url',
		array(
			'label'    => __( 'My Account Icon Url', 'getled' ),
			'section'  => 'getled_top_icon',
			'settings' => 'getled_my_account_icon_url',
			'type'     => 'text',
		)
	);
		
    $wp_customize->add_setting( 'getled_my_account_page_url');
		
	$wp_customize->add_control( 
		'getled_my_account_page_url',
		array(
			'label'    => __( 'My Account Page Url', 'getled' ),
			'section'  => 'getled_top_icon',
			'settings' => 'getled_my_account_page_url',
			'type'     => 'text',
		)
	);
	$wp_customize->add_setting( 'getled_top_icon_size' ,
		array(
			'default'     => 30,
			'transport'   => 'refresh',
		)
	);
    $wp_customize->add_control( new WP_Customize_Range( $wp_customize, 'getled_top_icon_size',
		array(
			'label'	=>  'Top Icon Size(PX)',
			'min' => 30,
			'max' => 60,
			'step' => 1,
			'setting'=>'getled_top_icon_size',
			'section' => 'getled_top_icon',
		)
	) );
	$wp_customize->add_setting( 'getled_my_account_icon_color',
		array(
			'default' => '#000000'
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'getled_my_account_icon_color',
		array(
			'label'    => __( 'My Account Icon Color', 'getled' ),
			'section'  => 'getled_top_icon',
			'settings' => 'getled_my_account_icon_color',
			'priority' => 10,
		)
	) );
	//code to set search icon color
	$wp_customize->add_setting( 'getled_search_icon_color',
		array(
			'default' => '000000'
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'getled_search_icon_color',
		array(
			'label'    => __( 'Search Icon Color ', 'getled' ),
			'section'  => 'getled_top_icon',
			'settings' => 'getled_search_icon_color',
			)
		));
	//code to set menu icon color
	$wp_customize->add_setting( 'getled_menu_icon_color',
		array(
			'default' => '000000'
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'getled_menu_icon_color',
		array(
			'label'    => __( 'Menu Icon Color ', 'getled' ),
			'section'  => 'getled_top_icon',
			'settings' => 'getled_menu_icon_color',
			)
		));
	//code to set shopping cart icon color
	$cart_controls[] = array(
		'slug'     => 'cart_text_color',
		'default'  => '#000000',
		'label'    => __( 'Cart Icon Color', 'getledcustomizer' ),
		'section'  => 'getled_top_icon',
		'priority' => 120
	);

	$cart_controls[] = array(
		'slug'     => 'cart_dd_text_color',
		'default'  => '#000000',
		'label'    => __( 'Drop down text color', 'getledcustomizer' ),
		'section'  => 'getled_top_icon',
		'priority' => 120
	);

	$cart_controls[] = array(
		'slug'     => 'cart_dd_bg_color',
		'default'  => '',
		'label'    => __( 'Drop down background color', 'getledcustomizer' ),
		'section'  => 'getled_top_icon',
		'priority' => 180
	);

	// add settings and controls for each color

	foreach ( $cart_controls as $control ) {

		// settings

		$wp_customize->add_setting(
			$control['slug'], array(
				'default' => $control ['default'],
				'type'    => 'option'
			)
		);

		//controls
		if ( empty( $control['section'] ) ) {
			$control['section'] = 'top_promotions';
		}
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $control ['slug'], $control ) );

	}
	// region WooCommerce settings
	$wp_customize->add_section(
		'getled_woocommerce',
		array(
			'title'    => __( 'Getled', 'getled' ),
			'priority' => 10,
			'panel'    => 'woocommerce',
		)
	);

	$wp_customize->add_setting( 'getled_product_delivery_info' );
	$wp_customize->add_control(
		'getled_product_delivery_info',
		array(
			'label'       => __( 'Delivery info', 'getled' ),
			'description' => __( 'Displayed on product details page', 'woocommerce' ),
			'section'     => 'getled_woocommerce',
			'settings'    => 'getled_product_delivery_info',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting( 'getled_product_delivery_label', [ 'default' => 'DELIVERY' ] );
	$wp_customize->add_control(
		'getled_product_delivery_label',
		array(
			'label'    => __( 'Delivery info label', 'getled' ),
			'section'  => 'getled_woocommerce',
			'settings' => 'getled_product_delivery_label',
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting( 'getled_product_returns_info' );
	$wp_customize->add_control(
		'getled_product_returns_info',
		array(
			'label'       => __( 'Returns info', 'getled' ),
			'description' => __( 'Displayed on product details page', 'woocommerce' ),
			'section'     => 'getled_woocommerce',
			'settings'    => 'getled_product_returns_info',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting( 'getled_product_returns_label', [ 'default' => 'RETURNS' ] );
	$wp_customize->add_control(
		'getled_product_returns_label',
		array(
			'label'    => __( 'Returns info label', 'getled' ),
			'section'  => 'getled_woocommerce',
			'settings' => 'getled_product_returns_label',
			'type'     => 'text',
		)
	);
	// endregion
	// Sections, settings and controls will be added here
}


add_action( 'wp_head', 'my_dynamic_css' );
function my_dynamic_css() {
	?>
	<style type='text/css'>
		@media screen and (max-width: 600px) {
			/* for responsive menu */
			#primary-menu, #primary-menu ul {
				background: <?php echo get_theme_mod( 'getled_menu_bg_color' ); ?>;
			}
		}

		body.getled .woocommerce #respond input#submit,
		body.getled .woocommerce .button,
		body.getled .button,
		body.getled .button.disabled,
		body.getled #respond input#submit {
			padding: <?php echo get_theme_mod( 'getled_button_tb_padding', 11 ); ?>px <?php echo get_theme_mod( 'getled_button_lr_padding', 16 ); ?>px;
			border-radius: <?php echo get_theme_mod( 'getled_button_rounded_corners', 2 ); ?>px;
			background-color: <?php echo get_theme_mod( 'getled_button_color', '#04aa5b' ); ?>;
			color: <?php echo get_theme_mod( 'getled_button_text_color', '#fff' ); ?>;
			font: 300 18px "Oswald","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Geneva,Arial,sans-serif;
			letter-spacing: 1px;
		}

		body.getled input:checked ~ span.getled-push-btn {
			color: <?php echo get_theme_mod( 'getled_button_color', '#04aa5b' ); ?>;
		}

		body.getled .button.disabled:hover,
		body.getled .button:hover,
		body.getled #respond input#submit:hover {
			background-color: <?php echo get_theme_mod( 'getled_button_hover_color', '#03a050' ); ?>;
			color: <?php echo get_theme_mod( 'getled_button_hover_text_color', '#fff' ); ?>;
		}

		body.getled #respond input#submit.alt,
		body.getled .button.alt.disabled,
		body.getled .button.alt {
			background-color: <?php echo get_theme_mod( 'getled_button_secondary_color', '#444' ); ?>;
			color: <?php echo get_theme_mod( 'getled_button_secondary_text_color', '#fff' ); ?>;
		}

		body.getled .button.disabled,
		body.getled .button.alt.disabled {
			opacity: .7;
		}


		body.getled #respond input#submit.alt:hover,
		body.getled .button.alt.disabled:hover,
		body.getled .button.alt:hover {
			background-color: <?php echo get_theme_mod( 'getled_button_secondary_hover_color', '#212121' ); ?>;
			color: <?php echo get_theme_mod( 'getled_button_secondary_hover_text_color', '#fff' ); ?>;
		}

		#primary-menu, #primary-menu a {
			color: <?php echo get_theme_mod( 'getled_menu_color' ) ?>;
		}
        #primary-menu .sub-menu { background: <?php echo get_theme_mod( 'getled_menu_bg_color' ,'#f1f1f1' ) ?>;}
        #primary-menu, #primary-menu > ul {
			background: <?php echo get_theme_mod( 'getled_menu_bg_color' ); ?>;
		}

		#primary-menu li:hover {
			background: <?php echo get_theme_mod( 'getled_menu_bg_color_hover' ); ?>
		}
		.site-header {
			background-color: <?php echo get_theme_mod( 'getled_header_bg_color','#ffffff' ); ?>;
			height: <?php echo get_theme_mod( 'getled_header_height','150'); ?>px;
			border-bottom-style: solid;
			border-bottom-width: <?php echo get_theme_mod( 'getled_header_bottom_border_width','1'); ?>px;
			border-bottom-color: <?php echo get_theme_mod( 'getled_header_bottom_border_color'); ?>;
        }
		.toggle-gmenu {
			border:none;
			font-size:<?php echo get_theme_mod( 'getled_top_icon_size','30'); ?>px !important;
			cursor:pointer;
			color:<?php echo get_theme_mod( 'getled_menu_icon_color'); ?>;
		}
		#secondary-menu, #secondary-menu a {
			color: <?php echo get_theme_mod( 'getled_secondary_menu_link_color' ) ?>;
		}
		#secondary-menu, #secondary-menu > ul {
			background: <?php echo get_theme_mod( 'getled_secondary_menu_bg_color','#f1f1f1' ); ?>;
		}
		#secondary-menu .sub-menu { background: <?php echo get_theme_mod( 'getled_secondary_menu_bg_color' ,'#f1f1f1' ) ?>;}
		#secondary-menu li a:hover {
			color: <?php echo get_theme_mod( 'getled_secondary_menu_link_color_hover','#f26565' ); ?>
		}
		#secondary-menu li:hover {
			background: <?php echo get_theme_mod( 'getled_secondary_menu_bg_color_hover' ); ?>
		}
		#secondary-menu li a {
			font-size: <?php echo get_theme_mod( 'getled_secondary_menu_link_font_size' ); ?>px !important;
		}
		#primary-menu li a:hover {
			color: <?php echo get_theme_mod( 'getled_menu_link_color_hover','#f26565' ); ?>
		}
		#primary-menu li a {
			font-size: <?php echo get_theme_mod( 'getled_primary_menu_link_font_size' ); ?>px !important;
		}
		#middle-menu {
			background: <?php echo get_theme_mod( 'getled_middle_menu_bg_color' ,'#f1f1f1'); ?>
		}
		#middle-menu a {
			color: <?php echo get_theme_mod( 'getled_middle_menu_link_color' ); ?>
		}
		#middle-menu a:hover {
			color: <?php echo get_theme_mod( 'getled_middle_menu_link_color_hover' ); ?>
		}
		#middle-menu span { color: #000000; }
		.myaccount a i {
			font-size: <?php echo get_theme_mod( 'getled_top_icon_size','30' ); ?>px !important;
			color: <?php echo get_theme_mod( 'getled_my_account_icon_color','#555555' ); ?> !important;
		}
		.cart-contents, .site-header-cart .cart-contents:after { font-size: <?php echo get_theme_mod( 'getled_top_icon_size','30' ); ?>px !important; }
		.site-header .header-right-icons .myaccount img {
			 max-width :none !important;
			 width: <?php echo get_theme_mod( 'getled_top_icon_size','30' ); ?>px !important;
		}
		.custom-searchbox #site-header-search-custom i {
			 font-size: <?php echo get_theme_mod( 'getled_top_icon_size','30' ); ?>px !important;
			 color: <?php echo get_theme_mod( 'getled_search_icon_color' ); ?> !important;
		}
	    <?php getled_custom_colors(); ?>
	</style>
	<?php
}


function getled_custom_colors() {

	//define background colors
	$colortop_bg1 = get_option( 'top_one_bg_color','#C6F0ED' );
	$colortop_bg2 = get_option( 'top_two_bg_color','#F3D0D2' );
	$colortop_bg3 = get_option( 'top_three_bg_color','#d3c5e2' );
	//define header text colors
	$colortop_header1 = get_option( 'top_one_header_color' );
	$colortop_header2 = get_option( 'top_two_header_color' );
	$colortop_header3 = get_option( 'top_three_header_color' );
	//define p text settings
	$colortop_text1 = get_option( 'top_one_text_color' );
	$colortop_text2 = get_option( 'top_two_text_color' );
	$colortop_text3 = get_option( 'top_three_text_color' );

	$cart_text_color    = get_option( 'cart_text_color', '' );
	$cart_dd_text_color = get_option( 'cart_dd_text_color', '' );
	$cart_dd_bg_color   = get_option( 'cart_dd_bg_color', '' );

	//add classes

	$prod_cat_desc_bg    = get_option( 'product_category_description_bg', '#ffe7f4' );
	$prod_cat_desc_color = get_option( 'product_category_description_color', '#322' );
	?>
	.topthree .first { background-color: <?php echo $colortop_bg1; ?> }

	.topthree .second { background-color: <?php echo $colortop_bg2; ?> }

	.topthree .third { background-color: <?php echo $colortop_bg3; ?> }

	.topthree h3.top-promotion1 { color: <?php echo $colortop_header1; ?> }

	.topthree h3.top-promotion2 { color: <?php echo $colortop_header2; ?> }

	.topthree h3.top-promotion3 { color: <?php echo $colortop_header3; ?> }

	p.top-promo1-text { color: <?php echo $colortop_text1; ?> }

	p.top-promo2-text { color: <?php echo $colortop_text2; ?> }

	p.top-promo3-text { color: <?php echo $colortop_text3; ?> }

	a.cart-contents, .site-header-cart .cart-contents:after { color: <?php echo $cart_text_color; ?> }

	.site-header-cart .cart-contents .count { background-color: <?php echo $cart_text_color; ?> }

	#site-header-cart .total *, #site-header-cart .product_list_widget * { color: <?php echo $cart_dd_text_color; ?> }

	#site-header-cart .widget_shopping_cart { background: <?php echo $cart_dd_bg_color; ?> }

	#getled-filter-price .widget_price_filter .ui-slider .ui-slider-range,
	.tax-product_cat .woocommerce-products-header,
	a.getled-filter-link.active {
	background-color:<?php echo $prod_cat_desc_bg ?>;
	color:<?php echo $prod_cat_desc_color ?>;
	}
	<?php

}
