<?php
class ControllerCheckoutCouriernp extends Controller {
    
    public function index() {
        
        $this->load->language('checkout/shipping');
        
        $data['text_empty']=$this->language->get('text_empty');
        $data['address']='';
        
       if(isset($this->session->data['courier_address'])){
            $data['address']=$this->session->data['courier_address'];
       }else if($this->customer->isLogged()){
            $this->load->model('account/address');
            $address_id=$this->customer->getAddressId();
            $address_info = $this->model_account_address->getAddress($address_id);
            $data['address']=$address_info['address_1'];
            $this->session->data['courier_address']=$address_info['address_1'];
        }
        
        $data['text_address']=$this->language->get('text_address');
       
        
        return $this->load->view('checkout/couriernp', $data);
	
    } 
    
    public function setAddress(){
        $address=$this->request->get['address'];
        
        if($this->request->server['REQUEST_METHOD'] == 'POST'){
            $this->session->data['courier_address']=$address;
            $this->response->setOutput(json_encode(['success'=>true]));
        }else{
            $this->response->setOutput(json_encode(['success'=>false]));
        }
    }
    
}


