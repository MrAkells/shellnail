<?php
class ModelExtensionPaymentSimpleWestern extends Model {
	public function getMethod($address, $total) {
		$this->load->language('extension/payment/simple_western');

		$method_data = array();

               //couriernp.couriernp
                
                $status=true;
                if(isset($this->session->data['shipping_method']['code']) && $this->session->data['shipping_method']['code']!='inter.inter'){
                    $status=false;
                }
                
		if ($status) {
			$method_data = array(
				'code'       => 'simple_western',
				'title'      => $this->language->get('text_title'),
				'terms'      => $this->language->get('text_terms'),
				'sort_order' => $this->config->get('simple_western_sort_order')
			);
                }

		return $method_data;
	}
}
