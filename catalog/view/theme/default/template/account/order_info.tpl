<div>
    <div id="orders_block">
    <p class="back_to_orders_list"><span id="back_to_orders_list"><?php echo $text_back_to_list; ?></span>
                </p>
        <div class="row row-order">
            <div class="col-md-9 left-order-info">
                
                <div class="contant-order-info">
                    <div class="head-order-info">
                        <p class="block_number_order"><i class="fa fa-angle-up"></i><span class="number_order">№ <?php echo '000'.$order_id; ?></span>
                        </p>
                        <div class="date-order-detail"><?php echo $date_added; ?></div>
                    </div>
                    <div class="body-order-info">
                        <div class='one_order_products'>
                            <?php foreach ($products as $product) { ?>
                            <div class="row product_position">
                                <div class="col-lg-2 col-sm-3">
                                    <img src="<?php echo $product['thumb']; ?>" />
                                </div>
                                <div class="col-lg-10 col-sm-9">
                                    <p class="name-sku-order">
                                        <span class="name-order-info"><?php echo $product['name']; ?></ span>
                                        <span class="sku-order-info">   <?php echo $product['sku']; ?></span>
                                    </p>
                                    <div>
                                        <div class="price-order-info"> <?php echo $product['price']; ?> </div>
                                        <div class="qnt-order-info">   <?php echo $product['quantity']; ?><?php echo $text_one_thing; ?></div>
                                        <div class="total-order-info"><span> <?php echo $product['total']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div> 
                     <div class="row table-info-order">
                        <?php if ($payment_method) { ?>
                            <div class="payment_info">
                                <div class="col-sm-4 col-sm-offset-3 col-lg-4 col-lg-offset-2 col-xs-6 td-left"><?php         echo    $text_payment_method; ?></div>
                                <div class="col-sm-5 col-lg-6 col-xs-6 td-right"><?php echo    $payment_method; ?></div>
                            </div>
                        <?php } ?>
                        <?php if ($shipping_method) { ?>
                            <div class="shipping_info">
                                <div class="col-sm-4 col-sm-offset-3 col-lg-4 col-lg-offset-2 col-xs-6 td-left"><?php echo $text_shipping_method; ?></div>
                                <div class="col-sm-5 col-lg-6 col-xs-6 td-right"><?php echo $shipping_method; ?></div>
                            </div>
                        <?php } ?>
                        <?php if($user_fio){ ?>
                            <div>
                                <div class="col-sm-4 col-sm-offset-3 col-lg-4 col-lg-offset-2 col-xs-6 td-left"><?php echo $text_fio; ?></div>
                                <div class="col-sm-5 col-lg-6 col-xs-6 td-right"><?php echo $user_fio; ?></div>
                            </div>
                        <?php } ?>
                        <?php if($custom_phone){ ?>
                            <div>
                                <div class="col-sm-4 col-sm-offset-3 col-lg-4 col-lg-offset-2 col-xs-6 td-left"><?php echo $text_phone; ?></div>
                                <div class="col-sm-5 col-lg-6 col-xs-6 td-right"><?php echo $custom_phone; ?></div>
                            </div>
                        <?php } ?>
                        <?php if($shipping_address_1){ ?>
                            <div>
                                <div class="col-sm-4 col-sm-offset-3 col-lg-4 col-lg-offset-2 col-xs-6 td-left"><?php echo        $text_shipping_address; ?></div>
                                <div class="col-sm-5 col-lg-6 col-xs-6 td-right"><?php echo $shipping_address_1; ?></div>
                            </div>
                        <?php } ?>
                        <?php if($email){ ?>
                            <div>
                                <div class="col-sm-4 col-sm-offset-3 col-lg-4 col-lg-offset-2 col-xs-6 td-left"><?php echo $text_email; ?></div>
                                <div class="col-sm-5 col-lg-6 col-xs-6 td-right"><?php echo $email; ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                    
                    <?php foreach ($totals as $total) { ?>
                        <?php if($total['code']=='shipping'){ ?>
                        
              <div class="delivery-order">
                    <div class="name-delivery-order">Доставка (<?php echo $shipping_method; ?>)</div>
                    <div class="price-delivery-order"><?php echo $total['text']; ?></div>
                </div>
          
                    <?php } } ?>
                    
                    
               
                              
            
           
            
            
            
            
        
            
           <!-- <?php foreach ($vouchers as $voucher) { ?>
            <tr>
              <td class="text-left"><?php echo $voucher['description']; ?></td>
              <td class="text-left"></td>
              <td class="text-right">1</td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>
              <?php if ($products) { ?>
              <td></td>
              <?php } ?>
            </tr>
            <?php } ?> -->
                <div class="summative"> 
                    <table class="table-summative">
                    <tr>

                        <?php foreach ($totals as $total) { ?>
                        <?php if($total==end($totals)){ ?>
                        <td class="concomitant-order"><?php echo $total['title']; ?></td>
                        <td class="concomitant-sum"><?php echo $total['text']; ?> </td>
             
          
                    <?php } } ?>
                        </tr>
                    </table>
                </div>
                </div>  
            </div>
            <div class="col-md-3 right-order-info">
                <div class="order-info-status">
                    <div class="title-order-status"><?php echo $text_title_status; ?></div>
                <div class="position-order"><?php echo $order_status; ?></div>
                </div>
                
                <div>
                    <?php echo $shopreview; ?>
                </div>
                
                <div class="testimonial"></div>
            </div>
        </div>
    </div>
</div>

