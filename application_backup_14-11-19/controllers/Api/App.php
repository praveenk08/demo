<?php
	require APPPATH . '/libraries/REST_Controller.php';
	class App extends REST_Controller{
		public function __construct(){
 			parent::__construct();
			$this->load->model('api/App_model');
			$this->load->model('common/Common_model');
		}

		///////////////////Master Table Data Start///////////////////
		public function roleList_POST(){
			$response['response']=(object)array();
			$response['status']=TRUE;
			$response['message']="Role List";
			$where=array('status'=>1,'id <>'=>1);
			$response['response']=$this->App_model->getSingleTableData('role',$where);
			echo json_encode($response);
		}

		public function getwaySecretDetails_POST(){
			$response['response']=(object)array();
			$response['status']=TRUE;
			$response['message']="Details";
			$response['response']=array(
				'merchant_email' => $this->config->item('merchant_email'),
				'secret_key' => $this->config->item('secret_key')
			);
			echo json_encode($response);
		}
		

		function getCategories_POST(){
			$response['response']=(object)array();
			$response['status']=TRUE;
			$parent_id=$this->input->post('parent_id')?$this->input->post('parent_id'):0;
			$where=array('status'=>1,'is_deleted'=>0,'parent_id'=>$parent_id);
			$response['response']=$this->App_model->getSingleTableData('category',$where);
			$response['message']="Category List";
			echo json_encode($response);
			return false;
		}
	
		function getUnits_POST(){
			$response['response']=(object)array();
			$response['status']=TRUE;
			$where=array('status'=>1,'is_deleted'=>0);
			$response['response']=$this->App_model->getSingleTableData('units',$where);
			$response['message']="Unit List";
			echo json_encode($response);
			return false;
		}
		function getLanguages_POST(){
			$response['response']=(object)array();
			$response['status']=TRUE;
			$where=array();
			$response['response']=$this->App_model->getSingleTableData('languages',$where);
			$response['message']="Language List";
			echo json_encode($response);
			return false;
		}
		
		public function countryList_POST(){
			$response['response']=(object)array();
			$response['status']=TRUE;
			$response['message']="Country List";
 			$response['response']=$this->Common_model->getCountryList(array());
			echo json_encode($response);
		}

		public function stateList_POST(){
			if($_POST && $this->input->post('country_id')>0){
				$response['response']=(object)array();
				$response['status']=TRUE;
				$response['message']="State List";
				$where=array('country_id'=>$this->input->post('country_id'));
				$response['response']=changeCountryGetState($where);
				echo json_encode($response);
			}
		}

		public function cityList_POST(){
			if($_POST && $this->input->post('state_id')>0){
				$response['response']=(object)array();
				$response['status']=TRUE;
				$response['message']="State List";
				$where=array('state_id'=>$this->input->post('state_id'));
				$response['response']=changeStateGetCity($where);
				echo json_encode($response);
			}
		}
		function providerServiceCategory_POST(){
			$response['response']=(object)array();
			$response['status']=TRUE;
			$where=array('status'=>1,'is_deleted'=>0);
			$response['response']=$this->App_model->getSingleTableData('service_category',$where);
			$response['message']="Category List";
			echo json_encode($response);
			return false;
		}

		///////////////////Master Table Data Start///////////////////

		public function registration_POST(){
			if($_POST){
				$response['status']=TRUE;
				$data=array('role_id'=>$this->input->post('role_id'),'id'=>0);

				if(!empty($this->input->post('first_name'))){
					$data['first_name']=$this->input->post('first_name');
				}

				//if(!empty($this->input->post('last_name'))){
					//$grower_data['last_name']=$this->input->post('last_name');
				//}

				if(!empty($this->input->post('password'))){
					$data['password']=sha1($this->input->post('password'));
					$data['verification_code']=sha1(time());
				}

				if(!empty($this->input->post('phone'))){
					$data['phone']=$this->input->post('phone');
				}else{
					$response['status']=FALSE;
					$response['message']="Phone no is required!";
				}

				if(!empty($this->input->post('fcm_id'))){
					$data['fcm_id']=$this->input->post('fcm_id');
				}

				if(!empty($this->input->post('email'))){
					$data['email']=$this->input->post('email');
					$where['email']=$data['email'];
					$email_exist=$this->App_model->checkExist('users',$where);
					if(!$this->App_model->checkExist('users',$where)){
						$response['status']=FALSE;
						$response['message']="Email Address already exists!";
					}
				}else{
					$response['status']=FALSE;
					$response['message']="Email Address is required!";
				}

				if(!empty($this->input->post('phone'))){
					$where=array();
					$data['phone']=$this->input->post('phone');
					$where['phone']=$data['phone'];
					if(!$this->App_model->checkExist('users',$where)){
						$response['status']=FALSE;
						$response['message']="Phone No already exists!";
					}
				}					 
				if($response['status']){
					$id=$this->App_model->AddUpdateData('users',$data);
					if($id>0){
						$otp=generateOTP();
						sendSMS($data['phone'],$otp);
						$slug=makeSlug($data['first_name'].$id);
						$update_data=array('id'=>$id,'slug'=>$slug,'modified_date'=>'now()','otp' => $otp);
						$this->App_model->AddUpdateData('users',$update_data);

						$address_data['id']=0;
						$address_data['user_id']=$id;

						if(!empty($this->input->post('latitude'))){
							$address_data['latitude']=$this->input->post('latitude');
						}
						if(!empty($this->input->post('longitude'))){
							$address_data['longitude']=$this->input->post('longitude');
						}
						if(!empty($this->input->post('address'))){
							$address_data['address']=$this->input->post('address');
						}
						if(!empty($this->input->post('street'))){
							$address_data['street']=$this->input->post('street');
						}
						$this->App_model->AddUpdateData('user_address',$address_data);
				   		$response['status']=TRUE;
						$response['message']="Success";
						$response['otp']=$otp;
						$response['id']=$id;
					}else{
						$response['message']="Something Went Wrong!";
						$response['status']=FALSE;
						$response['otp']='';
						$response['id']='';
					}
				}
				echo json_encode($response);
			}  
			return false;
		}

// Resend OTP
		public function resendOTP_POST(){
			if($_POST){
				$response['status']=TRUE;
				$id=$this->input->post('id');
				$phone=$this->input->post('phone');
				if($id>0){
					$otp=generateOTP();
					$data=array('id' =>$id,'otp' => $otp);
					$this->App_model->AddUpdateData('users',$data);
					sendSMS($phone,$otp);
					$response['status']=TRUE;
					$response['message']="Success";
					$response['otp']=$otp;
					$response['id']=$id;
				}else{
					$response['message']="Something Went Wrong!";
					$response['status']=FALSE;
					$response['otp']='';
					$response['id']='';
				}
				echo json_encode($response);
			}  
			return false;
		}

		// Verification
		public function verification_POST(){
			if($_POST){
				$response['response']=(object)array();
				$response['status']=TRUE;
				$otp=$this->input->post('otp');
				$id=$this->input->post('id');
				if($id>0 && !empty($otp)){
					$check_data=array('u.id'=>$id);
					 $user_data = $this->App_model->loginCheck($check_data);
					 if($user_data['otp']==$otp){
						$update_data=array('id' =>$id,'otp' => '','phone_verified'=>0);
						$this->App_model->AddUpdateData('users',$update_data); 
						$template_data['registration']=$user_data;
						$this->db->select('r.name as role_name');
						$this->db->from('users u');
						$this->db->join('role r ','r.id=u.role_id','inner');
						$this->db->where('u.id',$id);
						$result=$this->db->get();
						$data=$result->row_array();
						
						$template_data['registration']['role_name']=$data['role_name'];
						$mail_message=$this->load->view('website/email_templates/registration-admin', $template_data, true);
						sendEmail(ADMINEMAIL,"",'Registration',$mail_message);

						$this->db->where('id',1);
						$email_data=$this->db->get('email_templates')->row_array();
						$template_data['email_data']=$email_data;

						$mail_message=$this->load->view('website/email_templates/registration-customer', $template_data, true);
						sendEmail($user_data['email'],"",$email_data['subject'],$mail_message);
						$response['response']=$user_data;
						$response['message']="Your Registration has been completed successfully";
					 }else{
						$response['message']="Wrong OTP!";
						$response['status']=FALSE;
					 }
				}else{
					$response['message']="Data Missing!";
					$response['status']=FALSE;
				}
				echo json_encode($response);
			}  
			return false;
		}


		// Login With Email
		public function loginWithEmail_POST(){
			$response['response']=(object)array();
			if(isset($_POST)){
				$fcm_id=$this->input->post('fcm_id');
				$check_data=array(
 				'u.email'=>$this->input->post('username'),
				'u.password'=>sha1($this->input->post('password')),
				);
				$result = $this->App_model->loginCheck($check_data);
				if (!empty($result)) {
					if(!$result['verified']){
						$response['status']=false;
						$response['message']='Your account needs to verification!';
					}else{
						if(!$result['status']){
							$response['status']=false;
							$response['message']='Your account needs to verify by admin!';
						}else{
							$data=array('id' => $result['id'],'last_login' => date("Y-m-d h:i:sa"),'fcm_id'=>$fcm_id);
							$this->App_model->AddUpdateData('users',$data);
							$response['status']=true;
							$response['message']='You have successfully loggedin!';
							$response['response']=$result;
						}
					}
				} else {
					$response['status']=false;
					$response['message']='Wrong username or password!';
				}
			echo json_encode($response);
			}
		}

		//Login With Phone
		public function loginPhone_POST(){
 		   if(isset($_POST)){
			   $check_data=array(
 				   'u.phone'=>$this->input->post('phone'),
 			   );
			   $result = $this->App_model->loginCheck($check_data);
			   if ($result) {
					$otp=1234;//generateOTPgenerateOTP();
 					$data=array('id' => $result['id'],'otp' => $otp);
					$this->App_model->AddUpdateData('users',$data);
					sendSMS($result['phone'],$otp);
					$response['status']=true;
					$response['otp']=$otp;
					$response['message']='OTP Sent';
			   } else {
				   $response['status']=false;
				   $response['otp']='';
				   $response['message']='Phone no does not exists!';
			   }
			   echo json_encode($response);
		   }
	   }

		// Verify  Login With OTP
	   public function verifyLoginPhone_POST(){
			$response['response']=(object)array();
			if(isset($_POST)){
				$fcm_id=$this->input->post('fcm_id');
				$check_data=array(
 					'u.phone'=>$this->input->post('phone'),
					// 'otp'=>$this->input->post('otp'),
					 'u.otp'=>1234,
					);
				$result = $this->App_model->loginCheck($check_data);
			if ($result) {
				//$data=array('id' => $result['id'],'last_login' => date("Y-m-d h:i:sa"),'fcm_id'=>$fcm_id,'otp'=>'');
				$data=array('id' => $result['id'],'last_login' => date("Y-m-d h:i:sa"),'fcm_id'=>$fcm_id);
				$this->App_model->AddUpdateData('users',$data);
				$response['status']=true;
				$response['message']='You have successfully loggedin!';
				$response['response']=$result;
			} else {
				$response['status']=false;
				$response['message']='OTP does not matches!';
			}
			echo json_encode($response);
		}
	}

	public function forgotPassword_POST(){
		$response['response']=(object)array();
		if(isset($_POST) && !empty($this->input->post('email'))){
			$check_data=array(
				'u.email'=>$this->input->post('email'),
			);
			$result = $this->App_model->loginCheck($check_data);
			if (!empty($result)) {
				$verified=$result['verified'];
				if(!$verified){
					$response['status']=false;
					$response['message']='You account needs to verification!';
				}else{
					$status=$result['status'];
					if(!$status){
						$response['status']=false;
						$response['message']='You account needs to verify by admin!';
					}else{
						$updatedata=array(
						'id'=>$result['id'],
						'verification_code'=>sha1(time()),
						);
						$this->App_model->AddUpdateData('users',$updatedata);
						$template_data['forgot_password']['name']=$result['first_name'].' '.$result['last_name'];
						$template_data['forgot_password']['link']=base_url('change-password/'.$updatedata['verification_code']);
						$mail_message=$this->load->view('website/email_templates/forgot-password', $template_data, true);
						sendEmail($result['email'],"",'Forgot Password',$mail_message);
						$response['status']=true;
						$response['message']='Password reset link has been sent to your email!';
					}
				}
			} else {
				$response['status']=false;
				$response['message']='Email Address not exists!';
			}
			echo json_encode($response);
		}
	}


	public function loginRegistrationWithFacebook_POST(){
		$response['otp']='';
		$response['response']=(object)array();
		if(isset($_POST) && !empty($this->input->post('email'))){
			$check_data=array(
				'u.email'=>$this->input->post('email'),
			);
 			$result=$this->App_model->loginCheck($check_data);
			if (!empty($result)) {
				$data=array('id' => $result['id'],'last_login' => date("Y-m-d h:i:sa"),'fcm_id'=>$this->input->post('fcm_id'));
				$this->App_model->AddUpdateData('users',$data);
				$response['status']=true;
				$response['response']=$result;
			} else {
				$check_data=array('id'=>0,'email'=>$this->input->post('email'));
				if(!empty($this->input->post('fcm_id'))){
					$check_data['fcm_id']=$this->input->post('fcm_id');
				}
				if(!empty($this->input->post('role_id'))){
					$check_data['role_id']=$this->input->post('role_id');
				}
				if(!empty($this->input->post('name'))){
					$check_data['first_name']=$this->input->post('name');
				}
				$check_data['verified']=1;	 
				$id=$this->App_model->AddUpdateData('users',$check_data);
				if($id>0){
					if(!empty($data['first_name'])){
						$update_data=array('id'=>$id,'modified_date'=>'now()');
						$slug=makeSlug($data['first_name'].$id);
						$update_data['slug']=$slug;
						$this->App_model->AddUpdateData('users',$update_data);
					}
					$address_data['id']=0;
					$address_data['user_id']=$id;
					$address_data['email']=$check_data['email'];
					$this->App_model->AddUpdateData('user_address',$address_data);
				   	$response['status']=TRUE;
					$response['message']='You have successfully loggedin!';
					$response['id']=$id;
					$response['response']=$check_data;
				}else{
					$response['message']="Something Went Wrong!";
					$response['status']=FALSE;
					$response['id']='';
				}
			}
			echo json_encode($response);
		}
	}


	function updateGrowerFarmInfo_POST(){
		if($_POST && $this->input->post('id')>0){
			$response['status']=TRUE;
			$data=array(
				'id'=>$this->input->post('id')
 			);

			if(!empty($this->input->post('firm_name'))){
				$data['firm_name']=$this->input->post('firm_name');
			}

			if(!empty($this->input->post('firm_description'))){
				$data['firm_description']=$this->input->post('firm_description');
			}

			if($response['status']){
				if(!empty($_FILES['firm_image']['name'])){
					$old_image=$this->input->post('old_image')?$this->input->post('old_image'):'';
					$allowed_types ='png|jpg|jpeg|gif';
					$input_name = 'firm_image';
					$file_response=uploadImage('users',$allowed_types,$input_name,$old_image);
					if($file_response['status']){
						$data['firm_image']=$file_response['name'];
					}else{
						$response['status']=false;
						$response['message']=$file_response['message'];
					}
				}else{
					$data['firm_image']=$old_image;
				}
				if($response['status']){
					$this->App_model->AddUpdateData('users',$data);
					$response['message']="Your Firm info has been updated successfully";
				}
			}
			echo json_encode($response);
		}  
		return false;
	}


	function getData_POST(){
		if($_POST && $this->input->post('id')>0){
			$response['response']=(object)array();
			$response['status']=TRUE;
			$where=array(
				'u.id'=>$this->input->post('id')
 			);
			$response['response']=$this->App_model->getData($where);
 			$response['message']="Data List";
 			echo json_encode($response);
		}  
		return false;
	} 

	

	public function growerUpdateProfile_POST(){
		if($_POST && $this->input->post('id')>0){
		$response['status']=TRUE;
			$data=array(
			'id'=>$this->input->post('id'),
			'role_id'=>2
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
		
		if(!empty($this->input->post('firm_name'))){
			$data['firm_name']=$this->input->post('firm_name');
		}
		if(!empty($this->input->post('firm_description'))){
			$data['firm_description']=$this->input->post('firm_description');
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
			if(!empty($_FILES['firm_image']['name'])){
				$old_firm_image=$this->input->post('old_firm_image')?$this->input->post('old_firm_image'):'';
				$allowed_types ='png|jpg|jpeg|gif';
				$input_name = 'firm_image';
				$file_response=uploadImage('users',$allowed_types,$input_name,$old_firm_image);
				if($file_response['status']){
					$data['firm_image']=$file_response['name'];
				}else{
					$response['status']=false;
					$response['message']=$file_response['message'];
				}
			} 


			if($response['status']){
				$grower_id=$this->App_model->AddUpdateData('users',$data);
				if(!empty($this->input->post('address'))){
					if(!empty($this->input->post('latitude'))){
						$address_data['latitude']=$this->input->post('latitude');
					}
					if(!empty($this->input->post('longitude'))){
						$address_data['longitude']=$this->input->post('longitude');
					}
					$address_data['address']=$this->input->post('address');
					$address_data['id']=$this->input->post('address_id')?$this->input->post('address_id'):0;
					$address_data['user_id']=$grower_id;
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


	///////////////Grower Add Product///////////////////

	// Auto Suggestion Product 
	function autoSuggestionProduct_POST(){
		if($_POST && !empty($this->input->post('name'))){
			$response['response']=(object)array();
			$response['status']=TRUE;
			$name=$this->input->post('name')?$this->input->post('name'):'';
			$response['response']=$this->App_model->autoSuggestionProduct($name);
 			$response['message']="Product List";
 			echo json_encode($response);
		}  
		return false;
	} 

	function addCopyProduct_POST(){
 		if($_POST && !empty($this->input->post('id'))){ 
			$response['response']=array();
			$response['status']=TRUE;
			$response['response']['names']=array();
 			$select=array('vp.id'=>$this->input->post('id'));
			$response['response']['product']=$this->App_model->productData($select);
 			$response['response']['product']['image']='';
			$names=$this->App_model->productNamedata($select);
			if(count($names)>0){
				foreach($names as $name){
					$response['response']['names'][$name['abbr']]=$name;
				}	
			}
			$data['secondary_images']=array();
			$response['message']="Product Data";
 			echo json_encode($response);
		}
 		return false;
	}



	public function addProduct_POST(){
		if($_POST){ 
			$languages=getLanguageList();
			$response['response']=array();
			$product_secondary_image_arr=array();
			$response['status']=TRUE;
 			$image='';

			if(!empty($_FILES['product_image']['name'])){
				$allowed_types ='png|jpg|jpeg|gif';
				$input_name = 'product_image';
				$file_response=uploadImage('products',$allowed_types,$input_name,'');
				if($file_response['status']){
					$image=$file_response['name'];
				}else{
					$response['status']=false;
					$response['message']=$file_response['message'];
				}
			} 
			if(isset($_FILES['product_secondary_image']['name'])){
				$total_secondary_images=count($_FILES['product_secondary_image']['name']) ? count($_FILES['product_secondary_image']['name']):0;
			}else{
				$total_secondary_images=0;
 			}
 			if(count($total_secondary_images)>0){
				$allowed_types ='png|jpg|jpeg|gif';
				for($i=0;$i<$total_secondary_images;$i++){
					$_FILES['file']['name']     = $_FILES['product_secondary_image']['name'][$i];
					$_FILES['file']['type']     = $_FILES['product_secondary_image']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['product_secondary_image']['tmp_name'][$i];
					$_FILES['file']['error']     = $_FILES['product_secondary_image']['error'][$i];
					$_FILES['file']['size']     = $_FILES['product_secondary_image']['size'][$i];
					$input_name = 'file';
					$file_response=uploadImage('products',$allowed_types,$input_name,'');
					if($file_response['status']){
						$product_secondary_image_arr[] =array(
							'name'=>$file_response['name']);
					}else{
						$response['status']=false;
						$response['message']=$file_response['message'];
					}
				}
			}
			if($response['status']){
				$save_data=array(
					'id'=>0,
					'vendor_id'=>$this->input->post('vendor_id'),
					'product_id'=>$this->input->post('master_product_id'),
					'unit_id'=>$this->input->post('unit_id'),
					'unit_value'=>$this->input->post('unit_value'),
					'quantity'=>$this->input->post('quantity'),
					'price'=>$this->input->post('price'),
 					'maturity_date'=>date('Y-m-d',strtotime($this->input->post('maturity_date'))),
					'image'=>$image,
					'status'=>$this->input->post('status'),
					'meta_title'=>$this->input->post('meta_title'), 
					'meta_keywords'=>$this->input->post('meta_keywords'), 
					'meta_description'=>$this->input->post('meta_description'), 
				);
	
				$vendor_product_id=$this->App_model->AddUpdateData('vendor_products',$save_data);
				if($vendor_product_id){
	
					if(count($product_secondary_image_arr)>0){
						foreach($product_secondary_image_arr as $product_secondary_image){
							if(!empty($product_secondary_image['name'])){
								$save_image_data=array(
									'id'=>0,
									'vendor_product_id'=>$vendor_product_id,
									'image'=>$product_secondary_image['name']
								); 
								$this->App_model->AddUpdateData('product_images',$save_image_data);
							}
						}
					}
	
					 if(count($languages)){
						foreach($languages as $language){
							$save_data=array(
								'id'=>0,
								'vendor_product_id'=>$vendor_product_id,
								'product_id'=>$this->input->post('master_product_id'),
								'vendor_id'=>$this->input->post('vendor_id'),
								 'name'=>$this->input->post('name'.$language['abbr']),
								'abbr'=>$language['abbr'],
								'brief'=>$this->input->post('brief'.$language['abbr']),
								'description'=>$this->input->post('description'.$language['abbr']),
							);
							 $this->App_model->AddUpdateData('product_translator',$save_data);
						}
					}
				}
				$response['response']['message']="Product Added Successfully!";
				$response['message']="SUCCESS";
			}else{
				if(count($product_secondary_image_arr)>0){
					foreach($product_secondary_image_arr as $product_secondary_image){
 						unlinkImage('products',$product_secondary_image['name']);
					}
				}
				if(!empty($image)){
					unlinkImage('products',$image);
				}
				$response['response']['message']=$response['message'];
				$response['message']="Something went wrong!";

			}
			echo json_encode($response);
		}
		return false;
	}



	public function addUpdateProduct_POST(){
		if($_POST){ 
 			$id=$this->input->post('id')? $this->input->post('id'):0;
			$languages=getLanguageList();
			$response['status']=true;
			$old_image=$this->input->post('old_image');
			$product_image='';
			if(!empty($_FILES['product_image']['name'])){
				$allowed_types ='png|jpg|jpeg|gif';
				$input_name = 'product_image';
				$file_response=uploadImage('products',$allowed_types,$input_name,$old_image);
				if($file_response['status']){
					$product_image=$file_response['name'];
				}else{
					$response['status']=false;
					$message=$file_response['message'];
				}
			}
			if(isset($_FILES['product_secondary_image']['name'])){
				$total_Secondary_image=count($_FILES['product_secondary_image']['name']) ? count($_FILES['product_secondary_image']['name']):0;
			}else{
				$total_Secondary_image=0;
				$product_secondary_image_arr=array();
			}
			
 			if($total_Secondary_image>0){
				$allowed_types ='png|jpg|jpeg|gif';
				for($i=0;$i<$total_Secondary_image;$i++){
					$_FILES['file']['name']     = $_FILES['product_secondary_image']['name'][$i];
					$_FILES['file']['type']     = $_FILES['product_secondary_image']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['product_secondary_image']['tmp_name'][$i];
					$_FILES['file']['error']     = $_FILES['product_secondary_image']['error'][$i];
					$_FILES['file']['size']     = $_FILES['product_secondary_image']['size'][$i];
					$input_name = 'file';
					$file_response=uploadImage('products',$allowed_types,$input_name,'');
					if($file_response['status']){
						$product_secondary_image_arr[] =array(
						'name'=>$file_response['name']);
					}else{
						$response['status']=false;
						$message=$file_response['message'];
					}
				}
			}
			if($response['status']){
 				$vendor_product_id=$id;
				$master_product_id=$this->input->post('master_product_id');
				if($vendor_product_id>0){
					$product_id=$master_product_id;
				}else{  
					$save_data=array(
					'id'=>$this->input->post('id')? $this->input->post('id'):0,
 					'name'=>$this->input->post('name'.$languages[0]['abbr']), 
					'meta_title'=>$this->input->post('meta_title'), 
					'meta_keywords'=>$this->input->post('meta_keywords'), 
					'meta_description'=>$this->input->post('meta_description'), 
					'status'=>$this->input->post('status'),
					);
				   $product_id=$this->App_model->AddUpdateData('product_master',$save_data);
					$slug=makeSlug($save_data['name'].$languages[0]['abbr'].'-'.time());
					$update_data=array('id'=>$product_id,'slug'=>$slug,'modified_date'=>'now()');
					$this->App_model->AddUpdateData('product_master',$update_data);
	
					$categories=$this->input->post('category_ids');
					if(!empty($categories)){
						$category_arr=explode(',',$categories);
						if(count($category_arr)){
							foreach($category_arr as $category){
								if($category>0){
									$save_data=array(
										'id'=>0,
										'product_id'=>$product_id,
										'category_id'=>$category,
									);
									$this->App_model->AddUpdateData('product_category',$save_data);
								}
							}
						}
					}
				}
				if($product_id){
					$vendor_product_save_data=array(
					'id'=>$this->input->post('id')? $this->input->post('id'):0,
					 'product_id'=>$product_id,
					'vendor_id'=>$this->input->post('vendor_id'),
					'unit_id'=>$this->input->post('unit_id'),
					'unit_value'=>$this->input->post('unit_value'),
					'quantity'=>$this->input->post('quantity'),
					'price'=>$this->input->post('price'),
 					'meta_title'=>$this->input->post('meta_title'),
					'maturity_date'=>date('Y-m-d',strtotime($this->input->post('maturity_date'))),
					'meta_keywords'=>$this->input->post('meta_keywords'), 
					'meta_description'=>$this->input->post('meta_description'), 
					'status'=>$this->input->post('status'),
					);
					if(!empty($product_image)){
						$vendor_product_save_data['image']=$product_image;
					}
	
					$vendor_product_id=$this->App_model->AddUpdateData('vendor_products',$vendor_product_save_data);
					if($vendor_product_id){
						if(count($product_secondary_image_arr)>0){
							foreach($product_secondary_image_arr as $product_secondary_image){
								if(!empty($product_secondary_image['name'])){
									$save_image_data=array(
										'id'=>0,
										'vendor_product_id'=>$vendor_product_id,
										'image'=>$product_secondary_image['name']
									); 
									$this->App_model->AddUpdateData('product_images',$save_image_data);
								}
							}
						}
						 if(count($languages)){
							$this->db->where('vendor_product_id',$vendor_product_id);
							$this->db->delete('product_translator');
							foreach($languages as $language){
								$save_data=array(
								'id'=>0,
								'vendor_product_id'=>$vendor_product_id,
								'product_id'=>$product_id,
								'vendor_id'=>$this->input->post('vendor_id'),
								'name'=>$this->input->post('name'.$language['abbr']),
								'abbr'=>$language['abbr'],
								'brief'=>$this->input->post('brief'.$language['abbr']),
								'description'=>$this->input->post('description'.$language['abbr']),
								'status'=>$this->input->post('status'),
								);
								$this->App_model->AddUpdateData('product_translator',$save_data);
							}
						}
					}
				}
				if($vendor_product_save_data['id']>0){
					$id=$vendor_product_save_data['id'];
					$action="Updated";
				}else{
					$id=$vendor_product_id;
					$action="Added";
				}
				$message = "Product ".$action." Successfully!";
			}else{
				if(count($product_secondary_image_arr)>0){
					foreach($product_secondary_image_arr as $product_secondary_image){
						 unlinkImage('products',$product_secondary_image['name']);
					}
				}
				if(!empty($product_image)){
					unlinkImage('products',$product_image);
				}
			}
			$response['response']['message']=$message;
			echo json_encode($response);
		}
	}


	public function ProductList_POST(){
		if($_POST){
			$start=$this->input->post('start') ? $this->input->post('start'):0;
			$length=$this->input->post('length') ? $this->input->post('length'):100;
			$vendor_id=$this->input->post('vendor_id');
			$vendor_product_id=$this->input->post('vendor_product_id');
			 
			$condition['where']=array(
				'pm.is_deleted'=>0,
				'vp.is_deleted'=>0,
				'pm.status'=>1,
				'vp.status'=>1,
				'pt.abbr'=>$this->input->post('language')
 			);
			if($vendor_id>0){
				$condition['where']['vp.vendor_id']=$vendor_id;
			}
			if($vendor_product_id>0){
				$condition['where']['vp.id']=$vendor_product_id;
			}
			
			$condition['start']=$start;
			$condition['length']=$length;
 		  
			$data=$this->App_model->manageProducts($condition);
			$response['response']=array();
			if(count($data)){
				foreach($data as $row){
					if(is_file('./attachments/products/thumb/'.$row['image'])){
						$image=$row['image'];	
				   }else{
					   $image='';
				   }
					$response['response'][]=array(
						'id'=>$row['id'],
						'master_product_id'=>$row['master_product_id'],
						'image'=>$image,
						'name'=>$row['name'],
 						'brief'=>$row['brief'],
						'language_name'=>$row['language_name'],
						'abbr'=>$row['abbr'],
						'description'=>$row['description'],
						'maturity_date'=>$row['maturity_date'],
						'vendor_name'=>$row['vendor_name'],
						'category_name'=>$row['category_name'],
						 'price'=>$row['price'], 
						 'unit_name'=>$row['unit_name'],
						 'unit_value'=>$row['unit_value'],
						'quantity'=>$row['quantity'],
						'status'=>$row['status'],
					 );
				}
				$response['message']="Product List";
				$response['status']=TRUE;
				$response['total']=count($data);
			}else{
				$response['message']="No Record Found";
				$response['status']=FALSE;
				$response['total']=0;
			}
			$response['imagePath']="./attachments/products/";
			echo json_encode($response);
		}
 		
	}


	public function VendorProductDelete_POST(){
		if($_POST && $this->input->post('vendor_id')>0){
 			$vendor_id=$this->input->post('vendor_id');
			$vendor_product_id=$this->input->post('vendor_product_id');
		 	$where=array('id'=>$vendor_product_id);
			$update_data['is_deleted']=1;
 			$response['status']=$this->Common_model->updateData('vendor_products',$where,$update_data);
			if($response['status']){
				$where=array('vendor_product_id'=>$vendor_product_id);
 				$this->Common_model->updateData('product_images',$where,$update_data);
				$this->Common_model->updateData('product_translator',$where,$update_data);
				$response['message']="Product Deleted Successfully";
			}
			else
			{
				$response['message']="Something Went Wrong";

			}
			echo json_encode($response);
		}
 		
	}
	

	function productGalleryImages_POST(){
		if($_POST && $this->input->post('vendor_product_id')>0){
			$where['vendor_product_id']=$this->input->post('vendor_product_id');
			$where['is_deleted']=0;
			$data=$this->App_model->productGalleryImages($where);
			$response['response']=array();
			if(count($data)){
				foreach($data as $row){
					if(is_file('./attachments/products/thumb/'.$row['image'])){
						$image=$row['image'];	
				   }else{
					   $image='';
				   }
					$response['response'][]=array(
						'id'=>$row['id'],
						'image'=>$image,
					 );
				}
				$response['message']="product Gallery Images";
				$response['status']=TRUE;
				$response['total']=count($response['response']);
			}else{
				$response['message']="No Record Found";
				$response['status']=FALSE;
				$response['total']=0;
			}
			$response['imagePath']="./attachments/products/";
			echo json_encode($response);
		}
	}




	function deleteProductImage_POST(){
		if($_POST && $this->input->post('vendor_product_id')>0){
			$update_data['id']=$this->input->post('vendor_product_id');
			$image=$this->input->post('image');
			$update_data['image']='';
 			$vendor_product_id=$this->App_model->AddUpdateData('vendor_products',$update_data);
			$response['response']=array();
			if(count($vendor_product_id)){
				unlinkImage('products',$image);
				$response['message']="product image deleted successfully";
				$response['status']=TRUE;
 			}else{
				$response['message']="Something went wrong";
				$response['status']=FALSE;
 			}
 			echo json_encode($response);
		}
	}
	
	function deleteProductGalleryImage_POST(){
		if($_POST && $this->input->post('image_id')>0){
			$update_data['id']=$this->input->post('image_id');
			$image=$this->input->post('image');
  			$image_id=$this->App_model->deleteRecord($update_data,'product_images');
			$response['response']=array();
			if(count($image_id)){
				unlinkImage('products',$image);
				$response['message']="Product gallery image deleted successfully";
				$response['status']=TRUE;
 			}else{
				$response['message']="Something went wrong";
				$response['status']=FALSE;
 			}
 			echo json_encode($response);
		}
	}
 

	public function fetchFaqData_POST(){
			$response['response']=(object)array();
			$where=array();
			$like=array();
			$id=$this->input->post('id');
			$search=$this->input->post('search');
			if(!empty($search)){
				$like['question']=$search;
				$like['answer']=$search;
			}
			if($id>0){
				$where['id']=$id;
			}
			$response['response']=$this->App_model->fetchFaqData($where,$like);

			 if(count($response)>0){
				$response['status']=true;
				$response['message']="Faq List!";
			}else{
				$response['status']=false;
				$response['message']="No record Found!";
			}
			echo json_encode($response);
	}


	public function fetchCmsData_POST(){
		if($_POST && $this->input->post('id')>0){
			$response['response']=(object)array();
   			$where['id']=$this->input->post('id');
			$response['response']=$this->App_model->fetchCmsData($where);
			if(count($response)>0){
				$response['status']=true;
				$response['message']="CMS Data!";
			}else{
				$response['status']=false;
				$response['message']="No record Found!";
			}
			echo json_encode($response);
		}
}



	function getProducts_POST(){
		$response['response']=(object)array();
		$response['status']=TRUE;
		$language=$this->input->post('language')?$this->input->post('language'):'en';
		//$parent_id=$this->input->post('parent_id')?$this->input->post('parent_id'):0;
		$params['where']=array('pt.abbr'=>$language);
		$response['response']=$this->App_model->getProducts($params);
		$response['message']="Product List";
		echo json_encode($response);
		return false;
	}


/// CMS Page


	/////// grower Login//////////////
		


		


		
	     
		
///////////////////////////////////////Delivery Boy///////////////////////

		 


		public function deliveryBoyLogin_POST(){
			if(isset($_POST)){
				$check_data=array(
					'u.role_id'=>4,
					'u.phone'=>$this->input->post('phone'),
				);
				$result = $this->App_model->loginCheck($check_data);

				if (!empty($result)) {
				$otp=generateOTP();
					$data=array('id' => $result['id'],'otp' => $otp);
				$this->App_model->addUpdateRecord('users',$data);
				sendSMS($result['phone'],$otp);
					$response['status']=true;
					$response['message']='OTP Sent';
				} else {
					$response['status']=false;
					$response['message']='Phone no does not exists!';
				}
				echo json_encode($response);
			}
		}

		public function verifyDeliveryBoyLogin_POST(){
			$response['response']=(object)array();
			if(isset($_POST)){
				$fcm_id=$this->input->post('fcm_id');
				$check_data=array(
					'u.role_id'=>4,
					'u.phone'=>$this->input->post('phone'),
					'u.otp'=>$this->input->post('otp'),
				);
				$result = $this->App_model->loginCheck($check_data);

				if (!empty($result)) {
					$data=array('id' => $result['id'],'last_login' => date("Y-m-d h:i:sa"),'fcm_id'=>$fcm_id);
					$this->App_model->addUpdateRecord('users',$data);
					$response['status']=true;
					$response['message']='You have successfully loggedin!';
					$response['response']=$result;
				} else {
					$response['status']=false;
					$response['message']='OTP does not matches!';
				}
				echo json_encode($response);
			}
		}

		public function deliveryBoyRegistration_POST(){
			if($_POST){
			$response['status']=TRUE;
				$grower_data=array(
				'id'=>$this->input->post('id')?$this->input->post('id'):0,
				'role_id'=>4
			);
			
			if(!empty($this->input->post('first_name'))){
				$grower_data['first_name']=$this->input->post('first_name');
			}

			if(!empty($this->input->post('last_name'))){
				$grower_data['last_name']=$this->input->post('last_name');
			}
							
			if(!empty($this->input->post('password'))){
				$grower_data['password']=sha1($this->input->post('password'));
			}

			if(!empty($this->input->post('phone'))){
				$grower_data['phone']=$this->input->post('phone');
			}else{
				$response['status']=FALSE;
				$response['message']="Phone no is required!";
			}

			if(!empty($this->input->post('fcm_id'))){
				$grower_data['fcm_id']=$this->input->post('fcm_id');
			}

			if(!empty($this->input->post('email'))){
				$grower_data['email']=$this->input->post('email');
				if($grower_data['id']>0){
					$where['id <>']=$grower_data['id'];
				}
				$where['email']=$grower_data['email'];
				$email_exist=$this->App_model->checkExist('users',$where);
					if(!$this->App_model->checkExist('users',$where)){
					$response['status']=FALSE;
					$response['message']="Email Address already exists!";
				}
			}else{
				$response['status']=FALSE;
				$response['message']="Email Address no is required!";
			}

			if(!empty($this->input->post('phone'))){
				$where=array();
				$grower_data['phone']=$this->input->post('phone');
				if($grower_data['id']>0){
					$where['id <>']=$grower_data['id'];
				}
				$where['phone']=$grower_data['phone'];
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
						$grower_data['image']=$file_response['name'];
					}else{
						$response['status']=false;
						$response['message']=$file_response['message'];
					}
				}else{
					$grower_data['image']=$old_image;
				}
				if($response['status']){
						
					$grower_id=$this->App_model->addUpdateRecord('users',$grower_data);
					$grower_address_data['id']=0;
					$grower_address_data['user_id']=$grower_id;
					if(!empty($this->input->post('address'))){
						$grower_address_data['address']=$this->input->post('address');
					}
					if(!empty($this->input->post('street'))){
						$grower_address_data['street']=$this->input->post('street');
					}
						$this->App_model->addUpdateRecord('user_address',$grower_address_data);
						if($grower_data['id']>0){
						$response['message']="Your Profile has been updated successfully";
					}else{
						$response['message']="Your Registration has been completed successfully";
					}
				}
			}
			echo json_encode($response);
		}  
		return false;
		}

		public function addUpdateDeliveryBoyVehicleDetails_POST(){
			if($_POST){
				$allowed_types ='png|jpg|jpeg|gif';
				$response['status']=TRUE;
				$files=array();

				$vehicle_data=array(
					'id'=>$this->input->post('id')?$this->input->post('id'):0,
					'delivery_boy_id'=>$this->input->post('user_id'),
				);
				
				if(!empty($this->input->post('vehicle_no'))){
					$vehicle_data['vehicle_no']=$this->input->post('vehicle_no');
				}

				if(!empty($this->input->post('type'))){
					$vehicle_data['type']=$this->input->post('type');
				}
				if(!empty($this->input->post('model'))){
					$vehicle_data['model']=$this->input->post('model');
				}
				if(!empty($this->input->post('registration_year'))){
					$vehicle_data['registration_year']=$this->input->post('registration_year');
				}
	
				if(!empty($_FILES['front_image']['name'])){
					$old_front_image_image=$this->input->post('old_front_image_image')?$this->input->post('old_front_image_image'):'';
 					$input_name = 'front_image';
					$file_response=uploadImage('user-vehicle',$allowed_types,$input_name,$old_front_image_image);
					if($file_response['status']){
						$vehicle_data['front_image']=$file_response['name'];
						$files[]=$file_response['name'];

					}else{
						$response['status']=false;
						$response['message']=$file_response['message'];
					}
				}else{
					$vehicle_data['front_image']=$old_front_image_image;
				}
				if(!empty($_FILES['back_image']['name'])){
					$old_back_image_image=$this->input->post('old_back_image_image')?$this->input->post('old_back_image_image'):'';
 					$input_name = 'back_image';
					$file_response=uploadImage('user-vehicle',$allowed_types,$input_name,$old_back_image_image);
					if($file_response['status']){
						$vehicle_data['back_image']=$file_response['name'];
						$files[]=$file_response['name'];

					}else{
						$response['status']=false;
						$response['message']=$file_response['message'];
					}
				}else{
					$vehicle_data['back_image']=$old_back_image_image;
				}

				if(!empty($_FILES['front_license']['name'])){
					$old_front_license=$this->input->post('old_front_license')?$this->input->post('old_front_license'):'';
 					$input_name = 'front_license';
					$file_response=uploadImage('user-vehicle',$allowed_types,$input_name,$old_front_license);
 					if($file_response['status']){
						$vehicle_data['front_license']=$file_response['name'];
						$files[]=$file_response['name'];

					}else{
						$response['status']=false;
						$response['message']=$file_response['message'];
 					}
				}else{
					$vehicle_data['front_license']=$old_front_license;
				}

				if(!empty($_FILES['back_license']['name'])){
					$old_back_license=$this->input->post('old_back_license')?$this->input->post('old_back_license'):'';
 					$input_name = 'back_license';
					$file_response=uploadImage('user-vehicle',$allowed_types,$input_name,$old_back_license);
					if($file_response['status']){
						$vehicle_data['back_license']=$file_response['name'];
						$files[]=$file_response['name'];
					}else{
						$response['status']=false;
						$response['message']=$file_response['message'];
					}
				}else{
					$vehicle_data['back_license']=$old_back_license;
				}

				if(!empty($_FILES['insurance_photo']['name'])){
					$old_insurance_photo=$this->input->post('old_insurance_photo')?$this->input->post('old_insurance_photo'):'';
 					$input_name = 'insurance_photo';
					$file_response=uploadImage('user-vehicle',$allowed_types,$input_name,$old_insurance_photo);
					if($file_response['status']){
						$vehicle_data['insurance_photo']=$file_response['name'];
						$files[]=$file_response['name'];
					}else{
						$response['status']=false;
						$response['message']=$file_response['message'];
					}
				}else{
					$vehicle_data['insurance_photo']=$old_insurance_photo;
				}
				if($response['status']){
 					$vehicle_id=$this->App_model->addUpdateRecord('delivery_boy_vehicle_details',$vehicle_data);
					if($vehicle_data['id']>0){
						$response['message']="Vehicle information has been updated successfully";
					}else{
						$response['message']="Vehicle information has been added successfully";
					}
				}else{
					if(count($files)>0){
						foreach($files as $file){
							unlinkImage('user-vehicle',$file);
						}
					}  
				}
				echo json_encode($response);
			}  
		}

 
		

	}
 