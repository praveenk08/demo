<!DOCTYPE html>
<html>
	<head>
		<title>Mahaseel Home</title>

		<meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/all.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/fonts/flaticon.css">
		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" rel="stylesheet" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css" rel="stylesheet" />
		<link href="<?php echo base_url();?>assets/frontend/css/owl.carousel.css" rel="stylesheet" />
		<link href="<?php echo base_url();?>assets/frontend/css/magnific-popup.css" rel="stylesheet" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" rel="stylesheet" />
		<link href="<?php echo base_url();?>assets/frontend/css/nice-select.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/frontend/css/icon-font.css">
		<link href="<?php echo base_url();?>assets/frontend/css/range-slider.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/vanilla-calendar.css">
		<link href="<?php echo base_url();?>assets/frontend/css/style.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo base_url();?>/assets/frontend/js/owl.carousel.js"></script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js'></script>
		<script src="<?php echo base_url();?>/assets/frontend/js/jquery.nice-select.min.js"></script>
		<script src="<?php echo base_url();?>/assets/frontend/js/jquery.rating-stars.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
		<?php
		if($this->uri->segment(1)!='registration-step-two'){
			?>
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPOxoqGdov5Z9xJw1SMVa_behLLSPacVM&libraries=places&callback=initAutocomplete"
				async defer></script>
			<?php
		}
		?>
		
		<script  src="<?php echo base_url();?>assets/frontend/js/range-slider.js"></script>
		<script src="<?php echo base_url();?>assets/frontend/js/vanilla-calendar-min.js"></script>
		<script src="<?php echo base_url();?>/assets/frontend/js/clamp.js"></script>
		<script src="<?php echo base_url();?>/assets/frontend/js/custom.js"></script>
		<script src="<?php echo base_url();?>/assets/frontend/js/common.js"></script>
		<script src="https://momentjs.com/downloads/moment.js"></script>
	</head>
	<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5d8c823b0080f50012d940d4&product=inline-share-buttons' async='async'></script>

	<body>
			<div class="mainWrapper">
			<!-- Header Section -->
			<header class="header">
				<div class="topHead">
					<div class="container-fluid">
						<div class="thContent">
							<ul class="d-flex flex-wrap align-items-center">
								<li class="myAccount">
									<div class="d-flex align-items-center">
									<?php
      									$languages=getLanguageList();
	  									?>
										  <?php
										  $sr=1;
											foreach($languages as $language){
 												?>
												<a href="javascript:void(0);" onclick="changeLanguage('<?php echo $language['abbr'];?>')" class="<?php if($language['abbr']==$this->session->userdata('language')){echo "active-language";}?>"><?php echo $language['short_name'];?></a>
												<?php
												if($sr==1){
													?>
													<span>|</span>
													<?php
												}
												?>
												<?php
												$sr++;
											}
											?>
 									<?php
									if($this->session->userdata('role_id')){
										if($this->session->userdata('role_id')==1){
											$key="admin_data";
										}
										if($this->session->userdata('role_id')==2){
											$key="vendor_data";
										}
										if($this->session->userdata('role_id')==3){
											$key="customer_data";
										}
										if($this->session->userdata('role_id')==4){
											$key="delivery_boy_data";
										}
										if($this->session->userdata('role_id')==5){
											$key="service_provider_data";
										}
										
										?>
										<a href="<?php echo $this->session->userdata('url');?>">Welcome <?php echo $this->session->userdata($key)['first_name'];?></a>
										<?php
									}else{
 										?>
 										<?php
										if($this->session->userdata('language')=='en'){
											?>

										<a href="<?php echo base_url('login');?>">Login</a>
										<span>|</span>										
											<?php
										}else if($this->session->userdata('language')=='ar'){
											?>

										<a href="<?php echo base_url('login');?>">?????????? ????????????</a>
 										<?php
										}
										?>


											<?php
										if($this->session->userdata('language')=='en'){
											?>

										<a href="<?php echo base_url('registration-step-one');?>">Register</a>
 											<?php
										}else if($this->session->userdata('language')=='ar'){
											?>

										<a href="<?php echo base_url('registration-step-one');?>">??????????
</a>
 										<?php
										}
										?>



										<?php
									}
									
									?>
									</div>
									<!-- <div class="accountLogin" style="display: none;"><i class="fas fa-user-circle"></i> <span>Ashish</span></div> -->
								</li>
								<!-- <li class="growerAccount">
									<a href="" class="">Register Growers</a>
								</li> -->
							</ul>
						</div>
					</div>
				</div>
				<div class="mianHead">
					<div class="container-fluid">
						<nav class="navbar navbar-expand-sm navbar-expand">
						<?php
									$settings=getSettings();

									if($this->session->userdata('language')=='en'){
										if(is_file('attachments/pages/main/'.$settings['logo'])){
											?>
									 <a href="<?php echo base_url();?>" class="navbar-brand"><img src="<?php echo base_url('attachments/pages/main/'.$settings['logo'])?>"></a>
										<?php
										}else{
											?>
											<a href="<?php echo base_url();?>" class="navbar-brand"><img src="<?php echo base_url();?>/assets/frontend/images/logo.png"></a>
											<?php
										}
									 }else{
										if(is_file('attachments/pages/main/'.$settings['arabic_logo'])){
											?>
									 <a href="<?php echo base_url();?>" class="navbar-brand"><img src="<?php echo base_url('attachments/pages/main/'.$settings['arabic_logo'])?>"></a>
										<?php
										}else{
											?>
											<a href="<?php echo base_url();?>" class="navbar-brand"><img src="<?php echo base_url();?>/assets/frontend/images/arabic_logo.png"></a>
											<?php
										}
									 }

 
									?>

							<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar">
								<i class="fas fa-bars"></i>
							</button>
							<div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
								<ul class="navbar-nav navbar-right">
									<li class="nav-item">
										<?php
										if($this->session->userdata('language')=='en'){
											?>
											<a class="nav-link" href="<?php echo base_url();?>">Home</a>
											<?php
										}else if($this->session->userdata('language')=='ar'){
											?>
											<a class="nav-link" href="<?php echo base_url();?>">???????????? ????????????????</a>
											<?php
										}
										?>
										
									</li>
									<li class="nav-item">
									<?php
										if($this->session->userdata('language')=='en'){
											?>
										<a class="nav-link" href="<?php echo base_url('about-us');?>">About us</a>
											<?php
										}else if($this->session->userdata('language')=='ar'){
											?>
											<a class="nav-link" href="<?php echo base_url('about-us');?>">?????????????? ??????
</a>
											<?php
										}
										?>


									</li>

									<li class="nav-item">
										<?php
										if($this->session->userdata('language')=='en'){
											?>
										<a class="nav-link" href="<?php echo base_url('our-team');?>">Our team</a>
											<?php
										}else if($this->session->userdata('language')=='ar'){
											?>
											<a class="nav-link" href="<?php echo base_url('our-team');?>">????????????</a>
											<?php
										}
										?>


										
									</li>

									<li class="nav-item">
										<?php
										if($this->session->userdata('language')=='en'){
											?>
										<a class="nav-link" href="<?php echo base_url('contact-us');?>">Contact us</a>
											<?php
										}else if($this->session->userdata('language')=='ar'){
											?>
											<a class="nav-link" href="<?php echo base_url('contact-us');?>">???????? ??????
</a>
											<?php
										}
										?>

									</li>
									 
									<!--<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
											Products
										</a>
										<div class="dropdown-menu">
											<a class="dropdown-item" href="<?php echo base_url('products');?>">Link 1</a>
											<a class="dropdown-item" href="<?php echo base_url('products');?>">Link 2</a>
											<a class="dropdown-item" href="<?php echo base_url('products');?>">Link 3</a>
										</div>
									</li>
									 
									<li class="nav-item">
										<a class="nav-link" href="<?php echo base_url('contact-us');?>">Contact</a>
									</li>-->
								</ul>
							</div>
							<div class="mhEcom d-flex">
								<!---->
								<div class="mhBag"><a href="<?php echo base_url('cart');?>"><i class="fas fa-shopping-cart"></i> <span class="badge" id="cart_counter"><?php echo totalCartItem();?></span></a></div>
								<div class="mhWish"><a href="<?php echo base_url('wishlist');?>" class=""><i class="fa fa-heart"></i> <span class="badge" id="wish_counter"><?php echo totalWishList();?></span></a></div>
							</div>
						</nav>
					</div>
				</div>
			</header>