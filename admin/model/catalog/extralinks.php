<?php
class ModelCatalogExtralinks extends Model {
	public function addExtralink($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."menu_extra_links SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', link='".$this->db->escape($data['link'])."', title='".$this->db->escape($data['title'])."', parent_id=".(int)$data['parent_id'].", icon='".$this->db->escape($data['icon'])."', icon2='".$this->db->escape($data['icon2'])."'");

		$extralink_id = $this->db->getLastId();

                $this->cache->delete('menushka');
		return $extralink_id;
	}

	public function editExtralink($extralink_id, $data) {
            $this->db->query("UPDATE " . DB_PREFIX . "menu_extra_links SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', link='".$this->db->escape($data['link'])."', title='".$this->db->escape($data['title'])."', parent_id=".(int)$data['parent_id'].", icon='".$this->db->escape($data['icon'])."', icon2='".$this->db->escape($data['icon2'])."' WHERE id = '" . (int)$extralink_id. "'");
            $this->cache->delete('menushka');
	}

	public function deleteExtralink($extralink_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_extra_links WHERE id = '" . (int)$extralink_id . "'");
                $this->cache->delete('menushka');
	}

	public function getExtralink($extralink_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "menu_extra_links WHERE id = '" . (int)$extralink_id . "'");
                
		return $query->row;
	}

	public function getExtralinks($data = array()) {
		
            $sql = "SELECT * FROM " . DB_PREFIX . "menu_extra_links ";

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


	public function getTotalExtralinks() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "menu_extra_links");

		return $query->row['total'];
	}

}
