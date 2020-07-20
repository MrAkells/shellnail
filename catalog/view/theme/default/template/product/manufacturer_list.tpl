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
      <ul class="breadcrumbs list-inline" itemscope itemtype="http://schema.org/BreadcrumbList">
           <?php $i=0; ?>
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" class="crumb" href="<?php echo $breadcrumb['href']; ?>"><span itemprop="name"><?php echo $breadcrumb['text']; ?></span></a>
        <meta itemprop="position" content="<?php echo $i++; ?>">
        </li>
        <?php } ?>
      </ul>
      <h1 itemprop="name"><?php echo $heading_title; ?></h1>
      <div class="row tile-of-brand">
        <?php if ($categories) { ?>
    
        <?php foreach ($categories as $category) { ?>
        <div class="col-md-3 col-sm-4 col-xs-6 col-xxs-12 text-center piece-of-tile">
          <a href="<?php echo $category['href']; ?>"><img src="<?php echo $category['thumb']; ?>" alt="<?php echo $category['name']; ?>" title="<?php echo $category['name']; ?>"/></a>
        </div>
      
        <?php } ?>
        <?php } else { ?>
        <p><?php echo $text_empty; ?></p>
        <div class="buttons clearfix">
          <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
        </div>
        <?php } ?>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>