<?php class Category_model extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database(); 
	 }
 
	
	public function CategoryData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select('*');
			$this->db->from('category');
			$result=$this->db->get();
			$response=$result->row_array();
			return $response;
		}
	}

	public function categoryList($where,$status=false){
		if($status==false){
			$where['c.is_deleted']=0;
		}
		if(count($where)>0){
			$this->db->where($where);
		}
		$result=$this->db->get('category c');
		return $result->result_array();
	}

	public function getCategoryLevel($where){
		$this->db->where($where);
		$result=$this->db->get('category c');
		$row=$result->row_array();
		return $row;
		
	}
	
 	public function getCategories($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->from('category');
			$result=$this->db->get();
			$response=$result->result_array();
			return $response;
		}
	 }
	public function manageCategoriesAjax($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['status'];

		$where['c.is_deleted']=0;
		if($status!=''){
			$where['c.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['c.name']=$search;
 		}
		$this->db->select('c.*,c2.name as parent_name');

		$this->db->from('category c');
		$this->db->join('category c2','c.parent_id=c2.id','LEFT');
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
					$order_by = 'c.name';
					break;	

				case 3:
					$order_by = 'c2.name';
					break;

				case 4:
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

	
	public function manageCategoriesExport($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['change_status'];

		$where['c.is_deleted']=0;
		if($status!=''){
			$where['c.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['c.name']=$search;
 		}
		$this->db->select('c.name,c2.name as parent_name');

		$this->db->from('category c');
		$this->db->join('category c2','c.parent_id=c2.id','LEFT');
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



	public function manageunitsExport($post,$count=false){
		//echo "abc"; print_r($post);die;
		$search=trim($post['search']);
 		$status=$post['change_status'];
		$where['u.is_deleted']=0;
		if($status!=''){
			$where['u.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['u.name']=$search;
 		}
		
		$this->db->select("
			u.name,
			u.status,
			DATE_FORMAT(u.added_date,'%d-%m-%Y %H:%i') as added_date");

		$this->db->from('units u');
 		if(count($where)>0){
			$this->db->where($where);
		}
		if(count($like)>0){
			$this->db->group_start();
			$this->db->or_like($like);
			$this->db->group_end();
		}
		 //$result = $this->db->get();
		// echo $this->db->last_query(); die;
		return $result = $this->db->get()->result_array();
		//count($result);
		
		}


	public function manageSlidersAjax($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['status'];

		$where['s.is_deleted']=0;
		if($status!=''){
			$where['s.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['s.name']=$search;
 		}
		$this->db->select('s.*');

		$this->db->from('slider s');
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
					$order_by = 's.name';
					break;

				case 2:
					$order_by = 's.added_date';
					break;

				case 3:
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
		//echo $this->db->last_query();
		return $resultArray;
	}
	}

	public function manageSlidersExport($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['change_status'];

		$where['s.is_deleted']=0;
		if($status!=''){
			$where['s.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['s.name']=$search;
 		}
		$this->db->select('s.name ,s.added_date, s.status , s.is_deleted');

		$this->db->from('slider s');
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




	public function manageBrandsAjax($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['status'];

		$where['b.is_deleted']=0;
		if($status!=''){
			$where['b.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['b.name']=$search;
 		}
		$this->db->select('b.*');

		$this->db->from('brands b');
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
					$order_by = 'b.name';
					break;

				case 2:
					$order_by = 'b.added_date';
					break;

				case 3:
					$order_by = 'b.status';
					break;
				default:
					$order_by = 'b.id';
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


	public function manageUnitsAjax($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['status'];

		$where['u.is_deleted']=0;
		if($status!=''){
			$where['u.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['u.name']=$search;
		 }
 
		$this->db->select("u.id,u.name,u.status,DATE_FORMAT(u.added_date,'%d-%m-%Y %H:%i') as added_date");
		$this->db->from('units u');
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
					$order_by = 'u.name';
					break;

				case 2:
					$order_by = 'u.added_date';
					break;

				case 3:
					$order_by = 'u.status';
					break;
				default:
					$order_by = 'u.id';
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

	public function manageFaqsAjax($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['status'];

		$where['f.is_deleted']=0;
		if($status!=''){
			$where['f.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['f.question']=$search;
 		}
		$this->db->select('f.*');

		$this->db->from('faq f');
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
					$order_by = 'f.question';
					break;
				case 2:
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
		//echo $this->db->last_query();
		return $resultArray;
	}
	}
 

 public function manageFaqsExport($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['change_status'];

		$where['f.is_deleted']=0;
		if($status!=''){
			$where['f.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['f.question']=$search;
 		}
		$this->db->select('f.question ,f.answer , f.status ,f.added_date');

		$this->db->from('faq f');
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
 

public function brandData($where){
	if(count($where)>0){
		$this->db->where($where);
		$this->db->select('*');
		$this->db->from('brands');
		$result=$this->db->get();
		$response=$result->row_array();
		return $response;
	}
}



public function unitData($where){
	if(count($where)>0){
		$this->db->where($where);
		$this->db->select('*');
		$this->db->from('units');
		$result=$this->db->get();
		$response=$result->row_array();
		return $response;
	}
}

public function viewDeliveryBoy($where){
	if(count($where)>0){
		$this->db->select('
		db.*,c.name as country_name,s.name as state_name,city.name as city_name
		');
		$this->db->from('delivery_boy db');
		$this->db->join('countries c','c.id=db.country','left');
		$this->db->join('states s','s.id=db.state','left');
		$this->db->join('cities city','city.id=db.city','left');
		$this->db->where($where);
  		$result=$this->db->get();
		$response=$result->row_array();
		return $response;
	}
}



	
}
