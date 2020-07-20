<?php
class ModelExtensionPaymentCustomLiqpay extends Model {
	public function getMethod($address, $total) {
		$this->load->language('extension/payment/custom_liqpay');

	  $status=true;

             if(isset($this->session->data['shipping_method']['code']) && $this->session->data['shipping_method']['code']!='inter.inter'){
                    $status=false;
                }
		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'custom_liqpay',
				'title'      => $this->language->get('text_title'),
				'terms'      => $this->language->get('text_terms'),
				'sort_order' => $this->config->get('custom_liqpay_sort_order')
			);
		}

		return $method_data;
	}
}
