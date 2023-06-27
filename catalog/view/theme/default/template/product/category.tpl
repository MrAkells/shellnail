<?php echo $header; ?>
<div class="container">
    <div class="row">
        <?php echo $column_left; ?>
        <div id="content" class="col-xs-12 col-sm-12 col-md-9">
            <?php echo $content_top; ?>


            <ul class="hidden-xs hidden-sm breadcrumbs list-inline" itemscope itemtype="https://schema.org/BreadcrumbList">
                <?php $i=0; ?>
                <?php foreach ($breadcrumbs as $i => $breadcrumb) { ?>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <?php if($i+1 < count($breadcrumbs)) { ?>
                            <a class="crumb" itemprop="item" href="<?php echo $breadcrumb['href']; ?>">
                                <span itemprop="name"><?php echo $breadcrumb['text']; ?></span>
                            </a>
                            <meta itemprop="position" content="<?php echo $i+1; ?>" /> 
                        <?php } else { ?>
                            <span class="crumb" >
                                <span itemprop="name"><?php echo $breadcrumb['text']; ?></span>
                            </span>
                            <meta itemprop="position" content="<?php echo $i+1; ?>" /> 
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>

            <h1 itemprop="name">
                <?php echo $heading_title; ?>
            </h1>

            <?php if ($categories && !isset($promo) && !$is_filter_applied) { ?>
            <?php if (count($categories) <= 5) { ?>
            <div class="row row-flex row-daughter-category">
                <?php foreach ($categories as $category) { ?>
                <div class="col-sm-3 col-xs-6 col-refine">
                    <div class="daughter-category">
                        <a href="<?php echo $category['href']; ?>">
                  <img src="<?php echo $category['categ_image'] ?>" alt="Image category" class="img-responsive">
              <div class="daughter-category-name"><?php echo $category['name']; ?></div>
              </a>
                    </div>

                </div>
                <?php } ?>
            </div>
            <?php } else { ?>
            <div class="row row-flex row-daughter-category">
                <?php foreach (array_chunk($categories, ceil(count($categories) / 4)) as $categories) { ?>
                <?php foreach ($categories as $category) { ?>
                <div class="col-sm-3 col-xs-6 col-refine">
                    <div class="daughter-category">
                        <a href="<?php echo $category['href']; ?>">
                  <img src="<?php echo $category['categ_image']; ?>" alt="Image category" class="img-responsive"><div class="daughter-category-name">
            <?php echo $category['name']; ?></div>
              </a>
                    </div>

                </div>
                <?php } ?>
                <?php } ?>
            </div>
            <?php } ?>
            <?php } ?>


            <?php if (isset($promo)) { ?>
            <div class="row more-detailed-promotion">
                <div class="col-sm-6">

                    <p class="number-of-goods">
                        <?php echo $text_promo_product; ?>
                        <?php echo $promo['count']; ?>
                    </p>
                    <div class="look-over">
                        <img src="catalog/view/theme/default/image/icon-eye.png" alt="Avatar" class="img-avatar">
                        <?php echo $text_look_over; ?>
                        <?php echo $promo['observers']; ?> <?php echo $text_people ?>
                    </div>
                    <!--<div class="new-popover">Показано 5</div>-->
                    <div style="clear: left"></div>

                    <p class="promo-description">
                        <?php echo $promo['description']; ?>
                    </p>

                    <div class="promo-fb-line">
                        <?php $datafbsave = $promo['href']; ?>
                        <div class="fb-save" data-uri="<?php echo $datafbsave; ?>" data-size="small"></div>

                        <div class="fb-like" data-href="<?php echo $promo['href']; ?>" data-layout="button" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>

                        <div class="fb-share-button" data-href="<?php echo $promo['href']; ?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"><?php echo $text_btn_fb_share ?></a></div>
                    </div>

                    <div id="end_of_promo<?php echo $promo['promo_id']; ?>" data-seconds="<?php echo $promo['endtime']; ?>"></div>
                </div>
                <div class="col-sm-6 right-promotion">
                    <div class="promotion-crop-cat" style="background-image:url(<?php echo $promo['thumb']; ?>);">
                        <img src="<?php echo $promo['thumb_m']; ?>" class="promotion-crop-cat-img" />
                    </div>
                    <p class="period-promotion">
                        <?php echo $text_action_do; ?>
                        <?php echo $promo['date_end']; ?>
                    </p>
                    <div id="simple-timer<?php echo $promo['promo_id']; ?>" class="simple-timer">
                        <div class="casing">
                            <span class="timer-day<?php echo $promo['promo_id']; ?> timer-digits"></span>
                            <span class="timer-word"><?php echo $text_day; ?></span>
                        </div>
                        <label class="separator">:</label>
                        <div class="casing">
                            <span class="timer-hour<?php echo $promo['promo_id']; ?> timer-digits"></span>
                            <span class="timer-word"><?php echo $text_hour; ?></span>
                        </div>
                        <label class="separator">:</label>
                        <div class="casing">
                            <span class="timer-minute<?php echo $promo['promo_id']; ?> timer-digits"></span>
                            <span class="timer-word"><?php echo $text_minute; ?></span>
                        </div>
                        <label class="separator">:</label>
                        <div class="casing">
                            <span class="timer-second<?php echo $promo['promo_id']; ?> timer-digits"></span>
                            <span class="timer-word"><?php echo $text_second; ?></span>
                        </div>
                    </div>
                </div>






                <script type="text/javascript">
                    $(document).ready(function() {

                        (function($) {
                            var defaluts = {
                                day: 0,
                                dayDom: '',
                                hour: 0,
                                hourDom: '',
                                minute: 1,
                                minuteDom: '',
                                second: 0,
                                secondDom: '',
                                millisecond: 0,
                                millisecondDom: '',
                                blank: 1000,
                                pause: '',
                                pauseFun: '',
                                goonFun: '',
                                endFun: '',
                                animation: 'none'
                            };

                            $.fn.extend({
                                stamp: 0,
                                intervalObj: {},
                                state: 1,
                                simpletimer: function(options) {
                                    var _self = this;
                                    var options = $.extend({}, defaluts, options);

                                    _self.stamp = parseInt(options.millisecond) +
                                        10 * parseInt(options.second) +
                                        600 * parseInt(options.minute) +
                                        36000 * parseInt(options.hour) +
                                        864000 * parseInt(options.day);
                                    this._dida(options);
                                    this._pause(options);
                                },
                                _pause: function(options) {
                                    var _self = this;

                                    $(options.pause).on('click', function() {
                                        console.log(2);
                                        if (_self.state === 1) {
                                            _self.state = 0;
                                            clearInterval(_self.intervalObj);
                                            $(this).html('Resume');
                                            options.pauseFun();
                                        } else {
                                            _self.state = 1;
                                            _self._dida(options);
                                            options.goonFun();
                                        }
                                    });
                                },
                                _dida: function(options) {
                                    var _self = this;
                                    _self.intervalObj = setInterval(function() {
                                        var temp = _self.stamp;
                                        var day = Math.floor(temp / 864000);
                                        temp = temp % 864000;
                                        var hour = Math.floor(temp / 36000);
                                        temp = temp % 36000;
                                        var minute = Math.floor(temp / 600);
                                        temp = temp % 600;
                                        var second = Math.floor(temp / 10);
                                        var millisecond = temp % 10;
                                        $(options.dayDom).html(_self.prefixInteger(day, 2));
                                        $(options.hourDom).html(_self.prefixInteger(hour, 2));
                                        $(options.minuteDom).html(_self.prefixInteger(minute, 2));
                                        $(options.secondDom).html(_self.prefixInteger(second, 2));
                                        $(options.millisecondDom).html(_self.prefixInteger(millisecond, 1));
                                        _self.stamp = _self.stamp - (options.blank / 100).toFixed(0);
                                        if (_self.stamp < 0) {
                                            _self.state = 0;
                                            clearInterval(_self.intervalObj);
                                            options.endFun();
                                        }
                                    }, parseInt(options.blank));
                                },
                                prefixInteger: function(num, length) {
                                    return ("0000" + num).substr(-length);
                                }
                            });

                        })(jQuery);
                    });


                    $(document).ready(function() {

                        var d = new Date();
                        var seconds_now = Math.round(d.getTime() / 1000);
                        var end = $('#end_of_promo<?php echo $promo['promo_id']; ?>').data('seconds');
                        var seconds_to_end = end - seconds_now;
                        var days = Math.floor(seconds_to_end / (3600 * 24));
                        var hour = Math.floor((seconds_to_end - (days * 3600 * 24)) / 3600);
                        var minutes = Math.floor((seconds_to_end - (days * 3600 * 24) - (hour * 3600)) / 60);
                        var seconds = seconds_to_end - (days * 3600 * 24) - (hour * 3600) - (minutes * 60);


                        $('#simple-timer<?php echo $promo['promo_id']; ?>').simpletimer({
                            day: days,
                            dayDom: '.timer-day<?php echo $promo['promo_id']; ?>',
                            hour: hour,
                            hourDom: '.timer-hour<?php echo $promo['promo_id']; ?>',
                            minute: minutes,
                            minuteDom: '.timer-minute<?php echo $promo['promo_id']; ?>',
                            second: seconds,
                            secondDom: '.timer-second<?php echo $promo['promo_id']; ?>'
                        });

                    });
                </script>


            </div>
            <?php } ?>

            <?php if ($products) { ?>
            <div class="row row-flex sorting-tools">
                <div class="col-md-2 col-sm-6 hidden">
                    <div class="btn-group btn-group-sm">
                        <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
                        <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
                    </div>
                </div>
                <div class="col-lg-6 col-md-5 col-sm-5 col-xs-4 sort-different">
                    <div class="form-group input-group input-group-sm">
                        <label class="input-group-addon" for="input-sort"><?php echo $text_sort; ?></label>

                        <?php if ($langcode == 'uk-ua') {
                            $current_lang = "lang_ua";
                        } ?>
                        <?php if ($langcode == 'ru-ru') {
                            $current_lang = "lang_ru";
                        } ?>

                        <ul class="new-sorting list-inline visible-lg <?php echo $current_lang; ?>">

                            <?php if ('p.sort_order-ASC' == $sort . '-' . $order) { ?>
                            <li class='selected_sort'><span class="sort-signal sort-up"><i class="fa fa-sort-amount-asc"></i></span><a onclick="location = '<?php echo $sorts['p.sort_order-DESC']['href']; ?>';"><?php echo $text_po_poryadku_asc; ?></a></li>
                            <?php }else if('p.sort_order-DESC' == $sort . '-' . $order){ ?>
                            <li class='selected_sort'><span class="sort-signal sort-up"><i class="fa fa-sort-amount-desc"></i></span><a onclick="location = '<?php echo $sorts['p.sort_order-ASC']['href']; ?>';"><?php echo $text_po_poryadku_asc; ?></a></li>
                            <?php } else{ ?>
                            <li><a onclick="location = '<?php echo $sorts['p.sort_order-ASC']['href']; ?>';">По порядку </a></li>
                            <?php } ?>


                            <?php if('p.date_added-DESC' == $sort . '-' . $order){ ?>
                            <li class='selected_sort'><a onclick="location = '<?php echo $sorts['p.date_added-ASC']['href']; ?>';"><?php echo $text_newest_desc; ?></a></li>
                            <?php } else{ ?>
                            <li><a onclick="location='<?php echo $sorts['p.date_added-DESC']['href']; ?>';"><?php echo $text_newest_desc; ?></a></li>
                            <?php } ?>




                            <?php if('p.viewed-DESC' == $sort . '-' . $order){ ?>
                            <li class='selected_sort'><a onclick="location='<?php echo $sorts['p.viewed-ASC']['href']; ?>';"><?php echo $text_most_viewed_desc; ?></a></li>
                            <?php } else{ ?>
                            <li><a onclick="location='<?php echo $sorts['p.viewed-DESC']['href']; ?>';"><?php echo $text_most_viewed_desc; ?></a></li>
                            <?php } ?>
                        </ul>
                        <?php 
                        unset($sorts['p.viewed-ASC']);
                        unset($sorts['p.sort_order-DESC']);
                        unset($sorts['p.date_added-ASC']);
                        ?>
                        <select id="input-sort" class="form-control hidden-lg" onchange="location = this.value;" style="width: 120px; position: absolute; opacity: 0; height: 34px; font-size: 12px; z-index: 5;">
              <?php foreach ($sorts as $key=>$sortss) { ?>
              
              <?php if($key=='p.price-ASC' || $key=='p.price-DESC'){
                continue;
              } ?>
              
              <?php if ($sortss['value'] == $sort . '-' . $order) { ?>
              <option value="<?php echo $sortss['href']; ?>" selected="selected"><?php echo $sortss['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $sortss['href']; ?>"><?php echo $sortss['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
                        <span class="form-control customSelect transparentSelect  hidden-lg" style="display: inline-block; width: 120px;"><span class="customSelectInner" style="width: 120px; display: inline-block;">9</span></span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-5 sort-price">
                    <div class="form-group input-group input-group-sm">
                        <label class="input-group-addon" for="isort-price"><?php echo $text_price; ?></label>
                        <ul class="new-sorting list-inline visible-lg">

                            <?php if ('p.price-ASC' == $sort . '-' . $order) { ?>
                            <li class='selected_sort'><a onclick="location='<?php echo $sorts['p.price-ASC']['href']; ?>';"><?php echo $text_cheaper; ?></a></li>
                            <?php } else{ ?>
                            <li><a onclick="location='<?php echo $sorts['p.price-ASC']['href']; ?>';"><?php echo $text_cheaper; ?></a></li>
                            <?php } ?>

                            <?php if ('p.price-DESC' == $sort . '-' . $order) { ?>
                            <li class='selected_sort'><a onclick="location='<?php echo $sorts['p.price-DESC']['href']; ?>';"><?php echo $text_more_expensive; ?></a></li>
                            <?php } else{ ?>
                            <li><a onclick="location='<?php echo $sorts['p.price-DESC']['href']; ?>';"><?php echo $text_more_expensive; ?></a></li>
                            <?php } ?>



                        </ul>
                        <select id="sort-price" class="form-control hidden-lg" style="width: 100px; position: absolute; opacity: 0; height: 34px; font-size: 12px; z-index: 5;" onChange="location=this.value;">
               
              <?php if('p.price-ASC' == $sort . '-' . $order){ ?> 
              <option value="<?php echo $sorts['p.price-ASC']['href']; ?>" selected><?php echo $text_cheaper; ?></option>
            <?php }else{ ?>
            <option value="<?php echo $sorts['p.price-ASC']['href']; ?>" ><?php echo $text_cheaper; ?></option>
            <?php } ?>
            
             <?php if('p.price-DESC' == $sort . '-' . $order){ ?> 
              <option value="<?php echo $sorts['p.price-DESC']['href']; ?>" selected><?php echo $text_more_expensive; ?></option>
              <?php }else{ ?>
              <option value="<?php echo $sorts['p.price-DESC']['href']; ?>"><?php echo $text_more_expensive; ?></option>
              <?php } ?>
              <?php if('p.price-ASC' != $sort . '-' . $order && 'p.price-DESC' != $sort . '-' . $order){ ?>
              <option value="" selected><?php echo $text_not_chosen; ?></option>
              <?php } ?>
            </select>
                        <span class="form-control customSelect transparentSelect  hidden-lg" style="display: inline-block; width: 100px;"><span class="customSelectInner" style="width: 100px; display: inline-block;">9</span></span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 sort-number ">
                    <div class="form-group input-group input-group-sm">
                        <label class="input-group-addon" for="input-limit"><?php echo $text_limit; ?></label>
                        <select id="input-limit" class="form-control" onchange="location = this.value;" style="width: 60px; position: absolute; opacity: 0; height: 34px; font-size: 12px; z-index: 5;">
              <?php foreach ($limits as $limits) { ?>
              <?php if ($limits['value'] == $limit) { ?>
              <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
                        <span class="customSelect form-control" style="display: inline-block; width: 60px;"><span class="customSelectInner" style="width: 60px; display: inline-block;">9</span></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($products as $product) { ?>
                <div class="product-layout product-list col-xs-6 grid-product js_infscrl">
                    <ul class="list-inline bts-wish-compare">
                        <?php if($product['video_link']){ ?>
                        <li class='magni_youtube'>
                            <img onclick="create_frame_popup($(this))" data-video_link="<?php echo $product['video_link']; ?>" style='width: 24px; cursor:pointer;' src="image/video-tovara-youtube.png" alt="youtube"  width="24" height="17" >
                        </li>
                        <?php } ?>
                        <li>
                            <button class="btn-transparent" data-product_id="<?php echo $product['product_id']; ?>" onclick="compare.add($(this))"><img src="catalog/view/theme/default/image/icon-small-compare.png" alt="Compare" width="26" height="19" ></button>
                        </li>
                        <li>
                            <button class="btn-transparent" data-product_id="<?php echo $product['product_id']; ?>" onclick="wishlist.add($(this))"><img src="catalog/view/theme/default/image/icon-small-heart.png" alt="Wishlist" width="19" height="17" ></button>
                        </li>
                    </ul>
                    <div class="product-thumb">
                        <div class="image"><a href="<?php echo $product['href']; ?>"><img class="<?php echo $product['quantity']>0?'':'colorless'; ?>" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" width="<?php echo $product['img_width']; ?>" height="<?php echo $product['img_height']; ?>" /></a></div>
                        <div>
                            <div class="caption">
                                <div class="name-product">
                                    <a href="<?php echo $product['href']; ?>">
                                        <?php echo $product['name']; ?>
                                    </a>
                                </div>
                                <div class="product_art_stat">
                                    <?php if($product['sku']){ ?>
                                    <p class="artikul"><span><?php echo $text_artikul; ?>:</span> <span><?php echo $product['sku']; ?></span></p>
                                    <?php } ?>
                                    <?php if($product['quantity']>0){ ?>
                                    <p class="produc-status"><i class="fa fa-check"></i>
                                        <?php echo $text_instock; ?>
                                    </p>
                                    <?php }else{ ?>
                                    <p class="produc-status is_not_present">
                                        <?php echo $text_outstock; ?>
                                    </p>
                                    <?php } ?>
                                </div>


                                <?php if ($product['rating']) { ?>
                                <div class="rating">
                                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                                    <?php if ($product['rating'] < $i) { ?>
                                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                    <?php } else { ?>
                                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                    <?php } ?>
                                    <?php } ?>
                                </div>

                                <?php if($product['reviews']){ ?>
                                            <div class="reviews">
                                                <span><?php echo $product['reviews']; ?></span> 
                                                <span><?php echo  $text_reviews_number; ?></span>
                                            </div>
                                        <?php } ?>
                                <?php } else{ ?>
                                <!-- <div class="rating">
                                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                </div> -->
                                <?php } ?>
                                <div style="clear: left"></div>
                                <?php if ($product['price']) { ?>
                                <p class="price">
                                    <?php if (!$product['special']) { ?>
                                    <?php echo $product['price']; ?>
                                    <?php } else { ?>
                                    <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                                    <?php } ?>
                                    <?php if ($product['tax']) { ?>
                                    <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                                    <?php } ?>
                                </p>
                                <?php } ?>
                            </div>




                            <?php if(!$product['quantity'] || $product['quantity']<1){ ?>
                            <div class="btn-two">
                                <button type="button" class="notify-of-availability order" data-toggle="modal" data-target="#preoder" data-product="<?php echo $product['name']; ?>" data-product_url="<?php echo $product['href']; ?>" data-product_id="<?php echo $product['product_id']; ?>"
                                    data-product_img="<?php echo $product['thumb']; ?>" data-product_price="<?php echo $product['price']; ?>"><span class="title-one-click"><?php echo $button_notify_availability; ?></span></button>
                            </div>
                            <?php }else{ ?>
                            <div class="btn-two">
                                <button type="button" class="btn-add-cart" data-fbq_sku="<?php echo $product['sku']; ?>" data-fbq_name="<?php echo $product['name']; ?>" data-fbq_price="<?php echo $product['intprice']; ?>" onclick="prepare_fbq($(this)); cart.add('<?php echo $product['product_id']; ?>');"><img src="catalog/view/theme/default/image/icon-small-cart.png" alt="<?php echo $button_cart; ?>" width="16" height="22"> <span class=""><?php echo $button_cart; ?></span></button>
                                <button type="button" class="buy-one-click order" data-toggle="modal" data-target="#order" data-fbq_sku="<?php echo $product['sku']; ?>" data-fbq_name="<?php echo $product['name']; ?>" data-fbq_price="<?php echo $product['intprice']; ?>" data-product_id="<?php echo $product['product_id']; ?>"
                                    data-product="<?php echo $product['name']; ?>" data-product_url="<?php echo $product['href']; ?>" data-product_img="<?php echo $product['thumb']; ?>" data-product_price="<?php echo $product['price']; ?>" onclick="prepare_fbq($(this));"><img src="catalog/view/theme/default/image/icon-small-phone.png" alt="<?php echo $text_buy_one_click; ?>" width="16" height="23"> <span class="title-one-click"><?php echo $text_buy_one_click; ?></span></button>
                            </div>

                            <?php } ?>


                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <?php if($pagination){ ?>
            <div id="pre_pagination" class="pre_pagination" onclick="NextProducts()"><span><?php echo $load_more_products ?></span></div>
            <?php } ?>

            <div id="pagination_row" class="row ">
                <div class="pagination-casing">
                    <?php echo $pagination; ?>
                </div>

            </div>
            <?php } ?>
            <?php if (!$categories && !$products) { ?>
            <p>
                <?php echo $text_empty; ?>
            </p>
            <div class="buttons">
                <div class="pull-right">
                    <a href="<?php echo $continue; ?>" class="btn btn-primary">
                        <?php echo $button_continue; ?>
                    </a>
                </div>
            </div>
            <?php } ?>
            <?php echo $content_bottom; ?>
            <div class="row">
                <?php if ($description && $number_page ==1) { ?>
                <div class="col-xs-12">
                    <?php echo $description; ?>
                </div>
                <?php } ?>
            </div>


        </div>



    </div>
    <script type="text/javascript">
        function create_frame_popup(elem) {
            var link = elem.data('video_link');
            $.magnificPopup.open({
                items: {
                    src: link
                },
                type: 'iframe'
            });
        }
        $(document).ready(function() {
            $(".form-group").each(function() {
                $(this).find(".customSelectInner").html($(this).find("select :selected").html());

            });

        });
    </script>
    <?php echo $footer; ?>