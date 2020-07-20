<div class="col-sm-8 col-md-9 col-lg-8 col-lg-offset-1">
    <div  id="address_block" class="">
     
        <h2 id="edit_or_create" class="title-in-tab add-address">
          <?php echo (isset($address_id) && $address_id)?$edit_user_address:$create_user_address; ?>
          
      </h2>
      <form id="address_form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group register-group">
                <label class="col-sm-12  register-label form-label" for="input-firstname2"><?php echo $entry_firstname; ?></label>
                <div class="col-sm-12">
                  <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="" id="input-firstname2" class="form-control" />
              <?php if ($error_firstname) { ?>
                  <div class="text-danger"><?php echo $error_firstname; ?></div>
              <?php } ?>
                </div>
              </div>
              <div class="form-group register-group">
                <label class="col-sm-12 register-label form-label" for="input-lastname2"><?php echo $entry_lastname; ?></label>
                <div class="col-sm-12">
                  <input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="" id="input-lastname2" class="form-control" />
                  <?php if ($error_lastname) { ?>
                  <div class="text-danger"><?php echo $error_lastname; ?>   </div>
                  <?php } ?>
                </div>
              </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group register-group">
              <label class="col-sm-12 register-label form-label" for="input-phone"><?php echo $entry_phone; ?></label>
              <div class="col-sm-12">
                <input type="text" name="addr_phone" value="<?php echo $addr_phone; ?>" placeholder="+38(___)-___-__-__" id="input-phone" class="form-control" data-inputmask="'mask': '+99(999)-999-99-99'" />
                 <script type="text/javascript">
                    $('input[name=\'addr_phone\']').inputmask();
                </script>
              <?php if ($error_phone) { ?>
                <div class="text-danger"><?php echo $error_phone; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group register-group">
              <label class="col-sm-12 register-label form-label" for="input-city"><?php echo $entry_city; ?></label>
              <div class="col-sm-12">
                <input type="text" name="city" value="<?php echo $city; ?>" placeholder="" id="input-city" class="form-control" />
                <?php if ($error_city) { ?>
                <div class="text-danger"><?php echo $error_city; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group register-group">
              <label class="col-sm-12 register-label form-label" for="input-street"><?php echo $entry_street; ?></label>
              <div class="col-sm-12">
                <input type="text" name="street" value="<?php echo $street; ?>" placeholder="" id="input-street" class="form-control" />
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group register-group">
                  <label class="col-sm-12 register-label form-label" for="input-house"><?php echo $entry_house; ?></label>
                  <div class="col-sm-12">
                    <input type="text" name="house" value="<?php echo $house; ?>" placeholder="" id="input-house" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group register-group">
                  <label class="col-sm-12 register-label form-label" for="input-flat"><?php echo $entry_flat; ?></label>
                  <div class="col-sm-12">
                    <input type="text" name="flat" value="<?php echo $flat; ?>" placeholder="" id="input-flat" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group register-group">
                  <label class="col-sm-12 register-label form-label" for="input-postcode"><?php echo $entry_postcode; ?></label>
                  <div class="col-sm-12">
                    <input type="text" name="postcode" value="<?php echo $postcode; ?>" placeholder="" id="input-postcode" class="form-control" />
                  </div>
                </div> 
              </div>
                
             <?php if ($error_default) { ?>
                        <div class="text-danger"><?php echo $error_default; ?></div>
                        <?php } ?>
                        
                   <div class="col-sm-4">
                <div class="search-btn" data-toggle="buttons">
                <label class="control-label form-label  btn new-check" >
                    <input type="checkbox" name="default" value="1"  <?php echo $default?'checked':''; ?> />
                  <span class="title-check title-remember title-reg"><?php echo $text_main_address; ?></span>
                    
                </label>
                     
              </div>
                       
                   </div>
                   
                        
              <input type='text' id="hidden_addr_id" name='address_id' class='hidden' value='<?php echo $address_id; ?>'/>
            </div>
          </div>
        </div>
      </fieldset>
    </form>
        
        <script type='text/javascript'>
             $('input:checkbox').change();
        </script>
    </div>
    
    <div class="row">
      <div class="col-xs-12 col-sm-6 col-sm-offset-6">
        <div>
          <span id="new_address"  class="btn btn-danger hidden" data-href="index.php?route=account/address/add"><?php echo $button_new; ?></span>
        </div> 
      </div>
      <div class="col-xs-12 col-sm-6 col-sm-offset-6">
        <span id="send_address"  class="btn btn-primary"><?php echo $button_continue; ?></span>
      </div>
    </div>  
</div>

<script type="text/javascript"><!--
$(document).delegate('#send_address', 'click', function() {
        
        if($('#hidden_addr_id').val()){
            var url="index.php?route=account/address/edit&address_id="+$('#hidden_addr_id').val();
        }else{
            var url="index.php?route=account/address/add";
        }
       
        
	$.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: new FormData($('#address_form')[0]),
            cache: false,
            contentType: false,
            processData: false,
            success: function(json) {
		if (json.success) {
                    var markup=$('#address_block', json.form);
                    $('#address_block').html(markup.html());
                    var markup2=$('#address_list_block', json.list);
                    $('#address_list_block').html(markup2.html());
                    
		}
            },
           
	});
	$('input:checkbox').change();
});

$(document).ready(function(){
    $(document).delegate('input:checkbox','change', function(){
        if($(this).is(':checked')) 
            $(this).parent().addClass('violet-check'); 
        else 
            $(this).parent().removeClass('violet-check')
    });
    
});
//--></script>
<script type="text/javascript">
    
  
        
        function select_handler(item) {
            $('input[id="input-city"]').val(item['label']);
        }
        
        $(document).delegate('input[id="input-city"]','focusin',function(){
            $(this).autocomplete({
            'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=account/precheckout/hint&hint=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
                            if(json.success){
                                response($.map(json.data, function(item) {
					return {
						label: item['name'],
						value: item['ref']
					}
				}));
                            }
				
			}
		});
            },
            'select': select_handler
        });
        });
       
    
 
        
</script>




