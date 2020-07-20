<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-new_mail" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-new_mail" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-key"><span data-toggle="tooltip" title="<?php echo $help_key; ?>"><?php echo $entry_key; ?></span></label>
            <div class="col-sm-6">
              <input type="text" name="new_mail_key" value="<?php echo $new_mail_key; ?>" placeholder="<?php echo $entry_key; ?>" id="input_key" class="form-control" />
            </div>
            <div class="col-sm-2">
                <button type="button" id="update_base" style="min-width: 220px; font-size: 14px" data-action="<?= $action_base ?>" class="btn btn-primary" ><?= $entry_update ?>
                    <i style="font-size: 18px; display: none" class="fa fa-cog fa-spin fa-3x fa-fw"></i>
                    <span id="popover_progress" data-container="body" data-toggle="popover" data-placement="top" data-content="Update in progress..."  ></span>
                    <span id="popover_updated" data-container="body" data-toggle="popover" data-placement="top" data-content="Database updated ))"  ></span>
                </button>
            </div>
            <div class="col-sm-2">
                <button type="button" id="backup_base" style="min-width: 220px; font-size: 14px" data-action="<?= $action_backup ?>" class="btn btn-primary" ><?= $entry_backup ?>
                    <i style="font-size: 18px; display: none" class="fa fa-cog fa-spin fa-3x fa-fw"></i>
                    <span id="popover_progress_base" data-container="body" data-toggle="popover" data-placement="top" data-content="Update in progress..."  ></span>
                    <span id="popover_updated_base" data-container="body" data-toggle="popover" data-placement="top" data-content="Database updated ))"  ></span>
                </button>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="new_mail_status" id="input-status" class="form-control">
                <?php if ($new_mail_status) { ?>
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
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="new_mail_sort_order" value="<?php echo $new_mail_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
            
             <div class="form-group">
            <label class="col-sm-2 control-label" for="input-freetotal"><?php echo $min_free_total; ?></label>
            <div class="col-sm-10">
              <input type="number" name="new_mail_freetotal" value="<?php echo $new_mail_freetotal; ?>"  id="input-freetotal" class="form-control" />
            </div>
          </div>
            
            
               <div class="form-group">
            <label class="col-sm-6 control-label" for="input-fee"><?php echo $entry_fee; ?></label>
            <div class="col-sm-6">
              <input type="text" name="new_mail_nalozhniy_fee" value="<?php echo $new_mail_nalozhniy_fee; ?>" placeholder="<?php echo $entry_fee; ?>" id="input-fee" class="form-control" />
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-6 control-label" for="input-percent"><?php echo $entry_percent; ?></label>
            <div class="col-sm-6">
              <input type="text" name="new_mail_nalozhniy_percent" value="<?php echo $new_mail_nalozhniy_percent; ?>" placeholder="<?php echo $entry_percent; ?>" id="input-percent" class="form-control" />
            </div>
          </div>
            
            
            
                 <div class="form-group">
            <label class="col-sm-4 control-label" for="total-status"><?php echo $entry_total_status; ?></label>
            <div class="col-sm-8">
              <select name="new_mail_total_status" id="total-status" class="form-control">
                <?php if ($new_mail_total_status) { ?>
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
<?php echo $footer; ?>

<script>
    jQuery('document').ready(function($)
    {
        $('#update_base').on('click', function(){
            var action = $(this).data('action');
            var key = $('#input_key').val();
            var sp = $(this).find('i');
            $('#popover_progress').popover('show');
            setTimeout(function(){
                $('#popover_progress').popover('hide');
            }, 3000);
            sp.show();
            $.post(action, JSON.stringify({'key':key}), function(response) 
            {
                if (response == true) {
                    $('#popover_updated').popover('show');
                    setTimeout(function(){
                        $('#popover_updated').popover('hide');
                    }, 3000);
                    sp.hide();
                }else{consol.log(response);}
            }, 'json');
        });
        $('#popover_progress, #popover_updated').popover();
        
        $('#backup_base').on('click', function(){
            var action = $(this).data('action');
            var key = $('#input_key').val();
            var sp = $(this).find('i');
            $('#popover_progress_base').popover('show');
            setTimeout(function(){
                $('#popover_progress_base').popover('hide');
            }, 3000);
            sp.show();
            $.post(action, JSON.stringify({'key':key}), function(response) 
            {
                if (response == true) {
                    $('#popover_updated_base').popover('show');
                    setTimeout(function(){
                        $('#popover_updated_base').popover('hide');
                    }, 3000);
                    sp.hide();
                }else{consol.log(response);}
            }, 'json');
        });
        $('#popover_progress_base, #popover_updated_base').popover();
    });
</script>