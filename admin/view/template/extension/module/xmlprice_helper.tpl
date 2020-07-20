<?php if($success){ ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
<?php } ?>
<div class="pull-right">
    <span data-form="form_<?php echo $aggregator; ?>" title="<?php echo $text_save.$aggregator; ?>" class="settings_saver btn btn-success">
        <i class="fa fa-save agg"></i>
    </span>
</div>
<br/><br/><br/>
<div class="row">
    <div class="col-sm-4"><a href="<?php echo $link_to_xml_file; ?>" target="_blank"><?php echo $text_link; ?></a></div>
     <div class="col-sm-8 well well-sm" style="height: 40px;"><?php echo $link_to_xml_file; ?></div>
</div>
<form id="form_<?php echo $aggregator; ?>" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
<div class="form-group" >
        <div  style="height: 300px; overflow: auto;">
            <table class='table table-bordered table-striped'>
                <tbody>
                    <tr>
                        <th><span title="<?php echo $category_explained ?>"><?php echo $text_categories; ?></span></th><th><span title="<?php echo $psevdo_explained ?>"><?php echo $text_aliases; ?></span></th>
                    </tr>
                    <?php foreach ($categories as $category) { ?>
                    <tr>
                        <td>
                          <?php if (in_array($category['category_id'], $checked_categories)) { ?>
                          <input type="checkbox" name="<?php echo $aggregator ?>_categories[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                          <?php echo $category['name']; ?>
                          <?php } else { ?>
                          <input type="checkbox" name="<?php echo $aggregator ?>_categories[]" value="<?php echo $category['category_id']; ?>" />
                          <?php echo $category['name']; ?>
                          <?php } ?>  
                        </td>
                        <td>
                            <input type="text" name="alias<?php echo $category['category_id'] ?>" class="category_alias" value="<?php echo isset($aliases[$category['category_id']])? $aliases[$category['category_id']]:''; ?>" style="color: green;"/>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <br/>
        <a style="cursor:default;" onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a style="cursor:default;" onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a>
</div>
<div class="form-group" >
        <div  style="height: 200px; width: 600px; overflow: auto;">
            <table class='table table-bordered table-striped'>
                <tbody>
                    <tr>
                        <th>Brands</th>
                    </tr>
            <?php foreach ($manufacturers as $manufacturer) { ?>
            <tr>
                <td>
                <?php if (in_array($manufacturer['manufacturer_id'], $checked_manufacturers)) { ?>
                    <input type="checkbox" name="manufacturers[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" checked="checked" />
                <?php echo $manufacturer['name']; ?>
                <?php } else { ?>
                    <input type="checkbox" name="manufacturers[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" />
                <?php echo $manufacturer['name']; ?>
                <?php } ?>   
                  </td>
            </tr>
            <?php } ?>
              </tbody>
              </table>
        </div>
        <br/>
        <a style="cursor:default;" onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a style="cursor:default;" onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a>
</div>
</form>
<div>
    <button class="generator btn btn-primary" data-agg="<?php echo $aggregator; ?>" data-state="<?php echo $aggregator_state; ?>" data-link="<?php echo $link_to_generate; ?>"><?php echo $text_generate; ?>
    </button>
</div>