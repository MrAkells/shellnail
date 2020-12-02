<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-latest" data-toggle="tooltip" title="<?php echo $button_save; ?>"
          class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
          class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-np_invoice"
          class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-np_key"><?php echo $entry_np_key; ?></label>
            <div class="col-sm-10">
              <input type="text" name="sd_np_key" value="<?php echo $sd_np_key; ?>"
                placeholder="<?php echo $entry_np_key; ?>" id="input-np_key" class="form-control" />
              <?php if ($error_np_key) { ?>
              <div class="text-danger"><?php echo $error_np_key; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-np_sender"><?php echo $entry_np_sender; ?></label>
            <div class="col-sm-10">
              <select name="sd_np_sender" id="input-np_sender" class="form-control">
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"
              for="input-np_сontact_sender"><?php echo $entry_np_сontact_sender; ?></label>
            <div class="col-sm-10">
              <select name="sd_np_сontact_sender" id="input-np_сontact_sender" class="form-control">
              </select>
            </div>
            <input type="hidden" name="sd_np_сontact_phone" value="" id="input-np_сontact_phone" />
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-np_ref_city"><?php echo $entry_np_ref_city; ?></label>
            <div class="col-sm-10">
              <input type="text" name="sd_np_ref_city" value="<?php echo $sd_np_ref_city; ?>"
                placeholder="<?php echo $entry_np_ref_city; ?>" id="input-np_ref_city" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"
              for="input-np_ref_sender_address"><?php echo $entry_np_ref_sender_address; ?></label>
            <div class="col-sm-10">
              <input type="text" name="sd_np_ref_sender_address" value="<?php echo $sd_np_ref_sender_address; ?>"
                placeholder="<?php echo $entry_np_ref_sender_address; ?>" id="input-np_ref_sender_address"
                class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-np_status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="sd_np_status" id="input-np_status" class="form-control">
                <?php if ($sd_np_status) { ?>
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
<script type="text/javascript">
  $(document).ready(function () {
    $.ajax({
      url: 'index.php?route=extension/module/sd_np_invoice/get_senders&token=<?php echo $token; ?>',
      dataType: 'json',
      success: function (json) {
        if (!json['err']) {
          $('#input-np_sender').html(json['senders']);

        }
      }
    });
    $.ajax({
      url: 'index.php?route=extension/module/sd_np_invoice/get_contacts&token=<?php echo $token; ?>',
      dataType: 'json',
      success: function (json) {
        if (!json['err']) {
          $('#input-np_сontact_sender').html(json['contacts']);
          $('#input-np_сontact_phone').val(json['contact_phone']);
        }
        console.log(json);
      }
    });
    $('#input-np_сontact_sender').on('change', function () {
      $('#input-np_сontact_phone').val($('#input-np_сontact_sender > option:selected').data('phone'));
    });
  });
</script>
<?php echo $footer; ?>