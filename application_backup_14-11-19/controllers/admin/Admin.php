<?php
class Admin extends MY_Controller
{
 function updateProfile(){
        $this->load->view('admin/update-profile');
	}

	public function adminUpdateProfile(){
		$this->isAjaxRequest();
		$image_error='';
		$response['status']=true;
		$this->form_validation->set_rules('admin_first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('admin_last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('admin_phone', 'Phone Number', 'required|regex_match[/^[0-9]{10}$/]|min_length[10]|max_length[12]');
		$this->form_validation->set_rules('admin_email', 'Email Address', 'trim|required|valid_email|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('admin_password', 'Password', 'trim|min_length[5]');
		$this->form_validation->set_rules('confirm_admin_password', 'Confirm Password', 'matches[admin_password]');
		$old_image=$this->input->post('old_image');
		if($this->form_validation->run() == TRUE && $response['status']==TRUE){
			if(!empty($_FILES['admin_image']['name'])){ 
				$allowed_types = 'png|jpg|jpeg|gif';
				$input_name = 'admin_image';
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
					$response['admin_image']=$image_error;
				}
				$response['message']='There is error in submitting form!';
			}else{
			
			$update_data=array(
				'id'=>$this->session->userdata('admin_data')['id'],
				'first_name'=>$this->input->post('admin_first_name'),
				'last_name'=>$this->input->post('admin_last_name'),
				//'email'=>$this->input->post('admin_email'),
				'phone'=>$this->input->post('admin_phone'),
				'image'=>$image?$image:'',
			);
			if(!empty($this->input->post('admin_password'))){
				$update_data['password']=sha1($this->input->post('admin_password'));
			}
			$admin_id=$this->Common_model->updateProfile($update_data);
			if($admin_id){
				$update_data['email']=$this->session->userdata('admin_data')['email'];
				$this->session->set_userdata(array('admin_data'=>$update_data));
				$this->session->set_flashdata('success_message',"Your profile has been updated successfully!");
			}
		}
		echo json_encode($response);
	}
 
	public function adminRemoveProfilePhoto(){
		$this->isAjaxRequest();
		$data=post['data'];
		$update_data=array(
			'image'=>'',
			'id'=>$this->session->userdata('admin_data')['id']
		);
		$response['status']=$this->Common_model->updateProfile($update_data);
 		unlinkImage('users',$this->session->userdata('admin_data')['image']);
		$this->session->unset_userdata($this->session->userdata('admin_data')['image']);
		$this->session->set_flashdata('success_message',"Your profile Image has been removed successfully!");
		echo json_encode($response);
 
	}
	function getdata(){
		return "";
	}


	
	
}