<?php
class ModelCatalogShopreview extends Model {
    
	public function addReview($data, $image_attached=false) {
            
		$this->db->query("INSERT INTO " . DB_PREFIX . "shopreview SET author = '" . $this->db->escape($data['author']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = '" . $this->db->escape($data['date_added']) . "', email = '". $this->db->escape($data['email'])."', phone='". $this->db->escape($data['phone'])."', answer='". $this->db->escape($data['answer'])."', notify='". $this->db->escape($data['notify'])."'");

		$review_id = $this->db->getLastId();
               
                if($image_attached){
                    $size = getimagesize($this->request->files['reviewimage']['tmp_name']);
                    $this->addreviewImage($review_id, $size[0], $size[1]);
                }
                
		return $review_id;
	}

	public function editReview($review_id, $data, $image_attached=false) {
            
            if($image_attached){
                    $query=$this->db->query("SELECT image FROM " . DB_PREFIX . "shopreview WHERE shopreview_id = '" . (int)$review_id . "'");
                    $old_image=DIR_IMAGE.'shop_reviews/'.$query->row['image'];
                    if(is_file($old_image)){
                        unlink($old_image);
                    }
                    $size = getimagesize($this->request->files['reviewimage']['tmp_name']);
                    $this->addreviewImage($review_id, $size[0], $size[1]);
                }
            
            $this->db->query("UPDATE " . DB_PREFIX . "shopreview SET author = '" . $this->db->escape($data['author']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = '" . $this->db->escape($data['date_added']). "', email = '". $this->db->escape($data['email'])."', phone='". $this->db->escape($data['phone'])."', answer='". $this->db->escape($data['answer'])."', notify='". $this->db->escape($data['notify'])."', date_modified = NOW() WHERE shopreview_id = '" . (int)$review_id . "'");
	
        }

	public function deleteReview($review_id) {
                $query=$this->db->query("SELECT image FROM " . DB_PREFIX . "shopreview WHERE shopreview_id = '" . (int)$review_id . "'");
                $old_image=DIR_IMAGE.'shop_reviews/'.$query->row['image'];
                if(is_file($old_image)){
                    unlink($old_image);
                }
		$this->db->query("DELETE FROM " . DB_PREFIX . "shopreview WHERE shopreview_id = '" . (int)$review_id . "'");
	}

	public function getReview($review_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "shopreview WHERE shopreview_id = '" . (int)$review_id . "'");

		return $query->row;
	}

	public function getReviews($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "shopreview WHERE 1=1";

		if (!empty($data['filter_author'])) {
			$sql .= " AND author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'author',
			'rating',
			'status',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY date_added";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

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

	public function getTotalReviews($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "shopreview WHERE 1=1";

		if (!empty($data['filter_author'])) {
			$sql .= " AND author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalReviewsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "shopreview WHERE status = '0'");

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
        
        public function deleteImage($shopreview_id){
            $query=$this->db->query("SELECT image FROM " . DB_PREFIX . "shopreview WHERE shopreview_id = '" . (int)$shopreview_id . "'");
            $old_image=DIR_IMAGE.'shop_reviews/'.$query->row['image'];
            if(is_file($old_image)){
                unlink($old_image);
            }
            $this->db->query("UPDATE " . DB_PREFIX . "shopreview SET image = '' WHERE shopreview_id = '" . (int)$shopreview_id . "'");
        }
        
        public function saveDefaultImage($data){
            $path = DIR_IMAGE . 'shop_reviews/';

            $file = $data['file_name'];
            $fdata = pathinfo($file);
            $ext = $fdata['extension'];
            $filename = $fdata['filename'];

            $new_file_name = $filename .  "." . $ext;

            $image = new Image($data['file']); 
            $image->save($path . $new_file_name);
            return  $new_file_name;
        }
        
        public function deleteDefaultImage($file){
            $old_image=DIR_IMAGE.'shop_reviews/'.$file;
            if(is_file($old_image)){
                unlink($old_image);
            }
        }
        
        public function setUrlAlias($keyword, $query='features/reviews') {
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = '" .$query . "'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias (query, keyword) VALUES('".$query ."', '".$this->db->escape($keyword). "')");
                
	}
        
}