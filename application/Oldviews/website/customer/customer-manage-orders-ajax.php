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
																<h5><strong><?php echo $order['name'];?></strong></h5>
																<div class="weight"><?php echo $order['quantity'];?> <?php echo $order['unit_name'];?></div>
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
                                                    <span  class="btn btn1">Order Details</span>
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