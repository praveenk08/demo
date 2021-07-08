
			<?php
			$this->load->view('website/includes/header');
			?>
 			<!-- Top Banner scetion -->
			<div class="topBanner" style="background-image: url('<?php echo base_url('assets/frontend/images/hsbanner.jpg')?>');">
				<div class="container-fluid">
					<div class="topBContent">
						<h1>Mahaseel <strong>Change Password</strong></h1>
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
							<h5>Change Password Form</h5>
							<form id="change_password_form">
							<div id="success_message"></div>

								<div class="form-group">
									<input type="password" class="form-control" id="password" placeholder="Password*" name="password">
									<span class="error" id="password_error"></span>
								</div>
								<div class="form-group">
                                    <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password*" name="confirm_password">
                                    <span class="error" id="confirm_password_error"></span>
								</div>
                                
								<div class="signupDiv">
 								<button type="button" class="btn signupBtn" id="change_password_btn">Submit</button>
                                 <input type="hidden" name="id" value="<?php echo $id;?>">
 								</div>

							</form>
						</div>
					</div>
				</div>
            </div>
            <?php
			$this->load->view('website/includes/footer');
			?>

 
			