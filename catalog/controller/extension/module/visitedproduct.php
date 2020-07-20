<?php
class ControllerExtensionModuleVisitedproduct extends Controller {
	public function index($setting) {
           
		$this->load->language('extension/module/visitedproduct');
                
                $this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');

		$data['heading_title'] = $setting['name'];
                $data['text_reviews'] = $this->language->get('text_reviews');
                $data['button_cart'] = $this->language->get('button_cart');
                $data['text_artikul'] = $this->language->get('text_artikul');
                $data['text_buy_one_click'] = $this->language->get('text_buy_one_click');
                $data['button_notify_availability'] = $this->language->get('button_notify_availability');
               
                $data['text_instock']  = $this->language->get('text_instock');
                $data['text_outstock'] = $this->language->get('text_outstock');
                
		$data['text_reviews_number'] = $this->language->get('text_reviews_number');
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image');
		
		$data['products'] = array();
		
		if(isset($this->session->data['products_id']))
			$this->session->data['products_id'] = array_slice($this->session->data['products_id'], -$setting['limit']);

		if (isset($this->session->data['products_id'])) {
			foreach ($this->session->data['products_id'] as $product_info_id) {
				$product_info = $this->model_catalog_product->getProduct($product_info_id);
                                
                                if(!$product_info){
                                    continue;
                                } 
                                
                                $image='';
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], 200, 200);
				} 
				
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
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
				if(utf8_strlen($product_info['name']) < 80){
					$sub_name = $product_info['name'];
				}else{
					$sub_name = utf8_substr($product_info['name'], 0, 80) . '..';
				}
                                
                                $this->load->model('catalog/review');
                                $reviews = $this->model_catalog_review->getTotalReviewsByProductId($product_info_id);
                                if(!$reviews){
                                    $reviews='0';
                                }
                                
                                
				$data['products'][] = array(
					'product_id'  => $product_info['product_id'],
					'thumb'       => $image,
					'name'        => $sub_name ,
					'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price' => $price,
                                        'intprice' => $product_info['price'],
                                        'quantity'=>$product_info['quantity'],
                                        'stock_status'=>$product_info['stock_status'],
                                        'sku'         => $product_info['sku'],
					'special'     => $special,
                                        'reviews'     =>$reviews,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
				);
			}
		}
		
                $sort=[];
                foreach($data['products']  as $key=>$value){
                    $sort[$key]=(int)$value['quantity'];
                }
                array_multisort($sort, SORT_DESC, $data['products']);
                
		if ($data['products']) {
			return $this->load->view('extension/module/visitedproduct', $data);
		}
	}
}