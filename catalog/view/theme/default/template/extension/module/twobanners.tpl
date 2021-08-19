<div class="two-bannersblock">
    <div class="row banners-and-advantage">
       <div  class="col-sm-9 left-banner">
            <div id="first_banner" class="owl-carousel" style="opacity: 1;">
                <?php foreach ($first_banner as $banner) { ?>
                <div class="item">
                    <?php if ($banner['link']) { ?>
                        <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive img-banner" />
                        
                        </a>
                        
                        <div class="contents-banner">
                        <a href="<?php echo $banner['link']; ?>">
                            <div class="title-banner">
                            <?php echo $banner['title']; ?>
                            <!-- Yura start -->
                            <?php if($banner['title2']){ ?>
                            <span class="h2_second_piece">
                                <?php echo $banner['title2']; ?>
                            </span>
                            <?php } ?>
                              <!-- Yura end -->
                            </div></a>
                            <div class="more-detailed">
                                <a class="btn-more-detailed" href="<?php echo $banner['link']; ?>"><?php echo $btn_more_detailed; ?></a>
                            </div>
                            
                            </div>
                        
                    <?php } else { ?>
                        <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive img-banner" />
                         <div class="contents-banner">
                            <div class="title-banner">
                            <?php echo $banner['title']; ?>
                            <!-- Yura start -->
                            <?php if($banner['title2']){ ?>
                            <span class="h2_second_piece">
                                <?php echo $banner['title2']; ?>
                            </span>
                            <?php } ?>
                              <!-- Yura end -->
                            </div>
                            <div class="more-detailed">
                                <a class="btn-more-detailed" href="<?php echo $banner['link']; ?>"><?php echo $btn_more_detailed; ?></a>
                            </div>
                        </div>                      

                    <?php } ?>
                </div>
                
                <?php } ?>
                
                
                
            </div>
           
             <div id="carousel-custom-dots" class='owl-dots'>
                <?php foreach ($first_banner as $banner) { ?>
               <button class="owl-dot"><canvas width="20" height="20" data-percent="0"
style="border:3px solid transparent;"></canvas></button>
                <?php } ?>
           </div> 
           

           <script>
               var clock_for_loader;
               var slider_period=6000;
               
              function draw_loader(){
                    var elem = $('.owl-dot.active canvas');
                    var progress=elem.data('percent');
                    var percent= progress+2;
                    var progress=elem.data('percent', percent);
                    var canvas = elem[0];
                    var canvas_context = canvas.getContext("2d");
                    canvas_context.clearRect(0, 0, canvas.width, canvas.height);
                    canvas_context.beginPath();
                    canvas_context.lineWidth=4;
                    canvas_context.strokeStyle="#fff";
                    canvas_context.arc(10,10,8,-0.5*Math.PI, percent/50*Math.PI-0.5*Math.PI);
                    canvas_context.stroke();
                }
            </script>
           
           
<script type="text/javascript"><!--
$('#first_banner').owlCarousel({
	items: 1,
        dots: true,
        dotsContainer: '#carousel-custom-dots',
        autoplay: true,
        rewind:true,
        //autoplayHoverPause: true,
       
    autoplayTimeout: slider_period,
    center: true,
	singleItem: true,
	nav: true, 
	//navText: ['<span class="glyphicon glyphicon-menu-left" style="color: #5f2e73;"></span>', '<span class="glyphicon glyphicon-menu-right" style="color: #5f2e73;"></span>'],
        navText: ['<img src="catalog/view/theme/default/image/big_banner_left.png"/>', '<img src="catalog/view/theme/default/image/big_banner_right.png"/>'],
        onChange: visual_loading,
    responsive:{
        0:{
            nav: false, 
        },
        768:{
            nav: true, 
        }
        
    }
});

function visual_loading(){
     clearInterval(clock_for_loader);
     
     $('#first_banner').trigger('stop.owl.autoplay');
     
    var dots=$('#carousel-custom-dots button canvas');
    
    dots.each(function(){
        $(this).data('percent',0);
        var canvas = $(this)[0];
        var canvas_context = canvas.getContext("2d");
        canvas_context.clearRect(0, 0, canvas.width, canvas.height);
    });
    
   $('#first_banner').trigger('play.owl.autoplay');
    clock_for_loader=setInterval(draw_loader, slider_period/50);
    
}


--></script>
         </div>
        <div class="col-xs-12 visible-xs">
             <?php echo $mini_header_catalog; ?>
        </div>
        <div class="col-sm-3 col-xs-5 right-banner">
        <div id="second_banner owl-carousel" style="opacity: 1;" >
        <div class="item">
                    <?php if ($second_banner['link']) { ?>
                        <a href="<?php echo $second_banner['link']; ?>"><img src="<?php echo $second_banner['image']; ?>" alt="<?php echo $second_banner['title']; ?>" class="img-responsive img-banner" /></a>
                    <?php } else { ?>
                         <img src="<?php echo $second_banner['image']; ?>" alt="<?php echo $second_banner['title']; ?>" class="img-responsive img-banner" />
                    <?php } ?>
                    
        </div>
            </div>
    

    </div>
    <!--</div>
    <div class="row">-->
     <div class="col-sm-12 visible-sm">
             <?php echo $mini_header_catalog; ?>
        </div>
        <div class="col-sm-3 col-md-3 col-xs-7 advantage-1">
        <div class="advantage">
           <div class="advantage-img">
                <img src="catalog/view/theme/default/image/advantage-img-1.png" alt="Advantage image">
            </div>
            <div class="advantage-body">
                <span class="title-advantage"><?php echo $first_advantage; ?></span>
                <div class="advantage-content">
                    <?php echo $text_1_advantage; ?>
                </div>
            </div>
        </div> 
        </div>
        <div class="col-sm-3 col-md-3 col-xs-7 advantage-2">
            <div class="advantage">
                <div class="advantage-img">
                    <img src="catalog/view/theme/default/image/advantage-img-2.png" alt="Advantage image">
                </div>
                <div class="advantage-body">
                    <span class="title-advantage"><?php echo $second_advantage; ?></span>  
                    <div class="advantage-content"><?php echo $text_2_advantage; ?></div>
                </div>
            </div>
        </div>    
        <div class="col-sm-3 col-lg-2 col-xs-7 advantage-3" style=" clear: none;">
            <div class="advantage">
                <div class="advantage-img">
                    <img src="catalog/view/theme/default/image/advantage-img-3.png" alt="Advantage image">
                </div>
                <div class="advantage-body">
                    <div class="title-advantage"><?php echo $third_advantage;; ?></div>
                    <div class="advantage-content"><?php echo $text_3_advantage; ?></div>
                </div>
        </div></div>       
        <div class="col-sm-3 col-lg-4 col-xs-7 advantage-4" style=" clear: none;">
            <div class="advantage">
                <div class="advantage-img">
                    <img src="catalog/view/theme/default/image/advantage-img-4.png" alt="Advantage image">
                </div>
                <div class="advantage-body">
                    <div class="title-advantage"><?php echo $forth_advantage;; ?></div>
                    <div style="clear: left"></div>
                    <div class="advantage-content"><?php echo $text_4_advantage; ?></div>
                </div>
            </div>       
        </div>

    </div>
    <div class="row">
       
    </div> 
    
    <div class='row'>
        <?php echo $promos; ?>
    </div>
    
</div>
<script>
  
  $(".contents-banner").click(function(){
       var link=$(this).prev().attr("href");
       //$(location).attr('href',link);
       location = link;
    });
  
  
</script>
