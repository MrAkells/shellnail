<?php
class ControllerCheckoutNewMail extends Controller {
    
    public function index() {
        
        $this->load->language('checkout/shipping');
        $this->load->model('extension/shipping/new_mail');
        
        $data=array();
        
//        $data['areas']=$this->model_extension_shipping_new_mail->getAreas();
//       
//        if(isset($this->session->data['checkout_new_mail_area']) && $this->session->data['checkout_new_mail_area']){
//            $data['new_mail_area']=$this->session->data['checkout_new_mail_area'];
//        }else{
//            $data['new_mail_area']=0;
//        }
        
//        if($data['new_mail_area']){
//            $data['cities']=$this->model_extension_shipping_new_mail->getCities($data['new_mail_area']);
//            if(isset($this->session->data['checkout_new_mail_city'])){
//                $data['new_mail_city']= $this->session->data['checkout_new_mail_city'];
//            }else{
//                $data['new_mail_city']=0;
//            }
//        }
//        
//        if(isset($data['new_mail_city']) && isset($data['new_mail_area'])){
//            $data['offices']=$this->model_extension_shipping_new_mail->getOffices($data['new_mail_city']);
//            if(isset($this->session->data['checkout_new_mail_office'])){
//                $data['new_mail_office']= $this->session->data['checkout_new_mail_office'];
//            }else{
//                $data['new_mail_office']=0;
//            }
//        }
        
        $data['is_valid_city']=false;
        $data['city']='';
        $data['offices']=[];
        $data['choosen_office']=false;
        
        if(isset($this->session->data['payment_address']['city'])){
            $city=$this->session->data['payment_address']['city'];
            $cities=$this->model_extension_shipping_new_mail->checkCity($city);
           
            $is_valid_city=count($cities)==1;
            $data['is_valid_city']=$is_valid_city;
            
            if($is_valid_city){
               $city = $cities[0]['name_ru'];
               $city_ref=$cities[0]['city_ref'];
               $data['offices']=$this->model_extension_shipping_new_mail->getOffices($city_ref);
            }
            $data['city']=$city;
        }
        
        
        $data['text_empty']=$this->language->get('text_empty');
        $data['text_region']=$this->language->get('text_region');
        $data['text_city']=$this->language->get('text_city');
        $data['text_office']=$this->language->get('text_office');
        $data['text_choose']=$this->language->get('text_choose');
        
        return $this->load->view('checkout/new_mail', $data);
	
    } 
    
    public function getCities(){
        
        if($this->request->server['REQUEST_METHOD']=='POST'){
            
            $this->load->model('extension/shipping/new_mail');
        
            $ref=$this->request->get['ref'];
        
            $cities=$this->model_extension_shipping_new_mail->getCities($ref);
        
            $this->response->setOutput(json_encode($cities));
            
        }
       
    }
    
    public function setArea(){
         if($this->request->server['REQUEST_METHOD']=='POST'){
            
            $ref=$this->request->get['ref'];
            $this->session->data['checkout_new_mail_area']=$ref;
            $this->session->data['checkout_new_mail_city']=0;
            $this->session->data['checkout_new_mail_office']=0;
                
            $this->response->setOutput(json_encode(['success'=>1]));
            
        }
    }
    
    public function setCity(){
         if($this->request->server['REQUEST_METHOD']=='POST'){
            
            $ref=$this->request->get['ref'];
            $this->session->data['checkout_new_mail_city']=$ref;
            $this->session->data['checkout_new_mail_office']=0;
                
            $this->response->setOutput(json_encode(['success'=>1]));
            
        }
    }
    
    public function setOffice(){
        $office= htmlspecialchars_decode($this->request->get['office']);
        if($this->request->server['REQUEST_METHOD'] == 'POST'){
            $this->session->data['newmail_office']=$office;
            $this->response->setOutput(json_encode(['success'=>true]));
        }else{
            $this->response->setOutput(json_encode(['success'=>false]));
        }
    }
}


