<?php
 if($this->session->userdata('language')=='en'){
	$new_label="New";
	$no_record_found_label="No Record Found";
	}else{		
	$new_label="الجديد";	
	$no_record_found_label="لا يوجد سجلات";
	 }
?>
<div class="prdList">
   <ul class="d-flex flex-wrap">
   <?php
										if(count($services)>0){
 											
										foreach($services as $service){
											?>
											<li>
												<div class="msProItem">
													<div class="msProImg">
														<div class="msfTag">
															<div class="msfLabel new"><?=$new_label;?></div>
															<!--<div class="msfLabel discount">-5%</div>-->
 														</div>
														<a href="<?php echo base_url('service-details/'.$service['slug']);?>">
 														<?php if(is_file('attachments/services/medium/'.$service['image'])){ ?>
               											<img  src="<?php echo base_url('attachments/services/medium/'.$service['image'])?>" >
 			 
																<?php
															}else{
																?>
															<img src="<?php echo base_url();?>/assets/frontend/images/prd1.jpg">
																<?php
															}
															?>
															</a>
													</div>
													<div class="msProText">
														<div class="prName"><a href="<?php echo base_url('service-details/'.$service['slug']);?>"><strong><?php echo $service['name'];?></strong></a></div>
														<!--<div class="starDisplay">
															<span><i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="fas fa-star-half-alt"></i>
															<i class="far fa-star"></i>
															<i class="far fa-star"></i>
															</span>
														</div>-->
														<div class="d-flex align-items-center">
															<div class="msfPrice"><!--<del>$60.00</del>--> <span>$<?php echo $service['price'];?></span></div>
															<!--<button class="btn addCartBtn" id="addToCart"><span id="added">Add to Cart</span></button>-->
														</div>
													</div>
												</div>
											</li>
											<?php
										}
									}else{
										?>
											<li><?=$no_record_found_label;?></li>
										<?php
									}
										?>
   </ul>
</div>
<div class="msPagination mt-3" id="pagination-section">
   <?php echo $this->ajax_pagination->create_links(); ?>
</div>