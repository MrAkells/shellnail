    <div class="hidden-xs hidden-sm category-module">
        <ul class="multi-level menu-items" role="menu">
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
                    <ul class="dropdown-menu js_drop_height" style="min-width: <?php echo $category['cols']*262; ?>px">  
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
    <div class="site-overlay"></div> 
   
    <script type="text/javascript">
    $(document).ready(function(){
    
        function leftHeight(){
            var m = $(".category-dropdown").outerHeight();
            if(!m){
                m= $(".category-module").outerHeight();
            }
            $(".js_drop_height").css('min-height', m);
        }
       
        leftHeight();
       
      
     
        $(".dropdown-submenu").mouseover(function(){
            leftHeight();
            $("body").addClass('pushy-active');
            
        });
        $(".menu-items").mouseout(function(){
            $("body").removeClass('pushy-active');
        });
   
        $('.js_drop_height').mouseenter(function(){
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
        
        $('.js_drop_height').mouseleave(function(){
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