<?php
class ControllerExtensionModuleOwner extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/owner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('owner', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

                        $this->cache->delete('menushka');
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
                
                $data['text_moto'] = $this->language->get('text_moto');
                $data['text_moto_footer'] = $this->language->get('text_moto_footer');
                $data['text_second_block_title'] = $this->language->get('text_second_block_title');
                $data['text_second_block'] = $this->language->get('text_second_block');
                $data['text_phone1'] = $this->language->get('text_phone1');
                $data['text_phone2'] = $this->language->get('text_phone2');
                $data['text_phone3'] = $this->language->get('text_phone3');
                $data['text_email'] = $this->language->get('text_email');
                $data['text_skype'] = $this->language->get('text_skype');
                $data['text_sсhedule'] = $this->language->get('text_sсhedule');
                $data['entry_icons'] = $this->language->get('entry_icons');
                $data['entry_brands_name'] = $this->language->get('entry_brands_name');
                $data['entry_brands_sort_order'] = $this->language->get('entry_brands_sort_order');
                $data['entry_promotions_meta_description'] = $this->language->get('entry_promotions_meta_description');
                $data['entry_promotions_meta_title'] = $this->language->get('entry_promotions_meta_title');
                $data['entry_promotions_meta_keywords'] = $this->language->get('entry_promotions_meta_keywords');
                
                $data['text_shop_description'] = $this->language->get('text_shop_description');
                
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
			'href' => $this->url->link('extension/module/owner', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/owner', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);
$data['ckeditor'] = $this->config->get('config_editor_default');
            if ($this->config->get('config_editor_default')) {
                $this->document->addScript('view/javascript/ckeditor/ckeditor.js');
                $this->document->addScript('view/javascript/ckeditor/ckeditor_init.js');
            } else {
                $this->document->addScript('view/javascript/summernote/summernote.js');
                $this->document->addScript('view/javascript/summernote/lang/summernote-' . $this->language->get('lang') . '.js');
                $this->document->addScript('view/javascript/summernote/opencart.js');
                $this->document->addStyle('view/javascript/summernote/summernote.css');
            }
    
		if (isset($this->request->post['owner_moto'])) {
			$data['moto'] = $this->request->post['owner_moto'];
		} else {
			$data['moto'] = $this->config->get('owner_moto');
		}

                if (isset($this->request->post['owner_moto_footer'])) {
			$data['moto_footer'] = $this->request->post['owner_moto_footer'];
		} else {
			$data['moto_footer'] = $this->config->get('owner_moto_footer');
		}
                
                if (isset($this->request->post['owner_second_block_title'])) {
			$data['second_block_title'] = $this->request->post['owner_second_block_title'];
		} else {
			$data['second_block_title'] = $this->config->get('owner_second_block_title');
		}
                
                if (isset($this->request->post['owner_second_block'])) {
			$data['second_block'] = $this->request->post['owner_second_block'];
		} else {
			$data['second_block'] = $this->config->get('owner_second_block');
		}
                
                if (isset($this->request->post['owner_phone1'])) {
                    $data['phone1'] = $this->request->post['owner_phone1'];
		} else {
                    $data['phone1'] = $this->config->get('owner_phone1');
		}
                
                if (isset($this->request->post['owner_phone1'])) {
                    $data['phone2'] = $this->request->post['owner_phone2'];
		} else {
                    $data['phone2'] = $this->config->get('owner_phone2');
		}
                
                if (isset($this->request->post['owner_phone3'])) {
                    $data['phone3'] = $this->request->post['owner_phone3'];
		} else {
                    $data['phone3'] = $this->config->get('owner_phone3');
		}
                
                if (isset($this->request->post['owner_email'])) {
                    $data['email'] = $this->request->post['owner_email'];
		} else {
                    $data['email'] = $this->config->get('owner_email');
		}
                
                if (isset($this->request->post['owner_skype'])) {
                    $data['skype'] = $this->request->post['owner_skype'];
		} else {
                    $data['skype'] = $this->config->get('owner_skype');
		}
                
                if (isset($this->request->post['owner_sсhedule'])) {
                    $data['schedule'] = $this->request->post['owner_sсhedule'];
		} else {
                    $data['schedule'] = $this->config->get('owner_sсhedule');
		}
                
                if (isset($this->request->post['owner_shop_description'])) {
                    $data['shop_description'] = $this->request->post['owner_shop_description'];
		} else {
                    $data['shop_description'] = $this->config->get('owner_shop_description');
		}
                
                if (isset($this->request->post['owner_brands_name'])) {
                    $data['brands_name'] = $this->request->post['owner_brands_name'];
		} else {
                    $data['brands_name'] = $this->config->get('owner_brands_name');
		}
                
                if (isset($this->request->post['owner_brands_sort_order'])) {
                    $data['brands_sort_order'] = $this->request->post['owner_brands_sort_order'];
		} else {
                    $data['brands_sort_order'] = $this->config->get('owner_brands_sort_order');
		}
                
                if (isset($this->request->post['owner_brands_icon'])) {
                    $data['brands_icon'] = $this->request->post['owner_brands_icon'];
		} else {
                    $data['brands_icon'] = $this->config->get('owner_brands_icon');
		}
                
                if (isset($this->request->post['owner_brands_icon2'])) {
                    $data['brands_icon2'] = $this->request->post['owner_brands_icon2'];
		} else {
                    $data['brands_icon2'] = $this->config->get('owner_brands_icon2');
		}
                
                if (isset($this->request->post['owner_additional_logo'])) {
                    $data['owner_additional_logo'] = $this->request->post['owner_additional_logo'];
		} else {
                    $data['owner_additional_logo'] = $this->config->get('owner_additional_logo');
		}
                
                if (isset($this->request->post['owner_promotions_meta_title'])) {
                    $data['promotions_meta_title'] = $this->request->post['owner_promotions_meta_title'];
		} else {
                    $data['promotions_meta_title'] = $this->config->get('owner_promotions_meta_title');
		}
		if (isset($this->request->post['owner_promotions_meta_description'])) {
                    $data['promotions_meta_description'] = $this->request->post['owner_promotions_meta_description'];
		} else {
                    $data['promotions_meta_description'] = $this->config->get('owner_promotions_meta_description');
		}
                if (isset($this->request->post['owner_promotions_meta_keywords'])) {
                    $data['promotions_meta_keywords'] = $this->request->post['owner_promotions_meta_keywords'];
		}else if( $this->config->get('owner_promotions_meta_keywords')){
                    $data['promotions_meta_keywords'] = $this->config->get('owner_promotions_meta_keywords');
                }else{
                    $data['promotions_meta_keywords']='';
                }
                
                $this->load->model('tool/image');

                if (isset($this->request->post['owner_brands_icon']) && is_file(DIR_IMAGE . $this->request->post['owner_brands_icon'])) {
			$data['thumb_brands_icon'] = $this->model_tool_image->resize($this->request->post['owner_brands_icon'], 60, 60);
		} elseif ($this->config->get('owner_brands_icon') && is_file(DIR_IMAGE . $this->config->get('owner_brands_icon'))) {
			$data['thumb_brands_icon'] = $this->model_tool_image->resize($this->config->get('owner_brands_icon'), 60, 60);
		} else {
			$data['thumb_brands_icon'] = $this->model_tool_image->resize('no_image.png', 60, 60);
		}
                
                if (isset($this->request->post['owner_brands_icon2']) && is_file(DIR_IMAGE . $this->request->post['owner_brands_icon2'])) {
			$data['thumb_brands_icon2'] = $this->model_tool_image->resize($this->request->post['owner_brands_icon2'], 60, 60);
		} elseif ($this->config->get('owner_brands_icon') && is_file(DIR_IMAGE . $this->config->get('owner_brands_icon2'))) {
			$data['thumb_brands_icon2'] = $this->model_tool_image->resize($this->config->get('owner_brands_icon2'), 60, 60);
		} else {
			$data['thumb_brands_icon2'] = $this->model_tool_image->resize('no_image.png', 60, 60);
		}
              
                if (isset($this->request->post['owner_additional_logo']) && is_file(DIR_IMAGE . $this->request->post['owner_additional_logo'])) {
			$data['thumb_additional_logo'] = $this->model_tool_image->resize($this->request->post['owner_additional_logo'], 200, 100);
		} elseif ($this->config->get('owner_additional_logo') && is_file(DIR_IMAGE . $this->config->get('owner_additional_logo'))) {
			$data['thumb_additional_logo'] = $this->model_tool_image->resize($this->config->get('owner_additional_logo'), 200, 100);
		} else {
			$data['thumb_additional_logo'] = $this->model_tool_image->resize('no_image.png', 200, 100);
		}
                
                if (isset($this->request->post['owner_free_shipping_sum'])) {
                    $data['owner_free_shipping_sum'] = $this->request->post['owner_free_shipping_sum'];
		} else {
                    $data['owner_free_shipping_sum'] = $this->config->get('owner_free_shipping_sum');
		}
                
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/owner', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/owner')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}