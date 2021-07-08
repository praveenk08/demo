 
<?php
 $this->load->view('admin/includes/header');?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
		View Slider
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">View Slider</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content ViewProduct">
		<!-- Small boxes (Stat box) -->
		<div class="box box-primary">
			<!-- <div class="box-header"><h3 class="box-title">Product Name</h3></div> -->
			<div class="box-body">
				<div class="row">
			 
				 	 
					<div class="col-md-12">
						<div class="outerData">
							<div class="innerData1">Slider Name</div>
							<div class="innerData2"><?php echo $slider['name'];?></div>
						</div>
					</div>

          <div class="col-md-12">
						<div class="outerData">
							<div class="innerData1">Status</div>
							<div class="innerData2"><?php echo $slider['status'] ? "Active" : "In-active";?></div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="outerData">
							<div class="innerData1">Slider Image</div>
							<div class="innerData2">
              <div class="prdImg">
              <?php if(is_file('attachments/sliders/thumb/'.$slider['image'])){ ?><img src="<?php echo base_url('attachments/sliders/thumb/'.$slider['image'])?>"  class="img-responsive"><?php } ?><img src=""  class="img-responsive">
              </div></div>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<a href="<?php echo base_url('admin-manage-sliders')?>" class="btn btn-primary">Back</a>
			</div>
		</div>
	</section>

	<!-- /.content -->
  <?php  $this->load->view('admin/includes/footer');?>
   
 

   
 
