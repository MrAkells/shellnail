<?php
class ControllerExtensionModuleTwobanners extends Controller {
	public function index() {
		$this->load->language('extension/module/twobanners');

                $this->load->model('design/banner');
		$this->load->model('tool/image');

        $this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.theme.default.min.css');

		$data['banners'] = array();

		$first_slide_banners = $this->model_design_banner->getBanner($this->config->get('twobanners_first_banner_id'));
                $second_banner = $this->model_design_banner->getBanner($this->config->get('twobanners_second_banner_id'));
             
                    foreach ($first_slide_banners as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
                                $titles=explode(';',$result['title']);
                                $title=$titles[0];
                                if(isset($titles[1])){
                                   $title2=$titles[1];
                                }else{
                                     $title2='';
                                }
				$data['first_banner'][] = array(
					'title' => $title,
                                        'title2' => $title2,
					'link'  => $result['link'],
                                        'image' => $this->model_tool_image->resize($result['image'], $this->config->get('twobanners_first_width'), $this->config->get('twobanners_first_height'))
				);
			}
                    }
               
                if (is_file(DIR_IMAGE . $second_banner[0]['image'])) {
                    $data['second_banner'] = array(
                        'title' => $second_banner[0]['title'],
			'link'  => $second_banner[0]['link'],
                        'image' => $this->model_tool_image->resize($second_banner[0]['image'], $this->config->get('twobanners_second_width'), $this->config->get('twobanners_second_height'))
                    );
                }
		
		$data['heading_title'] = $this->language->get('heading_title');
                $data['first_advantage']    = $this->language->get('first_advantage');
                $data['second_advantage']    = $this->language->get('second_advantage');
                $data['third_advantage']    = $this->language->get('third_advantage');
                $data['forth_advantage']    = $this->language->get('forth_advantage');
                $data['text_1_advantage']    = $this->language->get('text_1_advantage');
                
                $data['text_2_advantage']    = sprintf($this->language->get('text_2_advantage'), $this->config->get('ukrposhta_freetotal'), $this->config->get('new_mail_freetotal'));         
                
                $data['text_3_advantage']    = $this->language->get('text_3_advantage');
                $data['text_4_advantage']    = $this->language->get('text_4_advantage');
                $data['btn_more_detailed']    = $this->language->get('btn_more_detailed');

                $data['mini_header_catalog']=$this->load->controller('extension/module/menu', ['template'=>"extension/module/mini_menu_noindex"]);

               // $data['promos']=$this->promotions();
   
                $data['promos']=$this->load->controller('product/promotions');
                
		return $this->load->view('extension/module/twobanners', $data);
	}
        
       
}