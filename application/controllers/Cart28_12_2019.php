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
				if($this->session->userdata('language')=='en'){
					$response['message']="Product successfully added in cart!";
					$response['button_label']="Added";
				}else{
					$response['message']="وأضاف المنتج بنجاح في عربة!";
					$response['button_label']="وأضاف";
				}
			}else{
				if($this->session->userdata('language')=='en'){
					$response['message']="Opps Product Quantity exceeded!";
				}else{
					$response['message']="مقابل المنتج الكمية تجاوزت!";
				}
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
				if($this->session->userdata('language')=='en'){
					$message = "Product successfully added in Wishlist!";
				}else{
					$message = "تم اضافة المنتج بنجاح في قائمة الامنيات!";
				}
			}else{
				if($this->session->userdata('language')=='en'){
					$message = "Product successfully removed from Wishlist!";
				}else{
					$message="تمت إزالة المنتج بنجاح من قائمة الأمنيات!";
				}
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
				if($this->session->userdata('language')=='en'){
					$message = "Product Quantity Updated!";
				}else{
					$message = "تحديث كمية المنتج";
				}
			}else{
				if($this->session->userdata('language')=='en'){
					$message = "Opps Product Quantity exceeded!";
				}else{
					$message = "مقابل المنتج الكمية تجاوزت!";
				}
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
				if($this->session->userdata('language')=='en'){
					$message = "Product removed from cart!";
				}else{
					$message = "تمت إزالة المنتج من العربة!";
				}
			}else{
				if($this->session->userdata('language')=='en'){
					$message = "There is an error!";
				}else{
					$message = "هنالك خطأ!";
				}
			}
			$response['message']=$message;
			$response['total_cart']=totalCartItem();
			echo json_encode($response);
		}
	}	

}