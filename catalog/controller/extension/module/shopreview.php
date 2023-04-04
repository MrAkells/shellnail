<?php
class ControllerExtensionModuleShopreview extends Controller {
    
	public function index() {
		$this->load->language('extension/module/shopreview');
                
               
		$data['heading_title'] = $this->language->get('heading_title');
                
                $data['entry_name'] = $this->language->get('entry_name');
                $data['entry_review'] = $this->language->get('entry_review');
		$data['entry_rating'] = $this->language->get('entry_rating');
		$data['entry_good'] = $this->language->get('entry_good');
		$data['entry_bad'] = $this->language->get('entry_bad');
                $data['entry_image'] = $this->language->get('entry_image');
                $data['text_write'] = $this->language->get('text_write');
                $data['text_error'] = $this->language->get('text_error');
                $data['entry_email']   = $this->language->get('entry_email');
                $data['entry_phone']   = $this->language->get('entry_phone');
                $data['should_notify']   = $this->language->get('should_notify');
               
                $data['text_greetings']=$this->language->get('text_greetings');
                $data['text_you_can_rate']=$this->language->get('text_you_can_rate');

               
                $data['button_write'] = $this->language->get('button_write');
                $data['button_send'] = $this->language->get('button_send');
                
                if ($this->customer->isLogged()) {
                    $data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
		} else {
                    $data['customer_name'] = '';
		}
                
                if ($this->config->get($this->config->get('config_captcha') . '_status') && !$this->customer->isLogged()) {
                    $data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));
		} else {
                    $data['captcha'] = '';
		}
                
                if ($this->config->get('config_review_guest') || $this->customer->isLogged()) {
                    $data['review_guest'] = true;
		} else {
                    $data['review_guest'] = false;
		}
               
                return $this->load->view('extension/module/shopreview', $data);
	}
        
        public function getreviews() {

                $this->response->redirect($this->url->link('features/reviews', '', true));

            $this->load->language('extension/module/shopreview');
            $data['text_answer']=$this->language->get('text_answer');
            
            $this->load->model('extension/module/shopreview');
            $this->load->model('tool/image');

            $data['text_no_reviews'] = $this->language->get('text_no_reviews');

            if (isset($this->request->get['page'])) {
		$page = $this->request->get['page'];
            } else {
		$page = 1;
            }

            $data['reviews'] = array();

            $review_total = $this->model_extension_module_shopreview->getTotalReviews();

            $rew_limit=$this->config->get('shopreview_reviews_on_page');
            
            $results = $this->model_extension_module_shopreview->getreviews(($page - 1) *  $rew_limit, $rew_limit);
            
            $width=$this->config->get('shopreview_width');
            $height=$this->config->get('shopreview_height');
            
            if($this->config->get('shopreview_image')){
                $path='shop_reviews/'.$this->config->get('shopreview_image');
                $data['defaultimage']=$this->model_tool_image->resize($path, $width, $height);
            }else{
                $data['defaultimage']='';
            }
            
            foreach ($results as $result) {
                    
                if($result['image']){
                    $path='shop_reviews/'.$result['image'];
                    $image=$this->model_tool_image->resize($path, $width, $height);
                }else{
                    $image='';
                }
                       
			$data['reviews'][] = array(
                                'id' => $result['shopreview_id'],
				'author'     => $result['author'],
				'text'       => nl2br($result['text']),
                                'answer'     => $result['answer'],
				'rating'     => (int)$result['rating'],
                                'image'      => $image,
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                            'answer_date' => date($this->language->get('date_format_short'), strtotime($result['date_modified']))
			);
		}

		$pagination = new Pagination();
		$pagination->total = $review_total;
		$pagination->page = $page;
		$pagination->limit =  $rew_limit;
		$pagination->url = $this->url->link('extension/module/shopreview/getreviews', 'page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) *  $rew_limit) + 1 : 0, ((($page - 1) *  $rew_limit) > ($review_total -  $rew_limit)) ? $review_total : ((($page - 1) *  $rew_limit) +  $rew_limit), $review_total, ceil($review_total /  $rew_limit));

		$this->response->setOutput($this->load->view('extension/module/shopreview_list', $data));
	}

	public function addreview() {
		$this->load->language('extension/module/shopreview');
                $this->load->model('extension/module/shopreview');
                
		$json = array();
                
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}

			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}

			if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
				$json['error'] = $this->language->get('error_rating');
			}
                        
                        
                        if(preg_match_all( "/[0-9]/", $this->request->post['reviewphone'])<12){
				$json['error'] = $this->language->get('error_phone');
			}
                        
                        if (!filter_var($this->request->post['reviewemail'], FILTER_VALIDATE_EMAIL)) {
                            $json['error'] = $this->language->get('error_email');
                        } 
                        
                        if (isset($this->request->post['notify']) && $this->request->post['notify']) {
				$this->request->post['notify']=1;
                        }else{
                                $this->request->post['notify']=0;
                        }
                        
                       $image_attached=false;
//                        if(is_file($this->request->files['reviewimage']['tmp_name'])){
//                            $image_attached=true;
//                            if(!$this->model_extension_module_shopreview->isPicture($this->request->files['reviewimage']['type'])){
//                               $json['error']=$this->language->get('wrong_photo_type');
//                            }
//                           
//                            $size = getimagesize($this->request->files['reviewimage']['tmp_name']);
//                            $width=$size[0];
//                            $height=$size[1];
//            
//                            if($width>800 || $width<100 || $height>800 || $height<100){
//                                $json['error']=$this->language->get('wrong_photo_dimension');
//                            }
//                           
//                        }
                        
			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && !$this->customer->isLogged()) {
				$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

                            if ($captcha) {
                                $json['error'] = $captcha;
                            }
			}

			if (!isset($json['error'])) {
				$this->load->model('extension/module/shopreview');

				$this->model_extension_module_shopreview->addreview($this->request->post,  $image_attached);

				$json['success']=$this->language->get('shopreview_added');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
        
        public function sudoindex() {
		$this->load->language('extension/module/shopreview');
                
               
		$data['heading_title'] = $this->language->get('heading_title');
                
                $data['entry_name'] = $this->language->get('entry_name');
                $data['entry_review'] = $this->language->get('entry_review');
		$data['entry_rating'] = $this->language->get('entry_rating');
		$data['entry_good'] = $this->language->get('entry_good');
		$data['entry_bad'] = $this->language->get('entry_bad');
                $data['entry_image'] = $this->language->get('entry_image');
                $data['text_write'] = $this->language->get('text_write');
                $data['text_error'] = $this->language->get('text_error');
                $data['entry_email']   = $this->language->get('entry_email');
                $data['entry_phone']   = $this->language->get('entry_phone');
                $data['should_notify']   = $this->language->get('should_notify');
               
                $data['text_greetings']=$this->language->get('text_greetings');
                $data['text_you_can_rate']=$this->language->get('text_you_can_rate');

               
                $data['button_write'] = $this->language->get('button_write');
                $data['button_send'] = $this->language->get('button_send');
                
                if ($this->customer->isLogged()) {
                    $data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
		} else {
                    $data['customer_name'] = '';
		}
                
                if ($this->config->get($this->config->get('config_captcha') . '_status') && !$this->customer->isLogged()) {
                    $data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));
		} else {
                    $data['captcha'] = '';
		}
                
                if ($this->config->get('config_review_guest') || $this->customer->isLogged()) {
                    $data['review_guest'] = true;
		} else {
                    $data['review_guest'] = false;
		}
               
                return $this->load->view('extension/module/sudoshopreview', $data);
	}
        
}

