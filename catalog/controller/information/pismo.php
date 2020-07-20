<?php
class ControllerInformationPismo extends Controller {
	private $error = array();

	public function index() {
             die;
               // в файле catalog/model/checkout/order
               // раскоментируйте 
               //  $this->cache->set('testordermail', $data);
               // сделайте заказ и с помощью этого контролера получайте в браузере 
               // разметку письма для редактирования
           
		$data= $this->cache->get('testordermail');
                
                // echo '<pre>'; var_dump($data); die;
                
                $markup=$this->load->view('mail/order', $data);
		$this->response->setOutput($markup);
	}
}
