
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
							<form method="POST" action="" id="home_page_search_form">
								<div class="hsFlex">
								<div class="hs1">
										<div class="selectCrop"><input type="text" class="form-control focusInput" autocomplete="off" placeholder="Select your Crop" name="" id="change_category">
											<div class="inputDropdown">
												<ul class="dropdown-menu" id="category_section">
												<li class="nav-item dropdown"><a  class="nav-link select_cate" is_parent="1" id="0" name="">Select your Crop</a></li>
													<?php
													foreach($category as $cat){
														?>
													<?php
													if(count($cat['sub_category'])){
													?>
													<li class="nav-item dropdown">
														<a  class="nav-link select_cate" name="<?php echo $cat['name'];?>" id="<?php echo $cat['id'];?>"  slug="<?php echo $cat['slug'];?>" is_parent="1" ><?php echo $cat['name'];?></a>
														<span class="dropIcon"><i class="fa fa-angle-right"></i></span>
														<ul class="dropdown-menu">
															<?php
															foreach($cat['sub_category'] as $sub_category){
																?>
																<li class="nav-item"><a  class="nav-link select_cate" name="<?php echo $sub_category['name'];?>" id="<?php echo $sub_category['id'];?>" slug="<?php echo $sub_category['slug'];?>" is_parent="0"  ><?php echo $sub_category['name'];?></a></li>
																<?php
															}
															?>
														</ul>
													</li>
													<?php
													}else{
														?>
														<li class="nav-item"><a  class="nav-link select_cate" name="<?php echo $cat['name'];?>" id="<?php echo $cat['id'];?>" slug="<?php echo $cat['slug'];?>"  is_parent="1" ><?php echo $cat['name'];?></a></li>
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
										<div class="selectCrop"><input type="text" class="form-control focusInput" autocomplete="off"  placeholder="Select Service Category" name="" id="change_service_category">
										<div class="inputDropdown">
												<ul class="dropdown-menu"  id="change_service_category_section">
												<li class="nav-item dropdown"><a  class="nav-link select_service" name="" parent_slug="" slug=""  id="0" is_parent="1" >Select Service Category</a></li>
													<?php
													foreach($service_category as $service_cat){
													?>
													<?php
													if(count($service_cat['sub_category'])){
													?>
													<li class="nav-item dropdown">
														<a  class="nav-link select_service" name="<?php echo $service_cat['name'];?>"  parent_slug="" slug="<?php echo $service_cat['slug'];?>" id="<?php echo $service_cat['id'];?>"  is_parent="1" ><?php echo $service_cat['name'];?></a>
														<span class="dropIcon"><i class="fa fa-angle-right"></i></span>
														<ul class="dropdown-menu">
															<?php
															foreach($service_cat['sub_category'] as $sub_category){
																?>
																<li class="nav-item">
																<a    class="nav-link select_service" name="<?php echo $sub_category['name'];?>" parent_slug="<?php echo $service_cat['slug'];?>" slug="<?php echo $sub_category['slug'];?>"   id="<?php echo $sub_category['id'];?>" is_parent="0"><?php echo $sub_category['name'];?></a>
 																</li>
																<?php
															}
															?>
														</ul>
													</li>
													<?php
													}else{
														?>
														<li class="nav-item"><a  class="nav-link select_service" name="<?php echo $service_cat['name'];?>" parent_slug="" slug="<?php echo $service_cat['slug'];?>" id="<?php echo $service_cat['id'];?>"  is_parent="1"   ><?php echo $service_cat['name'];?></a></li>
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
											<div class="locIcon"><i class="fas fa-map-marker-alt"></i></div>
											<input type="search" class="form-control focusInput" autocomplete="off"  placeholder="Select Location" name="" id="change_location">
										<!-- <div class="input-group">
											<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span></div>
											<input type="search" class="form-control focusInput2" autocomplete="off"  placeholder="Select Location" name="" id="change_location">
											<div class="input-group-append"><button class="btn"><i class="fas fa-crosshairs"></i></button></div>
										</div> -->
										<div class="inputDropdown">
											<ul class="dropdown-menu" id="change_location_section">
													<?php
													foreach($states as $state){
													?>
													<?php
													if(count($state['cities'])){
													?>
													<li class="nav-item dropdown">
														<a  class="nav-link change_location" name="<?php echo $state['name'];?>" is_parent="1" id="<?php echo $state['id'];?>"><?php echo $state['name'];?></a>
														<span class="dropIcon"><i class="fa fa-angle-right"></i></span>
														<ul class="dropdown-menu">
															<?php
															foreach($state['cities'] as $city){
																?>
																<li class="nav-item"><a  is_parent="0" class="nav-link change_location" id="<?php echo $city['id'];?>" name="<?php echo $city['name'];?>"><?php echo $city['name'];?></a></li>
																<?php
															}
															?>
														</ul>
													</li>
													<?php
													}else{
														?>
														<li class="nav-item"><a  is_parent="1" class="nav-link change_location" id="<?php echo $state['id'];?>" name="<?php echo $state['name'];?>"><?php echo $state['name'];?></a></li>
														<?php
													}
												}
												?>
												</ul>
											</div>
										</div>
									</div>	 
									<div class="searchSubmit"><button  type="submit" class="btn searchBtn" id="search_button" disabled>Search</button></div>
								</div>
								<input type="hidden" placeholder="search_type" name="search_type" id="search_type">
								<input type="hidden" placeholder="search_type_id" name="search_type_id" id="search_type_id">
								<input type="hidden" placeholder="search_id" name="search_id" id="search_id">
								<input type="hidden" name="location_id" id="location_id">
								<input type="hidden" name="location_type" id="location_type">
							</form>
						</div>
					</div>
				</div>
				<div class="msPolicy">
					<div class="container-fluid">
						<div class="msPolicyBox">
							<ul class="d-flex flex-wrap justify-content-center">
							<?php  
							foreach($calculations as $calculation){
								?>
							<li class="d-flex align-items-baseline">
									<div class="mspIcon">
 									<?php if(is_file('attachments/calculations/main/'.$calculation['image'])){ ?>
 											<img src="<?php echo base_url('attachments/calculations/main/'.$calculation['image'])?>">
 										 <?php } ?>
									</div>
									<div class="mspText">
										<strong><?php echo $calculation['value'];?></strong>
										<p><?php echo $calculation['title'];?></p>
									</div>
								</li>
									<?php } ?>
							  


							</ul>
						</div>
					</div>
				</div>
			</div>


 			

			<div class="msProWrapper">
				<div class="container-fluid">
					
					<!-- Ms Process Start -->
					<div class="msProcess">
						<div class="howHead mb-4">
							<h3>How it works?</h3>
						</div>
						<div class="row">
							<?php
							foreach($how_it_works as $how_it_work){
								?>
							<div class="col-sm-4">
								<div class="msProcessItem">
									<?php if(is_file('attachments/work-process/main/'.$how_it_work['image'])){ ?>
											<div class="processImg">
											<img src="<?php echo base_url('attachments/work-process/main/'.$how_it_work['image'])?>">
									</div>
										 <?php } ?>
									
										 <h6><?php echo $how_it_work['name'];?></h6>
								</div>
							</div>
							
							<?php } ?>
						</div>
					</div>

					<!-- Ms Process End -->

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
				$('#home_page_search_form').attr('action', '');
				$('#change_category').val('');
				var name=$(this).attr('name');
				var slug=$(this).attr('slug');
 				if(name!=''){
					$('#search_type').val(1);
					var id=$(this).attr('id');
					var is_parent=$(this).attr('is_parent');
					$('#search_type_id').val(is_parent);
					$('#search_id').val(id);
					$('#change_service_category').attr("disabled", true);
					$('#change_category').val(name);
					$('#search_button').removeAttr("disabled");
					$('#home_page_search_form').attr('action', '<?php echo base_url('products/');?>'+slug);
				}else{
					$('#change_service_category').removeAttr("disabled");
					$('#search_type_id').val('');
					$('#search_id').val('');
					$('#search_type').val('');
 					$('#search_button').attr("disabled", true);

				} 
				$('.hs1').removeClass('active');

			});
			$('.select_service').click(function(){
				$('#search_type').val(2);
				$('#home_page_search_form').attr('action', '');
				var name=$(this).attr('name');
				var slug=$(this).attr('slug');
				var parent_slug=$(this).attr('parent_slug');
 				$('#change_service_category').val('');
				if(name!=''){
					var id=$(this).attr('id');
					var is_parent=$(this).attr('is_parent');
					$('#search_type_id').val(is_parent);
					var dest_url="<?php echo base_url('services');?>";
					if(is_parent==1){
						dest_url +='/'+slug;
					}else{
						dest_url +='/'+parent_slug+'/'+slug;
					}
					$('#search_id').val(id);
					$('#change_category').attr("disabled", true);
					$('#change_service_category').val(name);
					$('#search_button').removeAttr("disabled");
					$('#home_page_search_form').attr('action', dest_url);
				}else{
					$('#change_category').removeAttr("disabled");
					$('#search_type_id').val('');
					$('#search_id').val('');
					$('#search_type').val('');
					$('#search_button').attr("disabled", true);
				}
				$('.hs2').removeClass('active');

			});
			$('#change_category').keyup(function(){
				 var cat =$('#change_category').val();
				 if(cat!=''){
					$('#change_service_category').removeAttr("disabled");
					$('#change_category').removeAttr("disabled");
				 }
 			})
			$('.change_location').click(function(){
				var id=$(this).attr('id');
			    var is_parent=$(this).attr('is_parent');
			    var name=$(this).attr('name');
				$('#change_location').val(name);
				if(is_parent==1){
					$('#location_type').val(1);
				}else{
					$('#location_type').val(2);
				}
				$('#location_id').val(id);
				$('.hs3').removeClass('active');
			})
			//change_service_category
			//  $("body").on("click", function(){
			// 		$(".selectCrop").removeClass('active');
			//  });

			// $("#change_category").focus(function(){
			// 		if($(".selectCrop").hasClass('active'))
			// 		{
			// 			$(".selectCrop").removeClass('active');
			// 		}

			// 	$(this).parent().addClass('active');

			// });
			
			// $("#change_category").blur(function(){
			// 	$(this).parent().removeClass('active');
			// });
			// $(".select_cate").click(function(){
			// 	$(".selectCrop").removeClass('active');
			// });

			// $(".select_service").click(function(){
			// 	$(".selectCrop").removeClass('active');
			// });

			// $("#change_service_category").focus(function(){
			// 	if($(".selectCrop").hasClass('active')){
			// 			$(".selectCrop").removeClass('active');
			// 	}
			// 	$(this).parent().addClass('active');
			// });
			 
			
			// $("#change_location").focus(function(){
			// 	if($(".selectCrop").hasClass('active'))
			// 		{
			// 			$(".selectCrop").removeClass('active');
			// 		}
			// 	$(this).parent().parent().addClass('active');
			// });
			// $(".change_location").click(function(){
			// 	$(".selectCrop").removeClass('active');
			// });

			$('.hsFlex .focusInput').on("click", function (e) {
				if ($(this).parent().parent('div').hasClass('active')) {
					$(this).parent().parent('div').removeClass('active');
				} else {
					$(this).parent().parent('div').addClass('active');
					$(this).parent().parent('div').siblings().removeClass('active');
				}
			});
			 
		});


 

	</script>
