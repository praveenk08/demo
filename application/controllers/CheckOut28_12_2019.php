<?php
class CheckOut extends Web {
	
function __construct() { 
	parent::__construct(); 
	$this->load->model('CheckOutModel');
	$this->load->model('Customer_model');	
	$this->load->model('Cart_model');	
  }
	public function index()
	{
		if($this->session->userdata('logged_in') && $this->session->userdata('customer_data')['id']>0)
		{	
			$data=array();
			$select['where']=array('ua.status'=>1,'ua.status'=>1,'ua.is_deleted'=>0,'ua.user_id'=>$this->session->userdata('customer_data')['id']);
			$select['like']=array();
			$param=array('limit'=>getSettings()['total_record_per_page']);
			$param['where']=$select['where'];
			$param['like']=array();
			$data['addressInfo']=$this->Customer_model->addressData($param);
			
			$cartwhere=array(
				'pt.abbr'=>$this->session->userdata('language'),
				'c.user_id'=>$this->session->userdata('user_session_id')
			);
			
			$data['carts']=$this->Cart_model->cartList($cartwhere);	
			
			$this->load->view('website/checkout',$data); 
		}else{
			redirect('/login?page=Cart');
		}
		
	}

	 public function payment(){
   		$payment_reference=$_POST['payment_reference'];
  		$ch = curl_init('https://www.paytabs.com/apiv2/verify_payment');
		$post_data['payment_reference']=$payment_reference;
		$post_data['merchant_email']=$this->config->item('merchant_email');
		$post_data['secret_key']=$this->config->item('secret_key');
 		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = json_decode(curl_exec($ch));
		$this->db->where('order_id',$result->reference_no);
		$customer_result=$this->db->get('orders');
		$customer_id=$customer_result->row_array()['customer_id'];
  		if($result->response_code==100){
			$this->db->where('order_id',$result->reference_no);
			$this->db->update('orders',array('transaction_id'=>$result->transaction_id,'payment_status'=>1));
			$this->db->insert('payments',array('order_id'=>$result->reference_no,'amount'=>$result->amount,'transaction_id'=>$result->transaction_id));
			$payment_id= $this->db->insert_id();	 
			$this->orderEmail($result->reference_no);
			if($payment_id){
				$this->Common_model->callBackOrderSales($customer_id,true); 
				redirect(base_url('payment-success'));
			}
 		}else{
			$this->db->where('order_id',$result->reference_no);
			$this->db->update('orders',array('transaction_id'=>$result->transaction_id,'payment_status'=>0));
			$this->Common_model->callBackOrderSales($customer_id,false); 
			redirect(base_url('payment-failure'));
		}
 	}
	
	public function success(){
		$this->load->view('website/success');
	}
	public function failure(){
		$this->load->view('website/failure');
	}
	public function createOrder(){
 		if ($this->input->is_ajax_request()) {
 			$response=array();
			$address_id=$this->input->post('address_id');
			$payment_type=$this->input->post('payment_type');
			$cart_total=$this->input->post('cart_total');
			$transactionid="";
			if($payment_type=='COD'){
				$transactionid="cod";
 				$response= $this->CheckOutModel->createOrder($address_id,$payment_type,$cart_total,$transactionid);
 				$this->orderEmail($response['order_id']);
				$this->CheckOutModel->callBackOrderSales(true); 
				$response['payment_url']=base_url('CheckOut/thanks');
				$this->db->insert('payments',array('order_id'=>$response['order_id'],'amount'=>$cart_total,'transaction_id'=>$transactionid));
				$response['status']=TRUE;
			}else{ 
 				$response=$this->CheckOutModel->createOrder($address_id,$payment_type,$cart_total,$transactionid);
				$post_data=$this->setGatewatData($response);
 				$ch = curl_init('https://www.paytabs.com/apiv2/create_pay_page');
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = json_decode(curl_exec($ch));
 				if($result->response_code==4012){
					$response['status']=TRUE;
					$response['payment_url']=$result->payment_url;
					$response['message']=$result;
 				}else{
					$response['status']=FALSE;
					$response['message']=$result;
					$response['payment_url']=base_url();
				}
			 }
			echo json_encode($response);
		}
	}

	public function setGatewatData($data){
		
		$order_data=$this->Common_model->getOrderData(array('o.order_id'=>$data['order_id']));
		$order_details=$this->Common_model->getOrderProducts($data['order_id']);

		$unit_price="";
		$quantity="";
		$title="";
		foreach($order_details as $order_detail){
			$unit_price .=$order_detail['price']." || ";
			$quantity .=$order_detail['quantity']." || ";
			$title .=$order_detail['name']." || ";
		}
 
		$response=array(
		'merchant_email'=>$this->config->item('merchant_email'),
		'secret_key'=>$this->config->item('secret_key'),
		'site_url'=>base_url(),
		'return_url'=>base_url('payment'),
		'title'=>"Order Product",
		'cc_first_name'=>$order_data['first_name'],
		'cc_last_name'=>$order_data['last_name'],
		'cc_phone_number'=>$order_data['customer_phone'],
		'phone_number'=>$order_data['phone'],
		'email'=>$order_data['email'],
		'products_per_title'=>rtrim($title," || "),
		'unit_price'=>rtrim($unit_price," || "),
		'quantity'=>rtrim($quantity," || "),
		'other_charges'=>'0',
		'amount'=>$order_data['total_amount'],
		'discount'=>$order_data['discount'],
		'currency'=>'USD',
		'reference_no'=>$data['order_id'],
		'ip_customer'=>$_SERVER['SERVER_ADDR'],
		'ip_merchant'=>$_SERVER['SERVER_ADDR'],
 		'billing_address'=>$order_data['name'].' '.$order_data['phone'].' '.$order_data['city_name'].' '.$order_data['state_name'].' '.$order_data['country_name'].' '.$order_data['zip'],
		'state'=>$order_data['state_name'],
		'city'=>$order_data['city_name'],
		'postal_code'=>$order_data['zip'],
		'country'=>$order_data['country_code'],
		'shipping_first_name'=>$order_data['first_name'],
		'shipping_last_name'=>$order_data['last_name'],
		'address_shipping'=>$order_data['name'].' '.$order_data['phone'].' '.$order_data['city_name'].' '.$order_data['state_name'].' '.$order_data['country_name'].' '.$order_data['zip'],
		'city_shipping'=>$order_data['city_name'],
		'state_shipping'=>$order_data['state_name'],
		'postal_code_shipping'=>$order_data['zip'],
		'country_shipping'=>$order_data['country_code'],
		'msg_lang'=>'English',
		'cms_with_version'=>phpversion(),
		);
  		return $response;

	}
	 

	public function orderEmail($order_id){
		if($order_id>0){
		  $response['products']=$this->Common_model->getOrderProducts($order_id);
		  $response['address']=$this->Common_model->getOrderAddress($order_id);
		  $response['order_no']=$order_id;
		  $mail_message=$this->load->view('website/email_templates/order-details',$response,true);
		  $sent=sendEmail($this->session->userdata('customer_data')['email'],"",'Order',$mail_message);
		  $this->vendorEmailManagement($order_id);
		  return $sent;
 		}
	}

	function vendorEmailManagement($order_id){
		$response['address']=$this->Common_model->getOrderAddress($order_id);
		$vendors=$this->Common_model->vendorList($order_id);
		 if(count($vendors)>0){
			 foreach($vendors as $vendor){
				 $where=array(
					 'od.vendor_id'=>$vendor['vendor_id'],
					 'pt.abbr'=>'en',
					 'od.order_id'=>$order_id,
					);
				$products=$this->Common_model->vendorOrderDetails($where);
				$response['products']=$products;
				$response['vendor_name']=$vendor['vendor_name'];
				$response['order_no']=$order_id;
				$mail_message=$this->load->view('website/email_templates/vendor-order-details',$response,true);
				$sent=sendEmail($vendor['vendor_email'],"",'Order',$mail_message);
				$total_price=0;
                $total_product_quantity=0;
				foreach($products as $product){
					$total_price +=($product['price']*$product['quantity']);
					$total_product_quantity +=$product['quantity'];
				}
				$save_data=array(
					'id'=>0,
					'vendor_id'=>$vendor['vendor_id'],
					'customer_id'=>$vendor['customer_id'],
					'total_product'=>count($products),
					'total_product_quantity'=>$total_product_quantity,
					'total_amount'=>$total_price,
				);
				$this->Common_model->addUpdateData('vendor_order_notifications',$save_data);
			 }
		 }

	}

	

	


	public function thanks()
	{
		$data=array();
		$data['order_status']=0;	
		$data['paid_status']="COD";
		$this->load->view('website/thanks',$data); 
	}
 
	


}