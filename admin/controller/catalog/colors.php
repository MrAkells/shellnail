<?php
class ControllerCatalogColors extends Controller {
	private $error = array();

	public function index() {
                
            // $this->db->query("CREATE TABLE ".DB_PREFIX."colors (color_id INT(11) PRIMARY KEY AUTO_INCREMENT, name VARCHAR(254), code VARCHAR(254))");
          
            $this->load->language('catalog/colors');

            $this->document->setTitle($this->language->get('heading_title'));

            $this->load->model('catalog/colors');

            $this->getList();
	}

	public function add() {
		$this->load->language('catalog/colors');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/colors');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_colors->addColor($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/colors', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/colors');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/colors');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_colors->editColor($this->request->get['color_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/colors', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/colors');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/colors');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $color_id) {
				$this->model_catalog_colors->deleteColor($color_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/colors', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'cd.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

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
			'href' => $this->url->link('catalog/colors', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/colors/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/colors/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['colors'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$colors_total = $this->model_catalog_colors->getTotalColors();

		$results = $this->model_catalog_colors->getColors($filter_data);

		foreach ($results as $result) {
			$data['colors'][] = array(
				'color_id' => $result['color_id'],
				'name'        => $result['name'],
				'code'  => $result['code'],
				'edit'        => $this->url->link('catalog/colors/edit', 'token=' . $this->session->data['token'] . '&color_id=' . $result['color_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_code'] = $this->language->get('column_code');
		$data['column_action'] = $this->language->get('column_action');

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

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/colors', 'token=' . $this->session->data['token'] . '&sort=c.name' . $url, true);
		$data['sort_code'] = $this->url->link('catalog/colors', 'token=' . $this->session->data['token'] . '&sort=c.code' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $colors_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/colors', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($colors_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($colors_total - $this->config->get('config_limit_admin'))) ? $colors_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $colors_total, ceil($colors_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/colors_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['color_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_code'] = $this->language->get('entry_code');
		

		$data['help_code'] = $this->language->get('help_code');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}


		if (isset($this->error['code'])) {
			$data['error_code'] = $this->error['code'];
		} else {
			$data['error_code'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

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
			'href' => $this->url->link('catalog/colors', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['color_id'])) {
			$data['action'] = $this->url->link('catalog/colors/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/colors/edit', 'token=' . $this->session->data['token'] . '&color_id=' . $this->request->get['color_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/colors', 'token=' . $this->session->data['token'] . $url, true);


		if (isset($this->request->get['color_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$color_info = $this->model_catalog_colors->getColor($this->request->get['color_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->get['color_id'])) {
			$data['color_id'] = $this->request->get['color_id'];
		} else {
			$data['color_id'] = 0;
		}

		if (isset($this->request->post['color_description'])) {
			$data['color_description'] = $this->request->post['color_description'];
		} elseif (isset($this->request->get['color_id'])) {
			$data['color_description'] = $this->model_catalog_colors->getColorDescription($this->request->get['color_id']);
		} else {
			$data['color_description'] = array();
		}

		if (isset($this->request->post['code'])) {
			$data['code'] = $this->request->post['code'];
		} elseif (!empty($color_info)) {
			$data['code'] = $color_info['code'];
		} else {
			$data['code'] = '';
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/colors_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/colors')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}


		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/colors')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
            
                $this->load->model('catalog/colors');

                if(isset($this->request->get['name'])){
                    $name=$this->request->get['name'];
                }
                
                $results=$this->model_catalog_colors->getEligibleColors($name);
                $colors=array();
                
                foreach($results as $color){
                    $colors[]=array(
                        'name'=> $color['name'],
                        'code'=> $color['code'],
                    ); 
                }

		$this->response->setOutput(json_encode($colors));
	}
}