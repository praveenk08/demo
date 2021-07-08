
			 <?php
			 $this->load->view('website/includes/header');
			 if($this->session->userdata('language')=='en'){
				$home_label="Home";
				$orders_label="Orders";
			 }else{
				$home_label="الصفحة الرئيسية";
				$orders_label="أوامر";
			 }
			 ?>
			<!-- Main body wrapper -->
			<div class="mainBody">
				<div class="msBreadcrumb">
					<div class="container-fluid">
						<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>"><?php echo $home_label;?></a></li>
							<li class="breadcrumb-item active"><?php echo $orders_label;?></li>
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
									<div class="gwrHead"><h5 class="dashTitle">Sales Order</h5></div>
									<div class="loading"></div>
									<div id="order-list-section">
									<div class="loading text-center" id="srvLoader" style="display:none;"></div>
									<ul>
                                        <?php
                                        foreach($orders as $order){
                                            ?>
                                            <li>
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
															<div class="orderID">Order ID: MH-<?php echo $order['order_id'];//getOderId();?></div>
															<h5><strong><a href="<?php echo base_url('product-details/'.$order['slug'])?>"><?php echo $order['name'];?></a></strong></h5>																<div class="weight"><?php echo $order['quantity'];?> <?php echo $order['unit_name'];?></div>
																<div class="ordDetail">
																	<span><?php echo $order['order_address'];?> 
																	<?php echo $order['order_block'];?> 
																	<?php echo $order['order_zip'];?> -
																	</span><br/>
																	<span><?php echo $order['order_date'];?></span>
																</div>
															</div>
														</div>
													</div>
													<div class="gwrItemAction">
                                                    <span  class="btn btn1"><?php echo $order['order_status'];?></span>
  													</div>
												</div>
											</li>
											 
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
 

 