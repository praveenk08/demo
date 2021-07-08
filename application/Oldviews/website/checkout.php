<?php
$this->load->view('website/includes/header');
?>
<section class="productWrapper">
		<div class="container">
			<div class="checkoutContainer">
				<div class="wgAccordion">
					<div class="wgAccordion_box">
						<a href="#" id="login_area">Login <i class="fa fa-plus"></i></a>
						<div class="wgAccordion_content card">
							<div class="card-body">
								<div class="dFlex">
									<div>
										<p>Name: <strong><?=$this->session->userdata('customer_data')['first_name']?></strong></p>
										<p>Phone: <strong><?=$this->session->userdata('customer_data')['phone']?></strong></p>
									</div>
									<!--<div><button class="continue_Checkout">Continue Checkout</button></div> -->
								</div>
							</div>
						</div>
					</div>
					<div class="wgAccordion_box">
						<a href="#" class="active" id="address_area">Delivery Address <i class="fa fa-plus"></i></a>
						<div class="wgAccordion_content card" id="address_area_body" style="display: block;">
						
						<?php 
						/* echo "<pre>";
						print_r($addressInfo);
						echo "</pre>"; */
						?>
							<div class="card-body">
								<ul class="addressList">
								<?php
								     $itempos=0;
									 $style="display:none";
									 $checked="";
                                    foreach ($addressInfo as $address)
                                    { 
									 if($itempos==0)
									 {
										 $style="display:block;margin-top: 15px;";
										 $checked="checked";
									 }
									 else{
										  $style="display:none";
									 $checked="";
									 }
									 $itempos++;
									?>
									<li class="dFlex">
									<input type="radio" name="deliveryAddress" class="deliver_radio" id="address_<?=$address['id'];?>" value="<?=$address['id'];?>" <?=$checked?> >
									<label for="address_<?= $address['id'];?>"> </label>
										<div class="addressBox"><span><?=$address['address_type']?></span>
											<h4><?=$address['name']; ?> <span><?= $address['phone']; ?></span></h4>
											<p><?= $address['address'];?></p>
											<div class="deliverHere" id="deliver_<?= $address['id'];?>" style="<?=$style?>"><button class="continue_Checkout addressclick" data-id="<?=$address['zip']?>">Deliver Here</button></div>
											
											<p id="pincode_<?=$address['zip']?>" class="text-danger"></p>
											
											<div class="manageAction">
												<a href=""><i class="fas fa-ellipsis-v"></i></a>
												<div class="dropAction">
												<a href="<?php echo base_url('customer-update-address/'.$address['id']);?>?ch=1">Edit</a>
											  <!--	<a href="javascript:void(0);" onclick="DeleteRecord('<?php echo $address['id'];?>')">Delete</a>-->
                      </div>
											</div>
										</div>
									</li>
									<?php } ?>
								</ul>
								
						<a href="<?php echo base_url('customer-add-address')?>?ch=1" class="btn btn-info"><i class="fas fa-plus"></i> Add New Address</a>
							
							</div>
							
						</div>
					</div>
					<div class="wgAccordion_box">
						<a href="#" id="cart_area">Order Summary <i class="fa fa-plus"></i></a>
						<div class="wgAccordion_content card" id="cart_area_body">
							<div class="container-fluid">
						<div class="anuTable">						
							<table class="table table-bordered">
								<thead>
									<tr>
										<th class="prImg">Thumbnail</th>
										<th class="prDesc">Product</th>
										<th class="prPrice">Price</th>
										<th class="prQty">Quantity</th>
										<th class="prTotal">Total</th>
										
									</tr>
								</thead>
								<tbody>								
									<?php 
									$cartsum=0;
									foreach($carts as $cart){
 									?>
									<tr>
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
										<td class="prPrice" data-title="Price">$<?php echo $cart['price'];?></td>
										<td class="prQty" data-title="Quantity"><?php echo $cart['quantity'];?>	</td>
										<td class="prTotal" data-title="Total">$<?php echo number_format($cart['price']*$cart['quantity'],2);?></td>
										
									</tr>
									<?php
									$cartsum=$cartsum+($cart['price']*$cart['quantity']);
								}
								?>
									
								</tbody>
								
							</table>
						</div>
						<input type="hidden" name="cart_total" id="cart_total" value="<?=$cartsum;?>"/>
						<?php if($cartsum > 0) { ?>
						<div class="checkoutTable">
							<table class="table">
								<thead>
									<tr><th>Cart Totals</th></tr>
								</thead>
								<tbody>
									<!--<tr><td class="subTotal" data-title="Sub Total">$230</td></tr>
									 <tr><td class="shipping" data-title="Shipping">$70</td></tr> -->
									<tr><td class="total" data-title="Total">$<?=number_format($cartsum,2);?></td></tr>
								</tbody>
								<tfoot>
									<tr><td><button class="btn cartinfoclick">Continue</button></td></tr>
								</tfoot>
							</table>
						</div>
						<?php } ?>
					</div>
						</div>
					</div>
					<div class="wgAccordion_box">
						<a href="#"  id="payment_area">Payment Options <i class="fa fa-plus"></i></a>
						<div class="wgAccordion_content card" id="payment_area_body">
							<div class="card-body">
								<!--<div class="dFlex">
									<div>
										<p class="" style="margin-bottom: 10px;">
											<input type="radio" name="paymentOption" id="payment_1">
											<label for="payment_1">Credit / Debit / ATM Card</label>
										</p>
										<p class="" style="margin-bottom: 10px;">
											<input type="radio" name="paymentOption" id="payment_2">
											<label for="payment_2">Net Banking</label>
										</p> 
										<p class="">
											<input type="radio" name="paymentOption" id="payment_3" value="COD">
											<label for="payment_3">Cash on delivery</label>
										</p>
									</div>
									<div class="deliverHere" style="margin-top: auto;"><button class="continue_Checkout">Deliver Here</button></div>
								</div>-->
								
								<?php if(count($addressInfo)>0) { ?>
								<div class="dFlex">
									<div>
										<!--<p class="" style="margin:20px 0 10px 0;">
											<input type="radio" class="paymentOption" name="paymentOption" checked id="payment_1" value="online">
											<label for="payment_1">Online</label>
										</p>	 -->									
										<p class="">
											<input type="radio" checked class="paymentOption" name="paymentOption" id="payment_3" value="COD">
											<label for="payment_3">Cash on delivery</label>
										</p>

										<p class="" style="margin-bottom: 10px;">
											<input type="radio"class="paymentOption" name="paymentOption" id="payment_1" value="PayTabs">
											<label for="payment_1">PayTabs</label>
										</p>

									</div>
									<div class="checkout_proceed" style="">
									<button class="continue_Checkout" id="proceed">Place an order</button>
 									
									<button class="continue_Checkout" id="loading_button" style="display:none"><i class="fas fa-spinner fa-spin"></i> Please Wait</button>
									</div>
								</div>
								<div class="alert alert-info" id="mess" style="display:none"></div>
							<?php } else { ?>	
							<div class="text-danger">Select an address to proceed</div>
							<?php } ?>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
 
	<script>
		$(document).ready(function() {
		
		 $(".wgAccordion_box > a").on("click", function() {
			  if(this.id=="address_area" || this.id=="login_area"){
					if ($(this).hasClass("active")) {
					  $(this).removeClass("active");
					  $(this).siblings(".wgAccordion_content").slideUp(200);
					  $(".wgAccordion_box > a i").removeClass("fa-minus").addClass("fa-plus");
					} else {
				  	$(".wgAccordion_box > a i").removeClass("fa-minus").addClass("fa-plus");
				  	$(this).find("i").removeClass("fa-plus").addClass("fa-minus");
				 	  $(".wgAccordion_box > a").removeClass("active");
				  	$(this).addClass("active");
				 	  $(".wgAccordion_content").slideUp(200);
				 	  $(this).siblings(".wgAccordion_content").slideDown(200);
				  } 
			  }
			});
			
		$(".deliver_radio").change(function() {
			  var value=this.value;
			  console.log(value);
			  $(".deliverHere").hide();
			  console.log("#deliver_"+value);
			  $("#deliver_"+value).show();
		});
		  
		$(".paymentOption").change(function() {
			var value=this.value;
  			var cart_total=$('#cart_total').val();
			if(value=="COD"){
  				$("#proceed").html('Place an order');
			}
			else{
  				$("#proceed").html('Proceed to Pay $'+cart_total);
			}
		});
		  
		$(".addressclick").on("click", function() {
			$("#address_area").removeClass("active");
			$("#address_area i").removeClass("fa-minus").addClass("fa-plus");
			$("#address_area_body").hide();
			$("#cart_area").addClass("active");
			$("#cart_area i").removeClass("fa-plus").addClass("fa-minus");
			$("#cart_area_body").show();
		});
		
		
		$(".cartinfoclick").on("click", function() {			   
			$("#cart_area").removeClass("active");
			$("#cart_area i").removeClass("fa-minus").addClass("fa-plus");
			$("#cart_area_body").hide();
			$("#payment_area").addClass("active");
			$("#payment_area i").removeClass("fa-plus").addClass("fa-minus");
			$("#payment_area_body").show();
		});
	 
		  $("#proceed").on("click", function() {
			var address_id = $("input[name='deliveryAddress']:checked"). val();
        	var payment_type = $("input[name='paymentOption']:checked"). val();
        	var cart_total=$('#cart_total').val();			
			$('#proceed').hide();			
			$('#loading_button').show();			
					$.ajax({
						type: "POST",
						url: "<?=base_url('CheckOut/createOrder')?>",
						data: {
							address_id: address_id,
							payment_type: payment_type,
							cart_total:cart_total
						},
						success: function(ajaxresponse){
							response=JSON.parse(ajaxresponse);
							console.log(response);
 							$('#proceed').show();			
							$('#loading_button').hide();
							if(!response['status']){
								$('#mess').html("add item in cart").fadeIn('slow');
								$('#mess').delay(5000).fadeOut('slow');
							}else{
								window.location =response['payment_url'];
								$("#proceed").html('Proceed');
							}
						}
					});
		  });
});  
		  
		

	</script>
<?php
$this->load->view('website/includes/footer');
?>

 