<div class="module-newsblog-popular">
<?php if ($heading_title) { ?>
<h2><?php echo $heading_title; ?></h2>
<?php } ?>

<div class="row row-flex newsblog-popular" >
  <?php foreach ($articles as $article) { ?>
  <div class="col-md-12 col-sm-4 col-xs-6 col-newsblog-popular">
    <div>
        
         
        
      <?php if ($article['thumb']) { ?>
      <div class="image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['name']; ?>" title="<?php echo $article['name']; ?>" class="img-responsive" /></a></div>
      <?php } ?>
      <div class="date-more-article"><?php echo $article['date']; ?></div>
      <div class="caption">
        <h4 class="title-news"><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></h4>
        <p class="desctiption-news"><?php echo $article['preview']; ?></p>
      </div>
     
    </div>
  </div>
  <?php } ?>
</div>
</div>