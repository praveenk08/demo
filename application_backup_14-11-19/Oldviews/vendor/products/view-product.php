
<?php
 $this->load->view('vendor/includes/header');?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
		View Product
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">View Product</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content ViewProduct">
		<!-- Small boxes (Stat box) -->
		<div class="box box-primary">
			<!-- <div class="box-header"><h3 class="box-title">Product Name</h3></div> -->
			<div class="box-body">
				<div class="row">
					 
					<div class="col-md-6">
						<div class="outerData">
							<div class="innerData1">Vendor</div>
							<div class="innerData2"><?php echo $product['vendor_name'];?></div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="outerData">
							<div class="innerData1">Category</div>
							<div class="innerData2"><?php echo $product['product_category_name'];?></div>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="outerData">
							<div class="innerData1">Unit</div>
							<div class="innerData2"><?php echo $product['unit_name'];?></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="outerData">
							<div class="innerData1">Unit Value</div>
							<div class="innerData2"><?php echo $product['unit_value'];?></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="outerData">
							<div class="innerData1">Quantity</div>
							<div class="innerData2"><?php echo $product['quantity'];?></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="outerData">
							<div class="innerData1">Price</div>
							<div class="innerData2"><?php echo $product['price'];?></div>
						</div>
					</div>
					 
					<div class="col-md-4">
						<div class="outerData">
							<div class="innerData1">Maturity Date</div>
							<div class="innerData2"><?php echo date('d-m-Y h:i',strtotime($product['maturity_date']));?></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="outerData">
							<div class="innerData1">Added Date</div>
							<div class="innerData2"><?php echo date('d-m-Y h:i',strtotime($product['added_date']));?></div>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="outerData">
							<div class="innerData1">Status</div>
							<div class="innerData2"><?php echo $product['status'] ? "Active" : "In-active";?></div>
						</div>
					</div>
					<?php
						$languages=getLanguageList();
						foreach($languages as $language){
					?>
					<div class="col-md-12">
						<div class="outerData">
							<div class="innerData1">Name(<?php echo ucfirst($language['name']);?>)</div>
							<div class="innerData2"><?php if(isset($names[$language['abbr']]['name'])){echo $names[$language['abbr']]['name'];} ?></div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="outerData">
							<div class="innerData1">Brief(<?php echo ucfirst($language['name']);?>)</div>
							<div class="innerData2"><?php if(isset($names[$language['abbr']]['brief'])){echo $names[$language['abbr']]['brief'];} ?></div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="outerData">
							<div class="innerData1">Description(<?php echo ucfirst($language['name']);?>)</div>
							<div class="innerData2"><?php if(isset($names[$language['abbr']]['description'])){echo $names[$language['abbr']]['description'];} ?></div>
						</div>
					</div>
					<?php
						}
					?>
					<div class="col-md-6">
						<div class="outerData">
							<div class="innerData1">Meta Title</div>
							<div class="innerData2"><?php echo $product['meta_title'];?></div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="outerData">
							<div class="innerData1">Meta Keywords</div>
							<div class="innerData2"><?php echo $product['meta_keywords'];?></div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="outerData">
							<div class="innerData1">Meta Description</div>
							<div class="innerData2"><?php echo $product['meta_description'];?></div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="outerData">
							<div class="innerData1">Product Image</div>
							<div class="innerData2"><?php if(is_file('attachments/products/thumb/'.$product['image'])){ ?><div class="prdImg"><img src="<?php echo base_url('attachments/products/thumb/'.$product['image'])?>"  class="img-responsive"></div><?php } ?></div>
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="outerData">
							<div class="innerData1">Product Secondary Image</div>
							<div class="innerData2">
							<?php
							if(count($product_secondary_images)>0){
							foreach($product_secondary_images as $product_secondary_image){
							?>
							<div class="prdImg"><?php if(is_file('attachments/products/thumb/'.$product_secondary_image['image'])){ ?><img src="<?php echo base_url('attachments/products/thumb/'.$product_secondary_image['image'])?>"  class="img-responsive"><?php } ?></div>
							<?php
							}
							}
							?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<a href="<?php echo base_url('vendor-manage-products')?>" class="btn btn-primary">Back</a>
			</div>
		</div>
	</section>

	<!-- /.content -->
  <?php  $this->load->view('vendor/includes/footer');?>
   
 
