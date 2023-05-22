<?php echo $header; ?>
<div class="container">
  
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row">
      <?php echo $column_left; ?>
    <div id="content" class="col-sm-9"><?php echo $content_top; ?>
         <ul class="breadcrumbs list-inline">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <li><a class="crumb" href="<?php echo $breadcrumb['href']; ?>"><span ><?php echo $breadcrumb['text']; ?></span></a>
            </li>
            <?php } ?>
        </ul>
      <div class="row">
           <h1 class="text-center"><?php echo $heading_title; ?></h1>
        <div class="col-sm-6">
          <button type="button" onclick="social_auth.googleplus(this)" data-loading-text="Loading" class="btn btn-primary">G+</button>
          <button type="button" onclick="social_auth.facebook(this)" data-loading-text="Loading" class="btn btn-primary">FB</button>
        </div>

      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>