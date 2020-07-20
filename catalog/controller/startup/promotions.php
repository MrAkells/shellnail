<?php
class ControllerStartupPromotions extends Controller {
    
    public function index() {
	$this->load->model('catalog/promotions');	
   
        $promo_data=$this->model_catalog_promotions->ActivePromoProducts();
          
        $promo_products=$promo_data['prod_ids'];
        $promos=$promo_data['promos'];
        
        
        $this->config->set('active_promos_products_as_keys', $promo_products);
        $this->config->set('active_promos_width_prod_ids', $promos);
        
//        echo '<pre>';
//        var_dump($promo_products);
//        var_dump($promos);
        
    }
    
    
}
