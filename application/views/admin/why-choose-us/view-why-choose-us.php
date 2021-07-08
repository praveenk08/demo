<?php
 $this->load->view('admin/includes/header');?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
		View Why choose us
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">View Why choose us</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content ViewProduct">
		<!-- Small boxes (Stat box) -->
		<div class="box box-primary">
			<!-- <div class="box-header"><h3 class="box-title">Product Name</h3></div> -->
			<div class="box-body">
				<div class="row">
			 
				 

          <?php
					$languages=getLanguageList();
					foreach($languages as $language){
			?>
            <div class="col-md-6">
               <div class="outerData">
                  <div class="innerData1">Name (<?php echo ucfirst($language['name']);?>)</div>
                  <div class="innerData2"><?php if(isset($names[$language['abbr']]['name'])){echo $names[$language['abbr']]['name'];} ?></div>
               </div>
            </div>
            <?php
						}
					?>
 
 
 
                <?php
                foreach($languages as $language){
			        ?>
                <div class="col-md-12">
               <div class="outerData">
                  <div class="innerData1"> Description (<?php echo ucfirst($language['name']);?>)</div>
                  <div class="innerData2"><?php if(isset($names[$language['abbr']]['description'])){echo $names[$language['abbr']]['description'];} ?></div>
               </div>
            </div>
            <?php
						}
					?>

                <div class="col-md-12">
                  <div class="outerData">
                  <div class="innerData1">Image</div>
                  <div class="innerData2"><?php if(is_file('attachments/why-choose-us/thumb/'.$why_choose['image'])){ ?><img src="<?php echo base_url('attachments/why-choose-us/thumb/'.$why_choose['image'])?>"  class="img-responsive"><?php } ?><img src=""  class="img-responsive"></div>
                  </div>
                </div>
 
    


                <div class="col-md-6">
                  <div class="outerData">
                    <div class="innerData1">Status</div>
                    <div class="innerData2"><?php echo $why_choose['status'] ? "Active" : "In-active";?></div>
                  </div>
                </div>



					 
				</div>
			</div>
			<div class="box-footer">
				<a href="<?php echo base_url('admin-manage-why-choose')?>" class="btn btn-primary">Back</a>
			</div>
		</div>
	</section>

	<!-- /.content -->
  <?php  $this->load->view('admin/includes/footer');?>


  
   
 
