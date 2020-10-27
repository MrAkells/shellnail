
<div class="fbcommments-custom">
  <?php if($heading_title) { ?>
    <div class="title-fbcommments-custom" id="facebook_comms"><?php echo $heading_title; ?></div>
  <?php } ?>
</div>

<div id="fb-comments_wrap" class="">
<div class="fb-comments" data-mobile="true"  data-href="http://shellnail.com.ua/" data-width="auto" data-numposts="<?php echo $comments_number; ?>" data-order-by="reverse_time"></div>
</div>

<?php if (isset($ishome)) { ?>
<div class="visible-xs visible-sm ">
    <h3 class="title-common-news title-common-news--center"><?php echo $text_shellnail; ?></h3>
     <div class="description-text"><?php echo $shop_text; ?></div>
</div>
<?php } ?>

  <script type="text/javascript">     
      

        $(document).ready(function(){
            
            new SimpleBar($('#fb-comments_wrap')[0], {
                classNames: {
                    content: 'simplebar-content',
                    scrollContent: 'simplebar-scroll-content',
                    scrollbar: 'simplebar-scrollbar',
                    track: 'simplebar-track'
               },
               timeout: 600000
            });
        });    

    </script>  
    
    <style>
        #fb-comments_wrap{
            overflow-y: auto; 
            overflow-x: auto;
            max-height: <?php echo $comments_height ?>px;
        }
    </style>


