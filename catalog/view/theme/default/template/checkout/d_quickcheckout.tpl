<?php echo $header; ?>
<div class="container" id="container">
 
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

      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#warningModal">
        Launch demo modal
      </button>

      <?php echo $d_quickcheckout; ?>

      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>

<!-- Modal -->
<div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="warningModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        В связи с военными действиями в Украине почта прекратила работу на отправку из нашего региона. Вы можете добавлять товары в список желаний, чтобы их купить, когда мы вернемся к работе. Мы обязательно оповестим вас, когда магазин заработает! Извините за неудобства.

        <button type="button" class="btn btn-default" data-dismiss="modal">Понятно</button>

      </div>

    </div>
  </div>
</div>
<?php echo $footer; ?>