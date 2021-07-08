<?php
class Login extends CI_Controller
{
 	public function __construct()
    {
        parent::__construct();
		$this->load->model('common/Common_model');		
    }
 
	public function index(){
  		if ($this->session->userdata('admin_data')) {
            redirect('admin-dashboard', 'refresh');
        }
 		$this->form_validation->set_rules('email', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
 		if ($this->form_validation->run()== true) {
			$check_data=array(
				'email like binary'=>$this->input->post('email'),
				'password like binary'=>sha1($this->input->post('password')),
				'role_id' =>1
			 );

			$result = $this->Common_model->loginCheck($check_data);		
   			if (!empty($result)) {
				$this->Common_model->updateLogin($result['id']);
				$this->session->set_userdata('logged_in',TRUE);
 				$this->session->set_userdata($result);
				 
  				$this->session->set_userdata(array('admin_data'=>$result,'url'=>'admin-dashboard','role_id'=>$result['role_id']));
				if($this->input->post('remind_me')){
					$this->load->helper('cookie');
					//$this->input->set_cookie($result);
				}
 				redirect('admin-dashboard');
			} else {
 				$this->session->set_flashdata('err_login', 'Wrong username or password!');
			   redirect('admin');
			}
		 }
 		$this->load->view('admin/login');
	}
	//
	public function ForgotPassword(){
 		 // load form and url helpers
		 $this->load->helper(array('form', 'url'));
       
		 // load form_validation library
		 $this->load->library('form_validation');
 		if ($this->session->userdata('logged_in')) {
            redirect('admin-dashboard', 'refresh');
        }
 		$this->form_validation->set_rules('username', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		 
 		if ($this->form_validation->run()==true) {
 			$where=array('email'=>$this->input->post('username'),'role_id'=>1);
			$result = $this->Common_model->userData($where);
 			if (!empty($result)) {
				$password=time();//randomPassword(8);
				$template['template']=array(
					'name'=>$result['first_name'].' '.$result['last_name'],
					'password'=>$password,
				);
				$to=$result['email'];
  				$mail_message=$this->load->view('admin/email-templates/admin-forgot-password', $template, true);
 				$sent=sendEmail($to,'','Forgot password',$mail_message);
 				if($sent){
					$updatepassword=array(
						'id'=>$result['id'],
						'password'=>sha1($password),
					);
					//echo'<pre>';print_r($updatepassword);die;
					$this->Common_model->updateProfile($updatepassword);
					$this->session->set_flashdata('success', 'New password sent to your email');
				}else{
					$this->session->set_flashdata('success', 'There is an error in sending mail!');
				}
				redirect('admin-forgot-password');
			} else {
				$this->session->set_flashdata('error', 'Email Address not exists!');
			}
		}
		$this->load->view('admin/forgot-password');
	}
	
	function logout(){
 		$this->session->unset_userdata(array('admin_data'=>'','url'=>'','role_id'=>''));
		$this->session->sess_destroy();
 		redirect('admin','refresh');
	}
}
