<?php
class Orders extends VendorController {

	public function index()
	{
		$data['order_status']=getOrderStatus(array('status'=>1));
		$where=array('u.status'=>1,'u.is_deleted'=>0);
 		$where['u.role_id']=3;
		$data['customers']=getUserList($where);
		if(isset($_POST['export'])){
			$this->exportOrders();
		}
		$this->load->view('vendor/orders/manage-orders',$data);
	}

	public function exportOrders()
	{
		$orders=$this->Orders_model->manageOrdersExport($_POST,false);
		$filename = 'Orders_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
        $file = fopen('php://output', 'w');

        $header = array(
            "Payment Status",
            "Total Amount",
            "Total Product",
            "Coustmer Name",
            "Order Status",
            
              ); 
        fputcsv($file, $header);
        foreach ($orders as $key=>$line){ 
          fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
	}

	
	public function manageOrders(){
		$this->isAjaxRequest();
		$response['data']=$this->Orders_model->manageOrdersAjax($_POST,false);
		$response['total']=$this->Orders_model->manageOrdersAjax($_POST,true);
		$this->getJson($response);
	}
	
	public function orderDetails(){
		$this->isAjaxRequest();
 		$id=$this->input->post('id');
		$response=array();
		if($id>0){
			$response['products']=$this->Orders_model->getOrderProducts($id);
			$response['address']=$this->Common_model->getOrderAddress($id);
			$response['order_products']=$this->load->view('vendor/orders/order-details',$response,true);
			$response['order_address']=$this->load->view('vendor/orders/order-address',$response,true);
			echo json_encode($response);
		}
	}
	 

}
