<?php
class ModelExtensionShippingCouriernp extends Model 
{
	function getQuote($address) {
		$this->load->language('extension/shipping/couriernp');
                
                $cost=0;
                $text_cost='';

                $weight=$this->cart->getWeight();
               
                if($weight && $this->config->get('new_mail_key') && isset($this->session->data['payment_address']['city'])){
                   
                        $results= $this->checkCity($this->session->data['payment_address']['city']);
                        $recipient=false;
                        if(count($results)==1){
                            $recipient=$results[0]['city_ref'];
                        }
                        if($recipient){
                            $cost=$this->cost($recipient, $weight, 'db5c8927-391c-11dd-90d9-001a92567626');
                            // $text_cost=$this->currency->format($cost, $this->session->data['currency']);
                        }
                        
                         if(!$cost){
                                $cost=$this->config->get('new_mail_min_cost') + $this->config->get('couriernp_add_cost');
                            }
                        
                    }
                    
                    if($this->cart->getSubTotal()>=$this->config->get('couriernp_freetotal')){
                        $cost = $this->config->get('couriernp_add_cost');  
                    }
                    
                    
                $add_markup=$this->load->controller('checkout/couriernp');
                
                $quote_data = array();

                $quote_data['couriernp'] = array(
                        'code'         => 'couriernp.couriernp',
                        'title'        => $this->language->get('text_description'),
                    
                        'addon'=> $add_markup,
                    
                        'cost'         => $cost,
                        'tax_class_id' => '',
                        'text'         => $text_cost
                );

                $method_data = array(
                        'code'       => 'couriernp',
                        'title'      => $this->language->get('text_title'),
                        'quote'      => $quote_data,
                        'sort_order' => $this->config->get('couriernp_sort_order'),
                        'error'      => false
                );
		

		return $method_data;
	}
        
        public function checkCity($piece, $limit = 10){
            $query = $this->db->query("SELECT city_id AS id, ref AS city_ref, areas, description AS name_ua, description_ru AS name_ru, settlement_type_description_ru AS type_ru, settlement_type_description AS type_ua FROM " . DB_PREFIX . "newmail_city WHERE description ='" . $piece . "' OR description_ru='" . $piece . "' LIMIT " . (int)$limit);
            return $query->rows;
        }
        
        private function cost($recipient, $weight, $sender){
            $request=array(
                "modelName"=>"InternetDocument",
                "calledMethod"=>"getDocumentPrice",
                "methodProperties"=>[
                "CitySender"=> $sender,
                "CityRecipient"=> $recipient,
                "ServiceType"=>"WarehouseDoors",
                "Weight"=> $weight],
                "apiKey"=> $this->config->get('new_mail_key')
            );
        
        
            $data= json_encode($request);
        
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.novaposhta.ua/v2.0/json/",
                CURLOPT_RETURNTRANSFER => True,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_TIMEOUT_MS=>1000,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array("content-type: application/json",),
            ));
        
            $response = curl_exec($curl);
            $err = curl_error($curl);
        
            curl_close($curl);
            if ($err) {
                return "cURL Error #:" . $err;
            } else {
                $novaposhta_obj= json_decode($response);
                return (isset($novaposhta_obj->data[0]) ? $novaposhta_obj->data[0]->Cost: 0);
                // return 0;
            }
        }
        
}
