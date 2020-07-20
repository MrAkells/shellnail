<div id="cart_psevdo" class="nail-cart">   
	<div class="head">
	 <div><button type="button" class="close close-icon close-main" style="margin-left: 0;
	margin-right: auto;"onclick="$('#popupcart_extended').popup('hide')" ><span></span></button></div><div><?php echo $head; ?></div>
	</div>
	<?php if ($products || $vouchers) { ?>
		<div class="popupcart_info">
			<table>
				<tr class="hr"><td colspan="6"></td></tr>
				<?php foreach ($products as $key => $product) { ?>
					<tr class="row_<?php echo $key; ?>_<?php echo $product['id']; ?> row-popup">
						<td class="image">
							<?php if ($product['thumb']) { ?>
								<img src="<?php echo $product['thumb']; ?>" onclick="location='<?php echo $product['href']; ?>'" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" />
							<?php } ?>
						</td>
						<td class="name">
							<a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
							<div>
								<?php foreach ($product['option'] as $option) { ?>
									<div class="cart-options"><?php echo $option['name']; ?> <?php echo $option['value']; ?></div>
								<?php } ?>
							</div>
							<?php if (!$product['stock']) { ?>
								<?php if ($product['quantity'] >= $product['maximum']) { ?>
									<div class="cart-options"><?php echo $in_stock; ?> <?php echo ($product['maximum'] > 1) ? $left : $left1; ?> <?php echo $just; ?> <?php echo $product['maximum']; ?> <?php echo $pcs; ?></div>
								<?php } ?>
							<?php } ?>
							<div class="quantity">
								<div>
								
								<span>
								<i class="fa fa-minus1" onclick="updateCartNew('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>', '-')"></i>
								<input type="text" name="<?php echo $product['key']; ?>" size="2" value="<?php echo $product['quantity']; ?>" onchange="updateCartNew('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>')" />
									<?php if (!$product['stock']) { ?>
										<?php if ($product['quantity'] < $product['maximum']) { ?>
											<i class="fa fa-plus1" onclick="updateCartNew('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>', '+')"></i>
										<?php } else { ?>
											<i class="fa fa-plus1" style="opacity:0.5; cursor:default"></i>
										<?php } ?>
									<?php } else { ?>
										<i class="fa fa-plus1" onclick="updateCartNew('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>', '+')"></i>
									<?php } ?>
									
								</span>
							</div>
							</div>
							<div class="privat-price visible-xs">
								<?php echo $product['total']; ?>
							</div>
						</td>
						<?php if ($manufacturer_show) { ?>
							<td class="brand"><?php echo $product['manufacturer']; ?></td>
						<?php } ?>
						<td class="price hidden-xs"><?php echo $product['total']; ?></td>
						<td class="remove">
						<button type="button" class="close close-icon" title="<?php echo $button_remove; ?>" onclick="$(this).parent().prev().prev().find('input').val(0); updateCartNew('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>', 'del')" ><span></span></button>
						</td>
					</tr>
					<tr class="hr"><td colspan="6"></td></tr>
				<?php } ?>
                             
				<?php foreach($totals as $total) { ?>
                                <?php if($total==end($totals)){ ?>
					<tr class="bottom-line">
						<td class="image text-total"><?php echo $total['title'] ?></td>
						<td class="empty-cell"></td>
						<td class="price"><?php echo $total['text']; ?></td>
						<td class="last-empty-cell"></td>
					</tr>
                                    <?php } ?>
				<?php } ?>

				</table>
		</div>
		<div class="popupcart_buttons">
			
			
			
		</div>
		<?php if($products_related) { ?>
			<div id="related">
				<div class="heading"><?php echo $text_related; ?></div>
				<div class="related_product">
					<?php foreach ($products_related as $product) { ?>
						<div>
							<?php if ($product['thumb']) { ?>
								<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
							<?php } ?>
							<div>
								<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
								<?php if ($product['price']) { ?>
									<div class="price">
										<?php if (!$product['special']) { ?>
											<?php echo $product['price']; ?>
										<?php } else { ?>
											<span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
										<?php } ?>
									</div>
								<?php } ?>
								<div class="cart"><a onclick="cart.add('<?php echo $product['product_id']; ?>', 1, 1);" class="button btn btn-primary"><i class="fa fa-shopping-cart"></i></a></div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	<?php } else { ?>
		<div class="empty"><?php echo $text_empty; ?></div>
	<?php } ?>
	<input type="hidden" name="addtocart_logic" value="<?php echo $addtocart_logic; ?>" />
	<input type="hidden" name="click_on_cart" value="<?php echo $click_on_cart; ?>" />
</div>

<script>
function updateCartNew(product_id, key, flag) {

	var input = $('input[name=\'' + key + '\']');
	
	if(flag == '+') {
		input.val(parseFloat(input.val())+1);
	}
	
	if(flag == '-') {
		input.val(parseFloat(input.val())-1);
	}

	if (qnty == '') return;
	
	var qnty = parseFloat(input.val());
        
        if(flag == 'del'){
            qnty=0;
        }
	
	$.ajax({
		type: 'post',
		data: 'quantity['+key+']='+qnty,
		url: 'index.php?route=checkout/cart/edit',
		dataType: 'html',
		success: function(data) {
			$('#cart_psevdo').load('index.php?route=extension/module/cartpage/ajax #cart_psevdo > *');
			
			if (!qnty) {
				restore_button(product_id);
			}
		}
	});
}
</script>




