  <?php 
    $static_header_is_on=false;
    if($static_header_is_on)
        { ?>
    <div id="dropdown_category_menu2">
        <div class="dropdown">
            <button id="dLabel" role="button" data-toggle="dropdown">
                    <div class="burger">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </div>
                        <span class="title-menu"><?php echo $heading_title; ?></span>
            </button>
            <ul class="dropdown-menu multi-level menu-items category-dropdown2" role="menu" aria-labelledby="dropdownMenu">
                <?php foreach ($categories as $category) { ?> 
                    
                    <?php if(!$category['children']){ ?>
                    <li class="dropdown-submenu">
                    <a class="category-items main_category_block" href="<?php echo $category['href'] ?>">
                        <?php if($category['icon']){ ?>
                        <img class="icon-category icon_first" src="<?php echo $category['icon']; ?>"/>
                        <?php } ?>
                        <?php if($category['icon2']){ ?>
                        <img class="icon-category icon_second hidden" src="<?php echo $category['icon2']; ?>"/>
                        <?php } ?>
                        <span class="name-items"><?php echo $category['name']; ?></span>
                         <span class="arrow-category"></span>
                    </a>
                </li>
                            <?php }else{ ?>
                     <li class="dropdown-submenu">
                         <a  href="<?php echo $category['href'] ?>" class="category-items main_category_block">
                    <?php if($category['icon']){ ?>
                    <img class="icon-category icon_first" src="<?php echo $category['icon']; ?>"/>
                    <?php } ?>
                    <?php if($category['icon2']){ ?>
                        <img class="icon-category icon_second hidden" src="<?php echo $category['icon2']; ?>"/>
                    <?php } ?>
                    <span class="name-items">
                        <?php echo $category['name'] ?>
                    </span>
                    <span class="arrow-category"></span>
                    </a>
                          <ul class="dropdown-menu js_static_drop_height" style="min-width: <?php echo $category['cols']*262; ?>px">  
                            
                           <?php $i=0; ?> 
                        <?php foreach($category['children'] as $child){ ?>

                        
                           <?php if($i>=$category['number_of_categories']){ ?>
                                    <?php $i=0; ?>
                                    </div>  
                                    <?php } ?>
                                    
                                <?php if($i==0){ ?>
                                    <div class="menu_column">
                                <?php } ?>
                        

                            <?php if($child['level3']){ ?>
                            <p class="with-descendant"><a class="category-items"  href="<?php echo $child['href'] ?>"><?php echo $child['name'];  $i++; ?></a></p>
                            <div class="menu_level_3 ">    
                                <?php foreach($child['level3'] as $grandchild){ ?>
                                <p class="indention-item"><a class="link_level_3" href="<?php echo $grandchild['href'] ?>"><?php echo $grandchild['name'];  $i++; ?></a></p>
                                <?php } ?>
                            </div>

                            <?php } else{ ?>
                            <p class="without-descendant"><a class="category-items"  href="<?php echo $child['href'] ?>"><?php echo $child['name'];  $i++; ?></a></p>
                            <?php } ?>




                        <?php } ?> 
                            
                        </ul>
                    </li>
                    <?php } ?>
                    
                <?php } ?>

            </ul>
        </div>
    </div>
    <div class="site-overlay"></div> 
<script type="text/javascript">
    $(document).ready(function(){
    
        var m = $(".category-dropdown").outerHeight();
        if(!m){
            m= $(".category-module").outerHeight();
        }
        console.log('no_ind'+m);
        $(".js_static_drop_height").css('min-height', m);
       
    
        $(".dropdown-submenu").mouseover(function(){
            $("body").addClass('pushy-active');
        });
        $(".menu-items").mouseout(function(){
            $("body").removeClass('pushy-active');
        });
   
        $('.js_static_drop_height').mouseenter(function(){
            var elem=$(this).parent();
            var a=elem.children('a');
            a.addClass('right_dropdown_hovered');
            a.find('.arrow-category').addClass('arrow_howered');
            var first_icon=a.children('.icon_first');
            var second_icon=a.children('.icon_second');
            if(first_icon[0] && second_icon[0]){
                first_icon.addClass('hidden');
                second_icon.removeClass('hidden');
            }
        });
        
        $('.js_static_drop_height').mouseleave(function(){
            var elem=$(this).parent();
            var a=elem.children('a');
            //a.removeClass('right_dropdown_hovered');
            
        });
   
        $('.dropdown-submenu').mouseenter(function(){
            var a=$(this).children('a');
            a.addClass('right_dropdown_hovered');
            a.find('.arrow-category').addClass('arrow_howered');
            var first_icon=$(this).find('a').children('.icon_first');
            var second_icon=$(this).find('a').children('.icon_second');
            if(first_icon[0] && second_icon[0]){
                first_icon.addClass('hidden');
                second_icon.removeClass('hidden');
            }
        });
        
        
        $('.dropdown-submenu').mouseleave(function(){
            var a=$(this).children('a');
            a.removeClass('right_dropdown_hovered');
            a.find('.arrow-category').removeClass('arrow_howered');
            var first_icon=$(this).find('a').children('.icon_first');
            var second_icon=$(this).find('a').children('.icon_second');
            if(first_icon[0] && second_icon[0]){
                first_icon.removeClass('hidden');
                second_icon.addClass('hidden');
            }
        });

   
    });
    </script>
    

    <style>
        
        .affix {
            position: fixed !important;
        }
        
        .static_category_menu_responsive{
            width: 24% !important;
        }
        
        .static_logo_feature #logo img{
            margin-left: 12px !important;
        }
        
        .static_category_menu_responsive{
            border-right: none !important;
        }
        
        .static_logo_feature{
             width: 20% !important;   
        }
        
        .static_phone_numbers{
            width: 12% !important;
        }
        
        .static_call_back{
            width: 6% !important;
        }
        
        .static_compare_link{
            padding-top: 10px !important;
        }  
        
        .static_buying{
            bottom: 7px !important;
        }   
         
        .static_header_row{
            padding-top: 20px;
        }  
        
        @media (min-width: 992px) and (max-width: 1199px) {
            .static_schedule{
                display: none;
            }
            .static_category_menu_responsive{
                width: 25% !important;
                
            }
            .static_logo_feature{
                width: 20% !important;
                 
            }
            .static_phone_numbers{
                width: 16% !important;
                
            }
            .static_phone_numbers div{
                margin-left: 5px !important;
            }
            
            .static_call_back{
                margin-left: 21px;
                width: 7% !important;
                
            }
            
        }
    </style>
    <script>
    $(document).ready(function(){
        var height=600;
        // height+=$("#top").height();
        // height+=$("header").height();
        if ($(window).width() > 992){
            $("header").affix({offset: {top: height} });
        }
    });
      
    $("header").on('affix.bs.affix', function(){
        $(this).addClass('header_affixed');
        $("#static_category_menu").removeClass("hidden-sm");
        $("#static_category_menu").removeClass("hidden-md");
        $("#static_category_menu").removeClass("hidden-lg");
        $("#shop_feature").hide(); 
        
        $('.btn_back_call span').hide();
        $('.btn_back_call span.buying').show();
        $('.btn_back_call span.buying').removeClass('hidden');
        
        $('#call_me_back').addClass('static_call_back');
        $('.logo-feature').addClass('static_logo_feature');
        $('#static_category_menu').addClass('static_category_menu_responsive');
        $('#phone_numbers').addClass('static_phone_numbers');
        $("#schedule").addClass("static_schedule");
        
        $("#compare_link").addClass("static_compare_link");
        $("#wishlist_link .buying, #compare_link .buying, #cart .buying").addClass
("static_buying");
        $('header .row').addClass('static_header_row');
    });
    
    $("header").on('affix-top.bs.affix', function(){
        $(this).removeClass('header_affixed');
        $("#static_category_menu").addClass("hidden-sm");
        $("#static_category_menu").addClass("hidden-md");
        $("#static_category_menu").addClass("hidden-lg");
        $("#shop_feature").show(); 
        
        $('.btn_back_call span').show();
        $('.btn_back_call span.buying').hide();
        $('.btn_back_call span.buying').addClass('hidden');
        
        $('#call_me_back').removeClass('static_call_back');
        $('.logo-feature').removeClass('static_logo_feature');
        $('#static_category_menu').removeClass('static_category_menu_responsive');
        $('#phone_numbers').removeClass('static_phone_numbers');
        $("#schedule").removeClass("static_schedule");
        
        $("#compare_link").removeClass("static_compare_link");
        $("#wishlist_link .buying, #compare_link .buying, #cart .buying").removeClass
("static_buying");
        $('header .row').removeClass('static_header_row');
    });

    </script>
   
   <?php } ?>
    
  