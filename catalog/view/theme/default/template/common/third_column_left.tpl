<?php if ($modules) { ?>
<aside id="column-left" class="col-xs-12 col-sm-12 col-md-3">
    
    <?php if(isset($category_breadcrumbs) && $category_breadcrumbs){ ?>
    <ul class="breadcrumbs list-inline hidden-md hidden-lg">
        <?php foreach ($category_breadcrumbs as $breadcrumb) { ?>
            <li>
                <a class="crumb" href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            </li>
        <?php } ?>
    </ul>
   <?php } ?>
    
    
    <div class="hidden-md hidden-lg mini-catalog-сategory">
        <?php echo $mini_header_catalog; ?>
    </div> 
   
  <?php foreach ($modules as $module) { ?>
  <?php echo $module; ?>
  <?php } ?>
</aside>
<?php } ?>
