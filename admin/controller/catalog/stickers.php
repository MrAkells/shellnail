<?php
class ControllerCatalogStickers extends Controller {
	
	public function index($product_info='') {
            $this->load->language('catalog/stickers');

            $data['all_possible_stickers']=array(
                'b'=>$this->language->get('bestseller_sticker'),
                'n'=>$this->language->get('new_sticker'),
                'p'=>$this->language->get('popular_sticker'),
            );
                       
            $data['text_hand_stickers']=$this->language->get('text_hand_sticker');
            $data['text_auto_stickers']=$this->language->get('text_auto_sticker');
            $data['text_stickers_description']=$this->language->get('text_stickers_description');

            $data['stickers_list']=array_keys($data['all_possible_stickers']);
                        
            if(isset($product_info) && isset($product_info['stickers']) && $product_info['stickers'] && isset($product_info['auto_stickers']) &&  $product_info['auto_stickers']){
                $data['product_stickers']=str_split($product_info['stickers']);
                $data['product_auto_stickers']=str_split($product_info['auto_stickers']);
            }else{
                $data['product_stickers']=[];
                $data['product_auto_stickers']=[];
            }
                    
            return $this->load->view('catalog/stickers', $data);
           
	}

	
}
