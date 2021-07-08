<?php
class Student_model extends CI_Model{
	function __construct()
	{
		$this->load->database();
	}

	public function managestudentajax($post,$count=false){
		$search=trim($post['search']);
		$where=array();
		$status=$post['status'];
		$where['s.is_deleted']=0;

 		if($status!=''){
			$where['s.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['s.registrationno']=$search;
			$like['s.name']=$search;
			$like['s.class']=$search;
			$like['s.rollno']=$search;
			$like['s.email']=$search;
			$like['s.phone']=$search;
			$like['s.address']=$search;
 		} 
		$this->db->select('s.*');
		$this->db->from('student s');
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
				case 2:
					$order_by = 's.registrationno';
					break;
				case 3:
					$order_by = 's.name';
				break;

				case 4:
					$order_by = 's.email';
				break;
			 
				case 5:
					$order_by = 's.phone';
				break;

				case 6:
					$order_by = 's.rollno';
				break;

				case 7:
					$order_by = 's.status';
				break;

						 
				default:
					$order_by = 's.id';
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
	//echo  $this->db->last_query();
	$resultArray = $result->result_array();	
	if($count){

		return $result->num_rows();

	}else{
 		return $resultArray;
	}
	}

public function contactUsExport($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['change_status'];
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
		$this->db->select("
			c.name,
			c.email,
			c.phone,
			c.subject,
			c.message,
			");
		$this->db->from('contact_us c');
  		if(count($where)>0){
			$this->db->where($where);
		}
		if(count($like)>0){
			$this->db->group_start();
			$this->db->or_like($like);
			$this->db->group_end();
		}
		
		return $result = $this->db->get()->result_array();
	
		}
	public function managestudentExport($post,$count=false){
		$search=trim($post['search']);
		$where=array();
		$status=$post['change_status'];
		$where['s.is_deleted']=0;

 		if($status!=''){
			$where['s.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['s.registrationno']=$search;
			$like['s.name']=$search;
			$like['s.class']=$search;
			$like['s.rollno']=$search;
			$like['s.email']=$search;
			$like['s.phone']=$search;
			$like['s.address']=$search;
 		}
		   
		$this->db->select("s.*");
		$this->db->from('student s');
 		if(count($where)>0){	
			$this->db->where($where);
		}
		if(count($like)>0){
			$this->db->group_start();
			$this->db->or_like($like);
			$this->db->group_end();
		}
	return $result = $this->db->get()->result_array();
	}


	public function manageReviewsExport($post,$count=false){
		// /$search=trim($post['search']);
//		echo"<pre>"; print_r($search); die;
		$rating=$post['change_rating'];
		$status=$post['change_status'];
		$where['r.is_deleted']=0;
		if($status!=''){
			$where['r.status']=$status;
		}
		if($rating>0){
			$where['r.rating']=$rating;
		}    
		$like=array();
		
		$this->db->select("r.rating, CONCAT(u.first_name,' ',u.last_name) customer_id ,CONCAT(vendor.first_name,' ',vendor.last_name) vendor_product_id");
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
		return $result = $this->db->get()->result_array();
		}	


}