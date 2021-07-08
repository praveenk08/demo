
			 <?php
			 $this->load->view('website/includes/header');
			 ?>
			
			<!-- Main body wrapper -->
			<div class="mainBody">
				<div class="msBreadcrumb">
					<div class="container-fluid">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Dashboard</li>
						</ol>
					</div>
				</div>
				<div class="userWrapper">
					<div class="container-fluid">
						<div class="cwContainer">
							<div class="uwBox d-flex flex-wrap">
								<?php $this->load->view('website/delivery-boy/left-panel');?>
								<div class="profileRt">
									<div class="tab-content">

										<div class="tab-pane active" id="myProfile">
											<div class="myProfile">
												<div class="d-flex">
													 
													<?php
                                             if(is_file('attachments/users/thumb/'.$this->session->userdata('delivery_boy_data')['image'])){
											 ?>
											 <div class="myImg">
														<img src="<?php echo base_url('attachments/users/thumb/'.$this->session->userdata('delivery_boy_data')['image'])?>">
													</div>
                                              <?php
                                                }
                                                ?>
													<div class="myInfo">
														<div class="personalInfo">
															<h5 class="infoTitle"><strong>Personal Details:</strong></h5>
															<div class="row form-group">
																<label class="col-sm-3">First Name:</label>
																<div class="col-sm-9"><?php echo $this->session->userdata('delivery_boy_data')['first_name'];?></div>
															</div>
															<div class="row form-group">
																<label class="col-sm-3">last Name:</label>
																<div class="col-sm-9"><?php echo $this->session->userdata('delivery_boy_data')['last_name'];?></div>
															</div>
															<div class="row form-group">
																<label class="col-sm-3">Phone:</label>
																<div class="col-sm-9"><?php echo $this->session->userdata('delivery_boy_data')['phone'];?></div>
															</div>
															<div class="row form-group">
																<label class="col-sm-3">Email:</label>
																<div class="col-sm-9"><?php echo $this->session->userdata('delivery_boy_data')['email'];?></div>
															</div>

														</div>

													</div>
												</div>
											</div>
											 
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
			<?php
			 $this->load->view('website/includes/footer');
			 ?>