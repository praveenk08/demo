
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
       <form role="form" id="add_update_user_address_form">
              <div class="box-body">
              <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
				<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?></div>
                
                <div class="form-group col-md-4">
                  <label for="Name">Contact Name<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $address['name'];?>">
                  <span id="name_error" class="error"></span>
                </div>

                <div class="form-group col-md-4">
                  <label for="Phone">Phone<span class="mandatory">*</span></label>
                  <input type="text"class="form-control allownumericwithoutdecimal" minlength="10" maxlength="10" name="phone" id="phone" placeholder="Phone" value="<?php echo $address['phone'];?>">
                  <span id="phone_error" class="error"></span>
                </div>
 

                <div class="form-group col-md-4">
                  <label for="Email">Email Address<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $address['email'];?>">
                  <span id="email_error" class="error"></span>
                </div>


                <div class="form-group col-md-4">
                <?php
                 $countries=getCountryList();
                  ?>
                <label for="Select Country">Select Country<span class="mandatory">*</span></label>
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

                <div class="form-group col-md-4">
                  <label for="State">State<span class="mandatory">*</span></label>
                  <select class="form-control" id="change_state" name="change_state">
                    <option value="">Select State</option>
                  </select>
              <span id="change_state_error" class="error"></span>
                </div>

                <div class="form-group col-md-4">
                  <label for="city">city<span class="mandatory">*</span></label>
                  <select class="form-control" id="change_city" name="change_city">
                    <option value="">Select City</option>
                  </select>
               
                <span id="change_city_error" class="error"></span>
                </div>


                <div class="form-group col-md-4">
                  <label for="Address">Address<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php echo $address['address'];?>">
                  <span id="address_error" class="error"></span>
                </div>

                <div class="form-group col-md-4">
                  <label for="Street">Street</label>
                  <input type="text" class="form-control" id="street" name="street" placeholder="Street" value="<?php echo $address['street'];?>">
                 </div>

               <div class="form-group col-md-4">
                  <label for="Block">Block</label>
                  <input type="text" class="form-control" id="block" name="block" placeholder="Block" value="<?php echo $address['block'];?>">
                 </div>

                <div class="form-group col-md-4">
                  <label for="Landmark">Landmark<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" id="landmark" name="landmark" placeholder="Landmark" value="<?php echo $address['landmark'];?>">
                  <span id="landmark_error" class="error"></span>
                </div>

                <div class="form-group col-md-4">
                  <label for="Zip">Zip<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip" value="<?php echo $address['zip'];?>">
                  <span id="zip_error" class="error"></span>
                </div>

             
                
                <div class="form-group col-md-4">
                  <label for="Status">Status</label>
                  <select class="form-control" id="address_status" name="status">
                  <option value="1" <?php if($address['status']==1){ echo "Selected";}?>>Active</option>
                  <option value="0" <?php if($address['status']==0){ echo "Selected";}?>>In-active</option>
                  </select>
                 </div>

            
 
               </div>
 
              <div class="box-footer">
              <button type="button" class="btn btn-primary" id="add_update_user_address"><?php  echo $button;?><span id="add_update_user_address_loader"></span></button>
              <input type="hidden" id="id" name="id" value="<?php echo $address['id'];?>">
              <input type="hidden" id="user_id" name="user_id" value="<?php echo $address['user_id'];?>">
              <a href="<?php echo base_url('admin-manage-user-addresses');?>" type="button" class="btn btn-primary">Cancel</a>
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
      var country_id=<?php echo $address['country']?>;
      var state_id=<?php echo $address['state']?>;
      var city_id=<?php echo $address['city']?>;
      if(country_id>0){
      $('#change_country').trigger('change');
      if(state_id!=''){
        setTimeout(function(){
          $('#change_state').val(state_id);
          $('#change_state').trigger('change');
          if(city_id!=''){
            setTimeout(function(){
            $('#change_city').val(city_id);
          }, 500);
         }
        }, 500);
      }
    }

    $('#add_update_user_address').click(function(){
		buttonEnableDisable('add_update_user_address', 1);
		$('#success_message').html('');
		$('.form-control').removeClass('error');
		$('.error').html('');
		var form = $("#add_update_user_address_form")[0];
		var formData = new FormData(form);
		$.ajax({
			type: "POST",
			url: "<?php  echo base_url('admin-add-update-user-address');?>",
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
					$('#add_update_user_address_form').trigger("reset");
					setTimeout(function () {
           location.replace("<?php echo base_url('admin-manage-user-addresses')?>");
					},500);
				}
				buttonEnableDisable('add_update_user_address', 0);
			}
		});
	
    });

 
 })
</script>
 
