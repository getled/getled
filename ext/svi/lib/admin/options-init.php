<?php

if (!class_exists('Redux')) {
    return;
}

function sviremoveDemoModeLink() { // Be sure to rename this function to something more unique
    if (class_exists('ReduxFrameworkPlugin')) {
        remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2);
    }
    if (class_exists('ReduxFrameworkPlugin')) {
        remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance(), 'admin_notices'));
    }
}

add_action('init', 'sviremoveDemoModeLink');

// This is your option name where all the Redux data is stored.
$opt_name = "woosvi_options";

$args = array(
    'opt_name' => 'woosvi_options',
    'use_cdn' => TRUE,
    'dev_mode' => false,
    'forced_dev_mode_off' => false,
    'display_name' => 'SMART VARIATIONS IMAGES',
    'display_version' => SL_VERSION,
    'page_slug' => 'woocommerce_svi',
    'page_title' => 'Smart Variations Images for WooCommerce',
    'update_notice' => TRUE,
    'admin_bar' => TRUE,
    'menu_type' => 'submenu',
    'menu_title' => 'SVI',
    'page_parent' => 'woocommerce',
    'customizer' => FALSE,
    'default_mark' => '*',
    'hints' => array(
        'icon' => 'el el-adjust-alt',
        'icon_position' => 'right',
        'icon_color' => 'lightgray',
        'icon_size' => 'normal',
        'tip_style' => array(
            'color' => 'light',
        ),
        'tip_position' => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect' => array(
            'show' => array(
                'duration' => '500',
                'event' => 'mouseover',
            ),
            'hide' => array(
                'duration' => '500',
                'event' => 'mouseleave unfocus',
            ),
        ),
    ),
    'output_tag' => TRUE,
    'cdn_check_time' => '1440',
    'page_permissions' => 'manage_woocommerce',
    'save_defaults' => TRUE,
    'database' => 'options',
    'transient_time' => '3600',
    'network_sites' => TRUE,
);

Redux::setArgs($opt_name, $args);

/*
 * ---> END ARGUMENTS
 */


/*
 *
 * ---> START SECTIONS
 *
 */

Redux::setSection($opt_name, array(
    'title' => __('Global', 'wc_svi'),
    'id' => 'general',
    //'desc' => __('General settings', 'wc_svi'),
    'icon' => 'el el-home',
    'fields' => array(
        array(
            'id' => 'default',
            'type' => 'switch',
            'title' => __('Enable SVI', 'wc_svi'),
            'desc' => __('Activate or Deactivate SVI from running on your site.', 'wc_svi'),
            'on' => __('Activate', 'wc_svi'),
            'off' => __('Deactivate', 'wc_svi'),
            'default' => false,
        ),
        array(
            'id' => 'svi0_info',
            'type' => 'info',
            'style' => 'success',
            'icon' => 'el-icon-info-sign',
            'title' => __('Smart Variations Images PRO for WooCommerce makes adding custom images to variations a breeze! Give your customers the most amazing experience while navigating your products!', 'wc_svi'),
            'desc' => __('Check all the amazing features <a href="https://www.rosendo.pt/smart-variations-images-pro/" target="_blank">here</a>.', 'wc_svi')
        ),
        array(
            'id' => 'svi20_info',
            'type' => 'info',
            'title' => __('Trigger Match', 'wc_svi'),
            'style' => 'warning',
            'desc' => __('On user selects Images will be showed according to galleries created in Product, no grouping will occur.', 'wc_svi'),
        ),
        array(
            'id' => 'svi1_info',
            'type' => 'info',
            'title' => __('Cart Image (PRO VERSION)', 'wc_svi'),
            'style' => 'warning',
            'desc' => __('Display choosen variation image in cart/checkout instead of default Product image.', 'wc_svi')
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __('Lightbox', 'wc_svi'),
    'id' => 'lightbox-svi',
    'fields' => array(
        array(
            'id' => 'lightbox',
            'type' => 'switch',
            'required' => array(
                array('default', '=', '1'),
            ),
            'title' => __('Activate Lightbox', 'wc_svi'),
            //'subtitle' => __('Also called a "fold" parent.', 'wc_svi'),
            //'desc' => __('Items set with a fold to this ID will hide unless this is set to the appropriate value.', 'wc_svi'),
            'default' => false,
        ),
        array(
            'id' => 'svi100_info',
            'type' => 'info',
            'style' => 'warning',
            'icon' => 'el-icon-info-sign',
            'title' => __('prettyPhoto Ligthbox Style', 'wc_svi'),
            'desc' => __('The PrettyPhoto lightbox plugin comes with a few additional themes, than the one enabled into WooCommerce by default. Now you can access them.', 'wc_svi')
        ),
        array(
            'id' => 'svi101_info',
            'type' => 'info',
            'style' => 'warning',
            'icon' => 'el-icon-info-sign',
            'title' => __('Use theme prettyPhoto style', 'wc_svi'),
            'desc' => __('Use this option if your theme uses prettyPhoto as ligthbox and has his own style.', 'wc_svi')
        ),
        array(
            'id' => 'svi102_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Lightbox Woo 3.0', 'wc_svi'),
            //'subtitle' => __('Also called a "fold" parent.', 'wc_svi'),
            'desc' => __('Use the new WooCommerce 3.0 Ligthbox.', 'wc_svi'),
            'icon' => 'el-icon-info-sign',
        ),
        array(
            'id' => 'svi103_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Show Thumbnails', 'wc_svi'),
            //'subtitle' => __('Also called a "fold" parent.', 'wc_svi'),
            'desc' => __('A Lightbox Woo 3.0 option', 'wc_svi'),
            'icon' => 'el-icon-info-sign',
        ),
        array(
            'id' => 'svi104_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Show Close Button', 'wc_svi'),
            //'subtitle' => __('Also called a "fold" parent.', 'wc_svi'),
            'desc' => __('A Lightbox Woo 3.0 option', 'wc_svi'),
            'icon' => 'el-icon-info-sign',
        ),
        array(
            'id' => 'svi105_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Show Image Titles', 'wc_svi'),
            //'subtitle' => __('Also called a "fold" parent.', 'wc_svi'),
            'desc' => __('A Lightbox Woo 3.0 option', 'wc_svi'),
            'icon' => 'el-icon-info-sign',
        ),
        array(
            'id' => 'svi106_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Show FullScreen Option', 'wc_svi'),
            //'subtitle' => __('Also called a "fold" parent.', 'wc_svi'),
            'desc' => __('A Lightbox Woo 3.0 option', 'wc_svi'),
            'icon' => 'el-icon-info-sign',
        ),
        array(
            'id' => 'svi107_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Show Zoom Option', 'wc_svi'),
            //'subtitle' => __('Also called a "fold" parent.', 'wc_svi'),
            'desc' => __('A Lightbox Woo 3.0 option', 'wc_svi'),
            'icon' => 'el-icon-info-sign',
        ),
        array(
            'id' => 'svi108_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Show Share Option', 'wc_svi'),
            //'subtitle' => __('Also called a "fold" parent.', 'wc_svi'),
            'desc' => __('A Lightbox Woo 3.0 option', 'wc_svi'),
            'icon' => 'el-icon-info-sign',
        ),
        array(
            'id' => 'svi109_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Show Counter Option', 'wc_svi'),
            //'subtitle' => __('Also called a "fold" parent.', 'wc_svi'),
            'desc' => __('A Lightbox Woo 3.0 option', 'wc_svi'),
            'icon' => 'el-icon-info-sign',
        ),
        array(
            'id' => 'svi110_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Show Counter Option', 'wc_svi'),
            //'subtitle' => __('Also called a "fold" parent.', 'wc_svi'),
            'desc' => __('A Lightbox Woo 3.0 option', 'wc_svi'),
            'icon' => 'el-icon-info-sign',
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __('Slider', 'wc_svi'),
    'id' => 'slider-subsection',
    //'desc' => __('For full documentation on validation, visit: ', 'wc_svi') . '<a href="//docs.reduxframework.com/core/the-basics/required/" target="_blank">docs.reduxframework.com/core/the-basics/required/</a>',
    'fields' => array(
        array(
            'id' => 'svi2_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Activate Slider (PRO VERSION)', 'wc_svi'),
        ),
        array(
            'id' => 'svi200_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Deactivate Centered thumbnails', 'wc_svi'),
            //'subtitle' => __('Also called a "fold" parent.', 'wc_svi'),
            'desc' => __('Thumbnails will be forced to start in begining of element.', 'wc_svi'),
        ),
        array(
            'id' => 'svi201_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Main Navigation Slider (PRO VERSION).', 'wc_svi'),
            'desc' => __('Add arrow navigation to main image.', 'wc_svi'),
        ),
        array(
            'id' => 'svi202_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Thumb Navigation Slider (PRO VERSION). ', 'wc_svi'),
            'desc' => __('Add arrow navigation to thumbnails.', 'wc_svi'),
        ),
        array(
            'id' => 'svi203_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Navigation Color (PRO VERSION).', 'wc_svi'),
            'desc' => __('Set color for navigation arrows.', 'wc_svi'),
        ),
        array(
            'id' => 'svi204_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Auto Slide', 'wc_svi'),
            'subtitle' => __('Add auto sliding.', 'wc_svi'),
            'default' => false,
        ),
        array(
            'id' => 'svi205_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Auto Slide time (ms)', 'wc_svi'),
            //'subtitle' => __('Also called a "fold" parent.', 'wc_svi'),
            'desc' => __('Delay between transitions (in ms). If this parameter is not specified or is 0(zero), auto play will be 2500 (2,5s)', 'wc_svi'),
        ),
    )
));


Redux::setSection($opt_name, array(
    'title' => __('Magnifier Lens', 'wc_svi'),
    'id' => 'lens-subsection',
    'fields' => array(
        array(
            'id' => 'lens',
            'type' => 'switch',
            'required' => array('default', '=', '1'),
            'title' => __('Activate Magnifier Lens', 'wc_svi'),
            //'subtitle' => __('Also called a "fold" parent.', 'wc_svi'),
            //'desc' => __('Disabled on mobile phones.', 'wc_svi'),
            'default' => false,
        ),
        array(
            'id' => 'svi306_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Disable Lens Zoom Contain', 'wc_svi'),
            //'desc' => __('Select thumnails position. Bottom, Left.',  'wc_svi'),
            'desc' => __('NOTE: If active in some themes this option may not work properly.', 'wc_svi'),
        ),
        array(
            'id' => 'svi307_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Lens Easing', 'wc_svi'),
            'desc' => __('Allows smooth scrool of image to Zoom Type Window & Inner', 'wc_svi'),
        ),
        array(
            'id' => 'svi300_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Lens Format (PRO VERSION)', 'wc_svi'),
            'desc' => __('Square or Round format, default is round', 'wc_svi')
        ),
        array(
            'id' => 'svi301_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Lens Size (PRO VERSION)', 'wc_svi'),
            'desc' => __('Lens size to be displayed, min:100 | max: 300.', 'wc_svi'),
        ),
        array(
            'id' => 'svi302_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Lens Border (PRO VERSION)', 'wc_svi'),
            'desc' => __('Pick a border color for the lens or transparent.', 'wc_svi'),
        ),
        array(
            'id' => 'svi303_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Zoom type (PRO VERSION)', 'wc_svi'),
            'desc' => __('Lens, Window or Inner, defaul is Lens.', 'wc_svi'),
        ),
        array(
            'id' => 'svi304_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Zoom Effect (PRO VERSION)', 'wc_svi'),
            'desc' => __('Allows Zoom with mouse scroll.', 'wc_svi'),
        ),
        array(
            'id' => 'svi305_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Fade Effect (PRO VERSION)', 'wc_svi'),
            'desc' => __('On mouse in Lens fades in or out.', 'wc_svi'),
        )
    )
));


Redux::setSection($opt_name, array(
    'title' => __('Thumbails', 'wc_svi'),
    'id' => 'thumbs-subsection',
    //'desc' => __('For full documentation on validation, visit: ', 'wc_svi') . '<a href="//docs.reduxframework.com/core/the-basics/required/" target="_blank">docs.reduxframework.com/core/the-basics/required/</a>',
    'fields' => array(
        array(
            'id' => 'svi400_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Disable Thumbnails (PRO VERSION)', 'wc_svi'),
            'desc' => __('Disable thumbnails on product page', 'wc_svi'),
        ),
        array(
            'id' => 'svi401_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Thumbnail Position (PRO VERSION)', 'wc_svi'),
            'subtitle' => __('Select thumnails position. Bottom, Left or right.', 'wc_svi'),
            'desc' => __('Bottom, Left and Right positions, for thumbnails.', 'wc_svi'),
        ),
        array(
            'id' => 'columns',
            'type' => 'text',
            'title' => __('Thumbnail Columns', 'wc_svi'),
            //'subtitle' => __('Also called a "fold" parent.', 'wc_svi'),
            'desc' => __('Number of thumbnails to be displayed by row, min:1 | max: 10.', 'wc_svi'),
            'validate' => 'numeric',
            'default' => '4',
        ),
        array(
            'id' => 'hide_thumbs',
            'type' => 'switch',
            'title' => __('Hidden Thumbnails', 'wc_svi'),
            //'subtitle' => __('Also called a "fold" parent.', 'wc_svi'),
            'desc' => __('Thumbnails will be hidden until a variation as been selected.', 'wc_svi'),
            'default' => false,
        ),
        array(
            'id' => 'svi402_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Select Swap (PRO VERSION)', 'wc_svi'),
            'desc' => __('All selects will trigger the thumbnail swaps. Don\'t have to wait for select combination.', 'wc_svi'),
        ),
        array(
            'id' => 'svi403_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Thumbnail Click Swap (PRO VERSION)', 'wc_svi'),
            'desc' => __('Swap select box(es) to match variation on thumbnail click.', 'wc_svi'),
        ),
        array(
            'id' => 'svi404_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Keep Thumbnails visible (PRO VERSION)', 'wc_svi'),
            'desc' => __('This option will keep thumbnails visible all the time. No changes will be made to the images.', 'wc_svi'),
        ),
        array(
            'id' => 'svi405_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Thumbnail Opacity', 'wc_svi'),
            //'subtitle' => __('Also called a "fold" parent.', 'wc_svi'),
            'desc' => __('If active, current tumbnail will be faded.', 'wc_svi'),
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __('Layout Fixes', 'wc_svi'),
    'id' => 'fixes-subsection',
    //'desc' => __('For full documentation on validation, visit: ', 'wc_svi') . '<a href="//docs.reduxframework.com/core/the-basics/required/" target="_blank">docs.reduxframework.com/core/the-basics/required/</a>',
    'fields' => array(
        array(
            'id' => 'svi500_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Custom Class (PRO VERSION)', 'wc_svi'),
            'desc' => __('Insert custom css class(es) to fit your theme needs.', 'wc_svi'),
        ),
        array(
            'id' => 'svi501_info',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Remove Image class (PRO VERSION)', 'wc_svi'),
            'desc' => __('Some theme force styling on image class that may break the layout.', 'wc_svi'),
        ),
        array(
            'id' => 'imagesloaded',
            'type' => 'switch',
            'required' => array(
                array('default', '=', '1'),
            ),
            'title' => __('Image Loaded', 'wc_svi'),
            //'subtitle' => __('Also called a "fold" parent.', 'wc_svi'),
            'desc' => __('Fix Image Loaded conflicts.', 'wc_svi'),
            'default' => false,
        ),
    )
));


Redux::setSection($opt_name, array(
    'title' => __('Support', 'wc_svi'),
    'id' => 'info-svi',
    'desc' => 'All support for my free plugins are provided at <a href="https://wordpress.org/support/plugin/smart-variations-images" target="_blank">www.wordpress.org</a>.<br>
Themes that follow the default WooCommerce implementation will usually work with this plugin. However, some themes use an unorthodox method to add their own lightbox/slider, which breaks the hooks this plugin needs.<br>
<br>
<b>Please note that WordPress has a big history of conflicts between plugins.</b><br>
<br>
Love the free version? Why not go PRO? <a href="http://www.rosendo.pt/product/smart-variations-images-pro/" target="_blank">SMART VARIATIONS IMAGES PRO</a><br>
<br>
<h2>No refunds, test the free version before buying!</h2>
<br>
<a href="http://www.rosendo.pt/terms-conditions/">Terms & Conditions</a><br><br>
<h3>If you like my free version please leave a review <a href="https://wordpress.org/support/plugin/smart-variations-images/reviews/" target="_blank">here</a> so that I keep improving the free version.</h3>
<br>
<h2>Setup instructions</h2>
Please visit the free version of this plugin for instructions, click <a href="https://wordpress.org/plugins/smart-variations-images/screenshots/">here</a>.

',
));

/*
     * <--- END SECTIONS
     */
