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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-account" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="stickers_status" id="input-status" class="form-control">
                <?php if ($stickers_status) { ?>
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
            <label class="col-sm-3 control-label" for="input-popular"><?php echo $text_popular; ?></label>
            <div class="col-sm-5">
              <select name="stickers_popular" id="input-popular" class="form-control">
                <?php if ($stickers_popular) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
            <label class="col-sm-2 control-label"><?php echo $text_limit; ?></label>
            <div class="col-sm-2">
                <input type="number" class="form-control" name="stickers_popular_limit" value="<?php echo $popular_limit ?>">
            </div>
            
        
            
          </div>
            
           
  
         
            
            
            <div class="form-group">
            <label class="col-sm-3 control-label" for="input-latest"><?php echo $text_latest; ?></label>
            <div class="col-sm-5">
              <select name="stickers_latest" id="input-latest" class="form-control">
                <?php if ($stickers_latest) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
            <label class="col-sm-2 control-label"><?php echo $text_limit; ?></label>
            <div class="col-sm-2">
                <input type="number" class="form-control" name="stickers_latest_limit" value="<?php echo $latest_limit; ?>">
            </div>
        
            
          </div>
            
            
               <div class="form-group">
            <label class="col-sm-3 control-label" for="input-bestseller"><?php echo $text_bestseller; ?></label>
            <div class="col-sm-5">
              <select name="stickers_bestseller" id="input-bestseller" class="form-control">
                <?php if ($stickers_bestseller) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
            <label class="col-sm-2 control-label"><?php echo $text_limit; ?></label>
            <div class="col-sm-2">
                <input type="number" class="form-control" name="stickers_bestseller_limit" value="<?php echo $bestseller_limit; ?>">
            </div>
           
            </div>
            
            
               <div class="form-group">
            <label class="col-sm-3 control-label" for="input-special"><?php echo $text_special; ?></label>
            <div class="col-sm-5">
              <select name="stickers_special" id="input-special" class="form-control">
                <?php if ($stickers_special) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
           
           
            </div>
            
            
            <div class='row'>
                <br/><br/>
                <div class='col-sm-4'></div>
                <div class='col-sm-2'>
                    
                    <select name="hand_stickers"  class="form-control">
                        <option value="0"><?php echo  $text_do_nothing; ?></option>
                        <option value="1"><?php echo $clear_hand_stickers; ?></option>
                    </select>
                </div>
                <div class='col-sm-2'>
                    <select name="auto_stickers"  class="form-control">
                        <option value="0"><?php echo  $text_do_nothing; ?></option>
                        <option value="1"><?php echo  $clear_auto_stickers; ?></option>
                        <option value="2"><?php echo $update_auto_stickers; ?></option>
                    </select>
                </div>
                <div class='col-sm-4'></div>
            </div>
            
             
               
            
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>

