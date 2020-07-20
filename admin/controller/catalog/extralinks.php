<?php
class ControllerCatalogExtralinks extends Controller {
    private $error = array();

	public function index() {
            
           // $this->db->query("CREATE TABLE IF NOT EXISTS ".DB_PREFIX."menu_extra_links (id INT(11) PRIMARY KEY AUTO_INCREMENT, title VARCHAR(254), link VARCHAR(254), status TINYINT, sort_order INT(11), icon VARCHAR(254), parent_id INT(11))");
            
            $this->load->language('catalog/extralinks');

            $this->document->setTitle($this->language->get('heading_title'));

            $this->load->model('catalog/extralinks');

            $this->getList();
	}

	public function add() {
		$this->load->language('catalog/extralinks');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/extralinks');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_extralinks->addExtralink($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/extralinks', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/extralinks');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/extralinks');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_extralinks->editExtralink($this->request->get['extralink_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/extralinks', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/extralinks');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/extralinks');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $extralink_id) {
				$this->model_catalog_extralinks->deleteExtralink($extralink_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/extralinks', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/extralinks', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/extralinks/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/extralinks/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['extralinks'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$extralinks_total = $this->model_catalog_extralinks->getTotalExtralinks();

		$results = $this->model_catalog_extralinks->getExtralinks($filter_data);

		foreach ($results as $result) {
                    $data['extralinks'][] = array(
                        'extralink_id' => $result['id'],
                        'title'          => $result['title'],
                        'link' => $result['link'],
                        'sort_order'     => $result['sort_order'],
                        'icon'=>$result['icon'],
                        'parent_id'=>$result['parent_id'],
                        'status'=>$result['status'],
                        'edit'           => $this->url->link('catalog/extralinks/edit', 'token=' . $this->session->data['token'] . '&extralink_id=' . $result['id'] . $url, true),   
                    );
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_title'] = $this->language->get('column_title');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');
                $data['column_link'] = $this->language->get('column_link');
                

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_title'] = $this->url->link('catalog/extralinks', 'token=' . $this->session->data['token']  . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/extralinks', 'token=' . $this->session->data['token'] . $url, true);

		$url = '';

		$pagination = new Pagination();
		$pagination->total = $extralinks_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/extralinks', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($extralinks_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($extralinks_total - $this->config->get('config_limit_admin'))) ? $extralinks_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $extralinks_total, ceil($extralinks_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/extralinks_list', $data));
	}

	protected function getForm() {
    //CKEditor
    if ($this->config->get('config_editor_default')) {
        $this->document->addScript('view/javascript/ckeditor/ckeditor.js');
        $this->document->addScript('view/javascript/ckeditor/ckeditor_init.js');
    } else {
        $this->document->addScript('view/javascript/summernote/summernote.js');
        $this->document->addScript('view/javascript/summernote/lang/summernote-' . $this->language->get('lang') . '.js');
        $this->document->addScript('view/javascript/summernote/opencart.js');
        $this->document->addStyle('view/javascript/summernote/summernote.css');
    }

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['extralinks_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_extralinks_title'] = $this->language->get('entry_title');
		$data['entry_extralinks_description'] = $this->language->get('entry_description');
		
                $data['entry_icon'] = $this->language->get('entry_icon');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
                $data['entry_title'] = $this->language->get('entry_title');
                $data['entry_parent'] = $this->language->get('entry_parent');
                $data['text_none'] = $this->language->get('text_none');
                $data['column_link'] = $this->language->get('column_link');
                
	
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

//		if (isset($this->error['title'])) {
//			$data['error_title'] = $this->error['title'];
//		} else {
//			$data['error_title'] = array();
//		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/extralinks', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['extralink_id'])) {
			$data['action'] = $this->url->link('catalog/extralinks/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/extralinks/edit', 'token=' . $this->session->data['token'] . '&extralink_id=' . $this->request->get['extralink_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/extralinks', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['extralink_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
                    $extralink_info = $this->model_catalog_extralinks->getExtralink($this->request->get['extralink_id']);
		}

		$data['token'] = $this->session->data['token'];
		$data['ckeditor'] = $this->config->get('config_editor_default');

		
                if (isset($this->request->post['title'])) {
			$data['title'] = $this->request->post['title'];
		} elseif (isset($this->request->get['extralink_id'])) {
			$data['title'] = $extralink_info['title'];
		} else {
			$data['title'] = '';
		}
                
		if (isset($this->request->post['link'])) {
			$data['link'] = $this->request->post['link'];
		} elseif (isset($this->request->get['extralink_id'])) {
			$data['link'] = $extralink_info['link'];
		} else {
			$data['link'] = '';
		}

		if (isset($this->request->post['status'])) {
                    $data['status'] = $this->request->post['status'];
		} elseif (!empty($extralink_info)) {
			$data['status'] = $extralink_info['status'];
		} else {
			$data['status'] = false;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($extralink_info)) {
			$data['sort_order'] = $extralink_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
                
                if (isset($this->request->post['icon'])) {
			$data['icon'] = $this->request->post['icon'];
		} elseif (!empty($extralink_info)) {
			$data['icon'] = $extralink_info['icon'];
		} else {
			$data['icon'] = '';
		}
                
                if (isset($this->request->post['icon2'])) {
			$data['icon2'] = $this->request->post['icon2'];
		} elseif (!empty($extralink_info)) {
			$data['icon2'] = $extralink_info['icon2'];
		} else {
			$data['icon2'] = '';
		}
                
                $this->load->model('tool/image');

                if (isset($this->request->post['icon']) && is_file(DIR_IMAGE . $this->request->post['icon'])) {
			$data['thumb_icon'] = $this->model_tool_image->resize($this->request->post['icon'], 60, 60);
		} elseif (!empty($extralink_info) && is_file(DIR_IMAGE . $extralink_info['icon'])) {
			$data['thumb_icon'] = $this->model_tool_image->resize($extralink_info['icon'], 60, 60);
		} else {
			$data['thumb_icon'] = $this->model_tool_image->resize('no_image.png', 60, 60);
		}
                
                if (isset($this->request->post['icon2']) && is_file(DIR_IMAGE . $this->request->post['icon2'])) {
			$data['thumb_icon2'] = $this->model_tool_image->resize($this->request->post['icon2'], 60, 60);
		} elseif (!empty($extralink_info) && is_file(DIR_IMAGE . $extralink_info['icon2'])) {
			$data['thumb_icon2'] = $this->model_tool_image->resize($extralink_info['icon2'], 60, 60);
		} else {
			$data['thumb_icon2'] = $this->model_tool_image->resize('no_image.png', 60, 60);
		}
                
                if (isset($this->request->post['parent_id'])) {
			$data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($extralink_info)) {
			$data['parent_id'] = $extralink_info['parent_id'];
		} else {
			$data['parent_id'] = '';
		}

                $this->load->model("catalog/category");
                $data['categories'] = $this->model_catalog_category->getCategories();
                
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/extralinks_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/extralinks')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

}
