<?php
// Heading
$_['v_mod'] = '1';
$_['vers_mod'] = '2.3.'.$_['v_mod'];
$_['p_mod'] = 'Static Sitemap';
$_['heading_title'] = '<b style="color:#9CB43E"><i class="fa fa-globe fa-lg"></i> '.$_['p_mod'].'_v.'.$_['vers_mod'].'</b>';
$_['title'] = $_['p_mod'].'_v.'.$_['vers_mod'];

//tab_nav
$_['text_general'] = 'Основные';

$_['legnd_sitemap'] = 'Sitemaps';
$_['help_sitemap'] = 'Сгенерировать '.$_['legnd_sitemap'];

//button
$_['button_apply'] = 'Применить';
$_['button_exit'] = 'Выйти';
$_['button_save'] = 'Сохранить настройки';
$_['button_copy'] = 'Копировать';
$_['button_add'] = 'Создать'.' '.$_['legnd_sitemap'];
$_['button_delit'] = 'Удалить'.' '.$_['legnd_sitemap'];

//text
$_['text_module'] = 'Модуль';
$_['text_success'] = 'Настройки модуля обновлены!';
$_['text_success_delit'] = 'Удалены '.$_['legnd_sitemap'];
$_['text_edit2'] = 'Редактирование модуля';
$_['text_avtor'] = 'Другие разработки автора';
$_['text_main'] = 'Общие настройки';
$_['text_ya'] = 'Yandex';
$_['text_htaccess'] = '!!! Важно: <br /> в файле .htaccess, который расположен в корне вашего сайта, <br /> найдите строку, начинающуюся с <br /> RewriteRule ^sitemap.xml$ index.php?route= <br /> и закомментируйте ее вот так: <br /> #RewriteRule ^sitemap.xml$ index.php?route=';

$_['legnd_product'] = 'Товара';
$_['legnd_category'] = 'Категорий';
$_['legnd_manufacturer'] = 'Производителей';
$_['legnd_information'] = 'Информаций';
$_['legnd_others'] = 'Другие модули';
$_['help_others'] = 'Создание '.$_['legnd_sitemap'].' для других/недефолтных модулей: фильтров, блогов, новостей и т.п. (модули подключать при помощи модификатора в файле /catalog/model/sitemap/stat_sitemap_vier.php после $output = \'\'; Принимает уже готовый $output без обертки &lt;&frasl;urlset&gt; )';

//
$_['legnd_protocol'] = 'Протокол:';
$_['help_protocol'] = 'Укажите протокол согласно настроек сайта';
$_['legnd_continue'] = 'только ЧПУ:';
$_['help_continue'] = 'Не учитывать ссылки вида `index.php?route=`';
$_['legnd_last_main'] = 'lastmod-index:';
$_['help_last_main'] = 'Включать дату сгенерированных всех sitemap. (Устанавливает текущую дату на момент создания основного/индексного sitemap)';
$_['legnd_sek_key'] = 'Пароль:';
$_['help_sek_key'] = 'Для защиты. Использовать только буквы, числа, тире и подчеркивание.';
$_['legnd_ya'] = $_['legnd_sitemap'].' '.$_['text_ya'];
$_['help_ya'] = 'При установке галки и повторном нажатии на `'.$_['button_add'].'`, можно создать еще один новый sitemap под другим именем для Яндекса (без учета картинок). При нажатии `'.$_['button_delit'].'` - удалит '.$_['legnd_sitemap'].' '.$_['text_ya'];

$_['legnd_changefreq'] = 'Частота обновления:';
$_['help_changefreq'] = 'Укажите частоту обновления страницы';
$_['legnd_priority'] = 'Приоритетность:';
$_['help_priority'] = 'Укажите приоритетность';
$_['legnd_lastmod'] = 'lastmod:';
$_['help_lastmod'] = 'Включать дату последних изменений';
$_['legnd_images'] = 'images:';
$_['help_images'] = 'Включать картинки';
$_['help_warning'] = '- увеличивает нагрузку!';
$_['help_ya_warning'] = '(Яндекс картинки не поддерживает)!';

//
$_['legnd_lic'] = 'Введите лицензионный ключ:';
$_['bott_lic'] = 'Активировать';
$_['legnd_get_key'] = 'Запросить Лиц.ключ:';
$_['bott_get_key'] = 'Запросить';
$_['err_time_out'] = 'Превышен лимит.';
$_['err_no_domen'] = 'Нет данных.';
$_['err_bag_domen'] = 'ERROR.';
$_['err_no_prod'] = 'ERROR product.';
$_['err_error'] = 'Ошибка запроса.';
$_['visit_mail'] = 'Обратитесь к разработчику: vier9@ukr.net';
$_['devels'] = 'https://oc-vier.ru';

//succ
$_['succ_file'] = 'Файл <b><a href="/%1$s.xml" target="_blank">%1$s.xml</a></b> создан (%2$s sec.- %3$s b)';
$_['succ_rez'] = '<a href="/%1$s" target="_blank">%2$s</a>';

// Entry
$_['entry_status'] = 'Статус:';

// Error
$_['error_permission'] = 'У Вас нет прав для управления этим модулем!';
$_['error_sek_key'] = 'Вы не заполнили <b>'.$_['legnd_sek_key'].'</b> для секретного ключа!!!';
$_['error_operac'] = 'Ошибка операции!!!';
$_['error_protocol'] = 'Ошибка протокола!!!';
$_['error_parse'] = 'ERROR parse array!!';
$_['error_rec'] = 'Не удачная попытка создать файл';

?>