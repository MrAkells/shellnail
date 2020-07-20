<?php

class ControllerAggregatorsHotline extends Controller {
    
    private $name="hotline";
    private $settings=array();
    private $total=0;
    private $shop = array();
    private $allowed_categories;
    private $categories = array();
    private $offers = array();
    private $from_charset = 'utf-8';
    private $eol = "\n";

    public function index($settings) {
        
        $this->makeUrl();
        $server_name_for_url=$this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG;
		
	$this->settings=$settings;
        $this->load->model('feed/xmlprice');
        $allowed_categories=$this->model_feed_xmlprice->getAggregatorCategories($this->name);    
        $allowed_manufacturers=$this->model_feed_xmlprice->getAggregatorManufacturers($this->name);
        
        if (!$allowed_categories){
            $result=array(
                'error'=>'No allowed categories'
            );
            return $result;
        } 
            $this->allowed_categories=explode(',', $allowed_categories);
            $this->load->model('feed/aggregator');
            $this->load->model('localisation/currency');
            $this->load->model('tool/image');

            // Магазин
            $this->setShop('name', $this->config->get('xmlprice_shopname'));
            $this->setShop('company', $this->config->get('xmlprice_company'));
            $this->setShop('url', HTTP_CATALOG);
            $this->setShop('phone', $this->config->get('config_telephone'));
            $this->setShop('platform', 'OPENCART');
            $this->setShop('version', VERSION);

            // Валюты
            $offers_currency = $this->config->get('xmlprice_currency');
            
            if (!$this->currency->has($offers_currency)) {
               $result=array(
                'error'=>'No shop currencies'
                );
                return $result;
            }
            $decimal_place = $this->currency->getDecimalPlace($offers_currency);
            if(!$decimal_place){
                $decimal_place=1;
            }
            $shop_currency = $this->config->get('config_currency');

            // Категории
            $categories = $this->model_feed_aggregator->getCategory($this->name);
            
            foreach ($categories as $category) {
                $this->setCategory($category['name'], $category['category_id'], $category['parent_id'], $category['alias']);
            }
             
            // Товарные предложения
            $in_stock_id = $this->config->get('xmlprice_in_stock'); // id статуса товара "В наличии"
            $out_of_stock_id = $this->config->get('xmlprice_out_of_stock'); // id статуса товара "Нет на складе"
            $vendor_required = false; // true - только товары у которых задан производитель, необходимо для 'vendor.model' 
            
            if(!$this->settings['total']){
                $total_products=$this->model_feed_aggregator->getEligibleProducts($allowed_categories, $allowed_manufacturers, $out_of_stock_id, $vendor_required);
                $this->total=(int)$total_products;
            }else{
                $this->total=(int)($this->settings['total']);
            }
            
            $products = $this->model_feed_aggregator->getProduct($allowed_categories, $allowed_manufacturers, $out_of_stock_id, $this->settings['limit'], $this->settings['offset'], $vendor_required);

            foreach ($products as $product) {
                $data = array();

                // Атрибуты товарного предложения
                $data['id'] = $product['product_id'];
                $data['available'] = ($product['quantity'] > 0 || $product['stock_status_id'] == $in_stock_id);
                $data['url'] = $server_name_for_url.$this->url->link('product/product', 'path=' . $this->getPath($product['category_id']) . '&product_id=' . $product['product_id']);
                $data['priceRUAH'] = number_format($product['price'], $decimal_place, '.', '');
                $data['currencyId'] = $offers_currency;
                $data['categoryId'] = $product['category_id'];
                $data['delivery'] = 'true';
                $data['name'] = $product['name'];
                $data['vendor'] = $product['manufacturer'];
                $data['model'] = $product['name'];
                $data['description'] = $product['description'];
                
                $data['stock'] = 'В наличии';
                
                
                $attributes=$this->model_feed_aggregator->getProductAttributes($product['product_id']);
                
       
                if ($product['image']) {
                    $data['image'] = $this->model_tool_image->resize($product['image'], 800, 600);
                }
                $this->setOffer($data);
            }
            
            $this->categories = array_filter($this->categories, array($this, "filterCategory"));
           
            $this->fillXml();
            
            $result=array(
                'offset'=>$this->settings['offset']+$this->settings['limit'],
                'total'=>$this->total
            );
            return $result;
      
    }

    private function setShop($name, $value) {
	$allowed = array('name', 'company', 'url', 'phone', 'platform', 'version', 'agency', 'email');
	if (in_array($name, $allowed)) {
            $this->shop[$name] = $this->prepareField($value);
	}
    }

    private function setCategory($name, $id, $parent_id = 0, $alias = '') {
        $id = (int) $id;
        if ($id < 1 || trim($name) == '') {
            return false;
        }
        if ($alias) {
            $alias = $this->prepareField($alias);
        }
        if ((int) $parent_id > 0) {
            $this->categories[$id] = array(
                'id' => $id,
                'parentId' => (int) $parent_id,
                'name' => $this->prepareField($name),
                'alias' => $alias
            );
        } else {
            $this->categories[$id] = array(
                'id' => $id,
                'name' => $this->prepareField($name),
                'alias' => $alias
            );
        }

        return true;
    }

    private function setOffer($data) {
	$offer = array();
                
        if(isset($data['param']) && is_array($data['param'])){
            $offer['param'] = $data['param'];
        }
                	
	$allowed_tags = array(
            'id'=>1,
            'categoryId'=>1,
            'vendor'=>1,
            'name'=>1,
            'description'=>1,
            'url'=>1,
            'image'=>1,
            'priceRUAH'=>1,
            'stock'=>1,
            'guarantee'=>0
        );

	$required_tags = array_filter($allowed_tags);

	if (sizeof(array_intersect_key($data, $required_tags)) != sizeof($required_tags)) {
            return;
	}

	$data = array_intersect_key($data, $allowed_tags);

	$allowed_tags = array_intersect_key($allowed_tags, $data);

	// Стандарт XML учитывает порядок следования элементов,
	// поэтому важно соблюдать его в соответствии с порядком описанным в DTD
	$offer['data'] = array();
	foreach ($allowed_tags as $key => $value) {
            $offer['data'][$key] = $this->prepareField($data[$key]);      
	}

	$this->offers[] = $offer;
    }

    private function fillXml() {
       
        if(!$this->settings['offset']){
            $flag=true;
	$xml  = '<?xml version="1.0" encoding="windows-1251"?>' . $this->eol;
	$xml .= '<price>' . $this->eol;
        $xml .= '<date>'.date('Y-m-d H:i').'</date>'. $this->eol;
        $xml .= '<firmName>'.$this->shop['name'].'</firmName>'. $this->eol;
                
	// категории
	$xml .= '<categories>' . $this->eol;
	foreach ($this->categories as $category) {
            $xml .='<category>'. $this->eol.'<id>'.$category['id'].'</id>'.$this->eol;
            if(isset($category['parentId'])){
                $xml .='<parentId>'.$category['parentId'].'</parentId>'.$this->eol;
            }
            
            if($category['alias']){
                $xml .='<name>'.$category['alias'].'</name>'.$this->eol.'</category>'.$this->eol;
            }else{
                $xml .='<name>'.$category['name'].'</name>'.$this->eol.'</category>'.$this->eol;
            }
            
	}
	$xml .= '</categories>' . $this->eol;
        $xml .= '<items>' . $this->eol;
        
    }else{
        $flag=false;
        $xml='';
    }
	// товарные предложения
	
	foreach ($this->offers as $offer) {
            $tags = $this->array2Tag($offer['data']);
            unset($offer['data']);
            if (isset($offer['param'])) {
		$tags .= $this->array2Param($offer['param']);
		unset($offer['param']);
            }
            $xml .= $this->getElement($offer, 'item', $tags);
	}
        
        if($flag){
            file_put_contents('../hotline.xml', $xml);
            return true;
        }
        
        if($this->settings['offset']+$this->settings['limit']>=$this->total){
	$xml .= '</items>' . $this->eol;

	$xml .= '</price>';
        }
        
        file_put_contents('../hotline.xml', $xml, FILE_APPEND);
        
        return true;
    }

    private function getElement($attributes, $element_name, $element_value = '') {
	$retval = '<' . $element_name . ' ';
	foreach ($attributes as $key => $value) {
            $retval .= $key . '="' . $value . '" ';
	}
        $retval .= $element_value ? '>' . $this->eol . $element_value . '</' . $element_name . '>' : '/>';
                        
	$retval .= $this->eol;

	return $retval;
    }

    private function array2Tag($tags) {
	$retval = '';
	foreach ($tags as $key => $value) {
//          if($key=='description'){
//              $retval .= '<' . $key . '><![CDATA[' . $value . ']]></' . $key . '>';                  
//          }else{
                    $retval .= '<' . $key . '>' . $value . '</' . $key . '>' . $this->eol;
//          }
			
	}
        return $retval;
    }

    private function array2Param($params) {
	$retval = '';
	foreach ($params as $param) {
            $retval .= '<param name="' . $this->prepareField($param['name']);
            if (isset($param['unit'])) {
		$retval .= '" unit="' . $this->prepareField($param['unit']);
            }
		$retval .= '">' . $this->prepareField($param['value']) . '</param>' . $this->eol;
        }
        return $retval;
    }

    private function prepareField($field) {    
	$field = htmlspecialchars_decode($field);
	$field = strip_tags($field);
	$from = array('"', '&', '>', '<', '\'');
	$to = array('&quot;', '&amp;', '&gt;', '&lt;', '&apos;');
	$field = str_replace($from, $to, $field);
	if ($this->from_charset != 'windows-1251') {
            $field = iconv($this->from_charset, 'windows-1251//TRANSLIT//IGNORE', $field);
	}
                
	$field = preg_replace('#[\x00-\x08\x0B-\x0C\x0E-\x1F]+#is', ' ', $field);

	return trim($field);
    }
        
    protected function getPath($category_id, $current_path = '') {
	if (isset($this->categories[$category_id])) {
            $this->categories[$category_id]['export'] = 1;

            if (!$current_path) {
		$new_path = $this->categories[$category_id]['id'];
            } else {
		$new_path = $this->categories[$category_id]['id'] . '_' . $current_path;
            }	

            if (isset($this->categories[$category_id]['parentId'])) {
		return $this->getPath($this->categories[$category_id]['parentId'], $new_path);
            } else {
		return $new_path;
            }

	}
    }

    function filterCategory($category) {
	return in_array($category['id'], $this->allowed_categories);
    }
    
   private function makeUrl(){
        $seo_type = $this->config->get('config_seo_url_type');
        if (!$seo_type) {
            $seo_type = 'seo_url';
        }
        require_once(DIR_CATALOG . 'controller/startup/' . $seo_type . '.php');
        $classSeo = 'ControllerStartup'.str_replace('_','',$seo_type);
        $seoUrl = new $classSeo($this->registry);

        $urlToCatalog = new Url(HTTP_CATALOG, $this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG);
        $urlToCatalog->addRewrite($seoUrl);
       
        $this->url=$urlToCatalog;
    }
        
}

