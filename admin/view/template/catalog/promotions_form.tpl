<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-promo" data-toggle="tooltip" title="<?php echo $button_save; ?>"
                    class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
                    class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
            <h1>
                <?php echo $heading_title; ?>
            </h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>">
                        <?php echo $breadcrumb['text']; ?>
                    </a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
            <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i>
                    <?php echo $text_form; ?>
                </h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-promo"
                    class="form-horizontal">

                    <input id="promo_id" class="hidden" name='promo_id' value="<?php echo $promo_id; ?>" />
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-title">
                            <?php echo $entry_title; ?>
                        </label>
                        <div class="col-sm-8">
                            <input name="title" value="<?php echo $title; ?>" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-short_title">
                            <?php echo $entry_short_title; ?>
                        </label>
                        <div class="col-sm-8">
                            <input name="short_title" value="<?php echo $short_title; ?>" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                            <span class="btn btn-default" data-toggle="collapse" data-target="#seo_fields">SEO
                                настройки</span>
                        </div>
                    </div>
                    <div id="seo_fields" class="col-sm-12 collapse">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="input-keyword">
                                <?php echo $entry_keyword; ?>
                            </label>
                            <div class="col-sm-8">
                                <input name="keyword" value="<?php echo $keyword; ?>" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="input-metat_title">Meta-title</label>
                            <div class="col-sm-8">
                                <input name="meta_title" value="<?php echo $meta_title; ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="input-meta_h1">Meta-H1</label>
                            <div class="col-sm-8">
                                <input name="meta_h1" value="<?php echo $meta_h1; ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="input-meta_description">Meta-description</label>
                            <div class="col-sm-8">
                                <textarea id="input-meta_description" name="meta_description"
                                    class="form-control"><?php echo $meta_description; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="input-meta_keywords">Keywords</label>
                            <div class="col-sm-8">
                                <textarea id="input-meta_keywords" name="meta_keywords"
                                    class="form-control"><?php echo $meta_keywords; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-description">
                            <?php echo $entry_description; ?>
                        </label>
                        <div class="col-sm-8">
                            <textarea id="input-description" name="description"
                                class="form-control"><?php echo $description; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            <?php echo $entry_image; ?>
                        </label>
                        <div class="col-sm-8"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img
                                    src="<?php echo $thumb_image; ?>" alt="" title="" /></a>
                            <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            <?php echo $entry_image; ?>
                        </label>
                        <div class="col-sm-8"><a href="" id="thumb-image-m" data-toggle="image" class="img-thumbnail"><img
                                    src="<?php echo $thumb_image_m; ?>" alt="" title="" /></a>
                            <input type="hidden" name="image_m" value="<?php echo $image_m; ?>" id="input-image-m" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-sort">
                            <?php echo $entry_sort_order; ?>
                        </label>
                        <div class="col-sm-8">
                            <input name="sort_order" value="<?php echo $sort_order; ?>" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-type">
                            <?php echo $entry_type; ?>
                        </label>
                        <div class="col-sm-8">
                            <select id="input-type" name="type" class="form-control">
                                <option value="0">NONE</option>
                                <?php foreach($types as $key => $value){ ?>
                                <?php if($type==$key){ ?>
                                <option value="<?php echo $key; ?>" selected="">
                                    <?php echo $value; ?>
                                </option>
                                <?php }else{ ?>
                                <option value="<?php echo $key; ?>">
                                    <?php echo $value; ?>
                                </option>
                                <?php } ?>
                                <?php } ?>
                            </select>

                            <div class="percent settings">
                                <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <label class="col-sm-3 control-label" for="input-percent">
                                        <?php echo $entry_percent; ?>
                                    </label>
                                    <div class="col-sm-3">
                                        <input id="input-percent" name="percent" value="<?php echo $percent; ?>"
                                            class="form-control">
                                    </div>
                                    <div class="col-sm-3"></div>
                                </div>
                            </div>

                            <div class="product_quantity settings">
                                <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <label class="col-sm-3 control-label" for="input-quantity">
                                        <?php echo $entry_quantity; ?>
                                    </label>
                                    <div class="col-sm-3">
                                        <input id="input-quantity" name="quantity" value="<?php echo $quantity; ?>"
                                            class="form-control">
                                    </div>
                                    <div class="col-sm-3"></div>
                                </div>
                            </div>

                            <div class="discount settings">
                                <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <label class="col-sm-3 control-label" for="input-discount">
                                        <?php echo $entry_discount; ?>
                                    </label>
                                    <div class="col-sm-3">
                                        <input id="input-discount" name="discount" value="<?php echo $discount; ?>"
                                            class="form-control">
                                    </div>
                                    <div class="col-sm-3"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-status">
                            <?php echo $entry_status; ?>
                        </label>
                        <div class="col-sm-8">
                            <select name="status" id="input-status" class="form-control">
                                <?php if ($status) { ?>
                                <option value="1" selected="selected">
                                    <?php echo $text_enabled; ?>
                                </option>
                                <option value="0">
                                    <?php echo $text_disabled; ?>
                                </option>
                                <?php } else { ?>
                                <option value="1">
                                    <?php echo $text_enabled; ?>
                                </option>
                                <option value="0" selected="selected">
                                    <?php echo $text_disabled; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-main">
                            <?php echo $entry_main; ?>
                        </label>
                        <div class="col-sm-8">
                            <select name="main" id="input-main" class="form-control">
                                <?php if ($main) { ?>
                                <option value="1" selected="selected">
                                    <?php echo $text_enabled; ?>
                                </option>
                                <option value="0">
                                    <?php echo $text_disabled; ?>
                                </option>
                                <?php } else { ?>
                                <option value="1">
                                    <?php echo $text_enabled; ?>
                                </option>
                                <option value="0" selected="selected">
                                    <?php echo $text_disabled; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            <?php echo $entry_parent = 'Родительская акция'; ?>
                        </label>
                        <div class="col-sm-8">
                            <select name="parent_id" class="form-control">
                                <option value="0" selected="selected">
                                    <?php echo $no_parent_entry = '-- Без родителя --'; ?>
                                </option>
                                <?php foreach ($parents as $key => $parent) { ?>
                                <?php if ($key == $parent_id) { ?>
                                <option value="<?php echo $key; ?>" selected="selected">
                                    <?php echo $parent; ?>
                                </option>
                                <?php } else { ?>
                                <option value="<?php echo $key; ?>">
                                    <?php echo $parent; ?>
                                </option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                    <div class="row form-group">

                        <div class="col-sm-3"></div>
                        <div class="form-group col-sm-4">
                            <label class=" control-label" for="input-date_start">
                                <?php echo $entry_date_start; ?>
                            </label>
                            <div class="">
                                <div class="input-group date">
                                    <input type="text" name="date_start" value="<?php echo $date_start; ?>"
                                        data-date-format="YYYY-MM-DD HH:mm" class="form-control" />
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i
                                                class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-1"></div>
                        <div class="form-group col-sm-4">
                            <label class=" control-label" for="input-date_end">
                                <?php echo $entry_date_end; ?>
                            </label>
                            <div class="">
                                <div class="input-group date">
                                    <input type="text" name="date_end" value="<?php echo $date_end; ?>"
                                        data-date-format="YYYY-MM-DD HH:mm" class="form-control" />
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i
                                                class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>


                    <?php if($edit_mode){ ?>


                    <div class="form-group">
                        <br /><br />
                        <label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip"
                                title="Выберите категорию и производителя. Либо что-то одно и нажмите кнопку добавить группу">
                                <?php echo $entry_group; ?>
                            </span></label>
                        <div class="col-sm-3">
                            <select class="form-control" id="selectProductCategory" onchange="check_group();">
                                <option value="0">
                                    <?php echo $text_select; ?>
                                </option>
                                <?php foreach ($categories as $category){ ?>
                                <option value="<?php echo $category['category_id']; ?>">
                                    <?php echo $category['name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control" id="selectProductManufacturer" onchange="check_group();">
                                <option value="0">
                                    <?php echo $text_select; ?>
                                </option>
                                <?php foreach ($manufacturers as $manufacturer): ?>
                                <option value="<?php echo $manufacturer['manufacturer_id']; ?>">
                                    <?php echo $manufacturer['name']; ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <span id="btn_add_group" onclick="add_group_to_list()" class="btn btn-success"
                                style="font-size: 1.1em;">Добавить 0 товаров в список</span>
                        </div>

                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip"
                                title="Начните вводить название">
                                <?php echo $entry_product; ?>
                            </span></label>
                        <div class="col-sm-4">
                            <input type="text" name="product_name" value="" placeholder="<?php echo $entry_product; ?>"
                                id="input-product" class="form-control" />

                        </div>

                        <div class="col-sm-1">

                        </div>

                        <div class="col-sm-1">
                            <span id="sort_name" data-order="DESC" data-toggle="tooltip" title="Сортировать по алфавиту"
                                class="btn btn-default"><i class="fa fa-sort-alpha-asc"></i></span>
                        </div>

                        <div class="col-sm-1">
                            <span id="sort_quantity" data-order="ASC" data-toggle="tooltip"
                                title="Сортировать по количеству" class="btn btn-default"><i
                                    class="fa fa-sort-amount-asc"></i></span>
                        </div>

                        <div class="col-sm-1">
                            <span id="sort_price" data-order="ASC" data-toggle="tooltip" title="Сортировать по цене"
                                class="btn btn-default"><i class="fa fa-dollar"></i></span>
                        </div>

                        <div class="col-sm-1">
                            <span onclick="save_promo_products();" data-toggle="tooltip"
                                title="Прикрепить выбраные товары к акции" class="btn btn-success"><i
                                    class="fa fa-save"></i></span>
                        </div>



                        <div class="col-sm-1">
                            <span type="button" data-toggle="tooltip" title="Удалить не отмеченные"
                                class="btn btn-danger"
                                onclick="confirm('Удалить не отмеченные в списке товары?') ? delete_from_list() : false;"><i
                                    class="fa fa-trash-o"></i></span>
                        </div>

                    </div>


                    <br />
                    <div id="candidates_list" class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td style="width: 1px;" class="text-center"><input type="checkbox"
                                            onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                                    </td>
                                    <td class="text-center">
                                        <?php echo $column_image; ?>
                                    </td>
                                    <td class="text-left">
                                        <?php echo $column_name; ?>
                                    </td>
                                    <td class="text-left">
                                        <?php echo $column_category; ?>
                                    </td>
                                    <td class="text-right">
                                        <?php echo $column_price; ?>
                                    </td>

                                    <td class="text-right">
                                        <?php echo $column_quantity; ?>
                                    </td>
                                    <td class="text-right">
                                        <?php echo $column_action; ?>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($products) { ?>
                                <?php foreach ($products as $product) { ?>
                                <tr>
                                    <td class="text-center">
                                        <?php if (in_array($product['product_id'], $selected)) { ?>
                                        <input type="checkbox" name="selected[]"
                                            value="<?php echo $product['product_id']; ?>" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="selected[]"
                                            value="<?php echo $product['product_id']; ?>" />
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($product['image']) { ?>
                                        <img src="<?php echo $product['image']; ?>"
                                            alt="<?php echo $product['name']; ?>" class="img-thumbnail" />
                                        <?php } else { ?>
                                        <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-left">
                                        <?php echo $product['name']; ?>
                                    </td>
                                    <td class="text-left">
                                        <?php foreach ($categories as $category) { ?>
                                        <?php if (in_array($category['category_id'], $product['category'])) { ?>
                                        <?php echo $category['name'];?><br>
                                        <?php } ?>
                                        <?php } ?>
                                    </td>
                                    <td class="text-right">
                                        <?php echo $product['price']; ?>
                                    </td>



                                    <td class="text-right">
                                        <?php if ($product['quantity'] <= 1) { ?>

                                        <span class="label label-danger">
                                            <?php echo $product['quantity']; ?>
                                        </span>
                                        <?php } else { ?>
                                        <span class="label label-success">
                                            <?php echo $product['quantity']; ?>
                                        </span>
                                        <?php } ?>
                                    </td>

                                    <td class="text-right"><a target="_blank" href="<?php echo $product['edit']; ?>"
                                            data-toggle="tooltip" title="Редактировать товар" class="btn"><i
                                                class="fa fa-pencil"></i></a></td>

                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                <tr>
                                    <td class="text-center" colspan="8">
                                        <?php echo $text_no_results; ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <?php }else{ ?>
                    <div style="font-size: 2em; color: red;">
                        <?php echo $text_save_first; ?>
                    </div>
                    <?php } ?>

                </form>
            </div>
        </div>
    </div>

</div>
<script>

    $('.date').datetimepicker({

    });

    function create_loader() {
        $('body').prepend("<div style='position: fixed; z-index: 9999; width: 200px; height: 200px' class='uloginloader hidden'><img class='image' src='../image/payment/spin.gif' style='width: 100%;'/></div>");
        var loader = $('.uloginloader');

        var top = (window.innerHeight - loader.height()) / 2;
        var left = (window.innerWidth - loader.width()) / 2;

        loader.css('top', top + 'px');
        loader.css('left', left + 'px');
    }

    function start_loader() {
        var loader = $('.uloginloader');
        loader.removeClass('hidden');
    }

    function stop_loader() {
        var loader = $('.uloginloader');
        loader.addClass('hidden');
    }

    ckeditorInit('input-description', getURLVar('token'));

    $(document).ready(function () {
        $('.settings').hide();

        $('#input-type').change(function () {
            $('.settings').hide();
            var value = $(this).val();
            if (value == 1) {
                $('.percent').show();
            } else if (value == 2) {
                $('.discount').show();
            } else if (value == 3) {
                $('.product_quantity').show();
            }
        });

        $('#input-type').change();

        $("#open_price_manager").click(function () {
            $("#price_manager_block").slideToggle();
            var arrow = $(this).find('i');
            if (arrow.hasClass('fa-angle-double-down')) {
                arrow.removeClass('fa-angle-double-down');
                arrow.addClass('fa-angle-double-up');
            } else {
                arrow.removeClass('fa-angle-double-up');
                arrow.addClass('fa-angle-double-down');
            }
        });

    });
</script>
<script>
    $('input[name=\'product_name\']').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                dataType: 'json',
                success: function (json) {
                    response($.map(json, function (item) {
                        return {
                            label: item['name'],
                            value: item['product_id']
                        }
                    }));
                }
            });
        },
        select: function (item) {
            var promo_id = $("#promo_id").val();
            var send_data = {
                product_id: item['value'],
                promo_id: promo_id
            };
            $.ajax({
                url: 'index.php?route=catalog/promotions/addcandidate&token=<?php echo $token; ?>',
                type: 'post',
                data: send_data,
                dataType: 'json',
                success: function (json) {
                    $('input[name=\'product_name\']').val('');
                    update_product_list();
                }
            });
        }
    });

    $('#sort_name').click(function () {
        if ($(this).data('order') == 'ASC') {
            var sort = 'pd.name&order=ASC';
            $(this).data('order', 'DESC');
        } else {
            var sort = 'pd.name&order=DESC';
            $(this).data('order', 'ASC');
        }
        update_product_list(sort);
    });

    $('#sort_quantity').click(function () {
        if ($(this).data('order') == 'ASC') {
            var sort = 'p.quantity&order=ASC';
            $(this).data('order', 'DESC');
        } else {
            var sort = 'p.quantity&order=DESC';
            $(this).data('order', 'ASC');
        }
        update_product_list(sort);
    });

    $('#sort_price').click(function () {
        if ($(this).data('order') == 'ASC') {
            var sort = 'p.price&order=ASC';
            $(this).data('order', 'DESC');
        } else {
            var sort = 'p.price&order=DESC';
            $(this).data('order', 'ASC');
        }
        update_product_list(sort);
    });


    function update_product_list(sort) {
        if (!$('.uloginloader').length) {
            create_loader();
        }
        start_loader();
        var url = location.href;
        if (sort !== undefined) {
            url += '&sort=' + sort;
        }
        $.ajax({
            url: url,
            type: 'get',
            dataType: 'html',
            success: function (html) {
                var new_list = $('#candidates_list', html).html();
                $('#candidates_list').html(new_list);
                stop_loader();
            }
        });
    }

    function save_promo_products() {
        var data = $('#form-promo').serialize();
        $.ajax({
            url: 'index.php?route=catalog/promotions/saveJustPromoProducts&token=<?php echo $token; ?>',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (json) {
                if (json.success) {
                    update_product_list();
                } else {
                    alert('Прикрепить товары к акции не удалось. Попробуйте ещё раз. Если снова появится данное сообщение сообщите программисту');
                }
            }
        });
    }

    function delete_from_list() {
        var data = $('#form-promo').serialize();
        $.ajax({
            url: 'index.php?route=catalog/promotions/deleteCandidatesAndPromoProducts&token=<?php echo $token; ?>',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (json) {
                if (json.success) {
                    update_product_list();
                } else {
                    alert('Прикрепить товары к акции не удалось. Попробуйте ещё раз. Если снова появится данное сообщение сообщите программисту');
                }
            }
        });
    }

    function check_group() {
        var category_id = $("#selectProductCategory").val();
        var manufacturer_id = $("#selectProductManufacturer").val();
        var promo_id = $("#promo_id").val();
        var send_data = {
            category_id: category_id,
            manufacturer_id: manufacturer_id,
            promo_id: promo_id
        };
        $.ajax({
            url: 'index.php?route=catalog/promotions/checkGroup&token=<?php echo $token; ?>',
            type: 'post',
            data: send_data,
            dataType: 'json',
            success: function (json) {
                if (json.success) {
                    $('#btn_add_group').html('Добавить ' + json.count + ' товаров в список');
                }

            }
        });

    }

    function add_group_to_list() {
        var category_id = $("#selectProductCategory").val();
        var manufacturer_id = $("#selectProductManufacturer").val();
        var promo_id = $("#promo_id").val();
        var send_data = {
            category_id: category_id,
            manufacturer_id: manufacturer_id,
            promo_id: promo_id
        };
        $.ajax({
            url: 'index.php?route=catalog/promotions/addCandidatesGroup&token=<?php echo $token; ?>',
            type: 'post',
            data: send_data,
            dataType: 'json',
            success: function (json) {
                update_product_list();
                $('#btn_add_group').html('Добавить 0 товаров в список');
            }
        });
    }



</script>


<?php echo $footer; ?>