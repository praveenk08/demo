<?php $this->load->view('website/includes/header');?>

		<?php
		if(is_file('attachments/pages/main/'.$about_us['banner_image'])){
			$image=base_url('attachments/pages/main/'.$about_us['banner_image']);
		}else{
			$image=base_url('assets/frontend/images/hsbanner.jpg');
		}
		
		?>
			<!-- Top Banner scetion -->
 			<div class="topBanner" style="background-image: url('<?php echo $image;?>');">
				<div class="container-fluid">
					<div class="topBContent">
						<h1><?php echo $about_us['name'];?></h1>
						<p><?php echo $about_us['banner_title'];?></p>
					</div>
				</div>
			</div>

			<!-- Main body wrapper -->
			<div class="mainBody">
				<div class="aboutWrapper">
					<div class="container-fluid">
						<div class="abtContainer">
							<div class="d-flex flex-wrap">
								<div class="abtLt">
									<div class="abtContent">
 										<?php echo $about_us['description'];?>
									</div>
								</div>
								<div class="abtRt">
								<?php if(is_file('attachments/pages/medium/'.$about_us['image'])){ ?>
									<div class="abtImg">
										<img src="<?php echo base_url('attachments/pages/medium/'.$about_us['image'])?>">
									</div>
   										<?php } ?>
									
								</div>
							</div>
						</div>
					</div>
				</div>
				

				<div class="whyWrapper">
					<div class="container-fluid">
						<div class="whyContainer">
							<h4 class="mb-4 text-center"><strong>Why choose us</strong></h4>
							<div class="row">
								<div class="col-md-4">
									<div class="whyItem">
										<div class="whyIcon"><i class="fas fa-globe"></i></div>
										<div class="whyContent">
											<h6>Free Shipping</h6>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
											tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim ven.</p>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="whyItem">
										<div class="whyIcon"><i class="fas fa-plane"></i></div>
										<div class="whyContent">
											<h6>Fast Delivery</h6>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
											tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim ven.</p>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="whyItem">
										<div class="whyIcon"><i class="fas fa-comments"></i></div>
										<div class="whyContent">
											<h6>Customer Support</h6>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
											tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim ven.</p>
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