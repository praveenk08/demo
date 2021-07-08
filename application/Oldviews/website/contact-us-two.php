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
						<form id="contact_two_form_form">
							<div class="row">
								
								<div class="col-md-6">
									<div class="ctForm">
										<h5><strong>Tell us your project</strong></h5>
										<div id="success_message"></div>
										<div class="row">
											<div class="form-group col-lg-12">
												<input type="text" class="form-control" placeholder="Name*" name="cname"  id="cname">
												<span class="error" id="cname_error"></span>
											</div>
											<div class="form-group col-lg-12">
												<input type="text" class="form-control" placeholder="Phone*"  name="cphone"  id="cphone">
												<span class="error" id="cphone_error"></span>
											</div>
											<div class="form-group col-lg-12">
												<input type="email" class="form-control" placeholder="Email*"   name="cemail"  id="cemail">
												<span class="error" id="cemail_error"></span>
											</div>
											<div class="form-group col-lg-12">
												<input type="text" class="form-control" placeholder="Subject*"   name="csubject"  id="csubject">
												<span class="error" id="csubject_error"></span>
											</div>
											<div class="form-group col-lg-12">
												<textarea class="form-control" placeholder="Message*" rows="4" name="cmessage"  id="cmessage"></textarea>
												<span class="error"id="cmessage_error" ></span>
											</div>
										</div>
										<div class="sendDiv">
										<button type="button" class="btn sendBtn"  id="contact_nowtwo" title="">Contact Now</button>
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
			 <script>
			 	$(function(){		
			 		
	$('#contact_nowtwo').click(function(){
		$('#contact_nowtwo').attr("disabled", true);
		$('#contact_two_form_form input,textarea').css('border', '1px solid #ccc');
		$('#success_message').html('');
		$('.error').html('');
		$.ajax({
			type: "POST",	
			url: '<?php echo base_url('Website/contactustwoSubmit');?>',
			data: $('#contact_two_form_form').serialize(),
			success: function(ajaxresponse){
				  response=JSON.parse(ajaxresponse);
				 //alert(response.length);
				 if(!response['status']){
					$.each(response['response'], function(key, value) {
						$('#' + key).css('border', '1px solid #cc0000');
						$('#'+key+'_error').html(value);
					});
					$('#success_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#contact_nowtwo').removeAttr("disabled");
				}else{
					$('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#contact_two_form_form').trigger("reset");
					$('#contact_nowtwo').removeAttr("disabled");
					setTimeout(function(){
						$('#success_message').html('');
						}, 3000);
					   
				}
 
			}
		});
	})

	
			 	});

			 </script>