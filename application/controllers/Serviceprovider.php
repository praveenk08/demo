<?php
class Serviceprovider extends ServiceproviderController {
	public function index()
	{
 		$this->load->view('website/service-provider/service-provider-dashboard');
	}

	public function fetchProfile(){
		$this->load->view('website/service-provider/service-provider-update-profile');
	}
	public function services(){
 		$select['where']=array('sps.is_deleted'=>0);
		$totalRec = count($this->Serviceprovider_model->providerServicesData($select));
		$config=ajaxPaginationConfigration(array('base_url'=>base_url().'Serviceprovider/serviceListAjax','totalRec'=>$totalRec,'per_page'=>getSettings()['total_record_per_page']));
		$this->ajax_pagination->initialize($config);
		$param=array('limit'=>getSettings()['total_record_per_page']);
		$param['where']=array('sps.is_deleted'=>0);
 		$data['services']=$this->Serviceprovider_model->providerServicesData($param);
		$where=array('sc.status'=>1,'sc.is_deleted'=>0,'sct.abbr'=>$this->session->userdata('language'));
		$data['service_category']=$this->Common_model->getServicesCategories($where);
 		$this->load->view('website/service-provider/service-provider-services',$data);
	}

	public function serviceListAjax(){
		$this->isAjaxRequest();
		$conditions = array();
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
		}
		$change_category = $this->input->post('change_category');
        $change_status = $this->input->post('change_status');
		$change_search = $this->input->post('change_search');
		$select['search']=array('change_category'=>$change_category,'change_status'=>$change_status,'change_search'=>$change_search);
		$select['where']=array('sps.is_deleted'=>0);
		$totalRec = count($this->Serviceprovider_model->providerServicesData($select));
		$config=ajaxPaginationConfigration(array('base_url'=>base_url().'Serviceprovider/serviceListAjax','totalRec'=>$totalRec,'per_page'=>getSettings()['total_record_per_page']));
		$this->ajax_pagination->initialize($config);
		$param=array('limit'=>getSettings()['total_record_per_page'],'start'=>$offset);
		$param['where']=array('sps.is_deleted'=>0);
		$param['search']=$select['search'];
		$data['services']=$this->Serviceprovider_model->providerServicesData($param);
		$this->load->view('website/service-provider/service-provider-services-ajax',$data,false);

	
	}
	public function addServices(){
		$data=array();
	  	$id=$this->uri->segment(2);
		if($id>0){
			$select['where']=array('sps.id'=>$id,'sps.is_deleted'=>0);
			$service=$this->Serviceprovider_model->providerServicesData($select);
			if(count($service)>0){
				$data['service']=$service[0];
				$service_name_data=$this->Serviceprovider_model->getServiceNameData(array('sps.id'=>$id));
				if(count($service_name_data)>0){
					foreach($service_name_data as $service_name_row){
						$data['names'][$service_name_row['abbr']]=$service_name_row;
					}	
				}
  			}else{
				redirect('service-provider-dashboard');
			}
   			$data['btn']="Update Service";
    	}else{
			$data['service']['id']='';
			$data['service']['service_category_id']=''; 
			$data['service']['name']='';
			$data['service']['price']='';
			$data['service']['description']='';
			$data['service']['image']='';
			$data['service']['status']=1;
			$data['btn']="Add Service";
		 }
		$where=array('sc.status'=>1);
		$data['services']=$this->Common_model->getServicesCategories($where);
		$this->load->view('website/service-provider/service-provider-add-update-service',$data);
	}
	

	public function updateProfile(){
		$this->isAjaxRequest();
		$image_error='';
		$phone_error='';
		$response['status']=TRUE;
		$this->form_validation->set_rules('service_provider_first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('service_provider_last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('service_provider_phone', 'Phone Number', 'required|regex_match[/^[0-9]{10}$/]|min_length[10]|max_length[12]');
		$this->form_validation->set_rules('service_provider_password', 'Password', 'max_length[15]|min_length[5]|alpha_numeric');
		$this->form_validation->set_rules('service_provider_confirm_password', 'Confirm Password', 'matches[service_provider_password]');

		 
		$old_image=$this->input->post('old_image');
		$phone=$this->input->post('service_provider_phone');
		if(!empty($phone)){
			$where=array('phone'=>$phone,'id <>'=>$this->session->userdata('service_provider_data')['id']);
			if(!$this->Common_model->checkExist('users',$where)){
				$response['status']=FALSE;
				$phone_error="Phone No already exists!";
			}
		}
		if($this->form_validation->run() == TRUE && $response['status']==TRUE){
			if(!empty($_FILES['service_provider_image']['name'])){ 
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'service_provider_image';
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
				$response['response']['service_provider_image']=$image_error;
			}
			if(!empty($phone_error)){
				$response['response']['service_provider_phone']=$phone_error;
			}
			$response['message']='There is error in submitting form!';
		}else{
			$update_data=array(
			'id'=>$this->session->userdata('service_provider_data')['id'],
			'first_name'=>$this->input->post('service_provider_first_name'),
			'last_name'=>$this->input->post('service_provider_last_name'),
			'phone'=>$this->input->post('service_provider_phone'),
			'publication'=>$this->input->post('publication'),
			'image'=>$image?$image:'',
			);
			if(!empty($this->input->post('service_provider_password'))){
				$update_data['password']=sha1($this->input->post('service_provider_password'));
			}
			$user_id=$this->Common_model->updateProfile($update_data);
			if($user_id){
				$update_data['email']=$this->session->userdata('service_provider_data')['email'];
				$this->session->set_userdata(array('service_provider_data'=>$update_data));
				$response['message']='Your profile has been updated successfully!';
				$this->session->set_flashdata('success_message',$response['message']);
			}
		}
		echo json_encode($response);
	}

	public function saveService(){
		$this->isAjaxRequest();
		$image_error='';
 		$response['status']=TRUE;
		$this->form_validation->set_rules('service_category', 'Service Category', 'trim|required');

		//$this->form_validation->set_rules('service_name', 'Service Name', 'trim|required');
		$languages=getLanguageList(); 
		if(count($languages)){
			foreach($languages as $language){
				$this->form_validation->set_rules('service_name'.$language['abbr'], 'Service Name ('.ucfirst($language['name']).')', 'trim|required');
			}
		}
		$this->form_validation->set_rules('service_price', 'Service Price','trim|required');
		$old_image=$this->input->post('old_image');
 		$id=$this->input->post('id') ? $this->input->post('id'):0;
 
		if($this->form_validation->run() == TRUE && $response['status']==TRUE){
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
		}
		if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
			$response['response']=$this->form_validation->error_array();
			$response['status']=false;
			if(!empty($image_error)){
				$response['response']['service_image']=$image_error;
			}
			$response['message']='There is error in submitting form!';
		}else{
			$save_data=array(
			'id'=>$id,
			'service_provider_id'=>$this->session->userdata('service_provider_data')['id'],
			'service_category_id'=>$this->input->post('service_category'),
			//'name'=>$this->input->post('service_name'),
			'price'=>$this->input->post('service_price'),
			//'description'=>$this->input->post('service_description'),
			'status'=>$this->input->post('service_status'),
			'image'=>$image?$image:'',
			);
			$service_id=$this->Common_model->AddUpdateData('service_provider_services',$save_data);

			$languages=getLanguageList();
			if(count($languages)){
				$this->Common_model->deleteRecord(array('service_id'=>$service_id),'service_provider_service_translator');
				foreach($languages as $language){
					$save_data=array(
					'id'=>0,
					'service_id'=>$service_id,
					'name'=>$this->input->post('service_name'.$language['abbr']),
					'description'=>$this->input->post('service_description'.$language['abbr']),
					'abbr'=>$language['abbr'],
 					);
					$id=$this->Common_model->AddUpdateData('service_provider_service_translator',$save_data);
					$slug=makeSlug($save_data['name'].'-'.$id);
					$update_data=array('id'=>$id,'slug'=>$slug);
					$this->Common_model->AddUpdateData('service_provider_service_translator',$update_data);
					}
				}
				$slug=makeSlug($this->input->post('service_nameen').'-'.$service_id);
				$update_data=array('id'=>$service_id,'slug'=>$slug);
				$this->Common_model->AddUpdateData('service_provider_services',$update_data);
			if($save_data['id']>0){
				$action=" updated ";
			}else{
				$action=" added ";
			}
			$response['message']="Service ".$action." Successfully";
			$response['url']=base_url('service-provider-services');
			$this->session->set_flashdata('success_message',$response['message']);
		}
 		echo json_encode($response);
	}

	public function manageAddresses(){
		$this->load->view('website/customer/customer-manage-addresses');
	}

	 
	public function removeProfilePhoto(){
		$this->isAjaxRequest();
		$update_data=array(
			'image'=>'',
			'id'=>$this->session->userdata('service_provider_data')['id']
		);
		$response['status']=$this->Common_model->updateProfile($update_data);
 		unlinkImage('users',$this->session->userdata('service_provider_data')['image']);
		$this->session->unset_userdata($this->session->userdata('service_provider_data')['image']);
		$response['message']="Your profile Image has been removed successfully!";
		$this->session->set_flashdata('success_message',$response['message']);
		echo json_encode($response);
	}

	
	function deleteService(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$user_data=array('id'=>$id);
			$user_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('service_provider_services',$user_data);
			if($response['status']){
				$response['message']="Service Deleted Successfully!";
			}else{
				$response['message']="Something went wrong!";
			}
			$this->session->set_flashdata('success_message',$response['message']);
			echo json_encode($response);
		}
	}

	
	
}
