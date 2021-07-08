<?php
	require APPPATH . '/libraries/REST_Controller.php';
	class CustomerApp extends REST_Controller{
		public function __construct(){
 			parent::__construct();
 			$this->load->model('api/App_model');
			 $this->load->model('Cart_model');
  
		}
  // Customer Update Profile
	public function customerUpdateProfile_POST(){
		if($_POST && $this->input->post('id')>0){
		$response['status']=TRUE;
			$data=array(
			'id'=>$this->input->post('id'),
			'role_id'=>3
		);
		if(!empty($this->input->post('first_name'))){
			$data['first_name']=$this->input->post('first_name');
		}

						
		if(!empty($this->input->post('password'))){
			$data['password']=sha1($this->input->post('password'));
		}

		if(!empty($this->input->post('phone'))){
			$data['phone']=$this->input->post('phone');
		}
		 

		if(!empty($this->input->post('phone'))){
			$where=array();
			$data['phone']=$this->input->post('phone');
			if($data['id']>0){
				$where['id <>']=$data['id'];
			}
			$where['phone']=$data['phone'];
			if(!$this->App_model->checkExist('users',$where)){
				$response['status']=FALSE;
				$response['message']="Phone No already exists!";
				}
			}

		if($response['status']){
			if(!empty($_FILES['image']['name'])){
				$old_image=$this->input->post('old_image')?$this->input->post('old_image'):'';
				$allowed_types ='png|jpg|jpeg|gif';
				$input_name = 'image';
				$file_response=uploadImage('users',$allowed_types,$input_name,$old_image);
				if($file_response['status']){
					$data['image']=$file_response['name'];
				}else{
					$response['status']=false;
					$response['message']=$file_response['message'];
				}
			}
 
			if($response['status']){
				$customer_id=$this->App_model->AddUpdateData('users',$data);
				if(!empty($this->input->post('address'))){
					$address_data['address']=$this->input->post('address');
					$address_data['latitude']=$this->input->post('latitude');
					$address_data['longitude']=$this->input->post('longitude');
					$address_data['id']=$this->input->post('address_id')?$this->input->post('address_id'):0;
					$address_data['user_id']=$customer_id;
					if(!empty($this->input->post('street'))){
						$address_data['street']=$this->input->post('street');
					}
					$this->App_model->AddUpdateData('user_address',$address_data);
				}
				$response['message']="Your Profile has been updated successfully";
			}
		}
		echo json_encode($response);
	}  
	return false;
	}


	


	public function getLatestVendorList_POST()
	{
		$response['response']=(object)array();
		$response['status']=TRUE;
		$conditions['latitude']=$this->input->post('latitude')?$this->input->post('latitude'):'';
		$conditions['longitude']=$this->input->post('longitude')?$this->input->post('longitude'):'';
 	 	$conditions['where_in']=array();
		//$category_id=$this->input->post('category_id');
	//	if($category_id){
 		//	$category_ids=explode(',',ltrim(rtrim($this->App_model->getAllChildCategoriesList($category_id)['categories'].','.$category_id,','),','));
		//	$conditions['where_in'] = $category_ids;
		//	}
		$conditions['where'] = array('u.status'=>1,'u.role_id'=>2,'u.is_deleted'=>0);
		$response['response'] = $this->App_model->getLatestVendorList($conditions);
		$response['imagePath']="./attachments/users/";
		echo json_encode($response);
		}
 

	function getMinMaxProductPrice_POST(){
		$response['response']=(object)array();
		$response['status']=TRUE;
		$response['message']="Price List";
		$response['response']=getMinMaxProductPrice();
 		echo json_encode($response);
	}
 
	function addProductToCart_POST(){
		if($_POST && $this->input->post('user_id')>0){
			$response['status']=true;
			$add_update_data=array(
				 'user_id'=>$this->input->post('user_id'),
				'quantity'=>$this->input->post('quantity'),
				'product_id'=>$this->input->post('product_id')
		  );
		  $status=$this->App_model->addProductToCart($add_update_data);
		  $message = "Product successfully added to cart!";
		  $response['message']=$message;
		  echo json_encode($response);
		}
			
	}

	function UpdateQuantityProductToCart_POST(){
		if($_POST && $this->input->post('cart_detail_id')>0){
			$response['status']=true;
			$user_id=$this->input->post('user_id');
			$quantity=$this->input->post('quantity');
			$cart_detail_id=$this->input->post('cart_detail_id');
 			$add_update_data=array('user_id'=>$user_id,'quantity'=>$quantity,'cart_detail_id'=>$cart_detail_id);
			$status=$this->App_model->UpdateQuantityProductToCart($add_update_data);
			if($status){
				$message = "Product Quantity Updated!";
			}else{
				$message = "There is an error!";
			}
			$response['message']=$message;
			echo json_encode($response);
		}
			
	}

	function RemoveProductToCart_POST(){
		if($_POST && $this->input->post('cart_detail_id')>0){
			$response['status']=true;
			$data=array('cart_detail_id'=>$this->input->post('cart_detail_id'));
		   $status=$this->App_model->RemoveProductToCart($data);
		   if($status){
			   $message = "Product removed from cart!";
		   }else{
			   $message = "There is an error!";
		   }
		   $response['message']=$message;
		   echo json_encode($response);
		}
			
	}



	function totalCartItem_POST($user_id){
		if($_POST && $this->input->post('user_id')>0){
		   $response['status']=true;
			$response['response']=$this->App_model->totalCartItem($this->input->post('user_id'));
		   echo json_encode($response);
		}
	 }

	 function cartList_POST(){
		if($_POST && $this->input->post('user_id')>0){
			$where=array(
				'pt.abbr'=>$this->input->post('language'),
				'c.user_id'=>$this->input->post('user_id'),
 			);
		   $response['status']=true;
 		   $response['response']=$this->App_model->cartList($where);
		   echo json_encode($response);
		}
	 }

	 function addRemoveWishlist_POST(){
 		if($_POST && $this->input->post('user_id')>0){
			$response['status']=true;
  			$add_update_data=array(
 				  'user_id'=>$this->input->post('user_id'),
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
 			echo json_encode($response);
		}
	 }

	 function totalWishList_POST(){
		if($_POST && $this->input->post('user_id')>0){
			$response['status']=true;
  			$user_id=$this->input->post('user_id');
			$response['response']=$this->App_model->totalWishList($user_id);
   			echo json_encode($response);
		}
	 }
	 
 	 public function wishList_POST(){
	 	if($_POST && $this->input->post('user_id')>0){
			$response['response']=(object)array();
			$response['status']=TRUE;
			$where=array(
			   'pt.abbr'=>$this->input->post('language')?$this->input->post('language'):'en',
			   'wish.user_id'=>$this->input->post('user_id'),
		   	);
			$response['response']=$this->Cart_model->wishList($where);
			$response['message']="wishList Product";
			$response['imagePath']="./attachments/products/";
			echo json_encode($response);
 		}
	}

	 function createOrder_POST(){
		if($_POST && $this->input->post('user_id')>0){
			
			 $address_id=$this->input->post('address_id');
			 $payment_type=$this->input->post('payment_type');
			 $order_total=$this->input->post('order_total');
			 $transaction_id=$this->input->post('transaction_id');
			 $userid=$this->input->post('user_id');
			 $abbr=$this->input->post('language');
 		   $response =$this->App_model->createOrder($address_id,$payment_type,$order_total,$transaction_id,$userid,$abbr);
		   echo json_encode($response);
		}
	 }
	 
	 function addUpdateAddress_POST(){
		if($_POST && $this->input->post('user_id')>0){
			$save_data=array(
 				'id'=>$this->input->post('id')?$this->input->post('id'):0,
				'user_id'=>$this->input->post('user_id'),
				'name'=>$this->input->post('name'),
				'email'=>$this->input->post('email'),
				'phone'=>$this->input->post('phone'),
				'country'=>$this->input->post('country'),
				'state'=>$this->input->post('state'),
				'city'=>$this->input->post('city'),
				'address'=>$this->input->post('address'),
				'address_type'=>$this->input->post('address_type'),
				'street'=>$this->input->post('street'),
				'block'=>$this->input->post('block'),
				'status'=>$this->input->post('status')?$this->input->post('status'):0,
				'landmark'=>$this->input->post('landmark'),
				'zip'=>$this->input->post('zip'),
			);

 			$response['response']=$this->App_model->AddUpdateData('user_address',$save_data);
			if($save_data['id']>0){
				$action=" updated ";
			}else{
				$action=" added ";
			}
			$response['message']="Address ".$action.' Successfully';
		   echo json_encode($response);
		}
	 }

		function addressList_POST(){
			if($_POST && $this->input->post('user_id')>0){
				if($this->input->post('user_id')>0){
					$where['u.id']=$this->input->post('user_id');
				}
				if($this->input->post('id')>0){
					$where['ua.id']=$this->input->post('id');
				}
				$where['ua.is_deleted']=0;
				$response['response']=$this->App_model->addressData($where);
				$response['message']="Address List";
				echo json_encode($response);
			}
		}

		function deleteAddress_POST(){
			if($_POST && $this->input->post('id')>0){
				$user_data=array('id'=>$this->input->post('id'),'is_deleted'=>1);
 				$response['status']=$this->App_model->AddUpdateData('user_address',$user_data);
				if($response['status']){
					$response['message']="Address Deleted Successfully!";
				}else{
					$response['message']="Something went wrong!";
				}
 				echo json_encode($response);
 			}
 
	 }

	 public function getCoustmerOrders_POST(){
	 	if($_POST && $this->input->post('id')>0){
			$user_data=array('id'=>$this->input->post('id'));
			$response['response']=(object)array();
			$response['status']=TRUE;
			$response['message']="OrderList";
			$param['where']= array(
				'o.customer_id'=>$this->input->post('id'),
				'pt.abbr'=> $this->input->post('language')? $this->input->post('language'):'en' ,
			);
			$response['response']=$this->App_model->getCoustmerOrders($param);
			echo json_encode($response);
 		}
	}


		function getProducts_POST(){
		if($_POST && $this->input->post('user_id')>0){
			$response['response']=(object)array();
			$response['status']=TRUE;
			$language=$this->input->post('language')?$this->input->post('language'):'en';
 			$params['where']=array('pt.abbr'=>$language);
 			$product_id=$this->input->post('product_id')?$this->input->post('product_id'):0;
 			if($product_id>0){
 				$params['where']['vp.id']=$product_id;
 			}
			$params['user_id']=$this->input->post('user_id');
			$response['response']=array();
			$data=$this->App_model->getProducts($params);
			foreach($data as $row){
					$response['response'][]=array(
					'vendor_product_id'=>$row['vendor_product_id'],
					'slug'=>$row['slug'],
					'name'=>$row['name'],
					'description'=>$row['description']?$row['description']:'',
					'image'=>$row['image'],
					'price'=>$row['price'],
					'maturity_date'=>$row['maturity_date'],
					'brief'=>$row['brief']? $row['brief']:'',
					'wish_product_id'=>$row['wish_product_id']? $row['wish_product_id']:0,
					'cd_product_id'=>$row['cd_product_id']? $row['cd_product_id']:0,	

				);
			}

			$response['message']="Product List";
			echo json_encode($response);
			return false;
		}
		
	}


	
 }
 