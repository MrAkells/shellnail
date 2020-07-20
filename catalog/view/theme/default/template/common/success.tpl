<?php echo $header; ?>
<div class="container">
    
    <div class="row">
        <?php echo $column_left; ?>
        <div id="content" class="col-xs-12 col-sm-9">
            <ul class="breadcrumbs list-inline">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a class="crumb" href="<?php echo $breadcrumb['href']; ?>"><span ><?php echo $breadcrumb['text']; ?></span></a>
                </li>
                <?php } ?>
            </ul>
            <h1><?php echo $heading_title; ?></h1>
            <?php if (isset($success) && $success) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <span style="font-size: 1.5em"><?php echo $success; ?></span></div>
        <?php } ?>
            <div style="font-size: 1.4em"><?php echo $text_message; ?></div>
            <br/>
                <div class="text-center"><a href="<?php echo $continue; ?>" class="btn-default"><?php echo $button_continue; ?></a></div>
           
      </div>
    </div>
</div>
<?php echo $footer; ?>