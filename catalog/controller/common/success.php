<?php
class ControllerCommonSuccess extends Controller {
	public function index($passed_data=[]) {
		
                $this->load->language('common/success');
           
                if(isset($passed_data['heading_title'])){
                    $data['heading_title'] = $passed_data['heading_title'];
                }else{
                    $data['heading_title'] = $this->language->get('heading_title');
                }
    
                if(isset($this->session->data['success'])){
                    $data['success']=$this->session->data['success'];
                    $this->session->data['success']='';
                }else{
                    $data['success']='';
                }
                
                
		$this->document->setTitle($data['heading_title']);

                if(isset($passed_data['breadcrumbs'])){
                    $data['breadcrumbs'] = $passed_data['breadcrumbs'];
                }else{
                    $data['breadcrumbs'] = array();

                    $data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
                    );
                }
		
                if(isset($passed_data['text_message'])){
                    $data['text_message'] = $passed_data['text_message'];
                }else{
                    $data['text_message'] = $this->language->get('text_message');
                }
		
                if(isset($passed_data['button_continue'])){
                    $data['button_continue'] = $passed_data['button_continue'];
                }else{
                    $data['button_continue'] = $this->language->get('button_continue');
                }
		
                if(isset($passed_data['continue'])){
                    $data['continue'] = $passed_data['continue'];
                }else{
                    $data['continue'] = '/';
                }

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		return $this->load->view('common/success', $data);
	}
}