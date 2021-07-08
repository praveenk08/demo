
			 <?php
			 $this->load->view('website/includes/header');
			 ?>
			<!-- Main body wrapper -->
			<div class="mainBody">
   <div class="msBreadcrumb">
      <div class="container-fluid">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Orders</li>
         </ol>
      </div>
   </div>
   <div class="userWrapper">
      <div class="container-fluid">
         <div class="cwContainer">
            <div class="uwBox d-flex flex-wrap">
               <?php $this->load->view('website/customer/left-panel');?>
               <div class="profileRt">
                  <div class="gwrSalesOrder">
                     <div class="gwrHead">
                        <h5 class="dashTitle">Sales Order</h5>
                     </div>
                     <div class="loading"></div>
                     <div id="order-list-section">
                        <div class="loading text-center" id="srvLoader" style="display:none;"></div>
                        <ul>
                           <?php
							$old_order_id='';
							 $serial_no=1;
							if(count($orders)>0){
                            foreach($orders as $order){
							$new_order_id=$order['order_id'];
                            if($old_order_id!=$new_order_id){
								if($serial_no!=1){
									?>
									
									
								</div>
						   </li>
									<?php
								}
							?>
							
						   
                           <li class="card mb-3 shadow">
                              <div class="card-body">
                                 <?php
                                    }
									?>
									<div class="row">
										<div class="col-md-9">
											<div class="ordDetail">
												<span><?php echo $order['order_address'];?> 
												<?php echo $order['order_block'];?> 
												<?php echo $order['order_zip'];?> -
												</span>
												<div><strong>Order Datetime: </strong><span><?php echo $order['order_date'];?></span></div>
											</div>
										</div>
										<div class="col-md-3">
											<div><strong>Total Amount: </strong><span>$<?php echo $order['total_amount'];?></span></div>
											<div class="gwrItemAction">
											<span  class="btn btn1"><?php echo $order['order_status'];?></span>
											</div>
										</div>
									</div>
                                 <div class="gwrSaleItem d-flex flex-wrap">
                                    <div class="gwrItemInfo">
                                       <div class="d-flex">
                                          <div class="gwrSaleImg">
                                             <?php
                                                if(is_file('./attachments/products/thumb/'.$order['image'])){
                                                ?>
                                             <img src="<?php echo base_url('attachments/products/thumb/'.$order['image'])?>">
                                             <?php
                                                }else{
                                                
                                                	?>
                                             <img src="<?php echo base_url();?>/assets/frontend/images/prd1.jpg">
                                             <?php
                                                }
                                                ?>
                                          </div>
                                          <div class="gwrSaleText">
                                             <div class="orderID">
											 <h5><strong>Order ID: <?php   echo $order['order_id'];?></strong></h5>
                                             </div>
                                             <h5><strong><?php echo $order['name'];?></strong></h5>
                                             <div class="weight"><strong>Quantity: </strong><?php echo $order['quantity'];?> <?php echo $order['unit_name'];?></div>
                                             <div class="weight"><strong>Price: </strong> $<?php echo $order['price']*$order['quantity'];?></div>
                                          </div>
                                       </div>
                                    </div>
                                    
                                 </div>
                                 
                           <?php
							 
							  $old_order_id=$new_order_id;
							  $serial_no++;
							  }
							}else{
								?>
								<li>No Orders Found!</li>
								<?php
							} 
                           ?>
                        </ul>
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
		
<?php
$this->load->view('website/includes/footer');
?>


<script>
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
 

 