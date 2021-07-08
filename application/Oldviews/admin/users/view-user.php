
<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>
       View User
       </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View User</li>
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
                  <div class="innerData1">Role</div>
                  <div class="innerData2"><?php echo $user['role_name'];?></div>
                  </div>
                 
                </div>

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
                    <div class="innerData1">Display on Top</div>
                    <div class="innerData2"><?php echo $user['top'] ? "Yes" : "No";?></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="outerData">
                    <div class="innerData1">Weather Forecast</div>
                    <div class="innerData2"><?php  if($user['forecast']==1){ echo "Weekly";}else if($user['forecast']==2){ echo "Monthly";}else if($user['forecast']==3){ echo "3 Monthly";}?></div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="outerData">
                    <div class="innerData1">Publication</div>
                    <div class="innerData2"><?php  if($user['publication']==1){ echo "Weekly";}else if($user['publication']==2){ echo "Monthly";}else if($user['publication']==3){ echo "3 Monthly";}?></div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="outerData">
                    <div class="innerData1">Matching</div>
                    <div class="innerData2"><?php  if($user['matching']==1){ echo "Weekly";}else if($user['matching']==2){ echo "Monthly";}else if($user['matching']==3){ echo "3 Monthly";}?></div>
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

                 
    

                <div class="col-md-6">
                <div class="outerData">
                  <div class="innerData1">User Image</div>
                  <div class="innerData2"><?php if(is_file('attachments/users/thumb/'.$user['image'])){ ?><img src="<?php echo base_url('attachments/users/thumb/'.$user['image'])?>"  class="img-responsive"><?php } ?><img src=""  class="img-responsive"></div>
                  </div>
                 
                </div>


                
              </div>

              <div class="box-footer">
                <a href="<?php echo base_url('admin-manage-users')?>" class="btn btn-primary">Back</a>
              </div>

               </div>

          
            </div>
          </div>
          
        </section>
        
      </div>
    

    </section>
    <!-- /.content -->
  <?php  $this->load->view('admin/includes/footer');?>
   
 
