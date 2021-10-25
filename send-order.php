<?php

function replace_shablon($string){
	global $product, $name, $phone, $email, $shop_name;

	$patterns[0] = "/\{shop_name\}/";
	$patterns[1] = "/\{product\}/";
	$patterns[2] = "/\{name\}/";
	$patterns[3] = "/\{clickphone\}/";
	$patterns[4] = "/\{email\}/";

	$replacements[0] = $shop_name;
	$replacements[1] = $product;
	$replacements[2] = $name;
	$replacements[3] = $phone;
	$replacements[4] = $email;
	return preg_replace($patterns, $replacements, $string);
}

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

	include "config.php"; // подключаем конфиг для TurboSMS

	/* Осуществляем проверку вводимых данных и их защиту от враждебных скриптов */
	$product = trim(strip_tags($_POST["product"]));
	$product_body = "Вам пришёл заказ на ";
	$product_body .= $_POST["product"];
	$post_name = htmlspecialchars($_POST["name"]);
	$name = strip_tags(mb_convert_encoding($post_name, 'UTF-8', mb_detect_encoding($post_name)));
	$email = htmlspecialchars($_POST["email"]);
	$phone = htmlspecialchars($_POST["clickphone"]);
	$message = htmlspecialchars($_POST["message"]);

	/* Устанавливаем e-mail адресата */
	$myemail = $_POST["admin_email"];

        
        
        if(isset($_POST["message_type"]) && $_POST["message_type"]){
	/* $_POST["product_id"] можно записать в базу вместе с телефоном для автоматизации */
            $message_to_myemail = "<b>Уведомить о наличии!</b> <br /><br />
            Имя отправителя: $name <br />
            Телефон: $phone <br />";
            if ($email=='') {
		$message_to_myemail .= "<br />";
            }
            else {
		$message_to_myemail .= "E-mail: $email <br />";
            }
            if($_POST["message_type"]=="sms"){
                $message_type = "СМС";
                $formatted_phone_pre =  str_replace('+38', '', $phone);
                $formatted_phone = preg_replace('/[^0-9.]+/', '', $formatted_phone_pre);
                $save_sms_array =[
                    'name'=> $name,
                    'product_id' => $_POST["product_id"],
                    'phone' => preg_replace('/[^0-9.]+/', '', $formatted_phone)
                ];
             
            }else{
                $message_type = "звонка";
            }
            $message_to_myemail .= "<br />".$name." ждёт <b>".$message_type."</b> при появлении на складе";
            $message_to_myemail .= " ".$_POST["product"]."<br /><br />Удачных продаж!!!";
            $decrease_quantity=false;
        }else{
            
            $decrease_quantity=true;
            
            /* Создаем новую переменную, присвоив ей значение */
            $message_to_myemail = "<b>Купить в один клик!</b> <br /><br />
            $product_body<br /><br />
            Имя отправителя: $name <br />
            Телефон: $phone <br />";
            if ($email=='') {
		$message_to_myemail .= "<br />";
            }
            else {
		$message_to_myemail .= "E-mail: $email <br />";
            }
            if ($message=='') {
		$message_to_myemail .= "<br />Удачных продаж!!!";
            }
            else {
		$message_to_myemail .= "Сообщение: $message <br /><br />Удачных продаж!!!";
            }
        }
	/******************* СОЕДИНЕНИЕ С БАЗОЙ *******************/

	$db_host = constant("DB_HOSTNAME");
	$db_database = constant("DB_DATABASE");
	$db_username = constant("DB_USERNAME");
	$db_password = constant("DB_PASSWORD");
	$db_prefix = constant("DB_PREFIX");
	$db_table = $db_prefix . 'setting';


	
	# Соединение
	$db_link = mysqli_connect($db_host, $db_username, $db_password, $db_database);
	if($decrease_quantity){
		$update_quantity = mysqli_query($db_link,"UPDATE oc_product SET quantity=quantity-1 WHERE `product_id` = '".(int)$_POST["product_id"]."' AND `subtract` = 1");    
	}
	
	if(isset($save_sms_array)){
		
		mysqli_query($db_link,"SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
		mysqli_query($db_link,"SET CHARACTER SET 'utf8'");
		$sql_text = "INSERT INTO sms SET phone= '".$save_sms_array['phone']."', product_id= '".$save_sms_array['product_id']."', name= '". $save_sms_array['name'] ."'";
		
		$result = mysqli_query($db_link,$sql_text);  
//            var_dump($sql_text, $result);
//            die;
	}
        
    $result = mysqli_query($db_link,"SELECT * FROM `$db_table` WHERE `code` = 'buyoneclick_'");

    while ($row = mysqli_fetch_assoc($result)) {
		switch ($row['key']) {
			case 'buyoneclick_turbosms_status' :
				$turbosms_status = $row['value'];
				break;
			case 'buyoneclick_turbosms_login' :
				$turbosms_login = $row['value'];
				break;
			case 'buyoneclick_turbosms_password' :
				$turbosms_password = $row['value'];
				break;
			case 'buyoneclick_turbosms_number' :
				$turbosms_number = $row['value'];
				break;
			case 'buyoneclick_turbosms_name' :
				$turbosms_name = $row['value'];
				break;
		}
    }
	
	# Соединение
	$db_link = mysqli_connect($db_host, $db_username, $db_password, $db_database);
	$set_charset = mysqli_set_charset($db_link, "utf8");
    $result = mysqli_query($db_link, "SELECT * FROM `$db_table` WHERE `code` = 'buyoneclick_' OR `code` = 'config'");

    while ($row = mysqli_fetch_assoc($result)) {
		switch ($row['key']) {
			case 'config_name' :
				$shop_name = $row['value'];
				break;
			case 'buyoneclick_turbosms_status' :
				$turbosms_status = $row['value'];
				break;
			case 'buyoneclick_turbosms_client_status' :
				$turbosms_client_status = $row['value'];
				break;
			case 'buyoneclick_turbosms_login' :
				$turbosms_login = $row['value'];
				break;
			case 'buyoneclick_turbosms_password' :
				$turbosms_password = $row['value'];
				break;
			case 'buyoneclick_turbosms_number' :
				$turbosms_number = $row['value'];
				break;
			case 'buyoneclick_turbosms_name' :
				$turbosms_name = $row['value'];
				break;
			case 'buyoneclick_turbosms_admin_sms' :
				$turbosms_admin_sms = $row['value'];
				break;
			case 'buyoneclick_turbosms_client_sms' :
				$turbosms_client_sms = $row['value'];
				break;
			case 'buyoneclick_smsru_status' :
				$smsru_status = $row['value'];
				break;
			case 'buyoneclick_smsru_client_status' :
				$smsru_client_status = $row['value'];
				break;
			case 'buyoneclick_smsru_api' :
				$smsru_api = $row['value'];
				break;
			case 'buyoneclick_smsru_login' :
				$smsru_login = $row['value'];
				break;
			case 'buyoneclick_smsru_password' :
				$smsru_password = $row['value'];
				break;
			case 'buyoneclick_smsru_number' :
				$smsru_number = $row['value'];
				break;
			case 'buyoneclick_smsru_name' :
				$smsru_name = $row['value'];
				break;
			case 'buyoneclick_smsru_admin_sms' :
				$smsru_admin_sms = $row['value'];
				break;
			case 'buyoneclick_smsru_client_sms' :
				$smsru_client_sms = $row['value'];
				break;
		}
    }

	$shop_name = mb_convert_encoding($shop_name, 'UTF-8', mb_detect_encoding($shop_name));

	/*********** SMS клиенту **************/
	$client_sms = "Спасибо за Ваш заказ на $product в интернет-магазине $shop_name! Мы свяжемся с Вами для подтверждения заказа!";
	/*********** SMS админу **************/
	$admin_sms = "Заказ: $product. Покупатель: $name $phone $email";

	if ($turbosms_status == '1') {

		$message_to_myemail .= "
			<br /><br />Сатус TurboSMS: $turbosms_status
			<br />Turbosms Number: $turbosms_number
			<br />Turbosms Name: $turbosms_name
			<br />Turbosms login: $turbosms_login
			<br />Turbosms password: $turbosms_password <br /><br />
		";

		/*********** TurboSMS клиенту **************/
		if ($turbosms_client_sms != '') {
			$client_sms = replace_shablon($turbosms_client_sms);
		}
		/*********** TurboSMS админу **************/
		if ($turbosms_admin_sms != '') {
			$admin_sms = replace_shablon($turbosms_admin_sms);
		}

		try {

			// Подключаемся к серверу
			$client = new SoapClient('http://turbosms.in.ua/api/wsdl.html');

			// Данные авторизации
			$auth = array(
				'login' => $turbosms_login,
				'password' => $turbosms_password
			);

			// Авторизируемся на сервере
			$auth_result = $client->Auth($auth);

			// Результат авторизации
			$message_to_myemail .= '<br /><hr /><strong>TurboSMS.ua</strong><br />Авторизация на TurboSMS.ua: ' . $auth_result->AuthResult . '<br />';

			if ($auth_result) {

				// Получаем количество доступных кредитов
				$credit_result = $client->GetCreditBalance();

				// Отправляем сообщение на один номер (администратору магазина).
				// Подпись отправителя может содержать английские буквы и цифры. Максимальная длина - 11 символов.
				// Номер указывается в полном формате, включая плюс и код страны
				if (intval($credit_result) > 0) {
					$sms_sender = $turbosms_name;
					$sms_sender = mb_convert_encoding($sms_sender, 'UTF-8', mb_detect_encoding($sms_sender));


					$sms = array(
						'sender' => $sms_sender,
						'destination' => $turbosms_number,
						'text' => $admin_sms
					);
					$result = $client->SendSMS($sms);

					$new_result_error = $result->SendSMSResult->ResultArray;
					$new_result = $result->SendSMSResult->ResultArray[0];

					if ( ! is_array($new_result_error) ) {
						$message_to_myemail .= 'Результат отправки SMS администратору: ' . $new_result_error . '<br>';
					} else {
						$message_to_myemail .= 'Результат отправки SMS администратору: ' . $new_result . '<br>';
					}
				}

				//отправка SMS покупателю

				if ($turbosms_client_status == '1') {

					// Получаем количество доступных кредитов
					$credit_result = $client->GetCreditBalance();
					$client_number = '+';
					$client_number .= preg_replace('/[^0-9]+/', '', $phone);

					// Отправляем сообщение на один номер (покупателю).
					// Номер указывается в полном формате, включая плюс и код страны
					if (intval($credit_result) > 0) {
						$sms_sender = $turbosms_name;
						$sms_sender = mb_convert_encoding($sms_sender, 'UTF-8', mb_detect_encoding($sms_sender));


						$sms = array(
							'sender' => $sms_sender,
							'destination' => $client_number,
							'text' => $client_sms
						);
						$result = $client->SendSMS($sms);

						$new_result_error = $result->SendSMSResult->ResultArray;
						$new_result = $result->SendSMSResult->ResultArray[0];

						if ( ! is_array($new_result_error) ) {
							$message_to_myemail .= 'Результат отправки SMS клиенту: ' . $new_result_error;
						} else {
							$message_to_myemail .= 'Результат отправки SMS клиенту: ' . $new_result;
						}
					}
				}

				// Получаем количество доступных кредитов
				$credit_result = $client->GetCreditBalance();
				$message_to_myemail .= '<br />Остаток на SMS счете: ' . $credit_result->GetCreditBalanceResult .'<br />';
				
				$message_to_myemail .= '<br /><br />СМС-шаблон администратору (TurboSMS): ' . "$admin_sms";				
				$message_to_myemail .= '<br /><br />СМС-шаблон клиенту (TurboSMS): ' . "$client_sms";

			}

		} catch(Exception $e) {
			$message_to_myemail .= 'Ошибка: ' . $e->getMessage() . '<br />';
		}

	}

	if ($smsru_status == '1') {

		/*********** SMS.ru клиенту **************/
		if ($smsru_client_sms != '') {
			$client_sms = replace_shablon($smsru_client_sms);
		}
		/*********** SMS.ru админу **************/
		if ($smsru_admin_sms != '') {
			$admin_sms = replace_shablon($smsru_admin_sms);
		}

		$smsru_number = preg_replace('/[^0-9]+/', '', $smsru_number);
		$admin_sms = mb_convert_encoding($admin_sms, 'UTF-8', mb_detect_encoding($admin_sms));
		
		if ($smsru_name != '') {
			$sms_sender = $smsru_name;
			$sms_sender = mb_convert_encoding($sms_sender, 'UTF-8', mb_detect_encoding($sms_sender));
			$sending_string1 = 'https://sms.ru/sms/send?api_id=' . $smsru_api . '&to=' . $smsru_number . '&text=' .  urlencode($admin_sms) . '&from=' . $sms_sender . '&partner_id=188307';
		} else {
			$sending_string1 = 'https://sms.ru/sms/send?api_id=' . $smsru_api . '&to=' . $smsru_number . '&text=' .  urlencode($admin_sms) . '&partner_id=188307';
		}
		
		$body=file_get_contents($sending_string1);
			list($code,$text) = explode("\n", $body);
			if ($code=="100") {
				$message_to_myemail .= '<br /><hr /><strong>SMS.ru</strong><br />Результат отправки SMS администратору: ' . $text;
			} else {
				$message_to_myemail .= '<br /><hr /><strong>SMS.ru</strong><br /><span style="color:#ff0000;">Ошибка отправки SMS администратору:</span> ' . $code;
			}

		//отправка SMS покупателю
		if ($smsru_client_status == '1') {

			$client_number = preg_replace('/[^0-9]+/', '', $phone);
			$client_sms = mb_convert_encoding($client_sms, 'UTF-8', mb_detect_encoding($client_sms));
			if (isset($smsru_name)) {
				$sms_sender = $smsru_name;
				$sms_sender = mb_convert_encoding($sms_sender, 'UTF-8', mb_detect_encoding($sms_sender));
				$sending_string2 = 'https://sms.ru/sms/send?api_id=' . $smsru_api . '&to=' . $client_number . '&text=' . urlencode($client_sms) . '&from=' . $sms_sender . '&partner_id=188307';
			} else {
				$sending_string2 = 'https://sms.ru/sms/send?api_id=' . $smsru_api . '&to=' . $client_number . '&text=' . urlencode($client_sms) . '&partner_id=188307';
			}
			$body=file_get_contents($sending_string2);
			list($code,$text) = explode("\n", $body);
			if ($code=="100") {
				$message_to_myemail .= '<br />Результат отправки SMS клиенту: ' . $text;
			} else {
				$message_to_myemail .= '<br /><span style="color:#ff0000;">Ошибка отправки SMS клиенту:</span> ' . $code;
			}
		}

		// Получаем количество доступных кредитов
		$sending_string = 'https://sms.ru/my/balance?api_id=' . $smsru_api;
		$body=file_get_contents("$sending_string");

		list($code,$balance) = explode("\n", $body);
		if ($code=="100") {
			$message_to_myemail .= '<br />Остаток на SMS счете: ' . $balance;
		} else {
			$message_to_myemail .= '<br />Ошибка запроса баланса: ' . $code;
		}
		
		$message_to_myemail .= '<br /><br />СМС-шаблон администратору (SMS.ru): ' . "$admin_sms";
		$message_to_myemail .= '<br /><br />СМС-шаблон клиенту (SMS.ru): ' . "$client_sms";

	}
	/* Создаем from email */
	$from_email = $shop_name . ' <zakaz@' . $_SERVER['SERVER_NAME'] . '>';
	/* Создаем заголовок */
	$headers = 'Content-type: text/html; charset=UTF-8' . " \r\n" . 'From:' . $from_email . " \r\n"; //Заголовок для отправки писем без файла
	/**************** отправка почты *********************/
        if($decrease_quantity){
             $subject = "В $shop_name поступил заказ 'Купить в один клик' на $product";
        }else{
             $subject = "В $shop_name поступил запрос 'Уведомить о наличии' $product";
        }
       
	
        /* Отправляем сообщение, используя mail() функцию */
	mail($myemail, '=?utf-8?B?'.base64_encode($subject).'?=', $message_to_myemail, $headers);

}else{
	die('spam!');
}

?>
