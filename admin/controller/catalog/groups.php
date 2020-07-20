<?php
class ControllerCatalogGroups extends Controller {
    private $error = array();

	public function index() {
            
            //$this->db->query("CREATE TABLE IF NOT EXISTS ".DB_PREFIX."groups (group_id INT(11) PRIMARY KEY AUTO_INCREMENT, title VARCHAR(254), type INT(2))");
          
            $this->load->language('catalog/groups');

            $this->document->setTitle($this->language->get('heading_title'));

            $this->load->model('catalog/groups');

            $this->getList();
	}

	public function add() {
		$this->load->language('catalog/groups');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/groups');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {
			$this->model_catalog_groups->addGroup($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/groups', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/groups');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/groups');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {
			$this->model_catalog_groups->editGroup($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/groups', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm(true);
	}

	public function delete() {
		$this->load->language('catalog/groups');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/groups');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $promo_id) {
				$this->model_catalog_groups->deleteGroup($promo_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/groups', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/groups', 'token=' . $this->session->data['token'] , true)
		);

		$data['add'] = $this->url->link('catalog/groups/add', 'token=' . $this->session->data['token'] , true);
		$data['delete'] = $this->url->link('catalog/groups/delete', 'token=' . $this->session->data['token'] , true);

		$data['groups'] = array();

		$results = $this->model_catalog_groups->getGroups();

		foreach ($results as $result) {
                    $count=count($this->model_catalog_groups->getGroupProducts(['group_id'=>$result['group_id']]));
                    
                    $data['groups'][] = array(
                        'group_id' => $result['group_id'],
                        'title'          => $result['title'],
                       
                        'quantity' => $count,
                        'edit'           => $this->url->link('catalog/groups/edit', 'token=' . $this->session->data['token'] . '&group_id=' . $result['group_id'] , true),   
                    );
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_title'] = $this->language->get('column_title');
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

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/groups_list', $data));
	}

	protected function getForm($edit=false) {
  
            if($edit){
                $data['edit_mode']=1;
            }else{
                $data['edit_mode']=0;
            }
   
            $data['heading_title'] = $this->language->get('heading_title');

            $data['text_form'] = !isset($this->request->get['groups_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
            $data['text_default'] = $this->language->get('text_default');
            $data['text_enabled'] = $this->language->get('text_enabled');
            $data['text_disabled'] = $this->language->get('text_disabled');

            $data['entry_groups_title'] = $this->language->get('entry_title');
                
            $data['entry_type'] = $this->language->get('entry_type');
		
            $data['entry_title'] = $this->language->get('entry_title');
             $data['entry_product'] = $this->language->get('entry_product');
             
            $data['column_image'] = $this->language->get('column_image');
            $data['column_name'] = $this->language->get('column_name');
            $data['column_category'] = $this->language->get('column_category');
            $data['column_price'] = $this->language->get('column_price');
            $data['column_quantity'] = $this->language->get('column_quantity');
            $data['column_action'] = $this->language->get('column_action');
            $data['text_no_results'] = $this->language->get('text_no_results');
            $data['text_save_first'] = $this->language->get('text_save_first');
               
            $data['text_select'] = $this->language->get('text_select');
            $data['entry_group'] = $this->language->get('entry_group');

            $data['button_save'] = $this->language->get('button_save');
            $data['button_cancel'] = $this->language->get('button_cancel');

            if (isset($this->error['warning'])) {
		$data['error_warning'] = $this->error['warning'];
            } else {
		$data['error_warning'] = '';
            }

            $url = '';

            $data['breadcrumbs'] = array();

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
            );

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('catalog/groups', 'token=' . $this->session->data['token'] . $url, true)
            );



            if (!isset($this->request->get['group_id'])) {
                $data['action'] = $this->url->link('catalog/groups/add', 'token=' . $this->session->data['token'] . $url, true);
            } else {
                $data['action'] = $this->url->link('catalog/groups/edit', 'token=' . $this->session->data['token'] . '&group_id=' . $this->request->get['group_id'] . $url, true);
                $data['group_id'] = $this->request->get['group_id'];
            }

            $data['cancel'] = $this->url->link('catalog/groups', 'token=' . $this->session->data['token'] . $url, true);

            if (isset($this->request->get['group_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
                $data['breadcrumbs'][] = array(
                    'text' => 'Настройки группы',
                    'href' => $this->url->link('catalog/groups/edit', 'token=' . $this->session->data['token'] . '&group_id=' . $this->request->get['group_id'], true)
                );

                $filter_data['group_id'] = $this->request->get['group_id'];

                $group_info = $this->model_catalog_groups->getGroup($filter_data);
              //  var_dump($group_info);
            }

            $data['token'] = $this->session->data['token'];


            if (isset($this->request->post['title'])) {
		$data['title'] = $this->request->post['title'];
            } elseif (isset($group_info)) {
                
		$data['title'] = $group_info['title'];
            } else {
		$data['title'] = '';
            }
          
            $data['types']=array(
                1=>'скидка(процент)',
                2=>'скидка(фиксированная сумма)',
            );
         
                $this->load->model('catalog/product');
                $this->load->model('catalog/category');
                $this->load->model('catalog/manufacturer');
                $this->load->model('tool/image');
                
                $data['categories'] = $this->model_catalog_category->getCategories();
                $data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();

                if (!empty($group_info)) {
                    
                    $filter_data['group_id']=$group_info['group_id'];
                    if (isset($this->request->get['sort']) ){
                        $filter_data['sort']=$this->request->get['sort'];
                    }
                    if (isset($this->request->get['order']) ){
                         $filter_data['order']=$this->request->get['order'];
                    }
                    
                    $products =  $this->model_catalog_groups->getGroupProducts($filter_data);
                    $data['selected']=$this->model_catalog_groups->getGroupSelectedProducts ($group_info['group_id']);
                    $data['products'] =array();
                   
                    foreach($products as $result){
                       
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
                    
                  
		} else {
                    $data['products'] = [];
		}
                
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/group_form', $data));
	}

        public function saveGroupProducts(){
           
            $this->load->model('catalog/groups');
            if(isset($this->request->post['selected']) && $this->request->post['selected'] && isset($this->request->post['group_id']) && $this->request->post['group_id']){
                $this->model_catalog_groups->saveGroupProducts($this->request->post);
                $this->response->setOutput(json_encode(['success'=>1])); 
            }else{
                $this->response->setOutput(json_encode(['success'=>0]));
            }
            
        }
        
        public function deleteGroupProducts(){
            $this->load->model('catalog/groups');
            if(isset($this->request->post['selected']) && $this->request->post['selected'] && isset($this->request->post['group_id']) && $this->request->post['group_id']){
                $this->model_catalog_groups->deleteCandidateProducts($this->request->post);
                $data['product']=$this->request->post['selected'];
                $data['group_id']=$this->request->post['group_id'];
                $this->model_catalog_groups->addCandidatesSelected($data);
               
                $this->response->setOutput(json_encode(['success'=>1])); 
            }else{
                $this->response->setOutput(json_encode(['success'=>0]));
            }
        }
        
        public function addProductToGroup(){
            $this->load->model('catalog/groups');
            $data['group_id']=$this->request->post['group_id'];
            $data['product']=[$this->request->post['product_id']];
            $this->model_catalog_groups->addCandidateProducts($data);
            $this->response->setOutput(json_encode(['succes'=>1]));
        }
        
        public function checkGroup(){
            $this->load->model('catalog/groups');
            $data['category_id']=$this->request->post['category_id'];
            $data['manufacturer_id']=$this->request->post['manufacturer_id'];
            $data['group_id']=$this->request->post['group_id'];
            $results=$this->model_catalog_groups->getEligibleProducts($data);
            
            $this->response->setOutput(json_encode(['success'=>1, 'count'=>count($results)]));
        }
        
        public function addProductsGroup(){
            $this->load->model('catalog/groups');
            $data['category_id']=$this->request->post['category_id'];
            $data['manufacturer_id']=$this->request->post['manufacturer_id'];
            $data['group_id']=$this->request->post['group_id'];
            $results=$this->model_catalog_groups->getEligibleProducts($data);
            $data['product']=[];
            foreach($results as $result){
                $data['product'][]=$result['product_id'];
            }
            $this->model_catalog_groups->addCandidateProducts($data);
            $this->response->setOutput(json_encode(['success'=>1]));
            
        }
        
        public function changeTitle(){
            $this->load->model('catalog/groups');
            if(isset($this->request->post['title']) && $this->request->post['title'] && isset($this->request->post['group_id']) && $this->request->post['group_id']){
               //var_dump($this->request->post['selected']);
                $this->model_catalog_groups->changeTitle($this->request->post);
               
                $this->response->setOutput(json_encode(['success'=>1])); 
            }
        }
        
         public function changeGroupPrice(){
            $this->load->model('catalog/groups');
            if(isset($this->request->post['selected']) && $this->request->post['selected'] && isset($this->request->post['change_price']) && $this->request->post['change_price'] && in_array((string)$this->request->post['type'], ['1','2'])){
               //var_dump($this->request->post);
                $this->model_catalog_groups->changeBasePrices($this->request->post);
              
               $this->response->setOutput(json_encode(['success'=>1])); 
            }
         }
        
	

}
