
<div id="fb-comments_wrap" >
<div class="fb-comments"  data-href="http://shellnail.com.ua/" data-width="auto" data-numposts="<?php echo $comments_number; ?>" data-order-by="reverse_time"></div>
</div>


    <script type="text/javascript">     
       

        $(document).ready(function(){
            new SimpleBar($('#fb-comments_wrap')[0], {
                classNames: {
                    content: 'simplebar-content',
                    scrollContent: 'simplebar-scroll-content',
                    scrollbar: 'simplebar-scrollbar_nothing',
                    track: 'simplebar-track'
                }
            });
        });

        $(document).ready(adjust_fb_coments);
        $(window).resize(adjust_fb_coments);

        function adjust_fb_coments(){
            var width=$('#tab-content').width();
            
            var interval=setInterval(function(){
                if($('.vidgit-fb .fb_iframe_widget').attr('fb-xfbml-state')=='rendered'){
                    clearInterval(interval);
                    $('.vidgit-fb .fb_iframe_widget').find('iframe').css('width',width+'px');
                }
            }, 200);
        }

       

    </script>
    
    <style>
        #fb-comments_wrap{
            overflow-y: auto; 
            overflow-x: hidden;
          
        }
    </style>


