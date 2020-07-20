<!-- extension/module/shopreview_list.tpl -->
<?php if ($reviews) { ?>
<?php foreach ($reviews as $review) { ?>
<table class="table-striped table-reviews">
  <tr>
    <td class="first-td-reviews"><div class="review-name"><?php echo $review['author']; ?></div>
    <div class="date-review"><?php echo $review['date_added']; ?></div>
    <div class="rating">

      <?php for ($i = 1; $i <= 5; $i++) { ?>
      <?php if ($review['rating'] < $i) { ?>
       <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
      <?php } else { ?>
     <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
      <?php } ?>
      <?php } ?>
    </div>
    </td>
    <td class="text-justify second-td-reviews">
        <div class="text-review"><?php echo $review['text']; ?></div>
        <?php if($review['answer']){ ?>
        <div class="admin-response">
          <div class="title-admin-response"><?php echo $text_answer; ?></div>
          <div class=" text-review text-admin-response"><?php echo $review['answer']; ?></div>
        </div>
      <?php } ?>

        <?php if($review['image']){ ?>
        <div class="image text-right">
          <img src="<?php echo $review['image']; ?>" alt=""/>
        </div>
        <?php }else{ ?>
    
        <!--<div class="image text-right">
          <img src="<?php echo $defaultimage; ?>" alt=""/>
        </div>-->
    
        <?php } ?>

    </td>
  </tr>
</table>
<?php } ?>
<div class="text-center"><?php echo $pagination; ?></div>
<?php } else { ?>
<p><?php echo $text_no_reviews; ?></p>
<?php } ?>

