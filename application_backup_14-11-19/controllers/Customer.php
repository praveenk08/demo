<?php
class Customer extends CustomerController {
	public function index()
	{
 		$this->load->view('website/customer/customer-dashboard');
	}

	public function fetchProfile(){
		$this->load->view('website/customer/customer-update-profile');
	}

	public function updateProfile(){
		$this->isAjaxRequest();
		$image_error='';
		$phone_error='';
		$response['status']=TRUE;
		$this->form_validation->set_rules('customer_first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('customer_last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('customer_phone', 'Phone Number', 'required|regex_match[/^[0-9]{10}$/]|min_length[10]|max_length[12]');
		$this->form_validation->set_rules('customer_password', 'Password', 'max_length[15]|min_length[5]|alpha_numeric');
		$this->form_validation->set_rules('customer_confirm_password', 'Confirm Password', 'matches[customer_password]');

		$old_image=$this->input->post('old_image');
		$phone=$this->input->post('customer_phone');
		if(!empty($phone)){
			$where=array('phone'=>$phone,'id <>'=>$this->session->userdata('customer_data')['id']);
			if(!$this->Common_model->checkExist('users',$where)){
				$response['status']=FALSE;
				$phone_error="Phone No already exists!";
			}
		}
		if($this->form_validation->run() == TRUE && $response['status']==TRUE){
			if(!empty($_FILES['customer_image']['name'])){ 
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'customer_image';
				$file_response=uploadImage('users',$allowed_types,$input_name,$old_image);
				if($file_response['status']){
					$image=$file_response['name'];
				}else{
					$response['status']=false;
					$image_error=$file_response['message'];
				}
			}else{
				$image=$old_image;
			}
		}
		if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
			$response['response']=$this->form_validation->error_array();
			$response['status']=false;
			if(!empty($image_error)){
				$response['response']['customer_image']=$image_error;
			}
			if(!empty($phone_error)){
				$response['response']['customer_phone']=$phone_error;
			}
			$response['message']='There is error in submitting form!';
		}else{
			$update_data=array(
			'id'=>$this->session->userdata('customer_data')['id'],
			'first_name'=>$this->input->post('customer_first_name'),
			'last_name'=>$this->input->post('customer_last_name'),
			'phone'=>$this->input->post('customer_phone'),
			'publication'=>$this->input->post('publication'),
			'matching'=>$this->input->post('matching'),
			'image'=>$image?$image:'',
			);
			if(!empty($this->input->post('customer_password'))){
				$update_data['password']=sha1($this->input->post('customer_password'));
			}
			$user_id=$this->Common_model->updateProfile($update_data);
			if($user_id){
				$update_data['email']=$this->session->userdata('customer_data')['email'];
				$this->session->set_userdata(array('customer_data'=>$update_data));
				$response['message']='Your profile has been updated successfully!';
				$this->session->set_flashdata('success_message',$response['message']);
			}
		}
		echo json_encode($response);
	}

	public function manageAddresses(){
		$select['where']=array('ua.is_deleted'=>0,'ua.user_id'=>$this->session->userdata('customer_data')['id']);
		$select['like']=array();
		$totalRec = count($this->Customer_model->addressData($select));
		$config=ajaxPaginationConfigration(array('base_url'=>base_url().'Customer/manageAddressesAjax','totalRec'=>$totalRec,'per_page'=>getSettings()['total_record_per_page']));
		$this->ajax_pagination->initialize($config);
		$param=array('limit'=>getSettings()['total_record_per_page']);
		$param['where']=$select['where'];
		$param['like']=array();
 		$data['addresses']=$this->Customer_model->addressData($param);
 		$data['service_category']=array();;
 		$this->load->view('website/customer/customer-manage-addresses',$data);
	}


	public function manageAddressesAjax(){
		$conditions = array();
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
		}
		$select['where']=array('ua.is_deleted'=>0,'ua.user_id'=>$this->session->userdata('customer_data')['id']);
		$change_country = $this->input->post('change_country');
        $change_state = $this->input->post('change_state');
		$change_city = $this->input->post('change_city');
		$change_status = $this->input->post('change_status');
		$change_search = trim($this->input->post('change_search'));
		
		$select['like']=array();
		if($change_country>0){
			$select['where']['ua.country']=$change_country;
		}
		if($change_state>0){
			$select['where']['ua.state']=$change_state;
		}
		if($change_city>0){
			$select['where']['ua.city']=$change_city;
		}
		if($change_status!=''){
			$select['where']['ua.status']=$change_status;
		}
  		if(strlen($change_search)>0){
			$select['like']['ua.name']=$change_search;
			$select['like']['ua.phone']=$change_search;
			$select['like']['ua.email']=$change_search;
			$select['like']['ua.address']=$change_search;
			$select['like']['ua.street']=$change_search;
			$select['like']['ua.block']=$change_search;
			$select['like']['ua.landmark']=$change_search;
			$select['like']['ua.zip']=$change_search;
		}
		  
		$totalRec = count($this->Customer_model->addressData($select));
		$config=ajaxPaginationConfigration(array('base_url'=>base_url().'Customer/manageAddressesAjax','totalRec'=>$totalRec,'per_page'=>getSettings()['total_record_per_page']));
		$this->ajax_pagination->initialize($config);
  		$param=array('limit'=>getSettings()['total_record_per_page'],'start'=>$offset);
		$param['where']=$select['where'];
		$param['like']=$select['like'];
		$data['addresses']=$this->Customer_model->addressData($param);
 		$this->load->view('website/customer/customer-manage-address-ajax',$data,false);
	}

	function customerWishlist(){
		$where=array(
			'pt.abbr'=>$this->session->userdata('language'),
			'wish.user_id'=>$this->session->userdata('user_session_id')
		);
		$data['wishlists']=$this->Cart_model->wishList($where);
		$this->load->view('website/customer/customer-manage-wishlist',$data);
	}

	public function customerOrders(){
		$conditions['where']=array('o.customer_id'=>$this->session->userdata('customer_data')['id']);
		$totalRec = count($this->Customer_model->customerOrders($conditions));
		$config=ajaxPaginationConfigration(array('base_url'=>base_url().'website/Customer/customerOrderstAjax','totalRec'=>$totalRec,'per_page'=>getSettings()['total_record_per_page']));
		$this->ajax_pagination->initialize($config);
		$conditions['limit']=getSettings()['total_record_per_page'];
 		$data['orders']=$this->Customer_model->customerOrders($conditions);
 		$this->load->view('website/customer/customer-manage-orders',$data);
	}

	public function customerOrderstAjax(){
		$conditions = array();
		$conditions['where']=array('o.customer_id'=>$this->session->userdata('customer_data')['id']);
		$page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
		}
		
		$totalRec = count($this->Customer_model->customerOrders($conditions));
        $config=ajaxPaginationConfigration(array('base_url'=>base_url().'website/Customer/customerOrderstAjax','totalRec'=>$totalRec,'per_page'=>getSettings()['total_record_per_page']));
		$this->ajax_pagination->initialize($config);
        $conditions['start'] = $offset;
        $conditions['limit'] = getSettings()['total_record_per_page'];
		$data['orders'] = $this->Customer_model->customerOrders($conditions);
 		$this->load->view('website/customer/customer-manage-orders-ajax',$data,false);
	}

	
	public function addAddress(){
		$data=array();
	    $id=$this->uri->segment(2); 
	    $ch=$this->input->get('ch')?$this->input->get('ch'):'';
		if($id>0){
			$select['where']=array('ua.id'=>$id,'ua.is_deleted'=>0,'ua.user_id'=>$this->session->userdata('customer_data')['id']);
			$select['like']=array();
			$address=$this->Customer_model->addressData($select);
 			if(count($address)>0){
				$data['address']=$address[0];
  			}else{
				redirect('customer-dashboard');
			}
   			$data['btn']="Update Address";
    	}else{
			$data['address']['name']='';
			$data['address']['phone']='';
			$data['address']['email']='';
			$data['address']['country']=0;
			$data['address']['state']=0;
			$data['address']['city']=0;
			$data['address']['address_type']='Home';
			$data['address']['address']='';
			$data['address']['street']='';
			$data['address']['landmark']='';
			$data['address']['block']='';
			$data['address']['status']=1;
			$data['address']['id']='';
			$data['address']['zip']='';
 			$data['btn']="Add Address";
		 }
		$data['address']['ch']=$ch;
 		$this->load->view('website/customer/customer-add-update-address',$data);
	}

	

	public function saveAddress(){
		//$this->isAjaxRequest();
 		$response['status']=TRUE;
		 $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');
		$this->form_validation->set_rules('change_country', 'Phone Number', 'trim|required');
		$this->form_validation->set_rules('change_state', 'State Name', 'trim|required');
		$this->form_validation->set_rules('change_city', 'City Name', 'trim|required');
		$this->form_validation->set_rules('landmark', 'lankmark', 'trim|required');
 		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('zip', 'Zip', 'trim|required');
		$id=$this->input->post('id') ? $this->input->post('id'):0;
		  
		if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
			$response['response']=$this->form_validation->error_array();
			$response['status']=false;
			$response['message']='There is error in submitting form!';
		}else{
			$save_data=array(
				'id'=>$id,
				'user_id'=>$this->session->userdata('customer_data')['id'],
				'name'=>$this->input->post('name'),
				'email'=>$this->input->post('email'),
				'phone'=>$this->input->post('phone'),
				'country'=>$this->input->post('change_country'),
				'state'=>$this->input->post('change_state'),
				'city'=>$this->input->post('change_city'),
				'address'=>$this->input->post('address'),
				'address_type'=>$this->input->post('address_type'),
				'street'=>$this->input->post('street'),
				'block'=>$this->input->post('block'),
				'status'=>$this->input->post('status'),
				'landmark'=>$this->input->post('landmark'),
				'zip'=>$this->input->post('zip'),
			);
			$this->Common_model->AddUpdateData('user_address',$save_data);
			if($save_data['id']>0){
				$action=" updated ";
			}else{
				$action=" added ";
			}
			$response['message']="Your address has been".$action." Successfully";
			$response['url']=base_url('customer-manage-addresses');
			$response['ch']=$this->input->post('ch');
			$response['ch_url']=base_url('CheckOut');
			$this->session->set_flashdata('success_message',$response['message']);
		}
 		echo json_encode($response);
	}

	function deleteAddress(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$user_data=array('id'=>$id);
			$user_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('user_address',$user_data);
			if($response['status']){
				$response['message']="Address Deleted Successfully!";
			}else{
				$response['message']="Something went wrong!";
			}
			$this->session->set_flashdata('success_message',$response['message']);
			echo json_encode($response);
		}
	}
	
	public function removeProfilePhoto(){
		$this->isAjaxRequest();
		$update_data=array(
			'image'=>'',
			'id'=>$this->session->userdata('customer_data')['id']
		);
		$response['status']=$this->Common_model->updateProfile($update_data);
 		unlinkImage('users',$this->session->userdata('customer_data')['image']);
		$this->session->unset_userdata($this->session->userdata('customer_data')['image']);
		$response['message']="Your profile Image has been removed successfully!";
		$this->session->set_flashdata('success_message',$response['message']);
		echo json_encode($response);
	}

	
}
