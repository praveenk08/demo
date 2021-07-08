<?php
class Login extends CI_Controller
{
 	public function __construct()
    {
        parent::__construct();
		$this->load->model('common/Common_model');		
    }
	public function index(){
		if ($this->session->userdata('vendor_data')) {
		  redirect('vendor-dashboard', 'refresh');
	}
	  $this->load->view('vendor/login');
  }

	public function loginCheck(){

		if (!$this->input->is_ajax_request() || (!$this->input->post()) || $this->session->userdata('vendor_data')) {
			redirect('vendor-dashboard', 'refresh');
		}
		$this->form_validation->set_rules('email', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if ($this->form_validation->run() == FALSE) {
				$response=$this->form_validation->error_array();
				$response['status']=false;
				$response['message']='There is error in submitting form!';
			}else{
				$check_data=array(
					'email'=>$this->input->post('email'),
					'password'=>sha1($this->input->post('password')),
					'role_id'=>2,
 				);
				$result = $this->Common_model->loginCheck($check_data);
 				//print_r($result);
				if (!empty($result)) {
					$verified=$result['verified'];
					if(!$verified){
						$response['status']=false;
						$response['message']='You account needs to verification!';
					}else{
						$status=$result['status'];
						if(!$status){
							$response['status']=false;
							$response['message']='You account needs to verify by admin!';
						}else{
							$this->Common_model->updateLogin($result['id']);
							$this->session->set_userdata('logged_in',TRUE);
   						$this->session->set_userdata(array('vendor_data'=>$result,'url'=>'vendor-dashboard','role_id'=>$result['role_id']));
							if($this->input->post('remind_me')){
								$this->load->helper('cookie');
								//$this->input->set_cookie($result);
							}
							$response['status']=true;
							$response['message']='You have successfully loggedin!';
						}
					}
				} else {
					$response['status']=false;
					$response['message']='Wrong username or password!';
				}
			}
			
			echo json_encode($response);
	}
	
	public function ForgotPassword(){
 		 // load form and url helpers
		 $this->load->helper(array('form', 'url'));
       
		 // load form_validation library
		 $this->load->library('form_validation');
 		if ($this->session->userdata('vendor')) {
            redirect('vendor-dashboard', 'refresh');
        }
 		$this->form_validation->set_rules('username', 'Email Address', 'trim|required|valid_email');
		 $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		 
 		if ($this->form_validation->run($this)) {
 			$where=array('email'=>$this->input->post('username'),'role_id'=>2);
			$result = $this->Common_model->userData($where);
 			if (!empty($result)) {
				$password=time();//randomPassword(8);
				$template['template']=array(
					'name'=>$result['first_name'].' '.$result['last_name'],
					'password'=>$password,
				);
				$to=$result['email'];
  			$mail_message=$this->load->view('vendor/email-templates/vendor-forgot-password', $template, true);
				 $sent=sendEmail($to,'','Forgot password',$mail_message);
  			if($sent){
					$updatepassword=array(
						'id'=>$result['id'],
						'password'=>sha1($password),
					);
					$this->Common_model->updateProfile($updatepassword);
					$this->session->set_flashdata('success', 'New password sent to your email');
				}else{
					$this->session->set_flashdata('success', 'There is an error in sending mail!');
				}
				redirect('vendor-forgot-password');
			} else {
				$this->session->set_flashdata('error', 'Email Address not exists!');
			}
		}
		$this->load->view('vendor/forgot-password');
	}
	
	function logout(){
		$newdata = array(
				'vendor'  =>'',
 		);
		$this->session->unset_userdata($newdata);
		$this->session->sess_destroy();
		redirect('vendor','refresh');
	}
}
