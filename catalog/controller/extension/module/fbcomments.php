<?php
class ControllerExtensionModuleFbcomments extends Controller {
	public function index($setting) {
            
            $this->document->addScript('catalog/view/javascript/fbwidgets.js');
            $this->document->addScript('catalog/view/javascript/jquery/simplebar.js');
            $this->document->addStyle('catalog/view/theme/default/stylesheet/simplebar.css');
                  
            $data['heading_title']=$setting['name'];
            $data['width']=$setting['width'];
            $data['comments_number']=$setting['comments_number'];
            $data['comments_height']=$setting['comments_height'];
            
            $template='fbcomments';
            if ($setting['module_template']){ 
                $template=$setting['module_template'];
                $method=$setting['module_template'];
                if(method_exists($this, $method)){
                    $data=$this->$method($data);
                }
            }
                        
            return $this->load->view('extension/module/'.$template, $data);
                       
	}
        
        private function fbcomments_custom($data){
            $data['text_shellnail']=$this->language->get('text_shellnail');
           
            $data['shop_text']=html_entity_decode($this->config->get("owner_shop_description"), ENT_QUOTES, 'UTF-8'); 
            return $data;
        }
}