<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-buyoneclick" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-html" class="form-horizontal">

			<div class="tab-pane">
				<ul class="nav nav-tabs" id="language">
					<?php foreach ($languages as $language) { ?>
					<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
					<?php } ?>
				</ul>
				<div class="tab-content">
					<?php foreach ($languages as $language) { ?>
					<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
						<div class="form-group">
							<label class="col-sm-3 control-label" for="buyoneclick_name_<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
							<div class="col-sm-9">
								<input type="text" name="buyoneclick_name_<?php echo $language['language_id']; ?>" placeholder="<?php echo $entry_name; ?>" id="buyoneclick_name_<?php echo $language['language_id']; ?>" value="<?php echo isset(${'buyoneclick_name_'.$language['language_id']}) ? ${'buyoneclick_name_'.$language['language_id']} : ''; ?>" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="buyoneclick_preorder_name_<?php echo $language['language_id']; ?>"><?php echo $entry_preorder_name; ?></label>
							<div class="col-sm-9">
								<input type="text" name="buyoneclick_preorder_name_<?php echo $language['language_id']; ?>" placeholder="<?php echo $entry_preorder_name; ?>" id="buyoneclick_preorder_name_<?php echo $language['language_id']; ?>" value="<?php echo isset(${'buyoneclick_preorder_name_'.$language['language_id']}) ? ${'buyoneclick_preorder_name_'.$language['language_id']} : ''; ?>" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="buyoneclick_success_field_<?php echo $language['language_id']; ?>"><?php echo $entry_success_field; ?></label>
							<div class="col-sm-9">
								<input type="text" name="buyoneclick_success_field_<?php echo $language['language_id']; ?>" placeholder="<?php echo $entry_success_field; ?>" id="buyoneclick_success_field_<?php echo $language['language_id']; ?>" value="<?php echo isset(${'buyoneclick_success_field_'.$language['language_id']}) ? ${'buyoneclick_success_field_'.$language['language_id']} : ''; ?>" class="form-control" />
								<p><?php echo $success_field_tooltip; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="buyoneclick_additional_field_<?php echo $language['language_id']; ?>"><?php echo $entry_additional_field; ?></label>
							<div class="col-sm-7">
								<input type="text" name="buyoneclick_additional_field_<?php echo $language['language_id']; ?>" placeholder="<?php echo $entry_additional_field; ?>" id="buyoneclick_additional_field_<?php echo $language['language_id']; ?>" value="<?php echo isset(${'buyoneclick_additional_field_'.$language['language_id']}) ? ${'buyoneclick_additional_field_'.$language['language_id']} : ''; ?>" class="form-control" />
							</div>
							<div class="col-sm-2">
								<label>
								<input type="checkbox" name="buyoneclick_additional_field_required_<?php echo $language['language_id']; ?>" value="1" <?php echo isset(${'buyoneclick_additional_field_required_'.$language['language_id']}) ? 'checked="checked"' : ''; ?>> <?php echo $additional_field_required; ?>
								</label>
							</div>
							<div class="col-sm-offset-3 col-sm-9">
								<?php echo $additional_field_tooltip; ?>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			
			<div class="form-group" style="border-top: 1px solid #ccc;">
				<label class="col-sm-3 control-label" for="input-img_status"><?php echo $img_title; ?></label>
				<div class="col-sm-9">
					<select name="buyoneclick_img_status" id="input-img_status" class="form-control">
						<?php if ($buyoneclick_img_status) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>			

			<div class="form-group" style="border-top: 1px solid #ccc;">
				<label class="col-sm-3 control-label" for="input-field1_status"><?php echo $field1_title; ?></label>
				<div class="col-sm-7">
					<select name="buyoneclick_field1_status" id="input-field1_status" class="form-control">
						<?php if ($buyoneclick_field1_status) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-sm-2">
					<label>
					<input type="checkbox" name="buyoneclick_field1_required" value="1" <?php echo isset($buyoneclick_field1_required) ? 'checked="checked"' : ''; ?>> <?php echo $field_required; ?>
					</label>
				</div>
			</div>

			<div class="form-group" style="border:none;">
				<label class="col-sm-3 control-label" for="input-field2_status"><?php echo $field2_title; ?></label>
				<div class="col-sm-7">
					<select name="buyoneclick_field2_status" id="input-field2_status" class="form-control">
						<?php if ($buyoneclick_field2_status) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-sm-2">
					<label>
					<input type="checkbox" name="buyoneclick_field2_required" value="1" <?php echo isset($buyoneclick_field2_required) ? 'checked="checked"' : ''; ?>> <?php echo $field_required; ?>
					</label>
				</div>
			</div>

			<div class="form-group" style="border:none;">
				<label class="col-sm-3 control-label" for="input-field3_status"><?php echo $field3_title; ?></label>
				<div class="col-sm-7">
					<select name="buyoneclick_field3_status" id="input-field3_status" class="form-control">
						<?php if ($buyoneclick_field3_status) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-sm-2">
					<label>
					<input type="checkbox" name="buyoneclick_field3_required" value="1" <?php echo isset($buyoneclick_field3_required) ? 'checked="checked"' : ''; ?>> <?php echo $field_required; ?>
					</label>
				</div>
			</div>

			<div class="form-group" style="border:none;">
				<label class="col-sm-3 control-label" for="input-field4_status"><?php echo $field4_title; ?></label>
				<div class="col-sm-7">
					<select name="buyoneclick_field4_status" id="input-field4_status" class="form-control">
						<?php if ($buyoneclick_field4_status) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-sm-2">
					<label>
					<input type="checkbox" name="buyoneclick_field4_required" value="1" <?php echo isset($buyoneclick_field4_required) ? 'checked="checked"' : ''; ?>> <?php echo $field_required; ?>
					</label>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label" for="input-validation_type" style="padding-top:0px;"><?php echo $entry_validation_type; ?></label>
				<div class="col-sm-7">
					<select name="buyoneclick_validation_type" id="input-validation_type" class="form-control">
						<?php if ($buyoneclick_validation_type == $value_validation_type1) { ?>
						<option value="<?php echo $value_validation_type1; ?>" selected="selected"><?php echo $text_validation_type1; ?></option>
						<option value="<?php echo $value_validation_type2; ?>"><?php echo $text_validation_type2; ?></option>
						<?php } else { ?>
						<option value="<?php echo $value_validation_type1; ?>"><?php echo $text_validation_type1; ?></option>
						<option value="<?php echo $value_validation_type2; ?>" selected="selected"><?php echo $text_validation_type2; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-sm-2">
					<label>
					<input type="checkbox" name="buyoneclick_validation_status" value="1" <?php echo isset($buyoneclick_validation_status) ? 'checked="checked"' : ''; ?>> <?php echo $entry_validation_status; ?>
					</label>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label" for="input-status" style="padding-top:0px;"><?php echo $entry_status; ?></label>
				<div class="col-sm-9">
					<select name="buyoneclick_status" id="input-status" class="form-control">
						<?php if ($buyoneclick_status) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="form-group" style="border:none;">
				<label class="col-sm-3 control-label" for="input-status_category" style="padding-top:0px;"><?php echo $entry_status_category; ?></label>
				<div class="col-sm-9">
					<select name="buyoneclick_status_category" id="input-status_category" class="form-control">
						<?php if ($buyoneclick_status_category) { ?>
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
				<label class="col-sm-3 control-label" for="input-style_status" style="padding-top:0px;"><?php echo $entry_style_status; ?></label>
				<div class="col-sm-9">
					<select name="buyoneclick_style_status" id="input-style_status" class="form-control">
						<?php if ($buyoneclick_style_status) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			
			<!---------- SMS settings ------------>
			<div class="tab-pane" style="padding-top:2em; border-top:1px solid #000;">
				<div class="col-sm-12 text-center h2" style="margin-top:0;">Настройки SMS уведомлений</div>
				<ul class="nav nav-tabs" id="sms_settings">
					<li><a href="#smsru" data-toggle="tab">SMS.ru</a></li>
					<li><a href="#turbosms" data-toggle="tab">TurboSMS.ua</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane" id="smsru">
						<!---------- SMS.ru ------------>
						<div class="col-sm-12 text-center h2" style="margin-top:0;"><?php echo $smsru_form_title; ?></div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="smsru_api"><?php echo $smsru_api_title; ?></label>
							<div class="col-sm-9">
							  <input type="text" name="buyoneclick_smsru_api" value="<?php echo $buyoneclick_smsru_api; ?>" placeholder="<?php echo $smsru_api_title; ?>" id="smsru_api" class="form-control" />
							</div>
							<div class="col-sm-offset-3 col-sm-9">
								<?php echo $smsru_api_tooltip; ?>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="smsru_login"><?php echo $smsru_login_title; ?></label>
							<div class="col-sm-9">
							  <input type="text" name="buyoneclick_smsru_login" value="<?php echo $buyoneclick_smsru_login; ?>" placeholder="<?php echo $smsru_login_title; ?>" id="smsru_login" class="form-control" />
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="smsru_password"><?php echo $smsru_password_title; ?></label>
							<div class="col-sm-9">
							  <input type="text" name="buyoneclick_smsru_password" value="<?php echo $buyoneclick_smsru_password; ?>" placeholder="<?php echo $smsru_password_title; ?>" id="smsru_password" class="form-control" />
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="smsru_number"><?php echo $smsru_number_title; ?></label>
							<div class="col-sm-9">
							  <input type="text" name="buyoneclick_smsru_number" value="<?php echo $buyoneclick_smsru_number; ?>" placeholder="<?php echo $smsru_number_title; ?>" id="smsru_number" class="form-control" />
							</div>
							<div class="col-sm-offset-3 col-sm-9">
								<?php echo $smsru_number_tooltip; ?>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="smsru_name"><?php echo $smsru_name_title; ?></label>
							<div class="col-sm-9">
							  <input type="text" name="buyoneclick_smsru_name" value="<?php echo $buyoneclick_smsru_name; ?>" placeholder="<?php echo $smsru_name_title; ?>" id="smsru_name" class="form-control" />
							</div>
							<div class="col-sm-offset-3 col-sm-9">
								<?php echo $smsru_name_tooltip; ?>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="smsru_admin_sms"><?php echo $smsru_admin_sms_title; ?></label>
							<div class="col-sm-9">
							  <input type="text" name="buyoneclick_smsru_admin_sms" value="<?php echo $buyoneclick_smsru_admin_sms; ?>" placeholder="<?php echo $smsru_admin_sms_title; ?>" id="smsru_admin_sms" class="form-control" />
							</div>
							<div class="col-sm-offset-3 col-sm-9">
								<?php echo $smsru_admin_sms_tooltip; ?>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="smsru_client_status"><?php echo $smsru_client_status_title; ?></label>
							<div class="col-sm-9">
							  <select name="buyoneclick_smsru_client_status" id="smsru_client_status" class="form-control">
								<?php if ($buyoneclick_smsru_client_status) { ?>
								<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								<option value="0"><?php echo $text_disabled; ?></option>
								<?php } else { ?>
								<option value="1"><?php echo $text_enabled; ?></option>
								<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							  </select>
							</div>
							<div class="col-sm-offset-3 col-sm-9">
								<?php echo $smsru_client_status_tooltip; ?>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="smsru_client_sms"><?php echo $smsru_client_sms_title; ?></label>
							<div class="col-sm-9">
							  <input type="text" name="buyoneclick_smsru_client_sms" value="<?php echo $buyoneclick_smsru_client_sms; ?>" placeholder="<?php echo $smsru_client_sms_title; ?>" id="smsru_client_sms" class="form-control" />
							</div>
							<div class="col-sm-offset-3 col-sm-9">
								<?php echo $smsru_client_sms_tooltip; ?>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="smsru_status"><?php echo $smsru_status_title; ?></label>
							<div class="col-sm-9">
							  <select name="buyoneclick_smsru_status" id="smsru_status" class="form-control">
								<?php if ($buyoneclick_smsru_status) { ?>
								<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								<option value="0"><?php echo $text_disabled; ?></option>
								<?php } else { ?>
								<option value="1"><?php echo $text_enabled; ?></option>
								<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							  </select>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="turbosms">
						<!---------- TurboSMS.ua ------------>
						<div class="col-sm-12 text-center h2" style="margin-top:0;"><?php echo $turbosms_form_title; ?></div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="turbosms_login"><?php echo $turbosms_login_title; ?></label>
							<div class="col-sm-9">
							  <input type="text" name="buyoneclick_turbosms_login" value="<?php echo $buyoneclick_turbosms_login; ?>" placeholder="<?php echo $turbosms_login_title; ?>" id="turbosms_login" class="form-control" />
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="turbosms_password"><?php echo $turbosms_password_title; ?></label>
							<div class="col-sm-9">
							  <input type="text" name="buyoneclick_turbosms_password" value="<?php echo $buyoneclick_turbosms_password; ?>" placeholder="<?php echo $turbosms_password_title; ?>" id="turbosms_password" class="form-control" />
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="turbosms_number"><?php echo $turbosms_number_title; ?></label>
							<div class="col-sm-9">
							  <input type="text" name="buyoneclick_turbosms_number" value="<?php echo $buyoneclick_turbosms_number; ?>" placeholder="<?php echo $turbosms_number_title; ?>" id="turbosms_number" class="form-control" />
							</div>
							<div class="col-sm-offset-3 col-sm-9">
								<?php echo $turbosms_number_tooltip; ?>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="turbosms_name"><?php echo $turbosms_name_title; ?></label>
							<div class="col-sm-9">
							  <input type="text" name="buyoneclick_turbosms_name" value="<?php echo $buyoneclick_turbosms_name; ?>" placeholder="<?php echo $turbosms_name_title; ?>" id="turbosms_name" class="form-control" />
							</div>
							<div class="col-sm-offset-3 col-sm-9">
								<?php echo $turbosms_name_tooltip; ?>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="turbosms_admin_sms"><?php echo $turbosms_admin_sms_title; ?></label>
							<div class="col-sm-9">
							  <input type="text" name="buyoneclick_turbosms_admin_sms" value="<?php echo $buyoneclick_turbosms_admin_sms; ?>" placeholder="<?php echo $turbosms_admin_sms_title; ?>" id="turbosms_admin_sms" class="form-control" />
							</div>
							<div class="col-sm-offset-3 col-sm-9">
								<?php echo $turbosms_admin_sms_tooltip; ?>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="turbosms_client_status"><?php echo $turbosms_client_status_title; ?></label>
							<div class="col-sm-9">
							  <select name="buyoneclick_turbosms_client_status" id="turbosms_client_status" class="form-control">
								<?php if ($buyoneclick_turbosms_client_status) { ?>
								<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								<option value="0"><?php echo $text_disabled; ?></option>
								<?php } else { ?>
								<option value="1"><?php echo $text_enabled; ?></option>
								<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							  </select>
							</div>
							<div class="col-sm-offset-3 col-sm-9">
								<?php echo $turbosms_client_status_tooltip; ?>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="turbosms_client_sms"><?php echo $turbosms_client_sms_title; ?></label>
							<div class="col-sm-9">
							  <input type="text" name="buyoneclick_turbosms_client_sms" value="<?php echo $buyoneclick_turbosms_client_sms; ?>" placeholder="<?php echo $turbosms_client_sms_title; ?>" id="turbosms_client_sms" class="form-control" />
							</div>
							<div class="col-sm-offset-3 col-sm-9">
								<?php echo $turbosms_client_sms_tooltip; ?>
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="turbosms_status"><?php echo $turbosms_status_title; ?></label>
							<div class="col-sm-9">
							  <select name="buyoneclick_turbosms_status" id="turbosms_status" class="form-control">
								<?php if ($buyoneclick_turbosms_status) { ?>
								<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								<option value="0"><?php echo $text_disabled; ?></option>
								<?php } else { ?>
								<option value="1"><?php echo $text_enabled; ?></option>
								<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							  </select>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<!---------- Analytics settings ------------>
			<div class="tab-pane" style="padding-top:2em; border-top:1px solid #000;">
				<div class="col-sm-12 text-center h2" style="margin-top:0;">Настройка аналитики</div>
				<ul class="nav nav-tabs" id="analytics_settings">
					<li><a href="#yandex" data-toggle="tab"><span style="color:red;">Я</span>ндекс</a></li>
					<li><a href="#google" data-toggle="tab"><span style="color:#4285f4;">G</span>oogle</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane" id="yandex">
						<!---------- Yandex.ru ------------>
						<div class="form-group">
							<div class="col-sm-12 text-center h2"><?php echo $ya_form_title; ?></div>
							<label class="col-sm-3 control-label" for="ya_counter"><?php echo $ya_counter_title; ?></label>
							<div class="col-sm-9">
							  <input type="text" name="buyoneclick_ya_counter" value="<?php echo $buyoneclick_ya_counter; ?>" placeholder="<?php echo $ya_counter_title; ?>" id="ya_counter" class="form-control" />
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="ya_identificator"><?php echo $ya_identificator_title; ?></label>
							<div class="col-sm-9">
							  <input type="text" name="buyoneclick_ya_identificator" value="<?php echo $buyoneclick_ya_identificator; ?>" placeholder="<?php echo $ya_identificator_title; ?>" id="ya_identificator" class="form-control" />
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="ya_target_status"><?php echo $ya_target_status_title; ?></label>
							<div class="col-sm-9">
							  <select name="buyoneclick_ya_status" id="ya_target_status" class="form-control">
								<?php if ($buyoneclick_ya_status) { ?>
								<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								<option value="0"><?php echo $text_disabled; ?></option>
								<?php } else { ?>
								<option value="1"><?php echo $text_enabled; ?></option>
								<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							  </select>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="google">
						<!---------- Google.com ------------>
						<div class="form-group">
							<div class="col-sm-12 text-center h2"><?php echo $google_form_title; ?></div>
							<label class="col-sm-3 control-label" for="google_category"><?php echo $google_category_title; ?></label>
							<div class="col-sm-9">
							  <input type="text" name="buyoneclick_google_category" value="<?php echo $buyoneclick_google_category; ?>" placeholder="<?php echo $google_category_title; ?>" id="google_category" class="form-control" />
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="google_action"><?php echo $google_action_title; ?></label>
							<div class="col-sm-9">
							  <input type="text" name="buyoneclick_google_action" value="<?php echo $buyoneclick_google_action; ?>" placeholder="<?php echo $google_action_title; ?>" id="google_action" class="form-control" />
							</div>
						</div>
						<div class="form-group" style="border:none;">
							<label class="col-sm-3 control-label" for="google_target_status"><?php echo $google_target_status_title; ?></label>
							<div class="col-sm-9">
							  <select name="buyoneclick_google_status" id="google_target_status" class="form-control">
								<?php if ($buyoneclick_google_status) { ?>
								<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								<option value="0"><?php echo $text_disabled; ?></option>
								<?php } else { ?>
								<option value="1"><?php echo $text_enabled; ?></option>
								<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							  </select>
							</div>
						</div>
					</div>
				</div>
			</div>
        </form>
      </div>
    </div>
	
<script type="text/javascript"><!--
$('#language a:first').tab('show');
$('#sms_settings a:first').tab('show');
$('#analytics_settings a:first').tab('show');
//--></script>
  </div>
<?php echo $footer; ?>