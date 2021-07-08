<?php
class Cart extends Web {
	 
	function index(){
 		$where=array(
			'pt.abbr'=>$this->session->userdata('language'),
			'ct.abbr'=>$this->session->userdata('language'),
			'c.user_id'=>$this->session->userdata('user_session_id')
		);
		$data['carts']=$this->Common_model->cartList($where);
  		$this->load->view('website/cart',$data);
	}


	function wishList(){
		$where=array(
		   'pt.abbr'=>$this->session->userdata('language'),
		   'ct.abbr'=>$this->session->userdata('language'),
		   'wish.user_id'=>$this->session->userdata('user_session_id')
	   );
	$data['wishlists']=$this->Common_model->wishList($where);
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
			$response['status']=$this->Common_model->addProductToCart($add_update_data);
			if($response['status']){
				if($this->session->userdata('language')=='en'){
					$response['message']="Crop successfully added in cart!";
					$response['button_label']="Added";
				}else{
					$response['message']="وأضاف المنتج بنجاح في عربة!";
					$response['button_label']="وأضاف";
				}
			}else{
				if($this->session->userdata('language')=='en'){
					$response['message']="Opps Crop Quantity exceeded!";
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
					$message = "Crop successfully added in Wishlist!";
				}else{
					$message = "تم اضافة المنتج بنجاح في قائمة الامنيات!";
				}
			}else{
				if($this->session->userdata('language')=='en'){
					$message = "Crop successfully removed from Wishlist!";
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
			$response['status']=$this->Common_model->UpdateQuantityProductToCart($add_update_data);
			if($response['status']){
				if($this->session->userdata('language')=='en'){
					$message = "Crop Quantity Updated!";
				}else{
					$message = "تحديث كمية المنتج";
				}
			}else{
				if($this->session->userdata('language')=='en'){
					$message = "Opps Crop Quantity exceeded!";
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
			$user_id=$this->session->userdata('user_session_id');
			$data=array('cart_detail_id'=>$cart_detail_id,'user_id'=>$user_id);
			$status=$this->Common_model->RemoveProductToCart($data);
 			if($status){
				if($this->session->userdata('language')=='en'){
					$message = "Crop removed from cart!";
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

		public function moveWishlistToCart(){
			$product_arr=$this->input->post('product_id');
			if(count($product_arr)>0){
				foreach ($product_arr as $product_id) {
					$add_update_data=array(
					'user_id'=>$this->session->userdata('user_session_id'),
					'quantity'=>1,
					'product_id'=>$product_id,
					);
					$response=$this->Common_model->addProductToCart($add_update_data);

					$add_update_data=array(
					'user_id'=>$this->session->userdata('user_session_id'),
					'product_id'=>$product_id,
					);
					$response=$this->Cart_model->addRemoveWishlist($add_update_data);

			}
				$response['total_cart']=totalCartItem();
				$response['total_wishlist']=totalWishList();
				$response['status']=1;
				$response['message']=" Product Successfully Moved Into Cart";
				$response['response']=$product_arr;

			}
				echo json_encode($response);
			}
}