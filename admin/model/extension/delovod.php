<?php
class ModelExtensionDelovod extends Model {
	public function editIsbn($id, $isbn) {
		$this->db->query("UPDATE `" . DB_PREFIX . "product` SET `sku` = '" . $this->db->escape($id) . "', `isbn` = '" . $this->db->escape($isbn) . "' WHERE `product_id` = '" . (int)$id . "'");
	}

	public function getProductsByCategoryId($category_id, $isbn = true, $page = 0 ) {
        $sql = "SELECT p.product_id, pd.name FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id. "'" . ($isbn?" AND p.isbn = ''" :"") . " ORDER BY pd.name ASC";
        if($page) $sql .= " LIMIT " . (int)($page - 1)*50 . ", 50";
		$query = $this->db->query($sql);

		return $query->rows;
	}

    public function getProductsPriceByCategoryId($category_id, $isbn = true, $page = 0 ) {
        $sql = "SELECT p.product_id, p.price, p.isbn FROM " . DB_PREFIX . "product p  LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE  p2c.category_id = '" . (int)$category_id. "' ORDER BY p.product_id ASC";
        if($page) $sql .= " LIMIT " . (int)($page - 1)*50 . ", 50";
		$query = $this->db->query($sql);

		return $query->rows;
	}

    /**
     * Получить товары с изменённой ценой за последние 24 часа или истекшей акцией
     * Теперь учитывается поле price_modified и выбирается актуальная цена (акционная, если действует, иначе обычная)
     */
    public function getAllProductsForPriceUpdate($page = 1, $limit = 100)
    {
        $page = max(1, (int)$page);
        $offset = ($page - 1) * $limit;

        // Выбираем товары, у которых была изменена цена за последние сутки (price_modified)
        // или у которых началась/закончилась акция за последние сутки, или акция истекла
        $sql = "
            SELECT 
                p.product_id, 
                p.isbn, 
                CASE 
                    WHEN MIN(ps.price) IS NOT NULL AND MIN(ps.date_start) <= NOW() AND MIN(ps.date_end) > NOW() 
                        THEN MIN(ps.price)
                    ELSE p.price
                END AS price
            FROM " . DB_PREFIX . "product p
            LEFT JOIN " . DB_PREFIX . "product_special ps 
                ON ps.product_id = p.product_id AND ps.customer_group_id = 1
            WHERE 
                p.isbn != '' 
                AND (
                    p.price_modified >= NOW() - INTERVAL 1 DAY
                    OR ps.date_start >= NOW() - INTERVAL 1 DAY
                    OR ps.date_end >= NOW() - INTERVAL 1 DAY
                    OR (ps.date_end IS NOT NULL AND ps.date_end < NOW())
                )
            GROUP BY p.product_id
            ORDER BY p.product_id ASC
            LIMIT " . (int)$offset . ", " . (int)$limit;

        $query = $this->db->query($sql);

        return $query->rows;
    }

    /**
     * Проверка, активна ли акционная цена
     */
    private function isSpecialPriceActive($row)
    {
        $now = strtotime(date('Y-m-d'));
        $start = strtotime($row['date_start']);
        $end = strtotime($row['date_end']);

        return (!$row['date_start'] || $start <= $now) &&
            (!$row['date_end'] || $end >= $now);
    }

    /**
     * Получить общее количество товаров с изменённой ценой за последние 24 часа или истекшей акцией
     */
    public function getAllProductsTotalForPriceUpdate()
    {
        $yesterday = date('Y-m-d H:i:s', strtotime('-24 hours'));

        $sql = "
            SELECT COUNT(DISTINCT p.product_id) AS total
            FROM " . DB_PREFIX . "product p
            LEFT JOIN " . DB_PREFIX . "product_special ps ON ps.product_id = p.product_id AND ps.customer_group_id = 1
            WHERE 
                p.isbn != ''
                AND (
                    p.date_modified >= '" . $this->db->escape($yesterday) . "' 
                    OR ps.date_start >= '" . $this->db->escape($yesterday) . "' 
                    OR ps.date_end >= '" . $this->db->escape($yesterday) . "'
                )
        ";

        $query = $this->db->query($sql);
        return (int)$query->row['total'];
    }


    

	public function getProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT p.price, p.weight, pd.name, pdu.name as name_ua,p.sku, p.isbn, p.ean, p2c.category_id, cd.name as category, md.name as manufacturer  FROM " . DB_PREFIX . "product p
					LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "')
                    LEFT JOIN " . DB_PREFIX . "product_description pdu ON (p.product_id = pdu.product_id AND pdu.language_id = 3)
					LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (p.manufacturer_id = md.manufacturer_id AND md.language_id = '" . (int)$this->config->get('config_language_id') . "')
					LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id AND p2c.main_category = 1)
					LEFT JOIN " . DB_PREFIX . "category_description cd ON (p2c.category_id = cd.category_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "')
					WHERE p.product_id = '" . (int)$product_id .  "'");

		return $query->row;
	}

    
    // Получить пачку товаров для выгрузки штрихкодов
    public function getProductsForBarcodeSync($category_id = 0, $page = 1, $limit = 50) {
        $start = ($page - 1) * $limit;
        $sql = "SELECT p.product_id, p.isbn, p.ean 
                FROM " . DB_PREFIX . "product p 
                LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) 
                WHERE p.isbn != '' 
                AND p.ean != '' 
                AND p.ean_synced = 0";
        if ($category_id) {
            $sql .= " AND p2c.category_id = '" . (int)$category_id . "'";
        }
        $sql .= " ORDER BY p.product_id ASC LIMIT " . (int)$start . ", " . (int)$limit;
        $query = $this->db->query($sql);
        return $query->rows;
    }


    // Получить общее количество товаров для выгрузки штрихкодов
    public function getTotalProductsForBarcodeSync($category_id = 0) {
        $sql = "SELECT COUNT(*) AS total
                FROM " . DB_PREFIX . "product p 
                LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) 
                WHERE p.isbn != '' 
                AND p.ean != '' 
                AND p.ean_synced = 0";
        if ($category_id) {
            $sql .= " AND p2c.category_id = '" . (int)$category_id . "'";
        }
        $query = $this->db->query($sql);
        return (int)$query->row['total'];
    }

    public function markEanSynced($product_id) {
        $this->db->query("UPDATE `" . DB_PREFIX . "product` SET `ean_synced` = 1 WHERE `product_id` = '" . (int)$product_id . "'");
    }


	public function updateBalance($data) {
        // auto sms code
        $waiters = [];
        if($this->url->link('common/home') === 'https://shellnail.com.ua/'){
            $this->sms_log =  new Log('sms.log');
            $sms_config = new Config();
            $sms_config->load('sms');
            $this->sms_config = $sms_config;
            $this->makeUrl();
            
            $query_sms=$this->db->query("SELECT sms.product_id, sms.name as user_name, sms.phone as user_phone, pd.name as product_name, isbn FROM " . DB_PREFIX . "product p JOIN sms ON (p.product_id=sms.product_id) LEFT JOIN ".DB_PREFIX."product_description pd ON(p.product_id=pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

            foreach($query_sms as $row){
                if(isset($waiters[$row['isbn']])){
                    $waiters[$row['isbn']][] = $row;
                }else{
                    $waiters[$row['isbn']] = array($row);
                }
            }    
        }       
        // end of auto sms

		// if return need sum qty (2 rows)
		$goods = [];
		foreach ($data as $good) {
			if(isset($goods[$good->id] )) {
				$goods[$good->id] += $good->qty;
			} else {
				$goods[$good->id] = $good->qty;
			}
		}

		if($goods) {
			$i = 0;
			foreach ($goods as $key => $qty) {
				++$i;
	
				// auto sms code
				if (isset($waiters[$key]) && (int) $qty > 0) {
					$this->notify($waiters[$key]);
				}
				// end of auto sms            

				$this->db->query("UPDATE `" . DB_PREFIX . "product` SET `quantity` = '" . (int) $qty . "', date_modified = NOW() WHERE `isbn` = '" . $key . "'");
			}
			if ($i) {
				$this->db->query("UPDATE `" . DB_PREFIX . "product` SET `quantity` = '0',  date_modified = NOW() WHERE `isbn` <> '' AND `mpn` = '' AND `quantity` > 0 AND `date_modified` < (NOW() - INTERVAL 50 MINUTE)");
			}
		}
	
    }
        
    public function notify($rows) {

        $product_id = isset($rows[0]['product_id']) ? $rows[0]['product_id'] : false;
        if ($product_id) {

            foreach ($rows as $row) {
                $this->sendSms($row);
            }

            $this->db->query("DELETE FROM sms WHERE product_id = '" . (int) $product_id . "'");
        }
    }

    public function sendSms($data) {

        $username = $this->sms_config->get('sms_username'); //'380508448537';    
        $token = $this->sms_config->get('sms_token');  //'VKpJeF81HzujOj9';       
        $from = $this->sms_config->get('sms_from');  //'shellnail';  

        $to = '38' . $data['user_phone'];
        $name = $data['product_name'];

        $link = HTTPS_CATALOG.$this->url->link('product/product', '&product_id=' . $data['product_id']);

        $message = "Товар $name, который Вы ожидаете появился в наличии $link";
        $text = iconv('utf-8', 'windows-1251', $message);
        $text = urlencode($text);

        $ch = curl_init();
        $url = "https://gate.smsclub.mobi/token/?username=$username&token=$token&from=$from&to=$to&text=$text";
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        $this->sms_log->write('SMS was sended to user ' . $data['user_name'] . ' on number ' . $data['user_phone'] . '. Result = ' . $result);
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

