<div id="cart">
	<div class="tunic">
            <?php if($text_items){ ?>
   		<img src="catalog/view/theme/default/image/icon-cart.png" alt="Add cart" class="img-responsive img-buying"><span class="hidden-sm hidden-xs buying"><?php echo $text_cart_shopping; ?></span><span id="cart-total"><?php echo $text_items; ?></span>
            <?php }else{ ?>
                <img src="catalog/view/theme/default/image/icon-cart_gray.png" alt="Add cart" class="img-responsive img-buying"><span class="hidden-sm hidden-xs buying"><?php echo $text_cart_shopping; ?></span>
            <?php } ?>
   	</div>
</div>
