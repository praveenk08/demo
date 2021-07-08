
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
       <form role="form" id="add_update_why_choose_form">
              <div class="box-body">
              <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
					<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?></div>
                <div class="row d-flex flex-wrap">
                <?php
              $languages=getLanguageList();
            ?>
                <div class="form-group col-md-4">
                  <label for="Name">Select Language</label>
                  <select id="change_language" name="change_language" onChange="changeLanguage()" class="form-control">
                    <?php
                      foreach($languages as $language){
                        ?>
                        <option value="<?php echo $language['abbr'];?>"><?php echo $language['name'];?></option>
                        <?php
                      }
                    ?>
                  </select>
                </div>

                 
               

               <div class="form-group col-md-4">
                <?php
                    foreach($languages as $key=>$language){
                  ?> 
                  <div class="set_language" id="set_language<?php echo $language['abbr'];?>">
                    <label for="Name">Name <span class="mandatory">*</span>(<?php echo ucfirst($language['name']);?>)</label>
                    <input type="text" class="form-control"  name="name<?php echo $language['abbr'];?>" id="name<?php echo $language['abbr'];?>" placeholder="Name" value="<?php if(isset($names[$language['abbr']]['name'])){echo $names[$language['abbr']]['name'];}?>">
                    <input type="hidden" name="languages[]" value="<?php echo $language['abbr']?>">
                     <span id="name<?php echo $language['abbr'];?>_error" class="error"></span>
                  </div>
                  <?php
                    }
                  ?>
                </div>

               


                 <div class="form-group col-md-4">
                  <label for="Status">Status</label>
                  <select class="form-control" id="service_status" name="status">
                  <option value="1" <?php if($why_choose['status']==1){ echo "Selected";}?>>Active</option>
                  <option value="0" <?php if($why_choose['status']==0){ echo "Selected";}?>>In-active</option>
                  </select>
                 </div>
                  
                   
                <div class="form-group col-md-12">
                <?php
                    foreach($languages as $key=>$language){
                      ?>
                      <div class="set_language" id="set_languageinfo<?php echo $language['abbr'];?>">
                      
                        <div class="form-group">
                          <label for="Description">Description(<?php echo ucfirst($language['name']);?>)</label>
                          <textarea class="form-control" id="description<?php echo $language['abbr'];?>" name="description<?php echo $language['abbr'];?>" placeholder="Description"><?php if(isset($names[$language['abbr']]['description'])){echo $names[$language['abbr']]['description'];} ?></textarea>
                          <span id="description<?php echo $language['abbr'];?>_error" class="error"></span>
                        </div>
                      </div>
                      <?php
                   }
                  ?>
 
                </div>

                <div class="form-group col-md-6">
                  <label for="Image">Image</label>
                  <input type="file"  name="image" id="image" class="form-control change_image_section">
                  <span id="image_error" class="error"></span>
                 </div>

                 <div class="form-group col-md-6">
                 
                <span id="image_preview">
                 <?php if(is_file('attachments/why-choose-us/thumb/'.$why_choose['image'])){
                ?>
                <img  src="<?php echo base_url('attachments/why-choose-us/thumb/'.$why_choose['image'])?>"  id="image_prev">
                <a href="javascript:void(0)" id="delete_image"><span class="glyphicon glyphicon-trash"></span></a>
                 <?php
               }else{
                 ?>
                <img  id="image_prev" >
                 <?php
               }
               ?>
               </span>
                </div>

               

              </div>
               </div>
 
              <div class="box-footer">
              <button type="button" class="btn btn-primary" id="add_update_why_choose"><?php  echo $button;?><span id="add_update_why_choose_loader"></span></button>
              <input type="hidden" id="id" name="id" value="<?php echo $why_choose['id'];?>">
              <input type="hidden" name="old_image" id="old_image" value="<?php echo $why_choose['image'];?>">
              <a href="<?php echo base_url('admin-manage-why-choose');?>" type="button" class="btn btn-danger">Cancel</a>
              </div>
            </form>
            </div>
          
        </section>
        
     
  <?php  $this->load->view('admin/includes/footer');?>
    <script>

<?php
    foreach($languages as $language){
  ?>
 
    CKEDITOR.replace('description<?php echo $language['abbr'];?>', {
      height: 150
    });
  <?php
}

?>

      
    $(function () {
      changeLanguage();
 
    $('#add_update_why_choose').click(function(){
		buttonEnableDisable('add_update_why_choose', 1);
		$('#success_message').html('');
		$('.form-control').removeClass('error');
    $('.error').html('');
    for ( instance in CKEDITOR.instances ){
      CKEDITOR.instances[instance].updateElement(); 
    }
		var form = $("#add_update_why_choose_form")[0];
		var formData = new FormData(form);
		$.ajax({
			type: "POST",
			url: "<?php  echo base_url('admin-add-update-why-choose');?>",
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
					$('#add_update_why_choose_form').trigger("reset");
					setTimeout(function () {
            location.replace("<?php echo base_url('admin-manage-why-choose')?>");
					},500);
				}
				buttonEnableDisable('add_update_why_choose', 0);
			}
		});
	
    });

    $('#deleteImage').click(function(){
 			deleteDataImage('<?php echo base_url('admin-delete-why-choose-image')?>');
		});
 })
</script>
 
