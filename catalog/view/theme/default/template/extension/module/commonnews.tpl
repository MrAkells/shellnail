<div class='row common-news'>
<div class='col-lg-8 col-md-7 col-sm-12'>
<?php if ($heading_title) { ?>
<h2 class="title-common-news hidden-xs hidden-sm"><?php echo $heading_title; ?></h2>
<?php } ?>

    <?php if (isset($shop_description)) { ?> 
        <div class="hidden-xs hidden-sm description-text">
            <?php echo $shop_description;  ?>
        </div>
    <?php } ?>
</div>
<div  class='col-lg-4 col-md-5 col-news col-sm-12'>
    <h2 class="title-common-news"><?php echo $text_all_articles; ?></h2>
    <?php foreach ($articles as $article) { ?>
        <?php if ($article['thumb']) { ?>
        <div class="item">
            <div class="image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['name']; ?>" title="<?php echo $article['name']; ?>" class="img-responsive" /></a></div>
            <div class="info-news">
                <div class="date-news"><?php echo $article['date']; ?></div>
                <div class="title-news"><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a> </div>
                <div class="desctiption-news">
                   <?php echo $article['preview']; ?>
                </div>
            </div>
            <div style="clear: left"></div>
        </div>
        <?php } ?>
    <?php } ?>
    
    <?php if ($link_to_category) { ?>
    <div class="block-more-news">
        <a href="<?php echo $link_to_category; ?>" class="read-more-news"><?php echo $text_more; ?></a>
    </div>
<?php } ?>

    
</div>
    </div>
  

