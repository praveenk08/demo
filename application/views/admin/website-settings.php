
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
      <div class="box box-primary">
       <form role="form" id="update_settings_form">
              <div class="box-body">
              <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
				<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?></div>
              <div class="row d-flex flex-wrap">
               <div class="form-group col-md-4">
                <label for="Websitesite Logo">Website Logo</label>
                 <input type="file" class="form-control" name="website_logo" id="website_logo">
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

                  <div class="form-group col-md-4">
                <label for="Websitesite Logo">Arabic Logo</label>
                <input type="file" class="form-control" name="arabic_logo" id="arabic_logo">
                <span id="arabic_logo_error" class="error"></span>
                </div>
                <div class="form-group col-md-6">
                <span id="arabic_logo">
                <?php if(is_file('attachments/pages/thumb/'.$setting['arabic_logo'])){
                ?>
                <img  src="<?php echo base_url('attachments/pages/thumb/'.$setting['arabic_logo'])?>" >
                <input type="hidden" name="old_arabic_logo" value="<?php echo $setting['arabic_logo'];?>">
                <a href="javascript:void(0)" id="delete_arabic_logo"><span class="glyphicon glyphicon-trash"></span></a>
                <?php
                }
                ?>
                </span>
              </div>

              <div class="form-group col-md-4">
                <label for="Websitesite Logo">Login Registration Banner</label>
                <input type="file" class="form-control" name="login_registration_banner" id="login_registration_banner">
                <span id="login_registration_banner_error" class="error"></span>
                </div>
                <div class="form-group col-md-6">
                <span id="login_registration_banner_preview">
                <?php if(is_file('attachments/pages/thumb/'.$setting['login_registration_banner'])){
                ?>
                <img  src="<?php echo base_url('attachments/pages/thumb/'.$setting['login_registration_banner'])?>" >
                <input type="hidden" name="old_login_registration_banner" value="<?php echo $setting['login_registration_banner'];?>">
                <a href="javascript:void(0)" id="delete_login_registration_banner"><span class="glyphicon glyphicon-trash"></span></a>
                <?php
                }
                ?>
                </span>
              </div>


              <div class="form-group col-md-4">
                <label for="Websitesite Logo">Product Banner</label>
                <input type="file" class="form-control" name="product_banner" id="product_banner">
                <span id="product_banner_error" class="error"></span>
                </div>
                <div class="form-group col-md-6">
                <span id="product_banner">
                <?php if(is_file('attachments/pages/thumb/'.$setting['product_banner'])){
                ?>
                <img  src="<?php echo base_url('attachments/pages/thumb/'.$setting['product_banner'])?>" >
                <input type="hidden" name="old_product_banner" value="<?php echo $setting['product_banner'];?>">
                <a href="javascript:void(0)" id="delete_product_banner"><span class="glyphicon glyphicon-trash"></span></a>
                <?php
                }
                ?>
                </span>
              </div>

            <!--    <div class="form-group col-md-4">
                <label for="Websitesite Logo">Service Banner</label>
                <input type="file" class="form-control" name="service_banner" id="service_banner">
                <span id="service_banner_error" class="error"></span>
                </div>
                <div class="form-group col-md-6">
                <span id="service_banner">
                <?php if(is_file('attachments/pages/thumb/'.$setting['service_banner'])){
                ?>
                <img  src="<?php echo base_url('attachments/pages/thumb/'.$setting['service_banner'])?>" >
                <input type="hidden" name="old_service_banner" value="<?php echo $setting['service_banner'];?>">
                <a href="javascript:void(0)" id="delete_service_banner"><span class="glyphicon glyphicon-trash"></span></a>
                <?php
                }
                ?>
                </span>
              </div> -->

                <div class="form-group col-md-4">
                  <label for="Phone">Phone No<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="Phone" value="<?php echo $setting['phone_no'];?>">
                  <span id="phone_no_error" class="error"></span>
                </div>

                <div class="form-group col-md-4">
                  <label for="Mobile No">Mobile No<span class="mandatory">*</span></label>
                  <input type="text" class="form-control allownumericwithoutdecimal"   minlength="10" maxlength="12" id="mobile_no" name="mobile_no" placeholder="Mobile No" value="<?php echo $setting['mobile_no'];?>">
                  <span id="admin_phone_error" class="error"></span>
                </div>

                <div class="form-group col-md-4">
                  <label for="Email Address">Email Address<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" id="email_address" name="email_address" placeholder="Email Address" value="<?php echo $setting['email_address'];?>">
                  <span id="email_address_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="Contact Info">Contact Info<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" id="contact_info" name="contact_info" placeholder="Contact Info" value="<?php echo $setting['contact_info'];?>">
                  <span id="email_address_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="Working Hours">Working Hours<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" id="working_hours" name="working_hours" placeholder="Working Hours" value="<?php echo $setting['working_hours'];?>">
                  <span id="working_hours_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="Working Hours">Total Record's Per Page<span class="mandatory"></span></label>
                  <select id="total_record_per_page" name="total_record_per_page" class="form-control">
                    <option value="1">1 Record</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
                    <?php                      
                      for($i=5;$i<=100;$i=$i+5){
                        ?> 
                        <option value="<?php echo $i;?>" <?php if($i==$setting['total_record_per_page']){
                          echo 'selected';
                        } ?>><?php echo $i;?> Records</option>
                        <?php
                             }                              
                      ?>
                   </select>
                  <span id="total_record_per_page_error" class="error"></span>
                </div>

              </div> 
              </div>
 
              <div class="box-footer">
                <button type="button" class="btn btn-primary" id="update_setting">Update<span id="update_setting_loader"></span></button>
                <a href="<?php echo base_url('admin-dashboard');?>" type="button" class="btn btn-danger">Cancel</a>
              </div>
            </form>
            </div>
          
        </section>

      <div class="modal fade" id="removewebsiteLogoPopup" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
              <p><strong id="logo_confirmation_message"></strong></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="remove_logo">Yes</button>&nbsp;&nbsp;&nbsp;
              <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>        

      <div class="modal fade" id="removeloginregistrationbannerPopup" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
              <p><strong id="loginregistration_confirmation_message"></strong></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="remove_loginregistration_banner">Yes</button>&nbsp;&nbsp;&nbsp;
              <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>

       <div class="modal fade" id="removearabiclogoPopup" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
              <p><strong id="arabic_logo_confirmation_message"></strong></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="remove_arabic_logo">Yes</button>&nbsp;&nbsp;&nbsp;
              <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="removeproductbannerPopup" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
              <p><strong id="product_confirmation_message"></strong></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="remove_product_banner">Yes</button>&nbsp;&nbsp;&nbsp;
              <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>

        <div class="modal fade" id="removeServicebannerPopup" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
              <p><strong id="service_confirmation_message"></strong></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="remove_service_banner">Yes</button>&nbsp;&nbsp;&nbsp;
              <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>
  <?php
 
  $this->load->view('admin/includes/footer');?>
 
 
   <script>

  $(function (){
    $('#delete_website_logo').click(function(){
      $('#logo_confirmation_message').html('Are you sure want to remove website logo?');
      $('#removewebsiteLogoPopup').modal('show');
    });  
      $('#delete_login_registration_banner').click(function(){
      $('#loginregistration_confirmation_message').html('Are you sure want to remove login registration banner?');
      $('#removeloginregistrationbannerPopup').modal('show');
      
    });

      $('#delete_product_banner').click(function(){
      $('#product_confirmation_message').html('Are you want to remove Product banner?');
      $('#removeproductbannerPopup').modal('show');
    });  

      $('#delete_service_banner').click(function(){
      $('#service_confirmation_message').html('Are you want to remove Service banner?');
      $('#removeServicebannerPopup').modal('show');
    });  

      $('#delete_arabic_logo').click(function(){
      $('#arabic_logo_confirmation_message').html('Are you want to remove Arabic logo?');
      $('#removearabiclogoPopup').modal('show');
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

     $('#remove_loginregistration_banner').click(function(){
        $('#removeloginregistrationbannerPopup').modal('hide');
        $.ajax({
            url  :'<?php echo base_url('admin-remove-login-registration-banner')?>', 
            type : 'POST',
            data: $('#update_settings_form').serialize(),
            success : function(ajaxresponse) {
                var response=JSON.parse(ajaxresponse);
                if(response['status']){
                    $('#login_registration_banner_preview').html('');
                    location.reload();
                }
            }
        });
    });

      $('#remove_product_banner').click(function(){
        $('#removeproductbannerPopup').modal('hide');
        $.ajax({
            url  :'<?php echo base_url('admin-remove-product-banner')?>', 
            type : 'POST',
            data: $('#update_settings_form').serialize(),
            success : function(ajaxresponse) {
                var response=JSON.parse(ajaxresponse);
                if(response['status']){
                    $('#product_banner_preview').html('');
                    location.reload();
                }
            }
        });
    });

      $('#remove_service_banner').click(function(){
        $('#removeServicebannerPopup').modal('hide');
        $.ajax({
            url  :'<?php echo base_url('admin-remove-service-banner')?>', 
            type : 'POST',
            data: $('#update_settings_form').serialize(),
            success : function(ajaxresponse) {
                var response=JSON.parse(ajaxresponse);
                if(response['status']){
                    $('#service_banner_preview').html('');
                    location.reload();
                }
            }
        });
    });

       $('#remove_arabic_logo').click(function(){
        $('#removearabiclogoPopup').modal('hide');
        $.ajax({
            url  :'<?php echo base_url('admin-remove-arabic-logo')?>', 
            type : 'POST',
            data: $('#update_settings_form').serialize(),
            success : function(ajaxresponse) {
                var response=JSON.parse(ajaxresponse);
                if(response['status']){
                    $('#arabic_logo_preview').html('');
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
 
  