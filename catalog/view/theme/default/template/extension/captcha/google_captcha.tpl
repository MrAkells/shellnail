<script src="//www.google.com/recaptcha/api.js?hl=<?php echo $lang; ?>" type="text/javascript"></script>
<fieldset>
  <!-- <legend><?php echo $text_captcha; ?></legend> -->
  <div class="form-group required">
    <?php if (substr($route, 0, 9) == 'checkout/') { ?>
    <label class="control-label" for="input-payment-captcha"><?php echo $entry_captcha; ?></label>
    <div id="input-payment-captcha" class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>"></div>
    <?php if ($error_captcha) { ?>
    <div class="text-danger"><?php echo $error_captcha; ?></div>
    <?php } ?>
    <?php } else { ?>
    <div class="col-sm-1"></div>
    <label class="hidden-xs col-sm-3 control-label"><span class=""><?php echo $entry_captcha; ?></span></label>
    <div class="col-xs-12 col-sm-8">
      <div style="margin-right: -5px;" class="g-recaptcha pull-right" data-sitekey="<?php echo $site_key; ?>"></div>
      <?php if ($error_captcha) { ?>
      <div class="text-danger"><?php echo $error_captcha; ?></div>
      <?php } ?>
    </div>
    <?php } ?>
  </div>
</fieldset>
