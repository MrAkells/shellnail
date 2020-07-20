<?php
class ModelModuleShopreview extends Model {

	public function getreviews($start = 0, $limit = 20) {
            if ($start < 0) {
		$start = 0;
            }

            if ($limit < 1) {
		$limit = 20;
            }

            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "shopreview  WHERE status = '1' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

            return $query->rows;
        }
        
        public function addreview($data,  $image_attached=false) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "shopreview SET author = '" . $this->db->escape($data['name']) . "', customer_id = '" . (int)$this->customer->getId() . "', text = '" . $this->db->escape($data['text']) . "', rating = '" . (int)$data['rating'] . "', status='1', date_added = NOW(), email='".$this->db->escape($data['reviewemail'])."', phone='".$this->db->escape($data['reviewphone'])."', notify='".(int)$data['notify']."'");
            
            $review_id = $this->db->getLastId();
            
            if($image_attached){
                $size = getimagesize($this->request->files['reviewimage']['tmp_name']);
                $this->addreviewImage($review_id, $size[0], $size[1]);
            }
            
        }
        
        public function getTotalReviews(){
            $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "shopreview  WHERE status = '1'");
            return $query->row['total'];
        }
        
        public function isPicture($type) {
            $result = false;
            
            switch ($type) {
                case 'image/jpeg':
                case 'image/jpg':
                case 'image/pjpeg':
                case 'image/x-png':
                case 'image/png':
                case 'image/gif':
                $result = true;
                break;
            }
            
            return $result;
        }
        
        
        public function addreviewImage($shopreview_id, $width, $height){
               
            if(is_file($this->request->files['reviewimage']['tmp_name'])){
                $image_settings = array(
                    'file'          => $this->request->files['reviewimage']['tmp_name'],
                    'file_name'     => $this->request->files['reviewimage']['name'],
                    'width'         => $width,
                    'height'        => $height,
                    'shopreview_id'=> $shopreview_id,
                    );
                $this->SaveReviewImage($image_settings);
            }
               
        }
        
        public function SaveReviewImage($data) {
            $path = DIR_IMAGE . 'shop_reviews/';

            $file = $data['file_name'];
            $fdata = pathinfo($file);
            $ext = $fdata['extension'];
            $filename = $fdata['filename'];

            $new_file_name = $filename . "_" . $data['shopreview_id'] . "." . $ext;

            $this->db->query("UPDATE " . DB_PREFIX . "shopreview SET image = '" . $this->db->escape($new_file_name) . "' WHERE shopreview_id = '" . (int)$data['shopreview_id'] . "'");
	
            $image = new Image($data['file']); 
            $image->save($path . $new_file_name);
        }
     
}