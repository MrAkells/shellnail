<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-account" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
          
          
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-shopreview" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="shopreview_status" id="input-status" class="form-control">
                <?php if ($shopreview_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
            
           <div class="form-group">
            <label class="col-sm-2 control-label" for="input-seo"><?php echo $entry_seo; ?></label>
            <div class="col-sm-10">
                <input type="text" name="shopreview_seo" id="input-seo" class="form-control" value="<?php echo $seo ?>"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-meta_title"><?php echo $entry_meta_title; ?></label>
            <div class="col-sm-10">
                <input type="text" name="shopreview_meta_title" id="input-meta_title" class="form-control" value="<?php echo $shopreview_meta_title; ?>"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-meta_description"><?php echo $entry_meta_description; ?></label>
            <div class="col-sm-10">
                <textarea type="text" name="shopreview_meta_description" id="input-meta_description" class="form-control"  rows="3"><?php echo $shopreview_meta_description; ?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-meta_keywords"><?php echo $entry_meta_keywords; ?></label>
            <div class="col-sm-10">
                <textarea type="text" name="shopreview_meta_keywords" id="input-meta_keywords" class="form-control"  rows="3"><?php echo $shopreview_meta_keywords; ?></textarea>
            </div>
          </div>
            
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-number_of_reviews"><?php echo $entry_reviews_on_page; ?></label>
            <div class="col-sm-10">
                <input type="number" name="shopreview_reviews_on_page" id="input-number_of_reviews" class="form-control" value="<?php echo $reviews_on_page ?>"/>
            </div>
          </div>
            
        <div class="form-group">
            <label class="col-sm-2 control-label" for="input-width"><?php echo $entry_width; ?></label>
            <div class="col-sm-10">
                <input type="number" name="shopreview_width" id="input-width" class="form-control" value="<?php echo $width; ?>"/>
            </div>
        </div>
            
        <div class="form-group">
            <label class="col-sm-2 control-label" for="input-height"><?php echo $entry_height; ?></label>
            <div class="col-sm-10">
                <input type="number" name="shopreview_height" id="input-height" class="form-control" value="<?php echo $height; ?>"/>
            </div>
        </div>
            
        <div class="form-group">
            <label class="col-sm-5 control-label" for="input-image"><?php echo $entry_image; ?></label>
            <div class="col-sm-3">
                <input type="file" name="reviewimage" id="input-file" class="form-control"/>
            </div>
            <div class="col-sm-4 image">
                <img src="<?php echo $image; ?>"/>
            </div>
        </div>
            
        </form>
          
          
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>