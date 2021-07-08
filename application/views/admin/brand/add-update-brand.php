
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
      <div class="row">
       <div class="col-md-12">
       <form role="form" id="add_update_brand_form">
              <div class="box-body">
              <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
					<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?></div>
                
                <div class="form-group col-md-12">
                  <label for="Name">Name<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $brand['name'];?>">
                  <span id="name_error" class="error"></span>
                </div>

              
                <div class="form-group col-md-12">
                  <label for="Image">Image</label>
                  <input type="file" id="Image" name="image" id="image" class="form-control">
                  <span id="image_error" class="error"></span>
                 </div>

                 <div class="form-group col-md-12">
                <span id="image_preview">
                 <?php if(is_file('attachments/brand/thumb/'.$brand['image'])){
                ?>
                <img  src="<?php echo base_url('attachments/brand/thumb/'.$brand['image'])?>" >
                <input type="hidden" name="old_image" id="old_image" value="<?php echo $brand['image'];?>"><a href="javascript:void(0)" id="delete_image"><span class="glyphicon glyphicon-trash"></span></a>
                 <?php
               }
               ?>
               </span>
                </div>

                <div class="form-group col-md-12">
                  <label for="Status">Status</label>
                  <select class="form-control" id="brand_status" name="status">
                  <option value="1" <?php if($brand['status']==1){ echo "Selected";}?>>Active</option>
                  <option value="0" <?php if($brand['status']==0){ echo "Selected";}?>>In-active</option>
                  </select>
                 </div>

                 
               </div>
 
              <div class="box-footer">
              <button type="button" class="btn btn-primary" id="add_update_brand"><?php  echo $button;?><span id="add_update_brand_loader"></span></button>
              <input type="hidden" id="id" name="id" value="<?php echo $brand['id'];?>">
              <a href="<?php echo base_url('admin-manage-brand');?>" type="button" class="btn btn-danger">Cancel</a>
              </div>
            </form>
            </div>
          </div>
          
        </section>
        
      </div>
    

    </section>
    <!-- /.content -->
  <?php  $this->load->view('admin/includes/footer');?>
    <script>
    $(function () {
    $('#add_update_brand').click(function(){
		buttonEnableDisable('add_update_brand', 1);
		$('#success_message').html('');
		$('.form-control').removeClass('error');
		$('.error').html('');
		var form = $("#add_update_brand_form")[0];
		var formData = new FormData(form);
		$.ajax({
			type: "POST",
			url: "<?php  echo base_url('admin-add-update-brand');?>",
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
          $('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#add_update_brand_form').trigger("reset");
					setTimeout(function () {
            location.replace("<?php echo base_url('admin-manage-brand')?>");
					},500);
				}
				buttonEnableDisable('add_update_brand', 0);
			}
		});
	
    });

    $('#deleteImage').click(function(){
 			deleteDataImage('<?php echo base_url('admin-delete-brand-image')?>');
		});
 })
</script>
 
