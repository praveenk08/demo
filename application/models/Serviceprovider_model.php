<?php class Serviceprovider_model extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database(); 
	 }
 
	function providerServicesData($params = array()){
       // print_r($params['search']);
        $this->db->select("
        sps.id,sps.service_provider_id,sps.service_category_id,spst.name,sps.price,spst.description,sps.image,sps.status,
        sct.name as category_name
        ");
        $this->db->from('service_provider_services sps');
        $this->db->join('service_provider_service_translator spst','sps.id=spst.service_id','INNER');
        $this->db->join('service_category sc','sc.id=sps.service_category_id','INNER');
        $this->db->join('service_category_translator sct','sc.id=sct.category_id','INNER');
           
        if(count($params['where'])>0){
            $this->db->where('sc.status',1);
        }
        $this->db->where($params['where']);
        $this->db->where('spst.abbr',$this->session->userdata('language'));
        $this->db->where('sct.abbr',$this->session->userdata('language'));
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
    
    
    public function getServiceNameData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select("spst.name,spst.description,spst.abbr");
			$this->db->from('service_provider_services sps');
			$this->db->join('service_provider_service_translator spst','sps.id=spst.service_id','INNER');
			$result=$this->db->get();
			$response=$result->result_array();
			return $response;
		}
	}
}
