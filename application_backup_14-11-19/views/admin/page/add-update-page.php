
<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (Page header) -->
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
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="box box-primary">
        <form role="form" id="add_update_page_form">
          <div class="box-body">
            <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
              <div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?>
            </div>
            <div class="row d-flex flex-wrap">
              <div class="form-group col-md-12">
                <label for="Name">Name<span class="mandatory">*</span></label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $page['name'];?>">
                <span id="name_error" class="error"></span>
              </div>

              <div class="form-group col-md-6">
                <label for="Meta Title">Meta Title<span class="mandatory">*</span></label>
                <input type="text" class="form-control" name="meta_title" id="meta_title" placeholder="Meta Title" value="<?php echo $page['meta_title'];?>">
                <span id="meta_title_error" class="error"></span>
              </div>

              <div class="form-group col-md-6">
                <label for="Meta Keywords">Meta Keywords<span class="mandatory">*</span></label>
                <input type="text" class="form-control" name="meta_keywords" id="meta_keywords" placeholder="Meta Keywords" value="<?php echo $page['meta_keywords'];?>">
                <span id="meta_keywords_error" class="error"></span>
              </div>

              <div class="form-group col-md-12">
                <label for="Meta Description">Meta Description</label>
                <textarea class="form-control" name="meta_description" id="meta_description" placeholder="Meta Description"><?php echo $page['meta_description'];?></textarea>
                <span id="meta_description_error" class="error"></span>
              </div>

              <div class="form-group col-md-12">
                <label for="Description">Description<span class="mandatory">*</span></label>
                  <textarea class="form-control" name="description" id="description" placeholder="Description"><?php echo $page['description'];?></textarea>
                <span id="description_error" class="error"></span>
              </div>

              <div class="form-group col-md-6">
                <label for="Image">Image</label>
                <input type="file" name="page_image" id="page_image" class="form-control change_image_section">
                <span id="page_image_error" class="error"></span>
              </div>

              <div class="form-group col-md-6">
                <span id="image_preview">
                 <?php if(is_file('attachments/pages/thumb/'.$page['image'])){
                ?>
                <img  src="<?php echo base_url('attachments/pages/thumb/'.$page['image'])?>" id="image_prev">
                <input type="hidden" name="old_image" id="old_image" value="<?php echo $page['image'];?>" >
                <a href="javascript:void(0)" id="delete_image"><span class="glyphicon glyphicon-trash"></span></a>
                 <?php
                }else{
                  ?>
                  <img  id="image_prev" >
                  <?php
                }
                ?>
               </span>
              </div>

              <div class="form-group col-md-6">
                <label for="Banner Title">Banner Title<span class="mandatory">*</span></label>
                <input type="text" class="form-control" name="banner_title" id="banner_title" placeholder="Banner Title" value="<?php echo $page['banner_title'];?>">
                <span id=banner_title_error" class="error"></span>
              </div>
              
              <div class="form-group col-md-6">
                <label for="Status">Status</label>
                <select class="form-control" id="page_status" name="status">
                  <option value="1" <?php if($page['status']==1){ echo "Selected";}?>>Active</option>
                  <option value="0" <?php if($page['status']==0){ echo "Selected";}?>>In-active</option>
                </select>
              </div>

              <div class="form-group col-md-6">
                <label for="Banner Image">Banner Image(max 1400x300)</label>
                <input type="file" id="banner_image" name="banner_image" id="banner_image" class="form-control">
                <span id="banner_image_error" class="error"></span>
              </div>

              <div class="form-group col-md-6">
                <span id="banner_image_preview">
                 <?php if(is_file('attachments/pages/thumb/'.$page['banner_image'])){
                  ?>
                  <img  src="<?php echo base_url('attachments/pages/thumb/'.$page['banner_image'])?>" >
                  <input type="hidden" name="old_banner_image" id="old_banner_image" value="<?php echo $page['banner_image'];?>">
                  <a href="javascript:void(0)" id="delete_banner_image"><span class="glyphicon glyphicon-trash"></span></a>
                  <?php
                  }
                  ?>
                </span>
              </div>

            </div>    
          </div>
 
          <div class="box-footer">
            <button type="button" class="btn btn-primary" id="add_update_page"><?php  echo $button;?><span id="add_update_page_loader"></span></button>
            <input type="hidden" id="id" name="id" value="<?php echo $page['id'];?>">
            <a href="<?php echo base_url('admin-manage-pages');?>" type="button" class="btn btn-danger">Cancel</a>
          </div>
        </form>
      </div>          
    </section>
        
     
    <!-- /.content -->
  <?php  $this->load->view('admin/includes/footer');?>
    <script>
    $(function () {

  CKEDITOR.replace('description', {
   height: 150
   });
    $('#add_update_page').click(function(){
		buttonEnableDisable('add_update_page', 1);
		$('#success_message').html('');
		$('.form-control').removeClass('error');
		$('.error').html('');
    for ( instance in CKEDITOR.instances ){
      CKEDITOR.instances[instance].updateElement(); 
    }
		var form = $("#add_update_page_form")[0];
		var formData = new FormData(form);
		$.ajax({
			type: "POST",
			url: "<?php  echo base_url('admin-add-update-page');?>",
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
 					$('#success_message').html('<div class="alert alert-success">Page updated successfully!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#add_update_page_form').trigger("reset");
					setTimeout(function () {
            location.replace("<?php echo base_url('admin-manage-pages')?>");
					},500);
				}
				buttonEnableDisable('add_update_page', 0);
			}
		});
	
    });

    $('#deleteImage').click(function(){
 			deleteDataImage('<?php echo base_url('admin-delete-page-image')?>');
    });
    $('#deleteBannerImage').click(function(){
 			deleteDataBannerImage('<?php echo base_url('admin-delete-page-banner-image')?>');
    });
    
 })
</script>
 
