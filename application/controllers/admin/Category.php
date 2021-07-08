<?php
class Category extends MY_Controller {
	private $category_counter=2;
	public function index()
	{
		if(isset($_POST['export'])){
			$this->exportcategory();
		}
  	 	$this->load->view('admin/category/manage-category');
	}
		 public function exportcategory(){ 
		// print_r($_POST); die;
        // file name 
        $category = $this->Category_model->manageCategoriesExport($_POST,false);
        //echo"<pre>"; print_r($category);die;
        $filename = 'category_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
      
        // file creation 
        $file = fopen('php://output', 'w');

        $header = array(
            "Name",
            "Parent Class",
            ); 
        fputcsv($file, $header);
        foreach ($category as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
       }



	public function manageCategories(){
		$this->isAjaxRequest();
 		$data=$this->Category_model->manageCategoriesAjax($_POST,false);
		$response['data']=array();
		if(count($data)){
			foreach($data as $row){
 				if(is_file('./attachments/category/thumb/'.$row['image'])){
					$image=base_url('attachments/category/thumb/'.$row['image']);	
			   }else{
				   $image='';
			   }
				$response['data'][]=array(
					'id'=>$row['id'],
					'image'=>$image,
					'name'=>$row['name'],
					'parent_name'=>$row['parent_name'],
 					'status'=>$row['status'],
 				);
			}
		}

		$response['total']=$this->Category_model->manageCategoriesAjax($_POST,true);
		$this->getJson($response);
	}

	public function addUpdateCategory(){
		$data=array();
		$id=$this->uri->segment(2);
		$where=array('c.parent_id'=>0,'c.status'=>1,'ct.abbr'=>'en');
		$data['categories']=$this->Category_model->categoryList($where);
   		if($id>0){
			$select=array('id'=>$id);
			$data['category']=$this->Category_model->CategoryData($select);

			$category_name_data=$this->Category_model->categoryNameData(array('c.id'=>$id));
			if(count($category_name_data)>0){
				foreach($category_name_data as $category_name_row){
					$data['names'][$category_name_row['abbr']]=$category_name_row;
				}	
			}
			$data['heading']="Update Category";
			$data['button']="Update";
    	}else{
			$data['category']['id']='';
			$data['category']['parent_id']='';
			$data['category']['name']='';
			$data['category']['image']='';
			$data['category']['status']=1;
			$data['heading']="Add Category";
			$data['button']="Add";
 		}
 		$this->load->view('admin/category/add-update-category',$data); 
	}

	public function categoryHierarchy(){
		$this->isAjaxRequest();
		$parent_id=$this->input->post('parent_id');
		$where=array('c.parent_id'=>$parent_id);
		$response['categories']=$this->Category_model->categoryList($where);
		$where=array('c.id'=>$parent_id);
		$this->recursive($where);
		$response['counter']=$this->category_counter;
		echo json_encode($response);
  }
  function recursive($where){
	  if(count($where)>0){
		  $level=$this->Category_model->getCategoryLevel($where);
		  $parent_id=$level['parent_id'];
		  if($parent_id>0){
			  $where=array('c.id'=>$parent_id);
			   $this->recursive($where);
			  $this->category_counter++;
		  }
		  return $this->category_counter;
	  }
  }

  public function categoryLevel(){
	$this->isAjaxRequest();
	$id=$this->input->post('id');
	$where=array('c.id'=>$id);
	$response['counter']=$this->recursive($where);
	echo json_encode($response);
}

public function categoryParentDom(){
	$this->isAjaxRequest();
	$id=$this->input->post('id');
	$where=array('id'=>$id);
	$response=$where;
	$data=$this->Category_model->categoryData($where);
	if($data){
		$response=$data;
	}
	echo json_encode($response);
}

	public function viewCategory(){
		$id=$this->uri->segment(2);
		if($id>0){
			$select=array('id'=>$id);
			$data['category']=$this->Category_model->categoryData($select);
			$category_name_data=$this->Category_model->categoryNameData(array('c.id'=>$id));
			if(count($category_name_data)>0){
				foreach($category_name_data as $category_name_row){
					$data['names'][$category_name_row['abbr']]=$category_name_row;
				}	
			}
			$this->load->view('admin/category/view-category',$data);
     	}
	}
	public function saveCategory(){
		$this->isAjaxRequest();
		$response['status']=true;
		$image_error='';
		$name_error='';
		$old_image=$this->input->post('old_image');
		$languages=getLanguageList(); 
		if(count($languages)){
			foreach($languages as $language){
				$this->form_validation->set_rules('name'.$language['abbr'], 'Name ('.ucfirst($language['name']).')', 'trim|required');
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
			$response['status']=$this->Common_model->checkExist('category',$where);
			if(!$response['status']){
				$name_error="Category Name already exists!";
			}
		}
		*/


		if($this->form_validation->run() == TRUE && $response['status']==TRUE){
 			if(!empty($_FILES['category_image']['name'])){
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'category_image';
				$file_response=uploadImage('category',$allowed_types,$input_name,$old_image);
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
				$response['category_image']=$image_error;
			}
			//if(!empty($name_error)){
			//	$response['name']=$name_error;
			//}
			$response['message']='There is error in submitting form!';
		}else{
			$save_data=array(
				'id'=>$this->input->post('id')? $this->input->post('id'):0,
				//'name'=>$this->input->post('name'),
				'parent_id'=>$this->input->post('parent_id'),
				'status'=>$this->input->post('status'),
				//'meta_title'=>$this->input->post('meta_title'),
				//'meta_keywords'=>$this->input->post('meta_keywords'),
				//'meta_description'=>$this->input->post('meta_description'),
			);
			$save_data['image']=$image ? $image:'';
			$category_id=$this->Common_model->AddUpdateData('category',$save_data);
			$languages=$this->input->post('languages');
			if(count($languages)){
				$this->Common_model->deleteRecord(array('category_id'=>$category_id),'category_translator');
				foreach($languages as $language){
					$save_data=array(
						'id'=>0,
						'category_id'=>$category_id,
						'name'=>$this->input->post('name'.$language),
 						'abbr'=>$language,
 					);
					$id=$this->Common_model->AddUpdateData('category_translator',$save_data);
					$slug=makeSlug($save_data['name'].'-'.$id);
					$update_data=array('id'=>$id,'slug'=>$slug);
					$this->Common_model->AddUpdateData('category_translator',$update_data);

					}
				}
 
			$slug=makeSlug($this->input->post('nameen').'-'.$category_id);
			$update_data=array('id'=>$category_id,'slug'=>$slug);
			$this->Common_model->AddUpdateData('category',$update_data);
			if($this->input->post('id')>0){
				$response['message']="Category Updated Successfully!";
			}else{
				$response['message']="Category Added Successfully!";
			}
			$this->session->set_flashdata('success_message',$response['message']);
			$logdata=array(
				'activity_in'=>1,
				'category'=>3,
				'reference_id'=>$category_id,
				'action'=>'Updated',
				'message'=>$response['message'],
				'modified_data'=>json_encode($this->input->post()),
				'done_by'=>$this->session->userdata('admin_data')['id']
			);
			activityLog($logdata);
		}
		echo json_encode($response);
	}



	public function categoryRecursiveChangeStatus($id){
		$where=array('c.parent_id'=>$id);
		$update_data=array('id'=>$id,'status'=>0);
		$this->Common_model->AddUpdateData('category',$update_data);
		$response=$this->Category_model->categoryList($where,true);
   		if(count($response)>0){
			foreach($response as $row){
 				$this->categoryRecursiveChangeStatus($row['id']);
			}
		}
		return true;
	}
	 
	public function changeStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			if($status==1){
				$update_data=array('id'=>$id,'status'=>$status);
				$response['status']=$this->Common_model->changeDataStatus('category',$update_data);
			}else{
				$response['status']=$this->categoryRecursiveChangeStatus($id);
			}
			
			if($response['status']){
				$response['message']="Category Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>3,
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
 
 


	function deleteCategory(){
		$this->isAjaxRequest();
		$action_id=$this->input->post('action_id');
		if(!empty($action_id)){
			$select=array('id'=>$action_id);
			//$category_info=$this->Admin_model->categoryData($select);
			//$image=$category_info['image']; 
			//$response['status']=$this->Admin_model->deleteRecord($select,'category');
			$category_data=array('id'=>$action_id);
			//$customer_data['is_deleted']=1;
			$response['status']=$this->categoryRecursive($action_id);
			//$this->Admin_model->AddUpdateData('category',$customer_data);
			if($response['status']){
				$response['message']="Category Deleted Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>3,
					'reference_id'=>$action_id,
					'action'=>'Deleted',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
			}
			//unlinkImage('category',$image);
			echo json_encode($response);
		}
	}

	public function categoryRecursive($id){
		$where=array('c.parent_id'=>$id);
		$update_data=array('id'=>$id,'is_deleted'=>1);
		$this->Common_model->AddUpdateData('category',$update_data);
		$response=$this->Category_model->categoryList($where,true);
   		if(count($response)>0){
			foreach($response as $row){
 				$this->categoryRecursive($row['id']);
			}
		}
		return true;
	}

	//deleteCategoryImage

	public function deleteCategoryImage(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$image=$this->input->post('image');
		if(!empty($id) && !empty($image)){
			$update_data=array(
				'image'=>'',
				'id'=>$id
			);
 			$result=$this->Common_model->AddUpdateData('category',$update_data);
			unlinkImage('vendor',$image);
			if($result){
				$response['message']="Category Image deleted successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>3,
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

	function upload(){
		if(isset($_POST["submit"])) {
    if(is_array($_FILES)) {


        $file = $_FILES['fileToUpload']['tmp_name']; 
        $sourceProperties = getimagesize($file);
        $fileNewName = time();
         $folderPath='./attachments/uploads/';
        $ext = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
        $imageType = $sourceProperties[2];


        switch ($imageType) {


            case IMAGETYPE_PNG:
                $imageResourceId = imagecreatefrompng($file); 
                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagepng($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
                break;


            case IMAGETYPE_GIF:
                $imageResourceId = imagecreatefromgif($file); 
                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagegif($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
                break;


            case IMAGETYPE_JPEG:
                $imageResourceId = imagecreatefromjpeg($file); 
                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagejpeg($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
                break;


            default:
                echo "Invalid Image type.";
                exit;
                break;
        }


        move_uploaded_file($file, $folderPath. $fileNewName. ".". $ext);
        echo "Image Resize Successfully.";
    }
}

 		$this->load->view('admin/category/upload'); 
	} 

	function imageResize($imageResourceId,$width,$height) {


    $targetWidth =1400;
    $targetHeight =600;


    $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
    imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);


    return $targetLayer;
}


}





