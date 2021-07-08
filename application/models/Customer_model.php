<?php class Customer_model extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database(); 
	 }
 
	function customerOrders_bk($params = array()){
        $this->db->where('pt.abbr',$this->session->userdata('language'));
        $this->db->select("
            o.order_id,
            DATE_FORMAT(o.added_date,'%d-%m-%Y %H:%i') order_date,
            vp.image,
            pt.name,
            od.quantity,
            od.price,
            o.total_amount,
            os.name as order_status,
            ut.name as unit_name,
            oa.address as order_address,
            oa.block as order_block,
            oa.zip as order_zip,
        ");

        $this->db->from('orders o');
        $this->db->join('order_details od','o.order_id=od.order_id');
        $this->db->join('vendor_products vp','vp.id=od.product_id');
        $this->db->join('product_master pm','pm.id=vp.product_id');
        $this->db->join('product_translator pt','pt.vendor_product_id=vp.id');
        $this->db->join('order_address oa','oa.order_id=o.order_id');
        $this->db->join('order_status os','os.id=o.order_status');
        
        $this->db->join('units unit','vp.unit_id=unit.id','INNER');
        $this->db->join('unit_translator ut','ut.unit_id=unit.id','INNER');
        if(count($params['where'])>0){
            $this->db->where($params['where']);
        }   
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
  		$this->db->order_by('o.order_id','DESC');
        $query = $this->db->get();
       // echo $this->db->last_query();
        return ($query->num_rows() > 0)?$query->result_array():array();
    }

    function customerOrders($params = array()){
        $this->db->where('pt.abbr',$this->session->userdata('language'));
        $this->db->where('ut.abbr',$this->session->userdata('language'));
        $this->db->select("
            o.order_id,
            DATE_FORMAT(o.added_date,'%d-%m-%Y %H:%i') order_date,
            vp.image,
            vp.slug,
            pt.name,
            od.quantity,
            od.price,
            o.total_amount,
            os.name as order_status,
            ut.name as unit_name,
            oa.address as order_address,
            oa.block as order_block,
            oa.zip as order_zip,
        ");

        $this->db->from('orders o');
        $this->db->join('order_details od','o.order_id=od.order_id');
        $this->db->join('vendor_products vp','vp.id=od.product_id');
        $this->db->join('product_master pm','pm.id=vp.product_id');
        $this->db->join('product_translator pt','pt.vendor_product_id=vp.id');
        $this->db->join('order_address oa','oa.order_id=o.order_id');
        $this->db->join('order_status os','os.id=o.order_status');
        
        $this->db->join('units unit','vp.unit_id=unit.id','INNER');
        $this->db->join('unit_translator ut','ut.unit_id=unit.id','INNER');
        if(count($params['where'])>0){
            $this->db->where($params['where']);
        }   
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
  		$this->db->order_by('o.order_id','DESC');
        $query = $this->db->get();
        // echo $this->db->last_query();
        return ($query->num_rows() > 0)?$query->result_array():array();
    }

     

    function matchingAndConnections($params = array()){
        $this->db->select("
        ct.name category_name,
        ct2.name parent_category_name,
        pmc.image,
        pmc.id,
        pmc.category_id,
        pmc.status
        ");
        $this->db->from('product_matching_and_connections pmc');
        $this->db->join('category c','c.id=pmc.category_id','INNER');
        $this->db->join('category_translator ct','ct.category_id=c.id');
        $this->db->join('category_translator ct2','ct2.category_id=c.parent_id','LEFT');
        if(count($params['where'])>0){
            $this->db->where($params['where']);
        }
        if(count($params['where_in'])>0){
            $this->db->where_in('pmc.category_id',$params['where_in']);
        }
        $this->db->group_by(array('pmc.id'));
        $this->db->order_by('pmc.id','DESC');
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        return ($query->num_rows() > 0)?$query->result_array():array();
   }
    
    function addressData($params = array()){
        $this->db->select("ua.*,
         concat(u.first_name,' ',u.last_name) user_name,
         c.name as country_name,
         s.name as state_name,
         city.name as city_name
        ");

        $this->db->from('user_address ua');
        $this->db->join('users u','u.id=ua.user_id','inner');
        $this->db->join('countries c','c.id=ua.country','left');
        $this->db->join('states s','s.id=ua.state','left');
        $this->db->join('cities city','city.id=ua.city','left');
        if(count($params['where'])>0){
            $this->db->where($params['where']);
        }
        if(count($params['like'])>0){
             $this->db->group_start();
			$this->db->or_like($params['like']);
			$this->db->group_end();
        }
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
		}
 		$this->db->order_by('ua.id','DESC');
        $query = $this->db->get();
        return ($query->num_rows() > 0)?$query->result_array():array();
    }
}
