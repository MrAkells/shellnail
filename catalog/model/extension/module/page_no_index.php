<?php
class ModelExtensionModulePageNoIndex extends Model
{
    public function isPageNoIndex()
    {
        
        if(isset($this->request->server['REQUEST_URI'])){
            $sql = "SELECT page_id FROM  " . DB_PREFIX . "page_no_index WHERE url = '" . $this->request->server['REQUEST_URI'] . "'  AND is_noindex=1";

            $query = $this->db->query($sql);

            return ($query->num_rows ? true : false);
        }
        return false;
    }
    public function getDescription()
    {
         if(isset($this->request->server['REQUEST_URI'])){
            $query = $this->db->query("SELECT pd.* FROM " . DB_PREFIX . "page_no_index p LEFT JOIN " . DB_PREFIX . "page_no_index_description pd ON (p.page_id = pd.page_id)  WHERE p.url = '" . $this->request->server['REQUEST_URI'] . "' AND p.is_noindex=0 AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
            return $query->num_rows ? $query->rows[0] : [];
        }
        return [];
    }
}
