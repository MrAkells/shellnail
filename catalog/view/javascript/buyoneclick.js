$(document).ready(function() {
	$('input').focus(function(){
		$(this).parent().removeClass('has-error');
		$(this).removeClass('input_error');
		// console.log('removeClass!');
	});
    $('#order-form').submit(function(event) {
	
		event.preventDefault ? event.preventDefault() : (event.returnValue = false);
		
	if(!formValidation(event.target)){return false;}
		
		var action = $(this).attr('action');
		var sendingForm = $(this);
		var submit_btn = $(this).find('button[type=submit]');
		//var value_text = $(submit_btn).text();
		//var waiting_text = 'SENDING';
		
		var msg_type=$("#hidden_type_of_message").val();
		var prod_id=$("#hidden_product_id").val();
		
		$.ajax({
			type: "POST",
			url: action,
			data: $(event.target).serializeArray(),
			beforeSend:function(){
				$(submit_btn).prop( 'disabled', true );
				
				//$(submit_btn).addClass('waiting').text(waiting_text);
			},
			success: function(msg,status){
				// console.log(msg);
				var success = true;
				$(sendingForm).trigger('reset');
				//$(submit_btn).removeClass('waiting');
				//$(submit_btn).text(value_text);
				$(submit_btn).prop( 'disabled', false );
				if(msg_type){
				    $('#preoder').modal('hide');
				    $('#preoder_success').modal('show');
				    setTimeout(function(){
					$('#preoder_success').modal('hide');
				    }, 4000);
				    success = false;
				    $("#let_me_know_phone").val('');
				    $("#let_me_know_name").val('');
				}else{
				    $('#order').modal('hide');
				    $('#order').on('hidden.bs.modal', function (e) {
					if (success) {
						$('#success').modal('show');
						setTimeout(function(){
						$('#success').modal('hide');
						}, 4000);
						success = false;
					}
				    });
				}
				
			},
			error: function(){
				$(submit_btn).prop( 'disabled', false );
				$(submit_btn).removeClass('waiting').text("ERROR");
				setTimeout(function(){
					$(submit_btn).delay( 3000 ).text(value_text);
				}, 3000);
			}
		});
		event.preventDefault();
    });
});
function formValidation(formElem){
	var elements = $(formElem).find('.required');
	var errorCounter = 0;
	$(elements).each(function(indx,elem){
		var placeholder = $(elem).attr('placeholder');
		if($.trim($(elem).val()) == '' || $(elem).val() == placeholder){
			$(elem).parent().addClass('has-error');
			errorCounter++;
		}
		else{
			$(elem).parent().removeClass('has-error');
		}
	});
	$('input[name="clickphone"]').each(function() {
		var phone=$(this).val();
		var numbers=phone.replace(/[^0-9]/g,"").length;
		if(numbers<12 || !phone){
			console.log('NON valid phone!');
			$('input[name="clickphone"]').addClass("input_error");
			errorCounter++;
		} 
		else{
			$(this).removeClass("input_error");
		}
	});
	if (errorCounter > 0) {
		$('.fancy_form_error_text').show();
		return false;
	} else {
		$('.fancy_form_error_text').hide();
		return true;
	}
}
