<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-package" data-toggle="tooltip" title="<?php echo $button_save; ?>"
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-package"
          class="form-horizontal">
          <input id="page_id" class="hidden" name='page_id' value="<?php echo $page_id; ?>" />
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-title">
              <?php echo $entry_url; ?>
            </label>
            <div class="col-sm-10">
              <input name="url" value="<?php echo $url; ?>" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-is_noindex"><?php echo $entry_noindex; ?></label>
            <div class="col-sm-10">
              <div class="checkbox">
                <label>
                  <?php if ($is_noindex) { ?>
                  <input type="checkbox" name="is_noindex" value="1" checked="checked" id="input-is_noindex" />
                  <?php } else { ?>
                  <input type="checkbox" name="is_noindex" value="1" id="input-is_noindex" />
                  <?php } ?>
                  &nbsp; </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-is_canonical"><?php echo $entry_canonical; ?></label>
            <div class="col-sm-10">
              <div class="checkbox">
                <label>
                  <?php if ($is_canonical) { ?>
                  <input type="checkbox" name="is_canonical" value="1" checked="checked" id="input-is_canonical" />
                  <?php } else { ?>
                  <input type="checkbox" name="is_canonical" value="1" id="input-is_canonical" />
                  <?php } ?>
                  &nbsp; </label>
              </div>
            </div>
          </div>
          <ul class="nav nav-tabs" id="language">
            <?php foreach ($languages as $language) { ?>
            <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
            <?php } ?>
          </ul>
          <div class="tab-content">
            <?php foreach ($languages as $language) { ?>
            <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                <div class="col-sm-10">
                  <textarea name="page_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" data-lang="<?php echo $lang; ?>" class="form-control summernote"><?php echo isset($page_description[$language['language_id']]) ? $page_description[$language['language_id']]['description'] : ''; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-h1<?php echo $language['language_id']; ?>"><?php echo $entry_h1; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="page_description[<?php echo $language['language_id']; ?>][h1]" value="<?php echo isset($page_description[$language['language_id']]) && isset($page_description[$language['language_id']]['h1']) ? $page_description[$language['language_id']]['h1'] : ''; ?>" placeholder="<?php echo $entry_h1; ?>" id="input-h1<?php echo $language['language_id']; ?>" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="page_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($page_description[$language['language_id']]) ? $page_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                <div class="col-sm-10">
                  <textarea name="page_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($page_description[$language['language_id']]) ? $page_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                <div class="col-sm-10">
                  <textarea name="page_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($page_description[$language['language_id']]) ? $page_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
    <?php foreach ($languages as $language) { ?>
        ckeditorInit('input-description<?php echo $language['language_id']; ?>', getURLVar('token'));
    <?php } ?>
    $('#language a:first').tab('show');
  //--></script>
</div>
<?php echo $footer; ?>
