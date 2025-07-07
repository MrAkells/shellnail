<?php
class ModelExtensionModuleDelovod extends Model
{

	public function updateOrderDelovodId($order_id, $id)
	{
		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET `delovod_order_id` = '" . $id . "' WHERE `order_id` = '" . (int) $order_id . "'");
	}

	public function getOrderProducts($order_id)
	{
		$product_query = $this->db->query("SELECT op.order_product_id, op.product_id, op.quantity,op.price,op.total,p.isbn,p.mpn,p.price as base_price FROM " . DB_PREFIX . "order_product op
					LEFT JOIN " . DB_PREFIX . "product p ON (op.product_id = p.product_id)
					WHERE order_id = '" . (int) $order_id . "'");

		return $product_query->rows;
	}

	public function getOrder($delovod_order_id)
	{
		$order_query = $this->db->query("SELECT *, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = o.language_id) AS order_status FROM `" . DB_PREFIX . "order` o WHERE o.delovod_order_id = '" . $delovod_order_id . "'");

		if ($order_query->num_rows) {
			return array(
				'order_id' 			=> $order_query->row['order_id'],
				'customer_id' 		=> $order_query->row['customer_id'],
				'delovod_order_id' 	=> $order_query->row['delovod_order_id'],
				'total'				=> $order_query->row['total'],
				'shipping_code'	=> $order_query->row['shipping_code'],
				'order_status_id'   => $order_query->row['order_status_id'],
				'order_status'      => $order_query->row['order_status']
			);
		}

		return false;
	}

	public function getOrdersForSync()
	{
		$order = [];
		$query = $this->db->query("SELECT order_id, delovod_order_id, customer_id, total, shipping_code, order_status_id FROM `" . DB_PREFIX . "order` WHERE `order_status_id` in (1,2,3,11) AND `delovod_order_id` <> ''");

		foreach ($query->rows as $result) {
			$order[] = [
				'order_id' 			=> $result['order_id'],
				'delovod_order_id' 	=> $result['delovod_order_id'],
				'customer_id' 		=> $result['customer_id'],
				'total'				=> $result['total'],
				'shipping_code'	=> $result['shipping_code'],
				'order_status_id'   => $result['order_status_id']
			];
		}

		return $order;
	}

	public function getOrderTotal($order_id)
	{
		$query = $this->db->query("SELECT code, value FROM `" . DB_PREFIX . "order_total` o WHERE order_id = '" . (int) $order_id . "'");
		$totals = [];
		foreach ($query->rows as $result) {
			$totals[$result['code']] = $result['value'];
		}

		return $totals;
	}

	/**
	 * get order sub_total by products total
	 * @method getOrderSubTotal
	 * @param  $id
	 * @return float order sub_total
	 */
	public function getOrderSubTotal($id)
	{
		$query = $this->db->query("SELECT sum(`total`) as sub_total FROM `" . DB_PREFIX . "order_product` WHERE `order_id` = " . $id);
		return (isset($query->row['sub_total']) ? $query->row['sub_total'] : 0);
	}

	/**
	 * get order_status_id by name
	 * @method getOrderStatusIdByName
	 * @param  $name
	 * @return int order_status_id
	 */
	public function getOrderStatusIdByName($name)
	{
		$query = $this->db->query("SELECT order_status_id FROM `" . DB_PREFIX . "order_status` WHERE name = '" . $name . "'");
		return (isset($query->row['order_status_id']) ? (int) $query->row['order_status_id'] : false);
	}

	/**
	 * get product_id by isbn
	 * @method getProductIdByIsbn
	 * @param  $isbn
	 * @return int product_id
	 */
	public function getProductIdByIsbn($isbn)
	{
		$query = $this->db->query("SELECT product_id, model FROM `" . DB_PREFIX . "product` WHERE isbn = '" . $isbn . "'");
		return (isset($query->row['product_id']) ? ['product_id' => $query->row['product_id'], 'model' => $query->row['model']] : false);
	}

	public function addProductToOrder($order_id, $product, $name, $price, $quantity, $total)
	{
		$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int) $order_id .
			"', product_id = '" . (int) $product['product_id'] .
			"', name = '" . $this->db->escape($name) .
			"', model = '" . $this->db->escape($product['model']) .
			"', quantity = '" . (int) $quantity .
			"', price = '" . (float) $price .
			"', total = '" . (float) $total . "'");
	}

	public function updateProductToOrder($order_product_id, $price, $quantity, $total)
	{
		$this->db->query("UPDATE `" . DB_PREFIX . "order_product` SET `quantity` = '" . (int) $quantity .
			"', `price` = '" . (float) $price .
			"', `total` = '" . (float) $total .
			"' WHERE `order_product_id` = '" . (int) $order_product_id . "'");
	}

	public function deleteProductsFromOrder($order_products)
	{
		foreach ($order_products as $product) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "order_product` WHERE `order_product_id` = '" . (int) $product['order_product_id'] . "'");
		}
	}

	public function updateOrder($order_id, $order_status_id, $total)
	{
		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET `order_status_id` = '" . (int) $order_status_id . "', `total` = '" . (float) $total . "' WHERE `order_id` = '" . (int) $order_id . "'");
	}

	public function updateOrderTotals($order_id, $totals)
	{
		foreach ($totals as $key => $value) {
			$this->db->query("UPDATE `" . DB_PREFIX . "order_total` SET `value` = '" . (float) $value . "' WHERE `order_id` = '" . (int) $order_id . "' AND code = '" . $key . "'");
		}
	}

	public function updateBalance($data)
	{

		// auto sms code
		$waiters = [];
		if($this->url->link('common/home') === 'https://shellnail.com.ua/'){
			$this->sms_log =  new Log('sms.log');
			$sms_config = new Config();
			$sms_config->load('sms');
			$this->sms_config = $sms_config;
	
			$query_sms = $this->db->query("SELECT sms.product_id, sms.name as user_name, sms.phone as user_phone, pd.name as product_name, isbn FROM " . DB_PREFIX . "product p JOIN sms ON (p.product_id=sms.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON(p.product_id=pd.product_id) WHERE pd.language_id = '3'");
	
			foreach ($query_sms->rows as $row) {
				if (isset($waiters[$row['isbn']])) {
					$waiters[$row['isbn']][] = $row;
				} else {
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

	public function notify($rows)
	{

		$product_id = isset($rows[0]['product_id']) ? $rows[0]['product_id'] : false;
		if ($product_id) {

			foreach ($rows as $row) {
				$this->sendSms($row);
			}

			$this->db->query("DELETE FROM sms WHERE product_id = '" . (int) $product_id . "'");
		}
	}

	/**
	 * Is use Coupon in order
	 * @method isUseCoupon
	 * @param  $order_id
	 * @return boolean
	 */
	public function isUseCoupon($order_id)
	{
		$query = $this->db->query("SELECT coupon_id FROM `" . DB_PREFIX . "coupon_history` WHERE order_id = " . (int)$order_id);
		return ($query->rows ? true : false);
	}

	public function sendSms($data)
	{
		$username = $this->sms_config->get('sms_username'); //'380508448537';    
		$token = $this->sms_config->get('sms_token');  //'VKpJeF81HzujOj9';       
		$from = $this->sms_config->get('sms_from');  //'shellnail';  

		$to = '38' . $data['user_phone'];
		$name = $data['product_name'];

		$link = $this->url->link('product/product', '&product_id=' . $data['product_id']);

		if($this->config->get('config_language_id') != 3) {
			$base_url = $this->url->link('common/home', '', 'SSL');
			$link = str_replace($base_url, $base_url. 'ua/', $link);
		}

		$message = "Товар $name, який Ви очікуєте з'явився в наявності $link";
		$text = iconv('utf-8', 'windows-1251', $message);
		$text = urlencode($text);

		$ch = curl_init();
		$url = "https://gate.smsclub.mobi/token/?username=$username&token=$token&from=$from&to=$to&text=$text";
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result = curl_exec($ch);
		$this->sms_log->write('SMS was sended to user ' . $data['user_name'] . ' on number ' . $data['user_phone'] . '. Result = ' . $result);
	}

	/**
     * Получить товары с изменённой ценой за последние 24 часа (price_modified)
     * Только если price_modified не null и не старше суток
     * Выбирается актуальная цена (акционная, если действует, иначе обычная)
     */
    public function getAllProductsForPriceUpdate($page = 1, $limit = 100)
    {
        $page = max(1, (int)$page);
        $offset = ($page - 1) * $limit;

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
                AND p.price_modified IS NOT NULL
                AND p.price_modified >= NOW() - INTERVAL 1 DAY
            GROUP BY p.product_id
            ORDER BY p.product_id ASC
            LIMIT " . (int)$offset . ", " . (int)$limit;

        $query = $this->db->query($sql);

        return $query->rows;
    }

    /**
     * Получить общее количество товаров с изменённой ценой за последние 24 часа (price_modified)
     * Только если price_modified не null и не старше суток
     */
    public function getAllProductsTotalForPriceUpdate()
    {
        $yesterday = date('Y-m-d H:i:s', strtotime('-24 hours'));

        $sql = "
            SELECT COUNT(DISTINCT p.product_id) AS total
            FROM " . DB_PREFIX . "product p
            WHERE 
                p.isbn != ''
                AND p.price_modified IS NOT NULL
                AND p.price_modified >= '" . $this->db->escape($yesterday) . "'
        ";

        $query = $this->db->query($sql);
        return (int)$query->row['total'];
    }
}
