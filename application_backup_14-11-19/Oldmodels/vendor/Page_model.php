<?php class Page_model extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database(); 
	 }
 
	
	public function pageData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select('*');
			$this->db->from('cms_pages');
			$result=$this->db->get();
			$response=$result->row_array();
			return $response;
		}
	}
 	
	public function managePagesAjax($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['status'];
		$where['p.is_deleted']=0;
		if($status!=''){
			$where['p.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['p.name']=$search;
			$like['p.meta_title']=$search;
			$like['p.meta_keywords']=$search;
			$like['p.meta_description']=$search;
			$like['p.description']=$search;
		}
		$this->db->select('p.*');
		$this->db->from('cms_pages p');
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
					$order_by = 'p.name';
					break;
				case 2:
					$order_by = 'p.meta_title';
					break;
				case 3:
					$order_by = 'p.status';
					break;
				default:
					$order_by = 'p.id';
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
