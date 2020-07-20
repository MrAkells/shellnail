<?php
class ControllerAccountOrder extends Controller {
	public function index() {

		$this->load->language('account/order');
		
                if (isset($this->request->get['period'])) {
                    $period = $this->request->get['period'];
                }else{
                    $period=false;
                }
                
                
		$url = '';

//		if (isset($this->request->get['page'])) {
//			$url .= '&page=' . $this->request->get['page'];
//		}
                
		if (isset($this->request->get['period'])) {
                    $url .= '&period=' . $this->request->get['period'];
                }

                
		$data['heading_title'] = $this->language->get('heading_title');

                $data['text_period']   = $this->language->get('text_period');
                $data['text_all_your_orders']  = $this->language->get('text_all_your_orders');
                
                $data['text_all']      = $this->language->get('text_all');
              
                $data['href_all'] = $this->url->link('account/order/getList', '&period=all', true);
                
                $data['text_this_month']  = $this->language->get('text_this_month');
                $data['href_this_month'] = $this->url->link('account/order/getList', '&period=this_month', true);
                
                $data['text_last_month']  = $this->language->get('text_last_month');
                $data['href_last_month'] = $this->url->link('account/order/getList', '&period=last_month', true);
                
                $data['text_last_year']   = $this->language->get('text_last_year');
                $data['href_last_year'] = $this->url->link('account/order/getList', '&period=last_year', true);
                
                $data['text_this_year']  = $this->language->get('text_this_year');
                $data['href_this_year'] = $this->url->link('account/order/getList', '&period=this_year', true);
                
                $data['text_product']    = $this->language->get('text_product');
                $data['text_on_summ']    = $this->language->get('text_on_summ');
                
                
		$data['text_empty'] = $this->language->get('text_empty');


		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_product'] = $this->language->get('column_product');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_date_added'] = $this->language->get('column_date_added');

		$data['button_view'] = $this->language->get('button_view');
    $data['button_ocstore_payeer_onpay'] = $this->language->get('button_ocstore_payeer_onpay');
    $data['button_ocstore_yk_onpay'] = $this->language->get('button_ocstore_yk_onpay');
		$data['button_continue'] = $this->language->get('button_continue');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['orders'] = array();

		$this->load->model('extension/payment/ocstore_payeer');
		$this->load->model('extension/payment/ocstore_yk');
		$this->load->model('account/order');
                
              
               
               // $limit=1;
               $limit=5;
                
                
                if($period=='all' || $period===false){
                    $order_total = $this->model_account_order->getTotalOrders();
                    $results = $this->model_account_order->getOrders(($page - 1) * $limit, $limit);
                }else if($period=='this_month'){
                    $order_total = $this->model_account_order->getTotalOrdersMonth();
                    $results = $this->model_account_order->getOrders(($page - 1) * $limit, $limit, $period);
                }else if($period=='last_month'){
                    $order_total = $this->model_account_order->getTotalOrdersByLastMonth();
                    $results = $this->model_account_order->getOrders(($page - 1) * $limit, $limit, $period);
                }else if($period=='this_year'){
                    $order_total = $this->model_account_order->getTotalOrdersByYear();
                    $results = $this->model_account_order->getOrders(($page - 1) * $limit, $limit, $period);
                }else if($period=='last_year'){
                    $order_total = $this->model_account_order->getTotalOrdersByLastYear();
                    $results = $this->model_account_order->getOrders(($page - 1) * $limit, $limit, $period);
                }
                
               

		foreach ($results as $result) {
			$product_total = $this->model_account_order->getTotalOrderProductsByOrderId($result['order_id']);
			$voucher_total = $this->model_account_order->getTotalOrderVouchersByOrderId($result['order_id']);

			$ocstore_yk_onpay_info  = $this->model_extension_payment_ocstore_yk->checkLaterpay($result['order_id']);

                       $products = $this->model_account_order->getOrderProducts($result['order_id']);
                       $products_bag=[];
			foreach ($products as $product) {

				$product_info = $this->model_catalog_product->getProduct($product['product_id']);

                                if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], 30, 40);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 30, 40);
				}

				$products_bag[] = array(
					'image'     => $image,
					'href'=>$this->url->link('product/product', 'product_id=' . $product['product_id']),
				);
			}
                        

			$data['orders'][] = array(
				'order_id'   => $result['order_id'],
				'name'       => $result['firstname'] . ' ' . $result['lastname'],
				'status'     => $result['status'],
				'date_added' => date('d F Y H:i', strtotime($result['date_added'])),
				'products_count'   => ($product_total + $voucher_total),
				'total'      => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'ocstore_payeer_onpay'  => $this->model_extension_payment_ocstore_payeer->checkLaterpay($result['order_id']) ? $this->url->link('extension/payment/ocstore_payeer/laterpay', sprintf('order_id=%s&order_tt=%s', $result['order_id'], $result['total'], 'SSL')) : '',
				'ocstore_yk_onpay'      => $ocstore_yk_onpay_info['onpay'] ? $this->url->link('extension/payment/ocstore_yk/laterpay', sprintf('order_id=%s&order_ttl=%s&paymentType=%s', $result['order_id'], $result['total'], $ocstore_yk_onpay_info['payment_code']), 'SSL') : '',
				'view'       => $this->url->link('account/order/getInfo', 'order_id=' . $result['order_id'], true),
                                'products'=>$products_bag
			);
		}

		$pagination = new orderPagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
                if($period){
                    $pagination->url = $this->url->link('account/order/getList', 'page={page}&period='.$period, true);
                }else{
                    $pagination->url = $this->url->link('account/order/getList', 'page={page}', true);
                }
		

		$data['pagination'] = $pagination->render();

                //var_dump($data['pagination']);
                
		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($order_total - 10)) ? $order_total : ((($page - 1) * 10) + 10), $order_total, ceil($order_total / 10));

		

		return $this->load->view('account/order_list', $data);
	}

        
        public function getList() {
            $markup=$this->index();
            $json=array(
                'success'=> 1,
                'html'=>$markup
            );
            $this->response->setOutput(json_encode($json));
        }
        
	public function info() {
            
		$this->load->language('account/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

                $data['shopreview']=$this->load->controller('extension/module/shopreview/sudoindex');
                
		$this->load->model('account/order');

		$order_info = $this->model_account_order->getOrder($order_id);

		if ($order_info) {
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_account'),
				'href' => $this->url->link('account/account', '', true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('account/order', $url, true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_order'),
				'href' => $this->url->link('account/order/info', 'order_id=' . $this->request->get['order_id'] . $url, true)
			);

			$data['heading_title'] = $this->language->get('text_order');

			$data['text_order_detail'] = $this->language->get('text_order_detail');
			$data['text_invoice_no'] = $this->language->get('text_invoice_no');
			$data['text_order_id'] = $this->language->get('text_order_id');
			$data['text_date_added'] = $this->language->get('text_date_added');
			$data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$data['text_shipping_address'] = $this->language->get('text_shipping_address');
			$data['text_payment_method'] = $this->language->get('text_payment_method');
			$data['text_payment_address'] = $this->language->get('text_payment_address');
			$data['text_history'] = $this->language->get('text_history');
			$data['text_comment'] = $this->language->get('text_comment');
			$data['text_no_results'] = $this->language->get('text_no_results');

			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');
			$data['column_action'] = $this->language->get('column_action');
			$data['column_date_added'] = $this->language->get('column_date_added');
			$data['column_status'] = $this->language->get('column_status');
			$data['column_comment'] = $this->language->get('column_comment');

			$data['button_reorder'] = $this->language->get('button_reorder');
			$data['button_return'] = $this->language->get('button_return');
			$data['button_continue'] = $this->language->get('button_continue');
                        
                        $data['text_back_to_list'] = $this->language->get('text_back_to_list');
                        $data['text_one_thing'] = $this->language->get('text_one_thing');
                        $data['text_phone']=$this->language->get('text_phone');
                        $data['text_fio']=$this->language->get('text_fio');
                        $data['text_email'] =$this->language->get('text_email'); 
                        $data['text_title_status'] = $this->language->get('text_title_status');      
                        
                        
                        
			if (isset($this->session->data['error'])) {
				$data['error_warning'] = $this->session->data['error'];

				unset($this->session->data['error']);
			} else {
				$data['error_warning'] = '';
			}

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}

			if ($order_info['invoice_no']) {
				$data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$data['invoice_no'] = '';
			}

			$data['order_id'] = $this->request->get['order_id'];
			$data['date_added'] = date('d.m.Y H:i', strtotime($order_info['date_added']));
                        $data['shipping_address_1']=$order_info['shipping_address_1'];
                        
                        if($order_info['custom_field']){
                            $custom_ph= json_decode($order_info['custom_field']);
                        }else{
                             $custom_ph=[];
                        }
                        
                        foreach($custom_ph as $key => $value){
                            $custom_phone[$key] = $value;
                        }

                        if(isset($custom_phone['1'])){
                            $data['custom_phone'] = $custom_phone['1'];
                        }else{
                            $data['custom_phone'] = '';
                        }
                        
                        $data['user_fio']=$order_info['payment_firstname'].' '.$order_info['payment_lastname'];
                        $data['email']=$order_info['email'];

			if ($order_info['payment_address_format']) {
				$format = $order_info['payment_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname' => $order_info['payment_firstname'],
				'lastname'  => $order_info['payment_lastname'],
				'company'   => $order_info['payment_company'],
				'address_1' => $order_info['payment_address_1'],
				'address_2' => $order_info['payment_address_2'],
				'city'      => $order_info['payment_city'],
				'postcode'  => $order_info['payment_postcode'],
				'zone'      => $order_info['payment_zone'],
				'zone_code' => $order_info['payment_zone_code'],
				'country'   => $order_info['payment_country']
			);

			$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$data['payment_method'] = $order_info['payment_method'];

			if ($order_info['shipping_address_format']) {
				$format = $order_info['shipping_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{city} {postcode}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname' => $order_info['shipping_firstname'],
				'lastname'  => $order_info['shipping_lastname'],
				'company'   => $order_info['shipping_company'],
				'address_1' => $order_info['shipping_address_1'],
				'address_2' => $order_info['shipping_address_2'],
				'city'      => $order_info['shipping_city'],
				'postcode'  => $order_info['shipping_postcode'],
				'zone'      => $order_info['shipping_zone'],
				'zone_code' => $order_info['shipping_zone_code'],
				'country'   => $order_info['shipping_country']
			);

                        if($order_info['shipping_address_2']){
                            $data['shipping_address'] =  $order_info['shipping_address_2'];

                        }else{
                            $data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
                        }
			
                        $myquery=$this->db->query("SELECT name FROM ".DB_PREFIX."order_status WHERE order_status_id='".(int)$order_info['order_status_id']."' AND language_id=1");
                        
                        $data['order_status']=$myquery->row['name'];
                        
			$data['shipping_method'] = $order_info['shipping_method'];

			$this->load->model('catalog/product');
			$this->load->model('tool/upload');

			// Products
			$data['products'] = array();

			$products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);

			foreach ($products as $product) {
				$option_data = array();

				$options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

				foreach ($options as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$value = $upload_info['name'];
						} else {
							$value = '';
						}
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				$product_info = $this->model_catalog_product->getProduct($product['product_id']);

                                if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], 100, 100);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 100, 100);
				}
                                
				if ($product_info) {
					$reorder = $this->url->link('account/order/reorder', 'order_id=' . $order_id . '&order_product_id=' . $product['order_product_id'], true);
				} else {
					$reorder = '';
				}

				$data['products'][] = array(
					'name'     => $product['name'],
					'model'    => $product['model'],
                                        'thumb' =>$image,
                                        'sku'=>$product_info['sku'],
					'option'   => $option_data,
					'quantity' => $product['quantity'],
					'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'reorder'  => $reorder,
					'return'   => $this->url->link('account/return/add', 'order_id=' . $order_info['order_id'] . '&product_id=' . $product['product_id'], true)
				);
			}

			// Voucher
			$data['vouchers'] = array();

			$vouchers = $this->model_account_order->getOrderVouchers($this->request->get['order_id']);

			foreach ($vouchers as $voucher) {
				$data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}

			// Totals
			$data['totals'] = array();

			$totals = $this->model_account_order->getOrderTotals($this->request->get['order_id']);

			foreach ($totals as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
                                        'code' => $total['code']
				);
			}

			$data['comment'] = nl2br($order_info['comment']);

			// History
			$data['histories'] = array();

			$results = $this->model_account_order->getOrderHistories($this->request->get['order_id']);

			foreach ($results as $result) {
				$data['histories'][] = array(
					'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'status'     => $result['status'],
					'comment'    => $result['notify'] ? nl2br($result['comment']) : ''
				);
			}

			
			return $this->load->view('account/order_info', $data);
		} else {

			$data['heading_title'] = $this->language->get('text_order');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			return $this->load->view('error/not_found', $data);
		}
	}

        public function getInfo(){
              
            $markup=$this->info();
            $json=array(
                'success'=> 1,
                'html'=>$markup
            );
            $this->response->setOutput(json_encode($json));
       
        }
        
        
	public function reorder() {
		$this->load->language('account/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$this->load->model('account/order');

		$order_info = $this->model_account_order->getOrder($order_id);

		if ($order_info) {
			if (isset($this->request->get['order_product_id'])) {
				$order_product_id = $this->request->get['order_product_id'];
			} else {
				$order_product_id = 0;
			}

			$order_product_info = $this->model_account_order->getOrderProduct($order_id, $order_product_id);

			if ($order_product_info) {
				$this->load->model('catalog/product');

				$product_info = $this->model_catalog_product->getProduct($order_product_info['product_id']);

				if ($product_info) {
					$option_data = array();

					$order_options = $this->model_account_order->getOrderOptions($order_product_info['order_id'], $order_product_id);

					foreach ($order_options as $order_option) {
						if ($order_option['type'] == 'select' || $order_option['type'] == 'radio' || $order_option['type'] == 'image') {
							$option_data[$order_option['product_option_id']] = $order_option['product_option_value_id'];
						} elseif ($order_option['type'] == 'checkbox') {
							$option_data[$order_option['product_option_id']][] = $order_option['product_option_value_id'];
						} elseif ($order_option['type'] == 'text' || $order_option['type'] == 'textarea' || $order_option['type'] == 'date' || $order_option['type'] == 'datetime' || $order_option['type'] == 'time') {
							$option_data[$order_option['product_option_id']] = $order_option['value'];
						} elseif ($order_option['type'] == 'file') {
							$option_data[$order_option['product_option_id']] = $this->encryption->encrypt($order_option['value']);
						}
					}

					$this->cart->add($order_product_info['product_id'], $order_product_info['quantity'], $option_data);

					$this->session->data['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $product_info['product_id']), $product_info['name'], $this->url->link('checkout/cart'));

					unset($this->session->data['shipping_method']);
					unset($this->session->data['shipping_methods']);
					unset($this->session->data['payment_method']);
					unset($this->session->data['payment_methods']);
				} else {
					$this->session->data['error'] = sprintf($this->language->get('error_reorder'), $order_product_info['name']);
				}
			}
		}

		$this->response->redirect($this->url->link('account/order/info', 'order_id=' . $order_id));
	}
}