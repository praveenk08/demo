
			 
			<div class="subscribe">
				<div class="container-fluid">
					<div class="scContainer d-flex flex-wrap">
						<div class="sc1">
							<h5>Sign up to newsletter</h5>
							<p>Register now to get updates on promotions & coupons.</p>
						</div>
						<div class="sc2">
							<div class="input-group">
								<input type="email" class="form-control" name="subscribe_email" id="subscribe_email" placeholder="Email address">
								<div class="input-group-append"><span class="input-group-text" id="subscribe_btn">Subscribe</span></div>
							</div>
							<span id="subscribe_email_error" class="error"></span>
   						<span id="subscribe_success"></span>
						</div>
						<div class="sc3">
							<div class="d-flex scSocial">
							<div class="customInsta"><a href="https://www.instagram.com/"><img src="https://platform-cdn.sharethis.com/img/instagram.svg"></a></div>
							<div class="d-flex scSocial sharethis-inline-share-buttons"></div>
							<!--<a href=""><i class="fab fa-whatsapp"></i></a>
								<a href=""><i class="fab fa-facebook-f"></i></a>
								<a href=""><i class="fab fa-twitter"></i></a>
								<a href=""><i class="fab fa-pinterest"></i></a>
								<a href=""><i class="fab fa-linkedin-in"></i></a>-->
							</div>
						</div>
					</div>
				</div>
			</div>
			<footer>
				<div class="footTop">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-6">
								<div class="footContent footContact">
									<?php
									$settings=getSettings();
									  if(is_file('attachments/pages/main/'.$settings['logo'])){
										?>
 								<a href="<?php echo base_url();?>" class="footLogo"><img src="<?php echo base_url('attachments/pages/main/'.$settings['logo'])?>"></a>
									<?php
									}else{
										?>
										<a href="<?php echo base_url();?>" class="footLogo"><img src="<?php echo base_url();?>/assets/frontend/images/logo.png"></a>
										<?php
									}
									?>
									<div class="footCall d-flex">
										<img src="<?php echo base_url();?>/assets/frontend/images/support.png">
										<div>
											<label>Call us toll free</label>
											<span><?php echo $settings['phone_no'];?></span>
										</div>
									</div>
									<div class="footInfo">
										<strong>Contact Info:</strong>
										<p><?php echo $settings['contact_info'];?></p>
									</div>
									<div class="footInfo">
										<strong>Contact Email:</strong>
										<p><?php echo $settings['email_address'];?></p>
									</div>
								</div>
							</div>
							<div class="col-md-2 col-sm-4">
								<div class="footContent footLink">
									<h5>Crops</h5>
									<ul>
									<?php
											$categories=categoryList(array('c.parent_id'=>0,'c.status'=>1));
											$sr=1;
											$total_cat=count($categories);
											foreach($categories as $category){

												if($sr>5){
													$class="more";
											 }else{
													$class="default less";
											 }
											 ?>
											 	<li class="<?php echo $class;?>"><a href="<?php echo base_url('products/'.$category['slug']);?>"><?php echo $category['name'];?></a></li>
 											 <?php
											 if($sr==5){
												 ?>
												 <i id="show_more" ><b>Show more</b></i>
												 <?php
											 }
											 if($total_cat==$sr){
												?>
												<i id="show_less" style="display:none;"><b>Show less</b></i>
												<?php
											 }
											 $sr ++;
										 
												?>
												<?php
											}
										?>
 									</ul>
								</div>
							</div>
							
							<div class="col-md-2 col-sm-4">
								<div class="footContent footLink">
									<h5>Services</h5>
									<ul>
										<?php
												$service_categories=getServicesCategories(array('sc.is_deleted'=>0,'sc.status'=>1));
												$sr=1;
												$total_service=count($service_categories);
												foreach($service_categories as $service_category){
													if($sr>5){
 														$class="more1";
													}else{
 														$class="default less1";
													}
													?>
													<li class="<?php echo $class;?>"><a href="<?php echo base_url('services/'.$service_category['slug']);?>"><?php echo $service_category['name'];?></a></li>
													<?php
													if($sr==5){
														?>
														<i id="show_more1" ><b>Show more</b></i>
														<?php
													}
													if($total_service==$sr){
													 ?>
													 <i id="show_less1" style="display:none;"><b>Show less</b></i>
													 <?php
													}
													$sr ++;
												}
										?>
									</ul>
								</div>
							</div>

							<div class="col-md-2 col-sm-4">
								<div class="footContent footLink">
									<h5>Quick Links</h5>
									<ul>
										<li><a href="<?php echo base_url('contact-us');?>">About Us</a></li>
 										<li><a href="<?php //echo base_url('site-map');?>">Sitemap</a></li>
										<li><a href="<?php echo base_url('contact-us');?>">Contact Us</a></li>
										<li><a href="<?php echo base_url('our-team');?>">Our team</a></li>
									</ul>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="footMiddle">
					<div class="container-fluid">
						<div class="footPolicy">
							<ul class="d-flex flex-wrap justify-content-center">
								<?php
								$facilities=getSingleTableData('facilities',array('status'=>1,'is_deleted'=>0),array('key'=>'sort_id','value'=>'ASC'));
								?>
								<?php
								foreach($facilities as $facility){
									?>
									<li class="d-flex align-items-center">
									<div class="mspIcon">
										<?php
										if(is_file('attachments/facilities/thumb/'.$facility['image'])){
											?>
									 <img src="<?php echo base_url('attachments/facilities/thumb/'.$facility['image'])?>">
										<?php
										}
										?>
									</div>
									<div class="mspText">
										<p><?php echo $facility['name'];?></p>
									</div>
								</li>
									<?php
								}
								?>
								 
							</ul>
						</div>
						<span class="footer_extra_part">
						<div class="fmText">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</div>
						<div class="payMethod d-flex justify-content-center" >
							<div class="payImg" ><img src="<?php echo base_url();?>/assets/frontend/images/pay-img.jpg"></div>
						</div>
						</span>
					</div>
				</div>
				<div class="footBottom">
					<div class="container-fluid">
						<div class="footCopy text-center">&copy; <a href="">Mahaseel</a> <?php echo date('Y');?>. All Rights Reserved.</div>
					</div>
				</div>
			</footer>
			<div class="scroll-top not-visible"><i class="fas fa-angle-up"></i></div>
		</div>


	<div class="modal fade" id="removeProfilePhotoPouup" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmation</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="text-center" style="font-size: 18px;"><strong id="delete_profile_image_confirmation_message"></strong></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="deleteProfilePhoto">Yes</button>&nbsp;&nbsp;&nbsp;
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>


	<div class="modal fade" id="deleteRecordPouup" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmation</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="text-center" style="font-size: 18px;"><strong id="delete_record_confirmation_message"></strong></div>
					<input type="hidden" id="action_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="deleteRecord">Yes</button>&nbsp;&nbsp;&nbsp;
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        </div>
      </div>
    </div>
  </div>

		<script>
			$(function(){
				$('.footer_extra_part').remove();
				$('.more').hide();
				$('.more1').hide();
				$('#show_more').click(function(){
					$('#show_more').hide();
					$('#show_less').show();
					$('.more').show();
				});
				$('#show_less').click(function(){
					$('#show_less').hide();
					$('#show_more').show();
					$('.more').hide();
				})

				$('#show_more1').click(function(){
					$('#show_more1').hide();
					$('#show_less1').show();
					$('.more1').show();
				});
				$('#show_less1').click(function(){
					$('#show_less1').hide();
					$('#show_more1').show();
					$('.more1').hide();
				})
				/*-------- scroll to top start --------*/
				$(window).on('scroll', function () {
					if ($(this).scrollTop() > 600) {
						$('.scroll-top').removeClass('not-visible');
					} else {
						$('.scroll-top').addClass('not-visible');
					}
				});
				$('.scroll-top').on('click', function (event) {
					$('html,body').animate({
						scrollTop: 0
					}, 1000);
				});
				/*-------- scroll to top end --------*/

				$('.proSlide1').owlCarousel({
					nav: true, dots: false, loop: true, autoplay: true, responsive: {
						0: { items: 1 },
						640: { items: 2 },
						800: { items: 3 },
						1000: { items: 4 }
					}
				});
				$('.proSlide2').owlCarousel({
					nav: true, dots: false, loop: true, autoplay: true, margin:30, responsive: {
						0: { items: 1 },
						640: { items: 2 },
						800: { items: 3 },
						1000: { items: 4 }
					}
				});
				$('.msLogoSlide').owlCarousel({
					nav: false, dots: false, loop: true, autoplay: true, margin:30, responsive: {
						0: { items: 1 },
						640: { items: 2 },
						800: { items: 4 },
						1000: { items: 5 }
					}
				});
				$('.proSlide3').owlCarousel({
					nav: true, dots: false, loop: true, autoplay: true, margin:30, responsive: {
						0: { items: 1 },
						640: { items: 2 },
						1000: { items: 3 }
					}
				});
			});

			function makeTimer() {

			//	var endTime = new Date("29 April 2018 9:56:00 GMT+01:00");	
				var endTime = new Date("29 April 2020 9:56:00 GMT+01:00");			
					endTime = (Date.parse(endTime) / 1000);

					var now = new Date();
					now = (Date.parse(now) / 1000);

					var timeLeft = endTime - now;

					var days = Math.floor(timeLeft / 86400); 
					var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
					var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
					var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
		  
					if (hours < "10") { hours = "0" + hours; }
					if (minutes < "10") { minutes = "0" + minutes; }
					if (seconds < "10") { seconds = "0" + seconds; }

					$("#days").html(days + "<span>Days</span>");
					$("#hours").html(hours + "<span>Hrs</span>");
					$("#minutes").html(minutes + "<span>Min</span>");
					$("#seconds").html(seconds + "<span>Sec</span>");		

			}

			setInterval(function() { makeTimer(); }, 1000);

var loader='<div class="loader"><i class="fa fa-spinner fa-spin"></i></div>';
 var urls = {
	base_url: '<?php echo base_url('');?>',
	subscribe: '<?php echo base_url('subscribe');?>',
	addUser: '<?php echo base_url('user-registration');?>',
	login: '<?php echo base_url('check-login');?>',
	loginForm: '<?php echo base_url('login');?>',
	changePassword: '<?php echo base_url('check-change-password');?>',
	forgotPassword: '<?php echo base_url('forgot-password');?>',
	contactUsNow: '<?php echo base_url('contact-us-now');?>',
	customerSaveUpdateProfile: '<?php echo base_url('customer-save-update-profile');?>',
	deliveryBoySaveUpdateProfile: '<?php echo base_url('delivery-boy-save-update-profile');?>',
	serviceProviderSaveUpdateProfile: '<?php echo base_url('service-provider-save-update-profile');?>',
	providerSaveService: '<?php echo base_url('service-provider-save-service');?>',
	changeLanguage: '<?php echo base_url('change-language');?>',	
	changeCountryGetState:'<?php echo base_url('change-country-get-state')?>',
	changeStateGetCity:'<?php echo base_url('change-state-get-city')?>',
	addRemoveWishlist:'<?php echo base_url('add-remove-wish-list')?>',
	addProductToCart:'<?php echo base_url('add-product-to-cart')?>',
	rating:'<?php echo base_url('rating')?>',
 };
 var language='<?php echo $this->session->userdata('language')?>';
if(language==''){
	changeLanguage('en');
}
 var error_message='<div class="alert alert-danger">Error in submitting form! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
</script>
</body>
</html>