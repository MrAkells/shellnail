<?php
class ModelCatalogExtralinks extends Model {
	
    public function getExtralinks() {
		
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_extra_links WHERE status=1");
        
        $links=array();
        foreach ($query->rows as $link){
            $links[$link['parent_id']][]=$link;
        }
        
        return $links;
    }

}
