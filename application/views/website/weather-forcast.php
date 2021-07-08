<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vendor</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>dist/css/AdminLTE.min.css">
  
  
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>dist/css/croppie.css">

  <link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css"
        rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css"
        rel="stylesheet" />
  <!-- custom-->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>dist/css/custom.css">
 

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
  .content-wrapper {margin-left:0;}
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

  
  <!-- Left side column. contains the logo and sidebar -->
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
<?php

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
      

    </section>
    <!-- /.content -->
   
</div>
<!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo base_url('assets/backend/');?>bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url('assets/backend/');?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url('assets/backend/');?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url('assets/backend/');?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
            
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('assets/backend/');?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/backend/');?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="<?php echo base_url('assets/backend/');?>dist/js/pages/dashboard.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/backend/');?>dist/js/demo.js"></script>
<script src="<?php echo base_url('assets/backend/');?>dist/js/croppie.js"></script>
<script src="<?php echo base_url('assets/backend/');?>dist/js/common.js"></script>
<script src="https://cdn.ckeditor.com/4.11.4/basic/ckeditor.js"></script>
<script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"
      type="text/javascript"></script>

 
</body>
</html>
