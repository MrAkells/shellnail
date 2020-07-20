<?php
class ModelExtensionShippingInter extends Model 
{
	function getQuote($address) {
		$this->load->language('extension/shipping/inter');
                
                $cost=0;

                $text_cost='';
                
                $add_markup=$this->load->controller('checkout/inter');
                
                $quote_data = array();

                $quote_data['inter'] = array(
                        'code'         => 'inter.inter',
                        'title'        => $this->language->get('text_description'),
                    
                        'addon'=> $add_markup,
                    
                        'cost'         => $cost,
                        'tax_class_id' => '',
                        'text'         => $text_cost
                );

                $method_data = array(
                        'code'       => 'inter',
                        'title'      => $this->language->get('text_title'),
                        'quote'      => $quote_data,
                        'sort_order' => $this->config->get('inter_sort_order'),
                        'error'      => false
                );
		

		return $method_data;
	}
        
}