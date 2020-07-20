<?php
class ControllerCheckoutUkrposhta extends Controller {
    
    public function index() {
        
        $this->load->language('checkout/shipping');
        
        $data['text_empty']=$this->language->get('text_empty');

        $data['postcode']='';
        
        
        if(isset($this->session->data['changed_postcode'])){
            $data['postcode']=$this->session->data['changed_postcode'];
        }else if($this->customer->isLogged()){
            $this->load->model('account/address');
            $address_id=$this->customer->getAddressId();
            $address_info = $this->model_account_address->getAddress($address_id);
           
            $data['postcode']=$address_info['postcode'];
            $this->session->data['changed_postcode']=$address_info['postcode'];
        }
        
        $data['text_postcode']=$this->language->get('text_postcode');
       
        
        return $this->load->view('checkout/ukrposhta', $data);
	
    } 
    
    public function setPostcode(){
        $postcode=$this->request->get['postcode'];
        
        if($this->request->server['REQUEST_METHOD'] == 'POST'){
            $this->session->data['changed_postcode']=$postcode;
            $this->response->setOutput(json_encode(['success'=>true]));
        }else{
            $this->response->setOutput(json_encode(['success'=>false]));
        }
    }
}


