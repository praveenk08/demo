 
<?php
 $this->load->view('admin/includes/header');?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
   <h1>
      View Facility
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">View Facility</li>
   </ol>
</section>
<!-- Main content -->
<section class="content ViewProduct">
   <!-- Small boxes (Stat box) -->
   <div class="box box-primary">
       <div class="box-body">
         <div class="row">
            <div class="col-md-6">
               <div class="outerData">
                  <div class="innerData1">Facility Name</div>
                  <div class="innerData2"><?php echo $facility['name'];?></div>
               </div>
            </div>
           
            
            <div class="col-md-3">
               <div class="outerData">
                  <div class="innerData1">Sort Id</div>
                  <div class="innerData2"><?php echo $facility['sort_id'];?></div>
               </div>
            </div>

    

            <div class="col-md-3">
               <div class="outerData">
                  <div class="innerData1">Status</div>
                  <div class="innerData2"><?php echo $facility['status'] ? "Active" : "In-active";?></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="outerData">
                  <div class="innerData1">Image</div>
                  <div class="innerData2">
                     <div class="prdImg">
                        <?php if(is_file('attachments/facilities/thumb/'.$facility['image'])){ ?><img src="<?php echo base_url('attachments/facilities/thumb/'.$facility['image'])?>"  class="img-responsive"><?php } ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="box-footer">
         <a href="<?php echo base_url('admin-manage-facilities')?>" class="btn btn-primary">Back</a>
      </div>
   </div>
</section>
<!-- /.content -->
<?php  $this->load->view('admin/includes/footer');?>
   
 

   
 
