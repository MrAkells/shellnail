<?php
class ControllerProductCategory extends Controller {
	public function index() {
            
		$this->load->language('product/category');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

                
		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$data['number_page'] = $page;
		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['path'])) {
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'path=' . $path . $url)
					);
				}
			}
		} else {
			$category_id = 0;
		}

                $this->config->set('category_id', $category_id);
                
                // Если пришел ajax - запрос, то это фильтр обновляет свою разметку
                if($this->request->server['REQUEST_METHOD'] == 'POST'){
                    
                    $response=[];
                    $response['html']=$this->load->controller('common/column_left');

                        $filter_data2 = array(
                            'filter_category_id' => $category_id,
                            'filter_dvfilter' => $filter_dvfilter
			);

                    $prod_total = $this->model_catalog_product->getTotalProducts($filter_data2);
                    $response['count']=$prod_total;
                    
                $this->response->setOutput(json_encode($response));    
                return;
            }

		$category_info = $this->model_catalog_category->getCategory($category_id);

		if ($category_info) {
			$meta_description = (mb_detect_encoding($category_info['meta_description']) == 'UTF-8' ? $category_info['meta_description'] :mb_convert_encoding($category_info['meta_description'],'utf-8', "HTML-ENTITIES"));
			if ($page == 1) {
			if ($category_info['meta_title']) {
				$this->document->setTitle($category_info['meta_title']);
			} else {
				$this->document->setTitle($category_info['name']);
			}

			
			$this->document->setDescription($meta_description);
			$this->document->setKeywords($category_info['meta_keyword']);
			}else{
					if ($category_info['meta_title']) {
				$this->document->setTitle($category_info['meta_title'].' - стр. '.$page);
			} else {
				$this->document->setTitle($category_info['name'].' - стр. '.$page);
			}

			$this->document->setDescription($meta_description.' - стр. '.$page);
			$this->document->setKeywords($category_info['meta_keyword'].' - стр. '.$page);
			}
		

			if ($category_info['meta_h1']) {
				$data['heading_title'] = $category_info['meta_h1'];
			} else {
				$data['heading_title'] = $category_info['name'];
			}
			
			$data['text_refine'] = $this->language->get('text_refine');
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_quantity'] = $this->language->get('text_quantity');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_price'] = $this->language->get('text_price');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_limit'] = $this->language->get('text_limit');

                        $data['text_instock']  = $this->language->get('text_instock');
                        $data['text_outstock'] = $this->language->get('text_outstock');
                        $data['text_artikul'] = $this->language->get('text_artikul');
                        
                        $data['button_notify_availability'] = $this->language->get('button_notify_availability');
                        
			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['button_list'] = $this->language->get('button_list');
			$data['button_grid'] = $this->language->get('button_grid');

			// Set the last category breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => $category_info['name'],
				'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'])
			);

			if ($category_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get($this->config->get('config_theme') . '_image_category_width'), $this->config->get($this->config->get('config_theme') . '_image_category_height'));
				$this->document->setOgImage($data['thumb']);
			} else {
				$data['thumb'] = '';
			}

			if (isset($this->request->get['order'])) {
				$data['description'] = '';
			} else{
				$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
			}
			$data['compare'] = $this->url->link('product/compare');

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['categories'] = array();
			$this->load->model('catalog/extralinks'); 
			$results = $this->model_catalog_category->getCategories($category_id);
			$extra_links=$this->model_catalog_extralinks->getExtralinks();

			foreach ($results as $result) {
				$filter_data = array(
					'filter_category_id'  => $result['category_id'],
					'filter_sub_category' => true
				);

                                
                                if ($result['image']) {
					$categ_image = $this->model_tool_image->resize($result['image'], 125, 125);
				} else {
					$categ_image = $this->model_tool_image->resize('placeholder.png', 125, 125);
				}
                                
				$data['categories'][] = array(
					'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url),
                                        'categ_image' => $categ_image
				);
			}
				if(isset($extra_links[$category_id])){
                            foreach($extra_links[$category_id] as $link){
                                    if ($link['icon']) {
					$image_extra = $this->model_tool_image->resize($link['icon'], 125, 125);
				} else {
					$image_extra = $this->model_tool_image->resize('placeholder.png', 125, 125);
				}
                               $data['categories'][] = array(
                                    'name'        => $link['title'],
                                    'href'        => $link['link'],
                                    'categ_image'        => $image_extra
                                );
                            
                            }
                          
                            
                        }
                        
                     if($category_info['parent_id']==197){
                         
                         $data['breadcrumbs'] = array();

                        $data['breadcrumbs'][] = array(
                            'text' => $this->language->get('text_home'),
                            'href' => $this->url->link('common/home')
                        );
                         
                         
                        $data['text_promo_product']=$this->language->get('text_promo_product');
                        $data['text_look_over']=$this->language->get('text_look_over');
                        $data['text_day']=$this->language->get('text_day');
                        $data['text_hour']=$this->language->get('text_hour');
                        $data['text_minute']=$this->language->get('text_minute');
                        $data['text_second']=$this->language->get('text_second');
                        
                          $this->load->model('catalog/promotions');
                        $promotion=$this->model_catalog_promotions->getPromotion($category_id, false);
                   
                        if($promotion['hierarchy'] == 1){
                            $this->load->controller('features/group', ['promo_id'=>$category_id]);
                            return;
                        }
               
                        if ($promotion['image']) {
                            $image = $this->model_tool_image->resize($promotion['image'], 861, 331);
                        } else {
                            $image = $this->model_tool_image->resize('placeholder.png', 861, 331);
                        }
                    
                        $this->load->model('tool/online');
                        $observers=$this->model_tool_online->getTotalCustomersOnline($promotion['promo_id']);
                        
                        $ends=strtotime($promotion['date_end']);
                        $date_end=date('d.m.Y',$ends);
                        $data['promo']=array(
                            'promo_id'=>$promotion['promo_id'],
                            'title'=>$promotion['title'],
                            'endtime'=> $ends,
                            'description'=> html_entity_decode($promotion['description']),
                            'date_end'=>$date_end,
                            'thumb'=>$image,
                            'href'=>$this->url->link('product/category', 'category_id=' . $promotion['promo_id']),
                            'count'=>$promotion['products'],
                            'observers'=>$observers
                        );
                    
                    }
                    

			$data['products'] = array();

			$filter_data = array(
				'filter_category_id' => $category_id,
				'filter_filter'      => $filter,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);

			$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
                                
				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
                                        'sku'       => $result['sku'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
                                        'intprice'       => $result['price'],
					'special'     => $special,
					'tax'         => $tax,
                                        'video_link' => $result['video'],
                                        'quantity'         => $result['quantity'],
					'minimum'     => ($result['minimum'] > 0) ? $result['minimum'] : 1,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url)
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['sorts'] = array();

			$data['sorts']['p.sort_order-ASC'] = array(
				'text'  => $this->language->get('text_po_poryadku_asc'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
			);
                        
            $data['sorts']['p.sort_order-DESC'] = array(
				'text'  => $this->language->get('text_po_poryadku_desc'),
				'value' => 'p.sort_order-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=DESC' . $url)
			);

			$data['sorts']['p.viewed-ASC'] = array(
				'text'  => $this->language->get('text_most_viewed_asc'),
				'value' => 'p.viewed-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.viewed&order=ASC' . $url)
			);

			$data['sorts']['p.viewed-DESC'] = array(
				'text'  => $this->language->get('text_most_viewed_desc'),
				'value' => 'p.viewed-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.viewed&order=DESC' . $url)
			);

			$data['sorts']['p.price-ASC'] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
			);

			$data['sorts']['p.price-DESC'] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
			);

			$data['sorts']['p.date_added-ASC'] = array(
				'text'  => $this->language->get('text_newest_asc'),
				'value' => 'p.date_added-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.date_added&order=ASC' . $url)
			);

			$data['sorts']['p.date_added-DESC'] = array(
				'text'  => $this->language->get('text_newest_desc'),
				'value' => 'p.date_added-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.date_added&order=DESC' . $url)
			);

                        
                       // echo '<pre>'; var_dump($data['sorts']);
                        
                        
			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$data['limits'] = array();

			$limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 32, 64, 96));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));
 
                        //$data['load_more_products']=$this->config->get('infscrl_endtext')[$this->config->get('config_language_id')];
                        $data['load_more_products']=sprintf($this->language->get('load_more_products'), $limit);
                         
			// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
			if ($page == 1) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], true), 'canonical');
			} elseif ($page == 2) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], true), 'prev');
			} else {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page='. ($page - 1), true), 'prev');
			}
			if ($page !== 1) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], true), 'canonical');
			}
			
			if ($limit && ceil($product_total / $limit) > $page) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page='. ($page + 1), true), 'next');
			}

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;

			$data['continue'] = $this->url->link('common/home');

                        $mini_header_catalog=$this->load->controller('extension/module/menu', ['template'=>"extension/module/mini_menu_noindex"]);
                        $this->config->set('mini_header_catalog',$mini_header_catalog);
                        $this->config->set('category_breadcrumbs',$data['breadcrumbs']);
                       
                        $this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
                        $this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
                     
                        
			$data['column_left'] = $this->load->controller('common/column_left');
			//$data['column_right'] = $this->load->controller('common/column_right');
                        $data['column_right'] = '';
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('product/category', $data));
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('product/category', $url)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error_description');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
                        
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}
}
