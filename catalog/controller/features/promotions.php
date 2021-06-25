<?php
class ControllerFeaturesPromotions extends Controller {
	public function index() {
           
		$this->load->language('features/promotions');
                $this->load->model('catalog/promotions');
                $this->load->model('tool/image');

		$data['heading_title']=$this->language->get('heading_title');

                $this->document->setTitle($this->config->get('owner_description')[$this->config->get('config_language_id')]['promotions_meta_title']);
		$this->document->setDescription($this->config->get('owner_description')[$this->config->get('config_language_id')]['promotions_meta_description']);  
		$this->document->setKeywords($this->config->get('owner_description')[$this->config->get('config_language_id')]['promotions_meta_keywords']); 
                
                $data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
                );
                $data['breadcrumbs'][] = array(
			'text' => $data['heading_title'],
			'href' => $this->url->link('features/promotions')
		);
                $data['mini_catalog']=$this->load->controller('extension/module/menu', ['template'=>"extension/module/mini_menu_noindex"]);

                $promo_ids= $this->config->get('active_promos_width_prod_ids');
          
                $this->load->model('tool/online');
                
                $data['promotions']=array();
                
                foreach($promo_ids as $promo_id=>$valu){
//                 if($_SERVER['REMOTE_ADDR'] == '195.140.163.79' ){
//                     var_dump($valu['info'], $promo_id);
//                 }
                    if(isset($valu['info']) && isset($valu['info']['prparent']) && $valu['info']['prparent']){
                        continue;
                   }
                    $promotion=$this->model_catalog_promotions->getPromotion($promo_id, false);

                    $promotion_description = $this->model_catalog_promotions->getPromoDescription($promo_id);

                    if ($promotion['image']) {
			$image = $this->model_tool_image->resize($promotion['image'], 848, 326);
                    } else {
			$image = $this->model_tool_image->resize('placeholder.png', 848, 326);
                    }
                    if ($promotion['image_m']) {
			$image_m = $this->model_tool_image->resize($promotion['image_m'], 424, 326);
                    } else {
			$image_m = $this->model_tool_image->resize('placeholder.png', 424, 326);
                    }
                    $observers=$this->model_tool_online->getTotalCustomersOnline($promo_id);
       
                    $ends=strtotime($promotion['date_end']);
                    $date_end=date('d.m.Y',$ends);
                    $data['promotions'][]=array(
                        'promo_id'=>$promotion['promo_id'],
                        'title'=>$promotion_description ? $promotion_description['title'] : "",
                        'endtime'=> $ends,
                        'description'=> $promotion_description ? utf8_substr(strip_tags(html_entity_decode($promotion_description['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..' : '',
                        'date_end'=>$date_end,
                        'thumb'=>$image,
                        'thumb_m'=>$image_m,
                        'href'=>$this->url->link('product/category', 'category_id=' . $promotion['promo_id']),
                        'count'=>$promotion['products'],
                        'observers'=>$observers
                    );
                    
                }
                
		$data['column_left'] = $this->load->controller('common/column_left');
		//$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		$data['text_promo_product']=$this->language->get('text_promo_product');
		$data['text_look_over']=$this->language->get('text_look_over');
		$data['text_day']=$this->language->get('text_day');
		$data['text_hour']=$this->language->get('text_hour');
		$data['text_minute']=$this->language->get('text_minute');
		$data['text_second']=$this->language->get('text_second');
                $data['text_more_details']=$this->language->get('text_more_details');
                $data['text_promotion_until']=$this->language->get('text_promotion_until');

		$this->response->setOutput($this->load->view('features/promotions', $data));
		
	}

	public function promo() {
		
	}
}