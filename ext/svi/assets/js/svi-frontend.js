(function ($, window, document, undefined) {

    $.fn.wcsvi_variation_form = function () {

        var $form = this,
                $product_variations = $form.data('product_variations'),
                $is_reset = false;

        $form
                .on('click', '.reset_variations', function (event) {
                    event.preventDefault();
                    $is_reset = true;
                    WOOSVI.STARTS.loadImages(true);
                    WOOSVI.STARTS.imagesLoaded(true);
                    setTimeout(function () {
                        $is_reset = false;
                    }, 500)
                })
                // When the variation is revealed
                .on('show_variation', function (event, variation, purchasable) {
                    //console.log("show_variation");
                    WOOSVI.STARTS.showVariation(); //COMENTADO PORQUE CORRE 2x
                })

                // On changing an attribute
                .on('change', '.variations select', function () {
                    //console.log('change');
                })
                // Upon gaining focus
                .on('focusin touchstart', '.variations select', function () {
                    $is_reset = false;
                })
                // Show single variation details (price, stock, image)
                .on('found_variation', function (event, variation) {
                    //console.log('found_variation');
                })
                // Check variations
                .on('check_variations', function (event, exclude, focus) {
                    //console.log('check_variations');
                })

                // Disable option fields that are unavaiable for current set of attributes
                .on('update_variation_values', function (event, variations) {
                    //console.log('update_variation_values');
                });
        $form.trigger('wc_variation_form');
        return $form;
    };
    $(function () {
        if (typeof wc_add_to_cart_variation_params !== 'undefined') {
            $('.variations_form').each(function () {
                $(this).wcsvi_variation_form();
            });
        }
        WOOSVI.STARTS.init();
    });
})(jQuery, window, document);
if (!WOOSVI) {
    var WOOSVI = {};
} else {
    if (WOOSVI && typeof WOOSVI !== "object") {
        throw new Error("WOOSVI is not an Object type");
    }
}
jQuery.noConflict();
WOOSVI.STARTS = function ($, window, document, undefined) {
    var $form = $('form.variations_form');
    var $container = $("div#woosvi_strap");
    var runningImgLoader = false;
    var $is_variation = ($form.find('.variations select').length > 0) ? true : false;
    var $img_tag = '<img src="{{image_src}}" alt="{{image_alt}}" title="{{image_title}}" data-svikey="{{image_svikey}}" data-woosvislug="{{image_woosvislug}}" data-svizoom-image="{{image_svizoom}}" srcset="{{image_srcset}}" sizes="{{image_sizes}}" width="{{image_width}}" height="{{image_height}}">';
    //THUMBNAILS
    var $hide_thumbs = (WOOSVIDATA.hide_thumbs == '1') ? true : false;
    var $woosvi_lens = (WOOSVIDATA.lens == '1') ? true : false;
    var $woosvi_lightbox = (WOOSVIDATA.lightbox == '1') ? true : false;
    var $prettyphoto_running = false;
    var $LoadLens_running = false;
    var $exist_thumbs = (typeof WOOSVIDATA.gallery.thumbs !== 'undefined' && WOOSVIDATA.gallery.thumbs.length > 0) ? true : false;
    /*BROWSER SUPPORT*/
    var $browser = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
    var is_chrome = navigator.userAgent.indexOf('Chrome') > -1;
    var is_explorer = navigator.userAgent.indexOf('MSIE') > -1;
    var is_firefox = navigator.userAgent.indexOf('Firefox') > -1;
    var is_safari = navigator.userAgent.indexOf("Safari") > -1;
    var is_opera = navigator.userAgent.toLowerCase().indexOf("op") > -1;
    var $reset_variations = $form.find('.reset_variations');
    var $imagesLoaded = (WOOSVIDATA.imagesloaded == '1') ? true : false;
    return{NAME: "Application initialize module", VERSION: WOOSVIDATA.jsversion,
        init: function () {
            if ($browser)
                $woosvi_lens = false;

            if (typeof wc_add_to_cart_variation_params === 'undefined') { //NOT VARIATIONS
                $hide_thumbs = false;
            }

            var cols = ' columns-' + WOOSVIDATA.columns;
            if ($container.find('ul.svithumbnails li').length > 0)
                $container.find('ul.svithumbnails li').remove();
            else
                $container.find('div#woosvithumbs').prepend('<ul class="svithumbnails' + cols + '"></ul>');

            if ($hide_thumbs)
                $container.find('div#woosvithumbs').hide();


            WOOSVI.STARTS.loadImages();
            WOOSVI.STARTS.imagesLoaded();
            WOOSVI.STARTS.ActivateSwapImage();
            WOOSVI.STARTS.prettyPhoto();
        },
        reset: function () {

        },
        loadImages: function ($is_reset) {
            if ($is_reset)
                $LoadLens_running = false;

            $container.find('div#woosvimain').html('');
            $container.find('ul.svithumbnails li').remove();
            $('div#woosvimain').prepend('<div class="sviLoader_thumb"></div>');


            var sels = WOOSVI.STARTS.getActiveVariationsInSelect();
            if (sels.length > 0 && !$is_reset /*&& (sels.length == $('.variations select').size())*/) {
                WOOSVI.STARTS.showVariation();
                return;
            }

            if (!$is_variation && WOOSVIDATA.gallery.thumbs) {
                if (WOOSVIDATA.gallery.main_image)
                    $('div#woosvimain').append($(WOOSVI.STARTS.buildImgTag(WOOSVIDATA.gallery.main_image.fullimg)));
                else if ($exist_thumbs)
                    $('div#woosvimain').append($(WOOSVI.STARTS.buildImgTag(WOOSVIDATA.gallery.thumbs[0].fullimg)));
            }

            if (!WOOSVIDATA.gallery.thumbs && $('div#woosvimain img').length < 1) {
                if (WOOSVIDATA.gallery.main_image)
                    $('div#woosvimain').append($(WOOSVI.STARTS.buildImgTag(WOOSVIDATA.gallery.main_image.fullimg)));
                else if ($exist_thumbs)
                    $('div#woosvimain').append($(WOOSVI.STARTS.buildImgTag(WOOSVIDATA.gallery.thumbs[0].fullimg)));
            }

            if ($is_variation && $('div#woosvimain img').length < 1) {
                if (WOOSVIDATA.gallery.main_image)
                    $('div#woosvimain').append($(WOOSVI.STARTS.buildImgTag(WOOSVIDATA.gallery.main_image.fullimg)));
                else if ($exist_thumbs)
                    $('div#woosvimain').append($(WOOSVI.STARTS.buildImgTag(WOOSVIDATA.gallery.thumbs[0].fullimg)));
            }
            WOOSVI.STARTS.loadThumb(WOOSVIDATA.gallery.thumbs, false);
            WOOSVI.STARTS.reOrderThumbs();
        },
        buildImgTag: function (img) {
            if (typeof img !== 'undefined') { //NOT VARIATIONS

                return $img_tag
                        .replace(/{{image_src}}/g, img.src)
                        .replace("{{image_class}}", img.class)
                        .replace("{{image_alt}}", img.alt)
                        .replace("{{image_title}}", img.title)
                        .replace("{{image_woosvislug}}", img['data-woosvislug'])
                        .replace("{{image_svizoom}}", img['data-svizoom-image'])
                        .replace("{{image_svikey}}", img['data-svikey'])
                        .replace("{{image_srcset}}", (img.srcset) ? img.srcset : '')
                        .replace("{{image_sizes}}", (img.sizes) ? img.sizes : '')
                        .replace("{{image_width}}", (img.width) ? img.width : '')
                        .replace("{{image_height}}", (img.height) ? img.height : '');
            }
        },
        loadMain: function ($main) {

            if (!$main)
                return;
            var $classes = [''];
            var item = WOOSVI.STARTS.itemBuilder($main, $classes, true);

            $container.find('ul.svithumbnails').append($(item));

        },
        loadThumb: function ($thumbs, $is_selected) {
            if (!$thumbs) {
                if (!$is_selected)
                    WOOSVI.STARTS.loadMain(WOOSVIDATA.gallery.main_image);
                return;
            }

            var $size = Object.keys($thumbs).length;

            if (!$is_selected)
                WOOSVI.STARTS.loadMain(WOOSVIDATA.gallery.main_image);


            WOOSVI.STARTS.reset();

            jQuery.each($thumbs, function ($loop, v) {

                var item = '';
                var item_full = '';
                var $classes = [''];
                var arr, arr_main;

                var $x = $container.find('ul.svithumbnails li').size();

                if ($x === 0 || $x % WOOSVIDATA.columns === 0) {
                    $classes.push('first');
                }
                if (($x + 1) % WOOSVIDATA.columns === 0) {
                    $classes.push('last');
                }
                if ($x === $size)
                    $classes.push('last');

                item = WOOSVI.STARTS.itemBuilder(v, $classes);

                arr = $container.find('ul.svithumbnails li').map(function () {

                    if ($(this).data('thumb') === $(item).data('thumb'))
                        return true;
                }).get();



                if (jQuery.isEmptyObject(arr)) {
                    $container.find('ul.svithumbnails').append($(item));
                }

            });
        },
        reOrderThumbs: function () {

            jQuery.each($container.find('ul.svithumbnails li'), function ($loop, v) {

                var $classes = [''];

                if ($loop === 0 || $loop % WOOSVIDATA.columns === 0) {
                    $classes.push('first');
                }
                if (($loop + 1) % WOOSVIDATA.columns === 0) {
                    $classes.push('last');
                }

                $(v).removeClass('first_pre').removeClass('first').removeClass('last').addClass($classes.join(' '));

            });
        },
        itemBuilder: function (v, $classes, full) {
            var $item = '';

            $item += '<li data-thumb="' + v.thumb[0] + '" data-src="' + v.full[0] + '" class="' + $classes.join(' ') + '">';
            $item += '<div class="sviLoader_thumb"></div>';
            $item += WOOSVI.STARTS.buildImgTag(v.thumbimg);
            $item += '</li>';

            return $item;
        },
        imagesLoaded: function ($is_reset) {
            if ($is_reset)
                $LoadLens_running = false;

            if (runningImgLoader)
                return;

            if ($imagesLoaded) {
                $.getScript("//cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.1/imagesloaded.pkgd.min.js")
                        .done(function (script, textStatus) {
                            WOOSVI.STARTS.runImageProcess($is_reset);
                        })
                        .fail(function (jqxhr, settings, exception) {
                            $("div.log").text("Triggered ajaxError handler.");
                        });
            } else {
                WOOSVI.STARTS.runImageProcess($is_reset);
            }

        },
        runImageProcess: function ($is_reset) {
            runningImgLoader = true;
            $container.imagesLoaded().always(function (instance) {
                $container.find('.sviLoader_thumb').fadeOut().remove();
                if ($('.sivmainloader').length > 0) {
                    $('.sivmainloader').fadeOut('fast', function () {
                        $container.find('.svihidden').removeClass('svihidden');
                        WOOSVI.STARTS.completeAction($is_reset);
                    }).remove();
                } else {
                    $container.removeClass('svihidden');
                    WOOSVI.STARTS.completeAction($is_reset);
                }
            }).done(function (instance) {

            }).progress(function (instance, image) {
            }).fail(function () {
                $container.find('.sviLoader_thumb').fadeOut().remove();
                runningImgLoader = false;
            });
        },
        completeAction: function ($is_reset) {

            if ($is_reset) {
                if ($hide_thumbs)
                    $container.find('div#woosvithumbs').hide();
            }

            // $container.find('.whitespacesvi').remove();
            $container.find('.sviLoader_thumb').fadeOut().remove();
            runningImgLoader = false;

            WOOSVI.STARTS.LoadLens();

            if (!$prettyphoto_running && $woosvi_lightbox) {
                $prettyphoto_running = true;
                $('a[rel^="prettyphoto"], .prettyphoto').prettyPhoto({
                    hook: 'data-rel',
                    social_tools: false,
                    theme: 'pp_woocommerce',
                    horizontal_padding: 20,
                    opacity: 0.8,
                    deeplinking: false
                });
            }
        },
        showVariation: function ($event) {
            $LoadLens_running = false;
            var $items = [];

            $.each(WOOSVI.STARTS.getActiveVariationsInSelect(), function (i, v) {


                var $variation = v.replace(/ /g, '').toLowerCase();

                if (!$variation) {
                    WOOSVI.STARTS.getActiveVariationsInSelect();
                    return false;
                }

                var $items_new = WOOSVI.STARTS.getVariationImages($variation);

                if ($items_new) {
                    $items = $items.concat($items_new);
                }

            });
            if ($items.length > 0) {
                $container.find('ul.svithumbnails li').remove();
                if ($hide_thumbs)
                    $container.find('div#woosvithumbs').show();

                $container.find('div#woosvimain').html('').prepend($(WOOSVI.STARTS.buildImgTag($items[0].fullimg)));

                WOOSVI.STARTS.loadThumb($items, true);
                WOOSVI.STARTS.reOrderThumbs();
                WOOSVI.STARTS.imagesLoaded();
            } else {
                $is_reset = true;
                WOOSVI.STARTS.loadImages(true);
                WOOSVI.STARTS.imagesLoaded(true);
                setTimeout(function () {
                    $is_reset = false;
                }, 500);
            }

        },
        getActiveVariationsInSelect: function () {
            var arr = $form.find('.variations select').map(function () {
                if (this.value !== '')
                    return decodeURI(this.value);
            }).get();

            return arr;
        },
        getVariationImages: function ($variation) {
            var $items = [];
            if ($variation) {

                jQuery.each(WOOSVIDATA.gallery.thumbs, function ($loop, v) {
                    if (v.woosvi_slug && decodeURIComponent(v.woosvi_slug.replace(/ /g, '').toLowerCase()) == $variation)
                        $items.push(v);
                });

                if (WOOSVIDATA.gallery.main_image.woosvi_slug && decodeURIComponent(WOOSVIDATA.gallery.main_image.woosvi_slug.replace(/ /g, '').toLowerCase()) == $variation)
                    $items.push(WOOSVIDATA.gallery.main_image);

                var $size = Object.keys($items).length;

                if ($size > 0)
                    return $items;
                else
                    return false;
            }
        },
        ActivateSwapImage: function () {

            $container.on('click', 'ul.svithumbnails img', function (e) {
                WOOSVI.STARTS.initSwap(this);
            });
        },
        initSwap: function (v) {

            var $svikey = $(v).data('svikey');
            var $image_data = false;
            if ($svikey >= 0)
                $image_data = WOOSVIDATA.gallery.thumbs[$svikey];

            var image = new Image();
            if ($image_data)
                image.src = $image_data.single[0];
            else {
                $image_data = WOOSVIDATA.gallery.main_image;
                image.src = $image_data.single[0];
            }

            if ($('div#woosvimain img').attr('src') != image.src) {
                $('div#woosvimain').prepend('<div class="sviLoader_thumb"></div>');

                $(image).on("load", function () {
                    $('div#woosvimain img').fadeOut('fast').remove();
                    $('div#woosvimain').prepend($(WOOSVI.STARTS.buildImgTag($image_data.fullimg)).hide());
                    $('div#woosvimain img').fadeIn('fast');
                    $('div#woosvimain').find('.sviLoader_thumb').fadeOut().remove();
                    $('div.sviLoader_thumb').remove();
                    $LoadLens_running = false;
                    WOOSVI.STARTS.LoadLens();
                });
            }
        },
        /*LOAD LENS*/
        LoadLens: function () {

            if (!$woosvi_lens)
                return;
            if ($LoadLens_running)
                return;
            $LoadLens_running = true;

            $("div.sviZoomContainer").remove();

            var ez, lensoptions;
            ez = $("div#woosvimain .swiper-slide-active img, div#woosvimain>img");
            lensoptions = {
                container: 'sviZoomContainer',
                attrImageZoomSrc: 'svizoom-image',
                zoomType: 'lens',
                lensShape: 'round',
                lensSize: 150,
                cursor: 'pointer',
                galleryActiveClass: 'active',
                containLensZoom: true,
                loadingIcon: true,
                zIndex: 1000
            };
            ez.ezPlus(lensoptions);
        },
        /*END LOAD LENS*/
        /*PRETTY PHOTO*/
        prettyPhoto: function () {

            if (!$woosvi_lightbox) //IF LIGTHBOX NOT ACTIVE RETURN
                return;


            $container.on('click', 'div#woosvimain img', function (e) {

                e.preventDefault();
                var click_url = $(this).data('svizoom-image');

                var click_title = $(this).attr('title');
                var api_images = [];
                var api_titles = [];
                $('div#woosvithumbs ul.svithumbnails li, div#woosvithumbs .swiper-slide').each(function (i, v) {

                    var $svikey = $(this).find('img').data('svikey');
                    var $image_data = false;
                    if ($svikey >= 0)
                        $image_data = WOOSVIDATA.gallery.thumbs[$svikey];
                    if ($image_data) {
                        api_images.push($image_data.full[0]);
                        api_titles.push($(this).find('img').attr('title'));
                    } else {
                        api_images.push(WOOSVIDATA.gallery.main_image.full[0]);
                        api_titles.push($(this).find('img').attr('title'));
                    }
                });

                if (jQuery.isEmptyObject(api_images)) {
                    api_images.push(click_url);
                    api_titles.push(click_title);
                }

                jQuery.prettyPhoto.open(api_images, api_titles);
                $('div.pp_gallery').find('img[src="' + click_url + '"]').parent().trigger('click');
            });
        },
        /*END PRETTY PHOTO*/
    };
}(jQuery, window, document);
