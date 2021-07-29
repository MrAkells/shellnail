<?php
class ModelCatalogPromotions extends Model {
    
	public function getPromotion($promo_id, $with_products=true) {
                $this->load->model('catalog/product');
                
		$query = $this->db->query("SELECT DISTINCT *, (date_start<=NOW() AND date_end>=NOW()) as ongoing FROM " . DB_PREFIX . "promotions WHERE promo_id = '" . (int)$promo_id . "'");
               
                $return=[];
                foreach($query->row as $key=>$value){
                    $return[$key]=$value;
                }
                
                if($with_products){
                $products_query=$this->db->query("SELECT  ptc.product_id, pd.name FROM " . DB_PREFIX . "product_to_category ptc LEFT JOIN ".DB_PREFIX."product_description pd ON(ptc.product_id=pd.product_id) WHERE pd.language_id='" . (int)$this->config->get('config_language_id') . "' AND ptc.category_id = '" . (int)$promo_id . "'");
                $products=array();
                foreach($products_query->rows as $row){
                    
                        $result=$this->model_catalog_product->getProduct($row['product_id']);
                        $products[$result['product_id']]=$result;
                   
                }
                $return['products']=$products;
                           
                }else{
                    $products_query=$this->db->query("SELECT  COUNT(ptc.product_id) as count FROM " . DB_PREFIX . "product_to_category ptc LEFT JOIN ".DB_PREFIX."product_description pd ON(ptc.product_id=pd.product_id) WHERE pd.language_id='" . (int)$this->config->get('config_language_id') . "' AND ptc.category_id IN (SELECT DISTINCT promo_id FROM ".DB_PREFIX."promotions WHERE promo_id ='".(int)$promo_id."' OR parent_id='".(int)$promo_id."')");
                    $return['products']=$products_query->row['count'];
                }
                
                
                return $return;
	}

    public function getPromoDescription($promo_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "promotion_description WHERE promo_id = '" . (int)$promo_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
        if ($query->num_rows) {
			return $query->row;
		} else {
			return [];
		}
    }

	public function getActivePromotions() {
		
            $query = $this->db->query("SELECT promo_id FROM " . DB_PREFIX . "promotions WHERE status=1 AND date_start<=NOW() AND date_end>=NOW() AND parent_id=0 ORDER BY hierarchy DESC, sort_order");
            $ids=array();
            foreach($query->rows as $row){
                $ids[]=$row['promo_id'];
            }
            return $ids;
		
	}

        
        public function getMainPromotions() {
		
            $query = $this->db->query("SELECT promo_id FROM " . DB_PREFIX . "promotions WHERE status=1 AND main=1 AND date_start<=NOW() AND date_end>=NOW() AND parent_id=0 ORDER BY hierarchy DESC, sort_order");
            $ids=array();
            foreach($query->rows as $row){
                $ids[]=$row['promo_id'];
            }
            return $ids;
		
	}
        
        public function ActivePromoProducts(){
            $cache_data=$this->cache->get('activepromos');
            if($cache_data){
                return $cache_data;
            }
            $query = $this->db->query("SELECT oc.category_id, ptc.product_id, pr.type, pr.settings, pr.title, pr.parent_id as prparent FROM ".DB_PREFIX ."category oc LEFT JOIN ". DB_PREFIX ."product_to_category ptc ON(oc.category_id=ptc.category_id) LEFT JOIN ". DB_PREFIX ."promotions pr ON(pr.promo_id=oc.category_id)  WHERE pr.status=1 AND pr.date_start<=NOW() AND pr.date_end>=NOW() AND oc.parent_id=197 ORDER BY hierarchy DESC, pr.sort_order DESC");
            $prod_ids=[];
            $promos=[];
            
            foreach($query->rows as $row){
                $prod_ids[$row['type']][$row['product_id']]=[
                    'promo_id'=>$row['category_id'],
                    'type'=>$row['type'],
                    'title'=>$row['title'],
                    'settings'=>$row['settings']
                ];
               // $promos[$row['category_id']]['products'][]=$row['product_id'];
           
               $promos[$row['category_id']]['info']=['type'=> $row['type'], 'settings'=>$row['settings'], 'prparent'=>$row['prparent']];
     
                
            }
            
            $this->cache->set('activepromos', array('prod_ids'=>$prod_ids, 'promos'=>$promos));
            return array('prod_ids'=>$prod_ids, 'promos'=>$promos);
            
        }
        
        public function getGroup($promo_id) {
		
            $query = $this->db->query("SELECT promo_id FROM " . DB_PREFIX . "promotions WHERE status=1 AND date_start<=NOW() AND date_end>=NOW() AND parent_id='".(int)$promo_id."' ORDER BY sort_order");
            $ids=array();
            foreach($query->rows as $row){
                $ids[]=$row['promo_id'];
            }
            return $ids;
		
	}


}
