<?php echo $header; ?>
<div class="container">
  
  <div class="row">
  <?php echo $column_left; ?>
   
    <div id="content" class="col-md-9">
        <ul class="breadcrumbs list-inline">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a class="crumb" href="<?php echo $breadcrumb['href']; ?>"><span ><?php echo $breadcrumb['text']; ?></span></a>
                </li>
                <?php } ?>
        </ul>
        <div class="visible-xs mini-catalog-product"><?php echo $mini_catalog; ?></div>
        <?php echo $content_top; ?>
      <h1 itemprop="name" class="text-center"><?php echo $heading_title; ?></h1>
      <?php echo $description; ?><?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>