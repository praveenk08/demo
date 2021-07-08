<?php
			 $this->load->view('website/includes/header');
			 ?>
			
			<!-- Main body wrapper -->
			<div class="mainBody newRegister">
				<div class="regWrapper">
					<div class="regTopBanner"><img src="<?php echo base_url();?>/assets/frontend/images/banner01.jpg"></div>
					<div class="container-fluid">
						<div class="regContainer" id="login_part">
							<div class="regLogo"><a href="<?php echo base_url();?>" class=""><img src="<?php echo base_url();?>/assets/frontend/images/logo.png"></a></div>
							<h4>Log In </h4>
							<form id="login_form">
								<div id="success_message" class="success"></div>									
								<div class="form-group">
									<label>Enter your email</label>
									<input type="text" class="form-control" placeholder="Email*" name="email" id="email">
									<span class="error" id="email_error"></span>
								</div>
								<div class="form-group">
									<label>Enter a password</label>
									<input type="password" class="form-control" id="password" placeholder="Password*" name="password">
									<span class="error" id="password_error"></span>
								</div>
								<div class="form-group">
									<div class="d-flex justify-content-between align-items-center">
										<div class="custom-control custom-checkbox">
											<!--<input type="checkbox" class="custom-control-input" id="rememberMe" name="">
											<label class="custom-control-label" for="rememberMe">Remember Me</label>-->
										</div>
										<a href="javascript:void(0)" onClick="loginForgot(0);">Forgot Password?</a>
									</div>
								</div>
								<div class="signupDiv">
 									<button type="button" class="btn signupBtn" id="login_btn">Login</button>
									<input type="hidden" name="ch" value="<?php echo $ch;?>">
									<div class="text-right">New User? <a href="<?php echo base_url('registration-step-one');?>" class="linkBtn">Registration</a></div>
								</div>
							</form>
						</div>

						<div class="regContainer" style="display:none;" id="forgot_password_part">
							<div class="regLogo"><a href="<?php echo base_url();?>" class=""><img src="<?php echo base_url();?>/assets/frontend/images/logo.png"></a></div>
							<h4>Forgot password</h4>
							<form id="forgot_password_form">
								<div id="forgot_success_message" class="success"></div>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Enter your email" name="forgot_email" id="forgot_email">
									<span class="error" id="forgot_email_error"></span>
								</div>
								<div class="signupDiv">
									<button type="button" class="btn signupBtn" id="forgot_btn">Submit</button>
									<!-- <div class="text-right"><a href="javascript:void(0)" onClick="loginForgot(1);" class="linkBtn">Login</a></div> -->
								</div>
							</form>
						</div>

					</div>
					<div class="regBottomBanner"><img src="<?php echo base_url();?>/assets/frontend/images/banner02.jpg"></div>
				</div>
			</div>

			<?php
			 $this->load->view('website/includes/footer');
			 ?>

			 
<script>
	$(function(){
		$(".mainWrapper").addClass("logRegPage");
	});

	//  var regB1 = $(".regTopBanner").outerHeight();
	//  var regB2 = $(".regBottomBanner").outerHeight();
	//  var ms2banner = regBanner1 + regBanner2;
	//  var msWinHeight = $(window).height();
	// $(".regContainer").css({"min-hight": msWinHeight - ms2banner});
	// $(".regWrapper").css({"padding-top": regBanner1, "padding-bottom": regBanner2});
</script>