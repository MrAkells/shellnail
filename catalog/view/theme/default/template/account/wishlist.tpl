<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumbs list-inline">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a class="crumb" href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
  </ul>
   <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h2 class="wishlist-title"><?php echo $heading_title; ?></h2>
      <?php if ($products) { ?>
      <div>
        <table class="table table-wishlist">
          <thead class="hidden">
            <tr>
              <td class="text-center"><?php echo $column_image; ?></td>
              <td class="text-left"><?php echo $column_name; ?></td>
              <td class="text-left"><?php echo $column_model; ?></td>
              <td class="text-right"><?php echo $column_stock; ?></td>
              <td class="text-right"><?php echo $column_price; ?></td>
              <td class="text-right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product) { ?>
            <tr>
              <td class="text-center"><?php if ($product['thumb']) { ?>
                <a href="<?php echo $product['href']; ?>"><img class="<?php echo $product['quantity']>0?'':'colorless'; ?>" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
                <?php } ?></td>
              <td class="text-left name-table"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                <div class="model-table"><?php echo $column_model; ?>: <?php echo $product['model']; ?></div>
                <div class="produc-status wishlist-status visible-xs">
                  <i class="fa fa-check"></i> <?php echo $product['stock']; ?>
                </div>
                <?php if ($product['price']) { ?>
                <div class="price price-table visible-xs">
                  <?php if (!$product['special']) { ?>
                  <?php echo $product['price']; ?>
                  <?php } else { ?>
                  <b><?php echo $product['special']; ?></b> <s><?php echo $product['price']; ?></s>
                  <?php } ?>
                </div>
                <?php } ?>
                </td>
              <td class="text-left model-table hidden"><?php echo $column_model; ?>: <?php echo $product['model']; ?></td>
              <td class="text-right produc-status hidden-xs">
                    <?php if($product['quantity']>0){ ?>
                        <p class="produc-status"><i class="fa fa-check"></i> <?php echo $text_instock; ?></p>
                    <?php }else{ ?>
                        <p class="produc-status is_not_present"> <?php echo $text_outstock; ?></p>
                        <?php } ?></td>
              <td class="text-right hidden-xs"><?php if ($product['price']) { ?>
                <div class="price price-table">
                  <?php if (!$product['special']) { ?>
                  <?php echo $product['price']; ?>
                  <?php } else { ?>
                  <b><?php echo $product['special']; ?></b> <s><?php echo $product['price']; ?></s>
                  <?php } ?>
                </div>
                <?php } ?></td>
              <td class="wishlist-delete text-center">
                   <?php if($product['quantity']){ ?>
                  <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_cart; ?>" class="btn-transparent"><img src="catalog/view/theme/default/image/icon-cart.png" alt="Add cart" class="img-cart-table">
                  </button>
                  <?php }else{ ?>
                  <button type="button" class="btn-transparent order" data-toggle="modal" data-target="#preoder" data-product="<?php echo $product['name']; ?>" data-product_url="<?php echo $product['href']; ?>" data-product_id="<?php echo $product['product_id']; ?>" data-product_img="<?php echo $product['thumb']; ?>" data-product_price="<?php echo $product['price']; ?>" ><i data-toggle="tooltip"  title="<?php echo $button_notify_availability; ?>" style="font-size: 2em;" class="fa fa-phone"></i></button>
                  <?php } ?>
                <a href="<?php echo $product['remove']; ?>" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="close-icon close-wishlist btn-transparent"></a></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>