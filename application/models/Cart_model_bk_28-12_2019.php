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
		$this->db->select('product_id,quantity');
		$result=$this->db->get('cart_details');
		$product_id=$result->row_array()['product_id'];
		$quantity=$result->row_array()['quantity'];
		$this->db->select('id,quantity');
		$this->db->from('vendor_products');
		$this->db->where('id',$data['product_id']);
		$product_data=$this->db->get()->row_array();
 		$product_quantity=$product_data['quantity'];
		$total_quantity=$quantity+$data['quantity'];
		if($total_quantity<=$product_quantity){
			if(!$product_id){
				$cart_detail_id=$this->db->insert('cart_details',array('product_id'=>$data['product_id'],'quantity'=>$total_quantity,'cart_id'=>$cart_id));
			}else{
				$this->db->where(array('product_id'=>$data['product_id'],'cart_id'=>$cart_id));
				$cart_detail_id=$this->db->update('cart_details',array('product_id'=>$data['product_id'],'quantity'=>$total_quantity,'cart_id'=>$cart_id));
			}
			$this->updateTotalCartAmount($cart_id);
			return true;

		}else{
			return false;
		}
		
	}
	function updateTotalCartAmount($cart_id){
		if($cart_id>0){
			$this->db->select('vp.price,cd.quantity');
			$this->db->from('cart_details cd');
			$this->db->join('vendor_products vp','vp.id=cd.product_id','INNER');
			$this->db->where('cart_id',$cart_id);
			$result=$this->db->get();
			$result_array=$result->result_array();
			if(count($result_array)>0){
				$total_cart_amount=0;
				foreach($result_array as $result_row){
					$total_cart_amount=$total_cart_amount+($result_row['price']*$result_row['quantity']);
				}
				if($total_cart_amount>0){
					$this->db->where('cart_id',$cart_id);
					$this->db->update('add_to_cart',array('total_cart_amount'=>$total_cart_amount));
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
	

	function UpdateQuantityProductToCart($data){
		$this->db->select('product_id,cart_id');
		$this->db->where(array('cart_detail_id'=>$data['cart_detail_id']));
		$result=$this->db->get('cart_details')->row_array();
		$product_id=$result['product_id'];
		$this->db->select('quantity');
		$this->db->where('id',$product_id);
		$product_data=$this->db->get('vendor_products')->row_array();
		$product_quantity=$product_data['quantity'];
		if($product_quantity>=$data['quantity']){
			$this->db->where(array('cart_detail_id'=>$data['cart_detail_id']));
			$response=$this->db->update('cart_details',array('quantity'=>$data['quantity']));
			$this->updateTotalCartAmount($result['cart_id']);
			return $response;
		}else{
			return false;
		}
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
	function wishList($where){
		if(count($where)>0){
			$this->db->select("
			wish.id,
			wish.product_id,
			vp.slug,
			vp.price,
			vp.image,
 			pt.name
		");
		$this->db->from('add_to_wishlist wish');
		$this->db->join('vendor_products vp', 'wish.product_id = vp.id', 'inner');
		$this->db->join('product_translator pt', 'vp.id = pt.vendor_product_id', 'inner');
 		$this->db->where($where);
		$this->db->group_by('pt.vendor_product_id');
		$result = $this->db->get();
 		$response=$result->result_array();
		return $response;
		}
	}
	

	
	function RemoveProductToCart($data){
		$this->db->where('cart_detail_id',$data['cart_detail_id']);
		$result=$this->db->get('cart_details');
		$cart_id=$result->row_array()['cart_id'];
		if($cart_id){
			$this->db->where('cart_detail_id',$data['cart_detail_id']);
			$result=$this->db->delete('cart_details');
			$total_product=$this->totalCartItem();
			if(!$total_product){
				$this->db->where('cart_id',$cart_id);
				$this->db->delete('add_to_cart');
			}else{
				$this->updateTotalCartAmount($cart_id);
			}
			return $result;
		}
 	}
}
