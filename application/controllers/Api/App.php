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
 			$where=array(
				 'c.status'=>1,
				 'c.is_deleted'=>0,
				 'c.parent_id'=>$this->input->post('parent_id')?$this->input->post('parent_id'):0,
				 'ct.abbr'=>$this->input->post('language')?$this->input->post('language'):'en'
				);
			$response['response']=categoryList($where);
			$response['message']="Category List";
			echo json_encode($response);
			return false;
		}
	
		function getUnits_POST(){
			$response['response']=(object)array();
			$response['status']=TRUE;
			$where=array('u.status'=>1,'u.is_deleted'=>0,'ut.abbr'=>$this->input->post('language')?$this->input->post('language'):'en');
			$response['response']=getUnitList($where);
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
 			$response['response']=$this->Common_model->getCountryList(array('id'=>65));
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
 			$response['response']=$this->App_model->providerServiceCategory(array('sc.status'=>1,'sc.is_deleted'=>0,'sct.abbr'=>$this->input->post('language') ? $this->input->post('language'):'en'));
 			$response['message']="Service Category List";
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
					$data['forecast']= $this->input->post('forecast')?$this->input->post('forecast'):0;
					$data['publication']= $this->input->post('publication')?$this->input->post('publication'):0;
					$data['matching']= $this->input->post('matching')?$this->input->post('matching'):0;
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
						if(!empty($this->input->post('country_id'))){
							$address_data['country']=$this->input->post('country_id');
						}
						if(!empty($this->input->post('state_id'))){
							$address_data['state']=$this->input->post('state_id');
						}
						if(!empty($this->input->post('city_id'))){
							$address_data['city']=$this->input->post('city_id');
						}
						if(!empty($this->input->post('street'))){
							$address_data['street']=$this->input->post('street');
						}
						if(!empty($this->input->post('first_name'))){
							$address_data['name']=$this->input->post('first_name');
						}
						if(!empty($this->input->post('phone'))){
							$address_data['phone']=$this->input->post('phone');
						}
						if(!empty($this->input->post('email'))){
							$address_data['email']=$this->input->post('email');
						}
						$address_data['address_type']='Home';					
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
 				$phone=$this->input->post('phone');
				$check_data=array('u.phone'=>$phone);
				$user_data = $this->App_model->loginCheck($check_data);
				if(!empty($phone)){
					if($user_data){
						$id=$user_data['id'];
						$otp=generateOTP();
						$data=array('id' =>$id,'otp' => $otp);
						$this->App_model->AddUpdateData('users',$data);
						sendSMS($phone,$otp);
						$response['status']=TRUE;
						$response['message']="Success";
						$response['id']=$id;
						$response['otp']=$otp;
					 }else{
						$response['message']="Phone no Not Exists!";
						$response['status']=FALSE;
						$response['otp']='';
						$response['id']=0;
 					}
				}else{
					$response['message']="Phone is missing!";
					$response['status']=FALSE;
					$response['otp']='';
					$response['id']=0;
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
			   //echo"<pre>"; print_r($result); die;
			   if ($result) {
			   	
					//$otp=generateOTP();
			   	$otp=1234;
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
					//'u.otp'=>$this->input->post('otp'),
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
						$slug=makeSlug($data['first_name'].'-'.$id);
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
			$response['imagePath']="./attachments/users/";
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
				$data['forecast']= $this->input->post('forecast')?$this->input->post('forecast'):0;
				$data['publication']= $this->input->post('publication')?$this->input->post('publication'):0;
				//$data['matching']= $this->input->post('matching')?$this->input->post('matching'):0;
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
					if(!empty($this->input->post('country_id'))){
						$address_data['country']=$this->input->post('country_id');
					}
					if(!empty($this->input->post('state_id'))){
						$address_data['state']=$this->input->post('state_id');
					}
					if(!empty($this->input->post('city_id'))){
						$address_data['city']=$this->input->post('city_id');
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
 			$select=array('vp.id'=>$this->input->post('id'),'ut.abbr'=>$this->input->post('language')?$this->input->post('language'):'en');
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
 					'maturity_to_date'=>date('Y-m-d',strtotime($this->input->post('maturity_to_date'))),
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
							 if($language['abbr']=='en'){
								$slug=makeSlug($save_data['name'].'-'.$vendor_product_id);
								$update_data=array('id'=>$vendor_product_id,'slug'=>$slug,'modified_date'=>'now()');
								$this->App_model->AddUpdateData('vendor_products',$update_data);
							 }
						}
					}
					$response['response']['message']="Product Added Successfully!";
					$response['message']="SUCCESS";
				}else{
					$response['status']=FALSE;
					$message = "Something went Wrong!";
				}
				
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
			if($response['status'] && $this->input->post('vendor_id')>0){
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
					$slug=makeSlug($save_data['name'].$languages[0]['abbr'].'-'.$product_id);
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
					'unit_id'=>$this->input->post('unit_id')?$this->input->post('unit_id'):0,
					'unit_value'=>$this->input->post('unit_value')?$this->input->post('unit_value'):0,
					'quantity'=>$this->input->post('quantity')?$this->input->post('quantity'):0,
					'price'=>$this->input->post('price')?$this->input->post('price'):0,
 					'meta_title'=>$this->input->post('meta_title')?$this->input->post('meta_title'):'',
					'maturity_date'=>date('Y-m-d',strtotime($this->input->post('maturity_date'))),
					'maturity_to_date'=>date('Y-m-d',strtotime($this->input->post('maturity_to_date'))),
					'meta_keywords'=>$this->input->post('meta_keywords')?$this->input->post('meta_keywords'):'', 
					'meta_description'=>$this->input->post('meta_description')?$this->input->post('meta_description'):'', 
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
								if($language['abbr']=='en'){
									$slug=makeSlug($save_data['name'].'-'.$vendor_product_id);
									$update_data=array('id'=>$vendor_product_id,'slug'=>$slug,'modified_date'=>'now()');
									$this->App_model->AddUpdateData('vendor_products',$update_data);
								 }
							}
						}
					}
				}else{
					$response['status']=FALSE;
					$response['MESSAGE'] ="MESSAGE";
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
				$response['status']=FALSE;
				$message = "Something went Wrong!";
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
			 $sort=$this->input->post('sort')?$this->input->post('sort'):0;
			 
			$condition['where']=array(
				'pm.is_deleted'=>0,
				'vp.is_deleted'=>0,
				'pm.status'=>1,
				//'vp.status'=>1,
				'pt.abbr'=>$this->input->post('language')?$this->input->post('language'):'en',
				'ut.abbr'=>$this->input->post('language')?$this->input->post('language'):'en'

 			);
			if($vendor_id>0){
				$condition['where']['vp.vendor_id']=$vendor_id;
			}
			if($vendor_product_id>0){
				$condition['where']['vp.id']=$vendor_product_id;
			}
			if($sort==1){
				$condition['order_by']='vp.added_date';	
			}
			if($sort==2){
				$condition['order_by']='vp.totalsale';	
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
						'totalsale'=>$row['totalsale'],
						'abbr'=>$row['abbr'],
						'description'=>$row['description'],
						'maturity_date'=>$row['maturity_date'],
						'maturity_to_date'=>$row['maturity_to_date'],
						'vendor_name'=>$row['vendor_name'],
						'category_name'=>$row['category_name'],
						'parent_category_name'=>$row['parent_category_name'],
						 'price'=>$row['price'], 
						 'unit_name'=>$row['unit_name'],
						 'unit_id'=>$row['unit_id'],
						 'unit_value'=>$row['unit_value'],
						'quantity'=>$row['quantity'],
						'category_id'=>$row['category_id'],
						'parent_category_id'=>$row['parent_category_id']?$row['parent_category_id']:0,
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
		$response['status']=FALSE;
		if($_POST && $this->input->post('vendor_id')>0 && $this->input->post('vendor_product_id')){
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
				$response['status']=TRUE;
			}
			else
			{
				$response['message']="Something Went Wrong";
			}
	
		}
		else{
			$response['message']="Something Went Wrong";

		}
 		echo json_encode($response);
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
		if($_POST && $this->input->post('vendor_product_id')>0 && !empty($image)){
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
			$where['ft.abbr']=$this->input->post('language')?$this->input->post('language'):'en';
			$search=$this->input->post('search');
			if(!empty($search)){
				$like['ft.question']=$search;
				$like['ft.answer']=$search;
			}
			if($id>0){
				$where['f.id']=$id;
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
   			$where['cp.id']=$this->input->post('id');
   			$where['pt.abbr']=$this->input->post('language')?$this->input->post('language'):'en';
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
	

	function getNotificationList_POST(){
		if($this->input->post('id')>0){
			$response['response']=(object)array();
			$response['status']=TRUE;
			$where=array('customer_id'=>$this->input->post('id'));
			if (!empty($this->input->post('type'))) {
				$where['type']=$this->input->post('type');
			}
			$response['response']=$this->App_model->getSingleTableData('customer_notification_summary',$where);
			$response['message']="Notification List";
			$where['id']=$this->input->post('id');
			echo json_encode($response);
			return false;
		}
		
	}

	function getProducts_POST(){
		$response['response']=(object)array();
		$response['status']=TRUE;
		$language=$this->input->post('language')?$this->input->post('language'):'en';
		$parent_id=$this->input->post('parent_id')?$this->input->post('parent_id'):0;
		$params['where']=array('pt.abbr'=>$language);
		$response['response']=$this->App_model->getProducts($params);
		$response['message']="Product List";
		$response['imagePath']="./attachments/products/";
		echo json_encode($response);
		return false;
	}


	

	function weatherForecastt_POST(){
 		if(isset($_POST) && $this->input->post('vendor_id')>0){
 				$response['response']=(object)array();
				$response['status']=TRUE;
				$vendor_id=$this->input->post('vendor_id');
				$where=array('ua.user_id'=>$vendor_id);
				$address=$this->Common_model->vendorAddress($where);
 				$post_data=array('access_key'=>'572df6f7a732844bb4017960675abba4','query'=>$address['city_name']);
				$ch = curl_init("http://api.weatherstack.com/current?access_key=572df6f7a732844bb4017960675abba4&query=".$address['city_name']);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		
		 		$response['response']= json_decode(curl_exec($ch));
				$response['message']="Weather forecast ";
		 		echo json_encode($response);
				return false;
			
		}
		
	}



		public function getVendorOrders_POST(){
			if(isset($_POST) && $this->input->post('vendor_id')>0){
				$response['response']=(object)array();
				$response['status']=TRUE;
				$vendor_id=$this->input->post('vendor_id');
				$order_status=$this->input->post('order_status')?$this->input->post('order_status'):1;
				$where=array('od.vendor_id'=>$vendor_id,'o.order_status'=>$order_status);
				$response['response']=$this->App_model->getVendorOrder($where );
				$response['message']="Order list";
				echo json_encode($response);
			}
				
		}


		public function getVendorOrderDetails_POST(){
			if(isset($_POST) && $this->input->post('vendor_id')>0 && !empty($this->input->post('order_id'))){
				$response=array();
				$response['status']=TRUE;
				$order_id=$this->input->post('order_id');
				$vendor_id=$this->input->post('vendor_id');
				$language=$this->input->post('language')?$this->input->post('language'):'en';
				$where=array('od.vendor_id'=>$this->input->post('vendor_id'),'od.order_id'=>$order_id,'ct.abbr'=>$language,'ct2.abbr'=>$language,'pt.abbr'=>$language);
				$response['order_details']=$this->App_model->getVendorOrderDetails($where);
				$response['address']=$this->Common_model->getOrderAddress($order_id);
				$response['message']="Order Details";
				$response['imagePath']="./attachments/products/";
				echo json_encode($response);
			}
				
		} 

		function getSettingsDetail_POST(){
			$response['response']=$this->Common_model->getSettings();
			$response['message']="Settings Data";
			$response['status']=TRUE;
			echo json_encode($response);
	}

	public function contactUsNow_POST(){
		if (isset($_POST)) {
			$response['status']=true;
  			$this->form_validation->set_rules('name', 'Name', 'trim|required');
 			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
			$this->form_validation->set_rules('phone', 'Phone Number', 'required');
			$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
			$this->form_validation->set_rules('message', 'Message', 'trim|required');
			 
			if ($this->form_validation->run() == FALSE) {
				$response['response']=$this->form_validation->error_array();
				$response['status']=FALSE;
				$response['message']='There is error in submitting form!';
			}else{
				$save_data=array(
					'id'=>0,
 					'name'=>$this->input->post('name'),
 					'email'=>$this->input->post('email'),
					 'phone'=>$this->input->post('phone'),
					 'subject'=>$this->input->post('subject'),
					 'message'=>$this->input->post('message'),
 				);
				if($this->Common_model->AddUpdateData('contact_us',$save_data)){

					$template_data['contact_us']=$save_data;

					$mail_message=$this->load->view('website/email_templates/contact-us-admin', $template_data, true);
					$sent=sendEmail(ADMINEMAIL,"",'Contact US',$mail_message);
					$mail_message=$this->load->view('website/email_templates/contact-us-customer', $template_data, true);
				    sendEmail($save_data['email'],"",'Contact US',$mail_message);
				
					$message = "Thank you for filling out your information!";
				}else{
					$message = "There is an error!";
					$response['status']=FALSE;
				}
 				$response['message']=$message;
				$response['response']=array();
			}
			$response['imagePath']="./attachments/pages/";
			echo json_encode($response);
		}
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
				$this->App_model->AddUpdateData('users',$data);
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
					$grower_data['forecast']= $this->input->post('forecast')?$this->input->post('forecast'):0;
					$grower_data['publication']= $this->input->post('publication')?$this->input->post('publication'):0;
					$grower_data['matching']= $this->input->post('matching')?$this->input->post('matching'):0;
						
					$grower_id=$this->App_model->AddUpdateData('users',$grower_data);
					$grower_address_data['id']=0;
					$grower_address_data['user_id']=$grower_id;
					if(!empty($this->input->post('address'))){
						$grower_address_data['address']=$this->input->post('address');
					}
					if(!empty($this->input->post('street'))){
						$grower_address_data['street']=$this->input->post('street');
					}
						$this->App_model->AddUpdateData('user_address',$grower_address_data);
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

				$where=array('delivery_boy_id'=>$this->input->post('user_id'));
				$data=$this->App_model->fetchVehicleDetails($where);

				$vehicle_data=array(
					'id'=>$data['id']?$data['id']:0,
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
				if(!empty($this->input->post('color'))){
					$vehicle_data['color']=$this->input->post('color');
				}
				if(!empty($this->input->post('license_no'))){
					$vehicle_data['license_no']=$this->input->post('license_no');
				}
				if(!empty($this->input->post('registration_year'))){
					$vehicle_data['registration_year']=$this->input->post('registration_year');
				}
				$old_front_image=$this->input->post('old_front_image')?$this->input->post('old_front_image'):'';
				if(!empty($_FILES['front_image']['name'])){
 					$input_name = 'front_image';
					$file_response=uploadImage('user-vehicle',$allowed_types,$input_name,$old_front_image);
					if($file_response['status']){
						$vehicle_data['front_image']=$file_response['name'];
						$files[]=$file_response['name'];

					}else{
						$response['status']=false;
						$response['message']=$file_response['message'];
					}
				}else{
					$vehicle_data['front_image']=$old_front_image;
				}
				$old_back_image=$this->input->post('old_back_image')?$this->input->post('old_back_image'):'';
				if(!empty($_FILES['back_image']['name'])){
 					$input_name = 'back_image';
					$file_response=uploadImage('user-vehicle',$allowed_types,$input_name,$old_back_image);
					if($file_response['status']){
						$vehicle_data['back_image']=$file_response['name'];
						$files[]=$file_response['name'];

					}else{
						$response['status']=false;
						$response['message']=$file_response['message'];
					}
				}else{
					$vehicle_data['back_image']=$old_back_image;
				}
				$old_insurance_photo=$this->input->post('old_insurance_photo')?$this->input->post('old_insurance_photo'):'';
				if(!empty($_FILES['insurance_photo']['name'])){
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
 					$vehicle_id=$this->App_model->AddUpdateData('delivery_boy_vehicle_details',$vehicle_data);
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

		public function getVechileDetail_POST(){
			if(isset($_POST)  && !empty($this->input->post('user_id'))){
			 	$where=array('delivery_boy_id'=>$this->input->post('user_id'));
				$response['response']=$this->App_model->fetchVehicleDetails($where);
				$response['status']=TRUE;
				$response['message']="Vechile Details";
				$response['imagePath']="./attachments/user-vehicle/";

			}
				echo json_encode($response);
		}


		public function deliveryBoyAssignOrders_POST(){
			if(isset($_POST)  && !empty($this->input->post('user_id'))){
				$param['where']=array('dboa.delivery_boy_id'=>$this->input->post('user_id'));
				$param['where_in']=array(3,4);
				$orders=$this->App_model->assignedOrders($param);
				//echo"<pre>";print_r($orders);die;
				$response['response']=array();
				foreach($orders as $order){
					$products=$this->Common_model->getOrderProducts($order['order_id']);
					$address=$this->Common_model->getOrderAddress($order['order_id']);
					$response['response'][]=array(
						'order_id'=>$order['order_id'],
						'transaction_id'=>$order['transaction_id'],
						'customer_name'=>$order['customer_name'], 
						'total_product'=>$order['total_product'],
						'total_amount'=>$order['total_amount'], 
						'order_status'=>$order['order_status'],
						'products'=>$products,
						'address'=>$address,
					);
				}
				$response['status']=TRUE;
				$response['message']="Delivery Boy Assigned Orders";
				$response['imagePath']="./attachments/products/";


			}
			else
			{
				$response['message']=MESSAGE;
				$response['status']=FALSE;			
			}
			echo json_encode($response);
		}



		public function changeOrderStatus_POST(){
			if(isset($_POST)  && !empty($this->input->post('user_id')) && !empty($this->input->post('order_id'))){
			//if($this->input->post('status')==4 || $this->input->post('status')==5){
				$data=array('order_status'=>$this->input->post('status'));
				$this->db->where('order_id',$this->input->post('order_id'));
				$this->db->update('orders',$data);
				$response['messgae']="Order status is changed Successfully";
				$response['status']=TRUE;
			//}
			// else
			// {
			// 	$respponse['message']=MESSAGE;
			// 	$response['status']=FALSE;
			// }
						echo json_encode($response);

			}

		}



		public function vendorDashboardData_POST(){		
			if(isset($_POST) && $this->input->post('vendor_id')>0){
			$where=array('od.vendor_id'=>$this->input->post('vendor_id'));
			$response['response']['total_customers']=count($this->Common_model->getTotalCustomers($where));
			$where=array('pm.is_deleted'=>0,'vp.is_deleted'=>0,'vp.vendor_id'=>$this->input->post('vendor_id'),'pt.abbr'=>$this->input->post('language')?$this->input->post('language'):'en' ,'ut.abbr'=>$this->input->post('language')?$this->input->post('language'):'en');
			$response['response']['total_products']=count($this->Common_model->getTotalProducts($where));
			$visitor_where=array(
					'vp.vendor_id'=>$this->input->post('vendor_id'),
					'pm.status'=>1,
					'pm.is_deleted'=>0,
					'pt.abbr'=>'en',
					'ut.abbr'=>'en',
					'vp.is_deleted'=>0
					);

			$response['response']['total_visitors']=$this->Common_model->getTotalVisitors($visitor_where);
			$response['response']['total_order_notifications']=$this->Common_model->getVendorTotalOrderNotifications(array('von.vendor_id'=>$this->input->post('vendor_id'),'von.viewed'=>0));
			
			$duration=$this->input->post('duration')?$this->input->post('duration'):0;
			$where=array('od.vendor_id'=>$this->input->post('vendor_id'));
			$message="Yearly Total Sale";

			if($duration==1){
				$monday = strtotime("last monday"); // this week
				$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;

				$sunday = strtotime(date("Y-m-d",$monday)." +6 days");

				$this_week_start = date("Y-m-d",$monday);
				
                $where['o.order_date >=']=$this_week_start;
               	$message="This week Sale";

			}
			if($duration==2){ // this month
                $where['o.order_date >=']=date('Y-m-01');
        	    	$message="This Month Sale";
			}
			if($duration==3){ // this year
				$where['o.order_date >=']=date('Y-01-01');
       	    	$message="This Year Sale";
			}
			$order_data=$this->Common_model->getVendorTotalSalesOrders($where);
			$new_where=$where;
			$new_where['o.order_status']=5;
			$order_data2=$this->Common_model->getVendorTotalSalesOrders($new_where);
			$response['response']['total_notifications']=$this->Common_model->getVendorTotalNotifications(array('user.id'=>$this->input->post('vendor_id'),'cns.is_deleted'=>0));
			//echo $this->db->last_query();
			$response['response']['total_orders']=$order_data['total_orders'];
			$response['response']['total_shipped_orders']=$order_data2['total_orders'];
			$response['response']['total_sales']=$order_data['total_sales'];
			

			$response['status']=TRUE;
			$response['message']="Profit details";

			//$where=array('od.vendor_id'=>$this->input->post('vendor_id'));
			$response['yearly_response']=$this->App_model->vendorSalesOrdersReport($where);

			$response['status']=TRUE;
			$response['message']=$message;
		}
		echo json_encode($response);
		}	



		public function vendorSalesOrdersReport_POST(){
			if(isset($_POST) && $this->input->post('vendor_id')>0){
			$where=array('od.vendor_id'=>$this->input->post('vendor_id'));
			$duration=$this->input->post('duration')?$this->input->post('duration'):0;
			if($duration==1){
				$monday = strtotime("last monday");
				$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;

				$sunday = strtotime(date("Y-m-d",$monday)." +6 days");

				$this_week_start = date("Y-m-d",$monday);
				//$this_week_end = date("Y-m-d",$sunday);

				//echo "Current week range from $this_week_start to $this_week_end ";

				// $current_date=date('Y-m-d');
    //             $start_date= date('Y-m-d', strtotime(date('Y-m-d'). '- 7 days'));
                $where['o.order_date >=']=$this_week_start;
			}
				if($duration==2){
                $where['o.order_date <=']=date('01-m-Y');
			}
				if($duration==3){
				$where['o.order_date <=']=date('01-01-Y');
				
			}

			$response['response']=$this->App_model->vendorSalesOrdersReport($where);
			$response['status']='TRUE';
			$response['message']="Yearly Total Sale";
		}
		echo json_encode($response);
		}	



		function weatheForecast_POST(){
		if(isset($_POST)&& $this->input->post('vendor_id')>0){
			$response['response']=array();
			$vendor_id=$this->input->post('vendor_id');
			$where=array(
				'u.id'=>$this->input->post('vendor_id')
 			);
			$address=$this->App_model->getData($where);
			$url="https://api.darksky.net/forecast/a578671a1905c97036163c74310e9730/".$address[0]['latitude'].",".$address[0]['longitude'];

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response['response'] = json_decode(curl_exec($ch));
			$response['message']="Weather Forecast";
			$response['status']=TRUE;
		}
		else
		{
			$response['status']=FALSE;
			$response['message']=MESSAGE;
		}
			echo json_encode($response);
		}





		function vendorReviewList_POST(){
		if(isset($_POST)&& $this->input->post('vendor_id')>0){
			$params['where']=array('r.is_deleted'=>0);

			$rating=$this->input->post('rating')?$this->input->post('rating'):'';
			$status=$this->input->post('status')?$this->input->post('status'):'';
		//	$search=$this->input->post('search');
			$vendor_id=$this->input->post('vendor_id');
			$id=$this->input->post('id');
			if($rating>0)
			{
			$params['where']['r.rating']=$rating;
			}
			if($status!="")
			{
			$params['where']['r.status']=$status;
			}

			if($vendor_id>0)
			{
			$params['where']['vp.vendor_id']=$vendor_id;
			}

			if($id>0)
			{
			$params['where']['r.id']=$id;
			}
			$response['response']=array();
			$vendor_id=$this->input->post('vendor_id');
			$response['response'] = $this->App_model->vendorReviewList($params);
			$response['message']="Review List";
			$response['status']=TRUE;
			}
		else
			{
				$response['status']=FALSE;
				$response['message']=MESSAGE;
			}
				echo json_encode($response);
			}


	 function deleteVendorReviews_POST(){
			if($_POST && $this->input->post('id')>0){
				$user_data=array('id'=>$this->input->post('id'),'is_deleted'=>1);
 				$response['status']=$this->Common_model->AddUpdateData('review_rating',$user_data);
				if($response['status']){
					$response['message']="Review Deleted Successfully!";
				}else{
					$response['message']="Something went wrong!";
				}
 				echo json_encode($response);
 			}

 		}


		



	}
 








 