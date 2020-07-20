<?php
class ModelExtensionTotalAfterShipping extends Model {
	public function getTotal($total) {
                   
                    $additional_value=0;
                    if (isset($this->session->data['shipping_method']['code']) && $this->session->data['shipping_method']['code']=='new_mail.new_mail' && isset($this->session->data['payment_method']['code']) &&  $this->session->data['payment_method']['code']=='cod') {
                        $this->load->language('extension/shipping/new_mail');
                            
                        $value_fee=$this->config->get('new_mail_nalozhniy_fee');
                        $value_percent=(float)((float)($this->config->get('new_mail_nalozhniy_percent')/100)*(float)$this->cart->getSubTotal());
                         
                        $additional_value=$value_fee+$value_percent;
                            
                        $total['totals'][] = array(
                            'code'       => 'aftershipping',
                            'title'      => $this->language->get('text_nalozniy'),
                            'value'      => $additional_value,
                            'sort_order' => (int)$this->config->get('shipping_sort_order')+1
                        );
                            
                        $total['total'] += $additional_value;
                            
                    }

	}
}
