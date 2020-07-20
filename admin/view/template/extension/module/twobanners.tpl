<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-twobanners" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-twobanners" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-4 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-4">
              <select name="twobanners_status" id="input-status" class="form-control">
                <?php if ($twobanners_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-sm-4"></div>
          </div>
            
            <div class="form-group">
                    <label class="col-sm-3 control-label" for="input_catalog_banner"><?php echo $entry_catalog_banner; ?></label>
                    <div class="col-sm-6">
                        <select class='form-control' name='twobanners_first_banner_id' id='input_catalog_banner'>
                            <?php foreach($all_banners as $banner){ ?>
                                <?php if($banner['banner_id']==$twobanners_first_banner_id){ ?>
                                <option selected value="<?php echo $banner['banner_id']; ?>"><?php echo $banner['name']; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $banner['banner_id']; ?>"><?php echo $banner['name']; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <table>
                            <tr>
                                <th><?php echo $entry_width; ?></th>
                                <th><?php echo $entry_height; ?></th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="twobanners_first_width" value="<?php echo $twobanners_first_width; ?>" class="form-control" /></td>
                                <td>
                                    <input type="text" name="twobanners_first_height" value="<?php echo $twobanners_first_height; ?>"  class="form-control" /></td>
                            </tr>
                        </table>
                    </div>
                </div>
          
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="input_brands_banner"><?php echo $entry_brands_banner; ?></label>
                    <div class="col-sm-6">
                        <select class='form-control' name='twobanners_second_banner_id' id='input_brands_banner'>
                            <?php foreach($all_banners as $banner){ ?>
                                <?php if($banner['banner_id']==$twobanners_second_banner_id){ ?>
                                    <option selected value="<?php echo $banner['banner_id']; ?>"><?php echo $banner['name']; ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $banner['banner_id']; ?>"><?php echo $banner['name']; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                         <table>
                            <tr>
                                <th><?php echo $entry_width; ?></th>
                                <th><?php echo $entry_height; ?></th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="twobanners_second_width" value="<?php echo $twobanners_second_width; ?>"  class="form-control" /></td>
                                <td>
                                    <input type="text" name="twobanners_second_height" value="<?php echo $twobanners_second_height; ?>" class="form-control" />
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            
            
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>