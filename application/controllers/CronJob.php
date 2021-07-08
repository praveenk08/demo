<?php

class CronJob extends CI_Controller{


    public function setCron(){
        $this->load->model('common/Common_model');
        $interval=$_REQUEST['interval'];
        $matching=$this->getMatching($interval);
        $where=array('u.status'=>1,'u.is_deleted'=>0,'u.role_id'=>3,'u.matching_and_connections_status'=>1,'matching'=>$matching);
        $customers=$this->getCustomerList($where);
          if(count($customers)>0){
            $admin_message="";
            foreach($customers as $customer){
                if($customer['id']>0){
                    $current_date=date('Y-m-d');
                    $start_date= date('Y-m-d', strtotime(date('Y-m-d'). ' - '.$interval.' days'));
                    $param['where']=array(
                        'pm.is_deleted'=>0,
                        'pm.status'=>1,
                        'vp.is_deleted'=>0,
                        'vp.status'=>1,
                        'pt.abbr'=>'en',
                        'Date_Format(vp.added_date,"%Y-%m-%d") <='=>$current_date,
                        'Date_Format(vp.added_date,"%Y-%m-%d") >='=>$start_date,
                        'vp.status'=>1,
                    );
                    $param['where_in']=explode(',',$customer['categories_ids']);
                    $data['products']=$this->getProductList($param);
                    //echo $this->db->last_query();
                    $data['customer_info']=$customer;
                    $mail_message=$this->load->view('website/email_templates/matching-and-connections-cron-job',$data,true);
                    $admin_message .=$mail_message;
                    $sent= 1;//sendEmail($customer['email'],"","Matching and connections",$mail_message);
                    if($sent){
                        // echo $mail_message; 
                        // echo "Sent";
                    }
                }
            }
            echo $admin_message;
           //sendEmail(ADMINEMAIL,"",'Matching and Connections Cron job Summary',$admin_message);
           // die;
        }
    }
    public function getMatching($interval){
        if($interval==7){
            $interval=1;
        }else if($interval==30){
            $interval=2;
        }else if($interval==90){
            $interval=3;
        }else{
            $interval=false;
        }
        return $interval;
    }
    public function getCustomerList($where){
        $this->db->where($where);
        $this->db->select("
        u.id,
        u.email,
        CONCAT(u.first_name,' ',u.last_name) customer_name,
        GROUP_CONCAT(pmc.category_id) as categories_ids
        ");
        $this->db->from('users u');
        $this->db->join('product_matching_and_connections pmc','pmc.customer_id=u.id','INNER');
        $this->db->group_by('u.id');
        $result=$this->db->get();
        $response=$result->result_array();
        return $response;
    }
    public function getProductList($param){
        $this->db->select("
		DISTINCT(vp.id) as vendor_product_id,
		vp.slug,
		pt.name,
		vp.image,
		vp.price
		");
		$this->db->from('vendor_products vp');
		$this->db->join('product_master pm','pm.id=vp.product_id','INNER');
		$this->db->join('product_category pc','pc.product_id=pm.id','INNER');
		$this->db->join('product_translator pt','pt.vendor_product_id=vp.id','INNER');
		$this->db->join('users u','u.id=vp.vendor_id','INNER');
		$this->db->join('user_address ua','ua.user_id=u.id','LEFT');
        if(count($param['where'])>0){
            $this->db->where($param['where']);
        }

        if(!empty($param['where_in'])){
            $this->db->where_in('pc.category_id',$param['where_in']);
        }

		$this->db->group_by(array('vp.id','pt.vendor_product_id','vp.product_id','ua.user_id'));
		$this->db->order_by('vp.id','DESC');
        $result = $this->db->get();
        $response=$result->result_array();
        return $response;

    }

 


}
?> 