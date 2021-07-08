
 <?php $this->load->view('vendor/includes/header');?>
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      View Customer
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">View Customer</li>
   </ol>
</section>
<!-- Main content -->
<section class="content ViewCustomer">
   <!-- Small boxes (Stat box) -->
   <div class="box box-primary">
      <div class="box-body">
         <div class="row">
            <div class="col-md-6">
               <div class="outerData">
                  <div class="innerData1">Name</div>
                  <div class="innerData2"><?php echo $user['first_name'].' '. $user['last_name'];?></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="outerData">
                  <div class="innerData1">Phone</div>
                  <div class="innerData2"><?php echo $user['phone'];?></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="outerData">
                  <div class="innerData1">Email Addres</div>
                  <div class="innerData2"><?php echo $user['email'];?></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="outerData">
                  <div class="innerData1">Status</div>
                  <div class="innerData2"><?php echo $user['status'] ? "Active" : "In-active";?></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="outerData">
                  <div class="innerData1">Verified</div>
                  <div class="innerData2"><?php echo $user['verified'] ? "Yes" : "No";?></div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="outerData">
                  <div class="innerData1">Customer Image</div>
                  <div class="innerData2"><?php if(is_file('attachments/users/thumb/'.$user['image'])){ ?><img src="<?php echo base_url('attachments/users/thumb/'.$user['image'])?>"  class="img-responsive"><?php } ?><img src=""  class="img-responsive"></div>
               </div>
            </div>
         </div>
      </div>
      <div class="box-footer">
      <a href="<?php echo base_url('vendor-manage-customers')?>" class="btn btn-primary">Back</a>
      </div>
   </div>
</section>
 <?php  $this->load->view('vendor/includes/footer');?>
   
 


   
 
