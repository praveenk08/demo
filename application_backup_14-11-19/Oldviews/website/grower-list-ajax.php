<div class="loading text-center" id="srvLoader" style="display:none;"></div>	
										<div class="prdList gwrList fullList">
											<ul class="d-flex flex-wrap">
												<?php
												 foreach($growers as $grower){
													?>
													<li>
												   <div class="msProItem">
												   
													   <div class="msProImg">
													   <?php
														   if(is_file('attachments/users/main/'.$grower['image'])){
														   ?>
														   <img src="<?php echo base_url('attachments/users/main/'.$grower['image'])?>">
														   <?php
														   }else{
																?>
															<img src="<?php echo base_url();?>/assets/frontend/images/prd1.jpg">
																<?php
															}
														   ?>
														</div>

													   <div class="msProText">
														<div class="prName"><strong><?php echo $grower['first_name'].' '.$grower['last_name'];?></strong></div>
														   <div class="starDisplay">
															   <span><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i></span>
														   </div>
														   <div class="gwrLocation mb-2">
															   <i class="fas fa-map-marker-alt"></i>
															   <span>Grower location, <?php echo $grower['address'];?> <?php echo $grower['zip'];?></span>
															</div>
														   <p><?php echo $grower['firm_description'];?></p>
														   <a href="<?php echo base_url('products/'.$grower['slug']);?>" class="btn viewBtn">View Products</a>
													   </div>
												   </div>
											   </li>
													<?php
												 }
												 ?>
												
											</ul>
										</div>
 
										<div class="msPagination mt-3" id="pagination-section">
										<?php echo $this->ajax_pagination->create_links(); ?>
										</div>