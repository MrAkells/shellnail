<?php
class ModelCatalogGroups extends Model {
	public function addGroup($data) {
            
            $this->db->query("INSERT INTO ".DB_PREFIX."groups SET title='".$this->db->escape($data['title'])."'");
	}

	public function changeTitle($data) {

            $this->db->query("UPDATE " . DB_PREFIX . "groups  SET  title='".$this->db->escape($data['title'])."' WHERE group_id='".(int)$data['group_id']."'");
	
        }

	public function deleteGroup($group_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "groups WHERE group_id = '" . (int)$group_id . "'");
                $this->db->query("DELETE FROM " . DB_PREFIX . "group_candidates WHERE group_id = '" . (int)$group_id . "'");
       
	}

	public function getGroup($data) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "groups WHERE group_id = '" . (int)$data['group_id'] . "'");

                return $query->row;
	}

	public function getGroups($data = array()) {
            $sql = "SELECT * FROM " . DB_PREFIX . "groups ";
            $query = $this->db->query($sql);
            return $query->rows;
	}


        
        
         public function getGroupProducts($data=array()){
            
		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

		$sql .= " LEFT JOIN " . DB_PREFIX . "group_candidates gc ON (p.product_id = gc.candidate_product_id)";
			
                $sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

                if(isset($data['group_id'])){
                    $sql .= " AND gc.group_id = '" . (int)$data['group_id'] . "'";
                }else{
                    return [];
                }
		$sql .= " GROUP BY p.product_id";

		$sort_data = array(
			'pd.name',
			'p.price',
			'p.quantity',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		$query = $this->db->query($sql);

		return $query->rows;
         }
        
         public function getGroupSelectedProducts($group_id){
            
		$sql = "SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

		$sql .= " LEFT JOIN " . DB_PREFIX . "group_candidates gc ON (p.product_id = gc.candidate_product_id)";
			
                $sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

                $sql .= " AND gc.group_id = '" . (int)$group_id . "' AND gc.selected='1'";
        
		$sql .= " GROUP BY p.product_id";

		$query = $this->db->query($sql);

                $ids=[];
                foreach($query->rows as $row){
                         $ids[]=$row['product_id'];
                }
		return  $ids;
         }
         
         public function addCandidateProducts($data){
             
            if(isset($data['product']) && isset($data['group_id'])){
                
                foreach($data['product'] as $product_id){
                    $this->db->query("DELETE FROM ".DB_PREFIX."group_candidates WHERE group_id='".(int)$data['group_id']."' AND candidate_product_id='".$product_id."'");
                
                    $this->db->query("INSERT INTO ".DB_PREFIX."group_candidates SET group_id='".(int)$data['group_id']."', candidate_product_id='".$product_id."'");
                }
                
            }
         }
         
     
         
         public function addCandidatesSelected($data){
             
            if(isset($data['product']) && isset($data['group_id'])){
                
                foreach($data['product'] as $product_id){
                    $this->db->query("INSERT INTO ".DB_PREFIX."group_candidates SET group_id='".(int)$data['group_id']."', candidate_product_id='".$product_id."', selected='1'");
                }
               
            }
         }
         
        public function changeBasePrices($data){
            
            if($data['type']=='1'){
                $coefficient=(float)((100+(float)$data['change_price'])/100);
                $this->db->query("UPDATE ".DB_PREFIX."product SET price=price*".$coefficient.", price_modified=NOW() WHERE product_id IN(".implode(', ', $data['selected']).")");
            
            }else if($data['type']=='2'){
                $coefficient=(float)$data['change_price'];
                if($coefficient<0){
                    $coefficient=-($coefficient);
                    $this->db->query("UPDATE ".DB_PREFIX."product SET price=(price-".$coefficient."), price_modified=NOW() WHERE product_id IN(".implode(', ', $data['selected']).")");
            
                }else{
                    $this->db->query("UPDATE ".DB_PREFIX."product SET price=(price+".$coefficient."), price_modified=NOW() WHERE product_id IN(".implode(', ', $data['selected']).")");
            
                }
                
            }
           
            
        }
         
        public function deleteCandidateProducts($data){
            
            $this->db->query("DELETE FROM ".DB_PREFIX."group_candidates WHERE group_id='".(int)$data['group_id']."'");
    
        }
         
         public function getEligibleProducts($data){
                if($data['category_id'] || $data['manufacturer_id']){
                    $sql="SELECT DISTINCT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON(p.product_id = p2c.product_id) WHERE ";
                    if($data['category_id']){ 
                        $sql.="p2c.category_id = '" . (int)$data['category_id'] . "' ";
                        if($data['manufacturer_id']){
                            $sql.="AND p.manufacturer_id = '" . (int)$data['manufacturer_id'] . "' ";
                        }
                    }else{
                         $sql.=" p.manufacturer_id = '" . (int)$data['manufacturer_id'] . "' ";
                    }
                    
                    $pre_query=$this->db->query("SELECT DISTINCT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "group_candidates gc ON(p.product_id = gc.candidate_product_id) WHERE gc.group_id = '" . (int)$data['group_id'] . "'");
                    if($pre_query->num_rows){
                        $sql.=" AND p.product_id NOT IN (SELECT DISTINCT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "group_candidates gc ON(p.product_id = gc.candidate_product_id) WHERE gc.group_id = '" . (int)$data['group_id'] . "')";
                    }
                    
                    
                    $query=$this->db->query($sql);
                    return $query->rows;
                }else{
                    return [];
                }
         }
         
        public function saveGroupProducts($data){
            $this->db->query("UPDATE ".DB_PREFIX."group_candidates SET selected='0' WHERE group_id='".$data['group_id']."'");
                
            if(isset($data['selected'])){
                foreach($data['selected'] as $product_id){
                    $this->db->query("UPDATE ".DB_PREFIX."group_candidates SET selected='1' WHERE candidate_product_id='".$product_id."'");
                }
            }
           
        }
         
}
