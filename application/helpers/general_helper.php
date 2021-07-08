<?php
function sendEmail($to,$from,$subject,$message,$cc=array('sumishra@panindia.in'),$bcc=array('sumishra@panindia.in'),$attachments=array()) {
	if(isset($to) && !empty($subject) && !empty($message)){
		$config2 = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://mail.panindia.info',
			'smtp_port' => 465,
			'smtp_user' => 'mail@panindia.info',
			'smtp_pass' => 'yit-4%.85o=p',
			'mailtype'  => 'html', 
			'charset'   => 'UTF-8',
		);
		
		$CI =& get_instance();
		$CI->load->library('email',$config2);
		$CI->email->set_newline("\r\n");
		if(isset($from)){
			$from=array(
			'name'=>'Mahasheel',
			'email'=>'mail@panindia.info'
			);
		}
		$CI->email->from($from['email'], $from['name']); 
		$to='bchandra@panindia.in';
		$CI->email->to($to);
		if(isset($cc)){
			$CI->email->cc($cc);
		}
		
		if(isset($bcc)){
			$CI->email->bcc($cc);
		}
		if(count($attachments)>0){
			foreach($attachments as $attachment){
				$CI->email->attach($attachment);
			}
		}
		$CI->email->subject($subject); 
		$CI->email->message($message); 
		$sent=$CI->email->send();
  		if(!$sent){
 			return $CI->email->print_debugger();
		}else{
 			return $sent;
		}
	}
	return false;
	
}

function generateOTP(){
	$random_no=rand(4,9999);
	$random_no_length=strlen($random_no);
	$str='';
	if($random_no_length<4){
		$balance_length=4-$random_no_length;
		$str=str_repeat(0,$balance_length);
	}
  	return $str.$random_no;
}

function sendSMS($mobile,$otp){

    $otpp= $otp." is login OTP. OTP is confidential.";   
	$username = "rahul@panindia.in";
	$hash = "d762f2c1a0cfa1c1a9c4b286b498f24b4c94ff19";
	$sender = "INONLN"; 
 	$test = "0";        
	$msg = urlencode($otpp);
	$data = "username=".$username."&hash=".$hash."&message=".$msg."&sender=".$sender."&numbers=".$mobile."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	if($result){
		return true;
	}

}
function deleteTempFiles($path){
	$files = glob($path);
	foreach($files as $file){
		if(is_file($file)){
			unlink($file);
		}
	}
}
function unlinkImage($module,$image){
    $full_url='./attachments/'.$module.'/';
    if(is_file($full_url.'thumb/'.$image) && !empty($image)){
            unlink($full_url.'thumb/'.$image);
        }
        if(is_file($full_url.'main/'.$image) && !empty($image)){
            unlink($full_url.'main/'.$image);
        }

        if(is_file($full_url.'medium/'.$image) && !empty($image)){
            unlink($full_url.'medium/'.$image);
        }
}

function settDateYMD($date){
    if($date!='00/00/0000' && $date!=''){
        $return= date('Y-m-d',strtotime(str_replace('/','-',$date)));
    }else{
        $return="";
    }
    return $return;
}

function activityLog($data){
	if(count($data)>0){
		$CI = get_instance();
 		$CI->Common_model->activityLog($data);
	}
}
function makeSlug($str){
	if(!empty($str)){
		$str = preg_replace('~[^\pL\d]+~u', '-', $str);

		//$str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);

		$str = preg_replace('~[^-\w]+~', '', $str);

		$str = trim($str, '-');

		$str = preg_replace('~-+~', '-', $str);

		$str = strtolower($str);

		if (empty($str)) {
			return 'n-a-'.time();
		}
	}else{
		return 'n-a-'.time();
	}
	return $str;
}

function getStatus($status){
	if($status){
		$return="<span class='btn btn-sm btn-success'>Active</span>";
	}else{
		$return="<span  class='btn btn-sm btn-danger'>In-active</span>";
	}
	return $return;
}
function showYesNo($status){
	if($status){
		$return="<span style='color:green'>Yes</span>";
	}else{
		$return="<span style='color:red'>No</span>";
	}
	return $return;
}

function getDateDMY($date){
	if($date!='0000-00-00' && $date!=''){
		$return= date('d/m/Y',strtotime($date));
	}else{
		$return="";
	}
	return $return;
}


function settYMD($date){
	if($date!='00-00-0000' && $date!=''){
		$return= date('Y-m-d',strtotime($date));
	}else{
		$return="";
	}
	return $return;
}
function getSettingData($key){
	if(!empty($key)){
		$CI = get_instance();
		$CI->load->model('Website_model');
		$where=array('setting_key'=>$key);
		$result= $CI->Website_model->getSettingData($where);
 		return $result;
	}else{
		return array();
	}
}

function resizeImage($path,$fileData,$old_image='',$image_sizes=array()){
 	if(count($image_sizes)>0){
		$CI =& get_instance();
 		$CI->load->library('image_lib');
		foreach ($image_sizes as $key=>$resize) {
			$config2 = array(
	
			'image_library' =>'gd2',
			'source_image' => $fileData['full_path'],
	
			'new_image' => $path.$key,
	
			'maintain_ratio' => FALSE,
	
			'width' => $resize[0],
	
			'height' => $resize[1],
	
			'quality' =>70,
	
			);
	
			$CI->image_lib->initialize($config2);
	
			$CI->image_lib->resize();
	
			$CI->image_lib->clear();
	
		}
		if(!empty($old_image)){
			unlinkImage($path,$old_image);
		}
	}
}

function uploadImage($module,$allowed_types,$name,$old_image){ //table_name,//allowed_type,,//name ,//old_image
	//$this->session->set_flashdata('error',$error['error']);
	$response['status']=true;
	$path='./attachments/'.$module.'/'; 
	$config['upload_path']          = $path.'main/';
	$config['allowed_types']        = $allowed_types;
	$config['encrypt_name'] = TRUE;
	$CI =& get_instance();
	$CI->load->library('upload');
	$CI->upload->initialize($config);
	$CI->upload->error_msg = [];
//print_r($config);
 	if($CI->upload->do_upload($name)){
		$fileData = $CI->upload->data();
		$image_name=$fileData['file_name'];
		$image_sizes = array('thumb' => array(80, 80),'medium' => array(600, 450));
		resizeImage($path,$fileData,$old_image,$image_sizes);
 		$response['message']="SUCCESS";
		$response['name']=$image_name;
		$response['file_data']=$fileData;
	}else{
		$image_error=$CI->upload->display_errors();
		$response['status']=FALSE;
		$response['message']=$image_error;
		$response['file_data']='';

	}	
	return $response;
}

function uploadCroperImage($module,$user_id,$image){
	$image_parts = explode(";base64,", $image);
	$image_type_aux = explode("image/", $image_parts[0]);
	$image_type = 'jpeg';
	$filename=uniqid().'.' .$image_type;
	$filepath = './attachments/'.$module.'/'.$user_id.'/'.$filename;
	$blob= $image_parts[1];
	file_put_contents($filepath,  base64_decode( str_replace('data:image/jpeg;base64,', '', $blob)));
	$response=array('image_path'=>$filepath,'image_name'=>$filename,'image_id'=>time());
	return $response;
}

 
function get_date_diff( $time1, $time2, $precision = 2 ) {
	// If not numeric then convert timestamps
	if( !is_int( $time1 ) ) {
		$time1 = strtotime( $time1 );
	}
	if( !is_int( $time2 ) ) {
		$time2 = strtotime( $time2 );
	}

	// If time1 > time2 then swap the 2 values
	if( $time1 > $time2 ) {
		list( $time1, $time2 ) = array( $time2, $time1 );
	}

	// Set up intervals and diffs arrays
	$intervals = array( 'year', 'month', 'day', 'hour', 'minute', 'second' );
	$diffs = array();

	foreach( $intervals as $interval ) {
		// Create temp time from time1 and interval
		$ttime = strtotime( '+1 ' . $interval, $time1 );
		// Set initial values
		$add = 1;
		$looped = 0;
		// Loop until temp time is smaller than time2
		while ( $time2 >= $ttime ) {
			// Create new temp time from time1 and interval
			$add++;
			$ttime = strtotime( "+" . $add . " " . $interval, $time1 );
			$looped++;
		}

		$time1 = strtotime( "+" . $looped . " " . $interval, $time1 );
		$diffs[ $interval ] = $looped;
	}

	$count = 0;
	$times = array();
	foreach( $diffs as $interval => $value ) {
		// Break if we have needed precission
		if( $count >= $precision ) {
			break;
		}
		// Add value and interval if value is bigger than 0
		if( $value > 0 ) {
			if( $value != 1 ){
				$interval .= "s";
			}
			// Add value and interval to times array
			$times[] = $value . " " . $interval;
			$count++;
		}
	}

	// Return string with times
	return implode( ", ", $times );
}
 
function randomPassword( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}
 

function getDateDDMMYY($date){
	if($date!=''){
		$return= date('d M Y',strtotime($date));
	}else{
		$return="";
	}
	return $return;
}
function getTime($date){
	if($date!=''){
		$return= date('m:i:s',strtotime($date));
	}else{
		$return="";
	}
	return $return;
}


function getUserList($where=array('u.is_deleted'=>0)){
	$CI = get_instance();
 	$response=$CI->Common_model->getUserList($where);
 	return $response; 
}
 
function getSingleTableData($table,$where=array(),$order=array()){
	if(!empty($table)){
		$CI = get_instance();
		$response=$CI->Common_model->getSingleTableData($table,$where,$order);
		return $response; 
	}
}
function getLanguageList($where=array()){
	$CI = get_instance();
 	$response=$CI->Common_model->getLanguageList($where);
 	return $response; 
}

function getBrandList($where){
	if(count($where)>0){
		$CI = get_instance();
		$response=$CI->Common_model->getBrandList($where);
		return $response;
	}
}

function getUnitList($where){
	if(count($where)>0){
		$CI = get_instance();
		$response=$CI->Common_model->getUnitList($where);
		return $response;
	}
}

function getRoleList(){
	$CI = get_instance();
	$where=array('status'=>1);
	$response=$CI->Users_model->getRoleList($where);
 	return $response; 
}

function getCountryList(){
	$CI = get_instance();
 	$where=array('id'=>65);
	$response=$CI->Common_model->getCountryList($where);
 	return $response; 
}

function changeCountryGetState($where){
	$CI = get_instance();
 	$response=$CI->Common_model->changeCountryGetState($where);
 	return $response; 
}
function changeStateGetCity($where){
	$CI = get_instance();
 	$response=$CI->Common_model->changeStateGetCity($where);
 	return $response; 
}

function getServicesCategories($where){
	$CI = get_instance();
 	$response=$CI->Common_model->getServicesCategories($where);
 	return $response; 
}

function getServices($where){
	$CI = get_instance();
 	$response=$CI->Common_model->getServices($where);
 	return $response; 
}


function getOrderStatus($where=array()){
	$CI = get_instance();
	$response=$CI->Common_model->getOrderStatus($where);
	return $response; 
}

function getOderId($order_id){
	$total_length=5;
	$current_length=strlen($order_id);
	$balance_length=$total_length-$current_length;
	$response='';
	if($balance_length>0){
		$response .= str_repeat(0,$balance_length);
	}
	return $response.$order_id;
}

function getVenodrCustomerList($where){
	if(count($where)>0){
		$CI = get_instance();
		$response=$CI->Common_model->getVenodrCustomerList($where);
		return $response;
	}
}
function getFacilitiesData($where){
	if(count($where)>0){
		$CI = get_instance();
		$response=$CI->Common_model->getFacilitiesData($where);
		return $response;
	}
}


function customCopy($src, $dst) {  
   
	// open the source directory 
	$dir = opendir($src);  
	// Make the destination directory if not exist 
	$response=@mkdir($dst);  
	// Loop through the files in source directory 
	foreach (scandir($src) as $file) {  
   
		if (( $file != '.' ) && ( $file != '..' )) {  
			if ( is_dir($src . '/' . $file) )  
			{  
   
				// Recursively calling custom copy function 
				// for sub directory  
				//custom_copy($src . '/' . $file, $dst . '/' . $file);  
   
			}  
			else {  
				//copy($src . '/' . $file, $dst . '/' . $file);  
			}  
		}  
	}  
   
	closedir($dir); 
	return $response;
}

function customDate($post){
	$change_date=$post['change_date'];
	$today=date('d-m-Y');
	switch ($change_date){

	 case 0:
	 //today
	 $from_date=$today;
	 $to_date=$today;
	 break;

	 case 1:
	 //yesterday
	 $from_date=date('d-m-Y',strtotime("-1 days"));
	 $to_date=date('d-m-Y',strtotime("-1 days"));
	 break;

	 case 2:
	  //Last seven Days
	 $from_date=date('d-m-Y',strtotime("-7 days"));
	 $to_date=$today;
	 break;

	 case 3:
	 //Last Fifteen days
	 $from_date=date('d-m-Y',strtotime("-15 days"));
	 $to_date=$today;
	 break;

	 case 4:
	 //this month
	 $from_date=date('01-m-Y');
	 $to_date=$today;
	 break;

	 case 5:
	 //last month
	 $from_date=date('01-m-Y',strtotime('last month'));
	 $to_date=date('t-m-Y',strtotime('last month'));
	 break;

	 case 6:
	  //last six months
	 $from_date=date('d-m-Y', strtotime(date('Y-m-d') .' -6 months'));
	 $to_date=$today;
	 break;

	 case 7:
	 //this year
	 $from_date=date('01-01-Y');
	 $to_date=$today;
	 break;

	 case 8:
	 //Last Year
	 $from_date=date("d-m-Y",strtotime("last year January 1st"));
	 $to_date=date("d-m-Y",strtotime("last year December 31st"));
	 break;

	 case 9:
	 $from_date=$post['from_date'] ? $post['from_date']:'01-01-1970';
	 $to_date=$post['to_date'] ? $post['to_date']:$today;
	 break;

	 default :
	 $from_date=$today;
	 $to_date=$today;
	 
	}
	$response['from_date']=$from_date;
	$response['to_date']=$to_date;
	return $response;
}

function categoryList($where){
	if(count($where)>0){
		$CI = get_instance();
		$response=$CI->Common_model->categoryList($where);
		return $response;
	}
}

function totalCartItem(){
	$CI = get_instance();
	$response=$CI->Cart_model->totalCartItem();
 	return $response;
}

function totalWishList(){
	$CI = get_instance();
	$response=$CI->Cart_model->totalWishList();
	return $response;
}

function ajaxPaginationConfigration($data){
	$config['target']      = '#postList';
	$config['base_url']    = $data['base_url'];
	$config['total_rows']  = $data['totalRec'];
	$config['per_page']    = $data['per_page'];
	$config['link_func']   = 'searchFilter';
	$config['full_tag_open'] = '<ul class="pagination">';
	$config['full_tag_close'] = '</ul>';
	$config['num_tag_open'] = '<li class="page-item">';
	$config['num_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
	$config['cur_tag_close'] = '</a></li>';
	$config['next_tag_open'] = '<li class="page-item">';
	$config['next_tagl_close'] = '</a></li>';
	$config['prev_tag_open'] = '<li class="page-item">';
	$config['prev_tagl_close'] = '</li>';
	$config['first_tag_open'] = '<li class="page-item disabled">';
	$config['first_tagl_close'] = '</li>';
	$config['last_tag_open'] = '<li class="page-item">';
	$config['last_tagl_close'] = '</a></li>';
	$config['anchor_class'] = 'page-link';
	$config['attributes'] = array('class' => 'page-link');
	return $config;
}

function getMinMaxProductPrice(){
	$CI = get_instance();
	$response=$CI->Common_model->getMinMaxProductPrice();
	return $response;
}

function getSettings(){
	$CI = get_instance();
	$response=$CI->Common_model->getSettings();
	return $response;
}

function setGatewatData($data){
	$CI = get_instance();
	$order_data=$CI->Common_model->getOrderData(array('o.order_id'=>$data['order_id']));
	$order_details=$CI->Common_model->getOrderProducts($data['order_id']);

	$unit_price="";
	$quantity="";
	$title="";
	foreach($order_details as $order_detail){
		$unit_price .=$order_detail['price']." || ";
		$quantity .=$order_detail['quantity']." || ";
		$title .=$order_detail['name']." || ";
	}

	$response=array(
	'merchant_email'=>$CI->config->item('merchant_email'),
	'secret_key'=>$CI->config->item('secret_key'),
	'site_url'=>base_url(),
	'return_url'=>base_url('payment'),
	'title'=>"Order Product",
	'cc_first_name'=>$order_data['first_name'],
	'cc_last_name'=>$order_data['last_name'],
	'cc_phone_number'=>$order_data['customer_phone'],
	'phone_number'=>$order_data['phone'],
	'email'=>$order_data['email'],
	'products_per_title'=>rtrim($title," || "),
	'unit_price'=>rtrim($unit_price," || "),
	'quantity'=>rtrim($quantity," || "),
	'other_charges'=>'0',
	'amount'=>$order_data['total_amount'],
	'discount'=>$order_data['discount'],
	'currency'=>'USD',
	'reference_no'=>$data['order_id'],
	'ip_customer'=>$_SERVER['SERVER_ADDR'],
	'ip_merchant'=>$_SERVER['SERVER_ADDR'],
	 'billing_address'=>$order_data['name'].' '.$order_data['phone'].' '.$order_data['city_name'].' '.$order_data['state_name'].' '.$order_data['country_name'].' '.$order_data['zip'],
	'state'=>$order_data['state_name'],
	'city'=>$order_data['city_name'],
	'postal_code'=>$order_data['zip'],
	'country'=>$order_data['country_code'],
	'shipping_first_name'=>$order_data['first_name'],
	'shipping_last_name'=>$order_data['last_name'],
	'address_shipping'=>$order_data['name'].' '.$order_data['phone'].' '.$order_data['city_name'].' '.$order_data['state_name'].' '.$order_data['country_name'].' '.$order_data['zip'],
	'city_shipping'=>$order_data['city_name'],
	'state_shipping'=>$order_data['state_name'],
	'postal_code_shipping'=>$order_data['zip'],
	'country_shipping'=>$order_data['country_code'],
	'msg_lang'=>'English',
	'cms_with_version'=>phpversion(),
	);
	  return $response;

}
function pr($d, $echo = TRUE){
      if($echo){
          echo '<pre>'.print_r($d, true).'</pre>';
      }else{
         return '<pre>'.print_r($d, true).'</pre>';
      }
   }

   function prd($d){  
      pr($d);    
      die;
   }

   function vr($d , $echo = TRUE){
      if($echo){
          echo '<pre>';var_dump($d, true);
      }else{
         return '<pre>';var_dump($d, true);
      }
   }

   function vrd($d){
      vr($d);
      die;
   }

function getTemp($f){
	if($f){
		return  number_format(5*($f-32)/9,2);
	}
	return false;
	

} 



 


 