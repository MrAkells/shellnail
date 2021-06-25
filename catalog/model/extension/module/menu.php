<?php
class ModelExtensionModuleMenu extends Model {
    
    public function createCategoryMenu(){  
        
        $cache_data=$this->cache->get('menushka_' . $this->config->get('config_language_id'));
        if($cache_data){
            return $cache_data;
        }
        
        $this->load->model('catalog/category');
        $this->load->model('tool/image');  
        $this->load->model('catalog/extralinks'); 
        
            $full_category_data = array();

            $categories = $this->model_catalog_category->getCategories(0);
            $extra_links=$this->model_catalog_extralinks->getExtralinks();
            if ( $_SERVER['REMOTE_ADDR'] == '82.207.90.222') {
        var_dump($extra_links); die;        
        }
            foreach ($categories as $category) {
               
                $children_data = array();

                $children = $categories = $this->model_catalog_category->getCategories($category['category_id']);
                $number_of_categories=0;
                foreach ($children as $child) {
 
                    $number_of_categories++;
                      
                        $data_level3 = array();
                        $level3 = $this->model_catalog_category->getCategories($child['category_id']);
                        
                        foreach ($level3 as $lev)
                        {
                            $number_of_categories++;
                            $data_level3[] = array(
                                'category_id' => $lev['category_id'],
                                'name'        => $lev['name'],
                                'sort_order'        => $lev['sort_order'],
                                'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'] . '_' . $lev['category_id'])	
                            );     
                           
                        }
                        
                        if(isset($extra_links[$child['category_id']])){
                            foreach($extra_links[$child['category_id']] as $link){
                        
                                $data_level3[]  = array(
                                    'name'        => $link['title'],
                                    'href'        => $link['link'],
                                    'sort_order' => $link['sort_order']    
                                );
                                $number_of_categories++;
                                unset($link);
                            }
                                
                            $sort=[];
                            foreach($data_level3  as $key=>$value){
                                $sort[$key]=$value['sort_order'];
                            }
                            array_multisort($sort, SORT_ASC, $data_level3);
                            unset($extra_links[$child['category_id']]);
                        }
                        
                        
                        $children_data[] = array(
                            'category_id' => $child['category_id'],
                            'name'        => $child['name'],
                            'level3'    => $data_level3,
                            'sort_order'=>$child['sort_order'],
                            'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
                        );
                        
                }
                
                 if(isset($extra_links[$category['category_id']])){
                            foreach($extra_links[$category['category_id']] as $link){
                        
                                $children_data[] = array(
                                    'name'        => $link['title'],
                                    'children'    => [],
                                    'level3'    => [],
                                    'href'        => $link['link'],
                                    'sort_order'        => $link['sort_order']
                                );
                                $number_of_categories++;
                                unset($link);
                            }
                            
                            $sort=[];
                            foreach($children_data  as $key=>$value){
                                $sort[$key]=$value['sort_order'];
                            }
                            array_multisort($sort, SORT_ASC, $children_data);
                            unset($extra_links[$child['category_id']]);
                            
                        }
                
                
                
                if ($category['icon']) {
                    $icon = $this->model_tool_image->resize($category['icon'], 25,25);
                    //$icon='image/'.$category['icon'];
		} else {
                    $icon = '';
		}
                
                if ($category['icon2']) {
                    $icon2 = $this->model_tool_image->resize($category['icon2'], 25,25);
                    //$icon2='image/'.$category['icon2'];
		} else {
                    $icon2 = $icon;
		}
           
                if($category['column']>5 || $category['column']<1 ){
                    $cols=1;
                }else{
                    $cols=(int)$category['column'];
                }
                
                
                $full_category_data[] = array(
                        'category_id' => $category['category_id'],
                        'cols'=>$cols,
                        'number_of_categories'=>ceil($number_of_categories/$cols),
                        'sort_order'=>$category['sort_order'],
                        'name'        => $category['name'],
                        'icon'=>$icon,
                        'icon2'=>$icon2,
                        'children'    => $children_data,
                        'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
                );
                
      
                
            }
   
            $this->load->model('catalog/manufacturer');
            $results = $this->model_catalog_manufacturer->getManufacturers();

                $data['manufacturers']=[];
		foreach ($results as $result) {
                    
                   
                    $data['manufacturers'][] = array(
			'name' => $result['name'],
			'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id']),
                        'level3'    => [],
                    );
                    
		}
            
                        if($this->config->get('owner_brands_icon')){
                            $icon_manuf = $this->model_tool_image->resize($this->config->get('owner_brands_icon'), 25,25);
                        }else{
                            $icon_manuf='';
                        }
                        
                        if ($this->config->get('owner_brands_icon2')) {
                            $icon_manuf2 = $this->model_tool_image->resize($this->config->get('owner_brands_icon2'), 25,25);
                        } else {
                            $icon_manuf2 = '';
                        }
                
                  $full_category_data[] = array(
                            'name'        => $this->config->get('owner_brands_name'),
                            'icon'=> $icon_manuf,
                            'icon2'=>$icon_manuf2,
                            'cols'=> 2,
                            'number_of_categories'=>ceil(count($data['manufacturers'])/2),
                            'children'    => $data['manufacturers'],
                            'href'        => $this->url->link('product/manufacturer'),
                            'sort_order'    => 1000,
                        );
            
            
            
                if(isset($extra_links[0])){
                    foreach($extra_links[0] as $link){
                        
                        if($link['icon']){
                            $icon_ = $this->model_tool_image->resize($link['icon'], 25,25);
                        }else{
                            $icon_='';
                        }
                        
                        if ($link['icon2']) {
                            $icon2_ = $this->model_tool_image->resize($link['icon2'], 25,25);
                        } else {
                            $icon2_ = $icon_;
                        }
                        
                        $full_category_data[] = array(
                            'name'        => $link['title'],
                            'icon'=>$icon_,
                            'icon2'=>$icon2_,
                            'children'    => [],
                            'href'        => $link['link'],
                            'sort_order'    => $link['sort_order'],
                        );
                        
                        unset($link);
                    }
                        $sort=[];
                            foreach($full_category_data  as $key=>$value){
                                $sort[$key]=$value['sort_order'];
                            }
                        array_multisort($sort, SORT_ASC, $full_category_data);
                        unset($extra_links[0]);
                }
        
            $this->cache->set('menushka_' . $this->config->get('config_language_id'), $full_category_data);
            
            return $full_category_data;
    }
    
  
}
