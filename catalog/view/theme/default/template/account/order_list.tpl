<div>
<div id="orders_block">
    <div class="row">   
        <div class="col-sm-3">
            <div class="title-in-tab"><?php echo $text_period; ?></div>
            <ul class="orders_groups">
                <li class="order_type" data-href="<?php echo $href_all; ?>"><?php echo $text_all; ?></li>
                <li class="order_type" data-href="<?php echo $href_this_month; ?>"><?php echo $text_this_month; ?></li>
                <li class="order_type" data-href="<?php echo $href_last_month; ?>"><?php echo $text_last_month; ?></li>
                <li class="order_type" data-href="<?php echo $href_last_year; ?>"><?php echo $text_last_year; ?></li>
                <li class="order_type" data-href="<?php echo $href_this_year; ?>"><?php echo $text_this_year; ?></li>
            </ul>
        </div> 
        <div class="col-sm-9">
            <?php if ($orders) { ?>
                <h2 class="title-in-tab title-all-orders"><?php echo $text_all_your_orders; ?></h2>  
                <table id="orders_list_on_page">
                    <?php foreach ($orders as $order) { ?>
                        <tr class="one_order">
                            <td class="order-first-colum">   
                                <p class="to_order_details">
                                    <i class="fa fa-angle-up"></i>
                                    <span class="watch_one_order" data-href="<?php echo $order['view']; ?>" >№<span><?php echo '000'.$order['order_id']; ?></span>
                                    </span>
                                </p>
                                <div class="date-order"><span><?php echo $order['date_added']; ?></span></div>
                                <div class="order-status hidden-lg"><span><?php echo $order['status']; ?></span></div>
                                <div class="order-sum visible-sm visible-xs">
                                    <span><?php echo $order['products_count']; ?> <?php   echo $text_product; ?> <?php echo $text_on_summ; ?>  <?php echo    $order['total']; ?></span>
                                </div>
                                <div class="order-img-xs visible-xxs hidden-xs hidden-sm hidden-lg hidden-md">
                                <?php if($order['products']){ ?>
                                    <?php foreach($order['products'] as $product){ ?>
                                        <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['image']; ?>" /></a>
                                    <?php } ?>
                                <?php } ?>
                                </div>
                                
                            </td>

                            </td>    
                            <td class="order-img hidden-xxs">
                                <?php if($order['products']){ ?>
                                    <?php foreach($order['products'] as $product){ ?>
                                        <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['image']; ?>" /></a>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                            <td class="order-sum hidden-xs hidden-sm">
                                <span><?php echo $order['products_count']; ?> <?php   echo $text_product; ?> <?php echo $text_on_summ; ?>  <?php echo    $order['total']; ?></span>
                                
                            </td>
                            
                            <td class="order-status visible-lg"><span><?php echo $order['status']; ?></span>
                            </td>

                            
                        </tr>
                    <?php } ?>
                </table>
                <div class="row">
                    <div class="col-sm-6 text-left order_pagination" ><?php echo $pagination; ?></div>
                    <div class="col-sm-6 text-right"><?php echo $results; ?></div>
                </div>
                <?php } else { ?>
                <p><?php echo $text_empty; ?></p>
                <?php } ?>
            </div> 
</div>
</div>     
</div>
<script type="text/javascript"><!--
    $(document).delegate('.order_type, .order_pagination ul li a, .watch_one_order', 'click', function() {
        
        var url=$(this).data('href');
        
	$.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            success: function(json) {
		if (json.success) {
                    var markup=$('#orders_block', json.html);
                    $('#orders_block').html(markup.html());
		}
            }
	});
	
});


$(document).delegate('#back_to_orders_list', 'click', function(){
    var url="index.php?route=account/order/getList&period=all";
    $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            success: function(json) {
		if (json.success) {
                    var markup=$('#orders_block', json.html);
                    $('#orders_block').html(markup.html());
		}
            }
	});
});
//--></script>
