<?php
class ControllerExtensionModulePageNoIndex extends Controller
{
	private $error = array();

	public function install()
	{

		$this->load->model('extension/module/page_no_index');

		$this->model_extension_module_page_no_index->createTable();
	}

	public function index()
	{
		$this->load->language('extension/module/page_no_index');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('sd_pni', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');

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
			'href' => $this->url->link('extension/module/page_no_index', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/page_no_index', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);


		if (isset($this->request->post['sd_pni_status'])) {
			$data['sd_pni_status'] = $this->request->post['sd_pni_status'];
		} else {
			$data['sd_pni_status'] = $this->config->get('sd_pni_status');
		}
		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/page_no_index', $data));
	}


	protected function validate()
	{
		if (!$this->user->hasPermission('modify', 'extension/module/page_no_index')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}

    public function urls()
	{
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

        if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

        if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->load->language('extension/module/page_no_index');

		$this->document->setTitle($this->language->get('heading_title'));
		$data['heading_title'] = $this->language->get('heading_title');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/page_no_index/urls', 'token=' . $this->session->data['token'] . $url, true)
		);


		$data['add'] = $this->url->link('extension/module/page_no_index/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('extension/module/page_no_index/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
        $data['button_filter'] = $this->language->get('button_filter');
        $data['token'] = $this->session->data['token'];

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_url'] = $this->language->get('column_url');
		$data['column_action'] = $this->language->get('column_action');

		$data['urls'] = array();

		$this->load->model('extension/module/page_no_index');
        $filter_data = array(
			'filter_name'	  => $filter_name,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);
        $urls_total = $this->model_extension_module_page_no_index->getTotalUrls($filter_data);
		$results = $this->model_extension_module_page_no_index->getUrls($filter_data);

		foreach ($results as $result) {
			$data['urls'][] = array(
				'page_id'  => $result['page_id'],
				'url'      => $result['url'],
				'edit'     => $this->url->link('extension/module/page_no_index/edit', 'token=' . $this->session->data['token'] . '&page_id=' . $result['page_id'], true)
			);
		}

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
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

		$pagination = new Pagination();
		$pagination->total = $urls_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/module/page_no_index/urls', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($urls_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($urls_total - $this->config->get('config_limit_admin'))) ? $urls_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $urls_total, ceil($urls_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/page_no_index_list', $data));
	}

    public function add()
	{
		$this->load->language('extension/module/page_no_index');
		$this->load->model('extension/module/page_no_index');

		$this->document->setTitle($this->language->get('heading_title'));


		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm($this->request->post)) {

			$this->model_extension_module_page_no_index->add($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module/page_no_index/urls', 'token=' . $this->session->data['token'], true));
		}

		$this->getForm();
	}

	public function edit()
	{
		$this->load->language('extension/module/page_no_index');
		$this->load->model('extension/module/page_no_index');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm($this->request->post)) {
			$this->model_extension_module_page_no_index->edit($this->request->get['page_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module/page_no_index/urls', 'token=' . $this->session->data['token'], true));
		}

		$this->getForm(true);
	}

	public function delete()
	{
		$this->load->language('extension/module/page_no_index');
		$this->load->model('extension/module/page_no_index');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->post['selected'])) {

			$this->model_extension_module_page_no_index->delete($this->request->post['selected']);

			$this->session->data['success'] = $this->language->get('text_success');
		}

		$this->response->redirect($this->url->link('extension/module/page_no_index/urls', 'token=' . $this->session->data['token'], true));
	}

	protected function getForm($edit = false)
	{
		if ($edit) {
			$data['edit_mode'] = 1;
		} else {
			$data['edit_mode'] = 0;
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['page_id']) ? $this->language->get('text_add') : $this->language->get('text_edit_url');

		$data['entry_url'] = $this->language->get('entry_url');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/page_no_index/urls', 'token=' . $this->session->data['token'], true)
		);



		if (!isset($this->request->get['page_id'])) {
			$data['action'] = $this->url->link('extension/module/page_no_index/add', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/page_no_index/edit', 'token=' . $this->session->data['token'] . '&page_id=' . $this->request->get['page_id'], true);
			$data['page_id'] = $this->request->get['page_id'];
			$url_info = $this->model_extension_module_page_no_index->getUrl($this->request->get['page_id']);
		}

		$data['cancel'] = $this->url->link('extension/module/page_no_index/urls', 'token=' . $this->session->data['token'], true);

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->request->post['url'])) {
			$data['url'] = $this->request->post['url'];
		} elseif (isset($this->request->get['page_id'])) {
			$data['url'] = $url_info['url'];
		} else {
			$data['url'] = '';
		}
		if (isset($this->request->post['description'])) {
			$data['description'] = $this->request->post['description'];
		} elseif (isset($this->request->get['page_id'])) {
			$data['description'] = $url_info['description'];
		} else {
			$data['description'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/page_no_index_form', $data));
	}

	protected function validateForm($data = [])
	{

		if (!$this->user->hasPermission('modify', 'extension/module/page_no_index')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$data['url']) {
			$this->error['warning'] = $this->language->get('error_url');
		}


		return !$this->error;
	}
}