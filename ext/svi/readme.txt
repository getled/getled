=== Smart Variations Images ===
Contributors: drosendo
Donate link: https://goo.gl/EPQAsA
Tags: WooCommerce, images variations, gallery, woocommerce variations, woocommerce variations images, woocommerce images
Requires at least: 3.6.0
Tested up to: 4.8.2
Stable tag: 3.2.18
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Want your images to switch according to the select variation? Smart Variations Images for WooCommerce makes adding custom images to variations a breeze!

== Description ==


By default WooCommerce will only swap the main variation image when you select a product variation, not the gallery images below it. 

Want your images to switch according to the select variation? Smart Variations Images for WooCommerce makes adding custom images to variations a breeze!

This extension allows visitors to your online store to be able to swap different gallery images when they select a product variation. 
Adding this feature will let visitors see different images of a product variation all in the same color and style.

This extension will allow the use of multiple images per variation, and simplifies it! How?
Instead of upload one image per variation, upload all the variation images to the product gallery and for each image choose the corresponding slug of the variation on the dropdown.
As quick and simple as that!

<h4>PRO Version</h4>
<ul>
<li>Main Image/thumbnails swap on choose variation</li>
<li>Multiple Images for Variation</li>
<li>Multiple Images Upload for Variation (Bulk)</li>
<li>Ability to assign images to a <b>Combination of Variations</b>.</li>
<li>Ability to use same image across multiple variations.</li>
<li>Allow same image to be shared across different products with diferent variations</li>
<li>Show Variation as Cart Image</li>
<li>Ligthbox prettyPhoto & photoswipe</li>
<li>Advanced Slider (Navigation Arrows & Color + Thumbnail Positions) - Fully Responsive</li>
<li>Advanced Magnifier Lens (Lens Style & Size + Lens Border Color + Zoom Type & Effects)</li>
<li>Extra Thumbnail Options (Disabled Thumbnails + Select Swap + Thumbnail Click Swap + Keep Thumbnails Visible)</li>
<li>Extra Layout Fixes (Add Custom CSS Classes + Remove Image Class)</li>
<li>WPML Compatible</li>
<li>Responsive</li>
<li>Priority Support</li>
</ul>

Try the PRO version: <a href="http://svi.rosendo.pt/pro" target="_blank">PRO VERSION DEMO</a>

<strong>WooCommerce 3.0+ Ready</strong>

<h4>Free version Features</h4>
<ul>
<li>Multiple Images for Variation</li>
<li>Magnifier Lens</li>
<li>Ligthbox</li>
<li>Main Image/thumbnails swap on choose variation</li>
<li>Custom Thumbnail Columns</li>
<li>Hidden Thumbnails</li>
<li>WPML Compatible</li>
<li>Responsive</li>
</ul>

<strong>Read the FAQ and Screenshots before posting in support!</strong>

Check out a demo at: <a href="http://svi.rosendo.pt/free" target="_blank">svi.rosendo.pt/free</a>

<strong>Please give your review!</strong> Good or bad all is welcomed!

Visit ROSENDO for more information http://www.rosendo.pt

== Installation ==

1. Upload the entire `smart-variations-images` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. On your product assign the product attributes and save
4. Go to Product Gallery and upload/choose your images
5. Assign the slugs to be used for the variation images for each of the image and save.
6. When you are ready to take the variation swapping online go to WooCommerce > SVI and activate SVI to run on the front-end
6. Good luck with sales :)


== Frequently Asked Questions ==

= The plugin doesn't work with my theme =

Themes that follow the default WooCommerce implementation will usually work with this plugin. However, some themes use an unorthodox method to add their own lightbox/slider, which breaks the hooks this plugin needs.

= The plugin works but messes up the styling of the images =

You can try several options here.

1. Go to WooCommerce > SVI (Smart Variations Images) and activate or deactivate the option "Enable WooCommerce default product image"
2. Disable other plugins that change the Product image default behavior.
3. Read the Support Threads.


= How do I configure it to work? =

1. Assign your product Attributes and click "Save attributes"
2. Create the variations you need, and click "Publish" or "Save as draft"
3. Go to the WooCommerce Product Gallery and upload/choose the images you are going to use
4. For EACH image assign the slug/variation to be used for the variation images swap
5. Publish you product

You can skip steps 1 and 2 if your product is already setup with Attributes and Variations.

== Screenshots ==

1. Add images to your Product Gallery
2. Choose the images to be used and select the "slug" of the variation in the "Variation Slug" field.
3. Hides all other images that don't match the variation, and show only the default color, if no default is chosen, the gallery is hidden.
4. On change the variation, images in the gallery also change to match the variation. The image in the gallery when click should show in the bigger image(above).
4. Lens Zoom in action (activate it in WooCommerce > SVI (Smart Variations Images)

== Changelog ==

= 3.2.18 =
* Fixed lens not loading Full image

= 3.2.17 =
* update Readme
* removed duplicate function of plugin woocommerce_show_product_images
* Fix warning messages


= 3.2.16 =
* Minor fix for notices showing in admin
* Added Multisite compatibility

= 3.2.15 =
* Minor fix for notices showing in admin

= 3.2.14 =
* Fix for possible encoded characters

= 3.2.13 =
* Updated new options

= 3.2.12 =
* Added extra option for theme compatibility case jQuery Imageloaded is used by theme and creates conflict
* Code optimization for retro-compatibility

= 3.2.11 =
* Localized all JS
* Fix prevent duplicate Image showing in gallery
* Fix possible conflict with other themes/plugins adding variation selects in other places


= 3.2.10 =
* Added support for UNICODE chars

= 3.2.9 =
* Fix variations only loading last match

= 3.2.8 =
* Fix: White area on loading/swapping images
* Fix: Image flicker when main image already in use
* Fix: Main image not showing in Thumbnail images
* Code cleanup

= 3.2.7 =
* Fix: Single image not loading

= 3.2.6 =
* Fixed thumbnails being hidden if no matches occurs
* Fixed no titles appearing on ligthbox
* Improvment: Variation select for images in admin showing more results than needed
* Code cleanup

= 3.2.5 =
* Fixed: Duplicate Image where product is variable and with 1 image

= 3.2.4 =
* Added: Fallback if no Main image get 1st Thumbnail image
* Improvement: Order thumbnails correctly First/last
* Fix: Duplicate thumbs with main image
* Fix: If no main image set in variations, notice error prevent images loading
* Fix: Hidden thumbnails not showing thumbnails in single product pages
* Cleanup

= 3.2.3 =
* Fix: Show only variations for select
* Fix: WPML translation on non variations

= 3.2.2 =
* Minor fix: Added missing thumbnail options
* Minor fix: Lens not Round
* Minor fix: If missing srcset skip to prevent images not loading
+ Code Clean Up

= 3.2.1 =
* Added missing slug

= 3.2 =
* Full code rewrite
* WooCommerce 2.7 Compatible
* Improvement: Better theme integration
* Improvement: WPML Compatibility
* Improvement: Faster Image loading
* Removed: Included ReduxFramework plugin form SVI to require install for better compatibility
* Added: Pre-loader on page load
* Minor Fixes

= 3.1.8.11 =
* Added fallback if main image not present
* Cleared JS messages for showing

= 3.1.8.10 =
* Added fallback if no images present
* Faster loading of images

= 3.1.8.9 =
* Fixed fallback if default variation has no images attributed

= 3.1.8.8 =
* Added fallback if default variation has no image attributed

= 3.1.8.7 =
* Fix correct variation not loading if default variation predefined
* Not showing correct variation if variation with "any value" exist
* Fix clear  button not showign default images

= 3.1.8.6 =
* Minor fix for themes over writing main image, fallback.

= 3.1.8.5 =
* minor fix for some theme breaking up main image

= 3.1.8.4 =
* Fix custom variation with spaces not being loaded properly

= 3.1.8.3 =
* Fix Ligthbox not showing correct clicked image on Ligthbox open

= 3.1.8.2 =
* Fix Lens and Ligthbox not loading Full image
* Fix Clear button duplicating images after 2nd clear

= 3.1.8.1 =
* JS clean up

= 3.1.8 =
* Prevent duplicate images from showing
* Fixed double quotes breaking image load, changed JS code
* Preload images so they swap faster

= 3.1.7 =
* Fixed JS issue when not detecting object
* Fixed double quotes issue preventing images from getting loaded properly

= 3.1.6 =
* Removed comments

= 3.1.5 =
* Stable Version JS cleanUp
* Return to native WooCommerce Ligthbox
* I'm sorry about the previous problems that occurred during the latest update.

= 3.1.4 =
* Fixed issue with hidding admin bar
* Fixed issue not displaying single products
* Fixed issue Custom variations not swapping

= 3.1.3 =
* Added Missing thumbnails options

= 3.1.2 =
* Fixed minor issue throwing fatal error for old PHP versions. Please use PHP 5.6.

= 3.1.1 =
* Added missing files

= 3.1 =
* Full code rewrite
* Better theme integration
* WPML Compatible
* New Ligthbox
* Faster response

= 3.0.1 =
* Minor CSS fix with margins
* Deleted uneeded files

= 3.0 =
* Major release
* New UI for admin now with ReduxFramework
* Lens with Loader
* Faster response
* Better compatibility

= 2.0.9 =
* Fallback support for variations using "all options"

= 2.0.8 =
* Fixed warning message when WooCommerce not active, It was calling wrong function, thanks to @moyen03 for reporting it

= 2.0.7 =
* Added feature to Hide thumbnails on load and show after variation has been selected.

= 2.0.6 =
* Code cleanup

= 2.0.5 =
* Code cleanup
* Promotion 25% for the first 100!

= 2.0.4 =
* Fix bug with ligthbox poping Ligthbox in some themes
* Fix incorrect thumnails display with collumns
* Added new Pro Features content

= 2.0.3 =
* Fixed bug issue related with long variations not showing prices.
* Fix incorrect thumnails display with collumns

= 2.0.2 =
* Minor fix for Lens showing duplicate images
* Fix Lens to load Original Image
* Fix conflicts that may cause Lens not to work properly

= 2.0.1 =
* Minor fix for Lens showing duplicate images
* SVI PRO Update now WPML compatible

= 2.0 =
* Wordpress 4.5 compatible
* Complete code rewrite
* Better theme compatibility
* Clean code
* SVI PRO update
* Better lens
* Better ligthbox

= 1.5.8 =
* Fixed Columns display after reset
* Fixed image swap not working in some cases

= 1.5.7 =
* Fix reset
* Launch Pro Version

= 1.5.6 =
* Minor CSS to fix Woocommerce issues hidding images with class has-children.

= 1.5.5 =
* First: Sorry for all the updates!
* Fixed issue with ligthbox not working in themes or not setup to work with pretybox (woocommerce default ligthbox)
* Fixed issue to prevent image to open in blank if no lightbox is activated for variable and single images
* Code cleanup

= 1.5.4 =
* Fixed issue of images opening in blank page is not variable product.
* SVI only loaded in Variable products
* Code cleanup

= 1.5.3 =
* Fixed issue in some cases images on swap showed pixelixed
* Fixed ligthbox issue on preview image not showing images if default product is enabled.

= 1.5.2 =
* Fixed SVI not overwriting product image page if template has his own files.

= 1.5.1 =
* Fixed warning messages
* Fixed changelog typo on version
* Fixed ligthbox not showing if using default woocomerce product template

= 1.5 =
* Major realease
* New settings page. WooCommerce > SVI
* Better theme compatibility
* Ligthbox now shows only same variations images
* Added better transition for thumbnail click

= 1.4.5 =
* Fix bug with for Wordpress 4.4 not swapping images
* added optional register with rosendo.pt for news and updates

= 1.4.4 =
* New Lens Zoom (removed elevateZoom script, less 1 js file yay!)
* Speed improvements due to new Lens Zoom
* Clean JS/CSS

= 1.4.3.1 =
* Minor issue with class naming of thumbnails, first and last class.

= 1.4.3 =
* Fixed issue with thumbnails when not in order of appearence in product gallery update the swap with primary would not work correctly, thanks to @jamblo for reporting
* Speed improvements due to fix

= 1.4.2.1 =
* Fixed minor issue with thumbnail swap with primary not changing link for prettyPhoto Zoom, thanks to @wzshop for reporting

= 1.4.2 =
* Fixed issue with variation descriptions not showing up, thanks to @jamblo and @Sandeepy02 for reporting

= 1.4.1 =
* Fixed issue with CSS not loading if woocommerce.css not found, messing up the CSS of the images.
* Code cleaning

= 1.4 =
* Added support for "Custom product attributes".

= 1.3.4 =
* Fixed issue with not showing images to swap on products with no variations. Thanks to parasomnias for alerting.

= 1.3.3 =
* Fixed issue with Safari when when switch the variation image the image doesn't render properly.

= 1.3.2 =
* Fixed issue with Lens Zoom not working, due to missing initialization.

= 1.3.1 =
* Fixed load of images recurring to cache
* Fixed swaping iamge when not using WOOSVI

= 1.3 =
* Complete reconstrution of JS to better handle changes.
* Fixed, no more flickering on "WooCommerce default product image"

= 1.2.1 =
* Bug fixed, if user has multiple variations and is not using one of them, variation slug in the image would not show up.
* Added, when user clicks "Clear Selection", update gallery.
* Speacial thank to @max_Q, for reporting issue and supplying some solution.

= 1.2 =
* Added option to prevent conflit with other plugins that maybe Removing/Adding action woocommerce_before_single_product_summary and woocommerce_product_thumbnails to insert their own gallery.
* User can choose to "Enable WooCommerce default product image", SVI will work but may see some flickering when images change, this option is deactivated by default.

= 1.1 =
* Stable Version
* Fixed flickering when swapping images
* Added Lens Zoom Option (activate it in WooCommerce > Configuration > Products Tab > Smart Variations Images)

= 1.0.1 =
* Revert State, missing files to commit. working version.

= 1.0 =
* This is a big release. Fixed flickering of images when swaping images. Added a new option for Lens Zoom, activate this option in WooCommerce > Configuration > Products * Tab > Smart Variations Images

= 0.2.2 =
* Fixed issue where variation would not chagne in Chrome, also if no image variation exist, dont change image.

= 0.2.1 =
* Fixed Warning message from appearing if WP_DEBUG was true preventing images from showing.

= 0.2 =
* No longer use of caption field for Variation, new field has been added to replace the caption.
* Javascript will search for new tag and loop the gallery.

= 0.1 =
* Just released into the wild.