<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-google-sitemap" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-xmlprice_status" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                        <div class="col-sm-10">
                            <select name="xmlprice_status" id="input-status" class="form-control">
                                <?php if ($xmlprice_status) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-xmlprice_shopname"><span data-toggle="tooltip" title="<?php echo $text_shop_name; ?>"><?php echo $text_shop_name; ?></span></label>
                        <div class="col-sm-10">
                            <input type="text" name="xmlprice_shopname" value="<?php echo $shop_name; ?>" placeholder="<?php echo $entry_shopname; ?>" id="input-xmlprice_shopname" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-xmlprice_company"><span data-toggle="tooltip" title="<?php echo $text_company; ?>"><?php echo $text_company; ?></span></label>
                        <div class="col-sm-10">
                            <input type="text" name="xmlprice_company" value="<?php echo $company; ?>" placeholder="<?php echo $text_company; ?>" id="input-xmlprice_company" class="form-control" />
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="xmlprice_currency"><span data-toggle="tooltip" title="<?php echo $text_curency; ?>"><?php echo $text_curency; ?></span></label>
                        <div class="col-sm-10">
                            <select name="xmlprice_currency" id="xmlprice_currency" class="form-control">
                            <?php foreach ($currencies as $currency) { ?>
                                <?php if ($currency['code'] == $xmlprice_currency) { ?>
                                <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $currency['code']; ?>"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
                                <?php } ?>
				<?php } ?>
                            </select>
                        </div>
                    </div>
		   
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="xmlprice_in_stock"><?php echo $entry_in_stock; ?></label>
                        <div class="col-sm-10">
                            <select name="xmlprice_in_stock" id="xmlprice_in_stock" class="form-control">
                            <?php foreach ($stock_statuses as $stock_status) { ?>
                                <?php if ($stock_status['stock_status_id'] == $xmlprice_in_stock) { ?>
                                <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
                                <?php } ?>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="xmlprice_out_of_stock"><?php echo $entry_out_of_stock; ?></label>
                        <div class="col-sm-10">
                            <select name="xmlprice_out_of_stock" id="xmlprice_out_of_stock" class="form-control">
                            <?php foreach ($stock_statuses as $stock_status) { ?>
                                <?php if ($stock_status['stock_status_id'] == $xmlprice_out_of_stock) { ?>
                                <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
                                <?php } ?>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
                <br/><br/>
                <div class='row'>
                    <div class='col-sm-1'></div>
                    <div class='col-sm-10'>
                        <ul class="nav nav-tabs">
                        <?php foreach($aggregators as $agg){ ?>
                            <li><a href="#tab-<?php echo $agg['name']; ?>" data-toggle="tab"><?php echo $agg['name']; ?></a></li>
                        <?php } ?>
                        </ul>
                        <div class="tab-content">
                        <?php foreach($aggregators as $aggr){ ?>
                            <div class="tab-pane" id="tab-<?php echo $aggr['name']; ?>">
                                <?php echo $aggr['content']; ?>
                            </div>  
                        <?php } ?>
                        </div>  
                    </div>
                    <div class='col-sm-1'></div>
                </div>
            </div>
        </div>
    </div>
    
 
    <div id="XmlModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="aggregator_state">
                        <h2><span id="name_of_agg"></span><span id="date_of_file"></span></h2>
                        <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width:0%">
                            0%
                        </div>
  </div>
                    </div>
                    <div id="list_of_xmlfiles"></div>
                   <input id="generator_link" class="hidden"  value="">
                </div>
                <div class="modal-footer">
                    <button id='generate_step' class="btn btn-success">START</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
     
    <div class="text-center">
        <span class="btn btn-primary" id="generate_all" data-link="<?php echo $generate_all; ?>"><?php echo $text_generate_all; ?></span>
    </div>
    
  </div>
  
<script type="text/javascript">
    $('#content').delegate('.settings_saver', 'click', function(){
        var form_id=$(this).data('form');
        var form=$('#'+form_id);
        var form_data=new FormData(form[0]);
        var url=form.attr('action');
        $.ajax({
            type: 'POST',
            url: url,
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response){
                form.parent().html(response);
                setTimeout(function(){
                    $('.alert-success').remove();
                }, 3000);
            }
        });
    });
    
     $('#content').delegate('.generator','click', function(){ 
        var link=$(this).data('link');
        var state=$(this).data('state');
        var agg=$(this).data('agg');
        $.ajax({
            type: 'POST',
            url: state,
            dataType: 'JSON',
            success: function(data){
                var date=data.date;
                var prepared=data.prepared;
                var total=data.total;
                updateProgress(date, prepared, total);
            }
        });
        $('#generator_link').val(link);
        $('#name_of_agg').html(agg);
        openModal();
    });
    
    $('#generate_all').click(function(){
        var link=$(this).data('link');
        $('#generator_link').val(link);
        openModal();
        $.ajax({
            type: 'GET',
            url: link,
            dataType: 'JSON',
            success: function(data){
                var xmlfiles=data.xmlfiles;
                var agg=data.aggregator;
                if(data.date){
                    var date=data.date;
                }else{
                    var date=0;
                }
                var prepared=data.prepared;
                var total=data.total;
                updateProgress(date, prepared, total, agg, xmlfiles);
                if(!date){
                    generation_step();
                }
            }
        });
    });
    
    $('#generate_step').click(function(){
        generation_step();
        $(this).hide();
        $('#ready_file_date').html('');
    });
    
    function generation_step(){
        var url=$('#generator_link').val();
        if(isModalOpen()){
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'JSON',
                success: function(data){
                    var xmlfiles=data.xmlfiles;
                    var agg=data.aggregator;
                    if(data.date){
                        var date=data.date;
                    }else{
                        var date=0;
                    }
                    var prepared=data.prepared;
                    var total=data.total;
                    updateProgress(date, prepared, total, agg, xmlfiles);
                    if(!date){
                        generation_step();
                    }
                }
            });
        }
    }
    
    function updateProgress(date, prepared, total, agg, xmlfiles){
        $('#name_of_agg').html(agg);
        if(xmlfiles!=undefined){
            $('#list_of_xmlfiles').html(xmlfiles);
        }
        var width=prepared/total*100;
        if(width){
           width+='%';
        }else{
           width='0px';
        }
        $('.progress-bar').css('width', width);
        $('.progress-bar').html(prepared+'/'+total);
        if(date){
            
            $('#date_of_file').html('<i class="fa fa-check" style="color:green; font-size: 150%;"></i>'+date);
            $('#generate_step').show();
        }
    }
    
    function openModal(){
        $('#XmlModal').modal({ backdrop: 'static', keybord: false });
    }
    
    function isModalOpen(){
        return $('#XmlModal').is(':visible');
    }
    
 
    
</script>
   
<?php echo $footer; ?>