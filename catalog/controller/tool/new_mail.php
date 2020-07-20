<?php
class ControllerToolNewMail extends Controller {
        
        public function update_base()
        {            
			if (isset($_GET['auth']) && $_GET['auth'] == '2020')
            {
                $this->load->model('tool/new_mail');      
                $Model = $this->model_tool_new_mail;
                $Model->setKey($this->config->get('new_mail_key'));
                $Model->update_base();
            }            
        }
}