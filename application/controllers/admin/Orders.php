<?php

class Orders extends MY_Controller {
	public function index()
	{
		$data['order_status']=getOrderStatus(array('status'=>1));
		$where=array('u.status'=>1,'u.is_deleted'=>0);
 		$where['u.role_id']=3;
		$data['customers']=getUserList($where);

		if(isset($_POST['export'])){
			$this->exportorders();
		}
 	 	$this->load->view('admin/orders/manage-orders',$data);
	}
		public function exportOrders()
		{


			$orders= $this->Orders_model->manageOrdersExport($_POST , false);
			//echo"<pre>"; print_r($orders); die;
   			$filename = 'Order_list'.date('d-m-Y m-i-s').'.csv'; 
	        header("Content-Description: File Transfer"); 
	        header("Content-Disposition: attachment; filename=$filename"); 
	        header("Content-Type: application/csv; ");
	      
	        // file creation 
	        $file = fopen('php://output', 'w');

	        $header = array(
	            "Total Amount",
	            "Total Products",
	            "Order Status",
	            "Payment Status",
	            "Order Date",
	            "Coustmer Name",
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
			$response['products']=$this->Common_model->getOrderProducts($id);
			$response['address']=$this->Common_model->getOrderAddress($id);
			$response['order_products']=$this->load->view('admin/orders/order-details',$response,true);
			$response['order_address']=$this->load->view('admin/orders/order-address',$response,true);
			echo json_encode($response);
		}
	}

	function generatePdf($id=1063){
 
			$pdfFilePath = "output_pdf_name.pdf";
			//load mPDF library
			$this->load->library('m_pdf');
			$response['products']=$this->Common_model->getOrderProducts($id);
			$response['address']=$this->Common_model->getOrderAddress($id);
			$html='<table class="table table-dark table-striped"  id="order_details_table">';
			$html .=$this->load->view('admin/orders/order-details',$response,true);
			$html .='</table>';
			$html .='<table class="table table-dark table-striped"  id="order_details_table">';
			$html .=$this->load->view('admin/orders/order-address',$response,true);
			$html .='</table>';
			$this->m_pdf->pdf->WriteHTML($html);
			$this->m_pdf->pdf->Output(); // opens in browser
 
	}

	public function changeOrderStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		$selected_delivery_boy=$this->input->post('selected_delivery_boy');
 		if($id>0){
			$update_data=array('order_id'=>$id,'order_status'=>$status);
			$this->db->where('order_id',$id);
			$response['status']=$this->db->update('orders',$update_data);
			$this->db->where('order_id',$id);
			$this->db->update('vendor_order_notifications',array('viewed'=>1));
  			if($response['status']){
				if($status==3){
					$this->db->where(array('order_id'=>$id,'delivery_boy_id'=>$selected_delivery_boy));
					$result=$this->db->get('delivery_boy_order_assignment');
					$total=count($result->result_array());
					if(!$total){
						$this->db->insert('delivery_boy_order_assignment',array('order_id'=>$id,'delivery_boy_id'=>$selected_delivery_boy));
					}
				}
				$response['message']="Order Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>20,
					'reference_id'=>$id,
					'action'=>'Updated',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
			}
 			echo json_encode($response);
		}
	}

	public function manageTransactions()
	{
 		$where=array('u.status'=>1,'u.is_deleted'=>0);
 		$where['u.role_id']=3;
		$data['customers']=getUserList($where);
 	 	$this->load->view('admin/orders/manage-transactions',$data);
	}

	
	public function manageTransactionsAjax(){
		$this->isAjaxRequest();
	   	$response['data']=$this->Orders_model->manageTransactionsAjax($_POST,false);
		$response['total']=$this->Orders_model->manageTransactionsAjax($_POST,true);
	   	$this->getJson($response);
   }


}
