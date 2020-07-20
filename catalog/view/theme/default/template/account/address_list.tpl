<div class="col-md-3 col-sm-4">
    <div id="address_list_block">
<?php if ($success) { ?>
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>

    <div >
      <?php if ($addresses) { ?>

            <?php foreach ($addresses as $result) { ?>
            <div class="radio-input radio deception">
                <label for="radio-<?php echo $result['address_id']; ?>">
                    <input type="radio" name="shipping_method" value="new_mail.new_mail" id="radio-<?php echo $result['address_id']; ?>" checked="checked" data-refresh="5" class="styled address-old-radio">
                    <span class="user_addresses">
                        <span class="radio-address"></span>
                        <span class="text-address"><?php echo $result['contact']; ?></span>
                        <button class="address_editor btn-transparent" data-address_id="<?php echo $result['address_id']; ?>" data-firstname="<?php echo $result['firstname']; ?>" data-lastname="<?php echo $result['lastname']; ?>" data-phone="<?php echo $result['phone']; ?>" data-city="<?php echo $result['city']; ?>" data-street="<?php echo $result['street']; ?>" data-house="<?php echo $result['house']; ?>" data-flat="<?php echo $result['flat']; ?>" data-postcode="<?php echo $result['postcode']; ?>" data-href="<?php echo $result['href']; ?>"><?php echo $text_edit_addr; ?></button>
                    </span>
                </label>
            </div>
                
               
                <br/>
            <?php } ?>
  
        <?php } else { ?>
            <p><?php echo $text_empty; ?></p>
        <?php } ?>
    
      </div>
    </div>
</div>


<script type="text/javascript"><!--
    $(document).delegate('.address_editor', 'click', function() {

        var url=$(this).data('href');

	$.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            success: function(json) {
                console.log(json);
		if (json.success) {
                    var markup=$('#address_block', json.form);
                    $('#address_block').html(markup.html());
		}
            },
            error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
	});
        
        
        
        $('#new_address').removeClass('hidden');
        $('.user_addresses').removeClass('active');
        $(this).parent().addClass('active');
    });
 
    $(document).delegate('#new_address', 'click', function() {
     
     
       var url=$(this).data('href');

	$.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            success: function(json) {
                console.log(json);
		if (json.success) {
                    var markup=$('#address_block', json.form);
                    $('#address_block').html(markup.html());
		}
            },
            error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
	});
      $('.user_addresses').removeClass('active');
     
        $('#edit_or_create').html('<?php echo $create_user_address; ?>');
       $(this).addClass('hidden');
        
    });
    
   
//--></script>

