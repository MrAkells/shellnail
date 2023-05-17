<?php
class ControllerExtensionModuleSdNpInvoice extends Controller
{
	private $error = array();
	private $urlApi = 'https://api.novaposhta.ua/v2.0/json/';

	public function install()
	{

		$this->load->model('extension/module/sd_np_invoice');

		$this->model_extension_module_sd_np_invoice->createTable();
	}

	public function index()
	{
		$this->load->language('extension/module/sd_np_invoice');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('sd_np', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_np_key'] = $this->language->get('entry_np_key');
		$data['entry_np_sender'] = $this->language->get('entry_np_sender');
		$data['entry_np_сontact_sender'] = $this->language->get('entry_np_сontact_sender');
		$data['entry_np_ref_city'] = $this->language->get('entry_np_ref_city');
		$data['entry_np_ref_sender_address'] = $this->language->get('entry_np_ref_sender_address');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['np_key'])) {
			$data['error_np_key'] = $this->error['np_key'];
		} else {
			$data['error_np_key'] = '';
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
			'href' => $this->url->link('extension/module/sd_np_invoice', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/sd_np_invoice', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);


		if (isset($this->request->post['sd_np_key'])) {
			$data['sd_np_key'] = $this->request->post['sd_np_key'];
		} else {
			$data['sd_np_key'] = $this->config->get('sd_np_key');
		}

		if (isset($this->request->post['sd_np_сontact_phone'])) {
			$data['sd_np_сontact_phone'] = $this->request->post['sd_np_сontact_phone'];
		} else {
			$data['sd_np_сontact_phone'] = $this->config->get('sd_np_сontact_phone');
		}

		if (isset($this->request->post['sd_np_ref_city'])) {
			$data['sd_np_ref_city'] = $this->request->post['sd_np_ref_city'];
		} else {
			$data['sd_np_ref_city'] = $this->config->get('sd_np_ref_city');
		}

		if (isset($this->request->post['sd_np_ref_sender_address'])) {
			$data['sd_np_ref_sender_address'] = $this->request->post['sd_np_ref_sender_address'];
		} else {
			$data['sd_np_ref_sender_address'] = $this->config->get('sd_np_ref_sender_address');
		}

		if (isset($this->request->post['sd_np_status'])) {
			$data['sd_np_status'] = $this->request->post['sd_np_status'];
		} else {
			$data['sd_np_status'] = $this->config->get('sd_np_status');
		}
		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/sd_np_invoice', $data));
	}


	protected function validate()
	{
		if (!$this->user->hasPermission('modify', 'extension/module/sd_np_invoice')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->request->post['sd_np_key']) {
			$this->error['np_key'] = $this->language->get('error_np_key');
		}
		return !$this->error;
	}

	public function packages()
	{

		$this->load->language('extension/module/sd_np_invoice');

		$this->document->setTitle($this->language->get('heading_title_packages'));
		$data['heading_title'] = $this->language->get('heading_title_packages');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title_packages'),
			'href' => $this->url->link('extension/module/sd_np_invoice/packages', 'token=' . $this->session->data['token'], true)
		);


		$data['add'] = $this->url->link('extension/module/sd_np_invoice/packages_add', 'token=' . $this->session->data['token'], true);
		$data['delete'] = $this->url->link('extension/module/sd_np_invoice/packages_delete', 'token=' . $this->session->data['token'], true);

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_title'] = $this->language->get('column_title');
		$data['column_volume'] = $this->language->get('column_volume');
		$data['column_action'] = $this->language->get('column_action');

		$data['packages'] = array();

		$this->load->model('extension/module/sd_np_invoice');

		$results = $this->model_extension_module_sd_np_invoice->getPackages();
		foreach ($results as $result) {
			$data['packages'][] = array(
				'packaging_id'  => $result['packaging_id'],
				'title'      	=> $result['title'],
				'volume'      	=> $result['volume'],
				'edit'          => $this->url->link('extension/module/sd_np_invoice/packages_edit', 'token=' . $this->session->data['token'] . '&packaging_id=' . $result['packaging_id'], true)
			);
		}

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/sd_np_packages_list', $data));
	}

	public function packages_add()
	{
		$this->load->language('extension/module/sd_np_invoice');
		$this->load->model('extension/module/sd_np_invoice');

		$this->document->setTitle($this->language->get('heading_title_packages'));


		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm($this->request->post)) {

			$this->model_extension_module_sd_np_invoice->addPackage($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module/sd_np_invoice/packages', 'token=' . $this->session->data['token'], true));
		}

		$this->getForm();
	}

	public function packages_edit()
	{
		$this->load->language('extension/module/sd_np_invoice');
		$this->load->model('extension/module/sd_np_invoice');

		$this->document->setTitle($this->language->get('heading_title_packages'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm($this->request->post)) {
			$this->model_extension_module_sd_np_invoice->editPackage($this->request->get['packaging_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module/sd_np_invoice/packages', 'token=' . $this->session->data['token'], true));
		}

		$this->getForm(true);
	}

	public function packages_delete()
	{
		$this->load->language('extension/module/sd_np_invoice');
		$this->load->model('extension/module/sd_np_invoice');

		$this->document->setTitle($this->language->get('heading_title_packages'));

		if (isset($this->request->post['selected'])) {

			$this->model_extension_module_sd_np_invoice->deletePackages($this->request->post['selected']);

			$this->session->data['success'] = $this->language->get('text_success');
		}

		$this->response->redirect($this->url->link('extension/module/sd_np_invoice/packages', 'token=' . $this->session->data['token'], true));
	}

	protected function getForm($edit = false)
	{
		if ($edit) {
			$data['edit_mode'] = 1;
		} else {
			$data['edit_mode'] = 0;
		}

		$data['heading_title'] = $this->language->get('heading_title_packages');

		$data['text_form'] = !isset($this->request->get['packaging_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_volume'] = $this->language->get('entry_volume');
		$data['entry_dimension'] = $this->language->get('entry_dimension');
		$data['entry_length'] = $this->language->get('entry_length');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title_packages'),
			'href' => $this->url->link('extension/module/sd_np_invoice/packages', 'token=' . $this->session->data['token'], true)
		);



		if (!isset($this->request->get['packaging_id'])) {
			$data['action'] = $this->url->link('extension/module/sd_np_invoice/packages_add', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/sd_np_invoice/packages_edit', 'token=' . $this->session->data['token'] . '&packaging_id=' . $this->request->get['packaging_id'], true);
			$data['packaging_id'] = $this->request->get['packaging_id'];
			$package_info = $this->model_extension_module_sd_np_invoice->getPackage($this->request->get['packaging_id']);
		}

		$data['cancel'] = $this->url->link('extension/module/sd_np_invoice/packages', 'token=' . $this->session->data['token'], true);

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->request->post['title'])) {
			$data['title'] = $this->request->post['title'];
		} elseif (isset($this->request->get['packaging_id'])) {
			$data['title'] = $package_info['title'];
		} else {
			$data['title'] = '';
		}
		if (isset($this->request->post['volume'])) {
			$data['volume'] = $this->request->post['volume'];
		} elseif (isset($this->request->get['packaging_id'])) {
			$data['volume'] = $package_info['volume'];
		} else {
			$data['volume'] = '';
		}

		if (isset($this->request->post['length'])) {
			$data['length'] = $this->request->post['length'];
		} elseif (!empty($package_info)) {
			$data['length'] = $package_info['length'];
		} else {
			$data['length'] = '';
		}

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($package_info)) {
			$data['width'] = $package_info['width'];
		} else {
			$data['width'] = '';
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($package_info)) {
			$data['height'] = $package_info['height'];
		} else {
			$data['height'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/sd_np_packages_form', $data));
	}

	protected function validateForm($data = [])
	{

		if (!$this->user->hasPermission('modify', 'catalog/promotions')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$data['title']) {
			$this->error['warning'] = $this->language->get('error_title');
		}
		if (!$data['volume']) {
			$this->error['warning'] = $this->language->get('error_volume');
		}

		return !$this->error;
	}

	public function set_order_package()
	{

		if ($this->config->get('sd_np_status') && $this->request->get['order_id'] > 0 &&  $this->request->get['package_id'] > 0) {
			$this->load->model('extension/module/sd_np_invoice');
			$this->model_extension_module_sd_np_invoice->setOrderPackage($this->request->get);
		}
	}

	public function add_invoices()
	{
		$type = 0;
		$json = [];
		if ($this->config->get('sd_np_status')) {

			$this->load->model('sale/order');
			$this->load->model('catalog/product');
			$this->load->model('extension/module/sd_np_invoice');

			if (isset($this->request->post['selected'])) {
				$orders = $this->request->post['selected'];
			} elseif (isset($this->request->get['order_id'])) {
				$type = 1;
				$orders[] = $this->request->get['order_id'];
			}
			$json['total'] = count($orders);
			$errors = '';
			foreach ($orders as $order_id) {
				$json = $this->add_invoice($order_id);
				if ($json['err'] && isset($json['errors'])) {
					$errors .= $order_id . ': ' . $json['errors'] . '<br>';
				}
			}
		}
		if ($type) {
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		} else {

			if ($errors) $this->session->data['warning'] = '<br>' . $errors;

			$this->response->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'], true));
		}
	}

	private function add_invoice($order_id)
	{
		$json = array();
		$json['err'] = true;
		$is_warning = false;
		$is_documents = false;

		if ($order_id > 0) {
			$ttn = $this->model_extension_module_sd_np_invoice->getInvoiceOrder($order_id);
			if ($ttn && $ttn['np_number']) {
				$json['errors'] = 'ТТН уже существует, №' . $ttn['np_number'];
				return $json;
			}

			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info && ($order_info['shipping_code'] == 'new_mail.new_mail' || $order_info['shipping_code'] == 'couriernp.couriernp')) {
				$weight = $this->model_extension_module_sd_np_invoice->getWeightOrder($order_id);
				$volumeGeneral = 0;
				$optionsSeat = [];
				$packaging_id = $this->model_extension_module_sd_np_invoice->getPackageOrder($order_id);
				if ($packaging_id) {
					$packaging = $this->model_extension_module_sd_np_invoice->getPackage($packaging_id);
					if($packaging['title'] == 'Спец - Документы'){
						$is_documents = true;
						if($weight <= 0.1) 
							$weight = 0.1;
						elseif($weight <= 0.5) 
							$weight = 0.5;
						else 
							$weight = 1;
					}

					if ($packaging) {
						$volumeGeneral = $packaging['volume'];
						$optionsSeat = [
							[
								"volumetricVolume" 	=> $packaging['volume'],
								"volumetricWidth" 	=> $packaging['width'],
								"volumetricLength"	=> $packaging['length'],
								"volumetricHeight"	=> $packaging['height'],
								"weight"			=> $weight
							]
						];

					}
				} else {
					$json['errors'] = 'Необходимо выбрать упаковку!';
					return $json;
				}

				$shippingCost = $this->model_extension_module_sd_np_invoice->getShippingCostOrder($order_id);

				$payer_type = "Sender";
				if ($order_info['payment_code'] == 'privat' && $order_info['shipping_code'] == 'new_mail.new_mail' && $shippingCost > 0) {
					$payer_type = "Recipient";
				}
				$ref_city = $this->model_extension_module_sd_np_invoice->getRefCity($order_info['shipping_city']);
				if ($ref_city == '') {
					$ref_city = $this->config->get('sd_np_ref_city');
					$is_warning = true;
				}
				// if($order_info['telephone']){
				// 	$customer_phone = preg_replace('/\D/', '', $order_info['telephone']);
				// } else if ($order_info['shipping_custom_field']) {
				// 	if(isset($order_info['shipping_custom_field'][1])) $customer_phone = preg_replace('/\D/', '', $order_info['shipping_custom_field'][1]);
				// }
				$customer_phone = '';
				if ($order_info['shipping_custom_field']) {
					if (isset($order_info['shipping_custom_field'][1])) {
						$customer_phone = $order_info['shipping_custom_field'][1];
					} else if ($customer_phone == '' && isset($order_info['shipping_custom_field']['phone'])) {
						$customer_phone =  $order_info['shipping_custom_field']['phone'];
					}
				}
				if ($customer_phone == '' && $order_info['telephone']) {
					$customer_phone = $order_info['telephone'];
				}
				if($customer_phone) $customer_phone = preg_replace('/\D/', '', $customer_phone);

				$data = [
					"apiKey" => $this->config->get('sd_np_key'),
					"modelName" => "InternetDocument",
					"calledMethod" => "save",
					"methodProperties" => [
						"NewAddress" => "1",
						"PayerType" => $payer_type,
						"PaymentMethod" => ($payer_type == "Recipient" ? "Cash" : "NonCash"),
						"CargoType" => $is_documents ? "Documents" : "Parcel", 
						"VolumeGeneral" => $volumeGeneral,
						"Weight" => $weight,
						"ServiceType" => ($order_info['shipping_code'] == 'new_mail.new_mail' ? 'WarehouseWarehouse' : 'WarehouseDoors'),
						"Description" => $is_documents ? "Сертифікати на продукцію" : "Косметика, косметологічне обладнання",
						"SeatsAmount" => 1,
						"Cost" => ($order_info['payment_code'] == 'privat' ? 200 : round($order_info['total'])),
						"CitySender" => $this->config->get('sd_np_ref_city'),
						"Sender" => $this->config->get('sd_np_sender'),
						"SenderAddress" => $this->config->get('sd_np_ref_sender_address'),
						"ContactSender" => $this->config->get('sd_np_сontact_sender'),
						"SendersPhone" => $this->config->get('sd_np_сontact_phone'),
						"CityRecipient" => $ref_city,
						"RecipientArea" => "",
						"RecipientAreaRegions" => "",
						"RecipientName" => ucfirst($order_info['payment_firstname']) . ($order_info['shipping_code'] == 'couriernp.couriernp' || $payer_type == "Recipient" ? ' ОТЧЕСТВО ' : ' ') . ucfirst($order_info['payment_lastname']),
						"RecipientType" => "PrivatePerson",
						"RecipientsPhone" => $customer_phone,
						"DateTime" => date('d.m.Y')
					]
				];

				// Параметр вантажу для кожного місця відправлення
				if($order_info['shipping_code'] == 'new_mail.new_mail'){
					$data['methodProperties']['OptionsSeat'] = $optionsSeat;
				}

				//Формирование запроса на создание «ЭН» с услугой «Контроль оплаты»
				if ($order_info['payment_code'] == 'cod') $data['methodProperties']['AfterpaymentOnGoodsCost'] = round($order_info['total']);

				$adress = strip_tags($order_info['shipping_address_2']);
				if(!$adress){
					$adress = strip_tags($order_info['shipping_address_1']);
				}

				if ($order_info['shipping_code'] == 'new_mail.new_mail') {
					//if set office_ref
					if($order_info['custom_field'] && isset($order_info['custom_field']['newmail_office_ref']) && strlen($order_info['custom_field']['newmail_office_ref']) > 25){
						$data['methodProperties']['RecipientAddress'] = $order_info['custom_field']['newmail_office_ref'];
					} else { // not set office_ref
						$adress = mb_substr($adress, 23);

						$data['methodProperties']['RecipientAddress'] = $this->model_extension_module_sd_np_invoice->getRefOffice($adress,$ref_city);
						if (!$data['methodProperties']['RecipientAddress']) { // if not found Office
							$data['methodProperties']['RecipientAddress'] = $this->config->get('sd_np_ref_sender_address');
							$data['methodProperties']['CityRecipient'] = $this->config->get('sd_np_ref_city');
							$is_warning = true;
						}
					}

				} else {
					$ar_adress = explode(",", $adress);
					if (count($ar_adress) > 1) {
						$address_name = (isset($ar_adress[1]) ? trim($ar_adress[1]) : $adress);
						preg_match_all('/\s(\d+)\,*\s*?(\d+)*/', $adress, $matches, PREG_SET_ORDER, 0);

						if ($matches) {
							$data['methodProperties']["RecipientAddressName"] = $address_name;
							$data['methodProperties']["RecipientHouse"] = (isset($matches[0][1]) ? $matches[0][1] : '');
							$data['methodProperties']["RecipientFlat"] = (isset($matches[1][1]) ? $matches[1][1] : '');
						} else {
							$is_warning = true;
							$data['methodProperties']["RecipientAddressName"] = 'вул. Олекси Тихого';
							$data['methodProperties']["RecipientHouse"] = '70';
						}
					} else {
						$is_warning = true;
						$data['methodProperties']["RecipientAddressName"] = 'вул. Олекси Тихого';
						$data['methodProperties']["RecipientHouse"] = '70';
					}
				}

				$res =  $this->sendRequest($data);
				if ($res) {
					if ($res->success) {
						$this->model_extension_module_sd_np_invoice->setInvoiceOrder($order_id, $res->data[0]->IntDocNumber, $packaging_id, $is_warning);
						$json['invoice'] = $res->data[0]->IntDocNumber;
						$json['is_warning'] = $is_warning;

						$json['err'] = false;
					} else {
						$json['errors'] = '';
						foreach ($res->errors as $error) {
							$json['errors'] .= $error . ' ';
						}
						$json['data'] = $data;
					}
				}
			}
		}

		return $json;
	}

	/**
	 * Загрузить список Контрагентов отправителей/получателей/третье лицо
	 * @return json
	 */
	public function get_senders()
	{
		$json = array();
		$json['err'] = true;
		$data = [
			"apiKey" => $this->config->get('sd_np_key'),
			"modelName" => "Counterparty",
			"calledMethod" => "getCounterparties",
			"methodProperties" => [
				"CounterpartyProperty" => "Sender",
				"Page" => "1"
			]
		];
		$res =  $this->sendRequest($data);
		if ($res) {
			if ($res->success) {
				$json['senders'] = '';
				foreach ($res->data as $sender) {
					$json['senders'] .= '<option value="' . $sender->Ref . '" ' . ($this->config->get('sd_np_sender') == $sender->Ref ? 'selected="selected"' : '') . '>' . $sender->Description . '</option>';
				}
				$json['err'] = false;
			} else {
				$json['errors'] = '';
				foreach ($res->errors as $error) {
					$json['errors'] .= $error . ' ';
				}
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	/**
	 * Загрузить список контактных лиц Контрагента
	 * @return json
	 */
	public function get_contacts()
	{
		$json = array();
		$json['err'] = true;
		if ($this->config->get('sd_np_sender')) {
			$data = [
				"apiKey" => $this->config->get('sd_np_key'),
				"modelName" => "Counterparty",
				"calledMethod" => "getCounterpartyContactPersons",
				"methodProperties" => [
					"Ref" => $this->config->get('sd_np_sender'),
					"Page" => "1"
				]
			];
			$res =  $this->sendRequest($data);
			if ($res) {
				if ($res->success) {
					$json['contacts'] = '';
					$json['contact_phone'] = '';
					foreach ($res->data as $contact) {
						if ($this->config->get('sd_np_сontact_sender') == $contact->Ref) {
							$json['contacts'] .= '<option value="' . $contact->Ref . '" selected="selected" data-phone="' . $contact->Phones . '">' . $contact->Description . '</option>';
							$json['contact_phone'] = $contact->Phones;
						} else {
							if ($json['contact_phone'] == '') $json['contact_phone'] = $contact->Phones;
							$json['contacts'] .= '<option value="' . $contact->Ref . '" data-phone="' . $contact->Phones . '">' . $contact->Description . '</option>';
						}
					}
					$json['err'] = false;
				} else {
					$json['errors'] = '';
					foreach ($res->errors as $error) {
						$json['errors'] .= $error . ' ';
					}
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function fix_invoices()
	{
		$json = [];
		$json['err'] = true;
		$this->load->model('extension/module/sd_np_invoice');

		if (isset($this->request->get['ttn'])) {
			$this->model_extension_module_sd_np_invoice->setCheckInvoiceOrder($this->request->get['ttn']);
			$json['err'] = false;
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	/**
	 * Отправить ТТН клиенту
	 */
	public function send_invoices()
	{
		$this->load->language('extension/module/sd_np_invoice');

		$comment = $this->language->get('text_comment');
		$errors = '';
		$order_status = 1; // Отправлен
		$count = 0;
		
		if ($this->config->get('sd_np_status')) {

			$this->load->model('sale/order');
			$this->load->model('extension/module/sd_np_invoice');
			
			// load model from CATALOG
			$this->load_model('checkout/order');
			$this->load_model('account/customer');
			$this->load_model('extension/extension');

			if (isset($this->request->post['selected'])) {
				$orders = $this->request->post['selected'];
				foreach ($orders as $order_id) {
					$order_info = $this->model_sale_order->getOrder($order_id);
					if($order_info['order_status_id'] != 1){
						$number = $this->model_extension_module_sd_np_invoice->getInvoiceOrder($order_id);
						if($number && $number['np_number']){
							$comment_order = sprintf($comment, $number['np_number']);
							$this->model_checkout_order->addOrderHistory($order_id, $order_status, $comment_order, 1, 0);
							$count++;
						} else {
							$errors .= $order_id . ' нет ТТН<br>';
						}
					} else {
						$errors .= $order_id . ' ' .$order_info['order_status_id']. ' <br>';
					}
				}
			}
		}

		if ($errors) $this->session->data['warning'] = $errors;
		if($count) $this->session->data['success'] = sprintf($this->language->get('text_success_send'), $count);
		
		$this->response->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'], true));

	}

	/**
	 * @param $data
	 * @return bool|mixed
	 */
	protected function sendRequest($data)
	{
		$data_json = json_encode($data);
		try {
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $this->urlApi);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

			$response = curl_exec($ch);

			curl_close($ch);

			return json_decode($response);
		} catch (\Exception $e) {
			return false;
		}
	}

	// Load model from CATALOG
	private function load_model($model) {
		require(DIR_CATALOG.'model/'.$model.'.php');
		$model_path = 'model_'.str_replace('/', '_', $model);
		$model_name = $this->create_model_name($model);
		$this->$model_path = new $model_name( $this->registry );
	}
	private function create_model_name($model) {
		$m_expl = explode('/', $model);
		foreach($m_expl as $m) {
		  $m_UC[] = ucfirst($m);
		}

		return 'Model'.implode('', $m_UC);
	}
}
