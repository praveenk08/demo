<?php class Page_model extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database(); 
	 }
 

	public function managePagesAjax($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['status'];
		$where['p.is_deleted']=0;
		$where['pt.abbr']='en';
		 if($status!=''){
			$where['p.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['pt.name']=$search;
			$like['pt.meta_title']=$search;
			$like['pt.meta_keywords']=$search;
			$like['pt.meta_description']=$search;
			$like['pt.description']=$search;
		}
		$this->db->select('p.id,p.slug,p.image,p.banner_image,p.featured,p.status,pt.name,pt.meta_title,pt.meta_keywords,pt.meta_description,pt.description,pt.banner_title');
		$this->db->from('cms_pages p');
		$this->db->join('page_translator pt','pt.page_id=p.id','INNER');
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
				case 1:
					$order_by = 'pt.name';
					break;
				case 2:
					$order_by = 'pt.meta_title';
					break;
				case 3:
					$order_by = 'pt.status';
					break;
				default:
					$order_by = 'p.id';
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

	public function managepagesExport($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['change_status'];
		$where['p.is_deleted']=0;
		if($status!=''){
			$where['p.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['p.name']=$search;
			$like['p.meta_title']=$search;
			$like['p.meta_keywords']=$search;
			$like['p.meta_description']=$search;
			$like['p.description']=$search;
		}
		$this->db->select('p.name , p.meta_title , p.meta_keywords , p.status ');
		$this->db->from('cms_pages p');
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
 
 	
	public function manageTeamsAjax($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['status'];
		 $where['ot.is_deleted']=0;
		 $where['ott.abbr']='en';
		 if($status!=''){
			$where['ot.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['ott.name']=$search;
			$like['ott.designation']=$search;
			$like['ott.description']=$search;
 		}
		$this->db->select('ot.*,ott.name,ott.designation,ott.description');
		$this->db->from('our_team ot');
		$this->db->join('our_team_translator ott','ott.team_id=ot.id','INNER');
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
				case 1:
					$order_by = 'ott.name';
					break;

				case 2:
					$order_by = 'ott.designation';
					break;

				case 4:
					$order_by = 'ot.status';
					break;
			 
				default:
					$order_by = 'ot.id';
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

	public function manageTeamsExport($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['change_status'];
		$where['ot.is_deleted']=0;
		if($status!=''){
			$where['ot.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['ot.name']=$search;
			$like['ot.designation']=$search;
			$like['ot.description']=$search;
 		}
		$this->db->select('ot.name , ot.designation , ot.status , ot.added_date');
		$this->db->from('our_team ot');
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


 	
	public function manageOurServicesAjax($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['status'];
	    $where['os.is_deleted']=0;
		$where['ost.abbr']='en';
		 
		if($status!=''){
			$where['os.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['ost.name']=$search;
 			$like['ost.description']=$search;
 		}
		$this->db->select('os.*,ost.name,ost.description');
		$this->db->from('our_services os');
		$this->db->join('our_services_translator ost','ost.service_id=os.id','INNER');
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
				case 1:
					$order_by = 'ost.name';
					break;

				case 2:
					$order_by = 'ost.description';
					break;

				case 4:
					$order_by = 'os.status';
					break;
			 
				default:
					$order_by = 'os.id';
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

	public function manageServicesExport($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['change_status'];
		$where['os.is_deleted']=0;
		if($status!=''){
			$where['os.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['os.name']=$search;
 			$like['os.description']=$search;
 		}
		$this->db->select('os.*');
		$this->db->from('our_services os');
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


 	
	public function manageWorkProcessAjax($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['status'];
		 $where['wp.is_deleted']=0;
		 $where['wpt.abbr']='en';
		 if($status!=''){
			$where['wp.status']=$status;
		}

		$like=array();
		if(strlen($search)>0){
			$like['wp.name']=$search;
		}
		  
		$this->db->select('wp.*,wpt.name');
		$this->db->from('work_process wp');
		$this->db->join('work_process_translator wpt','wpt.process_id=wp.id');
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
				case 1:
					$order_by = 'wpt.name';
					break;

				case 3:
					$order_by = 'wp.sort_id';
					break;
				case 4:
					$order_by = 'wp.status';
					break;
			 
				default:
					$order_by = 'wp.id';
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
	


	public function manageWorkProcessExport($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['change_status'];
		$where['wp.is_deleted']=0;
		if($status!=''){
			$where['wp.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['wp.name']=$search;
  		}
		$this->db->select('wp.name ,wp.description,wp.status,wp.added_date');
		$this->db->from('work_process wp');
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


	public function manageFacilitiesAjax($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['status'];
		 $where['f.is_deleted']=0;
		 $where['ft.abbr']='en';
		 
		if($status!=''){
			$where['f.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['ft.name']=$search;
  		}
		$this->db->select('f.*,ft.name');
		$this->db->from('facilities f');
		$this->db->join('facilities_translator ft','ft.facility_id=f.id','INNER');
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
				case 1:
					$order_by = 'ft.name';
					break;

				case 3:
					$order_by = 'f.sort_id';
					break;
				case 4:
					$order_by = 'f.status';
					break;
			 
				default:
					$order_by = 'f.id';
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


public function manageFacilitiesExport($post,$count=false){
		$search=trim($post['search']);
 		$status=$post['change_status'];
		$where['f.is_deleted']=0;
		if($status!=''){
			$where['f.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['f.name']=$search;
  		}
		$this->db->select('f.name,f.description,f.status,f.added_date');
		$this->db->from('facilities f');
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


	public function manageEmailTemplatesAjax($post,$count=false){
		$search=trim($post['search']);
		$where=array();
 		//$status=$post['status'];
 		//if($status!=''){
			//$where['e.status']=$status;
		//}  
		$like=array();
		if(strlen($search)>0){
			$like['e.name']=$search;
			$like['e.subject']=$search;
			$like['e.welcome_heading']=$search;
			$like['e.welcome_message']=$search;
			$like['e.message_description']=$search;
		}
		   
		$this->db->select('e.*');
		$this->db->from('email_templates e');
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
				case 1:
					$order_by = 'e.name';
					break;

				case 3:
					$order_by = 'e.name';
				break;
				case 4:
					$order_by = 'e.name';
				break;
			 
				default:
					$order_by = 'e.id';
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


	public function manageEmailTemplatesExport($post,$count=false){
		$search=trim($post['search']);
		$where=array();
 		//$status=$post['status'];
 		//if($status!=''){
			//$where['e.status']=$status;
		//}  
		$like=array();
		if(strlen($search)>0){
			$like['e.name']=$search;
			$like['e.subject']=$search;
			$like['e.welcome_heading']=$search;
			$like['e.welcome_message']=$search;
			$like['e.message_description']=$search;
		}
		   
		$this->db->select('e.name, e.subject, e.welcome_heading,e.welcome_message,e.message_description');
		$this->db->from('email_templates e');
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


	public function manageCalculationAjax($post,$count=false){
		$search=trim($post['search']);
		$where=array();
		$status=$post['status'];
		$where['c.is_deleted']=0;
		$where['ct.abbr']='en';

 		if($status!=''){
			$where['c.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['ct.name']=$search;
			$like['c.value']=$search;
 		}
		   
		$this->db->select('c.*,ct.name');
		$this->db->from('calculations c');
		$this->db->join('calculation_translator ct','ct.calculation_id=c.id','INNER');
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
					$order_by = 'ct.name';
					break;
				case 3:
					$order_by = 'c.value';
				break;

				case 4:
					$order_by = 'c.sort_id';
				break;
			 
				case 5:
					$order_by = 'c.status';
				break;
			 
				default:
					$order_by = 'c.id';
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


	public function manageCalculationExport($post,$count=false){
		$search=trim($post['search']);
		$where=array();
		$status=$post['change_status'];
		$where['c.is_deleted']=0;

 		if($status!=''){
			$where['c.status']=$status;
		}  
		$like=array();
		if(strlen($search)>0){
			$like['c.title']=$search;
			$like['c.value']=$search;
 		}
		   
		$this->db->select('c.title ,c.value ,c.status , c.added_date');
		$this->db->from('calculations c');
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

	public function getCalculationData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select("ct.name,ct.slug,ct.abbr");
			$this->db->from('calculations c');
			$this->db->join('calculation_translator ct','c.id=ct.calculation_id','INNER');
			$result=$this->db->get();
			$response=$result->result_array();
			return $response;
		}
	}

	public function getOurServicesData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select("ost.slug,ost.abbr,ost.name,ost.description");
			$this->db->from('our_services os');
			$this->db->join('our_services_translator ost','os.id=ost.service_id','INNER');
			$result=$this->db->get();
			$response=$result->result_array();
			return $response;
		}
	}

	public function getOurTeamData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select("ot.id,ot.status,ot.image,ott.abbr,ott.name,ott.designation,ott.description");
			$this->db->from('our_team ot');
			$this->db->join('our_team_translator ott','ot.id=ott.team_id','INNER');
			$result=$this->db->get();
			$response=$result->result_array();
			return $response;
		}
	}

	public function getWorkProcessData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select("wpt.name,wpt.abbr");
			$this->db->from('work_process wp');
			$this->db->join('work_process_translator wpt','wp.id=wpt.process_id','INNER');
			$result=$this->db->get();
			$response=$result->result_array();
			return $response;
		}
	}

	public function getPageNameData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select("pt.abbr,pt.name,pt.meta_title,pt.meta_keywords,pt.meta_description,pt.description,pt.banner_title");
			$this->db->from('cms_pages p');
			$this->db->join('page_translator pt','p.id=pt.page_id','INNER');
			$result=$this->db->get();
			$response=$result->result_array();
			return $response;
		}
	}

	public function getFacilityNameData($where){
		if(count($where)>0){
			$this->db->where($where);
			$this->db->select("ft.name,ft.abbr");
			$this->db->from('facilities f');
			$this->db->join('facilities_translator ft','f.id=ft.facility_id','INNER');
			$result=$this->db->get();
			$response=$result->result_array();
			return $response;
		}
	}
	
	

	
	

}
