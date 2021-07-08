<?php
class Deliveryboy extends DeliveryboyController {
	public function index()
	{
		$this->load->view('website/delivery-boy/delivery-boy-dashboard');
	}

	public function fetchProfile(){
		$where=array('vd.delivery_boy_id'=>$this->session->userdata('delivery_boy_data')['id']);
		$data['vehicle_data']=$this->Deliveryboy_model->fetchVehicleDetails($where);
		if(!$data['vehicle_data']){
			$data['vehicle_data']['id']=0;
			$data['vehicle_data']['vehicle_no']='';
			$data['vehicle_data']['type']='';
			$data['vehicle_data']['model']='';
			$data['vehicle_data']['color']='';
			$data['vehicle_data']['registration_year']='';
			$data['vehicle_data']['front_image']='';
			$data['vehicle_data']['back_image']='';
			$data['vehicle_data']['license_no']='';
			$data['vehicle_data']['insurance_photo']='';
 		}
		$this->load->view('website/delivery-boy/delivery-boy-update-profile',$data);
	}

	public function updateProfile(){
		$this->isAjaxRequest();
		$image_error='';
		$vehicle_front_photo_error='';
		$vehicle_back_photo_error='';
		$insurance_photo_error='';
		$phone_error='';
		$response['status']=TRUE;
		$uploaded_images=array();
		$this->form_validation->set_rules('delivery_boy_first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('delivery_boy_last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('delivery_boy_phone', 'Phone Number', 'required|regex_match[/^[0-9]{10}$/]|min_length[10]|max_length[12]');
		$old_image=$this->input->post('old_image') ? $this->input->post('old_image'):'';
		$old_vehicle_front_photo=$this->input->post('old_vehicle_front_photo') ? $this->input->post('old_vehicle_front_photo'):'';
		$old_vehicle_back_photo=$this->input->post('old_vehicle_back_photo') ? $this->input->post('old_vehicle_back_photo'):'';
		$old_insurance_photo=$this->input->post('old_insurance_photo') ? $this->input->post('old_insurance_photo'):'';
		
		$phone=$this->input->post('delivery_boy_phone');
		if(!empty($phone)){
			$where=array('phone'=>$phone,'id <>'=>$this->session->userdata('delivery_boy_data')['id']);
			if(!$this->Common_model->checkExist('users',$where)){
				$response['status']=FALSE;
				$phone_error="Phone No already exists!";
			}
		}
		if($this->form_validation->run() == TRUE && $response['status']==TRUE){
			if(!empty($_FILES['delivery_boy_image']['name'])){ 
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'delivery_boy_image';
				$file_response=uploadImage('users',$allowed_types,$input_name,$old_image);
				if($file_response['status']){
					$image=$file_response['name'];
					$uploaded_images[]=$image;
				}else{
					$response['status']=false;
					$image_error=$file_response['message'];
				}
			}else{
				$image=$old_image;
			}

			if(!empty($_FILES['vehicle_front_photo']['name'])){ 
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'vehicle_front_photo';
				$file_response=uploadImage('users',$allowed_types,$input_name,$old_vehicle_front_photo);
				if($file_response['status']){
					$vehicle_front_photo=$file_response['name'];
					$uploaded_images[]=$vehicle_front_photo;
				}else{
					$response['status']=false;
					$vehicle_front_photo_error=$file_response['message'];
				}
			}else{
				$vehicle_front_photo=$old_vehicle_front_photo;
			}
			if(!empty($_FILES['vehicle_back_photo']['name'])){ 
 				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'vehicle_back_photo';
				$file_response=uploadImage('users',$allowed_types,$input_name,$old_vehicle_back_photo);
				if($file_response['status']){
					$vehicle_back_photo=$file_response['name'];
					$uploaded_images[]=$vehicle_back_photo;
				}else{
					$response['status']=false;
					$vehicle_back_photo_error=$file_response['message'];
				}
			}else{
				$vehicle_back_photo=$old_vehicle_back_photo;
			}

			if(!empty($_FILES['insurance_photo']['name'])){ 
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'insurance_photo';
				$file_response=uploadImage('users',$allowed_types,$input_name,$old_insurance_photo);
				if($file_response['status']){
					$insurance_photo=$file_response['name'];
					$uploaded_images[]=$insurance_photo;
				}else{
					$response['status']=false;
					$insurance_photo_error=$file_response['message'];
				}
			}else{
				$insurance_photo=$old_insurance_photo;
			}
		}
		if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
			$response['response']=$this->form_validation->error_array();
			$response['status']=false;
			if(!empty($image_error)){
				$response['response']['delivery_boy_image']=$image_error;
			}
			if(!empty($vehicle_front_photo_error)){
				$response['response']['vehicle_front_photo']=$vehicle_front_photo_error;
			}
			if(!empty($vehicle_back_photo_error)){
				$response['response']['vehicle_back_photo']=$vehicle_back_photo_error;
			}
			if(!empty($insurance_photo_error)){
				$response['response']['insurance_photo']=$insurance_photo_error;
			}
			if(!empty($phone_error)){
				$response['response']['delivery_boy_phone']=$phone_error;
			}
			$response['message']='There is error in submitting form!';
			if(count($uploaded_images)>0){
				foreach($uploaded_images as $uploaded_image){
					unlinkImage('users',$uploaded_image);
				}
			}
		}else{
			$update_data=array(
			'id'=>$this->session->userdata('delivery_boy_data')['id'],
			'first_name'=>$this->input->post('delivery_boy_first_name'),
			'last_name'=>$this->input->post('delivery_boy_last_name'),
			'phone'=>$this->input->post('delivery_boy_phone'),
			'publication'=>$this->input->post('publication'),
			'image'=>$image?$image:'',
			);
			$user_id=$this->Common_model->updateProfile($update_data);
			if($user_id){
				$update_data['email']=$this->session->userdata('delivery_boy_data')['email'];
				$this->session->set_userdata(array('delivery_boy_data'=>$update_data));
				$update_data=array(
					'id'=>$this->input->post('id')?$this->input->post('id'):0,
					'delivery_boy_id'=>$this->session->userdata('delivery_boy_data')['id'],
					'vehicle_no'=>$this->input->post('vehicle_number'),
					'type'=>$this->input->post('vehicle_type'),
					'model'=>$this->input->post('vehicle_model'),
					'color'=>$this->input->post('vehicle_color'),
					'registration_year'=>$this->input->post('vehicle_registration_year'),
					'front_image'=>$vehicle_front_photo ? $vehicle_front_photo:'',
					'back_image'=>$vehicle_back_photo ? $vehicle_back_photo:'',
					'insurance_photo'=>$insurance_photo ? $insurance_photo:'',
					'license_no'=>$this->input->post('license_number'),
				);
				$this->Common_model->AddUpdateData('delivery_boy_vehicle_details',$update_data);
				$response['message']='Your profile has been updated successfully!';
				$this->session->set_flashdata('success_message',$response['message']);
			}
		}
		echo json_encode($response);
	}

	public function assignedOrders(){
		$param['where']=array('dboa.delivery_boy_id'=>$this->session->userdata('delivery_boy_data')['id']);
		$param['where_in']=array(3,4);
		$orders=$this->Deliveryboy_model->assignedOrders($param);
		$data=array();
		foreach($orders as $order){
			$products=$this->Common_model->getOrderProducts($order['order_id']);
			$address=$this->Common_model->getOrderAddress($order['order_id']);
			$data['orders'][]=array(
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
 		$this->load->view('website/delivery-boy/delivery-boy-assigned-orders',$data);
	}
 }
