<?php
class ControllerExtensionModuleDelovod extends Controller
{

	private $pass = '11103';
	private $services = [
		"ukrposhta.ukrposhta"	=> [ //Доставка Укрпочта Smartbox
			"id" 		=> "1100300000004217",
			"goodType"	=> "1004000000000014", //Товар
			"delivery" 	=> "1110400000001003",
			"unit"		=> "1103600000000001"	//Штуки
		],
		"new_mail.new_mail"	=> [ //Доставка Новая почта
			"id" 		=> "1100300000003062",
			"goodType"	=> "1004000000000015", //Услуга
			"delivery" 	=> "1110400000001005",
			"unit"		=> "1103600000000002"	//Услуга
		],
		"couriernp.couriernp"	=> [ //Доставка Новая почта курьером
			"id" 		=> "1100300000003068",
			"goodType"	=> "1004000000000015", //Услуга
			"delivery" 	=> "1110400000001005",
			"unit"		=> "1103600000000002"	//Услуга
		],
		"inter.inter"	=> [ //Доставка Международная
			"id" 		=> "1100300000006222",
			"goodType"	=> "1004000000000015", //Услуга
			"delivery" 	=> "1110400000001004",
			"unit"		=> "1103600000000002"	//Услуга
		],
		"cod"				=> [ //Комиссия в случае оплаты наложенным платежом
			"id" 		=> "1100300000004929",
			"goodType"	=> "1004000000000015", //Услуга
			"unit"		=> "1103600000000002"	//Услуга
		]
	];
	private $paymentForms = [
		"cod"				=> "1110300000000002",
		"privat"			=> "1110300000000001",
		"simple_western"	=> "1110300000000001",
	];

	// Товар	good	1004000000000014
	// Услуга	service	1004000000000015
	// Набор	goodSet	1004000000000220
	private $goodTypes = ['1004000000000014', '1004000000000220', '1004000000000015'];

	/**
	 * Export new order to delovod
	 *
	 * @param $order_id
	 */
	public function exportOrder($order_id)
	{
		$packet['action'] = "saveObject";
		if ($this->config->get('delovod_status') && $order_id) {
			$this->load->model('checkout/order');
			$order_info = $this->model_checkout_order->getOrder($order_id);
			if ($order_info) {
				$time = new DateTime('now', new DateTimeZone('UTC'));
				file_put_contents(DIR_LOGS . 'delovod_orders.log', $time->format('Y-m-d H:i:s') . ' Add new order: id = ' . $order_id . "\n", FILE_APPEND);
				if ($order_info['email']) {
					$person_id = $this->getObjectId('persons', $order_info['email'], 'email', "=");
					if ($person_id) {
						$packet["params"]['header']['person'] = $person_id;
					} else { // export new person
						$telephone = '';
						// if(isset($order_info['telephone']) && $order_info['telephone'] != '') {
						// 	$telephone = $order_info['telephone'];
						// } elseif (isset($order_info['payment_custom_field']['1']) && $order_info['payment_custom_field']['1'] != '') {
						// 	$telephone = $order_info['payment_custom_field']['1'];
						// }
						if (isset($order_info['payment_custom_field']['1']) && $order_info['payment_custom_field']['1'] != '') {
							$telephone = $order_info['payment_custom_field']['1'];
						} elseif (isset($order_info['telephone']) && $order_info['telephone'] != '') {
							$telephone = $order_info['telephone'];
						}
						
						$client_full_name = $order_info['firstname'] . ' ' . $order_info['lastname'];

						$packet["params"]['header'] = [
							"id"		=> "catalogs.persons",
							"parent"	=> "1100100000001022", //Покупатели
							"name" 		=> ["ru" => $client_full_name, "uk" => $client_full_name],
							"details"	=> json_encode(["phones" => [["pr" => $telephone, "kind" => "phone"]], "emails" => [["pr" => $order_info['email'], "kind" => "email"]]])
						];
						$person_id = $this->saveObject($packet, $time);
						if ($person_id) file_put_contents(DIR_LOGS . 'delovod_orders.log', "Add new user email: " . $order_info['email'] . ". Person ID = " . $person_id . "\n", FILE_APPEND);
					}
					if (!$person_id) return 0;

					$format = '{address_1}' . " " . '{address_2}' . ", " . '{city}' . ", "  . '{country}';
					$find = array(
						'{address_1}',
						'{address_2}',
						'{city}',
						'{country}'
					);
					$replace = array(
						'address_1' => $order_info['shipping_address_1'],
						'address_2' => $order_info['shipping_address_2'],
						'city'      => $order_info['shipping_city'],
						'country'   => $order_info['shipping_country']
					);

					$shipping_address = trim(str_replace($find, $replace, $format));

					$packet["params"] = [];
					$packet["params"]['header'] = [
						"id"		=> "documents.saleOrder",
						"number"	=> "i" . $order_id,
						"date"		=> $order_info['date_added'],
						"person"	=> $person_id,
						"firm"		=> "1100400000001001", //Интернет-магазин shellnail.com.ua
						"state"		=> "1111500000001005", //В обработке
						"storage"	=> "1100700000000001", //Основной склад
						"currency"	=> "1101200000001001", //грн.
						"amountCur"			=> $order_info['total'],
						"paymentForm"		=> (isset($this->paymentForms[$order_info['payment_code']]) ? $this->paymentForms[$order_info['payment_code']] : "1110300000000001"),
						"deliveryMethod_forDel"	=> (isset($this->services[$order_info['shipping_code']]) ? $this->services[$order_info['shipping_code']]['delivery'] : "1110400000000001"),
						"remark"			=> strip_tags($order_info['payment_method'] . ", " . $shipping_address)
					];
					// Get products
					$packet["params"]['tableParts'] = [];
					$packet["params"]['tableParts']['tpGoods'] = [];
					$tpGoods = [];
					$this->load->model('extension/module/delovod');
					$order_products = $this->model_extension_module_delovod->getOrderProducts($order_id);
					if ($order_products) {
						$percent = 0;
						if ($order_info["customer_id"]) { //накопительная скидка
							$this->load->model("account/order");
							$percent = $this->model_account_order->getCustomerSpecial($order_info["customer_id"]);
							if ($percent) {
								$active_promos_products = $this->config->get('active_promos_products_as_keys');
							}
						}
						$i = 0;
						foreach ($order_products as $product) {
							++$i;
							$discountPercent = 0;
							$discount = 0;
							// накопительная скидка только для неакционных товаров
							if ($percent && $product["price"] == $product["base_price"] && !(isset($active_promos_products["3"]) && isset($active_promos_products["3"][$product["product_id"]]))) {
								$discountPercent = $percent;
								$discount = $product["total"] * ($percent / 100);
							}

							if ($product["mpn"] == '') {
								$goodType = "1004000000000014"; // good товар
							} elseif ($product["mpn"] == '1') {
								$goodType = "1004000000000220"; // goodSet набор
							} else {
								$goodType = "1004000000000015"; // service услуга
							}

							$packet["params"]['tableParts']['tpGoods'][] = [
								"rowNum" 	=> $i,
								"good" 		=> $product["isbn"],
								//"goodType"	=> $goodType,
								"gType_forDel"	=> $goodType,
								"unit"		=>	"1103600000000001", //Штуки
								"qty" 		=> $product["quantity"],
								"price" 			=> $product["price"],				//Цена
								"priceAmount" 		=> $product["total"], 				//Сумма без скидки
								"discount"			=> $discount, 	//Скидка
								"discountPercent" 	=> $discountPercent, 				//Процент скидки
								"amountCur" 		=> $product["total"] - $discount, 						//Сумма
							];
							// for goodMoving
							if ($product["mpn"] == '') { // В документ перемещение только товар
								$tpGoods[] = [
									"rowNum"	=> $i,
									"good"		=> $product["isbn"],
									"unit"		=>	"1103600000000001", //Штуки
									"qty" 		=> $product["quantity"],
								];
							}
						}
					}
					//Добавление услуг
					$totals = $this->model_extension_module_delovod->getOrderTotal($order_id);
					// если сумма заказа < config new_mail_freetotal грн. и способ оплаты "Оплата банковским переводом", а доставка "В отделение Новой почты",  то в Деловод не добавляем доставку
					if (isset($this->services[$order_info['shipping_code']]) && !($totals["sub_total"] < $this->config->get('new_mail_freetotal') && $order_info['payment_code'] == "privat" && $order_info['shipping_code'] == "new_mail.new_mail")) { // Доставка
						$price_ser = (isset($totals["shipping"]) ? $totals["shipping"] : 0);
						$packet["params"]['tableParts']['tpGoods'][] = [
							"rowNum" 	=> ++$i,
							"good" 		=> $this->services[$order_info['shipping_code']]["id"],
							//"goodType"	=> $this->services[$order_info['shipping_code']]["goodType"],
							"gType_forDel"	=> $this->services[$order_info['shipping_code']]["goodType"],
							"unit"		=> $this->services[$order_info['shipping_code']]["unit"],
							"qty" 		=> 1,
							"price" 	=> $price_ser,
							"amountCur" => $price_ser,
						];
					}
					if (isset($totals["aftershipping"])) { // Комиссия в случае оплаты наложенным платежом
						$aftershipping = round($totals["aftershipping"]);
						$packet["params"]['tableParts']['tpGoods'][] = [
							"rowNum" 	=> ++$i,
							"good" 		=> $this->services["cod"]["id"],
							//"goodType"	=> $this->services["cod"]["goodType"],
							"gType_forDel"	=> $this->services["cod"]["goodType"],
							"unit"		=> $this->services["cod"]["unit"],
							"qty" 		=> 1,
							"price" 	=> $aftershipping,
							"amountCur" => $aftershipping,
						];
					}

					$delovod_order_id = $this->saveObject($packet, $time);
					if ($delovod_order_id) {
						$this->model_extension_module_delovod->updateOrderDelovodId($order_id, $delovod_order_id);
						// Выполнить перемещение
						if ($tpGoods) {
							$this->addNewgoodMoving($delovod_order_id, $order_id, $tpGoods, $order_info['date_added']);
						}
					}
				} else {
					file_put_contents(DIR_LOGS . 'delovod_orders.log', "Err user email. Order ID = " . $order_id . "\n", FILE_APPEND);
				}
			}
		}
	}

	/**
	 * Add new document goodMoving
	 *
	 * @param $order_id
	 */
	public function addNewgoodMoving($id, $order_id, $tpGoods, $date)
	{
		$packet['action'] = "saveObject";
		$packet["params"] = [];
		$packet["params"]["saveType"] = 1;
		$packet["params"]['header'] = [
			"id"		=> "documents.goodMoving",
			"number"	=> "m" . $order_id,
			"date"		=> $date,
			"baseDoc"	=> $id,
			"firm"		=> "1100400000001001", //Интернет-магазин shellnail.com.ua
			"storage"	=> "1100700000000001", //Основной склад
			"storageTo"	=> "1100700000001001", //Резервный склад
			"docMode"	=> "1004000000000409", //Перемещение на склад
		];
		$packet["params"]['tableParts']['tpGoods'] = $tpGoods;
		$time = new DateTime('now', new DateTimeZone('UTC'));
		$this->saveObject($packet, $time);
	}

	/**
	 * saveObject in delovod
	 *
	 * @param $packet, $time
	 * @return int
	 */
	private function saveObject($packet, $time)
	{

		$requestResult = $this->sendRequest($packet);
		$data = $this->handleResult($requestResult);

		if (!(isset($data->is_error) || isset($data->error) || $data  == new \stdClass()) && isset($data->id)) {
			file_put_contents(DIR_LOGS . 'delovod_orders.log', $time->format('Y-m-d H:i:s') . ' Save Object:' . $data->id . '. Packet' . json_encode($packet) . "\n", FILE_APPEND);
			return $data->id;
		} else {
			$error_msg = (isset($data->error_msg) ? $data->error_msg : (isset($data->error) ? $data->error : ''));
			file_put_contents(DIR_LOGS . 'delovod_orders.log', $time->format('Y-m-d H:i:s') . ' Err save Object: ' . $error_msg . "\n", FILE_APPEND);
			return 0;
		}
	}

	/**
	 * Get Object Id from delovod by object_type and object name
	 *
	 * @param $data
	 * @return int ObjectId
	 */
	private function getObjectId($object_type, $query = "", $field = "name", $operator = "%", $isGroup = false)
	{
		$json = [];
		$id = 0;
		if ($this->config->get('delovod_status')) {
			$packet['action'] = "request";
			$packet['params']['from'] = "catalogs." . $object_type;
			$packet['params']['fields'] = ["id" => "id", $field => "name", "isGroup" => "isGroup"];
			if ($query != "") {
				if ($isGroup) {
					$packet['params']['filters'] = [
						[
							"alias"		=> "name",
							"operator"	=> $operator,
							"isGroup"	=> true,
							"value"		=> $query
						]
					];
				} else {
					$packet['params']['filters'] = [
						[
							"alias"		=>	"name",
							"operator"	=>	$operator,
							"value"		=>	$query
						]
					];
				}
			}

			$requestResult = $this->sendRequest($packet);
			$data = $this->handleResult($requestResult);
			//print_r($data);
			if (!(isset($data->is_error) || isset($data->error) || $data  == new \stdClass()) && count($data) == 1) {
				$id = $data[0]->id;
			}
		}
		return $id;
	}

	/**
	 * Get Object from delovod by Id
	 *
	 * @param $id  Object Id
	 * @param $file_log  name file log
	 * @return stdClass Object
	 */
	private function getObject($id, $file_log = 'delovod_orders.log')
	{

		if ($this->config->get('delovod_status')) {

			$packet['action'] = "getObject";
			$packet['params']['id'] = $id;

			$requestResult = $this->sendRequest($packet);
			$data = $this->handleResult($requestResult);

			if (!(isset($data->is_error) || isset($data->error) || $data  == new \stdClass())) {
				return $data;
			} else {
				$time = new DateTime('now', new DateTimeZone('UTC'));
				$error_msg = (isset($data->error_msg) ? $data->error_msg : (isset($data->error) ? $data->error : ''));
				file_put_contents(DIR_LOGS . $file_log, $time->format('Y-m-d H:i:s') . ' Err get Object Id: ' . $id . ". Error: " . $error_msg . "\n", FILE_APPEND);
			}
		}
		return 0;
	}

	private function sendRequest($packet)
	{
		$return = new stdClass();

		$packet['key'] = $this->config->get('delovod_api_key');
		$packet['version'] = "0.15";

		//file_put_contents(DIR_LOGS . "delovod_Request.log", print_r($packet,true) . "\n", FILE_APPEND);
	
		if ($curl = curl_init()) {
			curl_setopt($curl, CURLOPT_URL, 'https://api.delovod.ua');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, "packet=" . json_encode($packet));
			$response = curl_exec($curl);
			$headerCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

			$return->data = json_decode($response);
			$return->http_code = $headerCode;
			curl_close($curl);
		}

		return $return;
	}

	/**
	 * Process results
	 *
	 * @param $data
	 * @return mixed
	 */
	private function handleResult($data)
	{
		if (empty($data->data)) {
			$data->data = new stdClass();
		}
		if ($data->http_code != 200) {
			$data->data->is_error = true;
			$data->data->error_msg = "Connection error";
			$data->data->http_code = $data->http_code;
		}
		if (isset($data->data->error) && $data->data->error == 'bad key') {
			$data->data->is_error = true;
			$data->data->error_msg = "Error: bad API key";
		}
		return $data->data;
	}

	/**
	 * Orders synchronization from delovod
	 * @method syncOrders
	 */
	public function syncOrders()
	{

		if ($this->config->get('delovod_status')) {
			$this->load->model('extension/module/delovod');
			$orders = $this->model_extension_module_delovod->getOrdersForSync();
			$time = new DateTime('now', new DateTimeZone('UTC'));
			file_put_contents(DIR_LOGS . 'delovod_orders_sync.log', $time->format('Y-m-d H:i:s') . ' Start synchronization ' . "\n", FILE_APPEND);
			if ($orders) {
				foreach ($orders as $order) {
					$this->syncOrder($order);
				}
			}
		}
	}

	/**
	 * webhook from delovod
	 *
	 */
	private function webhook()
	{
		if ($this->config->get('delovod_status')) {
			$time = new DateTime('now', new DateTimeZone('UTC'));
			file_put_contents(DIR_LOGS . 'delovod_orders_sync.log', $time->format('Y-m-d H:i:s') . ' Order I: ' . json_encode($this->request->get) . "\n", FILE_APPEND);

			$object_id = '1109100000005172';
			$data = $this->getObject($object_id, 'delovod_orders_sync.log');
			print_r($data);
			die();
			$this->load->model('extension/module/delovod');

			$order = $this->model_extension_module_delovod->getOrder($object_id);
			if ($order) {
				$this->syncOrder($order);
			}
		}
	}

	public function testOrder()
	{
		//$this->getObjectT();
		//$data = $this->getObject('1109100000014988', 'delovod_test.log');
		//print_r($data);
		// $this->load->model('extension/module/delovod');
		// $order = $this->model_extension_module_delovod->getOrder('1109100000015507');
		// if ($order) {
		// 	$this->syncOrder($order);
		// }
	}
	private function getObjectT()
	{
		$packet['action'] = "request";
		$packet['params']['from']="catalogs.states";
		$packet['params']['fields'] = ["id" => "id", "name" => "name", "code" => "code"];
		// $packet['params']['from'] = "catalogs.goods";
		// $packet['params']['fields'] = ["id" => "id", "name" => "name", "gType_forDel" => "gType_forDel"];
		// $packet['params']['filters'] = [
		// 	[
		// 		"alias" => "gType_forDel",
		// 		"operator" => "=",
		// 		"value" => "1004000000000015"
		// 	]
		// ];
		$requestResult = $this->sendRequest($packet);
		$data = $this->handleResult($requestResult);
		print_r($data);
	}
	/**
	 * Order synchronization from delovod
	 * @method syncOrder
	 * @param $order
	 */
	private function syncOrder($order)
	{
		if ($this->config->get('delovod_status')) {
			$this->load->model('extension/module/delovod');
			$time = new DateTime('now', new DateTimeZone('UTC'));
			file_put_contents(DIR_LOGS . 'delovod_orders_sync.log', $time->format('Y-m-d H:i:s') . ' Order I: ' . $order['order_id'] . "\n", FILE_APPEND);

			$data = $this->getObject($order['delovod_order_id'], 'delovod_orders_sync.log');
			if ($data) {
				//print_r($data);
				$totals = $this->model_extension_module_delovod->getOrderTotal($order['order_id']);
				$order_status_id = $this->model_extension_module_delovod->getOrderStatusIdByName(str_replace(" new", "", $data->header->state->pr));

				if ($order_status_id && ($order_status_id != $order['order_status_id'] || $totals['total'] != $data->header->amountCur)) {
					$order_products = $this->model_extension_module_delovod->getOrderProducts($order['order_id']);
					$change = 0;
					foreach ($data->tableParts->tpGoods as $key => $good) {
						$check = 0;
						// Пропускать доставку
						if (in_array($good->good, ["1100300000004217", "1100300000003062", "1100300000003068", "1100300000004929"])) {
							if($good->good == "1100300000004929") {
								$aftershipping = $good->price;
							} else {
								$shipping_cost = $good->price;
							}
							continue;
						}

						foreach ($order_products as $key => $product) {
							$check = 0;
							if ($product['isbn'] == $good->good) {
								$check = 1;
								// Проверка изм состава заказа
								//if ($product['quantity'] != $good->qty || $product['price'] != $good->price) {
								if ($product['quantity'] != $good->qty || $product['price'] != $good->price) {
									$change = 1;
									$this->model_extension_module_delovod->updateProductToOrder($product['order_product_id'], $good->price, $good->qty, $good->priceAmount);
									file_put_contents(DIR_LOGS . 'delovod_orders_sync.log', $time->format('Y-m-d H:i:s') . ' Product ' . $good->good . ' new qty: ' . $good->qty . "\n", FILE_APPEND);
								}
								unset($order_products[$key]);
								break;
							}
						}
						if (!$check) { // нет товара в заказе ИМ
							$product_inf = $this->model_extension_module_delovod->getProductIdByIsbn($good->good);
							if ($product_inf) {
								$change = 1;
								$this->model_extension_module_delovod->addProductToOrder($order['order_id'], $product_inf, $good->good__pr, $good->price, $good->qty, $good->priceAmount);
							} else {
								file_put_contents(DIR_LOGS . 'delovod_orders_sync.log', $time->format('Y-m-d H:i:s') . ' Product ' . $good->good__pr . ' not found: ' . $good->good . "\n", FILE_APPEND);
								//return 0;
							}
						}
					}

					// delete Product from Order
					if ($order_products) {
						$change = 1;
						$this->model_extension_module_delovod->deleteProductsFromOrder($order_products);
						file_put_contents(DIR_LOGS . 'delovod_orders_sync.log', $time->format('Y-m-d H:i:s') . ' Order ID:' . $order['order_id'] . '. Delete products.' . "\n", FILE_APPEND);
					}
								
					// change total
					if($change){ 

						// get new sub_total by products
						$sub_total = $this->model_extension_module_delovod->getOrderSubTotal($order['order_id']);


						if ($sub_total && isset($totals['sub_total']) &&  $sub_total != $totals['sub_total']) {
							$new_totals = [];

							//$total = $totals['total'] + $sub_total - $totals['sub_total'];

							//Накопительная скидка
							if (isset($totals['coupon']) && $order['customer_id'] && !$this->model_extension_module_delovod->isUseCoupon($order['order_id'])) {
								$accumulative_discount = $this->getAccumulativeDiscount($order['customer_id'], $order['order_id']);
								file_put_contents(DIR_LOGS . 'delovod_orders_sync.log', $time->format('Y-m-d H:i:s') . ' Order ID:' . $order['order_id'] . '. Accumulative_discount:' . $accumulative_discount . "\n", FILE_APPEND);
								if ($accumulative_discount != $totals['coupon']) {
									//$total = $total + $accumulative_discount - $totals['coupon'];
									$new_totals['coupon'] = $accumulative_discount;
								}
							}
							//Комиссия в случае оплаты наложенным платежом
							if (isset($totals['aftershipping'])){
								$new_totals['aftershipping'] = $this->config->get('new_mail_nalozhniy_fee') + (float)((float)($this->config->get('new_mail_nalozhniy_percent')/100)*(float)$sub_total);
								//$total = $total + $new_totals['aftershipping'] - $totals['aftershipping'];
							}

							// Shipping
							if($order['shipping_code'] == 'new_mail.new_mail'){
								if( $sub_total >= $this->config->get('new_mail_freetotal')){
									$new_totals['shipping'] = 0;
									//$total = $total - $totals['shipping'];
								}
							}
							
							$new_totals['sub_total'] = $sub_total;
							$new_totals['total'] = $data->header->amountCur;//$total;
							file_put_contents(DIR_LOGS . 'delovod_orders_sync.log', $time->format('Y-m-d H:i:s') . print_r($totals,true) . "\n", FILE_APPEND);
							file_put_contents(DIR_LOGS . 'delovod_orders_sync.log', $time->format('Y-m-d H:i:s') . print_r($new_totals,true) . "\n", FILE_APPEND);
							$this->model_extension_module_delovod->updateOrderTotals($order['order_id'], $new_totals);

							$this->model_extension_module_delovod->updateOrder($order['order_id'], $order_status_id, $new_totals['total']);
							file_put_contents(DIR_LOGS . 'delovod_orders_sync.log', $time->format('Y-m-d H:i:s') . ' Order ID:' . $order['order_id'] . '. Update totals.' . "\n", FILE_APPEND);
						}

					} else if($data->header->discountPercent && $totals['total'] != $data->header->amountCur){ // Add discount
						$this->model_extension_module_delovod->updateOrderTotals($order['order_id'], ['total' => $data->header->amountCur]);
						
						$this->model_extension_module_delovod->updateOrder($order['order_id'], $order_status_id, $data->header->amountCur);
						file_put_contents(DIR_LOGS . 'delovod_orders_sync.log', $time->format('Y-m-d H:i:s') . ' Order ID:' . $order['order_id'] . '. Update total. Add Discount.' . "\n", FILE_APPEND);					
					}


					// add to OrderHistory
					if ($order['order_status_id'] != $order_status_id) {
						$this->load->model('checkout/order');
						$this->model_checkout_order->addOrderHistory($order['order_id'], $order_status_id);
						file_put_contents(DIR_LOGS . 'delovod_orders_sync.log', $time->format('Y-m-d H:i:s') . ' Order ID:' . $order['order_id'] . '. New status: ' . $data->header->state->pr . "\n", FILE_APPEND);
					}
				}
			}
		}
	}
	// public function testOrder()
	// {
	// 	$order = [
	// 		'order_id' 			=> 17103,
	// 		'delovod_order_id' 	=> '1109100000015199',
	// 		'customer_id' 		=> 782,
	// 		'total'				=> '1187.0720',
	// 		'order_status_id'   => 7
	// 	];
	// 	$this->syncOrder($order);
	// }
	/**
	 * накопительная скидка
	 */
	public function getAccumulativeDiscount($customer_id, $order_id)
	{
		$accumulative_discount = 0;
		$this->load->model("account/order");
		$percent = $this->model_account_order->getCustomerSpecial($customer_id);
		if ($percent) {
			$active_promos_products = $this->config->get('active_promos_products_as_keys');
			$order_products = $this->model_extension_module_delovod->getOrderProducts($order_id);
			if ($active_promos_products && $order_products) {
				foreach ($order_products as $product) {
					// накопительная скидка только для неакционных товаров
					if ($product["price"] == $product["base_price"] && !(isset($active_promos_products["3"]) && isset($active_promos_products["3"][$product["product_id"]]))) {
						$accumulative_discount += $product["price"]*$product["quantity"];
					}
				}
			}
			$accumulative_discount = $accumulative_discount * ($percent / 100);
		}

		return -$accumulative_discount;
	}

	/**
	 * Обновление товарных остатков
	 */
	public function updateBalance()
	{
		if ($this->config->get('delovod_status')) {
			$time = new DateTime('now', new DateTimeZone('UTC'));
			file_put_contents(DIR_LOGS . 'delovod_update_balance.log', $time->format('Y-m-d H:i:s') . ' ---Start---' . "\n", FILE_APPEND);
			$j = 0;
			$time = new DateTime('now', new DateTimeZone('Europe/Kiev'));
			$packet['action'] = "request";
			$packet["params"]["from"] = [
				"type"		=> "balance",
				"register" 	=> "goods",
				"filters" 	=> [
					[
						"alias" => "storage",
						"operator" => "=",
						"value" => "1100700000000001" //Основной склад
					]
				],
				"date" 	=> $time->format('Y-m-d H:i:s'),
			];
			$packet["params"]["fields"] = [
				"good" 		=> "good",
				"storage" 	=> "storage",
				"good.id"	=> "id",
				"qty" 		=> "qty"
			];

			$requestResult = $this->sendRequest($packet);
			$data = $this->handleResult($requestResult);

			if (!(isset($data->is_error) || isset($data->error) || $data  == new \stdClass())) {
				$this->load->model('extension/module/delovod');
				$this->model_extension_module_delovod->updateBalance($data);
				$time = new DateTime('now', new DateTimeZone('UTC'));
				file_put_contents(DIR_LOGS . 'delovod_update_balance.log', $time->format('Y-m-d H:i:s') . ' Всего:' . count($data) . "\n", FILE_APPEND);
			} else {
				$error_msg = (isset($data->error_msg) ? $data->error_msg : 'Ошибка синхронизации остатков.');
				file_put_contents(DIR_LOGS . 'delovod_update_balance.log', $time->format('Y-m-d H:i:s') . ' ' . $error_msg . "\n", FILE_APPEND);
			}
		}
	}
}
