<?php if ($modules) { ?>
<aside id="column-left" class="col-xs-12 col-sm-12 col-md-3">
    
    <?php if(isset($category_breadcrumbs) && $category_breadcrumbs){ ?>
    <ul class="breadcrumbs breadcrumbs--phone list-inline hidden-md hidden-lg" itemscope itemtype="https://schema.org/BreadcrumbList">
        <?php $i=0; ?>
        <?php foreach ($category_breadcrumbs as $i => $breadcrumb) { ?>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <?php if($i+1 < count($category_breadcrumbs)) { ?>
                    <a class="crumb" itemscope itemtype="https://schema.org/Thing" itemprop="item" href="<?php echo $breadcrumb['href']; ?>">
                        <span class="p-hidden" itemprop="name"><?php echo $breadcrumb['text']; ?></span>
                    </a>
                    <meta itemprop="position" content="<?php echo $i+1; ?>" /> 
                <?php } else { ?>
                    <span class="crumb" itemscope itemtype="https://schema.org/Thing" itemprop="item" >
                        <span itemprop="name"><?php echo $breadcrumb['text']; ?></span>
                    </span>
                    <meta itemprop="position" content="<?php echo $i+1; ?>" /> 
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
