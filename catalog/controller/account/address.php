<?php
class ControllerAccountAddress extends Controller {
	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/address', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/address');

		$this->load->model('account/address');

		$data['address_list']=$this->getList();
                $data['address_form']=$this->getForm();
                
                return $this->load->view('account/address', $data);
	}

	public function add() {
           
		$this->load->language('account/address');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/address');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
                    $address_2=[];
                    if($this->request->post['addr_phone']){
                        $address_2['phone']=$this->request->post['addr_phone'];
                    }
                    
                    if($this->request->post['street']){
                        $address_2['street']=$this->request->post['street'];
                    }
                    
                    if($this->request->post['house']){
                        $address_2['house']=$this->request->post['house'];
                    }
                    
                    if($this->request->post['flat']){
                        $address_2['flat']=$this->request->post['flat'];
                    }
                    
                    $address_1=[];
                    if($this->request->post['city']){
                        $address_1[]=$this->request->post['city'];
                    }
                    if($this->request->post['street']){
                        $address_1[]="ул. ".$this->request->post['street'];
                    }
                    if($this->request->post['house']){
                        $address_1[]="дом ".$this->request->post['house'];
                    }
                    if($this->request->post['flat']){
                        $address_1[]="кв. ".$this->request->post['flat'];
                    }
                   
                    
                    $this->request->post['address_1']= implode(', ', $address_1);
                    $this->request->post['custom_field']=  json_encode($address_2);
                    $this->request->post['country_id']=  '220';
                    $this->request->post['zone_id']=  '0';
                    
                        $this->model_account_address->addAddress($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_add');

			// Add to activity log
			if ($this->config->get('config_customer_activity')) {
				$this->load->model('account/activity');

				$activity_data = array(
					'customer_id' => $this->customer->getId(),
					'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
				);

				$this->model_account_activity->addActivity('address_add', $activity_data);
			}

		}
                
              
		$list=$this->getList();
		$form=$this->getForm();
                $json=array(
                    'success'=>1,
                    'form'=>$form,
                    'list'=>$list
                );
                $this->response->setOutput(json_encode($json));
	}

	public function edit() {
		
		$this->load->language('account/address');

	
		$this->load->model('account/address');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
                    
                    unset($this->session->data['payment_address']);
                    unset( $this->session->data['changed_postcode']);
                    unset($this->session->data['courier_address']);
                    unset($this->session->data['newmail_office']);
                    unset($this->session->data['inter_comment']);
                    
			$address_2=[];
                    if($this->request->post['addr_phone']){
                        $address_2['phone']=$this->request->post['addr_phone'];
                    }
                    
                    if($this->request->post['street']){
                        $address_2['street']=$this->request->post['street'];
                    }
                    
                    if($this->request->post['house']){
                        $address_2['house']=$this->request->post['house'];
                    }
                    
                    if($this->request->post['flat']){
                        $address_2['flat']=$this->request->post['flat'];
                    }
                    
                    $address_1=[];
                    if($this->request->post['city']){
                        $address_1[]=$this->request->post['city'];
                    }
                    if($this->request->post['street']){
                        $address_1[]="ул. ".$this->request->post['street'];
                    }
                    if($this->request->post['house']){
                        $address_1[]="дом ".$this->request->post['house'];
                    }
                    if($this->request->post['flat']){
                        $address_1[]="кв. ".$this->request->post['flat'];
                    }
                   
                    $this->request->post['address_1']= implode(', ', $address_1);
                    $this->request->post['custom_field']=  json_encode($address_2);
                  

                   // var_dump($this->request->post); die;
                    
                    $this->model_account_address->editAddress($this->request->get['address_id'], $this->request->post);

			// Default Shipping Address
			if (isset($this->session->data['shipping_address']['address_id']) && ($this->request->get['address_id'] == $this->session->data['shipping_address']['address_id'])) {
				$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->request->get['address_id']);

				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
			}

			// Default Payment Address
			if (isset($this->session->data['payment_address']['address_id']) && ($this->request->get['address_id'] == $this->session->data['payment_address']['address_id'])) {
				$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->request->get['address_id']);

				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);
			}

			$this->session->data['success'] = $this->language->get('text_edit');

			// Add to activity log
			if ($this->config->get('config_customer_activity')) {
				$this->load->model('account/activity');

				$activity_data = array(
					'customer_id' => $this->customer->getId(),
					'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
				);

				$this->model_account_activity->addActivity('address_edit', $activity_data);
			}
                        
			$this->request->get['address_id']=false;
		}
                
                $list=$this->getList();
		$form=$this->getForm();
                $json=array(
                    'success'=>1,
                    'form'=>$form,
                    'list'=>$list
                );
                $this->response->setOutput(json_encode($json));
	}

	public function delete() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/address', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/address');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/address');

		if (isset($this->request->get['address_id']) && $this->validateDelete()) {
			$this->model_account_address->deleteAddress($this->request->get['address_id']);

			// Default Shipping Address
			if (isset($this->session->data['shipping_address']['address_id']) && ($this->request->get['address_id'] == $this->session->data['shipping_address']['address_id'])) {
				unset($this->session->data['shipping_address']);
				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
			}

			// Default Payment Address
			if (isset($this->session->data['payment_address']['address_id']) && ($this->request->get['address_id'] == $this->session->data['payment_address']['address_id'])) {
				unset($this->session->data['payment_address']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);
			}

			$this->session->data['success'] = $this->language->get('text_delete');

			// Add to activity log
			if ($this->config->get('config_customer_activity')) {
				$this->load->model('account/activity');

				$activity_data = array(
					'customer_id' => $this->customer->getId(),
					'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
				);
				
				$this->model_account_activity->addActivity('address_delete', $activity_data);
			}

			$this->response->redirect($this->url->link('account/address', '', true));
		}

		$this->getList();
	}

	protected function getList() {

		
                $data['create_user_address'] = $this->language->get('create_user_address');

		$data['text_address_book'] = $this->language->get('text_address_book');
		$data['text_empty'] = $this->language->get('text_empty');
                $data['text_edit_addr'] = $this->language->get('text_edit_addr');
                

		$data['button_new_address'] = $this->language->get('button_new_address');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_back'] = $this->language->get('button_back');
                
               
                
		$data['addresses'] = array();

                 if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		} 
                
		$results = $this->model_account_address->getAddresses();
                
                $data['addresses']=[];
                
		foreach ($results as $result) {
                    $full_address=[];
                        if($result['custom_field'] && !is_null($result['custom_field'])){
                            $full_address=$result['custom_field'];
                        }
                     
                        if($full_address){
                            $street=isset($full_address['street'])?$full_address['street']:'';
                            $house=isset($full_address['house'])?$full_address['house']:'';    
                            $flat=isset($full_address['flat'])?$full_address['flat']:''; 
                            $phone=isset($full_address['phone'])?$full_address['phone']:''; 
                        }else{
                            $street='';
                            $house='';
                            $flat='';
                            $phone='';
                        }
                        
                       $parts = array();
                        
                        if($result['firstname'] || $result['lastname']){
                            $parts[]=$result['firstname'] ." ". $result['lastname'];
                        }
                        
                        if($street){
                            $parts[]='ул. '.$street;
                        }
     
                        if($result['city']){
                            $parts[]=$result['city'];
                        }
                        
                        if($house){
                            $parts[]='дом '.$house;
                        }
                        
                        if($flat){
                            $parts[]='кв. '.$flat;
                        }
                        
                        if($phone){
                            $parts[]='тел. '.$phone;
                        }
                        
                        $contact=implode(', ', $parts);
                        
                        
			$data['addresses'][] = array(
                                'address_id' => $result['address_id'],
				'firstname' => $result['firstname'],
				'lastname'  => $result['lastname'],
				'company'   => $result['company'],
				'address_1' => $result['address_1'],
				'street' => $street,
                                'house' => $house,
                                'flat' => $flat,
                                'phone'=>$phone,
                                'contact'=>$contact,
				'city'      => $result['city'],
				'postcode'  => $result['postcode'],
				'zone'      => $result['zone'],
				'zone_code' => $result['zone_code'],
				'country'   => $result['country'],
                                'href' => $this->url->link('account/address/edit', 'address_id='.(int)$result['address_id']),
                              
			);
		}

		return $this->load->view('account/address_list', $data);
	}

	protected function getForm() {

		$data['text_edit_address'] = $this->language->get('text_edit_address');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
                
                $data['entry_street'] = $this->language->get('entry_street');
                $data['entry_house'] = $this->language->get('entry_house');
                $data['entry_flat'] = $this->language->get('entry_flat');
                $data['entry_phone'] = $this->language->get('entry_phone');
                $data['button_new'] = $this->language->get('button_new');
                
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_default'] = $this->language->get('entry_default');
                $data['text_main_address'] = $this->language->get('text_main_address');
                

                
                 $data['edit_user_address'] = $this->language->get('edit_user_address');
                $data['create_user_address'] = $this->language->get('create_user_address');
                
		$data['button_continue'] = $this->language->get('text_save');
		$data['button_back'] = $this->language->get('button_back');
		$data['button_upload'] = $this->language->get('button_upload');

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

		if (isset($this->error['city'])) {
			$data['error_city'] = $this->error['city'];
		} else {
			$data['error_city'] = '';
		}
                
		if (isset($this->error['postcode'])) {
			$data['error_postcode'] = $this->error['postcode'];
		} else {
			$data['error_postcode'] = '';
		}

                if (isset($this->error['phone'])) {
			$data['error_phone'] = $this->error['phone'];
		} else {
			$data['error_phone'] = '';
		}

                if (isset($this->error['default'])) {
			$data['error_default'] = $this->error['default'];
		} else {
			$data['error_default'] = '';
		}
                
		if (!isset($this->request->get['address_id'])) {
			$data['action'] = $this->url->link('account/address/add', '', true);
                        $data['address_id']='';
		} else {
			$data['action'] = $this->url->link('account/address/edit', 'address_id=' . $this->request->get['address_id'], true);
                        $data['address_id']=$this->request->get['address_id'];
		}

		if (isset($this->request->get['address_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$address_info = $this->model_account_address->getAddress($this->request->get['address_id']);
		}

		if (isset($this->request->post['firstname'])  && $this->error) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($address_info)) {
			$data['firstname'] = $address_info['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])  && $this->error) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($address_info)) {
			$data['lastname'] = $address_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->request->post['address_1'])  && $this->error) {
			$data['address_1'] = $this->request->post['address_1'];
		} elseif (!empty($address_info)) {
			$data['address_1'] = $address_info['address_1'];
		} else {
			$data['address_1'] = '';
		}

		if (isset($this->request->post['postcode'])  && $this->error) {
			$data['postcode'] = $this->request->post['postcode'];
		} elseif (!empty($address_info)) {
			$data['postcode'] = $address_info['postcode'];
		} else {
			$data['postcode'] = '';
		}

		if (isset($this->request->post['city'])  && $this->error) {
			$data['city'] = $this->request->post['city'];
		} elseif (!empty($address_info)) {
			$data['city'] = $address_info['city'];
		} else {
			$data['city'] = '';
		}

                if(!empty($address_info)){
                    $full_adress=$address_info['custom_field'];
                }else{
                    $full_adress=false;
                }
                
		if (isset($this->request->post['street'])  && $this->error) {
			$data['street'] = $this->request->post['street'];
		} elseif ($full_adress && isset($full_adress['street'])) {
			$data['street'] = $full_adress['street'];
		} else {
			$data['street'] = '';
		}
                
                if (isset($this->request->post['house'])  && $this->error) {
			$data['house'] = $this->request->post['house'];
		} elseif ($full_adress && isset($full_adress['house'])) {
			$data['house'] = $full_adress['house'];
		} else {
			$data['house'] = '';
		}
                
                if (isset($this->request->post['flat'])  && $this->error) {
			$data['flat'] = $this->request->post['flat'];
		} elseif ($full_adress && isset($full_adress['flat'])) {
			$data['flat'] = $full_adress['flat'];
		} else {
			$data['flat'] = '';
		}
                
                if (isset($this->request->post['addr_phone']) && $this->error) {
			$data['addr_phone'] = $this->request->post['addr_phone'];
		} elseif ($full_adress && isset($full_adress['phone'])) {
			$data['addr_phone'] = $full_adress['phone'];
		} else {
			$data['addr_phone'] = '';
		}
                
                
		if (isset($this->request->post['default']) && $this->error) {
			$data['default'] = $this->request->post['default'];
		} elseif (isset($this->request->get['address_id'])) {
			$data['default'] = $this->customer->getAddressId() == $this->request->get['address_id'];
		} else {
			$data['default'] = false;
		}
                
		return $this->load->view('account/address_form', $data);
	}

	protected function validateForm() {
		if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128)) {
			$this->error['city'] = $this->language->get('error_city');
		}
                
                if(isset($this->request->get['address_id'])){
                    if(($this->customer->getAddressId()== $this->request->get['address_id']) && !isset($this->request->post['default']) ){
                        $this->error['default'] = 'Основной адрес нельзя убрать, можно только сменить!';
                    }
                }

		return !$this->error;
	}

	protected function validateDelete() {
		if ($this->model_account_address->getTotalAddresses() == 1) {
			$this->error['warning'] = $this->language->get('error_delete');
		}

		if ($this->customer->getAddressId() == $this->request->get['address_id']) {
			$this->error['warning'] = $this->language->get('error_default');
		}

		return !$this->error;
	}
}
