<?php
			 $this->load->view('website/includes/header');
			 ?>
			<!-- Top Banner scetion -->
			<div class="topBanner" style="background-image: url('<?php echo base_url('assets/frontend/images/hsbanner.jpg')?>');">
				<div class="container-fluid">
					<div class="topBContent">
						<h1>Mahaseel <strong>Login</strong></h1>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim ven.</p>
					</div>
				</div>
			</div>

			<!-- Main body wrapper -->
			<div class="mainBody">
				<div class="regWrapper">
					<div class="container-fluid">
						<div class="msRegBox" id="login_part">
							<h5>Login Form</h5>
							<form id="login_form">
							<div id="success_message"  class="success"></div>

								<div class="form-group">
									<input type="text" class="form-control" placeholder="Enter your email" name="email" id="email">
									<span class="error" id="email_error"></span>
								</div>
								<div class="form-group">
									<input type="password" class="form-control" placeholder="Enter your password" name="password" id="password">
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
								 <a href="<?php echo base_url('registration');?>" class="btn signupBtn">Registration</a>
								</div>
							</form>
						</div>

						<div class="msRegBox" style="display:none;" id="forgot_password_part">
							<h5>Forgot password</h5>
							<form id="forgot_password_form">
							<div id="forgot_success_message" class="success"></div>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Enter your email" name="forgot_email" id="forgot_email">
									<span class="error" id="forgot_email_error"></span>
								</div>
								 
								<div class="form-group">
									<div class="d-flex justify-content-between align-items-center">
										
									<button type="button" class="btn signupBtn" id="forgot_btn">Submit</button>

										<a href="javascript:void(0)" onClick="loginForgot(1);">Login</a>
									</div>
								</div>
								 
							</form>
						</div>

					</div>
				</div>
			</div>
			<?php
			 $this->load->view('website/includes/footer');
			 ?>