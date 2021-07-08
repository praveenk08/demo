 

<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
   <h1>
      View Page
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">View Page</li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <!-- Small boxes (Stat box) -->
   <div class="row">
      <div class="col-md-12">
         <div class=" box-body boxMain">
            <div class="row">
               <div class="col-md-6">
                  <div class="outerData">
                     <div class="innerData1">Name</div>
                     <div class="innerData2"><?php echo $page['name'];?></div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="outerData">
                     <div class="innerData1">Page Title</div>
                     <div class="innerData2"><?php echo $page['meta_title'];?></div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="outerData">
                     <div class="innerData1">Meta Keywords</div>
                     <div class="innerData2"><?php echo $page['meta_keywords'];?></div>
                  </div>
               </div>

               <div class="col-md-6">
                  <div class="outerData">
                     <div class="innerData1">Banner Title</div>
                     <div class="innerData2"><?php echo $page['banner_title'];?></div>
                  </div>
               </div>

               <?php if(is_file('attachments/pages/thumb/'.$page['banner_image'])){ ?>
                  <div class="col-md-6">
                  <div class="outerData">
                     <div class="innerData1">Banner Images</div>
                     <div class="innerData2"><img src="<?php echo base_url('attachments/pages/thumb/'.$page['banner_image'])?>"  class="img-responsive"></div>
                  </div>
               </div>
   			 <?php } ?>
             
             
               <?php if(is_file('attachments/pages/thumb/'.$page['image'])){ ?>
                  <div class="col-md-6">
                  <div class="outerData">
                     <div class="innerData1">Images</div>
                     <div class="innerData2"><img src="<?php echo base_url('attachments/pages/thumb/'.$page['image'])?>"  class="img-responsive"></div>
                  </div>
               </div>
 
   			 <?php } ?>

             

               

               <div class="col-md-12">
                  <div class="outerData">
                     <div class="innerData1">Meta Description</div>
                     <div class="innerData2"><?php echo $page['meta_description'];?></div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="outerData">
                     <div class="innerData1">Description</div>
                     <div class="innerData2"><?php echo $page['description'];?></div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="outerData">
                     <div class="innerData1">Status</div>
                     <div class="innerData2"><?php echo $page['status'] ? "Active" : "In-active";?></div>
                  </div>
               </div>
            </div>
            <div class="box-footer">
               <a href="<?php echo base_url('admin-manage-pages')?>" class="btn btn-primary">Back</a>
            </div>
         </div>
      </div>
   </div>
</section>
</div>
</section>
<!-- /.content -->
<?php  $this->load->view('admin/includes/footer');?>
