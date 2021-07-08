<?php
class Page extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
 		$this->load->model('admin/Page_model');
    }
	public function index()
	{
		if(isset($_POST['export'])){
			$this->exportmanagePages();
		}
 	 	$this->load->view('admin/page/manage-page');
	}
	public function exportmanagePages()
		{
			$csv_data=array();
		$managepages = $this->Page_model->managepagesExport($_POST,false);
		foreach($managepages as $managepage)
		{
			$csv_data[]=array(
				'name' => $managepage['name'],
				'meta_title' => $managepage['meta_title'],
				'meta_keywords' => $managepage['meta_keywords'],
				'status' => $managepage['status']?'active':'inactive',

			);
		}
        //echo"<pre>"; print_r($category);die;
        $filename = 'Pages_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
      
        // file creation 
        $file = fopen('php://output', 'w');

        $header = array(
            "Name",
            "Meta_Title",
            "Meta_keywords",
            "Status",
               ); 
        fputcsv($file, $header);
        foreach ($csv_data as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
		}

	public function managePages(){
		$this->isAjaxRequest();
		$response['data']=$this->Page_model->managePagesAjax($_POST,false);
		$response['total']=$this->Page_model->managePagesAjax($_POST,true);
		$this->getJson($response);
	}

	public function addUpdatePage(){
		$data=array();
	  	$id=$this->uri->segment(2);
		if($id>0){
			$select=array('id'=>$id);
			$pagedata=getSingleTableData('cms_pages',$select);
			 if(count($pagedata)>0){
				$data['page']=$pagedata[0];
			}
			else
			{
				redirect('admin-dashboard');
			}
			$data['heading']="Update Page";
			$data['button']="Update";
    	}else{
			$data['page']['id']='';
			$data['page']['name']='';
			$data['page']['slug']='';
			$data['page']['meta_title']=''; 
			$data['page']['banner_title']='';
			$data['page']['meta_keywords']='';
			$data['page']['meta_description']='';
			$data['page']['description']='';
			$data['page']['image']='';
			$data['page']['banner_image']='';
			$data['page']['status']=1;
			$data['heading']="Add Page";
			$data['button']="Add";
			
 		}
 		$this->load->view('admin/page/add-update-page',$data); 
	}

	public function viewPage(){
		$id=$this->uri->segment(2);
		if($id>0){
			$select=array('id'=>$id);
			$pagedata=getSingleTableData('cms_pages',$select);
			 if(count($pagedata)>0){
				$data['page']=$pagedata[0];
			}
			else
			{
				redirect('admin-dashboard');
			}
			$this->load->view('admin/page/view-page',$data);
     	}
	}
 	public function savePage(){
		$this->isAjaxRequest();
		$response['status']=true;
		$name_error='';
		$image_error='';
		$banner_image_error='';
		$this->form_validation->set_rules('name', 'Page Name', 'trim|required');
		$this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required');
		$this->form_validation->set_rules('meta_keywords', 'Meta Title', 'trim|required');
		$this->form_validation->set_rules('banner_title', 'Banner Title', 'trim|required');
		$this->form_validation->set_rules('description', 'Page Description', 'trim|required');

		$name=$this->input->post('name');
		$old_image=$this->input->post('old_image');
		$old_banner_image=$this->input->post('old_banner_image');
		
		$id=$this->input->post('id') ? $this->input->post('id'):0;
		if(!empty($name)){
			$where=array('name'=>$name);
			if($id>0){
				$where['id <>']=$id;
			}
			$response['status']=$this->Common_model->checkExist('cms_pages',$where);
			if(!$response['status']){
				$name_error="Page Name already  exists";
			}
		}

		if($this->form_validation->run() == TRUE && $response['status']==TRUE){
			if(!empty($_FILES['page_image']['name'])){
			   $allowed_types = 'png|jpg|jpeg|gif';
			   $input_name = 'page_image';
			   $file_response=uploadImage('pages',$allowed_types,$input_name,$old_image);
 			   if($file_response['status']){
				   $image=$file_response['name'];
			   }else{
				   $response['status']=false;
				   $image_error=$file_response['message'];
			   }
		   }else{
			   $image=$old_image;
		   }

		   if(!empty($_FILES['banner_image']['name'])){
			$imageInformation = getimagesize($_FILES['banner_image']['tmp_name']);
 			
			$imageWidth = $imageInformation[0]; 
 			$imageHeight = $imageInformation[1]; 
			
			if($imageWidth<1400 &&  $imageWidth>1300 && $imageHeight < 600 && $imageHeight >250)
			{
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'banner_image';
				$file_response=uploadImage('pages',$allowed_types,$input_name,$old_banner_image);
				 if($file_response['status']){
					$banner_image=$file_response['name'];
				}else{
					$response['status']=false;
					$banner_image_error=$file_response['message'];
				}
			}else{
				$response['status']=false;
				$banner_image_error="Opps Banner Image Size exceeded!";
			}


			
		}else{
			$banner_image=$old_banner_image;
		}
	   } 

		if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
			$response=$this->form_validation->error_array();
			$response['status']=false;
			if(!empty($name_error)){
				$response['name']=$name_error;
			}
			if(!empty($image_error)){
				$response['page_image']=$image_error;
			}

			if(!empty($banner_image_error)){
				$response['banner_image']=$banner_image_error;
			}
			$response['message']='There is error in submitting form!';
		}else{
			$save_data=array(
				'id'=>$this->input->post('id')? $this->input->post('id'):0,
				'name'=>$this->input->post('name'),
				'meta_title'=>$this->input->post('meta_title'),
				'banner_title'=>$this->input->post('banner_title'),
				'meta_keywords'=>$this->input->post('meta_keywords'),
				'meta_description'=>$this->input->post('meta_description'),
				'description'=>$this->input->post('description'),
 				'status'=>$this->input->post('status'),					
			);
			if(!empty($image)){
				$save_data['image']=$image;
			}
			if(!empty($image)){
				$save_data['banner_image']=$banner_image;
			}

			$page_id=$this->Common_model->AddUpdateData('cms_pages',$save_data);
			

			if($save_data['id']>0){
				$id=$save_data['id'];
				$action="Updated";
			}else{
				$id=$page_id;
				$action="Added";
			}
			$message = "CMS Page ".$action." Successfully!";
			$this->session->set_flashdata('success_message',$message);
			$slug=makeSlug($save_data['name'].'-'.$id);
			$update_data=array('id'=>$id,'slug'=>$slug,'modified_date'=>'now()');
			$this->Common_model->AddUpdateData('cms_pages',$update_data);
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

	
	public function deletePageImage(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$image=$this->input->post('image');
		if(!empty($id) && !empty($image)){
			$update_data=array(
				'image'=>'',
				'id'=>$id
			);
 			$result=$this->Common_model->AddUpdateData('cms_pages',$update_data);
			unlinkImage('vendor',$image);
			if($result){
				$response['message']="Page Image deleted successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>2,
					'reference_id'=>$id,
					'action'=>'Deleted',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
				$response['status']=true;
			}else{
				$response=array('status'=>false,'message'=>"There is an error!");
			}
			echo json_encode($response);
		}
	}
	public function deletePageBannerImage(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$image=$this->input->post('image');
		if(!empty($id) && !empty($image)){
			$update_data=array(
				'banner_image'=>'',
				'id'=>$id
			);
 			$result=$this->Common_model->AddUpdateData('cms_pages',$update_data);
			unlinkImage('vendor',$image);
			if($result){
				$response['message']="Page Banner Image deleted successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>2,
					'reference_id'=>$id,
					'action'=>'Deleted',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
				$response['status']=true;
			}else{
				$response=array('status'=>false,'message'=>"There is an error!");
			}
			echo json_encode($response);
		}
	}
	


	public function changeStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			$update_data=array('id'=>$id,'status'=>$status);
			$response['status']=$this->Common_model->changeDataStatus('cms_pages',$update_data);
			if($response['status']){
				$response['message']="CMS Page Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>2,
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

 
	function deletePage(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$page_data=array('id'=>$id);
			$page_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('cms_pages',$page_data);
			if($response['status']){
				$response['message']="CMS Page Deleted Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>2,
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

	function websiteSettings(){
		$data['setting']=$this->db->get('website_settings')->row_array();
		$this->load->view('admin/website-settings',$data);

	}
	
	public function updateWebsiteSettings(){
		$this->isAjaxRequest();
		$response['status']=TRUE;
		$name_error='';
		$website_logo_error='';
 		$login_registration_banner_error='';
		$this->form_validation->set_rules('phone_no', 'Phone No', 'trim|required');
		$this->form_validation->set_rules('mobile_no', 'Mobile No.', 'trim|required');
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required');
		$this->form_validation->set_rules('contact_info', 'Contact Information', 'trim|required');
		$this->form_validation->set_rules('working_hours', 'Working Hours', 'trim|required');
			

		$old_website_logo=$this->input->post('old_website_logo');
		$old_login_registration_banner=$this->input->post('old_login_registration_banner');

 		if($this->form_validation->run() == TRUE && $response['status']==TRUE){
	
		   if(!empty($_FILES['website_logo']['name'])){
	 
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'website_logo';
				$file_response=uploadImage('pages',$allowed_types,$input_name,$old_website_logo);
				 if($file_response['status']){
					$website_logo=$file_response['name'];
				}else{
					$response['status']=false;
					$website_logo_error=$file_response['message'];
				}

		}else{
			$website_logo=$old_website_logo;	
		}
	   } 


	   if($this->form_validation->run() == TRUE && $response['status']==TRUE){
	
		   if(!empty($_FILES['login_registration_banner']['name'])){
	 
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'login_registration_banner';
				$file_response=uploadImage('pages',$allowed_types,$input_name,$old_login_registration_banner);
				 if($file_response['status']){
					$login_registration_banner=$file_response['name'];
				}else{
					$response['status']=false;
					$login_registration_banner_error=$file_response['message'];
				}

		}else{
			$login_registration_banner=$old_login_registration_banner;
		}
	   } 


		if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
			$response=$this->form_validation->error_array();
			$response['status']=false;
			 
			if(!empty($website_logo_error)){
				$response['website_logo']=$website_logo_error;
			}
 			if(!empty($login_registration_banner_error)){
				$response['login_registration_banner']=$login_registration_banner_error;
			}
			$response['message']='There is error in submitting form!';
		}else{
			$save_data=array(
				'id'=>1,
				'phone_no'=>$this->input->post('phone_no'),
				'mobile_no'=>$this->input->post('mobile_no'),
				'email_address'=>$this->input->post('email_address'),
				'contact_info'=>$this->input->post('contact_info'),
 				'working_hours'=>$this->input->post('working_hours'),
 				'total_record_per_page'=>$this->input->post('total_record_per_page'),
 			);
			if(!empty($website_logo)){
				$save_data['logo']=$website_logo;
			}
			if(!empty($login_registration_banner)){
				$save_data['login_registration_banner']=$login_registration_banner;
			}
			$setting_id=$this->Common_model->AddUpdateData('website_settings',$save_data);
 			$message = "Website Setting Updated Successfully!";
			$this->session->set_flashdata('success_message',$message);

			$logdata=array(
				'activity_in'=>1,
				'category'=>16,
				'reference_id'=>$setting_id,
				'action'=>'Updated',
				'message'=>$message,
				'modified_data'=>json_encode($this->input->post()),
				'done_by'=>$this->session->userdata('admin_data')['id']
			);
			activityLog($logdata);
			$response['message']=$message;
		}
		echo json_encode($response);
	}

	
	public function removeWebsiteLogo(){
		$this->isAjaxRequest();
		$id=1;
		$image=$this->input->post('old_website_logo');
		if(!empty($id) && !empty($image)){
			$update_data=array(
				'logo'=>'',
				'id'=>$id
			);
 			$result=$this->Common_model->AddUpdateData('website_settings',$update_data);
			unlinkImage('pages',$image);
			if($result){
				$response['message']="Website Logo deleted successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>16,
					'reference_id'=>$id,
					'action'=>'Deleted',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
				$response['status']=true;
				$this->session->set_flashdata('success_message',$response['message']);
			}else{
				$response=array('status'=>false,'message'=>"There is an error!");
			}
			echo json_encode($response);
		}
	}

	public function removeLoginRegistrationBanner(){
		$this->isAjaxRequest();
		$id=1;
		$image=$this->input->post('old_login_registration_banner');
		if(!empty($id) && !empty($image)){
			$update_data=array(
				'login_registration_banner'=>'',
				'id'=>$id
			);
 			$result=$this->Common_model->AddUpdateData('website_settings',$update_data);
			unlinkImage('pages',$image);
			if($result){
				$response['message']="Login Registration Banner deleted successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>16,
					'reference_id'=>$id,
					'action'=>'Deleted',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
				$response['status']=true;
				$this->session->set_flashdata('success_message',$response['message']);
			}else{
				$response=array('status'=>false,'message'=>"There is an error!");
			}
			echo json_encode($response);
		}
	}
	function manageEmailTemplates(){
		if(isset($_POST['export']))
		{
			$this->exportEmailtemplates();
		}
		$this->load->view('admin/email-template/manage-email-templates');
   }

   	public function exportEmailtemplates()
   	{

   	   $templates = $this->Page_model->manageEmailTemplatesExport($_POST,false);
   		$filename = 'template_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
        $file = fopen('php://output', 'w');

        $header = array(
            "Name",
            "Subject",
            "Welcome Heading",
            "Welcome Message",
            "Welcome Description",
          
             ); 
        fputcsv($file, $header);
        foreach ($templates as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
   	}



   public function manageEmailTemplatesAjax(){
	   $this->isAjaxRequest();
	   $response['data']=$this->Page_model->manageEmailTemplatesAjax($_POST,false);
	   $response['total']=$this->Page_model->manageEmailTemplatesAjax($_POST,true);
	   $this->getJson($response);
   }
   public function addUpdateEmailTemplate(){
	   $data=array();
		 $id=$this->uri->segment(2);
	   if($id>0){
		   $select=array('id'=>$id);
		   $email_templatedata=getSingleTableData('email_templates',$select);
			 if(count($email_templatedata)>0){
				$data['email_template']=$email_templatedata[0];
			}
			else
			{
				redirect('admin-dashboard');
			}
		   $data['heading']="Update Email Template";
		   $data['button']="Update";
	   }else{
		   $data['email_template']['id']='';
		   $data['email_template']['name']='';
 		   $data['email_template']['subject']=''; 
		   $data['email_template']['welcome_heading']='';
		   $data['email_template']['welcome_message']='';
		   $data['email_template']['message_description']='';
 		   $data['email_template']['banner_image']='';
 		   $data['heading']="Add Email Template";
		   $data['button']="Add";
		}
		$this->load->view('admin/email-template/add-update-email-template',$data); 
   }

   public function saveEmailTemplate(){
	   $this->isAjaxRequest();
	   $response['status']=true;
	   $name_error='';
	   $banner_image_error='';
	   $name=$this->input->post('name');
	   $old_banner_image=$this->input->post('old_image');
	   $this->form_validation->set_rules('name', 'Name', 'trim|required');
	   $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
	   $this->form_validation->set_rules('welcome_heading', 'Welcome Heading', 'trim|required');
	   $this->form_validation->set_rules('welcome_message', 'Welcome Message', 'trim|required');
	   $this->form_validation->set_rules('message_description', 'Welcome Description', 'trim|required');
	   if(empty($old_banner_image) && empty($_FILES['banner_image']['name'])){
			$this->form_validation->set_rules('banner_image', 'Banner Image', 'required');
		}

	   
		
	   $id=$this->input->post('id') ? $this->input->post('id'):0;
	   if(!empty($name)){
		   $where=array('name'=>$name);
		   if($id>0){
			   $where['id <>']=$id;
		   }
		   $response['status']=$this->Common_model->checkExist('email_templates',$where);
		   if(!$response['status']){
			   $name_error="Name already  exists";
		   }
	   }

	   if($this->form_validation->run() == TRUE && $response['status']==TRUE){
		   if(!empty($_FILES['banner_image']['name'])){
			  $allowed_types = 'png|jpg|jpeg|gif';
			  $input_name = 'banner_image';
			  $file_response=uploadImage('email-templates',$allowed_types,$input_name,$old_banner_image);
			   if($file_response['status']){
				  $banner_image=$file_response['name'];
			  }else{
				  $response['status']=false;
				  $banner_image_error=$file_response['message'];
			  }
		  }else{
			  $banner_image=$old_banner_image;
		  }
	  } 

	   if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
		   $response=$this->form_validation->error_array();
		   $response['status']=false;
		   if(!empty($name_error)){
			   $response['name']=$name_error;
		   }
	

		   if(!empty($banner_image_error)){
			   $response['banner_image']=$banner_image_error;
		   }
		   $response['message']='There is error in submitting form!';
	   }else{
		   $save_data=array(
			   'id'=>$this->input->post('id')? $this->input->post('id'):0,
			   'name'=>$this->input->post('name'),
			   'subject'=>$this->input->post('subject'),
			   'welcome_heading'=>$this->input->post('welcome_heading'),
			   'welcome_message'=>$this->input->post('welcome_message'),
			   'message_description'=>$this->input->post('message_description'),
			);
			
		   if(!empty($banner_image)){
			   $save_data['banner_image']=$banner_image;
		   }

		   $template_id=$this->Common_model->AddUpdateData('email_templates',$save_data);

		   if($save_data['id']>0){
			   $id=$save_data['id'];
			   $action="Updated";
		   }else{
			   $id=$template_id;
			   $action="Added";
		   }
		   $message = "Email Template ".$action." Successfully!";
		   $this->session->set_flashdata('success_message',$message);
		   $slug=makeSlug($save_data['name'].'-'.$id);
		   $update_data=array('id'=>$id,'slug'=>$slug);
		   $this->Common_model->AddUpdateData('email_templates',$update_data);
		   $logdata=array(
			   'activity_in'=>1,
			   'category'=>18,
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

   public function deleteEmailTemplateBannerImage(){
	$this->isAjaxRequest();
	$id=$this->input->post('id');
	$image=$this->input->post('image');
	if(!empty($id) && !empty($image)){
		$update_data=array(
			'banner_image'=>'',
			'id'=>$id
		);
		 $result=$this->Common_model->AddUpdateData('email_templates',$update_data);
		unlinkImage('email-templates',$image);
		if($result){
			$response['message']="Page Banner Image deleted successfully!";
			$logdata=array(
				'activity_in'=>1,
				'category'=>18,
				'reference_id'=>$id,
				'action'=>'Deleted',
				'message'=>$response['message'],
				'modified_data'=>json_encode($this->input->post()),
				'done_by'=>$this->session->userdata('admin_data')['id']
			);
			activityLog($logdata);
			$response['status']=true;
		}else{
			$response=array('status'=>false,'message'=>"There is an error!");
		}
		echo json_encode($response);
	}
}




	public function viewEmailTemplate(){
		$id=$this->uri->segment(2);
		if($id>0){
			$select=array('id'=>$id);
			$email_templatedata=getSingleTableData('email_templates',$select);
			 if(count($email_templatedata)>0){
				$data['email_template']=$email_templatedata[0];
			}
			else
			{
				redirect('admin-dashboard');
			}

 			$this->load->view('admin/email-template/view-email-template',$data);
		}
	}



	function manageCalculations(){
		if(isset($_POST['export']))
		{
			$this->manageCalculationsexport();
		}
	
		$this->load->view('admin/calculations/manage-calculations');
   }

   public function manageCalculationsexport()
   {
   	$calculations= $this->Page_model->manageCalculationExport($_POST , false);
   	$filename = 'calculaqtion_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
      
        // file creation 
        $file = fopen('php://output', 'w');

        $header = array(
            "Title",
            "Value",
            "Status",
            "Added_date",
               ); 
        fputcsv($file, $header);
        foreach ($calculations as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 

   }

   public function manageCalculationAjax(){

	$this->isAjaxRequest();
	$data=$this->Page_model->manageCalculationAjax($_POST,false);
	$response['data']=array();
	if(count($data)){
		foreach($data as $row){
			if(is_file('./attachments/calculations/thumb/'.$row['image'])){
				$image=base_url('attachments/calculations/thumb/'.$row['image']);	
		   }else{
			   $image='';
		   }
			$response['data'][]=array(
				'id'=>$row['id'],
				'image'=>$image,
				'title'=>$row['title'],
				'value'=>$row['value'],
				'sort_id'=>$row['sort_id'],
				'status'=>$row['status'],
			 );
		}
	}
	$response['total']=$this->Page_model->manageCalculationAjax($_POST,true);
	$this->getJson($response);
   }
   public function addUpdateCalculation(){
 		$id=$this->uri->segment(2);
	   if($id>0){
		   $select=array('id'=>$id);
		   $calculationData=getSingleTableData('calculations',$select,array('key'=>'title','value'=>'ASC'));
		   if(count($calculationData)){
			$data['calculation']=$calculationData[0];
		   }else{
			   redirect(base_url('admin-manage-calculations'));
		   }
		   $data['heading']="Update Calculation";
		   $data['button']="Update";
	   }else{
		   $data['calculation']['id']='';
		   $data['calculation']['title']='';
 		   $data['calculation']['value']=''; 
			$data['calculation']['image']='';
		   $data['calculation']['sort_id']='';
		   $data['calculation']['status']='1';
  		   $data['heading']="Add Email Calculation";
		   $data['button']="Add";
		}
		$this->load->view('admin/calculations/add-update-calculation',$data); 
   }

   public function saveCalculation(){
	   $this->isAjaxRequest();
	   $response['status']=true;
	   $title_error='';
	   $image_error='';
	   $title=$this->input->post('title');
	   $old_image=$this->input->post('old_image');
	   $this->form_validation->set_rules('title', 'Title', 'trim|required');
	   $this->form_validation->set_rules('value', 'Value', 'trim|required');
 	   if(empty($old_image) && empty($_FILES['image']['name'])){
			$this->form_validation->set_rules('image', 'Image', 'required');
		}

	   $id=$this->input->post('id') ? $this->input->post('id'):0;
	   if(!empty($title)){
		   $where=array('title'=>$title);
		   if($id>0){
			   $where['id <>']=$id;
		   }
		   $response['status']=$this->Common_model->checkExist('calculations',$where);
		   if(!$response['status']){
			   $name_error="Title already  exists";
		   }
	   }

	   if($this->form_validation->run() == TRUE && $response['status']==TRUE){
		   if(!empty($_FILES['image']['name'])){
			  $allowed_types = 'png|jpg|jpeg|gif';
			  $input_name = 'image';
			  $file_response=uploadImage('calculations',$allowed_types,$input_name,$old_image);
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
		   if(!empty($name_error)){
			   $response['name']=$name_error;
		   }
	

		   if(!empty($image_error)){
			   $response['image']=$image_error;
		   }
		   $response['message']='There is error in submitting form!';
	   }else{
		   $save_data=array(
			   'id'=>$this->input->post('id')? $this->input->post('id'):0,
			   'title'=>$this->input->post('title'),
			   'value'=>$this->input->post('value'),
			   'sort_id'=>$this->input->post('sort_id'), 
			   'status'=>$this->input->post('status'),
 			);
			
		   if(!empty($image)){
			   $save_data['image']=$image;
		   }

		   $calculation_id=$this->Common_model->AddUpdateData('calculations',$save_data);

		   if($save_data['id']>0){
			   $id=$save_data['id'];
			   $action="Updated";
		   }else{
			   $id=$calculation_id;
			   $action="Added";
		   }
		   $message = "Email Template ".$action." Successfully!";
		   $this->session->set_flashdata('success_message',$message);
		   $slug=makeSlug($save_data['title'].'-'.$id);
		   $update_data=array('id'=>$id,'slug'=>$slug);
		   $this->Common_model->AddUpdateData('calculations',$update_data);
		   $logdata=array(
			   'activity_in'=>1,
			   'category'=>19,
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

   public function deleteCalculationImage(){
	$this->isAjaxRequest();
	$id=$this->input->post('id');
	$image=$this->input->post('image');
	if(!empty($id) && !empty($image)){
		$update_data=array(
			'image'=>'',
			'id'=>$id
		);
		$result=$this->Common_model->AddUpdateData('calculations',$update_data);
		unlinkImage('calculations',$image);
		if($result){
			$response['message']="Calculation Image deleted successfully!";
			$logdata=array(
				'activity_in'=>1,
				'category'=>19,
				'reference_id'=>$id,
				'action'=>'Deleted',
				'message'=>$response['message'],
				'modified_data'=>json_encode($this->input->post()),
				'done_by'=>$this->session->userdata('admin_data')['id']
			);
			activityLog($logdata);
			$response['status']=true;
		}else{
			$response=array('status'=>false,'message'=>"There is an error!");
		}
		echo json_encode($response);
	}
}
	public function viewCalculation(){
		$id=$this->uri->segment(2);
		if($id>0){
  		   $select=array('id'=>$id);
		   $calculationData=getSingleTableData('calculations',$select,array('key'=>'title','value'=>'ASC'));
		   if(count($calculationData)){
			$data['calculation']=$calculationData[0];
		   }else{
			   redirect(base_url('admin-manage-calculations'));
		   }
 			$this->load->view('admin/calculations/view-calculation',$data);
		}
	}


	public function changeCalculationStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			$update_data=array('id'=>$id,'status'=>$status);
			$response['status']=$this->Common_model->changeDataStatus('calculations',$update_data);
			if($response['status']){
				$response['message']="Calculation Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>19,
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
   

	function deleteCalculation(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$page_data=array('id'=>$id);
			$page_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('calculations',$page_data);
			if($response['status']){
				$response['message']="Calculations Deleted Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>19,
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

}
