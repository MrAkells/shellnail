<?php
class ControllerExtensionModuleMenu extends Controller {
	public function index($settings=array()) {
		$this->load->language('extension/module/menu');

                $this->document->addStyle('catalog/view/theme/default/stylesheet/menu.css');
                
		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['category_id'] = $parts[0];
		} else {
			$data['category_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}

		$this->load->model('catalog/category');

                $this->load->model("extension/module/menu");
                $data['categories']=$this->model_extension_module_menu->createCategoryMenu();
                
                $template="extension/module/menu";
                if(isset($settings['template'])){
                    $template=$settings['template'];
                }
               
		return $this->load->view($template, $data);
	}
        
}


