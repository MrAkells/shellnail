    <div id="order" class="modal fade">
	<div class="modal-dialog">
            <div class="modal-content modal-order-phone">
		<form id="order-form" action="send-order.php" role="form">
                    <fieldset>
                        
                    
                        
			<div class="modal-header">
                            <button class="close close-icon" type="button" data-dismiss="modal"><span></span></button>

                            <h2 class="modal-title">Заказ</h2>
			</div>
			<div class="modal-body">
			<?php if ($buyoneclick_img_status) { ?>
                            <div id="additional_field" class="col-xs-12">
				<div class="thumbnail">
                                    <img src="" class="img-responsive" />
				</div>
				<div class="price text-center">
                                    <h3></h3>
				</div>
                            </div>
                            <div class="col-xs-12">
                            <?php } else if ($buyoneclick_additional_field_required) { ?>
				<div id="additional_field" class="col-sm-5">
                                    <?php echo $buyoneclick_additional_field; ?>
				</div>
				<div class="col-xs-12">
                            <?php } else { ?>
				<div class="col-sm-12">
                            <?php } ?>
                            <div style="display:none">
				<input id="order_admin_email" type="text" name="admin_email" value="<?php echo $buyoneclick_admin_email; ?>">
                            </div>
                            <div style="display:none">
				<input id="order_product" type="text" name="product">
                            </div>
                <div class="form-group">
                            <?php if ($buyoneclick_field1_status) { ?>
				<!--<div class="input-group<?php if ($buyoneclick_field1_required) { echo ' has-warning';} ?> ">-->
                                    <input id="order_popup_name" class="form-control<?php if ($buyoneclick_field1_required) { echo ' required';} ?>" type="text" name="name" placeholder="<?php echo $buyoneclick_field1_title; ?>">
				<!--</div>-->
                                
                            <?php } ?>
                            <?php if ($buyoneclick_field2_status) { ?>
                            <!--<div class="input-group<?php if ($buyoneclick_field2_required) { echo ' has-warning';} ?>">
                            <div class="form-group">-->
                            <input id="order_popup_phone" class="form-control mask<?php if ($buyoneclick_field2_required) { echo ' required';} ?>" type="tel" name="clickphone" placeholder="+38(___)-___-__-__" data-inputmask="'mask': '+99(999)-999-99-99'">
                            <div style="clear: both"></div>
                </div>  
                            </div>
                            <br />
                            <?php } ?>
                            <?php if ($buyoneclick_field3_status) { ?>
                            <div class="input-group<?php if ($buyoneclick_field3_required) { echo ' has-warning';} ?>">
				<span class="input-group-addon"><i class="fa fa-fw fa-envelope" aria-hidden="true"></i></span>
				<input id="order_popup_email" class="form-control<?php if ($buyoneclick_field3_required) { echo ' required';} ?>" type="email" name="email" placeholder="<?php echo $buyoneclick_field3_title; ?>">
                            </div>
                            <br />
                            <?php } ?>
                            <?php if ($buyoneclick_field4_status) { ?>
                            <div class="form-group<?php if ($buyoneclick_field4_required) { echo ' has-warning';} ?>">
				<textarea id="order_popup_message" class="form-control<?php if ($buyoneclick_field4_required) { echo ' required';} ?>" name="message" rows="3" placeholder="<?php echo $buyoneclick_field4_title; ?>" ></textarea>
                            </div>
                            <?php } ?>
                               
                <input class="hidden" id="hidden_product_id" name="product_id" value="">
                <input class="hidden" id="hidden_type_of_message" name="message_type" value="">
                            
                                    
		</div>
		<div class="clearfix"></div>
        <div class="col-xs-12 jacket-send">
            <button id="send_buy_one" type="submit" class="form_send"><?php echo $buyoneclick_button_order; ?></button>
                    </div>

		</div>
		</fieldset>

		</form>
            </div>
	</div>
    </div>
    <div id="success" class="modal fade">
	<div class="modal-dialog">
            <div class="modal-content">
		<div class="modal-body">
                    <div class="text-center"><?php echo $buyoneclick_success_field; ?></div>
		</div>
            </div>
	</div>
    </div>
        
        
        
        <div id="preoder" class="modal fade">
	<div class="modal-dialog">
            <div class="modal-content">
                <div id="let_me_know">
                        <button class="close close-icon" type="button" data-dismiss="modal"><span></span></button>
                        <h3 class="enter-information">Введите данные о заказе</h3>
                        <div class="form-group">
                            <label class="control-label" for="let_me_know_name">Ваше ФИО</label>
                            <input id="let_me_know_name" class="form-control" type="text" placeholder="">
                        </div>
                        <div class="form-group">
                               <label class="control-label" for="let_me_know_phone">Ваш телефон</label>
                            <input id="let_me_know_phone"  class="form-control mask" type="tel"  placeholder="+38(___)-___-__-__" data-inputmask="'mask': '+38(999)-999-99-99'">  
                        </div>  
                        <div class="btns-notify-availability">
                            <button class="btn-primary" style="visibility: hidden">
                                <span class="let_me_btn" data-msg="call">Жду звонка</span>
                            </button>
                            <button class="btn-primary">
                                <span class="let_me_btn" data-msg="sms">Жду SMS</span>
                            </button>
                            <button class="btn-primary hidden-xxs">
                                <span  data-dismiss="modal">Закрыть</span>
                            </button>
                        </div> 
                    </div>
            </div>
        </div>
        </div>
        
         <div id="preoder_success" class="modal fade">
	<div class="modal-dialog">
            <div class="modal-content">
		<div class="modal-body">
                    <div class="text-center">Спавибо за заявку. Мы сообщим Вам когда товар появится на складе</div>
		</div>
            </div>
	</div>
    </div>
        
                 

    <script>
	$(document).ready(function() {
            $("button.order").click(function(){
                var product_name = $(this).attr('data-product');
                var product_url = $(this).attr('data-product_url');
                var product_id = $(this).attr('data-product_id');
                $("#hidden_product_id").val(product_id);

                <?php if ($buyoneclick_img_status) { ?> 
                    var product_img = $(this).attr('data-product_img'); 
                    var product_price = $(this).attr('data-product_price'); 
                <?php } ?>
                $("#order").find("h2.modal-title").text(product_name);
                <?php if ($buyoneclick_img_status) { ?> 
                    $("#order").find(".modal-body .thumbnail img").attr('src', product_img); 
                    $("#order").find(".modal-body .price h3").text(product_price); 
                <?php } ?>
                $("#order").find('input[name="product"]').val("<a href='" + product_url + "'>" + product_name + "</a>");
            console.log(product_name);
            });
	});
    </script>
				
    
    <style>
        .input_error{
            border: 1px solid #a94442 !important;
        }
    </style>
    
    <script>
            $(document).ready(function() {
                $(".let_me_btn").click(function(){
                    var name=$("#let_me_know_name").val();
                    var phone=$("#let_me_know_phone").val();
                    var msg_type=$(this).data('msg');
                    $("#order").find("#order_popup_phone").val(phone);
                    $("#order").find("#order_popup_name").val(name);
                    $("#hidden_type_of_message").val(msg_type);
                   
                    var numbers=phone.replace(/[^0-9]/g,"").length;
                    if(numbers<12){
                        $("#let_me_know_phone").parent().addClass("has-error");
                        $("#let_me_know_phone").addClass("input_error");
                    }else{
                        $("#let_me_know_phone").parent().removeClass("has-error");
                        $(this).removeClass("input_error");
                        $("#order-form").submit();
                    }
                });
                                
               
                                
                                
            });
        </script>