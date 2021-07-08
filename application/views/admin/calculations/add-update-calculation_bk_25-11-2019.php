
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
       <form role="form" id="add_update_calculation_form">
              <div class="box-body">
              <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
					<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?></div>
                <div class="row d-flex flex-wrap">
                <div class="form-group col-md-12">
                  <label for="Title">Title<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?php echo $calculation['title'];?>">
                  <span id="title_error" class="error"></span>
                </div>

                <div class="form-group col-md-4">
                  <label for="Value">Value<span class="mandatory">*</span></label>
                  <input type="number" minlength="1" class="form-control allownumericwithoutdecimal" name="value" id="value" placeholder="Value" value="<?php echo $calculation['value'];?>">
                  <span id="value_error" class="error"></span>
                </div>

                <div class="form-group col-md-4">
                  <label for="Sort Id">Sort Id<span class="mandatory">*</span></label>
                  <input type="number" class="form-control allownumericwithoutdecimal" name="sort_id" id="sort_id" placeholder="sort Order" value="<?php echo $calculation['sort_id'];?>">
                  <span id="sort_id_error" class="error"></span>
                </div>
                 
                <div class="form-group col-md-4">
                  <label for="Status">Status</label>
                  <select class="form-control" id="calculation_status" name="status">
                  <option value="1" <?php if($calculation['status']==1){ echo "Selected";}?>>Active</option>
                  <option value="0" <?php if($calculation['status']==0){ echo "Selected";}?>>In-active</option>
                  </select>
                 </div>
                
                <div class="form-group col-md-4">
                  <label for="Image">Image<span class="mandatory">*</span></label>
                   <input type="file" id="image" name="image" accept="image/x-png,image/gif,image/jpeg" class="form-control">
                  <span id="image_error" class="error"></span>
                 </div>

                 <div class="form-group col-md-6">
                <span id="image_preview">
                 <?php if(is_file('attachments/calculations/thumb/'.$calculation['image'])){
                ?>
                <img  src="<?php echo base_url('attachments/calculations/thumb/'.$calculation['image'])?>" >
                <input type="hidden" name="old_image" id="old_image" value="<?php echo $calculation['image'];?>"><a href="javascript:void(0)" id="delete_image"><span class="glyphicon glyphicon-trash"></span></a>
                 <?php
               }
               ?>
               </span>
                </div>
                 
                 

              </div>
               </div>
 
              <div class="box-footer">
                <button type="button" class="btn btn-primary" id="add_update_calculation"><?php  echo $button;?><span id="add_update_calculation_loader"></span></button>
                <input type="hidden" id="id" name="id" value="<?php echo $calculation['id'];?>">
                
                <a href="<?php echo base_url('admin-manage-calculations');?>" type="button" class="btn btn-danger">Cancel</a>
              </div>
            </form>
            </div>
        
        </section>
        

  <?php  $this->load->view('admin/includes/footer');?>
    <script>
    $(function () {
    $('#add_update_calculation').click(function(){
    buttonEnableDisable('add_update_calculation', 1);
  	$('#success_message').html('');
		$('.form-control').removeClass('error');
		$('.error').html('');
		var form = $("#add_update_calculation_form")[0];
		var formData = new FormData(form);
		$.ajax({
			type: "POST",
			url: "<?php  echo base_url('admin-add-update-calculation');?>",
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
					$('#add_update_calculation_form').trigger("reset");
					setTimeout(function () {
            location.replace("<?php echo base_url('admin-manage-calculations')?>");
					},500);
				}
        buttonEnableDisable('add_update_calculation', 0);
			}
		});
	
    });

    $('#deleteImage').click(function(){
 			deleteDataImage('<?php echo base_url('admin-delete-calculation-image')?>');
    });

    
 })
</script>
 
