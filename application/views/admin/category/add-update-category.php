
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
       <form role="form" id="add_update_category_form">
              <div class="box-body">
              <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
					<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?></div>
                <div class="row d-flex flex-wrap">
                <?php
              $languages=getLanguageList();
            ?>
                <div class="form-group col-md-4">
                  <label for="Select Language">Select Language</label>
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
                  <label for="Select Parent Category">Select Parent Category</label>
                  <select id="parent_id" name="parent_id" class="form-control"  >
                  <option value="">Select Parent Category</option>
                  <?php 
                  foreach($categories as $category_list){
                    ?>
                    <option value="<?php echo $category_list['id'];?>" <?php if($category_list['id']==$category['parent_id']){echo "Selected";}?>><?php echo $category_list['name'];?></option>
                    <?php
                  }
                  ?>
                  </select>
 
                 </div>
                <span id="child_category_div"></span>

                <div class="form-group col-md-4">
                <?php
                    foreach($languages as $key=>$language){
                  ?> 
                  <div class="set_language" id="set_language<?php echo $language['abbr'];?>">
                    <label for="Category Name">Category Name (<?php echo ucfirst($language['name']);?>)<span class="mandatory">*</span></label>
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
                  <select class="form-control" id="category_status" name="status">
                  <option value="1" <?php if($category['status']==1){ echo "Selected";}?>>Active</option>
                  <option value="0" <?php if($category['status']==0){ echo "Selected";}?>>In-active</option>
                  </select>
                 </div>

                <div class="form-group col-md-4">
                  <label for="Image">Image</label>
                  <input type="file" id="Image" name="category_image" id="category_image" class="form-control">
                  <span id="category_image_error" class="error"></span>
                 </div>

                 <div class="form-group col-md-6">
                <span id="image_preview">
                 <?php if(is_file('attachments/category/thumb/'.$category['image'])){
                ?>
                <img  src="<?php echo base_url('attachments/category/thumb/'.$category['image'])?>" >
                <input type="hidden" name="old_image" id="old_image" value="<?php echo $category['image'];?>"><a href="javascript:void(0)" id="delete_image"><span class="glyphicon glyphicon-trash"></span></a>
                 <?php
               }
               ?>
               </span>
                </div>

              </div>
                 </div>
 
              <div class="box-footer">
                <button type="button" class="btn btn-primary" id="add_update_category"><?php  echo $button;?><span id="add_update_category_loader"></span></button>
                <input type="hidden" id="id" name="id" value="<?php echo $category['id'];?>">
                <a href="<?php echo base_url('admin-manage-category');?>" type="button" class="btn btn-danger">Cancel</a>
              </div>
            </form>
            </div>        
        </section>
      
  <?php  $this->load->view('admin/includes/footer');?>
    <script>

  

  $(function () {
    changeLanguage();
    var id=$('#id').val();
    $('#add_update_category').click(function(){
    buttonEnableDisable('add_update_category', 1);
    $('#success_message').html('');
    $('.form-control').removeClass('error');
    $('.error').html('');
    var form = $("#add_update_category_form")[0];
    var formData = new FormData(form);
    $.ajax({
      type: "POST",
      url: "<?php  echo base_url('admin-add-update-category');?>",
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
  $('#add_update_category_form').trigger("reset");
  setTimeout(function () {
  location.replace("<?php echo base_url('admin-manage-category')?>");
  },500);
  }
  buttonEnableDisable('add_update_category', 0);
  }
  });

  });

  $('#deleteImage').click(function(){
  deleteDataImage('<?php echo base_url('admin-delete-category-image')?>');
  });
  })



 </script>
 
