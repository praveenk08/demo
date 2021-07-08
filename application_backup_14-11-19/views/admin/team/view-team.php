 
<?php
 $this->load->view('admin/includes/header');?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
   <h1>
      View Team
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">View Team</li>
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
                  <div class="innerData1">Team Name</div>
                  <div class="innerData2"><?php echo $team['name'];?></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="outerData">
                  <div class="innerData1">Designation</div>
                  <div class="innerData2"><?php echo $team['designation'];?></div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="outerData">
                  <div class="innerData1">Description</div>
                  <div class="innerData2"><?php echo $team['description'];?></div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="outerData">
                  <div class="innerData1">Status</div>
                  <div class="innerData2"><?php echo $team['status'] ? "Active" : "In-active";?></div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="outerData">
                  <div class="innerData1">Image</div>
                  <div class="innerData2">
                     <div class="prdImg">
                        <?php if(is_file('attachments/teams/thumb/'.$team['image'])){ ?><img src="<?php echo base_url('attachments/teams/thumb/'.$team['image'])?>"  class="img-responsive"><?php } ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="box-footer">
         <a href="<?php echo base_url('admin-manage-teams')?>" class="btn btn-primary">Back</a>
      </div>
   </div>
</section>

	<!-- /.content -->
  <?php  $this->load->view('admin/includes/footer');?>
   
 

   
 
