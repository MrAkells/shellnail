<?php
class ControllerExtensionModuleTwobanners extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/twobanners');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('twobanners', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
                
                $data['entry_width'] = $this->language->get('entry_width');
                $data['entry_height'] = $this->language->get('entry_height');

		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
                
                $data['entry_catalog_banner'] = $this->language->get('entry_catalog_banner');
                $data['entry_brands_banner'] = $this->language->get('entry_brands_banner');

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
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/twobanners', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/twobanners', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		if (isset($this->request->post['twobanners_status'])) {
			$data['twobanners_status'] = $this->request->post['twobanners_status'];
		} else {
			$data['twobanners_status'] = $this->config->get('twobanners_status');
		}
                
                if (isset($this->request->post['twobanners_first_width'])) {
			$data['twobanners_first_width'] = $this->request->post['twobanners_first_width'];
		} else if($this->config->get('twobanners_first_width')){
			$data['twobanners_first_width'] = $this->config->get('twobanners_first_width');
                } else{
                        $data['twobanners_first_width']=200;  
                }
                
                if (isset($this->request->post['twobanners_first_height'])) {
			$data['twobanners_first_height'] = $this->request->post['twobanners_first_height'];
		} else if($this->config->get('twobanners_first_height')){
			$data['twobanners_first_height'] = $this->config->get('twobanners_first_height');
                }else{
                    $data['twobanners_first_height']=100;
                }
                
                if (isset($this->request->post['twobanners_second_width'])) {
			$data['twobanners_second_width'] = $this->request->post['twobanners_second_width'];
		} else if($this->config->get('twobanners_second_width')){
			$data['twobanners_second_width'] = $this->config->get('twobanners_second_width');
                } else{
                    $data['twobanners_second_width']=200;
                }
                
                if (isset($this->request->post['twobanners_second_height'])) {
			$data['twobanners_second_height'] = $this->request->post['twobanners_second_height'];
		} else if($this->config->get('twobanners_second_height')){
			$data['twobanners_second_height'] = $this->config->get('twobanners_second_height');
                }else{
                    $data['twobanners_second_height'] = 100;
                }

                $this->load->model('design/banner');
                $data['all_banners'] = $this->model_design_banner->getBanners();
                
                $data['twobanners_first_banner_id']=$this->config->get('twobanners_first_banner_id');
                $data['twobanners_second_banner_id']=$this->config->get('twobanners_second_banner_id');
                
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/twobanners', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/twobanners')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}