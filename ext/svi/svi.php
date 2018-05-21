<?php
/*
  Plugin Name: Smart Variations Images
  Plugin URI: http://www.rosendo.pt
  Description: This is a WooCommerce extension plugin, that allows the user to add any number of images to the product images gallery and be used as variable product variations images in a very simple and quick way, without having to insert images p/variation.
  Author: David Rosendo
  Version: 3.2.18
  WC requires at least: 3.0
  WC tested up to: 3.3.4
  Author URI: http://www.rosendo.pt
 */

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

if (!class_exists('woocommerce_svi')) {

    class woocommerce_svi {

        /**
         * init
         *
         * @access public
         * @since 1.0.0
         */
        function __construct() {

            define('SL_VERSION', '3.2.18');

            require ('lib/persist-admin-notices-dismissal.php');
            add_action('admin_init', array('PAnD', 'init'));

            add_action('init', array($this, 'load_plugin_textdomain'));

            if ($this->is_woocommerce_active()) {
                if (is_admin()) {
                    include_once( 'lib/class-svi-admin.php' );
                } else {
                    include_once( 'lib/class-svi-frontend.php' );
                }
            } else {
                add_action('admin_notices', array($this, 'svi_missing_notice'));
            }
        }

        /**
         * load the plugin text domain for translation.
         *
         * @since 1.0.0
         * @return bool
         */
        public function load_plugin_textdomain() {
            apply_filters('svi_locale', get_locale(), 'woocommerce-svi');

            load_plugin_textdomain('wc-svi', false, dirname(plugin_basename(__FILE__)) . '/languages');

            return true;
        }

        function svi2_missing_notice() {

            if (!PAnD::is_admin_notice_active('disablesvipro_notice-notice')) {
                return;
            }
            ?>

            <div data-dismissible="disablesvipro_notice-notice" class="notice notice-info is-dismissible">
                <p><?php _e('Take advantage of WooCommerce 3.0 new ligthbox features with <strong>Smart Variations Images PRO</strong> for just <small><del>€25</del></small>€22 until <b>end of April</b>.<br> SVI PRO for WooCommerce makes adding custom images to variations a breeze! Give your customers the most amazing experience while navigating your products! ', 'woocommerce'); ?></p>
                <p class="submit"><a class="button-primary" href="https://www.rosendo.pt/smart-variations-images-pro/" target="_blank"><?php _e('View the features', 'woocommerce'); ?></a></p>
            </div>
            <?php
        }

        /**
         * SVI fallback notice.
         *
         * @return string
         */
        public function svi_missing_notice() {
            echo '<div class="error"><p>' . sprintf(__('Smart Variations Images requires WooCommerce to be installed and active. You can download %s here.', 'wc-svi'), '<a href="http://www.woothemes.com/woocommerce/" target="_blank">WooCommerce</a>') . '</p></div>';
        }

        function is_woocommerce_active() {
        if ( ! function_exists( 'is_plugin_active_for_network' ) )
    			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

            if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) || is_plugin_active_for_network( 'woocommerce/woocommerce.php' )) {
                return true;
            }
            return false;
        }

    }

    add_action('after_setup_theme', 'svi_init', 0);

    /**
     * init function
     *
     * @package  woocommerce_svi
     * @since 1.0.0
     * @return bool
     */
    function svi_init() {
        new woocommerce_svi();

        return true;
    }

    /**
     * print array
     */
    function svipre($arg) {
        echo "<pre>" . print_r($arg, true) . "</pre>";
    }

}