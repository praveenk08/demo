<?php
 $this->load->view('vendor/includes/header');
 $weekDayNames=array();
 for ($i = 0; $i < 8; $i++) {
   if(date('D')==strftime("%a", strtotime("today +$i day")) && $i==0){
     $day='Today';;
   }else{
    $day=strftime("%a", strtotime("today +$i day"));
   }
  $weekDayNames[] =$day ;
  }
  //echo '<pre>';
 // print_r($weather_forecast_response);
 ?>
    <!-- Main content -->
    <section class="content vnd_Dashboard">
      <!-- Small boxes (Stat box) -->
      <div class="row d-flex flex-wrap">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $response['total_orders']?$response['total_orders']:0;?></h3>

              <p>New Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo base_url('vendor-manage-orders');?>" class="small-box-footer">View More<i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="<?php echo base_url('vendor-manage-orders');?>" class="small-box-footer">View More<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $response['total_customers']?$response['total_customers']:0;?></h3>

              <p>Total Customers</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?php echo base_url('vendor-manage-customers');?>" class="small-box-footer">View More<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
            <h3><?php echo $response['total_products']?$response['total_products']:0;?></h3>
            <p>Total Products</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-box"></i>
            </div>
            <a href="<?php echo base_url('vendor-manage-products');?>" class="small-box-footer">View More<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <!-- Forecast -->
      <section class="forecast">
        <div class="panel panel-default">
          <div class="panel-heading"><div class="h3"><strong>Weather Forecast <?php echo $weather_forecast['vendor_address'];?></strong></div></div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-3 text-center">
                <div class="fc_current">
                  <div class="d-flex">
                    <div class="fc_icon"><img src="https://darksky.net/images/weather-icons/<?php echo $weather_forecast_response->daily->data[0]->icon;?>.png"></div>
                    <div class="fc_text text-center">
 
                      <div class="h1"><strong><?php echo getTemp($weather_forecast_response->daily->data[0]->apparentTemperatureMax);?>˚C</strong></div>
                      <p>and rising</p>
                    </div>
                  </div>
                  <div class="h3"><strong>Mostaly Cloudy</strong></div>
                  <div class="wc">Wind Speed: <strong><?php echo $weather_forecast_response->daily->data[0]->windSpeed;?> mph (N)</strong></div>
                  <div class="hd">Humidity: <strong><?php echo $weather_forecast_response->daily->data[0]->humidity;?></strong></div>
                 </div>
              </div>
              <div class="col-md-9">
                <div class="fc_week table-responsive">
                  <table class="table">
                    
                    <tr>
                      <?php
                      $counter=0;
                      $max_temp=58;
                      $min_temp=-88;

                      $length=58;
                      foreach($weekDayNames as $day){
                        $current_max_temp=getTemp($weather_forecast_response->daily->data[$counter]->temperatureHigh);
                        $current_min_temp=getTemp($weather_forecast_response->daily->data[$counter]->temperatureLow);
                        
                        $actual_temp=$length-$current_max_temp;
                        $top_margin=($actual_temp*100)/$length;

                        $bottom_margin=($current_min_temp*100)/$length;
                        $balance_margin= (100)-($top_margin+$bottom_margin);
                        ?>
                      <td align="center">
                        <ul class="list-unstyled">
                          <li>
                            <div class="h5"><strong><?php echo $day;?></strong></div>
                            <div class="fc_icon"><img src="https://darksky.net/images/weather-icons/<?php echo $weather_forecast_response->daily->data[$counter]->icon;?>.png"></div>
                          </li>
                          <li>
                            <div class="tempRange">
                              <div class="minTemp" style="margin-top:<?php echo $top_margin;?>%"><?php echo getTemp($weather_forecast_response->daily->data[$counter]->temperatureHigh);?>˚C</div>
                              <div class="bar" style="height:<?php echo $bottom_margin;?>%;"></div>
                              <div class="maxTemp"><?php echo getTemp($weather_forecast_response->daily->data[$counter]->temperatureLow);?>˚C</div>
                            </div>
                          </li>
                          <li>
                            <div class="wc">Wind Speed: <strong><?php echo $weather_forecast_response->daily->data[$counter]->windSpeed;?></strong></div>
                            <div class="hd">Humidity: <strong><?php echo $weather_forecast_response->daily->data[$counter]->humidity;?></strong></div>
                          </li>
                        </ul>
                      </td>
                        <?php
                        $counter++;
                      }
                      
                      ?>
                     
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <div data-api="forecast_week" class="week">
          <div class="day"><span class="name">THU</span><i class="partly_cloudy"></i><span class="temperature">30 °c</span></div>
          <div class="day"><span class="name">FRI</span><i class="partly_cloudy"></i><span class="temperature">27 °c</span></div>
          <div class="day"><span class="name">SAT</span><i class="partly_cloudy"></i><span class="temperature">26 °c</span></div>
          <div class="day"><span class="name">SUN</span><i class="partly_cloudy"></i><span class="temperature">29 °c</span></div>
          <div class="day"><span class="name">MON</span><i class="partly_cloudy"></i><span class="temperature">31 °c</span></div>
        </div> -->
      </section>
 <!-- Forecast End-->

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
            <a href="<?php echo base_url('vendor-manage-products');?>" class="small-box-footer">View More<i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="<?php echo base_url('vendor-manage-orders');?>" class="small-box-footer">View More<i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="<?php   echo base_url('vendor-manage-notifications');?>" class="small-box-footer">View More<i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="<?php echo base_url('vendor-manage-orders');?>" class="small-box-footer">View More<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

      </div>

    </section>
    <!-- /.content -->
    <?php
   $this->load->view('vendor/includes/footer');?>
