<?php
class ControllerExtensionModuleFbcomments extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/fbcomments');

		$this->document->setTitle($this->language->get('heading_title'));
                
		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate($this->request->post)) {
			$this->request->post['name_front'] = json_encode($this->request->post['name_front']);
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('fbcomments', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}
                
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_title'] = $this->language->get('entry_title');
                $data['entry_number'] = $this->language->get('entry_number');
                $data['entry_width'] = $this->language->get('entry_width');
		
		$data['entry_status'] = $this->language->get('entry_status');
                $data['entry_template'] = $this->language->get('entry_template');
                $data['example_template'] = $this->language->get('example_template');
                $data['help_template'] = $this->language->get('help_template');
                $data['entry_comments_height'] = $this->language->get('entry_comments_height');
                
                
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
                
                if (isset($this->error['comments_number'])) {
			$data['error_comments_number'] = $this->error['comments_number'];
		} else {
			$data['error_comments_number'] = '';
		}
                
                if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
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

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/fbcomments', 'token=' . $this->session->data['token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/fbcomments', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/fbcomments', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/fbcomments', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['name_front'])) {
			$data['name_front'] = $this->request->post['name_front'];
		} elseif (!empty($module_info)) {
			$data['name_front'] = json_decode($module_info['name_front'],true);
		} else {
			$data['name_front'] = '';
		}

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($module_info)) {
			$data['width'] = $module_info['width'];
		} else {
			$data['width'] = 300;
		}

                if (isset($this->request->post['comments_number'])) {
			$data['comments_number'] = $this->request->post['comments_number'];
		} elseif (!empty($module_info)) {
			$data['comments_number'] = $module_info['comments_number'];
		} else {
			$data['comments_number'] = '';
		}
                
                if (isset($this->request->post['comments_height'])) {
			$data['comments_height'] = $this->request->post['comments_height'];
		} elseif (!empty($module_info)) {
			$data['comments_height'] = $module_info['comments_height'];
		} else {
			$data['comments_height'] = 900;
		}
                
                if (isset($this->request->post['module_template'])) {
			$data['module_template'] = $this->request->post['module_template'];
		} elseif (!empty($module_info)) {
			$data['module_template'] = $module_info['module_template'];
		} else {
			$data['module_template'] = '';
		}
                
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/fbcomments', $data));
	}

	protected function validate($data) {
		if (!$this->user->hasPermission('modify', 'extension/module/fbcomments')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($data['name']) < 3) || (utf8_strlen($data['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!(isset($data['name_front']) && $data['name_front'])) {
			$this->error['name_front'] = $this->language->get('error_name');
		}
                
        if ($data['comments_number']<1 || $data['comments_number']>50){
			$this->error['comments_number'] = $this->language->get('error_comments_number');
		}
                
                if ($data['width']<50 || $data['width']>1200){
			$this->error['width'] = $this->language->get('error_width');
		}
                
		return !$this->error;
	}
}