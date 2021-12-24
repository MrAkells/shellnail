<?php echo $header; ?>
<div class="container">
  <div class="row">
  <?php echo $column_left; ?>
  
    <div id="content" class="col-xs-12 col-md-9">
      <ul class="breadcrumbs list-inline" itemscope itemtype="http://schema.org/BreadcrumbList">
           <?php $i=0; ?>
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
         <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" class="crumb" href="<?php echo $breadcrumb['href']; ?>"><span itemprop="name"><?php echo $breadcrumb['text']; ?></span></a>
        <meta itemprop="position" content="<?php echo $i++; ?>">
        </li>
        <?php } ?>
      </ul>
    <div class="hidden-md hidden-lg mini-catalog-сategory">
        <?php echo $mini_catalog; ?>
    </div>        
            <h1 itemprop="name"><?php echo $heading_title; ?></h1>
            <div class="text-shopreview">
                <p><?php echo $text_greetings; ?></p>
                <p><?php echo $text_you_can_rate; ?></p>
            </div>
           
           
        <ul class="nav nav-tabs new-nav-tabs review-tabs">
            <li class="active"><a data-toggle="tab" href="#reviews"><?php echo $text_ourreviews; ?> (<?php echo $review_total; ?>)</a></li>
            <li>
                <a data-toggle="tab" href="#facebook_reviews">
                    Facebook
                    (<span class="fb-comments-count" data-href="http://shellnail.com.ua/">...</span>)
                </a></li>
            
        </ul>

<div class="tab-content">
  <div id="reviews" class="tab-pane fade in active">
        
       <div id="shopreview"></div>
       <br/><br/>
       <?php echo $content_top; ?>   
  </div>
  <div id="facebook_reviews" class="tab-pane fade">
      
       <?php echo $content_bottom; ?>
     
  </div>
  
</div>
        
     
    
    </div>
  </div>
</div>

<script type="text/javascript">
  
function updateShareCount (permalinkWPSC) {
   return $.ajax({
        url: 'https://graph.facebook.com/?id=' + permalinkWPSC,
        type: 'GET',
        dataType: 'JSONP',
        success: function(data) {
            if (data.share) {	
                $(".myfb-comments-count").html(data.share.comment_count);
            }
       }
    });
 }
 
 $(document).ready(function(){
    var permalinkWPSC = 'http://shellnail.com.ua/';
    updateShareCount(permalinkWPSC);
 });
    
</script>

<?php echo $footer; ?>