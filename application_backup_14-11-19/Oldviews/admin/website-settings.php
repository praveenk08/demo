
<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Website settings
       </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update Website Settings</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
       <div class="col-md-12">
       <form role="form" id="update_settings_form">
              <div class="box-body">
              <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
				<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?></div>
               
                <div class="form-group col-md-6">
                  <label for="Websitesite Logo">Website Logo</label>
                  <input type="file" name="website_logo" id="website_logo">
                  <span id="website_logo_error" class="error"></span>
                 </div>
                 <div class="form-group col-md-6">
                <span id="website_logo_preview">
                 <?php if(is_file('attachments/pages/thumb/'.$setting['logo'])){
                ?>
                <img  src="<?php echo base_url('attachments/pages/thumb/'.$setting['logo'])?>" >
                <input type="hidden" name="old_website_logo" value="<?php echo $setting['logo'];?>">
                <a href="javascript:void(0)" id="delete_website_logo"><span class="glyphicon glyphicon-trash"></span></a>
                 <?php
               }
               ?>
               </span>
                </div>
 
                <div class="form-group col-md-6">
                  <label for="Phone">Phone No<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="Phone" value="<?php echo $setting['phone_no'];?>">
                  <span id="phone_no_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="Mobile No">Mobile No<span class="mandatory">*</span></label>
                  <input type="text" class="form-control allownumericwithoutdecimal"   minlength="10" maxlength="12" id="mobile_no" name="mobile_no" placeholder="Mobile No" value="<?php echo $setting['mobile_no'];?>">
                  <span id="admin_phone_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="Email Address">Email Address<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" id="email_address" name="email_address" placeholder="Email Address" value="<?php echo $setting['email_address'];?>">
                  <span id="email_address_error" class="error"></span>
                </div>

                <div class="form-group col-md-12">
                  <label for="Contact Info">Contact Info<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" id="contact_info" name="contact_info" placeholder="Contact Info" value="<?php echo $setting['contact_info'];?>">
                  <span id="email_address_error" class="error"></span>
                </div>

                <div class="form-group col-md-12">
                  <label for="Working Hours">Working Hours<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" id="working_hours" name="working_hours" placeholder="Working Hours" value="<?php echo $setting['working_hours'];?>">
                  <span id="working_hours_error" class="error"></span>
                </div>

               </div>
 
              <div class="box-footer">
              <button type="button" class="btn btn-primary" id="update_setting">Update<span id="update_setting_loader"></span></button>
              <a href="<?php echo base_url('admin-dashboard');?>" type="button" class="btn btn-primary">Cancel</a>
              </div>
            </form>
            </div>
          </div>
          
        </section>
        
      </div>

      <div class="modal fade" id="removewebsiteLogoPopup" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p><span id="logo_confirmation_message"></p>
        </div>
        <div class="modal-footer">
           <button type="button" class="btn btn-primary" id="remove_logo">Yes</button>&nbsp;&nbsp;&nbsp;
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div> 
    

    </section>
    <!-- /.content -->
  <?php
 
  $this->load->view('admin/includes/footer');?>
 
 
    <script>

    $(function () {
    $('#delete_website_logo').click(function(){
      $('#logo_confirmation_message').html('Are you sure want to remove your photo?');
      $('#removewebsiteLogoPopup').modal('show');
    });
    $('#remove_logo').click(function(){
        $('#removewebsiteLogoPopup').modal('hide');
        $.ajax({
            url  :'<?php echo base_url('admin-remove-website-logo')?>', 
            type : 'POST',
            data: $('#update_settings_form').serialize(),
            success : function(ajaxresponse) {
                var response=JSON.parse(ajaxresponse);
                if(response['status']){
                    $('#website_logo_preview').html('');
                    location.reload();
                }
            }
        });
    });

	  $('#update_setting').click(function () {
		buttonEnableDisable('update_setting', 1);
		$('#success_message').html('');
		$('.form-control').removeClass('error');
		$('.error').html('');
		var form = $("#update_settings_form")[0];
		var formData = new FormData(form);
		$.ajax({
			type: "POST",
			url: "<?php  echo base_url('admin-update-website-settings');?>",
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
 					$('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#update_settings_form').trigger("reset");
					setTimeout(function () {
						location.reload();
					},500);
				}
				buttonEnableDisable('update_setting', 0);
			}
		});
	});
})
</script>
 
