<?php
	if($this->session->userdata('language')=='en'){
		$home_label="Home";
		$shop_label="Shop";	
		$service_label="Service";	
		$service_category_label="Service Category";
		$provider_name_label="Provider Name";
		$description_lebel="Description";
	}else{		
		$home_label="الصفحة الرئيسية";
		$shop_label="متجر";	
		$service_label="الخدمات";	
		$service_category_label="فئة الخدمة";
		$provider_name_label="اسم المزود";
		$description_lebel="وصف";
	 }
			 $this->load->view('website/includes/header');
			 ?>
			<link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" rel="stylesheet" />
			<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5d8c823b0080f50012d940d4&product=inline-share-buttons' async='async'></script>


			<!-- Main body wrapper -->
			<div class="mainBody">
				<div class="msBreadcrumb">
					<div class="container-fluid">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url();?>"><?=$home_label;?></a></li>
							<li class="breadcrumb-item"><a href="<?php echo base_url('cart');?>"><?=$shop_label;?>p</a></li>
							<li class="breadcrumb-item active"><?=$service_label;?></li>
						</ol>
					</div>
				</div>

				<div class="productWrapper">
					<div class="container-fluid">
						<div class="prdDetail">
						<div id="success_message"></div>
							<div class="row">
								<div class="col-md-5">
									<div class="prdGallery">
									<?php
										$service_images=explode(',',$service['images']);
 									?>
										<div class="mainSlide slider">
											
											<?php
											$total_images=count($service_images);
											if($total_images>0){
												foreach($service_images as $service_image){

													if(is_file('attachments/services/medium/'.$service_image)){
													?>
													<div class="mainSlideItem">
													<img src="<?php echo base_url('attachments/services/medium/'.$service_image)?>">
													</div>
													<?php
													} 
														 
												}
											}
											?>
										</div>

										
										<div class="thumbSlide slider" style="display:none;">
										<?php
											$total_mages=count($service_images);
											if($total_images>0){
												foreach($service_images as $service_image){

													if(is_file('attachments/services/thumb/'.$service_image)){
													?>
													<div class="thumbSlideItem">
													<img src="<?php echo base_url('attachments/services/thumb/'.$service_image)?>">
													</div>
													<?php
													} 
														 
												}
											}
											?>
										</div>
									</div>
								</div>
								<div class="col-md-7">
									<div class="detailContent">
										<div class="prName"><strong><?php echo $service['name'];?></strong></div>
										<div class="prName"><strong><?=$service_category_label;?>: <?php echo $service['category_name'];?></strong></div>
										<div class="prName"><strong><?=$provider_name_label;?>: <?php echo $service['provider_name'];?></strong></div>


										<!--<div class="starDisplay">
											<span><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i></span>
										</div>-->
										<div class="msfPrice"><span>$<?php echo $service['price'];?></span></div>
 										 
									</div>
								</div>
							</div>
						</div>

						<div class="prdAdditionalInfo">
							<ul class="nav nav-tabs">
								<li class="nav-item"><a href="#prdDesc" class="nav-link active" data-toggle="tab"><?=$description_lebel;?></a></li>
 								<li class="nav-item " style="display:none;"><a href="#prdReview" class="nav-link" data-toggle="tab">Reviews</a></li>
							</ul>
							<div class="tab-content border p-3 border-top-0">
								<div class="tab-pane active" id="prdDesc">
									<div class="additionalInfo"><?php echo $service['description'];?></div>
								</div>
								 
								<div class="tab-pane fade" id="prdReview">
									<div class="additionalInfo">
									 Reviews
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
			 <script>
			 $(function(){
				$('#quantity').keyup(function(){
					if(this.value<1 || this.value>'<?php echo $product['quantity'];?>'){
 						$('#addToCart').attr('disabled', true);
					}else{
						$('#addToCart').removeAttr('disabled');
					}
				})
				$('#addToCart').click(function(){
					$.ajax({
						type: 'POST',
						url: '<?php echo base_url(); ?>cart/addProductToCart',
						data:{
							'quantity':$('#quantity').val(),
							'product_id':$('#product_id').val(),
 						},
						success: function (ajaxresponse) {
							response=JSON.parse(ajaxresponse);
							if(response['status']){
								$('#cart_counter').html(response['total_cart']);
								$('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
							}
						}
					});	 
				})
			 })
			 $('.mainSlide').slick({
				  slidesToShow: 1,
				  slidesToScroll: 1,
				  arrows: false,
				  fade: true,
				  centerMode: true,
				  asNavFor: '.thumbSlide'
				});
				$('.thumbSlide').slick({
				  slidesToShow: 4,
				  slidesToScroll: 1,
				  asNavFor: '.mainSlide',
				  dots: false,
				  arrows: false,
				  margin: 15,
				  focusOnSelect: true
				});
			 </script>
