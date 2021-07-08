<?php
	 $this->load->view('website/includes/header');
	 $settings=getSettings();
			 ?>
		<div class="mainWrapper">
		
			<!-- Main body wrapper -->
			<div class="mainBody newRegister">
				<div class="regWrapper">
					<div class="regTopBanner">
						<?php
						if(is_file('attachments/pages/main/'.$settings['login_registration_banner']) ){
										?>
 								<img src="<?php echo base_url('attachments/pages/main/'.$settings['login_registration_banner'])?>">
									<?php
									}else{
										?>
										<img src="<?php echo base_url();?>/assets/frontend/images/banner01.jpg">
										<?php
							}
							?>

						</div>
						<div class="container-fluid">
						<div class="regContainer lrbContainer">
							<div class="regLogo"><a href="<?php echo base_url();?>" class="">
							<?php
								
									if(is_file('attachments/pages/main/'.$settings['logo'])){
									?>
 								 <img src="<?php echo base_url('attachments/pages/main/'.$settings['logo'])?>">
									<?php
									}else{
										?>
								<img src="<?php echo base_url();?>/assets/frontend/images/logo.png">
										<?php
									}
									?>
							</a></div>
								<div class="row">
									<div class="col-sm-6">
										<div class="lrbItem">
											<button class="d-flex align-items-center" onClick="Submit(3);">
												<div class="icon1"><img src="<?php echo base_url();?>/assets/frontend/images/ic_customer.png"></div>
												<div class="lrbContent">
													<label>Sign Up to</label>
													<h3>Customer</h3>
												</div>
												<div class="icon2"><i class="fas fa-arrow-right"></i></div>
											</button>
 										</div>
									</div>

									<div class="col-sm-6">
										<div class="lrbItem">
											<button class="d-flex align-items-center"  onClick="Submit(2);">
												<div class="icon1"><img src="<?php echo base_url();?>/assets/frontend/images/ic_grower.png"></div>
												<div class="lrbContent">
													<label>Sign Up to</label>
													<h3>Grower</h3>
												</div>
												<div class="icon2"><i class="fas fa-arrow-right"></i></div>
											</button>
 										</div>
									</div>

									<div class="col-sm-6">
										<div class="lrbItem">
										<button class="d-flex align-items-center"  onClick="Submit(5);">
												<div class="icon1"><img src="<?php echo base_url();?>/assets/frontend/images/ic_service_provider.png"></div>
												<div class="lrbContent">
													<label>Sign Up to</label>
													<h3>Service Provider</h3>
												</div>
												<div class="icon2"><i class="fas fa-arrow-right"></i></div>
											</button>
 										</div>
									</div>

									<div class="col-sm-6">
										<div class="lrbItem">
										<button class="d-flex align-items-center"  onClick="Submit(4);">
												<div class="icon1"><img src="<?php echo base_url();?>/assets/frontend/images/ic_delivery.png"></div>
												<div class="lrbContent">
													<label>Sign Up to</label>
													<h3>Delivery Agents</h3>
												</div>
												<div class="icon2"><i class="fas fa-arrow-right"></i></div>
											</button>
										</div>
									</div>
 								</div>
								<form method="POST" id="registration_page" action="<?php echo base_url('registration-step-two');?>">
								<input type="hidden" name="role_id" id="role_d" >
								</form>
						</div>
					</div>
					<div class="regBottomBanner"><img src="<?php echo base_url();?>/assets/frontend/images/banner02.jpg"></div>
				</div>
			</div>
			
		</div>

		
		<?php
			 $this->load->view('website/includes/footer');
			 ?>

<script>
	$(".mainWrapper").addClass("logRegPage");
	function Submit(id){
		$('#role_d').val(id);
		$('#registration_page').submit();
 	}
</script>

<!-- 		
		
	</body>
</html> -->