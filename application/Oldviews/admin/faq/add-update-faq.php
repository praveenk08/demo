
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
       <form role="form" id="add_update_faq_form">
              <div class="box-body">
              <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
					<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?></div>
              <div class="row d-flex flex-wrap">
                <div class="form-group col-md-12">
                  <label for="Question">Question<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="question" id="question" placeholder="Question" value="<?php echo $faq['question'];?>">
                  <span id="question_error" class="error"></span>
                </div>

                <div class="form-group col-md-12">
                  <label for="Answer">Answer<span class="mandatory">*</span></label>
                  <textarea name="answer" style="margin: 0px; width: 1220px; height: 87px;" id="name"><?php echo $faq['answer'];?></textarea>
                   <span id="answer_error" class="error"></span>
                </div>

                 

                <div class="form-group col-md-12">
                  <label for="Status">Status</label>
                  <select class="form-control" id="faq_status" name="status">
                  <option value="1" <?php if($faq['status']==1){ echo "Selected";}?>>Active</option>
                  <option value="0" <?php if($faq['status']==0){ echo "Selected";}?>>In-active</option>
                  </select>
                 </div>

                 
               </div>
              </div>
              <div class="box-footer">
              <button type="button" class="btn btn-primary" id="add_update_faq"><?php  echo $button;?><span id="add_update_faq_loader"></span></button>
              <input type="hidden" id="id" name="id" value="<?php echo $faq['id'];?>">
              <a href="<?php echo base_url('admin-manage-faqs');?>" type="button" class="btn btn-primary">Cancel</a>
              </div>
            </form>
            </div>
         
        </section>
        
     
    <!-- /.content -->
  <?php  $this->load->view('admin/includes/footer');?>
    <script>
    $(function () {
      CKEDITOR.replace('answer', {
      height: 150
    });
 
    $('#add_update_faq').click(function(){
		buttonEnableDisable('add_update_faq', 1);
		$('#success_message').html('');
		$('.form-control').removeClass('error');
    $('.error').html('');
    for ( instance in CKEDITOR.instances ){
        CKEDITOR.instances[instance].updateElement(); 
      }
		var form = $("#add_update_faq_form")[0];
		var formData = new FormData(form);
		$.ajax({
			type: "POST",
			url: "<?php  echo base_url('admin-add-update-faq');?>",
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
					$('#add_update_faq_form').trigger("reset");
					setTimeout(function () {
            location.replace("<?php echo base_url('admin-manage-faqs')?>");
					},500);
				}
				buttonEnableDisable('add_update_faq', 0);
			}
		});
	
    });
 })
</script>
 
