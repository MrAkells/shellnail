<?php
// Heading
$_['v_mod'] = '1';
$_['vers_mod'] = '2.3.'.$_['v_mod'];
$_['p_mod'] = 'Static Sitemap';
$_['heading_title'] = '<b style="color:#9CB43E"><i class="fa fa-globe fa-lg"></i> '.$_['p_mod'].'_v.'.$_['vers_mod'].'</b>';
$_['title'] = $_['p_mod'].'_v.'.$_['vers_mod'];

//tab_nav
$_['text_general'] = 'General';

$_['legnd_sitemap'] = 'Sitemaps';
$_['help_sitemap'] = 'Generate '.$_['legnd_sitemap'];

//button
$_['button_apply'] = 'Apply';
$_['button_exit'] = 'Exit';
$_['button_save'] = 'Save settings';
$_['button_copy'] = 'Copy';
$_['button_add'] = 'Add'.' '.$_['legnd_sitemap'];
$_['button_delit'] = 'Remove'.' '.$_['legnd_sitemap'];

//text
$_['text_module'] = 'Module';
$_['text_success'] = 'Module settings updated!';
$_['text_success_delit'] = 'Removed '.$_['legnd_sitemap'];
$_['text_edit2'] = 'Editing module';
$_['text_avtor'] = 'Other author\'s developments';
$_['text_main'] = 'General settings';
$_['text_ya'] = 'Yandex';
$_['text_htaccess'] = '!!! Importantly: <br /> in file .htaccess, which is located at the root of your site, <br /> find the line starting with <br /> RewriteRule ^sitemap.xml$ index.php?route= <br /> and comment it out like this: <br /> #RewriteRule ^sitemap.xml$ index.php?route=';

$_['legnd_product'] = 'Products';
$_['legnd_category'] = 'Categories';
$_['legnd_manufacturer'] = 'Manufactures';
$_['legnd_information'] = 'Information';
$_['legnd_others'] = 'Other Modules';
$_['help_others'] = 'Creature '.$_['legnd_sitemap'].' for other/non-default modules: filters, blogs, news, etc. (plug in modules using the modifier in the file /catalog/model/sitemap/stat_sitemap_vier.php after $output = \'\'; It takes the finished $output without wrappers &lt;&frasl;urlset&gt; )';

//
$_['legnd_protocol'] = 'Protocol:';
$_['help_protocol'] = 'Specify the protocol according to the site settings';
$_['legnd_continue'] = 'only SEO_URL:';
$_['help_continue'] = 'Do not include references like `index.php?route=`';
$_['legnd_last_main'] = 'lastmod-index:';
$_['help_last_main'] = 'Include the date of all generated sitemap. (Sets the current date at the time the main / index sitemap was created)';
$_['legnd_sek_key'] = 'Password:';
$_['help_sek_key'] = 'For protection. Use only letters, numbers, dashes, and underscores.';
$_['legnd_ya'] = $_['legnd_sitemap'].' '.$_['text_ya'];
$_['help_ya'] = 'When you install a daw and click on `'.$_['button_add'].'`, You can create another new sitemap under a different name for the Yandex (without pictures). When you click `'.$_['button_delit'].'` - will remove '.$_['legnd_sitemap'].' '.$_['text_ya'];

$_['legnd_changefreq'] = 'Update frequency:';
$_['help_changefreq'] = 'Specify the frequency of page updates';
$_['legnd_priority'] = 'Priority:';
$_['help_priority'] = 'Specify a priority';
$_['legnd_lastmod'] = 'lastmod:';
$_['help_lastmod'] = 'Include the date of the last changes';
$_['legnd_images'] = 'images:';
$_['help_images'] = 'Include pictures';
$_['help_warning'] = '- increases the load!';
$_['help_ya_warning'] = '(Yandex does not support images)!';

//
$_['legnd_lic'] = 'Enter the license key:';
$_['bott_lic'] = 'Activate';
$_['legnd_get_key'] = 'Request Lyc.key:';
$_['bott_get_key'] = 'Request';
$_['err_time_out'] = 'Limit exceeded.';
$_['err_no_domen'] = 'No data.';
$_['err_bag_domen'] = 'ERROR.';
$_['err_no_prod'] = 'ERROR product.';
$_['err_error'] = 'The request failed.';
$_['visit_mail'] = 'Contact the developer: vier9@ukr.net';
$_['devels'] = 'https://oc-vier.ru';

//succ
$_['succ_file'] = 'File <b><a href="/%1$s.xml" target="_blank">%1$s.xml</a></b> created (%2$s sec.- %3$s b)';
$_['succ_rez'] = '<a href="/%1$s" target="_blank">%2$s</a>';

// Entry
$_['entry_status'] = 'Status:';

// Error
$_['error_permission'] = 'You are not allowed to control this module!';
$_['error_sek_key'] = 'You did not fill out <b>'.$_['legnd_sek_key'].'</b> for the private key!!!';
$_['error_operac'] = 'Operation failed!!!';
$_['error_protocol'] = 'Protocol error!!!';
$_['error_parse'] = 'ERROR parse array!!';
$_['error_rec'] = 'Not a successful attempt to create a file';

?>