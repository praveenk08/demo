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
			$like['s.']=$search;
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
	$resultArray = $result->result_array();	
	if($count){

		return $result->num_rows();

	}else{
 		return $resultArray;
	}
	}

}