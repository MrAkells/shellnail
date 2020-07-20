<?php
class ModelCatalogVendorcountry extends Model {
	public function getVendorcountry($vendorcountry_id) {
		$query = $this->db->query("SELECT DISTINCT *, md.name AS name FROM " . DB_PREFIX . "vendorcountry m LEFT JOIN " . DB_PREFIX . "vendorcountry_description md ON (m.vendorcountry_id = md.vendorcountry_id) LEFT JOIN " . DB_PREFIX . "vendorcountry_to_store m2s ON (m.vendorcountry_id = m2s.vendorcountry_id) WHERE md.language_id = '" . (int)$this->config->get('config_language_id') . "' && m.vendorcountry_id = '" . (int)$vendorcountry_id . "' AND m2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		return $query->row;
	}

	public function getVendorcountryes($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "vendorcountry m LEFT JOIN " . DB_PREFIX . "vendorcountry_to_store m2s ON (m.vendorcountry_id = m2s.vendorcountry_id) LEFT JOIN " . DB_PREFIX . "vendorcountry_description md ON (m.vendorcountry_id = md.vendorcountry_id) WHERE md.language_id = '" . (int)$this->config->get('config_language_id') . "' && m2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

			$sort_data = array(
				'name',
				'sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY md.name";
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
		} else {
			$vendorcountry_data = $this->cache->get('vendorcountry.' . (int)$this->config->get('config_language_id').'.'. (int)$this->config->get('config_store_id'));

			if (!$vendorcountry_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vendorcountry m LEFT JOIN " . DB_PREFIX . "vendorcountry_to_store m2s ON (m.vendorcountry_id = m2s.vendorcountry_id) LEFT JOIN " . DB_PREFIX . "vendorcountry_description md ON (m.vendorcountry_id = md.vendorcountry_id) WHERE md.language_id = '" . (int)$this->config->get('config_language_id') . "' && m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY md.name");

				$vendorcountry_data = $query->rows;

				$this->cache->set('vendorcountry.' . (int)$this->config->get('config_language_id') . '.'. (int)$this->config->get('config_store_id'), $vendorcountry_data);
			}

			return $vendorcountry_data;
		}
	}
}