<?php
class ControllerAccountPrecheckout extends Controller {
	private $error = array();

	public function index() {
		
                if($this->customer->isLogged() || isset($this->session->data['ready_for_checkout'])){
                    
                    $this->response->redirect($this->url->link('checkout/checkout'));
                }
            
		$this->load->language('account/precheckout');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/customer');

		if ($this->request->server['REQUEST_METHOD'] == 'POST'){
					$cred = $this->request->get['cred'] ?? '';
					if($cred == 'guest' && $this->validate()){
                        $this->session->data['ready_for_checkout']=[];
                        $this->session->data['payment_address']['firstname']=$this->request->post['firstname'];
                        $this->session->data['payment_address']['lastname']=$this->request->post['lastname'];
                        $this->session->data['payment_address']['telephone']=$this->request->post['telephone'];
                        $this->session->data['payment_address']['custom_field']['address'][1]=$this->request->post['telephone'];
                        $this->session->data['payment_address']['email']=$this->request->post['email'];
                       if(isset($this->request->post['newsletter'])){
                           $this->load->model('extension/module/delivery');
                           
                           $test = $this->model_extension_module_delivery->checkEmail($this->request->post['email']);
                         
                           if(empty($test)){
                              
                               $save_data['name']=$this->request->post['firstname'];
                               $save_data['phone']=$this->request->post['telephone'];
                               $save_data['email']=$this->request->post['email'];
                               $this->model_extension_module_delivery->addData($save_data);
                           }
                           
                        }else{
                            $this->session->data['payment_address']['newsletter']=0;
                        }
                        $this->response->setOutput("<div><span id='login_success'></div>");
                        return;
					}else if($cred == 'login' && $this->loginValidate()){
                        $this->response->setOutput("<div><span id='login_success'></div>");
                        return;
                    }
                    
  
			//$this->customer->login($this->request->post['email'], $this->request->post['password']);

			//unset($this->session->data['guest']);

			// Add to activity log
//			if ($this->config->get('config_customer_activity')) {
//				$this->load->model('account/activity');
//
//				$activity_data = array(
//					'customer_id' => $customer_id,
//					'name'        => $this->request->post['firstname'] . ' ' . $this->request->post['lastname']
//				);
//
//				$this->model_account_activity->addActivity('precheckout', $activity_data);
//			}

                   
                }else{
                    $data['big_cart']=$this->load->controller('extension/module/popupcartpre');
                }

		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('account/login', '', true));
		$data['text_your_details'] = $this->language->get('text_your_details');
		$data['text_your_address'] = $this->language->get('text_your_address');
		$data['text_your_password'] = $this->language->get('text_your_password');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');
                
                $data['text_new'] = $this->language->get('text_new');
                $data['text_customer'] = $this->language->get('text_customer');

                $data['end_step']= $this->language->get('end_step');
                
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_fax'] = $this->language->get('entry_fax');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_newsletter'] = $this->language->get('entry_newsletter');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_confirm'] = $this->language->get('entry_confirm');
                $data['entry_login'] = $this->language->get('entry_login');

                $data['try_to_login'] = $this->language->get('try_to_login');
                $data['text_register'] = $this->language->get('text_register');
                //$data['text_contact_details'] = $this->language->get('text_contact_details');
                $data['text_contact_details'] = $this->language->get('text_enter_as');
                $data['register_link'] = $this->url->link('account/register');
                
		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_upload'] = $this->language->get('button_upload');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['firstname'])) {
			$data['error_firstname'] = $this->error['firstname'];
		} else {
			$data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$data['error_lastname'] = $this->error['lastname'];
		} else {
			$data['error_lastname'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

		
		if (isset($this->error['city'])) {
			$data['error_city'] = $this->error['city'];
		} else {
			$data['error_city'] = '';
		}

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['login'])) {
			$data['error_login'] = $this->error['login'];
		} else {
			$data['error_login'] = '';
		}

		$data['action'] = $this->url->link('account/precheckout', '', true);

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} else {
			$data['telephone'] = '';
		}

		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} else {
			$data['city'] = '';
		}

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->post['newsletter'])) {
			$data['newsletter'] = $this->request->post['newsletter'];
		} else {
			$data['newsletter'] = 1;
		}

                if (isset($this->request->post['login'])) {
			$data['login'] = $this->request->post['login'];
		} else {
			$data['login'] = '';
		}

		if (isset($this->request->post['agree'])) {
			$data['agree'] = $this->request->post['agree'];
		} else {
			$data['agree'] = false;
		}

               
                
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/precheckout', $data));
	}

	private function validate() {         
            
		if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}
 
		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match($this->config->get('config_mail_regexp'), $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_exists');
		}
 
		if (preg_match_all( "/[0-9]/", $this->request->post['telephone'])<12  || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		return !$this->error;
	}

        public function loginValidate(){
                $this->load->model('account/customer');
                $this->request->post['email']=$this->request->post['login'];
                $login_info = $this->model_account_customer->getLoginAttempts($this->request->post['email']);

		if ($login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
			$this->error['login'] = $this->language->get('error_attempts');
		}

		// Check if customer has been approved.
		$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

		if ($customer_info && !$customer_info['approved']) {
			$this->error['login'] = $this->language->get('error_approved');
		}

		if (!$this->error) {
			if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
				$this->error['login'] = $this->language->get('error_login');

				$this->model_account_customer->addLoginAttempt($this->request->post['email']);
			} else {
				$this->model_account_customer->deleteLoginAttempts($this->request->post['email']);
			}
		}

		return !$this->error;
        }
        
        public function hint() {
            $this->load->model('extension/shipping/new_mail');
			$this->load->language('account/precheckout');

			$lang = ($this->config->get('config_language_id') == 1 ? '_ru' : '_ua');

            $hint=$this->request->get['hint'];
        
            $areas=$this->model_extension_shipping_new_mail->getCityByHint($hint);
  
            $cities=[];
        
            if($hint){
                foreach($areas as $area){
                    $cities[]=array(
                        'name'=> $area['name'.$lang],
                        'ref'=>  $area['city_ref'],
                    );
                }
            }
        
        
            if(!$cities && !$hint){
                $def_cities=array(
                    '8d5a980d-391c-11dd-90d9-001a92567626',
                    'db5c88f0-391c-11dd-90d9-001a92567626',
                    'db5c88e0-391c-11dd-90d9-001a92567626',
                    'db5c88d0-391c-11dd-90d9-001a92567626',
                    'db5c88f5-391c-11dd-90d9-001a92567626',
                );
                $lang = ($this->config->get('config_language_id') == 1 ? '_ru' : '');
                $default_areas=$this->model_extension_shipping_new_mail->getDefaultCities($def_cities);
                foreach($default_areas as $area){
                    $cities[]=array(
                        'name'=> $area['description' . $lang],
                        'ref'=>  $area['ref']
                    );
                }
                if($cities){
                     $cities[]=[
                    'name'=> $this->language->get('text_another_city'),
                    'ref'=>  'another_city'
                ];
                }
                
            }
            
            if($cities){
               
                $result=array(
                    'success'=>true,
                    'data'=>$cities
                );
            }else{
                 $result=array(
                    'success'=>false,
                    'data'=>[]
                );
            }
            
            
        
            $this->response->setOutput(json_encode($result));
    }
        
    
}