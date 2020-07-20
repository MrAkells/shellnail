<?php if ($heading_title) { ?>
<h3><?php echo $heading_title; ?></h3>
<?php } ?>

<?php 
    // Переменная $html это текст из описания модуля 
    if ($html) { 
        echo $html; 
    } 
 ?>

<div id="news_slider" class="owl-carousel">
    <?php foreach ($articles as $article) { ?>
        <?php if ($article['thumb']) { ?>
        <div class="item">
            <div class="image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['name']; ?>" title="<?php echo $article['name']; ?>" class="img-responsive" /></a></div>
        </div>
        <?php } ?>
    <?php } ?>
</div>
  
<?php if ($link_to_category) { ?>
<a href="<?php echo $link_to_category; ?>"><?php echo $text_more; ?> <?php echo $heading_title; ?></a>
<?php } ?>

