<?php echo $header; ?>
<div class="container">
 <ul class="breadcrumbs list-inline">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a class="crumb" href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>

<!-- sd sitemap -->
<div class="row">
  <div class="col-md-12">
    <nav class="sd_sitemap">
    <?php foreach ($categories as $category) { ?>
      <div class="sd_sitemap__level sd_sitemap__level--<?php echo $category['level']; ?>"><a class="sd_sitemap__item" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></div>
    <?php } ?>
    </nav>
  </div>
</div>
<!-- end sd sitemap -->


 <?php if ($page_last) { ?>
      <div class="row">
        <div class="col-sm-12">
          <ul>
            <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
            <li><a href="<?php echo $search; ?>"><?php echo $text_search; ?></a></li>
            <li><?php echo $text_information; ?>
              <ul>
                <?php foreach ($informations as $information) { ?>
                <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
                <?php } ?>
                <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <?php } ?>

      <div id="pagination_row" class="row hidden-xs">
        <div class="pagination-casing"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>