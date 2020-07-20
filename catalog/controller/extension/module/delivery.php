<?php  
class ControllerExtensionModuleDelivery extends Controller {
    
	public function index() 
        {           
		$this->language->load('extension/module/delivery');
		$this->load->model('extension/module/delivery');
             
		$data['heading_title'] = $this->language->get('heading_title');
                $data['text_send'] = $this->language->get('send');
		$data['textSuccess'] = $this->language->get('textSuccess');
		$data['textErrorEmeil'] = $this->language->get('textErrorEmeil');
		$data['textNotValid'] = $this->language->get('textNotValid');
		$data['textRegisterEmail'] = $this->language->get('textRegisterEmail');
                $data['your_phone']=$this->language->get('your_phone');
              
                $data['action'] = $this->url->link('extension/module/delivery', '', 'SSL');                
                
                if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->post['isdelivery']))
                    
                { 
                    if(!empty($this->request->post['name']) ){
                        $name = $this->request->post['name'];
                    }
                    else{
                        $name = '';
                    }
                    
//                    else{
//                        $rez = explode('@', $this->request->post['email']);
//                        $name = $rez[0];
//                    }
//                    $email = $this->request->post['email'];
//                  
                    if(isset($this->request->post['phone'])){
                        $phone = $this->request->post['phone'];
                    }else{
                        $phone='';
                    }
                    
                    if(isset($this->request->post['email'])){
                        $email = $this->request->post['email'];
                    }else{
                        $email='';
                    }

                    if(preg_match_all( "/[0-9]/", $phone )>11)
                    {
                            $test = $this->model_extension_module_delivery->checkPhone($phone);
                            if($test){
                                $data = array();
                                $data['email'] = $email;
                                $data['name'] = $name;   
                                $data['phone']= $phone;
                                $this->model_extension_module_delivery->addData($data);                    
                                echo 'success';
                            }else{
                                echo 'success';
                            }
                            
                    }  
                    else
                    {
                        echo 'notValid';
                    }
                    
                    
//                    if($this->model_extension_module_delivery->validate($email) != 0)
//                    {
//                
//                        $test = $this->model_extension_module_delivery->checkEmail($email);
//                        if(empty($test))
//                        {
//                            $data = array();
//                            
//                            $data['email'] = $email;
//                            $data['name'] = $name;   
//                            $data['phone']= $phone;
//                            $this->model_extension_module_delivery->addData($data);                    
//                            echo 'success';
//                        }
//                        else 
//                        {
//                            echo 'issetEmail';
//                        }
//                    }  
//                    else
//                    {
//                        echo 'notValid';
//                    }
                }
                

                if($this->config->get('category_breadcrumbs')){
                    $data['hide_xs_sm']=true;
                }else{
                    $data['hide_xs_sm']=false;
                }
                
                
                return $this->load->view('extension/module/delivery', $data);
	}
}
