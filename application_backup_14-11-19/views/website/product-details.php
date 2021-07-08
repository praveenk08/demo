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
											<span>
											<?php 
											echo $average_review=$product['average_review'];
											$fraction = $average_review - intval($average_review);
											$mark_pointer=0;
											if($fraction>0){
												$mark_pointer=intval($average_review)+1;
											}
 											for($i=1;$i<=5;$i++){
												
 												if($average_review>=$i){
													?>
													<i class="fas fa-star"></i>
													<?php
												}else{
													if($i==$mark_pointer){
 														?>
														<i class="fas fa-star-half-alt"></i>
														<?php
													}else{
														?>
														<i class="far fa-star"></i>
														<?php
													}
													?>
													<?php
												}
												?>
												
												<?php
											}
											?>
											 
											</span>
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
									 <div class="reviewInfo">
											<span class="starCount"><?php echo $product['average_review'];?>
											<span>
											<?php
											for($i=1;$i<=5;$i++){
												
												if($average_review>=$i){
												   ?>
												   <i class="fas fa-star"></i>
												   <?php
											   }else{
												   if($i==$mark_pointer){
														?>
													   <i class="fas fa-star-half-alt"></i>
													   <?php
												   }else{
													   ?>
													   <i class="far fa-star"></i>
													   <?php
												   }
												   ?>
												   <?php
											   }
											   ?>
											   
											   <?php
										   }
										   ?>
											</span>
											</span>
											<small class="reviewCount"><?php echo count($reviews);?> Reviews</small>
										</div>
										<ul class="rateReviewList">
										<?php
										foreach($reviews as $review){
											?>
											<li>
											<h5><?php echo $review['customer_name'];?></h5>
											<p class="ratingCount">
											<span class="rate4">
											<?php
 											for($i=1;$i<=5;$i++){
												if($i<=$review['rating']){
													$rate="fas fa-star";
												}else{
													$rate ="far fa-star";
												} 
												?>
												<i class="<?php echo $rate;?>"></i>
												<?php
											}
											?>
											 </span>
											 <?php echo $review['added_date']; echo strlen($review['review']);?></p>
											<p>
											<span id="max_part<?php echo $review['id'];?>" style="display:none;">
											<?php echo $review['review'];?> <a href="javascript:void(0)" onClick="showMoreData('<?php echo $review['id'];?>')">Less..</a></span>
											<span id="min_part<?php echo $review['id'];?>">
											<?php if(strlen($review['review'])>50){echo substr($review['review'],0,50); ?>
											<a href="javascript:void(0)" onClick="showMoreData('<?php echo $review['id']?>')"> More..</a><?php }else{ echo $review['review'];} ?>
											</span>
											<input type="hidden" id="show_hide<?php echo $review['id'];?>" value="0"/>
											</p>
											</li>
											<?php
										}
										?>
										 
										</ul>
										<?php if($rating_applicable) { ?>
										<div class="writeReviewBox card bg-light">
											<div class="card-body">
											<div id="rating_success_message"></div>
											<h6><i class="fas fa-pencil-alt"></i> Write a review</h6>
											<form id="rating_form">
											<div class="form-group">
												<div class="rateExp d-flex flex-wrap align-items-center justify-content-between">
													<label>Please rate your experience <i class="fa fa-arrow-right"></i></label>
													<div class="rating-stars" id="rating">
													<input type="hidden" readonly="readonly" name="rating-stars-value" id="rating-stars-value" class="rating-value hidden" name="rating-stars-value">
													<input type="hidden" name="vendor_product_id" id="vendor_product_id" value="<?php echo $product['vendor_product_id'];?>" >
														<div class="d-flex">
															<div class="rating-star">
																<i class="fas fa-star"></i>
															</div>
															<div class="rating-star">
																<i class="fas fa-star"></i>
															</div>
															<div class="rating-star">
																<i class="fas fa-star"></i>
															</div>
															<div class="rating-star">
																<i class="fas fa-star"></i>
															</div>
															<div class="rating-star">
																<i class="fas fa-star"></i>
															</div>
														</div>
													</div>
												</div>
												<span id="rating-stars-value_error" class="error"></span>
												</div>
												<div class="form-group">
													<textarea class="form-control" id="comment" name="comment" placeholder="Comment" rows="3"></textarea>
													<span id="comment_error" class="error"></span>
												</div>
												<div class="submitReview text-right">
												<button class="btn btn-warning reviewBtn" id="rate_now">Submit Review</button>
												</div>
											</form>
											</div>
										</div>
									<?php } ?>
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
			  function showMoreData(id){
				var show_hide_status=$('#show_hide'+id).val();
				if(show_hide_status==0){
					$('#max_part'+id).show();
					$('#min_part'+id).hide();
					$('#show_hide'+id).val(1);
				}else{
					$('#max_part'+id).hide();
					$('#min_part'+id).show();
					$('#show_hide'+id).val(0);
				}
			}

			 $(function(){
		 
				$('#rate_now').click(function(){
				$('#rate_now').attr("disabled", true);
				$('#rating_form textarea').css('border', '1px solid #ccc');
				$('#rating_success_message').html('');
				$('.error').html('');
				$.ajax({
					type: "POST",
					url: urls.rating,
					data: $('#rating_form').serialize(),
					success: function(ajaxresponse){
						response=JSON.parse(ajaxresponse);
						if(!response['status']){
							$.each(response['response'], function(key, value) {
								$('#' + key).css('border', '1px solid #cc0000');
								$('#'+key+'_error').html(value);
							});
							$('#rating_success_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
							$('#rate_now').removeAttr("disabled");
						}else{
							$('#rating_success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
							$('#comment').val('');
							$('#rate_now').removeAttr("disabled");
							setTimeout(function(){
								$('#rating_success_message').html('');
							}, 3000);
						}  
					}
				});
			})
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
