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
      
      <?php if ($error_warning) { ?>
  <div class="alert alert-danger" ><i class="fa fa-exclamation-circle"></i><span style="font-size: 1.5em;"> <?php echo $error_warning; ?></span></div>
  <?php } ?>
  
        <?php if (isset($success) && $success) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
        <?php } ?>
      
      <p><?php echo $text_email; ?></p>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>
          <legend><?php echo $text_your_email; ?></legend>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
            </div>
          </div>
        </fieldset>
        <div class="buttons clearfix">
          <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-default"><?php echo $button_back; ?></a></div>
          <div class="pull-right">
            <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-default" />
          </div>
        </div>
      </form>
      </div>
    </div>
</div>
<?php echo $footer; ?>