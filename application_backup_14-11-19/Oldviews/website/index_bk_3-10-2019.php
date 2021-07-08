
			 <?php
			 $this->load->view('website/includes/header');
			 ?>
			  <div class="homeSlider">
			 <?php
			 if(count($sliders)>0){
 				 ?>
				 <div class="carousel slide" id="homeSlide" data-ride="carousel" data-interval="2000" data-pause="false">
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
								<div class="hs1">
										<div class="selectCrop"><input type="text" class="form-control focusInput" placeholder="Select your Crop" name="" id="change_category">
											<div class="inputDropdown">
												<ul class="dropdown-menu" id="category_section">
													<?php
													foreach($category as $cat){
														?>
													<?php
													if(count($cat['sub_category'])){
													?>
													<li class="nav-item dropdown">
														<a  class="nav-link select_cate" name="<?php echo $cat['name'];?>"><?php echo $cat['name'];?></a>
														<span class="dropIcon"><i class="fa fa-angle-right"></i></span>
														<ul class="dropdown-menu">
															<?php
															foreach($cat['sub_category'] as $sub_category){
																?>
																<li class="nav-item"><a  class="nav-link select_cate" name="<?php echo $sub_category['name'];?>"><?php echo $sub_category['name'];?></a></li>
																<?php
															}
															?>
														</ul>
													</li>
													<?php
													}else{
														?>
														<li class="nav-item"><a   name="<?php echo $cat['name'];?>" class="nav-link select_cate"><?php echo $cat['name'];?></a></li>
														<?php
													}
												
													}
													?>
													 
												</ul>
											</div>
										</div>
										 
									</div>
									<div class="hs5"><span class="btn">or</span></div>
									<div class="hs2">
										<div class="selectCrop"><input type="text" class="form-control focusInput" placeholder="Select Service Category" name="" id="change_service_category">
										<div class="inputDropdown">
												<ul class="dropdown-menu"  id="change_service_category_section">
													<?php
													foreach($service_category as $service_cat){
													?>
													<?php
													if(count($service_cat['sub_category'])){
													?>
													<li class="nav-item dropdown">
														<a  class="nav-link select_service" name="<?php echo $service_cat['name'];?>"><?php echo $service_cat['name'];?></a>
														<span class="dropIcon"><i class="fa fa-angle-right"></i></span>
														<ul class="dropdown-menu">
															<?php
															foreach($service_cat['sub_category'] as $sub_category){
																?>
																<li class="nav-item">
																<a   name="<?php echo $sub_category['name'];?>" class="nav-link select_service"><?php echo $sub_category['name'];?></a>
 																</li>
																<?php
															}
															?>
														</ul>
													</li>
													<?php
													}else{
														?>
														<li class="nav-item"><a  class="nav-link select_service" name="<?php echo $service_cat['name'];?>"><?php echo $service_cat['name'];?></a></li>
														<?php
													}
												}
												?>
												</ul>
											</div>
										</div>
									 
									</div>
									<div class="hs3">
										<div class="selectCrop">
										<div class="input-group">
											<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span></div>
											<input type="search" class="form-control focusInput2" placeholder="Select Location" name="" id="change_location">
											<div class="input-group-append"><button class="btn"><i class="fas fa-crosshairs"></i></button></div>
										</div>
										<div class="inputDropdown">
											<ul class="dropdown-menu" id="change_location_section">
													<?php
													foreach($states as $state){
													?>
													<?php
													if(count($state['cities'])){
													?>
													<li class="nav-item dropdown">
														<a href="#" class="nav-link"><?php echo $state['name'];?></a>
														<span class="dropIcon"><i class="fa fa-angle-right"></i></span>
														<ul class="dropdown-menu">
															<?php
															foreach($state['cities'] as $city){
																?>
																<li class="nav-item"><a href="#" class="nav-link"><?php echo $city['name'];?></a></li>
																<?php
															}
															?>
														</ul>
													</li>
													<?php
													}else{
														?>
														<li class="nav-item"><a href="#" class="nav-link"><?php echo $state['name'];?></a></li>
														<?php
													}
												}
												?>
												</ul>
											</div>
										</div>
									</div>	 
								  
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
									<h6>Choose Agriculture Products</h6>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="msProcessItem">
									<div class="processImg"><img src="<?php echo base_url();?>/assets/frontend/images/how-img2.png"></div>
									<h6>Configure Your Shopping Cart</h6>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="msProcessItem">
									<div class="processImg"><img src="<?php echo base_url();?>/assets/frontend/images/how-img3.png"></div>
									<h6>Pickup or Delivery</h6>
								</div>
							</div>
						</div>
					</div>
					<?php
					if(count($our_services)>0){
						?>
						<div class="msHow text-center">
						<div class="howHead mb-4">
							<h3>Discover what we can do more for you</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eius.</p>
						</div>
						<div class="row">
							<?php
							foreach($our_services as $service){
								?>
								<div class="col-md-4 col-sm-6">
								<div class="howBlock">
									<div class="howIcon">
										<?php if(is_file('attachments/our-services/thumb/'.$service['image'])){ ?>
											<figure>
											<img src="<?php echo base_url('attachments/our-services/thumb/'.$service['image'])?>">
											</figure>
 										<?php } ?>
									</div>
									<div class="howText">
										<h5><?php echo $service['name'];?></h5>
										<p><?php echo $service['description'];?></p>
									</div>
								</div>
							</div>
								<?php
							}
							?>
							 
						</div>
					</div>
						<?php
					}
					?>

					<div class="msClient">
						<div class="d-flex">
							<h5>Top Vendors</h5>
							<div class="msLogoBox">
								<div class="owl-carousel msLogoSlide">
									
								<?php
									foreach($top_vendors as $top_vendor){
										if(is_file('attachments/users/thumb/'.$top_vendor['image'])){
											?>
											<div class="mscLogo">
											<img src="<?php echo base_url('attachments/users/thumb/'.$top_vendor['image'])?>">
 											</div>
											<?php
										}
										?>
										<?php
									}
									?>
								 
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
									<div class="col-md-5"><div class="appImg"><img src="<?php echo base_url();?>/assets/frontend/images/main-post-img-3.png"></div></div>
									<div class="col-md-7">
										<div class="appContent">
											<h4>Mahaseel In Your Mobile! Get Our App</h4>
											<p class="mb-4">Get our app, its the fastest way to order crop on the go.</p>
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
			$('#change_category').keyup(function(){
				var value = $(this).val().toLowerCase();
				$("#category_section li").filter(function() {
					$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			})

			$('#change_service_category').keyup(function(){
				var value = $(this).val().toLowerCase();
				$("#change_service_category_section li").filter(function() {
					$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			})

			$('#change_location').keyup(function(){
				var value = $(this).val().toLowerCase();
				$("#change_location_section li").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			})

			$('.select_cate').click(function(){
				$('#change_category').val('');
				var name=$(this).attr('name');
				if(name!=''){
					$('#change_service_category').attr("disabled", true);
					$('#change_category').val(name);
				}else{
					$('#change_service_category').removeAttr("disabled")
				} 
			});
			$('.select_service').click(function(){
				var name=$(this).attr('name');
				$('#change_service_category').val('');
				if(name!=''){
					$('#change_category').attr("disabled", true);
					$('#change_service_category').val(name);
				}else{
					$('#change_category').removeAttr("disabled");
				}
			});
			$('#change_category').keyup(function(){
				 var cat =$('#change_category').val();
				 if(cat!=''){
					$('#change_service_category').removeAttr("disabled");
					$('#change_category').removeAttr("disabled");
				 }
 			})

			//change_service_category
			//  $("body").on("click", function(){
			// 		$(".selectCrop").removeClass('active');
			//  });

			$("#change_category").focus(function(){
				$(this).parent().addClass('active');
			});
			
			// $("#change_category").blur(function(){
			// 	$(this).parent().removeClass('active');
			// });
			$(".select_cate").click(function(){
				$(".selectCrop").removeClass('active');
			});

			$("#change_service_category").focus(function(){
				$(this).parent().addClass('active');
			});
			// $("#change_service_category").blur(function(){
			// 	$(this).parent().removeClass('active');
			// });
			
			$("#change_location").focus(function(){
				$(this).parent().parent().addClass('active');
			});
			// $("#change_location").blur(function(){
			// 	$(this).parent().parent().removeClass('active');
			// });

			// $('.hsFlex > div').on("mouseover", function () {
			// 	if ($(this).hasClass('active')) {
			// 		$(this).toggleClass('active')
			// 	} else {
			// 		$(this).toggleClass('active')
			// 	}
			// });
			
			// $('.hsFlex > div').on("mouseout", function () {
			// 	if ($(this).hasClass('active')) {
			// 		$(this).toggleClass('active')
			// 	} else {
			// 		$(this).toggleClass('active')
			// 	}
			// });
		});


 

	</script>
