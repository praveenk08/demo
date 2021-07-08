
			 <?php
			 $this->load->view('website/includes/header');
			 ?>
			<!-- Main body wrapper -->
			<div class="mainBody">
   <div class="msBreadcrumb">
      <div class="container-fluid">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Assigned Orders</li>
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
                        <div   id="serviceList">
                           <div class="srvHead d-flex flex-wrap align-items-center">
                              <h5>Assigned Orders</h5>
                           </div>
                           <div id="success_message" >
                              <?php if($this->session->flashdata('success_message')){ ?> 
                              <div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?>
                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                              </div>
                              <?php } ?>
                           </div>
                           <!--<div class="row form-group">
                              <div class="col-sm-4">
                               <select id="change_service_category" class="form-control change">
                              	 <option value="">Select category</option>
                              		<?php
                                 //	foreach($service_category as $serv){
                                 	?>
                              		<option value="<?php ///echo $serv['id']?>"><?php //echo $serv['name'];?></option>
                              		<?php
                                 //}
                                 ?>
                               </select>
                              	</div>
                              	<div class="col-sm-4">
                               <select id="change_status" class="form-control change">
                               <option value="">Select Status</option>
                               <option value="1">Active</option>
                               <option value="0">In-active</option>
                               </select>
                              	</div>
                              	<div class="col-sm-4">
                              		<input type="text" name="change_search" id="change_search" class="form-control change" placeholder="Search name">
                              
                              	</div>
                              	</div>-->
                           <div class="srvListTable table-responsive" id="service_list_section">
                              <div class="loading text-center" id="srvLoader" style="display:none;"></div>
                              <table class="table table-bordered">
                                 <thead class="text-uppercase">
                                    <tr>
                                       <th></th>
                                       <th>Orde Id</th>
                                       <th>Transition ID</th>
                                       <th>Customer</th>
                                       <th>Total Product</th>
                                       <th>Total Price</th>
                                       <th>Status</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                       $sr=1;
                                       foreach($orders as $order){
                                       	?>
                                    <tr>
                                       <input type="hidden" id="show_hide_status<?php echo $order['order_id']?>" value="0">	 
                                       <td>
                                          <a href="javascript:void(0)" class="show_hide_btn" onclick="showHideData('<?php echo $order['order_id']?>')" id="show_hide_btn<?php echo $order['order_id'];?>"><img src="<?php echo base_url('assets/frontend/images/details_open.png')?>">
                                          </a>
                                       </td>
                                       <td><?php echo $order['order_id'];?></td>
                                       <td><?php echo $order['transaction_id'];?></td>
                                       <td><?php echo $order['customer_name'];?></td>
                                       <td style="text-align:right;"><?php echo $order['total_product'];?></td>
                                       <td style="text-align:right;">$<?php echo $order['total_amount'];?></td>
                                       <td>
                                          <select id="change_order_status" class="form-control" onClick="changeOrderStatus('<?php echo $order['order_id'];?>')">
                                             <?php
                                                if($order['order_status']==3){
                                                	?>
                                             <option value="3" selected="selected" >Assign to delivery boy</option>
                                             <option value="4">Ready to ship</option>
                                             <?php
                                                }else if($order['order_status']==4){
                                                	?>
                                             <option value="4" selected="selected">Ready to ship</option>
                                             <option value="5">Completed</option>
                                             <?php
                                                }
                                                ?>
                                          </select>
                                       </td>
                                    </tr>
                                    <tr id="discription<?php echo $order['order_id'];?>" style="display:none;" class="description">
                                       <td colspan="7">
                                          <table class="table table-bordered">
                                             <thead>
                                                <tr>
                                                   <th>S.No.</th>
                                                   <th>Image</th>
                                                   <th>Name</th>
                                                   <th>Vendor</th>
                                                   <th class="center">Quantity</th>
                                                   <th class="center">Price</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php
                                                   if(count($order['products'])>0){
                                                       $sr=1;
                                                       $total_price=0;
                                                       $total_quantity=0;
                                                       foreach($order['products'] as $product){
                                                           ?>
                                                <tr>
                                                   <td><?php echo $sr;?></td>
                                                   <td><?php if(is_file('./attachments/products/thumb/'.$product['image'])){  ?>
                                                      <img style="height:50px;width:50px;" src="<?php echo base_url('attachments/products/thumb/'.$product['image']);?>"><?php } ?>
                                                   </td>
                                                   <td><?php  echo $product['name'];?></td>
                                                   <td><?php echo $product['vendor_name'];?></td>
                                                   <td  class="center"><?php echo $product['quantity'];?></td>
                                                   <td  class="center">$<?php echo $product['price'];?></td>
                                                </tr>
                                                <?php
                                                   $total_price +=$product['price'];
                                                   $total_quantity +=$product['quantity'];
                                                   $sr++;
                                                   }
                                                   ?>
                                             </tbody>
                                             <tr>
                                                <td><b>Total:</b></td>
                                                <td colspan="3"></td>
                                                <td class="center"><?php echo $total_quantity;?></td>
                                                <td class="center">$<?php echo number_format($total_price,2);?></td>
                                             </tr>
                                             <?php
                                                }else{
                                                    ?>
                                             <tr>
                                                <td colspan="6">No Record Found</td>
                                             </tr>
                                             <?php
                                                }
                                                ?>
                                          </table>
                                          <table class="table table-bordered">
                                             <tr>
                                                <td><b>Name</b></td>
                                                <td><?php echo $order['address']['name'];?></td>
                                                <td><b>Email</b></td>
                                                <td><?php echo $order['address']['email'];?></td>
                                                <td><b>Phone</b></td>
                                                <td><?php echo $order['address']['phone'];?></td>
                                             </tr>
                                             <tr>
                                                <td><b>Address Type</b></td>
                                                <td><?php echo $order['address']['address_type'];?></td>
                                             </tr>
                                             <tr>
                                                <td><b>Country</b></td>
                                                <td><?php echo $order['address']['country_name'];?></td>
                                                <td><b>State</b></td>
                                                <td><?php echo $order['address']['state_name'];?></td>
                                                <td><b>City</b></td>
                                                <td><?php echo $order['address']['city_name'];?></td>
                                             </tr>
                                             <tr>
                                                <td><b>Address</b></td>
                                                <td><?php echo $order['address']['address'];?></td>
                                                <td><b>Block</b></td>
                                                <td><?php echo $order['address']['block'];?></td>
                                                <td><b>Landmark</b></td>
                                                <td><?php echo $order['address']['landmark'];?></td>
                                             </tr>
                                             <tr>
                                                <td><b>Zip Code</b></td>
                                                <td><?php echo $order['address']['zip'];?></td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                    <?php
                                       $sr++;
                                       }
                                       ?>
                                 </tbody>
                              </table>
                              <div class="msPagination mt-3" id="pagination-section">
                                 <?php //echo $this->ajax_pagination->create_links(); ?>
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
		function changeOrderStatus(id){
		//	alert(id);
		}
		function searchFilter(page_num) {
			page_num = page_num?page_num:0;
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>Customer/customerOrderstAjax/'+page_num,
				data:{
				'page':page_num,
				},
				beforeSend: function () {
 					$('#srvLoader').html(loader);
					$('#srvLoader').show();
				},
				success: function (html) {
 					$('#order-list-section').html(html);
					$('#srvLoader').hide();
				}
			});
		}
	</script>
 

 