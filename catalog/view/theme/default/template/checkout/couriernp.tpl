<div id="courier_addon">
    <div class="courier-shipping" style="margin-bottom: 20px;">
        <label><?php echo $text_address; ?></label>
        <input id='new_mail_courier_address' class='form-control' value="<?php echo $address; ?>" oninput="$(this).change();">
         <div class="text_fill_field text-danger" style="display: none;">
            <?php echo $text_input_address; ?>
        </div>
    </div> 
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#new_mail_courier_address').change(function(){
            var courier_address=$('#new_mail_courier_address').val();
            
            $.ajax({
            url: 'index.php?route=checkout/couriernp/setaddress&address='+encodeURIComponent(courier_address),
            type: 'POST',
            dataType: 'json',
            success: function(json) {
		if (json.success) {
                   //$('input[id="payment_address_address_1"]').change(); 
		}
            }
           
	});
            
    });
    
    
       $('#new_mail_courier_address').focus(function(){
            $('#new_mail_courier_address').removeClass('input_error');
            $('#new_mail_courier_address').parent().find('.text_fill_field').css('display','none');
        });
    
    });
</script>
