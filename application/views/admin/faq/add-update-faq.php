
<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>
    <?php  echo $heading;?>
       </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
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


              <?php
              $languages=getLanguageList();
            ?>
                <div class="form-group col-md-12">
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

               

                <div class="form-group col-md-12">
                <?php
                    foreach($languages as $key=>$language){
                  ?> 
                  <div class="set_language" id="set_language<?php echo $language['abbr'];?>">
                    <label for="Question">Question(<?php echo ucfirst($language['name']);?>)</label>
                    <input type="text" class="form-control"  name="question<?php echo $language['abbr'];?>" id="question<?php echo $language['abbr'];?>" placeholder="Question" value="<?php if(isset($names[$language['abbr']]['question'])){echo $names[$language['abbr']]['question'];}?>">
                    <input type="hidden" name="languages[]" value="<?php echo $language['abbr']?>">
                     <span id="question<?php echo $language['abbr'];?>_error" class="error"></span>
                  </div>
                  <?php
                    }
                  ?>

            <div class="form-group col-md-12">
            <?php
                    foreach($languages as $key=>$language){
                      ?>
                      <div class="set_language" id="set_languageinfo<?php echo $language['abbr'];?>">
                      
                        <div class="form-group">
                          <label for="Answer">Answer(<?php echo ucfirst($language['name']);?>)</label>
                          <textarea class="form-control" name="answer<?php echo $language['abbr'];?>" placeholder="Answer"><?php if(isset($names[$language['abbr']]['answer'])){echo $names[$language['abbr']]['answer'];} ?></textarea>
                          <span id="answer<?php echo $language['abbr'];?>_error" class="error"></span>
                        </div>
                      </div>
                      <?php
                   }
                  ?>
 
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
              <a href="<?php echo base_url('admin-manage-faqs');?>" type="button" class="btn btn-danger">Cancel</a>
              </div>
            </form>
            </div>
         
        </section>
        
     
    <!-- /.content -->
  <?php  $this->load->view('admin/includes/footer');?>
    <script>
        <?php
    foreach($languages as $language){
  ?>
 
    CKEDITOR.replace('answer<?php echo $language['abbr'];?>', {
      height: 150
    });
  <?php
}

?>

    $(function () {
      changeLanguage();

 
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
 
