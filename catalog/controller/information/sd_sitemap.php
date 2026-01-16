<?php
class ControllerInformationSdSitemap extends Controller {
	public function index() {
		$this->load->language('information/sitemap');
		$this->load->model('catalog/information');

		$information_info = array();
		if ($this->config->get('config_sitemap_id')) {
			$information_info = $this->model_catalog_information->getInformation((int)$this->config->get('config_sitemap_id'));
		}

		if ($information_info) {
			$this->document->setTitle($information_info['meta_title'] ? $information_info['meta_title'] : $information_info['title']);
			$this->document->setDescription((mb_detect_encoding($information_info['meta_description']) == 'UTF-8' ? $information_info['meta_description'] : mb_convert_encoding($information_info['meta_description'], 'utf-8', "HTML-ENTITIES")));
			$data['heading_title'] = $information_info['meta_h1'] ? $information_info['meta_h1'] : $information_info['title'];
		} else {
			$this->document->setTitle($this->language->get('text_title'));
			$this->document->setDescription($this->language->get('text_description'));
			$data['heading_title'] = $this->language->get('heading_title');
		}
		$this->document->addLink($this->url->link('information/sitemap'), 'canonical');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $data['heading_title'],
			'href' => $this->url->link('information/sitemap')
		);

		if (!isset($data['heading_title'])) {
			$data['heading_title'] = $this->language->get('heading_title');
		}

		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_password'] = $this->language->get('text_password');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_history'] = $this->language->get('text_history');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_cart'] = $this->language->get('text_cart');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_search'] = $this->language->get('text_search');
		$data['text_information'] = $this->language->get('text_information');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_reviews'] = $this->language->get('text_reviews');
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$this->load->model('catalog/sd_sitemap');
		$limit = 150;
		$filter_data = array(
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		);
		$sitemap_total = $this->model_catalog_sd_sitemap->getTotal();
		$data['categories'] =$this->model_catalog_sd_sitemap->get($filter_data);

		$data['special'] = $this->url->link('product/special');
		$data['search'] = $this->url->link('product/search');
		$data['contact'] = $this->url->link('information/contact');
		$data['reviews'] = $this->url->link('features/reviews');
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);

		$data['informations'] = array();
		$sitemap_id = (int)$this->config->get('config_sitemap_id');

		foreach ($this->model_catalog_information->getInformations() as $result) {
			$href = $this->url->link('information/information', 'information_id=' . $result['information_id']);

			if ($sitemap_id && (int)$result['information_id'] === $sitemap_id) {
				$href = $this->url->link('information/sitemap');
			}

			$data['informations'][] = array(
				'title' => $result['title'],
				'href'  => $href
			);
		}

		$pagination = new Pagination();
		$pagination->total = $sitemap_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('information/sd_sitemap', 'page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($sitemap_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($sitemap_total - $limit)) ? $sitemap_total : ((($page - 1) * $limit) + $limit), $sitemap_total, ceil($sitemap_total / $limit));
		$data['page_last'] = (ceil($sitemap_total / $limit) <= $page ? true: false);

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('information/sd_sitemap', $data));
	}

	// update sitemap
	public function update_base()
	{            
		$time_start = time();

		$this->load->model('catalog/category');
		$this->load->model('catalog/sd_sitemap');
		$this->load->model('catalog/dvfilter');
		$this->load->model('extension/module/page_no_index');

		if (isset($_GET['auth']) && $_GET['auth'] == '2020')
		{
			$this->model_catalog_sd_sitemap->init();
			$this->updateTable(1);
			$this->updateTable(3);
				// if(isset($categories_1[$category_id + 1])){
				// 	$this->model_catalog_sd_sitemap->editSetting('sd_sitemap',['sd_sitemap_id'=>$category_id + 1,'sd_sitemap_status'=>0]);
				// } else {
				// 	$this->model_catalog_sd_sitemap->editSetting('sd_sitemap',['sd_sitemap_id'=>0,'sd_sitemap_status'=>3]);	
				// }
			if($this->config->get('sd_pni_status')){
				$this->model_catalog_sd_sitemap->delRowsNoIndex();
			}	
				echo ' time ' . (time() - $time_start);
		}
	}

	private function updateTable($language_id = 1) {
		$base_url = $this->url->link('common/home');

		$this->config->set('config_language_id', $language_id);
		$categories_1 = $this->model_catalog_category->getCategories(0);
		// echo $this->config->get('sd_sitemap_id') . ' ' . $this->config->get('sd_sitemap_status');
		// $status = $this->config->get('sd_sitemap_status');
		// if($status == 2){
		
		// 	$category_id = 0;
		// } else if($status == 3){
		// 	echo 'sitemap greated sus';
		// 	return;
		// } else{
		// 	$category_id = $this->config->get('sd_sitemap_id');
		// 	$this->model_catalog_sd_sitemap->editSetting('sd_sitemap',['sd_sitemap_status'=>2]);	
		// }
		foreach ($categories_1 as $category_1) {

		//$category_1 = $categories_1[$category_id];

			$data = [
				'category_id' => $category_1['category_id'],
				'name' => $category_1['name'],
				'meta_h1' => $category_1['meta_h1'],
				'href' => $this->fixUrl($this->url->link('product/category', 'path=' . $category_1['category_id']), $base_url, $language_id),
				'level' => 1,
			];
			
			$this->model_catalog_sd_sitemap->add($data);

			$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);

			foreach ($categories_2 as $category_2) {
				$data_2 = [
					'category_id' => $category_2['category_id'],
					'name' => $category_2['name'],
					'meta_h1' => $category_2['meta_h1'],
					'href' => $this->fixUrl($this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id']), $base_url, $language_id),
					'level' => 2,
				];
				$this->model_catalog_sd_sitemap->add($data_2);
				$this->addFiltrOptions($data_2);
				$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);

				foreach ($categories_3 as $category_3) {
					$data_3 = [
						'category_id' => $category_3['category_id'],
						'name' => $category_3['name'],
						'meta_h1' => $category_3['meta_h1'],
						'href' => $this->fixUrl($this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'] . '_' . $category_3['category_id']), $base_url, $language_id),
						'level' => 2,
					];
					$this->model_catalog_sd_sitemap->add($data_3);
					$this->addFiltrOptions($data_3);
				}

			}
			$this->addFiltrOptions($data);
		}
	}

	private function fixUrl($url, $base_url,$language_id) {
		if($language_id > 1){
			$url = str_replace($base_url, $base_url. 'ua/', $url);
		}
		return $url;
	}

	// category + dvfilter options
	private function addFiltrOptions($data) {
		$level =$data['level'] + 1;
		$cat_href = mb_substr($data['href'], 0, -1);
		$cat_name = $data['meta_h1'] . ' ';
		$filter_data = array(
			'filter_category_id' => $data['category_id'],
			'filter_dvfilter' => ''
		);
		$counters = $this->model_catalog_dvfilter->getCounters($filter_data);

		$manufacturers = $this->model_catalog_dvfilter->getManufacturersByCategoryId($data['category_id']);
		$options = $this->model_catalog_dvfilter->getDVFilterOptionsByCategoryId($data['category_id']);

		$options = $this->checkOptions($options,$counters);

		$m_level = $level + 1;
		$rows = [];
		foreach ($manufacturers as $manufacturer) {
			$cat_manufacture_name = $cat_name . $manufacturer['name'];
			$cat_manufacture_href = $cat_href . '_' . $manufacturer['keyword'];

			if (isset($counters['m' . $manufacturer['value_id']])) {
				$href = $cat_manufacture_href . '/';

				// Добавляем в sitemap только если URL явно разрешён
				if ($this->model_extension_module_page_no_index->isUrlIndexAllowed($href)) {
					$rows[] = [
						'name'  => $cat_manufacture_name,
						'href'  => $href,
						'level' => $level,
					];
				}

				// Дальнейшая логика с $filter_data и т.п. оставляем как есть
				$filter_data = array(
					'filter_category_id' => $data['category_id'],
					//'filter_manufacturer_id' => $manufacturer['value_id'],
					'filter_dvfilter'    => 'm:' . $manufacturer['value_id']
				);
				$c_m_counters = $this->model_catalog_dvfilter->getCounters($filter_data);

				//$rows = array_merge($rows, $this->addOptions($this->checkOptions($options,$c_m_counters),$cat_manufacture_name .' ,',$cat_manufacture_href,$m_level));
				//$this->addOptions($this->checkOptions($options,$c_m_counters),$cat_manufacture_name .' ,',$cat_manufacture_href,$m_level);
			}
		
		}
		$rows = array_merge($rows,$this->addOptions($options,$cat_name. ' ',$cat_href,$level,$data['category_id'],0,1));
		if($rows) $this->model_catalog_sd_sitemap->addRows($rows);
		
	}
	private function checkOptions($options, $counters){
		$opt = [];
		foreach ($options as $key_opt => $option) {
			$opt_values = [];
			if(!isset($counters[$option['option_id'].'all'])){
				continue;
			}
			foreach ($option['values'] as $key_val => $value) {
				if(isset($counters[$option['option_id'].$value['value_id']])){
					$opt_values[] = $value;
				}
			}
			if($opt_values){
				$option['values'] = $opt_values;
				$opt[$key_opt] = $option;
			} 
		}
		return $opt;
	}

	private function addOptions($options, $name, $href, $level, $category_id = 0, $option_id = 0, $type = 0) {
		$insert_rows = [];
		foreach ($options as $key_opt => $option) {
			if($option_id != $option['option_id']){
				$cat_option_name = $name . $option['name'] . ' ';
				$cat_option_href = $href . '_' . $option['keyword']. '_';
			} else {
				continue;
				$cat_option_name = $name;
				$cat_option_href = $href. '_';
			}
            foreach ($option['values'] as $key_val => $value) {

				//if(isset($counters[$option['option_id'].$value['value_id']])){
					$href = $cat_option_href . $value['keyword'] . '/';

					// Добавляем только если URL разрешён в Page No Index
					if ($this->model_extension_module_page_no_index->isUrlIndexAllowed($href)) {
						$insert_rows[] = [
							'name'  => $cat_option_name . $value['name'],
							'href'  => $href,
							'level' => $level,
						];
					}

					unset($options[$key_opt]['values'][$key_val]);
					// if($type) {
					// 	if($option_id != $option['option_id']){
					// 		$filter_data = array(
					// 			'filter_category_id' => $category_id,
					// 			'filter_dvfilter' => $option['option_id'].':'. $value['value_id']
					// 		);
					// 		$c_o_counters = $this->model_catalog_dvfilter->getCounters($filter_data);
					// 		$insert_rows = array_merge($insert_rows,$this->addOptions($this->checkOptions($options,$c_o_counters),$cat_option_name  . $value['name'] . ', ',$cat_option_href . $value['keyword'], $level + 1,0,$option['option_id']));
					// 	} else{
					// 		$insert_rows = array_merge($insert_rows,$this->addOptions($options,$cat_option_name  . $value['name'] . ', ',$cat_option_href . $value['keyword'], $level + 1,0,$option['option_id']));
					// 	}
						
					// }
				//}
				//unset($options[$key_opt]['values'][$key_val]);
			}
			unset($options[$key_opt]);
		}
		//if($insert_rows) $this->model_catalog_sd_sitemap->addRows($insert_rows);
		return $insert_rows;
	}
}
