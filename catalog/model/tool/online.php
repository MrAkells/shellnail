<?php
class ModelToolOnline extends Model {
	public function addOnline($ip, $customer_id, $url, $referer, $promo_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "customer_online` WHERE date_added < '" . date('Y-m-d H:i:s', strtotime('-1 hour')) . "'");

		$this->db->query("REPLACE INTO `" . DB_PREFIX . "customer_online` SET `ip` = '" . $this->db->escape($ip) . "', `customer_id` = '" . (int)$customer_id . "', `url` = '" . $this->db->escape($url) . "', `referer` = '" . $this->db->escape($referer) . "', `date_added` = '" . $this->db->escape(date('Y-m-d H:i:s')) . "', promo_id='".(int)$promo_id."'");
	}
        
        public function getTotalCustomersOnline($promo_id=-1) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "customer_online` co LEFT JOIN " . DB_PREFIX . "customer c ON (co.customer_id = c.customer_id) WHERE promo_id='".(int)$promo_id."'";
        
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
        
}
