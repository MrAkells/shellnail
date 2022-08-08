<?php
class ControllerExtensionShippingCourierNP extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/shipping/couriernp');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('couriernp', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['min_free_total'] = $this->language->get('min_free_total');
		$data['add_cost_total'] = $this->language->get('add_cost_total');

		$data['text_none'] = $this->language->get('text_none');

		$data['entry_status'] = $this->language->get('entry_status');
                
                
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		
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
			'href' => $this->url->link('extension/shipping/couriernp', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/shipping/couriernp', 'token=' . $this->session->data['token'], true);
		
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true);

		if (isset($this->request->post['couriernp_status'])) {
			$data['couriernp_status'] = $this->request->post['couriernp_status'];
		} else {
			$data['couriernp_status'] = $this->config->get('couriernp_status');
		}

        if (isset($this->request->post['couriernp_freetotal'])) {
			$data['couriernp_freetotal'] = $this->request->post['couriernp_freetotal'];
		} else {
			$data['couriernp_freetotal'] = $this->config->get('couriernp_freetotal');
		}
                
		if (isset($this->request->post['couriernp_sort_order'])) {
			$data['couriernp_sort_order'] = $this->request->post['couriernp_sort_order'];
		} else {
			$data['couriernp_sort_order'] = $this->config->get('couriernp_sort_order');
		}

		if (isset($this->request->post['couriernp_add_cost'])) {
			$data['couriernp_add_cost'] = $this->request->post['couriernp_add_cost'];
		} else {
			$data['couriernp_add_cost'] = $this->config->get('couriernp_add_cost');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/couriernp', $data));
	}
        
      

        protected function validate() {
            if (!$this->user->hasPermission('modify', 'extension/shipping/couriernp')) {
                    $this->error['warning'] = $this->language->get('error_permission');
            }
            return !$this->error;
	}
}