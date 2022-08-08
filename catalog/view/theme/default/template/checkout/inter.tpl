<div id="inter_addon" style="margin-top: 0px; margin-bottom: 0px;">
     <div>
        <label><?php echo $text_international; ?></label>
        <textarea id='inter_comment' class='form-control' oninput="$(this).change();"><?php echo $comment_value; ?></textarea>
        <div class="text_fill_field text-danger" style="display: none;">
            <?php echo $text_input_international; ?>
        </div>
    </div> 
</div>

<script type="text/javascript">
    $(document).ready(function(){
        
        $('#inter_comment').change(function(){
            var comment=$(this).val();
            $.ajax({
            url: 'index.php?route=checkout/inter/setComment&comment='+encodeURIComponent(comment),
            type: 'POST',
            dataType: 'json',
            success: function(json) {
		if (json.success) {
                  //$('input[id="payment_address_address_1"]').change(); 
		}
            }
           
	});
        });
            
            
            
          $('#inter_comment').focus(function(){
            $('#inter_comment').removeClass('input_error');
            $('#inter_comment').parent().find('.text_fill_field').css('display','none');
        });
    });
       
        
   
</script>
