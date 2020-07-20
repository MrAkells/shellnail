<?php
class ControllerFeaturesGroup extends Controller {
	public function index($input_data) {
            
                $promo_id =$input_data['promo_id'];
		$this->load->language('features/group');
                $this->load->model('catalog/promotions');
                $this->load->model('tool/image');
                $this->document->addStyle('catalog/view/theme/default/stylesheet/group_promo.css?ver1.6');
 
		$data['heading_title']=$this->language->get('heading_title');
                
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

                $this->load->model('tool/online');
                
                $super_promotion=$this->model_catalog_promotions->getPromotion($promo_id);
                $this->document->setTitle($super_promotion['meta_title']);
		$this->document->setDescription($super_promotion['meta_description']);  
		$this->document->setKeywords($super_promotion['meta_keywords']); 
                
                if(isset($super_promotion['meta_h1'])){
                    $data['title'] = $super_promotion['meta_h1'];
                }else{
                    $data['title'] = $super_promotion['title'];
                }
               
                $data['description']= html_entity_decode($super_promotion['description'], ENT_QUOTES, 'UTF-8');
                if ($super_promotion['image']) {
                    $main_image = $this->model_tool_image->resize($super_promotion['image'], 861, 331);
                } else {
                    $main_image = $this->model_tool_image->resize('placeholder.png', 861, 331);
                }
                $data['main_thumb']=$main_image;
                       

                $data['promotions']=array();
                
                $promo_group = $this->model_catalog_promotions->getGroup($promo_id);
                foreach($promo_group as $promo_id){
                    $promotion=$this->model_catalog_promotions->getPromotion($promo_id, false);
                    if ($promotion['image']) {
			$image = $this->model_tool_image->resize($promotion['image'], 861, 331);
                    } else {
			$image = $this->model_tool_image->resize('placeholder.png', 861, 331);
                    }

                    $observers=$this->model_tool_online->getTotalCustomersOnline($promo_id);
       
                    $ends=strtotime($promotion['date_end']);
                    $date_end=date('d.m.Y',$ends);
                    $data['promotions'][]=array(
                        'promo_id'=>$promotion['promo_id'],
                        'title'=>$promotion['title'],
                        'endtime'=> $ends,
                        'description'=> utf8_substr(strip_tags(html_entity_decode($promotion['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
                        'date_end'=>$date_end,
                        'thumb'=>$image,
                        'href'=>$this->url->link('product/category', 'category_id=' . $promotion['promo_id']),
                        'count'=>$promotion['products'],
                        'observers'=>$observers
                    );
                    
                }
                
		//$data['column_left'] = $this->load->controller('common/column_left');
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
                
                
		$this->response->setOutput($this->load->view('features/group_list', $data));
		
	}

	
}