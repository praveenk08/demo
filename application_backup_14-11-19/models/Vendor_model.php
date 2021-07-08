<?php class Vendor_model extends CI_Model
{
	function __construct() { 
		parent::__construct(); 
 		$this->load->database(); 
	 }

	public function loginCheck($values)
	{
	 	$arr = array(
			'username' => $values['username'],
			'password' => sha1($values['password']),
			'status' => 1,
		);
 		$this->db->where($arr);
		$result = $this->db->get('admin');
		$resultArray = $result->row_array();
		
		if ($result->num_rows() > 0) {
			$this->db->where('id', $resultArray['id']);
			$this->db->update('admin', array('last_login' => time()));
		}
		return $resultArray;
	}
	function adminData($where){
		if(count($where)>0){
			$this->db->where($where);
			$query=$this->db->get('admin');
			$total_rows=$query->num_rows();
			if($total_rows==1){
				return 	$query->row_array();
			}
		}
		
	}
	
	function adminUpdateProfile($update_data){
		if(count($update_data)>0){
			$this->db->where('id',$update_data['id']);
			$result=$this->db->update('admin',$update_data);
			return $result;
		}
	}
	public function adminChangePassword($update_data){
		if(count($update_data)>0){
			$this->db->where('id',$update_data['id']);
			$this->db->where('password',$update_data['password']);
			$query=$this->db->get('admin');
			$total_rows=$query->num_rows();
			if($total_rows==1){
				$this->db->where('id',$update_data['id']);
				$this->db->where('password',$update_data['password']);
				$result=$this->db->update('admin',array('password'=>$update_data['new_password']));
				return $result;
			}
			return false;
		}
	}
// SaveAndUpdate Common

public function AddUpdateData($table,$save_data){
	if(!empty($table) && count($save_data)>0){
		if($save_data['id']>0){
			$this->db->where('id',$save_data['id']);
			$this->db->update($table,$save_data);
			  return $save_data['id'];
		}else{
			$this->db->insert($table,$save_data);
			  return $this->db->insert_id();
		}
	}
}
public function checkExist($table,$where){
	if(!empty($table) && count($where)>0){
		$this->db->where($where);
		$result=$this->db->get($table);
		$total_rows=$result->num_rows();
		if(!$total_rows){
			return true;
		}
		return false;
	}
}
}
