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
										<h5><strong>
										<?php
										if($this->session->userdata('language')=='en'){
											$name_place="Name";
											$phone_place="Phone";
											$email_place="Email";
											$subject_place="Subject";
											$message_place="Message";
											$btn_place="Contact Now";
											$working_hours_place="Working Hours";
                                          ?>
										Tell us your project
										  <?php
										}else{
											$name_place="اسم";
											$phone_place="هاتف";
											$email_place="البريد الإلكتروني";
											$subject_place="موضوع";
											$message_place="رسالة";
											$btn_place="اتصل الآن";
											$working_hours_place="ساعات العمل";
											?>
											أخبرنا بمشروعك
											<?php
										}
										?>
										</strong></h5>
										<div id="success_message"></div>
										<div class="row">
											<div class="form-group col-lg-12">
												<input type="text" class="form-control" placeholder="<?php echo $name_place; ?>*" name="name"  id="name">
												<span class="error" id="name_error"></span>
											</div>
											<div class="form-group col-lg-12">
												<input type="text" class="form-control" placeholder="<?php echo $phone_place; ?>*"  name="phone"  id="phone">
												<span class="error" id="phone_error"></span>
											</div>
											<div class="form-group col-lg-12">
												<input type="email" class="form-control" placeholder="<?php echo $email_place; ?>*"   name="email"  id="email">
												<span class="error" id="email_error"></span>
											</div>
											<div class="form-group col-lg-12">
												<input type="text" class="form-control" placeholder="<?php echo $subject_place; ?>*"   name="subject"  id="subject">
												<span class="error" id="subject_error"></span>
											</div>
											<div class="form-group col-lg-12">
												<textarea class="form-control" placeholder="<?php echo $message_place; ?>*" rows="4" name="message"  id="message"></textarea>
												<span class="error" id="message_error"></span>
											</div>
										</div>
										<div class="sendDiv">
										<button type="button" class="btn sendBtn" id="contact_now"><?php echo $btn_place; ?></button>
 										</div>
									</div>
								</div>
								

								<div class="col-md-6">
									<div class="ctInfo">
									<?php
									$settings=getSettings();
									?>
										<h5><strong>
										<?php
										if($this->session->userdata('language')=='en'){
                                          ?>
										Contact Us
										  <?php
										}else{
											?>
										اتصل بنا
											<?php
										}
										?>
										

										</strong></h5>
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
											<h6>
											<?php echo $working_hours_place; ?>
											</h6>
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