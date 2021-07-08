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
			u.verified,
			u.phone,
			u.email,
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
			$like["CONCAT(u.first_name,' ',u.last_name)"]=$search;
			$like['u.phone']=$search;
			$like['u.email']=$search;
			$like['u.address']=$search;
		}
		$this->db->select("
			u.id,
			r.name as role_name,
			CONCAT(u.first_name,'  ',u.last_name) as name,
			count(ua.id) as total_address,
			u.image,
			u.phone,
			u.email,
			u.status
		");

		$this->db->from('users u');
		$this->db->join('role r','r.id=u.role_id','inner');
		$this->db->join('user_address ua','r.id=u.id','left');
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
					$order_by = 'r.name';
					break;
				case 3:
					$order_by = 'u.email';
					break;
				case 4:
					$order_by = 'u.phone';
					break;
				case 5:
					$order_by = 'total_address';
					break;

				case 7:
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



	
}
