<?php
class ModelCatalogSdSitemap extends Model {
	public function getInformation($information_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id) WHERE i.information_id = '" . (int)$information_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1'");

		return $query->row;
	}
	public function add($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "sitemap` SET `name` = '" . $this->db->escape($data['name']) . "', `href` = '" . $data['href'] . "', `level` = '" . (int)$data['level'] . "'");
	}
	public function addRows($data) {
		$values = '';
		foreach ($data as $value) {
			$values .= "('" . $this->db->escape($value['name']) . "','" . $value['href'] . "', " . (int)$value['level'] . "),";
		}
		$query= "INSERT INTO `" . DB_PREFIX . "sitemap` ( `name`, `href`,`level`) VALUES " . mb_substr($values, 0, -1);
		$this->db->query($query);
	}
	public function init() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "sitemap`");
		//$this->editSetting('sd_sitemap',['sd_sitemap_id'=>0,'sd_sitemap_status'=>0]);
	}
	public function get($data) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "sitemap` ";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getTotal(){
		$sql = "SELECT COUNT(DISTINCT id) AS total FROM `" . DB_PREFIX . "sitemap`";
		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function editSetting($code, $data, $store_id = 0) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($code) . "'");

		foreach ($data as $key => $value) {
			if (substr($key, 0, strlen($code)) == $code) {
				if (!is_array($value)) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(json_encode($value, true)) . "', serialized = '1'");
				}
			}
		}
	}
}