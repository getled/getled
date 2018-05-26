<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class woocommerce_svi_frontend {

    private static $_this;

    /**
     * contruct
     *
     * @since 1.0.0
     * @return bool
     */
    public function __construct() {

        $this->suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        add_action('wp', array($this, 'init'));
        return $this;
    }

    /**
     * run init to check if we are on product page
     *
     * @since 1.0.0
     * @return 
     */
    function init() {

        $this->prepVars();

        if (is_product()) {
            add_action('woocommerce_before_single_product', array($this, 'remove_hooks'));
            add_action('woocommerce_before_single_product_summary', array($this, 'show_product_images'), 20);
            add_action('wp_enqueue_scripts', array($this, 'load_scripts'), 150, 1);
        }
    }

    /**
     * Plugin path
     *
     * @since 1.0.0
     * @return string
     */
    function woo_svi_plugin_path() {
        return untrailingslashit( SVI_PATH );
    }

    /**
     * Loads the vars needed
     *
     * @since 1.1.1
     * @return instance object
     */
    function prepVars() {
        global $woosvi;

        $this->woosvi_options = get_option('woosvi_options');
        if (is_product()) {
            $this->woosvi_options['gallery'] = $this->gallery();
        }
        $this->woosvi_options['jsversion'] = '5.7';
        $woosvi = $this->woosvi_options;
    }

    /**
     * Load images to be used
     *
     * @since 1.0.0
     * @return array
     */
    public function gallery() {
        global $post;

        $product = wc_get_product($post->ID);

        $slugs = $this->wpml($post->ID, $product);

        $mid = get_post_thumbnail_id($post->ID);

	      $attachment_ids = $product->get_gallery_image_ids();
        $gallery_images = array();

        $slug_main = $this->wpml_slug($slugs, $mid, $post->ID);

        $full = wp_get_attachment_image_src($mid, 'full');
        $title = get_the_title($mid);
        $gallery_images['main_image'] = array();
        if ($full) {
            $gallery_images['main_image'] = array(
                'fullimg' => $this->imgtagger(wp_get_attachment_image($mid, apply_filters('single_product_large_thumbnail_size', 'shop_single'), 0, array(
                    'data-woosvislug' => $slug_main,
                    'data-svikey' => '-1',
                    'data-svizoom-image' => $full[0],
                    'title' => $title
                                )
                )),
                'thumbimg' => $this->imgtagger(wp_get_attachment_image($mid, apply_filters('single_product_small_thumbnail_size', 'shop_catalog'), 0, array(
                    'data-woosvislug' => $slug_main,
                    'data-svikey' => '-1',
                    'data-svizoom-image' => $full[0],
                    'title' => $title
                ))),
                'full' => $full,
                'large' => wp_get_attachment_image_src($mid, 'large'),
                'single' => wp_get_attachment_image_src($mid, apply_filters('single_product_large_thumbnail_size', 'shop_single')),
                'thumb' => wp_get_attachment_image_src($mid, 'thumbnail'),
                'woosvi_slug' => $slug_main,
                'title' => $title,
                'type' => 'main'
            );
        } else {
            $gallery_images['main_image'] = false;
        }
        if (0 < count($attachment_ids)) {

            foreach ($attachment_ids as $k => $id) {

                $woosvi_slug = $this->wpml_slug($slugs, $id, $post->ID);
                $full = wp_get_attachment_image_src($id, 'full');
                $title = get_the_title($id);
                $gallery_images['thumbs'][] = array(
                    'fullimg' => $this->imgtagger(wp_get_attachment_image($id, apply_filters('single_product_large_thumbnail_size', 'shop_single'), 0, array(
                        'data-woosvislug' => $woosvi_slug,
                        'data-svikey' => $k,
                        'data-svizoom-image' => $full[0],
                        'title' => $title
                    ))),
                    'thumbimg' => $this->imgtagger(wp_get_attachment_image($id, apply_filters('single_product_small_thumbnail_size', 'shop_thumbnail'), 0, array(
                        'data-woosvislug' => $woosvi_slug,
                        'data-svikey' => $k,
                        'data-svizoom-image' => $full[0],
                        'title' => $title
                    ))),
                    'full' => $full,
                    'large' => wp_get_attachment_image_src($id, 'large'),
                    'single' => wp_get_attachment_image_src($id, apply_filters('single_product_large_thumbnail_size', 'shop_single')),
                    'thumb' => wp_get_attachment_image_src($id, 'thumbnail'),
                    'woosvi_slug' => $woosvi_slug,
                    'title' => $title,
                    'type' => 'thumb'
                );
            }
        }

        return $gallery_images;
    }

    /**
     * Break images tags to array to be used
     *
     * @since 1.0.0
     * @return array
     */
    function imgtagger($fullimg_tag) {
        preg_match_all('/(alt|title|src|data-woosvislug|data-svizoom-image|data-svikey|srcset|sizes|width|height|class)=("[^"]*")/i', $fullimg_tag, $fullimg_split);

        foreach ($fullimg_split[2] as $key => $value) {
            if ($value == '""')
                $fullimg_split[2][$key] = "";
            else
                $fullimg_split[2][$key] = str_replace('"', "", $value);
        }
        return array_combine($fullimg_split[1], $fullimg_split[2]);
    }

    /**
     * Get translated Slugs
     *
     * @since 1.0.0
     * @return array
     */
    function wpml($pid, $product) {
        global $sitepress;

        if ($product->is_type('simple'))
            return false;

        $slugs = array();

        if (class_exists('SitePress')) {

            $attributes = get_post_meta($pid, '_product_attributes');

            foreach ($attributes[0] as $att => $attribute) {

                if ($attribute['is_taxonomy'] && $attribute['is_variation']) {
                    $terms = wp_get_post_terms($pid, $att, 'all');

                    foreach ($terms as $tr => $term) {
                        remove_filter('get_term', array($sitepress, 'get_term_adjust_id'), 1, 1);
                        $gtb = get_term(icl_object_id($term->term_id, $att, true, $sitepress->get_default_language()));

                        $slugs[urldecode($gtb->slug)] = urldecode($term->slug);
                        add_filter('get_term', array($sitepress, 'get_term_adjust_id'), 1, 1);
                    }
                }
            }

            $original = icl_object_id($pid, 'product', true, $sitepress->get_default_language());
            $attributes_original = get_post_meta($original, '_product_attributes');

            foreach ($attributes_original[0] as $att => $attribute) {

                if (!$attribute['is_taxonomy'] && $attribute['is_variation']) {

                    if (array_key_exists($att, $attributes[0])) {
                        $values = str_replace(" ", "", $attributes[0][$att]['value']);
                        if (!empty($values)) {
                            $terms = explode('|', $values);

                            $values_original = str_replace(" ", "", $attribute['value']);
                            $terms_original = explode('|', $values_original);

                            foreach ($terms_original as $tr => $term) {
                                $slugs[strtolower(urldecode($term))] = strtolower($terms[$tr]);
                            }
                        }
                    }
                }
            }
        } else {
            $attributes = get_post_meta($pid, '_product_attributes');
            if (!empty($attributes)) {
                foreach ($attributes[0] as $att => $attribute) {

                    if ($attribute['is_taxonomy'] && $attribute['is_variation']) {
                        $terms = wp_get_post_terms($pid, $att, 'all');

                        foreach ($terms as $tr => $term) {

                            $gtb = get_term($term->term_id);

                            $slugs[urldecode($gtb->slug)] = urldecode($term->slug);
                        }
                    }
                }


                foreach ($attributes[0] as $att => $attribute) {

                    if (!$attribute['is_taxonomy'] && $attribute['is_variation']) {

                        $values = str_replace(" ", "", $attribute['value']);
                        if (!empty($values)) {

                            $terms = explode('|', $values);

                            $values_original = str_replace(" ", "", $attribute['value']);
                            $terms_original = explode('|', $values_original);

                            foreach ($terms_original as $tr => $term) {
                                $slugs[strtolower(urldecode($term))] = strtolower($terms[$tr]);
                            }
                        }
                    }
                }
            }
        }

        return $slugs;
    }

    /**
     * Get translated Slug for attachments
     *
     * @since 1.0.0
     * @return array
     */
    function wpml_slug($slugs, $id, $pid) {
        global $sitepress;

        if (!$slugs)
            return '';

        if (class_exists('SitePress')) {

            $originalwoosvi_slug = get_post_meta(icl_object_id($id, 'attachment', true, $sitepress->get_default_language()), 'woosvi_slug', true);

            if (!empty($originalwoosvi_slug)) {
                if (array_key_exists($originalwoosvi_slug, $slugs))
                    $woosvi_slug = $slugs[$originalwoosvi_slug];
                else
                    $woosvi_slug = $originalwoosvi_slug;
            } else {
                $woosvi_slug = get_post_meta($id, 'woosvi_slug', true);
            }
        } else {
            $woosvi_slug = get_post_meta($id, 'woosvi_slug', true);
        }
        return $woosvi_slug;
    }

    /**
     * Loads visualization page
     *
     * @since 1.1.1
     * @return instance object
     */
    public function show_product_images() {
        require_once($this->woo_svi_plugin_path() . '/frontend/display.php');
    }

    /**
     * load front-end scripts
     *
     * @since 1.0.0
     * @return bool
     */
    function load_scripts() {
        global $wp_styles, $woocommerce;

        $loads = array(
            'jquery',
        );

        wp_enqueue_script('sviImagesloaded', SVI_URL . 'assets/vendor/imagesloaded/js/imagesloaded.pkgd' . $this->suffix . '.js', null, true);
        array_push($loads, 'sviImagesloaded');
        wp_enqueue_script('woosvijs', SVI_URL . 'assets/js/svi-frontend' . $this->suffix . '.js', $loads, null, true);
        wp_localize_script('woosvijs', 'WOOSVIDATA', $this->woosvi_options);

        $styles = null;
        $srcs = array_map('basename', (array) wp_list_pluck($wp_styles->registered, 'src'));
        $key_woocommerce = array_search('woocommerce.css', $srcs);

        if ($key_woocommerce) {
            $styles = array(
                $key_woocommerce,
            );
        }

        wp_enqueue_style('woo_svicss', SVI_URL . 'assets/css/woo_svi' . $this->suffix . '.css', $styles, null);
    }

    /**
     * Remove hooks for plugin to work properly
     *
     * @since 1.1.1
     * @return instance object
     */
    public function remove_hooks() {
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
        remove_action('woocommerce_before_single_product_summary_product_images', 'woocommerce_show_product_images', 20);
        remove_action('woocommerce_product_summary_thumbnails', 'woocommerce_show_product_thumbnails', 20);
    }

    /**
     * public function to get instance
     *
     * @since 1.1.1
     * @return instance object
     */
    public function get_instance() {
        return self::$_this;
    }

}

function woosvi_class() {
    global $woosvi_class;

    if (!isset($woosvi_class)) {
        $woosvi_class = new woocommerce_svi_frontend();
    }

    return $woosvi_class;
}

// initialize
woosvi_class();
