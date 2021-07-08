 
			 <?php
			 $this->load->view('website/includes/header');
			 ?>
			
			<!-- Main body wrapper -->
			<div class="mainBody">
				<div class="msBreadcrumb">
					<div class="container-fluid">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Cart</li>
						</ol>
					</div>
				</div>
				<div class="cartWrapper">
					<div class="container-fluid">
					<div id="success_message"></div>
						<div class="cartTable">
							<table class="table table-bordered" id="wish_list_table">
								<thead>
									<tr>
										<th class="prImg">Thumbnail</th>
										<th class="prDesc">Product</th>
										<th class="prPrice">Price</th>
 										<th class="prAction">Remove</th>
									</tr>
								</thead>
								<tbody>
								<?php 
 								if(count($wishlists)>0){
									foreach($wishlists as $wishlist){
 										 ?>
										<tr id="wish<?php echo $wishlist['product_id'];?>">
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
											<td class="prPrice" data-title="Price">$<?php echo $wishlist['price'];?></td>
 											<td class="prAction" data-title="Remove">
											<a href="javascript:void(0)" class="remove_item" data_id="<?php echo $wishlist['product_id'];?>"><i class="fas fa-trash"></i></a></td>
										</tr>
										<?php
									}
								}else{
									?>
									<tr>
									<td colspan="6">
									No item found in your wishlist.<br>
									<a href="<?php echo base_url();?>">Continue Shopping</a>
									</td>
									</tr>
									<?php
								}
								
								?>
									
									 
								</tbody>
								 
							</table>
						</div>
					 
					</div>
				</div>
			</div>
			 
			<?php
			 $this->load->view('website/includes/footer');
			 ?>
			 <script>
			$('.remove_item').click(function(){
                var data_id=$(this).attr('data_id');
                if(data_id>0){
                    addRemoveWishList(data_id);
                    $('#wish'+data_id).remove();
					var rowCount = $('#wish_list_table >tbody >tr').length;
					if(!rowCount){
						$("#wish_list_table tbody").append('<tr><td colspan="6">No item found in your cart.<br><a href="<?php echo base_url();?>">Continue Shopping</a></td></tr>');
					}
                 }
  			})
 		 
			 </script>