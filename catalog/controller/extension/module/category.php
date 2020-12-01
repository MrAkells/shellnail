<?php
class ControllerExtensionModuleCategory extends Controller {
    
	public function index() {
		$this->load->language('extension/module/category');

		$data['heading_title'] = $this->language->get('heading_title');

		$this->load->model('catalog/category');
                
		$data['categories'] = array();

		$this->load->model("extension/module/menu");
    $data['categories']=$this->model_extension_module_menu->createCategoryMenu();
                
		return $this->load->view('extension/module/category', $data);
	}
    
}