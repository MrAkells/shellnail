<?php
class ControllerCatalogPromotions extends Controller
{
	private $error = array();

	public function index()
	{

		//$this->db->query("CREATE TABLE IF NOT EXISTS ".DB_PREFIX."promotions (promo_id INT(11) PRIMARY KEY AUTO_INCREMENT, title VARCHAR(254), image VARCHAR(254), status TINYINT, sort_order INT(11), description TEXT, type INT(3), date_start DATE, date_end DATE, settings VARCHAR(250))");

		//           $this->db->query("ALTER TABLE " . DB_PREFIX . "promotions ADD COLUMN parent_id INT(11) DEFAULT 0");
		//           $this->db->query("ALTER TABLE " . DB_PREFIX . "promotions ADD COLUMN hierarchy INT(11) DEFAULT 0");
		//           $this->db->query("ALTER TABLE " . DB_PREFIX . "promotions ADD COLUMN meta_title VARCHAR(254) DEFAULT NULL");
		//           $this->db->query("ALTER TABLE " . DB_PREFIX . "promotions ADD COLUMN meta_description TEXT DEFAULT NULL");
		//           $this->db->query("ALTER TABLE " . DB_PREFIX . "promotions ADD COLUMN meta_keywords TEXT DEFAULT NULL");
		//$this->db->query("ALTER TABLE " . DB_PREFIX . "promotions ADD COLUMN meta_h1 TEXT DEFAULT NULL");

		$this->load->language('catalog/promotions');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/promotions');

		$this->getList();
	}

	public function add()
	{
		$this->load->language('catalog/promotions');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/promotions');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm($this->request->post)) {
			$this->model_catalog_promotions->addPromotion($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/promotions', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit()
	{
		$this->load->language('catalog/promotions');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/promotions');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm($this->request->post, $this->request->get['promo_id'])) {
			$this->model_catalog_promotions->editPromotion($this->request->get['promo_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/promotions', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm(true);
	}

	public function delete()
	{
		$this->load->language('catalog/promotions');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/promotions');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $promo_id) {

				$promo_for_del = $this->model_catalog_promotions->getPromotion(['promo_id' => $promo_id]);

				if ($promo_for_del['hierarchy'] != '1') {
					if ($promo_for_del['parent_id']) {
						$query2 = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "promotions WHERE parent_id = '" . (int)$promo_for_del['parent_id'] . "'");
						if ($query2->num_rows < 2) {
							$this->db->query("UPDATE " . DB_PREFIX . "promotions SET hierarchy='0' WHERE promo_id='" . (int)$promo_for_del['parent_id'] . "'");
						}
					}
					$this->model_catalog_promotions->deletePromotion($promo_id);

					$this->session->data['success'] = $this->language->get('text_success');
				} else {
					$this->session->data['error'] = 'Сначала удалите вложеные промо акции';
				}
			}

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/promotions', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList()
	{

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
			'href' => $this->url->link('catalog/promotions', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/promotions/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/promotions/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['promotions'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$promotions_total = $this->model_catalog_promotions->getTotalPromotions();

		$results = $this->model_catalog_promotions->getPromotions($filter_data);

		foreach ($results as $result) {
			$data['promotions'][$result['promo_id']] = array(
				'promo_id' => $result['promo_id'],
				'title'          => $result['title'],
				'sort_order'     => $result['sort_order'],
				'parent_id' => $result['parent_id'],
				'children' => [],
				'status' => $result['status'],
				'active' => $result['ongoing'],
				'edit'           => $this->url->link('catalog/promotions/edit', 'token=' . $this->session->data['token'] . '&promo_id=' . $result['promo_id'] . $url, true),
			);
		}

		foreach ($data['promotions'] as $value) {
			if ($value['parent_id'] && !in_array($value['title'], $data['promotions'][$value['parent_id']]['children'])) {
				$data['promotions'][$value['parent_id']]['children'][] = $value['title'];
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_title'] = $this->language->get('column_title');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');
		//$data['column_link'] = $this->language->get('column_link');


		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

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

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_title'] = $this->url->link('catalog/promotions', 'token=' . $this->session->data['token']  . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/promotions', 'token=' . $this->session->data['token'] . $url, true);

		$url = '';

		$pagination = new Pagination();
		$pagination->total = $promotions_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/promotions', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($promotions_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($promotions_total - $this->config->get('config_limit_admin'))) ? $promotions_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $promotions_total, ceil($promotions_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/promotions_list', $data));
	}

	protected function getForm($edit = false)
	{

		$this->document->addScript('view/javascript/promotion.js');

		if ($edit) {
			$data['edit_mode'] = 1;
		} else {
			$data['edit_mode'] = 0;
		}

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

		$data['text_form'] = !isset($this->request->get['promotions_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_promotions_title'] = $this->language->get('entry_title');
		$data['entry_description'] = $this->language->get('entry_description');

		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_percent'] = $this->language->get('entry_percent');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_type'] = $this->language->get('entry_type');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_parent'] = $this->language->get('entry_parent');
		$data['text_none'] = $this->language->get('text_none');
		$data['column_link'] = $this->language->get('column_link');
		$data['entry_short_title'] = $this->language->get('entry_short_title');
		$data['entry_main'] = $this->language->get('entry_main');

		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_category'] = $this->language->get('column_category');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_action'] = $this->language->get('column_action');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_save_first'] = $this->language->get('text_save_first');

		$data['entry_discount'] = $this->language->get('entry_discount');

		$data['text_select'] = $this->language->get('text_select');
		$data['entry_group'] = $this->language->get('entry_group');

		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
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
			'href' => $this->url->link('catalog/promotions', 'token=' . $this->session->data['token'] . $url, true)
		);



		if (!isset($this->request->get['promo_id'])) {
			$data['action'] = $this->url->link('catalog/promotions/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/promotions/edit', 'token=' . $this->session->data['token'] . '&promo_id=' . $this->request->get['promo_id'] . $url, true);
			$data['promo_id'] = $this->request->get['promo_id'];
		}

		$data['cancel'] = $this->url->link('catalog/promotions', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['promo_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
			$data['breadcrumbs'][] = array(
				'text' => 'Настройки акции',
				'href' => $this->url->link('catalog/promotions/edit', 'token=' . $this->session->data['token'] . '&promo_id=' . $this->request->get['promo_id'], true)
			);

			$filter_data['promo_id'] = $this->request->get['promo_id'];
			if (isset($this->request->get['sort'])) {
				$filter_data['sort'] = $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$filter_data['order'] = $this->request->get['order'];
			}
			$promo_info = $this->model_catalog_promotions->getPromotion($filter_data);
		}

		$data['token'] = $this->session->data['token'];
		$data['ckeditor'] = $this->config->get('config_editor_default');


		if (isset($this->request->post['title'])) {
			$data['title'] = $this->request->post['title'];
		} elseif (isset($this->request->get['promo_id'])) {
			$data['title'] = $promo_info['title'];
		} else {
			$data['title'] = '';
		}

		if (isset($this->request->post['short_title'])) {
			$data['short_title'] = $this->request->post['short_title'];
		} elseif (isset($this->request->get['promo_id'])) {
			$data['short_title'] = $promo_info['short_title'];
		} else {
			$data['short_title'] = '';
		}

		if (isset($this->request->post['description'])) {
			$data['description'] = html_entity_decode($this->request->post['description']);
		} elseif (isset($promo_info['description'])) {
			$data['description'] = html_entity_decode($promo_info['description']);
		} else {
			$data['description'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($promo_info)) {
			$data['status'] = $promo_info['status'];
		} else {
			$data['status'] = false;
		}


		if (isset($this->request->post['main'])) {
			$data['main'] = $this->request->post['main'];
		} elseif (!empty($promo_info)) {
			$data['main'] = $promo_info['main'];
		} else {
			$data['main'] = false;
		}

		if (isset($this->request->post['parent_id'])) {
			$data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($promo_info) && isset($promo_info['parent_id'])) {
			$data['parent_id'] = $promo_info['parent_id'];
		} else {
			$data['parent_id'] = 0;
		}

		$potential_parents = [];
		if (!$edit || $promo_info['hierarchy'] != 1) {
			$potential_parents = $this->model_catalog_promotions->getPromotions(['without_children' => true]);
		}

		$data['parents'] = [];
		foreach ($potential_parents as $par) {
			$data['parents'][$par['promo_id']] = $par['title'];
		}

		if (isset($this->request->post['hierarchy'])) {
			$data['hierarchy'] = $this->request->post['hierarchy'];
		} elseif (!empty($promo_info) && isset($promo_info['hierarchy'])) {
			$data['hierarchy'] = $promo_info['hierarchy'];
			unset($data['parents'][$promo_info['promo_id']]);
		} else {
			$data['hierarchy'] = 0;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($promo_info)) {
			$data['sort_order'] = $promo_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($promo_info)) {
			$data['image'] = $promo_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb_image'] = $this->model_tool_image->resize($this->request->post['image'], 600, 300);
		} elseif (!empty($promo_info) && is_file(DIR_IMAGE . $promo_info['image'])) {
			$data['thumb_image'] = $this->model_tool_image->resize($promo_info['image'], 600, 300);
		} else {
			$data['thumb_image'] = $this->model_tool_image->resize('no_image.png', 600, 300);
		}

		if (isset($this->request->post['image_m'])) {
			$data['image_m'] = $this->request->post['image_m'];
		} elseif (!empty($promo_info)) {
			$data['image_m'] = $promo_info['image_m'];
		} else {
			$data['image_m'] = '';
		}


		if (isset($this->request->post['image_m']) && is_file(DIR_IMAGE . $this->request->post['image_m'])) {
			$data['thumb_image_m'] = $this->model_tool_image->resize($this->request->post['image_m'], 600, 300);
		} elseif (!empty($promo_info) && is_file(DIR_IMAGE . $promo_info['image'])) {
			$data['thumb_image_m'] = $this->model_tool_image->resize($promo_info['image_m'], 600, 300);
		} else {
			$data['thumb_image_m'] = $this->model_tool_image->resize('no_image.png', 600, 300);
		}

		if (isset($this->request->post['date_start'])) {
			$data['date_start'] = $this->request->post['date_start'];
		} elseif (!empty($promo_info)) {
			$timestamp = strtotime($promo_info['date_start']);
			$data['date_start'] = ($promo_info['date_start'] != '0000-00-00 00:00') ? date('Y-m-d h:i', $timestamp) : '';
		} else {
			$data['date_start'] = date('Y-m-d h:i');
		}

		if (isset($this->request->post['date_end'])) {
			$data['date_end'] = $this->request->post['date_end'];
		} elseif (!empty($promo_info)) {
			$timestamp = strtotime($promo_info['date_end']);
			$data['date_end'] = ($promo_info['date_end'] != '0000-00-00 00:00') ? date('Y-m-d h:i', $timestamp) : '';
		} else {
			$data['date_end'] = date('Y-m-d h:i');
		}

		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($promo_info)) {
			$data['type'] = $promo_info['type'];
		} else {
			$data['type'] = 0;
		}

		$data['types'] = array(
			1 => 'скидка(процент)',
			2 => 'скидка(фиксированная сумма)',
			3 => 'вместе дешевле'
		);

		if (isset($this->request->post['percent'])) {
			$data['percent'] = $this->request->post['percent'];
		} elseif (!empty($promo_info)) {
			$data['percent'] = $promo_info['settings'];
		} else {
			$data['percent'] = '';
		}

		if (isset($this->request->post['quantity'])) {
			$data['quantity'] = $this->request->post['quantity'];
		} elseif (!empty($promo_info)) {
			$data['quantity'] = $promo_info['settings'];
		} else {
			$data['quantity'] = '';
		}

		if (isset($this->request->post['discount'])) {
			$data['discount'] = $this->request->post['discount'];
		} elseif (!empty($promo_info)) {
			$data['discount'] = $promo_info['settings'];
		} else {
			$data['discount'] = '';
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($promo_info)) {
			$data['keyword'] = $promo_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['meta_title'])) {
			$data['meta_title'] = $this->request->post['meta_title'];
		} elseif (!empty($promo_info) && isset($promo_info['meta_title'])) {
			$data['meta_title'] = $promo_info['meta_title'];
		} else {
			$data['meta_title'] = '';
		}

		if (isset($this->request->post['meta_h1'])) {
			$data['meta_h1'] = $this->request->post['meta_h1'];
		} elseif (!empty($promo_info) && isset($promo_info['meta_h1'])) {
			$data['meta_h1'] = $promo_info['meta_h1'];
		} else {
			$data['meta_h1'] = '';
		}

		if (isset($this->request->post['meta_description'])) {
			$data['meta_description'] = $this->request->post['meta_description'];
		} elseif (!empty($promo_info) && isset($promo_info['meta_description'])) {
			$data['meta_description'] = $promo_info['meta_description'];
		} else {
			$data['meta_description'] = '';
		}

		if (isset($this->request->post['meta_keywords'])) {
			$data['meta_keywords'] = $this->request->post['meta_keywords'];
		} elseif (!empty($promo_info) && isset($promo_info['meta_keywords'])) {
			$data['meta_keywords'] = $promo_info['meta_keywords'];
		} else {
			$data['meta_keywords'] = '';
		}

		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		$this->load->model('catalog/manufacturer');
		$data['categories'] = $this->model_catalog_category->getCategories();
		$data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();

		if (!empty($promo_info)) {
			$products = $promo_info['products'];
			$data['products'] = array();

			foreach ($products as $result) {

				$category =  $this->model_catalog_product->getProductCategories($result['product_id']);

				if (is_file(DIR_IMAGE . $result['image'])) {
					$image = $this->model_tool_image->resize($result['image'], 40, 40);
				} else {
					$image = $this->model_tool_image->resize('no_image.png', 40, 40);
				}


				$data['products'][] = array(
					'product_id' => $result['product_id'],
					'image'      => $image,
					'name'       => $result['name'],
					'price'      => $result['price'],
					'category'   => $category,
					'quantity'   => $result['quantity'],
					'edit'       => $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'] . $url, true)
				);
			}

			$data['selected'] = $promo_info['selected'];
		} else {
			$data['products'] = [];
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/promotions_form', $data));
	}

	public function saveJustPromoProducts()
	{
		$this->load->model('catalog/promotions');
		if (isset($this->request->post['selected']) && $this->request->post['selected'] && isset($this->request->post['promo_id']) && $this->request->post['promo_id']) {
			$this->model_catalog_promotions->savePromoProducts($this->request->post);
			$this->response->setOutput(json_encode(['success' => 1]));
		} else {
			$this->response->setOutput(json_encode(['success' => 0]));
		}
	}

	public function deleteCandidatesAndPromoProducts()
	{
		$this->load->model('catalog/promotions');
		if (isset($this->request->post['selected']) && $this->request->post['selected'] && isset($this->request->post['promo_id']) && $this->request->post['promo_id']) {
			$this->model_catalog_promotions->savePromoProducts($this->request->post);
			$this->model_catalog_promotions->deleteCandidateProducts($this->request->post);

			$this->response->setOutput(json_encode(['success' => 1]));
		} else {
			$this->response->setOutput(json_encode(['success' => 0]));
		}
	}

	public function addCandidate()
	{
		$this->load->model('catalog/promotions');
		$data['promo_id'] = $this->request->post['promo_id'];
		$data['product'] = [$this->request->post['product_id']];
		$this->model_catalog_promotions->addCandidateProducts($data);
		$this->response->setOutput(json_encode(['succes' => 1]));
	}

	public function checkGroup()
	{
		$this->load->model('catalog/promotions');
		$data['category_id'] = $this->request->post['category_id'];
		$data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		$data['promo_id'] = $this->request->post['promo_id'];
		$results = $this->model_catalog_promotions->getEligibleProducts($data);

		$this->response->setOutput(json_encode(['success' => 1, 'count' => count($results)]));
	}

	public function addCandidatesGroup()
	{
		$this->load->model('catalog/promotions');
		$data['category_id'] = $this->request->post['category_id'];
		$data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		$data['promo_id'] = $this->request->post['promo_id'];
		$results = $this->model_catalog_promotions->getEligibleProducts($data);
		$data['product'] = [];
		foreach ($results as $result) {
			$data['product'][] = $result['product_id'];
		}
		$this->model_catalog_promotions->addCandidatesGroup($data);
		$this->response->setOutput(json_encode(['success' => 1]));
	}

	public function changeGroupPrice()
	{
		$this->load->model('catalog/promotions');
		if (isset($this->request->post['selected']) && $this->request->post['selected'] && isset($this->request->post['change_price']) && $this->request->post['change_price']) {
			//var_dump($this->request->post['selected']);
			$this->model_catalog_promotions->changeBasePrices($this->request->post);

			$this->response->setOutput(json_encode(['success' => 1]));
		}
	}

	protected function validateForm($data = [])
	{

		if (!$this->user->hasPermission('modify', 'catalog/promotions')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$data['keyword']) {
			$this->error['warning'] = 'SEO-url обязателен!';
		}

		return !$this->error;
	}
}
