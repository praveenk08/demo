
<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>
       View Brand
       </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View Brand</li>
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
                  <div class="innerData2"><?php echo $brand['name'];?></div>
                  </div>
                 
                </div>
 
   
 

                <div class="col-md-6">
                  <div class="outerData">
                    <div class="innerData1">Status</div>
                    <div class="innerData2"><?php echo $brand['status'] ? "Active" : "In-active";?></div>
                  </div>
                </div>

                
                <div class="col-md-6">
                <div class="outerData">
                  <div class="innerData1">Brand Image</div>
                  <div class="innerData2"><?php if(is_file('attachments/brand/thumb/'.$brand['image'])){ ?><img src="<?php echo base_url('attachments/brand/thumb/'.$brand['image'])?>"  class="img-responsive"><?php } ?></div>
                  </div>
                 
                </div>

              </div>

              <div class="box-footer">
                <a href="<?php echo base_url('admin-manage-brand')?>" class="btn btn-primary">Back</a>
              </div>

               </div>

          
            </div>
          </div>
          
        </section>
        
      </div>
    

    </section>
    <!-- /.content -->
  <?php  $this->load->view('admin/includes/footer');?>
   
 
