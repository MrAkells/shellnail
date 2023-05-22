<?php
class ModelToolRemarketing extends Model {
 
	public function getRemarketingFooter() { 
		
		$output = '';
		
		$this->load->model('catalog/product');
		$this->load->model('checkout/order');	
		
		$route = !empty($this->request->get['route']) ? $this->request->get['route'] : '';
		$ecommerce_ga4_id = $this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? 'product_id' : 'model';
		  
		$total_value = 0;
		$ecommerce_currency = $this->config->get('remarketing_ecommerce_currency'); 
		
		switch ($route) {
			case '':			
			case 'common/home':	
				break;
			case 'product/category':
				break;
			case 'product/search':
			case 'product/special':
			case 'product/manufacturer/info':
				break;	
			case 'product/product':
				if (empty($this->request->get['product_id'])) return;
				$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
				if (!$product_info) return; 
				$product_price = $product_info['special'] ? $product_info['special'] : $product_info['price'];
				$price = $this->currency->format($this->tax->calculate($product_price, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'], '', false);
				$total_value = $price;
				$ecommerce_total = $this->currency->format($product_price, $ecommerce_currency, '', false);
				break;					
			case 'checkout/cart':
			case 'checkout/simplecheckout':
			case 'checkout/checkout':
			case 'checkout/unicheckout':
			case 'checkout/uni_checkout':
			case 'checkout/revcheckout':
			case 'revolution/revcheckout':
			case 'checkout/oct_fastorder':
			case 'checkout/onepcheckout':
			case 'checkout/buy':
			case 'extension/quickcheckout/checkout':
			case 'lightcheckout/checkout':
			case 'extension/module/custom':
				$ga4_products = [];
				
				$products = $this->cart->getProducts();
				$cart_json = [];
				
				if ($this->config->get('remarketing_ecommerce_status') || $this->config->get('remarketing_ecommerce_ga4_status') || $this->config->get('remarketing_ecommerce_ga4_measurement_status')) {
					$i = 1;
					foreach ($products as $product) {
						$product_info = $this->model_catalog_product->getProduct($product['product_id']);
						$categories = addslashes($this->getRemarketingCategories($product['product_id']));
						$ga4_categories = $this->getRemarketingCategoriesGa4($product['product_id']);
						
						$ga4_product = [
							'item_id'   => ($this->config->get('remarketing_ecommerce_ga4_id') == 'id') ? $product['product_id'] : $product['model'],
							'item_name' => addslashes($product['name']),
							'quantity' => $product['quantity'],
							'index'  => $i, 
							'price' => $this->currency->format($product['price'], $ecommerce_currency, '', false),
							'currency' => $ecommerce_currency
						];
						
						if (!empty($ga4_categories[0])) $ga4_product['item_category'] = $ga4_categories[0];
						if (!empty($ga4_categories[1])) $ga4_product['item_category2'] = $ga4_categories[1];
						if (!empty($ga4_categories[2])) $ga4_product['item_category3'] = $ga4_categories[2];
						if (!empty($ga4_categories[3])) $ga4_product['item_category4'] = $ga4_categories[3];
						
						if (!empty($product_info['manufacturer'])) $ga4_product['item_brand'] = $product_info['manufacturer'];
						$ga4_products[] = $ga4_product;
						$i++;
					}	
				}
				
				$output .= "<script>\n";
				$output .= "window.cart_products = " . json_encode($cart_json) . "\n";
				$output .= "</script>\n";
				
				$cart_total = $this->cart->getTotal();
				
				$total_value = $this->currency->format($cart_total, $this->session->data['currency'], '', false); 
				$ecommerce_total = $this->currency->format($cart_total * (float)$this->config->get('remarketing_ecommerce_ratio'), $ecommerce_currency, '', false); 
				
				if ($this->config->get('remarketing_ecommerce_status')) {
					$output .= '<script>' . "\n";
					$output .= 'window.dataLayer = window.dataLayer || [];' . "\n";
					$output .= 'dataLayer.push({ ecommerce: null });' . "\n";
					$output .= 'dataLayer.push({' . "\n";
					$output .= "'event': 'ga4_begin_checkout'," . "\n"; 
					$output .= "'ecommerce': {" . "\n";
					$output .= "'currency': '" . $ecommerce_currency . "',\n"; 
					$output .= "'value': " . $ecommerce_total . ",\n"; 
					$output .= "'items': " . json_encode($ga4_products) . "\n"; 
					$output .= '}});' . "\n</script>\n";
				}
				
				if ($this->config->get('remarketing_ecommerce_ga4_status')) {
					$output .= '<script>' . "\n";
					$output .= "if (typeof gtag != 'undefined') {" . "\n";
					$output .= 'gtag("event", "' . ($route != 'checkout/cart' ? 'begin_checkout' : 'view_cart') . '" , {'."\n";
					$output .= "'send_to': '" . $this->config->get('remarketing_ecommerce_ga4_identifier') . "',\n";
					$output .= "'currency': '" . $ecommerce_currency . "',\n";
					$output .= "'value': " . $ecommerce_total . ",\n"; 
					$output .= "'items': " . json_encode($ga4_products) ."\n";
					$output .= '})};' . "\n";
					$output .= '</script>' . "\n";
				}
		
				break;	
			case 'checkout/success':
			case 'extension/ocdevwizard/smart_order_success_page_pro': 
			case 'oneclick/success': 
				if (!empty($this->request->cookie['remarketing_order_id']) || !empty($this->session->data['order_id']) || !empty($this->session->data['remarketing_order_id'])) {
					if (!empty($this->request->cookie['remarketing_order_id'])) $remarketing_order_id = $this->request->cookie['remarketing_order_id'];
					if (!empty($this->session->data['order_id'])) $remarketing_order_id = $this->session->data['order_id'];
					if (!empty($this->session->data['remarketing_order_id'])) $remarketing_order_id = $this->session->data['remarketing_order_id'];
					$order_info = $this->getOrderRemarketing($remarketing_order_id);
					if ($order_info) {
 
						$total_value = $this->currency->format($order_info['total'], $this->session->data['currency'], '', false);
						$ecommerce_total = $order_info['ecommerce_total'];
						
						if ($this->config->get('remarketing_ecommerce_status')) {
							$output .= '<script>' . "\n";
							$output .= 'window.dataLayer = window.dataLayer || [];' . "\n";
							$output .= 'dataLayer.push({ ecommerce: null });' . "\n";
							$output .= 'dataLayer.push(' . json_encode($order_info['ga4_datalayer']) . ');' . "\n";
							$output .= '</script>' . "\n";  
						} 
						
						if ($this->config->get('remarketing_ecommerce_ga4_status')) {
							$output .= '<script>' . "\n";
							$output .= "if (typeof gtag != 'undefined') {" . "\n"; 
							$output .= 'gtag("event", "purchase", ' . json_encode($order_info['ga4_event']) . ');' . "\n";
							$output .= '}' . "\n";
							$output .= '</script>' . "\n";
						}
 
						$output .= "<script>console.log ('%c%s', 'color: green; font: 1.2rem/1 Tahoma;', 'order_sent');</script>";
					} 
					
					$this->setSuccessPage($remarketing_order_id);
					
				} else {
				}
				break;	 
			case 'error/not_found': 
				break;	
			default:
				break;
		}
		
		if ($this->config->get('remarketing_ecommerce_ga4_status') && $this->config->get('remarketing_ecommerce_ga4_selector')) {
			$output .= "<script>$(document).on('click touchstart', '" . $this->config->get('remarketing_ecommerce_ga4_selector') . "', function() {" . "\n";
			$output .= "if (typeof ecommerce_ga4_product_data !== 'undefined') {" . "\n";
			$output .= "item_id = $(this).find('.remarketing_cart_button').attr('data-product_id');" . "\n";
			$output .= '$(ecommerce_ga4_product_data).each(function(key, data) {' . "\n";
			$output .= "if (data['item_id'] == item_id) {" . "\n";
			$output .= "if (typeof ecommerce_ga4_product_data[key] !== 'undefined') {" . "\n";
			$output .= "if (typeof sendGa4Click !== 'undefined') {" . "\n";
			$output .= 'sendGa4Click(ecommerce_ga4_product_data[key]);' . "\n";
			$output .= '}}}})}});</script>' . "\n";
		}
		 
		return $output; 
	}
	
	public function remarketingAddToCart($product_info = [], $quantity = 1) {
		$json_data = [];
		if ($product_info) {
			$categories = $this->getRemarketingCategories($product_info['product_id']);
			$categories = addslashes($categories);
			$ga4_categories = $this->getRemarketingCategoriesGa4($product_info['product_id']);
			$json_data['ecommerce_status'] = $this->config->get('remarketing_ecommerce_status');
			$json_data['ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status');
			$current_price = $product_info['special'] ? $product_info['special'] : $product_info['price'];
			$ecommerce_price = $this->currency->format($current_price * (float)$this->config->get('remarketing_ecommerce_ratio'), $this->config->get('remarketing_ecommerce_currency'), '', false);
			$name = addslashes($product_info['name']);
			$ecommerce_currency = $this->config->get('remarketing_ecommerce_currency');
			
			$ecommerce_ga4_product = [
				'item_id' => $this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $product_info['product_id'] : $product_info['model'],
				'item_name' => $name, 
				'index' => 1,
				'price' => $ecommerce_price,
				'quantity' => $quantity
			];
			if (!empty($product_info['manufacturer'])) $ecommerce_ga4_product['item_brand'] = addslashes($product_info['manufacturer']);
			if (!empty($ga4_categories[0])) $ecommerce_ga4_product['item_category'] = addslashes($ga4_categories[0]);
			if (!empty($ga4_categories[1])) $ecommerce_ga4_product['item_category2'] = addslashes($ga4_categories[1]);
			if (!empty($ga4_categories[2])) $ecommerce_ga4_product['item_category3'] = addslashes($ga4_categories[2]);
			if (!empty($ga4_categories[3])) $ecommerce_ga4_product['item_category4'] = addslashes($ga4_categories[3]);
			
			$json_data['ecommerce_ga4_event'] = [
				'send_to' => $this->config->get('remarketing_ecommerce_ga4_identifier'),
				'currency' => $ecommerce_currency,
				'value' => $ecommerce_price * $quantity,
				'items' => [$ecommerce_ga4_product]
			];
			
			$json_data['ga4_datalayer'] = [
				'event' => 'ga4_add_to_cart',
				'ecommerce' => [
					'items' => [$ecommerce_ga4_product]
				]
			]; 
		}
		return $json_data;	 
	}
	
	public function remarketingRemoveFromCart($product_info = [], $quantity = 1) {
		$json_data = [];
		if ($product_info) {
			$ga4_categories = $this->getRemarketingCategoriesGa4($product_info['product_id']);
			$json_data['ecommerce_status'] = $this->config->get('remarketing_ecommerce_status');
			$json_data['ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status');
			$current_price = $product_info['special'] ? $product_info['special'] : $product_info['price'];
			$ecommerce_price = $this->currency->format($current_price * (float)$this->config->get('remarketing_ecommerce_ratio'), $this->config->get('remarketing_ecommerce_currency'), '', false);
			$ecommerce_currency = $this->config->get('remarketing_ecommerce_currency');
			 
			$ecommerce_ga4_product = [ 
				'item_id' => $this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $product_info['product_id'] : $product_info['model'],
				'item_name' => addslashes($product_info['name']),
				'index' => 1,
				'price' => $ecommerce_price,
				'quantity' => $quantity
			];
			if (!empty($product_info['manufacturer'])) $ecommerce_ga4_product['item_brand'] = addslashes($product_info['manufacturer']);
			if (!empty($ga4_categories[0])) $ecommerce_ga4_product['item_category'] = addslashes($ga4_categories[0]);
			if (!empty($ga4_categories[1])) $ecommerce_ga4_product['item_category2'] = addslashes($ga4_categories[1]);
			if (!empty($ga4_categories[2])) $ecommerce_ga4_product['item_category3'] = addslashes($ga4_categories[2]);
			if (!empty($ga4_categories[3])) $ecommerce_ga4_product['item_category4'] = addslashes($ga4_categories[3]);

			$json_data['ecommerce_ga4_event'] = [
				'send_to' => $this->config->get('remarketing_ecommerce_ga4_identifier'),
				'currency' => $ecommerce_currency,
				'items' => [$ecommerce_ga4_product]
			]; 
			
			$json_data['ga4_datalayer'] = [
				'event' => 'ga4_remove_from_cart',
				'ecommerce' => [
					'items' => [$ecommerce_ga4_product]
				] 
			]; 	
		}
		return $json_data;	
	}
	
	public function remarketingWishlist($product_info = []) {
		$json_data = [];
		if ($product_info) {
			$categories = $this->getRemarketingCategories($product_info['product_id']);
			$ga4_categories = $this->getRemarketingCategoriesGa4($product_info['product_id']);
			$json_data = [];
			$json_data['ecommerce_status'] = $this->config->get('remarketing_ecommerce_status');
			$json_data['ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status');

			$current_price = $product_info['special'] ? $product_info['special'] : $product_info['price'];
			$ecommerce_price = $this->currency->format($current_price * (float)$this->config->get('remarketing_ecommerce_ratio'), $this->config->get('remarketing_ecommerce_currency'), '', false);
			$brand = addslashes($product_info['manufacturer']);
			$name = addslashes($product_info['name']);
			$json_data['category'] = addslashes($categories);
			$quantity = 1; 
			$ecommerce_currency = $this->config->get('remarketing_ecommerce_currency');
			$json_data['ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status');

			$ecommerce_ga4_product = [
				'item_id' => $this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $product_info['product_id'] : $product_info['model'],
				'item_name' => $name,
				'index' => 1,
				'price' => $ecommerce_price,
				'quantity' => $quantity
			];
			if (!empty($brand)) $ecommerce_ga4_product['item_brand'] = $brand;
			if (!empty($ga4_categories[0])) $ecommerce_ga4_product['item_category'] = addslashes($ga4_categories[0]);
			if (!empty($ga4_categories[1])) $ecommerce_ga4_product['item_category2'] = addslashes($ga4_categories[1]);
			if (!empty($ga4_categories[2])) $ecommerce_ga4_product['item_category3'] = addslashes($ga4_categories[2]);
			if (!empty($ga4_categories[3])) $ecommerce_ga4_product['item_category4'] = addslashes($ga4_categories[3]);

			$json_data['ecommerce_ga4_event'] = [
				'send_to' => $this->config->get('remarketing_ecommerce_ga4_identifier'),
				'currency' => $ecommerce_currency,
				'items' => [$ecommerce_ga4_product]
			];
			
			$json_data['ga4_datalayer'] = [
				'event' => 'ga4_add_to_wishlist',
				'ecommerce' => [
					'items' => [$ecommerce_ga4_product]
				]
			]; 
		}
		return $json_data;	
	}
	
	public function getQuickOrderOpen($product_info) {
		$json = [];
		if ($product_info && $this->config->get('remarketing_status') && !$this->isBot()) {
			$json['remarketing'] = $this->remarketingAddToCart($product_info, $quantity = 1);
		}
		return $json; 
    } 
	
	public function getQuickOrderSuccess($order_id, $send_history = false) {
		$json['remarketing'] = [];
		$order_info = $this->getOrderRemarketing($order_id);
		if ($order_info) {
			$json['remarketing'] = [];
			$ecommerce_currency = $this->config->get('remarketing_ecommerce_currency');
			$num_items = 0;
			$json['remarketing']['ecommerce_status'] = $this->config->get('remarketing_ecommerce_status');
			$json['remarketing']['ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status');
			$json['remarketing']['ecommerce_ga4_identifier'] = $this->config->get('remarketing_ecommerce_ga4_identifier');
			
			$json['remarketing']['ga4_datalayer'] = $order_info['ga4_datalayer'];
			 
			$json['remarketing']['ga4_event'] = $order_info['ga4_event']; 
						
			if ($send_history) {
				$this->load->model('checkout/order'); 				
				$this->model_checkout_order->addOrderHistory($order_id, $order_info['order_status_id'], 'remarketing_quick_order');
			}
		}
		
		return $json['remarketing'];
    }

	
	public function isBot() {
		if (!empty($this->request->server['HTTP_USER_AGENT'])) {
			if (preg_match('/abacho|accona|AddThis|AdsBot|ahoy|AhrefsBot|AISearchBot|alexa|altavista|anthill|appie|applebot|arale|araneo|AraybOt|ariadne|arks|aspseek|ATN_Worldwide|Atomz|baiduspider|baidu|bbot|bingbot|bing|Bjaaland|BlackWidow|BotLink|bot|boxseabot|bspider|calif|CCBot|ChinaClaw|christcrawler|CMC\/0\.01|combine|confuzzledbot|contaxe|CoolBot|cosmos|crawler|crawlpaper|crawl|curl|cusco|cyberspyder|cydralspider|dataprovider|digger|DIIbot|DotBot|downloadexpress|DragonBot|DuckDuckBot|dwcp|EasouSpider|ebiness|ecollector|elfinbot|esculapio|ESI|esther|eStyle|Ezooms|facebookexternalhit|facebook|facebot|fastcrawler|FatBot|FDSE|FELIX IDE|fetch|fido|find|Firefly|fouineur|Freecrawl|froogle|gammaSpider|gazz|gcreep|geona|Getterrobo-Plus|girafabot|golem|googlebot|\-google|grabber|GrabNet|griffon|Gromit|gulliver|gulper|hambot|havIndex|hotwired|htdig|HTTrack|ia_archiver|iajabot|IDBot|Informant|InfoSeek|InfoSpiders|INGRID\/0\.1|inktomi|inspectorwww|Internet Cruiser Robot|irobot|Iron33|JBot|jcrawler|Jeeves|jobo|KDD\-Explorer|KIT\-Fireball|ko_yappo_robot|label\-grabber|larbin|legs|libwww-perl|linkedin|Linkidator|linkwalker|Lockon|logo_gif_crawler|Lycos|m2e|majesticsEO|marvin|mattie|mediafox|mediapartners|MerzScope|MindCrawler|MJ12bot|mod_pagespeed|speed|moget|Motor|msnbot|muncher|muninn|MuscatFerret|MwdSearch|NationalDirectory|naverbot|NEC\-MeshExplorer|NetcraftSurveyAgent|NetScoop|NetSeer|newscan\-online|nil|none|Nutch|ObjectsSearch|Occam|openstat.ru\/Bot|packrat|pageboy|ParaSite|patric|pegasus|perlcrawler|phpdig|piltdownman|Pimptrain|pingdom|pinterest|pjspider|PlumtreeWebAccessor|PortalBSpider|psbot|rambler|Raven|RHCS|RixBot|roadrunner|Robbie|robi|RoboCrawl|robofox|Scooter|Scrubby|Search\-AU|searchprocess|search|SemrushBot|Senrigan|seznambot|Shagseeker|sharp\-info\-agent|sift|SimBot|Site Valet|SiteSucker|skymob|SLCrawler\/2\.0|slurp|snooper|solbot|speedy|spider_monkey|SpiderBot\/1\.0|spiderline|spider|suke|tach_bw|TechBOT|TechnoratiSnoop|templeton|teoma|titin|topiclink|twitterbot|twitter|UdmSearch|Ukonline|UnwindFetchor|URL_Spider_SQL|urlck|urlresolver|Valkyrie libwww\-perl|verticrawl|Victoria|void\-bot|Voyager|VWbot_K|wapspider|WebBandit\/1\.0|webcatcher|WebCopier|WebFindBot|WebLeacher|WebMechanic|WebMoose|webquest|webreaper|webspider|webs|WebWalker|WebZip|whowhere|winona|wlm|WOLP|woriobot|WWWC|XGET|xing|yahoo|YandexBot|Lighthouse|lighthouse|YandexMobileBot|yandex|Chrome-Lighthouse|yeti|Zeus/i', $this->request->server['HTTP_USER_AGENT'])) {
				return true; 
			}
		}

		return false;
	}
	
	public function setSuccessPage($order_id) {
        if (!empty($order_id)) { 
			unset($this->session->data['remarketing_order_id']); 
			unset($this->session->data['order_id']); 
			setcookie('remarketing_order_id', $order_id, time() - 3600, '/');
			$this->db->query("UPDATE `" . DB_PREFIX . "remarketing_orders` SET `success_page` = NOW() WHERE order_id = '" . (int)$order_id . "'");
		}
    }
	
	public function setSend($order_id, $source) {
        if (!empty($order_id)) {
			$this->db->query("UPDATE `" . DB_PREFIX . "remarketing_orders` SET `" . $this->db->escape($source) . "` = NOW() WHERE order_id = '" . (int)$order_id . "'");
		}
    }
	
	public function getCid() {
		$cid = '';
        if (isset($this->request->cookie['_ga'])) {
			$cookie = explode('.', $this->request->cookie['_ga']);
			if (isset($cookie['2']) && isset($cookie['3'])) {
				$uuid = $cookie['2'] . '.' . $cookie['3'];
				$cid = $uuid;
			}
		} elseif (isset($this->request->cookie['__utma'])) {
			$cookie = explode('.', $this->request->cookie['__utma']);
			if (isset($cookie['1']) && isset($cookie['2'])) {
				$uuid = $cookie['1'] . '.' . $cookie['2'];
				$cid = $uuid;
			}
		} elseif (isset($this->request->cookie['remarketing_cid'])) {
			$cid = $this->request->cookie['remarketing_cid'];
		} else {
			$cid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',  mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),  mt_rand( 0, 0xffff ),  mt_rand( 0, 0x0fff ) | 0x4000,  mt_rand( 0, 0x3fff ) | 0x8000,  mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ));		
			setcookie('remarketing_cid', $cid, time() + 24 * 3600 * 30, '/');
		} 
		
		$this->session->data['uuid'] = $cid;
		
		$ga4_session_id = ''; 
		$cookie_name = '_ga_' . str_replace('G-', '', $this->config->get('remarketing_ecommerce_ga4_analytics_id'));
        if (isset($this->request->cookie[$cookie_name])) {
			$parts = explode('.', $this->request->cookie[$cookie_name]);
			if (isset($parts['2'])) {
				$ga4_session_id = $parts['2'];
				$this->session->data['ga4_uuid'] = $ga4_session_id;
			}
			setcookie('remarketing_ga4_cid', $ga4_session_id, time() + 24 * 3600 * 30, '/');
		} elseif (isset($this->request->cookie['remarketing_ga4_cid'])) {
			$ga4_session_id = $this->request->cookie['remarketing_ga4_cid'];
			$this->session->data['ga4_uuid'] = $ga4_session_id;
		} else {
			$ga4_session_id = $this->session->data['uuid'];
			$this->session->data['ga4_uuid'] = $ga4_session_id;
		} 
		
    }
	
	public function trackUtm() {
		
		$get_params = [
			'gclid',
			'dclid',
			'utm_source',
			'utm_campaign',
			'utm_term',
			'utm_medium',
			'utm_content',
			'ttclid'
		];
		
		foreach ($get_params as $get_param) {
			if (isset($this->request->get[$get_param])) {
				$this->session->data[$get_param] = $this->request->get[$get_param];
			}
		}
		
		if (isset($this->request->cookie['_fbp'])) {
			$this->session->data['fbp'] = $this->request->cookie['_fbp'];
		}

		if (isset($this->request->cookie['_fbc'])) {
			$this->session->data['fbc'] = $this->request->cookie['_fbc'];
		}
		
		if (isset($this->request->get['fbclid'])) {
			$this->session->data['fbc'] = 'fb' . '.' . '1' . '.' . time() . '.' . $this->request->get['fbclid'];
		}
 
		if ($this->config->get('remarketing_esputnik_status') && $this->customer->isLogged()) {
			if (empty($this->session->data['esputnik_email']) && $this->customer->getEmail()) {
				$this->session->data['esputnik_email'] = $this->customer->getEmail();
			}
			
			if (empty($this->session->data['esputnik_telephone']) && $this->customer->getTelephone()) {
				$this->session->data['esputnik_telephone'] = $this->customer->getTelephone();
			}
			
			if (empty($this->session->data['esputnik_uniq'])) {
				$this->session->data['esputnik_uniq'] = uniqid();
			}
		}
    }
	
	public function getRemarketingCategories($product_id) {
		$category_data = '';
		$category_query = $this->db->query("SELECT DISTINCT cd.name FROM `" . DB_PREFIX . "product_to_category` pc LEFT JOIN `" . DB_PREFIX . "category_description` cd ON pc.category_id = cd.category_id LEFT JOIN `" . DB_PREFIX . "category_path` cp ON pc.category_id = cp.category_id WHERE pc.product_id = '" . (int)$product_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY cp.level ASC LIMIT 5");
		foreach ($category_query->rows as $category) {
			$category_data .= $category['name'] . '/';
		}
		$category_data = rtrim($category_data, '/');
		return $category_data;
	}
	 
	public function getRemarketingCategoriesGa4($product_id) {
		$category_data = [];
		$category_query = $this->db->query("SELECT DISTINCT cd.name FROM `" . DB_PREFIX . "product_to_category` pc LEFT JOIN `" . DB_PREFIX . "category_description` cd ON pc.category_id = cd.category_id LEFT JOIN `" . DB_PREFIX . "category_path` cp ON pc.category_id = cp.category_id WHERE pc.product_id = '" . (int)$product_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY cp.level ASC LIMIT 5");
		foreach ($category_query->rows as $category) {
			$category_data[] = $category['name'];
		}
		return $category_data;
	}
	
	public function processCategory($category_info = [], $heading_title = '', $products = []) {

      $search_page = (!empty($this->request->get['route']) && $this->request->get['route'] == 'product/search' && !empty($this->request->get['search'])) ? true : false;
	  $output = '';
	  
	  if ($search_page) {
	      $google_page = 'view_search_results';
		  $data['view_search_results'] = true;
	  }

		if ($this->config->get('remarketing_ecommerce_status')) {
			$data['ecommerce_status'] = $this->config->get('remarketing_ecommerce_status');
			$data['ga4_datalayer'] = [];
			$data['measurement_status'] = $this->config->get('remarketing_ecommerce_measurement_status');
			$currency = $this->config->get('remarketing_ecommerce_currency');
			
			$ecommerce_ga4_products = [];
			
			$i = 0;
			foreach ($products as $remarketing_product) {
				$ecommerce_ga4_products[$i] = [];
				$ecommerce_ga4_products[$i]['item_name'] = addslashes($remarketing_product['name']);
				$ecommerce_ga4_products[$i]['item_id'] = ($this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $remarketing_product['product_id'] : $remarketing_product['model']);
				$ecommerce_ga4_products[$i]['price'] = $remarketing_product['ecommerce_price'];
				if (!empty($remarketing_product['manufacturer'])) $ecommerce_ga4_products[$i]['item_brand'] = addslashes($remarketing_product['manufacturer']);
				$ecommerce_ga4_products[$i]['item_list_name'] = addslashes($heading_title);
				$ecommerce_ga4_products[$i]['item_category'] = addslashes($heading_title);
				$ecommerce_ga4_products[$i]['index'] = $i+1;
				$ecommerce_ga4_products[$i]['quantity'] = 1; 
				$i++;
			}
			
			$data['ga4_datalayer'] = [
				'event' => 'ga4_view_item_list',
				'ecommerce' => [ 
					'items' => $ecommerce_ga4_products
				]
			]; 
		}
		 
		if ($this->config->get('remarketing_ecommerce_ga4_status') || $this->config->get('remarketing_ecommerce_ga4_measurement_status')) {
			$data['ecommerce_ga4_status'] = true;
			$data['ga4_json'] = [];
			
			$currency = $this->config->get('remarketing_ecommerce_currency');
			$i = 0;
			foreach ($products as $remarketing_product) {
				$data['ga4_json'][$i] = [];
				$data['ga4_json'][$i]['item_name'] = addslashes($remarketing_product['name']);
				$data['ga4_json'][$i]['item_id'] = ($this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $remarketing_product['product_id'] : $remarketing_product['model']);
				$data['ga4_json'][$i]['price'] = $remarketing_product['ecommerce_price'];
				if (!empty($remarketing_product['manufacturer'])) $data['ga4_json'][$i]['item_brand'] = addslashes($remarketing_product['manufacturer']);
				$data['ga4_json'][$i]['item_list_name'] = addslashes($heading_title);
				$data['ga4_json'][$i]['item_category'] = addslashes($heading_title);
				$data['ga4_json'][$i]['index'] = $i+1;
				$data['ga4_json'][$i]['quantity'] = 1;
				$i++;
			}

			$data['remarketing_ecommerce_ga4_selector'] = $this->config->get('remarketing_ecommerce_ga4_selector');
		}
		
		$data['remarketing_code'] = $this->load->view('extension/module/remarketing', $data);
		if (!empty($output)) { 
			$data['remarketing_code'] .= $output;
		}
		 
		return $data;
	}	
		
	public function processProduct($product_info = [], $category_info = []) {
		if (empty($product_info)) return [];
		$data = [];
		$output = '';
		$current_price = $product_info['special'] ? $product_info['special'] : $product_info['price'];
		$product_price = $this->currency->format($current_price, $this->session->data['currency'], '', false);
		$ecommerce_price = $this->currency->format($current_price, $this->config->get('remarketing_ecommerce_currency'), '', false);
		$ecommerce_product_id = ($this->config->get('remarketing_ecommerce_ga4_id') == 'id') ? $product_info['product_id'] : $product_info['model'];
		
		if ($this->config->get('remarketing_ecommerce_status') || $this->config->get('remarketing_ecommerce_ga4_status') || $this->config->get('remarketing_ecommerce_ga4_measurement_status')) {
			$ga4_categories = $this->getRemarketingCategoriesGa4($product_info['product_id']);
			$ecommerce_ga4_product = [
				'item_id' => $ecommerce_product_id,
				'item_name' => $product_info['name'], 
				'index' => 1, 
				'price' => $this->currency->format($product_info['special'] ? $product_info['special'] : $product_info['price'], $this->config->get('remarketing_ecommerce_currency'), '', false),
				'quantity' => 1
			];
			if (!empty($product_info['manufacturer'])) $ecommerce_ga4_product['item_brand'] = $product_info['manufacturer'];
			if (!empty($ga4_categories[0])) $ecommerce_ga4_product['item_category'] = $ecommerce_ga4_product['item_list_name'] = (!empty($category_info['name']) ? $category_info['name'] : addslashes($ga4_categories[0]));
			if (!empty($ga4_categories[1])) $ecommerce_ga4_product['item_category2'] = addslashes($ga4_categories[1]);
			if (!empty($ga4_categories[2])) $ecommerce_ga4_product['item_category3'] = addslashes($ga4_categories[2]);
			if (!empty($ga4_categories[3])) $ecommerce_ga4_product['item_category4'] = addslashes($ga4_categories[3]);
		}
		
		if ($this->config->get('remarketing_ecommerce_status')) {
			$data['ecommerce_product_json'] = [];
			$data['measurement_status'] = false;
			$data['ecommerce_status'] = true;  
			
			$data['ga4_datalayer'] = [ 
				'event' => 'ga4_view_item',
				'ecommerce' => [ 
					'items' => [$ecommerce_ga4_product]
				]
			]; 
		}
 
		if ($this->config->get('remarketing_ecommerce_ga4_status')) {
			$data['ga4_product'] = []; 
			$data['ecommerce_ga4_status'] = true;
			$data['measurement_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_measurement_status');
			$ecommerce_ga4_product['item_id'] = $this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			 
			$data['ga4_product'] = [ 
				'send_to' => $this->config->get('remarketing_ecommerce_ga4_identifier'),
				'currency' => $this->config->get('remarketing_ecommerce_currency'),
				'items' => [$ecommerce_ga4_product],
			];
		}
		
		$data['remarketing_code'] = $this->load->view('extension/module/remarketing', $data);
		if (!empty($output)) { 
			$data['remarketing_code'] .= $output;
		}
 
		return $data;	
	}
	
	public function getOrderRemarketing($order_id) {
		
		$this->load->model('catalog/product'); 
		$this->load->model('checkout/order'); 

        $order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");
        if ($order_query->num_rows) {
			$products = [];
			$ga4_products = [];
            $language_id = $order_query->row['language_id'];
            $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
			$i = 1;
            foreach ($order_product_query->rows as $product) {
                $option_data = '';
                $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");
                foreach ($order_option_query->rows as $option) {
                    if ($option['type'] != 'file') {
                        $option_data .= $option['name'] . ':' . $option['value'] . ';';
                    }
                }
                $option_data = rtrim($option_data, ';');
				
                if ($option_data) {
                    $variant = str_replace("\n", " ", addslashes($option_data));
                } else {
                    $variant = '';
                }

				$product_info = $this->model_catalog_product->getProduct($product['product_id']);
				
				$ga4_categories = $this->getRemarketingCategoriesGa4($product['product_id']);
				
                $products[] = [
                    'name'            => $product['name'],
                    'product_id'      => $product['product_id'],
                    'product_info'    => $product_info,
                    'sku'             => $product_info['sku'],
                    'model'           => $product['model'],
                    'category'        => $this->getRemarketingCategories($product['product_id']),
                    'variant'         => $variant,
                    'price'           => $this->currency->format($product['price'], $this->session->data['currency'], '', false),
                    'ecommerce_price' => $this->currency->format($product['price'] * (float)$this->config->get('remarketing_ecommerce_ratio'), $this->config->get('remarketing_ecommerce_currency'), '', false),
                    'quantity'        => $product['quantity']
                ];
				
				$ga4_products[] = [
					'item_id' => $this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $product['product_id'] : $product['model'],
					'item_name' => addslashes($product['name']),
					'item_brand' => !empty($product_info['manufacturer']) ? addslashes($product_info['manufacturer']) : '',
					'item_category'   => !empty($ga4_categories[0]) ? addslashes($ga4_categories[0]) : '',
                    'item_category2'  => !empty($ga4_categories[1]) ? addslashes($ga4_categories[1]) : '',
                    'item_category3'  => !empty($ga4_categories[2]) ? addslashes($ga4_categories[2]) : '',
                    'item_category4'  => !empty($ga4_categories[3]) ? addslashes($ga4_categories[3]) : '', 
                    'item_variant'  => $variant, 
                    'index'  => $i, 
                    'quantity'  => $product['quantity'], 
                    'price'  => $this->currency->format($product['price'] * (float)$this->config->get('remarketing_ecommerce_ratio'), $this->config->get('remarketing_ecommerce_currency'), '', false)
				];
				
				$i++; 
            }
			
			$shipping_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' AND code = 'shipping'");
			if ($shipping_query->rows) {
				$shipping = $shipping_query->row['value'];
			} else {
				$shipping = 0;
			}

			$tax_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' AND code = 'tax'");
			if ($tax_query->rows) {
				$tax = $tax_query->row['value'];
			} else {
				$tax = 0;
			}
			
			$coupon_query = $this->db->query("SELECT title FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' AND code = 'coupon'");
			if ($coupon_query->rows) {
				$coupon = $coupon_query->row['title'];
			} else {
				$coupon = false;
			}
			
			$order_info = $this->model_checkout_order->getOrder($order_query->row['order_id']);
			
			$ecommerce_total = $this->currency->format($order_query->row['total'] * (float)$this->config->get('remarketing_ecommerce_ratio'), $this->config->get('remarketing_ecommerce_currency'), '', false);
			
			$ga4_datalayer = [];
			$ga4_event = []; 
			
			$ga4_event = [
				'send_to' => $this->config->get('remarketing_ecommerce_ga4_identifier'),
				'transaction_id' => $order_info['order_id'],
				'value' => $ecommerce_total,
				'currency' => $this->config->get('remarketing_ecommerce_currency'),
				'affiliation' => addslashes($order_info['store_name']),
				'shipping' => $this->currency->format($shipping, $this->config->get('remarketing_ecommerce_currency'), '', false),
				'tax' => $this->currency->format($tax, $this->config->get('remarketing_ecommerce_currency'), '', false),
				'items' => $ga4_products
			];
 			if ($coupon) $ga4_event['coupon'] = $coupon;
			
			$ga4_datalayer = [
				'event' => 'ga4_purchase',
				'ecommerce' => $ga4_event
			]; 
			
			if ($order_info['shipping_method']) $ga4_datalayer['shipping_tier'] = $order_info['shipping_method'];
			if ($order_info['payment_method'])  $ga4_datalayer['payment_type'] = $order_info['payment_method'];
			unset($ga4_datalayer['ecommerce']['send_to']);
			
			$order_data = [
                'order_id'        => $order_query->row['order_id'],
                'store_name'      => addslashes($order_query->row['store_name']),
                'email'           => $order_query->row['email'],
                'telephone'       => $order_query->row['telephone'],
                'firstname'       => $order_query->row['firstname'],
                'lastname'        => $order_query->row['lastname'],
                'products'        => $products,
                'ga4_products'    => $ga4_products, 
                'order_info'      => $order_info,
                'total'           => $order_query->row['total'], 
                'default_total'   => $this->currency->format($order_query->row['total'], $this->session->data['currency'], '', false),
                'ecommerce_total' => $ecommerce_total,
				'shipping'        => $this->currency->format($shipping, $this->config->get('remarketing_ecommerce_currency'), '', false), 
				'tax'             => $this->currency->format($tax, $this->config->get('remarketing_ecommerce_currency'), '', false), 
				'coupon'          => $coupon, 
                'order_status_id' => $order_query->row['order_status_id'],
                'currency_code'   => $order_query->row['currency_code'],
                'ga4_event'       => $ga4_event,
                'ga4_datalayer'   => $ga4_datalayer,
            ];
			 
			$remarketing_check_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "remarketing_orders` WHERE order_id = '" . (int)$order_id . "'");
			$parameters = [
				'uuid', 'ga4_uuid', 'fbclid', 'fbc', 'fbp', 'gclid', 'dclid', 'utm_source', 'utm_campaign', 'utm_medium', 'utm_term', 'utm_content', 'ttclid' 
			]; 
			if (!$remarketing_check_query->num_rows) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "remarketing_orders` SET `order_id` = '" . (int)$order_id . "', `order_data` = '" . $this->db->escape(print_r($order_data, true)) . "', `date_added` = NOW()");
				
				foreach ($parameters as $parameter) {
					if (!empty($this->session->data[$parameter])) {
						$this->db->query("UPDATE `" . DB_PREFIX . "remarketing_orders` SET `" . $parameter . "` = '" . $this->db->escape($this->session->data[$parameter]) . "' WHERE order_id = '" . (int)$order_id . "'");
					}
				}
			}
			
			$remarketing_orders_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "remarketing_orders` WHERE `order_id` = '" . (int)$order_id . "'");
			
			$order_data['sent_data'] = [];
			
			if ($remarketing_orders_query->rows) {
				$order_data['sent_data'] = $remarketing_orders_query->row;
			}
			
			foreach($order_data['sent_data'] as $key => $val) {
				if (!empty($order_data['sent_data'][$key]) && in_array($key, $parameters)) {
					$this->session->data[$key] = $val; 
				}
			}
			
			if (empty($this->session->data['uuid'])) {
				$this->getCid();		
			} 

			return $order_data;
        } else {
            return false; 
        }  
    } 
}