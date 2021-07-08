
<?php
 $this->load->view('vendor/includes/header');?>

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
              <div id="success_message1"><?php if($this->session->flashdata('success_message')){ ?> 
					<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?></div>
                <div class="form-group col-md-6">
                  <label for="First Name">First Name<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="vendor_first_name" id="vendor_first_name" placeholder="First Name" value="<?php echo $this->session->userdata('vendor_data')['first_name'];?>">
                  <span id="vendor_first_name_error" class="error"></span>
                </div>
                <div class="form-group col-md-6">
                  <label for="Last Name">Last Name<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="vendor_last_name" id="vendor_last_name" placeholder="Last Name" value="<?php echo $this->session->userdata('vendor_data')['last_name'];?>">
                  <span id="vendor_last_name_error" class="error"></span>
                </div>
                <div class="form-group col-md-6">
                  <label for="Phone">Phone<span class="mandatory">*</span></label>
                  <input type="text" class="form-control allownumericwithoutdecimal" minlength="10" maxlength="10"  id="vendor_phone" name="vendor_phone" placeholder="Phone" value="<?php echo $this->session->userdata('vendor_data')['phone'];?>">
                  <span id="vendor_phone_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="Email">Email Address<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" id="vendor_email" readonly name="vendor_email" placeholder="Email" value="<?php echo $this->session->userdata('vendor_data')['email'];?>">
                  <span id="vendor_email_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="Password">Password</label>
                  <input type="password" class="form-control" id="vendor_password" name="vendor_password" placeholder="Password" autocomplete="off" value="">
                  <span id="vendor_password_error" class="error"></span>
                </div>
                <div class="form-group col-md-6">
                  <label for="Password">Confirm Password</label>
                  <input type="password" class="form-control" id="confirm_vendor_password" name="confirm_vendor_password" placeholder="Confirm Password" value="">
                  <span id="confirm_vendor_password_error" class="error"></span>
                </div>

                <div class="form-group col-md-3">
                  <label for="Image">Image</label>
                  <input type="file" id="Image" name="vendor_image" id="vendor_image">
                  <span id="vendor_image_error" class="error"></span>
                 </div>

                 <div class="form-group col-md-3">
                <span id="vendor_image_preview">
                 <?php if(is_file('attachments/users/thumb/'.$this->session->userdata('vendor_data')['image'])){
                ?>
                <img  src="<?php echo base_url('attachments/users/thumb/'.$this->session->userdata('vendor_data')['image'])?>" >
                <input type="hidden" name="old_image" value="<?php echo $this->session->userdata('vendor_data')['image'];?>"><a href="javascript:void(0)" id="delete_vendor_image"><span class="glyphicon glyphicon-trash"></span></a>
                 <?php
               }
               ?>
               </span>
                </div>
                
                
                <div class="form-group col-md-6">
                  <label for="Weather Forecast">Weather Forecast</label>
                  <select class="form-control" id="forecast" name="forecast">
                  <option value="1" <?php if($this->session->userdata('vendor_data')['forecast']==1){ echo "Selected";}?>>Weekly</option>
                  <option value="2" <?php if($this->session->userdata('vendor_data')['forecast']==2){ echo "Selected";}?>>Monthly</option>
                  <option value="3" <?php if($this->session->userdata('vendor_data')['forecast']==3){ echo "Selected";}?>>3 Monthly</option>
                   </select>
                 </div>


                 <div class="form-group col-md-6">
                  <label for="Publication">Publication</label>
                  <select class="form-control" id="publication" name="publication">
                  <option value="1" <?php if($this->session->userdata('vendor_data')['publication']==1){ echo "Selected";}?>>Weekly</option>
                  <option value="2" <?php if($this->session->userdata('vendor_data')['publication']==2){ echo "Selected";}?>>Monthly</option>
                  <option value="3" <?php if($this->session->userdata('vendor_data')['publication']==3){ echo "Selected";}?>>3 Monthly</option>
                   </select>
                 </div>
               


                <!--<div class="form-group col-md-12">
                  <label for="Firm Name">Firm Name</label>
                  <input name="firm_name" id="firm_name" class="form-control" placeholder="Firm Name" value="<?php echo $this->session->userdata('vendor_data')['firm_name'];?>">
                  <span id="firm_name_error" class="error"></span>
                 </div>

                 <div class="form-group col-md-12">
                  <label for="Firm Description">Firm Description</label>
                  <textarea name="firm_description" id="firm_description" placeholder="Firm Description" class="form-control"><?php echo $this->session->userdata('vendor_data')['firm_description'];?></textarea>
                  <span id="firm_description_error" class="error"></span>
                 </div>-->

                <div class="form-group col-md-12">
                <h2>Address</h2>
                </div>
                <div class="form-group col-md-6">
                  <label for="Name">Contact Name</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $address['name'];?>">
                  <span id="name_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="Phone">Contact Phone</label>
                  <input type="text" class="form-control allownumericwithoutdecimal" name="phone" minlength="10" maxlength="10"  id="phone" placeholder="Phone" value="<?php echo $address['phone'];?>">
                  <span id="phone_error" class="error"></span>
                </div>
 

                <div class="form-group col-md-6">
                  <label for="Email">Contact Email Address</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $address['email'];?>">
                  <span id="email_error" class="error"></span>
                </div>


                <div class="form-group col-md-6">
                <?php
                 $countries=getCountryList();
                  ?>
                <label for="Select Country">Select Country</label>
                <select class="form-control" id="change_country" name="change_country">
                <option value="">Select Country</option>
                <?php if(count($countries)>0){
                  foreach($countries as $country){
                    ?>
                    <option value="<?php echo $country['id']?>" <?php if($address['country']==$country['id']){echo "Selected";}?>><?php echo $country['name'];?></option>
                    <?php
                  }
              }
              ?>
            </select>
                   <span id="change_country_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="State">State</label>
                  <select class="form-control" id="change_state" name="change_state">
                    <option value="">Select State</option>
                  </select>
              <span id="change_state_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="city">City</label>
                  <select class="form-control" id="change_city" name="change_city">
                    <option value="">Select City</option>
                  </select>
               
                <span id="change_city_error" class="error"></span>
                </div>


                <div class="form-group col-md-6">
                  <label for="Address">Address</label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php echo $address['address'];?>">
                  <span id="address_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="Street">Street</label>
                  <input type="text" class="form-control" id="street" name="street" placeholder="Street" value="<?php echo $address['street'];?>">
                 </div>

               <div class="form-group col-md-6">
                  <label for="Block">Block</label>
                  <input type="text" class="form-control" id="block" name="block" placeholder="Block" value="<?php echo $address['block'];?>">
                 </div>

                <div class="form-group col-md-6">
                  <label for="Landmark">Landmark</label>
                  <input type="text" class="form-control" id="landmark" name="landmark" placeholder="Landmark" value="<?php echo $address['landmark'];?>">
                  <span id="landmark_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="Zip">Zip</label>
                  <input type="text" class="form-control allownumericwithoutdecimal" minlength="5" maxlength="7" id="zip" name="zip" placeholder="Zip" value="<?php echo $address['zip'];?>">
                  <span id="zip_error" class="error"></span>
                </div>

 
               </div>
 
              <div class="box-footer">
              <button type="button" class="btn btn-primary" id="update_profile">Update<span id="update_profile_loader"></span></button>
              <input type="hidden" name="id" id="id" value="<?php echo $address['id'];?>">
              <input type="hidden" name="hidden_state" id="hidden_state" value="<?php echo $address['state'];?>">
              <input type="hidden" name="hidden_city" id="hidden_city" value="<?php echo $address['city'];?>">
               
              <a href="<?php echo base_url('vendor-dashboard');?>" type="button" class="btn btn-danger">Cancel</a>
              </div>
            </form>
            </div>
          </div>
          
        </section>
        
      </div>
    

    </section>
    <!-- /.content -->
  <?php
 
  $this->load->view('vendor/includes/footer');?>
    <script>
    $(function () {
    ///
   // CKEDITOR.replace('firm_description', {
     // height: 150
   //});
      var country_id=$('#change_country').val();
       var state_id=$('#hidden_state').val();
       var city_id=$('#hidden_city').val();
       if(country_id>0){
      $('#change_country').trigger('change');
       if(state_id!=''){
        setTimeout(function(){
          $('#change_state').val(state_id);
          $('#change_state').trigger('change');
          if(city_id!=''){
            setTimeout(function(){
            $('#change_city').val(city_id);
          }, 2000);
         }
        }, 2000);
      }
    }

    $('#delete_vendor_image').click(function(){
      $('#confirmation_message').html('Are you sure want to remove your photo?');
      $('#removeProfilePhoteModalPopup').modal('show');
    });
    $('#remove_photo').click(function(){
      $('#removeProfilePhoteModalPopup').modal('hide');
				$.ajax({
					url  :'<?php echo base_url('vendor-remove-profile-image')?>', 
					type : 'POST',
					success : function(ajaxresponse) {
            var response=JSON.parse(ajaxresponse);
             if(response['status']){
              $('#vendor_image_preview').html('');
              location.reload();
             }
					}
				});
    });

	  $('#update_profile').click(function () {
    buttonEnableDisable('update_profile', 1);
 		$('#success_message1').html('');
		$('.form-control').removeClass('error');
		$('.error').html('');
    for ( instance in CKEDITOR.instances ){
        CKEDITOR.instances[instance].updateElement(); 
      }
		var form = $("#update_profile_form")[0];
		var formData = new FormData(form);
		$.ajax({
			type: "POST",
			url: "<?php  echo base_url('vendor-update-profile');?>",
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
            $('#success_message1').html(form_error_message);
            buttonEnableDisable('update_profile', 0);
            return false;
				} else {
 					$('#success_message1').html('<div class="alert alert-success">Your profile has been updated successfully!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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