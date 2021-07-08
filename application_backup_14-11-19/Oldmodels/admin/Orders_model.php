<?php class Orders_model extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database(); 
	 }
    
	public function manageOrdersAjax($post,$count=false){
	     $search=trim($post['search']);
          $status=$post['status'];
           $status=$post['status'];
           $change_date=$post['change_date'];
           $where=array();
           if($change_date!=''){
               $custom_date=customDate($post);
               $this->db->where("o.order_date >=", date('Y-m-d',strtotime($custom_date['from_date'])));
               $this->db->where("o.order_date <=", date('Y-m-d',strtotime($custom_date['to_date'])));
           }
        
		$customer_id=$post['customer_id'];
  		if($status!=''){
			$where['os.id']=$status;
		}
		if($customer_id>0){
			$where['o.customer_id']=$customer_id;
        }
        
		$like=array();
		if(strlen($search)>0){
			$like['o.order_id']=$search;
  		}
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
		//$this->db->join('product_master pm','pm.id=vp.product_id','inner');
		$this->db->join('users user','user.id=o.customer_id','inner');
 		//$this->db->join('units u','u.id=vp.unit_id','inner');
		$this->db->join('order_status os','os.id=o.order_status','inner');
 
 		if(count($where)>0){
			$this->db->where($where);
		}
		if(count($like)>0){
			$this->db->group_start();
			$this->db->or_like($like);
			$this->db->group_end();
		}
		if ($post['order'][0]['column']!='' && isset($post['order'][0]['dir']) && !empty($post['order'][0]['dir'])) {
			$order_by = '';
			switch ($post['order'][0]['column']) {
				case 2:
					$order_by = 'o.order_id';
				break;
				case 3:
                    $order_by = 'o.transaction_id';
                    break;
				case 4:
                    $order_by = "customer_name";
                    break;
				case 5:
                    $order_by = 'o.total_amount';
                    break;
				case 6:
                    $order_by = 'o.total_amount';
                    break;
				case 7:
                    $order_by = 'o.added_date';
                    break;
				case 8:
                    $order_by = 'os.name';
                    break;
				default:
                    $order_by = 'o.order_id';
                    break;
			}

			$dir_by = '';
			switch ($post['order'][0]['dir']) {

				case 'asc':
					$dir_by = 'asc';
					break;
				case 'desc':
					$dir_by = 'desc';
					break;
				default:
					$dir_by = 'asc';
					break;
			}
		$this->db->order_by($order_by,$dir_by); 
	}
	//
	if(!$count){
		$start=$post['start'];
		$length=$post['length'];
		if(!$start){
			$start=0;
		}
		if(!$length){
			$length=10;
		}
		$this->db->limit($length,$start);
	}

	$result = $this->db->get();
	$resultArray = $result->result_array();	
	if($count){
		return $result->num_rows();
	}else{
		//echo $this->db->last_query();
		return $resultArray;
	}
    }	
    
    
}
