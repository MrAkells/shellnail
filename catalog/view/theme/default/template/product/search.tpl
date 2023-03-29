<?php echo $header; ?>
<div class="container">
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <ul class="hidden-xs hidden-sm breadcrumbs list-inline">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
          <li><a class="crumb" href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
      <div class="visible-xs mini-catalog-product"><?php echo $mini_catalog; ?></div>
      <h1><?php echo $heading_title; ?></h1>
      <label class="control-label" for="input-search"><?php echo $entry_search; ?></label>
      <div class="row row-flex">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-search" class="form-control"/>
        </div>
        <div class="col-md-5 col-sm-6 col-xs-12 search-category">
            <select name="category_id"  style="width: auto; position: absolute; opacity: 0; height: 34px; font-size: 14px; z-index: 5;">
            <option value="0"><?php echo $text_category; ?></option>
            <?php foreach ($categories as $category_1) { ?>
            <?php if ($category_1['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_1['category_id']; ?>" selected><?php echo $category_1['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
            <?php } ?>
            <?php foreach ($category_1['children'] as $category_2) { ?>
            <?php if ($category_2['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
            <?php } ?>
            <?php foreach ($category_2['children'] as $category_3) { ?>
            <?php if ($category_3['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            <?php } ?>
          </select>
           <span class="form-control customSelect" style="display: inline-block; width: auto;"><span class="customSelectInner" style="width: auto display: inline-block;">9</span></span>
        </div>
        <div class="col-md-3 col-xs-12">
          <div class="search-btn block-search-sub" data-toggle="buttons">
            <label class="control-label form-label btn new-check search-sub-category">
            <?php if ($sub_category) { ?>
            <input type="checkbox" class="check-sub-category" name="sub_category" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" class="check-sub-category" name="sub_category" value="1" />
            <?php } ?>
            <span class="title-check"><?php echo $text_sub_category; ?></span></label>
          </div>
          
        </div>
      </div>
      <p>
        <div class="search-btn search-description" data-toggle="buttons">
          <label class="control-label form-label  btn new-check active">
            <?php if ($description) { ?>
            <input type="checkbox" name="description" value="1" id="description" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="description" value="1" id="description" />
            <?php } ?>
            <span class="title-check"><?php echo $entry_description; ?></span>
          </label>
        </div>
      </p>
      <input type="button" value="<?php echo $button_search; ?>" id="button-search" class="btn btn-primary" />
      <h2><?php echo $text_search; ?></h2>
      <?php if ($products) { ?>
     <div class="row row-flex sorting-tools">
        <div class="col-md-2 col-sm-6 hidden">
          <div class="btn-group btn-group-sm">
            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
          </div>
        </div>
        <div class="col-lg-6 col-md-5 col-sm-5 col-xs-7 sort-different search-diffrent">
          <div class="form-group input-group input-group-sm">
            <label class="input-group-addon" for="input-sort"><?php echo $text_sort; ?></label>
            <ul class="new-sorting list-inline visible-lg">
                
               <?php if ('p.sort_order-ASC' == $sort . '-' . $order) { ?>  
               <li class='selected_sort'><span class="sort-signal sort-up"><i class="fa fa-sort-amount-asc"></i></span><a href="<?php echo $sorts['p.sort_order-DESC']['href']; ?>">По порядку</a></li>
                <?php }else if('p.sort_order-DESC' == $sort . '-' . $order){ ?>
                <li class='selected_sort'><span class="sort-signal sort-up"><i class="fa fa-sort-amount-desc"></i></span><a href="<?php echo $sorts['p.sort_order-ASC']['href']; ?>">По порядку</a></li>
                <?php } else{ ?>
                <li><a href="<?php echo $sorts['p.sort_order-ASC']['href']; ?>">По порядку </a></li>
                <?php } ?>
                

                <?php if('p.date_added-DESC' == $sort . '-' . $order){ ?>
                <li class='selected_sort'><a href="<?php echo $sorts['p.date_added-ASC']['href']; ?>">Новинки</a></li>
                <?php } else{ ?>
                <li><a href="<?php echo $sorts['p.date_added-DESC']['href']; ?>">Новинки</a></li>
                <?php } ?>
                
                
                
               
                <?php if('p.viewed-DESC' == $sort . '-' . $order){ ?>
                <li class='selected_sort'><a href="<?php echo $sorts['p.viewed-ASC']['href']; ?>">Популярные</a></li>
                <?php } else{ ?>
                <li><a href="<?php echo $sorts['p.viewed-DESC']['href']; ?>">Популярные</a></li>
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
               <li class='selected_sort'><a href="<?php echo $sorts['p.price-ASC']['href']; ?>">Дешевле</a></li>
                <?php } else{ ?>
                <li><a href="<?php echo $sorts['p.price-ASC']['href']; ?>">Дешевле</a></li>
                <?php } ?>
                
                 <?php if ('p.price-DESC' == $sort . '-' . $order) { ?>  
            <li class='selected_sort'><a href="<?php echo $sorts['p.price-DESC']['href']; ?>">Дороже</a></li>
                <?php } else{ ?>
                <li><a href="<?php echo $sorts['p.price-DESC']['href']; ?>">Дороже</a></li>
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
            <img onclick="create_frame_popup($(this))" data-video_link="<?php echo $product['video_link']; ?>" style='width: 24px; cursor:pointer;' src="image/video-tovara-youtube.png" alt="youtube"  width="24" height="17" >
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
                <h4 class="name-product"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                
                <?php if($product['sku']){ ?>
        <p class="artikul"><span><?php echo $text_artikul; ?>:</span> <span><?php echo $product['sku']; ?></span></p>
                 <?php } ?>
                <?php if($product['quantity']>0){ ?>
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
                <button type="button" class="buy-one-click order" data-toggle="modal" data-target="#order" data-fbq_sku="<?php echo $product['sku']; ?>" data-fbq_name="<?php echo $product['name']; ?>" data-fbq_price="<?php echo $product['intprice']; ?>" data-product_id="<?php echo $product['product_id']; ?>" data-product="<?php echo $product['name']; ?>" data-product_url="<?php echo $product['href']; ?>" data-product_img="<?php echo $product['thumb']; ?>" data-product_price="<?php echo $product['price']; ?>" onclick="prepare_fbq($(this));"><img src="catalog/view/theme/default/image/icon-small-phone.png" alt="New"> <span class="title-one-click">Купить в один клик</span></button>
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
        <div class="pagination-casing"><?php echo $pagination; ?></div>
        
      </div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
$('#button-search').bind('click', function() {
	url = 'index.php?route=product/search';

	var search = $('#content input[name=\'search\']').prop('value');

	if (search) {
		url += '&search=' + encodeURIComponent(search);
	}

	var category_id = $('#content select[name=\'category_id\']').prop('value');

	if (category_id > 0) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}

	var sub_category = $('#content input[name=\'sub_category\']:checked').prop('value');

	if (sub_category) {
		url += '&sub_category=true';
	}

	var filter_description = $('#content input[name=\'description\']:checked').prop('value');

	if (filter_description) {
		url += '&description=true';
	}

	location = url;
});

$('#content input[name=\'search\']').bind('keydown', function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('select[name=\'category_id\']').on('change', function() {
       
	if (this.value == '0') {
		$('input[name=\'sub_category\']').prop('disabled', true);
   $("input[name=\'sub_category\']").parent().addClass('disabled'); 
    

	} else {
		$('input[name=\'sub_category\']').prop('disabled', false);
               $("input[name=\'sub_category\']").parent().removeClass('disabled'); 
	}
});

  $("input[name=\'sub_category\']").change(function(){
  
   if($('input[name=\'sub_category\']').is(':checked') && $('select[name=\'category_id\']').val()!= '0') {
       $(this).parent().addClass('violet-check'); 
      
       $(this).val('1');
   }else {
      $(this).parent().removeClass('violet-check');
      
       $(this).val('0');
  }
  
 });

$('select[name=\'category_id\']').trigger('change');
--></script>
 <script type="text/javascript">
 
$(document).ready(function(){
     $(".form-group").each(function(){
        $(this).find(".customSelectInner").html($(this).find("select :selected").html());

      });
});
$(document).ready(function(){
    
    $(".search-category").each(function(){
        $(this).find(".customSelectInner").html($(this).find("select :selected").html());
    });
      
    $(document).delegate(".search-category select", 'change', function(){
       var val=$(this).val();
       var new_text=$(this).find("option[value="+val+"]").html();
       $(this).parent().find(".customSelectInner").html(new_text);
    });
      
      
});



</script>
<script type="text/javascript">
 
$(document).ready(function(){
   $('.search-description input:checkbox').change(function(){
   if($(this).is(':checked')) 
       $(this).parent().addClass('violet-check'); 
  else 
      $(this).parent().removeClass('violet-check')
 });

});

</script>
<?php echo $footer; ?>