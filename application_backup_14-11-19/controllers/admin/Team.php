<?php
class Team extends MY_Controller {

	public function index()
	{
		if(isset($_POST['export']))
		{
			$this->exportteam();
		}
  	 	$this->load->view('admin/team/manage-team');
	}

	public function exportteam()
	{
		$team = $this->Page_model->manageTeamsExport($_POST, false);
		$filename = 'student_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
       
        // get data 
        
     
        // file creation 
        $file = fopen('php://output', 'w');

        $header = array(
            "Name",
            "Designation",
            "Status",
            "Added_date",
            
              ); 
        fputcsv($file, $header);
        foreach ($team as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
	}

	public function teams()
	{
 	 	$this->load->view('admin/team/manage-team');
	}
	public function manageTeam(){
		$this->isAjaxRequest();
		$data=$this->Page_model->manageTeamsAjax($_POST,false);
		$response['data']=array();
		if(count($data)){
			foreach($data as $row){
				if(is_file('./attachments/teams/thumb/'.$row['image'])){
					$image=base_url('attachments/teams/thumb/'.$row['image']);	
			   }else{
				   $image='';
			   }
				$response['data'][]=array(
					'id'=>$row['id'],
					'image'=>$image,
					'name'=>$row['name'],
					'designation'=>$row['designation'],
 					'status'=>$row['status'],
 				);
			}
		}
		$response['total']=$this->Page_model->manageTeamsAjax($_POST,true);
		$this->getJson($response);
	}
	

 
function uploadTeamImage()
{
	$this->isAjaxRequest();
	$response=uploadCroperImage('teams',$this->session->userdata('admin_data')['id'],$this->input->post('image'));
	echo json_encode($response);
}
	 

	public function addUpdateTeam(){
		deleteTempFiles('./attachments/teams/'.$this->session->userdata('admin_data')['id'].'/*');
		$data=array();
	  	$id=$this->uri->segment(2);
		if($id>0){
			$select=array('id'=>$id);
			$teamdata=getSingleTableData('our_team',$select);
			 if(count($teamdata)>0){
				$data['team']=$teamdata[0];
			}
			else
			{
				redirect('admin-dashboard');
			}
			 $data['heading']="Update Team";
			 $data['button']="Update";
    	}else{
			$data['team']['id']='';
			$data['team']['name']='';
			$data['team']['designation']='';
			$data['team']['description']='';
			$data['team']['image']='';
			$data['team']['status']=1;
			$data['heading']="Add Team";
			$data['button']="Add";
			
 		}
 		$this->load->view('admin/team/add-update-team',$data); 
	}

 

	public function viewTeam(){
		$id=$this->uri->segment(2);
		if($id>0){
			$select=array('id'=>$id);
			$teamdata=getSingleTableData('our_team',$select);
			 if(count($teamdata)>0){
				$data['team']=$teamdata[0];
			}
			else
			{
				redirect('admin-dashboard');
			}
			$this->load->view('admin/team/view-team',$data);
     	}
	}

 


 	public function saveTeam(){
		$this->isAjaxRequest();
		$response['status']=true;
		$image_error='';
		$name_error='';
		$team_image=$this->input->post('team_image');
		$old_image=$this->input->post('old_image');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('designation', 'Designation', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
 		if(empty($_FILES['image']['name']) && empty($old_image) && empty($team_image)){
			$this->form_validation->set_rules('image', 'Image', 'required');
		}
		$name=$this->input->post('name');
		$id=$this->input->post('id') ? $this->input->post('id'):0;
		if(!empty($name)){
			$where=array('name'=>$name);
			if($id>0){
				$where['id <>']=$id;
			}
			$response['status']=$this->Common_model->checkExist('our_team',$where);
			if(!$response['status']){
				$name_error="Team name already  exists";
			}
		}
       
      /*  if($this->form_validation->run() == TRUE && $response['status']==TRUE){
  			if(!empty($_FILES['image']['name'])){
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'image';
				$file_response=uploadImage('teams',$allowed_types,$input_name,$old_image);
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
		*/
		
		if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
			$response=$this->form_validation->error_array();
			$response['status']=false;
			//if(!empty($image_error)){
			//	$response['image']=$image_error;
			//}
			if(!empty($name_error)){
				$response['name']=$name_error;
			}
			$response['message']='There is error in submitting form!';
		}else{
			$image=$this->input->post('team_image');
			$image_path['full_path']=$this->input->post('image_path');
			$image_path['file_name']=$image;
			$old_image=$this->input->post('old_image');
			if(!empty($image)){
				$image_sizes = array('thumb' => array(80, 80),'medium' => array(600, 450));
				$path='./attachments/teams/'; 
				resizeImage($path,$image_path,$old_image,$image_sizes);
				if(is_file($image_path['full_path'])){
					copy($image_path['full_path'],$path.'main/'.$image);
					unlink($image_path['full_path']);
				}
			}else{
				$image=$old_image;
			}

			$save_data=array(
				'id'=>$this->input->post('id')? $this->input->post('id'):0,
				'name'=>$this->input->post('name'),
				'designation'=>$this->input->post('designation'),
				'description'=>$this->input->post('description'),
				'status'=>$this->input->post('status'),
				'image'=>$image ? $image:'',
			);

			$slider_id=$this->Common_model->AddUpdateData('our_team',$save_data);
			
			if($save_data['id']>0){
				$id=$save_data['id'];
				$action="Updated";
			}else{
				$id=$slider_id;
				$action="Added";
			}
			$message = "Team ".$action." Successfully!";
			$this->session->set_flashdata('success_message',$message);
   			$logdata=array(
				'activity_in'=>1,
				'category'=>13,
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

 

	public function changeStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			$update_data=array('id'=>$id,'status'=>$status);
			$response['status']=$this->Common_model->changeDataStatus('our_team',$update_data);
			if($response['status']){
				$response['message']="Team Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>13,
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

	function deleteTeam(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$brand_data=array('id'=>$id);
			$brand_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('our_team',$brand_data);
			if($response['status']){
				$response['message']="Team Deleted Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>13,
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

 
	public function deleteTeamImage(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$image=$this->input->post('image');
		if(!empty($id) && !empty($image)){
			$update_data=array(
				'image'=>'',
				'id'=>$id
			);
 			$result=$this->Common_model->AddUpdateData('our_team',$update_data);
			unlinkImage('teams',$image);
			if($result){
				$response['message']="Our Team Image deleted successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>13,
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




	public function ourServices()
	{
		if(isset($_POST['export']))
		{
			$this->exportServices();
		}
  	 	$this->load->view('admin/our-services/manage-our-services');
	}

	public function exportServices()
	{
		$services=$this->Page_model->manageServicesExport($_POST,false);
		$filename = 'services_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
       
        // get data 
        
     
        // file creation 
        $file = fopen('php://output', 'w');

        $header = array(
            
            "Name",
            "Description",
            "Status",
            "Added_date",
            ); 
        fputcsv($file, $header);
        foreach ($services as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 

	}
 
	public function manageOurServicesAjax(){
		$this->isAjaxRequest();
		$data=$this->Page_model->manageOurServicesAjax($_POST,false);
		$response['data']=array();
		if(count($data)){
			foreach($data as $row){
				if(is_file('./attachments/our-services/thumb/'.$row['image'])){
					$image=base_url('attachments/our-services/thumb/'.$row['image']);	
			   }else{
				   $image='';
			   }
				$response['data'][]=array(
					'id'=>$row['id'],
					'image'=>$image,
					'description'=>$row['description'],
					'name'=>$row['name'],
  					'status'=>$row['status'],
 				);
			}
		}
		$response['total']=$this->Page_model->manageOurServicesAjax($_POST,true);
		$this->getJson($response);
	}
	

	function uploadOurServicesImage()
	{
		$this->isAjaxRequest();
		$image_parts = explode(";base64,", $this->input->post('image'));
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = 'jpeg';
		$filename=uniqid().'.' .$image_type;
		if(!file_exists('./attachments/our-services/'.$this->session->userdata('admin_data')['id'])){
			if(mkdir('./attachments/our-services/'.$this->session->userdata('admin_data')['id'], 777));
		}
		$filepath = './attachments/our-services/'.$this->session->userdata('admin_date')['id'].'/'.$filename;
		$blob= $image_parts[1];
		file_put_contents($filepath,  base64_decode( str_replace('data:image/jpeg;base64,', '', $blob)));
		$response=array('image_path'=>$filepath,'image_name'=>$filename,'image_id'=>time());
		echo json_encode($response);
	}
	 

	public function addUpdateOurServices(){
		deleteTempFiles('./attachments/our-services/'.$this->session->userdata('admin_data')['id'].'/*');
		$data=array();
	  	$id=$this->uri->segment(2);
		if($id>0){
			$select=array('id'=>$id);
			//$data['service']=$this->Page_model->ourServicesData($select);
			$servicedata=getSingleTableData('our_services',$select);
			 if(count($servicedata)>0){
				$data['service']=$servicedata[0];
			}
			else
			{
				redirect('admin-dashboard');
			}
			 $data['heading']="Update Our Service";
			 $data['button']="Update";
    	}else{
			$data['service']['id']='';
			$data['service']['name']='';
 			$data['service']['description']='';
			$data['service']['image']='';
			$data['service']['status']=1;
			$data['heading']="Add Our Service";
			$data['button']="Add";
			
 		}
 		$this->load->view('admin/our-services/add-update-our-services',$data); 
	}

 

	public function viewOurService(){
		$id=$this->uri->segment(2);
		if($id>0){
			$select=array('id'=>$id);
			$servicedata=getSingleTableData('our_services',$select);
			 if(count($servicedata)>0){
				$data['service']=$servicedata[0];
			}
			else
			{
				redirect('admin-dashboard');
			}
			$this->load->view('admin/our-services/view-our-services',$data);
     	}
	}

 


 	public function saveOurServices(){
		$this->isAjaxRequest();
		$response['status']=true;
		$image_error='';
		$name_error='';
		$old_image=$this->input->post('old_image');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
 		$this->form_validation->set_rules('description', 'Description', 'trim|required');
 		if(empty($old_image) && empty($_FILES['image']['name'])){
			$this->form_validation->set_rules('image', 'Image', 'required');

		}
		$name=$this->input->post('name');
		$id=$this->input->post('id') ? $this->input->post('id'):0;
		if(!empty($name)){
			$where=array('name'=>$name);
			if($id>0){
				$where['id <>']=$id;
			}
			$response['status']=$this->Common_model->checkExist('our_team',$where);
			if(!$response['status']){
				$name_error="Service name already  exists";
			}
		}
       
        if($this->form_validation->run() == TRUE && $response['status']==TRUE){
  			if(!empty($_FILES['image']['name'])){
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'image';
				$file_response=uploadImage('our-services',$allowed_types,$input_name,$old_image);
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
        /*
		if($this->form_validation->run() == TRUE && $response['status']==TRUE){ 
			$slider_image=$this->input->post('slider_image');
			$image_path['full_path']=$this->input->post('image_path');
			$image_path['file_name']=$slider_image;
			$old_image=$this->input->post('old_image');
			if(!empty($slider_image)){
				$image_sizes = array('thumb' => array(80, 80),'medium' => array(600, 450));
				$path='./attachments/sliders/'; 
				resizeImage($path,$image_path,$old_image,$image_sizes);
				if(is_file($image_path['full_path'])){
					copy($image_path['full_path'],$path.'main/'.$slider_image);
					unlink($image_path['full_path']);
				}
			}else{
				$slider_image=$old_image;
			}

		}

 */
 
		if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
			$response=$this->form_validation->error_array();
			$response['status']=false;
			if(!empty($image_error)){
				$response['image']=$image_error;
			}
			if(!empty($name_error)){
				$response['name']=$name_error;
			}
			$response['message']='There is error in submitting form!';
		}else{
			$save_data=array(
				'id'=>$this->input->post('id')? $this->input->post('id'):0,
				'name'=>$this->input->post('name'),
 				'description'=>$this->input->post('description'),
				'status'=>$this->input->post('status'),
				'image'=>$image ? $image:'',
			);

			$slider_id=$this->Common_model->AddUpdateData('our_services',$save_data);
			
			if($save_data['id']>0){
				$id=$save_data['id'];
				$action="Updated";
			}else{
				$id=$slider_id;
				$action="Added";
			}
			$message = "Our Service ".$action." Successfully!";
			$this->session->set_flashdata('success_message',$message);
   			$logdata=array(
				'activity_in'=>1,
				'category'=>14,
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

 

	public function changeOurServiceStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			$update_data=array('id'=>$id,'status'=>$status);
			$response['status']=$this->Common_model->changeDataStatus('our_services',$update_data);
			if($response['status']){
				$response['message']="Our Service Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>14,
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

	function deleteOurService(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$brand_data=array('id'=>$id);
			$brand_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('our_services',$brand_data);
			if($response['status']){
				$response['message']="Team Deleted Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>14,
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

 
	public function deleteOurServiceImage(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$image=$this->input->post('image');
		if(!empty($id) && !empty($image)){
			$update_data=array(
				'image'=>'',
				'id'=>$id
			);
 			$result=$this->Common_model->AddUpdateData('our_services',$update_data);
			unlinkImage('our-services',$image);
			if($result){
				$response['message']="Our Service Image deleted successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>13,
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



// Work Process



public function workProcess()
{
	if(isset($_POST['export'])){
		$this->exportWorkProcess();
	}
	$this->load->view('admin/work-process/manage-work-process');
}

		public function exportWorkProcess(){ 
		// print_r($_POST); die;
        // file name 
        $workprocess = $this->Page_model->manageWorkProcessExport($_POST,false);
      
        $filename = 'workprocess_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
       
        // get data 
        
     
        // file creation 
        $file = fopen('php://output', 'w');

        $header = array(
            "Name",
            "Description",
            "Status",
            "Added-Date",
            

              ); 
        fputcsv($file, $header);
        foreach ($workprocess as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
       }


	public function manageWorkProcess(){
	$this->isAjaxRequest();
	$data=$this->Page_model->manageWorkProcessAjax($_POST,false);
	$response['data']=array();
	if(count($data)){
		foreach($data as $row){
			if(is_file('./attachments/work-process/thumb/'.$row['image'])){
				$image=base_url('attachments/work-process/thumb/'.$row['image']);	
		   }else{
			   $image='';
		   }
			$response['data'][]=array(
				'id'=>$row['id'],
				'image'=>$image,
				'name'=>$row['name'],
				'sort_id'=>$row['sort_id'],
				'status'=>$row['status'],
			 );
		}
	}
	$response['total']=$this->Page_model->manageWorkProcessAjax($_POST,true);
	$this->getJson($response);
}
 
 

public function addUpdateWorkProcess(){
 	$data=array();
	  $id=$this->uri->segment(2);
	if($id>0){
		$select=array('id'=>$id);
		//$data['work_process']=$this->Page_model->workProcessData($select);
		$work_processdata=getSingleTableData('work_process',$select);
			 if(count($work_processdata)>0){
				$data['work_process']=$work_processdata[0];
			}
			else
			{
				redirect('admin-dashboard');
			}

 		 $data['heading']="Update Work Process";
		 $data['button']="Update";
	}else{
		$data['work_process']['id']='';
		$data['work_process']['name']='';
 		$data['work_process']['image']='';
		 $data['work_process']['sort_id']='';
 		 $data['work_process']['status']=1;
		$data['heading']="Add Work Process";
		$data['button']="Add";
		
	 }
	 $this->load->view('admin/work-process/add-update-work-process',$data); 
}



public function viewWorkProcess(){
	$id=$this->uri->segment(2);
	if($id>0){
		$select=array('id'=>$id);
		//$data['work_process']=$this->Page_model->workProcessData($select);
		$work_processdata=getSingleTableData('work_process',$select);
			 if(count($work_processdata)>0){
				$data['work_process']=$work_processdata[0];
			}
			else
			{
				redirect('admin-dashboard');
			}
 		$this->load->view('admin/work-process/view-work-process',$data);
	 }
}




 public function saveWorkProcess(){
	$this->isAjaxRequest();
	$response['status']=true;
	$image_error='';
	$name_error='';
	$old_image=$this->input->post('old_image');
	$this->form_validation->set_rules('name', 'Name', 'trim|required');
	$this->form_validation->set_rules('sort_id', 'Sort Id', 'trim|required');
 	if(empty($old_image) && empty($_FILES['image']['name'])){
		$this->form_validation->set_rules('image', 'Image', 'required');

	}
	$name=$this->input->post('name');
	$id=$this->input->post('id') ? $this->input->post('id'):0;
	if(!empty($name)){
		$where=array('name'=>$name);
		if($id>0){
			$where['id <>']=$id;
		}
		$response['status']=$this->Common_model->checkExist('work_process',$where);
		if(!$response['status']){
			$name_error="Process Name already  exists";
		}
	}
   
	if($this->form_validation->run() == TRUE && $response['status']==TRUE){
		  if(!empty($_FILES['image']['name'])){
			$allowed_types = 'png|jpg|jpeg|gif';
			$input_name = 'image';
			$file_response=uploadImage('work-process',$allowed_types,$input_name,$old_image);
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
			$response['image']=$image_error;
		}
		if(!empty($name_error)){
			$response['name']=$name_error;
		}
		$response['message']='There is error in submitting form!';
	}else{
		$save_data=array(
			'id'=>$this->input->post('id')? $this->input->post('id'):0,
			'name'=>$this->input->post('name'),
			'status'=>$this->input->post('status'),
			'sort_id'=>$this->input->post('sort_id'),
 			'image'=>$image ? $image:'',
		);

		$id=$this->Common_model->AddUpdateData('work_process',$save_data);
		
		if($save_data['id']>0){
			$id=$save_data['id'];
			$action="Updated";
		}else{
 			$action="Added";
		}
		$message = "Work Process ".$action." Successfully!";
		$this->session->set_flashdata('success_message',$message);
		   $logdata=array(
			'activity_in'=>1,
			'category'=>15,
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



public function changeWorkProcessStatus(){
	$this->isAjaxRequest();
	$id=$this->input->post('id');
	$status=$this->input->post('status');
	if($id>0){
		$update_data=array('id'=>$id,'status'=>$status);
		$response['status']=$this->Common_model->changeDataStatus('work_process',$update_data);
		if($response['status']){
			$response['message']="Work Process Status Updated Successfully!";
			$logdata=array(
				'activity_in'=>1,
				'category'=>15,
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

function deleteWorkProcess(){
	$this->isAjaxRequest();
	$id=$this->input->post('action_id');
	if(!empty($id)){
		$brand_data=array('id'=>$id);
		$brand_data['is_deleted']=1;
		$response['status']=$this->Common_model->AddUpdateData('work_process',$brand_data);
		if($response['status']){
			$response['message']="Work Process Deleted Successfully!";
			$logdata=array(
				'activity_in'=>1,
				'category'=>15,
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


public function deleteWorkProcessImage(){
	$this->isAjaxRequest();
	$id=$this->input->post('id');
	$image=$this->input->post('image');
	if(!empty($id) && !empty($image)){
		$update_data=array(
			'image'=>'',
			'id'=>$id
		);
		 $result=$this->Common_model->AddUpdateData('work_process',$update_data);
		unlinkImage('our-services',$image);
		if($result){
			$response['message']="Work Process Image deleted successfully!";
			$logdata=array(
				'activity_in'=>1,
				'category'=>15,
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






public function facilities()
{
	if(isset($_POST['export']))
	{
		$this->exportFacilites();
	}
	$this->load->view('admin/facilities/manage-facilities');
}

	public function exportFacilites()
	{
		$facilities = $this->Page_model->manageFacilitiesExport($_POST,false);
		$filename = 'facilites_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
       
        // get data 
        
     
        // file creation 
        $file = fopen('php://output', 'w');

        $header = array(
            "Name",
            "Description",
            "Status",
            "Added_date",
              ); 
        fputcsv($file, $header);
        foreach ($facilities as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
	}

public function manageFacilitiesAjax(){
	$this->isAjaxRequest();
	$data=$this->Page_model->manageFacilitiesAjax($_POST,false);
	$response['data']=array();
	if(count($data)){
		foreach($data as $row){
			if(is_file('./attachments/facilities/thumb/'.$row['image'])){
				$image=base_url('attachments/facilities/thumb/'.$row['image']);	
		   }else{
			   $image='';
		   }
			$response['data'][]=array(
				'id'=>$row['id'],
				'image'=>$image,
				'name'=>$row['name'],
				'sort_id'=>$row['sort_id'],
				'status'=>$row['status'],
			 );
		}
	}
	$response['total']=$this->Page_model->manageFacilitiesAjax($_POST,true);
	$this->getJson($response);
}
 
 

public function addUpdateFacility(){
 	$data=array();
	  $id=$this->uri->segment(2);
	if($id>0){
		$select=array('id'=>$id);
		// $data['facility']=$this->Page_model->facilityData($select);
		$facilitydata=getSingleTableData('facilities',$select);
			 if(count($facilitydata)>0){
				$data['facility']=$facilitydata[0];
			}
			else
			{
				redirect('admin-dashboard');
			}
 		$data['heading']="Update Facility";
		$data['button']="Update";
	}else{
		$data['facility']['id']='';
		$data['facility']['name']='';
 		$data['facility']['image']='';
		$data['facility']['sort_id']='';
 		$data['facility']['status']=1;
		$data['heading']="Add Facility";
		$data['button']="Add";
		
	 }
	 $this->load->view('admin/facilities/add-update-facility',$data); 
}



public function viewFacility(){
	$id=$this->uri->segment(2);
	if($id>0){
		$select=array('id'=>$id);
		//$data['facility']=$this->Page_model->facilityData($select);
		$facilitydata=getSingleTableData('facilities',$select);
			 if(count($facilitydata)>0){
				$data['facility']=$facilitydata[0];
			}
			else
			{
				redirect('admin-dashboard');
			}
 		$this->load->view('admin/facilities/view-facility',$data);
	 }
}




 public function saveFacility(){
	$this->isAjaxRequest();
	$response['status']=true;
	$image_error='';
	$name_error='';
	$old_image=$this->input->post('old_image');
	$this->form_validation->set_rules('name', 'Name', 'trim|required');
	$this->form_validation->set_rules('sort_id', 'Sort Id', 'trim|required');
	
 	if(empty($old_image) && empty($_FILES['image']['name'])){
		$this->form_validation->set_rules('image', 'Image', 'required');
	}
	$name=$this->input->post('name');
	$id=$this->input->post('id') ? $this->input->post('id'):0;
	if(!empty($name)){
		$where=array('name'=>$name);
		if($id>0){
			$where['id <>']=$id;
		}
		$response['status']=$this->Common_model->checkExist('facilities',$where);
		if(!$response['status']){
			$name_error="Facilities Name already  exists";
		}
	}
   
	if($this->form_validation->run() == TRUE && $response['status']==TRUE){
		  if(!empty($_FILES['image']['name'])){
			$allowed_types = 'png|jpg|jpeg|gif';
			$input_name = 'image';
			$file_response=uploadImage('facilities',$allowed_types,$input_name,$old_image);
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
			$response['image']=$image_error;
		}
		if(!empty($name_error)){
			$response['name']=$name_error;
		}
		$response['message']='There is error in submitting form!';
	}else{
		$save_data=array(
			'id'=>$this->input->post('id')? $this->input->post('id'):0,
			'name'=>$this->input->post('name'),
			'status'=>$this->input->post('status'),
			'sort_id'=>$this->input->post('sort_id'),
 			'image'=>$image ? $image:'',
		);

		$id=$this->Common_model->AddUpdateData('facilities',$save_data);
		
		if($save_data['id']>0){
			$id=$save_data['id'];
			$action="Updated";
		}else{
 			$action="Added";
		}
		$message = "Facilities ".$action." Successfully!";
		$this->session->set_flashdata('success_message',$message);
		   $logdata=array(
			'activity_in'=>1,
			'category'=>17,
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



public function changeFacilityStatus(){
	$this->isAjaxRequest();
	$id=$this->input->post('id');
	$status=$this->input->post('status');
	if($id>0){
		$update_data=array('id'=>$id,'status'=>$status);
		$response['status']=$this->Common_model->changeDataStatus('facilities',$update_data);
		if($response['status']){
			$response['message']="Facility Status Updated Successfully!";
			$logdata=array(
				'activity_in'=>1,
				'category'=>17,
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

function deleteFacility(){
	$this->isAjaxRequest();
	$id=$this->input->post('action_id');
	if(!empty($id)){
		$brand_data=array('id'=>$id);
		$brand_data['is_deleted']=1;
		$response['status']=$this->Common_model->AddUpdateData('facilities',$brand_data);
		if($response['status']){
			$response['message']="Work Process Deleted Successfully!";
			$logdata=array(
				'activity_in'=>1,
				'category'=>15,
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


public function deleteFacilityImage(){
	$this->isAjaxRequest();
	$id=$this->input->post('id');
	$image=$this->input->post('image');
	if(!empty($id) && !empty($image)){
		$update_data=array(
			'image'=>'',
			'id'=>$id
		);
		 $result=$this->Common_model->AddUpdateData('facilities',$update_data);
		unlinkImage('our-services',$image);
		if($result){
			$response['message']="Facility Image deleted successfully!";
			$logdata=array(
				'activity_in'=>1,
				'category'=>17,
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


}