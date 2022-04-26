<?php echo $header; ?>
<div class="container" id="container">

<div class="sd-warning-modal" id="sd-warning-modal">
  <div class="sd-warning-modal__body">
    В связи с военными действиями в Украине почта прекратила работу на отправку из нашего региона. Вы можете добавлять товары в список желаний, чтобы их купить, когда мы вернемся к работе. Мы обязательно оповестим вас, когда магазин заработает! Извините за неудобства.
    <div class="sd-warning-modal__bottom">
      <button type="button" id="sd-warning-close" class="btn btn-default sd-warning-modal__btn" >Понятно</button>
    </div>
  </div>
</div>
<script>
  document.getElementById("sd-warning-close").onclick = function() {
    document.getElementById("sd-warning-modal").style.display = "none";
  }
</script>
 
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
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
<!--<h1><?php echo $heading_title; ?></h1>-->
<!-- Quick Checkout v4.0 by Dreamvention.com checkout/quickcheckout.tpl -->

      <?php echo $d_quickcheckout; ?>

      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>


<?php echo $footer; ?>