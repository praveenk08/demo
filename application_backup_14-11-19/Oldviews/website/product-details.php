<?php
			 $this->load->view('website/includes/header');
			 ?>
			<link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" rel="stylesheet" />
			<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5d8c823b0080f50012d940d4&product=inline-share-buttons' async='async'></script>


			<!-- Main body wrapper -->
			<div class="mainBody">
				<div class="msBreadcrumb">
					<div class="container-fluid">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
							<li class="breadcrumb-item"><a href="<?php echo base_url('cart');?>">Shop</a></li>
							<li class="breadcrumb-item active">Product</li>
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
										$products_images=explode(',',$product['images']);
 									?>
										<div class="mainSlide slider">
											
											<?php
											$total_images=count($products_images);
											if($total_images>0){
												foreach($products_images as $products_image){

													if(is_file('attachments/products/medium/'.$products_image)){
													?>
													<div class="mainSlideItem">
													<img src="<?php echo base_url('attachments/products/medium/'.$products_image)?>">
													</div>
													<?php
													} 
														 
												}
											}
											?>
										</div>

										
										<div class="thumbSlide slider">
										<?php
											$total_mages=count($products_images);
											if($total_images>0){
												foreach($products_images as $products_image){

													if(is_file('attachments/products/thumb/'.$products_image)){
													?>
													<div class="thumbSlideItem">
													<img src="<?php echo base_url('attachments/products/thumb/'.$products_image)?>">
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
										<div class="prName"><strong><?php echo $product['name'];?></strong></div>
										<div class="starDisplay">
											<span><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i></span>
										</div>
										<div class="msfPrice"><!--<del>$60.00</del> --><span>$<?php echo $product['price'];?></span></div>
										<?php echo $product['brief'];?>
										<div class="stock"><i class="fas fa-check-circle"></i>&nbsp;<span><?php echo $product['quantity'];?> In Stock</span></div>
										<div class="maturityDate"><span>Maturity Date:</span>&nbsp;<strong>12 Dec 2019</strong></div>
										<div class="prdUnit btn"><?php echo $product['unit_value'];?>   <?php echo $product['unit_name'];?></div>
										<div class="prdBottom d-flex flex-wrap text-nowrap">
											<div class="input-group pdQty">
											<span class="btn msMinus"><i class="fa fa-minus"></i></span>
											
											<input type="text" class="form-control allownumericwithoutdecimal" value="1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="quantity" id="quantity">
											<span class="btn msPlus"><i class="fa fa-plus"></i></span>
											</div>
											<input type="hidden" name="product_id" id="product_id" value="<?php echo $product['vendor_product_id'];?>" >
											<div class="addToCart"><button class="btn addCartBtn" id="addToCart"><i class="fas fa-shopping-basket"></i>&nbsp;<span id="added">Add to Cart</span></button></div>
											<div class="saveLater"><a class="wishlist-item" onclick="addRemoveWishList('<?php echo $product['vendor_product_id'];?>')" id="<?php echo $product['vendor_product_id'];?>"><?php if($product['vendor_product_id']==$product['wish_product_id']){ ?> <i class='fas fa-heart'></i> <?php }else{ ?> <i class='far fa-heart'></i> <?php }?></a></div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="prdAdditionalInfo">
							<ul class="nav nav-tabs">
								<li class="nav-item"><a href="#prdDesc" class="nav-link active" data-toggle="tab">Description</a></li>
 								<li class="nav-item "><a href="#prdReview" class="nav-link" data-toggle="tab">Reviews</a></li>
							</ul>
							<div class="tab-content border p-3 border-top-0">
								<div class="tab-pane active" id="prdDesc">
									<div class="additionalInfo"><?php echo $product['description'];?></div>
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
					if(parseInt(this.value)<1 || parseInt(this.value)==''){
 						$('#success_message').html('<div class="alert alert-danger">Opps Product quantity must be one or greater than one!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
						closePopup('success_message');
						$('#addToCart').attr('disabled', true);
					}else if(parseInt(this.value)>'<?php echo $product['quantity'];?>'){
  						$('#success_message').html('<div class="alert alert-danger">Opps product quantity exceeded!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
						closePopup('success_message');
						$('#addToCart').attr('disabled', true);
					}else{
						$('#addToCart').removeAttr('disabled');
						$('#success_message').html('');
					}
				})
				$('#addToCart').click(function(){
					$('#success_message').html('');
					var product_id=$('#product_id').val();
					var quantity=parseInt($('#quantity').val());
					if(quantity<1){
						$('#success_message').html('<div class="alert alert-danger">Opps Product quantity must be one or greater than one!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
						closePopup('success_message');
 					}else if(quantity>'<?php echo $product['quantity'];?>'){
 						$('#success_message').html('<div class="alert alert-danger">Opps product quantity exceeded!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
						closePopup('success_message');
 					}else{
						 if(quantity>0 && quantity!=''){
							addProductToCart(product_id,quantity);
						 }else{
							$('#success_message').html('<div class="alert alert-danger">Opps Product quantity must be one or greater than one!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
							closePopup('success_message');
						 }
					}
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
