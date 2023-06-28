<div id="promotions-and-discounts" class="col-xs-12 envelope new-product">
<h2 class="title-promotions visible-xs"><?php echo $text_promotions; ?></h2>
    <ul class="nav nav-tabs">
         <li class="non-tab hidden-xs"><h2 class="title-promotions"><?php echo $text_promotions; ?></h2></li>
        <?php foreach($promotions as $key=>$promo){ ?>
            <?php if($key == 0){ ?>
                 <li class="active"><a data-toggle="tab" href="#promo<?php echo $promo['promo_id']; ?>"><?php echo $promo['title']; ?></a></li>
            <?php }else{ ?>
                 <li><a class="<?php echo $key>=4?'hidden-xs':''; ?>" data-toggle="tab" href="#promo<?php echo $promo['promo_id']; ?>"><?php echo $promo['title']; ?></a></li>
            <?php } ?>
        <?php } ?>
    </ul>

    <div class="tab-content">
        <?php foreach($promotions as $key=>$promo){ ?>
            <?php if($key==0){ ?>
                <div id="promo<?php echo $promo['promo_id']; ?>" class="tab-pane fade in active">
            <?php }else{ ?>
                <div id="promo<?php echo $promo['promo_id']; ?>" class="tab-pane fade ">
            <?php } ?>
                <?php if ($promo['products']) { ?>
                    <div id="promo_products<?php echo $promo['promo_id']; ?>" class="owl-carousel">
                        <?php foreach ($promo['products'] as $product) { ?>
                        <div class="item">
                            
                                <ul class="list-inline bts-wish-compare">
                                    <li>
                                       <button class="btn-transparent" data-product_id="<?php echo $product['product_id']; ?>" onclick="compare.add($(this))"><img src="catalog/view/theme/default/image/icon-small-compare.png" alt="Compare"></button>
                                    </li>
                                    <li>
                                      <button class="btn-transparent" data-product_id="<?php echo $product['product_id']; ?>" onclick="wishlist.add($(this))"><img src="catalog/view/theme/default/image/icon-small-heart.png" alt="Wishlist"></button>
                                    </li>
                                </ul>
                            <div class="product-thumb">
                                
                                <div class="image"><a href="<?php echo $product['href']; ?>"><img class="<?php echo $product['quantity']>0?'':'colorless'; ?>" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>
                                </div>
                                
                            <div>
                                <div class="caption">
                                    <div class="name-product"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                    <?php if($product['sku']){ ?>
                                    <p class="artikul"><span><?php echo $text_artikul; ?>:</span> <span><?php echo $product['sku']; ?></span></p>
                                    <?php } ?>
                                    <?php if(!$product['quantity'] || $product['quantity']<1){ ?>
                                     <p class="produc-status is_not_present"><?php echo $text_outstock; ?></p>
                                    <?php }else{ ?>
                                   <p class="produc-status"><i class="fa fa-check"></i><?php echo $text_instock; ?> </p>
                                    <?php } ?>

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

                            </div>
                                
                            <?php if(!$product['quantity'] || $product['quantity']<1){ ?>
                            <div class="btn-two">
                                <button type="button" class="notify-of-availability order" data-toggle="modal" data-target="#preoder" data-product="<?php echo $product['name']; ?>" data-product_url="<?php echo $product['href']; ?>" data-product_id="<?php echo $product['product_id']; ?>" data-product_img="<?php echo $product['thumb']; ?>" data-product_price="<?php echo $product['price']; ?>"><span class="title-one-click"><?php echo $button_notify_availability; ?></span></button>
                            </div>
                            <?php }else{ ?>
                             <div class="btn-two">
                                <button type="button" class="btn-add-cart" data-fbq_sku="<?php echo $product['sku']; ?>" data-fbq_name="<?php echo $product['name']; ?>" data-fbq_price="<?php echo $product['intprice']; ?>" onclick="prepare_fbq($(this)); cart.add('<?php echo $product['product_id']; ?>');"><img src="catalog/view/theme/default/image/icon-small-cart.png" alt="New"> <span class=""><?php echo $button_cart; ?></span></button>
                                <button type="button" class="buy-one-click order" data-toggle="modal" data-target="#order" data-fbq_sku="<?php echo $product['sku']; ?>" data-fbq_name="<?php echo $product['name']; ?>" data-fbq_price="<?php echo $product['intprice']; ?>" data-product_id="<?php echo $product['product_id']; ?>" data-product="<?php echo $product['name']; ?>" data-product_url="<?php echo $product['href']; ?>" data-product_product_id="false" data-product_img="<?php echo $product['thumb']; ?>" data-product_price="<?php echo $product['price']; ?>" onclick="prepare_fbq($(this));"><img src="catalog/view/theme/default/image/icon-small-phone.png" alt="New"> <span class="title-one-click"><?php echo $button_buy_click; ?></span></button>
       
                            </div>
                           
                            <?php } ?>
                        </div>
          </div>
        </div>
            <?php } ?> 
            </div>
        
        <script type="text/javascript">
            $(document).ready(function(){
                $('#promo_products<?php echo $promo['promo_id']; ?>').owlCarousel({
                    items: 4,
                    autoPlay: false,
                    singleItem: false,
                    nav: true, 
                    navText: ['<img src="catalog/view/theme/default/image/arrow-violet.png" alt="Prew" class="violet-prev">','<img src="catalog/view/theme/default/image/arrow-violet.png" alt="Next" >'],
                    autoWidth: true,
                    dots: false,
                    pagination: false,
                    responsive:{
        0:{
            items:1
        },
        481:{
            items:2
        },
        769:{
            items:3
        },
        1200:{
            items:4
        }
    }
                });
            }); 
        </script>
      
    <?php } ?>
    
            </div>
            
        <?php } ?>
        </div>

    </div>







