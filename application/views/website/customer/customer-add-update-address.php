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
            <li class="breadcrumb-item active"><?php echo $btn;?></li>
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
                                 <h5 class="srvHead"><?php echo $btn;?></h5>
                                 <div class="addAddress">
                                    <div class="row">
                                       <div class="form-group col-md-4">
                                          <label for="Name">Contact Name<span class="mandatory">*</span></label>
                                          <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $address['name'];?>">
                                        </div>
                                       <div class="form-group col-md-4">
                                          <label for="Phone">Phone<span class="mandatory">*</span></label>
                                          <input type="text"class="form-control" minlength="5" maxlength="15" name="phone" id="phone" placeholder="Phone" value="<?php echo $address['phone'];?>">
                                        </div>
                                       <div class="form-group col-md-4">
                                          <label for="Email">Email Address<span class="mandatory">*</span></label>
                                          <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $address['email'];?>">
                                        </div>
                                       <div class="form-group col-md-4">
                                          <?php
                                             $countries=getCountryList();
                                              ?>
                                          <label for="Select Country">Select Country<span class="mandatory">*</span></label>
                                          <select class="form-control" id="change_country" name="change_country">
                                             <option value="">Select Country</option>
                                             <?php if(count($countries)>0){
                                                foreach($countries as $country){
                                                  ?>
                                             <option value="<?php echo $country['id']?>" <?php if($address['country']==$country['id']){echo "Selected";}?>><?php echo $country['name'];?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </select>
                                        </div>
                                       <div class="form-group col-md-4">
                                          <label for="State">State<span class="mandatory">*</span></label>
                                          <select class="form-control" id="change_state" name="change_state">
                                             <option value="">Select State</option>
                                          </select>
                                        </div>
                                       <div class="form-group col-md-4">
                                          <label for="city">city<span class="mandatory">*</span></label>
                                          <select class="form-control" id="change_city" name="change_city">
                                             <option value="">Select City</option>
                                          </select>
                                        </div>
                                       <div class="form-group col-md-4">
                                          <label for="Address">Address Type</label><br>
                                           
                                          <input type="radio" name="address_type" value="Home" <?php if($address['address_type']=='Home'){echo "Checked";}?>> Home
                                          <input type="radio" name="address_type" value="Work" <?php if($address['address_type']=='Work'){echo "Checked";}?>> Work
                                          <input type="radio" name="address_type" value="Office" <?php if($address['address_type']=='Office'){echo "Checked";}?>> Office  
                                        </div>

                                       <div class="form-group col-md-8">
                                          <label for="Address">Address<span class="mandatory">*</span></label>
                                          <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php echo $address['address'];?>">
                                        </div>
                                       
                                       <div class="form-group col-md-4">
                                          <label for="Landmark">Landmark<span class="mandatory">*</span></label>
                                          <input type="text" class="form-control" id="landmark" name="landmark" placeholder="Landmark" value="<?php echo $address['landmark'];?>">
                                        </div>
                                       
                                       <div class="form-group col-md-4">
                                          <label for="Street">Street</label>
                                          <input type="text" class="form-control" id="street" name="street" placeholder="Street" value="<?php echo $address['street'];?>">
                                       </div>
                                       <div class="form-group col-md-4">
                                          <label for="Block">Block</label>
                                          <input type="text" class="form-control" id="block" name="block" placeholder="Block" value="<?php echo $address['block'];?>">
                                       </div>

                                       <div class="form-group col-md-4">
                                          <label for="Zip">Zip<span class="mandatory">*</span></label>
                                          <input type="text" class="form-control allownumericwithoutdecimal"   minlength="5" maxlength="7" id="zip" name="zip" placeholder="Zip" value="<?php echo $address['zip'];?>">
                                        </div>

                                       <div class="form-group col-md-4">
                                          <label for="Status">Status</label>
                                          <select class="form-control" id="address_status" name="status">
                                             <option value="1" <?php if($address['status']==1){ echo "Selected";}?>>Active</option>
                                             <option value="0" <?php if($address['status']==0){ echo "Selected";}?>>In-active</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="row form-group">
                                       <label class="col-sm-4"></label>
                                       <div class="col-sm-8">
                                          <button type="button" class="btn signupBtn" id="add_update_customer_address"><?php echo $btn;?></button>
                                          <input type="hidden" name="id" value="<?php echo $address['id'];?>">
                                          <input type="hidden" name="ch" value="<?php echo $address['ch'];?>">
                                           <input type="button" value="Cancel"  class="btn signupBtn" onclick="window.location.href='<?php echo base_url('customer-manage-addresses');?>'" />
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
      var country_id=<?php echo $address['country']?>;
      var state_id=<?php echo $address['state']?>;
      var city_id=<?php echo $address['city']?>;
       if(country_id>0){
      $('#change_country').trigger('change');
      if(state_id!=''){
        setTimeout(function(){
          $('#change_state').val(state_id);
          $('#change_state').trigger('change');
          if(city_id!=''){
            setTimeout(function(){
            $('#change_city').val(city_id);
          }, 500);
         }
        }, 500);
      }
    }
 
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