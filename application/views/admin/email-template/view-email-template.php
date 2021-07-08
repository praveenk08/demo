 
<?php
 $this->load->view('admin/includes/header');?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
   <h1>
      View Work Process
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">View Work Process</li>
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
                  <div class="innerData1">Name</div>
                  <div class="innerData2"><?php echo $email_template['name'];?></div>
               </div>
            </div>

            <div class="col-md-6">
               <div class="outerData">
                  <div class="innerData1">Subject</div>
                  <div class="innerData2"><?php echo $email_template['subject'];?></div>
               </div>
            </div>

            <div class="col-md-12">
               <div class="outerData">
                  <div class="innerData1">Welcome Heading</div>
                  <div class="innerData2"><?php echo $email_template['welcome_heading'];?></div>
               </div>
            </div>

            <div class="col-md-12">
               <div class="outerData">
                  <div class="innerData1">Welcome Message</div>
                  <div class="innerData2"><?php echo $email_template['welcome_message'];?></div>
               </div>
            </div>


            <div class="col-md-12">
               <div class="outerData">
                  <div class="innerData1">Message Description</div>
                  <div class="innerData2"><?php echo $email_template['message_description'];?></div>
               </div>
            </div>
           
    
            <div class="col-md-12">
               <div class="outerData">
                  <div class="innerData1">Banner Image</div>
                  <div class="innerData2">
                     <div class="prdImg">
                        <?php if(is_file('attachments/email-templates/thumb/'.$email_template['banner_image'])){ ?><img src="<?php echo base_url('attachments/email-templates/thumb/'.$email_template['banner_image'])?>"  class="img-responsive"><?php } ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="box-footer">
         <a href="<?php echo base_url('admin-manage-email-templates')?>" class="btn btn-primary">Back</a>
      </div>
   </div>
</section>
<!-- /.content -->
<?php  $this->load->view('admin/includes/footer');?>
   
 

   
 
