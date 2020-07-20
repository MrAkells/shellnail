<?php
class ControllerExtensionModulePopupForm extends Controller 
{
	public function index() 
        { 
            //$this->document->addScript('catalog/view/javascript/popup_form/popup_form.js');
            // Скрипт закоментированый сверху добавлен в common/header
            
            $this->load->language('extension/module/popup_form');
            
            $data['name']       = $this->language->get('text_your_name');
            $data['phone']      = $this->language->get('text_your_phone');
            
            $data['text_hour']=$this->language->get('text_hour');
            $data['text_to']=$this->language->get('text_to');
            $data['timing']=$this->language->get('timing');
            
//            if( $this->config->get('config_language_id')!=1){
//                $data['name']= $this->language->get('formname_ua');
//                
//                $data['email']['label']=$this->language->get('email_ua');
//            
//                $data['phone']['label']=$this->language->get('phone_ua');
//            
//                $data['form_name']['label']=$this->language->get('name_ua');
//            }

  
            $data['action'] = $this->url->link('extension/module/popup_form/send');

            $data['heading_title']      = $this->language->get('heading_title');
            $data['text_success']       = $this->language->get('text_success');
            $data['text_error_email']   = $this->language->get('text_error_email');
            $data['text_success']       = $this->language->get('text_success');
            $data['text_error_phone']   = $this->language->get('text_error_phone');
           
            $data['text_close_btn'] = $this->language->get('text_close_btn');
            $data['text_send_btn'] = $this->language->get('text_send_btn');
            
            return array(
                'button'=>$this->load->view('extension/module/popup_form/order.tpl', $data),
                'modal'=>$this->load->view('extension/module/popup_form/order_modal.tpl', $data),
            );
		
	}
        
        public function send()
        {
                   
            if ($this->request->server['REQUEST_METHOD'] == 'POST')
            {
                $data = json_decode(file_get_contents("php://input"));
                
                if($this->validate($data) !== true){
                   echo json_encode($this->validate($data)); die();
                }
               

                $message  = '<html dir="ltr" lang="en">' . "\n";
                $message .= '  <head>' . "\n";
                $message .= '    <title>Вопрос по сайту</title>' . "\n";
                $message .= '    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
                $message .= '  </head>' . "\n";
                $message .= '<body> '. "\n";
                $message .= '<h3>Данные клиента</h3>'. "\n";  
                if(isset($data->form_name)){
                $message .= '<div style="font-weight:bold"> Имя:</div> <div>' . $data->form_name . '</div><br />'. "\n";
                }
                if(isset($data->phone)){
                $message .= '<div style="font-weight:bold"> Телефон:</div>   <div>' . $data->phone . '</div><br />'. "\n";
                }
                if(isset($data->from_hour)){
                $message .= '<div style="font-weight:bold"> Звонить c</div>   <div>' . $data->from_hour .'-00'. '</div><br />'. "\n";
                }
                if(isset($data->to_hour)){
                $message .= '<div style="font-weight:bold"> до </div>   <div>' . $data->to_hour .'-00'. '</div><br />'. "\n";
                }
                
                $message .= '</body>' . "\n";
                $message .= '</html>' . "\n";

                $mail = new Mail();	
                $mail->protocol = $this->config->get('config_mail_protocol');
                $mail->parameter = $this->config->get('config_mail_parameter');
                $mail->setTo($this->config->get('config_email'));
                $mail->setFrom('my_shop');
                $mail->setSender($this->config->get('config_name'));
                $mail->setSubject(html_entity_decode('Ответьте на вопрос!', ENT_QUOTES, 'UTF-8'));					
                $mail->setHtml($message);
                $mail->send();
                
                echo json_encode(array('success' => true));               
            }
        }
        
        private function validate($data) 
        {        
            
            $tests = array(
                    'phone' => false,
                    'email' => false
                );
            
         
            $tests['email'] = 1;
            
            
            if(isset($data->phone) ){
                $tests['phone'] = preg_match('/^[0-9\(\)\-\+]{9,18}$/', $data->phone);
            }

            foreach ($tests as $test){            
                if(!$test){
                    return array('error_test' => $tests);
                }
            }
            return true;
        }
}