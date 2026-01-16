<?php
class ControllerProductPromotions extends Controller {
	public function index() {
           
		$this->load->language('product/promotions');
                $this->load->model('catalog/promotions');
                $this->load->model('tool/image');
            
                $this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
                $this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');
                $this->document->addLink($this->url->link('product/promotions'), 'canonical');

                $cache_data=$this->cache->get('promotions_'. $this->config->get('config_language_id'));
           if(!$cache_data){
                
                $data['button_cart'] = $this->language->get('button_cart');
                $data['button_buy_click'] = $this->language->get('button_buy_click');
                $data['button_notify_availability'] = $this->language->get('button_notify_availability');
                $data['button_wishlist'] = $this->language->get('button_wishlist');
                $data['button_compare'] = $this->language->get('button_compare');
                
                //$data['text_buy_one_click'] = $this->language->get('text_buy_one_click');
               
                $data['text_instock']  = $this->language->get('text_instock');
                $data['text_outstock'] = $this->language->get('text_outstock');
                
                $data['text_artikul'] = $this->language->get('text_artikul');
                $data['text_reviews_number'] = $this->language->get('text_reviews_number');

                $data['text_promotions']=$this->language->get('heading_title');
            
                $promo_ids=$this->model_catalog_promotions->getMainPromotions();
            
                $data['promotions']=array();
                foreach($promo_ids as $promo_id){
                    $promotion=$this->model_catalog_promotions->getPromotion($promo_id);
                    $products=array();
                    foreach($promotion['products'] as $product){
                        
                        if ($product['image']) {
                            $image = $this->model_tool_image->resize($product['image'], 175, 175);
                        } else {
                            $image = $this->model_tool_image->resize('placeholder.png', 175, 175);
                        }
                        
                        if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                                $price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                            } else {
                                $price = false;
                            }

                            if ((float)$product['special']) {
                                $special = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                            } else {
                                $special = false;
                            }

                            if ($this->config->get('config_tax')) {
                                $tax = $this->currency->format((float)$product['special'] ? $product['special'] : $product['price'], $this->session->data['currency']);
                            } else {
                                $tax = false;
                            }

                            if ($this->config->get('config_review_status')) {
                                $rating = $product['rating'];
                            } else {
                                $rating = false;
                            }
                        
                        
                        $products[]=array(
                            'product_id' => $product['product_id'],
                            'reviews' => $product['reviews'],
                            'sku' => $product['sku'],
                            'stock_status'=>$product['stock_status'],
                            'quantity'=>$product['quantity'],
                            'thumb' => $image,
                            'name' => $product['name'],
                            'description' => utf8_substr(strip_tags(html_entity_decode($product['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
                            'price' => $price,
                             'intprice' => $product['price'],
                            'special' => $special,
                            'tax' => $tax,
                            'rating' => $rating,
                            'href' => $this->url->link('product/product', 'product_id=' . $product['product_id'])
                        );
                    }
                    
                    $sort=[];
                    foreach($products  as $key=>$value){
                        $sort[$key]=(int)$value['quantity'];
                    }
                    array_multisort($sort, SORT_DESC, $products);
                    
                    $data['promotions'][]=array(
                        'promo_id'=>$promotion['promo_id'],
                        'title'=>$promotion['short_title'],
                        'products'=>  array_slice($products, 0,10)
                    );
                }
                $this->cache->set('promotions_'. $this->config->get('config_language_id'), $data);
              
           }else{
               $data=$cache_data;
           }
       
                    return $this->load->view('product/promotions', $data);
                }
}
