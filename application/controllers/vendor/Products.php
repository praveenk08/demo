<?php
class Products extends VendorController {


	public function index()
	{
 		$where=array('u.status'=>1);
		$data['units']=getUnitList($where);
		if(isset($_POST['export'])){
			$this->manageProductsFile();
		}
  	 	$this->load->view('vendor/products/manage-products',$data);
	}


	public function manageProductsFile(){
		//echo"<pre>"; print_r($_POST); die;
		$Products= $this->Products_model->manageProductsExport($_POST,$count=false);
		//echo"<pre>"; print_r($Products); die;
		$filename = 'products_list'.date('d-m-Y m-i-s').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
        $file = fopen('php://output', 'w');

        $header = array(
            "Product Name",
            "Unit Name",
            "Quantity",
            "Total Sale",
            "Price",
             "Status",
            "Vendor Name",
               ); 
        fputcsv($file, $header);
        foreach ($Products as $key=>$line){ 
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
  					'price'=>$row['price'], 
 					'totalsale'=>$row['totalsale'], 
					'unit_name'=>$row['unit_name'],
					'quantity'=>$row['quantity'],
					'total_visitors'=>$row['total_visitors'],
					'status'=>$row['status'],
 				);
			}
		}
		$response['total']=$this->Products_model->manageProductsAjax($_POST,true);
		$this->getJson($response);
	}
	function deleteTempFiles(){
		$files = glob('./attachments/products/'.$this->session->userdata('vendor_data')['id'].'/*');
		foreach($files as $file){
			if(is_file($file)){
				unlink($file);
			}
		}
	}
	public function addUpdateProduct(){
		$this->deleteTempFiles();
 		$data=array();
			$id=$this->uri->segment(2);
			$data['secondary_images']=array();
			$data['product_categories']=array();
			$data['names']=array();
		if($id>0){
			$select=array('vp.id'=>$id,'vp.vendor_id'=>$this->session->userdata('vendor_data')['id']);
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
			 //print_r($data);
			 //die;
   			if(!empty($data['product']['id'])){
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
				redirect('/vendor-manage-products');
			}
			
   		 }else{
			$data['product']['id']=0;
			$data['product']['master_product_id']='';
			$data['product']['quantity']='';
			$data['product']['price']='';
			$data['product']['vendor_id']='';
			$data['product']['unit_id']='';
			//$data['product']['unit_value']='';
			$data['product']['name']='';
 			$data['product']['maturity_date']=date('d-m-Y');
 			$data['product']['maturity_to_date']=date('d-m-Y');
			$data['product']['slug']='';
			$data['product']['meta_title']='';
			$data['product']['meta_keywords']='';
			$data['product']['meta_description']='';
			$data['product']['brief']='';
			$data['product']['description']='';
			$data['product']['status']=1;
			$data['product']['image']='';
			$data['category_id']='';
			$data['child_category']='';
			$data['secondary_images']=array();
			$data['heading']="Add Product";
			$data['button']="Add";
		}

		$where=array('u.status'=>1,'u.is_deleted'=>0,'ut.abbr'=>'en');
		$data['units']=getUnitList($where);
   		$where=array('c.status'=>1,'c.is_deleted'=>'0','ct.abbr'=>'en');
		$data['categories']=$this->Common_model->categoryList($where);
   		$this->load->view('vendor/products/add-update-product',$data); 
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
			$this->load->view('vendor/products/view-product',$data);
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
				$category_data=categoryList(array('c.id'=>$category_id,'ct.abbr'=>'en'))[0];
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
				$data['heading']="Add Product";
				$data['button']="Add";
				$where=array('u.status'=>1,'u.is_deleted'=>0);
				$data['units']=getUnitList($where);
 				$where=array('c.status'=>1);
 				$this->load->view('vendor/products/copy-product',$data); 
			 }
			 else{
				redirect('/vendor-manage-products');
			 }
		}else{
			redirect('/vendor-manage-products');
		}
	}

	public function copySaveProduct(){
		$this->isAjaxRequest();
		$response['status']=true;
 		$old_image=$this->input->post('old_image')?$this->input->post('old_image'):'';
		$product_image=$this->input->post('product_image')?$this->input->post('product_image'):'';
		$this->form_validation->set_rules('name'.$this->input->post('languages')[0], 'Product Name', 'trim|required');
   		$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required');
		   $this->form_validation->set_rules('unit_id', 'Unit', 'trim|required');
		  // $this->form_validation->set_rules('unit_value', 'Unit Value', 'trim|required');
		   $this->form_validation->set_rules('price', 'Price', 'trim|required');
 		$this->form_validation->set_rules('maturity_date', 'Maturity Date', 'trim|required');
 		$this->form_validation->set_rules('maturity_to_date', 'Maturity To Date', 'trim|required');
		

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
						$image_path['full_path']='./attachments/products/'.$this->session->userdata('vendor_data')['id'].'/'.$secondary_image;
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
			'vendor_id'=>$this->session->userdata('vendor_data')['id'],
			'product_id'=>$this->input->post('master_product_id'),
			'unit_id'=>$this->input->post('unit_id'),
			//'unit_value'=>$this->input->post('unit_value'),
			'quantity'=>$this->input->post('quantity'),
			'price'=>$this->input->post('price'),
 			'maturity_date'=>date('Y-m-d',strtotime($this->input->post('maturity_date'))),
 			'maturity_to_date'=>date('Y-m-d',strtotime($this->input->post('maturity_to_date'))),
 			'status'=>$this->input->post('status'),
			'meta_title'=>$this->input->post('meta_title'), 
			'meta_keywords'=>$this->input->post('meta_keywords'), 
			'meta_description'=>$this->input->post('meta_description'), 
			);
			if(!empty($product_image)){
				$save_data['image']=$product_image;
			}

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
					'vendor_id'=>$this->session->userdata('vendor_data')['id'],
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
		'done_by'=>$this->session->userdata('vendor_data')['id']
		);
		activityLog($logdata);
		$response['message']=$message;
		}
		echo json_encode($response);
	}



		public function saveProduct(){
			$this->isAjaxRequest();
 			$response['status']=true;
 			$old_image=$this->input->post('old_image') ? $this->input->post('old_image'):'';
			$product_image=$this->input->post('product_image') ? $this->input->post('product_image'):'';
 			$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required');
			 $this->form_validation->set_rules('unit_id', 'Unit', 'trim|required');
			// $this->form_validation->set_rules('unit_value', 'Unit Value', 'trim|required');
			 $this->form_validation->set_rules('price', 'Price', 'trim|required');
  			if($this->input->post('id')<1){
 				$this->form_validation->set_rules('name'.$this->input->post('languages')[0], 'Product Name', 'trim|required');
 				$this->form_validation->set_rules('category', 'Category Name', 'trim|required');
 			}
			$this->form_validation->set_rules('maturity_date', 'Maturity Date', 'trim|required');
			$this->form_validation->set_rules('maturity_to_date', 'Maturity To Date', 'trim|required');
			
			//if(empty($_FILES['image']['name']) && empty($old_image) && empty($product_image)){
			if(empty($old_image) && empty($product_image)){
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
				$secondary_images=$this->input->post('product_secondary_image')?$this->input->post('product_secondary_image'):array();
				$old_product_secondary_images=$this->input->post('old_product_secondary_image')?$this->input->post('old_product_secondary_image'):array();
				if(count($secondary_images)>0){
					foreach($secondary_images as $secondary_image){
						if(!empty($secondary_image)){
							$image_path['full_path']='./attachments/products/'.$this->session->userdata('vendor_data')['id'].'/'.$secondary_image;
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
				$response['status']=FALSE;
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

						$slug=makeSlug($save_data['name'].$this->input->post('languages')[0].'-'.$product_id);
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
					'vendor_id'=>$this->session->userdata('vendor_data')['id'],
					'product_id'=>$product_id,
					'unit_id'=>$this->input->post('unit_id'),
					//'unit_value'=>$this->input->post('unit_value'),
					'quantity'=>$this->input->post('quantity'),
					'price'=>$this->input->post('price'),
 					'maturity_date'=>date('Y-m-d',strtotime($this->input->post('maturity_date'))),
 					'maturity_to_date'=>date('Y-m-d',strtotime($this->input->post('maturity_to_date'))),
					'meta_title'=>$this->input->post('meta_title'), 
					'meta_keywords'=>$this->input->post('meta_keywords'), 
					'meta_description'=>$this->input->post('meta_description'), 
 					'status'=>$this->input->post('status'),
				);
				if(!empty($product_image)){
					$vendor_product_save_data['image']=$product_image;	
				}
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
								'vendor_id'=>$this->session->userdata('vendor_data')['id'],
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
				'done_by'=>$this->session->userdata('vendor_data')['id']
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
					'done_by'=>$this->session->userdata('vendor_data')['id']
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
					'done_by'=>$this->session->userdata('vendor_data')['id']
				);
				activityLog($logdata);
				
			}
			echo json_encode($response);
		}
	}

 

function uploadProductImage()
{

	$this->isAjaxRequest();
	$image_parts = explode(";base64,", $this->input->post('image'));
	$image_type_aux = explode("image/", $image_parts[0]);
	$image_type = 'jpeg';
	$filename=uniqid().'.' .$image_type;
	if(!file_exists('./attachments/products/'.$this->session->userdata('vendor_data')['id'])){
		$src = "./attachments/products/thumb"; 
		$dst = "./attachments/products/".$this->session->userdata('vendor_data')['id']; 
		customCopy($src, $dst);
 	}
	$filepath = './attachments/products/'.$this->session->userdata('vendor_data')['id'].'/'.$filename;
	$blob= $image_parts[1];
	file_put_contents($filepath,  base64_decode( str_replace('data:image/jpeg;base64,', '', $blob)));
	$response=array('image_path'=>$filepath,'image_name'=>$filename,'image_id'=>time());
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
				'done_by'=>$this->session->userdata('vendor_data')['id']
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
				'done_by'=>$this->session->userdata('vendor_data')['id']
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


public function queryGen(){
	$this->db->select("
	at.id,
	at.user_id,
	CONCAT(c.first_name,' ',c.last_name) as name,
	at.type,
	at.total_booked_tickets,
	at.order_type,
	at.tickets_total_amount,
	os.name as order_status,
	DATE_FORMAT(at.order_datetime, '%d/%m/%Y %H:%i %p') as order_datetime,
	td.ticket_no 
	");
	$this->db->from('all_tickets at');
	$this->db->join('ticket_details td', 'td.tickets_id=at.id');
	$this->db->join('customer c','c.id=at.user_id','inner');
	$this->db->join('order_status os','os.id=at.order_status','inner');
	//$this->db->join('category c','c.id=e.category_id','inner');
	//$this->db->join('organizer o','o.id=e.organizer_id','inner');
	//$this->db->join('organizer_category orgCat','o.category_id=orgCat.id','inner');		
	$result=$this->db->get();
	return $result->result_array();
   }
   


   public function customerDetailsRecord($table,$where){
	if(count($where)>0){
		$this->db->where($where);
	}
	$result=$this->db->get($table);
	$response=$result->row_array();
	 return $response;
}

public function export(){
 
	$filename = 'users_'.date('Ymd').'.csv'; 
	header("Content-Description: File Transfer"); 
	header("Content-Disposition: attachment; filename=$filename"); 
	header("Content-Type: application/csv; ");
		



		// get data 
	$customer_data=array();
	$response=$this->queryGen();
	foreach($response as $data){
		$type=$data['type'];
		$where=array('id'=>$data['user_id']);
		if($type!=0){
			$table='customer_details';
			$user_data=$this->customerDetailsRecord($table,$where);
			$relation=$this->config->item('staying_type')[$type];
		}else{
			$table='customer';
			$user_data=$this->customerDetailsRecord($table,$where);
			$relation="ME";
		}
		$name=$user_data['first_name'].' '.$user_data['last_name'];
		$email=$user_data['email'];
		$contact_no=$user_data['contact_no'];
		$occupation=$user_data['occupation'];
		$dob=getDateDMY($user_data['dob']);
		//$title=$this->config->item('name_titles')[$user_data['title']];
		$ticket_no=$data['ticket_no'];

		 $customer_data[]=array(
			'id'=>$data['id'],
			'booked_by'=>ucwords($name),
			'type'=>$data['type']?"Event":'Package',
			'total_booked_tickets'=>$data['total_booked_tickets'],
			'order_type'=>$this->config->item('booking_type')[$data['order_type']],
			'tickets_total_amount'=>$data['tickets_total_amount'],
			'order_status'=>$data['order_status'],
			'order_datetime'=>$data['order_datetime'],
			'ticket_no'=>$ticket_no,
			'title'=>$title,
			'name'=>ucwords($name),			
			'email'=>$email,
			'occupation'=>$occupation,
			'contact_no'=>$contact_no,
			'dob'=>$dob,
			'relation'=>$relation,
			
		 );
 
		}

	// file creation 
	$file = fopen('php://output', 'w');
  
	$header = array(
		"Booking ID",
		"Booked by",
		"Type",
		"Total Tickets Booked",
		"Booking type",
		"Total Amount",
		"Booking Status",
		"Booking Date",
		"Ticket No",
 		"Name",
		"Email",
		"Occupation",
		"Phone",
		"DOB",
		"Relation",
); 
	fputcsv($file, $header);
	foreach ($customer_data as $key=>$line){ 
	  fputcsv($file,$line); 
	}
	fclose($file); 
	exit; 

 
}

}




