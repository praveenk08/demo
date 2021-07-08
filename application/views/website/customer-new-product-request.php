<?php $this->load->view('website/includes/header');
if($this->session->userdata('language')=='en'){
   $home_label="Home";
   $dashboard_label="Dashboard";
}else{
   $home_label="الصفحة الرئيسية";
   $dashboard_label="لوحة القيادة";
}
?>
<!-- Main body wrapper -->
<div class="mainBody">
   <div class="msBreadcrumb">
      <div class="container-fluid">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><?php echo $home_label;?></a></li>
            <li class="breadcrumb-item active">New Product Request</li>
         </ol>
      </div>
   </div>
   <div class="userWrapper">
      <div class="container-fluid">
         <div class="cwContainer">
            <div class="uwBox d-flex flex-wrap">
               <?php $this->load->view('website/customer/left-panel');?>
               <div class="profileRt">
                  <div class="tab-content">
                     <div class="tab-pane active" id="myProfile">
                        <div class="manageAddress">
                          
                        
                        <form id="add_update_customer_address_form">
                                 <div id="success_message" >
                                    <?php if($this->session->flashdata('success_message')){ ?> 
                                    <div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?>
                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <?php } ?>
                                 </div>
                                 <h5 class="srvHead">New Product Request</h5>
                                 <div class="addAddress">
                                    <div class="row">
                                       <div class="form-group col-md-12">
                                          <label for="Subject">Subject<span class="mandatory">*</span></label>
                                          <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" value="">
                                        </div>
                                       <div class="form-group col-md-6">
                                          <label for="Category Name">Category Name<span class="mandatory">*</span></label>
                                          <input type="text"class="form-control"   name="category_name" id="category_name" placeholder="Category Name" value="">
                                        </div>

                                        <div class="form-group col-md-6">
                                          <label for="Category Name">Sub Category Name<span class="mandatory">*</span></label>
                                          <input type="text"class="form-control"  name="sub_category_name" id="sub_category_name" placeholder="Sub Category Name" value="">
                                        </div>
 
                                       
                                        <div class="form-group text col-md-12">
                                          <label for="Message">Message<span class="mandatory">*</span></label>
                                          <textarea class="form-control" name="message" id="message" placeholder="Message" style=""></textarea>
                                        </div>
                                      
  
                                    </div>
                                    <div class="row form-group">
                                       <label class="col-sm-4"></label>
                                       <div class="col-sm-8">
                                          <button type="button" class="btn signupBtn" id="add_new_product_request">Send</button>
                                            <input type="button" value="Cancel"  class="btn signupBtn" onclick="window.location.href='<?php echo base_url('customer-matching-and-connections');?>'" />
                                       </div>
                                    </div>
                                 </div>
                           </form>
                           </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php
   $this->load->view('website/includes/footer');
   ?>
   <script>
      $(function(){
      
 
   $('#add_update_customer_address').click(function(){
  	$('#add_update_customer_address').attr("disabled", true);
	  $('#add_update_customer_address_form input,select').css('border', '1px solid #ccc');
	  $('#success_message').html('');
	  $('.error').remove();
		 $.ajax({
		  url: '<?php echo base_url('customer-save-address');?>',
		  type: "POST",
		  data: new FormData($("#add_update_customer_address_form")[0]),
		  async: false,
		  cache: false,
		  contentType: false,
		  processData: false,
		  success: function (ajaxresponse) { 
			  response=JSON.parse(ajaxresponse);
			  if(!response['status']){
				  $.each(response['response'], function(key, value) {
               $('#' + key).css('border', '1px solid #cc0000');
               $('#' + key).after('<span id="'+key+'_error" class="error">'+value+'</span>');
				  });
				  $('#success_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				  $('#add_update_customer_address').removeAttr("disabled");
			  }else{
				  $('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				   setTimeout(function(){
                  if(response['ch']==1){
                     window.location.href = response['ch_url']; 
                  }else{
                     window.location.href = response['url']; 
                  }
				  }, 500);
			  } 
			}
	  }) 
  });
       })
     
   </script>