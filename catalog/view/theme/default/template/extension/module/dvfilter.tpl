<?php if ($options || $show_price) { ?>
  <div class="visible-xs visible-sm" id="dvfilter-mobile">
    <nav class="navbar" onclick="$('#dvfilter').slideToggle()">
      <div>
        <button class="btn-dvfilter" type="button"><?php echo $heading_title; ?></button>
      </div>
      <div id="navbar-dvfilter"></div>
    </nav>
  </div>
  <?php
  $onclick = false;
  $selecteds_count = count($selecteds);
  if ($selecteds_count > 1) {
    $onclick = true;
  } else if ($selecteds_count) {
    $values_count = 0;
    foreach ($selecteds as $option) {
      $values_count += count($option['values']);
      if ($values_count > 1) {
        $onclick = true;
        break;
      }
    }
  }
  ?>
  <div class="panel  panel-default dvfilter" id="dvfilter">
    <div class="panel-heading hidden-xs"><span class="filter-title"><?php echo $heading_title; ?></span>
      <?php if ($selecteds) { # Selected options 
      ?>
        <div class="list-group-item selected-options">
          <?php foreach ($selecteds as $option) { ?>
            <div class="dvfilter-option hidden">
              <span><?php echo $option['name']; ?>:</span>
              <?php foreach ($option['values'] as $value) { ?>
                <button type="button" onclick="location = '<?php echo $value['href']; ?>';" class="btn btn-xs btn-danger" style="padding: 1px 4px;"><i class="fa fa-times"></i> <?php echo $value['name']; ?></button>
              <?php } ?>
            </div>
          <?php } ?>
          <?php $count = count($selecteds);
          $selected = $selecteds;
          $first = array_shift($selected); ?>
          <?php if ($count >= 1 || count($first['values']) >= 1) { ?>
            <button type="button" onclick="location = '<?php echo $link; ?>';" class="btn-transparent resel-all" style="border-radius: 0;"><?php echo $text_cancel_all; ?></button>
          <?php } ?>
        </div>
      <?php } ?><div style="clear: left"></div>
    </div>
    <div class="hidden" id="dvfilter-button">
      <button class="btn btn-primary disabled" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Загрузка.."></button>
    </div>
    <div class="list-group" id="dvfilter-content">


      <?php if ($show_price) { # Price filtering 
      ?>
        <div class="list-group-item dvfilter-option" data-toggle="popover-price">
          <div class="option-name angle_up">
            <?php echo $text_price; ?>&nbsp;<?php echo $symbol_left; ?>
            <span id="price-from"><?php echo $min_price_get; ?></span>&nbsp;-&nbsp;<span id="price-to"><?php echo $max_price_get; ?></span><?php echo $symbol_right; ?>
            <i class="fa fa-angle-up" aria-hidden="true"></i>
          </div>

          <div class="option-values">
            <!--				 	<div id="scale-price" class="scale dvf-target" data-option-id="p"
              data-start-min="<?php echo $min_price_get; ?>"
              data-start-max="<?php echo $max_price_get; ?>"
              data-range-min="<?php echo $min_price; ?>"
              data-range-max="<?php echo $max_price; ?>"
              data-element-min="#price-from"
              data-element-max="#price-to"
              data-control-min="#min-price-value"
              data-control-max="#max-price-value"
              ></div> -->

            <input name="price[min]" type="number" id="min-price-value">
            <!--              <input type="number" placeholder="От">-->
            <p class="dash"> - </p>
            <input name="price[max]" type="number" id="max-price-value">
            <!--              <input type="number" placeholder="До">-->
            <button id='search-products'>Ок</button>



            <?php if ($diagram) { ?>
              <div class="price-diagram">
                <div class="diagram-field">
                  <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="40px">
                    <?php foreach ($diagram['circles'] as $circle) { ?>
                      <?php if ($circle['count']) { ?>
                        <circle cx="<?php echo $circle['x']; ?>" cy="<?php echo $circle['y']; ?>" r="1" fill="#037a9c" stroke="#037a9c" stroke-width="1" />
                      <?php } else { ?>
                        <circle cx="<?php echo $circle['x']; ?>" cy="<?php echo $circle['y']; ?>" r="1" fill="#BF0000" stroke="#BF0000" stroke-width="1" />
                      <?php } ?>
                    <?php } ?>
                    <path fill="#037a9c" stroke="#037a9c" d="<?php echo $diagram['path']; ?>" stroke-width="1" opacity="0.25" stroke-opacity="1" />
                  </svg>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      <?php } # Price filtering end 
      ?>

      <?php foreach ($options as $main_key => $option) { ?>

        <?php if ($show_options_limit && $show_options_limit == $option['index'] - 1) { ?>
          <?php if ($show_options) { ?>
            <button type="button" class="btn btn-default btn-block" data-toggle="collapse" data-target="#dvfilter-hidden-options" aria-expanded="true" aria-controls="dvfilter-hidden-options"><i class="fa fa-angle-down"></i></button>
            <div class="collapse in" id="dvfilter-hidden-options" aria-expanded="true">
            <?php } else { ?>
              <button type="button" class="btn btn-default btn-block" data-toggle="collapse" data-target="#dvfilter-hidden-options" aria-expanded="false" aria-controls="dvfilter-hidden-options"><i class="fa fa-angle-down"></i></button>
              <div class="collapse" id="dvfilter-hidden-options" aria-expanded="false">
              <?php } ?>
            <?php } ?>

            <div class="list-group-item dvfilter-option" id="option-<?php echo $option['option_id']; ?>">
              <div class="option-name angle_up">
                <?php if ($option['name'] == 'color') { ?>
                  <?php echo "<a><span id='color_hook'>" . $text_color . "</span></a>"; ?>
                <?php } else { ?>
                  <?php echo $option['name']; ?>
                <?php } ?>
                <?php if ($option['type'] == 'slide' || $option['type'] == 'slide_dual') { ?>
                  <span id="left-value-<?php echo $option['option_id']; ?>"><?php echo $option['slide_value_min_get']; ?></span>
                  <?php if ($option['type'] == 'slide_dual') { ?>
                    -&nbsp;<span id="right-value-<?php echo $option['option_id']; ?>"><?php echo $option['slide_value_max_get']; ?></span>
                  <?php } ?>
                  <?php echo $option['postfix']; ?>
                <?php } ?>

                <?php
                $angle_up = ((($is_mobile && $main_key !== 'm') || in_array('angles_' . $option['option_id'], $collapsed)) && $option['collapse']) ? false : true;
                ?>

                <i id="angles_<?php echo $option['option_id']; ?>" class="<?php echo $angle_up ? 'fa fa-angle-up' : 'fa fa-angle-down'; ?>" aria-hidden="true"></i>
              </div>

              <div class="option-values" <?php echo $angle_up ?: 'style="display: none"'; ?>>

                <?php if ($option['selectbox'] && ($option['type'] == 'radio' || $option['type'] == 'checkbox')) { # Selectbox wrapper start 
                ?>
                  <div class="dropdown">
                    <button class="btn btn-block btn-<?php echo (isset($selecteds[$option['option_id']]) ? 'warning' : 'default'); ?> dropdown-toggle" type="button" id="dvfilter-selectbox-<?php echo $option['option_id']; ?>" data-toggle="dropdown" aria-expanded="true">
                      <i class="pull-right fa fa-angle-down"></i>
                      <span class="pull-left text-left">
                        <?php if (isset($selecteds[$option['option_id']])) { ?>
                          <?php foreach ($selecteds[$option['option_id']]['values'] as $value) { ?>
                            <?php echo $value['name']; ?><br />
                          <?php } ?>
                        <?php } else { ?>
                          <?php echo $text_any; ?>
                        <?php } ?>
                      </span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dvfilter-selectbox-<?php echo $option['option_id']; ?>">
                      <li role="presentation">
                      <?php } ?>

                      <?php if ($option['type'] == 'select') { # Select type start 
                      ?>

                        <select class="form-control dvf-target<?php echo ($option['selected'] ? ' selected' : ''); ?>">
                          <?php foreach ($option['values'] as $value) { ?>
                            <?php if ($value['selected']) { ?>
                              <option value="<?php echo $value['href']; ?>" id="v-<?php echo $value['id']; ?>" selected="selected"><?php echo $value['name']; ?></option>
                            <?php } elseif ($value['count']) { ?>
                              <option value="<?php echo $value['href']; ?>" id="v-<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                            <?php } else { ?>
                              <option value="" id="v-<?php echo $value['id']; ?>" disabled="disabled"><?php echo $value['name']; ?></option>
                            <?php } ?>
                          <?php } ?>
                        </select>

                      <?php } elseif ($option['type'] == 'slide' || $option['type'] == 'slide_dual') { # Slide type start 
                      ?>
                        <div id="scale-<?php echo $option['option_id']; ?>" class="scale dvf-target" data-option-id="<?php echo $option['option_id']; ?>" data-start-min="<?php echo $option['slide_value_min_get']; ?>" data-start-max="<?php echo $option['slide_value_max_get']; ?>" data-range-min="<?php echo $option['slide_value_min']; ?>" data-range-max="<?php echo $option['slide_value_max']; ?>" data-element-min="#left-value-<?php echo $option['option_id']; ?>" data-element-max="#right-value-<?php echo $option['option_id']; ?>"></div>

                      <?php } elseif ($option['type'] == 'radio' || $option['type'] == 'checkbox') { # Radio and Checkbox types start 
                      ?>
                        <!--#################checkbox###################-->
                        <?php foreach ($option['values'] as $key => $value) { ?>

                          <?php if ($show_values_limit && $show_values_limit == $key) { ?>

                            <?php if ($option['collapse']) { ?>
                              <p>
                                <a id="open_collapse_link-<?php echo $option['option_id']; ?>" class="open_collapse_link" href="#dvfilter-hidden-values-<?php echo $option['option_id']; ?>" data-toggle="collapse" aria-expanded="false" aria-controls="dvfilter-hidden-values"><?php echo $text_show_all; ?> <i class="fa fa-angle-down"></i></a>
                              </p>
                              <div class="collapse" id="dvfilter-hidden-values-<?php echo $option['option_id']; ?>">
                              <?php } else { ?>
                                <p>
                                  <a id="open_collapse_link-<?php echo $option['option_id']; ?>" class="open_collapse_link" href="#dvfilter-hidden-values-<?php echo $option['option_id']; ?>" data-toggle="collapse" aria-expanded="true" aria-controls="dvfilter-hidden-values"><?php echo $text_show_all; ?> <i class="fa fa-angle-down"></i></a>
                                </p>
                                <div class="collapse in" id="dvfilter-hidden-values-<?php echo $option['option_id']; ?>">
                                <?php } ?>
                              <?php } ?>
                              <?php if ($option['color']) { ?>
                                <div class="color" style="background-color: #<?php echo $value['color']; ?>;"></div>
                              <?php } ?>
                              <?php if ($option['image']) { ?>
                                <div class="image" style="background-image: url(<?php echo $value['image']; ?>);"></div>
                              <?php } ?>
                              <?php if ($value['selected']) { ?>
                                <?php if ($option['name'] != 'color') { ?>
                                  <div class="divo-btn" data-toggle="buttons">
                                    <label id="v-<?php echo $value['id']; ?>" class="selected btn divo-check active">
                                      <input type="<?php echo $option['type']; ?>" autocomplete="off" name="dvfilter_filter[<?php echo $option['option_id']; ?>]" value="<?php echo $value['href']; ?>" checked="checked" class="dvf-target" />
                                      <a href="<?php echo $value['href']; ?>"><span class="parametr-filter"><?php echo $value['name']; ?></span></a>
                                      <?php if ($show_counter) { ?>
                                        <small class="badge"></small>
                                      <?php } ?>
                                      <i class="fa fa-check hidden"></i>
                                    </label>
                                  </div>
                                <?php } else {
                                  $color_key = (string)$value['name'];
                                ?>
                                  <div class="divo-btn colored color_selected" data-toggle="buttons">
                                    <label id="v-<?php echo $value['id']; ?>" class="selected btn divo-check active" style="background: <?php echo $filter_colors_array[$color_key]; ?>;" title="<?php echo $color_key; ?>">
                                      <input type="<?php echo $option['type']; ?>" autocomplete="off" name="dvfilter_filter[<?php echo $option['option_id']; ?>]" value="<?php echo $value['href']; ?>" checked="checked" class="dvf-target" title="<?php echo $value['name']; ?>" />
                                      <a href="<?php echo $value['href']; ?>"><span class="parametr-filter hidden"><?php echo $value['name']; ?></span></a>
                                      <?php if ($show_counter) { ?>
                                        <small class="badge"></small>
                                      <?php } ?>
                                      <i class="fa fa-check hidden"></i>
                                    </label>
                                  </div>
                                <?php } ?>
                              <?php } else { ?>
                                <?php if ($option['name'] != 'color') {?>
                                  <div class="divo-btn <?php echo ($value['count']?'':'divo-btn__disabled'); ?>" data-toggle="buttons">
                                    <label id="v-<?php echo $value['id']; ?>" class="btn divo-check">
                                    <?php if ($value['count']) { ?>
                                      <input type="<?php echo $option['type']; ?>" autocomplete="off" name="dvfilter_filter[<?php echo $option['option_id']; ?>]" value="<?php echo $value['href']; ?>" class="dvf-target" />
                                      <?php if ($onclick || $option['selected'] == 1) { ?>
                                        <a onclick="location='<?php echo $value['href']; ?>';"><span class="parametr-filter"><?php echo $value['name']; ?></span></a>
                                      <?php } else { ?>
                                        <a href="<?php echo $value['href']; ?>"><span class="parametr-filter"><?php echo $value['name']; ?></span></a>
                                      <?php } ?>
                                      <?php if ($show_counter) { ?>
                                        <small class="badge"><?php echo $value['count']; ?></small>
                                      <?php } ?>
                                    <?php } else { ?>
                                      <span class="parametr-filter"><?php echo $value['name']; ?></span>
                                    <?php } ?>

                                    </label>
                                  </div>
                                <?php } else {
                                  $color_key = (string)$value['name'];
                                ?>
                                  <div class="divo-btn colored <?php echo ($value['count']?'':'color-disabled'); ?>" data-toggle="buttons">
                                    <label id="v-<?php echo $value['id']; ?>" class="btn divo-check" style="background: <?php echo isset($filter_colors_array[$color_key]) ? $filter_colors_array[$color_key] : '#fff'; ?>;" title="<?php echo $color_key; ?>">
                                    <?php if ($value['count']) { ?> 
                                      <input type="<?php echo $option['type']; ?>" autocomplete="off" name="dvfilter_filter[<?php echo $option['option_id']; ?>]" value="<?php echo $value['href']; ?>" class="dvf-target" title="<?php echo $value['name']; ?>" />
                                    <?php } ?>
                                      <?php if ($show_counter) { ?>
                                        <small class="badge"><?php echo $value['count']; ?></small>
                                      <?php } ?>

                                    </label>

                                  </div>
                                <?php } ?>
                              <?php } ?>
                              <?php if ($show_values_limit && $show_values_limit < count($option['values']) && $key + 1 == count($option['values'])) { ?>
                                </div>
                              <?php } ?>
                            <?php } ?>
                          <?php } # End type switcher 
                          ?>
                          <?php if ($option['selectbox'] && ($option['type'] == 'radio' || $option['type'] == 'checkbox')) { # Selectbox wrapper end 
                          ?>
                      </li>
                    </ul>
                  </div>
                <?php } ?>
              </div>
            </div>

            <?php if ($show_options_limit && $option['index'] == count($options)) { # Closing the hidden options box 
            ?>
              </div>
            <?php } ?>

          <?php } # End "foreach $options" 
          ?>
            </div>
    </div>
    <script type="text/javascript">
      <!--
      $(function() {
        var options = {
          mobile: false,
          php: {
            showPrice: <?php echo $show_price; ?>,
            showCounter: <?php echo $show_counter; ?>,
            manualPrice: <?php echo $manual_price; ?>,
            link: '<?php echo $link; ?>',
            path: '<?php echo $path; ?>',
            params: '<?php echo $params; ?>',
            index: '<?php echo $index; ?>'
          },
          text: {
            show_all: '<?php echo $text_show_all; ?>',
            hide: '<?php echo $text_hide; ?>',
            load: '<?php echo $text_load; ?>',
            any: '<?php echo $text_any; ?>',
            select: '<?php echo $button_select; ?>',
            show_res: '<?php echo $text_show_res; ?>'
          }
        };



        setTimeout(function() {
          $('#dvfilter').dvfilter(options);
        }, 1);
      });
      //
      -->
    </script>
  <?php } ?>

  <style>
    .custom_popover {
      position: relative;
      top: -7px;
      right: -9px;
      padding: 2px 10px;
      background-color: #976ba8;
      color: #fff;
      font-size: 14px;
      line-height: 21px;
      z-index: 999;
    }

    .custom_popover:before {
      content: '';
      position: absolute;
      top: 50%;
      left: -3px;
      margin: -6px 0 0 -9px;
      border: 6px solid transparent;
      border-right-color: #976ba8;
    }
  </style>