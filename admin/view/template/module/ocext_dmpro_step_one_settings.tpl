<?php if($format_data=='csv'){ ?>

<input name="odmpro_tamplate_data[format_data]" type="hidden" value="<?php echo $format_data ?>" />

<table class="table table-bordered table-hover">
          <tbody>
                <tr>
                    <td class="text-left">
                        <?php echo $entry_odmpro_tamplate_data_select ?>
                    </td>
                    <td class="text-left">
                        <div class="input-group">
                            
                            <?php if($demo_mode && $type_process=='import'){ ?>
                                <div class="info-box-modal"><?php echo $text_info_box_modal_step_1_import_csv ?></div>
                                <div class="arrow down"></div>
                            <?php } ?>
                            
                        <?php if(!$tamplates_data){ ?>
                            <select name="odmpro_tamplate_data[id]"  class="form-control">
                                <option value="0" ><?php echo $entry_odmpro_tamplate_data_empty; ?></option>
                            </select>
                        <?php }else{ ?>
                            <select onchange="getStepOneSettings('<?php echo $format_data ?>',this.value,'<?php echo $type_process ?>');" name="odmpro_tamplate_data[id]"  class="form-control">
                                            <option value="0" ><?php echo $entry_odmpro_tamplate_data_new; ?></option>
                                    <?php foreach($tamplates_data as $tamplate_data_key => $tamplate_data){ ?>
                                        <?php if(isset($tamplate_data_selected['id']) && $tamplate_data_selected['id']== $tamplate_data_key){ ?>
                                            <option value="<?php echo $tamplate_data_key ?>" selected="" ><?php echo $tamplate_data['name']; ?></option>
                                        <?php }else{ ?>
                                            <option value="<?php echo $tamplate_data_key ?>" ><?php echo $tamplate_data['name']; ?></option> 
                                        <?php } ?>
                                    <?php } ?>
                            </select>
                        <?php } ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">
                        <?php echo $entry_odmpro_csv_delimiter ?>
                    </td>
                    <td class="text-left">
                        <div class="input-group">
                            <input name="odmpro_tamplate_data[csv_delimiter]" value="<?php echo $tamplate_data_selected['csv_delimiter']; ?>"  class="form-control" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">
                        <?php echo $entry_odmpro_csv_enclosure ?>
                    </td>
                    <td class="text-left">
                        <div class="input-group">
                            <input name="odmpro_tamplate_data[csv_enclosure]" value='<?php if(isset($tamplate_data_selected['csv_enclosure'])){ echo $tamplate_data_selected['csv_enclosure']; }else{ echo '"'; } ?>'  class="form-control" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">
                        <?php echo $entry_odmpro_csv_escape ?>
                    </td>
                    <td class="text-left">
                        <div class="input-group">
                            <input name="odmpro_tamplate_data[csv_escape]" value='<?php if(isset($tamplate_data_selected['csv_escape'])){ echo $tamplate_data_selected['csv_escape']; }else{ echo '\\'; } ?>'  class="form-control" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">
                        <?php echo $entry_odmpro_encoding ?>
                    </td>
                    <td class="text-left">
                        <div class="input-group">
                        <select name="odmpro_tamplate_data[encoding]" class="form-control">
                                <option value="0" ><?php echo $entry_select; ?></option>
                                    <?php foreach($encodings as $encoding){ ?>
                                        <?php if($tamplate_data_selected['encoding']== $encoding){ ?>
                                <option value="<?php echo $encoding ?>" selected="" ><?php echo $encoding; ?></option>
                                        <?php }else{ ?>
                                <option value="<?php echo $encoding ?>" ><?php echo $encoding; ?></option> 
                                        <?php } ?>
                                    <?php } ?>
                        </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">
                        <?php echo $text_log_title ?>
                    </td>
                    <td class="text-left">
                        <div class="input-group">
                            <select name="odmpro_tamplate_data[log_status]" class="form-control">
                                    <?php if($tamplate_data_selected['log_status']){ ?>
                                        <option value="1" selected="" ><?php echo $entry_enable; ?></option>
                                        <option value="0" ><?php echo $entry_disable; ?></option>
                                    <?php }else{ ?>
                                        <option value="1"  ><?php echo $entry_enable; ?></option>
                                        <option value="0" selected=""><?php echo $entry_disable; ?></option> 
                                    <?php } ?>
                            </select>
                        </div>
                        <br>
                        <div class="input-group">
                            <label><?php echo $text_log_details; ?></label><br>
                            <select name="odmpro_tamplate_data[log_details]" class="form-control">
                                    <?php if($tamplate_data_selected['log_details']){ ?>
                                        <option value="1" selected="" ><?php echo $entry_enable; ?></option>
                                        <option value="0" ><?php echo $entry_disable; ?></option>
                                    <?php }else{ ?>
                                        <option value="1"  ><?php echo $entry_enable; ?></option>
                                        <option value="0" selected=""><?php echo $entry_disable; ?></option> 
                                    <?php } ?>
                            </select>
                        </div><br>
                        <div class="input-group">
                            <label><?php echo $text_log_update; ?></label><br>
                            <select name="odmpro_tamplate_data[log_update]" class="form-control">
                                    <?php if($tamplate_data_selected['log_update']){ ?>
                                        <option value="1" selected="" ><?php echo $entry_enable; ?></option>
                                        <option value="0" ><?php echo $entry_disable; ?></option>
                                    <?php }else{ ?>
                                        <option value="1"  ><?php echo $entry_enable; ?></option>
                                        <option value="0" selected=""><?php echo $entry_disable; ?></option> 
                                    <?php } ?>
                            </select>
                        </div><br>
                        <div class="input-group">
                            <label><?php echo $text_log_html; ?></label><br>
                            <select onchange="if(this.value=='1'){ $('#log_file_name_link_type').text('.htm'); }else{ $('#log_file_name_link_type').text('.txt'); } $('input[name=\'odmpro_tamplate_data[log_file_name]\']').change(); " name="odmpro_tamplate_data[log_html]" class="form-control">
                                    <?php if($tamplate_data_selected['log_update']){ ?>
                                        <option value="1" selected="" ><?php echo $entry_enable; ?></option>
                                        <option value="0" ><?php echo $entry_disable; ?></option>
                                    <?php }else{ ?>
                                        <option value="1"  ><?php echo $entry_enable; ?></option>
                                        <option value="0" selected=""><?php echo $entry_disable; ?></option> 
                                    <?php } ?>
                            </select>
                        </div><br>
                        <div class="input-group" style="width: 100%">
                            <label><?php echo $text_log_file_name; ?></label><br>
                            <table >
                                <tr>
                                    <td><?php echo HTTPS_CATALOG.'image/' ?></td>
                                    <td><input style="display: inline-block; margin-bottom: 5px;" onchange="update_link('#log_file_name_link','<?php echo HTTPS_CATALOG.'image/' ?>',this.value,$('#log_file_name_link_type').text())" name="odmpro_tamplate_data[log_file_name]" value='<?php if(isset($tamplate_data_selected["log_file_name"])){ echo $tamplate_data_selected["log_file_name"]; }else{ echo ""; } ?>'  class="form-control" /></td>
                                    <td id="log_file_name_link_type">.htm</td>
                                </tr>
                            </table>
                            
                            <table class="table table-bordered table-hover">
                                    <tr>  
                                        <td >
                                            <input   class="form-control" id="log_file_name_link"  readonly="" onclick="$(this).select()" value="<?php echo HTTPS_CATALOG.'image/'.$tamplate_data_selected["log_file_name"]; ?>"/>
                                        </td>
                                    </tr>
                                    
                            </table>
                            
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">
                        <?php echo $entry_odmpro_file ?>
                    </td>
                    <td class="text-left">
                        
                        
                        <?php if($type_process=='import'){ ?>
                        
                             <?php
                             
                             $import_css = "";
                             $export_css = " style='display:none' ";
                             
                             ?>
                        
                        <?php }elseif($type_process=='export'){ ?>
                        
                            <?php
                             
                             $import_css = " style='display:none' ";
                             $export_css = "";
                             
                             ?>
                        
                        <?php } ?>
                        
                        <div  <?php echo $import_css; ?> >
                        
                            <?php if($entry_odmpro_file_upload_error_type){ ?>
                                <div class="alert alert-danger"><?php echo $entry_odmpro_file_upload_error_type ?></div>
                            <?php } ?>
                            <div class="input-group">
                                <input type="text" name="odmpro_tamplate_data[file_upload]" value="<?php echo $tamplate_data_selected['file_upload'] ?>" placeholder="<?php echo $entry_odmpro_file_upload ?>" id="input-filename" class="form-control" />
                                <span class="input-group-btn">
                                    <button type="button" id="button-upload" data-loading-text="<?php echo $text_wite; ?>" class="btn btn-primary"><i class="fa fa-upload"></i> <?php echo $entry_odmpro_file_upload ?></button>
                                </span>
                            </div>
                            <div class="input-group" style="margin-top: 7px;">
                                <?php echo $entry_odmpro_file_url; ?> <input type="text" name="odmpro_tamplate_data[file_url]" value="<?php echo $tamplate_data_selected['file_url'] ?>" placeholder="<?php echo $entry_odmpro_file_url ?>" id="input-filename" class="form-control" />
                            </div>
                        
                            
                            <?php if($type_process=='import'){ ?>
                            
                                <?php if($text_anyxml_status_false){ ?>
                                <div class="alert alert-info" style="margin-top: 5px;"><?php echo $text_anyxml_status_false; ?></div>
                                <?php }else{ ?>
                                
                                <label style="margin-top: 10px; color: crimson"><?php echo $text_anyxml_xml_upload; ?></label>
                                <select name="odmpro_tamplate_data[anyxml_xml_upload]" class="form-control">
                                        <?php if($tamplate_data_selected['anyxml_xml_upload']){ ?>
                                            <option value="1" selected="" ><?php echo $entry_enable; ?></option>
                                            <option value="0" ><?php echo $entry_disable; ?></option>
                                        <?php }else{ ?>
                                            <option value="1"  ><?php echo $entry_enable; ?></option>
                                            <option value="0" selected=""><?php echo $entry_disable; ?></option> 
                                        <?php } ?>
                                </select>
                                
                                
                                
                                
                                <label style="margin-top: 10px;; color: lightseagreen">
                        <?php echo $text_xml_specification ?>
                    </label>
                        <select name="odmpro_tamplate_data[xml_specification]" class="form-control">
                                <option value="0" ><?php echo $text_xml_specification_select; ?></option>
                                <?php foreach($xml_specifications as $xml_specification => $xml_specification_text){ ?>
                                        <?php if(isset($tamplate_data_selected['xml_specification']) && $tamplate_data_selected['xml_specification'] == $xml_specification){ ?>
                                <option value="<?php echo $xml_specification ?>" selected="" ><?php echo $xml_specification_text; ?></option>
                                        <?php }else{ ?>
                                <option value="<?php echo $xml_specification ?>" ><?php echo $xml_specification_text; ?></option> 
                                        <?php } ?>
                                <?php } ?>
                        </select>
                                
                                
                                
                                
                                
                                
                                
                                <?php } ?>
                            
                            <?php } ?>
                            
                        
                       </div> 
                        
                        <div <?php echo $export_css; ?> >
                        
                            <div class="input-group"  style="width: 100%">
                                <label><?php echo $entry_export_file_name ?></label>
                                
                                <table>
                                    <tr>
                                        <td><?php echo HTTPS_CATALOG.'image/' ?></td>
                                        <td><input style="margin-bottom: 5px;" type="text" onchange="update_link('#export_file_name_link','<?php echo HTTPS_CATALOG.'image/' ?>',this.value,'.csv')" name="odmpro_tamplate_data[export_file_name]" value="<?php echo $tamplate_data_selected['export_file_name'] ?>" placeholder="<?php echo $entry_export_file_name ?>" class="form-control" /></td>
                                        <td>.csv</td>
                                    </tr>
                                </table>
                                <table class="table table-bordered table-hover">
                                    <tr>  
                                        <td colspan="3">
                                        <input   class="form-control" id="export_file_name_link"  readonly="" onclick="$(this).select()" value="<?php echo HTTPS_CATALOG.'image/'.$tamplate_data_selected['export_file_name'].'.csv' ?>"/>
                                        </td>
                                    </tr>
                                    
                                </table>
                                
                                <label style="margin-top: 10px;"><?php echo $entry_export_file_name_write_time ?></label>
                                    <select name="odmpro_tamplate_data[file_name_write_time]" class="form-control">
                                            <?php if($tamplate_data_selected['file_name_write_time']){ ?>
                                                <option value="1" selected="" ><?php echo $entry_enable; ?></option>
                                                <option value="0" ><?php echo $entry_disable; ?></option>
                                            <?php }else{ ?>
                                                <option value="1"  ><?php echo $entry_enable; ?></option>
                                                <option value="0" selected=""><?php echo $entry_disable; ?></option> 
                                            <?php } ?>
                                    </select>
                                
                            </div>
                        
                        </div> 
                        
                    </td>
                </tr>
                
                <tr>
                    <td class="text-left">
                        <?php echo $entry_odmpro_tamplate_data_level ?>
                    </td>
                    <td class="text-left">
                        <div class="input-group">
                        <select name="odmpro_tamplate_data[level]" class="form-control">
                                        <?php if($tamplate_data_selected['level']){ ?>
                                <option value="1" selected="" ><?php echo $entry_odmpro_tamplate_data_level_1; ?></option>
                                <option value="0" ><?php echo $entry_odmpro_tamplate_data_level_0; ?></option>
                                        <?php }else{ ?>
                                <option value="1"  ><?php echo $entry_odmpro_tamplate_data_level_1; ?></option>
                                <option value="0" selected=""><?php echo $entry_odmpro_tamplate_data_level_0; ?></option> 
                                        <?php } ?>
                        </select>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td class="text-left">
                        <?php echo $entry_odmpro_language ?>
                    </td>
                    <td class="text-left">
                        <div class="input-group">
                        <select name="odmpro_tamplate_data[language_id]" class="form-control">
                                <option value="0" ><?php echo $entry_select; ?></option>
                                <?php foreach($languages as $language_id => $language){ ?>
                                        <?php if($tamplate_data_selected['language_id'] == $language_id){ ?>
                                <option value="<?php echo $language_id ?>" selected="" ><?php echo $language['name']; ?></option>
                                        <?php }else{ ?>
                                <option value="<?php echo $language_id ?>" ><?php echo $language['name']; ?></option> 
                                        <?php } ?>
                                <?php } ?>
                        </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">
                        <?php echo $entry_odmpro_currency ?>
                    </td>
                    <td class="text-left">
                        <div class="input-group">
                        <select name="odmpro_tamplate_data[currency_code]" class="form-control">
                                <option value="0" ><?php echo $entry_select; ?></option>
                                <?php foreach($currencies as $currency_code => $currency){ ?>
                                        <?php if($tamplate_data_selected['currency_code'] == $currency_code){ ?>
                                <option value="<?php echo $currency_code ?>" selected="" ><?php echo $currency['name']; ?></option>
                                        <?php }else{ ?>
                                <option value="<?php echo $currency_code ?>" ><?php echo $currency['name']; ?></option> 
                                        <?php } ?>
                                <?php } ?>
                        </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">
                        <?php echo $entry_odmpro_store ?>
                    </td>
                    <td class="text-left">
                        <div class="well well-sm" style="max-height: 70px; overflow: auto; margin-bottom: 0px;">
                        <?php foreach ($stores as $store) { ?>
                        <div class="checkbox">
                          <label>
                            <?php if ( isset($tamplate_data_selected['store_id'][$store['store_id']]) ) { ?>
                                <input type="checkbox" name="odmpro_tamplate_data[store_id][<?php echo $store['store_id'] ?>]" value="<?php echo $store['store_id'] ?>" checked="checked" />
                            <?php echo $store['name']; ?>
                            <?php } else { ?>
                                <input type="checkbox" name="odmpro_tamplate_data[store_id][<?php echo $store['store_id'] ?>]" value="<?php echo $store['store_id'] ?>" />
                            <?php echo $store['name']; ?>
                            <?php } ?>
                          </label>
                        </div>
                        <?php } ?>
                      </div>
                    </td>
                </tr>
            </tbody>
</table>
    <?php if($demo_mode && $type_process=='import'){ ?>
        <div class="info-box-modal"><?php echo $text_info_box_modal_step_2_import_csv ?></div>
        <div class="arrow down"></div>
        <div class="clearfix"></div>
    <?php } ?>

    <?php if($type_process=='import'){ ?>

        <a onclick="getStepTwoSettings('<?php echo $type_process ?>')" class="btn btn-primary btn-step-two"><?php echo $entry_download_field_to_file; ?></a>

    <?php }elseif($type_process=='export'){ ?>

    <script type="text/javascript"><!--
    
        $(document).ready(function() {

            getStepTwoSettings('<?php echo $type_process ?>');

        });

    //--></script> 
    
    <?php } ?>

<?php }else{ ?>

    <?php echo $entry_odmpro_format_data_redirect; ?>

<?php } ?>
<script type="text/javascript"><!--
    
        $(document).ready(function() {
            $('input[name=\'odmpro_tamplate_data[log_file_name]\']').change();
        });

    //--></script> 

<script type="text/javascript"><!--
$('#button-upload').on('click', function() {
	$('#form-upload').remove();
	
	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');
	
	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}
	
	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);		
			
			$.ajax({
				url: 'index.php?route=catalog/download/upload&token=<?php echo $token; ?>',
				type: 'post',		
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,		
				beforeSend: function() {
					$('#button-upload').button('loading');
				},
				complete: function() {
					$('#button-upload').button('reset');
				},	
				success: function(json) {
					if (json['error']) {
						alert(json['error']);
					}
								
					if (json['success']) {
						alert(json['success']);
						$('input[name=\'odmpro_tamplate_data[file_upload]\']').attr('value', json['filename']);
					}
				},			
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});


$(document).ready(function() {
    
    

});

//--></script> 