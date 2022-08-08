<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
            <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img
                            src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png"
                            title="<?php echo $language['name']; ?>" />
                        <?php echo $language['name']; ?>
                    </a></li>
                <?php } ?>
            </ul>
            <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-title">
                            <?php echo $entry_title; ?>
                        </label>
                        <div class="col-sm-8">
                            <input name="extralink_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($extralink_description[$language['language_id']]) && isset($extralink_description[$language['language_id']]['title']) ? $extralink_description[$language['language_id']]['title'] : ''; ?>" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-column_link">
                            <?php echo $column_link; ?>
                        </label>
                        <div class="col-sm-8">
                            <input name="extralink_description[<?php echo $language['language_id']; ?>][link]" value="<?php echo isset($extralink_description[$language['language_id']]) && isset($extralink_description[$language['language_id']]['link']) ? $extralink_description[$language['language_id']]['link'] : ''; ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <?php } ?>         
            </div>    
            
            <hr>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-parent"><?php echo $entry_parent; ?></label>
                <div class="col-sm-8">
                  <select name="parent_id" class="form-control">
                    <option value="0" selected="selected"><?php echo $text_none; ?></option>
                    <?php foreach ($categories as $category) { ?>
                    <?php if ($category['category_id'] == $parent_id) { ?>
                    <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            
               <div class="form-group">
                <label class="col-sm-3 control-label" for="input-sort"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-8">
                    <input name="sort_order" value="<?php echo $sort_order; ?>" class="form-control">
                </div>
              </div>
            
                <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $entry_icon; ?></label>
                <div class="col-sm-4"><a href="" id="thumb-icon" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb_icon; ?>" alt="" title="" /></a>
                  <input type="hidden" name="icon" value="<?php echo $icon; ?>" id="input-icon" />
                </div>
                  <div class="col-sm-4"><a href="" id="thumb-icon2" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb_icon2; ?>" alt="" title="" /></a>
                  <input type="hidden" name="icon2" value="<?php echo $icon2; ?>" id="input-icon2" />
                </div>
              </div>
            
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-8">
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

  </div>
  <script type="text/javascript"><!--
    $('#language a:first').tab('show');
  //--></script>
<?php echo $footer; ?>
