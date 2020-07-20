<?php
class ControllerExtensionModuleXmlprice extends Controller {

        private $aggregators=array();
        private $categories=array();
        private $manufacturers=array();
        private $limit=40;
        private $error = array();
     
        public function __construct($registry){
            parent::__construct($registry);
            $this->load->model('feed/xmlprice');

//              $this->load->model('extension/delovod'); 
//         $obj = (object)['id'=>'1100300000002345', 'qty'=>1];
//         $this->model_extension_delovod->updateBalance([
//            $obj
//          ]);
            
            $this->categories=$this->model_feed_xmlprice->getCategories();
            $this->manufacturers=$this->model_feed_xmlprice->getManufacturers();
        }
        
	public function index() {
            $aggregators=glob(DIR_APPLICATION.'controller/aggregators/*');
            foreach ($aggregators as $agg) {
		$this->aggregators[] = basename($agg, '.php');
            }
            
            $this->load->language('extension/module/xmlprice');
            
            $this->document->setTitle($this->language->get('heading_title'));
            
            $this->load->model('setting/setting');
            $this->load->model('localisation/currency');
            $this->load->model('localisation/stock_status');
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {            
		$this->model_setting_setting->editSetting('xmlprice', $this->request->post);	
                $this->session->data['success'] = $this->language->get('text_success');
                $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
            }

            $data['heading_title'] = $this->language->get('heading_title');
            
            $data['button_save'] = $this->language->get('button_save');
            $data['button_cancel'] = $this->language->get('button_cancel');

            $data['text_enabled'] = $this->language->get('text_enabled');
            $data['text_disabled'] = $this->language->get('text_disabled');
            $data['text_edit']=$this->language->get('text_edit');
            
            $data['text_shop_name'] = $this->language->get('text_shop_name');
            $data['text_company'] = $this->language->get('text_company');
            $data['text_categories'] = $this->language->get('text_categories');
            $data['text_select_all'] = $this->language->get('text_select_all');
            $data['text_unselect_all'] = $this->language->get('text_unselect_all');
            $data['text_curency'] = $this->language->get('text_curency');
          
            $data['entry_in_stock'] = $this->language->get('entry_in_stock');
            $data['entry_out_of_stock'] = $this->language->get('entry_out_of_stock');
            
            $data['entry_status'] = $this->language->get('entry_status');
            $data['entry_data_feed'] = $this->language->get('entry_data_feed');

            $data['breadcrumbs'] = array();

            $data['breadcrumbs'][] = array(
		'text'     => $this->language->get('text_home'),
		'href'     => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
		'separator'=> false
            );

            $data['breadcrumbs'][] = array(
		'text'      => $this->language->get('text_modules'),
		'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'),
		'separator' => ' :: '
            );

            $data['breadcrumbs'][] = array(
		'text'      => $this->language->get('heading_title'),
		'href'      => $this->url->link('extension/module/xmlprice', 'token=' . $this->session->data['token'], 'SSL'),
		'separator' => ' :: '
            );
            
            $data['action'] = $this->url->link('extension/module/xmlprice', 'token=' . $this->session->data['token'], 'SSL');
            $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');
            $data['token']=$this->session->data['token'];
            
            if (isset($this->error['warning'])) {
		$data['error_warning'] = $this->error['warning'];
            } else {
		$data['error_warning'] = '';
            }
            
            if (isset($this->request->post['xmlprice_status'])) {
		$data['xmlprice_status'] = $this->request->post['xmlprice_status'];
            } else {
		$data['xmlprice_status'] = $this->config->get('xmlprice_status');
            }
                
            if ($this->config->get('xmlprice_shopname')) {
		$data['shop_name'] = $this->config->get('xmlprice_shopname');
            } else {
		$data['shop_name'] ='YourShop';
            }
                
            if ($this->config->get('xmlprice_company')) {
		$data['company'] = $this->config->get('xmlprice_company');
            } else {
		$data['company'] = 'YourCompany';
            }
        
            $data['currencies'] = $this->model_localisation_currency->getCurrencies();
            if (isset($this->request->post['xmlprice_currency'])) {
		$data['xmlprice_currency'] = $this->request->post['xmlprice_currency'];
            } else {
		$data['xmlprice_currency'] = $this->config->get('xmlprice_currency');
            }
                
            $data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();  
            if (isset($this->request->post['xmlprice_in_stock'])) {
		$data['xmlprice_in_stock'] = $this->request->post['xmlprice_in_stock'];
            } elseif ($this->config->get('xmlprice_in_stock')) {
		$data['xmlprice_in_stock'] = $this->config->get('xmlprice_in_stock');
            } else {
		$data['xmlprice_in_stock'] = 7;
            }

            if (isset($this->request->post['xmlprice_out_of_stock'])) {
		$data['xmlprice_out_of_stock'] = $this->request->post['xmlprice_out_of_stock'];
            } elseif ($this->config->get('xmlprice_in_stock')) {
		$data['xmlprice_out_of_stock'] = $this->config->get('xmlprice_out_of_stock');
            } else {
		$data['xmlprice_out_of_stock'] = 5;
            }

            $data['aggregators']=array();
            foreach($this->aggregators as $agg){
                $data['aggregators'][]=array(
                    'name'=>$agg,
                    'content'=>$this->getAggregatorData($agg)
                );
            }
            
            $data['text_generate_all']=$this->language->get('text_generate_all');
            $data['generate_all']=$this->url->link('extension/module/xmlprice/generateall', 'token=' . $this->session->data['token'], 'SSL');
            
            $data['header'] = $this->load->controller('common/header');
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['footer'] = $this->load->controller('common/footer');

            $this->response->setOutput($this->load->view('extension/module/xmlprice.tpl', $data));
	} 

        public function getAggregatorData($aggregator){
            $this->load->language('extension/module/xmlprice');
            
            if(isset($this->session->data['success'])){
                $data['success']=$this->session->data['success'];
                unset($this->session->data['success']);
            }else{
                 $data['success']=false;
            }
            
            $data['text_categories']=$this->language->get('text_categories');
            $data['text_aliases']=$this->language->get('text_aliases');
            $data['text_select_all']=$this->language->get('text_select_all');
            $data['text_unselect_all']=$this->language->get('text_unselect_all');
            $data['text_save']=$this->language->get('text_save');
            $data['psevdo_explained']=$this->language->get('psevdo_explained');
            $data['category_explained']=$this->language->get('category_explained');
            
            $data['aggregator']=$aggregator;
            $data['categories']=$this->categories;
            $data['manufacturers']=$this->manufacturers;
            $data['text_generate']=$this->language->get('text_generate');
            
            $data['action'] = $this->url->link('extension/module/xmlprice/saveAggregatorData', 'token=' . $this->session->data['token'].'&platform='.$aggregator, 'SSL');
            $data['token']=$this->session->data['token'];
            $data['link_to_generate']=$this->url->link('extension/module/xmlprice/generate', 'token=' . $this->session->data['token'].'&platform='.$aggregator, 'SSL');
            $data['aggregator_state']=$this->url->link('extension/module/xmlprice/getstate', 'token=' . $this->session->data['token'].'&platform='.$aggregator, 'SSL'); 
            $data['link_to_xml_file']=HTTP_CATALOG.$aggregator.'.xml';
            $data['text_link']=$this->language->get('text_link');
            
            $data['checked_manufacturers']=explode(',',$this->model_feed_xmlprice->getAggregatorManufacturers($aggregator));
            $data['checked_categories']=explode(',',$this->model_feed_xmlprice->getAggregatorCategories($aggregator));
            $data['aliases']=$this->model_feed_xmlprice->getAliases($aggregator);
            $data['state']=$this->model_feed_xmlprice->getXmlfileState($aggregator);
           
            return $this->load->view('extension/module/xmlprice_helper.tpl', $data);
        }
        
        public function saveAggregatorData(){
            $this->load->language('extension/module/xmlprice');
            
            $this->model_feed_xmlprice->checkNewAggregators();
            
            $aggregator=$this->request->get['platform'];
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
                 
                $aliases=[];
                    foreach($this->request->post as $key=>$post_value){
                        $pos=strpos($key, 'alias');
                           
                        if($pos!==false && $post_value){
                            $alias_category_id=(int)str_replace('alias', '', $key);
                            $aliases[]=[
                                'category_id'=>$alias_category_id,
                                'alias'=>iconv( mb_detect_encoding($post_value), 'UTF-8', $post_value)
                            ];
                        }
                    }
                       
                    $this->model_feed_xmlprice->editAlliases($aggregator,$aliases);
                    if(isset($this->request->post[$aggregator.'_categories'])){
                        $checked_categories = implode(',', $this->request->post[$aggregator.'_categories']);
                    }else{
                        $checked_categories='';
                    }
                   
                    $this->model_feed_xmlprice->setAggregatorCategories($aggregator, $checked_categories);
                    
                    if(isset($this->request->post['manufacturers'])){
                        $checked_manufacturers = implode(',', $this->request->post['manufacturers']);
                    }else{
                        $checked_manufacturers='';
                    }
                    
                    $this->model_feed_xmlprice->setAggregatorManufacturers($aggregator, $checked_manufacturers);
                    
                    
                    $this->session->data['success'] = $this->language->get('text_set_success');
                    
                    $response=$this->getAggregatorData($aggregator);
                       
                    $this->response->setOutput($response);
            }
        }
        
       
        public function getState(){
            $aggregator=$this->request->get['platform']; 
            $data['aggregator']=$aggregator;
            $state=$this->model_feed_xmlprice->getXmlfileState($aggregator);
            $response=array(
                'date'=>$state['xmlfile_date'],
                'prepared'=>$state['prepared_items'],
                'total'=>$state['total_items']
            );
            $this->response->setOutput(json_encode($response));  
        }
        
        public function generate(){
            $aggregator=$this->request->get['platform']; 
            $state=$this->model_feed_xmlprice->getXmlfileState($aggregator);
            
            $settings=array(
                'limit'=>$this->limit,
                'total'=>$state['total_items'],
                'offset'=>$state['prepared_items']
            );
            
            $arr=$this->load->controller('aggregators/'.$aggregator, $settings);
            //var_dump($arr); die();
            if($arr['offset']>=$arr['total']){
                $this->model_feed_xmlprice->setXmlfileDate($aggregator);
            }else{
                $this->model_feed_xmlprice->setXmlfileItems($aggregator, $arr['offset'], $arr['total']);
            }
            $new_state=$this->model_feed_xmlprice->getXmlfileState($aggregator);
           
            $response=array(
                'aggregator'=>$aggregator,
                'date'=>$new_state['xmlfile_date'],
                'prepared'=>$new_state['prepared_items'],
                'total'=>$new_state['total_items'],
                'xmlfiles'=>''
            );
           
            $this->response->setOutput(json_encode($response)); 
            
        }
        
        public function generateAll(){
            
            if(!$this->model_feed_xmlprice->IsStack()){
                $this->model_feed_xmlprice->MakeStack();
            }
            $aggregators=$this->model_feed_xmlprice->getAggregators();
            $prepared_agg='';
            $not_ready_agg=[];
            foreach($aggregators as $aggregator){
                if(!$aggregator['stack']){
                    $prepared_agg.='<p>'.$aggregator['aggregator'].' 100%</p>';
                }else{
                    $not_ready_agg[]=$aggregator['aggregator'];
                }
            }
            
            $this->request->get['platform'] = $not_ready_agg[0];
            $this->generate();
            $result = json_decode($this->response->getOutput());
           // var_dump($result); die();
            if ($result->prepared >= $result->total) {
                $this->model_feed_xmlprice->setUnstaked($not_ready_agg[0]);
            }

            if ($this->model_feed_xmlprice->IsStack()) {
                $response = array(
                    'aggregator' => $not_ready_agg[0],
                    'date' => '',
                    'prepared' => $result->prepared,
                    'total' => $result->total,
                    'xmlfiles' => $prepared_agg.'...'
                );
            } else {
                 $this->load->language('extension/module/xmlprice');
                 $response = array(
                    'aggregator' => $this->language->get('all_done'),
                    'date' => date('Y-m-d'),
                    'xmlfiles' => $prepared_agg.'<p>'.$not_ready_agg[0].' 100%</p>'
                );
            }
            $this->response->setOutput(json_encode($response));
    }
        
    public function install(){
            $this->db->query("CREATE TABLE IF NOT EXISTS xmlprice_aliases (alias_id int(11) AUTO_INCREMENT PRIMARY KEY, category_id int(11), alias VARCHAR(40) NOT NULL, platform VARCHAR(20) NOT NULL) CHARACTER SET UTF8");
            $this->db->query("CREATE TABLE IF NOT EXISTS aggregator_settings (aggregator VARCHAR(200) PRIMARY KEY, categories text, manufacturers text, xmlfile_date DATE, prepared_items INT(11), total_items INT(11), stack TINYINT)");
            
            $aggregators=glob(DIR_APPLICATION.'controller/aggregators/*');
            foreach ($aggregators as $agg) {
		$this->db->query("INSERT INTO aggregator_settings (aggregator, categories, manufacturers, xmlfile_date, prepared_items, total_items, stack) VALUES('".basename($agg, '.php')."', '', '', 'empty', 0, 0, 0)");
            }
        }
        
        public function uninstall(){
            $this->db->query("DROP TABLE xmlprice_aliases");
            $this->db->query("DROP TABLE aggregator_settings");
        }
        
        protected function validate() {
            if (!$this->user->hasPermission('modify', 'extension/module/xmlprice')) {
		$this->error['warning'] = $this->language->get('error_permission');
            }

            if (!$this->error) {
		return true;
            } else {
		return false;
            }	
	}

}

