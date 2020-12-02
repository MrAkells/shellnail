<?php
class ControllerToolSdPushSendpulse extends Controller {
    private $sendpulse_url = 'https://events.sendpulse.com/events/id/e862189e941e4d5ee9f76878d0415a39/6607345';
    
	public function index(){            
		if (isset($_GET['auth']) && $_GET['auth'] == '2020')
		{
			$this->load->model('catalog/product');
			$this->load->model('account/customer');
			$this->load->model('tool/image');
			
			$cart_query = $this->db->query("SELECT `session_id`, customer_id, max(`date_added`) as date FROM `" . DB_PREFIX . "cart` WHERE customer_id > 0 AND (`date_added` BETWEEN DATE_ADD(NOW(), INTERVAL -3 HOUR) AND DATE_ADD(NOW(), INTERVAL -1 HOUR))  group by `session_id`");
			foreach ($cart_query->rows as $cart) {
				$product_cart_query = $this->db->query("SELECT `product_id` FROM `" . DB_PREFIX . "cart` WHERE `session_id` = '" . $cart['session_id'] . "'");
				$customer = $this->model_account_customer->getCustomer($cart['customer_id']);
				if($customer['email'] != ''){
					$sd_products = [];	
					foreach ($product_cart_query->rows as $product) {
						$results = $this->model_catalog_product->getProduct($product['product_id']);
						if($results){
							if ($results['image']) {
								$image = $this->model_tool_image->resize($results['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height'));
							} else {
								$image = '';
							}
							$sd_products[] = [
								'id' 		=> $results['product_id'],
								'name'  	=> $results['name'],
								'url'  		=> $this->url->link('product/product', 'product_id=' . $product['product_id']),
								'price'   	=> round($results['price'],2),
								'img_url' 	=> $image,
							];
						}
					}
					
					$sd_data = [
						'email' => $customer['email'],
						'phone' => $customer['telephone'],
						'event_date' => $cart['date'],
						'products' => $sd_products
					];
					//print_r($sd_data);
					$this->send($sd_data);
				}				
			
			}
			
		}            
	}
	
	private function send($data){
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->sendpulse_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		return curl_exec($ch);		
	}
}