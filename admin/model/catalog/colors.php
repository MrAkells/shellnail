<?php
class ModelCatalogColors extends Model {
	public function addColor($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "colors SET name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "'");

		$color_id = $this->db->getLastId();

		return $color_id;
	}

	public function editColor($color_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "colors SET name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "' WHERE color_id = '" . (int)$color_id . "'");
	}

	public function deleteColor($color_id) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "colors WHERE color_id = '" . (int)$color_id . "'");
	}

	public function getColor($color_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "colors WHERE color_id = '" . (int)$color_id . "'");

		return $query->row;
	}

	public function getColors($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "colors ";


		$sort_data = array(
			'name',
			'code'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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