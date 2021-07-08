 
			 <?php
			 $this->load->view('website/includes/header');
			 if($this->session->userdata('language')=='en'){

				$home_label="Home";
				$cart_label="Cart";
				$thumb_label="Image";
				$product_label="Crop";
				$price_label="Price";
				$parent_category_name_label="Category";
				$category_name_label="Sub Category";
				$quantity_label="Quantity";
				$total_label="Price";
				$remove_label="Remove";
				$no_record_label="No item found in your cart.";
				$continue_shoping_label="Continue Shopping";
				$cart_total_label="Cart Totals";
				$proced_to_checkout_label="Proceed to checkout";
				$sub_total_price_label="Sub Total";
				$shiping_price_label="Shipping";
				$total_price_label="Total";
 			}else{
				$home_label="الصفحة الرئيسية";
				$cart_label="عربة التسوق";
				$thumb_label="صورة";
				$product_label="ا & قتصاص";
				$price_label="السعر";
				$parent_category_name_label="الفئة";
				$category_name_label="تصنيف فرعي";
				$quantity_label="كمية";
				$total_label="السعر";
				$remove_label="إزالة";
				$no_record_label="لم يتم العثور على عنصر في سلة التسوق الخاصة بك.";
				$continue_shoping_label="مواصلة التسوق";
				$cart_total_label="إجماليات السلة";
				$proced_to_checkout_label="باشرالخروج من الفندق";
				$sub_total_price_label="المجموع الفرعي";
				$shiping_price_label="الشحن";
				$total_price_label="مجموع";

			}
		?>
			
			<!-- Main body wrapper -->
			<div class="mainBody">
				<div class="msBreadcrumb">
					<div class="container-fluid">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url()?>"><?php echo $home_label;?></a></li>
							<li class="breadcrumb-item active"><?php echo $cart_label;?></li>
						</ol>
					</div>
				</div>
				<div class="cartWrapper">
					<div class="container-fluid">
					<div id="success_message"></div>
						<div class="cartTable">
							<div id="loader_section"></div>
							<table class="table table-bordered" id="cart_list_table">
								<thead>

									<tr>
										<th class="prImg"><?php echo $thumb_label;?></th>
										<th class="prDesc"><?php echo $product_label;?></th>
										<th class="prDesc"><?php echo $parent_category_name_label;?></th>
										<th class="prDesc"><?php echo $category_name_label;?></th>
										<th class="prPrice"><?php echo $price_label;?></th>
										<th class="prQty"><?php echo $quantity_label;?></th>
										<th class="prTotal"><?php echo $price_label;?>*<?php echo $quantity_label;?></th>
										<th class="prAction"><?php echo $remove_label;?></th>
									</tr>

								</thead>
								<tbody>
								<?php 
								$subtotal=0;
								if(count($carts)>0){
									foreach($carts as $cart){
										$subtotal=$subtotal+($cart['price']*$cart['quantity']);
										 ?>
										<tr id="cart<?php echo $cart['cart_detail_id'];?>">
											<td class="prImg" data-title="Thumbnail">
											<?php
												if(is_file('attachments/products/thumb/'.$cart['image'])){
												?>
												<img src="<?php echo base_url('attachments/products/thumb/'.$cart['image'])?>">
												<?php
												}else{
												?>
												<img src="<?php echo base_url();?>/assets/frontend/images/prd1.jpg">
												<?php
												}
												?>
											</td>
											<td class="prDesc" data-title="Product" ><a href="<?php echo base_url('product-details/'.$cart['slug']);?>"><?php echo $cart['name'];?></a></td>

											<td class="prDesc" data-title="Product" ><?php echo $cart['parent_category_name'];?></td>

										<td class="prDesc" data-title="Product" ><?php echo $cart['category_name'];?></td>

											<td class="prPrice" data-title="Price">$<?php echo $cart['price'];?></td>
											<td class="prQty" data-title="Quantity">
											<input type="hidden"  class="cart_detail_id" value="<?php echo $cart['cart_detail_id'];?>">
											<input type="hidden" id="price<?php echo $cart['cart_detail_id'];?>"   value="<?php echo $cart['price'];?>">
											<input type="hidden" id="available_quantity<?php echo $cart['cart_detail_id'];?>"   value="<?php echo $cart['available_quantity'];?>">
												<div class="input-group">
													<span class="btn msMinus change_quantity" action="-" data_id="<?php echo $cart['cart_detail_id'];?>"><i class="fa fa-minus"></i></span>
													<input type="text" class="form-control allownumericwithoutdecimal" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly id="quantity<?php echo $cart['cart_detail_id'];?>"  value="<?php echo $cart['quantity'];?>"/>
													<span class="btn msPlus change_quantity" action="+" data_id="<?php echo $cart['cart_detail_id'];?>"><i class="fa fa-plus"></i></span>
												 </div>
											</td>
											<td class="prTotal" data-title="Total">$<span id="total_price<?php echo $cart['cart_detail_id'];?>"><?php echo number_format($cart['price']*$cart['quantity'],2);?></span></td>
											<td class="prAction" data-title="Remove">
											<a href="javascript:void(0)" class="remove_item" data_id="<?php echo $cart['cart_detail_id'];?>"><i class="fas fa-trash"></i></a></td>
										</tr>
										<?php
									}
								}else{
									?>
									<tr>
										<td colspan="8">
										<?php echo $no_record_label;?>
										<br>
										<a href="<?php echo base_url();?>"><?php echo $continue_shoping_label;?></a>
										</td>
									</tr>
									<?php
								}
								
								?>
									
									 
								</tbody>
								<!-- <tfoot>
									<tr style="display:none;">
										<td colspan="6">
											<div class="d-flex flex-wrap justify-content-between align-items-center">
												<div class="input-group applyCoupon" style="max-width: 500px;">
													<input type="text" class="form-control" placeholder="Enter your coupon code" name="">
													<div class="input-group-append"><button class="btn applyBtn">Apply Coupon</button></div>
												</div>
												<div class="updateCart"><a href="" class="btn updateBtn">Update Cart</a></div>
											</div>
										</td>
									</tr>
								</tfoot> -->
							</table>
						</div>
						<?php
						if(count($carts)>0){
							?>
							<div class="checkoutTable" id="checkoutTable">
							<table class="table">
								<thead>
									<tr><th><?php echo $cart_total_label;?></th></tr>
								</thead>
								<tbody>
									<tr><td class="subTotal" data-title="<?php echo $sub_total_price_label;?>">$<span id="subtotal"><?php echo number_format($subtotal,2);?></span></td></tr>
									<tr><td class="shipping" data-title="<?php echo $shiping_price_label;?>">$0</td></tr>
									<tr><td class="total" data-title="<?php echo $total_price_label;?>">$<span id="total"><?php echo number_format($subtotal,2);?></span></td></tr>
								</tbody>
								<tfoot>
									<?php 
									if($this->session->userdata('logged_in') && $this->session->userdata('role_id')!=1){
										$action=base_url('CheckOut');
									}else{
										$action=base_url('login?ch=1');
									}
									?>
									<tr><td><a class="btn" href="<?php echo $action;?>"><?php echo $proced_to_checkout_label;?></a></td></tr>

									<tr><td><a class="btn" href="<?php echo base_url();?>"><?php echo $continue_shoping_label;?></a></td></tr>

								</tfoot>
							</table>
						</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
			 
			<?php
			 $this->load->view('website/includes/footer');
			 ?>
			 <script>
			$('.remove_item').click(function(){
 				$('#loader_section').html(loader);
				var data_id=$(this).attr('data_id');
				$.ajax({
						type: 'POST',
						url: '<?php echo base_url(); ?>cart/RemoveProductToCart',
						data:{
 							'cart_detail_id':data_id,
 						},
						success: function (ajaxresponse) {
							response=JSON.parse(ajaxresponse);
							if(response['status']){
								$('#cart'+data_id).remove();
								$('#cart_counter').html(response['total_cart']);
								$('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
								if(response['total_cart']==0){
									$('#checkoutTable').hide();
									$("#cart_list_table tbody").append('<tr><td colspan="8">No item found in your cart.<br><a href="<?php echo base_url();?>">Continue Shopping</a></td></tr>');

								}
								calculatePrice();
							}
					}
				});
 			})
			 $('.change_quantity').click(function(){
				$('#success_message').html('');
 				var data_id=$(this).attr('data_id');
				var action=$(this).attr('action');
				var available_quantity=parseInt($('#available_quantity'+data_id).val());
 				var quantity=parseInt($('#quantity'+data_id).val());
 				if(action=='-') quantity--;
				else quantity ++;
  			 	if(available_quantity >= quantity && quantity>=1){
					$('#loader_section').html(loader);
					$.ajax({
						type: 'POST',
						url: '<?php echo base_url(); ?>cart/UpdateQuantityProductToCart',
						data:{
							'quantity':quantity,
							'cart_detail_id':data_id,
 						},
						success: function (ajaxresponse) {
							response=JSON.parse(ajaxresponse);
							if(response['status']){
 								$('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
							}else{
								$('#success_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
								var actual_quantity=parseInt($('#quantity'+data_id).val());
								if(actual_quantity>=1){
									$('#quantity'+data_id).val(actual_quantity-1);
								}
							}
							$('#cart_counter').html(response['total_cart']);
 							calculatePrice();
						}
					});
				  }else{
				 	var actual_quantity=parseInt($('#quantity'+data_id).val());
  				 	if(actual_quantity>=1){
					 	$('#quantity'+data_id).val(actual_quantity-1);
					 	$('#success_message').html('<div class="alert alert-danger">Opps Somthing went wrong!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					 	closePopup('success_message');	
					 }
				 } 
			  })
			function calculatePrice(){
				var total_price=0;
 				$('.cart_detail_id').each(function(){
					var cart_detail_id=$(this).val();
					var price=parseInt($('#price'+cart_detail_id).val());
					var quantity=parseInt($('#quantity'+cart_detail_id).val());
					var cart_price=parseInt(price*quantity);
					total_price=parseInt(total_price+cart_price);
 					$('#total_price'+cart_detail_id).html(cart_price.toFixed(2)); 
				});
				$('#subtotal').html(total_price.toFixed(2)); 
				$('#total').html(total_price.toFixed(2));
				$('#loader_section').html(''); 
				closePopup('success_message');
 			}
			 </script>