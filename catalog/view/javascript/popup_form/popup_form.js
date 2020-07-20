jQuery('document').ready(function () 
{ 
    //$("#phone").mask("+38(999)999-99-99");
   
    $('.mask').inputmask();
    
    
    $('#form_send').on('click', function () 
    { 
        var type = $(this).data('type');
        var form = $(type).find('form');
        var data_list = form.find('input, select, textarea');
        console.log(this);
        var action = form.attr('action');
        var temp = form.attr('name');
        console.log(action);
        var obj = {temp:temp};
        data_list.each(function () {
            var k = $(this).attr('name');
            var v = $(this).val();
            obj[k] = v;
        });
       
        $.ajax({
            url: action,
            type: 'post',
            data: JSON.stringify(obj),
            contentType: 'JSON',
            dataType: 'JSON',
            success: function (answer)
            {
                form.find('.popup_form_error').hide();
                
                if (answer.success) {
                    $('.popup_form_success').show();
                    setTimeout(function () {
                        data_list.each(function () {
                            $(this).val('');
                        });
                        $('.popup_form_success').hide();
                        $('.close').click();
                    }, 3000);
                    
                    
                }
                else{                        
                    for(var i in  answer.error_test )
                    {
                        if (!answer.error_test.phone) {
                            form.find('.popup_form_error_phone').show();                     
                        }

                        if (!answer.error_test.email) {
                            form.find('.popup_form_error_email').show(); 
                        }                            
                    }
                }

            }
        });

    });
});