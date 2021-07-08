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
				$data['forecast']= $this->input->post('forecast')?$this->input->post('forecast'):0;
				$data['publication']= $this->input->post('publication')?$this->input->post('publication'):0;
				$data['matching']= $this->input->post('matching')?$this->input->post('matching'):0;
				$data['matching_and_connections_status']= $this->input->post('matching_and_connections_status')?$this->input->post('matching_and_connections_status'):0;
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
		   $response['status']=$this->Common_model->addProductToCartPhone($add_update_data);
 		  if($response['status']){
			$message="Product successfully added in cart!";
		  }else{
			$message="Opps Product Quantity exceeded!";
		  }
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
			$response['status']=$this->Common_model->UpdateQuantityProductToCart($add_update_data);
			 if($response['status']){
				$message = "Product Quantity Updated!";
			 }else{
				$message = "Opps Product Quantity exceeded!";
			 }
			$response['message']=$message;
 			echo json_encode($response);
		}
			
	}

	function RemoveProductToCart_POST(){
		if($_POST && $this->input->post('cart_detail_id')>0 && $this->input->post('user_id')>0){
			$response['status']=true;
			$cart_detail_id=$this->input->post('cart_detail_id');
			$data=array('cart_detail_id'=>$cart_detail_id,'user_id'=>$this->input->post('user_id'));
			$status=$this->Common_model->RemoveProductToCart($data);
			if($status){
				$message = "Product removed from cart!";
			}else{
				$message = "There is an error!";
			}
		   $response['message']=$message;
		}else{
			$response['message']="Something went Wrong";
		}
		echo json_encode($response);
			
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
			'pt.abbr'=>$this->input->post('language')?$this->input->post('language'):'en',
			'ct.abbr'=>$this->input->post('language')?$this->input->post('language'):'en',
			'c.user_id'=>$this->input->post('user_id')
		);
		   $response['status']=true;
 		   $response['response']=$this->Common_model->cartList($where);
		   echo json_encode($response);
		}
	 }

	function addRemoveWishlist_POST(){
		if($_POST && $this->input->post('user_id')>0){
			if($this->input->post('product_id')>0){
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
				$response['status']=TRUE;
			}
			else{
				$message='Product Id is Missing';
				$response['status']=FALSE;
			}
			$response['message']=$message;
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
		   'ct.abbr'=>$this->input->post('language')?$this->input->post('language'):'en',
		   'wish.user_id'=>$this->input->post('user_id'),
	  		 );
			$response['response']=$this->Common_model->wishList($where);
			$response['message']="wishList Product";
			$response['imagePath']="./attachments/products/";
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
				$response['status']=TRUE;
		
			}
			else
			{
				$response['status']=FALSE;
				$response['message']=MESSAGE;

			}
			echo json_encode($response);

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
			$response['response']=array();
			$response['status']=TRUE;
			$response['message']="Order List";
			$param['where']= array(
				'o.customer_id'=>$this->input->post('id'),
				'pt.abbr'=> $this->input->post('language')? $this->input->post('language'):'en',
				'ut.abbr'=> $this->input->post('language')? $this->input->post('language'):'en',
			);
			$data=array();
			$results=$this->App_model->getCoustmerOrders($param);
			foreach($results as $result){
				if(is_file('./attachments/products/thumb/'.$result['image'])){
						$image=$result['image'];	
				  }else{
					   $image='';
				   }
				$response['response'][]=array(
					'order_id' => $result['order_id'],
					'order_date' => $result['order_date'],
					'name' => $result['name'],
					'image' => $image,
					'quantity' => $result['quantity'],
					'product_id' => $result['product_id'],
					'unit_name' => $result['unit_name'],
					'price' => $result['price'],
					'order_status' => $result['order_status'],
					'order_address' => $result['order_address'],
					'order_block' => $result['order_block'],
					'order_zip' => $result['order_zip'],

				);
			}

			$response['imagePath']="./attachments/products/";
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
 			$vendor_id=$this->input->post('vendor_id')?$this->input->post('vendor_id'):0;
 			$category_id=$this->input->post('category_id')?$this->input->post('category_id'):0;
 			$min_price=$this->input->post('min_price')?$this->input->post('min_price'):0;
			$max_price=$this->input->post('max_price')?$this->input->post('max_price'):1000000;
			$params['where']['vp.price>=']=$min_price;
			$params['where']['vp.price<=']=$max_price;
			$maturity_start_date=date('Y-m-d',strtotime($this->input->post('maturity_start_date')));
			$maturity_end_date=date('Y-m-d',strtotime($this->input->post('maturity_end_date')));

			if(!empty($maturity_start_date)){
			$params['where']['vp.maturity_date >=']=$maturity_start_date;
			}
			if(!empty($maturity_start_date)){
			$params['where']['vp.maturity_to_date >=']=$maturity_end_date;
			}
			if($product_id>0){
	 				$params['where']['vp.id']=$product_id;
	  				$params['product_id']=$product_id;
	 	     		$this->db->query('update vendor_products set total_visitors=total_visitors+1 where id='.$product_id);
	  			}
	  			else{
	  				$params['product_id']=$product_id;

	  			}
 			if($vendor_id>0){
 				$params['where']['vp.vendor_id']=$vendor_id;
 			}
 			$params['where_in']=array();
 			if($category_id>0){
                        $params['where_in'] = explode(',',ltrim(rtrim($this->Common_model->getAllChildCategoriesList($category_id)['categories'].','.$category_id,','),','));
                     }
			$params['user_id']=$this->input->post('user_id');
			$response['response']=array();
			$data=$this->App_model->getProducts($params);
			//echo"<pre>";print_r($data); die;

 			foreach($data as $row){
					$response['response'][]=array(
					'vendor_product_id'=>$row['vendor_product_id'],
					'slug'=>$row['slug'],
					'name'=>$row['name'],
					'category_name'=>$row['category_name'],
					'description'=>$row['description']?$row['description']:'',
					'image'=>$row['image'],
					'price'=>$row['price'],
					'quantity'=>$row['quantity'],
					'rating_applicable'=>$row['rating_applicable'],
					'average_review'=>$row['average_review']?$row['average_review']:"0",
					'maturity_date'=>$row['maturity_date'],
					'maturity_to_date'=>$row['maturity_to_date'],					
					'brief'=>$row['brief']? $row['brief']:'',
					'wish_product_id'=>$row['wish_product_id']? $row['wish_product_id']:"0",
					'cd_product_id'=>$row['cd_product_id']? $row['cd_product_id']:"0",	
					'cd_cart_quantity'=>$row['cd_cart_quantity']? $row['cd_cart_quantity']:"0",	
					'cart_detail_id'=>$row['cart_detail_id']? $row['cart_detail_id']:"0",	
				);
			}

			$response['message']="Product List";
			$response['imagePath']="./attachments/products/";
			echo json_encode($response);
			return false;
		}
		
	}


	public function createOrderBKK_POST(){
 		if ($this->input->post('address_id')>0 && !empty($this->input->post('payment_type')) && $this->input->post('cart_total')>0 && $this->input->post('customer_id')>0) {
			$response=array();
			$address_id=$this->input->post('address_id');
			$payment_type=$this->input->post('payment_type');
			$cart_total=$this->input->post('cart_total');
			$customer_id=$this->input->post('customer_id');
			$transactionid="";
			//echo "sss";
			//die;
 		//	if($payment_type=='COD'){
			//	$transactionid="cod";
			//	$response= $this->Common_model->createOrder($address_id,$payment_type,$cart_total,$transactionid);
			//	$this->orderEmail($response['order_id']);
			//	$this->Common_model->callBackOrderSales(true); 
			//	$response['payment_url']=base_url('CheckOut/thanks');
			//	$response['status']=TRUE;
			//}else{
				$response=$this->Common_model->createOrder($address_id,$payment_type,$cart_total,$transactionid,$customer_id);
 				$post_data=setGatewatData($response);
 				$ch = curl_init('https://www.paytabs.com/apiv2/create_pay_page');
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = json_decode(curl_exec($ch));
 				if($result->response_code==4012){
					$response['status']=TRUE;
					$response['payment_url']=$result->payment_url;
					$response['message']=$result;
 				}else{
					$response['status']=FALSE;
					$response['message']=$result;
					$response['payment_url']=base_url();
				}
 		//	}
			echo json_encode($response);
		}
	}

	public function createOrder_POST(){
		if ($this->input->post('address_id')>0 && !empty($this->input->post('payment_type')) && $this->input->post('cart_total')>0 && $this->input->post('customer_id')>0) {
		   $response=array();
 		   $address_id=$this->input->post('address_id');
		   $payment_type=$this->input->post('payment_type');
		   $cart_total=$this->input->post('cart_total');
		   $customer_id=$this->input->post('customer_id');
		   $transactionid="";
		   $order_info=array(
			   'address_id'=>$address_id,
			   'payment_type'=>$payment_type,
			   'cart_total'=>$cart_total,
			   'transactionid'=>$transactionid,
			   'customer_id'=>$customer_id
			);
		   if($payment_type=='COD'){
				$order_info['transactionid']="cod";
 				$response= $this->Common_model->createOrder($order_info);
				$response['response']=setGatewatData($response);
				$this->Common_model->callBackOrderSales($customer_id,true); 
				$customer_email=$this->Common_model->userData(array('id'=>$customer_id))['email'];
				$this->orderEmail($response['order_id'],$customer_email);
				$response['payment_url']=base_url('CheckOut/thanks');
				$this->db->insert('payments',array('order_id'=>$response['order_id'],'amount'=>$cart_total,'transaction_id'=>$transactionid));
				$response['status']=TRUE;
				$response['order_id']=$response['order_id'];
				$response['message']="SUCCESS";
			}else{
 				$result=$this->Common_model->createOrder($order_info);
 				$response['response']=setGatewatData($result);
				$response['status']=true;
				$response['order_id']=$result['order_id'];
			}
		   echo json_encode($response);
	   }
   }

	public function checkPayment_POST(){
 		if ($this->input->post('reference_no')>0 && !empty($this->input->post('customer_id')) && $this->input->post('transaction_id')>0) {
		$response['status']=TRUE;
		$reference_no=$this->input->post('reference_no');
		$customer_id=$this->input->post('customer_id');
		$payment_status=$this->input->post('payment_status');
		$transaction_id=$this->input->post('transaction_id');
		$customer_email=$this->Common_model->userData(array('id'=>$customer_id))['email'];
		$amount=$this->input->post('amount');

  		if($payment_status==TRUE){
			$this->db->where('order_id',$reference_no);
			$this->db->update('orders',array('transaction_id'=>$transaction_id,'payment_status'=>1));
			$this->db->insert('payments',array(
				'order_id'=>$reference_no,
				'amount'=>$amount,
				'transaction_id'=>$transaction_id
			));
			$payment_id= $this->db->insert_id();	 
			$this->orderEmail($reference_no,$customer_email);
			if($payment_id){
				$this->Common_model->callBackOrderSales($customer_id,true); 
			 }
			 $response['message']='Transaction done successfully';
		}else{
			$this->db->where('order_id',$reference_no);
			$this->db->update('orders',array('transaction_id'=>$transaction_id,'payment_status'=>0));
			$this->Common_model->callBackOrderSales($customer_id,false); 
			$response['message']='Something went wrong';
		 }

		}
		 echo json_encode($response);
	}

	public function orderEmail($order_id,$customer_email){
		if($order_id>0){
		  $response['products']=$this->Common_model->getOrderProducts($order_id);
		  $response['address']=$this->Common_model->getOrderAddress($order_id);
		  $response['order_no']=$order_id;
		  $mail_message=$this->load->view('website/email_templates/order-details',$response,true);
		  $sent=sendEmail($customer_email,"",'Order',$mail_message);
		  $this->vendorEmailManagement($order_id);
		  return $sent;
 		}
	}

	function vendorEmailManagement($order_id){
		$response['address']=$this->Common_model->getOrderAddress($order_id);
		$vendors=$this->Common_model->vendorList($order_id);
		 if(count($vendors)>0){
			 foreach($vendors as $vendor){
				 $where=array(
					 'od.vendor_id'=>$vendor['vendor_id'],
					 'pt.abbr'=>'en',
					 'od.order_id'=>$order_id,
					);
				$products=$this->Common_model->vendorOrderDetails($where);
				$response['products']=$products;
				$response['vendor_name']=$vendor['vendor_name'];
				$response['order_no']=$order_id;
				$mail_message=$this->load->view('website/email_templates/vendor-order-details',$response,true);
				$sent=sendEmail($vendor['vendor_email'],"",'Order',$mail_message);
				$total_price=0;
                $total_product_quantity=0;
				foreach($products as $product){
					$total_price +=($product['price']*$product['quantity']);
					$total_product_quantity +=$product['quantity'];
				}
				$save_data=array(
					'id'=>0,
					'vendor_id'=>$vendor['vendor_id'],
					'order_id'=>$order_id,
					'customer_id'=>$vendor['customer_id'],
					'total_product'=>count($products),
					'total_product_quantity'=>$total_product_quantity,
					'total_amount'=>$total_price,
				);
				$this->Common_model->addUpdateData('vendor_order_notifications',$save_data);
			 }
		 }

	}


	function getTransationList_POST(){
			if($_POST && $this->input->post('customer_id')>0){
				if($this->input->post('customer_id')>0){
					$where['o.customer_id']=$this->input->post('customer_id');
				}
				$response['response']=$this->App_model->getTransationList($where);
				$response['message']="Transation List";
				$response['status']=TRUE;
				echo json_encode($response);
			}
		}


	function addUpdateStatusMatchingConnection_POST(){
		if($_POST && $this->input->post('product_id')>0 && $this->input->post('customer_id')>0){
			$this->Common_model->addUpdateStatusMatchingConnection(array('product_id'=>$this->input->post('product_id'),'customer_id'=>$this->input->post('customer_id'),'status'=>$this->input->post('status')));
			$response['message']="Status Updated";
			$response['status']=TRUE;
  			echo json_encode($response);
		}
	}

	function getContactUs_POST(){
			$response['response']=$this->Common_model->getSettings();
			$response['message']="Contact Us";
			$response['status']=TRUE;
			echo json_encode($response);
	}


	function getProductReviews_POST(){
			if(isset($_POST) && $this->input->post('customer_id') && $this->input->post('product_id')){

			$where=array('rr.vendor_product_id'=>$this->input->post('product_id'),'rr.status'=>1,'rr.is_deleted'=>0);
			$response['response']=$this->Common_model->getReviews($where);
			$response['message']="Review List";
			$response['status']=TRUE;
			echo json_encode($response);
		}
			}	


	function addProductReviews_POST(){
		if(isset($_POST)&& $this->input->post('customer_id') && $this->input->post('product_id')) {
			$where=array(
					'id'=>0,
					'review'=>$this->input->post('review'),
					'vendor_product_id'=>$this->input->post('product_id'),
					'rating'=>$this->input->post('rating')?$this->input->post('rating'):1,
					'customer_id'=>$this->input->post('customer_id'),
 				);
			$response['response']=$this->Common_model->AddUpdateData('review_rating',$where);
			$response['response']="Thankyou for Review";
			$response['status']=TRUE;
			echo json_encode($response);
			
		}
		
	}


	function addMatchingAndConnectionProduts_POST(){
		if(isset($_POST)&& ($this->input->post('category_id'))  && ($this->input->post('customer_id'))){	
			$image='';
			if(!empty($_FILES['image']['name'])){
				$allowed_types ='png|jpg|jpeg|gif';
				$input_name = 'image';
				$file_response=uploadImage('products',$allowed_types,$input_name,'');
				if($file_response['status']){
					$image=$file_response['name'];
				}
				else{
					$response['status']=false;
					$response['message']=$file_response['message'];
				}
			} 
			$save_data=array(
				'id'=>0,
				'category_id'=>$this->input->post('category_id'),
				'customer_id'=>$this->input->post('customer_id'),
				'image'=>$image,
				'status'=>$this->input->post('status')?$this->input->post('status'):0,
			);
			$response['response']=$this->Common_model->AddUpdateData('product_matching_and_connections',$save_data);
			$response['message']="Your Matching and Connection product is been Added !!";
			$response['status']=TRUE;
			
		}
		else
		{
			$response['status']=FALSE;
			$response['message']=MESSAGE;
		}
		echo json_encode($response);
	}


	function getCustomermatchingAndConnectionsProductList_POST(){
			if($_POST && $this->input->post('customer_id')>0){
 			$language=$this->input->post('language')?$this->input->post('language'):'en';
 			$conditions['where']=array('c.status'=>1,'ct.abbr'=>$language,'c.is_deleted'=>0);
			$conditions['where_in'] = array();
			$conditions['where']['customer_id'] = $this->input->post('customer_id');
			$category_id=$this->input->post('category_id')?$this->input->post('category_id'):0;
			$status=$this->input->post('status');
 			if($status!=""){
 				$conditions['where']['pmc.status']=$status;
			}
			if($category_id >0){
 				$category_ids=explode(',',ltrim(rtrim($this->Common_model->getAllChildCategoriesList($category_id)['categories'].','.$category_id,','),','));
				$conditions['where_in'] = $category_ids;
			}
			$response['message']="Matching And Connections Product List";
			$response['response'] = $this->App_model->matchingAndConnections($conditions);
			$response['imagePath']="./attachments/products/";
			$response['status']=TRUE;
 			
		}
		else
		{
			$response['status']=FALSE;
			$response['message']=MESSAGE;
		}
		echo json_encode($response);
	}


	function changeStatusMatchingAndConnectionProducts_POST(){
		if(isset($_POST) && $this->input->post('customer_id')&& $this->input->post('id')){
			$update_data=array(
				'id'=>$this->input->post('id'),
				'status'=>$this->input->post('status'),
			);
			$response['response']=$this->Common_model->changeDataStatus('product_matching_and_connections',$update_data);
			$response['message']="Status Updated Successfully !!";
			$response['status']=TRUE;
		}
		else
		{
			$response['status']=FALSE;
			$response['message']=MESSAGE;
		}
		echo json_encode($response);
	}



	function deleteMatchingAndConnectionProduct_POST(){
		if($_POST && $this->input->post('customer_id')>0 && $this->input->post('id')){

			$data_info=getSingleTableData('product_matching_and_connections',array('id' =>$this->input->post('id')))[0];
			unlinkImage('products',$data_info['image']);
			$where=array(
				'id'=>$this->input->post('id'),
				'customer_id'=>$this->input->post('customer_id'),
			);
				$response['response']=$this->Common_model->deleteRecord($where,'product_matching_and_connections');
				$response['message']="Product is deleted successfully !!";
				$response['status']=TRUE;
			}
			else
			{
				$response['status']=FALSE;
				$response['message']=MESSAGE;
			}
			echo json_encode($response);
		}
	

	function customerNewProductRequest_POST(){
		if(isset($_POST) && $this->input->post('customer_id')){
			$save_data=array(
				'id'=>0,
				'customer_id'=>$this->input->post('customer_id'),
				'category_name'=>$this->input->post('category_name'),
				'sub_category_name'=>$this->input->post('sub_category_name'),
				'message'=>$this->input->post('message'),
			);
			$response['response']=$this->Common_model->AddUpdateData('customer_new_product_request',$save_data);
			$response['message']="Your new product request has been sent successfully !!";
			$response['status']=TRUE;
		}
		else{
			$response['status']=TRUE;
			$response['message']=MESSAGE;

		}
		echo json_encode($response);
	}


	function services_POST(){
		if(isset($_POST)&& $this->input->post('customer_id')>0){
			$language=$this->input->post('language')?$this->input->post('language'):'en';
  			$category_id=$this->input->post('category_id');
			$service_id=$this->input->post('service_id');
			$state_id=$this->input->post('state_id');
			$city_id=$this->input->post('city_id');
			$response['response']=array();
			$where['sc.is_deleted']=0;
			$where['sc.status']=1;
			$where['sps.is_deleted']=0;
			$where['spst.abbr']=$language;
			$where['sct.abbr']=$language;
			$where['sps.status']=1;  	
			if($category_id>0){
				$where['sps.service_category_id']=$category_id;
			}
			if($service_id>0){
				$where['sps.id']=$service_id;
			}

			if($state_id>0){
				$where['ua.state']=$state_id;
			}
			if($city_id>0){
				$where['ua.city']=$city_id;
			}
			
			$param['where']=$where;			
			$response['response'] = $this->App_model->servicesList($param);
			$response['message']="Service List";
			$response['status']=TRUE;
		}
		else
		{
			$response['status']=FALSE;
			$response['message']=MESSAGE;

		}
				$response['imagePath']="./attachments/services/";
				echo json_encode($response);
			}



		public function manageVendorCustomers_POST(){
			if(isset($_POST)&& $this->input->post('vendor_id')>0){
	  		$params['where']['u.is_deleted']=0;
			$params['where']['u.role_id']=3; 
			$params['where']['od.vendor_id']=$this->input->post('vendor_id'); 
			$response['response']=$this->App_model->manageVendorCustomers($params);
			$response['message']="Vendor Customer List";
			$response['status']=TRUE;
			}
			else
			{
				$response['message']=MESSAGE;
				$response['status']=FALSE;
			}
			echo json_encode($response);
		}


}

 