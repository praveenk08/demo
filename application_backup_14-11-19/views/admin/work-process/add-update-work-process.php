
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
       <form role="form" id="add_update_work_process_form">
              <div class="box-body">
              <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
					<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?></div>
              <div class="row d-flex flex-wrap">
                <div class="form-group col-md-4">
                  <label for="Name">Name<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $work_process['name'];?>">
                  <span id="name_error" class="error"></span>
                </div>

                 
                <div class="form-group col-md-4">
                  <label for="Sort Id">Sort Id<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="sort_id" id="sort_id" placeholder="sort Order" value="<?php echo $work_process['sort_id'];?>">
                  <span id="sort_id_error" class="error"></span>
                </div>
                 
                <div class="form-group col-md-4">
                  <label for="Status">Status</label>
                  <select class="form-control" id="team_status" name="status">
                  <option value="1" <?php if($work_process['status']==1){ echo "Selected";}?>>Active</option>
                  <option value="0" <?php if($work_process['status']==0){ echo "Selected";}?>>In-active</option>
                  </select>
                 </div>
                
                <div class="form-group col-md-4">
                  <label for="Image">Image<span class="mandatory">*</span></label>
                   <input type="file" id="image" name="image" accept="image/x-png,image/gif,image/jpeg" class="form-control">
                  <span id="image_error" class="error"></span>
                 </div>

                 <div class="form-group col-md-4">
                <span id="image_preview">
                 <?php if(is_file('attachments/work-process/thumb/'.$work_process['image'])){
                ?>
                <img  src="<?php echo base_url('attachments/work-process/thumb/'.$work_process['image'])?>" >
                <input type="hidden" name="old_image" id="old_image" value="<?php echo $work_process['image'];?>"><a href="javascript:void(0)" id="delete_image"><span class="glyphicon glyphicon-trash"></span></a>
                 <?php
               }
               ?>
               </span>
                </div>
                <!--<div class="form-group col-md-12">
                <div id="product_image_frame"></div>
                <button class="btn btn-success product_main_image_crop" style="display:none;" >Crop and Upload</button>
                <span id="gallery-spinner-regular" style="display:none;"><i class="fa fa fa-spinner fa-spin"></i></span>
                </div>-->
                
               <!-- <div class="form-group col-md-12" id="product_image_div">
                 </div>-->

                 
              </div>
                 
               </div>
 
              <div class="box-footer">
              <button type="button" class="btn btn-primary" id="add_update_work_process"><?php  echo $button;?><span id="add_update_work_process_loader"></span></button>
              <input type="hidden" id="id" name="id" value="<?php echo $work_process['id'];?>">
              
              <a href="<?php echo base_url('admin-manage-work-process');?>" type="button" class="btn btn-danger">Cancel</a>
              </div>
            </form>
            </div>
          
        </section>
        
      
    <!-- /.content -->
  <?php  $this->load->view('admin/includes/footer');?>
    <script>
    $(function () {
      var fileTypes = ['jpg', 'jpeg', 'png'];

      //product_image_frame();

    $('#add_update_work_process').click(function(){
    buttonEnableDisable('add_update_work_process', 1);
 		$('#success_message').html('');
		$('.form-control').removeClass('error');
		$('.error').html('');
		var form = $("#add_update_work_process_form")[0];
		var formData = new FormData(form);
		$.ajax({
			type: "POST",
			url: "<?php  echo base_url('admin-add-update-work-process');?>",
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
					$('#add_update_work_process_form').trigger("reset");
					setTimeout(function () {
            location.replace("<?php echo base_url('admin-manage-work-process')?>");
					},500);
				}
				buttonEnableDisable('add_update_work_process', 0);
			}
		});
	
    });

    $('#deleteImage').click(function(){
 			deleteDataImage('<?php echo base_url('admin-delete-work-process-image')?>');
    });
    
    $('#image12').change(function () { 
      var reader = new FileReader();
      var file = this.files[0]; // Get your file here
      var fileExt = file.type.split('/')[1]; // Get the file extension
      if (fileTypes.indexOf(fileExt) !== -1) {
        $('.product_main_image_crop').show();
        reader.onload = function (e) {
        $product_main_image.croppie('bind', {
          url: e.target.result
        }).then(function(){
          console.log('jQuery bind complete');
        });
      }
      reader.readAsDataURL(this.files[0]);
      }else{
        $('.product_main_image_crop').hide();	
        alert('File not supported');return false;
      }
  });

  $('.product_main_image_crop').click(function (ev) {
      $('.product_main_image_crop').hide();
      $('#gallery-spinner-regular').show();
        ev.preventDefault();
        $product_main_image.croppie('result', {
          type: 'canvas',
          size: {width: 1000, height: 1000},
          format:"jpeg",
          quality:0.5	
         }).then(function (resp) {
          $.ajax({
            url: "<?php echo base_url();?>admin/our-service/uploadteamImage",
            type: "POST",
            data: {"image":resp},
            success: function (ajaxresponse) {
             var response=JSON.parse(ajaxresponse);
            $('#gallery-spinner-regular').hide();
            var html='';
            html +='<div class="gbrgImg" id="'+response['image_id']+'"><img style="height:100px;width:100px" src="<?php echo base_url();?>'+response['image_path']+'"/>';
            html +='<a class="removeimg" onclick="removeImage('+response['image_id']+')"><span class="glyphicon glyphicon-trash"></span></a>';
            html +='<input type="hidden" name="team_image" id="team_image" class="smallsize" value="'+response['image_name']+'"/>';
            html +='<input type="hidden" name="image_path" id="image_path"  value="'+response['image_path']+'"/></div>';
            $('#product_image_div').html(html);
            $('.cr-image, .cr-overlay').removeAttr('style src');
            $('#image').val('');
          }
      });
    });
  });


 })
</script>
 
