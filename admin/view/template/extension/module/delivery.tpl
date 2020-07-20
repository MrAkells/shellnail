<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-delivery" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
          
          <div id="settings" class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <form id="form-data">

                            <div class="form-group">
                                <label for="<?php echo $sender ?>"><?php echo $sender ?></label>
                                <input id="send_sender" type="text" class="form-control" name="send_sender" placeholder="<?php echo $sender_default ?>"/>
                            </div>

                            <div class="form-group">
                                <label for="<?php echo $head ?>"><?php echo $head ?></label>
                                <input id="send_head" type="text" class="form-control" name="send_head" placeholder="<?php echo $head_default ?>"/>
                            </div> 

                            <textarea id="send_content" name="send_content"></textarea>
                           
                            <div class="row">
                                <div class="col-md-8">
                                    <?php echo $message_user ?>
                                </div>    
                                <div class="col-md-4">   
                                    <a  class="btn btn-info pull-right form_send" onclick="send('<?php echo $url ?>')"><?php echo $text_send ?></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>    
                
                <div style="display: none;" class="message"></div>
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-delivery" class="form-horizontal">
                            <div class="form-group">
                              <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                              <div class="col-sm-10">
                                <select name="delivery_status" id="input-status" class="form-control">
                                  <?php if ($delivery_status) { ?>
                                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                  <option value="0"><?php echo $text_disabled; ?></option>
                                  <?php } else { ?>
                                  <option value="1"><?php echo $text_enabled; ?></option>
                                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>      
                
            </div>
            <div class="col-md-4">
                
                <div class="open_widget_groups btn btn-info"><?php echo $show_list_groups ?></div>
                <div style="display: none;" class="widget_groups">
                    <div class="select all panel-heading"><?php echo $choice_checked ?></div>
                    <form id="send_groups">
                        <?php if($groups){ ?>
                            <?php $i = 0; foreach ($groups as $group){ ?>                            
                            <div class="input-block panel-heading">
                                <input type="checkbox"  name="<?php echo $i ?>" value="<?php echo $group['group_id']?>" />
                                <div class="check_send">
                                    </span> <?php echo $group['group_name'] ?>
                                </div>   
                            </div>
                            <?php $i++; } ?>
                        <?php } ?>
                    </form>    
                </div>
                
                <div class="open_widget btn btn-info"><?php echo $show_list ?></div>
                <div style="display: none;" class="widget">
                    <div class="select panel-heading all"><?php echo $choice_checked ?></div>
                    <form id="send_menu">
                        <?php if($subscribers){ ?>
                            <?php foreach ($subscribers as $key => $value){ ?>
                            <div class="input-block panel-heading">
                                <input disabled="disabled" type="checkbox" name="<?php echo $value['name'] ?>" value="<?php echo $value['email'] ?>" />
                                <div class="check_send">
                                    <span><?php echo $text_name ?><?php echo $value['name'] ?> </span> <span><i class="fa fa-envelope"></i><?php echo $value['email'] ?></span> <span><i class="fa fa-phone"></i> <?php echo $value['phone'] ?></span></div>                              
                            </div>
                            <?php } ?>
                        <?php } ?>
                    </form>    
                </div>
                
            </div>
        </div>
          
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>

<script>

    $('#send_content').summernote({
	height: 300
    });
</script>

<script>
    function send(url)
    {      
        
        var obj1 = {};
            obj1['send_sender'] = $('#send_sender').val();
            obj1['send_head'] = $('#send_head').val();
            obj1['send_content'] = $('#form-data').find('.note-editable').html();        
       
        var obj2 = {};
        $('#send_menu input[checked]').each(function() {
            var v = $(this).val();
            var k = $(this).attr('name');
            obj2[k] = v;
        });
        var obj3 = {};       
        $('#send_groups input[checked]').each(function() {
            var v = $(this).val();
            var k = $(this).attr('name');
            obj3[k] = v;
        });
        
        var dataJson = { message: obj1, settings: obj2, groups:   obj3 };

        $.ajax({
            url: url,
            type: 'post',
            data: JSON.stringify(dataJson),
            contentType: 'JSON',
            dataType: 'text',
            beforeSend: function() {
                $('#button-send').attr('disabled', true);
            },
            complete: function() {
                $('#button-send').attr('disabled', false);
            },
            success: function(answer)
            {
                if (answer === 'success') {
                    $('.message').text('<?php echo $success_send ?>').show(200);
                }
                else if(answer === 'error') {
                    $('.message').text('<?php echo $error ?>').show(200);
                }
                else if(answer === 'error_groups'){
                    $('.message').text('<?php echo $error_group ?>').show(200);
                }                    

            }
        });
    }
</script>


<script>
        jQuery(document).ready(function($)
        {
            function checkedAll(elem){
                var inputs = $(elem).siblings('form').find('input');
                inputs.each(function( index ) {
                    this.checked = true; $(this).attr('checked', true);
                });
            }
            
            function oncheckedAll(elem){
                var inputs = $(elem).siblings('form').find('input');
                inputs.each(function( index ) {
                    this.checked = false; $(this).attr('checked', false);
                });
            }
           
            $('.select').on('click', function() {
                if ($(this).is('.all') === true) {
                    $(this).text('<?php echo $delete_checked ?>');
                    $(this).removeClass('all').addClass('del');
                    checkedAll($(this));
                }
                else if ($(this).is('.del') === true) {
                    $(this).text('<?php echo $choice_checked ?>');
                    $(this).removeClass('del').addClass('all');
                    oncheckedAll($(this));
                }
            });
          
            $('.check_send').on('click', function() 
            {
                var elem = $(this).siblings('input')[0];
                if (!elem.checked)
                {
                   elem.checked = true; $(elem).attr('checked', true);
                }
                else {
                    elem.checked = false; $(elem).attr('checked', false);
                }
            });

            $('.open_widget').on('click', function() {
                if ($('.widget').css('display') === 'none') {
                    $(this).text('<?php echo $hide_list ?>');
                    $('.widget').slideDown(500);
                }
                else if ($('.widget').css('display') === 'block') {
                    $(this).text('<?php echo $show_list ?>');
                    $('.widget').slideUp(300);
                }
            });
            
             $('.open_widget_groups').on('click', function() {                
                if ($('.widget_groups').css('display') === 'none') {
                    $(this).text('<?php echo $hide_list_groups ?>');
                    $('.widget_groups').slideDown(500);
                }
                else if ($('.widget_groups').css('display') === 'block') {
                    $(this).text('<?php echo $show_list_groups ?>');
                    $('.widget_groups').slideUp(300);
                }
            });

        });

    </script>
  
    <style>
        .open_widget_groups, .open_widget{
            width: 310px;
            font-size: 14px;
            margin-top: 20px;
        }
        .widget_groups, .widget{
            width: 310px;
        }
        .check_send {
            cursor: pointer;
            position: absolute;
            top: 0;
            padding-left: 20px;
            height: 50px;
            padding-top: 10px;
        }
        .check_send{
             cursor: pointer;
        }
        .check_send input {
            float: left;
            margin-right: 10px;
           
        }        
        .form_send{
            margin:10px 0;
            width: 120px;
            height: 25px;
            line-height:6px;
            font-size: 16px;
            text-align: center;
        }
        .select.panel-heading{
            cursor: pointer;
        }
    </style>