<?php echo $header; ?>
<div class="container">
 
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <div class="row">
   
      
      
    <div id="content" class="col-sm-12">
      <h2><?php echo $heading_title; ?></h2>
      
      
    <div class="tab-account">
      <ul class="nav nav-tabs new-nav-tabs nav-account">
          <li class="active"><a data-toggle="tab" href="#tab1"><span class="hidden-xs"><?php echo $text_сontact_info; ?></span><img src="catalog/view/theme/default/image/icons-contact-info.png" alt="Contact info" class="img-responsive visible-xs"></a></li>
          <li ><a data-toggle="tab" href="#tab2"><span class="hidden-xs"><?php echo $text_address_book; ?></span><img src="catalog/view/theme/default/image/icons-note-address.png" alt="Note address" class="img-responsive visible-xs"></a></li>
          <li><a data-toggle="tab" href="#tab3"><span class="hidden-xs"><?php echo $text_wishlist; ?></span><img src="catalog/view/theme/default/image/icons-note-wish.png" alt="Note wishlist" class="img-responsive visible-xs"></a></li>
          <li ><a data-toggle="tab" href="#tab4"><span class="hidden-xs"><?php echo $text_transaction; ?></span><img src="catalog/view/theme/default/image/icons-history-order.png" alt="History order" class="img-responsive visible-xs"></a></li>
          <div class="block_leave"><a href="<?php echo $link_leave; ?>" class="link_leave"><?php echo $text_leave; ?></a></div>
      </ul>
      
      
      <div class="tab-content">
          <div id="tab1" class="tab-pane fade in active">
            <div class="row">
              <div class="col-md-8 col-sm-6"><?php echo $personalData; ?></div>
              <div class="col-md-4 col-sm-6"><?php echo $changePassword; ?></div>
            </div>
          </div>
          <div id="tab2" class="tab-pane fade">
             <div class="row"><?php echo $address; ?></div>
          </div>
          <div id="tab3" class="tab-pane fade">
             <?php echo $widhlist; ?>
          </div>
          <div id="tab4" class="tab-pane fade">
              <div>
                  <?php if($customer_special){ ?>
                  <span style='font-size: 140%; color: red;'> <?php echo $customer_special_text.'%'; ?> </span>
                  <br/><br/>
                  <?php } ?>
                  <div id="order_block">
                    <?php echo $orders; ?>
                  </div>
              </div>
            
          </div>
      </div>  
    </div>  
      
      
      
     
     
    </div>
      
     
      
</div>
<?php echo $footer; ?> 