<?php
class ControllerExtensionModuleStickers extends Controller {
	private $error = array();

	public function index() {
                $this->load->model('catalog/product');
		$this->load->language('extension/module/stickers');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
                    
                    $text_for_stickers='';
                    if($this->request->post['hand_stickers']){
                        $this->db->query("UPDATE ".DB_PREFIX."product SET stickers=''");
                        unset($this->request->post['hand_stickers']);
                        $text_for_stickers.='<br/>Ручные стикеры очищены<br/>';
                    }
                    
                    if($this->request->post['auto_stickers']){
                        
                        $this->db->query("UPDATE ".DB_PREFIX."product SET auto_stickers=''");
                        $text_for_stickers.='<br/>Автоматические стикеры очищены<br/>';
                        if($this->request->post['auto_stickers']==2){
                            $this->setAutoStickers();
                            $text_for_stickers.='Автоматические стикеры установлены';
                        }
                        unset($this->request->post['auto_stickers']);
                    }
                    
			$this->model_setting_setting->editSetting('stickers', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success').$text_for_stickers;
                        
                        
                       

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
                
                $data['text_special']=$this->language->get('text_special');
                $data['text_popular']=$this->language->get('text_popular');
                $data['text_latest']=$this->language->get('text_new_thing');
                $data['text_bestseller']=$this->language->get('text_bestseller');
                
                $data['entry_product'] = $this->language->get('entry_product');
                $data['token']=$this->session->data['token'];
                
                $data['text_limit']=$this->language->get('text_limit');
                
                
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/stickers', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/stickers', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		if (isset($this->request->post['stickers_status'])) {
                    $data['stickers_status'] = $this->request->post['stickers_status'];
		} else {
                    $data['stickers_status'] = $this->config->get('stickers_status');
		}
                
                if (isset($this->request->post['stickers_popular'])) {
                    $data['stickers_popular'] = $this->request->post['stickers_popular'];
		} else {
                    $data['stickers_popular'] = $this->config->get('stickers_popular');
		}
                
                if (isset($this->request->post['stickers_latest'])) {
                    $data['stickers_latest'] = $this->request->post['stickers_latest'];
		} else {
                    $data['stickers_latest'] = $this->config->get('stickers_latest');
		}
                
                if (isset($this->request->post['stickers_bestseller'])) {
                    $data['stickers_bestseller'] = $this->request->post['stickers_bestseller'];
		} else {
                    $data['stickers_bestseller'] = $this->config->get('stickers_bestseller');
		}
                
                if (isset($this->request->post['stickers_special'])) {
                    $data['stickers_special'] = $this->request->post['stickers_special'];
		} else {
                    $data['stickers_special'] = $this->config->get('stickers_special');
		}
                
                // Лимиты для функций в модели catalog/product
               
                if($this->config->get('stickers_popular_limit')){
                    $data['popular_limit']=$this->config->get('stickers_popular_limit');
                }else{
                    $data['popular_limit']=5;
                }
               
                if($this->config->get('stickers_latest_limit')){
                    $data['latest_limit']=$this->config->get('stickers_latest_limit');
                }else{
                    $data['latest_limit']=5;
                }
              
               if($this->config->get('stickers_bestseller_limit')){
                    $data['bestseller_limit']=$this->config->get('stickers_bestseller_limit');
                }else{
                    $data['bestseller_limit']=5;
                }
                
                $data['text_do_nothing']=$this->language->get('text_do_nothing');
                $data['update_auto_stickers']= $this->language->get('update_auto_stickers');
                $data['clear_auto_stickers']= $this->language->get('clear_auto_stickers');
                $data['clear_hand_stickers']= $this->language->get('clear_hand_stickers');
                
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/stickers', $data));
	}

        protected function setAutoStickers(){
            
            if($this->request->post['stickers_popular_limit']){
                
               $query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$this->request->post['stickers_popular_limit']);
                $ids=[];
                foreach ($query->rows as $result) {
                    $ids[] = $result['product_id'];
                }
				if($ids){
                $query = $this->db->query("UPDATE ".DB_PREFIX."product SET auto_stickers=CONCAT(auto_stickers, 'p') WHERE product_id IN (".implode(',',$ids).")");
				}
            
            }
               
            if($this->request->post['stickers_latest_limit']){
                
                 $query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$this->request->post['stickers_latest_limit']);
                    $ids=[];
                    foreach ($query->rows as $result) {
                        $ids[] = $result['product_id'];
                    }
                if($ids){
                  $query = $this->db->query("UPDATE ".DB_PREFIX."product SET auto_stickers=CONCAT(auto_stickers, 'n') WHERE product_id IN (".implode(',',$ids).")");
				}
            }
              
            if($this->request->post['stickers_bestseller_limit']){
                
                    
               $query = $this->db->query("SELECT op.product_id, COUNT(op.product_id) as count FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY count DESC LIMIT " . (int)$this->request->post['stickers_bestseller_limit']);
                    $ids=[];
                    foreach($query->rows as $row){
                        $ids[]=$row['product_id'];
                    }
					if($ids){
                 $query = $this->db->query("UPDATE ".DB_PREFIX."product SET auto_stickers=CONCAT(auto_stickers, 'b') WHERE product_id IN (".implode(',',$ids).")");
					}
            }
            
            
        }
        
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/stickers')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}