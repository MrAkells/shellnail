<?php
class ModelCatalogStickers extends Model {
    
	public function getProductStickers($product_info) {
            
            $product_stickers=array_unique(array_merge(str_split($product_info['stickers']),str_split($product_info['auto_stickers'])));
            
            $stickers=array();
            
            if ($this->config->get('stickers_status')) {
                if (in_array('b', $product_stickers) && $this->config->get('stickers_bestseller')) {
                    $stickers[] = [
                        'class' => 'sticker_bestseller',
                        'title' => $this->language->get('sticker_bestseller')
                    ];
                }
                if (in_array('n', $product_stickers) && $this->config->get('stickers_latest')) {
                    $stickers[] = [
                        'class' => 'sticker_new_product',
                        'title' => $this->language->get('sticker_new_product')
                    ];
                }
                if (in_array('p', $product_stickers) && $this->config->get('stickers_popular')) {
                    $stickers[] = [
                        'class' => 'sticker_most_viewed',
                        'title' => $this->language->get('sticker_most_viewed')
                    ];
                }
                if ($product_info['special'] && $this->config->get('stickers_special')) {
                    $stickers[] = [
                        'class' => 'sticker_special',
                        'title' => $this->language->get('sticker_special')
                    ];
                }
            }
            $stickers=array_merge($stickers,$product_info['promos']);
            return $stickers;
	}
        

}