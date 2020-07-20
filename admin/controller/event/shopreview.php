<?php
class ControllerEventShopReview extends Controller {
  
    public function index(&$route, &$data, &$output){
      $this->load->language('catalog/shopreview');
      $this->load->model('catalog/shopreview');
      
      $openShopreviews=$this->model_catalog_shopreview->getTotalReviewsAwaitingApproval();
      
      $data['text_shopreviews']=$this->language->get('heading_title');
      $data['shopreviews_total']=$openShopreviews;
      
      	if(isset( $data['alerts'])){
            $data['alerts']=$openShopreviews+$data['alerts'];
            $data['shopreviews']=$this->url->link('catalog/shopreview', 'token=' . $this->session->data['token'], true);
	}
      
    }
    
}
