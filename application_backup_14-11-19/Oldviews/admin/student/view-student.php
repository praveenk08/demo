 
<?php
 $this->load->view('admin/includes/header');?>
   <!-- Content Header (Page header) -->
   <section class="content-header">
   <h1>
      View Student Details
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">View Student Details</li>
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
                  <div class="innerData1">Registration No</div>
                  <div class="innerData2"><?php echo $student['registrationno'];?></div>
               </div>
            </div>
           
            
            <div class="col-md-6">
               <div class="outerData">
                  <div class="innerData1">Name</div>
                  <div class="innerData2"><?php echo $student['name'];?></div>
               </div>
            </div>

            <div class="col-md-6">
               <div class="outerData">
                  <div class="innerData1">Email</div>
                  <div class="innerData2"><?php echo $student['email'];?></div>
               </div>
            </div>

            <div class="col-md-6">
               <div class="outerData">
                  <div class="innerData1">Roll NO</div>
                  <div class="innerData2"><?php echo $student['rollno'];?></div>
               </div>
            </div>

    

            <div class="col-md-6">
               <div class="outerData">
                  <div class="innerData1">Status</div>
                  <div class="innerData2"><?php echo $student['status'] ? "Active" : "In-active";?></div>
               </div>
            </div>
                    
            </div>
         </div>
      </div>
      <div class="box-footer">
         <a href="<?php echo base_url('admin-manage-student')?>" class="btn btn-primary">Back</a>
      </div>
   </div>
</section>
<!-- /.content -->
<?php  $this->load->view('admin/includes/footer');?>
   
 

   
 
<!-- <?php if($student['gender']==1){ ?> checked
                     <?php  } ?> value="1">Male -->