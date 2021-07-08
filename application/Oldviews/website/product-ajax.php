
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
					<div class="wishIcon"><a class="wishlist-item" onclick="addRemoveWishList('<?php echo $product['vendor_product_id'];?>')" id="<?php echo $product['vendor_product_id'];?>"><?php if($product['vendor_product_id']==$product['wish_product_id']){ ?><i class='fas fa-heart'></i><?php }else{ ?><i class='far fa-heart'></i><?php } ?></a></div>
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
						<button class="btn addCartBtn" onClick="AddProductInToCart('<?php echo $product['vendor_product_id'];?>')" id="<?php echo $product['vendor_product_id'];?>" ><span id="added<?php echo $product['vendor_product_id'];?>">Add to Cart</span></button>
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
	<li>No Product Found</li>
	<?php
}
?>
</ul>
</div>
<div class="msPagination mt-3" id="pagination-section">
<?php echo $this->ajax_pagination->create_links(); ?>
</div>