<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class woocommerce_svi_admin {

    private static $_this;

    /**
     * init
     *
     * @since 1.0.0
     * @return bool
     */
    public function __construct() {

        add_action('admin_enqueue_scripts', array($this, 'load_admin_scripts'), 150);
        add_filter((is_multisite() ? 'network_admin_' : '') . 'plugin_action_links', array($this, 'plugin_action_links'), 10, 2);
        add_filter('attachment_fields_to_edit', array($this, 'woo_svi_field'), 10, 2);
        add_filter('attachment_fields_to_save', array($this, 'woo_svi_field_save'), 10, 2);

        add_action('woocommerce_product_write_panel_tabs', array($this, 'sviproimages_section'));
        if ($this->version_check()) {
            add_action('woocommerce_product_data_panels', array($this, 'sviproimages_settings'));
        } else {
            add_action('woocommerce_product_write_panels', array($this, 'sviproimages_settings'));
        }
        add_action('wp_ajax_woosvi_reload', array($this, 'buildSelect_json'));

        $role = get_role('shop_manager');
        $role->add_cap('manage_options');


        return true;
    }

    /**
     * Adds the settings link under the plugin on the plugin screen.
     * 
     *
     * @since 1.0.0
     * @return 
     */
    public function plugin_action_links($links, $file) {
        if (is_array($links) && $file == 'smart-variations-images/svi.php') {
            $settings_link = '<a href="admin.php?page=woocommerce_svi">' . __("Settings", "woocommerce-svi") . '</a>';
            array_unshift($links, $settings_link);
        }
        return $links;
    }

    /**
     * Dismiss notice
     * 
     *
     * @since 1.0.0
     * @return 
     */
    function woosvi_dismiss_notice() {
        update_option('woosvi-notice-dismissed', true);
        header("Content-type: application/json");
        echo json_encode(true);
        die();
    }

    /**
     * load admin scripts
     *
     * @since 1.0.0
     * @return bool
     */
    function load_admin_scripts() {
        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        $screen = get_current_screen();
        if ($screen->post_type == 'product') {
            wp_enqueue_style('woo_svicss_admin', SVI_URL . 'assets/css/woo_svi_admin.css', null, null);
        }

        wp_enqueue_script('woo_svijs', SVI_URL . 'assets/js/svi-admin-settings' . $suffix . '.js', array('jquery'));
    }

    /**
     * Add woovsi field to media uploader
     *
     * @param $form_fields array, fields to include in attachment form
     * @param $post object, attachment record in database
     * @return $form_fields, modified form fields
     */
    function woo_svi_field($form_fields, $post) {

        if (isset($_POST['post_id']) && $_POST['post_id'] != '0') {
            $in_use = false;
            $variations = false;

            $attributes = get_post_meta($_POST['post_id'], '_product_attributes');

            if (!empty($attributes)) {
                $variations = true;

                $current = get_post_meta($post->ID, 'woosvi_slug', true);

                $html = "<select name='attachments[{$post->ID}][woosvi-slug]' id='attachments[{$post->ID}][woosvi-slug]' style='width:100%;'>";
                $html .= "<option value='' " . selected($current, '', false) . ">Select Variation Or None</option>";
                $existing = array();
                foreach ($attributes[0] as $att => $attribute) {

                    if ($attribute['is_taxonomy'] && $attribute['is_variation']) {

                        $terms = wp_get_post_terms($_POST['post_id'], $att, 'all');
                        if (!empty($terms)) {
                            $tax = get_taxonomy($att);

                            $html .= '<optgroup label="' . $tax->label . '">';
                            foreach ($terms as $tr => $term) {
                                if ($current == $term->slug)
                                    $in_use = true;

                                $html .= "<option value='" . $term->slug . "' " . selected($current, $term->slug, false) . ">" . $term->name . "</option>";

                                array_push($existing, $term->slug);
                            }
                            $html .= '</optgroup>';
                        }
                    } else if (!$attribute['is_taxonomy'] && $attribute['is_variation']) {

                        $values = str_replace(" ", "", $attribute['value']);
                        $terms = explode('|', $values);
                        $html .= '<optgroup label="' . $attribute['name'] . '">';
                        foreach ($terms as $tr => $term) {
                            if ($current == strtolower($term))
                                $in_use = true;

                            $html .= "<option value='" . strtolower($term) . "' " . selected($current, strtolower($term), false) . ">" . $term . "</option>";
                            array_push($existing, strtolower($term));
                        }
                        $html .= '</optgroup>';
                    }
                }

                if (!$in_use && $current != '')
                    $html .= "<option value='" . $current . "' " . selected($current, $current, false) . ">" . $current . "</option>";

                $html .= "</select>";

                $helps = '';

                if (!$in_use && $current != '')
                    $helps = '<div style="color:red;">Image in use by other product, if you wish to use with this product upload another new/same image.<br><strong>Image will not be displayed!</strong></div><br>Purchase <b>SVI PRO</b> to enable this feature!';

                if ($variations) {
                    $form_fields['woosvi-slug'] = array(
                        'label' => 'Variation',
                        'input' => 'html',
                        'html' => $html,
                        'application' => 'image',
                        'exclusions' => array(
                            'audio',
                            'video'
                        ),
                        'helps' => $helps . 'Choose the variation'
                    );
                } else {
                    $form_fields['woosvi-slug'] = array(
                        'label' => 'Variation',
                        'input' => 'html',
                        'html' => 'This product doesn\'t seem to be using any variations.',
                        'application' => 'image',
                        'exclusions' => array(
                            'audio',
                            'video'
                        ),
                        'helps' => 'Add variations to the product and Save'
                    );
                }
            }
        }
        return $form_fields;
    }

    /**
     * Save values of woovsi in media uploader
     *
     * @param $post array, the post data for database
     * @param $attachment array, attachment fields from $_POST form
     * @return $post array, modified post data
     */
    function woo_svi_field_save($post, $attachment) {

        if (isset($attachment['woosvi-slug'])) {
            update_post_meta($post['ID'], 'woosvi_slug', $attachment['woosvi-slug']);
        } else {
            delete_post_meta($post['ID'], 'woosvi_slug');
        }

        return $post;
    }

    /**
     * ADd tab to WooCommerce Product
     * 
     *
     * @since 1.0.0
     * @return HTML
     */
    function sviproimages_section() {
        ?>
        <li class="box_tab show_if_variable"><a href="#sviproimages_tab_data" id="svibulkbtn"><?php _e('SVI PRO Variations Gallery', 'woocommerce'); ?></a></li>
        <?php
    }

    /**
     * Builds Html with content of TAB
     * 
     *
     * @since 1.0.0
     * @return HTML
     */
    function sviproimages_settings() {

        echo '<div id="sviproimages_tab_data" class="panel woocommerce_options_panel" style="padding: 20px 20px;">';

        $this->buildSelect();
        echo '</div>';
    }

    /**
     * Builds the varitions display on product page load
     * 
     *
     * @since 1.0.0
     * @return HTML
     */
    function buildSelect($id = false) {
        global $post;


        echo '<div id="message" class="inline notice woocommerce-message">';
        echo '<h4>AVAILABLE IN PRO VERSION!</h4>';
        echo '<p><ul style="margin-left: 40px;">'
        . '<li>Ability to add images in bulk to a variation.</li>'
        . '<li>Ability to assign images to a Combination of Variations.</li>'
        . '<li>Ability to use same image across multiple variations.</li></ul></p>';
        echo '</div>';
    }

    public static function version_check($version = '3.0') {
        if (class_exists('WooCommerce')) {
            global $woocommerce;
            if (version_compare($woocommerce->version, $version, ">=")) {
                return true;
            }
        }
        return false;
    }

}

new woocommerce_svi_admin();