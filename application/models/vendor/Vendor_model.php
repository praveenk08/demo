<?php class Vendor_model extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database(); 
	 }

	 public function vendorAddress($where){
		if(count($where)>0){
			$this->db->select("
				ua.*,
 				c.name as country_name,
				s.name as state_name,
				city.name as city_name
			");
			$this->db->from('user_address ua');
 			$this->db->join('countries c','c.id=ua.country','left');
			$this->db->join('states s','s.id=ua.state','left');
			$this->db->join('cities city','city.id=ua.city','left');
			$this->db->where($where);
			$this->db->order_by('added_date','DESC');
			$this->db->limit(1);
			$result=$this->db->get();
			$response=$result->row_array();
 			return $response;
		}
	}

	 public function manageCustomersAjax($post,$count=false){
		$search=trim($post['search']);
  		$where['u.is_deleted']=0;
		$where['u.role_id']=3; 
		$where['od.vendor_id']=$this->session->userdata('vendor_data')['id']; 
		  
		$like=array();
		if(strlen($search)>0){
			$like['u.first_name']=$search;
			$like['u.last_name']=$search;
			$like["concat(u.first_name,'',u.last_name)"]=$search;
			$like['u.phone']=$search;
			$like['u.email']=$search;
 		}
		$this->db->select("
			u.id,
 			CONCAT(u.first_name,'  ',u.last_name) as name,
 			u.image,
			u.phone,
			u.email,
			u.status
		");

		$this->db->from('users u');
 		$this->db->join('orders o','o.customer_id=u.id','inner');
		$this->db->join('order_details od','od.order_id=o.order_id','inner');
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
					$order_by = 'u.email';
					break;
				case 3:
					$order_by = 'u.phone';
					break;
				 
				case 5:
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



	 public function manageCustomersExport($post,$count=false){
		$search=trim($post['search']);
  		$where['u.is_deleted']=0;
		$where['u.role_id']=3; 
		$where['od.vendor_id']=$this->session->userdata('vendor_data')['id']; 
		  
		$like=array();
		if(strlen($search)>0){
			$like['u.first_name']=$search;
			$like['u.last_name']=$search;
			$like["concat(u.first_name,'',u.last_name)"]=$search;
			$like['u.phone']=$search;
			$like['u.email']=$search;
 		}
		$this->db->select("
			CONCAT(u.first_name,'  ',u.last_name) as name,
			u.phone,
			u.email,
			u.status
		");

		$this->db->from('users u');
 		$this->db->join('orders o','o.customer_id=u.id','inner');
		$this->db->join('order_details od','od.order_id=o.order_id','inner');
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


	public function customerData($where){
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


	public function customerAddressListAjax($post,$count=false){
		$customer_id=$post['customer_id'];
		$search=trim($post['search']);
		$country_id=$post['country_id'];
		$state_id=$post['state_id'];
		$city_id=$post['city_id'];
		$status=$post['status'];

		$where['ua.is_deleted']=0;
		$where['u.is_deleted']=0;
		$where['u.role_id']=3; 
		$where['od.vendor_id']=$this->session->userdata('vendor_data')['id'];

		if($country_id>0){
			$where['ua.country']=$country_id;
		}
		if($customer_id>0){
			$where['ua.user_id']=$customer_id;
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
		$this->db->join('orders o','o.customer_id=u.id','inner');
		$this->db->join('order_details od','od.order_id=o.id','inner');
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
	
	
	public function manageNotificationsAjax($post,$count=false){
		$search=trim($post['search']);
		$where=array();
 		$change_type=$post['change_type'];
 		$where['cns.is_deleted']=0;
		$where['cns.customer_id']=$this->session->userdata('vendor_data')['id'];  
		if($change_type !=""){
			$where['cns.type']=$change_type;
		}  

		$like=array();
		if(strlen($search)>0){
			$like['cns.subject']=$search;
			$like['cns.type']=$search;
			$like['cns.message']=$search;
 		}
		
		$this->db->select("
		cns.*,CONCAT(u.first_name,' ',u.last_name) as name
		");

		$this->db->from('customer_notification_summary cns');
		$this->db->join('users u','u.id=cns.customer_id','INNER');
 
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
					$order_by = 'cns.type';
					break;
				case 2:
					$order_by = 'cns.subject';
					break;
				case 3:
					$order_by = 'cns.message';
					break;
				 
				default:
					$order_by = 'cns.id';
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
 		return $resultArray;
	}
	}
 
}
