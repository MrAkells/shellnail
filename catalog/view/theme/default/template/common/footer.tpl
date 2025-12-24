<footer>
    <div class="footer-top">
        <div class="container">
            <div class="row row-flex">

                <div class="col-md-3 col-sm-6 col-xs-6 logo_info">
                    <div class="logo_info-middle">
                        <div>
                            <?php if ($logo) { ?>
                                <?php if ($home == $og_url) { ?>
                                    <img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" />
                                <?php } else { ?>
                                    <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <div class="owner-moto">
                            <?php echo $owner_moto_footer; ?>
                        </div>
                    </div>

                </div>

                <div class="col-md-2 col-sm-6 col-xs-6 block-work">
                    <div class="title-footer hidden-sm hidden-xs">
                        <strong><?php echo $second_block_title; ?></strong>
                    </div>
                    <div class="town_ukraine">
                        <?php echo $second_block; ?>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-6 block-contact">
                    <div class="title-footer">
                        <strong> <?php echo $text_contact; ?> </strong>
                    </div>
                    <div class="contact_footer">
                        <div class="phone-star pnone-table-row">
                            <div class="left-icon-phone">
                                <img src="catalog/view/theme/default/image/icon-kyivstar.png" alt="icon kyivstar">
                                <img src="catalog/view/theme/default/image/icon-whatsapp.png" alt="icon whatsapp">
                            </div>
                            <div class="right-number-phone">
                                <a href="tel:<?php echo $phone3; ?>">
                                    <?php echo $phone3; ?>
                                </a>
                            </div>
                        </div>
                        <div class="block-mts pnone-table-row">
                            <div class="left-icon-phone">
                                <img src="catalog/view/theme/default/image/icon-mts.png" class="icon-phone-mts" alt="icon mts">
                                <img src="catalog/view/theme/default/image/icon-viber.png" alt="icon viber">
                            </div>
                            <div class="right-number-phone">
                                <a href="tel:<?php echo $phone1; ?>">
                                    <?php echo $phone1; ?>
                                </a>
                            </div>
                        </div>
                        <div class="block-life dropdown pnone-table-row">
                            <div class="left-icon-phone">
                                <img src="catalog/view/theme/default/image/icon-life.png" alt="icon life">
                            </div>
                            <!--<button class="btn-transparent dropdown-toggle" type="button">-->
                            <div class="right-number-phone">
                                <a href="tel:<?php echo $phone2; ?>">
                                    <?php echo $phone2; ?>
                                </a>
                                <!--</button>-->
                            </div>
                        </div>
                    </div>
                    <div class="block-shedule hidden-sm hidden-xs">
                        <div class="title-footer">
                            <strong><?php echo $text_schedule; ?></strong>
                        </div>
                        <div class="shedule">
                            <?php echo $schedule; ?><br> Сб. 10.00-16.00
                        </div>
                    </div>

                </div>

                <div class="col-md-2 col-sm-6 col-xs-6 useful-information">
                    <div class="title-footer">
                        <strong> <?php echo $text_useful_info; ?> </strong>
                    </div>
                    <div class="link-footer">
                        <div>
                            <a href="<?php echo $page_reviews; ?>">
                                <?php echo $text_reviews; ?>
                            </a>
                        </div>
                        <div>
                            <a href="<?php echo $link_to_articles_category; ?>">
                                <?php echo $text_articles; ?>
                            </a>
                        </div>
                        <div>
                            <a href="<?php echo $promotions; ?>">
                                <?php echo $text_promotions; ?>
                            </a>
                        </div>
                        <div>
                            <a href="<?php echo $sitemap; ?>">
                                <?php echo $text_sitemap; ?>
                            </a>
                        </div>
                        <div>
                            <a href="<?php echo $informations['7']['href']; ?>">
                                <?php echo $informations['7']['title']; ?>
                            </a>
                        </div>

                        <?php if (isset($informations['17'])) { ?>
                            <div>
                                <a href="<?php echo $informations['17']['href']; ?>">
                                    <?php echo $informations['17']['title']; ?>
                                </a>
                            </div>
                        <?php } ?>

                        <div>
                            <a class="link-footer-payment" href="<?php echo $informations['6']['href']; ?>">
                                <?php echo $informations['6']['title']; ?>
                                <div class="image_accept_payment"><img src="catalog/view/theme/default/image/payment/icon_payment_master_card.png" alt="Mastercard"><img src="catalog/view/theme/default/image/payment/icon_payment_visa.png" alt="Visa"></div>
                            </a>
                        </div>

                    </div>

                </div>



                <div class="col-md-2 col-sm-6 col-xs-6 personal-area">
                    <div class="title-footer">
                        <strong><?php echo $text_account; ?></strong>
                    </div>

                    <ul class="list-unstyled link-footer">
                        <li>
                            <a href="<?php echo $account; ?>">
                                <?php echo $text_account; ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $order; ?>">
                                <?php echo $text_order; ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $wishlist; ?>">
                                <?php echo $text_wishlist; ?>
                            </a>
                        </li>

                    </ul>
                    <div class="our-public">
                        <div class="title-footer">
                            <strong><?php echo $text_our_public; ?></strong>
                        </div>

                        <ul class="soc-icon">
                            <li>
                                <a onclick="location = '<?php echo $instagram; ?>';" rel="nofollow"><img src="catalog/view/theme/default/image/icon-instagram.png" alt="Instagram"></a>
                            </li>
                            <li>
                                <a onclick="location = '<?php echo $facebook; ?>';" rel="nofollow"><img src="catalog/view/theme/default/image/icon-facebook.png" alt="Facebook"></a>
                            </li>
                            <li>
                                <a onclick="location = '<?php echo $youtube; ?>';" rel="nofollow"><img src="catalog/view/theme/default/image/icon-youtube.png" alt="Youtube"></a>
                            </li>
                        </ul>
                    </div>


                </div>
                <div class="col-sm-6 shedule-sm hidden-lg hidden-md">
                    <div class="block-shedule">
                        <div class="title-footer">
                            <strong><?php echo $text_schedule; ?></b>
                        </div>
                        <div class="shedule">
                            <?php echo $schedule; ?><br>
                            Сб. 10.00-16.00
                        </div>
                    </div>
                    <div class="our-public our-public-copy">
                        <div class="title-footer">
                            <strong><?php echo $text_our_public; ?></strong>
                        </div>

                        <ul class="soc-icon">
                            <li>
                                <a href="<?php echo $instagram; ?>" rel="nofollow"><img src="catalog/view/theme/default/image/icon-instagram.png" alt="Instagram"></a>
                            </li>
                            <li>
                                <a href="<?php echo $facebook; ?>" rel="nofollow"><img src="catalog/view/theme/default/image/icon-facebook.png" alt="Facebook"></a>
                            </li>
                            <li>
                                <a href="<?php echo $youtube; ?>" rel="nofollow"><img src="catalog/view/theme/default/image/icon-youtube.png" alt="Youtube"></a>
                            </li>
                        </ul>
                    </div>
                </div>


            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <p>
            <?php echo $powered; ?>
        </p>
    </div>
    <div id="scroll-top" class="hidden-xs"> </div>
</footer>
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!--Push-messages-->
<script charset="UTF-8" src="//cdn.sendpulse.com/js/push/201955e6573e29dfc2d595efa182a63e_1.js" async></script>
<!--/Push-messages-->
<script type="text/javascript">
    $(document).ready(function() {
        $("#scroll-top").hide();
        $(function() {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    $('#scroll-top').fadeIn();
                } else {
                    $('#scroll-top').fadeOut();
                }
            });
            $('#scroll-top').click(function() {
                $('body,html').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
        });
        /*
        setTimeout(function tick() {
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/ru/fbevents.js');
            fbq('init', '1980090912831695');
            fbq('track', 'PageView');
            fbq('track', 'ViewContent');

            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = 'https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.5&appId=179241882791748&autoLogAppEvents=1';
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));

        }, 3000);
        */
    });
</script>

<script type="text/javascript">
    (function(d, w, s) {
        var widgetHash = '9Q7b9yCxX0T0oqqm19rM',
            bch = d.createElement(s);
        bch.type = 'text/javascript';
        bch.async = true;
        bch.src = '//widgets.binotel.com/chat/widgets/' + widgetHash + '.js';
        var sn = d.getElementsByTagName(s)[0];
        sn.parentNode.insertBefore(bch, sn);
    })(document, window, 'script');
</script>


<!--------------------SNOWFALL---good----------------------------------->
<!--
<script src="catalog/view/javascript/snowfall/snowfall.js"></script>
<script type="text/javascript">
    
$(document).snowfall({
flakeCount: 150,
minSize: 1, 
maxSize:4,
maxSpeed:3,
minSpeed:1,

round: true,
shadow: true
});

</script>
-->
<!--------------------//SNOWFALL-------------------------------------->

</body>

</html>