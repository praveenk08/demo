<?php class Deliveryboy_model extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database(); 
	}
	
	public function fetchVehicleDetails($where){
		if(count($where)){
			$this->db->where($where);
			$this->db->from('delivery_boy_vehicle_details vd');
			$result=$this->db->get();
			$response=$result->row_array();
			return $response;
		}
	}

	public function assignedOrders($params=array()){
		$this->db->select("
			o.order_id,
			o.transaction_id,
			o.customer_id,
			o.total_amount,
			o.total_product,
			o.shipping_id,
			DATE_FORMAT(o.added_date,'%d-%m-%Y %H:%i') order_date,
			CONCAT(user.first_name,' ', user.last_name) customer_name,
			os.name order_status_name,
			os.class,
			o.order_status,
		");
		$this->db->from("orders o");
		$this->db->join('delivery_boy_order_assignment dboa','dboa.order_id=o.order_id','inner');
		$this->db->join('users user','user.id=o.customer_id','inner');
		$this->db->join('order_status os','os.id=o.order_status','inner');
		if(count($params['where'])>0){
			$this->db->where($params['where']);
		}
		if(count($params['where_in'])>0){
			$this->db->where_in('o.order_status',$params['where_in']);
		}
		
		$result=$this->db->get();
		$response=$result->result_array();
		return $response;
	}
}
