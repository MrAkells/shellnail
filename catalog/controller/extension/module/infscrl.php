<?php
class ControllerExtensionModuleinfscrl extends Controller {	
	private $error = array();
	private $modpath = 'module/infscrl'; 
	private $modtpl = 'default/template/module/infscrl.tpl'; 
	private $modname = 'infscrl';
	private $modtext = 'Infinite Product Scroll';
	private $modid = '23856';
	private $modssl = 'SSL';
	private $modemail = 'opencarttools@gmail.com'; 
	private $langid = 0;
	
	public function __construct($registry) {
		parent::__construct($registry);
		
		$value = $this->config->get('config_language_id');
		$this->langid = is_numeric($value) ? (int)$value : 0;
 		
		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3') { 
			$this->modtpl = 'extension/module/infscrl';
			$this->modpath = 'extension/module/infscrl';
		} else if(substr(VERSION,0,3)=='2.2') {
			$this->modtpl = 'module/infscrl';
		} 
		
		if(substr(VERSION,0,3)>='3.0') { 
			$this->modname = 'module_infscrl';
		} 
		
		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3' || substr(VERSION,0,3)=='2.2') { 
			$this->modssl = true;
		} 
 	} 
	
	public function index() {
        $data['infscrl_status'] = $this->setvalue($this->modname.'_status');
        $data['infscrl_endtext'] = $this->setvalue($this->modname.'_endtext');
        if (is_array($data['infscrl_endtext']) && isset($data['infscrl_endtext'][$this->langid])) {
            $data['infscrl_endtext'] = $data['infscrl_endtext'][$this->langid];
        } else {
            $data['infscrl_endtext'] = '';
        }
        $data['infscrl_loader_img'] = $this->setvalue($this->modname.'_loader_img');
        $data['infscrl_loader_img'] = 'image/'.$data['infscrl_loader_img'];
 		
                $data['is_search']=false;
                
		if($data['infscrl_status']) {
 			//product/category
			if(stristr($this->request->get['route'],'product/category')) {	
				$url = '';

				if (isset($this->request->get['filter_dvfilter'])) {
					$url .= '&filter_dvfilter=' . $this->request->get['filter_dvfilter'];
				}
	
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}
	
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
	
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
				
				$data['ajaxurl'] = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url ,$this->modssl);
				//$data['ajaxurl'] ='index.php?route=product/category&path=' . $this->request->get['path'] . $url;
                            }
			
			//product/manufacturer
			if(stristr($this->request->get['route'],'product/manufacturer')) {
				$url = '';

                                if (isset($this->request->get['filter_dvfilter'])) {
					$url .= '&filter_dvfilter=' . $this->request->get['filter_dvfilter'];
				}
                                
				if (isset($this->request->get['manufacturer_id'])) {
					$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
				}
	
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}
	
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
	
				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}
	
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
				
                                $data['ajaxurl'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] .  $url ,$this->modssl);
				//$data['ajaxurl'] = 'index.php?route=product/manufacturer/info&manufacturer_id=' . $this->request->get['manufacturer_id'] . $url;
			}
			
			//product/search
			if(stristr($this->request->get['route'],'product/search')) {
				$url = '';
	
				if (isset($this->request->get['search'])) {
					$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
				}
	
				if (isset($this->request->get['tag'])) {
					$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
				}
	
				if (isset($this->request->get['description'])) {
					$url .= '&description=' . $this->request->get['description'];
				}
	
				if (isset($this->request->get['category_id'])) {
					$url .= '&category_id=' . $this->request->get['category_id'];
				}
	
				if (isset($this->request->get['sub_category'])) {
					$url .= '&sub_category=' . $this->request->get['sub_category'];
				}
	
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
                                
				$data['is_search']=true;
				$data['ajaxurl'] = $this->url->link('product/search', $url ,$this->modssl);
				//$data['ajaxurl'] = 'index.php?route=product/search'. $url;
			}
			
			//product/special
			if(stristr($this->request->get['route'],'product/special')) {
				$url = '';

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}
		
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
		
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
			
				$data['ajaxurl'] = $this->url->link('product/special', $url ,$this->modssl);
				//$data['ajaxurl'] = 'index.php?route=product/special'. $url;
			} 	
                        
                        if(isset($this->request->get['page'])){
                            $data['page']=$this->request->get['page'];
                        }else{
                            $data['page']=1;
                        }
                        
	  		return $this->load->view($this->modtpl, $data);
		}
	} 
	
	private function setvalue($postfield) {
		return $this->config->get($postfield);
	}
}