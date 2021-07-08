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
				<div class="serviceWrapper">
					<div class="container-fluid">
						<div class="prdContainer d-flex flex-wrap">
							<div class="prdLt">
								<div class="prdFilter prdCategory">
									<h6>Service Categories</h6>
									<div class="catMenu" id="catMenu">
									<ul class="menu">
										<?php 
											$categories=getServicesCategories(array('sc.is_deleted'=>0,'sc.status'=>1));
											foreach($categories as $category){
												?>
											<li>
												<a href="javascript:void(0);" class="menuToggle change_category" parent_slug="" slug="<?php echo $category['slug'];?>" is_parent="1" cat_value="<?php echo $category['id'];?>"><?php echo $category['name'];?></a>
												<?php
												$serviceslist=getServices(array('sps.service_category_id'=>$category['id'],'sps.status'=>1,'sps.is_deleted'=>0));
												if(count($serviceslist)>0){
													?>
													<ul class="subMneu">
														<?php
														foreach($serviceslist as $service){
															?>
															<a href="javascript:void(0);" class="change_category" parent_slug="<?php echo $category['slug'];?>" slug="<?php echo $service['slug'];?>" is_parent="0" cat_value="<?php echo $service['id'];?>"><?php echo $service['name'];?></a>
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
								<div class="prdFilter prdPrice" style="display:none;">
									<h6>By Price</h6>
									<div class="rangeBlock">
										<div class="range-slider"><input type="text" class="js-range-slider" id="price-slider" value="" /></div>
										<div class="rangeInput">
											<input type="text" class="js-input-from" id="minPrice" readonly />
											<input type="text" class="js-input-to" id="maxPrice" readonly />
										</div>
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

									<div class="prdContentSort border bg-white pt-2 pb-2 pl-3 pr-3 mb-3" style="display:none;" >
										<div class="d-flex align-items-center">
											<div class="prdListFilter">
												<a href="" class="thFilter d-inline-block"><i class="fas fa-th"></i></a>
												<a href="" class="fullFilter d-inline-block"><i class="fas fa-list"></i></a>
											</div>
										 
											<div class="d-flex ml-auto align-items-center" style="max-width: 260px;">
												<span class="mr-2 text-nowrap">Sort By:</span>
												<select class="form-control">
													<option>Relevance</option>
													<option>Popularity</option>
												</select>
											</div>
										</div>
									</div>
									<div id="service-list-section">
									<div class="loading text-center" id="srvLoader" style="display:none;"></div>
									<div class="prdList">
										<ul class="d-flex flex-wrap">
										<?php
										
										if(count($services)>0){
										foreach($services as $service){
											?>
											<li>
												<div class="msProItem">
													<div class="msProImg">
														<div class="msfTag">
															<div class="msfLabel new">New</div>
															<!--<div class="msfLabel discount">-5%</div>-->
 														</div>
														<a href="<?php echo base_url('service-details/'.$service['slug']);?>">
 														<?php if(is_file('attachments/services/medium/'.$service['image'])){ ?>
               											<img  src="<?php echo base_url('attachments/services/medium/'.$service['image'])?>" >
 			 
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
														<div class="prName"><a href="<?php echo base_url('service-details/'.$service['slug']);?>"><strong><?php echo $service['name'];?></strong></a></div>
														<div class="starDisplay">
															<span><i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="fas fa-star-half-alt"></i>
															<i class="far fa-star"></i>
															<i class="far fa-star"></i>
															</span>
														</div>
														<div class="d-flex align-items-center">
															<div class="msfPrice"><!--<del>$60.00</del>--> <span>$<?php echo $service['price'];?></span></div>
															<!--<button class="btn addCartBtn" id="addToCart"><span id="added">Add to Cart</span></button>-->
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
			<?php
			 $this->load->view('website/includes/footer');
			?>
		<script>
		var search_id='';
		$(function(){
			$('.change_category').click(function(){
				search_id=$(this).attr('cat_value');
				slug=$(this).attr('slug');
				parent_slug=$(this).attr('parent_slug');
				$('#search_type_id').val($(this).attr('is_parent'));
				if(search_id>0){
					var CURRENTURL= window.location.href; 
      				var new_url='<?php echo base_url('services')?>';
					if(parent_slug!=''){
						new_url +='/'+parent_slug+'/'+slug;
					}else{
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
				url: '<?php echo base_url(); ?>website/serviceListAjax/'+page_num,
				data:{
					'page':page_num,
					'search_id':search_id,
					'search_type_id':$('#search_type_id').val(),
   				},
				beforeSend: function () {
					$('#srvLoader').html(loader);
					$('#srvLoader').show();
				},
				success: function (html) {
					$('#service-list-section').html(html);
					$('#srvLoader').hide();
				}
			});
		}
		</script>