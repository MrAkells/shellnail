<?php if(!$errors){ ?>

<?php if($format_data=='csv'){ ?>
<ul  class="nav nav-tabs sh-tab-n" >
    <li class="active sh-tab"><a onclick="showHide('.stepTwoTempl');" style="cursor: pointer"><h2><?php echo $text_step_2_synchronization ?></h2></a></li></ul>
    <div class="stepTwoTempl">
<?php if($type_process=='import'){ ?>
<a onclick="showHide('#check_row_info')" class="btn btn-danger" style="margin-bottom: 25px;">
            <span><?php echo $text_check_row ?></span>
        </a>

<?php if(isset($tamplate_data_selected['getCSVAsHTML']) && $tamplate_data_selected['getCSVAsHTML']){ ?>

        <a target="_blank" href="<?php echo $tamplate_data_selected['getCSVAsHTML']; ?>" class="btn btn-danger" style="margin-bottom: 25px;">
            <span><?php echo $text_getCSVAsHTML ?></span>
        </a>
    <a onclick="showHide('#check_row_info_2')"  class="btn btn-danger" style="margin-bottom: 25px;">
            <span><?php echo $entry_anyxml_link_on_file ?></span>
        </a>
<div id="check_row_info_2" class="well" style="display: none;margin-bottom: 25px;">
            <table  class="table table-bordered table-hover">
    <tr>
                    <td class="text-left">
                        <?php echo $entry_anyxml_link_on_file ?>
                    </td>
                    <td class="text-left">
                        <div class="input-group">
                            <?php echo $anyxml_link_on_file; ?>
                        </div>
                    </td>
                </tr>
    <tr>
                    <td class="text-left">
                        <?php echo $entry_odmpro_csv_delimiter ?>
                    </td>
                    <td class="text-left">
                        <div class="input-group">
                            <?php echo $tamplate_data_selected['csv_delimiter']; ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">
                        <?php echo $entry_odmpro_csv_enclosure ?>
                    </td>
                    <td class="text-left">
                        <div class="input-group">
                            <?php echo $tamplate_data_selected['csv_enclosure']; ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">
                        <?php echo $entry_odmpro_csv_escape ?>
                    </td>
                    <td class="text-left">
                        <div class="input-group">
                            <?php echo $tamplate_data_selected['csv_escape']; ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">
                        <?php echo $entry_odmpro_encoding ?>
                    </td>
                    <td class="text-left">
                        <div class="input-group">
                        <?php echo  $tamplate_data_selected['encoding'] ?>
                        </div>
                    </td>
                </tr>
    
</table>
</div>
<?php } ?>
        
        
        <div id="check_row_info" class="well" style="display: none;margin-bottom: 25px;">
        
            <p class="alert alert-success"><?php echo $text_count_fields ?>: <b><?php echo $count_fields ?></b>, <?php echo $text_count_rows ?>: <b><?php echo $count_rows ?></b></p>
        
        <p>
            <?php echo $text_check_row_info ?>
        </p>

        <div class="well well-sm" style="overflow-x: auto; background: white; margin-bottom: 0px;">

                <?php if($csv_data_last_row_for_view){ ?>

                    <table class="table table-bordered table-hover">
                        <tr>
                            <?php foreach($data_rows as $field){ ?>
                                <td>
                                    <?php echo $field ?>
                                </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php foreach($csv_data_last_row_for_view as $csv_data_last_row_for_view_row){ ?>
                                <td>
                                    <?php echo $csv_data_last_row_for_view_row ?>
                                </td>
                            <?php } ?>
                        </tr>
                    </table>

                <?php }else{ ?>

                    <div class="alert alert-info"><?php echo $text_check_row_empty ?></div>

                <?php } ?>

            </div>

        </div>

<?php } ?>

<table class="table table-bordered table-hover">
    
        <thead>
            <tr>
                <td><?php echo $text_column_field_to_file; ?></td>
                
                <?php if($type_process=='export'){ ?>
                    <td colspan="3"><?php echo $text_column_param_field_to_file; ?></td>
                <?php }else{ ?>
                    <td>
                        
                        <?php 
                        
                        
                        echo $text_column_param_field_to_file; ?>
                        
                        
                        <label style="font-weight: normal; font-size: 10px;">
                            <?php 
                            
                            if(isset($tamplate_data_selected['hide_column']) && $tamplate_data_selected['hide_column']){ ?>
                                <input onclick="hideColumn()" type="checkbox" value="1" name="odmpro_tamplate_data[hide_column]" checked="">
                            <?php }else{ ?>
                                <input onclick="hideColumn()" type="checkbox" value="1" name="odmpro_tamplate_data[hide_column]" >
                            <?php } ?>
                            
                            
                            <?php echo $text_type_data_hide_column; ?>
                        </label>
                    </td>
                    <td><?php echo $text_column_param_field_to_file_param; ?></td>
                <?php } ?>
                
            </tr>
        </thead>
        <tbody>
            <?php
              
                $position_field_to_file = 0;
                
                foreach($data_rows as $field){
              
            ?>
                  <tr id="type_data_column_<?php echo md5($field) ?>_table_row">
                      <td class="text-left" width="20%">
                          
                            <?php if($type_process=='export'){ ?>

                                <input onchange="setNewTypesDataColumns('<?php echo $field ?>','<?php echo md5($field) ?>',this.value,'<?php echo $type_process ?>',this.name,'<?php echo $tamplate_data_selected['id'] ?>');" value="<?php echo $field ?>" class="form-control" name="odmpro_tamplate_data[export_field_name][<?php echo $tamplate_data_selected['id'] ?>][<?php echo $field ?>]" />
                                
                            <?php }elseif($type_process=='import'){ ?>
                          
                            <div class="field-file"><?php echo $field ?></div>
                                
                                <input type="hidden" value="<?php echo $field ?>" class="form-control" name="odmpro_tamplate_data[export_field_name][<?php echo $tamplate_data_selected['id'] ?>][<?php echo $field ?>]" />
                          
                                
                                
                                <div style="margin-top: 5px; max-height: 100px; overflow-y: auto; " >

                                    <?php foreach($csv_data_for_view['data'] as $csv_data_for_view_row){ ?>

                                        <?php foreach($csv_data_for_view_row as $position_field_to_file_this => $csv_data_for_view_row_field){ ?>

                                            <?php if($position_field_to_file_this == $position_field_to_file){ ?>

                                            <table class='table table-bordered table-hover' style="margin-bottom: 0px; margin-top: -1px; ">
                                                  <tr>
                                                      <td  style="padding: 3px;"><div class="field-view-file-data"><?php echo $csv_data_for_view_row_field; ?></div></td>
                                                  </tr>
                                            </table>

                                            <?php } ?>

                                        <?php } ?>

                                    <?php

                                    }

                                    $position_field_to_file++;

                                    ?>

                                </div>
                          
                          <?php } ?>
                          
                      </td>
                      <td class="text-left" width="20%">
                          <div class="input-group" >
                              <select onchange="getTypesDataColumns(this.value,'#type_data_column_<?php echo md5($field) ?>','<?php echo $field; ?>','<?php echo $type_process ?>');" name="odmpro_tamplate_data[type_data][<?php echo $field ?>]"  class="form-control select-type-data">
                                  <option value="0" ><?php echo $text_type_data_ignor; ?></option>
                                      <?php foreach($types_data as $type => $columns){ ?>
                                          <?php if(isset($tamplate_data_selected['type_data'][$field]) && $tamplate_data_selected['type_data'][$field] == $type ){ ?>
                                  <option value="<?php echo $type ?>" selected="" ><?php echo ${'text_type_data_'.$type}; ?></option>
                                          <?php }else{ ?>
                                  <option value="<?php echo $type ?>" ><?php echo ${'text_type_data_'.$type}; ?></option> 
                                          <?php } ?>
                                      <?php } ?>
                              </select>
                          </div>
                      </td>
                      <td class="text-left" id="type_data_column_<?php echo md5($field) ?>">
                          
                      </td>
                      <?php if($type_process=='export'){ ?>
                      
                            <td class="text-left"><button type="button" onclick="$('#type_data_column_<?php echo md5($field) ?>_table_row').remove();" data-toggle="tooltip" title="" class="btn btn-danger" ><i class="fa fa-minus-circle"></i></button></td>
                      
                      <?php } ?>
                  </tr>
            <?php } ?>
            
            <?php if($type_process=='export'){ ?>
            
            <tr id="addTypeDataColumnTableRow_<?php echo $type_process ?>">
                <td colspan="4">
                    <a onclick="addTypeDataColumnTableRow('<?php echo $type_process ?>','<?php echo $tamplate_data_selected['id'] ?>')" data-toggle="tooltip" title="" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                </td>
            </tr>
            
            <?php } ?>
            
          </tbody>
          
</table>
                                          
                                          
                                          
    <div id="typesDataGeneralSetting">
        
        

    </div>

                                          <h3><?php echo $entry_odmpro_tamplate_data ?></h3>



                                          <div class="well">
<table class="table table-bordered table-hover">
        <tbody>
            <?php if($type_process=='export'){ ?>
            
            
            <tr style="display: none;">
                    
                    
            <?php }else{ ?>
            
            <tr>
            
            <?php } ?>
                    <td class="text-left" width="20%">
                        <?php echo $entry_type_change; ?>
                    </td>
                    <td class="text-left">
                        <div class="input-group">
                            <select name="odmpro_tamplate_data[type_change]"  class="form-control">
                                  <option value="0" ><?php echo $entry_select; ?></option>
                                      <?php foreach($types_change as $type_change => $type_change_title){ ?>
                                          <?php if(isset($tamplate_data_selected['type_change']) && $tamplate_data_selected['type_change'] == $type_change ){ ?>
                                  <option value="<?php echo $type_change ?>" selected="" ><?php echo $type_change_title; ?></option>
                                          <?php }else{ ?>
                                  <option value="<?php echo $type_change ?>" ><?php echo $type_change_title; ?></option> 
                                          <?php } ?>
                                      <?php } ?>
                              </select>
                        </div>
                    </td>
                </tr>
            
              <tr>
                      <td class="text-left" width="20%">
                          <?php echo $entry_odmpro_tamplate_data_name ?>
                      </td>
                      <td class="text-left">
                          <?php if($tamplate_data_selected['id']){ ?>
                            <input placeholder="<?php echo $entry_odmpro_tamplate_data_name ?>" name="odmpro_tamplate_data[name]" value="<?php echo $tamplate_data_selected['name'] ?>"  class="form-control" />
                          <?php }else{ ?>
                            <input placeholder="<?php echo $entry_odmpro_tamplate_data_name ?>" name="odmpro_tamplate_data[name]" value="<?php echo $tamplate_data_name_new; ?>"  class="form-control" />
                          <?php } ?>
                      </td>
                </tr>
                <tr>
                    
                      <td class="text-left" width="20%">
                          <?php echo $entry_odmpro_tamplate_type_save ?>
                      </td>
                    <td class="text-left"  >
                          <div class="input-group">
                              <select class="form-control" id="setTemplateDataTypeAction">
                                    
                                  <?php if($tamplate_data_selected['id']){ ?>
                                    <option value="save" ><?php echo $entry_odmpro_tamplate_data_save; ?></option>
                                    <option value="update" selected=""><?php echo $entry_odmpro_tamplate_data_update; ?></option>
                                    <option value="delete" ><?php echo $entry_odmpro_tamplate_data_delete; ?></option>
                                  <?php }else{ ?>
                                    <option value="save" ><?php echo $entry_odmpro_tamplate_data_save; ?></option>
                                    <option style="color: #ccc " value="update" ><?php echo $entry_odmpro_tamplate_data_update; ?></option>
                                    <option style="color: #ccc " value="delete" ><?php echo $entry_odmpro_tamplate_data_delete; ?></option>
                                  <?php } ?>
                                  
                              </select>
                              
                          </div>
                          
                      </td>
                </tr>
          </tbody>
          
</table>
                                          </div>
       <a id="setTemplateDataBtn" onclick="setTemplateData($('#setTemplateDataTypeAction').val(),'<?php echo $type_process ?>')" class="btn btn-primary setTemplateDataBtn"><?php echo $entry_odmpro_tamplate_data_save_tamplate_data ?></a>
                          <span id="setTemplateData" class="alert alert-info" style="display: none"></span>       
                          
                          <hr>
<?php if($type_process=='import'){ ?>
  

</div>

<ul  class="nav nav-tabs sh-tab-n" >
    <li class="active sh-tab"><a onclick="showHide('.stepThreeTempl');" style="cursor: pointer"><h2><?php echo $text_step_3_ending ?></h2></a></li></ul>

<table class="table table-bordered table-hover stepThreeTempl">
        <tbody>
              <tr>
                      <td class="text-center" width="20%">
                          <a id="startImport" onclick="startImport($('input[name=\'odmpro_tamplate_data[start]\']').val());" class="btn btn-primary" style="width: 100%"><?php echo $text_step_3_start_import; ?></a>
                          <input type="hidden" name="type_process" value="import"  />
                      </td>
                      <td class="text-left">
                          <label><?php echo $text_step_3_start ?></label>
                          <input placeholder="<?php echo $text_step_3_start ?>" name="odmpro_tamplate_data[start]" value="<?php echo $tamplate_data_selected['start'] ?>"  class="form-control" />
                      </td>
                      <td class="text-left">
                          <label><?php echo $text_step_3_limit ?></label>
                          <input placeholder="<?php echo $text_step_3_limit ?>" name="odmpro_tamplate_data[limit]" value="<?php echo $tamplate_data_selected['limit'] ?>"  class="form-control" />
                      </td>
              </tr>
              <tr >
                  <td colspan="3" id="importStartMessages">
                      
                  </td>
              </tr>
        </tbody>
</table>
                                          
<input type="hidden" value="<?php echo $tamplate_data_selected['new_file_upload'] ?>" class="form-control" name="odmpro_tamplate_data[new_file_upload]" />
                          

<?php }elseif($type_process=='export'){ ?>

<ul  class="nav nav-tabs sh-tab-n" >
    <li class="active sh-tab"><a><h2><?php echo $text_step_3_ending_export ?></h2></a></li></ul>

<table class="table table-bordered table-hover">
        <tbody>
              <tr>
                      <td class="text-center" width="20%">
                          <a id="startExport" onclick="startExport($('input[name=\'odmpro_tamplate_data[start]\']').val(),1);" class="btn btn-primary" style="width: 100%"><?php echo $text_step_3_start_export; ?></a>
                          <input type="hidden" name="type_process" value="export"  />
                          <span id="startExportLoading" ></span>
                      </td>
                      <td class="text-left">
                          <input placeholder="<?php echo $text_step_3_start ?>" name="odmpro_tamplate_data[start]" value="<?php echo $tamplate_data_selected['start'] ?>"  class="form-control" />
                      </td>
                      <td class="text-left">
                          <input placeholder="<?php echo $text_step_3_limit ?>" name="odmpro_tamplate_data[limit]" value="<?php echo $tamplate_data_selected['limit'] ?>"  class="form-control" />
                      </td>
              </tr>
              <tr >
                  <td colspan="3" id="exportStartMessages">
                      
                  </td>
              </tr>
        </tbody>
</table>

<?php } ?>

<?php }else{ ?>

    <?php echo $entry_odmpro_format_data_empty; ?>

<?php } ?>


<script type="text/javascript"><!--
    
    
    var column_name_num = <?php echo $column_name_num; ?>;

function addTypeDataColumnTableRow(type_process,template_id){

    var id_td = new Date().getTime();
    
    var column_name = 'column_'+column_name_num;
    
    column_name_num += 1;
    
    var html = '';
        html += '<tr id="type_data_column_'+id_td+'_table_row">';
        html +=  '<td class="text-left" width="20%">';
        html +=    '<input onchange="setNewTypesDataColumns(\''+column_name+'\',\''+id_td+'\',this.value,\''+type_process+'\',this.name,\''+template_id+'\');" value="'+column_name+'" class="form-control" name="odmpro_tamplate_data[export_field_name]['+template_id+']['+column_name+']">';
        html +=  '</td>';
        html +=  '<td class="text-left" width="20%">';
	html += 	  '<div class="input-group">';
        html += '<select onchange="getTypesDataColumns(this.value,\'#type_data_column_'+id_td+'\',\''+column_name+'\',\''+type_process+'\');" name="odmpro_tamplate_data[type_data]['+column_name+']"  class="form-control select-type-data">';
        html += '<option value="0" ><?php echo $text_type_data_ignor; ?></option>';
                
        <?php foreach($types_data as $type => $columns){ ?>
            html += '<option value="<?php echo $type ?>" ><?php echo ${'text_type_data_'.$type}; ?></option>';
        <?php } ?>
        
        html +=          '</select>';
        html += 	  '</div>';
        html +=  '</td>';
        html +=  '<td class="text-left" id="type_data_column_'+id_td+'">';
        html +=  '</td>';
	html += '<td class="text-left"><button type="button" onclick="$(\'#type_data_column_'+id_td+'_table_row\').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';
        
        $('#addTypeDataColumnTableRow_'+type_process).before(html);
        
}
    
//--></script> 


<script type="text/javascript"><!--
    
    $(document).ready(function() {
        changeTypeData();
        showHide('.stepOneTempl');
        hideColumn();
        getTypesDataGeneralSetting("<?php echo $type_process ?>");
    });
    
//--></script> 
<?php }else{ ?>
    <h3><?php echo $errors_odmpro_title ?></h3>
    <?php foreach($errors as $error){ ?>
        <div class="alert alert-danger"><?php echo $error ?></div>
    <?php } ?>
<?php } ?>