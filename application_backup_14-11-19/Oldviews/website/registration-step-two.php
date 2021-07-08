<!-- <!DOCTYPE html>
<html>
	<head>
		<title>Mahaseel Register</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
		<link rel="stylesheet" href="assets/css/all.min.css">
		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" rel="stylesheet" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css" rel="stylesheet" />
		<link href="<?php echo base_url();?>assets/frontend/css/style.css" rel="stylesheet" />

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
		<script src="<?php echo base_url();?>assets/frontend/js/custom.js"></script>

	</head>
	<body> -->

	<?php
		$this->load->view('website/includes/header');
		$role_array=array('3'=>'Customer','2'=>'Grower','5'=>'Service Provider','4'=>'Delivery Boy');
	?>
		<div class="mainWrapper">
			<!-- Main body wrapper -->
			<div class="mainBody newRegister">
				<div class="regWrapper">
					<div class="regTopBanner"><img src="<?php echo base_url();?>/assets/frontend/images/banner01.jpg"></div>
					<div class="container-fluid">
						<div class="regContainer">
							<div class="regLogo">
							<a href="<?php echo base_url();?>" class="">
							<?php
								$settings=getSettings();
									if(is_file('attachments/pages/thumb/'.$settings['logo'])){
									?>
 								 <img src="<?php echo base_url('attachments/pages/thumb/'.$settings['logo'])?>">
									<?php
									}else{
										?>
								<img src="<?php echo base_url();?>/assets/frontend/images/logo.png">
										<?php
									}
									?>
									</a>
							
							</div>
							<h4>Sign Up with <?php echo $role_array[$role];?></h4>
							<form id="registration_form">
								<div id="success_message"></div>
								<div class="row">
									<div class="col-sm-6 form-group">
										<label>First Name</label>
										<input type="text" class="form-control" id="first_name"  placeholder="First Name*" name="first_name">
										<span class="error" id="first_name_error"></span>
									</div>
									<div class="col-sm-6 form-group">
										<label>Last Name</label>
										<input type="text" class="form-control" id="last_name" placeholder="Last Name*" name="last_name">
										<span class="error" id="last_name_error"></span>
									</div>
									<div class="col-sm-12 form-group">
										<label>Enter your email</label>
										<input type="text" class="form-control" placeholder="Email*" name="email" id="email">
										<span class="error" id="email_error"></span>
									</div>
									<div class="col-sm-12 form-group">
										<label>Enter your phone number</label>
										<input type="text" class="form-control allownumericwithoutdecimal" minlength="10" maxlength="10" id="phone" placeholder="Phone*" name="phone">
										<span class="error" id="phone_error"></span>
									</div>

									<div class="col-sm-12 form-group">
										<label>Select State</label>
										<?php
										$states=changeCountryGetState(array('country_id'=>65));
										?>
										<select class="form-control" id="change_state" name="change_state">
											<option value="">Select State</option>
											<?php 
											foreach($states as $state){
												?>
												<option value="<?php echo $state['id'];?>"><?php echo $state['name'];?></option>
												<?php
											}
											?>
										</select>
 										<span class="error" id="change_state_error"></span>
									</div>

									<div class="col-sm-12 form-group">
										<label>Select City</label>
										<select class="form-control" id="change_city" name="change_city">
											<option value="">Select City</option>
										</select>
 										<span class="error" id="change_city_error"></span>
									</div>

									<div class="col-sm-12 form-group">
										<label>Enter your address</label>
										<input type="text" class="form-control" id="address" placeholder="Address*" name="address" autocomplete="off">
										<span class="error" id="address_error"></span>
									</div>

									<div class="col-sm-6 form-group">
										<label>Enter a password</label>
										<input type="password" class="form-control" id="password" placeholder="Password*" name="password">
										<span class="error" id="password_error"></span>
									</div>
									<div class="col-sm-6 form-group">
										<label>Enter a confirm password</label>
										<input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password*" name="confirm_password">
										<span class="error" id="confirm_password_error"></span>
									</div>
 									<div class="col-sm-12 form-group" style="<?php if($role==2){ ?>display:block;<?php	 }else{ ?> display:none;<?php } ?>" >
										<label>Weather Forecast</label>
										<div class="forecast">
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" checked class="custom-control-input" id="forecastWeekly" name="weatherforecast" value="1">
												<label class="custom-control-label" for="forecastWeekly">Weekly</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="forecastMonthly" name="weatherforecast" value="2">
												<label class="custom-control-label" for="forecastMonthly">Monthly</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="forecast3Monthly" name="weatherforecast" value="3">
												<label class="custom-control-label" for="forecast3Monthly">3 Monthly</label>
											</div>
										</div>
									</div>
									<div class="col-sm-12 form-group">
										<label>Publication</label>
										<div class="publication">
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" checked class="custom-control-input" id="PublicationWeekly" name="publicationtime" value="1">
												<label class="custom-control-label" for="PublicationWeekly">Weekly</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="PublicationMonthly" name="publicationtime" value="2">
												<label class="custom-control-label" for="PublicationMonthly">Monthly</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="Publication3Monthly" name="publicationtime" value="3">
												<label class="custom-control-label" for="Publication3Monthly">3 Monthly</label>
											</div>
										</div>
									</div>
										 
									 <div class="col-sm-12 form-group" style="<?php if($role==3){ ?>display:block;<?php	 }else{ ?> display:none;<?php } ?>" >
										<label>Matching</label>
										<div class="publication">
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" checked class="custom-control-input" id="PublicationWeekly" name="matching" value="1">
												<label class="custom-control-label" for="MatchingWeekly">Weekly</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="PublicationMonthly" name="matching" value="2">
												<label class="custom-control-label" for="MatchingMonthly">Monthly</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="Publication3Monthly" name="matching" value="3">
												<label class="custom-control-label" for="Matching3Monthly">3 Monthly</label>
											</div>
										</div>
									</div>
									
									
									

									<div class="col-sm-12 form-group">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="subscribeNewletter" name="subscribeNewletter" value="1">
											<label class="custom-control-label" for="subscribeNewletter">Subscribe Our Newsletter</label>
										</div>
									</div>
								</div>
								<div class="signupDiv">
									<input type="hidden" id="latitude" name="latitude">
									<input type="hidden" id="longitude" name="longitude">
									<input type="hidden" name="role" value="<?php echo $role;?>">
									<button type="button" class="btn signupBtn" id="add_btn">Register</button>
									<div class="text-right">Already Register? <a href="<?php echo base_url('login');?>" class="linkBtn">Login</a></div>
 								</div>
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
	$(function(){
		$(".mainWrapper").addClass("logRegPage");
	});
	// var regBanner1 = $(".regTopBanner").outerHeight();
	// var regBanner2 = $(".regBottomBanner").outerHeight();
	// var ms2banner = regBanner1 + regBanner2;
	// var msWinHeight = $(window).height();
	// $(".regContainer").css({"min-hight": msWinHeight - ms2banner});
	// $(".regWrapper").css({"padding-top": regBanner1, "padding-bottom": regBanner2});
</script>

<!-- 		
		
	</body>
</html> -->