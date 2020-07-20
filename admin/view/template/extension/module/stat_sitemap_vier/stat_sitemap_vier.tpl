<?php 
    //setting
    $hlp = 'data-toggle="tooltip"';
    $cls_hel = ' class="helpis"';
    $cls_tab = 'class="nav nav-tabs"';
    $ajax_err = true;
?>
<?php echo $header; echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div id="parent_blok">
        <div id="loader_img"></div>
    </div>
    <div class="container-fluid">
      <div class="pull-right">
      <?php if($bloc_bott) { ?>
        <span id="primenit" <?php echo $hlp; ?> title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></span>
        <?php } ?>
        <a href="<?php echo $cancel; ?>" <?php echo $hlp; ?> title="<?php echo $button_exit; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="box">
    <div id="error_warning">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
    </div>
    <div class="panel panel-default div_panel"> 
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit2; ?></h3>
        </div>
        <div class="content div_form panel-body">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
            <?php if($shabl == 'base') { ?>
                <ul <?php echo $cls_tab; ?> id="tabs">
                <?php foreach($tab_nav as $key => $val) { ?>
                <?php $cls_act = null; if($key === 0) {$cls_act = ' class="active"';} ?>
                    <li<?php echo $cls_act; ?>><a href="#<?php echo $val['href']; ?>" data-toggle="tab" class="linc" id="<?php echo $key; ?>"><?php echo $val['txt']; ?></a></li>
                <?php } ?>
                    <div id="ssuu">
                    <?php if($success) { ?>
                    <div class="seo_infa alert alert-success" style="margin-bottom:0px; padding:5px 17px; min-width:160px;"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                        <button type="button" class="close" data-dismiss="alert">&nbsp;&times;</button>
                    </div>
                    <?php } ?>
                    </div>
                </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab-general">
                    <div id="block_mod">
                        <div class="form-group main_bloc">
                            <div class="podskaz"><?php echo $text_main; ?></div>
                            <div class="sett_main">
                                <?php $pole = 'protocol'; ?>
                                <label class="control-label">
                                <span <?php echo $hlp; ?> title="<?php echo ${'help_'.$pole}; ?>"><?php echo ${'legnd_'.$pole}; ?></span>   
                                  <select name="stat_sitemap_vier_setting[<?php echo $pole; ?>]" class="select_fv">
                                    <?php foreach($arr_protocol as $val) {
                                            $selec = null;
                                            if(isset($stat_sitemap_vier_setting[$pole]) && ($stat_sitemap_vier_setting[$pole] == $val)) { $selec = ' selected="selected"'; } ?>
                                       <option value="<?php echo $val; ?>" <?php echo $selec; ?>><?php echo $val; ?></option>
                                    <?php } ?>
                                  </select>
                                </label>
                            </div>
                            <div class="sett_main">
                                <?php $pole = 'continue'; ?>
                                <label class="control-label">
                                <span <?php echo $hlp; ?> title="<?php echo ${'help_'.$pole}; ?>"><?php echo ${'legnd_'.$pole}; ?></span>   
                                <?php $chek = null; if(isset($stat_sitemap_vier_setting[$pole])) { $chek = ' checked="checked"';} ?>
                                <input class="" type="checkbox" name="stat_sitemap_vier_setting[<?php echo $pole ?>]" value="1" <?php echo $chek; ?> />
                                </label>
                            </div>
                            <div class="sett_main">
                                <?php $pole = 'ya'; ?>
                                <label class="control-label">
                                <span <?php echo $hlp; ?> title="<?php echo ${'help_'.$pole}; ?>"><?php echo ${'legnd_'.$pole}; ?></span>   
                                <?php $chek = null; if(isset($stat_sitemap_vier_setting[$pole])) { $chek = ' checked="checked"';} ?>
                                <input class="" type="checkbox" name="stat_sitemap_vier_setting[<?php echo $pole ?>]" value="1" <?php echo $chek; ?> />
                                </label>
                            </div>
                            <div class="sett_main">
                                <?php $pole = 'last_main'; ?>
                                <label class="control-label">
                                <span <?php echo $hlp; ?> title="<?php echo ${'help_'.$pole}; ?>"><?php echo ${'legnd_'.$pole}; ?></span>   
                                <?php $chek = null; if(isset($stat_sitemap_vier_setting[$pole])) { $chek = ' checked="checked"';} ?>
                                <input class="" type="checkbox" name="stat_sitemap_vier_setting[<?php echo $pole ?>]" value="1" <?php echo $chek; ?> />
                                </label>
                            </div>
                            <div class="sett_main">
                                <?php $pole = 'sek_key'; ?>
                                <label class="control-label">
                                <span <?php echo $hlp; ?> title="<?php echo ${'help_'.$pole}; ?>"><?php echo ${'legnd_'.$pole}; ?></span>   
                                <?php $value_key = null; if(isset($stat_sitemap_vier_setting[$pole]) && !empty($stat_sitemap_vier_setting[$pole])) {$value_key = $stat_sitemap_vier_setting[$pole];} ?>
                    <input class="input_center input_width_40" id="input_sek_key" type="text" name="stat_sitemap_vier_setting[<?php echo $pole ?>]" value="<?php echo $value_key; ?>" />
                                </label>
                            </div>
                            <div class="sett_main">
                                <?php $pole = 'delit'; ?>
                                <span id="<?php echo $pole; ?>1" class="button_submit bg_red"><?php echo ${'button_'.$pole}; ?></span>
                            </div>
                            <?php $pole = 'sitemap'; ?>
                            <div class="sett_main resultat" id="rez_<?php echo $pole ?>">
                                <?php echo $arr_sitemap[$pole]; ?>
                            </div>
                        </div><!-- main_bloc -->
                        <?php foreach($arr_pole as $pole) { ?>
                        <div class="form-group">
                            <?php if($pole == 'others') { ?>
                            <div class="sett_main width_sett">
                                <label class="control-label">
                                    <?php $chek = null; if(isset($stat_sitemap_vier_setting[$pole]['status'])) { $chek = ' checked="checked"';} ?>
                                    <input class="" type="checkbox" name="stat_sitemap_vier_setting[<?php echo $pole ?>][status]" value="1" <?php echo $chek; ?> />
                                    <span <?php echo $hlp; ?> title="<?php echo ${'help_'.$pole}; ?>"><?php echo ${'legnd_'.$pole}; ?></span>
                                </label>
                            </div>
                            <?php } else { ?>
                            <?php $legend_pole = ${'legnd_'.$pole}; $help = $help_sitemap.' '.$legend_pole; $legnd = $legnd_sitemap.' '.$legend_pole; ?>
                            <div class="sett_main width_sett">
                                <label class="control-label">
                                    <?php $chek = null; if(isset($stat_sitemap_vier_setting[$pole]['status'])) { $chek = ' checked="checked"';} ?>
                                    <input class="" type="checkbox" name="stat_sitemap_vier_setting[<?php echo $pole ?>][status]" value="1" <?php echo $chek; ?> />
                                    <span <?php echo $hlp; ?> title="<?php echo $help; ?>"><?php echo $legnd; ?></span>
                                </label>
                            </div>
                            <div class="sett_main">
                                <label class="control-label">
                                    <span <?php echo $hlp; ?> title="<?php echo $help_priority.' '.${'legnd_'.$pole}; ?>"><?php echo $legnd_priority; ?></span>   
                                  <select name="stat_sitemap_vier_setting[<?php echo $pole ?>][priority]" class="select_fv">
                                    <?php foreach($arr_priority as $val) {
                                            $selec = null; 
                                            if(isset($stat_sitemap_vier_setting[$pole]['priority']) && ($stat_sitemap_vier_setting[$pole]['priority'] == $val)) { $selec = ' selected="selected"'; } ?>
                                       <option value="<?php echo $val; ?>" <?php echo $selec; ?>><?php echo $val; ?></option>
                                    <?php } ?>
                                  </select>
                                </label>
                            </div>
                            <div class="sett_main">
                                <label class="control-label">
                                    <span <?php echo $hlp; ?> title="<?php echo $help_changefreq.' '.${'legnd_'.$pole}; ?>"><?php echo $legnd_changefreq; ?></span>   
                                  <select name="stat_sitemap_vier_setting[<?php echo $pole ?>][changefreq]" class="select_fv">
                                    <?php foreach($arr_changefreq as $val) {
                                            $selec = null;
                                            if(isset($stat_sitemap_vier_setting[$pole]['changefreq']) && ($stat_sitemap_vier_setting[$pole]['changefreq'] == $val)) { $selec = ' selected="selected"'; } ?>
                                       <option value="<?php echo $val; ?>" <?php echo $selec; ?>><?php echo $val; ?></option>
                                    <?php } ?>
                                  </select>
                                </label>
                            </div>
                            <?php if(($pole == 'product') || ($pole == 'category')) { ?>
                            <div class="sett_main">
                                <label class="control-label">
                                    <span <?php echo $hlp; ?> title="<?php echo $help_lastmod.' '.${'legnd_'.$pole}; ?>"><?php echo $legnd_lastmod; ?></span>
                                    <?php $chek = null; if(isset($stat_sitemap_vier_setting[$pole]['lastmod'])) { $chek = ' checked="checked"';} ?>
                                    <input class="" type="checkbox" name="stat_sitemap_vier_setting[<?php echo $pole ?>][lastmod]" value="1" <?php echo $chek; ?> />
                                </label>
                            </div>
                            <div class="sett_main">
                                <label class="control-label">
                                    <span <?php echo $hlp; ?> title="<?php echo $help_images.' '.${'legnd_'.$pole}.' '.$help_warning.' '.$help_ya_warning; ?>"><?php echo $legnd_images; ?></span>
                                    <?php $chek = null; if(isset($stat_sitemap_vier_setting[$pole]['images'])) { $chek = ' checked="checked"';} ?>
                                    <input class="" type="checkbox" name="stat_sitemap_vier_setting[<?php echo $pole ?>][images]" value="1" <?php echo $chek; ?> />
                                </label>
                            </div>
                                <?php } ?>
                            <?php } ?>
                            <div class="sett_main resultat" id="rez_<?php echo $pole ?>">
                                <?php echo $arr_sitemap[$pole]; ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <?php } ?>
                        <div class="form-group txt_right main_bloc">
                            <div class="sett_main">
                                <?php $pole = 'add'; ?>
                                <span id="<?php echo $pole; ?>1" class="button_submit bg_grey"><?php echo ${'button_'.$pole}; ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="sett_main">
                               <div class="podskaz"><?php echo $text_htaccess; ?></div> 
                            </div>
                        </div>
                    </div><!-- end block_mod -->
                    <div class="clear"></div>
                </div><!-- end #general -->
            </div><!-- / tab-content -->
            <?php } elseif($shabl == 'lic') { ?>
            <div id="tab-<?php echo $shabl; ?>">
                <div class="form-group">
                    <div class="sett_main">
                        <span><?php echo $legnd_lic; ?><span class="color_red">*</span></span>
                        <input class="width_300" type="text" value="" name="lic_key" />
                        <input type="submit" name="add_key" value="<?php echo $bott_lic; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="sett_main">
                        <span><?php echo $legnd_get_key; ?></span>
                        <input type="submit" name="get_key" value="<?php echo $bott_get_key; ?>" />
                    </div>
                </div>
            </div>
            <?php } ?>
            </form>
        </div><!-- end class="panel-body" -->
    </div><!-- end class="panel panel-default" -->
    <div class="jir marg_left_10"><?php echo $text_avtor; ?> <a href="https://liveopencart.ru/vier" target="_blank">Vier</a></div>
  </div>
</div><!-- end id="content" -->
<?php if($shabl != 'lic') { ?>
<script>
    function successPole(text) {
        return '<div class="seo_infa alert alert-success" style="margin-bottom:0px; padding:5px 17px; min-width:160px;"><i class="fa fa-check-circle"></i> '+text+'<button type="button" class="close" data-dismiss="alert">&nbsp;&times;</button></div>';
    }
    function errorPole(text) {
        return '<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> '+text+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
    }
    function clearPoleAll() {
        $('#ssuu').empty();
        $('#error_warning').empty();
        $('.resultat').empty();
    }
    function showLoadImg() {
        $("#parent_blok").css('display','block');
        $("#loader_img").show();
    }
    function hideLoadImg() {
        $("#parent_blok").css('display','none');
        $("#loader_img").hide();  
    }
    function preparPost() {
        var txt_post = "[name^='stat_sitemap_vier']";
        return $(txt_post).serialize();
    }
    function ajs_post(post_data) {
        clearPoleAll();
        $.ajax({
            url: '<?php echo $ajax_put; ?>'
            ,type: 'POST'
            ,async: true
            ,dataType: 'json'
            ,cache: false
            ,data: post_data
            ,beforeSend: function(){
                showLoadImg();
            }
            ,success: function(data) {
                if(data.error_warning) {
                    $('#error_warning').html(errorPole(data.error_warning));
                }
                if(data.succ) {
                    $('#ssuu').html(successPole(data.succ));
                }
                if(data.result) {
                    $.each(data.result,function(key, data) {
                            $("#rez_"+key).html(data);
                        });
                }
            }
            ,complete: function(){
                hideLoadImg();
            }
            <?php if($ajax_err) { ?>
            ,error: function(jqXHR, textStatus) {
                var text_error = '';
                text_error += 'code: '+jqXHR.readyState;
                text_error += (jqXHR.status) ? ', status: '+jqXHR.status : '';
                text_error += (textStatus) ? ', textStatus: '+textStatus : '';
                text_error += (jqXHR.responseText) ? ', "responseText:" '+jqXHR.responseText : '';
                $('#error_warning').html(errorPole('ERROR!!! '+text_error));
            }
            <?php } ?>
        });
    }
    $('#primenit').on('click', function(){
        var post_data = {};
        post_data["primenit"] = preparPost();
        ajs_post(post_data);
    });
    $('#add1').on('click', function() {
        var post_data = {}
        post_data["add"] = preparPost();
        ajs_post(post_data);
    });
    $('#delit1').on('click', function() {
        var post_data = {}
        post_data["delit"] = preparPost();
        ajs_post(post_data);
    });
</script>
<?php } ?>
<?php echo $footer; ?>