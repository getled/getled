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

	$color_controls[] = array(
		'slug'     => 'cart_text_color',
		'default'  => '#000000',
		'label'    => __( 'Cart text color', 'getledcustomizer' ),
		'section'  => 'shopping_cart',
		'priority' => 120
	);

	$color_controls[] = array(
		'slug'     => 'cart_dd_text_color',
		'default'  => '#000000',
		'label'    => __( 'Drop down text color', 'getledcustomizer' ),
		'section'  => 'shopping_cart',
		'priority' => 120
	);

	$color_controls[] = array(
		'slug'     => 'cart_dd_bg_color',
		'default'  => '',
		'label'    => __( 'Drop down background color', 'getledcustomizer' ),
		'section'  => 'shopping_cart',
		'priority' => 180
	);

	// add settings and controls for each color

	foreach ( $color_controls as $control ) {

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

			<?php endif; ?>
		</style>
		<?php
	}
endif;


function getled_top_three_promo() {

	//define top 3 headers
	$topheader1 = get_theme_mod( 'top_one_header' );
	$topheader2 = get_theme_mod( 'top_two_header' );
	$topheader3 = get_theme_mod( 'top_three_header' );
	//define top 3 paragraph texts
	$topparagraph1 = get_theme_mod( 'top_one_text' );
	$topparagraph2 = get_theme_mod( 'top_two_text' );
	$topparagraph3 = get_theme_mod( 'top_three_text' );
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
 * @param WP_Customize_Manager $wp_customize
 */
function getled_customizer_controls( $wp_customize ) {

	getled_button_customizer_controls( $wp_customize );

	$wp_customize->add_section(
		'getled_menu_options',
		array(
			'title'       => __( 'Main Menu Settings', 'getled' ),
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

	$wp_customize->add_setting( 'getled_menu_title_setting',
		array(
			'default' => 'Menu'
		)
	);

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
		'your_control_id',
		array(
			'label'    => __( 'Menu Button Text', 'getled' ),
			'section'  => 'getled_menu_options',
			'settings' => 'getled_menu_title_setting',
			'type'     => 'text',
		) );

	$wp_customize->add_control(
		'getled_menu_title_icon_control',
		array(
			'label'    => __( 'Menu Icon (Fontawesome Class)', 'getled' ),
			'section'  => 'getled_menu_options',
			'settings' => 'getled_menu_title_iconclass_setting',
			'type'     => 'text',
		) );

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

		#primary-menu, #primary-menu > ul {
			background: <?php echo get_theme_mod( 'getled_menu_bg_color' ); ?>;
		}

		#primary-menu li:hover {
			background: <?php echo get_theme_mod( 'getled_menu_bg_color_hover' ); ?>
		}

		<?php getled_custom_colors(); ?>
	</style>
	<?php
}


function getled_custom_colors() {

	//define background colors
	$colortop_bg1 = get_option( 'top_one_bg_color' );
	$colortop_bg2 = get_option( 'top_two_bg_color' );
	$colortop_bg3 = get_option( 'top_three_bg_color' );
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