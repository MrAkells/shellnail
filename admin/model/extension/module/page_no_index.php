<?php
class ModelExtensionModulePageNoIndex extends Model
{
    /**
     * Call method createTable() - for create tables in database during install module
     */
    public function createTable()
    {

        $this->db->query(
            "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "page_no_index ("
                . " page_id INT(11) NOT NULL AUTO_INCREMENT, "
                . " url VARCHAR(255) NOT NULL, "
                . " description text, "
                . " PRIMARY KEY (page_id) , KEY `url` (`url`)"
                . ") COLLATE='utf8_general_ci' ENGINE=MyISAM"
        );
    }

    public function getUrl($id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "page_no_index  WHERE page_id = ". $id);

        return $query->row;
    }

	public function getUrls($data){
        $sql = "SELECT * FROM " . DB_PREFIX . "page_no_index ";

        if (!empty($data['filter_name'])) {
			$sql .= " WHERE url LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

        $sql .= " ORDER BY url ASC";

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

    public function getTotalUrls($data = array()){
        $sql = "SELECT COUNT(DISTINCT page_id) AS total FROM " . DB_PREFIX . "page_no_index ";
        if (!empty($data['filter_name'])) {
			$sql .= " WHERE url LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

        $query = $this->db->query($sql);

		return $query->row['total'];
    }

    public function add($data)
    {
        $this->db->query("INSERT INTO ".DB_PREFIX."page_no_index SET url='". $this->db->escape($data['url']) . "', description = '" . $this->db->escape($data['description']) . "'");

        return $this->db->getLastId();
    }

    public function edit($id, $data)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "page_no_index  SET  url='".$this->db->escape($data['url']) ."', description = '" . $this->db->escape($data['description']) . "' WHERE page_id='".(int)$id."'");

    }

    public function delete($ids)
    {
        $this->db->query("DELETE FROM ".DB_PREFIX."page_no_index WHERE page_id IN (" . implode(",", $ids) .")");
    }    

}