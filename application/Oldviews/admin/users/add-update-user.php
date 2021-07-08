
<?php
 $this->load->view('admin/includes/header');?>
  <!-- Content Header (Page header) -->
  <section class="content-header">
  <h1><?php  echo $heading;?></h1>
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
       <form role="form" id="add_update_user_form">
              <div class="box-body">
              <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
					<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?></div>
          
          <div class="form-group col-md-6">
                <?php
                 $role_list=getRoleList();
                  ?>
                <label for="Select Role">Select Role<span class="mandatory">*</span></label>
                <select class="form-control" id="role_id" name="role_id">
                <option value="">Select Role</option>
                <?php if(count($role_list)>0){
                  foreach($role_list as $role){
                    ?>
                    <option value="<?php echo $role['id']?>" <?php if($user['role_id']==$role['id']){echo "Selected";}?>><?php echo $role['name'];?></option>
                    <?php
                  }
              }
              ?>
            </select>
                   <span id="role_id_error" class="error"></span>
                </div>
                <div class="form-group col-md-6">
                  <label for="First Name">First Name<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="<?php echo $user['first_name'];?>">
                  <span id="first_name_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="Last Name">Last Name<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="<?php echo $user['last_name'];?>">
                  <span id="last_name_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="Phone">Phone<span class="mandatory">*</span></label>
                  <input type="text" class="form-control allownumericwithoutdecimal" minlength="10" maxlength="10" name="phone" id="phone" placeholder="Phone" value="<?php echo $user['phone'];?>">
                  <span id="phone_error" class="error"></span>
                </div>
 

                <div class="form-group col-md-6">
                  <label for="Email">Email Address<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $user['email'];?>">
                  <span id="email_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="Image">Image</label>
                  <input type="file" id="Image" name="image" id="image" class="form-control">
                  <span id="image_error" class="error"></span>
                 </div>
                 <?php if(is_file('attachments/users/thumb/'.$user['image'])){
                ?>
                 <div class="form-group col-md-6">
                <span id="image_preview">
               
                <img  src="<?php echo base_url('attachments/users/thumb/'.$user['image'])?>" >
                <input type="hidden" name="old_image" id="old_image" value="<?php echo $user['image'];?>"><a href="javascript:void(0)" id="delete_image"><span class="glyphicon glyphicon-trash"></span></a>
                
               </span>
                </div>
                <?php
               }
               ?>
              
                 <div class="form-group col-md-6 apidataset" id="display_top" style="display:none;">
                  <label for="Display Top">Display on Top</label>
                  <select class="form-control" id="top" name="top">
                  <option value="1" <?php if($user['top']==1){ echo "Selected";}?>>Yes</option>
                  <option value="2" <?php if($user['top']==0){ echo "Selected";}?>>No</option>
                  </select>
                 </div>

                 <div class="form-group col-md-6 apidataset" id="display_forecast" style="display:none;">
                  <label for="Weather Forecast">Weather Forecast</label>
                  <select class="form-control" id="forecast" name="forecast">
                  <option value="1" <?php if($user['forecast']==1){ echo "Selected";}?>>Weekly</option>
                  <option value="2" <?php if($user['forecast']==2){ echo "Selected";}?>>Monthly</option>
                  <option value="3" <?php if($user['forecast']==3){ echo "Selected";}?>>3 Monthly</option>
                   </select>
                 </div>

                 <div class="form-group col-md-6 apidataset" id="display_publication" style="display:none;">
                  <label for="Publication">Publication</label>
                  <select class="form-control" id="publication" name="publication">
                  <option value="1" <?php if($user['publication']==1){ echo "Selected";}?>>Weekly</option>
                  <option value="2" <?php if($user['publication']==2){ echo "Selected";}?>>Monthly</option>
                  <option value="3" <?php if($user['publication']==3){ echo "Selected";}?>>3 Monthly</option>
                   </select>
                 </div>
                
                <div class="form-group col-md-6 apidataset" id="display_matching" style="display:none;">
                  <label for="Matching">Matching</label>
                  <select class="form-control" id="matching" name="matching">
                  <option value="1" <?php if($user['matching']==1){ echo "Selected";}?>>Weekly</option>
                  <option value="2" <?php if($user['matching']==2){ echo "Selected";}?>>Monthly</option>
                  <option value="3" <?php if($user['matching']==3){ echo "Selected";}?>>3 Monthly</option>
                   </select>
                 </div>
                 <div class="form-group col-md-6">
                  <label for="Status">Status</label>
                  <select class="form-control" id="user_status" name="status">
                  <option value="1" <?php if($user['status']==1){ echo "Selected";}?>>Active</option>
                  <option value="0" <?php if($user['status']==0){ echo "Selected";}?>>In-active</option>
                  </select>
                 </div>

                 <div class="form-group col-md-6">
                  <label for="Verified">Verified</label>
                  <select class="form-control" id="verified" name="verified">
                  <option value="1" <?php if($user['verified']==1){ echo "Selected";}?>>Verified</option>
                  <option value="0" <?php if($user['verified']==0){ echo "Selected";}?>>Un-verified</option>
                  </select>
                 </div>

                </div>
 
              <div class="box-footer">
              <button type="button" class="btn btn-primary" id="add_update_user"><?php  echo $button;?><span id="add_update_user_loader"></span></button>
              <input type="hidden" id="id" name="id" value="<?php echo $user['id'];?>">
              <a href="<?php echo base_url('admin-manage-users');?>" type="button" class="btn btn-primary">Cancel</a>
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
      function apiDataSet(role_id)
      {
         if(role_id==2)
        {
          $('#display_forecast ,#display_publication').show();   
        }
        if(role_id==3)
        {
          $('#display_publication ,#display_matching').show(); 
        }
        if(role_id==5 || role_id==4)
        {
          $('#display_publication').show(); 
        }

      }
    $(function () {
         var role_id = $('#role_id').val();
         apiDataSet(role_id);
         $('#role_id').change(function(){
        $('.apidataset').hide();
        role_id=this.value;
        if(role_id>0)
        {
          apiDataSet(role_id);
        }

      });

    $('#add_update_user').click(function(){
 		buttonEnableDisable('add_update_user', 1);
		$('#success_message').html('');
		$('.form-control').removeClass('error');
		$('.error').html('');
		var form = $("#add_update_user_form")[0];
		var formData = new FormData(form);
		$.ajax({
			type: "POST",
			url: "<?php  echo base_url('admin-add-update-user');?>",
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
					$('#add_update_user_form').trigger("reset");
					setTimeout(function () {
            location.replace("<?php echo base_url('admin-manage-users/')?>");
            // /location.replace("<?php echo base_url('admin-manage-user-addresses/')?>"+response['id']);
					},500);
				}
				buttonEnableDisable('add_update_user', 0);
			}
		});
    });

    $('#deleteImage').click(function(){
 			deleteDataImage('<?php echo base_url('admin-delete-user-image')?>');
		});
 })
</script>
 
