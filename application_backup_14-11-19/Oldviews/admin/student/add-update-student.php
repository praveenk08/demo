
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
       <form role="form" id="add_update_student_form">
              <div class="box-body">
              <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
					<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?></div>
                
                <div class="form-group col-md-12">
                  <label for="Title">Registration No<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="registrationno" id="registrationno" placeholder="Registration" value="<?php echo $student['registrationno'];?>">
                  <span id="registrationno_error" class="error"></span>
                </div>
                <div class="form-group col-md-12">
                  <label for="Title">Name<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $student['name'];?>">
                  <span id="name_error" class="error"></span>
                </div>
                <div class="form-group col-md-12">
                  <label for="Title">Class<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="class" id="class" placeholder="Class" value="<?php echo $student['class'];?>">
                  <span id="class_error" class="error"></span>
                </div>
                <div class="form-group col-md-12">
                  <label for="Title">Roll No<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="rollno" id="rollno" placeholder="Roll No" value="<?php echo $student['rollno'];?>">
                  <span id="rollno_error" class="error"></span>
                </div> <div class="form-group col-md-12">
                  <label for="Title">Gender<span class="mandatory">*</span></label></br>

                  <input type="radio"  name="gender" id="gender" placeholder="Male" <?php if($student['gender']==1){ echo "checked";?>
                     <?php  } ?> value="1">Male
                  <input type="radio"  name="gender" id="gender" placeholder="female" <?php if($student['gender']==2){ echo "checked"; ?> <?php  } ?> value="2">Female</br> 
                  <span id="gender_error" class="error"></span>
                </div>
                              
               <div class="form-group col-md-12">
                  <label for="Title">Email<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $student[ 'email'];?>">
                  <span id="email_error" class="error"></span>
                </div>
                <div class="form-group col-md-12">
                  <label for="Title">Phone<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" value="<?php echo $student['phone'];?>">
                  <span id="phone_error" class="error"></span>
                </div>

                <div class="form-group col-md-12">
                  <label for="Image">Image<span class="mandatory">*</span></label>
                   <input type="file" id="image" name="image" accept="image/x-png,image/gif,image/jpeg" class="form-control">
                  <span id="image_error" class="error"></span>
                 </div>

                 <div class="form-group col-md-12">
                <span id="image_preview">
                 <?php if(is_file('attachments/student/thumb/'.$student['image'])){
                ?>
                <img  src="<?php echo base_url('attachments/student/thumb/'.$student['image'])?>" >
                <input type="hidden" name="old_image" id="old_image" value="<?php echo $student['image'];?>"><a href="javascript:void(0)" id="delete_image"><span class="glyphicon glyphicon-trash"></span></a>
                 <?php
               }
               ?>
               </span>
                </div>
                <div class="form-group col-md-12">
                  <label for="Title">Address<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="<?php echo $student[ 'address'];?>">
                  <span id="address_error" class="error"></span>
                </div>
                 </span>
                </div>                
                <div class="form-group col-md-12">
                  <label for="Status">Status</label>
                  <select class="form-control" id="student_status" name="status">
                  <option value="1" <?php if($student['status']==1){ echo "Selected";}?>>Active</option>
                  <option value="0" <?php if($student['status']==0){ echo "Selected";}?>>In-active</option>
                  </select>
                 </div>

                 
               </div>
 
              <div class="box-footer">
              <button type="button" class="btn btn-primary" id="add_update_student"><?php  echo $button;?><span id="add_update_student_loader"></span></button>
              <input type="hidden" id="id" name="id" value="<?php echo $student['id'];?>">
              
              <a href="<?php echo base_url('admin-manage-student');?>" type="button" class="btn btn-primary">Cancel</a>
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
    $('#add_update_student').click(function(){
    buttonEnableDisable('add_update_student', 1);
  	$('#success_message').html('');
		$('.form-control').removeClass('error');
		$('.error').html('');
		var form = $("#add_update_student_form")[0];
		var formData = new FormData(form);
		$.ajax({
			type: "POST",
			url: "<?php  echo base_url('admin-add-update-student');?>",
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
					$('#add_update_student_form').trigger("reset");
					setTimeout(function () {
            location.replace("<?php echo base_url('admin-manage-student')?>");
					},500);
				}
        buttonEnableDisable('add_update_student', 0);
			}
		});
	
    });

    $('#deleteImage').click(function(){
 			deleteDataImage('<?php echo base_url('admin-delete-student-image')?>');
    });

    
 })
</script>
 
