<?php
   $this->load->view('website/includes/header');
   ?>
<!-- Main body wrapper -->
<div class="mainBody">
   <div class="msBreadcrumb">
      <div class="container-fluid">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Update Profile</li>
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
                        <div class="myProfile">
                           <div class="d-flex">
                              <!--<div class="myImg"> 
                                 </div>-->
                              <div class="myInfo">
                                 <div class="personalInfo">
                                    <div id="success_message" >
                                       <?php if($this->session->flashdata('success_message')){ ?> 
                                       <div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?>
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                       </div>
                                       <?php } ?>
                                    </div>
                                    <h5 class="infoTitle"><strong>Personal Details:</strong></h5>
                                    <form id="update_customer_profile_form"  role="form">
                                       <div class="row form-group">
                                          <label class="col-sm-4">First Name:<span class="mandatory">*</span></label>
                                          <div class="col-sm-8">
                                             <input type="text" class="form-control" name="customer_first_name" id="customer_first_name" placeholder="First Name" value="<?php echo $this->session->userdata('customer_data')['first_name'];?>">
                                             <span class="error" id="customer_first_name_error"></span>
                                          </div>
                                       </div>
                                       <div class="row form-group">
                                          <label class="col-sm-4">Last Name:<span class="mandatory">*</span></label>
                                          <div class="col-sm-8">
                                             <input type="text" class="form-control" name="customer_last_name" id="customer_last_name" placeholder="Last Name" value="<?php echo $this->session->userdata('customer_data')['last_name'];?>">
                                             <span class="error" id="customer_last_name_error"></span>
                                          </div>
                                       </div>
                                       <div class="row form-group">
                                          <label class="col-sm-4">Email:</label>
                                          <div class="col-sm-8"><?php echo $this->session->userdata('customer_data')['email'];?></div>
                                       </div>
                                       <div class="row form-group">
                                          <label class="col-sm-4">Password:</label>
                                          <div class="col-sm-8"><input type="password" class="form-control" id="customer_password" name="customer_password" placeholder="Password" value=""></div>
                                          <span id="customer_password_error" class="error"></span>
                                       </div>

									   <div class="row form-group">
                                          <label class="col-sm-4">Confirm Password:</label>
                                          <div class="col-sm-8"><input type="password" class="form-control" id="customer_confirm_password" name="customer_confirm_password" placeholder="Confirm Password" value=""></div>
                                          <span id="customer_confirm_password_error" class="error"></span>
                                       </div>

                                       <div class="row form-group">
                                          <label class="col-sm-4">Phone:<span class="mandatory">*</span></label>
                                          <div class="col-sm-8">
                                             <input type="text" class="form-control allownumericwithoutdecimal" minlength="10" maxlength="10" id="customer_phone" name="customer_phone" placeholder="Phone Number" value="<?php echo $this->session->userdata('customer_data')['phone'];?>">
                                             <span class="error" id="customer_phone_error"></span>
                                          </div>
                                       </div>
                                       <div class="row form-group">
                                          <label class="col-sm-4">Photo:</label>
                                          <div class="col-sm-4">
                                             <input type="file" name="customer_image" id="customer_image">
                                             <span class="error" id="customer_image_error"></span>
                                          </div>
                                          <div class="col-sm-4" id="image_preview"><?php
                                             if(is_file('attachments/users/thumb/'.$this->session->userdata('customer_data')['image'])){
                                             ?>
                                             <input type="hidden" name="old_image" value="<?php echo $this->session->userdata('customer_data')['image'];?>">
                                             <img src="<?php echo base_url('attachments/users/thumb/'.$this->session->userdata('customer_data')['image'])?>"><a href="javascript:void(0)" class="btn btn-sm removeBtn" id="delete_photo"><i class="fas fa-trash"></i></a>
                                             <?php
                                                }
                                                ?>
                                          </div>
                                       </div>

                                            <div class="row form-group">
                                          <label class="col-sm-4">Publication:<span class="mandatory">*</span></label>
                                          <div class="col-sm-4">
                                             <select class="form-control" name="publication">
                                             <option value="1" <?php if($this->session->userdata('customer_data')['publication']==1){ echo "Selected";}?>>Weekly</option>
                                             <option value="2" <?php if($this->session->userdata('customer_data')['publication']==2){ echo "Selected";}?>>Monthly</option>
                                             <option value="3" <?php if($this->session->userdata('customer_data')['publication']==3){ echo "Selected";}?>>3 Monthly</option>
                                             </select>
                                            
                                          </div>
                                       </div>

                                             <div class="row form-group">
                                          <label class="col-sm-4">Matching:<span class="mandatory">*</span></label>
                                          <div class="col-sm-4">
                                             <select class="form-control" name="matching">
                                             <option value="1" <?php if($this->session->userdata('customer_data')['matching']==1){ echo "Selected";}?>>Weekly</option>
                                             <option value="2" <?php if($this->session->userdata('customer_data')['matching']==2){ echo "Selected";}?>>Monthly</option>
                                             <option value="3" <?php if($this->session->userdata('customer_data')['matching']==3){ echo "Selected";}?>>3 Monthly</option>
                                             </select>
                                            
                                          </div>
                                       </div>


                                       <div class="row form-group">
                                          <div class="col-sm-12">
                                             <button type="button" class="btn signupBtn" id="update_customer_profile">Update Profile</button>
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
      </div>
   </div>
</div>
<?php
   $this->load->view('website/includes/footer');
   ?>
<script>
   $('#deleteProfilePhoto').click(function(){
   deleteProfilePhoto('<?php echo base_url('customer-remove-image')?>');
   });
</script>