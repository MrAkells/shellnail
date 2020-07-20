<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
       <button type="submit" form="form-forgroups" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary <?php echo $edit_mode?'hidden':''; ?>"><i class="fa fa-save"></i></button>
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
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-forgroups" class="form-horizontal">
         
            <input id="group_id" class="hidden" name='group_id' value="<?php echo $group_id; ?>" />
            
                <div class="form-group">
                <label class="col-sm-3 control-label" for="input-title"><?php echo $entry_title; ?></label>
                <div class="col-sm-6">
                    <input id="group_title" name="title" value="<?php echo $title; ?>" class="form-control">
                </div>
                <div class="col-sm-3 <?php echo $edit_mode?'':'hidden'; ?>">
                     <span id='edit_title' onclick="edit_group_title()" class='btn btn-info'>Изменить название группы</span>
                </div>
              </div>
           
              <div class="form-group <?php echo $edit_mode?'':'hidden'; ?>">
                <label class="col-sm-3 control-label" for="input-type"><?php echo $entry_type; ?></label>
                <div class="col-sm-3">
                    <select id="input-type" name="type" class="form-control">
                        <?php foreach($types as $key => $value){ ?>
                            
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                           
                        <?php } ?>
                    </select>
                </div>
                 <label class="col-sm-1 control-label" for="input-change_value">Величина</label>
                 <div class="col-sm-2">
                    <input id="input-change_price" value='0' type="number" min="-999" name="change_price" class="form-control" max="1000" step="0.01">
                </div>
                   <div class="col-sm-3 " >
                       <span id='apply_price_change' class='btn btn-success' onclick="change_group_price()">Изменить цену группе товаров</span>
                </div>
              </div>
            
            <?php if($edit_mode){ ?>
            
           
            <div class="form-group">
                 <br/><br/>
                  <label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip" title="Выберите категорию и производителя. Либо что-то одно и нажмите кнопку добавить в список"><?php echo $entry_group; ?></span></label>
                <div class="col-sm-3">
                    <select class="form-control" id="selectProductCategory" onchange="check_group();">
                        <option value="0"><?php echo $text_select; ?></option>
                        <?php foreach ($categories as $category){ ?>
                            <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
			<?php } ?>
                    </select>
                </div>
                 
                <div class="col-sm-3">
                    <select class="form-control"  id="selectProductManufacturer" onchange="check_group();">
			<option value="0"><?php echo $text_select; ?></option>
                        <?php foreach ($manufacturers as $manufacturer): ?>
                            <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
			<?php endforeach ?>
                    </select>
                </div>
                  
                <div class="col-sm-4">
                    <span id="btn_add_group" onclick="add_group_to_list()" class="btn btn-success" style="font-size: 1.1em;">Добавить 0 товаров в список</span>
                </div>
                  
            </div>
            
            
            <div class="form-group">
            <label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip" title="Начните вводить название"><?php echo $entry_product; ?></span></label>
            <div class="col-sm-4">
              <input type="text" name="product_name" value="" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />
         
            </div>

            <div class="col-sm-1">
                
            </div>
            
            <div class="col-sm-1">
                 <span id="sort_name" data-order="DESC" data-toggle="tooltip" title="Сортировать по алфавиту" class="btn btn-default"><i class="fa fa-sort-alpha-asc"></i></span>
            </div>
            
             <div class="col-sm-1">
                 <span id="sort_quantity" data-order="ASC" data-toggle="tooltip" title="Сортировать по количеству" class="btn btn-default"><i class="fa fa-sort-amount-asc"></i></span>
            </div>
            
            <div class="col-sm-1">
                 <span id="sort_price" data-order="ASC" data-toggle="tooltip" title="Сортировать по цене" class="btn btn-default"><i class="fa fa-dollar"></i></span>
            </div>
            
            <div class="col-sm-1">
                   <span onclick="save_group_products();"  data-toggle="tooltip" title="Прикрепить выбраные товары к акции" class="btn btn-success"><i class="fa fa-save"></i></span>
                </div>
            
            
            
                <div class="col-sm-1">
                    <span type="button" data-toggle="tooltip" title="Удалить не отмеченные" class="btn btn-danger" onclick="confirm('Удалить не отмеченные в списке товары?') ? delete_from_list() : false;"><i class="fa fa-trash-o"></i></span>
                </div>
                
          </div> 
            
          
            
            <br/>
            <div id="candidates_list" class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-center"><?php echo $column_image; ?></td>
                  <td class="text-left"><?php echo $column_name; ?></td>
                 <td class="text-left"><?php echo $column_category; ?></td>
                 <td class="text-right"><?php echo $column_price; ?></td>
                  
                  <td class="text-right"><?php echo $column_quantity; ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($products) { ?>
                <?php foreach ($products as $product) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($product['product_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-center"><?php if ($product['image']) { ?>
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-thumbnail" />
                    <?php } else { ?>
                    <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $product['name']; ?></td>
                  <td class="text-left">
                    <?php foreach ($categories as $category) { ?>
                    <?php if (in_array($category['category_id'], $product['category'])) { ?>
                    <?php echo $category['name'];?><br>
                    <?php } ?>
                    <?php } ?></td>
                <td class="text-right"><?php echo $product['price']; ?></td>

                 

                  <td class="text-right"><?php if ($product['quantity'] <= 1) { ?>
                    
                    <span class="label label-danger"><?php echo $product['quantity']; ?></span>
                    <?php } else { ?>
                    <span class="label label-success"><?php echo $product['quantity']; ?></span>
                    <?php } ?></td>
                  
                  <td class="text-right"><a target="_blank" href="<?php echo $product['edit']; ?>" data-toggle="tooltip" title="Редактировать товар"  class="btn"><i class="fa fa-pencil"></i></a></td>
                  
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
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
     function create_loader(){
        $('body').prepend("<div style='position: fixed; z-index: 9999; width: 200px; height: 200px' class='uloginloader hidden'><img class='image' src='../image/payment/spin.gif' style='width: 100%;'/></div>");
        var loader = $('.uloginloader');

        var top=(window.innerHeight-loader.height())/2;
        var left=(window.innerWidth-loader.width())/2;
     
        loader.css('top', top+'px');
        loader.css('left', left+'px');
    }
    
    function start_loader(){
            var loader = $('.uloginloader');
            loader.removeClass('hidden');
        }
        
    function stop_loader(){
        var loader = $('.uloginloader');
        loader.addClass('hidden');
    }
 </script>
 
 <script>
$('input[name=\'product_name\']').autocomplete({
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	select: function(item) {
		var group_id=$("#group_id").val();
                var send_data={
                    product_id: item['value'],
                    group_id: group_id
                };
                $.ajax({
			url: 'index.php?route=catalog/groups/addProductToGroup&token=<?php echo $token; ?>',
                        type: 'post',
                        data: send_data,
                        dataType: 'json',
			success: function(json) {
                            $('input[name=\'product_name\']').val('');
                             update_product_list();
			}
		});
	}
});
	
        $('#sort_name').click(function(){
            if($(this).data('order')=='ASC'){
                var sort='pd.name&order=ASC';
                $(this).data('order', 'DESC');
            }else{
                var sort='pd.name&order=DESC';
                $(this).data('order', 'ASC');
            }
            update_product_list(sort);
        });
        
        $('#sort_quantity').click(function(){
            if($(this).data('order')=='ASC'){
                var sort='p.quantity&order=ASC';
                $(this).data('order', 'DESC');
            }else{
                var sort='p.quantity&order=DESC';
                $(this).data('order', 'ASC');
            }
            update_product_list(sort);
        });
        
        $('#sort_price').click(function(){
            if($(this).data('order')=='ASC'){
                var sort='p.price&order=ASC';
                $(this).data('order', 'DESC');
            }else{
                var sort='p.price&order=DESC';
                $(this).data('order', 'ASC');
            }
            update_product_list(sort);
        });


    function update_product_list(sort){
        if(!$('.uloginloader').length){
            create_loader();
        }
        start_loader();
        var url=location.href;
        if(sort!==undefined){
           url+='&sort='+sort;
        }
        $.ajax({
            url: url,
            type: 'get',          
            dataType: 'html',
            success: function(html) {
                var new_list=$('#candidates_list', html).html();
                $('#candidates_list').html(new_list);
                stop_loader();
            }
	});
    }

    function save_group_products(){
        var data=$('#form-forgroups').serialize();
        $.ajax({
            url: 'index.php?route=catalog/groups/saveGroupProducts&token=<?php echo $token; ?>',
            type: 'post',   
            data: data,
            dataType: 'json',
            success: function(json) {
                if(json.success){
                    update_product_list();
                }else{
                    alert('Прикрепить товары к акции не удалось. Попробуйте ещё раз. Если снова появится данное сообщение сообщите программисту');
                }
            }
	});
    }

    function delete_from_list(){
        var data=$('#form-forgroups').serialize();
        $.ajax({
            url: 'index.php?route=catalog/groups/deleteGroupProducts&token=<?php echo $token; ?>',
            type: 'post',   
            data: data,
            dataType: 'json',
            success: function(json) {
                if(json.success){
                    update_product_list();
                }else{
                    alert('Прикрепить товары к акции не удалось. Попробуйте ещё раз. Если снова появится данное сообщение сообщите программисту');
                }
            }
	});
    }
    
        function check_group(){
            var category_id=$("#selectProductCategory").val();
            var manufacturer_id=$("#selectProductManufacturer").val();
            var group_id=$("#group_id").val();
            var send_data={
                category_id:  category_id,
                manufacturer_id: manufacturer_id,
                group_id: group_id
            };
            $.ajax({
			url: 'index.php?route=catalog/groups/checkGroup&token=<?php echo $token; ?>',
                        type: 'post',
                        data: send_data,
                        dataType: 'json',
			success: function(json) {
                            if(json.success){
                                $('#btn_add_group').html('Добавить '+json.count+' товаров в список');
                            }
                           
			}
		});
        
        }
         
        function add_group_to_list(){
            var category_id=$("#selectProductCategory").val();
            var manufacturer_id=$("#selectProductManufacturer").val();
           var group_id=$("#group_id").val();
            var send_data={
                category_id:  category_id,
                manufacturer_id: manufacturer_id,
                group_id: group_id
            };
            $.ajax({
			url: 'index.php?route=catalog/groups/addProductsGroup&token=<?php echo $token; ?>',
                        type: 'post',
                        data: send_data,
                        dataType: 'json',
			success: function(json) {
                            update_product_list();
                             $('#btn_add_group').html('Добавить 0 товаров в список');
			}
		});
    }
    
    function edit_group_title(){
        var data=$('#form-forgroups').serialize();
        $.ajax({
            url: 'index.php?route=catalog/groups/changeTitle&token=<?php echo $token; ?>',
            type: 'post',   
            data: data,
            dataType: 'json',
            success: function(json) {
                if(json.success){
                    
                }
            }
	});
    }
    
    function change_group_price(){
        var data=$('#form-forgroups').serialize();
        console.log($('#input-type').val());
       
        var value=$('#input-change_price').val();
       
        if($('#input-change_price').val()!=0){
            var answer=true;
            if($('#input-type').val()=='1' && value>0){
                answer=confirm('Увеличить цену товаров на '+value+'% ?');
            }
            
            if($('#input-type').val()=='1' && value<0){
                answer=confirm('Уменшить цену товаров на '+-value+' % ?');
            }
            if($('#input-type').val()=='2' && value>0){
                answer=confirm('Увеличить цену товаров на '+value+'грн. ?');
            }
            if($('#input-type').val()=='2' && value<0){
               answer=confirm('Уменшить цену товаров на '+-value+' грн. ?');
            }
            
            if(!answer){
                return false;
            }
            
        $.ajax({
            url: 'index.php?route=catalog/groups/changeGroupPrice&token=<?php echo $token; ?>',
            type: 'post',   
            data: data,
            dataType: 'json',
            success: function(json) {
                if(json.success){
                    update_product_list();
                }else{
                    alert('Изменить цену не удалось. Попробуйте ещё раз. Если снова появится данное сообщение сообщите программисту');
                }
            }
	});
        }
    }
 
    
</script>
 
 
<?php echo $footer; ?>
