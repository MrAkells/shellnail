<?php echo $header; ?>
<div class="container">

  <div class="row">
    <?php echo $column_left; ?>
    <!-- <div class="col-sm-3 hidden-xs"></div> -->
    <div id="content" class="col-sm-6">

      <ul class="breadcrumbs list-inline">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
          <li><a class="crumb" href="<?php echo $breadcrumb['href']; ?>"><span ><?php echo $breadcrumb['text']; ?></span></a>
          </li>
          <?php } ?>
        </ul>

        <div class="visible-xs mini-catalog-product"><?php echo isset($mini_catalog) ? $mini_catalog : ''; ?></div>

      <?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <p style="font-size: 1.5em;"><?php echo $text_error; ?></p>
      
     <?php if(!isset($no_404image)){ ?>
      <div>
          <img src="image/catalog/background/404.jpg" alt="Страница не найдена. Код ошибки 404" class="img-responsive">
      </div>
      <?php } ?>
      
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      </div>
    </div>
</div>
<?php echo $footer; ?>
