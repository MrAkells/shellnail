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
      <?php echo $description; ?>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>
          <legend><?php echo $text_contact; ?></legend>
          <div class="form-group required">
            <label class="col-sm-3 col-md-2 control-label form-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-md-10 col-sm-9">
              <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 col-md-2 control-label form-label" for="input-email"><?php echo $entry_email; ?></label>
            <div class="col-md-10 col-sm-9">
              <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" />
              <?php if ($error_email) { ?>
              <div class="text-danger"><?php echo $error_email; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 col-md-2 control-label form-label" for="input-enquiry"><?php echo $entry_enquiry; ?></label>
            <div class="col-md-10 col-sm-9">
              <textarea name="enquiry" rows="10" id="input-enquiry" class="form-control"><?php echo $enquiry; ?></textarea>
              <?php if ($error_enquiry) { ?>
              <div class="text-danger"><?php echo $error_enquiry; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php echo $captcha; ?>
        </fieldset>
        <div class="buttons">
          <div class="pull-right">
            <input class="btn btn-primary" type="submit" value="<?php echo $button_submit; ?>" />
          </div>
        </div>
      </form>     
      <?php echo $content_bottom; ?>
    </div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>