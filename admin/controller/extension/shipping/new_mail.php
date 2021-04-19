<?php
class ControllerExtensionShippingNewMail extends Controller {
	private $error = array();
        
        public function install(){     
           
            $this->load->model('extension/shipping/new_mail');       
           
            $this->model_extension_shipping_new_mail->createTable();
            
            
        }
        
        public function uninstall(){
            
            $this->load->model('extension/shipping/new_mail');                
            $this->model_extension_shipping_new_mail->deleteTable();
            
        }

	public function index() {
		$this->load->language('extension/shipping/new_mail');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('new_mail', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_key']      = $this->language->get('entry_key');
		$data['entry_update']   = $this->language->get('entry_update');
		$data['entry_backup']   = $this->language->get('entry_backup');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
                $data['min_free_total'] = $this->language->get('min_free_total');
                
                $data['entry_percent'] = $this->language->get('entry_percent');
                $data['entry_fee'] = $this->language->get('entry_fee');
                
                $data['entry_total_status'] = $this->language->get('entry_total_status');
                
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['help_key'] = $this->language->get('help_key');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
                
                
                

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/shipping/new_mail', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/shipping/new_mail', 'token=' . $this->session->data['token'], true);
		$data['action_base'] = $this->url->link('extension/shipping/new_mail/update_base', 'token=' . $this->session->data['token'], 'SSL');
		$data['action_backup'] = $this->url->link('extension/shipping/new_mail/create_backup', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true);

		if (isset($this->request->post['new_mail_key'])) {
			$data['new_mail_key'] = $this->request->post['new_mail_key'];
		} else {
			$data['new_mail_key'] = $this->config->get('new_mail_key');
		}

		if (isset($this->request->post['new_mail_geo_zone_id'])) {
			$data['new_mail_geo_zone_id'] = $this->request->post['new_mail_geo_zone_id'];
		} else {
			$data['new_mail_geo_zone_id'] = $this->config->get('new_mail_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['new_mail_status'])) {
			$data['new_mail_status'] = $this->request->post['new_mail_status'];
		} else {
			$data['new_mail_status'] = $this->config->get('new_mail_status');
		}
                
                
                if (isset($this->request->post['new_mail_total_status'])) {
			$data['new_mail_total_status'] = $this->request->post['new_mail_total_status'];
		} else {
			$data['new_mail_total_status'] = $this->config->get('new_mail_total_status');
		}

		if (isset($this->request->post['new_mail_sort_order'])) {
			$data['new_mail_sort_order'] = $this->request->post['new_mail_sort_order'];
		} else {
			$data['new_mail_sort_order'] = $this->config->get('new_mail_sort_order');
		}

        if (isset($this->request->post['new_mail_freetotal'])) {
			$data['new_mail_freetotal'] = $this->request->post['new_mail_freetotal'];
		} else {
			$data['new_mail_freetotal'] = $this->config->get('new_mail_freetotal');
		}

		if (isset($this->request->post['new_mail_min_cost'])) {
			$data['new_mail_min_cost'] = $this->request->post['new_mail_min_cost'];
		} else {
			$data['new_mail_min_cost'] = $this->config->get('new_mail_min_cost');
		}                
                if (isset($this->request->post['new_mail_nalozhniy_percent'])) {
			$data['new_mail_nalozhniy_percent'] = $this->request->post['new_mail_nalozhniy_percent'];
		} else {
			$data['new_mail_nalozhniy_percent'] = $this->config->get('new_mail_nalozhniy_percent');
		}

		if (isset($this->request->post['new_mail_nalozhniy_fee'])) {
			$data['new_mail_nalozhniy_fee'] = $this->request->post['new_mail_nalozhniy_fee'];
		} else {
			$data['new_mail_nalozhniy_fee'] = $this->config->get('new_mail_nalozhniy_fee');
		}
                
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/new_mail', $data));
	}
        
        public function update_base()
        {            
            if($this->request->server['REQUEST_METHOD'] == 'POST')
            {
                $json = file_get_contents("php://input");
                $object = (array)json_decode($json);
                
                if(!isset($object['key']) && !preg_match('/^[a-zA-Z0-9]{2,}$/', $object['key'])){ die('error_key');}
                
                $this->load->model('extension/shipping/new_mail');      
                $Model = $this->model_extension_shipping_new_mail;
                
                $Model->setKey($object['key']);
                $Model->update_base();
            }            
        }
        
        public function create_backup(){
            $json = file_get_contents("php://input");
            $object = (array)json_decode($json);

            if(!isset($object['key']) && !preg_match('/^[a-zA-Z0-9]{2,}$/', $object['key'])){ die('error_key');}

            $this->load->model('extension/shipping/new_mail');      
            $Model = $this->model_extension_shipping_new_mail;

            $Model->setKey($object['key']);
            $Model->create_backup();
        }

        protected function validate() {
            if (!$this->user->hasPermission('modify', 'extension/shipping/new_mail')) {
                    $this->error['warning'] = $this->language->get('error_permission');
            }
            return !$this->error;
	}
}