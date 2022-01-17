    
  $(document).delegate('input[id="payment_address_city"]','focusin',function(){
	  var _that = $(this);
	  	  _that.data('ref', '');
	    $(this).parent().find('ul').remove();
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
									_that.data('ref', '');
							
						}
					});
			},
			'select': select_handler

		}).focusout(function(){            
			if(!$(this).data('ref')) $(this).val('');
		});

    });
        
         function select_handler(item) {

            if(item['value']=='another_city'){
                $('input[id="payment_address_city"]').focus();
                return false;
            }

			$('input[id="payment_address_address_1"]').val('');
			$('input[id="payment_address_city"]')
				.data('ref', item['value'])
				.val(item['label'])
				.focusout()
				.change();
	 
            $('#new_mail_office').change();
        }
        
	
//	$(document).delegate('input[id="payment_address_custom_field.address.1"]','change',function(){
//              console.log('phone changed');   
//              $.ajax({
//			url: 'index.php?route=account/precheckout/remember&phone=' +  $(this).val(),
//			dataType: 'json',
//			success: function(json) {
//                           if(json.success){
//                               console.log('phone_saved');
//                           }
//			}
//		});
//        });
        
	function preConfirm(){
	    
	    var shipping_validation=false;
	    var raw = $('.form-control-static').last().text();
	    var itogo = raw.split(' ').join('');
		    
	    if($('#ukrposhta_addon').parent().css('display')!='none'){
		if($('#ukrposhta_postcode').val()){
		    shipping_validation=true;
		}else{
		    $('#ukrposhta_postcode').addClass('input_error');
		    $('#ukrposhta_postcode').parent().find('.text_fill_field').css('display','block');
		    var go_to=$('#ukrposhta_postcode').offset().top;
		}
	    }else if($('#new_mail_addon').parent().css('display')!='none'){
		if($('#new_mail_office').val()!=0){
		    shipping_validation=true;
		}else{
		    if($('#payment_address_city').val()){
			$('#new_mail_office').addClass('input_error');
			$('#new_mail_office').parent().find('.text_fill_field').css('display','block');
			var go_to=$('#new_mail_office').offset().top;
		    }else{
			console.log('fbq_purchase');
			prepare_fbq_purchase(parseInt(itogo));
			$('#qc_confirm_order').trigger('click');
			$('#qc_confirm_order').trigger('click');
		    }

		}
	    }else if($('#courier_addon').parent().css('display')!='none'){
		if($('#new_mail_courier_address').val()){
		    shipping_validation=true;
		}else{
		     if($('#payment_address_city').val()){
			$('#new_mail_courier_address').addClass('input_error');
			$('#new_mail_courier_address').parent().find('.text_fill_field').css('display','block');
			var go_to=$('#new_mail_courier_address').offset().top;
		    }else{
			console.log('fbq_purchase');
			prepare_fbq_purchase(parseInt(itogo));
			$('#qc_confirm_order').trigger('click');
			$('#qc_confirm_order').trigger('click');
		    }
		}
	    }else if($('#inter_addon').parent().css('display')!='none'){
		if($('#inter_comment').val()){
		    shipping_validation=true;
		}else{
		    $('#inter_comment').addClass('input_error');
		    $('#inter_comment').parent().find('.text_fill_field').css('display','block');
		    var go_to=$('#inter_comment').offset().top;
		}
	    }else{
		shipping_validation=true;
	    }
	    
	    if(shipping_validation){
		console.log('fbq_purchase');
		prepare_fbq_purchase(parseInt(itogo));
		$('#qc_confirm_order').trigger('click');
		$('#qc_confirm_order').trigger('click');
	    }else{
		$('html, body').animate({ scrollTop: go_to }, 'slow');
	    }
            
	    
	    
	}
