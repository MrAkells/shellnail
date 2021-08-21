<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" <?php 
        switch ($route) {
            case 'newsblog/article':
                echo "itemscope itemtype='https://schema.org/Article'";
                break;
            // case 'product/product':
            //     echo "itemscope itemtype='https://schema.org/Product'";
            //     break;
        }?> >
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title;  ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<meta property="og:title" content="<?php echo $title; ?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo $og_url; ?>" />
<?php if ($og_image) { ?>
<meta property="og:image" content="<?php echo $og_image; ?>" />
<?php } else { ?>
<meta property="og:image" content="<?php echo $logo; ?>" />
<?php } ?>
<meta property="og:site_name" content="<?php echo $name; ?>" />
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">
<link href="catalog/view/theme/default/stylesheet/stylesheet.css?v<?php echo $version_stylesheet_css; ?>" rel="stylesheet">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/common.js?v=6" type="text/javascript"></script>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>

<?php if (isset($ishome)) { ?>
    <script type="application/ld+json">
    { 
    "@context": "https://schema.org",
    "@type": "Organization",
    "url": "https://shellnail.com.ua/",
    "priceRange": "$",
    "name": "Товары для ногтей и красоты. Интернет-магазин для маникюра ShellNail Украина",
    "logo": "https://shellnail.com.ua/image/catalog/Logo/ximg-logo.png.pagespeed.ic.bwiMBPQSMS.png",
    "image": [
    "https://shellnail.com.ua/image/cache/catalog/xsale-callus-20-861x331.jpg.pagespeed.ic.KdxraCQtZW.webp",
    "https://shellnail.com.ua/image/cache/catalog/xcanni-sale-861x331.jpg.pagespeed.ic.s90o3T5KTl.webp",
    "https://shellnail.com.ua/image/cache/catalog/xedlen-3-1-akciya-861x331.jpg.pagespeed.ic.G6Q7w86bi-.webp"
    ],
    "sameAs": [
    "https://www.instagram.com/shellnail_shop/?hl=ru", 
    "https://www.facebook.com/groups/shellnail/", 
    "https://www.youtube.com/c/Shellnailshop"
    ],
    "currenciesAccepted": "UAH",
    "paymentAccepted": "cash, credit card",
    "hasMap": "https://g.page/shopshellnail?share",
    "address": {
    "@type": "PostalAddress",
    "@id": "https://shellnail.com.ua/contacts.html",
    "name": "ShellNail, Краматорск", 
    "addressRegion": "Донецкая область",
    "addressLocality": "Краматорск",     
    "postalCode": "84313",
    "streetAddress": "ул.Парковая, 3",
    "telephone": "+38 066 807 70 50",
    "email": "shopshellnail@gmail.com",
    "addressCountry": "UA"
    },
    "contactPoint": [
    { "@type": "ContactPoint",
    "telephone": "+38(066) 807 70 50",
    "contactType": "customer support"
    }],
    "openingHoursSpecification": [
    {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": [
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday"
    ],
    "opens": "09:00",
    "closes": "18:00"
    }
    ]
    }
</script>

<script type="application/ld+json">
    {
    "@context": "https://schema.org",
    "@type": "WebSite",
    "url": "https://shellnail.com.ua/",
    "potentialAction": {
    "@type": "SearchAction",
    "target": "https://shellnail.com.ua/search/?search={search_term_string}",
    "query-input": "required name=search_term_string" }
    }
</script>


<?php } ?>

<?php if ($json_ld) echo $json_ld; ?>


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-59209923-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-59209923-1');
  gtag('config', 'AW-CONVERSION_ID');
</script>
<!-- End of Global site tag (gtag.js) - Google Analytics -->

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-W244K4');</script>
<!-- End Google Tag Manager -->


<!-- Facebook Pixel Code -->
        <script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/ru/fbevents.js');
fbq('init', '1322266524515292'); 
fbq('track', 'PageView');
fbq('track', 'ViewContent');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=1322266524515292&ev=PageView
&noscript=1"/>
</noscript>   
<!-- End Facebook Pixel Code -->

</head>
<body class="<?php echo $class; ?>" >
    
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W244K4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    
 <!-- facebook api element -->
 <div id="fb-root"></div>
 <script>
 (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.5&appId=179241882791748&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
 <!-- end facebook api element -->
    
<!-- Верхние ссылки-->  
<nav id="top" class="hidden-xs">
    <div class="container">
        <div id="top-links" class="nav row">
            <div class="col-lg-9 col-md-11 col-sm-11">
                <ul class="list-inline">
                    <li><a href="<?php echo $payment_and_delivery['href']; ?>"><span><?php echo $payment_and_delivery['text']; ?></span></a> </li>
                    <li><a href="<?php echo $shop_reviews['href']; ?>"><span><?php echo $shop_reviews['text']; ?></span></a></li> 
                    <li><a href="<?php echo $promotions['href']; ?>"><span><?php echo $promotions['text']; ?></span></a></li>  
                    <li><a href="<?php echo $articles['href']; ?>"><span><?php echo $articles['text']; ?></span></a> </li>  
                    <li><a href="<?php echo $for_buyers['href']; ?>"><span ><?php echo $for_buyers['text']; ?></span></a></li>  
                    <li><a href="<?php echo $return_product['href']; ?>"><span><?php echo $return_product['text']; ?></span></a></li> 
                    <li><a href="<?php echo $user_agreement['href']; ?>"><span ><?php echo $user_agreement['text']; ?></span></a></li>
                    <li><a href="<?php echo $contact; ?>"><span><?php echo $text_contact; ?></span></a></li>   
                </ul>
            </div>
            <div class="col-lg-3 col-md-1 col-sm-1 text-right">
                <?php if ( $is_admin == 1) { ?>
                    <div class="top-d-flex">
                <?php } else { ?>
                    <div class="top-d-flex top-d-flex--right">
                <?php } ?>
                <?php if ( $is_admin == 1) { ?>
                    <div class="top-lang"><?php echo $language; ?></div>
                <?php } ?>

                <!-- Личный кабинет-->
                <?php if ($logged) { ?>
                    <li class="dropdown">
                        <a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>" class="dropdown-toggle" >
                            <img src="catalog/view/theme/default/image/icon-avatar.png" alt="Avatar" class="img-avatar"> 
                            <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_account; ?></span>
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="dropdown">  
                        <a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="catalog/view/theme/default/image/icon-avatar.png" alt="Avatar" class="img-avatar">    
                            <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_account; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
                            <li><span type="button" onclick = "$('#login_modal').modal('show')" class="authorization"><span><?php echo $text_login; ?></span></span></li>
                        </ul>
                    </li>
                    <?php } ?>
                <!-- конец личного кабинета -->
                
                </div>

            </div>
        </div>
    </div>
</nav>
<!-- конец верхних ссылок-->

<header>
  <div class="container">
    <div class="row">
        <div id="static_category_menu" class="header_element hidden-xs hidden-sm hidden-md hidden-lg">
            <?php echo $static_header_catalog; ?>
        </div>
        <div id="mobile_top_links" class="header_element visible-xs dropdown">
            <div class="burger burgen-top visible-xs" data-toggle="dropdown">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </div> 
                 <ul class="dropdown-menu">
                <li><a href="<?php echo $payment_and_delivery['href']; ?>"><span><?php echo $payment_and_delivery['text']; ?></span></a> </li>
                <li><a href="<?php echo $shop_reviews['href']; ?>"><span><?php echo $shop_reviews['text']; ?></span></a></li>
                <li><a href="<?php echo $promotions['href']; ?>"><span><?php echo $promotions['text']; ?></span></a></li>
                <li><a href="<?php echo $articles['href']; ?>"><span><?php echo $articles['text']; ?></span></a> </li>
                <li><a href="<?php echo $for_buyers['href']; ?>"><span ><?php echo $for_buyers['text']; ?></span></a></li>
                <li><a href="<?php echo $return_product['href']; ?>"><span><?php echo $return_product['text']; ?></span></a></li>
                <li><a href="<?php echo $user_agreement['href']; ?>"><span ><?php echo $user_agreement['text']; ?></span></a></li>
                <li><a href="<?php echo $contact; ?>"><span><?php echo $text_contact; ?></span></a></li>                
 
                
                 <?php if ($logged) { ?>
                 <li><a href="<?php echo $account; ?>"><span><?php echo $text_account; ?></span></a></li> 
                  <?php } else { ?>
                 <li><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
                <li>
                   
                    <span type="button" onclick = "$('#login_modal').modal('show')"><span class="authorization authorization-xs"><?php echo $text_login; ?></span></span>
                   
                </li>
             <?php } ?>
           
            </ul>
        </div>
        <div class="logo-feature">
            <div id="logo" class="header_element">
            <?php if ($logo) { ?>
                <?php if ($home == $og_url) { ?>
                <img itemprop="logo" src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" />
                <?php } else { ?>
                <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>                <?php } ?>
            <?php } ?>
        </div> 
        <div id="shop_feature" class="header_element hidden-md hidden-sm hidden-xs">
            <?php if ($home == $og_url) { ?>
                <h1 id='h1_shop_feature' itemprop="name"><?php echo $shop_feature; ?></h1>
            <?php }else{ ?>
                <p class="header_shop_feature"><?php echo $shop_feature; ?></p>
            <?php } ?> 
        </div>
    </div>
         
        <div id="phone_numbers" class="header_element">
            <div class="hidden-xs">
                <div class="phone-star pnone-table-row">
                    <div class="left-icon-phone">
                        <img src="catalog/view/theme/default/image/icon-kyivstar.png" alt="icon kyivstar">
                        <img src="catalog/view/theme/default/image/icon-whatsapp.png" alt="icon whatsapp">
                    </div>
                    <div class="right-number-phone">
                       <a href="tel:<?php echo $phone3; ?>"><?php echo $phone3; ?></a> 
                    </div>
                </div>
                <div class="block-mts pnone-table-row">
                    <div class="left-icon-phone">
                        <img src="catalog/view/theme/default/image/icon-mts.png" class="icon-phone-mts" alt="icon mts">
                        <img src="catalog/view/theme/default/image/icon-viber.png" alt="icon viber">
                    </div>
                    <div class="right-number-phone">
                        <a href="tel:<?php echo $phone1; ?>"><?php echo $phone1; ?></a>
                    </div>
                </div>
                <div class="block-life dropdown pnone-table-row">
                    <div class="left-icon-phone">
                        <img src="catalog/view/theme/default/image/icon-life.png" alt="icon life">
                    </div>
                <!--<button class="btn-transparent dropdown-toggle" type="button">-->
                    <div class="right-number-phone">
                        <a href="tel:<?php echo $phone2; ?>"><?php echo $phone2; ?></a>
                <!--</button>-->
                    </div>
                </div>

               </div>
            <div class="visible-xs mobile-telephone dropdown">
             <img src="catalog/view/theme/default/image/icon-phone.png" alt="Phone" class="img-responsive img-buying img-phone" data-toggle="dropdown">
                <div class="dropdown-menu">
                     <div class="phone-star pnone-table-row">
                        <div class="left-icon-phone">
                        <img src="catalog/view/theme/default/image/icon-kyivstar.png" alt="icon kyivstar">
                        <img src="catalog/view/theme/default/image/icon-whatsapp.png" alt="icon whatsapp">
                    </div>
                    <div class="right-number-phone">
                   <a href="tel:<?php echo $phone3; ?>"><?php echo $phone3; ?></a> </div> 
                    </div> 
                    <div class="block-mts pnone-table-row">
                        <div class="left-icon-phone">
                        <img src="catalog/view/theme/default/image/icon-mts.png" class="icon-phone-mts" alt="icon mts">
                        <img src="catalog/view/theme/default/image/icon-viber.png" alt="icon viber">
                    </div>
                    <div class="right-number-phone">
                       <a href="tel:<?php echo $phone1; ?>"><?php echo $phone1; ?></a></div>
                    </div>
                    <div class="block-life pnone-table-row">
                        <div class="left-icon-phone">
                            <img src="catalog/view/theme/default/image/icon-life.png" alt="icon life">
                        </div>
                        <div class="right-number-phone">
                       <a href="tel:<?php echo $phone2; ?>"><?php echo $phone2; ?></a>
                        </div>
                    </div>
                    <div class="block-skype pnone-table-row" >
                        <div class="left-icon-phone">
                            <img src="catalog/view/theme/default/image/icon-skype.png" alt="icon skype">
                        </div>
                        <div class="right-number-phone">
                            <?php echo $skype; ?>
                        </div> 
                    </div>  
                    <p class="bnt-order-bell"> <?php echo $phone_call_back['button']; ?> </p>
                    <div style="clear: both"></div>

                    <div class="shedule-block">
                        <div class="schedule-work"> <?php echo $text_schedule; ?> </div>
                        <div class="schedule-work"> <?php echo $schedule; ?> </div>
                        <div class="schedule-work"> Сб. 10.00-16.00</div>
                    </div>
                </div> 
            </div>
        </div>
        <div id="schedule" class="header_element hidden-xs">
            <p class="schedule-work"> <?php echo $text_schedule; ?> </p>
            <div class="schedule-work"> <?php echo $schedule; ?> </div>
            <div class="schedule-work"> Сб. 10.00-16.00</div>
            <!-- <div class="block-skype" ><span class="skype">   </span><?php echo $skype; ?></div> -->
        </div>
       
            <div id="call_me_back" class="header_element hidden-xs">
            <p class="bnt-order-bell"> <?php echo $phone_call_back['button']; ?> </p>
        </div>
        <div id="compare_link" class="header_element hidden-xxs">
            <a href="<?php echo $compare['href']; ?>">
            <?php if($compare['total']){ ?>
            <img src="catalog/view/theme/default/image/icon-compare.png" alt="Compare" class="img-responsive img-buying">
            <span class="sum"><?php echo $compare['total']; ?></span>
            <?php } else{ ?>
            <img src="catalog/view/theme/default/image/icon-compare_gray.png" alt="Compare" class="img-responsive img-buying">
            <?php } ?>
            <span class="hidden-xs hidden-sm buying"><?php echo $compare['text']; ?></span>
            </a>
        </div>
        <div id="wishlist_link" class="header_element hidden-xxs">
            <a href="<?php echo $wishlist; ?>" id="wishlist-total" title="<?php echo $text_wishlist1; ?>">
            <div class="tunic">
                <?php if($count_wishlist){ ?>
                <img src="catalog/view/theme/default/image/icon-wishlist.png" alt="Wishlist" class="img-responsive img-buying img-heart">
                <?php echo $text_wishlist; ?><span class="sum"><?php echo $count_wishlist; ?></span>
                <?php } else{ ?>
                 <img src="catalog/view/theme/default/image/icon-wishlist_gray.png" alt="Wishlist" class="img-responsive img-buying img-heart">
                <?php echo $text_wishlist; ?>
                <?php } ?>

                </div>
            </a>
            
        </div>
        
       
      <div id="cart_element" class="header_element"><?php echo $cart; ?></div>

        
    </div>

  </div>
</header>
    
    <div class="container">
        <div class="row">
            <div id="menu_button" class="hidden-xs hidden-sm">
                <?php if(isset($header_catalog)){ ?>
                    <?php echo $header_catalog; ?>
                <?php }else{ ?>
                <div id="false_menu_button">
                    <button>
                        <div class="burger">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </div>
                        <span class="title-menu"><?php echo $text_category_catalog; ?></span>
                    </button>
                </div>
              
                <?php } ?>
             

            </div>
            
            <div id="header_search" >
                <?php echo $search; ?>
            </div>
        </div>
    </div>
    
    <?php if(!$logged){ 
        echo $login_form;
     } ?>
   <?php echo $phone_call_back['modal']; ?>
   
  