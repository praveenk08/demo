<?php
class Dashboard extends MY_Controller
{
	public function index(){
		$crop_sections=array('products','teams','sliders','users');
		foreach($crop_sections as $crop_section){
			$src = "./attachments/".$crop_section."/thumb"; 
			$dst = "./attachments/".$crop_section."/".$this->session->userdata('admin_data')['id']; 
			customCopy($src, $dst);
		}
		$order_data=$this->Common_model->getVendorTotalSalesOrders();
		$data['response']['total_orders']=$order_data['total_orders'];
		$data['response']['total_sales']=$order_data['total_sales'];
		$data['response']['total_customers']=count(getUserList(array('u.is_deleted'=>0,'u.role_id'=>3)));
		$where=array('pm.is_deleted'=>0,'vp.is_deleted'=>0,'pt.abbr'=>'en','ut.abbr'=>'en');
		$data['response']['total_products']=count($this->Common_model->getTotalProducts($where));
		$data['response']['total_order_notifications']=$this->Common_model->getVendorTotalOrderNotifications(array('von.viewed'=>0));
		$data['response']['total_notifications']=$this->Common_model->getVendorTotalNotifications(array('cns.is_deleted'=>0));
		$order_data2=$this->Common_model->getVendorTotalSalesOrders(array('o.order_status'=>5));
		$data['response']['total_shipped_orders']=$order_data2['total_orders'];

		$visitor_where=array(
 			'pm.status'=>1,
			'pm.is_deleted'=>0,
			'pt.abbr'=>'en',
			'ut.abbr'=>'en',
			'vp.is_deleted'=>0
			);

		$data['response']['total_visitors']=$this->Common_model->getTotalVisitors($visitor_where);
 		$this->load->view('admin/dashboard',$data);
	}

	
	
	 
}
