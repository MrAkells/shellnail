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
            $sql = "SELECT `description` FROM  " . DB_PREFIX . "page_no_index WHERE url = '" . $this->request->server['REQUEST_URI'] . "' AND is_noindex=0";

            $query = $this->db->query($sql);
            return ($query->row ? $query->row['description'] : '');
        }
        return '';
    }
}
