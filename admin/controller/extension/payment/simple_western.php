<?php
class ControllerExtensionPaymentSimpleWestern extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/payment/simple_western');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('simple_western', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
$data['entry_order_status'] = $this->language->get('entry_order_status');
		
		$data['help_total'] = $this->language->get('help_total');

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
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/simple_western', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/payment/simple_western', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);

		if (isset($this->request->post['simple_western_status'])) {
			$data['simple_western_status'] = $this->request->post['simple_western_status'];
		} else {
			$data['simple_western_status'] = $this->config->get('simple_western_status');
		}

                if (isset($this->request->post['simple_western_order_status_id'])) {
			$data['simple_western_order_status_id'] = $this->request->post['simple_western_order_status_id'];
		} else {
			$data['simple_western_order_status_id'] = $this->config->get('simple_western_order_status_id');
		}
                
                $this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

                
		if (isset($this->request->post['simple_western_sort_order'])) {
			$data['simple_western_sort_order'] = $this->request->post['simple_western_sort_order'];
		} else {
			$data['simple_western_sort_order'] = $this->config->get('simple_western_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/simple_western', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/simple_western')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}