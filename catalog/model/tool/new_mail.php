<?php

include_once DIR_APPLICATION."model/tool/nova-poshta-sdk-php/lib/NovaPoshta/bootstrap.php";
use NovaPoshta\Config;
use NovaPoshta\ApiModels\Address;
use NovaPoshta\MethodParameters\Address_getWarehouses;
use NovaPoshta\MethodParameters\Address_getCities;
use NovaPoshta\MethodParameters\Address_getAreas;


class ModelToolNewMail extends Model 
{
    
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
                if($office->DescriptionRu == '') $office->DescriptionRu = $office->Description;
                if($office->ShortAddressRu == '') $office->ShortAddressRu = $office->ShortAddress;
                if($office->CityDescriptionRu == '') $office->CityDescriptionRu = $office->CityDescription;
                $this->db->query(
                    "INSERT INTO " . DB_PREFIX . "newmail_office SET site_key = '" . (int)$office->SiteKey . "', number = '" . (int)$this->Number . "',"
                    . " ref = '" . $this->db->escape($office->Ref) . "', city_ref = '" . $this->db->escape($office->CityRef) . "',"
                    . " city_description = '" . $this->db->escape($office->CityDescription) . "', city_description_ru = '" . $this->db->escape($office->CityDescriptionRu) . "',"
                    . " description = '" . $this->db->escape($office->Description) . "', description_ru = '" . $this->db->escape($office->DescriptionRu) . "',"
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