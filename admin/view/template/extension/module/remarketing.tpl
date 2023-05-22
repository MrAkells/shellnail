<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-remarketing" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-remarketing" class="form-horizontal">
		  <div class="col-md-2"> 
		  <ul class="nav nav-pills nav-stacked">
			<li class="active"><a href="#tab-ecommerce-ga4" data-toggle="tab" <?php if ($remarketing_ecommerce_status || $remarketing_ecommerce_ga4_status || $remarketing_ecommerce_ga4_measurement_status) { ?>class="enabled"<?php } ?>><i class="fa fa-money"></i> <?php echo $text_ecommerce_ga4; ?></a></li>
          </ul> 
		  </div>
		  <div class="col-md-10">
		  <div class="tab-content">
		  <div class="tab-pane active" id="tab-ecommerce-ga4">
		  	<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
			<label class="switch">
				<input type="checkbox" name="remarketing_status" <?php if ($remarketing_status) { ?>checked<?php } ?>>
				<span class="slider round"></span> 
			</label>
            </div>
            </div>
		   <legend><?php echo $text_ecommerce_ga4; ?> - (gtag.js)</legend>
			<div class="help-link"><a href="https://developers.google.com/analytics/devguides/collection/ga4/ecommerce" target="_blank"><?php echo $text_help_link; ?> Google</a></div>
			<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <label class="switch">
				<input type="checkbox" name="remarketing_ecommerce_ga4_status" <?php if ($remarketing_ecommerce_ga4_status) { ?>checked<?php } ?>>
				<span class="slider round"></span>
			</label>
            </div>
          </div> 
		  <div class="form-group">
		  <label class="col-sm-2 control-label" for="input-currency"><?php echo $entry_currency; ?> - GA4</label>
		  <div class="col-sm-10">
			<select name="remarketing_ecommerce_currency" class="form-control">
				<?php foreach ($currencies as $currency) { ?>
				<?php if ($currency['code'] == $remarketing_ecommerce_currency) { ?>
				<option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $currency['code']; ?>"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
		 </div>
		 </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_ga4_id"><?php echo $text_identifier; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_ecommerce_ga4_id" id="input-remarketing_ecommerce_ga4_id" class="form-control">
                <?php if ($remarketing_ecommerce_ga4_id == 'id') { ?>
                <option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
                <?php } elseif ($remarketing_ecommerce_ga4_id == 'model')  { ?>
                <option value="id"><?php echo $text_id; ?></option>
                <option value="model" selected="selected"><?php echo $text_model; ?></option>
                <?php } else { ?>
				<option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
				<?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_ga4_identifier"><?php echo $entry_ecommerce_ga4_identifier; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_ecommerce_ga4_identifier" value="<?php echo $remarketing_ecommerce_ga4_identifier; ?>" id="input-remarketing_ecommerce_ga4_identifier" class="form-control" />
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_ga4_selector"><?php echo $entry_ecommerce_selector; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_ecommerce_ga4_selector" value="<?php echo $remarketing_ecommerce_ga4_selector; ?>" id="input-remarketing_ecommerce_selector" class="form-control" />
               </div>
			</div>
			<div class="form-group">
			<label class="col-sm-2 control-label" for="input-remarketing_ecommerce_ratio"><?php echo $entry_ecommerce_ratio; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_ecommerce_ratio" value="<?php echo $remarketing_ecommerce_ratio; ?>" id="input-remarketing_ecommerce_ratio" class="form-control" />
               </div>
			</div>
          <legend><?php echo $text_ecommerce_ga4; ?> (dataLayer)</legend>
		  <div class="help-link"><a href="https://developers.google.com/tag-manager/ecommerce-ga4?hl=ru" target="_blank"><?php echo $text_help_link; ?> Google</a></div>
		  <div class="help-link"><a href="https://opencartforum.com/files/tutorials/670-nastroyka-google-analytics-4-cherez-modul/" target="_blank"><?php echo $text_help_link; ?> Opencartforum</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <label class="switch">
				<input type="checkbox" name="remarketing_ecommerce_status" <?php if ($remarketing_ecommerce_status) { ?>checked<?php } ?>>
				<span class="slider round"></span>
			 </label>
            </div>
          </div> 
		  </div>
		  </div>
		  </div>
        </form>
      </div>
    </div>
  </div>
</div>
<style>
.config-summary span {
	font-size:20px;
	color:#0043ff;
	font-weight:bold;
}
.version {
    color: green;
	font-weight:bold;
}
.summary-heading {
	font-size:20px;
	color:green;
	margin-bottom: 15px;
}
.enabled, .enabled:hover {
	background: #c7ffc7 !important;
    font-weight: bold;
}
.version-update {
	background: #c7ffc7 !important;
    font-weight: bold;
	margin-left:15px;
}
.diag, .diag:hover{
    background: #00b9ff !important;
    color: #fff !important;
}
legend {
	font-size:30px;
	margin-top:15px;
}
.help-link{
	font-size: 22px;
}
.help-link a{
	color: red;
}
.nav li a {
font-weight: bold;
}
.nav-pills > li.active > a.enabled, .nav-pills > li.active > a.enabled:hover, .nav-pills > li.active > a.enabled:focus {
color: red;
}
</style>
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.form-group select.form-control {
text-align:left;
max-width:300px;
}
.selectric-wrapper{
text-align:left;
max-width:300px;
}
</style>
<?php echo $footer; ?>