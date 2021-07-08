<?php
 	class Common extends CI_Controller{
		public function __construct(){

			parent::__construct();
			$this->load->model('common/Common_model');
 
		}

		public function changeCountryGetState(){
			if ($this->input->is_ajax_request()) {
				$country_id=$this->input->post('country_id');
				if($country_id >0){
					$where=array('country_id'=>$country_id);
					$response=changeCountryGetState($where);
					echo json_encode($response);
				}	
			}
		}

		public function changeStateGetCity(){
			if ($this->input->is_ajax_request()) {
				$state_id=$this->input->post('state_id');
				if($state_id >0){
					$where=array('state_id'=>$state_id);
					$response=changeStateGetCity($where);
					echo json_encode($response);
				}
			}
		} 
		public function getChildCategories(){
			if ($this->input->is_ajax_request()) {
				$id=$this->input->post('id');
				$abbr=$this->input->post('abbr')?$this->input->post('abbr'):'en';
				if($id >0){
					$where=array('c.status'=>1,'c.is_deleted'=>0,'c.parent_id'=>$id,'ct.abbr'=>$abbr);
					 $response=categoryList($where);
 					echo json_encode($response);
				}
			}
		}

		

	}
 