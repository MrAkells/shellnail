<?php
class ControllerExtensionShippingUkrposhta extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/shipping/ukrposhta');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('ukrposhta', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['text_none'] = $this->language->get('text_none');
                $data['entry_price'] = $this->language->get('entry_price');
		$data['entry_status'] = $this->language->get('entry_status');
                $data['min_free_total'] = $this->language->get('min_free_total');
                
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
			'href' => $this->url->link('extension/shipping/ukrposhta', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/shipping/ukrposhta', 'token=' . $this->session->data['token'], true);
		
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true);

		if (isset($this->request->post['ukrposhta_status'])) {
			$data['ukrposhta_status'] = $this->request->post['ukrposhta_status'];
		} else {
			$data['ukrposhta_status'] = $this->config->get('ukrposhta_status');
		}

                if (isset($this->request->post['ukrposhta_price'])) {
			$data['ukrposhta_price'] = $this->request->post['ukrposhta_price'];
		} else {
			$data['ukrposhta_price'] = $this->config->get('ukrposhta_price');
		}
                
                if (isset($this->request->post['ukrposhta_freetotal'])) {
			$data['ukrposhta_freetotal'] = $this->request->post['ukrposhta_freetotal'];
		} else {
			$data['ukrposhta_freetotal'] = $this->config->get('ukrposhta_freetotal');
		}
                
		if (isset($this->request->post['ukrposhta_sort_order'])) {
			$data['ukrposhta_sort_order'] = $this->request->post['ukrposhta_sort_order'];
		} else {
			$data['ukrposhta_sort_order'] = $this->config->get('ukrposhta_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/ukrposhta', $data));
	}
        
      

        protected function validate() {
            if (!$this->user->hasPermission('modify', 'extension/shipping/ukrposhta')) {
                    $this->error['warning'] = $this->language->get('error_permission');
            }
            return !$this->error;
	}
}