<?php echo $header; ?>
<div class="container">
  <div class="row">
  <!-- <div id="content" class="col-xs-12 col-sm-12 col-md-9 col-md-push-3"> -->
  <div id="content" class="col-md-12">
      <?php echo $content_top; ?>
      <ul class="breadcrumbs list-inline" itemscope itemtype="https://schema.org/BreadcrumbList">
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
      <div class="hidden-md hidden-lg mini-catalog-сategory">
          <?php echo $mini_catalog; ?>
      </div>     
         <h1 itemprop="name" class="title-promotion-group"><?php echo $title; ?></h1>
        <div class="description-promotion-group"><?php echo $description; ?></div>
        <!--<div><img src="<?php echo $main_thumb; ?>"></div>
        <div class="vita_removes_this"><?php echo $title; ?></div>-->
        <div class="row cpage-promotipns">
            <?php foreach($promotions as $promo){ ?>
              <div class="col-md-4 col-sm-6 item-promotion-group">
                <a href="<?php echo $promo['href']; ?>">
                <!--<div><?php echo $promo['description']; ?></div>-->
                  <div>
                    <img src="<?php echo $promo['thumb_m']; ?>" class="promotion-img-top"/>
                    <img src="<?php echo $promo['thumb']; ?>" class="promotion-img-bg"/>
                  </div>
                  <div class="item-promotion-title"><?php echo $promo['title']; ?></div>
                </a>
               </div>
             <?php } ?> 
        </div>
        
    </div>  
    <!-- <aside id="column-left" class="col-xs-12 col-sm-12 col-md-3 col-md-pull-9">
      <?php echo $mini_catalog_category; ?>
    </aside>     	 -->
 </div>
           

    </div>


<?php echo $footer; ?>


 
 

 