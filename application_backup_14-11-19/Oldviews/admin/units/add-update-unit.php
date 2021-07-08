
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
       <form role="form" id="add_update_unit_form">
              <div class="box-body">
              <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
					<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?></div>
                
                <div class="form-group col-md-6">
                  <label for="Name">Name<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $unit['name'];?>">
                  <span id="name_error" class="error"></span>
                </div>
 
                <div class="form-group col-md-6">
                  <label for="Status">Status</label>
                  <select class="form-control" id="unit_status" name="status">
                  <option value="1" <?php if($unit['status']==1){ echo "Selected";}?>>Active</option>
                  <option value="0" <?php if($unit['status']==0){ echo "Selected";}?>>In-active</option>
                  </select>
                 </div>

                 
               </div>
 
              <div class="box-footer">
              <button type="button" class="btn btn-primary" id="add_update_unit"><?php  echo $button;?><span id="add_update_unit_loader"></span></button>
              <input type="hidden" id="id" name="id" value="<?php echo $unit['id'];?>">
              
              <a href="<?php echo base_url('admin-manage-unit');?>" type="button" class="btn btn-primary">Cancel</a>
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
    $('#add_update_unit').click(function(){
    buttonEnableDisable('add_update_unit', 1);
 		$('#success_message').html('');
		$('.form-control').removeClass('error');
		$('.error').html('');
		var form = $("#add_update_unit_form")[0];
		var formData = new FormData(form);
		$.ajax({
			type: "POST",
			url: "<?php  echo base_url('admin-add-update-unit');?>",
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
					$('#add_update_unit_form').trigger("reset");
					setTimeout(function () {
            location.replace("<?php echo base_url('admin-manage-unit')?>");
					},500);
				}
				buttonEnableDisable('add_update_unit', 0);
			}
		});
    });

    $('#deleteImage').click(function(){
       deleteDataImage('<?php echo base_url('admin-delete-unit-image')?>');
       
		});
 })
</script>
 
