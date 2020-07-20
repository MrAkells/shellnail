<?php
class ModelSitemapStatSitemapVier extends Model {
    
    private $limit = 10000;
    public function setLimit() {
        return $this->limit;
    }
    public function siteMapOthers() {
        $output = '';
        
        return $output;
    }
    
    private function allCmsBlog($data = array()) {
        $limit = null;
        if($data) {
            $limit = " LIMIT ".(int)$data['start'].", ".(int)$data['limit'];
        }
        $where_and = " AND `index_page` NOT LIKE '%noindex%' ";
        $query_str = "SELECT `record_id` FROM `".DB_PREFIX."record` WHERE `status` = 1 ".$where_and.$limit;
        $query = $this->db->query($query_str);
        return $query->rows;
	}
}