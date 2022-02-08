<?php echo $header; ?>
<div class="container">
 
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row precheckout">
    <div class="col-lg-5 col-md-6">
      <h1><?php echo $heading_title; ?></h1>
      <div class="social_login-autorization">
        <div class="contact-details"><?php echo $text_contact_details; ?></div>
        <button type="button" onclick="social_auth.facebook(this)" data-loading-text="<?= $text_loading; ?>" class="btn btn-primary"><i class="fa fa-facebook-f"></i></button>
        <button type="button" onclick="social_auth.googleplus(this)" data-loading-text="<?= $text_loading; ?>" class="btn btn-primary"><i class="fa fa-google"></i></button>
        <button type="button" onclick="social_auth.instagram(this)" data-loading-text="<?= $text_loading; ?>" class="btn btn-primary"><i class="fa fa-instagram"></i></button>      
      </div>
      
       <ul class="nav nav-tabs new-nav-tabs precheckout-tabs">
          <li class="active"><a data-toggle="tab" href="#tab1"><span><?php echo $text_new; ?></span></a></li>
          <li><a data-toggle="tab" href="#tab2"><span><?php echo $text_customer; ?></span></a></li>
        </ul>
        <div class="tab-content">
            <div id="tab1" class="tab-pane fade in active">
              <div id="new_customer">
                <form action="<?php echo $action.'&cred=guest'; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                  <div class="form-group register-group required">
                    <label class="col-xs-12 register-label form-label" for="input-firstname"><?php echo $entry_firstname; ?></label>
                    <div class="col-xs-12">
                      <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="form-control" />
                      <?php if ($error_firstname) { ?>
                        <div class="text-danger"><?php echo $error_firstname; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group register-group required">
                    <label class="col-xs-12 register-label form-label" for="input-lastname"><?php echo $entry_lastname; ?></label>
                    <div class="col-xs-12">
                      <input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-lastname" class="form-control" />
                      <?php if ($error_lastname) { ?>
                        <div class="text-danger"><?php echo $error_lastname; ?></div>
                        <?php } ?>
                    </div>
                  </div>
                  <div class="form-group register-group required">
                    <label class="col-xs-12 register-label form-label " for="input-telephone"><?php echo $entry_telephone; ?></label>
                    <div class="col-xs-12">
                      <input type="tel" name="telephone" value="<?php echo $telephone; ?>" placeholder="+38(___)-___-__-__" id="input-telephone" class="form-control" data-inputmask="'mask': '+99(999)-999-99-99'"/>
                      
                      <?php if ($error_telephone) { ?>
                        <div class="text-danger"><?php echo $error_telephone; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group register-group required">
                    <label class="col-xs-12 register-label form-label" for="input-email"><?php echo $entry_email; ?></label>
                    <div class="col-xs-12">
                      <input type="email" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
                      <?php if ($error_email) { ?>
                        <div class="text-danger"><?php echo $error_email; ?></div>
                      <?php } ?>
                    </div>
                  </div>    
                  <div class="form-group">
                    <div class="col-sm-12">
                      <div class="search-btn" data-toggle="buttons">
                        <label class="control-label form-label  btn new-check active">
                            <input type="checkbox" name="newsletter" value="1" <?php echo $newsletter?'checked':''; ?> />
                          <span class="title-check title-remember title-reg"><?php echo $text_newsletter; ?></span>
                        </label>
                      </div>
                    </div>
                  </div> 
                  <div class="buttons">
                    <div class="btn-register">
                      <span id="continue_as_new" class="btn btn-default btn-forth"><?php echo $end_step; ?></span>
                    </div>
                  </div>
              </form>
            </div>
          </div>
          <div id="tab2" class="tab-pane fade in">
            <div  id="old_customer">
              <form action="<?php echo $action.'&cred=login'; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group register-group required">
                  <label class="col-xs-12 register-label form-label" for="input-login"><?php echo $entry_login; ?></label>
                  <div class="col-xs-12">
                    <input type="text" name="login" value="<?php echo $login; ?>" placeholder="" id="input-login" class="form-control" />
                    <?php if ($error_login) { ?>
                      <div class="text-danger"><?php echo $error_login; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group register-group required">
                  <label class="col-xs-12 register-label form-label" for="input-password"><?php echo $entry_password; ?></label>
                  <div class="col-xs-12">
                    <input type="password" name="password" value="<?php echo $password; ?>" placeholder="" id="input-password" class="form-control" />
                    <?php if ($error_password) { ?>
                      <div class="text-danger"><?php echo $error_password; ?></div>
                    <?php } ?>
                  </div>
                </div>
              </form>
              <div class="buttons">
                <div class="btn-register">
                  <div class="precheckout-register">
                    <a href="<?php echo $register_link; ?>"><span class="btn btn-default"><?php echo $text_register; ?></span></a></div>
                  <div class="precheckout-enter">
                    <span id="continue_as_old" class="btn btn-primary"><?php echo $try_to_login; ?></span>
                  </div>
                   <div style="clear: left"></div>
                </div>
               
                  
              </div>
            </div>   
          </div>   
      </div>
    </div> 
    <div class="col-lg-5 col-lg-offset-2 col-md-6 col-md-offset-0 hidden-sm hidden-xs">
      <div>
          <?php echo $big_cart; ?>
      </div>
    </div>
      
      
      
      <?php echo $content_bottom; ?></div>
    </div>
</div>
<script>
    $(document).ready(function(){
        
        $(document).delegate('#continue_as_new', 'click', function(){
            
              var url=$('#new_customer form').attr('action');
        
	$.ajax({
            url: url,
            type: 'post',
          
            data: new FormData($('#new_customer form')[0]),
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                    var markup=$('#new_customer', result);
                    $('#new_customer').html(markup.html());
                    
                    if($('#login_success', result).length){
                        console.log($('#login_success', result).length);
                       location.reload();
                    }
            },
            error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
	});
	
        });
        
        
         $(document).delegate('#continue_as_old', 'click', function(){
            
              var url=$('#old_customer form').attr('action');
        
	$.ajax({
            url: url,
            type: 'post',
          
            data: new FormData($('#old_customer form')[0]),
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                
                    if($('#login_success', result).length){
                       location.reload();
                    }
                
                    var markup=$('#old_customer', result);
                    $('#old_customer').html(markup.html());
            },
            error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
	});
        
        
    });
    
      });
</script>
<script type="text/javascript">
 

    $(document).delegate('input:checkbox', 'change', function(){
        if($(this).is(':checked')) 
            $(this).parent().addClass('violet-check'); 
        else 
            $(this).parent().removeClass('violet-check')
    });



</script> 
<script type="text/javascript">
                        $('#input-telephone').inputmask();
                        $('input:checkbox').change();
                      </script>
<?php echo $footer; ?>
