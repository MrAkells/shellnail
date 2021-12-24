<?php
class ModelCatalogExtralinks extends Model {
	
    public function getExtralinks() {
		
        $query = $this->db->query("SELECT l.*, ld.title, ld.link FROM " . DB_PREFIX . "menu_extra_links l LEFT JOIN ". DB_PREFIX ."menu_extra_links_description ld ON (l.id=ld.extralink_id AND ld.language_id='" . (int)$this->config->get('config_language_id') . "') WHERE status=1");
        
        $links=array();
        foreach ($query->rows as $link){
            $links[$link['parent_id']][]=$link;
        }
        
        return $links;
    }

}
