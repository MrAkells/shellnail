<?php
class ModelExtensionModuleDelivery extends Model {
    
    public function validate($email) {        
         return preg_match('/^[a-zA-Z0-9_\-\.]{2,}@[a-zA-Z0-9_\-\.]{1,}\.[a-zA-Z]{2,6}$/', $email);         
    }
    
    public function checkEmail($email){
        
        $query = $this->db->query("SELECT email FROM " . DB_PREFIX . "delivery WHERE email = '" . $email . "'");
        if($query ->num_rows){
             return $query -> row;
        }
        return [];
    }

    public function addData($data = array()){
         return $this->db->query("INSERT INTO " . DB_PREFIX . "delivery SET email = '" . $data['email'] . "', name = '" . $data['name'] . "', phone='".$data['phone']."'");
    }
    
    
    public function checkPhone($phone){
        $query=$this->db->query("SELECT * FROM " . DB_PREFIX . "delivery WHERE phone='".$phone."'");
        if($query->num_rows){
            return true;
        }else{
            return false;
        }
    }
    
}
