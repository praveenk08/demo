<?php
$this->load->view('admin/includes/header');?>

<section class="content-header">
    <h1>
    <?php  echo $heading;?>
       </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php  echo $heading;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <?php
      $languages=getLanguageList();
    ?>
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="box box-primay">
        <div class="addUpdateProduct">
          <form role="form" id="add_update_product_form">
            <div class="box-body">
              <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
					      <div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div><?php } ?>
              </div>

              <div class="col-md-3 col-sm-6 form-group">
                  <label for="Name">Name<span class="mandatory">*</span></label><br>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $master_product['name'];?>">
						      <span id="name_error" class="error"></span>
                </div>
                
                
                <div class="col-md-3 col-sm-6 form-group">
                  <label for="Select Category">Select Categories<span class="mandatory">*</span></label><br>
						      <select name="category" id="category" class="form-control ">
                  <option value="">Select Category</option>
                    <?php
                      $categories=categoryList(array('c.parent_id'=>0,'c.status'=>1,'ct.abbr'=>'en'));

                      foreach($categories as $category){
                        ?>
                        <option value="<?php echo $category['id'];?>" <?php if($category_id==$category['id']){ echo "selected='selected' ";}?>><?php echo  $category['name'];?></option>
                        <?php
                      }
                    ?>
                  </select>
						      <span id="category_error" class="error"></span>
                </div>

                <div class="col-md-3 col-sm-6 form-group">
                  <label for="Select Child Category">Select Child Category</label><br>
						      <select name="child_category" id="child_category" class="form-control ">
                  <option value="">Select Child Category</option>
                  </select>
						      <span id="child_category_error" class="error"></span>
                </div>
   
                <div class="col-md-2 col-sm-4 form-group">
                  <label for="Status">Status</label>
                  <select class="form-control" id="product_status" name="status">
                  <option value="1" <?php if($master_product['status']==1){ echo "Selected";}?>>Active</option>
                  <option value="0" <?php if($master_product['status']==0){ echo "Selected";}?>>In-active</option>
                  </select>
                </div>
              </div>
        

              <div class="row d-flex flex-wrap">
                 
                <div class="form-group col-lg-6 ">
                  <label for="Meta Title">Meta Title<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="meta_title" id="meta_title" placeholder="Meta Title" value="<?php echo $master_product['meta_title'];?>">
                  <span id="meta_title_error" class="error"></span>
                </div>

                <div class="form-group col-md-6 ">
                  <label for="Meta Keywords">Meta Keywords</label>
                  <input type="text" class="form-control" name="meta_keywords" id="meta_keywords" placeholder="Meta Keywords" value="<?php echo $master_product['meta_keywords'];?>">
                  <span id="meta_keywords_error" class="error"></span>
                </div>

                <div class="form-group col-md-12 ">
                  <label for="Meta Description">Meta Description</label>
                  <textarea class="form-control" name="meta_description" id="meta_description" placeholder="Meta Description"><?php echo $master_product['meta_description'];?></textarea>
                  <span id="meta_description_error" class="error"></span>
                </div>
              </div>
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-primary" id="add_update_master_product"><?php  echo $button;?><span id="add_update_master_product_loader"></span></button>
               <input type="hidden" id="id" name="id" value="<?php echo $master_product['id'];?>">
                <a href="<?php echo base_url('admin-manage-master-products');?>" type="button" class="btn btn-danger">Cancel</a>
            </div>
          </form>
        </div>
      </div>      
    </section>
 

    <!-- /.content -->
  <?php  $this->load->view('admin/includes/footer');?>



  <script>
  $(function(){
    CKEDITOR.replace('meta_description', {
   height: 150
   });
    var child_category='<?php echo $child_category;?>';
     setTimeout(function(){ $('#category').trigger('change'); }, 1000);
    
    $('#category').change(function(){
      var html='<option value="">Select Child Category</option>';
      $('#child_category').html(html);
      if(this.value>0){
        $.ajax({
            url: "<?php echo base_url();?>common/Common/getChildCategories",
            type: "POST",
            data: {"id":this.value},
            success: function (ajaxresponse) {
            var response=JSON.parse(ajaxresponse);
            if(response.length>0){
               for(i=0;i<response.length;i++){
                 if(response[i]['id']==child_category){
                    selected="selected";
                }else{
                  selected='';
                }
                html +='<option value="'+response[i]['id']+'" '+selected+'>'+response[i]['name']+'</option>';
               }
            }
            $('#child_category').html(html);
          }
      });
      }
    })

    $('#add_update_master_product').click(function(){
      buttonEnableDisable('add_update_master_product', 1);
      uploadImage();
      $('#success_message').html('');
      $('.form-control').removeClass('error');
      $('.error').html('');
      for ( instance in CKEDITOR.instances ){
        CKEDITOR.instances[instance].updateElement(); 
      }
		  var form = $("#add_update_product_form")[0];
      var formData = new FormData(form);
		  $.ajax({
			  type: "POST",
			  url: "<?php  echo base_url('admin-add-update-master-product');?>",
			  data: formData,
			  async: false,
		  	cache: false,
		  	contentType: false,
			  processData: false,
		  	success: function (ajaxresponse) {
				response = JSON.parse(ajaxresponse);
				if (!response['status']) {
					$.each(response, function (key, value) {
						$('#' + key).addClass('error');
						$('#' + key + '_error').html(value);
					});
          $('#success_message').html(form_error_message);
          closePopup('success_message');
        } else {
 					$('#success_message').html('<div class="alert alert-success">Your profile has been updated successfully!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#add_update_product_form').trigger("reset");
					setTimeout(function () {
          location.replace("<?php echo base_url('admin-manage-master-products')?>");
					},500);
				}
				buttonEnableDisable('add_update_master_product', 0);
			}
		});
	
    });

  })
 
</script>
 
