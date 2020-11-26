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

		if (isset($this->request->post['sd_np_status'])) {
			$data['sd_np_status'] = $this->request->post['sd_np_status'];
		} else {
			$data['sd_np_status'] = $this->config->get('sd_np_status');
		}

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
	public function add_invoice()
	{
		$json = array();
		$json['err'] = true;
		$re = '/№(\d+)/';

		if ($this->config->get('sd_np_status') && $this->request->get['order_id'] > 0) {
			$order_id = $this->request->get['order_id'];
			$this->load->model('sale/order');
			$this->load->model('catalog/product');
			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info && $order_info['shipping_code'] == 'new_mail.new_mail') {
				$this->load->model('catalog/product');
				$weight = 0;

				$this->load->model('extension/module/sd_np_invoice');

				$volumeGeneral = 1;
				$packaging_id = 0;
				$packaging_id = $this->model_extension_module_sd_np_invoice->getPackageOrder($order_id);
				if($packaging_id){
					$packaging = $this->model_extension_module_sd_np_invoice->getPackage($packaging_id);
					if($packaging) {
						$volumeGeneral = $packaging['volume'];
					}
				}
				$shippingCost = $this->model_extension_module_sd_np_invoice->getShippingCostOrder($order_id);
				
				preg_match_all($re, $order_info['shipping_address_2'], $matches, PREG_SET_ORDER, 0);
				if($matches){
					$warehouse = $matches[0][1];
				}

				$data = [
					"apiKey" => $this->config->get('sd_np_key'),
					"modelName" => "InternetDocument",
					"calledMethod" => "save",
					"methodProperties" => [
						"NewAddress" => "1",
						"PayerType" => ($shippingCost > 0 ? "Recipient" :"Sender"),
						"PaymentMethod" => ($shippingCost > 0 ? "Cash" :"NonCash"),
						"CargoType" => "Parcel",
						"VolumeGeneral" => $volumeGeneral,
						"Weight" => $this->model_extension_module_sd_np_invoice->getWeightOrder($order_id),
						"ServiceType" => "WarehouseWarehouse",
						"SeatsAmount" => 1,
						"Description" => "Косметика, косметологічне обладнання",
						"Cost" => ($order_info['payment_code'] == 'privat'? 200 : $order_info['total']),
						"CitySender" => "db5c8927-391c-11dd-90d9-001a92567626",
						"Sender" => "02ce79aa-7659-11e9-9937-005056881c6b",
						"SenderAddress" => "2bb8cec2-e1c2-11e3-8c4a-0050568002cf",
						"ContactSender" => "07e5ea95-7659-11e9-9937-005056881c6b",
						"SendersPhone" => "380668077050",
						"RecipientCityName" => $order_info['shipping_city'],
						"RecipientArea" => "",
						"RecipientAreaRegions" => "",
						"RecipientAddressName" => $warehouse,
						"RecipientHouse" => "",
						"RecipientFlat" => "",
						"RecipientName" => ucfirst($order_info['firstname']) . ' ' .ucfirst( $order_info['lastname']),
						"RecipientType" => "PrivatePerson",
						"RecipientsPhone" => preg_replace('/\D/', '', $order_info['telephone']),
						"DateTime" => date('d.m.Y', strtotime("+1 day"))
					]
				];

				$response =  $this->sendRequest($data);
				if ($response) {
					$res = json_decode($response);
					if($res->success){
						$this->model_extension_module_sd_np_invoice->setInvoiceOrder($order_id,$res->data[0]->IntDocNumber,$packaging_id);
						$json['invoice'] = $res->data[0]->IntDocNumber;
						$json['err'] = false;
						
					}
					$json['response'] = $response;
				}
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
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

			return $response;
		} catch (\Exception $e) {
			return false;
		}
	}
}
