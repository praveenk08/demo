<?php

class Main_Controller extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model(
            array(
                'common/Common_model',
                )
            );
    }
     
    public function checkAjaxRequest($role){
        if (!$this->input->is_ajax_request() || (!$this->input->post())) {
            redirect($role, 'refresh');
        }
    }

    public function getJson($response){
        $json_data = array(
            "recordsTotal"    => $response['total'],  
            "recordsFiltered" => $response['total'],
            "data"            => $response['data'] 
        );
        echo json_encode($json_data);
    }

    public function loginCheck($check_data){
         $result = $this->Common_model->loginCheck($check_data);
         if (!empty($result)) {
            $verified=$result['verified'];
            if(!$verified){
                return false;
            }else{
                $status=$result['status'];
                if(!$status){
                    return false;
                }else{
                    return true;
                }
            }
        } else {
            return true;
         }
    }
}

 // class MY_Controller Only for Admin Panel
class MY_Controller extends Main_Controller
{
    public function __construct()
    {
        parent::__construct();
 		if (!$this->session->userdata('logged_in') || !count($this->session->userdata('admin_data'))) {
            redirect('admin', 'refresh');
        }

        $this->load->model(
            array(
                'admin/Users_model',
                'admin/Page_model',
                'admin/Category_model',
                'admin/Products_model',
                'admin/Orders_model',
                )
            );		
    }
    
    public function isAjaxRequest(){
        $this->checkAjaxRequest('admin');
    }
}


class VendorController extends Main_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || !$this->session->userdata('vendor_data') || !$this->loginCheck(array('id'=>$this->session->userdata('vendor_data')['id']))) {
		$this->session->unset_userdata(array('vendor'  =>''));
		$this->session->sess_destroy();
            redirect('vendor', 'refresh');
        }
        $this->load->model(
            array(
                'vendor/Vendor_model',
                'admin/Users_model',
                'vendor/Products_model',
                'vendor/Orders_model',
                )
            );		
    }
    
    
    public function isAjaxRequest(){
        $this->checkAjaxRequest('vendor');
    }

}


class CustomerController extends Main_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');    
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role_id')!=3 || !$this->loginCheck(array('id'=>$this->session->userdata('customer_data')['id']))) {
            $this->session->unset_userdata(array('customer_data'  =>'','url'=>'','role_id'=>''));
            $this->session->sess_destroy();
                redirect(base_url(), 'refresh');
            }
    }
    public function isAjaxRequest(){
        $this->checkAjaxRequest('customer-dashboard');
    }
}

class DeliveryboyController extends Main_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Deliveryboy_model');    
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role_id')!=4 || !$this->loginCheck(array('id'=>$this->session->userdata('delivery_boy_data')['id']))) {
            $this->session->unset_userdata(array('delivery_boy_data'  =>'','url'=>'','role_id'=>''));
            $this->session->sess_destroy();
            redirect(base_url(), 'refresh');
        }
    }
    public function isAjaxRequest(){
        $this->checkAjaxRequest('delivery-boy-dashboard');
    }
}
class ServiceproviderController extends Main_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Serviceprovider_model');    
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role_id')!=5 || !$this->loginCheck(array('id'=>$this->session->userdata('service_provider_data')['id']))) {
            $this->session->unset_userdata(array('service_provider_data'  =>'','url'=>'','role_id'=>''));
            $this->session->sess_destroy();
            redirect(base_url(), 'refresh');
        }
    }
    public function isAjaxRequest(){
        $this->checkAjaxRequest('service-provider-dashboard');
    }
}
class Web extends Main_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Website_model','Cart_model'));

        if (isset($_SESSION)){
				if( $this->session->userdata('logged_in')&& $this->session->userdata('role_id')==3) {
				$this->session->set_userdata('user_session_id',$this->session->userdata('customer_data')['id']);
				}	else { 
				if(!isset($_COOKIE["user_session_id"])) {
                $cookie_value = 'session_'.time().'_'.str_shuffle("aAi6r5wN%#7r$$3ui38wi");
                setcookie("user_session_id", $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
            }
            $this->session->set_userdata('user_session_id',$_COOKIE["user_session_id"]);
				}		
         }else{
            if(!isset($_COOKIE["user_session_id"])) {
                $cookie_value = 'session_'.time().'_'.str_shuffle("aAi6r5wN%#7r$$3ui38wi");
                setcookie("user_session_id", $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
            }
            $this->session->set_userdata('user_session_id',$_COOKIE["user_session_id"]);
         }
    }
}


