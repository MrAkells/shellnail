    
<div class="block-write">
    <button type="button" id="write-shopreview" class="btn btn-primary" onclick="$('#block-shopreview').slideToggle()"><?php echo $button_write; ?></button> 
</div>
<div id="block-shopreview" style="display: none;">
    
        <form class="form-horizontal" id="form-shopreview" >
          
            
            <?php if ($review_guest) { ?>
            <div class="form-group form-new-group required">
                <div class="col-sm-12">
                    <label class="control-label form-label" for="input-name"><?php echo $entry_name; ?></label>
                    <input type="text" name="name" value="<?php echo $customer_name; ?>" id="input-name" class="form-control" />
                </div>
            </div>
            
            <div class="form-group form-new-group required">
                <div class="col-sm-12">
                    <label class="control-label form-label label-mark"><?php echo $entry_rating; ?></label>
                    <div>
                        <label for="rating-1" class="">
                            <input type="radio" name="rating" id="rating-1" class="ragio-old" class="ragio-old" value="1" />
                            <span class="fa fa-stack radio-star"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                        </label>
                        <label for="rating-2">
                            <input type="radio" name="rating" id="rating-2" class="ragio-old" value="2" />
                            <span class="fa fa-stack radio-star"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                        </label>
                        <label for="rating-3">
                            <input type="radio" name="rating" id="rating-3" class="ragio-old" value="3" />
                            <span class="fa fa-stack radio-star"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                        </label>
                        <label for="rating-4">
                            <input type="radio" name="rating" id="rating-4" class="ragio-old" value="4" />
                            <span class="fa fa-stack radio-star"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                        </label>
                        <label for="rating-5">
                            <input type="radio" name="rating" id="rating-5" class="ragio-old" value="5" />
                           <span class="fa fa-stack radio-star"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="form-group form-new-group  required">
                <div class="col-sm-12">
                    <label class="control-label form-label" for="input-email"><?php echo $entry_email; ?></label>
                   <input type="text" name="reviewemail" value="" id="input-email" class="form-control" />
                </div>
            </div>
            
             <div class="form-group form-new-group form-notify">
                 <div class="col-sm-12">
                    <div class="search-btn" data-toggle="buttons">
                        <label class="control-label form-label  btn new-check" for="input-notify"><input id="input-notify" type="checkbox" name="notify" value="1"  />
                        <span class="title-check notify-mail">
                         <?php echo $should_notify; ?></span>
                        
                        </label>
                    </div>
                 </div>
              </div>
            
            
             <div class="form-group form-new-group required">
                <div class="col-sm-12">
                    <label class="control-label form-label" for="input-phone"><?php echo $entry_phone; ?></label>
                       <input type="text" name="reviewphone" class="form-control  mask" id="myphone" placeholder="+38(___)-___-__-__" data-inputmask="'mask': '+99(999)-999-99-99'">
                </div>
            </div>
            
            <div id="last_form_div" class="form-group form-new-group required">
                <div class="col-sm-12">
                    <label class="control-label form-label" for="input-review"><?php echo $entry_review; ?></label>
                    <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
                </div>
            </div>
           
             <?php echo $captcha; ?>
               
            <!--<div class="form-group">
                <label class="col-sm-2 control-label text-left" for="input-image"><?php echo $entry_image; ?></label>
                <div class="col-sm-10">
                    <input type="file" name="reviewimage" id="input-image" class="form-control" />
                </div>
            </div> -->
           
          
            <div class="buttons clearfix review-send">
                <div class="text-center">
                    <button type="button" id="button-shopreview" class="btn btn-primary btn-review-send pull-right"><?php echo $button_send; ?></button>                </div>
            </div>
            <?php } else { ?>
                <?php echo $text_login; ?>
            <?php } ?>
        </form>
    </div>
  
<script type="text/javascript">
$(document).ready(function(){
    $('#shopreview').delegate('.pagination a', 'click', function(e) {
        e.preventDefault();

        $('#shopreview').fadeOut('slow');

        $('#shopreview').load(this.href);

        $('#shopreview').fadeIn('slow');
    });

    $('#shopreview').load('index.php?route=extension/module/shopreview/getreviews');

    $('#button-shopreview').on('click', function() {
        var shopreview_form=$("#form-shopreview").serialize();
       
	$.ajax({
		url: 'index.php?route=extension/module/shopreview/addreview',
		type: 'post',
		dataType: 'json',
		data: shopreview_form,
               
		complete: function() {
			$('#button-shopreview').button('reset');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				$('#last_form_div').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#last_form_div').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
                                $('input[name=\'reviewemail\']').val('');
                                $('input[name=\'reviewphone\']').val('');
                                
			}
		}
    });
     grecaptcha.reset();
});

});
</script>
<script type="text/javascript">
$(document).ready(function(){
   $('input:radio').click(function(){
    $(this).parents().find(".yellow").removeClass("yellow");
   if($(this).is(':checked')) 
       $(this).parent().prevAll().addClass('yellow'); 
  
 });

});

</script>
<script type="text/javascript">
 
$(document).ready(function(){
   $('input:checkbox').change(function(){
   if($(this).is(':checked')) 
       $(this).parent().addClass('violet-check'); 
  else 
      $(this).parent().removeClass('violet-check')
 });

});

</script> 
