			<?php
			 $this->load->view('website/includes/header');
			 ?>
			<!-- Top Banner scetion -->
			<div class="topBanner" style="background-image: url('<?php echo base_url('assets/frontend/images/hsbanner.jpg')?>');">
				<div class="container-fluid">
					<div class="topBContent">
						<h1>Verification</h1>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim ven.</p>
					</div>
				</div>
			</div>

			<!-- Main body wrapper -->
			<div class="mainBody">
				<div class="contactWrapper">
					<div class="container-fluid">
						<div class="contactContainer">
							<div class="row">
                            <h2><?php echo $message;?></h2>
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
				window.setTimeout(function(){
 				window.location.href = "<?php echo base_url();?>";
				}, 5000);
			 })
			 </script>