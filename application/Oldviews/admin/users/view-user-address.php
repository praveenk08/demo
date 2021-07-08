
<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>
       View Customer Address
       </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View Customer Address</li>
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
                  <div class="innerData2"><?php echo $address['user_name'];?></div>
                  </div>
                </div>

                <div class="col-md-6">
                <div class="outerData">
                  <div class="innerData1">Contact Name</div>
                  <div class="innerData2"><?php echo $address['name'];?></div>
                  </div>
                </div>
                

                <div class="col-md-6">
                <div class="outerData">
                  <div class="innerData1">Phone</div>
                  <div class="innerData2"><?php echo $address['phone'];?></div>
                  </div>
                 
                </div>
 

                <div class="col-md-6">
                <div class="outerData">
                  <div class="innerData1">Email Addres</div>
                  <div class="innerData2"><?php echo $address['email'];?></div>
                  </div>
                 
                </div>

                <div class="col-md-6">
                  <div class="outerData">
                  <div class="innerData1">Country</div>
                  <div class="innerData2"><?php echo $address['country_name'];?></div>
                  </div>
                 
                </div>

                <div class="col-md-6">
                <div class="outerData">
                  <div class="innerData1">State</div>
                  <div class="innerData2"><?php echo $address['state_name'];?></div>
                  </div>
                 
                </div>
 

                <div class="col-md-6">
                <div class="outerData">
                  <div class="innerData1">City</div>
                  <div class="innerData2"><?php echo $address['city_name'];?></div>
                  </div>
                 
                </div>
 

                <div class="col-md-6">
                  <div class="outerData">
                  <div class="innerData1">Address</div>
                  <div class="innerData2"><?php echo $address['address'];?></div>
                  </div>
                 
                </div>

                <div class="col-md-6">
                <div class="outerData">
                  <div class="innerData1">Street</div>
                  <div class="innerData2"><?php echo $address['street'];?></div>
                  </div>
                 
                </div>

                <div class="col-md-6">
                <div class="outerData">
                  <div class="innerData1">Block</div>
                  <div class="innerData2"><?php echo $address['block'];?></div>
                  </div>
                 
                </div>
 

                <div class="col-md-6">
                <div class="outerData">
                  <div class="innerData1">Zip</div>
                  <div class="innerData2"><?php echo $address['zip'];?></div>
                  </div>
                 
                </div>
 

                <div class="col-md-6">
                  <div class="outerData">
                    <div class="innerData1">Status</div>
                    <div class="innerData2"><?php echo $address['status'] ? "Active" : "In-active";?></div>
                  </div>
                </div>

                
              </div>

              <div class="box-footer">
                <a href="<?php echo base_url('admin-manage-user-addresses')?>" class="btn btn-primary">Back</a>
              </div>

               </div>

          
            </div>
          </div>
          
        </section>
        
      </div>
    

    </section>
    <!-- /.content -->
  <?php  $this->load->view('admin/includes/footer');?>
   
 
