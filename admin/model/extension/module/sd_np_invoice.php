<?php
class ModelExtensionModuleSdNpInvoice extends Model
{
    /**
     * Call method createTable() - for create tables in database during install module
     */
    public function createTable()
    {

        $this->db->query(
            "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "np_packaging ("
                . " packaging_id INT(11) NOT NULL AUTO_INCREMENT, "
                . " title VARCHAR(255) NOT NULL, "
                . " volume VARCHAR(255) NOT NULL, "
                . " PRIMARY KEY (packaging_id)"
                . ") COLLATE='utf8_general_ci' ENGINE=MyISAM"
        );
        $this->db->query(
            "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "np_invoices ("
                . " order_id INT(11) NOT NULL, "
                . " np_number VARCHAR(64), "
                . " packaging_id INT(11), "
                . " is_warning tinyint(1), "
                . " PRIMARY KEY (order_id)"
                . ") COLLATE='utf8_general_ci' ENGINE=MyISAM"
        );
    }

    public function addPackage($data)
    {
        $this->db->query("INSERT INTO ".DB_PREFIX."np_packaging SET title='". $this->db->escape($data['title'])."', volume='".$this->db->escape($data['volume'])."'");

        return $this->db->getLastId();
    }

    public function editPackage($packaging_id, $data)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "np_packaging  SET  title='".$this->db->escape($data['title'])."', volume='".$this->db->escape($data['volume'])."' WHERE packaging_id='".(int)$packaging_id."'");

    }

    public function deletePackages($packages_ids)
    {
        $this->db->query("DELETE FROM ".DB_PREFIX."np_packaging WHERE packaging_id IN (" . implode(",", $packages_ids) .")");
    }

    public function getPackage($id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "np_packaging  WHERE packaging_id = ". $id);

        return $query->row;
    }

    public function getPackages()
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "np_packaging  ORDER BY title ASC");

        return $query->rows;
    }

    public function getPackageOrder($order_id)
    {
        $query = $this->db->query("SELECT packaging_id FROM " . DB_PREFIX . "np_invoices  WHERE order_id = ". $order_id);

        return ($query->num_rows ? $query->row['packaging_id']: false);
    }

    public function getInvoiceOrder($order_id)
    {
        $query = $this->db->query("SELECT np_number, is_warning FROM " . DB_PREFIX . "np_invoices  WHERE order_id = ". $order_id);

        return ($query->num_rows ? $query->row : '');
    }

    public function setOrderPackage($data)
    {
        $this->db->query("REPLACE INTO ".DB_PREFIX."np_invoices SET order_id='". (int)$data['order_id']."', packaging_id='". (int)$data['package_id']."'");

    }

    public function getWeightOrder($order_id)
    {
        $query = $this->db->query("SELECT sum(p.weight*op.quantity) as order_weight FROM `oc_order_product` op LEFT JOIN `oc_product` p on (p.`product_id` = op.`product_id`) WHERE `order_id` = " . $order_id);

        return ($query->num_rows ? $query->row['order_weight']/1000: 0);
    }

    public function getShippingCostOrder($order_id)
    {
        $query = $this->db->query("SELECT `value` FROM `oc_order_total` WHERE  `code` = 'shipping' AND `order_id` = " . $order_id );
        return ($query->num_rows ? $query->row['value']: 0);
    }

    public function setInvoiceOrder($order_id, $inNumber, $packaging_id, $is_warning){
        $this->db->query("REPLACE INTO ".DB_PREFIX."np_invoices SET order_id='". (int)$order_id."', np_number='". $inNumber . "', packaging_id=". (int)$packaging_id. ", is_warning=". (int)$is_warning);
    }

    public function getRefCity($city)
    {
        $query = $this->db->query("SELECT `ref` FROM `oc_newmail_city` WHERE `description` = '" . $city ."' OR `description_ru` = '" . $city ."'" );
        return ($query->num_rows ? $query->row['ref']: '');
    }

    public function getRefOffice($office)
    {
        $query = $this->db->query("SELECT `ref` FROM `oc_newmail_office` WHERE `description` = '" . $office ."' OR `description_ru` = '" . $office ."'" );
        return ($query->num_rows ? $query->row['ref']: '');
    }
}
