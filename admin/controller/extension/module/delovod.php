<?php
class ControllerExtensionModuleDelovod extends Controller
{
	private $error = array();
	//private $ignor_category = [113,148,149,157,186,242];
	public function index()
	{

		$this->load->language('extension/module/delovod');

		$this->load->model('setting/setting');
		$this->load->model('design/layout');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('delovod', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_action'] = $this->language->get('column_action');

		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_sync'] = $this->language->get('text_sync');
		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['tab_art'] = $this->language->get('tab_art');
		$data['tab_balance'] = $this->language->get('tab_balance');
		$data['tab_config'] = $this->language->get('tab_config');
		$data['tab_goods'] = $this->language->get('tab_goods');

		$data['entry_api_key'] = $this->language->get('entry_api_key');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_category_list'] = $this->language->get('entry_category_list');
		$data['entry_category'] = $this->language->get('entry_category');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->session->data['warning'])) {
			$data['error_warning'] = $this->session->data['warning'];

			unset($this->session->data['warning']);
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->error['api_key'])) {
			$data['error_api_key'] = $this->error['api_key'];
		} else {
			$data['error_api_key'] = '';
		}

		if (isset($this->error['category_list'])) {
			$data['error_category_list'] = $this->error['category_list'];
		} else {
			$data['error_category_list'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/delovod', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/delovod', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['delovod_api_key'])) {
			$data['delovod_api_key'] = $this->request->post['delovod_api_key'];
		} elseif ($this->config->get('delovod_api_key')) {
			$data['delovod_api_key'] = $this->config->get('delovod_api_key');
		} else {
			$data['delovod_api_key'] = '';
		}

		if (isset($this->request->post['delovod_category_list'])) {
			$data['delovod_category_list'] = $this->request->post['delovod_category_list'];
		} elseif ($this->config->get('delovod_category_list')) {
			$data['delovod_category_list'] = $this->config->get('delovod_category_list');
		} else {
			$data['delovod_category_list'] = '';
		}

		if (isset($this->request->post['delovod_status'])) {
			$data['delovod_status'] = $this->request->post['delovod_status'];
		} else {
			$data['delovod_status'] = $this->config->get('delovod_status');
		}
		if (isset($this->request->get['category_id'])) {
			$data['category_id'] = $this->request->get['category_id'];
		} else {
			$data['category_id'] = 0;
		}

		$data['products'] = [];
		if ($data['category_id']) {
			$this->load->model('extension/delovod');
			$results = $this->model_extension_delovod->getProductsByCategoryId($data['category_id']);
			foreach ($results as $result) {
				$data['products'][] = array(
					'product_id' => $result['product_id'],
					'name'       => $result['name'],
					'edit'       => $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'], true)
				);
			}
		}

		// Categories
		$this->load->model('catalog/category');

		$filter_data = array(
			'sort'        => 'name',
			'order'       => 'ASC'
		);

		$data['categories'] = $this->model_catalog_category->getCategories($filter_data);

		$data['url_sync'] = $this->url->link('extension/module/delovod/sync', 'token=' . $this->session->data['token'], true);
		$data['url_balance'] = $this->url->link('extension/module/delovod/updateBalance', 'token=' . $this->session->data['token'], true);
		$data['url_sync_prod'] = $this->url->link('extension/module/delovod/exportProducts', 'token=' . $this->session->data['token'], true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['current_page'] = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;
		$data['total_pages'] = isset($this->session->data['delovod_total_pages']) ? (int)$this->session->data['delovod_total_pages'] : 1;
		$data['progress_percent'] = $data['total_pages'] > 0
			? round($data['current_page'] / $data['total_pages'] * 100)
			: 0;

		$this->response->setOutput($this->load->view('extension/module/delovod', $data));
	}

	protected function validate()
	{
		if (!$this->user->hasPermission('modify', 'extension/module/delovod')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['delovod_api_key']) < 30) || (utf8_strlen($this->request->post['delovod_api_key']) > 32)) {
			$this->error['api_key'] = $this->language->get('error_api_key');
		}

		if (isset($this->request->post['delovod_category_list']) && utf8_strlen($this->request->post['delovod_category_list']) > 2) {

			if (!explode(',', $this->request->post['delovod_category_list'])) $this->error['category_list'] = $this->language->get('error_category_list');
		}

		return !$this->error;
	}

	public function sync()
	{
		// Обработка массового обновления всех цен без категории (по get или post)
		if (
			($this->request->get['update_all_prices'] ?? null) == 1 ||
			($this->request->post['update_all_prices'] ?? null) == 1
		) {
			$page = (int)($this->request->get['page'] ?? $this->request->post['page'] ?? 1);
			$this->updateAllPrices($page);
			return;
		}

		$json = [];
		if ($this->config->get('delovod_status') && $this->user->hasPermission('modify', 'extension/module/delovod')) {

			// Обработка массового обновления всех цен без категории
			if (isset($this->request->post['update_all_prices']) && $this->request->post['update_all_prices'] == 1) {
				$page = isset($this->request->post['page']) ? (int)$this->request->post['page'] : 1;
				$this->updateAllPrices($page);
				return;
			}

			if (isset($this->request->post['category_id']) && $this->request->post['category_id']) {
				$time = new DateTime('now', new DateTimeZone('UTC'));
				file_put_contents(DIR_LOGS . 'delovod_sync.log', "\nBEGIN -------" . $time->format('Y-m-d H:i:s') . "--------\n", FILE_APPEND);
				$category_id = $this->request->post['category_id'];
				$this->load->model('extension/delovod');

				if(isset($this->request->post['only_name'])){
					$page = isset($this->request->post['page']) ? $this->request->post['page'] : 0;
					$this->updateNameUa($category_id, $page);
					$this->response->redirect($this->url->link('extension/module/delovod', 'token=' . $this->session->data['token'] . (isset($this->request->post['category_id']) ? '&category_id=' . $this->request->post['category_id'] : ''), true));
				}
			
				if(isset($this->request->post['only_price'])){
					$page = isset($this->request->post['page']) ? $this->request->post['page'] : 0;
					$this->updatePrice($category_id, $page);
					$this->response->redirect($this->url->link('extension/module/delovod', 'token=' . $this->session->data['token'] . (isset($this->request->post['category_id']) ? '&category_id=' . $this->request->post['category_id'] : ''), true));
				}

				if (isset($this->request->post['only_barcode'])) {
					$page = isset($this->request->post['page']) ? $this->request->post['page'] : 0;
					$this->updateBarcode($category_id, $page);
					$this->response->redirect($this->url->link('extension/module/delovod', 'token=' . $this->session->data['token'] . (isset($this->request->post['category_id']) ? '&category_id=' . $this->request->post['category_id'] : ''), true));
				}

				$results = $this->model_extension_delovod->getProductsByCategoryId($category_id);


				$i = 0;
				$j = 0;
				$packet['action'] = "request";
				$packet['params']['from'] = "catalogs.goods";
				$packet['params']['fields'] = ["id" => "good", "name" => "name"];
				foreach ($results as $result) {
					$i++;
					$packet['params']['filters'] = [
						[
							"alias" => "name",
							"operator" => "=",
							"value" => $result['name']
						]
					];
					$requestResult = $this->sendRequest($packet);
					$data = $this->handleResult($requestResult);
					if (isset($data->is_error)) {
						$json["error"] = $data->error_msg;
						break;
					}

					if (isset($data->error) || $data  == new \stdClass()) {
						file_put_contents(DIR_LOGS . 'delovod_sync.log', 'id = ' . $result['product_id'] . "\n", FILE_APPEND);
					} elseif (isset($data[0]->good)) {
						$id = $data[0]->good;
						$this->model_extension_delovod->editIsbn($result['product_id'], $id);
						file_put_contents(DIR_LOGS . 'delovod_sync.log', 'id = ' . $result['product_id'] . ". isbn = " . $id . "\n", FILE_APPEND);
						++$j;
					}

					if ($i > 50) break;
				}

				$this->session->data['success'] = "Всего: " . $i . " Обновлено: " . $j;
			}
		}
		if (isset($json["error"])) $this->session->data['warning'] = $json["error"];

		// $this->response->addHeader('Content-Type: application/json');
		// $this->response->setOutput(json_encode($json));
		$this->response->redirect($this->url->link('extension/module/delovod', 'token=' . $this->session->data['token'] . (isset($this->request->post['category_id']) ? '&category_id=' . $this->request->post['category_id'] : ''), true));
	}

	/**
	 * Export products to delovod
	 *
	 * @param $product_id
	 */
	public function exportProducts()
	{
		$i = 0;
		$j = 0;
		$y = 0;
		if ($this->config->get('delovod_status') && $this->user->hasPermission('modify', 'extension/module/delovod')) {
			if (isset($this->request->post['category_id']) && $this->request->post['category_id']) {

				$time = new DateTime('now', new DateTimeZone('UTC'));
				file_put_contents(DIR_LOGS . 'delovod_goods.log', "\nBEGIN -------" . $time->format('Y-m-d H:i:s') . "--------\n", FILE_APPEND);

				if (isset($this->request->post['selected'])) {
					$products = $this->request->post['selected'];
					foreach ($products as $product_id) {
						$i++;
						$res = $this->exportProduct($product_id);
						if ($res == 1) $j++; // update
						elseif ($res == 2) $y++; // Add new
					}
				} else {
					$category_id = $this->request->post['category_id'];
					$this->load->model('extension/delovod');
					$results = $this->model_extension_delovod->getProductsByCategoryId($category_id, false);

					foreach ($results as $result) {
						$i++;
						$res = $this->exportProduct($result["product_id"]);
						if ($res == 1) $j++; // update
						elseif ($res == 2) $y++; // Add new
					}
				}

				$this->session->data['success'] = "Всего: " . $i . ". Обновлено: " . $j . ". Добавлено: " . $y;
			}
		}
		$this->response->redirect($this->url->link('extension/module/delovod', 'token=' . $this->session->data['token'] . (isset($this->request->post['category_id']) ? '&category_id=' . $this->request->post['category_id'] : ''), true));
	}

	/**
	 * Export product to delovod
	 *
	 * @param $product_id
	 */
	public function exportProduct($product_id)
	{
		if ($this->config->get('delovod_status') && $product_id) {
			$this->load->model('extension/delovod');
			$product_info = $this->model_extension_delovod->getProduct($product_id);
			if ($product_info) {
				$time = new DateTime('now', new DateTimeZone('UTC'));
				if ($product_info['isbn'] != '') { // Обновить только цену
					//set price
					return $this->setPrice($product_info['isbn'], $product_info['price'], $time);
				}
				// if($this->config->get('delovod_category_list') != ''){
				// 	$ignor_category = explode ( ',', $this->config->get('delovod_category_list'));
				// 	if($product_info && $product_info['category_id'] && in_array($product_info['category_id'], $ignor_category)){
				// 		return 0;
				// 	}
				// }
				$packet['action'] = "saveObject";
				$packet["params"]['header'] = [
					"id" 		=> "catalogs.goods",
					"name" 	=> [
						"ru" => $product_info['name'],
						"uk" => $product_info['name_ua'],
					],
					"productNum"	=> $product_id, // Артикул
					"mainUnit"		=> "1103600000001002", // шт
					//"goodType" 		=> "1004000000000014", // товар
					"gType_forDel"	=> "1004000000000014", // товар
					"isGroup" 		=> false,
					"accPolicy" 	=> "1201200000001002"
				];
				if ($product_info['category']) {
					$category_id = $this->getObjectId('goods', $product_info['category'], "=", true);
					if ($category_id) {
						$packet["params"]['header']['parent'] = $category_id;
					}
				}
				if ($product_info['weight'] != 0) {
					$packet["params"]['header']['weight'] = $product_info['weight'];
				}
				if ($product_info['manufacturer']) {
					$manufacturer_id = $this->getObjectId('tradeMarks', $product_info['manufacturer'], "=");
					if ($manufacturer_id) {
						$packet["params"]['header']['tradeMark'] = $manufacturer_id;
					}
				}

				//  if (!empty($product_info['ean'])) {
				// 	$packet["params"]['header']['barCode'] = $product_info['ean'];
				// }

				$requestResult = $this->sendRequest($packet);
				$data = $this->handleResult($requestResult);

				if (!(isset($data->is_error) || isset($data->error) || $data  == new \stdClass()) && isset($data->id)) {
					$this->model_extension_delovod->editIsbn($product_id, $data->id);
					file_put_contents(DIR_LOGS . 'delovod_goods.log', $time->format('Y-m-d H:i:s') . ' Add new product: id = ' . $product_id . ", isbn = " . $data->id . "\n", FILE_APPEND);
					//set price
					$this->setPrice($data->id, $product_info['price'], $time);
					 if (!empty($product_info['ean'])) {
						$this->setBarcode($data->id, $product_info['ean']);
					}
					return 2;
				} else {

					$error_msg = (isset($data->error_msg) ? $data->error_msg : (isset($data->error) ? $data->error : ''));
					file_put_contents(DIR_LOGS . 'delovod_goods.log', $time->format('Y-m-d H:i:s') . ' Err add new product: id = ' . $product_id . ". " . $error_msg . "\n", FILE_APPEND);
					return 0;
				}
			}
		}
	}

	/**
	 * Set price product by Id
	 *
	 * @param $id, $price, $time
	 * @return int
	 */
	private function setPrice($id, $price, $time)
	{
		if ($id != '' && (float)$price > 0) {

			// Получаем текущую цену
			$packetCheck = [
				'action' => 'request',
				'params' => [
					'from' => 'informationRegisters.goodsPrices',
					'fields' => ['price' => 'price'],
					'filters' => [
						['alias' => 'good', 'operator' => '=', 'value' => $id],
						['alias' => 'priceType', 'operator' => '=', 'value' => '1101300000001001'] // Факт
					],
					'sortOrder' => [['alias' => 'date', 'order' => 'DESC']],
					'limit' => 1
				]
			];

			$check = $this->sendRequest($packetCheck);
			$checkData = $this->handleResult($check);

			if (!isset($checkData->is_error) && is_array($checkData) && isset($checkData[0]->price)) {
				$current_price = (float)$checkData[0]->price;
				if (abs($current_price - (float)$price) < 0.0001) {
					file_put_contents(DIR_LOGS . 'delovod_all_price_update.log',
						date('Y-m-d H:i:s') . " Пропущено: цена уже установлена ({$price}) для isbn {$id}\n",
						FILE_APPEND
					);
					return 1; // считаем как успешно
				}
			}

			// Установка новой цены
			$packet['action'] = "saveObject";
			$packet["params"]['header'] = [
				"id"         => "informationRegisters.goodsPrices",
				"date"       => $time->format('Y-m-d H:i:s'),
				"good"       => $id,
				"priceType"  => "1101300000001001", // Факт
				"price"      => $price,
				"currency"   => "1101200000001001"
			];

			$requestResult = $this->sendRequest($packet);
			$data = $this->handleResult($requestResult);

			if (!(isset($data->is_error) || isset($data->error) || $data == new \stdClass()) && isset($data->result)) {
				file_put_contents(DIR_LOGS . 'delovod_all_price_update.log', date('Y-m-d H:i:s') . " Установлена новая цена {$price} для isbn {$id}\n", FILE_APPEND);
				return 1;
			} else {
				$error_msg = (isset($data->error_msg) ? $data->error_msg : (isset($data->error) ? $data->error : ''));
				file_put_contents(DIR_LOGS . 'delovod_all_price_update.log', date('Y-m-d H:i:s') . " Ошибка установки цены для isbn {$id}: {$error_msg}\n", FILE_APPEND);
				return 0;
			}
		}
	}

	/**
	 * Set barcode for product by Id
	 *
	 * @param $id, $barcode
	 * @return int
	 */
	private function setBarcode($id, $barcode) {
		$log_file = DIR_LOGS . 'delovod_night_barcode_sync.log';
		file_put_contents($log_file, "[" . date('Y-m-d H:i:s') . "] setBarcode: попытка. ID={$id}, штрихкод={$barcode}\n", FILE_APPEND);

		if ($id == '' || $barcode == '') {
			file_put_contents($log_file, "[" . date('Y-m-d H:i:s') . "] setBarcode: данные пустые\n", FILE_APPEND);
			return 0;
		}

		// Формируем пакет
		$packet = [
			'action' => 'saveObject',
			'params' => [
				'header' => [
					'id'     => 'informationRegisters.barCodes',
					'object' => $id,
					'code'   => $barcode
				]
			]
		];

		$save = $this->sendRequest($packet);
		$result = $this->handleResult($save);

		if (!isset($result->is_error) && isset($result->id)) {
			file_put_contents($log_file, "[" . date('Y-m-d H:i:s') . "] setBarcode: успешно сохранено. ID={$id}, barcode={$barcode}, запись={$result->id}\n", FILE_APPEND);
			return $result->id;
		}

		file_put_contents($log_file, "[" . date('Y-m-d H:i:s') . "] setBarcode: ошибка: " . json_encode($result) . "\n", FILE_APPEND);
		return 0;
	}


	/**
	 * Get Object Id from delovod by object_type and object name
	 *
	 * @param $data
	 * @return int ObjectId
	 */
	private function getObjectId($object_type, $name = "", $operator = "%", $isGroup = false)
	{
		$json = [];
		$id = 0;
		if ($this->config->get('delovod_status') && $this->user->hasPermission('modify', 'extension/module/delovod')) {
			$packet['action'] = "request";
			$packet['params']['from'] = "catalogs." . $object_type;
			$packet['params']['fields'] = ["id" => "id", "name" => "name", "isGroup" => "isGroup"];
			if ($name != "") {
				if ($isGroup) {
					$packet['params']['filters'] = [
						[
							"alias"			=> "name",
							"operator"	=> $operator,
							"isGroup"		=> true,
							"value"			=> $name
						]
					];
				} else {
					$packet['params']['filters'] = [
						[
							"alias" => "name",
							"operator" => $operator,
							"value" => $name
						]
					];
				}
			}

			$requestResult = $this->sendRequest($packet);
			$data = $this->handleResult($requestResult);

			if (!(isset($data->is_error) || isset($data->error) || $data  == new \stdClass()) && count($data) == 1) {
				$id = $data[0]->id;
			}
		}
		return $id;
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
				"type" 					=> "balance",
				"register" 			=> "goods",
				"filters" => [
					[
						"alias" => "storage",
						"operator" => "=",
						"value" => "1100700000000001"
					]
				],
				"date" => $time->format('Y-m-d H:i:s'),
			];
			$packet["params"]["fields"] = [
				"good" => "good",
				"storage" => "storage",
				"good.id" => "id",
				"qty" => "qty"
			];
			//print_r($data);
			$requestResult = $this->sendRequest($packet);
			$data = $this->handleResult($requestResult);
			//print_r($data);die();
			if (!(isset($data->is_error) || isset($data->error) || $data  == new \stdClass())) {

				$this->load->model('extension/delovod');
				$this->model_extension_delovod->updateBalance($data);
				$time = new DateTime('now', new DateTimeZone('UTC'));
				file_put_contents(DIR_LOGS . 'delovod_update_balance.log', $time->format('Y-m-d H:i:s') . ' Всего:' . count($data) . "\n", FILE_APPEND);
				$this->session->data['success'] = "Cинхронизация остатков выполнена. Всего получено: " . count($data);
			} else {
				$error_msg = (isset($data->error_msg) ? $data->error_msg : 'Ошибка синхронизации остатков.');
				$this->session->data['warning'] = $error_msg;
				file_put_contents(DIR_LOGS . 'delovod_update_balance.log', $time->format('Y-m-d H:i:s') . ' ' . $error_msg . "\n", FILE_APPEND);
			}
		}
		$this->response->redirect($this->url->link('extension/module/delovod', 'token=' . $this->session->data['token'], true));
	}

	/**
	 * Update products artikul
	 */
	public function updateProductsArt($start = 0, $limit = 100)
	{
		$i = 0;
		$start = 3400;
		$this->load->model('catalog/product');
		$products = $this->model_catalog_product->getProducts(['start' => $start, 'limit' => $limit]);
		if ($products) {
			foreach ($products as $product) {
				if ($product['isbn'] != "") {
					$i++;
					$packet['action'] = "saveObject";
					$packet["params"]['header'] = [
						"id" 		=> $product['isbn'],
						"productNum"	=> $product['product_id'], // Артикул
					];
					//	print_r($product['product_id']. '  '. $product['isbn']);print_r('<br>');
					$requestResult = $this->sendRequest($packet);
				}
			}
		}
		print_r($start);
		print_r('<br>');
		print_r('Всего: ' . $i);
	}

	private function sendRequest($packet)
	{
		$return = new stdClass();

		$packet['key'] = $this->config->get('delovod_api_key');
		$packet['version'] = "0.15";

		if ($curl = curl_init()) {
			curl_setopt($curl, CURLOPT_URL, 'https://api.dilovod.ua');
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

	public function install()
	{
		// DB
		$query = $this->db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '" . DB_PREFIX . "order' AND table_schema = '" . DB_DATABASE . "' AND COLUMN_NAME = 'delovod_order_id'");
		if (!$query->num_rows) {
			$query = $this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `delovod_order_id` VARCHAR(20) NOT NULL AFTER `invoice_prefix`");
			$query = $this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD INDEX(`delovod_order_id`)");
		}
	}

	/**
	 * Set product name UA
	 *
	 * @param $category_id
	 * @return void
	 */
	private function updateNameUa($category_id, $page){
		$i = 0;
		$j = 0;
		$results = $this->model_extension_delovod->getProductsByCategoryId($category_id, false, $page);

		foreach ($results as $result) {
			$i++;
			$product_info = $this->model_extension_delovod->getProduct($result['product_id']);

			//if($product_info['isbn'] != '' && $product_info['name_ua'] != '' && $product_info['name_ua'] != $product_info['name']){
			if($product_info['isbn'] != '' && $product_info['name_ua'] != ''){	
				$packet['action'] = "saveObject";
				$packet["params"]['header'] = [
					"id" 		=> $product_info['isbn'],
					"name" 	=> [
						"uk" => $product_info['name_ua'],
					]
				];
				$requestResult = $this->sendRequest($packet);
				$data = $this->handleResult($requestResult);
				if (!isset($data->is_error)) {
					$j++;
				}

			}
		}

		$this->session->data['success'] = "Всего: " . $i . " Обновлено: " . $j . " Page: " . $page;
		
	}

	/**
	 * Set product Price
	 *
	 * @param $category_id
	 * @return void
	 */
	private function updatePrice($category_id, $page){
		$i = 0;
		$j = 0;
		$results = $this->model_extension_delovod->getProductsPriceByCategoryId($category_id, false, $page);
		$time = new DateTime('now', new DateTimeZone('UTC'));
		foreach ($results as $result) {
			$i++;
				if ($result['isbn'] != '') { // Обновить только цену
					if ($this->setPrice($result['isbn'], $result['price'], $time)) {
						$j++;
					}

				}
		}
		$this->session->data['success'] = "Обновление цен. Всего: " . $i . " Обновлено: " . $j . " Page: " . $page;
	}


	/* Обновление цен для всех товаров */
	public function updateAllPrices($page = 1)
	{
		$this->load->model('extension/delovod');

		$limit = 100;
		$log_file = DIR_LOGS . 'delovod_all_price_update.log';

		// Первая итерация — получаем общее количество товаров и сохраняем в сессии
		if ($page == 1 || !isset($this->session->data['delovod_total_items'])) {
			$total_items = $this->model_extension_delovod->getAllProductsTotalForPriceUpdate();
			$this->session->data['delovod_total_items'] = $total_items;
			$this->session->data['delovod_total_pages'] = ceil($total_items / $limit);
		}

		$total_items = $this->session->data['delovod_total_items'];
		$total_pages = $this->session->data['delovod_total_pages'];

		$products = $this->model_extension_delovod->getAllProductsForPriceUpdate($page, $limit);
		$total = count($products);

		file_put_contents($log_file, "[" . date('Y-m-d H:i:s') . "] [{$page}/{$total_pages}] — Обработка цен товаров (всего: {$total_items}, на странице: {$total})\n", FILE_APPEND);

		$updated = 0;
		$time = new DateTime('now', new DateTimeZone('UTC'));

		foreach ($products as $product) {
			$isbn = $product['isbn'] ?? null;
			$price = $product['price'] ?? null;

			if (!$isbn || !$price) continue;

			$result = $this->setPrice($isbn, $price, $time);

			if ($result === 1) {
				$updated++;
				file_put_contents($log_file, "[" . date('Y-m-d H:i:s') . "] → product_id: {$product['product_id']}, isbn: {$isbn}, price: {$price} → OK\n", FILE_APPEND);
			} else {
				file_put_contents($log_file, "[" . date('Y-m-d H:i:s') . "] → product_id: {$product['product_id']}, isbn: {$isbn}, price: {$price} → FAIL\n", FILE_APPEND);
			}
		}

		file_put_contents($log_file, "[" . date('Y-m-d H:i:s') . "] [{$page}/{$total_pages}] — Завершено. Обновлено: $updated.\n", FILE_APPEND);

		$this->session->data['success'] = "Обновлено товаров: $updated. Страница: $page из $total_pages. Всего товаров: $total_items.";

		// Переход на следующую страницу
		if ($page < $total_pages) {
			$next_url = $this->url->link('extension/module/delovod/sync', 'token=' . $this->session->data['token'] . '&update_all_prices=1&page=' . ($page + 1), true);
			$this->response->redirect($next_url);
		} else {
			// Последняя страница — очищаем и возвращаемся
			unset($this->session->data['delovod_total_items']);
			unset($this->session->data['delovod_total_pages']);

			$final_url = $this->url->link('extension/module/delovod', 'token=' . $this->session->data['token'], true);
			$this->response->redirect($final_url);
		}
	}

	/**
 * Массовое обновление штрихкодов по категории
 * @param $category_id
 * @param $page
 * @return void
 */
private function updateBarcode($category_id, $page = 0) {
    $i = 0;
    $j = 0;
    $results = $this->model_extension_delovod->getProductsForBarcodeSync($category_id, $page, 50);
    foreach ($results as $result) {
        $i++;
        if (!empty($result['isbn']) && !empty($result['ean'])) {
            if ($this->setBarcode($result['isbn'], $result['ean'])) {
                $j++;
            }
        }
    }
    $this->session->data['success'] = "Обновление штрихкодов. Всего: $i. Обновлено: $j. Page: $page";
}


	/**
     * Ночная синхронизация цен с Деловод
     * Для запуска через крон: https://shellnail.com.ua/index.php?route=extension/module/delovod/syncPrices
     * Для теста: ограничено 2 товарами (убрать ограничение после проверки)
     */
    public function syncPrices()
    {
        // Проверка статуса модуля
        if (!$this->config->get('delovod_status')) {
            exit('Delovod module disabled');
        }
        $this->load->model('extension/delovod');
        $limit = 100;
        $page = 1;
        $updated = 0;
        $log_file = DIR_LOGS . 'delovod_night_price_sync.log';
        $total_items = $this->model_extension_delovod->getAllProductsTotalForPriceUpdate();
        $total_pages = ceil($total_items / $limit);
        file_put_contents($log_file, "[" . date('Y-m-d H:i:s') . "] Ночная синхронизация цен. Всего товаров: {$total_items}\n", FILE_APPEND);
        $time = new DateTime('now', new DateTimeZone('UTC'));
        $test_limit = 2; // <--- ОГРАНИЧЕНИЕ ДЛЯ ТЕСТА, убрать после проверки
        $test_count = 0;
        $test_products = [];
        do {
            $products = $this->model_extension_delovod->getAllProductsForPriceUpdate($page, $limit);
            // Логируем содержимое массива $products для отладки
            file_put_contents($log_file, "[" . date('Y-m-d H:i:s') . "] [PAGE {$page}] Выборка товаров: " . print_r($products, true) . "\n", FILE_APPEND);
            foreach ($products as $product) {
                $isbn = $product['isbn'] ?? null;
                $price = $product['price'] ?? null;
                if (!$isbn || !$price) continue;
                $result = $this->setPrice($isbn, $price, $time);
                // Логируем id и isbn каждого переданного товара
                $test_products[] = [
                    'product_id' => $product['product_id'] ?? '',
                    'isbn' => $isbn,
                    'price' => $price
                ]; 
                if ($result === 1) {
                    $updated++;
                    file_put_contents($log_file, "[" . date('Y-m-d H:i:s') . "] → product_id: {$product['product_id']}, isbn: {$isbn}, price: {$price} → OK\n", FILE_APPEND);
                } else {
                    file_put_contents($log_file, "[" . date('Y-m-d H:i:s') . "] → product_id: {$product['product_id']}, isbn: {$isbn}, price: {$price} → FAIL\n", FILE_APPEND);
                }
                $test_count++;
                if ($test_count >= $test_limit) break; // <--- ОГРАНИЧЕНИЕ ДЛЯ ТЕСТА
            }
            if ($test_count >= $test_limit) break; // <--- ОГРАНИЧЕНИЕ ДЛЯ ТЕСТА
            $page++;
        } while ($page <= $total_pages);
        // Логируем итоговый список переданных товаров
        file_put_contents($log_file, "[" . date('Y-m-d H:i:s') . "] Переданы товары (TEST): " . print_r($test_products, true) . "\n", FILE_APPEND);
        file_put_contents($log_file, "[" . date('Y-m-d H:i:s') . "] Завершено. Обновлено: $updated.\n", FILE_APPEND);
        exit("OK. Updated: $updated (TEST MODE: только 2 товара)");
    }

	public function test()
	{
		$this->load->model('extension/delovod');
		$product_info = $this->model_extension_delovod->getProduct(4060);
		//print_r($product_info);die();
		// $packet['action'] = "saveObject";
		// $packet["params"]['header'] = [
		// 	"id" 		=> "1100300000003854",
		// 	"name" 	=> [
		// 		"uk" => $product_info['name_ua'],
		// 	]
		// ];
		// $requestResult = $this->sendRequest($packet);
		// $data = $this->handleResult($requestResult);
		// print_r($data);die();

		$packet['action'] = "request";
		$packet['params']['from'] = "catalogs.goods";
		$packet['params']['fields'] = ["id" => "id", "name" => "name"];
		$packet['params']['multilang'] = true;
		
		$packet['params']['filters'] = [
			[
				"alias" => "id",
				"operator" => '=',
				"value" => '1100300000003854'
			]
		];

		$requestResult = $this->sendRequest($packet);
		$data = $this->handleResult($requestResult);
		print_r($data);
	}
}
