<?php
class ModelCatalogExtralinks extends Model {
	public function addExtralink($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."menu_extra_links SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', parent_id=".(int)$data['parent_id'].", icon='".$this->db->escape($data['icon'])."', icon2='".$this->db->escape($data['icon2'])."'");

		$extralink_id = $this->db->getLastId();

		foreach ($data['extralink_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "menu_extra_links_description SET extralink_id = '" . (int)$extralink_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', link = '" . $this->db->escape($value['link'])  . "'");
		}

		$this->cacheDelete();

		return $extralink_id;
	}

	public function editExtralink($extralink_id, $data) {
            $this->db->query("UPDATE " . DB_PREFIX . "menu_extra_links SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', parent_id=".(int)$data['parent_id'].", icon='".$this->db->escape($data['icon'])."', icon2='".$this->db->escape($data['icon2'])."' WHERE id = '" . (int)$extralink_id. "'");
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "menu_extra_links_description WHERE extralink_id = '" . (int)$extralink_id . "'");
			foreach ($data['extralink_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "menu_extra_links_description SET extralink_id = '" . (int)$extralink_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', link = '" . $this->db->escape($value['link'])  . "'");
			}          
			
			//$this->cache->delete('menushka');
			$this->cacheDelete();
	}

	public function deleteExtralink($extralink_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_extra_links WHERE id = '" . (int)$extralink_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_extra_links_description WHERE extralink_id = '" . (int)$extralink_id . "'");
                        
		$this->cacheDelete();
	}

	private function cacheDelete() {
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		foreach ($languages as $language) {
			$this->cache->delete('menushka_' . $language['language_id']);
		}
	}

	public function getExtralink($extralink_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "menu_extra_links WHERE id = '" . (int)$extralink_id . "'");
                
		return $query->row;
	}

    public function getExtralinkDescription($extralink_id) {
        $extralink_description_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_extra_links_description WHERE extralink_id = '" . (int)$extralink_id . "'");

        foreach ($query->rows as $result) {
            $extralink_description_data[$result['language_id']] = array(
                'title'      => $result['title'],
                'link'       => $result['link'],
            );
        }

        return $extralink_description_data;
    }

	public function getExtralinks($data = array()) {
		
            $sql = "SELECT l.*, ld.title, ld.link FROM " . DB_PREFIX . "menu_extra_links l LEFT JOIN ". DB_PREFIX ."menu_extra_links_description ld ON (l.id=ld.extralink_id AND ld.language_id='" . (int)$this->config->get('config_language_id') . "')";

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
