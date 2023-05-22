<?php
class ControllerCommonRemarketing extends Controller {
	public function footer() {
		$this->load->model('tool/remarketing');
		if ($this->config->get('remarketing_status') && !$this->model_tool_remarketing->isBot()) {
			return $this->model_tool_remarketing->getRemarketingFooter();
		} 
	}

	public function removeProduct() {
		if (isset($this->request->post)) {
			if (isset($this->request->post['product_id']) && isset($this->request->post['quantity'])) {
				if ($this->config->get('remarketing_status')) { 
					$this->load->model('catalog/product');
					$this->load->model('tool/remarketing');
					$product_info = $this->model_catalog_product->getProduct($this->request->post['product_id']);
					$quantity = $this->request->post['quantity'];
					$json = []; 
					$json['remarketing'] = [];
					if ($product_info) {
						$json['remarketing'] = $this->model_tool_remarketing->remarketingRemoveFromCart($product_info, $quantity);						
						$this->response->addHeader('Content-Type: application/json');
						$this->response->setOutput(json_encode($json));
					}
				}
			}
		}
	} 
}