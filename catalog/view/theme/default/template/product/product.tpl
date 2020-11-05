<?php echo $header; ?>
<script>
    fbq('track', 'ViewContent',{
        content_type: 'product',
        content_ids: ['<?php echo $sku; ?>'],
        content_name: '<?php echo $heading_title; ?>',
        currency: 'UAH', 
        value: '<?php echo $intprice; ?>'
    });
</script>
<!--Тег-события-для-Google-merchant-center-->
<script>
  gtag('event', 'view_item', {
    'send_to': 'AW-969257410',
    'value': '<?php echo $intprice; ?>',
    'items': [{
      'id': '<?php echo $sku; ?>',
      'google_business_vertical': 'retail'
    }]
  });
</script>
<!--/Тег-события-для-Google-merchant-center-->
<div class="container">
  <div class="row">
  <?php echo $column_left; ?>
    <div id="content" class="col-xs-12 col-md-9"><?php echo $content_top; ?>


    <ul class="hidden-xs hidden-sm breadcrumbs list-inline" itemscope itemtype="http://schema.org/BreadcrumbList">
        <?php $i=0; ?>
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
          <a itemprop="item" class="crumb" href="<?php echo $breadcrumb['href']; ?>">
           <span itemprop="name"><?php echo $breadcrumb['text']; ?></span>
          </a>
        <meta itemprop="position" content="<?php echo $i++; ?>">
        </li>
        <?php } ?>
      </ul>

      <ul class="breadcrumbs breadcrumbs--phone list-inline hidden-md hidden-lg">
        <?php $i=0; ?>
        <?php foreach ($breadcrumbs as $i => $breadcrumb) { ?>
            <li>
                <?php if($i+1 < count($breadcrumbs)) { ?>
                    <a class="crumb" href="<?php echo $breadcrumb['href']; ?>">
                        <span class="p-hidden" ><?php echo $breadcrumb['text']; ?></span>
                    </a>
                    <meta content="<?php echo $i+1; ?>" /> 
                <?php } else { ?>
                    <span class="crumb" >
                        <span ><?php echo $breadcrumb['text']; ?></span>
                    </span>
                    <meta content="<?php echo $i+1; ?>" /> 
                <?php } ?>
            </li>
        <?php } ?>
    </ul>


      
      <div class="visible-xs mini-catalog-product"><?php echo $mini_catalog; ?></div>
      <div class="row goods-cart">

      
       <div class="col-sm-8">
       <div class="row row-flex">
        <div class="col-sm-7 col-xs-12 col-with-img">
            <?php if($active_promos){ ?>
              <!--  <a href="<?php echo $active_promos['href']; ?>" title="<?php echo $active_promos['title']; ?>">
                <div class="product_cart_sticker stickers">
                    <div class="sticker_special"></div>
                </div>
                </a>  -->
            <?php } ?>
          <!-- Начало блока с картинкой продукта и дополнительными изображениями -->
          <?php if ($thumb || $images) { ?>
          <ul class="thumbnails product-images">
            <?php if ($thumb) { ?>
            <li class="big-product-images"><a class="mfp-image thumbnail" href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
            <?php } ?>
            <div class="pack-image-additional">
                 <?php if(isset($product_video['video']) && $product_video['video']){ ?>
            <li class="image-additional"><a class="thumbnail mfp-iframe" href="<?php echo $product_video['video'] ?>" rel="nofollow"><img src="<?php echo $product_video['thumb']; ?>"  /></a></li>
            <?php } ?>
            <?php if ($images) { ?>
            <?php foreach ($images as $image) { ?>
            <li class="image-additional"><a class="mfp-image thumbnail" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>"> <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
            <?php } ?> 
            <?php } ?>
          </ul>
          <?php } ?>
          <!-- Конец блока с картинкой продукта и дополнительными изображениями -->
      
        </div>
          
        <!-- Начало блока с кодом, ценой, производителем, страной и т.д  -->
            
            <div class="col-sm-5 col-xs-6 col-middle-product">
            <div class="col-sm-12 col-title-goods"><h1 class="title-goods-cart" ><?php echo $heading_title; ?></h1></div>
                <div>
                    <?php if($sku){ ?>
                    <p class="product-code" > <?php echo $text_model; ?> <?php echo $sku; ?></p>
                    <?php } ?>
                     <?php if($quantity>0){ ?>
                    <p class="produc-status"><i class="fa fa-check"></i> <?php echo $text_instock; ?></p>
                    <?php } else{ ?>
                    <p class="produc-status is_not_present"> <?php echo $text_outstock; ?></p>
                    <?php } ?>
                    <div style="clear: left"></div>
                </div>
                
                <div class="rating-product">
                 <?php if ($rating) { ?>
                <div class="rating">
                  <?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php if ($rating < $i) { ?>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } else { ?>
                  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } ?>
                  <?php } ?>
                </div>
                <?php } else{ ?>
                <div class="rating">
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <span class="fa fa-stack"><i class="fa fa-star-o        fa-stack-2x"></i></span>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                </div>
                <?php } ?>
                <p class="reviews">
                  <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); to_reviews(); return false;"><span><?php echo $reviews; ?></span></a>
                </p>
                </div>
                
                <div class="product-manufacture" >
                       <?php if ($manufacturer) { ?>
                  <div>
                    <span > <?php echo $text_manufacturer; ?></span> <span ><?php echo $manufacturer; ?></span>
                  </div>    
                    <?php } ?>
                    <?php if ($vendorcountry) { ?>
                  <div>
                    <span> <?php echo $text_vendorcountry; ?></span> <span><?php echo $vendorcountry; ?></span> 
                  </div>
                    <?php } ?>
                </div>
                
                
            <?php if ($price) { ?>
            <p class="price">
            <meta content="<?php echo $intprice; ?>"/>     
             <meta content="<?php echo (!$quantity || $quantity<1) ? 'OutOfStock' : 'InStock' ; ?>"/>      
            <?php if (!$special) { ?>
            
              <h2><?php echo $price; ?></h2>
            
            <?php } else { ?>
               
            <span class="price-new"><?php echo $special; ?></span>
             <span class="price-old"><?php echo $price; ?></span>
            <?php if($active_promos){ ?>
            <a href="<?php echo $active_promos['href']; ?>" title="<?php echo $active_promos['title']; ?>">
                <img src="catalog/view/theme/default/image/stiker-promotional-price.png" class="stiker-product"/>
            </a>
            <?php } ?>
            
            <?php } ?>
            <ul class="list-unstyled">
            <?php if ($tax) { ?>
            <li><?php echo $text_tax; ?> <?php echo $tax; ?></li>
            <?php } ?>
            <?php if ($points) { ?>
            <li><?php echo $text_points; ?> <?php echo $points; ?></li>
            <?php } ?>
            <?php if ($discounts) { ?>
            <li>
              <hr>
            </li>
            <?php foreach ($discounts as $discount) { ?>
            <li><?php echo $discount['quantity']; ?><?php echo $text_discount; ?><?php echo $discount['price']; ?></li>
            <?php } ?>
            <?php } ?>
          </ul>
          </p>
          <?php } ?>
                  <div class="qty-pack">
                    <div class="block-qty">
                      <span class="new-qty">
                        <i class="fa fa-minus2 count_down"></i>
                        <input type="text" name="quantity" value="<?php echo $minimum; ?>" size="2" id="input-quantity" class="input-quantity-prod"/>
                        <i class="fa fa-plus1 count_up" ></i>
                      </span>
                    </div>
                      <label class="control-label label-qty" for="input-quantity"><?php echo $entry_qty; ?></label>
                        
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                    
                    </div>
          
                     <?php if(!$quantity || $quantity<1){ ?>
                            <div class="btn-two">
                                <button type="button" class="notify-of-availability order" data-toggle="modal" data-target="#preoder" data-product="<?php echo $heading_title; ?>" data-product_url="<?php echo $product_link; ?>" data-product_id="<?php echo $product_id; ?>" data-product_img="<?php echo $thumb; ?>" data-product_price="<?php echo $price; ?>"><span class="title-one-click"><?php echo $button_notify_availability; ?></span></button>
                            </div>
                            <?php }else{ ?>
                    <div class="btn-two">
                      <button type="button" id="button-cart"  data-fbq_sku="<?php echo $sku; ?>" data-fbq_name="<?php echo $heading_title; ?>" data-fbq_price="<?php echo $intprice; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn-add-cart"><img src="catalog/view/theme/default/image/icon-small-cart.png" alt="New"><span><?php echo $button_cart; ?></span></button>
                      <button type="button" class="buy-one-click order" data-toggle="modal" data-target="#order" data-fbq_sku="<?php echo $sku; ?>" data-fbq_name="<?php echo $heading_title; ?>" data-fbq_price="<?php echo $intprice; ?>" data-product_id="<?php echo $product_id; ?>" data-product="<?php echo $heading_title; ?>" data-product_url="<?php echo $product_link; ?>" data-product_img="<?php echo $thumb; ?>" data-product_price="<?php echo (isset($special) && $special)?$special:$price; ?>" onclick="prepare_fbq($(this))"><img src="catalog/view/theme/default/image/icon-small-phone.png" alt="New"> <span class="title-one-click"><?php echo $button_buy_click; ?></span></button>
                    </div> 
                            <?php } ?>
                
                <?php if ($minimum > 1) { ?>
                <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>
                <?php } ?>
                
                <div class="product-btns product-btns-first"> 
                  <div class="btn-pack">
                    <button type="button"  class="btn-transparent btn-product-wislist" data-product_id="<?php echo $product_id; ?>" onclick="wishlist.add($(this))"><img src="catalog/view/theme/default/image/icon-small-heart.png" alt="wishlist"><span><?php echo $button_wishlist; ?></span></button></div>
                    <div class="btn-pack">
                    <button type="button" data-product_id="<?php echo $product_id; ?>" class="btn-transparent btn-product-compare" onclick="compare.add($(this));"><img src="catalog/view/theme/default/image/icon-small-compare.png" alt="Compare"><span><?php echo $button_compare; ?></span></button></div>
                <div class="btn-pack pack-share">
                        
                    <button type="button" data-toggle="tooltip" class="btn-transparent btn-product-share"><img src="catalog/view/theme/default/image/icon-small-share.png" alt="Share"><span><?php echo $button_share; ?></span>
                    
                    </button>
                    
                    <div class="social-likes">
                        <div class="facebook" title="Поделиться ссылкой на Фейсбуке"><i class="fa fa-facebook-f"></i></div>
                        <div class="twitter" title="Поделиться ссылкой в Твиттере"><i class="fa fa-twitter"></i></div>
                        <div class="plusone" title="Поделиться ссылкой в Гугл-плюсе"><i class="fa fa-google-plus"></i></div>
                        <div class="pinterest" title="Поделиться картинкой на Пинтересте" data-media=""><i class="fa fa-pinterest-p"></i></div>
                    </div>
                    
                </div>
                    
                    
                    
                </div>
                
            </div>


         <div class='col-xs-6 col-attribute visible-xs' id="specification">
           <?php if ($attribute_groups) { ?>
            <table class="product-attribute">
                  <tr>
                  <td class="product-attribute-title" colspan="2">
                    <?php echo $tab_attribute;?>:
                  </td></tr>
                    <?php $i=0; $attr_limit=5; ?>
                <?php foreach ($attribute_groups as $attribute_group) { ?>
                
                    <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                    
                     <?php $i++; ?>
                        <?php if($i<=$attr_limit){ ?>
                        <tr>
                          <td>
                                <?php if($attribute['name']=='color'){ ?>
                                   <span>Цвет</span>
                                <?php }else{ ?>
                                     <span><?php echo $attribute['name']; ?></span>
                               <?php } ?>
                           </td>
                          <td>
                            <span><?php echo $attribute['text']; ?></span>
                          </td>
                        </tr>
                         <?php }else{ ?>
                             <tr class="hide_more_attr_xs" style="display: none">
                            <td>
                                <?php if($attribute['name']=='color'){ ?>
                                   <span>Цвет</span>
                                <?php }else{ ?>
                                     <span><?php echo $attribute['name']; ?></span>
                               <?php } ?>
                           </td>
                           <td>
                            <span><?php echo $attribute['text']; ?></span>
                          </td>
                        </tr>
                         <?php } ?>
                    <?php } ?>
                
                <?php } ?>
                </table>
           
            <?php if($i>$attr_limit){ ?>
              <div class="product-more-detailed">
                <a onclick="$('.hide_more_attr_xs').slideToggle();  if($(this).html()!='Свернуть'){ $(this).html('Свернуть'); }else{ $(this).html('Подробнее') }"><?php echo $btn_more_detailed; ?></a>
              </div>
              <?php } ?>
           
              <?php } ?>
        </div>


        <div class="col-xs-12 visible-xs">
          <div class="product-btns product-btns-second"> 
                  <div class="btn-pack">
                    <button type="button" data-toggle="tooltip" class="btn-transparent btn-product-wislist" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product_id; ?>');"><img src="catalog/view/theme/default/image/icon-small-heart.png" alt="Compare"><span><?php echo $button_wishlist; ?></span></button></div>
                    <div class="btn-pack">
                    <button type="button" data-toggle="tooltip" class="btn-transparent btn-product-compare" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product_id; ?>');"><img src="catalog/view/theme/default/image/icon-small-compare.png" alt="Compare"><span><?php echo $button_compare; ?></span></button></div>
                    <div class="btn-pack">
                    <button type="button" data-toggle="tooltip" class="btn-transparent btn-product-share" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product_id; ?>');"><img src="catalog/view/theme/default/image/icon-small-share.png" alt="Compare"><span><?php echo $button_share; ?></span></button></div>
                </div>
        </div>
        <!-- Начало преимуществ 
         <div class="advantage-pack advantage-pack-xs visible-xs">
            <div class="advantage-product">
              <div class="advantage-product-img">
                <img src="catalog/view/theme/default/image/advantage-img-1.png" alt="Advantage image">
              </div>
              <div class="title-advantage"><?php echo $first_advantage; ?></div>
              <div class="advantage-product-content">
              <?php echo $text_1_advantage;; ?>
              </div>
            </div> 
            <div class="advantage-product">
              <div class="advantage-product-img">
                  <img src="catalog/view/theme/default/image/advantage-img-2.png" alt="Advantage image">
              </div>
              <div class="title-advantage"><?php echo $second_advantage; ?></div>  
              <div class="advantage-product-content"><?php echo $text_2_advantage; ?></div>
            </div>
            <div class="advantage-product">
              <div class="advantage-product-img">
                <img src="catalog/view/theme/default/image/advantage-img-3.png" alt="Advantage image">
              </div>
              <div class="title-advantage"><?php echo $third_advantage;; ?></div>
              <div class="advantage-product-content"><?php echo $text_3_advantage; ?></div>
            </div>       
            <div class="advantage-product">
              <div class="advantage-product-img">
                  <img src="catalog/view/theme/default/image/advantage-img-4.png" alt="Advantage image">
              </div>
              <div class="title-advantage"><?php echo $forth_advantage;; ?></div>
              
              <div class="advantage-product-content"><?php echo $text_4_advantage; ?></div>
            </div>       
          </div> --> 
            </div>
            <div class="row">
            <div class="col-sm-12 col-product-tab">
              <!-- Начало табов -->
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-description" data-toggle="tab"><?php echo $tab_description; ?></a></li>
            <?php if ($review_status) { ?>
            <li id="tab-product-review"><a href="#tab-review" data-toggle="tab"><?php echo $tab_review; ?></a></li>
            <?php } ?>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-description" itemprop="description"><?php echo $description; ?></div>
           
            <?php if ($review_status) { ?>
            <div class="tab-pane" id="tab-review" >
              <form class="form-horizontal" id="form-review">
                <div id="review"></div>
                <h2 id="review_fields"><?php echo $text_write; ?></h2>
                <?php if ($review_guest) { ?>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label label-review" for="input-name"><?php echo $entry_name; ?></label>
                    <input type="text" name="name" value="<?php echo $customer_name; ?>" id="input-name" class="form-control" />
                  </div>
                </div>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label label-review" for="input-review"><?php echo $entry_review; ?></label>
                    <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
                  
                  </div>
                </div>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label"><?php echo $entry_rating; ?></label>
                    &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                    <input type="radio" name="rating" value="1" />
                    &nbsp;
                    <input type="radio" name="rating" value="2" />
                    &nbsp;
                    <input type="radio" name="rating" value="3" />
                    &nbsp;
                    <input type="radio" name="rating" value="4" />
                    &nbsp;
                    <input type="radio" name="rating" value="5" />
                    &nbsp;<?php echo $entry_good; ?></div>
                </div>
                
                <div class="buttons clearfix row">
                   <div class="pull-right"><?php echo $captcha; ?></div>  
                  <div class="col-xs-12">
                     
                          <button style="margin-right: -18px;" type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary pull-right"><?php echo $button_continue; ?></button>
                     
                  </div>
                    
                </div>
                <?php } else { ?>
                <?php echo $text_login; ?>
                <?php } ?>
              </form>
            </div>
            <?php } ?>
          </div>
             <!-- конец табов --> 
             
          <div class="last-five-review">
              <?php if($five_reviews){ ?>
            <h3 class="title-last-review">
              <span class="heading-title-review"><?php echo $heading_title; ?> <?php echo $text_last_reviews; ?></span>
            </h3>
            <div><?php echo $five_reviews; ?></div> 
            <div class="more-review">
                
                   
                     <div onclick="$('a[href=\'#tab-review\']').trigger('click'); to_reviews();"><?php echo $text_view_review; ?></div>
                
             
            </div>
                <?php } ?>
            <div class="pack-btn-write-review" onclick="$('a[href=\'#tab-review\']').trigger('click'); to_review_form();">
              <button class="btn-primary">
                <?php echo $text_write; ?>
              </button>
            </div>
          </div>
        
            </div>
            </div>
            </div>
          <!-- Конец блока с кодом, ценой, производителем, страной и т.д  --> 
          <!-- Начало атрибутов  --> 
      
            
            <div class='col-sm-4 col-attribute' id="specification">
           <div class="hidden-xs">
           <?php if ($attribute_groups) { ?>
           
            <table class="product-attribute">
                  <tr>
                  <td class="product-attribute-title" colspan="2">
                    <?php echo $tab_attribute;?>:
                  </td></tr>
                  <?php $i=0; $attr_limit=10; ?>
                <?php foreach ($attribute_groups as $attribute_group) { ?>
                    
                    <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                        <?php $i++; ?>
                        <?php if($i<=$attr_limit){ ?>
                        <tr>
                          <td>
                             <?php if($attribute['name']=='color'){ ?>
                                   <span>Цвет</span>
                                <?php }else{ ?>
                                     <span><?php echo $attribute['name']; ?></span>
                               <?php } ?>
                          </td>
                          <td>
                            <span><?php echo $attribute['text']; ?></span>
                          </td>
                        </tr>
                        <?php }else{ ?>
                       <tr class="hide_more_attr" style="display: none">
                          <td>
                             <?php if($attribute['name']=='color'){ ?>
                                   <span>Цвет</span>
                                <?php }else{ ?>
                                     <span><?php echo $attribute['name']; ?></span>
                               <?php } ?>
                          </td>
                          <td>
                            <span><?php echo $attribute['text']; ?></span>
                          </td>
                        </tr>
                       
                        <?php } ?>
                    <?php } ?>
            
                <?php } ?>
                    </table>
           
            <?php if($i>$attr_limit){ ?>
              <div class="product-more-detailed">
                <a onclick="$('.hide_more_attr').slideToggle();  if($(this).html()!='Свернуть'){ $(this).html('Свернуть'); }else{ $(this).html('Подробнее') }"><?php echo $btn_more_detailed; ?></a>
              </div>
              <?php } ?>
           
              <?php } ?>
              
             
              
              </div>
                           <!-- Начало преимуществ --> 
         <div class="advantage-pack advantage-desctop- hidden-xs-">
            
        <div class="advantage-product">
           <div class="advantage-product-img">
                <img src="catalog/view/theme/default/image/advantage-img-1.png" alt="Advantage image">
            </div>
            <div class="title-advantage"><?php echo $first_advantage; ?></div>
            <div class="advantage-product-content">
              <?php echo $text_1_advantage;; ?>
            </div>
            
        </div> 
        
         
            <div class="advantage-product">
                <div class="advantage-product-img">
                    <img src="catalog/view/theme/default/image/advantage-img-2.png" alt="Advantage image">
                </div>
                <div class="title-advantage"><?php echo $second_advantage; ?></div>  
                <div class="advantage-product-content"><?php echo $text_2_advantage; ?></div>
                
            </div>
          
            <div class="advantage-product">
                <div class="advantage-product-img">
                    <img src="catalog/view/theme/default/image/advantage-img-3.png" alt="Advantage image">
                </div>
                <div class="title-advantage"><?php echo $third_advantage;; ?></div>
                <div class="advantage-product-content"><?php echo $text_3_advantage; ?></div>
            </div>       
        
            <div class="advantage-product">
                <div class="advantage-product-img">
                    <img src="catalog/view/theme/default/image/advantage-img-4.png" alt="Advantage image">
                </div>
                <div class="title-advantage"><?php echo $forth_advantage;; ?></div>
               
                <div class="advantage-product-content"><?php echo $text_4_advantage; ?></div>
                
            </div>  <div style="clear: left"></div>      
        </div>
          
             <!-- Конец преимуществ --> 
            

            </div>
           
        <!-- Конец атрибутов  -->  
      </div>
             <!-- Начало Вместе с этим продуктом покупают  --> 
              <?php if ($products) { ?>
             <div class="row new-product">
  <div class="col-xs-12 envelope">
    <h2 class="title-feature"><?php echo $text_related; ?></h2>
    <div id="related_products" class="owl-carousel">
  <?php foreach ($products as $product) { ?>
  
  <div class="item product-layout">
     
      <ul class="list-inline bts-wish-compare">
        <li>
          <button class="btn-transparent" data-product_id="<?php echo $product['product_id']; ?>" onclick="compare.add($(this))"><img src="catalog/view/theme/default/image/icon-small-compare.png" alt="Compare"></button>
        </li>
        <li>
            <button class="btn-transparent" data-product_id="<?php echo $product['product_id']; ?>" onclick="wishlist.add($(this))"><img src="catalog/view/theme/default/image/icon-small-heart.png" alt="Wishlist"></button>
        </li>
      </ul>
          
      
    <div class="product-thumb transition">
      <div class="image"><a href="<?php echo $product['href']; ?>"><img class="<?php echo $product['quantity']>0?'':'colorless'; ?>" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
      <div class="caption">
        <h4 class="name-product"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
         <?php if($product['sku']){ ?>
        <p class="artikul"><span><?php echo $text_artikul; ?>:</span> <span><?php echo $product['sku']; ?></span></p>
        <?php } ?>
        
        
         <?php if($product['quantity']){ ?>
        <p class="produc-status"><i class="fa fa-check"></i> <?php echo $text_instock; ?></p>
        <?php }else{ ?>
             <p class="produc-status is_not_present"> <?php echo $text_outstock; ?></p>
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
                 
        
        
        <?php if($product['reviews']){ ?>
        <p class="reviews"><span><?php echo $product['reviews']; ?></span> <span><?php echo  $text_reviews_number; ?></span></p>
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
                                <button type="button" class="notify-of-availability order" data-toggle="modal" data-target="#preoder" data-product="<?php echo $product['name']; ?>" data-product_url="<?php echo $product['href']; ?>" data-product_id="<?php echo $product['product_id']; ?>" data-product_img="<?php echo $product['thumb']; ?>" data-product_price="<?php echo $product['price']; ?>"><span class="title-one-click"><?php echo $button_notify_availability; ?></span></button>
                            </div>
                            <?php }else{ ?>
      <div class="btn-two">
        <button type="button" class="btn-add-cart" data-fbq_sku="<?php echo $sku; ?>" data-fbq_name="<?php echo $heading_title; ?>" data-fbq_price="<?php echo $intprice; ?>" onclick="prepare_fbq($(this)); cart.add('<?php echo $product['product_id']; ?>');"><img src="catalog/view/theme/default/image/icon-small-cart.png" alt="New"> <span class=""><?php echo $button_cart; ?></span></button>
         <button type="button" class="buy-one-click order" data-toggle="modal" data-target="#order" data-fbq_sku="<?php echo $sku; ?>" data-fbq_name="<?php echo $heading_title; ?>" data-fbq_price="<?php echo $intprice; ?>" data-product_id="<?php echo $product['product_id']; ?>" data-product="<?php echo $product['name']; ?>" data-product_url="<?php echo $product['href']; ?>" data-product_img="<?php echo $product['thumb']; ?>" data-product_price="<?php echo $product['price']; ?>" onclick="prepare_fbq($(this))"><img src="catalog/view/theme/default/image/icon-small-phone.png" alt="New"> <span class="title-one-click"><?php echo $button_buy_click; ?></span></button>
      </div>
        <?php } ?>
      
      
    </div>
  </div>
  <?php } ?>
  </div>
         <script type="text/javascript">
                $(document).ready(function(){
                    $('#related_products').owlCarousel({
                        items: 3,
                        singleItem: true,
                        nav: true, 
                        navText: ['<img src="catalog/view/theme/default/image/arrow-violet.png" alt="Prew" class="violet-prev">','<img src="catalog/view/theme/default/image/arrow-violet.png" alt="Next" >'],
                        autoWidth: true,
                        dots: false,
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
</div>
</div>
   <?php } ?>
              <!-- Конец Вместе с этим продуктом покупают  --> 
             
             
             
             
      <?php echo $content_bottom; ?></div>
      
        
    </div>
    
  <?php echo $column_right; ?>
  
</div>
<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart').button('loading');
		},
		complete: function() {
			$('#button-cart').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}

			if (json['success']) {
				$('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');

				$('html, body').animate({ scrollTop: 0 }, 'slow');

				$('#cart > ul').load('index.php?route=common/cart/info ul li');
			}
		},
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});
//--></script>

<script type="text/javascript"><!--
$('#review').delegate('.pagination a', 'click', function(e) {
    e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: $("#form-review").serialize(),
		beforeSend: function() {
			$('#button-review').button('loading');
		},
		complete: function() {
			$('#button-review').button('reset');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				$('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
			}
		}
	});
    grecaptcha.reset();
});

$(document).ready(function() {
	$('.thumbnails').magnificPopup({
		//type:'image',
		delegate: 'a',
		gallery: {
			enabled:true
		}
	});
});

$(document).ready(function() {
	var hash = window.location.hash;
	if (hash) {
		var hashpart = hash.split('#');
		var  vals = hashpart[1].split('-');
		for (i=0; i<vals.length; i++) {
			$('#product').find('select option[value="'+vals[i]+'"]').attr('selected', true).trigger('select');
			$('#product').find('input[type="radio"][value="'+vals[i]+'"]').attr('checked', true).trigger('click');
			$('#product').find('input[type="checkbox"][value="'+vals[i]+'"]').attr('checked', true).trigger('click');
		}
	}
})
//--></script>
<script>
    $(document).ready(function(){
        
        $('.count_up').click(function(){
                var quantity = parseInt($('#input-quantity').val());
                if(Number.isInteger(quantity)){
                    if(quantity<9){
                        quantity++;
                    }
                    $('#input-quantity').val(''+quantity);
                }else{
                    $('#input-quantity').val('1');
                }
                
            });
        
            $('.count_down').click(function(){
                var quantity = parseInt($('#input-quantity').val());
                if(Number.isInteger(quantity)){
                    if(quantity>=1){
                        quantity-=1;
                    }
                    $('#input-quantity').val(''+quantity);
                }else{
                     $('#input-quantity').val('1');
                }
            });
            

    });
    
     function to_reviews(){
                var h1=$('#tab-review').offset().top;
                $('html, body').animate({ scrollTop: h1 }, 'slow');
            }
            
    function to_review_form(){
        var h1=$('#review_fields').offset().top;
        $('html, body').animate({ scrollTop: h1 }, 'slow');
    }
    
</script>
<script>
  function inspection(){
    if($("#tab-product-review").hasClass("active")){
      $(".last-five-review").addClass('hidden');
}
    else{
      $(".last-five-review").removeClass('hidden');
      }
  
}
  $(".nav-tabs li").click(function(){
      setTimeout(
    inspection, 50);
    });
  
  
</script>
<?php echo $footer; ?>
