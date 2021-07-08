
			<?php
			$this->load->view('website/includes/header');
			?>
 			<!-- Top Banner scetion -->
			<div class="topBanner" style="background-image: url('<?php echo base_url('assets/frontend/images/hsbanner.jpg')?>');">
				<div class="container-fluid">
					<div class="topBContent">
						<h1>Mahaseel <strong>Registration</strong></h1>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim ven.</p>
					</div>
				</div>
			</div>
            <!-- Main body wrapper -->
			<div class="mainBody">
				<div class="regWrapper">
					<div class="container-fluid">
						<div class="msRegBox">
							<h5>Signup Form</h5>
							<form id="registration_form">
							<div id="success_message"></div>
								<div class="form-group">
									<label>Signup As</label>
									<select class="form-control" name="role"  id="role">
										<option value="">Select signup as</option>
										<?php
										$where=array('status'=>1,'id <>'=>1);
										$roles=getSingleTableData('role',$where);
										foreach($roles as $role){
										?>
										<option value="<?php  echo $role['id'];?>"><?php echo $role['name'];?></option>
										<?php
										}
										?>
									</select>
									<span class="error" id="role_error"></span>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" id="first_name"  placeholder="First Name*" name="first_name">
									<span class="error" id="first_name_error"></span>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" id="last_name" placeholder="Last Name*" name="last_name">
									<span class="error" id="last_name_error"></span>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Email*" name="email" id="email">
									<span class="error" id="email_error"></span>
								</div>
								<div class="form-group">
									<input type="text" class="form-control allownumericwithoutdecimal" minlength="10" maxlength="10" id="phone" placeholder="Phone*" name="phone">
									<span class="error" id="phone_error"></span>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" id="address" placeholder="Address*" name="address" autocomplete="off">
									<span class="error" id="address_error"></span>
								</div>
								<div class="form-group">
										<input type="password" class="form-control" id="password" placeholder="Password*" name="password">
										<span class="error" id="password_error"></span>
								</div>
								<div class="form-group">
										<input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password*" name="confirm_password">
										<span class="error" id="confirm_password_error"></span>
								</div>
								<div class="form-group">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="subscribeNewletter" name="subscribeNewletter" value="1">
										<label class="custom-control-label" for="subscribeNewletter">Subscribe Our Newsletter</label>
									</div>
								</div>
								<div class="signupDiv">
								<input type="hidden" id="latitude" name="latitude">
								<input type="hidden" id="longitude" name="longitude">
								<button type="button" class="btn signupBtn" id="add_btn">Submit</button>
								<a href="<?php echo base_url('login');?>" class="btn signupBtn">Login</a>
 								</div>
							</form>
						</div>
					</div>
				</div>
            </div>
            
            <?php
			$this->load->view('website/includes/footer');
			?>

 
			