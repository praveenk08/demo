<?php class Common_model extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database(); 
	 }

	public function loginCheck($where)
	{
		 $this->db->where($where);
		 $result = $this->db->get('users');
		 $resultArray = $result->row_array();
 		 return $resultArray;
	}

	public function updateLogin($id){
		$this->db->where('id', $id);
      $this->db->update('users', array('last_login' => 'now()'));
	}

	function userData($where){
		if(count($where)>0){
			$this->db->where($where);
			$query=$this->db->get('users');
			$total_rows=$query->num_rows();
			if($total_rows==1){
				return 	$query->row_array();
			}
		}
	}
	
	function updateProfile($update_data){
		if(count($update_data)>0){
			$this->db->where('id',$update_data['id']);
			$result=$this->db->update('users',$update_data);
			return $result;
		}
	}

// SaveAndUpdate Common

public function AddUpdateData($table,$save_data){
	if(!empty($table) && count($save_data)>0){
		if($save_data['id']>0){
			$this->db->where('id',$save_data['id']);
			$this->db->update($table,$save_data);
			  return $save_data['id'];
		}else{
			$this->db->insert($table,$save_data);
			return $this->db->insert_id();
		}
	}
}



public function updateData($table,$where,$update_data){
	if(!empty($table) && count($update_data)>0){
		$this->db->where($where);
		$respnse=$this->db->update($table,$update_data);
		 return $respnse;
	}
}


//Delete Common
public function deleteRecord($where,$table){
	if(count($where)>0 && !empty($table)){
		$this->db->where($where);
		$result=$this->db->delete($table);
		return $result;
	}
	return false;
}
public function changeDataStatus($table,$update_data){
	if(count($update_data)>0 && !empty($table)){
		$this->db->where('id',$update_data['id']);
		$response=$this->db->update($table,$update_data);
		return $response;
	}
}

public function activityLog($save_data){
	$this->db->insert('activity_log',$save_data);
}


public function checkExist($table,$where){
	if(!empty($table) && count($where)>0){
		$this->db->where($where);
		$result=$this->db->get($table);
		$total_rows=$result->num_rows();
		if(!$total_rows){
			return true;
		}
		return false;
	}
}

function getCountryList($where){
	if(count($where)>0){
		$this->db->where($where);
	}
	$result=$this->db->get('countries');
	return $result->result_array();
}

function getLanguageList($where){
	if(count($where)>0){
		$this->db->where($where);
	}
	$result=$this->db->get('languages');
	return $result->result_array();
}


function changeCountryGetState($where){
	if(count($where)>0){
		$this->db->where($where);
		$result=$this->db->get('states');
		return $result->result_array();
	}
}

function changeStateGetCity($where){
	if(count($where)>0){
		$this->db->where($where);
		$result=$this->db->get('cities');
		return $result->result_array();
	}
}
function getBrandList($where){
	if(count($where)>0){
		$this->db->where($where);
		$result=$this->db->get('brands b');
		return $result->result_array();
	}
}
function getUnitList($where){
	if(count($where)>0){
		$this->db->where($where);
		$result=$this->db->get('units u');
		return $result->result_array();
	}
}
function getOrderStatus($where){
	if(count($where)>0){
		$this->db->where($where);
	}
 	$result=$this->db->get('order_status');
	return $result->result_array();

}
function getServicesCategories($where){
	if(count($where)>0){
		$this->db->where($where);
 		$result=$this->db->get('service_category sc');
		return $result->result_array();
	}
}

function getServices($where){
	if(count($where)>0){
		$this->db->where($where);
 		$result=$this->db->get('service_provider_services sps');
		return $result->result_array();
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

public function autoSuggestionProduct($name){
		if(!empty($name)){
			$this->db->like('pm.name',$name);
			$this->db->select("
			pm.name,
			vp.id as vendor_product_id,
			vp.vendor_id,
			CONCAT(user.first_name,' ' ,user.last_name) as vendor_name
			");
			$where=array(
				'pm.status'=>1,
				'vp.status'=>1,
				'user.status'=>1,
 				'pm.is_deleted'=>0,
				'vp.is_deleted'=>0,
				'user.is_deleted'=>0,
 			);
			$this->db->where($where);
			$this->db->from('product_master pm');
			$this->db->join('vendor_products vp','vp.product_id=pm.id','inner');
			$this->db->join('users user','user.id=vp.vendor_id','inner');
			$this->db->join('units u','u.id=vp.unit_id','inner');
			$this->db->join('product_category pc','pc.product_id=pm.id','left');
			$this->db->join('category c','c.id=pc.category_id','left');
			$this->db->group_by('vp.id');
			$this->db->order_by('vp.id','DESC');
			$this->db->limit(20);
			$result=$this->db->get();
			$response=$result->result_array();
			return $response;
		}
	}


	function getVenodrCustomerList($where){
		$this->db->select("
			u.id,CONCAT(u.first_name,' ',u.last_name) as name
		");

		$this->db->from('users u ');
		$this->db->join('user_address ua','u.id=ua.user_id','inner');
		$this->db->join('orders o','o.customer_id=u.id','inner');
		$this->db->join('order_details od','od.order_id=o.id','inner');
		$this->db->join('countries c','c.id=ua.country','left');
		$this->db->join('states s','s.id=ua.state','left');
		$this->db->join('cities city','city.id=ua.city','left');
		if(count($where)>0){
			$this->db->where($where);
		}
		$this->db->group_by('u.id');
		$result = $this->db->get();
		$resultArray = $result->result_array();	
		return $resultArray;
	}


	public function getOrderProducts($id){
        if($id>0){
            $this->db->where('od.order_id',$id);
            $this->db->where('pt.abbr','en');
            $this->db->select("
            pt.name,
            vp.image,
            od.quantity,
            od.price,
            CONCAT(user.first_name,' ', user.last_name) vendor_name,
            ");
            $this->db->from('order_details od');
            $this->db->join('vendor_products vp','vp.id=od.product_id');
			$this->db->join('product_master pm','pm.id=vp.product_id');
			$this->db->join('product_translator pt','pt.vendor_product_id=vp.id');
            $this->db->join('users user','user.id=vp.vendor_id','inner');
            $result=$this->db->get();
            $response=$result->result_array();
            return $response;
        }
    }
    public function getOrderAddress($id){
    if($id>0){
		$this->db->where('oa.order_id',$id);
		$this->db->select("
		oa.*,
		c.name as country_name,
		s.name as state_name,
		city.name as city_name
		");
		$this->db->from('order_address oa');
 		$this->db->join('countries c','c.id=oa.country','left');
		$this->db->join('states s','s.id=oa.state','left');
		$this->db->join('cities city','city.id=oa.city','left');
		$result=$this->db->get();
		$response=$result->row_array();
		return $response;
     }
 }

 public function getOrderData($where){
	 if(count($where)>0){
		$this->db->select("
		o.order_id,
 		o.total_amount,
		o.total_product,
		o.discount,
		user.first_name,
		user.last_name,
		user.phone customer_phone,
		oa.name,
		oa.email,
		oa.phone,
		oa.street,
		oa.address,
		oa.block,
		oa.landmark,
		oa.zip,
		c.name as country_name,
		c.iso3 as country_code,
		s.name as state_name,
		city.name as city_name
		");
		$this->db->from('orders o');
		$this->db->join('users user','user.id=o.customer_id','INNER');
		$this->db->join('order_address oa','oa.order_id=o.order_id','INNER');
		$this->db->join('countries c','c.id=oa.country','left');
		$this->db->join('states s','s.id=oa.state','left');
		$this->db->join('cities city','city.id=oa.city','left');
		$this->db->where($where);
		$result=$this->db->get();
		$response=$result->row_array();
		return $response;

	 }
 }
 public function getSingleTableData($table,$where=array(),$order_by=array('key'=>'name','value'=>'ASC')){
	if(!empty($table)){
		if(count($where)>0){
			$this->db->where($where);
		}
		$this->db->order_by($order_by['key'],$order_by['value']);
		$result=$this->db->get($table);
		return $result->result_array();
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


public function getMinMaxProductPrice(){
	$this->db->select("min(price) min_price,max(price) max_price");
	$this->db->from('vendor_products');
	$result=$this->db->get();
	return $result->result_array();	
}
public function getSettings(){
	$this->db->select("*");
	$this->db->from('website_settings');
	$result=$this->db->get();
	return $result->row_array();	
}


public function getVendorTotalSalesOrders($where=array()){ 
	$this->db->select("
	count(distinct(o.order_id)) as total_orders,
	sum(od.price*od.quantity) as total_sales
	");
	$this->db->from("orders o");
	$this->db->join('order_details od','od.order_id=o.order_id','inner');
	$this->db->join('users user','user.id=o.customer_id','inner');
	$this->db->join('order_status os','os.id=o.order_status','inner');
	if(count($where)>0){
		$this->db->where($where);
	}
	$result = $this->db->get();
	return $result->row_array();	
}

public function getTotalCustomers($where=array()){
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
	$this->db->group_by('u.id');
	$result = $this->db->get();
	return $result->result_array();	
}


public function getTotalProducts($where=array()){
		
	$this->db->select("
		pm.name,
		u.name as unit_name,
		vp.quantity,
		vp.id,
		vp.totalsale,
		vp.image,
		vp.price,
		vp.weight,
		vp.status,
		CONCAT(user.first_name,' ',user.last_name	) as vendor_name
	");
	$this->db->from('vendor_products vp');
	$this->db->join('product_master pm','pm.id=vp.product_id','inner');
	$this->db->join('product_translator pt','pt.vendor_product_id=vp.id');
	$this->db->join('users user','user.id=vp.vendor_id','inner');
 	$this->db->join('units u','u.id=vp.unit_id','inner');

	 if(count($where)>0){
		$this->db->where($where);
	}
	$this->db->group_by('vp.id');
	$result = $this->db->get();
	return $result->result_array();	

}

	
}

?>
