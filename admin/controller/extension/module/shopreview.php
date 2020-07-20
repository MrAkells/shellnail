<?php
class ControllerExtensionModuleShopReview extends Controller {
	private $error = array();

        public function install(){
           $this->db->query("CREATE TABLE ".DB_PREFIX."shopreview (shopreview_id INT(11) PRIMARY KEY AUTO_INCREMENT, customer_id INT(11), author VARCHAR(64) NOT NULL, text TEXT, rating INT(2), status TINYINT(1), image VARCHAR(100), date_added DATETIME, date_modified DATETIME)");
           mkdir(DIR_IMAGE . 'shop_reviews/');
        }
        
	public function index() {
		$this->load->language('extension/module/shopreview');
                $this->load->model('tool/image');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
                    
                    $this->load->model('catalog/shopreview');
                     
                    if(is_file($this->request->files['reviewimage']['tmp_name'])){
                    
                        $image_settings = array(
                            'file'          => $this->request->files['reviewimage']['tmp_name'],
                            'file_name'     => $this->request->files['reviewimage']['name'],
                        );
                   
                        $imagename=$this->model_catalog_shopreview->saveDefaultImage($image_settings);
                        $this->request->post['shopreview_image']= $imagename;
                        $this->model_catalog_shopreview->deleteDefaultImage($this->config->get('shopreview_image'));
                    }
                    
                    if($this->request->post['shopreview_seo']){
                        $this->model_catalog_shopreview->setUrlAlias($this->request->post['shopreview_seo']);
                    }
                    
			$this->model_setting_setting->editSetting('shopreview', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');
                $data['entry_seo'] = $this->language->get('entry_seo');
                $data['entry_meta_title'] = $this->language->get('entry_meta_title');
                $data['entry_meta_description'] = $this->language->get('entry_meta_description');
                $data['entry_meta_keywords'] = $this->language->get('entry_meta_keywords');
                $data['entry_seo'] = $this->language->get('entry_seo');
                $data['entry_reviews_on_page'] = $this->language->get('entry_reviews_on_page');
                $data['entry_width'] = $this->language->get('entry_width');
                $data['entry_height'] = $this->language->get('entry_height');
                $data['entry_image'] = $this->language->get('entry_image');
                
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

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
			'href' => $this->url->link('extension/module/shopreview', 'token=' . $this->session->data['token'], true)
		);
                
		$data['action'] = $this->url->link('extension/module/shopreview', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		if (isset($this->request->post['shopreview_status'])) {
			$data['shopreview_status'] = $this->request->post['shopreview_status'];
		} else {
			$data['shopreview_status'] = $this->config->get('shopreview_status');
		}
                
                if (isset($this->request->post['shopreview_seo'])) {
			$data['seo'] = $this->request->post['shopreview_seo'];
		} else {
			$data['seo'] = $this->config->get('shopreview_seo');
		}
                
                if (isset($this->request->post['shopreview_reviews_on_page'])) {
			$data['reviews_on_page'] = $this->request->post['shopreview_reviews_on_page'];
		}else if( $this->config->get('shopreview_reviews_on_page')){
			$data['reviews_on_page'] = $this->config->get('shopreview_reviews_on_page');
                }else{
                    $data['reviews_on_page']=5;
                }
                
                if (isset($this->request->post['shopreview_meta_title'])) {
                    $data['shopreview_meta_title'] = $this->request->post['shopreview_meta_title'];
		}else if( $this->config->get('shopreview_meta_title')){
                    $data['shopreview_meta_title'] = $this->config->get('shopreview_meta_title');
                }else{
                    $data['shopreview_meta_title']='';
                }
                if (isset($this->request->post['shopreview_meta_description'])) {
                    $data['shopreview_meta_description'] = $this->request->post['shopreview_meta_description'];
		}else if( $this->config->get('shopreview_meta_description')){
                    $data['shopreview_meta_description'] = $this->config->get('shopreview_meta_description');
                }else{
                    $data['shopreview_meta_description']='';
                }
                
                 if (isset($this->request->post['shopreview_meta_keywords'])) {
                    $data['shopreview_meta_keywords'] = $this->request->post['shopreview_meta_keywords'];
		}else if( $this->config->get('shopreview_meta_keywords')){
                    $data['shopreview_meta_keywords'] = $this->config->get('shopreview_meta_keywords');
                }else{
                    $data['shopreview_meta_keywords']='';
                }
                
                if (isset($this->request->post['shopreview_width'])) {
                    $data['width'] = $this->request->post['shopreview_width'];
		}else if( $this->config->get('shopreview_width')){
                    $data['width'] = $this->config->get('shopreview_width');
                }else{
                    $data['width']=200;
                }
                
                if (isset($this->request->post['shopreview_height'])) {
                    $data['height'] = $this->request->post['shopreview_height'];
		}else if( $this->config->get('shopreview_height')){
                    $data['height'] = $this->config->get('shopreview_height');
                }else{
                    $data['height']=200;
                }
                
                
                if( $this->config->get('shopreview_image')){
                    $path='shop_reviews/'.$this->config->get('shopreview_image');
                    $data['image'] =$this->model_tool_image->resize($path, 200, 200);
                }else{
                    $data['image']='';
                }

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/shopreview', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/shopreview')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
                
                if($this->request->post['shopreview_reviews_on_page']<1){
                    $this->error['warning'] = $this->language->get('error_number_of_reviews');
                }
                
                if(is_file($this->request->files['reviewimage']['tmp_name'])){
                    $this->load->model('catalog/shopreview');
                    $type=$this->request->files['reviewimage']['type'];
                    if(!$this->model_catalog_shopreview->isPicture($type)){
                        $this->error['warning'] = $this->language->get('error_image_type');
                    }
                }
                
		return !$this->error;
	}
}