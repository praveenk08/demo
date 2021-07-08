<?php class Website_model extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database(); 
	 }

	 
	function getSliders($where){
		if(count($where)>0){
			$this->db->where($where);
			$result=$this->db->get('slider');
			$response=$result->result_array();
 			return 	$response;
		}
	}
 
	function products($params = array()){
 		$this->db->select("
		DISTINCT(vp.id) as vendor_product_id,
		vp.slug,
		pt.name,
		vp.image,
		vp.price,
		(select wish.product_id  from add_to_wishlist wish where wish.product_id=vp.id and wish.user_id='".$this->session->userdata('user_session_id')."' group by wish.user_id) as wish_product_id,
		(select cd.product_id  from cart_details cd 
		INNER JOIN add_to_cart ac ON ac.cart_id=cd.cart_id
		where cd.product_id=vp.id and ac.user_id='".$this->session->userdata('user_session_id')."' group by ac.user_id) as cd_product_id,
		(select FORMAT(AVG(rr.rating),1)  from review_rating rr where rr.vendor_product_id=vp.id and rr.status=1 and rr.is_deleted=0) as average_review,

		");
		$this->db->from('vendor_products vp');
		$this->db->join('product_master pm','pm.id=vp.product_id','INNER');
		$this->db->join('product_category pc','pc.product_id=pm.id','INNER');
		$this->db->join('product_translator pt','pt.vendor_product_id=vp.id','INNER');
		$this->db->join('users u','u.id=vp.vendor_id','INNER');
		$this->db->join('user_address ua','ua.user_id=u.id','LEFT');
		$this->db->where('pt.abbr',$this->session->userdata('language'));
 	    if(count($params['where'])>0){
			$this->db->where($params['where']);
		}
		if(count($params['where_in'])>0){
			$this->db->where_in('pc.category_id',$params['where_in']);
		}
         if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
		}
		$this->db->group_by(array('vp.id','pt.vendor_product_id','vp.product_id','ua.user_id'));
		$this->db->order_by('vp.id','DESC');
		$query = $this->db->get();
		//echo $this->db->last_query();
        return ($query->num_rows() > 0)?$query->result_array():array();
	}

	
	

	function productDetails($where){
		if(count($where)>0){
			$this->db->select("
			vp.id as vendor_product_id,
			vp.slug,
			pt.name,
			vp.quantity,
			unit.name as unit_name,
			vp.unit_value,
			vp.price,
			vp.image,
			pt.brief,
			pt.description,
 			GROUP_CONCAT(pi.image) as images,
			(select wish.product_id  from add_to_wishlist wish where wish.product_id=vp.id and wish.user_id='".$this->session->userdata('user_session_id')."') as wish_product_id,
			(select FORMAT(AVG(rr.rating),1)  from review_rating rr where rr.vendor_product_id=vp.id and rr.status=1 and rr.is_deleted=0) as average_review,
			");
			$this->db->from('vendor_products vp');
			$this->db->join('product_master pm','pm.id=vp.product_id','INNER');
			$this->db->join('product_category pc','pc.product_id=pm.id','INNER');
			$this->db->join('product_translator pt','pt.vendor_product_id=vp.id','INNER');
			$this->db->join('users u','u.id=vp.vendor_id','INNER');
			$this->db->join('units unit','unit.id=vp.unit_id','INNER');
			$this->db->join('product_images pi','pi.vendor_product_id=vp.id','LEFT');
  			$this->db->where('pt.abbr',$this->session->userdata('language'));
			$this->db->where($where);
			$this->db->group_by('vp.id');
			$result = $this->db->get();
			$response=$result->row_array();
          	return $response;
		}
		
	}
	

	function servicesList($params = array()){
		$this->db->select("
		sps.id,
		sps.service_provider_id,
		sps.service_category_id,
		sps.name,
		sps.slug,
		sps.image,
		CONCAT(u.first_name,' ',u.last_name) as provider_name,
		sps.price,
		sps.description,
		sps.image,
		sps.status,
		sc.name as category_name
		");
		$this->db->from('service_provider_services sps');
		$this->db->join('service_category sc','sc.id=sps.service_category_id');
		$this->db->join('users u','u.id=sps.service_provider_id','INNER');
		$this->db->join('user_address ua','ua.user_id=u.id','LEFT');

 	    if(count($params['where'])>0){
			$this->db->where($params['where']);
		}
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
		}
		$this->db->group_by(array('sps.id'));
		$this->db->order_by('sps.id','DESC');
		$query = $this->db->get();
        return ($query->num_rows() > 0)?$query->result_array():array();
	}

	function test(){
		$this->db->select('*, 
		111.1111*DEGREES(acos( cos( radians('.$clat.') ) * cos( radians( pp.location_lat ) ) * cos( radians( '.$clng.' ) - radians(pp.location_lng) ) + sin( radians('.$clat.') ) * sin( radians(pp.location_lat ) ) ) ) as from_distance');
	 }
	function growerList($params = array()){
		if(!empty($params['latitude'])){
			$this->db->select('u.id,u.slug,u.first_name,u.last_name,u.firm_description,u.image,ua.address,ua.zip,pc.category_id, 111.1111*DEGREES(acos( cos( radians('.$params['latitude'].') ) * cos( radians( ua.latitude ) ) * cos( radians( '.$params['longitude'].' ) - radians(ua.longitude) ) + sin( radians('.$params['latitude'].') ) * sin( radians(ua.latitude ) ) ) ) as from_distance');
			$this->db->having('from_distance <', '50');
		}else{
			$this->db->select("u.id,u.slug,u.first_name,u.last_name,u.firm_description,u.image,ua.address,ua.zip,pc.category_id");
		}
 		$this->db->from('users u');
		$this->db->join('vendor_products vp','vp.vendor_id=u.id','INNER');
		$this->db->join('product_master pm','pm.id=vp.product_id','INNER');
		$this->db->join('product_category pc','pc.product_id=pm.id','INNER');
		$this->db->join('user_address ua','ua.user_id=u.id','LEFT');
		
 
    	if(count($params['where'])>0){
            $this->db->where($params['where']);
		}
		
		if(count($params['where_in'])>0){
            $this->db->where_in('pc.category_id',$params['where_in']);
		}

		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
		}
		$this->db->group_by('u.id');
		$this->db->order_by('u.id','DESC');
		$query = $this->db->get();
         return ($query->num_rows() > 0)?$query->result_array():array();
	}

	
	
	function cartQuantity($product_id){
		$this->db->from('add_to_cart c');
		$this->db->join('cart_details cd ','cd.cart_id=c.cart_id','INNER');
		$this->db->where('c.user_id',$this->session->userdata('user_session_id'));
		$this->db->where('cd.product_id',$product_id);
		$result=$this->db->get();
		$response=$result->row_array()['quantity'];
		return $response ? $response:1;
	}
	function subscribe($insertData){
		$this->db->where('email',$insertData['email']);
		$query=$this->db->get('subscribers');
 		$total=$query->num_rows();
		if(!$total){
			$this->db->insert('subscribers',$insertData);
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	

	public function getAllCategoriesParentList($category_id){
		if(!empty($category_id)){
			$result=$this->db->query("SELECT group_concat(c.id) as categories FROM ( SELECT @r AS _id, (SELECT @r := parent_id FROM category WHERE id = _id) AS parent_id, @l := @l + 1 AS level FROM (SELECT @r := ".$category_id.", @l := 0) vars, category m WHERE @r <> 0) d JOIN category c ON d._id = c.id");
			$response=$result->row_array();
			return $response;
		}
	 }
	 
	 public function getAllChildCategoriesList($category_id){
		if(!empty($category_id)){
			$result=$this->db->query("select group_concat(id) as categories from (select * from category order by parent_id, id) category, (select @pv := ".$category_id.") initialisation where find_in_set(parent_id, @pv) > 0 and @pv := concat(@pv, ',', id )");
			$response=$result->row_array();
			return $response;
		}
	 }

	 public function getReviews($where){
		$this->db->select("
		rr.id,
		rr.rating,
		rr.review,
		DATE_FORMAT(rr.created_date,'%d-%m-%Y %H:%i') added_date,
		CONCAT(u.first_name,' ',u.last_name) customer_name
		");
		$this->db->from('review_rating rr');
		$this->db->join('users u','rr.customer_id=u.id');
		$this->db->where($where);
		$result=$this->db->get();
		$response=$result->result_array();
		return $response;
	 }
 
	
	 

}
