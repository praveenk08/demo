<?php class Orders_model extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database(); 
	 }
     
	public function manageOrdersAjax($post,$count=false){ 
 	     $search=trim($post['search']);
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
           
		$where['od.vendor_id']=$this->session->userdata('vendor_data')['id'];
        
		$like=array();
		if(strlen($search)>0){
			$like['o.order_id']=(int)$search;
  		}
		$this->db->select("
            o.order_id,
            o.transaction_id,
            o.customer_id,
            o.payment_status,
            sum(od.price*od.quantity) total_amount,
            sum(od.quantity) total_product,
            o.shipping_id,
            DATE_FORMAT(o.added_date,'%d-%m-%Y %H:%i') order_date,
            CONCAT(user.first_name,' ', user.last_name) customer_name,
			os.name order_status,
            os.class
		");
		$this->db->from("orders o");
		$this->db->join('order_details od','od.order_id=o.order_id','inner');
		$this->db->join('users user','user.id=o.customer_id','inner');
 		$this->db->join('order_status os','os.id=o.order_status','inner');
 
 		if(count($where)>0){
			$this->db->where($where);
		}
		if(count($like)>0){
			$this->db->group_start();
			$this->db->or_like($like);
			$this->db->group_end();
          }
          $this->db->group_by('o.order_id');
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
                    $order_by = 'customer_name';
                    break;
				case 5:
                    $order_by = 'total_product';
                    break;
				case 6:
                    $order_by = 'total_amount';
                    break;
				case 7:
                    $order_by = 'order_date';
                    break;
				case 8:
                    $order_by = 'o.payment_status';
					break;
				case 8:
                    $order_by = 'order_status';
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
 		return $resultArray;
	}
    }	
	

public function manageOrdersExport($post,$count=false){ 
	     $search=trim($post['search']);
          $status=$post['change_status'];
           $change_date=$post['change_date'];
           $where=array();
           if($change_date!=''){
			$custom_date=customDate($post);
               $this->db->where("DATE_FORMAT(o.added_date,'%d-%m-%Y') >=", $custom_date['from_date']);
               $this->db->where("DATE_FORMAT(o.added_date,'%d-%m-%Y') <=", $custom_date['to_date']);
          }
        
		// $customer_id=$post['customer_id'];
  // 		if($status!=''){
		// 	$where['os.id']=$status;
		// }
		// if($customer_id>0){
		// 	$where['o.customer_id']=$customer_id;
  //         }
           
		$where['od.vendor_id']=$this->session->userdata('vendor_data')['id'];
        
		$like=array();
		if(strlen($search)>0){
			$like['o.order_id']=(int)$search;
  		}
		$this->db->select("
            o.payment_status,
            sum(od.price*od.quantity) total_amount,
            sum(od.quantity) total_product,
            CONCAT(user.first_name,' ', user.last_name) customer_name,
			os.name order_status,
            
		");
		$this->db->from("orders o");
		$this->db->join('order_details od','od.order_id=o.order_id','inner');
		$this->db->join('users user','user.id=o.customer_id','inner');
 		$this->db->join('order_status os','os.id=o.order_status','inner');
 
 		if(count($where)>0){
			$this->db->where($where);
		}
		if(count($like)>0){
			$this->db->group_start();
			$this->db->or_like($like);
			$this->db->group_end();
          }
        	  $this->db->group_by('o.order_id');
					return $result = $this->db->get()->result_array();
    		}	
	

    public function getOrderProducts($id){
        if($id>0){
		  $this->db->where('od.order_id',$id);
		  $this->db->where('pt.abbr','en');
          $this->db->where('od.vendor_id',$this->session->userdata('vendor_data')['id']);
          $this->db->where('ct.abbr','en');
          $this->db->where('ct2.abbr','en');
          $this->db->select("
            pt.name,
            vp.image,
            od.quantity,
            od.price,
            CONCAT(user.first_name,' ', user.last_name) vendor_name,
            ct.name category_name,
 			ct2.name parent_category_name,
            ");
            $this->db->from('order_details od');
            $this->db->join('vendor_products vp','vp.id=od.product_id');
            $this->db->join('product_master pm','pm.id=vp.product_id');
			$this->db->join('users user','user.id=vp.vendor_id','inner');
			$this->db->join('product_translator pt','pt.vendor_product_id=vp.id','INNER');
			$this->db->join('product_category pc', 'pc.product_id = pm.id', 'inner');
			$this->db->join('category c', 'c.id = pc.category_id', 'inner');
			$this->db->join('category_translator ct', 'ct.category_id = c.id', 'inner');
			$this->db->join('category_translator ct2', 'ct2.category_id = c.parent_id', 'left');
            $result=$this->db->get();
		  $response=$result->result_array();
            return $response;
        }
    }
    public function getOrderAddress($id){
     if($id>0){
         $this->db->where('oa.order_id',$id);
         $this->db->select("
         oa.*,
         ");
         $this->db->from('order_address oa');
          $result=$this->db->get();
         $response=$result->row_array();
         return $response;
     }
 }
}
