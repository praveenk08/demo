<div class="loading text-center" id="srvLoader" style="display:none;"></div>
<ul>
                           <?php
							$old_order_id='';
 							$serial_no=1;
                            foreach($orders as $order){
							$new_order_id=$order['order_id'];
                            if($old_order_id!=$new_order_id){
								if($serial_no!=1){
									?>
									<div class="row">
									
									<div class="col-md-9">
									 <div class="ordDetail">
                                    <span><?php echo $order['order_address'];?> 
                                    <?php echo $order['order_block'];?> 
                                    <?php echo $order['order_zip'];?> -
									</span>
									<div><strong>Order Datetime</strong><span><?php echo $order['order_date'];?></span></div>
									<div><strong>Order Amount: </strong><span>$<?php echo $order['total_amount'];?></span></div>
                                    
								 </div>

								</div>

								 <div class="col-md-3">
								  <div class="gwrItemAction">
                                       <span  class="btn btn1"><?php echo $order['order_status'];?></span>
								 </div></div>
								 </div>
									
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
                           ?>
                        </ul>

										<div class="msPagination mt-3" id="pagination-section">
										<?php echo $this->ajax_pagination->create_links(); ?>
										</div>