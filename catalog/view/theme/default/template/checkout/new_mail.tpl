<div id="new_mail_addon">
    
   <?php if($is_valid_city && $offices){ ?>
        <div class="addres-new-office">
            <label><?php echo $text_office; ?></label>
            <select id='new_mail_office' class='form-control'>
                    <option value=0><?php echo $text_empty; ?></option>
                    <?php foreach($offices as $office){ ?>
                        <?php if($office['description'] == $choosen_office){ ?>
                        <option selected value="<?php echo $office['description'] ?>"><?php echo $office['description']; ?></option>
                        <?php }else{ ?>
                         <option value="<?php echo $office['description'] ?>"><?php echo $office['description']; ?></option>
                        <?php } ?>
                    <?php } ?>
            </select>
             <div class="text_fill_field text-danger" style="display: none;">
            Выберите отделение Новой Почты
        </div>
        </div>
    <?php }else{ ?> 
         <div class="addres-new-mail" style="margin-bottom: 20px;">
            <label><?php echo $text_office; ?></label>
            <input id='new_mail_office' class='form-control'>
            <div class="text_fill_field text-danger" style="display: none;">
            Выберите отделение Новой Почты
        </div>
        </div>
    <?php } ?>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $('#new_mail_office').change(function(){
            //var office=$(this).val();
            var office = $('#new_mail_office option:selected' ).text();
            $.ajax({
                url: 'index.php?route=checkout/new_mail/setoffice&office='+encodeURIComponent(office),
                type: 'POST',
                dataType: 'json',
                success: function(json) {
                    if (json.success) {
                            //$('input[name="shipping_method"]').change(); 
                    }
                }
                    // $('input[id="payment_address_address_1"]').val(office); 
                    // $('input[id="payment_address_address_1"]').change();
            });
            
    });
       
       
       $('#new_mail_office').focus(function(){
            $('#new_mail_office').removeClass('input_error');
            $('#new_mail_office').parent().find('.text_fill_field').css('display','none');
        });
       
  });      
   
</script>
