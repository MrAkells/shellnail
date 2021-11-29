<div id="ukrposhta_addon" style="margin-top: 0px; margin-bottom: 0px;">
    <div>
        <label><?php echo $text_postcode; ?></label>
        <input id='ukrposhta_postcode' class='form-control' value="<?php echo $postcode; ?>" oninput="$(this).change();">
        <div class="text_fill_field text-danger text-center" style="display: none;">
            <?php echo $text_input_postcode; ?>
        </div>
    </div> 
</div>

<script type="text/javascript">
    $(document).ready(function(){
       
        $('#ukrposhta_postcode').change(function(){
            var postcode=$('#ukrposhta_postcode').val();
            
            $.ajax({
            url: 'index.php?route=checkout/ukrposhta/setPostcode&postcode='+encodeURIComponent(postcode),
            type: 'POST',
            dataType: 'json',
            success: function(json) {
		if (json.success) {
                   // $('input[id="payment_address_address_1"]').change(); 
		}
            }
           
	});
  
        });
        
        $('#ukrposhta_postcode').focus(function(){
            $('#ukrposhta_postcode').removeClass('input_error');
            $('#ukrposhta_postcode').parent().find('.text_fill_field').css('display','none');
        });
        
    });
</script>
