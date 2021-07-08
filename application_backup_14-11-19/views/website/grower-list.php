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
													<a href="javascript:void(0);" class="menuToggle change_category" cat_value="<?php echo $category['id'];?>"><?php echo $category['name'];?></a>
													<?php
													$child_categories=categoryList(array('c.parent_id'=>$category['id'],'c.status'=>1));
													if(count($child_categories)>0){
														?>
														<ul class="subMneu">
															<?php
															foreach($child_categories as $child_category){
																?>
																<a href="javascript:void(0);" class="change_category" cat_value="<?php echo $child_category['id'];?>"><?php echo $child_category['name'];?></a>
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
								</div>
								 

								<div class="leftAd">
								<p><img src="<?php echo base_url();?>/assets/frontend/images/ad1.jpg"></p>
									<p><img src="<?php echo base_url();?>/assets/frontend/images/ad2.jpg"></p>
								</div>
							</div>
							<div class="prdRt">

								<div class="prdContent">
									<div class="mb-3"><img src="<?php echo base_url();?>/assets/frontend/images/f-ad1.jpg"></div>

									<div class="prdContentSort border bg-white pt-2 pb-2 pl-3 pr-3 mb-3" >
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
									<div id="grower-list">	
									<div class="loading text-center" id="srvLoader" style="display:none;"></div>	
										<div class="prdList gwrList fullList">
											<ul class="d-flex flex-wrap">
												<?php
												 foreach($growers as $grower){
													 ?>
													 <li>
													<div class="msProItem">
													
														<div class="msProImg">
														<?php
															if(is_file('attachments/users/main/'.$grower['image'])){
															?>
															<img src="<?php echo base_url('attachments/users/main/'.$grower['image'])?>">
															<?php
															}else{
																?>
															<img src="<?php echo base_url();?>/assets/frontend/images/prd1.jpg">
																<?php
															}
															?>
 														</div>

														<div class="msProText">
														<div class="prName"><strong><?php echo $grower['first_name'].' '.$grower['last_name'];?></strong></div>
															<div class="starDisplay">
																<span><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i></span>
															</div>
															<div class="gwrLocation mb-2">
																<i class="fas fa-map-marker-alt"></i>
																<span>Grower location, <?php echo $grower['address'];?> <?php echo $grower['zip'];?></span>
 															</div>
															<p><?php echo $grower['firm_description'];?></p>
															<a href="<?php echo base_url('products/'.$grower['slug']);?>" class="btn viewBtn">View Products</a>
														</div>
													</div>
												</li>
													 <?php
												 }
												 ?>
												
											</ul>
										</div>
 
										<div class="msPagination mt-3" id="pagination-section">
										<?php echo $this->ajax_pagination->create_links(); ?>
										</div>
									</div>
									<input type="hidden" name="vendor_latitude" id="vendor_latitude" value="<?php echo $latitude;?>">
									<input type="hidden" name="vendor_longitude" id="vendor_longitude" value="<?php echo $longitude;?>">

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
			var category_id='';
			 $(function(){
				$('.change_category').click(function(){
					category_id=$(this).attr('cat_value');
 					if(category_id>0){
						searchFilter(0)
					}
				})
			 })
		function searchFilter(page_num) {
			page_num = page_num?page_num:0;
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>website/growerListAjax/'+page_num,
				data:{
					'page':page_num,
					'category_id':category_id,
					'latitude':$('#vendor_latitude').val(),
					'longitude':$('#vendor_longitude').val(),
				},
				beforeSend: function () {
					$('#srvLoader').html(loader);
					$('#srvLoader').show();
				},
				success: function (html) {
					$('#grower-list').html(html);
					$('#srvLoader').hide();
				}
			});
		}
		</script>
			 