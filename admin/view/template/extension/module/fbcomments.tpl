<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-html" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-html" class="form-horizontal">
            
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>         
          <ul class="nav nav-tabs" id="language">
            <?php foreach ($languages as $language) { ?>
            <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
            <?php } ?>
          </ul>

          <div class="tab-content">
            <?php foreach ($languages as $language) { ?>
            <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-name">Front <?php echo $entry_name; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="name_front[<?php echo $language['language_id']; ?>]" value="<?php echo $name_front[$language['language_id']]; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                  <?php if ($error_name) { ?>
                  <div class="text-danger"><?php echo $error_name; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div> 
            <?php } ?>
          </div>
          <hr>
            <div class="form-group">
            <label class="col-sm-2 control-label" for="input-width"><?php echo $entry_width; ?></label>
            <div class="col-sm-10">
              <input type="number" name="width" value="<?php echo $width; ?>" id="input-width" class="form-control" />
              <?php if ($error_width) { ?>
              <div class="text-danger"><?php echo $error_width; ?></div>
              <?php } ?>
            </div>
          </div>     
            
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-comments_number"><?php echo $entry_number; ?></label>
            <div class="col-sm-10">
              <input type="number" name="comments_number" value="<?php echo $comments_number; ?>" id="input-comments_number" class="form-control" />
              <?php if ($error_comments_number) { ?>
              <div class="text-danger"><?php echo $error_comments_number; ?></div>
              <?php } ?>
            </div>
          </div>  
            
            
            <div class="form-group">
            <label class="col-sm-2 control-label" for="input-comments_height"><?php echo $entry_comments_height; ?></label>
            <div class="col-sm-10">
              <input type="number" name="comments_height" value="<?php echo $comments_height; ?>" id="input-comments_height" class="form-control" />
            </div>
          </div>  
            
            
           <div class="form-group">
            <label class="col-sm-2 control-label" for="input-template"><span data-toggle="tooltip" title="<?php echo $help_template; ?>"><?php echo $entry_template; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="module_template" value="<?php echo $module_template; ?>" placeholder="<?php echo $example_template; ?>" id="input-template" class="form-control" />
            </div>
          </div> 
            
            
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
    $('#language a:first').tab('show');
  //--></script>

<?php echo $footer; ?>