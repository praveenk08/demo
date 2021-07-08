
<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update Profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
       <div class="col-md-12">
       <form role="form" id="update_profile_form">
              <div class="box-body">
              <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
					<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?></div>
                <div class="form-group col-md-6">
                  <label for="First Name">First Name<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="admin_first_name" id="admin_first_name" placeholder="First Name" value="<?php echo $this->session->userdata('admin_data')['first_name'];?>">
                  <span id="admin_first_name_error" class="error"></span>
                </div>
                <div class="form-group col-md-6">
                  <label for="Last Name">Last Name<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="admin_last_name" id="admin_last_name" placeholder="Last Name" value="<?php echo $this->session->userdata('admin_data')['last_name'];?>">
                  <span id="admin_last_name_error" class="error"></span>
                </div>
                <div class="form-group col-md-6">
                  <label for="Phone">Phone<span class="mandatory">*</span></label>
                  <input type="text" class="form-control allownumericwithoutdecimal"   minlength="10" maxlength="12" id="admin_phone" name="admin_phone" placeholder="Phone" value="<?php echo $this->session->userdata('admin_data')['phone'];?>">
                  <span id="admin_phone_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="Email">Email Address<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" id="admin_email" name="admin_email" readonly placeholder="Email" value="<?php echo $this->session->userdata('admin_data')['email'];?>">
                  <span id="admin_email_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="Password">Password</label>
                  <input type="password" class="form-control" id="admin_password" name="admin_password" placeholder="Password" value="" autocomplete="off">
                  <span id="admin_password_error" class="error"></span>
                </div>
                <div class="form-group col-md-6">
                  <label for="Password">Confirm Password</label>
                  <input type="password" class="form-control" autocomplete="off" id="confirm_admin_password" name="confirm_admin_password" placeholder="Confirm Password" value="">
                  <span id="confirm_admin_password_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="Image">Image</label>
                  <input type="file" name="admin_image" id="admin_image">
                  <span id="admin_image_error" class="error"></span>
                 </div>
                 <div class="form-group col-md-6">
                <span id="admin_image_preview">
                 <?php if(is_file('attachments/users/thumb/'.$this->session->userdata('admin_data')['image'])){
                ?>
                <img  src="<?php echo base_url('attachments/users/thumb/'.$this->session->userdata('admin_data')['image'])?>" >
                <input type="hidden" name="old_image" value="<?php echo $this->session->userdata('admin_data')['image'];?>"><a href="javascript:void(0)" id="delete_admin_image"><span class="glyphicon glyphicon-trash"></span></a>
                 <?php
               }
               ?>
               </span>
                </div>

               </div>
 
              <div class="box-footer">
              <button type="button" class="btn btn-primary" id="update_profile">Update<span id="update_profile_loader"></span></button>
              <a href="<?php echo base_url('admin');?>" type="button" class="btn btn-danger">Cancel</a>
              </div>
            </form>
            </div>
          </div>
          
        </section>
        
      </div>
    

    </section>
    <!-- /.content -->
  <?php
 
  $this->load->view('admin/includes/footer');?>
 
 
    <script>
 
 
 


    $(function () {
    $('#delete_admin_image').click(function(){
      $('#confirmation_message').html('Are you sure want to remove your photo?');
      $('#removeProfilePhoteModalPopup').modal('show');
    });
    $('#remove_photo').click(function(){
      $('#removeProfilePhoteModalPopup').modal('hide');
				$.ajax({
					url  :'<?php echo base_url('admin-remove-profile-image')?>', 
          type : 'POST',
          data: $('#update_profile_form').serialize(),
					success : function(ajaxresponse) {
            var response=JSON.parse(ajaxresponse);
             if(response['status']){
              $('#admin_image_preview').html('');
              location.reload();
             }
					}
				});
    });

	  $('#update_profile').click(function () {
      // $("#update_profile").attr('disable',true);
		buttonEnableDisable('update_profile', 1);
		$('#success_message').html('');
		$('.form-control').removeClass('error');
		$('.error').html('');
		var form = $("#update_profile_form")[0];
		var formData = new FormData(form);
		$.ajax({
			type: "POST",
			url: "<?php  echo base_url('admin-update-profile');?>",
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
				} else {
 					$('#success_message').html('<div class="alert alert-success">Your profile has been updated successfully!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#update_profile_form').trigger("reset");
					setTimeout(function () {
						location.reload();
					},500);
				}
				buttonEnableDisable('update_profile', 0);
			}
		});
	});
})
</script>
 
