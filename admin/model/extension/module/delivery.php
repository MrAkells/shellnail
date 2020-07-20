<?php
class ModelExtensionModuleDelivery extends Model {
    
    public function createTable (){
         $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "delivery ( email varchar(100) NOT NULL PRIMARY KEY, name varchar(100) NOT NULL, phone varchar(100) NOT NULL ) ENGINE=MyISAM DEFAULT CHARSET=utf8");       
    }
    
    public function deleteTable (){
         $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "delivery");       
    }
    
    public function getEmails($settings){
        foreach ($settings as $key => $val){
            $emails[$key] = $val;
        }
        return $emails;
    }
    
    public function getGroups($settings){
        $emails=array();
        foreach ($settings as $val){
            $query = $this->db->query("SELECT firstname,  email FROM " . DB_PREFIX . "customer WHERE customer_group_id ='". $val ."' AND newsletter = 1");
            foreach($query->rows as $value){
                $emails[$value['firstname']] = $value['email'];
            }
        }
        return $emails;
    }
    
    public function getEmailsTotal(){
        $query = $this->db->query("SELECT email FROM " . DB_PREFIX . "delivery"); 
        foreach ($query->rows as $val){
            $emails[] = $val;
        }
        return $emails;
    }
    
    public function getSubscribers(){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "delivery");
        foreach ($query->rows as $value){
            $result[] = $value;
        }
        if(!empty($result)){
            return $result;
        }
    }
    
    public function getGroupsId(){
      $query = $this->db->query("SELECT customer_group_id FROM " . DB_PREFIX . "customer_group");      
      foreach ($query->rows as $value){
            $result[] = $value;
       }
       return $result;
    }
    
    public function getLanguageId($code){
        $query = $this->db->query("SELECT language_id FROM " . DB_PREFIX . "language WHERE code = '" . $code . "'");
        return $query->row;
    }
}
