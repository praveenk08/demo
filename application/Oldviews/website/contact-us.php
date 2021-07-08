<?php
			 $this->load->view('website/includes/header');
			 ?>
			<!-- Top Banner scetion -->
			<?php
			if(is_file('attachments/pages/main/'.$page['banner_image'])){
				$image=base_url('attachments/pages/main/'.$page['banner_image']);
			}else{
				$image=base_url('assets/frontend/images/hsbanner.jpg');
			}
			
			?>
				<!-- Top Banner scetion -->
				<div class="topBanner" style="background-image: url('<?php echo $image;?>');">
					<div class="container-fluid">
						<div class="topBContent">
							<h1><?php echo $page['name'];?></h1>
							<p><?php echo $page['banner_title'];?></p>
						</div>
					</div>
				</div>

			<!-- Main body wrapper -->
			<div class="mainBody">
				<div class="contactWrapper">
					<div class="container-fluid">
						<div class="contactContainer">
						<form id="contact_now_form_form">
							<div class="row">
								
								<div class="col-md-6">
									<div class="ctForm">
										<h5><strong>Tell us your project</strong></h5>
										<div id="success_message"></div>
										<div class="row">
											<div class="form-group col-lg-12">
												<input type="text" class="form-control" placeholder="Name*" name="name"  id="name">
												<span class="error" id="name_error"></span>
											</div>
											<div class="form-group col-lg-12">
												<input type="text" class="form-control" placeholder="Phone*"  name="phone"  id="phone">
												<span class="error" id="phone_error"></span>
											</div>
											<div class="form-group col-lg-12">
												<input type="email" class="form-control" placeholder="Email*"   name="email"  id="email">
												<span class="error" id="email_error"></span>
											</div>
											<div class="form-group col-lg-12">
												<input type="text" class="form-control" placeholder="Subject*"   name="subject"  id="subject">
												<span class="error" id="subject_error"></span>
											</div>
											<div class="form-group col-lg-12">
												<textarea class="form-control" placeholder="Message*" rows="4" name="message"  id="message"></textarea>
												<span class="error" id="message_error"></span>
											</div>
										</div>
										<div class="sendDiv">
										<button type="button" class="btn sendBtn" id="contact_now">Contact Now</button>
 										</div>
									</div>
								</div>
								

								<div class="col-md-6">
									<div class="ctInfo">
									<?php
									$settings=getSettings();
									?>
										<h5><strong>Contact us</strong></h5>
										<ul>
											<li class="d-flex">
												<i class="fas fa-home"></i>
												<span><?php echo $settings['contact_info'];?> </span>
											</li>
											<li class="d-flex">
												<i class="fas fa-envelope"></i>
												<span><?php echo $settings['email_address'];?> </span>
											</li>
											<li class="d-flex">
												<i class="fas fa-phone"></i>
												<span><?php echo $settings['mobile_no'];?> </span>
											</li>
										</ul>
										<div class="workHour">
											<h6>Working Hours</h6>
											<p>Working Hours: <span><?php echo $settings['working_hours'];?> </span></p>
										</div>
									</div>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			 $this->load->view('website/includes/footer');
			 ?>