<?php class CheckOutModel extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database();        	
	 }
	 
	 
	function createOrder($address_id,$payment_type,$order_total,$transaction_id)
	{
		$this->db->trans_strict(TRUE);
		$this->db->trans_start();
		//$this->db->trans_begin();		
        $userid=$this->session->userdata('user_session_id');
		$addr_id=0;
		$order_id=0;
		$msg="startting..";
		
		//check if item exist on cart then insert the data in order table
		$cart_details=$this->totalCartItem($userid);
		$total_cart_item=$cart_details['total_cart'];	
		if($total_cart_item>0){	
			//insert data in order table
			 if (!$this->db->insert('orders', array(
				'customer_id' => $userid,         								
				'payment_type' => $payment_type,			
				'transaction_id' => $transaction_id,				
				'total_amount' => $cart_details['total_cart_amount'],				
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
								
								$cartdata=$this->cartlist();
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
									//	$this->db->where('cart_detail_id',$cart['cart_detail_id']);										
										// if (!$this->db->delete('cart_details')) {
										//	slog_message('error', print_r($this->db->error(), true));
										// }else{
										//	$this->db->where('cart_id',$cart['cart_id']);	
										//	if (!$this->db->delete('add_to_cart')) {
										//		log_message('error', print_r($this->db->error(), true));
								 		//	}
										// }
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
		} else {
			
			$msg .="cart not found";
		}
		$response=array('order_id'=>$order_id,'message'=>$msg);
		return $response;
	}	
	
	function callBackOrderSales($status){
		$userid=$this->session->userdata('user_session_id');
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
		$this->db->where('c.user_id',$userid);
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
	 
	function cartList(){
		$where=array(
			'pt.abbr'=>$this->session->userdata('language'),
			'c.user_id'=>$this->session->userdata('user_session_id')
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
		$this->db->select("count(cd.cart_detail_id) as total_cart,c.total_cart_amount");
		$this->db->from('add_to_cart c');
		$this->db->join('cart_details cd ','cd.cart_id=c.cart_id','INNER');
		$this->db->where('user_id',$userid);
		$result=$this->db->get();
		$response=$result->row_array();
		return $response;
	}
	
}