<?php echo $header; ?>
<div class="container">

  <div class="row">
      
    <div id="content" class="col-xs-12 col-sm-12 col-md-9 col-md-push-3">
        <?php echo $content_top; ?>
      <ul class="breadcrumbs list-inline" itemscope itemtype="http://schema.org/BreadcrumbList">
           <?php $i=0; ?>
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
         <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" class="crumb" href="<?php echo $breadcrumb['href']; ?>"><span itemprop="name"><?php echo $breadcrumb['text']; ?></span></a>
        <meta itemprop="position" content="<?php echo $i++; ?>">
        </li>
        <?php } ?>
      </ul>
    <div class="hidden-md hidden-lg mini-catalog-сategory">
        <?php echo $mini_catalog; ?>
    </div> 
        <h1 itemprop="name"><?php echo $heading_title; ?></h1>
        
        <script type="text/javascript"> 
$(document).ready(function(){
    
(function ($) {
	var defaluts = {
		day: 0,			
		dayDom: '',			
		hour: 0,			
		hourDom: '',		
		minute: 1,			
		minuteDom: '',		
		second: 0,			
		secondDom: '',		
		millisecond: 0,		
		millisecondDom: '',	
		blank: 1000, 		
		pause: '',			
		pauseFun: '',		
		goonFun: '',	
		endFun: '',		
		animation: 'none' 	
	};

	$.fn.extend({
		stamp: 0,				
		intervalObj: {},		
		state: 1,				
		simpletimer: function (options) {
			var _self = this;
			var options = $.extend({}, defaluts, options);

			_self.stamp = parseInt(options.millisecond) + 
						  10 * parseInt(options.second) + 
						  600 * parseInt(options.minute) + 
						  36000 * parseInt(options.hour) +
						  864000 * parseInt(options.day);
			this._dida(options);
			this._pause(options);
		},
		_pause: function (options) {
			var _self = this;

			$(options.pause).on('click', function () {
				console.log(2);
				if (_self.state === 1) {
					_self.state = 0;
					clearInterval(_self.intervalObj);
					$(this).html('Resume');
					options.pauseFun();
				} else {
					_self.state = 1;
					_self._dida(options);
					options.goonFun();
				}
			});
		},
		_dida: function (options) {
			var _self = this;
			_self.intervalObj = setInterval(function () {
				var temp = _self.stamp;
				var day = Math.floor(temp / 864000);
				temp = temp % 864000;
				var hour = Math.floor(temp / 36000);
				temp = temp % 36000;
				var minute = Math.floor(temp / 600);
				temp = temp % 600;
				var second = Math.floor(temp / 10);
				var millisecond = temp % 10; 
				$(options.dayDom).html(_self.prefixInteger(day, 2));
				$(options.hourDom).html(_self.prefixInteger(hour, 2));
				$(options.minuteDom).html(_self.prefixInteger(minute, 2));
				$(options.secondDom).html(_self.prefixInteger(second, 2));
				$(options.millisecondDom).html(_self.prefixInteger(millisecond, 1));
				_self.stamp = _self.stamp - (options.blank/100).toFixed(0);
				if (_self.stamp < 0) {
					_self.state = 0;
					clearInterval(_self.intervalObj);
					options.endFun();
				}
			}, parseInt(options.blank));
		},
		prefixInteger: function(num, length) {  
			return ( "0000" + num ).substr( -length );  
		}
	});
	
})(jQuery);
 
}); 
</script>

        <div class="page-promotipns">
            <?php foreach($promotions as $promo){ ?>
            <div class="one_promo">
            	<div class="promo-img">
            		     		
            	
            	<div class="promo-content">
            		<p class="title-stoke">
                	<?php echo $promo['title']; ?>
            	</p>
				<p class="number-of-goods"><?php echo $text_promo_product; ?> <?php echo $promo['count']; ?></p>
				<div id="simple-timer<?php echo $promo['promo_id']; ?>" class="simple-timer">
                    <div class="casing">
                    	<span class="timer-day<?php echo $promo['promo_id']; ?> timer-digits"></span>
                    	<span class="timer-word"><?php echo $text_day; ?></span>
                    </div>
                    <label class="separator">:</label>
                   <div class="casing">
                    	<span class="timer-hour<?php echo $promo['promo_id']; ?> timer-digits"></span>
                    	<span class="timer-word"><?php echo $text_hour; ?></span>
                    </div>

                    <label class="separator">:</label>
                    <div class="casing">
                    	<span class="timer-minute<?php echo $promo['promo_id']; ?> timer-digits"></span>
                    	<span class="timer-word"><?php echo $text_minute; ?></span>
                    </div>
                    <label class="separator">:</label>
                    <div class="casing">
                    	<span class="timer-second<?php echo $promo['promo_id']; ?> timer-digits"></span>
                    	<span class="timer-word"><?php echo $text_second; ?></span>
                    </div>
                </div>
            	<p class="period-promotion">
                	Акция до <?php echo $promo['date_end']; ?>
            	</p>
            	<p class="promo-description hidden-xs">
                <?php echo $promo['description']; ?>
            	</p>
            	<div class="more-eye">
            		<div class="promo-more">
              			<a href="<?php echo $promo['href']; ?>" class="btn-promo-more">Подробнее</a>
              		</div>
              		<div class="look-over">
              			<img src="catalog/view/theme/default/image/icon-eye.png" alt="Avatar" class="img-avatar"> <?php echo $text_look_over; ?> <?php echo $promo['observers']; ?> человека
              		</div>
                </div>

                <div id="end_of_promo<?php echo $promo['promo_id']; ?>" data-seconds="<?php echo $promo['endtime']; ?>"></div>
 
            <script>  
                
                $(document).ready(function(){
                
                var d=new Date();
                var seconds_now=Math.round(d.getTime()/1000);
                var end=$('#end_of_promo<?php echo $promo['promo_id']; ?>').data('seconds');
                
                var seconds_to_end=end-seconds_now;
                var days=Math.floor(seconds_to_end/(3600*24));
                var hour=Math.floor((seconds_to_end-(days*3600*24))/3600);
                var minutes=Math.floor((seconds_to_end-(days*3600*24)-(hour*3600))/60);
                var seconds=seconds_to_end-(days*3600*24)-(hour*3600)-(minutes*60);
   
     
    $('#simple-timer<?php echo $promo['promo_id']; ?>').simpletimer({
        day: days,
        dayDom: '.timer-day<?php echo $promo['promo_id']; ?>',
        hour: hour,
        hourDom: '.timer-hour<?php echo $promo['promo_id']; ?>',
        minute: minutes,
        minuteDom: '.timer-minute<?php echo $promo['promo_id']; ?>',
        second: seconds,
        secondDom: '.timer-second<?php echo $promo['promo_id']; ?>'
    });
    
    
    });
 </script>
        </div>
        <div class="crop"><img src="<?php echo $promo['thumb']; ?>" class="image-promotions" /></div>
    </div>       	
            	
            	
            	
            </div>
            <?php } ?>
        </div>
        
        <?php echo $content_bottom; ?>
    </div>
    
    <?php echo $column_left; ?>
    
    </div>
</div>
<?php echo $footer; ?>


 
 

 