<?php
class ControllerAccountPassword extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('account/password');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('account/customer');

                            $this->model_account_customer->editPassword($this->customer->getEmail(), $this->request->post['password']);

                            $this->session->data['success'] = $this->language->get('text_success');

                            // Add to activity log
                            if ($this->config->get('config_customer_activity')) {
				$this->load->model('account/activity');

				$activity_data = array(
					'customer_id' => $this->customer->getId(),
					'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
				);

				$this->model_account_activity->addActivity('password', $activity_data);
                            }
                        
                }

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_password'] = $this->language->get('text_password');

		$data['entry_password'] = $this->language->get('entry_password');
                $data['entry_old_password'] = $this->language->get('entry_old_password');
		$data['entry_confirm'] = $this->language->get('entry_confirm');

		$data['button_continue'] = $this->language->get('text_save');
		
		$data['action'] = $this->url->link('account/password/setPassword', '', true);

                if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		} 
                
                if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
                
                if (isset($this->error['oldpassword'])) {
                    $data['error_oldpassword'] = $this->error['oldpassword'];
                } else {
                    $data['error_oldpassword'] = '';
                }
                
                if (isset($this->error['password'])) {
                    $data['error_password'] = $this->error['password'];
                } else {
                    $data['error_password'] = '';
                }

                if (isset($this->error['confirm'])) {
                    $data['error_confirm'] = $this->error['confirm'];
                } else {
                    $data['error_confirm'] = '';
                }
                
                
		if (isset($this->request->post['password']) && $this->error) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->post['confirm']) && $this->error) {
			$data['confirm'] = $this->request->post['confirm'];
		} else {
			$data['confirm'] = '';
		}

		return $this->load->view('account/password', $data);
	}

        public function setPassword(){
         
            $markup=$this->index();
            $json=array(
                'success'=> 1,
                'html'=>$markup
            );
            $this->response->setOutput(json_encode($json));
        }
        
	protected function validate() {

            if($this->request->post['oldpassword']==='' && $this->request->post['password']==='' && $this->request->post['confirm']===''){
                return false;
            }
            
                $this->load->model('account/customer');
                $check_old_pass=$this->model_account_customer->checkPassword($this->session->data['customer_id'], $this->request->post['oldpassword']);
                
                if(!$check_old_pass){
                    $this->error['oldpassword'] = $this->language->get('error_old_password');
                }
                
		if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if ($this->request->post['confirm'] != $this->request->post['password']) {
			$this->error['confirm'] = $this->language->get('error_confirm');
		}

                if($this->error){
                   $this->error['warning']= $this->language->get('error_change_password');
                }
                
		return !$this->error;
	}
}