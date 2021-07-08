<?php
			 $this->load->view('website/includes/header');
			 ?>
			
			<!-- Main body wrapper -->
			<div class="mainBody">
				<div class="msBreadcrumb">
					<div class="container-fluid">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Shop</li>
						</ol>
					</div>
				</div>
				<div class="productWrapper">
					<div class="container-fluid">
						<div class="prdContainer d-flex flex-wrap">
							<div class="prdLt">
								<input type="checkbox" id="filterMenu">
								<label for="filterMenu"><i class="fas fa-filter"></i> <span>Menu</span></label>
								<div class="filterList">
									<div class="prdFilter prdCategory">
										<h6>Categories</h6>
										<div class="catMenu" id="catMenu">
										<ul class="menu">
											<?php 
												$categories=categoryList(array('c.parent_id'=>0,'c.status'=>1));
												foreach($categories as $category){
													?>
												<li>
													<a href="javascript:void(0);" class="menuToggle change_category" slug="<?php echo $category['slug'];?>"  is_parent="1" cat_value="<?php echo $category['id'];?>"><?php echo $category['name'];?></a>
													<?php
													$child_categories=categoryList(array('c.parent_id'=>$category['id'],'c.status'=>1));
													if(count($child_categories)>0){
														?>
														<ul class="subMneu">
															<?php
															foreach($child_categories as $child_category){
																?>
																<a href="javascript:void(0);" class="change_category" slug="<?php echo $child_category['slug'];?>" is_parent="0" cat_value="<?php echo $child_category['id'];?>"><?php echo $child_category['name'];?></a>
																<?php
															}
															?>
														</ul>
														<?php
													}
													?>
													
												</li>
												<?php
												} 
												?>
											</ul>
										</div>
									</div>

									<!-- Range Slider -->
									<div class="prdFilter prdPrice">
										<h6>By Price</h6>
										<div class="rangeBlock">
											<div class="range-slider">
											<input type="text" class="js-range-slider" id="price-slider" value="" /></div>
											<div class="rangeInput">
												<input type="text" class="js-input-from" id="minPrice" readonly />
												<input type="text" class="js-input-to" id="maxPrice" readonly />
	
 										</div>
										</div>
									</div>

									<!-- Maturity Date -->
									<div class="prdFilter prdMaturity">
										<h6>By Maturity Date</h6>
										<div id="calendar2" style="width: 100%;"></div>
									</div>
											
								</div>
								<div class="leftAd">
									<p><img src="<?php echo base_url();?>/assets/frontend/images/ad1.jpg"></p>
									<p><img src="<?php echo base_url();?>/assets/frontend/images/ad2.jpg"></p>
								</div>
							</div>
							<div class="prdRt">

								<div class="prdContent">
									<div class="mb-3"><img src="<?php echo base_url();?>/assets/frontend/images/f-ad1.jpg"></div>


									<div class="prdContentSort border bg-white pt-2 pb-2 pl-3 pr-3 mb-3"  style="display:none;">
										<div class="d-flex align-items-center">
											<div class="prdListFilter">
												<a href="" class="thFilter d-inline-block"><i class="fas fa-th"></i></a>
												<a href="" class="fullFilter d-inline-block"><i class="fas fa-list"></i></a>
											</div>
										 
											<div class="d-flex ml-auto align-items-center" style="max-width: 260px;display:none;">
												<span class="mr-2 text-nowrap">Sort By:</span>
												<select class="form-control">
													<option>Relevance</option>
													<option>Popularity</option>
												</select>
											</div>
										</div>
									</div>
									<div id="success_message"></div>
									<div id="product-list-section">
									<div class="loading text-center" id="srvLoader" style="display:none;"></div>
									<div class="prdList">
										<ul class="d-flex flex-wrap">
										<?php
										if(count($products)>0){
  										foreach($products as $product){
											?>
											<li>
												<div class="msProItem">
													<div class="msProImg">
														<div class="msfTag">
															<div class="msfLabel new">New</div>
 															<!--<div class="msfLabel discount">-5%</div>-->
														 </div>
														<div class="wishIcon">
														<a class="wishlist-item" id="<?php echo $product['vendor_product_id'];?>">
														<?php if($product['vendor_product_id']==$product['wish_product_id']){ ?>
														<i class='fas fa-heart'></i>
														<?php }else{ ?>
														<i class='far fa-heart'></i><?php } ?>
														</a>
														</div>
														<a href="<?php echo base_url('product-details/'.$product['slug']);?>">
 														<?php if(is_file('attachments/products/medium/'.$product['image'])){ ?>
               											<img  src="<?php echo base_url('attachments/products/medium/'.$product['image'])?>" >
 			 
																<?php
															}else{
																?>
															<img src="<?php echo base_url();?>/assets/frontend/images/prd1.jpg">
																<?php
															}
															?>
															</a>
													</div>
													<div class="msProText">
														<div class="prName"><a href="<?php echo base_url('product-details/'.$product['slug']);?>"><strong><?php echo $product['name'];?></strong></a></div>
														<div class="starDisplay">
															<span><i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="fas fa-star-half-alt"></i>
															<i class="far fa-star"></i>
															<i class="far fa-star"></i>
															</span>
														</div>
														<div class="d-flex align-items-center">
															<div class="msfPrice"><!--<del>$60.00</del>--> <span>$<?php echo $product['price'];?></span></div>
															<?php if($product['vendor_product_id']==$product['cd_product_id']){
																?>
															<button class="btn addCartBtn" id="<?php echo $product['vendor_product_id'];?>" ><span id="added<?php echo $product['vendor_product_id'];?>">Added</span></button>
																<?php
															}else{
																?>
																<button class="btn addCartBtn" id="<?php echo $product['vendor_product_id'];?>" ><span id="added<?php echo $product['vendor_product_id'];?>">Add to Cart</span></button>
																<?php
															}
															?>
														</div>
													</div>
												</div>
											</li>
											<?php
										}
									}else{
										?>
											<li>No Record Found</li>
										<?php
									}
										?>
 										</ul>
									</div>

									<div class="msPagination mt-3" id="pagination-section">
										<?php echo $this->ajax_pagination->create_links(); ?>
									</div>
									</div>

								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="search_type_id" id="search_type_id" value="<?php echo $search_type_id;?>">
			<input type="hidden" name="search_id" id="search_id" value="<?php echo $search_id;?>">
			<input type="hidden" name="change_location" id="change_location" value="<?php echo $change_location;?>">
			<input type="hidden" name="location_type" id="location_type" value="<?php echo $location_type;?>">

			<?php
			$this->load->view('website/includes/footer');
			$min_price=getMinMaxProductPrice()[0]['min_price'];
			$maximum_price=getMinMaxProductPrice()[0]['max_price'];
			if(!($maximum_price % 10)){
				$max_price = $maximum_price;
			}
			else{
				$max_price = $maximum_price + (10 - ($maximum_price % 10));
			}
			?>

		<script>
			function AddProductInToCart(product_id){
				if(product_id>0){
					var status=addProductToCart(product_id,1);
				}
			}
			$(function(){
			$('.addCartBtn').click(function(){
				var product_id=$(this).attr('id');
				var quantity=1; 
				addProductToCart(product_id,quantity);
 				})
			})
// Trigger
$('#price-slider').on('change', function() {
		var min_price = jQuery('.irs-from').text();
		var max_price = jQuery('.irs-to').text();
 		$('#minPrice').val(min_price);
		$('#maxPrice').val(max_price);
 		searchFilter(0)
	});
 
	var category_id='';
	$(function () {
		$('#product-list-section .wishlist-item').click(function(){
			var id=$(this).attr('id');
			if(id>0){
				addRemoveWishList(id);
			}
 		})

    var $range = $("#price-slider"),
        $inputFrom = $("#minPrice"),
        $inputTo = $("#maxPrice"),
        instance, min = 0,
        max = '<?php echo $max_price;?>',
        from = 0,
		to = 0;
				
    $range.ionRangeSlider({
        type: "double",
        min: min,
        max: max,
        from: '<?php echo $min_price;?>',
        to: '<?php echo $max_price;?>',
        onStart: updateInputs,
        onChange: updateInputs,
        step: 10,
        prettify_enabled: false,
        prettify_separator: ".",
        values_separator: " - ",
        force_edges: true
    });
		
	instance = $range.data("ionRangeSlider");
		

    function updateInputs(data) {
        from = data.from;
        to = data.to;
        $inputFrom.prop("value", from);
        $inputTo.prop("value", to);
    }
    $inputFrom.on("input", function() {
        var val = $(this).prop("value");
        if (val < min) {
            val = min;
        } else if (val > to) {
            val = to;
        }
        instance.update({
            from: val
        });
    });
    $inputTo.on("input", function() {
        var val = $(this).prop("value");
        if (val < from) {
            val = from;
        } else if (val > max) {
            val = max;
        }
        instance.update({
            to: val
        });
		});
		

		$("#calendar2").MEC();
		//$("#calendar2").datepicker();
		//$('#calendar2').datepicker({
    		//format: 'mm-dd-yyyy',
    		//startDate: '1d'
 		//});
	    $('.change_category').click(function(){
			category_id=$(this).attr('cat_value');
			slug=$(this).attr('slug');
			is_parent=$(this).attr('is_parent');
				if(category_id>0){
 					var CURRENTURL= window.location.href; 
      				var new_url='<?php echo base_url('products')?>';
					if(slug!=''){
						new_url +='/'+slug;
					} 
	  				ChangeUrl(CURRENTURL,new_url);
					searchFilter(0)
				}
			})
		})
		
		function searchFilter(page_num) {
  		page_num = page_num?page_num:0;
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>website/productListAjax/'+page_num,
				data:{
					'page':page_num,
					'search_id':category_id,
					'min_price':$('#minPrice').val(),
					'max_price':$('#maxPrice').val(),
					'change_location':$('#change_location').val(),
					'location_type':$('#location_type').val(),
 				},
				beforeSend: function () {
					$('#srvLoader').html(loader);
					$('#srvLoader').show();
				},
				success: function (html) {
					$('#product-list-section').html(html);
					$('#srvLoader').hide();
				}
			});
		}
		</script>