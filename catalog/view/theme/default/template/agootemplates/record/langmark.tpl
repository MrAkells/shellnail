<?php if (count($languages) > 1) { ?>
<?php if (SC_VERSION < 20) { ?>
<div id="langmark">
  <?php echo $text_language; ?>
    <?php foreach ($languages as $language) { ?>
    <?php if ($language['current']) { ?>
    <span class="language-current" aria-current="true"><img src="image/flags/<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>"></span>
    <?php } else { ?>
    <a href="<?php echo $language['url']; ?>"><img src="image/flags/<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>"></a>
    <?php } ?>
    <?php } ?>
</div>
<?php } else { ?>
<div class="pull-left">
  <div class="btn-group">
    <button class="btn btn-link dropdown-toggle" data-toggle="dropdown">
    <!-- <?php foreach ($languages as $language) { ?>
    <?php if ($language['current']) { ?>
    <?php if (SC_VERSION < 22) { ?>
    <img src="image/flags/<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>">
    <?php } else { ?>
    <img src="catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>">
    <?php } ?>
    <?php } ?>
    <?php } ?> -->
    <span class=""><?php echo $text_language; ?></span> <i class="fa fa-caret-down"></i></button>
    <ul class="dropdown-menu">
      <?php foreach ($languages as $language) { ?>
      <?php if ($language['current']) { ?>
      <li><span class="language-current" aria-current="true"><!-- <?php if (SC_VERSION < 22) { ?><img src="image/flags/<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>" /><?php } else { ?><img src="catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>"><?php } ?> --><?php echo $language['name']; ?></span></li>
      <?php } else { ?>
      <li><a href="<?php echo $language['url']; ?>"><!-- <?php if (SC_VERSION < 22) { ?><img src="image/flags/<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>" /><?php } else { ?><img src="catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>"><?php } ?> --><?php echo $language['name']; ?></a></li>
      <?php } ?>
      <?php } ?>
    </ul>
  </div>
</div>
<?php } ?>
<?php } ?>
