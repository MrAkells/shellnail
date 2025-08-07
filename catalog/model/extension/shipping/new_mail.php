<?php
class ModelExtensionShippingNewMail extends Model 
{
    function getQuote($address) {
        $this->load->language('extension/shipping/new_mail');
                
        $cost=0;
        $text_cost='';
               
        $weight=$this->cart->getWeight();
               
        if($weight &&  $this->config->get('new_mail_key') && isset($this->session->data['payment_address']['city'])){
                   
            $results= $this->checkCity($this->session->data['payment_address']['city']);
            $recipient=false;
            if (count($results) === 1 && isset($results[0]['city_ref'])) {
                $recipient = $results[0]['city_ref'];
            }
            if($recipient){
                $cost=$this->cost($recipient, $weight, 'db5c8927-391c-11dd-90d9-001a92567626');
            }
                        
            if(!$cost) $cost = $this->config->get('new_mail_min_cost');
        }
                    
        if($this->cart->getSubTotal()>=$this->config->get('new_mail_freetotal')){
            $cost=0;  
        }
                
        $add_markup=$this->load->controller('checkout/new_mail');
                
        $quote_data = array();

        $quote_data['new_mail'] = array(
            'code'         => 'new_mail.new_mail',
            'title'        => $this->language->get('text_description'),
            'addon'        => $add_markup,
            'cost'         => $cost,
            'tax_class_id' => '',
            'text'         => $text_cost
        );

        $method_data = array(
            'code'       => 'new_mail',
            'title'      => $this->language->get('text_title'),
            'quote'      => $quote_data,
            'sort_order' => $this->config->get('new_mail_sort_order'),
            'error'      => false
        );
        
        return $method_data;
    }
        
    public function getAreas() {
        $data_areas = $this->db->query("SELECT ar.area_id, ar.description, z.name as description_ru, ar.ref, z.zone_id, z.country_id FROM " . DB_PREFIX . "newmail_area ar LEFT JOIN oc_zone z ON(ar.code = z.code) LEFT JOIN oc_country c ON(z.country_id = c.country_id) WHERE c.iso_code_2 = 'UA'");
        if(isset($data_areas->rows) && !empty($data_areas->rows)){
            return $data_areas->rows;
        }
        return array();
    }
        
    public function getCountry() {
        $data_country = $this->db->query("SELECT * FROM " . DB_PREFIX . "country c WHERE c.iso_code_2 = 'UA'");
        if(isset($data_country->row) && !empty($data_country->row)){
            return $data_country->row;
        }
        return array();
    }
        
    public function getCities($ref) {
        $data_city = $this->db->query("SELECT ref, description, description_ru FROM " . DB_PREFIX . "newmail_city WHERE areas = '" . $ref . "'");
        if(isset($data_city->rows) && !empty($data_city->rows)){
            return $data_city->rows;
        }
        return array();
    }
        
    public function getOffices($ref) {
        // Получаем данные офисов из базы данных
        $data_city = $this->db->query("SELECT * FROM " . DB_PREFIX . "newmail_office WHERE city_ref = '" . $ref . "'");

        if (isset($data_city->rows) && !empty($data_city->rows)) {
            // Сортируем офисы сначала по типу, затем по номеру
            usort($data_city->rows, function($a, $b) {
                // Устанавливаем порядок типов
                $typeOrder = ['Отделение' => 1, 'Почтомат' => 2, 'Пункт' => 3];
                
                // Определяем типы офисов
                preg_match('/^(Отделение|Почтомат|Пункт)/u', $a['description'], $matchesA);
                preg_match('/^(Отделение|Почтомат|Пункт)/u', $b['description'], $matchesB);
                
                $typeA = isset($matchesA[1]) ? $matchesA[1] : '';
                $typeB = isset($matchesB[1]) ? $matchesB[1] : '';

                // Сравниваем по типу
                if ($typeOrder[$typeA] !== $typeOrder[$typeB]) {
                    return $typeOrder[$typeA] <=> $typeOrder[$typeB];
                }

                // Извлекаем числа из описания офиса
                preg_match('/\d+/', $a['description'], $matchesNumA);
                preg_match('/\d+/', $b['description'], $matchesNumB);

                $numA = isset($matchesNumA[0]) ? (int)$matchesNumA[0] : 0;
                $numB = isset($matchesNumB[0]) ? (int)$matchesNumB[0] : 0;

                // Сравниваем числовые значения
                return $numA <=> $numB;
            });

            return $data_city->rows;
        }
        
        return array();
    }
        
    public function getCityByHint($piece, $limit = 10) {
        $query = $this->db->query("SELECT city_id AS id, ref AS city_ref, areas, description AS name_ua, description_ru AS name_ru, settlement_type_description_ru AS type_ru, settlement_type_description AS type_ua FROM " . DB_PREFIX . "newmail_city WHERE description LIKE '" . $this->db->escape($piece) . "%' OR description_ru LIKE '" . $this->db->escape($piece) . "%' LIMIT " . (int)$limit);
        return $query->rows;
    }
        
    public function checkCity($piece, $limit = 10) {
        $query = $this->db->query("SELECT city_id AS id, ref AS city_ref, areas, description AS name_ua, description_ru AS name_ru, settlement_type_description_ru AS type_ru, settlement_type_description AS type_ua FROM " . DB_PREFIX . "newmail_city WHERE description ='" . $this->db->escape($piece) . "' OR description_ru='" . $this->db->escape($piece) . "' LIMIT " . (int)$limit);
        return $query->rows;
    }
        
    public function getDefaultCities($refs=array('8d5a980d-391c-11dd-90d9-001a92567626','db5c88f0-391c-11dd-90d9-001a92567626','db5c88e0-391c-11dd-90d9-001a92567626','db5c88d0-391c-11dd-90d9-001a92567626','db5c88f5-391c-11dd-90d9-001a92567626')) {
        $piece = implode("','", $refs);
        $data_cities = $this->db->query("SELECT ref, description, description_ru FROM " . DB_PREFIX . "newmail_city WHERE ref IN ('" . $piece . "')");
        if (isset($data_cities->rows) && !empty($data_cities->rows)) {
            return $data_cities->rows;
        }
        return array();
    }
        
    private function cost($recipient, $weight, $sender) {
        $request=array(
            "modelName"=>"InternetDocument",
            "calledMethod"=>"getDocumentPrice",
            "methodProperties"=>[
            "CitySender"=> $sender,
            "CityRecipient"=> $recipient,
            "ServiceType"=>"WarehouseWarehouse",
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
            return (isset($novaposhta_obj->data[0]) ? $novaposhta_obj->data[0]->Cost : 0);
        }
    }
}
