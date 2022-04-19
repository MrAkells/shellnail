<div id="login_modal" class="modal fade text-left">
	<div class="modal-dialog modal-login">
        <div class="modal-content">
            <form id="login_modal_form" action="<?php echo $action; ?>" role="form">
                <div class="modal-header header-avtorization">
                        <button class="close close-icon" type="button" data-dismiss="modal"><span></span></button>
                        <div class="h2title modal-title title-login"><?php echo $heading_title; ?></div>
                </div>
                <div class="modal-body body-avtorization"> 
                    
                    <div class="alert alert-danger hidden" id="modal_login_error"><i class="fa fa-exclamation-circle"></i></div>
                    
                    <div class="form-group form-group-login required">
                        <label class="control-label" for="input-login_email"><?php echo $entry_login_email; ?></label>
                        <input type="text" name="login_email"  id="input-login_email" class="form-control" />
                    </div>
                    
                    <div class="form-group required">
                        <label class="control-label" for="input-login_password" class="autorization-password"><?php echo $entry_login_password; ?></label>
                        <div class="forgotten"> <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a> </div>
                        <input type="password" name="login_password" id="input-login_password" class="form-control" />
                    </div>
                    <div class="remeber-and-autorization">
                        <div class="form-group block-remember search-btn" data-toggle="buttons">
                            <label class="control-label btn new-check" for="input-login_password">
                            <input type="checkbox"  name="remember_me" value="1" />
                            <span class="title-check title-remember"><?php echo $entry_remember; ?></span>
                            </label>
                        </div>
                    
                    
                        <div class="form-group block-btn-avtorization">
                            <span id="try_to_login"  class="form_send"><?php echo $text_step_into; ?>   </span>
                        </div>
                    </div>
                </div>
            </form>

            <div class="social-autorization-modal">
                <div class="social-autorization__title"><?php echo $text_contact_details; ?></div>
                <?php include DIR_APPLICATION . '/view/theme/default/template/component/social_autorization.tpl'; ?>
            </div>

        </div>
	</div>
</div>
<script>
    
    $(document).ready(function(){
        
        $('#try_to_login').on('click', function() {
            var route='<?php echo $route; ?>';
            var login_form=new FormData($('#login_modal_form')[0]);
            var url=$('#login_modal_form').attr('action');
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: login_form,
                cache: false,
                contentType: false,
                processData: false,
                success: function(json) {
                    if(json.success){
                        $('#modal_login_error').addClass('hidden');
                        //console.log(json.message, route);
                        if (route == 'account/logout') {
                            location.replace('/index.php?route=account/account');
                        }else{
                            location.reload();
                        } 
                    }else{
                    // console.log(json.message);
                        $('#modal_login_error').removeClass('hidden');
                        $('#modal_login_error').html(json.message);
                    }
                
                }
            });
        });
    });
</script> 
<script type="text/javascript">
 
$(document).ready(function(){
   $('.remeber-and-autorization input:checkbox').change(function(){
   if($(this).is(':checked')) 
       $(this).parent().addClass('violet-check'); 
  else 
      $(this).parent().removeClass('violet-check')
 });

});

</script>       
        
      