<?php
class ModelExtensionShippingUkrposhta extends Model 
{
	function getQuote($address) {
		$this->load->language('extension/shipping/ukrposhta');
                
                $cost=$this->config->get('ukrposhta_price');

                if($this->cart->getSubTotal()>=$this->config->get('ukrposhta_freetotal')){
                    $cost=0;  
                }
                
                $text_cost='';
                
                $add_markup=$this->load->controller('checkout/ukrposhta');
                
                $quote_data = array();

                $quote_data['ukrposhta'] = array(
                        'code'         => 'ukrposhta.ukrposhta',
                        'title'        => sprintf($this->language->get('text_description'), $cost),
                    
                        'addon'=> $add_markup,
                    
                        'cost'         => $cost,
                        'tax_class_id' => '',
                        'text'         => $text_cost
                );

                $method_data = array(
                        'code'       => 'ukrposhta',
                        'title'      => $this->language->get('text_title'),
                        'quote'      => $quote_data,
                        'sort_order' => $this->config->get('ukrposhta_sort_order'),
                        'error'      => false
                );
		

		return $method_data;
	}
        
}