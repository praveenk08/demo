<?php
class Cart extends Web {
	 
	function index(){
 		$where=array(
			'pt.abbr'=>$this->session->userdata('language'),
			'c.user_id'=>$this->session->userdata('user_session_id')
		);
		$data['carts']=$this->Cart_model->cartList($where);
  		$this->load->view('website/cart',$data);
	}
	function wishList(){
		$where=array(
		   'pt.abbr'=>$this->session->userdata('language'),
		   'wish.user_id'=>$this->session->userdata('user_session_id')
	   );
	$data['wishlists']=$this->Cart_model->wishList($where);
	$this->load->view('website/wish-list',$data);
   }
	

	function addProductToCart(){
		if ($this->input->is_ajax_request()) {
			$response['status']=true;
  			$add_update_data=array(
				  'user_id'=>$this->session->userdata('user_session_id'),
				  'quantity'=>$this->input->post('quantity'),
				  'product_id'=>$this->input->post('product_id')
			);
			$response['status']=$this->Cart_model->addProductToCart($add_update_data);
			if($response['status']){
 				$response['message']="Product successfully added in cart!";
			}else{
 				$response['message']="Opps Product Quantity exceeded!";
			}
			$response['total_cart']=totalCartItem();
			echo json_encode($response);
		}
	}

	function addRemoveWishlist(){
		if ($this->input->is_ajax_request()) {
			$response['status']=true;
  			$add_update_data=array(
				  'user_id'=>$this->session->userdata('user_session_id'),
 				  'product_id'=>$this->input->post('product_id')
			);
			$status=$this->Cart_model->addRemoveWishlist($add_update_data);
			if($status){
				$message = "Product successfully added in Wishlist!";
			}else{
				$message = "Product successfully removed from Wishlist!";
			}
			$response['message']=$message;
			$response['status']=$status;
			$response['total_wishlist']=totalWishList();
			echo json_encode($response);
		}
	}
	

	function UpdateQuantityProductToCart(){
		if ($this->input->is_ajax_request()) {
			$response['status']=true;
			$quantity=$this->input->post('quantity');
			$cart_detail_id=$this->input->post('cart_detail_id');
 			$add_update_data=array('user_id'=>$this->session->userdata('user_session_id'),'quantity'=>$quantity,'cart_detail_id'=>$cart_detail_id);
			$response['status']=$this->Cart_model->UpdateQuantityProductToCart($add_update_data);
			if($response['status']){
				$message = "Product Quantity Updated!";
			}else{
				$message = "Opps Product Quantity exceeded!";
			}
			$response['message']=$message;
			$response['total_cart']=totalCartItem();
			echo json_encode($response);
		}
	}

	function RemoveProductToCart(){
		if ($this->input->is_ajax_request()) {
			$response['status']=true;
 			$cart_detail_id=$this->input->post('cart_detail_id');
			$data=array('cart_detail_id'=>$cart_detail_id);
			$status=$this->Cart_model->RemoveProductToCart($data);
			if($status){
				$message = "Product removed from cart!";
			}else{
				$message = "There is an error!";
			}
			$response['message']=$message;
			$response['total_cart']=totalCartItem();
			echo json_encode($response);
		}
	}	

}