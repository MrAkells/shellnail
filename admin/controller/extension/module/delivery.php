<?php
class ControllerExtensionModuleDelivery extends Controller {
	private $error = array();
        
        public function install(){           
            $this->load->model('extension/module/delivery');                
            $this->model_extension_module_delivery->createTable();
            
            
        }
        
        public function uninstall(){
            $this->load->model('extension/module/delivery');                
            $this->model_extension_module_delivery->deleteTable();
            
        }
        

	public function index() {
            
		$this->load->language('extension/module/delivery');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		$this->load->model('setting/setting');
                 $this->load->model('extension/module/delivery');
                $this->load->model('customer/customer_group');
                
                
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('delivery', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
                        
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}
                
                if ($this->config->get('config_editor_default')) {
                    $this->document->addScript('view/javascript/ckeditor/ckeditor.js');
                    $this->document->addScript('view/javascript/ckeditor/ckeditor_init.js');
                } else {
                    $this->document->addScript('view/javascript/summernote/summernote.js');
                    $this->document->addScript('view/javascript/summernote/lang/summernote-' . $this->language->get('lang') . '.js');
                    $this->document->addScript('view/javascript/summernote/opencart.js');
                    $this->document->addStyle('view/javascript/summernote/summernote.css');
                }
                
                
                $setting = $this->model_setting_setting->getSetting('config');
		$language = $this->model_extension_module_delivery->getLanguageId($setting['config_admin_language']);                
                                         
                ///////////////////////////////OPENCART GROUPS//////////////////////////////////////////               
                $group_id = $this->model_extension_module_delivery->getGroupsId();                
                foreach ($group_id as $id)
                {
                    $data_group = array();
                    $group_descript = $this->model_customer_customer_group->getCustomerGroupDescriptions((int)$id['customer_group_id']);
                    
                    $data_group[] = $group_descript[(int)$language];
                   
                    foreach ($data_group as $group)
                    {
                        $data['groups'][] = array(
                            'group_id' => $id['customer_group_id'],
                            'group_name' => $group['name']
                        );
                    }
                    
                }             
                //////////////////////////////////////////////////////////////////////////////////
                                             /*AND GROUPS*/
                
                ////////////////////Вывод списка подписчиков в админку///////////////////////////
                $data['subscribers'] = $this->model_extension_module_delivery->getSubscribers();
                //////////////////////////////////and lists////////////////////////////////////

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
                
                /*Переменные редактора сообщений*/
                $data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['go_editor'] = $this->language->get('text_editor');
		$data['return'] = $this->language->get('text_return');
		$data['show_list'] = $this->language->get('text_show_list');
		$data['hide_list'] = $this->language->get('text_hide_list');
		$data['show_list_groups'] = $this->language->get('text_show_groups_list');
		$data['hide_list_groups'] = $this->language->get('text_hide_groups_list');
		$data['message_user'] = $this->language->get('text_send_message_user');
		$data['text_send'] = $this->language->get('text_send');
		$data['text_name'] = $this->language->get('text_name');
		$data['name_group'] = $this->language->get('name_group');
		$data['head'] = $this->language->get('text_head');
		$data['head_default'] = $this->language->get('text_head_default');
		$data['choice_checked'] = $this->language->get('text_choice_checked');
		$data['delete_checked'] = $this->language->get('text_delete_checked');
		$data['sender'] = $this->language->get('text_sender');
		$data['sender_default'] = $this->language->get('text_sender_default');
		$data['error'] = $this->language->get('text_error');
		$data['error_group'] = $this->language->get('text_error_group');
		$data['success_send'] = $this->language->get('text_send_success');
                
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/delivery', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('extension/module/delivery', 'token=' . $this->session->data['token'], 'SSL');
                $data['url']    = $this->url->link('extension/module/delivery/message', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		if (isset($this->request->post['delivery_status'])) {
			$data['delivery_status'] = $this->request->post['delivery_status'];
		} else {
			$data['delivery_status'] = $this->config->get('delivery_status');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/delivery.tpl', $data));
	}
        
        public function message()
        {
            if($this->request->server['REQUEST_METHOD'] == 'POST')
            {
                $json = file_get_contents("php://input");
                $object = json_decode($json);
                
                $settings_message = (array)$object->message;
                $settings_letters = (array)$object->settings;
                $settings_groups  = (array)$object->groups;
               
                if(!empty($settings_message['send_sender']) 
                    && !empty($settings_message['send_head'])
                    && !empty($settings_message['send_content']))
                {
                    if(!empty($settings_letters) || !empty($settings_groups))
                    {
                        $this->load->language('module/delivery');
                        $this->load->model('extension/module/delivery');
                        $this->load->model('customer/customer_group');

                        $data_message = array();

                        if(!empty($settings_letters)){
                            $settings_letters = (array)$object->settings;
                            $data_message = array_merge($data_message, $this->model_extension_module_delivery->getEmails($settings_letters));                           
                        }

                        if(!empty($settings_groups)){
                            $settings_groups = (array)$object->groups;
                            $data_message = array_merge($data_message, $this->model_extension_module_delivery->getGroups($settings_groups));                    
                        }

                        foreach ($data_message as $name => $email) 
                        {
                           
                            $textHTML = html_entity_decode($settings_message['send_content'], ENT_QUOTES, 'UTF-8');
                            $textmess = str_replace("{NAME}", $name, $textHTML);

                            $message  = '<html dir="ltr" lang="en">' . "\n";
                            $message .= '  <head>' . "\n";
                            $message .= '    <title>' . $settings_message['send_head'] . '</title>' . "\n";
                            $message .= '    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
                            $message .= '  </head>' . "\n";
                            $message .= '  <body>' . $textmess . '</body>' . "\n";
                            $message .= '</html>' . "\n";

                            
                            $mail = new Mail($this->config->get('config_mail'));
                            $mail->setTo($email);
                            $mail->setFrom($this->config->get('config_email'));
                            $mail->setSender($settings_message['send_sender']);
                            $mail->setSubject(html_entity_decode($settings_message['send_head'], ENT_QUOTES, 'UTF-8'));
                            $mail->setHtml($message);
                            $mail->send();
                            
                        }
                        echo 'success';
                    }
                    else
                    {
                        echo 'error_groups';
                    }
                }
                else
                {
                    echo 'error';
                }    
            }            
        }

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/delivery')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
       
}
