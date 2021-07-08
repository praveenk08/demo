<?php class Review_model extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database(); 
	 }

	public function manageReviewsAjax($post,$count=false){
		$search=trim($post['search']);
		$rating=$post['rating'];
		$status=$post['status'];
		$vendor_id=$post['vendor_id'];
		
		$where['r.is_deleted']=0;
		if($status!=''){
			$where['r.status']=$status;
		}
		if($rating>0){
			$where['r.rating']=$rating;
		} 
		if($vendor_id>0){
			$where['vp.vendor_id']=$vendor_id;
		}   

		$like=array();
		if(strlen($search)>0){
			$like['r.review']=$search;
 			$like["CONCAT(u.first_name,' ',u.last_name)"]=$search;
			$like['u.first_name']=$search;
			$like['u.last_name']=$search;
 		}
		$this->db->select("r.*,CONCAT(u.first_name,' ',u.last_name) customer_name,CONCAT(vendor.first_name,' ',vendor.last_name) vendor_name");
		$this->db->from('review_rating r');
		$this->db->join('users u' ,'u.id=r.customer_id','left');
		$this->db->join('vendor_products vp' ,'vp.id=r.vendor_product_id','left');
		$this->db->join('users vendor' ,'vendor.id=vp.vendor_id','left');
 		if(count($where)>0){
			$this->db->where($where);
		}
		if(count($like)>0){
			$this->db->group_start();
			$this->db->or_like($like);
			$this->db->group_end();
		}
		if ($post['order'][0]['column']!='' && isset($post['order'][0]['dir']) && !empty($post['order'][0]['dir'])) {
			$order_by = '';
			switch ($post['order'][0]['column']) {
				case 1:
				$order_by = 'customer_name';
				break;
				case 2:
				$order_by = 'vendor_name';
				break;
				case 3:
				$order_by = 'r.review';
				break;
				case 4:
				$order_by = 'r.rating';
				break;
				case 5:
				$order_by = 'r.status';
				break;
				default:
				$order_by = 'r.id';
				break;
			}

			$dir_by = '';
			switch ($post['order'][0]['dir']) {

				case 'asc':
					$dir_by = 'asc';
					break;
				case 'desc':
					$dir_by = 'desc';
					break;
				default:
					$dir_by = 'asc';
					break;
			}
		$this->db->order_by($order_by,$dir_by); 
	}
	//
	if(!$count){
		$start=$post['start'];
		$length=$post['length'];
		if(!$start){
			$start=0;
		}
		if(!$length){
			$length=10;
		}
		$this->db->limit($length,$start);
	}

	$result = $this->db->get();
	$resultArray = $result->result_array();	
	if($count){
		return $result->num_rows();
	}else{
		//echo $this->db->last_query();
		return $resultArray;
	}
	}	

	public function contactUsAjax($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['status'];
		$where['c.is_deleted']=0;
		if($status!=''){
			$where['c.status']=$status;
		}
		   
		$like=array();
		if(strlen($search)>0){
			$like['c.name']=$search;
			$like['c.email']=$search;
			$like['c.phone']=$search;
			$like['c.subject']=$search;
			$like['c.message']=$search;
  		}
		$this->db->select("c.*");
		$this->db->from('contact_us c');
  		if(count($where)>0){
			$this->db->where($where);
		}
		if(count($like)>0){
			$this->db->group_start();
			$this->db->or_like($like);
			$this->db->group_end();
		}
		if ($post['order'][0]['column']!='' && isset($post['order'][0]['dir']) && !empty($post['order'][0]['dir'])) {
			$order_by = '';
			switch ($post['order'][0]['column']) {
				case 1:
				$order_by = 'c.name';
				break;
				case 2:
				$order_by = 'c.email';
				break;
				case 3:
				$order_by = 'c.phone';
				break;
				case 4:
				$order_by = 'c.subject';
				break;
 				case 5:
				$order_by = 'c.status';
				break;
				default:
				$order_by = 'c.id';
				break;
			}

			$dir_by = '';
			
			switch ($post['order'][0]['dir']) {

				case 'asc':
					$dir_by = 'asc';
					break;
				case 'desc':
					$dir_by = 'desc';
					break;
				default:
					$dir_by = 'asc';
					break;
			}
		$this->db->order_by($order_by,$dir_by); 
	}
	//
	if(!$count){
		$start=$post['start'];
		$length=$post['length'];
		if(!$start){
			$start=0;
		}
		if(!$length){
			$length=10;
		}
		$this->db->limit($length,$start);
	}

	$result = $this->db->get();
	$resultArray = $result->result_array();	
	if($count){
		return $result->num_rows();
	}else{
		//echo $this->db->last_query();
		return $resultArray;
	}
	}	
	
}
