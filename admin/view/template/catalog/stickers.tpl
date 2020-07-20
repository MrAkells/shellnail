
<div class='row'>
    <div class='col-sm-3'></div>
    <div class='col-sm-6'>
        <br/>
        <h4><?php echo $text_stickers_description; ?></h4>
        <br/>
    </div>
    <div class='col-sm-3'></div>
</div>
<div class="row well">

    <label class="col-sm-2 control-label"><?php echo  $text_hand_stickers; ?></label>
    <div class="col-sm-4">
        <table class="table table-striped">
        <?php foreach ($stickers_list as $sticker) { ?>
        <tr>
            <td class="checkbox">
                <label>
                    <?php if (in_array($sticker, $product_stickers)) { ?>
                    <input type="checkbox" name="product_stickers[]" value="<?php echo $sticker; ?>" checked="checked" />
                    <?php echo $all_possible_stickers[$sticker]; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="product_stickers[]" value="<?php echo $sticker; ?>" />
                    <?php echo $all_possible_stickers[$sticker]; ?>
                    <?php } ?>
                </label>
            </td>
        </tr>
        <?php } ?>
        </table>
    </div>
                
    <label class="col-sm-2 control-label"><?php echo $text_auto_stickers; ?></label>
    <div class="col-sm-4">
        <table class="table table-striped">
            <?php foreach ($stickers_list as $sticker) { ?>
            <tr>
                <td class="checkbox">
                    <label>
                    <?php if (in_array($sticker, $product_auto_stickers)) { ?>
                    <input type="checkbox" name="product_auto_stickers[]" value="<?php echo $sticker; ?>" disabled  checked="checked" />
                    <?php echo $all_possible_stickers[$sticker]; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="product_auto_stickers[]" value="<?php echo $sticker; ?>" disabled />
                    <?php echo $all_possible_stickers[$sticker]; ?>
                    <?php } ?>
                    </label>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>



