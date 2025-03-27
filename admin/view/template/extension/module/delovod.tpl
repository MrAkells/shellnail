<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
  <?php } elseif(isset($success) && $success) {?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li <?php if ($category_id == 0) echo 'class="active"' ?> ><a href="#tab-config" data-toggle="tab"><i class="fa fa-pencil"></i> <?php echo $tab_config; ?></a></li>
          <li><a href="#tab-balance" data-toggle="tab"><?php echo $tab_balance; ?></a></li>
          <li <?php if ($category_id) echo 'class="active"' ?>><a href="#tab-goods" data-toggle="tab"><i class="fa fa-refresh"></i> <?php echo $tab_goods; ?></a></li>
        </ul>
        <div class="tab-content">
          <!-- Tab Config -->
          <div class="tab-pane <?php if ($category_id == 0) echo 'active' ?>" id="tab-config">
              <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-delovod" class="form-horizontal">
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-api_key"><?php echo $entry_api_key; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="delovod_api_key" value="<?php echo $delovod_api_key; ?>" placeholder="<?php echo $entry_api_key; ?>" id="input-api_key" class="form-control" />
                      <?php if ($error_api_key) { ?>
                      <div class="text-danger"><?php echo $error_api_key; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-category_list"><?php echo $entry_category_list; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="delovod_category_list" value="<?php echo $delovod_category_list; ?>" placeholder="110,200,300" id="input-category_list" class="form-control" />
                      <?php if ($error_category_list) { ?>
                      <div class="text-danger"><?php echo $error_category_list; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                    <div class="col-sm-10">
                      <select name="delovod_status" id="input-status" class="form-control">
                        <?php if ($delovod_status) { ?>
                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                        <option value="0"><?php echo $text_disabled; ?></option>
                        <?php } else { ?>
                        <option value="1"><?php echo $text_enabled; ?></option>
                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <button type="submit" form="form-delovod" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                </form>
              </div>
          </div>
          <!-- Tab balance -->
          <div class="tab-pane" id="tab-balance">
            <div class="form-group">
              <label class="col-sm-2 col-form-label" for="input-category">Выполнить синхронизацию остатков</label>
              <div class="col-sm-6">
                <a href="<?php echo $url_balance; ?>"><button type="button" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Выполнить синхронизацию остатков"><i class="fa fa-refresh"></i></button></a>
              </div>
            </div>
          </div>
          <!-- Tab goods -->
          <div class="tab-pane <?php if ($category_id) echo 'active' ?>" id="tab-goods" >
            <div class="container-fluid">
              <div class="pull-right">
                <button type="submit" form="form-delovod-sync" data-toggle="tooltip" title="sync" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
                <button type="button" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-product').submit() : false;"><i class="fa fa-plus"></i></button>
              </div>
            </div>
            <form action="<?php echo $url_sync; ?>" method="post" enctype="multipart/form-data" id="form-delovod-sync" class="form-horizontal">
              <div class="form-group">
                <div class="col-sm-6">
                  <label>
                    <input type="checkbox" name="only_name" value="1">
                    Обновить только наименование
                  </label>
                  <br>
                  <label>
                  <input type="checkbox" name="only_price" value="1">
                  Обновить только Цену
                </label>
                <br>
                <label>
                  <input type="checkbox" name="update_all_prices" value="1">
                  Обновить цену всех товаров (постранично)
                </label>
                <br>
                <label>
                Страница: <input type="text" name="update_page" value="1" style="width: 60px;">
              </label>
              <br>
              <span id="price-progress-info"></span>

                </div>

                <div class="col-sm-6">
                  <label>
                    Page
                    <input type="text" name="page" value="0" >
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-category"><?php echo $entry_category; ?></label>
                <div class="col-sm-6">
                  <select id="category_id" name="category_id" class="form-control">
                    <option value="0" selected="selected"><?php echo $text_none; ?></option>
                    <?php foreach($categories as $category) { ?>
                      <?php if ($category['category_id'] == $category_id) { ?>
                      <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                  </div>
              </div>
            </form>
            <form action="<?php echo $url_sync_prod; ?>" method="post" enctype="multipart/form-data" id="form-product">
                      <input type="hidden" name="category_id" value="<?php echo $category_id; ?>"/>
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                      <td class="text-left"><?php echo $column_name; ?></td>
                      <td class="text-right"><?php echo $column_action; ?></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($products) { ?>
                    <?php foreach ($products as $product) { ?>
                    <tr>
                      <td class="text-center">
                        <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" />
                      </td>
                      <td class="text-left"><?php echo $product['name']; ?></td>
                        <td class="text-right"><a href="<?php echo $product['edit']; ?>" data-toggle="tooltip" title="edit" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                      <td class="text-center" colspan="3"><?php echo $text_no_results; ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </form>
            <?php if ($products) { ?>
            <div class="row">
              <div class="col-sm-6 text-right">Всего: <?php echo count($products); ?></div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
</div>

<script>
  (function() {
    const checkbox = document.querySelector('input[name="update_all_prices"]');
    const pageInput = document.querySelector('input[name="update_page"]');
    const progressContainer = document.getElementById('price-progress-info');

    const totalPages = parseInt(sessionStorage.getItem('delovod_total_pages') || 0);
    const currentPage = parseInt(pageInput?.value || 1);

    if (progressContainer && totalPages > 0) {
      const percent = Math.min(100, Math.round((currentPage / totalPages) * 100));
      progressContainer.innerHTML = `
        <div style="margin-top: 10px;">
          Страница <strong>${currentPage}</strong> из <strong>${totalPages}</strong>
        </div>
        <div style="width: 100%; background: #eee; border-radius: 5px; height: 10px; margin-top: 5px;">
          <div style="width: ${percent}%; background: #5cb85c; height: 10px; border-radius: 5px;"></div>
        </div>
      `;
    }

    // Сохраняем общее число страниц из flash-сообщения (если есть)
    const successMsg = document.querySelector('.alert-success');
    if (successMsg) {
      const match = successMsg.innerText.match(/Всего товаров: (\d+)/i);
      if (match) {
        const total = parseInt(match[1]);
        const pageSize = 100;
        const pages = Math.ceil(total / pageSize);
        sessionStorage.setItem('delovod_total_pages', pages);
      }
    }
  })();
</script>



<script type="text/javascript"><!--
    $('button[type=\'submit\']').on('click', function() {
      $(this).button('loading');
    });
    $('#category_id').on('change', function() {
      location = 'index.php?route=extension/module/delovod&token=<?php echo $token; ?>&category_id=' + $(this).val();
    });
//--></script>
<?php echo $footer; ?>
