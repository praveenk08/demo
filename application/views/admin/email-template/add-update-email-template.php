
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
       <form role="form" id="add_update_email_template_form">
              <div class="box-body">
              <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
					<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?></div>
                <div class="row d-flex flex-wrap">
                <div class="form-group col-md-6">
                  <label for="Name">Name<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $email_template['name'];?>">
                  <span id="name_error" class="error"></span>
                </div>

                <div class="form-group col-md-6">
                  <label for="Subject">Subject<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" value="<?php echo $email_template['subject'];?>">
                  <span id="subject_error" class="error"></span>
                </div>

                <div class="form-group col-md-12">
                  <label for="Welcome Heading">Welcome Heading<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="welcome_heading" id="welcome_heading" placeholder="Welcome Heading" value="<?php echo $email_template['welcome_heading'];?>">
                  <span id="welcome_heading_error" class="error"></span>
                </div>

                <div class="form-group col-md-12">
                  <label for="Welcome Message">Welcome Message<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="welcome_message" id="welcome_message" placeholder="Welcome Message" value="<?php echo $email_template['welcome_message'];?>">
                  <span id="welcome_message_error" class="error"></span>
                </div>


                <div class="form-group col-md-12">
                  <label for="Message Description">Message Description<span class="mandatory">*</span></label>
                  <textarea  class="form-control" name="message_description" id="message_description" placeholder="Message Description"><?php echo $email_template['message_description'];?></textarea>
                  <span id="message_description_error" class="error"></span>
                </div>


                <div class="form-group col-md-6">
                  <label for="Banner Image">Banner Image<span class="mandatory">*</span></label>
                   <input type="file" id="banner_image" name="banner_image" accept="image/x-png,image/gif,image/jpeg" class="form-control">
                  <span id="banner_image_error" class="error"></span>
                 </div>

                 <div class="form-group col-md-6">
                <span id="image_preview">
                 <?php if(is_file('attachments/email-templates/thumb/'.$email_template['banner_image'])){
                ?>
                <img  src="<?php echo base_url('attachments/email-templates/thumb/'.$email_template['banner_image'])?>" >
                <input type="hidden" name="old_image" id="old_image" value="<?php echo $email_template['banner_image'];?>"><a href="javascript:void(0)" id="delete_image"><span class="glyphicon glyphicon-trash"></span></a>
                 <?php
               }
               ?>
               </span>
                </div>

               </div>
              </div>
 
              <div class="box-footer">
                <button type="button" class="btn btn-primary" id="add_update_email_template"><?php  echo $button;?><span id="add_update_email_template_loader"></span></button>
                <input type="hidden" id="id" name="id" value="<?php echo $email_template['id'];?>">
                
                <a href="<?php echo base_url('admin-manage-email-templates');?>" type="button" class="btn btn-danger">Cancel</a>
              </div>
            </form>
            </div>          
        </section>
      
  <?php  $this->load->view('admin/includes/footer');?>
    <script>
    $(function () {
    $('#add_update_email_template').click(function(){
    buttonEnableDisable('add_update_email_template', 1);
 		$('#success_message').html('');
		$('.form-control').removeClass('error');
		$('.error').html('');
		var form = $("#add_update_email_template_form")[0];
		var formData = new FormData(form);
		$.ajax({
			type: "POST",
			url: "<?php  echo base_url('admin-add-update-email-template');?>",
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
					$('#add_update_email_template_form').trigger("reset");
					setTimeout(function () {
            location.replace("<?php echo base_url('admin-manage-email-templates')?>");
					},500);
				}
				buttonEnableDisable('add_update_email_template', 0);
			}
		});
	
    });

    $('#deleteImage').click(function(){
 			deleteDataImage('<?php echo base_url('admin-delete-email-template-banner-image')?>');
    });
    
 

 })
</script>
 
