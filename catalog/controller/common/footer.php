<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');
                
                $data['og_url'] = (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')) ? HTTPS_SERVER : HTTP_SERVER) . substr($this->request->server['REQUEST_URI'], 1, (strlen($this->request->server['REQUEST_URI'])-1));
                $data['home'] = $this->url->link('common/home');
                
                if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
                
                if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

                $data['owner_moto_footer'] = $this->config->get('owner_description')[$this->config->get('config_language_id')]['moto_footer'];

                $data['second_block_title'] = $this->config->get('owner_description')[$this->config->get('config_language_id')]['second_block_title'];

				$data['second_block'] = $this->config->get('owner_description')[$this->config->get('config_language_id')]['second_block'];

                $data['phone1'] = $this->config->get('owner_phone1');
                $data['phone2'] = $this->config->get('owner_phone2');
                $data['phone3'] = $this->config->get('owner_phone3');
                $data['email'] = $this->config->get('owner_email');
                $data['skype'] = $this->config->get('owner_skype');
                $data['instagram'] = $this->config->get('config_instagram');
                $data['facebook'] = $this->config->get('config_facebook');
                $data['youtube'] = $this->config->get('config_youtube');
                $data['ok'] = $this->config->get('config_ok');
                $data['vk'] = $this->config->get('config_vk');
                
                $data['text_schedule'] =$this->language->get('text_schedule');
                $data['schedule'] =$this->config->get('owner_sсhedule');
                
                $data['text_useful_info'] =$this->language->get('text_useful_info');
                $data['link_to_articles_category']=$this->url->link('newsblog/category', 'newsblog_path=3');
                $data['text_articles']= $this->language->get('text_articles');
                $data['text_promotions']= $this->language->get('text_promotions');
                $data['promotions']= $this->url->link('features/promotions');
                
                $data['text_reviews']= $this->language->get('text_reviews');
                $data['text_our_public']= $this->language->get('text_our_public');
                $data['page_reviews']= $this->url->link('features/reviews');
                
                $data['scripts'] = $this->document->getScripts('footer');

		$data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		$data['text_email'] = $this->language->get('text_email');
		$name = $this->config->get('config_name');
                $data['name'] =$name;

		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			
				$data['informations'][$result['information_id']] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			
		}

		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', true);
		$data['sitemap'] = $this->url->link('information/sd_sitemap');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', true);
		$data['affiliate'] = $this->url->link('affiliate/account', '', true);
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', true);
		//$data['order'] = $this->url->link('account/order', '', true);
                $data['order'] = $this->url->link('account/account', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);

		$data['powered'] = $this->language->get('text_powered').date('Y', time())." $name";

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}
                       
                        
                        if($this->config->get('category_id')){
                            $promos=array_keys($this->config->get('active_promos_width_prod_ids'));
                     
                            if(in_array($this->config->get('category_id'), $promos)){
                                $promo_id=$this->config->get('category_id');
                                
                            }else{
                                $promo_id=0;
                            }
                            
                        }else{
                            $promo_id=0;
                        }
                        
                        

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer, $promo_id);
		}

		return $this->load->view('common/footer', $data);
	}
}
