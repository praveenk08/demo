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


	public function teamData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select('*');
			$this->db->from('our_team');
			$result=$this->db->get();
			$response=$result->row_array();
			return $response;
		}
	}
 	
	public function manageTeamsAjax($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['status'];
		$where['ot.is_deleted']=0;
		if($status!=''){
			$where['ot.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['ot.name']=$search;
			$like['ot.designation']=$search;
			$like['ot.description']=$search;
 		}
		$this->db->select('ot.*');
		$this->db->from('our_team ot');
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
					$order_by = 'ot.name';
					break;

				case 2:
					$order_by = 'ot.designation';
					break;

				case 4:
					$order_by = 'ot.status';
					break;
			 
				default:
					$order_by = 'ot.id';
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



	public function ourServicesData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select('*');
			$this->db->from('our_services');
			$result=$this->db->get();
			$response=$result->row_array();
			return $response;
		}
	}
 	
	public function manageOurServicesAjax($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['status'];
		$where['os.is_deleted']=0;
		if($status!=''){
			$where['os.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['os.name']=$search;
 			$like['os.description']=$search;
 		}
		$this->db->select('os.*');
		$this->db->from('our_services os');
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
					$order_by = 'os.name';
					break;

				case 2:
					$order_by = 'os.description';
					break;

				case 4:
					$order_by = 'os.status';
					break;
			 
				default:
					$order_by = 'os.id';
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


	public function workProcessData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select('*');
			$this->db->from('work_process');
			$result=$this->db->get();
			$response=$result->row_array();
			return $response;
		}
	}
 	
	public function manageWorkProcessAjax($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['status'];
		$where['wp.is_deleted']=0;
		if($status!=''){
			$where['wp.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['wp.name']=$search;
  		}
		$this->db->select('wp.*');
		$this->db->from('work_process wp');
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
					$order_by = 'wp.name';
					break;

				case 3:
					$order_by = 'wp.sort_id';
					break;
				case 4:
					$order_by = 'wp.status';
					break;
			 
				default:
					$order_by = 'wp.id';
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


	
	public function facilityData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select('*');
			$this->db->from('facilities');
			$result=$this->db->get();
			$response=$result->row_array();
			return $response;
		}
	}
 	
	public function manageFacilitiesAjax($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['status'];
		$where['f.is_deleted']=0;
		if($status!=''){
			$where['f.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['f.name']=$search;
  		}
		$this->db->select('f.*');
		$this->db->from('facilities f');
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
					$order_by = 'f.name';
					break;

				case 3:
					$order_by = 'f.sort_id';
					break;
				case 4:
					$order_by = 'f.status';
					break;
			 
				default:
					$order_by = 'f.id';
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


	public function manageEmailTemplatesAjax($post,$count=false){
		$search=trim($post['search']);
		$where=array();
 		//$status=$post['status'];
 		//if($status!=''){
			//$where['e.status']=$status;
		//}  
		$like=array();
		if(strlen($search)>0){
			$like['e.name']=$search;
			$like['e.subject']=$search;
			$like['e.welcome_heading']=$search;
			$like['e.welcome_message']=$search;
			$like['e.message_description']=$search;
		}
		   
		$this->db->select('e.*');
		$this->db->from('email_templates e');
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
					$order_by = 'e.name';
					break;

				case 3:
					$order_by = 'e.name';
				break;
				case 4:
					$order_by = 'e.name';
				break;
			 
				default:
					$order_by = 'e.id';
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

	

	public function emailTemplateData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select('*');
			$this->db->from('email_templates');
			$result=$this->db->get();
			$response=$result->row_array();
			return $response;
		}
	}
	

	public function manageCalculationAjax($post,$count=false){
		$search=trim($post['search']);
		$where=array();
		$status=$post['status'];
		$where['c.is_deleted']=0;

 		if($status!=''){
			$where['c.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['c.title']=$search;
			$like['c.value']=$search;
 		}
		   
		$this->db->select('c.*');
		$this->db->from('calculations c');
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
					$order_by = 'c.title';
					break;
				case 3:
					$order_by = 'c.value';
				break;

				case 4:
					$order_by = 'c.sort_id';
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
 		return $resultArray;
	}
	}

}
