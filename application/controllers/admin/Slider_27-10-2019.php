<?php
class Slider extends MY_Controller {

	public function index()
	{
  	 	$this->load->view('admin/slider/manage-slider');
	}

	public function sliders()
	{
 	 	$this->load->view('admin/slider/manage-slider');
	}
	public function manageSliders(){
		$this->isAjaxRequest();
		$data=$this->Category_model->manageSlidersAjax($_POST,false);
		$response['data']=array();
		if(count($data)){
			foreach($data as $row){
				if(is_file('./attachments/sliders/thumb/'.$row['image'])){
					$image=base_url('attachments/sliders/thumb/'.$row['image']);	
			   }else{
				   $image='';
			   }
				$response['data'][]=array(
					'id'=>$row['id'],
					'image'=>$image,
					'name'=>$row['name'],
 					'status'=>$row['status'],
 				);
			}
		}
		$response['total']=$this->Category_model->manageSlidersAjax($_POST,true);
		$this->getJson($response);
	}
	

	function uploadSliderImage()
	{
		$this->isAjaxRequest();
		$image_parts = explode(";base64,", $this->input->post('image'));
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = 'jpeg';
		$filename=uniqid().'.' .$image_type;
		if(!file_exists('./attachments/sliders/'.$this->session->userdata('admin_data')['id'])){
			if(mkdir('./attachments/sliders/'.$this->session->userdata('admin_data')['id'], 777));
		}
		$filepath = './attachments/sliders/'.$this->session->userdata('admin_date')['id'].'/'.$filename;
		$blob= $image_parts[1];
		file_put_contents($filepath,  base64_decode( str_replace('data:image/jpeg;base64,', '', $blob)));
		$response=array('image_path'=>$filepath,'image_name'=>$filename,'image_id'=>time());
		echo json_encode($response);
	}
	public function manageUnits(){
		$this->isAjaxRequest();
		$response['data']=$this->Category_model->manageUnitsAjax($_POST,false);
		$response['total']=$this->Category_model->manageUnitsAjax($_POST,true);
		$this->getJson($response);
	}

	public function addUpdateSlider(){
		deleteTempFiles('./attachments/sliders/'.$this->session->userdata('admin_data')['id'].'/*');
		$data=array();
	  	$id=$this->uri->segment(2);
		if($id>0){
			$select=array('id'=>$id);
			$sliderdata=getSingleTableData('slider',$select); //select from slider where id = id ..
			 if(count($sliderdata)>0){
				$data['slider']=$sliderdata[0];
							}
			else
			{
				redirect('admin-dashboard');
			}
			 $data['heading']="Update Slider";
			 $data['button']="Update";
    	}else{
			$data['slider']['id']='';
			$data['slider']['name']='';
			$data['slider']['image']='';
			$data['slider']['status']=1;
			$data['heading']="Add Slider";
			$data['button']="Add";
			
 		}
 		$this->load->view('admin/slider/add-update-slider',$data); 
	}

 

	public function viewSlider(){
		$id=$this->uri->segment(2);
		if($id>0){
			$select=array('id'=>$id);
			$sliderdata=getSingleTableData('slider',$select);
			 if(count($sliderdata)>0){
				$data['slider']=$sliderdata[0];
			}
			else
			{
				redirect('admin-dashboard');
			}


			$this->load->view('admin/slider/view-slider',$data);
     	}
	}

  	public function saveSlider(){
		$this->isAjaxRequest();
		$response['status']=true;
		$image_error='';
		$name_error='';
		$old_image=$this->input->post('old_image');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]');
		if(empty($old_image) && empty($_FILES['image']['name'])){
			$this->form_validation->set_rules('image', 'Slider Image', 'required');

		}
		$name=$this->input->post('name');
		$id=$this->input->post('id') ? $this->input->post('id'):0;
		if(!empty($name)){
			$where=array('name'=>$name);
			if($id>0){
				$where['id <>']=$id;
			}
			$response['status']=$this->Common_model->checkExist('slider',$where);
			if(!$response['status']){
				$name_error="Slider Name already  exists";
			}
		}
       
        if($this->form_validation->run() == TRUE && $response['status']==TRUE){
  			if(!empty($_FILES['image']['name'])){
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'image';
				$file_response=uploadImage('sliders',$allowed_types,$input_name,$old_image);
				if($file_response['status']){
					$slider_image=$file_response['name'];
				}else{
					$response['status']=false;
					$image_error=$file_response['message'];
				}
			}else{
				$slider_image=$old_image;
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
				'status'=>$this->input->post('status'),
				'image'=>$slider_image ? $slider_image:'',
			);

			$slider_id=$this->Common_model->AddUpdateData('slider',$save_data);
			
			if($save_data['id']>0){
				$id=$save_data['id'];
				$action="Updated";
			}else{
				$id=$slider_id;
				$action="Added";
			}
			$message = "Slider ".$action." Successfully!";
			$this->session->set_flashdata('success_message',$message);
   			$logdata=array(
				'activity_in'=>1,
				'category'=>7,
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
			$response['status']=$this->Common_model->changeDataStatus('slider',$update_data);
			if($response['status']){
				$response['message']="Slider Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>7,
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

	function deleteSlider(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$brand_data=array('id'=>$id);
			$brand_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('slider',$brand_data);
			if($response['status']){
				$response['message']="Slider Deleted Successfully!";
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
			}
			echo json_encode($response);
		}
	}

	//deleteSliderImage

	public function deleteSliderImage(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$image=$this->input->post('image');
		if(!empty($id) && !empty($image)){
			$update_data=array(
				'image'=>'',
				'id'=>$id
			);
 			$result=$this->Common_model->AddUpdateData('slider',$update_data);
			unlinkImage('sliders',$image);
			if($result){
				$response['message']="Slider Image deleted successfully!";
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
	public function faqList(){
 	 	$this->load->view('admin/faq/manage-faq');
	}

	public function manageFaqs(){
		$this->isAjaxRequest();
		$response['data']=$this->Category_model->manageFaqsAjax($_POST,false);
		$response['total']=$this->Category_model->manageFaqsAjax($_POST,true);
		$this->getJson($response);
	}
		
	public function addUpdateFaq(){
 		$data=array();
	  	$id=$this->uri->segment(2);
		if($id>0){
			$select=array('id'=>$id);
			$faqdata=getSingleTableData('faq',$select);
			 if(count($faqdata)>0){
				$data['faq']=$faqdata[0];
			}
			else
			{
				redirect('admin-dashboard');
			}
			 $data['heading']="Update Faq";
			 $data['button']="Update";
    	}else{
			$data['faq']['id']='';
			$data['faq']['question']='';
			$data['faq']['answer']='';
			$data['faq']['status']=1;
			$data['heading']="Add Faq";
			$data['button']="Add";
 		}
 		$this->load->view('admin/faq/add-update-faq',$data); 
	}
	public function saveFaq(){
		$this->isAjaxRequest();
		$response['status']=true;
 		$question_error='';
 		$this->form_validation->set_rules('question', 'Question', 'trim|required');
 		$this->form_validation->set_rules('answer', 'Answer', 'trim|required');
		$question=$this->input->post('question');
		$id=$this->input->post('id') ? $this->input->post('id'):0;
		if(!empty($question)){
			$where=array('question'=>$question);
			if($id>0){
				$where['id <>']=$id;
			}
			$response['status']=$this->Common_model->checkExist('faq',$where);
			if(!$response['status']){
				$question_error="Question already  exists";
			}
		}
       
		if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
			$response=$this->form_validation->error_array();
			$response['status']=false;
			if(!empty($question_error)){
				$response['question']=$question_error;
			}
			$response['message']='There is error in submitting form!';
		}else{
			$save_data=array(
				'id'=>$this->input->post('id')? $this->input->post('id'):0,
				'question'=>$this->input->post('question'),
				'answer'=>$this->input->post('answer'),
				'status'=>$this->input->post('status'),
 			);

			$faq_id=$this->Common_model->AddUpdateData('faq',$save_data);
			
			if($save_data['id']>0){
				$id=$save_data['id'];
				$action="Updated";
			}else{
				$id=$faq_id;
				$action="Added";
			}
			$message = "Faq ".$action." Successfully!";
			$this->session->set_flashdata('success_message',$message);
   			$logdata=array(
				'activity_in'=>1,
				'category'=>8,
				'reference_id'=>$id,
				'action'=>$action,
				'message'=>$message,
				'modified_data'=>json_encode($this->input->post()),
				'done_by'=>$this->session->userdata('id')
			);
			activityLog($logdata);
			$response['message']=$message;
		}
		echo json_encode($response);
		
	}

	
	public function viewFaq(){
		$id=$this->uri->segment(2);
		if($id>0){
			$select=array('id'=>$id);
			$faqdata=getSingleTableData('faq',$select);
			 if(count($faqdata)>0){
				$data['faq']=$faqdata[0];
			}
			else
			{
				redirect('admin-dashboard');
			}	
			$this->load->view('admin/faq/view-faq',$data);
     	}
	}


	function deleteFaq(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$brand_data=array('id'=>$id);
			$brand_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('faq',$brand_data);
			if($response['status']){
				$response['message']="Faq Deleted Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>8,
					'reference_id'=>$id,
					'action'=>'Deleted',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('id')
				);
				activityLog($logdata);
			}
			echo json_encode($response);
		}
	}

	public function changeFaqStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			$update_data=array('id'=>$id,'status'=>$status);
			$response['status']=$this->Common_model->changeDataStatus('faq',$update_data);
			if($response['status']){
				$response['message']="Faq Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>8,
					'reference_id'=>$id,
					'action'=>'Updated',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('id')
				);
				activityLog($logdata);
			}
			$data=array('status'=>1);
			echo json_encode($data);
		}
	}
 }