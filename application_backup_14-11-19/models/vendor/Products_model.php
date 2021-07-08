<?php class Products_model extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database(); 
	 }
 
	
	public function productData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select("
			pm.id as master_product_id,
			pm.name,
			pm.sku,
 			vp.meta_title,
			vp.meta_keywords,
			vp.meta_description,
 			u.name as unit_name,
			vp.quantity,
			DATE_FORMAT(vp.maturity_date, '%d-%m-%Y') maturity_date,
			vp.id,
			vp.price,
			vp.unit_id,
			vp.unit_value,
			vp.vendor_id,
			vp.weight,
			vp.image,
			vp.status,
			vp.added_date ,
			CONCAT(user.first_name,' ',user.last_name	) as vendor_name,
			pc.category_id,
			c.name as product_category_name,
		");
		$this->db->from('vendor_products vp');
		$this->db->join('product_master pm','pm.id=vp.product_id','inner');
		$this->db->join('users user','user.id=vp.vendor_id','inner');
 		$this->db->join('units u','u.id=vp.unit_id','inner');
		$this->db->join('product_category pc','pc.product_id=pm.id','left');
		$this->db->join('category c','c.id=pc.category_id','left');
		$result=$this->db->get();
		$response=$result->row_array();
		return $response;
		}
	}

	public function productNamedata($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select("
			pt.id,
			pt.vendor_product_id,
			pt.	product_id,
			pt.vendor_id,
			pt.abbr,
			pt.name,
			pt.brief,
			pt.description,
			l.name as language_name
		");
		$this->db->from('vendor_products vp');
		$this->db->join('product_translator pt','pt.vendor_product_id=vp.id','inner');
		$this->db->join('languages l','l.abbr=pt.abbr','inner');
 		 $result=$this->db->get();
			$response=$result->result_array();
			return $response;
		}
	}
	public function productSecondaryImagesData($where=array()){
		if(count($where)>0){
			$this->db->where($where);
		}
		$this->db->from('product_images');
		$result=$this->db->get();
		$response=$result->result_array();
		return $response;
	}
	public function manageProductsAjax($post,$count=false){
		$search=trim($post['search']);
		$status=$post['status'];
 		$unit_id=$post['unit_id'];
		$where['pm.status']=1;
		$where['pm.is_deleted']=0;
		$where['pt.abbr']='en';
		$where['vp.is_deleted']=0;
		$where['vp.vendor_id']=$this->session->userdata('vendor_data')['id'];

  		if($status!=''){
			$where['vp.status']=$status;
		}
		   
		if($unit_id>0){
			$where['vp.unit_id']=$unit_id;
		}    
		$like=array();
		if(strlen($search)>0){
			$like['pt.name']=$search;
			 
			// $like['pm.meta_title']=$search;
			//$like['pm.meta_keywords']=$search;
			//$like['pm.meta_description']=$search;
			$like['vp.quantity']=$search;
			$like['vp.price']=$search;
 		}
		$this->db->select("
			pt.name,
  			u.name as unit_name,
			vp.quantity,
			vp.id,
			vp.totalsale,
			vp.image,
			vp.price,
			vp.weight,
 			vp.status,
			CONCAT(user.first_name,' ',user.last_name	) as vendor_name
		");
		$this->db->from('vendor_products vp');
		$this->db->join('product_master pm','pm.id=vp.product_id','inner');
		$this->db->join('product_translator pt','pt.vendor_product_id=vp.id','inner');
		$this->db->join('languages l','l.abbr=pt.abbr','inner');
		$this->db->join('users user','user.id=vp.vendor_id','inner');
 		$this->db->join('units u','u.id=vp.unit_id','inner');
  
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
					$order_by = 'pm.name';
					break;
				case 3:
					$order_by = 'vp.totalsale';
					break;
				case 4:
					$order_by = 'vp.quantity';
					break;
				case 5:
					$order_by = 'vp.price';
					break;
				case 6:
					$order_by = 'vp.status';
					break;
				default:
					$order_by = 'vp.id';
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

		public function manageProductsExport($post,$count=false){
		$search=trim($post['search']);
		$status=$post['change_status'];
 		$unit_id=$post['change_unit'];
		$where['pm.status']=1;
		$where['pm.is_deleted']=0;
		$where['pt.abbr']='en';
		$where['vp.is_deleted']=0;
		$where['vp.vendor_id']=$this->session->userdata('vendor_data')['id'];

  		if($status!=''){
			$where['vp.status']=$status;
		}
		   
		if($unit_id>0){
			$where['vp.unit_id']=$unit_id;
		}    
		$like=array();
		if(strlen($search)>0){
			$like['pt.name']=$search;
			 
			// $like['pm.meta_title']=$search;
			//$like['pm.meta_keywords']=$search;
			//$like['pm.meta_description']=$search;
			$like['vp.quantity']=$search;
			$like['vp.price']=$search;
 		}
		$this->db->select("
			pt.name,
  			u.name as unit_name,
			vp.quantity,
			vp.totalsale,
			vp.price,
 			vp.status,
			CONCAT(user.first_name,' ',user.last_name	) as vendor_name
		");
		$this->db->from('vendor_products vp');
		$this->db->join('product_master pm','pm.id=vp.product_id','inner');
		$this->db->join('product_translator pt','pt.vendor_product_id=vp.id','inner');
		$this->db->join('languages l','l.abbr=pt.abbr','inner');
		$this->db->join('users user','user.id=vp.vendor_id','inner');
 		$this->db->join('units u','u.id=vp.unit_id','inner');
  
 		if(count($where)>0){
			$this->db->where($where);
		}
		if(count($like)>0){
			$this->db->group_start();
			$this->db->or_like($like);
			$this->db->group_end();
		}
		
		return $result = $this->db->get()->result_array();
	
		}	


	public function manageReviewsExport($post,$count=false){
		$search=trim($post['search']);
		$rating=$post['change_rating'];
		$status=$post['change_status'];
		$where['r.is_deleted']=0;
		if($status!=''){
			$where['r.status']=$status;
		}
		if($rating>0){
			$where['r.rating']=$rating;
		}    
		$like=array();
		if(strlen($search)>0){
			$like['r.review']=$search;
			$like['r.title']=$search;
			$like['u.first_name']=$search;
			$like['u.last_name']=$search;
 		}
		$this->db->select("r.review, CONCAT(u.first_name,' ',u.last_name) customer_name,CONCAT(vendor.first_name,' ',vendor.last_name) vendor_name");
		$this->db->from('review_rating r');
		$this->db->join('users u' ,'u.id=r.customer_id','left');
		$this->db->join('vendor_products vp' ,'vp.id=r.vendor_product_id','left');
		$this->db->join('users vendor' ,'vendor.id=vp.vendor_id','left');
 		if(count($where)>0){
			$this->db->where($where);
		}
		if(count($like)>0){
			$this->db->group_start();
			$this->db->or_like($like);
			$this->db->group_end();
		}
		return $result = $this->db->get()->result_array();

		}	

}
