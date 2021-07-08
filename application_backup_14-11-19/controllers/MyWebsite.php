<?php
class Website extends Web {
 
	 
	public function index()
	{
		$categories=categoryList(array('c.parent_id'=>0,'c.status'=>1));
		$data['category']=array();
		if(count($categories)>0){
			foreach($categories as $category){
				$sub_categories=categoryList(array('c.parent_id'=>$category['id'],'c.status'=>1));
				$data['category'][]=array(
					'id'=>$category['id'],
					'name'=>$category['name'],
					'slug'=>$category['slug'],
					'sub_category'=>$sub_categories,
				);
			}
		}


		$service_categories=$this->Common_model->getServicesCategories(array('sc.is_deleted'=>0,'sc.status'=>1));
		$data['service_category']=array();
 		if(count($service_categories)>0){
			foreach($service_categories as $service_category){
				$services=$this->Common_model->getServices(array('sps.service_category_id'=>$service_category['id']));
				$data['service_category'][]=array(
					'id'=>$service_category['id'],
					'name'=>$service_category['name'],
					'slug'=>$service_category['slug'],
					'sub_category'=>$services,
				);
			}
		}

		$states=changeCountryGetState(array('country_id'=>65));
		$data['states']=array();
   		if(count($states)>0){
			foreach($states as $state){
				$cities=changeStateGetCity(array('state_id'=>$state['id']));
				$data['states'][]=array(
					'id'=>$state['id'],
					'name'=>$state['name'],
					'cities'=>$cities,
				);
			}
		}

		$where=array('is_deleted'=>0,'status'=>1);
		$data['sliders']=$this->Website_model->getSliders($where);
		$data['our_services']=$this->Common_model->getSingleTableData('our_services',array('status'=>1,'is_deleted'=>0));
		$data['calculations']=$this->Common_model->getSingleTableData('calculations',array('status'=>1,'is_deleted'=>0),array('key'=>'sort_id','value'=>'ASC'));
		$data['how_it_works']=$this->Common_model->getSingleTableData('work_process',array('status'=>1,'is_deleted'=>0),array('key'=>'sort_id','value'=>'ASC'));
		$data['top_vendors']=$this->Common_model->getSingleTableData('users',array('status'=>1,'is_deleted'=>0,'role_id'=>2,'top'=>1),array('key'=>'first_name','value'=>'ASC'));
   	 	$this->load->view('website/index',$data);
	}

	public function registrationStepTwo(){
		if($this->session->userdata('role_id')){
			redirect($this->session->userdata('url'));
	   }
	   if($this->input->post('role_id')>0){
		    $data['role']=$this->input->post('role_id');
			$this->load->view('website/registration-step-two',$data);
	   }else{
		   redirect(base_url('registration-step-one'));
	   }


	}

	public function registrationStepOne(){
		if($this->session->userdata('role_id')){
			redirect($this->session->userdata('url'));
	   }
	   $this->load->view('website/registration-step-one');
	}

	public function aboutUs(){
		$about_us=$this->Common_model->getSingleTableData('cms_pages',array('id'=>1,'status'=>1,'is_deleted'=>0));
		$data['about_us']=array();
		if(count($about_us)){
			$data['about_us']=$about_us[0];
		}
		$this->load->view('website/about-us',$data);
	}

	public function contactUs(){
		$page=$this->Common_model->getSingleTableData('cms_pages',array('id'=>4,'status'=>1,'is_deleted'=>0));
		$data['page']=array();
		if(count($page)){
			$data['page']=$page[0];
		}
		$this->load->view('website/contact-us',$data);
	}

	function contactustwo()
	{
		$page=$this->Common_model->getSingleTableData('cms_pages',array('id'=>4,'status'=>1,'is_deleted'=>0));
		$data['page']=array();
		if(count($page)){
			$data['page']=$page[0];
		}
		$this->load->view('website/contact-us-two',$data);

	}


	public function ourTeam(){
		$page=$this->Common_model->getSingleTableData('cms_pages',array('id'=>3,'status'=>1,'is_deleted'=>0));
		$data['page']=array();
		if(count($page)){
			$data['page']=$page[0];
		}
		$data['teams']=$this->Common_model->getSingleTableData('our_team',array('status'=>1,'is_deleted'=>0));
		$this->load->view('website/our-team',$data);
	}

	public function login(){
		if($this->session->userdata('role_id')){
 			redirect($this->session->userdata('url'));
		}
	    $data['ch']=$this->input->get('ch')?$this->input->get('ch'):'';
		$this->load->view('website/login',$data);
	}

	public function logout(){
		if($this->session->userdata('role_id')){
			if($this->session->userdata('role_id')==1){
				$key='admin_data';
			}
			if($this->session->userdata('role_id')==2){
				$key='vendor_data';
			}
			if($this->session->userdata('role_id')==3){
				$key='customer_data';
			}
			if($this->session->userdata('role_id')==4){
				$key='delivery_boy_data';
			}
			if($this->session->userdata('role_id')==5){
				$key='service_provider_data';
			}
			$this->session->unset_userdata(array($key=>'','url'=>'','role_id'=>''));
			$this->session->sess_destroy();
		}
		redirect(base_url());
 	}

 


	public function products()
	{
		$param['where_in'] = array();
		$param['where']=array('pm.is_deleted'=>0,'pm.status'=>1,'vp.is_deleted'=>0,'vp.status'=>1);
 		if(count($this->input->post())>0){
			$change_location=$this->input->post('change_location');
			$location_type=$this->input->post('location_type');
 			if($location_type=1 && $change_location>0){
				$param['where']['ua.state']=$change_location;
			}elseif($change_location>0){
				$param['where']['ua.city']=$change_location;
			}
			$search_type_id=$this->input->post('search_type_id');
			$category_id=$this->input->post('search_id');
			if($category_id){
				$category_ids=explode(',',ltrim(rtrim($this->Website_model->getAllChildCategoriesList($category_id)['categories'].','.$category_id,','),','));
				$param['where_in'] = $category_ids;
			}
 			$totalRec = count($this->Website_model->products($param));
  			$config=ajaxPaginationConfigration(array('base_url'=>base_url().'website/productListAjax','totalRec'=>$totalRec,'per_page'=>$this->config->item('record_per_page')));
			$this->ajax_pagination->initialize($config);
			$param['limit']=$this->config->item('record_per_page');
			$data['products']=$this->Website_model->products($param);
			$data['search_type_id']=$search_type_id;
			$data['search_id']=$this->input->post('search_id');
			$data['change_location']=$this->input->post('change_location');
			$data['location_type']=$this->input->post('location_type');
		    $this->load->view('website/products',$data);
		}else{
			$category_slug=$this->uri->segment(2);
			if(!empty($category_slug)){
				$cat_data=$this->Common_model->getSingleTableData('category',array('slug'=>$category_slug,'status'=>1,'is_deleted'=>0));
				if(count($cat_data)>0){
					$category_id=$cat_data[0]['id'];
					//$category_id=$this->input->post('search_id');
					if($category_id){
						$category_ids=explode(',',ltrim(rtrim($this->Website_model->getAllChildCategoriesList($category_id)['categories'].','.$category_id,','),','));
						$param['where_in'] = $category_ids;
 					}
				} 
				$totalRec = count($this->Website_model->products($param));
				$config=ajaxPaginationConfigration(array('base_url'=>base_url().'website/productListAjax','totalRec'=>$totalRec,'per_page'=>$this->config->item('record_per_page')));
				$this->ajax_pagination->initialize($config);
				$param['limit']=$this->config->item('record_per_page');
				$data['products']=$this->Website_model->products($param);
 				$data['search_type_id']=1;
				$data['search_id']=$category_id;
				$data['change_location']='';
				$data['location_type']='';
				$data['search_type_id']=1;
 				$this->load->view('website/products',$data);
			}else{
				redirect(base_url());
			}
		}
	}

 

	public function productListAjax(){
		$conditions = array(); 
		$conditions['where_in'] = array();
		$conditions['where']=array('pm.is_deleted'=>0,'pm.status'=>1,'vp.is_deleted'=>0,'vp.status'=>1);
		$page = $this->input->post('page');
		$min_price=$this->input->post('min_price');
		$max_price=$this->input->post('max_price');
		$conditions['where']['vp.price>=']=$min_price;
		$conditions['where']['vp.price<=']=$max_price;
		$change_location=$this->input->post('change_location');
		$location_type=$this->input->post('location_type');
		 if($location_type=1 && $change_location>0){
			$conditions['where']['ua.state']=$change_location;
		}else if($change_location>0){
			$conditions['where']['ua.city']=$change_location;
		}
		$search_type_id=$this->input->post('search_type_id');
		$category_id=$this->input->post('search_id');
		if($category_id){
			$category_ids=explode(',',ltrim(rtrim($this->Website_model->getAllChildCategoriesList($category_id)['categories'].','.$category_id,','),','));
			$conditions['where_in'] = $category_ids;
		}
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
		$totalRec = count($this->Website_model->products($conditions));

 		$config=ajaxPaginationConfigration(array('base_url'=>base_url().'website/productListAjax','totalRec'=>$totalRec,'per_page'=>$this->config->item('record_per_page')));
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->config->item('record_per_page');
        
        //get posts data
		$data['products'] = $this->Website_model->products($conditions);
        $this->load->view('website/product-ajax', $data, false);
	}


	public function productDetails(){
		$slug=$this->uri->segment(2);
		if(!empty($slug)){
			$where=array('vp.slug'=>$slug);
			$data['product']=$this->Website_model->productDetails($where);
			$data['product']['images']=$data['product']['images'].','.$data['product']['image'];
			$data['product']['cart_quantity']=$this->Website_model->cartQuantity($data['product']['vendor_product_id']);
  			$this->load->view('website/product-details',$data);
		} 
	}
	 

	public function services(){
 		$where['sc.is_deleted']=0;
		$where['sc.status']=1;
		$where['sps.is_deleted']=0;
		$where['sps.status']=1;
  		if(count($this->input->post())>0){
  			$search_type_id=$this->input->post('search_type_id');
			$search_id=$this->input->post('search_id');
			if($search_type_id==1){
				$where['sps.service_category_id']=$search_id;
			}else{
				$where['sps.id']=$search_id;
			}
			$change_location=$this->input->post('change_location');
			$location_type=$this->input->post('location_type');
			if($change_location>0){
				if($location_type=1){
					$where['ua.state']=$change_location;
				}else{
					$where['ua.city']=$change_location;
				}
			}
			$param['where']=$where;
			$totalRec = count($this->Website_model->servicesList($param));
 			$config=ajaxPaginationConfigration(array('base_url'=>base_url().'website/serviceListAjax','totalRec'=>$totalRec,'per_page'=>$this->config->item('record_per_page')));
			$this->ajax_pagination->initialize($config);
			$param['limit']=$this->config->item('record_per_page');
			$data['services']=$this->Website_model->servicesList($param);
  			$data['search_type_id']=$search_type_id;
			$data['search_id']=$search_id;
 			$this->load->view('website/services',$data);
		}else{
			$service_cate_slug=$this->uri->segment(2);
			$service_slug=$this->uri->segment(3);
			if(!empty($service_cate_slug)){
				$search_id=0;
				if(!empty($service_slug)){
					$service_data=$this->Common_model->getSingleTableData('service_provider_services',array('slug'=>$service_slug,'status'=>1,'is_deleted'=>0));
					if(count($service_data)>0){
						$search_id=$service_data[0]['id'];
					}
					$where['sps.id']=$search_id;
					$data['search_type_id']=0;
				}else{
					$cat_data=$this->Common_model->getSingleTableData('service_category',array('slug'=>$service_cate_slug,'status'=>1,'is_deleted'=>0));
					if(count($cat_data)>0){
						$search_id=$cat_data[0]['id'];
						$data['search_type_id']=1;
						$where['sps.service_category_id']=$search_id;
					}
				}
				$param['where']=$where;
				$totalRec = count($this->Website_model->servicesList($param));
				$config=ajaxPaginationConfigration(array('base_url'=>base_url().'website/serviceListAjax','totalRec'=>$totalRec,'per_page'=>$this->config->item('record_per_page')));
				$this->ajax_pagination->initialize($config);
				$param['limit']=$this->config->item('record_per_page');
				$data['services']=$this->Website_model->servicesList($param);
 				$data['search_id']=$search_id;
				$this->load->view('website/services',$data);
			}
		}
		 
	}
	

	public function serviceListAjax(){
		$conditions = array();
		$where['sc.is_deleted']=0;
		$where['sc.status']=1;
		$where['sps.is_deleted']=0;
		$where['sps.status']=1;
         $page = $this->input->post('page');
         if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
		$search_type_id=$this->input->post('search_type_id');
		if($search_type_id==1){
			$where['sps.service_category_id']=$this->input->post('search_id');
		}else{
			$where['sps.id']=$this->input->post('search_id');
		}
		$conditions['where']=$where;
		$totalRec = count($this->Website_model->servicesList($conditions));

 		$config=ajaxPaginationConfigration(array('base_url'=>base_url().'website/serviceListAjax','totalRec'=>$totalRec,'per_page'=>$this->config->item('record_per_page')));
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->config->item('record_per_page');
        
        //get posts data
		$data['services'] = $this->Website_model->servicesList($conditions);
		//echo $this->db->last_query();
        $this->load->view('website/service-list-ajax', $data, false);
	}

	public function serviceDetails(){
		$slug=$this->uri->segment(2);
		if(!empty($slug)){
 			$conditions['where']=array('sps.slug'=>$slug);
			$service_data =  $this->Website_model->servicesList($conditions);
			if(count($service_data)){
				$data['service']=$service_data[0];
				$data['service']['images']=$service_data[0]['image'];
				$this->load->view('website/service-details',$data);
			}else{
				redirect(base_url());
			}
		} 
	}


	public function growerList()
	{
		$conditions['latitude']=$this->input->post('latitude')?$this->input->post('latitude'):'';
		$conditions['longitude']=$this->input->post('longitude')?$this->input->post('longitude'):'';
 	 	$conditions['where_in']=array();
		$category_id=$this->input->post('category_id');
		if($category_id){
 			$category_ids=explode(',',ltrim(rtrim($this->Website_model->getAllChildCategoriesList($category_id)['categories'].','.$category_id,','),','));
			$conditions['where_in'] = $category_ids;
		}
		$conditions['where'] = array('u.role_id'=>2);
		$totalRec = count($this->Website_model->growerList($conditions));
 		$config=ajaxPaginationConfigration(array('base_url'=>base_url().'website/growerListAjax','totalRec'=>$totalRec,'per_page'=>$this->config->item('record_per_page')));
		$this->ajax_pagination->initialize($config);
		$conditions['limit']=$this->config->item('record_per_page');
		$data['growers']=$this->Website_model->growerList($conditions);
		$data['latitude']=$conditions['latitude'];
		$data['longitude']=$conditions['longitude'];
 		$this->load->view('website/grower-list',$data);
		}

	public function growerListAjax(){
		$conditions = array();
		$conditions['where_in']=array();
		$conditions['latitude']=$this->input->post('latitude')?$this->input->post('latitude'):'';
		$conditions['longitude']=$this->input->post('longitude')?$this->input->post('longitude'):'';
        $page = $this->input->post('page');
		$category_id=$this->input->post('category_id');
		if($category_id){
			$category_ids=explode(',',ltrim(rtrim($this->Website_model->getAllChildCategoriesList($category_id)['categories'].','.$category_id,','),','));
			$conditions['where_in'] = $category_ids;
		}

        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
		}
		$conditions['where'] = array('u.role_id'=>2);
		 
		//total rows count
		$totalRec = count($this->Website_model->growerList($conditions));
		$config=ajaxPaginationConfigration(array('base_url'=>base_url().'website/growerListAjax','totalRec'=>$totalRec,'per_page'=>$this->config->item('record_per_page')));
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->config->item('record_per_page');
        
        //get posts data
		$data['growers'] = $this->Website_model->growerList($conditions);
         $this->load->view('website/grower-list-ajax', $data, false);
	}


	public function addUser(){
		if ($this->input->is_ajax_request()) {
			$response['status']=true;
			$email_error='';
			$phone_error='';
			$this->form_validation->set_rules('role', 'Role', 'trim|required');
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
			$this->form_validation->set_rules('change_state', 'State', 'trim|required');
			$this->form_validation->set_rules('change_city', 'City', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone Number', 'required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('address', 'Address', 'required');
			$this->form_validation->set_rules('password', 'New Password', 'required|max_length[15]|min_length[5]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
			   
			$email=$this->input->post('email');
 			if(!empty($email)){

				$where=array('email'=>$email);
 				if(!$this->Common_model->checkExist('users',$where)){
					$response['status']=FALSE;
					$email_error="Email Address already  exists";
				}
			}

			$phone=$this->input->post('phone');
 			if(!empty($phone)){
				$where=array('phone'=>$phone);
				if(!$this->Common_model->checkExist('users',$where)){
					$response['status']=FALSE;
					$phone_error="Phone Number already  exists";
				}
			}
	
	
			if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
				$response['response']=$this->form_validation->error_array();
				$response['status']=FALSE;
 				if(!empty($email_error)){
					$response['response']['email']=$email_error;
				}
				if(!empty($phone_error)){
					$response['response']['phone']=$phone_error;
				}
				
				$response['message']='There is error in submitting form!';
			}else{

				$save_data=array(
					'id'=>0,
					'role_id'=>$this->input->post('role'),
					'first_name'=>$this->input->post('first_name'),
					'last_name'=>$this->input->post('last_name'),
					'email'=>$this->input->post('email'),
					'phone'=>$this->input->post('phone'),
					'forecast'=>$this->input->post('weatherforecast')?$this->input->post('weatherforecast'):1,
					'publication'=>$this->input->post('publicationtime')?$this->input->post('publicationtime'):1,
					'matching'=>$this->input->post('matching')?$this->input->post('matching'):1,
					'verification_code'=>sha1(time()),
					'password'=>sha1($this->input->post('password')),					
				);
				 
				$user_id=$this->Common_model->AddUpdateData('users',$save_data);
				$this->Common_model->AddUpdateData('users',array('id'=>$user_id,'slug'=>makeSlug($save_data['first_name'].'-'.$save_data['last_name'].'-'.$user_id)));
				if($user_id){
					$address_data=array(
						'id'=>0,
						'user_id'=>$user_id,
						'address'=>$this->input->post('address'),
						'state'=>$this->input->post('change_state'),
						'city'=>$this->input->post('change_city'),
						'latitude'=>$this->input->post('latitude'),
						'longitude'=>$this->input->post('longitude'),
					);
					$this->Common_model->AddUpdateData('user_address',$address_data);
					$template_data['registration']=$save_data;
					$this->db->select('r.name as role_name');
					$this->db->from('users u');
					$this->db->join('role r ','r.id=u.role_id','inner');
					$this->db->where('u.id',$user_id);
					$result=$this->db->get();
					$data=$result->row_array();

					$subscribeNewletter=$this->input->post('subscribeNewletter');
					
					if($subscribeNewletter){
						$subscriber_save=array(
							'email'=>$this->input->post('email'),
						);
					   $this->Website_model->subscribe($subscriber_save);

					}
					$template_data['registration']['role_name']=$data['role_name'];
					
					
					$mail_message=$this->load->view('website/email_templates/registration-admin', $template_data, true);
					sendEmail(ADMINEMAIL,"",'Registration',$mail_message);
					$this->db->where('id',1);
					$email_data=$this->db->get('email_templates')->row_array();
					$template_data['email_data']=$email_data;
					$mail_message=$this->load->view('website/email_templates/registration-customer', $template_data, true);
					sendEmail($save_data['email'],"",$email_data['subject'],$mail_message);
					
					$message = "Your Registration has been completed Successfully!";
				}else{
					$message = "There is an error!";
					$response['status']=FALSE;
				}
 				$response['message']=$message;
			}
 			echo json_encode($response);
		}
	}
 
	public function checkLogin(){
		//if (!$this->input->is_ajax_request() || (!$this->input->post()) || $this->session->userdata('vendor')) {
			//redirect('vendor-dashboard', 'refresh');
		//}
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if ($this->form_validation->run() == FALSE) {
				$response['response']=$this->form_validation->error_array();
				$response['status']=false;
				$response['message']='There is error in submitting form!';
			}else{
				$check_data=array(
					'email'=>$this->input->post('email'),
					'password'=>sha1($this->input->post('password')),
 				);
				$result = $this->Common_model->loginCheck($check_data);
 				if (!empty($result)) {
					$verified=$result['verified'];
					if(!$verified){
						$response['status']=false;
						$response['message']='Your account needs to verification!';
					}else{
						$status=$result['status'];
						if(!$status){
							$response['status']=false;
							$response['message']='Your account needs to verify by admin!';
						}else{
							$response['role_id']=$result['role_id'];
							if(in_array($response['role_id'],array(2,3,4,5))){
								//if($result['role_id']==1){
								//	$this->session->set_userdata('admin',TRUE);
								//	$session_data=array('admin_data'=>$result);
								//	$url=base_url('admin-dashboard');
							//	}
								if($result['role_id']==2){
									$this->session->set_userdata('vendor',TRUE);
									$session_data=array('vendor_data'=>$result);
									$url=base_url('vendor-dashboard');
								}
								else if($result['role_id']==3){
									$this->session->set_userdata('customer',TRUE);
									$session_data=array('customer_data'=>$result);
									//if($this->input->post('ch')){
									//	$url=base_url('CheckOut');
									//}else{
										$url=base_url('customer-dashboard');
									//}
								}
								else if($result['role_id']==4){
									$this->session->set_userdata('delivery-boy',TRUE);
									$session_data=array('delivery_boy_data'=>$result);
									$url=base_url('delivery-boy-dashboard');
								}
								else if($result['role_id']==5){
									$this->session->set_userdata('service-provider',TRUE);
									$session_data=array('service_provider_data'=>$result);
									$url=base_url('service-provider-dashboard');
								}
								$ch_url='';
								if($this->input->post('ch')){
									$ch_url=base_url('CheckOut');
								}
								$session_data['url']=$url;
								$session_data['role_id']=$result['role_id'];
								$this->Common_model->updateLogin($result['id']);
								$this->session->set_userdata('logged_in',TRUE);
 								$this->session->set_userdata($session_data);
								//if($this->input->post('remind_me')){
									//$this->input->set_cookie($result);
								//}
								$response['url']=$url;
								$response['ch_url']=$ch_url;
								$response['status']=true;
								$response['message']='You have successfully loggedin!';
								$this->Cart_model->updateUserId($_COOKIE["user_session_id"]);
							}else{
								$response['status']=false;
								//$response['message']='Some thing went wrong with your account!';
								$response['message']='Wrong username or password!';

							}
						}
					}
				} else {
					$response['status']=false;
					$response['message']='Wrong username or password!';
				}
			}
			echo json_encode($response);
	}
	public function forgotPassword(){
		//if (!$this->input->is_ajax_request() || (!$this->input->post()) || $this->session->userdata('vendor')) {
			//redirect('vendor-dashboard', 'refresh');
		//}
		$this->form_validation->set_rules('forgot_email', 'Email', 'trim|required');
 			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if ($this->form_validation->run() == FALSE) {
				$response['response']=$this->form_validation->error_array();
				$response['status']=false;
				$response['message']='There is error in submitting form!';
			}else{
				$check_data=array(
					'email'=>$this->input->post('forgot_email'),
  				);
				$result = $this->Common_model->loginCheck($check_data);
 				//print_r($result);
				if (!empty($result)) {
					$verified=$result['verified'];
					if(!$verified){
						$response['status']=false;
						$response['message']='You account needs to verification!';
					}else{
						$status=$result['status'];
						if(!$status){
							$response['status']=false;
							$response['message']='You account needs to verify by admin!';
						}else{
 							$updatedata=array(
								'id'=>$result['id'],
								'verification_code'=>sha1(time()),
							);
							$this->Common_model->updateProfile($updatedata);
							$template_data['forgot_password']['name']=$result['first_name'].' '.$result['last_name'];
							$template_data['forgot_password']['link']=base_url('change-password/'.$updatedata['verification_code']);
							$mail_message=$this->load->view('website/email_templates/forgot-password', $template_data, true);
							sendEmail($result['email'],"",'Forgot Password',$mail_message);
							$response['status']=true;
 							$response['message']='Password reset link has been sent to your email!';

						}
					}
				} else {
					$response['status']=false;
					$response['message']='Email Address not exists!';
				}
			}
			echo json_encode($response);
	}
	
	public function changePassword(){
		$token=$this->uri->segment(2);
 		if(!empty($token)){
 			$where=array('verification_code'=>$token);
			$response=$this->Common_model->userData($where);
		    if(count($response)){
				$data['id']=$response['id'];
				$this->load->view('website/change-password',$data);
			}else{
				redirect('/');
			}
 		} 
	}


	public function checkChangePassword(){
		$this->form_validation->set_rules('password', 'New Password', 'required|max_length[15]|min_length[5]|alpha_numeric');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == FALSE) {
			$response['response']=$this->form_validation->error_array();
			$response['status']=false;
			$response['message']='There is error in submitting form!';
		}else{
			$update_data=array(
				'id'=>($this->input->post('id')),
				'password'=>sha1($this->input->post('password')),
				'verification_code'=>'',
			);
			$result = $this->Common_model->updateProfile($update_data);
			if (!empty($result)) {
				$response['status']=TRUE;
				$response['message']='Your password has been updated successfully!';
			}else{
				$response['status']=FALSE;
				$response['message']='Something went wrong with account!';
			} 
		}
		echo json_encode($response);
	}
	

	public function accountVerification(){
 		$varification_code=$this->input->get('token');
		if(!empty($varification_code)){
			$where=array('verification_code'=>$varification_code);
			$response=$this->Common_model->userData($where);
   		    if(count($response)){
 				if($response['verified']){
					$data['message']="Your account is already verified";
			   }else{
					$data=array('id'=>$response['id'],'verified'=>1,'status'=>1,'verification_code'=>'');
					$this->Common_model->AddUpdateData('users',$data);
 				   $data['message']="Your account has been  verified successfully";
			   }
			}
			$this->load->view('website/account-verification',$data);
 		}
	}

	function contactustwoSubmit()
	{
		if ($this->input->is_ajax_request()) {
			$response['status']=true;
  			$this->form_validation->set_rules('cname', 'Name', 'trim|required');
 			$this->form_validation->set_rules('cemail', 'Email Address', 'trim|required|valid_email');
			$this->form_validation->set_rules('cphone', 'Phone Number', 'required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('csubject', 'Subject', 'trim|required');
			$this->form_validation->set_rules('cmessage', 'Message', 'trim|required');
			 
			if ($this->form_validation->run() == FALSE) {
				$response['response']=$this->form_validation->error_array();
				$response['status']=FALSE;
				$response['message']='There is error in submitting form!';
			}else{
				$save_data=array(
					'id'=>0,
 					'cname'=>$this->input->post('cname'),
 					'cemail'=>$this->input->post('cemail'),
					 'cphone'=>$this->input->post('cphone'),
					 'csubject'=>$this->input->post('csubject'),
					 'cmessage'=>$this->input->post('cmessage'),
 				);
				if($this->Common_model->AddUpdateData('contact_uss',$save_data)){

					$template_data['contact_us']=$save_data;
					$message = "Thank you for filling out your information!";
					}else{
					$message = "There is an error!";
					$response['status']=FALSE;
				}
 				$response['message']=$message;
			}
			echo json_encode($response);
		}
		else
		{
			redirect('Website/contactustwo');
		}
	}

	public function contactUsNow(){
		if ($this->input->is_ajax_request()) {
			$response['status']=true;
  			$this->form_validation->set_rules('name', 'Name', 'trim|required');
 			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
			$this->form_validation->set_rules('phone', 'Phone Number', 'required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
			$this->form_validation->set_rules('message', 'Message', 'trim|required');
			 
			if ($this->form_validation->run() == FALSE) {
				$response['response']=$this->form_validation->error_array();
				$response['status']=FALSE;
				$response['message']='There is error in submitting form!';
			}else{
				$save_data=array(
					'id'=>0,
 					'name'=>$this->input->post('name'),
 					'email'=>$this->input->post('email'),
					 'phone'=>$this->input->post('phone'),
					 'subject'=>$this->input->post('subject'),
					 'message'=>$this->input->post('message'),
 				);
				if($this->Common_model->AddUpdateData('contact_us',$save_data)){

					$template_data['contact_us']=$save_data;

					$mail_message=$this->load->view('website/email_templates/contact-us-admin', $template_data, true);
					sendEmail(ADMINEMAIL,"",'Contact US',$mail_message);
					
					$mail_message=$this->load->view('website/email_templates/contact-us-customer', $template_data, true);
				    sendEmail($save_data['email'],"",'Contact US',$mail_message);
				
					$message = "Thank you for filling out your information!";
				}else{
					$message = "There is an error!";
					$response['status']=FALSE;
				}
 				$response['message']=$message;
			}
			echo json_encode($response);
		}
	}

	

	public function subscribe(){
		if ($this->input->is_ajax_request()) {
			$response['status']=true;
 			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
 		    if ($this->form_validation->run() == FALSE) {
				$response['response']=$this->form_validation->error_array();
				$response['status']=false;
 			}else{
 				$save_data=array(
 					'email'=>$this->input->post('email'),
 				);
				$id=$this->Website_model->subscribe($save_data);

				if(!$id){
					$response['message']="Email Address already exists!";
					$response['status']=false;
				}else{
					$template_data['subscription']=$save_data;
					
					$mail_message=$this->load->view('website/email_templates/subscription-admin', $template_data, true);
					sendEmail(ADMINEMAIL,"",'Subscription',$mail_message);
					
					$mail_message=$this->load->view('website/email_templates/subscription-customer', $template_data, true);
				    sendEmail($save_data['email'],"",'Subscription Thanks',$mail_message);
				}
			}
			echo json_encode($response);
		}
	}
	 

	 

	 

	public function showTeamDetails(){
		if ($this->input->is_ajax_request()) {
			$response['status']=true;
			$id=$this->input->post('id');
			$response['response']=getSingleTableData('our_team',array('id'=>$id))[0];
			echo json_encode($response);
		}
	}

	

 public function changeLanguage(){
	if ($this->input->is_ajax_request()) {
		$id=$this->input->post('id');
		$this->session->set_userdata('language',$id);
 	}
 }


 function pdf(){
	$pdfFilePath = "output_pdf_name.pdf";
 
	//load mPDF library
	$this->load->library('m_pdf');
	$html="";
   //generate the PDF from the given html
	$this->m_pdf->pdf->WriteHTML($html);

	//download it.
 	$this->m_pdf->pdf->Output(); // opens in browser
 }


 function exportData(){

	
	 $result=$this->db->get('area');
	 $data=$result->result_array();
	 echo '<pre>';
 	 foreach($data as $row){
		if($row['parent_id']>0){
			//$this->db->insert('states',array('country_id'=>65,'name'=>$row['name']));
			$state_id=$this->db->insert_id(); 
 		}else{
			//$this->db->insert('cities',array('country_id'=>65,'name'=>$row['name'],'state_id'=>$state_id));
  		}
		//echo '<br>';
		//echo $row['name'];
	}

 }
 	
}
