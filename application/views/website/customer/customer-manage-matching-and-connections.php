<?php
   $this->load->view('website/includes/header');
   if($this->session->userdata('language')=='en'){
      $home_label="Home";
      $matching_and_connections_label="Matching and Connections";
      $select_status_label="Select Status";
      $select_category_label="Select Category";
      $select_sub_category_label="Select Sub Category";
      $active_label="Active";
      $inactive_label="In-active";
      $image_label="Image";
      $category_name_label="Category Name";
      $main_category_name_label="Main Category Name";
      $status_label="Status";
      $action_label="Action";
    }else{
      $home_label="الصفحة الرئيسية";
      $matching_and_connections_label="مطابقة والاتصالات";
      $select_status_label="اختر الحالة";
      $select_category_label="اختر الفئة";
      $select_sub_category_label="اختر الفئة الفرعية";
      $active_label="نشيط";
      $inactive_label="غير نشط";
      $image_label="صورة";
      $category_name_label="اسم التصنيف";
      $main_category_name_label="اسم الفئة الرئيسية";
      $status_label="الحالة";
      $action_label="عمل";
   }
   ?>
<!-- Main body wrapper -->
<div class="mainBody">
   <div class="msBreadcrumb">
      <div class="container-fluid">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><?php echo $home_label;?></a></li>
            <li class="breadcrumb-item active"><?php echo $matching_and_connections_label;?></li>
         </ol>
      </div>
   </div>
   <div class="userWrapper">
      <div class="container-fluid">
         <div class="cwContainer">
            <div class="uwBox d-flex flex-wrap">
               <?php $this->load->view('website/customer/left-panel');?>
               <div class="profileRt">
                  <div class="tab-content">
                     <div class="tab-pane active" id="myProfile">
                        <div   id="serviceList">
                           <div class="srvHead d-flex flex-wrap align-items-center">
                              <h5><?php echo $matching_and_connections_label;?></h5>
                              <a href="javascript:void(0)" class="btn signupBtn" id="add_product">Add Crop</a>
                           </div>
                           <div id="success_message" > <?php if($this->session->flashdata('success_message')){ ?> 
                           <div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?>
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                           </div>
                           <?php } ?></div>
                           <form id="add_product_form">
                              <div id="add_box" style="display:none;" >
                                 <div class="row">
                                    <div class="form-group col-md-6">
                                       <label for="Category">Category<span class="mandatory">*</span></label>
                                       <?php
                                          $categories=categoryList(array('c.parent_id'=>0,'c.status'=>1,'ct.abbr'=>$this->session->userdata('language')));
                                          ?>
                                       <select id="change_product_category" name="change_product_category" class="form-control">
                                          <option value=""><?php echo $select_category_label;?></option>
                                          <?php
                                             foreach($categories as $category){
                                             ?>
                                          <option value="<?php echo $category['id']?>"><?php echo $category['name'];?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                       <span class="error" id="change_product_category_error">
                                    </div>
                                    <div class="col-sm-6">
                                       <label for="Sub Category">Sub Category<span class="mandatory">*</span></label>
                                       <select id="child_category" name="child_category" class="form-control">
                                          <option value=""><?php echo $select_sub_category_label;?></option>
                                       </select>
                                       <span class="error" id="child_category">
                                    </div>
                                    <div class="col-sm-6">
                                       <label for="Photo">Photo</label>
                                       <input type="file" name="product_image" id="product_image">
                                       <span class="error" id="product_image_error"></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                       <label for="Status">Status</label>
                                       <select class="form-control" id="address_status" name="status">
                                          <option value="1" selected="">Active</option>
                                          <option value="0">In-active</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="row form-group">
                                    <label class="col-sm-6"></label>
                                    <div class="col-sm-8">
                                       <button type="button" class="btn signupBtn" id="add_product_btn">Add</button>
                                       <input type="button" value="Cancel" class="btn signupBtn" id="cancel">
                                    </div>
                                 </div>
                                 <hr>
                           </form>
                          
                           </div>
                           <div class="row form-group">
                              <div class="col-sm-4">
                                 <select id="change_category" class="form-control change">
                                    <option value=""><?php echo $select_category_label;?></option>
                                    <?php
                                       foreach($categories as $category){
                                       ?>
                                    <option value="<?php echo $category['id']?>"><?php echo $category['name'];?></option>
                                    <?php
                                       }
                                       ?>
                                 </select>
                              </div>
                              <div class="col-sm-4">
                                 <select id="change_child_category" class="form-control change">
                                    <option value=""><?php echo $select_sub_category_label;?></option>
                                 </select>
                              </div>
                              <div class="col-sm-4">
                                 <select id="change_status" class="form-control">
                                    <option value=""><?php echo $select_status_label;?></option>
                                    <option value="1"><?php echo $active_label;?></option>
                                    <option value="0"><?php echo $inactive_label;?></option>
                                 </select>
                              </div>
                           </div>
                           <div class="srvListTable table-responsive" id="product_list_section">
                              <div class="loading text-center" id="srvLoader" style="display:none;"></div>
                              <table class="table table-bordered">
                                 <thead class="text-uppercase">
                                    <tr>
                                       <th><?php echo $image_label;?></th>
                                       <th><?php echo $category_name_label;?></th>
                                       <th><?php echo $main_category_name_label;?></th>
                                       <th><?php echo $status_label;?></th>
                                       <th><?php echo $action_label;?></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                       $sr=1;
                                       //echo $this->db->last_query();
                                       foreach($products as $product){
                                       	?>
                                    <tr>
                                       <td>
                                          <div class="srvImg">
                                             <?php if(is_file('attachments/products/thumb/'.$product['image'])){
                                                ?>
                                             <img src="<?php echo base_url('attachments/products/thumb/'.$product['image'])?>">
                                             <?php
                                                }else{
                                                	?>
                                             <img src="<?php echo base_url();?>/assets/frontend/images/prd1.jpg" style="height:80px;width:80px;">
                                             <?php
                                                }
                                                ?>
                                          </div>
                                       </td>
                                       <td><?php echo $product['category_name'];?></td>
                                       <td><?php echo $product['parent_category_name'];?></td>
                                       <td>
                                          <span id="status<?php echo $product['id'];?>">
                                          <a href="javascript:void(0)" onClick="addUpdateStatus('<?php echo $product['id'];?>','<?php echo $product['status'];?>')"><?php
                                             if($product['status']==1){ ?><span class='btn btn-sm btn-success'><?php echo $active_label;?></span>	
                                          <?php
                                             }else{ ?> <span class='btn btn-sm btn-danger'><?php echo $inactive_label;?></span><?php	} ?></a></span>
                                       </td>
                                       <td class="prAction" data-title="Remove" style="text-align:center">
											      <a href="javascript:void(0)" class="remove_item" data_id="<?php echo $product['id'];?>"><i class="fas fa-trash"></i></a></td>
                                    </tr>
                                    <?php
                                       $sr++;
                                       }
                                       ?>
                                 </tbody>
                              </table>
                              <div class="msPagination mt-3" id="pagination-section">
                                 <?php echo $this->ajax_pagination->create_links(); ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <input type="hidden" id="category_id" value="">
</div>
		
<?php
	$this->load->view('website/includes/footer');
 ?>
<script>
      function changeProductCategory(category_id,key){
         $('#'+key).html('');
         var change_child_category_html="<option value=''><?php echo $select_sub_category_label;?></option>";
					$.ajax({
						type: "POST",
						url: '<?php echo base_url(); ?>common/Common/getChildCategories/',
						data: {'id':category_id,'abbr':'<?php echo $this->session->userdata('language');?>'},
						success: function (ajaxresponse) {
							response = JSON.parse(ajaxresponse);
							if(response.length){
								for(i=0;i<response.length;i++){
									change_child_category_html +='<option value="'+response[i]['id']+'">'+response[i]['name']+'</option>';
                        }
                     }
							$('#'+key).html(change_child_category_html);
						}
					});
      }
		$(function(){
         $('.remove_item').click(function(){
            $('#action_id').val($(this).attr('data_id'))
            $('#deleteRecordPouup').modal('show');
            $('#delete_record_confirmation_message').html('Are you sure want to delete this record!');
         })
         $('#deleteRecord').click(function(){
   	      deleteActionPerform('<?php echo base_url('customer-delete-matching-and-connection')?>');
         })
         $('#add_product_btn').click(function(){
            $('#add_product_btn').attr("disabled", true);
            $('#add_product_form select').css('border', '1px solid #ccc');
            $('#success_message').html('');
            $('.error').remove();
            $.ajax({
               url: '<?php echo base_url('customer-save-product');?>',
               type: "POST",
               data: new FormData($("#add_product_form")[0]),
               async: false,
               cache: false,
               contentType: false,
               processData: false,
               success: function (ajaxresponse) { 
               response=JSON.parse(ajaxresponse);
               if(!response['status']){
                   $.each(response['response'], function(key, value) {
                     $('#' + key).css('border', '1px solid #cc0000');
                     $('#' + key).after('<span id="'+key+'_error" class="error">'+value+'</span>');
                  });
                  $('#success_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                  $('#add_product_btn').removeAttr("disabled");
               }else{
                   $('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                  $("#add_product_form")[0].reset();
                   $('#child_category').html("<option value=''><?php echo $select_sub_category_label;?></option>");
                  $('#add_product_btn').removeAttr("disabled");
                  $('#add_product').trigger('click');
                  setTimeout(function(){ searchFilter(0); }, 2000);
               } 
            }
         }) 
         });
         $('#add_product,#cancel').click(function(){
            $('#add_box').toggle();
            $('#add_product_form select').css('border', '1px solid #ccc');
            $('.error').html('');
            //$('#success_message').html('');
         })
         $('#change_product_category').change(function(){
            var change_child_category_html="<option value=''><?php echo $select_sub_category_label;?></option>";
            var category_id=this.value;
				if(category_id!=''){
               $('#child_category').html('');
               changeProductCategory(category_id,'child_category');
				}else{
					$('#child_category').html(change_child_category_html);
				}
         })
			$('#change_category').change(function(){
            var change_child_category_html="<option value=''><?php echo $select_sub_category_label;?></option>";
				var category_id=this.value;
				if(category_id!=''){
               $('#change_child_category').html('');
               changeProductCategory(category_id,'change_child_category');
				}else{
					$('#change_child_category').html(change_child_category_html);
				}
			})

			$('.change').change(function(){
				var change_child_category=$('#change_child_category').val();
 				if(change_child_category==null || change_child_category==''){
					$('#category_id').val($('#change_category').val());
				}else{
					$('#category_id').val($('#change_child_category').val());
				}
				searchFilter(0);
			})

			$('#change_status').change(function(){
 				searchFilter(0);
			})
		})
	 
		function addUpdateStatus(id,status){
			$('#status'+id).html('');
  			if(status==1){
				var set_status=0;
			}else{
				var set_status=1;
			}
 			$.ajax({
				type: "POST",
				url: '<?php echo base_url(); ?>Customer/addUpdateStatus/',
				data: {'id':id,'status':set_status},
				success: function(ajaxresponse){
					response=JSON.parse(ajaxresponse);
					if(response['status']){ 
						if(set_status){
							var html='<a href="javascript:void(0)" onClick="addUpdateStatus('+id+','+set_status+')"><span class="btn btn-sm btn-success">Active</span></a>';
						}else{
							var html='<a href="javascript:void(0)" onClick="addUpdateStatus('+id+','+set_status+')"><span class="btn btn-sm btn-danger">In-active</span></a>';
						}
						$('#status'+id).html(html);
					}
				}
      });
     setTimeout(function(){ searchFilter(0); }, 2000);

      	
 		}
       
		function searchFilter(page_num) {
			page_num = page_num?page_num:0;
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>Customer/matchingAndConnectionsAjax/'+page_num,
				data:{
					'page':page_num,
					'change_category':$('#category_id').val(),
					'change_status':$('#change_status').val(),
					//'change_search':$('#change_search').val(),
				},
				beforeSend: function () {
					$('#srvLoader').html(loader);
					$('#srvLoader').show();
				},
				success: function (html) {
					  $('#product_list_section').html(html);
					  $('#srvLoader').hide();
				}
			});
		}
	</script>