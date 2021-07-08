
			 <?php
			 $this->load->view('website/includes/header');
			 ?>
			  <div class="homeSlider">
			 <?php
			 if(count($sliders)>0){
 				 ?>
				 <div class="carousel slide" id="homeSlide" data-ride="carousel">
					<div class="carousel-inner">
						<?php
						$sr=1;
						foreach($sliders as $slider){
   							 if(is_file('./attachments/sliders/main/'.$slider['image'])){
								$image=base_url('attachments/sliders/main/'.$slider['image']);	
								?>
								<div class="carousel-item <?php if($sr==1){echo " active";}?>" >
							<div class="hsImg">
								<img src="<?php echo $image;?>">
							</div>
						</div>
								<?php
								$sr++;
						    }
 							?>
							
							<?php
							
						}
						
						?>
						 	
					</div>
					<ul class="carousel-indicators">
					<?php
 						for($i=0;$i<$sr-1;$i++){
						?>
						<li data-target="#homeSlide" data-slide-to="<?php echo $i;?>" <?php if($i==0){ ?> class="active" <?php } ?>></li>
 						<?php
						}
						?>
					</ul>
				</div>
				 <?php
			 }
			 ?>
			
				

				
				<div class="hsContainer">
					<div class="container-fluid">
						<div class="hsContent">
							<h3>Come to the Online <strong>Agriculture Market</strong></h3>
							<h5>Find Delivery market near by you</h5>
						</div>
						<div class="hsSearch">
							<form method="POST" action="<?php echo base_url('growers');?>">
								<div class="hsFlex">
									<div class="hs1" id="change_category_section">
									<?php
									$categories=categoryList(array('c.parent_id'=>0,'c.status'=>1));
									?>
										<select class="form-control" name="category_id" id="change_category">
											<option value="0">Select your crop</option>
											<?php
											foreach($categories as $category){
												?>
												<option value="<?php echo $category['id'];?>"><?php echo $category['name'];?></option>
												<?php
											}
											?>
										</select>
									</div>
									<div class="hs5"><span class="btn">or</span></div>
									<div class="hs2" id="change_provider_section">
										<select class="form-control" id="change_provider" name="change_provider">
											<option>Select Service Provider</option>
											<?php
											$service_providers=getUserList(array('u.is_deleted'=>0,'role_id'=>4));
											foreach($service_providers as $service_provider){
												?>
												<option value="<?php echo $service_provider['id'];?>"><?php echo $service_provider['name'];?></option>
												<?php
											}
											?>
  										</select>
									</div>
									
									<div class="hs3">
										<div class="input-group">
											<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span></div>
											<input type="search" class="form-control" placeholder="Location" name="" id="address">
											<input type="hidden" id="latitude" name="latitude">
											<input type="hidden" id="longitude" name="longitude">
 											<div class="input-group-append"><button class="btn"><i class="fas fa-crosshairs"></i></button></div>
										</div>
									</div>
									<div class="hs4" style="display:none;">
										 <input type="text" class="form-control" name="growers" placeholder="growers" style="display:none;">
									</div>
									<!-- <div class="searchCheck custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" name="" id="searchCheck">
										<label class="custom-control-label" for="searchCheck">Search Deliveries Only</label>
									</div> -->
									<div class="searchSubmit"><button  type="submit" class="btn searchBtn">Search</button></div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="msPolicy">
					<div class="container-fluid">
						<div class="msPolicyBox">
							<ul class="d-flex flex-wrap justify-content-center">
								<li class="d-flex align-items-baseline">
									<div class="mspIcon"><img src="<?php echo base_url();?>/assets/frontend/images/ico_count_1.png"></div>
									<div class="mspText">
										<strong>19500</strong>
										<p>Tons of harvest</p>
									</div>
								</li>
								<li class="d-flex align-items-baseline">
								<div class="mspIcon"><img src="<?php echo base_url();?>/assets/frontend/images/ico_count_3.png"></div>
									<div class="mspText">
										<strong>2720</strong>
										<p>Number of farms</p>
									</div>
								</li>
								<li class="d-flex align-items-baseline">
									<div class="mspIcon"><img src="<?php echo base_url();?>/assets/frontend/images/ico_count_3.png"></div>
									<div class="mspText">
										<strong>10000</strong>
										<p>Feddan of farm</p>
									</div>
								</li>
								<li class="d-flex align-items-baseline">
									<div class="mspIcon"><img src="<?php echo base_url();?>/assets/frontend/images/ico_count_4.png"></div>
									<div class="mspText">
										<strong>128</strong>
										<p>Units of technic</p>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>


 			

			<div class="msProWrapper">
				<div class="container-fluid">
					<div class="msProcess">
						<div class="howHead mb-4">
							<h3>How it works?</h3>
						</div>
						<div class="row">
							<div class="col-sm-4">
								<div class="msProcessItem">
									<div class="processImg"><img src="<?php echo base_url();?>/assets/frontend/images/how-img1.png"></div>
									<h6>Choose a Agriculture Products</h6>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="msProcessItem">
									<div class="processImg"><img src="<?php echo base_url();?>/assets/frontend/images/how-img2.png"></div>
									<h6>Choose a Agriculture Products</h6>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="msProcessItem">
									<div class="processImg"><img src="<?php echo base_url();?>/assets/frontend/images/how-img3.png"></div>
									<h6>Choose a Agriculture Products</h6>
								</div>
							</div>
						</div>
					</div>
					<div class="msHow text-center">
						<div class="howHead mb-4">
							<h3>Discover what we can do more for you</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eius.</p>
						</div>
						<div class="row">
							<div class="col-md-4 col-sm-6">
								<div class="howBlock">
									<div class="howIcon">
										<figure>
											<img src="<?php echo base_url();?>/assets/frontend/images/how1.png">
										</figure>
									</div>
									<div class="howText">
										<h5>Deals & Promotions</h5>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
										tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim ve.</p>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6">
								<div class="howBlock">
									<div class="howIcon">
										<figure>
											<img src="<?php echo base_url();?>/assets/frontend/images/how2.png">
										</figure>
									</div>
									<div class="howText">
										<h5>Secure Payments</h5>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
										tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim ve.</p>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6">
								<div class="howBlock">
									<div class="howIcon">
										<figure>
											<img src="<?php echo base_url();?>/assets/frontend/images/how3.png">
										</figure>
									</div>
									<div class="howText">
										<h5>24x7 Customer Service</h5>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
										tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim ve.</p>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6">
								<div class="howBlock">
									<div class="howIcon">
										<figure>
											<img src="<?php echo base_url();?>/assets/frontend/images/how4.png">
										</figure>
									</div>
									<div class="howText">
										<h5>Estimated Shipping</h5>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
										tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim ve.</p>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6">
								<div class="howBlock">
									<div class="howIcon">
										<figure>
											<img src="<?php echo base_url();?>/assets/frontend/images/how5.png">
										</figure>
									</div>
									<div class="howText">
										<h5>Track Your Packages</h5>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
										tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim ve.</p>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6">
								<div class="howBlock">
									<div class="howIcon">
										<figure>
											<img src="<?php echo base_url();?>/assets/frontend/images/how6.png">
										</figure>
									</div>
									<div class="howText">
										<h5>Trusted Data</h5>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
										tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim ve.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="msClient">
						<div class="d-flex">
							<h5>Top Vendors</h5>
							<div class="msLogoBox">
								<div class="owl-carousel msLogoSlide">
									<div class="mscLogo"><img src="<?php echo base_url();?>/assets/frontend/images/client1.png"></div>
									<div class="mscLogo"><img src="<?php echo base_url();?>/assets/frontend/images/client2.png"></div>
									<div class="mscLogo"><img src="<?php echo base_url();?>/assets/frontend/images/client3.png"></div>
									<div class="mscLogo"><img src="<?php echo base_url();?>/assets/frontend/images/client4.png"></div>
									<div class="mscLogo"><img src="<?php echo base_url();?>/assets/frontend/images/client5.png"></div>
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>



			<div class="appSection">
				<div class="container-fluid">
					<div class="appFlex">
						<div class="row">
							<div class="col-lg-8 offset-lg-2">
								<div class="row">
									<div class="col-md-3"><div class="appImg"><img src="<?php echo base_url();?>/assets/frontend/images/main-post-img-1.png"></div></div>
									<div class="col-md-9">
										<div class="appContent">
											<h4>FoodBakery In Your Mobile! Get Our App</h4>
											<p class="mb-4">Get our app, it's the fastest way to order food on the go.</p>
											<div class="d-flex mb-4">
												<a href="" class="mr-2"><img src="<?php echo base_url();?>/assets/frontend/images/app-img1-1.png"></a>
												<a href=""><img src="<?php echo base_url();?>/assets/frontend/images/app-img2-1.png"></a>
											</div>
											<div class="sendLinkBox">
												<form>
													<div class="input-group">
														<input type="email" class="form-control" name="" placeholder="Your Email">
														<div class="input-group-append"><input type="submit" class="btn" value="Send Link"></div>
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
			 <script>
			 $(function(){
				 $('#change_category').change(function(){
					var category_id=this.value;
					if(category_id>0){
						$('#change_provider').attr('disabled', true);
  					}else{
 						 $('#change_provider').removeAttr('disabled');
 					}
				 }) 
				 $('#change_provider').change(function(){
					var category_id=this.value;
					if(category_id>0){
						$('#change_category').attr('disabled', true);
					}else{
						$('#change_category').removeAttr('disabled');
					}
				 });
				 
			 })
			 </script>
 