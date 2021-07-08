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
		$this->db->select('u.*,ut.name');
		$this->db->from('units u');
		$this->db->join('unit_translator ut','ut.unit_id=u.id','INNER');
		$result=$this->db->get();
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
		$this->db->where('sct.abbr',$this->session->userdata('language'));
		$this->db->select('sc.id,sc.slug,sct.name');
		$this->db->from('service_category sc');
		$this->db->join('service_category_translator sct','sct.category_id=sc.id','INNER');
 		$result=$this->db->get();
		return $result->result_array();
	}
}

function getServices($where){
	if(count($where)>0){
		$this->db->where($where);
		$this->db->where('spst.abbr',$this->session->userdata('language'));
		$this->db->select("sps.id,sps.slug,spst.name");
		$this->db->from('service_provider_services sps');
		$this->db->join('service_provider_service_translator spst','spst.service_id=sps.id','inner');	
 		$result=$this->db->get();
		return $result->result_array();
	}
}
 
function getFacilitiesData($where){
	if(count($where)>0){
		$this->db->where($where);
 		$this->db->select("f.id,ft.name,f.image");
		$this->db->from('facilities f');
		$this->db->join('facilities_translator ft','ft.facility_id=f.id','inner');	
		$this->db->order_by('sort_id','ASC');
 		$result=$this->db->get();
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
	$this->db->select('c.*,ct.name');
	$this->db->from('category c');
	$this->db->join('category_translator ct','ct.category_id=c.id','INNER');
	$result=$this->db->get();
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

	public function vendorOrderDetails($where){
		if(count($where)>0){
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
			$this->db->join('users user','user.id=vp.vendor_id','inner');
			$this->db->join('product_translator pt','pt.vendor_product_id=vp.id','INNER');
			$this->db->where($where);
			$result=$this->db->get();
			$response=$result->result_array();
			return $response;
		}
	}

	public function vendorList($order_id){
		if($order_id>0){
			$this->db->select("u.id as vendor_id,CONCAT(u.first_name,' ',u.last_name) as vendor_name, o.customer_id,u.email as vendor_email");
			$this->db->from('orders o');
			$this->db->join('order_details od','od.order_id=o.order_id','INNER');
			$this->db->join('users u','u.id=od.vendor_id','INNER');
			$this->db->where('o.order_id',$order_id);
			$this->db->group_by('u.id');
			$result=$this->db->get();
			$response=$result->result_array();
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
 
 public function getSingleTableData($table,$where=array(),$order_by=array()){
	if(!empty($table)){
		if(count($where)>0){
			$this->db->where($where);
		}
		if(count($order_by)>0){
			$this->db->order_by($order_by['key'],$order_by['value']);
		}
		$result=$this->db->get($table);
		return $result->result_array();
	}
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
public function getUserList($where){
	$this->db->select("DISTINCT(u.id),CONCAT(u.first_name,' ',u.last_name) name,r.name as role_name");
	$this->db->from('users u');
	$this->db->join('role r','r.id=u.role_id','inner');
	if(count($where)>0){
		$this->db->where($where);
	}
	$this->db->group_by('u.id');
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

public function getReviews($where){
	$this->db->select("
	rr.id,
	rr.rating,
	rr.review,
	DATE_FORMAT(rr.created_date,'%d-%m-%Y %H:%i') added_date,
	CONCAT(u.first_name,' ',u.last_name) customer_name
	");
	$this->db->from('review_rating rr');
	$this->db->join('users u','rr.customer_id=u.id');
	$this->db->where($where);
	$result=$this->db->get();
	$response=$result->result_array();
	return $response;
 }


public function getTotalProducts($where=array()){
		
	$this->db->select("
		pm.name,
		ut.name as unit_name,
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
	$this->db->join('unit_translator ut','u.id=ut.unit_id','inner');

	 if(count($where)>0){
		$this->db->where($where);
	}
	$this->db->group_by('vp.id');
	$result = $this->db->get();
	return $result->result_array();	
}

public function getVendorTotalNotifications($where=array()){
		
	$this->db->select("
		 count(cns.id) as total_notifications
	");
	$this->db->from('customer_notification_summary cns');
 	$this->db->join('users user','user.id=cns.customer_id','inner');
 
	 if(count($where)>0){
		$this->db->where($where);
	}
	$result = $this->db->get();
	return $result->row_array();	
}


public function getVendorTotalOrderNotifications($where=array()){
		
	$this->db->select("
		 count(von.id) as total_order_notifications
	");
	$this->db->from('vendor_order_notifications von');
  
	 if(count($where)>0){
		$this->db->where($where);
	}
	$result = $this->db->get();
	return $result->row_array();	
}





function createOrder($address_id,$payment_type,$order_total,$transaction_id,$customer_id)
	{
 		$this->db->trans_strict(TRUE);
		$this->db->trans_start();
		//$this->db->trans_begin();		
 		$addr_id=0;
		$order_id=0;
		$msg="startting..";
		
		//check if item exist on cart then insert the data in order table
		$total_cart_item=$this->totalCartItem($customer_id);	
 		if($total_cart_item>0){	
			//insert data in order table
			 if (!$this->db->insert('orders', array(
				'customer_id' => $customer_id,         								
				'payment_type' => $payment_type,			
				'transaction_id' => $transaction_id,				
				'total_amount' => $order_total,				
				'order_date' => date('Y-m-d'),				
				'total_product' => $total_cart_item				
			))){
				log_message('error', print_r($this->db->error(), true));
				} else {
 					$msg .="<br/> order master inserted";
					$order_id=$this->db->insert_id();
								
					//get the data from address table 
					$this->db->where('id', $address_id);		
					$addquery = $this->db->get('user_address');	
					if($addquery->num_rows()>0){
			
						$msg .="<br/> inserting address";
						$post= $addquery->row_array();
							$data = array(  
							'order_id' =>$order_id,	
							'name'    =>$post['name'],  
							'zip'  =>$post['zip'],  
							'street'=>$post['street'], 
							'block'=>$post['block'], 
							'address'=>$post['address'], 
							'country'=>$post['country'], 
							'state'=> $post['state'], 
							'city'=> $post['city'],   			
							'landmark'=> $post['landmark'],
							'email'=>$post['email'],				
							'phone'=>$post['phone'],				
							'address_type'=>$post['address_type'],
							'latitude'=>$post['latitude'],
							'longitude'=>$post['longitude']
							); 
							 //insert the data in order address table
							if(!$this->db->insert('order_address',$data)){
								log_message('error', print_r($this->db->error(), true));
							} else{
								$addr_id=$this->db->insert_id();
								$msg .="<br/>  address inserted";
								
								$cartdata=$this->cartList($customer_id,'en');
								$cart_id=0;
								foreach($cartdata as $cart){
									$cart_id=$cart['cart_id'];									
									$pdata = array(  				
									'order_id' =>$order_id,  
									'product_id' =>$cart['product_id'],  
									'quantity'    =>$cart['quantity'],  
									'vendor_id'  =>$cart['vendor_id'],  
									'price'=>$cart['price'], 
									'slug'=>$cart['slug'], 
									'image'=>$cart['image'], 
									'status'=>1, 
									'name'=>$cart['name']
									);
									if(!$this->db->insert('order_details',$pdata)){
									log_message('error', print_r($this->db->error(), true));
									} else{
										$msg .="<br/> order detail inserted ->".$cart['product_id'];
										$this->db->query('UPDATE vendor_products SET totalsale=totalsale+'.$cart['quantity'].' WHERE id ='.$cart['product_id']);
									 
									}
							 }
					}
				}
			}
			$this->db->trans_complete();
			 
		} else {
			
			$msg .="cart not found";
		}
 		$response=array('order_id'=>$order_id,'message'=>$msg);
 		return $response;
	}

	function cartList($user_id,$lan='en'){
		$where=array(
			'pt.abbr'=>$lan,
			'c.user_id'=>$user_id
		);
		if(count($where)>0){
			$this->db->select("
			c.cart_id,			
			cd.product_id,
			cd.cart_detail_id,
			cd.quantity,
			vp.vendor_id,
			vp.price,
			vp.slug,
			vp.image,			
			pt.name
		");
		$this->db->from('cart_details cd');
		$this->db->join('vendor_products vp', 'cd.product_id = vp.id', 'inner');
		$this->db->join('product_translator pt', 'vp.id = pt.vendor_product_id', 'inner');
		$this->db->join('add_to_cart c', 'c.cart_id = cd.cart_id', 'inner');
		$this->db->where($where);
		$this->db->group_by('cd.product_id');
		$result = $this->db->get();
		$response=$result->result_array();
		return $response;
		}
	}

	function totalCartItem($userid){
		$this->db->select("count(cd.cart_detail_id) as total_cart");
		$this->db->from('add_to_cart c');
		$this->db->join('cart_details cd ','cd.cart_id=c.cart_id','INNER');
		$this->db->where('user_id',$userid);
		$result=$this->db->get();
		$response=$result->row_array()['total_cart'];
		return $response;
	}

	function callBackOrderSales($customer_id,$status){
 		$this->db->select("
			c.cart_id,			
			cd.product_id,
			cd.cart_detail_id,
			cd.quantity,
			vp.totalsale
		");
		$this->db->from('add_to_cart c');
		$this->db->join('cart_details cd', 'c.cart_id = cd.cart_id', 'inner');
		$this->db->join('vendor_products vp', 'vp.id = cd.product_id', 'inner');
		$this->db->where('c.user_id',$customer_id);
		$this->db->group_by('c.cart_id');
		$result = $this->db->get();
		$product_data=$result->result_array();

		if(count($product_data)>0){
			foreach($product_data as $row){
				if(!$status){
					$quantity=$row['quantity'];
					$total_sale=$row['totalsale'];
					$actual_sale=$total_sale-$quantity;
					$this->db->where('id',$row['product_id']);
					$this->db->update('vendor_products',array('totalsale'=>$actual_sale));
				}
				$this->db->where('cart_detail_id',$row['cart_detail_id']);
				$this->db->delete('cart_details');
			}
			$this->db->where('cart_id',$row['cart_id']);
			$this->db->delete('add_to_cart');
		}
	}

	public function getAllChildCategoriesList($category_id){
		if(!empty($category_id)){
			$result=$this->db->query("select group_concat(id) as categories from (select * from category order by parent_id, id) category, (select @pv := ".$category_id.") initialisation where find_in_set(parent_id, @pv) > 0 and @pv := concat(@pv, ',', id )");
			$response=$result->row_array();
			return $response;
		}
	 }

	 public function getTotalVisitors($where=array()){

		$this->db->select("
		sum(vp.total_visitors) as Total_visitors
		");
		$this->db->from('vendor_products vp');
		$this->db->join('product_master pm','pm.id=vp.product_id','inner');
		$this->db->join('product_translator pt','pt.vendor_product_id=vp.id','inner');
		$this->db->join('languages l','l.abbr=pt.abbr','inner');
		$this->db->join('users user','user.id=vp.vendor_id','inner');
		$this->db->join('units u','u.id=vp.unit_id','inner');
		$this->db->join('unit_translator ut','u.id=ut.unit_id','inner');
		
		if(count($where)){
			$this->db->where($where);
		}
		$result=$this->db->get();
		$response=$result->row_array();
		return $response;
		 
	 }

	 
	
}

?>
