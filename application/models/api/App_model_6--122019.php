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

	function providerServiceCategory($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select('sc.id,sc.slug,sct.name');
			$this->db->from('service_category sc');
			$this->db->join('service_category_translator sct','sct.category_id=sc.id','INNER');
			 $result=$this->db->get();
			return $result->result_array();
		}
	}

	
	function getData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select("u.*,r.name as role_name,ua.id as address_id,ua.address,ua.street,ua.block,ua.country,ua.state,ua.city,
			c.name as country_name,
			s.name as state_name,
			city.name as city_name
			");
			$this->db->from('users u');
			$this->db->join('role r ','r.id=u.role_id','inner');
			$this->db->join('user_address ua','ua.user_id=u.id','left');
			$this->db->join('countries c','c.id=ua.country','left');
			$this->db->join('states s','s.id=ua.state','left');
			$this->db->join('cities city','city.id=ua.city','left');
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
 			ut.name as unit_name,
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
		$this->db->join('unit_translator ut','u.id=ut.unit_id','inner');
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
			vp.totalsale,
 			pm.id as master_product_id,
 			ut.name as unit_name,
			vp.quantity,
			vp.id,
			vp.price,
			vp.unit_value,
			vp.weight,
			DATE_FORMAT(vp.maturity_date, '%d-%m-%Y') maturity_date,
			vp.image,
			vp.status,
			pt.brief,
			ct.name as category_name,
			c.id category_id,
			ct2.id parent_category_id,
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
		$this->db->join('unit_translator ut','u.id=ut.unit_id','inner');
		$this->db->join('product_category pc','pc.product_id=pm.id','inner');
		$this->db->join('category c','c.id=pc.category_id','inner');
		$this->db->join('category_translator ct','c.id=ct.category_id','inner');
		$this->db->join('category_translator ct2','ct2.category_id=c.parent_id','left');
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
 		if(!empty($condition['order_by'])){
 			$this->db->order_by($condition['order_by'],'DESC');
 		}
 		
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


	public function fetchFaqData($where){
      		$this->db->select("f.*, ft.abbr , ft.question , ft.answer ");		
      		$this->db->from('faq f');
      		$this->db->join('faq_translator ft' ,'ft.faq_id=f.id','inner');
      		$this->db->where($where);
      		$result = $this->db->get();
      		return $result->result_array();
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
		$this->db->select("cp.id , pt.abbr , pt.name , pt.meta_description, pt.meta_title ,pt.description");
		$this->db->from('cms_pages cp');
		$this->db->join('page_translator pt','pt.page_id=cp.id','INNER');
		$this->db->where($where);
		$result=$this->db->get();	
		return $result->result_array();
		
	}
	

	function totalCartItem($userid){
		$this->db->select("count(cd.cart_detail_id) as total_cart");
		$this->db->from('add_to_cart c');
		$this->db->join('cart_details cd ','cd.cart_id=c.cart_id','INNER');
		$this->db->where('c.user_id',$userid);
		$result=$this->db->get('cart');
		//echo $this->db->last_Query();
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

	 function totalWishList($user_id){
		$this->db->select("count(wish.id) as total_wish");
		$this->db->from('add_to_wishlist wish');
 		$this->db->where('wish.user_id',$user_id);
		$result=$this->db->get();
		$response=$result->row_array()['total_wish'];
 		return $response;
	}
	 
	 function cartList($where){
		if(count($where)>0){
			$this->db->select("
			c.cart_id,
			cd.cart_detail_id,
			cd.product_id,
			cd.quantity,
			vp.vendor_id,
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
	
	function createOrder($address_id,$payment_type,$order_total,$transaction_id,$userid,$abbr)
	{
		$this->db->trans_strict(TRUE);
		$this->db->trans_start();
		$addr_id=0;
		$order_id=0;
		$msg="0";
		
		$response['status']=false;
		$response['reponse']="";
		$response['orderid']=0;
		
		//check if item exist on cart then insert the data in order table
		$where=array(
				'pt.abbr'=>$abbr,
				'c.user_id'=>$userid,
 			);
		$total_cart_item=$this->totalCartItem($userid);	
		if($total_cart_item>0){	
			//insert data in order table
			 if (!$this->db->insert('orders', array(
				'customer_id' => $userid,         								
				'payment_type' => $payment_type,			
				'transaction_id' => $transaction_id,				
				'total_amount' => $order_total,				
				'total_product' => $total_cart_item				
			))){
				log_message('error', print_r($this->db->error(), true));
				$response['reponse']="Error in inserting order";
				} else {					
					$order_id=$this->db->insert_id();
					$response['orderid']=$order_id;	
					//get the data from address table 
					$this->db->where('id', $address_id);		
					$addquery = $this->db->get('user_address');	
					if($addquery->num_rows()>0){
						$post= $addquery->result_array()[0];
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
							'phone'=>$post['phone'],				
							'address_type'=>$post['address_type'],
							'latitude'=>$post['latitude'],
							'longitude'=>$post['longitude']
							); 
							 //insert the data in order address table
							if(!$this->db->insert('order_address',$data)){
								log_message('error', print_r($this->db->error(), true));
								$response['reponse']="Error in inserting address";
							} else{
								$addr_id=$this->db->insert_id();								
								$cartdata=$this->cartList($where);
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
									'name'=>$cart['name']
									);
									if(!$this->db->insert('order_details',$pdata)){
									log_message('error', print_r($this->db->error(), true));
									$response['reponse']="Error in inserting order product";
									} else{
										
										$this->db->query('UPDATE vendor_products SET totalsale=totalsale+'.$cart['quantity'].' WHERE id ='.$cart['product_id']);
										
										$this->db->query('UPDATE vendor_products SET quantity=quantity-'.$cart['quantity'].' WHERE id ='.$cart['product_id']);
										$this->db->where('cart_detail_id',$cart['cart_detail_id']);										
										 if (!$this->db->delete('cart_details')) {
														log_message('error', print_r($this->db->error(), true));
														$response['reponse']="Error in delete cart product";
										 }
										 $msg=$order_id;
									}
							 }
					}
				}
			}
			$this->db->trans_complete();
			
			/* if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
			} else {
				$this->db->trans_commit();
			} */
			$response['status']=true;
			$response['reponse']="Order Created Successfully";
			
		} else {
			
			$response['reponse']="No item in cart";
		}
		return $response;
	}
	
	function addressData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select("ua.*,
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
			$this->db->order_by('ua.id','DESC');
			$query = $this->db->get();
			return ($query->num_rows() > 0)?$query->result_array():array();
		}
      }

      
	
	function providerServiceList($where){
 		 $this->db->select("
		 sps.id,
		 sps.service_provider_id,
		 sps.service_category_id,
		 spst.name,
		 sps.price,
		 spst.description,
		 sps.image,
		 sps.status,
		 sct.name as category_name
		 ");
		 $this->db->from('service_provider_services sps');
		 $this->db->join('service_provider_service_translator spst','sps.id=spst.service_id');   
 		 $this->db->join('service_category sc','sc.id=sps.service_category_id','INNER');
		 $this->db->join('service_category_translator sct','sc.id=sct.category_id','INNER'); 
		 if(count($where)>0){
			 $this->db->where($where);
		 }
		$this->db->order_by('sps.id','DESC');
		$result = $this->db->get();
 		return $result->result_array();
 	 }


  
	function getProducts($params = array()){
    	$this->db->select("
		DISTINCT(vp.id) as vendor_product_id,
		vp.slug,
		ct.name category_name,
		pt.name,
		pt.description,
		pt.brief,
		vp.image,
		DATE_FORMAT(vp.maturity_date,'%d-%m-%Y') maturity_date,
		vp.price,
		(select wish.product_id  from add_to_wishlist wish where wish.product_id=vp.id and wish.user_id=".$params['user_id'].") as wish_product_id,
		(select cd.product_id  from cart_details cd 
		INNER JOIN add_to_cart ac ON ac.cart_id=cd.cart_id
		where cd.product_id=vp.id and ac.user_id=".$params['user_id'].") as cd_product_id,
		(select cd.quantity  from cart_details cd 
		INNER JOIN add_to_cart ac ON ac.cart_id=cd.cart_id
		where cd.product_id=vp.id and ac.user_id=".$params['user_id'].") as cd_cart_quantity,
		(select FORMAT(AVG(rr.rating),1)  from review_rating rr where rr.vendor_product_id=vp.id and rr.status=1 and rr.is_deleted=0) as average_review,
		");
		$this->db->from('vendor_products vp');
		$this->db->join('product_master pm','pm.id=vp.product_id','INNER');
		//$this->db->join('product_category pc','pc.product_id=pm.id','INNER');
		$this->db->join('product_translator pt','pt.vendor_product_id=vp.id','INNER');
		$this->db->join('users u','u.id=vp.vendor_id','INNER');
		$this->db->join('product_category pc','pc.product_id=pm.id','LEFT');
		$this->db->join('category c','c.id=pc.category_id','LEFT');
		$this->db->join('category_translator ct','c.id=ct.category_id','INNER');
		$this->db->join('user_address ua','ua.user_id=u.id','LEFT');
  	    if(count($params['where'])>0){
			$this->db->where($params['where']);
		}
		if(count($params['where_in'])>0){
			$this->db->where_in('pc.category_id',$params['where_in']);
		}
		$this->db->group_by(array('vp.id','pt.vendor_product_id','vp.product_id','ua.user_id'));
		$this->db->order_by('vp.id','DESC');
		$result=$this->db->get();
		$response=$result->result_array();
 		return $response;
	}

	function getCoustmerOrders($params = array()){
        $this->db->select("
            o.order_id,
            DATE_FORMAT(o.added_date,'%d-%m-%Y %H:%i') order_date,
            vp.image,
            pt.name,
            od.quantity,
            od.price,
            os.name as order_status,
            ut.name as unit_name,
            oa.address as order_address,
            oa.block as order_block,
            oa.zip as order_zip,
        ");

        $this->db->from('orders o');
        $this->db->join('order_details od','o.order_id=od.order_id');
        $this->db->join('vendor_products vp','vp.id=od.product_id');
        $this->db->join('product_master pm','pm.id=vp.product_id');
        $this->db->join('product_translator pt','pt.vendor_product_id=vp.id');
        $this->db->join('order_address oa','oa.order_id=o.order_id');
        $this->db->join('order_status os','os.id=od.status');
        $this->db->join('units unit','vp.unit_id=unit.id','LEFT');
        $this->db->join('unit_translator ut','ut.unit_id=unit.id','LEFT');
        if(count($params['where'])>0){
            $this->db->where($params['where']);
        }   
        $this->db->order_by('o.order_id','DESC');
        $result = $this->db->get();
        $response=$result->result_array();
        return $response;
    }

    public function getVendorOrder($where){ 
	    if(count($where)>0){
	    	$this->db->select("
            o.order_id,
            o.transaction_id,
            o.customer_id,
            o.payment_status,
            sum(od.price*od.quantity) total_amount,
            sum(od.quantity) total_product_quantity,
            count(od.order_id) total_product,
            o.shipping_id,
            DATE_FORMAT(o.added_date,'%d-%m-%Y %H:%i') order_date,
            CONCAT(user.first_name,' ', user.last_name) customer_name,
			os.name order_status,
            os.class
		");
		$this->db->from("orders o");
		$this->db->join('order_details od','od.order_id=o.order_id','inner');
		$this->db->join('users user','user.id=o.customer_id','inner');
 		$this->db->join('order_status os','os.id=o.order_status','inner');
 		
 		$this->db->where($where);
 		$this->db->group_by('o.order_id');

		$result = $this->db->get();
		//echo $this->db->last_query();
		$resultArray = $result->result_array();	
		return $resultArray;
		
	    	}
		}


		public function getVendorOrderDetails($where){
        if(count($where)>0){
          $this->db->select("
            pm.sku,
            pm.name,
            vp.image,
            od.quantity,
            od.price,
            CONCAT(user.first_name,' ', user.last_name) vendor_name,
            ");
            $this->db->from('order_details od');
            $this->db->join('vendor_products vp','vp.id=od.product_id');
            $this->db->join('product_master pm','pm.id=vp.product_id');
            $this->db->join('users user','user.id=vp.vendor_id','inner');
            $this->db->where($where);
            $result=$this->db->get();
            //$this->db->last_query();
		    $response=$result->result_array();
            return $response;
        }
    }



    public function getCustomerOrderList($where){
    	$this->db->select("
	    	od.price,
	    	od.quantity,
	    	od.name,
	    	CONCAT(u.first_name,'',u.last_name) vendor_name,
       		");
    	// $this->db->from('order_details od');
    	// $this->db->join('')
    	$result=$this->db->get('order_details');
    //echo $this->db->last_query();
    $response=$result->result_array();
    return $response;
    }

    public function getTransationList($where){
    	$this->db->select("
    		p.transaction_id,
    		p.amount,
    		p.added_date,
    		p.order_id
    		");
    	$this->db->from('payments p');
    	$this->db->join('orders o','o.order_id=p.id' ,'left');
    	//$this->db->where($where);
    	$result=$this->db->get();
    	//echo $this->db->last_query();
    	$response= $result->result_array();
    	return $response;
    }
 
	
	function matchingAndConnections($params = array()){
        $status=$this->input->post('status');
        $product_ids='';
        $wh_con="";
        if($status!=''){
            if($status==1){
                $wh_con=" and pmc.status=1";
             }else{
                $this->db->select("group_concat(pmc2.product_id) as product_ids");
                $this->db->where(array('pmc2.status'=>1,'pmc2.customer_id'=>$params['customer_id']));
                $this->db->from('product_matching_and_connections pmc2');
                $res=$this->db->get();
                $product_ids=$res->row_array()['product_ids'];
             }
        }

       $this->db->select("
       DISTINCT(vp.id) as vendor_product_id,
       vp.slug,
       pt.name,
       c.name category_name,
	   c2.name parent_category_name,
       vp.image,
       vp.price,
       CONCAT(u.first_name,' ',u.last_name) as vendor_name,
       ifnull((select pmc.status status  from product_matching_and_connections pmc where pmc.product_id=vp.id ".$wh_con." and pmc.customer_id=".$params['customer_id']."
		),0) as status
       ");
       $this->db->from('vendor_products vp');
       $this->db->join('product_master pm','pm.id=vp.product_id','INNER');
       $this->db->join('product_category pc','pc.product_id=pm.id','INNER');
       $this->db->join('category c','c.id=pc.category_id','INNER');
       $this->db->join('category c2','c2.id=c.parent_id','LEFT');
       $this->db->join('product_translator pt','pt.vendor_product_id=vp.id','INNER');
       $this->db->join('users u','u.id=vp.vendor_id','INNER');
       if($status==1){
        $this->db->join('product_matching_and_connections pmc3','pmc3.product_id=vp.id and pmc3.customer_id='.$params['customer_id'],'INNER');
       }
        $this->db->join('user_address ua','ua.user_id=u.id','LEFT');
         if(count($params['where'])>0){
           $this->db->where($params['where']);
       }
       if($status==1){
        $this->db->where('pmc3.status',$status);
       }
       if(!empty($product_ids)){
        $this->db->where_not_in('vp.id', explode(',',$product_ids));
        }
       if(count($params['where_in'])>0){
           $this->db->where_in('pc.category_id',$params['where_in']);
       }
    
       $this->db->group_by(array('vp.id'));
       $this->db->order_by('vp.id','DESC');
       $query = $this->db->get();
       return ($query->num_rows() > 0)?$query->result_array():array();
   }


   	public function fetchVehicleDetails($where){
   		    	if(count($where)){
				$this->db->where($where);
				$this->db->from('delivery_boy_vehicle_details vd');
				$result=$this->db->get();
				$response=$result->row_array();
				return $response;
		}
	

	}

	public function vendorSalesOrdersReport($where){ 
	$this->db->select("
	count(o.order_id) as total_orders,
	year(o.order_date) as year,
	sum(od.quantity*od.price) as  total_amount
	");
	$this->db->from("orders o");
	if(count($where)>0){
		$this->db->where($where);

	}
	$this->db->join('order_details od','od.order_id=o.order_id','inner');
	$this->db->join('order_status os','os.id=o.order_status','inner');
	if(count($where)>0){
	$this->db->group_by('year(order_date)');
	$result = $this->db->get();
	return $result->result_array();
	}
		
	}

	
}

 