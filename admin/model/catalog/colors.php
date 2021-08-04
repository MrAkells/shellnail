<?php
class ModelCatalogColors extends Model {
	public function addColor($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "colors SET code = '" . $this->db->escape($data['code']) . "'");

		
		$color_id = $this->db->getLastId();

        foreach ($data['color_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "colors_description SET color_id = '" . (int)$color_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		return $color_id;
	}

	public function editColor($color_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "colors SET code = '" . $this->db->escape($data['code']) . "' WHERE color_id = '" . (int)$color_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "colors_description WHERE color_id = '" . (int)$color_id . "'");
		foreach ($data['color_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "colors_description SET color_id = '" . (int)$color_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
	}

	public function deleteColor($color_id) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "colors_description WHERE color_id = '" . (int)$color_id . "'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "colors WHERE color_id = '" . (int)$color_id . "'");
	
	}

	public function getColor($color_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "colors WHERE color_id = '" . (int)$color_id . "'");

		return $query->row;
	}

	public function getColorDescription($color_id) {
		$color_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "colors_description WHERE color_id = '" . (int)$color_id . "'");

		foreach ($query->rows as $result) {
			$color_description_data[$result['language_id']] = array(
				'name'	=> $result['name']
			);
		}

		return $color_description_data;
	}
	
	public function getColors($data = array()) {
		$sql = "SELECT c.color_id, c.code, cd.name FROM " . DB_PREFIX . "colors c LEFT JOIN ". DB_PREFIX ."colors_description cd ON (c.color_id=cd.color_id AND cd.language_id='" . (int)$this->config->get('config_language_id') . "')";


		$sort_data = array(
			'cd.name',
			'code'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY cd.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

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


	public function getTotalColors() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "colors");

		return $query->row['total'];
	}
        
        public function getEligibleColors($part) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "colors WHERE name LIKE '%".$part."%'");

		return $query->rows;
	}
}