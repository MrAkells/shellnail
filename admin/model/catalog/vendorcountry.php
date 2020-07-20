<?php
class ModelCatalogVendorcountry extends Model {
	public function addVendorcountry($data) {

		$this->load->model('localisation/language');
		$language_info = $this->model_localisation_language->getLanguageByCode($this->config->get('config_language'));
    $front_language_id = $language_info['language_id'];
		$data['name'] = $data['vendorcountry_description'][$front_language_id ]['name'];
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "vendorcountry SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$vendorcountry_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "vendorcountry SET image = '" . $this->db->escape($data['image']) . "' WHERE vendorcountry_id = '" . (int)$vendorcountry_id . "'");
		}

		foreach ($data['vendorcountry_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "vendorcountry_description SET vendorcountry_id = '" . (int)$vendorcountry_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['vendorcountry_store'])) {
			foreach ($data['vendorcountry_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "vendorcountry_to_store SET vendorcountry_id = '" . (int)$vendorcountry_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'vendorcountry_id=" . (int)$vendorcountry_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('vendorcountry');

		return $vendorcountry_id;
	}

	public function editVendorcountry($vendorcountry_id, $data) {
		
		$this->load->model('localisation/language');
		$language_info = $this->model_localisation_language->getLanguageByCode($this->config->get('config_language'));
    $front_language_id = $language_info['language_id'];
		$data['name'] = $data['vendorcountry_description'][$front_language_id ]['name'];

		$this->db->query("UPDATE " . DB_PREFIX . "vendorcountry SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE vendorcountry_id = '" . (int)$vendorcountry_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "vendorcountry SET image = '" . $this->db->escape($data['image']) . "' WHERE vendorcountry_id = '" . (int)$vendorcountry_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "vendorcountry_description WHERE vendorcountry_id = '" . (int)$vendorcountry_id . "'");

		foreach ($data['vendorcountry_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "vendorcountry_description SET vendorcountry_id = '" . (int)$vendorcountry_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "vendorcountry_to_store WHERE vendorcountry_id = '" . (int)$vendorcountry_id . "'");

		if (isset($data['vendorcountry_store'])) {
			foreach ($data['vendorcountry_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "vendorcountry_to_store SET vendorcountry_id = '" . (int)$vendorcountry_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'vendorcountry_id=" . (int)$vendorcountry_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'vendorcountry_id=" . (int)$vendorcountry_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('vendorcountry');
	}

	public function deleteVendorcountry($vendorcountry_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendorcountry WHERE vendorcountry_id = '" . (int)$vendorcountry_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendorcountry_to_store WHERE vendorcountry_id = '" . (int)$vendorcountry_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'vendorcountry_id=" . (int)$vendorcountry_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendorcountry_description WHERE vendorcountry_id = '" . (int)$vendorcountry_id . "'");

		$this->cache->delete('vendorcountry');
	}

	public function getVendorcountry($vendorcountry_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'vendorcountry_id=" . (int)$vendorcountry_id . "' LIMIT 1) AS keyword FROM " . DB_PREFIX . "vendorcountry WHERE vendorcountry_id = '" . (int)$vendorcountry_id . "'");

		return $query->row;
	}

	public function getVendorcountryDescriptions($vendorcountry_id) {
		$vendorcountry_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vendorcountry_description WHERE vendorcountry_id = '" . (int)$vendorcountry_id . "'");

		foreach ($query->rows as $result) {
			$vendorcountry_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'       => $result['meta_title'],
				'meta_h1'          => $result['meta_h1'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
			);
		}

		return $vendorcountry_description_data;
	}

	public function getVendorcountryes($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "vendorcountry";

		$sql = "SELECT c.vendorcountry_id, vd.name, c.sort_order FROM " . DB_PREFIX . "vendorcountry c LEFT JOIN " . DB_PREFIX . "vendorcountry_description vd ON (c.vendorcountry_id = vd.vendorcountry_id) WHERE vd.language_id = '" . (int)$this->config->get('config_language_id') . "'";



		if (!empty($data['filter_name'])) {
			$sql .= " AND name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'name',
			'sort_order'
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

	public function getVendorcountryStores($vendorcountry_id) {
		$vendorcountry_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vendorcountry_to_store WHERE vendorcountry_id = '" . (int)$vendorcountry_id . "'");

		foreach ($query->rows as $result) {
			$vendorcountry_store_data[] = $result['store_id'];
		}

		return $vendorcountry_store_data;
	}

	public function getTotalVendorcountryes() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "vendorcountry");

		return $query->row['total'];
	}
}
