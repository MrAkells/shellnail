<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-owner" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-owner" class="form-horizontal">
            
            <h3 class="text-center">Общие</h3>
            
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_phone1; ?></label>
                <div class="col-sm-8">
                    <input type="text" name="owner_phone1" value="<?php echo $phone1; ?>" placeholder="<?php echo $text_phone1; ?>"  class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_phone2; ?></label>
                <div class="col-sm-8">
                    <input type="text" name="owner_phone2" value="<?php echo $phone2; ?>" placeholder="<?php echo $text_phone2; ?>"  class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_phone3; ?></label>
                <div class="col-sm-8">
                    <input type="text" name="owner_phone3" value="<?php echo $phone3; ?>" placeholder="<?php echo $text_phone3; ?>"  class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_email; ?></label>
                <div class="col-sm-8">
                    <input type="text" name="owner_email" value="<?php echo $email; ?>" placeholder="<?php echo $text_email; ?>"  class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_skype; ?></label>
                <div class="col-sm-8">
                    <input type="text" name="owner_skype" value="<?php echo $skype; ?>" placeholder="<?php echo $text_skype; ?>"  class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_sсhedule; ?></label>
                <div class="col-sm-8">
                    <input type="text" name="owner_sсhedule" value="<?php echo $schedule; ?>" placeholder="<?php echo $text_sсhedule; ?>"  class="form-control" />
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
                <label class="col-sm-4 control-label"><?php echo $text_shop_description; ?></label>
                <div class="col-sm-8">
                    <textarea rows="10" type="text" name="owner_description[<?php echo $language['language_id']; ?>][description]" id="input-description<?php echo $language['language_id']; ?>" placeholder="<?php echo $text_shop_description; ?>"  data-lang="<?php echo $lang; ?>" class="form-control summernote"><?php echo isset($owner_description[$language['language_id']]) ? $owner_description[$language['language_id']]['description'] : ''; ?></textarea>
                </div>
              </div>

              <hr/>
            
              <h3 class="text-center">Хедер</h3>
              
              <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $text_moto; ?></label>
                  <div class="col-sm-8">
                      <input type="text" name="owner_description[<?php echo $language['language_id']; ?>][moto]" value="<?php echo isset($owner_description[$language['language_id']]['moto']) ? $owner_description[$language['language_id']]['moto'] : ''; ?>" placeholder="<?php echo $text_moto; ?>"  class="form-control" />
                  </div>
              </div>
              <hr/>
              
              <h3 class="text-center">Футер</h3>
              
              <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $text_moto_footer; ?></label>
                  <div class="col-sm-8">
                      <input type="text" name="owner_description[<?php echo $language['language_id']; ?>][moto_footer]" value="<?php echo isset($owner_description[$language['language_id']]['moto_footer']) ? $owner_description[$language['language_id']]['moto_footer'] : ''; ?>" placeholder="<?php echo $text_moto_footer; ?>"  class="form-control" />
                  </div>
              </div>
              
              <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $text_second_block_title; ?></label>
                  <div class="col-sm-8">
                      <input type="text" name="owner_description[<?php echo $language['language_id']; ?>][second_block_title]" value="<?php echo isset($owner_description[$language['language_id']]['second_block_title']) ? $owner_description[$language['language_id']]['second_block_title'] : ''; ?>" placeholder="<?php echo $text_second_block_title; ?>"  class="form-control" />
                  </div>
              </div>
              
                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $text_second_block; ?></label>
                  <div class="col-sm-8">
                      <textarea type="text" name="owner_description[<?php echo $language['language_id']; ?>][second_block]"  placeholder="<?php echo $text_second_block; ?>"  class="form-control" /><?php echo isset($owner_description[$language['language_id']]['second_block']) ? $owner_description[$language['language_id']]['second_block'] : ''; ?></textarea>
                  </div>
              </div>

              <hr/>

              <h3 class='text-center'>Акции</h3>
              <div class="form-group">
                 <label class="col-sm-4 control-label"><?php echo $entry_promotions_meta_title; ?></label>
                 <div class="col-sm-8">
                     <input type="text" name="owner_description[<?php echo $language['language_id']; ?>][promotions_meta_title]" value="<?php echo isset($owner_description[$language['language_id']]['promotions_meta_title']) ? $owner_description[$language['language_id']]['promotions_meta_title'] : ''; ?>" placeholder="<?php echo $entry_promotions_meta_title; ?>"  class="form-control" />
                 </div>
             </div>
             <div class="form-group">
                 <label class="col-sm-4 control-label"><?php echo $entry_promotions_meta_description; ?></label>
                 <div class="col-sm-8">
                     <textarea type="text" name="owner_description[<?php echo $language['language_id']; ?>][promotions_meta_description]"  placeholder="<?php echo $entry_promotions_meta_description; ?>"  class="form-control" /><?php echo isset($owner_description[$language['language_id']]['promotions_meta_description']) ? $owner_description[$language['language_id']]['promotions_meta_description'] : ''; ?></textarea>
                 </div>
             </div>
             <div class="form-group">
                 <label class="col-sm-4 control-label"><?php echo $entry_promotions_meta_keywords; ?></label>
                 <div class="col-sm-8">
                     <textarea type="text" name="owner_description[<?php echo $language['language_id']; ?>][promotions_meta_keywords]"  placeholder="<?php echo $entry_promotions_meta_keywords; ?>"  class="form-control" /><?php echo isset($owner_description[$language['language_id']]['promotions_meta_keywords']) ? $owner_description[$language['language_id']]['promotions_meta_keywords'] : ''; ?></textarea>
                  </div>
             </div>                                        
            </div>
            <?php } ?>
          </div>               
            
            <hr/>
            <h3 class='text-center'>Дополнительный логотип</h3>
            
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo 'Выберите логотип'; ?></label>
                <div class="col-sm-8"><a href="" id="thumb-add_logo" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb_additional_logo; ?>" alt="" title="" /></a>
                  <input type="hidden" name="owner_additional_logo" value="<?php echo $owner_additional_logo; ?>" id="input-add_logo" />
                </div>
                
            </div>
            
             <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo 'Текст суммы бесплатной доставки'; ?></label>
                <div class="col-sm-8">
                    <input type="number" name="owner_free_shipping_sum" value="<?php echo $owner_free_shipping_sum; ?>"   class="form-control" />
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
    <?php foreach ($languages as $language) { ?>
        ckeditorInit('input-description<?php echo $language['language_id']; ?>', getURLVar('token'));
    <?php } ?>
    $('#language a:first').tab('show');
  //--></script>
<?php echo $footer; ?>