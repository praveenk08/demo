
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
       <form role="form" id="add_update_category_form">
              <div class="box-body">
              <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
					<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?></div>
                
                <div class="form-group col-md-6">
                  <label for="Select Category">Select Category</label>
                  <select id="category1" name="category1" class="form-control cate"  >
                  <option value="">Select Category</option>
                  <?php 
                  foreach($categories as $category_list){
                    ?>
                    <option value="<?php echo $category_list['id'];?>"><?php echo $category_list['name'];?></option>
                    <?php
                  }
                  ?>
                  </select>
 
                 </div>
                <span id="child_category_div"></span>
                <div class="form-group col-md-6">
                  <label for="Name">Name<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $category['name'];?>">
                  <span id="name_error" class="error"></span>
                </div>
                

                <div class="form-group col-md-6">
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


                <div class="form-group col-md-6">
                  <label for="Meta Title">Meta Title</label>
                  <input type="text" class="form-control" name="meta_title" id="meta_title" placeholder="Meta KeywTitleords" value="<?php echo $category['meta_title'];?>">
                  <span id="meta_title_error" class="error"></span>
                </div>


                <div class="form-group col-md-12">
                  <label for="Meta Keywords">Meta Keywords</label>
                  <input type="text" class="form-control" name="meta_keywords" id="meta_keywords" placeholder="Meta Keywords" value="<?php echo $category['meta_keywords'];?>">
                  <span id="meta_keywords_error" class="error"></span>
                </div>


                <div class="form-group col-md-12">
                  <label for="Meta Description">Meta Description</label>
                  <textarea name="meta_description" id="meta_description" placeholder="Meta Description" style="margin: 0px; width: 1080px; height: 75px;"><?php echo $category['meta_description'];?></textarea>
                   <span id="meta_description_error" class="error"></span>
                </div>


                <div class="form-group col-md-12">
                  <label for="Status">Status</label>
                  <select class="form-control" id="category_status" name="status">
                  <option value="1" <?php if($category['status']==1){ echo "Selected";}?>>Active</option>
                  <option value="0" <?php if($category['status']==0){ echo "Selected";}?>>In-active</option>
                  </select>
                 </div>
                 </div>
 
              <div class="box-footer">
              <button type="button" class="btn btn-primary" id="add_update_category"><?php  echo $button;?><span id="add_update_category_loader"></span></button>
              <input type="hidden" id="id" name="id" value="<?php echo $category['id'];?>">
 						<input type="hidden" name="parent_id" id="parent_id" value="<?php echo $category['parent_id'];?>">

						<input type="hidden" name="max_counter" id="max_counter" value="0">
						<input type="hidden" name="level_counter" id="level_counter" value="0">
              
              <a href="<?php echo base_url('admin-manage-category');?>" type="button" class="btn btn-danger">Cancel</a>
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

  var category_list_table='';
  function categoryHierarchy(parent_id,counter=1){
    if(parent_id>0){
      $.ajax({
        url  :'<?php echo base_url('admin-category-hierarchy')?>', 
        type : 'POST',
        data : {'parent_id':parent_id},
        async : false,
        cache : false,
        success : function(ajaxresponse) {
          response=JSON.parse(ajaxresponse);
          categories=response['categories'];
          counter=response['counter'];
          if(categories.length>0){
            $('#max_counter').val(counter);
            $('#category_id_level'+counter).remove();
            html='<div class="form-group col-md-6" id="category_id_level'+counter+'">';
            html +='<label for="Select Category">Select Sub Category</label>';
            html +='<select id="category'+counter+'" name="category'+counter+'" class="form-control cate" onchange="categoryHierarchy(this.value,'+counter+')" >';
            html +='<option value="">Select Sub Category</option>';
            for(i=0;i<categories.length;i++){
              html +='<option value="'+categories[i]['id']+'">'+categories[i]['name']+'</option>'
            }
            html +='</select></div>';
            $('#child_category_div').append(html);
          }
        }
      });
    } 
    var max_counter=$('#max_counter').val();
    if(max_counter>1){
      for(i=max_counter;i>counter;i--){
        $('#category_id_level'+i).remove();
      }
    }
    $('.cate').each(function() {
      var category_id=$(this).val();
      if(category_id>0){
        $('#parent_id').val(category_id);
      }
    }); 
  }


  $(function () {
    var id=$('#id').val();
    var parent_id=$('#parent_id').val();
    if(id>0){
      getLevel(id);
      var level_counter=$('#level_counter').val();
				$('#max_counter').val(level_counter);
				categoryParentDom(level_counter,parent_id);
    }
    $('#category1').change(function(){
      var parent_id=this.value;
      $('#child_category_div').html('');
      $('#parent_id').val(parent_id);
      if(parent_id>0){
        categoryHierarchy(parent_id,1);
      }
    })


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

  function getLevel(id){
 		$.ajax({
			type: "POST",
			async : false,
			url: '<?php echo base_url('admin-get-category-level')?>',
			data: {'id':id},
			success: function(ajaxresponse){
				response=JSON.parse(ajaxresponse);
				var counter= response['counter']-2;
				$('#level_counter').val(counter);
			}
		});
	}

  function categoryParentDom(id,level_counter){
 		$.ajax({
			type: "POST",
			async : false,
			url: '<?php echo base_url('admin-get-parent-category')?>',
			data: {'id':id},
			success: function(ajaxresponse){
				response=JSON.parse(ajaxresponse);
				var parent_id=response['parent_id'];
        if(parent_id>0){
          $('#category_id_level'+level_counter).remove();
			  	html='<div class="form-group col-md-6" id="category_id_level'+level_counter+'">';
			  	html +='<label for="Select Category">Select Sub Category</label>';
			  	html +='<select id="category'+level_counter+'" name="category'+level_counter+'" class="form-control cate" onchange="categoryHierarchy(this.value,'+level_counter+')" >';
			  	html +='<option value="">Select Sub Category</option>';
			  	html +='<option value="'+response['id']+'" selected>'+response['name']+'</option>'
			  	html +='</select></div>';
        }
 				//var id=response['id'];
        if(parent_id==0){
          //	var html='';
          $('#category1').val(response['id']);
        //  $('#category1').html('<option value="">Select Category</option>');
         // $('#category1').append('<option value="">Select Category</option>');

        //  $('#category1').val(response['id']);
				  //$('#category1').val('');
        //  $('#child_category_div').prepend(html);
        }else{
					$('#child_category_div').prepend(html);
        }
				if(parent_id>0){
					var counter=level_counter-1;
					categoryParentDom(parent_id,counter);
				}
			}
		});
	}
</script>
 
