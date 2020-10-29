<?php

class ControllerExtensionModuleDVFilter extends Controller {

    public $registry;
    private $data = array();

    public function __construct($registry) {
        $this->registry = $registry;

        if (false !== $this->dvfilter) {
            $this->data = $this->dvfilter->data;
            return;
        }

        $this->load->language('extension/module/dvfilter');

        $this->load->config('dvfilter');
        $this->load->helper('dvfilter');

        $this->load->model('catalog/dvfilter');
        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        // Decode URL
        $this->decode();

        if (!$this->path && !isset($this->request->get['manufacturer_id'])) {
            return;
        }

        $parts = explode('_', $this->path);

        $this->category_id = (int) end($parts);

        if (isset($this->request->get['manufacturer_id'])) {
            $this->manufacturer_id = $this->request->get['manufacturer_id'];
        } else {
            $this->manufacturer_id = false;
        }

        if (isset($this->request->get['filter_dvfilter'])) {
            $this->params = cleanParamsString($this->request->get['filter_dvfilter'], $this->config);

            if ($this->params) {
                $options_get = decodeParamsFromString($this->params, $this->config);

                $this->options_get = $options_get;

                if ($this->config->get('dvfilter_show_price') && !empty($options_get['p'])) {
                    $range = getRangeParts(end($options_get['p']));

                    if (isset($range['from']) && isset($range['to'])) {
                        $this->min_price_get = $range['from'];
                        $this->max_price_get = $range['to'];
                    }
                }

                if (!$this->page_info && $this->config->get('dvfilter_noindex_limit') > 0) {
                    $values_count = 0;

                    foreach ($this->options_get as $option_id => $values) {
                        $values_count += count($values);
                    }

                    if ($values_count >= $this->config->get('dvfilter_noindex_limit')) {
                        $this->document->setNoindex(true);
                    }
                }
            }
        }

        # Доработка фильтра на странице производителей
        if (isset($this->request->get['manufacturer_id'])) {
            $filter_data = array(
                'filter_category_id' => $this->category_id,
                'filter_manufacturer_id' => $this->request->get['manufacturer_id'],
                'filter_dvfilter' => $this->params
            );
        } else {
            $filter_data = array(
                'filter_category_id' => $this->category_id,
                'filter_dvfilter' => $this->params
            );
        }
        # Доработка фильтра на странице производителей
        # Manufacturer_filter
        if (isset($this->request->get['manufacturer_id']) && !$this->params) {
            $params = array(
                'm' => array($this->request->get['manufacturer_id'])
            );

            $this->params = encodeParamsToString($params, $this->config);

            $filter_data = array(
                'filter_category_id' => $this->category_id,
                'filter_manufacturer_id' => $this->request->get['manufacturer_id'],
                'filter_dvfilter' => $this->params
            );
        }
        # End Manufacturer_filter #
        # Get values counter
        $this->counters = $this->model_catalog_dvfilter->getCounters($filter_data);


        if ($this->config->get('dvfilter_show_price')) {
            $filter_data['filter_dvfilter'] = $this->cancelOptionParams('p');

            $this->product_prices = $this->model_catalog_dvfilter->getProductPrices($filter_data);

            if ($this->product_prices) {
                $this->min_price = floor($this->product_prices['min'] * $this->currency->getValue($this->session->data['currency']));
                $this->max_price = ceil($this->product_prices['max'] * $this->currency->getValue($this->session->data['currency']));
            }
        }

        # Cached options keywords
        $option_keywords = array();
        $value_keywords = array();

        $option_keywords['p'] = 'price';
        $option_keywords['s'] = 'sklad';
        $option_keywords['m'] = 'proizvoditel';
        $option_keywords['c'] = 'category';

        $results = $this->model_catalog_dvfilter->getCategories($this->category_id);

        foreach ($results as $value) {

            $keyword = $this->model_catalog_dvfilter->getCategorySeoByCategoryId($value['value_id']);

            if ($keyword) {
                $value_keywords['c-' . $value['value_id']] = $keyword;
            } else {
                $value_keywords['c-' . $value['value_id']] = $value['value_id'];
            }
        }

        $results = $this->model_catalog_dvfilter->getManufacturersByCategoryId($this->category_id);

        foreach ($results as $value) {
            if ($value['keyword']) {
                $value_keywords['m-' . $value['value_id']] = $value['keyword'];
            } else {
                $value_keywords['m-' . $value['value_id']] = $value['value_id'];
            }
        }

        # Доработка фильтра на странице производителей
        if (isset($this->request->get['manufacturer_id'])) {
            # Get manufacturer options
            $results = $this->model_catalog_dvfilter->getDVFilterOptionsByManufacturerId($this->request->get['manufacturer_id']);
        } else {
            # Get category options
            $results = $this->model_catalog_dvfilter->getDVFilterOptionsByCategoryId($this->category_id);
        }
        # Доработка фильтра на странице производителей

        foreach ($results as $option) {
            if ($option['keyword']) {
                $option_keywords[$option['option_id']] = $option['keyword'];
            } else {
                $option_keywords[$option['option_id']] = $option['option_id'];
            }

            foreach ($option['values'] as $value) {
                if (isset($value['keyword']) && $value['keyword'] != '') {
                    $value_keywords[$option['option_id'] . '-' . $value['value_id']] = $value['keyword'];
                } else {
                    $value_keywords[$option['option_id'] . '-' . $value['value_id']] = $value['value_id'];
                }
            }
        }

        $this->option_keywords = $option_keywords;
        $this->value_keywords = $value_keywords;

        # Cached existing seo pages
        $pages = array();

        $results = $this->model_catalog_dvfilter->getPages();

        foreach ($results as $result) {
            $pages[md5($result['category_id'] . $result['dvfilter_params'])] = $result['dvfilter_page_id'];
        }

        $this->pages = $pages;

        $this->registry->set('dvfilter', $this);
    }

    // Array access
    public function __get($key) {
        if (isset($this->data[$key])) {
            if (!is_array($this->data[$key])) {
                $property = $this->data[$key];
            } else {
                $property = &$this->data[$key];
            }
        } else if ($this->registry->has($key)) {
            $property = $this->registry->get($key);
        } else {
            $property = false;
        }

        return $property;
    }

    public function __set($key, $value) {
        $this->data[$key] = $value;
    }

    // Empty method to prevent execution of index()
    public function initialise() {
        
    }

    public function index($settings = array()) {
        if (!$this->category_id) {
            $this->category_id = 0;
        }

        $this->load->language('extension/module/dvfilter');

        if ($this->config->get('dvfilter_show_price') && $this->min_price < $this->max_price - 1) {
            $data['show_price'] = 1;
        } else {
            $data['show_price'] = 0;
        }

        $data['heading_title'] = $this->language->get('heading_title');

        if ($this->min_price_get && $this->min_price_get < $this->min_price) {
            $this->min_price = $this->min_price_get;
        }

        if ($this->max_price_get && $this->max_price_get > $this->max_price) {
            $this->max_price = $this->max_price_get;
        }

        $data['options'] = $this->getDVFilterOptions();

        $data['min_price'] = $this->min_price;
        $data['max_price'] = $this->max_price;
        $data['min_price_get'] = $this->min_price_get ? $this->min_price_get : $this->min_price;
        $data['max_price_get'] = $this->max_price_get ? $this->max_price_get : $this->max_price;
        $data['path'] = $this->path;
        $data['manufacturer_id'] = $this->manufacturer_id;

        $data['link'] = str_replace('&amp;', '&', $this->link());

        $data['params'] = $this->params;

        $data['index'] = $this->config->get('dvfilter_url_index');
        $data['show_counter'] = $this->config->get('dvfilter_show_counter');
        $data['show_values_limit'] = $this->config->get('dvfilter_show_values_limit');
        $data['manual_price'] = $this->config->get('dvfilter_manual_price');

        $data['text_show_all'] = $this->language->get('text_show_all');
        $data['text_hide'] = $this->language->get('text_hide');
        $data['button_select'] = $this->language->get('button_select');
        $data['text_load'] = $this->language->get('text_load');
        $data['text_price'] = $this->language->get('text_price');
        $data['text_any'] = $this->language->get('text_any');
        $data['text_cancel_all'] = $this->language->get('text_cancel_all');

        $data['symbol_left'] = $this->currency->getSymbolLeft($this->session->data['currency']);
        $data['symbol_right'] = $this->currency->getSymbolRight($this->session->data['currency']);

        if ($this->min_price_get && $this->max_price_get) {
            $data['price'] = 'p' . $this->config->get('dvfilter_sep_opt') . $this->min_price_get . '-' . $this->max_price_get;
        } else {
            $data['price'] = '';
        }

        if (isset($this->session->data['dvfilter_show_options'])) {
            $data['show_options'] = $this->session->data['dvfilter_show_options'];
        } else {
            $data['show_options'] = 0;
        }

        if ($this->config->get('dvfilter_show_diagram') && $this->config->get('dvfilter_show_price')) {
            $data['diagram'] = $this->getDiagram();
        } else {
            $data['diagram'] = array();
        }

        if ($this->config->get('dvfilter_show_selected') && $this->options_get) {
            $data['selecteds'] = $this->getSelectedOptions();
        } else {
            $data['selecteds'] = array();
        }

        if ($this->config->get('dvfilter_show_price') && $this->min_price_get && $this->max_price_get) {
            $data['show_price_selected'] = 1;
        } else {
            $data['show_price_selected'] = 0;
        }

        if ($this->config->get('dvfilter_show_options_limit') && $this->config->get('dvfilter_show_options_limit') < count($data['options'])) {
            $data['show_options_limit'] = $this->config->get('dvfilter_show_options_limit');
        } else {
            $data['show_options_limit'] = false;
        }

        $this->document->addStyle('catalog/view/javascript/dvfilter/nouislider.min.css');
        $this->document->addStyle('catalog/view/theme/default/stylesheet/dvfilter/dvfilter.css');

        $this->document->addScript('catalog/view/javascript/dvfilter/nouislider.min.js');
        

        $this->document->addScript('catalog/view/javascript/dvfilter/dvfilter.js?v=5');
        
  
  
        $query_colors = $this->db->query("SELECT * FROM " . DB_PREFIX . "colors");
        $data['filter_colors_array']=array();
            foreach($query_colors->rows as $row){
                $data['filter_colors_array'][$row['name']]=$row['code'];
            }

        $data['collapsed'] = isset($this->request->post['collapsed']) ? $this->request->post['collapsed'] : [] ;
        $is_GET = ($this->request->server['REQUEST_METHOD'] == 'GET');
 
        $data['is_mobile'] = ($is_GET && $this->detectmobile());
        
  
            foreach ($data['options'] as $key => $passed_option) {
                $should_collapse=true; 
                foreach ($passed_option['values'] as $val_key => $val_value) {
                    for($i=$val_key; $i<count($passed_option['values']); $i++){ 
                        if($passed_option['values'][$i]['selected']){
                            $should_collapse=false;
                            break;
                        }
                    } 
                }
                $data['options'][$key]['collapse'] = $should_collapse; 
             }
      
             return $this->load->view('extension/module/dvfilter', $data);
     
        
    }

    private function getDVFilterOptions() {

        if (false !== $this->options) {
            return $this->options;
        }

        $options = array();

        # Category filtering
        if ($this->config->get('dvfilter_category')) {

            $results = $this->model_catalog_dvfilter->getCategories($this->category_id);

            if ($results) {
                $options[] = array(
                    'option_id' => 'c',
                    'name' => $this->language->get('text_category'),
                    'description' => $this->language->get('text_category_description'),
                    'type' => 'checkbox',
                    'values' => $results
                );
            }
        }



        # End Category filtering
        # Manufacturers filtering
        if ($this->config->get('dvfilter_manufacturer')) {
            $results = $this->model_catalog_dvfilter->getManufacturersByCategoryId($this->category_id);


            if ($results) {
                $options[] = array(
                    'option_id' => 'm',
                    'name' => $this->language->get('text_manufacturer'),
                    'description' => $this->language->get('text_manufacturer_description'),
                    'type' => $this->config->get('dvfilter_manufacturer_type'),
                    'values' => $results
                );
            }
        }
        # End Manufacturers filtering

        # Stock status filtering
        if ($this->config->get('dvfilter_stock_status')) {
            if ($this->config->get('dvfilter_stock_status_method') == 'stock_status_id') {
                $results = $this->model_catalog_dvfilter->getStockStatuses();

                $options['stock'] = array(
                    'option_id' => 's',
                    'name' => $this->language->get('text_stock'),
                    'description' => $this->language->get('text_stock_description'),
                    'type' => $this->config->get('dvfilter_stock_status_type'),
                    'values' => $results
                );
            } elseif ($this->config->get('dvfilter_stock_status_method') == 'quantity') {
                $options['stock'] = array(
                    'option_id' => 's',
                    'name' => $this->language->get('text_stock'),
                    'description' => $this->language->get('text_stock_description'),
                    'type' => ($this->config->get('dvfilter_stock_out_value') ? 'radio' : 'checkbox'),
                    'values' => array(
                        array(
                            'value_id' => 'in',
                            'name' => 'В наличии'
                        )
                    )
                );

                if ($this->config->get('dvfilter_stock_out_value')) {
                    $options['stock']['values'][] = array(
                        'value_id' => 'out',
                        'name' => $this->language->get('text_out_of_stock')
                    );
                }
            }
        }

        # Get category options
        # Доработка фильтра на странице производителей
        if (isset($this->request->get['manufacturer_id'])) {
            # Get manufacturer options
            $results = $this->model_catalog_dvfilter->getDVFilterOptionsByManufacturerId($this->request->get['manufacturer_id']);
        } else {
            # Get category options
            $results = $this->model_catalog_dvfilter->getDVFilterOptionsByCategoryId($this->category_id);
        }
        # Доработка фильтра на странице производителей

        if ($results) {
            $options = array_merge($options, $results);
        }

        $options_data = array();

        if ($options) {

            foreach ($options as $key => $option) { # Start options each
                $this_option = isset($this->options_get[$option['option_id']]);

                $values = array();

                if ($option['type'] != 'slide' && $option['type'] != 'slide_dual') {
                    if (isset($option['grouping']) && (int) $option['grouping']) {

                        if ((int) $option['grouping'] < 2) {
                            $option['grouping'] = 2;
                        }

                        for ($i = 0; $i < count($option['values']); $i = $i + $option['grouping']) {
                            $groups = array();
                            $selected = false;
                            $count = 0;

                            if ($option['type'] == 'select' || $option['type'] == 'radio') {
                                $this->params = $this->cancelOptionParams($option['option_id']);
                            }

                            for ($j = $i; $j < ($i + $option['grouping']); $j++) {
                                if (isset($option['values'][$j])) {
                                    if (isset($this->counters[$option['option_id'] . $option['values'][$j]['value_id']])) {
                                        $count += $this->counters[$option['option_id'] . $option['values'][$j]['value_id']];
                                    }

                                    $params = $this->getValueParams($option['option_id'], $option['values'][$j]['value_id'], 'checkbox');

                                    $groups[] = $option['values'][$j];

                                    if (isset($this->options_get[$option['option_id']]) && in_array($option['values'][$j]['value_id'], $this->options_get[$option['option_id']])) {
                                        $selected = true;
                                    }

                                    $this->params = $params;
                                }
                            }

                            if ($groups && (!$this->config->get('dvfilter_hide_empty_values') || ($this->config->get('dvfilter_hide_empty_values') && $count))) {
                                $first = array_shift($groups);
                                $last = array_pop($groups);

                                if ($count && $this_option && $option['type'] == 'checkbox') {
                                    $count = '+' . $count;
                                }

                                $values[] = array(
                                    'value_id' => $first['value_id'],
                                    'id' => $option['option_id'] . $first['value_id'],
                                    'name' => html_entity_decode($first['name'] . ($last ? ' - ' . $last['name'] : '') . $option['postfix'], ENT_QUOTES, 'UTF-8'),
                                    'params' => $params,
                                    'href' => $this->link($params),
                                    'count' => $count,
                                    'selected' => $selected
                                );
                            }

                            # Reset params from request
                            if (isset($this->request->get['filter_dvfilter'])) {
                                $this->params = cleanParamsString($this->request->get['filter_dvfilter'], $this->config);
                            } else {
                                $this->params = '';
                            }
                        }
                    } else {
                        foreach ($option['values'] as $value) {
                            $this_value = isset($this->options_get[$option['option_id']]) && in_array($value['value_id'], $this->options_get[$option['option_id']]);
                            $count = 0;

                            if (isset($this->counters[$option['option_id'] . $value['value_id']])) {
                                if ($this_option && $option['type'] == 'checkbox') {
                                    $count = '+' . $this->counters[$option['option_id'] . $value['value_id']];
                                } else {
                                    $count = $this->counters[$option['option_id'] . $value['value_id']];
                                }
                            }

                            if ($count || !$this->config->get('dvfilter_hide_empty_values') ) {

                                if (isset($option['image']) && $option['image'] && isset($value['image']) && $value['image'] && file_exists(DIR_IMAGE . $value['image'])) {
                                    $image = $this->model_tool_image->resize($value['image'], 19, 19);
                                } else {
                                    $image = false;
                                }

                                $params = $this->getValueParams($option['option_id'], $value['value_id'], $option['type']);
                                
                                $values[] = array(
                                    'value_id' => $value['value_id'],
                                    'id' => $option['option_id'] . $value['value_id'],
                                    'name' => html_entity_decode($value['name'] . (isset($option['postfix']) ? $option['postfix'] : ''), ENT_QUOTES, 'UTF-8'),
                                    'keyword' => html_entity_decode((isset($value['keyword']) ? $value['keyword'] : $value['value_id']), ENT_QUOTES, 'UTF-8'),
                                    'color' => ((isset($value['color']) && $value['color']) ? $value['color'] : '#FFFFFF'),
                                    'image' => $image,
                                    'params' => $params,
                                    'href' => $this->link($params),
                                    'count' => $count,
                                    'selected' => $this_value
                                );
                                
                                
                                
                            }
                        }
                    }
                }

               
                if ($option['type'] != 'slide' && $option['type'] != 'slide_dual' && !$values) {
                    continue;
                }


                if ($values && $option['type'] == 'select' || $option['type'] == 'radio') {

                    $params = $this->cancelOptionParams($option['option_id']);

                    if (isset($this->counters[$option['option_id'] . 'all'])) {
                        $count = $this->counters[$option['option_id'] . 'all'];
                    } else {
                        $count = 1;
                    }

                    array_unshift($values, array(
                        'value_id' => $option['option_id'],
                        'id' => 'cancel-' . $option['option_id'],
                        'name' => $this->language->get('text_any'),
                        'params' => $params,
                        'href' => $this->link($params),
                        'count' => $count,
                        'selected' => !$this_option
                    ));
                }

                $options_data[$option['option_id']] = array(
                    'option_id' => $option['option_id'],
                    'index' => count($options_data) + 1,
                    'name' => html_entity_decode($option['name'], ENT_QUOTES, 'UTF-8'),
                    'selectbox' => (isset($option['selectbox']) ? $option['selectbox'] : false),
                    'color' => (isset($option['color']) ? $option['color'] : false),
                    'image' => (isset($option['image']) ? $option['image'] : false),
                    'keyword' => (isset($option['keyword']) ? $option['keyword'] : $option['option_id']),
                    'postfix' => (isset($option['postfix']) ? html_entity_decode($option['postfix'], ENT_QUOTES, 'UTF-8') : ''),
                    'description' => (isset($option['description']) ? $option['description'] : ''),
                    'slide_value_min' => (isset($option['slide_value_min']) ? $option['slide_value_min'] : 0),
                    'slide_value_max' => (isset($option['slide_value_max']) ? $option['slide_value_max'] : 0),
                    'slide_value_min_get' => (isset($option['slide_value_min']) ? $option['slide_value_min'] : 0),
                    'slide_value_max_get' => (isset($option['slide_value_max']) ? $option['slide_value_max'] : 0),
                    'type' => $option['type'],
                    'selected' => $this_option,
                    'values' => $values
                );

                if (($option['type'] == 'slide' || $option['type'] == 'slide_dual') && isset($this->options_get[$option['option_id']][0])) {
                    $range = getRangeParts($this->options_get[$option['option_id']][0]);

                    if (isset($range['from']) && isset($range['to'])) {
                        $options_data[$option['option_id']]['slide_value_min_get'] = $range['from'];
                        $options_data[$option['option_id']]['slide_value_max_get'] = $range['to'];

                        // For getSelectedOptions
                        array_unshift($options_data[$option['option_id']]['values'], array(
                            'value_id' => $range['from'] . '-' . $range['to'],
                            'name' => 'от ' . $range['from'] . ' до ' . $range['to'] . $option['postfix']
                        ));
                    }
                }
            } # End options each
        }

//         if($_SERVER['REMOTE_ADDR']=="185.181.17.240"){
//                    echo '<pre>';
//                    var_dump($options_data);
//                    die;
//                }
                
        
        $this->options = $options_data;

        return $options_data;
    }

    private function getValueParams($option_id, $value_id, $type = 'checkbox') {
        $decoded_params = decodeParamsFromString($this->params, $this->config);

        if (isset($this->request->get['manufacturer_id'])) {
            unset($decoded_params['m']);
        }

        if ($type == 'checkbox') {
            if (isset($decoded_params[$option_id])) {
                if (false !== $key = array_search($value_id, $decoded_params[$option_id])) {
                    unset($decoded_params[$option_id][$key]);
                } else {
                    $decoded_params[$option_id][] = $value_id;
                }
            } else {
                $decoded_params[$option_id] = array($value_id);
              
            }
        } elseif ($type == 'select' || $type == 'radio') {
            if (isset($decoded_params[$option_id])) {
                unset($decoded_params[$option_id]);
            }

            $decoded_params[$option_id] = array($value_id);
        }

        return encodeParamsToString($decoded_params, $this->config);
    }

    private function cancelOptionParams($option_id) {
        if ($this->params) {
            $params = decodeParamsFromString($this->params, $this->config);

            if (isset($params[$option_id])) {
                unset($params[$option_id]);
            }

            return encodeParamsToString($params, $this->config);
        }
    }

    private function getSelectedOptions() {
        $selected_options = array();

        $category_options = $this->getDVFilterOptions();

        if ($this->min_price_get && $this->max_price_get) {
            $category_options['p'] = array(
                'name' => $this->language->get('text_price'),
                'type' => 'select',
                'selected' => isset($this->options_get['p']),
                'values' => array(array(
                        'value_id' => $this->min_price_get . '-' . $this->max_price_get,
                        'name' => 'от ' . $this->currency->getSymbolLeft($this->session->data['currency']) . $this->min_price_get . ' до ' . $this->max_price_get . $this->currency->getSymbolRight($this->session->data['currency'])
                    ))
            );
        }

        foreach ($category_options as $option_id => $option) {

            if (!$option['selected']) {
                continue;
            }

            $values = array();

            foreach ($option['values'] as $value) {
                if (!in_array($value['value_id'], $this->options_get[$option_id])) {
                    continue;
                }

                $params = '';

                if (count($this->options_get) > 1 || count($this->options_get[$option_id]) > 1) {
                    if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'slide' || $option['type'] == 'slide_dual') {
                        $params .= $this->cancelOptionParams($option_id);
                    } else {
                        $params .= $value['params'];
                    }
                }

                $name = html_entity_decode($value['name'], ENT_QUOTES, 'UTF-8');

                if (false === strpos($value['value_id'], '-') && mb_strlen($name, 'UTF-8') > 30) { // было 20
                   $name = mb_substr($value['name'], 0, 30, 'UTF-8');
                }

                $values[] = array(
                    'name' => $name,
                    'id' => $option_id . $value['value_id'],
                    'href' => $this->link($params),
                );
            }

            $selected_options[$option_id] = array(
                'name' => $option['name'],
                'values' => $values
            );
        }

        return $selected_options;
    }

    private function getDiagram() {
        # Generate product price diagram coords by SooR 18-02-2013 v.2.0

        $diagram_data = array();

        if ($this->product_prices && count($this->product_prices['products']) > 1) {
            $height = 40;
            $items = 6;
            $width = 190;

            $price_range = $this->max_price - $this->min_price;

            if ($price_range < $items) {
                return;
            }

            $price_interval = $price_range / $items;

            $items_data = array();

            $max_count = 0;

            for ($i = 0; $i < $items; $i++) {
                $from = $i * $price_interval + $this->min_price;
                $to = ($i + 1) * $price_interval + $this->min_price;

                $count = 0;

                foreach ($this->product_prices['products'] as $price) {
                    if ($price >= $from && $price <= $to) {
                        $count++;
                    }
                }

                if ($count > $max_count) {
                    $max_count = $count;
                }

                $items_data[] = $count;
            }

            $items_interval = $width / ($items - 1);

            $diagram_data['circles'] = array();

            $diagram_data['path'] = 'M0,' . $height;

            foreach ($items_data as $key => $count) {
                $y = round($height / 100 * (100 - $count / $max_count * 100));
                $y = ($y < $height / 2 ? $y + 5 : $y - 5);

                $x = round($key * $items_interval, 1);

                $diagram_data['circles'][] = array('y' => $y, 'x' => $x, 'count' => $count);

                $diagram_data['path'] .= ' L' . $x . ',' . $y;

                if ($key == count($items_data) - 1) {
                    $diagram_data['path'] .= ' L' . $x . ',' . $height;
                }
            }

            $diagram_data['path'] .= ' L0,' . $height . 'Z';
        }

        return $diagram_data;
    }

    public function decode() {
        if (isset($this->request->get['path'])) {
            $this->path = $this->request->get['path'];
        }

        if (!isset($this->request->get['_route_'])) {
            return;
        }

        $_route_ = $this->request->get['_route_'];
        $keywords = explode('_', $_route_);
      
        if ($this->config->get('config_seo_url_type') == 'seo_pro') {
            if (substr(end($keywords), -1) == "/") {
                array_push($keywords, substr(array_pop($keywords), 0, -1));
            }
        }
        # SEO PRO Fix
        // remove any empty arrays from trailing
        if (utf8_strlen(end($keywords)) == 0) {
            array_pop($keywords);
        }

        // Get category path
        if (!$this->path) {
            $or = array();

            $keywords_ = explode('/', $keywords[0]);
            
            
            foreach ($keywords_ as $keyword) {

                if ($keyword == 'category') {
                    break;
                }

                $or[] = "keyword = '" . $this->db->escape($keyword) . "'";
            }

            $implode = array();

            foreach ($keywords_ as $keyword) {

                if ($keyword == 'category') {
                    break;
                }

                $implode[] = "'" . $this->db->escape($keyword) . "'";
            }

            if ($or) {

                $path = $this->cache->get('category.dvfilter.path.' . md5(implode(".", $implode)));

                if (false !== $path) {
                    $this->path = $path;
                } else {
                    $query = $this->db->query("SELECT GROUP_CONCAT(REPLACE(`query`, 'category_id=', '') ORDER BY FIELD(keyword, " . implode(", ", $implode) . ") SEPARATOR '_') AS path FROM " . DB_PREFIX . "url_alias WHERE `query` LIKE 'category_id=%' AND (" . implode(" OR ", $or) . ")");

                    if (!empty($query->row['path'])) {
                        $this->path = $query->row['path'];

                        $this->cache->set('category.dvfilter.path.' . md5(implode(".", $implode)), $this->path);
                    } else {
                        $query = $this->db->query("SELECT GROUP_CONCAT(REPLACE(`query`, 'manufacturer_id=', '') ORDER BY FIELD(keyword, " . implode(", ", $implode) . ") SEPARATOR '_') AS path FROM " . DB_PREFIX . "url_alias WHERE `query` LIKE 'manufacturer_id=%' AND (" . implode(" OR ", $or) . ")");
                        if (!empty($query->row['path'])) {
                            $this->manufacturer_id = $query->row['path'];
                            $this->request->get['manufacturer_id'] = $query->row['path'];
                        }
                    }
                }
            }
        }

        if (!$this->path && !isset($this->request->get['manufacturer_id'])) {
            return;
        }

        $parts = explode('_', $this->path);

        $category_id = (int) end($parts);

        // Get SEO Page
        foreach ($keywords as $key => $keyword) {
            $page_info = $this->cache->get('dvfilter.page.keyword.' . md5($keyword));

            if (false === $page_info) {
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dvfilter_page WHERE status = '1' AND keyword = '" . $this->db->escape($keyword) . "' LIMIT 1");

                if ($query->num_rows) {
                    $page_info = $query->row;

                    $this->cache->set('dvfilter.page.keyword.' . md5($keyword), $page_info);
                }
            }

            if ($page_info) {
                $this->page_info = $page_info;

                $keywords = explode('_', $page_info['dvfilter_params']);

                // remove any empty arrays from trailing
                if (utf8_strlen(end($keywords)) == 0) {
                    array_pop($keywords);
                }

                break;
            }
        }

        $params = array();

        $current = '';

     
        
        foreach ($keywords as $key => $keyword) {

            $founded = 0;

            // Values
            if ($current == 'p') {
                if (isRange($keyword)) {
                    $params['p'][] = $keyword;
                }

                $founded = 2;
            } else if ($current == 's') {
                if ($this->config->get('dvfilter_stock_status_method') == 'quantity') {
                    $params['s'][] = $keyword;

                    $founded = 2;
                } else if (isID($keyword)) {
                    $params['s'][$keyword] = $keyword;

                    $founded = 1;
                } else {
                    $current = '';
                }
            } else if ($current) {
                $values_id = $this->cache->get('dvfilter.decode.' . $current . '.' . md5($keyword));

                if (false === $values_id) {
                    $values_id = array();

                    $query = $this->db->query("SELECT value_id FROM " . DB_PREFIX . "dvfilter_option_value WHERE option_id = '" . (int) $current . "' AND `keyword` = '" . $this->db->escape($keyword) . "'");

                    // If keyword is ID
                    if (!$query->num_rows && isID($keyword)) {
                        $query = $this->db->query("SELECT value_id FROM " . DB_PREFIX . "dvfilter_option_value WHERE value_id = '" . (int) $keyword . "'");
                    }

                    if ($query->num_rows) {
                        foreach ($query->rows as $result) {
                            $values_id[] = $result['value_id'];
                        }

                        $this->cache->set('dvfilter.decode.' . $current . '.' . md5($keyword), $values_id);
                    }
                }

                if ($values_id) {
                    foreach ($values_id as $value_id) {
                        $params[$current][$value_id] = $value_id;
                    }

                    $founded = 1;
                } else if (isRange($keyword)) { // If Slider
                    $params[$current][$keyword] = $keyword;

                    $founded = 2;
                }
            }

            if ($founded > 0) {
                if ($founded > 1) {
                    $current = '';
                }

                unset($keywords[$key]);

                continue;
            }

            // Options
            if ($keyword == 'price') {
                $params['p'] = array();

                $current = 'p';

                unset($keywords[$key]);
            } else if ($keyword == 'sklad') {
                $params['s'] = array();

                $current = 's';

                unset($keywords[$key]);
            } else if (!isRange($keyword)) {
                $option_id = $this->cache->get('dvfilter.decode.option.' . md5($keyword) . '.' . (int) $category_id);

                if (false == $option_id) {
                    // Get Option by keyword
                    if (isset($this->request->get['manufacturer_id'])) {
                        $query = $this->db->query("SELECT oo.option_id FROM " . DB_PREFIX . "dvfilter_option oo LEFT JOIN " . DB_PREFIX . "dvfilter_option_to_category oo2c ON(oo.option_id = oo2c.option_id) WHERE oo.`keyword` = '" . $this->db->escape($keyword) . "' LIMIT 1");
                    } else {
                        $query = $this->db->query("SELECT oo.option_id FROM " . DB_PREFIX . "dvfilter_option oo LEFT JOIN " . DB_PREFIX . "dvfilter_option_to_category oo2c ON(oo.option_id = oo2c.option_id) WHERE oo2c.category_id = '" . (int) $category_id . "' AND oo.`keyword` = '" . $this->db->escape($keyword) . "' LIMIT 1");
                    }

                    // Get Option by ID
                    if (!$query->num_rows && isID($keyword)) {
                        if (isset($this->request->get['manufacturer_id'])) {
                            $query = $this->db->query("SELECT option_id FROM " . DB_PREFIX . "dvfilter_option_to_category WHERE option_id = '" . (int) $keyword . "'");
                        } else {
                            $query = $this->db->query("SELECT option_id FROM " . DB_PREFIX . "dvfilter_option_to_category WHERE category_id = '" . (int) $category_id . "' AND option_id = '" . (int) $keyword . "'");
                        }
                    }

                    if ($query->num_rows) {
                        $option_id = $query->row['option_id'];
                    }

                    $this->cache->set('dvfilter.decode.option.' . md5($keyword) . '.' . (int) $category_id, (int) $option_id);
                }

                if ($option_id) {
                    $params[$option_id] = array();

                    $current = $option_id;

                    unset($keywords[$key]);
                }
            }
        }

        # Get parent categories keywords
        $query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE parent_id = '0'");

        $category_str = '';

        foreach ($query->rows as $id) {
            $category_str .= "'category_id=" . $id['category_id'] . "', ";
        }

        $category_str = substr($category_str, 0, -2);

        $query = $this->db->query("SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query IN ($category_str)");

        foreach ($query->rows as $row) {
            $parent_category_keywords[] = $row['keyword'];
        }
        # END get parent categories keywords

        $search_category = false;

      

        // Category
        foreach ($keywords as $key => $keyword) {

            if ($keyword == 'category') {
                unset($keywords[$key]);
                $search_category = true;
                continue;
            }

            $category_id = $this->cache->get('dvfilter.decode.category' . md5($keyword));

            if (false === $category_id) {
                $query = $this->db->query("SELECT REPLACE(`query`, 'category_id=', '') AS category_id FROM " . DB_PREFIX . "url_alias WHERE `query` LIKE 'category_id=%' AND LCASE(`keyword`) = '" . $this->db->escape(utf8_strtolower($keyword)) . "' LIMIT 1");

                if (!$query->num_rows && isID($keyword)) {
                    $query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE category_id = '" . (int) $keyword . "'");
                }

                if (isset($this->request->get['manufacturer_id'])) {
                    if ($query->num_rows) {
                        $category_id = $query->row['category_id'];
                    }
                } else {
                    if ($query->num_rows && !in_array($keyword, $parent_category_keywords)) {
                        $category_id = $query->row['category_id'];
                    }
                }

                $this->cache->set('dvfilter.decode.category.' . md5($keyword), (int) $category_id);
            }

            if ($category_id && $search_category) {

                if (!isset($params['c'])) {
                    $params['c'] = array();
                }

                $params['c'][$category_id] = $category_id;
                unset($keywords[$key]);
            }
        }

        # Manufacturers
        foreach ($keywords as $key => $keyword) {

            $manufacturer_id = $this->cache->get('dvfilter.decode.manufacturer.' . md5($keyword));

            if (false === $manufacturer_id) {
                $query = $this->db->query("SELECT REPLACE(`query`, 'manufacturer_id=', '') AS manufacturer_id FROM " . DB_PREFIX . "url_alias WHERE `query` LIKE 'manufacturer_id=%' AND LCASE(`keyword`) = '" . $this->db->escape(utf8_strtolower($keyword)) . "' LIMIT 1");

                if (!$query->num_rows && isID($keyword)) {
                    $query = $this->db->query("SELECT manufacturer_id FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int) $keyword . "'");
                }

                if ($query->num_rows) {
                    $manufacturer_id = $query->row['manufacturer_id'];
                }

                $this->cache->set('dvfilter.decode.manufacturer.' . md5($keyword), (int) $manufacturer_id);
            }

            if ($manufacturer_id) {
                if (!isset($params['m'])) {
                    $params['m'] = array();
                }

                $params['m'][$manufacturer_id] = $manufacturer_id;

                unset($keywords[$key]);
            }
        }


        if ($this->page_info) {
            $path = $this->model_catalog_dvfilter->getCategorySeoPathByCategoryId($this->page_info['category_id']);

            if ($path) {
                $parts = explode('/', $path);

                foreach (array_reverse($parts) as $part) {
                    array_unshift($keywords, $part);
                }
            }
        }

        if ($keywords) {
            $this->request->get['_route_'] = implode('_', $keywords);
        } else if (isset($this->request->get['manufacturer_id'])) {
            $this->request->get['_route_'] = $this->model_catalog_dvfilter->getManufacturerSeoPathByManufacturerId($this->request->get['manufacturer_id']);
        }

        if ($params) {

            $this->request->get['filter_dvfilter'] = encodeParamsToString($params, $this->config);

            if (isset($this->request->get['route'])) {
                unset($this->request->get['route']);
            } else {
                if ($this->manufacturer_id) {
                    $this->request->get['route'] = 'product/manufacturer/info';
                } elseif ($this->path) {
                    $this->request->get['route'] = 'product/category';
                }
            }
        }
    }

    public function rewrite($link) {
        $url_info = parse_url(str_replace('&amp;', '&', $link));

        if (!isset($url_info['query'])) {
            return $link;
        }

        $data = array();

        parse_str($url_info['query'], $data);

        if (!isset($data['filter_dvfilter'])) {
            return $link;
        }

        $params = decodeParamsFromString($data['filter_dvfilter'], $this->config);

        unset($data['filter_dvfilter']);

        $path = '';

       

        foreach ($params as $option_id => $values) {

            if ($option_id == 'p') {
                $path .= '_price';
            } else if ($option_id == 's') {
                $path .= '_sklad';
            } else if ($option_id == 'c') {
                $path .= '_category';
            } else if ($option_id != 'm' and $option_id != 'c') {
                if (isset($this->option_keywords[$option_id])) {
                    $path .= '_' . $this->option_keywords[$option_id];
                } else {
                    $path .= '_' . $option_id;
                }
            }

            foreach ($values as $value_id) {
                if ((isset($this->request->get['manufacturer_id']) && $option_id == "m")) {
                    continue;
                }

              if (isset($this->value_keywords[$option_id . '-' . $value_id])) {
                    $path .= '_' . $this->value_keywords[$option_id . '-' . $value_id];
                } else {
                    $path .= '_' . $value_id;
                }
            }
        }

        if ($path) {
            $page_path = ltrim($path, '/');
            $page_path=ltrim($page_path, '_');
            
            if (isset($this->pages[md5($this->category_id . $page_path)])) {
                $page_info = $this->model_catalog_dvfilter->getPage($this->category_id, $page_path);

                if ($page_info && $page_info['keyword']) {
                    $path = '_' . $page_info['keyword'];
                }
            }
        }

        $rewrite = $url_info['scheme'] . '://' . $url_info['host'];

        if (isset($url_info['port'])) {
            $rewrite .= ':' . $url_info['port'];
        }

       

        if (isset($url_info['path'])) {
            $rewrite .= str_replace('/index.php', '', $url_info['path']);
        } else {
            $rewrite .= '/index.php';
        }

        if ($path) {
            $rewrite = rtrim($rewrite, '/') . $path;

            if ($this->config->has('config_seo_url_type') && $this->config->get('config_seo_url_type') == 'seo_pro') {
                $rewrite .= '/';
            }
        }

        $query = '';

        if ($data) {
            foreach ($data as $key => $value) {
                $query .= '&' . rawurlencode((string) $key) . '=' . rawurlencode((is_array($value) ? http_build_query($value) : (string) $value));
            }

            if ($query) {
                $query = '?' . str_replace('&', '&amp;', trim($query, '&'));
            }
        }

        $rewrite .= $query;




        return $rewrite;
    }

    public function getPageInfo() {
        return $this->page_info;
    }

    public function getSelectedsFilterTitle() {
        $filter_title = '';

        $selecteds = $this->getSelectedOptions();

        foreach ($selecteds as $option_id => $option) {
            if ($filter_title) {
                $filter_title .= ', ';
            }

            if ($option_id == 'm') {
                $values_name = '';

                foreach ($option['values'] as $value) {
                    if ($values_name) {
                        $values_name .= ', ';
                    }

                    $values_name .= $value['name'];
                }

                if ($values_name) {
                    $filter_title .= $values_name;
                }
            } else if ($option_id == 'c') {
                $values_name = '';

                foreach ($option['values'] as $value) {
                    if ($values_name) {
                        $values_name .= ', ';
                    }

                    $values_name .= $value['name'];
                }

                if ($values_name) {
                    $filter_title .= $values_name;
                }
            } else if ($option_id == 'p') {
                $price = array_shift($option['values']);

                $filter_title .= $price['name'];
            } else if ($option_id == 's') {
                if ($this->config->get('dvfilter_stock_status_method') == 'quantity') {
                    $stock_status = array_shift($option['values']);

                    if ($stock_status['name'] == 'in') {
                        $filter_title .= 'в наличии';
                    } elseif ($stock_status['name'] == 'out') {
                        $filter_title .= 'нет в наличии';
                    }
                } else {
                    $values_name = '';

                    foreach ($option['values'] as $value) {
                        if ($values_name) {
                            $values_name .= ', ';
                        }

                        $values_name .= $value['name'];
                    }

                    if ($values_name) {
                        $filter_title .= $values_name;
                    }
                }
            } else {
                $values_name = '';

                foreach ($option['values'] as $value) {
                    if ($values_name) {
                        $values_name .= ', ';
                    }

                    $values_name .= $value['name'];
                }

                if ($values_name || $values_name == 0) {
                    $filter_title .= $option['name'] . ' ' . $values_name;
                }
            }
        }

        return $filter_title;
    }

    protected function link($filter_dvfilter = '') {
        $url = '';

        if ($this->path) {
            $url .= '&path=' . (string) $this->path;
        }

        if ($filter_dvfilter) {
            $url .= '&filter_dvfilter=' . (string) $filter_dvfilter;
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . (string) $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . (string) $this->request->get['order'];
        }

        if (isset($this->request->get['limit'])) {
            $url .= '&limit=' . (int) $this->request->get['limit'];
        }

        if (isset($this->request->get['manufacturer_id']) && $this->request->get['manufacturer_id']) {
            return $this->url->link('product/manufacturer/info', '&manufacturer_id=' . $this->request->get['manufacturer_id'] . $url);
        }

        return $this->url->link('product/category', $url);
    }

    public function callback() {
        if (!$this->path && !isset($this->request->get['manufacturer_id'])) {
            return;
        }

        $this->load->language('extension/module/dvfilter');

        $json = array();

        $filter_data = array(
            'filter_category_id' => $this->category_id,
            'filter_manufacturer_id' => $this->manufacturer_id,
            'filter_dvfilter' => $this->params
        );

        $total_products = $this->model_catalog_product->getTotalProducts($filter_data);

        $json['total'] = $total_products;
        $json['text_total'] = declOfNum($total_products, array(
            $this->language->get('button_show_total_1'),
            $this->language->get('button_show_total_2'),
            $this->language->get('button_show_total_3')
        ));

        $json['values'] = array();

        $options = $this->getDVFilterOptions();

        foreach ($options as $option) {
            if ($option['type'] == 'slide' || $option['type'] == 'slide_dual') {
                continue;
            }

            if ($option['type'] == 'select' || $option['type'] == 'radio') {
                $params = $this->cancelOptionParams($option['option_id']);

                $json['values']['cancel-' . $option['option_id']] = array(
                    't' => 1,
                    'h' => $this->link($params),
                    's' => false
                );
            }

            foreach ($option['values'] as $value) {
                $json['values'][$value['id']] = array(
                    't' => $value['count'],
                    'h' => $value['href'],
                    's' => isset($this->options_get[$option['option_id']][$value['value_id']])
                );
            }
        }

        $json['href'] = str_replace('&amp;', '&', $this->link($this->params));

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    
      public function getParentCategory( $category_id )
    {
        $query = $this->db->query("SELECT c.parent_id AS category_id, cd.name FROM " . DB_PREFIX . "category c"
            . " LEFT JOIN " . DB_PREFIX . "category_description cd ON c.parent_id = cd.category_id"
            . " WHERE c.category_id = '" . (int)$category_id . "'"
            . " AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->row;
    }
    
    public function detectmobile(){
      
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $useragents = array (
            "iPhone",
            "iPod",
            "Android",
            "blackberry9500",
            "blackberry9530",
            "blackberry9520",
            "blackberry9550",
            "blackberry9800",
            "webOS"
        );
        $result = false;
        foreach ( $useragents as $useragent ) {
            if (preg_match("/".$useragent."/i",$agent)){
                $result = true;
            }
        }
        return $result;
    }
}
