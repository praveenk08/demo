<?php
   $this->load->view('website/includes/header');
   ?>
<!-- Main body wrapper -->
<div class="mainBody">
   <div class="msBreadcrumb">
      <div class="container-fluid">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Address List</li>
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
                        <div   id="serviceList">
                           <div class="srvHead d-flex flex-wrap align-items-center">
                              <h5>Address List</h5>
                              <a href="<?php echo base_url('customer-add-address')?>" class="btn signupBtn">Add address</a>
                           </div>
                           <div id="success_message" >
                              <?php if($this->session->flashdata('success_message')){ ?> 
                              <div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?>
                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                              </div>
                              <?php } ?>
                           </div>
                           <?php
                              $countries=getCountryList();
                              ?>
                           <div class="row form-group">
                              <div class="col-sm-3">
                                 <select class="form-control" id="change_country">
                                    <option value="">Select Country</option>
                                    <?php if(count($countries)>0){
                                       foreach($countries as $country){
                                         ?>
                                    <option value="<?php echo $country['id']?>"><?php echo $country['name'];?></option>
                                    <?php
                                       }
                                       }
                                       ?>
                                 </select>
                              </div>
                              <div class="col-md-3">
                                 <select class="form-control" id="change_state">
                                    <option value="">Select State</option>
                                 </select>
                              </div>
                              <div class="col-md-3">
                                 <select class="form-control" id="change_city">
                                    <option value="">Select City</option>
                                 </select>
                              </div>
                              <div class="col-sm-3">
                                 <select id="change_status" class="form-control change">
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">In-active</option>
                                 </select>
                              </div>
                              </div>
                              <div class="row"> 
                            
                              <div class="col-sm-6">
                                 <input type="text" name="change_search" id="change_search" class="form-control change" placeholder="Search name/email/phone/address/zip">
                              </div>
                           </div>
                            <br>
                           <div class="srvListTable" id="address_list_section">
                              <div class="loading text-center" id="srvLoader" style="display:none;"></div>
                              <?php
                                 foreach($addresses as $address){
                                     ?>
                              <div class="addressBox">
                                 <span><?php echo $address['address_type'];?></span>
                                 <h5><?php echo $address['name']?> <span><?php echo $address['phone'];?></span><span><?php echo $address['email'];?></span></h5>
                                 <?php $show_address= $address['address'].' '.$address['street'].' '.$address['block'].' '.$address['landmark'].' '.$address['country_name'].' '.$address['state_name'].' '.$address['city_name'].' '.$address['zip'];?>
                                 <?php if(!empty($show_address)){
                                    ?>
                                 <p><?php echo $show_address;?></p>
                                 <?php
                                    }?>
                                 <div class="manageAction">
                                    <a href="javascript:void(0);" ><i class="fas fa-ellipsis-v"></i></a>
                                    <div class="dropAction">
                                       <a href="<?php echo base_url('customer-update-address/'.$address['id']);?>" >Edit</a>
                                       <a  href="javascript:void(0)" onClick="DeleteRecord('<?php echo $address['id'];?>')" >Delete</a>
                                    </div>
                                 </div>
                              </div>
                              <?php
                                 }
                                 ?>
                              <div class="msPagination mt-3" id="pagination-section">
                                 <?php echo $this->ajax_pagination->create_links(); ?>
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
   $('#deleteRecord').click(function(){
   	deleteActionPerform('<?php echo base_url('customer-delete-address')?>');
   })
  
   $('#change_search').keyup(function(){
   	searchFilter(0);
   })
   $('#change_country,#change_state,#change_city,#change_status').change(function(){
      searchFilter(0);
    });
   	function searchFilter(page_num) {
   		page_num = page_num?page_num:0;
   		$.ajax({
   			type: 'POST',
   			url: '<?php echo base_url(); ?>Customer/manageAddressesAjax/'+page_num,
   			data:{
   				'page':page_num,
   				'change_country':$('#change_country').val(),
   				'change_state':$('#change_state').val(),
   				'change_city':$('#change_city').val(),
   				'change_status':$('#change_status').val(),
   				'change_search':$('#change_search').val(),
   			},
   			beforeSend: function () {
   				$('#srvLoader').html(loader);
   				$('#srvLoader').show();
   			},
   			success: function (html) {
   				  $('#address_list_section').html(html);
   				  $('#srvLoader').hide();
   			}
   		});
   	}
</script>