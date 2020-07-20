<?php
class ControllerExtensionModuleFbpage extends Controller {
	public function index($setting) {
            $this->load->language('mainpage/subscribe');
            $this->document->addScript('catalog/view/javascript/fbwidgets.js');
            
            $data['heading_title']=$this->language->get('heading_title');
            $data['text_youtube_subscribe']=$this->language->get('text_youtube_subscribe');
            if($this->request->get['route']=='common/home'){
                $data['width']=294;
            }else{
                $data['width']=$setting['width'];
            }
            
            $data['height']=$setting['height'];
            
            $data['shellnail_home_link']=$this->url->link('common/home');
            
            $template='fbpage';
            if ($setting['module_template']){ 
                $template=$setting['module_template'];
                $method=$setting['module_template'];
                if(method_exists($this, $method)){
                    $data=$this->$method($data);
                }
            }
                        
            return $this->load->view('extension/module/'.$template, $data);
                       
		
	}
        
        private function custom($data){
           // do nothing now
            return $data;
        }
}