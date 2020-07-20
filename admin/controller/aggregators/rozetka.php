<?php

class ControllerAggregatorsRozetka extends Controller {
    
    private $name="rozetka";
    private $settings=array();
    private $total=0;
    private $allowed_categories;
    private $shop = array();
    private $currencies = array();
    private $categories = array();
    private $offers = array();
    private $from_charset = 'utf-8';
    private $eol = "\n";
    private $additional;

    public function index($settings) {
        $this->additional = 'Дополнительно';
        $this->makeUrl();
        $server_name_for_url=$this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG;
        
        $this->settings = $settings;
        $this->load->model('feed/xmlprice');
        $allowed_categories = $this->model_feed_xmlprice->getAggregatorCategories($this->name);
        if (!$allowed_categories) {
            $result = array(
                'error' => 'No allowed categories'
            );
            return $result;
        }

        $this->allowed_categories=explode(',', $allowed_categories);
        $allowed_manufacturers=$this->model_feed_xmlprice->getAggregatorManufacturers($this->name);
        
        $this->load->model('feed/aggregator');
        $this->load->model('localisation/currency');
        $this->load->model('tool/image');


        // Магазин
        $this->setShop('name', $this->config->get('xmlprice_shopname'));
        $this->setShop('company', $this->config->get('xmlprice_company'));
        $this->setShop('url', HTTP_CATALOG);

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
        $this->setCurrency($offers_currency, 1);
        $currencies = $this->model_localisation_currency->getCurrencies();
        $supported_currencies = array('RUR', 'RUB', 'USD', 'BYR', 'KZT', 'EUR', 'UAH');
        $currencies = array_intersect_key($currencies, array_flip($supported_currencies));

        foreach ($currencies as $currency) {
            if ($currency['code'] != $offers_currency && $currency['status'] == 1) {
                $this->setCurrency($currency['code'], number_format(1/$this->currency->convert($currency['value'], $offers_currency, $shop_currency), 4, '.', ''));
            }
        }    

        // Категории
        $categories = $this->model_feed_aggregator->getCategory($this->name);
            
        foreach ($categories as $category) {
            $this->setCategory($category['name'], $category['category_id'], $category['parent_id'], $category['alias']);
        }

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
                $data['url'] =$server_name_for_url. $this->url->link('product/product', 'path=' . $this->getPath($product['category_id']) . '&product_id=' . $product['product_id']);
                $data['price'] = $product['price'];
                $data['currencyId'] = $offers_currency;
                $data['categoryId'] = $product['category_id'];
                $data['delivery'] = 'true';
                $data['name'] = $product['name'];
                $data['vendor'] = $product['manufacturer'];
                $data['vendorCode'] = $product['model'];
                $data['model'] = $product['name'];
                $data['description'] = $product['description'];
                if ($product['image']) {
                    $data['picture'] = $this->model_tool_image->resize($product['image'], 600, 500);
                }

                $parameters = $this->model_feed_aggregator->getProductAttributes($data['id']);

                foreach ($parameters as $parameter) {
                    $data['param'][] = array(
                        'name' => $parameter['name'],
                        'value' => $parameter['text']
                    );
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

    private function setCurrency($id, $rate = 'CBRF', $plus = 0) {
        $allow_id = array('RUR', 'RUB', 'USD', 'BYR', 'KZT', 'EUR', 'UAH');
        if (!in_array($id, $allow_id)) {
            return false;
        }
        $allow_rate = array('CBRF', 'NBU', 'NBK', 'CB');
        if (in_array($rate, $allow_rate)) {
            $plus = str_replace(',', '.', $plus);
            if (is_numeric($plus) && $plus > 0) {
                $this->currencies[] = array(
                    'id' => $this->prepareField(strtoupper($id)),
                    'rate' => $rate,
                    'plus' => (float) $plus
                );
            } else {
                $this->currencies[] = array(
                    'id' => $this->prepareField(strtoupper($id)),
                    'rate' => $rate
                );
            }
        } else {
            $rate = str_replace(',', '.', $rate);
            if (!(is_numeric($rate) && $rate > 0)) {
                return false;
            }
            $this->currencies[] = array(
                'id' => $this->prepareField(strtoupper($id)),
                'rate' => (float) $rate
            );
        }

        return true;
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

        $traits = '';
        if (isset($data['param'])) {
            $parameters = $data['param'];
            if (is_array($parameters)) {
                $traits.='<h4>' . $this->additional . '</h4><table><tbody>';
                foreach ($parameters as $param) {
                    $traits.='<tr>';
                    $traits.='<td>' . $param['name'] . ':</td><td>' . $param['value'] . '</td>';
                    $traits.='</tr>';
                }
                $traits.='</tbody></table>';
                $traits = $this->prepareDesc($traits);
            }
        }

        $offer = array();

        $attributes = array('id', 'available', 'param');
        $attributes = array_intersect_key($data, array_flip($attributes));

        foreach ($attributes as $key => $value) {
            switch ($key) {
                case 'id':
                    $value = (int) $value;
                    if ($value > 0) {
                        $offer[$key] = $value;
                    }
                    break;

                case 'available':
                    $offer['available'] = ($value ? 'true' : 'false');
                    break;

                case 'param':
                    if (is_array($value)) {
                        $offer['param'] = $value;
                    }
                    break;

                default:
                    break;
            }
        }

        $allowed_tags = array(
            'url' => 1,
            'price' => 1,
            'currencyId' => 1,
            'categoryId' => 1,
            'picture' => 1,
            'vendor' => 1,
            'name' => 1,
            'description' => 1,
        );

        $allowed_tags = array_merge($allowed_tags, array('aliases' => 0, 'additional' => 0, 'description' => 0, 'sales_notes' => 0, 'promo' => 0, 'manufacturer_warranty' => 0, 'country_of_origin' => 0, 'downloadable' => 0, 'adult' => 0, 'barcode' => 0));

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
            if ($key == 'description') {
                $offer['data'][$key] = $this->prepareDesc($data[$key]);
                $offer['data'][$key].=$traits;
            } else {
                $offer['data'][$key] = $this->prepareField($data[$key]);
            }
        }

        $this->offers[] = $offer;
    }

    private function fillXml() {
         if (!$this->settings['offset']) {
            $flag=true;
        $xml = '<?xml version="1.0" encoding="windows-1251"?>' . $this->eol;
        $xml .= '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">' . $this->eol;
        $xml .= '<yml_catalog date="' . date('Y-m-d H:i') . '">' . $this->eol;
        $xml .= '<shop>' . $this->eol;

        // информация о магазине
        $xml .= $this->array2Tag($this->shop);

        // валюты
        $xml .= '<currencies>' . $this->eol;
        foreach ($this->currencies as $currency) {
            $xml .= $this->getElement($currency, 'currency');
        }
        $xml .= '</currencies>' . $this->eol;

        // категории
        $xml .= '<categories>' . $this->eol;
        foreach ($this->categories as $category) {
             if($category['alias']){
                    $category_name = $category['alias'];
                }else{
                    $category_name = $category['name'];
                }
            unset($category['name'], $category['export'], $category['alias']);
            $xml .= $this->getElement($category, 'category', $category_name);
        }
        $xml .= '</categories>' . $this->eol;

        // товарные предложения
        $xml .= '<offers>' . $this->eol;
         }else{
            $flag = false;
            $xml = '';
         }
        foreach ($this->offers as $offer) {
            $tags = $this->array2Tag($offer['data']);
            unset($offer['data']);
            if (isset($offer['param'])) {
                unset($offer['param']);
            }
            $xml .= $this->getElement($offer, 'offer', $tags);
        }
        if($flag){
            file_put_contents('../rozetka.xml', $xml);
            return true;
        }
        
        if($this->settings['offset']+$this->settings['limit']>=$this->total){
            $xml .= '</offers>' . $this->eol;
            $xml .= '</shop>';
            $xml .= '</yml_catalog>';
        }
        file_put_contents('../rozetka.xml', $xml, FILE_APPEND);
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
            if ($key == 'description') {
                $retval .= '<' . $key . '><![CDATA[' . $value . ']]></' . $key . '>' . $this->eol;
                continue;
            }
            $retval .= '<' . $key . '>' . $value . '</' . $key . '>' . $this->eol;
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

    private function prepareDesc($field) {
        $field = htmlspecialchars_decode($field);
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
