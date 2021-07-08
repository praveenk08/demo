<?php
	require APPPATH . '/libraries/REST_Controller.php';
	class ServiceProviderApp extends REST_Controller{
		public function __construct(){
 			parent::__construct();
 			$this->load->model('api/App_model');
 
		}
  // Customer Update Profile
	public function serviceProviderUpdateProfile_POST(){
		if($_POST && $this->input->post('id')>0){
		$response['status']=TRUE;
			$data=array(
			'id'=>$this->input->post('id'),
			'role_id'=>5
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

	function deleteService_POST(){
		if($_POST && $this->input->post('id')>0){
			$response['status']=TRUE;
			$service_data=array('id'=>$this->input->post('id'));
			$service_data['is_deleted']=1;
			$response['status']=$this->App_model->AddUpdateData('service_provider_services',$service_data);
			if($response['status']){
				$response['message']="Service Deleted Successfully!";
			}else{
				$response['message']="Something went wrong!";
			}
 			echo json_encode($response);
		}
	}
	public function addUpdateService_POST(){
		if($_POST && $this->input->post('provider_id')>0){
			$image_error='';
			$response['status']=TRUE;
			$old_image=$this->input->post('old_image');
 			$id=$this->input->post('id') ? $this->input->post('id'):0;
			if(!empty($_FILES['service_image']['name'])){ 
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'service_image';
				$file_response=uploadImage('services',$allowed_types,$input_name,$old_image);
				if($file_response['status']){
					$image=$file_response['name'];
				}else{
					$response['status']=false;
					$image_error=$file_response['message'];
				}
			}else{
				$image=$old_image;
			}
			if($response['status']){
				$save_data=array(
					'id'=>$id,
					'service_provider_id'=>$this->input->post('provider_id'),
					'service_category_id'=>$this->input->post('service_category'),
					'name'=>$this->input->post('service_name'),
					'price'=>$this->input->post('service_price'),
					'description'=>$this->input->post('service_description'),
					'status'=>$this->input->post('service_status'),
					'image'=>$image?$image:'',
					);
					$this->App_model->AddUpdateData('service_provider_services',$save_data);
					if($save_data['id']>0){
						$action=" updated ";
					}else{
						$action=" added ";
					}
					$response['message']="Service ".$action." Successfully";
 			}
		}
 		echo json_encode($response);
	}

	public function providerServiceList_POST(){
		if($_POST && $this->input->post('provider_id')>0){
 			$response['status']=TRUE;
			$where=array('sps.is_deleted'=>0,'sps.service_provider_id'=>$this->input->post('provider_id'),'sc.status'=>1,'sc.is_deleted'=>0);
			if($this->input->post('id')>0){
				$where['sps.id']=$this->input->post('id');
			}
			$response['response'] = $this->App_model->providerServiceList($where);
			$response['message']="Service List";
			echo json_encode($response);
		}
   }
 
  }
 