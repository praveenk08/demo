<?php
class Student extends MY_Controller
{
		public function __construct()
	{
			parent::__construct();
			$this->load->model('admin/Student_model');

	}
	public function managestudent()

	{
		if(isset($_POST['export'])){
			$this->exportstudents();
		}
		
		$this->load->view('admin/student/manage-student');
	}	

	public function exportstudents(){ 
		// print_r($_POST); die;
        // file name 
        $student = $this->Student_model->managestudentExport($_POST,false);
      
        $filename = 'student_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
       
        // get data 
        
     
        // file creation 
        $file = fopen('php://output', 'w');

        $header = array(
            "Id",
            "Name",
            "Gender",
            "Registration",
            "Roll No",
            "Language",
            "Class",
            "image",
            "Phone",
            "Email",
            "Address",
            "Status",
            "Is_deleted",

              ); 
        fputcsv($file, $header);
        foreach ($student as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
       }

	public function managestudentajax()
	{
		$this->isAjaxRequest();
		$data=$this->Student_model->managestudentajax($_POST,false);
		$response['data']=array();
		if(count($data)){

			foreach($data as $row){
				if(is_file('./attachments/student/thumb/'.$row['image'])){
					$image=base_url('attachments/student/thumb/'.$row['image']);	
			   }else{
				   $image='';
			   }

				$response['data'][]=array(
				'id'=>$row['id'],
				'registrationno'=>$row['registrationno'],
				'name'=>$row['name'],
				'class'=>$row['class'],
				'rollno'=>$row['rollno'],
				'image'=>$image,
				'email'=>$row['email'],
				'language_known'=> $row['language_known'],
				'gender'=>$row['gender'],
				'phone'=>$row['phone'],
				'address'=>$row['address'],
				'status'=>$row['status'],
				);
		      }
		   		}

		$response['total']=$this->Student_model->managestudentajax($_POST,true);
		$this->getJson($response);
		}
	
		public function AddUpdateStudent(){
			$id=$this->uri->segment(2);
	  		 if($id>0){
		   		$select=array('id'=>$id);
		   		$studentData=getSingleTableData('student',$select,array('key'=>'registrationno','value'=>'ASC'));
		   		if(count($studentData)){
					$data['student']=$studentData[0];
					
			   }else{
				   redirect(base_url('admin-manage-student'));
		   }
		   			$data['heading']="Update student detail";
		   			$data['button']="Update";
	   		}else{
					$data['student']['id']='';
					$data['student']['registrationno']='';
					$data['student']['name']=''; 
					$data['student']['class']='';
					$data['student']['rollno']='';
					$data['student']['email']='';
					$data['student']['phone']='';
					$data['student']['language_known']='';
					$data['student']['image']='';
					$data['student']['gender']='1';
					$data['student']['country']='1';
					$data['student']['address']='';
					$data['student']['status']='1';
					$data['heading']="Add Student details";
					$data['button']="Add";

		}

		$this->load->view('admin/student/add-update-student',$data); 
		}
			
		public function saveStudent(){
			$this->isAjaxRequest();
			$response['status']=true;
			$registrationno_error='';
			$email_error="";
			$image_error='';
			$old_image=$this->input->post('old_image');
			$registrationno=$this->input->post('registrationno');
				$this->form_validation->set_rules('registrationno', 'Registrationno', 'trim|required|numeric');
				$this->form_validation->set_rules('name', 'Name', 'trim|required');
				$this->form_validation->set_rules('class', 'Class', 'trim|required');
				$this->form_validation->set_rules('rollno', 'Roll no', 'trim|required|numeric|max_length[8]');
				$this->form_validation->set_rules('rollno', 'Roll no', 'trim|required|numeric|max_length[8]');
				$this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[10]|max_length[12]|numeric');
				$this->form_validation->set_rules('address', 'Address', 'trim|required|alpha_numeric_spaces');
			if(empty($old_image) && empty($_FILES['image']['name'])){
				$this->form_validation->set_rules('image', 'Student Image', 'required');

			}

		$gender=$this->input->post('gender');		
		$id=$this->input->post('id') ? $this->input->post('id'):0;
		$where=array('registrationno'=>$registrationno);
		if($id>0){
			$where['id <>']=$id;
		}
		if(!$this->Common_model->checkExist('student',$where)){
			$registrationno_error="registration no  already  exists";
		}
		$where=array('email'=>$this->input->post('email'));
		if($id>0){
			$where['id <>']=$id;
		}
 		if(!$this->Common_model->checkExist('student',$where)){
 			$email_error="email id already  exists";
		}
	   		  if($this->form_validation->run() == TRUE && $response['status']==TRUE){
  			if(!empty($_FILES['image']['name'])){
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'image';
				$file_response=uploadImage('student',$allowed_types,$input_name,$old_image);
				if($file_response['status']){
					$student_image=$file_response['name'];
				}else{
					$response['status']=false;
					$image_error=$file_response['message'];
				}
			}else{
				$student_image=$old_image;
			}
		}

		if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
			$response=$this->form_validation->error_array();
			$response['status']=false;
			if(!empty($registrationno_error)){
				$response['name']=$registrationno_error;
			}
			if(!empty($email_error)){
				$response['email']=$email_errorr;
			}
			if(!empty($image_error)){
				$response['image']=$image_error;
			}
			$response['message']='There is error in submitting form!';
		}
	   	else{
			$save_data=array(
			'id'=>$this->input->post('id')? $this->input->post('id'):0,
			'registrationno'=>$this->input->post('registrationno'),
			'name'=>$this->input->post('name'),
			'class'=>$this->input->post('class'),
			'gender'=>$this->input->post('gender'),
			'rollno'=>$this->input->post('rollno'),
			'email'=>$this->input->post('email'), 
			'language_known'=>$this->input->post('language_known')?implode(",",$this->input->post('language_known')):" ",
			'phone'=>$this->input->post('phone'),
			'address'=>$this->input->post('address'),
			'status'=>$this->input->post('status'),
			
			'image'=>$student_image ? $student_image:'',
			);
			$student_id=$this->Common_model->AddUpdateData('student',$save_data);
			
			if($save_data['id']>0){
				$id=$save_data['id'];
				$action="Updated";
			}
			else{

				$id=$student_id;
				$action="Added";
			}
			$message = "Student details ".$action." Successfully!";
			$this->session->set_flashdata('success_message',$message);
			$slug=makeSlug($save_data['name'].'-'.$id);
			$update_data=array('id'=>$id,'slug'=>$slug);
			//$this->Common_model->AddUpdateData('student',$update_data);
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

	public function viewStudent(){
			$id=$this->uri->segment(2);
			  if($id>0){
					$select=array('id'=>$id);
					$studentData=getSingleTableData('student',$select,array('key'=>'registrationno','value'=>'ASC'));
				if(count($studentData)){
					$data['student']=$studentData[0];
					}else{
					redirect(base_url('admin-manage-student'));
				}
			$this->load->view('admin/student/view-student',$data);
			}
			}

			public function changeStudentStatus(){
				$this->isAjaxRequest();
				$id=$this->input->post('id');
				$status=$this->input->post('status');
						if($id>0){
				$update_data=array('id'=>$id,'status'=>$status);
				$response['status']=$this->Common_model->changeDataStatus('student',$update_data);
				if($response['status']){
					$response['message']="students Status Updated Successfully!";
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

		function deletestudent(){
			$this->isAjaxRequest();
			$id=$this->input->post('action_id');
				if(!empty($id)){
						$page_data=array('id'=>$id);
						$page_data['is_deleted']=1;
						$response['status']=$this->Common_model->AddUpdateData('student',$page_data);	
					// /	echo"<pre>"; print_r($response); die;	
				if($response['status']){
						$response['message']="Student Deatils Deleted Successfully!";
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
			public function deleteStudentImag(){
				$this->isAjaxRequest();
				$id=$this->input->post('id');
				$image=$this->input->post('image');
				if(!empty($id) && !empty($image)){
				$update_data=array(
				'image'=>'',
				'id'=>$id
				);
				$result=$this->Common_model->AddUpdateData('student',$update_data);
				unlinkImage('student',$image);
			if($result){
				$response['message']="student Image deleted successfully!";
				$logdata=array(
				'activity_in'=>1,
				'category'=>7,
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
?>