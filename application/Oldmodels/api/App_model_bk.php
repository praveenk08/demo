<?php
class App_model extends CI_Model{
    public function __construct(){
        $this->load->database();
    } 

public function loginCheck($where)
    {
		$this->db->select("u.*,ua.id as address_id,ua.address,ua.street,ua.latitude,ua.longitude");
		$this->db->from('users u');
		$this->db->join('user_address ua','ua.user_id=u.id','left');
		$this->db->where($where);
		$this->db->group_by('u.id');
		$this->db->order_by('ua.id','DESC');
        $result = $this->db->get();
        $resultArray = $result->row_array();
        return $resultArray;
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
    
     public function AddUpdateData($table,$save_data){
		if(!empty($table) && count($save_data)>0){
			if($save_data['id']>0){
				$this->db->where('id',$save_data['id']);
				$this->db->update($table,$save_data);
  				$response= $save_data['id'];
			}else{
				$this->db->insert($table,$save_data);
  				$response= $this->db->insert_id();
            }
            return $response;
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

	public function getSingleTableData($table,$where){
		if(!empty($table)){
			if(count($where)>0){
				$this->db->where($where);
			}
			$this->db->order_by('id','DESC');
			$result=$this->db->get($table);
			return $result->result_array();
		}
	}
	
	function getData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select("u.*,r.name as role_name,ua.id as address_id,ua.address,ua.street,ua.block");
			$this->db->from('users u');
			$this->db->join('role r ','r.id=u.role_id','inner');
			$this->db->join('user_address ua','ua.user_id=u.id','left');
			$this->db->order_by('ua.id','DESC');
			$this->db->limit(1);
			$result=$this->db->get();
			$response=$result->result_array();
			return $response;
		}
	}
 
	 
	public function autoSuggestionProduct($name){
		//if(!empty($name)){
			//$this->db->like('pm.name',$name);
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
	//	}
	}

	public function productData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select("
			pm.id as master_product_id,
			pm.name,
  			vp.meta_title,
			vp.meta_keywords,
			vp.meta_description,
 			u.name as unit_name,
			vp.quantity,
			DATE_FORMAT(vp.maturity_date, '%d-%m-%Y') maturity_date,
			vp.id,
			vp.price,
			vp.unit_id,
			vp.unit_value,
			vp.vendor_id,
			vp.weight,
			vp.image,
			vp.status,
			vp.added_date ,
			CONCAT(user.first_name,' ',user.last_name	) as vendor_name,
			group_CONCAT(pc.category_id) as product_categories,
			group_CONCAT(c.name) as product_categories_name,
		");
		$this->db->from('vendor_products vp');
		$this->db->join('product_master pm','pm.id=vp.product_id','inner');
		$this->db->join('users user','user.id=vp.vendor_id','inner');
 		$this->db->join('units u','u.id=vp.unit_id','inner');
		$this->db->join('product_category pc','pc.product_id=pm.id','left');
		$this->db->join('category c','c.id=pc.category_id','left');
		$result=$this->db->get();
		$response=$result->row_array();
		return $response;
		}
	}

	public function productNamedata($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select("
			pt.id,
			pt.vendor_product_id,
			pt.	product_id,
			pt.vendor_id,
			pt.abbr,
			pt.name,
			DATE_FORMAT(vp.maturity_date, '%d-%m-%Y') maturity_date,
			pt.brief,
			pt.description,
			l.name as language_name
		");
		$this->db->from('vendor_products vp');
		$this->db->join('product_translator pt','pt.vendor_product_id=vp.id','inner');
		$this->db->join('languages l','l.abbr=pt.abbr','inner');
 		 $result=$this->db->get();
			$response=$result->result_array();
			return $response;
		}
	}

	

	public function manageProducts($condition=array()){
		$this->db->select("
			pt.name,
 			pm.id as master_product_id,
 			u.name as unit_name,
			vp.quantity,
			vp.id,
			vp.price,
			vp.unit_value,
			vp.weight,
			DATE_FORMAT(vp.maturity_date, '%d-%m-%Y') maturity_date,
			vp.image,
			vp.status,
			pt.brief,
			c.name as category_name,
			pt.description,
			l.name as language_name,
			l.abbr,
			CONCAT(user.first_name,' ',user.last_name	) as vendor_name
		");
		$this->db->from('vendor_products vp');
		$this->db->join('product_master pm','pm.id=vp.product_id','inner');
		$this->db->join('users user','user.id=vp.vendor_id','inner');
		$this->db->join('product_translator pt','pt.vendor_product_id=vp.id','inner');
		$this->db->join('units u','u.id=vp.unit_id','inner');
		$this->db->join('product_category pc','pc.product_id=pm.id','inner');
		$this->db->join('category c','c.id=pc.category_id','inner');
		$this->db->join('languages l','l.abbr=pt.abbr','inner');
  
 		if(count($condition['where'])>0){
			$this->db->where($condition['where']);
		}
 
		$start=$condition['start'];
		$length=$condition['length'];
		if(!$start){
			$start=0;
		}
		if(!$length){
			$length=100;
		}
		$this->db->group_by('vp.id');
		$this->db->order_by('vp.id','DESC');
		$this->db->limit($length,$start);
		$result = $this->db->get();
 		return $result->result_array();	
	 
	}
 
	public function productGalleryImages($where){
		if(count($where)>0){
			$this->db->where($where);
			$result=$this->db->get('product_images');
			$response=$result->result_array();
			return $response;
		}
	}
	public function fetchFaqData($where,$like=array()){
		if(count($where)>0){
			$this->db->where($where);
		}
		if(count($like)>0){
			$this->db->group_start();
			$this->db->or_like($like);
			$this->db->group_end();
		}
		$this->db->order_by('id','desc');
		$result=$this->db->get('faq');
		$total=$result->num_rows();
 		if($total>0){
			return $result->result_array();	
		}
		return array();
	}
	
 
	function getLatestVendorList($params = array()){
		if(!empty($params['latitude'])){
			$this->db->select('u.id,u.slug,u.first_name,u.last_name,u.firm_description,u.image,ua.address,ua.zip,pc.category_id,ua.id as address_id,ua.address,ua.street,ua.latitude,ua.longitude, 111.1111*DEGREES(acos( cos( radians('.$params['latitude'].') ) * cos( radians( ua.latitude ) ) * cos( radians( '.$params['longitude'].' ) - radians(ua.longitude) ) + sin( radians('.$params['latitude'].') ) * sin( radians(ua.latitude ) ) ) ) as from_distance');
			$this->db->having('from_distance <', '50');
		}else{
			$this->db->select("u.id,u.slug,u.first_name,u.last_name,u.firm_description,u.image,ua.address,ua.zip,pc.category_id,ua.id as address_id,ua.address,ua.street,ua.latitude,ua.longitude");
		}
 		$this->db->from('users u');
		$this->db->join('vendor_products vp','vp.vendor_id=u.id','INNER');
		$this->db->join('product_master pm','pm.id=vp.product_id','INNER');
		$this->db->join('product_category pc','pc.product_id=pm.id','INNER');
		$this->db->join('user_address ua','ua.user_id=u.id','LEFT');
		
 
    	if(count($params['where'])>0){
            $this->db->where($params['where']);
		}
		
		//if(count($params['where_in'])>0){
       //     $this->db->where_in('pc.category_id',$params['where_in']);
		//}
 
		$this->db->group_by('u.id');
		$this->db->order_by('u.id','DESC');
		$result = $this->db->get();
		$response=$result->result_array();
         return $response;
	}
	

	
		

	public function fetchCmsData($where){
		if(count($where)>0){
			$this->db->where($where);
		}
		$result=$this->db->get('cms_pages');
		$total=$result->num_rows();
 		if($total>0){
			return $result->result_array();	
		}
		return array();
	}
	public function getMinMaxProductPrice(){
		$this->db->select("min(price) main_price,max(price) max_price");
		$this->db->from('vendor_products');
		$result=$this->db->get();
		return $result->result_array();	
	}	

	function totalCartItem($user_id){
		$this->db->select("count(cd.cart_detail_id) as total_cart");
		$this->db->from('add_to_cart c');
		$this->db->join('cart_details cd ','cd.cart_id=c.cart_id','INNER');
		$this->db->where('c.user_id',$user_id);
		$result=$this->db->get('cart');
		$response=$result->row_array()['total_cart'];
		return $response;
	}

	function addProductToCart($data){
		$this->db->where('user_id',$data['user_id']);
		$this->db->select('cart_id');
		$result=$this->db->get('add_to_cart');
		$cart_id=$result->row_array()['cart_id'];
		if(!$cart_id){
			$this->db->insert('add_to_cart',array('user_id'=>$data['user_id']));
			$cart_id=$this->db->insert_id();
		}
		$this->db->where(array('product_id'=>$data['product_id'],'cart_id'=>$cart_id));
		$this->db->select('product_id');
		$result=$this->db->get('cart_details');
		$product_id=$result->row_array()['product_id'];
		if(!$product_id){
			$cart_detail_id=$this->db->insert('cart_details',array('product_id'=>$data['product_id'],'quantity'=>$data['quantity'],'cart_id'=>$cart_id));
		 }else{
			$this->db->where(array('product_id'=>$data['product_id'],'cart_id'=>$cart_id));
			$cart_detail_id=$this->db->update('cart_details',array('product_id'=>$data['product_id'],'quantity'=>$data['quantity'],'cart_id'=>$cart_id));
		 }
	}

	function UpdateQuantityProductToCart($data){
		$this->db->where(array('cart_detail_id'=>$data['cart_detail_id']));
		return $this->db->update('cart_details',array('quantity'=>$data['quantity']));
	}

	function RemoveProductToCart($data){
		$this->db->where('cart_detail_id',$data['cart_detail_id']);
		return $this->db->delete('cart_details');
	 }
	 
	 function cartList($where){
		if(count($where)>0){
			$this->db->select("
			c.cart_id,
			cd.cart_detail_id,
			cd.product_id,
			cd.quantity,
			vp.price,
			vp.slug,
			vp.image,
			vp.quantity as available_quantity,
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

}

 