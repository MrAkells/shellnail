<?php
class ControllerCheckoutInter extends Controller {
    
    public function index() {
        
        $this->load->language('checkout/shipping');
       
        $data['text_empty']=$this->language->get('text_empty');
        $data['comment_value']='';
     
        $data['text_international']=$this->language->get('text_international');
        $data['text_input_international']=$this->language->get('text_input_international');

        return $this->load->view('checkout/inter', $data);
	
    } 
    
    public function setComment(){
        $office=$this->request->get['comment'];
        
        if($this->request->server['REQUEST_METHOD'] == 'POST'){
            $this->session->data['inter_comment']=$office;
            $this->response->setOutput(json_encode(['success'=>true]));
        }else{
            $this->response->setOutput(json_encode(['success'=>false]));
        }
    }
}


