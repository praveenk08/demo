<?php
   $this->load->view('website/includes/header');
   ?>
<!-- Main body wrapper -->
<div class="mainBody">
   <div class="msBreadcrumb">
      <div class="container-fluid">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
         </ol>
      </div>
   </div>
   <div class="userWrapper">
      <div class="container-fluid">
         <div class="cwContainer">
            <div class="uwBox d-flex flex-wrap">
               <?php $this->load->view('website/delivery-boy/left-panel');?>
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
                                    <form id="update_delivery_boy_profile_form"  role="form">
                                       <div class="row form-group">
                                          <label class="col-sm-4">First Name:</label>
                                          <div class="col-sm-5">
                                             <input type="text" class="form-control" name="delivery_boy_first_name" id="delivery_boy_first_name" placeholder="First Name" value="<?php echo $this->session->userdata('delivery_boy_data')['first_name'];?>">
                                             <span class="error" id="delivery_boy_first_name_error"></span>
                                          </div>
                                       </div>
                                       <div class="row form-group">
                                          <label class="col-sm-4">Last Name:</label>
                                          <div class="col-sm-8">
                                             <input type="text" class="form-control" name="delivery_boy_last_name" id="delivery_boy_last_name" placeholder="Last Name" value="<?php echo $this->session->userdata('delivery_boy_data')['last_name'];?>">
                                             <span class="error" id="delivery_boy_last_name_error"></span>
                                          </div>
                                       </div>
                                       <div class="row form-group">
                                          <label class="col-sm-4">Email:</label>
                                          <div class="col-sm-8"><?php echo $this->session->userdata('delivery_boy_data')['email'];?></div>
                                       </div>
                                       <div class="row form-group">
                                          <label class="col-sm-4">Phone:</label>
                                          <div class="col-sm-8">
                                             <input type="text" class="form-control" id="delivery_boy_phone" name="delivery_boy_phone" placeholder="Phone Number" value="<?php echo $this->session->userdata('delivery_boy_data')['phone'];?>">
                                             <span class="error" id="delivery_boy_phone_error"></span>
                                          </div>
                                       </div>
                                       <div class="row form-group">
                                          <label class="col-sm-4">Photo:</label>
                                          <div class="col-sm-4">
                                             <input type="file" name="delivery_boy_image" id="delivery_boy_image">
                                             <span class="error" id="delivery_boy_image_error"></span>
                                          </div>
                                          <div class="col-sm-4"><?php
                                             if(is_file('attachments/users/thumb/'.$this->session->userdata('delivery_boy_data')['image'])){
                                             ?>
                                             <input type="hidden" name="old_image" value="<?php echo $this->session->userdata('delivery_boy_data')['image'];?>">
                                             <img src="<?php echo base_url('attachments/users/thumb/'.$this->session->userdata('delivery_boy_data')['image'])?>">
                                             <?php
                                                }
                                                ?>
                                          </div>
                                       </div>

                                        <div class="row form-group">
                                          <label class="col-sm-4">Publication:<span class="mandatory">*</span></label>
                                          <div class="col-sm-4">
                                             <select class="form-control" name="publication">
                                             <option value="1" <?php if($this->session->userdata('delivery_boy_data')['publication']==1){ echo "Selected";}?>>Weekly</option>
                                             <option value="2" <?php if($this->session->userdata('delivery_boy_data')['publication']==2){ echo "Selected";}?>>Monthly</option>
                                             <option value="3" <?php if($this->session->userdata('delivery_boy_data')['publication']==3){ echo "Selected";}?>>3 Monthly</option>
                                             </select>
                                            
                                          </div>
                                       </div>




                                       
                                       <div class="vehicleDetail">
                                          <h5 class="infoTitle"><strong>Vehicle Details:</strong></h5>
                                          <div class="row form-group">
                                             <label class="col-sm-3">Vehicle Number:</label>
                                             <div class="col-sm-9">
											 <input type="text" class="form-control" name="vehicle_number" id="vehicle_number" placeholder="Vehicle Number" value="<?php echo $vehicle_data['vehicle_no'];?>">
											 <span class="error" id="vehicle_number_error"></span>
											 </div>
                                          </div>
                                          <div class="row form-group">
                                             <label class="col-sm-3">Vehicle Type:</label>
                                             <div class="col-sm-9">
											 <input type="text" class="form-control" name="vehicle_type"  id="vehicle_type" placeholder="Vehicle Type" value="<?php echo $vehicle_data['type'];?>">
											 <span class="error" id="vehicle_type_error"></span>
											 </div>
                                          </div>
                                          <div class="row form-group">
                                             <label class="col-sm-3">Vehicle Model:</label>
                                             <div class="col-sm-9">
											 <input type="text" class="form-control" name="vehicle_model" id="vehicle_model" placeholder="Vehicle Model" value="<?php echo $vehicle_data['model'];?>">
											 <span class="error" id="vehicle_model_error"></span>
											 </div>
                                          </div>
                                          <div class="row form-group">
                                             <label class="col-sm-3">Vehicle Color:</label>
                                             <div class="col-sm-9">
											 <input type="text" class="form-control" name="vehicle_color" id="vehicle_color"  placeholder="Vehicle Color" value="<?php echo $vehicle_data['color'];?>">
											 <span class="error" id="vehicle_color_error"></span>
											 </div>
                                          </div>
                                          <div class="row form-group">
                                             <label class="col-sm-3">Vehicle Registration Year:</label>
                                             <div class="col-sm-9">
                                                <select class="form-control" id="vehicle_registration_year" name="vehicle_registration_year">
                                                   <option value="">Select Vehicle Registration Year</option>
                                                   <?php
                                                      for($i=1990;$i<=date('Y');$i++){
                                                      	?>
                                                   <option value="<?php echo $i;?>" <?php if($i==$vehicle_data['registration_year']){ echo "Selected";}?>><?php echo $i;?></option>
                                                   <?php
                                                      }
                                                      ?>
                                                </select>
												<span class="error" id=vehicle_registration_year_error"></span>
                                             </div>
                                          </div>
                                          <div class="row form-group">
                                             <label class="col-sm-3">Vehicle Front Photo</label>
                                             <div class="col-sm-5">
											 <input type="file" class="form-control" name="vehicle_front_photo" id="vehicle_front_photo" >
											 <span class="error" id="vehicle_front_photo_error"></span>
											 </div>
                                             <div class="col-sm-4"> 
											 <?php
                                             if(is_file('attachments/users/thumb/'.$vehicle_data['front_image'])){
                                             ?>
                                             <input type="hidden" name="old_vehicle_front_photo" value="<?php echo $vehicle_data['front_image'];?>">
                                             <img src="<?php echo base_url('attachments/users/thumb/'.$vehicle_data['front_image'])?>">
                                             <?php
                                                }
                                                ?></div>
                                          </div>
                                          <div class="row form-group">
                                             <label class="col-sm-3">Vehicle Back Photo</label>
                                             <div class="col-sm-5">
											 <input type="file" class="form-control" name="vehicle_back_photo" id="vehicle_back_photo" >
											 <span class="error" id="vehicle_back_photo_error"></span>
											 </div>
                                             <div class="col-sm-4">
											 <?php
                                             if(is_file('attachments/users/thumb/'.$vehicle_data['back_image'])){
                                             ?>
                                             <input type="hidden" name="old_vehicle_back_photo" value="<?php echo $vehicle_data['back_image'];?>">
                                             <img src="<?php echo base_url('attachments/users/thumb/'.$vehicle_data['back_image'])?>">
                                             <?php
                                                }
                                                ?>
											 </div>
                                          </div>
                                       </div>
                                       <div class="idDetail">
                                          <h5 class="infoTitle"><strong>Verify Id Details:</strong></h5>
                                          <!--<div class="row form-group">
                                             <label class="col-sm-3">Id Type:</label>
                                             <div class="col-sm-9"><input type="text" class="form-control" name="" placeholder="Sedan" readonly=""></div>
                                             </div>-->
                                          <div class="row form-group">
                                             <label class="col-sm-3">License number:</label>
                                             <div class="col-sm-9">
											 <input type="text" class="form-control" name="license_number" id="license_number" placeholder="License number" value="<?php echo $vehicle_data['registration_year'];?>">
											 <span class="error" id=license_number_error"></span>
											 </div>
                                          </div>
                                          <!--<div class="row form-group">
                                             <label class="col-sm-3">Front License Photo:</label>
                                             <div class="col-sm-5"><input type="file" class="form-control" name="front_license_photo" id="front_license_photo"></div>
                                             <div class="col-sm-4">Front License Photo:</div>
                                             </div>
                                             <div class="row form-group">
                                             <label class="col-sm-3">Back License Photo:</label>
                                             <div class="col-sm-5"><input type="file" class="form-control" name="back_license_photo" id="back_license_photo"></div>
                                             <div class="col-sm-4">Back License Photo:</div>
                                             </div>-->
                                          <div class="row form-group">
                                             <label class="col-sm-3">Insurance Photo:</label>
                                             <div class="col-sm-5">
											 <input type="file" class="form-control" name="insurance_photo" id="insurance_photo">
											 <span class="error" id="insurance_photo_error"></span>
											 </div>
                                             <div class="col-sm-4">
											 <?php
                                             if(is_file('attachments/users/thumb/'.$vehicle_data['insurance_photo'])){
                                             ?>
                                             <input type="hidden" name="old_insurance_photo" value="<?php echo $vehicle_data['insurance_photo'];?>">
                                             <img src="<?php echo base_url('attachments/users/thumb/'.$vehicle_data['insurance_photo'])?>">
                                             <?php
                                                }
                                                ?>
											 </div>
                                          </div>
                                          <!--<div class="docsFile d-flex flex-wrap">
                                             <div class="prImage"><img src="assets/images/logo.png" id="prImage1">
                                             </div>
                                             <div class="prImage"><img src="assets/images/logo.png" id="prImage2">
                                             </div>
                                             <div class="prImage"><img src="assets/images/logo.png" id="prImage3">
                                             </div>
                                             </div>-->
                                       </div>
                                       <div class="row form-group">
                                          <div class="col-sm-12">
                                             <button type="button" class="btn signupBtn" id="update_delivery_boy_profile">Update</button>
											 <input type="hidden"  id="id" name="id" value="<?php echo $vehicle_data['id']?>">
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