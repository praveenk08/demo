<?php class Cart_model extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database(); 
	 }

	 function totalCartItem(){
		$this->db->select("count(cd.cart_detail_id) as total_cart");
		$this->db->from('add_to_cart c');
		$this->db->join('cart_details cd ','cd.cart_id=c.cart_id','INNER');
		$this->db->where('c.user_id',$this->session->userdata('user_session_id'));
		$result=$this->db->get();
 		$response=$result->row_array()['total_cart'];
		return $response;

	}
	function totalWishList(){
		$this->db->select("count(wish.id) as total_wish");
		$this->db->from('add_to_wishlist wish');
 		$this->db->where('wish.user_id',$this->session->userdata('user_session_id'));
		$result=$this->db->get();
		$response=$result->row_array()['total_wish'];
 		return $response;
	}
	

	function updateUserId($cooke){
 		$this->db->where('user_id',$this->session->userdata('customer_data')['id']);
		$cart_details=$this->db->get('add_to_cart');
		$cart_data=$cart_details->row_array();
		$cart_id=$cart_data['cart_id'];
		if(!$cart_id){
			$this->db->where('user_id',$cooke);
			$cart_detail_id=$this->db->update('add_to_cart',array('user_id'=>$this->session->userdata('customer_data')['id']));
		}else{
 			$user_id=$cart_data['user_id'];
			$this->db->select("c.cart_id,c.user_id,cd.cart_detail_id,cd.product_id,cd.quantity");
			$this->db->from('add_to_cart c');
			$this->db->join('cart_details cd ','cd.cart_id=c.cart_id','INNER');
			$this->db->where('c.user_id',$cooke);
			$cart_cookies_details=$this->db->get();
			$cart_details_data=$cart_cookies_details->result_array();
			if(count($cart_details_data)>0){
				foreach($cart_details_data as $cart_details_row){

					$new_cart_id=$cart_details_row['cart_id'];
					$product_id=$cart_details_row['product_id'];
					$cart_detail_id=$cart_details_row['cart_detail_id'];
 					$this->db->where(array('cart_id'=>$cart_id,'product_id'=>$product_id));
					$exist_result=$this->db->get('cart_details');
					$exist_result_data=$exist_result->row_array();

					if(!$exist_result_data['cart_detail_id'])
					{
						$this->db->update('cart_details',array('cart_id'=>$cart_id));
					}else{
						$this->db->where(array('cart_detail_id'=>$cart_detail_id));
						$this->db->delete('cart_details');
					}
				}
				$this->db->where(array('cart_id'=>$new_cart_id));
				$this->db->delete('add_to_cart');
			}
		}
		
		$this->db->where('user_id',$cooke);
		$wish_details=$this->db->get('add_to_wishlist');
		$wish_data=$wish_details->result_array();
 
		if(count($wish_data)>0){
			foreach($wish_data as $wish_row){
				$wish_id=$wish_row['id'];
				$wish_product_id=$wish_row['product_id'];
				$this->db->where(array('user_id'=>$this->session->userdata('customer_data')['id'],'product_id'=>$wish_product_id));
				$exist_result=$this->db->get('add_to_wishlist');
				$exist_data=$exist_result->row_array();
				 if(!$exist_data['id']){
					 $this->db->where(array('user_id'=>$cooke,'product_id'=>$wish_product_id));
					  $this->db->update('add_to_wishlist',array('user_id'=>$this->session->userdata('customer_data')['id']));
  				 }else{
 					$this->db->delete('add_to_wishlist',array('id'=>$wish_id));
				 }
			}
		}
	 }
	 

	
	
	function addRemoveWishlist($data){
		$this->db->select('product_id');
		$this->db->where('user_id',$data['user_id']);
		$this->db->where('product_id',$data['product_id']);
		$result=$this->db->get('add_to_wishlist');
		$product_id=$result->row_array()['product_id'];
		if(!$product_id){
			$this->db->insert('add_to_wishlist',array('user_id'=>$data['user_id'],'product_id'=>$data['product_id']));
			$wish_id=$this->db->insert_id();
			return true;
		}else{
			$this->db->where('user_id',$data['user_id']);
			$this->db->where('product_id',$data['product_id']);
			$this->db->delete('add_to_wishlist');
			return false;
		}
	}
	

	
}
