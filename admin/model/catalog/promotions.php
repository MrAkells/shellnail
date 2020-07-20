<?php
class ModelCatalogPromotions extends Model {
	public function addPromotion($data) {
            
            $this->load->model("catalog/category");
            
            $category_data=array(
                'status'=>1,
                'category_store'=>[0],
                'sort_order'=>0,
                'column'=>1,
                // id служебной категории для акций
                'parent_id'=>197,
                'category_description'=>array(
                    1=>['name'=>$data['title'], 'description'=>'', 'meta_title'=>$data['meta_title'], 'meta_h1'=>$data['meta_h1'], 'meta_description'=>$data['meta_description'], 'meta_keyword'=>$data['meta_keywords']]
                )
            );
            
            $category_id=$this->model_catalog_category->addCategory($category_data);
            
            $settings='';
            if($data['type']==1){
                $settings=$data['percent'];
            }else if($data['type']==2){
                $settings=$data['discount'];
            }else if($data['type']==3){
                $settings=$data['quantity'];
            }
            
             $hierarchy=0;
            if($data['parent_id']){
                $hierarchy=-1;
                $this->db->query("UPDATE ".DB_PREFIX."promotions SET hierarchy='1' WHERE promo_id='".(int)$data['parent_id']."'");
            }
            $this->db->query("INSERT INTO ".DB_PREFIX."promotions SET promo_id='".(int)$category_id."', title='".$this->db->escape($data['title'])."', short_title='".$this->db->escape($data['short_title'])."', image = '" . $this->db->escape($data['image']) . "', status = '" . (int)$data['status'] . "', main = '" . (int)$data['main'] . "', sort_order='".(int)$data['sort_order']."', description='".$this->db->escape($data['description'])."', type='".(int)$data['type']."', date_start='".$this->db->escape($data['date_start'])."', date_end='".$this->db->escape($data['date_end'])."', settings='".$settings."', parent_id='" .(int)$data['parent_id']."', hierarchy='".(int)$hierarchy."', meta_title='".$this->db->escape($data['meta_title'])."', meta_description='".$this->db->escape($data['meta_description'])."', meta_keywords='".$this->db->escape($data['meta_keywords'])."', meta_h1='".$this->db->escape($data['meta_h1'])."'");

            if (isset($data['keyword'])) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
            }
            
            $promo_id = $this->db->getLastId();
            
            $this->cache->delete('promotions');
            $this->cache->delete('activepromos');
            $this->cache->delete('seo_pro');
            $this->cache->delete('seo_url');
            
            return $promo_id;
	}

	public function editPromotion($promo_id, $data) {
            $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "promotions WHERE promo_id = '" . (int)$data['promo_id'] . "'");
            $old_parent = $query->row['parent_id'];
            $this->db->query("UPDATE ".DB_PREFIX."category_description SET name='".$this->db->escape($data['title'])."', meta_title='".$this->db->escape($data['meta_title'])."', meta_h1='".$this->db->escape($data['meta_h1'])."',  meta_description='".$this->db->escape($data['meta_description'])."', meta_keyword='".$this->db->escape($data['meta_keywords']) . "' WHERE language_id=1 AND category_id='".(int)$promo_id."'");

            $settings='';
            if($data['type']==1){
                $settings=$data['percent'];
            }else if($data['type']==2){
                $settings=$data['discount'];
            }else if($data['type']==3){
                $settings=$data['quantity'];
            }
            
            $hierarchy= $query->row['hierarchy'];
            if($data['parent_id'] != $old_parent){
                if($data['parent_id']){
                    $hierarchy=-1;
                }
                $this->db->query("UPDATE ".DB_PREFIX."promotions SET hierarchy='1' WHERE promo_id='".(int)$data['parent_id']."'");
                if($old_parent){
                     $query2 = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "promotions WHERE parent_id = '" . (int)$old_parent . "'");
                   
                     if($query2->num_rows<2){
                          $this->db->query("UPDATE ".DB_PREFIX."promotions SET hierarchy='0' WHERE promo_id='".(int)$old_parent."'");
                     }
                }
            }
            $this->db->query("UPDATE " . DB_PREFIX . "promotions  SET  title='".$this->db->escape($data['title'])."', short_title='".$this->db->escape($data['short_title'])."', image = '" . $this->db->escape($data['image']) . "', status = '" . (int)$data['status'] . "', main = '" . (int)$data['main'] . "', sort_order='".(int)$data['sort_order']."', description='".$this->db->escape($data['description'])."', type='".(int)$data['type']."', date_start='".$this->db->escape($data['date_start'])."', date_end='".$this->db->escape($data['date_end'])."', settings='".$settings."', parent_id='" .(int)$data['parent_id']."', hierarchy='".(int)$hierarchy."', meta_title='".$this->db->escape($data['meta_title'])."', meta_description='".$this->db->escape($data['meta_description'])."', meta_keywords='".$this->db->escape($data['meta_keywords'])."', meta_h1='".$this->db->escape($data['meta_h1'])."' WHERE promo_id='".(int)$promo_id."'");

//            $this->db->query("DELETE FROM ".DB_PREFIX."product_to_category WHERE category_id='".(int)$promo_id."'");
//            if(isset($data['selected'])){
//                foreach($data['selected'] as $product_id){
//                    $this->db->query("INSERT INTO ".DB_PREFIX."product_to_category SET category_id='".(int)$promo_id."', product_id='".$product_id."'");
//                }
//            }
            
            $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$promo_id."'");
            if (isset($data['keyword'])) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$promo_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
            }
            
            $this->cache->delete('seo_pro');
            $this->cache->delete('seo_url');    
            $this->cache->delete('activepromos');
            $this->cache->delete('promotions');
	}

	public function deletePromotion($promo_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "promotions WHERE promo_id = '" . (int)$promo_id . "'");
                $this->db->query("DELETE FROM " . DB_PREFIX . "promotion_candidates WHERE promo_id = '" . (int)$promo_id . "'");
                
                $this->load->model("catalog/category");
                $this->model_catalog_category->deleteCategory($promo_id);
                
                $this->cache->delete('activepromos');
                 $this->cache->delete('promotions');
	}

	public function getPromotion($data) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "promotions WHERE promo_id = '" . (int)$data['promo_id'] . "'");
               
		$seo_keyword=$this->db->query("SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=".(int)$data['promo_id']."'" );
                $return=[];
                foreach($query->row as $key=>$value){
                    $return[$key]=$value;
                }
                
                $return['products']=$this->getPromoProducts($data);
                $return['selected']=$this->getSelectedPromoProducts($data['promo_id']);
                $return['keyword']=$seo_keyword->row['keyword'];

//                echo '<pre>';
//                var_dump($return);
//                die;
                
                return $return;
	}

	public function getPromotions($data = array()) {
		
            $sql = "SELECT *, (date_start<=NOW() AND date_end>=NOW()) as ongoing FROM " . DB_PREFIX . "promotions ";

            if(isset($data['without_children']) && $data['without_children']){
                 $sql .= " WHERE hierarchy IN(1,0) ";
            }
         
            if (isset($data['start']) || isset($data['limit'])) {
                if ($data['start'] < 0) {
                    $data['start'] = 0;
                }

                if ($data['limit'] < 1) {
                    $data['limit'] = 20;
                }

                $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
            }

            
            $query = $this->db->query($sql);

            return $query->rows;
		
	}


	public function getTotalPromotions() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "promotions");

		return $query->row['total'];
	}

        public function getAllPromotedProducts($edited_promo_id){
            if($edited_promo_id){
                $products_query=$this->db->query("SELECT  ptc.product_id, ptc.category_id, p.title FROM " . DB_PREFIX . "product_to_category ptc LEFT JOIN ".DB_PREFIX."promotions p ON(ptc.category_id=p.promo_id) WHERE ptc.category_id IN(SELECT promo_id FROM " . DB_PREFIX . "promotions WHERE status=1 AND promo_id !='".$edited_promo_id."')");
            }else{
                $products_query=$this->db->query("SELECT  ptc.product_id, ptc.category_id, p.title FROM " . DB_PREFIX . "product_to_category ptc LEFT JOIN ".DB_PREFIX."promotions p ON(ptc.category_id=p.promo_id) WHERE ptc.category_id IN(SELECT promo_id FROM " . DB_PREFIX . "promotions WHERE status=1)");
            }
            
            $prod_to_promo=[];
            foreach($products_query->rows as $row){
                $prod_to_promo[$row['product_id']]=$row['title'];
            }
            
            return  $prod_to_promo;
        }
        
         public function getPromoProducts($data=array()){
            
		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

		$sql .= " LEFT JOIN " . DB_PREFIX . "promotion_candidates pc ON (p.product_id = pc.candidate_product_id)";
			
                $sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

                if(isset($data['promo_id'])){
                    $sql .= " AND pc.promo_id = '" . (int)$data['promo_id'] . "'";
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

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
         }
        
         public function getSelectedPromoProducts($promo_id){
            
		$sql = "SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

		$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category pc ON (p.product_id = pc.product_id)";
			
                $sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

                $sql .= " AND pc.category_id = '" . (int)$promo_id . "'";
        
		$sql .= " GROUP BY p.product_id";

		$query = $this->db->query($sql);

                $ids=[];
                foreach($query->rows as $row){
                         $ids[]=$row['product_id'];
                }
		return  $ids;
         }
         
         public function addCandidateProducts($data){
             
            if(isset($data['product']) && isset($data['promo_id'])){
                
                foreach($data['product'] as $product_id){
                    $this->db->query("DELETE FROM ".DB_PREFIX."promotion_candidates WHERE promo_id='".(int)$data['promo_id']."' AND candidate_product_id='".$product_id."'");
                
                    $this->db->query("INSERT INTO ".DB_PREFIX."promotion_candidates SET promo_id='".(int)$data['promo_id']."', candidate_product_id='".$product_id."'");
                }
                $this->cache->delete('promotions');
                $this->cache->delete('activepromos');
            }
         }
         
         public function addCandidatesGroup($data){
             
            if(isset($data['product']) && isset($data['promo_id'])){
                
                foreach($data['product'] as $product_id){
                    $this->db->query("INSERT INTO ".DB_PREFIX."promotion_candidates SET promo_id='".(int)$data['promo_id']."', candidate_product_id='".$product_id."'");
                }
                $this->cache->delete('promotions');
                $this->cache->delete('activepromos');
            }
         }
         
        public function changeBasePrices($data){
            $coefficient=(float)((100+(int)$data['change_price'])/100);
            $this->db->query("UPDATE ".DB_PREFIX."product SET price=price*".$coefficient." WHERE product_id IN(".implode(', ', $data['selected']).")");
            
        }
         
           public function deleteCandidateProducts($data){
             
            $this->db->query("DELETE FROM ".DB_PREFIX."promotion_candidates WHERE promo_id='".(int)$data['promo_id']."'");
                   
            if(isset($data['selected'])){
                foreach($data['selected'] as $product_id){
                    $this->db->query("INSERT INTO ".DB_PREFIX."promotion_candidates SET candidate_product_id='".(int)$product_id."', promo_id='".(int)$data['promo_id']."'");
                }
            }
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
                    
                    $pre_query=$this->db->query("SELECT DISTINCT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "promotion_candidates p2c ON(p.product_id = p2c.candidate_product_id) WHERE p2c.promo_id = '" . (int)$data['promo_id'] . "'");
                    if($pre_query->num_rows){
                        $sql.=" AND p.product_id NOT IN (SELECT DISTINCT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "promotion_candidates p2c ON(p.product_id = p2c.candidate_product_id) WHERE p2c.promo_id = '" . (int)$data['promo_id'] . "')";
                    }
                    
                    
                    $query=$this->db->query($sql);
                    return $query->rows;
                }else{
                    return [];
                }
         }
         
        public function savePromoProducts($data){
            $this->db->query("DELETE FROM ".DB_PREFIX."product_to_category WHERE category_id='".(int)$data['promo_id']."'");
            if(isset($data['selected'])){
                foreach($data['selected'] as $product_id){
                    $this->db->query("INSERT INTO ".DB_PREFIX."product_to_category SET category_id='".(int)$data['promo_id']."', product_id='".$product_id."'");
                }
            }
            $this->cache->delete('promotions');
            $this->cache->delete('activepromos');
        }
         
}
