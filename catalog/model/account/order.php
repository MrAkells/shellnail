<?php
class ModelAccountOrder extends Model {
	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND order_status_id > '0'");

		if ($order_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");

			if ($country_query->num_rows) {
				$payment_iso_code_2 = $country_query->row['iso_code_2'];
				$payment_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['code'];
			} else {
				$payment_zone_code = '';
			}

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");

			if ($country_query->num_rows) {
				$shipping_iso_code_2 = $country_query->row['iso_code_2'];
				$shipping_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$shipping_zone_code = $zone_query->row['code'];
			} else {
				$shipping_zone_code = '';
			}

                     
                        
			return array(
				'order_id'                => $order_query->row['order_id'],
				'invoice_no'              => $order_query->row['invoice_no'],
				'invoice_prefix'          => $order_query->row['invoice_prefix'],
				'store_id'                => $order_query->row['store_id'],
				'store_name'              => $order_query->row['store_name'],
				'store_url'               => $order_query->row['store_url'],
				'customer_id'             => $order_query->row['customer_id'],
				'firstname'               => $order_query->row['firstname'],
				'lastname'                => $order_query->row['lastname'],
				'telephone'               => $order_query->row['telephone'],
				'fax'                     => $order_query->row['fax'],
				'email'                   => $order_query->row['email'],
				'payment_firstname'       => $order_query->row['payment_firstname'],
				'payment_lastname'        => $order_query->row['payment_lastname'],
				'payment_company'         => $order_query->row['payment_company'],
				'payment_address_1'       => $order_query->row['payment_address_1'],
				'payment_address_2'       => $order_query->row['payment_address_2'],
				'payment_postcode'        => $order_query->row['payment_postcode'],
				'payment_city'            => $order_query->row['payment_city'],
				'payment_zone_id'         => $order_query->row['payment_zone_id'],
				'payment_zone'            => $order_query->row['payment_zone'],
				'payment_zone_code'       => $payment_zone_code,
				'payment_country_id'      => $order_query->row['payment_country_id'],
				'payment_country'         => $order_query->row['payment_country'],
				'payment_iso_code_2'      => $payment_iso_code_2,
				'payment_iso_code_3'      => $payment_iso_code_3,
				'payment_address_format'  => $order_query->row['payment_address_format'],
				'payment_method'          => $order_query->row['payment_method'],
				'shipping_firstname'      => $order_query->row['shipping_firstname'],
				'shipping_lastname'       => $order_query->row['shipping_lastname'],
				'shipping_company'        => $order_query->row['shipping_company'],
				'shipping_address_1'      => $order_query->row['shipping_address_1'],
				'shipping_address_2'      => $order_query->row['shipping_address_2'],
				'shipping_postcode'       => $order_query->row['shipping_postcode'],
				'shipping_city'           => $order_query->row['shipping_city'],
				'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
				'shipping_zone'           => $order_query->row['shipping_zone'],
				'shipping_zone_code'      => $shipping_zone_code,
				'shipping_country_id'     => $order_query->row['shipping_country_id'],
				'shipping_country'        => $order_query->row['shipping_country'],
				'shipping_iso_code_2'     => $shipping_iso_code_2,
				'shipping_iso_code_3'     => $shipping_iso_code_3,
				'shipping_address_format' => $order_query->row['shipping_address_format'],
				'shipping_method'         => $order_query->row['shipping_method'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'order_status_id'         => $order_query->row['order_status_id'],
				'language_id'             => $order_query->row['language_id'],
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'date_modified'           => $order_query->row['date_modified'],
				'date_added'              => $order_query->row['date_added'],
				'ip'                      => $order_query->row['ip'],
                                'custom_field'=>$order_query->row['payment_custom_field']
			);
		} else {
			return false;
		}
	}

	public function getOrders($start = 0, $limit = 20, $condition='') {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 1;
		}

                if($condition=='this_month'){
                    $sql_addon=" AND DATE(date_added) >= '" . $this->db->escape(date('Y') . '-' . date('m')) . "'";
                }else if($condition=='last_month'){
                        $m=(int)date('m');
                        $Y=(int)date('Y');
                        if($m=='1'){
                            $Y1=(int)date('Y')-1;
                            $m1='12';
                            $Y2=$Y;
                            $m2='01';
                        }else{
                            $Y1=$Y;
                            $m1=$m-1;
                            if($m1<10){
                                $m1='0'.$m1;
                            }
                            $Y2=$Y;
                            $m2=$m;
                            if($m2<10){
                                $m2='0'.$m2;
                            }
                
                          }

                    $sql_addon=" AND DATE(date_added) >= '" . $this->db->escape($Y1 . '-' . $m1) . "' AND DATE(date_added) < '" . $this->db->escape($Y2 . '-' . $m2) . "'";
                }else if($condition=='this_year'){
                    $sql_addon=" AND DATE(date_added) >= '" . $this->db->escape(date('Y')) . "'";
                }else if($condition=='last_year'){
                    $Y=(int)date('Y');
                    $Y1=$Y-1;
                    $Y2=$Y;
                    $sql_addon=" AND DATE(date_added) >= '" . $this->db->escape($Y1) . "' AND DATE(date_added) < '" . $this->db->escape($Y2) . "'";
                }else{
                    $sql_addon='';
                }
                
		$query = $this->db->query("SELECT o.order_id, o.firstname, o.lastname, os.name as status, o.date_added, o.total, o.currency_code, o.currency_value FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_status os ON (o.order_status_id = os.order_status_id) WHERE o.customer_id = '" . (int)$this->customer->getId() . "' ".$sql_addon." AND o.order_status_id > '0' AND o.store_id = '" . (int)$this->config->get('config_store_id') . "' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.order_id DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}
        
        public function getTotalOrdersMonth(){
            $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE DATE(date_added) >= '" . $this->db->escape(date('Y') . '-' . date('m')) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND order_status_id > '0' ");
          
            return $query->row['total'];
            //SELECT COUNT(product_id) as total FROM oc_product WHERE DATE(date_modified)>='2018-08' AND   DATE(date_modified)<='2018-09'
        }
        
        public function getTotalOrdersByLastMonth(){
            $m=(int)date('m');
            $Y=(int)date('Y');
            if($m=='1'){
                $Y1=(int)date('Y')-1;
                $m1='12';
                $Y2=$Y;
                $m2='01';
            }else{
                $Y1=$Y;
                $m1=$m-1;
                if($m1<10){
                    $m1='0'.$m1;
                }
                $Y2=$Y;
                $m2=$m;
                if($m2<10){
                    $m2='0'.$m2;
                }
                
            }
            $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE DATE(date_added) >= '" . $this->db->escape($Y1 . '-' . $m1) . "' AND DATE(date_added) < '" . $this->db->escape($Y2 . '-' . $m2) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND order_status_id > '0'");
            return $query->row['total'];
        }
        
        public function getTotalOrdersByYear(){
            $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE DATE(date_added) >= '" . $this->db->escape(date('Y')) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND order_status_id > '0'");
            return $query->row['total'];
        }
        
        public function getTotalOrdersByLastYear(){
            $Y=(int)date('Y');
            $Y1=$Y-1;
            $Y2=$Y;
            
            $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE DATE(date_added) >= '" . $this->db->escape($Y1) . "' AND DATE(date_added) < '" . $this->db->escape($Y2) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND order_status_id > '0'");
            return $query->row['total'];
        }

	public function getOrderProduct($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");

		return $query->row;
	}

	public function getOrderProducts($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderOptions($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");

		return $query->rows;
	}

	public function getOrderVouchers($order_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderTotals($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order");

		return $query->rows;
	}

	public function getOrderHistories($order_id) {
		$query = $this->db->query("SELECT date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order_id . "' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY oh.date_added");

		return $query->rows;
	}

	public function getTotalOrders() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` o WHERE customer_id = '" . (int)$this->customer->getId() . "' AND o.order_status_id > '0' AND o.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		return $query->row['total'];
	}

	public function getTotalOrderProductsByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

		return $query->row['total'];
	}

	public function getTotalOrderVouchersByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = '" . (int)$order_id . "'");

		return $query->row['total'];
	}
        
        public function getTotalCustomerMoney($customer_id){
            $query=$this->db->query("SELECT SUM(value) as sum FROM ".DB_PREFIX."order_total WHERE code='sub_total' AND order_id IN(SELECT o.order_id FROM ".DB_PREFIX."order o WHERE o.customer_id='".(int)$customer_id."' AND o.order_status_id='5')");
            return $query->row["sum"]; 
        }
        
        public function getCustomerSpecial($customer_id){
            $query=$this->db->query("SELECT personal_special as percent FROM loyalty WHERE  customer_id='".(int)$customer_id."'");
            if($query->num_rows){
                return $query->row["percent"]; 
            }else{
                return false; 
            }
        }
        
        public function setCustomerPercent($customer_id, $percent){
            $this->db->query("DELETE FROM loyalty WHERE  customer_id='".(int)$customer_id."'");
            $this->db->query("INSERT INTO loyalty SET customer_id='".(int)$customer_id."', personal_special='".(int)$percent."'");
        }
}