<?php echo $header; ?>
<div class="container">
  <div class="row">
    
    <div id="content" class="col-xs-12 col-sm-12 col-md-9 col-md-push-3">
    
    <?php echo $content_top; ?>
    <ul class="breadcrumbs list-inline" itemscope itemtype="http://schema.org/BreadcrumbList">
        <?php $i=0; ?>
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" class="crumb" href="<?php echo $breadcrumb['href']; ?>"><span itemprop="name"><?php echo $breadcrumb['text']; ?></span></a>
        <meta itemprop="position" content="<?php echo $i++; ?>">
        </li>
        <?php } ?>
      </ul>
      <div class="visible-xs mini-catalog-product"><?php echo $mini_catalog; ?></div>
      <h1 class="title-article" itemprop="name"><?php echo $heading_title; ?></h1>
      <?php if (!empty($show_description) && !empty($description)) { ?>
      <div class="newsblog-category-description">
        <?php echo $description; ?>
      </div>
      <?php } ?>
    
  
      <?php if ($articles) { ?>
      <div class="row row-flex row-article">
        <?php foreach ($articles as $article) { ?>
        <div class="product-layout casing-article col-sm-4 col-xs-6">
          <div class="product-thumb">
            <?php if ($article['thumb']) { ?>
              <div class="image">
                <a href="<?php echo $article['href']; ?>">
                  <img src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['name']; ?>" title="<?php echo $article['name']; ?>" class="img-responsive" />
                </a>
              </div>
            <?php } ?>
          
            
            <div class="caption">
              <p class="article-date"><?php echo $article['date']; ?></p>
              <?php if (!empty($is_popular_news)) { ?>
              <div class="title-news"><strong><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></strong></div>
              <?php } else { ?>
              <h4 class="title-news"><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></h4>
              <?php } ?>
              <p class="desctiption-news"><?php echo $article['preview']; ?></p>
            </div>
            </div>  
          </div>
        <?php } ?>
      </div>
      <div class="row row-bottom">
        <div class="col-sx-12 text-center <?php echo false?'hidden-xs':''; ?>"><?php echo $pagination; ?></div>
        <div class="pre_pagination <?php echo false?'visible-xs':'hidden'; ?>"><span>Загрузить еще</span></div>

        <div class="col-sm-6 text-right hidden"><?php echo $results; ?></div>
      </div>
      <?php } ?>
      <?php if (!$categories && !$articles) { ?>
      <p><?php echo $text_empty; ?></p>
     
      <?php } ?>
   
      <?php echo $content_bottom; ?></div>
                        
    <?php echo $column_right; ?>
  <?php echo $column_left; ?>
  </div>
</div>
<?php echo $footer; ?>
