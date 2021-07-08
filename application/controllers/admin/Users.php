<?php
class Users extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
 		$this->load->model('admin/Users_model');
	}
	
	public function index()
	{
		if(isset($_POST['export'])){
			$this->exportusers();
		}	
 	 	$this->load->view('admin/users/manage-users');
	}

	public function exportusers(){ 
        //print_r($_POST); die;
        // file name 
     	$users = $this->Users_model->manageusersExport($_POST,false);
     	 //echo"<pre>"; print_r($users); die;
	    $filename = 'users_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
       
        // get data 
        
        // file creation 
        $file = fopen('php://output', 'w');

        $header = array(
            "Role",
            "Name",
            "Phone",
            "Email",
            "Status",
              ); 
        fputcsv($file, $header);
        foreach ($users as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
       }


	public function manageUsers(){
		$this->isAjaxRequest();
		$data=$this->Users_model->manageUsersAjax($_POST,false);
		$response['total']=$this->Users_model->manageUsersAjax($_POST,true);
		//echo $this->db->last_query();die;

		//echo "<pre/>";print_r($a); die;
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
					'role_id'=>$row['role_id'],
					'role_name'=>$row['role_name'],
					'email'=>$row['email'],
					'total_address'=>$row['total_address'],
					'phone'=>$row['phone'],
					'image'=>$image,
					'status'=>$row['status'],
				);
			}
		}
		$this->getJson($response);
	}

	public function addUpdateUser(){
		deleteTempFiles('./attachments/users/'.$this->session->userdata('admin_data')['id'].'/*');
		$data=array();
	  	$id=$this->uri->segment(2);
		if($id>0){
			$select=array('u.id'=>$id);
			$data['user']=$this->Users_model->userData($select);
 			 $data['heading']="Update User";
			 $data['button']="Update";
    	}else{
			$data['user']['id']='';
			$data['user']['role_id']='';
			$data['user']['first_name']='';
			$data['user']['last_name']='';
			$data['user']['phone']='';
			$data['user']['email']='';
			$data['user']['country']=0;
			$data['user']['state']=0;
			$data['user']['city']=0;
			$data['user']['street']='';
			$data['user']['address']='';
			$data['user']['image']='';
			$data['user']['top']=0;
			$data['user']['status']=1;
			$data['user']['forecast']=1;
			$data['user']['publication']=1;
			$data['user']['publication_notification_status']=0;
			$data['user']['matching']=1;
			$data['user']['zip']='';
			$data['user']['verified']=0;
			$data['heading']="Add User";
			$data['button']="Add";
 		}
 		$this->load->view('admin/users/add-update-user',$data); 
	}




	public function viewUser(){
		$id=$this->uri->segment(2);
		if($id>0){
			$select=array('u.id'=>$id);
			$data['user']=$this->Users_model->userData($select);
			$this->load->view('admin/users/view-user',$data);
     	}
	}
 	public function saveUser(){
		$this->isAjaxRequest();
		$response['status']=TRUE;
		//$image_error='';
		$email_error='';
		$phone_error='';
		$old_image=$this->input->post('old_image');
		$user_image=$this->input->post('user_image');
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim');
		$this->form_validation->set_rules('role_id', 'Role', 'trim|required');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');

		$email=$this->input->post('email');
		$phone=$this->input->post('phone');
		$id=$this->input->post('id') ? $this->input->post('id'):0;
		if(!empty($email)){
			$where=array('email'=>$email);
			if($id>0){
				$where['id <>']=$id;
			}
			if(!$this->Common_model->checkExist('users',$where)){
				$response['status']=FALSE;
				$email_error="Email Address already exists";
			}
		}
		if(!empty($phone)){
			$phone=array('phone'=>$phone);
			if($id>0){
				$where['id <>']=$id;
			}
			if(!$this->Common_model->checkExist('users',$where)){
				$response['status']=FALSE;
				$phone_error="Phone Number already exists";
			}
		}

		/*
		if($this->form_validation->run() == TRUE && $response['status']==TRUE){
			if(!empty($_FILES['image']['name'])){
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'image';
				$file_response=uploadImage('users',$allowed_types,$input_name,$old_image);
				if($file_response['status']){
					$user_image=$file_response['name'];
				}else{
					$response['status']=false;
					$image_error=$file_response['message'];
				}
			}else{
				$user_image=$old_image;
			}
		}
		*/
		
		if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
			$response=$this->form_validation->error_array();
			$response['status']=false;
			//if(!empty($image_error)){
			//	$response['image']=$image_error;
			//}
			if(!empty($email_error)){
				$response['email']=$email_error;
			}
			if(!empty($phone_error)){
				$response['phone']=$phone_error;
			}
			$response['message']='There is error in submitting form!';
		}else{
			$user_image=$this->input->post('user_image');
			$image_path['full_path']=$this->input->post('image_path');
			$image_path['file_name']=$user_image;
			$old_image=$this->input->post('old_image');
			if(!empty($user_image)){
				$image_sizes = array('thumb' => array(80, 80),'medium' => array(600, 450));
				$path='./attachments/users/'; 
				resizeImage($path,$image_path,$old_image,$image_sizes);
				if(is_file($image_path['full_path'])){
					copy($image_path['full_path'],$path.'main/'.$user_image);
					unlink($image_path['full_path']);
				}
			}else{
				$user_image=$old_image;
			}

   			$save_data=array(
				'id'=>$this->input->post('id')? $this->input->post('id'):0,
				'role_id'=>$this->input->post('role_id'),
				'first_name'=>$this->input->post('first_name'),
				'last_name'=>$this->input->post('last_name'),
				'email'=>$this->input->post('email'),
				'phone'=>$this->input->post('phone'),
				'status'=>$this->input->post('status'),
				'verified'=>$this->input->post('verified'),
				'top'=>$this->input->post('top'),
				'forecast'=>$this->input->post('forecast'),
				'publication'=>$this->input->post('publication'),
				'publication_notification_status'=>$this->input->post('publication_notification_status'),
				'matching'=>$this->input->post('matching'),
				'image'=>$user_image ? $user_image:'',
			);
			$user_id=$this->Common_model->AddUpdateData('users',$save_data);
			if($save_data['id']>0){
				$id=$save_data['id'];
				$action="Updated";
			}else{
				$id=$user_id;
				$action="Added";
				$template_data['registration']=$save_data;
				$this->db->select('r.name as role_name');
				$this->db->from('users u');
				$this->db->join('role r ','r.id=u.role_id','inner');
				$this->db->where('u.id',$user_id);
				$result=$this->db->get();
				$data=$result->row_array();

				$template_data['registration']['role_name']=$data['role_name'];
				$mail_message=$this->load->view('website/email_templates/registration-admin', $template_data, true);
				sendEmail(ADMINEMAIL,"",'Registration',$mail_message);
				
				$this->db->where('id',1);
				$email_data=$this->db->get('email_templates')->row_array();
				$template_data['email_data']=$email_data;
				$mail_message=$this->load->view('website/email_templates/registration-customer', $template_data, true);
				sendEmail($save_data['email'],"",$email_data['subject'],$mail_message);
			}
			if($id==$this->session->userdata('admin_data')['id']){
				$this->session->set_userdata($save_data);
			}
			$message = "User ".$action." Successfully!";
			$this->session->set_flashdata('success_message',$message);
			$slug=makeSlug($save_data['first_name'].'-'.$save_data['last_name'].'-'.$id);
			$update_data=array('id'=>$id,'slug'=>$slug,'modified_date'=>'now()');
			$this->Common_model->AddUpdateData('users',$update_data);
			$logdata=array(
				'activity_in'=>1,
				'category'=>0,
				'reference_id'=>$id,
				'action'=>$action,
				'message'=>$message,
				'modified_data'=>json_encode($this->input->post()),
				'done_by'=>$this->session->userdata('admin_data')['id']
			);
			activityLog($logdata);
			$response['message']=$message;
			$response['id']=$id;
			
		}
		echo json_encode($response);
		 
	}
	
	function uploadUserImage(){
		$this->isAjaxRequest();
		$response=uploadCroperImage('users',$this->session->userdata('admin_data')['id'],$this->input->post('image'));
		echo json_encode($response);
	}
	

	public function changeStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			$update_data=array('id'=>$id,'status'=>$status);
			$response['status']=$this->Common_model->changeDataStatus('users',$update_data);
			if($response['status']){
				$response['message']="User Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>0,
					'reference_id'=>$id,
					'action'=>'Updated',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
			}
			$data=array('status'=>1);
			echo json_encode($data);
		}
	}

 
	function deleteUser(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$user_data=array('id'=>$id);
			$user_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('users',$user_data);
			if($response['status']){
				$response['message']="User Deleted Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>0,
					'reference_id'=>$id,
					'action'=>'Deleted',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
			}
			echo json_encode($response);
		}	 
	}

	//deleteUserImage

	public function deleteUserImage(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$image=$this->input->post('image');
		if(!empty($id) && !empty($image)){
			$update_data=array(
				'image'=>'',
				'id'=>$id
			);
 			$result=$this->Common_model->AddUpdateData('users',$update_data);
			unlinkImage('users',$image);
			if($result){
				$response['message']="User Image deleted successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>0,
					'reference_id'=>$id,
					'action'=>'Deleted',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('id')
				);
				activityLog($logdata);
				$response['status']=true;
			}else{
				$response=array('status'=>false,'message'=>"There is an error!");
			}
			echo json_encode($response);
		}
	}

	public function manageUsersAddress(){
		$this->isAjaxRequest(); 
		$response['data']=$this->Users_model->manageUsersAddressAjax($_POST,false);
		$response['total']=$this->Users_model->manageUsersAddressAjax($_POST,true);
		$this->getJson($response);
	}
	
	public function addressList()
	{
		$id=$this->uri->segment(2);
		if($id>0){
			$data['user_id']=$id;
		}else{
			$data['user_id']=0;
		}
		$where=array('status'=>1);
 		$this->load->view('admin/users/manage-user-addresses',$data);
	}

	public function userUpdateAddress(){
		$id=$this->uri->segment(2);
		if($id>0){
			$data['heading']="Update Address";
			$data['button']="Update";
 			$where=array('id'=>$id);
			$data['address']=$this->Users_model->addressData($where);
			$this->load->view('admin/users/add-update-user-address',$data); 
     	}
	}
	public function userAddAddress(){
	$id=$this->uri->segment(2);
		if($id>0){
			$select=array('u.id'=>$id);
		 	$data['address']['user_name']=$this->Users_model->userData($select)['first_name'];
			$data['heading']="Add Address";
			$data['button']="Add";
			$data['address']['name']='';
			$data['address']['phone']='';
			$data['address']['email']='';
			$data['address']['country']=0;
			$data['address']['state']=0;
			$data['address']['city']=0;
			$data['address']['address']='';
			$data['address']['street']='';
			$data['address']['landmark']='';
			$data['address']['block']='';
			$data['address']['status']=1;
			$data['address']['id']='';
			$data['address']['zip']='';
			$data['address']['user_id']=$id;
 			$this->load->view('admin/users/add-update-user-address',$data); 
     	}
	}


	public function saveUserAddress(){
		$this->isAjaxRequest();
		$response['status']=true;
		$email_error='';
		$old_image=$this->input->post('old_image');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');
		$this->form_validation->set_rules('change_country', 'Phone Number', 'trim|required');
		$this->form_validation->set_rules('change_state', 'State Name', 'trim|required');
		$this->form_validation->set_rules('change_city', 'City Name', 'trim|required');
		$this->form_validation->set_rules('landmark', 'lankmark', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('zip', 'Zip', 'trim|required');

		$email=$this->input->post('email');
		$id=$this->input->post('id') ? $this->input->post('id'):0;
		/*if(!empty($email)){
			$where=array('email'=>$email);
			if($id>0){
				$where['id <>']=$id;
			}
			$response['status']=$this->Common_model->checkExist('user_address',$where);
			if(!$response['status']){
				$email_error="Email Address already  exists";
			}
		}*/

		if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
			$response=$this->form_validation->error_array();
			$response['status']=false;
			if(!empty($email_error)){
				$response['email']=$email_error;
			}
			$response['message']='There is error in submitting form!';
		}else{
			$save_data=array(
				'id'=>$this->input->post('id')? $this->input->post('id'):0,
				'user_id'=>$this->input->post('user_id'),
				'name'=>$this->input->post('name'),
				'email'=>$this->input->post('email'),
				'phone'=>$this->input->post('phone'),
				'country'=>$this->input->post('change_country'),
				'state'=>$this->input->post('change_state'),
				'city'=>$this->input->post('change_city'),
				'address'=>$this->input->post('address'),
				'street'=>$this->input->post('street'),
				'block'=>$this->input->post('block'),
				'status'=>$this->input->post('status'),
				'landmark'=>$this->input->post('landmark'),
				'zip'=>$this->input->post('zip'),
			);

			$address_id=$this->Common_model->AddUpdateData('user_address',$save_data);
			if($save_data['id']>0){
				$id=$save_data['id'];
				$action="Updated";
			}else{
				$id=$address_id;
				$action="Added";
			}
			$message = "User Address ".$action." Successfully!";
			$this->session->set_flashdata('success_message',$message);
			$logdata=array(
				'activity_in'=>1,
				'category'=>2,
				'reference_id'=>$id,
				'action'=>$action,
				'message'=>$message,
				'modified_data'=>json_encode($this->input->post()),
				'done_by'=>$this->session->userdata('admin_data')['id']
			);
			activityLog($logdata);
			$response['message']=$message;
		}
		echo json_encode($response);
		
	}

	public function changeAddressStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			$update_data=array('id'=>$id,'status'=>$status);
			$response['status']=$this->Common_model->changeDataStatus('user_address',$update_data);
			if($response['status']){
				$response['message']="User Address Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>1,
					'reference_id'=>$id,
					'action'=>'Updated',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
			}
			$data=array('status'=>1);
			echo json_encode($data);
		}
	}

	function deleteUserAddress(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$user_data=array('id'=>$id);
			$user_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('user_address',$user_data);
			if($response['status']){
				$response['message']="User Address Deleted Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>1,
					'reference_id'=>$id,
					'action'=>'Deleted',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
			}
			echo json_encode($response);
		}
	}


	public function viewUserAddress(){
		$id=$this->uri->segment(2);
		if($id>0){
			$where=array('ua.id'=>$id);
			$data['address']=$this->Users_model->viewUserAddress($where);
			$this->load->view('admin/users/view-user-address',$data); 
		}		 
	}


	public function subscribersList(){
		if(isset($_POST['export'])){
			$this->exportsubscribers();
		}
 		$this->load->view('admin/users/manage-subscribers');
	}

	public function exportsubscribers()
	{
		//echo"<pre>";print_r($_POST); die;
        // file name 
        $Subscribers = $this->Users_model->manageSubscriberExport($_POST,false);
        
        $filename = 'subscribers_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
       
        // get data 
        
     
        // file creation 
        $file = fopen('php://output', 'w');

        $header = array(
            "Email",
            "Added_Date",

              ); 
        fputcsv($file, $header);
        foreach ($Subscribers as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
       }

	public function manageSubscribers(){
		$this->isAjaxRequest();
		$response['data']=$this->Users_model->manageSubscribersAjax($_POST,false);
		$response['total']=$this->Users_model->manageSubscribersAjax($_POST,true);
		$this->getJson($response);
	}
	
	function deleteSubscribers(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$subscribers_data=array('id'=>$id);
			$subscribers_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('subscribers',$subscribers_data);
			if($response['status']){
				$response['message']="Subscribers Deleted Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>8,
					'reference_id'=>$id,
					'action'=>'Deleted',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
			}
			echo json_encode($response);
		}	 
	}

	function sendNotification(){
		$this->isAjaxRequest();
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
		$this->form_validation->set_rules('type', 'Type', 'trim|required');
		$this->form_validation->set_rules('message', 'Message', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == FALSE) {
			$response['response']=$this->form_validation->error_array();
			$response['status']=false;
			$response['message']='There is error in submitting form!';
		}else{
			$user_id_arr=explode(',',rtrim($this->input->post('user_ids'),','));
			$subject=$this->input->post('subject');
			$message=$this->input->post('message');
 			if(count($user_id_arr)>0){
				$summary_mail='';
				foreach($user_id_arr as $userid){
					$select=array('u.id'=>$userid);
					$user_data=$this->Users_model->userData($select);
					if($this->input->post('type')==1){
						$type="Crops Publications";
					}else if($this->input->post('type')==2){
						$type="Market Publications";
					}
					else if($this->input->post('type')==3){
						$type="Official / Government Publications";
					}
					$template_data['template']=array(
						'name'=>$user_data['first_name'].' '.$user_data['last_name'],
						'email'=>$user_data['email'],
						'subject'=>$subject,
						'type'=>$type,
						'message'=>$message,
					);
					$mail_message=$this->load->view('admin/email-templates/customer_notification',$template_data,true);
					$summary_mail .=$mail_message;
					$sent=sendEmail($user_data['email'],'',$subject,$mail_message);
					if($sent) {
						$save_data=array(
							'id'=>'',
							'customer_id'=>$userid,
							'subject'=>$subject,
							'type'=>$this->input->post('type'),
							'message'=>$message
						);
						$this->Common_model->AddUpdateData('customer_notification_summary',$save_data);
						$response['message']="Notification Sent Successfully!";
						$logdata=array(
							'activity_in'=>1,
							'category'=>11,
							'reference_id'=>$userid,
							'action'=>'Notification Sent',
							'message'=>$response['message'],
							'modified_data'=>json_encode($this->input->post()),
							'done_by'=>$this->session->userdata('admin_data')['id']
						);
						activityLog($logdata);
					}
				}
				sendEmail(ADMINEMAIL,'','Email Notification Summary',$summary_mail);
				$response['status']=true;
 				$this->session->set_flashdata('success_message',$response['message']);
			}
		}
		echo json_encode($response);
	}

	function deleteNotifications(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$user_data=array('id'=>$id);
			$user_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('customer_notification_summary',$user_data);
			if($response['status']){
				$response['message']="Notification Deleted Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>0,
					'reference_id'=>$id,
					'action'=>'Deleted',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
			}
			echo json_encode($response);
		}	 
	}


	public function manageServiceCategories()
	{
		if(isset($_POST['export'])){
			$this->exportServiceCategory();
		//echo "<pre>"; print_r($_POST); die;
		}
 	 	$this->load->view('admin/services/manage-services-categories');
	}

       public function exportServiceCategory(){ 
        // file name 
        //print_r($_POST); die; 

        $serviceCategory = $this->Users_model->manageServiceCategoriesExport($_POST,false);
        //echo "abcd";
     	 //echo"<pre>"; print_r($serviceCategory); die;
        $filename = 'servicesCategory_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
       
        // get data 
        
             // file creation 
        $file = fopen('php://output', 'w');

        $header = array(
            "Name",
            "Status",
            "Added_Date",
            
              ); 
        fputcsv($file, $header);
        foreach ($serviceCategory as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
       }


	public function manageServiceCategoriesAjax()
	{
		$this->isAjaxRequest();
		$response['data']=$this->Users_model->manageServiceCategoriesAjax($_POST,false);
		$response['total']=$this->Users_model->manageServiceCategoriesAjax($_POST,true);
		$this->getJson($response);
	}
	public function changeServiceCategoryStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			$update_data=array('id'=>$id,'status'=>$status);
			$response['status']=$this->Common_model->changeDataStatus('service_category',$update_data);
			if($response['status']){
				$response['message']="Service Category Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>12,
					'reference_id'=>$id,
					'action'=>'Updated',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
			}
			$data=array('status'=>1,'message'=>$response['message']);
			echo json_encode($data);
		}
	}

	public function viewServiceCategory(){
		$id=$this->uri->segment(2);
		if($id>0){
			$where=array('sc.id'=>$id);
			$data['service']=$this->Users_model->serviceCategoryData($where);
			$service_category_data=$this->Users_model->getServiceCategoryData(array('sc.id'=>$id));
			if(count($service_category_data)>0){
				foreach($service_category_data as $service_category_row){
					$data['names'][$service_category_row['abbr']]=$service_category_row;
				}	
			}
			$this->load->view('admin/services/view-service-category',$data); 
		}		 
	}


	public function addUpdateServiceCategory(){
		$data=array();
	  	$id=$this->uri->segment(2);
		if($id>0){
			$select=array('sc.id'=>$id);
			$data['service_category']=$this->Users_model->serviceCategoryData($select);
			$service_category_data=$this->Users_model->getServiceCategoryData(array('sc.id'=>$id));
			if(count($service_category_data)>0){
				foreach($service_category_data as $service_category_row){
					$data['names'][$service_category_row['abbr']]=$service_category_row;
				}	
			}
 			$data['heading']="Update Service Category";
			$data['button']="Update";
    	}else{
			$data['service_category']['id']='';
			$data['service_category']['name']='';
 			$data['service_category']['status']=1;
			$data['heading']="Add Service Category";
			$data['button']="Add";
 		}
		$this->load->view('admin/services/add-update-service-category',$data); 
	}
	
	public function saveServiceCategory(){
		$this->isAjaxRequest();
		$response['status']=TRUE;
 		$name_error='';
 		$languages=getLanguageList(); 
		  if(count($languages)){
			  foreach($languages as $language){
				  $this->form_validation->set_rules('name'.$language['abbr'], 'Service Category Name ('.ucfirst($language['name']).')', 'trim|required');
			  }
		  }
 	//	$name=$this->input->post('name');
		$id=$this->input->post('id') ? $this->input->post('id'):0;
		/*if(!empty($name)){
			$where=array('name'=>$name);
			if($id>0){
				$where['id <>']=$id;
			}
			if(!$this->Common_model->checkExist('service_category',$where)){
				$response['status']=FALSE;
				$name_error="Service Category Name already exists!";
			}
		}*/
		 
		if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
			$response=$this->form_validation->error_array();
			//if(!empty($name_error)){
			//	$response['name']=$name_error;
			//}
			$response['message']='There is error in submitting form!';
		}else{
			$save_data=array(
				'id'=>$this->input->post('id')? $this->input->post('id'):0,
  				'status'=>$this->input->post('status'),
 			);
			$category_id=$this->Common_model->AddUpdateData('service_category',$save_data);
			$slug=makeSlug($this->input->post('nameen').'-'.$category_id);
			$update_data=array('id'=>$category_id,'slug'=>$slug);
			$this->Common_model->AddUpdateData('service_category',$update_data);

			$languages=$this->input->post('languages');
			if(count($languages)){
				$this->Common_model->deleteRecord(array('category_id'=>$category_id),'service_category_translator');
				foreach($languages as $language){
					$save_data=array(
					'id'=>0,
					'category_id'=>$category_id,
					'name'=>$this->input->post('name'.$language),
 					'abbr'=>$language,
 					);
					$id=$this->Common_model->AddUpdateData('service_category_translator',$save_data);
					$slug=makeSlug($save_data['name'].'-'.$id);
					$update_data=array('id'=>$id,'slug'=>$slug);
					$this->Common_model->AddUpdateData('service_category_translator',$update_data);
					}
				}
			if($save_data['id']>0){
				$id=$save_data['id'];
				$action="Updated";
			}else{
				$id=$category_id;
				$action="Added";
			}

			$message = "Service Category ".$action." Successfully!";
			$this->session->set_flashdata('success_message',$message);
 			$logdata=array(
				'activity_in'=>1,
				'category'=>12,
				'reference_id'=>$id,
				'action'=>$action,
				'message'=>$message,
				'modified_data'=>json_encode($this->input->post()),
				'done_by'=>$this->session->userdata('admin_data')['id']
			);
			activityLog($logdata);
			$response['message']=$message;
			$response['id']=$id;
			
		}
		echo json_encode($response);
	}

	function deleteServiceCategory(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$user_data=array('id'=>$id);
			$user_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('service_category',$user_data);
			if($response['status']){
				$response['message']="Service Category Deleted Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>12,
					'reference_id'=>$id,
					'action'=>'Deleted',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
			}
			echo json_encode($response);
		}
	}

	public function manageServiceProviderServices()
	{
		$where=array('sc.status'=>1,'sc.is_deleted'=>0,'sct.abbr'=>'en');
		$data['service_categories']=$this->Users_model->getServicesCategories($where);
		$data['service_providers']=$this->Users_model->getUserList(array('r.id'=>5,'u.is_deleted'=>0));
			if(isset($_POST['export'])){
			$this->exportserviceProvider();
		}
  	 	$this->load->view('admin/services/manage-service-provider-services',$data);
	}


	public function exportserviceProvider(){ 
		// print_r($_POST); die;
        // file name 
        $service_provider = $this->Users_model->manageServiceProviderServices($_POST,false);
        //echo"<pre>"; print_r($service_provider); die;
        
        $filename = 'serviceprovider_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
       
        // get data 
        
     
        // file creation 
        $file = fopen('php://output', 'w');

        $header = array(
            "Name",
            "Price",
           	"Description",
            "Added_date",
            "Service Provider Name"
           
              ); 
        fputcsv($file, $header);
        foreach ($service_provider as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
       }

	

	public function manageServiceProviderServicesAjax(){
		$this->isAjaxRequest();
		$data=$this->Users_model->manageServiceProviderServicesAjax($_POST,false);
		$response['total']=$this->Users_model->manageServiceProviderServicesAjax($_POST,true);
		$response['data']=array();
		if(count($data)>0){
			foreach($data as $row){
				if(is_file('./attachments/services/thumb/'.$row['image']) && !empty($row['image'])){
					$image=base_url('attachments/services/thumb/'.$row['image']);	
				}else{
					$image='';
				}
				$response['data'][]=array(
					'id'=>$row['id'],
					'service_category_name'=>$row['service_category_name'],
					'service_provider_name'=>$row['service_provider_name'],
					'name'=>$row['name'],
					'price'=>$row['price'],
					'description'=>$row['description'],
 					'added_date'=>$row['added_date'],
					'image'=>$image,
					'status'=>$row['status'],
				);
			}
		}
		$this->getJson($response);
	}

	public function viewService(){
		$id=$this->uri->segment(2);
		if($id>0){
			$where=array('sps.id'=>$id);
			$data['service']=$this->Users_model->serviceData($where);
			$service_name_data=$this->Users_model->getServiceData(array('s.id'=>$id));
				if(count($service_name_data)>0){
					foreach($service_name_data as $service_name_row){
						$data['names'][$service_name_row['abbr']]=$service_name_row;
					}	
				}
			$this->load->view('admin/services/view-service-provider-service',$data); 
		}		 
	}
	public function changeServiceStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			$update_data=array('id'=>$id,'status'=>$status);
			$response['status']=$this->Common_model->changeDataStatus('service_provider_services',$update_data);
			if($response['status']){
				$response['message']="Service Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>12,
					'reference_id'=>$id,
					'action'=>'Updated',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
			}
			$data=array('status'=>1,'message'=>$response['message']);
			echo json_encode($data);
		}
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
				$logdata=array(
					'activity_in'=>1,
					'category'=>12,
					'reference_id'=>$id,
					'action'=>'Deleted',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
			}
			echo json_encode($response);
		}
	}
	


	public function addUpdateService(){
		$data=array();
	  	$id=$this->uri->segment(2);
		if($id>0){
			$where=array('sps.id'=>$id);
			$data['service']=$this->Users_model->serviceData($where);
			$service_name_data=$this->Users_model->getServiceData(array('s.id'=>$id));
				if(count($service_name_data)>0){
					foreach($service_name_data as $service_name_row){
						$data['names'][$service_name_row['abbr']]=$service_name_row;
					}	
				}
  			$data['heading']="Update Service";
			$data['button']="Update";
     	}else{
			$data['service']['id']='';
			$data['service']['service_provider_id']='';
			$data['service']['service_category_id']='';
			//$data['service']['name']='';
 			$data['service']['price']='';
			//$data['service']['description']='';
 			$data['service']['image']='';
			$data['service']['status']=1;
 			$data['heading']="Add Service";
			$data['button']="Add";
		 }
		$where=array('sc.status'=>1,'sc.is_deleted'=>0,'sct.abbr'=>'en');
		$data['service_categories']=$this->Users_model->getServicesCategories($where);
		$data['service_providers']=$this->Users_model->getUserList(array('r.id'=>5,'u.is_deleted'=>0));
 		$this->load->view('admin/services/add-update-service-provider-service',$data); 
	}
 
 	public function saveService(){
		$this->isAjaxRequest();
		$response['status']=TRUE;
		$image_error='';
		$old_image=$this->input->post('old_image');
		$languages=getLanguageList(); 
		if(count($languages)){
			foreach($languages as $language){
				$this->form_validation->set_rules('name'.$language['abbr'], 'Service Name ('.ucfirst($language['name']).')', 'trim|required');
			}
		}

		$this->form_validation->set_rules('service_provider_id', 'Service Provider Name', 'trim|required');
		$this->form_validation->set_rules('service_category_id', 'Service Category Name', 'trim|required');
		$this->form_validation->set_rules('price', 'Service Price', 'trim|required');
  
 		$id=$this->input->post('id') ? $this->input->post('id'):0;
	  

		if($this->form_validation->run() == TRUE && $response['status']==TRUE){
			if(!empty($_FILES['image']['name'])){
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'image';
				$file_response=uploadImage('services',$allowed_types,$input_name,$old_image);
				if($file_response['status']){
					$user_image=$file_response['name'];
				}else{
					$response['status']=false;
					$image_error=$file_response['message'];
				}
			}else{
				$user_image=$old_image;
			}
		}
		
		if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
			$response=$this->form_validation->error_array();
			$response['status']=false;
			if(!empty($image_error)){
				$response['image']=$image_error;
			}
			$response['message']='There is error in submitting form!';
		}else{
			$save_data=array(
				'id'=>$id,
				'service_provider_id'=>$this->input->post('service_provider_id'),
				'service_category_id'=>$this->input->post('service_category_id'),
				'price'=>$this->input->post('price'),
 				'status'=>$this->input->post('status'),
 				'image'=>$user_image ? $user_image:'',
			);
			$service_id=$this->Common_model->AddUpdateData('service_provider_services',$save_data);
			$slug=makeSlug($this->input->post('nameen').'-'.$service_id);
			$update_data=array('id'=>$service_id,'slug'=>$slug);
			$this->Common_model->AddUpdateData('service_provider_services',$update_data);
			$languages=$this->input->post('languages');
			if(count($languages)){
				$this->Common_model->deleteRecord(array('service_id'=>$service_id),'service_provider_service_translator');
				foreach($languages as $language){
					$save_data=array(
					'id'=>0,
					'service_id'=>$service_id,
					'name'=>$this->input->post('name'.$language),
 					'description'=>$this->input->post('description'.$language),
					'abbr'=>$language,
 					);
					$id=$this->Common_model->AddUpdateData('service_provider_service_translator',$save_data);
					$slug=makeSlug($save_data['name'].'-'.$id);
					$update_data=array('id'=>$id,'slug'=>$slug);
					$this->Common_model->AddUpdateData('service_provider_service_translator',$update_data);
					}
				}

			$slug=makeSlug($this->input->post('nameen').'-'.$service_id);
			$update_data=array('id'=>$service_id,'slug'=>$slug);
			$this->Common_model->AddUpdateData('service_provider_services',$update_data);

			if($save_data['id']>0){
				$id=$save_data['id'];
				$action="Updated";
			}else{
				$id=$service_id;
				$action="Added";
			}
			 
			$message = "Service  ".$action." Successfully!";
			$this->session->set_flashdata('success_message',$message);
 			$logdata=array(
				'activity_in'=>1,
				'category'=>12,
				'reference_id'=>$id,
				'action'=>$action,
				'message'=>$message,
				'modified_data'=>json_encode($this->input->post()),
				'done_by'=>$this->session->userdata('admin_data')['id']
			);
			activityLog($logdata);
			$response['message']=$message;
			$response['id']=$id;
		}
		echo json_encode($response);
		 
	}

	public function deleteServiceImage(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$image=$this->input->post('image');
		if(!empty($id) && !empty($image)){
			$update_data=array(
				'image'=>'',
				'id'=>$id
			);
 			$result=$this->Common_model->AddUpdateData('service_provider_services',$update_data);
			unlinkImage('services',$image);
			if($result){
				$response['message']="Service Image deleted successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>0,
					'reference_id'=>$id,
					'action'=>'Deleted',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('id')
				);
				activityLog($logdata);
				$response['status']=true;
			}else{
				$response=array('status'=>false,'message'=>"There is an error!");
			}
			echo json_encode($response);
		}
	}

	
	public function notifications()
	{
 	 	$this->load->view('admin/notifications/manage-notifications');
	}
		
	public function manageNotificationsAjax(){
		$this->isAjaxRequest();
		$response['data']=$this->Users_model->manageNotificationsAjax($_POST,false);
		$response['total']=$this->Users_model->manageNotificationsAjax($_POST,true);
		$this->getJson($response);
	}

	public function matchingAndConnection(){
		$customer_id=$this->uri->segment(2);
		if($customer_id>0){
			$data['customer_id']=$customer_id;
			$this->load->view('admin/notifications/manage-matching-and-connections',$data);
		}else{
			redirect(base_url('admin-dashboard'));
		}
	}
     
     public function matchingAndConnectionAjax(){
		$this->isAjaxRequest();
 		$data=$this->Users_model->matchingAndConnectionAjax($_POST,false);
		$response['data']=array();
		if(count($data)){
			foreach($data as $row){
				if(is_file('./attachments/products/thumb/'.$row['image'])){
					$image=base_url('attachments/products/thumb/'.$row['image']);	
			   }else{
				   $image=base_url('assets/frontend/images/prd1.jpg');
			   }
			   
				$response['data'][]=array(
					'id'=>$row['id'],
					'image'=>$image,
					'category_name'=>$row['category_name'],
					'parent_category_name'=>$row['parent_category_name'],
  					'customer_name'=>$row['customer_name'],
   					'status'=>$row['status'],
 				);
			}
		}
		$response['total']=$this->Users_model->matchingAndConnectionAjax($_POST,true);
		$this->getJson($response);
	}


	public function changeMatchingAndConnectionStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			$update_data=array('id'=>$id,'status'=>$status);
			$response['status']=$this->Common_model->changeDataStatus('product_matching_and_connections',$update_data);
			if($response['status']){
				$response['message']="Matching and connection Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>22,
					'reference_id'=>$id,
					'action'=>'Updated',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
			}
			$data=array('status'=>1,'message'=>$response['message']);
			echo json_encode($data);
		}
	}
	
	
}
