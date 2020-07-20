<?php echo $header; ?>
<div class="container">
    <div class="row">
        <?php echo $column_left; ?>

        <div id="content" class="col-md-9">
            <?php echo $content_top; ?>
            <ul class="breadcrumbs list-inline" itemscope itemtype="http://schema.org/BreadcrumbList">
                <?php $i=0; ?>
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" class="crumb" href="<?php echo $breadcrumb['href']; ?>"><span itemprop="name"><?php echo $breadcrumb['text']; ?></span></a>
                    <meta itemprop="position" content="<?php echo $i++; ?>">
                </li>
                <?php } ?>
            </ul>
            <h1 itemprop="name">
                <?php echo $heading_title; ?>
            </h1>
            <div>

                <?php if ($description) { ?>
                <div id="short_description" class="short-description">
                    <?php echo $short_description; ?>
                </div>
                <div id="full_description" class="short-description hidden">
                    <?php echo $description; ?>
                </div>
                <span id="toogle_description"><?php echo $btn_more_detailed; ?></span>
                <script>
                    $('#toogle_description').click(function() {
                        if ($('#full_description').hasClass('hidden')) {
                            $('#full_description').removeClass('hidden');
                            $('#short_description').addClass('hidden');
                            $(this).html('<?php echo $btn_less_detailed; ?>');
                        } else {
                            $('#full_description').addClass('hidden');
                            $('#short_description').removeClass('hidden');
                            $(this).html('<?php echo $btn_more_detailed; ?>');
                            var h1 = $('h1').offset().top - 70;
                            $('html, body').animate({
                                scrollTop: h1
                            }, 'slow');
                        }
                    });
                </script>

                <?php } ?>


            </div>
            <hr>

            <?php if ($products) { ?>
            <div class="row row-flex sorting-tools">
                <div class="col-md-2 col-sm-6 hidden">
                    <div class="btn-group btn-group-sm">
                        <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
                        <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
                    </div>
                </div>
                <div class="col-lg-6 col-md-5 col-sm-5 col-xs-7 sort-different">
                    <div class="form-group input-group input-group-sm">
                        <label class="input-group-addon" for="input-sort"><?php echo $text_sort; ?></label>
                        <ul class="new-sorting list-inline visible-lg">

                            <?php if ('p.sort_order-ASC' == $sort . '-' . $order) { ?>
                            <li class='selected_sort'><span class="sort-signal sort-up"><i class="fa fa-sort-amount-asc"></i></span><a onclick="location = '<?php echo $sorts['p.sort_order-DESC']['href']; ?>';">По порядку</a></li>
                            <?php }else if('p.sort_order-DESC' == $sort . '-' . $order){ ?>
                            <li class='selected_sort'><span class="sort-signal sort-up"><i class="fa fa-sort-amount-desc"></i></span><a onclick="location = '<?php echo $sorts['p.sort_order-ASC']['href']; ?>';">По порядку</a></li>
                            <?php } else{ ?>
                            <li><a onclick="location = '<?php echo $sorts['p.sort_order-ASC']['href']; ?>';">По порядку </a></li>
                            <?php } ?>


                            <?php if('p.date_added-DESC' == $sort . '-' . $order){ ?>
                            <li class='selected_sort'><a onclick="location = '<?php echo $sorts['p.date_added-ASC']['href']; ?>';">Новинки</a></li>
                            <?php } else{ ?>
                            <li><a onclick="location = '<?php echo $sorts['p.date_added-DESC']['href']; ?>';">Новинки</a></li>
                            <?php } ?>




                            <?php if('p.viewed-DESC' == $sort . '-' . $order){ ?>
                            <li class='selected_sort'><a onclick="location = '<?php echo $sorts['p.viewed-ASC']['href']; ?>';">Популярные</a></li>
                            <?php } else{ ?>
                            <li><a onclick="location = '<?php echo $sorts['p.viewed-DESC']['href']; ?>';">Популярные</a></li>
                            <?php } ?>



                        </ul>
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
                        <label class="input-group-addon" for="isort-price">Цена:</label>
                        <ul class="new-sorting list-inline visible-lg">

                            <?php if ('p.price-ASC' == $sort . '-' . $order) { ?>
                            <li class='selected_sort'><a onclick="location = '<?php echo $sorts['p.price-ASC']['href']; ?>';">Дешевле</a></li>
                            <?php } else{ ?>
                            <li><a onclick="location = '<?php echo $sorts['p.price-ASC']['href']; ?>';">Дешевле</a></li>
                            <?php } ?>

                            <?php if ('p.price-DESC' == $sort . '-' . $order) { ?>
                            <li class='selected_sort'><a onclick="location = '<?php echo $sorts['p.price-DESC']['href']; ?>';">Дороже</a></li>
                            <?php } else{ ?>
                            <li><a onclick="location = '<?php echo $sorts['p.price-DESC']['href']; ?>';">Дороже</a></li>
                            <?php } ?>



                        </ul>
                        <select id="sort-price" class="form-control hidden-lg" style="width: 100px; position: absolute; opacity: 0; height: 34px; font-size: 12px; z-index: 5;" onChange="location=this.value;">
               
              <?php if('p.price-ASC' == $sort . '-' . $order){ ?> 
              <option value="<?php echo $sorts['p.price-ASC']['href']; ?>" selected>Дешевле</option>
            <?php }else{ ?>
            <option value="<?php echo $sorts['p.price-ASC']['href']; ?>" >Дешевле</option>
            <?php } ?>
            
             <?php if('p.price-DESC' == $sort . '-' . $order){ ?> 
              <option value="<?php echo $sorts['p.price-DESC']['href']; ?>" selected>Дороже</option>
              <?php }else{ ?>
              <option value="<?php echo $sorts['p.price-DESC']['href']; ?>">Дороже</option>
              <?php } ?>
              <?php if('p.price-ASC' != $sort . '-' . $order && 'p.price-DESC' != $sort . '-' . $order){ ?>
              <option value="" selected>Не выбрано</option>
              <?php } ?>
            </select>
                        <span class="form-control customSelect transparentSelect  hidden-lg" style="display: inline-block; width: 100px;"><span class="customSelectInner" style="width: 100px; display: inline-block;">9</span></span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-5 sort-number hidden-xs">
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

                <div class="product-layout product-list col-xs-12 grid-product js_infscrl">
                    <ul class="list-inline bts-wish-compare">
                        <?php if($product['video_link']){ ?>
                        <li class='magni_youtube'>
                            <img style='width: 24px' src="image/video-tovara-youtube.png" alt="youtube">
                        </li>
                        <?php } ?>
                        <li>
                            <button class="btn-transparent" data-product_id="<?php echo $product['product_id']; ?>" onclick="compare.add($(this))"><img src="catalog/view/theme/default/image/icon-small-compare.png" alt="Compare"></button>
                        </li>
                        <li>
                            <button class="btn-transparent" data-product_id="<?php echo $product['product_id']; ?>" onclick="wishlist.add($(this))"><img src="catalog/view/theme/default/image/icon-small-heart.png" alt="Wishlist"></button>
                        </li>
                    </ul>
                    <div class="product-thumb">
                        <div class="image"><a href="<?php echo $product['href']; ?>"><img class="<?php echo $product['quantity']>0?'':'colorless'; ?>" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
                        <div>
                            <div class="caption">
                                <h4 class="name-product">
                                    <a href="<?php echo $product['href']; ?>">
                                        <?php echo $product['name']; ?>
                                    </a>
                                </h4>

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
                                <?php } else{ ?>
                                <div class="rating">
                                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                </div>
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
                                <button type="button" class="btn-add-cart" data-fbq_sku="<?php echo $product['sku']; ?>" data-fbq_name="<?php echo $product['name']; ?>" data-fbq_price="<?php echo $product['intprice']; ?>" onclick="prepare_fbq($(this)); cart.add('<?php echo $product['product_id']; ?>');"><img src="catalog/view/theme/default/image/icon-small-cart.png" alt="New"> <span class=""><?php echo $button_cart; ?></span></button>
                                <button type="button" class="buy-one-click order" data-toggle="modal" data-target="#order" data-fbq_sku="<?php echo $product['sku']; ?>" data-fbq_name="<?php echo $product['name']; ?>" data-fbq_price="<?php echo $product['intprice']; ?>" data-product_id="<?php echo $product['product_id']; ?>"
                                    data-product="<?php echo $product['name']; ?>" data-product_url="<?php echo $product['href']; ?>" data-product_img="<?php echo $product['thumb']; ?>" data-product_price="<?php echo $product['price']; ?>" onclick="prepare_fbq($(this));"><img src="catalog/view/theme/default/image/icon-small-phone.png" alt="New"> <span class="title-one-click">Купить в один клик</span></button>
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

            <div id="pagination_row" class="row hidden-xs">
                <div class="pagination-casing">
                    <?php echo $pagination; ?>
                </div>
            </div>
            <?php } else { ?>
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
        </div>
        <?php echo $column_right; ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".form-group").each(function() {
            $(this).find(".customSelectInner").html($(this).find("select :selected").html());

        });
    });
</script>
<?php echo $footer; ?>