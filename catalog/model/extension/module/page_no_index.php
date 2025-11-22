<?php
class ModelExtensionModulePageNoIndex extends Model
{
    public function isPageNoIndex()
    {
        $pattern = ['/\?.*/i','/\/ua/i'];
        if(isset($this->request->server['REQUEST_URI'])){
            $sql = "SELECT page_id FROM  " . DB_PREFIX . "page_no_index WHERE url = '" . preg_replace($pattern, '', $this->request->server['REQUEST_URI']) . "'  AND is_noindex=1";

            $query = $this->db->query($sql);

            return ($query->num_rows ? true : false);
        }
        return false;
    }

    public function isPageCanonical()
    {

        if(isset($this->request->server['REQUEST_URI'])){

            $pattern = ['/\?.*/i','/\/ua/i'];

            $sql = "SELECT page_id FROM  " . DB_PREFIX . "page_no_index WHERE url = '" . preg_replace($pattern, '', $this->request->server['REQUEST_URI']) . "'  AND is_canonical=1";

            $query = $this->db->query($sql);

            return ($query->num_rows ? true : false);
        }
        return false;
    }

    public function getDescription()
    {
         if(isset($this->request->server['REQUEST_URI'])){
            $query = $this->db->query("SELECT pd.* FROM " . DB_PREFIX . "page_no_index p LEFT JOIN " . DB_PREFIX . "page_no_index_description pd ON (p.page_id = pd.page_id)  WHERE p.url = '" . preg_replace('/\/ua\//i', '/', $this->request->server['REQUEST_URI']) . "' AND p.is_noindex=0 AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
            return $query->num_rows ? $query->rows[0] : [];
        }
        return [];
    }

    // Сheck if the given URL is allowed to be indexed
    public function isCurrentUrlIndexAllowed() {
        if (empty($this->request->server['REQUEST_URI'])) {
            return false;
        }

        $uri = $this->request->server['REQUEST_URI'];

        $uri = $this->db->escape($uri);

        $query = $this->db->query("
            SELECT page_id 
            FROM `" . DB_PREFIX . "page_no_index`
            WHERE is_noindex = '0'
            AND url = '" . $uri . "'
            LIMIT 1
        ");

        return (bool)$query->num_rows;
    }

    public function isUrlIndexAllowed($href) {
        if (!$href) {
            return false;
        }

        $parts = parse_url($href);

        if (!$parts) {
            return false;
        }

        $uri = '';

        if (!empty($parts['path'])) {
            $uri .= $parts['path'];
        }

        if (!empty($parts['query'])) {
            $uri .= '?' . $parts['query'];
        }

        if ($uri === '') {
            return false;
        }

        $uri = $this->db->escape($uri);

        $query = $this->db->query("
            SELECT page_id 
            FROM `" . DB_PREFIX . "page_no_index`
            WHERE is_noindex = '0'
            AND url = '" . $uri . "'
            LIMIT 1
        ");

        return (bool)$query->num_rows;
    }

}
