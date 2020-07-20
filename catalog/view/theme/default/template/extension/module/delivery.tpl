<div id="delivery" class="<?php echo $hide_xs_sm?'hidden-xs hidden-sm':''; ?>">
    <img src="catalog/view/theme/default/image/mailing-bg.png" alt="Mailing" class="img-responsive hidden-xs hidden-sm">

    <div class="mailing">
        <div class="delivery-heading"  id="popover_email" data-container="body" data-toggle="popover" data-placement="bottom" data-content=""><?php echo $heading_title; ?></div>
        <form id="data-content" class="form" role="form">
            <div class="group block-wiht-input1">
                <input type="text"  type="text" name="email" placeholder="Email">
            </div>
            <div class="group block-wiht-input2">
                <input id="delivery_phone" type="text" class="mask"  name="phone" placeholder="<?php echo $your_phone; ?>" data-inputmask="'mask': '+99(999)-999-99-99'" >
            </div>
          
            <div  style="position: relative">
                <button class="button_form btn-mailing"   > 
                   <?php echo $text_send; ?>
                </button>
            </div> 
            
            <input type="text" name="isdelivery" class="hidden" value="1"/>
            
        </form>
        <img src="catalog/view/theme/default/image/elips-top.png" alt="decor-mailing" class="hidden-lg hidden-md elips-top">
         <img src="catalog/view/theme/default/image/elips-bottom.png" class="hidden-lg hidden-md elips-bottom" alt="decor-mailing">
    </div>
   
   </div>

<script>
    $('#data-content').on('submit', function() {
       
        var send = $(this).serialize();
        $.ajax({
            url: '<?php echo $action ?>',
            type: 'POST',
            data: send,
            dataType: 'text',
            success: handler
        });

        function hidePopup(){
                setTimeout(
                    function(){
                        $('#popover_email').popover('hide');
                        $('.popover').css('color','initial');
                    },
                    3000
                );
        }

        function handler(answer) {

            if (answer === 'success')
            {
                $('#popover_email')[0].dataset.content = '<?php echo $textSuccess ?>';
                $('#popover_email').popover('show');
                $('.popover').css('color','green');
                hidePopup();
                document.getElementById("data-content").reset();
            }
            else if (answer === 'notValid')
            {
                $('#popover_email')[0].dataset.content = '<?php echo $textNotValid ?>';
                $('#popover_email').popover('show');
                hidePopup();
                
            }
            else if (answer === 'issetEmail')
            {
                $('#popover_email')[0].dataset.content = '<?php echo $textRegisterEmail ?>';
                $('#popover_email').popover('show');
                 
                hidePopup();
               
            }
            else
            {
                $('#popover_email')[0].dataset.content = '<?php echo $textErrorEmeil ?>';
                $('#popover_email').popover('show');
                hidePopup();
            }
            
        }       
         return false;
    });
    
   
    
</script>
