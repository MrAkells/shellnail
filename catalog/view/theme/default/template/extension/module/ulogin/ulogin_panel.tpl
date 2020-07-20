<div class="ulogin_panel">
    
    <!--<div class="title-ulogin login-soc"><?php echo $heading_title; ?></div> -->

    <div>
        <div class='btn btn-soc btn-vk' id='activate_google'>
            <i class="fa fa-google"></i>
        </div>
        <div class='btn btn-soc btn-vk' id='activate_vk'>
            <i class="fa fa-vk"></i>
        </div>
        <div class='btn btn-soc btn-facebook'  id='activate_fb'>
            <i class="fa fa-facebook-f"></i>
        </div>
        <div class='btn btn-soc btn-ok' id='activate_odnoklas'>
            <i class="fa fa-odnoklassniki"></i>
        </div>
    </div>

    <?php echo $ulogin_form; ?>
</div>

<script type="text/javascript">
    
    function is_touch_device(){
        if ("ontouchstart" in document.documentElement){
            return 1;
        }
        return 0;
    }
    
    function createSpinner(){
        $('body').prepend("<div style='position: fixed; z-index: 9999; width: 200px; height: 200px' class='uloginloader hidden'><img class='image' src='image/payment/spin.gif' style='width: 100%;'/></div>");
        var loader = $('.uloginloader');

        var top=(window.innerHeight-loader.height())/2;
        var left=(window.innerWidth-loader.width())/2;
     
        loader.css('top', top+'px');
        loader.css('left', left+'px');
    }
    
    function start_ulogin_load(){
            $('.uloginloader').removeClass('hidden');
        }
        
    function stop_ulogin_load(){
        var loader = $('.uloginloader');
        loader.fadeOut(700);
    }
    
    $(document).ready(function(){
 
        $(document).delegate("#activate_vk",'click', function(){
            createSpinner();
            if(is_touch_device()){
                 uLogin.startAuth('vkontakte', "", 0); 
            }else{
                 $(".ulogin-button-vkontakte").trigger('click');
            }
        });
        
        $(document).delegate("#activate_fb",'click', function(){
            createSpinner();
            if(is_touch_device()){
                uLogin.startAuth('facebook', "", 0);
            }else{
                $(".ulogin-button-facebook").trigger('click');
            }
        });
        
        $(document).delegate("#activate_odnoklas",'click', function(){
            createSpinner();
            if(is_touch_device()){
                uLogin.startAuth('odnoklassniki', "", 0); 
            }else{
                 $(".ulogin-button-odnoklassniki").trigger('click');
            }
        });

           $(document).delegate("#activate_google",'click', function(){
            createSpinner();
            if(is_touch_device()){
                 uLogin.startAuth('google', "", 0); 
            }else{
                 $(".ulogin-button-google").trigger('click');
            }
        });
            
    });
</script>

