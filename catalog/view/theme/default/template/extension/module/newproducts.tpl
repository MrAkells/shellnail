<div class="row new-product">
  <div class="col-xs-12 envelope">
    <h2 class="title-feature"><?php echo $heading_title; ?></h2>
    <div id="products_<?php echo $tpl; ?>" class="owl-carousel">
  <?php foreach ($products as $product) { ?>
  
  <div class="item product-layout">
     
      <ul class="list-inline bts-wish-compare">
        <?php if($product['video_link']){ ?>
          <li class='magni_youtube'>
              <img onclick="create_frame_popup($(this))" data-video_link="<?php echo $product['video_link']; ?>" style='width: 24px; cursor:pointer;' src="image/video-tovara-youtube.png" alt="youtube">
          </li>
        <?php } ?>
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
        <div class="name-product"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
         <?php if($product['sku']){ ?>
        <p class="artikul"><span><?php echo $text_artikul; ?>:</span> <span><?php echo $product['sku']; ?></span></p>
        <?php } ?>
        <?php if(!$product['quantity'] || $product['quantity']<1){ ?>
                                     <p class="produc-status is_not_present"><?php echo $text_outstock; ?></p>
                                    <?php }else{ ?>
                                   <p class="produc-status"><i class="fa fa-check"></i> <?php echo $text_instock; ?></p>
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
        <button type="button" class="btn-add-cart" data-fbq_sku="<?php echo $product['sku']; ?>" data-fbq_name="<?php echo $product['name']; ?>" data-fbq_price="<?php echo $product['intprice']; ?>" onclick="prepare_fbq($(this)); cart.add('<?php echo $product['product_id']; ?>');"><img src="catalog/view/theme/default/image/icon-small-cart.png" alt="New"> <span class=""><?php echo $button_cart; ?></span></button>
        <button type="button" class="buy-one-click order" data-toggle="modal" data-target="#order" data-fbq_sku="<?php echo $product['sku']; ?>" data-fbq_name="<?php echo $product['name']; ?>" data-fbq_price="<?php echo $product['intprice']; ?>" data-product_id="<?php echo $product['product_id']; ?>" data-product="<?php echo $product['name']; ?>" data-product_url="<?php echo $product['href']; ?>" data-product_img="<?php echo $product['thumb']; ?>" data-product_price="<?php echo $product['price']; ?>" onclick="prepare_fbq($(this));"><img src="catalog/view/theme/default/image/icon-small-phone.png" alt="New"> <span class="title-one-click"><?php echo $text_buy_one_click; ?></span></button>
       
      </div>
                           
                            <?php } ?>
      
      
      
    </div>
  </div>
  <?php } ?>
  </div>
         <script type="text/javascript">
                $(document).ready(function(){
                    $('#products_<?php echo $tpl; ?>').owlCarousel({
                        items: 4,
                        singleItem: false,
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
</script>
</div>
</div>
