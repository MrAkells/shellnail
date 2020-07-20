<?php

include_once "model/extension/shipping/nova-poshta-sdk-php/lib/NovaPoshta/bootstrap.php";
use NovaPoshta\Config;
use NovaPoshta\ApiModels\Address;
use NovaPoshta\MethodParameters\Address_getWarehouses;
use NovaPoshta\MethodParameters\Address_getCities;
use NovaPoshta\MethodParameters\Address_getAreas;


class ModelExtensionShippingNewMail extends Model 
{
    /**
     * Call method createTable() - for create tables in database during install module
     */    
    public function createTable ()
    {
      
         /*$this->db->query(
                 "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "newmail_area ("
                        ." area_id INT(11) NOT NULL AUTO_INCREMENT,"
                        ." ref VARCHAR(255) NOT NULL,"
                        ." areas_center VARCHAR(255) NOT NULL,"
                        ." description VARCHAR(255) NOT NULL,"
                        ." date_added DATETIME,"
                        ." area_status TINYINT,"
                        ." sort INT(11), code VARCHAR(50) NOT NULL, PRIMARY KEY (area_id)"
                    .") COLLATE='utf8_general_ci' ENGINE=MyISAM"
                );   */
         
         $this->db->query(	
                "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "newmail_city ("
                        ." city_id INT(11) NOT NULL AUTO_INCREMENT, "
                        ." ref VARCHAR(255) NOT NULL, "
                        ." areas VARCHAR(255) NOT NULL, "
                        ." settlement_type VARCHAR(255) NOT NULL, "
                        ." mail_city_id INT (11) NOT NULL, "
                        ." description VARCHAR(255) NOT NULL, "
                        ." description_ru VARCHAR(255) NOT NULL, "
                        ." settlement_type_description VARCHAR(255) NOT NULL, "
                        ." settlement_type_description_ru VARCHAR(255) NOT NULL, "
                        ." date_added DATETIME, "
                        ." city_status TINYINT NOT NULL, "
                        ." sort INT(11) NOT NULL, PRIMARY KEY (city_id)"
                    .") COLLATE='utf8_general_ci' ENGINE=MyISAM"
                );        
         
        $this->db->query(
                "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "newmail_office ("
                        ." office_id int(11) NOT NULL AUTO_INCREMENT, site_key int(11) NOT NULL,"
                        ." number int (11) NOT NULL, ref varchar(255) NOT NULL,"
                        ." city_ref varchar(255) NOT NULL, city_description varchar(255) NOT NULL,"
                        ." city_description_ru varchar(255) NOT NULL, description varchar(255) NOT NULL,"
                        ." description_ru varchar(255) NOT NULL, short_address varchar(255) NOT NULL,"
                        ." short_address_ru varchar(255) NOT NULL, phone varchar(100) NOT NULL,"
                        ." typeof_warehouse varchar(255) NOT NULL, longitude varchar(255) NOT NULL,"
                        ." latitude varchar(255) NOT NULL, post_finance tinyint NOT NULL,"
                        ." bicycle_parking tinyint NOT NULL, payment_access tinyint NOT NULL,"
                        ." posterminal tinyint NOT NULL, international_shipping tinyint NOT NULL,"
                        ." total_max_weight_allowed int(11) NOT NULL,"
                        ." place_max_weight_allowed int(11) NOT NULL, reception text NOT NULL,"
                        ." delivery text NOT NULL, schedule text NOT NULL,"
                        ." date_added datetime, office_status tinyint NOT NULL, sort int(11) NOT NULL,"
                        ." PRIMARY KEY (office_id)"
                    .") COLLATE='utf8_general_ci' ENGINE=MyISAM"
                );  
        
        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "newmail_area_dump LIKE " . DB_PREFIX . "newmail_area");
        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "newmail_city_dump LIKE " . DB_PREFIX . "newmail_city");
        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "newmail_office_dump LIKE " . DB_PREFIX . "newmail_office");
    }
    
    private function updateAreas($data)
    {
        if(!empty($data))
        {
            $notice = array();
            foreach ($data as $area){
                $data_id = $this->db->query("SELECT area_id FROM " . DB_PREFIX . "newmail_area WHERE description = '" . strip_tags($area->Description) . "'");
                if(isset($data_id->row) && !empty($data_id->row)){
                    $area_id = $data_id->row['area_id'];
                    $this->db->query(
                        "UPDATE " . DB_PREFIX . "newmail_area SET ref = '" . $this->db->escape($area->Ref) . "', date_added = NOW() WHERE area_id = " . (int)$area_id );
                } else { $notice[$area->Description] = 'not_find'; }
            }
            if(!empty($notice)){
                return array('notice' => $notice);
            }
            return true;
        }
        return false;
    }
    
    private function updateCities($data)
    {
        if(!empty($data))
        {
            $this->db->query("TRUNCATE " . DB_PREFIX . "newmail_city");
            
            foreach ($data as $city){
                 $this->db->query(
                    "INSERT INTO " . DB_PREFIX . "newmail_city SET ref = '" . $this->db->escape($city->Ref) . "', areas = '" . $this->db->escape($city->Area) . "',"
                    . " settlement_type = '" . $this->db->escape($city->SettlementType) . "', mail_city_id = '" . (int)$city->CityID . "',"
                    . " description = '" . $this->db->escape($city->Description) . "', description_ru = '" . $this->db->escape($city->DescriptionRu) . "',"
                    . " settlement_type_description = '" . $this->db->escape($city->SettlementTypeDescription) . "', settlement_type_description_ru = '" . $this->db->escape($city->SettlementTypeDescriptionRu) . "',"
                    . " date_added = NOW(), city_status = 0, sort = 0 "
                );
            }
            return true;
        }
        return false;
       
    }
    
    private function updateWarehouses($data)
    {
        
        if(!empty($data))
        {
            $this->db->query("TRUNCATE " . DB_PREFIX . "newmail_office");
            
            foreach ($data as $office){
                $this->db->query(
                    "INSERT INTO " . DB_PREFIX . "newmail_office SET site_key = '" . (int)$office->SiteKey . "', number = '" . (int)$this->Number . "',"
                    . " ref = '" . $this->db->escape($office->Ref) . "', city_ref = '" . $this->db->escape($office->CityRef) . "',"
                    . " city_description = '" . $this->db->escape($office->CityDescriptionRu) . "', city_description_ru = '" . $this->db->escape($office->CityDescriptionRu) . "',"
                    . " description = '" . $this->db->escape($office->DescriptionRu) . "', description_ru = '" . $this->db->escape($office->DescriptionRu) . "',"
                    . " short_address = '" . $this->db->escape($office->ShortAddress) . "', short_address_ru = '" . $this->db->escape($office->ShortAddressRu) . "',"
                    . " phone = '" . $this->db->escape($office->Phone) . "', typeof_warehouse = '" . $this->db->escape($office->TypeOfWarehouse) . "',"
                    . " longitude = '" . $this->db->escape($office->Longitude) . "', latitude = '" . $this->db->escape($office->Latitude) . "',"
                    . " post_finance = '" . (int)$office->PostFinance . "', bicycle_parking = '" . (int)$office->BicycleParking . "',"
                    . " payment_access = '" . (int)$office->PaymentAccess . "', posterminal = '" . (int)$office->POSTerminal . "',"
                    . " international_shipping = '" . (int)$office->InternationalShipping . "', total_max_weight_allowed = '" . (int)$office->TotalMaxWeightAllowed . "',"
                    . " place_max_weight_allowed = '" . (int)$office->PlaceMaxWeightAllowed . "', reception = '" . serialize($office->Reception) . "',"
                    . " delivery = '" . serialize($office->Delivery) . "', schedule = '" . serialize($office->Schedule) . "',"
                    . " date_added = NOW(), office_status = 0, sort = 0 "
                );
            }
            return true;
        }
        return false;       
    }
    
    public function deleteTable (){
         $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "newmail_area");       
         $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "newmail_city");       
         $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "newmail_office");       
    }
    
    public function create_backup()
    {        
        $this->db->query("TRUNCATE " . DB_PREFIX . "newmail_area_dump");
        $this->db->query("TRUNCATE " . DB_PREFIX . "newmail_city_dump");
        $this->db->query("TRUNCATE " . DB_PREFIX . "newmail_office_dump");        
        $this->db->query("INSERT INTO " . DB_PREFIX . "newmail_area_dump    SELECT * FROM " . DB_PREFIX . "newmail_area");
        $this->db->query("INSERT INTO " . DB_PREFIX . "newmail_city_dump    SELECT * FROM " . DB_PREFIX . "newmail_city");
        $this->db->query("INSERT INTO " . DB_PREFIX . "newmail_office_dump  SELECT * FROM " . DB_PREFIX . "newmail_office");
        echo 'true';
    }
    
    
    public function setKey($key)
    {
        Config::setApiKey($key);
        Config::setFormat(Config::FORMAT_JSONRPC2);
        Config::setLanguage(Config::LANGUAGE_UA);        
    }

    /**
     * Call method update_base() - update database in module new mail     
     * @return data array objects
     */    
    public function update_base()
    {        
        $Areas      = $this->getAreas();
        $Cities     = $this->getCities();
       // $Warehouses = $this->getWarehouses();
        $Warehouses = $this->getWarehousesL(1000);
       // $Warehouses = $this->getWarehousesByCityRef($Cities);
        if($this->validate($Areas, $Cities, $Warehouses)){
            $update = array('areas' =>'', 'cities' =>'', 'warehouses' => '');
            $update['areas']        = $this->updateAreas($Areas);
            $update['cities']       = $this->updateCities($Cities);
            $update['warehouses']   = $this->updateWarehouses($Warehouses);  
            
            if (isset($update['areas']['notice']) && $update['cities'] && $update['warehouses']){
                echo $update['areas']['notice'];
            } 
            if ($update['areas'] && $update['cities'] && $update['warehouses']){
                echo true;
            } else {
                echo 'database do not update';
            }        
        } else {
            echo 'API new mail not ansver';
        }
    }
    
    private function validate($Areas, $Cities, $Warehouses){
        if(!isset($Areas[0]->Ref) && empty($Areas[0]->Ref)){
            return FALSE;
        }
        if(!isset($Cities[0]->Ref) && empty($Cities[0]->Ref)){
            return FALSE;
        }
        if(!isset($Warehouses[0]->Ref) && empty($Warehouses[0]->Ref)){
            return FALSE;
        }
        return true;
    }

        /**
     * Call method getAreas() - load catalog geografic areas Ukraine new mail     
     * @return data array objects
     */    
    private function getAreas()
    {
        $data = new Address_getAreas();
        return Address::getAreas($data)->data;
    }
        
    /**
     * Call method getCities() - load catalog cities new mail     
     * @return data array objects
     */    
    private function getCities()
    {
        $data = new Address_getCities();        
        $data->setPage(1);      
        return Address::getCities($data)->data;
    }    
    
    /**
     * Call method getWarehouses() - load catalog offices new mail     
     * @return data array objects
     */
    private function getWarehouses()
    {
        $data = new Address_getWarehouses(); 
        $data->setPage(1);
        return  Address::getWarehouses($data)->data;
    }

    /**
     * Call method getWarehousesL() - load catalog offices new mail with limit    
     * @return data array objects
     */
    private function getWarehousesL($limit)
    {
        $warehouses = [];
        $page = 1;
        $data = new Address_getWarehouses(); 
        $data->setPage($page);
        $data->setLimit($limit);
        $w = Address::getWarehouses($data)->data;

        while ($w) {
            $warehouses = array_merge($warehouses, $w);
            $data->setPage(++$page);
            $w = Address::getWarehouses($data)->data;
        }
        return  $warehouses;
    }

    /**
     * Call method getWarehouses() - load catalog offices new mail by CityRef     
     * @return data array objects
     */
    private function getWarehousesByCityRef($cites)
    {   $warehouses = [];
        $data = new Address_getWarehouses(); 
        $data->setPage(1);
        foreach ($cites as $city) {
            $data->setCityRef($city->Ref);
            $warehouses = array_merge($warehouses, Address::getWarehouses($data)->data);
        }
       return $warehouses;
    }    
}
?>