<?php
class ControllerAccountModal extends Controller {
      private $error = array();
    
	public function index() {
		$this->load->language('account/modal');

            $data['heading_title'] = $this->language->get('heading_title');
            $data['text_login'] = $this->language->get('text_login1');
            $data['text_step_into'] = $this->language->get('text_step_into');
            $data['action']=$this->url->link('account/modal/login');
            $data['entry_login_email']=$this->language->get('entry_login_email');
            $data['entry_login_password']=$this->language->get('entry_login_password');
            $data['text_contact_details'] = $this->language->get('text_enter_as');

            $data['entry_remember'] = $this->language->get('entry_remember');
            $data['text_forgotten'] = $this->language->get('text_forgotten');
            $data['forgotten'] = $this->url->link('account/forgotten', '', true);
            
            $data['route'] = $this->request->get['route'];

		return $this->load->view('account/modal', $data);
	}
        
      public function login() {
            //var_dump($this->request->post);
            $this->load->language('account/modal');
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		// Unset guest
		unset($this->session->data['guest']);

		// Default Shipping Address
		$this->load->model('account/address');

            if ($this->config->get('config_tax_customer') == 'payment') {
		$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
            }

            if ($this->config->get('config_tax_customer') == 'shipping') {
		$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
            }

            // Wishlist
            if (isset($this->session->data['wishlist']) && is_array($this->session->data['wishlist'])) {
		      $this->load->model('account/wishlist');

                  foreach ($this->session->data['wishlist'] as $key => $product_id) {
                        $this->model_account_wishlist->addWishlist($product_id);

                        unset($this->session->data['wishlist'][$key]);
                  }
            }

            // Add to activity log
            if ($this->config->get('config_customer_activity')) {
                  $this->load->model('account/activity');

                  $activity_data = array(
                        'customer_id' => $this->customer->getId(),
                        'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
                  );

                  $this->model_account_activity->addActivity('login', $activity_data);
            }

                $result=json_encode(['success'=>1, 'message'=>$this->language->get('success_login')]);
			
            }else{
                $result=json_encode(['success'=>0, 'message'=>$this->error['warning']]);
            }
            $this->response->setOutput($result);
    }
        
    protected function validate() {
        $this->request->post['email']=$this->request->post['login_email'];
        
        $this->request->post['password']=$this->request->post['login_password'];
        
        $this->load->model('account/customer');

	// Check how many login attempts have been made.
	$login_info = $this->model_account_customer->getLoginAttempts($this->request->post['email']);

	if ($login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
            $this->error['warning'] = $this->language->get('error_attempts');
	}

	if (!$this->error) {
            if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
		$this->error['warning'] = $this->language->get('error_login');

		$this->model_account_customer->addLoginAttempt($this->request->post['email']);
            } else {
		$this->model_account_customer->deleteLoginAttempts($this->request->post['email']);
                if(isset($this->request->post['remember_me']) && $this->request->post['remember_me']){
                   $this->load->helper('general');
                   $token=token(20).time();
                   $customer_id=$this->customer->getId();
                   $this->db->query("INSERT INTO ".DB_PREFIX."remember SET customer_id='".(int)$customer_id."', token='".$token."'");
                   setcookie('remember_me', $token, time() + 60 * 60 * 24 * 365, '/', $this->request->server['HTTP_HOST']);
                }
            }
	}

            return !$this->error;
	}
}