<?php
class ControllerFeaturesReviews extends Controller {
	public function index() {
		$this->load->language('features/reviews');

		$this->load->model('extension/module/shopreview');
		
		$data['review_total'] = $this->model_extension_module_shopreview->getTotalReviews();
		$this->document->setTitle($this->config->get('shopreview_meta_title'));
		$this->document->setDescription($this->config->get('shopreview_meta_description'));  
		$this->document->setKeywords($this->config->get('shopreview_meta_keywords')); 
		
		$data['heading_title']=$this->language->get('heading_title');

		$data['text_reviews']=$this->language->get('text_reviews');
		$data['text_ourreviews']=$this->language->get('text_ourreviews');

		$data['text_greetings']=$this->language->get('text_greetings');
		$data['text_you_can_rate']=$this->language->get('text_you_can_rate');

                
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_ourreviews'),
			'href' => $this->url->link('features/reviews')
		);
        $data['mini_catalog']=$this->load->controller('extension/module/menu', ['template'=>"extension/module/mini_menu_noindex"]);
        
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('features/reviews', $data));
		
	}

}