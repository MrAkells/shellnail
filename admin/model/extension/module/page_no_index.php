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
                . " is_noindex BOOLEAN NOT NULL DEFAULT FALSE, "
                . " is_canonical BOOLEAN NOT NULL DEFAULT FALSE, "
                . " url VARCHAR(255) NOT NULL, "
                . " PRIMARY KEY (page_id) , KEY `url` (`url`)"
                . ") COLLATE='utf8_general_ci' ENGINE=MyISAM"
        );
        $this->db->query(
            "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "page_no_index_description ("
                . " page_id INT(11) NOT NULL, "
                . " language_id int(11) NOT NULL,"
                . " description text, "
                . " h1 varchar(255),"
                . " meta_title varchar(255),"
                . " meta_description varchar(2024),"
                . " meta_keyword varchar(255),"
                . " PRIMARY KEY (page_id, language_id)"
                . ") COLLATE='utf8_general_ci' ENGINE=MyISAM"
        );

        // Migration for existing installs
        $query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "page_no_index_description` LIKE 'h1'");
        if (!$query->num_rows) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "page_no_index_description` ADD COLUMN `h1` VARCHAR(255) NULL AFTER `description`");
        }
    }

    public function getUrl($id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "page_no_index  WHERE page_id = " . $id);

        return $query->row;
    }

    public function getPageDescriptions($page_id)
    {
        $page_description_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "page_no_index_description WHERE page_id = '" . (int)$page_id . "'");

        foreach ($query->rows as $result) {
            $page_description_data[$result['language_id']] = array(
                'h1'              => isset($result['h1']) ? $result['h1'] : '',
                'meta_title'       => $result['meta_title'],
                'meta_description' => (mb_detect_encoding($result['meta_description']) == 'UTF-8' ? $result['meta_description'] : mb_convert_encoding($result['meta_description'], 'utf-8', "HTML-ENTITIES")),
                'meta_keyword'     => $result['meta_keyword'],
                'description'      => $result['description']
            );
        }

        return $page_description_data;
    }

    public function getUrls($data)
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "page_no_index WHERE 1";
        if (!empty($data['filter_name'])) {
            $sql .= " AND url LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }
        if (isset($data['filter_noindex'])) {
            $sql .= "  AND  is_noindex = '" . (int)$data['filter_noindex'] . "'";
        }
        if (isset($data['filter_canonical'])) {
            $sql .= "  AND  is_canonical = '" . (int)$data['filter_canonical'] . "'";
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

    public function getTotalUrls($data = array())
    {
        $sql = "SELECT COUNT(DISTINCT page_id) AS total FROM " . DB_PREFIX . "page_no_index ";
        if (!empty($data['filter_name'])) {
            $sql .= " WHERE url LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function add($data)
    {
        $this->db->query("INSERT INTO " . DB_PREFIX . "page_no_index SET  is_noindex= '" . (isset($data['is_noindex']) ? (int)$data['is_noindex'] : 0) . "', is_canonical= '" . (isset($data['is_canonical']) ? (int)$data['is_canonical'] : 0) . "', url='" . $this->db->escape($data['url']) . "'");
        $id = $this->db->getLastId();

        foreach ($data['page_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "page_no_index_description SET page_id = '" . (int)$id . "', language_id = '" . (int)$language_id . "', description = '" . $this->db->escape(isset($value['description']) ? $value['description'] : '') . "', h1 = '" . $this->db->escape(isset($value['h1']) ? $value['h1'] : '') . "', meta_title = '" . $this->db->escape(isset($value['meta_title']) ? $value['meta_title'] : '') . "', meta_description = '" . $this->db->escape(mb_convert_encoding(isset($value['meta_description']) ? $value['meta_description'] : '', 'HTML-ENTITIES')) . "', meta_keyword = '" . $this->db->escape(isset($value['meta_keyword']) ? $value['meta_keyword'] : '') . "'");
        }

        return $id;
    }

    public function edit($id, $data)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "page_no_index  SET  is_noindex= '" . (isset($data['is_noindex']) ? (int)$data['is_noindex'] : 0) . "', is_canonical= '" . (isset($data['is_canonical']) ? (int)$data['is_canonical'] : 0) . "', url='" . $this->db->escape($data['url']) . "' WHERE page_id='" . (int)$id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "page_no_index_description WHERE page_id = '" . (int)$id . "'");

        foreach ($data['page_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "page_no_index_description SET page_id = '" . (int)$id . "', language_id = '" . (int)$language_id . "', description = '" . $this->db->escape(isset($value['description']) ? $value['description'] : '') . "', h1 = '" . $this->db->escape(isset($value['h1']) ? $value['h1'] : '') . "', meta_title = '" . $this->db->escape(isset($value['meta_title']) ? $value['meta_title'] : '') . "', meta_description = '" . $this->db->escape(mb_convert_encoding(isset($value['meta_description']) ? $value['meta_description'] : '', 'HTML-ENTITIES')) . "', meta_keyword = '" . $this->db->escape(isset($value['meta_keyword']) ? $value['meta_keyword'] : '') . "'");
        }
    }

    public function delete($ids)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "page_no_index WHERE page_id IN (" . implode(",", $ids) . ")");
    }
}
