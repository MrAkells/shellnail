<?php
// Heading
$_['heading_title']     = 'Buy one click';

// Text
$_['text_module']       = 'Модули';
$_['text_success']      = 'Настройки успешно изменены!';
$_['text_edit']         = 'Настройки модуля';

// Fields
$_['img_title'] 		= 'Изображение и цена товара в доп. поле';
$_['field1_title'] 		= 'Имя';
$_['field2_title'] 		= 'Телефон';
$_['field3_title'] 		= 'E-mail';
$_['field4_title'] 		= 'Комментарий';
$_['field_required']    = 'Обязательное поле';

// Phone validation
$_['entry_validation_type']		= 'Маска проверки тел. номера';
$_['value_validation_type1']	= '+7(000)000-00-00';
$_['value_validation_type2']	= '+38(000)000-00-00';
$_['text_validation_type1']		= 'Россия: +7(000)000-00-00';
$_['text_validation_type2']		= 'Украина: +38(000)000-00-00';
$_['entry_validation_status']	= 'Включить проверку номера';

// SMS.ru
$_['smsru_form_title'] 			= 'Настройка <strong>SMS</strong>.ru';
$_['smsru_api_title']			= 'Ваш api_id';
$_['smsru_api_tooltip']			= 'По умолчанию для отправки СМС используется Ваш api_id (такого вида - XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX), посмотреть который можно у себя в личном кабинете SMS.ru. В этом случае заполнять поля Login и пароль не требуется. Если Вы хотите использовать авторизацию через Login и пароль - не заполняйте данное поле, тогда будут использованы поля Login и пароль.';
$_['smsru_login_title']			= 'Ваш login на sms.ru';
$_['smsru_password_title']		= 'Ваш пароль на sms.ru';
$_['smsru_number_title']		= 'Номер получателя SMS';
$_['smsru_number_tooltip']		= 'Обязательно используйте международный формат: +79876543210. Чтобы бесплатно получать СМС-сообщения - необходимо чтобы номер совпадал с номером в личном кабинете sms.ru<br />* <em>Сообщения на собственный номер <strong>бесплатны до 5 СМС в день</strong> при условии, что каждое сообщение помещается в 1 СМС (до 70 русских / 160 латинских символов). При превышении этих лимитов, сообщения оплачиваются согласно тарифу.</em>';
$_['smsru_name_title']			= 'Подпись отправителя';
$_['smsru_name_tooltip']		= 'По умолчанию: Ваш номер телефона. Если Вы хотите установить своё имя в имени отправителя - необходимо согласовать данный вопрос с администрацией sms.ru. Подробнее читайте в разделе "Отправители" Вашего личного кабинета sms.ru. Согласование бесплатное. Абонентской платы за пользование отправителем нет.';
$_['smsru_admin_sms_title']		= 'Шаблон сообщения администратору';
$_['smsru_admin_sms_tooltip']	= 'Стандартный шаблон СМС администратору: <b><em>Заказ: {product}. Покупатель: {name} {phone} {email}</b></em><br />Если не знаете что вписать - оставьте пустым! Подробнее о шаблонах Вы можете прочитать здесь: <a href="http://ocshop.xdomus.ru/buy_one_click.htm" target="_blank">FAQ по модулю</a>';
$_['smsru_client_sms_title']	= 'Шаблон сообщения клиенту';
$_['smsru_client_sms_tooltip']	= 'Стандартный шаблон СМС клиенту: <b><em>Спасибо за Ваш заказ на {product} в интернет-магазине "{shop_name}"! Мы свяжемся с Вами для подтверждения заказа!</em></b> Подробнее о шаблонах Вы можете прочитать здесь: <a href="http://ocshop.xdomus.ru/buy_one_click.htm" target="_blank">FAQ по модулю</a>';
$_['smsru_client_status_title']		= 'Включить отправку СМС покупателю';
$_['smsru_client_status_tooltip']	= 'Обязательно включите проверку номера телефона!';
$_['smsru_status_title']		= 'Включить SMS.ru';

// TurboSMS
$_['turbosms_form_title'] 		= 'Настройка <strong>Turbo</strong>SMS.ua';
$_['turbosms_login_title']		= 'Login шлюза';
$_['turbosms_password_title']	= 'Пароль шлюза';
$_['turbosms_number_title']		= 'Номер получателя SMS';
$_['turbosms_number_tooltip']	= 'Обязательно используйте международный формат: +79876543210';
$_['turbosms_name_title']		= 'Подпись отправителя';
$_['turbosms_name_tooltip']		= 'По умолчанию: Msg. Если Вы хотите установить своё имя в имени отправителя - изучите документацию, а именно раздел "Подписи". Видеоинструкция - <a href="https://youtu.be/RpC4aLpLHZM" target="_blank">YouTube</a>';
$_['turbosms_admin_sms_title']		= 'Шаблон сообщения администратору';
$_['turbosms_admin_sms_tooltip']	= 'Стандартный шаблон СМС администратору: Заказ: {product}. Покупатель: {name} {phone} {email} <br /><strong>Если не знаете что вписать - оставьте пустым!</strong> Подробнее о шаблонах Вы можете прочитать здесь: <a href="http://ocshop.xdomus.ru/buy_one_click.htm" target="_blank">FAQ по модулю</a>';
$_['turbosms_client_sms_title']	= 'Шаблон сообщения клиенту';
$_['turbosms_client_sms_tooltip']	= 'Стандартный шаблон СМС клиенту: Спасибо за Ваш заказ на {product} в интернет-магазине: "{shop_name}"! Мы свяжемся с Вами для подтверждения заказа! <br /><strong>Если не знаете что вписать - оставьте пустым!</strong> Подробнее о шаблонах Вы можете прочитать здесь: <a href="http://ocshop.xdomus.ru/buy_one_click.htm" target="_blank">FAQ по модулю</a>';
$_['turbosms_client_status_title']		= 'Включить отправку СМС покупателю';
$_['turbosms_client_status_tooltip']	= 'Обязательно включите проверку номера телефона!';
$_['turbosms_status_title']		= 'Включить TurboSMS';

// Yandex
$_['ya_form_title'] 			= 'Настройка <strong><span style="color:red;">Я</span>ндекс</strong> цели';
$_['ya_counter_title']			= 'Номер Вашего Яндекс счетчика';
$_['ya_identificator_title']	= 'Идентификатор Вашей Яндекс цели';
$_['ya_target_status_title']	= 'Включить Яндекс цель';

// Google
$_['google_form_title'] 			= 'Настройка <strong><span style="color:#4285f4;">G</span>oogle</strong> цели';
$_['google_category_title']			= 'Категория';
$_['google_action_title']			= 'Действие';
$_['google_target_status_title']	= 'Включить Google цель';

// Entry
$_['entry_name'] 				= 'Название кнопки "Купить"';
$_['entry_preorder_name'] 		= 'Название кнопки "Заказать"';
$_['entry_status'] 				= 'Быстрый заказ в карточке товара';
$_['entry_status_category'] 	= 'Быстрый заказ в категории';
$_['entry_style_status'] 		= 'Использовать стили buyoneclick.css (blue edition)';
$_['entry_additional_field'] 	= 'Текст в дополнительном поле';
$_['additional_field_required'] = 'Включено';
$_['additional_field_tooltip']	= 'Допустимо использовать html-теги';
$_['entry_success_field'] 		= 'Текст во всплывающем окне (успешная отправка)';
$_['success_field_tooltip']		= 'Текст по умолчанию: "<h4>Спасибо за Ваш заказ!<br />Мы свяжемся с Вами в самое ближайшее время.</h4>". Вы можете использовать html-теги.';


// Error
$_['error_permission']  = 'У Вас нет прав для управления данным модулем!';
$_['error_name'] 		= 'Название модуля должно содержать от 3 до 64 символов!';