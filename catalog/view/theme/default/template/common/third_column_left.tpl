<?php if ($modules) { ?>
<aside id="column-left" class="col-xs-12 col-sm-12 col-md-3">
    
    <?php if(isset($category_breadcrumbs) && $category_breadcrumbs){ ?>
    <ul class="breadcrumbs breadcrumbs--phone list-inline hidden-md hidden-lg">
        <?php $i=0; ?>
        <?php foreach ($category_breadcrumbs as $i => $breadcrumb) { ?>
            <li>
                <?php if($i+1 < count($category_breadcrumbs)) { ?>
                    <a class="crumb" href="<?php echo $breadcrumb['href']; ?>">
                        <span class="p-hidden" ><?php echo $breadcrumb['text']; ?></span>
                    </a>
                    
                <?php } else { ?>
                    <span class="crumb"  >
                        <span><?php echo $breadcrumb['text']; ?></span>
                    </span>
                   
                <?php } ?>
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
