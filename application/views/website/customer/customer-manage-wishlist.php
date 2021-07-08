
			 <?php
			 $this->load->view('website/includes/header');
			 if($this->session->userdata('language')=='en'){
				$home_label="Home";
				$wish_label="Wishlist";
				$thumb_label="Image";
				$product_label="Crop";
				$parent_category_name_label="Category";
				$category_name_label="Sub Category";
 				$total_label="Price";
				$remove_label="Remove";
				$no_record_label="No item found in your wishlist.";
				$continue_shoping_label="Continue Shopping";
				$cart_total_label="Cart Totals";
				$wish_list_heading_label="My Wishlist Crop";
  			}else{
				$home_label="الصفحة الرئيسية";
				$wish_label="الأماني";
				$thumb_label="صورة";
				$product_label="ا & قتصاص";
				$parent_category_name_label="الفئة";
				$category_name_label="تصنيف فرعي";
				$total_label="السعر";
				$remove_label="إزالة";
				$no_record_label="لم يتم العثور على أي عنصر في قائمة أمنياتك.";
				$continue_shoping_label="مواصلة التسوق";
				$cart_total_label="إجماليات السلة";
				$wish_list_heading_label="قائمة أمنياتي المنتج";
			}
			 ?>
			<!-- Main body wrapper -->
			<div class="mainBody">
				<div class="msBreadcrumb">
					<div class="container-fluid">
						<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>"><?php echo $home_label;?></a></li>
							<li class="breadcrumb-item active"><?php echo $wish_label;?></li>
						</ol>
					</div>
				</div>
				<div class="userWrapper">
					<div class="container-fluid">
						<div class="cwContainer">
							<div class="uwBox d-flex flex-wrap">
							<?php $this->load->view('website/customer/left-panel');?>

                            <div class="profileRt">
									<div class="gwrSalesOrder">
									<div class="gwrHead"><h5 class="dashTitle"><?php echo $wish_list_heading_label;?></h5></div>
									<div class="loading"></div>
									<div id="order-list-section">
									<div id="success_message"></div>

									<div class="loading text-center" id="srvLoader" style="display:none;"></div>
									<div class="cartTable">
								<form id="customerWishList">
							<table class="table table-bordered" id="wish_list_table">
							<thead>
									<tr>
											 <th class="moveWishlist"><input type="checkbox" name="check_all" id="check_all"  ></th>

										<th class="prImg"><?php echo $thumb_label;?></th>
										<th class="prDesc"><?php echo $product_label;?></th>
										<th class="prDesc"><?php echo $parent_category_name_label;?></th>
										<th class="prCName"><?php echo $category_name_label;?></th>
										<th class="prPrice"><?php echo $total_label;?></th>
 										<th class="prAction"><?php echo $remove_label;?></th>
									</tr>
								</thead>
								<tbody>
								<?php 
 								if(count($wishlists)>0){
									foreach($wishlists as $wishlist){
 										 ?>
										<tr id="wish<?php echo $wishlist['product_id'];?>">
											<td class="moveWishlist"> <input type="checkbox" class="check" name="product_id[]" value="<?php echo $wishlist['product_id'];?>"></td>
											<td class="prImg" data-title="Thumbnail">
											<?php
												if(is_file('attachments/products/thumb/'.$wishlist['image'])){
												?>
												<img src="<?php echo base_url('attachments/products/thumb/'.$wishlist['image'])?>">
												<?php
												}else{
												?>
												<img src="<?php echo base_url();?>/assets/frontend/images/prd1.jpg">
												<?php
												}
												?>
											</td>
											<td class="prDesc" data-title="Product" ><a href="<?php echo base_url('product-details/'.$wishlist['slug']);?>"><?php echo $wishlist['name'];?></a></td>

												<td><?php echo $wishlist['parent_category_name'];?></td>																					
												<td class="prCName" data-title="Category" ><?php echo $wishlist['category_name'];?></td>



											
											<td class="prPrice" data-title="Price">$<?php echo $wishlist['price'];?></td>
 											<td class="prAction" data-title="Remove">
											<a href="javascript:void(0)" class="remove_item" data_id="remove<?php echo $wishlist['product_id'];?>"><i class="fas fa-trash"></i></a></td>
										</tr>
										<?php
									}
								}else{
									?>
									<tr>
									<td colspan="7">
										<?php echo $no_record_label;?>
									<br>
									<a href="<?php echo base_url();?>"><?php echo $continue_shoping_label;?></a>
									</td>
									</tr>
									<?php
								}
								
								?>
									
									 
								</tbody>
								 
							</table>
						</form>
						</div> 
 
									</div>
										
									</div>

									
							<div class="form-group text-right">
							<a href="javascript:void(0)" class="btn btn-primary" style="margin-top: -2px;display: none;" id="move_to_cart">Move To Cart</a>
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


<script>
	$(function(){
		$('#move_to_cart').click(function(){
			$.ajax({
				type : "POST",
				url :'<?php echo base_url('Customer/moveProductToCart');?>',
				data :$('#customerWishList').serialize(),
				sucess : function(ajaxresponse){


				}
			});

		});



		$('#check_all').click(function(){
				if($(this).is(':checked')){
					$("#move_to_cart").show();
					$('.check').prop('checked',true);
					$('.remove_item').hide();
				}
				else{
					$('.check').prop('checked',false);
					$('.remove_item').show();
					$('#move_to_cart').hide();
				}
			});		

				$('.check').click(function(){
					if($('.check:checked').length==$('.check').length){
						$('#check_all').prop('checked',true);
					}					
					else
					{
						$('#check_all').prop('checked',false);
					}

						if($('.check:checked').length>0)
						{
							$('#move_to_cart').show();
						}
						else{
							$('#move_to_cart').hide();	
						}

						if($(this).is(':checked')){
							$('#remove'+$(this).val()).hide();
						}
						else
						{
							$('#remove'+$(this).val()).show();	
						}
				});
		$('.remove_item').click(function(){
                var data_id=$(this).attr('data_id');
                if(data_id>0){
                    addRemoveWishList(data_id);
                    $('#wish'+data_id).remove();
					var rowCount = $('#wish_list_table >tbody >tr').length;
					if(!rowCount){
						$("#wish_list_table tbody").append('<tr><td colspan="7"><?php echo $no_record_label;?><br><a href="<?php echo base_url();?>"><?php echo $continue_shoping_label;?></a></td></tr>');
					}
                 }
  			})
	})
 
	</script>
 

 