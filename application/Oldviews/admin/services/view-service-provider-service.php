<?php
 $this->load->view('admin/includes/header');?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
		View Service
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">View Service</li>
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
            <div class="innerData1">Name</div>
            <div class="innerData2"><?php echo $service['name'];?></div>
						</div>
					</div>

          <div class="col-md-6">
						<div class="outerData">
            <div class="innerData1">Provider Name</div>
            <div class="innerData2"><?php echo $service['service_provider_name'];?></div>
						</div>
					</div>

          <div class="col-md-6">
						<div class="outerData">
            <div class="innerData1">Category</div>
                  <div class="innerData2"><?php echo $service['service_category_name'];?></div>
						</div>
					</div>

          <div class="col-md-6">
                  <div class="outerData">
                  <div class="innerData1">Price</div>
                  <div class="innerData2">$<?php echo $service['price'];?></div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="outerData">
                  <div class="innerData1">Description</div>
                  <div class="innerData2"><?php echo $service['description'];?></div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="outerData">
                  <div class="innerData1">Image</div>
                  <div class="innerData2"><?php if(is_file('attachments/services/thumb/'.$service['image'])){ ?><img src="<?php echo base_url('attachments/services/thumb/'.$service['image'])?>"  class="img-responsive"><?php } ?><img src=""  class="img-responsive"></div>
                  </div>
                </div>
 
   
                <div class="col-md-6">
                  <div class="outerData">
                  <div class="innerData1">Added Date</div>
                  <div class="innerData2"><?php echo $service['added_date'];?></div>
                  </div>
                </div>


                <div class="col-md-6">
                  <div class="outerData">
                    <div class="innerData1">Status</div>
                    <div class="innerData2"><?php echo $service['status'] ? "Active" : "In-active";?></div>
                  </div>
                </div>



					 
				</div>
			</div>
			<div class="box-footer">
				<a href="<?php echo base_url('admin-manage-services')?>" class="btn btn-primary">Back</a>
			</div>
		</div>
	</section>

	<!-- /.content -->
  <?php  $this->load->view('admin/includes/footer');?>


  
   
 
