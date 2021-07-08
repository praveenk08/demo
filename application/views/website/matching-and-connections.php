<?php
			 $this->load->view('website/includes/header');
			 $settings=getSettings();
			 if($this->session->userdata('language')=='en'){
				 $home_label="Home";
				 $shop_label="Shop";
				 $categories_label="Category";
				 $no_record_found_label="No Record Found!";
				 $by_price_label="By Price";
				 $by_maturity_date_label="By Maturity Date";
				 $new_label="New";
				 $added_label="Added";
				$add_to_cart_label="Add to Cart";
			 }else{
				$home_label="الصفحة الرئيسية";
				$shop_label="متجر";
				$categories_label="الفئة";
				$no_record_found_label="لا يوجد سجلات!";
				$by_price_label="حسب السعر";
				$by_maturity_date_label="حسب تاريخ الاستحقاق";
				$new_label="الجديد";
				$added_label="وأضاف";
				$add_to_cart_label="أضف إلى السلة";

			 }
			 ?>
			
			<!-- Main body wrapper -->
			<div class="mainBody">
				<div class="msBreadcrumb">
					<div class="container-fluid">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url();?>"><?php echo $home_label;?></a></li>
							<li class="breadcrumb-item active"><?php echo $shop_label;?></li>
						</ol>
					</div>
				</div>
				<div class="productWrapper">
					<div class="container-fluid">
						<div class="prdContainer d-flex flex-wrap">
							<div class="prdLt">
								<input type="checkbox" id="filterMenu">
								<label for="filterMenu"><i class="fas fa-filter"></i><span>Menu</span></label>
								<div class="filterList">
									<div class="prdFilter prdCategory">
										<h6><?php echo $categories_label;?></h6>
										<div class="catMenu" id="catMenu">
										<ul class="menu">
											<?php 
												$categories=categoryList(array('c.parent_id'=>0,'c.status'=>1,'ct.abbr'=>$this->session->userdata('language')));
												foreach($categories as $category){
													?>
												<li>
													<a href="javascript:void(0);" class="menuToggle change_category" slug="<?php echo $category['slug'];?>"  is_parent="1" cat_value="<?php echo $category['id'];?>"><?php echo $category['name'];?></a>
													<?php
													$child_categories=categoryList(array('c.parent_id'=>$category['id'],'c.status'=>1,'ct.abbr'=>$this->session->userdata('language')));
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
										<h6><?php echo $by_price_label;?></h6>
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
										<h6><?php echo $by_maturity_date_label;?></h6>
										<div id="calendar2" class="vanilla-calendar" style="width: 100%;"></div>
									</div>
											
								</div>
								<div class="leftAd">
									<p><img src="<?php echo base_url();?>/assets/frontend/images/ad1.jpg"></p>
									<p><img src="<?php echo base_url();?>/assets/frontend/images/ad2.jpg"></p>
								</div>
							</div>
							<div class="prdRt">

								<div class="prdContent">
									<div class="mb-3">
									<?php
									if(is_file('attachments/pages/main/'.$settings['product_banner']) ){
										?>
 									<img src="<?php echo base_url('attachments/pages/main/'.$settings['product_banner'])?>">
									<?php
									}else{
										?>
										<img src="<?php echo base_url();?>/assets/frontend/images/f-ad1.jpg">>
										<?php
							}
							?>
									</div>


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
															<div class="msfLabel new"><?php echo $new_label;?></div>
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
															<span>
															<?php 
															$average_review=$product['average_review'];
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
														<div class="d-flex align-items-center">
															<div class="msfPrice"><!--<del>$60.00</del>--> <span>$<?php echo $product['price'];?></span></div>
															<?php if($product['vendor_product_id']==$product['cd_product_id']){
																?>
															<button class="btn addCartBtn" id="<?php echo $product['vendor_product_id'];?>" ><span id="added<?php echo $product['vendor_product_id'];?>"><?php echo $added_label;?></span></button>
																<?php
															}else{
																?>
																<button class="btn addCartBtn" id="<?php echo $product['vendor_product_id'];?>" ><span id="added<?php echo $product['vendor_product_id'];?>"><?php echo $add_to_cart_label;?></span></button>
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
											<li><?php echo $no_record_found_label;?></li>
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
 
  			<input type="hidden" name="maturity_date" id="maturity_date" value="">

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
		

		let calendar = new VanillaCalendar({
			selector: "#calendar2",
			shortWeekday: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
			onSelect: (data) => {
				var dateObj = new Date(data.date);
				var momentObj = moment(dateObj);
				var momentString = momentObj.format('YYYY-MM-DD'); // 2016-07-15
				$('#maturity_date').val(momentString);
 				searchFilter(0);
				}
			});
 
	    $('.change_category').click(function(){
			category_id=$(this).attr('cat_value');
			slug=$(this).attr('slug');
			is_parent=$(this).attr('is_parent');
				if(category_id>0){
 					var CURRENTURL= window.location.href; 
      				var new_url='<?php echo base_url('matching-and-connections')?>';
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
				url: '<?php echo base_url(); ?>website/matchingAndConnectionsAjax/'+page_num,
				data:{
					'page':page_num,
 					'min_price':$('#minPrice').val(),
					'max_price':$('#maxPrice').val(),
 					'maturity_date':$('#maturity_date').val(),
                    'search_id':category_id,
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