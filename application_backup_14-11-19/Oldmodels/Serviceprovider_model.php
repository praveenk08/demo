<?php class Serviceprovider_model extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database(); 
	 }
 
	function providerServicesData($params = array()){
       // print_r($params['search']);
        $this->db->select("
        sps.id,sps.service_provider_id,sps.service_category_id,sps.name,sps.price,sps.description,sps.image,sps.status,
            sc.name as category_name
        ");
        $this->db->from('service_provider_services sps');
        $this->db->join('service_category sc','sc.id=sps.service_category_id');   
        if(count($params['where'])>0){
            $this->db->where('sc.status',1);
        }
        $this->db->where($params['where']);
        if(array_key_exists("search",$params)){
            if($params['search']['change_category']>0){
                $this->db->where('sps.service_category_id',$params['search']['change_category']);
            }
            if($params['search']['change_status']!=''){
                $this->db->where('sps.status',$params['search']['change_status']);
            }
            if($params['search']['change_search']!=''){
                 $like=array('sps.name'=>$params['search']['change_search']);
                $this->db->like($like);
            }    
        }
               
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
		}
 		$this->db->order_by('sps.id','DESC');
        $query = $this->db->get();
        return ($query->num_rows() > 0)?$query->result_array():array();
	}
}
