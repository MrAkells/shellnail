  <div id="password_row">
    <div id="password">
     <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php }else if($error_warning){ ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
   
  <?php } ?>
      <form id="change_pass" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
           <div class="title-in-tab"><?php echo $text_password; ?></div>
        <fieldset>
          <div class="form-group register-group">
            <label class="col-sm-12 register-label form-label" for="input-oldpassword"><?php echo $entry_old_password; ?></label>
            <div class="col-sm-12">
              <input type="password" name="oldpassword"  placeholder="<?php echo $entry_old_password; ?>" id="input-oldpassword" class="form-control" />
              <?php if (isset($error_oldpassword) && $error_oldpassword) { ?>
              <div class="text-danger"><?php echo $error_oldpassword; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group register-group">
            <label class="col-sm-12 register-label form-label" for="input-password"><?php echo $entry_password; ?></label>
            <div class="col-sm-12">
              <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
              <?php if (isset($error_password) && $error_password) { ?>
              <div class="text-danger"><?php echo $error_password; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group register-group">
            <label class="col-sm-12 register-label form-label" for="input-confirm"><?php echo $entry_confirm; ?></label>
            <div class="col-sm-12">
              <input type="password" name="confirm" value="<?php echo $confirm; ?>" placeholder="<?php echo $entry_confirm; ?>" id="input-confirm" class="form-control" />
              <?php if (isset($error_confirm) && $error_confirm) { ?>
              <div class="text-danger"><?php echo $error_confirm; ?></div>
              <?php } ?>
            </div>
          </div>
        </fieldset>
        <div class="buttons clearfix">
          <div>
              <span id="send_personal_data" class="btn btn-primary"> <?php echo $button_continue; ?> </span>
          </div>
        </div>
      </form>
      </div>
    </div>

<script type="text/javascript"><!--
    $(document).delegate('#send_personal_data', 'click', function() {
        
        var url=$('#change_pass').attr('action');
        
	$.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: new FormData($('#change_pass')[0]),
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
					
            },
            complete: function() {
		
            },
            success: function(json) {
                console.log(json);
		if (json.success) {
                    var markup=$('#password', json.html);
                    $('#password').html(markup.html());
		}
            },
            error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
	});
	
});
//--></script>

