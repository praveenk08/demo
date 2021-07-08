<?php
class Review extends VendorController {

	public function __construct()
    {
        parent::__construct();
 		$this->load->model('common/Review_model');
 		$this->load->model('admin/Products_model','PM');
    }
	public function index()
	{
		if(isset($_POST['export']))
		{
			$this->exportReviews();
		}
 	 	$this->load->view('vendor/review/manage-review');
	}

	public function exportReviews()
	{
		// /echo"<pre>"; print_r($_POST); die;
		$this->load->model('admin/Review_model');
		$Reviews= $this->PM->manageReviewsExport($_POST,$count=false);
	//	echo"<pre>"; print_r($Reviews); die;
		$filename = 'products_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
        $file = fopen('php://output', 'w');

        $header = array(
            "Review",
            "Coustmer Name",
            "Vendor Name",
            
               ); 
        fputcsv($file, $header);
        foreach ($Reviews as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
	}





	public function manageProductsFile(){
		//echo"<pre>"; print_r($_POST); die;
		$Reviews= $this->Review_model->manageReviewsExport($_POST,$count=false);
		echo"<pre>"; print_r($Reviews); die;
		$filename = 'product_Review_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
        $file = fopen('php://output', 'w');

        $header = array(
            "Product Name",
            "Unit Name",
            "Quantity",
            "Total Sale",
            "Price",
            "Status",
            "Vendor Name",
               ); 
        fputcsv($file, $header);
        foreach ($Reviews as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
	}

	
	public function manageReviews(){
		$this->isAjaxRequest();
		$_POST['vendor_id']=$this->session->userdata('vendor_data')['id'];
		$response['data']=$this->Review_model->manageReviewsAjax($_POST,false);
		$response['total']=$this->Review_model->manageReviewsAjax($_POST,true);
		$this->getJson($response);
	}
 


	public function changeReviewStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			$update_data=array('id'=>$id,'status'=>$status);
			$response['status']=$this->Common_model->changeDataStatus('review_rating',$update_data);
			if($response['status']){
				$response['message']="Review Rating Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>9,
					'reference_id'=>$id,
					'action'=>'Updated',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('vendor_data')['id']
				);
				activityLog($logdata);
			}
			$data=array('status'=>1);
			echo json_encode($data);
		}
	}

 
	function deleteReview(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$page_data=array('id'=>$id);
			$page_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('review_rating',$page_data);
			if($response['status']){
				$response['message']="Review Rating Deleted Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>9,
					'reference_id'=>$id,
					'action'=>'Deleted',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('vendor_data')['id']
				);
				activityLog($logdata);
			}
			echo json_encode($response);
		}
	}
	public function changeRating(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$rating=$this->input->post('rating');
		if($id>0){
			$update_data=array('id'=>$id,'rating'=>$rating);
			$response['status']=$this->Common_model->changeDataStatus('review_rating',$update_data);
			if($response['status']){
				$response['message']="Rating Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>9,
					'reference_id'=>$id,
					'action'=>'Updated',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('vendor_data')['id']
				);
				activityLog($logdata);
			}
 			echo json_encode($response);
		}
	}

	public function updateRating(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$title=$this->input->post('title');
		$review=$this->input->post('review');
		if($id>0){
			$update_data=array('id'=>$id,'title'=>$title,'review'=>$review);
			$response['status']=$this->Common_model->AddUpdateData('review_rating',$update_data);
			if($response['status']){
				$response['message']="Review Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>9,
					'reference_id'=>$id,
					'action'=>'Updated',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('vendor_data')['id']
				);
				activityLog($logdata);
			}
 			echo json_encode($response);
		}
	}
	
	public function contactUs()
	{
 	 	$this->load->view('admin/contact-us/manage-contact-us');
	}

	public function managecontactUs(){
		$this->isAjaxRequest();
		$response['data']=$this->Review_model->contactUsAjax($_POST,false);
		$response['total']=$this->Review_model->contactUsAjax($_POST,true);
		$this->getJson($response);
	}
	

	public function changeContactUSStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			$update_data=array('id'=>$id,'status'=>$status);
			$response['status']=$this->Common_model->changeDataStatus('contact_us',$update_data);
			if($response['status']){
				$response['message']="Contact US Data Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>10,
					'reference_id'=>$id,
					'action'=>'Updated',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('vendor_data')['id']
				);
				activityLog($logdata);
			}
			$data=array('status'=>1);
			echo json_encode($data);
		}
	}

	function deleteContactUs(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
			$page_data=array('id'=>$id);
			$page_data['is_deleted']=1;
			$response['status']=$this->Common_model->AddUpdateData('contact_us',$page_data);
			if($response['status']){
				$response['message']="Contact US Data Deleted Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>10,
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
	
}
