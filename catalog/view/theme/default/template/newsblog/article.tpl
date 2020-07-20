<?php echo $header; ?>
<div class="container">
  <div class="row">
      <div id="content" class="col-xs-12 col-sm-12 col-md-9 col-md-push-3"><?php echo $content_top; ?>
      <ul class="breadcrumbs list-inline" itemscope itemtype="http://schema.org/BreadcrumbList">
           <?php $i=0; ?>
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" class="crumb" href="<?php echo $breadcrumb['href']; ?>"><span itemprop="name"><?php echo $breadcrumb['text']; ?></span></a>
        <meta itemprop="position" content="<?php echo $i++; ?>">
        </li>
        <?php } ?>
      </ul>
          
            <meta itemprop="datePublished" content="<?php echo $datePublished; ?>" />
            <meta itemprop="dateModified" content="<?php echo $micro_date_modified; ?>" />
            <meta itemprop="author" content="Екатерина Дорошенко" />
            <meta itemprop="headline" content="<?php echo $heading_title; ?>" />
            <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                    <meta itemprop="url" content="<?php echo $logo; ?>">
                    <meta itemprop="width" content="400">
                    <meta itemprop="height" content="60">
                </div>
                <meta itemprop="name" content="shellnail">
            </div>
            
          
      <div class="row more-article">
             <div class="col-md-8">
          <div class="date-more-article">
              <?php echo $date;?>
          </div>
        	<h1 class="title-more-article" itemprop="name"><?php echo $heading_title; ?></h1>
          <?php if ($thumb) { ?>
              <a class="thumbnail hidden" href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>"><img itemprop="image" src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
              <?php } ?>
          	
          <div class="description-more-article" itemprop="mainEntityOfPage"><?php echo $description; ?></div>
             	
            <div class="btn-pack pack-share">
                        
                    <button type="button" data-toggle="tooltip" class="btn-transparent btn-product-share"><img src="catalog/view/theme/default/image/icon-small-share.png" alt="Compare"><span><?php echo $button_share; ?></span>
                    
                    </button>
                    
                    <div class="social-likes">
                        <div class="facebook" title="Поделиться ссылкой на Фейсбуке"><i class="fa fa-facebook-f"></i></div>
                        <div class="twitter" title="Поделиться ссылкой в Твиттере"><i class="fa fa-twitter"></i></div>
                        <div class="plusone" title="Поделиться ссылкой в Гугл-плюсе"><i class="fa fa-google-plus"></i></div>
                        <div class="pinterest" title="Поделиться картинкой на Пинтересте" data-media=""><i class="fa fa-pinterest-p"></i></div>
                    </div>
                    
                </div>
          

          	<?php if ($attributes) { ?>
	      		<h5><?php echo $text_attributes;?></h5>
	            <?php foreach ($attributes as $attribute_group) { ?>
	              	<?php foreach ($attribute_group['attribute'] as $attribute_item) { ?>
                   		<b><?php echo $attribute_item['name'];?>:</b> <?php echo $attribute_item['text'];?><br />
	                <?php } ?>
	          	<?php } ?>
            <?php } ?>
        
             </div>
            <div class="col-md-4">
                      <?php echo $column_right; ?>
            </div>
            
      </div>

  	 

      
      <?php echo $content_bottom; ?></div>
      
  
    
  <?php echo $column_left; ?>
  </div>
</div>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('.thumbnails').magnificPopup({
		type:'image',
		delegate: 'a',
		gallery: {
			enabled:true
		}
	});
});
//--></script>
<?php echo $footer; ?>