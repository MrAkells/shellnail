<?php
class ModelFeedXmlprice extends Model {
    
     public function getAliases($aggregator){
        $query=$this->db->query("SELECT category_id, alias FROM xmlprice_aliases WHERE platform='".$aggregator."'");
        $aliases=[];
        if($query->rows){
            foreach($query->rows as $row){
                $aliases[$row['category_id']]=$row['alias'];
            }
        }
        return $aliases;
    }
    
    public function editAlliases($aggregator,$data=array()) {
	$this->db->query("DELETE FROM xmlprice_aliases WHERE platform='".$aggregator."'");
	if(!$data){
            return;
        }
        $sql="INSERT INTO xmlprice_aliases (category_id, alias, platform) VALUES";
        $flag=false;
        foreach($data as $value){
            if($flag){
                $sql.=', ';
            }else{
                $flag=true;
            }
            $sql.="('".$value['category_id']."', '".$value['alias']."', '".$aggregator."')";   
        }
        $this->db->query($sql);
	}
        
    public function getCategories() {
            $sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id) LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";
            $sql .= " GROUP BY cp.category_id";
            $query = $this->db->query($sql);
            return $query->rows;
	}
    
    public function getManufacturers(){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer");
        return $query->rows;
    }
    
    public function getAggregatorManufacturers($aggregator) {
       $query=$this->db->query("SELECT * FROM aggregator_settings WHERE aggregator='".$aggregator."'");
        
        if(isset($query->row['manufacturers'])){
            return $query->row['manufacturers'];
        }else{
            return '';
        }
    }
    
    public function setAggregatorManufacturers($aggregator, $manufacturers) {
       $this->db->query("UPDATE aggregator_settings SET manufacturers='".$this->db->escape($manufacturers)."' WHERE aggregator='".$aggregator."'");
    }    
        
        
    public function getAggregatorCategories($aggregator) {
        $query=$this->db->query("SELECT * FROM aggregator_settings WHERE aggregator='".$aggregator."'");
        
        if(isset($query->row['categories'])){
            return $query->row['categories'];
        }else{
            return '';
        }
        
    }
    
    public function setAggregatorCategories($aggregator, $categories){
        $this->db->query("UPDATE aggregator_settings SET categories='".$categories."' WHERE aggregator='".$aggregator."'");
    }
    
    public function setXmlfileDate($aggregator){
        $this->db->query("UPDATE aggregator_settings SET xmlfile_date=NOW(), prepared_items='0', total_items='0' WHERE aggregator='".$aggregator."'");
    }
    
    public function setXmlfileItems($aggregator, $prepared, $total){
        $this->db->query("UPDATE aggregator_settings SET xmlfile_date=NULL, prepared_items='".$prepared."', total_items='".$total."' WHERE aggregator='".$aggregator."'");
   
    }
    
    public function getXmlfileState($aggregator){
        $query=$this->db->query("SELECT * FROM aggregator_settings WHERE aggregator='".$aggregator."'");
        return $query->row;
    }
    
    public function checkNewAggregators(){
        $aggregators=array();
        $controllers=glob(DIR_APPLICATION.'controller/aggregators/*');
        foreach ($controllers as $agg) {
            $aggregators[]=basename($agg, '.php');
        }
        
        $query=$this->db->query("SELECT * FROM aggregator_settings WHERE 1");
        
        $saved_aggregators=array();
        foreach($query->rows as $row){
            $saved_aggregators[]=$row['aggregator'];
        }
        
        foreach($aggregators as $aggreg){
            if(!in_array($aggreg, $saved_aggregators)){
                $this->db->query("INSERT INTO aggregator_settings (aggregator, categories, manufacturers, xmlfile_date, prepared_items, total_items, stack) VALUES('".$aggreg."', '', '', 'empty', 0, 0, 0)");
            }
        }
    }
    
    public function MakeStack(){
        $this->db->query("UPDATE aggregator_settings SET xmlfile_date=NULL, stack=1, total_items=0, prepared_items=0 WHERE categories !=''");
    }
    
    public function IsStack(){
        $query=$this->db->query("SELECT * FROM aggregator_settings WHERE stack=1");
        if($query->num_rows){
            return true;
        }else{
            return false;
        }
    }
    
    public function getAggregators(){
        $query=$this->db->query("SELECT * FROM aggregator_settings");
        return $query->rows;
    }
    
    public function setUnstaked($aggregator){
         $this->db->query("UPDATE aggregator_settings SET stack=0 WHERE aggregator='".$aggregator."'");
    }
}
