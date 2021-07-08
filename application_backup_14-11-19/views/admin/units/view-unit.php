
<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>
       View Unit
       </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View Unit</li>
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
                  <div class="innerData2"><?php echo $unit['name'];?></div>
                  </div>
                 
                </div>
 
   
 

                <div class="col-md-6">
                  <div class="outerData">
                    <div class="innerData1">Status</div>
                    <div class="innerData2"><?php echo $unit['status'] ? "Active" : "In-active";?></div>
                  </div>
                </div>

                
                 

              </div>

              <div class="box-footer">
                <a href="<?php echo base_url('admin-manage-unit')?>" class="btn btn-primary">Back</a>
              </div>

               </div>

          
            </div>
          </div>
          
        </section>
        
      </div>
    

    </section>
    <!-- /.content -->
  <?php  $this->load->view('admin/includes/footer');?>
   
 
