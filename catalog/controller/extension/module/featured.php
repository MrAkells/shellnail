<?php
class ControllerExtensionModuleFeatured extends Controller {
	public function index($setting) {

		$this->load->language('extension/module/featured');

		//$data['heading_title'] = $this->language->get('heading_title');
                $data['heading_title'] =  $setting['name'];
              
                $this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');
                
		$data['text_tax'] = $this->language->get('text_tax');
    $data['button_notify_availability'] = $this->language->get('button_notify_availability');
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
                
                $data['text_artikul'] = $this->language->get('text_artikul');
		$data['text_reviews_number'] = $this->language->get('text_reviews_number');
             
                $data['text_buy_one_click'] = $this->language->get('text_buy_one_click');
               
                $data['text_instock']  = $this->language->get('text_instock');
                $data['text_outstock'] = $this->language->get('text_outstock');
                
		$this->load->model('catalog/product');

		$this->load->model('tool/image');

                $products=array();
		$data['products'] = array();

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}

                $method='';
                
                $template='featured';
                if ($setting['tpl']){ 
                    $template=$setting['tpl'];
                    $method=$setting['tpl'];
                }
                
		if(method_exists($this, $method) && empty($setting['product'])){
                   
                    $products=$this->$method($setting);
                }else{
                    if(!empty($setting['product'])){
                        $products = array_slice($setting['product'], 0, (int)$setting['limit']);
                    }
                }
		
            foreach ($products as $product_id) {
		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
                    if ($product_info['image']) {
			$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
                    } else {
			$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
                    }

                    if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
			$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    } else {
			$price = false;
                    }

                    if ((float)$product_info['special']) {
                        $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    } else {
			$special = false;
                    }

                    if ($this->config->get('config_tax')) {
			$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
                    } else {
			$tax = false;
                    }

                    if ($this->config->get('config_review_status')) {
			$rating = $product_info['rating'];
                    } else {
			$rating = false;
                    }

                    $data['products'][] = array(
                        'product_id' => $product_info['product_id'],
                        'reviews' => $product_info['reviews'],
                        'sku' => $product_info['sku'],
                        'stock_status'=>$product_info['stock_status'],
                        'quantity'=>$product_info['quantity'],
                        'thumb' => $image,
                        'name' => $product_info['name'],
                        'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
                        'price' => $price,
                        'intprice' => $product_info['price'],
                        'special' => $special,
                        'tax' => $tax,
                        'rating' => $rating,
                        'href' => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
                    );
                }
        }
		
            $sort=[];
            foreach($data['products']  as $key=>$value){
                $sort[$key]=(int)$value['quantity'];
            }
            array_multisort($sort, SORT_DESC, $data['products']);
        
        
            $data['tpl']=$template;
                    
            if($data['products']){
                return $this->load->view('extension/module/'.$template, $data);
            }
           
	}
        
        
        private function newproducts($setting){
            $this->load->model('catalog/product');
            $query=$this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$setting['limit']);
            $ids=array();
            foreach($query->rows as $row){
                $ids[]=$row['product_id'];
            }
            return $ids;
        }
        
         private function popularproducts($setting){
            $this->load->model('catalog/product');
            $query=$this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC LIMIT " . (int)$setting['limit']);
            $ids=array();
            foreach($query->rows as $row){
                $ids[]=$row['product_id'];
            }
            return $ids;
        }
}