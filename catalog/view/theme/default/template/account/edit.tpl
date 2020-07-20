<div class="row">
  
    <div id="personalData">
       
      <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
      <form id="personal_form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset class="field-personal">
        <div class="col-sm-12">
          <div class="title-in-tab"><?php echo $text_your_details; ?></div>
        </div>
        <div class="col-md-6">
          <div class="form-group register-group">
            <label class="col-sm-12 register-label form-label" for="input-firstname"><?php echo $entry_firstname; ?> </label>
            <div class="col-sm-12">
              <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="form-control" />
              <?php if ($error_firstname) { ?>
              <div class="text-danger"><?php echo $error_firstname; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group register-group">
            <label class="col-sm-12 register-label form-label" for="input-lastname"><?php echo $entry_lastname; ?></label>
            <div class="col-sm-12">
              <input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-lastname" class="form-control" />
              <?php if ($error_lastname) { ?>
              <div class="text-danger"><?php echo $error_lastname; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group register-group">
            <label class="col-sm-12 register-label form-label" for="input-email"><?php echo $entry_email; ?></label>
            <div class="col-sm-12">
              <input type="email" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
              <?php if ($error_email) { ?>
              <div class="text-danger"><?php echo $error_email; ?></div>
              <?php } ?>
            </div>
          </div>
          </div>


          <div class="col-md-6 personal-second">
          <div class="form-group register-group">
            <label class="col-sm-12 register-label form-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
            <div class="col-sm-12">
              <input type="tel" name="telephone" value="<?php echo $telephone; ?>" placeholder="+38(___)-___-__-__" id="input-telephone" class="form-control" data-inputmask="'mask': '+99(999)-999-99-99'"/>
              
                <script type="text/javascript">
                    $('#input-telephone').inputmask();
                </script>
              
              <?php if ($error_telephone) { ?>
              <div class="text-danger"><?php echo $error_telephone; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group register-group">
            <label class="col-sm-12 register-label form-label" for="input-customer_birthday"><?php echo $entry_customer_birthday; ?></label>
            <div class="col-sm-12">
              <input type="text" name="birthday" value="<?php echo $customer_birthday; ?>" placeholder="<?php echo $entry_customer_birthday; ?>" id="input-customer_birthday" class="form-control" />
            </div>
          </div>
        </div>
       
        </fieldset>
        <div class="buttons clearfix"></div>
      </form>
     </div>
   </div>

<script type="text/javascript"><!--
    $(document).delegate('#send_personal_data', 'click', function() {
        
        var url=$('#personal_form').attr('action');
        
	$.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: new FormData($('#personal_form')[0]),
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
                    var markup=$('#personalData', json.html);
                    $('#personalData').html(markup.html());
		}
            },
            error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
	});
	
});
//--></script>

