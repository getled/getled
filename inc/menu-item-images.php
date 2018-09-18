<?php

class Getled_Menu_Item_Images {

	/** @var self Instance */
	private static $_instance;
	private $ico = '';

	/**
	 * Returns instance of current calss
	 * @return self Instance
	 */
	public static function instance() {
		if ( ! self::$_instance ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Getled_Menu_Item_Images constructor.
	 */
	public function __construct() {

		add_filter( 'nav_menu_css_class', array( $this, 'icon_class' ), 10, 3 );
		add_filter( 'walker_nav_menu_start_el', array( $this, 'add_img' ), 10, 4 );
		//Enqueue scripts and styles
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ), 999 );

	}

	/**
	 * Filters menu item classes
	 * @param array $classes Item CSS classes
	 * @return array CSS classes
	 */
	public function icon_class( $classes, $item ) {

		$temp = array();
		$this->ico = null;

		foreach ( $classes as $class ) {
			if ( strpos( $class, 'fa-' ) === false ) {
				$temp[] = $class;
			} else {
				$temp[] = 'menu-item-icon';
				$this->ico = $class;
			}
		}

		return $temp;
	}


	/**
	 * @param $html
	 * @param $i
	 * @param $depth
	 *
	 * @return string
	 */
	public function add_img( $html, $i, $depth ) {

		$icon = $image = '';
		if ( $i->image ) {
			$image = "<img src='{$i->image}'>";
		}

		if ( $this->ico ) {
			$icon = "<i class='fa {$this->ico}'></i>";
		}
		return "<a href='{$i->url}'>$icon <span>{$i->title}</span> $image</a>";
	}


	public function enqueue() {
		global $pagenow;
		if ( 'nav-menus.php' == $pagenow ) {
			wp_enqueue_media();

			wp_enqueue_script( 'getled-admin-menu', get_template_directory_uri() . '/js/menu-item-images.js', array( 'jquery' ) );
			wp_enqueue_style( 'getled-admin-menu', get_template_directory_uri() . '/js/menu-item-images.css', array() );
			wp_enqueue_script( 'getled-fa-picker', get_template_directory_uri() . '/js/fa-picker.js', array( 'jquery' ) );
			wp_enqueue_style( 'getled-fa-picker', get_template_directory_uri() . '/js/fa-picker.css', array() );
			wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );

			wp_localize_script( 'getled-fa-picker', 'shrameeFAPickerL10n', [
				'cancel' => __( 'Cancel', 'getled' ),
				'accept' => __( 'Accept', 'getled' ),
			] );

		}
	}

}

Getled_Menu_Item_Images::instance();