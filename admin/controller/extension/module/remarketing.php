<?php
class ControllerExtensionModuleRemarketing extends Controller {
	private $error = [];
	private $purchased_domain = '';
	private $order = '';
	private $seller = '';  
	private $version = '';

	public function index() {
		
		$this->load->language('extension/module/remarketing');
		
		if (version_compare(VERSION,'3.0.0.0', '>=')) {
			$token = 'user_token=' . $this->session->data['user_token'];
			$data['user_token'] = $this->session->data['user_token'];
			$extension = 'marketplace/extension';
		} else {
			$token = 'token=' . $this->session->data['token'];
			$data['token'] = $this->session->data['token'];
			$extension = 'extension/extension';
		}

		$this->document->setTitle(strip_tags(html_entity_decode($this->language->get('heading_title'))));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$this->model_setting_setting->editSetting('remarketing', $this->request->post);
			if (version_compare(VERSION,'3.0.0.0', '>=')) {
				if ($this->request->post['remarketing_status']) {
					$this->request->post['module_remarketing_status'] = $this->request->post['remarketing_status'];
				}
				$this->model_setting_setting->editSetting('module_remarketing', $this->request->post);
			}
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link($extension, $token . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_id'] = $this->language->get('text_id');
		$data['text_model'] = $this->language->get('text_model');
		$data['text_identifier'] = $this->language->get('text_identifier');
		$data['text_events'] = $this->language->get('text_events');
		$data['text_esputnik'] = $this->language->get('text_esputnik');
		$data['text_ecommerce'] = $this->language->get('text_ecommerce');
		$data['text_ecommerce_gtag'] = $this->language->get('text_ecommerce_gtag');
		$data['text_ecommerce_ga4'] = $this->language->get('text_ecommerce_ga4');
		$data['text_ecommerce_ga4_measurement'] = $this->language->get('text_ecommerce_ga4_measurement');
		$data['text_ecommerce_measurement'] = $this->language->get('text_ecommerce_measurement');
		$data['text_help_google'] = $this->language->get('text_help_google');
		$data['text_help_facebook'] = $this->language->get('text_help_facebook');
		$data['text_diagnostics'] = $this->language->get('text_diagnostics');
		$data['text_check_install'] = $this->language->get('text_check_install');
		$data['text_check_config'] = $this->language->get('text_check_config');
		$data['text_help_link'] = $this->language->get('text_help_link');
		$data['text_not_selected'] = $this->language->get('text_not_selected');
		$data['text_feed'] = $this->language->get('text_feed');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$data['text_category_google'] = $this->language->get('text_category_google');
		$data['text_forum_documentation'] = $this->language->get('text_forum_documentation');
		$data['text_version'] = $this->language->get('text_version');
		
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_currency'] = $this->language->get('entry_currency');
		$data['entry_ecommerce_ratio'] = $this->language->get('entry_ecommerce_ratio');
		$data['entry_ecommerce_selector'] = $this->language->get('entry_ecommerce_selector');
		$data['entry_ecommerce_ga4_selector'] = $this->language->get('entry_ecommerce_selector');
		$data['entry_ecommerce_ga4_identifier'] = $this->language->get('entry_ecommerce_ga4_identifier');
		$data['entry_ecommerce_ga4_analytics_id'] = $this->language->get('entry_ecommerce_ga4_analytics_id');
		$data['entry_ecommerce_ga4_api_secret'] = $this->language->get('entry_ecommerce_ga4_api_secret');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', $token, true)
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link($extension, $token . '&type=module', true)
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/remarketing', $token, true)
		];

		$data['action'] = $this->url->link('extension/module/remarketing', $token, true);

		$data['cancel'] = $this->url->link($extension, $token . '&type=module', true);
		
		$data['test_facebook'] = html_entity_decode($this->url->link('extension/module/remarketing/testFacebook', $token, true));
		$data['check_version'] = html_entity_decode($this->url->link('extension/module/remarketing/checkVersion', $token, true));

		if (isset($this->request->post['remarketing_status'])) {
			$data['remarketing_status'] = $this->request->post['remarketing_status'];
		} else {
			$data['remarketing_status'] = $this->config->get('remarketing_status');
		}
		
		if (isset($this->request->post['remarketing_ecommerce_ratio'])) {
			$data['remarketing_ecommerce_ratio'] = $this->request->post['remarketing_ecommerce_ratio'];
		} elseif ($this->config->get('remarketing_ecommerce_ratio')) {
			$data['remarketing_ecommerce_ratio'] = $this->config->get('remarketing_ecommerce_ratio');
		} else {
			$data['remarketing_ecommerce_ratio'] = '1';
		}
		
		$this->load->model('localisation/currency');
		
		$currencies = $this->model_localisation_currency->getCurrencies();
		
		$data['currencies'] = $currencies;
		
		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['remarketing_ecommerce_currency'])) {
			$data['remarketing_ecommerce_currency'] = $this->request->post['remarketing_ecommerce_currency'];
		} else {
			$data['remarketing_ecommerce_currency'] = $this->config->get('remarketing_ecommerce_currency');
		}

		if (isset($this->request->post['remarketing_ecommerce_status'])) {
			$data['remarketing_ecommerce_status'] = $this->request->post['remarketing_ecommerce_status'];
		} else {
			$data['remarketing_ecommerce_status'] = $this->config->get('remarketing_ecommerce_status');
		}

		if (isset($this->request->post['remarketing_ecommerce_ga4_status'])) {
			$data['remarketing_ecommerce_ga4_status'] = $this->request->post['remarketing_ecommerce_ga4_status'];
		} else {
			$data['remarketing_ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status');
		}

		if (isset($this->request->post['remarketing_ecommerce_selector'])) {
			$data['remarketing_ecommerce_selector'] = $this->request->post['remarketing_ecommerce_selector'];
		} elseif ($this->config->get('remarketing_ecommerce_selector')) {
			$data['remarketing_ecommerce_selector'] = $this->config->get('remarketing_ecommerce_selector');
		} else {
			$data['remarketing_ecommerce_selector'] = '.product-thumb';
		}
		
		if (isset($this->request->post['remarketing_ecommerce_ga4_selector'])) {
			$data['remarketing_ecommerce_ga4_selector'] = $this->request->post['remarketing_ecommerce_ga4_selector'];
		} elseif ($this->config->get('remarketing_ecommerce_ga4_selector')) {
			$data['remarketing_ecommerce_ga4_selector'] = $this->config->get('remarketing_ecommerce_ga4_selector');
		} else {
			$data['remarketing_ecommerce_ga4_selector'] = '.product-thumb';
		}

		if (isset($this->request->post['remarketing_ecommerce_ga4_id'])) {
			$data['remarketing_ecommerce_ga4_id'] = $this->request->post['remarketing_ecommerce_ga4_id'];
		} else {
			$data['remarketing_ecommerce_ga4_id'] = $this->config->get('remarketing_ecommerce_ga4_id');
		}


		if (isset($this->request->post['remarketing_ecommerce_ga4_identifier'])) {
			$data['remarketing_ecommerce_ga4_identifier'] = $this->request->post['remarketing_ecommerce_ga4_identifier'];
		} else {
			$data['remarketing_ecommerce_ga4_identifier'] = $this->config->get('remarketing_ecommerce_ga4_identifier');
		}

		$data['check_install'] = $this->checkInstall();
		
		$data['check_config'] = $this->checkConfig();
		$data['version'] = $this->version;
		$data['domain'] = HTTPS_CATALOG;
		$data['purchased_domain'] = $this->purchased_domain;
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/remarketing', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/remarketing')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
	protected function checkInstall() {
		$check = '';
		
		if (version_compare(VERSION,'3.0.0.0', '>=')) {
			$files = [
				'admin/controller/sale/order.php',
				'catalog/controller/common/header.php',
				'catalog/controller/common/footer.php',
				'catalog/controller/product/product.php',
				'catalog/controller/product/category.php',
				'catalog/controller/product/manufacturer.php',
				'catalog/controller/product/search.php',
				'catalog/controller/product/special.php',
				'catalog/controller/checkout/cart.php',
				'catalog/controller/account/wishlist.php',
				'catalog/controller/information/contact.php',
				'catalog/model/checkout/order.php',
				'catalog/model/account/customer.php',
				'admin/view/template/sale/order_info.twig',
				'catalog/view/theme/{*}/template/common/header.twig',
				'catalog/view/theme/{*}/template/common/footer.twig',
				'catalog/view/theme/{*}/template/product/product.twig',
				'catalog/view/theme/{*}/template/product/category.twig',
				'catalog/view/theme/{*}/template/product/manufacturer_info.twig',
				'catalog/view/theme/{*}/template/product/search.twig',
				'catalog/view/theme/{*}/template/product/special.twig'
			];
		} else {
			$files = [
				'admin/controller/sale/order.php',
				'catalog/controller/common/header.php',
				'catalog/controller/common/footer.php',
				'catalog/controller/product/product.php',
				'catalog/controller/product/category.php',
				'catalog/controller/product/manufacturer.php',
				'catalog/controller/product/search.php',
				'catalog/controller/product/special.php',
				'catalog/controller/checkout/cart.php',
				'catalog/controller/account/wishlist.php',
				'catalog/controller/information/contact.php',
				'catalog/model/checkout/order.php',
				'catalog/model/account/customer.php',
				'admin/view/template/sale/order_info.tpl',
				'catalog/view/theme/{*}/template/common/header.tpl',
				'catalog/view/theme/{*}/template/common/footer.tpl',
				'catalog/view/theme/{*}/template/product/product.tpl',
				'catalog/view/theme/{*}/template/product/category.tpl',
				'catalog/view/theme/{*}/template/product/manufacturer_info.tpl',
				'catalog/view/theme/{*}/template/product/search.tpl',
				'catalog/view/theme/{*}/template/product/special.tpl'
			];
		}
		
		
		if ($this->config->get('config_theme') == 'theme_default') {
			$theme = $this->config->get('theme_default_directory');
		} else {
			$theme = $this->config->get('config_theme');
		}
		
		foreach ($files as $file) {
			$file = str_replace('{*}', $theme, $file);
			$filename = DIR_MODIFICATION . $file;
			
			if (file_exists($filename) && strpos(file_get_contents($filename), '// remarketing')) {
				$check .= $file . ' - ' . '<i class="fa fa-check" style="color:green"></i><br>';
			} else {
				$check .= $file . ' - ' . '<i class="fa fa-times" style="color:red"></i><br>';
			}
		}
	
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "remarketing_orders` (
		`order_id` int(11) NOT NULL,
		`ecommerce` datetime NOT NULL,
		`ecommerce_ga4` datetime NOT NULL,
		`facebook` datetime NOT NULL,
		`esputnik` datetime NOT NULL,
		`telegram` datetime NOT NULL,
		`success_page` datetime NOT NULL,
		`order_data` longtext NOT NULL,
		`date_added` datetime NOT NULL,
		PRIMARY KEY (`order_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		
		$query = $this->db->query("DESC `" . DB_PREFIX . "remarketing_orders`");
		
		$fields = [];
		
		foreach($query->rows as $row) {
			$fields[] = $row['Field'];
		}
		
		if (!in_array("facebook_lead", $fields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "remarketing_orders` ADD `facebook_lead` datetime NOT NULL AFTER `telegram`");	
		}	
		if (!in_array("tiktok", $fields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "remarketing_orders` ADD `tiktok` datetime NOT NULL AFTER `telegram`");	 
		}	
		
		$parameters = [ 
			'uuid', 'ga4_uuid', 'fbclid', 'fbc', 'fbp', 'gclid', 'dclid', 'utm_source', 'utm_campaign', 'utm_medium', 'utm_term', 'utm_content', 'ttclid', 'fb_event_id', 'fb_lead_event_id', 'tt_event_id' 
		];
		
		$fields_query = $this->db->query("DESC `" . DB_PREFIX . "remarketing_orders`");
		$fields = [];
		
		foreach ($fields_query->rows as $row) {
			$fields[] = $row['Field'];
		}
		
		foreach ($parameters as $parameter) {
			if (!in_array($parameter, $fields)) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "remarketing_orders` ADD `" . $parameter . "` VARCHAR(255) NOT NULL AFTER `date_added`");	
			}
		}
		
		if ($this->config->get('remarketing_autoclear_mode')) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "remarketing_orders` WHERE `date_added` < DATE_SUB(NOW(), INTERVAL 3 MONTH)");	
		}
		
		return $check;
	}
	
	protected function checkConfig() {
		// DISABLED
		return ''; 
	}
	
	public function checkVersion() {
		// DISABLED
		return '';
	}
}