<?php
class Vendor extends VendorController {
	public function index()
	{
 		$crop_sections=array('products');
		foreach($crop_sections as $crop_section){
			$src = "./attachments/".$crop_section."/thumb"; 
			$dst = "./attachments/".$crop_section."/".$this->session->userdata('vendor_data')['id']; 
			customCopy($src, $dst);
		}
		$where=array('od.vendor_id'=>$this->session->userdata('vendor_data')['id']);
		$order_data=$this->Common_model->getVendorTotalSalesOrders($where);
		$new_where=$where;
		$new_where['o.order_status']=5;
		$order_data2=$this->Common_model->getVendorTotalSalesOrders($new_where);

		$data['response']['total_orders']=$order_data['total_orders'];
		$data['response']['total_sales']=$order_data['total_sales'];
		$data['response']['total_shipped_orders']=$order_data2['total_orders'];

		$data['response']['total_notifications']=$this->Common_model->getVendorTotalNotifications(array('user.id'=>$this->session->userdata('vendor_data')['id'],'cns.is_deleted'=>0));
		$data['response']['total_order_notifications']=$this->Common_model->getVendorTotalOrderNotifications(array('von.vendor_id'=>$this->session->userdata('vendor_data')['id'],'von.viewed'=>0));
		 
		$data['response']['total_customers']=count($this->Common_model->getTotalCustomers(array('od.vendor_id'=>$this->session->userdata('vendor_data')['id'],'u.is_deleted'=>0)));
		$where=array('pm.is_deleted'=>0,'vp.is_deleted'=>0,'vp.vendor_id'=>$this->session->userdata('vendor_data')['id'],'pt.abbr'=>'en');
		$data['response']['total_products']=count($this->Common_model->getTotalProducts($where));

		$visitor_where=array(
		'vp.vendor_id'=>$this->session->userdata('vendor_data')['id'],
		'pm.status'=>1,
		'pm.is_deleted'=>0,
		'pt.abbr'=>'en',
		'ut.abbr'=>'en',
		'vp.is_deleted'=>0
		);
		$data['response']['total_visitors']=$this->Common_model->getTotalVisitors($visitor_where);
		$where=array('user_id'=>$this->session->userdata('vendor_data')['id']);
		$address=$this->Vendor_model->vendorAddress($where);
		$url="https://api.darksky.net/forecast/a578671a1905c97036163c74310e9730/".$address['latitude'].",".$address['longitude'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data['weather_forecast_response'] = json_decode(curl_exec($ch));
		//print_r($data['weather_forecast_response']);die;
		$data['weather_forecast']['vendor_address']=$address['address'];
 		$this->load->view('vendor/dashboard',$data);
	 }
	 function updateProfile(){
		$where=array('user_id'=>$this->session->userdata('vendor_data')['id']);
		$data['address']=$this->Vendor_model->vendorAddress($where);
 
		if(!$data['address']){
			$data['address']['id']=0;
 			$data['address']['country']='';
			$data['address']['state']='';
			$data['address']['city']='';
			$data['address']['name']='';
			$data['address']['phone']='';
			$data['address']['email']='';
			$data['address']['address']='';
			$data['address']['street']='';
			$data['address']['block']='';
			$data['address']['landmark']='';
			$data['address']['zip']='';
			$data['address']['country_name']='';
			$data['address']['state_name']='';
			$data['address']['city_name']='';
			$data['address']['latitude']='';
			$data['address']['longitude']='';
  		}
		 
        $this->load->view('vendor/update-profile',$data);
	}
	
	public function vendorUpdateProfile(){
		$this->isAjaxRequest();
		$image_error='';
		$response['status']=true;
		$this->form_validation->set_rules('vendor_first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('vendor_last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('vendor_phone', 'Phone Number', 'required|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('vendor_email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('email', 'Contact Email Address', 'trim|valid_email');
		$this->form_validation->set_rules('vendor_password', 'Password', 'trim|min_length[5]');
 		$this->form_validation -> set_rules('confirm_vendor_password', 'Confirm Password', 'matches[vendor_password]');
		$this->form_validation->set_rules('zip', 'Zip Code', 'trim|min_length[4]|max_length[9]');
		
		$old_image=$this->input->post('old_image');
		if($this->form_validation->run() == TRUE && $response['status']==TRUE){
			if(!empty($_FILES['vendor_image']['name'])){ 
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'vendor_image';
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
				$response=$this->form_validation->error_array();
				$response['status']=false;
				if(!empty($image_error)){
					$response['vendor_image']=$image_error;
				}
				$response['message']='There is error in submitting form!';
			}else{
			
			$update_data=array(
				'id'=>$this->session->userdata('vendor_data')['id'],
				'first_name'=>$this->input->post('vendor_first_name'),
				'last_name'=>$this->input->post('vendor_last_name'),
				//'email'=>$this->input->post('vendor_email'),
				'phone'=>$this->input->post('vendor_phone'),
				//'firm_name'=>$this->input->post('firm_name'),
				//'firm_description'=>$this->input->post('firm_description'),
				'forecast'=>$this->input->post('forecast'),
				'publication'=>$this->input->post('publication'),
				'matching'=>$this->input->post('matching'),
				'image'=>$image?$image:'',
			);
			if(!empty($this->input->post('vendor_password'))){
				$update_data['password']=sha1($this->input->post('vendor_password'));
			}


			$vendor_id=$this->Common_model->updateProfile($update_data);
			if($vendor_id){
				$update_data['email']=$this->session->userdata('vendor_data')['email'];
				$this->session->set_userdata(array('vendor_data'=>$update_data));
				$save_data=array(
					'id'=>$this->input->post('id')? $this->input->post('id'):0,
					'user_id'=>$this->session->userdata('vendor_data')['id'],
					'name'=>$this->input->post('name'),
					'email'=>$this->input->post('email'),
					'phone'=>$this->input->post('phone'),
					'country'=>$this->input->post('change_country'),
					'state'=>$this->input->post('change_state'),
					'city'=>$this->input->post('change_city'),
					'address'=>$this->input->post('address'),
					'street'=>$this->input->post('street'),
					'block'=>$this->input->post('block'),
 					'landmark'=>$this->input->post('landmark'),
					'zip'=>$this->input->post('zip'),
					'latitude'=>$this->input->post('latitude'),
					'longitude'=>$this->input->post('longitude'),
					);
				$address_id=$this->Common_model->AddUpdateData('user_address',$save_data);
 
				$slug=makeSlug($update_data['first_name'].'-'.$update_data['last_name'].$vendor_id);
				$update_data=array('id'=>$vendor_id,'slug'=>$slug);
				$this->Common_model->AddUpdateData('users',$update_data);

				$this->session->set_flashdata('success_message',"Your profile has been updated successfully!");
			}
		}
		echo json_encode($response);
	}

 	public function vendorRemoveProfilePhoto(){
		if($this->input->is_ajax_request()){
			$update_data=array(
				'image'=>'',
				'id'=>$this->session->userdata('vendor_data')['id']
			);
 			$response['status']=$this->Common_model->updateProfile($update_data);
			unlinkImage('users',$this->session->userdata('vendor_data')['image']);
			$this->session->unset_userdata($this->session->userdata('image'));
			$this->session->set_flashdata('success_message',"Your profile Image has been removed successfully!");
			echo json_encode($response);
		}else{
			redirect('vendor', 'refresh');
		}
	}
	
	public function manageCustomers(){
		$data=array();
		if(isset($_POST['export'])){
			$this->exportCustomers();
		}
		$this->load->view('vendor/customers/manage-customers',$data);
	}


	public function exportCustomers()
	{
		$Customer=$this->Vendor_model->manageCustomersExport($_POST,false);
		$filename = 'Customers_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
        $file = fopen('php://output', 'w');

        $header = array(
        	"Customer Name",
        	"Customer Phone",
        	"Customer Email",
        	"Customer Status",
                ); 
        fputcsv($file, $header);
        foreach ($Customer as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
	
	}	 

	public function manageCustomersAjax(){
		$this->isAjaxRequest();
		$data=$this->Vendor_model->manageCustomersAjax($_POST,false);
		$response['total']=$this->Vendor_model->manageCustomersAjax($_POST,true);
		$response['data']=array();
		if(count($data)>0){
			foreach($data as $row){
				if(is_file('./attachments/users/thumb/'.$row['image']) && !empty($row['image'])){
					$image=base_url('attachments/users/thumb/'.$row['image']);	
				}else{
					$image='';
				}
				$response['data'][]=array(
					'id'=>$row['id'],
					'name'=>$row['name'],
 					'email'=>$row['email'],
 					'phone'=>$row['phone'],
					'image'=>$image,
					'status'=>$row['status'],
				);
			}
		}
		$this->getJson($response);
	}


	 
	public function viewCustomer(){
		$id=$this->uri->segment(2);
		if($id>0){
			$select=array('u.id'=>$id);
			$data['user']=$this->Vendor_model->customerData($select);
			$this->load->view('vendor/customers/view-customer',$data);
     	}
	}

 
	public function addressList()
	{
		$id=$this->uri->segment(2);
		if($id>0){
			$data['customer_id']=$id;
		}else{
			$data['customer_id']=0;
		}
		$where=array('status'=>1);
 		$this->load->view('vendor/customers/manage-customer-addresses',$data);
	}

	public function customerAddressListAjax(){
		$this->isAjaxRequest(); 
		$response['data']=$this->Vendor_model->customerAddressListAjax($_POST,false);
		$response['total']=$this->Vendor_model->customerAddressListAjax($_POST,true);
		$this->getJson($response);
	}



	function weatherForecast(){
 		$where=array('user_id'=>$this->session->userdata('vendor_data')['id']);
		$address=$this->Vendor_model->vendorAddress($where);
 		$post_data=array('access_key'=>'572df6f7a732844bb4017960675abba4','query'=>$address['city_name'],'forecast_days'=>7,'hourly'=>1);
		$ch = curl_init("http://api.weatherstack.com/current?access_key=572df6f7a732844bb4017960675abba4&query=".$address['city_name']."&forecast_days=15&hourly=1");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data['response'] = json_decode(curl_exec($ch));
		$this->load->view('vendor/weather-forcasting',$data);
	}

	function weatherForecast123(){
		$where=array('user_id'=>$this->session->userdata('vendor_data')['id']);
		$address=$this->Vendor_model->vendorAddress($where);
		$url="https://api.darksky.net/forecast/a578671a1905c97036163c74310e9730/".$address['latitude'].",".$address['longitude'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data['response'] = json_decode(curl_exec($ch));
		echo '<pre>';
		print_r($data);die;
 		$this->load->view('vendor/weather-forcasting',$data);
   }
	
	public function notifications()
	{
 	 	$this->load->view('vendor/notifications/manage-notifications');
	}
		
	public function manageNotificationsAjax(){
		$this->isAjaxRequest();
		$response['data']=$this->Vendor_model->manageNotificationsAjax($_POST,false);
		$response['total']=$this->Vendor_model->manageNotificationsAjax($_POST,true);
		$this->getJson($response);
	}

}
