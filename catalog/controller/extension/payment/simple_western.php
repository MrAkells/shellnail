<?php
class ControllerExtensionPaymentSimpleWestern extends Controller {
	public function index() {
           
		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['text_loading'] = $this->language->get('text_loading');

		$data['continue'] = $this->url->link('checkout/success');

		return $this->load->view('extension/payment/simple_western', $data);
	}

	public function confirm() {
                if(!isset($this->session->data['order_id']) || !isset($this->session->data['payment_method']['code']) ){
                    $order_error_log =  new Log('order_trap.log');
                    $order_error_log->write('Western');
                    $order_error_log->write(print_r($this->session->data, TRUE));
                }
		if ($this->session->data['payment_method']['code'] == 'simple_western') {
			$this->load->model('checkout/order');

			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('simple_western_order_status_id'));
                }
	}
}
