<?php class Users_model extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database(); 
	 }
 
	public function getRoleList($where=array()){
		$this->db->select('*');
		$this->db->from('role');
		if(count($where)>0){
			$this->db->where($where);
		}
		$result=$this->db->get();
		$response=$result->result_array();
		return $response;
	}
	public function userData($where){
		if(count($where)>0){
			$this->db->select("
			u.id,
			r.name as role_name,
			u.role_id,
			u.first_name,
			u.last_name,
			u.image,
			u.top,
			u.verified,
			u.phone,
			u.email,
			u.forecast,
			u.publication,
			u.matching,
			u.status
		");

		$this->db->from('users u');
		$this->db->join('role r','r.id=u.role_id','inner');
 		if(count($where)>0){
			$this->db->where($where);
		}
			$result=$this->db->get();
			$response=$result->row_array();
			return $response;
		}
	}
 
	
	public function manageUsersAjax($post,$count=false){
		$search=trim($post['search']);
		$status=$post['status'];
		$role_id=$post['role_id'];
		$where['u.is_deleted']=0;
		//$where['ua.is_deleted']=0;
		if($role_id>0){
			$where['u.role_id']=$role_id;
		}
		if($status!=''){
			$where['u.status']=$status;
		}  

		$like=array();
		if(strlen($search)>0){
			$like['u.first_name']=$search;
			$like['u.last_name']=$search;
			$like['u.phone']=$search;
			$like['u.email']=$search;
 		}
		
		$this->db->select("
			u.id,
			r.name as role_name,
			CONCAT(u.first_name,'  ',u.last_name) as name,
			u.image,
			u.phone,
			u.email,
			u.status,
			(select count(ua.id) from user_address ua where ua.user_id=u.id and ua.is_deleted=0) as total_address
		");

		$this->db->from('users u');
		$this->db->join('role r','r.id=u.role_id','inner');
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
					$order_by = 'name';
					break;
				case 3:
					$order_by = 'r.name';
					break;
				case 4:
					$order_by = 'u.email';
					break;
				case 5:
					$order_by = 'u.phone';
					break;
				case 6:
					$order_by = 'total_address';
					break;

				case 8:
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

	$this->db->group_by('u.id');
	$result = $this->db->get();
	$resultArray = $result->result_array();	
	if($count){
		return $result->num_rows();
	}else{
		//echo $this->db->last_query();
		return $resultArray;
	}
	}

	public function getUserList($where){
		$this->db->select("u.id,CONCAT(u.first_name,' ',u.last_name) name,r.name as role_name");
		$this->db->from('users u');
		$this->db->join('role r','r.id=u.role_id','inner');
		if(count($where)>0){
			$this->db->where($where);
		}
		$this->db->order_by('r.name');
		$result=$this->db->get();
		$response=$result->result_array();
 		return $response;
	}
 
	public function manageUsersAddressAjax($post,$count=false){
		$user_id=$post['user_id'];
		$search=trim($post['search']);
		$country_id=$post['country_id'];
		$state_id=$post['state_id'];
		$city_id=$post['city_id'];
		$status=$post['status'];

		$where['ua.is_deleted']=0;
		if($country_id>0){
			$where['ua.country']=$country_id;
		}
		if($user_id>0){
			$where['ua.user_id']=$user_id;
		}
		if($state_id>0){
			$where['ua.state']=$state_id;
		} 
		if($city_id>0){
			$where['ua.city']=$city_id;
		}
		if($status!=''){
			$where['ua.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
 			$like['ua.address']=$search;
			$like['ua.street']=$search;
			$like['ua.block']=$search;
			$like['ua.landmark']=$search;
			$like['ua.zip']=$search;
			$like['ua.phone']=$search;
			$like['ua.email']=$search;
		}
		$this->db->select("
		ua.*,CONCAT(u.first_name,' ',u.last_name) as name,c.name as country_name,s.name as state_name,city.name as city_name
		");

		$this->db->from('user_address ua');
		$this->db->join('users u ','u.id=ua.user_id','inner');
		$this->db->join('countries c','c.id=ua.country','left');
		$this->db->join('states s','s.id=ua.state','left');
		$this->db->join('cities city','city.id=ua.city','left');
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
					$order_by = 'name';
					break;
				case 2:
					$order_by = 'ua.email';
					break;
				case 3:
					$order_by = 'ua.phone';
					break;
				case 4:
					$order_by = 'c.name';
				break;
				case 5:
					$order_by = 's.name';
					break;
				case 6:
					$order_by = 'city.name';
					break;
				case 7:
					$order_by = 'ua.status';
					break;
				default:
					$order_by = 'ua.id';
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
			$this->db->group_by('ua.id');
		$this->db->order_by($order_by,$dir_by); 
	}else{
		$this->db->group_by('ua.id');
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

	public function addressData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select('*');
			$this->db->from('user_address');
			$result=$this->db->get();
			$response=$result->row_array();
			return $response;
		}
	}
 	
	public function viewUserAddress($where){
		if(count($where)>0){
			$this->db->select("
				ua.*,
				concat(u.first_name,' ',u.last_name) user_name,
				c.name as country_name,
				s.name as state_name,
				city.name as city_name
			");
			$this->db->from('user_address ua');
			$this->db->join('users u','u.id=ua.user_id','inner');
			$this->db->join('countries c','c.id=ua.country','left');
			$this->db->join('states s','s.id=ua.state','left');
			$this->db->join('cities city','city.id=ua.city','left');
			$this->db->where($where);
			$result=$this->db->get();
			$response=$result->row_array();
 			return $response;
		}
	}
	
	public function manageSubscribersAjax($post,$count=false){
 		$search=trim($post['search']);
		$where['s.is_deleted']=0;

		$like=array();
		if(strlen($search)>0){
			$like['s.email']=$search;
		}
		$this->db->select("s.id,s.email,DATE_FORMAT(s.added_date, '%d-%m-%Y %H:%i') added_date
		");

		$this->db->from('subscribers s');
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
					$order_by = 's.email';
					break;

				case 2:
					$order_by = 's.added_date';
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
			$this->db->group_by('s.id');
		$this->db->order_by($order_by,$dir_by); 
	}else{
		$this->db->group_by('s.id');
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

	
	public function manageServiceCategoriesAjax($post,$count=false){
		$search=trim($post['search']);
		$status=$post['status'];
 		$where['sc.is_deleted']=0;
		if($status!=''){
			$where['sc.status']=$status;
		}  

		$like=array();
		if(strlen($search)>0){
			$like['sc.name']=$search;
 		}
		
		$this->db->select("
			sc.*
		");

		$this->db->from('service_category sc');
 
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
					$order_by = 'sc.name';
					break;
				case 3:
					$order_by = 'sc.status';
					break;
				 
				default:
					$order_by = 'sc.id';
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
	public function serviceCategoryData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select('*');
			$this->db->from('service_category sc');
			$result=$this->db->get();
			$response=$result->row_array();
			return $response;
		}
	}

	public function manageServiceProviderServicesAjax($post,$count=false){
 		$search=trim($post['search']);
		$status=$post['status'];
		$service_provider_id=$post['service_provider_id'];
		$service_category_id=$post['service_category_id'];
		$where['sps.is_deleted']=0;
		if($service_provider_id>0){
			$where['sps.service_provider_id']=$service_provider_id;
		}

		if($service_category_id>0){
			$where['sps.service_category_id']=$service_category_id;
		}

		if($status!=''){
			$where['sps.status']=$status;
		}  

		$like=array();
		if(strlen($search)>0){
			$like['sps.name']=$search;
			$like['sps.description']=$search;
 		}
		
		$this->db->select("
			sps.id,
			sps.service_provider_id,
			sps.service_category_id,
			sps.name,
			sps.price,
			sps.description,
			DATE_FORMAT(sps.added_date, '%d-%m-%Y %H:%i') added_date,
			sps.image,sps.status,
			sc.name as service_category_name,
			CONCAT(u.first_name,'',u.last_name) service_provider_name
		");
		$this->db->from('service_provider_services sps');
		$this->db->join('service_category sc','sc.id=sps.service_category_id'); 
		$this->db->join('users u','u.id=sps.service_provider_id'); 
 

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

				case 3:
				$order_by = 'sps.name';
				break;
				
				case 4:
				$order_by = 'sc.name';
				break;
				
				case 5:
				$order_by = 'service_provider_name';
				break;
				
				case 6:
				$order_by = 'sps.price';
				break;
				
				case 7:
				$order_by = 'sps.added_date';
				break;
				
				case 8:
				$order_by = 'sps.status';
				break;
				
				default:
				$order_by = 'sps.id';
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
	

	public function serviceData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select("
			sps.id,
			sps.service_provider_id,
			sps.service_category_id,
			sps.name,
			sps.price,
			sps.description,
			DATE_FORMAT(sps.added_date, '%d-%m-%Y %H:%i') added_date,
			sps.image,sps.status,
			sc.name as service_category_name,
			CONCAT(u.first_name,'',u.last_name) service_provider_name
		");
		$this->db->from('service_provider_services sps');
		$this->db->join('service_category sc','sc.id=sps.service_category_id'); 
		$this->db->join('users u','u.id=sps.service_provider_id'); 
		$result=$this->db->get();
		$response=$result->row_array();
		return $response;
		}
	}
	

	
}
