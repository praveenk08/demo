<?php
class Brand extends MY_Controller {

	public function index()
	{
  	 	$this->load->view('admin/brand/manage-brand');
	}

	public function units()
	{
		if(isset($_POST['export'])){
			$this->exportunits();
		}
 	 	$this->load->view('admin/units/manage-unit');
	}

	public function exportunits(){ 
        // file name 
        $units = $this->Category_model->manageunitsExport($_POST,false);
        //print_r($units);die;
        $filename = 'unit_list'.date('d-m-Y m-i-s').'.csv'; 
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
        foreach ($units as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
       }



	public function manageBrands(){
		$this->isAjaxRequest();
		$response['data']=$this->Category_model->manageBrandsAjax($_POST,false);
		$response['total']=$this->Category_model->manageBrandsAjax($_POST,true);
		$this->getJson($response);
	}

	public function manageUnits(){
		$this->isAjaxRequest();
		$response['data']=$this->Category_model->manageUnitsAjax($_POST,false);
		$response['total']=$this->Category_model->manageUnitsAjax($_POST,true);
		$this->getJson($response);
	}

	public function addUpdateBrand(){
		$data=array();
	  	$id=$this->uri->segment(2);
		if($id>0){
			$select=array('id'=>$id);
			$data['brand']=$this->Category_model->brandData($select);
			$data['heading']="Update Brand";
			$data['button']="Update";
    	}else{
			$data['brand']['id']='';
			$data['brand']['name']='';
			$data['brand']['image']='';
			$data['brand']['status']=1;
			$data['heading']="Add Brand";
			$data['button']="Add";
			
 		}
 		$this->load->view('admin/brand/add-update-brand',$data); 
	}

	public function addUpdateUnit(){
 		$data=array();
	  	$id=$this->uri->segment(2);
		if($id>0){
			$select=array('id'=>$id);
			$data['unit']=$this->Category_model->unitData($select);

			$unit_name_data=$this->Category_model->getUnitNameData(array('u.id'=>$id));
			if(count($unit_name_data)>0){
				foreach($unit_name_data as $unit_name_row){
					$data['names'][$unit_name_row['abbr']]=$unit_name_row;
				}	
			}

			$data['heading']="Update Unit";
			$data['button']="Update";
    	}else{
			$data['unit']['id']='';
 			$data['unit']['image']='';
			$data['unit']['status']=1;
			$data['heading']="Add Unit";
			$data['button']="Add";
 		}
 		$this->load->view('admin/units/add-update-unit',$data); 
	}

	
	public function viewBrand(){
		$id=$this->uri->segment(2);
		if($id>0){
			$select=array('id'=>$id);
			$data['brand']=$this->Category_model->brandData($select);
			$this->load->view('admin/brand/view-brand',$data);
     	}
	}

	public function viewUnit(){
		$id=$this->uri->segment(2);
		if($id>0){
			$select=array('id'=>$id);
			$data['unit']=$this->Category_model->unitData($select);
			$unit_name_data=$this->Category_model->getUnitNameData(array('u.id'=>$id));
			if(count($unit_name_data)>0){
				foreach($unit_name_data as $unit_name_row){
					$data['names'][$unit_name_row['abbr']]=$unit_name_row;
				}	
			}
			$this->load->view('admin/units/view-unit',$data);
     	}
	}


 	public function saveBrand(){
		$this->isAjaxRequest();
		$response['status']=true;
		$image_error='';
		$name_error='';
		$old_image=$this->input->post('old_image');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$name=$this->input->post('name');
		$id=$this->input->post('id') ? $this->input->post('id'):0;
		if(!empty($name)){
			$where=array('name'=>$name);
			if($id>0){
				$where['id <>']=$id;
			}
			$response['status']=$this->Common_model->checkExist('brands',$where);
			if(!$response['status']){
				$name_error="Brand Name already  exists";
			}
		}

		if($this->form_validation->run() == TRUE && $response['status']==TRUE){
  			if(!empty($_FILES['image']['name'])){
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'image';
				$file_response=uploadImage('brand',$allowed_types,$input_name,$old_image);
				if($file_response['status']){
					$brand_image=$file_response['name'];
				}else{
					$response['status']=false;
					$image_error=$file_response['message'];
				}
			}else{
				$brand_image=$old_image;
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
				'image'=>$brand_image ? $brand_image:'',
				
			);

			$brand_id=$this->Common_model->AddUpdateData('brands',$save_data);
			
			if($save_data['id']>0){
				$id=$save_data['id'];
				$action="Updated";
			}else{
				$id=$brand_id;
				$action="Added";
			}

			$message = "Brand ".$action." Successfully!";
			$this->session->set_flashdata('success_message',$message);
			$slug=makeSlug($save_data['name'].'-'.time());
			$update_data=array('id'=>$id,'slug'=>$slug,'modified_date'=>'now()');
			$this->Common_model->AddUpdateData('brands',$update_data);
			$logdata=array(
				'activity_in'=>1,
				'category'=>4,
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

	public function saveUnit(){
		$this->isAjaxRequest();
		$response['status']=true;
		$name_error='';
		$languages=getLanguageList(); 
		  if(count($languages)){
			  foreach($languages as $language){
				  $this->form_validation->set_rules('name'.$language['abbr'], 'Unit Name('.ucfirst($language['name']).')', 'trim|required');
			  }
		  }
 
		$name=$this->input->post('name');
		$id=$this->input->post('id') ? $this->input->post('id'):0;
		/*
		if(!empty($name)){
			$where=array('name'=>$name);
			if($id>0){
				$where['id <>']=$id;
			}
			$response['status']=$this->Common_model->checkExist('units',$where);
			if(!$response['status']){
				$name_error="Unit Name already  exists";
			}
		}
		*/

			
		
		if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
			$response=$this->form_validation->error_array();
			$response['status']=false;
			//if(!empty($name_error)){
				//$response['name']=$name_error;
			//}
			$response['message']='There is error in submitting form!';
		}else{
			$save_data=array(
				'id'=>$this->input->post('id')? $this->input->post('id'):0,
				//'name'=>$this->input->post('name'),
				'status'=>$this->input->post('status'),
			);
			$unit_id=$this->Common_model->AddUpdateData('units',$save_data);
			$languages=$this->input->post('languages');
			if(count($languages)){
				$this->Common_model->deleteRecord(array('unit_id'=>$unit_id),'unit_translator');
				foreach($languages as $language){
					$save_data=array(
					'id'=>0,
					'unit_id'=>$unit_id,
					'name'=>$this->input->post('name'.$language),
 					'abbr'=>$language,
 					);
 					$this->Common_model->AddUpdateData('unit_translator',$save_data);
					}
				}
			if($save_data['id']>0){
				$id=$save_data['id'];
				$action="Updated";
			}else{
				$id=$unit_id;
				$action="Added";
			}
			$message = "Unit ".$action." Successfully!";
			$this->session->set_flashdata('success_message',$message);
				$logdata=array(
				'activity_in'=>1,
				'category'=>5,
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
			$response['status']=$this->Common_model->changeDataStatus('brands',$update_data);
			if($response['status']){
				$response['message']="Brand Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>4,
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

	public function changeUnitStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			$update_data=array('id'=>$id,'status'=>$status);
			$response['status']=$this->Common_model->changeDataStatus('units',$update_data);
			if($response['status']){
				$response['message']="Unit Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>5,
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

 
	function deleteBrand(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$brand_data=array('id'=>$id);
			$brand_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('brands',$brand_data);
			if($response['status']){
				$response['message']="Brand Deleted Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>4,
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

	function deleteUnit(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$unit_data=array('id'=>$id);
			$unit_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('units',$unit_data);
			if($response['status']){
				$response['message']="Unit Deleted Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>5,
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

	

	//deleteBrandImage

	public function deleteBrandImage(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$image=$this->input->post('image');
		if(!empty($id) && !empty($image)){
			$update_data=array(
				'image'=>'',
				'id'=>$id
			);
 			$result=$this->Common_model->AddUpdateData('brands',$update_data);
			unlinkImage('vendor',$image);
			if($result){
				$response['message']="Brand Image deleted successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>4,
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

////////////////////////////////////////////////////////

public function whyChoose()
	{
 	 	$this->load->view('admin/why-choose-us/manage-why-choose-us');
	}


public function manageWhyChooseAjax()
	{
		$this->isAjaxRequest();
		$data=$this->Users_model->manageWhyChooseAjax($_POST,false);
		$response['total']=$this->Users_model->manageWhyChooseAjax($_POST,true);
		$response['data']=array();
		if(count($data)>0){
			foreach($data as $row){
				if(is_file('./attachments/why-choose-us/thumb/'.$row['image']) && !empty($row['image'])){
					$image=base_url('attachments/why-choose-us/thumb/'.$row['image']);	
				 }else{
					 $image='';
				 }
				 $response['data'][]=array(
					 'id'=>$row['id'],
					 'name'=>$row['name'],
					 'status'=>$row['status'],
 					 'image'=>$image,
 				 );
			 }
		 }


 		$this->getJson($response);
	}
	public function changeWhyChooseStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			$update_data=array('id'=>$id,'status'=>$status);
			$response['status']=$this->Common_model->changeDataStatus('why_choose_us',$update_data);
			if($response['status']){
				$response['message']="Why Choose Us Status Updated Successfully!";
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

	public function viewWhyChoose(){
		$id=$this->uri->segment(2);
		if($id>0){

			$where=array('wcu.id'=>$id);
			$data['why_choose']=$this->Users_model->whyChooseData($where);


			$why_choose_name_data=$this->Users_model->getwhyChooseUsNameData(array('wcu.id'=>$id));
			if(count($why_choose_name_data)>0){
				foreach($why_choose_name_data as $why_choose_name_row){
					$data['names'][$why_choose_name_row['abbr']]=$why_choose_name_row;
				}	
			}
			$this->load->view('admin/why-choose-us/view-why-choose-us',$data); 
		}		 
	}


	public function addUpdateWhyChoose(){
		$data=array();
	  	$id=$this->uri->segment(2);
		if($id>0){
			$where=array('wcu.id'=>$id);
			$data['why_choose']=$this->Users_model->whyChooseData($where);
			$why_choose_name_data=$this->Users_model->getwhyChooseUsNameData(array('wcu.id'=>$id));
			if(count($why_choose_name_data)>0){
				foreach($why_choose_name_data as $why_choose_name_row){
					$data['names'][$why_choose_name_row['abbr']]=$why_choose_name_row;
				}	
			}
 			$data['heading']="Update Why Choose Us";
			$data['button']="Update";
    	}else{
			$data['why_choose']['id']='';
			$data['why_choose']['image']='';
  			$data['why_choose']['status']=1;
			$data['heading']="Add Why Choose Us";
			$data['button']="Add";
 		}
		$this->load->view('admin/why-choose-us/add-update-why-choose-us',$data); 
	}
	
	public function saveWhyChoose(){
		$this->isAjaxRequest();
		$response['status']=TRUE;
 		$image_error='';
 		$languages=getLanguageList(); 
		  if(count($languages)){
			  foreach($languages as $language){
				  $this->form_validation->set_rules('name'.$language['abbr'], 'Service Category Name ('.ucfirst($language['name']).')', 'trim|required');
			  }
		  }

		$id=$this->input->post('id') ? $this->input->post('id'):0;
		$old_image=$this->input->post('old_image') ? $this->input->post('old_image'):'';
		  
		 if($this->form_validation->run() == TRUE && $response['status']==TRUE){
			if(!empty($_FILES['image']['name'])){
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'image';
				$file_response=uploadImage('why-choose-us',$allowed_types,$input_name,$old_image);
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
			if(!empty($image_error)){
				$response['image']=$image_error;
 			}
			$response['message']='There is error in submitting form!';
		}else{
			$save_data=array(
				'id'=>$this->input->post('id')? $this->input->post('id'):0,
				'status'=>$this->input->post('status'),
				'image'=>$image?$image:'',
			);
			$why_choose_us_id=$this->Common_model->AddUpdateData('why_choose_us',$save_data);
			$languages=$this->input->post('languages');
			if(count($languages)){
				$this->Common_model->deleteRecord(array('why_choose_us_id'=>$why_choose_us_id),'why_choose_us_translator');
				foreach($languages as $language){
					$save_data=array(
						'id'=>0,
						'why_choose_us_id'=>$why_choose_us_id,
						'name'=>$this->input->post('name'.$language),
						'description'=>$this->input->post('description'.$language),
						'abbr'=>$language,
 					);
					$id=$this->Common_model->AddUpdateData('why_choose_us_translator',$save_data);
					$slug=makeSlug($save_data['name'].'-'.$id);
					$update_data=array('id'=>$id,'slug'=>$slug);
					$this->Common_model->AddUpdateData('why_choose_us_translator',$update_data);
					}
				}
			if($save_data['id']>0){
				$id=$save_data['id'];
				$action="Updated";
			}else{
				$id=$why_choose_us_id;
				$action="Added";
			}

			$message = "Why Choose Us ".$action." Successfully!";
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
	public function deleteWhyChooseImage(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$image=$this->input->post('image');
		if(!empty($id) && !empty($image)){
			$update_data=array(
				'image'=>'',
				'id'=>$id
			);
 			$result=$this->Common_model->AddUpdateData('why_choose_us',$update_data);
			unlinkImage('vendor',$image);
			if($result){
				$response['message']="Why Choose Us Image deleted successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>4,
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

	


	function deleteWhyChoose(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$user_data=array('id'=>$id);
			$user_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('why_choose_us',$user_data);
			if($response['status']){
				$response['message']="Why Choose Us Deleted Successfully!";
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


	

	 
}
