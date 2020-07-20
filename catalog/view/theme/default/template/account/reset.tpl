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

      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>
          <legend><?php echo $text_password; ?></legend>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-password"><?php echo $entry_password; ?></label>
            <div class="col-sm-10">
              <input type="password" name="password" value="<?php echo $password; ?>" id="input-password" class="form-control" />
              <?php if ($error_password) { ?>
              <div class="text-danger"><?php echo $error_password; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-confirm"><?php echo $entry_confirm; ?></label>
            <div class="col-sm-10">
              <input type="password" name="confirm" value="<?php echo $confirm; ?>" id="input-confirm" class="form-control" />
              <?php if ($error_confirm) { ?>
              <div class="text-danger"><?php echo $error_confirm; ?></div>
              <?php } ?>
            </div>
          </div>
        </fieldset>
        <div class="buttons clearfix">
          <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-default"><?php echo $button_back; ?></a></div>
          <div class="pull-right"><button type="submit" class="btn btn-default"><i class="fa fa-save"></i> <?php echo $button_continue; ?></button></div>
        </div>
      </form>
       
     </div>
    </div>
</div>
<?php echo $footer; ?>