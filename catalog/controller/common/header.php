<?php
class ControllerCommonHeader extends Controller {
	public function index() {

		// !!!!! Удалить после настройки Уа
		if((int)$this->config->get('config_language_id') == 3) $this->document->setNoindex(true);

		// Analytics
		$this->load->model('extension/extension');

		$data['language'] = $this->load->controller('common/language');

		$data['langcode'] = $this->session->data['language'];
             
		$data['analytics'] = array();

		$analytics = $this->model_extension_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get($analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('extension/analytics/' . $analytic['code'], $this->config->get($analytic['code'] . '_status'));
			}
		}

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		// noindex for issue 2
		if(isset($this->request->server['REQUEST_URI'])){
			$pattern = '/';
			$pattern .= '(account\/)|(affiliate\/)|(checkout\/)|(\/wishlist)|(product\/search)|(product\/compare)|(\/system)|(\/catalog)|(login\/)|(\/compare-products)|(\/cart\/)';
			$pattern .= '|(forgot-password\/)';
			$pattern .= '|(manufacturer_id)|(sort=)|(order=)|(limit=)|(filter=)|(filter_)|(tracking=)';
			$pattern .='/';
			if (preg_match($pattern, $this->request->server['REQUEST_URI'])) {
				$this->document->setNoindex(true);
			}
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}

		$data['title'] = $this->document->getTitle();

                // Обратный звонок
                //$this->document->addScript( "https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js");

		if(isset($this->session->data['user_id']) && $this->session->data['user_id']){
			$data['is_admin'] = 1;
		}else{
			$data['is_admin'] = 0;
		}
		
		if (!$this->customer->isLogged()) {
                    $this->document->addScript('https://ulogin.ru/js/ulogin.js');
                    $this->document->addScript('catalog/view/javascript/extension/ulogin.js');
                     // $this->document->addScript('catalog/view/javascript/extension/ulogin_local.js');
                    $this->document->addStyle('https://ulogin.ru/version/2.0/css/providers.min.css');
                    $this->document->addStyle('catalog/view/theme/default/stylesheet/extension/ulogin.css');
                }
                
                $this->document->addScript('catalog/view/javascript/popup_form/popup_form.js');
                $this->document->addScript('catalog/view/javascript/jquery.inputmask.bundle.min.js');
                $data['phone_call_back']=$this->load->controller('extension/module/popup_form');
                
                
                $data['static_header_catalog']=$this->load->controller('extension/module/menu', ['template'=>"extension/module/menu_noindex"]);
                
                //$data['static_header_catalog']='';
                
                $fake_menu=array(
                    "common/home",
                    "common/success",
                    "checkout/success",
                    "account/reset",
                    "account/login",
                    "information/information",
                    "account/logout",
                    "account/forgotten",
                    "features/promotions",
                    "features/reviews",
                    "newsblog/category",
                    "newsblog/article",
                    "product/product"
                );
                if(!in_array($this->request->get['route'],$fake_menu)){
                    $data['header_catalog']=$this->load->controller('extension/module/menu');
               
                }
                $data['route']=$this->request->get['route'];
		$data['base'] = $server;
                
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');
		$data['og_url'] = (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')) ? HTTPS_SERVER : HTTP_SERVER) . substr($this->request->server['REQUEST_URI'], 1, (strlen($this->request->server['REQUEST_URI'])-1));

		$data['og_image'] = $this->document->getOgImage();
		$data['json_ld'] = $this->document->getJsonLd();

		$data['text_home'] = $this->language->get('text_home');

		// Wishlist
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');

			$data['count_wishlist']=$this->model_account_wishlist->getTotalWishlist();
			
		} else {
			$data['count_wishlist']=isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0;
			
		
                        $data['login_form'] = $this->load->controller('account/modal');
                }
		$data['text_wishlist1'] = $this->language->get('text_wishlist1');
		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));

                if ($this->customer->isLogged()) {
                    $data['text_account'] =  $this->customer->getFirstName().' '.$this->customer->getLastName();
                }else{
                    $data['text_account'] = $this->language->get('text_account');
                }
		
              
                
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_page'] = $this->language->get('text_page');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');
		$data['text_order_by_telephon'] = $this->language->get('text_order_by_telephon');
		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		$data['contact'] = $this->url->link('information/information', 'information_id=12');
		$data['telephone'] = $this->config->get('config_telephone');
                
                $data['text_contact'] = $this->language->get('text_contact');
                $data['text_category_catalog'] = $this->language->get('text_category_catalog');
                
                
                $data['payment_and_delivery']=array(
                    'text'=>$this->language->get('text_payment_and_delivery'),
                    'href'=>$this->url->link('information/information', '&information_id=6')
                );
                
                $data['shop_reviews']=array(
                    'text'=>$this->language->get('text_reviews'),
                    'href'=>$this->url->link('features/reviews')
                );
               
                $data['promotions']=array(
                    'text'=>$this->language->get('text_promotions'),
                    'href'=>$this->url->link('features/promotions')
                );
                
                $data['articles']=array(
                    'text'=>$this->language->get('text_articles'),
                    'href'=>$this->url->link('newsblog/category', 'newsblog_path=3')
                );
                
                $data['for_buyers']=array(
                    'text'=>$this->language->get('text_for_buyers'),
                     'href'=>$this->url->link('information/information', '&information_id=11')
                );

                $this->load->model('catalog/information');
                $information = $this->model_catalog_information->getInformation(7);
              
                $data['return_product']=array(
                    'text'=>$information['title'],
                    'href'=>$this->url->link('information/information', '&information_id=7')
                );
                
                $information = $this->model_catalog_information->getInformation(15);
              
                 $data['user_agreement']=array(
                    'text'=>$information['title'],
                    'href'=>$this->url->link('information/information', '&information_id=15')
                );
                
                
                $data['shop_feature']=$this->config->get('owner_description')[$this->config->get('config_language_id')]['moto'];

				//$data['shop_feature'] = $this->language->get('shop_feature');
                
                
                $data['phone1']=$this->config->get('owner_phone1');
                $data['phone2']=$this->config->get('owner_phone2');
                $data['phone3']=$this->config->get('owner_phone3');
                $data['shop_email']=$this->config->get('owner_email');
                
                $data['text_schedule']=$this->language->get('text_schedule');
                $data['schedule']=$this->config->get('owner_sсhedule');
                $data['skype']=$this->config->get('owner_skype');
                
               $data['compare']=array(
                   'text'=> $this->language->get('button_compare'),
                   'href'=>$this->url->link('product/compare'),
                   'total'=>isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0
               );
		
		$this->load->model('catalog/product');
                
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');

		$data['version_stylesheet_css'] = filemtime(DIR_APPLICATION  . 'view/theme/default/stylesheet/stylesheet.css');
	
  
		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} elseif (isset($this->request->get['information_id'])) {
				$class = '-' . $this->request->get['information_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

		if (!isset($this->request->get['route']) || $this->request->get['route'] == 'common/home'){
			$data['ishome']=1;
		}

		$data['is_product'] = isset($this->request->get['route']) && $this->request->get['route'] == 'product/product';

		return $this->load->view('common/header', $data);
	}
}
