<?php
 $this->load->view('admin/includes/header');?>
    <!-- Main content -->
    <section class="content adm_Dashboard">
      <!-- Small boxes (Stat box) -->
      <div class="row d-flex flex-wrap">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $response['total_orders'];?></h3>

              <p>New Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo base_url('admin-manage-orders');?>" class="small-box-footer">View More<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
            <h3 class="cfont">$<?php echo number_format($response['total_sales'],2);?></h3>
              <p>Total Sales</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo base_url('admin-manage-orders');?>" class="small-box-footer">View More<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $response['total_customers'];?></h3>

              <p>Total Customers</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?php echo base_url('admin-manage-users');?>" class="small-box-footer">View More<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
            <h3><?php echo $response['total_products'];?></h3>
            <p>Total Products</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-box"></i>
            </div>
            <a href="<?php echo base_url('admin-manage-products');?>" class="small-box-footer">View More<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
       
<hr>

 
      <!-- Small boxes (Stat box) -->
      <div class="row d-flex flex-wrap">
      <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">

            <div class="inner">
              <h3><?php echo $response['total_visitors']['Total_visitors']?$response['total_visitors']['Total_visitors']:0;?></h3>
              <p>Total Visitors</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="<?php echo base_url('admin-manage-products');?>" class="small-box-footer">View More<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $response['total_shipped_orders']?$response['total_shipped_orders']:0;?></h3>
              <p>Total Shipped Orders</p>
            </div>
            <div class="icon">
              <i class="fa fa-truck"></i>
            </div>
            <a href="<?php echo base_url('admin-manage-orders');?>" class="small-box-footer">View More<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $response['total_notifications']['total_notifications']?$response['total_notifications']['total_notifications']:0;?></h3>
              <p>Total Notifications</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-bell"></i>
            </div>
            <a href="<?php   echo base_url('admin-manage-notifications');?>" class="small-box-footer">View More<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
            <h3><?php echo $response['total_order_notifications']['total_order_notifications']?$response['total_order_notifications']['total_order_notifications']:0;?></h3>
              <p>Total Notifications of requested Orders</p>
            </div>
            <div class="icon">
              <i class="fa fa-file-text-o"></i>
            </div>
            <a href="<?php echo base_url('admin-manage-orders');?>" class="small-box-footer">View More<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

      </div>

      </div>

   

      </section>
    <!-- /.content -->
    <?php
   $this->load->view('admin/includes/footer');?>
