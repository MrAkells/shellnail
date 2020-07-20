<?php
class ModelExtensionPaymentPrivat extends Model {
	public function getMethod($address, $total) {
		$this->load->language('extension/payment/privat');

		
		$method_data = array();
                $status=true;
                
                if(isset($this->session->data['shipping_method']['code']) &&  $this->session->data['shipping_method']['code']=='inter.inter'){
                    $status = false;
                }
                    
                
                
                if($status){
		
			$method_data = array(
				'code'       => 'privat',
				'title'      => $this->language->get('text_title'),
				'terms'      => $this->language->get('text_terms'),
				'sort_order' => $this->config->get('privat_sort_order')
			);
                }

		return $method_data;
	}
}
