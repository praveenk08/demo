<?php
   $this->load->view('website/includes/header');
    ?>
<!-- Main body wrapper -->
<div class="mainBody">
   <div class="msBreadcrumb">
      <div class="container-fluid">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"><?php echo $btn;?></li>
         </ol>
      </div>
   </div>
   <div class="userWrapper">
      <div class="container-fluid">
         <div class="cwContainer">
            <div class="uwBox d-flex flex-wrap">
               <?php $this->load->view('website/service-provider/left-panel');?>
               <div class="profileRt">
                  <div class="tab-content">
                     <div class="tab-pane active" id="myProfile">
                        <div class="profileRt">
                          <form id="add_update_provider_service_form">
						  <div class="addSrvItem">
						  <div id="success_message" >
                                       <?php if($this->session->flashdata('success_message')){ ?> 
                                       <div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?>
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                       </div>
                                       <?php } ?>
                                    </div>
                              <h5 class="srvHead">Add Service</h5>
                              <div class="addSrvBox">
                                 <div class="row form-group">
                                    <label class="col-sm-4">Service Category:<span class="mandatory">*</span></label>
                                    <div class="col-sm-8">
                                       <select class="form-control" id="service_category" name="service_category">
                                          <option value="">Select Category</option>
                                          <?php
                                             foreach($services as $serv){
                                            ?>
                                          <option value="<?php echo $serv['id']?>" <?php if($serv['id']==$service['service_category_id']){ echo "Selected";}?>><?php echo $serv['name'];?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                       <span id="service_category_error" class="error"></span>
                                    </div>
                                 </div>
                                 <div class="row form-group">
                                    <label class="col-sm-4">Service Name:<span class="mandatory">*</span></label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" placeholder="Service Name" name="service_name" id="service_name" value="<?php echo $service['name'];?>"> 
                                       <span id="service_name_error" class="error"></span>
                                    </div>
                                 </div>
                                 <div class="row form-group">
                                    <label class="col-sm-4">Service Price:<span class="mandatory">*</span></label>
                                    <div class="col-sm-8">
                                       <input type="number" class="form-control" placeholder="Amount" name="service_price" id="service_price"  value="<?php echo $service['price'];?>"> 
                                       <span id="service_price_error" class="error"></span>
                                    </div>
                                 </div>
                                 <div class="row form-group">
                                    <label class="col-sm-4">Service Description:</label>
                                    <div class="col-sm-8">
                                       <textarea class="form-control" placeholder="Description" name="service_description" id="service_description" rows="4"><?php echo $service['description'];?> </textarea>
                                       <span id="service_description_error" class="error"></span>
                                    </div>
                                 </div>
                                 <div class="row form-group">
                                    <label class="col-sm-4">Service Image:</label>
                                    <div class="col-sm-4">
                                       <input type="file" class="form-control" name="service_image" id="service_image">
                                       <span id="service_image_error" class="error"></span> 
                                    </div>
                                    <div class="col-sm-4"><?php
                                       if(is_file('attachments/services/thumb/'.$service['image'])){
                                       ?>
                                       <input type="hidden" name="old_image" value="<?php echo $service['image'];?>">
                                       <img src="<?php echo base_url('attachments/services/thumb/'.$service['image'])?>">
                                       <?php
                                          }
                                          ?>
                                    </div>
                                 </div>
								 <div class="row form-group">
                                    <label class="col-sm-4">Service Status:</label>
                                    <div class="col-sm-8">
										<select name="service_status" id="service_status" class="form-control">
										<option value="1" <?php if($service['status']==1){ echo "Selected";}?>>Active</option>
										<option value="0" <?php if($service['status']==0){ echo "Selected";}?>>In-active</option>
										</select>
                                        <span id="service_description_error" class="error"></span>
                                    </div>
                                 </div>
                                 <div class="row form-group">
                                    <label class="col-sm-4"></label>
                                    <div class="col-sm-8">
                                       <button type="button" class="btn signupBtn" id="add_update_provider_service"><?php echo $btn;?></button>
									   <input type="hidden" name="id" value="<?php echo $service['id'];?>">
									   <a href="<?php echo base_url('service-provider-services');?>"  class="btn signupBtn">Cancel</A>


                                    </div>
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