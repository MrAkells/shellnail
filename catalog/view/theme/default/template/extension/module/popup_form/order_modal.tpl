<div class="modal  fade" id="form_order" tabindex="-1" role="dialog" aria-labelledby="form_order_label">
  <div class="modal-dialog dialog-phone" role="document">
    <div class="modal-content modal-order-phone">
      <div class="modal-header">
        <button type="button" class="close close-icon" data-dismiss="modal" aria-label="Close"><span></span></button>
        <div class="modal-title" id="form_order_label"><?= $heading_title; ?></div>
      </div>
      <div class="modal-body">
          <form name="order" class="popup_form" action="<?= $action ?>" >
                <div class="form-group">
                    <label for="form_name"><?= $name; ?></label>
                    <input type="text" name="form_name" class="form-control" id="form_name">
                </div>
                       
                <div class="form-group">
                    <label for="phone"><?= $phone; ?></label>
                    <input type="text" name="phone" class="form-control  mask" id="phone" placeholder="+38(___)-___-__-__" data-inputmask="'mask': '+99(999)-999-99-99'">
                    <span style="display: none;" class="popup_form_error_phone text-danger popup_form_error">  
                        <?= $text_error_phone; ?>  
                    </span>
                </div> 
                <label class="label-timing"><?= $timing; ?></label> <div>
                  <div class="form-group time-phone">
                                     
                    <select  name="from_hour" class="form-control">
                        <option value="0">----</option>
                        <?php for($i=1; $i<=24; $i++){ ?>
                        <option value="<?php echo $i; ?>"><?php echo $i.'-00'; ?></option>
                        <?php } ?>
                    </select>
                    <?php echo $text_to; ?>
                    
                     <select  name="to_hour" class="form-control">
                         <option value="0">----</option>
                        <?php for($i=1; $i<=24; $i++){ ?>
                        <option value="<?php echo $i; ?>"><?php echo $i.'-00'; ?></option>
                        <?php } ?>
                    </select>
                     <?php echo $text_hour; ?>
                    
                </div>
              <div class="block-send">
              <a id="form_send" data-type="#form_order"  class="form_send"><?php echo $text_send_btn; ?></a></div>
              <div style="clear: both"></div>
                </div>           
                
          </form>
          <div class="popup_form_success" style="display: none;">
              <p class="text-success success_style"><?= $text_success; ?> 
         </div>
      </div>
    </div>
  </div>
</div>

