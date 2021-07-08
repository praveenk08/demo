
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
    <?php
      $languages=getLanguageList();
    ?>
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
       <div class="col-md-12">
       <form role="form" id="copy_product_product_form">
              <div class="box-body">
              <div id="success_message"><?php if($this->session->flashdata('success_message')){ ?> 
					<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div><?php } ?></div>
          
          <div class="form-group col-md-4">
                  <label for="Name">Select Language<span class="mandatory">*</span></label>
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
                    <label for="Name">Name (<?php echo ucfirst($language['name']);?>)<span class="mandatory">*</span></label>
                   <input type="text" class="form-control name_suggestion" name="name<?php echo $language['abbr'];?>" id="name<?php echo $language['abbr'];?>" placeholder="Name" value="<?php echo $names[$language['abbr']]['name'];?>">
                  <input type="hidden" name="languages[]" value="<?php echo $language['abbr']?>">
                  <div id="suggesstion-box" class="suggesstion"></div>
                  <span id="name<?php echo $language['abbr'];?>_error" class="error"></span>
                  </div>
                    <?php
                  }
                  ?>
                  
                </div>

                <div class="col-md-3 col-sm-6 form-group">
                  <label for="Select Category">Select Categories</label><br>
						      <select name="category" id="category" class="form-control to_be_disable">
                  <option value="">Select Category</option>
                    <?php
                      $categories=categoryList(array('c.parent_id'=>0,'c.status'=>1));
                      foreach($categories as $category){
                        ?>
                        <option value="<?php echo $category['id'];?>" <?php if($category_id==$category['id']){ echo "selected='selected' ";}?><?php if($product['id']>0){ echo "Disabled";}?>><?php echo  $category['name'];?></option>
                        <?php
                      }
                    ?>
                  </select>
						      <span id="category_error" class="error"></span>
                </div>

                <div class="col-md-3 col-sm-6 form-group">
                  <label for="Select Child Category">Select Child Category</label><br>
						      <select name="child_category" id="child_category" class="form-control to_be_disable">
                  <option value="">Select Child Category</option>
                  </select>
						      <span id="child_category_error" class="error"></span>
                </div>


                <div class="form-group col-md-4">
                  <label for="Vendor">Vendor<span class="mandatory">*</span></label>
                  <select id="vendor_id" name="vendor_id" class="form-control">
                  <option value="">Select Vendor</option>
                  <?php 
                  if(count($vendors)>0){
                    foreach($vendors as $vendor){
                      ?>
                      <option value="<?php echo $vendor['id']?>"><?php echo $vendor['name']?></option>
                      <?php
                    }
                  }
                  ?>
                  </select>
                   <span id="vendor_id_error" class="error"></span>
                </div>


                
                <div class="form-group col-md-4">
                  <label for="Quantity">Quantity<span class="mandatory">*</span></label>
                  <input type="number" class="form-control" name="quantity" id="quantity" placeholder="Quantity" value="<?php echo $product['quantity'];?>">
                  <span id="quantity_error" class="error"></span>
                </div>
                <div class="form-group col-md-4">
                  <label for="Unit">Unit<span class="mandatory">*</span></label>
                  <select id="unit_id" name="unit_id" class="form-control">
                  <option value="">Select Unit</option>
                  <?php 
                  if(count($units)>0){
                    foreach($units as $unit){
                      ?>
                      <option value="<?php echo $unit['id']?>" <?php if($unit['id']==$product['unit_id']){echo "Selected";}?>><?php echo $unit['name']?></option>
                      <?php
                    }
                  }
                  ?>
                  </select>
                   <span id="unit_id_error" class="error"></span>
                </div>
                <div class="form-group col-md-4">
                   <label for="Unit Value">Unit Value<span class="mandatory">*</span></label>
                  <input type="number"  min="1"  class="form-control allownumericwithoutdecimal" name="unit_value" id="unit_value" placeholder="Unit Value" value="<?php echo $product['unit_value'];?>">
                  <span id="unit_value_error" class="error"></span>
                </div>
                <div class="form-group col-md-4">
                   <label for="Price">Price<span class="mandatory">*</span></label>
                  <input type="number" class="form-control" name="price" id="price" placeholder="Price" value="<?php echo $product['price'];?>">
                  <span id="price_error" class="error"></span>
                </div>
 
                <div class="form-group col-md-6">
                  <label for="Weight">Weight<span class="mandatory">*</span></label>
                  <input type="number" class="form-control" name="weight" id="weight" placeholder="Weight" value="<?php echo $product['weight'];?>">
                  <span id="weight_error" class="error"></span>
                </div>
          
                  
                 <div class="form-group col-md-<?php if(is_file('attachments/products/thumb/'.$product['image'])){echo "8"; }else{ echo "12";} ?>" >
                  <label for="Image">Product Main Image<span class="mandatory">*</span></label>
                   <input type="file" id="image" name="image" accept="image/x-png,image/gif,image/jpeg" class="form-control">
                   <span id="image_error" class="error"></span>
                 </div>
                 
                 <div class="form-group col-md-<?php if(is_file('attachments/products/thumb/'.$product['image'])){echo "4"; }else{ echo "0";} ?>">
               <span id="image_preview">
                 <?php if(is_file('attachments/products/thumb/'.$product['image'])){
                ?>
                <img  src="<?php echo base_url('attachments/products/thumb/'.$product['image'])?>" >
                <input type="hidden" name="old_image" id="old_image" value="<?php echo $product['image'];?>"><a href="javascript:void(0)" id="delete_image"><span class="glyphicon glyphicon-trash"></span></a>
                 <?php
               }
               ?>
               </span>
               
                </div>
                <div class="form-group col-md-4">
                <div id="product_image_frame"></div>
                <button class="btn btn-success product_main_image_crop" style="display:none;" >Crop and Upload</button>
                <span id="gallery-spinner-regular" style="display:none;"><i class="fa fa fa-spinner fa-spin"></i></span>
                </div>
                
                <div class="form-group col-md-12" id="product_image_div"></div>

                
                <div class="form-group col-md-12">
                  <label for="Product Secondary Image">Product Secondary Image</label>
                  <input type="file" name="secondary_image" id="secondary_image" accept="image/x-png,image/gif,image/jpeg" class="form-control">
                   <span id="secondary_image_error" class="error"></span>
                </div>
                <div class="form-group col-md-4">
                <div id="secondary_image_frame"></div>
                <button class="btn btn-success" id="secondary_image_crop" style="display:none;" >Crop and Upload</button>
                <span  id="secondary_image_loader" style="display:none;"><i class="fa fa fa-spinner fa-spin"></i></span>
                </div>
                <div class="form-group col-md-8">
                <div id="secondary_image_div">
                <?php if(count($secondary_images)>0){
                   foreach($secondary_images as $secondary_image){
                      if(is_file('attachments/products/thumb/'.$secondary_image['image'])){
                      ?>
                      <div class="gbrgImg" id="<?php echo $secondary_image['id'];?>"><img style="height:100px;width:100px" src="<?php echo base_url('attachments/products/thumb/'.$secondary_image['image'])?>"/>
                        <a class="removeimg" onclick="removeSecondaryImage('<?php echo $secondary_image['id'];?>')"><span class="glyphicon glyphicon-trash"></span></a>
                        <input type="hidden" name="old_product_secondary_image[]" class="smallsize" value="<?php echo $secondary_image['image'];?>"/> 
                        <input type="hidden" id="old_product_secondary_image<?php echo $secondary_image['id'];?>" value="<?php echo $secondary_image['image'];?>"/> 
                      </div>
                        <?php
                    }
                  }
                }?>
                </div>
                </div>


                   <?php
                  foreach($languages as $language){
                    ?>
                    <div class="set_language" id="set_languageinfo<?php echo $language['abbr'];?>">
                  <div class="form-group col-md-12">
                  <label for="Product Brief">Brief(<?php echo ucfirst($language['name']);?>)</label>
                   <textarea class="form-control" style="margin: 0px -543.991px 0px 0px; width: 1064px; height: 65px;" name="brief<?php echo $language['abbr'];?>" id="brief" placeholder="Product Brief"><?php echo $names[$language['abbr']]['brief'];?></textarea>
                  <span id="brief_error" class="error"></span>
                </div>

                <div class="form-group col-md-12">
                  <label for="Description">Description(<?php echo ucfirst($language['name']);?>)</label>
                   <textarea class="form-control" name="description<?php echo $language['abbr'];?>" id="description" placeholder="Description"><?php echo $names[$language['abbr']]['description'];?></textarea>
                  <span id="description_error" class="error"></span>
                </div>

                  </div>
                    <?php
                  }
                  ?>
                  
                  <div class="form-group col-md-12 ">
                  <label for="Meta Title">Meta Title<span class="mandatory">*</span></label>
                  <input type="text" class="form-control" name="meta_title" id="meta_title" placeholder="Meta Title" value="<?php echo $product['meta_title'];?>">
                  <span id="meta_title_error" class="error"></span>
                </div>

                <div class="form-group col-md-12 ">
                  <label for="Meta Keywords">Meta Keywords</label>
                  <input type="text" class="form-control" name="meta_keywords" id="meta_keywords" placeholder="Meta Keywords" value="<?php echo $product['meta_keywords'];?>">
                  <span id="meta_keywords_error" class="error"></span>
                </div>

                <div class="form-group col-md-12 ">
                  <label for="Meta Description">Meta Description</label>
                  <textarea class="form-control" name="meta_description" id="meta_description" placeholder="Meta Description"><?php echo $product['meta_description'];?></textarea>
                  <span id="meta_description_error" class="error"></span>
                </div>

                <div class="form-group col-md-12">
                  <label for="Status">Status</label>
                  <select class="form-control" id="product_status" name="status">
                  <option value="1" <?php if($product['status']==1){ echo "Selected";}?>>Active</option>
                  <option value="0" <?php if($product['status']==0){ echo "Selected";}?>>In-active</option>
                  </select>
                 </div>
 
               </div>
 
              <div class="box-footer">
              <button type="button" class="btn btn-primary" id="copy_product_product"><?php  echo $button;?></button>
              <input type="hidden" id="master_product_id" name="master_product_id" value="<?php echo $product['master_product_id'];?>"> 
              <input type="hidden" id="id" name="id" value="<?php echo $product['id'];?>">
                 <span id="copy_product_product_loader"></span>
              <a href="<?php echo base_url('admin-manage-products');?>" type="button" class="btn btn-primary">Cancel</a>
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

var child_category='<?php echo $child_category;?>';
     setTimeout(function(){ $('#category').trigger('change'); }, 1000);
    
    $('#category').change(function(){
      var html='<option value="">Select Child Category</option>';
      $('#child_category').html(html);
      if(this.value>0){
        $.ajax({
            url: "<?php echo base_url();?>common/Common/getChildCategories",
            type: "POST",
            data: {"id":this.value},
            success: function (ajaxresponse) {
            var response=JSON.parse(ajaxresponse);
            if(response.length>0){
               for(i=0;i<response.length;i++){
                 if(response[i]['id']==child_category){
                    selected="selected";
                }else{
                  selected='';
                }
                html +='<option value="'+response[i]['id']+'" '+selected+'>'+response[i]['name']+'</option>';
               }
            }
            $('#child_category').html(html);
          }
      });
      }
    })

     // $('#change_language').trigger('change');
    function changeLanguage(){
      var id=$('#change_language').val();
      $('.set_language').hide();
      $('#set_language'+id).show();
      $('#set_languageinfo'+id).show();
     } 
  $(function(){
    $('.to_be_disable').attr("disabled", true);
     $('#category').prop('disabled',true);

     changeLanguage();
     //$('#category').multiselect({
    //    includeSelectAllOption: true
   // });
  })


<?php
foreach($languages as $language){
  ?>
  CKEDITOR.replace('brief<?php echo $language['abbr'];?>', {
      height: 150
    });
    CKEDITOR.replace('description<?php echo $language['abbr'];?>', {
      height: 150
    });
  <?php
}

?>


    CKEDITOR.replace('meta_description', {
      height: 150
    });
 
  function product_image_frame(){
    $product_main_image = $('#product_image_frame').croppie({
        enableExif: true,
        enableResize: true,
        viewport: {
          width: 280,
          height: 280,
          type: 'trangle'
      },
      boundary: {
          width: 300,
          height:300
      }
    });
}
function secondary_image_frame(){
    $product_secondary_image = $('#secondary_image_frame').croppie({
        enableExif: true,
        enableResize: true,
        viewport: {
          width: 280,
          height: 280,
          type: 'trangle'
      },
      boundary: {
          width: 300,
          height:300
      }
    });
}

</script>

<script type="text/javascript">  
  var fileTypes = ['jpg', 'jpeg', 'png'];
 
  $(function(){
    product_image_frame();
    secondary_image_frame();
     $('#image').change(function () { 
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
  $('#secondary_image').change(function () { 
      var reader = new FileReader();
      var file = this.files[0]; // Get your file here
      var fileExt = file.type.split('/')[1]; // Get the file extension
      if (fileTypes.indexOf(fileExt) !== -1) {
        $('#secondary_image_crop').show();
        reader.onload = function (e) {
        $product_secondary_image.croppie('bind', {
          url: e.target.result
        }).then(function(){
          console.log('jQuery bind complete');
        });
      }
      reader.readAsDataURL(this.files[0]);
      }else{
        $('#secondary_image_crop').show();
        alert('File not supported');
        return false;
      }
  });
  

 
  // Product Main  Image

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
            url: "<?php echo base_url();?>admin/Products/uploadProductImage",
            type: "POST",
            data: {"image":resp,},
            success: function (ajaxresponse) {
             var response=JSON.parse(ajaxresponse);
            $('#gallery-spinner-regular').hide();
            var html='';
            html +='<div class="gbrgImg" id="'+response['image_id']+'"><img style="height:100px;width:100px" src="<?php echo base_url();?>'+response['image_path']+'"/>';
            html +='<a class="removeimg" onclick="removeImage('+response['image_id']+')"><span class="glyphicon glyphicon-trash"></span></a>';
            html +='<input type="hidden" name="product_image" id="product_image" class="smallsize" value="'+response['image_name']+'"/>';
            html +='<input type="hidden" name="image_path" id="image_path"  value="'+response['image_path']+'"/></div>';
            $('#product_image_div').html(html);
            $('.cr-image, .cr-overlay').removeAttr('style src');
            $('#image').val('');
          }
      });
    });
  });

// Product Secondary Image
  $('#secondary_image_crop').click(function (ev) {
        $('#secondary_image_loader').show();
        $('#secondary_image_crop').hide();
        ev.preventDefault();
        $product_secondary_image.croppie('result', {
          type: 'canvas',
          size: {width: 1000, height: 1000},
          format:"jpeg",
          quality:0.5	
         }).then(function (resp) {
          $.ajax({
            url: "<?php echo base_url();?>admin/Products/uploadProductImage",
            type: "POST",
            data: {"image":resp},
            success: function (ajaxresponse) {
             var response=JSON.parse(ajaxresponse);
            $('#secondary_image_loader').hide();
            var html='';
            html +='<div class="gbrgImg" id="'+response['image_id']+'"><img style="height:100px;width:100px" src="<?php echo base_url();?>'+response['image_path']+'"/>';
            html +='<a class="removeimg" onclick="removeImage('+response['image_id']+')"><span class="glyphicon glyphicon-trash"></span></a>';
            html +='<input type="hidden" name="product_secondary_image[]" class="smallsize" value="'+response['image_name']+'"/>';
            html +='<input type="hidden" name="product_secondary_image_path[]"   value="'+response['image_path']+'"/></div>';
            $('#secondary_image_div').append(html);
            $('.cr-image, .cr-overlay').removeAttr('style src');
            $('#secondary_image').val('');
          }
      });
    });
  });

 


 

    $('#copy_product_product').click(function(){
 	    buttonEnableDisable('copy_product_product', 1);
		$('#success_message').html('');
		$('.form-control').removeClass('error');
		$('.error').html('');
		var form = $("#copy_product_product_form")[0];
        var formData = new FormData(form);
        for ( instance in CKEDITOR.instances )
			CKEDITOR.instances[instance].updateElement(); 
		$.ajax({
			type: "POST",
			url: "<?php  echo base_url('admin-copy-save-product');?>",
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
					$('#copy_product_product_form').trigger("reset");
					setTimeout(function () {
                         location.replace("<?php echo base_url('admin-manage-products')?>");
					},500);
				}
				buttonEnableDisable('copy_product_product', 0);
			}
		});
	
    });

    $('#deleteImage').click(function(){
 			deleteDataImage('<?php echo base_url('admin-delete-product-image')?>');
    });
    $('#deleteSecondaryImage').click(function(){
      var id=$('#secondary_image_id').val();
       var image=$('#old_product_secondary_image'+id).val();
      if(id>0 && image!=''){
        $('#deleteSecondaryImageModalPopup').modal('hide');
        $('#delete_secondary_image_confirmation_message').html('');
        $.ajax({
          url  :'<?php echo base_url('admin-delete-product-secondary-image')?>', 
          type : 'POST',
          data : {'id':id,'image':image},
          async : false,
          cache : false,
          success: function(ajaxresponse){
            response=JSON.parse(ajaxresponse);
            if(!response['status']){
              $('#success_message').html('<div class="alert alert-danger">'+response['message']+' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }else{
              $('#success_message').html('<div class="alert alert-success">'+response['message']+' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
              $('#'+id).remove();
            }
            closePopup('success_message');  
          }
        });
      }
    });
 
 }); 
function removeImage(id){
   $('#'+id).remove();
}
function removeSecondaryImage(id){
    $('#deleteSecondaryImageModalPopup').modal('show');
    $('#secondary_image_id').val(id);
  	$('#delete_secondary_image_confirmation_message').html('Are you sure want to delete this image?');
}
 
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
</script>
 
