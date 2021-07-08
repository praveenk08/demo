<?php
class Products extends MY_Controller {
 
	public function index()
	{
		$where=array('u.status'=>1,'u.is_deleted'=>0);
		$data['units']=getUnitList($where);
		$where['u.role_id']=2;
		$data['vendors']=getUserList($where);
		if(isset($_POST['export']))
		{
			$this->exportProducts();
		}
   	 	$this->load->view('admin/products/manage-products',$data);
	}

		public function exportProducts()
		{
			$products = $this->Products_model->manageProductsExport($_POST,false);
			$filename = 'products_list'.date('d-m-Y m-i-s').'.csv'; 
	        header("Content-Description: File Transfer"); 
	        header("Content-Disposition: attachment; filename=$filename"); 
	        header("Content-Type: application/csv; ");
	        $file = fopen('php://output', 'w');

	        $header = array(
	            "Name",
	            "Unit name",
	            "Quantity",
	            "Total Sale",
	            "Price",
	            "Vendor Name",

	              ); 
	        fputcsv($file, $header);
	        foreach ($products as $key=>$line){ 
	          fputcsv($file,$line); 
	        }
	        fclose($file); 
	        exit; 
		}

	public function manageProducts(){
		$this->isAjaxRequest();
 		$data=$this->Products_model->manageProductsAjax($_POST,false);
		$response['data']=array();
		if(count($data)){
			foreach($data as $row){
				if(is_file('./attachments/products/thumb/'.$row['image'])){
					$image=base_url('attachments/products/thumb/'.$row['image']);	
			   }else{
				   $image='';
			   }
				$response['data'][]=array(
					'id'=>$row['id'],
					'image'=>$image,
					'name'=>$row['name'],
 					'vendor_name'=>$row['vendor_name'],
 					'price'=>$row['price'], 
 					'totalsale'=>$row['totalsale'], 
					'unit_name'=>$row['unit_name'],
					'quantity'=>$row['quantity'],
					'status'=>$row['status'],
 				);
			}
		}
		$response['total']=$this->Products_model->manageProductsAjax($_POST,true);
		$this->getJson($response);
	}

	public function manageMasterProducts(){
		$data=array();
		$this->load->view('admin/products/manage-master-products',$data); 
	}

	public function manageMasterProductsAjax(){
		$this->isAjaxRequest();
 		$data=$this->Products_model->manageMasterProductsAjax($_POST,false);
		$response['data']=array();
		if(count($data)){
			foreach($data as $row){
				$categoty_name=$row['category_name'];
				$parent_category_name=$row['parent_category_name'];
				$main_category_name=$categoty_name;
				if(!empty($parent_category_name)){
					$main_category_name=$parent_category_name.'=>'.$categoty_name;
				}
				$response['data'][]=array(
					'id'=>$row['id'],
 					'name'=>$row['name'],
 					'category_name'=>$main_category_name,
 					'status'=>$row['status'],
 				);
			}
		}
		$response['total']=$this->Products_model->manageMasterProductsAjax($_POST,true);
		$this->getJson($response);
	}

	public function viewMasterProduct(){
		$id=$this->uri->segment(2);
		if($id>0){ 
			$select=array('id'=>$id);
			$product_data=getSingleTableData('product_master',$select);
			if(count($product_data)>0){
				$data['master_product']=$product_data[0];
				$category_data=$this->Products_model->categoryProductData(array('pm.id'=>$id));
				$categoty_name=$category_data['category_name'];
				$parent_category_name=$category_data['parent_category_name'];
				$main_category_name=$categoty_name;
				if(!empty($parent_category_name)){
					$main_category_name=$parent_category_name.'=>'.$categoty_name;
				}
				$data['master_product']['category_name']=$main_category_name;
			}
			else
			{
				redirect('admin-dashboard');
			}
			$this->load->view('admin/products/view-master-product',$data); 
		}
	}
	

	public function addUpdateMasterProduct(){
		$id=$this->uri->segment(2);
		if($id>0){ 
			$select=array('id'=>$id);
			$product_data=getSingleTableData('product_master',$select);
			if(count($product_data)>0){
				$data['master_product']=$product_data[0];
				$category_data=$this->Products_model->categoryProductData(array('pm.id'=>$id));
  				if($category_data['parent_category_id']>0){
					$data['category_id']=$category_data['parent_category_id'];
					$data['child_category']=$category_data['category_id'];
				 }else{
					$data['category_id']='';
					$data['child_category']='';
				 } 
			}
			else
			{
				redirect('admin-dashboard');
			}
			$data['heading']="Update Master Product";
			$data['button']="Update";
   		 }else{
			$data['master_product']['id']=0;
			$data['master_product']['name']='';
			$data['master_product']['meta_title']='';
			$data['master_product']['meta_keywords']='';
			$data['master_product']['meta_description']='';
			$data['master_product']['status']=1;
			$data['category_id']="";
			$data['child_category']="";
			
			$data['heading']="Add Product";
			$data['button']="Add";
		}
   		$this->load->view('admin/products/add-update-master-product',$data); 
	}

	public function saveMasterProduct(){
		$this->isAjaxRequest();
		$response['status']=TRUE;
 		$name_error='';
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('category', 'Category', 'trim|required');
		$this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required');
		
 		$name=$this->input->post('name');
		$id=$this->input->post('id') ? $this->input->post('id'):0;
		if(!empty($name)){
			$where=array('name'=>$name);
			if($id>0){
				$where['id <>']=$id;
			}
			if(!$this->Common_model->checkExist('product_master',$where)){
				$response['status']=FALSE;
				$name_error="Product Name already exists";
			}
		}
  
		
		if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
			$response=$this->form_validation->error_array();
 			if(!empty($name_error)){
				$response['name']=$name_error;
			}
			$response['message']='There is error in submitting form!';
		}else{
   			$save_data=array(
				'id'=>$this->input->post('id')? $this->input->post('id'):0,
				'name'=>$this->input->post('name'),
				'meta_title'=>$this->input->post('meta_title'),
				'meta_keywords'=>$this->input->post('meta_keywords'),
				'meta_description'=>$this->input->post('meta_description'),
  				'status'=>$this->input->post('status'),
			);
			$product_master_id=$this->Common_model->AddUpdateData('product_master',$save_data);
			if($save_data['id']>0){
				$id=$save_data['id'];
				$action="Updated";
			}else{
				$id=$product_master_id;
				$action="Added";
			}

			$this->db->where('product_id',$product_master_id);
			$this->db->delete('product_category');
			$category_id=$this->input->post('child_category')?$this->input->post('child_category'):$this->input->post('category');
			$update_data=array('id'=>0,'product_id'=>$product_master_id,'category_id'=>$category_id);
			$this->Common_model->AddUpdateData('product_category',$update_data);

			$message = "Master Product ".$action." Successfully!";
			$this->session->set_flashdata('success_message',$message);
			$slug=makeSlug($save_data['name'].'-'.$id);
			$update_data=array('id'=>$id,'slug'=>$slug,'modified_date'=>'now()');
			$this->Common_model->AddUpdateData('product_master',$update_data);
			$logdata=array(
				'activity_in'=>1,
				'category'=>21,
				'reference_id'=>$id,
				'action'=>$action,
				'message'=>$message,
				'modified_data'=>json_encode($this->input->post()),
				'done_by'=>$this->session->userdata('admin_data')['id']
			);
			activityLog($logdata);
			$response['message']=$message;
			$response['id']=$id;
		}
		echo json_encode($response);
		 
	
		 
   }
	public function changeMasterProductStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			$update_data=array('id'=>$id,'status'=>$status);
			$response['status']=$this->Common_model->changeDataStatus('product_master',$update_data);
			if($response['status']){
				$response['message']="Master Product Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>6,
					'reference_id'=>$id,
					'action'=>'Updated',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
			}
			$data=array('status'=>1);
			echo json_encode($data);
		}
	}
	
	
	
	public function addUpdateProduct(){
		deleteTempFiles('./attachments/products/'.$this->session->userdata('admin_data')['id'].'/*');
 		$data=array();
			$id=$this->uri->segment(2);
			$data['secondary_images']=array();
			$data['product_categories']=array();
			$data['names']=array();
		if($id>0){
			$select=array('vp.id'=>$id);
			$data['product']=$this->Products_model->productData($select);
			$category_id=$data['product']['category_id'];
			$data['child_category']='';
			if($category_id>0){
				$category_data=categoryList(array('c.id'=>$category_id))[0];
				$data['parent_id']=$category_data['parent_id'];
				if($data['parent_id']==0){
					$data['category_id']=$category_data['id'];
				}else{
					$data['category_id']=$data['parent_id'];
					$data['child_category']=$category_data['id'];
 				}
			 }else{
				$data['category_id']='';
			 }


			$names=$this->Products_model->productNamedata($select);
			if(count($names)>0){
				foreach($names as $name){
					$data['names'][$name['abbr']]=$name;
				}	
			}
 			$data['secondary_images']=$this->Products_model->productSecondaryImagesData(array('vendor_product_id'=>$id));
			$data['heading']="Update Product";
			$data['button']="Update";
   		 }else{
			$data['product']['id']=0;
			$data['product']['master_product_id']='';
			$data['product']['quantity']='';
			$data['product']['price']='';
			$data['product']['vendor_id']='';
			$data['product']['unit_id']='';
			$data['product']['unit_value']='';
			$data['product']['category_id']=0;
			$data['product']['maturity_date']='';
			//$data['product']['weight']='';
			$data['product']['name']='';
 			$data['product']['slug']='';
			$data['product']['meta_title']='';
			$data['product']['meta_keywords']='';
			$data['product']['meta_description']='';
			$data['product']['brief']='';
			$data['product']['description']='';
			$data['product']['status']=1;
 			$data['product']['image']='';
			$data['secondary_images']=array();
			$data['category_id']='';
			$data['child_category']='';
			$data['heading']="Add Product";
			$data['button']="Add";
		}

		$where=array('u.status'=>1,'u.is_deleted'=>0);
		$data['units']=getUnitList($where);
		$where['u.role_id']=2;
		$data['vendors']=getUserList($where);
   		$where=array('c.status'=>1);
		$data['categories']=$this->Category_model->categoryList($where);
   		$this->load->view('admin/products/add-update-product',$data); 
	}

	public function viewProduct(){
		$id=$this->uri->segment(2);
		if($id>0){
			$select=array('vp.id'=>$id);
			$data['product']=$this->Products_model->productData($select);
			$data['names']=array();
			$names=$this->Products_model->productNamedata($select);
			if(count($names)>0){
					foreach($names as $name){
						$data['names'][$name['abbr']]=$name;
					}	
			}
	 
			$data['product_secondary_images']=$this->Products_model->productSecondaryImagesData(array('vendor_product_id'=>$id));
			$this->load->view('admin/products/view-product',$data);
     	}
	}
	public function addCopyProduct(){
		$id=$this->uri->segment(2);
		if($id>0){
			$data['names']=array();
 			$select=array('vp.id'=>$id);
			$data['product']=$this->Products_model->productData($select);
			$category_id=$data['product']['category_id'];
			$data['child_category']='';
			if($category_id>0){
				$category_data=categoryList(array('c.id'=>$category_id))[0];
				$data['parent_id']=$category_data['parent_id'];
				if($data['parent_id']==0){
					$data['category_id']=$category_data['id'];
				}else{
					$data['category_id']=$data['parent_id'];
					$data['child_category']=$category_data['id'];
 				}
			 }else{
				$data['category_id']='';
			 }

			$data['product']['image']='';
			$names=$this->Products_model->productNamedata($select);
			if(count($names)>0){
					foreach($names as $name){
						$data['names'][$name['abbr']]=$name;
					}	
			}
  			$data['secondary_images']=array();//$this->Products_model->productSecondaryImagesData(array('vendor_product_id'=>$id));
			 if(count($data['product'])>0){
				$data['heading']="Copy Product";
				$data['button']="Copy";
				$where=array('u.status'=>1,'u.is_deleted'=>0);
				$data['units']=getUnitList($where);
				$where['u.role_id']=2;
				$data['vendors']=getUserList($where);
				$where=array('b.status'=>1,'b.is_deleted'=>0);
  				$where=array('c.status'=>1);
				$data['categories']=$this->Category_model->categoryList($where);
				$this->load->view('admin/products/copy-product',$data); 
			 }
			 else{
				redirect('/admin-manage-products');
			 }
		}else{
			redirect('/admin-manage-products');
		}
	}

	public function copySaveProduct(){
		$this->isAjaxRequest();
		$response['status']=true;
		$old_image=$this->input->post('old_image');
		$product_image=$this->input->post('product_image');
		$this->form_validation->set_rules('name'.$this->input->post('languages')[0], 'Product Name', 'trim|required');
 		$this->form_validation->set_rules('vendor_id', 'Vendor', 'trim|required');
 		$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required');
		 $this->form_validation->set_rules('unit_id', 'Unit', 'trim|required');
		 $this->form_validation->set_rules('unit_value', 'Unit Value', 'trim|required');
		 $this->form_validation->set_rules('price', 'Price', 'trim|required');
		//$this->form_validation->set_rules('weight', 'Weight', 'trim|required');
 

		if(empty($_FILES['image']['name']) && empty($old_image) && empty($product_image)){
			$this->form_validation->set_rules('image', 'Image', 'required');
		}

		if($this->form_validation->run() == TRUE && $response['status']==TRUE){
			$product_image=$this->input->post('product_image');
			$image_path['full_path']=$this->input->post('image_path');
			$image_path['file_name']=$product_image;
			$old_image=$this->input->post('old_image');
			if(!empty($product_image)){
				$image_sizes = array('thumb' => array(80, 80),'medium' => array(600, 450));
				$path='./attachments/products/'; 
				resizeImage($path,$image_path,$old_image,$image_sizes);
				if(is_file($image_path['full_path'])){
					copy($image_path['full_path'],$path.'main/'.$product_image);
					unlink($image_path['full_path']);
				}
			}else{
				$product_image=$old_image;
			}
			$secondary_images=$this->input->post('product_secondary_image');
			$old_product_secondary_images=$this->input->post('old_product_secondary_image');
			if(count($secondary_images)>0){
				foreach($secondary_images as $secondary_image){
					if(!empty($secondary_image)){
						$image_path['full_path']='./attachments/products/'.$this->session->userdata('admin_data')['id'].'/'.$secondary_image;
						$image_path['file_name']=$secondary_image;
						$image_sizes = array('thumb' => array(80, 80),'medium' => array(600, 450));
						$path='./attachments/products/'; 
						resizeImage($path,$image_path,'',$image_sizes);
						if(is_file($image_path['full_path'])){
							copy($image_path['full_path'],$path.'main/'.$secondary_image);
							unlink($image_path['full_path']);
						}
					}
				}
			}
		}

		if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
			$response=$this->form_validation->error_array();
			$response['message']='There is error in submitting form!';
		}else{
			$save_data=array(
			'id'=>0,
			'vendor_id'=>$this->input->post('vendor_id'),
			'product_id'=>$this->input->post('master_product_id'),
			'unit_id'=>$this->input->post('unit_id'),
			'unit_value'=>$this->input->post('unit_value'),
			'quantity'=>$this->input->post('quantity'),
			'price'=>$this->input->post('price'),
		//	'weight'=>$this->input->post('weight'),
			'image'=>$product_image,
			'status'=>$this->input->post('status'),
			'meta_title'=>$this->input->post('meta_title'), 
			'meta_keywords'=>$this->input->post('meta_keywords'), 
			'meta_description'=>$this->input->post('meta_description'), 
			);

		$vendor_product_id=$this->Common_model->AddUpdateData('vendor_products',$save_data);
		if($vendor_product_id){
			$slug=makeSlug($this->input->post('name'.$this->input->post('languages')[0]).'-'.$vendor_product_id);
			$update_data=array('id'=>$vendor_product_id,'slug'=>$slug);
			$this->Common_model->AddUpdateData('vendor_products',$update_data);

			if(count($old_product_secondary_images)>0){
				foreach($old_product_secondary_images as $old_product_secondary_image){
					if(!empty($old_product_secondary_image)){
						$save_image_data=array(
						'id'=>0,
						'vendor_product_id'=>$vendor_product_id,
						'image'=>$old_product_secondary_image
						); 
						$this->Common_model->AddUpdateData('product_images',$save_image_data);
					}
				}
			}

			if(count($secondary_images)>0){
				foreach($secondary_images as $secondary_image){
					if(!empty($secondary_image)){
						$save_image_data=array(
						'id'=>0,
						'vendor_product_id'=>$vendor_product_id,
						'image'=>$secondary_image
						); 
						$this->Common_model->AddUpdateData('product_images',$save_image_data);
					}
				}
			}
			$languages=$this->input->post('languages');
			if(count($languages)){
				foreach($languages as $language){
					$save_data=array(
					'id'=>0,
					'vendor_product_id'=>$vendor_product_id,
					'product_id'=>$this->input->post('master_product_id'),
					'vendor_id'=>$this->input->post('vendor_id'),
					'name'=>$this->input->post('name'.$language),
					'abbr'=>$language,
					'brief'=>$this->input->post('brief'.$language),
					'description'=>$this->input->post('description'.$language),
					);
					$this->Common_model->AddUpdateData('product_translator',$save_data);
					}
				}
			}

		$message = "Product Added Successfully!";
		$this->session->set_flashdata('success_message',$message);
		$logdata=array(
		'activity_in'=>1,
		'category'=>6,
		'reference_id'=>$vendor_product_id,
		'action'=>'Added',
		'message'=>$message,
		'modified_data'=>json_encode($this->input->post()),
		'done_by'=>$this->session->userdata('admin_data')['id']
		);
		activityLog($logdata);
		$response['message']=$message;
		}
		echo json_encode($response);
	}



		public function saveProduct(){
 			$this->isAjaxRequest();
 			$response['status']=true;
			$old_image=$this->input->post('old_image');
			$product_image=$this->input->post('product_image');
			$this->form_validation->set_rules('vendor_id', 'Vendor', 'trim|required');
			$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required');
			$this->form_validation->set_rules('unit_id', 'Unit', 'trim|required');
			$this->form_validation->set_rules('unit_value', 'Unit Value', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			//$this->form_validation->set_rules('weight', 'Weight', 'trim|required');
 			if($this->input->post('id')<1){
 				$this->form_validation->set_rules('name'.$this->input->post('languages')[0], 'Product Name', 'trim|required');
 			}
			$this->form_validation->set_rules('maturity_date', 'Maturity Date', 'trim|required');
			
			if(empty($_FILES['image']['name']) && empty($old_image) && empty($product_image)){
				$this->form_validation->set_rules('image', 'Image', 'required');
			}

			if($this->form_validation->run() == TRUE && $response['status']==TRUE){
				$product_image=$this->input->post('product_image');
				$image_path['full_path']=$this->input->post('image_path');
				$image_path['file_name']=$product_image;
				$old_image=$this->input->post('old_image');
				if(!empty($product_image)){
					$image_sizes = array('thumb' => array(80, 80),'medium' => array(600, 450));
					$path='./attachments/products/'; 
					resizeImage($path,$image_path,$old_image,$image_sizes);
					if(is_file($image_path['full_path'])){
						copy($image_path['full_path'],$path.'main/'.$product_image);
						unlink($image_path['full_path']);
					}
				}else{
					$product_image=$old_image;
				}
				$secondary_images=$this->input->post('product_secondary_image');
				$old_product_secondary_images=$this->input->post('old_product_secondary_image');
				if(count($secondary_images)>0){
					foreach($secondary_images as $secondary_image){
						if(!empty($secondary_image)){
							$image_path['full_path']='./attachments/products/'.$this->session->userdata('logged_in').'/'.$secondary_image;
							$image_path['file_name']=$secondary_image;
							$image_sizes = array('thumb' => array(80, 80),'medium' => array(600, 450));
							$path='./attachments/products/'; 
							resizeImage($path,$image_path,'',$image_sizes);
							if(is_file($image_path['full_path'])){
								copy($image_path['full_path'],$path.'main/'.$secondary_image);
								unlink($image_path['full_path']);
							}
						}
					}
				} 
			}
			if ($this->form_validation->run() == FALSE || $response['status']==FALSE) {
				$response=$this->form_validation->error_array();
				$response['message']='There is error in submitting form!';
			}else{
				$vendor_product_id=$this->input->post('id');
				$master_product_id=$this->input->post('master_product_id');
				if($vendor_product_id>0){
					$product_id=$master_product_id;
				}else{
					$save_data=array(
						'id'=>$this->input->post('id')? $this->input->post('id'):0,
 						'name'=>$this->input->post('name'.$this->input->post('languages')[0]), 
						'meta_title'=>$this->input->post('meta_title'), 
						'meta_keywords'=>$this->input->post('meta_keywords'), 
						'meta_description'=>$this->input->post('meta_description'), 
						'status'=>$this->input->post('status'),
						);
						$product_id=$this->Common_model->AddUpdateData('product_master',$save_data);

						$slug=makeSlug($save_data['name'].$this->input->post('languages')[0].'-'.time());
					$update_data=array('id'=>$product_id,'slug'=>$slug,'modified_date'=>'now()');
					$this->Common_model->AddUpdateData('product_master',$update_data);

					/*$categories=$this->input->post('category');
					if(count($categories)){
						foreach($categories as $category){
							if($category>0){
								$save_data=array(
									'id'=>0,
									'product_id'=>$product_id,
									'category_id'=>$category,
								);
								$this->Common_model->AddUpdateData('product_category',$save_data);
							}
						}
					}*/


					$child_category=$this->input->post('child_category');
						if($child_category>0){
							$category_id=$child_category;
						}else{
							$category_id=$this->input->post('category')?$this->input->post('category'):0;
						}
						$save_data=array(
							'id'=>0,
							'product_id'=>$product_id,
							'category_id'=>$category_id,
						);
						$this->Common_model->AddUpdateData('product_category',$save_data);


				}

				if($product_id){
				$vendor_product_save_data=array(
					'id'=>$this->input->post('id')? $this->input->post('id'):0,
					'vendor_id'=>$this->input->post('vendor_id'),
					'product_id'=>$product_id,
					'unit_id'=>$this->input->post('unit_id'),
					'unit_value'=>$this->input->post('unit_value'),
					'quantity'=>$this->input->post('quantity'),
					'price'=>$this->input->post('price'),
					'maturity_date'=>date('Y-m-d',strtotime($this->input->post('maturity_date'))),
					'meta_title'=>$this->input->post('meta_title'), 
					'meta_keywords'=>$this->input->post('meta_keywords'), 
					'meta_description'=>$this->input->post('meta_description'), 
					'image'=>$product_image,
					'status'=>$this->input->post('status'),
				);
				
				$vendor_product_id=$this->Common_model->AddUpdateData('vendor_products',$vendor_product_save_data);
				if($vendor_product_id){
					$slug=makeSlug($this->input->post('name'.$this->input->post('languages')[0]).'-'.$vendor_product_id);
					$update_data=array('id'=>$vendor_product_id,'slug'=>$slug);
					$this->Common_model->AddUpdateData('vendor_products',$update_data);

					$this->db->where('vendor_product_id',$vendor_product_id);
					$this->db->delete('product_images');
					if(count($old_product_secondary_images)>0){
						foreach($old_product_secondary_images as $old_product_secondary_image){
							if(!empty($old_product_secondary_image)){
								$save_image_data=array(
									'id'=>0,
									'vendor_product_id'=>$vendor_product_id,
									'image'=>$old_product_secondary_image
								); 
								$this->Common_model->AddUpdateData('product_images',$save_image_data);
							}
						}
					}
					if(count($secondary_images)>0){
						foreach($secondary_images as $secondary_image){
							if(!empty($secondary_image)){
								$save_image_data=array(
									'id'=>0,
									'vendor_product_id'=>$vendor_product_id,
									'image'=>$secondary_image
								); 
								$this->Common_model->AddUpdateData('product_images',$save_image_data);
							}
						}
					}
					$languages=$this->input->post('languages');
					if(count($languages)){
						$this->db->where('vendor_product_id',$vendor_product_id);
						$this->db->delete('product_translator');
						foreach($languages as $language){
 							$save_data=array(
								'id'=>0,
								'vendor_product_id'=>$vendor_product_id,
								'product_id'=>$product_id,
								'vendor_id'=>$this->input->post('vendor_id'),
								'name'=>$this->input->post('name'.$language),
								'abbr'=>$language,
 								'brief'=>$this->input->post('brief'.$language),
								'description'=>$this->input->post('description'.$language),
								'status'=>$this->input->post('status'),
							);
							$this->Common_model->AddUpdateData('product_translator',$save_data);
						}
					}
				}
			}
			if($vendor_product_save_data['id']>0){
				$id=$vendor_product_save_data['id'];
				$action="Updated";
			}else{
				$id=$vendor_product_id;
				$action="Added";
			}
			$message = "Product ".$action." Successfully!";
			$this->session->set_flashdata('success_message',$message);
			$logdata=array(
				'activity_in'=>1,
				'category'=>6,
				'reference_id'=>$id,
				'action'=>$action,
				'message'=>$message,
				'modified_data'=>json_encode($this->input->post()),
				'done_by'=>$this->session->userdata('admin_data')['id']
			);
			activityLog($logdata);
			$response['message']=$message;
			}
			echo json_encode($response);
		}

	public function changeProductStatus(){
		$this->isAjaxRequest();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			$update_data=array('id'=>$id,'status'=>$status);
			$response['status']=$this->Common_model->changeDataStatus('vendor_products',$update_data);
			if($response['status']){
				$response['message']="Product Status Updated Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>6,
					'reference_id'=>$id,
					'action'=>'Updated',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
			}
			$data=array('status'=>1);
			echo json_encode($data);
		}
	}

 
	function deleteProduct(){
		$this->isAjaxRequest();
		$id=$this->input->post('action_id');
		if(!empty($id)){
 			$where=array('id'=>$id);
			$update_data['is_deleted']=1;
 			$response['status']=$this->Common_model->updateData('vendor_products',$where,$update_data);
			if($response['status']){
	
				$where=array('vendor_product_id'=>$id);
 				$this->Common_model->updateData('product_images',$where,$update_data);
				$this->Common_model->updateData('product_translator',$where,$update_data);

				$response['message']="Product Deleted Successfully!";
				$logdata=array(
					'activity_in'=>1,
					'category'=>6,
					'reference_id'=>$id,
					'action'=>'Deleted',
					'message'=>$response['message'],
					'modified_data'=>json_encode($this->input->post()),
					'done_by'=>$this->session->userdata('admin_data')['id']
				);
				activityLog($logdata);
				
			}
			echo json_encode($response);
		}
	}

 

function uploadProductImage()
{
	$this->isAjaxRequest();
	$response=uploadCroperImage('products',$this->session->userdata('admin_data')['id'],$this->input->post('image'));
	echo json_encode($response);
}
 


//deleteProductImage

public function deleteProductImage(){
	$this->isAjaxRequest();
	$id=$this->input->post('id');
	$image=$this->input->post('image');
	if(!empty($id) && !empty($image)){
		$update_data=array(
			'image'=>'',
			'id'=>$id
		);
		$result=$this->Common_model->AddUpdateData('vendor_products',$update_data);
		unlinkImage('products',$image);
		if($result){
			$response['message']="Product Image deleted successfully!";
			$logdata=array(
				'activity_in'=>1,
				'category'=>6,
				'reference_id'=>$id,
				'action'=>'Deleted',
				'message'=>$response['message'],
				'modified_data'=>json_encode($this->input->post()),
				'done_by'=>$this->session->userdata('admin_data')['id']
			);
			activityLog($logdata);
			$response['status']=true;
		}else{
			$response=array('status'=>false,'message'=>"There is an error!");
		}
		echo json_encode($response);
	}
}

public function deleteProductSecondaryImage(){
	$this->isAjaxRequest();
	$id=$this->input->post('id');
	$image=$this->input->post('image');
	if(!empty($id) && !empty($image)){
		$where=array('id'=>$id);
		$result=$this->Common_model->deleteRecord($where,'product_images');
		unlinkImage('products',$image);
		if($result){
			$response['message']="Product Secondary Image deleted successfully!";
			$logdata=array(
				'activity_in'=>1,
				'category'=>6,
				'reference_id'=>$id,
				'action'=>'Deleted',
				'message'=>$response['message'],
				'modified_data'=>json_encode($this->input->post()),
				'done_by'=>$this->session->userdata('admin_data')['id']
			);
			activityLog($logdata);
			$response['status']=true;
		}else{
			$response=array('status'=>false,'message'=>"There is an error!");
		}
		echo json_encode($response);
	}
}

public function autoSuggestionProduct(){
	$this->isAjaxRequest();
	$name=$this->input->post('name');
	if(!empty($name)){
		$response['data']=$this->Common_model->autoSuggestionProduct($name);
		$response['status']=true;
		echo json_encode($response);
	}
}


}
