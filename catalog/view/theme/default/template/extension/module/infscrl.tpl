<?php if(isset($ajaxurl) && $ajaxurl){ ?>
    <script>
        function create_loader(){
            $('body').prepend("<div style='position: fixed; z-index: 9999; width: 240px; height: 240px' class='uloginloader hidden'><img class='image' src='../image/payment/spin.gif' style='width: 100%;'/></div>");
            var loader = $('.uloginloader');

            var top=(window.innerHeight-loader.height())/2;
            var left=(window.innerWidth-loader.width())/2;

            loader.css('top', top+'px');
            loader.css('left', left+'px');
        }
    
        function start_loader(){
            var loader = $('.uloginloader');
            loader.removeClass('hidden');
        }
        
        function stop_loader(){
            var loader = $('.uloginloader');
            loader.addClass('hidden');
        }
       
    </script>
    <script language="javascript">
        $(document).ready(function(){ 
            create_loader();
            $('.js_infscrl').parent().addClass("infscrlintro"); 
            $('#content').append('<input type="hidden" name="pagenext" id="pagenext" value="<?php echo $page+1; ?>" />'); 
        
            var pagenext = parseInt($('#pagenext').val());  
            if(pagenext>$('#quantity_of_page').val()){
                $('#pre_pagination').hide();
            }
	//$('#content').append('<div class="row"> <div id="infscrl_loader" style="text-align:center"><img src="<?php echo $infscrl_loader_img;?>" /></div> </div>'); 
        });

        var $window = $(window);
        var $document = $(document);

        function NextProducts(e) {
                
            var pagenext = parseInt($('#pagenext').val());
            
            <?php if($is_search){ ?>
                var pre_url='<?php echo htmlspecialchars_decode($ajaxurl);?>&page=';
            <?php }else{ ?>
                var pre_url='<?php echo htmlspecialchars_decode($ajaxurl);?>?page=';
            <?php } ?>
        
            start_loader();
            $.ajax({
		url: '<?php echo htmlspecialchars_decode($ajaxurl);?>&page='+pagenext,
		dataType: 'html',
		beforeSend: function() {
                    
                    var pagenext = parseInt($('#pagenext').val());
                    $('#pagenext').val(pagenext+1);
                    if(pagenext+1>$('#quantity_of_page').val()){
                       $('#pre_pagination').hide();
                    }
                  var stateObj = { page: pagenext, url: pre_url+''+pagenext };
                   history.pushState(stateObj, "page "+pagenext, pre_url+pagenext);
                    
                  
		}, 
		success: function(html) {
                    var div = $('.js_infscrl', $(html));
                    var page_row = $('#pagination_row', $(html));
                    $('#pagination_row').html(page_row.html());
                    $('.infscrlintro').html(div);
            
                    
                    var cols = $('#column-right, #column-left').length;
                    if (cols == 2) {
			$('#content .product-list').attr('class', 'product-layout product-grid col-lg-6 col-md-6 col-sm-12 col-xs-12 grid-product js_infscrl');
                    } else if (cols == 1) {
			$('#content .product-list').attr('class', 'product-layout product-grid col-lg-3 col-md-4 col-sm-4 col-xs-6 grid-product js_infscrl');
                    } else {
			$('#content .product-list').attr('class', 'product-layout product-grid col-lg-3 col-md-4 col-sm-4 col-xs-6 grid-product js_infscrl');
                    }
                    
                    stop_loader();        
                    var pagetop=$('.sorting-tools').offset().top;
                    $('html, body').animate({scrollTop: pagetop },1500);
                }
            });
        }
               
            function handlePop(e){
                e.preventDefault();
                history.back();
                //console.log('onPop');
            }
    
        
             window.onpopstate = handlePop;
          
</script>


<?php } ?>